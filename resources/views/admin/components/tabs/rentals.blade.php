<!-- Equipment Rentals Tab Component -->
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Kelola Peminjaman Alat</h2>
                <p class="mt-1 text-sm text-gray-600">Kelola semua peminjaman alat laboratorium</p>
            </div>
            <div class="mt-4 sm:mt-0 flex gap-3">
                <button type="button" onclick="refreshRentalData()" 
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
            'value' => $peminjamanStats['Menunggu'] ?? 0
        ])

        @include('admin.components.shared.stat-card', [
            'icon' => 'hourglass-half',
            'bgColor' => 'bg-blue-100',
            'iconColor' => 'text-blue-600',
            'textColor' => 'text-blue-600',
            'title' => 'Disetujui',
            'value' => $peminjamanStats['Disetujui'] ?? 0
        ])

        @include('admin.components.shared.stat-card', [
            'icon' => 'handshake',
            'bgColor' => 'bg-indigo-100',
            'iconColor' => 'text-indigo-600',
            'textColor' => 'text-indigo-600',
            'title' => 'Dipinjam',
            'value' => $peminjamanStats['Dipinjam'] ?? 0
        ])

        @include('admin.components.shared.stat-card', [
            'icon' => 'exclamation-triangle',
            'bgColor' => 'bg-orange-100',
            'iconColor' => 'text-orange-600',
            'textColor' => 'text-orange-600',
            'title' => 'Terlambat',
            'value' => $peminjamanStats['Overdue'] ?? 0
        ])
        
        @include('admin.components.shared.stat-card', [
            'icon' => 'check-circle',
            'bgColor' => 'bg-green-100',
            'iconColor' => 'text-green-600',
            'textColor' => 'text-green-600',
            'title' => 'Selesai',
            'value' => $peminjamanStats['Selesai'] ?? 0
        ])

        @include('admin.components.shared.stat-card', [
            'icon' => 'times-circle',
            'bgColor' => 'bg-red-100',
            'iconColor' => 'text-red-600',
            'textColor' => 'text-red-600',
            'title' => 'Ditolak',
            'value' => $peminjamanStats['Ditolak'] ?? 0
        ])
    </div>

    <!-- Rental Requests -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Peminjaman Alat</h3>
                <div class="flex items-center gap-4">
                    <!-- Filter Status -->
                    <select id="statusFilter" onchange="filterByStatus()" class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="">Semua Status</option>
                        <option value="Menunggu">Menunggu</option>
                        <option value="Disetujui">Disetujui</option>
                        <option value="Dipinjam">Dipinjam</option>
                        <option value="Ditolak">Ditolak</option>
                        <option value="Selesai">Selesai</option>
                        <option value="Overdue">Terlambat</option>
                    </select>
                    
                    <!-- Search -->
                    <div class="relative">
                        <input type="text" id="searchRental" oninput="searchRental()" placeholder="Cari nama/no hp..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Content -->
        <div class="overflow-x-auto">
            <table class="w-full min-w-full" id="rentalTable">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjam</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Peminjaman</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($peminjamans ?? [] as $peminjaman)
                    @php
                        $isOverdue = $peminjaman->status === 'Dipinjam' && 
                                    \Carbon\Carbon::parse($peminjaman->tanggal_pengembalian)->isPast();
                    @endphp
                    <tr class="hover:bg-gray-50" data-status="{{ $peminjaman->status }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $peminjaman->namaPeminjam }}</div>
                            <div class="text-sm text-gray-500">{{ $peminjaman->noHp }}</div>
                            @if($peminjaman->is_mahasiswa_usk)
                                <div class="text-sm text-gray-500">NPM/NIM: {{ $peminjaman->npm_nim }}</div>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Mahasiswa USK</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-mono text-gray-900">{{ Str::limit($peminjaman->id, 8) }}</div>
                            <div class="text-sm text-gray-500">{{ $peminjaman->created_at->format('d/m/Y H:i') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="max-w-xs">
                                @foreach($peminjaman->peminjamanItems->take(2) as $item)
                                    <div class="text-sm text-gray-900">{{ $item->alat->nama }} ({{ $item->jumlah }}x)</div>
                                @endforeach
                                @if($peminjaman->peminjamanItems->count() > 2)
                                    <div class="text-sm text-gray-500">+{{ $peminjaman->peminjamanItems->count() - 2 }} more</div>
                                @endif
                                <div class="text-xs text-gray-500 mt-1">Total: {{ $peminjaman->peminjamanItems->sum('jumlah') }} Alat</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div>Mulai: {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d/m/Y') }}</div>
                            <div class="{{ $isOverdue ? 'text-red-600 font-semibold' : '' }}">
                                Selesai: {{ \Carbon\Carbon::parse($peminjaman->tanggal_pengembalian)->format('d/m/Y') }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->diffInDays(\Carbon\Carbon::parse($peminjaman->tanggal_pengembalian)) }} Hari
                                @if($isOverdue)
                                    <span class="text-red-600 font-semibold">
                                        ({{ \Carbon\Carbon::parse($peminjaman->tanggal_pengembalian)->diffInDays(now()) }} Hari Terlambat)
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col gap-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $peminjaman->status === 'Menunggu' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $peminjaman->status === 'Disetujui' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $peminjaman->status === 'Dipinjam' ? 'bg-indigo-100 text-indigo-800' : '' }}
                                    {{ $peminjaman->status === 'Selesai' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $peminjaman->status === 'Ditolak' ? 'bg-red-100 text-red-800' : '' }}">
                                    @switch($peminjaman->status)
                                        @case('Menunggu') Menunggu @break
                                        @case('Disetujui') Disetujui @break
                                        @case('Dipinjam') Dipinjam @break
                                        @case('Selesai') Selesai @break
                                        @case('Ditolak') Ditolak @break
                                        @default {{ $peminjaman->status }}
                                    @endswitch
                                </span>
                                
                                @if($isOverdue)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 animate-pulse">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        Terlambat
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="flex px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex flex-col gap-2">
                                <!-- View Details -->
                                <button onclick="viewRentalDetail('{{ $peminjaman->id }}')" 
                                        class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 transition-colors">
                                    <i class="fas fa-eye mr-1"></i>
                                    Detail
                                </button>
                                
                                <!-- Actions based on status -->
                                @if($peminjaman->status === 'Menunggu')
                                    <button onclick="approveRental('{{ $peminjaman->id }}')" 
                                            class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded-md hover:bg-green-200 transition-colors" 
                                            title="Approve">
                                        <i class="fas fa-check mr-1"></i>
                                        Setujui
                                    </button>
                                    <button onclick="rejectRental('{{ $peminjaman->id }}')" 
                                            class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded-md hover:bg-red-200 transition-colors" 
                                            title="Reject">
                                        <i class="fas fa-times mr-1"></i>
                                        Tolak
                                    </button>
                                @elseif($peminjaman->status === 'Disetujui')
                                    <button onclick="confirmRental('{{ $peminjaman->id }}')" 
                                            class="inline-flex items-center px-3 py-1 bg-indigo-100 text-indigo-700 rounded-md hover:bg-indigo-200 transition-colors" 
                                            title="Confirm (Letter Signed)">
                                        <i class="fas fa-signature mr-1"></i>
                                        Konfirmasi
                                    </button>
                                    <button onclick="rejectRental('{{ $peminjaman->id }}')" 
                                            class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded-md hover:bg-red-200 transition-colors" 
                                            title="Reject/Cancel">
                                        <i class="fas fa-times mr-1"></i>
                                        Batalkan
                                    </button>
                                @elseif($peminjaman->status === 'Dipinjam')
                                    <button onclick="completeRentalSimple('{{ $peminjaman->id }}')" 
                                            class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-700 rounded-md hover:bg-purple-200 transition-colors" 
                                            title="Complete Rental">
                                        <i class="fas fa-flag-checkered mr-1"></i>
                                        Selesaikan
                                    </button>
                                @endif
                                
                                <!-- Generate WhatsApp Template -->
                                <button onclick="generateWhatsAppTemplate('{{ $peminjaman->id }}', '{{ $peminjaman->namaPeminjam }}', '{{ $peminjaman->noHp }}', '{{ $peminjaman->status }}', {{ $isOverdue ? 'true' : 'false' }})" 
                                        class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded-md hover:bg-green-200 transition-colors text-sm" 
                                        title="WhatsApp Template">
                                    <i class="fab fa-whatsapp mr-1"></i>
                                    WhatsApp
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <i class="fas fa-clipboard-list text-4xl text-gray-300 mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada peminjaman</h3>
                            <p class="text-gray-500">Peminjaman akan muncul di sini setelah diajukan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div id="detailModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity bg-black/50 backdrop-blur-sm" onclick="closeDetailModal()"></div>

        <!-- Modal content -->
        <div class="inline-block w-full max-w-4xl my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-3xl">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 px-6 py-4 text-white">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold">Detail Peminjaman</h3>
                    <button onclick="closeDetailModal()" class="text-white hover:text-gray-200 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div id="detailModalContent" class="p-6">
                <!-- Content will be loaded here -->
                <div class="text-center py-12">
                    <i class="fas fa-spinner fa-spin text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">Memuat detail...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Complete Modal -->
