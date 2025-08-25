<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Detail Data Kasus<?= $this->endSection() ?>

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
                        <i class="fas fa-folder-open text-white" style="font-size: 2rem;"></i>
                    </div>
                </div>

                <h3 class="profile-username text-center"><?= esc($kasus['nomor_kasus']) ?></h3>

                <p class="text-muted text-center">
                    <?php
                    $statusBadges = [
                        'dilaporkan' => '<span class="badge badge-warning">Dilaporkan</span>',
                        'dalam_proses' => '<span class="badge badge-info">Dalam Proses</span>',
                        'selesai' => '<span class="badge badge-success">Selesai</span>',
                        'ditutup' => '<span class="badge badge-secondary">Ditutup</span>'
                    ];
                    echo $statusBadges[$kasus['status']] ?? '<span class="badge badge-light">' . ucfirst($kasus['status']) . '</span>';
                    ?>
                </p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b><i class="fas fa-file-alt mr-1"></i> Jenis Kasus</b>
                        <span class="float-right"><?= esc($kasus['nama_jenis'] ?? 'Tidak diketahui') ?></span>
                    </li>
                    <li class="list-group-item">
                        <b><i class="fas fa-exclamation-triangle mr-1"></i> Prioritas</b>
                        <span class="float-right">
                            <?php
                            $prioritasBadges = [
                                'rendah' => '<span class="badge badge-secondary">Rendah</span>',
                                'sedang' => '<span class="badge badge-primary">Sedang</span>',
                                'tinggi' => '<span class="badge badge-warning">Tinggi</span>',
                                'darurat' => '<span class="badge badge-danger">Darurat</span>'
                            ];
                            echo $prioritasBadges[$kasus['prioritas']] ?? '<span class="badge badge-light">' . ucfirst($kasus['prioritas']) . '</span>';
                            ?>
                        </span>
                    </li>
                    <li class="list-group-item">
                        <b><i class="fas fa-calendar mr-1"></i> Tgl Kejadian</b>
                        <span class="float-right"><?= date('d F Y', strtotime($kasus['tanggal_kejadian'])) ?></span>
                    </li>
                    <li class="list-group-item">
                        <b><i class="fas fa-calendar-plus mr-1"></i> Dilaporkan</b>
                        <span class="float-right"><?= date('d F Y', strtotime($kasus['created_at'])) ?></span>
                    </li>
                    <?php if ($kasus['petugas_nama']): ?>
                        <li class="list-group-item">
                            <b><i class="fas fa-user-shield mr-1"></i> Petugas</b>
                            <span class="float-right"><?= esc($kasus['petugas_nama']) ?></span>
                        </li>
                    <?php endif; ?>
                </ul>

                <div class="row">
                    <div class="col-6">
                        <a href="<?= base_url('spkt/kasus/edit/' . $kasus['id']) ?>" class="btn btn-warning btn-block">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-danger btn-block" onclick="deleteData(<?= $kasus['id'] ?>, '<?= esc($kasus['nomor_kasus']) ?>')">
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
                            <i class="fas fa-info-circle mr-1"></i> Detail Kasus
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#pelapor" data-toggle="tab">
                            <i class="fas fa-user mr-1"></i> Data Pelapor
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content">
                    <!-- Detail Kasus Tab -->
                    <div class="active tab-pane" id="detail">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">
                                        <i class="fas fa-hashtag mr-1"></i> Nomor Kasus
                                    </label>
                                    <p class="text-muted mb-0"><?= esc($kasus['nomor_kasus']) ?></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">
                                        <i class="fas fa-file-alt mr-1"></i> Jenis Kasus
                                    </label>
                                    <p class="text-muted mb-0"><?= esc($kasus['nama_jenis'] ?? 'Tidak diketahui') ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="text-bold">
                                        <i class="fas fa-heading mr-1"></i> Judul Kasus
                                    </label>
                                    <p class="text-muted mb-0"><?= esc($kasus['judul_kasus']) ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">
                                        <i class="fas fa-calendar mr-1"></i> Tanggal Kejadian
                                    </label>
                                    <p class="text-muted mb-0"><?= date('d F Y H:i', strtotime($kasus['tanggal_kejadian'])) ?></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">
                                        <i class="fas fa-map-marker-alt mr-1"></i> Lokasi Kejadian
                                    </label>
                                    <p class="text-muted mb-0"><?= esc($kasus['lokasi_kejadian']) ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">
                                        <i class="fas fa-flag mr-1"></i> Status
                                    </label>
                                    <p class="text-muted mb-0">
                                        <?php
                                        $statusBadges = [
                                            'dilaporkan' => '<span class="badge badge-warning">Dilaporkan</span>',
                                            'dalam_proses' => '<span class="badge badge-info">Dalam Proses</span>',
                                            'selesai' => '<span class="badge badge-success">Selesai</span>',
                                            'ditutup' => '<span class="badge badge-secondary">Ditutup</span>'
                                        ];
                                        echo $statusBadges[$kasus['status']] ?? '<span class="badge badge-light">' . ucfirst($kasus['status']) . '</span>';
                                        ?>
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">
                                        <i class="fas fa-exclamation-triangle mr-1"></i> Prioritas
                                    </label>
                                    <p class="text-muted mb-0">
                                        <?php
                                        $prioritasBadges = [
                                            'rendah' => '<span class="badge badge-secondary">Rendah</span>',
                                            'sedang' => '<span class="badge badge-primary">Sedang</span>',
                                            'tinggi' => '<span class="badge badge-warning">Tinggi</span>',
                                            'darurat' => '<span class="badge badge-danger">Darurat</span>'
                                        ];
                                        echo $prioritasBadges[$kasus['prioritas']] ?? '<span class="badge badge-light">' . ucfirst($kasus['prioritas']) . '</span>';
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="text-bold">
                                        <i class="fas fa-align-left mr-1"></i> Deskripsi/Kronologi Kejadian
                                    </label>
                                    <?php if ($kasus['deskripsi']): ?>
                                        <div class="card">
                                            <div class="card-body">
                                                <?= nl2br(esc($kasus['deskripsi'])) ?>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-muted mb-0 font-italic">Tidak ada deskripsi</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <?php if ($kasus['petugas_nama']): ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="text-bold">
                                            <i class="fas fa-user-shield mr-1"></i> Petugas Penanggungjawab
                                        </label>
                                        <p class="text-muted mb-0"><?= esc($kasus['petugas_nama']) ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Data Pelapor Tab -->
                    <div class="tab-pane" id="pelapor">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">
                                        <i class="fas fa-user mr-1"></i> Nama Pelapor
                                    </label>
                                    <p class="text-muted mb-0"><?= esc($kasus['pelapor_nama']) ?></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">
                                        <i class="fas fa-phone mr-1"></i> Telepon Pelapor
                                    </label>
                                    <p class="text-muted mb-0">
                                        <?php if ($kasus['pelapor_telepon']): ?>
                                            <a href="tel:<?= esc($kasus['pelapor_telepon']) ?>"><?= esc($kasus['pelapor_telepon']) ?></a>
                                        <?php else: ?>
                                            <span class="font-italic">Tidak ada nomor telepon</span>
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="text-bold">
                                        <i class="fas fa-home mr-1"></i> Alamat Pelapor
                                    </label>
                                    <?php if ($kasus['pelapor_alamat']): ?>
                                        <p class="text-muted mb-0"><?= nl2br(esc($kasus['pelapor_alamat'])) ?></p>
                                    <?php else: ?>
                                        <p class="text-muted mb-0 font-italic">Alamat tidak tersedia</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Timeline & Additional Info -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-clock mr-2"></i> Timeline Kasus
                </h3>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="time-label">
                        <span class="bg-success"><?= date('d F Y', strtotime($kasus['created_at'])) ?></span>
                    </div>
                    <div>
                        <i class="fas fa-plus bg-primary"></i>
                        <div class="timeline-item">
                            <span class="time"><i class="fas fa-clock"></i> <?= date('H:i', strtotime($kasus['created_at'])) ?></span>
                            <h3 class="timeline-header">Kasus Dilaporkan</h3>
                            <div class="timeline-body">
                                Kasus <?= esc($kasus['nomor_kasus']) ?> dilaporkan oleh <?= esc($kasus['pelapor_nama']) ?>
                                <?php if ($kasus['creator_nama']): ?>
                                    dan diinput oleh <?= esc($kasus['creator_nama']) ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php if ($kasus['updated_at'] && $kasus['updated_at'] != $kasus['created_at']): ?>
                        <div>
                            <i class="fas fa-edit bg-warning"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fas fa-clock"></i> <?= date('H:i', strtotime($kasus['updated_at'])) ?></span>
                                <h3 class="timeline-header">Data Diperbarui</h3>
                                <div class="timeline-body">
                                    Terakhir diperbarui pada <?= date('d F Y H:i', strtotime($kasus['updated_at'])) ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div>
                        <i class="fas fa-clock bg-gray"></i>
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
                        <a href="<?= base_url('spkt/kasus') ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
                        </a>
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="button" class="btn btn-info mr-2" onclick="updateStatus(<?= $kasus['id'] ?>, '<?= $kasus['status'] ?>')">
                            <i class="fas fa-flag mr-1"></i> Update Status
                        </button>
                        <a href="<?= base_url('spkt/kasus/edit/' . $kasus['id']) ?>" class="btn btn-warning mr-2">
                            <i class="fas fa-edit mr-1"></i> Edit Data
                        </a>
                        <button type="button" class="btn btn-danger" onclick="deleteData(<?= $kasus['id'] ?>, '<?= esc($kasus['nomor_kasus']) ?>')">
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
    function deleteData(id, nomorKasus) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            html: `Apakah Anda yakin ingin menghapus kasus:<br><strong>${nomorKasus}</strong>?`,
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
                    url: '<?= base_url('spkt/kasus/delete') ?>/' + id,
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
                                window.location.href = '<?= base_url('spkt/kasus') ?>';
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

    // Update status function
    function updateStatus(id, currentStatus) {
        const statusOptions = {
            'dilaporkan': 'Dilaporkan',
            'dalam_proses': 'Dalam Proses',
            'selesai': 'Selesai',
            'ditutup': 'Ditutup'
        };

        let selectOptions = '';
        for (const [value, label] of Object.entries(statusOptions)) {
            const selected = value === currentStatus ? 'selected' : '';
            selectOptions += `<option value="${value}" ${selected}>${label}</option>`;
        }

        Swal.fire({
            title: 'Update Status Kasus',
            html: `<select id="newStatus" class="form-control">${selectOptions}</select>`,
            showCancelButton: true,
            confirmButtonText: 'Update',
            cancelButtonText: 'Batal',
            preConfirm: () => {
                return document.getElementById('newStatus').value;
            }
        }).then((result) => {
            if (result.isConfirmed && result.value !== currentStatus) {
                $.ajax({
                    url: '<?= base_url('spkt/kasus/update-status') ?>/' + id,
                    type: 'POST',
                    data: {
                        status: result.value
                    },
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Berhasil!', response.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    }
                });
            }
        });
    }
</script>
<?= $this->endSection() ?>
