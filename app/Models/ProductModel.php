<?php namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    public $table = 'produk';
    protected $primaryKey = 'produk_id';
    protected $allowedFields = ['kategori_produk_id','nama_produk','foto_produk','status_produk','waktu_buat'];

    public function getProducts(int $limit, int $offset): array
    {
        return $this->select('produk_id,nama_produk,status_produk,waktu_buat')
                    ->orderBy('waktu_buat', 'DESC')->limit($limit, $offset)->get()->getResultArray();
    }

    public function getProductSearches(int $limit, int $offset, string $match): array
    {
        return $this->select('produk_id,nama_produk,status_produk,waktu_buat')
                    ->orderBy('waktu_buat', 'DESC')->limit($limit, $offset)
                    ->like('nama_produk',$match,'after')->get()->getResultArray();
    }

    public function countAllProduct(): int
    {
        return count($this->select('produk_id')->get()->getResultArray());
    }

    public function countAllProductSearch(string $match): int
    {
        return count($this->select('produk_id')->like('nama_produk',$match,'after')->get()->getResultArray());
    }

    public function findProduct(string $product_id, string $column): ? array
    {
        return $this->select($column)->getWhere(['produk_id'=>$product_id])->getRowArray();
    }
}
