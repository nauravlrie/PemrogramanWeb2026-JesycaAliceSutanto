<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

//Memastikan request hanya melalui POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$id = $_POST['id'] ?? null;

if ($id) {
    //Menghapus data pasien berdasarkan ID 
    $stmt = $pdo->prepare("DELETE FROM pasien WHERE id = :id");
    $stmt->execute(['id' => $id]);

    $_SESSION['flash'] = [
        'type' => 'success',
        'pesan' => 'Data pasien berhasil dihapus dari database.'
    ];
}

header('Location: list.php');
exit;