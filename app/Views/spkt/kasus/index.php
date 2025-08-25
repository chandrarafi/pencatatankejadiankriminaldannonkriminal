<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Kelola Data Kasus<?= $this->endSection() ?>

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

<!-- Data Table Card -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-folder-open mr-2"></i>
            Daftar Data Kasus
        </h3>
        <div class="card-tools">
            <a href="<?= base_url('spkt/kasus/create') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus mr-1"></i> Tambah Kasus Baru
            </a>
        </div>
    </div>

    <div class="card-body">
        <!-- Filter Section -->
        <div class="row mb-3">
            <div class="col-md-3">
                <select id="filterStatus" class="form-control form-control-sm">
                    <option value="">Semua Status</option>
                    <option value="dilaporkan">Dilaporkan</option>
                    <option value="dalam_proses">Dalam Proses</option>
                    <option value="selesai">Selesai</option>
                    <option value="ditutup">Ditutup</option>
                </select>
            </div>
            <div class="col-md-3">
                <select id="filterPrioritas" class="form-control form-control-sm">
                    <option value="">Semua Prioritas</option>
                    <option value="rendah">Rendah</option>
                    <option value="sedang">Sedang</option>
                    <option value="tinggi">Tinggi</option>
                    <option value="darurat">Darurat</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="date" id="filterTanggal" class="form-control form-control-sm" placeholder="Filter Tanggal">
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-secondary btn-sm" onclick="resetFilters()">
                    <i class="fas fa-sync mr-1"></i> Reset Filter
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table id="tableKasus" class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th width="12%">Nomor Kasus</th>
                        <th width="20%">Judul Kasus</th>
                        <th width="15%">Jenis Kasus</th>
                        <th width="10%">Tanggal</th>
                        <th width="10%">Status</th>
                        <th width="10%">Prioritas</th>
                        <th width="13%">Pelapor</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data akan diload via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Initialize DataTable
        const table = $('#tableKasus').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= base_url('spkt/kasus/get-data') ?>',
                type: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                data: function(d) {
                    d.filter_status = $('#filterStatus').val();
                    d.filter_prioritas = $('#filterPrioritas').val();
                    d.filter_tanggal = $('#filterTanggal').val();
                }
            },
            columns: [{
                    data: 0,
                    name: 'nomor_kasus'
                },
                {
                    data: 1,
                    name: 'judul_kasus'
                },
                {
                    data: 2,
                    name: 'nama_jenis'
                },
                {
                    data: 3,
                    name: 'tanggal_kejadian'
                },
                {
                    data: 4,
                    name: 'status',
                    orderable: false
                },
                {
                    data: 5,
                    name: 'prioritas',
                    orderable: false
                },
                {
                    data: 6,
                    name: 'pelapor_nama'
                },
                {
                    data: 7,
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ],
            order: [
                [3, 'desc']
            ],
            pageLength: 10,
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
            },
            dom: "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            drawCallback: function() {
                // Re-initialize tooltips
                $('[data-toggle="tooltip"]').tooltip();
            }
        });

        // Filter handlers
        $('#filterStatus, #filterPrioritas, #filterTanggal').on('change', function() {
            table.draw();
        });

        // Refresh table
        window.refreshTable = function() {
            table.ajax.reload(null, false);
        };

        // Reset filters
        window.resetFilters = function() {
            $('#filterStatus, #filterPrioritas, #filterTanggal').val('');
            table.draw();
        };
    });

    // Show detail function
    function showDetail(id) {
        window.location.href = '<?= base_url('spkt/kasus/show') ?>/' + id;
    }

    // Edit function
    function editData(id) {
        window.location.href = '<?= base_url('spkt/kasus/edit') ?>/' + id;
    }

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
                            });
                            refreshTable();
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

    // Quick status update
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
                            Swal.fire('Berhasil!', response.message, 'success');
                            refreshTable();
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
