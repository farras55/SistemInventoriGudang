<?php
$title = "Tambah Gudang";
include __DIR__ . '/../layout/header.php';
$error = $_GET['error'] ?? null;
?>
<div class="form-box">
  <h3 class="form-title">Tambah Gudang</h3>

  <?php if ($error): ?>
    <div class="alert alert-error"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST" action="../../controllers/GudangController.php?action=store">

    <div class="form-group">
      <label class="label">Nama Gudang</label>
      <input class="input" type="text" name="nama" required>
    </div>

    <div class="form-group">
      <label class="label">Lokasi</label>
      <input class="input" type="text" name="lokasi" required>
    </div>

    <button class="btn">Simpan</button>
    <a class="btn-small" href="../../controllers/GudangController.php?action=index">Batal</a>
  </form>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
