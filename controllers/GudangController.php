<?php
require_once __DIR__ . '/../models/GudangModel.php';

class GudangController {

    private $model;

    public function __construct() {
        $this->model = new GudangModel();
    }

    public function index() {
        $data = $this->model->getAll();
        include __DIR__ . '/../views/gudang/index.php';
    }

    public function create() {
        include __DIR__ . '/../views/gudang/create.php';
    }

    public function store() {
        $nama   = $_POST['nama'];
        $lokasi = $_POST['lokasi'];

        if ($this->model->store($nama, $lokasi)) {
            header("Location: GudangController.php?action=index");
        } else {
            header("Location: GudangController.php?action=create&error=Gagal menambah gudang");
        }
    }

    public function edit() {
        $id = $_GET['id'];
        $gudang = $this->model->getById($id);
        include __DIR__ . '/../views/gudang/edit.php';
    }

    public function update() {
        $id     = $_POST['id'];
        $nama   = $_POST['nama'];
        $lokasi = $_POST['lokasi'];

        if ($this->model->update($id, $nama, $lokasi)) {
            header("Location: GudangController.php?action=index");
        } else {
            header("Location: GudangController.php?action=edit&id=$id&error=Gagal update gudang");
        }
    }

    public function delete() {
        $id = $_GET['id'];
        $this->model->delete($id);
        header("Location: GudangController.php?action=index");
    }
}

$controller = new GudangController();
$action = $_GET['action'] ?? 'index';
$controller->$action();
