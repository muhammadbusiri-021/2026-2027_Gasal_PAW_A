<?php

require_once __DIR__ . "/../../utils.php";

/**
 * Mengambil rekapitulasi data penjualan harian dan ringkasan kumulatif
 * berdasarkan rentang tanggal (mulai sampai selesai)
 */
function getSalesReport($conn, $mulai, $selesai)
{
  $rekapSQL = <<<SQL
    SELECT
      DATE(waktu_transaksi) AS tgl,
      SUM(total) AS total_harian,
      COUNT(*) AS jumlah_transaksi
    FROM transaksi
    WHERE waktu_transaksi BETWEEN ? AND ?
    GROUP BY DATE(waktu_transaksi)
    ORDER BY tgl ASC;
  SQL;

  $summarySQL = <<<SQL
    SELECT
      COUNT(DISTINCT pelanggan_id) AS jumlah_pelanggan,
      COALESCE(SUM(total), 0) AS total_pendapatan,
      COUNT(*) AS total_transaksi
    FROM transaksi
    WHERE waktu_transaksi BETWEEN ? AND ?;
  SQL;

  $rekap = $conn->prepare($rekapSQL);
  $rekap->execute([$mulai, $selesai]);

  $summary = $conn->prepare($summarySQL);
  $summary->execute([$mulai, $selesai]);

  return [$rekap->fetchAll(), $summary->fetch()];
}
