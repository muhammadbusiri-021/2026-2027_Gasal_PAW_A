<?php
require_once "koneksi.php";

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Hapus data supplier menggunakan PDO Prepared Statement
    $stmt = $DBH->prepare("DELETE FROM supplier WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: index.php");
exit;
