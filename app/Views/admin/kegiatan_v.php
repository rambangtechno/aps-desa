<?php // TIDAK BOLEH ADA SPASI DI ATAS SINI ?>
<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
    <div class="card-body p-3">
        <div class="row g-2">
            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted">Cari Kegiatan</label>
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" id="searchJudul" class="form-control bg-light border-start-0" placeholder="Ketik judul kegiatan...">
                </div>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold text-muted">Kategori</label>
                <select id="filterKategori" class="form-select form-select-sm bg-light">
                    <option value="">Semua Kategori</option>
                    <option value="Rutin">Rutin</option>
                    <option value="Tahunan">Tahunan</option>
                    <option value="Mingguan">Mingguan</option>
                    <option value="Harian">Harian</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold text-muted">Status</label>
                <select id="filterStatus" class="form-select form-select-sm bg-light">
                    <option value="">Semua Status</option>
                    <option value="Pending">Pending</option>
                    <option value="Disetujui">Disetujui</option>
                    <option value="Ditolak">Ditolak</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold text-muted">Dari Tanggal</label>
                <input type="date" id="filterTglMulai" class="form-control form-select-sm bg-light">
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold text-muted">Sampai Tanggal</label>
                <input type="date" id="filterTglSelesai" class="form-control form-select-sm bg-light">
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="button" id="btnResetFilter" class="btn btn-outline-danger btn-sm w-100 rounded" title="Reset Filter">
                    <i class="fas fa-undo"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 15px;">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0">Daftar Kegiatan Desa</h5>
        <button class="btn btn-primary btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="fas fa-plus me-1"></i> Tambah Kegiatan
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="tabelKegiatan">
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
                        <tr class="baris-kegiatan" 
                            data-judul="<?= strtolower(htmlspecialchars($k['judul_kegiatan'])) ?>"
                            data-kategori="<?= $k['kategori'] ?? 'Rutin' ?>"
                            data-status="<?= $k['status'] ?>"
                            data-tanggal="<?= $k['tanggal'] ?? '' ?>">
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
                                        <span class="badge bg-secondary-subtle text-secondary mb-1" style="font-size: 10px; font-weight: 600; text-transform: uppercase;">
                                            <i class="fas fa-tag me-1" style="font-size: 9px;"></i><?= $k['kategori'] ?? 'Rutin' ?>
                                        </span>
                                        <small class="text-muted d-block"><?= substr($k['deskripsi'], 0, 30) ?>...</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <small class="d-block text-muted"><i class="fas fa-calendar me-1"></i> <span class="txt-tanggal"><?= $k['tanggal'] ?? '-' ?></span></small>
                                <small class="d-block text-primary"><i class="fas fa-map-marker-alt me-1"></i> <?= $k['lokasi'] ?></small>
                            </td>
                            <td><span class="badge bg-light text-dark">Rp <?= number_format((float)$k['anggaran'], 0, ',', '.') ?></span></td>
                            <td>
                                <span class="badge <?= ($k['status'] == 'Pending') ? 'bg-warning-subtle text-warning' : (($k['status'] == 'Disetujui') ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger') ?>" style="padding: 5px 10px;">
                                    <?= $k['status'] ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button class="btn btn-info btn-sm text-white rounded-circle shadow-sm me-1" 
                                        onclick="previewLengkap(
                                            '<?= htmlspecialchars($k['judul_kegiatan'], ENT_QUOTES) ?>', 
                                            '<?= htmlspecialchars($k['kategori'] ?? 'Rutin', ENT_QUOTES) ?>', 
                                            '<?= htmlspecialchars(str_replace(["\r", "\n"], " ", $k['deskripsi']), ENT_QUOTES) ?>', 
                                            '<?= htmlspecialchars($k['foto'], ENT_QUOTES) ?>', 
                                            '<?= $k['tanggal'] ?>', 
                                            '<?= htmlspecialchars($k['lokasi'], ENT_QUOTES) ?>', 
                                            '<?= number_format((float)$k['anggaran'], 0, ',', '.') ?>',
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
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label small fw-bold">Judul Kegiatan</label>
                                            <input type="text" name="judul_kegiatan" class="form-control" value="<?= $k['judul_kegiatan'] ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label small fw-bold">Kategori Kegiatan</label>
                                            <select name="kategori" class="form-select" required>
                                                <option value="Rutin" <?= (isset($k['kategori']) && $k['kategori'] == 'Rutin') ? 'selected' : '' ?>>Rutin</option>
                                                <option value="Tahunan" <?= (isset($k['kategori']) && $k['kategori'] == 'Tahunan') ? 'selected' : '' ?>>Tahunan</option>
                                                <option value="Mingguan" <?= (isset($k['kategori']) && $k['kategori'] == 'Mingguan') ? 'selected' : '' ?>>Mingguan</option>
                                                <option value="Harian" <?= (isset($k['kategori']) && $k['kategori'] == 'Harian') ? 'selected' : '' ?>>Harian</option>
                                            </select>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <label class="form-label small fw-bold text-warning">Ubah Titik Lokasi (Klik pada Peta)</label>
                                                <div id="mapEdit-<?= $k['kegiatan_id'] ?>" style="height: 300px; width: 100%; border-radius: 12px; background-color: #eee;" class="border shadow-sm"></div>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <label class="form-label small fw-bold">Latitude</label>
                                                <input type="text" name="latitude" id="latEdit-<?= $k['kegiatan_id'] ?>" class="form-control" value="<?= $k['latitude'] ?>" readonly required>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <label class="form-label small fw-bold">Longitude</label>
                                                <input type="text" name="longitude" id="lngEdit-<?= $k['kegiatan_id'] ?>" class="form-control" value="<?= $k['longitude'] ?>" readonly required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <label class="form-label small fw-bold">Tanggal</label>
                                                <input type="date" name="tanggal" class="form-control" value="<?= $k['tanggal'] ?>" required>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <label class="form-label small fw-bold">Lokasi (Alamat)</label>
                                                <input type="text" name="lokasi" class="form-control" value="<?= $k['lokasi'] ?>" required>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label small fw-bold">Anggaran (Rp)</label>
                                            <input type="number" name="anggaran" class="form-control" value="<?= $k['anggaran'] ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label small fw-bold">Update Foto (Bisa banyak)</label>
                                            <input type="file" name="foto[]" class="form-control" accept="image/*" multiple>
                                            <small class="text-muted" style="font-size: 11px;">Biarkan kosong jika tidak ingin mengubah foto.</small>
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
                        <tr id="noDataRow">
                            <td colspan="5" class="text-center py-5 text-muted">Belum ada data kegiatan.</td>
                        </tr>
                    <?php endif; ?>
                    <tr id="filterKosongRow" style="display: none;">
                        <td colspan="5" class="text-center py-5 text-muted">Data kegiatan tidak ditemukan berdasarkan filter pilihan.</td>
                    </tr>
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

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Kategori Kegiatan</label>
                        <select name="kategori" class="form-select" required>
                            <option value="" disabled selected>-- Pilih Kategori --</option>
                            <option value="Rutin">Rutin</option>
                            <option value="Tahunan">Tahunan</option>
                            <option value="Mingguan">Mingguan</option>
                            <option value="Harian">Harian</option>
                        </select>
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
document.addEventListener("DOMContentLoaded", function () {
    const searchJudul     = document.getElementById("searchJudul");
    const filterKategori  = document.getElementById("filterKategori");
    const filterStatus    = document.getElementById("filterStatus");
    const filterTglMulai  = document.getElementById("filterTglMulai");
    const filterTglSelesai = document.getElementById("filterTglSelesai");
    const btnResetFilter  = document.getElementById("btnResetFilter");
    const barisKegiatan   = document.querySelectorAll(".baris-kegiatan");
    const filterKosongRow = document.getElementById("filterKosongRow");

    function jalankanFilter() {
        const keyword   = searchJudul.value.toLowerCase().trim();
        const kategori  = filterKategori.value;
        const status    = filterStatus.value;
        const tglMulai  = filterTglMulai.value ? new Date(filterTglMulai.value) : null;
        const tglSelesai = filterTglSelesai.value ? new Date(filterTglSelesai.value) : null;

        let dataDitemukan = 0;

        barisKegiatan.forEach(tr => {
            const dataJudul    = tr.getAttribute("data-judul");
            const dataKategori = tr.getAttribute("data-kategori");
            const dataStatus   = tr.getAttribute("data-status");
            const rawTanggal   = tr.getAttribute("data-tanggal");
            const dataTanggal  = rawTanggal ? new Date(rawTanggal) : null;

            // Logika Evaluasi Filter
            const cocokKeyword  = !keyword || dataJudul.includes(keyword);
            const cocokKategori = !kategori || dataKategori === kategori;
            const cocokStatus   = !status || dataStatus === status;
            
            let cocokRentangWaktu = true;
            if (dataTanggal) {
                if (tglMulai && dataTanggal < tglMulai) cocokRentangWaktu = false;
                if (tglSelesai && dataTanggal > tglSelesai) cocokRentangWaktu = false;
            } else if (tglMulai || tglSelesai) {
                // Jika user memfilter waktu tapi kegiatan tidak punya tanggal
                cocokRentangWaktu = false;
            }

            // Aksi Sembunyikan / Tampilkan Baris
            if (cocokKeyword && cocokKategori && cocokStatus && cocokRentangWaktu) {
                tr.style.display = "";
                dataDitemukan++;
            } else {
                tr.style.display = "none";
            }
        });

        // Menampilkan pesan jika tidak ada hasil yang cocok
        if (dataDitemukan === 0 && barisKegiatan.length > 0) {
            filterKosongRow.style.display = "";
        } else {
            filterKosongRow.style.display = "none";
        }
    }

    // Pasang Event Listener saat input diubah
    searchJudul.addEventListener("input", jalankanFilter);
    filterKategori.addEventListener("change", jalankanFilter);
    filterStatus.addEventListener("change", jalankanFilter);
    filterTglMulai.addEventListener("change", jalankanFilter);
    filterTglSelesai.addEventListener("change", jalankanFilter);

    // Tombol Reset Filter
    btnResetFilter.addEventListener("click", function () {
        searchJudul.value = "";
        filterKategori.value = "";
        filterStatus.value = "";
        filterTglMulai.value = "";
        filterTglSelesai.value = "";
        jalankanFilter();
    });
});
</script>

