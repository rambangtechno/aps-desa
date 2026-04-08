<?php // TIDAK BOLEH ADA SPASI DI ATAS SINI ?>
<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="card border-0 shadow-sm" style="border-radius: 15px;">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0">Daftar Kegiatan Desa</h5>
        <button class="btn btn-primary btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="fas fa-plus me-1"></i> Tambah Kegiatan
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4">Kegiatan</th>
                        <th>Tanggal & Lokasi</th>
                        <th>Anggaran</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
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
                                        $fotoPertama = (is_array($fotonya) && !empty($fotonya)) ? $fotonya[0] : $k['foto'];
                                    ?>
                                    <?php if($fotoPertama): ?>
                                        <img src="<?= base_url('uploads/kegiatan/' . $fotoPertama) ?>" class="rounded me-3 shadow-sm" width="50" height="50" style="object-fit: cover;">
                                    <?php else: ?>
                                        <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <span class="fw-bold d-block"><?= $k['judul_kegiatan'] ?></span>
                                        <small class="text-muted"><?= substr($k['deskripsi'], 0, 30) ?>...</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <small class="d-block"><i class="fas fa-calendar me-1"></i> <?= $k['tanggal'] ?></small>
                                <small class="d-block text-primary"><i class="fas fa-map-marker-alt me-1"></i> <?= $k['lokasi'] ?></small>
                            </td>
                            <td><span class="badge bg-light text-dark">Rp <?= number_format((float)$k['anggaran'], 0, ',', '.') ?></span></td>
                            <td>
                                <span class="badge <?= ($k['status'] == 'Pending') ? 'bg-warning-subtle text-warning' : 'bg-success-subtle text-success' ?>" style="padding: 5px 10px;">
                                    <?= $k['status'] ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button class="btn btn-info btn-sm text-white rounded-circle shadow-sm me-1" 
                                        onclick="previewLengkap(
                                            '<?= htmlspecialchars($k['judul_kegiatan'], ENT_QUOTES) ?>', 
                                            '<?= htmlspecialchars(str_replace(["\r", "\n"], " ", $k['deskripsi']), ENT_QUOTES) ?>', 
                                            '<?= htmlspecialchars($k['foto'], ENT_QUOTES) ?>', 
                                            '<?= $k['tanggal'] ?>', 
                                            '<?= htmlspecialchars($k['lokasi'], ENT_QUOTES) ?>', 
                                            '<?= number_format((float)$k['anggaran'], 0, ',', '.') ?>'
                                            '<?= $k['latitude'] ?>',
                                            '<?= $k['longitude'] ?>'
                                        )">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    
                                    <button class="btn btn-warning btn-sm text-white rounded-circle me-1" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $k['kegiatan_id'] ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button class="btn btn-danger btn-sm rounded-circle" onclick="hapusKegiatan(<?= $k['kegiatan_id'] ?>)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="modalEdit<?= $k['kegiatan_id'] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0">
                                    <form action="<?= base_url('admin/update_kegiatan/' . $k['kegiatan_id']) ?>" method="POST" enctype="multipart/form-data">
                                        <?= csrf_field() ?>
                                        <div class="modal-header">
                                            <h5 class="fw-bold">Edit Kegiatan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-start">
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold">Judul Kegiatan</label>
                                                <input type="text" name="judul_kegiatan" class="form-control" value="<?= $k['judul_kegiatan'] ?>" required>
                                            </div>
                                            <div class="row">
                                                <div class="col-6 mb-3">
                                                    <label class="form-label small fw-bold">Tanggal</label>
                                                    <input type="date" name="tanggal" class="form-control" value="<?= $k['tanggal'] ?>" required>
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <label class="form-label small fw-bold">Lokasi</label>
                                                    <input type="text" name="lokasi" class="form-control" value="<?= $k['lokasi'] ?>" required>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold">Update Foto (Bisa banyak)</label>
                                                <input type="file" name="foto[]" class="form-control" accept="image/*" multiple>
                                                <small class="text-muted" style="font-size: 11px;">Abaikan jika tidak ingin mengganti foto.</small>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold">Deskripsi</label>
                                                <textarea name="deskripsi" class="form-control" rows="3"><?= $k['deskripsi'] ?></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-warning px-4 text-white">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Belum ada data kegiatan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <form action="<?= base_url('admin/simpan_kegiatan') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="fw-bold">Input Kegiatan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Judul Kegiatan</label>
                        <input type="text" name="judul_kegiatan" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label small fw-bold text-success">Pilih Titik Lokasi (Klik pada Peta)</label>
                            <div id="mapPicker" style="height: 300px; border-radius: 12px;" class="border shadow-sm"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label small fw-bold">Latitude</label>
                            <input type="text" name="latitude" id="latInput" class="form-control" readonly required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label small fw-bold">Longitude</label>
                            <input type="text" name="longitude" id="lngInput" class="form-control" readonly required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Anggaran (Rp)</label>
                        <input type="number" name="anggaran" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Upload Foto (Bisa pilih banyak)</label>
                        <input type="file" name="foto[]" class="form-control" accept="image/*" multiple required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary px-4">Ajukan Kegiatan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    var map;
    var marker;

    // Inisialisasi Peta saat Modal dibuka
    document.getElementById('modalTambah').addEventListener('shown.bs.modal', function () {
        if (!map) {
            // Koordinat default: Sambas (-1.17, 109.30) atau sesuaikan dengan Desa Segarau Parit
            map = L.map('mapPicker').setView([1.3622, 109.3117], 13); 

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            map.on('click', function(e) {
                var lat = e.latlng.lat;
                var lng = e.latlng.lng;

                if (marker) {
                    marker.setLatLng(e.latlng);
                } else {
                    marker = L.marker(e.latlng).addTo(map);
                }

                document.getElementById('latInput').value = lat;
                document.getElementById('lngInput').value = lng;
            });
        }
        map.invalidateSize(); // Perbaiki tampilan peta yang kadang abu-abu
    });
