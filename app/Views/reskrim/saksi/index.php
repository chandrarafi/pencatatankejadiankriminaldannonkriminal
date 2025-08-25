<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Data Saksi<?= $this->endSection() ?>

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
            <i class="fas fa-user-friends mr-2"></i>
            Data Saksi Polsek Lunang Silaut
        </h3>
        <div class="card-tools">
            <a href="<?= base_url('reskrim/saksi/create') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus mr-1"></i> Tambah Data Saksi
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table id="tableSaksi" class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th width="10%">NIK</th>
                        <th width="20%">Nama</th>
                        <th width="10%">JK</th>
                        <th width="8%">Umur</th>
                        <th width="12%">Jenis Saksi</th>
                        <th width="15%">Nomor Kasus</th>
                        <th width="15%">Judul Kasus</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data akan dimuat via DataTables -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        const table = $('#tableSaksi').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= base_url('reskrim/saksi/get-data') ?>',
                type: 'POST',
                data: function(d) {
                    return $.extend({}, d, {
                        "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                    });
                }
            },
            columns: [{
                    data: 'nik',
                    name: 'nik'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'jenis_kelamin',
                    name: 'jenis_kelamin'
                },
                {
                    data: 'umur',
                    name: 'umur'
                },
                {
                    data: 'jenis_saksi',
                    name: 'jenis_saksi',
                    orderable: false
                },
                {
                    data: 'nomor_kasus',
                    name: 'nomor_kasus'
                },
                {
                    data: 'judul_kasus',
                    name: 'judul_kasus'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ],
            order: [
                [1, 'asc']
            ],
            pageLength: 10,
            language: {
                processing: "Memproses...",
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                infoFiltered: "(disaring dari _MAX_ total data)",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                },
                emptyTable: "Tidak ada data yang tersedia",
                zeroRecords: "Tidak ditemukan data yang sesuai"
            }
        });

        // Handle delete button click
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            const id = $(this).data('id');

            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Apakah Anda yakin ingin menghapus data saksi ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= base_url('reskrim/saksi/delete/') ?>' + id,
                        type: 'DELETE',
                        data: {
                            "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                table.ajax.reload();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: response.message
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Terjadi kesalahan saat menghapus data'
                            });
                        }
                    });
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>

