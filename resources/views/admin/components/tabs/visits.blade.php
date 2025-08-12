<!-- Equipment Rentals Tab Component -->
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Kelola Kunjungan</h2>
                <p class="mt-1 text-sm text-gray-600">Kelola semua kunjungan laboratorium</p>
            </div>
            <div class="mt-4 sm:mt-0 flex gap-3">
                <button type="button" onclick="refreshVisitData()" 
                        class="btn rounded-lg py-2 px-4 bg-blue-500 text-white hover:bg-blue-600">
                    <i class="fas fa-sync-alt pr-2"></i>
                    Refresh
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
        @include('admin.components.shared.stat-card', [
            'icon' => 'clock',
            'bgColor' => 'bg-yellow-100',
            'iconColor' => 'text-yellow-600',
            'textColor' => 'text-yellow-600',
            'title' => 'Menunggu',
            'value' => $kunjungan->where('status', 'PENDING')->count() ?? 0
        ])

        @include('admin.components.shared.stat-card', [
            'icon' => 'spinner',
            'bgColor' => 'bg-blue-100',
            'iconColor' => 'text-blue-600',
            'textColor' => 'text-blue-600',
            'title' => 'Disetujui',
            'value' => $kunjungan->where('status', 'PROCESSING')->count() ?? 0
        ])

        @include('admin.components.shared.stat-card', [
            'icon' => 'check-circle',
            'bgColor' => 'bg-green-100',
            'iconColor' => 'text-green-600',
            'textColor' => 'text-green-600',
            'title' => 'Selesai',
            'value' => $kunjungan->where('status', 'COMPLETED')->count() ?? 0
        ])

        @include('admin.components.shared.stat-card', [
            'icon' => 'times-circle',
            'bgColor' => 'bg-red-100',
            'iconColor' => 'text-red-600',
            'textColor' => 'text-red-600',
            'title' => 'Dibatalkan',
            'value' => $kunjungan->where('status', 'CANCELLED')->count() ?? 0
        ])

        @include('admin.components.shared.stat-card', [
            'icon' => 'calendar',
            'bgColor' => 'bg-indigo-100',
            'iconColor' => 'text-indigo-600',
            'textColor' => 'text-indigo-600',
            'title' => 'Total',
            'value' => $kunjungan->count() ?? 0
        ])

        @include('admin.components.shared.stat-card', [
            'icon' => 'users',
            'bgColor' => 'bg-purple-100',
            'iconColor' => 'text-purple-600',
            'textColor' => 'text-purple-600',
            'title' => 'Total Peserta',
            'value' => $kunjungan->sum('jumlahPengunjung') ?? 0
        ])
    </div>

    <!-- Visits Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Kunjungan Laboratorium</h3>
                <div class="flex items-center gap-4">
                    <!-- Filter Status -->
                    <select id="statusFilter" onchange="filterByStatus()" class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="">Semua Status</option>
                        <option value="PENDING">Menunggu</option>
                        <option value="PROCESSING">Disetujui</option>
                        <option value="COMPLETED">Selesai</option>
                        <option value="CANCELLED">Dibatalkan</option>
                    </select>
                    
                    <!-- Search -->
                    <div class="relative">
                        <input type="text" id="searchVisit" oninput="searchVisit()" placeholder="Cari nama/no hp..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Content -->
        <div class="overflow-x-auto">
            <table class="w-full min-w-full" id="visitTable">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengunjung</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Kunjungan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jadwal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pengajuan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peserta</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($kunjungan as $visit)
                        <tr class="hover:bg-gray-50" data-status="{{ $visit->status }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $visit->namaPengunjung }}</div>
                                <div class="text-sm text-gray-500">{{ $visit->noHp }}</div>
                                @if($visit->namaInstansi)
                                    <div class="text-sm text-gray-500">{{ $visit->namaInstansi }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-mono text-gray-900">{{ Str::limit($visit->id, 8) }}</div>
                                <div class="text-sm text-gray-500">{{ $visit->created_at->format('d/m/Y H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($visit->jadwal)
                                    <div>Tanggal: {{ $visit->jadwal->tanggal->format('d/m/Y') }}</div>
                                    <div>Waktu: {{ $visit->jadwal->time_label }}</div>
                                    <div class="text-xs text-gray-500">{{ $visit->jadwal->waktuKunjungan }}</div>
                                @else
                                    <span class="text-sm text-gray-500">Jadwal tidak tersedia</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div>{{ $visit->created_at->format('d/m/Y') }}</div>
                                <div class="text-sm text-gray-500">{{ $visit->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $visit->jumlahPengunjung }} orang</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col gap-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $visit->status === 'PENDING' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $visit->status === 'PROCESSING' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $visit->status === 'COMPLETED' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $visit->status === 'CANCELLED' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ $visit->status_label }}
                                    </span>
                                </div>
                            </td>
                            <td class="flex px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex flex-col gap-2">
                                    <!-- View Details -->
                                    <button onclick="viewVisitDetail('{{ $visit->id }}')" 
                                            class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 transition-colors">
                                        <i class="fas fa-eye mr-1"></i>
                                        Detail
                                    </button>
                                    
                                    @if($visit->canBeApproved())
                                        <button onclick="approveVisit('{{ $visit->id }}')" 
                                                class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded-md hover:bg-green-200 transition-colors" 
                                                title="Approve">
                                            <i class="fas fa-check mr-1"></i>
                                            Setujui
                                        </button>
                                    @endif

                                    @if($visit->canBeCompleted())
                                        <button onclick="completeVisit('{{ $visit->id }}')"
                                                class="inline-flex items-center px-3 py-1 bg-indigo-100 text-indigo-700 rounded-md hover:bg-indigo-200 transition-colors">
                                            <i class="fas fa-check-double mr-1"></i>
                                            Selesai
                                        </button>
                                    @endif

                                    @if($visit->canBeCancelled())
                                        <button onclick="rejectVisit('{{ $visit->id }}')"
                                                class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded-md hover:bg-red-200 transition-colors">
                                            <i class="fas fa-times mr-1"></i>
                                            Tolak
                                        </button>
                                    @endif

                                    @if($visit->status === 'PROCESSING')
                                        <button onclick="generateWhatsAppTemplate('{{ $visit->id }}', '{{ $visit->namaPengunjung }}', '{{ $visit->noHp }}', '{{ $visit->status }}')"
                                                class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded-md hover:bg-green-200 transition-colors">
                                            <i class="fab fa-whatsapp mr-1"></i>
                                            WhatsApp
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                Tidak ada kunjungan ditemukan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Visit Detail Modal -->
<div id="visitDetailModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Detail Kunjungan</h3>
                    <button onclick="closeVisitDetailModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div id="visitDetailContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Global variables
let currentVisitId = null;

// Debug: Check if we're on the correct URL
console.log('Current URL:', window.location.href);
console.log('Admin visits tab script loaded');

// Search functionality
function searchVisit() {
    const searchTerm = document.getElementById('searchVisit').value.toLowerCase();
    const rows = document.querySelectorAll('#visitTable tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
}

// Filter by status
function filterByStatus() {
    const status = document.getElementById('statusFilter').value;
    const rows = document.querySelectorAll('#visitTable tbody tr');
    
    rows.forEach(row => {
        if (!status) {
            row.style.display = '';
        } else {
            row.style.display = row.dataset.status === status ? '' : 'none';
        }
    });
}

// View visit detail
function viewVisitDetail(visitId) {
    document.getElementById('visitDetailModal').classList.remove('hidden');
    
    fetch(`/admin/kunjungan/${visitId}/detail`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('visitDetailContent').innerHTML = data.html;
        })
        .catch(error => {
            document.getElementById('visitDetailContent').innerHTML = `
                <div class="text-center py-12">
                    <i class="fas fa-exclamation-triangle text-4xl text-red-300 mb-4"></i>
                    <p class="text-red-500">Gagal memuat detail</p>
                </div>
            `;   
        });
}

function closeVisitDetailModal() {
    document.getElementById('visitDetailModal').classList.add('hidden');
}

// Approve visit
function approveVisit(visitId) {
    Swal.fire({
        title: 'Konfirmasi',
        text: 'Apakah Anda yakin ingin menyetujui kunjungan ini?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10B981',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Ya, Setujui',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            console.log('Approving visit ID:', visitId);
            const url = `/admin/kunjungan/${visitId}/approve`;
            console.log('Fetch URL:', url);
            
            // Show loading state
            Swal.fire({
                title: 'Memproses...',
                text: 'Menyetujui kunjungan',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            fetch(url, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response URL:', response.url);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Kunjungan disetujui',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    refreshVisitData();
                } else {
                    Swal.fire({
                        title: 'Gagal!',
                        text: data.message || 'Gagal menyetujui kunjungan',
                        icon: 'error'
                    });
                }
            })
            .catch(error => {
                console.error('Approve error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: `Terjadi kesalahan: ${error.message}`,
                    icon: 'error'
                });
            });
        }
    });
}

