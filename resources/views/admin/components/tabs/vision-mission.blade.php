<!-- Vision & Mission Management Tab -->
<div x-show="currentTab === 'vision-mission'" class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 md:p-6">
        <div class="flex flex-col space-y-4 sm:space-y-0 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-gray-900">Kelola Visi & Misi</h2>
                <p class="mt-1 text-sm text-gray-600">Kelola data visi dan misi yang ditampilkan di halaman user</p>
            </div>
            <div class="w-full sm:w-auto">
                <button type="button" class="btn btn-primary rounded-lg py-2 px-4 w-full sm:w-auto" onclick="showAddVisionMissionModal()">
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
</div>

<!-- Add/Edit Vision Mission Modal -->
<div id="visionMissionModal" class="modal-overlay hidden">
    <div class="modal modal-wide">
        <div class="modal-header">
            <h3 class="modal-title" id="visionMissionModalTitle">Tambah Visi & Misi</h3>
            <button class="modal-close" onclick="hideVisionMissionModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body ">
            <form id="visionMissionForm" action="{{ route('admin.vision-mission.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="visionMissionMethod" value="POST">
                <div class="grid grid-cols-1 gap-6">
                    <div class="form-group">
                        <label class="form-label">Visi *</label>
                        <textarea name="vision" id="visionInput" class="form-input" rows="2" maxlength="1000" required></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Misi * <span class="text-xs text-gray-400">(Pisahkan tiap poin dengan baris baru)</span></label>
                        <textarea name="mission" id="missionInput" class="form-input" rows="5" maxlength="2000" required></textarea>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="hideVisionMissionModal()">Batal</button>
            <button type="button" class="btn btn-primary" onclick="submitVisionMissionForm()">Simpan</button>
        </div>
    </div>
</div>

<script>
// SweetAlert check
if (typeof Swal === 'undefined') {
    console.error('SweetAlert is not loaded!');
}

// Load data on tab show
function loadVisionMissionTable() {
    fetch('/admin/vision-mission')
        .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById('visionMissionTableBody');
            const count = document.getElementById('visionMissionCount');
            if (count) count.textContent = data.length;
            if (data.length === 0) {
                tbody.innerHTML = `<tr><td colspan="4" class="px-6 py-8 text-center text-gray-500"><i class='fas fa-bullseye text-4xl mb-4 block'></i><p>Belum ada data visi & misi</p></td></tr>`;
                return;
            }
            tbody.innerHTML = data.map(item => `
                <tr>
                    <td class="px-6 py-4 whitespace-pre-line text-gray-900">${item.vision}</td>
                    <td class="px-6 py-4 whitespace-pre-line text-gray-900">
                        <ul class="list-disc pl-5">
                            ${item.mission.split('\n').map(m => `<li>${m.trim()}</li>`).join('')}
                        </ul>
                    </td>
                    <td class="px-6 py-4 text-gray-600">${new Date(item.created_at).toLocaleDateString('id-ID')}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex flex-col gap-2">
                            <button class="inline-flex items-center px-3 py-1 bg-emerald-100 text-emerald-700 rounded-md hover:bg-emerald-200 transition-colors" onclick="editVisionMission(${item.id})" title="Edit"><i class="fas fa-edit mr-1"></i>Edit</button>
                            <button class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded-md hover:bg-red-200 transition-colors" onclick="deleteVisionMission(${item.id})" title="Hapus"><i class="fas fa-trash mr-1"></i>Hapus</button>
                        </div>
                    </td>
                </tr>
            `).join('');
        });
}

function showAddVisionMissionModal() {
    const form = document.getElementById('visionMissionForm');
    const methodInput = document.getElementById('visionMissionMethod');
    form.action = '{{ route("admin.vision-mission.store") }}';
    methodInput.value = 'POST';
    document.getElementById('visionMissionModalTitle').textContent = 'Tambah Visi & Misi';
    form.reset();
    document.getElementById('visionMissionModal').classList.remove('hidden');
}

function hideVisionMissionModal() {
    document.getElementById('visionMissionModal').classList.add('hidden');
}

function editVisionMission(id) {
    fetch(`/admin/vision-mission/${id}/edit`)
        .then(res => res.json())
        .then(data => {
            const form = document.getElementById('visionMissionForm');
            const methodInput = document.getElementById('visionMissionMethod');
            form.action = `/admin/vision-mission/${id}`;
            methodInput.value = 'PUT';
            document.getElementById('visionMissionModalTitle').textContent = 'Edit Visi & Misi';
            document.getElementById('visionInput').value = data.vision;
            document.getElementById('missionInput').value = data.mission;
            document.getElementById('visionMissionModal').classList.remove('hidden');
        });
}

function submitVisionMissionForm() {
    const form = document.getElementById('visionMissionForm');
    const method = document.getElementById('visionMissionMethod').value;
    const url = form.action;
    const formData = new FormData(form);
    if (method === 'PUT') formData.append('_method', 'PUT');
    fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message });
            hideVisionMissionModal();
            loadVisionMissionTable();
        } else {
            Swal.fire({ icon: 'error', title: 'Gagal', text: data.message || 'Terjadi kesalahan' });
        }
    })
    .catch(() => {
        Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan saat menyimpan data' });
    });
}

function deleteVisionMission(id) {
    Swal.fire({
        title: 'Hapus Visi & Misi?',
        text: 'Data yang dihapus tidak dapat dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/vision-mission/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message });
                    loadVisionMissionTable();
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: data.message || 'Terjadi kesalahan' });
                }
            })
            .catch(() => {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan saat menghapus data' });
            });
        }
    });
}

// Auto-load table when tab is shown
if (window.Alpine) {
    document.addEventListener('alpine:init', () => {
        Alpine.effect(() => {
            if (window.currentTab === 'vision-mission') {
                loadVisionMissionTable();
            }
        });
    });
} else {
    // Fallback: load on DOMContentLoaded
    document.addEventListener('DOMContentLoaded', loadVisionMissionTable);
}
</script> 