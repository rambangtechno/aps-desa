<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row mb-4">
    <div class="col-md-12 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0 text-success"><i class="fas fa-users me-2"></i> Manajemen Data Penduduk</h5>
        <button class="btn btn-success btn-sm px-3 rounded-pill" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="fas fa-user-plus me-1"></i> Tambah Warga
        </button>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 15px;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small">
                    <tr>
                        <th class="ps-4 py-3">NAMA / NIK</th>
                        <th>NO. WHATSAPP</th>
                        <th>DUSUN</th>
                        <th class="text-center">STATUS</th>
                        <th class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($penduduk as $p) : ?>
                    <tr>
                        <td class="ps-4">
                            <span class="fw-bold d-block text-dark"><?= $p['nama_penduduk'] ?></span>
                            <small class="text-muted"><?= $p['nik'] ?></small>
                        </td>
                        <td>
                            <a href="https://wa.me/<?= str_replace(['+', ' ', '-'], '', $p['no_wa']) ?>" target="_blank" class="text-decoration-none text-success fw-medium">
                                <i class="fab fa-whatsapp me-1"></i> <?= $p['no_wa'] ?>
                            </a>
                        </td>
                        <td><?= $p['dusun'] ?></td>
                        <td class="text-center">
                            <span class="badge bg-<?= $p['status_aktif'] == 'Ya' ? 'success' : 'danger' ?>-subtle text-<?= $p['status_aktif'] == 'Ya' ? 'success' : 'danger' ?> rounded-pill">
                                <?= $p['status_aktif'] == 'Ya' ? 'Aktif' : 'Non-aktif' ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="<?= base_url('admin/penduduk_hapus/'.$p['id_penduduk']) ?>" class="btn btn-light btn-sm text-danger rounded-circle" onclick="return confirm('Hapus warga ini?')">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
            <div class="modal-header border-0">
                <h5 class="fw-bold">Input Data Warga</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('admin/penduduk_simpan') ?>" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="small fw-bold">NIK</label>
                        <input type="number" name="nik" class="form-control rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama_penduduk" class="form-control rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">Nomor WhatsApp</label>
                        <input type="text" name="no_wa" class="form-control rounded-3" placeholder="Contoh: 0812345678" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">Dusun</label>
                        <input type="text" name="dusun" class="form-control rounded-3" placeholder="Nama Dusun">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-success w-100 rounded-pill fw-bold">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>