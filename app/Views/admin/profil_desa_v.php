<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<form action="<?= base_url('admin/update_profil') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= $desa['id'] ?>">
    <input type="hidden" name="logo_lama" value="<?= $desa['logo'] ?>">

    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0"><i class="fas fa-landmark text-success me-2"></i>Informasi Desa Segarau Parit</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nama Desa</label>
                            <input type="text" name="nama_desa" class="form-control rounded-pill" value="<?= $desa['nama_desa'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Telepon/WA Desa</label>
                            <input type="text" name="telepon" class="form-control rounded-pill" value="<?= $desa['telepon'] ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Email Resmi Desa</label>
                        <input type="email" name="email" class="form-control rounded-pill" value="<?= $desa['email'] ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Alamat Kantor Desa</label>
                        <textarea name="alamat" class="form-control" rows="2" style="border-radius: 15px;"><?= $desa['alamat'] ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Sejarah Singkat Desa</label>
                        <textarea name="sejarah" class="form-control" rows="4" style="border-radius: 15px;"><?= $desa['sejarah'] ?></textarea>
                    </div>

                    <hr>
                    <h6 class="fw-bold"><i class="fas fa-map-marked-alt text-danger me-2"></i>Lokasi Kantor Desa (Klik/Geser di Peta)</h6>
                    <div id="mapProfil" style="height: 350px; border-radius: 15px; z-index: 1;" class="mb-3 border"></div>

                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light border-0">Lat</span>
                                <input type="text" name="latitude" id="lat" class="form-control border-0 bg-light" value="<?= $desa['latitude'] ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light border-0">Long</span>
                                <input type="text" name="longitude" id="lng" class="form-control border-0 bg-light" value="<?= $desa['longitude'] ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center p-4 mb-3" style="border-radius: 15px;">
                <label class="fw-bold mb-3">Logo Instansi Desa</label>
                <div class="mb-3">
                    <?php 
                        $logoPath = ($desa['logo'] && file_exists('uploads/profil/'.$desa['logo'])) 
                                    ? base_url('uploads/profil/'.$desa['logo']) 
                                    : base_url('assets/img/logo_placeholder.png');
                    ?>
                    <img src="<?= $logoPath ?>" id="previewLogo" class="img-fluid p-2 border" style="max-height: 200px; border-radius: 10px; object-fit: contain;">
                </div>
                
                <div class="mb-3">
                    <input type="file" name="logo" id="inputLogo" class="d-none" accept="image/*">
                    <button type="button" class="btn btn-outline-success btn-sm rounded-pill px-4" onclick="document.getElementById('inputLogo').click()">
                        <i class="fas fa-camera me-2"></i>Ganti Logo
                    </button>
                    <div class="small text-muted mt-2" style="font-size: 10px;">Format: JPG, PNG (Maks 2MB)</div>
                </div>
            </div>

            <button type="submit" class="btn btn-success w-100 py-3 rounded-pill shadow-sm fw-bold">
                <i class="fas fa-save me-2"></i> SIMPAN PROFIL
            </button>
        </div>
    </div>
</form>

<script>
    // 1. Logika Peta
    var lat = <?= !empty($desa['latitude']) ? $desa['latitude'] : '1.3622' ?>;
    var lng = <?= !empty($desa['longitude']) ? $desa['longitude'] : '109.3117' ?>;

    var map = L.map('mapProfil').setView([lat, lng], 14);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    var marker = L.marker([lat, lng], {draggable: true}).addTo(map);

    marker.on('dragend', function(e) {
        var pos = marker.getLatLng();
        document.getElementById('lat').value = pos.lat.toFixed(7);
        document.getElementById('lng').value = pos.lng.toFixed(7);
    });

    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        document.getElementById('lat').value = e.latlng.lat.toFixed(7);
        document.getElementById('lng').value = e.latlng.lng.toFixed(7);
    });

    // 2. Logika Preview Gambar
    document.getElementById('inputLogo').onchange = evt => {
        const [file] = document.getElementById('inputLogo').files
        if (file) {
            document.getElementById('previewLogo').src = URL.createObjectURL(file)
        }
    }
</script>
<script>
    // Gunakan fungsi ini agar peta dirender setelah halaman benar-benar siap
    window.onload = function() {
        var lat = <?= !empty($desa['latitude']) ? $desa['latitude'] : '1.3622' ?>;
        var lng = <?= !empty($desa['longitude']) ? $desa['longitude'] : '109.3117' ?>;

        // Inisialisasi Map
        var map = L.map('mapProfil').setView([lat, lng], 14);

        // Tambahkan Tile Layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Tambahkan Marker
        var marker = L.marker([lat, lng], {draggable: true}).addTo(map);

        // Logika geser marker
        marker.on('dragend', function(e) {
            var pos = marker.getLatLng();
            document.getElementById('lat').value = pos.lat.toFixed(7);
            document.getElementById('lng').value = pos.lng.toFixed(7);
        });

        // Logika klik peta
        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            document.getElementById('lat').value = e.latlng.lat.toFixed(7);
            document.getElementById('lng').value = e.latlng.lng.toFixed(7);
        });

        // Paksa peta untuk menyesuaikan ukuran container
        setTimeout(function(){ 
            map.invalidateSize(); 
        }, 500);
    };
</script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<?= $this->endSection() ?>