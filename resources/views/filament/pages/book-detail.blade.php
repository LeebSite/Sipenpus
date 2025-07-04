<x-filament-panels::page>
    <div class="p-6 bg-white rounded-xl shadow-sm dark:bg-gray-800">
        <div class="bg-white dark:bg-gray-700 rounded-xl shadow-md overflow-hidden border border-gray-100 dark:border-gray-600">
            <div class="md:flex">
                <!-- Bagian Sampul Buku -->
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
                
                <!-- Bagian Detail Buku -->
                <div class="md:w-2/3 p-6 border-t md:border-t-0 md:border-l border-gray-100 dark:border-gray-600">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">{{ $book->judul }}</h2>
                    <div class="space-y-4">
                        <!-- Lencana Status -->
                        <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400 w-32">Status:</span>
                            @if($hasPendingLoan)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-200 border border-primary-200 dark:border-primary-800">
                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 2a8 8 0 100 16 8 8 0 000-16zm0 14a6 6 0 110-12 6 6 0 010 12zm1-6a1 1 0 11-2 0V7a1 1 0 112 0v3z"/>
                                    </svg>
                                    Menunggu Persetujuan
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $book->status === 'available' ? 'bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-200 border border-primary-200 dark:border-primary-800' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 border border-red-200 dark:border-red-800' }}">
                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $book->status === 'available' ? 'Tersedia' : 'Tidak Tersedia' }}
                                </span>
                            @endif
                        </div>

                        <!-- Informasi Buku -->
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

                        <!-- Lencana Kategori -->
                        <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-600/50 rounded-lg">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400 w-32">Kategori:</span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                {{ ucfirst($book->kategori) }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Bagian Deskripsi -->
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Deskripsi</h3>
                        <div class="p-4 bg-gray-50 dark:bg-gray-600/50 rounded-lg">
                            <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
                                {{ $book->deskripsi ?? 'Deskripsi tidak tersedia untuk buku ini.' }}
                            </p>
                        </div>
                        <!-- Bagian Tombol Permintaan Peminjaman -->
                        <div class="mt-6">
                            @if($hasPendingLoan)
                                <button 
                                    wire:click="$toggle('showCancelModal')"
                                    class="w-full px-6 py-3 bg-primary-100 hover:bg-primary-200 text-primary-800 dark:bg-primary-900 dark:hover:bg-primary-800 dark:text-primary-200 font-medium rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center space-x-2 border border-primary-200 dark:border-primary-800"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Menunggu Persetujuan (Klik untuk batalkan)</span>
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
                            <!-- Modal Konfirmasi Pembatalan -->
                            @if($showCancelModal)
                                <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                        <!-- Lapisan latar belakang -->
                                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                                        <!-- Panel modal -->
                                        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                <div class="sm:flex sm:items-start">
                                                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-primary-100 dark:bg-primary-900 sm:mx-0 sm:h-10 sm:w-10">
                                                        <svg class="h-6 w-6 text-primary-600 dark:text-primary-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                        </svg>
                                                    </div>
                                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                                                            Batalkan Pengajuan Peminjaman
                                                        </h3>
                                                        <div class="mt-2">
                                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                                Apakah Anda yakin ingin membatalkan pengajuan peminjaman buku ini?
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bg-success-50 dark:bg-success-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                <button 
                                                    wire:click="cancelLoan"
                                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto sm:text-sm dark:bg-primary-700 dark:hover:bg-primary-600"
                                                >
                                                    Ya, Batalkan
                                                </button>
                                                <button 
                                                    wire:click="$toggle('showCancelModal')"
                                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                                >
                                                    Tidak
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Kembali -->
        <div class="flex justify-end mt-6">
            <x-filament::button
                tag="a"
                href="{{ App\Filament\Pages\MemberBooks::getUrl() }}"
                color="gray"
                outlined
                size="sm"
            >
                <x-heroicon-o-arrow-left class="w-4 h-4 mr-2" />
                Kembali ke Katalog
            </x-filament::button>
        </div>
    </div>
</x-filament-panels::page>

