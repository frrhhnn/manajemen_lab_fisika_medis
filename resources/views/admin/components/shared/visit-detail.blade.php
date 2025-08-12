<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Left Column - Visitor Information -->
    <div class="space-y-4">
        <h4 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
            <i class="fas fa-user text-emerald-500"></i>
            Informasi Pengunjung
        </h4>
        
        <div class="bg-gray-50 rounded-xl p-4">
            <div class="grid grid-cols-1 gap-3">
                <div>
                    <label class="text-sm font-medium text-gray-600">Nama Lengkap</label>
                    <p class="text-gray-800 font-semibold">{{ $kunjungan->namaPengunjung }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Nomor HP</label>
                    <p class="text-gray-800 font-semibold">{{ $kunjungan->noHp }}</p>
                </div>
                @if($kunjungan->namaInstansi)
                <div>
                    <label class="text-sm font-medium text-gray-600">Instansi</label>
                    <p class="text-gray-800 font-semibold">{{ $kunjungan->namaInstansi }}</p>
                </div>
                @endif
                <div>
                    <label class="text-sm font-medium text-gray-600">Jumlah Peserta</label>
                    <p class="text-gray-800 font-semibold">{{ $kunjungan->jumlahPengunjung }} orang</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Tujuan Kunjungan</label>
                    <p class="text-gray-800">{{ $kunjungan->tujuan }}</p>
                </div>
            </div>
        </div>

        <h4 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
            <i class="fas fa-calendar text-blue-500"></i>
            Jadwal Kunjungan
        </h4>
        
        <div class="bg-gray-50 rounded-xl p-4">
            <div class="grid grid-cols-1 gap-3">
                @if($kunjungan->jadwal)
                <div>
                    <label class="text-sm font-medium text-gray-600">Tanggal Kunjungan</label>
                    <p class="text-gray-800 font-semibold">{{ $kunjungan->jadwal->tanggal->format('d M Y') }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Waktu Kunjungan</label>
                    <p class="text-gray-800 font-semibold">{{ $kunjungan->jadwal->time_label }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Durasi</label>
                    <p class="text-gray-800 font-semibold">{{ $kunjungan->jadwal->duration }} jam</p>
                </div>
                @else
                <div>
                    <label class="text-sm font-medium text-gray-600">Status Jadwal</label>
                    <p class="text-gray-800 font-semibold text-red-600">Jadwal belum ditentukan</p>
                </div>
                @endif
                <div>
                    <label class="text-sm font-medium text-gray-600">Dibuat</label>
                    <p class="text-gray-800 font-semibold">{{ $kunjungan->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column - Documents & Status -->
    <div class="space-y-4">
        <h4 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
            <i class="fas fa-file-alt text-purple-500"></i>
            Dokumen Pendukung
        </h4>
        
        <div class="bg-gray-50 rounded-xl p-4">
            @if($kunjungan->suratPengajuan)
            <div class="space-y-3">
                <div class="flex items-center gap-3 p-3 bg-white rounded-lg border">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-file-pdf text-red-500 text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <h5 class="font-semibold text-gray-800">Surat Pengajuan</h5>
                        <p class="text-sm text-gray-600">Dokumen resmi pengajuan kunjungan</p>
                    </div>
                    <div class="text-right">
                        <a href="{{ asset('storage/' . $kunjungan->suratPengajuan) }}" 
                           target="_blank"
                           class="inline-flex items-center px-3 py-1 bg-emerald-100 text-emerald-700 rounded-md hover:bg-emerald-200 transition-colors text-sm font-medium">
                            <i class="fas fa-eye mr-1"></i>
                            Lihat
                        </a>
                    </div>
                </div>
            </div>
            @else
            <div class="text-center py-8">
                <i class="fas fa-file-alt text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">Tidak ada dokumen yang diupload</p>
            </div>
            @endif
        </div>

        <h4 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
            <i class="fas fa-info-circle text-amber-500"></i>
            Status & ID
        </h4>
        
        <div class="bg-gray-50 rounded-xl p-4">
            <div class="space-y-3">
                <div>
                    <label class="text-sm font-medium text-gray-600">Status Saat Ini</label>
                    <p class="mt-1">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            {{ $kunjungan->status === 'PENDING' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $kunjungan->status === 'PROCESSING' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $kunjungan->status === 'COMPLETED' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $kunjungan->status === 'CANCELLED' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ $kunjungan->status_label }}
                        </span>
                    </p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">ID Kunjungan</label>
                    <p class="text-gray-800 font-mono text-sm break-all">{{ $kunjungan->id }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Link Tracking</label>
                    <p class="text-gray-800 text-sm break-all">
                        <a href="{{ route('kunjungan.tracking', $kunjungan->id) }}" 
                           target="_blank" 
                           class="text-blue-600 hover:text-blue-800 underline">
                            {{ route('kunjungan.tracking', $kunjungan->id) }}
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Function to contact visitor via WhatsApp
function contactVisitor(phoneNumber, visitorName, visitId) {
    // Remove any non-numeric characters from phone number
    const cleanPhone = phoneNumber.replace(/\D/g, '');
    
    // Add country code if not present
    const formattedPhone = cleanPhone.startsWith('62') ? cleanPhone : `62${cleanPhone}`;
    
    const message = `Halo ${visitorName},

Saya admin Laboratorium Fisika Medis ingin menghubungi Anda terkait kunjungan dengan ID: ${visitId}

Mohon konfirmasi atau jika ada pertanyaan silakan balas pesan ini.

Terima kasih,
Admin Laboratorium Fisika Medis`;

    const whatsappUrl = `https://wa.me/${formattedPhone}?text=${encodeURIComponent(message)}`;
    window.open(whatsappUrl, '_blank');
}
</script>
