<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Detail Data Korban<?= $this->endSection() ?>

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
                        <i class="fas fa-user-injured fa-4x text-white"></i>
                    </div>
                </div>

                <h3 class="profile-username text-center"><?= $korban['nama'] ?></h3>

                <p class="text-muted text-center">
                    <?= $korban['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' ?><br>
                    <?php if ($korban['umur']): ?>
                        <strong><?= $korban['umur'] ?> tahun</strong>
                    <?php endif; ?>
                </p>

                <div class="text-center">
                    <?php
                    $statusClass = [
                        'hidup' => 'success',
                        'meninggal' => 'danger',
                        'hilang' => 'warning',
                        'luka' => 'info'
                    ];
                    $statusText = [
                        'hidup' => 'Hidup',
                        'meninggal' => 'Meninggal',
                        'hilang' => 'Hilang',
                        'luka' => 'Luka'
                    ];
                    ?>
                    <span class="badge badge-<?= $statusClass[$korban['status_korban']] ?? 'light' ?> badge-lg">
                        <?= $statusText[$korban['status_korban']] ?? ucfirst($korban['status_korban']) ?>
                    </span>
                </div>

                <hr>

                <ul class="list-group list-group-unbordered mb-3">
                    <?php if ($korban['nik']): ?>
                        <li class="list-group-item">
                            <b><i class="fas fa-id-card mr-1"></i> NIK</b>
                            <span class="float-right"><?= $korban['nik'] ?></span>
                        </li>
                    <?php endif; ?>
                    <?php if ($korban['pekerjaan']): ?>
                        <li class="list-group-item">
                            <b><i class="fas fa-briefcase mr-1"></i> Pekerjaan</b>
                            <span class="float-right"><?= $korban['pekerjaan'] ?></span>
                        </li>
                    <?php endif; ?>
                    <li class="list-group-item">
                        <b><i class="fas fa-folder-open mr-1"></i> Kasus</b>
                        <span class="float-right">
                            <a href="<?= base_url('reskrim/kasus/show/' . ($korban['kasus_id'] ?? '')) ?>">
                                <?= $korban['nomor_kasus'] ?? '-' ?>
                            </a>
                        </span>
                    </li>
                </ul>

                <div class="row">
                    <div class="col-6">
                        <a href="<?= base_url('reskrim/korban/edit/' . $korban['id']) ?>" class="btn btn-warning btn-block">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                    <div class="col-6">
                        <button class="btn btn-danger btn-block btn-delete" data-id="<?= $korban['id'] ?>">
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
                    Informasi Detail Korban
                </h3>
                <div class="card-tools">
                    <a href="<?= base_url('reskrim/korban') ?>" class="btn btn-secondary btn-sm">
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
                                    <p class="text-muted"><?= $korban['nama'] ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">NIK</label>
                                    <p class="text-muted"><?= $korban['nik'] ?: '-' ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">Jenis Kelamin</label>
                                    <p class="text-muted"><?= $korban['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">Umur</label>
                                    <p class="text-muted"><?= $korban['umur'] ? $korban['umur'] . ' tahun' : '-' ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">Pekerjaan</label>
                                    <p class="text-muted"><?= $korban['pekerjaan'] ?: '-' ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">Status Korban</label>
                                    <p class="text-muted">
                                        <span class="badge badge-<?= $statusClass[$korban['status_korban']] ?? 'light' ?>">
                                            <?= $statusText[$korban['status_korban']] ?? ucfirst($korban['status_korban']) ?>
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
                                        <?php if ($korban['telepon']): ?>
                                            <a href="tel:<?= $korban['telepon'] ?>"><?= $korban['telepon'] ?></a>
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
                                        <?php if ($korban['email']): ?>
                                            <a href="mailto:<?= $korban['email'] ?>"><?= $korban['email'] ?></a>
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
                            <p class="text-muted"><?= $korban['alamat'] ?: '-' ?></p>
                        </div>

                        <hr>

                        <h5 class="text-bold">Informasi Kasus</h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">Nomor Kasus</label>
                                    <p class="text-muted">
                                        <a href="<?= base_url('reskrim/kasus/show/' . ($korban['kasus_id'] ?? '')) ?>">
                                            <?= $korban['nomor_kasus'] ?? '-' ?>
                                        </a>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">Judul Kasus</label>
                                    <p class="text-muted"><?= $korban['judul_kasus'] ?? '-' ?></p>
                                </div>
                            </div>
                        </div>

                        <?php if ($korban['hubungan_pelaku']): ?>
                            <div class="form-group">
                                <label class="text-bold">
                                    <i class="fas fa-user-secret mr-1"></i> Hubungan dengan Pelaku
                                </label>
                                <p class="text-muted"><?= $korban['hubungan_pelaku'] ?></p>
                            </div>
                        <?php endif; ?>

                        <?php if ($korban['keterangan_luka']): ?>
                            <div class="form-group">
                                <label class="text-bold">
                                    <i class="fas fa-plus-square mr-1"></i> Keterangan Luka
                                </label>
                                <p class="text-muted"><?= nl2br($korban['keterangan_luka']) ?></p>
                            </div>
                        <?php endif; ?>

                        <?php if ($korban['keterangan']): ?>
                            <div class="form-group">
                                <label class="text-bold">
                                    <i class="fas fa-sticky-note mr-1"></i> Keterangan Tambahan
                                </label>
                                <p class="text-muted"><?= nl2br($korban['keterangan']) ?></p>
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
                                        if ($korban['created_at']) {
                                            $createdAt = is_string($korban['created_at']) ? date_create($korban['created_at']) : $korban['created_at'];
                                            echo $createdAt ? $createdAt->format('d F Y H:i') : $korban['created_at'];
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
                                        if ($korban['updated_at']) {
                                            $updatedAt = is_string($korban['updated_at']) ? date_create($korban['updated_at']) : $korban['updated_at'];
                                            echo $updatedAt ? $updatedAt->format('d F Y H:i') : $korban['updated_at'];
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
                text: 'Apakah Anda yakin ingin menghapus data korban ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= base_url('reskrim/korban/delete/') ?>' + id,
                        type: 'DELETE',
                        data: {
                            "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.href = '<?= base_url('reskrim/korban') ?>';
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: response.message
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Terjadi kesalahan saat menghapus data'
                            });
                        }
                    });
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>

