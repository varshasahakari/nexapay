<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateUser extends Migration
{
    public function up()
    {
        $this->forge->addField(array(
            'id' => array(
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ),
            'name' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ),
            'gender' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ),
            'username' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => TRUE
            ),
            'password' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ),
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'deleted_at' => [
                'type'    => 'DATETIME',
                'null' => true,
            ],
        ));
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
