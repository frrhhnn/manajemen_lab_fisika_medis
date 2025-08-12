# Custom ID Format Documentation

## Format ID yang Digunakan

### Peminjaman Alat
- **Format**: `PJM-YYYYMMDD-XXXX`
- **Prefix**: `PJM-`
- **Contoh**: `PJM-20231225-0001`, `PJM-20231225-0002`
- **Implementasi**: File `app/Models/Peminjaman.php`

### Kunjungan Lab
- **Format**: `KJG-YYYYMMDD-XXXX`
- **Prefix**: `KJG-`
- **Contoh**: `KJG-20231225-0001`, `KJG-20231225-0002`
- **Implementasi**: File `app/Models/Kunjungan.php`

## Penjelasan Format

### Struktur ID
1. **Prefix**: 3 huruf singkatan + tanda strip (-)
   - `PJM-` untuk Peminjaman
   - `KJG-` untuk Kunjungan

2. **Tanggal**: Format YYYYMMDD
   - YYYY = Tahun (4 digit)
   - MM = Bulan (2 digit)
   - DD = Tanggal (2 digit)

3. **Nomor Urut**: 4 digit dengan leading zero
   - Reset setiap hari
   - Dimulai dari 0001
   - Maksimal 9999 per hari

### Contoh Penggunaan
```php
// Peminjaman pada tanggal 25 Desember 2023
PJM-20231225-0001  // Peminjaman pertama hari itu
PJM-20231225-0002  // Peminjaman kedua hari itu
PJM-20231225-0003  // Peminjaman ketiga hari itu

// Kunjungan pada tanggal yang sama
KJG-20231225-0001  // Kunjungan pertama hari itu
KJG-20231225-0002  // Kunjungan kedua hari itu
```

## Cara Mengubah Prefix

### Untuk Peminjaman
Edit file `app/Models/Peminjaman.php` pada method `generateCustomId()`:
```php
$prefix = 'PJM-' . $today . '-';  // Ganti 'PJM-' dengan prefix yang diinginkan
```

### Untuk Kunjungan
Edit file `app/Models/Kunjungan.php` pada method `generateCustomId()`:
```php
$prefix = 'KJG-' . $today . '-';  // Ganti 'KJG-' dengan prefix yang diinginkan
```

## Keuntungan Format Ini

1. **Mudah Dibaca**: Format yang jelas dan terstruktur
2. **Sortable**: ID dapat diurutkan secara natural
3. **Traceable**: Tanggal pembuatan terlihat dari ID
4. **Unique**: Tidak akan ada duplikasi ID
5. **Extensible**: Mudah ditambahkan kategori baru dengan prefix berbeda

## Migrasi dari UUID

Jika sebelumnya menggunakan UUID dan ingin beralih ke custom ID:
1. Data lama tetap menggunakan UUID
2. Data baru menggunakan custom ID format
3. Kedua format dapat berjalan bersamaan karena keduanya string
