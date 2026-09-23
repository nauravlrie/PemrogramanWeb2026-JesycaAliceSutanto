<?php
session_start();

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

if (!isset($_SESSION['rekam_medis'])) {
    $_SESSION['rekam_medis'] = [];
}

$nextNumber = count($_SESSION['rekam_medis']) + 1;
$no_rm = 'RM-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

$_SESSION['rekam_medis'][] = [
    'no_rm' => $no_rm,
    'pasien' => $pasien,
    'tanggal' => $tanggal,
    'dokter' => $dokter,
    'diagnosa' => $diagnosa,
];

$_SESSION['flash'] = [
    'type' => 'success',
    'pesan' => "Rekam medis {$no_rm} untuk {$pasien} berhasil dicatat!"
];

header('Location: list.php');
exit;