<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKeteranganToKasusTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('kasus', [
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'pelapor_alamat'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('kasus', 'keterangan');
    }
}
