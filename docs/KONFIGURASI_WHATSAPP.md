# 📱 Konfigurasi Nomor WhatsApp Admin

## 📍 Cara Mengubah Nomor WhatsApp Admin

### 1. **Melalui File .env (Recommended)**

Tambahkan konfigurasi berikut di file `.env`:

```env
# Admin Contact Configuration
ADMIN_WHATSAPP=6282283055874
ADMIN_WHATSAPP_DISPLAY="+62 822-8305-5874"
ADMIN_EMAIL="admin@fismed.unsyiah.ac.id"
```

### 2. **Format Nomor WhatsApp**

- **ADMIN_WHATSAPP**: Format untuk WhatsApp API (tanpa + dan spasi)
  - Contoh: `6282283055874` (dimulai dengan 62 untuk Indonesia)
  
- **ADMIN_WHATSAPP_DISPLAY**: Format untuk ditampilkan ke user
  - Contoh: `"+62 822-8305-5874"`

### 3. **Setelah Mengubah Konfigurasi**

1. Simpan file `.env`
2. Jalankan perintah: `php artisan config:cache`
3. Refresh browser

## 📂 File yang Menggunakan Konfigurasi WhatsApp

1. **User Tracking Page**: `resources/views/user/components/facilities/equipment-rental-tracking.blade.php`
   - Menampilkan nomor WhatsApp admin
   - Tombol "Konfirmasi via WhatsApp"

2. **Admin Dashboard**: `resources/views/admin/components/tabs/peminjaman-alat.blade.php`
   - Template WhatsApp untuk notifikasi ke user

3. **Config File**: `config/app.php`
   - Konfigurasi admin contact

## 🔧 Contoh Penggunaan di Blade Template

```php
<!-- Menampilkan nomor WhatsApp -->
{{ config('app.admin_contact.whatsapp_display') }}

<!-- Menggunakan nomor untuk WhatsApp API -->
const phoneNumber = '{{ config('app.admin_contact.whatsapp') }}';
```

## ⚙️ Default Values

Jika tidak dikonfigurasi di `.env`, akan menggunakan default:
- WhatsApp: `62XXXXXXXXXX`
- Display: `+62 XXX-XXXX-XXXX`
- Email: `admin@fismed.unsyiah.ac.id`

## 📝 Catatan Penting

1. **Format Nomor**: Pastikan nomor WhatsApp dimulai dengan kode negara (62 untuk Indonesia)
2. **Tanpa Karakter Khusus**: Untuk API WhatsApp, gunakan angka saja
3. **Testing**: Setelah mengubah, test tombol WhatsApp untuk memastikan berfungsi
4. **Cache**: Jangan lupa clear config cache setelah perubahan

## 🚀 Quick Setup

```bash
# 1. Edit file .env
nano .env

# 2. Tambahkan konfigurasi WhatsApp
echo "ADMIN_WHATSAPP=6282283055874" >> .env
echo 'ADMIN_WHATSAPP_DISPLAY="+62 822-8305-5874"' >> .env

# 3. Clear cache
php artisan config:cache
``` 