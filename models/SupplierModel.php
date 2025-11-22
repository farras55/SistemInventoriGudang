<?php
require_once __DIR__ . '/../config/db.php';

class SupplierModel {

    private $db;

    public function __construct() {
        global $pdo;        // ← ambil variabel dari db.php
        $this->db = $pdo;
    }

    public function getAll() {
        $sql = "SELECT * FROM supplier ORDER BY id_supplier DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT * FROM supplier WHERE id_supplier = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function store($nama, $kontak, $alamat, $email) {
        $sql = "INSERT INTO supplier (nama_supplier, kontak, alamat, email)
                VALUES (:nama, :kontak, :alamat, :email)";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'nama'   => $nama,
            'kontak' => $kontak,
            'alamat' => $alamat,
            'email'  => $email
        ]);
    }

    public function update($id, $nama, $kontak, $alamat, $email) {
        $sql = "UPDATE supplier SET nama_supplier = :nama,
                kontak = :kontak, alamat = :alamat, email = :email
                WHERE id_supplier = :id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id'     => $id,
            'nama'   => $nama,
            'kontak' => $kontak,
            'alamat' => $alamat,
            'email'  => $email
        ]);
    }

    public function delete($id) {
        $sql = "DELETE FROM supplier WHERE id_supplier = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
