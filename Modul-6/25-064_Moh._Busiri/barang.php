<?php
require_once 'koneksi.php';

// Ambil seluruh data barang beserta nama supplier dan jumlah pemakaian di transaksi_detail
$query = "
    SELECT 
        b.*, 
        s.nama AS nama_supplier,
        (SELECT COUNT(*) FROM transaksi_detail td WHERE td.barang_id = b.id) AS jumlah_terpakai
    FROM barang b
    LEFT JOIN supplier s ON b.supplier_id = s.id
    ORDER BY b.id ASC
";
$stmt = $DBH->prepare($query);
$stmt->execute();
$daftar_barang = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Data Barang</title>
</head>
<body>

    <h1>Pengelolaan Data Barang</h1>

    <!-- Navigasi Halaman -->
    <nav>
        <p>
            <a href="index.php"><strong>[ Master-Detail Transaksi ]</strong></a> | 
            <a href="barang.php"><strong>[ Data Barang ]</strong></a> | 
            <a href="tambah_barang.php"><strong>[ Tambah Barang Baru ]</strong></a> | 
            <a href="tambah_transaksi.php"><strong>[ Tambah Transaksi Baru ]</strong></a>
        </p>
    </nav>
    <hr>

    <!-- Notifikasi Pesan -->
    <?php if (isset($_GET['pesan'])): ?>
        <?php if (isset($_GET['status']) && $_GET['status'] === 'sukses'): ?>
            <p><strong>SUKSES:</strong> <?= htmlspecialchars($_GET['pesan']); ?></p>
        <?php else: ?>
            <p><strong>PERINGATAN:</strong> <?= htmlspecialchars($_GET['pesan']); ?></p>
        <?php endif; ?>
        <hr>
    <?php endif; ?>

    <h2>Daftar Tabel Barang</h2>
    <p>
        Halaman ini dilengkapi dengan validasi pengecekan relasi: 
        <strong>Barang yang sudah pernah digunakan pada detail transaksi TIDAK BISA dihapus</strong>, 
        sedangkan barang yang belum pernah digunakan boleh dihapus seperti biasa.
    </p>

    <p>
        <a href="tambah_barang.php"><button type="button">+ Tambah Barang Baru</button></a>
    </p>

    <table border="1" cellpadding="6" cellspacing="0" width="100%">
        <thead>
            <tr bgcolor="#eeeeee">
                <th>No</th>
                <th>ID</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Harga (Rp)</th>
                <th>Stok</th>
                <th>Supplier</th>
                <th>Status Penggunaan di Transaksi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($daftar_barang)): ?>
                <?php $no = 1; ?>
                <?php foreach ($daftar_barang as $row): ?>
                    <tr>
                        <td align="center"><?= $no++; ?></td>
                        <td align="center"><?= $row['id']; ?></td>
                        <td align="center"><?= htmlspecialchars($row['kode_barang']); ?></td>
                        <td><?= htmlspecialchars($row['nama_barang']); ?></td>
                        <td align="right">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                        <td align="center"><?= $row['stok']; ?></td>
                        <td><?= htmlspecialchars($row['nama_supplier'] ?? '-'); ?></td>
                        <td align="center">
                            <?php if ($row['jumlah_terpakai'] > 0): ?>
                                <span>Sudah dipakai (<?= $row['jumlah_terpakai']; ?> kali transaksi)</span>
                            <?php else: ?>
                                <span>Belum pernah dipakai</span>
                            <?php endif; ?>
                        </td>
                        <td align="center">
                            <a href="hapus_barang.php?id=<?= $row['id']; ?>" 
                               onclick="return confirm('Apakah Anda yakin ingin menghapus barang <?= htmlspecialchars($row['nama_barang']); ?>?');">
                                Hapus
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" align="center">Belum ada data barang.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>
