<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? "Sistem Inventory Gudang" ?></title>

    <link rel="stylesheet" href="/../style.css">
</head>

<body>

<!-- SIDEBAR -->
<?php include __DIR__ . '/sidebar.php'; ?>

<!-- HEADER ATAS -->
<header class="top-header">
    <h1><?= $title ?? "Sistem Inventory Gudang" ?></h1>
</header>

<!-- AREA KONTEN -->
<main class="content">
