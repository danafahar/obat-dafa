<?php
// File: views/data_stok.php (REVISI FINAL: Manajemen Inventaris Modern)

// mulai session hanya bila belum aktif -> hindari Notice: session_start() already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header('Location: ../public/index.php?action=login');
    exit;
}
if ($_SESSION['user']['level'] !== 'admin') {
    echo "Akses ditolak!";
    exit;
}



// Tentukan ambang batas stok rendah
$lowStockThreshold = 30; // Jika stok kurang dari 30, dianggap rendah
// AKHIR SIMULASI DATA
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Stok Obat</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Variabel Warna */
        :root {
            --primary: #5e72e4; /* Biru/Ungu Logistik */
            --primary-light: #8da4f4;
            --success: #2dce89; /* Hijau Tambah */
            --warning: #fb6340; /* Merah Muda (Stok Rendah) */
            --info: #11cdef; /* Biru Info */
            --text-dark: #32325d;
            --bg-light: #f4f5f7;
            --shadow: 0 0 2rem 0 rgba(136, 152, 170, 0.15);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-light);
            margin: 0;
            padding: 30px;
            color: var(--text-dark);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: var(--shadow);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: var(--primary);
            font-weight: 700;
            font-size: 28px;
        }

        /* --- Tombol Aksi Utama --- */
        .button-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            gap: 15px;
        }

        .button-group a {
            padding: 10px 18px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 8px;
            text-decoration: none;
            color: white;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            box-shadow: 0 4px 6px rgba(50, 50, 93, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        .button-group a.create {
            background: var(--success);
        }

        .button-group a.create:hover {
            background: #25a872;
            transform: translateY(-2px);
        }

        .button-group a.back {
            background: var(--info);
        }

        .button-group a.back:hover {
            background: #0ea1bf;
            transform: translateY(-2px);
        }

        /* --- Tabel --- */
        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            min-width: 800px; 
        }

        thead {
            background: var(--primary);
            color: white;
        }

        th, td {
            padding: 14px 12px;
            text-align: center;
            border-bottom: 1px solid #e9ecef;
            font-size: 14px;
        }
        
        th:nth-child(3), td:nth-child(3) {
            text-align: left; /* Nama Obat rata kiri */
        }


        th {
            font-weight: 600;
            text-transform: uppercase;
        }

        tbody tr:hover {
            background-color: #f6f9fc; 
        }

        /* --- Stok Rendah --- */
        .stok-rendah {
            background-color: #fff0f0; /* Latar belakang merah muda */
            font-weight: 600;
        }
        
        .stok-rendah td {
            color: var(--danger, #e53935);
        }

        .stok-low-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
            color: white;
        }
        
        .badge-stok {
            background: var(--success);
        }
        
        .badge-stok.low {
            background: var(--warning);
        }


        /* --- Tombol Aksi Baris --- */
        .actions-cell {
            white-space: nowrap;
        }
        
        .action-btn {
            padding: 6px 10px;
            font-size: 13px;
            border-radius: 6px;
            text-decoration: none;
            color: white;
            font-weight: 500;
            margin: 0 4px;
            transition: all 0.2s ease;
        }

        .edit-btn {
            background: #ffc107;
        }

        .edit-btn:hover {
            background: #e0a800;
            transform: scale(1.05);
        }

        .delete-btn {
            background: #dc3545;
        }

        .delete-btn:hover {
            background: #c82333;
            transform: scale(1.05);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            .button-group {
                flex-direction: column;
            }
            .button-group a {
                width: 100%;
                text-align: center;
                margin: 5px 0;
            }
            h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>📦 Data Stok Obat</h2>

        <div class="button-group">
            <a href="index.php?action=dashboard_admin" class="back">← Kembali ke Dashboard</a>
            <a href="index.php?action=create_stok" class="create">➕ Tambah Stok Obat</a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Obat</th>
                        <th>Merk Obat</th>
                        <th>Jenis</th>
                        <th>Stok Saat Ini</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($dataStok)) : ?>
                        <?php $no = 1; foreach ($dataStok as $row): 
                            // Logika Stok Rendah
                            $isLowStock = $row['jumlah_stok'] < $lowStockThreshold;
                            $rowClass = $isLowStock ? 'stok-rendah' : '';
                            $badgeClass = $isLowStock ? 'low' : '';
                        ?>
                        <tr class="<?= $rowClass ?>">
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['kode_obat']) ?></td>
                            <td><?= htmlspecialchars($row['merek_obat']) ?></td>
                            <td><?= htmlspecialchars($row['jenis_obat']) ?></td>
                            <td>
                                <span class="stok-low-badge badge-stok <?= $badgeClass ?>">
                                    <?= htmlspecialchars($row['jumlah_stok']) ?>
                                </span>
                                <?php if ($isLowStock): ?>
                                    <small style="color:var(--warning);"> (Rendah!)</small>
                                <?php endif; ?>
                            </td>
                            <td>Rp <?= number_format($row['harga_beli'], 0, ',', '.') ?></td>
                            <td>Rp <?= number_format($row['harga_jual'], 0, ',', '.') ?></td>
                            <td class="actions-cell">
                                <a href="index.php?action=edit_stok&id=<?= $row['id_stok'] ?>" class="action-btn edit-btn">Edit</a>
                                <a href="index.php?action=delete_stok&id=<?= $row['id_stok'] ?>" class="action-btn delete-btn" onclick="return confirm('Yakin ingin menghapus data stok <?= htmlspecialchars($row['merek_obat']) ?>?')">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="8" class="text-center" style="padding: 20px; color: #999;">Tidak ada data stok saat ini.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <script>
        // JavaScript (Opsional)
        document.addEventListener('DOMContentLoaded', () => {
            console.log('Halaman Data Stok Obat dimuat dengan tema inventaris modern.');
            
            // Logika untuk menandai baris stok rendah (sudah ada di PHP, tapi ini contoh JS)
            const lowStockThreshold = <?= $lowStockThreshold ?>;
            const stokCells = document.querySelectorAll('tbody tr td:nth-child(5)'); // Kolom Stok
            
            stokCells.forEach(cell => {
                const stockValue = parseInt(cell.textContent.trim().split(' ')[0]);
                if (stockValue < lowStockThreshold) {
                    // Cek jika class belum ditambahkan oleh PHP (redundant, tapi bagus untuk validasi)
                    if (!cell.parentElement.classList.contains('stok-rendah')) {
                         cell.parentElement.classList.add('stok-rendah');
                    }
                }
            });
        });
        
        // Fungsi untuk memastikan format Rupiah tetap konsisten (jika diperlukan)
        function formatRupiah(number) {
            return 'Rp ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    </script>
</body>
</html>