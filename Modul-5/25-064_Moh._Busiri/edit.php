<?php
require_once "koneksi.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int)$_GET['id'];
$error = "";

$stmt = $DBH->prepare("SELECT * FROM supplier WHERE id = ?");
$stmt->execute([$id]);
$data = $stmt->fetch();

if (!$data) {
    header("Location: index.php");
    exit;
}

// Proses submit form update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $nama   = trim($_POST['nama'] ?? '');
    $telp   = trim($_POST['telp'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');

    if (!empty($nama) && !empty($telp) && !empty($alamat)) {
        $update_stmt = $DBH->prepare("UPDATE supplier SET nama = ?, telp = ?, alamat = ? WHERE id = ?");
        $berhasil = $update_stmt->execute([$nama, $telp, $alamat, $id]);

        if ($berhasil) {
            header("Location: index.php");
            exit;
        } else {
            $error = "Gagal memperbarui data supplier!";
        }
    } else {
        $error = "Semua field wajib diisi!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Master Supplier</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h2 class="title">Edit Data Master Supplier</h2>

    <?php if (!empty($error)): ?>
        <p style="color: red; margin-left: 105px;"><?= htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="edit.php?id=<?= $id; ?>" method="POST" class="form-container">
        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($data['nama']); ?>" required>
        </div>

        <div class="form-group">
            <label for="telp">Telp</label>
            <input type="text" id="telp" name="telp" value="<?= htmlspecialchars($data['telp']); ?>" required>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat</label>
            <input type="text" id="alamat" name="alamat" value="<?= htmlspecialchars($data['alamat']); ?>" required>
        </div>

        <div class="form-actions">
            <button type="submit" name="update" class="btn btn-update">Update</button>
            <a href="index.php" class="btn btn-batal">Batal</a>
        </div>
    </form>

</body>
</html>
