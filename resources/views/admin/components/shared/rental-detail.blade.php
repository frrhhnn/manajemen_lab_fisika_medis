<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Left Column - Borrower Information -->
    <div class="space-y-6">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="bg-gradient-to-r from-emerald-50 to-green-50 px-6 py-4 border-b border-gray-100">
                <h4 class="text-lg font-semibold text-gray-800 flex items-center gap-3">
                    <div class="p-2 bg-emerald-100 rounded-lg">
                        <i class="fas fa-user text-emerald-600"></i>
                    </div>
                    Informasi Peminjam
                </h4>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 gap-4">
                    <div class="group">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Lengkap</label>
                        <p class="text-gray-900 font-semibold text-lg mt-1">{{ $peminjaman->namaPeminjam }}</p>
                    </div>
                    <div class="group">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Nomor HP</label>
                        <p class="text-gray-900 font-semibold mt-1 flex items-center gap-2">
                            <i class="fas fa-phone text-emerald-500 text-sm"></i>
                            {{ $peminjaman->noHp }}
                        </p>
                    </div>
                    <div class="group">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Status Mahasiswa</label>
                        <div class="mt-2">
                            @if($peminjaman->is_mahasiswa_usk)
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-blue-100 text-blue-800 border border-blue-200">
                                    <i class="fas fa-graduation-cap mr-2"></i>
                                    Mahasiswa USK
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-gray-100 text-gray-800 border border-gray-200">
                                    <i class="fas fa-user mr-2"></i>
                                    Bukan Mahasiswa USK
                                </span>
                            @endif
                        </div>
                    </div>
                    @if($peminjaman->is_mahasiswa_usk && $peminjaman->npm_nim)
                    <div class="group">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">NPM/NIM</label>
                        <p class="text-gray-900 font-semibold mt-1 flex items-center gap-2">
                            <i class="fas fa-id-card text-blue-500 text-sm"></i>
                            {{ $peminjaman->npm_nim }}
                        </p>
                    </div>
                    @endif
                    @if($peminjaman->tujuanPeminjaman)
                    <div class="group">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Tujuan Peminjaman</label>
                        <div class="mt-2 p-3 bg-gray-50 rounded-lg border border-gray-100">
                            <p class="text-gray-800 leading-relaxed">{{ $peminjaman->tujuanPeminjaman }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-100">
                <h4 class="text-lg font-semibold text-gray-800 flex items-center gap-3">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <i class="fas fa-calendar text-blue-600"></i>
                    </div>
                    Jadwal Peminjaman
                </h4>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 gap-4">
                    <div class="group">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal Pinjam</label>
                        <p class="text-gray-900 font-semibold text-lg mt-1 flex items-center gap-2">
                            <i class="fas fa-calendar-day text-blue-500 text-sm"></i>
                            {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}
                        </p>
                    </div>
                    <div class="group">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal Pengembalian</label>
                        <p class="text-gray-900 font-semibold text-lg mt-1 flex items-center gap-2">
                            <i class="fas fa-calendar-check text-green-500 text-sm"></i>
                            {{ \Carbon\Carbon::parse($peminjaman->tanggal_pengembalian)->format('d M Y') }}
                        </p>
                    </div>
                    <div class="group">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Durasi</label>
                        <p class="text-gray-900 font-semibold mt-1 flex items-center gap-2">
                            <i class="fas fa-hourglass-half text-purple-500 text-sm"></i>
                            {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->diffInDays(\Carbon\Carbon::parse($peminjaman->tanggal_pengembalian)) }} hari
                        </p>
                    </div>
                    <div class="group">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Dibuat</label>
                        <p class="text-gray-900 font-semibold mt-1 flex items-center gap-2">
                            <i class="fas fa-clock text-gray-500 text-sm"></i>
                            {{ $peminjaman->created_at->format('d M Y H:i') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column - Equipment List & Status -->
    <div class="space-y-6">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-6 py-4 border-b border-gray-100">
                <h4 class="text-lg font-semibold text-gray-800 flex items-center gap-3">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <i class="fas fa-list text-purple-600"></i>
                    </div>
                    Daftar Alat
                </h4>
            </div>
            
            <div class="p-6">
                <div class="space-y-3">
                    @foreach($peminjaman->peminjamanItems as $item)
                    <div class="flex items-center gap-4 p-4 bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-16 h-16 flex-shrink-0">
                            <img src="{{ $item->alat->image_url }}" 
                                 alt="{{ $item->alat->nama }}" 
                                 class="w-full h-full object-cover rounded-xl border border-gray-200">
                        </div>
                        <div class="flex-1 min-w-0">
                            <h5 class="font-semibold text-gray-900 text-lg">{{ $item->alat->nama }}</h5>
                            <p class="text-sm text-gray-600 mt-1 flex items-center gap-2">
                                <i class="fas fa-barcode text-gray-400"></i>
                                {{ $item->alat->kode }}
                            </p>
                            <p class="text-sm text-blue-600 mt-1 flex items-center gap-2">
                                <i class="fas fa-tag text-blue-400"></i>
                                {{ $item->alat->nama_kategori }}
                            </p>
                        </div>
                        <div class="flex-shrink-0 text-right">
                            <div class="text-2xl font-bold text-emerald-600">{{ $item->jumlah }}x</div>
                            <p class="text-sm text-gray-500 mt-1">Unit</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <div class="flex justify-between items-center p-4 bg-gradient-to-r from-emerald-50 to-green-50 rounded-xl border border-emerald-100">
                        <span class="font-semibold text-gray-800 flex items-center gap-2">
                            <i class="fas fa-calculator text-emerald-600"></i>
                            Total Item:
                        </span>
                        <span class="text-2xl font-bold text-emerald-600">{{ $peminjaman->peminjamanItems->sum('jumlah') }}</span>
                    </div>
                </div>
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
                                {{ $peminjaman->status === 'PENDING' ? 'bg-yellow-100 text-yellow-800 border border-yellow-200' : '' }}
                                {{ $peminjaman->status === 'PROCESSING' ? 'bg-blue-100 text-blue-800 border border-blue-200' : '' }}
                                {{ $peminjaman->status === 'COMPLETED' ? 'bg-green-100 text-green-800 border border-green-200' : '' }}
                                {{ $peminjaman->status === 'CANCELLED' ? 'bg-red-100 text-red-800 border border-red-200' : '' }}">
                                @if($peminjaman->status === 'PENDING')
                                    <i class="fas fa-clock mr-2"></i>
                                @elseif($peminjaman->status === 'PROCESSING')
                                    <i class="fas fa-cog fa-spin mr-2"></i>
                                @elseif($peminjaman->status === 'COMPLETED')
                                    <i class="fas fa-check mr-2"></i>
                                @elseif($peminjaman->status === 'CANCELLED')
                                    <i class="fas fa-times mr-2"></i>
                                @endif
                                {{ $peminjaman->status }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="group">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">ID Peminjaman</label>
                        <div class="mt-2 p-3 bg-gray-50 rounded-lg border border-gray-100">
                            <p class="text-gray-900 font-mono text-sm break-all">{{ $peminjaman->id }}</p>
                        </div>
                    </div>
                    
                    <div class="group">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Link Tracking</label>
                        <div class="mt-2 p-3 bg-blue-50 rounded-lg border border-blue-100">
                            <a href="{{ route('user.peminjaman.tracking', $peminjaman->id) }}" 
                               target="_blank" 
                               class="text-blue-600 hover:text-blue-800 underline text-sm break-all font-medium">
                                {{ route('user.peminjaman.tracking', $peminjaman->id) }}
                            </a>
                        </div>
                    </div>
                    
                    @if($peminjaman->kondisi_pengembalian)
                    <div class="group">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Kondisi Pengembalian</label>
                        <div class="mt-2 p-3 bg-green-50 rounded-lg border border-green-100">
                            <p class="text-gray-800 leading-relaxed">{{ $peminjaman->kondisi_pengembalian }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div> 