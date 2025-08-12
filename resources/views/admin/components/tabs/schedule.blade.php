<!-- Schedule Management Tab -->
<div class="space-y-8">
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Kelola Jadwal Kunjungan</h2>
                <p class="mt-1 text-sm text-gray-600">Atur dan pantau ketersediaan jadwal kunjungan secara real-time</p>
            </div>
            
            <!-- Enhanced Month/Year Selector -->
            <div class="flex items-center space-x-4">
                <!-- Month Navigation -->
                <div class="flex items-center bg-gradient-to-r from-emerald-50 to-teal-50 rounded-2xl px-2">
                    <button onclick="navigateMonth(-1)" 
                            class="p-3 rounded-xl text-emerald-600">
                        <i class="fas fa-chevron-left text-lg"></i>
                    </button>
                    
                    <!-- Current Month Display -->
                    <div class="px-2 py-1 text-center min-w-[100px]">
                        <div class="text-lg font-bold text-emerald-900" id="current-month-text">
                            <!-- Will be populated by JavaScript -->
                        </div>
                        <div class="text-sm text-emerald-600" id="current-year-text">
                            <!-- Will be populated by JavaScript -->
                        </div>
                    </div>
                    
                    <button onclick="navigateMonth(1)" 
                            class="p-3 rounded-xl text-emerald-600">
                        <i class="fas fa-chevron-right text-lg"></i>
                    </button>
                </div>
                
                <!-- Quick Actions -->
                <div class="flex items-center space-x-2">
                    <!-- Today Button -->
                    <button onclick="goToToday()" 
                            class="px-4 py-3 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition-all duration-200 font-medium shadow-lg hover:shadow-emerald-200">
                        <i class="fas fa-calendar-day mr-2"></i>Hari Ini
                    </button>
                    
                    <!-- Advanced Month Picker -->
                    <div class="relative">
                        <button onclick="toggleMonthPicker()" 
                                class="p-3 bg-gray-100 text-gray-600 rounded-xl hover:bg-gray-200 transition-all duration-200" 
                                title="Pilih Bulan">
                            <i class="fas fa-calendar-alt text-lg"></i>
                        </button>
                        
                        <!-- Month Picker Dropdown -->
                        <div id="month-picker-dropdown" class="absolute right-0 top-full mt-2 bg-white rounded-2xl shadow-2xl border border-gray-100 p-6 z-50 hidden min-w-[320px]">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Tahun</label>
                                <select id="year-selector" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                    <!-- Will be populated by JavaScript -->
                                </select>
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Bulan</label>
                                <div class="grid grid-cols-3 gap-2" id="month-grid">
                                    <!-- Will be populated by JavaScript -->
                                </div>
                            </div>
                            
                            <div class="flex justify-end space-x-2 pt-4 border-t border-gray-200">
                                <button onclick="closeMonthPicker()" 
                                        class="px-4 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-all duration-200">
                                    Batal
                                </button>
                                <button onclick="applyMonthSelection()" 
                                        class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-all duration-200">
                                    Terapkan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Hidden input for form compatibility -->
                <input type="month" id="month-selector" value="{{ $currentMonth }}" class="hidden">
            </div>
        </div>
    </div>

    <!-- Legend -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
        <div class="flex items-center mb-6">
            <div class="bg-gradient-to-r from-gray-400 to-gray-600 w-1 h-8 rounded-full mr-4"></div>
            <h3 class="text-xl font-bold text-gray-800">Keterangan Status</h3>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-6">
            <div class="flex items-center space-x-3 p-3 rounded-xl bg-green-50 border border-green-200">
                <div class="w-5 h-5 bg-green-500 rounded-full shadow-sm"></div>
                <span class="font-medium text-gray-700">Tersedia</span>
            </div>
            <div class="flex items-center space-x-3 p-3 rounded-xl bg-red-50 border border-red-200">
                <div class="w-5 h-5 bg-red-500 rounded-full shadow-sm"></div>
                <span class="font-medium text-gray-700">Dinonaktifkan</span>
            </div>
            <div class="flex items-center space-x-3 p-3 rounded-xl bg-indigo-50 border border-indigo-200">
                <div class="w-5 h-5 bg-indigo-500 rounded-full shadow-sm"></div>
                <span class="font-medium text-gray-700">Pengajuan Masuk</span>
            </div>
            <div class="flex items-center space-x-3 p-3 rounded-xl bg-blue-50 border border-blue-200">
                <div class="w-5 h-5 bg-blue-500 rounded-full shadow-sm"></div>
                <span class="font-medium text-gray-700">Disetujui</span>
            </div>
            <div class="flex items-center space-x-3 p-3 rounded-xl bg-yellow-50 border border-yellow-200">
                <div class="w-5 h-5 bg-yellow-500 rounded-full shadow-sm"></div>
                <span class="font-medium text-gray-700">Selesai (✓)</span>
            </div>
        </div>
    </div>

    <!-- Calendar -->
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <!-- Calendar Header -->
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-8 py-6 border-b border-gray-200">
            <div class="grid grid-cols-7 gap-4">
                <div class="text-center font-bold text-gray-700 py-3">
                    <i class="fas fa-sun text-orange-500 mr-2"></i>Minggu
                </div>
                <div class="text-center font-bold text-gray-700 py-3">
                    <i class="fas fa-briefcase text-blue-500 mr-2"></i>Senin
                </div>
                <div class="text-center font-bold text-gray-700 py-3">
                    <i class="fas fa-briefcase text-blue-500 mr-2"></i>Selasa
                </div>
                <div class="text-center font-bold text-gray-700 py-3">
                    <i class="fas fa-briefcase text-blue-500 mr-2"></i>Rabu
                </div>
                <div class="text-center font-bold text-gray-700 py-3">
                    <i class="fas fa-briefcase text-blue-500 mr-2"></i>Kamis
                </div>
                <div class="text-center font-bold text-gray-700 py-3">
                    <i class="fas fa-briefcase text-blue-500 mr-2"></i>Jumat
                </div>
                <div class="text-center font-bold text-gray-700 py-3">
                    <i class="fas fa-home text-green-500 mr-2"></i>Sabtu
                </div>
            </div>
        </div>
        
        <!-- Calendar Body -->
        <div class="p-4">
            <div id="calendar-grid" class="grid grid-cols-7 gap-3">
                <!-- Calendar days will be populated by JavaScript -->
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Schedule Settings Modal -->
<div id="schedule-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-green-600 to-teal-600 px-8 py-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold">Pengaturan Jadwal</h3>
                    <p class="text-green-100 mt-1" id="modal-date"></p>
                </div>
                <button onclick="closeScheduleModal()" 
                        class="text-white/80 hover:text-white hover:bg-white/20 p-2 rounded-xl transition-all duration-200">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        
        <!-- Modal Body -->
        <div class="p-8 max-h-[60vh] overflow-y-auto">
            <div id="schedule-list" class="space-y-4">
                <!-- Schedule items will be populated by JavaScript -->
            </div>
        </div>
        
        <!-- Modal Footer -->
        <div class="bg-gray-50 px-8 py-6 flex justify-end space-x-4">
            <button onclick="closeScheduleModal()" 
                    class="px-6 py-3 text-gray-600 border border-gray-300 rounded-xl hover:bg-gray-100 transition-all duration-200 font-medium">
                <i class="fas fa-times mr-2"></i>Tutup
            </button>
        </div>
    </div>
