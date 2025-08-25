<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FixPiketStatusSeeder extends Seeder
{
    public function run()
    {
        // Get all pikets with empty status
        $pikets = $this->db->table('piket')->get()->getResultArray();

        foreach ($pikets as $piket) {
            if (empty($piket['status'])) {
                // Set status based on date
                $tanggal = $piket['tanggal_piket'];
                $today = date('Y-m-d');

                if ($tanggal < $today) {
                    $status = 'selesai';
                } elseif ($tanggal == $today) {
                    $status = 'aktif';
                } else {
                    $status = 'dijadwalkan';
                }

                $this->db->table('piket')
                    ->where('id', $piket['id'])
                    ->update(['status' => $status]);

                echo "✅ Piket ID {$piket['id']} ({$tanggal}) → {$status}\n";
            }
        }

        echo "\n📊 Status Final:\n";
        $finalPikets = $this->db->table('piket')
            ->select('id, tanggal_piket, shift, status')
            ->orderBy('tanggal_piket')
            ->get()
            ->getResultArray();

        foreach ($finalPikets as $piket) {
            echo "ID {$piket['id']}: {$piket['tanggal_piket']} ({$piket['shift']}) → {$piket['status']}\n";
        }
    }
}
