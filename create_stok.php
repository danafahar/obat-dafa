<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Stok Obat</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 40px;
            color: #333;
        }

        .container {
            max-width: 500px;
            background: white;
            margin: 0 auto;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #2c3e50;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #555;
        }

        input, select {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #007bff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            color: white;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background: #0056b3;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #555;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Tambah Stok Obat</h2>
        <form method="POST" action="index.php?action=create_stok">
            <label for="id_obat">Pilih Obat</label>
            <select name="id_obat" id="id_obat" required>
                <option value="">-- Pilih Obat --</option>
                <?php foreach ($dataObat as $obat): ?>
                    <option value="<?= $obat['id_obat'] ?>">
                        <?= $obat['kode_obat'] ?> - <?= $obat['merek_obat'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="jumlah_stok">Jumlah Stok</label>
            <input type="number" name="jumlah_stok" id="jumlah_stok" required>

            <label for="harga_beli">Harga Beli</label>
            <input type="number" name="harga_beli" id="harga_beli" required>

            <label for="harga_jual">Harga Jual</label>
            <input type="number" name="harga_jual" id="harga_jual" required>

            <button type="submit">Simpan</button>
        </form>
        <a class="back-link" href="index.php?action=stok_obat">← Kembali ke Data Stok</a>
    </div>
</body>
</html>