<script>
    var editMaps = {};

    <?php foreach ($kegiatan as $k) : ?>
    document.getElementById('modalEdit<?= $k['kegiatan_id'] ?>').addEventListener('shown.bs.modal', function () {
        const id = "<?= $k['kegiatan_id'] ?>";
        const containerId = 'mapEdit-' + id;
        
        let oldLat = document.getElementById('latEdit-' + id).value;
        let oldLng = document.getElementById('lngEdit-' + id).value;
        let latlng = (oldLat && oldLng) ? [parseFloat(oldLat), parseFloat(oldLng)] : [1.3622, 109.3117];

        if (editMaps[id]) {
            editMaps[id].remove();
        }

        var osmEdit = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap' });
        var satelitEdit = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', { attribution: 'Tiles © Esri' });

        editMaps[id] = L.map(containerId, {
            center: latlng,
            zoom: 15,
            layers: [osmEdit]
        });

        var baseMapsEdit = {
            "Default (Jalan)": osmEdit,
            "Satelit": satelitEdit
        };
        L.control.layers(baseMapsEdit).addTo(editMaps[id]);

        let marker = L.marker(latlng, { draggable: true }).addTo(editMaps[id]);

        function updateFields(lat, lng) {
            document.getElementById('latEdit-' + id).value = lat.toFixed(7);
            document.getElementById('lngEdit-' + id).value = lng.toFixed(7);
        }

        marker.on('dragend', function(event) {
            let pos = marker.getLatLng();
            updateFields(pos.lat, pos.lng);
        });

        editMaps[id].on('click', function(e) {
            marker.setLatLng(e.latlng);
            updateFields(e.latlng.lat, e.latlng.lng);
        });

        setTimeout(() => {
            editMaps[id].invalidateSize();
        }, 400);
    });
    <?php endforeach; ?>
