<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Detail Data Saksi<?= $this->endSection() ?>

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
                        style="width: 150px; height: 150px; background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); border: 3px solid #dee2e6; margin: 0 auto;">
                        <i class="fas fa-user-friends fa-4x text-white"></i>
                    </div>
                </div>

                <h3 class="profile-username text-center"><?= $saksi['nama'] ?></h3>

                <p class="text-muted text-center">
                    <?= $saksi['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' ?><br>
                    <?php if ($saksi['umur']): ?>
                        <strong><?= $saksi['umur'] ?> tahun</strong>
                    <?php endif; ?>
                </p>

                <div class="text-center">
                    <?php
                    $jenisClass = [
                        'ahli' => 'primary',
                        'fakta' => 'info',
                        'korban' => 'warning',
                        'mahkota' => 'success'
                    ];
                    $jenisText = [
                        'ahli' => 'Saksi Ahli',
                        'fakta' => 'Saksi Fakta',
                        'korban' => 'Korban sebagai Saksi',
                        'mahkota' => 'Saksi Mahkota'
                    ];
                    ?>
                    <span class="badge badge-<?= $jenisClass[$saksi['jenis_saksi']] ?? 'light' ?> badge-lg">
                        <?= $jenisText[$saksi['jenis_saksi']] ?? ucfirst($saksi['jenis_saksi']) ?>
                    </span>
                </div>

                <hr>

                <ul class="list-group list-group-unbordered mb-3">
                    <?php if ($saksi['nik']): ?>
                        <li class="list-group-item">
                            <b><i class="fas fa-id-card mr-1"></i> NIK</b>
                            <span class="float-right"><?= $saksi['nik'] ?></span>
                        </li>
                    <?php endif; ?>
                    <?php if ($saksi['pekerjaan']): ?>
                        <li class="list-group-item">
                            <b><i class="fas fa-briefcase mr-1"></i> Pekerjaan</b>
                            <span class="float-right"><?= $saksi['pekerjaan'] ?></span>
                        </li>
                    <?php endif; ?>
                    <li class="list-group-item">
                        <b><i class="fas fa-folder-open mr-1"></i> Kasus</b>
                        <span class="float-right">
                            <a href="<?= base_url('reskrim/kasus/show/' . ($saksi['kasus_id'] ?? '')) ?>">
                                <?= $saksi['nomor_kasus'] ?? '-' ?>
                            </a>
                        </span>
                    </li>
                    <li class="list-group-item">
                        <b><i class="fas fa-phone mr-1"></i> Dapat Dihubungi</b>
                        <span class="float-right">
                            <?php if ($saksi['dapat_dihubungi']): ?>
                                <span class="badge badge-success">Ya</span>
                            <?php else: ?>
                                <span class="badge badge-secondary">Tidak</span>
                            <?php endif; ?>
                        </span>
                    </li>
                </ul>

                <div class="row">
                    <div class="col-6">
                        <a href="<?= base_url('reskrim/saksi/edit/' . $saksi['id']) ?>" class="btn btn-warning btn-block">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="<?= base_url('reskrim/saksi') ?>" class="btn btn-secondary btn-block">
                            <i class="fas fa-arrow-left"></i> Kembali
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
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active" href="#identity" data-toggle="tab">
                            <i class="fas fa-user"></i> Identitas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimony" data-toggle="tab">
                            <i class="fas fa-comment-dots"></i> Kesaksian
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#relationship" data-toggle="tab">
                            <i class="fas fa-users"></i> Hubungan
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content">
                    <!-- Identity Tab -->
                    <div class="tab-pane active" id="identity">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">Nama Lengkap</label>
                                    <p class="text-muted"><?= $saksi['nama'] ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">NIK</label>
                                    <p class="text-muted"><?= $saksi['nik'] ?: '-' ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-bold">Jenis Kelamin</label>
                                    <p class="text-muted">
                                        <?= $saksi['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' ?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-bold">Umur</label>
                                    <p class="text-muted"><?= $saksi['umur'] ? $saksi['umur'] . ' tahun' : '-' ?></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-bold">Jenis Saksi</label>
                                    <p class="text-muted">
                                        <span class="badge badge-<?= $jenisClass[$saksi['jenis_saksi']] ?? 'light' ?>">
                                            <?= $jenisText[$saksi['jenis_saksi']] ?? ucfirst($saksi['jenis_saksi']) ?>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">Pekerjaan</label>
                                    <p class="text-muted"><?= $saksi['pekerjaan'] ?: '-' ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">
                                        <i class="fas fa-phone mr-1"></i> Telepon
                                    </label>
                                    <p class="text-muted">
                                        <?php if ($saksi['telepon']): ?>
                                            <a href="tel:<?= $saksi['telepon'] ?>"><?= $saksi['telepon'] ?></a>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">
                                        <i class="fas fa-envelope mr-1"></i> Email
                                    </label>
                                    <p class="text-muted">
                                        <?php if ($saksi['email']): ?>
                                            <a href="mailto:<?= $saksi['email'] ?>"><?= $saksi['email'] ?></a>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">Dapat Dihubungi</label>
                                    <p class="text-muted">
                                        <?php if ($saksi['dapat_dihubungi']): ?>
                                            <span class="badge badge-success"><i class="fas fa-check mr-1"></i> Ya</span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary"><i class="fas fa-times mr-1"></i> Tidak</span>
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="text-bold">
                                <i class="fas fa-map-marker-alt mr-1"></i> Alamat
                            </label>
                            <div class="border p-3 rounded bg-light">
                                <p class="text-muted mb-0"><?= nl2br($saksi['alamat'] ?? '-') ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Testimony Tab -->
                    <div class="tab-pane" id="testimony">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">
                                        <i class="fas fa-folder-open mr-1"></i> Nomor Kasus
                                    </label>
                                    <p class="text-muted">
                                        <a href="<?= base_url('reskrim/kasus/show/' . ($saksi['kasus_id'] ?? '')) ?>">
                                            <?= $saksi['nomor_kasus'] ?? '-' ?>
                                        </a>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">Judul Kasus</label>
                                    <p class="text-muted"><?= $saksi['judul_kasus'] ?? '-' ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="text-bold">
                                <i class="fas fa-comment-dots mr-1"></i> Keterangan Kesaksian
                            </label>
                            <div class="border p-3 rounded bg-light">
                                <p class="text-muted mb-0"><?= nl2br($saksi['keterangan_kesaksian'] ?? 'Belum ada keterangan kesaksian yang tercatat.') ?></p>
                            </div>
                        </div>

                        <?php if ($saksi['keterangan']): ?>
                            <div class="form-group">
                                <label class="text-bold">
                                    <i class="fas fa-sticky-note mr-1"></i> Keterangan Tambahan
                                </label>
                                <div class="border p-3 rounded bg-light">
                                    <p class="text-muted mb-0"><?= nl2br($saksi['keterangan']) ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Relationship Tab -->
                    <div class="tab-pane" id="relationship">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">
                                        <i class="fas fa-user-injured mr-1"></i> Hubungan dengan Korban
                                    </label>
                                    <div class="border p-3 rounded bg-light">
                                        <p class="text-muted mb-0"><?= $saksi['hubungan_dengan_korban'] ?: 'Tidak ada informasi hubungan dengan korban.' ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">
                                        <i class="fas fa-user-secret mr-1"></i> Hubungan dengan Tersangka
                                    </label>
                                    <div class="border p-3 rounded bg-light">
                                        <p class="text-muted mb-0"><?= $saksi['hubungan_dengan_tersangka'] ?: 'Tidak ada informasi hubungan dengan tersangka.' ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">
                                        <i class="fas fa-plus mr-1"></i> Dibuat
                                    </label>
                                    <p class="text-muted">
                                        <?php
                                        if ($saksi['created_at']) {
                                            $createdAt = is_string($saksi['created_at']) ? date_create($saksi['created_at']) : $saksi['created_at'];
                                            echo $createdAt ? $createdAt->format('d F Y H:i') : $saksi['created_at'];
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
                                        if ($saksi['updated_at']) {
                                            $updatedAt = is_string($saksi['updated_at']) ? date_create($saksi['updated_at']) : $saksi['updated_at'];
                                            echo $updatedAt ? $updatedAt->format('d F Y H:i') : $saksi['updated_at'];
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
        // No additional scripts needed for show view
    });
</script>
<?= $this->endSection() ?>

