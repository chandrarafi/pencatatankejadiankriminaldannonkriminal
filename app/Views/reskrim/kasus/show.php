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

<!-- Related Parties Information -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-users mr-2"></i>
                    Pihak Terkait dalam Kasus
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" id="relatedPartiesTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="korban-tab" data-toggle="tab" href="#korban" role="tab">
                            <i class="fas fa-user-injured mr-1"></i> Korban <span class="badge badge-secondary" id="korban-count">0</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tersangka-tab" data-toggle="tab" href="#tersangka" role="tab">
                            <i class="fas fa-user-secret mr-1"></i> Tersangka <span class="badge badge-secondary" id="tersangka-count">0</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="saksi-tab" data-toggle="tab" href="#saksi" role="tab">
                            <i class="fas fa-user-friends mr-1"></i> Saksi <span class="badge badge-secondary" id="saksi-count">0</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="summary-tab" data-toggle="tab" href="#summary" role="tab">
                            <i class="fas fa-chart-pie mr-1"></i> Ringkasan
                        </a>
                    </li>
                </ul>

                <!-- Tab content -->
                <div class="tab-content mt-3" id="relatedPartiesTabContent">
                    <!-- Korban Tab -->
                    <div class="tab-pane fade show active" id="korban" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Data Korban</h5>
                            <a href="<?= base_url('reskrim/korban/create?kasus_id=' . $kasus['id']) ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus mr-1"></i> Tambah Korban
                            </a>
                        </div>
                        <div id="korban-list">
                            <div class="text-center py-4">
                                <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
                                <p class="text-muted mt-2">Memuat data korban...</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tersangka Tab -->
                    <div class="tab-pane fade" id="tersangka" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Data Tersangka</h5>
                            <a href="<?= base_url('reskrim/tersangka/create?kasus_id=' . $kasus['id']) ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus mr-1"></i> Tambah Tersangka
                            </a>
                        </div>
                        <div id="tersangka-list">
                            <div class="text-center py-4">
                                <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
                                <p class="text-muted mt-2">Memuat data tersangka...</p>
                            </div>
                        </div>
                    </div>

                    <!-- Saksi Tab -->
                    <div class="tab-pane fade" id="saksi" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Data Saksi</h5>
                            <a href="<?= base_url('reskrim/saksi/create?kasus_id=' . $kasus['id']) ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus mr-1"></i> Tambah Saksi
                            </a>
                        </div>
                        <div id="saksi-list">
                            <div class="text-center py-4">
                                <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
                                <p class="text-muted mt-2">Memuat data saksi...</p>
                            </div>
                        </div>
                    </div>

                    <!-- Summary Tab -->
                    <div class="tab-pane fade" id="summary" role="tabpanel">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="info-box">
                                    <span class="info-box-icon bg-info">
                                        <i class="fas fa-user-injured"></i>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Korban</span>
                                        <span class="info-box-number" id="summary-korban">0</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box">
                                    <span class="info-box-icon bg-warning">
                                        <i class="fas fa-user-secret"></i>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Tersangka</span>
                                        <span class="info-box-number" id="summary-tersangka">0</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box">
                                    <span class="info-box-icon bg-success">
                                        <i class="fas fa-user-friends"></i>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Saksi</span>
                                        <span class="info-box-number" id="summary-saksi">0</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card card-outline card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fas fa-clipboard-list mr-2"></i>
                                            Progress Investigasi
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="progress-group">
                                            Data Pelapor
                                            <span class="float-right"><b>1</b>/1</span>
                                            <div class="progress progress-sm">
                                                <div class="progress-bar bg-success" style="width: 100%"></div>
                                            </div>
                                        </div>
                                        <div class="progress-group">
                                            Data Korban
                                            <span class="float-right"><b id="progress-korban">0</b>/1+</span>
                                            <div class="progress progress-sm">
                                                <div class="progress-bar bg-info" id="progress-bar-korban" style="width: 0%"></div>
                                            </div>
                                        </div>
                                        <div class="progress-group">
                                            Data Tersangka
                                            <span class="float-right"><b id="progress-tersangka">0</b>/1+</span>
                                            <div class="progress progress-sm">
                                                <div class="progress-bar bg-warning" id="progress-bar-tersangka" style="width: 0%"></div>
                                            </div>
                                        </div>
                                        <div class="progress-group">
                                            Data Saksi
                                            <span class="float-right"><b id="progress-saksi">0</b>/1+</span>
                                            <div class="progress progress-sm">
                                                <div class="progress-bar bg-success" id="progress-bar-saksi" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Update Status Card for RESKRIM -->
