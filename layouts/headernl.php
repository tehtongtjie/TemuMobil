<?php
session_start();
require_once '../koneksi/link.php'; // pastikan path ini sesuai lokasi file
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>TemuMobil - Platform Jual Beli Mobil Terpercaya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <style>
        
    </style>
</head>
<body>
    <!-- Enhanced Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <div class="logo-icon">
                    <i class="fas fa-car"></i>
                </div>
                TemuMobil
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#beranda">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#mobil-bekas">Mobil Bekas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#mobil-baru">Mobil Baru</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#dealer">Dealer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#artikel">Artikel</a>
                    </li>
                </ul>
                
                <!-- Search Bar -->
                <div class="search-container d-none d-lg-block me-3">
                    <div class="position-relative">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" class="form-control search-input" placeholder="Cari mobil impian Anda...">
                    </div>
                </div>
                
                <!-- Auth Buttons -->
                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-login btn-custom">
                        <i class="fas fa-sign-in-alt me-1"></i>
                        Masuk
                    </a>
                    <a href="#" class="btn btn-register btn-custom">
                        <i class="fas fa-user-plus me-1"></i>
                        Daftar
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section" id="beranda" style="margin-top: 76px;">
        <div class="floating-elements">
            <i class="fas fa-car floating-car" style="top: 10%; left: 10%; font-size: 3rem;"></i>
            <i class="fas fa-car floating-car" style="top: 20%; right: 15%; font-size: 2rem; animation-delay: -2s;"></i>
            <i class="fas fa-car floating-car" style="bottom: 30%; left: 20%; font-size: 2.5rem; animation-delay: -4s;"></i>
        </div>
        
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content">
                        <h1>Temukan Mobil Impian Anda</h1>
                        <p>Platform terpercaya untuk jual beli mobil bekas dan baru dengan harga terbaik. Ribuan pilihan mobil berkualitas menanti Anda.</p>
                        
                        <div class="d-flex gap-3 flex-wrap">
                            <a href="#" class="btn btn-primary btn-lg btn-custom">
                                <i class="fas fa-search me-2"></i>
                                Cari Mobil
                            </a>
                            <a href="#" class="btn btn-outline-primary btn-lg btn-custom">
                                <i class="fas fa-plus me-2"></i>
                                Jual Mobil
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="search-box">
                        <h4 class="mb-4">Pencarian Cepat</h4>
                        
                        <!-- Quick Filters -->
                        <div class="mb-3">
                            <button class="btn filter-btn active">Semua</button>
                            <button class="btn filter-btn">Sedan</button>
                            <button class="btn filter-btn">SUV</button>
                            <button class="btn filter-btn">Hatchback</button>
                            <button class="btn filter-btn">MPV</button>
                        </div>
                        
                        <!-- Search Form -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <select class="form-select">
                                    <option>Pilih Merek</option>
                                    <option>Toyota</option>
                                    <option>Honda</option>
                                    <option>Suzuki</option>
                                    <option>Daihatsu</option>
                                    <option>Mitsubishi</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select class="form-select">
                                    <option>Pilih Model</option>
                                    <option>Avanza</option>
                                    <option>Innova</option>
                                    <option>Jazz</option>
                                    <option>Brio</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select class="form-select">
                                    <option>Tahun</option>
                                    <option>2024</option>
                                    <option>2023</option>
                                    <option>2022</option>
                                    <option>2021</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select class="form-select">
                                    <option>Harga</option>
                                    <option>< 100 Juta</option>
                                    <option>100-200 Juta</option>
                                    <option>200-500 Juta</option>
                                    <option>> 500 Juta</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 btn-custom">
                                    <i class="fas fa-search me-2"></i>
                                    Cari Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <span class="stat-number">50K+</span>
                        <span>Mobil Tersedia</span>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <span class="stat-number">25K+</span>
                        <span>Pelanggan Puas</span>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <span class="stat-number">500+</span>
                        <span>Dealer Partner</span>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <span class="stat-number">100+</span>
                        <span>Kota Terjangkau</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto">
                    <h2 class="display-5 fw-bold mb-3">Mengapa Pilih TemuMobil?</h2>
                    <p class="lead text-muted">Kami memberikan pengalaman terbaik dalam jual beli mobil dengan layanan terpercaya dan transparan.</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h5>Terpercaya</h5>
                        <p class="text-muted">Semua mobil telah melalui inspeksi ketat dan memiliki sertifikat keaslian.</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-tags"></i>
                        </div>
                        <h5>Harga Terbaik</h5>
                        <p class="text-muted">Dapatkan harga terbaik dengan sistem lelang dan negosiasi yang fair.</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h5>Support 24/7</h5>
                        <p class="text-muted">Tim customer service kami siap membantu Anda kapan saja.</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <h5>Pengiriman Cepat</h5>
                        <p class="text-muted">Layanan pengiriman ke seluruh Indonesia dengan asuransi penuh.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Filter buttons functionality
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Navbar background change on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.background = 'linear-gradient(135deg, rgba(37, 99, 235, 0.95) 0%, rgba(30, 64, 175, 0.95) 100%)';
                navbar.style.backdropFilter = 'blur(10px)';
            } else {
                navbar.style.background = 'linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%)';
                navbar.style.backdropFilter = 'none';
            }
        });
    </script>
</body>
</html>