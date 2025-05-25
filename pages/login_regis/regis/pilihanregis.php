<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pilih Jenis Registrasi - TemuMobil</title>
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
        <div class="floating-shape shape-3"></div>
        <div class="floating-car car-1"><i class="fas fa-car"></i></div>
        <div class="floating-car car-2"><i class="fas fa-tools"></i></div>
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
                <a href="../../index.php" class="btn btn-outline-light btn-sm me-2">
                    <i class="fas fa-arrow-left me-1"></i>
                    Kembali
                </a>
                <a href="../../login_regis/login/login.php" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-sign-in-alt me-1"></i>
                    Masuk
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <div class="registration-choice-container">
            <div class="choice-header text-center">
                <div class="choice-badge">
                    <i class="fas fa-user-plus"></i>
                    Bergabung dengan TemuMobil
                </div>
                <h1 class="choice-title">Pilih Jenis Akun Anda</h1>
                <p class="choice-description">
                    Bergabunglah dengan ribuan pengguna yang telah mempercayai TemuMobil untuk kebutuhan otomotif mereka
                </p>
            </div>

            <div class="row g-4 justify-content-center">
                <!-- User Registration -->
                <div class="col-lg-5 col-md-6">
                    <div class="choice-card user-card">
                        <div class="card-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <h3 class="card-title">Pengguna</h3>
                        <p class="card-description">
                            Untuk pembeli dan penjual mobil yang ingin menggunakan platform TemuMobil
                        </p>
                        <ul class="card-features">
                            <li><i class="fas fa-check"></i> Jual & Beli Mobil</li>
                            <li><i class="fas fa-check"></i> Akses Semua Fitur</li>
                            <li><i class="fas fa-check"></i> Support 24/7</li>
                            <li><i class="fas fa-check"></i> Gratis Selamanya</li>
                        </ul>
                        <a href="register.php" class="btn btn-primary btn-lg w-100 choice-btn">
                            <i class="fas fa-arrow-right me-2"></i>
                            Daftar Sebagai Pengguna
                        </a>
                        <div class="card-stats">
                            <span><strong>25K+</strong> Pengguna Aktif</span>
                        </div>
                    </div>
                </div>

                <!-- Inspector Registration -->
                <div class="col-lg-5 col-md-6">
                    <div class="choice-card inspector-card">
                        <div class="card-icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <h3 class="card-title">Inspektor</h3>
                        <p class="card-description">
                            Untuk profesional otomotif yang ingin memberikan layanan inspeksi mobil
                        </p>
                        <ul class="card-features">
                            <li><i class="fas fa-check"></i> Layanan Inspeksi</li>
                            <li><i class="fas fa-check"></i> Penghasilan Tambahan</li>
                            <li><i class="fas fa-check"></i> Sertifikat Resmi</li>
                            <li><i class="fas fa-check"></i> Jaringan Profesional</li>
                        </ul>
                        <a href="register_insp.php" class="btn btn-primary btn-lg w-100 choice-btn">
                            <i class="fas fa-arrow-right me-2"></i>
                            Daftar Sebagai Inspektor
                        </a>
                        <div class="card-stats">
                            <span><strong>500+</strong> Inspektor Bersertifikat</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Info -->
            <div class="additional-info text-center">
                <h4>Mengapa Bergabung dengan TemuMobil?</h4>
                <div class="row g-3 mt-3">
                    <div class="col-md-4">
                        <div class="info-item">
                            <i class="fas fa-shield-alt"></i>
                            <span>100% Aman & Terpercaya</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-item">
                            <i class="fas fa-headset"></i>
                            <span>Support 24/7</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-item">
                            <i class="fas fa-award"></i>
                            <span>Platform Terbaik</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="register-footer">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p>&copy; 2024 TemuMobil. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="footer-links">
                        <a href="#">Privacy Policy</a>
                        <a href="#">Terms of Service</a>
                        <a href="#">Help</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="register.js"></script>
</body>
</html>
