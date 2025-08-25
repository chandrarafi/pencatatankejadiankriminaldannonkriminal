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
                        <?php if ($pelapor['jenis_kelamin'] == 'L'): ?>
                            <span class="badge badge-primary">Laki-laki</span>
                        <?php elseif ($pelapor['jenis_kelamin'] == 'P'): ?>
                            <span class="badge badge-pink">Perempuan</span>
                        <?php endif; ?>
                    </span>
                </li>
            <?php endif; ?>

            <?php if ($pelapor['tanggal_lahir']): ?>
                <li class="list-group-item">
                    <b><i class="fas fa-birthday-cake mr-1"></i> Tanggal Lahir</b>
                    <span class="float-right">
                        <?php
                        $tanggalLahir = date_create($pelapor['tanggal_lahir']);
                        if ($tanggalLahir) {
                            echo $tanggalLahir->format('d F Y');
                            $umur = date_diff($tanggalLahir, date_create('today'))->y;
                            echo " <small class='text-muted'>($umur tahun)</small>";
                        }
                        ?>
                    </span>
                </li>
            <?php endif; ?>

            <!-- Kontak -->
            <?php if ($pelapor['telepon']): ?>
                <li class="list-group-item">
                    <b><i class="fas fa-phone mr-1"></i> Telepon</b>
                    <span class="float-right">
                        <a href="tel:<?= esc($pelapor['telepon']) ?>" class="text-decoration-none">
                            <?= esc($pelapor['telepon']) ?>
                        </a>
                    </span>
                </li>
            <?php endif; ?>

            <?php if ($pelapor['email']): ?>
                <li class="list-group-item">
                    <b><i class="fas fa-envelope mr-1"></i> Email</b>
                    <span class="float-right">
                        <a href="mailto:<?= esc($pelapor['email']) ?>" class="text-decoration-none">
                            <?= esc($pelapor['email']) ?>
                        </a>
                    </span>
                </li>
            <?php endif; ?>
        </ul>

        <div class="row">
            <div class="col-12">
                <a href="<?= base_url('spkt/pelapor/edit/' . $pelapor['id']) ?>" class="btn btn-warning btn-block">
                    <i class="fas fa-edit mr-1"></i> Edit Data Pelapor
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Address & Additional Info -->
<div class="row">
    <div class="col-md-8">
        <!-- Alamat Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-map-marker-alt mr-2"></i>
                    Alamat Lengkap
                </h3>
            </div>
            <div class="card-body">
                <?php if ($pelapor['alamat'] || $pelapor['kelurahan'] || $pelapor['kecamatan'] || $pelapor['kota_kabupaten'] || $pelapor['provinsi']): ?>
                    <address class="mb-0">
                        <?php if ($pelapor['alamat']): ?>
                            <strong><?= esc($pelapor['alamat']) ?></strong><br>
                        <?php endif; ?>

                        <?php if ($pelapor['kelurahan']): ?>
                            Kelurahan <?= esc($pelapor['kelurahan']) ?><br>
                        <?php endif; ?>

                        <?php if ($pelapor['kecamatan']): ?>
                            Kecamatan <?= esc($pelapor['kecamatan']) ?><br>
                        <?php endif; ?>

                        <?php if ($pelapor['kota_kabupaten']): ?>
                            <?= esc($pelapor['kota_kabupaten']) ?><br>
                        <?php endif; ?>

                        <?php if ($pelapor['provinsi']): ?>
                            <?= esc($pelapor['provinsi']) ?>
                        <?php endif; ?>

                        <?php if ($pelapor['kode_pos']): ?>
                            <?= esc($pelapor['kode_pos']) ?>
                        <?php endif; ?>
                    </address>
                <?php else: ?>
                    <p class="text-muted mb-0">
                        <i class="fas fa-info-circle mr-1"></i>
                        Alamat belum dilengkapi
                    </p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Keterangan Card -->
        <?php if ($pelapor['keterangan']): ?>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-sticky-note mr-2"></i>
                        Keterangan
                    </h3>
                </div>
                <div class="card-body">
                    <p class="mb-0"><?= nl2br(esc($pelapor['keterangan'])) ?></p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="col-md-4">
        <!-- Action Buttons -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-cogs mr-2"></i>
                    Aksi
                </h3>
            </div>
            <div class="card-body">
                <div class="btn-group-vertical btn-block">
                    <a href="<?= base_url('spkt/pelapor/edit/' . $pelapor['id']) ?>" class="btn btn-warning">
                        <i class="fas fa-edit mr-1"></i> Edit Data
                    </a>
                    <button type="button" class="btn btn-danger" onclick="deleteData(<?= $pelapor['id'] ?>, '<?= esc($pelapor['nama']) ?>')">
                        <i class="fas fa-trash mr-1"></i> Hapus Data
                    </button>
                    <a href="<?= base_url('spkt/pelapor') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Info Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle mr-2"></i>
                    Informasi Sistem
                </h3>
            </div>
            <div class="card-body">
                <small class="text-muted">
                    <i class="fas fa-calendar-plus mr-1"></i>
                    <strong>Dibuat:</strong><br>
                    <?php
                    $createdAt = date_create($pelapor['created_at']);
                    if ($createdAt) {
                        echo $createdAt->format('d F Y, H:i');
                    }
                    ?><br><br>

                    <i class="fas fa-calendar-edit mr-1"></i>
                    <strong>Diperbarui:</strong><br>
                    <?php
                    $updatedAt = date_create($pelapor['updated_at']);
                    if ($updatedAt) {
                        echo $updatedAt->format('d F Y, H:i');
                    }
                    ?>
                </small>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<style>
    .badge-pink {
        background-color: #e83e8c;
        color: white;
    }

    .badge-lg {
        font-size: 0.875em;
        padding: 0.5rem 0.75rem;
    }
</style>

<script>
    // Delete function
    function deleteData(id, nama) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            html: `Apakah Anda yakin ingin menghapus data pelapor:<br><strong>${nama}</strong>?`,
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
                    url: '<?= base_url('spkt/pelapor/delete') ?>/' + id,
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
                                window.location.href = '<?= base_url('spkt/pelapor') ?>';
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