<?php
session_start();
require_once '../../../koneksi/link.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $telfon = trim($_POST['telfon'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $konf_password = $_POST['konf_password'] ?? '';

    if (!$nama || !$username || !$telfon || !$email || !$password || !$konf_password) {
        $error = "Semua kolom harus diisi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email tidak valid.";
    } elseif (strlen($password) < 6) {
        $error = "Password minimal 6 karakter.";
    } elseif ($password !== $konf_password) {
        $error = "Password dan konfirmasi password tidak sama.";
    } else {
        $sql_check = "SELECT username FROM login WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql_check);
        if (!$stmt) {
            $error = "Gagal mempersiapkan query: " . mysqli_error($conn);
        } else {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) > 0) {
                $error = "Username sudah terdaftar.";
            }
            mysqli_stmt_close($stmt);
        }

        if (!$error) {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $sql_insert_login = "INSERT INTO login (username, password, role, status) VALUES (?, ?, 'Pengguna', 'aktif')";
            $stmt_login = mysqli_prepare($conn, $sql_insert_login);
            if ($stmt_login) {
                mysqli_stmt_bind_param($stmt_login, "ss", $username, $password_hash);
                if (mysqli_stmt_execute($stmt_login)) {
                    mysqli_stmt_close($stmt_login);

                    $sql_insert = "INSERT INTO register_pengguna (username, nama_lengkap, email, telfon, password, alamat) VALUES (?, ?, ?, ?, ?, '')";
                    $stmt = mysqli_prepare($conn, $sql_insert);
                    if ($stmt) {
                        mysqli_stmt_bind_param($stmt, "sssss", $username, $nama, $email, $telfon, $password_hash);
                        if (mysqli_stmt_execute($stmt)) {
                            $success = "Registrasi berhasil!";
                            mysqli_stmt_close($stmt);
                            mysqli_close($conn);
                            header("Location: ../login/login.php?registered=1");
                            exit;
                        } else {
                            $error = "Gagal menyimpan ke register_pengguna: " . mysqli_stmt_error($stmt);
                            mysqli_stmt_close($stmt);
                        }
                    } else {
                        $error = "Gagal menyiapkan query register_pengguna: " . mysqli_error($conn);
                    }
                } else {
                    $error = "Gagal menyimpan ke login: " . mysqli_stmt_error($stmt_login);
                    mysqli_stmt_close($stmt_login);
                }
            } else {
                $error = "Gagal mempersiapkan query login: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Registrasi Pengguna - TemuMobil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link href="regis.css" rel="stylesheet" />
</head>
<body>
    <!-- Background Elements -->
    <div class="bg-elements">
        <div class="floating-shape shape-1"></div>
        <div class="floating-shape shape-2"></div>
        <div class="floating-car car-1"><i class="fas fa-user"></i></div>
    </div>

    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="../../../index.html">
                <div class="logo-container">
                    <div class="logo-icon">
                        <i class="fas fa-car"></i>
                    </div>
                    <div class="logo-text">
                        <span class="brand-name">TemuMobil</span>
                        <span class="brand-tagline">Terpercaya</span>
                    </div>
                </div>
            </a>
            <div class="navbar-nav ms-auto">
                <a href="pilihanregis.php" class="btn btn-outline-light btn-sm me-2">
                    <i class="fas fa-arrow-left me-1"></i>
                    Kembali
                </a>
                <a href="../login/login.php" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-sign-in-alt me-1"></i>
                    Masuk
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <div class="register-container">
            <div class="register-card">
                <div class="register-header">
                    <div class="register-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <h2 class="register-title">Registrasi Pengguna</h2>
                    <p class="register-subtitle">Bergabunglah dengan komunitas TemuMobil dan temukan mobil impian Anda</p>
                </div>

                <?php if ($error): ?>
                    <div class="alert alert-danger alert-custom">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="alert alert-success alert-custom">
                        <i class="fas fa-check-circle me-2"></i>
                        <?= htmlspecialchars($success) ?>
                    </div>
                <?php endif; ?>

                <form action="" method="post" autocomplete="off" class="register-form" id="userRegisterForm">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama" class="form-label">
                                    <i class="fas fa-user me-2"></i>
                                    Nama Lengkap
                                </label>
                                <input type="text" id="nama" name="nama" class="form-control form-control-custom" 
                                       required value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>" 
                                       placeholder="Masukkan nama lengkap Anda" />
                                <div class="form-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username" class="form-label">
                                    <i class="fas fa-at me-2"></i>
                                    Username
                                </label>
                                <input type="text" id="username" name="username" class="form-control form-control-custom" 
                                       required value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" 
                                       placeholder="Pilih username unik" />
                                <div class="form-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-2"></i>
                                    Email
                                </label>
                                <input type="email" id="email" name="email" class="form-control form-control-custom" 
                                       required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" 
                                       placeholder="nama@email.com" />
                                <div class="form-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telfon" class="form-label">
                                    <i class="fas fa-phone me-2"></i>
                                    Nomor Telepon
                                </label>
                                <input type="tel" id="telfon" name="telfon" class="form-control form-control-custom" 
                                       required value="<?= htmlspecialchars($_POST['telfon'] ?? '') ?>" 
                                       placeholder="08xxxxxxxxxx" />
                                <div class="form-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock me-2"></i>
                                    Password
                                </label>
                                <div class="password-input">
                                    <input type="password" id="password" name="password" class="form-control form-control-custom" 
                                           required placeholder="Minimal 6 karakter" />
                                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="password-strength">
                                    <div class="strength-bar"></div>
                                    <span class="strength-text">Kekuatan password</span>
                                </div>
                                <div class="form-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="konf_password" class="form-label">
                                    <i class="fas fa-lock me-2"></i>
                                    Konfirmasi Password
                                </label>
                                <div class="password-input">
                                    <input type="password" id="konf_password" name="konf_password" class="form-control form-control-custom" 
                                           required placeholder="Ulangi password" />
                                    <button type="button" class="password-toggle" onclick="togglePassword('konf_password')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="form-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="terms" required>
                            <label class="form-check-label" for="terms">
                                Saya setuju dengan <a href="#" class="text-primary">Syarat & Ketentuan</a> dan <a href="#" class="text-primary">Kebijakan Privasi</a>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100 register-btn">
                        <span class="btn-text">
                            <i class="fas fa-user-plus me-2"></i>
                            Daftar Sekarang
                        </span>
                        <span class="btn-loading d-none">
                            <i class="fas fa-spinner fa-spin me-2"></i>
                            Mendaftarkan...
                        </span>
                    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="register.js"></script>
</body>
</html>
