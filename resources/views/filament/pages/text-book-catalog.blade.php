<x-filament-panels::page>
    <!-- Custom Styles -->
    <style>
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .book-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }
        .book-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .dark .book-card:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.4), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
        }
        .book-image-placeholder {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
        }
        .dark .book-image-placeholder {
            background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
        }
        .book-image-placeholder::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
            transform: translateX(-100%);
            transition: transform 0.6s;
        }
        .book-card:hover .book-image-placeholder::before {
            transform: translateX(100%);
        }
        .status-badge {
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }
        .info-grid {
            display: grid;
            gap: 0.5rem;
        }
        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
        }
        .info-label {
            min-width: 4rem;
            flex-shrink: 0;
        }
        @media (max-width: 640px) {
            .book-card {
                margin-bottom: 1rem;
            }
        }
    </style>

    <!-- Breadcrumb Navigation -->
    <div class="mb-4">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('filament.admin.pages.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <x-heroicon-o-home class="w-4 h-4 mr-2" />
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <x-heroicon-o-chevron-right class="w-4 h-4 text-gray-400" />
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Perpustakaan</span>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <x-heroicon-o-chevron-right class="w-4 h-4 text-gray-400" />
                        <span class="ml-1 text-sm font-medium text-gray-900 md:ml-2 dark:text-white">Katalog Buku Cetak</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <div class="mb-6">
        <div class="flex flex-col md:flex-row gap-4 mb-4">
            <!-- Kolom Pencarian -->
            <div class="flex-1 relative">
                <x-filament::input.wrapper>
                    <x-filament::input
                        type="search"
                        wire:model.live.debounce.500ms="search"
                        placeholder="Cari judul, penulis, atau kode buku..."
                        aria-label="Pencarian buku"
                    />
                </x-filament::input.wrapper>
                <div wire:loading wire:target="search" class="absolute right-3 top-1/2 transform -translate-y-1/2">
                    <svg class="animate-spin h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </div>

            <!-- Filter Mata Pelajaran -->
            <div class="relative">
                <x-filament::input.wrapper>
                    <x-filament::input.select
                        wire:model.live="selectedSubject"
                        aria-label="Filter mata pelajaran"
                    >
                        <option value="">Semua Mata Pelajaran</option>
                        @foreach($this->subjects as $subject)
                            <option value="{{ $subject }}">{{ $subject }}</option>
                        @endforeach
                    </x-filament::input.select>
                </x-filament::input.wrapper>
                <div wire:loading wire:target="selectedSubject" class="absolute right-8 top-1/2 transform -translate-y-1/2">
                    <svg class="animate-spin h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </div>

            <!-- Filter Kelas -->
            <div class="relative">
                <x-filament::input.wrapper>
                    <x-filament::input.select
                        wire:model.live="selectedClass"
                        aria-label="Filter kelas"
                    >
                        <option value="">Semua Kelas</option>
                        @foreach($this->classes as $class)
                            <option value="{{ $class }}">{{ $class }}</option>
                        @endforeach
                    </x-filament::input.select>
                </x-filament::input.wrapper>
                <div wire:loading wire:target="selectedClass" class="absolute right-8 top-1/2 transform -translate-y-1/2">
                    <svg class="animate-spin h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Loading overlay untuk daftar buku -->
        <div wire:loading.delay wire:target="search,selectedSubject,selectedClass" class="relative">
            <div class="absolute inset-0 bg-white/50 dark:bg-gray-900/50 backdrop-blur-sm z-10 rounded-lg flex items-center justify-center">
                <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-300">
                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Memuat data...</span>
                </div>
            </div>
        </div>

        <!-- Statistik Buku -->
        <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl border border-blue-200 dark:border-blue-800">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <x-heroicon-o-information-circle class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                    </div>
                    <div>
                        <span class="text-sm font-semibold text-blue-800 dark:text-blue-200">
                            Menampilkan {{ $textBooks->count() }} buku
                        </span>
                        @if($search || $selectedSubject || $selectedClass)
                            <span class="block text-xs text-blue-600 dark:text-blue-300 mt-1">
                                dari hasil pencarian/filter
                            </span>
                        @endif
                    </div>
                </div>
                @if($search || $selectedSubject || $selectedClass)
                    <x-filament::button
                        wire:click="clearFilters"
                        color="gray"
                        outlined
                        size="xs">
                        <x-heroicon-o-arrow-path class="w-3 h-3 mr-1" />
                        Reset Filter
                    </x-filament::button>
                @endif
            </div>
        </div>
    </div>
    <!-- Daftar Buku -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($textBooks as $book)
            <div class="book-card bg-white dark:bg-gray-800 rounded-xl shadow-md dark:shadow-gray-900/20 overflow-hidden border border-gray-100 dark:border-gray-700 flex flex-col">
                <!-- Gambar Buku dengan Ukuran Konsisten -->
                <div class="relative h-48 book-image-placeholder bg-gray-50 dark:bg-gray-700 flex items-center justify-center overflow-hidden flex-shrink-0">
                    @if($book->gambar && file_exists(public_path('storage/' . $book->gambar)))
                        <img
                            src="{{ asset('storage/' . $book->gambar) }}"
                            alt="Cover {{ $book->judul }}"
                            class="w-full h-full object-cover transition-transform duration-300 hover:scale-105"
                            loading="lazy"
                        />
                    @else
                        <!-- Default Book Cover -->
                        <div class="flex flex-col items-center justify-center text-center p-4">
                            <x-heroicon-o-book-open class="w-16 h-16 text-blue-400 dark:text-blue-300 mb-2" />
                            <span class="text-xs font-medium text-blue-600 dark:text-blue-300 line-clamp-2">
                                {{ Str::limit($book->judul, 30) }}
                            </span>
                        </div>
                    @endif

                    <!-- Status Badge -->
                    <div class="absolute top-3 right-3">
                        @if($book->stok > 0)
                            <span class="status-badge inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100/90 text-green-800 dark:bg-green-900/50 dark:text-green-300 border border-green-200 dark:border-green-700">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5 animate-pulse"></span>
                                Tersedia
                            </span>
                        @else
                            <span class="status-badge inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100/90 text-red-800 dark:bg-red-900/50 dark:text-red-300 border border-red-200 dark:border-red-700">
                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></span>
                                Habis
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Konten Buku -->
                <div class="p-4 flex flex-col flex-grow">
                    <!-- Judul Buku -->
                    <h3 class="text-base font-bold mb-3 text-gray-900 dark:text-white line-clamp-2 leading-snug">
                        {{ $book->judul }}
                    </h3>

                    <!-- Informasi Buku -->
                    <div class="space-y-2 text-sm mb-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500 dark:text-gray-400 text-xs">Kode:</span>
                            <span class="text-gray-700 dark:text-gray-300 font-mono text-xs bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded">
                                {{ $book->kode_buku }}
                            </span>
                        </div>

                        <div class="flex items-start justify-between">
                            <span class="text-gray-500 dark:text-gray-400 text-xs">Penulis:</span>
                            <span class="text-gray-700 dark:text-gray-300 text-xs font-medium text-right line-clamp-1 max-w-[60%]">{{ $book->penulis }}</span>
                        </div>

                        <div class="flex items-start justify-between">
                            <span class="text-gray-500 dark:text-gray-400 text-xs">Mapel:</span>
                            <span class="text-gray-700 dark:text-gray-300 text-xs text-right line-clamp-1 max-w-[60%]">{{ $book->mata_pelajaran }}</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-gray-500 dark:text-gray-400 text-xs">Kelas:</span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300">
                                {{ $book->kelas }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between pt-2 mt-2 border-t border-gray-100 dark:border-gray-700">
                            <span class="font-medium text-gray-600 dark:text-gray-400 text-xs">Stok:</span>
                            <div class="flex items-center space-x-1">
                                <span class="font-bold text-lg @if($book->stok > 0) text-green-600 dark:text-green-400 @else text-red-600 dark:text-red-400 @endif">
                                    {{ $book->stok }}
                                </span>
                                @if($book->stok > 0)
                                    <span class="text-xs text-green-600 dark:text-green-400">unit</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="mt-3 pt-2">
                        @if($book->stok > 0)
                            <x-filament::button
                                wire:click="goToLoanForm({{ $book->id }})"
                                wire:loading.attr="disabled"
                                wire:target="goToLoanForm({{ $book->id }})"
                                size="sm"
                                class="w-full justify-center"
                                color="primary"
                            >
                                <span wire:loading.remove wire:target="goToLoanForm({{ $book->id }})" class="flex items-center">
                                    <x-heroicon-o-plus class="w-4 h-4 mr-1.5" />
                                    Pinjam Buku
                                </span>
                                <span wire:loading wire:target="goToLoanForm({{ $book->id }})" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Memuat...
                                </span>
                            </x-filament::button>
                        @else
                            <x-filament::button
                                disabled
                                size="sm"
                                color="gray"
                                class="w-full justify-center"
                            >
                                <x-heroicon-o-x-mark class="w-4 h-4 mr-1.5" />
                                Stok Habis
                            </x-filament::button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full p-12 text-center">
                <div class="flex flex-col items-center justify-center space-y-4">
                    <div class="w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center">
                        <x-heroicon-o-book-open class="w-12 h-12 text-gray-400 dark:text-gray-500" />
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tidak Ada Buku Ditemukan</h3>
                        <p class="text-gray-500 dark:text-gray-400 max-w-md">
                            Tidak ada buku yang tersedia dengan kriteria pencarian saat ini.
                            Coba ubah filter atau kata kunci pencarian Anda.
                        </p>
                    </div>
                    @if($search || $selectedSubject || $selectedClass)
                        <x-filament::button
                            wire:click="clearFilters"
                            color="gray"
                            outlined
                            size="sm"
                        >
                            <x-heroicon-o-arrow-path class="w-4 h-4 mr-1" />
                            Reset Filter
                        </x-filament::button>
                    @endif
                </div>
            </div>
        @endforelse
    </div>

    <!-- Load More Button -->
    @if($this->hasMoreBooks())
        <div class="mt-8 text-center">
            <x-filament::button
                wire:click="loadMore"
                wire:loading.attr="disabled"
                wire:target="loadMore"
                color="gray"
                outlined
            >
                <span wire:loading.remove wire:target="loadMore">
                    Muat Lebih Banyak
                </span>
                <span wire:loading wire:target="loadMore" class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Memuat...
                </span>
            </x-filament::button>
        </div>
    @endif
</x-filament-panels::page>
