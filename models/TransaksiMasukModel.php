<?php
require_once __DIR__ . '/../config/db.php';

class TransaksiMasukModel
{
    private $db;

    public function __construct()
    {
        global $pdo;
        $this->db = $pdo;
    }

    public function getAll()
    {
        $sql = "SELECT tm.*, b.nama_barang 
                FROM transaksi_masuk tm
                JOIN barang b ON tm.id_barang = b.id_barang
                ORDER BY tm.id_trans_masuk DESC";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // paginated + search
    public function getAllPaginated(int $limit, int $offset, string $keyword = "")
    {
        $sql = "SELECT tm.*, b.nama_barang 
                FROM transaksi_masuk tm
                JOIN barang b ON tm.id_barang = b.id_barang
                WHERE (b.nama_barang ILIKE :kw
                       OR tm.no_po ILIKE :kw
                       OR CAST(tm.jumlah AS TEXT) ILIKE :kw
                       OR CAST(tm.tanggal AS TEXT) ILIKE :kw)
                ORDER BY tm.id_trans_masuk DESC
                LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':kw', "%$keyword%", PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function count(string $keyword = ""): int
    {
        $sql = "SELECT COUNT(*)
                FROM transaksi_masuk tm
                JOIN barang b ON tm.id_barang = b.id_barang
                WHERE (b.nama_barang ILIKE :kw
                       OR tm.no_po ILIKE :kw
                       OR CAST(tm.jumlah AS TEXT) ILIKE :kw
                       OR CAST(tm.tanggal AS TEXT) ILIKE :kw)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':kw', "%$keyword%", PDO::PARAM_STR);
        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }

    public function getBarang()
    {
        $sql = "SELECT * FROM barang ORDER BY nama_barang";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Simpan transaksi masuk dengan memanggil stored procedure tambah_stok.
     * SP akan:
     *  - INSERT ke transaksi_masuk
     *  - UPDATE stok di tabel barang
     */
    public function store($id_barang, $jumlah, $no_po)
    {
        try {
            $this->db->beginTransaction();

            $sql = "CALL tambah_stok(:id_barang, :jumlah, :no_po)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'id_barang' => (int)$id_barang,
                'jumlah'    => (int)$jumlah,
                'no_po'     => $no_po
            ]);

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            // bisa di-log kalau mau: error_log($e->getMessage());
            return false;
        }
    }
}
