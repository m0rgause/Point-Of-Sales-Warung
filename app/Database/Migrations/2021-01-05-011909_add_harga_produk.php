<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddHargaProduk extends Migration
{
	public function up()
	{
        $this->forge->addField('harga_produk_id UUID PRIMARY KEY');
        $this->forge->addField([
            'produk_id' => [
                'type' => 'uuid'
            ],
            'besaran_produk' => [
                'type' => 'varchar',
                'constraint' => 20
            ],
            'harga_produk' => [
                'type' => 'numeric',
                'constraint' => 10
            ]
        ]);
        $this->forge->addForeignKey('produk_id','produk','produk_id','NO ACTION','CASCADE');
        $this->forge->createTable('harga_produk');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('harga_produk');
	}
}
