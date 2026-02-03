<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCttToDataLjk extends Migration
{
    public function up()
    {
        $fields = [
            'ctt_uts' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'ctt_uas' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ];
        $this->forge->addColumn('data_ljk', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('data_ljk', 'ctt_uts');
        $this->forge->dropColumn('data_ljk', 'ctt_uas');
    }
}
