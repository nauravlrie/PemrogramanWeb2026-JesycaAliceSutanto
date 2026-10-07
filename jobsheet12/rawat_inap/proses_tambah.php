<?php
require_once __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/koneksi.php';

// Verifikasi token CSRF sebelum memproses transaksi
csrf_verify();

$pasienId     = $_POST['pasien_id'] ?? '';
$kandangId    = $_POST['kandang_id'] ?? '';
$tanggalMasuk = trim($_POST['tanggal_masuk'] ?? '');
$keterangan   = trim($_POST['keterangan'] ?? '');

if ($pasienId === '' || $kandangId === '' || $tanggalMasuk === '') {
    $_SESSION['flash'] = [
        'type' => 'error',
        'pesan' => 'Pasien, ruang rawat, dan tanggal masuk wajib diisi.'
    ];
    header('Location: tambah.php');
    exit;
}

try {
    // Memulai blok transaksi database
    $pdo->beginTransaction();

    // 1. Kunci baris kandang dengan FOR UPDATE untuk mencegah race condition (pessimistic locking)
    $cek = $pdo->prepare("SELECT kapasitas FROM kandang WHERE id = :id FOR UPDATE");
    $cek->execute(['id' => $kandangId]);
    $kandang = $cek->fetch(PDO::FETCH_ASSOC);

    if (!$kandang || (int)$kandang['kapasitas'] < 1) {
        throw new Exception('Slot kapasitas ruang rawat yang dipilih sudah penuh.');
    }

    // 2. Simpan transaksi rawat inap baru
    $insert = $pdo->prepare(
        "INSERT INTO rawat_inap (pasien_id, kandang_id, tanggal_masuk, status, keterangan)
         VALUES (:pasien_id, :kandang_id, :tanggal_masuk, 'dirawat', :keterangan)"
    );
    $insert->execute([
        'pasien_id'     => $pasienId,
        'kandang_id'    => $kandangId,
        'tanggal_masuk' => $tanggalMasuk,
        'keterangan'    => $keterangan !== '' ? $keterangan : null,
    ]);

    // 3. Kurangi kuota kapasitas kandang
    $update = $pdo->prepare("UPDATE kandang SET kapasitas = kapasitas - 1 WHERE id = :id");
    $update->execute(['id' => $kandangId]);

    // Konfirmasi dan simpan seluruh perubahan secara permanen
    $pdo->commit();

    $_SESSION['flash'] = [
        'type' => 'success',
        'pesan' => 'Pasien anabul berhasil didaftarkan ke rawat inap.'
    ];
    header('Location: kembali.php');
    exit;
} catch (Exception $e) {
    // Batalkan seluruh perubahan jika terjadi kendala agar data tetap konsisten
    $pdo->rollBack();

    $_SESSION['flash'] = [
        'type' => 'error',
        'pesan' => 'Gagal mencatat rawat inap: ' . $e->getMessage()
    ];
    header('Location: tambah.php');
    exit;
}