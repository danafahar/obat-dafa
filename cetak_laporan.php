<?php
// File: views/laporan/cetak_laporan.php (REVISI FINAL)
// File ini dipanggil oleh LaporanController untuk membuat PDF.

// Variabel yang tersedia: $obat_masuk, $obat_rusak, $report_dates

$display_range = $report_dates['display_range'] ?? 'Semua Data';

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Obat PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 10pt; }
        h1, h2 { text-align: center; color: #333; }
        .header { margin-bottom: 20px; }
        .info { text-align: center; margin-bottom: 20px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; }
        .section-title { margin-top: 20px; border-bottom: 1px solid #ccc; padding-bottom: 5px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>LAPORAN RIWAYAT OBAT APOTEK</h1>
        <p class="info"><?php echo $display_range; ?></p>
    </div>
    
    <h2>Riwayat Obat Masuk</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Obat</th>
                <th>Merek Obat</th>
                <th>Jenis</th>
                <th>Tanggal Masuk</th>
                <th>Tanggal Exp</th>
                 <th>Stok Saat Ini</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($obat_masuk)): ?>
                <?php $no = 1; foreach ($obat_masuk as $obat): ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars($obat['kode_obat']); ?></td>
                        <td><?php echo htmlspecialchars($obat['merek_obat']); ?></td>
                        <td><?php echo htmlspecialchars($obat['jenis_obat']); ?></td>
                        <td><?php echo htmlspecialchars($obat['tanggal_masuk']); ?></td>
                        <td><?php echo htmlspecialchars($obat['exp']); ?></td>
                        <td><?= htmlspecialchars($obat['jumlah_stok'] ?? '0') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6" style="text-align: center;">Tidak ada data riwayat obat masuk.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <br>
    
    <h2>Riwayat Obat Rusak</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Merek Obat</th>
                <th>Jumlah Rusak</th>
                <th>Tanggal Rusak</th>
                <th>Alasan</th>
                <th>Keterangan</th>
                <th>Dicatat Oleh</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($obat_rusak)): ?>
                <?php $no = 1; foreach ($obat_rusak as $rusak): ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars($rusak['merek_obat']); ?></td>
                        <td><?php echo htmlspecialchars($rusak['jumlah_rusak']); ?></td>
                        <td><?php echo htmlspecialchars($rusak['tanggal_rusak']); ?></td>
                        <td><?php echo htmlspecialchars($rusak['alasan_rusak'] ?: 'Tidak Dicatat'); ?></td>
                        <td><?php echo htmlspecialchars($rusak['keterangan']); ?></td>
                        <td><?php echo htmlspecialchars($rusak['user_pelapor']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="7" style="text-align: center;">Tidak ada data riwayat obat rusak.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>