<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Edit Piket<?= $this->endSection() ?>

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
            <i class="fas fa-calendar-edit mr-2"></i>
            Form Edit Piket
        </h3>
    </div>

    <form action="<?= base_url('kasium/piket/update/' . $piket['id']) ?>" method="post" id="formPiket">
        <?= csrf_field() ?>

        <div class="card-body">
            <div class="row">
                <!-- Data Utama -->
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="anggota_selected">Anggota Piket <span class="text-danger">*</span></label>
                                <div class="border rounded p-2" style="min-height: 100px; background-color: #f8f9fa;">
                                    <div id="selectedAnggotaList">
                                        <p class="text-muted text-center mb-0">
                                            <i class="fas fa-users"></i><br>
                                            Belum ada anggota dipilih
                                        </p>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-warning btn-sm mt-2" id="btnPilihAnggota">
                                    <i class="fas fa-edit mr-1"></i> Edit Anggota
                                </button>
                                <div class="invalid-feedback"></div>
                                <!-- Hidden input untuk menyimpan IDs -->
                                <input type="hidden" name="anggota_ids" id="anggota_ids" value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_piket">Tanggal Piket <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tanggal_piket" name="tanggal_piket"
                                    value="<?= old('tanggal_piket', $piket['tanggal_piket']) ?>" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="shift">Shift <span class="text-danger">*</span></label>
                                <select class="form-control" id="shift" name="shift" required>
                                    <option value="">-- Pilih Shift --</option>
                                    <option value="pagi" <?= old('shift', $piket['shift']) == 'pagi' ? 'selected' : '' ?>>Pagi</option>
                                    <option value="siang" <?= old('shift', $piket['shift']) == 'siang' ? 'selected' : '' ?>>Siang</option>
                                    <option value="malam" <?= old('shift', $piket['shift']) == 'malam' ? 'selected' : '' ?>>Malam</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lokasi_piket">Lokasi Piket</label>
                                <input type="text" class="form-control" id="lokasi_piket" name="lokasi_piket"
                                    value="<?= old('lokasi_piket', $piket['lokasi_piket']) ?>"
                                    placeholder="Polsek Lunang Silaut">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jam_mulai">Jam Mulai <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" id="jam_mulai" name="jam_mulai"
                                    value="<?= old('jam_mulai', $piket['jam_mulai']) ?>" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jam_selesai">Jam Selesai <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" id="jam_selesai" name="jam_selesai"
                                    value="<?= old('jam_selesai', $piket['jam_selesai']) ?>" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status <span class="text-danger">*</span></label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="dijadwalkan" <?= old('status', $piket['status']) == 'dijadwalkan' ? 'selected' : '' ?>>Dijadwalkan</option>
                                    <option value="selesai" <?= old('status', $piket['status']) == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                                    <option value="diganti" <?= old('status', $piket['status']) == 'diganti' ? 'selected' : '' ?>>Diganti</option>
                                    <option value="tidak_hadir" <?= old('status', $piket['status']) == 'tidak_hadir' ? 'selected' : '' ?>>Tidak Hadir</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3"
                            placeholder="Keterangan tambahan untuk jadwal piket"><?= old('keterangan', $piket['keterangan']) ?></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <!-- Info Piket -->
                <div class="col-md-4">
                    <div class="text-center mb-3" style="position: relative;">
                        <div class="d-inline-block position-relative" style="width: 250px; height: 250px; margin: 0 auto;">
                            <div class="border rounded d-flex align-items-center justify-content-center"
                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(135deg, #ffc107 0%, #ff8f00 100%); border: 3px dashed #ffc107; z-index: 1;">
                                <div class="text-center">
                                    <i class="fas fa-calendar-edit fa-4x text-white mb-2"></i>
                                    <br>
                                    <small class="text-white">Form Edit Piket</small>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="card-footer">
            <div class="row">
                <div class="col-md-6">
                    <a href="<?= base_url('kasium/piket') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
                <div class="col-md-6 text-right">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save mr-1"></i> Update
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Modal Pilih Anggota -->
<div class="modal fade" id="modalPilihAnggota" tabindex="-1" role="dialog" aria-labelledby="modalPilihAnggotaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPilihAnggotaLabel">
                    <i class="fas fa-users mr-2"></i>Pilih Anggota Piket
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Search Box -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="searchAnggota">
                                <i class="fas fa-search mr-1"></i>Cari Anggota
                            </label>
                            <input type="text" class="form-control" id="searchAnggota"
                                placeholder="Cari berdasarkan nama, NRP, pangkat, atau jabatan...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div class="d-flex">
                                <button type="button" class="btn btn-outline-warning btn-sm mr-2" id="btnSelectAllVisible">
                                    <i class="fas fa-check-square mr-1"></i>Pilih Semua
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="btnClearAll">
                                    <i class="fas fa-square mr-1"></i>Batal Semua
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="tableAnggotaModal" class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th width="5%" class="text-center">
                                    <div class="icheck-primary">
                                        <input type="checkbox" id="selectAll">
                                        <label for="selectAll"></label>
                                    </div>
                                </th>
                                <th width="15%">NRP</th>
                                <th width="35%">Nama</th>
                                <th width="20%">Pangkat</th>
                                <th width="25%">Jabatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($anggotaList as $anggota): ?>
                                <tr>
                                    <td class="text-center">
                                        <div class="icheck-primary">
                                            <input type="checkbox" class="anggota-checkbox"
                                                id="anggota_<?= $anggota['id'] ?>"
                                                value="<?= $anggota['id'] ?>"
                                                data-nama="<?= $anggota['nama'] ?>"
                                                data-nrp="<?= $anggota['nrp'] ?>"
                                                data-pangkat="<?= $anggota['pangkat'] ?>">
                                            <label for="anggota_<?= $anggota['id'] ?>"></label>
                                        </div>
                                    </td>
                                    <td><?= $anggota['nrp'] ?></td>
                                    <td><?= $anggota['nama'] ?></td>
                                    <td><?= $anggota['pangkat'] ?></td>
                                    <td><?= $anggota['jabatan'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Info Selected -->
                <div class="mt-3">
                    <div class="alert alert-warning" id="selectedInfo" style="display: none;">
                        <i class="fas fa-info-circle mr-2"></i>
                        <span id="selectedCount">0</span> anggota dipilih
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Batal
                </button>
                <button type="button" class="btn btn-warning" id="btnKonfirmasiPilihan">
                    <i class="fas fa-check mr-1"></i> Konfirmasi Pilihan
                </button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

<!-- Select2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- iCheck CSS -->
<style>
    .icheck-primary {
        display: inline-block;
        position: relative;
    }

    .icheck-primary input[type="checkbox"] {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    .icheck-primary label {
        position: relative;
        padding-left: 28px;
        cursor: pointer;
        display: inline-block;
        color: #495057;
        font-size: 13px;
        min-height: 20px;
    }

    .icheck-primary label:before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        width: 20px;
        height: 20px;
        border: 2px solid #007bff;
        background: #fff;
        border-radius: 3px;
        transition: all 0.3s;
    }

    .icheck-primary input[type="checkbox"]:checked+label:before {
        background: #007bff;
        border-color: #007bff;
    }

    .icheck-primary input[type="checkbox"]:checked+label:after {
        content: "";
        position: absolute;
        left: 6px;
        top: 2px;
        width: 6px;
        height: 12px;
        border: solid #fff;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }

    .icheck-primary input[type="checkbox"]:hover+label:before {
        border-color: #0056b3;
    }

    .icheck-primary input[type="checkbox"]:focus+label:before {
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
</style>

<script>
    $(document).ready(function() {
        let selectedAnggota = [];
        let dataTableAnggota;

        // Load anggota yang sudah dipilih saat edit
        const existingAnggota = <?= json_encode($selectedAnggota) ?>;
        if (existingAnggota && existingAnggota.length > 0) {
            selectedAnggota = existingAnggota.map(item => ({
                id: item.anggota_id,
                nama: item.nama,
                nrp: item.nrp,
                pangkat: item.pangkat
            }));

            updateSelectedAnggotaDisplay();

            const anggotaIds = selectedAnggota.map(a => a.id);
            $('#anggota_ids').val(anggotaIds.join(','));
        }

        // Initialize DataTable when modal is shown
        $('#modalPilihAnggota').on('shown.bs.modal', function() {
            if (!dataTableAnggota) {
                dataTableAnggota = $('#tableAnggotaModal').DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "searching": false, // We'll use custom search
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                    "pageLength": 10,
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json"
                    },
                    "order": [
                        [1, 'asc']
                    ], // Sort by NRP
                    "columnDefs": [{
                        "orderable": false,
                        "targets": 0 // Disable sorting on checkbox column
                    }]
                });
            }

            // Update checkbox states based on selectedAnggota
            updateCheckboxStates();
        });

        // Custom search functionality
        $('#searchAnggota').on('keyup', function() {
            const searchValue = this.value;
            dataTableAnggota.search(searchValue).draw();
            updateSelectAllState();
        });

        // Handle modal pilih anggota
        $('#btnPilihAnggota').click(function() {
            $('#modalPilihAnggota').modal('show');
        });

        // Handle select all checkbox (only visible rows)
        $('#selectAll').change(function() {
            const isChecked = $(this).is(':checked');

            // Only check visible rows
            dataTableAnggota.rows({
                search: 'applied'
            }).nodes().to$().find('.anggota-checkbox').prop('checked', isChecked);
            updateSelectedCount();
        });

        // Handle select all visible button
        $('#btnSelectAllVisible').click(function() {
            dataTableAnggota.rows({
                search: 'applied'
            }).nodes().to$().find('.anggota-checkbox').prop('checked', true);
            updateSelectAllState();
            updateSelectedCount();
        });

        // Handle clear all button
        $('#btnClearAll').click(function() {
            $('.anggota-checkbox').prop('checked', false);
            $('#selectAll').prop('checked', false);
            updateSelectedCount();
        });

        // Handle individual checkbox
        $(document).on('change', '.anggota-checkbox', function() {
            updateSelectAllState();
            updateSelectedCount();
        });

        // Update select all state based on visible checkboxes
        function updateSelectAllState() {
            if (!dataTableAnggota) return;

            const visibleCheckboxes = dataTableAnggota.rows({
                search: 'applied'
            }).nodes().to$().find('.anggota-checkbox');
            const checkedVisibleCheckboxes = visibleCheckboxes.filter(':checked');

            $('#selectAll').prop('checked', visibleCheckboxes.length > 0 && visibleCheckboxes.length === checkedVisibleCheckboxes.length);
        }

        // Update selected count
        function updateSelectedCount() {
            const selectedCount = $('.anggota-checkbox:checked').length;
            $('#selectedCount').text(selectedCount);

            if (selectedCount > 0) {
                $('#selectedInfo').show();
            } else {
                $('#selectedInfo').hide();
            }
        }

        // Update checkbox states when modal opens
        function updateCheckboxStates() {
            if (selectedAnggota.length > 0) {
                selectedAnggota.forEach(anggota => {
                    $(`.anggota-checkbox[value="${anggota.id}"]`).prop('checked', true);
                });
                updateSelectAllState();
                updateSelectedCount();
            }
        }

        // Handle konfirmasi pilihan
        $('#btnKonfirmasiPilihan').click(function() {
            selectedAnggota = [];
            let anggotaIds = [];

            $('.anggota-checkbox:checked').each(function() {
                const anggotaData = {
                    id: $(this).val(),
                    nama: $(this).data('nama'),
                    nrp: $(this).data('nrp'),
                    pangkat: $(this).data('pangkat')
                };
                selectedAnggota.push(anggotaData);
                anggotaIds.push(anggotaData.id);
            });

            updateSelectedAnggotaDisplay();
            $('#anggota_ids').val(anggotaIds.join(','));

            // Reset search when closing modal
            $('#searchAnggota').val('');
            if (dataTableAnggota) {
                dataTableAnggota.search('').draw();
            }

            $('#modalPilihAnggota').modal('hide');
        });

        // Reset search when modal is hidden
        $('#modalPilihAnggota').on('hidden.bs.modal', function() {
            $('#searchAnggota').val('');
            if (dataTableAnggota) {
                dataTableAnggota.search('').draw();
            }
        });

        function updateSelectedAnggotaDisplay() {
            const container = $('#selectedAnggotaList');

            if (selectedAnggota.length === 0) {
                container.html(`
                    <p class="text-muted text-center mb-0">
                        <i class="fas fa-users"></i><br>
                        Belum ada anggota dipilih
                    </p>
                `);
            } else {
                let html = '<div class="d-flex flex-wrap">';
                selectedAnggota.forEach(function(anggota, index) {
                    html += `
                        <div class="badge badge-warning mr-2 mb-2 p-2" style="font-size: 0.85em;">
                            <div><strong>${anggota.nama}</strong></div>
                            <div><small>${anggota.nrp} - ${anggota.pangkat}</small></div>
                            <button type="button" class="btn btn-link btn-sm p-0 ml-2 text-white" onclick="removeAnggota(${index})">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
                });
                html += '</div>';
                html += `<small class="text-muted">Total: <strong>${selectedAnggota.length} anggota</strong></small>`;
                container.html(html);
            }
        }

        // Function global untuk remove anggota
        window.removeAnggota = function(index) {
            const removedAnggotaId = selectedAnggota[index].id;
            selectedAnggota.splice(index, 1);

            // Update checkbox in modal
            $(`.anggota-checkbox[value="${removedAnggotaId}"]`).prop('checked', false);

            updateSelectedAnggotaDisplay();

            const anggotaIds = selectedAnggota.map(a => a.id);
            $('#anggota_ids').val(anggotaIds.join(','));
        };

        // Set default jam berdasarkan shift
        $('#shift').change(function() {
            const shift = $(this).val();
            let jamMulai = '';
            let jamSelesai = '';

            switch (shift) {
                case 'pagi':
                    jamMulai = '06:00';
                    jamSelesai = '14:00';
                    break;
                case 'siang':
                    jamMulai = '14:00';
                    jamSelesai = '22:00';
                    break;
                case 'malam':
                    jamMulai = '22:00';
                    jamSelesai = '06:00';
                    break;
                default:
                    jamMulai = '';
                    jamSelesai = '';
            }

            $('#jam_mulai').val(jamMulai);
            $('#jam_selesai').val(jamSelesai);
        });

        // AJAX Form Submit
        $('#formPiket').submit(function(e) {
            e.preventDefault();

            // Reset validation
            $('.form-control').removeClass('is-invalid');
            $('.invalid-feedback').empty();

            const formData = new FormData(this);

            // Validasi anggota minimal 1
            if (!$('#anggota_ids').val()) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan!',
                    text: 'Minimal harus memilih satu anggota untuk piket',
                    confirmButtonColor: '#ffc107'
                });
                return;
            }

            // Submit dengan AJAX
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                beforeSend: function() {
                    Swal.fire({
                        title: 'Menyimpan...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(response) {
                    Swal.close();

                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            confirmButtonColor: '#28a745'
                        }).then((result) => {
                            if (result.isConfirmed && response.redirect) {
                                window.location.href = response.redirect;
                            }
                        });
                    } else {
                        // Display validation errors
                        if (response.errors) {
                            Object.keys(response.errors).forEach(function(field) {
                                const input = $('[name="' + field + '"]');
                                input.addClass('is-invalid');
                                input.siblings('.invalid-feedback').text(response.errors[field]);
                            });
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: response.message,
                            confirmButtonColor: '#dc3545'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.close();
                    console.error('AJAX Error:', error);

                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan pada server. Silakan coba lagi.',
                        confirmButtonColor: '#dc3545'
                    });
                }
            });
        });
    });
</script>

<?= $this->endSection() ?>