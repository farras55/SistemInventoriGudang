<?php
// models/KategoriModel.php
// Menggunakan $pdo dari config/db.php (pastikan db.php diletakkan di config/ dan di-include di controller)
class KategoriModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // ambil data dengan pagination dan filter keyword
    public function getAll(int $limit, int $offset, string $keyword = "") {
        $sql = "SELECT * FROM kategori_barang
                WHERE nama_kategori ILIKE :keyword
                ORDER BY id_kategori DESC
                LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':keyword', "%$keyword%", PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function count(string $keyword = "") {
        $sql = "SELECT COUNT(*) FROM kategori_barang WHERE nama_kategori ILIKE :keyword";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':keyword', "%$keyword%", PDO::PARAM_STR);
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    public function find(int $id) {
        $sql = "SELECT * FROM kategori_barang WHERE id_kategori = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(string $nama, ?string $deskripsi) {
        $sql = "INSERT INTO kategori_barang (nama_kategori, deskripsi) VALUES (:nama, :deskripsi)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':nama' => $nama, ':deskripsi' => $deskripsi]);
    }

    public function update(int $id, string $nama, ?string $deskripsi) {
        $sql = "UPDATE kategori_barang SET nama_kategori = :nama, deskripsi = :deskripsi WHERE id_kategori = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':nama' => $nama, ':deskripsi' => $deskripsi, ':id' => $id]);
    }

    public function delete(int $id) {
        $sql = "DELETE FROM kategori_barang WHERE id_kategori = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
