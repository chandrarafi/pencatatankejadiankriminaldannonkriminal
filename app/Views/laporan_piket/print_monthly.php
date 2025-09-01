<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Piket Per Bulan - Polsek Lunang Silaut</title>
    <style>
        @media print {
            body { margin: 0; }
            .no-print { display: none !important; }
        }
        
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        
        .header h2 {
            margin: 5px 0;
            font-size: 16px;
            font-weight: bold;
        }
        
        .header h3 {
            margin: 5px 0;
            font-size: 14px;
            font-weight: normal;
        }
        
        .report-info {
            margin-bottom: 20px;
        }
        
        .report-info table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .report-info td {
            padding: 5px;
            vertical-align: top;
        }
        
        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin: 20px 0 10px 0;
            text-align: center;
            text-decoration: underline;
        }
        
        .statistics-summary {
            margin-bottom: 20px;
        }
        
        .statistics-summary table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        
        .statistics-summary th,
        .statistics-summary td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
            font-size: 11px;
        }
        
        .statistics-summary th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .data-table th,
        .data-table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
            font-size: 10px;
        }
        
        .data-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        
        .footer {
            margin-top: 30px;
            text-align: right;
        }
        
        .signature {
            margin-top: 50px;
        }
        
        .signature table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .signature td {
            padding: 10px;
            text-align: center;
            vertical-align: top;
        }
        
        .signature-line {
            border-top: 1px solid #000;
            margin-top: 40px;
            padding-top: 5px;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .highlight {
            background-color: #ffffcc;
        }
        
        .total-row {
            font-weight: bold;
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>KEPOLISIAN NEGARA REPUBLIK INDONESIA</h1>
        <h2>POLSEK LUNANG SILAUT</h2>
        <h3>Jl. Raya Lunang Silaut, Kec. Lunang Silaut, Kab. Pesisir Selatan, Sumatera Barat</h3>
        <h3>Telp: (0756) 123456 | Email: polseklunangsilaut@gmail.com</h3>
    </div>

    <!-- Report Information -->
    <div class="report-info">
        <table>
            <tr>
                <td style="width: 20%;"><strong>Nomor:</strong></td>
                <td style="width: 30%;">LP/<?= date('m') ?>/<?= date('Y') ?>/<?= str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT) ?></td>
                <td style="width: 20%;"><strong>Tanggal:</strong></td>
                <td style="width: 30%;"><?= date('d/m/Y') ?></td>
            </tr>
            <tr>
                <td><strong>Perihal:</strong></td>
                <td colspan="3">Laporan Piket Per Bulan</td>
            </tr>
            <tr>
                <td><strong>Bulan/Tahun:</strong></td>
                <td colspan="3"><?= $monthName ?> <?= $year ?></td>
            </tr>
        </table>
    </div>

    <!-- Section Title -->
    <div class="section-title">LAPORAN PIKET PER BULAN</div>

    <!-- Statistics Summary -->
    <div class="statistics-summary">
        <table>
            <tr>
                <th colspan="2">RINGKASAN STATISTIK PIKET</th>
            </tr>
            <tr>
                <td style="width: 50%;">
                    <strong>Berdasarkan Status:</strong><br>
                    • Total Piket: <?= $totals['total_piket'] ?> piket<br>
                    • Dijadwalkan: <?= $totals['dijadwalkan'] ?> piket<br>
                    • Selesai: <?= $totals['selesai'] ?> piket<br>
                    • Diganti: <?= $totals['diganti'] ?> piket<br>
                    • Tidak Hadir: <?= $totals['tidak_hadir'] ?> piket
                </td>
                <td style="width: 50%;">
                    <strong>Berdasarkan Anggota:</strong><br>
                    • Total Anggota: <?= $totals['total_anggota'] ?> orang<br>
                    • Rata-rata Anggota per Piket: <?= $totals['total_piket'] > 0 ? round($totals['total_anggota'] / $totals['total_piket'], 1) : 0 ?> orang<br>
                    • Persentase Selesai: <?= $totals['total_piket'] > 0 ? round(($totals['selesai'] / $totals['total_piket']) * 100, 1) : 0 ?>%<br>
                    • Efisiensi Piket: <?= $totals['total_piket'] > 0 ? round((($totals['selesai'] + $totals['diganti']) / $totals['total_piket']) * 100, 1) : 0 ?>%
                </td>
            </tr>
        </table>
    </div>

    <!-- Data Table -->
    <div class="section-title">DETAIL PIKET PER TANGGAL</div>
    <table class="data-table">
        <thead>
            <tr>
                <th rowspan="2" style="width: 10%;">No</th>
                <th rowspan="2" style="width: 12%;">Tanggal</th>
                <th rowspan="2" style="width: 10%;">Total Piket</th>
                <th colspan="4" style="width: 40%;">Status Piket</th>
                <th rowspan="2" style="width: 10%;">Total Anggota</th>
                <th rowspan="2" style="width: 8%;">Rata-rata</th>
                <th rowspan="2" style="width: 10%;">% Selesai</th>
            </tr>
            <tr>
                <th style="width: 10%;">Dijadwalkan</th>
                <th style="width: 10%;">Selesai</th>
                <th style="width: 10%;">Diganti</th>
                <th style="width: 10%;">Tidak Hadir</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data)): ?>
                <?php $no = 1; ?>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= date('d/m/Y', strtotime($row['tanggal_piket'])) ?></td>
                        <td><?= $row['total_piket'] ?></td>
                        <td><?= $row['dijadwalkan'] ?></td>
                        <td class="<?= $row['selesai'] > 0 ? 'highlight' : '' ?>"><?= $row['selesai'] ?></td>
                        <td><?= $row['diganti'] ?></td>
                        <td><?= $row['tidak_hadir'] ?></td>
                        <td><?= $row['total_anggota'] ?></td>
                        <td><?= $row['total_piket'] > 0 ? round($row['total_anggota'] / $row['total_piket'], 1) : 0 ?></td>
                        <td><?= $row['total_piket'] > 0 ? round(($row['selesai'] / $row['total_piket']) * 100, 1) : 0 ?>%</td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10" style="text-align: center;">Tidak ada data piket untuk bulan <?= $monthName ?> <?= $year ?></td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="2"><strong>TOTAL</strong></td>
                <td><strong><?= $totals['total_piket'] ?></strong></td>
                <td><strong><?= $totals['dijadwalkan'] ?></strong></td>
                <td><strong><?= $totals['selesai'] ?></strong></td>
                <td><strong><?= $totals['diganti'] ?></strong></td>
                <td><strong><?= $totals['tidak_hadir'] ?></strong></td>
                <td><strong><?= $totals['total_anggota'] ?></strong></td>
                <td><strong><?= $totals['total_piket'] > 0 ? round($totals['total_anggota'] / $totals['total_piket'], 1) : 0 ?></strong></td>
                <td><strong><?= $totals['total_piket'] > 0 ? round(($totals['selesai'] / $totals['total_piket']) * 100, 1) : 0 ?>%</strong></td>
            </tr>
        </tfoot>
    </table>

    <!-- Analysis Section -->
    <div class="section-title">ANALISIS DAN KESIMPULAN</div>
    <div style="margin-bottom: 20px;">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 50%; vertical-align: top; padding-right: 20px;">
                    <strong>Analisis Performa:</strong><br>
                    • Total hari dengan piket: <?= count($data) ?> hari<br>
                    • Hari dengan piket terbanyak: <?php 
                        $maxPiket = 0;
                        $maxDate = '';
                        foreach ($data as $row) {
                            if ($row['total_piket'] > $maxPiket) {
                                $maxPiket = $row['total_piket'];
                                $maxDate = date('d/m/Y', strtotime($row['tanggal_piket']));
                            }
                        }
                        echo $maxDate . ' (' . $maxPiket . ' piket)';
                    ?><br>
                    • Hari dengan efisiensi tertinggi: <?php 
                        $maxEfficiency = 0;
                        $maxEffDate = '';
                        foreach ($data as $row) {
                            if ($row['total_piket'] > 0) {
                                $efficiency = ($row['selesai'] / $row['total_piket']) * 100;
                                if ($efficiency > $maxEfficiency) {
                                    $maxEfficiency = $efficiency;
                                    $maxEffDate = date('d/m/Y', strtotime($row['tanggal_piket']));
                                }
                            }
                        }
                        echo $maxEffDate . ' (' . round($maxEfficiency, 1) . '%)';
                    ?>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <strong>Rekomendasi:</strong><br>
                    <?php 
                        $completionRate = $totals['total_piket'] > 0 ? ($totals['selesai'] / $totals['total_piket']) * 100 : 0;
                        if ($completionRate >= 80) {
                            echo "• Performa piket sangat baik, pertahankan standar yang ada<br>";
                        } elseif ($completionRate >= 60) {
                            echo "• Performa piket cukup baik, perlu peningkatan koordinasi<br>";
                        } else {
                            echo "• Performa piket perlu ditingkatkan, evaluasi sistem piket<br>";
                        }
                        
                        if ($totals['tidak_hadir'] > $totals['total_piket'] * 0.1) {
                            echo "• Tingkat ketidakhadiran tinggi, perlu evaluasi penjadwalan<br>";
                        }
                        
                        if ($totals['total_anggota'] / max($totals['total_piket'], 1) < 2) {
                            echo "• Rata-rata anggota per piket rendah, pertimbangkan penambahan personel<br>";
                        }
                    ?>
                </td>
            </tr>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Dicetak pada: <?= date('d/m/Y H:i:s') ?></p>
        <p>Oleh: <?= $user['nama'] ?? 'Sistem' ?> (<?= strtoupper($role) ?>)</p>
    </div>

    <!-- Signature -->
    <div class="signature">
        <table>
            <tr>
                <td style="width: 60%;"></td>
                <td style="width: 40%;">
                    <div class="signature-line">
                        <strong>Kapolsek Lunang Silaut</strong><br><br><br><br>
                        <strong><?= $user['nama'] ?? 'Nama Kapolsek' ?></strong><br>
                        <strong>NIP. <?= $user['nip'] ?? 'NIP Kapolsek' ?></strong>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <script>
        // Auto print when page loads
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
