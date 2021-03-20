<?php

namespace App\Controllers;

use App\Models\CategoryProductModel;
use App\Models\ProductModel;
use App\Models\ProductPriceModel;
use CodeIgniter\HTTP\Files\UploadedFile;
use App\Libraries\IndoTime;

class Product extends BaseController
{
    protected $helpers = ['form', 'active_menu', 'check_password_sign_in_user', 'generate_uuid'];
    private const PRODUCT_LIMIT = 50;

    public function __construct()
    {
        $this->session = session();
        $this->model = new ProductModel();
        $this->price_model = new ProductPriceModel();
        $this->indo_time = new IndoTime();
    }

    public function index()
    {
        $data['title'] = 'Produk . POSW';
        $data['page'] = 'produk';

        $data['product_total'] = $this->model->countAllProduct();
        $data['products_db'] = $this->model->getProducts(static::PRODUCT_LIMIT);
        $data['product_limit'] = static::PRODUCT_LIMIT;

        return view('product/product', $data);
    }

    public function createProduct()
    {
        $category_product_model = new CategoryProductModel;

        $data['category_products_db'] = $category_product_model->getCategoryProductsForFormSelect();
        $data['title'] = 'Buat Produk . POSW';
        $data['page'] = 'buat_produk';

        return view('product/create_product', $data);
    }

    private function generateDataInsertBatchProductPrice(string $product_id, array $product_magnitudes, array $product_prices): array
    {
        $data_insert = [];
        $count_product_magnitude = count($product_magnitudes);
        for ($i = 0; $i < $count_product_magnitude; $i++) {
            $data_insert[] = [
                'harga_produk_id' => generate_uuid(),
                'produk_id' => $product_id,
                'besaran_produk' => filter_var($product_magnitudes[$i], FILTER_SANITIZE_STRING),
                'harga_produk' => filter_var($product_prices[$i], FILTER_SANITIZE_STRING)
            ];
        }
        return $data_insert;
    }

    public function saveProductToDB()
    {
        if (!$this->validate([
            'category_product' => [
                'label' => 'Kategori produk',
                'rules' => 'required',
                'errors' => $this->generateIndoErrorMessages(['required'])
            ],
            'product_name' => [
                'label' => 'Nama produk',
                'rules' => 'required|max_length[50]|is_unique[produk.nama_produk]',
                'errors' => $this->generateIndoErrorMessages(['required','max_length','is_unique'])
            ],
            'product_status' => [
                'label' => 'Status Produk',
                'rules' => 'in_list[ada,tidak_ada]',
                'errors' => $this->generateIndoErrorMessages(['in_list'])
            ],
            'product_photo' => 'product_photo',
            'product_magnitudes' => 'product_magnitude',
            'product_prices' => 'product_price'
        ])) {
            // set validation errors message to flash session
            $this->session->setFlashData('form_errors', $this->setDelimiterMessage(
                '<small class="form-message form-message--danger">',
                '</small>',
                $this->validator->getErrors(),
                ['product_magnitudes', 'product_prices']
            ));

            return redirect()->back()->withInput();
        }

        // genearate new random name for product photo
        $product_photo_file = $this->request->getFile('product_photo');
        $product_photo_name = $product_photo_file->getRandomName();

        try {
            $this->model->db->transBegin();

            // insert product
            $this->model->insertReturning([
                'produk_id' => generate_uuid(),
                'kategori_produk_id' => $this->request->getPost('category_product', FILTER_SANITIZE_STRING),
                'nama_produk' => $this->request->getPost('product_name', FILTER_SANITIZE_STRING),
                'foto_produk' => $product_photo_name,
                'status_produk' => $this->request->getPost('product_status', FILTER_SANITIZE_STRING),
                'waktu_buat' => date('Y-m-d H:i:s')
            ], 'produk_id');

            // insert product price
            $produk_id = $this->model->getInsertReturned();
            $data_product_price = $this->generateDataInsertBatchProductPrice(
                $produk_id,
                $this->request->getPost('product_magnitudes'),
                $this->request->getPost('product_prices')
            );
            $this->price_model->insertBatch($data_product_price);

            $this->model->transCommit();
            $process = true;

        } catch (\ErrorException $e) {
            $this->model->transRollback();
            $process = false;
        }

        // if insert product and insert product price success
        if ($process === true) {
            // move product photo
            $product_photo_file->move('dist/images/product_photo', $product_photo_name);

            return redirect()->to('/admin/produk');
        }

        // make error message
        $this->session->setFlashData('form_errors', $this->setDelimiterMessage(
            '<div class="alert alert--warning mb-3"><span class="alert__icon"></span><p>',
            '</p><a class="alert__close" href="#"></a></div>',
            ['create_product' => '<strong>Peringatan</strong>, Produk gagal dibuat. Silahkan coba kembali!']
        ));
        return redirect()->back()->withInput();
    }

