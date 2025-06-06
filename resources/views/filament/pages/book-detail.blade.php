<x-filament-panels::page>
    <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-900 dark:text-white">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Book Image & Action -->
            <div class="w-full md:w-1/3">
                <div class="bg-gray-100 dark:bg-gray-700 rounded-xl overflow-hidden aspect-[3/4] w-100 h-46">
                    @if($book->gambar)
                        <img src="{{ asset('storage/' . $book->gambar) }}" alt="{{ $book->judul }}" class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400 dark:text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                    @endif
                </div>

                <div class="mt-5">
                    <button wire:click="requestLoan"
                        class="w-full py-2 px-4 rounded-md font-semibold text-center transition-all duration-200
                            {{ $book->status === 'available'
                                ? 'bg-primary-600 hover:bg-primary-700 text-white'
                                : 'bg-gray-300 text-gray-500 cursor-not-allowed'
                            }}">
                        {{ $book->status === 'available' ? 'Pinjam Buku' : 'Buku Tidak Tersedia' }}
                    </button>
                </div>
            </div>

            <!-- Book Info -->
            <div class="w-full md:w-2/3 space-y-6">
                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight">{{ $book->judul }}</h1>
                    <div class="flex flex-wrap items-center gap-2 mt-2">
                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                            {{ ucfirst($book->kategori) }}
                        </span>
                        <span class="px-3 py-1 text-xs font-medium rounded-full 
                            {{ $book->status === 'available' 
                                ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' 
                                : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                            {{ $book->status === 'available' ? 'Tersedia' : 'Tidak Tersedia' }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 text-sm">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 font-medium">Penulis</p>
                        <p class="text-base font-semibold">{{ $book->penulis }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 font-medium">Penerbit</p>
                        <p class="text-base font-semibold">{{ $book->penerbit }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 font-medium">Tanggal Terbit</p>
                        <p class="text-base font-semibold">
                            @if(is_string($book->tanggal_terbit))
                                {{ $book->tanggal_terbit }}
                            @else
                                {{ $book->tanggal_terbit->format('d M Y') }}
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 font-medium">Jumlah Halaman</p>
                        <p class="text-base font-semibold">{{ $book->jumlah_halaman }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 font-medium">ISBN</p>
                        <p class="text-base font-semibold">{{ $book->isbn ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 font-medium">Kode Buku</p>
                        <p class="text-base font-semibold">{{ $book->kode_buku }}</p>
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-semibold mb-2">Deskripsi</h2>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line">
                        {{ $book->deskripsi ?? 'Tidak ada deskripsi.' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>