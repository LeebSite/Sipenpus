<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sipenpus - Sistem Informasi Peminjaman Buku Perpustakaan</title>

    <!-- Fonts & Tailwind -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    },
                    colors: {
                        primary: '#4F46E5',
                        secondary: '#9333EA'
                    }
                }
            }
        }
    </script>

    <style>
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="antialiased font-sans bg-white text-gray-900">

<div class="min-h-screen flex flex-col relative">
    <!-- Header -->
    <header class="py-6 bg-white shadow">
        <div class="container mx-auto px-4 flex justify-between items-center pl-20 pr-20">
            <div class="flex items-center space-x-3">
                <img src="<?php echo e(asset('img/man3pekanbaru.png')); ?>" alt="Sipenpus Logo" class="h-12 w-12">
                <div>
                    <h1 class="text-xl font-bold text-purple-800">Sipenpus</h1>
                    <p class="text-xs font-semibold text-orange-500 tracking-wide uppercase">Perpustakaan Ismail Marzuki MAN 3 Kota Pekanbaru</p>
                </div>
            </div>
            <nav class="flex items-center space-x-4 text-sm font-semibold">
                <a href="#features" class="hover:text-purple-800">Fitur Kami</a>
                <a href="#contact" class="hover:text-purple-800">Contact</a>
                <?php if(auth()->guard()->check()): ?>
                    <?php
                        $dashboardUrl = url('/dashboard');
                        $user = auth()->user();
                        
                        if ($user->role === 'employee') {
                            $dashboardUrl = url('/employee-dashboard');
                        } elseif ($user->role === 'member') {
                            $dashboardUrl = url('/member-dashboard');
                        }
                    ?>
                    <a href="<?php echo e($dashboardUrl); ?>" class="px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white">Dashboard</a>
                <?php else: ?>
                    <a href="<?php echo e(url('/login')); ?>" class="px-4 py-2 rounded border border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white">Login</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    
    <!-- Hero -->
    <section class="relative h-[90vh] bg-cover bg-center" style="background-image: url('<?php echo e(asset('img/gambarperpus1.jpg')); ?>');">
        <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center">
            <div class="container mx-auto px-4 text-white">
                <div class="max-x-l pl-8">
                    <h2 class="text-2xl sm:text-5xl font-bold mb-2">Sistem Informasi Peminjaman Buku Perpustakaan</h2>
                    <h3 class="text-orange-500 font-semibold text-2xl mb-5">MAN 3 Pekanbaru</h3>
                    <p class="text-sm sm:text-base mb-6">Kelola peminjaman buku perpustakaan dengan mudah. Telusuri koleksi, pinjam buku, dan akses laporan dalam satu platform.</p>
                    <a href="<?php echo e(url('/login')); ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded">Mulai Sekarang</a>
                </div>
            </div>
        </div>
    </section>

    
    <!-- Subject Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-2xl font-bold mb-10 text-purple-800">Pilih subjek yang menarik bagi kamu yaa..</h2>
            <div class="flex flex-wrap justify-center gap-4 max-w-4xl mx-auto">
                <?php $__currentLoopData = ['Sejarah dan Sosial', 'Filsafat', 'Sains', 'Fiksi', 'Lihat lainnya..']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subjek): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="border border-purple-400 rounded-lg w-32 h-32 flex items-center justify-center text-center text-purple-900 font-semibold text-xs hover:bg-purple-50 transition">
                        <?php echo e($subjek); ?>

                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    
    <!-- Features -->
    <section id="features" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-purple-900 mb-12">Fitur Utama Kami</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="card bg-purple-700 text-white p-6 rounded-xl text-center">
                    <h3 class="text-lg font-semibold mb-2">📚 Katalog Buku</h3>
                    <p class="text-sm">Telusuri koleksi buku secara online, dengan pencarian cepat dan terstruktur.</p>
                </div>
                <div class="card bg-purple-700 text-white p-6 rounded-xl text-center">
                    <h3 class="text-lg font-semibold mb-2">🔄 Pinjam & Kembali</h3>
                    <p class="text-sm">Kelola proses peminjaman dan pengembalian buku dengan efisien.</p>
                </div>
                <div class="card bg-purple-700 text-white p-6 rounded-xl text-center">
                    <h3 class="text-lg font-semibold mb-2">📈 Laporan Statistik</h3>
                    <p class="text-sm">Dapatkan laporan lengkap aktivitas peminjaman buku perpustakaan.</p>
                </div>
            </div>
        </div>
    </section>

    
    <!-- Footer -->
    <footer id="contact" class="bg-gray-400 text-purple py-10 px-6">
        <div class="container mx-auto flex flex-col md:flex-row justify-between gap-8">
            <div class="md:w-1/3 rounded overflow-hidden shadow-lg">
                <iframe allowfullscreen="" height="250" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15897.443114755893!2d101.33187699123485!3d0.4507342565807903!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5a93d5e63895d%3A0x75549ad6049dac77!2sMAN%203%20KOTA%20PEKANBARU!5e0!3m2!1sid!2sid!4v1749151801175!5m2!1sid!2sid" style="border:0;" title="Map location of MAN 3 Kota Pekanbaru" width="100%">
                </iframe>
            </div>
            <div class="md:w-1/3">
                <h6 class="font-bold text-base mb-3 leading-tight">PERPUSTAKAAN ISMAIL MARZUKI<br>MAN 3 KOTA PEKANBARU</h6>
                <address class="text-sm not-italic">
                    Jl. Karya Guru, Kel. Tuah Madani, Kec. Tuah Madani, Kota Pekanbaru, Riau Kode Pos 28293
                </address>
            </div>
            <div class="md:w-1/3 text-sm space-y-2">
                <p><i class="fas fa-phone-alt mr-2"></i>0823-8864-8033</p>
                <p><i class="fas fa-envelope mr-2"></i>man3gemilang@gmail.com</p>
                <p><i class="fas fa-globe mr-2"></i><a href="https://man3pekanbaru.sch.id/" class="underline" target="_blank">Website MAN 3</a></p>
                <p><i class="fab fa-instagram mr-2"></i><a href="https://instagram.com/man3pekanbaru" class="underline" target="_blank">@man3pekanbaru</a></p>
            </div>
        </div>
    </footer>
</div>
</body>
</html>
<?php /**PATH C:\laragon\www\sipenpus\resources\views/welcome.blade.php ENDPATH**/ ?>