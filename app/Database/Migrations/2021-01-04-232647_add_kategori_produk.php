<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKategoriProduk extends Migration
{
	public function up()
	{
        $this->forge->addField('kategori_produk_id UUID PRIMARY KEY');
        $this->forge->addField([
            'nama_kategori_produk' => [
                'type' => 'varchar',
                'constraint' => 20
            ],
            'waktu_buat' => [
                'type' => 'timestamp'
            ]
        ]);
        $this->forge->createTable('kategori_produk');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('kategori_produk');
	}
}
