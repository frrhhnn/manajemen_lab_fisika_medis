@extends('layouts.user-section')

@section('title', 'Form Peminjaman Alat - Laboratorium Fisika Medis')

@section('breadcrumb')
    <li class="text-white/60">•</li>
    <li class="text-white font-medium">Fasilitas</li>
    <li class="text-white/60">•</li>
    <li class="text-white font-medium">Peminjaman Alat</li>
    <li class="text-white/60">•</li>
    <li class="text-white font-medium">Form Peminjaman</li>
@endsection

@section('page-title', 'Form Peminjaman Alat')

@section('page-description', 'Lengkapi formulir berikut untuk mengajukan peminjaman alat laboratorium')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-100">
    <section class="py-16">
        <div class="container mx-auto px-6">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('user.peminjaman.store') }}" method="POST" class="max-w-4xl mx-auto">
                @csrf
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Main Form -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Personal Information -->
                        <div class="bg-white/90 backdrop-blur-sm rounded-3xl p-8 shadow-xl border border-gray-100/50">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                                <div class="w-8 h-8 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-white text-sm"></i>
                                </div>
                                Informasi Peminjam
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                                    <input type="text" name="namaPeminjam" value="{{ old('namaPeminjam') }}" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nomor HP *</label>
                                    <input type="text" name="noHp" value="{{ old('noHp') }}" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300">
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label class="flex items-center gap-3">
                                        <input type="checkbox" name="is_mahasiswa_usk" value="1" {{ old('is_mahasiswa_usk') ? 'checked' : '' }}
                                            class="w-5 h-5 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500" id="is_mahasiswa_usk">
                                        <span class="text-sm font-medium text-gray-700">Saya adalah Mahasiswa USK</span>
                                    </label>
                                </div>
                                
                                <div id="npm_nim_field" class="md:col-span-2" style="display: none;">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">NPM/NIM *</label>
                                    <input type="text" name="npm_nim" value="{{ old('npm_nim') }}" 
                                        placeholder="Masukkan NPM/NIM Anda"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300">
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tujuan Peminjaman</label>
                                    <textarea name="tujuanPeminjaman" rows="3"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300">{{ old('tujuanPeminjaman') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Schedule Information -->
                        <div class="bg-white/90 backdrop-blur-sm rounded-3xl p-8 shadow-xl border border-gray-100/50">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-calendar text-white text-sm"></i>
                                </div>
                                Jadwal Peminjaman
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pinjam *</label>
                                    <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam') }}" required
                                        min="{{ date('Y-m-d') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pengembalian *</label>
                                    <input type="date" name="tanggal_pengembalian" value="{{ old('tanggal_pengembalian') }}" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300">
                                </div>
                            </div>
                        </div>

                        <!-- Equipment List -->
                        <div class="bg-white/90 backdrop-blur-sm rounded-3xl p-8 shadow-xl border border-gray-100/50">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                                <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-list text-white text-sm"></i>
                                </div>
                                Alat yang Dipinjam
                            </h3>
                            
                            <div id="equipment-list" class="space-y-4">
                                <!-- Equipment items will be populated by JavaScript -->
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white/90 backdrop-blur-sm rounded-3xl p-8 shadow-xl border border-gray-100/50 sticky top-8">
                            <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                                <div class="w-6 h-6 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-clipboard-list text-white text-xs"></i>
                                </div>
                                Ringkasan Peminjaman
                            </h3>
                            
                            <div id="order-summary" class="space-y-4 mb-6">
                                <!-- Summary will be populated by JavaScript -->
                            </div>
                            
                            <div class="border-t pt-6">
                                <div class="flex items-center justify-between text-lg font-bold text-gray-800 mb-6">
                                    <span>Total Item:</span>
                                    <span id="total-items">0</span>
                                </div>
                                
                                <button type="submit" class="w-full bg-gradient-to-r from-emerald-500 to-emerald-600 text-white py-4 rounded-xl font-semibold hover:from-emerald-600 hover:to-emerald-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                                    <i class="fas fa-paper-plane mr-2"></i>
                                    Ajukan Peminjaman
                                </button>
                                
                                <a href="{{ route('equipment.rental') }}" class="block w-full text-center bg-gray-100 text-gray-700 py-3 rounded-xl font-semibold hover:bg-gray-200 transition-all duration-300 mt-3">
                                    <i class="fas fa-arrow-left mr-2"></i>
                                    Kembali ke Daftar Alat
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Load cart from localStorage
    const cart = JSON.parse(localStorage.getItem('checkoutCart')) || [];
    
    if (cart.length === 0) {
        alert('Keranjang kosong. Silakan pilih alat terlebih dahulu.');
        window.location.href = '{{ route("equipment.rental") }}';
        return;
    }
    
    populateEquipmentList(cart);
    updateOrderSummary(cart);
    
    // Handle NPM/NIM field visibility
    const mahasiswaCheckbox = document.getElementById('is_mahasiswa_usk');
    const npmNimField = document.getElementById('npm_nim_field');
    
    if (mahasiswaCheckbox && npmNimField) {
        const npmNimInput = npmNimField.querySelector('input[name="npm_nim"]');
        
        // Show/hide field based on checkbox state
        function toggleNpmNimField() {
            console.log('Toggle function called, checkbox checked:', mahasiswaCheckbox.checked);
            if (mahasiswaCheckbox.checked) {
                npmNimField.style.display = 'block';
                if (npmNimInput) {
                    npmNimInput.required = true;
                }
                console.log('NPM/NIM field shown');
            } else {
                npmNimField.style.display = 'none';
                if (npmNimInput) {
                    npmNimInput.required = false;
                    npmNimInput.value = '';
                }
                console.log('NPM/NIM field hidden');
            }
        }
        
        // Initial state
        console.log('Initial checkbox state:', mahasiswaCheckbox.checked);
        toggleNpmNimField();
        
        // Add event listener
        mahasiswaCheckbox.addEventListener('change', function() {
            console.log('Checkbox changed, new state:', mahasiswaCheckbox.checked);
            toggleNpmNimField();
        });
    } else {
        console.error('Required elements not found: mahasiswaCheckbox or npmNimField');
    }
});

