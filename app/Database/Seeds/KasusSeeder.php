<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KasusSeeder extends Seeder
{
    public function run()
    {
        // Get user SPKT ID untuk created_by
        $spktUser = $this->db->table('users')->where('role', 'spkt')->get()->getRowArray();
        $createdBy = $spktUser ? $spktUser['id'] : 1;

        // Get jenis kasus IDs
        $jenisKasus = $this->db->table('jenis_kasus')->get()->getResultArray();
        $jenisKasusMap = [];
        foreach ($jenisKasus as $jenis) {
            $jenisKasusMap[$jenis['kode_jenis']] = $jenis['id'];
        }

        $data = [
            [
                'nomor_kasus' => 'K-202508-0001',
                'jenis_kasus_id' => $jenisKasusMap['CURANMOR'] ?? 1,
                'judul_kasus' => 'Pencurian Sepeda Motor Honda Beat di Pasar Lunang',
                'deskripsi' => 'Kasus pencurian sepeda motor Honda Beat warna hitam dengan nomor polisi BA 1234 XX yang terjadi di area parkir Pasar Lunang. Kendaraan hilang saat korban berbelanja selama 2 jam. Kondisi kunci motor masih ada di tangan korban, diduga pelaku menggunakan kunci T.',
                'tanggal_kejadian' => '2025-08-23 14:30:00',
                'lokasi_kejadian' => 'Area Parkir Pasar Lunang, Jl. Pasar Raya No. 15',
                'status' => 'dalam_proses',
                'prioritas' => 'sedang',
                'pelapor_nama' => 'Siti Aminah',
                'pelapor_telepon' => '082187654321',
                'pelapor_alamat' => 'Jorong Koto Baru, Nagari Lunang, Kec. Lunang Silaut',
                'petugas_id' => null,
                'created_by' => $createdBy,
                'created_at' => '2025-08-23 16:00:00',
                'updated_at' => '2025-08-24 09:15:00'
            ],
            [
                'nomor_kasus' => 'K-202508-0002',
                'jenis_kasus_id' => $jenisKasusMap['KDRT'] ?? 1,
                'judul_kasus' => 'Kekerasan Dalam Rumah Tangga di Jorong Silaut',
                'deskripsi' => 'Laporan kekerasan dalam rumah tangga berupa kekerasan fisik dan psikis yang dilakukan oleh suami terhadap istri. Korban mengalami luka memar di wajah dan tangan. Kejadian terjadi karena masalah ekonomi keluarga.',
                'tanggal_kejadian' => '2025-08-22 21:00:00',
                'lokasi_kejadian' => 'Jorong Silaut Dalam, Nagari Lunang Silaut',
                'status' => 'dilaporkan',
                'prioritas' => 'tinggi',
                'pelapor_nama' => 'Ratna Sari (korban)',
                'pelapor_telepon' => '081398765432',
                'pelapor_alamat' => 'Jorong Silaut Dalam RT 02 RW 01, Nagari Lunang Silaut',
                'petugas_id' => null,
                'created_by' => $createdBy,
                'created_at' => '2025-08-23 08:30:00',
                'updated_at' => '2025-08-23 08:30:00'
            ],
            [
                'nomor_kasus' => 'K-202508-0003',
                'jenis_kasus_id' => $jenisKasusMap['LAKALANTAS'] ?? 1,
                'judul_kasus' => 'Kecelakaan Lalu Lintas di Jalan Lintas Lunang-Pesisir',
                'deskripsi' => 'Kecelakaan tunggal sepeda motor Yamaha Mio yang menabrak pohon di tikungan tajam. Pengendara mengalami luka ringan dan dibawa ke Puskesmas. Diduga penyebab adalah kecepatan tinggi dan kondisi jalan yang licin karena hujan.',
                'tanggal_kejadian' => '2025-08-24 05:45:00',
                'lokasi_kejadian' => 'Jalan Lintas Lunang-Pesisir Selatan, KM 15',
                'status' => 'selesai',
                'prioritas' => 'sedang',
                'pelapor_nama' => 'Budi Santoso (saksi)',
                'pelapor_telepon' => '085267891234',
                'pelapor_alamat' => 'Jorong Koto Tinggi, Nagari Lunang',
                'petugas_id' => null,
                'created_by' => $createdBy,
                'created_at' => '2025-08-24 06:15:00',
                'updated_at' => '2025-08-24 14:30:00'
            ],
            [
                'nomor_kasus' => 'K-202508-0004',
                'jenis_kasus_id' => $jenisKasusMap['PENIPUAN'] ?? 1,
                'judul_kasus' => 'Penipuan Online Investasi Bodong',
                'deskripsi' => 'Korban tertipu investasi online dengan iming-iming keuntungan 50% per bulan. Total kerugian Rp 25.000.000. Pelaku menggunakan aplikasi WhatsApp dan Telegram untuk komunikasi. Setelah transfer uang, pelaku memblokir kontak korban.',
                'tanggal_kejadian' => '2025-08-20 10:00:00',
                'lokasi_kejadian' => 'Online (aplikasi WhatsApp)',
                'status' => 'dalam_proses',
                'prioritas' => 'tinggi',
                'pelapor_nama' => 'Ahmad Fauzi',
                'pelapor_telepon' => '081234567890',
                'pelapor_alamat' => 'Jorong Pasar, Nagari Lunang Silaut',
                'petugas_id' => null,
                'created_by' => $createdBy,
                'created_at' => '2025-08-21 14:00:00',
                'updated_at' => '2025-08-22 10:00:00'
            ],
            [
                'nomor_kasus' => 'K-202508-0005',
                'jenis_kasus_id' => $jenisKasusMap['KAMTIBMAS'] ?? 1,
                'judul_kasus' => 'Perkelahian Antar Pemuda di Lapangan Bola',
                'deskripsi' => 'Perkelahian antar kelompok pemuda saat pertandingan sepak bola antar jorong. Penyebab perkelahian adalah kecewa dengan keputusan wasit. Tidak ada korban luka serius, hanya luka ringan. Sudah dimediasi oleh wali nagari.',
                'tanggal_kejadian' => '2025-08-19 16:30:00',
                'lokasi_kejadian' => 'Lapangan Sepak Bola Nagari Lunang Silaut',
                'status' => 'ditutup',
                'prioritas' => 'rendah',
                'pelapor_nama' => 'Pak Wali Nagari',
                'pelapor_telepon' => '081298765432',
                'pelapor_alamat' => 'Kantor Wali Nagari Lunang Silaut',
                'petugas_id' => null,
                'created_by' => $createdBy,
                'created_at' => '2025-08-19 18:00:00',
                'updated_at' => '2025-08-20 10:00:00'
            ]
        ];

        // Clear existing data
        $this->db->table('kasus')->where('id >', 0)->delete();

        // Insert new data
        $this->db->table('kasus')->insertBatch($data);

        echo "Data kasus berhasil di-seed!\n";
    }
}
