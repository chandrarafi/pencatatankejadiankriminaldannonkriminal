<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keterangan - <?= $nomorSurat ?></title>
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

        .letter-head {
            margin-bottom: 30px;
        }

        .letter-head table {
            width: 100%;
            border-collapse: collapse;
        }

        .letter-head td {
            padding: 5px 0;
            vertical-align: top;
        }

        .letter-head .label {
            width: 15%;
            font-weight: bold;
        }

        .letter-head .colon {
            width: 2%;
        }

        .content {
            text-align: justify;
            line-height: 1.8;
            margin-bottom: 30px;
        }

        .content p {
            margin-bottom: 15px;
            text-indent: 30px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .info-table td {
            padding: 8px 12px;
            vertical-align: top;
            border: 1px solid #000;
        }

        .info-table .label {
            width: 30%;
            font-weight: bold;
            background-color: #f5f5f5;
        }

        .signature-section {
            margin-top: 50px;
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

        .important-note {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }

        .stamp-area {
            position: relative;
            width: 150px;
            height: 150px;
            border: 2px dashed #ccc;
            margin: 20px auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: #999;
        }

        @media print {
            body {
                margin: 0;
                padding: 15px;
            }

            .no-print {
                display: none !important;
            }

            .important-note {
                background-color: #f9f9f9;
            }

            .stamp-area {
                border-color: #000;
            }
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
        SURAT KETERANGAN
    </div>

    <!-- Letter Head -->
    <div class="letter-head">
        <table>
            <tr>
                <td class="label">Nomor</td>
                <td class="colon">:</td>
                <td><strong><?= $nomorSurat ?></strong></td>
            </tr>
            <tr>
                <td class="label">Lampiran</td>
                <td class="colon">:</td>
                <td>-</td>
            </tr>
            <tr>
                <td class="label">Perihal</td>
                <td class="colon">:</td>
                <td><strong>Keterangan Kasus <?= $kasus['nomor_kasus'] ?></strong></td>
            </tr>
        </table>
    </div>

    <!-- Content -->
    <div class="content">
        <p>
            Yang bertanda tangan di bawah ini, Kepala Kepolisian Sektor Lunang Silaut,
            Kabupaten Pesisir Selatan, Provinsi Sumatera Barat, dengan ini menerangkan bahwa:
        </p>

        <table class="info-table">
            <tr>
                <td class="label">Telah terjadi suatu peristiwa</td>
                <td><strong><?= $kasus['judul_kasus'] ?></strong></td>
            </tr>
            <tr>
                <td class="label">Jenis Kasus</td>
                <td><?= $kasus['jenis_kasus_nama'] ?? 'Belum ditentukan' ?></td>
            </tr>
            <tr>
                <td class="label">Nomor Kasus</td>
                <td><?= $kasus['nomor_kasus'] ?></td>
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
                        'dilaporkan' => 'TELAH DILAPORKAN',
                        'dalam_proses' => 'SEDANG DALAM PROSES PENYELIDIKAN',
                        'selesai' => 'TELAH SELESAI DISELIDIKI',
                        'ditutup' => 'TELAH DITUTUP'
                    ];
                    echo $statusText[$kasus['status']] ?? strtoupper($kasus['status']);
                    ?>
                </td>
            </tr>
            <tr>
                <td class="label">Tanggal Pelaporan</td>
                <td><?= date('d F Y, H:i', strtotime($kasus['created_at'])) ?> WIB</td>
            </tr>
        </table>

        <p>
            Berdasarkan laporan yang diterima dan hasil penyelidikan yang telah dilakukan,
            kasus tersebut telah ditangani sesuai dengan prosedur yang berlaku.
        </p>

        <?php if ($kasus['pelapor_nama']): ?>
            <p>
                Pelapor dalam kasus ini adalah <strong><?= $kasus['pelapor_nama'] ?></strong>
                <?php if ($kasus['pelapor_alamat']): ?>
                    yang beralamat di <strong><?= $kasus['pelapor_alamat'] ?></strong>
                <?php endif; ?>
                <?php if ($kasus['pelapor_telepon']): ?>
                    dan dapat dihubungi melalui nomor telepon <strong><?= $kasus['pelapor_telepon'] ?></strong>
                    <?php endif; ?>.
            </p>
        <?php endif; ?>

        <?php if ($kasus['deskripsi']): ?>
            <p>
                <strong>Keterangan Singkat Kejadian:</strong><br>
                <?= nl2br(htmlspecialchars($kasus['deskripsi'])) ?>
            </p>
        <?php endif; ?>

        <?php if ($kasus['keterangan']): ?>
            <p>
                <strong>Keterangan Tambahan:</strong><br>
                <?= nl2br(htmlspecialchars($kasus['keterangan'])) ?>
            </p>
        <?php endif; ?>

        <p>
            Surat keterangan ini dibuat atas dasar data dan informasi yang tersimpan dalam
            sistem kepolisian dan dapat dipertanggungjawabkan kebenarannya sesuai dengan
            ketentuan peraturan perundang-undangan yang berlaku.
        </p>

        <p>
            Surat keterangan ini berlaku sejak tanggal diterbitkan dan dapat digunakan
            untuk keperluan yang sah sesuai dengan ketentuan hukum yang berlaku.
        </p>
    </div>

    <!-- Important Note -->
    <div class="important-note">
        <p><strong>PENTING:</strong></p>
        <ul style="margin: 10px 0; padding-left: 20px;">
            <li>Surat keterangan ini bersifat resmi dan memiliki kekuatan hukum</li>
            <li>Penyalahgunaan surat ini dapat dikenai sanksi sesuai peraturan yang berlaku</li>
            <li>Untuk verifikasi keabsahan, dapat menghubungi Polsek Lunang Silaut</li>
            <li>Surat ini tidak dapat diubah, ditambah, atau dikurangi isinya</li>
        </ul>
    </div>

    <!-- Status Processing -->
    <div style="border: 1px solid #ddd; padding: 15px; margin: 20px 0; background-color: #f9f9f9;">
        <h4 style="margin-top: 0;">STATUS PEMROSESAN KASUS:</h4>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 25%; font-weight: bold; padding: 3px 0;">Diterima</td>
                <td style="width: 2%;">:</td>
                <td style="width: 23%;"><?= date('d/m/Y H:i', strtotime($kasus['created_at'])) ?></td>
                <td style="width: 25%; font-weight: bold; padding: 3px 0;">Petugas Penerima</td>
                <td style="width: 2%;">:</td>
                <td><?= $user['nama'] ?? 'Petugas SPKT' ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold; padding: 3px 0;">Diproses</td>
                <td>:</td>
                <td>
                    <?php if ($kasus['status'] !== 'dilaporkan'): ?>
                        <?= date('d/m/Y H:i', strtotime($kasus['updated_at'])) ?>
                    <?php else: ?>
                        Belum diproses
                    <?php endif; ?>
                </td>
                <td style="font-weight: bold; padding: 3px 0;">Unit Penanganan</td>
                <td>:</td>
                <td>
                    <?php if ($kasus['status'] !== 'dilaporkan'): ?>
                        Unit RESKRIM
                    <?php else: ?>
                        Unit SPKT
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold; padding: 3px 0;">Status Terkini</td>
                <td>:</td>
                <td colspan="4" style="text-transform: uppercase; font-weight: bold;">
                    <?= $statusText[$kasus['status']] ?? strtoupper($kasus['status']) ?>
                </td>
            </tr>
        </table>
    </div>

    <!-- Signature -->
    <div class="signature-section">
        <div class="signature-box">
            <p><strong>Lunang Silaut, <?= $tanggalSurat ?></strong></p>
            <p><strong>KEPALA KEPOLISIAN SEKTOR</strong></p>
            <p><strong>LUNANG SILAUT</strong></p>

            <div class="stamp-area">
                TEMPAT CAP DINAS
            </div>

            <div class="signature-space"></div>
            <p><strong><?= strtoupper($penandatangan['nama'] ?? $user['nama'] ?? 'NAMA KAPOLSEK') ?></strong></p>
            <p><?= $penandatangan['pangkat'] ?? $user['pangkat'] ?? 'PANGKAT' ?> NRP. <?= $penandatangan['nrp'] ?? $user['nrp'] ?? '___________' ?></p>
        </div>
    </div>

    <!-- Footer -->
    <div style="margin-top: 40px; text-align: center; font-size: 10px; color: #666;">
        <p>--- DOKUMEN RESMI KEPOLISIAN NEGARA REPUBLIK INDONESIA ---</p>
        <p>Dicetak pada: <?= date('d F Y, H:i') ?> WIB | Nomor: <?= $nomorSurat ?></p>
        <p><em>Untuk verifikasi keabsahan dokumen, hubungi Polsek Lunang Silaut</em></p>
    </div>
</body>

</html>
