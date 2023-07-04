<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Lansia extends Migration
{
    public function up()
    {
        $this->forge->addField([
            
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('lansia');
    }

    public function down()
    {
        $this->forge->dropTable('lansia');
    }
}
