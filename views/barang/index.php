<?php
$title = "Data Barang";
include __DIR__ . '/../layout/header.php';
?>

<h2>Data Barang</h2>

<a class="btn" href="/../controllers/BarangController.php?action=create">+ Tambah Barang</a>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Supplier</th>
            <th>Gudang</th>
            <th>Stok</th>
            <th>Min Stok</th>
            <th>harga_satuan</th>
            <th>Keterangan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $b): ?>
            <tr>
                <td><?= $b['id_barang'] ?></td>
                <td><?= htmlspecialchars($b['nama_barang']) ?></td>
                <td><?= htmlspecialchars($b['nama_kategori']) ?></td>
                <td><?= htmlspecialchars($b['nama_supplier']) ?></td>
                <td><?= htmlspecialchars($b['nama_gudang']) ?></td>

                <!-- warning jika stok < minimum stok -->
                <td style="color:<?= $b['stok'] < $b['stok_minimum'] ? 'red' : 'black' ?>">
                    <?= $b['stok'] ?>
                </td>

                <td><?= $b['stok_minimum'] ?></td>

                <td>Rp <?= number_format($b['harga_satuan'], 0, ',', '.') ?></td>
                <td><?= htmlspecialchars($b['keterangan']) ?></td>

                <td>
                    <a class="btn-small" href="/../controllers/BarangController.php?action=edit&id=<?= $b['id_barang'] ?>">Edit</a>
                    <a class="btn-small-danger" 
                       href="/../controllers/BarangController.php?action=delete&id=<?= $b['id_barang'] ?>"
                       onclick="return confirm('Yakin hapus barang ini?')">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__ . '/../layout/footer.php'; ?>
