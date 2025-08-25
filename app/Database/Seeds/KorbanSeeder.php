<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KorbanSeeder extends Seeder
{
    public function run()
    {
        // Get some kasus IDs for reference
        $kasusList = $this->db->table('kasus')->limit(3)->get()->getResultArray();

        if (empty($kasusList)) {
            echo "❌ Tidak ada data kasus. Jalankan KasusSeeder terlebih dahulu.\n";
            return;
        }

        $data = [
            [
                'kasus_id' => $kasusList[0]['id'],
                'nama' => 'Siti Nurhaliza',
                'nik' => '1371054509850001',
                'jenis_kelamin' => 'P',
                'umur' => 28,
                'alamat' => 'Jl. Pantai Indah No. 12, Lunang Silaut',
                'pekerjaan' => 'Guru SD',
                'telepon' => '08123456789',
                'email' => 'siti.nurhaliza@email.com',
                'status_korban' => 'hidup',
                'keterangan_luka' => 'Luka lecet di tangan kanan akibat terjatuh',
                'hubungan_pelaku' => 'Tidak dikenal',
                'keterangan' => 'Korban sedang berjalan pulang dari sekolah saat kejadian berlangsung',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kasus_id' => $kasusList[0]['id'],
                'nama' => 'Budi Santoso',
                'nik' => '1371051205790002',
                'jenis_kelamin' => 'L',
                'umur' => 45,
                'alamat' => 'Jl. Raya Lunang No. 45, Lunang Silaut',
                'pekerjaan' => 'Pedagang',
                'telepon' => '08198765432',
                'email' => null,
                'status_korban' => 'luka',
                'keterangan_luka' => 'Luka berat di kepala dan tangan, dirawat di rumah sakit',
                'hubungan_pelaku' => 'Tetangga',
                'keterangan' => 'Korban adalah pemilik warung yang menjadi sasaran pencurian',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kasus_id' => count($kasusList) > 1 ? $kasusList[1]['id'] : $kasusList[0]['id'],
                'nama' => 'Dewi Sartika',
                'nik' => '1371056708920003',
                'jenis_kelamin' => 'P',
                'umur' => 32,
                'alamat' => 'Jl. Sungai Jernih No. 7, Lunang Silaut',
                'pekerjaan' => 'Ibu Rumah Tangga',
                'telepon' => '08567891234',
                'email' => 'dewi.sartika@gmail.com',
                'status_korban' => 'hidup',
                'keterangan_luka' => null,
                'hubungan_pelaku' => 'Mantan pacar',
                'keterangan' => 'Korban menerima ancaman melalui pesan singkat berulang kali',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kasus_id' => count($kasusList) > 2 ? $kasusList[2]['id'] : $kasusList[0]['id'],
                'nama' => 'Ahmad Fauzi',
                'nik' => '1371051801880004',
                'jenis_kelamin' => 'L',
                'umur' => 36,
                'alamat' => 'Jl. Masjid Agung No. 23, Lunang Silaut',
                'pekerjaan' => 'Nelayan',
                'telepon' => '08345678901',
                'email' => null,
                'status_korban' => 'hilang',
                'keterangan_luka' => null,
                'hubungan_pelaku' => 'Tidak dikenal',
                'keterangan' => 'Korban hilang saat melaut, terakhir terlihat 3 hari yang lalu',
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
            ],
            [
                'kasus_id' => $kasusList[0]['id'],
                'nama' => 'Ratna Sari',
                'nik' => '1371055512950005',
                'jenis_kelamin' => 'P',
                'umur' => 29,
                'alamat' => 'Jl. Pemuda No. 89, Lunang Silaut',
                'pekerjaan' => 'Karyawan Bank',
                'telepon' => '08123456780',
                'email' => 'ratna.sari@bank.co.id',
                'status_korban' => 'meninggal',
                'keterangan_luka' => 'Luka fatal di dada akibat benda tajam',
                'hubungan_pelaku' => 'Tidak dikenal',
                'keterangan' => 'Korban ditemukan di rumahnya dalam keadaan meninggal dunia',
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 week')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-1 week')),
            ]
        ];

        // Insert data korban
        $this->db->table('korban')->insertBatch($data);

        // Output informasi
        echo "✓ Data sample korban berhasil di-seed:\n";
        echo "  - Total korban: " . count($data) . "\n";
        echo "  - Status: Hidup (2), Luka (1), Hilang (1), Meninggal (1)\n";
        echo "  - Terkait dengan " . count($kasusList) . " kasus\n";
    }
}
