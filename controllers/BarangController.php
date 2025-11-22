<?php
require_once __DIR__ . '/../models/BarangModel.php';

class BarangController {

    private $model;

    public function __construct() {
        $this->model = new BarangModel();
    }

    public function index() {
        $data = $this->model->getAll();
        include __DIR__ . '/../views/barang/index.php';
    }

    public function create() {
        $kategori = $this->model->getKategori();
        $supplier = $this->model->getSupplier();
        $gudang   = $this->model->getGudang();
        include __DIR__ . '/../views/barang/create.php';
    }

    public function store() {
        $data = [
            'nama'     => $_POST['nama'],
            'kategori' => $_POST['kategori'],
            'supplier' => $_POST['supplier'],
            'gudang'   => $_POST['gudang'],
            'stok'     => $_POST['stok'],
            'minstok'  => $_POST['minstok'],
            'harga_satuan'    => $_POST['harga_satuan'],
            'ket'      => $_POST['ket']
        ];

        $this->model->store($data);
        header("Location: BarangController.php?action=index");
    }

    public function edit() {
        $id = $_GET['id'];
        $barang  = $this->model->getById($id);

        $kategori = $this->model->getKategori();
        $supplier = $this->model->getSupplier();
        $gudang   = $this->model->getGudang();

        include __DIR__ . '/../views/barang/edit.php';
    }

    public function update() {
        $id = $_POST['id'];

        $data = [
            'nama'     => $_POST['nama'],
            'kategori' => $_POST['kategori'],
            'supplier' => $_POST['supplier'],
            'gudang'   => $_POST['gudang'],
            'stok'     => $_POST['stok'],
            'minstok'   => $_POST['minstok'],
            'harga_satuan'    => $_POST['harga_satuan'],
            'ket'      => $_POST['ket']
        ];

        $this->model->update($id, $data);
        header("Location: BarangController.php?action=index");
    }

    public function delete() {
        $id = $_GET['id'];
        $this->model->delete($id);
        header("Location: BarangController.php?action=index");
    }
}

$controller = new BarangController();
$action = $_GET['action'] ?? 'index';
$controller->$action();
