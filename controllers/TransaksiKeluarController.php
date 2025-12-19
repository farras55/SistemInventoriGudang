<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../views/auth/login.php");
    exit;
}

require_once __DIR__ . '/../models/TransaksiKeluarModel.php';

class TransaksiKeluarController {

    private $model;

    public function __construct() {
        $this->model = new TransaksiKeluarModel();
    }

    public function index() {
        $keyword = trim($_GET['search'] ?? '');
        $page = max(1, (int)($_GET['page'] ?? 1));
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $data = $this->model->getAllPaginated($limit, $offset, $keyword);
        $total = $this->model->count($keyword);
        $pages = (int) ceil($total / $limit);

        include __DIR__ . '/../views/trans_keluar/index.php';
    }

    public function create() {
        $barang = $this->model->getBarang();
        include __DIR__ . '/../views/trans_keluar/create.php';
    }

    public function store() {
        $id_barang = $_POST['id_barang'] ?? null;
        $tanggal   = $_POST['tanggal'] ?? date('Y-m-d');
        $jumlah    = (int)($_POST['jumlah'] ?? 0);

        if (empty($id_barang) || $jumlah <= 0) {
            header("Location: TransaksiKeluarController.php?action=create&error=" . urlencode("Barang & jumlah wajib diisi (jumlah > 0)."));
            exit;
        }

        $result = $this->model->store([
            'id_barang' => $id_barang,
            'tanggal'   => $tanggal,
            'jumlah'    => $jumlah
        ]);

        if ($result === true) {
            header("Location: TransaksiKeluarController.php?action=index&success=" . urlencode("Transaksi keluar berhasil disimpan."));
            exit;
        }

        
        $msg = (string)$result;
        
        if (stripos($msg, 'Stok barang tidak mencukupi') !== false) {
            $msg = "Stok barang tidak mencukupi!";
        }
        header("Location: TransaksiKeluarController.php?action=create&error=" . urlencode($msg));
        exit;
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        if (empty($id)) {
            header("Location: TransaksiKeluarController.php?action=index&error=" . urlencode("ID transaksi tidak valid."));
            exit;
        }

        $result = $this->model->delete($id);

        if ($result === true) {
            header("Location: TransaksiKeluarController.php?action=index&success=" . urlencode("Transaksi keluar berhasil dihapus."));
            exit;
        }

        header("Location: TransaksiKeluarController.php?action=index&error=" . urlencode((string)$result));
        exit;
    }

}

$controller = new TransaksiKeluarController();
$action = $_GET['action'] ?? 'index';
$controller->$action();
