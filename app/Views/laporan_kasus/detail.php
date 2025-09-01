<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>


<section class="content">
    <div class="container-fluid">
        <!-- Action Buttons -->
        <div class="row mb-3 no-print">
            <div class="col-12">
                <a href="<?= base_url('laporan-kasus') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
                <a href="<?= base_url('laporan-kasus/print-detail/' . $kasus['id']) ?>" target="_blank" class="btn btn-success">
                    <i class="fas fa-print mr-1"></i> Cetak Detail
                </a>
            </div>
        </div>

        <!-- Print Header (only visible when printing) -->
        <div class="print-header">
            <div class="text-center mb-4">
                <h2>KEPOLISIAN NEGARA REPUBLIK INDONESIA</h2>
                <h3>POLSEK LUNANG SILAUT</h3>
                <p>Jl. Raya Lunang Silaut, Kab. Pesisir Selatan, Sumatera Barat</p>
                <hr style="border-top: 2px solid #000; margin: 20px 0;">
                <h4 style="text-decoration: underline;">DETAIL KASUS</h4>
            </div>
        </div>

        <!-- Case Information Card -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title">
                    <i class="fas fa-folder-open mr-2"></i>Informasi Detail Kasus
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Case Info -->
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td class="font-weight-bold" style="width: 150px;">Nomor Kasus</td>
                                <td>: <?= $kasus['nomor_kasus'] ?: '-' ?></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Jenis Kasus</td>
                                <td>: <?= $kasus['jenis_kasus_nama'] ?: '-' ?></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Judul Kasus</td>
                                <td>: <?= $kasus['judul_kasus'] ?></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Tanggal Kejadian</td>
                                <td>: <?= date('d F Y', strtotime($kasus['tanggal_kejadian'])) ?></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Waktu Kejadian</td>
                                <td>: <?= date('H:i', strtotime($kasus['tanggal_kejadian'])) ?> WIB</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Status & Priority -->
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td class="font-weight-bold" style="width: 150px;">Lokasi Kejadian</td>
                                <td>: <?= $kasus['lokasi_kejadian'] ?: '-' ?></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Status</td>
                                <td>:
                                    <?php
                                    $statusClass = match ($kasus['status']) {
                                        'dilaporkan' => 'badge-warning',
                                        'dalam_proses' => 'badge-info',
                                        'selesai' => 'badge-success',
                                        'ditutup' => 'badge-secondary',
                                        default => 'badge-light'
                                    };
                                    ?>
                                    <span class="badge <?= $statusClass ?>"><?= ucfirst(str_replace('_', ' ', $kasus['status'])) ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Prioritas</td>
                                <td>:
                                    <?php
                                    $prioritasClass = match ($kasus['prioritas']) {
                                        'tinggi' => 'badge-danger',
                                        'sedang' => 'badge-warning',
                                        'rendah' => 'badge-success',
                                        default => 'badge-secondary'
                                    };
                                    ?>
                                    <span class="badge <?= $prioritasClass ?>"><?= ucfirst($kasus['prioritas'] ?: 'Tidak Ditentukan') ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Dibuat</td>
                                <td>: <?= date('d F Y H:i', strtotime($kasus['created_at'])) ?> WIB</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Diperbarui</td>
                                <td>: <?= date('d F Y H:i', strtotime($kasus['updated_at'])) ?> WIB</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Case Description -->
        <div class="card">
            <div class="card-header bg-info text-white">
                <h3 class="card-title">
                    <i class="fas fa-file-alt mr-2"></i>Deskripsi Kasus
                </h3>
            </div>
            <div class="card-body">
                <div class="alert alert-light">
                    <p class="mb-0" style="line-height: 1.8; text-align: justify;">
                        <?= nl2br(htmlspecialchars($kasus['deskripsi'] ?: 'Tidak ada deskripsi')) ?>
                    </p>
                </div>
                <?php if (!empty($kasus['keterangan'])): ?>
                    <div class="mt-3">
                        <h5><i class="fas fa-sticky-note mr-2"></i>Keterangan Tambahan:</h5>
                        <div class="alert alert-warning">
                            <p class="mb-0" style="line-height: 1.8;">
                                <?= nl2br(htmlspecialchars($kasus['keterangan'])) ?>
                            </p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Reporter Information -->
        <?php if (!empty($kasus['pelapor_nama'])): ?>
            <div class="card">
                <div class="card-header bg-teal text-white">
                    <h3 class="card-title">
                        <i class="fas fa-user mr-2"></i>Informasi Pelapor
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="font-weight-bold" style="width: 120px;">Nama</td>
                                    <td>: <?= $kasus['pelapor_nama'] ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Telepon</td>
                                    <td>: <?= $kasus['pelapor_telepon'] ?: '-' ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="font-weight-bold" style="width: 120px;">Alamat</td>
                                    <td>: <?= $kasus['pelapor_alamat'] ?: '-' ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    @media print {

        /* Hide unwanted elements */
        body * {
            visibility: hidden;
        }

        .content,
        .content * {
            visibility: visible;
        }

        .no-print {
            display: none !important;
        }

        .print-header {
            visibility: visible !important;
            display: block !important;
        }

        /* Reset layout for print */
        .content {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            background: white;
            color: black;
            font-size: 12px;
            line-height: 1.4;
            padding: 20px;
        }

        .container-fluid {
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .card {
            border: 1px solid #000 !important;
            margin-bottom: 15px !important;
            page-break-inside: avoid;
            background: white !important;
            box-shadow: none !important;
        }

        .card-header {
            background: #f5f5f5 !important;
            color: #000 !important;
            border-bottom: 1px solid #000 !important;
            padding: 8px 12px !important;
            font-weight: bold !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .card-body {
            padding: 12px !important;
            background: white !important;
        }

        .table {
            width: 100% !important;
            font-size: 11px !important;
            margin-bottom: 0 !important;
        }

        .table td {
            padding: 4px 6px !important;
            border: none !important;
            vertical-align: top !important;
        }

        .font-weight-bold {
            font-weight: bold !important;
        }

        .badge {
            border: 1px solid #000 !important;
            color: #000 !important;
            background: white !important;
            padding: 2px 4px !important;
            font-size: 9px !important;
        }

        .alert {
            border: 1px solid #ccc !important;
            background: #f9f9f9 !important;
            padding: 10px !important;
            margin: 10px 0 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            color: #000 !important;
            font-weight: bold !important;
            margin: 5px 0 !important;
        }

        .row {
            width: 100% !important;
            margin: 0 !important;
        }

        .col-md-6 {
            width: 48% !important;
            float: left !important;
            margin-right: 2% !important;
        }

        .col-md-6:nth-child(2n) {
            margin-right: 0 !important;
        }

        .row::after {
            content: "";
            display: table;
            clear: both;
        }
    }

    @media screen {
        .print-header {
            display: none !important;
        }
    }

    .bg-teal {
        background-color: #17a2b8 !important;
    }
</style>
<?= $this->endSection() ?>