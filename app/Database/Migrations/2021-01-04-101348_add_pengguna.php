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
                'constraint' => 255
            ],
            'login_terakhir' => [
                'type' => 'timestamp'
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
