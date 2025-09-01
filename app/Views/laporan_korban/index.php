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
                        <h3 id="totalKorban">0</h3>
                        <p>Total Korban</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-injured"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3 id="lakiLaki">0</h3>
                        <p>Laki-laki</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-male"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-pink">
                    <div class="inner">
                        <h3 id="perempuan">0</h3>
                        <p>Perempuan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-female"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3 id="meninggal">0</h3>
                        <p>Meninggal</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-heart-broken"></i>
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
                    <i class="fas fa-table mr-2"></i>Data Korban
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="korbanTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>NIK</th>
                                <th>Jenis Kelamin</th>
                                <th>Umur</th>
                                <th>Alamat</th>
                                <th>Status Korban</th>
                                <th>No. Kasus</th>
                                <th>Terdaftar</th>
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
                    <i class="fas fa-user-injured mr-2"></i>Detail Korban
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
        let korbanTable;

        // Initialize DataTable
        function initDataTable() {
            if (korbanTable) {
                korbanTable.destroy();
            }

            korbanTable = $('#korbanTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '<?= base_url('laporan-korban/get-data') ?>',
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
                        data: 'nik',
                        name: 'nik'
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
                        data: 'alamat',
                        name: 'alamat'
                    },
                    {
                        data: 'status_korban',
                        name: 'status_korban'
                    },
                    {
                        data: 'nomor_kasus',
                        name: 'nomor_kasus'
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
            $.get('<?= base_url('laporan-korban/statistics') ?>')
                .done(function(response) {
                    if (response.success) {
                        const stats = response.data;
                        $('#totalKorban').text(stats.total);
                        $('#lakiLaki').text(stats.laki_laki);
                        $('#perempuan').text(stats.perempuan);
                        $('#meninggal').text(stats.meninggal);
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

            $.get('<?= base_url('laporan-korban/detail') ?>/' + id)
                .done(function(response) {
                    if (response.success) {
                        const korban = response.data;

                        // Status badge mapping
                        const statusBadges = {
                            'meninggal': 'badge-danger',
                            'luka_berat': 'badge-warning',
                            'luka_ringan': 'badge-info',
                            'tidak_luka': 'badge-success'
                        };

                        const statusKasusBadges = {
                            'dilaporkan': 'badge-warning',
                            'dalam_proses': 'badge-info',
                            'selesai': 'badge-success',
                            'ditutup': 'badge-secondary'
                        };

                        let content = `
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="fas fa-user mr-2"></i>Informasi Korban</h6>
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td class="font-weight-bold" style="width: 120px;">Nama</td>
                                    <td>: ${korban.nama}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">NIK</td>
                                    <td>: ${korban.nik || '-'}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Jenis Kelamin</td>
                                    <td>: ${korban.jenis_kelamin.charAt(0).toUpperCase() + korban.jenis_kelamin.slice(1)}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Umur</td>
                                    <td>: ${korban.umur} tahun</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Alamat</td>
                                    <td>: ${korban.alamat || '-'}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Status Korban</td>
                                    <td>: <span class="badge ${statusBadges[korban.status_korban] || 'badge-light'}">${korban.status_korban.replace('_', ' ').toUpperCase()}</span></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-folder mr-2"></i>Informasi Kasus</h6>
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td class="font-weight-bold" style="width: 120px;">No. Kasus</td>
                                    <td>: ${korban.nomor_kasus || '-'}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Judul Kasus</td>
                                    <td>: ${korban.judul_kasus || '-'}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Jenis Kasus</td>
                                    <td>: ${korban.nama_jenis || '-'}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Tanggal Kejadian</td>
                                    <td>: ${korban.tanggal_kejadian ? new Date(korban.tanggal_kejadian).toLocaleDateString('id-ID') : '-'}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Status Kasus</td>
                                    <td>: <span class="badge ${statusKasusBadges[korban.status_kasus] || 'badge-light'}">${(korban.status_kasus || '').replace('_', ' ').toUpperCase()}</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                `;

                        if (korban.keterangan_luka) {
                            content += `
                        <hr>
                        <h6><i class="fas fa-notes-medical mr-2"></i>Keterangan Luka</h6>
                        <div class="alert alert-warning">
                            ${korban.keterangan_luka}
                        </div>
                    `;
                        }

                        if (korban.keterangan) {
                            content += `
                        <hr>
                        <h6><i class="fas fa-sticky-note mr-2"></i>Keterangan Tambahan</h6>
                        <div class="alert alert-info">
                            ${korban.keterangan}
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
                    Gagal memuat detail korban.
                </div>
            `);
                });
        };

        // Initialize
        initDataTable();
        loadStatistics();

        // Refresh button
        $('#btnRefresh').click(function() {
            korbanTable.ajax.reload();
            loadStatistics();
        });

        // Print button
        $('#btnPrint').click(function() {
            window.open('<?= base_url('laporan-korban/print') ?>', '_blank');
        });
    });
</script>
<?= $this->endSection() ?>
