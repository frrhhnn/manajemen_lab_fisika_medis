<!-- Staff Management Tab -->
<div x-data="pengurusManagement" x-show="currentTab === 'staff'" class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 md:p-6">
        <div class="flex flex-col space-y-4 sm:space-y-0 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-gray-900">Kelola Staff</h2>
                <p class="mt-1 text-sm text-gray-600">Kelola data staff yang ditampilkan di halaman user</p>
            </div>
            <div class="w-full sm:w-auto">
                <button type="button" class="btn btn-primary rounded-lg py-2 px-4 w-full sm:w-auto" @click="showAddPengurusModal()">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Staff
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @include('admin.components.shared.stat-card', [
            'title' => 'Total Staff',
            'value' => \App\Models\BiodataPengurus::count(),
            'icon' => 'users',
            'bgColor' => 'bg-emerald-100',
            'iconColor' => 'text-emerald-600',
            'textColor' => 'text-emerald-600'
        ])
        
        @include('admin.components.shared.stat-card', [
            'title' => 'Dosen',
            'value' => \App\Models\BiodataPengurus::where('jabatan', 'like', '%Dosen%')->count(),
            'icon' => 'user-tie',
            'bgColor' => 'bg-blue-100',
            'iconColor' => 'text-blue-600',
            'textColor' => 'text-blue-600'
        ])
        
        @include('admin.components.shared.stat-card', [
            'title' => 'Staff Lab',
            'value' => \App\Models\BiodataPengurus::where('jabatan', 'like', '%Staff%')->count(),
            'icon' => 'user-cog',
            'bgColor' => 'bg-purple-100',
            'iconColor' => 'text-purple-600',
            'textColor' => 'text-purple-600'
        ])
        
        @include('admin.components.shared.stat-card', [
            'title' => 'Kepala Lab',
            'value' => \App\Models\BiodataPengurus::where('jabatan', 'like', '%Kepala%')->count(),
            'icon' => 'crown',
            'bgColor' => 'bg-orange-100',
            'iconColor' => 'text-orange-600',
            'textColor' => 'text-orange-600'
        ])
    </div>

    <!-- Pengurus Cards -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="pb-6 border-b border-gray-200 mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Daftar Staff</h3>
            <p class="text-sm text-gray-600 mt-1">Kelola data pengurus yang ditampilkan di halaman user</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 pt-4">
            @forelse(\App\Models\BiodataPengurus::orderBy('nama')->get() as $member)
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                <x-image.optimized
                    :src="$member->image_url"
                    :alt="$member->nama"
                    class="w-full h-72"
                    object-fit="cover"
                    :rounded="false"
                    :shadow="false"
                />
                <div class="p-4">
                    <h3 class="font-semibold text-sm text-gray-900 mb-1">{{ $member->nama }}</h3>
                    <p class="text-xs text-gray-600 mb-3">{{ $member->jabatan }}</p>
                    <div class="flex justify-end space-x-2 font-medium">
                        <button class="text-emerald-600 hover:text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-3 py-1 rounded-md transition-colors text-sm"
                                @click="editPengurus('{{ $member->id }}')" title="Edit">
                            <i class="fas fa-edit"></i>
                            Edit
                        </button>
                        <button class="text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 px-3 py-1 rounded-md transition-colors text-sm"
                                @click="deletePengurus('{{ $member->id }}')" title="Hapus">
                            <i class="fas fa-trash"></i>
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center text-gray-500 py-12">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada data staff</h3>
                <p class="text-sm text-gray-600">Mulai dengan menambahkan staff pertama</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Add/Edit Pengurus Modal -->
    <div x-show="showCreateModal || showEditModal" x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 overflow-hidden">
        
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
        
        <!-- Modal Content -->
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-4 transform transition-all">
                <!-- Modal Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900" x-text="showCreateModal ? 'Tambah Pengurus Baru' : 'Edit Pengurus'"></h3>
                    <button @click="showCreateModal = false; showEditModal = false; formData = { nama: '', jabatan: '', image: null }"
                            class="text-gray-400 hover:text-gray-600 transition-colors p-1">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
                
                <!-- Modal Body -->
                <div class="p-6">
                    <form :action="showCreateModal ? '{{ route('admin.pengurus.store') }}' : `/admin/pengurus/${selectedPengurus?.id}`"
                          method="POST" enctype="multipart/form-data" x-ref="pengurusForm">
                        @csrf
                        <input type="hidden" name="_method" x-model="showCreateModal ? 'POST' : 'PUT'">
                        
                        <!-- Nama Field -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                            <input type="text" name="nama" x-model="formData.nama" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                   placeholder="Masukkan nama lengkap">
                        </div>
                        
                        <!-- Jabatan Field -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan *</label>
                            <input type="text" name="jabatan" x-model="formData.jabatan" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                   placeholder="Masukkan jabatan">
                        </div>
                        
                        <!-- Image Field -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Foto Pengurus</label>
                            <input type="file" name="image" accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                   @change="formData.image = $event.target.files[0]">
                            
                            <!-- Image Preview -->
                            <div x-show="formData.image || selectedPengurus?.image_url" class="mt-3">
                                <img :src="formData.image ? URL.createObjectURL(formData.image) : selectedPengurus?.image_url"
                                     alt="Preview" class="w-32 h-32 object-cover rounded-lg border shadow-sm">
                            </div>
                        </div>
                        
                        <!-- Modal Footer -->
                        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                            <button type="button" @click="showCreateModal = false; showEditModal = false; formData = { nama: '', jabatan: '', image: null }"
                                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors font-medium">
                                Batal
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 bg-emerald-500 text-white rounded-md hover:bg-emerald-600 transition-colors font-medium">
                                <i class="fas fa-save mr-2"></i>
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('pengurusManagement', () => ({
        showCreateModal: false,
        showEditModal: false,
        selectedPengurus: null,
        formData: {
            nama: '',
            jabatan: '',
            image: null
        },
        
        editPengurus(pengurusId) {
            console.log('Editing pengurus with ID:', pengurusId);
            fetch(`/admin/pengurus/${pengurusId}/edit`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                return response.json();
            })
            .then(data => {
                console.log('Edit data received:', data);
                this.selectedPengurus = {
                    id: data.id,
                    nama: data.nama,
                    jabatan: data.jabatan,
                    image_url: data.image_url
                };
                this.formData = {
                    nama: data.nama,
                    jabatan: data.jabatan,
                    image: null
                };
                this.showEditModal = true;
                this.showCreateModal = false;
            })
            .catch(error => {
                console.error('Error editing pengurus:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Gagal mengambil data pengurus: ' + error.message,
                    confirmButtonColor: '#38bdf8'
                });
            });
        },
        
        deletePengurus(pengurusId) {
            console.log('Deleting pengurus with ID:', pengurusId);
            Swal.fire({
                title: 'Yakin hapus pengurus?',
                text: 'Data pengurus yang dihapus tidak bisa dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/pengurus/${pengurusId}`, {
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
                        Swal.fire('Terhapus!', 'Data pengurus berhasil dihapus.', 'success').then(() => {
                            window.location.reload();
                        });
                    })
                    .catch(error => {
                        console.error('Error deleting pengurus:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Gagal menghapus data pengurus: ' + error.message,
                            confirmButtonColor: '#38bdf8'
                        });
                    });
                }
            });
        },
        
        showAddPengurusModal() {
            this.showCreateModal = true;
            this.showEditModal = false;
            this.selectedPengurus = null;
            this.formData = {
                nama: '',
                jabatan: '',
                image: null
            };
        }
    }));
});

// Handle form submission
document.addEventListener('submit', function(e) {
    if (e.target.matches('[x-ref="pengurusForm"]')) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        const submitButton = form.querySelector('button[type="submit"]');
        let isSubmitting = false;

        if (isSubmitting) return;
        isSubmitting = true;

        if (submitButton) {
            submitButton.disabled = true;
            submitButton.textContent = 'Menyimpan...';
        }

        console.log('Form submission:', {
            action: form.action,
            method: formData.get('_method') || 'POST',
            data: Object.fromEntries(formData)
        });

        fetch(form.action, {
            method: 'POST', // Laravel handles method override via _method
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => {
                    throw new Error(`HTTP ${response.status}: ${text}`);
                });
            }
            return response.json();
        })
        .then(data => {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message || 'Data pengurus berhasil disimpan.',
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
                submitButton.textContent = 'Simpan';
            }
        });
    }
});
</script>

<style>
.btn {
    @apply px-4 py-2 rounded-md font-medium text-white transition-colors;
}
.btn-primary {
    @apply bg-emerald-500 hover:bg-emerald-600;
}
</style>