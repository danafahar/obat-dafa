<?php
// File: views/dashboard_admin.php (Optimized Version)

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
$nama = $_SESSION['user']['nama_lengkap'];
$level = $_SESSION['user']['level'];

require_once __DIR__ . '/../config/Database.php'; 
$db = new Database();

// Helper functions (Tetap sama seperti logika Anda sebelumnya)
function db_fetchColumn($db, string $sql, array $params = []) {
	if (isset($db) && $db instanceof PDO) {
		$stmt = $db->prepare($sql);
		$stmt->execute($params);
		$col = $stmt->fetchColumn();
		return $col !== false ? $col : 0;
	}
	if (isset($db) && is_object($db) && method_exists($db, 'query')) {
		$res = $db->query($sql, $params);
		if (is_array($res) && count($res) > 0 && is_array($res[0])) {
			$first = array_values($res[0]);
			return $first[0] ?? 0;
		}
	}
	return 0;
}

function db_fetchAll($db, string $sql, array $params = []) {
	if (isset($db) && $db instanceof PDO) {
		$stmt = $db->prepare($sql);
		$stmt->execute($params);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	if (isset($db) && is_object($db) && method_exists($db, 'query')) {
		return $db->query($sql, $params) ?: [];
	}
	return [];
}

$current_month = date('m');
$current_year = date('Y');
$stok_minimum = 30;
$total_akun = $total_jenis_obat = $obat_menipis = $obat_rusak_bulan_ini = 0;

try {
    $total_akun = (int) db_fetchColumn($db, "SELECT COUNT(*) AS total FROM tbl_login");
    $total_jenis_obat = (int) db_fetchColumn($db, "SELECT COUNT(DISTINCT merek_obat) AS total FROM tbl_obat");
    $obat_menipis = (int) db_fetchColumn($db, "SELECT COUNT(*) AS total FROM tbl_stok_obat WHERE jumlah_stok <= :min_stok", [':min_stok' => $stok_minimum]);
    $obat_rusak_bulan_ini = (int) db_fetchColumn($db, "SELECT COUNT(*) AS total FROM tbl_obat_rusak WHERE MONTH(tanggal_rusak) = :month AND YEAR(tanggal_rusak) = :year", [':month' => $current_month, ':year' => $current_year]);
} catch (Exception $e) {
    error_log($e->getMessage());
}

$summaryData = [
    'total_akun' => $total_akun,
    'total_jenis_obat' => $total_jenis_obat, 
    'obat_menipis' => $obat_menipis,
    'obat_rusak_bulan_ini' => $obat_rusak_bulan_ini
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Apotek Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #0ea5e9;
            --primary-dark: #0369a1;
            --accent: #f0f9ff;
            --sidebar-bg: #ffffff;
            --main-bg: #f8fafc;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --white: #ffffff;
            --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--main-bg);
            color: var(--text-main);
            display: flex;
            min-height: 100vh;
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: 260px;
            background: var(--sidebar-bg);
            box-shadow: var(--shadow);
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            z-index: 1000;
            border-right: 1px solid #e2e8f0;
        }

        .logo {
            padding: 30px 25px;
            font-size: 22px;
            font-weight: 800;
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .menu-group {
            padding: 20px 25px 10px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--text-muted);
            letter-spacing: 0.05em;
        }

        .menu-item {
            margin: 2px 15px;
            padding: 12px 15px;
            display: flex;
            align-items: center;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border-radius: 8px;
            transition: 0.2s;
        }

        .menu-item i {
            width: 25px;
            font-size: 18px;
        }

        .menu-item:hover {
            background: var(--accent);
            color: var(--primary);
        }

        .menu-item.active {
            background: var(--primary);
            color: var(--white);
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
        }

        .logout-container { margin-top: auto; padding: 20px; }
        .btn-logout {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 12px;
            background: #ef4444;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: 0.2s;
        }
        .btn-logout:hover { background: #dc2626; }

        /* --- MAIN CONTENT --- */
        .main-content {
            margin-left: 260px;
            flex-grow: 1;
            width: calc(100% - 260px);
        }

        .navbar {
            height: 70px;
            background: var(--white);
            padding: 0 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .container {
            padding: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .header-section { margin-bottom: 30px; }
        .header-section h1 { font-size: 24px; font-weight: 700; color: var(--text-main); }
        .header-section p { color: var(--text-muted); font-size: 14px; }

        /* --- STATS CARDS --- */
        .info-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 24px;
        }

        .card {
            background: var(--white);
            padding: 24px;
            border-radius: 12px;
            box-shadow: var(--shadow);
            text-decoration: none;
            display: flex;
            flex-direction: column;
            position: relative;
            border-left: 4px solid transparent;
            transition: 0.3s;
        }

        .card:hover { transform: translateY(-5px); }
        .card.blue { border-left-color: #3b82f6; }
        .card.green { border-left-color: #10b981; }
        .card.yellow { border-left-color: #f59e0b; }
        .card.red { border-left-color: #ef4444; }

        .card-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .card-icon {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .blue .card-icon { background: #eff6ff; color: #3b82f6; }
        .green .card-icon { background: #ecfdf5; color: #10b981; }
        .yellow .card-icon { background: #fffbeb; color: #f59e0b; }
        .red .card-icon { background: #fef2f2; color: #ef4444; }

        .card-info h4 { font-size: 13px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; }
        .card-info p { font-size: 28px; font-weight: 700; color: var(--text-main); margin-top: 4px; }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 13px;
            color: var(--text-muted);
            padding-bottom: 30px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar { width: 0; transform: translateX(-100%); transition: 0.3s; }
            .main-content { margin-left: 0; width: 100%; }
            .container { padding: 20px; }
        }
    </style>
</head>
<body>
    
    <aside class="sidebar">
        <div class="logo">
            <i class="fa-solid fa-capsules"></i> Apotek.
        </div>
        
        <nav>
            <div class="menu-group">Main</div>
            <a class="menu-item active" href="?action=dashboard_admin">
                <i class="fa-solid fa-house"></i> <span>Dashboard</span>
            </a>
            
            <div class="menu-group">Inventory</div>
            <a class="menu-item" href="?action=obat">
                <i class="fa-solid fa-pills"></i> <span>Data Obat</span>
            </a>
            <a class="menu-item" href="?action=stok_obat">
                <i class="fa-solid fa-boxes-stacked"></i> <span>Stok Masuk</span>
            </a>
            <a class="menu-item" href="?action=obat_rusak">
                <i class="fa-solid fa-trash-can"></i> <span>Obat Rusak</span>
            </a>
            
            <div class="menu-group">System</div>
            <a class="menu-item" href="?action=akun">
                <i class="fa-solid fa-users-gear"></i> <span>Kelola Akun</span>
            </a>
            <a class="menu-item" href="?action=laporan">
                <i class="fa-solid fa-chart-line"></i> <span>Laporan</span>
            </a>
        </nav>

        <div class="logout-container">
            <a class="btn-logout" href="?action=logout">
                <i class="fa-solid fa-right-from-bracket"></i> Keluar
            </a>
        </div>
    </aside>
    
    <main class="main-content">
        <header class="navbar">
            <div class="nav-left">
                <p>Hari ini: <strong><?= date('d M Y') ?></strong></p>
            </div>
            <div class="user-profile">
                <div class="text-right" style="text-align: right;">
                    <div style="font-weight: 600; font-size: 14px;"><?= htmlspecialchars($nama) ?></div>
                    <div style="font-size: 12px; color: var(--text-muted);"><?= ucfirst($level) ?></div>
                </div>
                <div class="user-avatar">
                    <?= strtoupper(substr($nama, 0, 1)) ?>
                </div>
            </div>
        </header>

        <div class="container">
            <section class="header-section">
                <h1>Ringkasan Statistik</h1>
                <p>Selamat datang kembali! Berikut adalah status inventaris apotek Anda saat ini.</p>
            </section>

            <div class="info-cards">
                <a href="?action=akun" class="card blue">
                    <div class="card-head">
                        <div class="card-icon"><i class="fa-solid fa-users"></i></div>
                    </div>
                    <div class="card-info">
                        <h4>Total Pengguna</h4>
                        <p><?= number_format($summaryData['total_akun']) ?></p>
                    </div>
                </a>
                
                <a href="?action=obat" class="card green">
                    <div class="card-head">
                        <div class="card-icon"><i class="fa-solid fa-prescription-bottle-medical"></i></div>
                    </div>
                    <div class="card-info">
                        <h4>Jenis Obat</h4>
                        <p><?= number_format($summaryData['total_jenis_obat']) ?></p>
                    </div>
                </a>
                
                <a href="?action=stok_obat" class="card yellow">
                    <div class="card-head">
                        <div class="card-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
                    </div>
                    <div class="card-info">
                        <h4>Stok Menipis</h4>
                        <p><?= number_format($summaryData['obat_menipis']) ?></p>
                    </div>
                </a>
                
                <a href="?action=obat_rusak" class="card red">
                    <div class="card-head">
                        <div class="card-icon"><i class="fa-solid fa-dumpster-fire"></i></div>
                    </div>
                    <div class="card-info">
                        <h4>Rusak (Bulan Ini)</h4>
                        <p><?= number_format($summaryData['obat_rusak_bulan_ini']) ?></p>
                    </div>
                </a>
            </div>

            <footer class="footer">
                &copy; <?= date('Y') ?> Apotek Digital Management System • Crafted with ❤️
            </footer>
        </div>
    </main>
</body>
</html>