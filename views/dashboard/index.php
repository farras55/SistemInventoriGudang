<?php
// views/dashboard/index.php
// Variabel $title dan $totalStok dikirim dari DashboardController

include __DIR__ . '/../layout/header.php';
?>

<div class="page-header">
    <div class="dashboard-intro">
        <div>
            <h2>Dashboard</h2>
            <p class="muted">Ringkasan cepat kondisi gudang dan stok.</p>
        </div>
        <div>
            <a href="/../controllers/BarangController.php?action=index" class="btn">Kelola Barang</a>
        </div>
    </div>
</div>

<div class="dashboard-grid">
    <div class="card primary-card">
        <div class="card-row">
            <div>
                <h3 class="card-title">Total Stok Barang</h3>
                <p class="stat-number"><?= number_format((int)($totalStok ?? 0), 0, ',', '.') ?></p>
                <p class="stat-desc">Total unit barang saat ini di semua gudang.</p>
            </div>
            <div class="card-icon">📦</div>
        </div>
    </div>

    <a href="/../controllers/BarangController.php?action=index" class="card small-card">
        <h4 class="card-title">Jenis Barang</h4>
        <p class="stat-number"><?= number_format((int)($totalItems ?? 0), 0, ',', '.') ?></p>
        <p class="muted">Jumlah jenis barang terdaftar</p>
    </a>

    <a href="/../controllers/BarangController.php?action=index" class="card small-card">
        <h4 class="card-title">Barang Menipis</h4>
        <p class="stat-number"><?= number_format((int)($lowStockCount ?? 0), 0, ',', '.') ?></p>
        <p class="muted">Jumlah item dengan stok yang menipis (≤ stok minimum)</p>
    </a>
</div>

<div class="empty-box">
    <p><strong>ℹ️ Catatan:</strong> Klik "Kelola Barang" untuk melihat detail dan menambah stok. Kamu bisa menambahkan widget lain seperti grafik transaksi harian jika perlu.</p>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
