<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Transaction extends Controller
{
    public function index()
    {
        return view('transaction/transaction');
    }
}
