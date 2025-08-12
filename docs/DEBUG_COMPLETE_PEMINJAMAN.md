# 🐛 Debug Complete Peminjaman

## 🔍 **Perbaikan yang Telah Dilakukan**

### 1. **Controller Fixes (PeminjamanController.php)**
- ✅ **JSON Response**: Ditambahkan proper JSON response untuk AJAX
- ✅ **Validation Check**: Cek status COMPLETED dan kondisi_pengembalian
- ✅ **Error Logging**: Detailed logging untuk debugging
- ✅ **Better Error Messages**: Error message lebih deskriptif

### 2. **JavaScript Fixes (peminjaman-alat.blade.php)**
- ✅ **Headers**: Ditambahkan Accept dan X-Requested-With headers
- ✅ **Validation**: Pre-submit validation untuk data integrity
- ✅ **Error Handling**: Better error handling dan logging
- ✅ **Real-time Validation**: Input validation on change
- ✅ **Global Variable**: Proper currentPeminjamanId initialization

### 3. **UI Improvements**
- ✅ **Visual Feedback**: Border merah untuk input invalid
- ✅ **Warning Messages**: Real-time warning untuk total tidak sesuai
- ✅ **Better UX**: Loading states dan success messages

## 🧪 **Testing Steps**

### **Step 1: Verifikasi Status Peminjaman**
```bash
# Pastikan peminjaman memiliki status COMPLETED dan kondisi_pengembalian kosong
# Di database atau admin dashboard, cek:
- Status: COMPLETED
- kondisi_pengembalian: NULL atau empty
```

### **Step 2: Test Modal Opening**
```bash
# Di admin dashboard:
1. Klik tombol "Proses Pengembalian" (ikon undo)
2. ✅ Modal harus terbuka
3. ✅ Form items harus ter-populate
4. ✅ Console log: "Starting completePeminjaman for ID: [ID]"
```

### **Step 3: Test Input Validation**
```bash
# Di modal completion:
1. Ubah "Jumlah Baik" atau "Jumlah Rusak"
2. ✅ Total harus = jumlah dipinjam
3. ✅ Jika tidak sesuai: border merah + warning text
4. ✅ Jika sesuai: border normal + warning hilang
```

### **Step 4: Test Form Submission**
```bash
# Submit form dengan data valid:
1. Isi "Kondisi Pengembalian"
2. Pastikan semua total sesuai
3. Klik "Selesaikan Peminjaman"
4. ✅ Console logs:
   - "Sending completion data: {data}"
   - "Response status: 200"
   - "Response data: {success: true}"
5. ✅ Success notification
6. ✅ Modal close
7. ✅ Page reload
```

## 🔧 **Debug Commands**

### **Check Laravel Logs:**
```bash
# Monitor logs real-time
tail -f storage/logs/laravel.log

# Look for:
- "Starting complete peminjaman process"
- "Processing item"
- Any error messages
```

### **Browser Console Debug:**
```javascript
// Check if currentPeminjamanId is set
console.log('currentPeminjamanId:', currentPeminjamanId);

// Check form data before submit
const formData = new FormData(document.getElementById('completeForm'));
console.log('Form data:', Object.fromEntries(formData));

// Check if modal elements exist
console.log('Modal exists:', !!document.getElementById('completeModal'));
console.log('Form exists:', !!document.getElementById('completeForm'));
```

### **Network Tab Debug:**
```bash
# In browser dev tools Network tab:
1. Look for POST request to /admin/peminjaman/{id}/complete
2. Check request headers include:
   - Content-Type: application/json
   - Accept: application/json
   - X-Requested-With: XMLHttpRequest
   - X-CSRF-TOKEN: [token]
3. Check request payload structure
4. Check response status and body
```

## 🚨 **Common Issues & Solutions**

### **Issue 1: Modal Tidak Terbuka**
```bash
# Check:
1. JavaScript errors in console
2. currentPeminjamanId variable
3. Modal element exists in DOM

# Solution:
- Refresh page
- Check if tab is properly loaded
```

### **Issue 2: Items Tidak Load**
```bash
# Check:
1. /admin/peminjaman/{id}/items endpoint response
2. Console errors during fetch
3. Data structure dari API

# Solution:
- Verify peminjaman has items
- Check controller items() method
```

### **Issue 3: Submit Gagal**
```bash
# Check:
1. CSRF token valid
2. Request headers correct
3. Data validation errors
4. Laravel logs untuk error detail

# Solution:
- Clear browser cache
- Check validation rules
- Verify database constraints
```

### **Issue 4: Stock Tidak Update**
```bash
# Check:
1. Database transaction success
2. Alat stock values before/after
3. Calculation logic in controller

# Solution:
- Check jumlah_baik + jumlah_rusak = jumlah_dipinjam
- Verify database updates
```

## 📊 **Expected Data Flow**

### **1. Modal Open:**
```javascript
completePeminjaman('uuid') 
→ fetch('/admin/peminjaman/uuid/items')
→ populate form with items
→ show modal
```

### **2. Form Submit:**
```javascript
form.submit 
→ validate data
→ fetch('/admin/peminjaman/uuid/complete', {POST, JSON})
→ controller validation
→ database update
→ JSON response
→ UI feedback
```

### **3. Database Updates:**
```sql
-- For each item:
UPDATE alat SET 
  jumlah_tersedia = jumlah_tersedia + jumlah_baik,
  jumlah_dipinjam = jumlah_dipinjam - jumlah_total,
  jumlah_rusak = jumlah_rusak + jumlah_rusak

-- For peminjaman:
UPDATE peminjaman SET 
  kondisi_pengembalian = 'description'
```

## 🎯 **Success Criteria**

- [ ] Modal terbuka dengan data items
- [ ] Real-time validation bekerja
- [ ] Form submit tanpa error
- [ ] Database stock ter-update
- [ ] kondisi_pengembalian ter-isi
- [ ] Success notification muncul
- [ ] Page refresh otomatis

## 🔄 **Quick Test Script**

```bash
# 1. Setup test peminjaman
php artisan tinker
$peminjaman = App\Models\Peminjaman::where('status', 'COMPLETED')
    ->whereNull('kondisi_pengembalian')->first();
echo "Test dengan ID: " . $peminjaman->id;

# 2. Test API endpoint
curl -X GET "http://localhost/admin/peminjaman/{ID}/items" \
  -H "Accept: application/json"

# 3. Test complete endpoint
curl -X POST "http://localhost/admin/peminjaman/{ID}/complete" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "kondisi_pengembalian": "Test completion",
    "items": [{"jumlah_baik": 1, "jumlah_rusak": 0}]
  }'
``` 