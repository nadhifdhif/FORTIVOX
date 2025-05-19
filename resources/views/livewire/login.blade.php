<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new
#[Layout('components.layouts.empty')]
#[Title('Login')]
class extends Component {

    #[Rule('required|email')]
    public string $email = '';

    #[Rule('required')]
    public string $password = '';

    public function mount()
    {
        if (auth()->check()) {
            return $this->redirectBasedOnRole();
        }
    }

    public function login()
    {
        $credentials = $this->validate();

        if (auth()->attempt($credentials)) {
            request()->session()->regenerate();
            return $this->redirectBasedOnRole();
        }

        $this->addError('email', 'The provided credentials do not match our records.');
    }

    protected function redirectBasedOnRole()
    {
        $role = auth()->user()->role;

        if ($role === 'admin') {
            return redirect('/');
        }

        if ($role === 'user') {
            return redirect('/user-dashboard');
        }

        // Role tidak dikenal → logout dan flash error
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        session()->flash('error', 'Role tidak dikenali.');

        return redirect('/login');
    }
};
?>

<div class="md:w-96 mx-auto mt-20">
    <div class="mb-10">
        <x-app-brand />
    </div>

    @if (session('error'))
        <x-alert type="error" :message="session('error')" />
    @endif

    <x-form wire:submit="login">
        <x-input placeholder="E-mail" wire:model="email" icon="o-envelope" />
        <x-input placeholder="Password" wire:model="password" type="password" icon="o-key" />

        <x-slot:actions>
            <x-button label="Create an account" class="btn-ghost" link="/register" />
            <x-button label="Login" type="submit" icon="o-paper-airplane" class="btn-primary" spinner="login" />
        </x-slot:actions>
    </x-form>
</div>
