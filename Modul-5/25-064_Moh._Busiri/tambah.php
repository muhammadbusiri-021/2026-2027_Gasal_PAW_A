<?php
require_once "koneksi.php";

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpan'])) {
    $nama   = trim($_POST['nama'] ?? '');
    $telp   = trim($_POST['telp'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');

    if (!empty($nama) && !empty($telp) && !empty($alamat)) {
        $stmt = $DBH->prepare("INSERT INTO supplier (nama, telp, alamat) VALUES (?, ?, ?)");
        $simpan = $stmt->execute([$nama, $telp, $alamat]);

        if ($simpan) {
            header("Location: index.php");
            exit;
        } else {
            $error = "Gagal menyimpan data supplier!";
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
    <title>Tambah Data Master Supplier Baru</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h2 class="title">Tambah Data Master Supplier Baru</h2>

    <?php if (!empty($error)): ?>
        <p style="color: red; margin-left: 105px;"><?= htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="tambah.php" method="POST" class="form-container">
        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" id="nama" name="nama" placeholder="Nama" required>
        </div>

        <div class="form-group">
            <label for="telp">Telp</label>
            <input type="text" id="telp" name="telp" placeholder="telp" required>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat</label>
            <input type="text" id="alamat" name="alamat" placeholder="alamat" required>
        </div>

        <div class="form-actions">
            <button type="submit" name="simpan" class="btn btn-simpan">Simpan</button>
            <a href="index.php" class="btn btn-batal">Batal</a>
        </div>
    </form>

</body>
</html>
