<?php
$title = "Data Gudang";
include __DIR__ . '/../layout/header.php';
?>
<div class="table-box">
  <h3 class="form-title">Data Gudang</h3>

  <a class="btn" href="GudangController.php?action=create">+ Tambah Gudang</a>

  <table class="table">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Gudang</th>
        <th>Lokasi</th>
        <th>Aksi</th>
      </tr>
    </thead>

    <tbody>
      <?php $i = 1; foreach ($data as $d): ?>
      <tr>
        <td><?= $i++ ?></td>
        <td><?= htmlspecialchars($d['nama_gudang']) ?></td>
        <td><?= htmlspecialchars($d['lokasi']) ?></td>
        <td>
          <a class="btn-small" href="GudangController.php?action=edit&id=<?= $d['id_gudang'] ?>">Edit</a>
          <a class="btn-small-danger" onclick="return confirm('Hapus data ini?')"
             href="GudangController.php?action=delete&id=<?= $d['id_gudang'] ?>">Hapus</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>

  </table>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
