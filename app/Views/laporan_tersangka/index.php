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
                        <h3 id="totalTersangka">0</h3>
                        <p>Total Tersangka</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-tie"></i>
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
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3 id="ditahan">0</h3>
                        <p>Ditahan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-lock"></i>
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
                    <i class="fas fa-table mr-2"></i>Data Tersangka
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tersangkaTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>NIK</th>
                                <th>Jenis Kelamin</th>
                                <th>Umur</th>
                                <th>Alamat</th>
                                <th>Status Tersangka</th>
                                <th>Tempat Penahanan</th>
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
                    <i class="fas fa-user-tie mr-2"></i>Detail Tersangka
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
        let tersangkaTable;

        // Initialize DataTable
        function initDataTable() {
            if (tersangkaTable) {
                tersangkaTable.destroy();
            }

            tersangkaTable = $('#tersangkaTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '<?= base_url('laporan-tersangka/get-data') ?>',
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
                        data: 'status_tersangka',
                        name: 'status_tersangka'
                    },
                    {
                        data: 'tempat_penahanan',
                        name: 'tempat_penahanan'
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
            $.get('<?= base_url('laporan-tersangka/statistics') ?>')
                .done(function(response) {
                    if (response.success) {
                        const stats = response.data;
                        $('#totalTersangka').text(stats.total);
                        $('#lakiLaki').text(stats.laki_laki);
                        $('#perempuan').text(stats.perempuan);
                        $('#ditahan').text(stats.ditahan);
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

            $.get('<?= base_url('laporan-tersangka/detail') ?>/' + id)
                .done(function(response) {
                    if (response.success) {
                        const tersangka = response.data;

                        // Status tersangka badge mapping
                        const statusTersangkaBadges = {
                            'dpo': 'badge-danger',
                            'tersangka': 'badge-warning',
                            'terdakwa': 'badge-info',
                            'terpidana': 'badge-dark'
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
                            <h6><i class="fas fa-user mr-2"></i>Informasi Tersangka</h6>
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td class="font-weight-bold" style="width: 120px;">Nama</td>
                                    <td>: ${tersangka.nama}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">NIK</td>
                                    <td>: ${tersangka.nik || '-'}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Jenis Kelamin</td>
                                    <td>: ${tersangka.jenis_kelamin.charAt(0).toUpperCase() + tersangka.jenis_kelamin.slice(1)}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Umur</td>
                                    <td>: ${tersangka.umur} tahun</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Alamat</td>
                                    <td>: ${tersangka.alamat || '-'}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Status</td>
                                    <td>: <span class="badge ${statusTersangkaBadges[tersangka.status_tersangka] || 'badge-light'}">${tersangka.status_tersangka.toUpperCase()}</span></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-folder mr-2"></i>Informasi Kasus</h6>
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td class="font-weight-bold" style="width: 120px;">No. Kasus</td>
                                    <td>: ${tersangka.nomor_kasus || '-'}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Judul Kasus</td>
                                    <td>: ${tersangka.judul_kasus || '-'}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Jenis Kasus</td>
                                    <td>: ${tersangka.nama_jenis || '-'}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Tanggal Kejadian</td>
                                    <td>: ${tersangka.tanggal_kejadian ? new Date(tersangka.tanggal_kejadian).toLocaleDateString('id-ID') : '-'}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Status Kasus</td>
                                    <td>: <span class="badge ${statusKasusBadges[tersangka.status_kasus] || 'badge-light'}">${(tersangka.status_kasus || '').replace('_', ' ').toUpperCase()}</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                `;

                        if (tersangka.tempat_penahanan) {
                            content += `
                        <hr>
                        <h6><i class="fas fa-lock mr-2"></i>Informasi Penahanan</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Tempat Penahanan:</strong> ${tersangka.tempat_penahanan}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Tanggal Penahanan:</strong> ${tersangka.tanggal_penahanan ? new Date(tersangka.tanggal_penahanan).toLocaleDateString('id-ID') : '-'}</p>
                            </div>
                        </div>
                    `;
                        }

                        if (tersangka.pasal_yang_disangkakan) {
                            content += `
                        <hr>
                        <h6><i class="fas fa-gavel mr-2"></i>Pasal yang Disangkakan</h6>
                        <div class="alert alert-warning">
                            ${tersangka.pasal_yang_disangkakan}
                        </div>
                    `;
                        }

                        if (tersangka.barang_bukti) {
                            content += `
                        <hr>
                        <h6><i class="fas fa-box mr-2"></i>Barang Bukti</h6>
                        <div class="alert alert-info">
                            ${tersangka.barang_bukti}
                        </div>
                    `;
                        }

                        if (tersangka.keterangan) {
                            content += `
                        <hr>
                        <h6><i class="fas fa-sticky-note mr-2"></i>Keterangan Tambahan</h6>
                        <div class="alert alert-secondary">
                            ${tersangka.keterangan}
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
                    Gagal memuat detail tersangka.
                </div>
            `);
                });
        };

        // Initialize
        initDataTable();
        loadStatistics();

        // Refresh button
        $('#btnRefresh').click(function() {
            tersangkaTable.ajax.reload();
            loadStatistics();
        });

        // Print button
        $('#btnPrint').click(function() {
            window.open('<?= base_url('laporan-tersangka/print') ?>', '_blank');
        });
    });
</script>
<?= $this->endSection() ?>
