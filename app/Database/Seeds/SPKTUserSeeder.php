<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SPKTUserSeeder extends Seeder
{
    public function run()
    {
        // Check if SPKT user already exists
        $existingUser = $this->db->table('users')->where('role', 'spkt')->get()->getRowArray();

        if (!$existingUser) {
            $data = [
                'username' => 'spkt01',
                'email' => 'spkt@polseklunangsilaut.id',
                'password' => password_hash('spkt123', PASSWORD_DEFAULT),
                'fullname' => 'SPKT Polsek Lunang Silaut',
                'nrp' => '12345678901',
                'role' => 'spkt',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $this->db->table('users')->insert($data);
            echo "User SPKT berhasil dibuat!\n";
            echo "Username: spkt01\n";
            echo "Password: spkt123\n";
        } else {
            echo "User SPKT sudah ada: " . $existingUser['username'] . "\n";
        }
    }
}
