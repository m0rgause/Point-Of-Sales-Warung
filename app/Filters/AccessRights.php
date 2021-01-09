<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AccessRights implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = \Config\Services::session();

        // if not sign in
        if(!$session->has('posw_sign_in_status')) {
            return redirect()->to('/');
        }

        // if sign in but posw_user_level not equal to access rights in $arguments[0]
        if($_SESSION['posw_user_level'] !== $arguments[0]) {
            return redirect()->to('/sign_out');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $reponse, $arguments = null)
    {

    }
}
