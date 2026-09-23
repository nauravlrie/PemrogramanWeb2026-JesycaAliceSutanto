<?php
$page_title = "Tambah Rekam Medis";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$daftarPasien = $_SESSION['pasien'] ?? [];
?>

        <section>
            <article>
                <h2>Formulir Tambah Rekam Medis</h2>
                <p>Catat hasil diagnosa dan tindakan medis pasien anabul.</p>

                <?php if ($flash): ?>
                    <div class="flash flash-<?php echo htmlspecialchars($flash['type']); ?>">
                        <?php echo htmlspecialchars($flash['pesan']); ?>
                    </div>
                <?php endif; ?>

                <form action="proses_tambah.php" method="POST">
                    <div class="form-group">
                        <label for="pasien">Pilih Pasien *</label>
                        <select id="pasien" name="pasien" class="form-control" required>
                            <option value="">-- Pilih Pasien --</option>
                            <?php if (empty($daftarPasien)): ?>
                                <option value="Mochi (Kucing)">PAS-001 - Mochi (Kucing)</option>
                                <option value="Milo (Anjing)">PAS-002 - Milo (Anjing)</option>
                                <option value="Luna (Kucing)">PAS-003 - Luna (Kucing)</option>
                            <?php else: ?>
                                <?php foreach ($daftarPasien as $p): ?>
                                    <option value="<?php echo htmlspecialchars($p['nama_hewan'] . ' (' . $p['spesies'] . ')'); ?>">
                                        <?php echo htmlspecialchars($p['no_pasien'] . ' - ' . $p['nama_hewan'] . ' (' . $p['spesies'] . ')'); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tanggal">Tanggal Pemeriksaan *</label>
                        <input type="date" id="tanggal" name="tanggal" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="dokter">Dokter Pemeriksa *</label>
                        <select id="dokter" name="dokter" class="form-control" required>
                            <option value="">-- Pilih Dokter --</option>
                            <option value="drh. Ratna Sari">drh. Ratna Sari</option>
                            <option value="drh. Hendra Gunawan">drh. Hendra Gunawan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="diagnosa">Diagnosa & Tindakan *</label>
                        <textarea id="diagnosa" name="diagnosa" class="form-control" rows="3" placeholder="Hasil diagnosa dan tindakan dokter..." required></textarea>
                    </div>

                    <div style="margin-top: 20px;">
                        <button type="submit" class="btn btn-primary">Simpan Rekam Medis</button>
                        <a href="list.php" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </article>
        </section>

<?php include __DIR__ . '/../includes/footer.php'; ?>