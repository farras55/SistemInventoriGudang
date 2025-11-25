<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../views/auth/login.php");
    exit;
}

require_once __DIR__ . '/../models/LaporanModel.php';

class LaporanController {

    private $model;

    public function __construct() {
        $this->model = new LaporanModel();
    }

    public function mutasi() {
        $barang = trim($_GET['barang'] ?? '');

        if ($barang !== '') {
            $data = $this->model->getFilter($barang);
        } else {
            $data = $this->model->getMutasi();
        }

        include __DIR__ . '/../views/laporan/mutasi.php';
    }
}

$controller = new LaporanController();
$controller->mutasi();