<div id="completeModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity bg-black/50 backdrop-blur-sm" onclick="closeCompleteModal()"></div>

        <!-- Modal content -->
        <div class="inline-block w-full max-w-2xl my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-3xl">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4 text-white">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold">Selesai Peminjaman</h3>
                    <button onclick="closeCompleteModal()" class="text-white hover:text-gray-200 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <form id="completeForm">
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kondisi Pengembalian</label>
                        <textarea name="kondisi_pengembalian" rows="3" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300"
                                placeholder="Describe the condition of equipment when returned..."></textarea>
                    </div>
                    
                    <div id="completeItemsContainer">
                        <!-- Items will be populated by JavaScript -->
                    </div>
                    
                    <div class="flex gap-3">
                        <button type="submit" class="flex-1 bg-gradient-to-r from-purple-500 to-purple-600 text-white py-3 rounded-xl font-semibold hover:from-purple-600 hover:to-purple-700 transition-all duration-300">
                            <i class="fas fa-check mr-2"></i>
                            Selesai Peminjaman
                        </button>
                        <button type="button" onclick="closeCompleteModal()" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-300 transition-all duration-300">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Global variables
let currentRentalId = null;

// Debug: Check if we're on the correct URL
console.log('Current URL:', window.location.href);
console.log('Admin rental tab script loaded');

