<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTimeLogTable extends Migration
{
    public function up()
    {
        $this->forge->addField([

            
    'id' => [
        'type' => 'INT',
        'constraint' => 11,
        'unsigned' => true,
        'auto_increment' => true,
    ],
    'user_id' => [
        'type' => 'INT',
        'constraint' => 11,
        'unsigned' => true,
    ],
    'task_type' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'null' => true,
    ],
    'duration' => [
        'type' => 'VARCHAR',
        'constraint' => 8,
        'null' => true,
    ],
    'task' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'null' => false,
    ],
    'project_name' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'null' => false,
    ],
    'status' => [
        'type' => 'VARCHAR',
        'constraint' => 50,
        'null' => false,
    ],
    'product' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'null' => false,
    ],
    'start_time' => [
        'type' => 'DATETIME',
        'null' => true,
    ],
    'end_time' => [
        'type' => 'DATETIME',
        'null' => true,
    ],
]);


            $this->forge->addPrimaryKey("id");
            $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');

            $this->forge->createTable("time_logs");
    }
    

    public function down()
    {
        $this->forge->dropTable("time_logs");
    }
}
