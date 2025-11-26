<?php
$title = "Edit Kategori";
include __DIR__ . '/../layout/header.php';
$error = $_GET['error'] ?? null;
?>

<div class="form-box">
    <h3 class="form-title">Edit Kategori</h3>

    <?php if ($error): ?>
        <div class="alert"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="/../controllers/KategoriController.php?action=update" onsubmit="return validate()">

        <input type="hidden" name="id" value="<?= $kategori['id_kategori'] ?>">

        <div class="form-group">
            <label class="label">Nama Kategori</label>
            <input class="input" type="text" id="nama" name="nama" required minlength="3"
            value="<?= htmlspecialchars($kategori['nama_kategori']) ?>">
        </div>

        <div class="form-group">
            <label class="label">Deskripsi</label>
            <textarea class="input" name="deskripsi" rows="3"><?= htmlspecialchars($kategori['deskripsi']) ?></textarea>
        </div>

        <button class="btn">Update</button>
        <a href="/../controllers/KategoriController.php?action=index" class="btn-small" style="background:#6b7280;margin-left:8px;">Batal</a>
    </form>
</div>

<script>
function validate(){
    const n = document.getElementById('nama').value.trim();
    if (n.length < 3) {
        alert("Nama kategori minimal 3 karakter");
        return false;
    }
    return true;
}
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>
