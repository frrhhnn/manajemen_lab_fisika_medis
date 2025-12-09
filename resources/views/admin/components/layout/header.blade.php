<!-- Header Component -->
<header class="bg-gradient-to-r from-emerald-900 to-emerald-800 shadow-lg border-b border-emerald-700/30 sticky top-0 z-30">
    <div class="flex items-center justify-between h-20 px-6">
        <!-- Left Section -->
        <div class="flex items-center">
            <!-- Mobile Menu Button -->
            <button @click="sidebarOpen = !sidebarOpen" 
                    class="lg:hidden p-2 rounded-lg text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200">
                <i class="fas fa-bars text-lg"></i>
            </button>
            
            <!-- Page Title -->
            <div class="flex items-center">
                <div>
                    <h1 id="page-title" class="text-lg font-semibold text-white">{{ $title ?? 'Dashboard' }}</h1>
                    <p class="text-xs text-white/70">Laboratorium Fisika Medis</p>
                </div>
            </div>
        </div>
        
        <!-- Right Section -->
        <div class="flex items-center space-x-4">
            <!-- User Profile -->
            <div class="flex items-center space-x-3">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-white/70">Administrator</p>
                </div>
                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center border-2 border-white/30">
                    <span class="text-white font-semibold text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                </div>
            </div>
            
            <!-- Logout Button -->
            <form id="logout-form" method="POST" action="{{ route('logout') }}" class="ml-2" style="display: none;">
                @csrf
            </form>
            <button onclick="confirmLogout()" class="p-2 px-4 bg-red-500/90 rounded-lg text-white hover:bg-red-500 transition-all duration-200" title="Logout">
                <i class="fas fa-sign-out-alt text-lg"></i>
                Logout
            </button>
        </div>
    </div>
</header>