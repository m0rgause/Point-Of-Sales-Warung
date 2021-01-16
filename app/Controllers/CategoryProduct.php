<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\CategoryProductModel;
use App\Models\POSWModel;
use App\Libraries\ValidationMessage;

class CategoryProduct extends Controller
{
    protected $helpers = ['form', 'active_menu'];

    public function __construct()
    {
        $this->model = new CategoryProductModel;
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        $data['title'] = 'Kategori Produk . POSW';
        $data['page'] = 'kategori_produk';
        $data['category_products_db'] = $this->model->orderBy('waktu_buat','DESC')->findAll();

        return view('category_product/category_product', $data);
    }

    public function createCategoryProduct()
    {
        $data['title'] = 'Buat Kategori Produk . POSW';
        $data['page'] = 'buat_kategori_produk';

        return view('category_product/create_category_product', $data);

    }

    public function saveCategoryProductToDB()
    {
        if(!$this->validate([
            'category_product_name' => [
                'label' => 'Nama Kategori Produk',
                'rules' => 'required|max_length[20]',
                'errors' => ValidationMessage::generateIndonesianErrorMessage('required','max_length')
            ]
        ])) {
            // set validation errors message to flash session
            ValidationMessage::setFlashMessage(
                'form_errors',
                '<small class="form-message form-message--danger">',
                '</small>',
                $this->validator->getErrors()
            );
            return redirect()->back()->withInput();
        }

        $posw_model = new POSWModel($this->model->db, $this->model->table);
        $posw_model->insert([
            'nama_kategori_produk' => $this->request->getPost('category_product_name', FILTER_SANITIZE_STRING),
            'waktu_buat' => date('Y-m-d H:i:s')
        ]);
        return redirect()->to('/admin/kategori_produk');
    }
}
