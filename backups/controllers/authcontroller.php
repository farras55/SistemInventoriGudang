<?php
session_start();
include_once __DIR__ . '/../config/db.php';
include_once __DIR__ . '/../models/UserModel.php';

$userModel = new UserModel($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = $userModel->login($username, $password);

    if ($user) {
        // simpan seluruh info user ke session agar role dan fields lain tersedia
        $_SESSION['user'] = [
            'id_user' => $user['id_user'] ?? null,
            'username' => $user['username'] ?? null,
            'nama_lengkap' => $user['nama_lengkap'] ?? $user['username'] ?? null,
            'role' => $user['role'] ?? 'user',
            'email' => $user['email'] ?? null,
        ];
        header("Location: ../index.php");
    } else {
        header("Location: ../views/auth/login.php?error=Login gagal!");
    }
}
