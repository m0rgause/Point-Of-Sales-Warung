<?php namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    public $table = 'produk';
    protected $primaryKey = 'produk_id';
    protected $allowedFields = ['kategri_produk_id','nama_produk','foto_produk','status_produk','waktu_buat'];

    public function getProduct(int $limit, int $offset): array
    {
        return $this->select('produk_id,nama_produk,status_produk,waktu_buat')
                    ->orderBy('waktu_buat', 'DESC')->limit($limit, $offset)->get()->getResultArray();
    }

    public function getProductSearch(int $limit, int $offset, array $where): array
    {
        return $this->select('produk_id,nama_produk,status_produk,waktu_buat')
                    ->orderBy('waktu_buat', 'DESC')->limit($limit, $offset)->getWhere($where)->getResultArray();
    }

    public function countAllProduct(): int
    {
        return count($this->select('produk_id')->get()->getResultArray());
    }

    public function getProductPrice(string $product_id): array
    {
        $sql = 'SELECT harga_produk, besaran_produk FROM harga_produk where produk_id=:produk_id:';
        return $this->db->query($sql, ['produk_id'=>$product_id])->getResultArray();
    }

    public function findProduct(string $product_id, string $column): ? array
    {
        return $this->select($column)->getWhere(['produk_id'=>$product_id])->getRowArray();
    }
}
