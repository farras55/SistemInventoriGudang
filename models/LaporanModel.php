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

    
    public function getStokRingkasan() {
        try {
            
            $check = $this->db->query("SELECT to_regclass('public.mv_stok_ringkasan') AS mv_name")->fetch(PDO::FETCH_ASSOC);
            if (!empty($check['mv_name'])) {
                $sql = "SELECT * FROM mv_stok_ringkasan ORDER BY nama_kategori";
                $stmt = $this->db->query($sql);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            
            $sql = "SELECT k.nama_kategori, SUM(b.stok) AS total_stok
                    FROM barang b
                    JOIN kategori_barang k ON b.id_kategori = k.id_kategori
                    GROUP BY k.nama_kategori
                    ORDER BY k.nama_kategori";
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    
    public function refreshMaterialized(): bool {
        try {
            $this->db->exec("REFRESH MATERIALIZED VIEW CONCURRENTLY mv_stok_ringkasan");
            return true;
        } catch (PDOException $e) {
            
            try {
                $this->db->exec("REFRESH MATERIALIZED VIEW mv_stok_ringkasan");
                return true;
            } catch (PDOException $e2) {
                return false;
            }
        }
    }


    public function getStokOpnamePaginated(int $limit, int $offset, string $keyword = "", ?int $id_gudang = null, ?int $id_kategori = null) {
        $sql = "SELECT 
                    vo.id_barang,
                    vo.nama_barang,
                    vo.nama_kategori,
                    vo.nama_gudang,
                    vo.stok,
                    vo.stok_minimum
                FROM v_stok_opname vo
                JOIN barang b ON b.id_barang = vo.id_barang
                WHERE 1=1";

        $params = [];

        if ($keyword !== "") {
            $sql .= " AND (vo.nama_barang ILIKE :kw OR vo.nama_kategori ILIKE :kw OR vo.nama_gudang ILIKE :kw)";
            $params[':kw'] = "%{$keyword}%";
        }

        if (!empty($id_gudang)) {
            $sql .= " AND b.id_gudang = :id_gudang";
            $params[':id_gudang'] = (int)$id_gudang;
        }

        if (!empty($id_kategori)) {
            $sql .= " AND b.id_kategori = :id_kategori";
            $params[':id_kategori'] = (int)$id_kategori;
        }

        $sql .= " ORDER BY vo.nama_barang LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);

        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countStokOpname(string $keyword = "", ?int $id_gudang = null, ?int $id_kategori = null) {
        $sql = "SELECT COUNT(*) AS total
                FROM v_stok_opname vo
                JOIN barang b ON b.id_barang = vo.id_barang
                WHERE 1=1";

        $params = [];

        if ($keyword !== "") {
            $sql .= " AND (vo.nama_barang ILIKE :kw OR vo.nama_kategori ILIKE :kw OR vo.nama_gudang ILIKE :kw)";
            $params[':kw'] = "%{$keyword}%";
        }

        if (!empty($id_gudang)) {
            $sql .= " AND b.id_gudang = :id_gudang";
            $params[':id_gudang'] = (int)$id_gudang;
        }

        if (!empty($id_kategori)) {
            $sql .= " AND b.id_kategori = :id_kategori";
            $params[':id_kategori'] = (int)$id_kategori;
        }

        $stmt = $this->db->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }
        $stmt->execute();

        return (int)$stmt->fetchColumn();
    }


    public function getAllGudang() {
        $sql = "SELECT id_gudang, nama_gudang FROM gudang ORDER BY nama_gudang ASC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllKategori() {
        $sql = "SELECT id_kategori, nama_kategori FROM kategori_barang ORDER BY nama_kategori ASC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }




    

    public function getSlowMovingPaginated(int $limit, int $offset, string $keyword = ""): array
    {
        $sql = "SELECT *
                FROM v_barang_slow_moving
                WHERE nama_barang ILIKE :kw
                ORDER BY total_keluar ASC
                LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':kw', "%{$keyword}%", PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countSlowMoving(string $keyword = ""): int
    {
        $sql = "SELECT COUNT(*)
                FROM v_barang_slow_moving
                WHERE nama_barang ILIKE :kw";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':kw', "%{$keyword}%", PDO::PARAM_STR);
        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }


    
}
