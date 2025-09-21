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
                        <h3 id="totalSaksi">0</h3>
                        <p>Total Saksi</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-eye"></i>
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
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 id="dapatDihubungi">0</h3>
                        <p>Dapat Dihubungi</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-phone"></i>
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
                    <i class="fas fa-table mr-2"></i>Data Saksi
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="saksiTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>NIK</th>
                                <th>Jenis Kelamin</th>
                                <th>Umur</th>
                                <th>Alamat</th>
                                <th>Jenis Saksi</th>
                                <th>Dapat Dihubungi</th>
                                <th>Kode Jenis</th>
                                <th>Judul Kasus</th>
                                <th>Deskripsi</th>
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
                    <i class="fas fa-eye mr-2"></i>Detail Saksi
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
        let saksiTable;

        // Initialize DataTable
        function initDataTable() {
            if (saksiTable) {
                saksiTable.destroy();
            }

            saksiTable = $('#saksiTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '<?= base_url('laporan-saksi/get-data') ?>',
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
                        data: 'jenis_saksi',
                        name: 'jenis_saksi'
                    },
                    {
                        data: 'dapat_dihubungi',
                        name: 'dapat_dihubungi',
                        orderable: false
                    },
                    {
                        data: 'kode_jenis',
                        name: 'kode_jenis'
                    },
                    {
                        data: 'judul_kasus',
                        name: 'judul_kasus'
                    },
                    {
                        data: 'deskripsi',
                        name: 'deskripsi',
                        orderable: false
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
            $.get('<?= base_url('laporan-saksi/statistics') ?>')
                .done(function(response) {
                    if (response.success) {
                        const stats = response.data;
                        $('#totalSaksi').text(stats.total);
                        $('#lakiLaki').text(stats.laki_laki);
                        $('#perempuan').text(stats.perempuan);
                        $('#dapatDihubungi').text(stats.dapat_dihubungi);
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

            $.get('<?= base_url('laporan-saksi/detail') ?>/' + id)
                .done(function(response) {
                    if (response.success) {
                        const saksi = response.data;

                        // Jenis saksi badge mapping
                        const jenisSaksiBadges = {
                            'saksi_mata': 'badge-primary',
                            'saksi_telinga': 'badge-info',
                            'saksi_korban': 'badge-warning',
                            'saksi_ahli': 'badge-success'
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
                            <h6><i class="fas fa-user mr-2"></i>Informasi Saksi</h6>
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td class="font-weight-bold" style="width: 120px;">Nama</td>
                                    <td>: ${saksi.nama}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">NIK</td>
                                    <td>: ${saksi.nik || '-'}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Jenis Kelamin</td>
                                    <td>: ${saksi.jenis_kelamin.charAt(0).toUpperCase() + saksi.jenis_kelamin.slice(1)}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Umur</td>
                                    <td>: ${saksi.umur} tahun</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Alamat</td>
                                    <td>: ${saksi.alamat || '-'}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Jenis Saksi</td>
                                    <td>: <span class="badge ${jenisSaksiBadges[saksi.jenis_saksi] || 'badge-light'}">${saksi.jenis_saksi.replace('_', ' ').toUpperCase()}</span></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Dapat Dihubungi</td>
                                    <td>: <span class="badge ${saksi.dapat_dihubungi ? 'badge-success' : 'badge-danger'}">${saksi.dapat_dihubungi ? 'Ya' : 'Tidak'}</span></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-folder mr-2"></i>Informasi Kasus</h6>
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td class="font-weight-bold" style="width: 120px;">No. Kasus</td>
                                    <td>: ${saksi.nomor_kasus || '-'}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Judul Kasus</td>
                                    <td>: ${saksi.judul_kasus || '-'}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Jenis Kasus</td>
                                    <td>: ${saksi.nama_jenis || '-'}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Tanggal Kejadian</td>
                                    <td>: ${saksi.tanggal_kejadian ? new Date(saksi.tanggal_kejadian).toLocaleDateString('id-ID') : '-'}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Status Kasus</td>
                                    <td>: <span class="badge ${statusKasusBadges[saksi.status_kasus] || 'badge-light'}">${(saksi.status_kasus || '').replace('_', ' ').toUpperCase()}</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                `;

                        if (saksi.hubungan_dengan_korban) {
                            content += `
                        <hr>
                        <h6><i class="fas fa-link mr-2"></i>Hubungan dengan Korban</h6>
                        <div class="alert alert-info">
                            ${saksi.hubungan_dengan_korban}
                        </div>
                    `;
                        }

                        if (saksi.hubungan_dengan_tersangka) {
                            content += `
                        <hr>
                        <h6><i class="fas fa-user-tie mr-2"></i>Hubungan dengan Tersangka</h6>
                        <div class="alert alert-warning">
                            ${saksi.hubungan_dengan_tersangka}
                        </div>
                    `;
                        }

                        if (saksi.keterangan_kesaksian) {
                            content += `
                        <hr>
                        <h6><i class="fas fa-comments mr-2"></i>Keterangan Kesaksian</h6>
                        <div class="alert alert-primary">
                            ${saksi.keterangan_kesaksian}
                        </div>
                    `;
                        }

                        if (saksi.keterangan) {
                            content += `
                        <hr>
                        <h6><i class="fas fa-sticky-note mr-2"></i>Keterangan Tambahan</h6>
                        <div class="alert alert-secondary">
                            ${saksi.keterangan}
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
                    Gagal memuat detail saksi.
                </div>
            `);
                });
        };

        // Initialize
        initDataTable();
        loadStatistics();

        // Refresh button
        $('#btnRefresh').click(function() {
            saksiTable.ajax.reload();
            loadStatistics();
        });

        // Print button
        $('#btnPrint').click(function() {
            window.open('<?= base_url('laporan-saksi/print') ?>', '_blank');
        });
    });
</script>
<?= $this->endSection() ?>