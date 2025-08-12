<!-- Galeri Tab Component -->
<div>
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 md:p-6">
            <div class="flex flex-col space-y-4 sm:space-y-0 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-gray-900">Kelola Galeri</h2>
                    <p class="mt-1 text-sm text-gray-600">Kelola semua gambar dalam galeri</p>
                </div>
                <div class="w-full sm:w-auto">
                    <button type="button" class="btn btn-primary rounded-lg py-2 px-4 w-full sm:w-auto" onclick="showAddImageModal()">
                        <i class="fas fa-plus mr-2"></i>
                        <span>Tambah Gambar</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @include('admin.components.shared.stat-card', [
                'title' => 'Total Galeri Pengurus',
                'value' => \App\Models\Gambar::where('kategori', 'PENGURUS')->count(),
                'icon' => 'users',
                'bgColor' => 'bg-emerald-100',
                'iconColor' => 'text-emerald-600',
                'textColor' => 'text-emerald-600'
            ])
            
            @include('admin.components.shared.stat-card', [
                'title' => 'Total Galeri Acara',
                'value' => \App\Models\Gambar::where('kategori', 'ACARA')->count(),
                'icon' => 'newspaper',
                'bgColor' => 'bg-blue-100',
                'iconColor' => 'text-blue-600',
                'textColor' => 'text-blue-600'
            ])
            
            @include('admin.components.shared.stat-card', [
                'title' => 'Total Galeri Fasilitas',
                'value' => \App\Models\Gambar::where('kategori', 'FASILITAS')->count(),
                'icon' => 'building',
                'bgColor' => 'bg-purple-100',
                'iconColor' => 'text-purple-600',
                'textColor' => 'text-purple-600'
            ])
        </div>

        <!-- Galeri Tabs -->
        <div class="mb-6" x-data="{ activeGalleryTab: 'pengurus' }">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                    <button 
                        @click="activeGalleryTab = 'pengurus'"
                        :class="{ 'border-emerald-500 text-emerald-600': activeGalleryTab === 'pengurus', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeGalleryTab !== 'pengurus' }"
                        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm"
                    >
                        Galeri Pengurus
                    </button>
                    <button 
                        @click="activeGalleryTab = 'acara'"
                        :class="{ 'border-emerald-500 text-emerald-600': activeGalleryTab === 'acara', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeGalleryTab !== 'acara' }"
                        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm"
                    >
                        Galeri Acara
                    </button>
                    <button 
                        @click="activeGalleryTab = 'fasilitas'"
                        :class="{ 'border-emerald-500 text-emerald-600': activeGalleryTab === 'fasilitas', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeGalleryTab !== 'fasilitas' }"
                        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm"
                    >
                        Galeri Fasilitas
                    </button>
                </nav>
            </div>

            <!-- Galeri Pengurus Tab -->
            <div x-show="activeGalleryTab === 'pengurus'" class="mt-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    @if(isset($gambarPengurus) && $gambarPengurus->count() > 0)
                        @foreach($gambarPengurus as $gambar)
                        <div class="bg-white border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                            <div class="relative">
                                <img src="{{ $gambar->fullUrl }}" alt="{{ $gambar->judul }}" 
                                     class="w-full h-72 object-cover">
                                <div class="absolute top-2 right-2">
                                    <button onclick="toggleVisibility('{{ $gambar->id }}')" class="p-1 rounded-full {{ $gambar->isVisible ? 'bg-green-600 text-white' : 'bg-gray-500 text-white' }} hover:opacity-80 transition-opacity">
                                        <div class="flex items-center gap-2 px-2">
                                            <i class="fas {{ $gambar->isVisible ? 'fa-eye' : 'fa-eye-slash' }} text-xs"></i>
                                            <span class="text-sm font-medium text-white">
                                                {{ $gambar->isVisible ? 'Tampil' : 'Sembunyi' }}
                                            </span>
                                        </div>
                                    </button>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-sm text-gray-900 mb-1">{{ $gambar->judul }}</h3>
                                <p class="text-xs text-gray-600 mb-2">{{ Str::limit($gambar->deskripsi, 50) }}</p>
                                @if($gambar->biodataPengurus)
                                    <p class="text-xs text-emerald-600 mb-2">Pengurus: {{ $gambar->biodataPengurus->nama }}</p>
                                @endif
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-500">
                                        Status: <span class="{{ $gambar->isVisible ? 'text-green-600' : 'text-red-600' }} font-medium">
                                            {{ $gambar->isVisible ? 'Tampil' : 'Sembunyi' }}
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="col-span-full text-center text-gray-500 py-8">
                            Belum ada gambar pengurus yang ditambahkan
                        </div>
                    @endif
                </div>
            </div>

            <!-- Galeri Acara Tab -->
            <div x-show="activeGalleryTab === 'acara'" class="mt-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    @if(isset($gambarAcara) && $gambarAcara->count() > 0)
                        @foreach($gambarAcara as $gambar)
                        <div class="bg-white border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                            <div class="relative">
                                <img src="{{ $gambar->fullUrl }}" alt="{{ $gambar->judul }}" class="w-full h-72 object-cover">
                                <div class="absolute top-2 right-2">
                                    <button onclick="toggleVisibility('{{ $gambar->id }}')" class="p-1 rounded-full {{ $gambar->isVisible ? 'bg-green-600 text-white' : 'bg-gray-500 text-white' }} hover:opacity-80 transition-opacity">
                                        <div class="flex items-center gap-2 px-2">
                                            <i class="fas {{ $gambar->isVisible ? 'fa-eye' : 'fa-eye-slash' }} text-xs"></i>
                                            <span class="text-sm font-medium text-white">
                                                {{ $gambar->isVisible ? 'Tampil' : 'Sembunyi' }}
                                            </span>
                                        </div>
                                    </button>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-sm text-gray-900 mb-1">{{ $gambar->judul }}</h3>
                                <p class="text-xs text-gray-600 mb-2">{{ Str::limit($gambar->deskripsi, 50) }}</p>
                                @if($gambar->artikel)
                                    <p class="text-xs text-emerald-600 mb-2">Artikel: {{ $gambar->artikel->namaAcara }}</p>
                                @endif
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-500">
                                        Status: <span class="{{ $gambar->isVisible ? 'text-green-600' : 'text-red-600' }} font-medium">
                                            {{ $gambar->isVisible ? 'Tampil' : 'Sembunyi' }}
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="col-span-full text-center text-gray-500 py-8">
                            Belum ada gambar acara yang ditambahkan
                        </div>
                    @endif
                </div>
            </div>

            <!-- Galeri Fasilitas Tab -->
            <div x-show="activeGalleryTab === 'fasilitas'" class="mt-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    @if(isset($gambarFasilitas) && $gambarFasilitas->count() > 0)
                        @foreach($gambarFasilitas as $gambar)
                        <div class="bg-white border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                            <div class="relative">
                                <img src="{{ $gambar->fullUrl }}" alt="{{ $gambar->judul }}" 
                                     class="w-full h-72 object-cover">
                                <div class="absolute top-2 right-2">
                                    <div>
                                        <button onclick="toggleVisibility('{{ $gambar->id }}')" class="p-1 rounded-full {{ $gambar->isVisible ? 'bg-green-600 text-white' : 'bg-gray-500 text-white' }} hover:opacity-80 transition-opacity">
                                            <div class="flex items-center gap-2 px-2">
                                                <i class="fas {{ $gambar->isVisible ? 'fa-eye' : 'fa-eye-slash' }} text-xs"></i>
                                                <span class="text-sm font-medium text-white">
                                                    {{ $gambar->isVisible ? 'Tampil' : 'Sembunyi' }}
                                                </span>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-sm text-gray-900 mb-1">{{ $gambar->judul }}</h3>
                                <p class="text-xs text-gray-600 mb-2">{{ Str::limit($gambar->deskripsi, 50) }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-500">
                                        Status: <span class="{{ $gambar->isVisible ? 'text-green-600' : 'text-red-600' }} font-medium">
                                            {{ $gambar->isVisible ? 'Tampil' : 'Sembunyi' }}
                                        </span>
                                    </span>
                                    <div class="flex gap-2 justify-end font-medium">
                                        <button onclick="editImage('{{ $gambar->id }}')" class="text-blue-600 hover:text-blue-900 text-sm">
                                            <i class="fas fa-edit"></i>
                                            Edit
                                        </button>
                                        <button onclick="deleteImage('{{ $gambar->id }}')" class="text-red-600 hover:text-red-900 text-sm">
                                            <i class="fas fa-trash"></i>
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="col-span-full text-center text-gray-500 py-8">
                            Belum ada gambar fasilitas yang ditambahkan
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Image Modal -->
<div id="addImageModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Tambah Gambar</h3>
            <form id="addImageForm" action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                    <select name="kategori" id="kategori" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            onchange="toggleFields()">
                        <option value="">Pilih Kategori</option>
                        <option value="PENGURUS">Pengurus</option>
                        <option value="ACARA">Acara</option>
                        <option value="FASILITAS">Fasilitas</option>
                    </select>
                </div>

                <div id="pengurusField" class="mb-4 hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pengurus</label>
                    <select name="pengurusId" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="">Pilih Pengurus</option>
                        @if(isset($pengurusList))
                            @foreach($pengurusList as $pengurus)
                                <option value="{{ $pengurus->id }}">{{ $pengurus->nama }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div id="acaraField" class="mb-4 hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Artikel</label>
                    <select name="acaraId" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="">Pilih Artikel</option>
                        @if(isset($artikelList))
                            @foreach($artikelList as $artikel)
                                <option value="{{ $artikel->id }}">{{ $artikel->namaAcara }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Judul</label>
                    <input type="text" name="judul" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="deskripsi" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar</label>
                    <input type="file" name="image" accept="image/*" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="isVisible" checked
                               class="rounded border-gray-300 text-emerald-600 shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Tampilkan di galeri</span>
                    </label>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="hideAddImageModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Batal
                    </button>
                    <button type="button" onclick="submitForm()" id="submitBtn"
                            class="px-4 py-2 bg-emerald-500 text-white rounded-md hover:bg-emerald-600">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Image Modal -->
<div id="editImageModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Gambar</h3>
            <form id="editImageForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Judul</label>
                    <input type="text" name="judul" id="editJudul" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="deskripsi" id="editDeskripsi" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini</label>
                    <img id="editCurrentImage" src="" alt="Current Image" class="w-full h-32 object-cover rounded-md border">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ganti Gambar (Opsional)</label>
                    <input type="file" name="image" accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengganti gambar</p>
                </div>

                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="isVisible" id="editIsVisible"
                               class="rounded border-gray-300 text-emerald-600 shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Tampilkan di galeri</span>
                    </label>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="hideEditImageModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Batal
                    </button>
                    <button type="button" onclick="submitEditForm()" id="editSubmitBtn"
                            class="px-4 py-2 bg-emerald-500 text-white rounded-md hover:bg-emerald-600">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Test if SweetAlert2 is loaded
console.log('SweetAlert2 loaded:', typeof Swal !== 'undefined');

function showAddImageModal() {
    document.getElementById('addImageModal').classList.remove('hidden');
}

function hideAddImageModal() {
    document.getElementById('addImageModal').classList.add('hidden');
}

function showEditImageModal(gambar) {
    console.log('Showing edit modal with data:', gambar);
    
    document.getElementById('editImageModal').classList.remove('hidden');
    document.getElementById('editJudul').value = gambar.judul || '';
    document.getElementById('editDeskripsi').value = gambar.deskripsi || '';
    document.getElementById('editIsVisible').checked = gambar.isVisible || false;
    document.getElementById('editCurrentImage').src = gambar.fullUrl || '';
    
    console.log('Form fields populated:');
    console.log('- Judul:', document.getElementById('editJudul').value);
    console.log('- Deskripsi:', document.getElementById('editDeskripsi').value);
    console.log('- IsVisible:', document.getElementById('editIsVisible').checked);
    console.log('- Image URL:', document.getElementById('editCurrentImage').src);
}

function hideEditImageModal() {
    document.getElementById('editImageModal').classList.add('hidden');
}

// Simple form submission without complex event handling
function submitForm() {
    const form = document.getElementById('addImageForm');
    if (!form) {
        console.error('Form not found!');
        return;
    }

    const formData = new FormData(form);

    // Debug: Log form data
    console.log('Form submission started');
    for (let [key, value] of formData.entries()) {
        console.log(key + ': ' + value);
    }

    // Validate form before submission
    const kategori = formData.get('kategori');
    const judul = formData.get('judul');
    const image = formData.get('image');

    if (!kategori) {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: 'Kategori harus dipilih'
        });
        return;
    }

    if (!judul) {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: 'Judul harus diisi'
        });
        return;
    }

    if (!image || image.size === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: 'Gambar harus dipilih'
        });
        return;
    }

    // Validate kategori-specific fields
    if (kategori === 'PENGURUS' && !formData.get('pengurusId')) {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: 'Pengurus harus dipilih untuk kategori Pengurus'
        });
        return;
    }

    if (kategori === 'ACARA' && !formData.get('acaraId')) {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: 'Artikel harus dipilih untuk kategori Acara'
        });
        return;
    }

    // Show loading state
    Swal.fire({
        title: 'Menyimpan...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Disable submit button to prevent double submission
    const submitBtn = document.getElementById('submitBtn');
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.textContent = 'Menyimpan...';
    }

    console.log('Sending request to:', form.action);

    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(res => {
        console.log('Response status:', res.status);
        
        if (!res.ok) {
            throw new Error(`HTTP error! status: ${res.status}`);
        }
        
        return res.text().then(text => {
            console.log('Raw response:', text);
            try {
                return JSON.parse(text);
            } catch (e) {
                console.error('Failed to parse JSON:', e);
                throw new Error('Invalid JSON response');
            }
        });
    })
    .then(data => {
        console.log('Response data:', data);
        
        // Restore submit button
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Simpan';
        }
        
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message,
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                console.log('Reloading page...');
                location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: data.message || 'Terjadi kesalahan yang tidak diketahui'
            });
        }
    })
    .catch(err => {
        console.error('Fetch error:', err);
        
        // Restore submit button on error
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Simpan';
        }
        
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: 'Terjadi kesalahan saat menambah gambar: ' + err.message
        });
    });
}