// Search functionality
function searchRental() {
    const searchTerm = document.getElementById('searchRental').value.toLowerCase();
    const rows = document.querySelectorAll('#rentalTable tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
}

// Filter by status
function filterByStatus() {
    const status = document.getElementById('statusFilter').value;
    const rows = document.querySelectorAll('#rentalTable tbody tr');
    
    rows.forEach(row => {
        let showRow = false;
        
        if (!status) {
            showRow = true;
        } else if (status === 'Overdue') {
            // Check if row has overdue badge
            const overdueBadge = row.querySelector('.animate-pulse');
            showRow = overdueBadge !== null;
        } else {
            showRow = row.dataset.status === status;
        }
        
        row.style.display = showRow ? '' : 'none';
    });
}

// View detail
function viewRentalDetail(rentalId) {
    document.getElementById('detailModal').classList.remove('hidden');
    
    fetch(`/admin/peminjaman/${rentalId}/detail`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('detailModalContent').innerHTML = data.html;
        })
        .catch(error => {
            document.getElementById('detailModalContent').innerHTML = `
                <div class="text-center py-12">
                    <i class="fas fa-exclamation-triangle text-4xl text-red-300 mb-4"></i>
                    <p class="text-red-500">Gagal memuat detail</p>
                </div>
            `;
        });
}

function closeDetailModal() {
    document.getElementById('detailModal').classList.add('hidden');
}

