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
        $data = [
            'id_barang' => $_POST['id_barang'],
            'tanggal'   => $_POST['tanggal'],
            'jumlah'    => $_POST['jumlah']
        ];

        $this->model->store($data);
        header("Location: TransaksiKeluarController.php?action=index");
    }

    public function delete() {
        $id = $_GET['id'];
        $this->model->delete($id);
        header("Location: TransaksiKeluarController.php?action=index");
    }
}

$controller = new TransaksiKeluarController();
$action = $_GET['action'] ?? 'index';
$controller->$action();
