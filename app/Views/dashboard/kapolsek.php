<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<!-- Info boxes -->
<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-primary elevation-1">
                <i class="fas fa-file-alt"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Total Laporan</span>
                <span class="info-box-number">
                    <?= $stats['total_laporan'] ?>
                    <small>Laporan</small>
                </span>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1">
                <i class="fas fa-check-circle"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Selesai</span>
                <span class="info-box-number">
                    <?= $stats['laporan_selesai'] ?>
                    <small>Laporan</small>
                </span>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1">
                <i class="fas fa-hourglass-half"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Dalam Proses</span>
                <span class="info-box-number">
                    <?= $stats['laporan_proses'] ?>
                    <small>Laporan</small>
                </span>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1">
                <i class="fas fa-clock"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Pending</span>
                <span class="info-box-number">
                    <?= $stats['laporan_pending'] ?>
                    <small>Laporan</small>
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-lg-8 connectedSortable">
        <!-- Overview Cards -->
        <div class="row">
            <div class="col-md-6">
                <div class="small-box bg-gradient-primary">
                    <div class="inner">
                        <h3>100<sup style="font-size: 20px">%</sup></h3>
                        <p>Transparansi Laporan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        Lihat Semua Laporan <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="small-box bg-gradient-success">
                    <div class="inner">
                        <h3>95<sup style="font-size: 20px">%</sup></h3>
                        <p>Tingkat Penyelesaian</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        Lihat Statistik <i class="fas fa-arrow-circle-right"></i>
                    </a>
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
                    <div class="btn-group">
                        <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                            <i class="fas fa-filter"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" role="menu">
                            <a href="#" class="dropdown-item">Semua Status</a>
                            <a href="#" class="dropdown-item">Selesai</a>
                            <a href="#" class="dropdown-item">Dalam Proses</a>
                            <a href="#" class="dropdown-item">Pending</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No. Laporan</th>
                                <th>Tanggal</th>
                                <th>Jenis Kasus</th>
                                <th>Pelapor</th>
                                <th>Status</th>
                                <th>Petugas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                    Belum ada laporan yang masuk
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Statistik Bulanan -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-bar mr-1"></i>
                    Statistik Laporan Bulanan
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <canvas id="monthlyChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
            </div>
        </div>
    </section>

    <!-- Right col -->
    <section class="col-lg-4 connectedSortable">
        <!-- Status Overview -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie mr-1"></i>
                    Overview Status
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <canvas id="statusOverview" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                <div class="mt-3">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="description-block">
                                <h5 class="description-header text-success">0</h5>
                                <span class="description-text">SELESAI</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="description-block">
                                <h5 class="description-header text-warning">0</h5>
                                <span class="description-text">PROSES</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="description-block">
                                <h5 class="description-header text-danger">0</h5>
                                <span class="description-text">PENDING</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Unit -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-trophy mr-1"></i>
                    Performa Unit
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="progress-group">
                    SPKT (Pelayanan)
                    <span class="float-right"><b>85</b>%</span>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-primary" style="width: 85%"></div>
                    </div>
                </div>
                <div class="progress-group">
                    Kasium (Administrasi)
                    <span class="float-right"><b>92</b>%</span>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-success" style="width: 92%"></div>
                    </div>
                </div>
                <div class="progress-group">
                    Reskrim (Penyelidikan)
                    <span class="float-right"><b>78</b>%</span>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-warning" style="width: 78%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-cog mr-1"></i>
                    Aksi Cepat
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <a href="#" class="btn btn-primary btn-block mb-2">
                    <i class="fas fa-download mr-2"></i>Unduh Laporan
                </a>
                <a href="#" class="btn btn-info btn-block mb-2">
                    <i class="fas fa-print mr-2"></i>Cetak Statistik
                </a>
                <a href="#" class="btn btn-warning btn-block mb-2">
                    <i class="fas fa-chart-line mr-2"></i>Analisis Trend
                </a>
                <a href="#" class="btn btn-success btn-block">
                    <i class="fas fa-file-export mr-2"></i>Export Data
                </a>
            </div>
        </div>

        <!-- Informasi Penting -->
        <div class="card bg-gradient-warning">
            <div class="card-header border-0">
                <h3 class="card-title">
                    <i class="fas fa-exclamation-triangle"></i>
                    Perhatian
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="callout callout-warning">
                    <h6>Laporan Mendesak</h6>
                    <p>Saat ini tidak ada laporan yang memerlukan perhatian khusus.</p>
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
        console.log('Kapolsek Dashboard loaded');

        // Initialize Status Overview Chart
        var ctx1 = document.getElementById('statusOverview').getContext('2d');
        var statusOverview = new Chart(ctx1, {
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
                    display: false
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Initialize Monthly Chart
        var ctx2 = document.getElementById('monthlyChart').getContext('2d');
        var monthlyChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Laporan Masuk',
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                    backgroundColor: 'rgba(54, 162, 235, 0.8)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }, {
                    label: 'Laporan Selesai',
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                    backgroundColor: 'rgba(40, 167, 69, 0.8)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Handle action clicks
        $('.btn, .small-box-footer').on('click', function(e) {
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

