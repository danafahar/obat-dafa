<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Stok Obat</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
            padding: 30px;
        }

        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #343a40;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 14px;
        }

        button {
            background: #007bff;
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background: #0069d9;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Stok Obat</h2>
        <form action="index.php?action=update_stok&id=<?= $stok['id_stok'] ?>" method="POST">
            <label for="id_obat">Obat</label>
            <select name="id_obat" id="id_obat" required>
                <?php foreach ($obatList as $obat): ?>
                    <option value="<?= $obat['id_obat'] ?>" <?= $obat['id_obat'] == $stok['id_obat'] ? 'selected' : '' ?>>
                        <?= $obat['kode_obat'] ?> - <?= $obat['merek_obat'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="jumlah_stock">Jumlah Stok</label>
            <input type="number" name="jumlah_stok" id="jumlah_stok" value="<?= $stok['jumlah_stok'] ?>" required>

            <label for="harga_beli">Harga Beli</label>
            <input type="number" name="harga_beli" id="harga_beli" value="<?= $stok['harga_beli'] ?>" required>

            <label for="harga_jual">Harga Jual</label>
            <input type="number" name="harga_jual" id="harga_jual" value="<?= $stok['harga_jual'] ?>" required>