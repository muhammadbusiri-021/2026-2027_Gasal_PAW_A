<?php

require_once __DIR__ . "/conn.php";
require_once __DIR__ . "/utils.php";
require_once __DIR__ . "/services/reports/reports.query.php";

$mulai = parseDate($_GET["mulai"] ?? "");
$selesai = parseDate($_GET["selesai"] ?? "");

if (!$mulai || !$selesai) {
  header("Location: index.php");
  exit();
}

if ($mulai > $selesai) {
  [$mulai, $selesai] = [$selesai, $mulai];
}

[$rows, $summary] = getSalesReport($conn, $mulai, $selesai);

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=laporan_penjualan_{$mulai}_sampai_{$selesai}.xls");
header("Pragma: no-cache");
header("Expires: 0");

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Laporan Penjualan</title>
</head>
<body>
  <h3>Rekap Laporan Penjualan</h3>
  <p>Periode: <?= $mulai ?> sampai <?= $selesai ?></p>
  
  <table border="1" cellpadding="6" cellspacing="0">
    <thead>
      <tr bgcolor="#eeeeee">
        <th>No</th>
        <th>Total Pendapatan</th>
        <th>Tanggal Transaksi</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($rows)): ?>
        <?php foreach ($rows as $i => $row): ?>
          <tr>
            <td align="center"><?= $i + 1 ?></td>
            <td align="right">Rp. <?= number_format($row["total_harian"], 0, ',', '.') ?></td>
            <td align="center"><?= date("d M Y", strtotime($row["tgl"])) ?></td>
          </tr>
        <?php endforeach ?>
      <?php else: ?>
        <tr>
          <td colspan="3" align="center">Tidak ada transaksi pada periode ini.</td>
        </tr>
      <?php endif ?>
    </tbody>
  </table>

  <br>

  <table border="1" cellpadding="6" cellspacing="0">
    <thead>
      <tr bgcolor="#f0f8ff">
        <th>Jumlah Pelanggan</th>
        <th>Jumlah Pendapatan</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td align="center"><b><?= $summary["jumlah_pelanggan"] ?? 0 ?> Orang</b></td>
        <td align="center"><b>Rp. <?= number_format($summary["total_pendapatan"] ?? 0, 0, ',', '.') ?></b></td>
      </tr>
    </tbody>
  </table>
</body>
</html>
