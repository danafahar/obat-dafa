<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../public/index.php?action=login');
    exit;
}

require_once '../controllers/ObatController.php';
require_once '../controllers/PesananController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_obat = $_POST['id_obat'];
    $jumlah = $_POST['jumlah'];
    $id_user = $_SESSION['user']['id_user'];

    $pesananCtrl = new PesananController();
    $pesananCtrl->buatPesanan($id_user, $id_obat, $jumlah);

    header("Location: dashboard_user.php?status=berhasil");
    exit;
}
