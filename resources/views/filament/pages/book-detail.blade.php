<x-filament-panels::page>
    <div class="p-4 bg-white rounded shadow dark:bg-gray-800 dark:text-white">
        <div class="flex flex-col md:flex-row gap-8">
            <div class="w-full md:w-1/3">
                <div class="bg-gray-200 dark:bg-gray-700 rounded-lg overflow-hidden h-80">
                    @if($book->gambar)
                        <img src="{{ asset('storage/' . $book->gambar) }}" alt="{{ $book->judul }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400 dark:text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                    @endif
                </div>
                
                <div class="mt-4">
                    <button wire:click="requestLoan" class="w-full py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md transition-colors duration-200 {{ $book->status !== 'available' ? 'opacity-50 cursor-not-allowed' : '' }}">
                        {{ $book->status === 'available' ? 'Pinjam Buku' : 'Buku Tidak Tersedia' }}
                    </button>
                </div>
            </div>
            
            <div class="w-full md:w-2/3">
                <h1 class="text-2xl font-bold mb-2 dark:text-white">{{ $book->judul }}</h1>
                
                <div class="flex items-center gap-2 mb-4">
                    <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded-full">
                        {{ ucfirst($book->kategori) }}
                    </span>
                    
                    <span class="px-2 py-1 text-xs {{ $book->status === 'available' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }} rounded-full">
                        {{ $book->status === 'available' ? 'Tersedia' : 'Tidak Tersedia' }}
                    </span>
                </div>
                
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400">Penulis</h3>
                        <p class="text-gray-900 dark:text-white">{{ $book->penulis }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400">Penerbit</h3>
                        <p class="text-gray-900 dark:text-white">{{ $book->penerbit }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400">Tanggal Terbit</h3>
                        <p class="text-gray-900 dark:text-white">
                            @if(is_string($book->tanggal_terbit))
                                {{ $book->tanggal_terbit }}
                            @else
                                {{ $book->tanggal_terbit->format('d M Y') }}
                            @endif
                        </p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400">Jumlah Halaman</h3>
                        <p class="text-gray-900 dark:text-white">{{ $book->jumlah_halaman }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400">ISBN</h3>
                        <p class="text-gray-900 dark:text-white">{{ $book->isbn ?? '-' }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400">Kode Buku</h3>
                        <p class="text-gray-900 dark:text-white">{{ $book->kode_buku }}</p>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-2 dark:text-white">Deskripsi</h3>
                    <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">
                        {{ $book->deskripsi ?? 'Tidak ada deskripsi' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
