<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm p-3">
            <div class="d-flex align-items-center">
                <div class="bg-primary text-white p-3 rounded-3 me-3">
                    <i class="fas fa-tasks fa-2x"></i>
                </div>
                <div>
                    <p class="text-muted mb-0">Total Kegiatan</p>
                    <h3 class="mb-0">12</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm p-3">
            <div class="d-flex align-items-center">
                <div class="bg-success text-white p-3 rounded-3 me-3">
                    <i class="fas fa-check-circle fa-2x"></i>
                </div>
                <div>
                    <p class="text-muted mb-0">Selesai</p>
                    <h3 class="mb-0">8</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm p-3">
            <div class="d-flex align-items-center">
                <div class="bg-warning text-white p-3 rounded-3 me-3">
                    <i class="fas fa-clock fa-2x"></i>
                </div>
                <div>
                    <p class="text-muted mb-0">Berjalan</p>
                    <h3 class="mb-0">4</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mt-2">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0">Kegiatan Terbaru</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kegiatan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Musyawarah Perencanaan Desa</td>
                        <td>10 April 2026</td>
                        <td><span class="badge bg-warning">Pending</span></td>
                        <td><button class="btn btn-sm btn-outline-primary">Detail</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>