<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Kepala Desa | Desa Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        .section-title { color: #012970; font-weight: 700; margin-bottom: 40px; position: relative; }
        .kades-card { border: none; border-radius: 20px; transition: 0.3s; overflow: hidden; background: #fff; }
        .kades-card:hover { transform: translateY(-10px); box-shadow: 0 15px 30px rgba(0,0,0,0.1); }
        .kades-img { height: 250px; object-fit: cover; width: 100%; border-bottom: 5px solid #0061f2; }
        .badge-aktif { background: #0061f2; color: white; border-radius: 50px; padding: 5px 15px; font-size: 12px; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top py-3">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= base_url('/') ?>" style="color: #012970;">DESA<span style="color: #0061f2;">DIGITAL</span></a>
        <a href="<?= base_url('/') ?>" class="btn btn-outline-primary rounded-pill btn-sm">Kembali ke Beranda</a>
    </div>
</nav>

<section class="py-5">
    <div class="container py-5">
        <div class="text-center" data-aos="fade-up">
            <h2 class="section-title">Pemimpin Desa dari Masa ke Masa</h2>
            <p class="text-muted mx-auto" style="max-width: 600px;">Apresiasi setinggi-tingginya kepada para pemimpin yang telah mendedikasikan diri untuk kemajuan desa kita.</p>
        </div>

        <div class="row g-4 mt-4">
            <?php foreach($kades as $k): ?>
            <div class="col-lg-4 col-md-6" data-aos="fade-up">
                <div class="card kades-card shadow-sm h-100">
                    <img src="<?= $k['foto'] ?>" class="kades-img" alt="<?= $k['nama'] ?>">
                    <div class="card-body text-center p-4">
                        <?php if($k['status'] == 'aktif'): ?>
                            <span class="badge-aktif mb-3 d-inline-block">Sedang Menjabat</span>
                        <?php endif; ?>
                        <h5 class="fw-bold mb-1" style="color: #012970;"><?= $k['nama'] ?></h5>
                        <p class="text-primary fw-600 small mb-0"><?= $k['periode'] ?></p>
                        <hr class="my-3 opacity-25">
                        <p class="text-muted small italic">"Dedikasi tanpa batas untuk kemakmuran warga desa."</p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<footer class="py-4 bg-white border-top text-center">
    <p class="mb-0 text-muted">&copy; 2026 Pemerintah Desa - Sambas</p>
</footer>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init();</script>
</body>
</html>