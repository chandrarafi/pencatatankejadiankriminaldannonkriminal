<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Acara Pemeriksaan - <?= $nomorBAP ?></title>
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
            padding: 8px 10px;
            vertical-align: top;
            border: 1px solid #000;
        }

        .info-table .label {
            width: 25%;
            font-weight: bold;
            background-color: #f5f5f5;
        }

        .statement-box {
            border: 2px solid #000;
            padding: 15px;
            margin: 20px 0;
            min-height: 200px;
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

        .examination-details {
            text-align: justify;
            line-height: 1.8;
        }

        .legal-notice {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 10px;
            font-style: italic;
            text-align: justify;
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
        BERITA ACARA PEMERIKSAAN <?= strtoupper($personTitle) ?>
    </div>

    <!-- Nomor dan Tanggal -->
    <div class="nomor-tanggal">
        <div>
            <strong>Nomor: <?= $nomorBAP ?></strong>
        </div>
        <div>
            <strong><?= $tanggalBAP ?></strong>
        </div>
    </div>

    <!-- Pembukaan -->
    <div class="content-section">
        <p style="text-align: justify; text-indent: 30px;">
            Pada hari ini <strong><?= strftime('%A', strtotime('today')) ?></strong> tanggal <strong><?= $tanggalBAP ?></strong>
            pukul <strong><?= $jamBAP ?></strong>, bertempat di Kantor Kepolisian Sektor Lunang Silaut,
            Unit Reserse Kriminal, telah dilakukan pemeriksaan terhadap:
        </p>
    </div>

    <!-- Data Orang yang Diperiksa -->
    <div class="content-section">
        <h3>I. IDENTITAS <?= strtoupper($personTitle) ?> YANG DIPERIKSA</h3>
        <?php if ($person): ?>
            <table class="info-table">
                <tr>
                    <td class="label">Nama Lengkap</td>
                    <td><?= $person['nama'] ?></td>
                </tr>
                <tr>
                    <td class="label">NIK</td>
                    <td><?= $person['nik'] ?: 'Tidak tercatat' ?></td>
                </tr>
                <tr>
                    <td class="label">Jenis Kelamin</td>
                    <td><?= $person['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                </tr>
                <tr>
                    <td class="label">Umur</td>
                    <td><?= $person['umur'] ? $person['umur'] . ' tahun' : 'Tidak tercatat' ?></td>
                </tr>
                <tr>
                    <td class="label">Pekerjaan</td>
                    <td><?= $person['pekerjaan'] ?: 'Tidak tercatat' ?></td>
                </tr>
                <tr>
                    <td class="label">Alamat</td>
                    <td><?= $person['alamat'] ?: 'Tidak tercatat' ?></td>
                </tr>
                <tr>
                    <td class="label">No. Telepon</td>
                    <td><?= $person['telepon'] ?: 'Tidak tercatat' ?></td>
                </tr>
                <?php if ($personType === 'saksi' && isset($person['jenis_saksi'])): ?>
                    <tr>
                        <td class="label">Jenis Saksi</td>
                        <td><?= $person['jenis_saksi'] ?></td>
                    </tr>
                <?php endif; ?>
                <?php if ($personType === 'tersangka' && isset($person['status_tersangka'])): ?>
                    <tr>
                        <td class="label">Status Tersangka</td>
                        <td style="text-transform: uppercase; font-weight: bold;"><?= $person['status_tersangka'] ?></td>
                    </tr>
                <?php endif; ?>
                <?php if ($personType === 'korban' && isset($person['status_korban'])): ?>
                    <tr>
                        <td class="label">Status Korban</td>
                        <td style="text-transform: uppercase; font-weight: bold;"><?= $person['status_korban'] ?></td>
                    </tr>
                <?php endif; ?>
            </table>
        <?php else: ?>
            <table class="info-table">
                <tr>
                    <td class="label">Status</td>
                    <td style="color: red; font-weight: bold;">Data <?= $personTitle ?> tidak ditemukan</td>
                </tr>
            </table>
        <?php endif; ?>
    </div>

    <!-- Data Kasus -->
    <div class="content-section">
        <h3>II. DATA KASUS YANG DISELIDIKI</h3>
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
        </table>
    </div>

    <!-- Data Pemeriksa -->
    <div class="content-section">
        <h3>III. DATA PEMERIKSA</h3>
        <table class="info-table">
            <tr>
                <td class="label">Nama Pemeriksa</td>
                <td><?= $pemeriksa['nama'] ?? $user['nama'] ?? 'Penyidik RESKRIM' ?></td>
            </tr>
            <tr>
                <td class="label">NRP</td>
                <td><?= $pemeriksa['nrp'] ?? $user['nrp'] ?? 'NRP Penyidik' ?></td>
            </tr>
            <tr>
                <td class="label">Pangkat</td>
                <td><?= $pemeriksa['pangkat'] ?? $user['pangkat'] ?? 'Pangkat Penyidik' ?></td>
            </tr>
            <tr>
                <td class="label">Jabatan</td>
                <td><?= $pemeriksa['jabatan'] ?? 'Penyidik Unit RESKRIM' ?></td>
            </tr>
        </table>
    </div>

    <!-- Hak dan Kewajiban -->
    <div class="content-section">
        <h3>IV. HAK DAN KEWAJIBAN</h3>
        <div class="legal-notice">
            <p><strong>Sebelum pemeriksaan dimulai, kepada yang bersangkutan telah dijelaskan hak-haknya:</strong></p>
            <ol style="margin: 10px 0; padding-left: 20px;">
                <?php if ($personType === 'tersangka'): ?>
                    <li>Hak untuk diam dan tidak menjawab pertanyaan</li>
                    <li>Hak untuk mendapat bantuan hukum</li>
                    <li>Hak untuk menghubungi keluarga</li>
                    <li>Hak atas perlakuan yang manusiawi</li>
                <?php else: ?>
                    <li>Hak untuk memberikan keterangan dengan jujur</li>
                    <li>Hak untuk mendapat perlindungan</li>
                    <li>Hak untuk menolak menjawab pertanyaan yang dapat merugikan diri sendiri</li>
                    <li>Hak untuk didampingi penasehat hukum (jika diperlukan)</li>
                <?php endif; ?>
            </ol>
            <p><strong>Yang bersangkutan menyatakan memahami dan siap untuk diperiksa.</strong></p>
        </div>
    </div>

    <!-- Hasil Pemeriksaan -->
    <div class="content-section">
        <h3>V. HASIL PEMERIKSAAN</h3>
        <p style="font-weight: bold;">
            <?= strtoupper($personTitle) ?> MEMBERIKAN KETERANGAN SEBAGAI BERIKUT:
        </p>

        <div class="statement-box">
            <?php if ($person): ?>
                <?php if ($personType === 'saksi' && isset($person['keterangan_kesaksian'])): ?>
                    <div class="examination-details">
                        <?= nl2br(htmlspecialchars($person['keterangan_kesaksian'])) ?>
                    </div>
                <?php elseif ($personType === 'korban' && isset($person['keterangan_luka'])): ?>
                    <div class="examination-details">
                        <p><strong>Keterangan tentang kejadian:</strong></p>
                        <?= nl2br(htmlspecialchars($person['keterangan_luka'])) ?>

                        <?php if (isset($person['hubungan_pelaku'])): ?>
                            <p><strong>Hubungan dengan pelaku:</strong> <?= $person['hubungan_pelaku'] ?></p>
                        <?php endif; ?>
                    </div>
                <?php elseif ($personType === 'tersangka'): ?>
                    <div class="examination-details">
                        <p><em>Keterangan tersangka akan diisi berdasarkan hasil pemeriksaan yang dilakukan.</em></p>

                        <?php if (isset($person['pasal_yang_disangkakan'])): ?>
                            <p><strong>Pasal yang disangkakan:</strong><br><?= nl2br(htmlspecialchars($person['pasal_yang_disangkakan'])) ?></p>
                        <?php endif; ?>

                        <?php if (isset($person['barang_bukti'])): ?>
                            <p><strong>Barang bukti yang berkaitan:</strong><br><?= nl2br(htmlspecialchars($person['barang_bukti'])) ?></p>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="examination-details">
                        <p><em>Keterangan akan diisi berdasarkan hasil pemeriksaan yang dilakukan.</em></p>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="examination-details">
                    <p><em>Data <?= $personTitle ?> tidak tersedia. Pemeriksaan akan dilakukan secara terpisah.</em></p>
                </div>
            <?php endif; ?>

            <!-- Space for additional notes -->
            <div style="margin-top: 20px; border-top: 1px dashed #666; padding-top: 20px;">
                <p><strong>Catatan tambahan pemeriksa:</strong></p>
                <div style="min-height: 50px; border-bottom: 1px solid #ddd; margin-bottom: 10px;"></div>
                <div style="min-height: 50px; border-bottom: 1px solid #ddd; margin-bottom: 10px;"></div>
                <div style="min-height: 50px; border-bottom: 1px solid #ddd;"></div>
            </div>
        </div>
    </div>

    <!-- Penutup -->
    <div class="content-section">
        <h3>VI. PENUTUP</h3>
        <p style="text-align: justify; text-indent: 30px;">
            Demikian Berita Acara Pemeriksaan ini dibuat dengan sebenar-benarnya berdasarkan keterangan yang diberikan oleh
            <?= $personTitle ?> yang bersangkutan. Berita Acara ini ditutup pada hari yang sama pukul
            <strong>________________ WIB</strong>.
        </p>
    </div>

    <!-- Tanda Tangan -->
    <div class="signature-section">
        <div class="signature-box">
            <p><strong>Yang Diperiksa</strong></p>
            <div class="signature-space"></div>
            <p><strong>(<?= strtoupper($person['nama'] ?? '________________') ?>)</strong></p>
        </div>

        <div class="signature-box">
            <p><strong>Pemeriksa</strong></p>
            <div class="signature-space"></div>
            <p><strong><?= strtoupper($pemeriksa['nama'] ?? $user['nama'] ?? 'NAMA PEMERIKSA') ?></strong></p>
            <p>NRP. <?= $pemeriksa['nrp'] ?? $user['nrp'] ?? '_______________' ?></p>
        </div>
    </div>

    <!-- Footer -->
    <div style="margin-top: 30px; text-align: center; font-size: 10px; color: #666;">
        <p>--- DOKUMEN RESMI KEPOLISIAN NEGARA REPUBLIK INDONESIA ---</p>
        <p>Dicetak pada: <?= date('d F Y, H:i') ?> WIB | Nomor: <?= $nomorBAP ?></p>
    </div>
</body>

</html>
