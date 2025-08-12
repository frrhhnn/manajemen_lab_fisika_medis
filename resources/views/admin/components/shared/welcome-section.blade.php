<!-- Welcome Section Component -->
<div class="bg-gradient-to-r from-emerald-900 to-emerald-800 rounded-2xl p-8 text-white mb-8 card-hover">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}!</h2>
            <p class="text-lg">{{ $subtitle ?? 'Sistem Administrasi Laboratorium Fisika Medis dan Aplikasi Nuklir' }}</p>
            <div class="mt-4 text-sm">
                <i class="fas fa-calendar-alt mr-2"></i>
                {{ now()->format('l, d F Y') }}
            </div>
        </div>
    </div>
</div> 