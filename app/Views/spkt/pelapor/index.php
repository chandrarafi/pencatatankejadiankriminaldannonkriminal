<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Kelola Data Pelapor<?= $this->endSection() ?>

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
            <i class="fas fa-users mr-2"></i>
            Daftar Data Pelapor
        </h3>
        <div class="card-tools">
            <a href="<?= base_url('spkt/pelapor/create') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus mr-1"></i> Tambah Pelapor Baru
            </a>
        </div>
    </div>

    <div class="card-body">
        <!-- Filter Section -->
        <div class="row mb-3">
            <div class="col-md-3">
                <select id="filterJenisKelamin" class="form-control form-control-sm">
                    <option value="">Semua Jenis Kelamin</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div class="col-md-3">
                <select id="filterStatus" class="form-control form-control-sm">
                    <option value="">Semua Status</option>
                    <option value="1">Aktif</option>
                    <option value="0">Non-Aktif</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="text" id="filterKota" class="form-control form-control-sm" placeholder="Filter Kota/Kabupaten">
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-secondary btn-sm" onclick="resetFilters()">
                    <i class="fas fa-sync mr-1"></i> Reset Filter
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table id="tablePelapor" class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th width="20%">Nama</th>
                        <th width="12%">NIK</th>
                        <th width="12%">Telepon</th>
                        <th width="15%">Email</th>
                        <th width="10%">Jenis Kelamin</th>
                        <th width="15%">Kota/Kabupaten</th>
                        <th width="8%">Status</th>
                        <th width="8%">Aksi</th>
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
<style>
    .badge-pink {
        background-color: #e83e8c;
        color: white;
    }
</style>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        const table = $('#tablePelapor').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= base_url('spkt/pelapor/get-data') ?>',
                type: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                data: function(d) {
                    d.filter_jenis_kelamin = $('#filterJenisKelamin').val();
                    d.filter_status = $('#filterStatus').val();
                    d.filter_kota = $('#filterKota').val();
                }
            },
            columns: [{
                    data: 0,
                    name: 'nama'
                },
                {
                    data: 1,
                    name: 'nik'
                },
                {
                    data: 2,
                    name: 'telepon'
                },
                {
                    data: 3,
                    name: 'email'
                },
                {
                    data: 4,
                    name: 'jenis_kelamin',
                    orderable: false
                },
                {
                    data: 5,
                    name: 'kota_kabupaten'
                },
                {
                    data: 6,
                    name: 'is_active',
                    orderable: false
                },
                {
                    data: 7,
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ],
            order: [
                [0, 'asc']
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
        $('#filterJenisKelamin, #filterStatus').on('change', function() {
            table.draw();
        });

        $('#filterKota').on('keyup', function() {
            table.draw();
        });

        // Refresh table
        window.refreshTable = function() {
            table.ajax.reload(null, false);
        };

        // Reset filters
        window.resetFilters = function() {
            $('#filterJenisKelamin, #filterStatus').val('');
            $('#filterKota').val('');
            table.draw();
        };
    });

    // Show detail function
    function showDetail(id) {
        window.location.href = '<?= base_url('spkt/pelapor/show') ?>/' + id;
    }

    // Edit function
    function editData(id) {
        window.location.href = '<?= base_url('spkt/pelapor/edit') ?>/' + id;
    }

    // Delete function
    function deleteData(id, nama) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            html: `Apakah Anda yakin ingin menghapus data pelapor:<br><strong>${nama}</strong>?`,
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
                    url: '<?= base_url('spkt/pelapor/delete') ?>/' + id,
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
</script>
<?= $this->endSection() ?>