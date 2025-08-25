<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Data Pelapor<?= $this->endSection() ?>

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
            Data Pelapor
        </h3>
        <div class="card-tools">
            <span class="badge badge-info">Read Only - RESKRIM</span>
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
                    <option value="0">Nonaktif</option>
                </select>
            </div>
            <div class="col-md-6">
                <div class="info-box bg-light">
                    <span class="info-box-icon bg-info">
                        <i class="fas fa-info-circle"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Akses Read-Only</span>
                        <span class="info-box-number">Hanya dapat melihat data pelapor dari SPKT</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table id="pelaporTable" class="table table-bordered table-striped" width="100%">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th>Status</th>
                        <th>Tanggal Dibuat</th>
                        <th width="60">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data akan dimuat via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Inisialisasi DataTable
        var table = $('#pelaporTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= base_url('reskrim/pelapor/get-data') ?>',
                type: 'POST',
                data: function(d) {
                    d.<?= csrf_token() ?> = '<?= csrf_hash() ?>';
                    d.filterJenisKelamin = $('#filterJenisKelamin').val();
                    d.filterStatus = $('#filterStatus').val();
                },
                error: function(xhr, error, thrown) {
                    console.error('DataTables Error:', xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Gagal memuat data pelapor'
                    });
                }
            },
            columns: [{
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'nik',
                    name: 'nik'
                },
                {
                    data: 'telepon',
                    name: 'telepon'
                },
                {
                    data: 'alamat',
                    name: 'alamat'
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false
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
            pageLength: 25,
            responsive: true,
            language: {
                processing: "Memuat data...",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                zeroRecords: "Data tidak ditemukan",
                info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                infoEmpty: "Tidak ada data yang tersedia",
                infoFiltered: "(difilter dari _MAX_ total data)",
                search: "Cari:",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            }
        });

        // Filter handlers
        $('#filterJenisKelamin, #filterStatus').on('change', function() {
            table.ajax.reload();
        });

        // Row click handler untuk detail (jika diperlukan)
        $('#pelaporTable tbody').on('click', 'tr', function() {
            var data = table.row(this).data();
            if (data) {
                // Bisa ditambahkan handler untuk detail view
                // window.location.href = '<?= base_url('reskrim/pelapor/show/') ?>' + data.id;
            }
        });
    });
</script>
<?= $this->endSection() ?>