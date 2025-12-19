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

    
    public function getAllPaginated(int $limit, int $offset, string $keyword = "") {
        $sql = "SELECT tk.*, b.nama_barang 
            FROM transaksi_keluar tk
            JOIN barang b ON tk.id_barang = b.id_barang
            WHERE (b.nama_barang ILIKE :kw
                   OR CAST(tk.jumlah AS TEXT) ILIKE :kw
                   OR CAST(tk.tanggal AS TEXT) ILIKE :kw)
            ORDER BY tk.id_trans_keluar DESC
            LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':kw', "%$keyword%", PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function count(string $keyword = "") {
        $sql = "SELECT COUNT(*) FROM transaksi_keluar tk JOIN barang b ON tk.id_barang = b.id_barang
            WHERE (b.nama_barang ILIKE :kw
                   OR CAST(tk.jumlah AS TEXT) ILIKE :kw
                   OR CAST(tk.tanggal AS TEXT) ILIKE :kw)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':kw', "%$keyword%", PDO::PARAM_STR);
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    public function store($data) {
        try {
            $this->db->beginTransaction();

            $stmt2 = $this->db->prepare("
                INSERT INTO transaksi_keluar (id_barang, tanggal, jumlah)
                VALUES (:id_barang, :tanggal, :jumlah)
            ");
            $stmt2->execute([
                'id_barang' => $data['id_barang'],
                'tanggal'   => $data['tanggal'],
                'jumlah'    => $data['jumlah']
            ]);

            $stmt1 = $this->db->prepare("
                UPDATE barang 
                SET stok = stok - :jumlah, tanggal_update = NOW()
                WHERE id_barang = :id_barang
            ");
            $stmt1->execute([
                'jumlah'    => $data['jumlah'],
                'id_barang' => $data['id_barang']
            ]);

            $this->db->commit();
            return true;

        } catch (PDOException $e) {
            $this->db->rollBack();
            return $e->getMessage();
        }
    }



    public function delete($id) {
        try {
            $this->db->beginTransaction();

            
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

            
            $stmt2 = $this->db->prepare("
                UPDATE barang 
                SET stok = stok + :jumlah, tanggal_update = NOW()
                WHERE id_barang = :id_barang
            ");
            $stmt2->execute([
                'jumlah'    => $jumlah,
                'id_barang' => $id_barang
            ]);

            
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
