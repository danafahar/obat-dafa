<?php
// File: views/daftar_akun.php (REVISI FINAL: Glassmorphism & Responsif)

// mulai session hanya bila belum aktif -> hindari Notice
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header('Location: ../public/index.php?action=login');
    exit;
}
$level = $_SESSION['user']['level'];
$nama = $_SESSION['user']['nama_lengkap'];

if (!in_array($level, ['admin', 'operator'])) {
    echo "Akses ditolak!";
    exit;
}

// tambahkan mapping role setelah validasi session
$roleLabels = ['admin' => 'Admin', 'operator' => 'Operator', 'user' => 'User'];

$dashboardLink = "index.php?action=dashboard_" . htmlspecialchars($level);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Pengguna</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
    /* Variabel Warna */
    :root {
        --primary: #0077b6; /* Biru Utama */
        --secondary: #00b4d8; /* Biru Kedua */
        --accent: #caf0f8; /* Biru Muda Aksen */
        --bg-gradient: linear-gradient(135deg, #e0f7fa 0%, #ffffff 100%);
        --shadow-light: 0 8px 24px rgba(0, 0, 0, 0.1);
        --text-dark: #333;
        --danger: #e74c3c;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background: var(--bg-gradient);
        background-attachment: fixed;
        margin: 0;
        padding: 20px;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        color: var(--text-dark);
    }

    .container {
        background: rgba(255, 255, 255, 0.75); /* Sedikit lebih solid */
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        box-shadow: var(--shadow-light);
        border-radius: 20px;
        max-width: 1000px;
        width: 95%;
        padding: 40px;
        animation: fadeIn 0.8s ease-out;
    }

    h2 {
        text-align: center;
        color: var(--primary);
        font-weight: 700;
        margin-bottom: 30px;
        font-size: 28px;
    }

    /* --- Aksi dan Tombol --- */
    .actions {
        display: flex;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 25px;
    }

    .btn {
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    a.akun {
        background-color: var(--secondary);
        color: white;
    }

    a.akun:hover {
        background-color: var(--primary);
        transform: translateY(-2px);
    }

    a.dashboard {
        background-color: var(--accent);
        color: var(--primary);
        box-shadow: 0 4px 10px rgba(0, 119, 182, 0.1);
    }

    a.dashboard:hover {
        background-color: #ade8f4;
        transform: translateY(-2px);
    }

    /* --- Tabel --- */
    .table-responsive {
        overflow-x: auto;
    }
    
    table {
        min-width: 600px; /* Lebar minimum untuk responsif */
        width: 100%;
        border-collapse: separate; /* Digunakan dengan border-spacing */
        border-spacing: 0;
        background-color: rgba(255, 255, 255, 0.9);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    table th,
    table td {
        padding: 15px;
        border: none;
        border-bottom: 1px solid #ebf4f8;
        font-size: 14px;
        text-align: left;
    }

    table th {
        background-color: var(--primary);
        color: #ffffff;
        font-weight: 600;
        text-transform: uppercase;
    }

    table tr:last-child td {
        border-bottom: none;
    }

    table tr:hover td {
        background-color: var(--accent);
        transition: background-color 0.3s ease;
    }

    /* Kolom Aksi */
    td.actions-cell {
        white-space: nowrap;
    }
    
    td.actions-cell a {
        color: var(--primary);
        text-decoration: none;
        margin-right: 10px;
        font-weight: 500;
        transition: color 0.2s;
    }

    td.actions-cell a:hover {
        color: var(--primary-dark);
        text-decoration: underline;
    }
    
    /* Tombol Hapus disorot merah */
    td.actions-cell a:nth-child(2) { /* Link Hapus */
        color: var(--danger);
    }
    
    .no-data {
        text-align: center;
        padding: 30px;
        font-style: italic;
        color: #999;
        background-color: #f8f8f8;
    }

    /* Animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Responsive */
    @media (max-width: 650px) {
        .container {
            padding: 20px;
            width: 100%;
        }
        .actions {
            flex-direction: column;
        }
        .btn {
            width: 100%;
            text-align: center;
        }
    }
    </style>
</head>

<body>
    <div class="container">
        <h2>👥 Daftar Akun Pengguna</h2>
        
        <div class="actions">
            <?php if ($level === 'admin'): ?>
                <a class="btn akun" href="index.php?action=create_user">+ Tambah Akun Baru</a>
            <?php endif; ?>
            <a class="btn dashboard" href="<?= $dashboardLink ?>">Kembali ke Dashboard</a>
        </div>
        
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Nama Lengkap</th>
                        <th>Level</th>
                        <th class="actions-cell">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php $no = 1;
                        foreach ($users as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($no++) ?></td>
                                <td><?= htmlspecialchars($user['id']) ?></td>
                                <td><?= htmlspecialchars($user['username']) ?></td>
                                <td><?= htmlspecialchars(ucwords($user['nama_lengkap'])) ?></td>
                                <td>
                                    <span class="badge-level level-<?= htmlspecialchars($user['level']) ?>">
                                        <?= htmlspecialchars($roleLabels[$user['level']] ?? ucfirst($user['level'])) ?>
                                    </span>
                                </td>
                                <td class="actions-cell">
                                    <a href="index.php?action=edit_user&id=<?= urlencode($user['id']) ?>">Edit</a> 
                                    <?php if ($level === 'admin'): ?>
                                    | <a href="index.php?action=delete_user&id=<?= urlencode($user['id']) ?>" 
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus akun <?= htmlspecialchars($user['username']) ?>? Tindakan ini tidak dapat dibatalkan.')">Hapus</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="no-data">Data akun tidak ditemukan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <style>
        .badge-level {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            color: white;
            text-transform: capitalize;
        }
        .level-admin {
            background-color: #e63946; /* Merah */
        }
        .level-operator {
            background-color: #457b9d; /* Biru Gelap */
        }
    </style>
    
    <script>
        // JS sederhana untuk konfirmasi yang lebih terstruktur (opsional)
        document.addEventListener('DOMContentLoaded', () => {
            const deleteLinks = document.querySelectorAll('a[href*="delete_user"]');
            
            deleteLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    // Cek apakah browser support dialog/modal yang lebih baik
                    if (typeof Swal !== 'undefined') { // Contoh jika Anda menggunakan SweetAlert
                        // ... SweetAlert implementation
                    } else {
                        // Jika hanya menggunakan confirm bawaan
                        // Logika konfirmasi sudah ada di PHP inline (onclick)
                    }
                });
            });
            
            console.log('Halaman Daftar Akun dimuat.');
        });
    </script>
</body>

</html>