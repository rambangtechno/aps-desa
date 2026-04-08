<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-0 text-primary">
                            <i class="fas fa-file-signature me-2"></i> Otorisasi Kegiatan Desa
                        </h5>
                        <p class="text-muted small mb-0">Daftar pengajuan yang memerlukan persetujuan Kepala Desa</p>
                    </div>
                    <span class="badge bg-warning text-dark rounded-pill px-3 shadow-sm">
                        <i class="fas fa-clock me-1"></i> <?= count($kegiatan) ?> Menunggu
                    </span>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small text-uppercase">
                            <tr>
                                <th class="px-4 py-3">Detail Kegiatan</th>
                                <th>Anggaran (Rp)</th>
                                <th>Lokasi</th>
                                <th class="text-center">Aksi Validasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($kegiatan)) : ?>
                                <?php foreach ($kegiatan as $k) : ?>
                                <tr>
                                    <td class="px-4">
                                        <div class="d-flex align-items-center">
                                            <?php 
                                                $fotonya = json_decode($k['foto'], true); 
                                                $fotoUtama = (is_array($fotonya) && !empty($fotonya)) ? $fotonya[0] : $k['foto'];
                                            ?>
                                            <div class="position-relative" style="cursor: pointer;" 
                                                onclick="previewLengkap('<?= htmlspecialchars($k['judul_kegiatan'], ENT_QUOTES) ?>', '<?= htmlspecialchars(str_replace(["\r", "\n"], ' ', $k['deskripsi']), ENT_QUOTES) ?>', '<?= htmlspecialchars($k['foto'], ENT_QUOTES) ?>', '<?= $k['tanggal'] ?>', '<?= htmlspecialchars($k['lokasi'], ENT_QUOTES) ?>', '<?= number_format((float)$k['anggaran'], 0, ',', '.') ?>', '<?= $k['latitude'] ?>', '<?= $k['longitude'] ?>')">
                                                
                                                <img src="<?= base_url('uploads/kegiatan/' . ($fotoUtama ?: 'default.jpg')) ?>" 
                                                    class="rounded shadow-sm border" width="55" height="55" style="object-fit: cover;">
                                                    
                                                <div class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 20px; height: 20px; font-size: 10px;">
                                                    <i class="fas fa-search-plus"></i>
                                                </div>
                                            </div>
                                            
                                            <div class="ms-3">
                                                <span class="fw-bold d-block text-dark text-capitalize">
                                                    <?= $k['judul_kegiatan'] ?>
                                                </span>
                                                <small class="text-muted"><i class="far fa-calendar-alt me-1"></i> <?= date('d M Y', strtotime($k['tanggal'])) ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-success">Rp <?= number_format((float)$k['anggaran'], 0, ',', '.') ?></span>
                                    </td>
                                    <td>
                                        <span class="small"><i class="fas fa-map-marker-alt me-1 text-danger"></i> <?= $k['lokasi'] ?></span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group shadow-sm rounded-pill p-1 bg-white border">
                                            <button class="btn btn-success btn-sm rounded-pill px-3 me-1" 
                                                    onclick="konfirmasiAksi(<?= $k['kegiatan_id'] ?>, 'Disetujui', '<?= addslashes($k['judul_kegiatan']) ?>')">
                                                <i class="fas fa-check-circle me-1"></i> Setujui
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm rounded-pill px-3" 
                                                    onclick="konfirmasiAksi(<?= $k['kegiatan_id'] ?>, 'Ditolak', '<?= addslashes($k['judul_kegiatan']) ?>')">
                                                <i class="fas fa-times-circle me-1"></i> Tolak
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <img src="https://cdn-icons-png.flaticon.com/512/1791/1791330.png" width="80" class="mb-3 opacity-25">
                                        <p class="text-muted mb-0">Belum ada pengajuan kegiatan baru dari perangkat desa.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
