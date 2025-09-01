<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Dashboard Investigasi - RESKRIM<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Investigation Summary Cards -->
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3><?= number_format($totalInvestigasi) ?></h3>
                <p>Total Investigasi</p>
            </div>
            <div class="icon">
                <i class="fas fa-search"></i>
            </div>
            <a href="<?= base_url('reskrim/kasus') ?>" class="small-box-footer">
                Lihat Semua <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3><?= number_format($ongoingInvestigasi) ?></h3>
                <p>Sedang Diproses</p>
            </div>
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
            <a href="<?= base_url('laporan-manajemen/progress-investigasi') ?>" class="small-box-footer">
                Monitor Progress <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3><?= number_format($completedInvestigasi) ?></h3>
                <p>Diselesaikan</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <a href="#" class="small-box-footer">
                Kasus Selesai <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3><?= number_format($totalKorban + $totalTersangka + $totalSaksi) ?></h3>
                <p>Total Pihak Terlibat</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="#" class="small-box-footer">
                Detail Pihak <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>

<!-- Evidence and Persons Statistics -->
<div class="row">
    <div class="col-md-4">
        <div class="info-box">
            <span class="info-box-icon bg-success">
                <i class="fas fa-user-injured"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Total Korban</span>
                <span class="info-box-number"><?= number_format($totalKorban) ?></span>
                <div class="progress">
                    <div class="progress-bar bg-success" style="width: 100%"></div>
                </div>
                <span class="progress-description">
                    <a href="<?= base_url('reskrim/korban') ?>" class="text-success">Kelola Data Korban</a>
                </span>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="info-box">
            <span class="info-box-icon bg-warning">
                <i class="fas fa-user-secret"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Total Tersangka</span>
                <span class="info-box-number"><?= number_format($totalTersangka) ?></span>
                <div class="progress">
                    <div class="progress-bar bg-warning" style="width: 100%"></div>
                </div>
                <span class="progress-description">
                    <a href="<?= base_url('reskrim/tersangka') ?>" class="text-warning">Kelola Data Tersangka</a>
                </span>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="info-box">
            <span class="info-box-icon bg-info">
                <i class="fas fa-user-friends"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Total Saksi</span>
                <span class="info-box-number"><?= number_format($totalSaksi) ?></span>
                <div class="progress">
                    <div class="progress-bar bg-info" style="width: 100%"></div>
                </div>
                <span class="progress-description">
                    <a href="<?= base_url('reskrim/saksi') ?>" class="text-info">Kelola Data Saksi</a>
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Priority Cases and Workload -->
<div class="row">
    <!-- Case Priority Distribution -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Distribusi Prioritas Kasus Aktif
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="description-block border-right">
                            <span class="description-percentage text-danger">
                                <i class="fas fa-exclamation-triangle"></i> <?= $priorityStats['tinggi'] ?>
                            </span>
                            <h5 class="description-header"><?= $priorityStats['tinggi'] ?></h5>
                            <span class="description-text">PRIORITAS TINGGI</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="description-block border-right">
                            <span class="description-percentage text-warning">
                                <i class="fas fa-minus-circle"></i> <?= $priorityStats['sedang'] ?>
                            </span>
                            <h5 class="description-header"><?= $priorityStats['sedang'] ?></h5>
                            <span class="description-text">PRIORITAS SEDANG</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="description-block">
                            <span class="description-percentage text-success">
                                <i class="fas fa-circle"></i> <?= $priorityStats['rendah'] ?>
                            </span>
                            <h5 class="description-header"><?= $priorityStats['rendah'] ?></h5>
                            <span class="description-text">PRIORITAS RENDAH</span>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <canvas id="priorityChart" style="min-height: 200px; height: 200px; max-height: 200px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Investigator Workload -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user-tie mr-2"></i>
                    Beban Kerja Penyidik
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Penyidik</th>
                                <th>Kasus Aktif</th>
                                <th>Selesai</th>
                                <th>Performa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($investigatorWorkload as $investigator): ?>
                                <tr>
                                    <td><?= $investigator['nama'] ?></td>
                                    <td>
                                        <span class="badge badge-warning"><?= $investigator['active_cases'] ?></span>
                                    </td>
                                    <td>
                                        <span class="badge badge-success"><?= $investigator['completed_cases'] ?></span>
                                    </td>
                                    <td>
                                        <?php
                                        $total = $investigator['active_cases'] + $investigator['completed_cases'];
                                        $efficiency = $total > 0 ? round(($investigator['completed_cases'] / $total) * 100) : 0;
                                        ?>
                                        <div class="progress progress-xs">
                                            <div class="progress-bar progress-bar-<?= $efficiency >= 70 ? 'success' : ($efficiency >= 50 ? 'warning' : 'danger') ?>"
                                                style="width: <?= $efficiency ?>%"></div>
                                        </div>
                                        <span class="badge badge-secondary"><?= $efficiency ?>%</span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-history mr-2"></i>
                    Aktivitas Investigasi Terbaru
                </h3>
                <div class="card-tools">
                    <a href="<?= base_url('reskrim/kasus') ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-external-link-alt mr-1"></i> Lihat Semua
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Nomor Kasus</th>
                            <th>Judul Kasus</th>
                            <th>Jenis</th>
                            <th>Status</th>
                            <th>Last Update</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentActivities as $activity): ?>
                            <tr>
                                <td>
                                    <a href="<?= base_url('reskrim/kasus/show/' . $activity['id']) ?>" class="text-primary">
                                        <?= $activity['nomor_kasus'] ?>
                                    </a>
                                </td>
                                <td><?= substr($activity['judul_kasus'], 0, 50) . (strlen($activity['judul_kasus']) > 50 ? '...' : '') ?></td>
                                <td>
                                    <span class="badge badge-info"><?= $activity['nama_jenis'] ?: 'Tidak Dikategorikan' ?></span>
                                </td>
                                <td>
                                    <?php
                                    $statusClass = [
                                        'dalam_proses' => 'warning',
                                        'selesai' => 'success',
                                        'ditutup' => 'secondary'
                                    ];
                                    $statusText = [
                                        'dalam_proses' => 'Dalam Proses',
                                        'selesai' => 'Selesai',
                                        'ditutup' => 'Ditutup'
                                    ];
                                    $badgeClass = $statusClass[$activity['status']] ?? 'secondary';
                                    $statusLabel = $statusText[$activity['status']] ?? ucfirst($activity['status']);
                                    ?>
                                    <span class="badge badge-<?= $badgeClass ?>"><?= $statusLabel ?></span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <?= date('d/m/Y H:i', strtotime($activity['updated_at'])) ?>
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="<?= base_url('reskrim/kasus/show/' . $activity['id']) ?>"
                                            class="btn btn-info btn-sm" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url('surat/resume-kasus/' . $activity['id']) ?>"
                                            class="btn btn-success btn-sm" title="Resume" target="_blank">
                                            <i class="fas fa-file-medical"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Quick Investigation Tools -->
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-tools mr-2"></i>
                    Tools Investigasi Cepat
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <a href="<?= base_url('reskrim/korban/create') ?>" class="btn btn-success btn-block">
                            <i class="fas fa-user-injured mr-2"></i>
                            Tambah Korban
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a href="<?= base_url('reskrim/tersangka/create') ?>" class="btn btn-warning btn-block">
                            <i class="fas fa-user-secret mr-2"></i>
                            Tambah Tersangka
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a href="<?= base_url('reskrim/saksi/create') ?>" class="btn btn-info btn-block">
                            <i class="fas fa-user-friends mr-2"></i>
                            Tambah Saksi
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a href="<?= base_url('surat') ?>" class="btn btn-primary btn-block">
                            <i class="fas fa-file-contract mr-2"></i>
                            Generate BAP
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a href="<?= base_url('laporan-manajemen/progress-investigasi') ?>" class="btn btn-secondary btn-block">
                            <i class="fas fa-chart-line mr-2"></i>
                            Monitor Progress
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a href="<?= base_url('laporan-manajemen/statistik-kriminalitas') ?>" class="btn btn-dark btn-block">
                            <i class="fas fa-chart-bar mr-2"></i>
                            Statistik
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    $(document).ready(function() {
        // Priority Chart
        const priorityCtx = document.getElementById('priorityChart').getContext('2d');
        const priorityChart = new Chart(priorityCtx, {
            type: 'bar',
            data: {
                labels: ['Tinggi', 'Sedang', 'Rendah'],
                datasets: [{
                    label: 'Jumlah Kasus',
                    data: [
                        <?= $priorityStats['tinggi'] ?>,
                        <?= $priorityStats['sedang'] ?>,
                        <?= $priorityStats['rendah'] ?>
                    ],
                    backgroundColor: [
                        '#dc3545',
                        '#ffc107',
                        '#28a745'
                    ],
                    borderColor: [
                        '#dc3545',
                        '#ffc107',
                        '#28a745'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Auto refresh every 5 minutes
        setInterval(function() {
            location.reload();
        }, 300000); // 5 minutes
    });
</script>
<?= $this->endSection() ?>
