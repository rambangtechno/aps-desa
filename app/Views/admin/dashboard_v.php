<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<div class="row mb-4">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-0 shadow-sm" style="border-radius: 15px; border-left: 5px solid #10b981;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Kegiatan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_kegiatan ?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-calendar fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-0 shadow-sm" style="border-radius: 15px; border-left: 5px solid #f6c23e;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Menunggu ACC</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_pending ?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-clock fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-0 shadow-sm" style="border-radius: 15px; border-left: 5px solid #e74a3b;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Verifikasi User</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $user_pending ?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-user-check fa-2x text-gray-300"></i></div>
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
                <div class="d-flex align-items-center">
                    <select id="filterStatus" class="form-select form-select-sm border-success text-success fw-bold me-3" style="border-radius: 10px; width: 180px; cursor:pointer;">
                        <option value="all">Semua Kegiatan</option>
                        <option value="Disetujui">✅ Disetujui</option>
                        <option value="Pending">⏳ Belum Disetujui</option>
                    </select>
                    <span class="badge bg-success-light text-success px-3 py-2 rounded-pill small">
                        <i class="fas fa-circle fa-xs me-1 pulse"></i> Live GIS
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div id="mapDashboard" style="height: 500px; border-radius: 15px; z-index: 1;"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var map = L.map('mapDashboard').setView([1.1856, 108.9745], 14); 

        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Definisi Icon Berdasarkan Status
        var greenIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34], shadowSize: [41, 41]
        });

        var orangeIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-orange.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34], shadowSize: [41, 41]
        });

        var allMarkers = [];

        <?php foreach($kegiatan_map as $k) : ?>
            <?php if(!empty($k['latitude']) && !empty($k['longitude']) && is_numeric($k['latitude'])) : ?>
                
                var lat = parseFloat("<?= $k['latitude'] ?>");
                var lng = parseFloat("<?= $k['longitude'] ?>");
                var status = "<?= $k['status'] ?>"; // "Disetujui" atau "Pending"
                
                // Pilih Icon
                var currentIcon = (status === "Disetujui") ? greenIcon : orangeIcon;
                
                var marker = L.marker([lat, lng], {icon: currentIcon});
                
                // Simpan data status di dalam objek marker untuk difilter nanti
                marker.statusData = status;

                // Tooltip
                marker.bindTooltip("<?= addslashes($k['judul_kegiatan']) ?>", {
                    permanent: true, direction: 'top', offset: [0, -35], className: 'label-kegiatan'
                }).openTooltip();

                // Popup
                var fotoJson = '<?= $k['foto'] ?>';
                var fotoArray = [];
                try { fotoArray = JSON.parse(fotoJson); } catch(e) { fotoArray = [fotoJson]; }
                var imgPath = fotoArray[0] ? '<?= base_url('uploads/kegiatan/') ?>' + '/' + fotoArray[0] : '';

                marker.bindPopup(`
                    <div style="min-width: 180px; font-family: sans-serif;">
                        ${imgPath ? `<img src="${imgPath}" style="width:100%; height:100px; object-fit:cover; border-radius:8px; margin-bottom:8px;">` : ''}
                        <h6 style="font-weight:bold; color:${status === 'Disetujui' ? '#10b981' : '#f6c23e'}; margin-bottom:4px;"><?= addslashes($k['judul_kegiatan']) ?></h6>
                        <small style="color:#666;">Status: <b>${status}</b></small><br>
                        <small style="color:#666;"><i class="fas fa-map-marker-alt"></i> <?= addslashes($k['lokasi']) ?></small>
                        <hr style="margin:8px 0;">
                        <small>Anggaran: <b>Rp <?= number_format((float)$k['anggaran'], 0, ',', '.') ?></b></small>
                    </div>
                `);

                marker.addTo(map);
                allMarkers.push(marker);

            <?php endif; ?>
        <?php endforeach; ?>

        // LOGIKA FILTER
        var filterSelect = document.getElementById('filterStatus');
        filterSelect.addEventListener('change', function() {
            var val = this.value;
            var visibleMarkers = [];

            allMarkers.forEach(function(m) {
                if (val === 'all' || m.statusData === val) {
                    map.addLayer(m);
                    visibleMarkers.push(m.getLatLng());
                } else {
                    map.removeLayer(m);
                }
            });

            // Fokuskan ulang peta ke marker yang tersisa
            if (visibleMarkers.length > 0) {
                var bounds = new L.LatLngBounds(visibleMarkers);
                map.fitBounds(bounds, {padding: [50, 50]});
            }
        });

        // Zoom otomatis awal
        if (allMarkers.length > 0) {
            var group = new L.featureGroup(allMarkers);
            map.fitBounds(group.getBounds().pad(0.1));
        }
    });
</script>

<style>
    .bg-success-light { background-color: #ecfdf5; }
    .pulse { animation: pulse-animation 2s infinite; }
    @keyframes pulse-animation { 0% { opacity: 1; } 50% { opacity: 0.3; } 100% { opacity: 1; } }
    .leaflet-container { z-index: 1 !important; }

    /* Style Label sesuai Status */
    .label-kegiatan {
        background-color: #10b981 !important; /* Default hijau */
        border: none !important;
        border-radius: 6px !important;
        color: white !important;
        font-weight: bold !important;
        padding: 3px 8px !important;
        font-size: 10px !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .leaflet-tooltip-top:before { border-top-color: #10b981 !important; }
</style>

<?= $this->endSection() ?>