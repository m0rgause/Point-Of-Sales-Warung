<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class User extends Controller
{
    protected static $test = 'test';

    public function __construct()
    {
        $this->model = new UserModel;
    }

    public function index()
    {
        helper('active_menu');

        $data['title'] = 'Pengguna . POSW';
        $data['page'] = 'pengguna';
        $data['users_db'] = $this->model->getUser();

        return view('user/user', $data);
    }
}
