<?php
require_once __DIR__ . '/../config/db.php';

class BarangModel {

    private $db;

    public function __construct() {
        global $pdo;
        $this->db = $pdo;
    }

    public function getAll() {
        // fallback, sudah jarang dipakai tapi tetap dipertahankan
        $sql = "SELECT b.*, k.nama_kategori, s.nama_supplier, g.nama_gudang
            FROM barang b
            JOIN kategori_barang k ON b.id_kategori = k.id_kategori
            JOIN supplier s ON b.id_supplier = s.id_supplier
            JOIN gudang g ON b.id_gudang = g.id_gudang
            ORDER BY id_barang DESC";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // MASIH: versi lama dengan hanya keyword
    public function getAllPaginated(int $limit, int $offset, string $keyword = "") {
        $sql = "SELECT b.*, k.nama_kategori, s.nama_supplier, g.nama_gudang
            FROM barang b
            JOIN kategori_barang k ON b.id_kategori = k.id_kategori
            JOIN supplier s ON b.id_supplier = s.id_supplier
            JOIN gudang g ON b.id_gudang = g.id_gudang
            WHERE (b.nama_barang ILIKE :kw
                   OR k.nama_kategori ILIKE :kw
                   OR s.nama_supplier ILIKE :kw
                   OR g.nama_gudang ILIKE :kw)
            ORDER BY b.id_barang DESC
            LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':kw', "%$keyword%", PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function count(string $keyword = "") {
        $sql = "SELECT COUNT(*) FROM barang b
            JOIN kategori_barang k ON b.id_kategori = k.id_kategori
            JOIN supplier s ON b.id_supplier = s.id_supplier
            JOIN gudang g ON b.id_gudang = g.id_gudang
            WHERE (b.nama_barang ILIKE :kw
                   OR k.nama_kategori ILIKE :kw
                   OR s.nama_supplier ILIKE :kw
                   OR g.nama_gudang ILIKE :kw)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':kw', "%$keyword%", PDO::PARAM_STR);
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    // 🔹 BARU: versi dengan SEARCH + FILTER (kategori, supplier, gudang)
    public function getFilteredPaginated(
        int $limit,
        int $offset,
        string $keyword = "",
        ?int $id_kategori = null,
        ?int $id_supplier = null,
        ?int $id_gudang   = null
    ) {
        $sql = "SELECT b.*, k.nama_kategori, s.nama_supplier, g.nama_gudang
                FROM barang b
                LEFT JOIN kategori_barang k ON b.id_kategori = k.id_kategori
                LEFT JOIN supplier s ON b.id_supplier = s.id_supplier
                LEFT JOIN gudang g   ON b.id_gudang   = g.id_gudang
                WHERE 1=1";

        $params = [];

        if ($keyword !== "") {
            $sql .= " AND (b.nama_barang ILIKE :kw OR k.nama_kategori ILIKE :kw)";
            $params[':kw'] = "%{$keyword}%";
        }

        if (!empty($id_kategori)) {
            $sql .= " AND b.id_kategori = :id_kategori";
            $params[':id_kategori'] = $id_kategori;
        }

        if (!empty($id_supplier)) {
            $sql .= " AND b.id_supplier = :id_supplier";
            $params[':id_supplier'] = $id_supplier;
        }

        if (!empty($id_gudang)) {
            $sql .= " AND b.id_gudang = :id_gudang";
            $params[':id_gudang'] = $id_gudang;
        }

        $sql .= " ORDER BY b.nama_barang ASC LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countFiltered(
        string $keyword = "",
        ?int $id_kategori = null,
        ?int $id_supplier = null,
        ?int $id_gudang   = null
    ): int {
        $sql = "SELECT COUNT(*)
                FROM barang b
                LEFT JOIN kategori_barang k ON b.id_kategori = k.id_kategori
                LEFT JOIN supplier s ON b.id_supplier = s.id_supplier
                LEFT JOIN gudang g   ON b.id_gudang   = g.id_gudang
                WHERE 1=1";

        $params = [];

        if ($keyword !== "") {
            $sql .= " AND (b.nama_barang ILIKE :kw OR k.nama_kategori ILIKE :kw)";
            $params[':kw'] = "%{$keyword}%";
        }

        if (!empty($id_kategori)) {
            $sql .= " AND b.id_kategori = :id_kategori";
            $params[':id_kategori'] = $id_kategori;
        }

        if (!empty($id_supplier)) {
            $sql .= " AND b.id_supplier = :id_supplier";
            $params[':id_supplier'] = $id_supplier;
        }

        if (!empty($id_gudang)) {
            $sql .= " AND b.id_gudang = :id_gudang";
            $params[':id_gudang'] = $id_gudang;
        }

        $stmt = $this->db->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }
        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }

    public function getById($id) {
        $sql = "SELECT * FROM barang WHERE id_barang = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id'=>$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function store($data) {
        $sql = "INSERT INTO barang (nama_barang, id_kategori, id_supplier, id_gudang, stok, stok_minimum, harga_satuan, keterangan)
                VALUES (:nama, :kategori, :supplier, :gudang, :stok, :minstok, :harga_satuan, :ket)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'nama'         => $data['nama'],
            'kategori'     => $data['kategori'],
            'supplier'     => $data['supplier'],
            'gudang'       => $data['gudang'],
            'stok'         => $data['stok'],
            'minstok'      => $data['minstok'],
            'harga_satuan' => $data['harga_satuan'],
            'ket'          => $data['ket'],
        ]);
    }

    public function update($id, $data) {

        $sql = "UPDATE barang SET 
                nama_barang  = :nama,
                id_kategori  = :kategori,
                id_supplier  = :supplier,
                id_gudang    = :gudang,
                stok         = :stok,
                stok_minimum = :minstok,
                harga_satuan = :harga_satuan,
                keterangan   = :ket
                WHERE id_barang = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id'           => $id,
            'nama'         => $data['nama'],
            'kategori'     => $data['kategori'],
            'supplier'     => $data['supplier'],
            'gudang'       => $data['gudang'],
            'stok'         => $data['stok'],
            'minstok'      => $data['minstok'],
            'harga_satuan' => $data['harga_satuan'],
            'ket'          => $data['ket'],
        ]);
    }

    public function delete($id) {
        $sql = "DELETE FROM barang WHERE id_barang = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id'=>$id]);
    }

    // untuk form dropdown
    public function getKategori() {
        return $this->db->query("SELECT * FROM kategori_barang ORDER BY nama_kategori ASC")->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getSupplier() {
        return $this->db->query("SELECT * FROM supplier ORDER BY nama_supplier ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getGudang() {
        return $this->db->query("SELECT * FROM gudang ORDER BY nama_gudang ASC")->fetchAll(PDO::FETCH_ASSOC);
    }
}
