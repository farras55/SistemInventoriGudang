<?php 
$title = "Tambah Transaksi Masuk";
include __DIR__ . '/../layout/header.php';
?>

<div class="form-box">
    <h3 class="form-title">Tambah Transaksi Masuk</h3>

    <?php if (isset($_GET['error'])): ?>
        <p class="alert alert-danger"><?= $_GET['error'] ?></p>
    <?php endif; ?>

    <form method="POST" action="TransaksiMasukController.php?action=store">

        <div class="form-group">
            <label class="label">Barang</label>
            <select name="id_barang" class="input" required>
                <option value="">-- pilih barang --</option>
                <?php foreach ($barang as $b): ?>
                    <option value="<?= $b['id_barang'] ?>"><?= $b['nama_barang'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label class="label">Jumlah Masuk</label>
            <input type="number" name="jumlah" class="input" required min="1">
        </div>

        <div class="form-group">
            <label class="label">No PO (Optional)</label>
            <input type="text" name="no_po" class="input">
        </div>

        <button class="btn">Simpan</button>
        <a href="TransaksiMasukController.php?action=index" class="btn-small">Batal</a>
    </form>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
