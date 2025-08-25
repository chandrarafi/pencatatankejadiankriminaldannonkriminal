<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Detail Anggota<?= $this->endSection() ?>

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
                    <?php if ($anggota['foto'] && file_exists(FCPATH . 'uploads/anggota/' . $anggota['foto'])): ?>
                        <img class="profile-user-img img-fluid img-circle"
                            src="<?= base_url('uploads/anggota/' . $anggota['foto']) ?>"
                            alt="Foto <?= $anggota['nama'] ?>"
                            style="width: 150px; height: 150px; object-fit: cover;">
                    <?php else: ?>
                        <div class="profile-user-img img-fluid img-circle d-flex align-items-center justify-content-center rounded-circle"
                            style="width: 150px; height: 150px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: 3px solid #dee2e6; margin: 0 auto;">
                            <i class="fas fa-user fa-4x text-white"></i>
                        </div>
                    <?php endif; ?>
                </div>

                <h3 class="profile-username text-center"><?= $anggota['nama'] ?></h3>

                <p class="text-muted text-center">
                    <?= $anggota['pangkat'] ?><br>
                    <strong><?= $anggota['jabatan'] ?></strong>
                </p>

                <div class="text-center">
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
                    <span class="badge badge-<?= $statusClass[$anggota['status']] ?? 'light' ?> badge-lg">
                        <?= $statusText[$anggota['status']] ?? ucfirst($anggota['status']) ?>
                    </span>
                </div>

                <hr>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b><i class="fas fa-id-card mr-1"></i> NRP</b>
                        <span class="float-right"><?= $anggota['nrp'] ?></span>
                    </li>
                    <li class="list-group-item">
                        <b><i class="fas fa-building mr-1"></i> Unit Kerja</b>
                        <span class="float-right"><?= $anggota['unit_kerja'] ?: '-' ?></span>
                    </li>
                    <?php if ($anggota['tanggal_masuk']): ?>
                        <li class="list-group-item">
                            <b><i class="fas fa-calendar mr-1"></i> Tanggal Masuk</b>
                            <span class="float-right">
                                <?php
                                // Format tanggal dari string Y-m-d ke d F Y
                                $tanggal = date_create($anggota['tanggal_masuk']);
                                echo $tanggal ? $tanggal->format('d F Y') : $anggota['tanggal_masuk'];
                                ?>
                            </span>
                        </li>
                    <?php endif; ?>
                </ul>

                <div class="row">
                    <div class="col-6">
                        <a href="<?= base_url('kasium/anggota/edit/' . $anggota['id']) ?>" class="btn btn-warning btn-block">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                    <div class="col-6">
                        <button class="btn btn-danger btn-block btn-delete" data-id="<?= $anggota['id'] ?>">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
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
                    Informasi Detail Anggota
                </h3>
                <div class="card-tools">
                    <a href="<?= base_url('kasium/anggota') ?>" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="tab-content">
                    <!-- Personal Information -->
                    <div class="tab-pane active" id="personal">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">Nama Lengkap</label>
                                    <p class="text-muted"><?= $anggota['nama'] ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">NRP</label>
                                    <p class="text-muted"><?= $anggota['nrp'] ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">Pangkat</label>
                                    <p class="text-muted"><?= $anggota['pangkat'] ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">Jabatan</label>
                                    <p class="text-muted"><?= $anggota['jabatan'] ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">Unit Kerja</label>
                                    <p class="text-muted"><?= $anggota['unit_kerja'] ?: '-' ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">Status</label>
                                    <p class="text-muted">
                                        <span class="badge badge-<?= $statusClass[$anggota['status']] ?? 'light' ?>">
                                            <?= $statusText[$anggota['status']] ?? ucfirst($anggota['status']) ?>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <h5 class="text-bold">Kontak & Alamat</h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">
                                        <i class="fas fa-phone mr-1"></i> Telepon
                                    </label>
                                    <p class="text-muted">
                                        <?php if ($anggota['telepon']): ?>
                                            <a href="tel:<?= $anggota['telepon'] ?>"><?= $anggota['telepon'] ?></a>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">
                                        <i class="fas fa-envelope mr-1"></i> Email
                                    </label>
                                    <p class="text-muted">
                                        <?php if ($anggota['email']): ?>
                                            <a href="mailto:<?= $anggota['email'] ?>"><?= $anggota['email'] ?></a>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="text-bold">
                                <i class="fas fa-map-marker-alt mr-1"></i> Alamat
                            </label>
                            <p class="text-muted"><?= $anggota['alamat'] ?: '-' ?></p>
                        </div>

                        <?php if ($anggota['tanggal_masuk']): ?>
                            <div class="form-group">
                                <label class="text-bold">
                                    <i class="fas fa-calendar mr-1"></i> Tanggal Masuk
                                </label>
                                <p class="text-muted">
                                    <?php
                                    // Format tanggal dari string Y-m-d ke d F Y
                                    $tanggal = date_create($anggota['tanggal_masuk']);
                                    echo $tanggal ? $tanggal->format('d F Y') : $anggota['tanggal_masuk'];
                                    ?>
                                    <small class="text-muted">
                                        <?php
                                        // Hitung tahun dari tanggal masuk
                                        $tanggalMasuk = date_create($anggota['tanggal_masuk']);
                                        if ($tanggalMasuk) {
                                            $tahunKerja = floor((time() - $tanggalMasuk->getTimestamp()) / (365 * 60 * 60 * 24));
                                            echo "($tahunKerja tahun yang lalu)";
                                        }
                                        ?>
                                    </small>
                                </p>
                            </div>
                        <?php endif; ?>

                        <?php if ($anggota['keterangan']): ?>
                            <div class="form-group">
                                <label class="text-bold">
                                    <i class="fas fa-sticky-note mr-1"></i> Keterangan
                                </label>
                                <p class="text-muted"><?= nl2br($anggota['keterangan']) ?></p>
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
                                        // Format created_at
                                        if ($anggota['created_at']) {
                                            $createdAt = is_string($anggota['created_at']) ? date_create($anggota['created_at']) : $anggota['created_at'];
                                            echo $createdAt ? $createdAt->format('d F Y H:i') : $anggota['created_at'];
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
                                        // Format updated_at
                                        if ($anggota['updated_at']) {
                                            $updatedAt = is_string($anggota['updated_at']) ? date_create($anggota['updated_at']) : $anggota['updated_at'];
                                            echo $updatedAt ? $updatedAt->format('d F Y H:i') : $anggota['updated_at'];
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
        // Handle delete confirmation
        $('.btn-delete').click(function(e) {
            e.preventDefault();
            const id = $(this).data('id');

            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Apakah Anda yakin ingin menghapus data anggota ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?= base_url('kasium/anggota/delete/') ?>' + id;
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>