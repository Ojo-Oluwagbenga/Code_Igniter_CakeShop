<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
    public function up() {
        
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment'=> true,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true
            ],
            'password' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'apikey' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true
            ],

        ]);
        
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}