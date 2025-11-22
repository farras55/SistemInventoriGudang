<?php
$title = "Edit Gudang";
include __DIR__ . '/../layout/header.php';
$error = $_GET['error'] ?? null;
?>
<div class="form-box">
  <h3 class="form-title">Edit Gudang</h3>

  <?php if ($error): ?>
    <div class="alert alert-error"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST" action="../../controllers/GudangController.php?action=update">
    <input type="hidden" name="id" value="<?= $gudang['id_gudang'] ?>">

    <div class="form-group">
      <label class="label">Nama Gudang</label>
      <input class="input" type="text" name="nama" value="<?= htmlspecialchars($gudang['nama_gudang']) ?>" required>
    </div>

    <div class="form-group">
      <label class="label">Lokasi</label>
      <input class="input" type="text" name="lokasi" value="<?= htmlspecialchars($gudang['lokasi']) ?>" required>
    </div>

    <button class="btn">Update</button>
    <a class="btn-small" href="../../controllers/GudangController.php?action=index">Batal</a>
  </form>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