// Approve rental
function approveRental(rentalId) {
    Swal.fire({
        title: 'Konfirmasi',
        text: 'Apakah Anda yakin ingin menyetujui peminjaman ini?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10B981',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Ya, Setujui',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            console.log('Approving rental ID:', rentalId);
            const url = `/admin/peminjaman/${rentalId}/approve`;
            console.log('Fetch URL:', url);
            
            // Show loading state
            Swal.fire({
                title: 'Memproses...',
                text: 'Menyetujui peminjaman',
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
                        text: 'Peminjaman disetujui',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    refreshRentalData();
                } else {
                    Swal.fire({
                        title: 'Gagal!',
                        text: data.message || 'Gagal menyetujui peminjaman',
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

// Reject rental
function rejectRental(rentalId) {
    Swal.fire({
        title: 'Konfirmasi',
        text: 'Apakah Anda yakin ingin menolak/membatalkan peminjaman ini?',
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
                text: 'Menolak peminjaman',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            fetch(`/admin/peminjaman/${rentalId}/reject`, {
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
                        text: 'Peminjaman ditolak',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    refreshRentalData();
                } else {
                    Swal.fire({
                        title: 'Gagal!',
                        text: data.message || 'Gagal menolak peminjaman',
                        icon: 'error'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat menolak peminjaman',
                    icon: 'error'
                });
            });
        }
    });
}

// Confirm rental (when letter is signed)
function confirmRental(rentalId) {
    Swal.fire({
        title: 'Konfirmasi',
        text: 'Apakah Anda yakin surat peminjaman sudah ditandatangani dan alat siap digunakan?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3B82F6',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Ya, Konfirmasi',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            console.log('Confirming rental ID:', rentalId);
            const url = `/admin/peminjaman/${rentalId}/confirm`;
            console.log('Fetch URL:', url);
            
            // Show loading state
            Swal.fire({
                title: 'Memproses...',
                text: 'Mengkonfirmasi peminjaman',
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
                        text: 'Peminjaman dikonfirmasi',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    refreshRentalData();
                } else {
                    Swal.fire({
                        title: 'Gagal!',
                        text: data.message || 'Gagal mengkonfirmasi peminjaman',
                        icon: 'error'
                    });
                }
            })
            .catch(error => {
                console.error('Confirm error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: `Terjadi kesalahan: ${error.message}`,
                    icon: 'error'
                });
            });
        }
    });
}

// Complete rental
function completeRental(rentalId) {
    currentRentalId = rentalId;
    
    // Load items for this rental
    fetch(`/admin/peminjaman/${rentalId}/items`)
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('completeItemsContainer');
            container.innerHTML = data.items.map((item, index) => `
                <div class="mb-4 p-4 bg-gray-50 rounded-xl">
                    <h4 class="font-semibold text-gray-800 mb-3">${item.nama} (${item.kode})</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Good Condition</label>
                            <input type="number" name="items[${index}][jumlah_baik]" value="${item.jumlah}" min="0" max="${item.jumlah}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Damaged</label>
                            <input type="number" name="items[${index}][jumlah_rusak]" value="0" min="0" max="${item.jumlah}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 mt-2">Total borrowed: ${item.jumlah}</p>
                </div>
            `).join('');
            
            document.getElementById('completeModal').classList.remove('hidden');
        })
        .catch(error => {
            Swal.fire({
                title: 'Error!',
                text: 'Gagal memuat data item',
                icon: 'error'
            });
        });
}

// Complete rental simple (without form)
function completeRentalSimple(rentalId) {
    Swal.fire({
        title: 'Konfirmasi',
        text: 'Apakah Anda yakin ingin menyelesaikan peminjaman ini? Alat akan dikembalikan dalam kondisi baik.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#8B5CF6',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Ya, Selesaikan',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            console.log('Completing rental simple ID:', rentalId);
            
            // Show loading state
            Swal.fire({
                title: 'Memproses...',
                text: 'Menyelesaikan peminjaman',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            const url = `/admin/peminjaman/${rentalId}/complete-simple`;
            console.log('Fetch URL:', url);
            
            fetch(url, {
                method: 'POST',
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
                        text: 'Peminjaman berhasil diselesaikan',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    refreshRentalData();
                } else {
                    Swal.fire({
                        title: 'Gagal!',
                        text: data.message || 'Gagal menyelesaikan peminjaman',
                        icon: 'error'
                    });
                }
            })
            .catch(error => {
                console.error('Complete simple error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: `Terjadi kesalahan: ${error.message}`,
                    icon: 'error'
                });
            });
        }
    });
}

function closeCompleteModal() {
    document.getElementById('completeModal').classList.add('hidden');
    currentRentalId = null;
}

