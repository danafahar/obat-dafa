<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../public/index.php?action=login');
    exit;
}

require_once '../controllers/ObatController.php';
$controller = new ObatController();

$id = $_POST['id_obat'] ?? null;
$jumlah = $_POST['jumlah'] ?? 1;

if (!$id) {
    die("Obat tidak ditemukan.");
}

$obat = $controller->getObatById($id);
if (!$obat) {
    die("Data obat tidak ada.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pesan Obat</title>
</head>
<body>
    <h2>Konfirmasi Pesanan</h2>
    <p><b>Nama Obat:</b> <?= htmlspecialchars($obat['merek']); ?></p>
    <p><b>Jenis:</b> <?= htmlspecialchars($obat['jenis_obat']); ?></p>
    <p><b>Harga:</b> Rp <?= number_format($obat['harga'], 0, ',', '.'); ?></p>
    <p><b>Jumlah:</b> <?= $jumlah; ?></p>
    <p><b>Total:</b> Rp <?= number_format($obat['harga'] * $jumlah, 0, ',', '.'); ?></p>

    <form method="POST" action="proses_pesan.php">
        <input type="hidden" name="id_obat" value="<?= $obat['id_obat']; ?>">
        <input type="hidden" name="jumlah" value="<?= $jumlah; ?>">
        <button type="submit">Konfirmasi Pesan</button>
    </form>
</body>
</html>
