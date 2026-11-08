<?php
require_once 'koneksi.php';

// Ambil daftar pelanggan untuk dropdown
$stmt_pelanggan = $DBH->prepare("SELECT * FROM pelanggan ORDER BY nama ASC");
$stmt_pelanggan->execute();
$pelanggan = $stmt_pelanggan->fetchAll();

$pesan_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pelanggan_id = (int)($_POST['pelanggan_id'] ?? 0);
    $waktu_transaksi = trim($_POST['waktu_transaksi'] ?? '');
    $keterangan = trim($_POST['keterangan'] ?? '');

    if ($pelanggan_id > 0 && $waktu_transaksi !== '') {
        try {
            // Simpan data master transaksi baru dengan total awal 0
            $insert = $DBH->prepare("
                INSERT INTO transaksi (waktu_transaksi, keterangan, total, pelanggan_id) 
                VALUES (?, ?, 0, ?)
            ");
            $insert->execute([$waktu_transaksi, $keterangan, $pelanggan_id]);
            $transaksi_id_baru = $DBH->lastInsertId();

            header("Location: index.php?transaksi_id=$transaksi_id_baru&status=sukses&pesan=" . urlencode("Transaksi baru TRX-" . str_pad($transaksi_id_baru, 3, '0', STR_PAD_LEFT) . " berhasil dibuat. Silakan tambahkan item detail barang di bawah ini."));
            exit;
        } catch (PDOException $e) {
            $pesan_error = "Gagal membuat transaksi baru: " . $e->getMessage();
        }
    } else {
        $pesan_error = "Harap pilih pelanggan dan tanggal transaksi.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Transaksi Baru</title>
</head>
<body>

    <h1>Tambah Data Master Transaksi Baru</h1>

    <nav>
        <p>
            <a href="index.php"><strong>[ Master-Detail Transaksi ]</strong></a> | 
            <a href="barang.php"><strong>[ Data Barang ]</strong></a>
        </p>
    </nav>
    <hr>

    <?php if ($pesan_error !== ''): ?>
        <p><strong>PERINGATAN:</strong> <?= htmlspecialchars($pesan_error); ?></p>
        <hr>
    <?php endif; ?>

    <form method="POST" action="tambah_transaksi.php">
        <table border="0" cellpadding="6" cellspacing="0">
            <tr>
                <td><label for="pelanggan_id"><strong>Pelanggan:</strong></label></td>
                <td>
                    <select name="pelanggan_id" id="pelanggan_id" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        <?php foreach ($pelanggan as $p): ?>
                            <option value="<?= $p['id']; ?>">
                                <?= htmlspecialchars($p['nama']); ?> (<?= $p['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan'; ?>) - <?= htmlspecialchars($p['alamat']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="waktu_transaksi"><strong>Tanggal Transaksi:</strong></label></td>
                <td>
                    <input type="date" name="waktu_transaksi" id="waktu_transaksi" value="<?= date('Y-m-d'); ?>" required>
                </td>
            </tr>
            <tr>
                <td><label for="keterangan"><strong>Keterangan:</strong></label></td>
                <td>
                    <textarea name="keterangan" id="keterangan" rows="3" cols="45" placeholder="Contoh: Belanja kebutuhan kantor..."></textarea>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button type="submit">Simpan Transaksi</button>
                    <a href="index.php"><button type="button">Batal</button></a>
                </td>
            </tr>
        </table>
    </form>

</body>
</html>