</div>

<style>
.calendar-cell {
    min-height: 180px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.calendar-cell:hover {
    transform: translateY(-2px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

.today-cell {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
}

.today-cell:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
}

.schedule-item {
    font-size: 10px;
    line-height: 1.2;
    padding: 3px 6px;
    margin: 1px 0;
    border-radius: 6px;
    font-weight: 500;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    display: flex;
    align-items: center;
    gap: 3px;
}

.schedule-available {
    background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
    color: #166534;
    border: 1px solid #16a34a;
}

.schedule-booked {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    color: #1d4ed8;
    border: 1px solid #3b82f6;
}

/* New: Pending and Approved styles (distinct from completed) */
.schedule-pending {
    background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);
    color: #3730a3;
    border: 1px solid #6366f1;
}

.schedule-approved {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    color: #1d4ed8;
    border: 1px solid #3b82f6;
}

.schedule-completed {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #92400e;
    border: 1px solid #f59e0b;
}

.schedule-disabled {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #991b1b;
    border: 1px solid #ef4444;
}

.day-number {
    position: absolute;
    top: 8px;
    left: 8px;
    font-size: 16px;
    font-weight: bold;
    z-index: 2;
}

.schedule-list {
    padding: 25px 8px 8px 8px;
    max-height: calc(100% - 25px);
    overflow-y: auto;
}

/* Compact badges inside calendar cells */
.badges-row {
    position: absolute;
    top: 30px;
    left: 8px;
    right: 8px;
    display: flex;
    gap: 4px;
    flex-wrap: wrap;
    z-index: 2;
}

.badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 2px 6px;
    border-radius: 9999px;
    font-size: 9px;
    font-weight: 600;
    border-width: 1px;
}

.badge-pending {
    background: #eef2ff;
    border-color: #c7d2fe;
    color: #3730a3;
}

.badge-approved {
    background: #dbeafe;
    border-color: #bfdbfe;
    color: #1d4ed8;
}

