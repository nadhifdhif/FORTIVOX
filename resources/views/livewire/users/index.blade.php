<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    }

    public function render()
    {
        return view('livewire.users.index', [
            'users' => User::orderByDesc('last_login_at')->paginate(10)
        ]);
    }
}
?>

<div class="p-4">
    <h2 class="text-2xl font-bold mb-4">Daftar Pengguna</h2>

    <div class="overflow-x-auto">
        <table class="table table-zebra w-full">
            <thead>
                <tr class="bg-base-200 text-base-content">
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Password (hash)</th>
                    <th>Terakhir Login</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name ?? '–' }}</td>
                        <td>{{ $user->email }}</td>
                        <td class="truncate max-w-xs">{{ $user->password }}</td>
                        <td>{{ $user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at)->timezone('Asia/Jakarta')->format('d M Y H:i') : 'Belum Pernah' }}</td>
                        <td>
                            <button wire:click="delete({{ $user->id }})"
                                    onclick="return confirm('Yakin ingin menghapus user ini?')"
                                    class="btn btn-error btn-xs text-white">
                                Hapus
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>