<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TestKasusSeeder extends Seeder
{
    public function run()
    {
        $kasusModel = new \App\Models\KasusModel();

        // Get required data
        $jenisKasus = $this->db->table('jenis_kasus')->where('is_active', 1)->get()->getFirstRow('array');
        $pelapor = $this->db->table('pelapor')->where('is_active', 1)->get()->getFirstRow('array');
        $user = $this->db->table('users')->where('role', 'spkt')->get()->getFirstRow('array');

        if (!$jenisKasus || !$user) {
            echo "Error: Jenis kasus atau user SPKT tidak ditemukan!\n";
            return;
        }

        // Test data with empty nomor_kasus to trigger auto-generation
        $testData = [
            [
                'nomor_kasus' => '', // Empty untuk auto-generate
                'jenis_kasus_id' => $jenisKasus['id'],
                'judul_kasus' => 'Test Auto Generate Nomor Kasus #1',
                'deskripsi' => 'Testing auto generation nomor kasus dengan format K-YYYYMM-NNNN',
                'tanggal_kejadian' => date('Y-m-d'),
                'lokasi_kejadian' => 'Polsek Lunang Silaut',
                'status' => 'dilaporkan',
                'prioritas' => 'sedang',
                'pelapor_id' => $pelapor['id'] ?? null,
                'pelapor_nama' => $pelapor['nama'] ?? 'Test Pelapor',
                'pelapor_telepon' => $pelapor['telepon'] ?? '081234567890',
                'pelapor_alamat' => $pelapor['alamat'] ?? 'Alamat Test',
                'created_by' => $user['id']
            ],
            [
                'nomor_kasus' => '', // Empty untuk auto-generate
                'jenis_kasus_id' => $jenisKasus['id'],
                'judul_kasus' => 'Test Auto Generate Nomor Kasus #2',
                'deskripsi' => 'Testing sequential numbering untuk bulan yang sama',
                'tanggal_kejadian' => date('Y-m-d'),
                'lokasi_kejadian' => 'Kantor Polsek',
                'status' => 'dilaporkan',
                'prioritas' => 'tinggi',
                'pelapor_id' => $pelapor['id'] ?? null,
                'pelapor_nama' => $pelapor['nama'] ?? 'Test Pelapor 2',
                'pelapor_telepon' => $pelapor['telepon'] ?? '081234567891',
                'pelapor_alamat' => $pelapor['alamat'] ?? 'Alamat Test 2',
                'created_by' => $user['id']
            ],
            [
                'nomor_kasus' => '', // Empty untuk auto-generate
                'jenis_kasus_id' => $jenisKasus['id'],
                'judul_kasus' => 'Test Auto Generate Nomor Kasus #3',
                'deskripsi' => 'Testing third sequential number',
                'tanggal_kejadian' => date('Y-m-d'),
                'lokasi_kejadian' => 'Pos Polisi',
                'status' => 'dalam_proses',
                'prioritas' => 'rendah',
                'pelapor_id' => null,
                'pelapor_nama' => 'Manual Input Pelapor',
                'pelapor_telepon' => '081234567892',
                'pelapor_alamat' => 'Manual Alamat Test',
                'created_by' => $user['id']
            ]
        ];

        echo "Menambahkan test data kasus dengan auto-generate nomor...\n";

        foreach ($testData as $data) {
            $result = $kasusModel->insert($data);
            if ($result) {
                // Get the inserted record to see the generated nomor_kasus
                $insertedKasus = $kasusModel->find($result);
                echo "✅ Berhasil: {$insertedKasus['judul_kasus']} - Nomor: {$insertedKasus['nomor_kasus']}\n";
            } else {
                echo "❌ Gagal: {$data['judul_kasus']}\n";
                print_r($kasusModel->errors());
            }
        }

        echo "\nTest auto-generate nomor kasus selesai!\n";
    }
}
