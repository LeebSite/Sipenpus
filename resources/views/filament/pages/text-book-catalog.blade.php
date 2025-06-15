<x-filament-panels::page>
    <div class="mb-6">
        <div class="flex flex-col md:flex-row gap-4 mb-4">
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
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($textBooks as $book)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-4">
                    <h3 class="text-lg font-semibold mb-2">{{ $book->judul }}</h3>
                    <div class="text-sm text-gray-600 mb-2">
                        <p><span class="font-medium">Kode:</span> {{ $book->kode_buku }}</p>
                        <p><span class="font-medium">Penulis:</span> {{ $book->penulis }}</p>
                        <p><span class="font-medium">Mata Pelajaran:</span> {{ $book->mata_pelajaran }}</p>
                        <p><span class="font-medium">Kelas:</span> {{ $book->kelas }}</p>
                        <p><span class="font-medium">Stok:</span> {{ $book->stok }}</p>
                    </div>
                    <div class="mt-4">
                        <x-filament::button wire:click="selectBook({{ $book->id }})" size="sm">
                            Pinjam Buku
                        </x-filament::button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full p-6 text-center">
                <p class="text-gray-500">Tidak ada buku yang tersedia dengan kriteria pencarian saat ini.</p>
            </div>
        @endforelse
    </div>
</x-filament-panels::page>
