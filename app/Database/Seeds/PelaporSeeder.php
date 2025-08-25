<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PelaporSeeder extends Seeder
{
    public function run()
    {
        // Get user SPKT ID untuk created_by
        $spktUser = $this->db->table('users')->where('role', 'spkt')->get()->getRowArray();
        $createdBy = $spktUser ? $spktUser['id'] : 1;

        $data = [
            [
                'nama' => 'Siti Aminah',
                'nik' => '1371054512850001',
                'telepon' => '082187654321',
                'email' => 'siti.aminah@gmail.com',
                'alamat' => 'Jl. Mawar No. 15 RT 02 RW 01',
                'kelurahan' => 'Koto Baru',
                'kecamatan' => 'Lunang Silaut',
                'kota_kabupaten' => 'Kabupaten Pesisir Selatan',
                'provinsi' => 'Sumatera Barat',
                'kode_pos' => '25611',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '1985-12-05',
                'pekerjaan' => 'Ibu Rumah Tangga',
                'keterangan' => 'Pelapor kasus pencurian sepeda motor',
                'is_active' => 1,
                'created_by' => $createdBy,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nama' => 'Ahmad Fauzi',
                'nik' => '1371051234567890',
                'telepon' => '081234567890',
                'email' => 'ahmad.fauzi@yahoo.com',
                'alamat' => 'Jorong Pasar, RT 01 RW 02',
                'kelurahan' => 'Lunang',
                'kecamatan' => 'Lunang Silaut',
                'kota_kabupaten' => 'Kabupaten Pesisir Selatan',
                'provinsi' => 'Sumatera Barat',
                'kode_pos' => '25611',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1978-03-15',
                'pekerjaan' => 'Pedagang',
                'keterangan' => 'Korban penipuan investasi online',
                'is_active' => 1,
                'created_by' => $createdBy,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nama' => 'Ratna Sari',
                'nik' => '1371059876543210',
                'telepon' => '081398765432',
                'email' => null,
                'alamat' => 'Jorong Silaut Dalam RT 02 RW 01',
                'kelurahan' => 'Lunang Silaut',
                'kecamatan' => 'Lunang Silaut',
                'kota_kabupaten' => 'Kabupaten Pesisir Selatan',
                'provinsi' => 'Sumatera Barat',
                'kode_pos' => '25611',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '1990-07-20',
                'pekerjaan' => 'Buruh Tani',
                'keterangan' => 'Korban KDRT',
                'is_active' => 1,
                'created_by' => $createdBy,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nama' => 'Budi Santoso',
                'nik' => '1371051122334455',
                'telepon' => '085267891234',
                'email' => 'budi.santoso@outlook.com',
                'alamat' => 'Jorong Koto Tinggi RT 03 RW 01',
                'kelurahan' => 'Lunang',
                'kecamatan' => 'Lunang Silaut',
                'kota_kabupaten' => 'Kabupaten Pesisir Selatan',
                'provinsi' => 'Sumatera Barat',
                'kode_pos' => '25611',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1982-11-10',
                'pekerjaan' => 'Sopir',
                'keterangan' => 'Saksi kecelakaan lalu lintas',
                'is_active' => 1,
                'created_by' => $createdBy,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nama' => 'Dewi Sartika',
                'nik' => '1371056677889900',
                'telepon' => '087712345678',
                'email' => 'dewi.sartika@gmail.com',
                'alamat' => 'Jl. Merdeka No. 25 RT 01 RW 03',
                'kelurahan' => 'Koto Baru',
                'kecamatan' => 'Lunang Silaut',
                'kota_kabupaten' => 'Kabupaten Pesisir Selatan',
                'provinsi' => 'Sumatera Barat',
                'kode_pos' => '25611',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '1987-09-12',
                'pekerjaan' => 'Guru',
                'keterangan' => 'Pelapor gangguan ketertiban',
                'is_active' => 1,
                'created_by' => $createdBy,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nama' => 'Hendra Wijaya',
                'nik' => '1371053344556677',
                'telepon' => '081987654321',
                'email' => null,
                'alamat' => 'Jorong Pasar Lama RT 02 RW 02',
                'kelurahan' => 'Lunang',
                'kecamatan' => 'Lunang Silaut',
                'kota_kabupaten' => 'Kabupaten Pesisir Selatan',
                'provinsi' => 'Sumatera Barat',
                'kode_pos' => '25611',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1975-04-08',
                'pekerjaan' => 'Nelayan',
                'keterangan' => 'Korban pencurian alat tangkap ikan',
                'is_active' => 1,
                'created_by' => $createdBy,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Clear existing data
        $this->db->table('pelapor')->where('id >', 0)->delete();

        // Insert new data
        $this->db->table('pelapor')->insertBatch($data);

        echo "Data pelapor berhasil di-seed!\n";
    }
}
