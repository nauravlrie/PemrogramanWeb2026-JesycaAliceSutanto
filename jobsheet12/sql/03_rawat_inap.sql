-- ========================================================
-- Jobsheet 12: Integrasi Modul Transaksi Rawat Inap
-- Sistem Informasi Klinik Hewan PawCare Mini
-- ========================================================

-- 1. Tabel Master Kandang / Ruang Rawat (Memiliki Kapasitas/Slot)
CREATE TABLE IF NOT EXISTS kandang (
    id SERIAL PRIMARY KEY,
    kode_kandang VARCHAR(20) NOT NULL UNIQUE,
    nama_kandang VARCHAR(100) NOT NULL,
    tipe VARCHAR(50) NOT NULL,
    kapasitas INTEGER NOT NULL DEFAULT 1
);

-- 2. Tabel Transaksi Rawat Inap (Relasi Foreign Key ke Pasien dan Kandang)
CREATE TABLE IF NOT EXISTS rawat_inap (
    id SERIAL PRIMARY KEY,
    pasien_id INTEGER NOT NULL REFERENCES pasien(id),
    kandang_id INTEGER NOT NULL REFERENCES kandang(id),
    tanggal_masuk DATE NOT NULL DEFAULT CURRENT_DATE,
    tanggal_keluar DATE,
    status VARCHAR(20) NOT NULL DEFAULT 'dirawat',
    keterangan TEXT
);

-- 3. Data Awal Kandang
INSERT INTO kandang (kode_kandang, nama_kandang, tipe, kapasitas) VALUES
('KND-01', 'Kandang Kucing Sakura', 'Kucing', 2),
('KND-02', 'Kandang Anjing Lavender', 'Anjing', 2),
('KND-03', 'Ruang Isolasi Melati', 'Khusus', 1)
ON CONFLICT (kode_kandang) DO NOTHING;
