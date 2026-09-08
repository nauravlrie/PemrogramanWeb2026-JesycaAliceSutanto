# Wireframe & User Flow — SIMPUS-Mini

## Aktor
-Tamu: hanya bisa melihat katalog buku (Beranda, Daftar Buku) tanpa login.
-Petugas: login untuk mengakses seluruh fitur CRUD dan transaksi peminjaman.

## User Flow — Peminjaman Buku
[Petugas Login] -> [Dashboard] -> [Pilih menu "Peminjaman Baru"]
        -> [Pilih Anggota] -> [Pilih Buku (stok > 0)]
        -> [Simpan] -> [Stok buku berkurang 1] -> [Kembali ke Dashboard]

## User Flow — Pengembalian Buku
[Dashboard] -> [Menu "Pengembalian"] -> [Cari transaksi aktif (anggota/buku)]
        -> [Tandai "Dikembalikan"] -> [Stok buku bertambah 1]
        -> [Kembali ke Dashboard]

## Wireframe: Halaman Login
+--------------------------------------------+
|                SIMPUS-Mini                 |
+--------------------------------------------+
|                                            |
|             [ Login Petugas ]              |
|                                            |
|   Username : [____________________]        |
|   Password : [____________________]        |
|                                            |
|               [   Masuk   ]                |
|                                            |
|      Belum punya akun? Daftar di sini      |
|                                            |
+--------------------------------------------+

## Wireframe: Dashboard Petugas
+------------------------------------------------------------------------------+
| SIMPUS-Mini      Beranda | Buku | Anggota | Peminjaman      (Petugas) Logout |
+------------------------------------------------------------------------------+
|                                                                              |
|   [ Total Buku ]          [ Total Anggota ]          [ Sedang Dipinjam ]     |
|                                                                              |
|   Aksi Cepat:                                                                |
|   [ + Peminjaman Baru ]     [ + Pengembalian ]                               |
|                                                                              |
|   Transaksi Terbaru                                                          |
|   ------------------------------------------------------------------------   |
|   Anggota            | Buku                  | Tgl Pinjam    | Status        |
|   -------------------+-----------------------+---------------+------------   |
|   Siti Aminah        | Laskar Pelangi        | 08/09/2026    | Dipinjam      |
|   Budi Santoso       | Bumi Manusia          | 07/09/2026    | Dipinjam      |
|                                                                              |
+------------------------------------------------------------------------------+

## Wireframe: Form Peminjaman
+--------------------------------------------------------+
| Form Peminjaman Buku                                   |
+--------------------------------------------------------+
|                                                        |
|   Anggota        : [ dropdown pilih anggota      v ]   |
|   Buku           : [ dropdown, hanya stok > 0    v ]   |
|   Tanggal Pinjam : [ 08/09/2026 (auto: hari ini)   ]   |
|                                                        |
|                [  Simpan Peminjaman  ]                 |
|                                                        |
+--------------------------------------------------------+

## Wireframe: Form Pengembalian
+------------------------------------------------------------------+
| Pengembalian Buku                                                |
+------------------------------------------------------------------+
|                                                                  |
|   Cari transaksi aktif:                                          |
|   [ nama anggota / judul buku _____________________ ] [ Cari ]   |
|                                                                  |
|   Anggota        | Buku            | Tgl Pinjam   | Aksi         |
|   ---------------+-----------------+--------------+-----------   |
|   Siti Aminah    | Laskar Pelangi  | 01/09/2026   | [Kembali]    |
|                                                                  |
+------------------------------------------------------------------+

## Wireframe: Riwayat Peminjaman per Anggota
+------------------------------------------------------------------+
| Riwayat Peminjaman - Siti Aminah                                 |
+------------------------------------------------------------------+
|                                                                  |
|   Buku            | Tgl Pinjam   | Tgl Kembali   | Status        |
|   ----------------+--------------+---------------+------------   |
|   Laskar Pelangi  | 01/07/2026   | 10/07/2026    | Selesai       |
|   Bumi Manusia    | 15/07/2026   | -             | Dipinjam      |
|                                                                  |
+------------------------------------------------------------------+

## Wireframe: Registrasi Mandiri Anggota Baru
+----------------------------------------------------+
|                    SIMPUS-Mini                     |
+----------------------------------------------------+
|                                                    |
|           [ Registrasi Anggota Baru ]              |
|                                                    |
|   Nama Lengkap   : [__________________________]    |
|   NIM / No. Ident: [__________________________]    |
|   Email          : [__________________________]    |
|   Program Studi  : [ dropdown pilih prodi   v ]    |
|   No. WhatsApp   : [__________________________]    |
|   Password       : [__________________________]    |
|   Konfirmasi Pwd : [__________________________]    |
|                                                    |
|              [   Daftar Sekarang   ]               |
|                                                    |
|        Sudah punya akun? [ Login Petugas ]         |
|                                                    |
+----------------------------------------------------+

## Wireframe: Pemantauan Buku Terlambat & Denda
+-----------------------------------------------------------------------------------------+
| SIMPUS-Mini      Beranda | Buku | Anggota | Peminjaman | Terlambat     (Petugas) Logout |
+-----------------------------------------------------------------------------------------+
|                                                                                         |
|   Daftar Peminjaman Melewati Jatuh Tempo (Terlambat)                                    |
|   ---------------------------------------------------------------------------           |
|   Pencarian: [ Nama anggota / Judul buku ____________________ ] [ Cari ]                |
|                                                                                         |
|   Anggota      | Judul Buku       | Jatuh Tempo | Terlambat | Denda   | Aksi            | 
|   -------------+------------------+-------------+-----------+---------+---------        |
|   Ahmad Dani   | Clean Code       | 01/09/2026  | 7 Hari    | Rp7.000 | [Notif]         |
|   Rina Wijaya  | Sistem Basis Data| 03/09/2026  | 5 Hari    | Rp5.000 | [Notif]         |
|                                                                                         |
|   Ringkasan: 2 Transaksi Terlambat | Total Estimasi Denda: Rp12.000                     |
|                                                                                         |
+-----------------------------------------------------------------------------------------+