<?php if ($kasus['status'] !== 'ditutup'): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit mr-2"></i>
                        Update Status Kasus (RESKRIM)
                    </h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-2"></i>
                        <strong>Instruksi:</strong> RESKRIM dapat memperbarui status kasus berdasarkan perkembangan investigasi.
                    </div>

                    <form id="updateStatusForm">
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status Kasus <span class="text-danger">*</span></label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="">-- Pilih Status --</option>
                                        <option value="dalam_proses" <?= $kasus['status'] == 'dalam_proses' ? 'selected' : '' ?>>Dalam Proses</option>
                                        <option value="selesai" <?= $kasus['status'] == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                                        <option value="ditutup" <?= $kasus['status'] == 'ditutup' ? 'selected' : '' ?>>Ditutup</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="keterangan">Keterangan Update</label>
                                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3"
                                        placeholder="Tambahkan catatan atau keterangan untuk update status ini..."><?= $kasus['keterangan'] ?? '' ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save mr-1"></i> Update Status Kasus
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="window.location.reload()">
                                <i class="fas fa-undo mr-1"></i> Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Load related parties data
        loadRelatedParties();

        // Handle tab switching
        $('#relatedPartiesTab a').on('click', function(e) {
            e.preventDefault();
            $(this).tab('show');
        });

        // Handle status update form submission
        $('#updateStatusForm').on('submit', function(e) {
            e.preventDefault();

            const formData = {
                status: $('#status').val(),
                keterangan: $('#keterangan').val(),
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
            };

            // Validate required fields
            if (!formData.status) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Status kasus harus dipilih!'
                });
                return;
            }

            // Confirm update
            Swal.fire({
                title: 'Konfirmasi Update',
                text: 'Apakah Anda yakin ingin mengupdate status kasus ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ffc107',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Update!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Sedang mengupdate status kasus',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Submit update
                    $.ajax({
                        url: '<?= base_url('reskrim/kasus/update-status/' . $kasus['id']) ?>',
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    // Reload page to show updated status
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: response.message || 'Gagal mengupdate status kasus'
                                });
                            }
                        },
                        error: function(xhr) {
                            console.error('Error:', xhr);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Terjadi kesalahan saat mengupdate status kasus'
                            });
                        }
                    });
                }
            });
        });

        // Show status change warning
        $('#status').on('change', function() {
            const newStatus = $(this).val();
            const currentStatus = '<?= $kasus['status'] ?>';

            if (newStatus && newStatus !== currentStatus) {
                let statusText = '';
                switch (newStatus) {
                    case 'dalam_proses':
                        statusText = 'Kasus akan ditandai sebagai sedang dalam proses investigasi';
                        break;
                    case 'selesai':
                        statusText = 'Kasus akan ditandai sebagai selesai dan siap untuk ditutup oleh SPKT';
                        break;
                    case 'ditutup':
                        statusText = 'Kasus akan ditutup dan tidak dapat diubah lagi';
                        break;
                }

                if (statusText) {
                    $('#statusHelp').remove();
                    $(this).parent().append(`<small id="statusHelp" class="form-text text-muted">${statusText}</small>`);
                }
            }
        });

        // Function to load related parties data
        function loadRelatedParties() {
            const kasusId = <?= $kasus['id'] ?>;

            // Load Korban data
            loadKorbanData(kasusId);

            // Load Tersangka data  
            loadTersangkaData(kasusId);

            // Load Saksi data
            loadSaksiData(kasusId);
        }

        function loadKorbanData(kasusId) {
            $.ajax({
                url: '<?= base_url('reskrim/korban/get-by-kasus/') ?>' + kasusId,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        const data = response.data;
                        let html = '';

                        if (data.length > 0) {
                            data.forEach(function(korban) {
                                html += `
                                    <div class="card card-outline">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <h6 class="card-title font-weight-bold">${korban.nama}</h6>
                                                    <p class="card-text">
                                                        <small class="text-muted">
                                                            <i class="fas fa-id-card mr-1"></i> ${korban.nik || '-'} |
                                                            <i class="fas fa-venus-mars mr-1"></i> ${korban.jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan'} |
                                                            <i class="fas fa-calendar mr-1"></i> ${korban.umur || '-'} tahun
                                                        </small>
                                                    </p>
                                                    <p class="card-text">
                                                        <i class="fas fa-map-marker-alt mr-1"></i> ${korban.alamat || '-'}
                                                    </p>
                                                    <span class="badge badge-${getStatusBadgeClass(korban.status_korban)}">${getStatusLabel(korban.status_korban)}</span>
                                                </div>
                                                <div class="col-md-4 text-right">
                                                    <a href="<?= base_url('reskrim/korban/show/') ?>${korban.id}" class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye mr-1"></i> Detail
                                                    </a>
                                                    <a href="<?= base_url('reskrim/korban/edit/') ?>${korban.id}" class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit mr-1"></i> Edit
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            });
                        } else {
                            html = `
                                <div class="text-center py-4">
                                    <i class="fas fa-user-injured fa-3x text-muted"></i>
                                    <p class="text-muted mt-2">Belum ada data korban untuk kasus ini</p>
                                    <a href="<?= base_url('reskrim/korban/create?kasus_id=' . $kasus['id']) ?>" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus mr-1"></i> Tambah Korban
                                    </a>
                                </div>
                            `;
                        }

                        $('#korban-list').html(html);
                        $('#korban-count').text(data.length);
                        $('#summary-korban').text(data.length);
                        $('#progress-korban').text(data.length);
                        updateProgressBar('korban', data.length);
                    }
                },
                error: function() {
                    $('#korban-list').html('<div class="alert alert-danger">Gagal memuat data korban</div>');
                }
            });
        }

        function loadTersangkaData(kasusId) {
            $.ajax({
                url: '<?= base_url('reskrim/tersangka/get-by-kasus/') ?>' + kasusId,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        const data = response.data;
                        let html = '';

                        if (data.length > 0) {
                            data.forEach(function(tersangka) {
                                html += `
                                    <div class="card card-outline">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <h6 class="card-title font-weight-bold">${tersangka.nama}</h6>
                                                    <p class="card-text">
                                                        <small class="text-muted">
                                                            <i class="fas fa-id-card mr-1"></i> ${tersangka.nik || '-'} |
                                                            <i class="fas fa-venus-mars mr-1"></i> ${tersangka.jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan'} |
                                                            <i class="fas fa-calendar mr-1"></i> ${tersangka.umur || '-'} tahun
                                                        </small>
                                                    </p>
                                                    <p class="card-text">
                                                        <i class="fas fa-map-marker-alt mr-1"></i> ${tersangka.alamat || '-'}
                                                    </p>
                                                    <span class="badge badge-${getTersangkaStatusBadgeClass(tersangka.status_tersangka)}">${getTersangkaStatusLabel(tersangka.status_tersangka)}</span>
                                                </div>
                                                <div class="col-md-4 text-right">
                                                    <a href="<?= base_url('reskrim/tersangka/show/') ?>${tersangka.id}" class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye mr-1"></i> Detail
                                                    </a>
                                                    <a href="<?= base_url('reskrim/tersangka/edit/') ?>${tersangka.id}" class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit mr-1"></i> Edit
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            });
                        } else {
                            html = `
                                <div class="text-center py-4">
                                    <i class="fas fa-user-secret fa-3x text-muted"></i>
                                    <p class="text-muted mt-2">Belum ada data tersangka untuk kasus ini</p>
                                    <a href="<?= base_url('reskrim/tersangka/create?kasus_id=' . $kasus['id']) ?>" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus mr-1"></i> Tambah Tersangka
                                    </a>
                                </div>
                            `;
                        }

                        $('#tersangka-list').html(html);
                        $('#tersangka-count').text(data.length);
                        $('#summary-tersangka').text(data.length);
                        $('#progress-tersangka').text(data.length);
                        updateProgressBar('tersangka', data.length);
                    }
                },
                error: function() {
                    $('#tersangka-list').html('<div class="alert alert-danger">Gagal memuat data tersangka</div>');
                }
            });
        }

        function loadSaksiData(kasusId) {
            $.ajax({
                url: '<?= base_url('reskrim/saksi/get-by-kasus/') ?>' + kasusId,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        const data = response.data;
                        let html = '';

                        if (data.length > 0) {
                            data.forEach(function(saksi) {
                                html += `
                                    <div class="card card-outline">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <h6 class="card-title font-weight-bold">${saksi.nama}</h6>
                                                    <p class="card-text">
                                                        <small class="text-muted">
                                                            <i class="fas fa-id-card mr-1"></i> ${saksi.nik || '-'} |
                                                            <i class="fas fa-venus-mars mr-1"></i> ${saksi.jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan'} |
                                                            <i class="fas fa-calendar mr-1"></i> ${saksi.umur || '-'} tahun
                                                        </small>
                                                    </p>
                                                    <p class="card-text">
                                                        <i class="fas fa-map-marker-alt mr-1"></i> ${saksi.alamat || '-'}
                                                    </p>
                                                    ${saksi.jenis_saksi ? `<span class="badge badge-info">${saksi.jenis_saksi}</span>` : ''}
                                                    ${saksi.dapat_dihubungi ? '<span class="badge badge-success ml-1">Dapat Dihubungi</span>' : '<span class="badge badge-secondary ml-1">Tidak Dapat Dihubungi</span>'}
                                                </div>
                                                <div class="col-md-4 text-right">
                                                    <a href="<?= base_url('reskrim/saksi/show/') ?>${saksi.id}" class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye mr-1"></i> Detail
                                                    </a>
                                                    <a href="<?= base_url('reskrim/saksi/edit/') ?>${saksi.id}" class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit mr-1"></i> Edit
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            });
                        } else {
                            html = `
                                <div class="text-center py-4">
                                    <i class="fas fa-user-friends fa-3x text-muted"></i>
                                    <p class="text-muted mt-2">Belum ada data saksi untuk kasus ini</p>
                                    <a href="<?= base_url('reskrim/saksi/create?kasus_id=' . $kasus['id']) ?>" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus mr-1"></i> Tambah Saksi
                                    </a>
                                </div>
                            `;
                        }

                        $('#saksi-list').html(html);
                        $('#saksi-count').text(data.length);
                        $('#summary-saksi').text(data.length);
                        $('#progress-saksi').text(data.length);
                        updateProgressBar('saksi', data.length);
                    }
                },
                error: function() {
                    $('#saksi-list').html('<div class="alert alert-danger">Gagal memuat data saksi</div>');
                }
            });
        }

        function getStatusBadgeClass(status) {
            const statusClasses = {
                'hidup': 'success',
                'meninggal': 'danger',
                'luka': 'warning',
                'hilang': 'dark'
            };
            return statusClasses[status] || 'secondary';
        }

        function getStatusLabel(status) {
            const statusLabels = {
                'hidup': 'Hidup',
                'meninggal': 'Meninggal',
                'luka': 'Luka',
                'hilang': 'Hilang'
            };
            return statusLabels[status] || status;
        }

        function getTersangkaStatusBadgeClass(status) {
            const statusClasses = {
                'ditangkap': 'warning',
                'ditahan': 'danger',
                'buron': 'dark',
                'diserahkan': 'success'
            };
            return statusClasses[status] || 'secondary';
        }

        function getTersangkaStatusLabel(status) {
            const statusLabels = {
                'ditangkap': 'Ditangkap',
                'ditahan': 'Ditahan',
                'buron': 'Buron',
                'diserahkan': 'Diserahkan'
            };
            return statusLabels[status] || status;
        }

        function updateProgressBar(type, count) {
            const percentage = Math.min(count * 50, 100); // 50% per person, max 100%
            $(`#progress-bar-${type}`).css('width', percentage + '%');
        }
    });
</script>
<?= $this->endSection() ?>