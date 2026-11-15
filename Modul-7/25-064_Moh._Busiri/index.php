<?php

require_once __DIR__ . "/conn.php";
require_once __DIR__ . "/utils.php";
require_once __DIR__ . "/services/reports/reports.query.php";

$mulai = parseDate($_GET["mulai"] ?? "");
$selesai = parseDate($_GET["selesai"] ?? "");
$rows = [];
$summary = ["total_transaksi" => 0, "jumlah_pelanggan" => 0, "total_pendapatan" => 0];

if ($mulai && $selesai) {
  if ($mulai > $selesai) {
    [$mulai, $selesai] = [$selesai, $mulai];
  }
  [$rows, $summary] = getSalesReport($conn, $mulai, $selesai);
}

// Menyiapkan data label tanggal dan nominal total harian untuk Chart.js
$labels = array_column($rows, "tgl");
$data_total = array_map("intval", array_column($rows, "total_harian"));

?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Penjualan dan Grafik</title>
  <!-- Chart.js CDN -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
      color: #333;
    }

    h1, h2, h3 {
      color: #2c3e50;
    }

    .form-container {
      background: #f8f9fa;
      padding: 16px;
      border: 1px solid #dee2e6;
      border-radius: 6px;
      margin-bottom: 24px;
    }

    .form-container label {
      font-weight: bold;
      margin-right: 8px;
    }

    .form-container input[type="date"] {
      padding: 6px 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      margin-right: 15px;
    }

    button, .btn {
      display: inline-block;
      padding: 8px 16px;
      font-size: 14px;
      font-weight: bold;
      border-radius: 4px;
      cursor: pointer;
      text-decoration: none;
      border: 1px solid transparent;
      margin-right: 8px;
    }

    .btn-submit {
      background-color: #0d6efd;
      color: #fff;
    }

    .btn-submit:hover {
      background-color: #0b5ed7;
    }

    .btn-print {
      background-color: #e67e22;
      color: #fff;
    }

    .btn-print:hover {
      background-color: #d35400;
    }

    .btn-excel {
      background-color: #198754;
      color: #fff;
    }

    .btn-excel:hover {
      background-color: #157347;
    }

    .alert {
      padding: 12px 16px;
      border-radius: 4px;
      margin-bottom: 20px;
    }

    .alert-info {
      background-color: #cff4fc;
      border: 1px solid #b6effb;
      color: #055160;
    }

    .alert-warning {
      background-color: #fff3cd;
      border: 1px solid #ffecb5;
      color: #664d03;
    }

    .chart-container {
      max-width: 750px;
      margin: 20px auto 40px auto;
    }

    table.data-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
      margin-bottom: 25px;
    }

    table.data-table th, table.data-table td {
      border: 1px solid #dee2e6;
      padding: 10px 12px;
      text-align: left;
    }

    table.data-table thead {
      background-color: #d0e8f2;
    }

    table.data-table tbody tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    /* Card Ringkasan Total Kumulatif */
    .summary-card-table {
      width: 400px;
      border-collapse: collapse;
      margin-top: 10px;
    }

    .summary-card-table th {
      background-color: #cfe2ff;
      border: 1px solid #b6d4fe;
      padding: 10px;
      font-size: 13px;
      text-align: center;
    }

    .summary-card-table td {
      border: 1px solid #b6d4fe;
      padding: 12px;
      font-size: 18px;
      font-weight: bold;
      text-align: center;
      background-color: #f8faff;
      color: #0d6efd;
    }

    /* CSS Aturan Khusus Cetak (@media print) */
    @media print {
      .no-print {
        display: none !important;
      }
      body {
        margin: 0;
        padding: 10px;
        color: #000;
      }
      table.data-table th, table.data-table td {
        border: 1px solid #000 !important;
      }
      .summary-card-table th, .summary-card-table td {
        border: 1px solid #000 !important;
        color: #000 !important;
      }
      .chart-container {
        max-width: 100% !important;
        page-break-inside: avoid;
      }
    }
  </style>
