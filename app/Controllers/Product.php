<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\CategoryProductModel;
use App\Models\POSWModel;
use App\Models\ProductModel;
use App\Models\ProductPriceModel;
use App\Libraries\ValidationMessage;
use CodeIgniter\HTTP\Files\UploadedFile;

class Product extends Controller
{
    protected $helpers = ['form', 'active_menu', 'check_password_sign_in_user'];
    private $product_limit = 35;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->model = new ProductModel();
        $this->model_price = new ProductPriceModel();
    }

    public function index()
    {
        $data['title'] = 'Produk . POSW';
        $data['page'] = 'produk';
        $data['products_db'] = $this->model->getProducts($this->product_limit, 0);

        $page_total = ceil($this->model->countAllProduct()/$this->product_limit);
        if ($page_total == 0) {
            $page_total = 1;
        }
        $data['page_total'] = $page_total;

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

    private function productPriceRules(array $product_magnitudes, array $product_prices): bool
    {
        $count_product_magnitude = count($product_magnitudes);
        for ($i = 0; $i < $count_product_magnitude; $i++) {
            // if empty magnitude
            if (empty(trim($product_magnitudes[$i]))) {
                $this->product_magnitude_errors[$i] = "Besaran tidak boleh kosong!";
            }
            // if magnitude more than 20 character
            elseif (strlen($product_magnitudes[$i]) > 20) {
                $this->product_magnitude_errors[$i] = "Besaran tidak bisa melebihi 20 karakter";
            }

            // if empty price
            if (empty(trim($product_prices[$i]))) {
                $this->product_price_errors[$i] = "Harga tidak boleh kosong!";
            }
            // if price more than 10 character
            elseif (strlen($product_prices[$i]) > 10) {
                $this->product_price_errors[$i] = "Harga tidak bisa melebihi 10 karakter";
            }
            // if price not a number
            elseif (!preg_match('/^\d+$/', $product_prices[$i])) {
                $this->product_price_errors[$i] = "Harga harus terdiri dari angka!";
            }
        }

        if (count($this->product_magnitude_errors??[]) > 0 || count($this->product_price_errors??[]) > 0) {
            return false;
        }
        return true;
    }

    private function productPhotoRules(UploadedFile $product_photo_file): bool
    {
        // if not file was uploaded
        if ($product_photo_file->getError() === 4) {
            $this->product_photo_error = "Tidak ada file yang diupload";
        }
        // if not valid file
        elseif (!$product_photo_file->isValid()) {
            $this->product_photo_error = "File yang diupload tidak benar";
        }
        // if size file exceed 1MB
        elseif ($product_photo_file->getSizeByUnit('mb') > 1) {
            $this->product_photo_error = "Ukuran file tidak bisa melebihi 1MB";
        }
        // if file extension not jpg or jpeg
        elseif (strtolower($product_photo_file->getExtension()) !== 'jpg' && strtolower($product_photo_file->getExtension()) !== 'jpeg') {
            $this->product_photo_error = "Ekstensi file harus .jpg atau .jpeg!";
        }
        // if file is valid
        elseif ($product_photo_file->isValid()) {
            return true;
        }

        return false;
    }

    private function generateDataInsertBatchProductPrice(string $product_id, array $product_magnitudes, array $product_prices): array
    {
        $data_insert = [];
        $count_product_magnitude = count($product_magnitudes);
        for ($i = 0; $i < $count_product_magnitude; $i++) {
            $data_insert[] = [
                'produk_id' => $product_id,
                'besaran_produk' => filter_var($product_magnitudes[$i], FILTER_SANITIZE_STRING),
                'harga_produk' => filter_var($product_prices[$i], FILTER_SANITIZE_STRING)
            ];
        }
        return $data_insert;
    }

    public function saveProductToDB()
    {
        $form_errors = [];

        if (!$this->validate([
            'category_product' => [
                'label' => 'Kategori produk',
                'rules' => 'required',
                'errors' => ValidationMessage::generateIndonesianErrorMessage('required')
            ],
            'product_name' => [
                'label' => 'Nama produk',
                'rules' => 'required|max_length[50]',
                'errors' => ValidationMessage::generateIndonesianErrorMessage('required','max_length')
            ],
            'product_status' => [
                'label' => 'Status Produk',
                'rules' => 'in_list[ada,tidak_ada]',
                'errors' => ValidationMessage::generateIndonesianErrorMessage('in_list')
            ]
        ])) {
            $form_errors = array_merge($form_errors, $this->validator->getErrors());
        }

        // product photo validation
        $product_photo_file = $this->request->getFile('product_photo');
        if ($this->productPhotoRules($product_photo_file) !== true) {
            $form_errors = array_merge($form_errors, ['product_photo' => $this->product_photo_error]);
        }

        // add delimiter to errors message
        $form_errors = ValidationMessage::setDelimiterMessage(
            '<small class="form-message form-message--danger">',
            '</small>',
            $form_errors
        );

        // product price validation
        $product_magnitudes = $this->request->getPost('product_magnitudes');
        $product_prices = $this->request->getPost('product_prices');

        if ($this->productPriceRules($product_magnitudes, $product_prices) !== true) {
            // if exists product magnitude error
            if (isset($this->product_magnitude_errors)) {
                $form_errors = array_merge($form_errors, ['product_magnitudes' => $this->product_magnitude_errors]);
            }
            // if exists product price error
            if (isset($this->product_price_errors)) {
                $form_errors = array_merge($form_errors, ['product_prices' => $this->product_price_errors]);
            }
        }

        // if exists form errors
        if (count($form_errors) > 0) {
            // set form errors to session flash data
            $this->session->setFlashData('form_errors', $form_errors);

            return redirect()->back()->withInput();
        }

        // genearate new random name for product photo
        $product_photo_name = $product_photo_file->getRandomName();

        $this->model->db->transStart();
        // insert product
        $posw_model_product = new POSWModel($this->model->db, $this->model->table);
        $insert_product = $posw_model_product->insertReturning([
            'kategori_produk_id' => $this->request->getPost('category_product', FILTER_SANITIZE_STRING),
            'nama_produk' => $this->request->getPost('product_name', FILTER_SANITIZE_STRING),
            'foto_produk' => $product_photo_name,
            'status_produk' => $this->request->getPost('product_status', FILTER_SANITIZE_STRING),
            'waktu_buat' => date('Y-m-d H:i:s')
        ], 'produk_id');

        // insert product price
        $produk_id = $posw_model_product->getInsertReturning()??'';
        $data_product_prices = $this->generateDataInsertBatchProductPrice($produk_id, $product_magnitudes, $product_prices);
        $posw_model_product_price = new POSWModel($this->model->db, 'harga_produk');
        $insert_product_price = $posw_model_product_price->insertBatch($data_product_prices);

        $this->model->db->transComplete();

        // if insert product and insert product price success
        if ($insert_product === true && $insert_product_price === true) {
            // move product photo
            $product_photo_file->move('dist/images/product_photo', $product_photo_name);

            return redirect()->to('/admin/produk');
        }

        // make error message
        ValidationMessage::setFlashMessage(
            'form_errors',
            '<div class="alert alert--warning mb-3"><span class="alert__icon"></span><p>',
            '</p><a class="alert__close" onclick="close_alert(event)" href="#"></a></div>',
            ['create_product' => '<strong>Peringatan</strong>, Produk gagal dibuat']
        );
        return redirect()->back()->withInput();
    }

    public function showProductDetail()
    {
        $product_id = $this->request->getPost('product_id', FILTER_SANITIZE_STRING);
        $product_prices = $this->model_price->getProductPrices($product_id, 'harga_produk, besaran_produk');
        $product_photo = $this->model->findProduct($product_id, 'foto_produk')['foto_produk']??null;

        echo json_encode(['product_prices'=>$product_prices, 'product_photo'=>$product_photo, 'csrf_value'=>csrf_hash()]);
        return true;
    }

    public function showPaginationProduct()
    {
        $page_position = $this->request->getPost('page', FILTER_SANITIZE_STRING);
        $product_offset = ($page_position * $this->product_limit) - $this->product_limit;
        $keyword = $this->request->getPost('keyword', FILTER_SANITIZE_STRING);

        // if keyword !== null
        if ($keyword !== null) {
            $products_db = $this->model->getProductSearches($this->product_limit, $product_offset, $keyword);
            // get total page
            $page_total = ceil($this->model->countAllProductSearch($keyword)/$this->product_limit);

        } else {
            $products_db = $this->model->getProducts($this->product_limit, $product_offset);
            // get total page
            $page_total = ceil($this->model->countAllProduct()/$this->product_limit);
        }

        // convert timestamp
        $date_time = new \App\Libraries\DateTime();
        $count_products_db = count($products_db);
        for ($i = 0; $i < $count_products_db; $i++) {
            $products_db[$i]['waktu_buat_indo'] = $date_time->convertTimstampToIndonesianDateTime($products_db[$i]['waktu_buat']);
        }

        echo json_encode(['products_db' => $products_db, 'page_total'=>$page_total, 'csrf_value'=>csrf_hash()]);
        return true;
    }

    public function showSearchProduct()
    {
        $keyword = $this->request->getPost('keyword', FILTER_SANITIZE_STRING);
        $products_db = $this->model->getProductSearches($this->product_limit, 0, $keyword);

        // convert timestamp
        $date_time = new \App\Libraries\DateTime();
        $count_products_db = count($products_db);
        for ($i = 0; $i < $count_products_db; $i++) {
            $products_db[$i]['waktu_buat_indo'] = $date_time->convertTimstampToIndonesianDateTime($products_db[$i]['waktu_buat']);
        }

        // get total page
        $page_total = ceil($this->model->countAllProductSearch($keyword)/$this->product_limit);

        echo json_encode(['products_db' => $products_db, 'page_total'=>$page_total, 'csrf_value'=>csrf_hash()]);
        return true;
    }

    public function updateProduct(string $product_id)
    {
        $category_product_model = new CategoryProductModel;

        $product_id = filter_var($product_id, FILTER_SANITIZE_STRING);

        $data['title'] = 'Perbaharui Produk . POSW';
        $data['page'] = 'perbaharui_produk';
        $data['product_id'] = $product_id;
        $data['product_db'] = $this->model->findProduct($product_id, 'kategori_produk_id,nama_produk,status_produk,foto_produk');
        $data['product_prices_db'] = $this->model_price->getProductPrices($product_id, 'harga_produk_id, besaran_produk, harga_produk');
        $data['category_products_db'] = $category_product_model->getCategoryProductsForFormSelect();

        return view('product/update_product', $data);
    }

    private function splitProductPriceCreateUpdate(array $product_price_ids, array $product_magnitudes, array $product_prices)
    {
        $product_magnitudes_update = [];
        $product_prices_update = [];
        $product_magnitudes_insert = [];
        $product_prices_insert = [];

        $count_product_magnitude = count($product_magnitudes);
        for ($i = 0; $i < $count_product_magnitude; $i++) {
            // if product_price_id exists
            if (isset($product_price_ids[$i])) {
                $product_magnitudes_update[] = $product_magnitudes[$i];
                $product_prices_update[] = $product_prices[$i];
            } else {
                $product_magnitudes_insert[] = $product_magnitudes[$i];
                $product_prices_insert[] = $product_prices[$i];
            }
        }

        return [
            'product_magnitudes_update' => $product_magnitudes_update,
            'product_prices_update' => $product_prices_update,
            'product_magnitudes_insert' => $product_magnitudes_insert,
            'product_prices_insert' => $product_prices_insert
        ];
    }

    private function generateDataUpdateBatchProductPrice(array $product_price_ids, array $product_magnitudes, array $product_prices): array
    {
        $data_update = [];
        $count_product_magnitude = count($product_magnitudes);
        for ($i = 0; $i < $count_product_magnitude; $i++) {
            $data_update[] = [
                'harga_produk_id' => $product_price_ids[$i],
                'besaran_produk' => filter_var($product_magnitudes[$i], FILTER_SANITIZE_STRING),
                'harga_produk' => filter_var($product_prices[$i], FILTER_SANITIZE_STRING)
            ];
        }
        return $data_update;
    }

    public function updateProductInDB()
    {
        $form_errors = [];

        if (!$this->validate([
            'category_product' => [
                'label' => 'Kategori produk',
                'rules' => 'required',
                'errors' => ValidationMessage::generateIndonesianErrorMessage('required')
            ],
            'product_name' => [
                'label' => 'Nama produk',
                'rules' => 'required|max_length[50]',
                'errors' => ValidationMessage::generateIndonesianErrorMessage('required','max_length')
            ],
            'product_status' => [
                'label' => 'Status Produk',
                'rules' => 'in_list[ada,tidak_ada]',
                'errors' => ValidationMessage::generateIndonesianErrorMessage('in_list')
            ]
        ])) {
            $form_errors = array_merge($form_errors, $this->validator->getErrors());
        }

        // product photo validation
        $product_photo_file = $this->request->getFile('product_photo');
        // if product photo exists and product photo rules false
        if ($product_photo_file->getError() !== 4 && $this->productPhotoRules($product_photo_file) !== true) {
            $form_errors = array_merge($form_errors, ['product_photo' => $this->product_photo_error]);
        }

        // add delimiter to errors message
        $form_errors = ValidationMessage::setDelimiterMessage(
            '<small class="form-message form-message--danger">',
            '</small>',
            $form_errors
        );

        // product price validation
        if ($this->productPriceRules($this->request->getPost('product_magnitudes'), $this->request->getPost('product_prices')) !== true) {
            // if exists product magnitude error
            if (isset($this->product_magnitude_errors)) {
                $form_errors = array_merge($form_errors, ['product_magnitudes' => $this->product_magnitude_errors]);
            }
            // if exists product price error
            if (isset($this->product_price_errors)) {
                $form_errors = array_merge($form_errors, ['product_prices' => $this->product_price_errors]);
            }
        }

        // if exists form errors
        if (count($form_errors) > 0) {
            // set form errors to session flash data
            $this->session->setFlashData('form_errors', $form_errors);

            return redirect()->back()->withInput();
        }

        $data_update_product = [];
        $product_id = $this->request->getPost('product_id',FILTER_SANITIZE_STRING);

        $data_update_product = array_merge($data_update_product, [
            'kategori_produk_id' => $this->request->getPost('category_product', FILTER_SANITIZE_STRING),
            'nama_produk' => $this->request->getPost('product_name', FILTER_SANITIZE_STRING),
            'status_produk' => $this->request->getPost('product_status', FILTER_SANITIZE_STRING),
            'waktu_buat' => date('Y-m-d H:i:s')
        ]);

        // if exists product photo
        if ($product_photo_file->getError() !== 4) {
            $product_photo_name = $product_photo_file->getRandomName();
            // genearate new random name for product photo
            $data_update_product = array_merge($data_update_product, ['foto_produk' => $product_photo_name]);
        }

        $product_price_ids = $this->request->getPost('product_price_ids');
        // split product price create and product price update
        $split_product_price = $this->splitProductPriceCreateUpdate(
            $product_price_ids,
            $this->request->getPost('product_magnitudes'),
            $this->request->getPost('product_prices')
        );

        $product_magnitudes_update = $split_product_price['product_magnitudes_update'];
        $product_prices_update = $split_product_price['product_prices_update'];
        $product_magnitudes_insert = $split_product_price['product_magnitudes_insert'];
        $product_prices_insert = $split_product_price['product_prices_insert'];

        $data_product_price_update = $this->generateDataUpdateBatchProductPrice(
            $product_price_ids,
            $product_magnitudes_update,
            $product_prices_update
        );

        $data_product_price_insert = $this->generateDataInsertBatchProductPrice(
            $product_id,
            $product_magnitudes_insert,
            $product_prices_insert
        );

        try {
            $this->model->transBegin();
            // update product
            $update_product = $this->model->update($product_id, $data_update_product);

            // update product price
            $update_product_price = $this->model_price->updateBatch($data_product_price_update, 'harga_produk_id');

            // insert product price
            if (count($data_product_price_insert) > 0) {
                $posw_model_product_price = new POSWModel($this->model->db, 'harga_produk');
                $insert_product_price = $posw_model_product_price->insertBatch($data_product_price_insert);
            }

            // commit transaction
            $this->model->transCommit();

        } catch (\ErrorException $e) {
            // rollback transaction
            $this->model->transRollBack();
        }

        /* if update product and update product price success and
         *  data insert product price not found or insert product price success */
        if (
            $update_product === true &&
            $update_product_price === count($data_product_price_update) &&
            (count($data_product_price_insert) === 0 || $insert_product_price === true)
        ) {
            // if exists product photo
            if ($product_photo_file->getError() === 0) {
                // move product photo
                $product_photo_file->move('dist/images/product_photo', $product_photo_name);
                // remove old product photo
                $old_product_photo = $this->request->getPost('old_product_photo');
                unlink('dist/images/product_photo/'.$old_product_photo);
            }

            // make success message
            ValidationMessage::setFlashMessage(
                'form_success',
                '<div class="alert alert--success mb-3"><span class="alert__icon"></span><p>',
                '</p><a class="alert__close" onclick="close_alert(event)" href="#"></a></div>',
                ['update_product' => '<strong>Berhasil</strong>, Produk telah diperbaharui']
            );

            return redirect()->back();
        }

        // make error message
        ValidationMessage::setFlashMessage(
            'form_errors',
            '<div class="alert alert--warning mb-3"><span class="alert__icon"></span><p>',
            '</p><a class="alert__close" onclick="close_alert(event)" href="#"></a></div>',
            ['update_product' => '<strong>Peringatan</strong>, Produk gagal dibuat']
        );
        return redirect()->back();
    }

    public function removeProductPriceInDB()
    {
        $product_price_id = $this->request->getPost('product_price_id', FILTER_SANITIZE_STRING);
        if ($this->model_price->removeProductPrice($product_price_id) === true) {
            echo json_encode(['success'=>true, 'csrf_value'=>csrf_hash()]);
            return true;
        }

        $error_message = 'Gagal menghapus harga produk, cek apakah masih ada transaksi yang terhubung!';
        echo json_encode(['success'=>false, 'error_message'=>$error_message, 'csrf_value'=>csrf_hash()]);
        return false;
    }

    public function removeProductInDB()
    {
        $product_ids = explode(',',$this->request->getPost('product_ids', FILTER_SANITIZE_STRING));
        $photo_products = $this->model->findProducts($product_ids, 'foto_produk');
        // remove product
        if ($this->model->removeProduct($product_ids) === true) {
            // remove photo product
            foreach($photo_products as $p) {
                unlink('dist/images/product_photo/'.$p['foto_produk']);
            }

            $count_product_ids = count($product_ids);
            $smallest_create_time = $this->request->getPost('smallest_create_time');
            $keyword = $this->request->getPost('keyword', FILTER_SANITIZE_STRING);

            // if keyword !== null
            if ($keyword !== null) {
                // get longer product
                $longer_products = $this->model->getLongerProductSearches($count_product_ids, $smallest_create_time, $keyword);
                // get total page
                $page_total = ceil($this->model->countAllProductSearch($keyword)/$this->product_limit);

            } else {
                // get longer product
                $longer_products = $this->model->getLongerProducts($count_product_ids, $smallest_create_time);
                // get total page
                $page_total = ceil($this->model->countAllProduct()/$this->product_limit);
            }

            // convert timestamp
            $date_time = new \App\Libraries\DateTime();
            $count_longer_products = count($longer_products);
            for ($i = 0; $i < $count_longer_products; $i++) {
                $longer_products[$i]['waktu_buat_indo'] = $date_time->convertTimstampToIndonesianDateTime($longer_products[$i]['waktu_buat']);
            }

            echo json_encode(['success' => true, 'longer_products' => $longer_products, 'page_total'=>$page_total, 'csrf_value'=>csrf_hash()]);
            return true;
        }

        $error_message = 'Gagal menghapus product, cek apakah masih ada transaksi yang terhubung!';
        echo json_encode(['success'=>false, 'error_message'=>$error_message, 'csrf_value'=>csrf_hash()]);
        return false;
    }
}
