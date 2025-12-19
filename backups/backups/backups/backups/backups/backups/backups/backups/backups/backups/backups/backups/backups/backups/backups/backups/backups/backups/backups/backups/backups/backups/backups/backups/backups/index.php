<?php
// index.php
// Pintu masuk utama aplikasi.
// Tidak ada logika bisnis di sini, hanya mengarahkan ke controller.

session_start();

// Jika belum login, arahkan ke halaman login
if (!isset($_SESSION['user'])) {
    header("Location: views/auth/login.php");
    exit;
}

// Jika sudah login, arahkan ke DashboardController
header("Location: controllers/DashboardController.php?action=index");
exit;
