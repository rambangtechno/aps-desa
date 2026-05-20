<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kegiatan | APELDESA</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        :root {
            --digi-green: #10b981; 
            --digi-green-rgb: 16, 185, 129;
            --digi-dark: #064e3b; 
            --text-dark: #0f172a;
            --text-gray: #475569;
            --border-light: #e2e8f0;
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            color: var(--text-dark);
            background-color: #f8fafc;
            padding-top: 120px;
        }

        /* --- NAVBAR --- */
        .navbar {
            padding: 20px 0;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(var(--digi-green-rgb), 0.08);
        }
        .navbar-brand { font-size: 24px; font-weight: 800; color: var(--digi-dark) !important; letter-spacing: -0.5px; }
        .navbar-brand span { color: var(--digi-green); }

        /* --- CARDS --- */
        .card-custom {
            background: #ffffff;
            border: 1px solid var(--border-light);
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
            padding: 30px;
            margin-bottom: 30px;
        }

        .program-title {
            font-size: 2rem;
            font-weight: 800;
            color: var(--digi-dark);
            letter-spacing: -1px;
            line-height: 1.3;
        }

        /* --- MULTI-PHOTO SLIDER --- */
        .swiper-container-detail {
            width: 100%;
            height: 420px;
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 25px;
            border: 1px solid var(--border-light);
            position: relative;
        }
        .swiper-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .swiper-button-next, .swiper-button-prev {
            color: #ffffff !important;
            background: rgba(0, 0, 0, 0.3);
            width: 44px; height: 44px;
            border-radius: 50%;
            backdrop-filter: blur(4px);
        }
        .swiper-button-next::after, .swiper-button-prev::after { font-size: 18px !important; font-weight: 800; }
        .swiper-pagination-bullet-active { background: var(--digi-green) !important; }

        .info-badge {
            background: #f0fdf4;
            color: var(--digi-green);
            padding: 6px 16px;
            border-radius: 100px;
            font-weight: 700;
            font-size: 0.85rem;
            display: inline-block;
        }

        .status-badge {
            padding: 6px 16px;
            border-radius: 100px;
            font-weight: 700;
            font-size: 0.85rem;
            display: inline-block;
            text-transform: uppercase;
        }

        .status-proses { background: #fef3c7; color: #d97706; }
        .status-selesai { background: #d1fae5; color: #059669; }
        .status-rencana { background: #e0f2fe; color: #0284c7; }

        /* --- MAP DESIGN --- */
        #mapDetail {
            height: 350px !important;
            width: 100% !important;
            border-radius: 20px;
            border: 1px solid var(--border-light);
            background: #f1f5f9;
            z-index: 1;
        }

        .meta-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px dashed var(--border-light);
        }
        .meta-item:last-child { border-bottom: none; }
        .meta-icon {
            width: 40px; height: 40px;
            background: #f0fdf4;
            color: var(--digi-green);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem; margin-right: 15px;
        }

        .btn-back {
            background: #ffffff;
            border: 1px solid var(--border-light);
            padding: 12px 24px;
            border-radius: 12px;
            color: var(--text-gray);
            font-weight: 600;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }
        .btn-back:hover {
            background: #f1f5f9;
            color: var(--text-dark);
            transform: translateX(-3px);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url() ?>">APEL<span>DESA</span></a>
    </div>
</nav>

<div class="container py-4">
    <div class="mb-4">
        <a href="<?= base_url() ?>#peta-sebaran" class="btn-back">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Peta Utama
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card-custom">
                <?php
                // Decode data JSON foto dari database (Bisa menampung banyak foto sekaligus)
                $foto_raw = $kegiatan['foto'] ?? '';
                $list_foto = [];
                
                if (!empty($foto_raw)) {
                    $foto_array = json_decode($foto_raw, true);
                    if (is_array($foto_array) && !empty($foto_array)) {
                        $list_foto = $foto_array;
                    } else {
                        // Jika bukan JSON valid, bersihkan string murni bersangkutan
                        $clean_str = str_replace(['[', ']', '"'], '', $foto_raw);
                        if (!empty($clean_str)) {
                            $list_foto[] = $clean_str;
                        }
                    }
                }
                ?>

                <div class="swiper swiper-container-detail">
                    <div class="swiper-wrapper">
                        <?php if (!empty($list_foto)) : ?>
                            <?php foreach ($list_foto as $ft) : ?>
                                <?php if (file_exists(FCPATH . 'uploads/kegiatan/' . $ft)) : ?>
                                    <div class="swiper-slide">
                                        <img src="<?= base_url('uploads/kegiatan/' . $ft) ?>" alt="Dokumentasi Kegiatan">
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="d-flex flex-column align-items-center justify-content-center h-100 text-muted" style="background: #f1f5f9; width: 100%;">
                                <i class="fas fa-image fa-3x mb-2" style="color: #cbd5e1;"></i>
                                <span class="small fw-semibold text-secondary">Dokumentasi Belum Tersedia</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if (count($list_foto) > 1) : ?>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination"></div>
                    <?php endif; ?>
                </div>

                <div class="d-flex flex-wrap gap-2 mb-3 align-items-center">
                    <span class="info-badge">Infrastruktur & Pembangunan</span>
                    <?php 
                    $status = strtolower($kegiatan['status'] ?? 'proses');
                    $status_class = 'status-proses';
                    if ($status == 'selesai') $status_class = 'status-selesai';
                    if ($status == 'rencana') $status_class = 'status-rencana';
                    ?>
                    <span class="status-badge <?= $status_class ?>"><?= esc($kegiatan['status'] ?? 'Proses') ?></span>
                </div>

                <h1 class="program-title mb-4"><?= esc($kegiatan['judul_kegiatan'] ?? 'Tanpa Judul Program') ?></h1>
                
                <h5 class="fw-bold text-dark mb-3">Deskripsi / Rincian Program</h5>
                <div class="text-secondary lh-lg" style="font-size: 0.95rem;">
                    <?= !empty($kegiatan['deskripsi']) ? nl2br(esc($kegiatan['deskripsi'])) : 'Belum ada rincian deskripsi tambahan mengenai pelaksanaan program pembangunan fisik ini.' ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card-custom">
                <h5 class="fw-bold mb-4" style="color: var(--digi-dark);">Informasi Umum</h5>
                
                <div class="meta-item">
                    <div class="meta-icon"><i class="fas fa-wallet"></i></div>
                    <div>
                        <div class="text-muted small fw-medium">Total Anggaran</div>
                        <div class="fw-bold text-success fs-5">Rp <?= number_format((float)($kegiatan['anggaran'] ?? 0), 0, ',', '.') ?></div>
                    </div>
                </div>

                <div class="meta-item">
                    <div class="meta-icon"><i class="fas fa-map-marked-alt"></i></div>
                    <div>
                        <div class="text-muted small fw-medium">Lokasi Pelaksanaan</div>
                        <div class="fw-bold text-dark small"><?= esc($kegiatan['lokasi'] ?? '-') ?></div>
                    </div>
                </div>

                <div class="meta-item">
                    <div class="meta-icon"><i class="far fa-calendar-alt"></i></div>
                    <div>
                        <div class="text-muted small fw-medium">Tanggal Pembaruan</div>
                        <div class="fw-bold text-dark"><?= date('d M Y', strtotime($kegiatan['updated_at'] ?? $kegiatan['tanggal'] ?? date('Y-m-d'))) ?></div>
                    </div>
                </div>
            </div>

            <div class="card-custom">
                <h5 class="fw-bold mb-3" style="color: var(--digi-dark);">Titik Koordinat GIS</h5>
                <p class="text-muted small mb-3">Peta spasial penunjuk lokasi fisik realisasi program pembangunan di lapangan.</p>
                
                <div id="mapDetail" class="mb-3"></div>

                <div class="row g-2 text-center text-muted small mb-3">
                    <div class="col-6 bg-light p-2 rounded">
                        <span class="d-block text-uppercase fw-bold text-secondary mb-1" style="font-size: 10px; letter-spacing: 0.5px;">Latitude</span>
                        <span class="fw-bold text-dark"><?= esc($kegiatan['latitude'] ?? '0') ?></span>
                    </div>
                    <div class="col-6 bg-light p-2 rounded">
                        <span class="d-block text-uppercase fw-bold text-secondary mb-1" style="font-size: 10px; letter-spacing: 0.5px;">Longitude</span>
                        <span class="fw-bold text-dark"><?= esc($kegiatan['longitude'] ?? '0') ?></span>
                    </div>
                </div>

                <?php if (!empty($kegiatan['latitude']) && !empty($kegiatan['longitude'])): ?>
                    <a href="https://www.google.com/maps/dir/?api=1&destination=<?= $kegiatan['latitude'] ?>,<?= $kegiatan['longitude'] ?>" 
                       target="_blank" 
                       class="btn btn-outline-success w-100 fw-bold rounded-3 py-2" 
                       style="font-size: 0.85rem;">
                        <i class="text-danger fas fa-map-marker-alt me-2"></i> Petunjuk Arah (Google Maps)
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<footer class="bg-white border-top py-4 mt-5 text-center">
    <p class="mb-0 small text-muted">&copy; 2026 <strong>Pemerintah Desa Segarau Parit</strong>. All Rights Reserved.</p>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Inisialisasi Swiper Multi Foto Slider (Hanya berjalan jika ada foto)
        const swiper = new Swiper('.swiper-container-detail', {
            slidesPerView: 1,
            spaceBetween: 10,
            loop: true,
            pagination: { el: '.swiper-pagination', clickable: true },
            navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
        });

        // 2. Inisialisasi Nilai Koordinat Peta GIS
        const lat = <?= !empty($kegiatan['latitude']) ? floatval($kegiatan['latitude']) : 1.3622 ?>;
        const lng = <?= !empty($kegiatan['longitude']) ? floatval($kegiatan['longitude']) : 109.3117 ?>;

        var mapDetail;
        try {
            mapDetail = L.map('mapDetail', {
                scrollWheelZoom: false,
                zoomControl: true
            }).setView([lat, lng], 15);

            // Tipe Peta 1: OpenStreetMap Standard (Vektor)
            var streetLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap'
            }).addTo(mapDetail); // Default Layer Utama

            // Tipe Peta 2: Esri World Imagery (Citra Satelit Bumi)
            var satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                attribution: 'Tiles &copy; Esri &mdash; Satellite'
            });

            // Tipe Peta 3: OpenTopoMap (Kontur / Terrain Ketinggian)
            var terrainLayer = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
                attribution: 'Map data &copy; OpenTopoMap'
            });

            // Struktur Objek Pilihan Mode Basemaps
            var baseMaps = {
                "<span style='font-size: 11px; font-weight: 600; color:#1e293b;'>Peta Jalan</span>": streetLayer,
                "<span style='font-size: 11px; font-weight: 600; color:#1e293b;'>Citra Satelit</span>": satelliteLayer,
                "<span style='font-size: 11px; font-weight: 600; color:#1e293b;'>Kontur/Terrain</span>": terrainLayer
            };

            // Menambahkan Control Layer Interaktif ke Sudut Kanan Atas Peta
            L.control.layers(baseMaps, null, { position: 'topright', collapsed: false }).addTo(mapDetail);

            // Tautan Dinamis Google Maps Navigasi untuk Tautan di dalam Popup Marker
            let gmapsUrl = `https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}`;

            // Menambahkan Marker Spasial
            var marker = L.marker([lat, lng]).addTo(mapDetail);
            
            marker.bindPopup(`
                <div style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; padding: 2px; width: 180px;">
                    <b style="color: #064e3b; display: block; margin-bottom: 2px;">Lokasi Kegiatan</b>
                    <span style="color: #475569; display: block; margin-bottom: 8px;"><?= esc($kegiatan['lokasi'] ?? 'Desa Segarau Parit') ?></span>
                    <a href="${gmapsUrl}" target="_blank" style="color: #10b981; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center;">
                        Navigasi Google Maps <i class="fas fa-external-link-alt ms-1" style="font-size: 9px;"></i>
                    </a>
                </div>
            `).openPopup();

        } catch (error) {
            console.error("Gagal memuat peta mini detail: ", error);
        }

        // Jalankan sinkronisasi invalidate ukuran setelah elemen layout Bootstrap stabil
        setTimeout(function() {
            if (mapDetail) {
                mapDetail.invalidateSize();
            }
        }, 400);
    });
</script>

</body>
</html>