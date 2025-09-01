<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Polisi - <?= $nomorLP ?></title>
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
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .info-table td {
            padding: 5px 10px;
            vertical-align: top;
            border: 1px solid #000;
        }

        .info-table .label {
            width: 25%;
            font-weight: bold;
            background-color: #f5f5f5;
        }

        .signature-section {
            margin-top: 40px;
            display: flex;
            justify-content: flex-end;
        }

        .signature-box {
            text-align: center;
            width: 250px;
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

        .witness-info {
            margin-left: 20px;
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
        <p>Jl. Raya Lunang Silaut No. 123, Pesisir Selatan, Sumatera Barat</p>
        <p>Telp. (0756) 123456 | Email: polseklunangsilaut@polri.go.id</p>
    </div>

    <!-- Document Title -->
    <div class="document-title">
        LAPORAN POLISI
    </div>

    <!-- Nomor dan Tanggal -->
    <div class="nomor-tanggal">
        <div>
            <strong>Nomor: <?= $nomorLP ?></strong>
        </div>
        <div>
            <strong><?= $tanggalLP ?></strong>
        </div>
    </div>

    <!-- Data Kasus -->
    <div class="content-section">
        <h3>I. DATA KASUS</h3>
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
                <td style="text-transform: uppercase; font-weight: bold;">
                    <?php
                    $statusText = [
                        'dilaporkan' => 'DILAPORKAN',
                        'dalam_proses' => 'DALAM PROSES',
                        'selesai' => 'SELESAI',
                        'ditutup' => 'DITUTUP'
                    ];
                    echo $statusText[$kasus['status']] ?? strtoupper($kasus['status']);
                    ?>
                </td>
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
                    <td class="label">No. Telepon</td>
                    <td><?= $kasus['pelapor_telepon'] ?: 'Tidak tercatat' ?></td>
                </tr>
                <tr>
                    <td class="label">Email</td>
                    <td><?= $kasus['pelapor_email'] ?: 'Tidak tercatat' ?></td>
                </tr>
            </table>
        <?php else: ?>
            <table class="info-table">
                <tr>
                    <td class="label">Status</td>
                    <td style="color: red; font-weight: bold;">Data pelapor belum dilengkapi</td>
                </tr>
            </table>
        <?php endif; ?>
    </div>

    <!-- Kronologi Kejadian -->
    <div class="content-section">
        <h3>III. KRONOLOGI KEJADIAN</h3>
        <div class="chronology">
            <?php if ($kasus['deskripsi']): ?>
                <?= nl2br(htmlspecialchars($kasus['deskripsi'])) ?>
            <?php else: ?>
                <em>Kronologi kejadian belum diisi atau masih dalam tahap penyelidikan lebih lanjut.</em>
            <?php endif; ?>
        </div>
    </div>

    <!-- Tindak Lanjut -->
    <div class="content-section">
        <h3>IV. TINDAK LANJUT</h3>
        <table class="info-table">
            <tr>
                <td class="label">Status Penanganan</td>
                <td>
                    <?php
                    $statusPenanganan = [
                        'dilaporkan' => 'Telah diterima dan dicatat, menunggu penyelidikan',
                        'dalam_proses' => 'Sedang dalam proses penyelidikan oleh unit RESKRIM',
                        'selesai' => 'Penyelidikan telah selesai',
                        'ditutup' => 'Kasus telah ditutup'
                    ];
                    echo $statusPenanganan[$kasus['status']] ?? 'Status tidak diketahui';
                    ?>
                </td>
            </tr>
            <tr>
                <td class="label">Petugas Penerima</td>
                <td><?= $user['nama'] ?? 'Petugas SPKT' ?></td>
            </tr>
            <tr>
                <td class="label">Tanggal Penerimaan</td>
                <td><?= date('d F Y, H:i', strtotime($kasus['created_at'])) ?> WIB</td>
            </tr>
            <?php if ($kasus['keterangan']): ?>
                <tr>
                    <td class="label">Keterangan Tambahan</td>
                    <td><?= nl2br(htmlspecialchars($kasus['keterangan'])) ?></td>
                </tr>
            <?php endif; ?>
        </table>
    </div>

    <!-- Catatan -->
    <div class="content-section">
        <h3>V. CATATAN</h3>
        <p style="text-align: justify; font-style: italic;">
            Laporan Polisi ini dibuat berdasarkan keterangan yang diberikan oleh pelapor.
            Penyelidikan lebih lanjut akan dilakukan oleh unit terkait sesuai dengan prosedur yang berlaku.
            Segala informasi yang tercantum dalam laporan ini bersifat rahasia dan hanya dapat digunakan
            untuk keperluan proses hukum yang sedang berjalan.
        </p>
    </div>

    <!-- Tanda Tangan -->
    <div class="signature-section">
        <div class="signature-box">
            <p><strong>Lunang Silaut, <?= $tanggalLP ?></strong></p>
            <p><strong>PENERIMAAN LAPORAN</strong></p>
            <div class="signature-space"></div>
            <p><strong><?= strtoupper($user['nama'] ?? 'NAMA PETUGAS') ?></strong></p>
            <p>NRP. <?= $user['nrp'] ?? '_______________' ?></p>
        </div>
    </div>

    <!-- Footer -->
    <div style="margin-top: 30px; text-align: center; font-size: 10px; color: #666;">
        <p>--- DOKUMEN RESMI KEPOLISIAN NEGARA REPUBLIK INDONESIA ---</p>
        <p>Dicetak pada: <?= date('d F Y, H:i') ?> WIB | Nomor: <?= $nomorLP ?></p>
    </div>
</body>

</html>
