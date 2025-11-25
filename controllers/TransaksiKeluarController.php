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
        $data = $this->model->getAll();
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
