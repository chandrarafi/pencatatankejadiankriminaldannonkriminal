<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Tambah Anggota<?= $this->endSection() ?>

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
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-user-plus mr-2"></i>
            Form Tambah Anggota
        </h3>
    </div>

    <form action="<?= base_url('kasium/anggota/store') ?>" method="post" enctype="multipart/form-data" id="formAnggota">
        <?= csrf_field() ?>

        <div class="card-body">
            <div class="row">
                <!-- Data Utama -->
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nrp">NRP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['nrp'])) ? 'is-invalid' : '' ?>"
                                    id="nrp" name="nrp" value="<?= old('nrp') ?>"
                                    placeholder="Masukkan NRP" required>
                                <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['nrp'])): ?>
                                    <div class="invalid-feedback">
                                        <?= session()->getFlashdata('errors')['nrp'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['nama'])) ? 'is-invalid' : '' ?>"
                                    id="nama" name="nama" value="<?= old('nama') ?>"
                                    placeholder="Masukkan nama lengkap" required>
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
                                <label for="pangkat">Pangkat <span class="text-danger">*</span></label>
                                <select class="form-control" id="pangkat" name="pangkat" required>
                                    <option value="">-- Pilih Pangkat --</option>
                                    <option value="Brigadir Jenderal" <?= old('pangkat') == 'Brigadir Jenderal' ? 'selected' : '' ?>>Brigadir Jenderal</option>
                                    <option value="Komisaris Besar" <?= old('pangkat') == 'Komisaris Besar' ? 'selected' : '' ?>>Komisaris Besar</option>
                                    <option value="Komisaris" <?= old('pangkat') == 'Komisaris' ? 'selected' : '' ?>>Komisaris</option>
                                    <option value="Ajun Komisaris Besar" <?= old('pangkat') == 'Ajun Komisaris Besar' ? 'selected' : '' ?>>Ajun Komisaris Besar</option>
                                    <option value="Ajun Komisaris" <?= old('pangkat') == 'Ajun Komisaris' ? 'selected' : '' ?>>Ajun Komisaris</option>
                                    <option value="Inspektur Polisi Satu" <?= old('pangkat') == 'Inspektur Polisi Satu' ? 'selected' : '' ?>>Inspektur Polisi Satu</option>
                                    <option value="Inspektur Polisi Dua" <?= old('pangkat') == 'Inspektur Polisi Dua' ? 'selected' : '' ?>>Inspektur Polisi Dua</option>
                                    <option value="Ajun Inspektur Polisi Satu" <?= old('pangkat') == 'Ajun Inspektur Polisi Satu' ? 'selected' : '' ?>>Ajun Inspektur Polisi Satu</option>
                                    <option value="Ajun Inspektur Polisi Dua" <?= old('pangkat') == 'Ajun Inspektur Polisi Dua' ? 'selected' : '' ?>>Ajun Inspektur Polisi Dua</option>
                                    <option value="Brigadir Kepala" <?= old('pangkat') == 'Brigadir Kepala' ? 'selected' : '' ?>>Brigadir Kepala</option>
                                    <option value="Brigadir" <?= old('pangkat') == 'Brigadir' ? 'selected' : '' ?>>Brigadir</option>
                                    <option value="Ajun Brigadir Kepala" <?= old('pangkat') == 'Ajun Brigadir Kepala' ? 'selected' : '' ?>>Ajun Brigadir Kepala</option>
                                    <option value="Ajun Brigadir" <?= old('pangkat') == 'Ajun Brigadir' ? 'selected' : '' ?>>Ajun Brigadir</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jabatan">Jabatan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="jabatan" name="jabatan"
                                    value="<?= old('jabatan') ?>" placeholder="Masukkan jabatan" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="unit_kerja">Unit Kerja</label>
                                <input type="text" class="form-control" id="unit_kerja" name="unit_kerja"
                                    value="<?= old('unit_kerja', 'Polsek Lunang Silaut') ?>" placeholder="Unit kerja">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status <span class="text-danger">*</span></label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="aktif" <?= old('status') == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                                    <option value="non_aktif" <?= old('status') == 'non_aktif' ? 'selected' : '' ?>>Non Aktif</option>
                                    <option value="pensiun" <?= old('status') == 'pensiun' ? 'selected' : '' ?>>Pensiun</option>
                                    <option value="mutasi" <?= old('status') == 'mutasi' ? 'selected' : '' ?>>Mutasi</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telepon">Telepon</label>
                                <input type="text" class="form-control" id="telepon" name="telepon"
                                    value="<?= old('telepon') ?>" placeholder="Nomor telepon">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="<?= old('email') ?>" placeholder="Alamat email">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_masuk">Tanggal Masuk</label>
                                <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk"
                                    value="<?= old('tanggal_masuk') ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3"
                                    placeholder="Alamat lengkap"><?= old('alamat') ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="2"
                            placeholder="Keterangan tambahan"><?= old('keterangan') ?></textarea>
                    </div>
                </div>

                <!-- Upload Foto -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="foto">Foto Anggota</label>
                        <div class="text-center mb-3" style="position: relative;">
                            <div id="fotoContainer" class="d-inline-block position-relative" style="width: 250px; height: 250px; margin: 0 auto;">
                                <div id="fotoPreview" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: none; z-index: 2;">
                                    <img id="previewImg" src="" alt="Preview Foto"
                                        class="img-thumbnail rounded" style="width: 100%; height: 100%; object-fit: cover; border: 3px solid #007bff;">
                                </div>
                                <div id="fotoPlaceholder" class="border rounded d-flex align-items-center justify-content-center"
                                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: 3px dashed #007bff; cursor: pointer; transition: all 0.3s ease; z-index: 1;">
                                    <div class="text-center">
                                        <i class="fas fa-camera fa-3x text-white mb-2"></i>
                                        <br>
                                        <small class="text-white">Klik untuk pilih foto</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="file" class="form-control-file d-none" id="foto" name="foto" accept="image/*">
                        <div class="text-center mt-2">
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="$('#foto').click()">
                                <i class="fas fa-folder-open mr-1"></i> Pilih File
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm ml-2" id="clearPhoto" style="display: none;">
                                <i class="fas fa-times mr-1"></i> Hapus
                            </button>
                        </div>
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle"></i>
                            Format: JPG, PNG, GIF. Maksimal 2MB
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <div class="row">
                <div class="col-md-6">
                    <a href="<?= base_url('kasium/anggota') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
                <div class="col-md-6 text-right">
                    <button type="reset" class="btn btn-warning">
                        <i class="fas fa-undo mr-1"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Simpan
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
        // Form validation and AJAX submission
        $('#formAnggota').on('submit', function(e) {
            e.preventDefault();

            // Clear previous validation errors
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').hide();

            // Show loading state
            const submitBtn = $('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...');

            // Prepare FormData for file upload
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
                            window.location.href = response.redirect;
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
                        text: 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.'
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

        // Make foto container clickable with hover effects
        $('#fotoContainer').click(function() {
            $('#foto').click();
        }).hover(
            function() {
                $('#fotoPlaceholder').css({
                    'transform': 'scale(1.05)',
                    'box-shadow': '0 4px 15px rgba(0,123,255,0.4)'
                });
            },
            function() {
                $('#fotoPlaceholder').css({
                    'transform': 'scale(1)',
                    'box-shadow': 'none'
                });
            }
        );

        // Preview foto saat file dipilih
        $('#foto').change(function() {
            const file = this.files[0];
            if (file) {
                // Validasi tipe file
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                if (!allowedTypes.includes(file.type)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Format File Tidak Valid',
                        text: 'Silakan pilih file gambar (JPG, PNG, GIF)'
                    });
                    $(this).val('');
                    resetPreview();
                    return;
                }

                // Validasi ukuran file (max 2MB)
                if (file.size > 2 * 1024 * 1024) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File Terlalu Besar',
                        text: 'Ukuran file maksimal 2MB'
                    });
                    $(this).val('');
                    resetPreview();
                    return;
                }

                // Show preview with animation
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewImg').attr('src', e.target.result);
                    $('#fotoPreview').fadeIn(300);
                    $('#clearPhoto').show();
                };
                reader.readAsDataURL(file);
            } else {
                resetPreview();
            }
        });

        // Function to reset preview
        function resetPreview() {
            $('#fotoPreview').fadeOut(300);
            $('#clearPhoto').hide();
            $('#previewImg').attr('src', '');
        }

        // Clear photo button
        $('#clearPhoto').click(function() {
            $('#foto').val('');
            resetPreview();
        });

        // Reset form
        $('button[type="reset"]').click(function() {
            setTimeout(function() {
                resetPreview();
            }, 100);
        });

        // Drag and drop functionality
        $('#fotoContainer').on('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).addClass('border-primary');
        });

        $('#fotoContainer').on('dragleave', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).removeClass('border-primary');
        });

        $('#fotoContainer').on('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).removeClass('border-primary');

            const files = e.originalEvent.dataTransfer.files;
            if (files.length > 0) {
                $('#foto')[0].files = files;
                $('#foto').trigger('change');
            }
        });
    });
</script>
<?= $this->endSection() ?>