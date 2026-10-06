<?php
//Memeriksa apakah sesi pengguna sudah aktif
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Jika belum login mengalihkan ke halaman login
if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}