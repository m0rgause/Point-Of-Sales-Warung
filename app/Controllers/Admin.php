<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Admin extends Controller
{
    public function index()
    {
        helper('active_menu');

        $data['title'] = 'Admin . POSW';
        $data['page'] = 'admin';

        return view('admin/admin', $data);
    }
}
