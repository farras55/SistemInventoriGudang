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
        $_SESSION['user'] = $user['nama_lengkap'];
        header("Location: ../index.php");
    } else {
        header("Location: ../views/auth/login.php?error=Login gagal!");
    }
}
