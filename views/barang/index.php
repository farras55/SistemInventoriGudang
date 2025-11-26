<?php
$title = "Data Barang";
include __DIR__ . '/../layout/header.php';
?>

<div class="page-header">
    <h2>Data Barang</h2>
    <a class="btn" href="/../controllers/BarangController.php?action=create">+ Tambah Barang</a>
</div>

<!-- SEARCH & TOTAL -->
<div style="display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:18px;">
    <input id="searchBox" type="text" placeholder="Cari barang..." class="input" style="min-width:280px;" value="<?= htmlspecialchars($keyword ?? '') ?>">
    <span class="muted">Total: <?= $total ?? count($data) ?></span>
</div>

<table class="table" id="dataTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Supplier</th>
            <th>Gudang</th>
            <th>Stok</th>
            <th>Min Stok</th>
            <th>Harga Satuan</th>
            <th>Status Stok</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php if (empty($data)): ?>
            <tr>
                <td colspan="10" style="text-align:center;padding:18px;">Data tidak ditemukan</td>
            </tr>
        <?php else: ?>
            <?php foreach ($data as $b): ?>
            <tr>
                <td><?= $b['id_barang'] ?></td>
                <td><?= htmlspecialchars($b['nama_barang']) ?></td>
                <td><?= htmlspecialchars($b['nama_kategori']) ?></td>
                <td><?= htmlspecialchars($b['nama_supplier']) ?></td>
                <td><?= htmlspecialchars($b['nama_gudang']) ?></td>

                <td><?= $b['stok'] ?></td>
                <td><?= $b['stok_minimum'] ?></td>

                <td>Rp <?= number_format($b['harga_satuan'], 0, ',', '.') ?></td>

                <!-- BADGE STATUS STOK -->
                <td>
                <?php 
                    if ($b['stok'] == 0) {
                        echo "<span class='badge badge-red'>Habis</span>";
                    }
                    else if ($b['stok'] < $b['stok_minimum']) {
                        echo "<span class='badge badge-yellow'>Menipis</span>";
                    }
                    else {
                        echo "<span class='badge badge-green'>Tersedia</span>";
                    }
                ?>
                </td>

                <td>
                    <div class="action-btns">
                        <a class="btn-small" 
                           href="/../controllers/BarangController.php?action=edit&id=<?= $b['id_barang'] ?>">
                           Edit
                        </a>

                        <a class="btn-small-danger"
                           href="/../controllers/BarangController.php?action=delete&id=<?= $b['id_barang'] ?>"
                           onclick="return confirm('Yakin hapus barang ini?')">
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
        try { sb2.setSelectionRange(len, len); } catch (e) { /* ignore */ }
    }
});
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>
