<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\TransactionModel;
use App\Libraries\IndoTime;

class Transaction extends Controller
{
    protected $helpers = ['form', 'active_menu', 'check_password_sign_in_user', 'generate_uuid', 'is_transaction_allowed_delete'];
    private const TRANSACTION_LIMIT = 50;

    public function __construct()
    {
        $this->transaction_model = new TransactionModel();
        $this->session = session();
        $this->indo_time = new IndoTime();
    }

    public function index()
    {
        $data['title'] = 'Transaksi . POSW';
        $data['page'] = 'transaksi';

        $data['transaction_total'] = $this->transaction_model->countAllTransaction();
        $data['transactions_db'] = $this->transaction_model->getTransactions(static::TRANSACTION_LIMIT);
        $data['transaction_limit'] = static::TRANSACTION_LIMIT;

        return view('transaction/transaction', $data);
    }
}