// Reject visit (was previously named cancelVisit)
function rejectVisit(visitId) {
    Swal.fire({
        title: 'Konfirmasi',
        text: 'Apakah Anda yakin ingin menolak kunjungan ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#EF4444',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Ya, Tolak',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading state
            Swal.fire({
                title: 'Memproses...',
                text: 'Menolak kunjungan',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            fetch(`/admin/kunjungan/${visitId}/reject`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Kunjungan ditolak',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    refreshVisitData();
                } else {
                    Swal.fire({
                        title: 'Gagal!',
                        text: data.message || 'Gagal menolak kunjungan',
                        icon: 'error'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat menolak kunjungan',
                    icon: 'error'
                });
            });
        }
    });
}

// Complete visit
function completeVisit(visitId) {
    Swal.fire({
        title: 'Konfirmasi',
        text: 'Apakah Anda yakin ingin menyelesaikan kunjungan ini?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10B981',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Ya, Selesai',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading state
            Swal.fire({
                title: 'Memproses...',
                text: 'Menyelesaikan kunjungan',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            fetch(`/admin/kunjungan/${visitId}/complete`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Kunjungan selesai',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    refreshVisitData();
                } else {
                    Swal.fire({
                        title: 'Gagal!',
                        text: data.message || 'Gagal menyelesaikan kunjungan',
                        icon: 'error'
                    });
                }
            })
            .catch(error => {
                console.error('Complete error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: `Terjadi kesalahan: ${error.message}`,
                    icon: 'error'
                });
            });
        }
    });
}

