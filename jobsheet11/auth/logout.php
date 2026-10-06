<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Menghapus dan menghancurkan seluruh data sesi di server
$_SESSION = [];
session_destroy();

// Memulai sesi baru untuk menampung notifikasi keluar
session_start();
$_SESSION['flash'] = [
    'type' => 'success',
    'pesan' => 'Anda telah berhasil logout dari sistem.'
];

header('Location: login.php');
exit;