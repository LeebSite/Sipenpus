<x-filament-panels::page>
    <div class="p-6 bg-white rounded-xl shadow-sm dark:bg-gray-800">
        <div class="bg-white dark:bg-gray-700 rounded-xl shadow-md overflow-hidden border border-gray-100 dark:border-gray-600">
            <div class="md:flex">
                <!-- Book Cover Section -->
                <div class="md:w-1/3 p-6 flex flex-col">
                    <div class="bg-gray-50 dark:bg-gray-600 rounded-xl overflow-hidden h-80 flex items-center justify-center shadow-inner">
                        @if($book->gambar)
                            <img 
                                src="{{ asset('storage/' . $book->gambar) }}" 
                                alt="{{ $book->judul }}" 
                                class="w-full h-full object-contain"
                                loading="lazy"
                            >
                        @else
                            <div class="text-center p-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-300 dark:text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <p class="text-gray-400 dark:text-gray-500">Gambar tidak tersedia</p>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Book Details Section -->
                <div class="md:w-2/3 p-6 border-t md:border-t-0 md:border-l border-gray-100 dark:border-gray-600">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">{{ $book->judul }}</h2>
                    <div class="space-y-4">
                        <!-- Status Badge -->
                        <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400 w-32">Status:</span>
                            @if($hasPendingLoan)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200 border border-purple-200 dark:border-purple-800">
                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 2a8 8 0 100 16 8 8 0 000-16zm0 14a6 6 0 110-12 6 6 0 010 12zm1-6a1 1 0 11-2 0V7a1 1 0 112 0v3z"/>
                                    </svg>
                                    Menunggu Persetujuan
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $book->status === 'available' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200 border border-purple-200 dark:border-purple-800' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 border border-red-200 dark:border-red-800' }}">
                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $book->status === 'available' ? 'Tersedia' : 'Tidak Tersedia' }}
                                </span>
                            @endif
                        </div>

                        <!-- Book Info -->
                        @foreach([
                            'Penulis' => $book->penulis,
                            'Penerbit' => $book->penerbit,
                            'ISBN' => $book->isbn ?? 'Tidak tersedia',
                            'Kode Buku' => $book->kode_buku,
                            'Tanggal Terbit' => $book->tanggal_terbit ? $book->tanggal_terbit->format('d M Y') : 'Tidak tersedia',
                            'Jumlah Halaman' => $book->jumlah_halaman . ' halaman'
                        ] as $label => $value)
                            <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-600/50 rounded-lg">
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400 w-32">{{ $label }}:</span>
                                <span class="text-sm text-gray-900 dark:text-white">{{ $value }}</span>
                            </div>
                        @endforeach

                        <!-- Category Badge -->
                        <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-600/50 rounded-lg">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400 w-32">Kategori:</span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                {{ ucfirst($book->kategori) }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Description Section -->
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Deskripsi</h3>
                        <div class="p-4 bg-gray-50 dark:bg-gray-600/50 rounded-lg">
                            <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
                                {{ $book->deskripsi ?? 'Deskripsi tidak tersedia untuk buku ini.' }}
                            </p>
                        </div>
                       <!-- Loan Request Button Section -->
                        <div class="mt-6">
                            @if($hasPendingLoan)
                                <button disabled class="w-full px-6 py-3 bg-primary-50 dark:bg-primary-900 text-primary-800 dark:text-primary-200 font-medium rounded-xl cursor-not-allowed shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center space-x-2 border border-primary-200 dark:border-primary-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Menunggu Persetujuan</span>
                                </button>
                            @elseif($book->status === 'available')
                                <button 
                                    wire:click="requestLoan"
                                    class="w-full px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center space-x-2 border border-primary-700"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    <span>Ajukan Peminjaman</span>
                                </button>
                            @else
                                <button disabled class="w-full px-6 py-3 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 font-medium rounded-xl cursor-not-allowed shadow-md flex items-center justify-center space-x-2 border border-gray-200 dark:border-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Buku Tidak Tersedia</span>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="flex justify-end mt-6">
            <a href="{{ url('/member-books') }}" 
               class="inline-flex items-center px-4 py-2 bg-white hover:bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 text-sm font-medium rounded-lg border border-gray-200 dark:border-gray-600 transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Katalog
            </a>
        </div>
    </div>
</x-filament-panels::page>