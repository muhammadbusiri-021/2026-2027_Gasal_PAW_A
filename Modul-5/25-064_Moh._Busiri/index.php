<?php
require_once "koneksi.php";

$stmt = $DBH->prepare("SELECT * FROM supplier ORDER BY id ASC");
$stmt->execute();
$suppliers = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Master Supplier</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="header-wrapper">
        <h2 class="title">Data Master Supplier</h2>
        <a href="tambah.php" class="btn btn-tambah">Tambah Data</a>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 50px;">No</th>
                <th>Nama</th>
                <th style="width: 160px;">Telp</th>
                <th>Alamat</th>
                <th style="width: 140px;">Tindakan</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($suppliers)): ?>
                <?php $no = 1; ?>
                <?php foreach ($suppliers as $row): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($row['nama']); ?></td>
                        <td><?= htmlspecialchars($row['telp']); ?></td>
                        <td><?= htmlspecialchars($row['alamat']); ?></td>
                        <td>
                            <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-edit">Edit</a>
                            <a href="hapus.php?id=<?= $row['id']; ?>" class="btn btn-hapus" onclick="return confirm('Anda yakin akan menghapus supplier ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center;">Belum ada data supplier.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>
