<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTransaksi extends Migration
{
	public function up()
	{
        $this->forge->addField('transaksi_id uuid DEFAULT uuid_generate_v4() PRIMARY KEY');
        $this->forge->addField([
            'pengguna_id' => [
                'type' => 'uuid'
            ],
            'status_transaksi' => [
                'type' => 'varchar',
                'constraint' => 7
            ],
            'waktu_buat' => [
                'type' => 'timestamp'
            ]
        ]);
        $this->forge->addForeignKey('pengguna_id','pengguna','pengguna_id','NO ACTION','RESTRICT');
        $this->forge->createTable('transaksi');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('transaksi');
	}
}
