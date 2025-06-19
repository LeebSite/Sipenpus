<x-filament-panels::page>
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
        <div class="mb-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <x-heroicon-o-information-circle class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                    <span class="text-sm font-medium text-blue-800 dark:text-blue-200">
                        Menampilkan {{ $textBooks->count() }} buku
                        @if($search || $selectedSubject || $selectedClass)
                            dari hasil pencarian/filter
                        @endif
                    </span>
                </div>
                @if($search || $selectedSubject || $selectedClass)
                    <button
                        wire:click="clearFilters"
                        class="text-xs text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200 underline"
                    >
                        Hapus Filter
                    </button>
                @endif
            </div>
        </div>
    </div>

    @if($selectedBook)
        <!-- Form Peminjaman -->
        <div class="mb-6 p-4 bg-white dark:bg-gray-800 rounded-lg shadow dark:shadow-gray-900/20">
            <div class="flex justify-between items-start mb-4">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Form Peminjaman Buku Cetak</h2>
                <button wire:click="cancelSelection" class="text-gray-500 hover:text-red-500 dark:text-gray-400 dark:hover:text-red-400">
                    <x-heroicon-o-x-mark class="w-5 h-5" />
                </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                        <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                            Judul Buku
                        </span>
                    </label>
                    <x-filament::input.wrapper>
                        <x-filament::input type="text" value="{{ $selectedBook->judul }}" disabled />
                    </x-filament::input.wrapper>
                </div>

                <div>
                    <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                        <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                            Mata Pelajaran
                        </span>
                    </label>
                    <x-filament::input.wrapper>
                        <x-filament::input type="text" wire:model="mata_pelajaran" />
                    </x-filament::input.wrapper>
                </div>

                <div>
                    <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                        <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                            Guru Pengampu
                        </span>
                    </label>
                    <x-filament::input.wrapper>
                        <x-filament::input type="text" wire:model="guru_pengampu" />
                    </x-filament::input.wrapper>
                </div>

                <div>
                    <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                        <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                            Kelas/Keperluan
                        </span>
                    </label>
                    <x-filament::input.wrapper>
                        <x-filament::input type="text" wire:model="kelas_keperluan" />
                    </x-filament::input.wrapper>
                </div>

                <div>
                    <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                        <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                            Jumlah (Stok: {{ $selectedBook->stok }})
                        </span>
                    </label>
                    <x-filament::input.wrapper>
                        <x-filament::input type="number" wire:model="jumlah" min="1" max="{{ $selectedBook->stok }}" />
                    </x-filament::input.wrapper>
                </div>

                <div>
                    <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                        <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                            Tanggal Pinjam
                        </span>
                    </label>
                    <x-filament::input.wrapper>
                        <x-filament::input type="date" wire:model="loan_date" />
                    </x-filament::input.wrapper>
                </div>

                <div>
                    <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                        <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                            Tanggal Kembali
                        </span>
                    </label>
                    <x-filament::input.wrapper>
                        <x-filament::input type="date" wire:model="return_date" />
                    </x-filament::input.wrapper>
                </div>

                <div class="md:col-span-2">
                    <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                        <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                            Catatan
                        </span>
                    </label>
                    <x-filament::input.wrapper>
                        <textarea
                            wire:model="notes"
                            rows="3"
                            class="fi-input block w-full border-none py-1.5 text-base text-gray-950 transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)] sm:text-sm sm:leading-6 bg-white dark:bg-white/5 [&:not(:has(+ .fi-input-wrp-hint))]:rounded-lg [&:not(:has(+ .fi-input-wrp-hint))]:shadow-sm [&:not(:has(+ .fi-input-wrp-hint))]:ring-1 [&:not(:has(+ .fi-input-wrp-hint))]:ring-gray-950/10 [&:not(:has(+ .fi-input-wrp-hint))]:ring-inset focus:[&:not(:has(+ .fi-input-wrp-hint))]:ring-2 focus:[&:not(:has(+ .fi-input-wrp-hint))]:ring-primary-600 disabled:[&:not(:has(+ .fi-input-wrp-hint))]:bg-gray-50 disabled:[&:not(:has(+ .fi-input-wrp-hint))]:dark:bg-transparent [&:has(+ .fi-input-wrp-hint)]:rounded-t-lg [&:has(+ .fi-input-wrp-hint)]:shadow-sm [&:has(+ .fi-input-wrp-hint)]:ring-1 [&:has(+ .fi-input-wrp-hint)]:ring-gray-950/10 [&:has(+ .fi-input-wrp-hint)]:ring-inset focus:[&:has(+ .fi-input-wrp-hint)]:ring-2 focus:[&:has(+ .fi-input-wrp-hint)]:ring-primary-600 disabled:[&:has(+ .fi-input-wrp-hint)]:bg-gray-50 disabled:[&:has(+ .fi-input-wrp-hint)]:dark:bg-transparent dark:[&:not(:has(+ .fi-input-wrp-hint))]:ring-white/20 dark:focus:[&:not(:has(+ .fi-input-wrp-hint))]:ring-primary-500 dark:disabled:[&:not(:has(+ .fi-input-wrp-hint))]:ring-white/10 dark:[&:has(+ .fi-input-wrp-hint)]:ring-white/20 dark:focus:[&:has(+ .fi-input-wrp-hint)]:ring-primary-500 dark:disabled:[&:has(+ .fi-input-wrp-hint)]:ring-white/10"
                            placeholder="Masukkan catatan tambahan (opsional)"
                        ></textarea>
                    </x-filament::input.wrapper>
                </div>
            </div>
            
            <div class="mt-4 flex justify-end space-x-2">
                <x-filament::button
                    wire:click="cancelSelection"
                    color="gray"
                    outlined
                >
                    Batal
                </x-filament::button>
                <x-filament::button
                    wire:click="submitLoanRequest"
                    wire:loading.attr="disabled"
                    wire:target="submitLoanRequest"
                >
                    <span wire:loading.remove wire:target="submitLoanRequest">
                        Ajukan Peminjaman
                    </span>
                    <span wire:loading wire:target="submitLoanRequest" class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Memproses...
                    </span>
                </x-filament::button>
            </div>
        </div>
    @endif

    <!-- Daftar Buku -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($textBooks as $book)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow dark:shadow-gray-900/20 overflow-hidden transition-colors duration-200">
                <div class="p-4">
                    <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">{{ $book->judul }}</h3>
                    <div class="text-sm text-gray-600 dark:text-gray-300 mb-2 space-y-1">
                        <p><span class="font-medium text-gray-700 dark:text-gray-200">Kode:</span> {{ $book->kode_buku }}</p>
                        <p><span class="font-medium text-gray-700 dark:text-gray-200">Penulis:</span> {{ $book->penulis }}</p>
                        <p><span class="font-medium text-gray-700 dark:text-gray-200">Mata Pelajaran:</span> {{ $book->mata_pelajaran }}</p>
                        <p><span class="font-medium text-gray-700 dark:text-gray-200">Kelas:</span> {{ $book->kelas }}</p>
                        <p><span class="font-medium text-gray-700 dark:text-gray-200">Stok:</span>
                            <span class="@if($book->stok > 0) text-green-600 dark:text-green-400 @else text-red-600 dark:text-red-400 @endif">
                                {{ $book->stok }}
                            </span>
                        </p>
                    </div>
                    <div class="mt-4">
                        @if($book->stok > 0)
                            <x-filament::button wire:click="selectBook({{ $book->id }})" size="sm">
                                Pinjam Buku
                            </x-filament::button>
                        @else
                            <x-filament::button disabled size="sm" color="gray">
                                Stok Habis
                            </x-filament::button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full p-6 text-center">
                <div class="flex flex-col items-center justify-center space-y-2">
                    <x-heroicon-o-book-open class="w-12 h-12 text-gray-400 dark:text-gray-500" />
                    <p class="text-gray-500 dark:text-gray-400">Tidak ada buku yang tersedia dengan kriteria pencarian saat ini.</p>
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
