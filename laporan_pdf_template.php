<!DOCTYPE html>
<html>
<head>
    <title>Laporan Riwayat Obat</title>
    <style>
        /* CSS INTERNAL UNTUK DOMPDF */
        body { font-family: "Helvetica", sans-serif; font-size: 10pt; }
        h1, h2 { text-align: center; color: #333; }
        h1 { font-size: 16pt; margin-bottom: 5px; }
        h2 { font-size: 12pt; margin-top: 20px; border-bottom: 1px solid #ccc; padding-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px 8px; text-align: left; font-size: 9pt; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Laporan Riwayat Obat Apotek</h1>
    <p style="text-align: center; font-size: 9pt;">
        Periode: <?php echo $report_dates['start'] ?? 'Awal' ?> s/d <?php echo $report_dates['end'] ?? 'Sekarang' ?>
    </p>

    <h2>Riwayat Obat Masuk</h2>
    <table>
        <tbody>
            <?php if (!empty($obat_masuk)): ?>
                <?php $no = 1; foreach ($obat_masuk as $obat): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($obat['kode_obat']) ?></td>
                        <td><?= htmlspecialchars($obat['merek_obat']) ?></td>
                        <td><?= htmlspecialchars($obat['jenis_obat']) ?></td>
                        <td><?= htmlspecialchars($obat['tanggal_masuk']) ?></td>
                        <td><?= htmlspecialchars($obat['exp']) ?></td>
                        <td><?= htmlspecialchars($obat['jumlah_stok'] ?? '0') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6">Tidak ada data riwayat obat masuk.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <h2>Riwayat Obat Rusak</h2>
    <table>
        <tbody>
            <?php if (!empty($obat_rusak)): ?>
                <?php $no = 1; foreach ($obat_rusak as $rusak): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($rusak['merek_obat']) ?></td>
                        <td><?= htmlspecialchars($rusak['jumlah_rusak']) ?></td>
                        <td><?= htmlspecialchars($rusak['tanggal_rusak']) ?></td>
                        <td><?= htmlspecialchars($rusak['alasan_rusak']) ?></td>
                        <td><?= htmlspecialchars($rusak['user_pelapor']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6">Tidak ada data riwayat obat rusak.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>