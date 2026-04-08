<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Desa Segarau Parit</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root {
            --sidebar-bg: #ffffff;
            --sidebar-text: #64748b;
            --primary-green: #10b981; /* Emerald Green */
            --dark-green: #064e3b;
            --light-green: #ecfdf5;
            --bg-body: #f8fafc;
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: var(--bg-body); 
            color: #1e293b;
            margin: 0;
        }

        /* Sidebar Modern Styling */
        .sidebar { 
            min-width: 280px; 
            max-width: 280px; 
            background: var(--sidebar-bg); 
            min-height: 100vh; 
            transition: all 0.3s;
            border-right: 1px solid #e2e8f0;
            display: flex;
            flex-direction: column;
        }

        .sidebar .brand-wrapper {
            padding: 35px 25px;
            border-bottom: 1px solid #f1f5f9;
        }

        .sidebar .nav-link { 
            color: var(--sidebar-text); 
            padding: 12px 20px; 
            margin: 4px 18px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            font-weight: 500;
            transition: all 0.2s ease;
            text-decoration: none;
            font-size: 0.95rem;
        }

        .sidebar .nav-link i {
            width: 28px;
            font-size: 1.1rem;
            transition: 0.2s;
        }

        .sidebar .nav-link:hover { 
            color: var(--primary-green); 
            background: var(--light-green);
        }

        .sidebar .nav-link.active { 
            color: #fff !important; 
            background: var(--primary-green) !important;
            box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.2);
        }

        .sidebar .nav-link.active i {
            color: #fff !important;
        }

        .sidebar-label {
            padding: 20px 35px 10px;
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 700;
            color: #94a3b8;
            letter-spacing: 1px;
        }

        /* Content Area */
        .content { width: 100%; min-height: 100vh; display: flex; flex-direction: column; }

        .navbar-custom { 
            background: rgba(255, 255, 255, 0.9); 
            backdrop-filter: blur(8px);
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 30px;
        }

        .user-profile-img {
            width: 38px;
            height: 38px;
            border: 2px solid var(--primary-green);
            padding: 2px;
            border-radius: 10px;
            object-fit: cover;
        }

        @media (max-width: 768px) {
            .sidebar { margin-left: -280px; position: fixed; z-index: 1000; }
            .sidebar.active { margin-left: 0; box-shadow: 20px 0 25px -5px rgba(0,0,0,0.1); }
        }

        .section-container {
            padding: 30px;
            flex: 1;
        }

        /* Card Branding */
        .brand-text {
            color: var(--dark-green);
            font-size: 1.1rem;
            letter-spacing: -0.5px;
        }

        .btn-logout {
            color: #ef4444;
            background: #fef2f2;
            margin-top: auto;
            margin-bottom: 30px;
        }
        
        .btn-logout:hover {
            background: #fee2e2;
            color: #b91c1c;
        }
    </style>
</head>
<body>

