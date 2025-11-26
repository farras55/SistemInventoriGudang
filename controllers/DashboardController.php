<?php
// controllers/DashboardController.php

session_start();

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/DashboardModel.php';

class DashboardController
{
    private $model;

    public function __construct(PDO $db)
    {
        $this->model = new DashboardModel($db);
    }

    public function index(): void
    {
        // cek sudah login atau belum
        if (!isset($_SESSION['user'])) {
            // path relatif dari controllers ke views
            header("Location: ../views/auth/login.php");
            exit;
        }

        // panggil FUNCTION total_stok_barang() lewat model
        $totalStok = $this->model->getTotalStok();
        // data tambahan untuk tampilan
        $totalItems = $this->model->getTotalItems();
        $lowStockCount = $this->model->getLowStockCount();

        // judul halaman
        $title = "Dashboard";

        // load view
        include __DIR__ . '/../views/dashboard/index.php';
    }
}

// simple router di file ini
$action = $_GET['action'] ?? 'index';

$controller = new DashboardController($pdo);

if (method_exists($controller, $action)) {
    $controller->$action();
} else {
    // fallback kalau action tidak ada
    $controller->index();
}
