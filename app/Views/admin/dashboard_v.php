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
        // 1. Inisialisasi Layer Tampilan Map
        var osm = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; OpenStreetMap'
        });

        var satelit = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
        });

        var terrain = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data: &copy; OpenStreetMap contributors, SRTM | Map style: &copy; OpenTopoMap (CC-BY-SA)'
        });

        // 2. Inisialisasi Peta dengan layer default OSM
        var map = L.map('mapDashboard', {
            center: [1.1856, 108.9745],
            zoom: 14,
            layers: [osm] // Layer default saat dibuka
        });

        // 3. Fitur Ubah Tampilan Map (Control Layers)
        var baseMaps = {
            "Default (Modern)": osm,
            "Satelit": satelit,
            "Terrain (Kontur)": terrain
        };
        L.control.layers(baseMaps).addTo(map);

        // --- Kode Icon Tetap Sama ---
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
                var status = "<?= $k['status'] ?>";
                
                var currentIcon = (status === "Disetujui") ? greenIcon : orangeIcon;
                var marker = L.marker([lat, lng], {icon: currentIcon});
                marker.statusData = status;

                marker.bindTooltip("<?= addslashes($k['judul_kegiatan']) ?>", {
                    permanent: true, direction: 'top', offset: [0, -35], className: 'label-kegiatan'
                }).openTooltip();

                // --- Fitur Kunjungi: Link Google Maps ditambahkan di Popup ---
                var fotoJson = '<?= $k['foto'] ?>';
                var fotoArray = [];
                try { fotoArray = JSON.parse(fotoJson); } catch(e) { fotoArray = [fotoJson]; }
                var imgPath = fotoArray[0] ? '<?= base_url('uploads/kegiatan/') ?>' + '/' + fotoArray[0] : '';

                marker.bindPopup(`
                        <div style="min-width: 200px; font-family: 'Plus Jakarta Sans', sans-serif;">
                            ${imgPath ? `<img src="${imgPath}" style="width:100%; height:110px; object-fit:cover; border-radius:10px; margin-bottom:10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">` : ''}
                            
                            <h6 style="font-weight:800; color:${status === 'Disetujui' ? '#064e3b' : '#856404'}; margin-bottom:8px; font-size:14px; line-height:1.4;">
                                <?= addslashes($k['judul_kegiatan']) ?>
                            </h6>
                            
                            <div style="font-size:11px; color:#475569; line-height: 1.6;">
                                <div class="mb-1">
                                    <i class="fas fa-calendar-alt text-muted" style="width:18px;"></i> 
                                    <span><?= date('d M Y', strtotime($k['updated_at'] ?? $k['tanggal'])) ?></span>
                                </div>
                                <div class="mb-1">
                                    <i class="fas fa-wallet text-success" style="width:18px;"></i> 
                                    <b style="color:#10b981;">Rp <?= number_format((float)$k['anggaran'], 0, ',', '.') ?></b>
                                </div>
                                <div class="mb-1">
                                    <i class="fas fa-map-marker-alt text-danger" style="width:18px;"></i> 
                                    <span><?= addslashes($k['lokasi']) ?></span>
                                </div>
                                <div class="mt-1">
                                    <span style="background:${status === 'Disetujui' ? '#ecfdf5' : '#fffbeb'}; color:${status === 'Disetujui' ? '#10b981' : '#b45309'}; padding:2px 8px; border-radius:12px; font-weight:700; font-size:10px; border: 1px solid ${status === 'Disetujui' ? '#d1fae5' : '#fef3c7'}; text-transform:uppercase;">
                                        ${status}
                                    </span>
                                </div>
                            </div>

                            <hr style="margin:12px 0; border: 0; border-top: 1px solid #f1f5f9;">
                            
                            <a href="https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}" target="_blank" class="btn btn-sm btn-success text-white w-100" style="border-radius:8px; font-size:11px; font-weight:700; padding: 8px;">
                                <i class="fas fa-directions me-1"></i> PENUNJUK ARAH
                            </a>
                        </div>
                    `);

                marker.addTo(map);
                allMarkers.push(marker);

            <?php endif; ?>
        <?php endforeach; ?>

        // --- Logika Filter & Zoom Tetap Sama ---
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

            if (visibleMarkers.length > 0) {
                var bounds = new L.LatLngBounds(visibleMarkers);
                map.fitBounds(bounds, {padding: [50, 50]});
            }
        });

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