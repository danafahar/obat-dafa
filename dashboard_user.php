<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../public/index.php?action=login');
    exit;
}
if ($_SESSION['user']['level'] !== 'user') {
    echo "Akses ditolak!";
    exit;
}
$nama = $_SESSION['user']['nama_lengkap'];
$level = $_SESSION['user']['level'];

require_once '../controllers/ObatController.php';
$controller = new ObatController();
$obat = $controller->getDataObatDenganHarga();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard User</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 30px;
            background: linear-gradient(135deg, #ade8f4, #ffffff);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .container {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 30px 40px;
            max-width: 1100px;
            width: 100%;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            font-size: 26px;
            color: #023e8a;
            margin-bottom: 10px;
        }

        p {
            text-align: center;
            font-size: 16px;
            color: #333;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #dee2e6;
        }

        thead {
            background-color: #0077b6;
            color: white;
        }

        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tbody tr:hover {
            background-color: #e0f7fa;
        }

        .status-tersedia {
            background-color: #d4edda;
            color: #155724;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
            display: inline-block;
        }

        .status-habis {
            background-color: #f8d7da;
            color: #721c24;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
            display: inline-block;
        }

        .logout {
            display: inline-block;
            background-color: #d9534f;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            margin-top: 25px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .logout:hover {
            background-color: #c9302c;
        }

        .btn-pesan {
            background-color: #0077b6;
            color: #fff;
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
        }

        .btn-pesan:hover {
            background-color: #005f87;
        }

        @media screen and (max-width: 768px) {
            .container {
                padding: 20px;
            }

            table, thead, tbody, th, td, tr {
                font-size: 13px;
            }

            h2 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Toko Obat Kelontong</h2>
        <p>Selamat datang, <strong><?= htmlspecialchars($nama) ?></strong></p>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Obat</th>
                    <th>Merek</th>
                    <th>Jenis</th>
                    <th>Tanggal Masuk</th>
                    <th>Exp</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($obat)) : ?>
                    <?php foreach ($obat as $i => $o) : ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= htmlspecialchars($o['kode_obat']) ?></td>
                            <td><?= htmlspecialchars($o['merek_obat']) ?></td>
                            <td><?= htmlspecialchars($o['jenis_obat']) ?></td>
                            <td><?= htmlspecialchars($o['tanggal_masuk']) ?></td>
                            <td><?= htmlspecialchars($o['exp']) ?></td>
                            <td>Rp <?= number_format($o['harga_jual'], 0, ',', '.') ?></td>
                            <td><?= is_null($o['jumlah_stok']) ? '0' : htmlspecialchars($o['jumlah_stok']) ?></td>
                            <td>
                                <?php if (empty($o['jumlah_stok']) || $o['jumlah_stok'] == 0): ?>
                                    <span class="status-habis">Habis</span>
                                <?php else: ?>
                                    <span class="status-tersedia">Tersedia</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($o['jumlah_stok']) && $o['jumlah_stok'] > 0): ?>
                                    <form method="POST" action="proses_pesan.php">
                                        <input type="hidden" name="id_obat" value="<?= $o['id_obat']; ?>">
                                        <input type="number" name="jumlah" value="1" min="1" max="<?= $o['jumlah_stok']; ?>">
                                        <button type="submit" class="btn-pesan">Pesan</button>
                                    </form>
                                <?php else: ?>
                                    <span style="color:gray;">Habis</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="10">Tidak ada data obat tersedia.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div style="text-align: center;">
            <a class="logout" href="../public/index.php?action=logout">Logout</a>
        </div>
    </div>
</body>
</html>
