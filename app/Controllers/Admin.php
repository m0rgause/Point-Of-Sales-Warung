<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Admin extends Controller
{
    public function index()
    {
        helper('active_menu');

        $data['title'] = 'Home . POSW';
        $data['page'] = 'home';

        return view('admin/admin', $data);
    }
}
