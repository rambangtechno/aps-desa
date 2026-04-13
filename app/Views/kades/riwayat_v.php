<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="card border-0 shadow-sm" style="border-radius: 15px;">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0 text-success"><i class="fas fa-file-contract me-2"></i> Riwayat Persetujuan</h5>
        
        <form action="" method="get" class="row g-2 align-items-center">
            <div class="col-auto small fw-bold text-muted">Filter:</div>
            <div class="col-auto">
                <input type="date" name="tgl_mulai" class="form-control form-control-sm border-success-subtle" value="<?= $tgl_mulai ?? '' ?>">
            </div>
            <div class="col-auto">
                <span class="text-muted">s/d</span>
            </div>
            <div class="col-auto">
                <input type="date" name="tgl_selesai" class="form-control form-control-sm border-success-subtle" value="<?= $tgl_selesai ?? '' ?>">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-success btn-sm px-3 rounded-pill">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
                <?php if(isset($_GET['tgl_mulai'])): ?>
                    <a href="<?= base_url('kades/riwayat') ?>" class="btn btn-light btn-sm rounded-pill text-danger">
                        <i class="fas fa-times"></i>
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
    
    <div class="card-body">
        <div class="alert alert-success d-flex align-items-center mb-4" role="alert" style="border-radius: 12px;">
            <i class="fas fa-info-circle me-3 fa-lg"></i>
            <div class="small">
                Halaman ini menampilkan riwayat kegiatan yang telah Anda setujui. Data ini digunakan Admin untuk pencetakan dokumen fisik.
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light text-muted small">
                    <tr>
                        <th class="ps-4">NO</th>
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
                            <td class="ps-4"><?= $no++ ?></td>
                            <td><span class="fw-bold text-dark"><?= $a['judul_kegiatan'] ?></span></td>
                            <td><span class="text-success fw-medium">Rp <?= number_format((float)$a['anggaran'], 0, ',', '.') ?></span></td>
                           <td>
                                <?php 
                                // Ambil data tanggal berdasarkan kolom yang aktif
                                $tanggal_data = $a[$kolom_tgl] ?? null;
                                
                                if ($tanggal_data && $tanggal_data != '0000-00-00 00:00:00') : ?>
                                    <i class="far fa-calendar-alt me-1 text-muted"></i> 
                                    <?= date('d M Y', strtotime($tanggal_data)) ?>
                                <?php else : ?>
                                    <span class="text-muted small">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge bg-success-subtle text-success border border-success px-3 rounded-pill">
                                    <i class="fas fa-check-circle me-1"></i> Terverifikasi
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-search fa-3x d-block mb-3 opacity-25"></i>
                                Tidak ditemukan data pada rentang tanggal tersebut.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>