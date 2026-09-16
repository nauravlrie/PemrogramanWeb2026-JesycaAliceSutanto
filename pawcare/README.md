# 🐾 PawCare Mini — Sistem Informasi Klinik Hewan

Web multi-halaman sistem manajemen klinik hewan peliharaan (*pet clinic*) yang dibangun menggunakan **HTML5 Semantik & CSS3 Modern (Materi Jobsheet 1–4)**.

---

## 🎨 Palet Warna Tematik
- **Coffee Brown (`#8B6A5B`):** Brand logo, navbar aksen, dan tombol utama.
- **Blush Pink (`#EFD9D5`):** Tag status & sorotan.
- **Cream Beige (`#F6EEE8`):** Latar belakang utama.
- **Eucalyptus Green (`#BFC9B3`):** Garis aksen kartu dan tombol sekunder.
- **Warm Ivory (`#E8DCCB`):** Garis batas dan kartu.

---

## 🗂️ Struktur Direktori Proyek

```text
PawCare_Jesyca/
├── index.html                  # Dashboard & Beranda Statistik Klinik
├── assets/
│   └── css/
│       └── style.css           # Desain CSS Terpadu, Modern & Responsif
├── pasien/
│   ├── list.html               # Tabel Daftar Pasien Hewan
│   └── tambah.html             # Formulir Pendaftaran Pasien Baru
├── rekam_medis/
│   ├── list.html               # Tabel Riwayat Rekam Medis
│   └── tambah.html             # Formulir Input Rekam Medis Baru
└── README.md                   # Dokumentasi Proyek
```

---

## 🚀 Cara Menjalankan di Lokal (VS Code)
1. Buka folder `PawCare_Jesyca` di Visual Studio Code.
2. Klik kanan pada file `index.html` $\rightarrow$ pilih **"Open with Live Server"**.
3. Akses melalui peramban di `http://127.0.0.1:5500/index.html`.

---

## 🌐 Panduan Deployment ke Vercel
1. Buat repositori baru di GitHub (misal: `PawCare_Jesyca`).
2. Jalankan perintah git:
   ```bash
   git init
   git add .
   git commit -m "Initial commit PawCare Mini"
   git branch -M main
   git remote add origin https://github.com/USERNAME/PawCare_Jesyca.git
   git push -u origin main
   ```
3. Buka [vercel.com](https://vercel.com) $\rightarrow$ Login dengan GitHub $\rightarrow$ **Add New Project** $\rightarrow$ Pilih repositori `PawCare_Jesyca` $\rightarrow$ Klik **Deploy**!
