<x-filament-panels::page>
    <!-- Header Section -->
    <div class="mb-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Katalog Buku Cetak</h1>
            <p class="text-gray-600 dark:text-gray-400">Temukan dan pinjam buku cetak yang Anda butuhkan untuk pembelajaran</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex flex-col md:flex-row gap-4">
            <!-- Kolom Pencarian -->
            <div class="flex-1">
                <x-filament::input.wrapper>
                    <x-filament::input
                        type="search"
                        wire:model.live.debounce.500ms="search"
                        placeholder="Cari judul, penulis, atau kode buku..."
                    />
                </x-filament::input.wrapper>
            </div>

            <!-- Filter Mata Pelajaran -->
            <div>
                <x-filament::input.wrapper>
                    <x-filament::input.select wire:model.live="selectedSubject">
                        <option value="">Semua Mata Pelajaran</option>
                        @foreach($this->subjects as $subject)
                            <option value="{{ $subject }}">{{ $subject }}</option>
                        @endforeach
                    </x-filament::input.select>
                </x-filament::input.wrapper>
            </div>

            <!-- Filter Kelas -->
            <div>
                <x-filament::input.wrapper>
                    <x-filament::input.select wire:model.live="selectedClass">
                        <option value="">Semua Kelas</option>
                        @foreach($this->classes as $class)
                            <option value="{{ $class }}">{{ $class }}</option>
                        @endforeach
                    </x-filament::input.select>
                </x-filament::input.wrapper>
            </div>
        </div>
    </div>

    @if($selectedBook)
        <!-- Form Peminjaman -->
        <div class="mb-6 p-4 bg-white rounded-lg shadow">
            <div class="flex justify-between items-start mb-4">
                <h2 class="text-xl font-semibold">Form Peminjaman Buku Cetak</h2>
                <button wire:click="cancelSelection" class="text-gray-500 hover:text-red-500">
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
            
            <div class="mt-4 flex justify-end">
                <x-filament::button wire:click="submitLoanRequest">
                    Ajukan Peminjaman
                </x-filament::button>
            </div>
        </div>
    @endif

    <!-- Daftar Buku -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($textBooks as $book)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:scale-105 border border-gray-100 dark:border-gray-700">
                <!-- Gambar Buku -->
                <div class="relative h-56
                    @if(str_contains(strtolower($book->mata_pelajaran), 'matematika')) bg-gradient-to-br from-blue-400 to-blue-600
                    @elseif(str_contains(strtolower($book->mata_pelajaran), 'fisika')) bg-gradient-to-br from-green-400 to-green-600
                    @elseif(str_contains(strtolower($book->mata_pelajaran), 'kimia')) bg-gradient-to-br from-purple-400 to-purple-600
                    @elseif(str_contains(strtolower($book->mata_pelajaran), 'biologi')) bg-gradient-to-br from-teal-400 to-teal-600
                    @elseif(str_contains(strtolower($book->mata_pelajaran), 'bahasa')) bg-gradient-to-br from-red-400 to-red-600
                    @elseif(str_contains(strtolower($book->mata_pelajaran), 'sejarah')) bg-gradient-to-br from-yellow-400 to-orange-500
                    @else bg-gradient-to-br from-gray-400 to-gray-600
                    @endif">
                    @if($book->gambar)
                        <img
                            src="{{ asset('storage/' . $book->gambar) }}"
                            alt="{{ $book->judul }}"
                            class="w-full h-full object-cover"
                            loading="lazy"
                        >
                    @else
                        <div class="flex items-center justify-center h-full p-6">
                            <div class="text-center text-white">
                                @if(str_contains(strtolower($book->mata_pelajaran), 'matematika'))
                                    <div class="text-4xl font-bold mb-2">∑ π ∞</div>
                                    <div class="text-lg mb-1">x² + y² = r²</div>
                                @elseif(str_contains(strtolower($book->mata_pelajaran), 'fisika'))
                                    <div class="text-4xl font-bold mb-2">⚛️</div>
                                    <div class="text-lg mb-1">F = ma</div>
                                    <div class="text-sm">E = mc²</div>
                                @elseif(str_contains(strtolower($book->mata_pelajaran), 'kimia'))
                                    <div class="text-4xl font-bold mb-2">🧪</div>
                                    <div class="text-lg mb-1">H₂O</div>
                                    <div class="text-sm">NaCl</div>
                                @elseif(str_contains(strtolower($book->mata_pelajaran), 'biologi'))
                                    <div class="text-4xl font-bold mb-2">🧬</div>
                                    <div class="text-lg mb-1">DNA</div>
                                    <div class="text-sm">Sel</div>
                                @elseif(str_contains(strtolower($book->mata_pelajaran), 'bahasa'))
                                    <div class="text-4xl font-bold mb-2">📚</div>
                                    <div class="text-lg mb-1">Bahasa</div>
                                    <div class="text-sm">Sastra</div>
                                @elseif(str_contains(strtolower($book->mata_pelajaran), 'sejarah'))
                                    <div class="text-4xl font-bold mb-2">🏛️</div>
                                    <div class="text-lg mb-1">Sejarah</div>
                                    <div class="text-sm">Peradaban</div>
                                @else
                                    <svg class="w-16 h-16 mx-auto mb-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    <div class="text-sm">Buku Cetak</div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Badge Stok -->
                    <div class="absolute top-4 right-3">
                        @if($book->stok > 0)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                Stok: {{ $book->stok }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                Habis
                            </span>
                        @endif
                    </div>

                    <!-- Badge Mata Pelajaran -->
                    <div class="absolute top-3 left-3">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                            {{ $book->mata_pelajaran }}
                        </span>
                    </div>
                </div>

                <!-- Konten Buku -->
                <div class="p-6">
                    <div class="mb-4">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 line-clamp-2 leading-tight">
                            {{ $book->judul }}
                        </h3>
                        <p class="text-base text-gray-600 dark:text-gray-400 font-medium">
                            {{ $book->penulis }}
                        </p>
                    </div>

                    <div class="space-y-3 mb-6">
                        <div class="flex items-center text-sm text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            <span class="font-semibold text-gray-800 dark:text-gray-200">Kode:</span>
                            <span class="ml-2 font-mono text-blue-600 dark:text-blue-400">{{ $book->kode_buku }}</span>
                        </div>

                        <div class="flex items-center text-sm text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span class="font-semibold text-gray-800 dark:text-gray-200">Kelas:</span>
                            <span class="ml-2 px-2 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-full text-xs font-bold">{{ $book->kelas }}</span>
                        </div>

                        <div class="flex items-center text-sm text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 mr-3 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="font-semibold text-gray-800 dark:text-gray-200">Tahun:</span>
                            <span class="ml-2 text-purple-600 dark:text-purple-400 font-bold">{{ $book->tahun_terbit }}</span>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="pt-4 border-t border-gray-100 dark:border-gray-600">
                        @if($book->stok > 0)
                            <x-filament::button
                                wire:click="selectBook({{ $book->id }})"
                                size="md"
                                class="w-full justify-center"
                                color="primary"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Pinjam Buku
                            </x-filament::button>
                        @else
                            <button
                                disabled
                                class="w-full px-6 py-3 text-base font-semibold text-gray-400 bg-gray-100 dark:bg-gray-700 dark:text-gray-500 rounded-lg cursor-not-allowed flex items-center justify-center"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                                </svg>
                                Stok Habis
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Tidak ada buku ditemukan</h3>
                    <p class="text-gray-500 dark:text-gray-400">Tidak ada buku yang tersedia dengan kriteria pencarian saat ini.</p>
                </div>
            </div>
        @endforelse
    </div>
</x-filament-panels::page>
