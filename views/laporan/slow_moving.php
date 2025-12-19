<?php
$title = "Laporan Barang Slow Moving";
include __DIR__ . '/../layout/header.php';
?>

<h2>Laporan Barang Slow Moving</h2>


<form method="GET"
      action="/../controllers/LaporanController.php"
      class="mt-16"
      style="display:flex;flex-wrap:wrap;gap:8px;align-items:center;">

    
    <input type="hidden" name="action" value="slowMoving">

    <div style="min-width:220px;">
        <input type="text"
               name="search"
               class="input"
               placeholder="Cari nama barang..."
               value="<?= htmlspecialchars($keyword ?? '') ?>">
    </div>

    <button class="btn">Cari</button>

    <span class="muted">Total: <?= $total ?></span>
</form>

<table class="table mt-20">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Total Keluar (Periode)</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($data)): ?>
            <tr>
                <td colspan="3" style="text-align:center;padding:16px;">
                    Tidak ada data
                </td>
            </tr>
        <?php else: ?>
            <?php
            $no = 1 + (($page ?? 1) - 1) * 10;
            foreach ($data as $row):
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                    <td><?= $row['total_keluar'] ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>


<div class="pagination">
    <?php for ($i = 1; $i <= max(1, $pages ?? 1); $i++): ?>
        <a class="page-item <?= ($i == ($page ?? 1)) ? 'active' : '' ?>"
           href="LaporanController.php?action=slowMoving&page=<?= $i ?>&search=<?= urlencode($keyword ?? '') ?>">
            <?= $i ?>
        </a>
    <?php endfor; ?>
</div>


<?php include __DIR__ . '/../layout/footer.php'; ?>
