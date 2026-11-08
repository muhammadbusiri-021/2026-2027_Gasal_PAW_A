<?php
require_once 'koneksi.php';

$transaksi_id = isset($_GET['transaksi_id']) ? (int)$_GET['transaksi_id'] : 0;
$barang_id = isset($_GET['barang_id']) ? (int)$_GET['barang_id'] : 0;

if ($transaksi_id > 0 && $barang_id > 0) {
    try {
        // Hapus item dari tabel transaksi_detail
        $stmt_hapus = $DBH->prepare("DELETE FROM transaksi_detail WHERE transaksi_id = ? AND barang_id = ?");
        $stmt_hapus->execute([$transaksi_id, $barang_id]);

        // Hitung ulang total transaksi setelah penghapusan
        $stmt_hitung = $DBH->prepare("
            SELECT COALESCE(SUM(harga * qty), 0) AS total_transaksi 
            FROM transaksi_detail 
            WHERE transaksi_id = ?
        ");
        $stmt_hitung->execute([$transaksi_id]);
        $total_baru = (int)$stmt_hitung->fetchColumn();

        // Update total pada tabel transaksi
        $update_transaksi = $DBH->prepare("UPDATE transaksi SET total = ? WHERE id = ?");
        $update_transaksi->execute([$total_baru, $transaksi_id]);

        $pesan = "Item berhasil dihapus dari detail transaksi. Kolom total pada transaksi otomatis diperbarui menjadi Rp " . number_format($total_baru, 0, ',', '.');
        header("Location: index.php?transaksi_id=$transaksi_id&status=sukses&pesan=" . urlencode($pesan));
        exit;
    } catch (PDOException $e) {
        header("Location: index.php?transaksi_id=$transaksi_id&status=gagal&pesan=" . urlencode("Gagal menghapus detail: " . $e->getMessage()));
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
