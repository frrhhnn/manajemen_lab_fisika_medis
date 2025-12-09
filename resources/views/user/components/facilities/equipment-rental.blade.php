@extends('layouts.user-section')

@section('title', 'Peminjaman Alat - Laboratorium Fisika Medis')

@section('breadcrumb')
    <li class="text-white/60">•</li>
    <li class="text-white font-medium">Fasilitas</li>
    <li class="text-white/60">•</li>
    <li class="text-white font-medium">Peminjaman Alat</li>
@endsection

@section('page-title', 'Peminjaman Alat Laboratorium')

@section('page-description', 'Akses peralatan laboratorium berkualitas tinggi untuk mendukung penelitian dan praktikum Anda dengan prosedur yang mudah dan aman.')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-100">
    <!-- Guide Section -->
    <section class="py-16 overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, #10B981 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>
        <div class="absolute top-20 right-10 w-40 h-40 bg-emerald-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 left-10 w-32 h-32 bg-emerald-600/10 rounded-full blur-3xl"></div>

        <div class="container mx-auto px-6 relative z-10">
            <!-- How to Apply Card -->
            <div class="bg-white/90 backdrop-blur-sm rounded-3xl p-8 md:p-12 shadow-2xl border border-gray-100/50 mb-16" data-aos="fade-up">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-clipboard-list text-white text-2xl"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Panduan Peminjaman Alat</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">Ikuti langkah-langkah berikut untuk melakukan peminjaman alat laboratorium dengan mudah dan aman.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 md:gap-6">
                    <!-- Step 1 -->
                    <div class="text-center p-4 md:p-6 bg-emerald-50 rounded-2xl border border-emerald-100">
                        <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4">
                            <span class="text-white font-bold text-sm md:text-lg">1</span>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2 text-sm md:text-base">Pilih Alat</h3>
                        <p class="text-gray-600 text-xs md:text-sm">Pilih alat yang dibutuhkan dan tambahkan ke keranjang peminjaman</p>
                    </div>

                    <!-- Step 2 -->
                    <div class="text-center p-4 md:p-6 bg-emerald-50 rounded-2xl border border-emerald-100">
                        <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4">
                            <span class="text-white font-bold text-sm md:text-lg">2</span>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2 text-sm md:text-base">Isi Formulir</h3>
                        <p class="text-gray-600 text-xs md:text-sm">Lengkapi formulir peminjaman dengan data yang diperlukan</p>
                    </div>

                    <!-- Step 3 -->
                    <div class="text-center p-4 md:p-6 bg-emerald-50 rounded-2xl border border-emerald-100">
                        <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4">
                            <span class="text-white font-bold text-sm md:text-lg">3</span>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2 text-sm md:text-base">Verifikasi</h3>
                        <p class="text-gray-600 text-xs md:text-sm">Admin akan memverifikasi pengajuan dan ketersediaan alat</p>
                    </div>

                    <!-- Step 4 -->
                    <div class="text-center p-4 md:p-6 bg-emerald-50 rounded-2xl border border-emerald-100">
                        <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4">
                            <span class="text-white font-bold text-sm md:text-lg">4</span>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2 text-sm md:text-base">Pengajuan Surat</h3>
                        <p class="text-gray-600 text-xs md:text-sm">Pengajuan surat peminjaman alat kepada pihak laboratorium dengan format yang sudah ditentukan</p>
                    </div>
                    
                    <!-- Step 5 -->
                    <div class="text-center p-4 md:p-6 bg-emerald-50 rounded-2xl border border-emerald-100">
                        <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4">
                            <span class="text-white font-bold text-sm md:text-lg">5</span>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2 text-sm md:text-base">Penggunaan</h3>
                        <p class="text-gray-600 text-xs md:text-sm">Gunakan peralatan sesuai jadwal yang telah disepakati</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Equipment Catalog Section -->
    <section class="py-16 px-16 bg-white/50 backdrop-blur-sm" 
             x-data="equipmentData()" 
             x-init="initEquipment()">
        <div class="container mx-auto px-6 lg:px-12">
            <!-- Search & Filter Section -->
            <div class="max-w-6xl mx-auto mb-12" data-aos="fade-up">
                <h2 class="text-4xl font-bold text-gray-800 text-center mb-8">Katalog Peralatan</h2>
                
                <!-- Filter Categories -->
                <div class="flex flex-wrap justify-center gap-2 md:gap-4 mb-6 md:mb-8">
                    <!-- Equipment Count Display -->
                    <div class="w-full text-center mb-4">
                        <span class="inline-block bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2 rounded-full text-sm font-medium shadow-lg">
                            <i class="fas fa-th-large mr-2"></i>
                            <span x-text="'Menampilkan ' + filteredEquipmentCount + ' alat'"></span>
                        </span>
                    </div>

                    <button 
                        @click="selectedCategory = 'Semua'"
                        :class="{ 
                            'bg-emerald-500 text-white shadow-xl transform scale-105 ring-2 ring-emerald-300': selectedCategory === 'Semua',
                            'bg-white text-emerald-600 hover:bg-emerald-50 hover:shadow-lg hover:scale-105': selectedCategory !== 'Semua' 
                        }"
                        class="filter-btn px-3 md:px-6 py-2 md:py-3 rounded-full font-semibold border border-emerald-500 text-xs md:text-sm transition-all duration-300 shadow-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-opacity-50">
                        <i class="fas fa-th-large mr-2"></i>
                        Semua
                    </button>
                    <template x-for="kategori in categories" :key="kategori.id">
                        <button 
                            @click="selectedCategory = kategori.nama_kategori"
                            :class="{ 
                                'bg-emerald-500 text-white shadow-xl transform scale-105 ring-2 ring-emerald-300': selectedCategory === kategori.nama_kategori,
                                'bg-white text-emerald-600 hover:bg-emerald-50 hover:shadow-lg hover:scale-105': selectedCategory !== kategori.nama_kategori 
                            }"
                            class="filter-btn px-3 md:px-6 py-2 md:py-3 rounded-full font-semibold border border-emerald-500 text-xs md:text-sm transition-all duration-300 shadow-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-opacity-50">
                            <i :class="getCategoryIcon(kategori.nama_kategori)" class="mr-2"></i>
                            <span x-text="kategori.nama_kategori"></span>
                        </button>
                    </template>
                </div>
                
                <!-- Search Box & Cart Button -->
                <div class="flex flex-col sm:flex-row gap-4 items-stretch sm:items-center justify-between">
                    <!-- Search Box -->
                    <div class="relative flex-1 max-w-md">
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input 
                            type="text" 
                            x-model="searchTerm"
                            @input="filterEquipment()"
                            placeholder="Cari nama alat atau kode..." 
                            class="w-full pl-12 pr-4 py-3 bg-white/90 backdrop-blur-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300"
                        >
                    </div>
                    
                    <!-- Cart Button -->
                    <button @click="scrollToCart()" class="relative bg-gradient-to-r from-emerald-500 to-emerald-600 text-white px-4 md:px-6 py-3 rounded-xl font-semibold hover:from-emerald-600 hover:to-emerald-700 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="hidden sm:inline">Keranjang</span>
                        <span x-show="cartItemCount > 0" x-text="cartItemCount" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs w-6 h-6 rounded-full flex items-center justify-center"></span>
                    </button>
                </div>
            </div>

            <!-- Equipment Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6 lg:gap-8 mb-16" id="equipment-grid">
                @forelse($alats ?? [] as $alat)
                    <div class="equipment-card group bg-white/90 backdrop-blur-sm rounded-2xl md:rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 border border-gray-100/50 hover:border-emerald-500/20 hover:-translate-y-2 md:hover:-translate-y-3" 
                         data-category="{{ $alat->kategoriAlat->nama_kategori ?? 'Lainnya' }}" 
                         data-search="{{ strtolower(($alat->nama ?? '') . ' ' . ($alat->kode ?? '')) }}"
                         data-equipment-id="{{ $alat->id }}"
                         data-equipment-name="{{ $alat->nama ?? 'Nama tidak tersedia' }}"
                         data-equipment-code="{{ $alat->kode ?? '-' }}"
                         data-equipment-image="{{ $alat->image_url }}"
                         data-equipment-available="{{ $alat->jumlah_tersedia ?? 0 }}"
                         data-aos="fade-up">
                        <!-- Equipment Image -->
                        <div class="relative overflow-hidden h-40 md:h-48">
                            <img src="{{ $alat->image_url }}" 
                                 alt="{{ $alat->nama ?? 'Gambar alat' }}" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            <div class="absolute top-4 left-4">
                                @php
                                    $statusClass = 'bg-emerald-500';
                                    $statusText = 'Tersedia';
                                    
                                    if ($alat->jumlah_rusak > 0 && $alat->jumlah_tersedia == 0) {
                                        $statusClass = 'bg-red-500';
                                        $statusText = 'Rusak';
                                    } elseif ($alat->jumlah_dipinjam > 0 && $alat->jumlah_tersedia == 0) {
                                        $statusClass = 'bg-orange-500';
                                        $statusText = 'Sedang Dipinjam';
                                    } elseif ($alat->jumlah_tersedia == 0) {
                                        $statusClass = 'bg-gray-500';
                                        $statusText = 'Tidak Tersedia';
                                    }
                                @endphp
                                <span class="{{ $statusClass }} text-white px-3 py-1 rounded-full text-xs font-bold">
                                    {{ $statusText }}
                                </span>
                            </div>
                            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm text-gray-800 px-2 py-1 rounded-full text-xs font-bold">{{ $alat->kode ?: '-' }}</div>
                        </div>

                        <!-- Equipment Content -->
                        <div class="p-6">
                            <!-- Equipment Name & Category -->
                            <div class="mb-4">
                                <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-emerald-600 transition-colors">{{ $alat->nama }}</h3>
                                <span class="text-sm text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full font-medium">{{ $alat->nama_kategori }}</span>
                            </div>

                            <!-- Equipment Description -->
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ Str::limit($alat->deskripsi, 150) }}</p>

                            <!-- Equipment Info -->
                            <div class="space-y-2 mb-6">
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-check text-emerald-500 mr-2"></i>
                                    <span>Stok Total: {{ $alat->stok }}</span>
                                </div>
                                @if($alat->harga)
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-tag text-emerald-500 mr-2"></i>
                                    <span>Harga: Rp {{ number_format($alat->harga, 0, ',', '.') }}</span>
                                </div>
                                @endif
                            </div>

                            <!-- Stock Info & Actions -->
                            <div class="space-y-4">
                                <!-- Detailed Stock Information -->
                                <div class="bg-gray-50 rounded-xl p-4 space-y-2">
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-600">Tersedia:</span>
                                        <span class="font-bold text-emerald-600">{{ $alat->jumlah_tersedia }}</span>
                                    </div>
                                    @if($alat->jumlah_dipinjam > 0)
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-600">Sedang Dipinjam:</span>
                                        <span class="font-bold text-orange-600">{{ $alat->jumlah_dipinjam }}</span>
                                    </div>
                                    @endif
                                    @if($alat->jumlah_rusak > 0)
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-600">Rusak:</span>
                                        <span class="font-bold text-red-600">{{ $alat->jumlah_rusak }}</span>
                                    </div>
                                    @endif
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="grid grid-cols-2 gap-3">
                                    <a href="{{ route('equipment.detail', $alat->id) }}"
                                       class="bg-white/80 backdrop-blur-sm border border-emerald-500 text-emerald-600 py-3 rounded-xl font-semibold transition-all duration-300 shadow-md hover:shadow-lg hover:bg-white flex items-center justify-center gap-2 text-sm">
                                        <i class="fas fa-eye"></i>
                                        <span>Lihat Detail</span>
                                    </a>
                                    
                                    @php
                                        $canAddToCart = $alat->jumlah_tersedia > 0;
                                        $buttonText = 'Tambah';
                                        $buttonClass = 'bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white';
                                        
                                        if ($alat->jumlah_rusak > 0 && $alat->jumlah_tersedia == 0) {
                                            $buttonText = 'Rusak';
                                            $buttonClass = 'bg-red-300 text-red-600 cursor-not-allowed';
                                        } elseif ($alat->jumlah_dipinjam > 0 && $alat->jumlah_tersedia == 0) {
                                            $buttonText = 'Sedang Dipinjam';
                                            $buttonClass = 'bg-orange-300 text-orange-600 cursor-not-allowed';
                                        } elseif ($alat->jumlah_tersedia == 0) {
                                            $buttonText = 'Tidak Tersedia';
                                            $buttonClass = 'bg-gray-300 text-gray-500 cursor-not-allowed';
                                        }
                                    @endphp
                                    
                                    <button onclick="addToCartFromCard('{{ $alat->id }}', '{{ $alat->nama }}', '{{ $alat->kode ?: '-' }}', '{{ $alat->image_url }}', {{ $alat->jumlah_tersedia }})"
                                            {{ !$canAddToCart ? 'disabled' : '' }}
                                            class="add-to-cart-btn {{ $buttonClass }} py-3 rounded-xl font-semibold transition-all duration-300 shadow-md hover:shadow-lg flex items-center justify-center gap-2 text-sm">
                                        <i class="fas fa-plus"></i>
                                        <span>{{ $buttonText }}</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum ada alat tersedia</h3>
                        <p class="text-gray-500">Silakan cek kembali nanti atau hubungi admin</p>
                    </div>
                @endforelse
            </div>

            <!-- Empty State for Search -->
            <div id="empty-search-state" class="hidden text-center py-12">
                <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Tidak ada alat ditemukan</h3>
                <p class="text-gray-500">Coba ubah kategori atau kata kunci pencarian.</p>
            </div>

            <!-- Cart Section -->
            <div id="cart-section" class="max-w-6xl mx-auto mb-16 mt-8">
                <div class="bg-white/90 backdrop-blur-sm rounded-3xl p-8 shadow-2xl border border-gray-100/50">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-bold text-gray-800 flex items-center gap-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-shopping-cart text-white text-sm"></i>
                            </div>
                            Keranjang Peminjaman
                        </h3>
                        <span id="cart-badge" class="bg-emerald-500 text-white px-3 py-1 rounded-full text-sm font-bold">0 item</span>
                    </div>
                    
                    <div id="cart-items" class="space-y-4 mb-6">
                        <!-- Cart items will be populated by JavaScript -->
                    </div>
                    
                    <div x-show="cartItemCount > 0" class="flex justify-between items-center pt-6 border-t border-gray-200">
                        <button @click="clearCart()" class="text-red-500 hover:text-red-700 transition-colors flex items-center gap-2">
                            <i class="fas fa-trash"></i>
                            Kosongkan Keranjang
                        </button>
                        <button @click="showRentalForm()" class="bg-gradient-to-r from-emerald-500 to-emerald-600 text-white px-8 py-3 rounded-xl font-semibold hover:from-emerald-600 hover:to-emerald-700 transition-all duration-300 shadow-lg">
                            <i class="fas fa-arrow-right mr-2"></i>
                            Lanjutkan Peminjaman
                        </button>
                    </div>
                </div>
            </div>

            <!-- Rental Form Section -->
            <div id="rental-form-section" class="hidden max-w-6xl mx-auto mb-16">
                <form id="rental-form" action="{{ route('user.peminjaman.store') }}" method="POST">
                    @csrf
                    <div class="bg-white/90 backdrop-blur-sm rounded-3xl p-8 shadow-2xl border border-gray-100/50">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-2xl font-bold text-gray-800 flex items-center gap-3">
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-clipboard-list text-white text-sm"></i>
                                </div>
                                Formulir Peminjaman
                            </h3>
                            <button type="button" onclick="hideRentalForm()" class="text-gray-500 hover:text-gray-700 transition-colors">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                        
                        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 md:gap-8">
                            <!-- Left Column - Form Fields -->
                            <div class="space-y-6">
                                <!-- Personal Information -->
                                <div>
                                    <h4 class="text-base md:text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                                        <i class="fas fa-user text-emerald-500"></i>
                                        Informasi Peminjam
                                    </h4>
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                                            <input type="text" name="namaPeminjam" required class="w-full px-3 md:px-4 py-2 md:py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300 text-sm md:text-base">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor HP *</label>
                                            <input type="text" name="noHp" required class="w-full px-3 md:px-4 py-2 md:py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300 text-sm md:text-base">
                                        </div>
                                        <div>
                                            <label class="flex items-center gap-2 md:gap-3">
                                                <input type="checkbox" name="is_mahasiswa_usk" value="1" class="w-4 h-4 md:w-5 md:h-5 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500" id="is_mahasiswa_usk">
                                                <span class="text-xs md:text-sm font-medium text-gray-700">Saya adalah Mahasiswa USK</span>
                                            </label>
                                        </div>
                                        <div id="npm_nim_field" style="display: none;">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">NPM/NIM *</label>
                                            <input type="text" name="npm_nim" placeholder="Masukkan NPM/NIM Anda" class="w-full px-3 md:px-4 py-2 md:py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300 text-sm md:text-base">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Tujuan Peminjaman</label>
                                            <textarea name="tujuanPeminjaman" rows="3" class="w-full px-3 md:px-4 py-2 md:py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300 text-sm md:text-base"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Schedule Information -->
                                <div>
                                    <h4 class="text-base md:text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                                        <i class="fas fa-calendar text-blue-500"></i>
                                        Jadwal Peminjaman
                                    </h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pinjam *</label>
                                            <input type="date" name="tanggal_pinjam" required min="{{ date('Y-m-d') }}" class="w-full px-3 md:px-4 py-2 md:py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300 text-sm md:text-base">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pengembalian *</label>
                                            <input type="date" name="tanggal_pengembalian" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column - Cart Summary -->
                            <div>
                                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                                    <i class="fas fa-list text-purple-500"></i>
                                    Ringkasan Peminjaman
                                </h4>
                                <div class="bg-gray-50 rounded-2xl p-6">
                                    <div id="form-cart-summary" class="space-y-4 mb-6">
                                        <!-- Summary items will be populated by JavaScript -->
                                    </div>
                                    <div class="border-t pt-4">
                                        <div class="flex justify-between items-center text-lg font-bold text-gray-800">
                                            <span>Total Item:</span>
                                            <span id="form-total-items">0</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-6 space-y-3">
                                    <button type="submit" id="submit-btn" class="w-full bg-gradient-to-r from-emerald-500 to-emerald-600 text-white py-4 rounded-xl font-semibold hover:from-emerald-600 hover:to-emerald-700 transition-all duration-300 shadow-lg">
                                        <i class="fas fa-paper-plane mr-2"></i>
                                        Ajukan Peminjaman
                                    </button>
                                    <button type="button" onclick="hideRentalForm()" class="w-full bg-gray-100 text-gray-700 py-3 rounded-xl font-semibold hover:bg-gray-200 transition-all duration-300">
                                        <i class="fas fa-arrow-left mr-2"></i>
                                        Kembali ke Keranjang
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Hidden inputs for cart items -->
                        <div id="form-hidden-inputs">
                            <!-- Hidden inputs will be populated by JavaScript -->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<style>
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Styling untuk alat yang sudah dipilih */
    .equipment-selected {
        border: 2px solid #10B981 !important;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.05), rgba(16, 185, 129, 0.1)) !important;
        transform: scale(1.02);
        box-shadow: 0 10px 25px rgba(16, 185, 129, 0.2) !important;
    }
    
    .equipment-selected::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), transparent);
        pointer-events: none;
        border-radius: 1.5rem;
    }
    
    .selected-indicator {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.8;
        }
    }
    
    /* Smooth transitions untuk equipment cards */
    .equipment-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>

