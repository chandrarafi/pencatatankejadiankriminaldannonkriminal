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
                        <h3 id="totalPelapor">0</h3>
                        <p>Total Pelapor</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
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
                        <h3 id="denganNIK">0</h3>
                        <p>Memiliki NIK</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-id-card"></i>
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
                    <i class="fas fa-table mr-2"></i>Data Pelapor
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="pelaporTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>NIK</th>
                                <th>Jenis Kelamin</th>
                                <th>Alamat</th>
                                <th>Telepon</th>
                                <th>Kode Jenis</th>
                                <th>Judul Kasus</th>
                                <th>Deskripsi</th>
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
                    <i class="fas fa-user mr-2"></i>Detail Pelapor
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
        let pelaporTable;

        // Initialize DataTable
        function initDataTable() {
            if (pelaporTable) {
                pelaporTable.destroy();
            }

            pelaporTable = $('#pelaporTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '<?= base_url('laporan-pelapor/get-data') ?>',
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
                        data: 'alamat',
                        name: 'alamat'
                    },
                    {
                        data: 'telepon',
                        name: 'telepon'
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
            $.get('<?= base_url('laporan-pelapor/statistics') ?>')
                .done(function(response) {
                    if (response.success) {
                        const stats = response.data;
                        $('#totalPelapor').text(stats.total);
                        $('#lakiLaki').text(stats.laki_laki);
                        $('#perempuan').text(stats.perempuan);
                        $('#denganNIK').text(stats.dengan_nik);
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

            $.get('<?= base_url('laporan-pelapor/detail') ?>/' + id)
                .done(function(response) {
                    if (response.success) {
                        const pelapor = response.data;
                        const relatedCases = response.related_cases || [];

                        let content = `
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="font-weight-bold" style="width: 120px;">Nama</td>
                                    <td>: ${pelapor.nama}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">NIK</td>
                                    <td>: ${pelapor.nik || '-'}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Jenis Kelamin</td>
                                    <td>: ${pelapor.jenis_kelamin.charAt(0).toUpperCase() + pelapor.jenis_kelamin.slice(1)}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="font-weight-bold" style="width: 120px;">Alamat</td>
                                    <td>: ${pelapor.alamat || '-'}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Telepon</td>
                                    <td>: ${pelapor.telepon || '-'}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Terdaftar</td>
                                    <td>: ${new Date(pelapor.created_at).toLocaleDateString('id-ID')}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                `;

                        if (relatedCases.length > 0) {
                            content += `
                        <hr>
                        <h6><i class="fas fa-folder mr-2"></i>Kasus Terkait (${relatedCases.length})</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="bg-light">
                                    <tr>
                                        <th>No. Kasus</th>
                                        <th>Judul</th>
                                        <th>Jenis</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;

                            relatedCases.forEach(kasus => {
                                const statusClass = {
                                    'dilaporkan': 'badge-warning',
                                    'dalam_proses': 'badge-info',
                                    'selesai': 'badge-success',
                                    'ditutup': 'badge-secondary'
                                } [kasus.status] || 'badge-light';

                                content += `
                            <tr>
                                <td>${kasus.nomor_kasus || '-'}</td>
                                <td>${kasus.judul_kasus}</td>
                                <td>${kasus.nama_jenis || '-'}</td>
                                <td><span class="badge ${statusClass}">${kasus.status.replace('_', ' ').toUpperCase()}</span></td>
                            </tr>
                        `;
                            });

                            content += `
                                </tbody>
                            </table>
                        </div>
                    `;
                        } else {
                            content += `
                        <hr>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            Belum ada kasus yang dilaporkan oleh pelapor ini.
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
                    Gagal memuat detail pelapor.
                </div>
            `);
                });
        };

        // Initialize
        initDataTable();
        loadStatistics();

        // Refresh button
        $('#btnRefresh').click(function() {
            pelaporTable.ajax.reload();
            loadStatistics();
        });

        // Print button
        $('#btnPrint').click(function() {
            window.open('<?= base_url('laporan-pelapor/print') ?>', '_blank');
        });
    });
</script>
<?= $this->endSection() ?>