<?php
$title = "Tambah Barang";
include __DIR__ . '/../layout/header.php';
?>

<div class="form-box">
    <h3 class="card-title">Tambah Barang</h3>

    <form method="POST" action="/../controllers/BarangController.php?action=store" onsubmit="return validateBarang()">

        <div class="form-group">
            <label class="label">Nama Barang</label>
            <input type="text" name="nama" class="input" required minlength="2">
        </div>

        <div class="form-group">
            <label class="label">Kategori</label>
            <select class="input" name="kategori" required>
                <option value="">
                <?php foreach ($kategori as $k): ?>
                    <option value="<?= $k['id_kategori'] ?>"><?= $k['nama_kategori'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label class="label">Supplier</label>
            <select class="input" name="supplier" required>
                <option value="">
                <?php foreach ($supplier as $s): ?>
                    <option value="<?= $s['id_supplier'] ?>"><?= $s['nama_supplier'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label class="label">Gudang</label>
            <select class="input" name="gudang" required>
                <option value="">
                <?php foreach ($gudang as $g): ?>
                    <option value="<?= $g['id_gudang'] ?>"><?= $g['nama_gudang'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label class="label">Stok Awal</label>
            <input type="number" name="stok" class="input" min="0" value="0">
        </div>

        <div class="form-group">
            <label class="label">Minimum Stok</label>
            <input type="number" name="minstok" class="input" min="1" value="1">
        </div>

        <div class="form-group">
            <label class="label">Harga Satuan</label>
            <input type="number" name="harga_satuan" class="input" required min="0">
        </div>

        <div class="form-group">
            <label class="label">Keterangan</label>
            <textarea class="input" name="ket"></textarea>
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
        return false;
    }
    return true;
}
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>
