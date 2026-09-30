<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

$nama_hewan = trim($_POST['nama_hewan'] ?? '');
$spesies = trim($_POST['spesies'] ?? '');
$ras = trim($_POST['ras'] ?? '');
$nama_pemilik = trim($_POST['nama_pemilik'] ?? '');
$no_hp = trim($_POST['no_hp'] ?? '');

$errors = [];
if ($nama_hewan === '') {
    $errors[] = "Nama hewan wajib diisi.";
}
if ($spesies === '') {
    $errors[] = "Spesies wajib dipilih.";
}
if ($nama_pemilik === '') {
    $errors[] = "Nama pemilik wajib diisi.";
}
if ($no_hp === '') {
    $errors[] = "Nomor HP wajib diisi.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'pesan' => implode(' ', $errors)
    ];
    header('Location: tambah.php');
    exit;
}

$count = (int) $pdo->query("SELECT count(*) FROM pasien")->fetchColumn();
$no_pasien = 'PAS-' . str_pad($count + 1, 3, '0', STR_PAD_LEFT);

$stmt = $pdo->prepare(
    "INSERT INTO pasien (no_pasien, nama_hewan, spesies, ras, nama_pemilik, no_hp)
     VALUES (:no_pasien, :nama_hewan, :spesies, :ras, :nama_pemilik, :no_hp)
     RETURNING id"
);
$stmt->execute([
    'no_pasien' => $no_pasien,
    'nama_hewan' => $nama_hewan,
    'spesies' => $spesies,
    'ras' => $ras !== '' ? $ras : '-',
    'nama_pemilik' => $nama_pemilik,
    'no_hp' => $no_hp,
]);

$_SESSION['flash'] = [
    'type' => 'success',
    'pesan' => "Pasien {$nama_hewan} ({$no_pasien}) berhasil disimpan permanen ke database!"
];

header('Location: list.php');
exit;