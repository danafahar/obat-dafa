<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Akun</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: white;
            padding: 40px 50px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            font-size: 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-bottom: 10px;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        a {
            display: inline-block;
            text-align: center;
            width: 100%;
            padding: 10px;
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        a:hover {
            background-color: #5a6268;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Edit Akun</h2>
        <form method="post" action="index.php?action=update_user&id=<?= htmlspecialchars($user['id']) ?>">
            <label>Username:</label>
            <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>

            <label>Nama Lengkap:</label>
            <input type="text" name="nama_lengkap" value="<?= htmlspecialchars($user['nama_lengkap']) ?>">

            <label>Level:</label>
            <select name="level" required>
                <option value="admin" <?= $user['level'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="user" <?= $user['level'] === 'user' ? 'selected' : '' ?>>User</option>
                <option value="operator" <?= $user['level'] === 'operator' ? 'selected' : '' ?>>Operator</option>
            </select>

            <button type="submit">Update</button>
           <a href="index.php?action=akun">Batal</a>
        </form>
    </div>
</body>

</html>