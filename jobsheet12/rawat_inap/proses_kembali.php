<?php
require_once __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/koneksi.php';

// Memastikan hanya menerima method POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: kembali.php');
    exit;
}

// Verifikasi token CSRF
csrf_verify();

$id = $_POST['id'] ?? null;
if (!$id) {
    header('Location: kembali.php');
    exit;
}

try {
    // Memulai blok transaksi database
    $pdo->beginTransaction();

    // 1. Kunci baris transaksi rawat inap dengan FOR UPDATE
    $stmt = $pdo->prepare("SELECT kandang_id, status FROM rawat_inap WHERE id = :id FOR UPDATE");
    $stmt->execute(['id' => $id]);
    $trx = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$trx || $trx['status'] !== 'dirawat') {
        throw new Exception('Data transaksi tidak ditemukan atau pasien sudah selesai dirawat.');
    }

    // 2. Perbarui status rawat inap menjadi selesai dan catat tanggal kepulangan
    $updateRawat = $pdo->prepare(
        "UPDATE rawat_inap SET status = 'selesai', tanggal_keluar = CURRENT_DATE WHERE id = :id"
    );
    $updateRawat->execute(['id' => $id]);

    // 3. Tambahkan kembali kapasitas slot kandang (+1)
    $updateKandang = $pdo->prepare("UPDATE kandang SET kapasitas = kapasitas + 1 WHERE id = :kandang_id");
    $updateKandang->execute(['kandang_id' => $trx['kandang_id']]);

    // Simpan seluruh perubahan secara permanen
    $pdo->commit();

    $_SESSION['flash'] = [
        'type' => 'success',
        'pesan' => 'Pasien telah berhasil menyelesaikan rawat inap. Slot kandang telah kembali tersedia.'
    ];
} catch (Exception $e) {
    // Batalkan seluruh perubahan jika terjadi kesalahan
    $pdo->rollBack();

    $_SESSION['flash'] = [
        'type' => 'error',
        'pesan' => 'Gagal menyelesaikan rawat inap: ' . $e->getMessage()
    ];
}

header('Location: kembali.php');
exit;