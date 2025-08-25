<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Detail Data Kasus<?= $this->endSection() ?>

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
    <!-- Case Summary Card -->
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <div class="profile-user-img img-fluid img-circle d-flex align-items-center justify-content-center rounded-circle"
                        style="width: 150px; height: 150px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: 3px solid #dee2e6; margin: 0 auto;">
                        <i class="fas fa-folder-open fa-4x text-white"></i>
                    </div>
                </div>

                <h3 class="profile-username text-center"><?= $kasus['nomor_kasus'] ?></h3>

                <p class="text-muted text-center">
                    <strong><?= $kasus['judul_kasus'] ?></strong>
                </p>

                <div class="text-center">
                    <?php
                    $statusClass = [
                        'dilaporkan' => 'warning',
                        'dalam_proses' => 'info',
                        'selesai' => 'success',
                        'ditutup' => 'secondary'
                    ];
                    $statusText = [
                        'dilaporkan' => 'Dilaporkan',
                        'dalam_proses' => 'Dalam Proses',
                        'selesai' => 'Selesai',
                        'ditutup' => 'Ditutup'
                    ];
                    ?>
                    <span class="badge badge-<?= $statusClass[$kasus['status']] ?? 'light' ?> badge-lg">
                        <?= $statusText[$kasus['status']] ?? ucfirst($kasus['status']) ?>
                    </span>
                </div>

                <hr>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b><i class="fas fa-calendar mr-1"></i> Tanggal Kejadian</b>
                        <span class="float-right">
                            <?php
                            if ($kasus['tanggal_kejadian']) {
                                $tanggal = date_create($kasus['tanggal_kejadian']);
                                echo $tanggal ? $tanggal->format('d F Y') : $kasus['tanggal_kejadian'];
                            } else {
                                echo '-';
                            }
                            ?>
                        </span>
                    </li>
                    <li class="list-group-item">
                        <b><i class="fas fa-clock mr-1"></i> Waktu</b>
                        <span class="float-right">
                            <?php
                            if ($kasus['tanggal_kejadian']) {
                                $tanggal = date_create($kasus['tanggal_kejadian']);
                                echo $tanggal ? $tanggal->format('H:i') . ' WIB' : '-';
                            } else {
                                echo '-';
                            }
                            ?>
                        </span>
                    </li>
                    <li class="list-group-item">
                        <b><i class="fas fa-map-marker-alt mr-1"></i> Lokasi</b>
                        <span class="float-right"><?= $kasus['lokasi_kejadian'] ?: '-' ?></span>
                    </li>
                    <?php if ($kasus['pelapor_nama']): ?>
                        <li class="list-group-item">
                            <b><i class="fas fa-user mr-1"></i> Pelapor</b>
                            <span class="float-right"><?= $kasus['pelapor_nama'] ?></span>
                        </li>
                    <?php endif; ?>
                </ul>

                <div class="row">
                    <div class="col-12">
                        <a href="<?= base_url('reskrim/kasus') ?>" class="btn btn-secondary btn-block">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Information -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header p-2">
                <h3 class="card-title">
                    <i class="fas fa-info-circle mr-2"></i>
                    Informasi Detail Kasus
                </h3>
                <div class="card-tools">
                    <span class="badge badge-info">
                        <i class="fas fa-eye mr-1"></i>
                        Read-Only Access
                    </span>
                </div>
            </div>

            <div class="card-body">
                <div class="tab-content">
                    <!-- Case Information -->
                    <div class="tab-pane active" id="case-info">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">Nomor Kasus</label>
                                    <p class="text-muted"><?= $kasus['nomor_kasus'] ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">Jenis Kasus</label>
                                    <p class="text-muted"><?= $kasus['jenis_kasus_nama'] ?? '-' ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="text-bold">Judul Kasus</label>
                            <p class="text-muted"><?= $kasus['judul_kasus'] ?></p>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">Tanggal Kejadian</label>
                                    <p class="text-muted">
                                        <?php
                                        if ($kasus['tanggal_kejadian']) {
                                            $tanggal = date_create($kasus['tanggal_kejadian']);
                                            echo $tanggal ? $tanggal->format('d F Y') : $kasus['tanggal_kejadian'];
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">Waktu Kejadian</label>
                                    <p class="text-muted">
                                        <?php
                                        if ($kasus['tanggal_kejadian']) {
                                            $tanggal = date_create($kasus['tanggal_kejadian']);
                                            echo $tanggal ? $tanggal->format('H:i') . ' WIB' : '-';
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="text-bold">
                                <i class="fas fa-map-marker-alt mr-1"></i> Lokasi Kejadian
                            </label>
                            <p class="text-muted"><?= $kasus['lokasi_kejadian'] ?: '-' ?></p>
                        </div>

                        <hr>

                        <h5 class="text-bold">Deskripsi Kasus</h5>
                        <div class="form-group">
                            <p class="text-muted"><?= nl2br($kasus['deskripsi'] ?? '-') ?></p>
                        </div>

                        <hr>

                        <h5 class="text-bold">Informasi Pelapor</h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">
                                        <i class="fas fa-user mr-1"></i> Nama Pelapor
                                    </label>
                                    <p class="text-muted"><?= $kasus['pelapor_nama'] ?? '-' ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">
                                        <i class="fas fa-phone mr-1"></i> Telepon Pelapor
                                    </label>
                                    <p class="text-muted">
                                        <?php if ($kasus['pelapor_telepon']): ?>
                                            <a href="tel:<?= $kasus['pelapor_telepon'] ?>"><?= $kasus['pelapor_telepon'] ?></a>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <?php if ($kasus['keterangan']): ?>
                            <div class="form-group">
                                <label class="text-bold">
                                    <i class="fas fa-sticky-note mr-1"></i> Keterangan Tambahan
                                </label>
                                <p class="text-muted"><?= nl2br($kasus['keterangan']) ?></p>
                            </div>
                        <?php endif; ?>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">
                                        <i class="fas fa-plus mr-1"></i> Dibuat
                                    </label>
                                    <p class="text-muted">
                                        <?php
                                        if ($kasus['created_at']) {
                                            $createdAt = is_string($kasus['created_at']) ? date_create($kasus['created_at']) : $kasus['created_at'];
                                            echo $createdAt ? $createdAt->format('d F Y H:i') : $kasus['created_at'];
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">
                                        <i class="fas fa-sync-alt mr-1"></i> Terakhir Diupdate
                                    </label>
                                    <p class="text-muted">
                                        <?php
                                        if ($kasus['updated_at']) {
                                            $updatedAt = is_string($kasus['updated_at']) ? date_create($kasus['updated_at']) : $kasus['updated_at'];
                                            echo $updatedAt ? $updatedAt->format('d F Y H:i') : $kasus['updated_at'];
                                        }
                                        ?>
                                    </p>
                                </div>
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
        // No additional scripts needed for read-only view
    });
</script>
<?= $this->endSection() ?>