function submitEditForm() {
    const form = document.getElementById('editImageForm');
    if (!form) {
        console.error('Edit form not found!');
        return;
    }

    const formData = new FormData(form);
    const gambarId = formData.get('id'); // Assuming 'id' is passed in the form

    if (!gambarId) {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: 'Gambar ID tidak ditemukan'
        });
        return;
    }

    // Validate required fields
    const judul = formData.get('judul');
    if (!judul || judul.trim() === '') {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: 'Judul harus diisi'
        });
        return;
    }

    // Debug: Log form data
    console.log('Edit form submission started');
    for (let [key, value] of formData.entries()) {
        console.log(key + ': ' + value);
    }

    // Show loading state
    Swal.fire({
        title: 'Menyimpan...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Disable submit button to prevent double submission
    const editSubmitBtn = document.getElementById('editSubmitBtn');
    if (editSubmitBtn) {
        editSubmitBtn.disabled = true;
        editSubmitBtn.textContent = 'Menyimpan...';
    }

    console.log('Sending edit request to:', form.action);

    fetch(form.action, {
        method: 'POST', // Change to POST since we're using FormData
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(res => {
        console.log('Response status:', res.status);
        
        if (!res.ok) {
            throw new Error(`HTTP error! status: ${res.status}`);
        }
        
        return res.text().then(text => {
            console.log('Raw response:', text);
            try {
                return JSON.parse(text);
            } catch (e) {
                console.error('Failed to parse JSON:', e);
                throw new Error('Invalid JSON response');
            }
        });
    })
    .then(data => {
        console.log('Response data:', data);
        
        // Restore submit button
        if (editSubmitBtn) {
            editSubmitBtn.disabled = false;
            editSubmitBtn.textContent = 'Update';
        }
        
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message,
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                console.log('Reloading page...');
                location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: data.message || 'Terjadi kesalahan yang tidak diketahui'
            });
        }
    })
    .catch(err => {
        console.error('Fetch error:', err);
        
        // Restore submit button on error
        if (editSubmitBtn) {
            editSubmitBtn.disabled = false;
            editSubmitBtn.textContent = 'Update';
        }
        
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: 'Terjadi kesalahan saat mengedit gambar: ' + err.message
        });
    });
}

