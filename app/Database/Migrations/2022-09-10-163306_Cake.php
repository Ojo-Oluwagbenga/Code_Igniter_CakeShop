<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Cake extends Migration
{
    public function up() {
        
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment'=> true,
            ],
            'price' => [
                'type' => 'FLOAT',
                'null' => true
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true
            ],
            'type' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'recipe' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'maker' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true
            ]

        ]);
        
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('cakes');
    }

    public function down()
    {
        $this->forge->dropTable('cakes');
    }
}
