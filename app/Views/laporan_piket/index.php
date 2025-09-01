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
        <!-- Date Filter Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-filter mr-2"></i>Filter Tanggal
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="start_date">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="start_date" value="<?= date('Y-m-d', strtotime('-30 days')) ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="end_date">Tanggal Akhir</label>
                            <input type="date" class="form-control" id="end_date" value="<?= date('Y-m-d') ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>&nbsp;</label><br>
                            <button type="button" id="btnFilter" class="btn btn-primary">
                                <i class="fas fa-search mr-1"></i> Filter
                            </button>
                            <button type="button" id="btnReset" class="btn btn-secondary">
                                <i class="fas fa-undo mr-1"></i> Reset
                            </button>
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
                        <i class="fas fa-shield-alt"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 id="selesai">0</h3>
                        <p>Selesai</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3 id="dijadwalkan">0</h3>
                        <p>Dijadwalkan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3 id="tidakHadir">0</h3>
                        <p>Tidak Hadir</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-times-circle"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shift Statistics Cards -->
        <div class="row mb-3">
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
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3 id="shiftPagi">0</h3>
                        <p>Shift Pagi</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-sun"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3 id="shiftSiang">0</h3>
                        <p>Shift Siang</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-cloud-sun"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-dark">
                    <div class="inner">
                        <h3 id="shiftMalam">0</h3>
                        <p>Shift Malam</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-moon"></i>
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
                    <i class="fas fa-table mr-2"></i>Data Piket
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="piketTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Shift</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Lokasi</th>
                                <th>Anggota</th>
                                <th>Jumlah</th>
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

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white" id="detailModalLabel">
                    <i class="fas fa-shield-alt mr-2"></i>Detail Piket
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
        let piketTable;

        // Initialize DataTable
        function initDataTable() {
            if (piketTable) {
                piketTable.destroy();
            }

            piketTable = $('#piketTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '<?= base_url('laporan-piket/get-data') ?>',
                    type: 'POST',
                    data: function(d) {
                        d.<?= csrf_token() ?> = '<?= csrf_hash() ?>';
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                    }
                },
                columns: [{
                        data: 'tanggal_piket',
                        name: 'tanggal_piket'
                    },
                    {
                        data: 'shift',
                        name: 'shift',
                        orderable: false
                    },
                    {
                        data: 'jam_mulai',
                        name: 'jam_mulai'
                    },
                    {
                        data: 'jam_selesai',
                        name: 'jam_selesai'
                    },
                    {
                        data: 'lokasi_piket',
                        name: 'lokasi_piket'
                    },
                    {
                        data: 'anggota_list',
                        name: 'anggota_list',
                        orderable: false
                    },
                    {
                        data: 'jumlah_anggota',
                        name: 'jumlah_anggota'
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
                    [0, 'desc']
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
            const startDate = $('#start_date').val();
            const endDate = $('#end_date').val();

            $.get('<?= base_url('laporan-piket/statistics') ?>', {
                    start_date: startDate,
                    end_date: endDate
                })
                .done(function(response) {
                    if (response.success) {
                        const stats = response.data;
                        $('#totalPiket').text(stats.total_piket);
                        $('#selesai').text(stats.selesai);
                        $('#dijadwalkan').text(stats.dijadwalkan);
                        $('#tidakHadir').text(stats.tidak_hadir);
                        $('#totalAnggota').text(stats.total_anggota);
                        $('#shiftPagi').text(stats.shift_pagi);
                        $('#shiftSiang').text(stats.shift_siang);
                        $('#shiftMalam').text(stats.shift_malam);
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

            $.get('<?= base_url('laporan-piket/detail') ?>/' + id)
                .done(function(response) {
                    if (response.success) {
                        const piket = response.data.piket;
                        const anggota = response.data.anggota;

                        // Status mapping
                        const statusClass = {
                            'dijadwalkan': 'badge-warning',
                            'selesai': 'badge-success',
                            'diganti': 'badge-info',
                            'tidak_hadir': 'badge-danger'
                        };

                        // Shift mapping
                        const shiftClass = {
                            'pagi': 'badge-info',
                            'siang': 'badge-warning',
                            'malam': 'badge-dark'
                        };

                        let content = `
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="fas fa-info-circle mr-2"></i>Informasi Piket</h6>
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td class="font-weight-bold" style="width: 140px;">Tanggal Piket</td>
                                    <td>: ${new Date(piket.tanggal_piket).toLocaleDateString('id-ID')}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Shift</td>
                                    <td>: <span class="badge ${shiftClass[piket.shift] || 'badge-secondary'}">${piket.shift.toUpperCase()}</span></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Jam Mulai</td>
                                    <td>: ${piket.jam_mulai.substring(0, 5)}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Jam Selesai</td>
                                    <td>: ${piket.jam_selesai.substring(0, 5)}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Lokasi Piket</td>
                                    <td>: ${piket.lokasi_piket || '-'}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Status</td>
                                    <td>: <span class="badge ${statusClass[piket.status] || 'badge-secondary'}">${piket.status.toUpperCase()}</span></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-clipboard mr-2"></i>Keterangan</h6>
                            <div class="alert alert-info">
                                ${piket.keterangan || 'Tidak ada keterangan khusus'}
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h6><i class="fas fa-users mr-2"></i>Daftar Anggota Piket (${anggota.length} orang)</h6>
                `;

                        if (anggota.length > 0) {
                            content += `
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>NRP</th>
                                        <th>Pangkat</th>
                                        <th>Jabatan</th>
                                        <th>Unit Kerja</th>
                                        <th>Kontak</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;

                            anggota.forEach((person, index) => {
                                content += `
                            <tr>
                                <td>${index + 1}</td>
                                <td><strong>${person.nama}</strong></td>
                                <td>${person.nrp || '-'}</td>
                                <td>${person.pangkat || '-'}</td>
                                <td>${person.jabatan || '-'}</td>
                                <td>${person.unit_kerja || '-'}</td>
                                <td>
                                    ${person.telepon ? '<i class="fas fa-phone"></i> ' + person.telepon + '<br>' : ''}
                                    ${person.email ? '<i class="fas fa-envelope"></i> ' + person.email : ''}
                                </td>
                                <td>${person.keterangan || '-'}</td>
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
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Belum ada anggota yang ditugaskan untuk piket ini.
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
                    Gagal memuat detail piket.
                </div>
            `);
                });
        };

        // Initialize
        initDataTable();
        loadStatistics();

        // Filter button
        $('#btnFilter').click(function() {
            piketTable.ajax.reload();
            loadStatistics();
        });

        // Reset button
        $('#btnReset').click(function() {
            $('#start_date').val('<?= date('Y-m-d', strtotime('-30 days')) ?>');
            $('#end_date').val('<?= date('Y-m-d') ?>');
            piketTable.ajax.reload();
            loadStatistics();
        });

        // Refresh button
        $('#btnRefresh').click(function() {
            piketTable.ajax.reload();
            loadStatistics();
        });

        // Print button
        $('#btnPrint').click(function() {
            const startDate = $('#start_date').val();
            const endDate = $('#end_date').val();
            window.open('<?= base_url('laporan-piket/print') ?>?start_date=' + startDate + '&end_date=' + endDate, '_blank');
        });
    });
</script>
<?= $this->endSection() ?>