<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Admin extends Controller
{
    protected $helpers = ['form'];

    public function index()
    {
        return view('admin/admin');
    }
}
