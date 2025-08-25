<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<!-- Info boxes -->
<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-primary elevation-1">
                <i class="fas fa-user-shield"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Total Anggota</span>
                <span class="info-box-number">
                    <?= $stats['total_anggota'] ?>
                    <small>Orang</small>
                </span>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1">
                <i class="fas fa-user-check"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Anggota Aktif</span>
                <span class="info-box-number">
                    <?= $stats['anggota_aktif'] ?>
                    <small>Orang</small>
                </span>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-info elevation-1">
                <i class="fas fa-calendar-alt"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Piket Hari Ini</span>
                <span class="info-box-number">
                    <?= $stats['piket_hari_ini'] ?>
                    <small>Jadwal</small>
                </span>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1">
                <i class="fas fa-clock"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Total Piket</span>
                <span class="info-box-number">
                    <?= $stats['total_piket'] ?>
                    <small>Jadwal</small>
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-lg-8 connectedSortable">


        <!-- Daftar Anggota Terbaru -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-users mr-1"></i>
                    Anggota Terbaru
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
                                <th>NRP</th>
                                <th>Nama</th>
                                <th>Pangkat</th>
                                <th>Jabatan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($recent_anggota)): ?>
                                <?php foreach ($recent_anggota as $anggota): ?>
                                    <tr>
                                        <td><?= $anggota['nrp'] ?></td>
                                        <td>
                                            <strong><?= $anggota['nama'] ?></strong>
                                        </td>
                                        <td><?= $anggota['pangkat'] ?></td>
                                        <td><?= $anggota['jabatan'] ?></td>
                                        <td>
                                            <?php
                                            $statusClass = [
                                                'aktif' => 'success',
                                                'non_aktif' => 'warning',
                                                'pensiun' => 'secondary',
                                                'mutasi' => 'info'
                                            ];
                                            $statusText = [
                                                'aktif' => 'Aktif',
                                                'non_aktif' => 'Non Aktif',
                                                'pensiun' => 'Pensiun',
                                                'mutasi' => 'Mutasi'
                                            ];
                                            ?>
                                            <span class="badge badge-<?= $statusClass[$anggota['status']] ?? 'light' ?>">
                                                <?= $statusText[$anggota['status']] ?? ucfirst($anggota['status']) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                        Belum ada data anggota
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($recent_anggota)): ?>
                    <div class="card-footer text-center">
                        <a href="<?= base_url('kasium/anggota') ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-eye mr-1"></i> Lihat Semua Anggota
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Jadwal Piket Minggu Ini -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-calendar-week mr-1"></i>
                    Jadwal Piket Minggu Ini
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Hari</th>
                                <th>Shift Pagi</th>
                                <th>Shift Siang</th>
                                <th>Shift Malam</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $namaHari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                            $hariUrutan = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

                            foreach ($hariUrutan as $hari):
                                $jadwal = $jadwal_harian[$hari] ?? null;
                            ?>
                                <tr>
                                    <td>
                                        <strong><?= $hari ?></strong>
                                        <?php if ($jadwal): ?>
                                            <br><small class="text-muted"><?= date('d/m', strtotime($jadwal['tanggal'])) ?></small>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Shift Pagi -->
                                    <td class="text-center">
                                        <?php if ($jadwal && !empty($jadwal['pagi'])): ?>
                                            <?php foreach ($jadwal['pagi'] as $piket): ?>
                                                <div class="mb-1">
                                                    <small class="badge badge-warning">
                                                        <?= count($piket['anggota']) ?> orang
                                                    </small>
                                                    <br>
                                                    <small><?= $piket['jam_mulai'] ?>-<?= $piket['jam_selesai'] ?></small>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Shift Siang -->
                                    <td class="text-center">
                                        <?php if ($jadwal && !empty($jadwal['siang'])): ?>
                                            <?php foreach ($jadwal['siang'] as $piket): ?>
                                                <div class="mb-1">
                                                    <small class="badge badge-info">
                                                        <?= count($piket['anggota']) ?> orang
                                                    </small>
                                                    <br>
                                                    <small><?= $piket['jam_mulai'] ?>-<?= $piket['jam_selesai'] ?></small>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Shift Malam -->
                                    <td class="text-center">
                                        <?php if ($jadwal && !empty($jadwal['malam'])): ?>
                                            <?php foreach ($jadwal['malam'] as $piket): ?>
                                                <div class="mb-1">
                                                    <small class="badge badge-dark">
                                                        <?= count($piket['anggota']) ?> orang
                                                    </small>
                                                    <br>
                                                    <small><?= $piket['jam_mulai'] ?>-<?= $piket['jam_selesai'] ?></small>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (empty($piket_minggu_ini)): ?>
                    <div class="text-center mt-3">
                        <small class="text-muted">Belum ada jadwal piket minggu ini</small>
                    </div>
                <?php else: ?>
                    <div class="text-center mt-3">
                        <a href="<?= base_url('kasium/piket') ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-eye mr-1"></i> Lihat Semua Jadwal
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Right col -->
    <section class="col-lg-4 connectedSortable">
        <!-- Progress Administrasi -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-tasks mr-1"></i>
                    Progress Administrasi
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <?php
                // Calculate progress percentages
                $totalAnggota = max($stats['total_anggota'], 1); // Avoid division by zero
                $anggotaAktifPct = round(($stats['anggota_aktif'] / $totalAnggota) * 100);

                $totalPiket = max($stats['total_piket'], 1);
                $piketSelesaiPct = round(($stats['piket_selesai'] / $totalPiket) * 100);

                $piketBulanIniPct = min(round(($stats['piket_bulan_ini'] / 30) * 100), 100); // Max 30 days per month
                ?>

                <div class="progress-group">
                    Data Anggota Aktif
                    <span class="float-right"><b><?= $anggotaAktifPct ?></b>%</span>
                    <div class="progress progress-sm">
                        <div class="progress-bar <?= $anggotaAktifPct >= 80 ? 'bg-success' : ($anggotaAktifPct >= 60 ? 'bg-warning' : 'bg-danger') ?>"
                            style="width: <?= $anggotaAktifPct ?>%"></div>
                    </div>
                    <small class="text-muted"><?= $stats['anggota_aktif'] ?> dari <?= $stats['total_anggota'] ?> anggota</small>
                </div>

                <div class="progress-group">
                    Piket Selesai
                    <span class="float-right"><b><?= $piketSelesaiPct ?></b>%</span>
                    <div class="progress progress-sm">
                        <div class="progress-bar <?= $piketSelesaiPct >= 80 ? 'bg-success' : ($piketSelesaiPct >= 60 ? 'bg-warning' : 'bg-danger') ?>"
                            style="width: <?= $piketSelesaiPct ?>%"></div>
                    </div>
                    <small class="text-muted"><?= $stats['piket_selesai'] ?> dari <?= $stats['total_piket'] ?> jadwal</small>
                </div>

                <div class="progress-group">
                    Jadwal Bulan Ini
                    <span class="float-right"><b><?= $piketBulanIniPct ?></b>%</span>
                    <div class="progress progress-sm">
                        <div class="progress-bar <?= $piketBulanIniPct >= 80 ? 'bg-success' : ($piketBulanIniPct >= 60 ? 'bg-warning' : 'bg-danger') ?>"
                            style="width: <?= $piketBulanIniPct ?>%"></div>
                    </div>
                    <small class="text-muted"><?= $stats['piket_bulan_ini'] ?> jadwal terjadwal</small>
                </div>
            </div>
        </div>

        <!-- Informasi Penting -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-bullhorn mr-1"></i>
                    Informasi Penting
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle mr-2"></i>Pengingat</h6>
                    <p class="mb-0">Jangan lupa untuk memperbarui jadwal piket setiap awal bulan.</p>
                </div>
                <div class="alert alert-warning">
                    <h6><i class="fas fa-exclamation-triangle mr-2"></i>Perhatian</h6>
                    <p class="mb-0">Pastikan data anggota selalu terupdate untuk keperluan administrasi.</p>
                </div>
            </div>
        </div>

        <!-- Kalender Kecil -->
        <div class="card bg-gradient-primary">
            <div class="card-header border-0">
                <h3 class="card-title">
                    <i class="far fa-calendar-alt"></i>
                    Kalender
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="text-center">
                    <h4 class="text-white"><?= date('d') ?></h4>
                    <p class="text-white"><?= date('F Y') ?></p>
                    <small class="text-white"><?= date('l') ?></small>
                </div>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Initialize any dashboard-specific scripts here
        console.log('Kasium Dashboard loaded');

        // Handle quick action clicks
        $('.btn-app').on('click', function(e) {
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