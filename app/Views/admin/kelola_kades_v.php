<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0 text-success">Input Kepala Desa</h6>
            </div>
            <div class="card-body">
                <!-- PENTING: Tambahkan enctype untuk upload file -->
                <form action="<?= base_url('admin/simpan_kades') ?>" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="small fw-bold text-muted">NAMA LENGKAP</label>
                        <input type="text" name="nama_kades" class="form-control" placeholder="Contoh: Bpk. Alanda, S.T." required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold text-muted">NIP</label>
                        <input type="text" name="nip" class="form-control" placeholder="1982xxxx xxxx" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold text-muted">JABATAN</label>
                        <input type="text" name="jabatan" class="form-control" value="Kepala Desa Segarau Parit" readonly>
                    </div>
                    <!-- Input Foto Baru -->
                    <div class="mb-3">
                        <label class="small fw-bold text-muted">FOTO PROFIL</label>
                        <input type="file" name="foto" class="form-control" accept="image/*" required>
                        <div class="form-text text-danger" style="font-size: 10px;">*Format: JPG/PNG, Maks: 2MB</div>
                    </div>
                    <button type="submit" class="btn btn-success w-100 rounded-pill">Simpan Data</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-body p-0">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-light small">
                        <tr>
                            <th class="px-4">FOTO</th> <!-- Tambah kolom foto -->
                            <th>NAMA</th>
                            <th>NIP</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($kades as $k): ?>
                        <tr>
                            <!-- Bagian baris foto di tabel -->
                            <td class="px-4">
                                <img src="<?= base_url('uploads/kades/' . $k['foto']) ?>" 
                                    class="rounded-circle shadow-sm" 
                                    style="width: 45px; height: 45px; object-fit: cover;"
                                    alt="Foto">
                            </td>
                            <td class="fw-bold"><?= $k['nama_kades'] ?></td>
                            <td><?= $k['nip'] ?></td>
                            <td>
                                <?php if($k['is_active'] == 1): ?>
                                    <span class="badge bg-success rounded-pill">Aktif (TTD)</span>
                                <?php else: ?>
                                    <span class="badge bg-light text-muted rounded-pill">Non-Aktif</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>