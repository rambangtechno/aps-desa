<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="card border-0 shadow-sm" style="border-radius: 15px;">
    <div class="card-header bg-white py-3">
        <h5 class="fw-bold mb-0"><i class="fas fa-user-shield me-2 text-danger"></i> Verifikasi Akun Baru</h5>
        <p class="text-muted small mb-0">Setujui pendaftaran perangkat desa agar mereka bisa mengakses sistem.</p>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small">
                    <tr>
                        <th class="px-4 py-3">Nama Pengguna</th>
                        <th>Username</th>
                        <th>Jabatan / Role</th>
                        <th>Tanggal Daftar</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pending_user)) : ?>
                        <?php foreach ($pending_user as $u) : ?>
                        <tr>
                            <td class="px-4">
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name=<?= $u['nama_lengkap'] ?>&background=random&color=fff" class="rounded-circle me-3" width="35">
                                    <span class="fw-600"><?= $u['nama_lengkap'] ?></span>
                                </div>
                            </td>
                            <td><span class="badge bg-light text-dark border"><?= $u['username'] ?></span></td>
                            <td>
                                <span class="text-capitalize small">
                                    <i class="fas fa-briefcase me-1 text-muted"></i> <?= str_replace('_', ' ', $u['role']) ?>
                                </span>
                            </td>
                            <td class="text-muted small"><?= date('d M Y', strtotime($u['created_at'])) ?></td>
                            <td class="text-center">
                                <button class="btn btn-success btn-sm px-3 rounded-pill" onclick="confirmVerifikasi(<?= $u['id'] ?>, '<?= $u['nama_lengkap'] ?>')">
                                    <i class="fas fa-check me-1"></i> Verifikasi
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="fas fa-user-clock fa-3x text-light mb-3 d-block"></i>
                                <p class="text-muted mb-0">Tidak ada pendaftaran baru yang menunggu verifikasi.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function confirmVerifikasi(id, name) {
    Swal.fire({
        title: 'Verifikasi Akun?',
        text: "Izinkan " + name + " untuk masuk ke dalam sistem desa?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#198754',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Verifikasi!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Kita tambahkan /1 di akhir agar sesuai dengan route (:num)/(:num)
            window.location.href = "<?= base_url('admin/aktivasi_user') ?>/" + id + "/1";
        }
    });
}
</script>
<?= $this->endSection() ?>