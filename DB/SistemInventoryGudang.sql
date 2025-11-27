CREATE SEQUENCE seq_kategori START 1;
CREATE SEQUENCE seq_supplier START 1;
CREATE SEQUENCE seq_gudang START 1;
CREATE SEQUENCE seq_barang START 1;
CREATE SEQUENCE seq_trans_masuk START 1;
CREATE SEQUENCE seq_trans_keluar START 1;

CREATE TABLE kategori_barang (
    id_kategori INT PRIMARY KEY DEFAULT nextval('seq_kategori'),
    nama_kategori VARCHAR(50) UNIQUE NOT NULL,
    deskripsi TEXT
);

CREATE TABLE supplier (
    id_supplier INT PRIMARY KEY DEFAULT nextval('seq_supplier'),
    nama_supplier VARCHAR(100) NOT NULL,
    kontak VARCHAR(20),
    alamat TEXT
);

CREATE TABLE gudang (
    id_gudang INT PRIMARY KEY DEFAULT nextval('seq_gudang'),
    nama_gudang VARCHAR(100) NOT NULL,
    lokasi VARCHAR(100) NOT NULL
);

CREATE TABLE barang (
    id_barang INT PRIMARY KEY DEFAULT nextval('seq_barang'),
    nama_barang VARCHAR(100) NOT NULL,
    stok INT DEFAULT 0,
    harga_satuan NUMERIC(12,2) DEFAULT 0,
    id_kategori INT REFERENCES kategori_barang(id_kategori) ON DELETE SET NULL,
    id_supplier INT REFERENCES supplier(id_supplier) ON DELETE SET NULL,
    id_gudang INT REFERENCES gudang(id_gudang) ON DELETE SET NULL,
    keterangan TEXT DEFAULT 'Tersedia',
    UNIQUE (nama_barang, id_gudang)
);

CREATE TABLE transaksi_masuk (
    id_trans_masuk INT PRIMARY KEY DEFAULT nextval('seq_trans_masuk'),
    id_barang INT REFERENCES barang(id_barang) ON DELETE CASCADE,
    tanggal DATE DEFAULT CURRENT_DATE,
    jumlah INT NOT NULL CHECK (jumlah > 0)
);

CREATE TABLE transaksi_keluar (
    id_trans_keluar INT PRIMARY KEY DEFAULT nextval('seq_trans_keluar'),
    id_barang INT REFERENCES barang(id_barang) ON DELETE CASCADE,
    tanggal DATE DEFAULT CURRENT_DATE,
    jumlah INT NOT NULL CHECK (jumlah > 0)
);

ALTER TABLE supplier ALTER COLUMN kontak TYPE VARCHAR(30);
ALTER TABLE supplier ADD COLUMN email VARCHAR(100) DEFAULT 'tidak_ada@unknown.com';

ALTER TABLE barang ADD COLUMN tanggal_update TIMESTAMP DEFAULT NOW();
ALTER TABLE barang ADD CONSTRAINT chk_stok_nonnegatif CHECK (stok >= 0);

INSERT INTO kategori_barang (nama_kategori, deskripsi) VALUES
('Elektronik','Peralatan listrik'),
('Alat Tulis','Perlengkapan kantor'),
('Furniture','Perabotan gudang'),
('Keamanan','Peralatan safety'),
('Bahan Bangunan','Material konstruksi'),
('ATK','Alat tulis kantor'),
('IT Support','Komponen komputer'),
('Konsumsi','Barang konsumsi internal'),
('Kebersihan','Alat kebersihan gudang'),
('Sparepart','Suku cadang mesin'),
('Mesin','Peralatan produksi utama'),
('Komunikasi','Alat komunikasi'),
('Transportasi','Kendaraan operasional'),
('Perlengkapan Kantor','Peralatan kerja'),
('Hardware','Komponen keras komputer'),
('Software','Lisensi aplikasi dan OS'),
('Dekorasi','Aksesoris ruangan'),
('Maintenance','Barang perawatan gedung'),
('Tools','Perkakas umum'),
('Lain-lain','Kategori umum lainnya');

