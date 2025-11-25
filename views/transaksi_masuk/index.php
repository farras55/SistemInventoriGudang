<?php 
$title = "Transaksi Masuk";
include __DIR__ . '/../layout/header.php';
?>

<div class="table-box">
    <h3 class="table-title">Data Transaksi Masuk</h3>

    <?php if (isset($_GET['success'])): ?>
        <p class="alert alert-success"><?= $_GET['success'] ?></p>
    <?php endif; ?>

    <a href="TransaksiMasukController.php?action=create" class="btn">+ Tambah Transaksi</a>
    <br><br>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>No PO</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no=1;
            foreach ($data as $row): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['nama_barang'] ?></td>
                <td><?= $row['jumlah'] ?></td>
                <td><?= $row['no_po'] ?></td>
                <td><?= $row['tanggal'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
