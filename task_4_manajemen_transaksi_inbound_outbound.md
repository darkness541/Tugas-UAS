# Task 4: Manajemen Transaksi Inbound & Outbound

## Deskripsi Tugas
Ini merupakan *core logic* dari sistem inventaris. Membangun pencatatan keluar/masuknya stok barang yang secara dinamis dan aman mengubah nilai `current_stock` dari entitas `Item`.

## Kebutuhan Skema Database
- **TRANSACTIONS**
  - `id` (PK)
  - `item_id` (FK to items.id)
  - `user_id` (FK to users.id) - Mencatat *Staf Gudang* yang menginput.
  - `supplier_id` (FK to suppliers.id) - *Nullable* jika jenis transaksinya "out".
  - `type` (enum/string: 'in' atau 'out')
  - `quantity` (integer)
  - `reference_number` (string)
  - `transaction_date` (datetime/date)
  - `notes` (text)

## Detail Pekerjaan
1. **Migrasi, Model & Relasi:**
   - Buat struktur migrasi `transactions`.
   - Setup model dengan relasi `belongsTo` terhadap Item, User, dan Supplier.
2. **Logika Bisnis & Validasi (Transaction Rules):**
   - **Inbound (Stock In):** Membutuhkan *Item*, *Supplier*, *Quantity*, dll. Menambah `current_stock` pada tabel `items`.
   - **Outbound (Stock Out):** Membutuhkan *Item*, *Quantity*, dll. Mengurangi `current_stock` pada tabel `items`.
   - **Validasi Kritis:** Tolak transaksi *Outbound* jika *Quantity* melebihi *current_stock* (mencegah stok minus).
   - Pastikan transaksi bersifat *immutable* (atau sangat terkontrol ketat) agar *audit trail* konsisten. Gunakan DB Transactions (commit/rollback) saat insert transaksi & update stok.
3. **Seeder & Dummy Data:**
   - Buat `TransactionSeeder` yang mensimulasikan riwayat minimal 100+ transaksi di bulan terakhir.
   - Logika *seeder* harus disesuaikan agar angka *current_stock* di Item sinkron dengan jumlah transaksi IN/OUT, atau bisa saja *seeder* menjalankan fungsi kalkulasi saat memicu *factory*.
4. **Otorisasi:**
   - *Staf Gudang* diberikan akses utama untuk modul input/pengurangan stok.
   - *Admin* bisa mengakses untuk kontrol atau pemantauan darurat.
