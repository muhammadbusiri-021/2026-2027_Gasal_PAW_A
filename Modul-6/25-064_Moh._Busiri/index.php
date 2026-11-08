<?php
require_once 'koneksi.php';

// Ambil daftar seluruh transaksi untuk tabel Master
$stmt_transaksi = $DBH->prepare("
    SELECT t.*, p.nama AS nama_pelanggan 
    FROM transaksi t 
    JOIN pelanggan p ON t.pelanggan_id = p.id 
    ORDER BY t.id ASC
");
$stmt_transaksi->execute();
$daftar_transaksi = $stmt_transaksi->fetchAll();

// Tentukan transaksi yang sedang aktif/dipilih
$transaksi_id = isset($_GET['transaksi_id']) ? (int)$_GET['transaksi_id'] : 0;
if ($transaksi_id <= 0 && !empty($daftar_transaksi)) {
    $transaksi_id = (int)$daftar_transaksi[0]['id'];
}

// Ambil data master transaksi terpilih
$transaksi_terpilih = null;
$detail_transaksi = [];
$barang_sudah_dipakai = [];

if ($transaksi_id > 0) {
    $stmt_master = $DBH->prepare("
        SELECT t.*, p.nama AS nama_pelanggan, p.telp AS telp_pelanggan, p.alamat AS alamat_pelanggan 
        FROM transaksi t 
        JOIN pelanggan p ON t.pelanggan_id = p.id 
        WHERE t.id = ?
    ");
    $stmt_master->execute([$transaksi_id]);
    $transaksi_terpilih = $stmt_master->fetch();

    // Ambil data detail transaksi terpilih
    $stmt_detail = $DBH->prepare("
        SELECT td.*, b.kode_barang, b.nama_barang 
        FROM transaksi_detail td 
        JOIN barang b ON td.barang_id = b.id 
        WHERE td.transaksi_id = ?
        ORDER BY td.barang_id ASC
    ");
    $stmt_detail->execute([$transaksi_id]);
    $detail_transaksi = $stmt_detail->fetchAll();

    // Ambil list barang_id yang sudah ada di detail transaksi ini
    foreach ($detail_transaksi as $dt) {
        $barang_sudah_dipakai[] = (int)$dt['barang_id'];
    }
}

// Ambil semua daftar barang untuk dropdown select option
$stmt_all_barang = $DBH->prepare("SELECT * FROM barang ORDER BY nama_barang ASC");
$stmt_all_barang->execute();
$semua_barang = $stmt_all_barang->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Master Detail Data Transaksi</title>
</head>
<body>

    <h1>Pengelolaan Master-Detail Data Penjualan</h1>

    <!-- Navigasi Halaman -->
    <nav>
        <p>
            <a href="index.php"><strong>[ Master-Detail Transaksi ]</strong></a> | 
            <a href="barang.php"><strong>[ Data Barang ]</strong></a> | 
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

    <!-- BAGIAN 1: DATA MASTER (TABEL TRANSAKSI) -->
    <h2>1. Data Master: Tabel Transaksi</h2>
    <p>Silakan klik tombol <em>"Pilih / Lihat Detail"</em> pada baris transaksi yang ingin dikelola detailnya.</p>

    <table border="1" cellpadding="6" cellspacing="0" width="100%">
        <thead>
            <tr bgcolor="#eeeeee">
                <th>No</th>
                <th>ID Transaksi</th>
                <th>Waktu Transaksi</th>
                <th>Nama Pelanggan</th>
                <th>Keterangan</th>
                <th>Total (Rp)</th>
                <th>Status Pilihan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($daftar_transaksi)): ?>
                <?php $no = 1; ?>
                <?php foreach ($daftar_transaksi as $t): ?>
                    <?php $is_selected = ($t['id'] == $transaksi_id); ?>
                    <tr <?= $is_selected ? 'bgcolor="#ffffcc"' : ''; ?>>
                        <td align="center"><?= $no++; ?></td>
                        <td align="center">TRX-<?= str_pad($t['id'], 3, '0', STR_PAD_LEFT); ?></td>
                        <td align="center"><?= htmlspecialchars($t['waktu_transaksi']); ?></td>
                        <td><?= htmlspecialchars($t['nama_pelanggan']); ?></td>
                        <td><?= htmlspecialchars($t['keterangan'] ?? '-'); ?></td>
                        <td align="right">Rp <?= number_format($t['total'], 0, ',', '.'); ?></td>
                        <td align="center">
                            <?= $is_selected ? '<strong>Aktif Dipilih</strong>' : '-'; ?>
                        </td>
                        <td align="center">
                            <?php if ($is_selected): ?>
                                <span>(Sedang Aktif)</span>
                            <?php else: ?>
                                <a href="index.php?transaksi_id=<?= $t['id']; ?>">Pilih / Lihat Detail</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" align="center">Belum ada data transaksi.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <br>
    <hr>

    <!-- BAGIAN 2: DATA DETAIL (TABEL TRANSAKSI DETAIL) -->
    <?php if ($transaksi_terpilih): ?>
        <h2>2. Data Detail: Tabel Transaksi Detail (Transaksi ID: TRX-<?= str_pad($transaksi_terpilih['id'], 3, '0', STR_PAD_LEFT); ?>)</h2>

        <!-- Ringkasan Master -->
        <table border="0" cellpadding="4" cellspacing="0">
            <tr>
                <td><strong>ID Transaksi</strong></td>
                <td>: TRX-<?= str_pad($transaksi_terpilih['id'], 3, '0', STR_PAD_LEFT); ?></td>
            </tr>
            <tr>
                <td><strong>Tanggal Transaksi</strong></td>
                <td>: <?= htmlspecialchars($transaksi_terpilih['waktu_transaksi']); ?></td>
            </tr>
            <tr>
                <td><strong>Nama Pelanggan</strong></td>
                <td>: <?= htmlspecialchars($transaksi_terpilih['nama_pelanggan']); ?> (Telp: <?= htmlspecialchars($transaksi_terpilih['telp_pelanggan']); ?>)</td>
            </tr>
            <tr>
                <td><strong>Keterangan</strong></td>
                <td>: <?= htmlspecialchars($transaksi_terpilih['keterangan'] ?? '-'); ?></td>
            </tr>
            <tr>
                <td><strong>Total Transaksi (Master)</strong></td>
                <td>: <strong>Rp <?= number_format($transaksi_terpilih['total'], 0, ',', '.'); ?></strong></td>
            </tr>
        </table>

        <br>

        <!-- Tabel Detail Barang -->
        <h3>Daftar Barang pada Transaksi Ini</h3>
        <table border="1" cellpadding="6" cellspacing="0" width="100%">
            <thead>
                <tr bgcolor="#eeeeee">
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Harga Satuan (Rp)</th>
                    <th>Qty</th>
                    <th>Subtotal (Rp)</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($detail_transaksi)): ?>
                    <?php 
                    $no_detail = 1; 
                    $total_hitung = 0;
                    ?>
                    <?php foreach ($detail_transaksi as $item): ?>
                        <?php 
                        $subtotal = $item['harga'] * $item['qty'];
                        $total_hitung += $subtotal;
                        ?>
                        <tr>
                            <td align="center"><?= $no_detail++; ?></td>
                            <td align="center"><?= htmlspecialchars($item['kode_barang']); ?></td>
                            <td><?= htmlspecialchars($item['nama_barang']); ?></td>
                            <td align="right">Rp <?= number_format($item['harga'], 0, ',', '.'); ?></td>
                            <td align="center"><?= (int)$item['qty']; ?></td>
                            <td align="right">Rp <?= number_format($subtotal, 0, ',', '.'); ?></td>
                            <td align="center">
                                <a href="hapus_detail.php?transaksi_id=<?= $transaksi_terpilih['id']; ?>&barang_id=<?= $item['barang_id']; ?>" 
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus item ini dari transaksi? Total transaksi akan dihitung ulang secara otomatis.');">
                                    Hapus Item
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr bgcolor="#f5f5f5">
                        <td colspan="5" align="right"><strong>Total Keseluruhan Detail:</strong></td>
                        <td align="right"><strong>Rp <?= number_format($total_hitung, 0, ',', '.'); ?></strong></td>
                        <td></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="7" align="center">Belum ada item barang pada transaksi ini. Silakan tambahkan pada form di bawah.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <br>

        <!-- Form Tambah Detail Transaksi -->
        <h3>Tambah Item ke Detail Transaksi</h3>
        <?php 
        // Periksa apakah masih ada barang yang belum dimasukkan ke transaksi ini
        $tersisa = 0;
        foreach ($semua_barang as $b) {
            if (!in_array((int)$b['id'], $barang_sudah_dipakai)) {
                $tersisa++;
            }
        }
        ?>

        <?php if ($tersisa > 0): ?>
            <form method="POST" action="tambah_detail.php">
                <input type="hidden" name="transaksi_id" value="<?= $transaksi_terpilih['id']; ?>">

                <table border="0" cellpadding="5" cellspacing="0">
                    <tr>
                        <td><label for="barang_id"><strong>Pilih Barang:</strong></label></td>
                        <td>
                            <select name="barang_id" id="barang_id" required>
                                <option value="">-- Pilih Barang --</option>
                                <?php foreach ($semua_barang as $b): ?>
                                    <?php 
                                    $sudah_ada = in_array((int)$b['id'], $barang_sudah_dipakai);
                                    ?>
                                    <?php if ($sudah_ada): ?>
                                        <!-- Barang yang sudah ada di transaksi dinonaktifkan (disabled) -->
                                        <option value="<?= $b['id']; ?>" disabled>
                                            [SUDAH DIPILIH] <?= htmlspecialchars($b['kode_barang']); ?> - <?= htmlspecialchars($b['nama_barang']); ?>
                                        </option>
                                    <?php else: ?>
                                        <option value="<?= $b['id']; ?>">
                                            <?= htmlspecialchars($b['kode_barang']); ?> - <?= htmlspecialchars($b['nama_barang']); ?> (Harga: Rp <?= number_format($b['harga'], 0, ',', '.'); ?> | Stok: <?= $b['stok']; ?>)
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                            <small><em>* Barang yang sudah masuk ke transaksi ini otomatis dinonaktifkan (disabled) sehingga tidak bisa dipilih dua kali.</em></small>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="qty"><strong>Jumlah (Qty):</strong></label></td>
                        <td>
                            <input type="number" name="qty" id="qty" min="1" value="1" required style="width: 80px;">
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <button type="submit">Simpan ke Detail Transaksi</button>
                        </td>
                    </tr>
                </table>
            </form>
        <?php else: ?>
            <p><em>Catatan: Semua barang dari tabel master barang sudah dimasukkan ke dalam detail transaksi ini. Tidak ada barang lain yang dapat dipilih lagi.</em></p>
        <?php endif; ?>

    <?php else: ?>
        <p>Silakan pilih salah satu transaksi pada tabel di atas untuk menampilkan detail transaksi.</p>
    <?php endif; ?>

</body>
</html>
