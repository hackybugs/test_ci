<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserEmploymentTable extends Migration {
    public function up() {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'company' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'position' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'years' => [
                'type'       => 'INT',
                'constraint' => 5,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('user_employment');
    }

    public function down() {
        $this->forge->dropTable('user_employment');
    }
}
