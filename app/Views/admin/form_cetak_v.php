<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm border-0" style="border-radius: 15px;">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0 text-primary"><i class="fas fa-file-invoice me-2"></i> Pengaturan Cetak Laporan</h6>
            </div>
            <div class="card-body">
                <form action="<?= base_url('admin/print_laporan') ?>" method="POST" target="">
                    <div class="mb-3">
                        <label class="small fw-bold text-muted">PILIH KEPALA DESA YANG BERTANDA TANGAN</label>
                        <select name="id_kades" class="form-select" required>
                            <option value="">-- Pilih Nama Kades --</option>
                            <?php foreach($kades as $k): ?>
                                <option value="<?= $k['id_kades'] ?>"><?= $k['nama_kades'] ?> (<?= $k['nip'] ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="small fw-bold text-muted">TANGGAL LAPORAN (DI SURAT)</label>
                        <input type="date" name="tanggal_surat" class="form-control" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill">
                        <i class="fas fa-print me-2"></i> Buka Format Cetak Resmi
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>