<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kasus - <?= $kasus['nomor_kasus'] ?: 'Polsek Lunang Silaut' ?></title>
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
            background: white;
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

        .section {
            margin-bottom: 25px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .section-header {
            background-color: #f5f5f5;
            padding: 10px 15px;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
            font-size: 14px;
        }

        .section-content {
            padding: 15px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 5px 8px;
            vertical-align: top;
            border: none;
        }

        .info-table .label {
            width: 150px;
            font-weight: bold;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border: 1px solid #333;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            background: white;
        }

        .description-box {
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            line-height: 1.6;
            text-align: justify;
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

            .section {
                page-break-inside: avoid;
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
            <h3>Detail Kasus</h3>
            <p>Nomor: <?= $kasus['nomor_kasus'] ?: '-' ?></p>
        </div>

        <!-- Case Information Section -->
        <div class="section">
            <div class="section-header">
                INFORMASI KASUS
            </div>
            <div class="section-content">
                <div class="info-grid">
                    <div>
                        <table class="info-table">
                            <tr>
                                <td class="label">Nomor Kasus</td>
                                <td>: <?= $kasus['nomor_kasus'] ?: '-' ?></td>
                            </tr>
                            <tr>
                                <td class="label">Jenis Kasus</td>
                                <td>: <?= $kasus['jenis_kasus_nama'] ?: '-' ?></td>
                            </tr>
                            <tr>
                                <td class="label">Judul Kasus</td>
                                <td>: <?= $kasus['judul_kasus'] ?></td>
                            </tr>
                            <tr>
                                <td class="label">Tanggal Kejadian</td>
                                <td>: <?= date('d F Y', strtotime($kasus['tanggal_kejadian'])) ?></td>
                            </tr>
                            <tr>
                                <td class="label">Waktu Kejadian</td>
                                <td>: <?= date('H:i', strtotime($kasus['tanggal_kejadian'])) ?> WIB</td>
                            </tr>
                        </table>
                    </div>
                    <div>
                        <table class="info-table">
                            <tr>
                                <td class="label">Lokasi Kejadian</td>
                                <td>: <?= $kasus['lokasi_kejadian'] ?: '-' ?></td>
                            </tr>
                            <tr>
                                <td class="label">Status</td>
                                <td>: <span class="status-badge"><?= ucfirst(str_replace('_', ' ', $kasus['status'])) ?></span></td>
                            </tr>
                            <tr>
                                <td class="label">Prioritas</td>
                                <td>: <span class="status-badge"><?= ucfirst($kasus['prioritas'] ?: 'Tidak Ditentukan') ?></span></td>
                            </tr>
                            <tr>
                                <td class="label">Dibuat</td>
                                <td>: <?= date('d F Y H:i', strtotime($kasus['created_at'])) ?> WIB</td>
                            </tr>
                            <tr>
                                <td class="label">Diperbarui</td>
                                <td>: <?= date('d F Y H:i', strtotime($kasus['updated_at'])) ?> WIB</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description Section -->
        <div class="section">
            <div class="section-header">
                DESKRIPSI KASUS
            </div>
            <div class="section-content">
                <div class="description-box">
                    <?= nl2br(htmlspecialchars($kasus['deskripsi'] ?: 'Tidak ada deskripsi')) ?>
                </div>

                <?php if (!empty($kasus['keterangan'])): ?>
                    <div style="margin-top: 15px;">
                        <strong>Keterangan Tambahan:</strong>
                        <div class="description-box" style="margin-top: 5px;">
                            <?= nl2br(htmlspecialchars($kasus['keterangan'])) ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Reporter Information Section -->
        <?php if (!empty($kasus['pelapor_nama'])): ?>
            <div class="section">
                <div class="section-header">
                    INFORMASI PELAPOR
                </div>
                <div class="section-content">
                    <div class="info-grid">
                        <div>
                            <table class="info-table">
                                <tr>
                                    <td class="label">Nama</td>
                                    <td>: <?= $kasus['pelapor_nama'] ?></td>
                                </tr>
                                <tr>
                                    <td class="label">Telepon</td>
                                    <td>: <?= $kasus['pelapor_telepon'] ?: '-' ?></td>
                                </tr>
                            </table>
                        </div>
                        <div>
                            <table class="info-table">
                                <tr>
                                    <td class="label">Alamat</td>
                                    <td>: <?= $kasus['pelapor_alamat'] ?: '-' ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
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