.badge-completed {
    background: #fef3c7;
    border-color: #fde68a;
    color: #92400e;
}

.badge-available {
    background: #dcfce7;
    border-color: #bbf7d0;
    color: #166534;
}

.empty-day {
    opacity: 0.3;
    background: #f9fafb;
}

.past-day {
    opacity: 0.6;
}

.visit-info {
    position: absolute;
    top: 8px;
    left: 8px;
    right: 8px;
    z-index: 2;
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.visit-info div {
    padding: 2px 0;
}

/* Penyesuaian padding untuk schedule-list agar tidak bertabrakan dengan visit-info */
.schedule-list {
    padding-top: 60px; /* Disesuaikan berdasarkan tinggi visit-info */
}

.schedule-summary {
    position: absolute;
    top: 8px;
    right: 8px;
    font-size: 9px;
    padding: 2px 5px;
    border-radius: 6px;
    background: rgba(0, 0, 0, 0.1);
    color: rgba(0, 0, 0, 0.7);
    font-weight: 600;
}

.today-cell .schedule-summary {
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

.switch-button {
    position: relative;
    width: 48px;
    height: 24px;
    border-radius: 12px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.switch-button.active {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.switch-button.inactive {
    background: #d1d5db;
}

.switch-thumb {
    position: absolute;
    top: 2px;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: white;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.switch-thumb.active {
    transform: translateX(24px);
}

.switch-thumb.inactive {
    transform: translateX(2px);
}

/* Scrollbar styling untuk schedule list */
.schedule-list::-webkit-scrollbar {
    width: 2px;
}

.schedule-list::-webkit-scrollbar-track {
    background: transparent;
}

.schedule-list::-webkit-scrollbar-thumb {
    background: rgba(0, 0, 0, 0.2);
    border-radius: 1px;
}
</style>

<script>
let currentMonth = '{{ $currentMonth ?? date("Y-m") }}';
let selectedDate = null;
let selectedYear = null;
let selectedMonthIndex = null;
let calendarStats = {
    available: 0,
    booked: 0,
    completed: 0,
    disabled: 0
};

// Month names in Indonesian
const monthNames = [
    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
];

// Sample data untuk testing - nanti akan diganti dengan data dari server
const sampleScheduleData = [
    {
        date: '2025-01-07',
        schedules: [
            { id: 1, timeLabel: '08:00-09:00', isActive: true, isBooked: true, kunjungan: { nama: 'Dr. Ahmad', status: 'PENDING', isCompleted: false } },
            { id: 2, timeLabel: '09:00-10:00', isActive: true, isBooked: true, kunjungan: { nama: 'Prof. Sari', status: 'COMPLETED', isCompleted: true } },
            { id: 3, timeLabel: '10:00-11:00', isActive: true, isBooked: false },
            { id: 4, timeLabel: '11:00-12:00', isActive: false, isBooked: false },
            { id: 5, timeLabel: '13:00-14:00', isActive: true, isBooked: true, kunjungan: { nama: 'Tim Peneliti', status: 'PROCESSING', isCompleted: false } },
            { id: 6, timeLabel: '14:00-15:00', isActive: true, isBooked: false },
        ]
    },
    {
        date: '2025-01-08',
        schedules: [
            { id: 7, timeLabel: '08:00-09:00', isActive: true, isBooked: false },
            { id: 8, timeLabel: '09:00-10:00', isActive: true, isBooked: true, kunjungan: { nama: 'Mahasiswa UGM', status: 'PENDING', isCompleted: false } },
            { id: 9, timeLabel: '10:00-11:00', isActive: false, isBooked: false },
            { id: 10, timeLabel: '13:00-14:00', isActive: true, isBooked: true, kunjungan: { nama: 'Dinas Kesehatan', status: 'COMPLETED', isCompleted: true } },
        ]
    },
    {
        date: '2025-01-15',
        schedules: [
            { id: 11, timeLabel: '08:00-09:00', isActive: true, isBooked: true, kunjungan: { nama: 'Universitas Brawijaya', status: 'PROCESSING', isCompleted: false } },
            { id: 12, timeLabel: '09:00-10:00', isActive: true, isBooked: false },
            { id: 13, timeLabel: '10:00-11:00', isActive: true, isBooked: true, kunjungan: { nama: 'RS. Sardjito', status: 'COMPLETED', isCompleted: true } },
            { id: 14, timeLabel: '11:00-12:00', isActive: true, isBooked: false },
            { id: 15, timeLabel: '13:00-14:00', isActive: false, isBooked: false },
            { id: 16, timeLabel: '14:00-15:00', isActive: true, isBooked: false },
            { id: 17, timeLabel: '15:00-16:00', isActive: true, isBooked: true, kunjungan: { nama: 'Peneliti LIPI', status: 'PENDING', isCompleted: false } },
        ]
    }
    // Tambah data lainnya sesuai kebutuhan
];

// Initialize calendar
document.addEventListener('DOMContentLoaded', function() {
    initializeMonthDisplay();
    loadCalendar();
    initializeMonthPicker();
    
    // Month selector change (for hidden input compatibility)
    document.getElementById('month-selector').addEventListener('change', function() {
        currentMonth = this.value;
        updateMonthDisplay();
        loadCalendar();
    });
    
    // Close month picker when clicking outside
    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('month-picker-dropdown');
        const button = e.target.closest('[onclick="toggleMonthPicker()"]');
        if (!dropdown.contains(e.target) && !button) {
            closeMonthPicker();
        }
    });
});

function loadCalendar() {
    // Fetch real data from backend
    console.log('Loading calendar for month:', currentMonth);
    fetch(`/admin/jadwal/calendar-data?month=${currentMonth}`)
        .then(response => {
            console.log('Calendar API response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Calendar data received:', data);
            renderCalendar(data);
            updateStats();
        })
        .catch(error => {
            console.error('Error loading calendar:', error);
            // Show error alert but continue with sample data
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Gagal memuat data jadwal dari server. Menggunakan data sampel.',
                    confirmButtonColor: '#10b981'
                });
            }
            // Fallback to sample data in case of error
            const calendarData = generateCalendarData();
            renderCalendar(calendarData);
            updateStats();
        });
}

