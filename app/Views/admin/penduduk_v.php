<?php // TIDAK BOLEH ADA SPASI DI ATAS SINI ?>
<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row mb-4">
    <div class="col-md-12 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0 text-success"><i class="fas fa-user-shield me-2"></i> Manajemen Data Ketua RT / RW</h5>
        <button class="btn btn-success btn-sm px-3 rounded-pill" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="fas fa-user-plus me-1"></i> Tambah RT/RW
        </button>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
    <div class="card-body p-3">
        <div class="row g-2">
            <div class="col-md-5">
                <label class="form-label small fw-bold text-muted">Cari Nama / NIK</label>
                <input type="text" id="searchNama" class="form-control form-control-sm bg-light" placeholder="Ketik nama atau NIK...">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold text-muted">Filter Jabatan</label>
                <select id="filterJabatan" class="form-select form-select-sm bg-light">
                    <option value="">Semua Jabatan</option>
                    <option value="RT">Ketua RT</option>
                    <option value="RW">Ketua RW</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="button" id="btnReset" class="btn btn-outline-danger btn-sm w-100">
                    <i class="fas fa-undo me-1"></i> Reset Filter
                </button>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 15px;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small">
                    <tr>
                        <th class="ps-4 py-3">NAMA / NIK</th>
                        <th>JENIS KELAMIN</th>
                        <th>JABATAN / TUGAS</th>
                        <th>ALAMAT</th>
                        <th>NO. WHATSAPP</th>
                        <th>DUSUN</th>
                        <th>RT</th>
                        <th>RW</th>
                        <th class="text-center">STATUS</th>
                        <th class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody id="tabelRtrw">
                    <?php if(!empty($penduduk)): ?>
                        <?php foreach ($penduduk as $p) : ?>
                        <tr class="baris-rtrw" data-nama="<?= strtolower(htmlspecialchars($p['nama_penduduk'])) ?>" data-nik="<?= $p['nik'] ?>" data-jabatan="<?= $p['jabatan'] ?? 'RT' ?>">
                            <td class="ps-4">
                                <span class="fw-bold d-block text-dark"><?= $p['nama_penduduk'] ?></span>
                                <small class="text-muted"><?= $p['nik'] ?></small>
                            </td>
                            <td><?= $p['jenis_kelamin'] ?? '-' ?></td>
                            <td>
                                <?php if(($p['jabatan'] ?? 'RT') == 'RW'): ?>
                                    <span class="badge bg-primary text-white rounded-pill px-3">Ketua RW <?= $p['nomor_jabatan'] ?? '-' ?></span>
                                <?php else: ?>
                                    <span class="badge bg-info text-white rounded-pill px-3">Ketua RT <?= $p['nomor_jabatan'] ?? '-' ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?= $p['alamat'] ?? '-' ?></td>
                            <td>
                                <a href="https://wa.me/<?= str_replace(['+', ' ', '-'], '', $p['no_wa']) ?>" target="_blank" class="text-decoration-none text-success fw-medium">
                                    <i class="fab fa-whatsapp me-1"></i> <?= $p['no_wa'] ?>
                                </a>
                            </td>
                            <td><?= $p['dusun'] ?? '-' ?></td>
                            <td><?= $p['rt'] ?? '-' ?></td>
                            <td><?= $p['rw'] ?? '-' ?></td>
                            <td class="text-center">
                                <span class="badge bg-<?= $p['status_aktif'] == 'Ya' ? 'success' : 'danger' ?>-subtle text-<?= $p['status_aktif'] == 'Ya' ? 'success' : 'danger' ?> rounded-pill">
                                    <?= $p['status_aktif'] == 'Ya' ? 'Aktif' : 'Non-aktif' ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button class="btn btn-light btn-sm text-warning rounded-circle me-1" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $p['id_penduduk'] ?>" title="Edit Data">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href="<?= base_url('admin/penduduk_hapus/'.$p['id_penduduk']) ?>" class="btn btn-light btn-sm text-danger rounded-circle" onclick="return confirm('Hapus data pejabat RT/RW ini?')" title="Hapus Data">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="modalEdit<?= $p['id_penduduk'] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow" style="border-radius: 20px;">
                                    <div class="modal-header border-0">
                                        <h5 class="fw-bold">Edit Data Ketua RT / RW</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="<?= base_url('Admin/penduduk_update/' . $p['id_penduduk']) ?>" method="POST">
                                        <?= csrf_field() ?>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="small fw-bold">NIK Ketua</label>
                                                <input type="number" name="nik" class="form-control rounded-3" value="<?= $p['nik'] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="small fw-bold">Nama Lengkap</label>
                                                <input type="text" name="nama_penduduk" class="form-control rounded-3" value="<?= $p['nama_penduduk'] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="small fw-bold">Jenis Kelamin</label>
                                                <select name="jenis_kelamin" class="form-select rounded-3" required>
                                                    <option value="Laki-laki" <?= ($p['jenis_kelamin'] == 'Laki-laki') ? 'selected' : '' ?>>Laki-laki</option>
                                                    <option value="Perempuan" <?= ($p['jenis_kelamin'] == 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
                                                </select>
                                            </div>
                                            <div class="row">
                                                <div class="col-6 mb-3">
                                                    <label class="small fw-bold">Jabatan</label>
                                                    <select name="jabatan" class="form-select rounded-3" required>
                                                        <option value="RT" <?= ($p['jabatan'] == 'RT') ? 'selected' : '' ?>>Ketua RT</option>
                                                        <option value="RW" <?= ($p['jabatan'] == 'RW') ? 'selected' : '' ?>>Ketua RW</option>
                                                    </select>
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <label class="small fw-bold">Nomor (Contoh: 002)</label>
                                                    <input type="text" name="nomor_jabatan" class="form-control rounded-3" value="<?= $p['nomor_jabatan'] ?>" placeholder="000" required>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="small fw-bold">Alamat Jalan / Rumah</label>
                                                <textarea name="alamat" class="form-control rounded-3" rows="2" placeholder="Contoh: Jl. Merdeka No. 12"><?= $p['alamat'] ?></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="small fw-bold">Nomor WhatsApp</label>
                                                <input type="text" name="no_wa" class="form-control rounded-3" value="<?= $p['no_wa'] ?>" placeholder="Contoh: 0812345678" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="small fw-bold">Wilayah Dusun</label>
                                                <input type="text" name="dusun" class="form-control rounded-3" value="<?= $p['dusun'] ?>" placeholder="Nama Dusun" required>
                                            </div>
                                            <div class="row">
                                                <div class="col-6 mb-3">
                                                    <label class="small fw-bold">RT</label>
                                                    <input type="text" name="rt" class="form-control rounded-3" value="<?= $p['rt'] ?>" placeholder="001">
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <label class="small fw-bold">RW</label>
                                                    <input type="text" name="rw" class="form-control rounded-3" value="<?= $p['rw'] ?>" placeholder="002">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="small fw-bold">Status Aktif</label>
                                                <select name="status_aktif" class="form-select rounded-3">
                                                    <option value="Ya" <?= ($p['status_aktif'] == 'Ya') ? 'selected' : '' ?>>Aktif</option>
                                                    <option value="Tidak" <?= ($p['status_aktif'] == 'Tidak') ? 'selected' : '' ?>>Non-aktif</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="submit" class="btn btn-warning w-100 rounded-pill fw-bold text-white">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10" class="text-center py-5 text-muted">Belum ada data RT/RW yang diinput.</td>
                        </tr>
                    <?php endif; ?>
                    <tr id="rowKosong" style="display: none;">
                        <td colspan="10" class="text-center py-5 text-muted">Data RT/RW tidak ditemukan.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
            <div class="modal-header border-0">
                <h5 class="fw-bold">Input Data Ketua RT / RW</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('Admin/penduduk_simpan') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="small fw-bold">NIK Ketua</label>
                        <input type="number" name="nik" class="form-control rounded-3" maxlength="16" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama_penduduk" class="form-control rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select rounded-3" required>
                            <option value="" disabled selected>Pilih jenis kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="small fw-bold">Jabatan</label>
                            <select name="jabatan" class="form-select rounded-3" required>
                                <option value="RT">Ketua RT</option>
                                <option value="RW">Ketua RW</option>
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="small fw-bold">Nomor (Contoh: 002)</label>
                            <input type="text" name="nomor_jabatan" class="form-control rounded-3" placeholder="000" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">Alamat Jalan / Rumah</label>
                        <textarea name="alamat" class="form-control rounded-3" rows="2" placeholder="Contoh: Jl. Merdeka No. 12"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">Nomor WhatsApp</label>
                        <input type="text" name="no_wa" class="form-control rounded-3" placeholder="Contoh: 0812345678" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">Wilayah Dusun</label>
                        <input type="text" name="dusun" class="form-control rounded-3" placeholder="Nama Dusun" required>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="small fw-bold">RT</label>
                            <input type="text" name="rt" class="form-control rounded-3" placeholder="001">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="small fw-bold">RW</label>
                            <input type="text" name="rw" class="form-control rounded-3" placeholder="002">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-success w-100 rounded-pill fw-bold text-white">Simpan Data Pejabat</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchNama = document.getElementById("searchNama");
    const filterJabatan = document.getElementById("filterJabatan");
    const btnReset = document.getElementById("btnReset");
    const barisRtrw = document.querySelectorAll(".baris-rtrw");
    const rowKosong = document.getElementById("rowKosong");

    function saringData() {
        const keyword = searchNama.value.toLowerCase().trim();
        const jabatan = filterJabatan.value;
        let ketemu = 0;

        barisRtrw.forEach(tr => {
            const nama = tr.getAttribute("data-nama");
            const nik = tr.getAttribute("data-nik");
            const jab = tr.getAttribute("data-jabatan");

            const cocokKeyword = !keyword || nama.includes(keyword) || nik.includes(keyword);
            const cocokJabatan = !jabatan || jab === jabatan;

            if (cocokKeyword && cocokJabatan) {
                tr.style.display = "";
                ketemu++;
            } else {
                tr.style.display = "none";
            }
        });

        rowKosong.style.display = (ketemu === 0 && barisRtrw.length > 0) ? "" : "none";
    }

    searchNama.addEventListener("input", saringData);
    filterJabatan.addEventListener("change", saringData);
    btnReset.addEventListener("click", function () {
        searchNama.value = "";
        filterJabatan.value = "";
        saringData();
    });
});
</script>
<?= $this->endSection() ?>