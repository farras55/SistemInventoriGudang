<?php
$title = "Data Barang";
include __DIR__ . '/../layout/header.php';
?>

<div class="page-header">
    <h2>Data Barang</h2>
    <a class="btn" href="/../controllers/BarangController.php?action=create">+ Tambah Barang</a>
</div>

<!-- FORM SEARCH + FILTER (gaya mirip stok_opname) -->
<form method="GET"
      action="BarangController.php"
      class="mt-16"
      style="display:flex;flex-wrap:wrap;gap:8px;align-items:flex-end;">

    <input type="hidden" name="action" value="index">

    <!-- Search -->
    <div style="min-width:220px;">
        <input id="searchBox"
               type="text"
               name="search"
               class="input"
               placeholder="Cari nama barang / kategori..."
               value="<?= htmlspecialchars($keyword ?? '') ?>">
    </div>

    <!-- Filter Kategori -->
    <div>
        <select name="kategori" class="input">
            <option value="">Semua Kategori</option>
            <?php foreach ($kategori as $k): ?>
                <option value="<?= $k['id_kategori'] ?>"
                    <?= (($_GET['kategori'] ?? ($id_kategori ?? '')) == $k['id_kategori']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($k['nama_kategori']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Filter Supplier -->
    <div>
        <select name="supplier" class="input">
            <option value="">Semua Supplier</option>
            <?php foreach ($supplier as $s): ?>
                <option value="<?= $s['id_supplier'] ?>"
                    <?= (($_GET['supplier'] ?? ($id_supplier ?? '')) == $s['id_supplier']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($s['nama_supplier']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Filter Gudang -->
    <div>
        <select name="gudang" class="input">
            <option value="">Semua Gudang</option>
            <?php foreach ($gudang as $g): ?>
                <option value="<?= $g['id_gudang'] ?>"
                    <?= (($_GET['gudang'] ?? ($id_gudang ?? '')) == $g['id_gudang']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($g['nama_gudang']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <button class="btn">Terapkan</button>
    </div>

    <span class="muted">Total: <?= $total ?? count($data) ?></span>
</form>

<!-- TABEL DATA BARANG -->
<table class="table mt-20" id="dataTable">
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
                <?php
                    $stok = (int)$b['stok'];
                    $min  = (int)$b['stok_minimum'];

                    if ($stok == 0) {
                        $badgeClass = 'badge-red';
                        $statusText = 'Habis';
                    } elseif ($stok < $min) {
                        $badgeClass = 'badge-yellow';
                        $statusText = 'Menipis';
                    } else {
                        $badgeClass = 'badge-green';
                        $statusText = 'Tersedia';
                    }
                ?>
                <tr>
                    <td><?= $b['id_barang'] ?></td>
                    <td><?= htmlspecialchars($b['nama_barang']) ?></td>
                    <td><?= htmlspecialchars($b['nama_kategori']) ?></td>
                    <td><?= htmlspecialchars($b['nama_supplier']) ?></td>
                    <td><?= htmlspecialchars($b['nama_gudang']) ?></td>
                    <td><?= $stok ?></td>
                    <td><?= $min ?></td>
                    <td>Rp <?= number_format($b['harga_satuan'], 0, ',', '.') ?></td>
                    <td><span class="badge <?= $badgeClass ?>"><?= $statusText ?></span></td>
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
    <?php for ($i = 1; $i <= max(1, $pages ?? 1); $i++): ?>
        <a class="page-item <?= ($i == ($page ?? 1)) ? 'active' : '' ?>"
           href="?action=index
                &page=<?= $i ?>
                &search=<?= urlencode($keyword ?? '') ?>
                &kategori=<?= urlencode($_GET['kategori'] ?? ($id_kategori ?? '')) ?>
                &supplier=<?= urlencode($_GET['supplier'] ?? ($id_supplier ?? '')) ?>
                &gudang=<?= urlencode($_GET['gudang'] ?? ($id_gudang ?? '')) ?>">
            <?= $i ?>
        </a>
    <?php endfor; ?>
</div>

<script>
// tetap boleh: live-search dengan debounce
let timer = null;
const sb = document.getElementById('searchBox');
if (sb) {
    sb.addEventListener('keyup', function () {
        clearTimeout(timer);
        const q = this.value.trim();
        timer = setTimeout(() => {
            const params = new URLSearchParams(window.location.search);
            if (q) params.set('search', q); else params.delete('search');
            params.set('action', 'index');
            params.set('page', '1');
            window.location.search = params.toString();
        }, 300);
    });
}

// fokus otomatis ke search setelah reload
document.addEventListener('DOMContentLoaded', function () {
    const sb2 = document.getElementById('searchBox');
    if (sb2) {
        sb2.focus();
        const len = sb2.value.length;
        try { sb2.setSelectionRange(len, len); } catch (e) {}
    }
});
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>
