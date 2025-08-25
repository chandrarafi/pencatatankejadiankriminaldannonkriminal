<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Detail Piket<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Alert Messages -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle mr-2"></i>
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle mr-2"></i>
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<div class="row">
    <!-- Profile Card -->
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <div class="profile-user-img img-fluid img-circle d-flex align-items-center justify-content-center rounded-circle"
                        style="width: 150px; height: 150px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: 3px solid #dee2e6; margin: 0 auto;">
                        <i class="fas fa-calendar-alt fa-4x text-white"></i>
                    </div>
                </div>

                <h3 class="profile-username text-center">
                    Piket Polsek
                </h3>

                <p class="text-muted text-center">
                    <?php
                    $tanggalPiket = date_create($piket['tanggal_piket']);
                    if ($tanggalPiket) {
                        echo $tanggalPiket->format('d F Y');
                    }
                    ?>
                </p>

                <div class="text-center mb-3">
                    <?php
                    $statusClass = [
                        'draft' => 'secondary',
                        'aktif' => 'success',
                        'selesai' => 'primary',
                        'dibatalkan' => 'danger'
                    ];
                    $statusText = [
                        'draft' => 'Draft',
                        'aktif' => 'Aktif',
                        'selesai' => 'Selesai',
                        'dibatalkan' => 'Dibatalkan'
                    ];
                    $badgeClass = $statusClass[$piket['status'] ?? 'draft'] ?? 'secondary';
                    $statusLabel = $statusText[$piket['status'] ?? 'draft'] ?? 'Draft';
                    ?>
                    <span class="badge badge-<?= $badgeClass ?> badge-lg">
                        <i class="fas fa-info-circle mr-1"></i> <?= $statusLabel ?>
                    </span>
                    <span class="badge badge-info badge-lg ml-2">
                        <i class="fas fa-eye mr-1"></i> Read Only - RESKRIM
                    </span>
                </div>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b><i class="fas fa-clock mr-1"></i> Shift</b>
                        <span class="float-right">
                            <?php
                            $shiftClass = [
                                'pagi' => 'info',
                                'siang' => 'warning',
                                'malam' => 'dark'
                            ];
                            $shiftBadge = $shiftClass[strtolower($piket['shift'])] ?? 'secondary';
                            ?>
                            <span class="badge badge-<?= $shiftBadge ?>"><?= ucfirst($piket['shift']) ?></span>
                        </span>
                    </li>
                    <li class="list-group-item">
                        <b><i class="fas fa-map-marker-alt mr-1"></i> Lokasi</b>
                        <span class="float-right"><?= esc($piket['lokasi_piket'] ?? '-') ?></span>
                    </li>
                    <li class="list-group-item">
                        <b><i class="fas fa-calendar mr-1"></i> Tanggal</b>
                        <span class="float-right"><?= date('d/m/Y', strtotime($piket['tanggal_piket'])) ?></span>
                    </li>
                    <li class="list-group-item">
                        <b><i class="fas fa-clock-o mr-1"></i> Waktu</b>
                        <span class="float-right">
                            <?= date('H:i', strtotime($piket['jam_mulai'])) ?> -
                            <?= date('H:i', strtotime($piket['jam_selesai'])) ?> WIB
                        </span>
                    </li>
                </ul>

                <div class="text-center">
                    <a href="<?= base_url('reskrim/piket') ?>" class="btn btn-default">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Information -->
    <div class="col-md-8">
        <!-- Anggota Piket Card -->
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-users mr-2"></i>
                    Anggota Piket
                </h3>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle mr-2"></i>
                    <strong>Akses Read-Only RESKRIM:</strong>
                    Data ini berasal dari Kasium. Untuk mengedit data piket, hubungi bagian Kasium.
                </div>

                <?php if (isset($anggotaPiket) && !empty($anggotaPiket)): ?>
                    <div class="row">
                        <?php foreach ($anggotaPiket as $anggota): ?>
                            <div class="col-md-6 mb-3">
                                <div class="card card-outline">
                                    <div class="card-body p-3">
                                        <div class="media">
                                            <div class="profile-user-img img-fluid img-circle bg-primary d-flex align-items-center justify-content-center mr-3"
                                                style="width: 50px; height: 50px; font-size: 20px; color: white;">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div class="media-body">
                                                <h6 class="mt-0 mb-1">
                                                    <strong><?= esc($anggota['nama']) ?></strong>
                                                </h6>
                                                <p class="text-muted mb-1">
                                                    <small>
                                                        <i class="fas fa-id-badge mr-1"></i> <?= esc($anggota['nrp']) ?>
                                                    </small>
                                                </p>
                                                <p class="text-muted mb-1">
                                                    <small>
                                                        <i class="fas fa-building mr-1"></i> <?= esc($anggota['unit_kerja'] ?? '-') ?>
                                                    </small>
                                                </p>
                                                <p class="text-muted mb-0">
                                                    <small>
                                                        <i class="fas fa-star mr-1"></i> <?= esc($anggota['pangkat']) ?>
                                                    </small>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Belum ada anggota yang ditugaskan untuk piket ini.
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Keterangan Card -->
        <div class="card card-outline card-secondary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-sticky-note mr-2"></i>
                    Keterangan & Informasi
                </h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Keterangan:</dt>
                    <dd class="col-sm-9">
                        <?php if (!empty($piket['keterangan'])): ?>
                            <div class="alert alert-light p-2 mb-0">
                                <?= nl2br(esc($piket['keterangan'])) ?>
                            </div>
                        <?php else: ?>
                            <span class="text-muted">Tidak ada keterangan khusus</span>
                        <?php endif; ?>
                    </dd>

                    <dt class="col-sm-3">Dibuat pada:</dt>
                    <dd class="col-sm-9">
                        <i class="fas fa-calendar mr-1"></i>
                        <?= date('d F Y, H:i', strtotime($piket['created_at'])) ?> WIB
                    </dd>

                    <?php if ($piket['updated_at'] && $piket['updated_at'] != $piket['created_at']): ?>
                        <dt class="col-sm-3">Terakhir diubah:</dt>
                        <dd class="col-sm-9">
                            <i class="fas fa-edit mr-1"></i>
                            <?= date('d F Y, H:i', strtotime($piket['updated_at'])) ?> WIB
                        </dd>
                    <?php endif; ?>
                </dl>
            </div>
        </div>

        <!-- Schedule Information -->
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-schedule mr-2"></i>
                    Informasi Jadwal
                </h3>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-info">
                                <i class="fas fa-calendar-day"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Hari</span>
                                <span class="info-box-number">
                                    <?php
                                    $hari = [
                                        'Sunday' => 'Minggu',
                                        'Monday' => 'Senin',
                                        'Tuesday' => 'Selasa',
                                        'Wednesday' => 'Rabu',
                                        'Thursday' => 'Kamis',
                                        'Friday' => 'Jumat',
                                        'Saturday' => 'Sabtu'
                                    ];
                                    echo $hari[date('l', strtotime($piket['tanggal_piket']))];
                                    ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning">
                                <i class="fas fa-clock"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Durasi</span>
                                <span class="info-box-number">
                                    <?php
                                    $mulai = new DateTime($piket['jam_mulai']);
                                    $selesai = new DateTime($piket['jam_selesai']);
                                    $durasi = $mulai->diff($selesai);
                                    echo $durasi->h . ' Jam';
                                    ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-success">
                                <i class="fas fa-users"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Personil</span>
                                <span class="info-box-number">
                                    <?= isset($anggotaPiket) ? count($anggotaPiket) : 0 ?> Orang
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();

        // Handle print functionality if needed
        $('#printBtn').click(function() {
            window.print();
        });
    });
</script>
<?= $this->endSection() ?>