// Wait for DOM to be ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Content Loaded');
    
    const form = document.getElementById('addImageForm');
    if (form) {
        console.log('Form found, attaching event listener');
        
        // Test if form exists and has the right action
        console.log('Form action:', form.action);
        console.log('Form method:', form.method);
        
        // Simple event listener
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Form submitted - event triggered');
            submitForm();
        });
        
        console.log('Event listener attached successfully');
    } else {
        console.error('Form not found!');
    }
});

function toggleFields() {
    const kategori = document.getElementById('kategori').value;
    const pengurusField = document.getElementById('pengurusField');
    const acaraField = document.getElementById('acaraField');
    
    // Reset all fields first
    pengurusField.classList.add('hidden');
    acaraField.classList.add('hidden');
    pengurusField.querySelector('select').required = false;
    acaraField.querySelector('select').required = false;
    
    if (kategori === 'PENGURUS') {
        pengurusField.classList.remove('hidden');
        pengurusField.querySelector('select').required = true;
    } else if (kategori === 'ACARA') {
        acaraField.classList.remove('hidden');
        acaraField.querySelector('select').required = true;
    }
    // FASILITAS doesn't need any additional fields
}

function toggleVisibility(gambarId) {
    Swal.fire({
        title: 'Mengubah status...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    fetch(`/admin/galeri/${gambarId}/toggle-visibility`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message,
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: data.message
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: 'Terjadi kesalahan saat mengubah status tampilan'
        });
    });
}

function deleteImage(gambarId) {
    Swal.fire({
        title: 'Yakin hapus gambar ini?',
        text: "Tindakan ini tidak dapat dibatalkan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Menghapus...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch(`/admin/galeri/${gambarId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: data.message
                    });
                }
            })
            .catch(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat menghapus gambar'
                });
            });
        }
    });
}

function editImage(gambarId) {
    // Show loading state
    Swal.fire({
        title: 'Memuat data...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Fetch image data
    fetch(`/admin/galeri/${gambarId}/edit`, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Hide loading
            Swal.close();
            
            // Set form action
            const editForm = document.getElementById('editImageForm');
            editForm.action = `/admin/galeri/${gambarId}`;
            
            // Add hidden input for gambar ID
            let idInput = editForm.querySelector('input[name="id"]');
            if (!idInput) {
                idInput = document.createElement('input');
                idInput.type = 'hidden';
                idInput.name = 'id';
                editForm.appendChild(idInput);
            }
            idInput.value = gambarId;
            
            // Show edit modal with data
            showEditImageModal(data.gambar);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: data.message || 'Gagal memuat data gambar'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: 'Terjadi kesalahan saat memuat data gambar'
        });
    });
}
</script>