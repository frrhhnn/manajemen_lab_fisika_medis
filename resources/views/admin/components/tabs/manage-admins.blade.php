<!-- Manage Admins Tab Component -->
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 md:p-6">
        <div class="flex flex-col space-y-4 sm:space-y-0 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-gray-900">Kelola Admin</h2>
                <p class="mt-1 text-sm text-gray-600">Kelola semua administrator sistem</p>
            </div>
            <div class="w-full sm:w-auto">
                <button type="button" class="btn btn-primary rounded-lg py-2 px-4 w-full sm:w-auto" onclick="toggleAddAdminForm()">
                    <i class="fas fa-plus mr-2"></i>
                    <span>Tambah Admin</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @include('admin.components.shared.stat-card', [
            'icon' => 'user-shield',
            'bgColor' => 'bg-purple-100',
            'iconColor' => 'text-purple-600',
            'textColor' => 'text-purple-600',
            'title' => 'Super Admin',
            'value' => $adminStats['super_admin'] ?? 0
        ])

        @include('admin.components.shared.stat-card', [
            'icon' => 'users-cog',
            'bgColor' => 'bg-blue-100',
            'iconColor' => 'text-blue-600',
            'textColor' => 'text-blue-600',
            'title' => 'Admin Biasa',
            'value' => $adminStats['admin'] ?? 0
        ])

        @include('admin.components.shared.stat-card', [
            'icon' => 'users',
            'bgColor' => 'bg-green-100',
            'iconColor' => 'text-green-600',
            'textColor' => 'text-green-600',
            'title' => 'Total Admin',
            'value' => $adminStats['total'] ?? 0
        ])
    </div>

    <!-- Form Tambah Admin -->
    <div id="addAdminForm" class="hidden bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Tambah Admin Baru</h3>
        <form action="{{ route('admin.admins.store') }}" method="POST" class="space-y-4" onsubmit="return submitAdminForm(event)">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                    <input type="text" name="username" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                    <select name="role" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500" required>
                        <option value="">Pilih Role</option>
                        <option value="admin">Admin Biasa</option>
                        <option value="super_admin">Super Admin</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500" required>
                </div>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                    Simpan Admin
                </button>
                <button type="button" onclick="toggleAddAdminForm()" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                    Batal
                </button>
            </div>
        </form>
    </div>

    <!-- Form Edit Admin -->
    <div id="editAdminForm" class="hidden bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Edit Admin</h3>
        <form action="" method="POST" class="space-y-4" onsubmit="return submitEditAdminForm(event)">
            @csrf
            @method('PUT')
            <input type="hidden" id="editAdminId" name="admin_id">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" id="editName" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                    <input type="text" id="editUsername" name="username" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" id="editEmail" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                    <select id="editRole" name="role" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500" required>
                        <option value="admin">Admin Biasa</option>
                        <option value="super_admin">Super Admin</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru (Kosongkan jika tidak diubah)</label>
                    <input type="password" id="editPassword" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                    <input type="password" id="editPasswordConfirmation" name="password_confirmation" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500">
                </div>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Update Admin
                </button>
                <button type="button" onclick="cancelEditAdminForm()" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                    Batal
                </button>
            </div>
        </form>
    </div>

    <!-- Admin List -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <!-- Table Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Daftar Administrator</h3>
                    <p class="mt-1 text-sm text-gray-600">Total {{ $admins->count() }} administrator</p>
                </div>
                <div class="mt-4 sm:mt-0 flex gap-2">
                    <!-- Search -->
                    <div class="relative">
                        <input type="text" id="searchAdmin" placeholder="Cari admin..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-green-500 focus:border-green-500" onInput="filterAdmin()">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Content -->
        <div class="overflow-x-auto">
            <table id="adminTable" class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Admin</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($admins ?? [] as $admin)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 flex-shrink-0">
                                    <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                        <i class="fas fa-user text-gray-600"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $admin->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-mono text-gray-900">{{ $admin->username }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $admin->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $admin->role === 'super_admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                @if($admin->role === 'super_admin')
                                    <i class="fas fa-user-shield mr-1"></i>
                                    Super Admin
                                @else
                                    <i class="fas fa-user-cog mr-1"></i>
                                    Admin
                                @endif
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $admin->created_at->format('d/m/Y') }}</div>
                            <div class="text-sm text-gray-500">{{ $admin->created_at->format('H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex flex-col gap-2">
                                <button onclick="editAdmin('{{ $admin->id }}')" class="inline-flex items-center px-3 py-1 bg-emerald-100 text-emerald-700 rounded-md hover:bg-emerald-200 transition-colors" title="Edit">
                                    <i class="fas fa-edit mr-1"></i>
                                    Edit
                                </button>
                                @if($admin->id !== auth()->id())
                                <button onclick="deleteAdmin('{{ $admin->id }}')" class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded-md hover:bg-red-200 transition-colors" title="Hapus">
                                    <i class="fas fa-trash mr-1"></i>
                                    Hapus
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="text-gray-500">
                                <i class="fas fa-user-friends text-4xl mb-4"></i>
                                <p>Belum ada data admin</p>
                                <button onclick="toggleAddAdminForm()" class="mt-2 text-green-600 hover:text-green-700">
                                    Tambah admin pertama
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
// Toggle form add admin
function toggleAddAdminForm() {
    const addForm = document.getElementById('addAdminForm');
    const editForm = document.getElementById('editAdminForm');
    const addButton = document.querySelector('[onclick="toggleAddAdminForm()"]');
    
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
        addButton.innerHTML = '<i class="fas fa-plus"></i><span>Tambah Admin</span>';
        addButton.className = 'bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 flex items-center gap-2';
        
        // Reset form
        addForm.querySelector('form').reset();
    }
}

// Submit form dengan AJAX dan Sweet Alert
function submitAdminForm(event) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    
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
    .then(response => response.json())
    .then(data => {
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

// Edit admin - fetch data and show form
function editAdmin(adminId) {
    console.log('Editing admin with ID:', adminId);
    
    // Find admin data from the table
    const row = document.querySelector(`button[onclick="editAdmin('${adminId}')"]`).closest('tr');
    if (!row) {
        console.error('Could not find row for admin ID:', adminId);
        return;
    }
    
    try {
        // Extract data from the table row
        const cells = row.querySelectorAll('td');
        
        const nama = cells[0].querySelector('.text-sm.font-medium').textContent.trim();
        const username = cells[1].textContent.trim();
        const email = cells[2].textContent.trim();
        const roleText = cells[3].querySelector('span').textContent.trim();
        const role = roleText.includes('Super Admin') ? 'super_admin' : 'admin';
        
        // Hide add form if open
        const addForm = document.getElementById('addAdminForm');
        if (addForm && !addForm.classList.contains('hidden')) {
            toggleAddAdminForm();
        }
        
        // Show edit form
        const editForm = document.getElementById('editAdminForm');
        editForm.classList.remove('hidden');
        
        // Populate form
        document.getElementById('editAdminId').value = adminId;
        document.getElementById('editName').value = nama;
        document.getElementById('editUsername').value = username;
        document.getElementById('editEmail').value = email;
        document.getElementById('editRole').value = role;
        document.getElementById('editPassword').value = '';
        document.getElementById('editPasswordConfirmation').value = '';
        
        // Set form action
        const form = editForm.querySelector('form');
        form.action = `/admin/admins/${adminId}`;
        
        // Scroll to form
        editForm.scrollIntoView({ behavior: 'smooth' });
        
    } catch (error) {
        console.error('Error in editAdmin function:', error);
    }
}

// Cancel edit form
function cancelEditAdminForm() {
    const editForm = document.getElementById('editAdminForm');
    editForm.classList.add('hidden');
    
    // Reset form
    editForm.querySelector('form').reset();
}

// Submit edit form
function submitEditAdminForm(event) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    
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
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
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
        console.error('Error updating admin:', error);
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

// Delete admin dengan Sweet Alert
function deleteAdmin(adminId) {
    console.log('Deleting admin with ID:', adminId);
    
    if (typeof Swal === 'undefined') {
        if (confirm('Yakin hapus admin ini? Data admin yang dihapus tidak bisa dikembalikan!')) {
            performDeleteAdmin(adminId);
        }
        return;
    }

    Swal.fire({
        title: 'Yakin hapus admin ini?',
        text: 'Data admin yang dihapus tidak bisa dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            performDeleteAdmin(adminId);
        }
    });
}

function performDeleteAdmin(adminId) {
    fetch(`/admin/admins/${adminId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
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
        console.error('Error deleting admin:', error);
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan saat menghapus admin',
                confirmButtonColor: '#ef4444'
            });
        } else {
            alert('Terjadi kesalahan saat menghapus admin');
        }
    });
}

function filterAdmin() {
    const input = document.getElementById('searchAdmin');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('adminTable');
    const trs = table.querySelectorAll('tbody tr');

    trs.forEach(tr => {
        const rowText = tr.textContent.toLowerCase();
        if (rowText.includes(filter)) {
            tr.style.display = '';
        } else {
            tr.style.display = 'none';
        }
    });
}
</script>
