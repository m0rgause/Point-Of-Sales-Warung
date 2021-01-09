<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class SignOut extends Controller
{
    public function index()
    {
        $session = \Config\Services::session();

        // if sign in
        if($session->has('posw_sign_in_status')) {
            // update last sign in
            $model = new UserModel;
            $model->update($_SESSION['posw_user_id'], ['sign_in_terakhir'=>date('Y-m-d H:i:s')]);

            // destroy session
            $session = \Config\Services::session();
            $session->destroy();
        }

        return redirect()->to('/');
    }
}