</script>
<script>
    var map;
    var marker;

    document.getElementById('modalTambah').addEventListener('shown.bs.modal', function () {
        if (!map) {
            var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap'
            });

            var satelit = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                attribution: 'Tiles © Esri'
            });

            map = L.map('mapPicker', {
                center: [1.3622, 109.3117],
                zoom: 13,
                layers: [osm]
            });

            var baseMaps = {
                "Default (Jalan)": osm,
                "Satelit": satelit
            };
            L.control.layers(baseMaps).addTo(map);

            map.on('click', function(e) {
                var lat = e.latlng.lat;
                var lng = e.latlng.lng;

                if (marker) {
                    marker.setLatLng(e.latlng);
                } else {
                    marker = L.marker(e.latlng).addTo(map);
                }

                document.getElementById('latInput').value = lat.toFixed(7);
                document.getElementById('lngInput').value = lng.toFixed(7);
            });
        }
        map.invalidateSize();
    });
</script>
<script>
function previewLengkap(judul, kategori, deskripsi, fotoRaw, tanggal, lokasi, anggaran, lat, lng) {
    let htmlFoto = '';
    try {
        let daftarFoto = JSON.parse(fotoRaw);
        if (Array.isArray(daftarFoto) && daftarFoto.length > 0) {
            daftarFoto.forEach((img) => {
                htmlFoto += `<img src="<?= base_url('uploads/kegiatan/') ?>/${img}" class="img-fluid rounded mb-3 border shadow-sm" style="width: 100%; height: 250px; object-fit: cover;">`;
            });
        }
    } catch (e) {
        if (fotoRaw && fotoRaw !== "") {
            htmlFoto = `<img src="<?= base_url('uploads/kegiatan/') ?>/${fotoRaw}" class="img-fluid rounded mb-3 border shadow-sm" style="width: 100%;">`;
        } else {
            htmlFoto = `<div class="p-5 bg-light text-center rounded mb-3"><i class="fas fa-image fa-3x text-muted"></i></div>`;
        }
    }

    let gmapsLink = (lat && lng) ? `https://www.google.com/maps?q=${lat},${lng}` : '#';

    Swal.fire({
        title: '<span class="fw-bold">' + judul + '</span>',
        html: `
            <div class="text-start mt-2" style="max-height: 500px; overflow-y: auto; overflow-x: hidden;">
                ${htmlFoto}
                <div class="mb-3 text-center">
                    <span class="badge bg-secondary px-3 py-2 rounded-pill" style="font-size: 12px; letter-spacing: 0.5px;">
                        <i class="fas fa-tags me-1"></i> KATEGORI: ${kategori.toUpperCase()}
                    </span>
                </div>
                <div class="row g-2 mb-3">
                    <div class="col-6"><div class="p-2 border rounded bg-light small"><b>TANGGAL:</b><br>${tanggal}</div></div>
                    <div class="col-6"><div class="p-2 border rounded bg-light small"><b>LOKASI:</b><br>${lokasi}</div></div>
                </div>
                <div class="p-2 border rounded mb-3 bg-primary-subtle text-center">
                    <b class="small text-muted text-uppercase">Anggaran:</b><br>
                    <span class="text-primary fw-bold h5">Rp ${anggaran}</span>
                </div>
                <div class="mb-3 small p-2 border rounded bg-white">
                    <b>DESKRIPSI:</b><br>${deskripsi || '-'}
                </div>
                ${(lat && lng) ? `
                <a href="${gmapsLink}" target="_blank" class="btn btn-outline-success btn-sm w-100 rounded-pill">
                    <i class="fas fa-map-marker-alt me-1"></i> Lihat Lokasi di Google Maps
                </a>` : ''}
            </div>
        `,
        width: '550px', 
        confirmButtonText: 'Tutup', 
        confirmButtonColor: '#1e293b'
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