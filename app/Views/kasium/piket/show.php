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
                    <?php if (count($anggotaPiket) > 0): ?>
                        <?= count($anggotaPiket) ?> Anggota Piket
                    <?php else: ?>
                        Belum Ada Anggota
                    <?php endif; ?>
                </h3>

                <p class="text-muted text-center">
                    <?php
                    // Format tanggal
                    $tanggal = date_create($piket['tanggal_piket']);
                    echo $tanggal ? $tanggal->format('d F Y') : $piket['tanggal_piket'];
                    ?><br>
                    <strong>Shift <?= ucfirst($piket['shift']) ?></strong>
                </p>

                <div class="text-center">
                    <?php
                    $statusClass = [
                        'dijadwalkan' => 'primary',
                        'selesai' => 'success',
                        'diganti' => 'warning',
                        'tidak_hadir' => 'danger'
                    ];
                    $statusText = [
                        'dijadwalkan' => 'Dijadwalkan',
                        'selesai' => 'Selesai',
                        'diganti' => 'Diganti',
                        'tidak_hadir' => 'Tidak Hadir'
                    ];
                    ?>
                    <?php $status = $piket['status'] ?: 'draft'; ?>
                    <span class="badge badge-<?= $statusClass[$status] ?? 'light' ?> badge-lg">
                        <?= $statusText[$status] ?? ucfirst($status) ?>
                    </span>
                </div>

                <hr>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b><i class="fas fa-clock mr-1"></i> Jam Kerja</b>
                        <span class="float-right"><?= $piket['jam_mulai'] ?> - <?= $piket['jam_selesai'] ?></span>
                    </li>
                    <li class="list-group-item">
                        <b><i class="fas fa-map-marker-alt mr-1"></i> Lokasi</b>
                        <span class="float-right"><?= $piket['lokasi_piket'] ?: 'Polsek Lunang Silaut' ?></span>
                    </li>
                    <li class="list-group-item">
                        <b><i class="fas fa-users mr-1"></i> Jumlah Anggota</b>
                        <span class="float-right"><?= count($anggotaPiket) ?> orang</span>
                    </li>
                </ul>

                <div class="row">
                    <div class="col-6">
                        <a href="<?= base_url('kasium/piket/edit/' . $piket['id']) ?>" class="btn btn-warning btn-block">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                    <div class="col-6">
                        <button class="btn btn-danger btn-block btn-delete" data-id="<?= $piket['id'] ?>">
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
                    Informasi Detail Jadwal Piket
                </h3>
                <div class="card-tools">
                    <a href="<?= base_url('kasium/piket') ?>" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="tab-content">
                    <!-- Personal Information -->
                    <div class="tab-pane active" id="personal">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="text-bold">Anggota Piket (<?= count($anggotaPiket) ?> orang)</label>
                                    <?php if (count($anggotaPiket) > 0): ?>
                                        <div class="row">
                                            <?php foreach ($anggotaPiket as $anggota): ?>
                                                <div class="col-md-6 mb-2">
                                                    <div class="card bg-light">
                                                        <div class="card-body p-2">
                                                            <div class="d-flex align-items-center">
                                                                <div class="mr-2">
                                                                    <i class="fas fa-user-shield text-primary"></i>
                                                                </div>
                                                                <div>
                                                                    <strong><?= $anggota['nama'] ?></strong><br>
                                                                    <small class="text-muted"><?= $anggota['nrp'] ?> - <?= $anggota['pangkat'] ?></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-muted">Belum ada anggota yang ditugaskan</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">Tanggal Piket</label>
                                    <p class="text-muted">
                                        <?php
                                        $tanggal = date_create($piket['tanggal_piket']);
                                        echo $tanggal ? $tanggal->format('d F Y') : $piket['tanggal_piket'];
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">Shift</label>
                                    <p class="text-muted">
                                        <?php
                                        $shiftBadges = [
                                            'pagi' => '<span class="badge badge-info">Pagi</span>',
                                            'siang' => '<span class="badge badge-warning">Siang</span>',
                                            'malam' => '<span class="badge badge-dark">Malam</span>',
                                        ];
                                        echo $shiftBadges[$piket['shift']] ?? '<span class="badge badge-light">' . ucfirst($piket['shift']) . '</span>';
                                        ?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">Status</label>
                                    <p class="text-muted">
                                        <span class="badge badge-<?= $statusClass[$status] ?? 'light' ?>">
                                            <?= $statusText[$status] ?? ucfirst($status) ?>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">Jam Mulai</label>
                                    <p class="text-muted"><?= $piket['jam_mulai'] ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">Jam Selesai</label>
                                    <p class="text-muted"><?= $piket['jam_selesai'] ?></p>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <h5 class="text-bold">Lokasi & Detail</h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">
                                        <i class="fas fa-map-marker-alt mr-1"></i> Lokasi Piket
                                    </label>
                                    <p class="text-muted"><?= $piket['lokasi_piket'] ?: 'Polsek Lunang Silaut' ?></p>
                                </div>
                            </div>

                        </div>



                        <?php if ($piket['keterangan']): ?>
                            <div class="form-group">
                                <label class="text-bold">
                                    <i class="fas fa-sticky-note mr-1"></i> Keterangan
                                </label>
                                <p class="text-muted"><?= nl2br($piket['keterangan']) ?></p>
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
                                        if ($piket['created_at']) {
                                            $createdAt = is_string($piket['created_at']) ? date_create($piket['created_at']) : $piket['created_at'];
                                            echo $createdAt ? $createdAt->format('d F Y H:i') : $piket['created_at'];
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
                                        if ($piket['updated_at']) {
                                            $updatedAt = is_string($piket['updated_at']) ? date_create($piket['updated_at']) : $piket['updated_at'];
                                            echo $updatedAt ? $updatedAt->format('d F Y H:i') : $piket['updated_at'];
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
                text: 'Apakah Anda yakin ingin menghapus jadwal piket ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?= base_url('kasium/piket/delete/') ?>' + id;
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>