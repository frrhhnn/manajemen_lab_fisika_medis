<!-- Equipment Tab Component -->
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 md:p-6">
        <div class="flex flex-col space-y-4 sm:space-y-0 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-gray-900">Kelola Inventaris Alat</h2>
                <p class="mt-1 text-sm text-gray-600">Kelola semua peralatan laboratorium</p>
            </div>
            <div class="w-full sm:w-auto">
                <button type="button" class="btn btn-primary rounded-lg py-2 px-4 w-full sm:w-auto" onclick="toggleAddForm()">
                    <i class="fas fa-plus mr-2"></i>
                    <span>Tambah Alat</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @include('admin.components.shared.stat-card', [
            'icon' => 'microscope',
            'bgColor' => 'bg-blue-100',
            'iconColor' => 'text-blue-600',
            'textColor' => 'text-blue-600',
            'title' => 'Total Alat',
            'value' => $stats['total_alat'] ?? 0
        ])

        @include('admin.components.shared.stat-card', [
            'icon' => 'check-circle',
            'bgColor' => 'bg-green-100',
            'iconColor' => 'text-green-600',
            'textColor' => 'text-green-600',
            'title' => 'Tersedia',
            'value' => $stats['total_tersedia'] ?? 0
        ])

        @include('admin.components.shared.stat-card', [
            'icon' => 'clock',
            'bgColor' => 'bg-yellow-100',
            'iconColor' => 'text-yellow-600',
            'textColor' => 'text-yellow-600',
            'title' => 'Dipinjam',
            'value' => $stats['total_dipinjam'] ?? 0
        ])

        @include('admin.components.shared.stat-card', [
            'icon' => 'exclamation-triangle',
            'bgColor' => 'bg-red-100',
            'iconColor' => 'text-red-600',
            'textColor' => 'text-red-600',
            'title' => 'Rusak',
            'value' => $stats['total_rusak'] ?? 0
        ])
    </div>

    <!-- Alert Messages -->
    <!-- @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded" role="alert">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif -->

    <!-- Form Tambah Alat -->
    <div id="addAlatForm" class="hidden bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form action="{{ route('admin.alat.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4" onsubmit="return submitAlatForm(event)">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Alat</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kode Alat</label>
                    <input type="text" name="kode" value="{{ old('kode') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                    <select name="nama_kategori" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoris ?? [] as $kategori)
                            <option value="{{ $kategori->nama_kategori }}" {{ old('nama_kategori') == $kategori->nama_kategori ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Stok Awal</label>
                    <input type="number" name="stok" value="{{ old('stok') }}" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Harga (Opsional)</label>
                    <input type="number" name="harga" value="{{ old('harga') }}" min="0" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar (Opsional)</label>
                    <input type="file" name="image" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea name="deskripsi" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500" required>{{ old('deskripsi') }}</textarea>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                    Simpan Alat
                </button>
                <button type="button" onclick="toggleAddForm()" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                    Batal
                </button>
            </div>
        </form>
    </div>

    <!-- Form Edit Alat -->
    <div id="editAlatForm" class="hidden bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Edit Alat</h3>
        <form action="" method="POST" enctype="multipart/form-data" class="space-y-4" onsubmit="return submitEditAlatForm(event)">
            @csrf
            @method('PUT')
            <input type="hidden" id="editAlatId" name="alat_id">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Alat</label>
                    <input type="text" id="editNama" name="nama" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kode Alat</label>
                    <input type="text" id="editKode" name="kode" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                    <select id="editKategori" name="nama_kategori" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoris ?? [] as $kategori)
                            <option value="{{ $kategori->nama_kategori }}">{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Stok</label>
                    <input type="number" id="editStok" name="stok" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Tersedia</label>
                    <input type="number" id="editJumlahTersedia" name="jumlah_tersedia" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Dipinjam</label>
                    <input type="number" id="editJumlahDipinjam" name="jumlah_dipinjam" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Rusak</label>
                    <input type="number" id="editJumlahRusak" name="jumlah_rusak" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Harga (Opsional)</label>
                    <input type="number" id="editHarga" name="harga" min="0" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Baru (Opsional)</label>
                    <input type="file" name="image" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500">
                    <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah gambar</p>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea id="editDeskripsi" name="deskripsi" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500" required></textarea>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Update Alat
                </button>
                <button type="button" onclick="cancelEditForm()" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                    Batal
                </button>
            </div>
        </form>
    </div>

    <!-- Equipment List -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <!-- Table Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Daftar Alat</h3>
                    <p class="mt-1 text-sm text-gray-600">Total {{ $alats->count() }} alat</p>
                </div>
                <div class="mt-4 sm:mt-0 flex gap-2">
                    <!-- Search -->
                    <div class="relative">
                        <input type="text" id="searchAlat" placeholder="Cari alat..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-green-500 focus:border-green-500" onInput="filterAlat()">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Content -->
        <div class="overflow-x-auto">
            <table id="alatTable" class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($alats ?? [] as $alat)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-12 w-12 flex-shrink-0">
                                    <img class="h-12 w-12 rounded-lg object-cover" src="{{ $alat->image_url ? asset('storage/' . $alat->image_url) : asset('images/facilities/default-alat.jpg') }}" alt="{{ $alat->nama }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $alat->nama }}</div>
                                    <div class="text-sm text-gray-500">{{ Str::limit($alat->deskripsi, 50) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-mono text-gray-900">{{ $alat->kode }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $alat->nama_kategori }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-gray-900">{{ $alat->stok }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                                <div class="text-green-600">Tersedia: {{ $alat->jumlah_tersedia }}</div>
                                <div class="text-yellow-600">Dipinjam: {{ $alat->jumlah_dipinjam }}</div>
                                <div class="text-red-600">Rusak: {{ $alat->jumlah_rusak }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $alat->harga ? 'Rp ' . number_format($alat->harga, 0, ',', '.') : '-' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex flex-col gap-2">
                                <button onclick="editAlat('{{ $alat->id }}')" class="inline-flex items-center px-3 py-1 bg-emerald-100 text-emerald-700 rounded-md hover:bg-emerald-200 transition-colors" title="Edit">
                                    <i class="fas fa-edit mr-1"></i>
                                    Edit
                                </button>
                                <button onclick="deleteAlat('{{ $alat->id }}')" class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded-md hover:bg-red-200 transition-colors" title="Hapus">
                                    <i class="fas fa-trash mr-1"></i>
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="text-gray-500">
                                <i class="fas fa-box-open text-4xl mb-4"></i>
                                <p>Belum ada data alat</p>
                                <button onclick="toggleAddForm()" class="mt-2 text-green-600 hover:text-green-700">
                                    Tambah alat pertama
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

<script>

// Submit form dengan AJAX dan Sweet Alert
function submitAlatForm(event) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    
    // Debug form data
    console.log('Submitting form with data:');
    for (let [key, value] of formData.entries()) {
        console.log(key, value);
    }
    
    // Show loading
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Menyimpan...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading()
            }
        });
    }
    
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers.get('content-type'));
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        // Check if response is JSON
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            throw new Error('Response is not JSON - likely a redirect or HTML page');
        }
        
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    confirmButtonColor: '#10b981'
                }).then(() => {
                    window.location.reload();
                });
            } else {
                alert(data.message);
                window.location.reload();
            }
        } else {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: data.message,
                    confirmButtonColor: '#ef4444'
                });
            } else {
                alert(data.message);
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan saat menyimpan data',
                confirmButtonColor: '#ef4444'
            });
        } else {
            alert('Terjadi kesalahan saat menyimpan data');
        }
    });
    
    return false;
}

