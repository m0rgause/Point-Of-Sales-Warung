<?php namespace App\Models;

use CodeIgniter\Model;

class CategoryProductModel extends Model
{
    public $table = 'kategori_produk';
    protected $primaryKey = 'kategori_produk_id';
    protected $allowedFields = ['nama_kategori_produk','waktu_buat'];
}