INSERT INTO supplier (nama_supplier, kontak, alamat, email) VALUES
('PT Maju Jaya','08123456789','Malang','majujaya@gmail.com'),
('CV Berkah Abadi','08129876543','Surabaya','berkahabadi@gmail.com'),
('PT Sentosa Sejahtera','082233445566','Jakarta','sentosa@gmail.com'),
('PT Prima Supply','08124444666','Semarang','primasupply@gmail.com'),
('CV Mega Makmur','085711122233','Sidoarjo','megamakmur@gmail.com'),
('PT Nusantara Logistik','08121114567','Bandung','nusantaralog@gmail.com'),
('PT Global Elektronik','082155555678','Bekasi','globalelektronik@gmail.com'),
('CV Dunia Kertas','085799988877','Tulungagung','duniakertas@gmail.com'),
('PT FurniTech','081299933322','Solo','furnitech@gmail.com'),
('PT PowerTools','081355577799','Gresik','powertools@gmail.com'),
('CV Cahaya Abadi','081266688899','Kediri','cahayaabadi@gmail.com'),
('PT Jaya Sejati','085611122233','Malang','jayasejati@gmail.com'),
('CV Smart Stationery','081255599900','Blitar','smartstationery@gmail.com'),
('PT Safety Indo','082111223344','Bogor','safetyindo@gmail.com'),
('CV Bangun Makmur','082244556677','Surabaya','bangunmakmur@gmail.com'),
('PT SoundVision','081233344455','Jakarta','soundvision@gmail.com'),
('CV Harapan Baru','085700011122','Probolinggo','harapanbaru@gmail.com'),
('PT Sinar Cahaya','081344466688','Denpasar','sinarcahaya@gmail.com'),
('PT Mega Elektrik','081288899900','Depok','megaelektrik@gmail.com'),
('CV Nusantara Supply','081200011233','Yogyakarta','nusantarasupply@gmail.com');

INSERT INTO gudang (nama_gudang, lokasi) VALUES
('Gudang Pusat','Malang'),
('Gudang Cabang Surabaya','Surabaya'),
('Gudang Cabang Jakarta','Jakarta'),
('Gudang Cadangan','Blitar'),
('Gudang Utama','Sidoarjo'),
('Gudang Barat','Madiun'),
('Gudang Timur','Kediri'),
('Gudang Selatan','Tulungagung'),
('Gudang Utara','Probolinggo'),
('Gudang Produk A','Pasuruan'),
('Gudang Produk B','Gresik'),
('Gudang Elektronik','Bekasi'),
('Gudang Furnitur','Solo'),
('Gudang Sparepart','Bandung'),
('Gudang Peralatan','Depok'),
('Gudang Stok Lama','Semarang'),
('Gudang Distribusi','Banyuwangi'),
('Gudang Komponen','Yogyakarta'),
('Gudang Maintenance','Bogor'),
('Gudang Tambahan','Denpasar');

INSERT INTO barang (nama_barang, stok, harga_satuan, id_kategori, id_supplier, id_gudang, tanggal_update) VALUES
('Laptop ASUS',10,8500000,1,1,1,'2025-10-01 08:00:00'),
('Pulpen Pilot',200,5000,2,2,2,'2025-10-02 09:00:00'),
('Kursi Kantor',30,350000,3,3,3,'2025-10-03 10:00:00'),
('Helm Safety',50,90000,4,4,4,'2025-10-04 11:00:00'),
('Semen Tiga Roda',100,60000,5,5,5,'2025-10-05 12:00:00'),
('Buku Nota',250,7000,6,6,6,'2025-10-06 08:30:00'),
('RAM DDR4 16GB',25,750000,7,7,7,'2025-10-07 09:30:00'),
('Air Mineral 1L',100,4000,8,8,8,'2025-10-08 10:30:00'),
('Sapu Lantai',70,20000,9,9,9,'2025-10-09 11:30:00'),
('Bearing Gear',40,50000,10,10,10,'2025-10-10 12:30:00'),
('Bor Listrik Bosch',15,1250000,11,11,11,'2025-10-11 08:15:00'),
('Walkie Talkie Motorola',8,2300000,12,12,12,'2025-10-12 09:15:00'),
('Ban Mobil Toyota',12,950000,13,13,13,'2025-10-13 10:15:00'),
('Mouse Wireless Logitech',40,250000,14,14,14,'2025-10-14 11:15:00'),
('Motherboard ASUS Prime',18,1800000,15,15,15,'2025-10-15 12:15:00'),
('Windows 11 Pro License',50,3500000,16,16,16,'2025-10-16 08:45:00'),
('Vas Bunga Kantor',25,120000,17,17,17,'2025-10-17 09:45:00'),
('Oli Mesin Shell 1L',35,95000,18,18,18,'2025-10-18 10:45:00'),
('Obeng Set Kenmaster',45,85000,19,19,19,'2025-10-19 11:45:00'),
('Lampu Sorot LED 100W',20,500000,20,20,20,'2025-10-20 12:45:00');

