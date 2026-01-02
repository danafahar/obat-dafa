<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../public/index.php?action=login');
    exit;
}
if ($_SESSION['user']['level'] !== 'operator') {
    echo "Akses ditolak!";
    exit;
}
$nama = $_SESSION['user']['nama_lengkap'];
$level = $_SESSION['user']['level'];

// Dummy data untuk contoh tampilan
require_once '../config/Database.php';
require_once '../models/Obat.php';

$db = (new Database())->getConnection();
$obatModel = new Obat($db);

$nama = $_SESSION['user']['nama_lengkap'];
$level = $_SESSION['user']['level'];

$total_obat = $obatModel->getTotalObat();
$total_stok_obat = $obatModel->getTotalStok();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Operator</title>
   <style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(to right, #e8f5e9, #ffffff);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .container {
        background-color: #ffffff;
        padding: 40px 50px;
        border-radius: 16px;
        box-shadow: 0 0 25px rgba(76, 175, 80, 0.2);
        max-width: 620px;
        width: 100%;
        text-align: center;
        position: relative;
        overflow: hidden;
        border-left: 8px solid #4caf50;
    }

    .container::before {
        content: "\f0fa"; /* Icon Font Awesome Medical Cross */
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        font-size: 80px;
        color: #e0f2f1;
        position: absolute;
        top: 20px;
        right: 25px;
        opacity: 0.2;
    }

    h2 {
        margin-bottom: 10px;
        color: #2e7d32;
        font-weight: 600;
    }

    p {
        font-size: 16px;
        color: #555;
    }

    .stats {
        background-color: #f1f8e9;
        border-radius: 10px;
        padding: 25px;
        margin: 30px 0;
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
    }

    .stats p {
        margin: 10px 0;
        font-weight: 600;
        color: #388e3c;
        flex: 1 1 45%;
    }

    a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 10px 10px 0 10px;
        padding: 12px 20px;
        font-size: 14px;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        transition: 0.2s ease-in-out;
        font-weight: 500;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    a i {
        margin-right: 8px;
        font-size: 16px;
    }

    a.data_user {
        background-color: #26a69a;
    }

    a.data_user:hover {
        background-color: #00897b;
    }

    a.data_obat {
        background-color: #42a5f5;
    }

    a.data_obat:hover {
        background-color: #1e88e5;
    }

    a.logout {
        background-color: #ef5350;
    }

    a.logout:hover {
        background-color: #d32f2f;
    }

    @media (max-width: 500px) {
        .stats {
            flex-direction: column;
            align-items: center;
        }
    }
</style>
</head>
<body>
    <div class="container">
        <h2>Dashboard Operator</h2>
        <p>Selamat datang, <strong><?= htmlspecialchars($nama) ?></strong> (Level: <strong><?= htmlspecialchars($level) ?></strong>)</p>

        <div class="stats">
            <p>Total Obat: <?= $total_obat ?></p>
            <p>Total Stok Obat: <?= $total_stok_obat ?></p>
        </div>

        <a class="data_user" href="../public/index.php?action=akun">Data Akun</a>
        <a class="data_obat" href="../public/index.php?action=obat">Data Obat</a>
        <a class="logout" href="../public/index.php?action=logout">Logout</a>
    </div>
</body>
</html>