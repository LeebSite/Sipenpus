<?php if (isset($component)) { $__componentOriginal166a02a7c5ef5a9331faf66fa665c256 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.page.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-900 dark:text-white">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Book Image & Action -->
            <div class="w-full md:w-1/3">
                <div class="bg-gray-100 dark:bg-gray-700 rounded-xl overflow-hidden aspect-[3/4] w-100 h-46">
                    <!--[if BLOCK]><![endif]--><?php if($book->gambar): ?>
                        <img src="<?php echo e(asset('storage/' . $book->gambar)); ?>" alt="<?php echo e($book->judul); ?>" class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center text-gray-400 dark:text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                <div class="mt-5">
                    <button wire:click="requestLoan"
                        class="w-full py-2 px-4 rounded-md font-semibold text-center transition-all duration-200
                            <?php echo e($book->status === 'available'
                                ? 'bg-primary-600 hover:bg-primary-700 text-white'
                                : 'bg-gray-300 text-gray-500 cursor-not-allowed'); ?>">
                        <?php echo e($book->status === 'available' ? 'Pinjam Buku' : 'Buku Tidak Tersedia'); ?>

                    </button>
                </div>
            </div>

            <!-- Book Info -->
            <div class="w-full md:w-2/3 space-y-6">
                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight"><?php echo e($book->judul); ?></h1>
                    <div class="flex flex-wrap items-center gap-2 mt-2">
                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                            <?php echo e(ucfirst($book->kategori)); ?>

                        </span>
                        <span class="px-3 py-1 text-xs font-medium rounded-full 
                            <?php echo e($book->status === 'available' 
                                ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' 
                                : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'); ?>">
                            <?php echo e($book->status === 'available' ? 'Tersedia' : 'Tidak Tersedia'); ?>

                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 text-sm">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 font-medium">Penulis</p>
                        <p class="text-base font-semibold"><?php echo e($book->penulis); ?></p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 font-medium">Penerbit</p>
                        <p class="text-base font-semibold"><?php echo e($book->penerbit); ?></p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 font-medium">Tanggal Terbit</p>
                        <p class="text-base font-semibold">
                            <!--[if BLOCK]><![endif]--><?php if(is_string($book->tanggal_terbit)): ?>
                                <?php echo e($book->tanggal_terbit); ?>

                            <?php else: ?>
                                <?php echo e($book->tanggal_terbit->format('d M Y')); ?>

                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 font-medium">Jumlah Halaman</p>
                        <p class="text-base font-semibold"><?php echo e($book->jumlah_halaman); ?></p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 font-medium">ISBN</p>
                        <p class="text-base font-semibold"><?php echo e($book->isbn ?? '-'); ?></p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 font-medium">Kode Buku</p>
                        <p class="text-base font-semibold"><?php echo e($book->kode_buku); ?></p>
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-semibold mb-2">Deskripsi</h2>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line">
                        <?php echo e($book->deskripsi ?? 'Tidak ada deskripsi.'); ?>

                    </p>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $attributes = $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $component = $__componentOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\sipenpus\resources\views/filament/pages/book-detail.blade.php ENDPATH**/ ?>