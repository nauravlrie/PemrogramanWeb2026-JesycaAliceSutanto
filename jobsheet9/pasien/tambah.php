<?php
$page_title = "Tambah Pasien";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

        <section>
            <article>
                <h2>Formulir Tambah Pasien Baru</h2>
                <p>Silakan isi data hewan peliharaan dan pemilik di bawah ini.</p>

                <?php if ($flash): ?>
                    <div class="flash flash-<?php echo htmlspecialchars($flash['type']); ?>">
                        <?php echo htmlspecialchars($flash['pesan']); ?>
                    </div>
                <?php endif; ?>

                <form action="proses_tambah.php" method="POST">
                    <div class="form-group">
                        <label for="nama_hewan">Nama Hewan *</label>
                        <input type="text" id="nama_hewan" name="nama_hewan" class="form-control" placeholder="Masukkan nama hewan..." required>
                    </div>

                    <div class="form-group">
                        <label for="spesies">Spesies / Jenis Hewan *</label>
                        <select id="spesies" name="spesies" class="form-control" required>
                            <option value="">-- Pilih Spesies --</option>
                            <option value="Kucing">Kucing</option>
                            <option value="Anjing">Anjing</option>
                            <option value="Kelinci">Kelinci</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="ras">Ras</label>
                        <input type="text" id="ras" name="ras" class="form-control" placeholder="Contoh: British Shorthair, Golden Retriever...">
                    </div>

                    <div class="form-group">
                        <label for="nama_pemilik">Nama Pemilik *</label>
                        <input type="text" id="nama_pemilik" name="nama_pemilik" class="form-control" placeholder="Nama lengkap pemilik..." required>
                    </div>

                    <div class="form-group">
                        <label for="no_hp">Nomor HP / WhatsApp *</label>
                        <input type="tel" id="no_hp" name="no_hp" class="form-control" placeholder="08xxxxxxxxxx" required>
                    </div>

                    <div style="margin-top: 20px;">
                        <button type="submit" class="btn btn-primary">Simpan Data Pasien</button>
                        <a href="list.php" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </article>
        </section>

<?php include __DIR__ . '/../includes/footer.php'; ?>