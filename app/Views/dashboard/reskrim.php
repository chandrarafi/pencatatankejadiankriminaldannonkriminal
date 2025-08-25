<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<!-- Info boxes -->
<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1">
                <i class="fas fa-folder-open"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Total Kasus</span>
                <span class="info-box-number">
                    <?= $stats['total_kasus'] ?>
                    <small>Kasus</small>
                </span>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1">
                <i class="fas fa-user-secret"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Tersangka</span>
                <span class="info-box-number">
                    <?= $stats['total_tersangka'] ?>
                    <small>Orang</small>
                </span>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1">
                <i class="fas fa-user-injured"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Korban</span>
                <span class="info-box-number">
                    <?= $stats['total_korban'] ?>
                    <small>Orang</small>
                </span>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1">
                <i class="fas fa-eye"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Saksi</span>
                <span class="info-box-number">
                    <?= $stats['total_saksi'] ?>
                    <small>Orang</small>
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Secondary Info -->
<div class="row">
    <div class="col-12 col-sm-6 col-md-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3><?= $stats['laporan_bulan_ini'] ?></h3>
                <p>Laporan Bulan Ini</p>
            </div>
            <div class="icon">
                <i class="fas fa-file-alt"></i>
            </div>
            <a href="#" class="small-box-footer">
                Lihat Detail <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-6">
        <div class="small-box bg-gradient-info">
            <div class="inner">
                <h3>95<sup style="font-size: 20px">%</sup></h3>
                <p>Tingkat Penyelesaian</p>
            </div>
            <div class="icon">
                <i class="fas fa-chart-pie"></i>
            </div>
            <a href="#" class="small-box-footer">
                Lihat Statistik <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>

<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-lg-8 connectedSortable">
        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-bolt mr-1"></i>
                    Aksi Cepat
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <a href="#" class="btn btn-app bg-success">
                            <i class="fas fa-user-plus"></i> Tambah Tersangka
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="#" class="btn btn-app bg-warning">
                            <i class="fas fa-user-injured"></i> Tambah Korban
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="#" class="btn btn-app bg-info">
                            <i class="fas fa-eye"></i> Tambah Saksi
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="#" class="btn btn-app bg-primary">
                            <i class="fas fa-folder-open"></i> Lihat Kasus
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="#" class="btn btn-app bg-secondary">
                            <i class="fas fa-users"></i> Lihat Pelapor
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="#" class="btn btn-app bg-dark">
                            <i class="fas fa-file-alt"></i> Semua Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kasus dalam Penanganan -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-folder-open mr-1"></i>
                    Kasus dalam Penanganan
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No. Kasus</th>
                                <th>Jenis</th>
                                <th>Status</th>
                                <th>Tersangka</th>
                                <th>Korban</th>
                                <th>Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                    Belum ada kasus dalam penanganan
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Laporan Terbaru -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-file-alt mr-1"></i>
                    Laporan Terbaru
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="time-label">
                        <span class="bg-red">Belum ada laporan</span>
                    </div>
                    <div>
                        <div class="timeline-item">
                            <span class="time"><i class="fas fa-clock"></i> -</span>
                            <h3 class="timeline-header">Sistem siap menerima laporan</h3>
                            <div class="timeline-body">
                                Silakan mulai menambahkan data kasus, tersangka, korban, dan saksi.
                            </div>
                        </div>
                    </div>
                    <div>
                        <i class="fas fa-clock bg-gray"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Right col -->
    <section class="col-lg-4 connectedSortable">
        <!-- Status Kasus Chart -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie mr-1"></i>
                    Status Kasus
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <canvas id="statusChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                <div class="mt-3">
                    <div class="row">
                        <div class="col-6">
                            <div class="description-block border-right">
                                <span class="description-percentage text-success">
                                    <i class="fas fa-caret-up"></i> 0%
                                </span>
                                <h5 class="description-header">0</h5>
                                <span class="description-text">SELESAI</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="description-block">
                                <span class="description-percentage text-warning">
                                    <i class="fas fa-caret-left"></i> 0%
                                </span>
                                <h5 class="description-header">0</h5>
                                <span class="description-text">PROSES</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Prioritas Kasus -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-exclamation-triangle mr-1"></i>
                    Kasus Prioritas
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <ul class="products-list product-list-in-card pl-2 pr-2">
                    <li class="item text-center py-4">
                        <div class="text-muted">
                            <i class="fas fa-clipboard-list fa-2x mb-2"></i><br>
                            Belum ada kasus prioritas
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Target Bulanan -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-bullseye mr-1"></i>
                    Target Bulanan
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="progress-group">
                    Penyelesaian Kasus
                    <span class="float-right"><b>0</b>/10</span>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-primary" style="width: 0%"></div>
                    </div>
                </div>
                <div class="progress-group">
                    Input Data Tersangka
                    <span class="float-right"><b>0</b>/15</span>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-danger" style="width: 0%"></div>
                    </div>
                </div>
                <div class="progress-group">
                    Verifikasi Laporan
                    <span class="float-right"><b>0</b>/20</span>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-success" style="width: 0%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Piket -->
        <div class="card bg-gradient-info">
            <div class="card-header border-0">
                <h3 class="card-title">
                    <i class="fas fa-clock"></i>
                    Info Piket Hari Ini
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="text-center text-white">
                    <h5>Shift Saat Ini</h5>
                    <h3>Pagi (08:00 - 16:00)</h3>
                    <p class="mb-0">Petugas: Belum ada data</p>
                </div>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function() {
        console.log('Reskrim Dashboard loaded');

        // Initialize Status Chart
        var ctx = document.getElementById('statusChart').getContext('2d');
        var statusChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Selesai', 'Dalam Proses', 'Pending'],
                datasets: [{
                    data: [0, 0, 0],
                    backgroundColor: ['#28a745', '#ffc107', '#dc3545'],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom'
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    }
                }
            }
        });

        // Handle quick action clicks
        $('.btn-app, .small-box-footer').on('click', function(e) {
            e.preventDefault();

            Swal.fire({
                icon: 'info',
                title: 'Fitur Akan Segera Tersedia',
                text: 'Fitur ini sedang dalam tahap pengembangan.',
                confirmButtonColor: '#007bff'
            });
        });
    });
</script>
<?= $this->endSection() ?>

