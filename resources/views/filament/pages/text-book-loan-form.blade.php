<x-filament-panels::page>
    <!-- Custom Styles -->
    <style>
        .book-preview {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .dark .book-preview {
            background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
        }
        .form-section {
            transition: all 0.3s ease;
        }
        .form-section:hover {
            transform: translateY(-1px);
        }
    </style>

    <!-- Breadcrumb Navigation -->
    <div class="mb-6">
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
                <li>
                    <div class="flex items-center">
                        <x-heroicon-o-chevron-right class="w-4 h-4 text-gray-400" />
                        <a href="{{ App\Filament\Pages\TextBookCatalog::getUrl() }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Katalog Buku Cetak</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <x-heroicon-o-chevron-right class="w-4 h-4 text-gray-400" />
                        <span class="ml-1 text-sm font-medium text-gray-900 md:ml-2 dark:text-white">Form Peminjaman</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    @if($selectedBook)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Preview Buku -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg dark:shadow-gray-900/20 overflow-hidden border border-gray-100 dark:border-gray-700 sticky top-6">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-4">
                        <h3 class="text-white font-bold text-lg">Detail Buku</h3>
                    </div>
                    
                    <!-- Gambar Buku -->
                    <div class="relative h-64 book-preview flex items-center justify-center">
                        @if($selectedBook->gambar && file_exists(public_path('storage/' . $selectedBook->gambar)))
                            <img 
                                src="{{ asset('storage/' . $selectedBook->gambar) }}" 
                                alt="Cover {{ $selectedBook->judul }}"
                                class="w-full h-full object-cover"
                            />
                        @else
                            <div class="flex flex-col items-center justify-center text-center p-4">
                                <x-heroicon-o-book-open class="w-20 h-20 text-white/80 mb-3" />
                                <span class="text-white/90 font-medium text-sm">
                                    {{ $selectedBook->judul }}
                                </span>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Informasi Buku -->
                    <div class="p-6 space-y-4">
                        <div>
                            <h4 class="font-bold text-lg text-gray-900 dark:text-white mb-2 leading-tight">
                                {{ $selectedBook->judul }}
                            </h4>
                        </div>
                        
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400">Kode Buku:</span>
                                <span class="font-mono bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded text-xs">{{ $selectedBook->kode_buku }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400">Penulis:</span>
                                <span class="text-gray-700 dark:text-gray-300 font-medium">{{ $selectedBook->penulis }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400">Mata Pelajaran:</span>
                                <span class="text-gray-700 dark:text-gray-300">{{ $selectedBook->mata_pelajaran }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400">Kelas:</span>
                                <span class="bg-blue-100 dark:bg-blue-900/40 text-blue-800 dark:text-blue-300 px-2 py-1 rounded text-xs font-medium">{{ $selectedBook->kelas }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center pt-2 border-t border-gray-100 dark:border-gray-700">
                                <span class="text-gray-500 dark:text-gray-400">Stok Tersedia:</span>
                                <span class="font-bold text-lg text-green-600 dark:text-green-400">{{ $selectedBook->stok }} unit</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Peminjaman -->
            <div class="lg:col-span-2">
                <div class="form-section bg-white dark:bg-gray-800 rounded-xl shadow-lg dark:shadow-gray-900/20 border border-gray-100 dark:border-gray-700">
                    <!-- Header Form -->
                    <div class="bg-gradient-to-r from-green-600 to-blue-600 p-6 rounded-t-xl">
                        <h3 class="text-white font-bold text-xl">Form Peminjaman Buku</h3>
                        <p class="text-green-100 text-sm mt-1">Lengkapi informasi berikut untuk mengajukan peminjaman</p>
                    </div>
                    
                    <!-- Form Content -->
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Mata Pelajaran -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Mata Pelajaran <span class="text-red-500">*</span>
                                </label>
                                <x-filament::input.wrapper>
                                    <x-filament::input 
                                        type="text" 
                                        wire:model="mata_pelajaran" 
                                        placeholder="Masukkan mata pelajaran"
                                        required
                                    />
                                </x-filament::input.wrapper>
                                @error('mata_pelajaran')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Guru Pengampu -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Guru Pengampu <span class="text-red-500">*</span>
                                </label>
                                <x-filament::input.wrapper>
                                    <x-filament::input 
                                        type="text" 
                                        wire:model="guru_pengampu" 
                                        placeholder="Masukkan nama guru pengampu"
                                        required
                                    />
                                </x-filament::input.wrapper>
                                @error('guru_pengampu')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kelas/Keperluan -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Kelas/Keperluan <span class="text-red-500">*</span>
                                </label>
                                <x-filament::input.wrapper>
                                    <x-filament::input 
                                        type="text" 
                                        wire:model="kelas_keperluan" 
                                        placeholder="Masukkan kelas atau keperluan"
                                        required
                                    />
                                </x-filament::input.wrapper>
                                @error('kelas_keperluan')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jumlah -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Jumlah Buku <span class="text-red-500">*</span>
                                </label>
                                <x-filament::input.wrapper>
                                    <x-filament::input 
                                        type="number" 
                                        wire:model="jumlah" 
                                        min="1" 
                                        max="{{ $selectedBook->stok }}"
                                        placeholder="Jumlah buku yang dipinjam"
                                        required
                                    />
                                </x-filament::input.wrapper>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Maksimal {{ $selectedBook->stok }} unit</p>
                                @error('jumlah')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tanggal Pinjam -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Tanggal Pinjam <span class="text-red-500">*</span>
                                </label>
                                <x-filament::input.wrapper>
                                    <x-filament::input 
                                        type="date" 
                                        wire:model="loan_date"
                                        required
                                    />
                                </x-filament::input.wrapper>
                                @error('loan_date')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tanggal Kembali -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Tanggal Kembali <span class="text-red-500">*</span>
                                </label>
                                <x-filament::input.wrapper>
                                    <x-filament::input 
                                        type="date" 
                                        wire:model="return_date"
                                        required
                                    />
                                </x-filament::input.wrapper>
                                @error('return_date')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Catatan -->
                        <div class="mt-6">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Catatan Tambahan
                            </label>
                            <x-filament::input.wrapper>
                                <textarea
                                    wire:model="notes"
                                    rows="4"
                                    class="fi-input block w-full border-none py-3 text-base text-gray-950 transition duration-75 placeholder:text-gray-400 focus:ring-0 dark:text-white dark:placeholder:text-gray-500 sm:text-sm bg-white dark:bg-white/5 rounded-lg shadow-sm ring-1 ring-gray-950/10 ring-inset focus:ring-2 focus:ring-primary-600 dark:ring-white/20 dark:focus:ring-primary-500"
                                    placeholder="Masukkan catatan tambahan jika diperlukan (opsional)"
                                ></textarea>
                            </x-filament::input.wrapper>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Maksimal 1000 karakter</p>
                            @error('notes')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3 mt-8 pt-6 border-t border-gray-100 dark:border-gray-700">
                            <x-filament::button 
                                wire:click="backToCatalog" 
                                color="gray" 
                                outlined
                                class="flex-1 justify-center"
                            >
                                <x-heroicon-o-arrow-left class="w-4 h-4 mr-2" />
                                Kembali ke Katalog
                            </x-filament::button>
                            
                            <x-filament::button 
                                wire:click="submitLoanRequest"
                                wire:loading.attr="disabled"
                                wire:target="submitLoanRequest"
                                class="flex-1 justify-center"
                                color="primary"
                            >
                                <span wire:loading.remove wire:target="submitLoanRequest" class="flex items-center">
                                    <x-heroicon-o-paper-airplane class="w-4 h-4 mr-2" />
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
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <x-heroicon-o-exclamation-triangle class="w-16 h-16 text-red-500 mx-auto mb-4" />
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Buku Tidak Ditemukan</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-6">Buku yang Anda pilih tidak ditemukan atau tidak tersedia.</p>
            <x-filament::button wire:click="backToCatalog" color="primary">
                <x-heroicon-o-arrow-left class="w-4 h-4 mr-2" />
                Kembali ke Katalog
            </x-filament::button>
        </div>
    @endif
</x-filament-panels::page>
