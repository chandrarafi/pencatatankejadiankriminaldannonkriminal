<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<!-- Info boxes -->
<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1">
                <i class="fas fa-folder-open"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Total Kasus</span>
                <span class="info-box-number">
                    <?= $stats['total_kasus'] ?>
                    <small>Kasus</small>
                </span>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1">
                <i class="fas fa-users"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Total Pelapor</span>
                <span class="info-box-number">
                    <?= $stats['total_pelapor'] ?>
                    <small>Orang</small>
                </span>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1">
                <i class="fas fa-list"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Jenis Kasus</span>
                <span class="info-box-number">
                    <?= $stats['total_jenis_kasus'] ?>
                    <small>Jenis</small>
                </span>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1">
                <i class="fas fa-clock"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Piket Hari Ini</span>
                <span class="info-box-number">
                    <?= $stats['piket_hari_ini'] ?>
                    <small>Orang</small>
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-lg-7 connectedSortable">
        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-bolt mr-1"></i>
                    Aksi Cepat
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <a href="#" class="btn btn-app bg-success">
                            <i class="fas fa-plus"></i> Tambah Kasus Baru
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="#" class="btn btn-app bg-info">
                            <i class="fas fa-user-plus"></i> Tambah Pelapor
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="#" class="btn btn-app bg-warning">
                            <i class="fas fa-list-ul"></i> Kelola Jenis Kasus
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="#" class="btn btn-app bg-primary">
                            <i class="fas fa-eye"></i> Lihat Piket
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Cases -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-folder mr-1"></i>
                    Kasus Terbaru
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No. Kasus</th>
                                <th>Jenis</th>
                                <th>Pelapor</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                    Belum ada data kasus
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Right col -->
    <section class="col-lg-5 connectedSortable">
        <!-- Calendar -->
        <div class="card bg-gradient-primary">
            <div class="card-header border-0">
                <h3 class="card-title">
                    <i class="far fa-calendar-alt"></i>
                    Kalender
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body pt-0">
                <div id="calendar" style="width: 100%"></div>
            </div>
        </div>

        <!-- TO DO List -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="ion ion-clipboard mr-1"></i>
                    Tugas Hari Ini
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <ul class="todo-list" data-widget="todo-list">
                    <li>
                        <span class="handle">
                            <i class="fas fa-ellipsis-v"></i>
                            <i class="fas fa-ellipsis-v"></i>
                        </span>
                        <div class="icheck-primary d-inline ml-2">
                            <input type="checkbox" value="" name="todo1" id="todoCheck1">
                            <label for="todoCheck1"></label>
                        </div>
                        <span class="text">Verifikasi laporan masuk</span>
                        <small class="badge badge-warning"><i class="far fa-clock"></i> Menunggu</small>
                    </li>
                    <li>
                        <span class="handle">
                            <i class="fas fa-ellipsis-v"></i>
                            <i class="fas fa-ellipsis-v"></i>
                        </span>
                        <div class="icheck-primary d-inline ml-2">
                            <input type="checkbox" value="" name="todo2" id="todoCheck2">
                            <label for="todoCheck2"></label>
                        </div>
                        <span class="text">Update data pelapor</span>
                        <small class="badge badge-info"><i class="far fa-clock"></i> Proses</small>
                    </li>
                    <li>
                        <span class="handle">
                            <i class="fas fa-ellipsis-v"></i>
                            <i class="fas fa-ellipsis-v"></i>
                        </span>
                        <div class="icheck-primary d-inline ml-2">
                            <input type="checkbox" value="" name="todo3" id="todoCheck3" checked>
                            <label for="todoCheck3"></label>
                        </div>
                        <span class="text">Review jenis kasus baru</span>
                        <small class="badge badge-success"><i class="far fa-clock"></i> Selesai</small>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Statistik Piket -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-clock mr-1"></i>
                    Jadwal Piket Minggu Ini
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="progress-group">
                    Senin
                    <span class="float-right"><b>2</b>/3</span>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-primary" style="width: 67%"></div>
                    </div>
                </div>
                <div class="progress-group">
                    Selasa
                    <span class="float-right"><b>3</b>/3</span>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-success" style="width: 100%"></div>
                    </div>
                </div>
                <div class="progress-group">
                    Rabu
                    <span class="float-right"><b>1</b>/3</span>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-warning" style="width: 33%"></div>
                    </div>
                </div>
                <div class="progress-group">
                    Kamis
                    <span class="float-right"><b>0</b>/3</span>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-danger" style="width: 0%"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Initialize any dashboard-specific scripts here
        console.log('SPKT Dashboard loaded');

        // Example: Handle quick action clicks
        $('.btn-app').on('click', function(e) {
            e.preventDefault();

            Swal.fire({
                icon: 'info',
                title: 'Fitur Akan Segera Tersedia',
                text: 'Fitur ini sedang dalam tahap pengembangan.',
                confirmButtonColor: '#007bff'
            });
        });
    });
</script>
<?= $this->endSection() ?>

