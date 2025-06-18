<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="light scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sipenpus - Sistem Informasi Peminjaman Buku Perpustakaan</title>

    <!-- Fonts & Tailwind -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Poppins', 'sans-serif']
                    },
                    colors: {
                        primary: {
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            200: '#ddd6fe',
                            300: '#c4b5fd',
                            400: '#a78bfa',
                            500: '#8b5cf6',
                            600: '#7c3aed',
                            700: '#6d28d9',
                            800: '#5b21b6',
                            900: '#4c1d95',
                        },
                        secondary: {
                            50: '#fdf4ff',
                            100: '#fae8ff',
                            200: '#f5d0fe',
                            300: '#f0abfc',
                            400: '#e879f9',
                            500: '#d946ef',
                            600: '#c026d3',
                            700: '#a21caf',
                            800: '#86198f',
                            900: '#701a75',
                        },
                        accent: {
                            50: '#fff7ed',
                            100: '#ffedd5',
                            200: '#fed7aa',
                            300: '#fdba74',
                            400: '#fb923c',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                            800: '#9a3412',
                            900: '#7c2d12',
                        }
                    },
                    transitionDuration: {
                        '2000': '2000ms',
                    }
                }
            }
        }
    </script>

    <style>
        html {
            scroll-behavior: smooth;
        }
        
        body {
            overflow-x: hidden;
        }
        
        .card {
            transition: all 0.4s ease;
        }
        
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }
        
        .nav-link {
            position: relative;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 0;
            background-color: #6d28d9;
            transition: width 0.3s ease;
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        .sticky-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            backdrop-filter: blur(8px);
            background-color: rgba(255, 255, 255, 0.9);
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transform: translateY(-100%);
        }
        
        .sticky-header.visible {
            transform: translateY(0);
        }
        
        .subject-card {
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
        }
        
        .subject-card:hover {
            transform: scale(1.05);
            background-color: #f5f3ff;
            border-color: #8b5cf6;
        }
        
        .subject-card::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, #6d28d9, #a21caf);
            transition: width 0.3s ease;
        }
        
        .subject-card:hover::before {
            width: 100%;
        }
        
        .section-heading {
            position: relative;
            display: inline-block;
        }
        
        .section-heading::after {
            content: '';
            position: absolute;
            width: 50%;
            height: 3px;
            bottom: -8px;
            left: 25%;
            background: linear-gradient(90deg, #6d28d9, #a21caf);
            border-radius: 3px;
        }
        
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        
        .fade-in.appear {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="antialiased font-sans bg-white text-gray-900">

<div class="min-h-screen flex flex-col relative">
    <!-- Header -->
    <header class="py-5 bg-white shadow-sm transition-all duration-300">
        <div class="container mx-auto px-4 md:px-8 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <img src="<?php echo e(asset('img/man3pekanbaru.png')); ?>" alt="Sipenpus Logo" class="h-12 w-12">
                <div>
                    <h1 class="text-xl font-bold text-primary-800 font-heading">Sipenpus</h1>
                    <p class="text-xs font-semibold text-accent-500 tracking-wide uppercase">Perpustakaan Ismail Marzuki MAN 3 Kota Pekanbaru</p>
                </div>
            </div>
            
            <!-- Mobile menu button -->
            <button class="block lg:hidden focus:outline-none" id="menuToggle">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            
            <nav class="hidden lg:flex items-center space-x-6 text-sm font-medium">
                <a href="#features" class="nav-link hover:text-primary-700 transition-colors">Fitur Kami</a>
                <a href="#subject" class="nav-link hover:text-primary-700 transition-colors">Koleksi</a>
                <a href="#contact" class="nav-link hover:text-primary-700 transition-colors">Kontak</a>
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
                    <a href="<?php echo e($dashboardUrl); ?>" class="px-5 py-2.5 rounded-lg bg-primary-600 hover:bg-primary-700 text-white shadow-md hover:shadow-lg transition-all">Dashboard</a>
                <?php else: ?>
                    <a href="<?php echo e(url('/login')); ?>" class="px-5 py-2.5 rounded-lg border-2 border-primary-600 text-primary-600 hover:bg-primary-600 hover:text-white transition-all">Masuk</a>
                <?php endif; ?>
            </nav>
        </div>
        
        <!-- Mobile menu (hidden by default) -->
        <div class="lg:hidden hidden mt-4 py-4 bg-gray-50 border-t border-b border-gray-100" id="mobileMenu">
            <div class="container mx-auto px-4">
                <nav class="flex flex-col space-y-4">
                    <a href="#features" class="font-medium hover:text-primary-700 transition-colors">Fitur Kami</a>
                    <a href="#subject" class="font-medium hover:text-primary-700 transition-colors">Koleksi</a>
                    <a href="#contact" class="font-medium hover:text-primary-700 transition-colors">Kontak</a>
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e($dashboardUrl); ?>" class="px-4 py-2 text-center rounded-lg bg-primary-600 hover:bg-primary-700 text-white shadow-md transition-all">Dashboard</a>
                    <?php else: ?>
                        <a href="<?php echo e(url('/login')); ?>" class="px-4 py-2 text-center rounded-lg border-2 border-primary-600 text-primary-600 hover:bg-primary-600 hover:text-white transition-all">Masuk</a>
                    <?php endif; ?>
                </nav>
            </div>
        </div>
    </header>
    
    <!-- Sticky Header (initially hidden) -->
    <header class="sticky-header py-4" id="stickyHeader">
        <div class="container mx-auto px-4 md:px-8 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <img src="<?php echo e(asset('img/man3pekanbaru.png')); ?>" alt="Sipenpus Logo" class="h-10 w-10">
                <h1 class="text-lg font-bold text-primary-800 font-heading">Sipenpus</h1>
            </div>
            <nav class="hidden lg:flex items-center space-x-6 text-sm font-medium">
                <a href="#features" class="nav-link hover:text-primary-700 transition-colors">Fitur Kami</a>
                <a href="#subject" class="nav-link hover:text-primary-700 transition-colors">Koleksi</a>
                <a href="#contact" class="nav-link hover:text-primary-700 transition-colors">Kontak</a>
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e($dashboardUrl); ?>" class="px-4 py-2 rounded-lg bg-primary-600 hover:bg-primary-700 text-white shadow-md transition-all text-xs">Dashboard</a>
                <?php else: ?>
                    <a href="<?php echo e(url('/login')); ?>" class="px-4 py-2 rounded-lg border-2 border-primary-600 text-primary-600 hover:bg-primary-600 hover:text-white transition-all text-xs">Masuk</a>
                <?php endif; ?>
            </nav>
            
            <!-- Mobile menu button in sticky header -->
            <button class="block lg:hidden focus:outline-none" id="stickyMenuToggle">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
        
        <!-- Mobile menu in sticky header (hidden by default) -->
        <div class="lg:hidden hidden mt-4 py-4 bg-white border-t border-gray-100" id="stickyMobileMenu">
            <div class="container mx-auto px-4">
                <nav class="flex flex-col space-y-3">
                    <a href="#features" class="font-medium hover:text-primary-700 transition-colors">Fitur Kami</a>
                    <a href="#subject" class="font-medium hover:text-primary-700 transition-colors">Koleksi</a>
                    <a href="#contact" class="font-medium hover:text-primary-700 transition-colors">Kontak</a>
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e($dashboardUrl); ?>" class="px-4 py-2 text-center rounded-lg bg-primary-600 hover:bg-primary-700 text-white shadow-md transition-all">Dashboard</a>
                    <?php else: ?>
                        <a href="<?php echo e(url('/login')); ?>" class="px-4 py-2 text-center rounded-lg border-2 border-primary-600 text-primary-600 hover:bg-primary-600 hover:text-white transition-all">Masuk</a>
                    <?php endif; ?>
                </nav>
            </div>
        </div>
    </header>   

    <!-- Hero -->
    <section class="relative h-[90vh] bg-cover bg-center" style="background-image: url('<?php echo e(asset('img/gambarperpus1.jpg')); ?>');">
        <div class="absolute inset-0 bg-gradient-to-r from-black to-purple-900 bg-opacity-70 flex items-center">
            <div class="container mx-auto px-4 md:px-8 text-white">
                <div class="max-w-2xl pl-0 md:pl-8" data-aos="fade-right" data-aos-duration="1000">
                    <h2 class="text-3xl sm:text-5xl lg:text-6xl font-bold mb-3 font-heading leading-tight">Sistem Informasi Peminjaman Buku Perpustakaan</h2>
                    <h3 class="text-accent-400 font-semibold text-xl sm:text-2xl mb-6 font-heading">MAN 3 Pekanbaru</h3>
                    <p class="text-sm sm:text-base mb-8 text-gray-200 max-w-xl">Kelola peminjaman buku perpustakaan dengan mudah. Telusuri koleksi, pinjam buku, dan akses laporan dalam satu platform terintegrasi.</p>
                    <a href="<?php echo e(url('/login')); ?>" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg shadow-lg hover:shadow-xl transition-all inline-flex items-center group">
                        Mulai Sekarang
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Scroll indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <a href="#subject" class="text-white opacity-80 hover:opacity-100 transition-opacity">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                </svg>
            </a>
        </div>
    </section>

    <!-- Subject Section -->
    <section id="subject" class="py-20 bg-white">
        <div class="container mx-auto px-4 md:px-8 text-center">
            <h2 class="text-3xl font-bold mb-3 text-primary-800 section-heading font-heading" data-aos="fade-up">Pilih subjek yang menarik bagi kamu</h2>
            <p class="text-gray-600 max-w-xl mx-auto mb-12" data-aos="fade-up" data-aos-delay="100">Temukan koleksi buku berdasarkan subjek yang sesuai dengan minat dan kebutuhan belajarmu</p>
            
            <div class="flex flex-wrap justify-center gap-4 md:gap-6 max-w-4xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                <?php $__currentLoopData = ['Sejarah dan Sosial', 'Filsafat', 'Sains', 'Fiksi', 'Lihat lainnya..']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $subjek): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="subject-card border-2 border-primary-200 rounded-xl w-36 h-36 md:w-40 md:h-40 flex items-center justify-center text-center text-primary-900 font-semibold hover:bg-primary-50 transition" data-aos="zoom-in" data-aos-delay="<?php echo e(200 + ($index * 100)); ?>">
                        <div>
                            <?php if($subjek === 'Sejarah dan Sosial'): ?>
                                <i class="fas fa-landmark text-2xl mb-3 text-primary-600"></i>
                            <?php elseif($subjek === 'Filsafat'): ?>
                                <i class="fas fa-brain text-2xl mb-3 text-primary-600"></i>
                            <?php elseif($subjek === 'Sains'): ?>
                                <i class="fas fa-atom text-2xl mb-3 text-primary-600"></i>
                            <?php elseif($subjek === 'Fiksi'): ?>
                                <i class="fas fa-book text-2xl mb-3 text-primary-600"></i>
                            <?php else: ?>
                                <i class="fas fa-ellipsis-h text-2xl mb-3 text-primary-600"></i>
                            <?php endif; ?>
                            <p><?php echo e($subjek); ?></p>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section id="features" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4 md:px-8 text-center">
            <h2 class="text-3xl font-bold text-center text-primary-900 section-heading font-heading mb-12" data-aos="fade-up">Fitur Utama Kami</h2>
            <p class="text-gray-600 max-w-xl mx-auto text-center mb-12" data-aos="fade-up" data-aos-delay="100">Nikmati kemudahan dalam mengelola perpustakaan dengan fitur-fitur unggulan yang kami tawarkan</p>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="card bg-gradient-to-br from-primary-600 to-primary-800 text-white p-8 rounded-xl text-center shadow-lg" data-aos="fade-up" data-aos-delay="200">
                    <div class="bg-white/10 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-5">
                        <i class="fas fa-book-open text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 font-heading">Katalog Buku</h3>
                    <p class="text-sm text-gray-100">Telusuri koleksi buku secara online, dengan pencarian cepat dan terstruktur berdasarkan kategori, penulis, atau tahun terbit.</p>
                </div>
                
                <div class="card bg-gradient-to-br from-primary-700 to-secondary-700 text-white p-8 rounded-xl text-center shadow-lg" data-aos="fade-up" data-aos-delay="300">
                    <div class="bg-white/10 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-5">
                        <i class="fas fa-exchange-alt text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 font-heading">Pinjam & Kembali</h3>
                    <p class="text-sm text-gray-100">Kelola proses peminjaman dan pengembalian buku dengan efisien, disertai notifikasi dan reminder otomatis.</p>
                </div>
                
                <div class="card bg-gradient-to-br from-secondary-700 to-secondary-800 text-white p-8 rounded-xl text-center shadow-lg" data-aos="fade-up" data-aos-delay="400">
                    <div class="bg-white/10 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-5">
                        <i class="fas fa-chart-bar text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 font-heading">Laporan Statistik</h3>
                    <p class="text-sm text-gray-100">Dapatkan laporan lengkap aktivitas peminjaman buku perpustakaan dalam bentuk grafik dan data yang mudah dipahami.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="bg-gray-800 text-white py-16 px-6">
        <div class="container mx-auto flex flex-col md:flex-row justify-between gap-8">
            <div class="md:w-1/3 rounded-lg overflow-hidden shadow-lg" data-aos="fade-right">
                <iframe allowfullscreen="" height="250" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15897.443114755893!2d101.33187699123485!3d0.4507342565807903!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5a93d5e63895d%3A0x75549ad6049dac77!2sMAN%203%20KOTA%20PEKANBARU!5e0!3m2!1sid!2sid!4v1749151801175!5m2!1sid!2sid" style="border:0;" title="Map location of MAN 3 Kota Pekanbaru" width="100%">
                </iframe>
            </div>
            
            <div class="md:w-1/3" data-aos="fade-up">
                <h6 class="font-bold text-lg mb-4 leading-tight text-accent-400 font-heading">PERPUSTAKAAN ISMAIL MARZUKI<br>MAN 3 KOTA PEKANBARU</h6>
                <address class="text-sm not-italic text-gray-300 mb-4 leading-relaxed">
                    Jl. Karya Guru, Kel. Tuah Madani, Kec. Tuah Madani, Kota Pekanbaru, Riau Kode Pos 28293
                </address>
            </div>
            
            <div class="md:w-1/3 text-sm space-y-3" data-aos="fade-left">
                <p class="flex items-center text-gray-300 hover:text-white transition-colors">
                    <i class="fas fa-phone-alt mr-3 w-5 text-accent-400"></i>0823-8864-8033
                </p>
                <p class="flex items-center text-gray-300 hover:text-white transition-colors">
                    <i class="fas fa-envelope mr-3 w-5 text-accent-400"></i>man3gemilang@gmail.com
                </p>
                <p class="flex items-center text-gray-300 hover:text-white transition-colors">
                    <i class="fas fa-globe mr-3 w-5 text-accent-400"></i>
                    <a href="https://man3pekanbaru.sch.id/" class="underline hover:text-accent-400 transition-colors" target="_blank">Website MAN 3</a>
                </p>
                <p class="flex items-center text-gray-300 hover:text-white transition-colors">
                    <i class="fab fa-instagram mr-3 w-5 text-accent-400"></i>
                    <a href="https://instagram.com/man3pekanbaru" class="underline hover:text-accent-400 transition-colors" target="_blank">@man3pekanbaru</a>
                </p>
            </div>
        </div>
        
        <div class="container mx-auto mt-12 pt-6 border-t border-gray-700 text-center text-sm text-gray-400">
            <p>© <?php echo e(date('Y')); ?> Sipenpus - Perpustakaan Ismail Marzuki MAN 3 Kota Pekanbaru. All rights reserved.</p>
        </div>
    </footer>
</div>

<!-- Scripts -->
<script>
    // Initialize AOS animations
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            once: true,
            offset: 100,
            duration: 800
        });
        
        // Mobile menu toggle
        const menuToggle = document.getElementById('menuToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        
        menuToggle.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
        
        // Sticky header functionality
        const stickyHeader = document.getElementById('stickyHeader');
        const regularHeader = document.querySelector('header:not(.sticky-header)');
        const stickyMenuToggle = document.getElementById('stickyMenuToggle');
        const stickyMobileMenu = document.getElementById('stickyMobileMenu');
        
        stickyMenuToggle.addEventListener('click', function() {
            stickyMobileMenu.classList.toggle('hidden');
        });
        
        // Show/hide sticky header based on scroll position
        let lastScrollTop = 0;
        
        window.addEventListener('scroll', function() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            // Show sticky header when scrolling down past the regular header
            if (scrollTop > regularHeader.offsetHeight && scrollTop > lastScrollTop) {
                stickyHeader.classList.add('visible');
            } 
            // Hide sticky header when scrolling up to the top
            else if (scrollTop <= regularHeader.offsetHeight || scrollTop < lastScrollTop) {
                stickyHeader.classList.remove('visible');
            }
            
            lastScrollTop = scrollTop;
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Close mobile menus when clicking a link
                mobileMenu.classList.add('hidden');
                stickyMobileMenu.classList.add('hidden');
                
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Scroll reveal animation for sections
        const revealElements = document.querySelectorAll('.fade-in');
        
        function checkReveal() {
            for (let i = 0; i < revealElements.length; i++) {
                const windowHeight = window.innerHeight;
                const elementTop = revealElements[i].getBoundingClientRect().top;
                const elementVisible = 150;
                
                if (elementTop < windowHeight - elementVisible) {
                    revealElements[i].classList.add('appear');
                }
            }
        }
        
        window.addEventListener('scroll', checkReveal);
        checkReveal(); // Check on load
    });
</script>
</body>
</html><?php /**PATH C:\laragon\www\sipenpus\resources\views/welcome.blade.php ENDPATH**/ ?>