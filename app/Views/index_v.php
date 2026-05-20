<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APELDESA | Aplikasi Pengelolaan Kegiatan Desa Segarau Parit</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --digi-green: #10b981; 
            --digi-green-rgb: 16, 185, 129;
            --digi-dark: #064e3b; 
            --digi-dark-rgb: 6, 78, 59;
            --digi-light: #f0fdf4; 
            --text-dark: #0f172a;
            --text-gray: #475569;
            --border-light: #e2e8f0;
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            color: var(--text-dark);
            background-color: #ffffff;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* --- GLOBAL UTILITIES --- */
        .section-padding { padding: 120px 0; }
        .badge-pill-custom {
            background: var(--digi-light); 
            color: var(--digi-green); 
            font-weight: 700;
            font-size: 0.8rem;
            letter-spacing: 1px;
            padding: 8px 20px;
            border-radius: 100px;
            display: inline-block;
        }

        /* --- NAVBAR --- */
        .navbar {
            padding: 20px 0;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(var(--digi-green-rgb), 0.08);
        }
        .navbar-brand { font-size: 24px; font-weight: 800; color: var(--digi-dark) !important; letter-spacing: -0.5px; }
        .navbar-brand span { color: var(--digi-green); }
        .nav-link { color: var(--text-gray); font-weight: 600; padding: 8px 16px !important; transition: 0.2s ease; }
        .nav-link:hover { color: var(--digi-green); }

        /* --- HERO SECTION --- */
        .hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: #ffffff;
            padding-top: 100px;
            overflow: hidden;
        }
        .hero-content { position: relative; z-index: 10; }
        .hero h1 { 
            color: var(--digi-dark); 
            font-size: 54px; 
            font-weight: 800; 
            line-height: 1.15; 
            letter-spacing: -2px;
        }
        .hero h1 span { color: var(--digi-green); }
        .hero h2 { 
            color: var(--text-gray); 
            margin: 24px 0 40px 0; 
            font-size: 1.15rem; 
            font-weight: 400; 
            line-height: 1.7;
            max-width: 540px;
        }
        .hero-bg-merge {
            position: absolute;
            top: 0;
            right: 0;
            width: 50%;
            height: 100%;
            background-image: url('https://i.ibb.co.com/LhhLfgX1/faisal.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            z-index: 1;
        }
        .hero-bg-merge::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, #ffffff 0%, rgba(255, 255, 255, 0.9) 10%, rgba(255, 255, 255, 0) 100%);
        }

        /* --- BUTTONS --- */
        .btn-custom-primary {
            background: var(--digi-green);
            padding: 16px 36px;
            border-radius: 14px;
            color: #ffffff;
            font-weight: 700;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            border: none;
            box-shadow: 0 10px 25px -5px rgba(var(--digi-green-rgb), 0.3);
        }
        .btn-custom-primary:hover { 
            background: var(--digi-dark); 
            color: #ffffff; 
            transform: translateY(-2px); 
            box-shadow: 0 20px 35px -10px rgba(var(--digi-dark-rgb), 0.3); 
        }

        /* --- COUNTER SECTION --- */
        .counts { background: #ffffff; padding-bottom: 60px; }
        .count-box {
            display: flex;
            align-items: center;
            padding: 30px;
            background: var(--digi-light);
            border-radius: 20px;
            height: 100%;
            border: 1px solid rgba(var(--digi-green-rgb), 0.08);
            transition: all 0.3s ease;
        }
        .count-box:hover { transform: translateY(-4px); background: #ffffff; box-shadow: 0 20px 40px rgba(0,0,0,0.04); border-color: rgba(var(--digi-green-rgb), 0.2); }
        .count-box i { font-size: 32px; color: var(--digi-green); margin-right: 20px; }
        .count-box h3 { font-size: 1.75rem; font-weight: 800; color: var(--digi-dark); margin-bottom: 2px; }
        .count-box p { color: var(--text-gray); font-weight: 600; font-size: 0.85rem; margin-bottom: 0; }

        /* --- FEATURE/LAYANAN SECTION --- */
        .layanan-section { background: #f8fafc; }
        .feature-box {
            padding: 45px 35px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            height: 100%;
            border-radius: 24px;
            background: #ffffff;
            border: 1px solid var(--border-light);
        }
        .feature-box:hover { 
            transform: translateY(-8px); 
            border-color: transparent; 
            box-shadow: 0 30px 60px rgba(var(--digi-dark-rgb), 0.08); 
        }
        .feature-icon-wrapper {
            width: 64px; height: 64px;
            background: var(--digi-light);
            color: var(--digi-green);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px; margin-bottom: 24px;
            transition: 0.3s ease;
        }
        .feature-box:hover .feature-icon-wrapper { background: var(--digi-green); color: #ffffff; }
        .feature-box h3 { font-weight: 700; color: var(--digi-dark); font-size: 1.25rem; margin-bottom: 12px; }
        .feature-box p { color: var(--text-gray); font-size: 0.9rem; line-height: 1.6; margin-bottom: 0; }

        /* --- GIS SECTION (Perbaikan Tinggi Kritis) --- */
        .gis-section { background: #ffffff; }
        #mapLanding { 
            height: 550px !important; 
            min-height: 550px !important;
            width: 100% !important;
            border-radius: 24px; 
            box-shadow: 0 20px 50px rgba(0,0,0,0.06); 
            border: 1px solid var(--border-light);
            background-color: #f1f5f9; /* Fallback warna jika peta bermasalah */
            z-index: 5; 
        }

        /* --- PROFIL KADES VISI MISI --- */
        .vimi-container {
            position: relative;
            border-radius: 32px; 
            padding: 80px 60px; 
            background: linear-gradient(145deg, #043e2f 0%, #011c16 100%) !important;
            box-shadow: 0 30px 70px rgba(0, 0, 0, 0.25);
            overflow: hidden;
        }
        .photo-wrapper img {
            width: 230px; height: 290px; 
            object-fit: cover; 
            border-radius: 20px; 
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }
        .kades-name-wrapper { position: relative; display: inline-block; }
        .kades-name-wrapper h2 { font-weight: 800; color: #ffffff; }
        .vision-card-modern {
            background: rgba(255, 255, 255, 0.03); 
            border-radius: 20px; 
            border: 1px solid rgba(255, 255, 255, 0.08);
            padding: 40px;
            height: 100%;
        }
        .icon-circle {
            width: 48px; height: 48px; 
            background: rgba(16, 185, 129, 0.2); 
            color: var(--digi-green); 
            border-radius: 12px; 
            display: flex; align-items: center; justify-content: center; 
            font-size: 18px;
        }
        .misi-list-item {
            background: rgba(255, 255, 255, 0.02);
            border-radius: 14px;
            padding: 18px 20px;
            margin-bottom: 14px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }
        .misi-list-item:hover {
            background: rgba(16, 185, 129, 0.05);
            border-color: rgba(16, 185, 129, 0.2);
            transform: translateX(5px);
        }

        /* --- MODAL DESIGN --- */
        .modal-modern .modal-content { border-radius: 24px; padding: 20px; border: none; }
        .modal-modern .form-control, .modal-modern .form-select { 
            background-color: #f8fafc; 
            border: 1.5px solid #e2e8f0; 
            padding: 12px 16px; 
            border-radius: 12px; 
            font-size: 0.95rem;
        }
        .modal-modern .form-control:focus, .modal-modern .form-select:focus { 
            border-color: var(--digi-green); 
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1); 
            background-color: #ffffff; 
        }
        .btn-login-modern { 
            background: var(--digi-green); 
            padding: 14px; 
            border-radius: 12px; 
            font-weight: 700;
            border: none;
            transition: 0.2s ease;
        }
        .btn-login-modern:hover { background: var(--digi-dark); }

        /* --- FOOTER --- */
        footer { background: #022c22; color: #cbd5e1; padding: 100px 0 40px; font-size: 0.9rem; }
        footer .navbar-brand { color: #ffffff !important; }
        footer h4 { color: #ffffff; font-weight: 700; font-size: 1.1rem; margin-bottom: 24px; }
        .footer-links list-unstyled li { margin-bottom: 12px; }
        .footer-links a { color: #94a3b8; text-decoration: none; transition: 0.2s ease; }
        .footer-links a:hover { color: var(--digi-green); }

        /* Responsive Breakpoints */
        @media (max-width: 991px) {
            .section-padding { padding: 80px 0; }
            .hero { padding-top: 120px; text-align: center; min-height: auto; padding-bottom: 80px; }
            .hero h1 { font-size: 38px; text-shadow: none; }
            .hero h2 { font-size: 1rem; margin: 20px auto 35px auto; }
            .hero-bg-merge { width: 100%; opacity: 0.08; background-position: center; }
            .hero-bg-merge::before { background: #ffffff; }
            .vimi-container { padding: 40px 24px; }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">APEL<span>DESA</span></a>
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link" href="#hero">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="#layanan">Layanan</a></li>
                <li class="nav-item"><a class="nav-link" href="#peta-sebaran">Peta GIS</a></li>
                <li class="nav-item"><a class="nav-link" href="#profil-kades">Kepala Desa</a></li>
                <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                    <a href="#" class="btn-custom-primary py-2 px-4 fs-6 shadow-none" data-bs-toggle="modal" data-bs-target="#loginModal">
                        <i class="far fa-user me-2"></i> Dashboard
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<section id="hero" class="hero">
    <div class="hero-bg-merge" data-aos="fade"></div>
    <div class="container hero-content">
        <div class="row">
            <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up">
                <h1>Wujudkan <span>Tata Kelola</span> Digital Segarau Parit</h1>
                <h2>Sistem cerdas untuk akselerasi administrasi, transparansi kegiatan, dan efisiensi pelayanan publik Desa Segarau Parit, Kecamatan Tebas.</h2>
                <div>
                    <a href="#layanan" class="btn-custom-primary">
                        <span>Eksplorasi Layanan</span>
                        <i class="fas fa-arrow-right ms-2 fs-7"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="counts">
    <div class="container" data-aos="fade-up">
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="count-box">
                    <i class="linearicons-users fas fa-users"></i>
                    <div><h3>2.350</h3><p>TOTAL PENDUDUK</p></div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="count-box">
                    <i class="fas fa-layer-group"></i>
                    <div><h3>158</h3><p>KEGIATAN DESA</p></div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="count-box">
                    <i class="fas fa-shield-halved"></i>
                    <div><h3>42</h3><p>LAYANAN AKTIF</p></div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="count-box">
                    <i class="far fa-award fas fa-award"></i>
                    <div><h3>12</h3><p>PENGHARGAAN</p></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="layanan" class="layanan-section section-padding">
    <div class="container" data-aos="fade-up">
        <header class="text-center mb-5 pb-2">
            <span class="badge-pill-custom mb-3">FITUR UNGGULAN</span>
            <h2 class="fw-bold text-dark display-6">Solusi Desa Digital</h2>
            <p class="text-muted mx-auto" style="max-width: 500px; font-size: 0.95rem;">Transformasi sistem layanan konvensional menjadi ekosistem digital yang ringkas dan terukur.</p>
        </header>
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="feature-box" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-icon-wrapper"><i class="fas fa-folder-open"></i></div>
                    <h3>Manajemen Kegiatan</h3>
                    <p>Pengelolaan data agenda pembangunan, pendanaan, serta arsip sosial desa yang terpusat dan terstruktur.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="feature-box" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-icon-wrapper"><i class="fas fa-feather-alt"></i></div>
                    <h3>Otorisasi Digital</h3>
                    <p>Sistem validasi dokumen dan persetujuan kegiatan langsung oleh Kepala Desa guna memotong birokrasi yang lambat.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="feature-box" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-icon-wrapper"><i class="fas fa-file-invoice"></i></div>
                    <h3>Pelaporan Otomatis</h3>
                    <p>Komparasi data instan untuk mencetak berkas laporan kegiatan fisik berstandar baku regulasi pemerintahan.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="peta-sebaran" class="gis-section section-padding">
    <div class="container">
        <header class="text-center mb-5 pb-2" data-aos="fade-up">
            <span class="badge-pill-custom mb-3">GEOGRAPHIC INFORMATION SYSTEM</span>
            <h2 class="fw-bold text-dark display-6">Pemetaan Realisasi Kegiatan</h2>
            <p class="text-muted mx-auto" style="max-width: 520px; font-size: 0.95rem;">Transparansi penuh peta lokasi sebaran infrastruktur dan program sosial di wilayah Desa Segarau Parit.</p>
        </header>
        <div class="row">
            <div class="col-lg-12">
                <div id="mapLanding"></div>
            </div>
        </div>
    </div>
</section>

<section id="profil-kades" class="section-padding" style="background: #f8fafc;">
    <div class="container">
        <div class="vimi-container" data-aos="fade-up">
            <div class="row align-items-center g-5 mb-5 text-center text-lg-start">
                <div class="col-lg-4 d-flex justify-content-center">
                    <div class="photo-wrapper">
                        <img src="<?= base_url('uploads/kades/' . ($kades['foto'] ?? 'default.jpg')) ?>" alt="Kepala Desa">
                    </div>
                </div>
                <div class="col-lg-8">
                    <span class="badge mb-3 px-3 py-2 rounded-pill" style="background: rgba(16, 185, 129, 0.1); color: var(--digi-green); font-weight: 700; font-size: 0.75rem; letter-spacing: 1.5px;">PROFIL PEMIMPIN</span>
                    <div class="kades-name-wrapper d-block mb-2">
                        <h2 class="display-5 m-0"><?= esc($kades['nama_lengkap'] ?? 'Nama Kepala Desa') ?></h2>
                    </div>
                    <p class="fw-bold text-uppercase mb-1" style="color: var(--digi-green); letter-spacing: 2px; font-size: 0.85rem;">Kepala Desa Segarau Parit</p>
                    <p class="text-white-50 mb-0">Masa Bakti: 2022 — 2028</p>
                    <?php if(!empty($kades['nip'])): ?>
                        <p class="text-white-50 small mt-1">NIP. <?= esc($kades['nip']) ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-5">
                    <div class="vision-card-modern">
                        <div class="d-flex align-items-center mb-4">
                            <div class="icon-circle me-3"><i class="far fa-lightbulb"></i></div>
                            <h4 class="text-white fw-700 m-0">Visi</h4>
                        </div>
                        <p class="text-white-50 lh-lg" style="font-style: italic; font-size: 1.05rem;">
                            "Mewujudkan desa digital yang mandiri, transparan, dan unggul dalam pelayanan publik melalui inovasi teknologi informasi demi kesejahteraan masyarakat Segarau Parit."
                        </p>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="vision-card-modern">
                        <div class="d-flex align-items-center mb-4">
                            <div class="icon-circle me-3"><i class="fas fa-tasks"></i></div>
                            <h4 class="text-white fw-700 m-0">Misi Utama</h4>
                        </div>
                        <div class="misi-list">
                            <div class="misi-list-item">
                                <i class="fas fa-check text-success me-3"></i>
                                <span class="text-white-50">Digitalisasi tata kelola administrasi pemerintahan desa secara terpadu.</span>
                            </div>
                            <div class="misi-list-item">
                                <i class="fas fa-check text-success me-3"></i>
                                <span class="text-white-50">Mendorong transparansi anggaran dan realisasi pembangunan kepada publik.</span>
                            </div>
                            <div class="misi-list-item">
                                <i class="fas fa-check text-success me-3"></i>
                                <span class="text-white-50">Meningkatkan kualitas SDM perangkat desa yang adaptif terhadap teknologi.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<footer>
    <div class="container">
        <div class="row gy-5 text-md-start text-center">
            <div class="col-lg-5">
                <a href="#" class="navbar-brand">APEL<span>DESA</span></a>
                <p class="mt-3 text-white-50 lh-lg" style="max-width: 360px;">Platform digital resmi untuk pengawasan, integrasi data, dan pelaporan berkas publik Pemerintah Desa Segarau Parit, Kecamatan Tebas, Kabupaten Sambas.</p>
            </div>
            <div class="col-lg-3 col-6 footer-links ms-auto">
                <h4>Navigasi</h4>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><a href="#hero">Beranda</a></li>
                    <li class="mb-2"><a href="#layanan">Fitur Layanan</a></li>
                    <li class="mb-2"><a href="#peta-sebaran">Peta Spasial</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-6 footer-links">
                <h4>Kontak Utama</h4>
                <p class="small text-white-50 lh-lg mb-0">
                    <i class="fas fa-map-marker-alt me-2 text-white"></i> Jl. Raya Segarau Parit, Kec. Tebas<br>Kabupaten Sambas, Kalimantan Barat<br>
                    <i class="fas fa-envelope me-2 text-white mt-3"></i> segarauparit@desa.go.id
                </p>
            </div>
        </div>
        <hr class="mt-5 border-secondary opacity-20">
        <div class="text-center pt-3">
            <p class="mb-0 small text-white-50">&copy; 2026 <strong>Pemerintah Desa Segarau Parit</strong>. All Rights Reserved.</p>
        </div>
    </div>
</footer>

<div class="modal fade modal-modern" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header border-0 pt-4 px-4 pb-0 d-block">
                <button type="button" class="btn-close float-end shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                <h3 class="modal-title fw-800 mt-2" style="color: var(--digi-dark);">Login <span>Sistem</span></h3>
                <p class="text-muted small">Masuk ke internal dashboard APELDESA.</p>
            </div>
            <div class="modal-body px-4 pb-4">
                <form action="<?= base_url('auth/loginProcess') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Username</label>
                        <input type="text" name="username" class="form-control shadow-none" placeholder="Masukkan username" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted">Password</label>
                        <div class="position-relative">
                            <input type="password" id="passwordInput" name="password" class="form-control shadow-none" placeholder="••••••••" required>
                            <i class="fas fa-eye toggle-password" id="eyeIcon" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #94a3b8;"></i>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-login-modern btn-primary w-100 text-white">
                        Otorisasi Masuk <i class="fas fa-sign-in-alt ms-2"></i>
                    </button>
                    <div class="text-center mt-3">
                        <p class="mb-0 small text-muted">Akses akun aparatur baru? <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#registerModal" data-bs-dismiss="modal" class="text-success text-decoration-none fw-bold">Ajukan Pendaftaran</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-modern" id="registerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header border-0 pt-4 px-4 pb-0 d-block">
                <button type="button" class="btn-close float-end shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                <h3 class="modal-title fw-800 mt-2" style="color: var(--digi-dark);">Registrasi <span>Aparatur</span></h3>
                <p class="text-muted small">Permohonan hak akses akun operator desa.</p>
            </div>
            <div class="modal-body px-4 pb-4">
                <form action="<?= base_url('auth/registerProcess') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control shadow-none" placeholder="Sesuai SK Jabatan Resmi" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label small fw-bold text-muted">Username</label>
                            <input type="text" name="username" class="form-control shadow-none" placeholder="Pilih username" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Formasi Jabatan</label>
                            <select name="role" class="form-select shadow-none" required>
                                <option value="perangkat_desa">Perangkat Desa</option>
                                <option value="kepala_desa">Kepala Desa</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted">Kata Sandi</label>
                        <input type="password" name="password" class="form-control shadow-none" placeholder="Gunakan kombinasi kuat" required>
                    </div>
                    <div class="alert alert-success border-0 small mb-4" style="background: var(--digi-light); color: var(--digi-dark); border-radius: 12px;">
                        <i class="fas fa-info-circle me-2"></i> Akun memerlukan peninjauan dan aktivasi berkas oleh Administrator IT Utama.
                    </div>
                    <button type="submit" class="btn btn-login-modern btn-primary w-100 text-white">
                        Kirim Berkas Registrasi <i class="fas fa-paper-plane ms-2"></i>
                    </button>
                    <div class="text-center mt-3">
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal" class="text-success text-decoration-none fw-bold small">Kembali ke Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Animations
        AOS.init({ duration: 800, once: true });

        // Password Visibility Toggle
        const passwordInput = document.getElementById('passwordInput');
        const eyeIcon = document.getElementById('eyeIcon');
        if(eyeIcon) {
            eyeIcon.addEventListener('click', function() {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                this.classList.toggle('fa-eye', !isPassword);
                this.classList.toggle('fa-eye-slash', isPassword);
            });
        }

        // SweetAlert Handler
        <?php if (session()->getFlashdata('success')): ?>
            Swal.fire({ 
                icon: 'success', 
                title: 'Berhasil', 
                text: '<?= session()->getFlashdata('success') ?>', 
                showConfirmButton: false, 
                timer: 2000,
                customClass: { popup: 'rounded-4' }
            });
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            Swal.fire({ 
                icon: 'error', 
                title: 'Akses Ditolak', 
                text: '<?= session()->getFlashdata('error') ?>', 
                confirmButtonColor: '#10b981',
                customClass: { popup: 'rounded-4', confirmButton: 'rounded-3 px-4' }
            }).then(() => {
                var myModal = new bootstrap.Modal(document.getElementById('loginModal'));
                myModal.show();
            });
        <?php endif; ?>
    });
</script>
<script>
    window.addEventListener('load', function() {
        const mapContainer = document.getElementById('mapLanding');
        if (!mapContainer) return;

        // 1. Inisialisasi Peta Dasar
        var mapLanding;
        try {
            mapLanding = L.map('mapLanding', { 
                scrollWheelZoom: false,
                fadeAnimation: true
            }).setView([1.3622, 109.3117], 14);
        } catch (e) {
            console.error("Gagal inisialisasi Leaflet: ", e);
            return;
        }

        // 2. Load Tile Layer
        var streetLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        }).addTo(mapLanding);

        var satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            maxZoom: 19,
            attribution: 'Esri Satellite'
        });

        var baseMaps = {
            "<span style='font-size: 12px; font-weight: 600; color: #1e293b;'>Peta Vektor</span>": streetLayer,
            "<span style='font-size: 12px; font-weight: 600; color: #1e293b;'>Satelit Bumi</span>": satelliteLayer
        };
        L.control.layers(baseMaps, null, { position: 'topright' }).addTo(mapLanding);

        // 3. Rendering Markers (Konfigurasi Sesuai Kolom Database 'foto' & Format JSON)
        <?php if (!empty($kegiatan_map) && is_array($kegiatan_map)) : ?>
            <?php foreach ($kegiatan_map as $index => $km) : ?>
                <?php if (!empty($km['latitude']) && !empty($km['longitude'])) : ?>
                    try {
                        let imgTag_<?= $index ?> = '';
                        
                        <?php 
                        // Ambil data dari kolom 'foto' sesuai screenshot database
                        $foto_raw = $km['foto'] ?? ''; 
                        $nama_file = '';

                        if (!empty($foto_raw)) {
                            // Coba decode karena format di DB adalah JSON array: ["nama_file.png"]
                            $foto_array = json_decode($foto_raw, true);
                            if (is_array($foto_array) && !empty($foto_array)) {
                                $nama_file = $foto_array[0]; // Ambil file pertama
                            } else {
                                // Fallback jika sewaktu-waktu tipenya string biasa bukan JSON
                                $nama_file = str_replace(['[', ']', '"'], '', $foto_raw);
                            }
                        }

                        // Lakukan bypass pengecekan file_exists agar rendering client lebih aman
                        if (!empty($nama_file)) :
                        ?>
                            let imgUrl_<?= $index ?> = "<?= base_url('uploads/kegiatan/' . $nama_file) ?>";
                            
                            // Handler onerror disiapkan jika file tidak ada di folder fisik lokal
                            imgTag_<?= $index ?> = `<img src="${imgUrl_<?= $index ?>}" 
                                                        style="width: 100%; height: 100%; object-fit: cover;" 
                                                        onerror="this.onerror=null; this.parentElement.innerHTML='<div style=\'display:flex;align-items:center;justify-content:center;height:100%;color:#94a3b8;font-size:11px;\'><i class=\'fas fa-image me-1\'></i> Dokumentasi Kosong</div>';">`;
                        <?php else : ?>
                            imgTag_<?= $index ?> = `<div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #94a3b8; font-size: 11px;">
                                            <i class="fas fa-image me-1"></i> Dokumentasi Kosong
                                          </div>`;
                        <?php endif; ?>

                        let marker_<?= $index ?> = L.marker([<?= floatval($km['latitude']) ?>, <?= floatval($km['longitude']) ?>]).addTo(mapLanding);
                        
                        marker_<?= $index ?>.bindPopup(`
                            <div style="width: 250px; font-family: 'Plus Jakarta Sans', sans-serif; padding: 2px;">
                                <div style="width: 100%; height: 125px; overflow: hidden; border-radius: 12px; margin-bottom: 12px; background: #f1f5f9; position: relative;">
                                    ${imgTag_<?= $index ?>}
                                    <span style="position: absolute; top: 8px; left: 8px; background:#10b981; color:white; padding:4px 10px; border-radius:6px; font-size:9px; font-weight:700; text-transform: uppercase; z-index:10;">
                                        <?= esc($km['status'] ?? 'Proses') ?>
                                    </span>
                                </div>
                                <div>
                                    <h6 style="color:#064e3b; font-weight: 700; margin-bottom: 4px; font-size: 14px; line-height: 1.4;">
                                        <?= esc($km['judul_kegiatan'] ?? 'Tanpa Judul') ?>
                                    </h6>
                                    <div style="font-size: 11px; color: #64748b; margin-bottom: 8px;">
                                        <i class="far fa-calendar-alt me-1"></i> <?= date('d M Y', strtotime($km['updated_at'] ?? $km['tanggal'] ?? date('Y-m-d'))) ?>
                                    </div>
                                    <div style="background: #f8fafc; padding: 10px; border-radius: 8px; border: 1px solid #edf2f7; font-size: 11px;">
                                        <p style="margin-bottom: 4px; color: #475569;">
                                            <i class="fas fa-map-marker-alt text-danger me-1"></i> <?= esc($km['lokasi'] ?? '-') ?>
                                        </p>
                                        <p style="margin-bottom: 0; font-weight: 700; color:#10b981; font-size: 13px;">
                                            Rp <?= number_format((float)($km['anggaran'] ?? 0), 0, ',', '.') ?>
                                        </p>
                                    </div>
                                    <a href="<?= base_url('home/detail/' . ($km['kegiatan_id'] ?? $km['id'] ?? 0)) ?>" class="btn btn-sm w-100 mt-2 text-white" style="background: #10b981; font-size: 11px; font-weight: 700; border-radius: 8px; padding: 6px;">
                                        Detail Program <i class="fas fa-chevron-right ms-1" style="font-size: 9px;"></i>
                                    </a>
                                </div>
                            </div>
                        `);
                    } catch (err) {
                        console.error("Gagal merender marker: ", err);
                    }
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>

        setTimeout(() => { mapLanding.invalidateSize(); }, 400);
    });
</script>
</body>
</html>