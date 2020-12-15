<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Kasir extends Controller
{
    protected $helpers = ['form'];

    public function index()
    {
        return view('kasir/kasir');
    }
}
