<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\CategoryProductModel;
use App\Models\POSWModel;
use App\Models\ProductModel;
use App\Libraries\ValidationMessage;
use CodeIgniter\HTTP\Files\UploadedFile;

class Product extends Controller
{
    protected $helpers = ['form', 'active_menu', 'check_password_sign_in_user'];
    private $product_limit = 2;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->model = new ProductModel();
    }

    public function index()
    {
        $data['title'] = 'Produk . POSW';
        $data['page'] = 'produk';
        $data['products_db'] = $this->model->getProduct($this->product_limit, 0);
        $data['page_total'] = ceil($this->model->countAllProduct()/$this->product_limit);

        return view('product/product', $data);
    }

    public function createProduct()
    {
        $category_product_model = new CategoryProductModel;

        $data['category_products_db'] = $category_product_model->getCategoryProductForFormSelect();
        $data['title'] = 'Buat Produk . POSW';
        $data['page'] = 'buat_produk';

        return view('product/create_product', $data);
    }

    private function productPriceRules(array $product_magnitude, array $product_price): bool
    {
        $count_product_magnitude = count($product_magnitude);
        for($i = 0; $i < $count_product_magnitude; $i++) {
            // if empty magnitude
            if(empty(trim($product_magnitude[$i]))) {
                $this->product_magnitude_error[$i] = "Besaran tidak boleh kosong!";
            }
            // if magnitude more than 20 character
            elseif(strlen($product_magnitude[$i]) > 20) {
                $this->product_magnitude_error[$i] = "Besaran tidak bisa melebihi 20 karakter";
            }

            // if empty price
            if(empty(trim($product_price[$i]))) {
                $this->product_price_error[$i] = "Harga tidak boleh kosong!";
            }
            // if price more than 10 character
            elseif(strlen($product_price[$i]) > 10) {
                $this->product_price_error[$i] = "Harga tidak bisa melebihi 10 karakter";
            }
            // if price not a number
            elseif(!preg_match('/^\d+$/', $product_price[$i])) {
                $this->product_price_error[$i] = "Harga harus terdiri dari angka!";
            }
        }

        if(count($this->product_magnitude_error??[]) > 0 || count($this->product_price_error??[]) > 0) {
            return false;
        }
        return true;
    }

    private function productPhotoRules(UploadedFile $product_photo_file): bool
    {
        // if not file was uploaded
        if($product_photo_file->getError() === 4) {
            $this->product_photo_error = "Tidak ada file yang diupload";
        }
        // if not valid file
        elseif(!$product_photo_file->isValid()) {
            $this->product_photo_error = "File yang diupload tidak benar";
        }
        // if size file exceed 1MB
        elseif($product_photo_file->getSizeByUnit('mb') > 1) {
            $this->product_photo_error = "Ukuran file tidak bisa melebihi 1MB";
        }
        // if file extension not jpg or jpeg
        elseif(strtolower($product_photo_file->getExtension()) !== 'jpg' && strtolower($product_photo_file->getExtension()) !== 'jpeg') {
            $this->product_photo_error = "Ekstensi file harus .jpg atau .jpeg!";
        }
        // if file is valid
        elseif($product_photo_file->isValid()) {
            return true;
        }

        return false;
    }

    private function generateDataInsertBatchProductPrice(string $product_id, array $product_magnitude, array $product_price): array
    {
        $data_insert = [];
        $count_product_magnitude = count($product_magnitude);
        for($i = 0; $i < $count_product_magnitude; $i++) {
            $data_insert[] = [
                'produk_id' => $product_id,
                'besaran_produk' => filter_var($product_magnitude[$i], FILTER_SANITIZE_STRING),
                'harga_produk' => filter_var($product_price[$i], FILTER_SANITIZE_STRING)
            ];
        }
        return $data_insert;
    }

    public function saveProductToDB()
    {
        $form_errors = [];

        if(!$this->validate([
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
        if($this->productPhotoRules($product_photo_file) !== true) {
            $form_errors = array_merge($form_errors, ['product_photo' => $this->product_photo_error]);
        }

        // add delimiter to errors message
        $form_errors = ValidationMessage::setDelimiterMessage(
            '<small class="form-message form-message--danger">',
            '</small>',
            $form_errors
        );

        // product price validation
        if($this->productPriceRules($this->request->getPost('product_magnitude'), $this->request->getPost('product_price')) !== true) {
            // if exists product magnitude error
            if(isset($this->product_magnitude_error)) {
                $form_errors = array_merge($form_errors, ['product_magnitude' => $this->product_magnitude_error]);
            }
            // if exists product price error
            if(isset($this->product_price_error)) {
                $form_errors = array_merge($form_errors, ['product_price' => $this->product_price_error]);
            }
        }

        // if exists form errors
        if(count($form_errors) > 0) {
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
        $data_product_price = $this->generateDataInsertBatchProductPrice(
            $produk_id,
            $this->request->getPost('product_magnitude'),
            $this->request->getPost('product_price')
        );
        $posw_model_product_price = new POSWModel($this->model->db, 'harga_produk');
        $insert_product_price = $posw_model_product_price->insertBatch($data_product_price);

        $this->model->db->transComplete();

        // if insert product and insert product price success
        if($insert_product === true && $insert_product_price === true) {
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
        $product_price = $this->model->getProductPrice($product_id);
        $product_photo = $this->model->findProduct($product_id, 'foto_produk')['foto_produk']??null;

        echo json_encode(['product_price'=>$product_price, 'product_photo'=>$product_photo, 'csrf_value'=>csrf_hash()]);
        return true;
    }

    public function showPaginationProduct()
    {
        $page_position = $this->request->getPost('page', FILTER_SANITIZE_STRING);
        $product_offset = ($page_position * $this->product_limit) - $this->product_limit;
        $keyword = $this->request->getPost('keyword', FILTER_SANITIZE_STRING);

        // if keyword !== null
        if($keyword !== null) {
            $products_db = $this->model->getProductSearch($this->product_limit, $product_offset, ['nama_produk'=>$keyword]);

        } else {
            $products_db = $this->model->getProduct($this->product_limit, $product_offset);
        }

        // convert timestamp
        $date_time = new \App\Libraries\DateTime();
        $count_products_db = count($products_db);
        for($i = 0; $i < $count_products_db; $i++) {
            $products_db[$i]['waktu_buat'] = $date_time->convertTimstampToIndonesianDateTime($products_db[$i]['waktu_buat']);
        }

        // get total product
        $page_total = ceil($this->model->countAllProduct()/$this->product_limit);

        echo json_encode(['products_db' => $products_db, 'page_total'=>$page_total, 'csrf_value'=>csrf_hash()]);
        return true;
    }
}
