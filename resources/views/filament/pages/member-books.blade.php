<x-filament-panels::page>
    <div class="p-4 bg-white rounded shadow dark:bg-gray-800 dark:text-white">
        <h1 class="text-2xl font-bold mb-6 dark:text-white">Browse Books</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($books as $book)
                <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:shadow-lg hover:scale-105">
                    <div class="h-48 overflow-hidden bg-gray-200 dark:bg-gray-600">
                        @if($book->gambar)
                            <img src="{{ asset('storage/' . $book->gambar) }}" alt="{{ $book->judul }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400 dark:text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                            
                            <a href="{{ route('book.detail', $book->id) }}" class="px-3 py-1 bg-primary-600 hover:bg-primary-700 text-white text-sm rounded-md transition-colors duration-200">
                                Lihat Lengkap
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-6">
            {{ $books->links() }}
        </div>
    </div>
</x-filament-panels::page>