INSERT INTO transaksi_masuk (id_barang, tanggal, jumlah) VALUES
(1,'2025-10-01',5),(2,'2025-10-02',3),(3,'2025-10-03',10),(4,'2025-10-04',15),(5,'2025-10-05',2),
(6,'2025-10-06',10),(7,'2025-10-07',5),(8,'2025-10-08',20),(9,'2025-10-09',8),(10,'2025-10-10',10),
(11,'2025-10-11',12),(12,'2025-10-12',6),(13,'2025-10-13',9),(14,'2025-10-14',4),(15,'2025-10-15',25),
(16,'2025-10-16',3),(17,'2025-10-17',10),(18,'2025-10-18',8),(19,'2025-10-19',6),(20,'2025-10-20',7);

INSERT INTO transaksi_keluar (id_barang, tanggal, jumlah) VALUES
(1,'2025-10-11',2),(2,'2025-10-12',1),(3,'2025-10-13',5),(4,'2025-10-14',10),(5,'2025-10-15',1),
(6,'2025-10-16',2),(7,'2025-10-17',3),(8,'2025-10-18',15),(9,'2025-10-19',5),(10,'2025-10-20',8),
(11,'2025-10-21',6),(12,'2025-10-22',2),(13,'2025-10-23',1),(14,'2025-10-24',3),(15,'2025-10-25',4),
(16,'2025-10-26',5),(17,'2025-10-27',8),(18,'2025-10-28',2),(19,'2025-10-29',3),(20,'2025-10-30',6);

UPDATE barang SET harga_satuan = harga_satuan * 1.05 WHERE id_kategori = 1;
UPDATE barang SET stok = stok + 10, tanggal_update = NOW() WHERE id_barang = 1;
DELETE FROM barang WHERE stok < 0;

SELECT b.nama_barang, k.nama_kategori, s.nama_supplier, s.email, g.nama_gudang, b.stok
FROM barang b
INNER JOIN kategori_barang k ON b.id_kategori = k.id_kategori
INNER JOIN supplier s ON b.id_supplier = s.id_supplier
INNER JOIN gudang g ON b.id_gudang = g.id_gudang;

SELECT k.nama_kategori, b.nama_barang
FROM kategori_barang k
LEFT JOIN barang b ON b.id_kategori = k.id_kategori;

SELECT b.nama_barang, k.nama_kategori
FROM barang b
RIGHT JOIN kategori_barang k ON b.id_kategori = k.id_kategori;

SELECT CONCAT('Barang: ', nama_barang) FROM barang;
SELECT UPPER(nama_supplier) FROM supplier;
SELECT SUBSTRING(nama_barang FROM 1 FOR 5) FROM barang;
SELECT AGE(NOW(), tanggal) FROM transaksi_masuk;
SELECT ROUND(AVG(harga_satuan), 2) FROM barang;
SELECT CASE WHEN stok < 10 THEN 'Stok Menipis' ELSE 'Aman' END AS status FROM barang;

