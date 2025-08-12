<!-- Artikel Tab Component -->
<script>
    window.articlesData = @json($articlesJson ?? []);
</script>
<div x-data="articleManagement" x-show="currentTab === 'article'" class="space-y-6">
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 md:p-6">
            <div class="flex flex-col space-y-4 sm:space-y-0 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-gray-900">Kelola Artikel</h2>
                    <p class="mt-1 text-sm text-gray-600">Kelola semua artikel laboratorium</p>
                </div>
                <div class="w-full sm:w-auto">
                    <button type="button" class="btn btn-primary rounded-lg py-2 px-4 w-full sm:w-auto" @click="showCreateModal = true">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Artikel
                    </button>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @include('admin.components.shared.stat-card', [
                'title' => 'Total Artikel',
                'value' => \App\Models\Artikel::count(),
                'icon' => 'newspaper',
                'bgColor' => 'bg-emerald-100',
                'iconColor' => 'text-emerald-600',
                'textColor' => 'text-emerald-600'
            ])
        </div>

        <!-- Articles Table -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Daftar Artikel</h3>
                <p class="text-sm text-gray-600 mt-1">Kelola semua artikel yang ditampilkan di halaman user</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Gambar
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Judul Artikel
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Penulis
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal Acara
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @if(isset($articles) && $articles->count() > 0)
                            @foreach($articles as $artikel)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($artikel->gambar->count() > 0)
                                        <img src="{{ $artikel->gambar->first()->fullUrl }}" alt="{{ $artikel->namaAcara }}" 
                                            class="h-16 w-16 object-cover rounded-lg">
                                    @else
                                        <div class="h-16 w-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $artikel->namaAcara }}</div>
                                    <div class="text-sm text-gray-500">{{ Str::limit($artikel->deskripsi, 100) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $artikel->penulis ?? '-' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $artikel->formatted_date }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex flex-col gap-2">
                                        <button @click="selectedArtikel = articlesData[{{ $loop->index }}]; showViewModal = true" 
                                                class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 transition-colors">
                                            <i class="fas fa-eye mr-1"></i>
                                            Lihat
                                        </button>
                                        <button @click="selectedArtikel = articlesData[{{ $loop->index }}]; formData = {
                                            namaAcara: articlesData[{{ $loop->index }}].namaAcara,
                                            penulis: articlesData[{{ $loop->index }}].penulis || '',
                                            tanggalAcara: articlesData[{{ $loop->index }}].tanggalAcara,
                                            deskripsi: articlesData[{{ $loop->index }}].deskripsi,
                                            images: []
                                        }; showEditModal = true" 
                                                class="inline-flex items-center px-3 py-1 bg-emerald-100 text-emerald-700 rounded-md hover:bg-emerald-200 transition-colors">
                                            <i class="fas fa-edit mr-1"></i>
                                            Edit
                                        </button>
                                        <button @click="deleteArtikel('{{ $artikel->id }}')" 
                                                class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded-md hover:bg-red-200 transition-colors">
                                            <i class="fas fa-trash mr-1"></i>
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-newspaper text-gray-400 text-2xl"></i>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada artikel</h3>
                                    <p class="text-sm text-gray-600">Mulai dengan menambahkan artikel pertama</p>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div x-show="showCreateModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto">
        
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
        
        <!-- Modal Content -->
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white rounded-lg shadow-xl max-w-4xl w-full mx-4 transform transition-all">
                <!-- Modal Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Tambah Artikel Baru</h3>
                    <button @click="showCreateModal = false; resetForm()" class="text-gray-400 hover:text-gray-600 transition-colors p-1">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
                
                <form action="{{ route('admin.artikel.store') }}" method="POST" enctype="multipart/form-data" x-ref="createForm">
                    @csrf
                    <div class="p-6 space-y-4">
                        <!-- Nama Acara -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Judul Artikel <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="namaAcara" 
                                   x-model="formData.namaAcara"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors"
                                   placeholder="Masukkan judul artikel">
                        </div>

                        <!-- Penulis -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Penulis
                            </label>
                            <input type="text" 
                                   name="penulis" 
                                   x-model="formData.penulis"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors"
                                   placeholder="Masukkan nama penulis">
                        </div>

                        <!-- Tanggal Acara -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Acara <span class="text-red-500">*</span>
                            </label>
                            <input type="date" 
                                   name="tanggalAcara" 
                                   x-model="formData.tanggalAcara"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors">
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi Artikel <span class="text-red-500">*</span>
                            </label>
                            <textarea name="deskripsi" 
                                      x-model="formData.deskripsi"
                                      rows="6" 
                                      required
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors"
                                      placeholder="Masukkan deskripsi artikel..."></textarea>
                        </div>

                        <!-- Images -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Gambar Artikel
                            </label>
                            <input type="file" 
                                   name="images[]" 
                                   multiple
                                   accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors">
                            <p class="text-sm text-gray-500 mt-1">Pilih satu atau lebih gambar (format: JPG, PNG, GIF, maks. 2MB per file)</p>
                        </div>
                    </div>
                    
                    <!-- Modal Footer -->
                    <div class="flex justify-end space-x-3 p-6 bg-gray-50 border-t border-gray-200">
                        <button type="button" 
                                @click="showCreateModal = false; resetForm()"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors font-medium">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-emerald-500 text-white rounded-md hover:bg-emerald-600 transition-colors font-medium">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Artikel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-show="showEditModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto">
        
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
        
        <!-- Modal Content -->
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white rounded-lg shadow-xl max-w-4xl w-full mx-4 transform transition-all">
                <!-- Modal Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Edit Artikel</h3>
                    <button @click="showEditModal = false; resetForm()" class="text-gray-400 hover:text-gray-600 transition-colors p-1">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
                
                <form :action="`/admin/artikel/${selectedArtikel?.id}`" method="POST" enctype="multipart/form-data" x-ref="editForm">
                    @csrf
                    @method('PUT')
                    <div class="p-6 space-y-4">
                        <!-- Nama Acara -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Judul Artikel <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="namaAcara" 
                                   x-model="formData.namaAcara"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors"
                                   placeholder="Masukkan judul artikel">
                        </div>

                        <!-- Penulis -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Penulis
                            </label>
                            <input type="text" 
                                   name="penulis" 
                                   x-model="formData.penulis"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors"
                                   placeholder="Masukkan nama penulis">
                        </div>

                        <!-- Tanggal Acara -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Acara <span class="text-red-500">*</span>
                            </label>
                            <input type="date" 
                                   name="tanggalAcara" 
                                   x-model="formData.tanggalAcara"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors">
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi Artikel <span class="text-red-500">*</span>
                            </label>
                            <textarea name="deskripsi" 
                                      x-model="formData.deskripsi"
                                      rows="6" 
                                      required
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors"
                                      placeholder="Masukkan deskripsi artikel..."></textarea>
                        </div>

                        <!-- Existing Images -->
                        <div x-show="selectedArtikel?.gambar?.length > 0">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Gambar Saat Ini
                            </label>
                            <div class="grid grid-cols-3 gap-2">
                                <template x-for="gambar in (selectedArtikel?.gambar || [])" :key="gambar.id">
                                    <div class="relative group">
                                        <img :src="gambar.fullUrl" :alt="gambar.judul" 
                                             class="w-full h-20 object-cover rounded-lg">
                                        <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                            <button type="button" 
                                                    @click="deleteImage(gambar.id)"
                                                    class="text-red-400 hover:text-red-600">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- New Images -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tambah Gambar Baru
                            </label>
                            <input type="file" 
                                   name="images[]" 
                                   multiple
                                   accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors">
                            <p class="text-sm text-gray-500 mt-1">Pilih gambar untuk ditambahkan (format: JPG, PNG, GIF, maks. 2MB per file)</p>
                        </div>
                    </div>
                    
                    <!-- Modal Footer -->
                    <div class="flex justify-end space-x-3 p-6 bg-gray-50 border-t border-gray-200">
                        <button type="button" 
                                @click="showEditModal = false; resetForm()"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors font-medium">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-emerald-500 text-white rounded-md hover:bg-emerald-600 transition-colors font-medium">
                            <i class="fas fa-save mr-2"></i>
                            Perbarui Artikel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Modal -->
    <div x-show="showViewModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-hidden">
        
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
        
        <!-- Modal Content -->
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white rounded-lg shadow-xl max-w-4xl w-full mx-4 transform transition-all">
                <!-- Modal Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Detail Artikel</h3>
                    <button @click="showViewModal = false" class="text-gray-400 hover:text-gray-600 transition-colors p-1">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Article Info -->
                        <div>
                            <h4 class="text-xl font-bold text-gray-800 mb-4" x-text="selectedArtikel?.namaAcara"></h4>
                            <div class="space-y-3">
                                <div>
                                    <span class="font-medium text-gray-700">Penulis:</span>
                                    <span x-text="selectedArtikel?.penulis || '-'"></span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700">Tanggal Acara:</span>
                                    <span x-text="selectedArtikel?.formatted_date"></span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700">Deskripsi:</span>
                                    <p class="text-gray-600 mt-1" x-text="selectedArtikel?.deskripsi"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Article Images -->
                        <div>
                            <h5 class="font-medium text-gray-700 mb-3">Gambar Artikel</h5>
                            <div class="grid grid-cols-2 gap-3" x-show="selectedArtikel?.gambar?.length > 0">
                                <template x-for="gambar in (selectedArtikel?.gambar || [])" :key="gambar.id">
                                    <div>
                                        <img :src="gambar.fullUrl" :alt="gambar.judul" class="w-full h-32 object-cover rounded-lg">
                                        <p class="text-sm text-gray-600 mt-1" x-text="gambar.judul"></p>
                                    </div>
                                </template>
                            </div>
                            <div x-show="!selectedArtikel?.gambar?.length" class="text-gray-500 text-center py-8">
                                Tidak ada gambar
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Modal Footer -->
                <div class="flex justify-end p-6 bg-gray-50 border-t border-gray-200">
                    <button type="button" 
                            @click="showViewModal = false"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors font-medium">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('articleManagement', () => ({
        showCreateModal: false,
        showEditModal: false,
        showViewModal: false,
        selectedArtikel: null,
        articlesData: window.articlesData,
        formData: {
            namaAcara: '',
            penulis: '',
            tanggalAcara: '',
            deskripsi: '',
            images: []
        },
        
        resetForm() {
            this.formData = {
                namaAcara: '',
                penulis: '',
                tanggalAcara: '',
                deskripsi: '',
                images: []
            };
            this.selectedArtikel = null;
        },
        
        deleteArtikel(artikelId) {
            Swal.fire({
                title: 'Yakin hapus artikel?',
                text: 'Data artikel yang dihapus tidak bisa dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/artikel/${artikelId}`, {
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
                            return response.text().then(text => {
                                console.log('Error response text:', text);
                                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Delete success data:', data);
                        Swal.fire('Terhapus!', 'Data artikel berhasil dihapus.', 'success').then(() => {
                            window.location.reload();
                        });
                    })
                    .catch(error => {
                        console.error('Error deleting artikel:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Gagal menghapus data artikel: ' + error.message,
                            confirmButtonColor: '#38bdf8'
                        });
                    });
                }
            });
        },
        
        deleteImage(imageId) {
            Swal.fire({
                title: 'Yakin hapus gambar?',
                text: 'Gambar yang dihapus tidak bisa dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/gambar/${imageId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                        return response.json();
                    })
                    .then(data => {
                        Swal.fire('Terhapus!', 'Gambar berhasil dihapus.', 'success').then(() => {
                            window.location.reload();
                        });
                    })
                    .catch(error => {
                        console.error('Error deleting image:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Gagal menghapus gambar: ' + error.message,
                            confirmButtonColor: '#38bdf8'
                        });
                    });
                }
            });
        }
    }));
});

// Handle form submissions
document.addEventListener('submit', function(e) {
    if (e.target.matches('[x-ref="createForm"], [x-ref="editForm"]')) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        const submitButton = form.querySelector('button[type="submit"]');
        let isSubmitting = false;

        if (isSubmitting) return;
        isSubmitting = true;

        if (submitButton) {
            submitButton.disabled = true;
            const originalText = submitButton.innerHTML;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
        }

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            console.log('Form submission response status:', response.status);
            if (!response.ok) {
                return response.text().then(text => {
                    console.log('Error response text:', text);
                    throw new Error(`HTTP ${response.status}: ${text}`);
                });
            }
            return response.json();
        })
        .then(data => {
            console.log('Form submission success data:', data);
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message || 'Data artikel berhasil disimpan.',
                confirmButtonColor: '#38bdf8'
            }).then(() => {
                window.location.reload();
            });
        })
        .catch(error => {
            console.error('Error submitting form:', error);
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Terjadi kesalahan saat menyimpan data: ' + error.message,
                confirmButtonColor: '#38bdf8'
            });
        })
        .finally(() => {
            isSubmitting = false;
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.innerHTML = originalText;
            }
        });
    }
});
</script>