<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKepalaDesaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true],
            'nama'        => ['type' => 'VARCHAR', 'constraint' => '100'],
            'periode'     => ['type' => 'VARCHAR', 'constraint' => '50'], // Contoh: 2010 - 2016
            'foto'        => ['type' => 'VARCHAR', 'constraint' => '255', 'default' => 'default.jpg'],
            'jabatan'     => ['type' => 'VARCHAR', 'constraint' => '50', 'default' => 'Kepala Desa'],
            'status'      => ['type' => 'ENUM', 'constraint' => ['aktif', 'mantan'], 'default' => 'mantan'],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('kepala_desa');
    }

    public function down()
    {
        //
    }
}