    public function showProductDetail()
    {
        $product_id = $this->request->getPost('product_id', FILTER_SANITIZE_STRING);
        $product_prices = $this->price_model->getProductPrices($product_id, 'harga_produk, besaran_produk');
        $product_photo = $this->model->findProduct($product_id, 'foto_produk')['foto_produk']??null;

        return json_encode(['product_prices'=>$product_prices, 'product_photo'=>$product_photo, 'csrf_value'=>csrf_hash()]);
    }

    public function showProductSearches()
    {
        $keyword = $this->request->getPost('keyword', FILTER_SANITIZE_STRING);
        $products_db = $this->model->getProductSearches(static::PRODUCT_LIMIT, $keyword);

        // convert timestamp
        $count_products_db = count($products_db);
        for ($i = 0; $i < $count_products_db; $i++) {
            $products_db[$i]['indo_create_time'] = $this->indo_time->toIndoLocalizedString($products_db[$i]['waktu_buat']);
        }

        // get product search total
        $product_search_total = $this->model->countAllProductSearch($keyword);

        return json_encode([
            'products_db' => $products_db,
            'product_search_total' => $product_search_total,
            'product_limit' => static::PRODUCT_LIMIT,
            'csrf_value' => csrf_hash()
        ]);
    }

    public function updateProduct(string $product_id)
    {
        $category_product_model = new CategoryProductModel;

        $product_id = filter_var($product_id, FILTER_SANITIZE_STRING);

        $data['title'] = 'Perbaharui Produk . POSW';
        $data['page'] = 'perbaharui_produk';
        $data['product_id'] = $product_id;
        $data['product_db'] = $this->model->findProduct($product_id, 'kategori_produk_id,nama_produk,status_produk,foto_produk');
        $data['product_prices_db'] = $this->price_model->getProductPrices($product_id, 'harga_produk_id, besaran_produk, harga_produk');
        $data['category_products_db'] = $category_product_model->getCategoryProductsForFormSelect();

        return view('product/update_product', $data);
    }

    private function splitProductPriceCreateUpdate(array $product_price_ids, array $product_magnitudes, array $product_prices)
    {
        $data_product_magnitude_update = [];
        $data_product_price_update = [];
        $data_product_magnitude_insert = [];
        $data_product_price_insert = [];

        $count_product_magnitude = count($product_magnitudes);
        for ($i = 0; $i < $count_product_magnitude; $i++) {
            // if product_price_id exists
            if (isset($product_price_ids[$i])) {
                $data_product_magnitude_update[] = $product_magnitudes[$i];
                $data_product_price_update[] = $product_prices[$i];
            } else {
                $data_product_magnitude_insert[] = $product_magnitudes[$i];
                $data_product_price_insert[] = $product_prices[$i];
            }
        }

        return [
            'data_product_magnitude_update' => $data_product_magnitude_update,
            'data_product_price_update' => $data_product_price_update,
            'data_product_magnitude_insert' => $data_product_magnitude_insert,
            'data_product_price_insert' => $data_product_price_insert
        ];
    }

