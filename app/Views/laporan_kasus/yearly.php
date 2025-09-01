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
                    <i class="fas fa-filter mr-2"></i>Filter Laporan Tahunan
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
                                <label for="tahun">Tahun</label>
                                <select class="form-control" id="tahun" name="tahun" required>
                                    <option value="">Pilih Tahun</option>
                                    <?php for ($year = date('Y'); $year >= 2020; $year--): ?>
                                        <option value="<?= $year ?>" <?= $year == date('Y') ? 'selected' : '' ?>><?= $year ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <div class="d-block">
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



        <!-- Monthly Summary Table -->
        <div class="card" id="summaryCard" style="display: none;">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-table mr-2"></i>Ringkasan Per Bulan
                </h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="summaryTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Bulan</th>
                                <th>Total Kasus</th>
                                <th>Dilaporkan</th>
                                <th>Dalam Proses</th>
                                <th>Selesai</th>
                                <th>Ditutup</th>
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
        // Load yearly data
        function loadYearlyData() {
            const tahun = $('#tahun').val();
            if (!tahun) {
                alert('Silakan pilih tahun terlebih dahulu');
                return;
            }

            $.get('<?= base_url('laporan-kasus/yearly/get-data') ?>', {
                    tahun: tahun
                })
                .done(function(response) {
                    if (response.success && response.data) {
                        const data = response.data;

                        // Update summary table
                        const tbody = $('#summaryTable tbody');
                        tbody.empty();

                        let totalOverall = 0;
                        let totalDilaporkan = 0;
                        let totalDalamProses = 0;
                        let totalSelesai = 0;
                        let totalDitutup = 0;

                        data.forEach(function(item) {
                            totalOverall += item.total;
                            totalDilaporkan += item.dilaporkan;
                            totalDalamProses += item.dalam_proses;
                            totalSelesai += item.selesai;
                            totalDitutup += item.ditutup;

                            tbody.append(`
                        <tr>
                            <td>${item.bulan}</td>
                            <td class="text-center">${item.total}</td>
                            <td class="text-center">${item.dilaporkan}</td>
                            <td class="text-center">${item.dalam_proses}</td>
                            <td class="text-center">${item.selesai}</td>
                            <td class="text-center">${item.ditutup}</td>
                        </tr>
                    `);
                        });

                        // Add total row
                        tbody.append(`
                    <tr class="bg-light font-weight-bold">
                        <td>TOTAL</td>
                        <td class="text-center">${totalOverall}</td>
                        <td class="text-center">${totalDilaporkan}</td>
                        <td class="text-center">${totalDalamProses}</td>
                        <td class="text-center">${totalSelesai}</td>
                        <td class="text-center">${totalDitutup}</td>
                    </tr>
                `);

                        // Update statistics cards
                        $('#totalKasus').text(totalOverall);
                        $('#kasusDilaporkan').text(totalDilaporkan);
                        $('#kasusDalamProses').text(totalDalamProses);
                        $('#kasusSelesai').text(totalSelesai);

                        // Show cards
                        $('#statisticsCards').show();
                        $('#summaryCard').show();
                    }
                })
                .fail(function() {
                    alert('Gagal memuat data. Silakan coba lagi.');
                });
        }

        // Filter button
        $('#btnFilter').click(function() {
            loadYearlyData();
        });

        // Reset button
        $('#btnReset').click(function() {
            $('#filterForm')[0].reset();
            $('#tahun').val(<?= date('Y') ?>); // Reset to current year
            $('#statisticsCards').hide();
            $('#summaryCard').hide();
        });

        // Print button
        $('#btnPrint').click(function() {
            const tahun = $('#tahun').val();
            if (!tahun) {
                alert('Silakan pilih tahun terlebih dahulu');
                return;
            }

            const params = new URLSearchParams({
                tahun: tahun
            });

            window.open('<?= base_url('laporan-kasus/yearly/print') ?>?' + params.toString(), '_blank');
        });

        // Auto load current year data
        loadYearlyData();
    });
</script>
<?= $this->endSection() ?>