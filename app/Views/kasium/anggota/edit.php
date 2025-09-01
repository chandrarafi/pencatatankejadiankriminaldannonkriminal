<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Edit Anggota<?= $this->endSection() ?>

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
            Form Edit Anggota - <?= $anggota['nama'] ?>
        </h3>
    </div>

    <form action="<?= base_url('kasium/anggota/update/' . $anggota['id']) ?>" method="post" enctype="multipart/form-data" id="formAnggota">
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
                                    id="nrp" name="nrp" value="<?= old('nrp', $anggota['nrp']) ?>"
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
                                    id="nama" name="nama" value="<?= old('nama', $anggota['nama']) ?>"
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
                                    <option value="Brigadir Jenderal" <?= old('pangkat', $anggota['pangkat']) == 'Brigadir Jenderal' ? 'selected' : '' ?>>Brigadir Jenderal</option>
                                    <option value="Komisaris Besar" <?= old('pangkat', $anggota['pangkat']) == 'Komisaris Besar' ? 'selected' : '' ?>>Komisaris Besar</option>
                                    <option value="Komisaris" <?= old('pangkat', $anggota['pangkat']) == 'Komisaris' ? 'selected' : '' ?>>Komisaris</option>
                                    <option value="Ajun Komisaris Besar" <?= old('pangkat', $anggota['pangkat']) == 'Ajun Komisaris Besar' ? 'selected' : '' ?>>Ajun Komisaris Besar</option>
                                    <option value="Ajun Komisaris" <?= old('pangkat', $anggota['pangkat']) == 'Ajun Komisaris' ? 'selected' : '' ?>>Ajun Komisaris</option>
                                    <option value="Inspektur Polisi Satu" <?= old('pangkat', $anggota['pangkat']) == 'Inspektur Polisi Satu' ? 'selected' : '' ?>>Inspektur Polisi Satu</option>
                                    <option value="Inspektur Polisi Dua" <?= old('pangkat', $anggota['pangkat']) == 'Inspektur Polisi Dua' ? 'selected' : '' ?>>Inspektur Polisi Dua</option>
                                    <option value="Ajun Inspektur Polisi Satu" <?= old('pangkat', $anggota['pangkat']) == 'Ajun Inspektur Polisi Satu' ? 'selected' : '' ?>>Ajun Inspektur Polisi Satu</option>
                                    <option value="Ajun Inspektur Polisi Dua" <?= old('pangkat', $anggota['pangkat']) == 'Ajun Inspektur Polisi Dua' ? 'selected' : '' ?>>Ajun Inspektur Polisi Dua</option>
                                    <option value="Brigadir Kepala" <?= old('pangkat', $anggota['pangkat']) == 'Brigadir Kepala' ? 'selected' : '' ?>>Brigadir Kepala</option>
                                    <option value="Brigadir" <?= old('pangkat', $anggota['pangkat']) == 'Brigadir' ? 'selected' : '' ?>>Brigadir</option>
                                    <option value="Ajun Brigadir Kepala" <?= old('pangkat', $anggota['pangkat']) == 'Ajun Brigadir Kepala' ? 'selected' : '' ?>>Ajun Brigadir Kepala</option>
                                    <option value="Ajun Brigadir" <?= old('pangkat', $anggota['pangkat']) == 'Ajun Brigadir' ? 'selected' : '' ?>>Ajun Brigadir</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jabatan">Jabatan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="jabatan" name="jabatan"
                                    value="<?= old('jabatan', $anggota['jabatan']) ?>" placeholder="Masukkan jabatan" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="unit_kerja">Unit Kerja</label>
                                <input type="text" class="form-control" id="unit_kerja" name="unit_kerja"
                                    value="<?= old('unit_kerja', $anggota['unit_kerja']) ?>" placeholder="Unit kerja">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status <span class="text-danger">*</span></label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="aktif" <?= old('status', $anggota['status']) == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                                    <option value="non_aktif" <?= old('status', $anggota['status']) == 'non_aktif' ? 'selected' : '' ?>>Non Aktif</option>
                                    <option value="pensiun" <?= old('status', $anggota['status']) == 'pensiun' ? 'selected' : '' ?>>Pensiun</option>
                                    <option value="mutasi" <?= old('status', $anggota['status']) == 'mutasi' ? 'selected' : '' ?>>Mutasi</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telepon">Telepon</label>
                                <input type="text" class="form-control" id="telepon" name="telepon"
                                    value="<?= old('telepon', $anggota['telepon']) ?>" placeholder="Nomor telepon">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="<?= old('email', $anggota['email']) ?>" placeholder="Alamat email">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_masuk">Tanggal Masuk</label>
                                <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk"
                                    value="<?= old('tanggal_masuk', $anggota['tanggal_masuk']) ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3"
                                    placeholder="Alamat lengkap"><?= old('alamat', $anggota['alamat']) ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="2"
                            placeholder="Keterangan tambahan"><?= old('keterangan', $anggota['keterangan']) ?></textarea>
                    </div>
                </div>

                <!-- Upload Foto -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="foto">Foto Anggota</label>
                        <div class="text-center mb-3" style="position: relative;">
                            <div id="fotoContainer" class="d-inline-block position-relative">
                                <div id="fotoPreview" style="<?= $anggota['foto'] && file_exists(FCPATH . 'uploads/anggota/' . $anggota['foto']) ? '' : 'display: none;' ?>">
                                    <img id="previewImg" src="<?= $anggota['foto'] && file_exists(FCPATH . 'uploads/anggota/' . $anggota['foto']) ? base_url('uploads/anggota/' . $anggota['foto']) : '' ?>"
                                        alt="Preview Foto" class="img-thumbnail rounded"
                                        style="width: 250px; height: 250px; object-fit: cover; border: 3px solid #ffc107;">
                                </div>
                                <div id="fotoPlaceholder" class="border rounded d-flex align-items-center justify-content-center"
                                    style="width: 250px; height: 250px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); margin: 0 auto; border: 3px dashed #ffc107; cursor: pointer; transition: all 0.3s ease; <?= $anggota['foto'] && file_exists(FCPATH . 'uploads/anggota/' . $anggota['foto']) ? 'display: none;' : '' ?>">
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
                            <button type="button" class="btn btn-outline-warning btn-sm" onclick="$('#foto').click()">
                                <i class="fas fa-folder-open mr-1"></i> Pilih File Baru
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm ml-2" id="clearPhoto" style="<?= $anggota['foto'] && file_exists(FCPATH . 'uploads/anggota/' . $anggota['foto']) ? '' : 'display: none;' ?>">
                                <i class="fas fa-times mr-1"></i> Hapus
                            </button>
                        </div>
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle"></i>
                            Format: JPG, PNG, GIF. Maksimal 2MB. Kosongkan jika tidak ingin mengubah foto.
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
                    <a href="<?= base_url('kasium/anggota/show/' . $anggota['id']) ?>" class="btn btn-info">
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

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Store original image source
        const originalSrc = '<?= $anggota['foto'] && file_exists(FCPATH . 'uploads/anggota/' . $anggota['foto']) ? base_url('uploads/anggota/' . $anggota['foto']) : '' ?>';
        const hasOriginalPhoto = <?= $anggota['foto'] && file_exists(FCPATH . 'uploads/anggota/' . $anggota['foto']) ? 'true' : 'false' ?>;

        // Make placeholder clickable with hover effects
        $('#fotoPlaceholder').click(function() {
            $('#foto').click();
        }).hover(
            function() {
                $(this).css({
                    'transform': 'scale(1.05)',
                    'box-shadow': '0 4px 15px rgba(255,193,7,0.4)'
                });
            },
            function() {
                $(this).css({
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
                    resetToOriginal();
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
                    resetToOriginal();
                    return;
                }

                // Show preview with animation
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewImg').attr('src', e.target.result);
                    $('#fotoPlaceholder').fadeOut(300, function() {
                        $('#fotoPreview').fadeIn(300);
                        $('#clearPhoto').show();
                    });
                };
                reader.readAsDataURL(file);
            } else {
                resetToOriginal();
            }
        });

        // Function to reset to original state
        function resetToOriginal() {
            if (hasOriginalPhoto) {
                $('#previewImg').attr('src', originalSrc);
                $('#fotoPlaceholder').fadeOut(300, function() {
                    $('#fotoPreview').fadeIn(300);
                    $('#clearPhoto').show();
                });
            } else {
                $('#fotoPreview').fadeOut(300, function() {
                    $('#fotoPlaceholder').fadeIn(300);
                    $('#clearPhoto').hide();
                });
                $('#previewImg').attr('src', '');
            }
        }

        // Clear photo button
        $('#clearPhoto').click(function() {
            $('#foto').val('');
            $('#fotoPreview').fadeOut(300, function() {
                $('#fotoPlaceholder').fadeIn(300);
                $('#clearPhoto').hide();
            });
            $('#previewImg').attr('src', '');
        });

        // Reset form
        $('button[type="reset"]').click(function() {
            setTimeout(function() {
                resetToOriginal();
            }, 100);
        });

        // Drag and drop functionality
        $('#fotoContainer').on('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).addClass('border-warning');
        });

        $('#fotoContainer').on('dragleave', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).removeClass('border-warning');
        });

        $('#fotoContainer').on('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).removeClass('border-warning');

            const files = e.originalEvent.dataTransfer.files;
            if (files.length > 0) {
                $('#foto')[0].files = files;
                $('#foto').trigger('change');
            }
        });
    });
</script>
<?= $this->endSection() ?>