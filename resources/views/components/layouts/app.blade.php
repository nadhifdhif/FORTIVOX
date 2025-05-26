<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title.' - '.config('app.name') : config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/6.6.6/css/flag-icons.min.css" />
</head>
<body class="min-h-screen font-sans antialiased bg-base-200">

    <!-- TESTING TOKEN -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    {{-- NAVBAR mobile only --}}
    <x-nav sticky class="lg:hidden">
        <x-slot:brand>
            <x-app-brand />
        </x-slot:brand>
        <x-slot:actions>
            <label for="main-drawer" class="lg:hidden me-3">
                <x-icon name="o-bars-3" class="cursor-pointer" />
            </label>
        </x-slot:actions>
    </x-nav>

    {{-- MAIN --}}
    <x-main>
        {{-- SIDEBAR --}}
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-inherit">

            {{-- BRAND --}}
            <x-app-brand class="px-5 pt-4" />

            {{-- MENU --}}
            <x-menu activate-by-route>
                @if($user = auth()->user())
                    <x-menu-separator />

                    <x-list-item :item="$user" value="name" sub-value="email" no-separator no-hover class="-mx-2 !-my-2 rounded">
                        <x-slot:actions>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-ghost btn-xs" title="{{ __('messages.logout') }}">
                                    <x-icon name="o-power" />
                                </button>
                            </form>
                        </x-slot:actions>
                    </x-list-item>

                    <x-menu-separator />

                    {{-- MENU ADMIN --}}
                    @if($user->role === 'admin')
                        <x-menu-item :title="__('messages.homepage')" icon="o-rectangle-stack" link="/" />
                        <x-menu-item :title="__('messages.realtime_monitoring')" icon="o-command-line" link="/sensor" />
                        <x-menu-sub :title="__('messages.graph')" icon="o-clipboard-document-list">
                            <x-menu-item :title="__('messages.temperature_humidity')" icon="o-presentation-chart-line" link="/grafik-monitoring" />
                            <x-menu-item :title="__('messages.statistics')" icon="o-presentation-chart-bar" link="/grafik/stat" />
                        </x-menu-sub>
                        <x-menu-sub :title="__('messages.settings')" icon="o-wrench-screwdriver">
                            <x-menu-item :title="__('messages.theme')" icon="o-moon" link="####" />
                            <x-menu-item :title="__('messages.language')" icon="o-language" link="{{ route('language.settings') }}" />
                        </x-menu-sub>
                        <x-menu-item :title="__('messages.users')" icon="o-user-group" link="/users" />

                    {{-- MENU USER --}}
                    @elseif($user->role === 'user')
                        <x-menu-item :title="__('messages.homepage')" icon="o-home" link="/user-dashboard" />
                        <x-menu-item :title="__('messages.realtime_monitoring')" icon="o-document" link="/sensor" />
                        <x-menu-sub :title="__('messages.graph')" icon="o-arrow-trending-up">
                            <x-menu-item :title="__('messages.temperature_humidity')" icon="o-archive-box" link="/grafik-monitoring" />
                            <x-menu-item :title="__('messages.statistics')" icon="o-document" link="/grafik/stat" />
                        </x-menu-sub>
                        <x-menu-sub :title="__('messages.settings')" icon="o-cog-6-tooth">
                            <x-menu-item :title="__('messages.theme')" icon="o-cog-6-tooth" link="####" />
                            <x-menu-item :title="__('messages.language')" icon="o-document" link="{{ route('language.settings') }}" />
                        </x-menu-sub>
                    @endif
                @endif
            </x-menu>
        </x-slot:sidebar>

        {{-- The `$slot` goes here --}}
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-main>

    {{-- TOAST area --}}
    <x-toast />
</body>
</html>
