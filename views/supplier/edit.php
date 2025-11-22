<?php
$title = "Edit Supplier";
include __DIR__ . '/../layout/header.php';
$error = $_GET['error'] ?? null;
?>
<div class="form-box">
  <h3 class="form-title">Edit Supplier</h3>

  <?php if ($error): ?>
    <div class="alert alert-error"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST" action="../../controllers/SupplierController.php?action=update">
    <input type="hidden" name="id" value="<?= $supplier['id_supplier'] ?>">

    <div class="form-group">
      <label class="label">Nama Supplier</label>
      <input class="input" type="text" name="nama" 
             value="<?= htmlspecialchars($supplier['nama_supplier']) ?>" required>
    </div>

    <div class="form-group">
      <label class="label">Kontak</label>
      <input class="input" type="text" name="kontak"
             value="<?= htmlspecialchars($supplier['kontak']) ?>">
    </div>

    <div class="form-group">
      <label class="label">Alamat</label>
      <textarea class="input" name="alamat"><?= htmlspecialchars($supplier['alamat']) ?></textarea>
    </div>

    <div class="form-group">
      <label class="label">Email</label>
      <input class="input" type="email" name="email"
             value="<?= htmlspecialchars($supplier['email']) ?>">
    </div>

    <button class="btn">Update</button>
    <a class="btn-small" href="../../controllers/SupplierController.php?action=index">Batal</a>
  </form>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
