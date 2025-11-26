<?php
$title = "Edit Barang";
include __DIR__ . '/../layout/header.php';
?>

<div class="form-box">
    <h3 class="card-title">Edit Barang</h3>

    <form method="POST" action="/../controllers/BarangController.php?action=update" onsubmit="return validateBarang()">

        <input type="hidden" name="id" value="<?= $barang['id_barang'] ?>">

        <div class="form-group">
            <label class="label">Nama Barang</label>
            <input type="text" name="nama" class="input" required minlength="2"
                   value="<?= htmlspecialchars($barang['nama_barang']) ?>">
        </div>

        <div class="form-group">
            <label class="label">Kategori</label>
            <select class="input" name="kategori" required>
                <?php foreach ($kategori as $k): ?>
                    <option value="<?= $k['id_kategori'] ?>"
                        <?= $k['id_kategori']==$barang['id_kategori'] ? 'selected':'' ?>>
                        <?= $k['nama_kategori'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label class="label">Supplier</label>
            <select class="input" name="supplier" required>
                <?php foreach ($supplier as $s): ?>
                    <option value="<?= $s['id_supplier'] ?>"
                        <?= $s['id_supplier']==$barang['id_supplier'] ? 'selected':'' ?>>
                        <?= $s['nama_supplier'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label class="label">Gudang</label>
            <select class="input" name="gudang" required>
                <?php foreach ($gudang as $g): ?>
                    <option value="<?= $g['id_gudang'] ?>"
                        <?= $g['id_gudang']==$barang['id_gudang'] ? 'selected':'' ?>>
                        <?= $g['nama_gudang'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label class="label">Stok</label>
            <input type="number" name="stok" class="input" min="0"
                   value="<?= $barang['stok'] ?>">
        </div>

        <div class="form-group">
            <label class="label">Minimum Stok</label>
            <input type="number" name="minstok" class="input" min="1"
                   value="<?= $barang['stok_minimum'] ?>">
        </div>

        <div class="form-group">
            <label class="label">Harga Satuan</label>
            <input type="number" name="harga_satuan" class="input" min="0"
                   value="<?= $barang['harga_satuan'] ?>">
        </div>

        <div class="form-group">
            <label class="label">Keterangan</label>
            <textarea class="input" name="ket"><?= htmlspecialchars($barang['keterangan']) ?></textarea>
        </div>

        <button class="btn">Update</button>
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
