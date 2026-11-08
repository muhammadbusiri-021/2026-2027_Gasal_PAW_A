<?php
require_once 'koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    try {
        // 1. Ambil data barang terlebih dahulu
        $stmt_barang = $DBH->prepare("SELECT * FROM barang WHERE id = ?");
        $stmt_barang->execute([$id]);
        $barang = $stmt_barang->fetch();

        if (!$barang) {
            header("Location: barang.php?status=gagal&pesan=" . urlencode("Data barang tidak ditemukan."));
            exit;
        }

        $nama_barang = $barang['nama_barang'];

        // 2. Pengecekan data terkait: apakah barang sudah dipakai pada tabel transaksi_detail
        $stmt_cek = $DBH->prepare("SELECT COUNT(*) AS total FROM transaksi_detail WHERE barang_id = ?");
        $stmt_cek->execute([$id]);
        $jumlah_pakai = (int)$stmt_cek->fetchColumn();

        if ($jumlah_pakai > 0) {
            // Jika barang sudah dipakai, data TIDAK BOLEH dihapus dan sistem menampilkan notifikasi
            $pesan = "Data barang '{$nama_barang}' TIDAK DAPAT dihapus karena masih digunakan pada {$jumlah_pakai} data transaksi detail!";
            header("Location: barang.php?status=gagal&pesan=" . urlencode($pesan));
            exit;
        } else {
            // Jika belum dipakai, data barang boleh dihapus seperti biasa
            $stmt_hapus = $DBH->prepare("DELETE FROM barang WHERE id = ?");
            $stmt_hapus->execute([$id]);

            $pesan = "Data barang '{$nama_barang}' berhasil dihapus dari sistem.";
            header("Location: barang.php?status=sukses&pesan=" . urlencode($pesan));
            exit;
        }

    } catch (PDOException $e) {
        header("Location: barang.php?status=gagal&pesan=" . urlencode("Gagal memproses penghapusan: " . $e->getMessage()));
        exit;
    }
} else {
    header("Location: barang.php");
    exit;
}
