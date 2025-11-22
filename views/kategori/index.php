<?php 
// views/kategori/index.php
$title = "Data Kategori";
include __DIR__ . '/../layout/header.php';
?>
<div class="flex-between">
  <h2>Data Kategori Barang</h2>
  <div>
    <a href="KategoriController.php?action=create" class="btn">+ Tambah Kategori</a>
  </div>
</div>

<div class="mt-20 form-box">
  <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;">
    <div>
      <input id="searchBox" type="text" placeholder="Cari kategori..." class="input" style="min-width:280px;">
    </div>
    <div>
      <span class="muted">Total: <?= $total ?></span>
    </div>
  </div>

  <table class="table mt-20" id="dataTable">
    <thead>
      <tr><th>ID</th><th>Nama Kategori</th><th>Deskripsi</th><th>Aksi</th></tr>
    </thead>
    <tbody>
      <?php if (empty($data)): ?>
        <tr><td colspan="4" style="text-align:center;padding:18px;">Data tidak ditemukan</td></tr>
      <?php else: ?>
        <?php foreach ($data as $d): ?>
          <tr>
            <td><?= $d['id_kategori'] ?></td>
            <td><?= htmlspecialchars($d['nama_kategori']) ?></td>
            <td><?= htmlspecialchars($d['deskripsi']) ?></td>
            <td>
              <a class="btn-small" href="KategoriController.php?action=edit&id=<?= $d['id_kategori'] ?>">Edit</a>
              <a class="btn-small-danger" href="KategoriController.php?action=delete&id=<?= $d['id_kategori'] ?>" onclick="return confirm('Hapus kategori?')">Hapus</a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>

  <!-- pagination -->
  <div class="pagination">
    <?php for ($i=1; $i <= max(1,$pages); $i++): ?>
      <a class="page-item <?= $i == $page ? 'active' : '' ?>" href="?page=<?= $i ?>&search=<?= urlencode($keyword) ?>"><?= $i ?></a>
    <?php endfor; ?>
  </div>
</div>

<script>
// debounce search
let timer = null;
document.getElementById('searchBox').addEventListener('keyup', function () {
  clearTimeout(timer);
  let q = this.value.trim();
  timer = setTimeout(() => {
    // client-side filter first
    let rows = document.querySelectorAll('#dataTable tbody tr');
    rows.forEach(r => {
      r.style.display = r.innerText.toLowerCase().includes(q.toLowerCase()) ? '' : 'none';
    });
    // optional: you can also trigger server-side search by redirect:
    // window.location.href = 'KategoriController.php?action=index&search=' + encodeURIComponent(q);
  }, 150);
});
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>
