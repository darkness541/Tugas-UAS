# Task 3: Manajemen Master Data Barang (Items)

## Deskripsi Tugas
Membangun fitur manajemen inventaris utama (*Items/Products*). Fitur ini akan menjadi pusat referensi stok, yang berkaitan erat dengan master kategori.

## Kebutuhan Skema Database
- **ITEMS**
  - `id` (PK)
  - `sku` (string, unik)
  - `name` (string)
  - `category_id` (FK to categories.id)
  - `minimum_stock` (integer)
  - `current_stock` (integer, default 0)
  - `price` (decimal/integer)
  - `created_at`, `updated_at` (datetime)

## Detail Pekerjaan
1. **Migrasi & Model:**
   - Setup migrasi untuk tabel `items` beserta Foreign Key ke `categories`.
   - Setup model `Item` beserta relasi `belongsTo` Category.
2. **Logika CRUD Barang:**
   - Pembuatan data barang (termasuk *auto-generate* atau validasi *SKU*).
   - View daftar barang dilengkapi dengan fitur pencarian dan filter berdasarkan Kategori.
3. **Seeder & Dummy Data:**
   - Buat `ItemSeeder` (dan `ItemFactory`) untuk menghasilkan 50+ variasi barang dummy.
   - Pastikan variasi *current_stock* dan *minimum_stock* dibuat serealistis mungkin agar bisa diuji visualisasinya saat stok rendah (low stock).
4. **Otorisasi:**
   - Hanya *Admin* yang dapat menambah/menghapus/mengubah data utama barang. *Manajer* dan *Staf Gudang* dibatasi hanya untuk melihat detail/daftar (Read-only).
