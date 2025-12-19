<?php
$title = "Transaksi Keluar";
include __DIR__ . '/../layout/header.php';
?>

<div class="page-header">
    <h2>Data Transaksi Keluar</h2>
    <a class="btn" href="TransaksiKeluarController.php?action=create">+ Tambah Transaksi</a>
</div>

<?php if (isset($_GET['success'])): ?>
  <p class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></p>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
  <p class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></p>
<?php endif; ?>



<div style="display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:18px;">
    <input id="searchBox" type="text" placeholder="Cari transaksi (barang)..." class="input" style="min-width:280px;" value="<?= htmlspecialchars($keyword ?? '') ?>">
    <span class="muted">Total: <?= $total ?? count($data) ?></span>
</div>

<table class="table" id="dataTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Barang</th>
            <th>Tanggal</th>
            <th>Jumlah</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php if (empty($data)): ?>
            <tr>
                <td colspan="5" style="text-align:center;padding:18px;">Data tidak ditemukan</td>
            </tr>
        <?php else: ?>
            <?php foreach ($data as $t): ?>
            <tr>
                <td><?= $t['id_trans_keluar'] ?></td>
                <td><?= htmlspecialchars($t['nama_barang']) ?></td>
                <td><?= $t['tanggal'] ?></td>
                <td><?= $t['jumlah'] ?></td>

                <td>
                    <div class="action-btns">
                        <a class="btn-small-danger"
                            href="TransaksiKeluarController.php?action=delete&id=<?= $t['id_trans_keluar'] ?>"
                            onclick="return confirm('Yakin hapus transaksi ini?')">
                            Hapus
                        </a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>


<div class="pagination">
    <?php for ($i=1; $i <= max(1, $pages ?? 1); $i++): ?>
        <a class="page-item <?= ($i == ($page ?? 1)) ? 'active' : '' ?>"
           href="?page=<?= $i ?>&search=<?= urlencode($keyword ?? '') ?>">
           <?= $i ?>
        </a>
    <?php endfor; ?>
</div>

<script>

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
