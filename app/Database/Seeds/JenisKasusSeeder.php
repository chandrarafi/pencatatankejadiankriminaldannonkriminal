<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class JenisKasusSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'kode_jenis' => 'KDRT',
                'nama_jenis' => 'Kekerasan Dalam Rumah Tangga',
                'deskripsi' => 'Kasus kekerasan yang terjadi dalam lingkungan rumah tangga, termasuk kekerasan fisik, psikis, seksual, dan ekonomi yang dilakukan oleh anggota keluarga.',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kode_jenis' => 'CURANMOR',
                'nama_jenis' => 'Pencurian Kendaraan Bermotor',
                'deskripsi' => 'Tindak pidana pencurian kendaraan bermotor roda dua maupun roda empat dengan berbagai modus operandi.',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kode_jenis' => 'NARKOBA',
                'nama_jenis' => 'Penyalahgunaan Narkotika dan Obat Terlarang',
                'deskripsi' => 'Kasus yang berkaitan dengan narkotika, psikotropika, dan zat adiktif lainnya baik penyalahgunaan maupun peredaran gelap.',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kode_jenis' => 'CURAT',
                'nama_jenis' => 'Pencurian dengan Pemberatan',
                'deskripsi' => 'Tindak pidana pencurian yang dilakukan dengan kekerasan atau ancaman kekerasan, membawa senjata, atau dilakukan secara berkelompok.',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kode_jenis' => 'TIPIKOR',
                'nama_jenis' => 'Tindak Pidana Korupsi',
                'deskripsi' => 'Kasus korupsi yang merugikan keuangan negara atau perekonomian negara, termasuk suap, penggelapan, dan penyalahgunaan wewenang.',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kode_jenis' => 'PENIPUAN',
                'nama_jenis' => 'Penipuan dan Penggelapan',
                'deskripsi' => 'Tindak pidana penipuan dalam berbagai bentuk termasuk penipuan online, investasi bodong, dan penggelapan dana.',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kode_jenis' => 'KAMTIBMAS',
                'nama_jenis' => 'Gangguan Keamanan dan Ketertiban Masyarakat',
                'deskripsi' => 'Kasus-kasus yang mengganggu keamanan dan ketertiban masyarakat seperti perkelahian, vandalisme, dan gangguan ketentraman.',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kode_jenis' => 'LAKALANTAS',
                'nama_jenis' => 'Kecelakaan Lalu Lintas',
                'deskripsi' => 'Kasus kecelakaan lalu lintas yang mengakibatkan kerugian material, luka-luka, atau kematian.',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kode_jenis' => 'ASUSILA',
                'nama_jenis' => 'Tindak Pidana Kesusilaan',
                'deskripsi' => 'Kasus-kasus yang berkaitan dengan pelanggaran kesusilaan dan norma-norma sosial dalam masyarakat.',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kode_jenis' => 'CYBER',
                'nama_jenis' => 'Kejahatan Siber',
                'deskripsi' => 'Tindak pidana yang dilakukan melalui media elektronik dan internet seperti hacking, carding, dan penyebaran konten ilegal.',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Clear existing data
        $this->db->table('jenis_kasus')->where('id >', 0)->delete();

        // Insert new data
        $this->db->table('jenis_kasus')->insertBatch($data);

        echo "Data jenis kasus berhasil di-seed!\n";
    }
}
