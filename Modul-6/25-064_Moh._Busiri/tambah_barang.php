<?php
require_once 'koneksi.php';

// Ambil data supplier untuk dropdown
$stmt_supp = $DBH->prepare("SELECT * FROM supplier ORDER BY nama ASC");
$stmt_supp->execute();
$suppliers = $stmt_supp->fetchAll();

$pesan_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode_barang = trim($_POST['kode_barang'] ?? '');
    $nama_barang = trim($_POST['nama_barang'] ?? '');
    $harga = (int)($_POST['harga'] ?? 0);
    $stok = (int)($_POST['stok'] ?? 0);
    $supplier_id = (int)($_POST['supplier_id'] ?? 0);

    if ($kode_barang !== '' && $nama_barang !== '' && $harga > 0 && $supplier_id > 0) {
        try {
            $insert = $DBH->prepare("
                INSERT INTO barang (kode_barang, nama_barang, harga, stok, supplier_id) 
                VALUES (?, ?, ?, ?, ?)
            ");
            $insert->execute([$kode_barang, $nama_barang, $harga, $stok, $supplier_id]);

            header("Location: barang.php?status=sukses&pesan=" . urlencode("Barang baru '{$nama_barang}' berhasil ditambahkan. Anda dapat mencoba menghapus barang ini untuk menguji fitur hapus!"));
            exit;
        } catch (PDOException $e) {
            $pesan_error = "Gagal menyimpan barang: " . $e->getMessage();
        }
    } else {
        $pesan_error = "Harap lengkapi semua isian formulir dengan benar.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Data Barang</title>
</head>
<body>

    <h1>Tambah Data Barang Baru</h1>

    <nav>
        <p>
            <a href="index.php"><strong>[ Master-Detail Transaksi ]</strong></a> | 
            <a href="barang.php"><strong>[ Kembali ke Data Barang ]</strong></a>
        </p>
    </nav>
    <hr>

    <?php if ($pesan_error !== ''): ?>
        <p><strong>PERINGATAN:</strong> <?= htmlspecialchars($pesan_error); ?></p>
        <hr>
    <?php endif; ?>

    <form method="POST" action="tambah_barang.php">
        <table border="0" cellpadding="6" cellspacing="0">
            <tr>
                <td><label for="kode_barang"><strong>Kode Barang:</strong></label></td>
                <td><input type="text" name="kode_barang" id="kode_barang" placeholder="Contoh: BRG011" required></td>
            </tr>
            <tr>
                <td><label for="nama_barang"><strong>Nama Barang:</strong></label></td>
                <td><input type="text" name="nama_barang" id="nama_barang" placeholder="Contoh: Sabun Mandi Cair" required size="40"></td>
            </tr>
            <tr>
                <td><label for="harga"><strong>Harga (Rp):</strong></label></td>
                <td><input type="number" name="harga" id="harga" min="100" placeholder="Contoh: 15000" required></td>
            </tr>
            <tr>
                <td><label for="stok"><strong>Stok:</strong></label></td>
                <td><input type="number" name="stok" id="stok" min="0" value="10" required></td>
            </tr>
            <tr>
                <td><label for="supplier_id"><strong>Supplier:</strong></label></td>
                <td>
                    <select name="supplier_id" id="supplier_id" required>
                        <option value="">-- Pilih Supplier --</option>
                        <?php foreach ($suppliers as $s): ?>
                            <option value="<?= $s['id']; ?>"><?= htmlspecialchars($s['nama']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button type="submit">Simpan Barang</button>
                    <a href="barang.php"><button type="button">Batal</button></a>
                </td>
            </tr>
        </table>
    </form>

</body>
</html>
