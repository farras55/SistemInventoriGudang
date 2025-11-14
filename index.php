<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: views/auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Inventory Gudang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">Inventory Gudang</a>
        <span class="text-white">Halo, <?= $_SESSION['user'] ?></span>
        <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
    </div>
</nav>

<div class="container mt-5">

    <h3 class="text-center mb-4">Dashboard Sistem Inventory Gudang</h3>

    <div class="row g-3">

        <div class="col-md-3">
            <div class="card shadow-sm p-3 text-center">
                <h5>Master Barang</h5>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm p-3 text-center">
                <h5>Transaksi Masuk</h5>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm p-3 text-center">
                <h5>Transaksi Keluar</h5>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm p-3 text-center">
                <h5>Laporan Stok</h5>
            </div>
        </div>

    </div>

</div>

</body>
</html>
