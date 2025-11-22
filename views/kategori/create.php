<?php
// views/kategori/create.php
$title = "Tambah Kategori";
include __DIR__ . '/../layout/header.php';
$error = $_GET['error'] ?? null;
?>
<div class="form-box">
  <h3 class="form-title">Tambah Kategori</h3>
  <?php if ($error): ?>
    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST" action="../../controllers/KategoriController.php?action=store" onsubmit="return validate()">
    <div class="form-group">
      <label class="label">Nama Kategori</label>
      <input class="input" type="text" id="nama" name="nama" required minlength="3">
    </div>

    <div class="form-group">
      <label class="label">Deskripsi</label>
      <textarea class="input" name="deskripsi" rows="3"></textarea>
    </div>

    <button class="btn">Simpan</button>
    <a href="../../controllers/KategoriController.php?action=index" class="btn-small" style="margin-left:8px;background:#6b7280;">Batal</a>
  </form>
</div>

<script>
function validate(){
  let n = document.getElementById('nama').value.trim();
  if (n.length < 3) { alert('Nama kategori minimal 3 karakter'); return false; }
  return true;
}
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>