function populateEquipmentList(cart) {
    const container = document.getElementById('equipment-list');
    
    container.innerHTML = cart.map((item, index) => `
        <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl border">
            <img src="${item.image}" alt="${item.name}" class="w-16 h-16 object-cover rounded-lg">
            <div class="flex-1">
                <h4 class="font-semibold text-gray-800">${item.name}</h4>
                <p class="text-sm text-gray-600">${item.code}</p>
            </div>
            <div class="text-right">
                <div class="flex items-center gap-2 mb-2">
                    <button type="button" onclick="updateQuantity(${index}, -1)" class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                        <i class="fas fa-minus text-xs"></i>
                    </button>
                    <input type="number" name="items[${index}][jumlah]" value="${item.quantity}" min="1" max="${item.available}" 
                        class="w-16 text-center border border-gray-300 rounded-lg py-1" 
                        onchange="updateQuantityInput(${index}, this.value)">
                    <button type="button" onclick="updateQuantity(${index}, 1)" class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                        <i class="fas fa-plus text-xs"></i>
                    </button>
                </div>
                <p class="text-xs text-gray-500">Max: ${item.available}</p>
            </div>
            <input type="hidden" name="items[${index}][alat_id]" value="${item.id}">
            <button type="button" onclick="removeItem(${index})" class="text-red-500 hover:text-red-700 transition-colors ml-2">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `).join('');
}

function updateOrderSummary(cart) {
    const container = document.getElementById('order-summary');
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    
    container.innerHTML = cart.map(item => `
        <div class="flex justify-between items-center py-2 border-b border-gray-200">
            <div>
                <p class="font-medium text-gray-800">${item.name}</p>
                <p class="text-xs text-gray-500">${item.code}</p>
            </div>
            <span class="font-semibold text-gray-800">${item.quantity}x</span>
        </div>
    `).join('');
    
    document.getElementById('total-items').textContent = totalItems;
}

function updateQuantity(index, change) {
    const cart = JSON.parse(localStorage.getItem('checkoutCart')) || [];
    const newQuantity = cart[index].quantity + change;
    
    if (newQuantity < 1 || newQuantity > cart[index].available) return;
    
    cart[index].quantity = newQuantity;
    localStorage.setItem('checkoutCart', JSON.stringify(cart));
    
    populateEquipmentList(cart);
    updateOrderSummary(cart);
}

function updateQuantityInput(index, value) {
    const cart = JSON.parse(localStorage.getItem('checkoutCart')) || [];
    const newQuantity = parseInt(value);
    
    if (newQuantity < 1 || newQuantity > cart[index].available) return;
    
    cart[index].quantity = newQuantity;
    localStorage.setItem('checkoutCart', JSON.stringify(cart));
    
    updateOrderSummary(cart);
}

function removeItem(index) {
    const cart = JSON.parse(localStorage.getItem('checkoutCart')) || [];
    cart.splice(index, 1);
    localStorage.setItem('checkoutCart', JSON.stringify(cart));
    
    if (cart.length === 0) {
        alert('Keranjang kosong. Kembali ke daftar alat.');
        window.location.href = '{{ route("equipment.rental") }}';
        return;
    }
    
    populateEquipmentList(cart);
    updateOrderSummary(cart);
}

// Clear cart after successful submission
@if(session('success'))
    localStorage.removeItem('checkoutCart');
    localStorage.removeItem('equipmentCart');
@endif

// Additional NPM/NIM field handling with fallback
setTimeout(function() {
    const mahasiswaCheckbox = document.getElementById('is_mahasiswa_usk');
    const npmNimField = document.getElementById('npm_nim_field');
    
    if (mahasiswaCheckbox && npmNimField) {
        const npmNimInput = npmNimField.querySelector('input[name="npm_nim"]');
        
        function toggleNpmNimField() {
            if (mahasiswaCheckbox.checked) {
                npmNimField.style.display = 'block';
                npmNimField.style.visibility = 'visible';
                npmNimField.style.opacity = '1';
                if (npmNimInput) {
                    npmNimInput.required = true;
                }
            } else {
                npmNimField.style.display = 'none';
                npmNimField.style.visibility = 'hidden';
                npmNimField.style.opacity = '0';
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
        
        // Also add click event as backup
        mahasiswaCheckbox.addEventListener('click', function() {
            setTimeout(toggleNpmNimField, 10);
        });
    }
}, 100);
</script>
@endsection 