<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Data Kasus<?= $this->endSection() ?>

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
            Data Kasus SPKT (Read-Only)
        </h3>
        <div class="card-tools">
            <span class="badge badge-info">
                <i class="fas fa-eye mr-1"></i>
                View Only - Data dikelola oleh SPKT
            </span>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table id="tableKasus" class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th width="15%">Nomor Kasus</th>
                        <th width="25%">Judul Kasus</th>
                        <th width="12%">Tanggal Kejadian</th>
                        <th width="10%">Status</th>
                        <th width="15%">Pelapor</th>
                        <th width="13%">Tgl Input</th>
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
        const table = $('#tableKasus').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= base_url('reskrim/kasus/get-data') ?>',
                type: 'POST',
                data: function(d) {
                    return $.extend({}, d, {
                        "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                    });
                }
            },
            columns: [{
                    data: 'nomor_kasus',
                    name: 'nomor_kasus'
                },
                {
                    data: 'judul_kasus',
                    name: 'judul_kasus'
                },
                {
                    data: 'tanggal_kejadian',
                    name: 'tanggal_kejadian'
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false
                },
                {
                    data: 'pelapor_nama',
                    name: 'pelapor_nama'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ],
            order: [
                [5, 'desc']
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
    });
</script>
<?= $this->endSection() ?>

