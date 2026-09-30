<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

$pasien = trim($_POST['pasien'] ?? '');
$tanggal = trim($_POST['tanggal'] ?? '');
$dokter = trim($_POST['dokter'] ?? '');
$diagnosa = trim($_POST['diagnosa'] ?? '');


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
    header('Location: tambah.php');
    exit;
}

$count = (int) $pdo->query("SELECT count(*) FROM rekam_medis")->fetchColumn();
$no_rm = 'RM-' . str_pad($count + 1, 3, '0', STR_PAD_LEFT);


$stmt = $pdo->prepare(
    "INSERT INTO rekam_medis (no_rm, pasien, tanggal, dokter, diagnosa)
     VALUES (:no_rm, :pasien, :tanggal, :dokter, :diagnosa)
     RETURNING id"
);
$stmt->execute([
    'no_rm' => $no_rm,
    'pasien' => $pasien,
    'tanggal' => $tanggal,
    'dokter' => $dokter,
    'diagnosa' => $diagnosa,
]);

$_SESSION['flash'] = [
    'type' => 'success',
    'pesan' => "Rekam medis {$no_rm} untuk {$pasien} berhasil disimpan permanen ke database!"
];

header('Location: list.php');
exit;