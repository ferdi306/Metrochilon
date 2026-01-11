# Update Remaining Views - Tema Biru Telekomunikasi

## ✅ Sudah Diupdate:
1. ✅ `resources/views/admin/dashboard.blade.php`
2. ✅ `resources/views/karyawan/dashboard.blade.php`
3. ✅ `resources/views/admin/leave/index.blade.php`

## 📝 File yang Perlu Diupdate (dengan pola yang sama):

### Admin Views:
- `resources/views/admin/attendance-settings/index.blade.php`
- `resources/views/admin/employees/index.blade.php`
- `resources/views/admin/employees/create.blade.php`
- `resources/views/admin/employees/edit.blade.php`
- `resources/views/admin/employees/show.blade.php`
- `resources/views/admin/attendances/index.blade.php`
- `resources/views/admin/locations/index.blade.php`

### Karyawan Views:
- `resources/views/karyawan/absen.blade.php`
- `resources/views/employee/leave/create.blade.php`
- `resources/views/attendance/index.blade.php` (jika ada)
- `resources/views/attendance/history.blade.php` (jika ada)

## 🔄 Pola Replace yang Sama:

1. **CSS Variables:**
   - `--red-primary:#dc2626` → `--primary:#0066ff`
   - `--red-secondary:#ef4444` → `--accent:#00b8d4`
   - `--red-light:#fee2e2` → `--primary-light:#e6f2ff`
   - `--red-dark:#991b1b` → `--primary-dark:#0052cc`
   - `--bg:#fef2f2` → `--bg:#f8fafc`

2. **Background Gradients:**
   - `#fee2e2` → `#e6f2ff`
   - `#fecaca` → `#e0f7fa`
   - `#fef2f2` → `#f8fafc`

3. **RGBA Colors:**
   - `rgba(220,38,38,` → `rgba(0,102,255,`
   - `rgba(239,68,68,` → `rgba(0,184,212,`

4. **CSS Variables Usage:**
   - `var(--red-primary)` → `var(--primary)`
   - `var(--red-secondary)` → `var(--accent)`
   - `var(--red-light)` → `var(--primary-light)`
   - `var(--red-dark)` → `var(--primary-dark)`

## ⚠️ Catatan:
- Tetap mempertahankan warna merah untuk **danger/delete** actions
- Tetap mempertahankan warna hijau untuk **success** actions
- Hanya warna **primary/accent** yang diubah ke biru


