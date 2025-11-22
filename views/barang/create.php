<?php
$title = "Tambah Barang";
include __DIR__ . '/../layout/header.php';
?>

<div class="form-box">
    <h3 class="form-title">Tambah Barang</h3>

    <form method="POST" action="/../controllers/BarangController.php?action=store" onsubmit="return validateBarang()">
        
        <div class="form-group">
            <label class="label">Nama Barang</label>
            <input type="text" name="nama" class="input" required minlength="2">
        </div>

        <div class="form-group">
            <label class="label">Kategori</label>
            <select class="input" name="kategori" required>
                <option value="">-- pilih kategori --</option>
                <?php foreach ($kategori as $k): ?>
                    <option value="<?= $k['id_kategori'] ?>"><?= $k['nama_kategori'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label class="label">Supplier</label>
            <select class="input" name="supplier" required>
                <option value="">-- pilih supplier --</option>
                <?php foreach ($supplier as $s): ?>
                    <option value="<?= $s['id_supplier'] ?>"><?= $s['nama_supplier'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label class="label">Gudang</label>
            <select class="input" name="gudang" required>
                <option value="">-- pilih gudang --</option>
                <?php foreach ($gudang as $g): ?>
                    <option value="<?= $g['id_gudang'] ?>"><?= $g['nama_gudang'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label class="label">Stok Awal</label>
            <input type="number" name="stok" class="input" value="0" min="0">
        </div>

        <div class="form-group">
            <label class="label">Minimum Stok</label>
            <input type="number" name="minstok" class="input" value="1" min="1">
        </div>

        <div class="form-group">
            <label class="label">Harga Satuan</label>
            <input type="number" name="harga_satuan" class="input" required min="0">
        </div>

        <div class="form-group">
            <label class="label">Keterangan</label>
            <textarea name="ket" class="input"></textarea>
        </div>

        <button class="btn">Simpan</button>
        <a class="btn-small" href="/../controllers/BarangController.php?action=index">Batal</a>
    </form>
</div>

<script>
function validateBarang() {
    let nama = document.querySelector("[name='nama']").value.trim();
    if (nama.length < 2) {
        alert("Nama barang minimal 2 karakter!");
        return
