<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Resmi Desa Digital | Transformasi Desa Modern</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --digi-blue: #0061f2;
            --digi-dark: #012970;
            --digi-light: #f6f9ff;
        }

        body { 
            font-family: 'Inter', sans-serif; 
            color: #444444;
            background-color: #ffffff;
            overflow-x: hidden;
        }

        /* Navbar Style */
        .navbar {
            padding: 15px 0;
            transition: all 0.5s;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
        .navbar-brand { font-size: 24px; font-weight: 700; color: var(--digi-dark) !important; }
        .navbar-brand span { color: var(--digi-blue); }
        .nav-link { color: var(--digi-dark); font-weight: 600; padding: 10px 15px !important; }

        /* Hero Section */
        .hero {
            width: 100%;
            min-height: 90vh;
            background: url('https://bootstrapmade.com/demo/templates/FlexStart/assets/img/hero-bg.png') center center no-repeat;
            background-size: cover;
            display: flex;
            align-items: center;
            padding-top: 80px;
        }
        .hero h1 { color: var(--digi-dark); font-size: 48px; font-weight: 700; line-height: 56px; }
        .hero h2 { color: #444444; margin: 15px 0 30px 0; font-size: 24px; }

        .btn-get-started {
            background: var(--digi-blue);
            padding: 12px 35px;
            border-radius: 50px;
            color: #fff;
            font-weight: 600;
            transition: 0.5s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0, 97, 242, 0.3);
        }
        .btn-get-started:hover { background: #004dc2; color: #fff; transform: translateY(-2px); }

        /* Count Section */
        .counts { padding: 60px 0; background: var(--digi-light); }
        .count-box {
            display: flex;
            align-items: center;
            padding: 30px;
            background: #fff;
            box-shadow: 0px 0 30px rgba(1, 41, 112, 0.08);
            border-radius: 15px;
            height: 100%;
        }

        /* Layanan Section */
        .feature-box {
            padding: 40px 30px;
            box-shadow: 0px 0 30px rgba(1, 41, 112, 0.08);
            transition: 0.3s;
            height: 100%;
            text-align: center;
            border-radius: 15px;
            background: #fff;
            border-bottom: 3px solid transparent;
        }
        .feature-box:hover { transform: translateY(-10px); border-color: var(--digi-blue); }
        .feature-box i { font-size: 48px; color: var(--digi-blue); margin-bottom: 20px; display: block; }

        /* Kades Slider Section */
        .kades-section { padding: 80px 0; background: #fff; }
        .kades-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0px 10px 30px rgba(1, 41, 112, 0.08);
            margin: 15px;
            text-align: center;
            border: 1px solid #eee;
        }
        .kades-img-wrapper { height: 320px; position: relative; overflow: hidden; }
        .kades-img-wrapper img { width: 100%; height: 100%; object-fit: cover; }
        .badge-status {
            position: absolute; top: 15px; right: 15px;
            background: var(--digi-blue); color: white;
            padding: 5px 15px; border-radius: 50px; font-size: 12px; z-index: 2;
        }
        .kades-info { padding: 25px; }
        .kades-info h4 { color: var(--digi-dark); font-weight: 700; }
        .periode { color: var(--digi-blue); font-weight: 600; font-size: 14px; margin-bottom: 10px; display: block; }

        footer { 
            background: #ffffff;
            color: #444444;
            padding: 60px 0 30px; 
            border-top: 1px solid #eeeeee;
        }
        footer .navbar-brand { color: var(--digi-dark) !important; }
        footer h4 { color: var(--digi-dark); font-size: 18px;}
        .footer-links a { color: #666666; text-decoration: none; transition: 0.3s; }
        .footer-links a:hover { color: var(--digi-blue); padding-left: 5px; }

        /* Login Modal - Professional Minimalist */
.modal-modern .modal-content {
    border: none;
    border-radius: 16px; /* Tidak terlalu bulat agar tegas */
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    background: #ffffff;
}

.modal-modern .modal-header {
    padding: 30px 40px 10px;
    border: none;
    background: #fff;
    display: block; /* Menghilangkan display flex default bootstrap */
}

.modal-modern .modal-title {
    color: var(--digi-dark);
    font-weight: 800;
    letter-spacing: -0.5px;
}

.modal-modern .form-label {
    font-size: 13px;
    font-weight: 600;
    color: #64748b;
    margin-bottom: 8px;
}

.modal-modern .form-control {
    background-color: #f1f5f9;
    border: 1px solid #e2e8f0;
    padding: 12px 16px;
    border-radius: 10px;
    color: #1e293b;
    font-size: 15px;
    transition: all 0.2s ease;
}

.modal-modern .form-control:focus {
    background-color: #fff;
    border-color: var(--digi-blue);
    box-shadow: 0 0 0 4px rgba(0, 97, 242, 0.1);
}

.password-wrapper { position: relative; }

.toggle-password {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #94a3b8;
    transition: 0.2s;
}

.btn-login-modern {
    background: var(--digi-blue);
    color: #fff;
    border: none;
    padding: 14px;
    border-radius: 10px;
    font-weight: 700;
    font-size: 15px;
    margin-top: 10px;
    transition: all 0.3s;
}

.btn-login-modern:hover {
    background: #004dc2;
    transform: translateY(-1px);
    box-shadow: 0 8px 15px rgba(0, 97, 242, 0.2);
}

/* Navigasi Custom Swiper */
.custom-swiper-nav {
    color: var(--digi-blue) !important;
    background: #fff;
    width: 40px !important;
    height: 40px !important;
    border-radius: 50%;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    transition: 0.3s;
}

.custom-swiper-nav:after {
    font-size: 16px !important;
    font-weight: bold;
}

.custom-swiper-nav:hover {
    background: var(--digi-blue);
    color: #fff !important;
}

/* Memposisikan panah agar sedikit ke luar layar laptop */
.swiper-button-next { right: 0 !important; }
.swiper-button-prev { left: 0 !important; }

/* Menghilangkan panah di HP agar tidak mengganggu tampilan */
@media (max-width: 768px) {
    .custom-swiper-nav { display: none !important; }
    .swiper-kades { padding: 0 !important; }
}
/* Profil Kades Modern with Vision Mission */
.swiper-kades {
    padding-bottom: 50px !important;
}

.kades-card-modern {
    background: #fff;
    border-radius: 30px;
    overflow: hidden;
    border: 1px solid rgba(0,0,0,0.05);
    box-shadow: 0 15px 35px rgba(0,0,0,0.05);
    transition: all 0.4s ease;
    height: 100%;
}

.kades-content-wrapper {
    display: flex;
    flex-direction: row;
    align-items: stretch;
}

.kades-img-side {
    width: 40%;
    min-height: 400px;
    position: relative;
}

.kades-img-side img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.kades-info-side {
    width: 60%;
    padding: 40px;
    text-align: left;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.vimi-box {
    margin-top: 20px;
    padding: 20px;
    background: var(--digi-light);
    border-radius: 20px;
    font-size: 0.9rem;
}

.vimi-title {
    color: var(--digi-blue);
    font-weight: 700;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 1px;
    margin-bottom: 5px;
    display: block;
}

/* Responsif Mobile */
@media (max-width: 991px) {
    .kades-content-wrapper { flex-direction: column; }
    .kades-img-side, .kades-info-side { width: 100%; }
    .kades-img-side { height: 300px; min-height: 300px; }
    .kades-info-side { padding: 25px; }
}
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="#">DESA<span>DIGITAL</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link" href="#hero">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="#layanan">Layanan</a></li>
                <li class="nav-item"><a class="nav-link" href="#profil-kades">Kepala Desa</a></li>
                <li class="nav-item ms-lg-3">
                    <a href="#" class="btn-get-started py-2" data-bs-toggle="modal" data-bs-target="#loginModal"> Login Dashboard</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<section id="hero" class="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up">
                <h1>Wujudkan Tata Kelola Desa Berbasis Digital</h1>
                <h2>Solusi cerdas untuk mempercepat pelayanan administrasi dan transparansi kegiatan desa Anda.</h2>
                <div>
                    <a href="#layanan" class="btn-get-started">
                        <span>Mulai Sekarang</span>
                        <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 hero-img text-center" data-aos="zoom-out" data-aos-delay="200">
                <img src="https://bootstrapmade.com/demo/templates/FlexStart/assets/img/hero-img.png" class="img-fluid p-4" alt="">
            </div>
        </div>
    </div>
</section>

<section class="counts">
    <div class="container" data-aos="fade-up">
        <div class="row gy-4">
            <div class="col-lg-3 col-md-6">
                <div class="count-box">
                    <i class="fas fa-users me-3" style="color: #4154f1; font-size: 32px;"></i>
                    <div><span class="fw-bold fs-4">2,350</span><p class="mb-0 small">Penduduk</p></div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="count-box">
                    <i class="fas fa-tasks me-3" style="color: #ee6c20; font-size: 32px;"></i>
                    <div><span class="fw-bold fs-4">158</span><p class="mb-0 small">Kegiatan</p></div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="count-box">
                    <i class="fas fa-file-invoice me-3" style="color: #15be56; font-size: 32px;"></i>
                    <div><span class="fw-bold fs-4">42</span><p class="mb-0 small">Layanan Online</p></div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="count-box">
                    <i class="fas fa-award me-3" style="color: #bb0852; font-size: 32px;"></i>
                    <div><span class="fw-bold fs-4">12</span><p class="mb-0 small">Penghargaan</p></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="layanan" class="py-5">
    <div class="container py-5" data-aos="fade-up">
        <header class="text-center mb-5">
            <h2 class="fw-bold" style="color: var(--digi-dark);">Layanan Unggulan</h2>
            <p>Mudahkan urusan warga dengan teknologi informasi terintegrasi</p>
        </header>
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="feature-box" data-aos="fade-up" data-aos-delay="100">
                    <i class="fas fa-file-signature"></i>
                    <h3>Administrasi Online</h3>
                    <p>Pengajuan surat keterangan dan dokumen kependudukan secara mandiri dari rumah.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="feature-box" data-aos="fade-up" data-aos-delay="200">
                    <i class="fas fa-bullhorn"></i>
                    <h3>Informasi Kegiatan</h3>
                    <p>Update real-time mengenai agenda pembangunan dan kegiatan sosial kemasyarakatan.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="feature-box" data-aos="fade-up" data-aos-delay="300">
                    <i class="fas fa-hand-holding-usd"></i>
                    <h3>Transparansi Dana</h3>
                    <p>Pantau realisasi anggaran pendapatan dan belanja desa secara terbuka dan akuntabel.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="profil-kades" class="kades-section py-5">
    <div class="container position-relative" data-aos="fade-up">
        <div class="text-center mb-5">
            <span class="badge text-primary px-3 py-2 rounded-pill mb-3" style="background: var(--digi-light);">HISTORY & VISION</span>
            <h2 class="fw-bold display-6" style="color: var(--digi-dark);">Pemimpin Desa</h2>
            <p class="text-muted">Dedikasi dan visi besar para pemimpin desa dari masa ke masa.</p>
        </div>

        <div class="swiper swiper-kades">
            <div class="swiper-wrapper">
                
                <div class="swiper-slide">
                    <div class="kades-card-modern">
                        <div class="kades-content-wrapper">
                            <div class="kades-img-side">
                                <span class="badge-status">Sedang Menjabat</span>
                                <img src="https://cdn.digitaldesa.com/statics/landing/homepage/media/testimoni/kades-tompo.webp" alt="Kades">
                            </div>
                            <div class="kades-info-side">
                                <span class="periode text-primary fw-bold mb-2">2022 - 2028</span>
                                <h3 class="fw-bold mb-1" style="color: var(--digi-dark);">H. Ahmad Syukri</h3>
                                <p class="text-muted small mb-4">Kepala Desa Aktif</p>
                                
                                <div class="vimi-box">
                                    <span class="vimi-title"><i class="fas fa-eye me-2"></i> Visi</span>
                                    <p class="mb-3">"Mewujudkan desa digital yang mandiri, transparan, dan unggul dalam pelayanan publik melalui inovasi teknologi."</p>
                                    
                                    <span class="vimi-title"><i class="fas fa-bullseye me-2"></i> Misi Utama</span>
                                    <ul class="mb-0 ps-3">
                                        <li>Digitalisasi sistem administrasi desa.</li>
                                        <li>Peningkatan kapasitas SDM perangkat desa.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="kades-card-modern">
                        <div class="kades-content-wrapper">
                            <div class="kades-img-side">
                                <img src="https://cdn.digitaldesa.com/statics/landing/homepage/media/testimoni/kades-corawali.webp" alt="Kades">
                            </div>
                            <div class="kades-info-side">
                                <span class="periode text-primary fw-bold mb-2">2016 - 2022</span>
                                <h3 class="fw-bold mb-1" style="color: var(--digi-dark);">Drs. M. Yusuf</h3>
                                <p class="text-muted small mb-4">Mantan Kepala Desa</p>
                                
                                <div class="vimi-box">
                                    <span class="vimi-title"><i class="fas fa-eye me-2"></i> Visi</span>
                                    <p class="mb-0">"Pemerataan infrastruktur jalan desa dan irigasi persawahan untuk ketahanan pangan lokal."</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="kades-card-modern">
                        <div class="kades-content-wrapper">
                            <div class="kades-img-side">
                                <img src="https://cdn.digitaldesa.com/statics/landing/homepage/media/testimoni/kades-banua-baru-ilir.webp" alt="Kades">
                            </div>
                            <div class="kades-info-side">
                                <span class="periode text-primary fw-bold mb-2">2010 - 2016</span>
                                <h3 class="fw-bold mb-1" style="color: var(--digi-dark);">H.Andriyan</h3>
                                <p class="text-muted small mb-4">Mantan Kepala Desa</p>
                                
                                <div class="vimi-box">
                                    <span class="vimi-title"><i class="fas fa-eye me-2"></i> Visi</span>
                                    <p class="mb-0">"Pemberdayaan kaum perempuan dan peningkatan kualitas kesehatan ibu dan anak di tingkat desa."</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                </div>

            <div class="swiper-button-next custom-swiper-nav"></div>
            <div class="swiper-button-prev custom-swiper-nav"></div>
            <div class="swiper-pagination mt-4"></div>
        </div>
    </div>
</section>

<footer>
    <div class="container">
        <div class="row gy-4 text-center text-md-start">
            <div class="col-lg-5 col-md-12">
                <a href="#" class="navbar-brand">DESA<span>DIGITAL</span></a>
                <p class="mt-3 text-muted">Solusi teknologi informasi terpadu untuk percepatan pembangunan dan pelayanan masyarakat di tingkat desa.</p>
            </div>
            <div class="col-lg-3 col-6 footer-links ms-auto">
                <h4 class="fw-bold mb-3 text-dark">Tautan Cepat</h4>
                <ul class="list-unstyled">
                    <li><i class="fas fa-chevron-right me-2 small text-primary"></i><a href="#hero">Beranda</a></li>
                    <li><i class="fas fa-chevron-right me-2 small text-primary"></i><a href="#layanan">Layanan</a></li>
                    <li><i class="fas fa-chevron-right me-2 small text-primary"></i><a href="#profil-kades">Kepala Desa</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-6 footer-links">
                <h4 class="fw-bold mb-3 text-dark">Kontak</h4>
                <p class="small text-muted">
                    <i class="fas fa-map-marker-alt me-2 text-primary"></i> Jl. Raya Sambas No. 123<br>
                    Kabupaten Sambas, Kal-Bar
                </p>
            </div>
        </div>
        <hr class="mt-5">
        <div class="text-center pt-3">
            <p class="mb-0 small text-muted">&copy; 2026 <strong>Pemerintah Desa Digital</strong>. By Alanda Randa</p>
        </div>
    </div>
</footer>

<div class="modal fade modal-modern" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
                <h3 class="modal-title mt-3">Autentikasi Sistem</h3>
                <p class="text-muted small">Silakan masuk untuk mengelola dashboard administrasi desa.</p>
            </div>
            
            <div class="modal-body px-4 pb-5">
                <form action="<?= base_url('auth/loginProcess') ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="username" required>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <div class="password-wrapper">
                            <input type="password" id="passwordInput" name="password" class="form-control" placeholder="••••••••" required>
                            <i class="fas fa-eye toggle-password" id="eyeIcon"></i>
                        </div>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-login-modern">
                            Masuk
                        </button>
                    </div>
                    <div class="text-center mt-3">
                        <p class="mb-0 small text-muted">Belum memiliki akun?</p>
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#registerModal" data-bs-dismiss="modal" class="text-primary text-decoration-none fw-bold small">Buat Akun Terlebih Dahulu</a>
                    </div>
                </form>
            </div>
            
            <div class="modal-footer border-0 bg-light py-3 justify-content-center">
                <p class="mb-0 small text-muted">Lupa akses? <a href="#" class="text-primary text-decoration-none fw-600">Hubungi Admin Desa!</a></p>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal-modern" id="registerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
                <h3 class="modal-title mt-3">Pendaftaran Akun</h3>
                <p class="text-muted small">Data Anda akan diverifikasi oleh Admin sebelum dapat digunakan.</p>
            </div>
            <div class="modal-body px-4 pb-5">
                <form action="<?= base_url('auth/registerProcess') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama Lengkap" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="username" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Jabatan</label>
                        <select name="role" class="form-control" required>
                            <option value="perangkat_desa">Perangkat Desa</option>
                            <option value="kepala_desa">Kepala Desa</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-login-modern">Ajukan Pendaftaran</button>
                    </div>
                    <div class="alert alert-warning py-2 shadow-none border-0 mb-3" style="border-radius: 8px; background-color: #fff8e1;">
                        <p class="mb-0 small text-dark" style="font-size: 0.75rem;">
                            <i class="fas fa-info-circle me-1"></i> 
                            Setelah mendaftar, akun Anda tidak langsung aktif. Admin akan melakukan verifikasi terlebih dahulu.
                        </p>
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
    // Alert untuk sukses registrasi (Menunggu Verifikasi)
    <?php if (session()->getFlashdata('success_register')) : ?>
        Swal.fire({
            title: 'Pendaftaran Berhasil!',
            text: '<?= session()->getFlashdata('success_register') ?>',
            icon: 'info', // Menggunakan ikon info agar terkesan instruksi
            confirmButtonColor: '#0061f2',
            confirmButtonText: 'Siap, Saya Mengerti',
            allowOutsideClick: false // Agar user benar-benar membaca
        });
    <?php endif; ?>

    // Alert untuk error (Sudah ada di kode kamu sebelumnya biasanya)
    <?php if (session()->getFlashdata('error')) : ?>
        Swal.fire({
            title: 'Gagal!',
            text: '<?= session()->getFlashdata('error') ?>',
            icon: 'error',
            confirmButtonColor: '#e74a3b'
        });
    <?php endif; ?>
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize AOS
        AOS.init({ duration: 1000, once: true });

        // Single Swiper Initialization
        const swiperKades = new Swiper('.swiper-kades', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: { delay: 5000, disableOnInteraction: false },
            pagination: { el: '.swiper-pagination', clickable: true },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            }
        });

        // Password Toggle
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

        // SweetAlert
        <?php if (session()->getFlashdata('success')): ?>
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: '<?= session()->getFlashdata('success') ?>', showConfirmButton: false, timer: 2000 });
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            Swal.fire({ icon: 'error', title: 'Akses Ditolak!', text: '<?= session()->getFlashdata('error') ?>', confirmButtonColor: '#0061f2' }).then(() => {
                var myModal = new bootstrap.Modal(document.getElementById('loginModal'));
                myModal.show();
            });
        <?php endif; ?>
    });
</script>
</body>
</html>