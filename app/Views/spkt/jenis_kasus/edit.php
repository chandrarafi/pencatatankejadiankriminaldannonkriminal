<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Edit Jenis Kasus<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Main Form Card -->
<div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-edit mr-2"></i>
            Edit Jenis Kasus: <?= esc($jenisKasus['nama_jenis']) ?>
        </h3>
        <div class="card-tools">
            <a href="<?= base_url('spkt/jenis-kasus') ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>
    </div>

    <form id="formJenisKasus">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="kode_jenis">
                            <i class="fas fa-code mr-1"></i>Kode Jenis Kasus
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="kode_jenis" name="kode_jenis"
                            placeholder="Contoh: KDRT, NARK, CURANMOR" maxlength="20"
                            style="text-transform: uppercase;" value="<?= esc($jenisKasus['kode_jenis']) ?>" required>
                        <small class="form-text text-muted">Kode singkat untuk jenis kasus (maksimal 20 karakter)</small>
                        <div class="invalid-feedback" id="error-kode_jenis"></div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nama_jenis">
                            <i class="fas fa-file-alt mr-1"></i>Nama Jenis Kasus
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="nama_jenis" name="nama_jenis"
                            placeholder="Contoh: Kekerasan Dalam Rumah Tangga" maxlength="255"
                            value="<?= esc($jenisKasus['nama_jenis']) ?>" required>
                        <small class="form-text text-muted">Nama lengkap jenis kasus</small>
                        <div class="invalid-feedback" id="error-nama_jenis"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="deskripsi">
                            <i class="fas fa-align-left mr-1"></i>Deskripsi
                        </label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4"
                            placeholder="Deskripsi detail tentang jenis kasus ini (opsional)"><?= esc($jenisKasus['deskripsi']) ?></textarea>
                        <small class="form-text text-muted">Penjelasan detail tentang jenis kasus</small>
                        <div class="invalid-feedback" id="error-deskripsi"></div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="is_active">
                            <i class="fas fa-toggle-on mr-1"></i>Status
                        </label>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active"
                                <?= $jenisKasus['is_active'] ? 'checked' : '' ?>>
                            <label class="custom-control-label" for="is_active">Aktif</label>
                        </div>
                        <small class="form-text text-muted">Jenis kasus aktif dapat digunakan untuk membuat kasus baru</small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-2"></i>
                        <strong>Informasi:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Dibuat pada: <?= date('d F Y H:i', strtotime($jenisKasus['created_at'])) ?></li>
                            <?php if ($jenisKasus['updated_at']): ?>
                                <li>Terakhir diperbarui: <?= date('d F Y H:i', strtotime($jenisKasus['updated_at'])) ?></li>
                            <?php endif; ?>
                        </ul>
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
                    <button type="submit" class="btn btn-warning" id="btnSubmit">
                        <i class="fas fa-save mr-1"></i> Perbarui Data
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Auto uppercase kode_jenis
        $('#kode_jenis').on('input', function() {
            this.value = this.value.toUpperCase();
        });

        // Form submission
        $('#formJenisKasus').on('submit', function(e) {
            e.preventDefault();

            // Clear previous errors
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').text('');

            // Show loading state
            const btnSubmit = $('#btnSubmit');
            const originalText = btnSubmit.html();
            btnSubmit.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Memperbarui...');

            // Get form data
            const formData = new FormData(this);

            // AJAX request
            $.ajax({
                url: '<?= base_url('spkt/jenis-kasus/update/' . $jenisKasus['id']) ?>',
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
                            window.location.href = '<?= base_url('spkt/jenis-kasus') ?>';
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
        $('input, textarea').on('input', function() {
            if ($(this).hasClass('is-invalid')) {
                $(this).removeClass('is-invalid');
                $(`#error-${$(this).attr('name')}`).text('');
            }
        });
    });
</script>
<?= $this->endSection() ?>
