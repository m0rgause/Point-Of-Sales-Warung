<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Cashier extends Controller
{
    protected $helpers = ['form'];

    public function index()
    {
        return view('cashier/cashier');
    }
}
