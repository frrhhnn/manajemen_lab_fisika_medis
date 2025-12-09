<!-- Vision & Mission Management Tab -->
<div x-show="currentTab === 'vision-mission'" class="space-y-6" x-data="visionMissionManagement()">
    <!-- Page Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 md:p-6">
        <div class="flex flex-col space-y-4 sm:space-y-0 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-gray-900">Kelola Visi & Misi</h2>
                <p class="mt-1 text-sm text-gray-600">Kelola data visi dan misi yang ditampilkan di halaman user</p>
            </div>
            <div class="w-full sm:w-auto">
                <button type="button" @click="showAddVisionMissionModal()" 
                        class="bg-emerald-500 hover:bg-emerald-600 text-white font-medium py-2 px-4 rounded-lg transition-colors w-full sm:w-auto">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Visi & Misi
                </button>
            </div>
        </div>
    </div>

    <!-- Vision Mission Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Daftar Visi & Misi</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Visi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Misi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="visionMissionTableBody">
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-bullseye text-4xl mb-4 block"></i>
                            <p>Memuat data...</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add/Edit Vision Mission Modal -->
    <div x-show="showModal" x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 overflow-hidden">
        
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" @click="hideModal()"></div>
        
        <!-- Modal Content -->
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white rounded-xl shadow-2xl max-w-2xl w-full mx-4 transform transition-all max-h-[90vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-green-50">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-emerald-100 rounded-lg">
                            <i class="fas fa-bullseye text-emerald-600 text-lg"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900" x-text="isEdit ? 'Edit Visi & Misi' : 'Tambah Visi & Misi Baru'"></h3>
                    </div>
                    <button @click="hideModal()"
                            class="text-gray-400 hover:text-gray-600 transition-colors p-1 rounded-full hover:bg-gray-100">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
                
                <!-- Modal Body -->
                <div class="p-6">
                    <form :action="isEdit ? `/admin/vision-mission/${selectedItem?.id}` : '{{ route('admin.vision-mission.store') }}'"
                          method="POST" x-ref="visionMissionForm" @submit.prevent="submitForm()">
                        @csrf
                        <input type="hidden" name="_method" x-model="isEdit ? 'PUT' : 'POST'">
                        
                        <!-- Visi Field -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                <i class="fas fa-eye text-emerald-500 mr-2"></i>
                                Visi Organisasi *
                            </label>
                            <div class="relative">
                                <textarea name="vision" x-model="formData.vision" required rows="3"
                                          maxlength="1000" placeholder="Masukkan visi organisasi yang menginspirasi dan jelas..."
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 resize-none">
                                </textarea>
                                <div class="absolute bottom-2 right-3 text-xs text-gray-400">
                                    <span x-text="formData.vision ? formData.vision.length : 0"></span>/1000
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>
                                Visi adalah gambaran masa depan yang ingin dicapai organisasi
                            </p>
                        </div>

                        <!-- Misi Field -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                <i class="fas fa-tasks text-emerald-500 mr-2"></i>
                                Misi Organisasi *
                            </label>
                            <div class="relative">
                                <textarea name="mission" x-model="formData.mission" required rows="6"
                                          maxlength="2000" 
                                          placeholder="Masukkan misi organisasi (pisahkan setiap poin dengan baris baru)&#10;Contoh:&#10;1. Melakukan penelitian berkualitas tinggi&#10;2. Memberikan pelayanan terbaik&#10;3. Mengembangkan teknologi inovatif"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 resize-none">
                                </textarea>
                                <div class="absolute bottom-2 right-3 text-xs text-gray-400">
                                    <span x-text="formData.mission ? formData.mission.length : 0"></span>/2000
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>
                                Misi adalah langkah-langkah konkret untuk mencapai visi. Pisahkan setiap poin dengan baris baru
                            </p>
                        </div>

                        <!-- Preview Section -->
                        <div x-show="formData.vision || formData.mission" class="mb-6 p-4 bg-gray-50 rounded-lg border">
                            <h4 class="text-sm font-semibold text-gray-700 mb-3">
                                <i class="fas fa-eye text-gray-500 mr-2"></i>
                                Preview
                            </h4>
                            <div x-show="formData.vision" class="mb-3">
                                <h5 class="text-xs font-medium text-gray-600 mb-1">Visi:</h5>
                                <p class="text-sm text-gray-800" x-text="formData.vision"></p>
                            </div>
                            <div x-show="formData.mission" class="mb-3">
                                <h5 class="text-xs font-medium text-gray-600 mb-1">Misi:</h5>
                                <ul class="list-disc pl-5 text-sm text-gray-800">
                                    <template x-for="item in formData.mission.split('\n').filter(m => m.trim())" :key="item">
                                        <li x-text="item.trim()"></li>
                                    </template>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Modal Footer -->
                        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                            <button type="button" @click="hideModal()"
                                    class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                                <i class="fas fa-times mr-2"></i>
                                Batal
                            </button>
                            <button type="submit" :disabled="isSubmitting"
                                    class="px-6 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-colors font-medium disabled:opacity-50 disabled:cursor-not-allowed">
                                <i class="fas fa-save mr-2" :class="{ 'fa-spin fa-spinner': isSubmitting, 'fa-save': !isSubmitting }"></i>
                                <span x-text="isSubmitting ? 'Menyimpan...' : 'Simpan'"></span>
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
    Alpine.data('visionMissionManagement', () => ({
        showModal: false,
        isEdit: false,
        isSubmitting: false,
        selectedItem: null,
        formData: {
            vision: '',
            mission: ''
        },
        
        init() {
            // Load data when component is initialized
            this.loadVisionMissionTable();
            
            // Watch for tab changes
            this.$watch('window.currentTab', (value) => {
                if (value === 'vision-mission') {
                    this.loadVisionMissionTable();
                }
            });
        },
        
        loadVisionMissionTable() {
            fetch('/admin/vision-mission')
                .then(res => res.json())
                .then(data => {
                    const tbody = document.getElementById('visionMissionTableBody');
                    const count = document.getElementById('visionMissionCount');
                    
                    if (count) count.textContent = data.length;
                    
                    if (data.length === 0) {
                        tbody.innerHTML = `
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                    <i class='fas fa-bullseye text-4xl mb-4 block text-gray-300'></i>
                                    <p class="text-gray-500 font-medium">Belum ada data visi & misi</p>
                                    <p class="text-gray-400 text-sm mt-1">Klik tombol "Tambah Visi & Misi" untuk mulai menambahkan data</p>
                                </td>
                            </tr>
                        `;
                        return;
                    }
                    
                    tbody.innerHTML = data.map(item => `
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-gray-900">
                                <div class="max-w-xs">
                                    <p class="text-sm leading-relaxed">${item.vision}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-900">
                                <div class="max-w-md">
                                    <ul class="list-disc pl-5 space-y-1">
                                        ${item.mission.split('\n').map(m => m.trim() ? `<li class="text-sm leading-relaxed">${m.trim()}</li>` : '').join('')}
                                    </ul>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                <div class="text-sm">
                                    <div class="font-medium">${new Date(item.created_at).toLocaleDateString('id-ID')}</div>
                                    <div class="text-gray-400">${new Date(item.created_at).toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'})}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button @click="editVisionMission(${item.id})" 
                                            class="inline-flex items-center px-3 py-1.5 bg-emerald-100 text-emerald-700 rounded-lg hover:bg-emerald-200 transition-colors text-xs font-medium" 
                                            title="Edit">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </button>
                                    <button @click="deleteVisionMission(${item.id})" 
                                            class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors text-xs font-medium" 
                                            title="Hapus">
                                        <i class="fas fa-trash mr-1"></i>Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `).join('');
                })
                .catch(error => {
                    console.error('Error loading vision mission data:', error);
                    const tbody = document.getElementById('visionMissionTableBody');
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-red-500">
                                <i class='fas fa-exclamation-triangle text-4xl mb-4 block'></i>
                                <p>Gagal memuat data</p>
                            </td>
                        </tr>
                    `;
                });
        },
        
        showAddVisionMissionModal() {
            this.isEdit = false;
            this.selectedItem = null;
            this.formData = {
                vision: '',
                mission: ''
            };
            this.showModal = true;
        },
        
        editVisionMission(id) {
            fetch(`/admin/vision-mission/${id}/edit`)
                .then(res => res.json())
                .then(data => {
                    this.isEdit = true;
                    this.selectedItem = data;
                    this.formData = {
                        vision: data.vision,
                        mission: data.mission
                    };
                    this.showModal = true;
                })
                .catch(error => {
                    console.error('Error editing vision mission:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Gagal mengambil data untuk diedit',
                        confirmButtonColor: '#10B981'
                    });
                });
        },
        
        hideModal() {
            this.showModal = false;
            this.isEdit = false;
            this.isSubmitting = false;
            this.selectedItem = null;
            this.formData = {
                vision: '',
                mission: ''
            };
        },
        
        submitForm() {
            if (this.isSubmitting) return;
            
            this.isSubmitting = true;
            
            const form = this.$refs.visionMissionForm;
            const url = this.isEdit ? `/admin/vision-mission/${this.selectedItem.id}` : '{{ route("admin.vision-mission.store") }}';
            const method = this.isEdit ? 'PUT' : 'POST';
            
            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            formData.append('vision', this.formData.vision);
            formData.append('mission', this.formData.mission);
            
            if (this.isEdit) {
                formData.append('_method', 'PUT');
            }
            
            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(res => res.json())
            .then(data => {
                this.isSubmitting = false;
                
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        confirmButtonColor: '#10B981',
                        timer: 2000,
                        timerProgressBar: true
                    });
                    this.hideModal();
                    this.loadVisionMissionTable();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: data.message || 'Terjadi kesalahan saat menyimpan data',
                        confirmButtonColor: '#10B981'
                    });
                }
            })
            .catch(error => {
                this.isSubmitting = false;
                console.error('Error submitting form:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat menyimpan data',
                    confirmButtonColor: '#10B981'
                });
            });
        },
        
        deleteVisionMission(id) {
            Swal.fire({
                title: 'Hapus Visi & Misi?',
                text: 'Data yang dihapus tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/vision-mission/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus!',
                                text: data.message,
                                confirmButtonColor: '#10B981',
                                timer: 2000,
                                timerProgressBar: true
                            });
                            this.loadVisionMissionTable();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: data.message || 'Terjadi kesalahan saat menghapus data',
                                confirmButtonColor: '#10B981'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting vision mission:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat menghapus data',
                            confirmButtonColor: '#10B981'
                        });
                    });
                }
            });
        }
    }));
});
</script> 