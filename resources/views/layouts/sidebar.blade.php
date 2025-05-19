{{-- resources/views/layouts/sidebar.blade.php --}}
<aside class="w-64 bg-gray-100 p-4">
    <ul class="space-y-2">
        <li><a href="{{ route('grafik.monitoring') }}" class="text-blue-600">Grafik Monitoring</a></li>
        <li><a href="{{ route('grafik.stat') }}" class="text-blue-600">Statistik</a></li>
        <li><a href="{{ route('logout') }}" class="text-red-500">Logout</a></li>
    </ul>
</aside>
