<?php
require_once __DIR__ . '/../includes/auth.php';

$page_title = "Riwayat Rawat Inap";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$pasienId = $_GET['pasien_id'] ?? '';
$daftarPasien = $pdo->query("SELECT * FROM pasien ORDER BY nama_hewan ASC")->fetchAll(PDO::FETCH_ASSOC);

$sqlDasar = "SELECT r.id, r.tanggal_masuk, r.tanggal_keluar, r.status, r.keterangan,
                    p.no_pasien, p.nama_hewan, p.spesies, p.nama_pemilik,
                    k.kode_kandang, k.nama_kandang
             FROM rawat_inap r
             JOIN pasien p ON p.id = r.pasien_id
             JOIN kandang k ON k.id = r.kandang_id";

if ($pasienId !== '') {
    $stmt = $pdo->prepare($sqlDasar . " WHERE r.pasien_id = :id ORDER BY r.tanggal_masuk DESC");
    $stmt->execute(['id' => $pasienId]);
} else {
    $stmt = $pdo->query($sqlDasar . " ORDER BY r.tanggal_masuk DESC");
}

$riwayat = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

        <section>
            <article>
                <div class="section-header" style="margin-bottom: 20px;">
                    <h2>Riwayat Transaksi Rawat Inap</h2>
                    <span class="section-subtitle">Histori lengkap perawatan anabul terintegrasi multi-tabel (Pasien, Ruang, dan Transaksi)</span>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 16px;">
                    <div>
                        <a href="kembali.php" class="btn btn-secondary">← Pasien Aktif</a>
                        <a href="tambah.php" class="btn btn-primary" style="margin-left: 6px;">+ Check-in Baru</a>
                    </div>

                    <!-- Filter Berdasarkan Pasien -->
                    <div>
                        <form method="GET" action="riwayat.php" style="display: flex; gap: 6px; align-items: center;">
                            <select name="pasien_id" class="form-control" style="font-size: 13px; padding: 6px 10px;">
                                <option value="">-- Semua Pasien --</option>
                                <?php foreach ($daftarPasien as $p): ?>
                                    <option value="<?php echo e($p['id']); ?>" <?php echo (string)$pasienId === (string)$p['id'] ? 'selected' : ''; ?>>
                                        <?php echo e($p['nama_hewan']); ?> (<?php echo e($p['no_pasien']); ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                            <?php if ($pasienId !== ''): ?>
                                <a href="riwayat.php" class="btn btn-secondary btn-sm">Reset</a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>

                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>No Pasien</th>
                                <th>Nama Hewan</th>
                                <th>Kandang / Ruang</th>
                                <th>Tgl Masuk</th>
                                <th>Tgl Keluar</th>
                                <th>Status</th>
                                <th>Keterangan Diagnosa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($riwayat)): ?>
                                <tr>
                                    <td colspan="7" style="text-align: center; color: #846F65; padding: 24px;">
                                        Belum ada data riwayat rawat inap yang tercatat.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($riwayat as $row): ?>
                                    <tr>
                                        <td><strong><?php echo e($row['no_pasien']); ?></strong></td>
                                        <td><?php echo e($row['nama_hewan']); ?> (<?php echo e($row['spesies']); ?>)</td>
                                        <td>[<?php echo e($row['kode_kandang']); ?>] <?php echo e($row['nama_kandang']); ?></td>
                                        <td><?php echo e(date('d M Y', strtotime($row['tanggal_masuk']))); ?></td>
                                        <td>
                                            <?php echo $row['tanggal_keluar'] ? e(date('d M Y', strtotime($row['tanggal_keluar']))) : '<em style="color: #846F65;">Masih Dirawat</em>'; ?>
                                        </td>
                                        <td>
                                            <?php if ($row['status'] === 'dirawat'): ?>
                                                <span class="badge-pill badge-peach">Dirawat</span>
                                            <?php else: ?>
                                                <span class="badge-pill badge-vanilla" style="background-color: #E2ECE0; color: #3B6B38;">Selesai</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($row['keterangan'] ?? '-'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </article>
        </section>

<?php include __DIR__ . '/../includes/footer.php'; ?>