function konfirmasiAksi(id, status, judul) {
    const isAcc = status === 'Disetujui';
    
    Swal.fire({
        title: 'Konfirmasi ' + status,
        text: `Apakah Anda yakin ingin ${isAcc ? 'menyetujui' : 'menolak'} pengajuan "${judul}"?`,
        icon: isAcc ? 'question' : 'warning',
        showCancelButton: true,
        confirmButtonColor: isAcc ? '#198754' : '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, ' + status + '!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "<?= base_url('kades/proses_persetujuan') ?>/" + id + "/" + status;
        }
    });
}
function previewLengkap(judul, deskripsi, fotoRaw, tanggal, lokasi, anggaran, lat, lng) {
    let htmlFoto = '';
    try {
        let daftarFoto = JSON.parse(fotoRaw);
        if (Array.isArray(daftarFoto) && daftarFoto.length > 0) {
            daftarFoto.forEach((img) => {
                htmlFoto += `<img src="<?= base_url('uploads/kegiatan/') ?>/${img}" class="img-fluid rounded mb-3 border shadow-sm" style="width: 100%; object-fit: cover;">`;
            });
        }
    } catch (e) {
        if (fotoRaw && fotoRaw !== "") {
            htmlFoto = `<img src="<?= base_url('uploads/kegiatan/') ?>/${fotoRaw}" class="img-fluid rounded mb-3 border shadow-sm" style="width: 100%;">`;
        } else {
            htmlFoto = `<div class="p-4 bg-light text-center rounded mb-3 text-muted small"><i class="fas fa-image fa-2x mb-2"></i><br>Tidak ada foto dokumentasi</div>`;
        }
    }

    Swal.fire({
        title: '<span class="fw-bold text-success">' + judul + '</span>',
        html: `
            <div class="text-start mt-2" style="max-height: 550px; overflow-y: auto; overflow-x: hidden; padding-right: 8px;">
                ${htmlFoto}
                
                <div class="mb-3">
                    <small class="text-uppercase fw-bold text-muted" style="font-size: 10px; letter-spacing: 1px;">Titik Koordinat (GIS)</small>
                    <div id="mapPreview" class="rounded border shadow-sm mt-1" style="height: 220px; width: 100%;"></div>
                    <small class="text-muted" style="font-size: 9px;">Lat: ${lat} | Lng: ${lng}</small>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <div class="p-2 border rounded bg-light small">
                            <b class="text-muted d-block" style="font-size: 9px;">TANGGAL PELAKSANAAN</b>
                            <i class="fas fa-calendar-alt text-success me-1"></i> ${tanggal}
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 border rounded bg-light small">
                            <b class="text-muted d-block" style="font-size: 9px;">LOKASI WILAYAH</b>
                            <i class="fas fa-map-marker-alt text-danger me-1"></i> ${lokasi}
                        </div>
                    </div>
                </div>

                <div class="p-2 border rounded mb-3" style="background-color: #ecfdf5; border-color: #10b981 !important;">
                    <b class="text-muted d-block" style="font-size: 9px;">ESTIMASI ANGGARAN</b>
                    <span class="text-success fw-bold" style="font-size: 1.1rem;">Rp ${anggaran}</span>
                </div>

                <div class="small p-1 text-secondary">
                    <b class="text-muted d-block mb-1" style="font-size: 9px;">DESKRIPSI LENGKAP</b>
                    <p style="text-align: justify; line-height: 1.5;">${deskripsi || '-'}</p>
                </div>
            </div>
        `,
        width: '600px',
        confirmButtonText: 'Tutup Detail',
        confirmButtonColor: '#10b981',
        // --- BAGIAN PENTING UNTUK GIS ---
        didOpen: () => {
            if (lat && lng) {
                // Inisialisasi peta setelah modal terbuka
                var map = L.map('mapPreview').setView([lat, lng], 15);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap'
                }).addTo(map);
                
                // Tambahkan Marker
                L.marker([lat, lng]).addTo(map)
                    .bindPopup(judul)
                    .openPopup();

                // Fix map render issue
                setTimeout(() => { map.invalidateSize(); }, 500);
            } else {
                document.getElementById('mapPreview').innerHTML = '<div class="h-100 d-flex align-items-center justify-content-center bg-light text-muted small">Koordinat tidak tersedia</div>';
            }
        }
    });
}
</script>
<?= $this->endSection() ?>