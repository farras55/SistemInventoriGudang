<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../views/auth/login.php");
    exit;
}
require_once __DIR__ . '/../models/SupplierModel.php';

class SupplierController {

    private $model;

    public function __construct() {
        $this->model = new SupplierModel();
    }

    public function index() {
        $data = $this->model->getAll();
        include __DIR__ . '/../views/supplier/index.php';
    }

    public function create() {
        include __DIR__ . '/../views/supplier/create.php';
    }

    public function store() {
        $nama   = $_POST['nama'];
        $kontak = $_POST['kontak'];
        $alamat = $_POST['alamat'];
        $email  = $_POST['email'];

        if ($this->model->store($nama, $kontak, $alamat, $email)) {
            header("Location: SupplierController.php?action=index");
        } else {
            header("Location: SupplierController.php?action=create&error=Gagal menambah supplier");
        }
    }

    public function edit() {
        $id = $_GET['id'];
        $supplier = $this->model->getById($id);
        include __DIR__ . '/../views/supplier/edit.php';
    }

    public function update() {
        $id     = $_POST['id'];
        $nama   = $_POST['nama'];
        $kontak = $_POST['kontak'];
        $alamat = $_POST['alamat'];
        $email  = $_POST['email'];

        if ($this->model->update($id, $nama, $kontak, $alamat, $email)) {
            header("Location: SupplierController.php?action=index");
        } else {
            header("Location: SupplierController.php?action=edit&id=$id&error=Gagal update supplier");
        }
    }

    public function delete() {
        $id = $_GET['id'];
        $this->model->delete($id);
        header("Location: SupplierController.php?action=index");
    }
}

$controller = new SupplierController();

$action = $_GET['action'] ?? 'index';
$controller->$action();