<script>
// Load data for Alpine.js
window.alatData = @json($alats ?? []);
window.kategoriData = @json($kategoris ?? []);

// Cart data (isolated from alatData)
let cart = JSON.parse(localStorage.getItem('equipmentCart')) || [];
console.log('Initial cart loaded:', cart);

// Add to cart from equipment card
function addToCartFromCard(id, nama, kode, image, available) {
    if (available === 0) {
        // Check if equipment is damaged or rented
        const equipmentCard = document.querySelector(`[data-equipment-id="${id}"]`);
        if (equipmentCard) {
            const statusBadge = equipmentCard.querySelector('.absolute.top-4.left-4 span');
            if (statusBadge) {
                const status = statusBadge.textContent.trim();
                if (status === 'Rusak') {
                    showNotification('Alat sedang dalam perbaikan dan tidak dapat dipinjam', 'error');
                } else if (status === 'Sedang Dipinjam') {
                    showNotification('Alat sedang dipinjam oleh pengguna lain', 'error');
                } else {
                    showNotification('Alat tidak tersedia untuk dipinjam', 'error');
                }
            } else {
                showNotification('Alat tidak tersedia untuk dipinjam', 'error');
            }
        }
        return;
    }

    const existingItem = cart.find(item => item.id === id);
    if (existingItem) {
        if (existingItem.quantity < available) {
            existingItem.quantity++;
            showNotification('Jumlah alat di keranjang ditambah');
        } else {
            showNotification('Jumlah tidak boleh melebihi stok yang tersedia', 'error');
            return;
        }
    } else {
        cart.push({
            id: id,
            name: nama,
            code: kode,
            image: image,
            available: available,
            quantity: 1
        });
        // Tandai alat sebagai sudah dipilih
        markEquipmentAsSelected(id);
        showNotification('Alat berhasil ditambahkan ke keranjang');
    }

    updateCart();
    syncWithAlpineCart();
}

