<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../views/auth/login.php");
    exit;
}
require_once __DIR__ . '/../config/db.php'; // harus membuat $pdo di file ini
require_once __DIR__ . '/../models/KategoriModel.php';

$model = new KategoriModel($pdo);

// simple router by action param
$action = $_GET['action'] ?? 'index';

if ($action === 'index') {
    $keyword = trim($_GET['search'] ?? '');
    $page = max(1, (int)($_GET['page'] ?? 1));
    $limit = 10;
    $offset = ($page - 1) * $limit;

    $data = $model->getAll($limit, $offset, $keyword);
    $total = $model->count($keyword);
    $pages = (int) ceil($total / $limit);

    include __DIR__ . '/../views/kategori/index.php';
    exit;
}

if ($action === 'create') {
    include __DIR__ . '/../views/kategori/create.php';
    exit;
}

if ($action === 'store' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // server-side validation
    $nama = trim($_POST['nama'] ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');

    if ($nama === '' || strlen($nama) < 3) {
        // redirect back with error
        header("Location: KategoriController.php?action=create&error=" . urlencode("Nama kategori minimal 3 karakter"));
        exit;
    }

    $ok = $model->create($nama, $deskripsi);
    header("Location: KategoriController.php?action=index");
    exit;
}

if ($action === 'edit') {
    $id = (int)($_GET['id'] ?? 0);
    if ($id <= 0) {
        header("Location: KategoriController.php?action=index");
        exit;
    }
    $kategori = $model->find($id);
    if (!$kategori) {
        header("Location: KategoriController.php?action=index");
        exit;
    }
    include __DIR__ . '/../views/kategori/edit.php';
    exit;
}

if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $nama = trim($_POST['nama'] ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');

    if ($id <= 0 || $nama === '' || strlen($nama) < 3) {
        header("Location: KategoriController.php?action=edit&id=" . $id . "&error=" . urlencode("Validasi gagal"));
        exit;
    }

    $model->update($id, $nama, $deskripsi);
    header("Location: KategoriController.php?action=index");
    exit;
}

if ($action === 'delete') {
    $id = (int)($_GET['id'] ?? 0);
    if ($id > 0) {
        $model->delete($id);
    }
    header("Location: KategoriController.php?action=index");
    exit;
}

// default
header("Location: KategoriController.php?action=index");
exit;
