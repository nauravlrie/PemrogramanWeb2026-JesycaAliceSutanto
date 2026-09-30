<?php
session_start();

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
            <span class="meta-label">Jam Operasional</span>
            <span class="meta-value">Senin - Minggu: 08.00 - 21.00 WIB</span>
        </div>
    </header>

    <nav>
        <input type="checkbox" id="menu-toggle">
        <label for="menu-toggle" class="menu-icon">☰</label>
        <div class="menu">
            <a href="<?php echo $base; ?>index.php">Beranda</a>
            <a href="<?php echo $base; ?>pasien/list.php">Data Pasien</a>
            <a href="<?php echo $base; ?>pasien/tambah.php">Tambah Pasien</a>
            <a href="<?php echo $base; ?>rekam_medis/list.php">Rekam Medis</a>
            <a href="<?php echo $base; ?>rekam_medis/tambah.php">Tambah Rekam Medis</a>
        </div>
    </nav>

    <main>