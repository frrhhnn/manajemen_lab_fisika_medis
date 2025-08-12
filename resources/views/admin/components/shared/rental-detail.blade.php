<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Left Column - Borrower Information -->
    <div class="space-y-4">
        <h4 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
            <i class="fas fa-user text-emerald-500"></i>
            Informasi Peminjam
        </h4>
        
        <div class="bg-gray-50 rounded-xl p-4">
            <div class="grid grid-cols-1 gap-3">
                <div>
                    <label class="text-sm font-medium text-gray-600">Nama Lengkap</label>
                    <p class="text-gray-800 font-semibold">{{ $peminjaman->namaPeminjam }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Nomor HP</label>
                    <p class="text-gray-800 font-semibold">{{ $peminjaman->noHp }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Status Mahasiswa</label>
                    <p class="text-gray-800 font-semibold">
                        @if($peminjaman->is_mahasiswa_usk)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Mahasiswa USK</span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Bukan Mahasiswa USK</span>
                        @endif
                    </p>
                </div>
                @if($peminjaman->is_mahasiswa_usk && $peminjaman->npm_nim)
                <div>
                    <label class="text-sm font-medium text-gray-600">NPM/NIM</label>
                    <p class="text-gray-800 font-semibold">{{ $peminjaman->npm_nim }}</p>
                </div>
                @endif
                @if($peminjaman->tujuanPeminjaman)
                <div>
                    <label class="text-sm font-medium text-gray-600">Tujuan Peminjaman</label>
                    <p class="text-gray-800">{{ $peminjaman->tujuanPeminjaman }}</p>
                </div>
                @endif
            </div>
        </div>

        <h4 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
            <i class="fas fa-calendar text-blue-500"></i>
            Jadwal Peminjaman
        </h4>
        
        <div class="bg-gray-50 rounded-xl p-4">
            <div class="grid grid-cols-1 gap-3">
                <div>
                    <label class="text-sm font-medium text-gray-600">Tanggal Pinjam</label>
                    <p class="text-gray-800 font-semibold">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Tanggal Pengembalian</label>
                    <p class="text-gray-800 font-semibold">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pengembalian)->format('d M Y') }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Durasi</label>
                    <p class="text-gray-800 font-semibold">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->diffInDays(\Carbon\Carbon::parse($peminjaman->tanggal_pengembalian)) }} hari</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Dibuat</label>
                    <p class="text-gray-800 font-semibold">{{ $peminjaman->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column - Equipment List & Status -->
    <div class="space-y-4">
        <h4 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
            <i class="fas fa-list text-purple-500"></i>
            Daftar Alat
        </h4>
        
        <div class="bg-gray-50 rounded-xl p-4">
            <div class="space-y-3">
                @foreach($peminjaman->peminjamanItems as $item)
                <div class="flex items-center gap-3 p-3 bg-white rounded-lg border">
                    <img src="{{ $item->alat->image_url ? asset('storage/' . $item->alat->image_url) : asset('images/facilities/default-alat.jpg') }}" 
                         alt="{{ $item->alat->nama }}" 
                         class="w-12 h-12 object-cover rounded-lg">
                    <div class="flex-1">
                        <h5 class="font-semibold text-gray-800">{{ $item->alat->nama }}</h5>
                        <p class="text-sm text-gray-600">{{ $item->alat->kode }} • {{ $item->alat->nama_kategori }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-bold text-emerald-600">{{ $item->jumlah }}x</p>
                        <p class="text-sm text-gray-500">Unit</p>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="mt-4 pt-4 border-t border-gray-200">
                <div class="flex justify-between items-center">
                    <span class="font-semibold text-gray-800">Total Item:</span>
                    <span class="text-xl font-bold text-emerald-600">{{ $peminjaman->peminjamanItems->sum('jumlah') }}</span>
                </div>
            </div>
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
                            {{ $peminjaman->status === 'PENDING' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $peminjaman->status === 'PROCESSING' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $peminjaman->status === 'COMPLETED' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $peminjaman->status === 'CANCELLED' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ $peminjaman->status }}
                        </span>
                    </p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">ID Peminjaman</label>
                    <p class="text-gray-800 font-mono text-sm break-all">{{ $peminjaman->id }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Link Tracking</label>
                    <p class="text-gray-800 text-sm break-all">
                        <a href="{{ route('user.peminjaman.tracking', $peminjaman->id) }}" 
                           target="_blank" 
                           class="text-blue-600 hover:text-blue-800 underline">
                            {{ route('user.peminjaman.tracking', $peminjaman->id) }}
                        </a>
                    </p>
                </div>
                @if($peminjaman->kondisi_pengembalian)
                <div>
                    <label class="text-sm font-medium text-gray-600">Kondisi Pengembalian</label>
                    <p class="text-gray-800">{{ $peminjaman->kondisi_pengembalian }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div> 