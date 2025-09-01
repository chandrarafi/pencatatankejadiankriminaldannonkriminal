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
                    <i class="fas fa-filter mr-2"></i>Filter Laporan
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
                                <label for="tanggal_mulai">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_selesai">Tanggal Selesai</label>
                                <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai">
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

        <!-- Chart Card -->
        <div class="card" id="chartCard" style="display: none;">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-line mr-2"></i>Grafik Kasus
                </h3>
                <div class="card-tools">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-group="day">Harian</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary active" data-group="month">Bulanan</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-group="year">Tahunan</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <canvas id="kasusChart" style="height: 400px;"></canvas>
            </div>
        </div>

        <!-- Data Table Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-table mr-2"></i>Data Kasus
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function() {
        let kasusTable;
        let kasusChart;

        // Initialize DataTable
        function initDataTable() {
            if (kasusTable) {
                kasusTable.destroy();
            }

            kasusTable = $('#kasusTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '<?= base_url('laporan-kasus/get-data') ?>',
                    type: 'POST',
                    data: function(d) {
                        d.<?= csrf_token() ?> = '<?= csrf_hash() ?>';
                        d.tanggal_mulai = $('#tanggal_mulai').val();
                        d.tanggal_selesai = $('#tanggal_selesai').val();
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
                }
            });
        }

        // Initialize Chart
        function initChart() {
            const ctx = document.getElementById('kasusChart').getContext('2d');
            kasusChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Total Kasus',
                        data: [],
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        tension: 0.1
                    }, {
                        label: 'Dilaporkan',
                        data: [],
                        borderColor: 'rgb(255, 205, 86)',
                        backgroundColor: 'rgba(255, 205, 86, 0.2)',
                        tension: 0.1
                    }, {
                        label: 'Dalam Proses',
                        data: [],
                        borderColor: 'rgb(54, 162, 235)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        tension: 0.1
                    }, {
                        label: 'Selesai',
                        data: [],
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Load chart data
        function loadChartData(groupBy = 'month') {
            $.get('<?= base_url('laporan-kasus/statistics') ?>', {
                    tanggal_mulai: $('#tanggal_mulai').val(),
                    tanggal_selesai: $('#tanggal_selesai').val(),
                    group_by: groupBy
                })
                .done(function(response) {
                    if (response.success && response.data) {
                        const labels = response.data.map(item => item.label);
                        const totalData = response.data.map(item => item.total);
                        const dilaporkanData = response.data.map(item => item.dilaporkan);
                        const dalamProsesData = response.data.map(item => item.dalam_proses);
                        const selesaiData = response.data.map(item => item.selesai);

                        kasusChart.data.labels = labels;
                        kasusChart.data.datasets[0].data = totalData;
                        kasusChart.data.datasets[1].data = dilaporkanData;
                        kasusChart.data.datasets[2].data = dalamProsesData;
                        kasusChart.data.datasets[3].data = selesaiData;
                        kasusChart.update();

                        // Update statistics cards
                        const totals = response.data.reduce((acc, item) => {
                            acc.total += item.total;
                            acc.dilaporkan += item.dilaporkan;
                            acc.dalam_proses += item.dalam_proses;
                            acc.selesai += item.selesai;
                            return acc;
                        }, {
                            total: 0,
                            dilaporkan: 0,
                            dalam_proses: 0,
                            selesai: 0
                        });

                        $('#totalKasus').text(totals.total);
                        $('#kasusDilaporkan').text(totals.dilaporkan);
                        $('#kasusDalamProses').text(totals.dalam_proses);
                        $('#kasusSelesai').text(totals.selesai);
                        $('#statisticsCards').show();
                    }
                });
        }

        // Initialize
        initDataTable();
        initChart();

        // Filter button
        $('#btnFilter').click(function() {
            kasusTable.ajax.reload();
        });

        // Reset button
        $('#btnReset').click(function() {
            $('#filterForm')[0].reset();
            kasusTable.ajax.reload();
            $('#chartCard').hide();
            $('#statisticsCards').hide();
        });

        // Print button
        $('#btnPrint').click(function() {
            const params = new URLSearchParams({
                tanggal_mulai: $('#tanggal_mulai').val() || '',
                tanggal_selesai: $('#tanggal_selesai').val() || ''
            });

            window.open('<?= base_url('laporan-kasus/print') ?>?' + params.toString(), '_blank');
        });

        // Chart button
        $('#btnChart').click(function() {
            $('#chartCard').toggle();
            if ($('#chartCard').is(':visible')) {
                loadChartData($('.btn-group .active').data('group'));
            }
        });

        // Chart group buttons
        $('.btn-group button').click(function() {
            $('.btn-group button').removeClass('active');
            $(this).addClass('active');
            loadChartData($(this).data('group'));
        });
    });
</script>
<?= $this->endSection() ?>