<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePiketDetailTable extends Migration
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
            'piket_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'anggota_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
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

        // Foreign key constraints
        $this->forge->addForeignKey('piket_id', 'piket', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('anggota_id', 'anggota', 'id', 'CASCADE', 'CASCADE');

        // Unique constraint untuk mencegah duplikat anggota dalam satu piket
        $this->forge->addUniqueKey(['piket_id', 'anggota_id']);

        $this->forge->createTable('piket_detail');
    }

    public function down()
    {
        $this->forge->dropTable('piket_detail');
    }
}
