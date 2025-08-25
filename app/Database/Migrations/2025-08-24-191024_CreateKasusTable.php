<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKasusTable extends Migration
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
            'nomor_kasus' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'unique'     => true,
            ],
            'jenis_kasus_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'judul_kasus' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'tanggal_kejadian' => [
                'type' => 'DATETIME',
            ],
            'lokasi_kejadian' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['dilaporkan', 'dalam_proses', 'selesai', 'ditutup'],
                'default'    => 'dilaporkan',
            ],
            'prioritas' => [
                'type'       => 'ENUM',
                'constraint' => ['rendah', 'sedang', 'tinggi', 'darurat'],
                'default'    => 'sedang',
            ],
            'pelapor_nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'pelapor_telepon' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'pelapor_alamat' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'petugas_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'created_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
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
        $this->forge->addForeignKey('jenis_kasus_id', 'jenis_kasus', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('petugas_id', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('created_by', 'users', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('kasus');
    }

    public function down()
    {
        $this->forge->dropTable('kasus');
    }
}
