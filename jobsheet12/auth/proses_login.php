<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/koneksi.php';

csrf_verify();

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// Mengambil data user berdasarkan username menggunakan Prepared Statement
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
$stmt->execute(['username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Memverifikasi kecocokan password dengan hash di database
if ($user && password_verify($password, $user['password'])) {
    // Regenerasi session ID untuk mencegah serangan Session Fixation
    session_regenerate_id(true);

    // Menyimpan identitas pengguna ke dalam sesi server
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nama']    = $user['nama'];
    $_SESSION['role']    = $user['role'];

    $_SESSION['flash'] = [
        'type' => 'success',
        'pesan' => "Selamat datang kembali, {$user['nama']}!"
    ];

    header('Location: ../index.php');
    exit;
}

// Jika username tidak ditemukan atau password tidak cocok
$_SESSION['flash'] = [
    'type' => 'error',
    'pesan' => 'Username atau password salah.'
];

header('Location: login.php');
exit;