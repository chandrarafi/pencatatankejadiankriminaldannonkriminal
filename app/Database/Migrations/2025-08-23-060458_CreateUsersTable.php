<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'unique'     => true,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'unique'     => true,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'fullname' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'nrp' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['spkt', 'kasium', 'reskrim', 'kapolsek'],
                'default'    => 'spkt',
            ],
            'is_active' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('users');

        // Insert default users untuk setiap role
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

        $this->db->table('users')->insertBatch($data);
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
