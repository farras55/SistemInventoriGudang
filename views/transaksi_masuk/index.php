<?php 
$title = "Transaksi Masuk";
include __DIR__ . '/../layout/header.php';
?>

<div class="page-header">
    <h2>Data Transaksi Masuk</h2>
    <a href="TransaksiMasukController.php?action=create" class="btn">+ Tambah Transaksi</a>
</div>

<?php if (isset($_GET['success'])): ?>
    <p class="alert alert-success"><?= $_GET['success'] ?></p>
<?php endif; ?>


<div style="display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:18px;">
    <input id="searchBox" type="text" placeholder="Cari transaksi (barang)..." class="input" style="min-width:280px;" value="<?= htmlspecialchars($keyword ?? '') ?>">
    <span class="muted">Total: <?= $total ?? count($data) ?></span>
</div>

<table class="table" id="dataTable">
    <thead>
        <tr>
            <th>No</th>
            <th>Barang</th>
            <th>Jumlah</th>
            <th>No PO</th>
            <th>Tanggal</th>
        </tr>
    </thead>

    <tbody>
        <?php if (empty($data)): ?>
            <tr>
                <td colspan="5" style="text-align:center;padding:18px;">Data tidak ditemukan</td>
            </tr>
        <?php else: ?>
        <?php 
        $no = 1 + (($page-1) * ($limit ?? 10));
        foreach ($data as $row): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                <td><?= $row['jumlah'] ?></td>
                <td><?= $row['no_po'] ?></td>
                <td><?= $row['tanggal'] ?></td>
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
