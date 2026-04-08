<?php // TIDAK BOLEH ADA SPASI DI ATAS SINI ?>
<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row g-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3" style="border-radius: 15px;">
            <div class="d-flex align-items-center">
                <div class="icon-box bg-primary text-white rounded-3 p-3 me-3">
                    <i class="fas fa-calendar-alt fa-2x"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0"><?= $total_kegiatan ?></h3>
                    <p class="text-muted mb-0">Total Kegiatan</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3" style="border-radius: 15px;">
            <div class="d-flex align-items-center">
                <div class="icon-box bg-warning text-white rounded-3 p-3 me-3">
                    <i class="fas fa-clock fa-2x"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0"><?= $total_pending ?></h3>
                    <p class="text-muted mb-0">Menunggu ACC Kades</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3" style="border-radius: 15px;">
            <div class="d-flex align-items-center">
                <div class="icon-box bg-danger text-white rounded-3 p-3 me-3">
                    <i class="fas fa-user-shield fa-2x"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0"><?= $user_pending ?></h3>
                    <p class="text-muted mb-0">User Belum Verifikasi</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>