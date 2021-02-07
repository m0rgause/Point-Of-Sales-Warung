<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ProductModel;
use App\Models\ProductPriceModel;

class Cashier extends Controller
{
    protected $helpers = ['form'];
    private const BESTSELLER_PRODUCT_LIMIT = 4;
    private const PRODUCT_LIMIT = 4;

    public function __construct()
    {
        $this->product_model = new ProductModel();
        $this->product_price_model = new ProductPriceModel();
    }

    private function remapDataProducts(array $products_db, bool $return_product_ids=false): ? array
    {
        $fmt = new \NumberFormatter('id_ID', \NumberFormatter::CURRENCY);
        $fmt->setAttribute(\NumberFormatter::FRACTION_DIGITS, 0);

        $product_ids = [];
        $products = [];
        foreach ($products_db as $index => $val) {
            // if product id exists in products ids
            if (in_array($val['produk_id'], $product_ids)) {
                // add product price to product exists in products array
                $products[array_search($val['produk_id'], $product_ids)]['product_price'][] = [
                    'product_price_id' => $val['harga_produk_id'],
                    'product_magnitude' => $val['besaran_produk'],
                    'product_price' => $fmt->formatCurrency($val['harga_produk'], 'IDR')
                ];
            } else {
                // note product id to product_ids variabel, for fast check is product exists in products array
                $product_ids[] = $val['produk_id'];

                // add new data product
                $products[] = [
                    'product_price' => [
                        [
                            'product_price_id' => $val['harga_produk_id'],
                            'product_magnitude' => $val['besaran_produk'],
                            'product_price' => $fmt->formatCurrency($val['harga_produk'], 'IDR')
                        ],
                    ],
                    'product_id' => $val['produk_id'],
                    'product_name' => $val['nama_produk'],
                    'product_photo' => $val['foto_produk'],
                    'category_name' => $val['nama_kategori_produk'],
                    'number_product' => $val['jumlah_produk']
                ];
            }
        }

        if ($return_product_ids === true) {
            return ['products' => $products, 'product_ids' => $product_ids];
        }
        return $products;
    }

    public function index()
    {
        $bestseller_products_remapped = $this->remapDataProducts($this->product_model->getBestsellerProducts(static::BESTSELLER_PRODUCT_LIMIT), true);
        $bestseller_products = $bestseller_products_remapped['products'];
        $product_ids = $bestseller_products_remapped['product_ids'];

        $products_remapped = $this->remapDataProducts($this->product_model->getProductsForCashier($product_ids, static::PRODUCT_LIMIT));

        $data['bestseller_products'] = $bestseller_products;
        $data['products_db'] = $products_remapped;
        $data['product_total'] = $this->product_model->countAllProductForCashier();
        $data['product_limit'] = static::PRODUCT_LIMIT;
        $data['bestseller_product_limit'] = static::BESTSELLER_PRODUCT_LIMIT;

        return view('cashier/cashier', $data);
    }

    public function showProductSearches()
    {
        $keyword = $this->request->getPost('keyword', FILTER_SANITIZE_STRING);
        $product_remapped = $this->remapDataProducts($this->product_model->getProductSearchesForCashier(static::PRODUCT_LIMIT, $keyword));

        // get product search total
        $product_search_total = $this->product_model->countAllProductSearchForCashier($keyword);

        echo json_encode([
            'products_db' => $product_remapped,
            'product_search_total' => $product_search_total,
            'product_limit' => static::PRODUCT_LIMIT,
            'csrf_value' => csrf_hash()
        ]);
        return true;
    }
}
