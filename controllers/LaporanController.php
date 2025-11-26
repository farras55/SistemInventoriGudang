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
        $keyword = trim($_GET['barang'] ?? $_GET['search'] ?? '');
        $page = max(1, (int)($_GET['page'] ?? 1));
        $limit = 10;
        $offset = ($page - 1) * $limit;

        if ($keyword !== '') {
            $data = $this->model->getMutasiPaginated($limit, $offset, $keyword);
            $total = $this->model->count($keyword);
        } else {
            $data = $this->model->getMutasiPaginated($limit, $offset, '');
            $total = $this->model->count('');
        }

        $pages = (int) ceil($total / $limit);
        include __DIR__ . '/../views/laporan/mutasi.php';
    }
}

$controller = new LaporanController();
$controller->mutasi();
