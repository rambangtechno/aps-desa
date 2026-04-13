<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card border-0 shadow-sm" style="border-radius: 15px;">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="fw-bold mb-0 text-dark">Manajemen Pengguna</h5>
            <small class="text-muted">Kelola akun admin dan perangkat desa</small>
        </div>
        
        <form action="" method="get" class="d-flex">
            <div class="input-group">
                <input type="text" name="keyword" class="form-control form-control-sm border-success" 
                       placeholder="Cari user..." value="<?= $keyword ?? '' ?>" style="border-radius: 10px 0 0 10px;">
                <button class="btn btn-success btn-sm" type="submit" style="border-radius: 0 10px 10px 0;">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-secondary">
                    <tr>
                        <th class="px-4" style="font-size: 0.85rem;">NAMA LENGKAP</th>
                        <th style="font-size: 0.85rem;">USERNAME</th>
                        <th style="font-size: 0.85rem;">ROLE</th>
                        <th style="font-size: 0.85rem;">STATUS</th>
                        <th class="text-center" style="font-size: 0.85rem;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)) : ?>
                        <?php foreach ($users as $u) : ?>
                        <tr>
                            <td class="px-4 fw-bold text-dark"><?= $u['nama_lengkap'] ?></td>
                            <td><code class="text-primary"><?= $u['username'] ?></code></td>
                            <td>
                                <span class="badge bg-info-subtle text-info rounded-pill px-3">
                                    <?= strtoupper($u['role']) ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($u['is_active'] == 1) : ?>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
                                        <i class="fas fa-check-circle me-1"></i> Aktif
                                    </span>
                                <?php else : ?>
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill">
                                        <i class="fas fa-times-circle me-1"></i> Non-Aktif
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center"> 
                                <div class="btn-group">
                                    <a href="<?= base_url('admin/aktivasi_user/'.$u['id'].'/'.($u['is_active'] ? '0' : '1')) ?>" 
                                       class="btn btn-sm <?= $u['is_active'] ? 'btn-light text-danger' : 'btn-light text-success' ?> rounded-circle me-1 shadow-sm"
                                       title="<?= $u['is_active'] ? 'Nonaktifkan' : 'Aktifkan' ?>">
                                        <i class="fas <?= $u['is_active'] ? 'fa-user-slash' : 'fa-user-check' ?>"></i>
                                    </a>

                                    <button class="btn btn-light text-warning btn-sm rounded-circle me-1 shadow-sm" 
                                            data-bs-toggle="modal" data-bs-target="#modalEdit<?= $u['id'] ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    
                                    <?php if($u['id'] != session()->get('id')): ?>
                                        <button onclick="hapusUser(<?= $u['id'] ?>)" class="btn btn-light text-danger btn-sm rounded-circle shadow-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="modalEdit<?= $u['id'] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    <form action="<?= base_url('admin/update_user/' . $u['id']) ?>" method="post">
                                        <?= csrf_field() ?>
                                        <div class="modal-header bg-warning text-white">
                                            <h5 class="fw-bold mb-0"><i class="fas fa-user-edit me-2"></i> Edit Pengguna</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold">Nama Lengkap</label>
                                                <input type="text" name="nama_lengkap" class="form-control rounded-pill" value="<?= $u['nama_lengkap'] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold">Username</label>
                                                <input type="text" name="username" class="form-control rounded-pill" value="<?= $u['username'] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold">Role Hak Akses</label>
                                                <select name="role" class="form-select rounded-pill">
                                                    <option value="admin" <?= $u['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                                    <option value="kepala_desa" <?= $u['role'] == 'kepala_desa' ? 'selected' : '' ?>>Kepala Desa</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold">Password Baru (Kosongkan jika tidak ganti)</label>
                                                <div class="input-group">
                                                    <input type="password" name="password" id="passInput<?= $u['id'] ?>" class="form-control border-end-0" style="border-radius: 20px 0 0 20px;" placeholder="******">
                                                    <button class="btn btn-outline-secondary border-start-0" type="button" 
                                                            style="border-radius: 0 20px 20px 0;" onclick="togglePass(<?= $u['id'] ?>)">
                                                        <i class="fas fa-eye" id="eyeIcon<?= $u['id'] ?>"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-warning text-white rounded-pill px-4">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Data pengguna tidak ditemukan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
// Fungsi Lihat/Sembunyi Password
function togglePass(id) {
    const input = document.getElementById('passInput' + id);
    const icon = document.getElementById('eyeIcon' + id);
    if (input.type === "password") {
        input.type = "text";
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = "password";
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

// SweetAlert Hapus
function hapusUser(id) {
    Swal.fire({
        title: 'Hapus Pengguna?',
        text: "Akun ini tidak akan bisa login kembali ke sistem!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus Akun',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "<?= base_url('admin/hapus_user/') ?>/" + id;
        }
    });
}
</script>

<style>
    .bg-info-subtle { background-color: #e0f2fe; }
    .bg-success-subtle { background-color: #f0fdf4; }
    .bg-danger-subtle { background-color: #fef2f2; }
    .btn-light:hover { background-color: #f1f5f9; transform: scale(1.1); transition: 0.2s; }
</style>

<?= $this->endSection() ?>