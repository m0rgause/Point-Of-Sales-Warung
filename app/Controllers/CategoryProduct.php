<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\POSWModel;
use App\Libraries\ValidationMessage;

class CategoryProduct extends Controller
{
    protected $helpers = ['form', 'active_menu'];

    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        $data['title'] = 'Kategori Produk . POSW';
        $data['page'] = 'kategori_produk';

        return view('category_product/category_product', $data);
    }
}