function generateCalendarData() {
    const [year, month] = currentMonth.split('-');
    const daysInMonth = new Date(year, month, 0).getDate();
    const today = new Date();
    const currentDateStr = today.toISOString().split('T')[0];
    
    const calendarData = [];
    
    for (let day = 1; day <= daysInMonth; day++) {
        const dateStr = `${year}-${month.padStart(2, '0')}-${day.toString().padStart(2, '0')}`;
        const sampleData = sampleScheduleData.find(item => item.date === dateStr);
        
        const dayData = {
            date: dateStr,
            day: day,
            isToday: dateStr === currentDateStr,
            isPast: new Date(dateStr) < today,
            schedules: sampleData ? sampleData.schedules : []
        };
        
        calendarData.push(dayData);
    }
    
    return calendarData;
}

function renderCalendar(calendarData) {
    const grid = document.getElementById('calendar-grid');
    grid.innerHTML = '';
    
    // Reset stats
    calendarStats = { available: 0, booked: 0, completed: 0, disabled: 0 };
    
    // Add empty cells for days before the first day of the month
    const firstDay = new Date(currentMonth + '-01');
    const firstDayOfWeek = firstDay.getDay();
    
    for (let i = 0; i < firstDayOfWeek; i++) {
        grid.appendChild(createEmptyDay());
    }
    
    // Add calendar days
    calendarData.forEach(day => {
        grid.appendChild(createCalendarDay(day));
        // Update stats
        day.schedules.forEach(schedule => {
            const status = schedule.kunjungan?.status;
            if (status === 'COMPLETED' || schedule.kunjungan?.isCompleted) {
                calendarStats.completed++;
            } else if (status === 'PENDING' || status === 'PROCESSING' || schedule.isBooked) {
                calendarStats.booked++;
            } else if (schedule.isActive) {
                calendarStats.available++;
            } else {
                calendarStats.disabled++;
            }
        });
    });
}

function createEmptyDay() {
    const div = document.createElement('div');
    div.className = 'calendar-cell empty-day bg-gray-50/50 rounded-lg';
    return div;
}

