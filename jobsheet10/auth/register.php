<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Jika pengguna sudah login, langsung arahkan ke beranda
if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

$page_title = "Registrasi Petugas";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

        <section style="max-width: 520px; margin: 30px auto;">
            <article>
                <div class="section-header" style="margin-bottom: 20px;">
                    <h2>Registrasi Petugas Baru</h2>
                    <span class="section-subtitle">Daftarkan akun petugas untuk mengelola data klinik PawCare Mini</span>
                </div>

                <?php if ($flash): ?>
                    <div class="flash flash-<?php echo htmlspecialchars($flash['type']); ?>">
                        <?php echo htmlspecialchars($flash['pesan']); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="proses_register.php">
                    <div class="form-group">
                        <label for="nama">Nama Lengkap Petugas *</label>
                        <input type="text" id="nama" name="nama" class="form-control" placeholder="Contoh: Jesyca Alice" required>
                    </div>

                    <div class="form-group">
                        <label for="username">Username *</label>
                        <input type="text" id="username" name="username" class="form-control" placeholder="Gunakan huruf kecil atau angka..." required autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label for="password">Password *</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Minimal 6 karakter..." required minlength="6">
                        <small style="color: #846F65; font-size: 11px; margin-top: 4px; display: block;">
                            Kata sandi akan otomatis dienkripsi secara aman dengan algoritma Bcrypt (password_hash).
                        </small>
                    </div>

                    <div style="margin-top: 24px;">
                        <button type="submit" class="btn btn-primary" style="width: 100%;">Daftar Akun Petugas</button>
                    </div>
                </form>

                <div style="margin-top: 20px; text-align: center; font-size: 13px; color: #5C4337; border-top: 1px solid #EADFD6; padding-top: 16px;">
                    Sudah memiliki akun petugas? 
                    <a href="login.php" style="color: #8B6A5B; font-weight: bold; text-decoration: none;">Login di sini</a>
                </div>
            </article>
        </section>

<?php include __DIR__ . '/../includes/footer.php'; ?>