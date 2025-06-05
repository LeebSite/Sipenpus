<x-filament-panels::page>
    <div class="p-4 bg-white rounded shadow dark:bg-gray-800 dark:text-white">
        <h1 class="text-2xl font-bold mb-4 dark:text-white">Member Dashboard</h1>
        <p class="dark:text-gray-300">Selamat datang, {{ auth()->user()->name }}!</p>
    </div>
</x-filament-panels::page>
