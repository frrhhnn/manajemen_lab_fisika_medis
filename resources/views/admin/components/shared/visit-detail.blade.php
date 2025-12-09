<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Left Column - Visitor Information -->
    <div class="space-y-6">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="bg-gradient-to-r from-emerald-50 to-green-50 px-6 py-4 border-b border-gray-100">
                <h4 class="text-lg font-semibold text-gray-800 flex items-center gap-3">
                    <div class="p-2 bg-emerald-100 rounded-lg">
                        <i class="fas fa-user text-emerald-600"></i>
                    </div>
                    Informasi Pengunjung
                </h4>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 gap-4">
                    <div class="group">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Lengkap</label>
                        <p class="text-gray-900 font-semibold text-lg mt-1">{{ $kunjungan->namaPengunjung }}</p>
                    </div>
                    <div class="group">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Nomor HP</label>
                        <p class="text-gray-900 font-semibold mt-1 flex items-center gap-2">
                            <i class="fas fa-phone text-emerald-500 text-sm"></i>
                            {{ $kunjungan->noHp }}
                        </p>
                    </div>
                    @if($kunjungan->namaInstansi)
                    <div class="group">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Instansi</label>
                        <p class="text-gray-900 font-semibold mt-1 flex items-center gap-2">
                            <i class="fas fa-building text-blue-500 text-sm"></i>
                            {{ $kunjungan->namaInstansi }}
                        </p>
                    </div>
                    @endif
                    <div class="group">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Jumlah Peserta</label>
                        <p class="text-gray-900 font-semibold mt-1 flex items-center gap-2">
                            <i class="fas fa-users text-purple-500 text-sm"></i>
                            {{ $kunjungan->jumlahPengunjung }} orang
                        </p>
                    </div>
                    <div class="group">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Tujuan Kunjungan</label>
                        <div class="mt-2 p-3 bg-gray-50 rounded-lg border border-gray-100">
                            <p class="text-gray-800 leading-relaxed">{{ $kunjungan->tujuan }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-100">
                <h4 class="text-lg font-semibold text-gray-800 flex items-center gap-3">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <i class="fas fa-calendar text-blue-600"></i>
                    </div>
                    Jadwal Kunjungan
                </h4>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 gap-4">
                    @if($kunjungan->jadwal)
                    <div class="group">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal Kunjungan</label>
                        <p class="text-gray-900 font-semibold text-lg mt-1 flex items-center gap-2">
                            <i class="fas fa-calendar-day text-blue-500 text-sm"></i>
                            {{ $kunjungan->jadwal->tanggal->format('d M Y') }}
                        </p>
                    </div>
                    <div class="group">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Waktu Kunjungan</label>
                        <p class="text-gray-900 font-semibold mt-1 flex items-center gap-2">
                            <i class="fas fa-clock text-blue-500 text-sm"></i>
                            {{ $kunjungan->jadwal->time_label }}
                        </p>
                    </div>
                    <div class="group">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Durasi</label>
                        <p class="text-gray-900 font-semibold mt-1 flex items-center gap-2">
                            <i class="fas fa-hourglass-half text-blue-500 text-sm"></i>
                            {{ $kunjungan->jadwal->duration }} jam
                        </p>
                    </div>
                    @else
                    <div class="group">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Status Jadwal</label>
                        <div class="mt-2 p-3 bg-red-50 rounded-lg border border-red-100 flex items-center gap-2">
                            <i class="fas fa-exclamation-triangle text-red-500"></i>
                            <p class="text-red-700 font-semibold">Jadwal belum ditentukan</p>
                        </div>
                    </div>
                    @endif
                    <div class="group">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Dibuat</label>
                        <p class="text-gray-900 font-semibold mt-1 flex items-center gap-2">
                            <i class="fas fa-clock text-gray-500 text-sm"></i>
                            {{ $kunjungan->created_at->format('d M Y H:i') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column - Documents & Status -->
    <div class="space-y-6">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-6 py-4 border-b border-gray-100">
                <h4 class="text-lg font-semibold text-gray-800 flex items-center gap-3">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <i class="fas fa-file-alt text-purple-600"></i>
                    </div>
                    Dokumen Pendukung
                </h4>
            </div>
            
            <div class="p-6">
                @if($kunjungan->suratPengajuan)
                <div class="space-y-3">
                    <div class="flex items-center gap-4 p-4 bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-16 h-16 bg-gradient-to-br from-red-100 to-red-200 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-file-pdf text-red-600 text-2xl"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h5 class="font-semibold text-gray-900 text-lg">Surat Pengajuan</h5>
                            <p class="text-sm text-gray-600 mt-1">Dokumen resmi pengajuan kunjungan</p>
                            <div class="flex items-center gap-2 mt-2 text-xs text-gray-500">
                                <i class="fas fa-file-pdf text-red-500"></i>
                                <span>PDF Document</span>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="{{ asset('storage/' . $kunjungan->suratPengajuan) }}" 
                               target="_blank"
                               class="inline-flex items-center px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-colors font-medium shadow-sm">
                                <i class="fas fa-eye mr-2"></i>
                                Lihat
                            </a>
                        </div>
                    </div>
                </div>
                @else
                <div class="text-center py-12">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-file-alt text-4xl text-gray-300"></i>
                    </div>
                    <p class="text-gray-500 font-medium">Tidak ada dokumen yang diupload</p>
                    <p class="text-gray-400 text-sm mt-1">Pengunjung belum mengunggah surat pengajuan</p>
                </div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="bg-gradient-to-r from-amber-50 to-orange-50 px-6 py-4 border-b border-gray-100">
                <h4 class="text-lg font-semibold text-gray-800 flex items-center gap-3">
                    <div class="p-2 bg-amber-100 rounded-lg">
                        <i class="fas fa-info-circle text-amber-600"></i>
                    </div>
                    Status & Informasi
                </h4>
            </div>
            
            <div class="p-6">
                <div class="space-y-4">
                    <div class="group">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Status Saat Ini</label>
                        <div class="mt-2">
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold shadow-sm
                                {{ $kunjungan->status === 'PENDING' ? 'bg-yellow-100 text-yellow-800 border border-yellow-200' : '' }}
                                {{ $kunjungan->status === 'PROCESSING' ? 'bg-blue-100 text-blue-800 border border-blue-200' : '' }}
                                {{ $kunjungan->status === 'COMPLETED' ? 'bg-green-100 text-green-800 border border-green-200' : '' }}
                                {{ $kunjungan->status === 'CANCELLED' ? 'bg-red-100 text-red-800 border border-red-200' : '' }}">
                                @if($kunjungan->status === 'PENDING')
                                    <i class="fas fa-clock mr-2"></i>
                                @elseif($kunjungan->status === 'PROCESSING')
                                    <i class="fas fa-cog fa-spin mr-2"></i>
                                @elseif($kunjungan->status === 'COMPLETED')
                                    <i class="fas fa-check mr-2"></i>
                                @elseif($kunjungan->status === 'CANCELLED')
                                    <i class="fas fa-times mr-2"></i>
                                @endif
                                {{ $kunjungan->status_label }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="group">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">ID Kunjungan</label>
                        <div class="mt-2 p-3 bg-gray-50 rounded-lg border border-gray-100">
                            <p class="text-gray-900 font-mono text-sm break-all">{{ $kunjungan->id }}</p>
                        </div>
                    </div>
                    
                    <div class="group">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Link Tracking</label>
                        <div class="mt-2 p-3 bg-blue-50 rounded-lg border border-blue-100">
                            <a href="{{ route('kunjungan.tracking', $kunjungan->id) }}" 
                               target="_blank" 
                               class="text-blue-600 hover:text-blue-800 underline text-sm break-all font-medium">
                                {{ route('kunjungan.tracking', $kunjungan->id) }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>