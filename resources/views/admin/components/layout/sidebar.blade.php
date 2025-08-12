<!-- Sidebar Component -->
<div id="sidebar" 
     class="fixed inset-y-0 left-0 z-50 w-80 sidebar transform transition-transform duration-300 ease-in-out lg:translate-x-0 bg-gradient-to-b from-emerald-900 via-emerald-800 to-emerald-900 shadow-2xl"
     :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
    
    <!-- Mobile Close Button -->
    <div class="absolute top-4 right-4 lg:hidden">
        <button @click="sidebarOpen = false" 
                class="p-2 rounded-lg text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200">
            <i class="fas fa-times text-lg"></i>
        </button>
    </div>
    <!-- Sidebar Header -->
    <div class="flex items-center justify-center h-20 bg-gradient-to-r from-emerald-900 to-emerald-800 border-b border-white/10">
        <div class="flex items-center justify-center">
            <img src="{{ asset('images/logo/logo-fisika-putih.png') }}" alt="Logo" class="w-auto h-10">
        </div>
    </div>
    
    <!-- Navigation -->
    <nav class="mt-6 px-4 space-y-1">
        <!-- Dashboard -->
        <a href="#" @click="currentTab = 'dashboard'" 
           class="nav-item flex items-center px-4 py-2 rounded-xl transition-all duration-200 group" 
           :class="currentTab === 'dashboard' ? 'bg-white/20 text-white shadow-lg' : 'text-gray-200 hover:bg-white/10 hover:text-white'"
           id="nav-dashboard">
            <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center mr-3 group-hover:bg-white/20 transition-all duration-200">
                <i class="fas fa-chart-pie text-sm"></i>
            </div>
            <span class="font-medium">Dashboard</span>
        </a>

        <!-- Section: Profil dan Publikasi -->
        <div class="mt-4 pt-3">
            <h3 class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Profil dan Publikasi</h3>
            
            <a href="#" @click="currentTab = 'staff'" 
               class="nav-item flex items-center px-4 py-2 rounded-xl transition-all duration-200 group" 
               :class="currentTab === 'staff' ? 'bg-white/20 text-white shadow-lg' : 'text-gray-200 hover:bg-white/10 hover:text-white'"
               id="nav-staff">
                <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center mr-3 group-hover:bg-white/20 transition-all duration-200">
                    <i class="fas fa-user-tie text-sm"></i>
                </div>
                <span class="font-medium">Kelola Staff</span>
            </a>
            
            <a href="#" @click="currentTab = 'vision-mission'" 
               class="nav-item flex items-center px-4 py-2 rounded-xl transition-all duration-200 group" 
               :class="currentTab === 'vision-mission' ? 'bg-white/20 text-white shadow-lg' : 'text-gray-200 hover:bg-white/10 hover:text-white'"
               id="nav-vision-mission">
                <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center mr-3 group-hover:bg-white/20 transition-all duration-200">
                    <i class="fas fa-bullseye text-sm"></i>
                </div>
                <span class="font-medium">Kelola Visi & Misi</span>
            </a>
            
            <a href="#" @click="currentTab = 'article'" 
               class="nav-item flex items-center px-4 py-2 rounded-xl transition-all duration-200 group" 
               :class="currentTab === 'article' ? 'bg-white/20 text-white shadow-lg' : 'text-gray-200 hover:bg-white/10 hover:text-white'"
               id="nav-artikel">
                <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center mr-3 group-hover:bg-white/20 transition-all duration-200">
                    <i class="fas fa-newspaper text-sm"></i>
                </div>
                <span class="font-medium">Kelola Artikel</span>
            </a>
            
            <a href="#" @click="currentTab = 'gallery'" 
               class="nav-item flex items-center px-4 py-2 rounded-xl transition-all duration-200 group" 
               :class="currentTab === 'gallery' ? 'bg-white/20 text-white shadow-lg' : 'text-gray-200 hover:bg-white/10 hover:text-white'"
               id="nav-galeri">
                <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center mr-3 group-hover:bg-white/20 transition-all duration-200">
                    <i class="fas fa-images text-sm"></i>
                </div>
                <span class="font-medium">Kelola Galeri</span>
            </a>
        </div>

        <!-- Section: Sarana dan Penjadwalan -->
        <div class="mt-4 pt-3">
            <h3 class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Sarana dan Penjadwalan</h3>
            
            <a href="#" @click="currentTab = 'equipment'" 
               class="nav-item flex items-center px-4 py-2 rounded-xl transition-all duration-200 group" 
               :class="currentTab === 'equipment' ? 'bg-white/20 text-white shadow-lg' : 'text-gray-200 hover:bg-white/10 hover:text-white'"
               id="nav-equipment">
                <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center mr-3 group-hover:bg-white/20 transition-all duration-200">
                    <i class="fas fa-microscope text-sm"></i>
                </div>
                <span class="font-medium">Kelola Alat Laboratorium</span>
            </a>
            
            <a href="#" @click="currentTab = 'schedule'" 
               class="nav-item flex items-center px-4 py-2 rounded-xl transition-all duration-200 group" 
               :class="currentTab === 'schedule' ? 'bg-white/20 text-white shadow-lg' : 'text-gray-200 hover:bg-white/10 hover:text-white'"
               id="nav-schedule">
                <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center mr-3 group-hover:bg-white/20 transition-all duration-200">
                    <i class="fas fa-calendar-alt text-sm"></i>
                </div>
                <span class="font-medium">Kelola Jadwal Kunjungan</span>
            </a>
        </div>

        <!-- Section: Layanan Laboratorium -->
        <div class="mt-4 pt-3">
            <h3 class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Layanan Laboratorium</h3>
            
            <a href="#" @click="currentTab = 'rentals'" 
               class="nav-item flex items-center px-4 py-2 rounded-xl transition-all duration-200 group" 
               :class="currentTab === 'rentals' ? 'bg-white/20 text-white shadow-lg' : 'text-gray-200 hover:bg-white/10 hover:text-white'"
               id="nav-rentals">
                <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center mr-3 group-hover:bg-white/20 transition-all duration-200">
                    <i class="fas fa-handshake text-sm"></i>
                </div>
                <span class="font-medium">Kelola Peminjaman Alat</span>
            </a>
            
            <a href="#" @click="currentTab = 'visits'" 
               class="nav-item flex items-center px-4 py-2 rounded-xl transition-all duration-200 group" 
               :class="currentTab === 'visits' ? 'bg-white/20 text-white shadow-lg' : 'text-gray-200 hover:bg-white/10 hover:text-white'"
               id="nav-visits">
                <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center mr-3 group-hover:bg-white/20 transition-all duration-200">
                    <i class="fas fa-users text-sm"></i>
                </div>
                <span class="font-medium">Kelola Kunjungan Laboratorium</span>
            </a>
        </div>

        @if(auth()->user()->isSuperAdmin())
        <!-- Section: Manajemen Sistem (Hanya untuk Super Admin) -->
        <div class="mt-4 pt-3">
            <h3 class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Manajemen Sistem</h3>
            
            <a href="#" @click="currentTab = 'manage-admins'" 
               class="nav-item flex items-center px-4 py-2 rounded-xl transition-all duration-200 group" 
               :class="currentTab === 'manage-admins' ? 'bg-white/20 text-white shadow-lg' : 'text-gray-200 hover:bg-white/10 hover:text-white'"
               id="nav-manage-admins">
                <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center mr-3 group-hover:bg-white/20 transition-all duration-200">
                    <i class="fas fa-user-shield text-sm"></i>
                </div>
                <span class="font-medium">Kelola Admin</span>
            </a>
        </div>
        @endif
    </nav>
    
    <!-- Sidebar Footer -->
    <div class="absolute bottom-0 left-0 right-0 p-4">
        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-3 border border-white/20">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-cog text-white text-sm"></i>
                </div>
                <div class="flex-1">
                    <p class="text-xs font-medium text-white">Sistem Admin</p>
                    <p class="text-xs text-white/70">v1.0.0</p>
                </div>
            </div>
        </div>
    </div>
</div>