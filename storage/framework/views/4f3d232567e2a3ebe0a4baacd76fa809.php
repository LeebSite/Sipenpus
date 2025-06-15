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
    <div class="p-4 bg-white rounded shadow dark:bg-gray-800 dark:text-white">
        <h1 class="text-2xl font-bold mb-4 dark:text-white">Dashboard Administrator</h1>
        <p class="dark:text-gray-300">Selamat datang, <?php echo e(auth()->user()->name); ?>!</p>
        
        <!-- Statistik Admin -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
            <div class="bg-blue-100 dark:bg-blue-900 p-4 rounded shadow">
                <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-200">Total Pengguna</h3>
                <p class="text-2xl font-bold text-blue-700 dark:text-blue-100"><?php echo e(\App\Models\User::count()); ?></p>
            </div>
            
            <div class="bg-green-100 dark:bg-green-900 p-4 rounded shadow">
                <h3 class="text-lg font-semibold text-green-800 dark:text-green-200">Total Buku</h3>
                <p class="text-2xl font-bold text-green-700 dark:text-green-100"><?php echo e(\App\Models\Book::count() ?? 0); ?></p>
            </div>
        </div>
        
        <!-- Konten khusus admin
        <div class="mt-8">
            <h2 class="text-xl font-semibold mb-4 dark:text-white">Aktivitas Terbaru</h2>
            Tambahkan konten aktivitas terbaru di sini
        </div> -->
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
<?php endif; ?>
<?php /**PATH C:\laragon\www\sipenpus\resources\views/filament/pages/dashboard.blade.php ENDPATH**/ ?>