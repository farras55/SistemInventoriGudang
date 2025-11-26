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

    /**
     * Tampilkan materialized view ringkasan stok.
     */
    public function stokRingkasan() {
        $data = $this->model->getStokRingkasan();
        $title = "Ringkasan Stok (Materialized)";
        include __DIR__ . '/../views/laporan/stok_ringkasan.php';
    }

    /**
     * Refresh materialized view. POST action.
     */
    public function refreshMv() {
        // hanya izinkan POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: LaporanController.php?action=stokRingkasan");
            exit;
        }


        $ok = $this->model->refreshMaterialized();
        if ($ok) {
            $_SESSION['flash_success'] = 'Materialized view berhasil di-refresh.';
        } else {
            $_SESSION['flash_error'] = 'Gagal mereset materialized view. Periksa log server atau hak akses DB.';
        }

        header("Location: LaporanController.php?action=stokRingkasan");
        exit;
    }
}

$controller = new LaporanController();
$action = $_GET['action'] ?? $_POST['action'] ?? 'mutasi';
if (method_exists($controller, $action)) {
    $controller->$action();
} else {
    $controller->mutasi();
}
