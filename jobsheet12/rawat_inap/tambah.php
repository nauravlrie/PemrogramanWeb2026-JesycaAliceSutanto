<?php
require_once __DIR__ . '/../includes/auth.php';

$page_title = "Pendaftaran Rawat Inap";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

// Mengambil seluruh pasien terdaftar
$daftarPasien = $pdo->query("SELECT * FROM pasien ORDER BY nama_hewan ASC")->fetchAll(PDO::FETCH_ASSOC);

// Mengambil kandang yang masih memiliki kapasitas/slot tersedia (kapasitas > 0)
$daftarKandangTersedia = $pdo->query("SELECT * FROM kandang WHERE kapasitas > 0 ORDER BY kode_kandang ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

        <section>
            <article>
                <div class="section-header" style="margin-bottom: 20px;">
                    <h2>Pendaftaran Rawat Inap Baru</h2>
                    <span class="section-subtitle">Mencatat pasien anabul masuk ke ruang perawatan klinik</span>
                </div>

                <?php if ($flash): ?>
                    <div class="flash flash-<?php echo e($flash['type']); ?>">
                        <?php echo e($flash['pesan']); ?>
                    </div>
                <?php endif; ?>

                <?php if (empty($daftarPasien)): ?>
                    <div class="flash flash-error">
                        Belum ada data pasien di database. Silakan tambahkan data pasien terlebih dahulu.
                    </div>
                <?php elseif (empty($daftarKandangTersedia)): ?>
                    <div class="flash flash-error">
                        Seluruh kandang dan ruang rawat saat ini sedang penuh (kapasitas 0).
                    </div>
                <?php else: ?>
                    <form action="proses_tambah.php" method="POST">
                        <?php echo csrf_field(); ?>

                        <div class="form-group">
                            <label for="pasien_id">Pilih Pasien Anabul *</label>
                            <select id="pasien_id" name="pasien_id" class="form-control" required>
                                <option value="">-- Pilih Pasien --</option>
                                <?php foreach ($daftarPasien as $p): ?>
                                    <option value="<?php echo e($p['id']); ?>">
                                        <?php echo e($p['nama_hewan']); ?> (<?php echo e($p['spesies']); ?>) - Pemilik: <?php echo e($p['nama_pemilik']); ?> [<?php echo e($p['no_pasien']); ?>]
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="kandang_id">Pilih Kandang / Ruang Rawat *</label>
                            <select id="kandang_id" name="kandang_id" class="form-control" required>
                                <option value="">-- Pilih Ruang Rawat --</option>
                                <?php foreach ($daftarKandangTersedia as $k): ?>
                                    <option value="<?php echo e($k['id']); ?>">
                                        [<?php echo e($k['kode_kandang']); ?>] <?php echo e($k['nama_kandang']); ?> (Tipe: <?php echo e($k['tipe']); ?> | Sisa Slot: <?php echo e($k['kapasitas']); ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="tanggal_masuk">Tanggal Masuk Rawat *</label>
                            <input type="date" id="tanggal_masuk" name="tanggal_masuk" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan / Diagnosa Pengawasan</label>
                            <textarea id="keterangan" name="keterangan" class="form-control" rows="3" placeholder="Contoh: Observasi pasca-operasi, pemulihan dehidrasi..."></textarea>
                        </div>

                        <div style="margin-top: 24px; display: flex; gap: 10px;">
                            <button type="submit" class="btn btn-primary">Daftarkan Rawat Inap</button>
                            <a href="../index.php" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                <?php endif; ?>
            </article>
        </section>

<?php include __DIR__ . '/../includes/footer.php'; ?>