// Delete alat dengan Sweet Alert
function deleteAlat(alatId) {
    console.log('Deleting alat with ID:', alatId);
    
    if (typeof Swal === 'undefined') {
        if (confirm('Yakin hapus alat ini? Data alat yang dihapus tidak bisa dikembalikan!')) {
            performDeleteAlat(alatId);
        }
        return;
    }

    Swal.fire({
        title: 'Yakin hapus alat ini?',
        text: 'Data alat yang dihapus tidak bisa dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            performDeleteAlat(alatId);
        }
    });
}

function performDeleteAlat(alatId) {
    fetch(`/admin/alat/${alatId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        console.log('Delete response status:', response.status);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Delete response data:', data);
        if (data.success) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    confirmButtonColor: '#10b981'
                }).then(() => {
                    window.location.reload();
                });
            } else {
                alert(data.message);
                window.location.reload();
            }
        } else {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: data.message,
                    confirmButtonColor: '#ef4444'
                });
            } else {
                alert(data.message);
            }
        }
    })
    .catch(error => {
        console.error('Error deleting alat:', error);
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan saat menghapus alat',
                confirmButtonColor: '#ef4444'
            });
        } else {
            alert('Terjadi kesalahan saat menghapus alat');
        }
    });
}

// Toggle form add alat
function toggleAddForm() {
    const addForm = document.getElementById('addAlatForm');
    const editForm = document.getElementById('editAlatForm');
    const addButton = document.querySelector('[onclick="toggleAddForm()"]');
    
    // Hide edit form if open
    if (editForm && !editForm.classList.contains('hidden')) {
        editForm.classList.add('hidden');
    }
    
    if (addForm.classList.contains('hidden')) {
        addForm.classList.remove('hidden');
        addButton.innerHTML = '<i class="fas fa-times mr-2"></i>Batal';
        addButton.className = 'bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center gap-2';
    } else {
        addForm.classList.add('hidden');
        addButton.innerHTML = '<i class="fas fa-plus"></i><span>Tambah Alat</span>';
        addButton.className = 'bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 flex items-center gap-2';
        
        // Reset form
        document.querySelector('form[action*="admin.alat.store"]').reset();
    }
}

// Edit alat - fetch data and show form
function editAlat(alatId) {
    console.log('Editing alat with ID:', alatId);
    
    // Find alat data from the table
    const row = document.querySelector(`button[onclick="editAlat('${alatId}')"]`).closest('tr');
    if (!row) {
        console.error('Could not find row for alat ID:', alatId);
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Data alat tidak ditemukan',
                confirmButtonColor: '#ef4444'
            });
        } else {
            alert('Data alat tidak ditemukan');
        }
        return;
    }
    
    try {
        // Extract data from the table row with null checks
        const cells = row.querySelectorAll('td');
        
        // Get nama alat
        const namaElement = cells[0]?.querySelector('.text-sm.font-medium');
        const namaAlat = namaElement ? namaElement.textContent.trim() : '';
        
        // Get deskripsi
        const deskripsiElement = cells[0]?.querySelector('.text-sm.text-gray-500');
        const deskripsi = deskripsiElement ? deskripsiElement.textContent.trim() : '';
        
        // Get kode
        const kode = cells[1] ? cells[1].textContent.trim() : '';
        
        // Get kategori
        const kategori = cells[2] ? cells[2].textContent.trim() : '';
        
        // Get stok data with null checks
        const stokCell = cells[4]; // Changed from cells[3] to cells[4] based on table structure
        const tersediaElement = stokCell?.querySelector('.text-green-600');
        const dipinjamElement = stokCell?.querySelector('.text-yellow-600');
        const rusakElement = stokCell?.querySelector('.text-red-600');
        
        const tersedia = tersediaElement ? tersediaElement.textContent.replace('Tersedia: ', '').trim() : '0';
        const dipinjam = dipinjamElement ? dipinjamElement.textContent.replace('Dipinjam: ', '').trim() : '0';
        const rusak = rusakElement ? rusakElement.textContent.replace('Rusak: ', '').trim() : '0';
        
        // Get harga
        const hargaText = cells[5] ? cells[5].textContent.trim() : '-';
        const harga = hargaText.replace('Rp ', '').replace(/[,.]/g, '').trim();
        
        // Hide add form if open
        const addForm = document.getElementById('addAlatForm');
        if (addForm && !addForm.classList.contains('hidden')) {
            toggleAddForm();
        }
        
        // Show edit form
        const editForm = document.getElementById('editAlatForm');
        if (!editForm) {
            console.error('Edit form not found');
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Form edit tidak ditemukan',
                    confirmButtonColor: '#ef4444'
                });
            } else {
                alert('Form edit tidak ditemukan');
            }
            return;
        }
        
        editForm.classList.remove('hidden');
        
        // Populate form with null checks
        const editAlatIdField = document.getElementById('editAlatId');
        const editNamaField = document.getElementById('editNama');
        const editKodeField = document.getElementById('editKode');
        const editKategoriField = document.getElementById('editKategori');
        const editStokField = document.getElementById('editStok');
        const editJumlahTersediaField = document.getElementById('editJumlahTersedia');
        const editJumlahDipinjamField = document.getElementById('editJumlahDipinjam');
        const editJumlahRusakField = document.getElementById('editJumlahRusak');
        const editHargaField = document.getElementById('editHarga');
        const editDeskripsiField = document.getElementById('editDeskripsi');
        
        if (editAlatIdField) editAlatIdField.value = alatId;
        if (editNamaField) editNamaField.value = namaAlat;
        if (editKodeField) editKodeField.value = kode;
        if (editKategoriField) editKategoriField.value = kategori;
        if (editStokField) editStokField.value = parseInt(tersedia || 0) + parseInt(dipinjam || 0) + parseInt(rusak || 0);
        if (editJumlahTersediaField) editJumlahTersediaField.value = tersedia;
        if (editJumlahDipinjamField) editJumlahDipinjamField.value = dipinjam;
        if (editJumlahRusakField) editJumlahRusakField.value = rusak;
        if (editHargaField) editHargaField.value = harga === '-' ? '' : harga;
        if (editDeskripsiField) editDeskripsiField.value = deskripsi;
        
        // Set form action
        const form = editForm.querySelector('form');
        if (form) {
            form.action = `/admin/alat/${alatId}`;
        }
        
        // Scroll to form
        editForm.scrollIntoView({ behavior: 'smooth' });
        
    } catch (error) {
        console.error('Error in editAlat function:', error);
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan saat memuat data edit',
                confirmButtonColor: '#ef4444'
            });
        } else {
            alert('Terjadi kesalahan saat memuat data edit');
        }
    }
}

// Cancel edit form
function cancelEditForm() {
    const editForm = document.getElementById('editAlatForm');
    editForm.classList.add('hidden');
    
    // Reset form
    editForm.querySelector('form').reset();
}

// Submit edit form
function submitEditAlatForm(event) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    
    // Debug form data
    console.log('Submitting edit form with data:');
    for (let [key, value] of formData.entries()) {
        console.log(key, value);
    }
    
    // Show loading
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Mengupdate...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading()
            }
        });
    }
    
    fetch(form.action, {
        method: 'POST', // Laravel handles PUT via _method
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        console.log('Edit response status:', response.status);
        console.log('Edit response headers:', response.headers.get('content-type'));
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        // Check if response is JSON
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            throw new Error('Response is not JSON - likely a redirect or HTML page');
        }
        
        return response.json();
    })
    .then(data => {
        console.log('Edit response data:', data);
        if (data.success) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    confirmButtonColor: '#10b981'
                }).then(() => {
                    window.location.reload();
                });
            } else {
                alert(data.message);
                window.location.reload();
            }
        } else {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: data.message,
                    confirmButtonColor: '#ef4444'
                });
            } else {
                alert(data.message);
            }
        }
    })
    .catch(error => {
        console.error('Error updating alat:', error);
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan saat mengupdate data',
                confirmButtonColor: '#ef4444'
            });
        } else {
            alert('Terjadi kesalahan saat mengupdate data');
        }
    });
    
    return false;
}

function filterAlat() {
    const input = document.getElementById('searchAlat');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('alatTable');
    const trs = table.querySelectorAll('tbody tr');

    trs.forEach(tr => {
        // Gabungkan semua kolom jadi satu string
        const rowText = tr.textContent.toLowerCase();
        if (rowText.includes(filter)) {
            tr.style.display = '';
        } else {
            tr.style.display = 'none';
        }
    });
}
</script> 