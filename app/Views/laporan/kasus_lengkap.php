<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?><?= $title ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Print Styles -->
<?php if ($isPrint): ?>
    <style>
        @media print {

            .content-wrapper,
            .main-sidebar,
            .main-header,
            .main-footer {
                margin: 0 !important;
                padding: 0 !important;
            }

            .btn,
            .card-tools,
            .breadcrumb,
            .no-print {
                display: none !important;
            }

            .card {
                box-shadow: none !important;
                border: 1px solid #000 !important;
            }

            .content-header {
                display: none !important;
            }

            body {
                font-size: 12px !important;
            }

            .card-header {
                background: #f8f9fa !important;
                border-bottom: 2px solid #000 !important;
            }
        }
    </style>
<?php endif; ?>

<!-- Header Section -->
<div class="row no-print">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-file-alt mr-2"></i>
                    Laporan Lengkap Kasus
                </h3>
                <div class="card-tools">
                    <div class="btn-group">
                        <a href="<?= base_url('laporan') ?>" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                        <button onclick="window.print()" class="btn btn-info btn-sm">
                            <i class="fas fa-print mr-1"></i> Print
                        </button>
                        <a href="<?= current_url() ?>?print=1" target="_blank" class="btn btn-success btn-sm">
                            <i class="fas fa-external-link-alt mr-1"></i> Print View
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Case Information -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="card-title text-white">
                    <i class="fas fa-folder-open mr-2"></i>
                    INFORMASI KASUS
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="30%" class="font-weight-bold">Nomor Kasus</td>
                                <td width="5%">:</td>
                                <td><?= $kasus['nomor_kasus'] ?></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Jenis Kasus</td>
                                <td>:</td>
                                <td><?= $kasus['jenis_kasus_nama'] ?? '-' ?></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Judul Kasus</td>
                                <td>:</td>
                                <td><?= $kasus['judul_kasus'] ?></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Status</td>
                                <td>:</td>
                                <td>
                                    <?php
                                    $statusClass = [
                                        'dilaporkan' => 'warning',
                                        'dalam_proses' => 'info',
                                        'selesai' => 'success',
                                        'ditutup' => 'secondary'
                                    ];
                                    $statusText = [
                                        'dilaporkan' => 'Dilaporkan',
                                        'dalam_proses' => 'Dalam Proses',
                                        'selesai' => 'Selesai',
                                        'ditutup' => 'Ditutup'
                                    ];
                                    $badgeClass = $statusClass[$kasus['status']] ?? 'secondary';
                                    $statusLabel = $statusText[$kasus['status']] ?? ucfirst($kasus['status']);
                                    ?>
                                    <span class="badge badge-<?= $badgeClass ?>"><?= $statusLabel ?></span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="30%" class="font-weight-bold">Tanggal Kejadian</td>
                                <td width="5%">:</td>
                                <td>
                                    <?php
                                    if ($kasus['tanggal_kejadian']) {
                                        $tanggal = date_create($kasus['tanggal_kejadian']);
                                        echo $tanggal ? $tanggal->format('d F Y, H:i') . ' WIB' : $kasus['tanggal_kejadian'];
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Lokasi Kejadian</td>
                                <td>:</td>
                                <td><?= $kasus['lokasi_kejadian'] ?: '-' ?></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Prioritas</td>
                                <td>:</td>
                                <td>
                                    <?php
                                    $prioritasClass = [
                                        'rendah' => 'secondary',
                                        'sedang' => 'warning',
                                        'tinggi' => 'danger'
                                    ];
                                    $prioritasText = [
                                        'rendah' => 'Rendah',
                                        'sedang' => 'Sedang',
                                        'tinggi' => 'Tinggi'
                                    ];
                                    $badgeClass = $prioritasClass[$kasus['prioritas']] ?? 'secondary';
                                    $prioritasLabel = $prioritasText[$kasus['prioritas']] ?? ucfirst($kasus['prioritas']);
                                    ?>
                                    <span class="badge badge-<?= $badgeClass ?>"><?= $prioritasLabel ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Dibuat</td>
                                <td>:</td>
                                <td><?= date('d F Y, H:i', strtotime($kasus['created_at'])) ?> WIB</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <h6 class="font-weight-bold">Deskripsi Kasus:</h6>
                        <div class="bg-light p-3 rounded">
                            <?= nl2br(htmlspecialchars($kasus['deskripsi'] ?? '-')) ?>
                        </div>
                    </div>
                </div>

                <?php if ($kasus['keterangan']): ?>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h6 class="font-weight-bold">Keterangan Update:</h6>
                            <div class="bg-info p-3 rounded text-white">
                                <?= nl2br(htmlspecialchars($kasus['keterangan'])) ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Reporter Information -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info">
                <h3 class="card-title text-white">
                    <i class="fas fa-user mr-2"></i>
                    INFORMASI PELAPOR
                </h3>
            </div>
            <div class="card-body">
                <?php if ($kasus['pelapor_nama']): ?>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="30%" class="font-weight-bold">Nama Lengkap</td>
                                    <td width="5%">:</td>
                                    <td><?= $kasus['pelapor_nama'] ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">NIK</td>
                                    <td>:</td>
                                    <td><?= $kasus['pelapor_nik'] ?: '-' ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Telepon</td>
                                    <td>:</td>
                                    <td><?= $kasus['pelapor_telepon'] ?: '-' ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="30%" class="font-weight-bold">Email</td>
                                    <td width="5%">:</td>
                                    <td><?= $kasus['pelapor_email'] ?: '-' ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Alamat</td>
                                    <td>:</td>
                                    <td><?= $kasus['pelapor_alamat'] ?: '-' ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Data pelapor tidak tersedia atau belum dilengkapi.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Victims Information -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-success">
                <h3 class="card-title text-white">
                    <i class="fas fa-user-injured mr-2"></i>
                    DATA KORBAN (<?= count($korbanList) ?>)
                </h3>
            </div>
            <div class="card-body">
                <?php if (count($korbanList) > 0): ?>
                    <div class="row">
                        <?php foreach ($korbanList as $index => $korban): ?>
                            <div class="col-md-6 mb-3">
                                <div class="card card-outline card-success">
                                    <div class="card-header">
                                        <h6 class="card-title">
                                            <i class="fas fa-user-injured mr-1"></i>
                                            Korban #<?= $index + 1 ?>
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-sm table-borderless">
                                            <tr>
                                                <td width="35%" class="font-weight-bold">Nama</td>
                                                <td width="5%">:</td>
                                                <td><?= $korban['nama'] ?></td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">NIK</td>
                                                <td>:</td>
                                                <td><?= $korban['nik'] ?: '-' ?></td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Jenis Kelamin</td>
                                                <td>:</td>
                                                <td><?= $korban['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Umur</td>
                                                <td>:</td>
                                                <td><?= $korban['umur'] ? $korban['umur'] . ' tahun' : '-' ?></td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Status Korban</td>
                                                <td>:</td>
                                                <td>
                                                    <?php
                                                    $statusClass = [
                                                        'hidup' => 'success',
                                                        'meninggal' => 'danger',
                                                        'luka' => 'warning',
                                                        'hilang' => 'dark'
                                                    ];
                                                    $statusText = [
                                                        'hidup' => 'Hidup',
                                                        'meninggal' => 'Meninggal',
                                                        'luka' => 'Luka',
                                                        'hilang' => 'Hilang'
                                                    ];
                                                    $badgeClass = $statusClass[$korban['status_korban']] ?? 'secondary';
                                                    $statusLabel = $statusText[$korban['status_korban']] ?? $korban['status_korban'];
                                                    ?>
                                                    <span class="badge badge-<?= $badgeClass ?>"><?= $statusLabel ?></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Alamat</td>
                                                <td>:</td>
                                                <td><?= $korban['alamat'] ?: '-' ?></td>
                                            </tr>
                                            <?php if ($korban['keterangan_luka']): ?>
                                                <tr>
                                                    <td class="font-weight-bold">Keterangan Luka</td>
                                                    <td>:</td>
                                                    <td><?= nl2br(htmlspecialchars($korban['keterangan_luka'])) ?></td>
                                                </tr>
                                            <?php endif; ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Belum ada data korban untuk kasus ini.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Suspects Information -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-warning">
                <h3 class="card-title">
                    <i class="fas fa-user-secret mr-2"></i>
                    DATA TERSANGKA (<?= count($tersangkaList) ?>)
                </h3>
            </div>
            <div class="card-body">
                <?php if (count($tersangkaList) > 0): ?>
                    <div class="row">
                        <?php foreach ($tersangkaList as $index => $tersangka): ?>
                            <div class="col-md-6 mb-3">
                                <div class="card card-outline card-warning">
                                    <div class="card-header">
                                        <h6 class="card-title">
                                            <i class="fas fa-user-secret mr-1"></i>
                                            Tersangka #<?= $index + 1 ?>
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-sm table-borderless">
                                            <tr>
                                                <td width="35%" class="font-weight-bold">Nama</td>
                                                <td width="5%">:</td>
                                                <td><?= $tersangka['nama'] ?></td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">NIK</td>
                                                <td>:</td>
                                                <td><?= $tersangka['nik'] ?: '-' ?></td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Jenis Kelamin</td>
                                                <td>:</td>
                                                <td><?= $tersangka['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Umur</td>
                                                <td>:</td>
                                                <td><?= $tersangka['umur'] ? $tersangka['umur'] . ' tahun' : '-' ?></td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Status Tersangka</td>
                                                <td>:</td>
                                                <td>
                                                    <?php
                                                    $statusClass = [
                                                        'ditangkap' => 'warning',
                                                        'ditahan' => 'danger',
                                                        'buron' => 'dark',
                                                        'diserahkan' => 'success'
                                                    ];
                                                    $statusText = [
                                                        'ditangkap' => 'Ditangkap',
                                                        'ditahan' => 'Ditahan',
                                                        'buron' => 'Buron',
                                                        'diserahkan' => 'Diserahkan'
                                                    ];
                                                    $badgeClass = $statusClass[$tersangka['status_tersangka']] ?? 'secondary';
                                                    $statusLabel = $statusText[$tersangka['status_tersangka']] ?? $tersangka['status_tersangka'];
                                                    ?>
                                                    <span class="badge badge-<?= $badgeClass ?>"><?= $statusLabel ?></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Alamat</td>
                                                <td>:</td>
                                                <td><?= $tersangka['alamat'] ?: '-' ?></td>
                                            </tr>
                                            <?php if ($tersangka['pasal_yang_disangkakan']): ?>
                                                <tr>
                                                    <td class="font-weight-bold">Pasal Disangkakan</td>
                                                    <td>:</td>
                                                    <td><?= htmlspecialchars($tersangka['pasal_yang_disangkakan']) ?></td>
                                                </tr>
                                            <?php endif; ?>
                                            <?php if ($tersangka['barang_bukti']): ?>
                                                <tr>
                                                    <td class="font-weight-bold">Barang Bukti</td>
                                                    <td>:</td>
                                                    <td><?= nl2br(htmlspecialchars($tersangka['barang_bukti'])) ?></td>
                                                </tr>
                                            <?php endif; ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Belum ada data tersangka untuk kasus ini.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Witnesses Information -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-secondary">
                <h3 class="card-title text-white">
                    <i class="fas fa-user-friends mr-2"></i>
                    DATA SAKSI (<?= count($saksiList) ?>)
                </h3>
            </div>
            <div class="card-body">
                <?php if (count($saksiList) > 0): ?>
                    <div class="row">
                        <?php foreach ($saksiList as $index => $saksi): ?>
                            <div class="col-md-6 mb-3">
                                <div class="card card-outline card-secondary">
                                    <div class="card-header">
                                        <h6 class="card-title">
                                            <i class="fas fa-user-friends mr-1"></i>
                                            Saksi #<?= $index + 1 ?>
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-sm table-borderless">
                                            <tr>
                                                <td width="35%" class="font-weight-bold">Nama</td>
                                                <td width="5%">:</td>
                                                <td><?= $saksi['nama'] ?></td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">NIK</td>
                                                <td>:</td>
                                                <td><?= $saksi['nik'] ?: '-' ?></td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Jenis Kelamin</td>
                                                <td>:</td>
                                                <td><?= $saksi['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Umur</td>
                                                <td>:</td>
                                                <td><?= $saksi['umur'] ? $saksi['umur'] . ' tahun' : '-' ?></td>
                                            </tr>
                                            <?php if ($saksi['jenis_saksi']): ?>
                                                <tr>
                                                    <td class="font-weight-bold">Jenis Saksi</td>
                                                    <td>:</td>
                                                    <td><span class="badge badge-info"><?= $saksi['jenis_saksi'] ?></span></td>
                                                </tr>
                                            <?php endif; ?>
                                            <tr>
                                                <td class="font-weight-bold">Dapat Dihubungi</td>
                                                <td>:</td>
                                                <td>
                                                    <?php if ($saksi['dapat_dihubungi']): ?>
                                                        <span class="badge badge-success">Ya</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-secondary">Tidak</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Alamat</td>
                                                <td>:</td>
                                                <td><?= $saksi['alamat'] ?: '-' ?></td>
                                            </tr>
                                            <?php if ($saksi['keterangan_kesaksian']): ?>
                                                <tr>
                                                    <td class="font-weight-bold">Kesaksian</td>
                                                    <td>:</td>
                                                    <td><?= nl2br(htmlspecialchars($saksi['keterangan_kesaksian'])) ?></td>
                                                </tr>
                                            <?php endif; ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Belum ada data saksi untuk kasus ini.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Summary Statistics -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-dark">
                <h3 class="card-title text-white">
                    <i class="fas fa-chart-pie mr-2"></i>
                    RINGKASAN KASUS
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-info">
                                <i class="fas fa-user"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Pelapor</span>
                                <span class="info-box-number">1</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-success">
                                <i class="fas fa-user-injured"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Korban</span>
                                <span class="info-box-number"><?= count($korbanList) ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning">
                                <i class="fas fa-user-secret"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Tersangka</span>
                                <span class="info-box-number"><?= count($tersangkaList) ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-secondary">
                                <i class="fas fa-user-friends"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Saksi</span>
                                <span class="info-box-number"><?= count($saksiList) ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="alert alert-info">
                            <h6><i class="fas fa-info-circle mr-2"></i>Informasi Laporan</h6>
                            <ul class="mb-0">
                                <li><strong>Total Pihak Terkait:</strong> <?= 1 + count($korbanList) + count($tersangkaList) + count($saksiList) ?> orang</li>
                                <li><strong>Status Investigasi:</strong> <?= $statusLabel ?></li>
                                <li><strong>Tanggal Laporan:</strong> <?= date('d F Y, H:i') ?> WIB</li>
                                <li><strong>Digenerate oleh:</strong> <?= $user['nama'] ?? 'Sistem' ?> (<?= strtoupper($role) ?>)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Check if this is print view
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('print') === '1') {
            // Auto print for print view
            setTimeout(function() {
                window.print();
            }, 1000);
        }
    });
</script>
<?= $this->endSection() ?>