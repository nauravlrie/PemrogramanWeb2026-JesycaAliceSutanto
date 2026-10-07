<?php
require_once __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/koneksi.php';

// Memastikan request hanya datang melalui POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

csrf_verify();

$id = $_POST['id'] ?? null;

if ($id) {
    // Menghapus data rekam medis berdasarkan ID menggunakan 
    $stmt = $pdo->prepare("DELETE FROM rekam_medis WHERE id = :id");
    $stmt->execute(['id' => $id]);

    $_SESSION['flash'] = [
        'type' => 'success',
        'pesan' => 'Data rekam medis berhasil dihapus dari database.'
    ];
}

header('Location: list.php');
exit;