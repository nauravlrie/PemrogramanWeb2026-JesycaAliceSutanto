<?php
require_once __DIR__ . '/../includes/auth.php';

$page_title = "Rekam Medis";
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
        "SELECT COUNT(*) FROM rekam_medis 
         WHERE no_rm ILIKE :kw OR pasien ILIKE :kw OR dokter ILIKE :kw OR diagnosa ILIKE :kw"
    );
    $hitung->execute(['kw' => '%' . $keyword . '%']);
    $totalRows = (int) $hitung->fetchColumn();

    // Mengambil data dri postgres terpaginasi sesuai pencarian
    $stmt = $pdo->prepare(
        "SELECT * FROM rekam_medis 
         WHERE no_rm ILIKE :kw OR pasien ILIKE :kw OR dokter ILIKE :kw OR diagnosa ILIKE :kw 
         ORDER BY id ASC LIMIT :limit OFFSET :offset"
    );
    $stmt->bindValue('kw', '%' . $keyword . '%');
} else {
    // Menghitung seluruh data rekam medis
    $totalRows = (int) $pdo->query("SELECT COUNT(*) FROM rekam_medis")->fetchColumn();

    // Mengambil data dri postgres terpaginasi normal
    $stmt = $pdo->prepare("SELECT * FROM rekam_medis ORDER BY id ASC LIMIT :limit OFFSET :offset");
}

$stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue('offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$daftarRM = $stmt->fetchAll(PDO::FETCH_ASSOC);
$totalPages = max(1, (int) ceil($totalRows / $perPage));
?>

        <section>
            <article>
                <div class="section-header">
                    <h2>Daftar Rekam Medis</h2>
                    <span class="section-subtitle">Catatan riwayat pemeriksaan dan tindakan medis seluruh pasien klinik PawCare Mini</span>
                </div>

                <?php if ($flash): ?>
                    <div class="flash flash-<?php echo e($flash['type']); ?>">
                        <?php echo e($flash['pesan']); ?>
                    </div>
                <?php endif; ?>

                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 16px;">
                    <div>
                        <a href="tambah.php" class="btn btn-primary">+ Tambah Rekam Medis</a>
                    </div>

                    <!-- Formulir Pencarian Server-Side -->
                    <div class="search-box">
                        <form method="GET" action="list.php" style="display: flex; gap: 6px; align-items: center;">
                            <input type="text" id="search-input" name="q" value="<?php echo e($keyword); ?>" placeholder="Cari no RM, pasien, dokter, diagnosa..." class="form-control" style="width: 270px; padding: 7px 12px; font-size: 13px;">
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
                                <th>No RM</th>
                                <th>Nama Pasien</th>
                                <th>Tanggal</th>
                                <th>Diagnosa & Tindakan</th>
                                <th>Dokter Pemeriksa</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($daftarRM)): ?>
                                <tr>
                                    <td colspan="6" style="text-align: center; color: #846F65; padding: 24px;">
                                        <?php if ($keyword !== ''): ?>
                                            Tidak ditemukan rekam medis dengan kata kunci "<strong><?php echo e($keyword); ?></strong>".
                                        <?php else: ?>
                                            Belum ada riwayat rekam medis di database. Silakan klik tombol <strong>+ Tambah Rekam Medis</strong> di atas.
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($daftarRM as $rm): ?>
                                    <tr>
                                        <td><strong><?php echo e($rm['no_rm']); ?></strong></td>
                                        <td><?php echo e($rm['pasien']); ?></td>
                                        <td><?php echo e(date('d M Y', strtotime($rm['tanggal']))); ?></td>
                                        <td><?php echo e($rm['diagnosa']); ?></td>
                                        <td><?php echo e($rm['dokter']); ?></td>
                                        <td style="text-align: center; white-space: nowrap;">
                                            <a href="edit.php?id=<?php echo e($rm['id']); ?>" class="btn-action-edit">Edit</a>
                                            <form class="form-hapus" method="POST" action="hapus.php" style="display: inline-block;">
                                                <input type="hidden" name="id" value="<?php echo e($rm['id']); ?>">
                                                <button type="submit" class="btn-action-delete" style="border: none; cursor: pointer;">Hapus</button>
                                            </form>
                                        </td>
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