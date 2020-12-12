<?php namespace App\Controllers;

use CodeIgniter\Controller;

class SignIn extends Controller
{
    protected $helpers = ['form'];

    public function index()
    {
        return view('signin.php');
    }
}
