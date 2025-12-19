<?php

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../views/auth/login.php");
    exit;
}

require_once __DIR__ . '/../models/DashboardModel.php';

class DashboardController
{
    private $model;

    public function __construct()
    {
        $this->model = new DashboardModel();
    }

    public function index()
    {
        
        $counts = $this->model->getCounts();

        
        $barangMenipis    = $this->model->getBarangMenipisTop(5);
        $slowMoving       = $this->model->getSlowMovingTop(5);
        $transaksiTerbaru = $this->model->getTransaksiTerbaru(10);

        
        $title = "Dashboard";

        include __DIR__ . '/../views/dashboard/index.php';
    }
}


$controller = new DashboardController();
$action = $_GET['action'] ?? 'index';

if (method_exists($controller, $action)) {
    $controller->$action();
} else {
    $controller->index();
}
