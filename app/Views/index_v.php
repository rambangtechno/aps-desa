<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APELDESA | Aplikasi Pengelolaan Kegiatan Desa Segarau Parit</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --digi-green: #10b981; /* Emerald Green */
            --digi-dark: #064e3b; /* Dark Green */
            --digi-light: #ecfdf5; /* Very Light Green */
            --text-gray: #64748b;
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            color: #1e293b;
            background-color: #ffffff;
            overflow-x: hidden;
        }

        /* Navbar Style */
        .navbar {
            padding: 18px 0;
            transition: all 0.5s;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(16, 185, 129, 0.1);
        }
        .navbar-brand { font-size: 26px; font-weight: 800; color: var(--digi-dark) !important; letter-spacing: -1px; }
        .navbar-brand span { color: var(--digi-green); }
        .nav-link { color: var(--digi-dark); font-weight: 600; padding: 10px 15px !important; transition: 0.3s; }
        .nav-link:hover { color: var(--digi-green); }

        /* Hero Section */
        .hero {
            width: 100%;
            min-height: 100vh;
            background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%);
            display: flex;
            align-items: center;
            padding-top: 100px;
            position: relative;
        }
        /* Efek dekorasi background */
        .hero::before {
            content: ''; position: absolute; top: 10%; right: 5%; width: 300px; height: 300px;
            background: var(--digi-green); opacity: 0.05; filter: blur(80px); border-radius: 50%;
        }

        .hero h1 { color: var(--digi-dark); font-size: 52px; font-weight: 800; line-height: 1.2; letter-spacing: -2px; }
        .hero h1 span { color: var(--digi-green); }
        .hero h2 { color: var(--text-gray); margin: 20px 0 40px 0; font-size: 20px; font-weight: 400; line-height: 1.6; }

        .btn-get-started {
            background: var(--digi-green);
            padding: 14px 38px;
            border-radius: 16px;
            color: #fff;
            font-weight: 700;
            transition: 0.4s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.4);
        }
        .btn-get-started:hover { background: var(--digi-dark); color: #fff; transform: translateY(-3px); box-shadow: 0 20px 30px -10px rgba(16, 185, 129, 0.3); }

        /* Count Section */
        .counts { padding: 80px 0; background: #fff; }
        .count-box {
            display: flex;
            align-items: center;
            padding: 35px;
            background: var(--digi-light);
            border-radius: 24px;
            height: 100%;
            transition: 0.3s;
            border: 1px solid rgba(16, 185, 129, 0.1);
        }
        .count-box:hover { transform: translateY(-5px); background: #fff; box-shadow: 0 15px 30px rgba(0,0,0,0.05); }

        /* Layanan Section */
        .feature-box {
            padding: 50px 35px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.03);
            transition: 0.4s;
            height: 100%;
            text-align: center;
            border-radius: 24px;
            background: #fff;
            border: 1px solid #f1f5f9;
        }
        .feature-box:hover { transform: translateY(-12px); border-color: var(--digi-green); box-shadow: 0 20px 50px rgba(16, 185, 129, 0.1); }
        .feature-box i { font-size: 54px; color: var(--digi-green); margin-bottom: 25px; display: block; }
        .feature-box h3 { font-weight: 800; color: var(--digi-dark); font-size: 22px; }

        /* Kades Slider Section */
        .kades-section { padding: 100px 0; background: #f8fafc; }
        .kades-card-modern {
            background: #fff;
            border-radius: 35px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.04);
            border: 1px solid #f1f5f9;
        }
        .badge-status {
            background: var(--digi-green); font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 1px;
        }
        .vimi-box { border-left: 4px solid var(--digi-green); background: #f0fdf4; border-radius: 16px; }
        .vimi-title { color: var(--digi-green); font-weight: 800; }

        /* Login Modal Emerald */
        .modal-modern .modal-content { border-radius: 28px; padding: 15px; }
        .modal-modern .form-control { background-color: #f8fafc; border: 1.5px solid #e2e8f0; padding: 14px; border-radius: 14px; }
        .modal-modern .form-control:focus { border-color: var(--digi-green); box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1); background-color: #fff; }
        .btn-login-modern { background: var(--digi-green); padding: 14px; border-radius: 14px; box-shadow: 0 8px 20px rgba(16, 185, 129, 0.2); }
        .btn-login-modern:hover { background: var(--digi-dark); }

        /* Swiper Green */
        .custom-swiper-nav { color: var(--digi-green) !important; width: 50px !important; height: 50px !important; }
        .custom-swiper-nav:hover { background: var(--digi-green); color: #fff !important; }
        .swiper-pagination-bullet-active { background: var(--digi-green) !important; }

        footer { background: #064e3b; color: #ecfdf5; padding: 80px 0 30px; }
        footer .navbar-brand, footer .navbar-brand span { color: #fff !important; }
        footer h4 { color: #fff; font-weight: 700; margin-bottom: 25px; }
        .footer-links a { color: #a7f3d0; transition: 0.3s; }
        .footer-links a:hover { color: #fff; padding-left: 8px; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top shadow-none">
    <div class="container">
        <a class="navbar-brand" href="#">APEL<span>DESA</span></a>
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link" href="#hero">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="#layanan">Layanan</a></li>
                <li class="nav-item"><a class="nav-link" href="#profil-kades">Kepala Desa</a></li>
                <li class="nav-item ms-lg-4">
                    <a href="#" class="btn-get-started py-2 px-4 shadow-none fs-6" data-bs-toggle="modal" data-bs-target="#loginModal"> <i class="fas fa-user-circle me-2"></i> Login Dashboard</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
/* Reset style bawaan FlexStart agar tidak bentrok */
.hero {
    width: 100%;
    min-height: 100vh;
    padding-top: 100px;
    display: flex;
    align-items: center;
    position: relative;
    /* Menghapus background linear-gradient asli */
    background: none !important; 
}

/* Mengatur Kolom Teks agar berada di tengah secara vertikal */
.hero .col-lg-6.d-flex {
    justify-content: center;
    min-height: calc(100vh - 100px); /* Menyesuaikan tinggi navbar */
}

/* Modifikasi agar Teks di Kiri terlihat jelas */
.hero h1 { 
    color: var(--digi-dark); 
    font-size: 52px; 
    font-weight: 800; 
    line-height: 1.2; 
    letter-spacing: -2px;
}
.hero h1 span { 
    color: var(--digi-green); 
}
.hero h2 { 
    color: #1e293b; /* Warna abu gelap agar teks jelas */
    margin: 20px 0 40px 0; 
    font-size: 20px; 
    font-weight: 400; 
    line-height: 1.6;
}

/* Styling Bagian Kanan (Menjadi Background Image yang Menyatu) */
.hero-bg-merge {
    position: absolute;
    top: 0;
    right: 0;
    width: 50%; /* Mengambil setengah layar kanan */
    height: 100%;
    /* 1. MENGGUNAKAN GAMBAR ALANDA (Pastikan URL ini Direct Link) */
    background-image: url('https://i.ibb.co.com/LhhLfgX1/faisal.jpg');
    background-size: cover;
    
    /* --- PERUBAHAN DI SINI UNTUK MENGGESER KE KIRI --- */
    /* background-position: horizontal vertical; */
    /* Kita geser horizontal ke kiri (misal: -150px) */
    background-position: -350px center;
    /* --------------------------------------------------- */
    
    background-repeat: no-repeat;
    z-index: 1; /* Di bawah teks kiri */
}
/* --- UPDATE FINAL: BUANG EFEK PUTIH DARI GAMBAR --- */
.hero-bg-merge::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    
    /* Putihnya kita paksa berhenti di 0% (titik paling awal kiri) */
    background: linear-gradient(
        to right, 
        rgba(255, 255, 255, 1) 0%,   /* Putih hanya di garis start */
        rgba(255, 255, 255, 0) 5%,   /* Di titik 5% sudah hilang total */
        rgba(16, 185, 129, 0.02) 100% /* Sisanya murni gambar (hanya 2% tint hijau) */
    );
    z-index: 2; 
}
.hero h1 {
    color: var(--digi-dark);
    /* Memberikan 'sinar' putih di belakang teks agar kontras dengan gambar */
    text-shadow: 0 0 20px rgba(255, 255, 255, 1), 
                 0 0 10px rgba(255, 255, 255, 0.8);
}

.hero h2 {
    color: #000;
    font-weight: 600;
    /* Membuat deskripsi tetap terbaca jelas */
    text-shadow: 0 0 10px rgba(255, 255, 255, 1);
}
/* ----------------------------------------------------- */

/* 2. FILTER HIJAU EMERALD AGAR MENYATU (Gradient Overlay) */
.hero-bg-merge::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    /* Gradient transparan hijau di sisi kiri gambar agar menyatu dengan teks */
    background: linear-gradient(to right, rgba(255, 255, 255, 1) 0%, rgba(16, 185, 129, 0.3) 100%);
    z-index: 2; /* Di atas gambar, di bawah teks */
}

/* Penyesuaian Responsif untuk Mobile */
@media (max-width: 991px) {
    .hero {
        padding-top: 80px;
    }
    .hero-bg-merge {
        width: 100%; /* Gambar full background di HP */
        opacity: 0.2; /* Dibuat sangat transparan di HP agar teks terbaca */
        
        /* Reset posisi di HP agar gambar tidak terpotong aneh */
        background-position: center center;
    }
    .hero-bg-merge::before {
        background: linear-gradient(to bottom, rgba(255, 255, 255, 1) 0%, rgba(16, 185, 129, 0.4) 100%);
    }
    .hero .col-lg-6.d-flex {
        position: relative;
        z-index: 10; /* Teks di atas background transparan */
        min-height: auto;
        padding: 50px 20px;
    }
}
</style>

<section id="hero" class="hero">
    
    <div class="hero-bg-merge" data-aos="fade" data-aos-delay="200"></div>

    <div class="container" style="position: relative; z-index: 5;">
        <div class="row align-items-center">
            
            <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up">
                <h1 class="fw-800">
                    Wujudkan <span>Tata Kelola Desa</span> Digital Segarau Parit
                </h1>
                <h2 class="fw-400">
                    Sistem cerdas untuk akselerasi administrasi, transparansi kegiatan, dan efisiensi pelayanan publik Desa Segarau Parit, Kecamatan Tebas.
                </h2>
                <div>
                    <a href="#layanan" class="btn-get-started shadow">
                        <span>Mulai Sekarang</span>
                        <i class="fas fa-rocket ms-2"></i>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-6 hero-img d-none d-lg-block">
                </div>
            
        </div>
    </div>
</section>

<section class="counts">
    <div class="container" data-aos="fade-up">
        <div class="row gy-4">
            <div class="col-lg-3 col-md-6">
                <div class="count-box">
                    <i class="fas fa-users me-4" style="color: #10b981; font-size: 38px;"></i>
                    <div><span class="fw-bold fs-3">2,350</span><p class="mb-0 text-muted small fw-600">Total Penduduk</p></div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="count-box">
                    <i class="fas fa-check-circle me-4" style="color: #059669; font-size: 38px;"></i>
                    <div><span class="fw-bold fs-3">158</span><p class="mb-0 text-muted small fw-600">Kegiatan Desa</p></div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="count-box">
                    <i class="fas fa-shield-alt me-4" style="color: #10b981; font-size: 38px;"></i>
                    <div><span class="fw-bold fs-3">42</span><p class="mb-0 text-muted small fw-600">Layanan Aktif</p></div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="count-box">
                    <i class="fas fa-star me-4" style="color: #047857; font-size: 38px;"></i>
                    <div><span class="fw-bold fs-3">12</span><p class="mb-0 text-muted small fw-600">Penghargaan</p></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="layanan" class="py-5">
    <div class="container py-5" data-aos="fade-up">
        <header class="text-center mb-5 pb-3">
            <span class="badge px-3 py-2 rounded-pill mb-3" style="background: var(--digi-light); color: var(--digi-green); font-weight: 700;">FITUR UNGGULAN</span>
            <h2 class="fw-bold" style="color: var(--digi-dark); font-size: 36px; letter-spacing: -1px;">Solusi Desa Digital</h2>
            <p class="text-muted mx-auto" style="max-width: 600px;">Transformasi layanan konvensional menjadi digital yang lebih cepat dan akuntabel.</p>
        </header>
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="feature-box" data-aos="fade-up" data-aos-delay="100">
                    <i class="fas fa-laptop-code"></i>
                    <h3>Manajemen Kegiatan</h3>
                    <p class="text-muted small lh-lg">Pengelolaan data kegiatan pembangunan dan sosial desa secara terpusat dan sistematis.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="feature-box" data-aos="fade-up" data-aos-delay="200">
                    <i class="fas fa-file-signature"></i>
                    <h3>Otorisasi Kades</h3>
                    <p class="text-muted small lh-lg">Proses persetujuan (ACC) kegiatan oleh Kepala Desa secara digital untuk efisiensi birokrasi.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="feature-box" data-aos="fade-up" data-aos-delay="300">
                    <i class="fas fa-print"></i>
                    <h3>Laporan Otomatis</h3>
                    <p class="text-muted small lh-lg">Cetak laporan resmi kegiatan desa dengan format standar pemerintahan dalam satu klik.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="profil-kades" class="kades-section">
    <div class="container" data-aos="fade-up">
        <div class="text-center mb-5 pb-3">
            <h2 class="fw-bold display-6" style="color: var(--digi-dark); letter-spacing: -2px;">Profil Pemimpin Desa</h2>
            <p class="text-muted">Visi dan Misi Kepala Desa Segarau Parit dalam membangun desa digital.</p>
        </div>

        <div class="swiper swiper-kades">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="kades-card-modern">
                        <div class="kades-content-wrapper">
                            <div class="kades-img-side">
                                <span class="badge badge-status">AKTIF MENJABAT</span>
                                <img src="https://cdn.digitaldesa.com/statics/landing/homepage/media/testimoni/kades-tompo.webp" alt="Kades">
                            </div>
                            <div class="kades-info-side">
                                <span class="periode">Masa Jabatan: 2022 - 2028</span>
                                <h3 class="fw-bold mb-1" style="color: var(--digi-dark); font-size: 32px;">H. Ahmad Syukri</h3>
                                <p class="text-muted small mb-4 fw-bold">KEPALA DESA SEGARAU PARIT</p>
                                
                                <div class="vimi-box p-4">
                                    <span class="vimi-title mb-2 d-block"><i class="fas fa-quote-left me-2"></i> VISI PEMBANGUNAN</span>
                                    <p class="mb-3 italic lh-lg">"Mewujudkan desa digital yang mandiri, transparan, dan unggul dalam pelayanan publik melalui inovasi teknologi informasi demi kesejahteraan masyarakat Segarau Parit."</p>
                                    
                                    <span class="vimi-title mb-2 d-block"><i class="fas fa-bullseye me-2"></i> MISI UTAMA</span>
                                    <ul class="mb-0 ps-3 small text-muted lh-lg">
                                        <li>Digitalisasi tata kelola administrasi pemerintahan desa.</li>
                                        <li>Mendorong transparansi anggaran dan kegiatan pembangunan.</li>
                                        <li>Meningkatkan kualitas SDM perangkat desa yang melek teknologi.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-button-next custom-swiper-nav"></div>
            <div class="swiper-button-prev custom-swiper-nav"></div>
            <div class="swiper-pagination mt-5"></div>
        </div>
    </div>
</section>

<footer>
    <div class="container">
        <div class="row gy-4 text-center text-md-start">
            <div class="col-lg-5 col-md-12">
                <a href="#" class="navbar-brand">APEL<span>DESA</span></a>
                <p class="mt-3 text-white-50 small" style="max-width: 400px;">Platform digital resmi untuk pengelolaan kegiatan dan transparansi pelayanan publik Pemerintah Desa Segarau Parit, Kecamatan Tebas, Kabupaten Sambas.</p>
            </div>
            <div class="col-lg-3 col-6 footer-links ms-auto">
                <h4 class="mb-4">Navigasi</h4>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#hero" class="text-decoration-none">Beranda</a></li>
                    <li class="mb-2"><a href="#layanan" class="text-decoration-none">Fitur Layanan</a></li>
                    <li class="mb-2"><a href="#profil-kades" class="text-decoration-none">Kepala Desa</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-6 footer-links">
                <h4 class="mb-4">Hubungi Kami</h4>
                <p class="small text-white-50 lh-lg">
                    <i class="fas fa-map-marker-alt me-2 text-white"></i> Jl. Raya Segarau Parit, Kec. Tebas<br>
                    Kabupaten Sambas, Kalimantan Barat<br>
                    <i class="fas fa-envelope me-2 text-white mt-3"></i> segarauparit@desa.go.id
                </p>
            </div>
        </div>
        <hr class="mt-5 border-white opacity-10">
        <div class="text-center pt-3">
            <p class="mb-0 small text-white-50">&copy; 2026 <strong>Pemerintah Desa Segarau Parit</strong>. By Alanda Randa</p>
        </div>
    </div>
</footer>

<div class="modal fade modal-modern" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" style="max-width: 420px;">
        <div class="modal-content shadow-lg border-0" style="border-radius: 28px;">
            <div class="modal-header border-0 pt-4 px-4 pb-0 d-block">
                <button type="button" class="btn-close float-end shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                <h3 class="modal-title fw-800 mt-3" style="color: var(--digi-dark);">Login <span>Sistem</span></h3>
                <p class="text-muted small">Masuk ke Dashboard APELDESA Segarau Parit.</p>
            </div>
            
            <div class="modal-body px-4 pb-4">
                <form action="<?= base_url('auth/loginProcess') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Username</label>
                        <input type="text" name="username" class="form-control shadow-none" placeholder="Masukan username" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted">Password</label>
                        <div class="password-wrapper" style="position: relative;">
                            <input type="password" id="passwordInput" name="password" class="form-control shadow-none" placeholder="••••••••" required>
                            <i class="fas fa-eye toggle-password" id="eyeIcon" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #94a3b8;"></i>
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-login-modern text-white fw-bold">
                            Masuk Sekarang <i class="fas fa-sign-in-alt ms-2"></i>
                        </button>
                    </div>
                    <div class="text-center mt-3">
                        <p class="mb-0 small text-muted">Belum memiliki akun?</p>
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#registerModal" data-bs-dismiss="modal" class="text-success text-decoration-none fw-bold small">Daftar Akun Perangkat</a>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 bg-light py-3 justify-content-center" style="border-radius: 0 0 28px 28px;">
                <p class="mb-0 small text-muted text-center">Lupa akses? Hubungi Admin IT Desa.</p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-modern" id="registerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 450px;">
        <div class="modal-content shadow-lg border-0" style="border-radius: 28px;">
            <div class="modal-header border-0 pt-4 px-4 pb-0 d-block">
                <button type="button" class="btn-close float-end shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                <h3 class="modal-title fw-800 mt-3" style="color: var(--digi-dark);">Daftar <span>Akun</span></h3>
                <p class="text-muted small">Ajukan akses akun perangkat Desa Segarau Parit.</p>
            </div>
            
            <div class="modal-body px-4 pb-4">
                <form action="<?= base_url('auth/registerProcess') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control shadow-none" placeholder="Nama Lengkap sesuai SK" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Username</label>
                            <input type="text" name="username" class="form-control shadow-none" placeholder="username" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Jabatan</label>
                            <select name="role" class="form-select shadow-none" required>
                                <option value="perangkat_desa">Perangkat Desa</option>
                                <option value="kepala_desa">Kepala Desa</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted">Password</label>
                        <input type="password" name="password" class="form-control shadow-none" placeholder="Buat password kuat" required>
                    </div>
                    
                    <div class="alert alert-success border-0 small mb-4" style="background: var(--digi-light); color: var(--digi-dark); border-radius: 12px;">
                        <i class="fas fa-info-circle me-2"></i> Akun akan aktif setelah diverifikasi oleh Admin IT Desa.
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-login-modern text-white fw-bold">
                            Ajukan Pendaftaran <i class="fas fa-paper-plane ms-2"></i>
                        </button>
                    </div>
                    <div class="text-center mt-3">
                        <p class="mb-0 small text-muted">Sudah memiliki akun?</p>
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal" class="text-success text-decoration-none fw-bold small">Kembali ke Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize AOS
        AOS.init({ duration: 1000, once: true });

        // Swiper Kades
        const swiperKades = new Swiper('.swiper-kades', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: { delay: 6000, disableOnInteraction: false },
            pagination: { el: '.swiper-pagination', clickable: true },
            navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
        });

        // Password Toggle Logic
        const passwordInput = document.getElementById('passwordInput');
        const eyeIcon = document.getElementById('eyeIcon');
        if(eyeIcon) {
            eyeIcon.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        }

        // SweetAlert Flashdata
        <?php if (session()->getFlashdata('success')): ?>
            Swal.fire({ 
                icon: 'success', 
                title: 'Berhasil!', 
                text: '<?= session()->getFlashdata('success') ?>', 
                showConfirmButton: false, 
                timer: 2000,
                customClass: { popup: 'rounded-4' }
            });
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            Swal.fire({ 
                icon: 'error', 
                title: 'Opps!', 
                text: '<?= session()->getFlashdata('error') ?>', 
                confirmButtonColor: '#10b981',
                customClass: { popup: 'rounded-4', confirmButton: 'rounded-pill px-4' }
            }).then(() => {
                var myModal = new bootstrap.Modal(document.getElementById('loginModal'));
                myModal.show();
            });
        <?php endif; ?>
    });
</script>
</body>
</html>