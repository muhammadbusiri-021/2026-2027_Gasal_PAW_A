# Praktikum Pemrograman Aplikasi Web (PAW)
## Modul 6 – Pengelolaan Master Detil Data
**NIM / Nama**: 25-064 / Moh. Busiri  
**Kelas**: PAW A (Gasal 2026/2027)

---

### Struktur Berkas
- `koneksi.php`: Koneksi ke basis data MySQL `penjualan` menggunakan PDO.
- `penjualan.sql`: Berkas dump database lengkap (tabel supplier, barang, pelanggan, transaksi, transaksi_detail, pembayaran, user beserta relasi FK dan data awal minimal 10 baris per tabel).
- `index.php`: Halaman utama Master-Detail untuk data transaksi (Master: `transaksi`, Detail: `transaksi_detail`) dengan form penambahan item barang.
- `tambah_detail.php`: Proses penambahan item ke `transaksi_detail` dengan perhitungan otomatis subtotal dan pembaruan kolom `total` pada tabel `transaksi`.
- `hapus_detail.php`: Proses penghapusan item dari `transaksi_detail` yang otomatis memperbarui ulang kolom `total` pada tabel `transaksi`.
- `barang.php`: Pengelolaan tabel `barang` dengan informasi penggunaan di transaksi detail.
- `hapus_barang.php`: Fitur hapus barang dengan validasi pengecekan relasi: menolak penghapusan jika barang sudah digunakan di `transaksi_detail`.
- `tambah_barang.php`: Formulir penambahan data master barang baru.
- `tambah_transaksi.php`: Formulir pembuatan data master transaksi baru.

---

### Pemenuhan Tugas Praktikum (Modul 6)

1. **Pembuatan Database dan Relasi (Soal 1)**:
   - Database `penjualan` dibuat sesuai diagram ERD pada modul.
   - Relasi foreign key:
     - `barang.supplier_id` -> `supplier.id`
     - `transaksi.pelanggan_id` -> `pelanggan.id`
     - `transaksi_detail.transaksi_id` -> `transaksi.id`
     - `transaksi_detail.barang_id` -> `barang.id`
     - `pembayaran.transaksi_id` -> `transaksi.id`
   - Data master diinputkan minimal 5 data (terisi 10 data), dan transaksi minimal 10 data. Seluruhnya tersimpan di `penjualan.sql`.

2. **Halaman Master-Detail Transaksi & Validasi Dropdown Barang (Soal 2)**:
   - Halaman `index.php` menampilkan transaksi sebagai data master di bagian atas, dan detail transaksi di bagian bawah sesuai transaksi yang dipilih.
   - Pilihan barang pada dropdown diambil dari tabel `barang`.
   - Barang yang sudah ada di transaksi dinonaktifkan (`disabled`) dengan keterangan `[SUDAH DIPILIH]`, sehingga barang yang sama tidak dapat diinputkan dua kali.

3. **Fitur Hapus Barang dengan Pengecekan Data Terkait (Soal 3)**:
   - Pada `barang.php` dan `hapus_barang.php`, sebelum data barang dihapus, sistem menjalankan query `SELECT COUNT(*) FROM transaksi_detail WHERE barang_id = ?`.
   - Jika barang sudah pernah digunakan di `transaksi_detail`, sistem menolak penghapusan dan memberikan pesan notifikasi peringatan bahwa barang tersebut masih digunakan pada transaksi.
   - Jika belum dipakai, data barang dapat dihapus secara normal.

4. **Input Transaksi Detail Otomatis Update Kolom Total Transaksi (Soal 4)**:
   - Pada `tambah_detail.php`, setelah detail baru disimpan, sistem menghitung total transaksi dengan `SELECT COALESCE(SUM(harga * qty), 0) FROM transaksi_detail WHERE transaksi_id = ?`.
   - Hasil penjumlahan disimpan langsung ke kolom `total` pada tabel `transaksi` yang bersangkutan.

---

### Jawaban Tugas Pendahuluan

#### 1. Apa yang dimaksud dengan data master dan data detail, lalu berikan dua contoh nyata beserta alasan mengapa keduanya dipisahkan ke dalam tabel yang berbeda?
- **Data Master**: Entitas utama yang bersifat statis atau jarang berubah dan menjadi subjek inti dalam sistem (berdiri sendiri).
- **Data Detail**: Entitas pendukung atau rincian transaksi/kegiatan yang terkait erat dengan data master tertentu (biasanya memiliki relasi One-to-Many dari master ke detail).
- **Contoh Nyata**:
  1. *Faktur Penjualan*: Data Master adalah `transaksi` (ID faktur, tanggal, nama pelanggan), sedangkan Data Detail adalah `transaksi_detail` (daftar barang, kuantitas, harga).
  2. *Kartu Rencana Studi (KRS)*: Data Master adalah `mahasiswa` (NIM, nama, jurusan), sedangkan Data Detail adalah `krs_detail` (daftar mata kuliah yang diambil mahasiswa pada semester tertentu).