// Update cart
function updateCart() {
    localStorage.setItem('equipmentCart', JSON.stringify(cart));
    updateCartCount();
    updateCartSection();
}

// Sync with Alpine.js cart
function syncWithAlpineCart() {
    const alpineEl = document.querySelector('[x-data]');
    if (alpineEl && alpineEl._x_dataStack && alpineEl._x_dataStack[0]) {
        alpineEl._x_dataStack[0].cart = [...cart];
    }
}

// Update cart section display
function updateCartSection() {
    const cartSection = document.getElementById('cart-section');
    const cartItems = document.getElementById('cart-items');
    const cartBadge = document.getElementById('cart-badge');

    if (!cartSection || !cartItems || !cartBadge) return;

    const totalItems = cart.reduce((total, item) => total + item.quantity, 0);
    cartBadge.textContent = `${totalItems} item${totalItems !== 1 ? 's' : ''}`;

    // Cart section SELALU tampil, tidak pernah disembunyikan
    if (cart.length === 0) {
        cartItems.innerHTML = `
            <div class="text-center py-8">
                <i class="fas fa-shopping-cart text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-lg font-medium">Keranjang masih kosong</p>
                <p class="text-gray-400 text-sm mt-2">Pilih alat dari katalog di atas untuk memulai peminjaman</p>
            </div>
        `;
    } else {
        cartItems.innerHTML = cart.map(item => `
            <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl border">
                <img src="${item.image}" alt="${item.name}" class="w-16 h-16 object-cover rounded-lg">
                <div class="flex-1">
                    <h4 class="font-semibold text-gray-800">${item.name}</h4>
                    <p class="text-sm text-gray-600">${item.code}</p>
                    <p class="text-xs text-gray-500">Tersedia: ${item.available}</p>
                </div>
                <div class="flex items-center gap-2">
                    <button onclick="updateQuantity('${item.id}', ${item.quantity - 1})" class="cart-btn w-8 h-8 bg-gray-200 hover:bg-gray-300 rounded-full flex items-center justify-center transition-colors">
                        <i class="fas fa-minus text-xs"></i>
                    </button>
                    <span class="w-8 text-center font-semibold">${item.quantity}</span>
                    <button onclick="updateQuantity('${item.id}', ${item.quantity + 1})" class="cart-btn w-8 h-8 bg-gray-200 hover:bg-gray-300 rounded-full flex items-center justify-center transition-colors">
                        <i class="fas fa-plus text-xs"></i>
                    </button>
                </div>
                <button onclick="removeFromCart('${item.id}')" class="cart-btn text-red-500 hover:text-red-700 transition-colors ml-2">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `).join('');
    }

    // Update visibility tombol berdasarkan isi cart
    updateCartButtons();
}

