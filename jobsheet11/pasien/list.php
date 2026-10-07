<?php
$page_title = "Data Pasien";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

// Mengambil data dri postgres
// Konfigurasi Pagination & Pencarian Server-Side
$perPage = 5;
$page = max(1, (int) ($_GET['page'] ?? 1));
$offset = ($page - 1) * $perPage;
$keyword = trim($_GET['q'] ?? '');

if ($keyword !== '') {
    // Menghitung total data yang cocok dengan pencarian
    $hitung = $pdo->prepare(
        "SELECT COUNT(*) FROM pasien 
         WHERE nama_hewan ILIKE :kw OR nama_pemilik ILIKE :kw OR no_pasien ILIKE :kw"
    );
    $hitung->execute(['kw' => '%' . $keyword . '%']);
    $totalRows = (int) $hitung->fetchColumn();

    // Mengambil data dri postgres terpaginasi sesuai pencarian
    $stmt = $pdo->prepare(
        "SELECT * FROM pasien 
         WHERE nama_hewan ILIKE :kw OR nama_pemilik ILIKE :kw OR no_pasien ILIKE :kw 
         ORDER BY id ASC LIMIT :limit OFFSET :offset"
    );
    $stmt->bindValue('kw', '%' . $keyword . '%');
} else {
    // Menghitung seluruh data pasien
    $totalRows = (int) $pdo->query("SELECT COUNT(*) FROM pasien")->fetchColumn();

    // Mengambil data dri postgres terpaginasi normal
    $stmt = $pdo->prepare("SELECT * FROM pasien ORDER BY id ASC LIMIT :limit OFFSET :offset");
}

$stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue('offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$daftarPasien = $stmt->fetchAll(PDO::FETCH_ASSOC);
$totalPages = max(1, (int) ceil($totalRows / $perPage));
?>

        <section>
            <article>
                <div class="section-header">
                    <h2>Daftar Pasien Hewan</h2>
                    <span class="section-subtitle">Data seluruh hewan peliharaan yang terdaftar di database PostgreSQL PawCare Mini</span>
                </div>

                <?php if ($flash): ?>
                    <div class="flash flash-<?php echo e($flash['type']); ?>">
                        <?php echo e($flash['pesan']); ?>
                    </div>
                <?php endif; ?>

                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 16px;">
                    <div>
                        <!-- Tombol Tambah hanya tampil jika petugas sudah login -->
                        <?php if ($sudahLogin): ?>
                            <a href="tambah.php" class="btn btn-primary">+ Tambah Pasien Baru</a>
                        <?php endif; ?>
                    </div>

                    <!-- Formulir Pencarian Server-Side -->
                    <div class="search-box">
                        <form method="GET" action="list.php" style="display: flex; gap: 6px; align-items: center;">
                            <input type="text" id="search-input" name="q" value="<?php echo e($keyword); ?>" placeholder="Cari hewan, pemilik, no pasien..." class="form-control" style="width: 260px; padding: 7px 12px; font-size: 13px;">
                            <button type="submit" class="btn btn-primary btn-sm">Cari</button>
                            <?php if ($keyword !== ''): ?>
                                <a href="list.php" class="btn btn-secondary btn-sm">Reset</a>
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
                                <th>Spesies</th>
                                <th>Ras</th>
                                <th>Nama Pemilik</th>
                                <th>No HP</th>
                                <!-- Kolom Aksi hanya tampil jika petugas sudah login -->
                                <?php if ($sudahLogin): ?>
                                    <th style="text-align: center;">Aksi</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($daftarPasien)): ?>
                                <tr>
                                    <td colspan="<?php echo $sudahLogin ? 7 : 6; ?>" style="text-align: center; color: #846F65; padding: 24px;">
                                        <?php if ($keyword !== ''): ?>
                                            Tidak ditemukan data pasien dengan kata kunci "<strong><?php echo e($keyword); ?></strong>".
                                        <?php else: ?>
                                            Belum ada data pasien di database.
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($daftarPasien as $p): ?>
                                    <?php
                                    $badgeClass = 'badge-vanilla';
                                    if (strtolower($p['spesies']) === 'kucing') {
                                        $badgeClass = 'badge-strawberry';
                                    } elseif (strtolower($p['spesies']) === 'anjing') {
                                        $badgeClass = 'badge-peach';
                                    }
                                    ?>
                                    <tr>
                                        <td><strong><?php echo e($p['no_pasien']); ?></strong></td>
                                        <td><?php echo e($p['nama_hewan']); ?></td>
                                        <td><span class="badge-pill <?php echo $badgeClass; ?>"><?php echo e($p['spesies']); ?></span></td>
                                        <td><?php echo e($p['ras']); ?></td>
                                        <td><?php echo e($p['nama_pemilik']); ?></td>
                                        <td><?php echo e($p['no_hp']); ?></td>
                                        <!-- Kolom Aksi hanya tampil jika petugas sudah login -->
                                        <?php if ($sudahLogin): ?>
                                            <td style="text-align: center; white-space: nowrap;">
                                                <a href="edit.php?id=<?php echo e($p['id']); ?>" class="btn-action-edit">Edit</a>
                                                <form class="form-hapus" method="POST" action="hapus.php" style="display: inline-block;">
                                                    <input type="hidden" name="id" value="<?php echo e($p['id']); ?>">
                                                    <button type="submit" class="btn-action-delete" style="border: none; cursor: pointer;">Hapus</button>
                                                </form>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Navigasi Pagination -->
                <?php if ($totalPages > 1): ?>
                    <nav class="pagination" style="display: flex; justify-content: center; gap: 6px; margin-top: 20px;">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <a href="list.php?page=<?php echo $i; ?><?php echo $keyword !== '' ? '&q=' . urlencode($keyword) : ''; ?>"
                               class="btn btn-sm <?php echo $i === $page ? 'btn-primary' : 'btn-secondary'; ?>"
                               style="min-width: 32px; padding: 6px 12px; <?php echo $i === $page ? 'background-color: #8B6A5B; color: #fff;' : ''; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>
                    </nav>
                <?php endif; ?>
            </article>
        </section>

<?php include __DIR__ . '/../includes/footer.php'; ?>