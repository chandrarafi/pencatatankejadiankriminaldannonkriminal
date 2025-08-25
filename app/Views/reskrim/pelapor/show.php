<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Detail Data Pelapor<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Profile Card -->
<div class="card card-primary card-outline">
    <div class="card-body box-profile">
        <div class="text-center">
            <div class="profile-user-img img-fluid img-circle bg-primary d-inline-flex align-items-center justify-content-center"
                style="width: 128px; height: 128px; font-size: 48px; color: white;">
                <i class="fas fa-user"></i>
            </div>
        </div>

        <h3 class="profile-username text-center"><?= esc($pelapor['nama']) ?></h3>

        <p class="text-muted text-center">
            <?php if ($pelapor['pekerjaan']): ?>
                <i class="fas fa-briefcase mr-1"></i> <?= esc($pelapor['pekerjaan']) ?>
            <?php else: ?>
                <i class="fas fa-user mr-1"></i> Pelapor
            <?php endif; ?>
        </p>

        <div class="text-center mb-3">
            <?php if ($pelapor['is_active']): ?>
                <span class="badge badge-success badge-lg">
                    <i class="fas fa-check-circle mr-1"></i> Status Aktif
                </span>
            <?php else: ?>
                <span class="badge badge-secondary badge-lg">
                    <i class="fas fa-times-circle mr-1"></i> Status Non-Aktif
                </span>
            <?php endif; ?>
            <span class="badge badge-info badge-lg ml-2">
                <i class="fas fa-eye mr-1"></i> Read Only - RESKRIM
            </span>
        </div>

        <ul class="list-group list-group-unbordered mb-3">
            <!-- Data Identitas -->
            <?php if ($pelapor['nik']): ?>
                <li class="list-group-item">
                    <b><i class="fas fa-id-card mr-1"></i> NIK</b>
                    <span class="float-right"><?= esc($pelapor['nik']) ?></span>
                </li>
            <?php endif; ?>

            <?php if ($pelapor['jenis_kelamin']): ?>
                <li class="list-group-item">
                    <b><i class="fas fa-venus-mars mr-1"></i> Jenis Kelamin</b>
                    <span class="float-right">
                        <?= $pelapor['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?>
                    </span>
                </li>
            <?php endif; ?>

            <?php if ($pelapor['tanggal_lahir']): ?>
                <li class="list-group-item">
                    <b><i class="fas fa-birthday-cake mr-1"></i> Tanggal Lahir</b>
                    <span class="float-right">
                        <?= date('d F Y', strtotime($pelapor['tanggal_lahir'])) ?>
                        <?php
                        $today = new DateTime();
                        $birthDate = new DateTime($pelapor['tanggal_lahir']);
                        $age = $today->diff($birthDate)->y;
                        ?>
                        <span class="badge badge-info ml-1"><?= $age ?> tahun</span>
                    </span>
                </li>
            <?php endif; ?>

            <!-- Data Kontak -->
            <?php if ($pelapor['telepon']): ?>
                <li class="list-group-item">
                    <b><i class="fas fa-phone mr-1"></i> Telepon</b>
                    <span class="float-right">
                        <a href="tel:<?= esc($pelapor['telepon']) ?>" class="text-primary">
                            <?= esc($pelapor['telepon']) ?>
                        </a>
                    </span>
                </li>
            <?php endif; ?>

            <?php if ($pelapor['email']): ?>
                <li class="list-group-item">
                    <b><i class="fas fa-envelope mr-1"></i> Email</b>
                    <span class="float-right">
                        <a href="mailto:<?= esc($pelapor['email']) ?>" class="text-primary">
                            <?= esc($pelapor['email']) ?>
                        </a>
                    </span>
                </li>
            <?php endif; ?>
        </ul>

        <div class="text-center">
            <a href="<?= base_url('reskrim/pelapor') ?>" class="btn btn-default">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
            </a>
        </div>
    </div>
</div>

<!-- Detail Informasi Card -->
<div class="row">
    <!-- Alamat -->
    <div class="col-md-6">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-map-marker-alt mr-2"></i>
                    Informasi Alamat
                </h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Alamat Lengkap:</dt>
                    <dd class="col-sm-8"><?= esc($pelapor['alamat']) ?: '-' ?></dd>

                    <dt class="col-sm-4">Kelurahan:</dt>
                    <dd class="col-sm-8"><?= esc($pelapor['kelurahan']) ?: '-' ?></dd>

                    <dt class="col-sm-4">Kecamatan:</dt>
                    <dd class="col-sm-8"><?= esc($pelapor['kecamatan']) ?: '-' ?></dd>

                    <dt class="col-sm-4">Kota/Kabupaten:</dt>
                    <dd class="col-sm-8"><?= esc($pelapor['kota_kabupaten']) ?: '-' ?></dd>

                    <dt class="col-sm-4">Provinsi:</dt>
                    <dd class="col-sm-8"><?= esc($pelapor['provinsi']) ?: '-' ?></dd>

                    <dt class="col-sm-4">Kode Pos:</dt>
                    <dd class="col-sm-8"><?= esc($pelapor['kode_pos']) ?: '-' ?></dd>
                </dl>
            </div>
        </div>
    </div>

    <!-- Informasi Tambahan -->
    <div class="col-md-6">
        <div class="card card-outline card-secondary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle mr-2"></i>
                    Informasi Tambahan
                </h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Pekerjaan:</dt>
                    <dd class="col-sm-8"><?= esc($pelapor['pekerjaan']) ?: '-' ?></dd>

                    <dt class="col-sm-4">Keterangan:</dt>
                    <dd class="col-sm-8">
                        <?php if ($pelapor['keterangan']): ?>
                            <div class="alert alert-light p-2 mb-0">
                                <?= nl2br(esc($pelapor['keterangan'])) ?>
                            </div>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </dd>

                    <dt class="col-sm-4">Dibuat oleh:</dt>
                    <dd class="col-sm-8">
                        <?php if (isset($pelapor['created_by'])): ?>
                            <span class="badge badge-info"><?= esc($pelapor['created_by']) ?></span>
                        <?php else: ?>
                            <span class="text-muted">System</span>
                        <?php endif; ?>
                    </dd>

                    <dt class="col-sm-4">Tanggal Dibuat:</dt>
                    <dd class="col-sm-8">
                        <i class="fas fa-calendar mr-1"></i>
                        <?= date('d F Y, H:i', strtotime($pelapor['created_at'])) ?> WIB
                    </dd>

                    <?php if ($pelapor['updated_at'] && $pelapor['updated_at'] != $pelapor['created_at']): ?>
                        <dt class="col-sm-4">Terakhir Diubah:</dt>
                        <dd class="col-sm-8">
                            <i class="fas fa-edit mr-1"></i>
                            <?= date('d F Y, H:i', strtotime($pelapor['updated_at'])) ?> WIB
                        </dd>
                    <?php endif; ?>
                </dl>
            </div>
        </div>
    </div>
</div>

<!-- Statistik Pelaporan (jika ada data yang terkait) -->
<div class="card card-outline card-warning">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-chart-bar mr-2"></i>
            Riwayat Pelaporan
        </h3>
    </div>
    <div class="card-body">
        <div class="alert alert-info">
            <i class="fas fa-info-circle mr-2"></i>
            <strong>Akses Read-Only RESKRIM:</strong>
            Data ini berasal dari SPKT. Untuk melihat riwayat pelaporan lengkap, hubungi bagian SPKT.
        </div>

        <div class="row text-center">
            <div class="col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info">
                        <i class="fas fa-file-alt"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Laporan</span>
                        <span class="info-box-number">-</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-warning">
                        <i class="fas fa-clock"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Dalam Proses</span>
                        <span class="info-box-number">-</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-success">
                        <i class="fas fa-check"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Selesai</span>
                        <span class="info-box-number">-</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-secondary">
                        <i class="fas fa-archive"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Ditutup</span>
                        <span class="info-box-number">-</span>
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