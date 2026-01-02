<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Daftar Akun Baru</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Fira+Code&display=swap');

    body {
        font-family: 'Fira Code', monospace;
        background-color: #1e1e2f;
        color: #c3c3c3;
        margin: 0;
        padding: 0;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .form-container {
        background-color: #2a2a40;
        padding: 30px 40px;
        border-radius: 10px;
       
        width: 100%;
        max-width: 440px;
    }

    h2 {
        text-align: center;
        color: white;
        margin-bottom: 25px;
        
    }

    label {
        display: block;
        margin-bottom: 5px;
        color: #66fcf1;
        font-weight: bold;
    }

    input[type="text"],
    input[type="password"],
    select {
        width: 100%;
        padding: 10px;
        margin-bottom: 16px;
        border-radius: 5px;
        border: 1px solid #444;
        background-color: #1f1f2e;
        color: #fff;
        font-size: 14px;
        outline: none;
    }

    input:focus, select:focus {
        border-color: #00ffaa;
        box-shadow: 0 0 5px #00ffaa80;
    }

    button,
    a {
        padding: 10px 16px;
        font-size: 14px;
        border-radius: 6px;
        text-decoration: none;
        color: white;
        border: none;
        cursor: pointer;
        transition: 0.3s;
        margin-right: 8px;
        box-shadow: 0 0 8px rgba(86, 12, 245, 0.2);
    }

    button[type="submit"] {
        background-color: #00c896;
    }

    button[type="submit"]:hover {
        background-color: #00ffaa;
    }

    button[type="reset"] {
        background-color: #f39c12;
    }

    button[type="reset"]:hover {
        background-color: #f1c40f;
    }

    a {
        background-color: #34495e;
        display: inline-block;
        margin-top: 10px;
    }

    a:hover {
        background-color: #2c3e50;
    }

    @media screen and (max-width: 480px) {
        .form-container {
            padding: 20px;
        }

        button,
        a {
            display: block;
            width: 100%;
            margin-bottom: 10px;
        }
    }
</style>



</head>

<body>
    <div class="form-container">
        <h2>Daftar Akun Baru</h2>
        <form method="post" action="../public/index.php?action=create_user">
            <label>Username:</label>
            <input type="text" name="username" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <label>Nama Lengkap:</label>
            <input type="text" name="nama_lengkap">

            <label>Level:</label>
            <select name="level" required>
                <option value="admin">Admin</option>
                <option value="user">User</option>
                <option value="operator">Operator</option>
            </select>

            <button type="submit">Simpan</button>
            <button type="reset">Reset</button>
            <a href="index.php?action=akun">Batal</a>
        </form>
    </div>
</body>

</html>