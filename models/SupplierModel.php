<?php
require_once __DIR__ . '/../config/db.php';

class SupplierModel {

    private $db;

    public function __construct() {
        global $pdo;        
        $this->db = $pdo;
    }

    public function getAll() {
        $sql = "SELECT * FROM supplier ORDER BY id_supplier DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function getAllPaginated(int $limit, int $offset, string $keyword = "") {
        $sql = "SELECT * FROM supplier
            WHERE (nama_supplier ILIKE :kw
                   OR kontak ILIKE :kw
                   OR alamat ILIKE :kw
                   OR email ILIKE :kw)
            ORDER BY id_supplier DESC
            LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':kw', "%$keyword%", PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function count(string $keyword = "") {
        $sql = "SELECT COUNT(*) FROM supplier
            WHERE (nama_supplier ILIKE :kw
                   OR kontak ILIKE :kw
                   OR alamat ILIKE :kw
                   OR email ILIKE :kw)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':kw', "%$keyword%", PDO::PARAM_STR);
        $stmt->execute();
        return (int) $stmt->fetchColumn();
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
