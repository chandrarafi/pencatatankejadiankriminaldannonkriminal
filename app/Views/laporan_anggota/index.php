<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><?= $title ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active"><?= $title ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <!-- Statistics Cards -->
        <div class="row" id="statisticsCards">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3 id="totalAnggota">0</h3>
                        <p>Total Anggota</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 id="aktif">0</h3>
                        <p>Aktif</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-check"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3 id="nonAktif">0</h3>
                        <p>Non Aktif</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-times"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3 id="pensiun">0</h3>
                        <p>Pensiun</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-clock"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Statistics Cards -->
        <div class="row mb-3">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3 id="mutasi">0</h3>
                        <p>Mutasi</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-indigo">
                    <div class="inner">
                        <h3 id="denganNrp">0</h3>
                        <p>Dengan NRP</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-id-card"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-dark">
                    <div class="inner">
                        <h3 id="tanpaNrp">0</h3>
                        <p>Tanpa NRP</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-id-card-alt"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-purple">
                    <div class="inner">
                        <h3 id="unitKerja">0</h3>
                        <p>Unit Kerja</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-building"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row mb-3">
            <div class="col-12">
                <button type="button" id="btnRefresh" class="btn btn-secondary">
                    <i class="fas fa-sync-alt mr-1"></i> Refresh Data
                </button>
                <button type="button" id="btnPrint" class="btn btn-success">
                    <i class="fas fa-print mr-1"></i> Cetak Laporan
                </button>
            </div>
        </div>

        <!-- Data Table Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-table mr-2"></i>Data Anggota Polsek Lunang Silaut
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="anggotaTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>NRP</th>
                                <th>Pangkat</th>
                                <th>Jabatan</th>
                                <th>Unit Kerja</th>
                                <th>Telepon</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Tanggal Masuk</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white" id="detailModalLabel">
                    <i class="fas fa-user mr-2"></i>Detail Anggota
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="detailContent">
                    <div class="text-center">
                        <i class="fas fa-spinner fa-spin fa-2x"></i>
                        <p class="mt-2">Memuat data...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        let anggotaTable;

        // Initialize DataTable
        function initDataTable() {
            if (anggotaTable) {
                anggotaTable.destroy();
            }

            anggotaTable = $('#anggotaTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '<?= base_url('laporan-anggota/get-data') ?>',
                    type: 'POST',
                    data: function(d) {
                        d.<?= csrf_token() ?> = '<?= csrf_hash() ?>';
                    }
                },
                columns: [{
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'nrp',
                        name: 'nrp'
                    },
                    {
                        data: 'pangkat',
                        name: 'pangkat'
                    },
                    {
                        data: 'jabatan',
                        name: 'jabatan'
                    },
                    {
                        data: 'unit_kerja',
                        name: 'unit_kerja'
                    },
                    {
                        data: 'telepon',
                        name: 'telepon'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false
                    },
                    {
                        data: 'tanggal_masuk',
                        name: 'tanggal_masuk'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [0, 'asc']
                ],
                language: {
                    processing: "Memproses...",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    zeroRecords: "Data tidak ditemukan",
                    info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                    infoEmpty: "Tidak ada data tersedia",
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
                    loadStatistics();
                }
            });
        }

        // Load statistics
        function loadStatistics() {
            $.get('<?= base_url('laporan-anggota/statistics') ?>')
                .done(function(response) {
                    if (response.success) {
                        const stats = response.data;
                        $('#totalAnggota').text(stats.total);
                        $('#aktif').text(stats.aktif);
                        $('#nonAktif').text(stats.non_aktif);
                        $('#pensiun').text(stats.pensiun);
                        $('#mutasi').text(stats.mutasi);
                        $('#denganNrp').text(stats.dengan_nrp);
                        $('#tanpaNrp').text(stats.tanpa_nrp);
                        $('#unitKerja').text(Object.keys(stats.unit_kerja).length);
                    }
                })
                .fail(function() {
                    console.error('Failed to load statistics');
                });
        }

        // Show detail function
        window.showDetail = function(id) {
            $('#detailModal').modal('show');
            $('#detailContent').html(`
            <div class="text-center">
                <i class="fas fa-spinner fa-spin fa-2x"></i>
                <p class="mt-2">Memuat data...</p>
            </div>
        `);

            $.get('<?= base_url('laporan-anggota/detail') ?>/' + id)
                .done(function(response) {
                    if (response.success) {
                        const anggota = response.data;

                        // Status mapping for anggota table
                        const statusBadges = {
                            'aktif': 'badge-success',
                            'non_aktif': 'badge-danger',
                            'pensiun': 'badge-warning',
                            'mutasi': 'badge-info'
                        };

                        const statusBadge = statusBadges[anggota.status] || 'badge-secondary';

                        let content = `
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="fas fa-user mr-2"></i>Informasi Pribadi</h6>
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td class="font-weight-bold" style="width: 120px;">Nama</td>
                                    <td>: ${anggota.nama}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">NRP</td>
                                    <td>: ${anggota.nrp || '-'}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Pangkat</td>
                                    <td>: ${anggota.pangkat || '-'}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Jabatan</td>
                                    <td>: ${anggota.jabatan || '-'}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Status</td>
                                    <td>: <span class="badge ${statusBadge}">${anggota.status.toUpperCase()}</span></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-briefcase mr-2"></i>Informasi Dinas</h6>
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td class="font-weight-bold" style="width: 120px;">Unit Kerja</td>
                                    <td>: ${anggota.unit_kerja || '-'}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Email</td>
                                    <td>: ${anggota.email || '-'}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Telepon</td>
                                    <td>: ${anggota.telepon || '-'}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Alamat</td>
                                    <td>: ${anggota.alamat || '-'}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Tanggal Masuk</td>
                                    <td>: ${anggota.tanggal_masuk ? new Date(anggota.tanggal_masuk).toLocaleDateString('id-ID') : '-'}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Keterangan</td>
                                    <td>: ${anggota.keterangan || '-'}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                `;

                        // Add additional info if available
                        if (anggota.foto) {
                            content += `
                        <hr>
                        <h6><i class="fas fa-image mr-2"></i>Foto Anggota</h6>
                        <div class="text-center">
                            <img src="${anggota.foto}" alt="Foto ${anggota.nama}" class="img-thumbnail" style="max-width: 200px;">
                        </div>
                    `;
                        }

                        $('#detailContent').html(content);
                    } else {
                        $('#detailContent').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        ${response.message}
                    </div>
                `);
                    }
                })
                .fail(function() {
                    $('#detailContent').html(`
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Gagal memuat detail anggota.
                </div>
            `);
                });
        };

        // Initialize
        initDataTable();
        loadStatistics();

        // Refresh button
        $('#btnRefresh').click(function() {
            anggotaTable.ajax.reload();
            loadStatistics();
        });

        // Print button
        $('#btnPrint').click(function() {
            window.open('<?= base_url('laporan-anggota/print') ?>', '_blank');
        });
    });
</script>
<?= $this->endSection() ?>