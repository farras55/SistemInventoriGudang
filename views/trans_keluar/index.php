<?php
$title = "Transaksi Keluar";
include __DIR__ . '/../layout/header.php';
?>

<h2>Transaksi Keluar</h2>

<a class="btn" href="TransaksiKeluarController.php?action=create">+ Tambah Transaksi</a>

<table class="table mt-16">
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
        <?php foreach ($data as $t): ?>
        <tr>
            <td><?= $t['id_trans_keluar'] ?></td>
            <td><?= htmlspecialchars($t['nama_barang']) ?></td>
            <td><?= $t['tanggal'] ?></td>
            <td><?= $t['jumlah'] ?></td>
            <td>
                <a class="btn-small-danger"
                    href="TransaksiKeluarController.php?action=delete&id=<?= $t['id_trans_keluar'] ?>"
                    onclick="return confirm('Yakin hapus transaksi ini?')">
                    Hapus
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__ . '/../layout/footer.php'; ?>
