<?php
require_once __DIR__ . '/../config/db.php';

class TransaksiKeluarModel {

    private $db;

    public function __construct() {
        global $pdo;
        $this->db = $pdo;
    }

    public function getAll() {
        $sql = "SELECT tk.*, b.nama_barang 
                FROM transaksi_keluar tk
                JOIN barang b ON tk.id_barang = b.id_barang
                ORDER BY tk.id_trans_keluar DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function store($data) {
        try {
            // begin transaction
            $this->db->beginTransaction();

            // kurangi stok barang
            $stmt1 = $this->db->prepare("
                UPDATE barang 
                SET stok = stok - :jumlah, tanggal_update = NOW()
                WHERE id_barang = :id_barang
            ");

            $stmt1->execute([
                'jumlah'    => $data['jumlah'],
                'id_barang' => $data['id_barang']
            ]);

            // insert transaksi
            $stmt2 = $this->db->prepare("
                INSERT INTO transaksi_keluar (id_barang, tanggal, jumlah)
                VALUES (:id_barang, :tanggal, :jumlah)
            ");

            $stmt2->execute([
                'id_barang' => $data['id_barang'],
                'tanggal'   => $data['tanggal'],
                'jumlah'    => $data['jumlah']
            ]);

            // commit
            $this->db->commit();
            return true;

        } catch (PDOException $e) {
            $this->db->rollBack();
            return $e->getMessage(); // kirim ke controller
        }
    }


    public function delete($id) {
        try {
            $this->db->beginTransaction();

            // Ambil data transaksi
            $stmt1 = $this->db->prepare("
                SELECT id_barang, jumlah 
                FROM transaksi_keluar 
                WHERE id_trans_keluar = :id
            ");
            $stmt1->execute(['id' => $id]);
            $trans = $stmt1->fetch(PDO::FETCH_ASSOC);

            if (!$trans) {
                throw new Exception("Data transaksi tidak ditemukan!");
            }

            $id_barang = $trans['id_barang'];
            $jumlah    = $trans['jumlah'];

            // Kembalikan stok ke tabel barang
            $stmt2 = $this->db->prepare("
                UPDATE barang 
                SET stok = stok + :jumlah, tanggal_update = NOW()
                WHERE id_barang = :id_barang
            ");
            $stmt2->execute([
                'jumlah'    => $jumlah,
                'id_barang' => $id_barang
            ]);

            // Hapus transaksi keluar
            $stmt3 = $this->db->prepare("
                DELETE FROM transaksi_keluar WHERE id_trans_keluar = :id
            ");
            $stmt3->execute(['id' => $id]);

            $this->db->commit();
            return true;

        } catch (Exception $e) {
            $this->db->rollBack();
            return $e->getMessage();
        }
    }


    public function getBarang() {
        return $this->db->query("SELECT * FROM barang ORDER BY nama_barang ASC")->fetchAll(PDO::FETCH_ASSOC);
    }
}