    private function generateDataUpdateBatchProductPrice(array $product_price_ids, array $product_magnitudes, array $product_prices): array
    {
        $data_update = [];
        $count_product_magnitude = count($product_magnitudes);
        for ($i = 0; $i < $count_product_magnitude; $i++) {
            $data_update[] = [
                'harga_produk_id' => filter_var($product_price_ids[$i], FILTER_SANITIZE_STRING),
                'besaran_produk' => filter_var($product_magnitudes[$i], FILTER_SANITIZE_STRING),
                'harga_produk' => filter_var($product_prices[$i], FILTER_SANITIZE_STRING)
            ];
        }
        return $data_update;
    }

    public function updateProductInDB()
    {
        // generate data validate
        $data_validate = [
            'category_product' => [
                'label' => 'Kategori produk',
                'rules' => 'required',
                'errors' => $this->generateIndoErrorMessages(['required'])
            ],
            'product_name' => [
                'label' => 'Nama produk',
                'rules' => 'required|max_length[50]',
                'errors' => $this->generateIndoErrorMessages(['required','max_length'])
            ],
            'product_status' => [
                'label' => 'Status Produk',
                'rules' => 'in_list[ada,tidak_ada]',
                'errors' => $this->generateIndoErrorMessages(['in_list'])
            ],
            'product_magnitudes' => 'product_magnitude',
            'product_prices' => 'product_price'
        ];

        $product_photo_file = $this->request->getFile('product_photo');
        // if exists product photo
        if ($product_photo_file->getError() !== 4) {
            $data_validate = array_merge($data_validate, ['product_photo' => 'product_photo']);
        }

        // validate data
        if (!$this->validate($data_validate)) {
            // set validation errors message to flash session
            $this->session->setFlashData('form_errors', $this->setDelimiterMessage(
                '<small class="form-message form-message--danger">',
                '</small>',
                $this->validator->getErrors(),
                ['product_magnitudes', 'product_prices']
            ));

            return redirect()->back()->withInput();
        }

        $product_id = $this->request->getPost('product_id', FILTER_SANITIZE_STRING);
        // generate data update product
        $data_update_product = [
            'kategori_produk_id' => $this->request->getPost('category_product', FILTER_SANITIZE_STRING),
            'nama_produk' => $this->request->getPost('product_name', FILTER_SANITIZE_STRING),
            'status_produk' => $this->request->getPost('product_status', FILTER_SANITIZE_STRING),
            'waktu_buat' => date('Y-m-d H:i:s')
        ];

        // if exists product photo
        if ($product_photo_file->getError() !== 4) {
            // genearate new random name for product photo
            $product_photo_name = $product_photo_file->getRandomName();

            $data_update_product = array_merge($data_update_product, ['foto_produk' => $product_photo_name]);
        }

        $product_price_ids = $this->request->getPost('product_price_ids');
        // split product price create and product price update
        $split_product_price = $this->splitProductPriceCreateUpdate(
            $product_price_ids,
            $this->request->getPost('product_magnitudes'),
            $this->request->getPost('product_prices')
        );

        $data_product_magnitude_update = $split_product_price['data_product_magnitude_update'];
        $data_product_price_update = $split_product_price['data_product_price_update'];
        $data_product_magnitude_insert = $split_product_price['data_product_magnitude_insert'];
        $data_product_price_insert = $split_product_price['data_product_price_insert'];

        // generate data product price update and create
        $data_product_price_update = $this->generateDataUpdateBatchProductPrice(
            $product_price_ids,
            $data_product_magnitude_update,
            $data_product_price_update
        );

        $data_product_price_insert = $this->generateDataInsertBatchProductPrice(
            $product_id,
            $data_product_magnitude_insert,
            $data_product_price_insert
        );

        try {
            $this->model->transBegin();

            // update product
            $this->model->update($product_id, $data_update_product);
            // update product price
            $this->price_model->updateBatch($data_product_price_update, 'harga_produk_id');
            // insert product price
            if (count($data_product_price_insert) > 0) {
                $this->price_model->insertBatch($data_product_price_insert);
            }

            $this->model->transCommit();
            $process = true;

        } catch (\ErrorException $e) {
            $this->model->transRollback();
            $process = false;
        }

        // if update product and update product price success and insert product price success
        if ($process === true) {
            // if exists product photo
            if ($product_photo_file->getError() === 0) {
                // move product photo
                $product_photo_file->move('dist/images/product_photo', $product_photo_name);
                // remove old product photo
                $old_product_photo = $this->request->getPost('old_product_photo');
                if (file_exists('dist/images/product_photo/'.$old_product_photo)) {
                    unlink('dist/images/product_photo/'.$old_product_photo);
                }
            }

            // make success message
            $this->session->setFlashData('form_success', $this->setDelimiterMessage(
                '<div class="alert alert--success mb-3"><span class="alert__icon"></span><p>',
                '</p><a class="alert__close" href="#"></a></div>',
                ['update_product' => '<strong>Berhasil</strong>, Produk telah diperbaharui.']
            ));

            return redirect()->back();
        }

        // make error message
        $this->session->setFlashData('form_errors', $this->setDelimiterMessage(
            '<div class="alert alert--warning mb-3"><span class="alert__icon"></span><p>',
            '</p><a class="alert__close" href="#"></a></div>',
            ['update_product' => '<strong>Peringatan</strong>, Produk gagal diperbaharui. Silahkan coba kembali!']
        ));
        return redirect()->back();
    }

