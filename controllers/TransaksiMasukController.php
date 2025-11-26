<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../views/auth/login.php");
    exit;
}

require_once __DIR__ . '/../models/TransaksiMasukModel.php';

class TransaksiMasukController {

    private $model;

    public function __construct() {
        $this->model = new TransaksiMasukModel();
    }

    public function index() {
        $keyword = trim($_GET['search'] ?? '');
        $page = max(1, (int)($_GET['page'] ?? 1));
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $data = $this->model->getAllPaginated($limit, $offset, $keyword);
        $total = $this->model->count($keyword);
        $pages = (int) ceil($total / $limit);

        include __DIR__ . '/../views/transaksi_masuk/index.php';
    }

    public function create() {
        $barang = $this->model->getBarang();
        include __DIR__ . '/../views/transaksi_masuk/create.php';
    }

    public function store() {
        $id_barang = $_POST['id_barang'];
        $jumlah    = $_POST['jumlah'];
        $no_po     = $_POST['no_po'];

        if ($jumlah <= 0) {
            header("Location: TransaksiMasukController.php?action=create&error=Jumlah tidak valid!");
            exit;
        }

        $ok = $this->model->store($id_barang, $jumlah, $no_po);

        if ($ok) {
            header("Location: TransaksiMasukController.php?action=index&success=Berhasil menambah stok");
        } else {
            header("Location: TransaksiMasukController.php?action=create&error=Gagal menyimpan transaksi");
        }
    }
}

$controller = new TransaksiMasukController();
$action = $_GET['action'] ?? 'index';
$controller->$action();
