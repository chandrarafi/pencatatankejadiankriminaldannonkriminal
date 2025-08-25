<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Detail Jenis Kasus<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Profile Header -->
<div class="row">
    <div class="col-md-3">
        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <div class="profile-user-img img-fluid img-circle bg-primary d-flex align-items-center justify-content-center"
                        style="width: 80px; height: 80px; margin: 0 auto;">
                        <i class="fas fa-file-alt text-white" style="font-size: 2rem;"></i>
                    </div>
                </div>

                <h3 class="profile-username text-center"><?= esc($jenisKasus['nama_jenis']) ?></h3>

                <p class="text-muted text-center">
                    <span class="badge <?= $jenisKasus['is_active'] ? 'badge-success' : 'badge-secondary' ?>">
                        <?= $jenisKasus['is_active'] ? 'Aktif' : 'Non-Aktif' ?>
                    </span>
                </p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b><i class="fas fa-code mr-1"></i> Kode Jenis</b>
                        <span class="float-right"><?= esc($jenisKasus['kode_jenis']) ?></span>
                    </li>
                    <li class="list-group-item">
                        <b><i class="fas fa-calendar mr-1"></i> Dibuat</b>
                        <span class="float-right"><?= date('d F Y', strtotime($jenisKasus['created_at'])) ?></span>
                    </li>
                    <?php if ($jenisKasus['updated_at']): ?>
                        <li class="list-group-item">
                            <b><i class="fas fa-edit mr-1"></i> Diperbarui</b>
                            <span class="float-right"><?= date('d F Y', strtotime($jenisKasus['updated_at'])) ?></span>
                        </li>
                    <?php endif; ?>
                </ul>

                <div class="row">
                    <div class="col-6">
                        <a href="<?= base_url('spkt/jenis-kasus/edit/' . $jenisKasus['id']) ?>" class="btn btn-warning btn-block">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-danger btn-block" onclick="deleteData(<?= $jenisKasus['id'] ?>, '<?= esc($jenisKasus['nama_jenis']) ?>')">
                            <i class="fas fa-trash mr-1"></i> Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active" href="#detail" data-toggle="tab">
                            <i class="fas fa-info-circle mr-1"></i> Detail Jenis Kasus
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content">
                    <div class="active tab-pane" id="detail">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">
                                        <i class="fas fa-code mr-1"></i> Kode Jenis Kasus
                                    </label>
                                    <p class="text-muted mb-0"><?= esc($jenisKasus['kode_jenis']) ?></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">
                                        <i class="fas fa-file-alt mr-1"></i> Nama Jenis Kasus
                                    </label>
                                    <p class="text-muted mb-0"><?= esc($jenisKasus['nama_jenis']) ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">
                                        <i class="fas fa-toggle-on mr-1"></i> Status
                                    </label>
                                    <p class="text-muted mb-0">
                                        <span class="badge <?= $jenisKasus['is_active'] ? 'badge-success' : 'badge-secondary' ?>">
                                            <?= $jenisKasus['is_active'] ? 'Aktif' : 'Non-Aktif' ?>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="text-bold">
                                        <i class="fas fa-align-left mr-1"></i> Deskripsi
                                    </label>
                                    <?php if ($jenisKasus['deskripsi']): ?>
                                        <p class="text-muted mb-0"><?= nl2br(esc($jenisKasus['deskripsi'])) ?></p>
                                    <?php else: ?>
                                        <p class="text-muted mb-0 font-italic">Tidak ada deskripsi</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">
                                        <i class="fas fa-calendar-plus mr-1"></i> Tanggal Dibuat
                                    </label>
                                    <p class="text-muted mb-0"><?= date('d F Y H:i:s', strtotime($jenisKasus['created_at'])) ?></p>
                                </div>
                            </div>

                            <?php if ($jenisKasus['updated_at']): ?>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-bold">
                                            <i class="fas fa-calendar-edit mr-1"></i> Terakhir Diperbarui
                                        </label>
                                        <p class="text-muted mb-0"><?= date('d F Y H:i:s', strtotime($jenisKasus['updated_at'])) ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-6">
                        <a href="<?= base_url('spkt/jenis-kasus') ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
                        </a>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="<?= base_url('spkt/jenis-kasus/edit/' . $jenisKasus['id']) ?>" class="btn btn-warning mr-2">
                            <i class="fas fa-edit mr-1"></i> Edit Data
                        </a>
                        <button type="button" class="btn btn-danger" onclick="deleteData(<?= $jenisKasus['id'] ?>, '<?= esc($jenisKasus['nama_jenis']) ?>')">
                            <i class="fas fa-trash mr-1"></i> Hapus Data
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Delete function
    function deleteData(id, nama) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            html: `Apakah Anda yakin ingin menghapus jenis kasus:<br><strong>${nama}</strong>?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: '<i class="fas fa-trash mr-1"></i> Ya, Hapus!',
            cancelButtonText: '<i class="fas fa-times mr-1"></i> Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Menghapus...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // AJAX delete request
                $.ajax({
                    url: '<?= base_url('spkt/jenis-kasus/delete') ?>/' + id,
                    type: 'DELETE',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.message,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = '<?= base_url('spkt/jenis-kasus') ?>';
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message,
                                icon: 'error'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan sistem',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    }
</script>
<?= $this->endSection() ?>
