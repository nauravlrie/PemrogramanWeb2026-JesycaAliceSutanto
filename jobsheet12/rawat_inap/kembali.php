<?php
require_once __DIR__ . '/../includes/auth.php';

$page_title = "Pasien Rawat Inap Aktif";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$keyword = trim($_GET['q'] ?? '');

$sqlDasar = "SELECT r.id, r.tanggal_masuk, r.keterangan,
                    p.no_pasien, p.nama_hewan, p.spesies, p.nama_pemilik,
                    k.kode_kandang, k.nama_kandang
             FROM rawat_inap r
             JOIN pasien p ON p.id = r.pasien_id
             JOIN kandang k ON k.id = r.kandang_id
             WHERE r.status = 'dirawat'";

if ($keyword !== '') {
    $stmt = $pdo->prepare($sqlDasar . " AND (p.nama_hewan ILIKE :kw OR p.no_pasien ILIKE :kw OR k.nama_kandang ILIKE :kw) ORDER BY r.tanggal_masuk ASC");
    $stmt->execute(['kw' => '%' . $keyword . '%']);
} else {
    $stmt = $pdo->query($sqlDasar . " ORDER BY r.tanggal_masuk ASC");
}

$daftarAktif = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

        <section>
            <article>
                <div class="section-header" style="margin-bottom: 20px;">
                    <h2>Pasien Rawat Inap Aktif</h2>
                    <span class="section-subtitle">Daftar anabul yang sedang dalam masa perawatan inap klinik</span>
                </div>

                <?php if ($flash): ?>
                    <div class="flash flash-<?php echo e($flash['type']); ?>">
                        <?php echo e($flash['pesan']); ?>
                    </div>
                <?php endif; ?>

                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 16px;">
                    <div>
                        <a href="tambah.php" class="btn btn-primary">+ Check-in Pasien Baru</a>
                        <a href="riwayat.php" class="btn btn-secondary" style="margin-left: 6px;">Lihat Riwayat Selesai</a>
                    </div>

                    <div class="search-box">
                        <form method="GET" action="kembali.php" style="display: flex; gap: 6px; align-items: center;">
                            <input type="text" name="q" value="<?php echo e($keyword); ?>" placeholder="Cari hewan, pasien, kandang..." class="form-control" style="width: 250px; padding: 7px 12px; font-size: 13px;">
                            <button type="submit" class="btn btn-primary btn-sm">Cari</button>
                            <?php if ($keyword !== ''): ?>
                                <a href="kembali.php" class="btn btn-secondary btn-sm">Reset</a>
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
                                <th>Tanggal Masuk</th>
                                <th>Pemilik</th>
                                <th>Keterangan / Diagnosa</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($daftarAktif)): ?>
                                <tr>
                                    <td colspan="7" style="text-align: center; color: #846F65; padding: 24px;">
                                        <?php if ($keyword !== ''): ?>
                                            Tidak ditemukan pasien aktif dengan kata kunci "<strong><?php echo e($keyword); ?></strong>".
                                        <?php else: ?>
                                            Tidak ada pasien yang sedang rawat inap saat ini. Seluruh anabul telah sehat/pulang.
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($daftarAktif as $row): ?>
                                    <tr>
                                        <td><strong><?php echo e($row['no_pasien']); ?></strong></td>
                                        <td><?php echo e($row['nama_hewan']); ?> (<?php echo e($row['spesies']); ?>)</td>
                                        <td><span class="badge-pill badge-strawberry">[<?php echo e($row['kode_kandang']); ?>] <?php echo e($row['nama_kandang']); ?></span></td>
                                        <td><?php echo e(date('d M Y', strtotime($row['tanggal_masuk']))); ?></td>
                                        <td><?php echo e($row['nama_pemilik']); ?></td>
                                        <td><?php echo e($row['keterangan'] ?? '-'); ?></td>
                                        <td style="text-align: center; white-space: nowrap;">
                                            <form method="POST" action="proses_kembali.php" style="display: inline-block;" onsubmit="return confirm('Konfirmasi bahwa pasien anabul ini telah selesai dirawat dan siap pulang? Slot kandang akan otomatis dikembalikan.');">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="id" value="<?php echo e($row['id']); ?>">
                                                <button type="submit" class="btn btn-primary btn-sm" style="background-color: #5B7A58; border: none; cursor: pointer;">
                                                    Selesai / Pulang
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </article>
        </section>

<?php include __DIR__ . '/../includes/footer.php'; ?>