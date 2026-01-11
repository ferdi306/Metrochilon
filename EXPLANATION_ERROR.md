# Penjelasan Error @keyframes di Blade Template

## Penyebab Error

### 1. **Karakter `@` adalah Directive di Blade**
   - Di Laravel Blade, karakter `@` digunakan untuk directive PHP
   - Contoh: `@if`, `@foreach`, `@php`, `@keyframes` (dianggap sebagai directive)
   - Blade akan mencoba memproses `@keyframes` sebagai directive PHP, bukan sebagai CSS

### 2. **Kenapa Hanya di Halaman Tertentu?**
   
   **File yang ERROR:**
   - File yang menggunakan `@keyframes` (single `@`) di dalam tag `<style>`
   - Blade masih memproses `@` meskipun di dalam tag `<style>`
   - Terjadi error: `syntax error, unexpected identifier "gradientShift"`

   **File yang TIDAK ERROR:**
   - File yang menggunakan `@@keyframes` (double `@`)
   - `@@` di Blade akan di-render sebagai `@` di output HTML
   - Jadi `@@keyframes` menjadi `@keyframes` di browser (benar untuk CSS)

### 3. **Solusi yang Benar**

   **Gunakan `@@keyframes` bukan `@keyframes`:**
   ```css
   <style>
       @@keyframes gradientShift {
           0% { background-position: 0% 50%; }
           50% { background-position: 100% 50%; }
           100% { background-position: 0% 50%; }
       }
   </style>
   ```

   **Output di browser akan menjadi:**
   ```css
   @keyframes gradientShift {
       0% { background-position: 0% 50%; }
       50% { background-position: 100% 50%; }
       100% { background-position: 0% 50%; }
   }
   ```

## File yang Sudah Diperbaiki

Semua file sudah diperbaiki dan menggunakan `@@keyframes` (double `@`):
- ✅ `resources/views/admin/dashboard.blade.php`
- ✅ `resources/views/admin/employees/index.blade.php`
- ✅ `resources/views/admin/employees/create.blade.php`
- ✅ `resources/views/admin/employees/edit.blade.php`
- ✅ `resources/views/admin/employees/show.blade.php`
- ✅ `resources/views/admin/leave/index.blade.php`
- ✅ `resources/views/admin/attendances/index.blade.php`
- ✅ `resources/views/admin/locations/index.blade.php`
- ✅ `resources/views/admin/attendance-settings/index.blade.php`
- ✅ `resources/views/employee/leave/create.blade.php`
- ✅ `resources/views/employee/attendance/index.blade.php`
- ✅ `resources/views/karyawan/dashboard.blade.php`
- ✅ `resources/views/karyawan/absen.blade.php`

## Kesimpulan

**Penyebab Error:**
- Blade template engine memproses `@` sebagai directive PHP
- `@keyframes` dianggap sebagai directive, bukan CSS
- Error: `syntax error, unexpected identifier "gradientShift"`

**Solusi:**
- Gunakan `@@keyframes` (double `@`) di dalam tag `<style>`
- Blade akan me-render `@@` sebagai `@` di output HTML
- Browser akan menerima `@keyframes` yang benar untuk CSS

**Kenapa Hanya di Halaman Tertentu?**
- File yang menggunakan `@keyframes` (single `@`) → ERROR
- File yang menggunakan `@@keyframes` (double `@`) → TIDAK ERROR
- Sekarang semua file sudah menggunakan `@@keyframes`, jadi tidak ada lagi error

