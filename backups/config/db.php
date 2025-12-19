<?php
// config/db.php
$host = 'localhost'; $port='5433'; $dbname='Sistem_Inventory_Gudang_db'; $user='postgres'; $pass='12345678';
try {
  $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $pass);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Koneksi gagal: " . $e->getMessage());
}
