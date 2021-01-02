<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Barang extends Controller
{
    protected $helpers = ['form'];

    public function index()
    {
        return view('admin/barang');
    }
}
