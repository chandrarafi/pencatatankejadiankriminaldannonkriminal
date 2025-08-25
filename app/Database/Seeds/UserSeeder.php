<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Data default users untuk setiap role
        $data = [
            [
                'username'   => 'spkt_admin',
                'email'      => 'spkt@polsek.lunangsilaut.id',
                'password'   => password_hash('password123', PASSWORD_DEFAULT),
                'fullname'   => 'SPKT Administrator',
                'nrp'        => '12345678901',
                'role'       => 'spkt',
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'kasium_admin',
                'email'      => 'kasium@polsek.lunangsilaut.id',
                'password'   => password_hash('password123', PASSWORD_DEFAULT),
                'fullname'   => 'Kasium Administrator',
                'nrp'        => '12345678902',
                'role'       => 'kasium',
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'reskrim_admin',
                'email'      => 'reskrim@polsek.lunangsilaut.id',
                'password'   => password_hash('password123', PASSWORD_DEFAULT),
                'fullname'   => 'Reskrim Administrator',
                'nrp'        => '12345678903',
                'role'       => 'reskrim',
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'kapolsek_admin',
                'email'      => 'kapolsek@polsek.lunangsilaut.id',
                'password'   => password_hash('password123', PASSWORD_DEFAULT),
                'fullname'   => 'Kapolsek Administrator',
                'nrp'        => '12345678904',
                'role'       => 'kapolsek',
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Hapus data lama jika ada (untuk development)
        $this->db->table('users')->delete();

        // Insert data users
        $this->db->table('users')->insertBatch($data);

        // Output informasi
        echo "✓ Data default users berhasil di-seed:\n";
        echo "  - SPKT: spkt_admin / password123\n";
        echo "  - Kasium: kasium_admin / password123\n";
        echo "  - Reskrim: reskrim_admin / password123\n";
        echo "  - Kapolsek: kapolsek_admin / password123\n";
    }
}
