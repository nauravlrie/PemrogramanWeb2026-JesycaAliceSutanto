<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$sudahLogin = isset($_SESSION['user_id']);

$__jobsheetRoot = dirname(__DIR__);
$__scriptDir = dirname($_SERVER['SCRIPT_FILENAME']);
$__rel = ltrim(str_replace('\\', '/', substr($__scriptDir, strlen($__jobsheetRoot))), '/');
$base = $__rel === '' ? '' : str_repeat('../', substr_count($__rel, '/') + 1);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PawCare Mini<?php echo isset($page_title) ? ' - ' . $page_title : ' - Sistem Informasi Klinik Hewan'; ?></title>
    <link rel="stylesheet" href="<?php echo $base; ?>assets/css/style.css">
</head>
<body>
    <header>
        <div class="header-brand">
            <span class="header-tagline">Sistem Informasi Manajemen</span>
            <h1>PawCare Mini</h1>
        </div>
        <div class="header-meta">
            <?php if ($sudahLogin): ?>
                <span class="meta-label">Petugas Aktif</span>
                <span class="meta-value" style="font-weight: 600; color: #FAF6F2;"><?php echo htmlspecialchars($_SESSION['nama']); ?></span>
            <?php else: ?>
                <span class="meta-label">Jam Operasional</span>
                <span class="meta-value">Senin - Minggu: 08.00 - 21.00 WIB</span>
            <?php endif; ?>
        </div>
    </header>

    <nav>
        <input type="checkbox" id="menu-toggle">
        <label for="menu-toggle" class="menu-icon">☰</label>
        <div class="menu">
            <a href="<?php echo $base; ?>index.php">Beranda</a>
            <a href="<?php echo $base; ?>pasien/list.php">Data Pasien</a>
            
            <?php if ($sudahLogin): ?>
                <a href="<?php echo $base; ?>pasien/tambah.php">Tambah Pasien</a>
                <a href="<?php echo $base; ?>rekam_medis/list.php">Rekam Medis</a>
                <a href="<?php echo $base; ?>rekam_medis/tambah.php">Tambah Rekam Medis</a>
                <a href="<?php echo $base; ?>auth/logout.php" style="background-color: #8C2A3A; color: #ffffff; margin-left: 6px;">Logout</a>
            <?php else: ?>
                <a href="<?php echo $base; ?>auth/login.php" style="background-color: #8B6A5B; color: #ffffff; margin-left: 6px;">Login Petugas</a>
            <?php endif; ?>
        </div>
    </nav>

    <main>