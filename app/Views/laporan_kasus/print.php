<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kasus Per Tanggal - Polsek Lunang Silaut</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }

        .container {
            max-width: 210mm;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #000;
            padding-bottom: 20px;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
        }

        .logo {
            width: 80px;
            height: 80px;
        }

        .header-text {
            text-align: center;
        }

        .header-text h1 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .header-text h2 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .header-text p {
            font-size: 12px;
            margin-bottom: 2px;
        }

        .report-title {
            text-align: center;
            margin: 30px 0;
        }

        .report-title h3 {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            margin-bottom: 10px;
        }

        .report-info {
            margin-bottom: 30px;
        }

        .report-info table {
            width: 100%;
            border-collapse: collapse;
        }

        .report-info td {
            padding: 5px;
            vertical-align: top;
        }

        .report-info .label {
            width: 150px;
            font-weight: bold;
        }

        .statistics {
            margin-bottom: 30px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }

        .stat-card {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: center;
            border-radius: 5px;
        }

        .stat-card .number {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 5px;
        }

        .stat-card .label {
            font-size: 11px;
            color: #666;
            text-transform: uppercase;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        .data-table th {
            background-color: #f5f5f5;
            font-weight: bold;
            text-align: center;
        }

        .data-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-dilaporkan {
            background-color: #ffc107;
            color: #000;
        }

        .status-dalam-proses {
            background-color: #17a2b8;
            color: #fff;
        }

        .status-selesai {
            background-color: #28a745;
            color: #fff;
        }

        .status-ditutup {
            background-color: #6c757d;
            color: #fff;
        }

        .footer {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }

        .signature {
            text-align: center;
            width: 200px;
        }

        .signature-line {
            border-top: 1px solid #000;
            margin-top: 80px;
            padding-top: 5px;
        }

        .no-data {
            text-align: center;
            padding: 50px;
            color: #666;
            font-style: italic;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .container {
                max-width: none;
                margin: 0;
                padding: 15px;
            }

            .header {
                page-break-inside: avoid;
            }

            .data-table {
                page-break-inside: avoid;
            }

            .data-table thead {
                display: table-header-group;
            }

            .footer {
                page-break-inside: avoid;
            }
        }

        .summary-section {
            margin-bottom: 30px;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
        }

        .summary-section h4 {
            margin-bottom: 15px;
            color: #333;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }

        .summary-list {
            list-style: none;
            padding: 0;
        }

        .summary-list li {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            border-bottom: 1px dotted #ccc;
        }

        .summary-list li:last-child {
            border-bottom: none;
            font-weight: bold;
            border-top: 1px solid #333;
            padding-top: 10px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-content">
                <img src="<?= base_url('image/logo.png') ?>" alt="Logo Polri" class="logo">
                <div class="header-text">
                    <h1>Kepolisian Negara Republik Indonesia</h1>
                    <h2>Polsek Lunang Silaut</h2>
                    <p>Jl. Raya Lunang Silaut, Kab. Pesisir Selatan, Sumatera Barat</p>
                    <p>Telp: (0756) 123456 | Email: polseklunangsilaut@polri.go.id</p>
                </div>
            </div>
        </div>

        <!-- Report Title -->
        <div class="report-title">
            <h3>Laporan Kasus Per Tanggal</h3>
        </div>

        <!-- Report Information -->
        <div class="report-info">
            <table>
                <tr>
                    <td class="label">Periode Laporan</td>
                    <td>:
                        <?php if ($tanggalMulai && $tanggalSelesai): ?>
                            <?= date('d F Y', strtotime($tanggalMulai)) ?> s/d <?= date('d F Y', strtotime($tanggalSelesai)) ?>
                        <?php elseif ($tanggalMulai): ?>
                            Mulai <?= date('d F Y', strtotime($tanggalMulai)) ?>
                        <?php elseif ($tanggalSelesai): ?>
                            Sampai <?= date('d F Y', strtotime($tanggalSelesai)) ?>
                        <?php else: ?>
                            Semua Periode
                        <?php endif; ?>
                    </td>
                </tr>

                <tr>
                    <td class="label">Tanggal Cetak</td>
                    <td>: <?= date('d F Y H:i:s') ?></td>
                </tr>
                <tr>
                    <td class="label">Dicetak Oleh</td>
                    <td>: <?= $user['nama'] ?? 'System' ?> (<?= strtoupper($role) ?>)</td>
                </tr>
            </table>
        </div>





        <!-- Data Table -->
        <?php if (!empty($kasusData)): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">No.</th>
                        <th style="width: 15%;">No. Kasus</th>
                        <th style="width: 25%;">Judul Kasus</th>
                        <th style="width: 15%;">Jenis Kasus</th>
                        <th style="width: 15%;">Pelapor</th>
                        <th style="width: 12%;">Tanggal Kejadian</th>
                        <th style="width: 13%;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($kasusData as $index => $kasus): ?>
                        <tr>
                            <td style="text-align: center;"><?= $index + 1 ?></td>
                            <td><?= $kasus['nomor_kasus'] ?: '-' ?></td>
                            <td><?= $kasus['judul_kasus'] ?></td>
                            <td><?= $kasus['jenis_kasus_nama'] ?: '-' ?></td>
                            <td><?= $kasus['pelapor_nama'] ?: '-' ?></td>
                            <td style="text-align: center;"><?= date('d/m/Y', strtotime($kasus['tanggal_kejadian'])) ?></td>
                            <td style="text-align: center;">
                                <span class="status-badge status-<?= $kasus['status'] ?>">
                                    <?= ucfirst(str_replace('_', ' ', $kasus['status'])) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-data">
                <h4>Tidak ada data kasus yang ditemukan sesuai kriteria filter yang dipilih.</h4>
                <p>Silakan ubah filter pencarian untuk melihat data kasus lainnya.</p>
            </div>
        <?php endif; ?>

        <!-- Footer -->
        <div class="footer">
            <div class="signature">
                <p>Mengetahui,</p>
                <p><strong>KAPOLSEK LUNANG SILAUT</strong></p>
                <div class="signature-line">
                    <p><strong>KOMPOL AHMAD FAUZI, S.H.</strong></p>
                    <p>NRP. 12345678</p>
                </div>
            </div>
            <div class="signature">
                <p>Dibuat Oleh,</p>
                <p><strong><?= strtoupper($role) ?></strong></p>
                <div class="signature-line">
                    <p><strong><?= strtoupper($user['nama'] ?? 'SISTEM') ?></strong></p>
                    <p>NRP. <?= $user['nrp'] ?? '-' ?></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto print when page loads
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>