<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require 'config.php'; // File koneksi database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $role = $_POST["role"]; // Mendapatkan nilai role dari form

    // Validasi jika password tidak cocok
    if ($password !== $confirm_password) {
        $error_message = "Password dan konfirmasi password harus sama!";
    } else {
        // Cek apakah username sudah ada
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error_message = "Username sudah digunakan, pilih username lain!";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Simpan user ke database
            $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $username, $email, $hashed_password, $role);

            if ($stmt->execute()) {
                $success_message = "Registrasi berhasil! Silakan <a href='login.php'>login</a>.";
            } else {
                $error_message = "Terjadi kesalahan, coba lagi!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #0f172a, #1e3a8a);
        }

        .container {
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 12px;
            text-align: center;
            width: 360px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
        }

        .avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: url('https://cdn-icons-png.flaticon.com/512/747/747376.png') no-repeat center;
            background-size: cover;
            margin: 0 auto 15px;
        }

        h2 {
            color: white;
            margin-bottom: 15px;
        }

        .message {
            font-size: 14px;
            margin-bottom: 10px;
            padding: 8px;
            border-radius: 5px;
        }

        .error {
            background-color: #ffdddd;
            color: #d8000c;
        }

        .success {
            background-color: #ddffdd;
            color: #4CAF50;
        }

        .input-container {
            position: relative;
            margin: 10px 0;
        }

        .input-container input,
        .input-container select {
            width: 100%;
            padding: 10px 40px;
            border: none;
            border-bottom: 2px solid rgba(255, 255, 255, 0.5);
            background: transparent;
            color: white;
            font-size: 16px;
            outline: none;
        }

        .input-container input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .input-container select {
            background-color: white;
            color: black; /* Warna teks hitam */
            border-radius: 5px;
            cursor: pointer;
        }

        .input-container select option {
            color: black; /* Warna teks dalam pilihan dropdown */
        }

        .input-container i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
        }

        .register-btn {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            border: none;
            border-radius: 50px;
            background: white;
            color: #333;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .register-btn:hover {
            background: #ddd;
        }

        .back-login {
            display: block;
            margin-top: 15px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            text-decoration: none;
        }

        .back-login:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="avatar"></div>
        <h2>Register</h2>

        <?php if (isset($error_message)): ?>
            <p class="message error"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <?php if (isset($success_message)): ?>
            <p class="message success"><?php echo $success_message; ?></p>
        <?php endif; ?>

        <form action="register.php" method="POST">
            <div class="input-container">
                <i>👤</i>
                <input type="text" name="username" placeholder="Username" required autocomplete="off">
            </div>

            <div class="input-container">
                <i>📧</i>
                <input type="email" name="email" placeholder="Email" required autocomplete="off">
            </div>

            <div class="input-container">
                <i>🔒</i>
                <input type="password" name="password" placeholder="Password" required autocomplete="new-password">
            </div>

            <div class="input-container">
                <i>🔑</i>
                <input type="password" name="confirm_password" placeholder="Konfirmasi Password" required autocomplete="new-password">
            </div>

            <div class="input-container">
                <i>⚡</i>
                <select name="role" required>
                    <option value="" disabled selected>Pilih Role</option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <button class="register-btn" type="submit">DAFTAR</button>

            <a href="login.php" class="back-login">Sudah punya akun? Login</a>
        </form>
    </div>
</body>
</html>