function createCalendarDay(day) {
    const div = document.createElement('div');
    div.className = `calendar-cell bg-white border border-gray-200 rounded-2xl cursor-pointer relative overflow-hidden ${day.isPast ? 'past-day' : ''}`;
    
    if (day.isToday) {
        div.classList.add('today-cell');
    }
    
    div.onclick = () => openScheduleModal(day.date);
    
    // Day number
    const dayNumber = document.createElement('div');
    dayNumber.className = `day-number ${day.isToday ? 'text-white' : 'text-gray-900'}`;
    dayNumber.textContent = day.day;
    div.appendChild(dayNumber);
    
    // Schedule summary di pojok kanan atas
    if (day.schedules.length > 0) {
        const pendingCount = day.schedules.filter(s => s.kunjungan && s.kunjungan.status === 'PENDING').length;
        const approvedCount = day.schedules.filter(s => s.kunjungan && (s.kunjungan.status === 'PROCESSING' || s.kunjungan.status === 'APPROVED')).length;
        const completedCount = day.schedules.filter(s => s.kunjungan && (s.kunjungan.status === 'COMPLETED' || s.kunjungan.isCompleted)).length;
        const activeCount = day.schedules.filter(s => s.isActive && !s.isBooked).length;
        const disabledCount = day.schedules.filter(s => !s.isActive).length;
        
        // Schedule summary di pojok kanan atas
        if (activeCount || disabledCount) {
            const summary = document.createElement('div');
            summary.className = 'schedule-summary';
            
            let summaryParts = [];
            if (activeCount > 0) summaryParts.push(`⚪${activeCount}`);
            if (disabledCount > 0) summaryParts.push(`❌${disabledCount}`);
            
            summary.textContent = summaryParts.join(' ');
            div.appendChild(summary);
        }
    } else {
        // Jika tidak ada jadwal, create default schedules untuk hari ini dan masa depan
        if (!day.isPast) {
            // Create a minimal display for empty days
            const emptyInfo = document.createElement('div');
            emptyInfo.className = 'visit-info px-2 pt-10 text-xs font-medium text-gray-500';
            if (day.isToday) {
                emptyInfo.classList.add('text-white');
            }
            emptyInfo.innerHTML = '<div>Klik untuk atur jadwal</div>';
            div.appendChild(emptyInfo);
        }
    }
    
    // Schedule list
    const scheduleList = document.createElement('div');
    scheduleList.className = 'schedule-list';
    
    day.schedules.forEach(schedule => {
        const scheduleItem = document.createElement('div');
        scheduleItem.className = 'schedule-item';
        
        const status = schedule.kunjungan?.status;
        const nama = schedule.kunjungan?.nama || (schedule.isActive ? 'Tersedia' : 'Nonaktif');
        if (status === 'COMPLETED' || schedule.kunjungan?.isCompleted) {
            scheduleItem.classList.add('schedule-completed');
            scheduleItem.innerHTML = `
                <i class="fas fa-check-circle" style="font-size: 8px;"></i>
                <span>${schedule.timeLabel}</span>
                <span>✓ ${schedule.kunjungan.nama}</span>
            `;
            scheduleItem.title = `Nama: ${nama} | Status: Selesai | Waktu: ${schedule.timeLabel}`;
        } else if (status === 'PROCESSING' || status === 'APPROVED') {
            scheduleItem.classList.add('schedule-approved');
            scheduleItem.innerHTML = `
                <i class="fas fa-calendar-check" style="font-size: 8px;"></i>
                <span>${schedule.timeLabel}</span>
                <span>${schedule.kunjungan.nama}</span>
            `;
            scheduleItem.title = `Nama: ${nama} | Status: Disetujui | Waktu: ${schedule.timeLabel}`;
        } else if (status === 'PENDING') {
            scheduleItem.classList.add('schedule-pending');
            scheduleItem.innerHTML = `
                <i class="fas fa-hourglass-half" style="font-size: 8px;"></i>
                <span>${schedule.timeLabel}</span>
                <span>${schedule.kunjungan.nama}</span>
            `;
            scheduleItem.title = `Nama: ${nama} | Status: Menunggu | Waktu: ${schedule.timeLabel}`;
        } else if (schedule.isBooked && schedule.kunjungan) {
            scheduleItem.classList.add('schedule-approved');
            scheduleItem.innerHTML = `
                <i class="fas fa-user" style="font-size: 8px;"></i>
                <span>${schedule.timeLabel}</span>
                <span>${schedule.kunjungan.nama}</span>
            `;
            scheduleItem.title = `Nama: ${nama} | Status: Dibooking | Waktu: ${schedule.timeLabel}`;
        } else if (schedule.isActive) {
            scheduleItem.classList.add('schedule-available');
            scheduleItem.innerHTML = `
                <i class="fas fa-clock" style="font-size: 8px;"></i>
                <span>${schedule.timeLabel}</span>
                <span>Tersedia</span>
            `;
            scheduleItem.title = `Status: Tersedia | Waktu: ${schedule.timeLabel}`;
        } else {
            scheduleItem.classList.add('schedule-disabled');
            scheduleItem.innerHTML = `
                <i class="fas fa-times" style="font-size: 8px;"></i>
                <span>${schedule.timeLabel}</span>
                <span>Nonaktif</span>
            `;
            scheduleItem.title = `Status: Nonaktif | Waktu: ${schedule.timeLabel}`;
        }
        
        scheduleList.appendChild(scheduleItem);
    });
    
    div.appendChild(scheduleList);
    return div;
}

function updateStats() {
    const setText = (id, value) => {
        const el = document.getElementById(id);
        if (el) el.textContent = value;
    };
    setText('available-count', calendarStats.available);
    setText('booked-count', calendarStats.booked);
    setText('completed-count', calendarStats.completed);
    setText('disabled-count', calendarStats.disabled);
}

