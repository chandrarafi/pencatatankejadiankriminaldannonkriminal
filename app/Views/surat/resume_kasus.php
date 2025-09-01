<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume Kasus - <?= $nomorResume ?></title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12px;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #000;
            padding-bottom: 20px;
        }

        .logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 15px;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="45" fill="none" stroke="black" stroke-width="2"/><text x="50" y="55" text-anchor="middle" font-family="serif" font-size="20" font-weight="bold">POLRI</text></svg>') no-repeat center;
            background-size: contain;
        }

        .header h1 {
            font-size: 18px;
            font-weight: bold;
            margin: 5px 0;
            text-transform: uppercase;
        }

        .header h2 {
            font-size: 16px;
            font-weight: bold;
            margin: 5px 0;
        }

        .header p {
            font-size: 12px;
            margin: 2px 0;
        }

        .document-title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 30px 0;
            text-decoration: underline;
        }

        .nomor-tanggal {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .content-section {
            margin-bottom: 25px;
        }

        .content-section h3 {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
            background-color: #f5f5f5;
            padding-left: 10px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .info-table td {
            padding: 8px 10px;
            vertical-align: top;
            border: 1px solid #000;
        }

        .info-table .label {
            width: 25%;
            font-weight: bold;
            background-color: #f5f5f5;
        }

        .summary-box {
            border: 2px solid #000;
            padding: 15px;
            margin: 15px 0;
            background-color: #f9f9f9;
        }

        .person-card {
            border: 1px solid #ddd;
            margin: 10px 0;
            padding: 10px;
            background-color: #fafafa;
        }

        .person-card h5 {
            margin: 0 0 10px 0;
            font-weight: bold;
        }

        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-success {
            background-color: #d4edda;
            color: #155724;
        }

        .status-warning {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .status-info {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .status-secondary {
            background-color: #e2e3e5;
            color: #383d41;
        }

        .statistics {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
        }

        .stat-box {
            text-align: center;
            border: 1px solid #ddd;
            padding: 15px;
            flex: 1;
            margin: 0 5px;
        }

        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }

        .signature-section {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            text-align: center;
            width: 200px;
        }

        .signature-space {
            height: 80px;
            border-bottom: 1px solid #000;
            margin: 20px 0 10px;
        }

        @media print {
            body {
                margin: 0;
                padding: 15px;
            }

            .no-print {
                display: none !important;
            }
        }

        .chronology {
            text-align: justify;
            line-height: 1.8;
            text-indent: 30px;
        }

        .conclusion {
            background-color: #e9ecef;
            border-left: 4px solid #007bff;
            padding: 15px;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="background: #007bff; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">
            <i class="fas fa-print"></i> Print
        </button>
        <button onclick="window.close()" style="background: #6c757d; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-left: 10px;">
            Close
        </button>
    </div>

    <!-- Header -->
    <div class="header">
        <div class="logo"></div>
        <h1>KEPOLISIAN NEGARA REPUBLIK INDONESIA</h1>
        <h2>KEPOLISIAN SEKTOR LUNANG SILAUT</h2>
        <h2>UNIT RESERSE KRIMINAL</h2>
        <p>Jl. Raya Lunang Silaut No. 123, Pesisir Selatan, Sumatera Barat</p>
        <p>Telp. (0756) 123456 | Email: reskrim.polseklunangsilaut@polri.go.id</p>
    </div>

    <!-- Document Title -->
    <div class="document-title">
        RESUME KASUS PIDANA
    </div>

    <!-- Nomor dan Tanggal -->
    <div class="nomor-tanggal">
        <div>
            <strong>Nomor: <?= $nomorResume ?></strong>
        </div>
        <div>
            <strong><?= $tanggalResume ?></strong>
        </div>
    </div>

    <!-- Overview/Statistics -->
    <div class="content-section">
        <h3>RINGKASAN EKSEKUTIF</h3>
        <div class="statistics">
            <div class="stat-box">
                <div class="stat-number">1</div>
                <div>Pelapor</div>
            </div>
            <div class="stat-box">
                <div class="stat-number"><?= count($korbanList) ?></div>
                <div>Korban</div>
            </div>
            <div class="stat-box">
                <div class="stat-number"><?= count($tersangkaList) ?></div>
                <div>Tersangka</div>
            </div>
            <div class="stat-box">
                <div class="stat-number"><?= count($saksiList) ?></div>
                <div>Saksi</div>
            </div>
            <div class="stat-box">
                <div class="stat-number"><?= 1 + count($korbanList) + count($tersangkaList) + count($saksiList) ?></div>
                <div>Total Pihak</div>
            </div>
        </div>
    </div>

    <!-- Data Kasus -->
    <div class="content-section">
        <h3>I. IDENTITAS KASUS</h3>
        <table class="info-table">
            <tr>
                <td class="label">Nomor Kasus</td>
                <td><?= $kasus['nomor_kasus'] ?></td>
            </tr>
            <tr>
                <td class="label">Jenis Kasus</td>
                <td><?= $kasus['jenis_kasus_nama'] ?? 'Belum ditentukan' ?></td>
            </tr>
            <tr>
                <td class="label">Judul Kasus</td>
                <td><?= $kasus['judul_kasus'] ?></td>
            </tr>
            <tr>
                <td class="label">Tanggal Kejadian</td>
                <td>
                    <?php
                    if ($kasus['tanggal_kejadian']) {
                        $tanggal = date_create($kasus['tanggal_kejadian']);
                        echo $tanggal ? $tanggal->format('d F Y, H:i') . ' WIB' : $kasus['tanggal_kejadian'];
                    } else {
                        echo 'Belum ditentukan';
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td class="label">Tempat Kejadian</td>
                <td><?= $kasus['lokasi_kejadian'] ?: 'Belum ditentukan' ?></td>
            </tr>
            <tr>
                <td class="label">Status Kasus</td>
                <td>
                    <?php
                    $statusClass = [
                        'dilaporkan' => 'status-warning',
                        'dalam_proses' => 'status-info',
                        'selesai' => 'status-success',
                        'ditutup' => 'status-secondary'
                    ];
                    $statusText = [
                        'dilaporkan' => 'DILAPORKAN',
                        'dalam_proses' => 'DALAM PROSES',
                        'selesai' => 'SELESAI',
                        'ditutup' => 'DITUTUP'
                    ];
                    $badgeClass = $statusClass[$kasus['status']] ?? 'status-secondary';
                    $statusLabel = $statusText[$kasus['status']] ?? strtoupper($kasus['status']);
                    ?>
                    <span class="status-badge <?= $badgeClass ?>"><?= $statusLabel ?></span>
                </td>
            </tr>
            <tr>
                <td class="label">Prioritas</td>
                <td>
                    <?php
                    $prioritasClass = [
                        'rendah' => 'status-info',
                        'sedang' => 'status-warning',
                        'tinggi' => 'status-danger'
                    ];
                    $prioritasText = [
                        'rendah' => 'RENDAH',
                        'sedang' => 'SEDANG',
                        'tinggi' => 'TINGGI'
                    ];
                    $badgeClass = $prioritasClass[$kasus['prioritas']] ?? 'status-secondary';
                    $prioritasLabel = $prioritasText[$kasus['prioritas']] ?? strtoupper($kasus['prioritas']);
                    ?>
                    <span class="status-badge <?= $badgeClass ?>"><?= $prioritasLabel ?></span>
                </td>
            </tr>
            <tr>
                <td class="label">Tanggal Laporan</td>
                <td><?= date('d F Y, H:i', strtotime($kasus['created_at'])) ?> WIB</td>
            </tr>
        </table>
    </div>

    <!-- Data Pelapor -->
    <div class="content-section">
        <h3>II. DATA PELAPOR</h3>
        <?php if ($kasus['pelapor_nama']): ?>
            <table class="info-table">
                <tr>
                    <td class="label">Nama Lengkap</td>
                    <td><?= $kasus['pelapor_nama'] ?></td>
                </tr>
                <tr>
                    <td class="label">NIK</td>
                    <td><?= $kasus['pelapor_nik'] ?: 'Tidak tercatat' ?></td>
                </tr>
                <tr>
                    <td class="label">Alamat</td>
                    <td><?= $kasus['pelapor_alamat'] ?: 'Tidak tercatat' ?></td>
                </tr>
                <tr>
                    <td class="label">Kontak</td>
                    <td>
                        Telp: <?= $kasus['pelapor_telepon'] ?: '-' ?><br>
                        Email: <?= $kasus['pelapor_email'] ?: '-' ?>
                    </td>
                </tr>
            </table>
        <?php else: ?>
            <div class="summary-box">
                <p style="color: red; font-weight: bold; margin: 0;">⚠️ Data pelapor belum dilengkapi dalam sistem</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Data Korban -->
    <div class="content-section">
        <h3>III. DATA KORBAN (<?= count($korbanList) ?> ORANG)</h3>
        <?php if (count($korbanList) > 0): ?>
            <?php foreach ($korbanList as $index => $korban): ?>
                <div class="person-card">
                    <h5>Korban #<?= $index + 1 ?>: <?= $korban['nama'] ?></h5>
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="width: 20%; font-weight: bold; padding: 3px 5px;">NIK</td>
                            <td style="width: 2%;">:</td>
                            <td style="width: 28%; padding: 3px 5px;"><?= $korban['nik'] ?: '-' ?></td>
                            <td style="width: 20%; font-weight: bold; padding: 3px 5px;">Umur</td>
                            <td style="width: 2%;">:</td>
                            <td style="padding: 3px 5px;"><?= $korban['umur'] ? $korban['umur'] . ' tahun' : '-' ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 3px 5px;">Status</td>
                            <td>:</td>
                            <td colspan="4" style="padding: 3px 5px;">
                                <?php
                                $statusClass = [
                                    'hidup' => 'status-success',
                                    'meninggal' => 'status-danger',
                                    'luka' => 'status-warning',
                                    'hilang' => 'status-secondary'
                                ];
                                $statusText = [
                                    'hidup' => 'HIDUP',
                                    'meninggal' => 'MENINGGAL',
                                    'luka' => 'LUKA',
                                    'hilang' => 'HILANG'
                                ];
                                $badgeClass = $statusClass[$korban['status_korban']] ?? 'status-secondary';
                                $statusLabel = $statusText[$korban['status_korban']] ?? $korban['status_korban'];
                                ?>
                                <span class="status-badge <?= $badgeClass ?>"><?= $statusLabel ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 3px 5px;">Alamat</td>
                            <td>:</td>
                            <td colspan="4" style="padding: 3px 5px;"><?= $korban['alamat'] ?: '-' ?></td>
                        </tr>
                        <?php if ($korban['keterangan_luka']): ?>
                            <tr>
                                <td style="font-weight: bold; padding: 3px 5px;">Keterangan</td>
                                <td>:</td>
                                <td colspan="4" style="padding: 3px 5px;"><?= nl2br(htmlspecialchars($korban['keterangan_luka'])) ?></td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="summary-box">
                <p style="margin: 0;">ℹ️ Belum ada data korban yang tercatat dalam kasus ini</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Data Tersangka -->
    <div class="content-section">
        <h3>IV. DATA TERSANGKA (<?= count($tersangkaList) ?> ORANG)</h3>
        <?php if (count($tersangkaList) > 0): ?>
            <?php foreach ($tersangkaList as $index => $tersangka): ?>
                <div class="person-card">
                    <h5>Tersangka #<?= $index + 1 ?>: <?= $tersangka['nama'] ?></h5>
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="width: 20%; font-weight: bold; padding: 3px 5px;">NIK</td>
                            <td style="width: 2%;">:</td>
                            <td style="width: 28%; padding: 3px 5px;"><?= $tersangka['nik'] ?: '-' ?></td>
                            <td style="width: 20%; font-weight: bold; padding: 3px 5px;">Umur</td>
                            <td style="width: 2%;">:</td>
                            <td style="padding: 3px 5px;"><?= $tersangka['umur'] ? $tersangka['umur'] . ' tahun' : '-' ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 3px 5px;">Status</td>
                            <td>:</td>
                            <td colspan="4" style="padding: 3px 5px;">
                                <?php
                                $statusClass = [
                                    'ditangkap' => 'status-warning',
                                    'ditahan' => 'status-danger',
                                    'buron' => 'status-secondary',
                                    'diserahkan' => 'status-success'
                                ];
                                $statusText = [
                                    'ditangkap' => 'DITANGKAP',
                                    'ditahan' => 'DITAHAN',
                                    'buron' => 'BURON',
                                    'diserahkan' => 'DISERAHKAN'
                                ];
                                $badgeClass = $statusClass[$tersangka['status_tersangka']] ?? 'status-secondary';
                                $statusLabel = $statusText[$tersangka['status_tersangka']] ?? $tersangka['status_tersangka'];
                                ?>
                                <span class="status-badge <?= $badgeClass ?>"><?= $statusLabel ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 3px 5px;">Alamat</td>
                            <td>:</td>
                            <td colspan="4" style="padding: 3px 5px;"><?= $tersangka['alamat'] ?: '-' ?></td>
                        </tr>
                        <?php if ($tersangka['pasal_yang_disangkakan']): ?>
                            <tr>
                                <td style="font-weight: bold; padding: 3px 5px;">Pasal</td>
                                <td>:</td>
                                <td colspan="4" style="padding: 3px 5px;"><?= htmlspecialchars($tersangka['pasal_yang_disangkakan']) ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if ($tersangka['barang_bukti']): ?>
                            <tr>
                                <td style="font-weight: bold; padding: 3px 5px;">Barang Bukti</td>
                                <td>:</td>
                                <td colspan="4" style="padding: 3px 5px;"><?= nl2br(htmlspecialchars($tersangka['barang_bukti'])) ?></td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="summary-box">
                <p style="margin: 0;">ℹ️ Belum ada data tersangka yang tercatat dalam kasus ini</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Data Saksi -->
    <div class="content-section">
        <h3>V. DATA SAKSI (<?= count($saksiList) ?> ORANG)</h3>
        <?php if (count($saksiList) > 0): ?>
            <?php foreach ($saksiList as $index => $saksi): ?>
                <div class="person-card">
                    <h5>Saksi #<?= $index + 1 ?>: <?= $saksi['nama'] ?></h5>
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="width: 20%; font-weight: bold; padding: 3px 5px;">NIK</td>
                            <td style="width: 2%;">:</td>
                            <td style="width: 28%; padding: 3px 5px;"><?= $saksi['nik'] ?: '-' ?></td>
                            <td style="width: 20%; font-weight: bold; padding: 3px 5px;">Umur</td>
                            <td style="width: 2%;">:</td>
                            <td style="padding: 3px 5px;"><?= $saksi['umur'] ? $saksi['umur'] . ' tahun' : '-' ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 3px 5px;">Jenis Saksi</td>
                            <td>:</td>
                            <td style="padding: 3px 5px;"><?= $saksi['jenis_saksi'] ?: '-' ?></td>
                            <td style="font-weight: bold; padding: 3px 5px;">Dapat Dihubungi</td>
                            <td>:</td>
                            <td style="padding: 3px 5px;">
                                <?php if ($saksi['dapat_dihubungi']): ?>
                                    <span class="status-badge status-success">YA</span>
                                <?php else: ?>
                                    <span class="status-badge status-secondary">TIDAK</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 3px 5px;">Alamat</td>
                            <td>:</td>
                            <td colspan="4" style="padding: 3px 5px;"><?= $saksi['alamat'] ?: '-' ?></td>
                        </tr>
                        <?php if ($saksi['keterangan_kesaksian']): ?>
                            <tr>
                                <td style="font-weight: bold; padding: 3px 5px;">Kesaksian</td>
                                <td>:</td>
                                <td colspan="4" style="padding: 3px 5px;"><?= nl2br(htmlspecialchars($saksi['keterangan_kesaksian'])) ?></td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="summary-box">
                <p style="margin: 0;">ℹ️ Belum ada data saksi yang tercatat dalam kasus ini</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Kronologi -->
    <div class="content-section">
        <h3>VI. KRONOLOGI KEJADIAN</h3>
        <div class="chronology">
            <?php if ($kasus['deskripsi']): ?>
                <?= nl2br(htmlspecialchars($kasus['deskripsi'])) ?>
            <?php else: ?>
                <em>Kronologi kejadian belum diisi atau masih dalam tahap penyelidikan lebih lanjut.</em>
            <?php endif; ?>
        </div>
    </div>

    <!-- Kesimpulan -->
    <div class="content-section">
        <h3>VII. KESIMPULAN DAN REKOMENDASI</h3>
        <div class="conclusion">
            <h4 style="margin-top: 0;">KESIMPULAN:</h4>
            <p style="text-align: justify;">
                Berdasarkan hasil penyelidikan yang telah dilakukan terhadap kasus <strong><?= $kasus['judul_kasus'] ?></strong>
                dengan nomor <strong><?= $kasus['nomor_kasus'] ?></strong>, telah diperoleh data sebagai berikut:
            </p>
            <ul>
                <li>Total <?= count($korbanList) ?> korban yang terlibat dalam kasus ini</li>
                <li>Total <?= count($tersangkaList) ?> tersangka yang telah teridentifikasi</li>
                <li>Total <?= count($saksiList) ?> saksi yang dapat memberikan keterangan</li>
                <li>Status kasus saat ini: <strong><?= $statusLabel ?></strong></li>
            </ul>

            <h4>REKOMENDASI TINDAK LANJUT:</h4>
            <?php if ($kasus['status'] === 'dalam_proses'): ?>
                <ul>
                    <li>Melanjutkan proses penyelidikan dan pengumpulan barang bukti</li>
                    <li>Melakukan pemeriksaan lebih mendalam terhadap pihak-pihak terkait</li>
                    <li>Koordinasi dengan unit terkait untuk kelengkapan berkas</li>
                </ul>
            <?php elseif ($kasus['status'] === 'selesai'): ?>
                <ul>
                    <li>Berkas kasus telah lengkap dan siap untuk diserahkan ke Kejaksaan</li>
                    <li>Melakukan monitoring terhadap proses hukum selanjutnya</li>
                    <li>Menyiapkan dukungan untuk proses persidangan (jika diperlukan)</li>
                </ul>
            <?php else: ?>
                <ul>
                    <li>Mengevaluasi kelengkapan data dan informasi kasus</li>
                    <li>Menentukan tindak lanjut sesuai dengan perkembangan penyelidikan</li>
                    <li>Koordinasi dengan atasan dan unit terkait</li>
                </ul>
            <?php endif; ?>
        </div>
    </div>

    <!-- Penutup -->
    <div class="content-section">
        <p style="text-align: justify; text-indent: 30px;">
            Demikian resume kasus ini dibuat berdasarkan data dan informasi yang telah terkumpul.
            Resume ini dapat digunakan sebagai bahan evaluasi, koordinasi, dan pengambilan keputusan
            dalam proses penanganan kasus selanjutnya.
        </p>
    </div>

    <!-- Tanda Tangan -->
    <div class="signature-section">
        <div class="signature-box">
            <p><strong>Mengetahui,</strong></p>
            <p><strong>KEPALA UNIT RESKRIM</strong></p>
            <div class="signature-space"></div>
            <p><strong>(_____________________)</strong></p>
            <p>KAUR RESKRIM POLSEK LUNANG SILAUT</p>
        </div>

        <div class="signature-box">
            <p><strong>Lunang Silaut, <?= $tanggalResume ?></strong></p>
            <p><strong>PEMBUAT RESUME</strong></p>
            <div class="signature-space"></div>
            <p><strong><?= strtoupper($pembuat['nama'] ?? $user['nama'] ?? 'NAMA PEMBUAT') ?></strong></p>
            <p>NRP. <?= $pembuat['nrp'] ?? $user['nrp'] ?? '_______________' ?></p>
        </div>
    </div>

    <!-- Footer -->
    <div style="margin-top: 30px; text-align: center; font-size: 10px; color: #666;">
        <p>--- DOKUMEN RESMI KEPOLISIAN NEGARA REPUBLIK INDONESIA ---</p>
        <p>Dicetak pada: <?= date('d F Y, H:i') ?> WIB | Nomor: <?= $nomorResume ?></p>
        <p><em>Resume ini bersifat rahasia dan hanya untuk keperluan dinas</em></p>
    </div>
</body>

</html>
