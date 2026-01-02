<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
       <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(to right, #e3f2fd, #ffffff);
        background-image: url(''); /* opsional background apotek */
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .form-container {
        background-color: #ffffffef;
        padding: 40px 45px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 123, 255, 0.2);
        max-width: 430px;
        width: 100%;
        border-top: 6px solid #2196f3;
        position: relative;
    }

    .form-container::before {
        content: "💊";
        font-size: 60px;
        color: #64b5f6;
        position: absolute;
        top: -30px;
        right: -20px;
        opacity: 0.08;
        transform: rotate(-10deg);
    }

    h2 {
        text-align: center;
        margin-bottom: 30px;
        color: #1565c0;
        font-weight: 600;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #0d47a1;
    }

    input[type="text"],
    input[type="password"],
    input[type="number"],
    input[type="date"],
    select {
        width: 100%;
        padding: 12px 15px;
        margin-bottom: 20px;
        border-radius: 8px;
        border: 1.5px solid #90caf9;
        background-color: #f4faff;
        color: #0d47a1;
        font-size: 15px;
        transition: 0.3s;
    }

    input:focus,
    select:focus {
        border-color: #42a5f5;
        outline: none;
        box-shadow: 0 0 6px #90caf9;
    }

    button[type="submit"] {
        width: 100%;
        padding: 12px;
        background-color: #1976d2;
        color: white;
        font-size: 16px;
        font-weight: bold;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    button[type="submit"]:hover {
        background-color: #42a5f5;
        transform: scale(1.03);
        box-shadow: 0 0 10px rgba(66, 165, 245, 0.5);
    }

    a.back {
        display: inline-block;
        margin-top: 16px;
        text-decoration: none;
        color: #1976d2;
        font-weight: 600;
        transition: color 0.3s;
    }

    a.back:hover {
        color: #0d47a1;
        text-decoration: underline;
    }

    .error-message {
        color: #c62828;
        background-color: #fce4ec;
        padding: 10px;
        border-left: 4px solid #ef5350;
        margin-bottom: 15px;
        border-radius: 4px;
        text-align: center;
    }

    @media (max-width: 480px) {
        .form-container {
            padding: 30px 25px;
        }
    }
</style>

</head>

<body>
    <div class="form-container">
        <h2>Login</h2>
        <?php if (!empty($error)) echo "<p class='error-message'>" . htmlspecialchars($error) . "</p>"; ?>
        <form method="post" action="../public/index.php?action=login">
            <label>Username:</label>
            <input type="text" name="username" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>