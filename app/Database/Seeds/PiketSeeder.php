<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PiketSeeder extends Seeder
{
    public function run()
    {
        // Get user kasium untuk created_by
        $kasiumUser = $this->db->table('users')->where('role', 'kasium')->get()->getRowArray();
        $createdBy = $kasiumUser ? $kasiumUser['id'] : 1;

        // Get some anggota
        $anggotaList = $this->db->table('anggota')->limit(5)->get()->getResultArray();

        if (empty($anggotaList)) {
            echo "Warning: Tidak ada data anggota aktif. Buat data anggota dulu.\n";
            return;
        }

        // Sample piket data
        $piketData = [
            [
                'tanggal_piket' => date('Y-m-d', strtotime('+1 day')),
                'shift' => 'pagi',
                'jam_mulai' => '06:00',
                'jam_selesai' => '14:00',
                'lokasi_piket' => 'Kantor Polsek Lunang Silaut',
                'status' => 'aktif',
                'keterangan' => 'Piket rutin pagi hari',
                'created_by' => $createdBy,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_piket' => date('Y-m-d', strtotime('+1 day')),
                'shift' => 'siang',
                'jam_mulai' => '14:00',
                'jam_selesai' => '22:00',
                'lokasi_piket' => 'Kantor Polsek Lunang Silaut',
                'status' => 'aktif',
                'keterangan' => 'Piket siang hari',
                'created_by' => $createdBy,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_piket' => date('Y-m-d', strtotime('+1 day')),
                'shift' => 'malam',
                'jam_mulai' => '22:00',
                'jam_selesai' => '06:00',
                'lokasi_piket' => 'Kantor Polsek Lunang Silaut',
                'status' => 'aktif',
                'keterangan' => 'Piket malam hari',
                'created_by' => $createdBy,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_piket' => date('Y-m-d'),
                'shift' => 'pagi',
                'jam_mulai' => '06:00',
                'jam_selesai' => '14:00',
                'lokasi_piket' => 'Pos Polisi Silaut',
                'status' => 'selesai',
                'keterangan' => 'Piket hari ini sudah selesai',
                'created_by' => $createdBy,
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_piket' => date('Y-m-d', strtotime('+2 days')),
                'shift' => 'pagi',
                'jam_mulai' => '06:00',
                'jam_selesai' => '14:00',
                'lokasi_piket' => 'Kantor Polsek Lunang Silaut',
                'status' => 'aktif',
                'keterangan' => 'Piket besok lusa',
                'created_by' => $createdBy,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Clear existing data
        $this->db->table('piket_detail')->where('id >', 0)->delete();
        $this->db->table('piket')->where('id >', 0)->delete();

        echo "Menambahkan data piket...\n";

        foreach ($piketData as $piket) {
            // Insert piket
            $this->db->table('piket')->insert($piket);
            $piketId = $this->db->insertID();

            // Add random anggota to this piket
            $selectedAnggota = array_rand($anggotaList, min(2, count($anggotaList)));
            if (!is_array($selectedAnggota)) {
                $selectedAnggota = [$selectedAnggota];
            }

            foreach ($selectedAnggota as $index) {
                $this->db->table('piket_detail')->insert([
                    'piket_id' => $piketId,
                    'anggota_id' => $anggotaList[$index]['id'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }

            echo "✅ Piket {$piket['tanggal_piket']} ({$piket['shift']}) - " . count($selectedAnggota) . " anggota\n";
        }

        echo "\nData piket berhasil di-seed!\n";
    }
}
