<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UpdatePiketStatusSeeder extends Seeder
{
    public function run()
    {
        // Update status kosong menjadi aktif
        $this->db->table('piket')
            ->where('status IS NULL OR status = ""')
            ->update(['status' => 'aktif']);

        echo "✅ Status piket berhasil diupdate!\n";

        // Show current status
        $pikets = $this->db->table('piket')
            ->select('id, tanggal_piket, shift, status')
            ->get()
            ->getResultArray();

        echo "\n📊 Status Piket Saat Ini:\n";
        echo "ID | Tanggal    | Shift | Status\n";
        echo "---|------------|-------|--------\n";

        foreach ($pikets as $piket) {
            printf(
                "%-2s | %-10s | %-5s | %s\n",
                $piket['id'],
                $piket['tanggal_piket'],
                $piket['shift'],
                $piket['status'] ?: 'draft'
            );
        }
    }
}
