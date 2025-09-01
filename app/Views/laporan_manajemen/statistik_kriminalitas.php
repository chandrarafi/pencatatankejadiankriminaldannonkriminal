<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Statistik Kriminalitas<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Filter Section -->
<div class="row">
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-filter mr-2"></i>
                    Filter Statistik
                </h3>
                <div class="card-tools">
                    <?php if (!$isPrint): ?>
                        <a href="<?= current_url() ?>?print=1&tahun=<?= $tahun ?>" target="_blank" class="btn btn-success btn-sm">
                            <i class="fas fa-print mr-1"></i> Print
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" action="<?= current_url() ?>">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tahun">Tahun</label>
                                <select class="form-control" id="tahun" name="tahun">
                                    <?php for ($y = date('Y'); $y >= 2020; $y--): ?>
                                        <option value="<?= $y ?>" <?= $tahun == $y ? 'selected' : '' ?>><?= $y ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="submit">&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-search mr-1"></i> Filter
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Periode Laporan</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" value="Januari - Desember <?= $tahun ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if ($isPrint): ?>
    <!-- Print Header -->
    <div style="text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 20px;">
        <h2>STATISTIK KRIMINALITAS</h2>
        <h3>POLSEK LUNANG SILAUT</h3>
        <p>Periode: Januari - Desember <?= $tahun ?></p>
        <p>Dicetak pada: <?= date('d F Y, H:i') ?> WIB</p>
    </div>
<?php endif; ?>

<!-- Summary Statistics -->
<div class="row">
    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info">
                <i class="fas fa-chart-bar"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Total Jenis Kasus</span>
                <span class="info-box-number"><?= count($crimeByType) ?></span>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-success">
                <i class="fas fa-folder"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Total Kasus <?= $tahun ?></span>
                <span class="info-box-number"><?= array_sum(array_column($monthlyDistribution, 'count')) ?></span>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-warning">
                <i class="fas fa-map-marker-alt"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Lokasi Terdampak</span>
                <span class="info-box-number"><?= count($locationStats) ?></span>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-danger">
                <i class="fas fa-percentage"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Rata-rata Clearance</span>
                <span class="info-box-number"><?= count($clearanceByMonth) > 0 ? round(array_sum(array_column($clearanceByMonth, 'rate')) / count($clearanceByMonth), 1) : 0 ?>%</span>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row 1 -->
<div class="row">
    <!-- Monthly Distribution -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-line mr-2"></i>
                    Distribusi Kasus Bulanan <?= $tahun ?>
                </h3>
            </div>
            <div class="card-body">
                <canvas id="monthlyChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>

    <!-- Crime Types -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie mr-2"></i>
                    Top 5 Jenis Kasus
                </h3>
            </div>
            <div class="card-body">
                <canvas id="crimeTypeChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Detailed Statistics Tables -->
<div class="row">
    <!-- Crime by Type Table -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list mr-2"></i>
                    Rincian Jenis Kasus
                </h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Jenis Kasus</th>
                            <th>Kode</th>
                            <th>Jumlah</th>
                            <th>%</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalCases = array_sum(array_column($crimeByType, 'jumlah'));
                        foreach ($crimeByType as $index => $crime):
                        ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= $crime['nama_jenis'] ?: 'Tidak Dikategorikan' ?></td>
                                <td>
                                    <span class="badge badge-secondary"><?= $crime['kode_jenis'] ?: '-' ?></span>
                                </td>
                                <td>
                                    <span class="badge badge-primary"><?= $crime['jumlah'] ?></span>
                                </td>
                                <td>
                                    <?php $percentage = $totalCases > 0 ? round(($crime['jumlah'] / $totalCases) * 100, 1) : 0; ?>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-primary" style="width: <?= $percentage ?>%"></div>
                                    </div>
                                    <span class="badge badge-light"><?= $percentage ?>%</span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr class="bg-light">
                            <th colspan="3">TOTAL</th>
                            <th><span class="badge badge-dark"><?= $totalCases ?></span></th>
                            <th><span class="badge badge-dark">100%</span></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Location Statistics -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-map-marked-alt mr-2"></i>
                    Lokasi Kejadian Terbanyak
                </h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Lokasi</th>
                            <th>Jumlah</th>
                            <th>%</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalLocationCases = array_sum(array_column($locationStats, 'jumlah'));
                        foreach ($locationStats as $index => $location):
                        ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= $location['lokasi_kejadian'] ?></td>
                                <td>
                                    <span class="badge badge-warning"><?= $location['jumlah'] ?></span>
                                </td>
                                <td>
                                    <?php $percentage = $totalLocationCases > 0 ? round(($location['jumlah'] / $totalLocationCases) * 100, 1) : 0; ?>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-warning" style="width: <?= $percentage ?>%"></div>
                                    </div>
                                    <span class="badge badge-light"><?= $percentage ?>%</span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Clearance Rate Analysis -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-area mr-2"></i>
                    Analisis Tingkat Penyelesaian Kasus (Clearance Rate) <?= $tahun ?>
                </h3>
            </div>
            <div class="card-body">
                <canvas id="clearanceChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="alert alert-info">
                            <h5><i class="icon fas fa-info"></i> Interpretasi Tingkat Penyelesaian:</h5>
                            <ul class="mb-0">
                                <li><strong>Tinggi (≥80%):</strong> Kinerja sangat baik dalam penyelesaian kasus</li>
                                <li><strong>Sedang (60-79%):</strong> Kinerja baik, masih bisa ditingkatkan</li>
                                <li><strong>Rendah (<60%):< /strong> Perlu evaluasi dan perbaikan sistem investigasi</li>
                                <li><strong>Target Nasional:</strong> Minimum 70% tingkat penyelesaian kasus</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Executive Summary -->