</script>
<script>
function previewLengkap(judul, deskripsi, fotoRaw, tanggal, lokasi, anggaran) {
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
            htmlFoto = `<div class="p-5 bg-light text-center rounded mb-3"><i class="fas fa-image fa-3x text-muted"></i></div>`;
        }
    }

    Swal.fire({
        title: '<span class="fw-bold">' + judul + '</span>',
        html: `
            <div class="text-start mt-2" style="max-height: 500px; overflow-y: auto;">
                ${htmlFoto}
                <div class="row g-2 mb-3">
                    <div class="col-6"><div class="p-2 border rounded bg-light small"><b>TANGGAL:</b> ${tanggal}</div></div>
                    <div class="col-6"><div class="p-2 border rounded bg-light small"><b>LOKASI:</b> ${lokasi}</div></div>
                </div>
                <div class="p-2 border rounded mb-3 bg-primary-subtle"><b class="small text-muted">ANGGARAN:</b> <span class="text-primary fw-bold">Rp ${anggaran}</span></div>
                <div class="small p-1 text-secondary"><b>DESKRIPSI:</b><br>${deskripsi || '-'}</div>
            </div>
        `,
        width: '550px', confirmButtonText: 'Tutup', confirmButtonColor: '#1e293b'
    });
}

function hapusKegiatan(id) {
    Swal.fire({
        title: 'Hapus?', text: "Data tidak bisa dikembalikan!", icon: 'warning',
        showCancelButton: true, confirmButtonColor: '#d33', confirmButtonText: 'Ya, Hapus!'
    }).then((result) => {
        if (result.isConfirmed) window.location.href = "<?= base_url('admin/hapus_kegiatan') ?>/" + id;
    });
}
</script>
<?= $this->endSection() ?>