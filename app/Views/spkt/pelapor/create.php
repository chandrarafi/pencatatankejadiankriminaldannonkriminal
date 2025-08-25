<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Tambah Data Pelapor<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Main Form Card -->
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-plus mr-2"></i>
            Tambah Data Pelapor Baru
        </h3>
        <div class="card-tools">
            <a href="<?= base_url('spkt/pelapor') ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>
    </div>

    <form id="formPelapor">
        <div class="card-body">
            <div class="row">
                <!-- Kolom Kiri - Data Pribadi -->
                <div class="col-md-6">
                    <h5 class="text-primary mb-3"><i class="fas fa-user mr-2"></i>Data Pribadi</h5>

                    <div class="form-group">
                        <label for="nama">
                            <i class="fas fa-user mr-1"></i>Nama Lengkap
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="nama" name="nama"
                            placeholder="Masukkan nama lengkap" maxlength="255" required>
                        <div class="invalid-feedback" id="error-nama"></div>
                    </div>

                    <div class="form-group">
                        <label for="nik">
                            <i class="fas fa-id-card mr-1"></i>NIK
                        </label>
                        <input type="text" class="form-control" id="nik" name="nik"
                            placeholder="Nomor Induk Kependudukan" maxlength="20">
                        <div class="invalid-feedback" id="error-nik"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jenis_kelamin">
                                    <i class="fas fa-venus-mars mr-1"></i>Jenis Kelamin
                                </label>
                                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                                <div class="invalid-feedback" id="error-jenis_kelamin"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_lahir">
                                    <i class="fas fa-birthday-cake mr-1"></i>Tanggal Lahir
                                </label>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir">
                                <div class="invalid-feedback" id="error-tanggal_lahir"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="pekerjaan">
                            <i class="fas fa-briefcase mr-1"></i>Pekerjaan
                        </label>
                        <input type="text" class="form-control" id="pekerjaan" name="pekerjaan"
                            placeholder="Pekerjaan/profesi" maxlength="100">
                        <div class="invalid-feedback" id="error-pekerjaan"></div>
                    </div>
                </div>

                <!-- Kolom Kanan - Kontak & Alamat -->
                <div class="col-md-6">
                    <h5 class="text-success mb-3"><i class="fas fa-address-book mr-2"></i>Kontak & Alamat</h5>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telepon">
                                    <i class="fas fa-phone mr-1"></i>Telepon/HP
                                </label>
                                <input type="text" class="form-control" id="telepon" name="telepon"
                                    placeholder="Nomor telepon/HP" maxlength="20">
                                <div class="invalid-feedback" id="error-telepon"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">
                                    <i class="fas fa-envelope mr-1"></i>Email
                                </label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Alamat email" maxlength="255">
                                <div class="invalid-feedback" id="error-email"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="alamat">
                            <i class="fas fa-home mr-1"></i>Alamat
                        </label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3"
                            placeholder="Alamat lengkap (jalan, RT/RW, dll)"></textarea>
                        <div class="invalid-feedback" id="error-alamat"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kelurahan">
                                    <i class="fas fa-map-marker-alt mr-1"></i>Kelurahan
                                </label>
                                <input type="text" class="form-control" id="kelurahan" name="kelurahan"
                                    placeholder="Kelurahan/Desa" maxlength="100">
                                <div class="invalid-feedback" id="error-kelurahan"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kecamatan">
                                    <i class="fas fa-map-marker-alt mr-1"></i>Kecamatan
                                </label>
                                <input type="text" class="form-control" id="kecamatan" name="kecamatan"
                                    placeholder="Kecamatan" maxlength="100">
                                <div class="invalid-feedback" id="error-kecamatan"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kota_kabupaten">
                                    <i class="fas fa-city mr-1"></i>Kota/Kabupaten
                                </label>
                                <input type="text" class="form-control" id="kota_kabupaten" name="kota_kabupaten"
                                    placeholder="Kota/Kabupaten" maxlength="100">
                                <div class="invalid-feedback" id="error-kota_kabupaten"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="provinsi">
                                    <i class="fas fa-map mr-1"></i>Provinsi
                                </label>
                                <input type="text" class="form-control" id="provinsi" name="provinsi"
                                    placeholder="Provinsi" maxlength="100">
                                <div class="invalid-feedback" id="error-provinsi"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="kode_pos">
                            <i class="fas fa-mail-bulk mr-1"></i>Kode Pos
                        </label>
                        <input type="text" class="form-control" id="kode_pos" name="kode_pos"
                            placeholder="Kode pos" maxlength="10">
                        <div class="invalid-feedback" id="error-kode_pos"></div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="keterangan">
                            <i class="fas fa-sticky-note mr-1"></i>Keterangan
                        </label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3"
                            placeholder="Keterangan tambahan (opsional)"></textarea>
                        <div class="invalid-feedback" id="error-keterangan"></div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="is_active">
                            <i class="fas fa-toggle-on mr-1"></i>Status
                        </label>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" checked>
                            <label class="custom-control-label" for="is_active">Aktif</label>
                        </div>
                        <small class="form-text text-muted">Pelapor aktif dapat digunakan untuk membuat kasus baru</small>
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
                        <i class="fas fa-save mr-1"></i> Simpan Data Pelapor
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
        // Form submission
        $('#formPelapor').on('submit', function(e) {
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
                url: '<?= base_url('spkt/pelapor/store') ?>',
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
                            window.location.href = '<?= base_url('spkt/pelapor') ?>';
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

        // Auto format NIK
        $('#nik').on('input', function() {
            this.value = this.value.replace(/\D/g, ''); // Only numbers
            if (this.value.length > 16) {
                this.value = this.value.substring(0, 16);
            }
        });

        // Auto format phone
        $('#telepon').on('input', function() {
            this.value = this.value.replace(/[^0-9+\-\s]/g, '');
        });

        // Auto format kode pos
        $('#kode_pos').on('input', function() {
            this.value = this.value.replace(/\D/g, ''); // Only numbers
            if (this.value.length > 5) {
                this.value = this.value.substring(0, 5);
            }
        });
    });
</script>
<?= $this->endSection() ?>