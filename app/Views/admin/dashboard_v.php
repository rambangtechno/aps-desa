<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<div class="row mb-4">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2 border-0 shadow-sm" style="border-radius: 15px; border-left: 5px solid #10b981 !important;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Kegiatan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_kegiatan ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2 border-0 shadow-sm" style="border-radius: 15px; border-left: 5px solid #f6c23e !important;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Menunggu ACC</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_pending ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2 border-0 shadow-sm" style="border-radius: 15px; border-left: 5px solid #e74a3b !important;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Verifikasi User</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $user_pending ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card shadow-sm border-0 mb-4" style="border-radius: 20px;">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center" style="border-radius: 20px 20px 0 0;">
                <h6 class="m-0 font-weight-bold text-success">
                    <i class="fas fa-map-marked-alt me-2"></i> Sebaran Lokasi Kegiatan Desa Segarau Parit
                </h6>
                <div class="dropdown no-arrow">
                    <span class="badge bg-success-light text-success px-3 py-2 rounded-pill small">
                        <i class="fas fa-circle fa-xs me-1 pulse"></i> Live Monitoring
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div id="mapDashboard" style="height: 450px; border-radius: 15px; z-index: 1;"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Inisialisasi Peta (Koordinat default Segarau Parit)
        var map = L.map('mapDashboard').setView([1.1856, 108.9745], 14); 

        // 2. Layer Peta Modern (CartoDB Positron)
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // 3. Custom Marker Icon Hijau
        var greenIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        // 4. Looping Data Kegiatan dari Database
        // 4. Looping Data Kegiatan dari Database
        <?php foreach($kegiatan_map as $k) : ?>
            <?php if(!empty($k['latitude']) && !empty($k['longitude'])) : ?>
                
                var lat = parseFloat("<?= $k['latitude'] ?>");
                var lng = parseFloat("<?= $k['longitude'] ?>");
                
                // Buat marker
                var marker = L.marker([lat, lng], {icon: greenIcon}).addTo(map);

                // Tambahkan Label Nama Kegiatan yang muncul otomatis (Permanent Tooltip)
                marker.bindTooltip("<?= addslashes($k['judul_kegiatan']) ?>", {
                    permanent: true, 
                    direction: 'top',
                    offset: [0, -40],
                    className: 'label-kegiatan'
                }).openTooltip();

                // Tetap tambahkan PopUp untuk detail saat diklik
                marker.bindPopup(`
                    <div style="min-width: 150px;">
                        <h6 class="fw-bold text-success mb-1"><?= addslashes($k['judul_kegiatan']) ?></h6>
                        <p class="small text-muted mb-0">Lokasi: <?= addslashes($k['lokasi']) ?></p>
                        <small>Anggaran: Rp <?= number_format($k['anggaran'], 0, ',', '.') ?></small>
                    </div>
                `);

            <?php endif; ?>
        <?php endforeach; ?>
    });
</script>

<style>
    /* Styling tambahan agar dashboard lebih cantik */
    .bg-success-light { background-color: #ecfdf5; }
    .pulse {
        animation: pulse-animation 2s infinite;
    }
    @keyframes pulse-animation {
        0% { opacity: 1; }
        50% { opacity: 0.3; }
        100% { opacity: 1; }
    }
    /* Memastikan peta tidak menutupi menu navigasi */
    .leaflet-container { z-index: 1 !important; }


    <style>
    /* Style untuk label nama kegiatan di peta */
    .label-kegiatan {
        background-color: rgba(16, 185, 129, 0.9); /* Hijau emerald */
        border: none;
        border-radius: 5px;
        color: white;
        font-weight: bold;
        padding: 2px 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        font-size: 11px;
    }

    /* Panah kecil di bawah label */
    .leaflet-tooltip-top:before {
        border-top-color: rgba(16, 185, 129, 0.9);
    }
</style>
</style>

<?= $this->endSection() ?>