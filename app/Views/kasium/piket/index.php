<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Data Piket<?= $this->endSection() ?>

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
            <i class="fas fa-calendar-alt mr-2"></i>
            Daftar Jadwal Piket Polsek Lunang Silaut
        </h3>
        <div class="card-tools">
            <a href="<?= base_url('kasium/piket/create') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus mr-1"></i> Tambah Piket
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table id="tablePiket" class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th width="12%">Tanggal</th>
                        <th width="20%">Anggota</th>
                        <th width="10%">Shift</th>
                        <th width="15%">Jam</th>
                        <th width="18%">Lokasi</th>
                        <th width="10%">Status</th>
                        <th width="15%">Aksi</th>
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
        const table = $('#tablePiket').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= base_url('kasium/piket/data') ?>',
                type: 'POST'
            },
            columns: [{
                    data: 0,
                    name: 'tanggal_piket'
                },
                {
                    data: 1,
                    name: 'nama_anggota'
                },
                {
                    data: 2,
                    name: 'shift'
                },
                {
                    data: 3,
                    name: 'jam',
                    orderable: false
                },
                {
                    data: 4,
                    name: 'lokasi_piket'
                },
                {
                    data: 5,
                    name: 'status',
                    orderable: false
                },
                {
                    data: 6,
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ],
            order: [
                [0, 'desc']
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

        // No need for delete handler since we use direct links now
    });
</script>
<?= $this->endSection() ?>