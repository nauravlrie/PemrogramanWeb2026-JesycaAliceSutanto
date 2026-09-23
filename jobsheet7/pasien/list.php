<?php
$page_title = "Data Pasien";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$daftarPasien = $_SESSION['pasien'] ?? [];
?>

        <section>
            <article>
                <h2>Daftar Pasien Hewan</h2>
                <p>Data seluruh hewan peliharaan yang terdaftar di klinik PawCare Mini.</p>

                <?php if ($flash): ?>
                    <div class="flash flash-<?php echo htmlspecialchars($flash['type']); ?>">
                        <?php echo htmlspecialchars($flash['pesan']); ?>
                    </div>
                <?php endif; ?>

                <div style="margin-bottom: 16px;">
                    <a href="tambah.php" class="btn btn-primary">+ Tambah Pasien Baru</a>
                </div>

                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>No Pasien</th>
                                <th>Nama Hewan</th>
                                <th>Spesies</th>
                                <th>Ras</th>
                                <th>Nama Pemilik</th>
                                <th>No HP</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($daftarPasien)): ?>
                                <tr>
                                    <td colspan="7" style="text-align: center; color: #846F65; padding: 24px;">
                                        Belum ada data pasien. Silakan klik tombol <strong>+ Tambah Pasien Baru</strong> di atas.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($daftarPasien as $p): ?>
                                    <?php
                                    // Memberi warna badge lembut otomatis sesuai spesies hewan
                                    $badgeClass = 'badge-vanilla';
                                    if (strtolower($p['spesies']) === 'kucing') {
                                        $badgeClass = 'badge-strawberry';
                                    } elseif (strtolower($p['spesies']) === 'anjing') {
                                        $badgeClass = 'badge-peach';
                                    }
                                    ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($p['no_pasien']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($p['nama_hewan']); ?></td>
                                        <td><span class="badge-pill <?php echo $badgeClass; ?>"><?php echo htmlspecialchars($p['spesies']); ?></span></td>
                                        <td><?php echo htmlspecialchars($p['ras']); ?></td>
                                        <td><?php echo htmlspecialchars($p['nama_pemilik']); ?></td>
                                        <td><?php echo htmlspecialchars($p['no_hp']); ?></td>
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