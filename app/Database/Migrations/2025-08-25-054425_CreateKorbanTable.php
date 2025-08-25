<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKorbanTable extends Migration
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
            'status_korban' => [
                'type' => 'ENUM',
                'constraint' => ['hidup', 'meninggal', 'hilang', 'luka'],
                'default' => 'hidup',
            ],
            'keterangan_luka' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'hubungan_pelaku' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
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
        $this->forge->createTable('korban');
    }

    public function down()
    {
        $this->forge->dropTable('korban');
    }
}
