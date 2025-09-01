<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Laporan Kasus<?= $this->endSection() ?>

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

<!-- Info Card -->
<div class="row">
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle mr-2"></i>
                    Informasi Laporan Kasus
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <p class="mb-2">
                            <strong>Laporan Komprehensif:</strong> Halaman ini menyediakan laporan lengkap untuk setiap kasus yang mencakup:
                        </p>
                        <ul class="list-unstyled ml-3">
                            <li><i class="fas fa-check text-success mr-2"></i> Data kasus dari SPKT</li>
                            <li><i class="fas fa-check text-success mr-2"></i> Informasi pelapor lengkap</li>
                            <li><i class="fas fa-check text-success mr-2"></i> Data korban (jika ada)</li>
                            <li><i class="fas fa-check text-success mr-2"></i> Data tersangka (jika ada)</li>
                            <li><i class="fas fa-check text-success mr-2"></i> Data saksi (jika ada)</li>
                            <li><i class="fas fa-check text-success mr-2"></i> Progress investigasi RESKRIM</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <div class="info-box bg-info">
                            <span class="info-box-icon">
                                <i class="fas fa-file-alt"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Akses Multi-Role</span>
                                <span class="info-box-number">SPKT, RESKRIM, KASIUM</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Data Table Card -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-file-alt mr-2"></i>
            Daftar Laporan Kasus
        </h3>
        <div class="card-tools">
            <div class="btn-group">
                <button type="button" class="btn btn-success btn-sm" onclick="exportToExcel()">
                    <i class="fas fa-file-excel mr-1"></i> Export Excel
                </button>
                <button type="button" class="btn btn-danger btn-sm" onclick="exportToPDF()">
                    <i class="fas fa-file-pdf mr-1"></i> Export PDF
                </button>
            </div>
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
                <input type="date" id="filterTanggal" class="form-control form-control-sm" placeholder="Filter Tanggal">
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4">
                        <div class="info-box bg-primary">
                            <span class="info-box-icon">
                                <i class="fas fa-folder"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Kasus</span>
                                <span class="info-box-number" id="total-kasus">-</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-box bg-warning">
                            <span class="info-box-icon">
                                <i class="fas fa-clock"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Dalam Proses</span>
                                <span class="info-box-number" id="dalam-proses">-</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-box bg-success">
                            <span class="info-box-icon">
                                <i class="fas fa-check"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Selesai</span>
                                <span class="info-box-number" id="selesai">-</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table id="laporanTable" class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th width="12%">Nomor Kasus</th>
                        <th width="25%">Judul Kasus</th>
                        <th width="12%">Tanggal Kejadian</th>
                        <th width="10%">Status</th>
                        <th width="8%">Korban</th>
                        <th width="8%">Tersangka</th>
                        <th width="8%">Saksi</th>
                        <th width="8%">Total Pihak</th>
                        <th width="9%">Aksi</th>
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
<script>
    $(document).ready(function() {
        // Initialize DataTable
        const table = $('#laporanTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= base_url('laporan/get-data') ?>',
                type: 'POST',
                data: function(d) {
                    d.<?= csrf_token() ?> = '<?= csrf_hash() ?>';
                    d.filterStatus = $('#filterStatus').val();
                    d.filterTanggal = $('#filterTanggal').val();
                },
                error: function(xhr, error, thrown) {
                    console.error('DataTables Error:', xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Gagal memuat data laporan'
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
                    data: 'korban_count',
                    name: 'korban_count',
                    className: 'text-center'
                },
                {
                    data: 'tersangka_count',
                    name: 'tersangka_count',
                    className: 'text-center'
                },
                {
                    data: 'saksi_count',
                    name: 'saksi_count',
                    className: 'text-center'
                },
                {
                    data: 'total_parties',
                    name: 'total_parties',
                    className: 'text-center'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                }
            ],
            order: [
                [2, 'desc']
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
            },
            drawCallback: function(settings) {
                updateStatistics();
            }
        });

        // Filter handlers
        $('#filterStatus, #filterTanggal').on('change', function() {
            table.ajax.reload();
        });

        function updateStatistics() {
            // Simple statistics update
            const info = table.page.info();
            $('#total-kasus').text(info.recordsTotal);

            // Count status from visible data (simple approximation)
            let dalamProses = 0;
            let selesai = 0;

            table.rows().every(function() {
                const data = this.data();
                const status = $(data.status).text().toLowerCase();
                if (status.includes('dalam proses')) dalamProses++;
                if (status.includes('selesai')) selesai++;
            });

            $('#dalam-proses').text(dalamProses);
            $('#selesai').text(selesai);
        }

        // Export functions
        window.exportToExcel = function() {
            Swal.fire({
                title: 'Export Excel',
                text: 'Fitur ini akan segera tersedia',
                icon: 'info'
            });
        };

        window.exportToPDF = function() {
            Swal.fire({
                title: 'Export PDF',
                text: 'Fitur ini akan segera tersedia',
                icon: 'info'
            });
        };
    });
</script>
<?= $this->endSection() ?>
