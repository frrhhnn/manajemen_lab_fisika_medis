@extends('layouts.user-section')

@section('title', 'Kunjungan Laboratorium - Laboratorium Fisika Medis')

@section('breadcrumb')
    <li class="text-white/60">•</li>
    <li class="text-white font-medium">Fasilitas</li>
    <li class="text-white/60">•</li>
    <li class="text-white font-medium">Kunjungan Laboratorium</li>
@endsection

@section('page-title', 'Kunjungan Laboratorium')

@section('page-description', 'Ajukan kunjungan ke laboratorium untuk studi banding, penelitian, atau kegiatan edukasi lainnya.')

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
                        <i class="fas fa-calendar-check text-white text-2xl"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Panduan Kunjungan Laboratorium</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">Ikuti langkah-langkah berikut untuk mengajukan kunjungan ke laboratorium dengan mudah dan terstruktur.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <!-- Step 1 -->
                    <div class="text-center p-6 bg-emerald-50 rounded-2xl border border-emerald-100">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-white font-bold text-lg">1</span>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">Isi Formulir</h3>
                        <p class="text-gray-600 text-sm">Lengkapi formulir kunjungan dengan data yang diperlukan</p>
                    </div>

                    <!-- Step 2 -->
                    <div class="text-center p-6 bg-emerald-50 rounded-2xl border border-emerald-100">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-white font-bold text-lg">2</span>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">Pilih Jadwal</h3>
                        <p class="text-gray-600 text-sm">Pilih tanggal dan sesi kunjungan yang tersedia</p>
                    </div>

                    <!-- Step 3 -->
                    <div class="text-center p-6 bg-emerald-50 rounded-2xl border border-emerald-100">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-white font-bold text-lg">3</span>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">Verifikasi</h3>
                        <p class="text-gray-600 text-sm">Admin akan memverifikasi pengajuan kunjungan</p>
                    </div>

                    <!-- Step 4 -->
                    <div class="text-center p-6 bg-emerald-50 rounded-2xl border border-emerald-100">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-white font-bold text-lg">4</span>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">Kunjungan</h3>
                        <p class="text-gray-600 text-sm">Lakukan kunjungan sesuai jadwal yang telah disepakati</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Visit Form Section -->
    <section class="py-16 px-16 bg-white/50 backdrop-blur-sm">
        <div class="container mx-auto px-6 lg:px-12">
            <!-- Lab Visit Form -->
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">Ajukan Kunjungan Laboratorium</h2>
                        <p class="text-gray-600">Silakan isi form di bawah ini untuk mengajukan kunjungan ke Laboratorium Fisika Medis</p>
                    </div>

                    @if($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('kunjungan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8" id="kunjunganForm">
                        @csrf
                        
                        <!-- Step 1: Personal Information -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                                <span class="w-8 h-8 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-sm font-bold mr-3">1</span>
                                Informasi Pribadi
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="namaPengunjung" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                                    <input type="text" id="namaPengunjung" name="namaPengunjung" value="{{ old('namaPengunjung') }}" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                </div>
                                
                                <div>
                                    <label for="noHp" class="block text-sm font-medium text-gray-700 mb-2">Nomor HP *</label>
                                    <input type="tel" id="noHp" name="noHp" value="{{ old('noHp') }}" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                </div>
                                
                                <div>
                                    <label for="namaInstansi" class="block text-sm font-medium text-gray-700 mb-2">Nama Instansi *</label>
                                    <input type="text" id="namaInstansi" name="namaInstansi" value="{{ old('namaInstansi') }}" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                </div>
                                
                                <div>
                                    <label for="jumlahPengunjung" class="block text-sm font-medium text-gray-700 mb-2">Jumlah Peserta *</label>
                                    <input type="number" id="jumlahPengunjung" name="jumlahPengunjung" value="{{ old('jumlahPengunjung', 1) }}" min="1" max="50" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                    <p class="text-xs text-gray-500 mt-1">Maksimal 50 orang</p>
                                </div>
                            </div>
                            
                            <div class="mt-6">
                                <label for="tujuan" class="block text-sm font-medium text-gray-700 mb-2">Tujuan Kunjungan *</label>
                                <textarea id="tujuan" name="tujuan" rows="3" required
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">{{ old('tujuan') }}</textarea>
                            </div>
                        </div>

                        <!-- Step 2: Visit Information -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                                <span class="w-8 h-8 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-sm font-bold mr-3">2</span>
                                Informasi Kunjungan
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Kunjungan *</label>
                                    <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal') }}" required
                                           min="{{ date('Y-m-d') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                           onkeydown="return false;">
                                    <p class="text-xs text-gray-500 mt-1">Kunjungan tidak dapat dilakukan pada hari Minggu</p>
                                </div>
                                
                                <div>
                                    <label for="waktu_kunjungan" class="block text-sm font-medium text-gray-700 mb-2">Waktu Kunjungan (1 Jam) *</label>
                                    <select id="waktu_kunjungan" name="waktu_kunjungan" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                        <option value="">Pilih slot waktu kunjungan</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Durasi Kunjungan</label>
                                    <div class="px-3 py-2 bg-green-50 border border-green-300 rounded-lg">
                                        <span class="text-green-700 font-medium">1 Jam</span>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Informasi</label>
                                    <div class="px-3 py-2 bg-blue-50 border border-blue-300 rounded-lg">
                                        <span class="text-blue-700 text-sm">Setiap kunjungan berlangsung selama 1 jam</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                <div class="flex items-start">
                                    <i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i>
                                    <div>
                                        <h4 class="font-medium text-blue-900 mb-1">Informasi Jadwal</h4>
                                        <p class="text-sm text-blue-700">
                                            • Jam operasional: 09:00 - 17:00 WIB<br>
                                            • Setiap sesi berdurasi 1 jam<br>
                                            • Kunjungan dapat dijadwalkan maksimal 1 bulan ke depan<br>
                                            • Jadwal dapat berubah sesuai agenda internal laboratorium
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Document Upload -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                                <span class="w-8 h-8 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-sm font-bold mr-3">3</span>
                                Upload Surat Pengajuan
                            </h3>
                            
                            <div>
                                <label for="suratPengajuan" class="block text-sm font-medium text-gray-700 mb-2">Surat Pengajuan Kunjungan *</label>
                                <input type="file" id="suratPengajuan" name="suratPengajuan" accept=".pdf,.jpg,.jpeg,.png" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                <p class="text-xs text-gray-500 mt-1">Format: PDF, JPG, JPEG, PNG (Maksimal 2MB)</p>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="px-8 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-200 transition-colors">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Kirim Pengajuan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tanggalInput = document.getElementById('tanggal');
    const waktuKunjunganSelect = document.getElementById('waktu_kunjungan');

    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    tanggalInput.min = today;

    // Function to check if date is Sunday
    function isSunday(dateString) {
        const date = new Date(dateString);
        return date.getDay() === 0;
    }

    // Function to show notification
    function showNotification(message, type = 'error') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 ${type === 'success' ? 'bg-emerald-500' : 'bg-red-500'} text-white`;
        notification.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} mr-2"></i>
                ${message}
            </div>
        `;

        document.body.appendChild(notification);
        setTimeout(() => notification.remove(), 4000);
    }

    // Function to validate date selection
    function validateDateSelection(input) {
        const selectedDate = input.value;
        if (selectedDate && isSunday(selectedDate)) {
            input.value = '';
            showNotification('Kunjungan tidak dapat dilakukan pada hari Minggu! Silakan pilih hari lain.', 'error');
            // Clear time slots when date is invalid
            waktuKunjunganSelect.innerHTML = '<option value="">Pilih slot waktu kunjungan</option>';
            return false;
        }
        return true;
    }

    // Function to disable Sundays in date picker
    function disableSundays() {
        // Set date change event to validate
        tanggalInput.addEventListener('input', function(e) {
            const selectedDate = e.target.value;
            if (selectedDate && isSunday(selectedDate)) {
                e.target.value = '';
                showNotification('Kunjungan tidak dapat dilakukan pada hari Minggu!', 'error');
                waktuKunjunganSelect.innerHTML = '<option value="">Pilih slot waktu kunjungan</option>';
            }
        });

        // Override the date picker to disable Sundays using CSS
        const style = document.createElement('style');
        style.textContent = `
            input[type="date"]::-webkit-calendar-picker-indicator {
                filter: invert(0.5);
            }
        `;
        document.head.appendChild(style);

        // Add event listener to prevent Sunday selection via keyboard
        tanggalInput.addEventListener('keydown', function(e) {
            // Allow navigation keys
            const allowedKeys = ['Tab', 'Escape', 'Enter', 'Home', 'End', 'ArrowLeft', 'ArrowUp', 'ArrowRight', 'ArrowDown'];
            if (allowedKeys.includes(e.key)) {
                return;
            }
            // Block all other keys to prevent manual typing
            e.preventDefault();
        });
    }

    function populateTimeSlots() {
        const selectedDate = tanggalInput.value;
        
        // Clear existing options
        waktuKunjunganSelect.innerHTML = '<option value="">Pilih slot waktu kunjungan</option>';

        if (!selectedDate) return;

        // Validate date is not Sunday before proceeding
        if (!validateDateSelection(tanggalInput)) {
            return;
        }

        // Show loading state
        waktuKunjunganSelect.innerHTML = '<option value="">Memuat jadwal tersedia...</option>';
        waktuKunjunganSelect.disabled = true;

        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        // Fetch available sessions for the selected date
        fetch(`/kunjungan/available-sessions?date=${selectedDate}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken || ''
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            waktuKunjunganSelect.innerHTML = '<option value="">Pilih slot waktu kunjungan</option>';
            waktuKunjunganSelect.disabled = false;
            
            console.log('Received data:', data); // Debug log
            
            if (data.available_sessions && data.available_sessions.length > 0) {
                data.available_sessions.forEach(session => {
                    const option = document.createElement('option');
                    option.value = session.waktuKunjungan || `${session.jamMulai}-${session.jamSelesai}`;
                    option.textContent = session.time || `${session.jamMulai} - ${session.jamSelesai}`;
                    waktuKunjunganSelect.appendChild(option);
                });
                
                showNotification(`${data.available_sessions.length} slot waktu tersedia untuk tanggal ${selectedDate}`, 'success');
            } else {
                const option = document.createElement('option');
                option.value = '';
                option.textContent = 'Tidak ada slot tersedia untuk tanggal ini';
                option.disabled = true;
                waktuKunjunganSelect.appendChild(option);
                
                showNotification('Tidak ada slot waktu tersedia untuk tanggal yang dipilih', 'error');
            }
        })
        .catch(error => {
            console.error('Error fetching available sessions:', error);
            waktuKunjunganSelect.innerHTML = '<option value="">Error memuat jadwal - coba lagi</option>';
            waktuKunjunganSelect.disabled = false;
            showNotification('Gagal memuat jadwal. Silakan coba lagi.', 'error');
        });
    }

    // Event listeners
    tanggalInput.addEventListener('change', function() {
        // Double check for Sunday validation
        if (this.value && isSunday(this.value)) {
            this.value = '';
            showNotification('Kunjungan tidak dapat dilakukan pada hari Minggu!', 'error');
            waktuKunjunganSelect.innerHTML = '<option value="">Pilih slot waktu kunjungan</option>';
            return;
        }
        populateTimeSlots();
    });
    
    // Initialize Sunday blocking
    disableSundays();

    // Initialize if date is already selected
    if (tanggalInput.value) {
        if (!isSunday(tanggalInput.value)) {
            populateTimeSlots();
        } else {
            tanggalInput.value = '';
            showNotification('Tanggal yang dipilih adalah hari Minggu. Silakan pilih hari lain.', 'error');
        }
    }

    // Form submission validation
    const form = document.getElementById('kunjunganForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            console.log('Form submitting...');
            
            // Validate date is not Sunday
            const selectedDate = tanggalInput.value;
            if (!selectedDate) {
                e.preventDefault();
                showNotification('Silakan pilih tanggal kunjungan terlebih dahulu!', 'error');
                return false;
            }
            
            if (isSunday(selectedDate)) {
                e.preventDefault();
                tanggalInput.value = '';
                showNotification('Kunjungan tidak dapat dilakukan pada hari Minggu!', 'error');
                return false;
            }
            
            // Validate time slot is selected
            if (!waktuKunjunganSelect.value) {
                e.preventDefault();
                showNotification('Silakan pilih waktu kunjungan terlebih dahulu!', 'error');
                waktuKunjunganSelect.focus();
                return false;
            }
            
            console.log('Form validation passed, submitting...');
            console.log('Selected date:', selectedDate);
            console.log('Selected time:', waktuKunjunganSelect.value);
        });
    }
});
</script>
@endsection 