<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row d-print-none mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0 text-success"><i class="fas fa-cog me-2"></i> Pengaturan Dokumen Laporan</h6>
            </div>
            <div class="card-body">
                <form action="" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="small fw-bold text-muted">PILIH KEPALA DESA</label>
                        <select name="id_kades" class="form-select select-kades" required>
                            <option value="">-- Pilih Penandatangan --</option>
                            <?php 
                            $db = \Config\Database::connect();
                            $kades_list = $db->table('master_kades')->get()->getResultArray();
                            foreach($kades_list as $k) : 
                            ?>
                                <option value="<?= $k['id_kades'] ?>" <?= (isset($_GET['id_kades']) && $_GET['id_kades'] == $k['id_kades']) ? 'selected' : '' ?>>
                                    <?= $k['nama_kades'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="small fw-bold text-muted">TANGGAL LAPORAN</label>
                        <input type="date" name="tgl_cetak" class="form-control" value="<?= isset($_GET['tgl_cetak']) ? $_GET['tgl_cetak'] : date('Y-m-d') ?>">
                    </div>
                    <div class="col-md-5">
                        <div class="btn-group w-100">
                            <button type="submit" class="btn btn-success rounded-start-pill px-4">
                                <i class="fas fa-sync-alt me-2"></i> Terapkan Data
                            </button>
                            <button type="button" onclick="window.print()" class="btn btn-dark rounded-end-pill px-4" <?= !isset($_GET['id_kades']) ? 'disabled' : '' ?>>
                                <i class="fas fa-print me-2"></i> Cetak Laporan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if (isset($_GET['id_kades'])) : 
    $id_k = $_GET['id_kades'];
    $kades_pilih = $db->table('master_kades')->where('id_kades', $id_k)->get()->getRowArray();
    $tgl_lap = $_GET['tgl_cetak'];
?>
    <div class="print-area bg-white p-5 shadow-sm mx-auto" style="max-width: 210mm; min-height: 297mm; border-radius: 5px; color: black !important;">
        
        <div class="row align-items-center border-bottom border-4 border-dark pb-2 mb-4">
            <div class="col-2 text-center">
                <i class="fas fa-leaf fa-4x text-success"></i>
            </div>
            <div class="col-10 text-center">
                <h4 class="fw-bold mb-0 text-uppercase">Pemerintah Kabupaten Sambas</h4>
                <h5 class="fw-bold mb-0 text-uppercase">Kecamatan Tebas</h5>
                <h3 class="fw-bold mb-1 text-uppercase text-success">Pemerintah Desa Segarau Parit</h3>
                <small class="text-muted italic">Alamat: Jl. Raya Segarau Parit, Kode Pos 79461. Email: desasegarauparit@gmail.com</small>
            </div>
        </div>

        <div class="text-center mb-4">
            <h5 class="fw-bold text-uppercase text-decoration-underline">Laporan Persetujuan Kegiatan Desa</h5>
            <p class="small">Nomor: <?= date('Y/m', strtotime($tgl_lap)) ?>/LPKD/<?= rand(100, 999) ?></p>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered align-middle border-dark">
                <thead class="text-center bg-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Kegiatan</th>
                        <th>Lokasi</th>
                        <th>Anggaran</th>
                        <th>Status</th>
                        <th>Tanggal ACC</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($arsip)) : ?>
                        <?php $no = 1; foreach ($arsip as $a) : ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td class="fw-bold"><?= $a['judul_kegiatan'] ?></td>
                            <td><?= $a['lokasi'] ?></td>
                            <td class="text-end">Rp <?= number_format((float)$a['anggaran'], 0, ',', '.') ?></td>
                            <td class="text-center"><?= $a['status'] ?></td>
                            <td class="text-center"><?= date('d/m/Y', strtotime($a['tanggal_persetujuan'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr><td colspan="6" class="text-center py-4">Tidak ada data persetujuan yang ditemukan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="row mt-5">
            <div class="col-7"></div>
            <div class="col-5 text-center">
                <p class="mb-0">Segarau Parit, <?= date('d F Y', strtotime($tgl_lap)) ?></p>
                <p class="fw-bold mb-5">Kepala Desa Segarau Parit,</p>
                <br><br><br>
                <p class="fw-bold mb-0 text-decoration-underline text-uppercase"><?= $kades_pilih['nama_kades'] ?></p>
                <p class="small text-muted mb-0">NIP. <?= $kades_pilih['nip'] ?></p>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="text-center py-5 bg-white rounded shadow-sm">
        <i class="fas fa-file-invoice fa-4x text-light mb-3"></i>
        <h5 class="text-muted">Silakan pilih data Kepala Desa dan Tanggal Laporan <br>untuk menampilkan format pratinjau cetak.</h5>
    </div>
<?php endif; ?>

<style>
    @media screen {
        .print-area { border: 1px solid #dee2e6; margin-top: 20px; }
    }
    
    @media print {
        body { background-color: white !important; }
        .sidebar, .navbar-custom, .d-print-none, .btn, .footer, .sidebar-menu, .sidebar-label { 
            display: none !important; 
        }
        .content { margin: 0 !important; padding: 0 !important; }
        .section-container { padding: 0 !important; }
        .print-area { 
            box-shadow: none !important; 
            margin: 0 !important; 
            padding: 20px !important; 
            width: 100% !important;
            border: none !important;
        }
        .table-bordered td, .table-bordered th {
            border: 1px solid black !important;
        }
    }
</style>
<?= $this->endSection() ?>