// Generate WhatsApp template
function generateWhatsAppTemplate(visitId, nama, noHp, status) {
    let message = '';
    
    if (status === 'PROCESSING') {
        message = `Hello ${nama},

Kunjungan Anda telah disetujui!

📋 Visit ID: ${visitId}
✅ Status: Disetujui

Silakan datang ke laboratorium sesuai jadwal yang telah ditentukan.

Terima kasih!

Admin Lab. Fisika Medis USK`;
    }
    
    // Remove country code if exists
    const phoneNumber = noHp.startsWith('0') ? '62' + noHp.substring(1) : noHp;
    const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
    
    window.open(whatsappUrl, '_blank');
}

// Refresh data
function refreshVisitData() {
    location.reload();
}

// Show notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 ${
        type === 'success' ? 'bg-green-500 text-white' : 
        type === 'error' ? 'bg-red-500 text-white' : 
        'bg-blue-500 text-white'
    }`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Make functions globally available
window.approveVisit = approveVisit;
window.rejectVisit = rejectVisit;
window.completeVisit = completeVisit;
window.viewVisitDetail = viewVisitDetail;
window.closeVisitDetailModal = closeVisitDetailModal;
window.refreshVisitData = refreshVisitData;
window.generateWhatsAppTemplate = generateWhatsAppTemplate;
window.showNotification = showNotification;
window.searchVisit = searchVisit;
window.filterByStatus = filterByStatus;

console.log('Admin visit functions made globally available:', {
    approveVisit: typeof window.approveVisit,
    rejectVisit: typeof window.rejectVisit,
    completeVisit: typeof window.completeVisit,
    showNotification: typeof window.showNotification
});
</script>
