<?php
$page_title = "Beranda";
include __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/koneksi.php';


$totalPasien = (int) $pdo->query("SELECT count(*) FROM pasien")->fetchColumn();
$totalRekamMedis = (int) $pdo->query("SELECT count(*) FROM rekam_medis")->fetchColumn();
?>


        <div class="welcome-card">
            <div class="welcome-content">
                <span class="welcome-tag">Panel Manajemen Klinik</span>
                <h2>Dashboard Operasional</h2>
                <p>Selamat datang di sistem pengelolaan data pasien anabul dan riwayat rekam medis PawCare Mini.</p>
            </div>
        </div>


        <section>
            <div class="section-header">
                <h2>Statistik Klinik</h2>
                <span class="section-subtitle">Ringkasan data pasien dan tindakan terkini</span>
            </div>
            <div class="grid-statistik">
                <div class="kartu-stat">
                    <h3>Total Pasien Terdaftar</h3>
                    <p class="angka"><?php echo $totalPasien; ?></p>
                </div>
                <div class="kartu-stat">
                    <h3>Total Rekam Medis</h3>
                    <p class="angka"><?php echo $totalRekamMedis; ?></p>
                </div>
                <div class="kartu-stat">
                    <h3>Pasien Rawat Inap</h3>
                    <p class="angka">1</p>
                </div>
            </div>
        </section>

<?php include __DIR__ . '/includes/footer.php'; ?>