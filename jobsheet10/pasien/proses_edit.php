<?php
require_once __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/koneksi.php';

$id = $_POST['id'] ?? null;
$nama_hewan = trim($_POST['nama_hewan'] ?? '');
$spesies = trim($_POST['spesies'] ?? '');
$ras = trim($_POST['ras'] ?? '');
$nama_pemilik = trim($_POST['nama_pemilik'] ?? '');
$no_hp = trim($_POST['no_hp'] ?? '');

if (!$id) {
    header('Location: list.php');
    exit;
}

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
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}

$stmt = $pdo->prepare(
    "UPDATE pasien 
     SET nama_hewan = :nama_hewan,
         spesies = :spesies,
         ras = :ras,
         nama_pemilik = :nama_pemilik,
         no_hp = :no_hp
     WHERE id = :id"
);

$stmt->execute([
    'nama_hewan'   => $nama_hewan,
    'spesies'      => $spesies,
    'ras'          => $ras !== '' ? $ras : '-',
    'nama_pemilik' => $nama_pemilik,
    'no_hp'        => $no_hp,
    'id'           => $id,
]);

$_SESSION['flash'] = [
    'type' => 'success',
    'pesan' => "Data pasien {$nama_hewan} berhasil diperbarui!"
];

header('Location: list.php');
exit;