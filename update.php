<?php
// mulai session hanya bila belum aktif
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// proteksi akses
if (!isset($_SESSION['user'])) {
    header('Location: ../public/index.php?action=login');
    exit;
}
if (!in_array($_SESSION['user']['level'], ['admin', 'operator'])) {
    echo "Akses ditolak!";
    exit;
}

// Pastikan variabel tersedia agar view aman bila dipanggil langsung
$rusak = $rusak ?? [];
$dataObat = $dataObat ?? [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Edit Obat Rusak</title>
    <style>
        body{font-family:Arial,Helvetica,sans-serif;padding:20px;background:#f7f9fc}
        .card{background:#fff;padding:20px;border-radius:8px;max-width:700px;margin:20px auto;box-shadow:0 6px 18px rgba(0,0,0,0.06)}
        label{display:block;margin-top:10px;font-weight:600}
        input,select,textarea{width:100%;padding:8px;margin-top:6px;border:1px solid #ccc;border-radius:4px}
        button{margin-top:12px;padding:10px 14px;background:#007bff;color:#fff;border:none;border-radius:6px;cursor:pointer}
        a{display:inline-block;margin-top:12px;color:#007bff}
    </style>
</head>
<body>
    <div class="card">
        <h2>Edit Obat Rusak</h2>

        <form method="post" action="../public/index.php?action=update_rusak&id=<?= urlencode($rusak['id_rusak'] ?? $rusak['id'] ?? '') ?>">
            <label for="obat_id">Pilih Obat</label>
            <select id="obat_id" name="obat_id" required>
                <option value="">-- Pilih Obat --</option>
                <?php foreach ($dataObat as $o): 
                    $oid = $o['id'] ?? $o['id_obat'] ?? '';
                    $selected = ($oid == ($rusak['id_obat'] ?? '')) ? 'selected' : '';
                ?>
                    <option value="<?= htmlspecialchars($oid) ?>" <?= $selected ?>><?= htmlspecialchars($o['merek_obat'] ?? $o['nama'] ?? $o['kode_obat'] ?? '') ?></option>
                <?php endforeach; ?>
            </select>

            <label for="jumlah_rusak">Jumlah Rusak</label>
            <input type="number" id="jumlah_rusak" name="jumlah_rusak" min="1" required value="<?= htmlspecialchars($rusak['jumlah_rusak'] ?? $rusak['jumlah'] ?? '') ?>">

            <label for="alasan_rusak">Alasan</label>
            <textarea id="alasan_rusak" name="alasan_rusak" rows="3"><?= htmlspecialchars($rusak['alasan_rusak'] ?? '') ?></textarea>

            <label for="tanggal_rusak">Tanggal</label>
            <input type="date" id="tanggal_rusak" name="tanggal_rusak" required value="<?= htmlspecialchars($rusak['tanggal_rusak'] ?? date('Y-m-d')) ?>">

            <label for="keterangan">Keterangan (opsional)</label>
            <input type="text" id="keterangan" name="keterangan" value="<?= htmlspecialchars($rusak['keterangan'] ?? '') ?>">

            <button type="submit">Simpan Perubahan</button>
        </form>

        <p><a href="../public/index.php?action=obat_rusak">← Kembali ke Daftar Obat Rusak</a></p>
    </div>
</body>
</html>