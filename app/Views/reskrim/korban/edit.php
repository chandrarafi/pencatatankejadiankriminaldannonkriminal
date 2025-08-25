<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Edit Data Korban<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Alert Messages -->
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle mr-2"></i>
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle mr-2"></i>
        <strong>Terjadi kesalahan:</strong>
        <ul class="mb-0 mt-2">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<!-- Form Card -->
<div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-user-edit mr-2"></i>
            Form Edit Data Korban - <?= $korban['nama'] ?>
        </h3>
    </div>

    <form action="<?= base_url('reskrim/korban/update/' . $korban['id']) ?>" method="post" id="formKorban">
        <?= csrf_field() ?>

        <div class="card-body">
            <div class="row">
                <!-- Data Utama -->
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kasus_id">Kasus <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="hidden" id="kasus_id" name="kasus_id" value="<?= old('kasus_id', $korban['kasus_id']) ?>" required>
                                    <input type="text" class="form-control <?= (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['kasus_id'])) ? 'is-invalid' : '' ?>"
                                        id="selected_kasus_display" placeholder="Klik untuk pilih kasus" readonly>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#kasusModal">
                                            <i class="fas fa-search"></i> Pilih
                                        </button>
                                    </div>
                                </div>
                                <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['kasus_id'])): ?>
                                    <div class="invalid-feedback">
                                        <?= session()->getFlashdata('errors')['kasus_id'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['nama'])) ? 'is-invalid' : '' ?>"
                                    id="nama" name="nama" value="<?= old('nama', $korban['nama']) ?>"
                                    placeholder="Masukkan nama lengkap korban" required>
                                <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['nama'])): ?>
                                    <div class="invalid-feedback">
                                        <?= session()->getFlashdata('errors')['nama'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nik">NIK</label>
                                <input type="text" class="form-control" id="nik" name="nik"
                                    value="<?= old('nik', $korban['nik']) ?>" placeholder="Nomor Induk Kependudukan">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="L" <?= old('jenis_kelamin', $korban['jenis_kelamin']) == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                    <option value="P" <?= old('jenis_kelamin', $korban['jenis_kelamin']) == 'P' ? 'selected' : '' ?>>Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="umur">Umur</label>
                                <input type="number" class="form-control" id="umur" name="umur"
                                    value="<?= old('umur', $korban['umur']) ?>" placeholder="Umur" min="0" max="150">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pekerjaan">Pekerjaan</label>
                                <input type="text" class="form-control" id="pekerjaan" name="pekerjaan"
                                    value="<?= old('pekerjaan', $korban['pekerjaan']) ?>" placeholder="Pekerjaan korban">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status_korban">Status Korban <span class="text-danger">*</span></label>
                                <select class="form-control" id="status_korban" name="status_korban" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="hidup" <?= old('status_korban', $korban['status_korban']) == 'hidup' ? 'selected' : '' ?>>Hidup</option>
                                    <option value="meninggal" <?= old('status_korban', $korban['status_korban']) == 'meninggal' ? 'selected' : '' ?>>Meninggal</option>
                                    <option value="hilang" <?= old('status_korban', $korban['status_korban']) == 'hilang' ? 'selected' : '' ?>>Hilang</option>
                                    <option value="luka" <?= old('status_korban', $korban['status_korban']) == 'luka' ? 'selected' : '' ?>>Luka</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telepon">Telepon</label>
                                <input type="text" class="form-control" id="telepon" name="telepon"
                                    value="<?= old('telepon', $korban['telepon']) ?>" placeholder="Nomor telepon">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="<?= old('email', $korban['email']) ?>" placeholder="Alamat email">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hubungan_pelaku">Hubungan dengan Pelaku</label>
                                <input type="text" class="form-control" id="hubungan_pelaku" name="hubungan_pelaku"
                                    value="<?= old('hubungan_pelaku', $korban['hubungan_pelaku']) ?>" placeholder="Contoh: Tidak dikenal, Keluarga, Teman, dll">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="alamat">Alamat <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3"
                                    placeholder="Alamat lengkap korban" required><?= old('alamat', $korban['alamat']) ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="keterangan_luka">Keterangan Luka (jika ada)</label>
                        <textarea class="form-control" id="keterangan_luka" name="keterangan_luka" rows="2"
                            placeholder="Keterangan detail mengenai luka yang dialami"><?= old('keterangan_luka', $korban['keterangan_luka']) ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="keterangan">Keterangan Tambahan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="2"
                            placeholder="Keterangan tambahan mengenai korban"><?= old('keterangan', $korban['keterangan']) ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <div class="row">
                <div class="col-md-6">
                    <a href="<?= base_url('reskrim/korban') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                    <a href="<?= base_url('reskrim/korban/show/' . $korban['id']) ?>" class="btn btn-info">
                        <i class="fas fa-eye mr-1"></i> Detail
                    </a>
                </div>
                <div class="col-md-6 text-right">
                    <button type="reset" class="btn btn-warning">
                        <i class="fas fa-undo mr-1"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Update
                    </button>
                </div>
            </div>
        </div>
    </form>

</div>

<!-- Modal Pilih Kasus -->
<div class="modal fade" id="kasusModal" tabindex="-1" role="dialog" aria-labelledby="kasusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="kasusModalLabel">
                    <i class="fas fa-folder-open mr-2"></i>
                    Pilih Kasus
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Search Box -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="input-group">
                            <input type="text" class="form-control" id="search_kasus" placeholder="Cari berdasarkan nomor kasus atau judul...">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kasus Table -->
                <div class="table-responsive" style="max-height: 400px;">
                    <table class="table table-bordered table-hover" id="kasusTable">
                        <thead class="thead-light">
                            <tr>
                                <th width="5%">
                                    <i class="fas fa-mouse-pointer"></i>
                                </th>
                                <th width="20%">Nomor Kasus</th>
                                <th width="35%">Judul Kasus</th>
                                <th width="15%">Tanggal Kejadian</th>
                                <th width="15%">Status</th>
                                <th width="10%">Pelapor</th>
                            </tr>
                        </thead>
                        <tbody id="kasusTableBody">
                            <tr>
                                <td colspan="6" class="text-center">
                                    <i class="fas fa-spinner fa-spin"></i> Memuat data kasus...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Batal
                </button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        let kasusData = [];

        // Load existing kasus info if available
        <?php if (!empty($korban['kasus_id'])): ?>
            // Set initial display value if kasus_id exists
            $.ajax({
                url: '<?= base_url('reskrim/korban/get-kasus-data') ?>',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        let selectedKasus = response.data.find(k => k.id == '<?= $korban['kasus_id'] ?>');
                        if (selectedKasus) {
                            $('#selected_kasus_display').val(selectedKasus.nomor_kasus + ' - ' + selectedKasus.judul_kasus);
                        }
                    }
                }
            });
        <?php endif; ?>

        // Load kasus data when modal is opened
        $('#kasusModal').on('show.bs.modal', function() {
            loadKasusData();
        });

        // Function to load kasus data
        function loadKasusData() {
            $.ajax({
                url: '<?= base_url('reskrim/korban/get-kasus-data') ?>',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        kasusData = response.data;
                        displayKasusData(kasusData);
                    } else {
                        $('#kasusTableBody').html('<tr><td colspan="6" class="text-center text-danger">Gagal memuat data kasus</td></tr>');
                    }
                },
                error: function() {
                    $('#kasusTableBody').html('<tr><td colspan="6" class="text-center text-danger">Terjadi kesalahan saat memuat data</td></tr>');
                }
            });
        }

        // Function to display kasus data
        function displayKasusData(data) {
            let tbody = $('#kasusTableBody');
            tbody.empty();

            if (data.length === 0) {
                tbody.html('<tr><td colspan="6" class="text-center text-muted">Tidak ada data kasus</td></tr>');
                return;
            }

            data.forEach(function(kasus) {
                let statusClass = {
                    'aktif': 'success',
                    'selesai': 'info',
                    'batal': 'danger',
                    'ditunda': 'warning'
                };
                let badgeClass = statusClass[kasus.status] || 'secondary';

                let row = `
                    <tr class="kasus-row" data-id="${kasus.id}" data-nomor="${kasus.nomor_kasus}" data-judul="${kasus.judul_kasus}" style="cursor: pointer;">
                        <td class="text-center">
                            <i class="fas fa-hand-pointer text-warning"></i>
                        </td>
                        <td><strong>${kasus.nomor_kasus}</strong></td>
                        <td>${kasus.judul_kasus}</td>
                        <td>${formatDate(kasus.tanggal_kejadian)}</td>
                        <td><span class="badge badge-${badgeClass}">${kasus.status.toUpperCase()}</span></td>
                        <td>${kasus.pelapor_nama || '-'}</td>
                    </tr>
                `;
                tbody.append(row);
            });
        }

        // Format date function
        function formatDate(dateString) {
            if (!dateString) return '-';
            let date = new Date(dateString);
            return date.toLocaleDateString('id-ID');
        }

        // Handle kasus selection
        $(document).on('click', '.kasus-row', function() {
            let kasusId = $(this).data('id');
            let kasusNomor = $(this).data('nomor');
            let kasusJudul = $(this).data('judul');

            // Set values
            $('#kasus_id').val(kasusId);
            $('#selected_kasus_display').val(kasusNomor + ' - ' + kasusJudul);

            // Close modal
            $('#kasusModal').modal('hide');

            // Remove validation error if any
            $('#selected_kasus_display').removeClass('is-invalid');
        });

        // Search functionality
        $('#search_kasus').on('keyup', function() {
            let searchTerm = $(this).val().toLowerCase();
            let filteredData = kasusData.filter(function(kasus) {
                return kasus.nomor_kasus.toLowerCase().includes(searchTerm) ||
                    kasus.judul_kasus.toLowerCase().includes(searchTerm) ||
                    (kasus.pelapor_nama && kasus.pelapor_nama.toLowerCase().includes(searchTerm));
            });
            displayKasusData(filteredData);
        });

        // Clear search when modal is hidden
        $('#kasusModal').on('hidden.bs.modal', function() {
            $('#search_kasus').val('');
        });

        // Form validation and AJAX submission
        $('#formKorban').on('submit', function(e) {
            e.preventDefault();

            // Clear previous validation errors
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').hide();

            // Show loading state
            const submitBtn = $('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Mengupdate...');

            // Prepare FormData
            const formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = '<?= base_url('reskrim/korban/show/' . $korban['id']) ?>';
                        });
                    } else {
                        handleFormErrors(response);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat mengupdate data. Silakan coba lagi.'
                    });
                },
                complete: function() {
                    // Reset button state
                    submitBtn.prop('disabled', false).html(originalText);
                }
            });
        });

        // Function to handle form errors
        function handleFormErrors(response) {
            if (response.errors) {
                // Show field-specific errors
                $.each(response.errors, function(field, message) {
                    const fieldElement = $(`[name="${field}"]`);
                    fieldElement.addClass('is-invalid');

                    let feedbackElement = fieldElement.siblings('.invalid-feedback');
                    if (feedbackElement.length === 0) {
                        feedbackElement = $(`<div class="invalid-feedback"></div>`);
                        fieldElement.after(feedbackElement);
                    }
                    feedbackElement.text(message).show();
                });
            }

            // Show general error message
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal!',
                text: response.message || 'Silakan periksa form dan coba lagi.'
            });
        }
    });
</script>
<?= $this->endSection() ?>