# Calendar Display Issue - Debugging Guide

## Masalah yang Dilaporkan
Di kelola jadwal, calendar cell menampilkan "Tidak ada kunjungan" meskipun di database dan card pengaturan jadwal sudah menunjukkan bahwa ada kunjungan yang selesai di tanggal tersebut.

## Perbaikan yang Sudah Dilakukan

### 1. ✅ Menambahkan Logging di JadwalController
**File**: `app/Http/Controllers/JadwalController.php`
- Menambahkan log untuk tracking data yang diminta dan dikirim
- Menambahkan log untuk debugging groupBy tanggal
- Memperbaiki null check untuk kunjungan

### 2. ✅ Menambahkan Error Handling di Frontend
**File**: `resources/views/admin/components/tabs/schedule.blade.php`
- Menambahkan console.log untuk debugging
- Menambahkan error handling yang lebih baik
- Menambahkan SweetAlert untuk notifikasi error

### 3. ✅ Memperbaiki Grouping Logic
**File**: `app/Http/Controllers/JadwalController.php`
```php
// Sebelum
->groupBy('tanggal');

// Sesudah  
->groupBy(function($item) {
    return $item->tanggal->format('Y-m-d');
});
```

## Cara Testing

### 1. Buka Browser Developer Console
- Tekan F12 di browser
- Buka tab Console
- Buka halaman Admin Dashboard > Tab Jadwal

### 2. Periksa Log di Console
Anda harus melihat log seperti:
```
Loading calendar for month: 2025-01
Calendar API response status: 200
Calendar data received: [...]
```

### 3. Periksa Laravel Log
Buka file `storage/logs/laravel.log` dan cari log seperti:
```
[timestamp] local.INFO: Calendar data requested {"month":"2025-01","user":"1"}
[timestamp] local.INFO: Schedules found {"total_schedules":5,"dates_with_schedules":["2025-01-10","2025-01-11"]}
```

### 4. Periksa Response API Langsung
Buka URL ini di browser (ganti bulan sesuai kebutuhan):
```
http://localhost/admin/jadwal/calendar-data?month=2025-01
```

Response seharusnya berupa JSON dengan struktur:
```json
[
  {
    "date": "2025-01-10",
    "day": 10,
    "isToday": false,
    "isPast": false,
    "schedules": [
      {
        "id": "uuid-here",
        "timeLabel": "09:00 - 10:00",
        "isActive": true,
        "isBooked": true,
        "kunjungan": {
          "nama": "Dr. Ahmad",
          "status": "COMPLETED",
          "isCompleted": true,
          "namaInstansi": "Universitas ABC",
          "jumlahPengunjung": 5
        }
      }
    ],
    "hasBookings": true,
    "bookingInfo": "✓ Dr. Ahmad (09:00 - 10:00)"
  }
]
```

## Kemungkinan Penyebab Masalah

### 1. Data Tidak Ada di Database
Periksa apakah benar ada data jadwal dengan kunjungan:
```sql
SELECT j.*, k.namaPengunjung, k.status 
FROM jadwal j 
LEFT JOIN kunjungan k ON j.kunjunganId = k.id 
WHERE j.tanggal = '2025-01-10';
```

### 2. Route Tidak Terdaftar
Periksa routes dengan:
```bash
php artisan route:list --name=jadwal
```

### 3. Middleware atau Auth Issue
Pastikan user sudah login sebagai admin dan dapat mengakses endpoint.

### 4. JavaScript Error
Periksa Console untuk error JavaScript yang menghalangi render calendar.

## Data Test untuk Manual Testing

Jika ingin membuat data test manual, gunakan:

```sql
-- Buat kunjungan test
INSERT INTO kunjungan (id, namaPengunjung, tujuan, jumlahPengunjung, status, noHp, namaInstansi, suratPengajuan, created_at, updated_at) 
VALUES 
('KJG-20250810-0001', 'Dr. Test User', 'Testing Purpose', 1, 'COMPLETED', '081234567890', 'Test Institution', 'test.pdf', NOW(), NOW());

-- Buat jadwal test
INSERT INTO jadwal (id, tanggal, waktuKunjungan, isActive, kunjunganId, created_at, updated_at) 
VALUES 
(UUID(), '2025-01-10', '09:00-10:00', 1, 'KJG-20250810-0001', NOW(), NOW());
```

## Expected Behavior Setelah Perbaikan

1. **Calendar cells** harus menampilkan status kunjungan yang benar:
   - "X Kunjungan Selesai" untuk status COMPLETED
   - "X Kunjungan Disetujui" untuk status PROCESSING
   - "X Kunjungan Diajukan" untuk status PENDING

2. **Console logs** harus menunjukkan data yang benar dari API

3. **Tidak ada error** di console atau Laravel log

4. **Badge indicators** harus muncul dengan warna yang sesuai status
