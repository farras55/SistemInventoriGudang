<?php
$title = $title ?? "Ringkasan Stok";
include __DIR__ . '/../layout/header.php';
?>

<h2><?= htmlspecialchars($title) ?></h2>

<?php if (!empty($_SESSION['flash_success'])): ?>
    <div class="alert success"><?= htmlspecialchars($_SESSION['flash_success']) ?></div>
    <?php unset($_SESSION['flash_success']); ?>
<?php endif; ?>
<?php if (!empty($_SESSION['flash_error'])): ?>
    <div class="alert error"><?= htmlspecialchars($_SESSION['flash_error']) ?></div>
    <?php unset($_SESSION['flash_error']); ?>
<?php endif; ?>

<div style="display:flex;gap:8px;align-items:center;margin-bottom:12px;">
    <form method="POST" action="LaporanController.php?action=refreshMv" onsubmit="return confirm('Refresh materialized view?')">
        <button class="btn">Refresh MV</button>
    </form>
</div>

<table class="table">
    <thead>
        <tr>
            <th>Nama Kategori</th>
            <th>Total Stok</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($data)): ?>
            <tr><td colspan="2" style="text-align:center;padding:18px;">Data tidak ditemukan</td></tr>
        <?php else: ?>
            <?php foreach ($data as $r): ?>
                <tr>
                    <td><?= htmlspecialchars($r['nama_kategori'] ?? $r['nama_kategori']) ?></td>
                    <td><?= htmlspecialchars($r['total_stok'] ?? $r['total_stok']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?php include __DIR__ . '/../layout/footer.php'; ?>
