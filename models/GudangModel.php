<?php
require_once __DIR__ . '/../config/db.php';

class GudangModel {

    private $db;

    public function __construct() {
        global $pdo;
        $this->db = $pdo;
    }

    public function getAll() {
        $sql = "SELECT * FROM gudang ORDER BY id_gudang DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT * FROM gudang WHERE id_gudang = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function store($nama, $lokasi) {
        $sql = "INSERT INTO gudang (nama_gudang, lokasi)
                VALUES (:nama, :lokasi)";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'nama' => $nama,
            'lokasi' => $lokasi
        ]);
    }

    public function update($id, $nama, $lokasi) {
        $sql = "UPDATE gudang 
                SET nama_gudang = :nama, lokasi = :lokasi
                WHERE id_gudang = :id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'nama' => $nama,
            'lokasi' => $lokasi
        ]);
    }

    public function delete($id) {
        $sql = "DELETE FROM gudang WHERE id_gudang = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
