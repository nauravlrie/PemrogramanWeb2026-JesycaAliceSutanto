<?php
require_once __DIR__ . '/../includes/auth.php';

$page_title = "Edit Rekam Medis";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: list.php');
    exit;
}

// Mengambil data rekam medis yang akan diedit dari PostgreSQL
$stmt = $pdo->prepare("SELECT * FROM rekam_medis WHERE id = :id");
$stmt->execute(['id' => $id]);
$rm = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$rm) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'pesan' => 'Data rekam medis tidak ditemukan.'
    ];
    header('Location: list.php');
    exit;
}

// Mengambil daftar pasien untuk pilihan dropdown
$daftarPasien = $pdo->query("SELECT * FROM pasien ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

        <section>
            <article>
                <div class="section-header" style="margin-bottom: 20px;">
                    <h2>Edit Rekam Medis</h2>
                    <span class="section-subtitle">Memperbarui catatan pemeriksaan nomor <?php echo htmlspecialchars($rm['no_rm']); ?></span>
                </div>

                <?php if ($flash): ?>
                    <div class="flash flash-<?php echo htmlspecialchars($flash['type']); ?>">
                        <?php echo htmlspecialchars($flash['pesan']); ?>
                    </div>
                <?php endif; ?>

                <form action="proses_edit.php" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($rm['id']); ?>">

                    <div class="form-group">
                        <label for="no_rm_tampil">Nomor Rekam Medis (Otomatis)</label>
                        <input type="text" id="no_rm_tampil" class="form-control" value="<?php echo htmlspecialchars($rm['no_rm']); ?>" disabled style="background-color: #EADFD6; cursor: not-allowed;">
                    </div>

                    <div class="form-group">
                        <label for="pasien">Pilih Pasien *</label>
                        <select id="pasien" name="pasien" class="form-control" required>
                            <option value="">-- Pilih Pasien --</option>
                            <?php foreach ($daftarPasien as $p): ?>
                                <?php
                                $nilaiOpsi = $p['nama_hewan'] . ' (' . $p['spesies'] . ')';
                                $terpilih = ($rm['pasien'] === $nilaiOpsi) ? 'selected' : '';
                                ?>
                                <option value="<?php echo htmlspecialchars($nilaiOpsi); ?>" <?php echo $terpilih; ?>>
                                    <?php echo htmlspecialchars($p['no_pasien'] . ' - ' . $nilaiOpsi); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tanggal">Tanggal Pemeriksaan *</label>
                        <input type="date" id="tanggal" name="tanggal" class="form-control" value="<?php echo htmlspecialchars($rm['tanggal']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="dokter">Dokter Pemeriksa *</label>
                        <select id="dokter" name="dokter" class="form-control" required>
                            <option value="">-- Pilih Dokter --</option>
                            <option value="drh. Ratna Sari" <?php echo ($rm['dokter'] === 'drh. Ratna Sari') ? 'selected' : ''; ?>>drh. Ratna Sari</option>
                            <option value="drh. Hendra Gunawan" <?php echo ($rm['dokter'] === 'drh. Hendra Gunawan') ? 'selected' : ''; ?>>drh. Hendra Gunawan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="diagnosa">Diagnosa & Tindakan *</label>
                        <textarea id="diagnosa" name="diagnosa" class="form-control" rows="3" required><?php echo htmlspecialchars($rm['diagnosa']); ?></textarea>
                    </div>

                    <div style="margin-top: 24px; display: flex; gap: 10px;">
                        <button type="submit" class="btn btn-primary">Perbarui Rekam Medis</button>
                        <a href="list.php" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </article>
        </section>

<?php include __DIR__ . '/../includes/footer.php'; ?>