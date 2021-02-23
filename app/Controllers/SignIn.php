<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Libraries\ValidationMessage;
use App\Models\UserModel;

class SignIn extends Controller
{
    protected $helpers = ['form'];

    public function index()
    {
        return view('signin.php');
    }

    public function signIn()
    {
        $session = session();

        if(!$this->validate([
            'username' => [
                'label' => 'Username',
                'rules' => 'required',
                'errors' => ValidationMessage::generateIndonesianErrorMessage('required')
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => ValidationMessage::generateIndonesianErrorMessage('required')
            ]
        ])) {
            // set validation errors message to flash session
            ValidationMessage::setFlashMessage(
                'form_errors',
                '<small class="form-message form-message--danger">',
                '</small>',
                $this->validator->getErrors()
            );
            return redirect()->back()->withInput();
        }

        $model = new UserModel;

        $username = $this->request->getPost('username', FILTER_SANITIZE_STRING);
        $password = $this->request->getPost('password', FILTER_SANITIZE_STRING);
        $data_user_sign_in = $model->getDataUserSignIn($username);

        if($data_user_sign_in !== null) {
            // if sign in success
            if(password_verify($password, $data_user_sign_in['password']) === true) {
                $session->set([
                    'posw_sign_in_status' => true,
                    'posw_user_id' => $data_user_sign_in['pengguna_id'],
                    'posw_user_level' => $data_user_sign_in['tingkat'],
                    'posw_user_full_name' => $data_user_sign_in['nama_lengkap']
                ]);

                // if user level is admin
                if($_SESSION['posw_user_level'] === 'admin') {
                    return redirect()->to('/admin');
                }
                return redirect()->to('/kasir');
            }

            // if password is wrong
            ValidationMessage::setFlashMessage(
                'form_errors',
                '<small class="form-message form-message--danger">',
                '</small>',
                ['password' => 'Password salah']
            );
            return redirect()->back();
        }

        // if username not found
        ValidationMessage::setFlashMessage(
            'form_errors',
            '<small class="form-message form-message--danger">',
            '</small>',
            ['username' => 'Username tidak ditemukan']
        );
        return redirect()->back();
    }
}
