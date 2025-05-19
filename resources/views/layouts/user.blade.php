{{-- resources/views/layouts/user.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900">

    <div class="min-h-screen flex">
        {{-- Sidebar --}}
        @include('layouts.sidebar-user')

        {{-- Content --}}
        <main class="flex-1 p-6">
            {{ $slot }}
        </main>
    </div>

</body>
</html>
