<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePiketTable extends Migration
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
            'anggota_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'tanggal_piket' => [
                'type' => 'DATE',
            ],
            'shift' => [
                'type'       => 'ENUM',
                'constraint' => ['pagi', 'siang', 'malam'],
            ],
            'jam_mulai' => [
                'type' => 'TIME',
            ],
            'jam_selesai' => [
                'type' => 'TIME',
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['dijadwalkan', 'selesai', 'diganti', 'tidak_hadir'],
                'default'    => 'dijadwalkan',
            ],
            'lokasi_piket' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'default'    => 'Polsek Lunang Silaut',
            ],
            'created_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
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
        $this->forge->addForeignKey('anggota_id', 'anggota', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('created_by', 'users', 'id', 'SET NULL', 'SET NULL');
        $this->forge->createTable('piket');
    }

    public function down()
    {
        $this->forge->dropTable('piket');
    }
}
