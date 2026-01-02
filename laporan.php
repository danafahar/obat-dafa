<?php
// PHP di sini biasanya digunakan untuk mengambil data dari database
// dan menampilkannya dalam bentuk tabel di bawah.

// Data contoh (sama dengan data di cetak_laporan.php)
$data_penjualan = [
    ['no' => 1, 'kode_trx' => 'TRX001', 'tanggal' => '2025-12-01', 'total' => 150000],
    ['no' => 2, 'kode_trx' => 'TRX002', 'tanggal' => '2025-12-03', 'total' => 320000],
    ['no' => 3, 'kode_trx' => 'TRX003', 'tanggal' => '2025-12-05', 'total' => 85000],
];
$grand_total = array_sum(array_column($data_penjualan, 'total'));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Halaman Laporan Penjualan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7f6;
            margin: 20px;
            color: #333;
        }
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #007bff;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #e9ecef;
        }
        tfoot td {
            font-weight: 600;
            background-color: #f8f9fa;
        }
        .text-right {
            text-align: right;
        }
        
        /* Gaya untuk Tombol Cetak */
        .print-link {
            display: inline-block;
            padding: 10px 20px;
            background-color: #28a745; /* Warna hijau */
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            margin-bottom: 20px;
            transition: background-color 0.3s;
        }
        .print-link:hover {
            background-color: #1e7e34;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Laporan Penjualan Apotek Daring</h2>
    
    <a href="cetak_laporan.php" class="print-link" target="_blank">
        🖨️ Cetak Laporan PDF
    </a>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Transaksi</th>
                <th>Tanggal</th>
                <th class="text-right">Total Penjualan (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data_penjualan as $row): ?>
            <tr>
                <td><?php echo $row['no']; ?></td>
                <td><?php echo $row['kode_trx']; ?></td>
                <td><?php echo $row['tanggal']; ?></td>
                <td class="text-right"><?php echo number_format($row['total'], 0, ',', '.'); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">GRAND TOTAL</td>
                <td class="text-right"><?php echo number_format($grand_total, 0, ',', '.'); ?></td>
            </tr>
        </tfoot>
    </table>
</div>

</body>
</html>