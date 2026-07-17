# Task 2: Manajemen Master Data (Kategori & Supplier)

## Deskripsi Tugas
Membangun fitur *Create, Read, Update, Delete* (CRUD) inti untuk master data pendukung: Kategori Barang dan Supplier. Modul ini penting sebagai basis relasi dari master data Barang di task berikutnya.

## Kebutuhan Skema Database
- **CATEGORIES**
  - `id` (PK)
  - `name` (string)
  - `description` (string)
- **SUPPLIERS**
  - `id` (PK)
  - `name` (string)
  - `contact_person` (string)
  - `phone` (string)
  - `address` (string)

## Detail Pekerjaan
1. **Pembuatan Migrasi & Model:**
   - Buat migrasi, model, dan factory untuk `Category` dan `Supplier`.
2. **Pembuatan CRUD:**
   - Buat fungsi CRUD untuk kategori barang.
   - Buat fungsi CRUD untuk supplier barang.
   - Berikan validasi form yang sesuai (misal: nama kategori unik, telepon valid).
3. **Seeder & Dummy Data:**
   - Buat `CategorySeeder` untuk membuat setidaknya 5-10 kategori sampel (contoh: Elektronik, Pakaian, Makanan, Alat Tulis).
   - Buat `SupplierSeeder` untuk *generate* setidaknya 10 supplier fiktif agar antarmuka dapat diuji coba tampilannya.
4. **Keamanan & Otorisasi:**
   - Hanya pengguna dengan *Role Admin* yang boleh mengakses modul CRUD master data ini (implementasi Middleware/Gate/Policy).
