<?php
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transaksi_id = isset($_POST['transaksi_id']) ? (int)$_POST['transaksi_id'] : 0;
    $barang_id = isset($_POST['barang_id']) ? (int)$_POST['barang_id'] : 0;
    $qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 0;

    if ($transaksi_id <= 0 || $barang_id <= 0 || $qty <= 0) {
        header("Location: index.php?transaksi_id=$transaksi_id&status=gagal&pesan=" . urlencode("Input tidak valid! Pastikan barang dipilih dan jumlah (qty) minimal 1."));
        exit;
    }

    try {
        // 1. Ambil harga dan nama barang dari tabel barang
        $stmt_barang = $DBH->prepare("SELECT nama_barang, harga FROM barang WHERE id = ?");
        $stmt_barang->execute([$barang_id]);
        $barang = $stmt_barang->fetch();

        if (!$barang) {
            header("Location: index.php?transaksi_id=$transaksi_id&status=gagal&pesan=" . urlencode("Data barang tidak ditemukan."));
            exit;
        }

        $harga = (int)$barang['harga'];
        $nama_barang = $barang['nama_barang'];

        // 2. Pengecekan agar barang yang sama tidak bisa diinput dua kali dalam satu transaksi
        $cek_duplikat = $DBH->prepare("SELECT COUNT(*) FROM transaksi_detail WHERE transaksi_id = ? AND barang_id = ?");
        $cek_duplikat->execute([$transaksi_id, $barang_id]);
        if ($cek_duplikat->fetchColumn() > 0) {
            header("Location: index.php?transaksi_id=$transaksi_id&status=gagal&pesan=" . urlencode("Barang '{$nama_barang}' sudah pernah dimasukkan ke transaksi ini!"));
            exit;
        }

        // 3. Simpan data ke tabel transaksi_detail
        $insert = $DBH->prepare("
            INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) 
            VALUES (?, ?, ?, ?)
        ");
        $insert->execute([$transaksi_id, $barang_id, $harga, $qty]);

        // 4. Hitung ulang total transaksi: menjumlahkan hasil perkalian harga dan qty dari seluruh detail milik transaksi yang sama
        $stmt_hitung = $DBH->prepare("
            SELECT COALESCE(SUM(harga * qty), 0) AS total_transaksi 
            FROM transaksi_detail 
            WHERE transaksi_id = ?
        ");
        $stmt_hitung->execute([$transaksi_id]);
        $total_baru = (int)$stmt_hitung->fetchColumn();

        // 5. Simpan hasilnya ke kolom total pada tabel transaksi yang bersangkutan
        $update_transaksi = $DBH->prepare("UPDATE transaksi SET total = ? WHERE id = ?");
        $update_transaksi->execute([$total_baru, $transaksi_id]);

        $pesan = "Berhasil menambahkan '{$nama_barang}' ke detail transaksi. Kolom total pada transaksi otomatis diperbarui menjadi Rp " . number_format($total_baru, 0, ',', '.');
        header("Location: index.php?transaksi_id=$transaksi_id&status=sukses&pesan=" . urlencode($pesan));
        exit;

    } catch (PDOException $e) {
        header("Location: index.php?transaksi_id=$transaksi_id&status=gagal&pesan=" . urlencode("Terjadi kesalahan database: " . $e->getMessage()));
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
