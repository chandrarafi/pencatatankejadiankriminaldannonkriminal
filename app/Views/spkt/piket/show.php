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
                    Piket - <?= count($anggotaPiket) ?> Anggota
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
                        'aktif' => 'badge-success',
                        'selesai' => 'badge-info',
                        'batal' => 'badge-danger'
                    ];
                    $status = $piket['status'] ?: 'draft';
                    $statusBadge = $statusClass[$status] ?? 'badge-secondary';
                    ?>
                    <span class="badge badge-lg <?= $statusBadge ?>">
                        <i class="fas fa-circle mr-1"></i>
                        <?= strtoupper($status) ?>
                    </span>
                </div>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b><i class="fas fa-clock mr-1"></i> Shift</b>
                        <span class="float-right">
                            <?php
                            $shiftClass = [
                                'pagi' => 'badge-success',
                                'siang' => 'badge-warning',
                                'malam' => 'badge-dark'
                            ];
                            $shiftBadge = $shiftClass[$piket['shift']] ?? 'badge-secondary';
                            ?>
                            <span class="badge <?= $shiftBadge ?>"><?= strtoupper($piket['shift']) ?></span>
                        </span>
                    </li>
                    <li class="list-group-item">
                        <b><i class="fas fa-hourglass-half mr-1"></i> Jam</b>
                        <span class="float-right"><?= $piket['jam_mulai'] ?> - <?= $piket['jam_selesai'] ?></span>
                    </li>
                    <li class="list-group-item">
                        <b><i class="fas fa-map-marker-alt mr-1"></i> Lokasi</b>
                        <span class="float-right"><?= $piket['lokasi_piket'] ?: '-' ?></span>
                    </li>
                    <?php if ($piket['keterangan']): ?>
                        <li class="list-group-item">
                            <b><i class="fas fa-sticky-note mr-1"></i> Keterangan</b>
                            <span class="float-right"><?= esc($piket['keterangan']) ?></span>
                        </li>
                    <?php endif; ?>
                </ul>

                <div class="row">
                    <div class="col-12">
                        <a href="<?= base_url('spkt/piket') ?>" class="btn btn-secondary btn-block">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar Piket
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Information -->
    <div class="col-md-8">
        <!-- Read-Only Notice -->
        <div class="alert alert-info">
            <i class="fas fa-info-circle mr-2"></i>
            <strong>Mode Read-Only:</strong> Anda hanya dapat melihat informasi piket.
            Untuk mengedit atau mengelola data piket, hubungi bagian Kasium.
        </div>

        <!-- Anggota Piket Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-users mr-2"></i>
                    Anggota Piket (<?= count($anggotaPiket) ?> Orang)
                </h3>
            </div>
            <div class="card-body">
                <?php if (!empty($anggotaPiket)): ?>
                    <div class="row">
                        <?php foreach ($anggotaPiket as $anggota): ?>
                            <div class="col-md-6 mb-3">
                                <div class="card card-outline card-primary">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center">
                                            <div class="profile-user-img img-fluid img-circle d-flex align-items-center justify-content-center"
                                                style="width: 60px; height: 60px; background: linear-gradient(135deg, #3490dc 0%, #6574cd 100%); color: white; font-size: 24px; margin-right: 15px;">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 font-weight-bold"><?= esc($anggota['nama']) ?></h6>
                                                <p class="mb-1 text-muted small">
                                                    <i class="fas fa-id-badge mr-1"></i>
                                                    NRP: <?= esc($anggota['nrp']) ?>
                                                </p>
                                                <p class="mb-1 text-muted small">
                                                    <i class="fas fa-star mr-1"></i>
                                                    <?= esc($anggota['pangkat'] ?? '-') ?>
                                                </p>
                                                <p class="mb-0 text-muted small">
                                                    <i class="fas fa-building mr-1"></i>
                                                    <?= esc($anggota['unit_kerja'] ?? '-') ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-users fa-3x mb-3"></i>
                        <h5>Belum Ada Anggota</h5>
                        <p>Belum ada anggota yang ditugaskan untuk piket ini.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Information Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle mr-2"></i>
                    Informasi Sistem
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <small class="text-muted">
                            <i class="fas fa-calendar-plus mr-1"></i>
                            <strong>Dibuat:</strong><br>
                            <?php
                            $createdAt = date_create($piket['created_at']);
                            if ($createdAt) {
                                echo $createdAt->format('d F Y, H:i');
                            }
                            ?>
                        </small>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted">
                            <i class="fas fa-calendar-edit mr-1"></i>
                            <strong>Diperbarui:</strong><br>
                            <?php
                            $updatedAt = date_create($piket['updated_at']);
                            if ($updatedAt) {
                                echo $updatedAt->format('d F Y, H:i');
                            }
                            ?>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<style>
    .badge-lg {
        font-size: 0.9em;
        padding: 0.5rem 0.75rem;
    }
</style>
<?= $this->endSection() ?>