- **Alasan Pemisahan Tabel**: Mencegah redundansi data (duplikasi informasi seperti nama pelanggan/mahasiswa berulang kali), menjaga integritas dan konsistensi data (normalisasi basis data 1NF/2NF/3NF), serta memudahkan fleksibilitas jika satu master memiliki banyak detail (relasi 1:N).

#### 2. Jelaskan fungsi primary key dan foreign key dalam relasi master-detail. Pada tabel manakah foreign key diletakkan, dan mengapa?
- **Primary Key (PK)**: Pengidentifikasi unik untuk setiap baris rekaman pada tabel master maupun tabel detail, memastikan tidak ada baris ganda (integritas entitas).
- **Foreign Key (FK)**: Kunci penghubung yang merujuk pada Primary Key tabel master guna membentuk relasi logis antar tabel (integritas referensial).
- **Peletakan Foreign Key**: Foreign key **diletakkan pada tabel detail**.
- **Alasan**: Karena relasi master-detail umumnya bersifat *One-to-Many* (1 data master dapat memiliki banyak baris data detail). Meletakkan FK di tabel detail memungkinkan setiap baris detail merujuk tepat ke 1 induk transaksi master, tanpa perlu menduplikasi kolom master atau membatasi jumlah item detail.

#### 3. Jelaskan apa itu RIGHT JOIN, LEFT JOIN, dan INNER JOIN!
- **INNER JOIN**: Menggabungkan dan hanya menampilkan baris dari kedua tabel jika terdapat kecocokan (match) nilai pada kondisi relasi kunci yang ditentukan. Baris yang tidak memiliki pasangan pada salah satu tabel tidak akan ditampilkan.
- **LEFT JOIN (LEFT OUTER JOIN)**: Menampilkan **seluruh baris dari tabel sebelah kiri**, beserta baris yang cocok dari tabel sebelah kanan. Jika tidak ada baris yang cocok di tabel kanan, kolom tabel kanan akan bernilai `NULL`.
- **RIGHT JOIN (RIGHT OUTER JOIN)**: Menampilkan **seluruh baris dari tabel sebelah kanan**, beserta baris yang cocok dari tabel sebelah kiri. Jika tidak ada baris yang cocok di tabel kiri, kolom tabel kiri akan bernilai `NULL`.

#### 4. Jelaskan perbedaan opsi ON DELETE RESTRICT, ON DELETE CASCADE, dan ON DELETE SET NULL, serta berikan contoh situasi yang cocok untuk masing-masing!
- **ON DELETE RESTRICT**: Mencegah/menolak penghapusan baris pada tabel induk (master) jika masih terdapat baris turunan (detail) yang merujuk padanya.
  *Contoh*: Tabel `barang` dan `transaksi_detail`. Data barang tidak boleh dihapus jika sudah tercatat pada arsip transaksi penjualan agar pembukuan keuangan tidak rusak.
- **ON DELETE CASCADE**: Jika baris induk pada tabel master dihapus, seluruh baris turunan di tabel detail yang berelasi akan otomatis ikut terhapus.
  *Contoh*: Tabel `transaksi` dan `transaksi_detail`. Jika satu nota transaksi dibatalkan/dihapus secara permanen dari sistem, seluruh rincian item dalam transaksi tersebut harus ikut terhapus agar tidak ada data sampah (*orphan records*).
- **ON DELETE SET NULL**: Jika baris induk dihapus, nilai foreign key pada baris turunan di tabel detail akan otomatis diubah menjadi `NULL` (kolom FK harus mengizinkan NULL).
  *Contoh*: Tabel `karyawan` dan `departemen` dengan kolom `manager_id`. Jika seorang karyawan yang menjabat sebagai manajer dihapus/keluar dari perusahaan, nilai `manager_id` di tabel departemen diatur menjadi `NULL` sembari menunggu penunjukan manajer baru.

#### 5. Jelaskan apa yang dimaksud dengan tabel perantara (junction table) dan bagaimana tabel ini dipakai untuk menyelesaikan relasi many-to-many!
- **Junction Table (Bridge / Associative Table)**: Tabel khusus yang digunakan untuk memecah relasi banyak-ke-banyak (*Many-to-Many*) menjadi dua relasi satu-ke-banyak (*One-to-Many*).
- **Cara Kerja**: Basis data relasional tidak dapat mengimplementasikan relasi many-to-many secara langsung tanpa menimbulkan redundansi ekstrem. Junction table mengatasi hal ini dengan menampung minimal dua Foreign Key yang masing-masing merujuk ke Primary Key dari kedua tabel utama yang berelasi, sering kali sekaligus bertindak sebagai composite primary key.
  *Contoh*: Relasi antara `transaksi` dan `barang`. Satu transaksi dapat membeli banyak barang, dan satu barang dapat dibeli di banyak transaksi berbeda. Tabel `transaksi_detail` berfungsi sebagai junction table dengan kolom `transaksi_id` (FK ke `transaksi.id`) dan `barang_id` (FK ke `barang.id`).
