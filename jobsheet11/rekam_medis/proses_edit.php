<?php
require_once __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/koneksi.php';

$id = $_POST['id'] ?? null;
$pasien = trim($_POST['pasien'] ?? '');
$tanggal = trim($_POST['tanggal'] ?? '');
$dokter = trim($_POST['dokter'] ?? '');
$diagnosa = trim($_POST['diagnosa'] ?? '');

if (!$id) {
    header('Location: list.php');
    exit;
}

$errors = [];
if ($pasien === '') {
    $errors[] = "Pilihan pasien wajib diisi.";
}
if ($tanggal === '') {
    $errors[] = "Tanggal pemeriksaan wajib diisi.";
}
if ($dokter === '') {
    $errors[] = "Dokter pemeriksa wajib dipilih.";
}
if ($diagnosa === '') {
    $errors[] = "Diagnosa & tindakan wajib diisi.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'pesan' => implode(' ', $errors)
    ];
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}

// Memperbarui data rekam medis di database PostgreSQL 
$stmt = $pdo->prepare(
    "UPDATE rekam_medis 
     SET pasien = :pasien,
         tanggal = :tanggal,
         dokter = :dokter,
         diagnosa = :diagnosa
     WHERE id = :id"
);

$stmt->execute([
    'pasien'   => $pasien,
    'tanggal'  => $tanggal,
    'dokter'   => $dokter,
    'diagnosa' => $diagnosa,
    'id'       => $id,
]);

$_SESSION['flash'] = [
    'type' => 'success',
    'pesan' => "Data rekam medis untuk {$pasien} berhasil diperbarui!"
];

header('Location: list.php');
exit;