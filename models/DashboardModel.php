<?php
// models/DashboardModel.php
require_once __DIR__ . '/../config/db.php';

class DashboardModel
{
    private $db;

    public function __construct()
    {
        global $pdo;
        $this->db = $pdo;
    }

    /**
     * Ambil angka ringkasan untuk kartu statistik dashboard.
     */
    public function getCounts(): array
    {
        $sql = "
            SELECT
                (SELECT COUNT(*) FROM barang) AS total_barang,
                (SELECT COUNT(*) FROM supplier) AS total_supplier,
                (SELECT COUNT(*) FROM gudang) AS total_gudang,
                (SELECT COUNT(*) FROM barang WHERE stok < stok_minimum) AS barang_menipis,
                (SELECT COALESCE(SUM(stok * harga_satuan), 0) FROM barang) AS total_nilai_persediaan,
                (SELECT COALESCE(SUM(jumlah),0)
                 FROM transaksi_masuk
                 WHERE tanggal >= date_trunc('month', CURRENT_DATE)
                   AND tanggal <  date_trunc('month', CURRENT_DATE) + INTERVAL '1 month'
                ) AS total_masuk_bulan_ini,
                (SELECT COALESCE(SUM(jumlah),0)
                 FROM transaksi_keluar
                 WHERE tanggal >= date_trunc('month', CURRENT_DATE)
                   AND tanggal <  date_trunc('month', CURRENT_DATE) + INTERVAL '1 month'
                ) AS total_keluar_bulan_ini
        ";
        return $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Top N barang stok menipis (stok < minimum).
     */
    public function getBarangMenipisTop(int $limit = 5): array
    {
        $sql = "
            SELECT 
                b.id_barang,
                b.nama_barang,
                b.stok,
                b.stok_minimum,
                k.nama_kategori,
                g.nama_gudang
            FROM barang b
            LEFT JOIN kategori_barang k ON b.id_kategori = k.id_kategori
            LEFT JOIN gudang g         ON b.id_gudang   = g.id_gudang
            WHERE b.stok < b.stok_minimum
            ORDER BY (b.stok - b.stok_minimum) ASC
            LIMIT :limit
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Top N barang slow-moving dari view v_barang_slow_moving.
     */
    public function getSlowMovingTop(int $limit = 5): array
    {
        // sesuaikan nama kolom jika di view kamu beda
        $sql = "
            SELECT nama_barang, total_keluar
            FROM v_barang_slow_moving
            ORDER BY total_keluar ASC, nama_barang ASC
            LIMIT :limit
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Transaksi terakhir (gabungan masuk & keluar).
     */
    public function getTransaksiTerbaru(int $limit = 10): array
    {
        $sql = "
            SELECT tanggal, jenis, nama_barang, jumlah
            FROM (
                SELECT 
                    tm.tanggal,
                    'MASUK'::text AS jenis,
                    b.nama_barang,
                    tm.jumlah
                FROM transaksi_masuk tm
                JOIN barang b ON tm.id_barang = b.id_barang

                UNION ALL

                SELECT 
                    tk.tanggal,
                    'KELUAR'::text AS jenis,
                    b.nama_barang,
                    tk.jumlah
                FROM transaksi_keluar tk
                JOIN barang b ON tk.id_barang = b.id_barang
            ) x
            ORDER BY tanggal DESC
            LIMIT :limit
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
