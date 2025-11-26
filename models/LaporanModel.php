<?php
require_once __DIR__ . '/../config/db.php';

class LaporanModel {

    private $db;

    public function __construct() {
        global $pdo;
        $this->db = $pdo;
    }

    public function getMutasi() {
        $sql = "SELECT * FROM v_laporan_mutasi ORDER BY nama_barang ASC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFilter($barang) {
        $sql = "SELECT * FROM v_laporan_mutasi WHERE nama_barang ILIKE :b ORDER BY nama_barang ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['b' => "%$barang%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // paginated version
    public function getMutasiPaginated(int $limit, int $offset, string $keyword = "") {
        $sql = "SELECT * FROM v_laporan_mutasi WHERE nama_barang ILIKE :k ORDER BY nama_barang ASC LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':k', "%$keyword%", PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function count(string $keyword = "") {
        $sql = "SELECT COUNT(*) FROM v_laporan_mutasi WHERE nama_barang ILIKE :k";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':k', "%$keyword%", PDO::PARAM_STR);
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }
    
}
