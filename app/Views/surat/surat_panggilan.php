<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Panggilan - <?= $nomorSurat ?></title>
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

        .content ol {
            margin: 15px 0;
            padding-left: 30px;
        }

        .content ol li {
            margin-bottom: 10px;
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
        SURAT PANGGILAN
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
                <td><strong>Panggilan untuk <?= $personTitle ?> dalam Kasus <?= $kasus['nomor_kasus'] ?></strong></td>
            </tr>
        </table>
    </div>

    <!-- Recipient -->
    <div style="margin-bottom: 30px;">
        <p><strong>Kepada Yth.</strong></p>
        <p style="margin-left: 20px;">
            <strong><?= $person ? $person['nama'] : '___________________' ?></strong><br>
            <?= $person ? ($person['alamat'] ?: 'Alamat tidak tercatat') : 'Alamat: ___________________' ?>
        </p>
    </div>

    <!-- Content -->
    <div class="content">
        <p>
            Sehubungan dengan adanya kasus <strong><?= $kasus['judul_kasus'] ?></strong>
            yang terjadi pada tanggal <strong>
                <?php
                if ($kasus['tanggal_kejadian']) {
                    $tanggal = date_create($kasus['tanggal_kejadian']);
                    echo $tanggal ? $tanggal->format('d F Y') : $kasus['tanggal_kejadian'];
                } else {
                    echo '_____________';
                }
                ?>
            </strong> di <strong><?= $kasus['lokasi_kejadian'] ?: '___________________' ?></strong>,
            dengan ini kami mengharapkan kehadiran Saudara/i untuk memberikan keterangan selaku
            <strong><?= strtoupper($personTitle) ?></strong> dalam proses penyelidikan kasus tersebut.
        </p>

        <p>
            Berdasarkan ketentuan yang berlaku, kami memohon agar Saudara/i dapat hadir pada:
        </p>

        <table class="info-table">
            <tr>
                <td class="label">Hari/Tanggal</td>
                <td>: <strong>___________________</strong></td>
            </tr>
            <tr>
                <td class="label">Waktu</td>
                <td>: <strong>_____ WIB s/d selesai</strong></td>
            </tr>
            <tr>
                <td class="label">Tempat</td>
                <td>: <strong>Kantor Kepolisian Sektor Lunang Silaut<br>Unit Reserse Kriminal</strong></td>
            </tr>
            <tr>
                <td class="label">Keperluan</td>
                <td>: <strong>Pemeriksaan selaku <?= $personTitle ?> dalam kasus:<br><?= $kasus['judul_kasus'] ?></strong></td>
            </tr>
        </table>

        <p>
            Adapun yang perlu Saudara/i bawa dan persiapkan adalah:
        </p>

        <ol>
            <li>Kartu Tanda Penduduk (KTP) atau identitas resmi lainnya</li>
            <li>Dokumen pendukung yang berkaitan dengan kasus (jika ada)</li>
            <?php if ($personType === 'saksi'): ?>
                <li>Keterangan atau informasi yang dapat membantu proses penyelidikan</li>
            <?php elseif ($personType === 'tersangka'): ?>
                <li>Dokumen atau alat bukti yang dapat menunjang pembelaan (jika ada)</li>
                <li>Saudara/i berhak didampingi oleh penasehat hukum</li>
            <?php elseif ($personType === 'korban'): ?>
                <li>Keterangan atau bukti yang berkaitan dengan kerugian yang diderita</li>
                <li>Surat keterangan medis (jika diperlukan)</li>
            <?php endif; ?>
            <li>Kesiapan mental dan fisik untuk memberikan keterangan</li>
        </ol>

        <?php if ($personType === 'tersangka'): ?>
            <div class="important-note">
                <p><strong>PEMBERITAHUAN KHUSUS UNTUK TERSANGKA:</strong></p>
                <ul style="margin: 10px 0; padding-left: 20px;">
                    <li>Saudara/i berhak untuk diam dan tidak menjawab pertanyaan</li>
                    <li>Saudara/i berhak untuk didampingi penasehat hukum</li>
                    <li>Saudara/i berhak untuk menghubungi keluarga</li>
                    <li>Saudara/i akan diperlakukan secara manusiawi sesuai dengan hukum yang berlaku</li>
                </ul>
            </div>
        <?php endif; ?>

        <p>
            Kehadiran Saudara/i sangat kami harapkan tepat waktu. Apabila berhalangan hadir pada waktu yang telah ditentukan,
            mohon untuk menghubungi kami melalui nomor telepon <strong>(0756) 123456</strong> atau datang langsung ke
            Kantor Kepolisian Sektor Lunang Silaut paling lambat <strong>1 (satu) hari</strong> sebelum waktu panggilan
            untuk mengatur jadwal ulang.
        </p>

        <?php if ($personType !== 'tersangka'): ?>
            <p>
                Apabila Saudara/i tidak dapat hadir tanpa alasan yang dapat dipertanggungjawabkan setelah dipanggil sebanyak
                <strong>2 (dua) kali</strong> berturut-turut, maka kami akan mengambil tindakan sesuai dengan ketentuan
                peraturan perundang-undangan yang berlaku.
            </p>
        <?php endif; ?>

        <p>
            Demikian surat panggilan ini kami sampaikan, atas perhatian dan kerjasamanya kami ucapkan terima kasih.
        </p>
    </div>

    <!-- Information about Case -->
    <div style="border: 1px solid #ddd; padding: 15px; margin: 20px 0; background-color: #f9f9f9;">
        <h4 style="margin-top: 0;">INFORMASI KASUS:</h4>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 20%; font-weight: bold; padding: 3px 0;">Nomor Kasus</td>
                <td style="width: 2%;">:</td>
                <td><?= $kasus['nomor_kasus'] ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold; padding: 3px 0;">Jenis Kasus</td>
                <td>:</td>
                <td><?= $kasus['jenis_kasus_nama'] ?? 'Belum ditentukan' ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold; padding: 3px 0;">Status Kasus</td>
                <td>:</td>
                <td style="text-transform: uppercase;">
                    <?php
                    $statusText = [
                        'dilaporkan' => 'DILAPORKAN',
                        'dalam_proses' => 'DALAM PROSES PENYELIDIKAN',
                        'selesai' => 'SELESAI',
                        'ditutup' => 'DITUTUP'
                    ];
                    echo $statusText[$kasus['status']] ?? strtoupper($kasus['status']);
                    ?>
                </td>
            </tr>
        </table>
    </div>

    <!-- Signature -->
    <div class="signature-section">
        <div class="signature-box">
            <p><strong>Lunang Silaut, <?= $tanggalSurat ?></strong></p>
            <p><strong>KEPALA UNIT RESERSE KRIMINAL</strong></p>
            <p><strong>POLSEK LUNANG SILAUT</strong></p>
            <div class="signature-space"></div>
            <p><strong><?= strtoupper($penandatangan['nama'] ?? $user['nama'] ?? 'NAMA PEJABAT') ?></strong></p>
            <p><?= $penandatangan['pangkat'] ?? $user['pangkat'] ?? 'PANGKAT' ?> NRP. <?= $penandatangan['nrp'] ?? $user['nrp'] ?? '___________' ?></p>
        </div>
    </div>

    <!-- Footer -->
    <div style="margin-top: 40px; text-align: center; font-size: 10px; color: #666;">
        <p>--- DOKUMEN RESMI KEPOLISIAN NEGARA REPUBLIK INDONESIA ---</p>
        <p>Dicetak pada: <?= date('d F Y, H:i') ?> WIB | Nomor: <?= $nomorSurat ?></p>
        <p><em>Harap menyimpan surat ini sebagai bukti panggilan resmi</em></p>
    </div>
</body>

</html>