function openScheduleModal(date) {
    selectedDate = date;
    document.getElementById('modal-date').textContent = formatDate(date);
    
    // Show loading
    document.getElementById('schedule-list').innerHTML = '<div class="text-center py-4">Memuat jadwal...</div>';
    document.getElementById('schedule-modal').classList.remove('hidden');
    
    // Fetch schedule settings from backend
    fetch(`/admin/jadwal/schedule-settings?date=${date}`)
        .then(response => {
            console.log('Schedule settings response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Schedule settings data:', data);
            if (data.success) {
                renderScheduleList(data.schedules);
            } else {
                throw new Error(data.message || 'Failed to load schedule settings');
            }
        })
        .catch(error => {
            console.error('Error loading schedule settings:', error);
            // Show error in modal
            document.getElementById('schedule-list').innerHTML = `
                <div class="text-center py-4 text-red-600">
                    <i class="fas fa-exclamation-triangle mb-2"></i>
                    <p>Gagal memuat pengaturan jadwal</p>
                    <p class="text-sm">${error.message}</p>
                </div>
            `;
        });
}

function closeScheduleModal() {
    document.getElementById('schedule-modal').classList.add('hidden');
    selectedDate = null;
}

function renderScheduleList(schedules) {
    const container = document.getElementById('schedule-list');
    container.innerHTML = '';
    
    if (schedules.length === 0) {
        container.innerHTML = `
            <div class="text-center py-12">
                <i class="fas fa-calendar-times text-4xl text-gray-400 mb-4"></i>
                <p class="text-gray-500 text-lg">Belum ada jadwal untuk tanggal ini</p>
                <p class="text-gray-400 text-sm mt-2">Jadwal akan tersedia setelah dikonfigurasi oleh administrator</p>
            </div>
        `;
        return;
    }
    
    schedules.forEach(schedule => {
        const item = createScheduleItem(schedule);
        container.appendChild(item);
    });
}

function createScheduleItem(schedule) {
    const div = document.createElement('div');
    div.className = 'flex items-center justify-between p-6 border border-gray-200 rounded-2xl bg-gradient-to-r from-gray-50 to-white hover:shadow-lg transition-all duration-200';
    
    const info = document.createElement('div');
    info.className = 'flex-1';
    
    const timeLabel = document.createElement('div');
    timeLabel.className = 'text-lg font-bold text-gray-900 mb-1';
    timeLabel.innerHTML = `<i class="fas fa-clock text-green-500 mr-2"></i>${schedule.timeLabel}`;
    info.appendChild(timeLabel);
    
    if (schedule.kunjungan) {
        const bookingInfo = document.createElement('div');
        bookingInfo.className = 'text-sm text-gray-600 flex items-center mb-1';
        
        let statusIcon, statusText, statusClass;
        
        switch(schedule.kunjungan.status) {
            case 'PENDING':
                statusIcon = '<i class="fas fa-hourglass-half text-orange-500 mr-2"></i>';
                statusText = 'Menunggu Persetujuan - ';
                statusClass = 'text-orange-600';
                break;
            case 'PROCESSING':
                statusIcon = '<i class="fas fa-check-circle text-blue-500 mr-2"></i>';
                statusText = 'Disetujui - ';
                statusClass = 'text-blue-600';
                break;
            case 'COMPLETED':
                statusIcon = '<i class="fas fa-check-double text-green-500 mr-2"></i>';
                statusText = 'Selesai - ';
                statusClass = 'text-green-600';
                break;
            default:
                statusIcon = '<i class="fas fa-user text-gray-500 mr-2"></i>';
                statusText = 'Dijadwalkan - ';
                statusClass = 'text-gray-600';
        }
        
        bookingInfo.className += ` ${statusClass}`;
        bookingInfo.innerHTML = statusIcon + statusText + schedule.kunjungan.nama;
        info.appendChild(bookingInfo);
        
        // Additional booking details
        if (schedule.kunjungan.namaInstansi) {
            const instansiInfo = document.createElement('div');
            instansiInfo.className = 'text-xs text-gray-500';
            instansiInfo.innerHTML = `<i class="fas fa-building mr-1"></i>${schedule.kunjungan.namaInstansi} (${schedule.kunjungan.jumlahPengunjung} orang)`;
            info.appendChild(instansiInfo);
        }
    }
    
    div.appendChild(info);
    
    const toggle = document.createElement('div');
    toggle.className = 'flex items-center space-x-4';
    
    // Check if schedule can be modified
    const isLocked = schedule.isBooked && schedule.kunjungan && 
                    ['PROCESSING', 'COMPLETED'].includes(schedule.kunjungan.status);
    
    if (!schedule.isBooked) {
        // No booking - show toggle
        const switchContainer = document.createElement('div');
        switchContainer.className = 'flex items-center space-x-3';
        
        const switchBtn = document.createElement('button');
        switchBtn.className = `switch-button ${schedule.isActive ? 'active' : 'inactive'}`;
        switchBtn.onclick = () => toggleSchedule(schedule.id, !schedule.isActive);
        
        const switchThumb = document.createElement('span');
        switchThumb.className = `switch-thumb ${schedule.isActive ? 'active' : 'inactive'}`;
        
        switchBtn.appendChild(switchThumb);
        switchContainer.appendChild(switchBtn);
        
        const statusText = document.createElement('span');
        statusText.className = `text-sm font-medium ${schedule.isActive ? 'text-green-600' : 'text-gray-500'}`;
        statusText.innerHTML = schedule.isActive ? 
            '<i class="fas fa-check mr-1"></i>Aktif' : 
            '<i class="fas fa-times mr-1"></i>Nonaktif';
        switchContainer.appendChild(statusText);
        
        toggle.appendChild(switchContainer);
    } else if (isLocked) {
        // Booking is approved/completed - locked
        const statusBadge = document.createElement('span');
        statusBadge.className = 'px-4 py-2 text-sm font-medium rounded-xl bg-gradient-to-r from-red-500 to-red-600 text-white shadow-lg';
        statusBadge.innerHTML = '<i class="fas fa-lock mr-2"></i>Terkunci';
        toggle.appendChild(statusBadge);
    } else {
        // Booking exists but still pending - show status only
        const statusBadge = document.createElement('span');
        statusBadge.className = 'px-4 py-2 text-sm font-medium rounded-xl bg-gradient-to-r from-orange-500 to-orange-600 text-white shadow-lg';
        statusBadge.innerHTML = '<i class="fas fa-hourglass-half mr-2"></i>Menunggu';
        toggle.appendChild(statusBadge);
    }
    
    div.appendChild(toggle);
    return div;
}

