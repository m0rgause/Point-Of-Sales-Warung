<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class HasSignedIn implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = \Config\Services::session();

        // if sign in
        if($session->has('posw_sign_in_status')) {
            // if posw_user_level equal to admin
            if($_SESSION['posw_user_level'] === 'admin') {
                return redirect()->to('/admin');
            }

            return redirect()->to('/kasir');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $reponse, $arguments = null)
    {

    }
}
