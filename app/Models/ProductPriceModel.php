<?php namespace App\Models;

use CodeIgniter\Model;

class ProductPriceModel extends Model
{
    public $table = 'harga_produk';
    protected $primaryKey = 'harga_produk_id';
    protected $allowedFields = ['produk_id','harga_produk','besaran_produk'];

    public function getProductPrices(string $product_id, string $column): array
    {
        return $this->select($column)->getWhere(['produk_id'=>$product_id])->getResultArray();
    }

    public function removeProductPrice(string $product_price_id): bool
    {
        try {
            $this->delete($product_price_id);
            return true;
        } catch (\ErrorException $e) {
            return false;
        }
    }
}