// Handle complete form submission
document.addEventListener('DOMContentLoaded', function() {
    const completeForm = document.getElementById('completeForm');
    if (completeForm) {
        completeForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!currentRentalId) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Rental ID tidak ditemukan',
                    icon: 'error'
                });
                return;
            }
            
            console.log('Completing rental ID:', currentRentalId);
            
            const formData = new FormData(this);
            const data = {
                kondisi_pengembalian: formData.get('kondisi_pengembalian'),
                items: []
            };
            
            // Collect items data
            const jumlahBaikInputs = document.querySelectorAll('input[name*="[jumlah_baik]"]');
            const jumlahRusakInputs = document.querySelectorAll('input[name*="[jumlah_rusak]"]');
            
            for (let i = 0; i < jumlahBaikInputs.length; i++) {
                data.items.push({
                    jumlah_baik: parseInt(jumlahBaikInputs[i].value),
                    jumlah_rusak: parseInt(jumlahRusakInputs[i].value)
                });
            }
            
            console.log('Complete data:', data);
            
            const url = `/admin/peminjaman/${currentRentalId}/complete`;
            console.log('Fetch URL:', url);
            
            // Show loading state
            Swal.fire({
                title: 'Memproses...',
                text: 'Menyelesaikan peminjaman',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(data)
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
                        text: 'Peminjaman selesai',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    closeCompleteModal();
                    refreshRentalData();
                } else {
                    Swal.fire({
                        title: 'Gagal!',
                        text: data.message || 'Gagal menyelesaikan peminjaman',
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
        });
    }
});

// Generate WhatsApp template
function generateWhatsAppTemplate(rentalId, nama, noHp, status, isOverdue = false) {
    const trackingLink = `{{ url('/') }}/peminjaman/${rentalId}/tracking`;
    let message = '';
    
    if (isOverdue && status === 'Dipinjam') {
        message = `Hello ${nama},

⚠️ IMPORTANT REMINDER ⚠️

Peminjaman alat Anda sudah melewati tanggal pengembalian yang disepakati.

📋 Rental ID: ${rentalId}
🔴 Status: Terlambat

Mohon segera mengembalikan alat ke laboratorium untuk menghindari sanksi lebih lanjut.

🔗 ${trackingLink}

Terima kasih atas perhatiannya.

Admin Lab. Fisika Medis USK`;
    } else if (status === 'Disetujui') {
        message = `Hello ${nama},

Peminjaman alat Anda telah disetujui!

📋 Rental ID: ${rentalId}
✅ Status: Disetujui

Silakan unduh surat peminjaman melalui tautan berikut dan datang ke laboratorium untuk ditandatangani:

🔗 ${trackingLink}

Terima kasih!

Admin Lab. Fisika Medis USK`;
    } else if (status === 'Dipinjam') {
        message = `Hello ${nama},

Peminjaman alat Anda telah dikonfirmasi!

📋 Rental ID: ${rentalId}
✅ Status: Dipinjam

Alat dapat digunakan sesuai jadwal yang telah ditentukan.

🔗 ${trackingLink}

Terima kasih!

Admin Lab. Fisika Medis USK`;
    } else if (status === 'Selesai') {
        message = `Hello ${nama},

Peminjaman alat Anda telah selesai!

📋 Rental ID: ${rentalId}
✅ Status: Selesai

Terima kasih atas penggunaan fasilitas Laboratorium Fisika Medis USK.

🔗 ${trackingLink}

Admin Lab. Fisika Medis USK`;
    } else if (status === 'Ditolak') {
        message = `Hello ${nama},

Maaf, peminjaman alat Anda tidak dapat disetujui.

📋 Rental ID: ${rentalId}
❌ Status: Ditolak

Untuk informasi lebih lanjut, silakan hubungi admin laboratorium.

🔗 ${trackingLink}

Admin Lab. Fisika Medis USK`;
    }
    
    // Remove country code if exists
    const phoneNumber = noHp.startsWith('0') ? '62' + noHp.substring(1) : noHp;
    const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
    
    window.open(whatsappUrl, '_blank');
}

// Refresh data
function refreshRentalData() {
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
window.approveRental = approveRental;
window.confirmRental = confirmRental;
window.rejectRental = rejectRental;
window.completeRental = completeRental;
window.viewRentalDetail = viewRentalDetail;
window.closeDetailModal = closeDetailModal;
window.closeCompleteModal = closeCompleteModal;
window.refreshRentalData = refreshRentalData;
window.generateWhatsAppTemplate = generateWhatsAppTemplate;
window.showNotification = showNotification;
window.searchRental = searchRental;
window.filterByStatus = filterByStatus;

console.log('Admin rental functions made globally available:', {
    approveRental: typeof window.approveRental,
    confirmRental: typeof window.confirmRental,
    completeRental: typeof window.completeRental,
    showNotification: typeof window.showNotification
});
</script>