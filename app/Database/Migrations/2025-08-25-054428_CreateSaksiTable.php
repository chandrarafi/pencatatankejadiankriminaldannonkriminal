<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSaksiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'kasus_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'nik' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'jenis_kelamin' => [
                'type' => 'ENUM',
                'constraint' => ['L', 'P'],
            ],
            'umur' => [
                'type' => 'INT',
                'constraint' => 3,
                'null' => true,
            ],
            'alamat' => [
                'type' => 'TEXT',
            ],
            'pekerjaan' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'telepon' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'jenis_saksi' => [
                'type' => 'ENUM',
                'constraint' => ['korban', 'ahli', 'fakta', 'de_auditu'],
                'default' => 'fakta',
            ],
            'hubungan_dengan_korban' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'hubungan_dengan_tersangka' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'keterangan_kesaksian' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'dapat_dihubungi' => [
                'type' => 'ENUM',
                'constraint' => ['ya', 'tidak'],
                'default' => 'ya',
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
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
        $this->forge->addForeignKey('kasus_id', 'kasus', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('saksi');
    }

    public function down()
    {
        $this->forge->dropTable('saksi');
    }
}
