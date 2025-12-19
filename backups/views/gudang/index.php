<?php
$title = "Data Gudang";
include __DIR__ . '/../layout/header.php';
?>

<div class="page-header">
    <h2>Data Gudang</h2>
    <a class="btn" href="GudangController.php?action=create">+ Tambah Gudang</a>
</div>

<!-- SEARCH & TOTAL -->
<div style="display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:18px;">
    <input id="searchBox" type="text" placeholder="Cari gudang..." class="input" style="min-width:280px;" value="<?= htmlspecialchars($keyword ?? '') ?>">
    <span class="muted">Total: <?= $total ?? count($data) ?></span>
</div>

<table class="table" id="dataTable">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Gudang</th>
            <th>Lokasi</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php if (empty($data)): ?>
            <tr>
                <td colspan="4" style="text-align:center;padding:18px;">Data tidak ditemukan</td>
            </tr>
        <?php else: ?>
            <?php $i = 1 + (($page-1) * ($limit ?? 10)); foreach ($data as $d): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= htmlspecialchars($d['nama_gudang']) ?></td>
                <td><?= htmlspecialchars($d['lokasi']) ?></td>

                <td>
                    <div class="action-btns">
                        <a class="btn-small"
                           href="GudangController.php?action=edit&id=<?= $d['id_gudang'] ?>">
                           Edit
                        </a>

                        <a class="btn-small-danger"
                           onclick="return confirm('Hapus data ini?')"
                           href="GudangController.php?action=delete&id=<?= $d['id_gudang'] ?>">
                           Hapus
                        </a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<!-- PAGINATION -->
<div class="pagination">
    <?php for ($i=1; $i <= max(1, $pages ?? 1); $i++): ?>
        <a class="page-item <?= ($i == ($page ?? 1)) ? 'active' : '' ?>"
           href="?page=<?= $i ?>&search=<?= urlencode($keyword ?? '') ?>">
           <?= $i ?>
        </a>
    <?php endfor; ?>
</div>

<script>
// global server-side search: redirect with ?search=...&page=1 after user stops typing
let timer = null;
const sb = document.getElementById('searchBox');
if (sb) {
    sb.addEventListener('keyup', function () {
        clearTimeout(timer);
        const q = this.value.trim();
        timer = setTimeout(() => {
            const params = new URLSearchParams(window.location.search);
            if (q) params.set('search', q); else params.delete('search');
            params.set('page', '1');
                        window.location.search = params.toString();
        }, 300);
    });
}
// keep focus in search input after page reload so user can continue typing
document.addEventListener('DOMContentLoaded', function () {
    const sb2 = document.getElementById('searchBox');
    if (sb2) {
        sb2.focus();
        const len = sb2.value.length;
        try { sb2.setSelectionRange(len, len); } catch (e) { }
    }
});
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>
