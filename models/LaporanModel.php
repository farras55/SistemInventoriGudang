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
}
