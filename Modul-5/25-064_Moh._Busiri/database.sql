-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 01 Nov 2026 pada 10.06
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id`, `kode_barang`, `nama_barang`, `harga`, `stok`, `supplier_id`) VALUES
(1, 'BRG001', 'Beras Ramos 5kg', 65000, 50, 1),
(2, 'BRG002', 'Minyak Goreng 2L', 35000, 80, 1),
(3, 'BRG003', 'Gula Pasir 1kg', 16000, 100, 2),
(4, 'BRG004', 'Tepung Terigu 1kg', 12000, 60, 2),
(5, 'BRG005', 'Telur Ayam 1kg', 28000, 45, 3),
(6, 'BRG006', 'Kopi Bubuk 250g', 15000, 75, 4),
(7, 'BRG007', 'Susu UHT 1L', 18000, 90, 5),
(8, 'BRG008', 'Mi Instan Goreng Dus', 115000, 30, 6),
(9, 'BRG009', 'Kecap Manis 600ml', 20000, 55, 7),
(10, 'BRG010', 'Sabun Cuci Piring 800ml', 14000, 70, 8);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `telp` varchar(12) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `nama`, `jenis_kelamin`, `telp`, `alamat`) VALUES
(1, 'Ahmad Fauzi', 'L', '081234567890', 'Jl. Pemuda No. 10, Surabaya'),
(2, 'Siti Nurhaliza', 'P', '081234567891', 'Jl. Basuki Rahmat No. 45, Surabaya'),
(3, 'Budi Santoso', 'L', '081345678901', 'Jl. Soekarno Hatta No. 12, Malang'),
(4, 'Dewi Lestari', 'P', '081345678902', 'Jl. Diponegoro No. 8, Sidoarjo'),
(5, 'Eko Prasetyo', 'L', '081456789012', 'Jl. Panglima Sudirman No. 15, Gresik'),
(6, 'Rina Wijaya', 'P', '081456789013', 'Jl. Trunojoyo No. 20, Bangkalan'),
(7, 'Hendra Saputra', 'L', '081567890123', 'Jl. Pahlawan No. 33, Mojokerto'),
(8, 'Maya Anggraini', 'P', '081567890124', 'Jl. Gajah Mada No. 7, Surabaya'),
(9, 'Rizky Pratama', 'L', '081678901234', 'Jl. Hayam Wuruk No. 14, Jombang'),
(10, 'Putri Ayu', 'P', '081678901235', 'Jl. Veteran No. 25, Malang');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `waktu_bayar` datetime NOT NULL,
  `total` int(11) NOT NULL,
  `metode` enum('TUNAI','TRANSFER','EDC') NOT NULL,
  `transaksi_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `waktu_bayar`, `total`, `metode`, `transaksi_id`) VALUES
(1, '2026-10-01 10:15:00', 135000, 'TUNAI', 1),
(2, '2026-10-02 11:30:00', 131000, 'TRANSFER', 2),
(3, '2026-10-03 14:05:00', 64000, 'TUNAI', 3),
(4, '2026-10-04 16:20:00', 66000, 'EDC', 4),
(5, '2026-10-05 09:45:00', 345000, 'TRANSFER', 5),
(6, '2026-10-06 13:10:00', 105000, 'TUNAI', 6),
(7, '2026-10-07 15:50:00', 260000, 'EDC', 7),
(8, '2026-10-08 17:35:00', 69000, 'TUNAI', 8),
(9, '2026-10-09 12:00:00', 143000, 'TRANSFER', 9),
(10, '2026-10-10 18:40:00', 117000, 'EDC', 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `telp` varchar(12) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`id`, `nama`, `telp`, `alamat`) VALUES
(1, 'PT. Maju Bersama', '08123456', 'Surabaya'),
(2, 'PT. Senang Sekali', '081515563', 'Bangkalan'),
(3, 'PT. Segar Segar', '0845454663', 'Surabaya'),
(4, 'CV. Sumber Makmur', '0812987654', 'Sidoarjo'),
(5, 'PT. Bintang Kejora', '0857123456', 'Malang'),
(6, 'CV. Jaya Abadi', '0878112233', 'Gresik'),
(7, 'PT. Berkah Mandiri', '0821556677', 'Mojokerto'),
(8, 'CV. Mitra Sejati', '0838998877', 'Pasuruan'),
(9, 'PT. Sentosa Raya', '0896334455', 'Surabaya'),
(11, 'MOH. BUSIRI', '11111', 'Bangkalan madura');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `waktu_transaksi` date NOT NULL,
  `keterangan` text DEFAULT NULL,
  `total` int(11) NOT NULL,
  `pelanggan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id`, `waktu_transaksi`, `keterangan`, `total`, `pelanggan_id`) VALUES
