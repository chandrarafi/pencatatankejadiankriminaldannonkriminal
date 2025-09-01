<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Piket Per Tanggal - Polsek Lunang Silaut</title>
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

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
            vertical-align: top;
            font-size: 11px;
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
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            color: white;
        }

        .status-dijadwalkan {
            background-color: #ffc107;
            color: #212529;
        }

        .status-selesai {
            background-color: #28a745;
        }

        .status-diganti {
            background-color: #17a2b8;
        }

        .status-tidak_hadir {
            background-color: #dc3545;
        }

        .shift-badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            color: white;
        }

        .shift-pagi {
            background-color: #17a2b8;
        }

        .shift-siang {
            background-color: #ffc107;
            color: #212529;
        }

        .shift-malam {
            background-color: #343a40;
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

        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin: 20px 0 10px 0;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
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
            <h3>Laporan Piket Per Tanggal</h3>
        </div>

        <!-- Report Information -->
        <div class="report-info">
            <table>
                <tr>
                    <td class="label">Periode Laporan</td>
                    <td>: <?= date('d F Y', strtotime($startDate)) ?> - <?= date('d F Y', strtotime($endDate)) ?></td>
                </tr>
                <tr>
                    <td class="label">Total Piket</td>
                    <td>: <?= $stats['total_piket'] ?> piket</td>
                </tr>
                <tr>
                    <td class="label">Total Anggota</td>
                    <td>: <?= $stats['total_anggota'] ?> orang</td>
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
        <?php if (!empty($piketData)): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 4%;">No.</th>
                        <th style="width: 12%;">Tanggal</th>
                        <th style="width: 8%;">Shift</th>
                        <th style="width: 10%;">Jam</th>
                        <th style="width: 15%;">Lokasi</th>
                        <th style="width: 25%;">Anggota Piket</th>
                        <th style="width: 8%;">Jumlah</th>
                        <th style="width: 10%;">Status</th>
                        <th style="width: 8%;">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($piketData as $index => $piket): ?>
                        <tr>
                            <td style="text-align: center;"><?= $index + 1 ?></td>
                            <td><?= date('d/m/Y', strtotime($piket['tanggal_piket'])) ?></td>
                            <td style="text-align: center;">
                                <span class="shift-badge shift-<?= $piket['shift'] ?>"><?= strtoupper($piket['shift']) ?></span>
                            </td>
                            <td><?= substr($piket['jam_mulai'], 0, 5) ?> - <?= substr($piket['jam_selesai'], 0, 5) ?></td>
                            <td><?= $piket['lokasi_piket'] ?: '-' ?></td>
                            <td><?= $piket['anggota_list'] ?: 'Belum ada anggota' ?></td>
                            <td style="text-align: center;"><?= $piket['jumlah_anggota'] ?: 0 ?></td>
                            <td style="text-align: center;">
                                <span class="status-badge status-<?= $piket['status'] ?>"><?= strtoupper($piket['status']) ?></span>
                            </td>
                            <td><?= $piket['keterangan'] ?: '-' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            DataTables warning: table id=monthlyTable - Terjadi kesalahan: Expression #7 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'polseklunangsilaut.piket.tanggal_piket' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by

        <?php else: ?>
            <div class="no-data">
                <h4>Tidak ada data piket untuk periode yang dipilih.</h4>
                <p>Periode: <?= date('d F Y', strtotime($startDate)) ?> - <?= date('d F Y', strtotime($endDate)) ?></p>
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