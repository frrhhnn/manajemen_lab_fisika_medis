<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laboratorium Fisika Medis')</title>
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
        .section-header {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
        }
        .title-glow {
            text-shadow: 0 0 40px rgba(255, 255, 255, 0.3);
        }
        .floating-animation {
            animation: floating 6s ease-in-out infinite;
        }
        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .pulse-glow {
            animation: pulseGlow 4s ease-in-out infinite;
        }
        @keyframes pulseGlow {
            0%, 100% { box-shadow: 0 0 20px rgba(255, 255, 255, 0.1); }
            50% { box-shadow: 0 0 30px rgba(255, 255, 255, 0.2); }
        }
        .gradient-border {
            background: linear-gradient(45deg, rgba(255,255,255,0.1), rgba(255,255,255,0.3));
            background-size: 200% 200%;
            animation: gradientShift 3s ease infinite;
        }
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .particle-float {
            animation: particleFloat 8s ease-in-out infinite;
        }
        @keyframes particleFloat {
            0%, 100% { transform: translateY(0px) translateX(0px) rotate(0deg); }
            25% { transform: translateY(-15px) translateX(10px) rotate(90deg); }
            50% { transform: translateY(-5px) translateX(-10px) rotate(180deg); }
            75% { transform: translateY(-20px) translateX(5px) rotate(270deg); }
        }
        .scale-pulse {
            animation: scalePulse 3s ease-in-out infinite;
        }
        @keyframes scalePulse {
            0%, 100% { transform: scale(1); opacity: 0.7; }
            50% { transform: scale(1.1); opacity: 1; }
        }
        .rotate-slow {
            animation: rotateSlow 20s linear infinite;
        }
        @keyframes rotateSlow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .slide-in-left {
            animation: slideInLeft 1s ease-out;
        }
        @keyframes slideInLeft {
            from { transform: translateX(-100px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        .slide-in-right {
            animation: slideInRight 1s ease-out;
        }
        @keyframes slideInRight {
            from { transform: translateX(100px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    </style>
</head>
<body class="bg-neutral font-inter">
    <!-- Section Header -->
    <header class="section-header relative overflow-hidden">
        <!-- Enhanced Background Patterns -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, #ffffff 1px, transparent 0); background-size: 30px 30px;"></div>
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 15px 15px, #ffffff 0.5px, transparent 0); background-size: 60px 60px;"></div>
        </div>
        
        <!-- Large Background Blurs -->
        <div class="absolute top-10 right-10 w-32 h-32 bg-white/10 rounded-full blur-3xl floating-animation"></div>
        <div class="absolute bottom-10 left-10 w-40 h-40 bg-white/10 rounded-full blur-3xl floating-animation" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/4 w-24 h-24 bg-white/8 rounded-full blur-2xl floating-animation" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-1/4 right-1/3 w-36 h-36 bg-white/8 rounded-full blur-3xl floating-animation" style="animation-delay: 3s;"></div>
        
        <!-- Floating Geometric Elements Throughout Header -->
        <div class="absolute inset-0 pointer-events-none">
            <!-- Top Section Decorations -->
            <div class="absolute top-8 left-1/4 w-4 h-4 border border-white/20 rotate-45 particle-float" style="animation-delay: 0s;"></div>
            <div class="absolute top-12 right-1/4 w-3 h-3 bg-white/15 rounded-full scale-pulse" style="animation-delay: 1s;"></div>
            <div class="absolute top-6 left-1/3 w-2 h-2 bg-white/25 rounded-full particle-float" style="animation-delay: 2s;"></div>
            <div class="absolute top-16 right-1/3 w-5 h-5 border border-white/15 rounded-lg rotate-slow" style="animation-delay: 0.5s;"></div>
            
            <!-- Middle Section Decorations -->
            <div class="absolute top-1/3 left-8 w-6 h-6 border border-white/20 rounded-full scale-pulse" style="animation-delay: 1.5s;"></div>
            <div class="absolute top-1/3 right-12 w-4 h-4 bg-white/10 rotate-45 particle-float" style="animation-delay: 2.5s;"></div>
            <div class="absolute top-1/2 left-1/5 w-3 h-3 border border-white/25 rounded-full floating-animation" style="animation-delay: 3s;"></div>
            <div class="absolute top-1/2 right-1/5 w-5 h-5 bg-white/15 rounded-lg rotate-slow" style="animation-delay: 1.2s;"></div>
            
            <!-- Bottom Section Decorations -->
            <div class="absolute bottom-8 left-1/6 w-4 h-4 border border-white/20 rotate-45 scale-pulse" style="animation-delay: 3.5s;"></div>
            <div class="absolute bottom-12 right-1/6 w-3 h-3 bg-white/20 rounded-full particle-float" style="animation-delay: 4s;"></div>
            <div class="absolute bottom-6 left-2/5 w-2 h-2 bg-white/30 rounded-full floating-animation" style="animation-delay: 4.5s;"></div>
            <div class="absolute bottom-16 right-2/5 w-6 h-6 border border-white/15 rounded-2xl rotate-slow" style="animation-delay: 2.8s;"></div>
            
            <!-- Additional Scattered Elements -->
            <div class="absolute top-1/4 left-3/4 w-2 h-2 bg-white/25 rounded-full scale-pulse" style="animation-delay: 5s;"></div>
            <div class="absolute top-3/4 left-1/2 w-3 h-3 border border-white/20 rotate-45 particle-float" style="animation-delay: 5.5s;"></div>
            <div class="absolute top-2/3 right-3/4 w-4 h-4 bg-white/12 rounded-lg floating-animation" style="animation-delay: 6s;"></div>
            <div class="absolute bottom-1/3 left-3/5 w-2 h-2 border border-white/25 rounded-full rotate-slow" style="animation-delay: 6.5s;"></div>
        </div>
        
        <!-- Corner Constellation Effects -->
        <div class="absolute top-0 left-0 w-32 h-32 pointer-events-none">
            <div class="absolute top-4 left-4 w-1 h-1 bg-white/40 rounded-full particle-float" style="animation-delay: 7s;"></div>
            <div class="absolute top-8 left-12 w-1 h-1 bg-white/30 rounded-full particle-float" style="animation-delay: 7.5s;"></div>
            <div class="absolute top-12 left-8 w-1 h-1 bg-white/35 rounded-full particle-float" style="animation-delay: 8s;"></div>
            <div class="absolute top-6 left-16 w-1 h-1 bg-white/25 rounded-full particle-float" style="animation-delay: 8.5s;"></div>
        </div>
        
        <div class="absolute top-0 right-0 w-32 h-32 pointer-events-none">
            <div class="absolute top-4 right-4 w-1 h-1 bg-white/40 rounded-full particle-float" style="animation-delay: 9s;"></div>
            <div class="absolute top-8 right-12 w-1 h-1 bg-white/30 rounded-full particle-float" style="animation-delay: 9.5s;"></div>
            <div class="absolute top-12 right-8 w-1 h-1 bg-white/35 rounded-full particle-float" style="animation-delay: 10s;"></div>
            <div class="absolute top-6 right-16 w-1 h-1 bg-white/25 rounded-full particle-float" style="animation-delay: 10.5s;"></div>
        </div>
        
        <div class="absolute bottom-0 left-0 w-32 h-32 pointer-events-none">
            <div class="absolute bottom-4 left-4 w-1 h-1 bg-white/40 rounded-full particle-float" style="animation-delay: 11s;"></div>
            <div class="absolute bottom-8 left-12 w-1 h-1 bg-white/30 rounded-full particle-float" style="animation-delay: 11.5s;"></div>
            <div class="absolute bottom-12 left-8 w-1 h-1 bg-white/35 rounded-full particle-float" style="animation-delay: 12s;"></div>
            <div class="absolute bottom-6 left-16 w-1 h-1 bg-white/25 rounded-full particle-float" style="animation-delay: 12.5s;"></div>
        </div>
        
        <div class="absolute bottom-0 right-0 w-32 h-32 pointer-events-none">
            <div class="absolute bottom-4 right-4 w-1 h-1 bg-white/40 rounded-full particle-float" style="animation-delay: 13s;"></div>
            <div class="absolute bottom-8 right-12 w-1 h-1 bg-white/30 rounded-full particle-float" style="animation-delay: 13.5s;"></div>
            <div class="absolute bottom-12 right-8 w-1 h-1 bg-white/35 rounded-full particle-float" style="animation-delay: 14s;"></div>
            <div class="absolute bottom-6 right-16 w-1 h-1 bg-white/25 rounded-full particle-float" style="animation-delay: 14.5s;"></div>
        </div>
        
        <!-- Flowing Lines Decoration -->
        <div class="absolute inset-0 pointer-events-none opacity-20">
            <!-- Horizontal flowing lines -->
            <div class="absolute top-1/4 left-0 w-full h-px bg-gradient-to-r from-transparent via-white/30 to-transparent"></div>
            <div class="absolute top-2/3 left-0 w-full h-px bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
            
            <!-- Vertical flowing lines -->
            <div class="absolute top-0 left-1/4 w-px h-full bg-gradient-to-b from-transparent via-white/20 to-transparent"></div>
            <div class="absolute top-0 right-1/4 w-px h-full bg-gradient-to-b from-transparent via-white/15 to-transparent"></div>
        </div>
        
        <!-- Additional Layered Background Effects -->
        <div class="absolute inset-0 pointer-events-none">
            <!-- Subtle gradient overlays -->
            <div class="absolute top-0 left-0 w-1/3 h-1/3 bg-gradient-radial from-white/5 to-transparent rounded-full blur-xl"></div>
            <div class="absolute top-0 right-0 w-1/4 h-1/4 bg-gradient-radial from-white/4 to-transparent rounded-full blur-2xl"></div>
            <div class="absolute bottom-0 left-0 w-1/4 h-1/4 bg-gradient-radial from-white/4 to-transparent rounded-full blur-2xl"></div>
            <div class="absolute bottom-0 right-0 w-1/3 h-1/3 bg-gradient-radial from-white/5 to-transparent rounded-full blur-xl"></div>
        </div>
        
        <div class="container mx-auto px-6 relative z-10 py-8">
            <!-- Navigation & Back Button with Decorations -->
            <div class="flex items-center justify-between mb-8 relative" data-aos="fade-down">
                <!-- Navigation Background Decoration -->
                <div class="absolute inset-0 pointer-events-none">
                    <!-- Left side mini decorations -->
                    <div class="absolute top-0 left-0 w-2 h-2 bg-white/20 rounded-full scale-pulse" style="animation-delay: 0.2s;"></div>
                    <div class="absolute bottom-0 left-8 w-1 h-1 bg-white/30 rounded-full particle-float" style="animation-delay: 0.8s;"></div>
                    
                    <!-- Right side mini decorations -->
                    <div class="absolute top-0 right-0 w-2 h-2 bg-white/20 rounded-full scale-pulse" style="animation-delay: 1.2s;"></div>
                    <div class="absolute bottom-0 right-8 w-1 h-1 bg-white/30 rounded-full particle-float" style="animation-delay: 1.8s;"></div>
                    
                    <!-- Center flowing line -->
                    <div class="absolute top-1/2 left-1/4 right-1/4 h-px bg-gradient-to-r from-transparent via-white/15 to-transparent"></div>
                </div>
                
                <!-- Back Button & Logo -->
                <div class="flex items-center gap-6 relative">
                    <!-- Button side decorations -->
                    <div class="absolute -left-3 top-1/2 transform -translate-y-1/2 w-1 h-4 bg-gradient-to-b from-transparent via-white/30 to-transparent"></div>
                    
                    <a href="javascript:history.back()" class="group relative flex items-center gap-3 bg-white/20 backdrop-blur-sm border border-white/30 text-white px-4 py-2 rounded-xl font-semibold hover:bg-white/30 transition-all duration-300 shadow-lg hover:shadow-xl">
                        <!-- Button corner decorations -->
                        <div class="absolute -top-1 -left-1 w-2 h-2 border-l border-t border-white/20 rounded-tl-md"></div>
                        <div class="absolute -bottom-1 -right-1 w-2 h-2 border-r border-b border-white/20 rounded-br-md"></div>
                        
                        <i class="fas fa-arrow-left transform group-hover:-translate-x-1 transition-transform duration-300"></i>
                        Kembali
                    </a>
                </div>
                
                <!-- Home Button -->
                <div class="relative">
                    <!-- Button side decorations -->
                    <div class="absolute -right-3 top-1/2 transform -translate-y-1/2 w-1 h-4 bg-gradient-to-b from-transparent via-white/30 to-transparent"></div>
                    
                    <a href="/" class="group relative flex items-center gap-2 bg-white/20 backdrop-blur-sm border border-white/30 text-white px-4 py-2 rounded-xl font-semibold hover:bg-white/30 transition-all duration-300 shadow-lg hover:shadow-xl">
                        <!-- Button corner decorations -->
                        <div class="absolute -top-1 -right-1 w-2 h-2 border-r border-t border-white/20 rounded-tr-md"></div>
                        <div class="absolute -bottom-1 -left-1 w-2 h-2 border-l border-b border-white/20 rounded-bl-md"></div>
                        
                        <i class="fas fa-home"></i>
                        <span class="hidden md:inline">Beranda</span>
                    </a>
                </div>
            </div>
            
            <!-- Breadcrumb with Decorations -->
            <nav class="mb-6 relative" data-aos="fade-right">
                <!-- Breadcrumb Background Decoration -->
                <div class="absolute inset-0 pointer-events-none">
                    <!-- Left decoration -->
                    <div class="absolute left-0 top-1/2 transform -translate-y-1/2 flex items-center gap-1">
                        <div class="w-4 h-px bg-gradient-to-r from-white/40 to-transparent"></div>
                        <div class="w-1 h-1 bg-white/30 rounded-full scale-pulse"></div>
                    </div>
                    
                    <!-- Right decoration -->
                    <div class="absolute right-0 top-1/2 transform -translate-y-1/2 flex items-center gap-1">
                        <div class="w-1 h-1 bg-white/30 rounded-full scale-pulse" style="animation-delay: 0.5s;"></div>
                        <div class="w-4 h-px bg-gradient-to-l from-white/40 to-transparent"></div>
                    </div>
                    
                    <!-- Floating mini particles around breadcrumb -->
                    <div class="absolute -top-2 left-1/4 w-1 h-1 bg-white/25 rounded-full particle-float" style="animation-delay: 2s;"></div>
                    <div class="absolute -bottom-2 right-1/4 w-1 h-1 bg-white/25 rounded-full particle-float" style="animation-delay: 2.5s;"></div>
                </div>
                
                <ol class="flex items-center space-x-1 md:space-x-2 text-xs md:text-sm text-white/90 relative overflow-x-auto pb-2">
                    <!-- Breadcrumb background line -->
                    <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>
                    
                    <li class="relative flex-shrink-0">
                        <!-- Home icon decoration -->
                        <div class="absolute -top-1 -left-1 w-1 h-1 bg-white/20 rounded-full scale-pulse" style="animation-delay: 3s;"></div>
                        
                        <a href="/" class="hover:text-white transition-colors flex items-center gap-1 relative whitespace-nowrap">
                            <i class="fas fa-home text-xs"></i>
                            <span class="hidden sm:inline">Beranda</span>
                            <span class="sm:hidden">Home</span>
                        </a>
                    </li>
                    @yield('breadcrumb')
                </ol>
            </nav>
            
            <!-- Page Title Section with Rich Decorations -->
            <div class="text-center relative overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                <!-- Floating Particles Background -->
                <div class="absolute inset-0 pointer-events-none">
                    <!-- Top Left Particles -->
                    <div class="absolute top-10 left-10 w-3 h-3 bg-white/20 rounded-full particle-float" style="animation-delay: 0s;"></div>
                    <div class="absolute top-20 left-32 w-2 h-2 bg-white/30 rounded-full particle-float" style="animation-delay: 1s;"></div>
                    <div class="absolute top-16 left-20 w-1 h-1 bg-white/40 rounded-full particle-float" style="animation-delay: 2s;"></div>
                    
                    <!-- Top Right Particles -->
                    <div class="absolute top-12 right-16 w-2 h-2 bg-white/25 rounded-full particle-float" style="animation-delay: 0.5s;"></div>
                    <div class="absolute top-8 right-28 w-3 h-3 bg-white/20 rounded-full particle-float" style="animation-delay: 1.5s;"></div>
                    <div class="absolute top-24 right-12 w-1 h-1 bg-white/35 rounded-full particle-float" style="animation-delay: 2.5s;"></div>
                    
                    <!-- Bottom Left Particles -->
                    <div class="absolute bottom-16 left-24 w-2 h-2 bg-white/30 rounded-full particle-float" style="animation-delay: 3s;"></div>
                    <div class="absolute bottom-8 left-40 w-1 h-1 bg-white/40 rounded-full particle-float" style="animation-delay: 3.5s;"></div>
                    
                    <!-- Bottom Right Particles -->
                    <div class="absolute bottom-12 right-20 w-3 h-3 bg-white/25 rounded-full particle-float" style="animation-delay: 4s;"></div>
                    <div class="absolute bottom-20 right-36 w-2 h-2 bg-white/30 rounded-full particle-float" style="animation-delay: 4.5s;"></div>
                </div>
                
                <!-- Geometric Decorative Shapes -->
                <div class="absolute inset-0 pointer-events-none">
                    <!-- Left Side Decorations -->
                    <div class="absolute top-1/2 left-8 transform -translate-y-1/2">
                        <div class="w-16 h-16 border border-white/20 rounded-2xl rotate-45 scale-pulse" style="animation-delay: 0s;"></div>
                    </div>
                    <div class="absolute top-1/3 left-16">
                        <div class="w-8 h-8 bg-white/10 rounded-full scale-pulse" style="animation-delay: 1s;"></div>
                    </div>
                    <div class="absolute bottom-1/3 left-12">
                        <div class="w-6 h-6 border border-white/15 rotate-slow"></div>
                    </div>
                    
                    <!-- Right Side Decorations -->
                    <div class="absolute top-1/2 right-8 transform -translate-y-1/2">
                        <div class="w-16 h-16 border border-white/20 rounded-2xl -rotate-45 scale-pulse" style="animation-delay: 0.5s;"></div>
                    </div>
                    <div class="absolute top-1/4 right-16">
                        <div class="w-10 h-10 bg-white/8 rounded-full scale-pulse" style="animation-delay: 1.5s;"></div>
                    </div>
                    <div class="absolute bottom-1/4 right-12">
                        <div class="w-8 h-8 border border-white/15 rounded-lg rotate-slow" style="animation-delay: 0.8s;"></div>
                    </div>
                </div>
                
                <!-- Top Decorative Border -->
                <div class="absolute -top-2 left-1/2 transform -translate-x-1/2 flex items-center gap-2" data-aos="fade-down" data-aos-delay="400">
                    <div class="w-8 h-0.5 bg-gradient-to-r from-transparent via-white/40 to-white/60 rounded-full slide-in-left"></div>
                    <div class="w-3 h-3 bg-white/30 rounded-full pulse-glow"></div>
                    <div class="w-16 h-0.5 bg-gradient-to-r from-white/60 via-white/40 to-white/60 rounded-full"></div>
                    <div class="w-3 h-3 bg-white/30 rounded-full pulse-glow" style="animation-delay: 0.5s;"></div>
                    <div class="w-8 h-0.5 bg-gradient-to-r from-white/60 via-white/40 to-transparent rounded-full slide-in-right"></div>
                </div>
                
                <!-- Page Icon with Enhanced Decoration -->
                @hasSection('page-icon')
                    <div class="mb-8 relative" data-aos="zoom-in" data-aos-delay="300">
                        <!-- Icon Background Ring -->
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-32 h-32 border border-white/10 rounded-full rotate-slow"></div>
                        </div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-24 h-24 border border-white/15 rounded-full rotate-slow" style="animation-direction: reverse; animation-duration: 15s;"></div>
                        </div>
                        
                        <!-- Main Icon Container -->
                        <div class="relative inline-flex items-center justify-center w-20 h-20 bg-white/20 backdrop-blur-sm border border-white/30 rounded-2xl shadow-lg floating-animation pulse-glow">
                            <i class="@yield('page-icon') text-3xl text-white"></i>
                        </div>
                        
                        <!-- Corner Decorations -->
                        <div class="absolute -top-2 -left-2 w-4 h-4 bg-white/20 rounded-full scale-pulse"></div>
                        <div class="absolute -top-2 -right-2 w-3 h-3 bg-white/25 rounded-full scale-pulse" style="animation-delay: 0.5s;"></div>
                        <div class="absolute -bottom-2 -left-2 w-3 h-3 bg-white/25 rounded-full scale-pulse" style="animation-delay: 1s;"></div>
                        <div class="absolute -bottom-2 -right-2 w-4 h-4 bg-white/20 rounded-full scale-pulse" style="animation-delay: 1.5s;"></div>
                    </div>
                @endif
                
                <!-- Main Title with Rich Decoration -->
                <div class="mb-8 relative" data-aos="fade-up" data-aos-delay="500">
                    <!-- Title Background Decoration -->
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-full max-w-4xl h-px bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
                    </div>
                    
                    <h1 class="relative text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-3 title-glow">
                        <span class="bg-gradient-to-r from-white via-white to-white/90 bg-clip-text text-transparent">
                            @yield('page-title')
                        </span>
                    </h1>
                    
                    <!-- Title Side Decorations -->
                    <div class="absolute top-1/2 left-0 transform -translate-y-1/2 -translate-x-16 hidden lg:block">
                        <div class="flex items-center gap-2 slide-in-left">
                            <div class="w-8 h-px bg-white/40"></div>
                            <div class="w-2 h-2 bg-white/50 rounded-full"></div>
                        </div>
                    </div>
                    <div class="absolute top-1/2 right-0 transform -translate-y-1/2 translate-x-16 hidden lg:block">
                        <div class="flex items-center gap-2 slide-in-right">
                            <div class="w-2 h-2 bg-white/50 rounded-full"></div>
                            <div class="w-8 h-px bg-white/40"></div>
                        </div>
                    </div>
                    
                    <!-- Subtitle/Category with Enhanced Design -->
                    @hasSection('page-subtitle')
                        <div class="mt-4 relative" data-aos="fade-up" data-aos-delay="600">
                            <!-- Subtitle Background -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-32 h-px bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
                            </div>
                            
                            <span class="relative inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm border border-white/30 text-white px-6 py-3 rounded-full text-sm font-semibold tracking-wider uppercase shadow-lg gradient-border hover:scale-105 transition-transform duration-300">
                                <div class="w-1 h-1 bg-white/60 rounded-full"></div>
                                @yield('page-subtitle')
                                <div class="w-1 h-1 bg-white/60 rounded-full"></div>
                            </span>
                        </div>
                    @endif
                </div>
                
                <!-- Description with Side Decorations -->
                <div class="max-w-4xl mx-auto relative" data-aos="fade-up" data-aos-delay="700">
                    <!-- Description Side Lines -->
                    <div class="absolute top-0 left-0 w-px h-full bg-gradient-to-b from-transparent via-white/20 to-transparent hidden md:block"></div>
                    <div class="absolute top-0 right-0 w-px h-full bg-gradient-to-b from-transparent via-white/20 to-transparent hidden md:block"></div>
                    
                    <p class="text-lg md:text-xl text-white/95 leading-relaxed font-medium px-4">
                        @yield('page-description')
                    </p>
                    
                    <!-- Additional Info with Enhanced Layout -->
                    @hasSection('page-info')
                        <div class="mt-6 relative" data-aos="fade-up" data-aos-delay="800">
                            <!-- Info Background -->
                            <div class="absolute inset-0 bg-white/5 backdrop-blur-sm rounded-xl border border-white/10"></div>
                            
                            <div class="relative flex flex-wrap items-center justify-center gap-6 text-white/80 text-sm py-4 px-6">
                                @yield('page-info')
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- Enhanced Bottom Decoration -->
                <div class="mt-10 flex items-center justify-center relative" data-aos="fade-up" data-aos-delay="900">
                    <!-- Main decorative line -->
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-0.5 bg-gradient-to-r from-transparent via-white/60 to-white/40 rounded-full slide-in-left"></div>
                        <div class="w-2 h-2 bg-white/60 rounded-full pulse-glow"></div>
                        <div class="w-20 h-0.5 bg-gradient-to-r from-white/40 via-white/60 to-white/40 rounded-full"></div>
                        <div class="w-3 h-3 bg-white/50 rounded-full scale-pulse"></div>
                        <div class="w-20 h-0.5 bg-gradient-to-r from-white/40 via-white/60 to-white/40 rounded-full"></div>
                        <div class="w-2 h-2 bg-white/60 rounded-full pulse-glow" style="animation-delay: 0.5s;"></div>
                        <div class="w-12 h-0.5 bg-gradient-to-r from-white/40 via-white/60 to-transparent rounded-full slide-in-right"></div>
                    </div>
                    
                    <!-- Bottom corner decorations -->
                    <div class="absolute -bottom-4 left-1/2 transform -translate-x-1/2 flex gap-8">
                        <div class="w-1 h-1 bg-white/30 rounded-full particle-float" style="animation-delay: 5s;"></div>
                        <div class="w-1 h-1 bg-white/30 rounded-full particle-float" style="animation-delay: 5.5s;"></div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white text-dark py-10 border-t border-gray-200">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h5 class="text-xl font-bold mb-4">Laboratorium Fisika Medis dan Aplikasi Nuklir</h5>
                    <p>Universitas Syiah Kuala</p>
                    <p class="mt-2">Gedung Fakultas MIPA, Blok F Lantai 2</p>
                    <p class="mt-2">Jl. Syech Abdurrauf No. 3</p>
                    <p class="mt-2">Kopelma Darussalam, Banda Aceh, 23111</p>
                    <p class="mt-2">ACEH - INDONESIA</p>
                </div>
                <div>
                    <h5 class="text-xl font-bold mb-4">Tautan Cepat</h5>
                    <ul class="space-y-2">
                        <li><a href="/#about" class="hover:text-secondary transition-colors">Tentang</a></li>
                        <li><a href="{{ route('staff') }}" class="hover:text-secondary transition-colors">Staff dan Ahli</a></li>
                        <li><a href="{{ route('article.index') }}" class="hover:text-secondary transition-colors">Artikel</a></li>
                        <li><a href="/#services" class="hover:text-secondary transition-colors">Layanan</a></li>
                        <li><a href="/#gallery" class="hover:text-secondary transition-colors">Galeri</a></li>
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