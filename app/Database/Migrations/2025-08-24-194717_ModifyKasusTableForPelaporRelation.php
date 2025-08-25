<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyKasusTableForPelaporRelation extends Migration
{
    public function up()
    {
        // Add pelapor_id column
        $this->forge->addColumn('kasus', [
            'pelapor_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'prioritas'
            ]
        ]);

        // Add foreign key constraint
        $this->forge->addForeignKey('pelapor_id', 'pelapor', 'id', 'SET NULL', 'CASCADE', 'kasus');
    }

    public function down()
    {
        // Drop foreign key first
        if ($this->db->DBDriver === 'MySQLi') {
            $this->forge->dropForeignKey('kasus', 'kasus_pelapor_id_foreign');
        }

        // Drop column
        $this->forge->dropColumn('kasus', 'pelapor_id');
    }
}
