<x-filament-panels::page>
    <!-- Header Section -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Cari Buku</h1>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Temukan buku digital yang Anda inginkan</p>
    </div>

    <!-- Search and Filter Section -->
    <div class="mb-8 bg-white dark:bg-gray-800 rounded-xl shadow-sm dark:shadow-gray-900/20 border border-gray-100 dark:border-gray-700 p-6">
        <div class="flex flex-col lg:flex-row gap-4">
            <!-- Search Input -->
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <x-heroicon-o-magnifying-glass class="w-4 h-4 inline mr-1" />
                    Pencarian
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <x-heroicon-o-magnifying-glass class="h-5 w-5 text-gray-400" />
                    </div>
                    <input
                        wire:model.live.debounce.300ms="search"
                        type="text"
                        id="search"
                        class="pl-10 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:focus:border-blue-400 dark:focus:ring-blue-400"
                        placeholder="Cari judul, penulis, atau ISBN..."
                    >
                </div>
            </div>

            <!-- Category Filter -->
            <div class="lg:w-64">
                <label for="kategori" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <x-heroicon-o-tag class="w-4 h-4 inline mr-1" />
                    Kategori
                </label>
                <select
                    wire:model.live="kategori"
                    id="kategori"
                    class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:focus:border-blue-400 dark:focus:ring-blue-400"
                >
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Daftar Buku -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($books as $book)
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

                    <!-- Category Badge -->
                    <div class="absolute top-3 right-3">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100/90 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300 border border-blue-200 dark:border-blue-700">
                            {{ ucfirst($book->kategori) }}
                        </span>
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
                        <div class="flex items-start justify-between">
                            <span class="text-gray-500 dark:text-gray-400 text-xs">Penulis:</span>
                            <span class="text-gray-700 dark:text-gray-300 text-xs font-medium text-right line-clamp-1 max-w-[60%]">{{ $book->penulis }}</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-gray-500 dark:text-gray-400 text-xs">Halaman:</span>
                            <span class="text-gray-700 dark:text-gray-300 text-xs">{{ $book->jumlah_halaman ?? 'N/A' }} hal</span>
                        </div>

                        @if($book->deskripsi)
                            <div class="pt-2 mt-2 border-t border-gray-100 dark:border-gray-700">
                                <p class="text-xs text-gray-600 dark:text-gray-400 line-clamp-3 leading-relaxed">
                                    {{ $book->deskripsi }}
                                </p>
                            </div>
                        @endif
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="mt-3 pt-2">
                        <x-filament::button
                            tag="a"
                            href="{{ route('book.detail', $book->id) }}"
                            size="sm"
                            class="w-full justify-center"
                            color="primary"
                        >
                            <span class="flex items-center">
                                <x-heroicon-o-eye class="w-4 h-4 mr-1.5" />
                                Lihat Detail
                            </span>
                        </x-filament::button>
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
                            Coba ubah kata kunci pencarian atau kategori Anda.
                        </p>
                    </div>
                    @if($search || $kategori)
                        <x-filament::button
                            wire:click="$set('search', ''); $set('kategori', '')"
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

    <!-- Pagination -->
    @if($books->hasPages())
        <div class="mt-8 flex justify-center">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 p-4">
                {{ $books->links() }}
            </div>
        </div>
    @endif
</x-filament-panels::page>



