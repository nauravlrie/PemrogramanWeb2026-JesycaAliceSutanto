<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Jika pengguna sudah login, langsung arahkan ke beranda
if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

$page_title = "Login Petugas";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

        <section style="max-width: 480px; margin: 30px auto;">
            <article>
                <div class="section-header" style="margin-bottom: 20px;">
                    <h2>Login Petugas</h2>
                    <span class="section-subtitle">Masukkan akun petugas untuk mengakses sistem manajemen klinik</span>
                </div>

                <?php if ($flash): ?>
                    <div class="flash flash-<?php echo e($flash['type']); ?>">
                        <?php echo e($flash['pesan']); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="proses_login.php">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan username..." required autocomplete="username">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan kata sandi..." required autocomplete="current-password">
                    </div>

                    <div style="margin-top: 24px;">
                        <button type="submit" class="btn btn-primary" style="width: 100%;">Masuk ke Sistem</button>
                    </div>
                </form>

                <div style="margin-top: 20px; text-align: center; font-size: 13px; color: #5C4337; border-top: 1px solid #EADFD6; padding-top: 16px;">
                    Belum memiliki akun petugas? 
                    <a href="register.php" style="color: #8B6A5B; font-weight: bold; text-decoration: none;">Daftar akun di sini</a>
                </div>
            </article>
        </section>

<?php include __DIR__ . '/../includes/footer.php'; ?>