function toggleSchedule(scheduleId, isActive) {
    // Show loading state
    const switchBtn = document.querySelector(`[onclick*="${scheduleId}"]`);
    if (switchBtn) {
        switchBtn.disabled = true;
        switchBtn.style.opacity = '0.7';
    }
    
    // Make API call to toggle availability
    fetch(`/admin/jadwal/toggle-availability`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            scheduleId: scheduleId,
            isActive: isActive
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message,
                timer: 2000,
                showConfirmButton: false
            });
            
            // Reload calendar and modal
            loadCalendar();
            if (selectedDate) {
                setTimeout(() => openScheduleModal(selectedDate), 500);
            }
        } else {
            // Show error message
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: data.message,
                confirmButtonColor: '#38bdf8'
            });
        }
    })
    .catch(error => {
        console.error('Error toggling schedule:', error);
        Swal.fire({
            icon: 'error',
            title: 'Kesalahan!',
            text: 'Terjadi kesalahan saat mengubah jadwal',
            confirmButtonColor: '#38bdf8'
        });
    })
    .finally(() => {
        // Reset button state
        if (switchBtn) {
            switchBtn.disabled = false;
            switchBtn.style.opacity = '1';
        }
    });
}

function formatDate(dateString) {
    const date = new Date(dateString);
    const options = { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric'
    };
    return date.toLocaleDateString('id-ID', options);
}

// Utility functions untuk future development
function exportSchedule() {
    console.log('Exporting schedule data...');
    // Implementation untuk export data jadwal
}

function importSchedule() {
    console.log('Importing schedule data...');
    // Implementation untuk import data jadwal
}

function printSchedule() {
    console.log('Printing schedule...');
    // Implementation untuk print jadwal
}

// Event listeners untuk keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // ESC untuk tutup modal
    if (e.key === 'Escape' && selectedDate) {
        closeScheduleModal();
    }
    
    // Ctrl+M untuk buka modal hari ini
    if (e.ctrlKey && e.key === 'm') {
        e.preventDefault();
        const today = new Date().toISOString().split('T')[0];
        openScheduleModal(today);
    }
});

// Month/Year Navigation Functions
function initializeMonthDisplay() {
    updateMonthDisplay();
}

function updateMonthDisplay() {
    const [year, month] = currentMonth.split('-');
    const monthIndex = parseInt(month) - 1;
    
    document.getElementById('current-month-text').textContent = monthNames[monthIndex];
    document.getElementById('current-year-text').textContent = year;
    document.getElementById('month-selector').value = currentMonth;
}

function navigateMonth(direction) {
    const [year, month] = currentMonth.split('-');
    const currentDate = new Date(parseInt(year), parseInt(month) - 1, 1);
    
    currentDate.setMonth(currentDate.getMonth() + direction);
    
    const newYear = currentDate.getFullYear();
    const newMonth = (currentDate.getMonth() + 1).toString().padStart(2, '0');
    
    currentMonth = `${newYear}-${newMonth}`;
    updateMonthDisplay();
    loadCalendar();
}