</head>

<body>

  <header>
    <h1>Rekap Laporan Penjualan</h1>
    <?php if ($mulai && $selesai): ?>
      <p><strong>Periode:</strong> <?= sanitazion($mulai) ?> sampai <?= sanitazion($selesai) ?></p>
    <?php endif ?>
  </header>

  <!-- FORM FILTER RENTANG TANGGAL & TOMBOL AKSI (disembunyikan saat cetak) -->
  <div class="no-print form-container">
    <h3>Filter Laporan Penjualan</h3>
    <form method="GET" action="index.php" style="display: inline-block;">
      <label for="mulai">Dari:</label>
      <input type="date" id="mulai" name="mulai" value="<?= sanitazion($mulai ?? '') ?>" required>

      <label for="selesai">Sampai:</label>
      <input type="date" id="selesai" name="selesai" value="<?= sanitazion($selesai ?? '') ?>" required>

      <button type="submit" class="btn btn-submit">Tampilkan</button>
    </form>

    <?php if (!empty($rows)): ?>
      <button type="button" class="btn btn-print" id="btnPrint">Cetak</button>
      <a href="export_excel.php?mulai=<?= urlencode($mulai) ?>&selesai=<?= urlencode($selesai) ?>" class="btn btn-excel">Excel</a>
    <?php endif ?>
  </div>

  <!-- KONDISI STATUS DATA -->
  <?php if (!$mulai || !$selesai): ?>
    <div class="alert alert-info">
      Silakan tentukan rentang tanggal penjualan di atas lalu klik tombol <strong>Tampilkan</strong> untuk memuat grafik dan rekapitulasi data.
    </div>
  <?php elseif (empty($rows)): ?>
    <div class="alert alert-warning">
      Tidak ada data transaksi penjualan pada rentang tanggal <strong><?= sanitazion($mulai) ?></strong> sampai <strong><?= sanitazion($selesai) ?></strong>.
    </div>
  <?php else: ?>

    <!-- VISUALISASI GRAFIK BATANG (CHART.JS) -->
    <h2>Grafik Penjualan Harian</h2>
    <div class="chart-container">
      <canvas id="chartPenjualan"></canvas>
    </div>

    <!-- TABEL REKAPITULASI PENJUALAN HARIAN -->
    <h2>Rekapitulasi</h2>
    <table class="data-table">
      <thead>
        <tr>
          <th style="width: 60px; text-align: center;">No</th>
          <th>Total</th>
          <th>Tanggal</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $i => $row): ?>
          <tr>
            <td style="text-align: center;"><?= $i + 1 ?></td>
            <td>Rp. <?= number_format($row["total_harian"], 0, ',', '.') ?></td>
            <td><?= date("d M Y", strtotime($row["tgl"])) ?></td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>

    <!-- CARD RINGKASAN TOTAL KUMULATIF -->
    <h3>Ringkasan Total</h3>
    <table class="summary-card-table">
      <thead>
        <tr>
          <th>Jumlah Pelanggan</th>
          <th>Jumlah Pendapatan</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?= sanitazion($summary["jumlah_pelanggan"] ?? 0) ?> Orang</td>
          <td>Rp. <?= number_format($summary["total_pendapatan"] ?? 0, 0, ',', '.') ?></td>
        </tr>
      </tbody>
    </table>

    <!-- INISIALISASI CHART.JS DAN EVENT CETAK -->
    <script>
      const ctx = document.getElementById('chartPenjualan').getContext('2d');
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: <?= json_encode($labels) ?>,
          datasets: [{
            label: 'Total Penjualan',
            data: <?= json_encode($data_total) ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.5)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                callback: function(value) {
                  return 'Rp ' + value.toLocaleString('id-ID');
                }
              }
            }
          }
        }
      });

      // Pemicu cetak browser
      document.getElementById('btnPrint').addEventListener('click', function() {
        window.print();
      });
    </script>

  <?php endif ?>

</body>

</html>
