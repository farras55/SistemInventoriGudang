<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../views/auth/login.php");
    exit;
}

require_once __DIR__ . '/../models/BarangModel.php';

class BarangController
{
    private $model;

    public function __construct()
    {
        $this->model = new BarangModel();
    }

    
    public function index()
    {
        
        $keyword     = trim($_GET['search'] ?? '');
        $id_kategori = $_GET['kategori'] ?? '';
        $id_supplier = $_GET['supplier'] ?? '';
        $id_gudang   = $_GET['gudang'] ?? '';

        $page  = max(1, (int)($_GET['page'] ?? 1));
        $limit = 10;
        $offset = ($page - 1) * $limit;

        
        $data = $this->model->getFilteredPaginated(
            $limit,
            $offset,
            $keyword,
            $id_kategori ? (int)$id_kategori : null,
            $id_supplier ? (int)$id_supplier : null,
            $id_gudang   ? (int)$id_gudang   : null
        );

        $total = $this->model->countFiltered(
            $keyword,
            $id_kategori ? (int)$id_kategori : null,
            $id_supplier ? (int)$id_supplier : null,
            $id_gudang   ? (int)$id_gudang   : null
        );

        $pages = (int) ceil($total / $limit);

        
        $kategori = $this->model->getKategori();
        $supplier = $this->model->getSupplier();
        $gudang   = $this->model->getGudang();

        
        include __DIR__ . '/../views/barang/index.php';
    }

    public function create()
    {
        $kategori = $this->model->getKategori();
        $supplier = $this->model->getSupplier();
        $gudang   = $this->model->getGudang();

        include __DIR__ . '/../views/barang/create.php';
    }

    public function store()
    {
        $data = [
            'nama'         => $_POST['nama'],
            'kategori'     => $_POST['kategori'],
            'supplier'     => $_POST['supplier'],
            'gudang'       => $_POST['gudang'],
            'stok'         => $_POST['stok'],
            'minstok'      => $_POST['minstok'],
            'harga_satuan' => $_POST['harga_satuan'],
            'ket'          => $_POST['ket']
        ];

        $this->model->store($data);
        header("Location: BarangController.php?action=index");
        exit;
    }

    public function edit()
    {
        $id      = $_GET['id'];
        $barang  = $this->model->getById($id);
        $kategori = $this->model->getKategori();
        $supplier = $this->model->getSupplier();
        $gudang   = $this->model->getGudang();

        include __DIR__ . '/../views/barang/edit.php';
    }

    public function update()
    {
        $id = $_POST['id'];

        $data = [
            'nama'         => $_POST['nama'],
            'kategori'     => $_POST['kategori'],
            'supplier'     => $_POST['supplier'],
            'gudang'       => $_POST['gudang'],
            'stok'         => $_POST['stok'],
            'minstok'      => $_POST['minstok'],
            'harga_satuan' => $_POST['harga_satuan'],
            'ket'          => $_POST['ket']
        ];

        $this->model->update($id, $data);
        header("Location: BarangController.php?action=index");
        exit;
    }

    public function delete()
    {
        $id = $_GET['id'];
        $this->model->delete($id);
        header("Location: BarangController.php?action=index");
        exit;
    }
}


$controller = new BarangController();
$action = $_GET['action'] ?? 'index';

if (method_exists($controller, $action)) {
    $controller->$action();
} else {
    
    $controller->index();
}
