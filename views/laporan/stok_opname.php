<?php
$title = "Laporan Stok Opname";
include __DIR__ . '/../layout/header.php';
?>

<h2>Laporan Stok Opname</h2>


<form method="GET"
      action="LaporanController.php"
      class="mt-16"
      style="display:flex;flex-wrap:wrap;gap:8px;align-items:flex-end;">
    
    <input type="hidden" name="action" value="stokOpname">

    
    <div style="min-width:220px;">
        <input type="text"
               name="search"
               class="input"
               placeholder="Cari barang / kategori..."
               value="<?= htmlspecialchars($keyword ?? '') ?>">
    </div>

    
    <div>
        <select name="gudang" class="input">
            <option value="">Semua Gudang</option>
            <?php foreach ($gudang as $g): ?>
                <option value="<?= $g['id_gudang'] ?>"
                    <?= (!empty($id_gudang) && $id_gudang == $g['id_gudang']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($g['nama_gudang']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    
    <div>
        <select name="kategori" class="input">
            <option value="">Semua Kategori</option>
            <?php foreach ($kategori as $k): ?>
                <option value="<?= $k['id_kategori'] ?>"
                    <?= (!empty($id_kategori) && $id_kategori == $k['id_kategori']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($k['nama_kategori']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    
    <div>
        <button class="btn">Filter</button>
    </div>

    <span class="muted">Total: <?= $total ?></span>
</form>


<table class="table mt-20">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Gudang</th>
            <th>Stok Sistem</th>
            <th>Min Stok</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($data)): ?>
            <tr>
                <td colspan="7" style="text-align:center;padding:16px;">
                    Tidak ada data
                </td>
            </tr>
        <?php else: ?>
            <?php foreach ($data as $row): ?>
                <?php
                    $stok = (int)$row['stok'];
                    $min  = (int)$row['stok_minimum'];

                    if ($stok <= 0) {
                        $badgeClass = 'badge-red';
                        $statusText = 'Habis';
                    } elseif ($stok < $min) {
                        $badgeClass = 'badge-yellow';
                        $statusText = 'Menipis';
                    } else {
                        $badgeClass = 'badge-green';
                        $statusText = 'Aman';
                    }
                ?>
                <tr>
                    <td><?= $row['id_barang'] ?></td>
                    <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                    <td><?= htmlspecialchars($row['nama_kategori'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($row['nama_gudang'] ?? '-') ?></td>
                    <td><?= $stok ?></td>
                    <td><?= $min ?></td>
                    <td>
                        <span class="badge <?= $badgeClass ?>"><?= $statusText ?></span>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>


<div class="pagination">
    <?php for ($i = 1; $i <= max(1, $pages ?? 1); $i++): ?>
        <a class="page-item <?= ($i == ($page ?? 1)) ? 'active' : '' ?>"
           href="LaporanController.php?action=stokOpname&page=<?= $i ?>
                &search=<?= urlencode($keyword ?? '') ?>
                &gudang=<?= urlencode($id_gudang ?? '') ?>
                &kategori=<?= urlencode($id_kategori ?? '') ?>">
            <?= $i ?>
        </a>
    <?php endfor; ?>
</div>


<?php include __DIR__ . '/../layout/footer.php'; ?>
