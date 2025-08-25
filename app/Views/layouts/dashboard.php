<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Dashboard' ?> | Polsek Lunang Silaut</title>

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>vendor/almasaeed2010/adminlte/dist/css/adminlte.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css">
    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Source Sans Pro', sans-serif;
        }

        .brand-text {
            font-weight: 600 !important;
        }

        .nav-pills .nav-link.active {
            background-color: #007bff;
        }

        .card-primary.card-outline {
            border-top: 3px solid #007bff;
        }

        .content-header h1 {
            font-size: 1.8rem;
            font-weight: 600;
        }

        .small-box {
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .small-box:hover {
            transform: translateY(-5px);
        }

        .main-sidebar {
            box-shadow: 2px 0 6px rgba(0, 0, 0, 0.1);
        }

        /* Ensure content is properly centered within the AdminLTE layout */
        .content-wrapper {
            margin-left: 250px;
            /* Sidebar width */
        }

        .content {
            padding: 15px;
        }

        @media (max-width: 768px) {
            .content-wrapper {
                margin-left: 0;
            }
        }

        /* DataTables Custom Styling */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_processing,
        .dataTables_wrapper .dataTables_paginate {
            color: #6c757d;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.075);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.375rem 0.75rem;
            margin: 0 0.125rem;
            border-radius: 0.25rem;
        }

        .badge {
            font-size: 0.75em;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-user mr-2"></i>
                        <?= $user['fullname'] ?? 'User' ?>
                        <i class="fas fa-caret-down ml-1"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-header">
                            <strong><?= ucfirst($user['role'] ?? '') ?></strong><br>
                            <small><?= $user['nrp'] ?? '' ?></small>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-user mr-2"></i> Profile
                        </a>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-cog mr-2"></i> Settings
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="<?= base_url('auth/logout') ?>" class="dropdown-item text-danger">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>

        <!-- Main Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="<?= base_url('dashboard') ?>" class="brand-link">
                <i class="fas fa-shield-alt brand-image img-circle elevation-3 ml-3 mr-2" style="font-size: 2rem; color: #fff;"></i>
                <span class="brand-text font-weight-light">Polsek L. Silaut</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <div class="img-circle elevation-2" style="width: 2.1rem; height: 2.1rem; background: #6c757d; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-user text-white"></i>
                        </div>
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?= $user['fullname'] ?? 'User' ?></a>
                        <small class="text-muted"><?= ucfirst($user['role'] ?? '') ?></small>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="<?= base_url('dashboard') ?>" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <?php if ($role === 'spkt'): ?>
                            <li class="nav-header">SPKT MENU</li>
                            <li class="nav-item">
                                <a href="<?= base_url('spkt/pelapor') ?>" class="nav-link">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>Data Pelapor</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('spkt/jenis-kasus') ?>" class="nav-link">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>Jenis Kasus</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('spkt/kasus') ?>" class="nav-link">
                                    <i class="nav-icon fas fa-folder-open"></i>
                                    <p>Data Kasus</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('spkt/piket') ?>" class="nav-link">
                                    <i class="nav-icon fas fa-clock"></i>
                                    <p>Data Piket</p>
                                </a>
                            </li>
                        <?php elseif ($role === 'kasium'): ?>
                            <li class="nav-header">KASIUM MENU</li>
                            <li class="nav-item">
                                <a href="<?= base_url('kasium/anggota') ?>" class="nav-link">
                                    <i class="nav-icon fas fa-user-shield"></i>
                                    <p>Data Anggota</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('kasium/piket') ?>" class="nav-link">
                                    <i class="nav-icon fas fa-calendar-alt"></i>
                                    <p>Data Piket</p>
                                </a>
                            </li>
                        <?php elseif ($role === 'reskrim'): ?>
                            <li class="nav-header">RESKRIM MENU</li>
                            <li class="nav-item">
                                <a href="<?= base_url('reskrim/kasus') ?>" class="nav-link">
                                    <i class="nav-icon fas fa-folder-open"></i>
                                    <p>Data Kasus</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('reskrim/korban') ?>" class="nav-link">
                                    <i class="nav-icon fas fa-user-injured"></i>
                                    <p>Data Korban</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('reskrim/tersangka') ?>" class="nav-link">
                                    <i class="nav-icon fas fa-user-secret"></i>
                                    <p>Data Tersangka</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('reskrim/saksi') ?>" class="nav-link">
                                    <i class="nav-icon fas fa-eye"></i>
                                    <p>Data Saksi</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('reskrim/pelapor') ?>" class="nav-link">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>Data Pelapor</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('reskrim/piket') ?>" class="nav-link">
                                    <i class="nav-icon fas fa-clock"></i>
                                    <p>Data Piket</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('reskrim/laporan') ?>" class="nav-link">
                                    <i class="nav-icon fas fa-file-alt"></i>
                                    <p>Semua Laporan</p>
                                </a>
                            </li>
                        <?php elseif ($role === 'kapolsek'): ?>
                            <li class="nav-header">KAPOLSEK MENU</li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-file-alt"></i>
                                    <p>Semua Laporan</p>
                                </a>
                            </li>
                        <?php endif; ?>
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
                            <h1 class="m-0"><?= $title ?? 'Dashboard' ?></h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                                <li class="breadcrumb-item active"><?= $title ?? 'Dashboard' ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <?= $this->renderSection('content') ?>
                </div>
            </section>
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2025 <a href="#">Polsek Lunang Silaut</a>.</strong>
            Sistem Pencatatan Kejadian Kriminal dan Non-Kriminal.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.0
            </div>
        </footer>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>vendor/almasaeed2010/adminlte/dist/js/adminlte.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>

    <?= $this->renderSection('scripts') ?>
</body>

</html>