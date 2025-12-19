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

    
    public function stokRingkasan() {
        $data = $this->model->getStokRingkasan();
        $title = "Ringkasan Stok (Materialized)";
        include __DIR__ . '/../views/laporan/stok_ringkasan.php';
    }

    
    public function refreshMv() {
        
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


    public function stokOpname() {
        $keyword    = trim($_GET['search'] ?? '');
        $id_gudang  = $_GET['gudang'] ?? '';
        $id_kategori= $_GET['kategori'] ?? '';

        $page  = max(1, (int)($_GET['page'] ?? 1));
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $data = $this->model->getStokOpnamePaginated(
            $limit,
            $offset,
            $keyword,
            $id_gudang ? (int)$id_gudang : null,
            $id_kategori ? (int)$id_kategori : null
        );

        $total = $this->model->countStokOpname(
            $keyword,
            $id_gudang ? (int)$id_gudang : null,
            $id_kategori ? (int)$id_kategori : null
        );

        $pages = (int) ceil($total / $limit);

        
        $gudang   = $this->model->getAllGudang();
        $kategori = $this->model->getAllKategori();

        $title = "Laporan Stok Opname";

        include __DIR__ . '/../views/laporan/stok_opname.php';
    }




    public function slowMoving()
    {
        $keyword = trim($_GET['search'] ?? '');
        $page    = max(1, (int)($_GET['page'] ?? 1));
        $limit   = 10;
        $offset  = ($page - 1) * $limit;

        $data = $this->model->getSlowMovingPaginated($limit, $offset, $keyword);
        $total = $this->model->countSlowMoving($keyword);
        $pages = (int) ceil($total / $limit);

        $title = "Laporan Barang Slow Moving";
        include __DIR__ . '/../views/laporan/slow_moving.php';
    }


}

$controller = new LaporanController();
$action = $_GET['action'] ?? $_POST['action'] ?? 'mutasi';
if (method_exists($controller, $action)) {
    $controller->$action();
} else {
    $controller->mutasi();
}
