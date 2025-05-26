<?php

use Livewire\Volt\Component;

new class extends Component {
    public function layout(): string
    {
        return 'layouts.admin';
    }
};
?>

<div class="p-6">
    <h2 class="text-2xl font-bold mb-6">{{ __('messages.language') }}</h2>

    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-4 gap-4">
        @php
            $languages = [
                ['code' => 'id', 'flag' => 'id', 'label' => 'Indonesia'],
                ['code' => 'ms', 'flag' => 'my', 'label' => 'Melayu'],
                ['code' => 'ar', 'flag' => 'sa', 'label' => 'العربية'],
                ['code' => 'en', 'flag' => 'gb', 'label' => 'English'],
                ['code' => 'fr', 'flag' => 'fr', 'label' => 'Français'],
                ['code' => 'es', 'flag' => 'es', 'label' => 'Español'],
                ['code' => 'pt', 'flag' => 'pt', 'label' => 'Português'],
                ['code' => 'it', 'flag' => 'it', 'label' => 'Italiano'],
                ['code' => 'de', 'flag' => 'de', 'label' => 'Deutsch'],
                ['code' => 'nl', 'flag' => 'nl', 'label' => 'Nederlands'],
                ['code' => 'ru', 'flag' => 'ru', 'label' => 'Русский'],
                ['code' => 'zh', 'flag' => 'cn', 'label' => '中文'],
                ['code' => 'ja', 'flag' => 'jp', 'label' => '日本語'],
                ['code' => 'ko', 'flag' => 'kr', 'label' => '한국어'],
            ];
        @endphp

        @foreach ($languages as $lang)
            <a
                href="{{ route('lang.switch', $lang['code']) }}"
                class="border rounded-xl p-4 text-center hover:bg-blue-100 transition duration-200 flex items-center justify-center gap-2
                    {{ app()->getLocale() === $lang['code'] ? 'border-blue-600 font-bold bg-blue-50' : 'border-gray-300' }}"
            >
                <span class="fi fi-{{ $lang['flag'] }}"></span>
                {{ $lang['label'] }}
            </a>
        @endforeach
    </div>
</div>
