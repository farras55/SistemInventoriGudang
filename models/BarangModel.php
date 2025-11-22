<?php
require_once __DIR__ . '/../config/db.php';

class BarangModel {

    private $db;

    public function __construct() {
        global $pdo;
        $this->db = $pdo;
    }

    public function getAll() {
        $sql = "SELECT b.*, k.nama_kategori, s.nama_supplier, g.nama_gudang
            FROM barang b
            JOIN kategori_barang k ON b.id_kategori = k.id_kategori
            JOIN supplier s ON b.id_supplier = s.id_supplier
            JOIN gudang g ON b.id_gudang = g.id_gudang
            ORDER BY id_barang DESC";


        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
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
            'nama'     => $data['nama'],
            'kategori' => $data['kategori'],
            'supplier' => $data['supplier'],
            'gudang'   => $data['gudang'],
            'stok'     => $data['stok'],
            'minstok'  => $data['minstok'],
            'harga_satuan'    => $data['harga_satuan'],
            'ket'      => $data['ket'],
        ]);
    }

    public function update($id, $data) {

        $sql = "UPDATE barang SET 
                nama_barang = :nama,
                id_kategori = :kategori,
                id_supplier = :supplier,
                id_gudang   = :gudang,
                stok        = :stok,
                stok_minimum= :minstok,
                harga_satuan       = :harga_satuan,
                keterangan  = :ket
                WHERE id_barang = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id'       => $id,
            'nama'     => $data['nama'],
            'kategori' => $data['kategori'],
            'supplier' => $data['supplier'],
            'gudang'   => $data['gudang'],
            'stok'     => $data['stok'],
            'minstok'  => $data['minstok'],
            'harga_satuan'    => $data['harga_satuan'],
            'ket'      => $data['ket'],
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
