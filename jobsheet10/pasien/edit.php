<?php
$page_title = "Edit Data Pasien";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM pasien WHERE id = :id");
$stmt->execute(['id' => $id]);
$pasien = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pasien) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'pesan' => 'Data pasien tidak ditemukan.'
    ];
    header('Location: list.php');
    exit;
}
?>

        <section>
            <article>
                <div class="section-header" style="margin-bottom: 20px;">
                    <h2>Edit Data Pasien</h2>
                    <span class="section-subtitle">Memperbarui informasi rekam medis pasien <?php echo htmlspecialchars($pasien['no_pasien']); ?></span>
                </div>

                <?php if ($flash): ?>
                    <div class="flash flash-<?php echo htmlspecialchars($flash['type']); ?>">
                        <?php echo htmlspecialchars($flash['pesan']); ?>
                    </div>
                <?php endif; ?>

                <form action="proses_edit.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($pasien['id']); ?>">

                    <div class="form-group">
                        <label for="no_pasien_tampil">Nomor Pasien (Otomatis)</label>
                        <input type="text" id="no_pasien_tampil" class="form-control" value="<?php echo htmlspecialchars($pasien['no_pasien']); ?>" disabled style="background-color: #EADFD6; cursor: not-allowed;">
                    </div>

                    <div class="form-group">
                        <label for="nama_hewan">Nama Hewan *</label>
                        <input type="text" id="nama_hewan" name="nama_hewan" class="form-control" value="<?php echo htmlspecialchars($pasien['nama_hewan']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="spesies">Spesies / Jenis Hewan *</label>
                        <select id="spesies" name="spesies" class="form-control" required>
                            <option value="">-- Pilih Spesies --</option>
                            <option value="Kucing" <?php echo $pasien['spesies'] === 'Kucing' ? 'selected' : ''; ?>>Kucing</option>
                            <option value="Anjing" <?php echo $pasien['spesies'] === 'Anjing' ? 'selected' : ''; ?>>Anjing</option>
                            <option value="Kelinci" <?php echo $pasien['spesies'] === 'Kelinci' ? 'selected' : ''; ?>>Kelinci</option>
                            <option value="Lainnya" <?php echo $pasien['spesies'] === 'Lainnya' ? 'selected' : ''; ?>>Lainnya</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="ras">Ras</label>
                        <input type="text" id="ras" name="ras" class="form-control" value="<?php echo htmlspecialchars($pasien['ras']); ?>">
                    </div>

                    <div class="form-group">
                        <label for="nama_pemilik">Nama Pemilik *</label>
                        <input type="text" id="nama_pemilik" name="nama_pemilik" class="form-control" value="<?php echo htmlspecialchars($pasien['nama_pemilik']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="no_hp">Nomor HP / WhatsApp *</label>
                        <input type="tel" id="no_hp" name="no_hp" class="form-control" value="<?php echo htmlspecialchars($pasien['no_hp']); ?>" required>
                    </div>

                    <div style="margin-top: 24px; display: flex; gap: 10px;">
                        <button type="submit" class="btn btn-primary">Perbarui Data Pasien</button>
                        <a href="list.php" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </article>
        </section>

<?php include __DIR__ . '/../includes/footer.php'; ?>