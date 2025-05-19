<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @livewireStyles
</head>
<body class="flex min-h-screen bg-gray-50">
    {{-- Sidebar admin --}}
    @include('layouts.sidebar-admin')

    <main class="flex-1">
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>
