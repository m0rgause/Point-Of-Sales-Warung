<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProduk extends Migration
{
	public function up()
	{
        $this->forge->addField('produk_id uuid DEFAULT uuid_generate_v4() PRIMARY KEY');
        $this->forge->addField([
            'kategori_produk_id' => [
                'type' => 'uuid'
            ],
            'nama_produk' => [
                'type' => 'varchar',
                'constraint' => 50
            ],
            'foto_produk' => [
                'type' => 'varchar',
                'constraint' => 20
            ],
            'status_produk' => [
                'type' => 'varchar',
                'constraint' => 9
            ],
            'waktu_buat' => [
                'type' => 'timestamp'
            ]
        ]);
        $this->forge->addForeignKey('kategori_produk_id','kategori_produk','kategori_produk_id','NO ACTION','RESTRICT');
        $this->forge->createTable('produk');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('produk');
	}
}
