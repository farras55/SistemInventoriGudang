<?php
$title = "Laporan Mutasi Barang";
include __DIR__ . '/../layout/header.php';
?>

<h2>Laporan Mutasi Barang</h2>

<form method="GET" action="LaporanController.php" class="mt-16">
    <input type="hidden" name="action" value="mutasi">
    <input type="text" name="barang" class="input" placeholder="Cari nama barang..." value="<?= htmlspecialchars($_GET['barang'] ?? '') ?>">
    <button class="btn">Cari</button>
</form>

<table class="table mt-20">
    <thead>
        <tr>
            <th>Nama Barang</th>
            <th>Total Masuk</th>
            <th>Total Keluar</th>
            <th>Saldo Mutasi</th>
        </tr>
    </thead>

    <tbody>
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
    </tbody>
</table>

<?php include __DIR__ . '/../layout/footer.php'; ?>
