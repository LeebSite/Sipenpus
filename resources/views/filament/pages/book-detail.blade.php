<x-filament-panels::page>
    <div class="p-6 bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-xl shadow-sm">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                <i class="fas fa-search mr-3 text-blue-600"></i>Cari Buku
            </h1>
            <p class="text-gray-600 dark:text-gray-400">Temukan buku favorit Anda dari koleksi perpustakaan</p>
        </div>
        
        <!-- Search and Filter Section -->
        <div class="mb-8 bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Search Input -->
                <div class="flex-1">
                    <label for="search" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                        <i class="fas fa-book-open mr-2 text-blue-500"></i>Pencarian Buku
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input 
                            wire:model.live.debounce.300ms="search" 
                            type="text" 
                            id="search" 
                            class="pl-12 pr-4 py-3 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200" 
                            placeholder="Cari berdasarkan judul, penulis, atau ISBN..."
                        >
                    </div>
                </div>
                
                <!-- Category Filter -->
                <div class="lg:w-80">
                    <label for="kategori" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                        <i class="fas fa-filter mr-2 text-purple-500"></i>Filter Kategori
                    </label>
                    <select 
                        wire:model.live="kategori" 
                        id="kategori" 
                        class="block w-full py-3 px-4 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50 transition-all duration-200"
                    >
                        <option value="">📚 Semua Kategori</option>
                        @foreach($categories as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Books Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-6">
            @if($books->count() > 0)
                @foreach($books as $book)
                    <div class="group bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden transition-all duration-300 hover:-translate-y-2">
                        <!-- Book Cover -->
                        <div class="relative h-64 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 overflow-hidden">
                            @if($book->gambar)
                                <img 
                                    src="{{ asset('storage/' . $book->gambar) }}" 
                                    alt="{{ $book->judul }}" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                >
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <div class="text-center">
                                        <i class="fas fa-book text-4xl text-gray-400 dark:text-gray-500 mb-2"></i>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">No Cover</p>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Category Badge -->
                            <div class="absolute top-3 left-3">
                                <span class="px-2 py-1 bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm text-xs font-semibold text-gray-700 dark:text-gray-300 rounded-full border border-gray-200 dark:border-gray-600">
                                    {{ ucfirst($book->kategori) }}
                                </span>
                            </div>
                            
                            <!-- Pages Badge -->
                            <div class="absolute top-3 right-3">
                                <span class="px-2 py-1 bg-blue-500/90 backdrop-blur-sm text-xs font-semibold text-white rounded-full">
                                    {{ $book->jumlah_halaman }} hal
                                </span>
                            </div>
                        </div>
                        
                        <!-- Book Details -->
                        <div class="p-4">
                            <!-- Title -->
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 line-clamp-2 min-h-[3.5rem] leading-tight">
                                {{ $book->judul }}
                            </h3>
                            
                            <!-- Author -->
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3 flex items-center">
                                <i class="fas fa-user-edit mr-2 text-gray-400"></i>
                                <span class="truncate">{{ $book->penulis }}</span>
                            </p>
                            
                            <!-- Description -->
                            <p class="text-sm text-gray-700 dark:text-gray-300 mb-4 line-clamp-3 min-h-[4.5rem] leading-relaxed">
                                {{ $book->deskripsi ?? 'Deskripsi tidak tersedia untuk buku ini. Silakan lihat detail lengkap untuk informasi lebih lanjut.' }}
                            </p>
                            
                            <!-- Action Button -->
                            <div class="flex justify-between items-center pt-3 border-t border-gray-100 dark:border-gray-700">
                                <div class="flex items-center text-xs text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-eye mr-1"></i>
                                    <span>Detail</span>
                                </div>
                                <a 
                                    href="{{ route('book.detail', $book->id) }}" 
                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white text-sm font-semibold rounded-lg transition-all duration-200 hover:scale-105 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                                >
                                    <i class="fas fa-arrow-right mr-2"></i>
                                    Lihat
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Empty State -->
                <div class="col-span-full py-16 text-center">
                    <div class="max-w-md mx-auto">
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-search text-3xl text-gray-400 dark:text-gray-500"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Tidak ada buku ditemukan</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-6">
                            Maaf, tidak ada buku yang sesuai dengan kriteria pencarian Anda. Coba gunakan kata kunci yang berbeda.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3 justify-center">
                            <button 
                                wire:click="$set('search', '')" 
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors duration-200"
                            >
                                <i class="fas fa-refresh mr-2"></i>Reset Pencarian
                            </button>
                            <button 
                                wire:click="$set('kategori', '')" 
                                class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition-colors duration-200"
                            >
                                <i class="fas fa-filter mr-2"></i>Hapus Filter
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Pagination -->
        @if($books->count() > 0)
            <div class="mt-8 flex justify-center">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 p-4">
                    {{ $books->links() }}
                </div>
            </div>
        @endif
    </div>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .min-h-\[3\.5rem\] {
            min-height: 3.5rem;
        }
        
        .min-h-\[4\.5rem\] {
            min-height: 4.5rem;
        }
        
        /* Custom scrollbar for better aesthetics */
        ::-webkit-scrollbar {
            width: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        /* Dark mode scrollbar */
        .dark ::-webkit-scrollbar-track {
            background: #374151;
        }
        
        .dark ::-webkit-scrollbar-thumb {
            background: #6b7280;
        }
        
        .dark ::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
    </style>
</x-filament-panels::page>