(1, '2026-10-01', 'Belanja sembako bulanan', 135000, 1),
(2, '2026-10-02', 'Belanja kebutuhan dapur', 131000, 2),
(3, '2026-10-03', 'Pembelian bahan kue', 64000, 3),
(4, '2026-10-04', 'Belanja mingguan', 66000, 4),
(5, '2026-10-05', 'Pembelian partai kecil', 345000, 5),
(6, '2026-10-06', 'Kebutuhan warung makan', 105000, 6),
(7, '2026-10-07', 'Belanja konsumsi kantor', 260000, 7),
(8, '2026-10-08', 'Belanja perlengkapan rumah', 69000, 8),
(9, '2026-10-09', 'Pembelian telur dan mie', 143000, 9),
(10, '2026-10-10', 'Belanja sembako hemat', 117000, 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `transaksi_id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi_detail`
--

INSERT INTO `transaksi_detail` (`transaksi_id`, `barang_id`, `harga`, `qty`) VALUES
(1, 1, 65000, 1),
(1, 2, 35000, 2),
(2, 3, 16000, 1),
(2, 8, 115000, 1),
(3, 4, 12000, 3),
(3, 5, 28000, 1),
(4, 6, 15000, 2),
(4, 7, 18000, 2),
(5, 8, 115000, 3),
(6, 2, 35000, 3),
(7, 1, 65000, 4),
(8, 2, 35000, 1),
(8, 10, 14000, 1),
(9, 5, 28000, 1),
(9, 8, 115000, 1),
(10, 1, 65000, 1),
(10, 3, 16000, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` tinyint(2) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(35) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(150) NOT NULL,
  `hp` varchar(20) NOT NULL,
  `level` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama`, `alamat`, `hp`, `level`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'Administrator Utama', 'Jl. Kusuma Bangsa No. 1, Surabaya', '081211112222', 1),
(2, 'kasir1', 'de28f8f7998f23ab4194b51a6029416f', 'Siti Kasir Pagi', 'Jl. Manyar Rejo No. 5, Surabaya', '081233334444', 2),
(3, 'kasir2', 'de28f8f7998f23ab4194b51a6029416f', 'Joko Kasir Sore', 'Jl. Ngagel Timur No. 12, Surabaya', '081255556666', 2),
(4, 'gudang1', 'cbb7449d78314665f9e7c7dd0a18a68a', 'Bambang Staff Gudang', 'Jl. Rungkut Asri No. 8, Surabaya', '081277778888', 3),
(5, 'manager', '0795151defba7a4b5dfa89170de46277', 'Arief Manager Toko', 'Jl. Dharmahusada No. 19, Surabaya', '081299990000', 1),
(6, 'kasir3', 'de28f8f7998f23ab4194b51a6029416f', 'Dian Kasir Weekend', 'Jl. Kenjeran No. 44, Surabaya', '081311223344', 2),
(7, 'spv1', '6ade4163a398335a0a2abced430cf869', 'Farhan Supervisor', 'Jl. Kertajaya No. 88, Surabaya', '081355667788', 1),
(8, 'gudang2', 'cbb7449d78314665f9e7c7dd0a18a68a', 'Danang Staff Gudang', 'Jl. Wonokromo No. 2, Surabaya', '081399001122', 3),
(9, 'kasir4', 'de28f8f7998f23ab4194b51a6029416f', 'Lestari Kasir Pengganti', 'Jl. Jemursari No. 15, Surabaya', '081422334455', 2),
(10, 'akuntan', '42ef74c0d316f77b314a1f838cdd26f2', 'Mega Staff Keuangan', 'Jl. Baratajaya No. 30, Surabaya', '081466778899', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_barang_supplier` (`supplier_id`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pembayaran_transaksi` (`transaksi_id`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_transaksi_pelanggan` (`pelanggan_id`);

--
-- Indeks untuk tabel `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD PRIMARY KEY (`transaksi_id`,`barang_id`),
  ADD KEY `fk_detail_barang` (`barang_id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` tinyint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `fk_barang_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `fk_pembayaran_transaksi` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `fk_transaksi_pelanggan` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD CONSTRAINT `fk_detail_barang` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detail_transaksi` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