SELECT k.nama_kategori, COUNT(b.id_barang) AS total_barang
FROM barang b JOIN kategori_barang k ON b.id_kategori = k.id_kategori GROUP BY k.nama_kategori;

SELECT g.nama_gudang, SUM(b.stok) AS total_stok, SUM(b.stok*b.harga_satuan) AS total_nilai
FROM barang b JOIN gudang g ON b.id_gudang = g.id_gudang GROUP BY g.nama_gudang HAVING SUM(b.stok)>10;

SELECT MIN(harga_satuan), MAX(harga_satuan) FROM barang;

CREATE OR REPLACE FUNCTION total_stok_barang() RETURNS INT AS $$
DECLARE total INT;
BEGIN
  SELECT SUM(stok) INTO total FROM barang;
  RETURN total;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION daftar_barang_per_kategori(p_id_kategori INT)
RETURNS TABLE(nama_barang TEXT, stok INT) AS $$
BEGIN
  RETURN QUERY SELECT nama_barang, stok FROM barang WHERE id_kategori = p_id_kategori;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE PROCEDURE tambah_stok(p_id_barang INT, p_jumlah INT)
LANGUAGE plpgsql AS $$
BEGIN
  UPDATE barang SET stok = stok + p_jumlah, tanggal_update = NOW()
  WHERE id_barang = p_id_barang;
END;
$$;

CREATE VIEW v_stok_barang AS
SELECT nama_barang, stok FROM barang;

CREATE VIEW v_detail_barang AS
SELECT b.nama_barang, k.nama_kategori, s.nama_supplier, g.nama_gudang, b.stok, b.harga_satuan
FROM barang b
JOIN kategori_barang k ON b.id_kategori=k.id_kategori
JOIN supplier s ON b.id_supplier=s.id_supplier
JOIN gudang g ON b.id_gudang=g.id_gudang;

CREATE MATERIALIZED VIEW mv_stok_ringkasan AS
SELECT k.nama_kategori, SUM(b.stok) AS total_stok
FROM barang b
JOIN kategori_barang k ON b.id_kategori=k.id_kategori
GROUP BY k.nama_kategori;

REFRESH MATERIALIZED VIEW mv_stok_ringkasan;

CREATE INDEX idx_barang_nama ON barang(nama_barang);
CREATE INDEX idx_barang_stok_rendah ON barang(stok) WHERE stok < 10;
EXPLAIN ANALYZE SELECT * FROM barang WHERE stok < 10;

BEGIN;
UPDATE barang SET stok = stok - 2 WHERE id_barang = 1;
SAVEPOINT sebelum_rollback;
UPDATE barang SET stok = stok - 5 WHERE id_barang = 2;
ROLLBACK TO SAVEPOINT sebelum_rollback;
COMMIT;

SET TRANSACTION ISOLATION LEVEL READ COMMITTED;
SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;

select * from v_stok_barang;

select * from v_detail_barang;


select * from mv_stok_ringkasan;



ALTER TABLE barang 
ADD COLUMN kode_barang VARCHAR(20) UNIQUE DEFAULT CONCAT('BRG', nextval('seq_barang')),
ADD COLUMN stok_minimum INT DEFAULT 10 CHECK (stok_minimum >= 0);

ALTER TABLE transaksi_masuk 
ADD COLUMN no_po VARCHAR(30);

CREATE TABLE users (
    id_user SERIAL PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    role VARCHAR(20) DEFAULT 'admin',
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT NOW()
);

INSERT INTO users (username, password, nama_lengkap, email)
VALUES ('admin', crypt('admin123', gen_salt('bf')), 'Administrator', 'admin@gudang.com');

CREATE EXTENSION IF NOT EXISTS pgcrypto;

CREATE OR REPLACE FUNCTION cek_stok_keluar() RETURNS TRIGGER AS $$
BEGIN
    IF (SELECT stok FROM barang WHERE id_barang = NEW.id_barang) < NEW.jumlah THEN
        RAISE EXCEPTION 'Stok barang tidak mencukupi!';
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trg_cek_stok_keluar
BEFORE INSERT ON transaksi_keluar
FOR EACH ROW EXECUTE FUNCTION cek_stok_keluar();

