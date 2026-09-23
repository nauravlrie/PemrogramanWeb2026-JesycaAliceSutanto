<?php
$page_title = "Beranda";
include __DIR__ . '/includes/header.php';

//Inisialisasi 
if (!isset($_SESSION['pasien'])) {
    $_SESSION['pasien'] = [
        [
            'no_pasien' => 'PAS-001',
            'nama_hewan' => 'Mochi',
            'spesies' => 'Kucing',
            'ras' => 'British Shorthair',
            'nama_pemilik' => 'Siti Aminah',
            'no_hp' => '0812-3456-7890'
        ],
        [
            'no_pasien' => 'PAS-002',
            'nama_hewan' => 'Milo',
            'spesies' => 'Anjing',
            'ras' => 'Golden Retriever',
            'nama_pemilik' => 'Budi Santoso',
            'no_hp' => '0813-9876-5432'
        ],
        [
            'no_pasien' => 'PAS-003',
            'nama_hewan' => 'Luna',
            'spesies' => 'Kucing',
            'ras' => 'Persia Medium',
            'nama_pemilik' => 'Dewi Lestari',
            'no_hp' => '0814-1122-3344'
        ]
    ];
}

if (!isset($_SESSION['rekam_medis'])) {
    $_SESSION['rekam_medis'] = [
        [
            'no_rm' => 'RM-001',
            'pasien' => 'Mochi',
            'spesies' => 'Kucing',
            'tanggal' => '2026-09-15',
            'dokter' => 'drh. Ratna Sari',
            'diagnosa' => 'Vaksinasi Feline Tricat'
        ],
        [
            'no_rm' => 'RM-002',
            'pasien' => 'Milo',
            'spesies' => 'Anjing',
            'tanggal' => '2026-09-16',
            'dokter' => 'drh. Hendra Gunawan',
            'diagnosa' => 'Observasi Rawat Inap & Infus'
        ]
    ];
}

// Menghitung angka statistik secara dinamis dari data session PHP
$totalPasien = count($_SESSION['pasien'] ?? []);
$totalRekamMedis = count($_SESSION['rekam_medis'] ?? []);
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