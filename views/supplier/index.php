<?php
$title = "Data Supplier";
include __DIR__ . '/../layout/header.php';
?>
<div class="table-box">
  <h3 class="form-title">Data Supplier</h3>

  <a class="btn" href="SupplierController.php?action=create">+ Tambah Supplier</a>

  <table class="table">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Supplier</th>
        <th>Kontak</th>
        <th>Alamat</th>
        <th>Email</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php $i = 1; foreach ($data as $d): ?>
      <tr>
        <td><?= $i++ ?></td>
        <td><?= htmlspecialchars($d['nama_supplier']) ?></td>
        <td><?= htmlspecialchars($d['kontak']) ?></td>
        <td><?= htmlspecialchars($d['alamat']) ?></td>
        <td><?= htmlspecialchars($d['email']) ?></td>
        <td>
          <a class="btn-small" href="SupplierController.php?action=edit&id=<?= $d['id_supplier'] ?>">Edit</a>
          <a class="btn-small-danger" onclick="return confirm('Hapus supplier?')" 
             href="SupplierController.php?action=delete&id=<?= $d['id_supplier'] ?>">Hapus</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