function goToToday() {
    const today = new Date();
    const year = today.getFullYear();
    const month = (today.getMonth() + 1).toString().padStart(2, '0');
    
    currentMonth = `${year}-${month}`;
    updateMonthDisplay();
    loadCalendar();
}

function initializeMonthPicker() {
    populateYearSelector();
    populateMonthGrid();
}

function populateYearSelector() {
    const yearSelector = document.getElementById('year-selector');
    const currentYear = new Date().getFullYear();
    
    yearSelector.innerHTML = '';
    
    // Generate years from 2020 to current year + 2
    for (let year = 2020; year <= currentYear + 2; year++) {
        const option = document.createElement('option');
        option.value = year;
        option.textContent = year;
        yearSelector.appendChild(option);
    }
}

function populateMonthGrid() {
    const monthGrid = document.getElementById('month-grid');
    monthGrid.innerHTML = '';
    
    monthNames.forEach((monthName, index) => {
        const monthButton = document.createElement('button');
        monthButton.className = 'p-3 text-sm font-medium rounded-lg border border-gray-200 hover:bg-emerald-50 hover:border-emerald-300 hover:text-emerald-700 transition-all duration-200 text-center';
        monthButton.textContent = monthName;
        monthButton.onclick = () => selectMonth(index);
        monthButton.setAttribute('data-month', index);
        monthGrid.appendChild(monthButton);
    });
}

function selectMonth(monthIndex) {
    // Remove previous selection
    document.querySelectorAll('#month-grid button').forEach(btn => {
        btn.classList.remove('bg-emerald-100', 'border-emerald-400', 'text-emerald-800');
        btn.classList.add('border-gray-200');
    });
    
    // Add selection to clicked month
    const selectedButton = document.querySelector(`#month-grid button[data-month="${monthIndex}"]`);
    selectedButton.classList.add('bg-emerald-100', 'border-emerald-400', 'text-emerald-800');
    selectedButton.classList.remove('border-gray-200');
    
    selectedMonthIndex = monthIndex;
}

function toggleMonthPicker() {
    const dropdown = document.getElementById('month-picker-dropdown');
    const [currentYear, currentMonthValue] = currentMonth.split('-');
    
    if (dropdown.classList.contains('hidden')) {
        // Set current values when opening
        document.getElementById('year-selector').value = currentYear;
        selectedYear = currentYear;
        selectedMonthIndex = parseInt(currentMonthValue) - 1;
        
        // Update month grid selection
        document.querySelectorAll('#month-grid button').forEach(btn => {
            btn.classList.remove('bg-emerald-100', 'border-emerald-400', 'text-emerald-800');
            btn.classList.add('border-gray-200');
        });
        
        const currentMonthButton = document.querySelector(`#month-grid button[data-month="${selectedMonthIndex}"]`);
        if (currentMonthButton) {
            currentMonthButton.classList.add('bg-emerald-100', 'border-emerald-400', 'text-emerald-800');
            currentMonthButton.classList.remove('border-gray-200');
        }
        
        dropdown.classList.remove('hidden');
        dropdown.style.opacity = '0';
        dropdown.style.transform = 'translateY(-10px)';
        
        // Smooth animation
        setTimeout(() => {
            dropdown.style.transition = 'all 0.2s cubic-bezier(0.4, 0, 0.2, 1)';
            dropdown.style.opacity = '1';
            dropdown.style.transform = 'translateY(0)';
        }, 10);
    } else {
        closeMonthPicker();
    }
}

function closeMonthPicker() {
    const dropdown = document.getElementById('month-picker-dropdown');
    dropdown.style.opacity = '0';
    dropdown.style.transform = 'translateY(-10px)';
    
    setTimeout(() => {
        dropdown.classList.add('hidden');
    }, 200);
}

function applyMonthSelection() {
    const selectedYearValue = document.getElementById('year-selector').value;
    
    if (selectedMonthIndex !== null && selectedYearValue) {
        const monthValue = (selectedMonthIndex + 1).toString().padStart(2, '0');
        currentMonth = `${selectedYearValue}-${monthValue}`;
        
        updateMonthDisplay();
        loadCalendar();
        closeMonthPicker();
    }
}

// Update year selector change handler
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('year-selector').addEventListener('change', function() {
        selectedYear = this.value;
    });
});

// Auto refresh setiap 5 menit untuk update real-time
setInterval(function() {
    if (!selectedDate) { // Hanya refresh jika modal tidak terbuka
        loadCalendar();
    }
}, 300000); // 5 menit
</script>   