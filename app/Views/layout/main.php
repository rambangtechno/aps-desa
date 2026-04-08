<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Sistem Desa Digital</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root {
            --sidebar-bg: #1e293b;
            --sidebar-hover: #334155;
            --primary-blue: #0061f2;
            --accent-info: #0ea5e9;
        }

        body { 
            font-family: 'Inter', sans-serif; 
            background: #f1f5f9; 
            color: #1e293b;
        }

        /* Sidebar Modern */
        .sidebar { 
            min-width: 260px; 
            max-width: 260px; 
            background: var(--sidebar-bg); 
            color: #fff; 
            min-height: 100vh; 
            transition: all 0.3s;
            box-shadow: 4px 0 10px rgba(0,0,0,0.05);
        }

        .sidebar .brand-wrapper {
            padding: 30px 20px;
            background: rgba(0,0,0,0.1);
        }

        .sidebar .nav-link { 
            color: #94a3b8; 
            padding: 12px 25px; 
            margin: 4px 15px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            font-weight: 500;
            transition: 0.3s;
        }

        .sidebar .nav-link i {
            width: 25px;
            font-size: 1.1rem;
        }

        .sidebar .nav-link:hover { 
            color: #fff; 
            background: var(--sidebar-hover);
        }

        .sidebar .nav-link.active { 
            color: #fff; 
            background: var(--primary-blue);
            box-shadow: 0 4px 12px rgba(0, 97, 242, 0.3);
        }

        /* Navbar Content Area */
        .content { width: 100%; overflow-x: hidden; }

        .navbar-custom { 
            background: rgba(255, 255, 255, 0.8); 
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #e2e8f0;
            padding: 15px 30px;
        }

        .user-profile-img {
            width: 40px;
            height: 40px;
            border: 2px solid var(--primary-blue);
            padding: 2px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Responsive Mobile */
        @media (max-width: 768px) {
            .sidebar { margin-left: -260px; position: fixed; z-index: 1000; }
            .sidebar.active { margin-left: 0; }
        }

        .section-container {
            padding: 30px;
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="d-flex">
    <div class="sidebar" id="sidebar">
        <div class="brand-wrapper text-center">
            <h4 class="fw-bold mb-0">DESA<span class="text-info">DIGITAL</span></h4>
            <small class="text-white-50">Admin Panel </small>
        </div>
        
        <div class="mt-4">
            <nav class="nav flex-column">
                <a class="nav-link active" href="<?= base_url('dashboard') ?>">
                    <i class="fas fa-th-large me-2"></i> Dashboard
                </a>
                <a class="nav-link" href="#">
                    <i class="fas fa-calendar-check me-2"></i> Kegiatan Desa
                </a>
                <a class="nav-link" href="#">
                    <i class="fas fa-user-group me-2"></i> Data Penduduk
                </a>
                <a class="nav-link" href="#">
                    <i class="fas fa-chart-pie me-2"></i> Laporan
                </a>
                
                <div class="px-4 mt-5 mb-2 small text-uppercase text-white-50 fw-bold" style="letter-spacing: 1px;">Sistem</div>
                
                <a class="nav-link text-danger fw-bold" href="javascript:void(0)" id="btnLogout">
                    <i class="fas fa-power-off me-2"></i> Keluar
                </a>
            </nav>
        </div>
    </div>

    <div class="content">
        <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
            <div class="container-fluid p-0">
                <div class="d-flex align-items-center">
                    <button class="btn btn-light d-md-none me-3" id="mobile-toggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h5 class="fw-bold mb-0 d-none d-sm-block">Ringkasan Sistem</h5>
                </div>
                
                <div class="d-flex align-items-center">
                    <div class="text-end me-3 d-none d-md-block">
                        <p class="mb-0 fw-bold small"><?= session()->get('nama') ?></p>
                        <p class="mb-0 text-muted small text-uppercase" style="font-size: 10px;"><?= session()->get('role') ?? 'Administrator' ?></p>
                    </div>
                    <div class="dropdown">
                        <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://ui-avatars.com/api/?name=<?= session()->get('nama') ?>&background=0061f2&color=fff&bold=true" class="user-profile-img">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li><a class="dropdown-item py-2" href="#"><i class="fas fa-user-cog me-2"></i> Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item py-2 text-danger fw-bold" href="javascript:void(0)" onclick="confirmLogout()"><i class="fas fa-power-off me-2"></i> Keluar</a></li>
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

    // Fitur Konfirmasi Logout (Fungsi Global)
    function confirmLogout() {
        Swal.fire({
            title: 'Konfirmasi Keluar',
            text: "Apakah Anda yakin ingin mengakhiri sesi ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0061f2',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Keluar!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= base_url('logout') ?>";
            }
        });
    }

    // Listener untuk tombol logout di sidebar
    document.getElementById('btnLogout')?.addEventListener('click', confirmLogout);

    // SweetAlert Flashdata Handling
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (session()->getFlashdata('success')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= session()->getFlashdata('success') ?>',
                timer: 2500,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '<?= session()->getFlashdata('error') ?>',
                confirmButtonColor: '#1e293b'
            });
        <?php endif; ?>
    });
</script>

</body>
</html>