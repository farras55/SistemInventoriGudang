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

    // paginated + search
    public function getAllPaginated(int $limit, int $offset, string $keyword = "") {
        $sql = "SELECT * FROM gudang
                WHERE (nama_gudang ILIKE :kw OR lokasi ILIKE :kw)
                ORDER BY id_gudang DESC
                LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':kw', "%$keyword%", PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function count(string $keyword = "") {
        $sql = "SELECT COUNT(*) FROM gudang WHERE (nama_gudang ILIKE :kw OR lokasi ILIKE :kw)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':kw', "%$keyword%", PDO::PARAM_STR);
        $stmt->execute();
        return (int) $stmt->fetchColumn();
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
