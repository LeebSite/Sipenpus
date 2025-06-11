<x-filament-panels::page>
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Katalog Buku Cetak</h1>
        <p class="text-gray-500">Pilih buku cetak yang ingin Anda pinjam</p>
    </div>

    <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Search -->
        <div>
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

    @if($selectedBook)
        <!-- Form Peminjaman -->
        <div class="mb-6 p-4 bg-white rounded-lg shadow">
            <div class="flex justify-between items-start mb-4">
                <h2 class="text-xl font-semibold">Form Peminjaman Buku Cetak</h2>
                <button wire:click="cancelSelection" class="text-gray-500 hover:text-red-500">
                    <x-heroicon-o-x-mark class="w-5 h-5" />
                </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <h3 class="text-lg font-medium">{{ $selectedBook->judul }}</h3>
                    <p class="text-sm text-gray-500">Kode: {{ $selectedBook->kode_buku }}</p>
                    <p class="text-sm text-gray-500">Penulis: {{ $selectedBook->penulis }}</p>
                    <p class="text-sm text-gray-500">Penerbit: {{ $selectedBook->penerbit }}</p>
                    <p class="text-sm text-gray-500">Stok Tersedia: {{ $selectedBook->stok }}</p>
                </div>
                
                <div>
                    <form wire:submit="submitLoanRequest">
                        <div class="space-y-3">
                            <x-filament::input.wrapper>
                                <x-filament::input.label for="mata_pelajaran">Mata Pelajaran</x-filament::input.label>
                                <x-filament::input type="text" id="mata_pelajaran" wire:model="mata_pelajaran" />
                                @error('mata_pelajaran') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                            </x-filament::input.wrapper>
                            
                            <x-filament::input.wrapper>
                                <x-filament::input.label for="guru_pengampu">Guru Pengampu</x-filament::input.label>
                                <x-filament::input type="text" id="guru_pengampu" wire:model="guru_pengampu" />
                                @error('guru_pengampu') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                            </x-filament::input.wrapper>
                            
                            <x-filament::input.wrapper>
                                <x-filament::input.label for="kelas_keperluan">Kelas/Keperluan</x-filament::input.label>
                                <x-filament::input type="text" id="kelas_keperluan" wire:model="kelas_keperluan" />
                                @error('kelas_keperluan') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                            </x-filament::input.wrapper>
                            
                            <x-filament::input.wrapper>
                                <x-filament::input.label for="jumlah">Jumlah</x-filament::input.label>
                                <x-filament::input type="number" id="jumlah" wire:model="jumlah" min="1" max="{{ $selectedBook->stok }}" />
                                @error('jumlah') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                            </x-filament::input.wrapper>
                            
                            <div class="grid grid-cols-2 gap-3">
                                <x-filament::input.wrapper>
                                    <x-filament::input.label for="loan_date">Tanggal Pinjam</x-filament::input.label>
                                    <x-filament::input type="date" id="loan_date" wire:model="loan_date" />
                                    @error('loan_date') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                                </x-filament::input.wrapper>
                                
                                <x-filament::input.wrapper>
                                    <x-filament::input.label for="return_date">Tanggal Kembali</x-filament::input.label>
                                    <x-filament::input type="date" id="return_date" wire:model="return_date" />
                                    @error('return_date') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                                </x-filament::input.wrapper>
                            </div>
                            
                            <x-filament::input.wrapper>
                                <x-filament::input.label for="notes">Catatan</x-filament::input.label>
                                <x-filament::input.textarea id="notes" wire:model="notes" />
                            </x-filament::input.wrapper>
                            
                            <div class="flex justify-end">
                                <x-filament::button type="submit">
                                    Ajukan Peminjaman
                                </x-filament::button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Daftar Buku -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($textBooks as $book)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-4">
                    <div class="flex justify-between">
                        <h3 class="text-lg font-medium truncate">{{ $book->judul }}</h3>
                        <span class="text-sm bg-green-100 text-green-800 px-2 py-1 rounded">Stok: {{ $book->stok }}</span>
                    </div>
                    <p class="text-sm text-gray-500">Kode: {{ $book->kode_buku }}</p>
                    <p class="text-sm text-gray-500">Mata Pelajaran: {{ $book->mata_pelajaran }}</p>
                    <p class="text-sm text-gray-500">Kelas: {{ $book->kelas }}</p>
                    <p class="text-sm text-gray-500">Penulis: {{ $book->penulis }}</p>
                    
                    <div class="mt-4">
                        <x-filament::button wire:click="selectBook({{ $book->id }})" size="sm">
                            Pinjam Buku
                        </x-filament::button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 p-6 text-center">
                <p class="text-gray-500">Tidak ada buku cetak yang tersedia dengan kriteria pencarian tersebut.</p>
            </div>
        @endforelse
    </div>
</x-filament-panels::page>