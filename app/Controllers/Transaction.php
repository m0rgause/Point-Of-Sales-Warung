<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Transaction extends Controller
{
    protected $helpers = ['form', 'active_menu', 'check_password_sign_in_user', 'generate_uuid'];

    public function index()
    {
        $data['title'] = 'Transaksi . POSW';
        $data['page'] = 'transaksi';

        return view('transaction/transaction', $data);
    }
}