CREATE OR REPLACE PROCEDURE tambah_stok(p_id_barang INT, p_jumlah INT)
LANGUAGE plpgsql AS $$
BEGIN
  UPDATE barang SET stok = stok + p_jumlah, tanggal_update = NOW()
  WHERE id_barang = p_id_barang;
END;
$$;

CREATE OR REPLACE VIEW v_alert_stok_menipis AS
SELECT id_barang, nama_barang, stok, stok_minimum
FROM barang WHERE stok < stok_minimum;

CREATE OR REPLACE VIEW v_laporan_mutasi AS
SELECT 
    b.nama_barang,
    COALESCE(SUM(tm.jumlah), 0) AS total_masuk,
    COALESCE(SUM(tk.jumlah), 0) AS total_keluar,
    (COALESCE(SUM(tm.jumlah), 0) - COALESCE(SUM(tk.jumlah), 0)) AS saldo_mutasi
FROM barang b
LEFT JOIN transaksi_masuk tm ON b.id_barang = tm.id_barang
LEFT JOIN transaksi_keluar tk ON b.id_barang = tk.id_barang
GROUP BY b.nama_barang;

CREATE OR REPLACE VIEW v_barang_slow_moving AS
SELECT b.id_barang, b.nama_barang, COUNT(tk.id_trans_keluar) AS total_keluar
FROM barang b
LEFT JOIN transaksi_keluar tk ON b.id_barang = tk.id_barang
GROUP BY b.id_barang, b.nama_barang
HAVING COUNT(tk.id_trans_keluar) < 3;

CREATE MATERIALIZED VIEW mv_stok_ringkasan AS
SELECT k.nama_kategori, SUM(b.stok) AS total_stok
FROM barang b
JOIN kategori_barang k ON b.id_kategori=k.id_kategori
GROUP BY k.nama_kategori;

REFRESH MATERIALIZED VIEW mv_stok_ringkasan;


CREATE INDEX idx_barang_search ON barang(nama_barang);
CREATE INDEX idx_kategori_search ON kategori_barang(nama_kategori);
CREATE INDEX idx_supplier_search ON supplier(nama_supplier);
CREATE INDEX idx_gudang_search ON gudang(nama_gudang);

DROP VIEW IF EXISTS v_laporan_mutasi;

CREATE OR REPLACE VIEW v_laporan_mutasi AS
WITH masuk AS (
    SELECT id_barang, SUM(jumlah) AS total_masuk
    FROM transaksi_masuk
    GROUP BY id_barang
),
keluar AS (
    SELECT id_barang, SUM(jumlah) AS total_keluar
    FROM transaksi_keluar
    GROUP BY id_barang
)
SELECT 
    b.id_barang,
    b.nama_barang,
    COALESCE(m.total_masuk, 0) AS total_masuk,
    COALESCE(k.total_keluar, 0) AS total_keluar,
    COALESCE(m.total_masuk, 0) - COALESCE(k.total_keluar, 0) AS saldo_mutasi
FROM barang b
LEFT JOIN masuk m ON b.id_barang = m.id_barang
LEFT JOIN keluar k ON b.id_barang = k.id_barang
ORDER BY b.nama_barang;



CREATE OR REPLACE VIEW v_stok_opname AS
SELECT 
    b.id_barang,
    b.kode_barang,
    b.nama_barang,
    k.nama_kategori,
    g.nama_gudang,
    b.stok,
    b.stok_minimum,
    b.harga_satuan,
    (b.stok * b.harga_satuan) AS nilai_persediaan,
    CASE 
        WHEN b.stok < b.stok_minimum THEN 'MENIPIS'
        ELSE 'AMAN'
    END AS status_stok
FROM barang b
LEFT JOIN kategori_barang k ON b.id_kategori = k.id_kategori
LEFT JOIN gudang g         ON b.id_gudang   = g.id_gudang
ORDER BY b.nama_barang;