// Update visibility tombol cart berdasarkan isi cart
function updateCartButtons() {
    const cartActionButtons = document.querySelector('#cart-section .flex.justify-between');
    if (cartActionButtons) {
        if (cart.length === 0) {
            cartActionButtons.style.display = 'none';
        } else {
            cartActionButtons.style.display = 'flex';
        }
    }
}

// Update cart count
function updateCartCount() {
    const count = cart.reduce((total, item) => total + item.quantity, 0);
    const countElement = document.querySelector('[x-text="cartItemCount"]');
    if (countElement) countElement.textContent = count;

    const badge = document.querySelector('.absolute.-top-2.-right-2');
    if (badge) {
        if (count > 0) {
            badge.textContent = count;
            badge.classList.remove('hidden');
        } else {
            badge.classList.add('hidden');
        }
    }
}

// Scroll to cart section
function scrollToCart() {
    const cartSection = document.getElementById('cart-section');
    if (cartSection) {
        cartSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}
window.scrollToCart = scrollToCart;
window.clearCart = clearCart;

// Update quantity
function updateQuantity(id, newQuantity) {
    const item = cart.find(item => item.id === id);
    if (!item) return;

    if (newQuantity <= 0) {
        removeFromCart(id);
        return;
    }

    if (newQuantity > item.available) {
        showNotification('Jumlah tidak boleh melebihi stok yang tersedia', 'error');
        return;
    }

    item.quantity = newQuantity;
    updateCart();
}

// Remove from cart
function removeFromCart(id) {
    // Cari dan hapus item dari cart
    const removedItem = cart.find(item => item.id === id);
    cart = cart.filter(item => item.id !== id);
    
    // Reset status visual alat yang dihapus
    if (removedItem) {
        const equipmentCard = document.querySelector(`[data-equipment-id="${id}"]`);
        if (equipmentCard) {
            removeEquipmentSelectedStatus(equipmentCard);
        }
    }
    
    updateCart();
    showNotification('Alat berhasil dihapus dari keranjang');
}

// Reset status visual semua alat
function resetAllEquipmentStatus() {
    const equipmentCards = document.querySelectorAll('.equipment-card');
    equipmentCards.forEach(card => {
        removeEquipmentSelectedStatus(card);
    });
}

// Menandai alat sebagai sudah dipilih
function markEquipmentAsSelected(equipmentId) {
    const equipmentCard = document.querySelector(`[data-equipment-id="${equipmentId}"]`);
    if (equipmentCard) {
        // Tambah class selected
        equipmentCard.classList.add('equipment-selected');
        
        // Ubah tombol "Tambah" menjadi "Sudah Dipilih"
        const addButton = equipmentCard.querySelector('.add-to-cart-btn');
        if (addButton) {
            addButton.innerHTML = `
                <i class="fas fa-check mr-2"></i>
                <span>Sudah Dipilih</span>
            `;
            addButton.classList.remove('bg-gradient-to-r', 'from-emerald-500', 'to-emerald-600', 'hover:from-emerald-600', 'hover:to-emerald-700');
            addButton.classList.add('bg-gray-400', 'cursor-not-allowed');
            addButton.disabled = true;
        }
        
        // Tambah overlay atau border indicator
        const cardContent = equipmentCard.querySelector('.p-6');
        if (cardContent && !cardContent.querySelector('.selected-indicator')) {
            const indicator = document.createElement('div');
            indicator.className = 'selected-indicator absolute top-2 right-2 bg-emerald-500 text-white px-2 py-1 rounded-full text-xs font-bold';
            indicator.innerHTML = '<i class="fas fa-check mr-1"></i>Dipilih';
            cardContent.style.position = 'relative';
            cardContent.appendChild(indicator);
        }
    }
}

// Menghapus status alat sebagai sudah dipilih
function removeEquipmentSelectedStatus(equipmentCard) {
    if (equipmentCard) {
        // Hapus class selected
        equipmentCard.classList.remove('equipment-selected');
        
        // Kembalikan tombol "Tambah" ke kondisi semula
        const addButton = equipmentCard.querySelector('.add-to-cart-btn');
        if (addButton) {
            const alatId = equipmentCard.getAttribute('data-equipment-id');
            const alatNama = equipmentCard.getAttribute('data-equipment-name');
            const alatKode = equipmentCard.getAttribute('data-equipment-code');
            const alatImage = equipmentCard.getAttribute('data-equipment-image');
            const alatAvailable = equipmentCard.getAttribute('data-equipment-available');
            
            addButton.innerHTML = `
                <i class="fas fa-plus"></i>
                <span>Tambah</span>
            `;
            addButton.classList.remove('bg-gray-400', 'cursor-not-allowed');
            addButton.classList.add('bg-gradient-to-r', 'from-emerald-500', 'to-emerald-600', 'hover:from-emerald-600', 'hover:to-emerald-700');
            addButton.disabled = false;
            
            // Restore onclick handler
            addButton.setAttribute('onclick', `addToCartFromCard('${alatId}', '${alatNama}', '${alatKode}', '${alatImage}', ${alatAvailable})`);
        }
        
        // Hapus indicator
        const indicator = equipmentCard.querySelector('.selected-indicator');
        if (indicator) {
            indicator.remove();
        }
    }
}

// Show rental form
function showRentalForm() {
    if (cart.length === 0) {
        alert('Keranjang masih kosong');
        return;
    }

    document.getElementById('rental-form-section').classList.remove('hidden');
    updateFormSummary();

    document.getElementById('rental-form-section').scrollIntoView({ 
        behavior: 'smooth', 
        block: 'start' 
    });
}

// Hide rental form
function hideRentalForm() {
    document.getElementById('rental-form-section').classList.add('hidden');
}

// Update form summary
function updateFormSummary() {
    console.log('updateFormSummary called, cart:', cart);
    
    const summaryContainer = document.getElementById('form-cart-summary');
    const totalItemsElement = document.getElementById('form-total-items');
    const hiddenInputsContainer = document.getElementById('form-hidden-inputs');

    if (!summaryContainer || !totalItemsElement || !hiddenInputsContainer) {
        console.error('Form summary elements not found!', {
            summaryContainer: !!summaryContainer,
            totalItemsElement: !!totalItemsElement,
            hiddenInputsContainer: !!hiddenInputsContainer
        });
        return;
    }

    const totalItems = cart.reduce((total, item) => total + item.quantity, 0);
    totalItemsElement.textContent = totalItems;

    summaryContainer.innerHTML = cart.map(item => `
        <div class="flex justify-between items-center py-2 border-b border-gray-200">
            <div>
                <p class="font-medium text-gray-800">${item.name}</p>
                <p class="text-xs text-gray-500">${item.code}</p>
            </div>
            <span class="font-semibold text-gray-800">${item.quantity}x</span>
        </div>
    `).join('');

    const hiddenInputsHTML = cart.map((item, index) => `
        <input type="hidden" name="items[${index}][alat_id]" value="${item.id}">
        <input type="hidden" name="items[${index}][jumlah]" value="${item.quantity}">
    `).join('');
    
    hiddenInputsContainer.innerHTML = hiddenInputsHTML;
    console.log('Hidden inputs generated:', hiddenInputsHTML);
}

// Clear cart function
function clearCart() {
    console.log('Clearing cart...');
    cart = [];
    localStorage.removeItem('equipmentCart');
    updateCart();
    syncWithAlpineCart();
    
    // Reset visual status of all equipment cards
    const equipmentCards = document.querySelectorAll('.equipment-card');
    equipmentCards.forEach(card => {
        const addButton = card.querySelector('.add-to-cart-btn');
        if (addButton) {
            addButton.innerHTML = '<i class="fas fa-plus mr-2"></i>Tambah ke Keranjang';
            addButton.classList.remove('bg-green-500', 'text-white');
            addButton.classList.add('bg-gradient-to-r', 'from-emerald-500', 'to-emerald-600', 'hover:from-emerald-600', 'hover:to-emerald-700', 'text-white');
        }
        
        // Remove selected badge if exists
        const selectedBadge = card.querySelector('.selected-badge');
        if (selectedBadge) {
            selectedBadge.remove();
        }
    });
    
    console.log('Cart cleared successfully');
}

// Show notification
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 ${type === 'success' ? 'bg-emerald-500' : 'bg-red-500'} text-white`;
    notification.textContent = message;

    document.body.appendChild(notification);
    setTimeout(() => notification.remove(), 3000);
}

// Filter equipment cards
function filterEquipment() {
    const selectedCategory = document.querySelector('[x-data]')?._x_dataStack?.[0]?.selectedCategory || 'Semua';
    const searchTerm = document.querySelector('[x-data]')?._x_dataStack?.[0]?.searchTerm || '';
    const cards = document.querySelectorAll('.equipment-card');
    const emptyState = document.getElementById('empty-search-state');
    let visibleCount = 0;

    cards.forEach(card => {
        const category = card.getAttribute('data-category');
        const searchData = card.getAttribute('data-search');

        const matchesCategory = selectedCategory === 'Semua' || category === selectedCategory;
        const matchesSearch = searchTerm === '' || searchData.includes(searchTerm.toLowerCase());

        if (matchesCategory && matchesSearch) {
            card.style.display = 'block';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    if (visibleCount === 0 && cards.length > 0) {
        emptyState.classList.remove('hidden');
    } else {
        emptyState.classList.add('hidden');
    }

    // Refresh AOS animations after filtering
    if (window.AOS && typeof window.AOS.refresh === 'function') {
        window.AOS.refresh();
    }
}

// Alpine.js component (simplified)
function equipmentData() {
    return {
        selectedCategory: 'Semua',
        searchTerm: '',
        cart: [],
        showCart: false,
        alats: [],
        categories: [],

        initEquipment() {
            this.alats = window.alatData || [];
            this.categories = window.kategoriData || [];
            this.cart = JSON.parse(localStorage.getItem('equipmentCart')) || [];
        },

        get cartItemCount() {
            return this.cart.reduce((total, item) => total + item.quantity, 0);
        },

        get filteredEquipmentCount() {
            if (this.selectedCategory === 'Semua') {
                return this.alats.length;
            }
            return this.alats.filter(alat => 
                alat.kategoriAlat && alat.kategoriAlat.nama_kategori === this.selectedCategory
            ).length;
        },

        getCategoryIcon(categoryName) {
            const icons = {
                'Detektor Radiasi': 'fas fa-radiation',
                'Imaging Medical': 'fas fa-x-ray',
                'Dosimetri': 'fas fa-calculator',
                'Kalibrasi': 'fas fa-cogs',
                'Peralatan Laboratorium': 'fas fa-flask',
                'Sumber Radioaktif': 'fas fa-atom',
                'Alat Ukur': 'fas fa-ruler',
                'Proteksi Radiasi': 'fas fa-shield-alt',
                'Lainnya': 'fas fa-ellipsis-h'
            };
            return icons[categoryName] || 'fas fa-tag';
        },

        addToCartAlpine(alat) {
            // Check if equipment is available
            if (alat.jumlah_tersedia === 0) {
                // Determine the status based on other fields
                if (alat.jumlah_rusak > 0) {
                    showNotification('Alat sedang dalam perbaikan dan tidak dapat dipinjam', 'error');
                } else if (alat.jumlah_dipinjam > 0) {
                    showNotification('Alat sedang dipinjam oleh pengguna lain', 'error');
                } else {
                    showNotification('Alat tidak tersedia untuk dipinjam', 'error');
                }
                return;
            }

            const existingItem = this.cart.find(item => item.id === alat.id);
            if (existingItem) {
                if (existingItem.quantity < alat.jumlah_tersedia) {
                    existingItem.quantity++;
                } else {
                    showNotification('Jumlah tidak boleh melebihi stok yang tersedia', 'error');
                    return;
                }
            } else {
                this.cart.push({
                    id: alat.id,
                    name: alat.nama,
                    code: alat.kode || '-',
                    image: alat.image_url ? '/storage/' + alat.image_url : '/images/facilities/default-alat.jpg',
                    available: alat.jumlah_tersedia,
                    quantity: 1
                });
            }
            localStorage.setItem('equipmentCart', JSON.stringify(this.cart));
            this.syncWithVanillaJS();
            showNotification('Alat berhasil ditambahkan ke keranjang');
        },

        removeFromCart(alatId) {
            this.cart = this.cart.filter(item => item.id !== alatId);
            localStorage.setItem('equipmentCart', JSON.stringify(this.cart));
            this.syncWithVanillaJS();
        },

        updateQuantity(alatId, newQuantity) {
            const item = this.cart.find(item => item.id === alatId);
            if (item) {
                if (newQuantity <= 0) {
                    this.removeFromCart(alatId);
                } else {
                    const alat = this.alats.find(a => a.id === alatId);
                    if (alat) {
                        item.quantity = Math.min(newQuantity, alat.jumlah_tersedia);
                        localStorage.setItem('equipmentCart', JSON.stringify(this.cart));
                        this.syncWithVanillaJS();
                    }
                }
            }
        },

        showRentalForm() {
            if (this.cart.length === 0) {
                alert('Keranjang masih kosong');
                return;
            }
            window.cart = [...this.cart];
            localStorage.setItem('equipmentCart', JSON.stringify(this.cart));
            showRentalForm();
            this.showCart = false;
        },

        syncWithVanillaJS() {
            window.cart = [...this.cart];
            updateCartSection();
        },

        clearCart() {
            this.cart = [];
            localStorage.removeItem('equipmentCart');
            this.syncWithVanillaJS();
            console.log('Cart cleared from Alpine.js');
        }
    }
}

// Inisialisasi status visual alat berdasarkan cart yang sudah ada
function initializeEquipmentStatus() {
    // Loop through existing cart items dan tandai alat yang sudah dipilih
    cart.forEach(item => {
        markEquipmentAsSelected(item.id);
    });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Check if user is coming from tracking page (successful submission)
    const isFromTracking = sessionStorage.getItem('fromTracking');
    if (isFromTracking) {
        console.log('User coming from tracking page, clearing cart...');
        clearCart();
        sessionStorage.removeItem('fromTracking');
    }
    
    updateCart();
    
    // Pastikan cart section selalu tampil saat page load
    const cartSection = document.getElementById('cart-section');
    if (cartSection) {
        cartSection.classList.remove('hidden');
        updateCartSection(); // Inisialisasi tampilan cart
    }
    
    // Inisialisasi status visual alat berdasarkan cart yang ada
    initializeEquipmentStatus();

    // Set up filtering watchers
    setTimeout(() => {
        const alpineEl = document.querySelector('[x-data]');
        if (alpineEl && alpineEl._x_dataStack && alpineEl._x_dataStack[0]) {
            const alpineData = alpineEl._x_dataStack[0];

            Object.defineProperty(alpineData, '_selectedCategory', {
                value: alpineData.selectedCategory,
                writable: true
            });
            Object.defineProperty(alpineData, '_searchTerm', {
                value: alpineData.searchTerm,
                writable: true
            });

            Object.defineProperty(alpineData, 'selectedCategory', {
                get() { return this._selectedCategory; },
                set(value) { 
                    this._selectedCategory = value; 
                    filterEquipment(); 
                }
            });

            Object.defineProperty(alpineData, 'searchTerm', {
                get() { return this._searchTerm; },
                set(value) { 
                    this._searchTerm = value; 
                    filterEquipment(); 
                }
            });
        }
    }, 100);

    // Set up date constraints with Sunday validation
    const today = new Date().toISOString().split('T')[0];
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    const tomorrowString = tomorrow.toISOString().split('T')[0];

    // Function to check if date is Sunday
    function isSunday(dateString) {
        const date = new Date(dateString);
        return date.getDay() === 0;
    }

    // Function to show date validation message
    function showDateValidationMessage(message, type = 'error') {
        showNotification(message, type);
    }

    // Function to validate date selection
    function validateDateSelection(input, action = 'peminjaman') {
        const selectedDate = input.value;
        if (selectedDate && isSunday(selectedDate)) {
            input.value = '';
            showDateValidationMessage(`${action} tidak dapat dilakukan pada hari Minggu!`, 'error');
            return false;
        }
        return true;
    }

    const pinjamDate = document.querySelector('input[name="tanggal_pinjam"]');
    const kembaliDate = document.querySelector('input[name="tanggal_pengembalian"]');

    if (pinjamDate) {
        pinjamDate.min = today;
        
        // Add Sunday validation for pinjam date
        pinjamDate.addEventListener('change', function() {
            if (!validateDateSelection(this, 'Tanggal peminjaman')) {
                return;
            }
            
            if (kembaliDate) {
                kembaliDate.min = this.value;
                if (kembaliDate.value && kembaliDate.value <= this.value) {
                    const nextDay = new Date(this.value);
                    nextDay.setDate(nextDay.getDate() + 1);
                    kembaliDate.value = nextDay.toISOString().split('T')[0];
                }
            }
        });

        // Add input event listener for real-time validation
        pinjamDate.addEventListener('input', function() {
            validateDateSelection(this, 'Tanggal peminjaman');
        });
    }

    if (kembaliDate) {
        kembaliDate.min = tomorrowString;
        
        // Add Sunday validation for kembali date
        kembaliDate.addEventListener('change', function() {
            validateDateSelection(this, 'Tanggal pengembalian');
        });

        // Add input event listener for real-time validation
        kembaliDate.addEventListener('input', function() {
            validateDateSelection(this, 'Tanggal pengembalian');
        });
    }

    // Handle NPM/NIM field visibility
    const mahasiswaCheckbox = document.getElementById('is_mahasiswa_usk');
    const npmNimField = document.getElementById('npm_nim_field');
    
    if (mahasiswaCheckbox && npmNimField) {
        const npmNimInput = npmNimField.querySelector('input[name="npm_nim"]');
        
        function toggleNpmNimField() {
            if (mahasiswaCheckbox.checked) {
                npmNimField.style.display = 'block';
                if (npmNimInput) {
                    npmNimInput.required = true;
                }
            } else {
                npmNimField.style.display = 'none';
                if (npmNimInput) {
                    npmNimInput.required = false;
                    npmNimInput.value = '';
                }
            }
        }
        
        // Initial state
        toggleNpmNimField();
        
        // Add event listener
        mahasiswaCheckbox.addEventListener('change', toggleNpmNimField);
    }

    // Set up form submission handler
    const rentalForm = document.getElementById('rental-form');
    if (rentalForm) {
        console.log('Form found, adding event listener');
        rentalForm.addEventListener('submit', function(e) {
            console.log('Form submission triggered, cart length:', cart.length);
            
            if (cart.length === 0) {
                console.log('Cart is empty, preventing submission');
                e.preventDefault();
                alert('Keranjang masih kosong');
                return;
            }

            // Validate dates are not Sunday
            const tanggalPinjam = this.querySelector('input[name="tanggal_pinjam"]').value;
            const tanggalKembali = this.querySelector('input[name="tanggal_pengembalian"]').value;
            
            if (tanggalPinjam && isSunday(tanggalPinjam)) {
                e.preventDefault();
                showDateValidationMessage('Tanggal peminjaman tidak boleh pada hari Minggu!', 'error');
                return;
            }
            
            if (tanggalKembali && isSunday(tanggalKembali)) {
                e.preventDefault();
                showDateValidationMessage('Tanggal pengembalian tidak boleh pada hari Minggu!', 'error');
                return;
            }
            
            console.log('Updating form summary...');
            updateFormSummary();
            
            // Check if hidden inputs are populated
            const hiddenInputsContainer = document.getElementById('form-hidden-inputs');
            console.log('Hidden inputs HTML:', hiddenInputsContainer.innerHTML);
            
            if (!hiddenInputsContainer.innerHTML.trim()) {
                console.error('Hidden inputs are empty!');
                e.preventDefault();
                alert('Terjadi kesalahan sistem. Silakan coba lagi.');
                return;
            }
            
            console.log('Form validation passed, allowing submission');
            
            // Show loading state
            const submitButton = e.target.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...';
            }
            
            // Clear cart after successful form submission
            setTimeout(() => {
                console.log('Form submitted successfully, clearing cart...');
                clearCart();
            }, 1000);
        });
    } else {
        console.error('Rental form not found!');
    }
    
    // Additional fallback: Direct button click handler
    const submitBtn = document.getElementById('submit-btn');
    if (submitBtn) {
        submitBtn.addEventListener('click', function(e) {
            console.log('Submit button clicked directly');
            
            // Ensure form data is ready
            if (cart.length > 0) {
                updateFormSummary();
                console.log('Form data prepared for submission');
            }
        });
    }
});
</script>

<style>
/* Enhanced filter button styles */
.filter-btn {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.filter-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.5s;
}

.filter-btn:hover::before {
    left: 100%;
}

.filter-btn:focus {
    outline: none;
    transform: translateY(-2px);
}

/* Active filter button styles */
.filter-btn.bg-emerald-500 {
    background-color: #10b981 !important;
    color: white !important;
    box-shadow: 0 4px 14px 0 rgba(16, 185, 129, 0.4);
}

.filter-btn.bg-emerald-500:hover {
    background-color: #059669 !important;
    transform: scale(1.05) translateY(-2px);
    box-shadow: 0 8px 25px 0 rgba(16, 185, 129, 0.5);
}

/* Pulse animation for active filter */
@keyframes pulse-green {
    0%, 100% {
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
    }
    50% {
        box-shadow: 0 0 0 10px rgba(16, 185, 129, 0);
    }
}

/* Equipment count badge animation */
@keyframes count-update {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

.equipment-count-update {
    animation: count-update 0.3s ease-in-out;
}
</style>
@endsection