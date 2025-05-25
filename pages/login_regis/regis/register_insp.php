<?php
session_start();
require_once '../../../koneksi/link.php';

$error = '';
$success = '';

// Check database connection
if (!isset($conn) || !$conn) {
    die("Koneksi ke database gagal.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and trim all incoming POST data
    $nama = trim($_POST['nama'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $telfon = trim($_POST['telfon'] ?? '');
    $password = $_POST['password'] ?? '';
    $konf_password = $_POST['konf_password'] ?? '';
    $alamat = trim($_POST['alamat'] ?? '');
    $provinsi = trim($_POST['provinsi'] ?? '');
    $kota = trim($_POST['kota'] ?? '');
    $kecamatan = trim($_POST['kecamatan'] ?? '');
    $spesialisasi = trim($_POST['spesialisasi'] ?? '');
    $tahun_pengalaman = (int) ($_POST['tahun_pengalaman'] ?? 0);
    $lisensi_file = $_FILES['lisensi_file'] ?? null;

    // Server-side validation
    if (empty($nama) || empty($username) || empty($email) || empty($telfon) || empty($password) || empty($konf_password) || empty($alamat) || empty($provinsi) || empty($kota) || empty($kecamatan) || empty($spesialisasi) || empty($tahun_pengalaman)) {
        $error = "Semua kolom wajib diisi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid.";
    } elseif (strlen($password) < 6) {
        $error = "Password minimal 6 karakter.";
    } elseif ($password !== $konf_password) {
        $error = "Konfirmasi password tidak cocok.";
    } elseif (!$lisensi_file || $lisensi_file['error'] !== UPLOAD_ERR_OK) { // Check for proper upload success code
        $error = "File lisensi wajib diunggah.";
    } else {
        // Check if username already exists
        $sql_check = "SELECT username FROM login WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql_check);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) > 0) {
                $error = "Username sudah terdaftar.";
            }
            mysqli_stmt_close($stmt);
        } else {
            $error = "Gagal menyiapkan statement untuk cek username: " . mysqli_error($conn);
        }
    }

    if (!$error) {
        // File upload handling
        $upload_dir = '../../../uploads/lisensi/';
        if (!is_dir($upload_dir)) {
            if (!mkdir($upload_dir, 0777, true)) { // Ensure recursive directory creation
                $error = "Gagal membuat direktori upload.";
            }
        }

        if (empty($error)) {
            $filename = time() . '_' . basename($lisensi_file['name']);
            $target_path = $upload_dir . $filename;

            if (!move_uploaded_file($lisensi_file['tmp_name'], $target_path)) {
                $error = "Gagal mengunggah file lisensi.";
            }
        }
    }

    if (!$error) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Start transaction
        mysqli_begin_transaction($conn);

        try {
            // INSERT into login table
            $sql_login = "INSERT INTO login (username, password, role, status) VALUES (?, ?, 'Inspektor', 'aktif')";
            $stmt_login = mysqli_prepare($conn, $sql_login);
            if (!$stmt_login) {
                throw new mysqli_sql_exception("Gagal menyiapkan statement untuk login: " . mysqli_error($conn));
            }
            mysqli_stmt_bind_param($stmt_login, "ss", $username, $password_hash);
            if (!mysqli_stmt_execute($stmt_login)) {
                throw new mysqli_sql_exception("Gagal mengeksekusi statement login: " . mysqli_stmt_error($stmt_login));
            }
            mysqli_stmt_close($stmt_login);

            // INSERT into register_inspektor table
            $sql_insert = "INSERT INTO register_inspektor
                (nama, username, email, telfon, password, spesialisasi, tahun_pengalaman, alamat, provinsi, kota, kecamatan, tgl_daftar, lisensi_file)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)";
            $stmt = mysqli_prepare($conn, $sql_insert);
            if (!$stmt) {
                throw new mysqli_sql_exception("Gagal menyiapkan statement untuk inspektor: " . mysqli_error($conn));
            }
            // Bind parameters for register_inspektor
            mysqli_stmt_bind_param($stmt, "ssssssisssss",
                $nama,
                $username,
                $email,
                $telfon,
                $password_hash, // Store hashed password here too, or reference it from login table if design allows
                $spesialisasi,
                $tahun_pengalaman,
                $alamat,
                $provinsi,
                $kota,
                $kecamatan,
                $filename
            );
            if (!mysqli_stmt_execute($stmt)) {
                throw new mysqli_sql_exception("Gagal mengeksekusi statement inspektor: " . mysqli_stmt_error($stmt));
            }
            mysqli_stmt_close($stmt);

            mysqli_commit($conn);
            $success = "Registrasi berhasil!";
            echo "<script>alert('✅ Registrasi berhasil!'); window.location.href = '../login/login.php?registered=inspector';</script>";
            exit;

        } catch (mysqli_sql_exception $e) {
            mysqli_rollback($conn);
            $error = "Terjadi kesalahan database: " . $e->getMessage();

        } finally {
            mysqli_close($conn);
        }
    } else {
        echo "<script>alert('❌ " . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrasi Inspektor - TemuMobil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link href="regis.css" rel="stylesheet" />
</head>
<body>
    <div class="bg-elements">
        <div class="floating-shape shape-1"></div>
        <div class="floating-shape shape-2"></div>
        <div class="floating-car car-1"><i class="fas fa-user-tie"></i></div>
        <div class="floating-car car-2"><i class="fas fa-tools"></i></div>
    </div>

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

    <div class="container">
        <div class="register-container inspector-register">
            <div class="register-card">
                <div class="register-header">
                    <div class="register-icon inspector-icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <h2 class="register-title">Registrasi Inspektor</h2>
                    <p class="register-subtitle">Bergabunglah sebagai inspektor profesional dan berikan layanan terbaik</p>
                </div>

                <?php if ($error && $_SERVER['REQUEST_METHOD'] === 'POST'): // Only show error if form was submitted and there's an error ?>
                    <div class="alert alert-danger alert-custom">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <?php if ($success && $_SERVER['REQUEST_METHOD'] === 'POST'): // Only show success if form was submitted and successful ?>
                    <div class="alert alert-success alert-custom">
                        <i class="fas fa-check-circle me-2"></i>
                        <?= htmlspecialchars($success) ?>
                    </div>
                <?php endif; ?>

                <form action="" method="post" enctype="multipart/form-data" autocomplete="off" class="register-form" id="inspectorRegisterForm">
                    <div class="form-section">
                        <h5 class="section-title">
                            <i class="fas fa-user me-2"></i>
                            Informasi Pribadi
                        </h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                    <input type="text" id="nama" name="nama" class="form-control form-control-custom"
                                        required value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>"
                                        placeholder="Masukkan nama lengkap" />
                                    <div class="form-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" id="username" name="username" class="form-control form-control-custom"
                                        required value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                                        placeholder="Pilih username unik" />
                                    <div class="form-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" id="email" name="email" class="form-control form-control-custom"
                                        required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                                        placeholder="nama@email.com" />
                                    <div class="form-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telfon" class="form-label">Nomor Telepon</label>
                                    <input type="tel" id="telfon" name="telfon" class="form-control form-control-custom"
                                        required value="<?= htmlspecialchars($_POST['telfon'] ?? '') ?>"
                                        placeholder="08xxxxxxxxxx" />
                                    <div class="form-feedback"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h5 class="section-title">
                            <i class="fas fa-lock me-2"></i>
                            Keamanan Akun
                        </h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password" class="form-label">Password</label>
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
                                    <label for="konf_password" class="form-label">Konfirmasi Password</label>
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
                    </div>

                    <div class="form-section">
                        <h5 class="section-title">
                            <i class="fas fa-briefcase me-2"></i>
                            Informasi Profesional
                        </h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="spesialisasi" class="form-label">Spesialisasi</label>
                                    <select name="spesialisasi" id="spesialisasi" class="form-select form-control-custom" required>
                                        <option value="">Pilih Spesialisasi</option>
                                        <option value="Mesin" <?= ($_POST['spesialisasi'] ?? '') === 'Mesin' ? 'selected' : '' ?>>Mesin</option>
                                        <option value="Body & Cat" <?= ($_POST['spesialisasi'] ?? '') === 'Body & Cat' ? 'selected' : '' ?>>Body & Cat</option>
                                        <option value="Kelistrikan" <?= ($_POST['spesialisasi'] ?? '') === 'Kelistrikan' ? 'selected' : '' ?>>Kelistrikan</option>
                                        <option value="Kaki-Kaki" <?= ($_POST['spesialisasi'] ?? '') === 'Kaki-Kaki' ? 'selected' : '' ?>>Kaki-Kaki</option>
                                        <option value="Transmisi" <?= ($_POST['spesialisasi'] ?? '') === 'Transmisi' ? 'selected' : '' ?>>Transmisi</option>
                                        <option value="Interior & Eksterior" <?= ($_POST['spesialisasi'] ?? '') === 'Interior & Eksterior' ? 'selected' : '' ?>>Interior & Eksterior</option>
                                        <option value="Diesel" <?= ($_POST['spesialisasi'] ?? '') === 'Diesel' ? 'selected' : '' ?>>Diesel</option>
                                        <option value="Bensin" <?= ($_POST['spesialisasi'] ?? '') === 'Bensin' ? 'selected' : '' ?>>Bensin</option>
                                        <option value="Karburator" <?= ($_POST['spesialisasi'] ?? '') === 'Karburator' ? 'selected' : '' ?>>Karburator</option>
                                        <option value="Injeksi" <?= ($_POST['spesialisasi'] ?? '') === 'Injeksi' ? 'selected' : '' ?>>Injeksi</option>
                                    </select>
                                    <div class="form-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tahun_pengalaman" class="form-label">Tahun Pengalaman</label>
                                    <input type="number" id="tahun_pengalaman" name="tahun_pengalaman" class="form-control form-control-custom"
                                        required min="0" max="50" value="<?= htmlspecialchars($_POST['tahun_pengalaman'] ?? '') ?>"
                                        placeholder="Contoh: 5" />
                                    <div class="form-feedback"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="lisensi_file" class="form-label">
                                        <i class="fas fa-certificate me-2"></i>
                                        Upload Sertifikat / Lisensi
                                    </label>
                                    <div class="file-upload-area">
                                        <input type="file" id="lisensi_file" name="lisensi_file" class="form-control file-input"
                                            accept=".jpg,.png,.jpeg,.pdf" required />
                                        <div class="file-upload-text">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                            <span>Klik untuk upload atau drag & drop</span>
                                            <small>Format: JPG, PNG, PDF (Max: 5MB)</small>
                                        </div>
                                    </div>
                                    <div class="form-feedback"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h5 class="section-title">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            Informasi Alamat
                        </h5>
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="alamat" class="form-label">Alamat Lengkap</label>
                                    <textarea id="alamat" name="alamat" class="form-control form-control-custom"
                                                required rows="3" placeholder="Masukkan alamat lengkap"><?= htmlspecialchars($_POST['alamat'] ?? '') ?></textarea>
                                    <div class="form-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="provinsi" class="form-label">Provinsi</label>
                                    <select name="provinsi" id="provinsi" class="form-select form-control-custom" required>
                                        <option value="">Pilih Provinsi</option>
                                        <?php
                                        $provinsi_options = [
                                            "Aceh", "Sumatera Utara", "Sumatera Barat", "Riau", "Jambi", "Sumatera Selatan", "Bengkulu", "Lampung", "Kepulauan Bangka Belitung", "Kepulauan Riau",
                                            "DKI Jakarta", "Jawa Barat", "Jawa Tengah", "DI Yogyakarta", "Jawa Timur", "Banten",
                                            "Bali", "Nusa Tenggara Barat", "Nusa Tenggara Timur",
                                            "Kalimantan Barat", "Kalimantan Tengah", "Kalimantan Selatan", "Kalimantan Timur", "Kalimantan Utara",
                                            "Sulawesi Utara", "Sulawesi Tengah", "Sulawesi Selatan", "Sulawesi Tenggara", "Gorontalo", "Sulawesi Barat",
                                            "Maluku", "Maluku Utara",
                                            "Papua", "Papua Barat", "Papua Tengah", "Papua Pegunungan", "Papua Selatan", "Papua Barat Daya"
                                        ];

                                        foreach ($provinsi_options as $p) {
                                            $selected = ($p == ($_POST['provinsi'] ?? '')) ? ' selected' : '';
                                            echo '<option value="' . htmlspecialchars($p) . '"' . $selected . '>' . htmlspecialchars($p) . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <div class="form-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="kota" class="form-label">Kota/Kabupaten</label>
                                    <input type="text" id="kota" name="kota" class="form-control form-control-custom"
                                        required value="<?= htmlspecialchars($_POST['kota'] ?? '') ?>"
                                        placeholder="Contoh: Jakarta Selatan" />
                                    <div class="form-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="kecamatan" class="form-label">Kecamatan</label>
                                    <input type="text" id="kecamatan" name="kecamatan" class="form-control form-control-custom"
                                        required value="<?= htmlspecialchars($_POST['kecamatan'] ?? '') ?>"
                                        placeholder="Contoh: Kebayoran Baru" />
                                    <div class="form-feedback"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="terms" required>
                            <label class="form-check-label" for="terms">
                                Saya setuju dengan <a href="#" class="text-primary">Syarat & Ketentuan</a> dan <a href="#" class="text-primary">Kode Etik Inspektor</a>
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100 register-btn">
                        <span class="btn-text">
                            <i class="fas fa-user-tie me-2"></i>
                            Daftar Sebagai Inspektor
                        </span>
                        <span class="btn-loading d-none">
                            <i class="fas fa-spinner fa-spin me-2"></i>
                            Mendaftarkan...
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="register.js"></script> </body>
</html>