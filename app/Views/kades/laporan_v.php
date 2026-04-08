<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="card border-0 shadow-sm" style="border-radius: 15px;">
    <div class="card-header bg-white py-3">
        <h5 class="fw-bold mb-0 text-success"><i class="fas fa-file-contract me-2"></i> Riwayat Persetujuan & Verifikasi</h5>
    </div>
    <div class="card-body">
        <div class="alert alert-success d-flex align-items-center" role="alert">
            <i class="fas fa-info-circle me-2"></i>
            <div>
                Halaman ini menampilkan riwayat kegiatan yang telah Anda setujui. Admin akan mencetak dokumen fisik berdasarkan data di bawah ini untuk Anda tandatangani.
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light text-muted small">
                    <tr>
                        <th>NO</th>
                        <th>KEGIATAN</th>
                        <th>ANGGARAN</th>
                        <th>TANGGAL ACC</th>
                        <th>STATUS</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($arsip)) : ?>
                    <?php $no=1; foreach ($arsip as $a) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td>
                            <span class="fw-bold">
                                <?= $a['judul_kegiatan'] ?? 'ID Kegiatan: '.$a['kegiatan_id'] ?>
                            </span>
                        </td>
                        <td>Rp <?= number_format((float)$a['anggaran'], 0, ',', '.') ?></td>
                        <td><?= date('d M Y', strtotime($a['tanggal_persetujuan'])) ?></td>
                        <td><span class="badge bg-success">Disetujui</span></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fas fa-folder-open fa-3x d-block mb-3 opacity-25"></i>
                            Belum ada riwayat kegiatan yang disetujui.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>