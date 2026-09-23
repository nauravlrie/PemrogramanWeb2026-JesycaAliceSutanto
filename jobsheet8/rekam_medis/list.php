<?php
$page_title = "Rekam Medis";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);


$stmt = $pdo->query("SELECT * FROM rekam_medis ORDER BY id ASC");
$daftarRM = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

        <section>
            <article>
                <h2>Daftar Rekam Medis</h2>
                <p>Catatan riwayat pemeriksaan dan tindakan medis seluruh pasien klinik PawCare Mini dari database.</p>

                <?php if ($flash): ?>
                    <div class="flash flash-<?php echo htmlspecialchars($flash['type']); ?>">
                        <?php echo htmlspecialchars($flash['pesan']); ?>
                    </div>
                <?php endif; ?>

                <div style="margin-bottom: 16px;">
                    <a href="tambah.php" class="btn btn-primary">+ Tambah Rekam Medis</a>
                </div>

                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>No RM</th>
                                <th>Nama Pasien</th>
                                <th>Tanggal</th>
                                <th>Diagnosa & Tindakan</th>
                                <th>Dokter Pemeriksa</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($daftarRM)): ?>
                                <tr>
                                    <td colspan="6" style="text-align: center; color: #846F65; padding: 24px;">
                                        Belum ada riwayat rekam medis di database. Silakan klik tombol <strong>+ Tambah Rekam Medis</strong> di atas.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($daftarRM as $rm): ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($rm['no_rm']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($rm['pasien']); ?></td>
                                        <td><?php echo htmlspecialchars(date('d M Y', strtotime($rm['tanggal']))); ?></td>
                                        <td><?php echo htmlspecialchars($rm['diagnosa']); ?></td>
                                        <td><?php echo htmlspecialchars($rm['dokter']); ?></td>
                                        <td>
                                            <a href="#" class="btn-action-edit">Edit</a>
                                            <a href="#" class="btn-action-delete">Hapus</a>
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