<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTransaksiDetail extends Migration
{
	public function up()
	{
	    $this->forge->addField('transaksi_detail_id uuid DEFAULT uuid_generate_v4() PRIMARY KEY');
        $this->forge->addField([
            'transaksi_id' => [
                'type' => 'uuid'
            ],
            'harga_produk_id' => [
                'type' => 'uuid',
            ],
            'jumlah_produk' => [
                'type' => 'int',
                'constraint' => 11
            ]
        ]);
        $this->forge->addForeignKey('transaksi_id','transaksi','transaksi_id','NO ACTION','CASCADE');
        $this->forge->addForeignKey('harga_produk_id','harga_produk','harga_produk_id','NO ACTION','RESTRICT');
        $this->forge->createTable('transaksi_detail');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('transaksi_detail');
	}
}
