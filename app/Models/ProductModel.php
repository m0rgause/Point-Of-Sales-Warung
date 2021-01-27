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

    public function removeProduct(array $product_ids): bool
    {
        try {
            $this->whereIn('produk_id', $product_ids)->delete();
            return true;
        } catch (\ErrorException $e) {
            return false;
        }
    }

    public function getLongerProducts(int $limit, string $smallest_create_time): array
    {
        return $this->select('produk_id,nama_produk,status_produk,waktu_buat')
                    ->limit($limit)->orderBy('waktu_buat', 'DESC')->getWhere(['waktu_buat <' => $smallest_create_time])
                    ->getResultArray();
    }

    public function getLongerProductSearches(int $limit, string $smallest_create_time, string $match)
    {
         return $this->select('produk_id,nama_produk,status_produk,waktu_buat')
                     ->limit($limit)->orderBy('waktu_buat', 'DESC')->like('nama_produk',$match,'after')
                     ->getWhere(['waktu_buat <' => $smallest_create_time])->getResultArray();
    }

    public function findProducts(array $product_ids, string $column): array
    {
        return $this->select($column)->whereIn('produk_id', $product_ids)->get()->getResultArray();
    }
}
