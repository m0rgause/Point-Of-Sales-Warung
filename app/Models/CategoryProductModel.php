<?php namespace App\Models;

use CodeIgniter\Model;

class CategoryProductModel extends Model
{
    public $table = 'kategori_produk';
    protected $primaryKey = 'kategori_produk_id';
    protected $allowedFields = ['nama_kategori_produk','waktu_buat'];

    public function findCategoryProduct(string $category_product_id): ? array
    {
        return $this->select('nama_kategori_produk')->getWhere(['kategori_produk_id' => $category_product_id])->getRowArray();
    }

    public function removeCategoryProduct(string $category_product_id): bool
    {
        try {
            $this->delete($category_product_id);
        } catch(\ErrorException $e) {
            return false;
        }
        return true;
    }

    public function getCategoryProductForFormSelect(): array
    {
        return $this->select('kategori_produk_id, nama_kategori_produk')->get()->getResultArray();
    }
}
