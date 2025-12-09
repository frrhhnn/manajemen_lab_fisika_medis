<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - Laboratorium Fisika Medis</title>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    
    <!-- SweetAlert2 Custom Styles -->
    <style>
        .swal-btn-confirm {
            background-color: #dc2626 !important;
            border-color: #dc2626 !important;
        }
        .swal-btn-confirm:hover {
            background-color: #b91c1c !important;
            border-color: #b91c1c !important;
        }
        .swal-btn-cancel {
            background-color: #6b7280 !important;
            border-color: #6b7280 !important;
        }
        .swal-btn-cancel:hover {
            background-color: #4b5563 !important;
            border-color: #4b5563 !important;
        }
    </style>
    
    @yield('head')
</head>
<body class="bg-gray-50" x-data="{ 
    currentTab: 'dashboard',
    sidebarOpen: false,
    showModal: false,
    modalTitle: '',
    modalContent: '',
    showNotifications: false
}">
    <!-- Mobile Sidebar Overlay -->
    <div 
      x-show="sidebarOpen" 
      x-transition:enter="transition-opacity ease-linear duration-300"
      x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition-opacity ease-linear duration-300"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0"
      @click="sidebarOpen = false"
      class="fixed inset-0 bg-gray-600 bg-opacity-75 z-40 lg:hidden"></div>

    <!-- Include Sidebar -->
    @include('admin.components.layout.sidebar')

    <!-- Main Content -->
    <div class="lg:pl-80">
        <!-- Include Header -->
        @include('admin.components.layout.header', ['title' => $pageTitle ?? 'Dashboard'])

        <!-- Content Area -->
        <main class="p-6 bg-gray-50 min-h-screen">
            @yield('content')

            <!-- Dashboard Tab -->
            <div id="dashboard-tab" class="tab-content" x-show="currentTab === 'dashboard'" x-transition>
                @include('admin.components.tabs.dashboard')
            </div>

            <!-- Equipment Tab -->
            <div id="equipment-tab" class="tab-content" x-show="currentTab === 'equipment'" x-transition>
                @include('admin.components.tabs.equipment')
            </div>

            <!-- Rentals Tab -->
            <div id="rentals-tab" class="tab-content" x-show="currentTab === 'rentals'" x-transition>
                @include('admin.components.tabs.rentals')
            </div>

            <!-- Visits Tab -->
            <div id="visits-tab" class="tab-content" x-show="currentTab === 'visits'" x-transition>
                @include('admin.components.tabs.visits')
            </div>

            <!-- Schedule Tab -->
            <div id="schedule-tab" class="tab-content" x-show="currentTab === 'schedule'" x-transition>
                @include('admin.components.tabs.schedule', ['currentMonth' => $currentMonth])
            </div>

            <!-- Staff Tab -->
            <div id="staff-tab" class="tab-content" x-show="currentTab === 'staff'" x-transition>
                @include('admin.components.tabs.staff')
            </div>

            <!-- Vision Mission Tab -->
            <div id="vision-mission-tab" class="tab-content" x-show="currentTab === 'vision-mission'" x-transition>
                @include('admin.components.tabs.vision-mission')
            </div>

            <!-- Article Tab -->
            <div id="article-tab" class="tab-content" x-show="currentTab === 'article'" x-transition>
                @include('admin.components.tabs.article')
            </div>

            <!-- Gallery Tab -->
            <div id="gallery-tab" class="tab-content" x-show="currentTab === 'gallery'" x-transition>
                @include('admin.components.tabs.gallery')
            </div>

            @if(auth()->user()->isSuperAdmin())
            <!-- Manage Admins Tab (Only for Super Admin) -->
            <div id="manage-admins-tab" class="tab-content" x-show="currentTab === 'manage-admins'" x-transition>
                @include('admin.components.tabs.manage-admins')
            </div>
            @endif

        </main>
    </div>

    <!-- Modal Container -->
    <div x-show="showModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto">
        
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>

        <!-- Modal panel -->
        <div class="flex min-h-screen items-center justify-center p-4">
            <div x-show="showModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative transform overflow-hidden rounded-lg bg-white shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                
                <!-- Modal content -->
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left">
                            <h3 class="text-lg font-medium leading-6 text-gray-900" x-text="modalTitle"></h3>
                            <div class="mt-2" x-html="modalContent"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Modal footer -->
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" 
                            class="inline-flex w-full justify-center rounded-md border border-transparent bg-green-500 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm"
                            @click="showModal = false">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification Panel -->
    <div x-show="showNotifications"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-95"
         @click.away="showNotifications = false"
         class="absolute right-0 mt-2 w-80 rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5">
        <!-- Notification items will be dynamically loaded here -->
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/admin-dashboard.js') }}"></script>
    
    <!-- SweetAlert for Session Messages -->
    @if(session('success'))
    <script>
        Swal.fire({
          icon: 'success',
          title: 'Berhasil!',
          text: @json(session('success')),
          confirmButtonColor: '#10b981'
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: @json(session('error')),
          confirmButtonColor: '#10b981'
        });
    </script>
    @endif
    
    <!-- Mobile Sidebar Script -->
    <script>
        // Ensure sidebar functionality works on mobile
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-close sidebar when clicking on nav items on mobile
            const navItems = document.querySelectorAll('.nav-item');
            navItems.forEach(item => {
                item.addEventListener('click', function() {
                    if (window.innerWidth < 1024) { // lg breakpoint
                        // Close sidebar on mobile after navigation
                        setTimeout(() => {
                            window.Alpine?.store?.().sidebarOpen = false;
                        }, 300);
                    }
                });
            });
        });
    </script>
    
    <!-- Logout Confirmation Script -->
    <script>
        function confirmLogout() {
            Swal.fire({
                title: 'Konfirmasi Logout',
                text: 'Apakah Anda yakin ingin keluar dari sistem?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'swal-btn-confirm',
                    cancelButton: 'swal-btn-cancel'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Logging out...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Submit logout form
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>
    
    @stack('scripts')
</body>
</html>