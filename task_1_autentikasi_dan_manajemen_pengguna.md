# Task 1: Autentikasi dan Manajemen Pengguna

## Deskripsi Tugas
Menyesuaikan sistem autentikasi dan manajemen pengguna (User Management) yang sudah ada di aplikasi Laravel saat ini agar selaras dengan kebutuhan di PRD.md, khususnya terkait pengaturan peran pengguna (*User Role*).

## Kebutuhan Skema Database
Sesuai dengan PRD, pastikan struktur tabel berikut diimplementasikan (sesuaikan migrasi jika perlu):
- **ROLES**
  - `id` (PK)
  - `name` (string)
  - `description` (string)
- **USERS**
  - `id` (PK)
  - `name` (string)
  - `email` (string)
  - `password` (string)
  - `role_id` (FK to roles.id)
  - `created_at`, `updated_at` (datetime)

## Detail Pekerjaan
1. **Penyesuaian Struktur Tabel:** 
   - Modifikasi tabel `users` (tambahkan `role_id`).
   - Buat tabel `roles` dan relasinya.
2. **Penyesuaian Logika CRUD (User Management):** 
   - Modifikasi Controller, Model, dan Request/Validation yang berkaitan dengan User Management untuk mendukung peran baru (Admin, Staf Gudang, Manajer).
   - Pastikan relasi Eloquent terpasang dengan baik (User `belongsTo` Role, Role `hasMany` Users).
3. **Seeder & Dummy Data:**
   - Buat atau perbarui `RoleSeeder` dengan minimal 3 peran: *Admin*, *Staf Gudang*, dan *Manajer*.
   - Perbarui `UserSeeder` untuk menyertakan data dummy untuk masing-masing peran tersebut.
4. **Aturan Khusus (CRITICAL):**
   - **Wajib** mengikuti standar *coding style*, pola arsitektur, dan konvensi penamaan yang sudah ada (*existing*) pada modul user saat ini.
   - **Dilarang** membuat pola baru yang tidak konsisten (misalnya, jika sebelumnya menggunakan metode arsitektur tertentu seperti *Repository Pattern* atau *Action Classes*, maka teruskan pola tersebut).
