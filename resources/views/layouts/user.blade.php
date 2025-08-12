<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laboratorium Fisika Medis</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        inter: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: '#10B981',
                        secondary: '#059669',
                        accent: '#F59E0B',
                        neutral: '#F3F4F6',
                        dark: '#111827',
                    },
                    backgroundImage: {
                        'pattern-wave': "url(\"data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 50C20 30 40 30 50 50C60 70 80 70 100 50' stroke='%23F3F4F6' stroke-width='2' fill='none'/%3E%3C/svg%3E\")",
                    },
                    boxShadow: {
                        'glass': '0 4px 30px rgba(0, 0, 0, 0.1)',
                    },
                    backdropBlur: {
                        xs: '2px',
                    },
                }
            }
        }
    </script>
    <style>
        .bg-pattern-wave {
            background-color: #ffffff;
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 50C20 30 40 30 50 50C60 70 80 70 100 50' stroke='%23F3F4F6' stroke-width='2' fill='none'/%3E%3C/svg%3E");
        }
        .bg-gradient-modern {
            background: linear-gradient(135deg, #F3F4F6 0%, #E5E7EB 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        .glassmorphic {
            background: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        .navbar-transition {
            transition: background-color 0.4s cubic-bezier(.4,0,.2,1), border-bottom 0.4s cubic-bezier(.4,0,.2,1);
        }
        .nav-link-underline {
            position: relative;
            display: inline-block;
        }
        .nav-link-underline::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: -2px;
            width: 0;
            height: 2.5px;
            background: #10B981;
            border-radius: 2px;
            transition: width 0.3s cubic-bezier(.68,-0.55,.27,1.55), left 0.3s cubic-bezier(.68,-0.55,.27,1.55);
        }
        .nav-link-underline:hover::after, .nav-link-underline:focus-visible::after {
            width: 100%;
            left: 0;
        }
        .dropdown {
            position: relative;
        }
        .dropdown-content {
            position: absolute;
            top: 100%;
            left: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            border: 1px solid rgba(0,0,0,0.1);
            min-width: 200px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1000;
        }
        .dropdown:hover .dropdown-content {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .dropdown-item {
            padding: 12px 16px;
            color: #374151;
            display: block;
            text-decoration: none;
            transition: all 0.2s ease;
            border-radius: 8px;
            margin: 4px;
        }
        .dropdown-item:hover {
            background: #F3F4F6;
            color: #10B981;
            transform: translateX(4px);
        }
    </style>
</head>
<body class="bg-neutral font-inter">
    <nav id="main-navbar" class="navbar-transition fixed w-full bg-transparent border-b border-white/20 text-gray-800 z-50 shadow-md">
        <div class="container mx-auto px-6">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <img id="logo-putih" src="{{ asset('images/logo/logo-fisika-putih.png') }}" alt="Logo Putih" class="h-6 md:h-10 md:w-auto object-contain">
                    <img id="logo-hitam" src="{{ asset('images/logo/logo-fisika-hitam.png') }}" alt="Logo Hitam" class="h-6 md:h-10 md:w-auto object-contain hidden">
                </div>
                <div id="navbar-menu" class="hidden md:flex space-x-8 text-white">
                    <a href="#home" class="nav-link-underline">Beranda</a>
                    <a href="#about" class="nav-link-underline">Tentang</a>
                    <a href="{{ route('staff')}}" class="nav-link-underline">Staff dan Ahli</a>
                    <a href="#article" class="nav-link-underline">Artikel</a>
                    <div class="dropdown">
                        <a href="#" class="nav-link-underline flex items-center gap-1">
                            Layanan
                            <i class="fas fa-chevron-down text-xs"></i>
                        </a>
                        <div class="dropdown-content">
                            <a href="{{ route('equipment.rental') }}" class="dropdown-item flex items-center gap-2">
                                <i class="fas fa-tools text-emerald-500"></i>
                                Peminjaman Alat
                            </a>
                            <a href="{{ route('lab.visit') }}" class="dropdown-item flex items-center gap-2">
                                <i class="fas fa-microscope text-emerald-500"></i>
                                Kunjungan Lab
                            </a>
                        </div>
                    </div>
                    <!-- <a href="#services" class="nav-link-underline">Layanan</a> -->
                    <a href="#gallery" class="nav-link-underline">Galeri</a>
                </div>
                <button class="md:hidden" id="mobile-menu-button">
                    <i class="fas fa-bars text-2xl text-primary"></i>
                </button>
            </div>
            <div class="md:hidden hidden" id="mobile-menu">
                <div class="flex flex-col space-y-4 pb-4 text-primary text-sm">
                    <a href="#home" class="nav-link-underline">Beranda</a>
                    <a href="#about" class="nav-link-underline">Tentang</a>
                    <a href="{{ route('staff')}}" class="nav-link-underline">Staff dan Ahli</a>
                    <a href="#article" class="nav-link-underline">Artikel</a>
                    <div class="border-l-2 border-emerald-500 pl-4 ml-2">
                        <p class="text-gray-600 font-semibold mb-2">Layanan</p>
                        <a href="{{ route('equipment.rental') }}" class="nav-link-underline block mb-2 flex items-center gap-2">
                            <i class="fas fa-tools text-emerald-500"></i>
                            Peminjaman Alat
                        </a>
                        <a href="{{ route('lab.visit') }}" class="nav-link-underline block flex items-center gap-2">
                            <i class="fas fa-microscope text-emerald-500"></i>
                            Kunjungan Lab
                        </a>
                    </div>
                    <!-- <a href="#services" class="nav-link-underline">Layanan</a> -->
                    <a href="#gallery" class="nav-link-underline">Galeri</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="">
        @yield('content')
    </main>

    <footer class="bg-white text-dark py-10">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h5 class="text-xl font-bold mb-4">Laboratorium Fisika Medis dan Aplikasi Nuklir</h5>
                    <p>Universitas Syiah Kuala</p>
                    <p class=" mt-2">Gedung Fakultas MIPA, Blok F Lantai 2</p>
                    <p class=" mt-2">Jl. Syech Abdurrauf No. 3</p>
                    <p class=" mt-2">Kopelma Darussalam, Banda Aceh, 23111</p>
                    <p class=" mt-2">ACEH - INDONESIA</p>
                </div>
                <div>
                    <h5 class="text-xl font-bold mb-4">Tautan Cepat</h5>
                    <ul class="space-y-2">
                        <li><a href="#about" class="hover:text-secondary transition-colors">Tentang</a></li>
                        <li><a href="#staff" class="hover:text-secondary transition-colors">Staff dan Ahli</a></li>
                        <li><a href="{{ route('article.index') }}" class="hover:text-secondary transition-colors">Artikel</a></li>
                        <li><a href="#services" class="hover:text-secondary transition-colors">Layanan</a></li>
                        <li><a href="#gallery" class="hover:text-secondary transition-colors">Galeri</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="text-xl font-bold mb-4">Ikuti Kami</h5>
                    <div class="flex space-x-4">
                        <a href="#" class="hover:text-secondary transition-colors"><i class="fab fa-facebook-f text-xl"></i></a>
                        <a href="#" class="hover:text-secondary transition-colors"><i class="fab fa-twitter text-xl"></i></a>
                        <a href="#" class="hover:text-secondary transition-colors"><i class="fab fa-instagram text-xl"></i></a>
                    </div>
                </div>
                <div id="contact">
                    <h5 class="text-xl font-bold mb-4">Kontak</h5>
                    <ul class="space-y-3 text-base">
                        <li class="flex items-center gap-3"><i class="fas fa-phone-alt text-pink-400"></i> <span class="text-dark">+62 651–7552939</span></li>
                        <li class="flex items-center gap-3"><i class="fas fa-envelope text-purple-400"></i> <span class="text-dark">lab.fisikamedis@usk.ac.id</span></li>
                        <li class="flex items-center gap-3"><i class="fas fa-globe text-blue-400"></i> <span class="text-dark">www.laboratoriumfisikamedis.usk.ac.id</span></li>
                        <li class="flex items-center gap-3"><i class="fas fa-map-marker-alt text-rose-400"></i> <span class="text-dark">Banda Aceh, Aceh</span></li>
                    </ul>
                </div>
            </div>
            <div class="mt-10 text-center">
                <p>© {{ date('Y') }} Laboratorium Fisika Medis - Universitas Syiah Kuala. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
        // Close mobile menu when clicking a link
        const mobileLinks = mobileMenu.getElementsByTagName('a');
        for (let link of mobileLinks) {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
            });
        }
        // Navbar transparent to solid on scroll
        const navbar = document.getElementById('main-navbar');
        const navbarMenu = document.getElementById('navbar-menu');
        const logoPutih = document.getElementById('logo-putih');
        const logoHitam = document.getElementById('logo-hitam');
        function handleNavbarBg() {
            if (window.scrollY > 60) {
                navbar.classList.remove('bg-transparent', 'border-white/20');
                navbar.classList.add('bg-white', 'border-gray-200');
                navbarMenu.classList.remove('text-white');
                navbarMenu.classList.add('text-gray-800');
                logoPutih.classList.add('hidden');
                logoHitam.classList.remove('hidden');
            } else {
                navbar.classList.add('bg-transparent', 'border-white/20');
                navbar.classList.remove('bg-white', 'border-gray-200');
                navbarMenu.classList.add('text-white');
                navbarMenu.classList.remove('text-gray-800');
                logoPutih.classList.remove('hidden');
                logoHitam.classList.add('hidden');
            }
        }
        window.addEventListener('scroll', handleNavbarBg);
        window.addEventListener('DOMContentLoaded', handleNavbarBg);
    </script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
      AOS.init({
        once: false,
        duration: 900,
        offset: 80,
      });
    </script>
</body>
</html>