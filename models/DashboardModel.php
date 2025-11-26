<?php
// models/DashboardModel.php

class DashboardModel
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Memanggil FUNCTION total_stok_barang() di PostgreSQL
     * dan mengembalikan nilainya sebagai integer.
     */
    public function getTotalStok(): int
    {
        try {
            $stmt = $this->db->query("SELECT total_stok_barang() AS total");
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int)($row['total'] ?? 0);
        } catch (PDOException $e) {
            // kalau error, bisa kamu log; sementara kita kembalikan 0
            return 0;
        }
    }

    /**
     * Mengembalikan total jumlah jenis barang (COUNT)
     */
    public function getTotalItems(): int
    {
        try {
            $stmt = $this->db->query("SELECT COUNT(*) AS total_items FROM barang");
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int)($row['total_items'] ?? 0);
        } catch (PDOException $e) {
            return 0;
        }
    }

    /**
     * Mengembalikan jumlah barang yang stoknya di bawah atau sama dengan stok_minimum
     */
    public function getLowStockCount(): int
    {
        try {
            $stmt = $this->db->query("SELECT COUNT(*) AS low_count FROM barang WHERE stok <= stok_minimum");
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int)($row['low_count'] ?? 0);
        } catch (PDOException $e) {
            return 0;
        }
    }
}
