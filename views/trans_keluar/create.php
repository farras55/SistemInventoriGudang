<?php
$title = "Tambah Transaksi Keluar";
include __DIR__ . '/../layout/header.php';
?>

<div class="form-box">
  <h3 class="form-title">Tambah Transaksi Keluar</h3>

  <form method="POST" action="TransaksiKeluarController.php?action=store">

    <div class="form-group">
      <label class="label">Pilih Barang</label>
      <select name="id_barang" class="input" required>
        <option value="">-- pilih barang --</option>
        <?php foreach ($barang as $b): ?>
          <option value="<?= $b['id_barang'] ?>"><?= $b['nama_barang'] ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form-group">
      <label class="label">Tanggal</label>
      <input type="date" name="tanggal" class="input" required value="<?= date('Y-m-d') ?>">
    </div>

    <div class="form-group">
      <label class="label">Jumlah</label>
      <input type="number" name="jumlah" class="input" required min="1">
    </div>

    <button class="btn">Simpan</button>
    <a href="TransaksiKeluarController.php?action=index" class="btn-small">Batal</a>

  </form>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
