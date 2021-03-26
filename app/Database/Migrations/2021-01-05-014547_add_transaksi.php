<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTransaksi extends Migration
{
	public function up()
	{
        $this->forge->addField('transaksi_id UUID PRIMARY KEY');
        $this->forge->addField([
            'pengguna_id' => [
                'type' => 'uuid',
            ],
            'status_transaksi' => [
                'type' => 'varchar',
                'constraint' => 7
            ],
            'uang_pembeli' => [
                'type' => 'numeric',
                'constraint' => 10,
                'null' => true
            ],
            'waktu_buat' => [
                'type' => 'timestamp',
                'null' => true
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
