<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AnggotaSeeder extends Seeder
{
    public function run()
    {
        // Data sample anggota polsek
        $data = [
            [
                'nrp' => '19850101001',
                'nama' => 'Bripka Ahmad Fauzi',
                'pangkat' => 'Brigadir Polisi Kepala',
                'jabatan' => 'Bhabinkamtibmas',
                'unit_kerja' => 'Polsek Lunang Silaut',
                'alamat' => 'Jl. Raya Lunang No. 15, Lunang Silaut',
                'telepon' => '081234567890',
                'email' => 'ahmad.fauzi@polsek.lunangsilaut.id',
                'status' => 'aktif',
                'tanggal_masuk' => '2010-01-15',
                'keterangan' => 'Bertugas di wilayah Lunang Utara',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nrp' => '19900215002',
                'nama' => 'Briptu Sari Dewi',
                'pangkat' => 'Brigadir Polisi Satu',
                'jabatan' => 'Anggota Sabhara',
                'unit_kerja' => 'Polsek Lunang Silaut',
                'alamat' => 'Jl. Mawar No. 8, Silaut',
                'telepon' => '081234567891',
                'email' => 'sari.dewi@polsek.lunangsilaut.id',
                'status' => 'aktif',
                'tanggal_masuk' => '2015-03-20',
                'keterangan' => 'Anggota patroli wilayah',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nrp' => '19880712003',
                'nama' => 'Bripda Joko Susilo',
                'pangkat' => 'Brigadir Polisi Dua',
                'jabatan' => 'Anggota Lantas',
                'unit_kerja' => 'Polsek Lunang Silaut',
                'alamat' => 'Jl. Melati No. 12, Lunang',
                'telepon' => '081234567892',
                'email' => 'joko.susilo@polsek.lunangsilaut.id',
                'status' => 'aktif',
                'tanggal_masuk' => '2012-07-10',
                'keterangan' => 'Bertugas di pos lantas',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nrp' => '19920505004',
                'nama' => 'Briptu Lisa Maharani',
                'pangkat' => 'Brigadir Polisi Satu',
                'jabatan' => 'Anggota Reskrim',
                'unit_kerja' => 'Polsek Lunang Silaut',
                'alamat' => 'Jl. Anggrek No. 5, Silaut Selatan',
                'telepon' => '081234567893',
                'email' => 'lisa.maharani@polsek.lunangsilaut.id',
                'status' => 'aktif',
                'tanggal_masuk' => '2018-05-01',
                'keterangan' => 'Bertugas penyelidikan kriminal',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nrp' => '19870303005',
                'nama' => 'Bripka Indra Gunawan',
                'pangkat' => 'Brigadir Polisi Kepala',
                'jabatan' => 'Bendahara',
                'unit_kerja' => 'Polsek Lunang Silaut',
                'alamat' => 'Jl. Kenanga No. 3, Lunang Tengah',
                'telepon' => '081234567894',
                'email' => 'indra.gunawan@polsek.lunangsilaut.id',
                'status' => 'aktif',
                'tanggal_masuk' => '2011-03-03',
                'keterangan' => 'Mengurus administrasi keuangan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nrp' => '19831225006',
                'nama' => 'Bripka Bambang Sutrisno',
                'pangkat' => 'Brigadir Polisi Kepala',
                'jabatan' => 'Anggota Sabhara',
                'unit_kerja' => 'Polsek Lunang Silaut',
                'alamat' => 'Jl. Flamboyan No. 7, Silaut Barat',
                'telepon' => '081234567895',
                'email' => 'bambang.sutrisno@polsek.lunangsilaut.id',
                'status' => 'pensiun',
                'tanggal_masuk' => '2008-12-25',
                'keterangan' => 'Pensiun per Januari 2024',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Insert data ke tabel anggota
        $this->db->table('anggota')->insertBatch($data);

        echo "✓ Data sample anggota berhasil di-seed (6 anggota)\n";
    }
}
