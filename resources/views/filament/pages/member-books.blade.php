<x-filament-panels::page>
    <div class="p-4 bg-white rounded shadow dark:bg-gray-800 dark:text-white">
        <h1 class="text-2xl font-bold mb-6 dark:text-white">Cari Buku</h1>
        
        <!-- Search and Filter -->
        <div class="mb-6 flex flex-col md:flex-row gap-4">
            <div class="w-full md:w-1/2">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input wire:model.live.debounce.300ms="search" type="text" id="search" class="pl-10 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500" placeholder="Judul, penulis, atau ISBN...">
                </div>
            </div>
            
            <div class="w-full md:w-1/2">
                <select wire:model.live="kategori" id="kategori" class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <!-- Daftar buku -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($books as $book)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden flex flex-col h-full">
                    <div class="h-48 bg-gray-200 dark:bg-gray-700 relative">
                        @if($book->gambar)
                            <img src="{{ asset('storage/' . $book->gambar) }}" alt="{{ $book->judul }}" class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center justify-center h-full bg-gray-100 dark:bg-gray-700">
                                <svg class="w-12 h-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    
                    <div class="p-4">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-1">{{ $book->judul }}</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">{{ $book->penulis }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">{{ $book->jumlah_halaman }} halaman</p>
                        
                        <p class="text-sm text-gray-700 dark:text-gray-300 mb-4 line-clamp-3">
                            {{ $book->deskripsi ?? 'Tidak ada deskripsi' }}
                        </p>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-xs px-2 py-1 bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded-full">
                                {{ ucfirst($book->kategori) }}
                            </span>
                            
                            <a href="{{ route('filament.pages.book-detail', $book) }}" class="text-sm text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 font-medium">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Tidak ada buku</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Tidak ada buku yang sesuai dengan kriteria pencarian Anda.</p>
                </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        <div class="mt-6">
            {{ $books->links() }}
        </div>
    </div>
</x-filament-panels::page>