<div class="d-flex">
    <div class="sidebar" id="sidebar">
    <div class="brand-wrapper">
        <div class="d-flex align-items-center">
            <div class="bg-success rounded-3 p-2 me-3 shadow-sm" style="background: var(--primary-green) !important;">
                <i class="fas fa-leaf text-white fa-lg"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-0 brand-text">Segarau Parit</h6>
                <small class="text-muted fw-medium" style="font-size: 0.7rem;">DESA DIGITAL</small>
            </div>
        </div>
    </div>
    
    <div class="sidebar-menu flex-grow-1">
        <ul class="nav flex-column mt-3">
            
            <?php if (session()->get('role') == 'admin') : ?>
                <li class="nav-item">
                    <a class="nav-link <?= (url_is('admin') || url_is('admin/index')) ? 'active' : '' ?>" href="<?= base_url('admin') ?>">
                        <i class="fas fa-chart-line me-2"></i> Dashboard
                    </a>
                </li>
                <div class="sidebar-label">Manajemen</div>
                <li class="nav-item">
                    <a class="nav-link <?= (url_is('admin/kegiatan*')) ? 'active' : '' ?>" href="<?= base_url('admin/kegiatan') ?>">
                        <i class="fas fa-tasks me-2"></i> Data Kegiatan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= (url_is('admin/kelola_kades*')) ? 'active' : '' ?>" href="<?= base_url('admin/kelola_kades') ?>">
                        <i class="fas fa-user-tie me-2"></i> Kelola Kepala Desa
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= (url_is('admin/verifikasi_user*')) ? 'active' : '' ?>" href="<?= base_url('admin/verifikasi_user') ?>">
                        <i class="fas fa-user-check me-2"></i> Verifikasi Akun
                    </a>
                </li>
                <div class="sidebar-label">Laporan</div>
                <li class="nav-item">
                    <a class="nav-link <?= (url_is('admin/print_laporan*')) ? 'active' : '' ?>" href="<?= base_url('admin/print_laporan') ?>">
                        <i class="fas fa-print me-2"></i> Cetak Laporan
                    </a>
                </li>
            <?php endif; ?>

            <?php if (session()->get('role') == 'kepala_desa') : ?>
                <li class="nav-item">
                    <a class="nav-link <?= (url_is('kades') || url_is('kades/index')) ? 'active' : '' ?>" href="<?= base_url('kades') ?>">
                        <i class="fas fa-chart-pie me-2"></i> Dashboard
                    </a>
                </li>
                <div class="sidebar-label">Otoritas Kades</div>
                <li class="nav-item">
                    <a class="nav-link <?= (url_is('kades/persetujuan*')) ? 'active' : '' ?>" href="<?= base_url('kades/persetujuan') ?>">
                        <i class="fas fa-file-signature me-2"></i> Persetujuan (ACC)
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= (url_is('kades/riwayat*')) ? 'active' : '' ?>" href="<?= base_url('kades/riwayat') ?>">
                        <i class="fas fa-history me-2"></i> Riwayat & Verifikasi
                    </a>
                </li>
            <?php endif; ?>

            <li class="nav-item mt-auto">
                <a class="nav-link btn-logout" href="javascript:void(0)" onclick="confirmLogout()">
                    <i class="fas fa-power-off me-2"></i> Keluar
                </a>
            </li>
        </ul>
    </div>
</div>

    <div class="content">
        <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
            <div class="container-fluid p-0">
                <div class="d-flex align-items-center">
                    <button class="btn btn-light border d-md-none me-3" id="mobile-toggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h6 class="fw-bold mb-0 text-dark d-none d-sm-block">Overview Sistem</h6>
                </div>
                
                <div class="d-flex align-items-center">
                    <div class="text-end me-3 d-none d-md-block">
                        <p class="mb-0 fw-bold small text-capitalize"><?= session()->get('nama') ?></p>
                        <p class="mb-0 text-muted small" style="font-size: 10px; font-weight: 600;"><?= strtoupper(session()->get('role')) ?></p>
                    </div>
                    <div class="dropdown">
                        <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://ui-avatars.com/api/?name=<?= session()->get('nama') ?>&background=10b981&color=fff&bold=true" class="user-profile-img shadow-sm">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 animate slideIn">
                            <li class="px-3 py-2 d-md-none border-bottom">
                                <p class="mb-0 fw-bold small text-capitalize"><?= session()->get('nama') ?></p>
                                <p class="mb-0 text-muted small" style="font-size: 10px;"><?= strtoupper(session()->get('role')) ?></p>
                            </li>
                            <li><a class="dropdown-item py-2" href="#"><i class="fas fa-user-circle me-2 text-muted"></i> Pengaturan Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item py-2 text-danger fw-bold" href="javascript:void(0)" onclick="confirmLogout()"><i class="fas fa-power-off me-2"></i> Keluar Aplikasi</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <div class="section-container">
            <?= $this->renderSection('content') ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Toggle Sidebar Mobile
    document.getElementById('mobile-toggle')?.addEventListener('click', function() {
        document.getElementById('sidebar').classList.toggle('active');
    });

    // Custom confirm Logout
    function confirmLogout() {
        Swal.fire({
            title: 'Akhiri Sesi?',
            text: "Anda akan keluar dari sistem Desa Digital Segarau Parit.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Ya, Keluar',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                confirmButton: 'rounded-pill px-4',
                cancelButton: 'rounded-pill px-4'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= base_url('auth/logout') ?>";
            }
        });
    }

    // Toast Flashdata
    document.addEventListener('DOMContentLoaded', function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });

        <?php if (session()->getFlashdata('success')): ?>
            Toast.fire({
                icon: 'success',
                title: '<?= session()->getFlashdata('success') ?>'
            });
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Opps!',
                text: '<?= session()->getFlashdata('error') ?>',
                confirmButtonColor: '#10b981'
            });
        <?php endif; ?>
    });
</script>

</body>
</html>