<?php if ($isPrint): ?>
    <div style="page-break-before: always;">
        <h3 style="border-bottom: 2px solid #000; padding-bottom: 10px;">RINGKASAN EKSEKUTIF</h3>

        <div style="margin: 20px 0;">
            <h4>Temuan Utama:</h4>
            <ul>
                <li>Total kasus yang tercatat pada tahun <?= $tahun ?>: <strong><?= $totalCases ?> kasus</strong></li>
                <li>Jenis kasus terbanyak: <strong><?= $crimeByType[0]['nama_jenis'] ?? 'Tidak ada data' ?> (<?= $crimeByType[0]['jumlah'] ?? 0 ?> kasus)</strong></li>
                <li>Lokasi dengan kasus terbanyak: <strong><?= $locationStats[0]['lokasi_kejadian'] ?? 'Tidak ada data' ?> (<?= $locationStats[0]['jumlah'] ?? 0 ?> kasus)</strong></li>
                <li>Rata-rata tingkat penyelesaian: <strong><?= count($clearanceByMonth) > 0 ? round(array_sum(array_column($clearanceByMonth, 'rate')) / count($clearanceByMonth), 1) : 0 ?>%</strong></li>
            </ul>
        </div>

        <div style="margin: 20px 0;">
            <h4>Rekomendasi:</h4>
            <ol>
                <li>Peningkatan patroli di lokasi dengan tingkat kriminalitas tinggi</li>
                <li>Fokus pencegahan pada jenis kasus yang paling sering terjadi</li>
                <li>Evaluasi prosedur investigasi untuk meningkatkan clearance rate</li>
                <li>Koordinasi dengan instansi terkait untuk penanganan yang lebih efektif</li>
            </ol>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    $(document).ready(function() {
        // Monthly Distribution Chart
        const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
        const monthlyChart = new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: <?= json_encode(array_column($monthlyDistribution, 'month')) ?>,
                datasets: [{
                    label: 'Jumlah Kasus',
                    data: <?= json_encode(array_column($monthlyDistribution, 'count')) ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.8)',
                    borderColor: 'rgba(54, 162, 235, 1)',
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

        // Crime Type Chart (Top 5)
        const crimeTypeCtx = document.getElementById('crimeTypeChart').getContext('2d');
        const topCrimes = <?= json_encode(array_slice($crimeByType, 0, 5)) ?>;
        const crimeTypeChart = new Chart(crimeTypeCtx, {
            type: 'doughnut',
            data: {
                labels: topCrimes.map(crime => crime.nama_jenis || 'Tidak Dikategorikan'),
                datasets: [{
                    data: topCrimes.map(crime => crime.jumlah),
                    backgroundColor: [
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                        '#4BC0C0',
                        '#9966FF'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Clearance Rate Chart
        const clearanceCtx = document.getElementById('clearanceChart').getContext('2d');
        const clearanceChart = new Chart(clearanceCtx, {
            type: 'line',
            data: {
                labels: <?= json_encode(array_column($clearanceByMonth, 'month')) ?>,
                datasets: [{
                    label: 'Tingkat Penyelesaian (%)',
                    data: <?= json_encode(array_column($clearanceByMonth, 'rate')) ?>,
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.1,
                    fill: true
                }, {
                    label: 'Target (70%)',
                    data: Array(12).fill(70),
                    borderColor: 'rgb(255, 99, 132)',
                    backgroundColor: 'rgba(255, 99, 132, 0.1)',
                    borderDash: [5, 5],
                    fill: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    }
                }
            }
        });
    });
</script>
<?= $this->endSection() ?>
