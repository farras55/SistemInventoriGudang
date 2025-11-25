<?php
require_once __DIR__ . '/../config/db.php';

class TransaksiMasukModel {

    private $db;

    public function __construct() {
        global $pdo;
        $this->db = $pdo;
    }

    public function getAll() {
        $sql = "SELECT tm.*, b.nama_barang 
                FROM transaksi_masuk tm
                JOIN barang b ON tm.id_barang = b.id_barang
                ORDER BY tm.id_trans_masuk DESC";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBarang() {
        return $this->db->query("SELECT * FROM barang ORDER BY nama_barang")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function store($id_barang, $jumlah, $no_po) {

        try {
            $this->db->beginTransaction();

            // 1. simpan transaksi masuk
            $sql = "INSERT INTO transaksi_masuk (id_barang, jumlah, no_po)
                    VALUES (:id_barang, :jumlah, :no_po)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'id_barang' => $id_barang,
                'jumlah'    => $jumlah,
                'no_po'     => $no_po
            ]);

            // 2. update stok barang
            $sql2 = "UPDATE barang 
                     SET stok = stok + :jumlah,
                         tanggal_update = NOW()
                     WHERE id_barang = :id_barang";
            $stmt2 = $this->db->prepare($sql2);
            $stmt2->execute([
                'id_barang' => $id_barang,
                'jumlah'    => $jumlah
            ]);

            $this->db->commit();
            return true;

        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
}
