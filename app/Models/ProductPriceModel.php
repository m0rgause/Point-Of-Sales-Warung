<?php namespace App\Models;

use CodeIgniter\Model;

class ProductPriceModel extends Model
{
    protected $table = 'harga_produk';
    protected $primaryKey = 'harga_produk_id';
    protected $allowedFields = ['harga_produk_id','produk_id','harga_produk','besaran_produk'];
    protected $useAutoIncrement = false;

    public function getProductPrices(string $product_id, string $column): array
    {
        return $this->select($column)->getWhere(['produk_id'=>$product_id])->getResultArray();
    }

    public function removeProductPrice(string $product_price_id): int
    {
        try {
            $this->delete($product_price_id);
            return $this->db->affectedRows();
        } catch (\ErrorException $e) {
            return 0;
        }
    }
}
