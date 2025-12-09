@extends('layouts.user-section')

@section('title', 'Tracking Peminjaman #' . $peminjaman->id)

@section('breadcrumb')
    <li class="text-white/60">•</li>
    <li class="text-white font-medium">Fasilitas</li>
    <li class="text-white/60">•</li>
    <li><a href="{{ route('equipment.rental') }}" class="text-white/80 hover:text-white transition-colors">Peminjaman Alat</a></li>
    <li class="text-white/60">•</li>
    <li class="text-white font-medium">Tracking #{{ Str::limit($peminjaman->id, 8) }}</li>
@endsection

@section('page-title', 'Tracking Peminjaman')

@section('page-description', 'Pantau status peminjaman alat laboratorium Anda secara real-time')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-100">
    <section class="py-16">
        <div class="container mx-auto px-6">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Status Progress -->
            <div class="max-w-4xl mx-auto mb-8">
                <div class="bg-white/90 backdrop-blur-sm rounded-3xl p-8 shadow-2xl border border-gray-100/50">
                    <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center">Status Peminjaman</h2>
                    
                    <div class="relative">
                        <!-- Progress Line -->
                        <div class="absolute top-6 left-0 w-full h-1 bg-gray-200 rounded-full">
                            <div class="h-full bg-emerald-500 rounded-full transition-all duration-1000" style="width: {{ $progressWidth }}%"></div>
                        </div>
                        
                        <!-- Progress Steps -->
                        <div class="relative flex justify-between">
                            <!-- Step 1: Menunggu -->
                            <div class="flex flex-col items-center flex-1">
                                <div class="w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center mb-2 md:mb-3 {{ in_array($peminjaman->status, ['Menunggu', 'Disetujui', 'Dipinjam', 'Selesai']) ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-500' }}">
                                    <i class="fas fa-paper-plane text-xs md:text-sm"></i>
                                </div>
                                <span class="text-xs md:text-sm font-medium text-gray-600 text-center">Peminjaman<br>Diajukan</span>
                            </div>
                            
                            <!-- Step 2: Disetujui -->
                            <div class="flex flex-col items-center flex-1">
                                <div class="w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center mb-2 md:mb-3 {{ in_array($peminjaman->status, ['Disetujui', 'Dipinjam', 'Selesai']) ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-500' }}">
                                    <i class="fas fa-check-circle text-xs md:text-sm"></i>
                                </div>
                                <span class="text-xs md:text-sm font-medium text-gray-600 text-center">Divalidasi<br>Admin</span>
                            </div>
                            
                            <!-- Step 3: Dipinjam -->
                            <div class="flex flex-col items-center flex-1">
                                <div class="w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center mb-2 md:mb-3 {{ in_array($peminjaman->status, ['Dipinjam', 'Selesai']) ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-500' }}">
                                    <i class="fas fa-handshake text-xs md:text-sm"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-600 text-center">Surat TTD<br>& Dipinjam</span>
                            </div>
                            
                            <!-- Step 4: Selesai -->
                            <div class="flex flex-col items-center">
                                <div class="w-12 h-12 rounded-full flex items-center justify-center mb-3 {{ $peminjaman->status === 'Selesai' ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-500' }}">
                                    <i class="fas fa-flag-checkered"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-600 text-center">Selesai<br>& Dikembalikan</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Current Status -->
                    <div class="mt-8 text-center">
                        <div class="inline-flex items-center gap-2 px-6 py-3 rounded-full text-lg font-semibold
                            {{ $peminjaman->status === 'Menunggu' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $peminjaman->status === 'Disetujui' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $peminjaman->status === 'Dipinjam' ? 'bg-indigo-100 text-indigo-800' : '' }}
                            {{ $peminjaman->status === 'Selesai' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $peminjaman->status === 'Ditolak' ? 'bg-red-100 text-red-800' : '' }}">
                            @php
                                $statusIcons = [
                                    'Menunggu' => 'hourglass-half',
                                    'Disetujui' => 'check-circle',
                                    'Dipinjam' => 'handshake',
                                    'Selesai' => 'flag-checkered',
                                    'Ditolak' => 'times-circle'
                                ];
                            @endphp
                            <i class="fas fa-{{ $statusIcons[$peminjaman->status] ?? 'question-circle' }}"></i>
                            {{ $statusText }}
                        </div>
                        @if($peminjaman->status === 'Menunggu')
                            <p class="text-gray-600 mt-3">Peminjaman Anda sedang menunggu review dari admin laboratorium</p>
                        @elseif($peminjaman->status === 'Disetujui')
                            <p class="text-gray-600 mt-3">✅ Peminjaman disetujui! Silakan download surat dan datang ke laboratorium untuk ditandatangani</p>
                        @elseif($peminjaman->status === 'Dipinjam')
                            <p class="text-gray-600 mt-3">🎉 <strong>Peminjaman berhasil!</strong> Surat sudah ditandatangani, alat dapat digunakan sesuai jadwal</p>
                        @elseif($peminjaman->status === 'Selesai')
                            <p class="text-gray-600 mt-3">✅ <strong>Peminjaman selesai!</strong> Terima kasih telah menggunakan fasilitas laboratorium</p>
                        @elseif($peminjaman->status === 'Ditolak')
                            <p class="text-gray-600 mt-3">❌ Peminjaman ditolak oleh admin</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Peminjaman Details -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Borrower Information -->
                    <div class="bg-white/90 backdrop-blur-sm rounded-3xl p-8 shadow-xl border border-gray-100/50">
                        <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-white text-sm"></i>
                            </div>
                            Informasi Peminjam
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-gray-600">Nama Lengkap</label>
                                <p class="text-lg font-semibold text-gray-800">{{ $peminjaman->namaPeminjam }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Nomor HP</label>
                                <p class="text-lg font-semibold text-gray-800">{{ $peminjaman->noHp }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Status Mahasiswa</label>
                                <p class="text-lg font-semibold text-gray-800">{{ $peminjaman->is_mahasiswa_usk ? 'Mahasiswa USK' : 'Bukan Mahasiswa USK' }}</p>
                            </div>
                            @if($peminjaman->is_mahasiswa_usk && $peminjaman->npm_nim)
                            <div>
                                <label class="text-sm font-medium text-gray-600">NPM/NIM</label>
                                <p class="text-lg font-semibold text-gray-800">{{ $peminjaman->npm_nim }}</p>
                            </div>
                            @endif
                            <div>
                                <label class="text-sm font-medium text-gray-600">ID Peminjaman</label>
                                <p class="text-lg font-semibold text-gray-800 font-mono">{{ $peminjaman->id }}</p>
                            </div>
                            @if($peminjaman->tujuanPeminjaman)
                            <div class="md:col-span-2">
                                <label class="text-sm font-medium text-gray-600">Tujuan Peminjaman</label>
                                <p class="text-lg font-semibold text-gray-800">{{ $peminjaman->tujuanPeminjaman }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Schedule Information -->
                    <div class="bg-white/90 backdrop-blur-sm rounded-3xl p-8 shadow-xl border border-gray-100/50">
                        <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-calendar text-white text-sm"></i>
                            </div>
                            Jadwal Peminjaman
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-gray-600">Tanggal Pinjam</label>
                                <p class="text-lg font-semibold text-gray-800">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Tanggal Pengembalian</label>
                                <p class="text-lg font-semibold text-gray-800">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pengembalian)->format('d M Y') }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Durasi Peminjaman</label>
                                <p class="text-lg font-semibold text-gray-800">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->diffInDays(\Carbon\Carbon::parse($peminjaman->tanggal_pengembalian)) }} hari</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Dibuat pada</label>
                                <p class="text-lg font-semibold text-gray-800">{{ $peminjaman->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Equipment List -->
                    <div class="bg-white/90 backdrop-blur-sm rounded-3xl p-8 shadow-xl border border-gray-100/50">
                        <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-list text-white text-sm"></i>
                            </div>
                            Daftar Alat yang Dipinjam
                        </h3>
                        
                        <div class="space-y-4">
                            @foreach($peminjaman->peminjamanItems as $item)
                            <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl border">
                                <img src="{{ $item->alat->image_url }}" 
                                     alt="{{ $item->alat->nama }}" 
                                     class="w-16 h-16 object-cover rounded-lg">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-800">{{ $item->alat->nama }}</h4>
                                    <p class="text-sm text-gray-600">{{ $item->alat->kode }}</p>
                                    <p class="text-sm text-gray-500">{{ $item->alat->nama_kategori }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-emerald-600">{{ $item->jumlah }}x</p>
                                    <p class="text-sm text-gray-500">Unit</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-semibold text-gray-800">Total Item:</span>
                                <span class="text-2xl font-bold text-emerald-600">{{ $peminjaman->peminjamanItems->sum('jumlah') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Actions -->
                <div class="space-y-6">
                    <!-- Quick Actions -->
                    <div class="bg-white/90 backdrop-blur-sm rounded-3xl p-8 shadow-xl border border-gray-100/50">
                        <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-amber-500 to-amber-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-rocket text-white text-sm"></i>
                            </div>
                            Aksi Cepat
                        </h3>
                        
                        <div class="space-y-4">
                            <!-- Download Surat Button -->
                            @if(in_array($peminjaman->status, ['Disetujui', 'Dipinjam', 'Selesai']))
                                <a href="{{ route('user.peminjaman.download-letter', $peminjaman->id) }}" 
                                   class="w-full bg-gradient-to-r from-emerald-500 to-emerald-600 text-white py-4 rounded-xl font-semibold hover:from-emerald-600 hover:to-emerald-700 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                                    <i class="fas fa-download"></i>
                                    <span>Download Surat Peminjaman</span>
                                </a>
                            @else
                                <div class="w-full bg-gray-300 text-gray-500 py-4 rounded-xl font-semibold text-center">
                                    <i class="fas fa-lock mr-2"></i>
                                    Surat belum tersedia
                                </div>
                            @endif
                            
                            <!-- WhatsApp Confirmation Button -->
                            <button onclick="sendWhatsAppConfirmation()" 
                                    class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-4 rounded-xl font-semibold hover:from-green-600 hover:to-green-700 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                                <i class="fab fa-whatsapp"></i>
                                <span>Konfirmasi via WhatsApp</span>
                            </button>
                            
                            <!-- Back to Equipment Button -->
                            <a href="{{ route('equipment.rental') }}" 
                               class="w-full bg-gray-100 text-gray-700 py-3 rounded-xl font-semibold hover:bg-gray-200 transition-all duration-300 text-center block">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Kembali ke Daftar Alat
                            </a>
                        </div>
                    </div>

                    <!-- Tracking Link -->
                    <div class="bg-white/90 backdrop-blur-sm rounded-3xl p-8 shadow-xl border border-gray-100/50">
                        <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-link text-white text-sm"></i>
                            </div>
                            Link Tracking
                        </h3>
                        
                        <p class="text-sm text-gray-600 mb-4">Simpan link ini untuk mengecek status peminjaman kapan saja:</p>
                        
                        <div class="bg-gray-50 p-4 rounded-xl border">
                            <p class="text-sm font-mono text-gray-700 break-all" id="tracking-link">{{ route('user.peminjaman.tracking', $peminjaman->id) }}</p>
                        </div>
                        
                        <button onclick="copyTrackingLink()" 
                                class="w-full mt-3 bg-blue-100 text-blue-700 py-2 rounded-lg font-semibold hover:bg-blue-200 transition-all duration-300">
                            <i class="fas fa-copy mr-2"></i>
                            Salin Link
                        </button>
                    </div>

                    <!-- Help & Contact -->
                    <div class="bg-white/90 backdrop-blur-sm rounded-3xl p-8 shadow-xl border border-gray-100/50">
                        <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-red-500 to-red-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-question-circle text-white text-sm"></i>
                            </div>
                            Bantuan
                        </h3>
                        
                        <div class="space-y-3 text-sm text-gray-600">
                            <p><strong>Status Pending:</strong> Menunggu review admin</p>
                            <p><strong>Status Processing:</strong> Disetujui, download surat lalu minta tanda tangan</p>
                            <p><strong>Status Completed:</strong> Berhasil, alat siap digunakan</p>
                        </div>
                        
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <p class="text-sm text-gray-600 mb-2"><strong>Kontak Admin:</strong></p>
                            <p class="text-sm text-gray-700">WhatsApp: {{ config('app.admin_contact.whatsapp_display') }}</p>
                            <p class="text-sm text-gray-700">Email: {{ config('app.admin_contact.email') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
function sendWhatsAppConfirmation() {
    const phoneNumber = '{{ config('app.admin_contact.whatsapp', '6282283055874') }}'; // Admin WhatsApp number
    const trackingLink = '{{ route("user.peminjaman.tracking", $peminjaman->id) }}';
    const message = `
Halo Admin Laboratorium Fisika Medis,

Saya {{ $peminjaman->namaPeminjam }} ingin mengkonfirmasi peminjaman alat:

📋 ID Peminjaman: {{ $peminjaman->id }}
📅 Tanggal Pinjam: {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}
📅 Tanggal Kembali: {{ \Carbon\Carbon::parse($peminjaman->tanggal_pengembalian)->format('d M Y') }}
📱 HP: {{ $peminjaman->noHp }}

🔗 Link Tracking: ${trackingLink}

Terima kasih!
    `.trim();
    
    const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
    window.open(whatsappUrl, '_blank');
}

function copyTrackingLink() {
    const trackingLink = document.getElementById('tracking-link').textContent;
    navigator.clipboard.writeText(trackingLink).then(function() {
        // Show notification
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 bg-blue-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
        notification.textContent = 'Link berhasil disalin!';
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    });
}

// Auto refresh status every 30 seconds
setInterval(function() {
    // Check if status has changed
    fetch(window.location.href + '?check_status=1')
        .then(response => response.json())
        .then(data => {
            if (data.status && data.status !== '{{ $peminjaman->status }}') {
                // Reload page if status changed
                window.location.reload();
            }
        })
        .catch(error => {
            // Silently ignore errors
        });
}, 30000);
</script>

<script>
// Clear cart when tracking page is loaded (indicating successful submission)
document.addEventListener('DOMContentLoaded', function() {
    console.log('Tracking page loaded, clearing cart...');
    
    // Clear cart from localStorage
    localStorage.removeItem('equipmentCart');
    
    // Also clear any Alpine.js cart data if present
    const alpineEl = document.querySelector('[x-data]');
    if (alpineEl && alpineEl._x_dataStack && alpineEl._x_dataStack[0]) {
        alpineEl._x_dataStack[0].cart = [];
    }
    
    // Mark that user is coming from tracking page
    sessionStorage.setItem('fromTracking', 'true');
    
    console.log('Cart cleared from tracking page');
});
</script>
@endsection 