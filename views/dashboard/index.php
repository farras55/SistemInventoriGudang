<?php

$title = "Dashboard";
include __DIR__ . '/../layout/header.php';
?>

<div class="content-inner">

    <div class="page-header">
        <h2>Dashboard</h2>
    </div>

    
    <div class="dashboard-grid" style="margin-top:12px;">
        <div class="card">
            <h3>Total Barang</h3>
            <div style="font-size:24px;font-weight:600;margin:4px 0;">
                <?= (int)($counts['total_barang'] ?? 0) ?>
            </div>
            <p class="muted">Jumlah master barang yang terdaftar.</p>
        </div>

        <div class="card">
            <h3>Barang Menipis</h3>
            <div style="font-size:24px;font-weight:600;margin:4px 0;">
                <?= (int)($counts['barang_menipis'] ?? 0) ?>
            </div>
            <p class="muted">Stok di bawah minimum.</p>
        </div>

        <div class="card">
            <h3>Masuk Bulan Ini</h3>
            <div style="font-size:24px;font-weight:600;margin:4px 0;">
                <?= (int)($counts['total_masuk_bulan_ini'] ?? 0) ?>
            </div>
            <p class="muted">Total jumlah barang masuk.</p>
        </div>

        <div class="card">
            <h3>Keluar Bulan Ini</h3>
            <div style="font-size:24px;font-weight:600;margin:4px 0;">
                <?= (int)($counts['total_keluar_bulan_ini'] ?? 0) ?>
            </div>
            <p class="muted">Total jumlah barang keluar.</p>
        </div>

        <div class="card">
            <h3>Nilai Persediaan</h3>
            <div style="font-size:20px;font-weight:600;margin:4px 0;">
                Rp <?= number_format((float)($counts['total_nilai_persediaan'] ?? 0), 0, ',', '.') ?>
            </div>
            <p class="muted">Perkiraan nilai semua stok.</p>
        </div>

        <div class="card">
            <h3>Total Supplier & Gudang</h3>
            <div style="font-size:15px;margin:4px 0;">
                Supplier: <strong><?= (int)($counts['total_supplier'] ?? 0) ?></strong><br>
                Gudang: <strong><?= (int)($counts['total_gudang'] ?? 0) ?></strong>
            </div>
            <p class="muted">Relasi pendukung stok.</p>
        </div>
    </div>

       
        <div style="display:flex;flex-wrap:wrap;gap:18px;margin-top:22px;align-items:flex-start;">

            
            <div class="card" style="flex:1 1 380px;min-width:280px;">
                <h3>Barang Stok Menipis</h3>
                <p class="muted" style="margin-bottom:10px;">Top 5 barang dengan stok di bawah minimum.</p>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th>Kategori</th>
                            <th>Gudang</th>
                            <th>Stok</th>
                            <th>Min</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($barangMenipis)): ?>
                            <tr>
                                <td colspan="5" style="text-align:center;padding:10px;">
                                    Tidak ada barang menipis.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($barangMenipis as $b): ?>
                                <tr>
                                    <td><?= htmlspecialchars($b['nama_barang']) ?></td>
                                    <td><?= htmlspecialchars($b['nama_kategori'] ?? '-') ?></td>
                                    <td><?= htmlspecialchars($b['nama_gudang'] ?? '-') ?></td>
                                    <td><?= (int)$b['stok'] ?></td>
                                    <td><?= (int)$b['stok_minimum'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            
            <div class="card" style="flex:1 1 380px;min-width:280px;">
                <h3>Barang Slow Moving</h3>
                <p class="muted" style="margin-bottom:10px;">Top 5 barang dengan pergerakan keluar paling kecil.</p>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th>Total Keluar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($slowMoving)): ?>
                            <tr>
                                <td colspan="2" style="text-align:center;padding:10px;">
                                    Tidak ada data slow moving.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($slowMoving as $s): ?>
                                <tr>
                                    <td><?= htmlspecialchars($s['nama_barang']) ?></td>
                                    <td><?= (int)$s['total_keluar'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>


    
    <div class="card" style="margin-top:22px;">
        <h3>Transaksi Terbaru</h3>
        <p class="muted" style="margin-bottom:10px;">10 transaksi masuk / keluar terakhir.</p>
        <table class="table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>Barang</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($transaksiTerbaru)): ?>
                    <tr>
                        <td colspan="4" style="text-align:center;padding:10px;">
                            Belum ada transaksi.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($transaksiTerbaru as $t): ?>
                        <tr>
                            <td><?= date('d-m-Y', strtotime($t['tanggal'])) ?></td>
                            <td>
                                <span class="badge <?= $t['jenis'] === 'MASUK' ? 'badge-green' : 'badge-yellow' ?>">
                                    <?= htmlspecialchars($t['jenis']) ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($t['nama_barang']) ?></td>
                            <td><?= (int)$t['jumlah'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
