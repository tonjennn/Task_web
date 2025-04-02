<?php
session_start();
require 'config.php';

// Cek apakah yang mengakses adalah admin
if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "admin") {
    header("Location: profile.php");
    exit();
}

// Ambil daftar user dari database
$result = $conn->query("SELECT id, username, email, role FROM users");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Command Center - Dashboard Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body {
            display: flex; justify-content: center; align-items: center;
            height: 100vh; background: linear-gradient(135deg, #0f172a, #1e3a8a);
        }
        .dashboard-container {
            background: rgba(255, 255, 255, 0.1); padding: 40px; border-radius: 15px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.5);
            text-align: center; width: 80%; max-width: 900px;
            backdrop-filter: blur(10px);
        }
        h2 {
            margin-bottom: 30px; font-size: 30px; color: white;
            text-transform: uppercase; letter-spacing: 1px;
        }
        table {
            width: 100%; margin-top: 20px; border-collapse: collapse;
        }
        th, td {
            padding: 15px; border: 1px solid rgba(255, 255, 255, 0.3); text-align: center;
            color: white;
        }
        th {
            background-color: rgba(255, 255, 255, 0.2); font-weight: 600;
        }
        td {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .btn {
            padding: 10px 15px; border-radius: 20px; color: white; text-decoration: none; 
            display: inline-block; transition: 0.3s; font-weight: bold;
        }
        .btn-edit {
            background: #00c896; padding: 12px 20px; border-radius: 50px;
        }
        .btn-edit:hover {
            background: #009974;
        }
        .btn-delete {
            background: #ff4757; padding: 12px 20px; border-radius: 50px;
        }
        .btn-delete:hover {
            background: #e84118;
        }
        .btn-logout {
            margin-top: 20px; padding: 12px 20px; background: #ffcc00; color: black;
            font-weight: bold; text-decoration: none; border-radius: 50px; 
            display: inline-block; transition: background 0.3s;
        }
        .btn-logout:hover { background: #e6b800; }

        /* Responsiveness */
        @media (max-width: 768px) {
            .dashboard-container {
                width: 90%;
                padding: 20px;
            }
            table { font-size: 14px; }
            th, td { padding: 10px; }
        }
    </style>
</head>
<body>

    <div class="dashboard-container">
        <h2>Command Center</h2>
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Nama Pengguna</th>
                    <th>Email</th>
                    <th>Peran</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row["id"]; ?></td>
                    <td><?php echo $row["username"]; ?></td>
                    <td><?php echo $row["email"]; ?></td>
                    <td><?php echo ucfirst($row["role"]); ?></td>
                    <td>
                        <a href="edit_user.php?id=<?php echo $row["id"]; ?>" class="btn btn-edit">✏ Edit</a>
                        <?php if ($row["role"] !== "admin") { ?>
                            <a href="delete_user.php?id=<?php echo $row["id"]; ?>" class="btn btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">🗑 Hapus</a>
                        <?php } ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="logout.php" class="btn btn-logout">Logout</a>
    </div>

</body>
</html>
