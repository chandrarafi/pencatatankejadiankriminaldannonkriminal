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
                    <li class="breadcrumb-item"><a href="<?= base_url('laporan-piket') ?>">Laporan Piket</a></li>
                    <li class="breadcrumb-item active">Per Bulan</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <!-- Month/Year Filter Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-calendar-alt mr-2"></i>Filter Bulan & Tahun
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="month">Bulan</label>
                            <select class="form-control" id="month">
                                <option value="01" <?= date('m') == '01' ? 'selected' : '' ?>>Januari</option>
                                <option value="02" <?= date('m') == '02' ? 'selected' : '' ?>>Februari</option>
                                <option value="03" <?= date('m') == '03' ? 'selected' : '' ?>>Maret</option>
                                <option value="04" <?= date('m') == '04' ? 'selected' : '' ?>>April</option>
                                <option value="05" <?= date('m') == '05' ? 'selected' : '' ?>>Mei</option>
                                <option value="06" <?= date('m') == '06' ? 'selected' : '' ?>>Juni</option>
                                <option value="07" <?= date('m') == '07' ? 'selected' : '' ?>>Juli</option>
                                <option value="08" <?= date('m') == '08' ? 'selected' : '' ?>>Agustus</option>
                                <option value="09" <?= date('m') == '09' ? 'selected' : '' ?>>September</option>
                                <option value="10" <?= date('m') == '10' ? 'selected' : '' ?>>Oktober</option>
                                <option value="11" <?= date('m') == '11' ? 'selected' : '' ?>>November</option>
                                <option value="12" <?= date('m') == '12' ? 'selected' : '' ?>>Desember</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="year">Tahun</label>
                            <select class="form-control" id="year">
                                <?php for ($i = date('Y'); $i >= (date('Y') - 5); $i--): ?>
                                    <option value="<?= $i ?>" <?= date('Y') == $i ? 'selected' : '' ?>><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>&nbsp;</label><br>
                            <button type="button" id="btnFilter" class="btn btn-primary">
                                <i class="fas fa-search mr-1"></i> Filter
                            </button>
                            <button type="button" id="btnPrint" class="btn btn-success">
                                <i class="fas fa-print mr-1"></i> Cetak Laporan
                            </button>
                            <a href="<?= base_url('laporan-piket') ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Harian
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row" id="statisticsCards">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3 id="totalPiket">0</h3>
                        <p>Total Piket</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 id="totalSelesai">0</h3>
                        <p>Piket Selesai</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3 id="totalDijadwalkan">0</h3>
                        <p>Dijadwalkan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3 id="totalTidakHadir">0</h3>
                        <p>Tidak Hadir</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-times-circle"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Statistics -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3 id="totalDiganti">0</h3>
                        <p>Piket Diganti</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-primary">
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
                <div class="small-box bg-dark">
                    <div class="inner">
                        <h3 id="rataRataAnggota">0</h3>
                        <p>Rata-rata Anggota/Piket</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-light">
                    <div class="inner">
                        <h3 id="persentaseSelesai">0%</h3>
                        <p>Persentase Selesai</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-percentage"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-table mr-2"></i>Detail Laporan Piket Per Bulan
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle mr-2"></i>
                    <strong>Informasi:</strong> Laporan ini menampilkan detail piket per tanggal dalam bulan yang dipilih. 
                    Data diurutkan berdasarkan tanggal untuk memudahkan analisis.
                </div>
                <div class="table-responsive">
                    <table id="monthlyTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Total Piket</th>
                                <th>Dijadwalkan</th>
                                <th>Selesai</th>
                                <th>Diganti</th>
                                <th>Tidak Hadir</th>
                                <th>Total Anggota</th>
                                <th>Rata-rata Anggota</th>
                                <th>Persentase Selesai</th>
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
        let monthlyTable;

        // Initialize DataTable
        function initDataTable() {
            if (monthlyTable) {
                monthlyTable.destroy();
            }

            monthlyTable = $('#monthlyTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '<?= base_url('laporan-piket/monthly/get-data') ?>',
                    type: 'POST',
                    data: function(d) {
                        d.<?= csrf_token() ?> = '<?= csrf_hash() ?>';
                        d.month = $('#month').val();
                        d.year = $('#year').val();
                    },
                    dataSrc: function(json) {
                        // Update statistics cards
                        updateStatistics(json.data);
                        return json.data;
                    }
                },
                columns: [{
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'total_piket',
                        name: 'total_piket',
                        render: function(data) {
                            return '<span class="badge badge-info">' + data + '</span>';
                        }
                    },
                    {
                        data: 'dijadwalkan',
                        name: 'dijadwalkan',
                        render: function(data) {
                            return '<span class="badge badge-warning">' + data + '</span>';
                        }
                    },
                    {
                        data: 'selesai',
                        name: 'selesai',
                        render: function(data) {
                            return '<span class="badge badge-success">' + data + '</span>';
                        }
                    },
                    {
                        data: 'diganti',
                        name: 'diganti',
                        render: function(data) {
                            return '<span class="badge badge-secondary">' + data + '</span>';
                        }
                    },
                    {
                        data: 'tidak_hadir',
                        name: 'tidak_hadir',
                        render: function(data) {
                            return '<span class="badge badge-danger">' + data + '</span>';
                        }
                    },
                    {
                        data: 'total_anggota',
                        name: 'total_anggota',
                        render: function(data) {
                            return '<span class="badge badge-primary">' + data + '</span>';
                        }
                    },
                    {
                        data: null,
                        name: 'rata_rata_anggota',
                        render: function(data, type, row) {
                            const rataRata = row.total_piket > 0 ? (row.total_anggota / row.total_piket).toFixed(1) : 0;
                            return '<span class="badge badge-dark">' + rataRata + '</span>';
                        }
                    },
                    {
                        data: null,
                        name: 'persentase_selesai',
                        render: function(data, type, row) {
                            const persentase = row.total_piket > 0 ? ((row.selesai / row.total_piket) * 100).toFixed(1) : 0;
                            let badgeClass = 'badge-secondary';
                            if (persentase >= 80) badgeClass = 'badge-success';
                            else if (persentase >= 60) badgeClass = 'badge-warning';
                            else if (persentase >= 40) badgeClass = 'badge-info';
                            else badgeClass = 'badge-danger';
                            
                            return '<span class="badge ' + badgeClass + '">' + persentase + '%</span>';
                        }
                    }
                ],
                order: [
                    [0, 'asc']
                ],
                paging: false,
                searching: false,
                info: false,
                language: {
                    processing: "Memproses...",
                    zeroRecords: "Tidak ada data untuk bulan dan tahun yang dipilih",
                    emptyTable: "Tidak ada data piket"
                },
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();

                    // Calculate totals
                    var totalPiket = api.column(1).data().reduce(function(a, b) {
                        return parseInt(a) + parseInt(b);
                    }, 0);

                    var totalDijadwalkan = api.column(2).data().reduce(function(a, b) {
                        return parseInt(a) + parseInt(b);
                    }, 0);

                    var totalSelesai = api.column(3).data().reduce(function(a, b) {
                        return parseInt(a) + parseInt(b);
                    }, 0);

                    var totalDiganti = api.column(4).data().reduce(function(a, b) {
                        return parseInt(a) + parseInt(b);
                    }, 0);

                    var totalTidakHadir = api.column(5).data().reduce(function(a, b) {
                        return parseInt(a) + parseInt(b);
                    }, 0);

                    var totalAnggota = api.column(6).data().reduce(function(a, b) {
                        return parseInt(a) + parseInt(b);
                    }, 0);

                    var rataRataAnggota = totalPiket > 0 ? (totalAnggota / totalPiket).toFixed(1) : 0;
                    var persentaseSelesai = totalPiket > 0 ? ((totalSelesai / totalPiket) * 100).toFixed(1) : 0;

                    // Update footer
                    if (!$(api.table().footer()).find('tr').length) {
                        $(api.table().footer()).html(`
                        <tr>
                            <th><strong>TOTAL</strong></th>
                            <th><strong>${totalPiket}</strong></th>
                            <th><strong>${totalDijadwalkan}</strong></th>
                            <th><strong>${totalSelesai}</strong></th>
                            <th><strong>${totalDiganti}</strong></th>
                            <th><strong>${totalTidakHadir}</strong></th>
                            <th><strong>${totalAnggota}</strong></th>
                            <th><strong>${rataRataAnggota}</strong></th>
                            <th><strong>${persentaseSelesai}%</strong></th>
                        </tr>
                    `);
                    }
                }
            });
        }

        // Update statistics cards
        function updateStatistics(data) {
            let totalPiket = 0, totalSelesai = 0, totalDijadwalkan = 0, totalTidakHadir = 0;
            let totalDiganti = 0, totalAnggota = 0;

            data.forEach(function(row) {
                totalPiket += parseInt(row.total_piket);
                totalSelesai += parseInt(row.selesai);
                totalDijadwalkan += parseInt(row.dijadwalkan);
                totalTidakHadir += parseInt(row.tidak_hadir);
                totalDiganti += parseInt(row.diganti);
                totalAnggota += parseInt(row.total_anggota);
            });

            const rataRataAnggota = totalPiket > 0 ? (totalAnggota / totalPiket).toFixed(1) : 0;
            const persentaseSelesai = totalPiket > 0 ? ((totalSelesai / totalPiket) * 100).toFixed(1) : 0;

            $('#totalPiket').text(totalPiket);
            $('#totalSelesai').text(totalSelesai);
            $('#totalDijadwalkan').text(totalDijadwalkan);
            $('#totalTidakHadir').text(totalTidakHadir);
            $('#totalDiganti').text(totalDiganti);
            $('#totalAnggota').text(totalAnggota);
            $('#rataRataAnggota').text(rataRataAnggota);
            $('#persentaseSelesai').text(persentaseSelesai + '%');
        }

        // Initialize
        initDataTable();

        // Filter button
        $('#btnFilter').click(function() {
            monthlyTable.ajax.reload();
        });

        // Print button
        $('#btnPrint').click(function() {
            const month = $('#month').val();
            const year = $('#year').val();
            window.open('<?= base_url('laporan-piket/monthly/print') ?>?month=' + month + '&year=' + year, '_blank');
        });
    });
</script>
<?= $this->endSection() ?>
