# Task 5: Dashboard dan Pelaporan (Reporting)

## Deskripsi Tugas
Membuat modul rangkuman visual untuk membantu *Manajer* dan *Admin* melakukan pemantauan sistem, serta membangun fitur *export* data analitik historis gudang.

## Detail Pekerjaan
1. **Pengembangan UI Dashboard:**
   - Buat ringkasan KPI (*Key Performance Indicators*): Total Barang, Estimasi Valuasi Stok (stok x harga), Total Supplier.
   - **Peringatan Stok Rendah (Low Stock Alerts):** Menampilkan tabel ringkas barang-barang yang `current_stock` <= `minimum_stock`.
   - **Grafik Transaksi:** Menampilkan grafik batang/garis pergerakan transaksi IN vs OUT selama 30 hari terakhir.
2. **Pembuatan Laporan (Reporting):**
   - Buat fitur *Report Generator* untuk menampilkan riwayat tabel transaksi berdasarkan periode tanggal (*Date Range*).
   - Sediakan tombol export ke PDF (contoh: via dompdf/snappy) dan/atau Excel (contoh: via maatwebsite/excel).
3. **Pemanfaatan Dummy Data:**
   - Karena `TransactionSeeder` dan seeder lain telah dijalankan di *Task 4*, pastikan visualisasi metrik pada dashboard otomatis menggunakan data dummy tersebut. 
4. **Otorisasi Akses:**
   - Dashboard dapat diakses semua role, tetapi konten yang bisa di-klik mungkin berbeda sesuai role.
   - Pelaporan mendalam menjadi fokus utama untuk akun dengan *Role Manajer*.
