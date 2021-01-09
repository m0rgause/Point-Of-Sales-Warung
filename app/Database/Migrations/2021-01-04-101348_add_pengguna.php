<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPengguna extends Migration
{
	public function up()
    {
        $this->forge->addField('pengguna_id uuid DEFAULT uuid_generate_v4() PRIMARY KEY');
        $this->forge->addField([
            'nama_lengkap' => [
                'type' => 'varchar',
                'constraint' => 32
            ],
            'username' => [
                'type' => 'varchar',
                'constraint' => 32
            ],
            'tingkat' => [
                'type' => 'varchar',
                'constraint' => 5
            ],
            'password' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'sign_in_terakhir' => [
                'type' => 'timestamp',
                'null' => true
            ]
        ]);
        $this->forge->createTable('pengguna');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('pengguna');
	}
}
