<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Kelola Jenis Kasus<?= $this->endSection() ?>

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
            <i class="fas fa-file-alt mr-2"></i>
            Daftar Jenis Kasus
        </h3>
        <div class="card-tools">
            <a href="<?= base_url('spkt/jenis-kasus/create') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus mr-1"></i> Tambah Jenis Kasus
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table id="tableJenisKasus" class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th width="15%">Kode Jenis</th>
                        <th width="30%">Nama Jenis</th>
                        <th width="25%">Deskripsi</th>
                        <th width="10%">Status</th>
                        <th width="10%">Dibuat</th>
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
        const table = $('#tableJenisKasus').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= base_url('spkt/jenis-kasus/get-data') ?>',
                type: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            },
            columns: [{
                    data: 0,
                    name: 'kode_jenis'
                },
                {
                    data: 1,
                    name: 'nama_jenis'
                },
                {
                    data: 2,
                    name: 'deskripsi',
                    orderable: false
                },
                {
                    data: 3,
                    name: 'is_active',
                    orderable: false
                },
                {
                    data: 4,
                    name: 'created_at'
                },
                {
                    data: 5,
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ],
            order: [
                [4, 'desc']
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

        // Refresh table
        window.refreshTable = function() {
            table.ajax.reload(null, false);
        };
    });

    // Show detail function
    function showDetail(id) {
        window.location.href = '<?= base_url('spkt/jenis-kasus/show') ?>/' + id;
    }

    // Edit function
    function editData(id) {
        window.location.href = '<?= base_url('spkt/jenis-kasus/edit') ?>/' + id;
    }

    // Delete function
    function deleteData(id, nama) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            html: `Apakah Anda yakin ingin menghapus jenis kasus:<br><strong>${nama}</strong>?`,
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
                    url: '<?= base_url('spkt/jenis-kasus/delete') ?>/' + id,
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
