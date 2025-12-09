<!-- Dashboard Tab Component -->
<div id="dashboard-tab" class="tab-content active">
    @include('admin.components.shared.welcome-section')

    <!-- Enhanced Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Alat Card -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Alat</p>
                    <p class="text-3xl font-bold">{{ $stats['total_alat'] ?? 0 }}</p>
                    <p class="text-blue-100 text-sm mt-1">
                        <span class="text-green-300">{{ $stats['total_tersedia'] ?? 0 }}</span> tersedia
                    </p>
                </div>
                <div class="bg-blue-400 bg-opacity-30 rounded-full p-3">
                    <i class="fas fa-microscope text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Peminjaman Card -->
        <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-100 text-sm font-medium">Total Peminjaman</p>
                    <p class="text-3xl font-bold">{{ $stats['total_peminjaman'] ?? 0 }}</p>
                    <p class="text-emerald-100 text-sm mt-1">
                        <span class="text-yellow-300">{{ $peminjamanStats['Dipinjam'] ?? 0 }}</span> aktif
                    </p>
                </div>
                <div class="bg-emerald-400 bg-opacity-30 rounded-full p-3">
                    <i class="fas fa-handshake text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Kunjungan Card -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Total Kunjungan</p>
                    <p class="text-3xl font-bold">{{ $stats['total_kunjungan'] ?? 0 }}</p>
                    <p class="text-purple-100 text-sm mt-1">
                        <span class="text-yellow-300">{{ $kunjunganByStatus['PENDING'] ?? 0 }}</span> menunggu
                    </p>
                </div>
                <div class="bg-purple-400 bg-opacity-30 rounded-full p-3">
                    <i class="fas fa-users text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- System Health Card -->
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-medium">Sistem Status</p>
                    <p class="text-3xl font-bold">Sehat</p>
                    <p class="text-orange-100 text-sm mt-1">
                        <span class="text-green-300">{{ $stats['total_artikel'] ?? 0 }}</span> artikel
                    </p>
                </div>
                <div class="bg-orange-400 bg-opacity-30 rounded-full p-3">
                    <i class="fas fa-heart text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Kunjungan Trend Chart -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Trend Kunjungan (6 Bulan Terakhir)</h3>
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                    <span class="text-sm text-gray-600">Kunjungan</span>
                </div>
            </div>
            <div class="relative h-64">
                <canvas id="kunjunganChart"></canvas>
            </div>
        </div>

        <!-- Peminjaman Trend Chart -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Trend Peminjaman (6 Bulan Terakhir)</h3>
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-emerald-500 rounded-full"></div>
                    <span class="text-sm text-gray-600">Peminjaman</span>
                </div>
            </div>
            <div class="relative h-64">
                <canvas id="peminjamanChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Status Distribution and Top Equipment -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <!-- Kunjungan Status Pie Chart -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Status Kunjungan</h3>
            <div class="relative h-64">
                <canvas id="kunjunganStatusChart"></canvas>
            </div>
        </div>

        <!-- Peminjaman Status Pie Chart -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Status Peminjaman</h3>
            <div class="relative h-64">
                <canvas id="peminjamanStatusChart"></canvas>
            </div>
        </div>

        <!-- Top 5 Alat Populer -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Alat Terpopuler</h3>
            <div class="space-y-4">
                @foreach($topAlat as $index => $alat)
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white text-sm font-bold">
                            {{ $index + 1 }}
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ Str::limit($alat['nama'], 20) }}</p>
                            <p class="text-sm text-gray-500">{{ $alat['count'] }} kali dipinjam</p>
                        </div>
                    </div>
                    <div class="w-16 bg-gray-200 rounded-full h-2">
                        @php
                            $maxCount = $topAlat->count() > 0 && $topAlat->first()['count'] > 0 ? $topAlat->first()['count'] : 1;
                            $percentage = ($alat['count'] / $maxCount) * 100;
                        @endphp
                        <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-2 rounded-full" 
                            style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
                @endforeach
                
                @if($topAlat->count() == 0)
                <div class="text-center py-8">
                    <i class="fas fa-chart-bar text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">Belum ada data peminjaman</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Aktivitas Terbaru</h3>
            <a href="#" @click="currentTab = 'visits'" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Lihat Semua</a>
        </div>
        
        <div class="space-y-4">
            @foreach($recent_visits->take(5) as $visit)
            <div class="flex items-start space-x-4 p-4 rounded-lg hover:bg-gray-50 transition-colors">
                <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-users text-purple-600"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900">Kunjungan baru dari {{ $visit->namaPengunjung }}</p>
                    <p class="text-sm text-gray-500">{{ $visit->namaInstansi ?? 'Instansi tidak disebutkan' }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $visit->created_at->diffForHumans() }}</p>
                </div>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                    {{ $visit->status === 'PENDING' ? 'bg-yellow-100 text-yellow-800' : '' }}
                    {{ $visit->status === 'PROCESSING' ? 'bg-blue-100 text-blue-800' : '' }}
                    {{ $visit->status === 'COMPLETED' ? 'bg-green-100 text-green-800' : '' }}
                    {{ $visit->status === 'CANCELLED' ? 'bg-red-100 text-red-800' : '' }}">
                    {{ $visit->status_label }}
                </span>
            </div>
            @endforeach

            @foreach($recent_rentals->take(3) as $rental)
            <div class="flex items-start space-x-4 p-4 rounded-lg hover:bg-gray-50 transition-colors">
                <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-handshake text-emerald-600"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900">Peminjaman baru dari {{ $rental->namaPeminjam }}</p>
                    <p class="text-sm text-gray-500">{{ $rental->peminjamanItems->count() }} alat dipinjam</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $rental->created_at->diffForHumans() }}</p>
                </div>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                    {{ $rental->status === 'Menunggu' ? 'bg-yellow-100 text-yellow-800' : '' }}
                    {{ $rental->status === 'Disetujui' ? 'bg-blue-100 text-blue-800' : '' }}
                    {{ $rental->status === 'Dipinjam' ? 'bg-purple-100 text-purple-800' : '' }}
                    {{ $rental->status === 'Selesai' ? 'bg-green-100 text-green-800' : '' }}
                    {{ $rental->status === 'Ditolak' ? 'bg-red-100 text-red-800' : '' }}">
                    {{ $rental->status }}
                </span>
            </div>
            @endforeach

            @if($recent_visits->count() == 0 && $recent_rentals->count() == 0)
            <div class="text-center py-8">
                <i class="fas fa-bell text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">Belum ada aktivitas terbaru</p>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart.js configuration
    Chart.defaults.font.family = 'Inter, sans-serif';
    Chart.defaults.color = '#6B7280';

    // Kunjungan Trend Chart
    const kunjunganCtx = document.getElementById('kunjunganChart').getContext('2d');
    const kunjunganData = @json($kunjunganChart);
    
    new Chart(kunjunganCtx, {
        type: 'line',
        data: {
            labels: kunjunganData.map(item => item.month),
            datasets: [{
                label: 'Kunjungan',
                data: kunjunganData.map(item => item.count),
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'rgb(59, 130, 246)',
                pointBorderColor: 'white',
                pointBorderWidth: 2,
                pointRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Peminjaman Trend Chart
    const peminjamanCtx = document.getElementById('peminjamanChart').getContext('2d');
    const peminjamanData = @json($peminjamanChart);
    
    new Chart(peminjamanCtx, {
        type: 'bar',
        data: {
            labels: peminjamanData.map(item => item.month),
            datasets: [{
                label: 'Peminjaman',
                data: peminjamanData.map(item => item.count),
                backgroundColor: 'rgba(16, 185, 129, 0.8)',
                borderColor: 'rgb(16, 185, 129)',
                borderWidth: 1,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Kunjungan Status Pie Chart
    const kunjunganStatusCtx = document.getElementById('kunjunganStatusChart').getContext('2d');
    const kunjunganStatusData = @json($kunjunganByStatus);
    
    new Chart(kunjunganStatusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Menunggu', 'Disetujui', 'Selesai', 'Dibatalkan'],
            datasets: [{
                data: [
                    kunjunganStatusData.PENDING,
                    kunjunganStatusData.PROCESSING,
                    kunjunganStatusData.COMPLETED,
                    kunjunganStatusData.CANCELLED
                ],
                backgroundColor: [
                    '#F59E0B',
                    '#3B82F6', 
                    '#10B981',
                    '#EF4444'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                }
            }
        }
    });

    // Peminjaman Status Pie Chart
    const peminjamanStatusCtx = document.getElementById('peminjamanStatusChart').getContext('2d');
    const peminjamanStatusData = @json($peminjamanByStatus);
    
    new Chart(peminjamanStatusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Menunggu', 'Disetujui', 'Dipinjam', 'Selesai', 'Ditolak'],
            datasets: [{
                data: [
                    peminjamanStatusData.Menunggu,
                    peminjamanStatusData.Disetujui,
                    peminjamanStatusData.Dipinjam,
                    peminjamanStatusData.Selesai,
                    peminjamanStatusData.Ditolak
                ],
                backgroundColor: [
                    '#F59E0B',
                    '#3B82F6',
                    '#8B5CF6',
                    '#10B981',
                    '#EF4444'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 15,
                        font: {
                            size: 11
                        }
                    }
                }
            }
        }
    });
});
</script> 