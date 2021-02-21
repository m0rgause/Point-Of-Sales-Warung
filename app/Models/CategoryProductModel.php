<?php namespace App\Models;

use CodeIgniter\Model;

class CategoryProductModel extends Model
{
    protected $table = 'kategori_produk';
    protected $primaryKey = 'kategori_produk_id';
    protected $allowedFields = ['kategori_produk_id','nama_kategori_produk','waktu_buat'];
    protected $useAutoIncrement = false;

    public function findCategoryProduct(string $category_product_id): ? array
    {
        return $this->select('nama_kategori_produk')->getWhere(['kategori_produk_id' => $category_product_id])->getRowArray();
    }

    public function removeCategoryProduct(string $category_product_id): int
    {
        try {
            $this->delete($category_product_id);
            return $this->db->affectedRows();
        } catch(\ErrorException $e) {
            return 0;
        }
    }

    public function getCategoryProductsForFormSelect(): array
    {
        return $this->select('kategori_produk_id, nama_kategori_produk')->get()->getResultArray();
    }
}
