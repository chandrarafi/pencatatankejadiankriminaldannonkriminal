<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveAnggotaIdFromPiketTable extends Migration
{
    public function up()
    {
        // Drop foreign key constraint first
        if ($this->db->DBDriver === 'MySQLi') {
            $this->forge->dropForeignKey('piket', 'piket_anggota_id_foreign');
        }

        // Drop the anggota_id column
        $this->forge->dropColumn('piket', 'anggota_id');
    }

    public function down()
    {
        // Add back the anggota_id column
        $this->forge->addColumn('piket', [
            'anggota_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'after'      => 'id'
            ]
        ]);

        // Add back foreign key constraint
        if ($this->db->DBDriver === 'MySQLi') {
            $this->forge->addForeignKey('anggota_id', 'anggota', 'id', 'CASCADE', 'CASCADE');
        }
    }
}