    public function removeProductPriceInDB()
    {
        $product_price_id = $this->request->getPost('product_price_id', FILTER_SANITIZE_STRING);
        if ($this->price_model->removeProductPrice($product_price_id) > 0) {
            return json_encode(['success'=>true, 'csrf_value'=>csrf_hash()]);
        }

        $error_message = 'Gagal menghapus harga produk, cek apakah masih ada transaksi yang terhubung!';
        return json_encode(['success'=>false, 'error_message'=>$error_message, 'csrf_value'=>csrf_hash()]);
    }

    public function removeProductsInDB()
    {
        $product_ids = explode(',',$this->request->getPost('product_ids', FILTER_SANITIZE_STRING));
        $photo_products = $this->model->findProducts($product_ids, 'foto_produk');
        // remove product
        if ($this->model->removeProducts($product_ids) > 0) {
            // remove photo product
            foreach($photo_products as $p) {
                if (file_exists('dist/images/product_photo/'.$p['foto_produk'])) {
                    unlink('dist/images/product_photo/'.$p['foto_produk']);
                }
            }

            $count_product_id = count($product_ids);
            $smallest_create_time = $this->request->getPost('smallest_create_time');
            $keyword = $this->request->getPost('keyword', FILTER_SANITIZE_STRING);

            // if keyword !== null
            if ($keyword !== null) {
                // product total
                $product_total = $this->model->countAllProductSearch($keyword);
                // get longer product
                $longer_products = $this->model->getLongerProductSearches($count_product_id, $smallest_create_time, $keyword);

            } else {
                // product total
                $product_total = $this->model->countAllProduct();
                // get longer product
                $longer_products = $this->model->getLongerProducts($count_product_id, $smallest_create_time);
            }

            // add array indo create time to longer products array
            $count_longer_products = count($longer_products);
            for ($i = 0; $i < $count_longer_products; $i++) {
                $longer_products[$i]['indo_create_time'] = $this->indo_time->toIndoLocalizedString($longer_products[$i]['waktu_buat']);
            }

            return json_encode([
                'success' => true,
                'longer_products' => $longer_products,
                'product_total' => $product_total,
                'product_limit' => static::PRODUCT_LIMIT,
                'csrf_value' => csrf_hash()
            ]);
        }

        $error_message = 'Gagal menghapus produk, cek apakah masih ada transaksi yang terhubung!';
        return json_encode(['success'=>false, 'error_message'=>$error_message, 'csrf_value'=>csrf_hash()]);
    }
}
