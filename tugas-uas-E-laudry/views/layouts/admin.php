<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $pageTitle ?? 'Laundry Tunas Bangsa' ?> | Laundry Tunas Bangsa</title>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --danger-gradient: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%);
            --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }
        
        .main-sidebar {
            background: linear-gradient(180deg, #1e1e2d 0%, #1a1a27 100%);
        }
        
        .brand-link {
            background: rgba(255,255,255,0.05);
            border-bottom: 1px solid rgba(255,255,255,0.1) !important;
        }
        
        .brand-text {
            font-weight: 700;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .nav-sidebar .nav-link {
            border-radius: 8px;
            margin: 2px 8px;
            transition: all 0.3s ease;
        }
        
        .nav-sidebar .nav-link:hover {
            background: rgba(255,255,255,0.1);
        }
        
        .nav-sidebar .nav-link.active {
            background: var(--primary-gradient) !important;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        .content-wrapper {
            background: #f4f6f9;
        }
        
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            box-shadow: 0 5px 25px rgba(0,0,0,0.1);
        }
        
        .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        
        .small-box {
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .small-box:hover {
            transform: translateY(-5px);
        }
        
        .small-box.bg-info {
            background: var(--info-gradient) !important;
        }
        
        .small-box.bg-success {
            background: var(--secondary-gradient) !important;
        }
        
        .small-box.bg-warning {
            background: var(--warning-gradient) !important;
        }
        
        .small-box.bg-danger {
            background: var(--danger-gradient) !important;
        }
        
        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        
        .btn-primary:hover {
            background: var(--primary-gradient);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            transform: translateY(-2px);
        }
        
        .btn-success {
            background: var(--secondary-gradient);
            border: none;
            box-shadow: 0 4px 15px rgba(17, 153, 142, 0.3);
        }
        
        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
        }
        
        .table th {
            background: #f8f9fa;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
        }
        
        .form-control {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
        }
        
        .page-item.active .page-link {
            background: var(--primary-gradient);
            border-color: transparent;
        }
        
        .status-timeline {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin: 20px 0;
        }
        
        .status-timeline::before {
            content: '';
            position: absolute;
            top: 15px;
            left: 0;
            right: 0;
            height: 3px;
            background: #e0e0e0;
            z-index: 1;
        }
        
        .status-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
        }
        
        .status-step .step-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-bottom: 8px;
            transition: all 0.3s ease;
        }
        
        .status-step.active .step-icon {
            background: var(--primary-gradient);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        .status-step.completed .step-icon {
            background: var(--secondary-gradient);
        }
        
        .status-step .step-label {
            font-size: 11px;
            color: #888;
            text-align: center;
        }
        
        .status-step.active .step-label,
        .status-step.completed .step-label {
            color: #333;
            font-weight: 600;
        }
        
        .invoice-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
        }
        
        .invoice-box h2 {
            margin: 0;
            font-size: 14px;
            opacity: 0.8;
        }
        
        .invoice-box h1 {
            margin: 5px 0 0;
            font-size: 24px;
            font-weight: 700;
        }
        
        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fas fa-user-circle mr-1"></i>
                    <?= Session::get('user_name', 'User') ?>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <span class="dropdown-item-text text-muted">
                        <small><?= ucfirst(Session::get('user_role', '')) ?></small>
                    </span>
                    <div class="dropdown-divider"></div>
                    <a href="<?= BASE_URL ?>/auth/logout" class="dropdown-item text-danger">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </a>
                </div>
            </li>
        </ul>
    </nav>

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="<?= BASE_URL ?>/dashboard" class="brand-link text-center">
            <span class="brand-text font-weight-bold">
                <i class="fas fa-tshirt mr-2"></i>Laundry Tunas Bangsa
            </span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-3">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <li class="nav-item">
                        <a href="<?= BASE_URL ?>/dashboard" class="nav-link <?= ($activeMenu ?? '') === 'dashboard' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    
                    <li class="nav-header">TRANSAKSI</li>
                    <li class="nav-item">
                        <a href="<?= BASE_URL ?>/transaction/create" class="nav-link <?= ($activeMenu ?? '') === 'transaction-create' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-plus-circle"></i>
                            <p>Transaksi Baru</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= BASE_URL ?>/transaction" class="nav-link <?= ($activeMenu ?? '') === 'transactions' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-receipt"></i>
                            <p>Daftar Transaksi</p>
                        </a>
                    </li>
                    
                    <li class="nav-header">MASTER DATA</li>
                    <li class="nav-item">
                        <a href="<?= BASE_URL ?>/package" class="nav-link <?= ($activeMenu ?? '') === 'packages' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-box"></i>
                            <p>Data Paket</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= BASE_URL ?>/customer" class="nav-link <?= ($activeMenu ?? '') === 'customers' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Data Pelanggan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= BASE_URL ?>/promo" class="nav-link <?= ($activeMenu ?? '') === 'promos' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-tags"></i>
                            <p>Kode Promo</p>
                        </a>
                    </li>
                    
                    <?php if (Session::isAdmin()): ?>
                    <li class="nav-header">PENGATURAN</li>
                    <li class="nav-item">
                        <a href="<?= BASE_URL ?>/user" class="nav-link <?= ($activeMenu ?? '') === 'users' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-user-cog"></i>
                            <p>Manajemen User</p>
                        </a>
                    </li>
                    <?php endif; ?>
                    
                    <li class="nav-header">LAINNYA</li>
                    <li class="nav-item">
                        <a href="<?= BASE_URL ?>/tracking" class="nav-link" target="_blank">
                            <i class="nav-icon fas fa-search"></i>
                            <p>Lacak Laundry <i class="fas fa-external-link-alt ml-1 small"></i></p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><?= $pageTitle ?? 'Dashboard' ?></h1>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <?php
                // Flash messages
                $flash = Session::getAllFlash();
                if (!empty($flash)):
                    foreach ($flash as $type => $message):
                ?>
                <div class="alert alert-<?= $type === 'error' ? 'danger' : $type ?> alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?= $message ?>
                </div>
                <?php 
                    endforeach;
                endif;
                ?>
                
                <?= $content ?>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 1.0.0
        </div>
        <strong>&copy; <?= date('Y') ?> Laundry Tunas Bangsa</strong> - Sistem Manajemen Laundry
    </footer>
</div>

<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize DataTables
    if ($.fn.DataTable) {
        $('.datatable').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            }
        });
    }
    
    // Initialize Select2
    if ($.fn.select2) {
        $('.select2').select2({
            theme: 'bootstrap4'
        });
    }
    
    // Confirm delete
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });
});

// Format currency
function formatRupiah(angka) {
    return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
</script>
</body>
</html>
