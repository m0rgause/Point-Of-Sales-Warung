<?php namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    public $table = 'produk';
    protected $primaryKey = 'produk_id';
    protected $allowedFields = ['kategri_produk_id','nama_produk','foto_produk','status_produk','waktu_buat'];
}
