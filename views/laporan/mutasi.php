<?php
$title = "Laporan Mutasi Barang";
include __DIR__ . '/../layout/header.php';
?>

<h2>Laporan Mutasi Barang</h2>
<div style="margin-bottom:10px;">
    <a class="btn" href="LaporanController.php?action=stokRingkasan">Lihat Ringkasan Stok (MV)</a>
</div>
<!-- SEARCH FORM -->
<form method="GET" action="LaporanController.php" class="mt-16" style="display:flex;gap:8px;align-items:center;">
    <input type="hidden" name="action" value="mutasi">
    <input type="text" name="barang" class="input" placeholder="Cari nama barang..." value="<?= htmlspecialchars($_GET['barang'] ?? $_GET['search'] ?? '') ?>">
    <button class="btn">Cari</button>
    <span class="muted">Total: <?= $total ?? count($data) ?></span>
</form>

<table class="table mt-20" id="dataTable">
    <thead>
        <tr>
            <th>Nama Barang</th>
            <th>Total Masuk</th>
            <th>Total Keluar</th>
            <th>Saldo Mutasi</th>
        </tr>
    </thead>

    <tbody>
        <?php if (empty($data)): ?>
            <tr>
                <td colspan="4" style="text-align:center;padding:18px;">Data tidak ditemukan</td>
            </tr>
        <?php else: ?>
        <?php foreach ($data as $d): ?>
            <tr>
                <td><?= htmlspecialchars($d['nama_barang']) ?></td>
                <td><?= $d['total_masuk'] ?></td>
                <td><?= $d['total_keluar'] ?></td>
                <td style="color: <?= $d['saldo_mutasi'] < 0 ? 'red' : 'black' ?>;">
                    <?= $d['saldo_mutasi'] ?>
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
           href="?action=mutasi&page=<?= $i ?>&barang=<?= urlencode($_GET['barang'] ?? $_GET['search'] ?? '') ?>">
           <?= $i ?>
        </a>
    <?php endfor; ?>
</div>

<script>
// global server-side search for laporan: redirect with ?barang=...&page=1 after debounce
let timer = null;
const searchBox = document.querySelector('input[name="barang"]');
if (searchBox) {
    searchBox.addEventListener('keyup', function () {
        clearTimeout(timer);
        const q = this.value.trim();
        timer = setTimeout(() => {
            const params = new URLSearchParams(window.location.search);
            if (q) params.set('barang', q); else params.delete('barang');
            params.set('action', 'mutasi');
            params.set('page', '1');
            window.location.search = params.toString();
        }, 300);
    });
}
// keep focus in laporan search input after reload
document.addEventListener('DOMContentLoaded', function () {
    const sb2 = document.querySelector('input[name="barang"]');
    if (sb2) {
        sb2.focus();
        const len = sb2.value.length;
        try { sb2.setSelectionRange(len, len); } catch (e) { }
    }
});
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>
