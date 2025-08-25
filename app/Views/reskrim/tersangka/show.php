<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Detail Data Tersangka<?= $this->endSection() ?>

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
                        style="width: 150px; height: 150px; background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); border: 3px solid #dee2e6; margin: 0 auto;">
                        <i class="fas fa-user-secret fa-4x text-white"></i>
                    </div>
                </div>

                <h3 class="profile-username text-center"><?= $tersangka['nama'] ?></h3>

                <p class="text-muted text-center">
                    <?= $tersangka['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' ?><br>
                    <?php if ($tersangka['umur']): ?>
                        <strong><?= $tersangka['umur'] ?> tahun</strong>
                    <?php endif; ?>
                </p>

                <div class="text-center">
                    <?php
                    $statusClass = [
                        'ditetapkan' => 'warning',
                        'ditahan' => 'danger',
                        'dibebaskan' => 'success',
                        'buron' => 'dark'
                    ];
                    $statusText = [
                        'ditetapkan' => 'Ditetapkan',
                        'ditahan' => 'Ditahan',
                        'dibebaskan' => 'Dibebaskan',
                        'buron' => 'Buron'
                    ];
                    ?>
                    <span class="badge badge-<?= $statusClass[$tersangka['status_tersangka']] ?? 'light' ?> badge-lg">
                        <?= $statusText[$tersangka['status_tersangka']] ?? ucfirst($tersangka['status_tersangka']) ?>
                    </span>
                </div>

                <hr>

                <ul class="list-group list-group-unbordered mb-3">
                    <?php if ($tersangka['nik']): ?>
                        <li class="list-group-item">
                            <b><i class="fas fa-id-card mr-1"></i> NIK</b>
                            <span class="float-right"><?= $tersangka['nik'] ?></span>
                        </li>
                    <?php endif; ?>
                    <?php if ($tersangka['pekerjaan']): ?>
                        <li class="list-group-item">
                            <b><i class="fas fa-briefcase mr-1"></i> Pekerjaan</b>
                            <span class="float-right"><?= $tersangka['pekerjaan'] ?></span>
                        </li>
                    <?php endif; ?>
                    <li class="list-group-item">
                        <b><i class="fas fa-folder-open mr-1"></i> Kasus</b>
                        <span class="float-right">
                            <a href="<?= base_url('reskrim/kasus/show/' . ($tersangka['kasus_id'] ?? '')) ?>">
                                <?= $tersangka['nomor_kasus'] ?? '-' ?>
                            </a>
                        </span>
                    </li>
                    <?php if ($tersangka['tempat_penahanan']): ?>
                        <li class="list-group-item">
                            <b><i class="fas fa-home mr-1"></i> Tempat Penahanan</b>
                            <span class="float-right"><?= $tersangka['tempat_penahanan'] ?></span>
                        </li>
                    <?php endif; ?>
                </ul>

                <div class="row">
                    <div class="col-6">
                        <a href="<?= base_url('reskrim/tersangka/edit/' . $tersangka['id']) ?>" class="btn btn-warning btn-block">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="<?= base_url('reskrim/tersangka') ?>" class="btn btn-secondary btn-block">
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
                        <a class="nav-link" href="#case" data-toggle="tab">
                            <i class="fas fa-gavel"></i> Perkara
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#detention" data-toggle="tab">
                            <i class="fas fa-handcuffs"></i> Penahanan
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
                                    <p class="text-muted"><?= $tersangka['nama'] ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">NIK</label>
                                    <p class="text-muted"><?= $tersangka['nik'] ?: '-' ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-bold">Jenis Kelamin</label>
                                    <p class="text-muted">
                                        <?= $tersangka['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' ?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-bold">Umur</label>
                                    <p class="text-muted"><?= $tersangka['umur'] ? $tersangka['umur'] . ' tahun' : '-' ?></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-bold">Status Tersangka</label>
                                    <p class="text-muted">
                                        <span class="badge badge-<?= $statusClass[$tersangka['status_tersangka']] ?? 'light' ?>">
                                            <?= $statusText[$tersangka['status_tersangka']] ?? ucfirst($tersangka['status_tersangka']) ?>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">Pekerjaan</label>
                                    <p class="text-muted"><?= $tersangka['pekerjaan'] ?: '-' ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">
                                        <i class="fas fa-phone mr-1"></i> Telepon
                                    </label>
                                    <p class="text-muted">
                                        <?php if ($tersangka['telepon']): ?>
                                            <a href="tel:<?= $tersangka['telepon'] ?>"><?= $tersangka['telepon'] ?></a>
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
                                        <?php if ($tersangka['email']): ?>
                                            <a href="mailto:<?= $tersangka['email'] ?>"><?= $tersangka['email'] ?></a>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">
                                        <i class="fas fa-map-marker-alt mr-1"></i> Alamat
                                    </label>
                                    <p class="text-muted"><?= $tersangka['alamat'] ?: '-' ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Case Tab -->
                    <div class="tab-pane" id="case">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">
                                        <i class="fas fa-folder-open mr-1"></i> Nomor Kasus
                                    </label>
                                    <p class="text-muted">
                                        <a href="<?= base_url('reskrim/kasus/show/' . ($tersangka['kasus_id'] ?? '')) ?>">
                                            <?= $tersangka['nomor_kasus'] ?? '-' ?>
                                        </a>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">Judul Kasus</label>
                                    <p class="text-muted"><?= $tersangka['judul_kasus'] ?? '-' ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="text-bold">
                                <i class="fas fa-balance-scale mr-1"></i> Pasal yang Disangkakan
                            </label>
                            <div class="border p-3 rounded bg-light">
                                <p class="text-muted mb-0"><?= nl2br($tersangka['pasal_yang_disangkakan'] ?? '-') ?></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="text-bold">
                                <i class="fas fa-box mr-1"></i> Barang Bukti
                            </label>
                            <div class="border p-3 rounded bg-light">
                                <p class="text-muted mb-0"><?= nl2br($tersangka['barang_bukti'] ?? '-') ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Detention Tab -->
                    <div class="tab-pane" id="detention">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">
                                        <i class="fas fa-home mr-1"></i> Tempat Penahanan
                                    </label>
                                    <p class="text-muted"><?= $tersangka['tempat_penahanan'] ?: '-' ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">
                                        <i class="fas fa-calendar mr-1"></i> Tanggal Penahanan
                                    </label>
                                    <p class="text-muted">
                                        <?php
                                        if ($tersangka['tanggal_penahanan']) {
                                            $tanggal = date_create($tersangka['tanggal_penahanan']);
                                            echo $tanggal ? $tanggal->format('d F Y') : $tersangka['tanggal_penahanan'];
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <?php if ($tersangka['keterangan']): ?>
                            <div class="form-group">
                                <label class="text-bold">
                                    <i class="fas fa-sticky-note mr-1"></i> Keterangan Tambahan
                                </label>
                                <div class="border p-3 rounded bg-light">
                                    <p class="text-muted mb-0"><?= nl2br($tersangka['keterangan']) ?></p>
                                </div>
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
                                        if ($tersangka['created_at']) {
                                            $createdAt = is_string($tersangka['created_at']) ? date_create($tersangka['created_at']) : $tersangka['created_at'];
                                            echo $createdAt ? $createdAt->format('d F Y H:i') : $tersangka['created_at'];
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
                                        if ($tersangka['updated_at']) {
                                            $updatedAt = is_string($tersangka['updated_at']) ? date_create($tersangka['updated_at']) : $tersangka['updated_at'];
                                            echo $updatedAt ? $updatedAt->format('d F Y H:i') : $tersangka['updated_at'];
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

