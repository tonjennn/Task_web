<?php
session_start();
require 'config.php'; // Pastikan file ini memiliki koneksi database yang benar

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    // Ambil user dari database
    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["username"] = $user["username"];
        $_SESSION["role"] = $user["role"];

        // Redirect berdasarkan role
        if ($user["role"] == "admin") {
            header("Location: dashboard.php"); // Admin ke dashboard
        } else {
            header("Location: profile.php"); // User biasa ke profile
        }
        exit();
    } else {
        echo "<script>alert('Username atau password salah!'); window.location='login.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            background: url('https://cdn-icons-png.flaticon.com/512/847/847969.png') no-repeat center;
            background-size: cover;
            margin: 0 auto 15px;
        }

        h2 {
            color: white;
            margin-bottom: 15px;
        }

        .input-container {
            position: relative;
            margin: 10px 0;
        }

        .input-container input {
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

        .input-container i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
        }

        .login-btn {
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

        .login-btn:hover {
            background: #ddd;
        }

        .forgot-password {
            display: block;
            text-align: right;
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            margin-top: 8px;
            text-decoration: none;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .register-btn {
            margin-top: 20px;
            padding: 12px;
            width: 100%;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            border: none;
        }

        .register-btn:hover {
            background: rgba(255, 255, 255, 0.4);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="avatar"></div>
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <div class="input-container">
                <i>📧</i>
                <input type="text" name="username" placeholder="Email ID" required>
            </div>
            <div class="input-container">
                <i>🔒</i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button class="login-btn" type="submit">LOGIN</button>
            <a href="#" class="forgot-password">Forgot Password?</a>
        </form>

        <!-- Hanya tombol REGISTER tanpa link -->
        <button class="register-btn" onclick="window.location.href='register.php'">REGISTER</button>
    </div>
</body>
</html>

