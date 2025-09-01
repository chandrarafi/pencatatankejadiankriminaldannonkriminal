<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>


<section class="content">
    <div class="container-fluid">
        <!-- Filter Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-filter mr-2"></i>Filter Laporan Bulanan
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form id="filterForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bulan">Bulan</label>
                                <select class="form-control" id="bulan" name="bulan">
                                    <option value="">Semua Bulan</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tahun">Tahun</label>
                                <select class="form-control" id="tahun" name="tahun">
                                    <option value="">Pilih Tahun</option>
                                    <?php for ($year = date('Y'); $year >= 2020; $year--): ?>
                                        <option value="<?= $year ?>" <?= $year == date('Y') ? 'selected' : '' ?>><?= $year ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" id="btnFilter" class="btn btn-primary">
                                <i class="fas fa-search mr-1"></i> Filter
                            </button>
                            <button type="button" id="btnReset" class="btn btn-secondary">
                                <i class="fas fa-undo mr-1"></i> Reset
                            </button>
                            <button type="button" id="btnPrint" class="btn btn-success">
                                <i class="fas fa-print mr-1"></i> Cetak Laporan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row" id="statisticsCards" style="display: none;">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3 id="totalKasus">0</h3>
                        <p>Total Kasus</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-folder"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3 id="kasusDilaporkan">0</h3>
                        <p>Dilaporkan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3 id="kasusDalamProses">0</h3>
                        <p>Dalam Proses</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-cog"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 id="kasusSelesai">0</h3>
                        <p>Selesai</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-table mr-2"></i>Data Kasus Bulanan
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="kasusTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No. Kasus</th>
                                <th>Judul Kasus</th>
                                <th>Jenis Kasus</th>
                                <th>Pelapor</th>
                                <th>Tanggal Kejadian</th>
                                <th>Status</th>
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
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        let kasusTable;

        // Initialize DataTable
        function initDataTable() {
            if (kasusTable) {
                kasusTable.destroy();
            }

            kasusTable = $('#kasusTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '<?= base_url('laporan-kasus/monthly/get-data') ?>',
                    type: 'POST',
                    data: function(d) {
                        d.<?= csrf_token() ?> = '<?= csrf_hash() ?>';
                        d.bulan = $('#bulan').val();
                        d.tahun = $('#tahun').val();
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
                        data: 'jenis_kasus_nama',
                        name: 'jenis_kasus_nama'
                    },
                    {
                        data: 'pelapor_nama',
                        name: 'pelapor_nama'
                    },
                    {
                        data: 'tanggal_kejadian',
                        name: 'tanggal_kejadian',
                        orderable: true
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [4, 'desc']
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
                    updateStatistics();
                }
            });
        }

        // Update statistics cards
        function updateStatistics() {
            const info = kasusTable.page.info();
            if (info.recordsTotal > 0) {
                // Get current data
                const data = kasusTable.rows({
                    page: 'current'
                }).data();
                let stats = {
                    total: info.recordsTotal,
                    dilaporkan: 0,
                    dalam_proses: 0,
                    selesai: 0,
                    ditutup: 0
                };

                // Count status from all data (approximate)
                for (let i = 0; i < data.length; i++) {
                    const status = data[i].status;
                    if (status.includes('Dilaporkan')) stats.dilaporkan++;
                    else if (status.includes('Dalam Proses')) stats.dalam_proses++;
                    else if (status.includes('Selesai')) stats.selesai++;
                    else if (status.includes('Ditutup')) stats.ditutup++;
                }

                $('#totalKasus').text(stats.total);
                $('#kasusDilaporkan').text(stats.dilaporkan);
                $('#kasusDalamProses').text(stats.dalam_proses);
                $('#kasusSelesai').text(stats.selesai);
                $('#statisticsCards').show();
            } else {
                $('#statisticsCards').hide();
            }
        }

        // Initialize
        initDataTable();

        // Filter button
        $('#btnFilter').click(function() {
            kasusTable.ajax.reload();
        });

        // Reset button
        $('#btnReset').click(function() {
            $('#filterForm')[0].reset();
            $('#tahun').val(<?= date('Y') ?>); // Reset to current year
            kasusTable.ajax.reload();
            $('#statisticsCards').hide();
        });

        // Print button
        $('#btnPrint').click(function() {
            const params = new URLSearchParams({
                bulan: $('#bulan').val() || '',
                tahun: $('#tahun').val() || ''
            });

            window.open('<?= base_url('laporan-kasus/monthly/print') ?>?' + params.toString(), '_blank');
        });
    });
</script>
<?= $this->endSection() ?>