<?php
require 'config.php';

$username = 'admin';
$password = password_hash('admin123', PASSWORD_DEFAULT); // Enkripsi password
$role = 'admin';

$stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
$stmt->execute([$username, $password, $role]);

echo "Akun admin berhasil ditambahkan!";
?>
