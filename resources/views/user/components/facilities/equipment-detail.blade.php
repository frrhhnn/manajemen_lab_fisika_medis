@extends('layouts.user-section')

@section('title', $alat->nama . ' - Detail Alat Laboratorium')

@section('breadcrumb')
    <li class="text-white/60">•</li>
    <li><a href="{{ route('equipment.rental') }}" class="text-white/80 hover:text-white transition-colors">Fasilitas</a></li>
    <li class="text-white/60">•</li>
    <li><a href="{{ route('equipment.rental') }}" class="text-white/80 hover:text-white transition-colors">Peminjaman Alat</a></li>
    <li class="text-white/60">•</li>
    <li class="text-white font-medium">{{ Str::limit($alat->nama, 20) }}</li>
@endsection

@section('page-title', $alat->nama)

@section('page-description', $alat->deskripsi)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-100">

    <!-- Equipment Overview Section -->
    <section class="py-16 overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, #10B981 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>
        <div class="absolute top-20 right-10 w-40 h-40 bg-emerald-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 left-10 w-32 h-32 bg-emerald-600/10 rounded-full blur-3xl"></div>

        <div class="container mx-auto px-6 relative z-10">
            <!-- Equipment Overview Card -->
            <div class="max-w-6xl mx-auto mb-16" data-aos="fade-up">
                <div class="bg-white/90 backdrop-blur-sm rounded-3xl overflow-hidden shadow-2xl border border-gray-100/50">
                    <div class="md:flex">
                        <!-- Equipment Image -->
                        <div class="md:w-1/2 relative overflow-hidden">
                            <img src="{{ $alat->image_url ? asset('storage/' . $alat->image_url) : asset('images/facilities/default-alat.jpg') }}" alt="{{ $alat->nama }}" class="w-full h-64 md:h-full object-cover">
                            <div class="absolute top-6 left-6">
                                <span class="{{ $alat->jumlah_tersedia > 0 ? 'bg-emerald-500' : 'bg-red-500' }} text-white px-4 py-2 rounded-full font-bold">
                                    {{ $alat->jumlah_tersedia > 0 ? 'Tersedia' : 'Tidak Tersedia' }}
                                </span>
                            </div>
                            <div class="absolute top-6 right-6 bg-white/90 backdrop-blur-sm text-gray-800 px-3 py-1 rounded-full font-bold">
                                {{ $alat->kode }}
                            </div>
                        </div>
                        
                        <!-- Equipment Info -->
                        <div class="md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
                            <!-- Basic Info -->
                            <div class="mb-6">
                                <span class="inline-block bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full text-sm font-semibold mb-4">
                                    {{ $alat->nama_kategori }}
                                </span>
                                <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $alat->nama }}</h1>
                                <p class="text-gray-600 leading-relaxed">{{ $alat->deskripsi }}</p>
                            </div>

                            <!-- Stock & Availability -->
                            <div class="bg-gray-50 rounded-2xl p-6 mb-6">
                                <h4 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                                    <i class="fas fa-box text-emerald-500"></i>
                                    Ketersediaan Stok
                                </h4>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="text-center">
                                        <p class="text-2xl font-bold text-emerald-600">{{ $alat->jumlah_tersedia }}</p>
                                        <p class="text-sm text-gray-600">Unit Tersedia</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-2xl font-bold text-gray-800">{{ $alat->stok }}</p>
                                        <p class="text-sm text-gray-600">Total Stok</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4 mt-4">
                                    <div class="text-center">
                                        <p class="text-xl font-bold text-yellow-600">{{ $alat->jumlah_dipinjam }}</p>
                                        <p class="text-sm text-gray-600">Sedang Dipinjam</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-xl font-bold text-red-600">{{ $alat->jumlah_rusak }}</p>
                                        <p class="text-sm text-gray-600">Rusak</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Button -->
                            @if($alat->jumlah_tersedia > 0)
                                <button onclick="addToCartDetail('{{ $alat->id }}', '{{ $alat->nama }}', '{{ $alat->kode }}', '{{ $alat->image_url ? asset('storage/' . $alat->image_url) : asset('images/facilities/default-alat.jpg') }}', {{ $alat->jumlah_tersedia }})"
                                        class="w-full bg-gradient-to-r from-emerald-500 to-emerald-600 text-white py-4 rounded-xl font-semibold hover:from-emerald-600 hover:to-emerald-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                                    <i class="fas fa-cart-plus mr-2"></i>
                                    Tambah ke Keranjang
                                </button>
                            @else
                                <div class="w-full bg-gray-300 text-gray-500 py-4 rounded-xl font-semibold text-center">
                                    <i class="fas fa-times-circle mr-2"></i>
                                    Stok Tidak Tersedia
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Detailed Information Section -->
    <section class="py-16 bg-white/50 backdrop-blur-sm">
        <div class="container mx-auto px-6">
            <div class="max-w-6xl mx-auto space-y-8">
                
                <!-- Equipment Specifications -->
                <div class="bg-white/90 backdrop-blur-sm rounded-3xl p-8 shadow-xl border border-gray-100/50" data-aos="fade-up">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-info-circle text-white text-xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">Informasi Alat</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between py-2 border-b border-gray-200">
                                <span class="text-gray-600">Kode Alat:</span>
                                <span class="font-semibold text-gray-800">{{ $alat->kode }}</span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-gray-200">
                                <span class="text-gray-600">Kategori:</span>
                                <span class="font-semibold text-gray-800">{{ $alat->nama_kategori }}</span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-gray-200">
                                <span class="text-gray-600">Stok Total:</span>
                                <span class="font-semibold text-gray-800">{{ $alat->stok }}</span>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between py-2 border-b border-gray-200">
                                <span class="text-gray-600">Tersedia:</span>
                                <span class="font-semibold text-emerald-600">{{ $alat->jumlah_tersedia }}</span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-gray-200">
                                <span class="text-gray-600">Dipinjam:</span>
                                <span class="font-semibold text-yellow-600">{{ $alat->jumlah_dipinjam }}</span>
                            </div>
                            @if($alat->harga)
                            <div class="flex items-center justify-between py-2 border-b border-gray-200">
                                <span class="text-gray-600">Harga:</span>
                                <span class="font-semibold text-gray-800">Rp {{ number_format($alat->harga, 0, ',', '.') }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Usage Guidelines -->
                <div class="bg-white/90 backdrop-blur-sm rounded-3xl p-8 shadow-xl border border-gray-100/50" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-amber-600 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-book text-white text-xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">Panduan Umum Peminjaman</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Persiapan -->
                        <div class="bg-amber-50 border border-amber-100 rounded-2xl p-6">
                            <h4 class="text-lg font-bold text-amber-800 mb-4 flex items-center gap-2">
                                <i class="fas fa-play-circle text-amber-600"></i>
                                Persiapan
                            </h4>
                            <div class="space-y-3">
                                <div class="flex items-start gap-3">
                                    <div class="w-6 h-6 bg-amber-200 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                        <i class="fas fa-check text-amber-700 text-xs"></i>
                                    </div>
                                    <p class="text-amber-800 text-sm">Lengkapi formulir peminjaman dengan data yang valid</p>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-6 h-6 bg-amber-200 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                        <i class="fas fa-check text-amber-700 text-xs"></i>
                                    </div>
                                    <p class="text-amber-800 text-sm">Pastikan memahami cara penggunaan alat</p>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-6 h-6 bg-amber-200 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                        <i class="fas fa-check text-amber-700 text-xs"></i>
                                    </div>
                                    <p class="text-amber-800 text-sm">Siapkan dokumen identitas dan surat permohonan</p>
                                </div>
                            </div>
                        </div>

                        <!-- Penggunaan -->
                        <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6">
                            <h4 class="text-lg font-bold text-blue-800 mb-4 flex items-center gap-2">
                                <i class="fas fa-tools text-blue-600"></i>
                                Penggunaan
                            </h4>
                            <div class="space-y-3">
                                <div class="flex items-start gap-3">
                                    <div class="w-6 h-6 bg-blue-200 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                        <i class="fas fa-check text-blue-700 text-xs"></i>
                                    </div>
                                    <p class="text-blue-800 text-sm">Gunakan alat sesuai dengan petunjuk yang diberikan</p>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-6 h-6 bg-blue-200 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                        <i class="fas fa-check text-blue-700 text-xs"></i>
                                    </div>
                                    <p class="text-blue-800 text-sm">Jaga alat dengan baik selama masa peminjaman</p>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-6 h-6 bg-blue-200 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                        <i class="fas fa-check text-blue-700 text-xs"></i>
                                    </div>
                                    <p class="text-blue-800 text-sm">Laporkan segera jika terjadi kerusakan</p>
                                </div>
                            </div>
                        </div>

                        <!-- Pengembalian -->
                        <div class="bg-green-50 border border-green-100 rounded-2xl p-6">
                            <h4 class="text-lg font-bold text-green-800 mb-4 flex items-center gap-2">
                                <i class="fas fa-undo text-green-600"></i>
                                Pengembalian
                            </h4>
                            <div class="space-y-3">
                                <div class="flex items-start gap-3">
                                    <div class="w-6 h-6 bg-green-200 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                        <i class="fas fa-check text-green-700 text-xs"></i>
                                    </div>
                                    <p class="text-green-800 text-sm">Kembalikan alat sesuai jadwal yang disepakati</p>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-6 h-6 bg-green-200 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                        <i class="fas fa-check text-green-700 text-xs"></i>
                                    </div>
                                    <p class="text-green-800 text-sm">Pastikan alat dalam kondisi bersih dan baik</p>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-6 h-6 bg-green-200 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                        <i class="fas fa-check text-green-700 text-xs"></i>
                                    </div>
                                    <p class="text-green-800 text-sm">Lengkapi proses pengembalian dengan admin</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Important Notice -->
                    <div class="mt-8 bg-red-50 border border-red-200 rounded-2xl p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-exclamation-triangle text-red-600"></i>
                            </div>
                            <h4 class="font-bold text-red-800">Penting untuk Diperhatikan</h4>
                        </div>
                        <div class="space-y-2 text-red-700">
                            <p>• Peminjam wajib mengikuti briefing keselamatan sebelum menggunakan alat</p>
                            <p>• Kerusakan akibat kelalaian pengguna akan dikenakan biaya penggantian</p>
                            <p>• Alat harus dikembalikan dalam kondisi bersih dan berfungsi normal</p>
                            <p>• Laporkan segera jika terjadi masalah atau kerusakan selama penggunaan</p>
                        </div>
                    </div>
                </div>

                <!-- Back to Catalog -->
                <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                    <a href="{{ route('equipment.rental') }}" class="inline-flex items-center gap-3 bg-white/80 backdrop-blur-sm border border-gray-200 text-gray-700 px-8 py-4 rounded-xl font-semibold hover:bg-gray-50 transition-all duration-300 shadow-md hover:shadow-lg">
                        <i class="fas fa-arrow-left"></i>
                        Kembali ke Katalog Alat
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
// Add to cart function for detail page
function addToCartDetail(id, nama, kode, image, available) {
    if (available === 0) return;
    
    let cart = JSON.parse(localStorage.getItem('equipmentCart')) || [];
    
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
            quantity: 1,
            available: available
        });
        showNotification('Alat berhasil ditambahkan ke keranjang');
    }
    
    localStorage.setItem('equipmentCart', JSON.stringify(cart));
}

// Show notification
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 ${type === 'success' ? 'bg-emerald-500' : 'bg-red-500'} text-white px-6 py-3 rounded-lg shadow-lg z-50`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>
@endsection 