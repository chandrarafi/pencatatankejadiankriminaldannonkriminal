<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Tambah Data Kasus<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Main Form Card -->
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-plus mr-2"></i>
            Tambah Data Kasus Baru
        </h3>
        <div class="card-tools">
            <a href="<?= base_url('spkt/kasus') ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>
    </div>

    <form id="formKasus">
        <div class="card-body">
            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="jenis_kasus_id">
                            <i class="fas fa-file-alt mr-1"></i>Jenis Kasus
                            <span class="text-danger">*</span>
                        </label>
                        <select class="form-control" id="jenis_kasus_id" name="jenis_kasus_id" required>
                            <option value="">-- Pilih Jenis Kasus --</option>
                            <?php foreach ($jenisKasusList as $jenis): ?>
                                <option value="<?= $jenis['id'] ?>"><?= esc($jenis['nama_jenis']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback" id="error-jenis_kasus_id"></div>
                    </div>

                    <div class="form-group">
                        <label for="judul_kasus">
                            <i class="fas fa-heading mr-1"></i>Judul Kasus
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="judul_kasus" name="judul_kasus"
                            placeholder="Masukkan judul singkat kasus" maxlength="255" required>
                        <div class="invalid-feedback" id="error-judul_kasus"></div>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_kejadian">
                            <i class="fas fa-calendar mr-1"></i>Tanggal Kejadian
                            <span class="text-danger">*</span>
                        </label>
                        <input type="datetime-local" class="form-control" id="tanggal_kejadian" name="tanggal_kejadian" required>
                        <div class="invalid-feedback" id="error-tanggal_kejadian"></div>
                    </div>

                    <div class="form-group">
                        <label for="lokasi_kejadian">
                            <i class="fas fa-map-marker-alt mr-1"></i>Lokasi Kejadian
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="lokasi_kejadian" name="lokasi_kejadian"
                            placeholder="Alamat/tempat terjadinya kejadian" maxlength="255" required>
                        <div class="invalid-feedback" id="error-lokasi_kejadian"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">
                                    <i class="fas fa-flag mr-1"></i>Status
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="dilaporkan" selected>Dilaporkan</option>
                                    <option value="dalam_proses">Dalam Proses</option>
                                    <option value="selesai">Selesai</option>
                                    <option value="ditutup">Ditutup</option>
                                </select>
                                <div class="invalid-feedback" id="error-status"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="prioritas">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>Prioritas
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-control" id="prioritas" name="prioritas" required>
                                    <option value="rendah">Rendah</option>
                                    <option value="sedang" selected>Sedang</option>
                                    <option value="tinggi">Tinggi</option>
                                    <option value="darurat">Darurat</option>
                                </select>
                                <div class="invalid-feedback" id="error-prioritas"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="pelapor_id">
                            <i class="fas fa-users mr-1"></i>Data Pelapor
                        </label>
                        <div class="input-group">
                            <input type="hidden" id="pelapor_id" name="pelapor_id">
                            <input type="text" class="form-control" id="pelapor_display"
                                placeholder="Klik untuk pilih pelapor..." readonly>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalPelapor">
                                    <i class="fas fa-search"></i>
                                </button>
                                <button type="button" class="btn btn-secondary" id="clearPelapor" title="Clear">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <small class="form-text text-muted">Pilih dari data pelapor yang sudah ada, atau isi manual di bawah</small>
                        <div class="invalid-feedback" id="error-pelapor_id"></div>
                    </div>

                    <div class="form-group">
                        <label for="pelapor_nama">
                            <i class="fas fa-user mr-1"></i>Nama Pelapor
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="pelapor_nama" name="pelapor_nama"
                            placeholder="Nama lengkap pelapor" maxlength="255" required>
                        <div class="invalid-feedback" id="error-pelapor_nama"></div>
                    </div>

                    <div class="form-group">
                        <label for="pelapor_telepon">
                            <i class="fas fa-phone mr-1"></i>Telepon Pelapor
                        </label>
                        <input type="text" class="form-control" id="pelapor_telepon" name="pelapor_telepon"
                            placeholder="Nomor telepon/HP pelapor" maxlength="20">
                        <div class="invalid-feedback" id="error-pelapor_telepon"></div>
                    </div>

                    <div class="form-group">
                        <label for="pelapor_alamat">
                            <i class="fas fa-home mr-1"></i>Alamat Pelapor
                        </label>
                        <textarea class="form-control" id="pelapor_alamat" name="pelapor_alamat" rows="3"
                            placeholder="Alamat lengkap pelapor"></textarea>
                        <div class="invalid-feedback" id="error-pelapor_alamat"></div>
                    </div>

                    <div class="form-group">
                        <label for="petugas_id">
                            <i class="fas fa-user-shield mr-1"></i>Petugas Penanggungjawab
                        </label>
                        <div class="input-group">
                            <input type="hidden" id="petugas_id" name="petugas_id">
                            <input type="text" class="form-control" id="petugas_display"
                                placeholder="Klik untuk pilih petugas (opsional)..." readonly>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalPetugas">
                                    <i class="fas fa-search"></i>
                                </button>
                                <button type="button" class="btn btn-secondary" id="clearPetugas" title="Clear">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <small class="form-text text-muted">Petugas yang akan menangani kasus ini</small>
                        <div class="invalid-feedback" id="error-petugas_id"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="deskripsi">
                            <i class="fas fa-align-left mr-1"></i>Deskripsi/Kronologi Kejadian
                        </label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="6"
                            placeholder="Deskripsikan secara detail kronologi kejadian, barang bukti, dan informasi penting lainnya..."></textarea>
                        <small class="form-text text-muted">Uraikan secara detail tentang kejadian, termasuk kronologi dan barang bukti</small>
                        <div class="invalid-feedback" id="error-deskripsi"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <div class="row">
                <div class="col-md-6">
                    <small class="text-muted">
                        <i class="fas fa-info-circle mr-1"></i>
                        Field yang bertanda <span class="text-danger">*</span> wajib diisi
                    </small>
                </div>
                <div class="col-md-6 text-right">
                    <button type="button" class="btn btn-secondary mr-2" onclick="window.history.back()">
                        <i class="fas fa-times mr-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary" id="btnSubmit">
                        <i class="fas fa-save mr-1"></i> Simpan Data Kasus
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Modal Pilih Pelapor -->
<div class="modal fade" id="modalPelapor" tabindex="-1" role="dialog" aria-labelledby="modalPelaporLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="modalPelaporLabel">
                    <i class="fas fa-users mr-2"></i>Pilih Data Pelapor
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Search Input -->
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchPelapor" placeholder="Cari berdasarkan nama, NIK, atau telepon...">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="btnSearchPelapor">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Loading -->
                <div id="loadingPelapor" class="text-center" style="display: none;">
                    <i class="fas fa-spinner fa-spin"></i> Memuat data...
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="tablePelaporModal">
                        <thead class="thead-light">
                            <tr>
                                <th width="5%">Pilih</th>
                                <th width="25%">Nama</th>
                                <th width="15%">NIK</th>
                                <th width="15%">Telepon</th>
                                <th width="10%">J. Kelamin</th>
                                <th width="30%">Alamat</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyPelapor">
                            <!-- Data akan diload via AJAX -->
                        </tbody>
                    </table>
                </div>

                <!-- No Data -->
                <div id="noDataPelapor" class="text-center text-muted" style="display: none;">
                    <i class="fas fa-info-circle"></i> Tidak ada data pelapor ditemukan
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Tutup
                </button>
                <a href="<?= base_url('spkt/pelapor/create') ?>" class="btn btn-primary" target="_blank">
                    <i class="fas fa-plus mr-1"></i> Tambah Pelapor Baru
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pilih Petugas -->
<div class="modal fade" id="modalPetugas" tabindex="-1" role="dialog" aria-labelledby="modalPetugasLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white" id="modalPetugasLabel">
                    <i class="fas fa-user-shield mr-2"></i>Pilih Petugas Penanggungjawab
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Search Input -->
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchPetugas" placeholder="Cari berdasarkan nama atau role...">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="btnSearchPetugas">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Filter Role -->
                <div class="form-group">
                    <select class="form-control" id="filterRole">
                        <option value="">Semua Role</option>
                        <option value="kasium">Kasium</option>
                        <option value="reskrim">Reskrim</option>
                        <option value="kapolsek">Kapolsek</option>
                    </select>
                </div>

                <!-- Loading -->
                <div id="loadingPetugas" class="text-center" style="display: none;">
                    <i class="fas fa-spinner fa-spin"></i> Memuat data...
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="tablePetugasModal">
                        <thead class="thead-light">
                            <tr>
                                <th width="5%">Pilih</th>
                                <th width="35%">Nama Lengkap</th>
                                <th width="20%">Username</th>
                                <th width="20%">Role</th>
                                <th width="20%">Status</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyPetugas">
                            <!-- Data akan diload via AJAX -->
                        </tbody>
                    </table>
                </div>

                <!-- No Data -->
                <div id="noDataPetugas" class="text-center text-muted" style="display: none;">
                    <i class="fas fa-info-circle"></i> Tidak ada data petugas ditemukan
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<style>
    .cursor-pointer {
        cursor: pointer;
    }

    .cursor-pointer:hover {
        background-color: rgba(0, 123, 255, 0.1);
    }

    .modal-lg {
        max-width: 900px;
    }
</style>
<script>
    $(document).ready(function() {
        // ===== MODAL PELAPOR FUNCTIONALITY =====

        // Load pelapor data when modal is opened
        $('#modalPelapor').on('show.bs.modal', function() {
            loadPelaporData();
        });

        // Search pelapor functionality
        $('#searchPelapor, #btnSearchPelapor').on('keyup click', function(e) {
            if (e.type === 'keyup' && e.keyCode !== 13) return;
            loadPelaporData($('#searchPelapor').val());
        });

        // Clear pelapor selection
        $('#clearPelapor').on('click', function() {
            clearPelaporSelection();
        });

        // Load pelapor data function
        function loadPelaporData(search = '') {
            $('#loadingPelapor').show();
            $('#noDataPelapor').hide();
            $('#tbodyPelapor').empty();

            $.ajax({
                url: '<?= base_url('spkt/pelapor/get-data') ?>',
                type: 'POST',
                data: {
                    start: 0,
                    length: 50,
                    search: {
                        value: search
                    }
                },
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    $('#loadingPelapor').hide();

                    if (response.data && response.data.length > 0) {
                        let html = '';
                        response.data.forEach(function(row, index) {
                            // Parse the original data structure from server
                            const nama = row[0];
                            const nik = row[1];
                            const telepon = row[2];
                            const email = row[3];
                            const jenisKelamin = row[4];
                            const kota = row[5];
                            const id = row[8]; // ID is at index 8

                            html += `
                            <tr class="cursor-pointer" onclick="selectPelapor('${id}', '${nama}', '${nik}', '${telepon}', '${kota}')">
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-primary">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </td>
                                <td><strong>${nama}</strong></td>
                                <td>${nik}</td>
                                <td>${telepon}</td>
                                <td>${jenisKelamin}</td>
                                <td>${kota}</td>
                            </tr>
                        `;
                        });
                        $('#tbodyPelapor').html(html);
                    } else {
                        $('#noDataPelapor').show();
                    }
                },
                error: function() {
                    $('#loadingPelapor').hide();
                    $('#noDataPelapor').show();
                }
            });
        }

        // Select pelapor function
        window.selectPelapor = function(id, nama, nik, telepon, kota) {
            // Set the pelapor ID
            $('#pelapor_id').val(id);

            // Set display text
            let displayText = nama;
            if (nik && nik !== '-') {
                displayText += ` (${nik})`;
            }
            $('#pelapor_display').val(displayText);

            // Fill form fields
            $('#pelapor_nama').val(nama).prop('readonly', true).addClass('bg-light');
            if (telepon && telepon !== '-') {
                $('#pelapor_telepon').val(telepon).prop('readonly', true).addClass('bg-light');
            }
            if (kota && kota !== '-') {
                $('#pelapor_alamat').val(kota).prop('readonly', true).addClass('bg-light');
            }

            // Close modal
            $('#modalPelapor').modal('hide');
        };

        // Clear pelapor selection
        function clearPelaporSelection() {
            $('#pelapor_id').val('');
            $('#pelapor_display').val('');
            $('#pelapor_nama, #pelapor_telepon, #pelapor_alamat').val('').prop('readonly', false).removeClass('bg-light');
        }

        // ===== MODAL PETUGAS FUNCTIONALITY =====

        // Load petugas data when modal is opened
        $('#modalPetugas').on('show.bs.modal', function() {
            loadPetugasData();
        });

        // Search petugas functionality
        $('#searchPetugas, #btnSearchPetugas, #filterRole').on('keyup click change', function(e) {
            if (e.type === 'keyup' && e.keyCode !== 13) return;
            loadPetugasData($('#searchPetugas').val(), $('#filterRole').val());
        });

        // Clear petugas selection
        $('#clearPetugas').on('click', function() {
            clearPetugasSelection();
        });

        // Load petugas data function
        function loadPetugasData(search = '', role = '') {
            $('#loadingPetugas').show();
            $('#noDataPetugas').hide();
            $('#tbodyPetugas').empty();

            $.ajax({
                url: '<?= base_url('spkt/kasus/get-petugas-data') ?>',
                type: 'POST',
                data: {
                    search: search,
                    role: role
                },
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    $('#loadingPetugas').hide();

                    if (response.success && response.data.length > 0) {
                        let html = '';
                        response.data.forEach(function(petugas) {
                            const roleClass = {
                                'kasium': 'badge-info',
                                'reskrim': 'badge-warning',
                                'kapolsek': 'badge-danger'
                            };

                            html += `
                            <tr class="cursor-pointer" onclick="selectPetugas('${petugas.id}', '${petugas.fullname}', '${petugas.role}')">
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-success">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </td>
                                <td><strong>${petugas.fullname}</strong></td>
                                <td>${petugas.username}</td>
                                <td><span class="badge ${roleClass[petugas.role] || 'badge-secondary'}">${petugas.role.toUpperCase()}</span></td>
                                <td><span class="badge badge-success">Aktif</span></td>
                            </tr>
                        `;
                        });
                        $('#tbodyPetugas').html(html);
                    } else {
                        $('#noDataPetugas').show();
                    }
                },
                error: function() {
                    $('#loadingPetugas').hide();
                    $('#noDataPetugas').show();
                }
            });
        }

        // Select petugas function
        window.selectPetugas = function(id, fullname, role) {
            $('#petugas_id').val(id);
            $('#petugas_display').val(`${fullname} (${role.toUpperCase()})`);
            $('#modalPetugas').modal('hide');
        };

        // Clear petugas selection
        function clearPetugasSelection() {
            $('#petugas_id').val('');
            $('#petugas_display').val('');
        }

        // Set default tanggal kejadian ke hari ini
        const now = new Date();
        const formatted = now.getFullYear() + '-' +
            String(now.getMonth() + 1).padStart(2, '0') + '-' +
            String(now.getDate()).padStart(2, '0') + 'T' +
            String(now.getHours()).padStart(2, '0') + ':' +
            String(now.getMinutes()).padStart(2, '0');
        $('#tanggal_kejadian').val(formatted);

        // Form submission
        $('#formKasus').on('submit', function(e) {
            e.preventDefault();

            // Clear previous errors
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').text('');

            // Show loading state
            const btnSubmit = $('#btnSubmit');
            const originalText = btnSubmit.html();
            btnSubmit.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...');

            // Get form data
            const formData = new FormData(this);

            // AJAX request
            $.ajax({
                url: '<?= base_url('spkt/kasus/store') ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
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
                        // Show validation errors
                        if (response.errors) {
                            for (const field in response.errors) {
                                const input = $(`#${field}`);
                                const errorDiv = $(`#error-${field}`);

                                input.addClass('is-invalid');
                                errorDiv.text(response.errors[field]);
                            }
                        }

                        Swal.fire({
                            title: 'Validasi Gagal!',
                            text: response.message,
                            icon: 'error'
                        });
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan sistem',
                        icon: 'error'
                    });
                },
                complete: function() {
                    // Reset button state
                    btnSubmit.prop('disabled', false).html(originalText);
                }
            });
        });

        // Validate form on input
        $('input, textarea, select').on('input change', function() {
            if ($(this).hasClass('is-invalid')) {
                $(this).removeClass('is-invalid');
                $(`#error-${$(this).attr('name')}`).text('');
            }
        });

        // Update prioritas color
        $('#prioritas').on('change', function() {
            const value = $(this).val();
            $(this).removeClass('border-secondary border-primary border-warning border-danger');

            switch (value) {
                case 'rendah':
                    $(this).addClass('border-secondary');
                    break;
                case 'sedang':
                    $(this).addClass('border-primary');
                    break;
                case 'tinggi':
                    $(this).addClass('border-warning');
                    break;
                case 'darurat':
                    $(this).addClass('border-danger');
                    break;
            }
        }).trigger('change');

        // Update status color
        $('#status').on('change', function() {
            const value = $(this).val();
            $(this).removeClass('border-warning border-info border-success border-secondary');

            switch (value) {
                case 'dilaporkan':
                    $(this).addClass('border-warning');
                    break;
                case 'dalam_proses':
                    $(this).addClass('border-info');
                    break;
                case 'selesai':
                    $(this).addClass('border-success');
                    break;
                case 'ditutup':
                    $(this).addClass('border-secondary');
                    break;
            }
        }).trigger('change');
    });
</script>
<?= $this->endSection() ?>