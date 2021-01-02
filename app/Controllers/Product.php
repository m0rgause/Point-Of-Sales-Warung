<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Product extends Controller
{
    protected $helpers = ['form'];

    public function index()
    {
        return view('product/product');
    }

    public function createProduct()
    {
        return view('product/create_product');
    }
}
