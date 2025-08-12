@extends('layouts.user-section')

@section('title', 'Tracking Kunjungan #' . $kunjungan->id)

@section('breadcrumb')
    <li class="text-white/60">•</li>
    <li class="text-white font-medium">Fasilitas</li>
    <li class="text-white/60">•</li>
    <li><a href="{{ route('lab.visit') }}" class="text-white/80 hover:text-white transition-colors">Kunjungan Lab</a></li>
    <li class="text-white/60">•</li>
    <li class="text-white font-medium">Tracking #{{ Str::limit($kunjungan->id, 8) }}</li>
@endsection

@section('page-title', 'Tracking Kunjungan')

@section('page-description', 'Pantau status pengajuan kunjungan laboratorium Anda secara real-time')

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
                    <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center">Status Kunjungan</h2>
                    
                    <div class="relative">
                        <!-- Progress Line -->
                        <div class="absolute top-6 left-0 w-full h-1 bg-gray-200 rounded-full">
                            @php
                                $progressWidth = 0;
                                if($kunjungan->status === 'PENDING') $progressWidth = 25;
                                elseif($kunjungan->status === 'PROCESSING') $progressWidth = 75;
                                elseif($kunjungan->status === 'COMPLETED') $progressWidth = 100;
                                elseif($kunjungan->status === 'CANCELLED') $progressWidth = 100;
                            @endphp
                            <div class="h-full bg-emerald-500 rounded-full transition-all duration-1000" style="width: {{ $progressWidth }}%"></div>
                        </div>
                        
                        <!-- Progress Steps -->
                        <div class="relative flex justify-between">
                            <!-- Step 1: Pending -->
                            <div class="flex flex-col items-center">
                                <div class="w-12 h-12 rounded-full flex items-center justify-center mb-3 {{ in_array($kunjungan->status, ['PENDING', 'PROCESSING', 'COMPLETED']) ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-500' }}">
                                    <i class="fas fa-paper-plane"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-600 text-center">Pengajuan<br>Dikirim</span>
                            </div>
                            
                            <!-- Step 2: Processing -->
                            <div class="flex flex-col items-center">
                                <div class="w-12 h-12 rounded-full flex items-center justify-center mb-3 {{ in_array($kunjungan->status, ['PROCESSING', 'COMPLETED']) ? 'bg-emerald-500 text-white' : ($kunjungan->status === 'CANCELLED' ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-500') }}">
                                    @if($kunjungan->status === 'CANCELLED')
                                        <i class="fas fa-times-circle"></i>
                                    @else
                                        <i class="fas fa-check-circle"></i>
                                    @endif
                                </div>
                                <span class="text-sm font-medium text-gray-600 text-center">
                                    @if($kunjungan->status === 'CANCELLED')
                                        Ditolak<br>Admin
                                    @else
                                        Disetujui<br>Admin
                                    @endif
                                </span>
                            </div>
                            
                            <!-- Step 3: Completed -->
                            <div class="flex flex-col items-center">
                                <div class="w-12 h-12 rounded-full flex items-center justify-center mb-3 {{ $kunjungan->status === 'COMPLETED' ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-500' }}">
                                    <i class="fas fa-flag-checkered"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-600 text-center">Kunjungan<br>Selesai</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Current Status -->
                    <div class="mt-8 text-center">
                        <div class="inline-flex items-center gap-2 px-6 py-3 rounded-full text-lg font-semibold
                            {{ $kunjungan->status === 'PENDING' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $kunjungan->status === 'PROCESSING' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $kunjungan->status === 'COMPLETED' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $kunjungan->status === 'CANCELLED' ? 'bg-red-100 text-red-800' : '' }}">
                            @php
                                $statusIcons = [
                                    'PENDING' => 'hourglass-half',
                                    'PROCESSING' => 'check-circle',
                                    'COMPLETED' => 'flag-checkered',
                                    'CANCELLED' => 'times-circle'
                                ];
                                $statusTexts = [
                                    'PENDING' => 'Menunggu Persetujuan',
                                    'PROCESSING' => 'Disetujui',
                                    'COMPLETED' => 'Selesai',
                                    'CANCELLED' => 'Ditolak'
                                ];
                            @endphp
                            <i class="fas fa-{{ $statusIcons[$kunjungan->status] ?? 'question-circle' }}"></i>
                            {{ $statusTexts[$kunjungan->status] ?? $kunjungan->status }}
                        </div>
                        @if($kunjungan->status === 'PENDING')
                            <p class="text-gray-600 mt-3">Pengajuan kunjungan Anda sedang menunggu review dari admin laboratorium</p>
                        @elseif($kunjungan->status === 'PROCESSING')
                            <p class="text-gray-600 mt-3">✅ Kunjungan disetujui! Silakan konfirmasi kehadiran via WhatsApp</p>
                        @elseif($kunjungan->status === 'COMPLETED')
                            <p class="text-gray-600 mt-3">✅ <strong>Kunjungan selesai!</strong> Terima kasih telah berkunjung ke laboratorium kami</p>
                        @elseif($kunjungan->status === 'CANCELLED')
                            <p class="text-gray-600 mt-3">❌ Pengajuan kunjungan ditolak oleh admin</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Visit Details -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Visitor Information -->
                    <div class="bg-white/90 backdrop-blur-sm rounded-3xl p-8 shadow-xl border border-gray-100/50 flex flex-col gap-10">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 flex items-center gap-3 mb-6">
                                <div class="w-8 h-8 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-users text-white text-sm"></i>
                                </div>
                                Informasi Pengunjung
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Nama Pengunjung</label>
                                    <p class="text-lg font-semibold text-gray-800">{{ $kunjungan->namaPengunjung }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Nomor HP</label>
                                    <p class="text-lg font-semibold text-gray-800">{{ $kunjungan->noHp }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Nama Instansi</label>
                                    <p class="text-lg font-semibold text-gray-800">{{ $kunjungan->namaInstansi }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Jumlah Pengunjung</label>
                                    <p class="text-lg font-semibold text-gray-800">{{ $kunjungan->jumlahPengunjung }} orang</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">ID Kunjungan</label>
                                    <p class="text-lg font-semibold text-gray-800 font-mono">{{ $kunjungan->id }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Tujuan Kunjungan</label>
                                    <p class="text-lg font-semibold text-gray-800">{{ $kunjungan->tujuan }}</p>
                                </div>
                            </div>
                        </div>

                        <hr class="border-gray-200">

                        <div>
                            <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-calendar text-white text-sm"></i>
                                </div>
                                Jadwal Kunjungan
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Tanggal Kunjungan</label>
                                    <p class="text-lg font-semibold text-gray-800">
                                        {{ $kunjungan->jadwal ? $kunjungan->jadwal->tanggal->format('d M Y') : 'Belum dijadwalkan' }}
                                    </p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Waktu</label>
                                    <p class="text-lg font-semibold text-gray-800">
                                        {{ $kunjungan->jadwal ? $kunjungan->jadwal->time_label : 'Belum ditentukan' }}
                                    </p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Surat Pengajuan</label>
                                    @if($kunjungan->suratPengajuan)
                                        <div class="flex items-center gap-2">
                                            <a href="{{ Storage::url($kunjungan->suratPengajuan) }}" target="_blank" 
                                                class="text-lg font-semibold text-emerald-600 hover:text-emerald-700 underline p-4 bg-emerald-50 rounded-lg">
                                                Lihat Dokumen
                                            </a>
                                        </div>
                                    @else
                                        <p class="text-lg font-semibold text-gray-500">Tidak ada dokumen</p>
                                    @endif
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Dibuat pada</label>
                                    <p class="text-lg font-semibold text-gray-800">{{ $kunjungan->created_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                        </div>

                        <hr class="border-gray-200">

                        <div>
                            <h3 class="text-xl font-bold text-gray-800 flex items-center gap-3">
                                <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-info-circle text-white text-sm"></i>
                                </div>
                                Detail Kunjungan
                            </h3>
                                
                            <div class="bg-gray-50 rounded-xl p-6">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-bullseye text-purple-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-800 mb-2">Tujuan Kunjungan</h4>
                                        <p class="text-gray-700 leading-relaxed">{{ $kunjungan->tujuan }}</p>
                                    </div>
                                </div>
                            </div>
                                
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-semibold text-gray-800">Total Pengunjung:</span>
                                    <span class="text-2xl font-bold text-emerald-600">{{ $kunjungan->jumlahPengunjung }}</span>
                                </div>
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
                            <!-- WhatsApp Confirmation Button -->
                            @if($kunjungan->status === 'PROCESSING')
                                <button onclick="sendWhatsAppConfirmation()" 
                                        class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-4 rounded-xl font-semibold hover:from-green-600 hover:to-green-700 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                                    <i class="fab fa-whatsapp"></i>
                                    <span>Konfirmasi via WhatsApp</span>
                                </button>
                            @endif

                            <!-- WhatsApp Contact Button -->
                            @if($kunjungan->status === 'PENDING')
                                <button onclick="chatWithAdmin()" 
                                        class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-3 rounded-xl font-semibold hover:from-green-600 hover:to-green-700 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                                    <i class="fab fa-whatsapp text-lg"></i>
                                    <span>Chat WhatsApp Admin</span>
                                </button>
                            @endif

                            <!-- Cancel Button (only for pending) -->
                            @if($kunjungan->status === 'PENDING')
                                <form action="{{ route('kunjungan.cancel', $kunjungan) }}" method="POST" class="w-full">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="w-full bg-gradient-to-r from-red-500 to-red-600 text-white py-4 rounded-xl font-semibold hover:from-red-600 hover:to-red-700 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center gap-2"
                                            onclick="return confirm('Apakah Anda yakin ingin membatalkan kunjungan ini?')">
                                        <i class="fas fa-times"></i>
                                        <span>Batalkan Kunjungan</span>
                                    </button>
                                </form>
                            @endif
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
                        
                        <p class="text-sm text-gray-600 mb-4">Simpan link ini untuk mengecek status kunjungan kapan saja:</p>
                        
                        <div class="bg-gray-50 p-4 rounded-xl border">
                            <p class="text-sm font-mono text-gray-700 break-all" id="tracking-link">{{ route('kunjungan.tracking', $kunjungan->id) }}</p>
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
                            Bantuan & Kontak
                        </h3>
                        
                        <div class="space-y-3 text-sm text-gray-600 mb-6">
                            <p><strong>Status Pengajuan:</strong> Kamu mengajukan kunjungan</p>
                            <p><strong>Status Disetujui:</strong> Admin menyetujui kunjungan anda</p>
                            <p><strong>Status Kunjungan Dilaksanakan:</strong> Disetujui, konfirmasi kehadiran via WhatsApp dan lakukan kunjungan</p>
                            <p><strong>Status Kunjungan Selesai:</strong> Kunjungan telah selesai dilaksanakan</p>
                        </div>
                        
                        <div class="space-y-4">                    
                            <!-- Contact Information -->
                            <div class="bg-gray-50 rounded-xl p-4">
                                <h4 class="font-semibold text-gray-800 mb-3">Kontak Admin:</h4>
                                <div class="space-y-2 text-sm">
                                    <div class="flex items-center gap-2">
                                        <i class="fab fa-whatsapp text-green-500"></i>
                                        <span class="text-gray-700">+62 812-3456-7890</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-envelope text-blue-500"></i>
                                        <span class="text-gray-700">lab@fisika.medis.ac.id</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-map-marker-alt text-red-500"></i>
                                        <span class="text-gray-700">Gedung Fisika Lt. 2</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
function sendWhatsAppConfirmation() {
    const phoneNumber = '6281234567890'; // Admin WhatsApp number
    const trackingLink = '{{ route("kunjungan.tracking", $kunjungan->id) }}';
    const message = `
Halo Admin Laboratorium Fisika Medis,

Saya {{ $kunjungan->namaPengunjung }} ingin mengkonfirmasi kunjungan:

📋 ID Kunjungan: {{ $kunjungan->id }}
🏢 Instansi: {{ $kunjungan->namaInstansi }}
👥 Jumlah Pengunjung: {{ $kunjungan->jumlahPengunjung }} orang
📅 Jadwal: {{ $kunjungan->jadwal ? $kunjungan->jadwal->tanggal->format('d M Y') : 'Belum dijadwalkan' }}
📱 HP: {{ $kunjungan->noHp }}
🎯 Tujuan: {{ $kunjungan->tujuan }}

🔗 Link Tracking: ${trackingLink}

Terima kasih!
    `.trim();
    
    const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
    window.open(whatsappUrl, '_blank');
}

function chatWithAdmin() {
    const phoneNumber = '6281234567890'; // Admin WhatsApp number
    const message = `
    Halo Admin Laboratorium Fisika Medis,

    Saya {{ $kunjungan->namaPengunjung }} ingin bertanya tentang kunjungan saya.

    ID Kunjungan: {{ $kunjungan->id }}

    Terima kasih!
    `;
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
            if (data.status && data.status !== '{{ $kunjungan->status }}') {
                // Reload page if status changed
                window.location.reload();
            }
        })
        .catch(error => {
            // Silently ignore errors
        });
}, 30000);
</script>
@endsection