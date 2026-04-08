<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 20px;">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0 text-success"><i class="fas fa-map-marked-alt me-2"></i> Peta Sebaran Kegiatan Desa</h5>
            </div>
            <div class="card-body">
                <div id="map" style="height: 500px; border-radius: 15px;"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // 1. Inisialisasi Peta (Koordinat Tengah Desa Segarau Parit)
    // Silakan sesuaikan koordinat -1.17xxx, 108.98xxx dengan lokasi asli
    var map = L.map('map').setView([1.2345, 109.1234], 14); 

    // 2. Tambahkan Layer Peta (OpenStreetMap)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // 3. Looping Marker dari Database
    <?php foreach($kegiatan as $k) : ?>
        <?php if($k['latitude'] && $k['longitude']) : ?>
            L.marker([<?= $k['latitude'] ?>, <?= $k['longitude'] ?>])
                .addTo(map)
                .bindPopup("<b><?= $k['judul_kegiatan'] ?></b><br>Lokasi: <?= $k['lokasi'] ?><br>Anggaran: Rp <?= number_format($k['anggaran'], 0, ',', '.') ?>");
        <?php endif; ?>
    <?php endforeach; ?>
</script>
<?= $this->endSection() ?>