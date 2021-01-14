<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\POSWModel;
use App\Libraries\ValidationMessage;

class User extends Controller
{
    protected $helpers = ['form', 'active_menu', 'check_password_sign_in_user'];

    public function __construct()
    {
        $this->model = new UserModel;
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        $data['title'] = 'Pengguna . POSW';
        $data['page'] = 'pengguna';
        $data['users_db'] = $this->model->getUser();

        return view('user/user', $data);
    }

    public function createUser()
    {
        $data['title'] = 'Buat Pengguna . POSW';
        $data['page'] = 'buat_pengguna';

        return view('user/create_user', $data);
    }

    public function saveUserToDB()
    {
        if(!$this->validate([
            'full_name' => [
                'label' => 'Nama lengkap',
                'rules' => 'required|min_length[4]|max_length[32]',
                'errors' => ValidationMessage::generateIndonesianErrorMessage('required','min_length','max_length')
            ],
            'username' => [
                'label' => 'Username',
                'rules' => 'required|min_length[4]|max_length[32]|is_unique[pengguna.username]',
                'errors' => ValidationMessage::generateIndonesianErrorMessage('required','min_length','max_length','is_unique')
            ],
            'level' => [
                'label' => 'Tingkat',
                'rules' => 'in_list[admin,kasir]',
                'errors' => ValidationMessage::generateIndonesianErrorMessage('in_list')
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[8]',
                'errors' => ValidationMessage::generateIndonesianErrorMessage('required','min_length')
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

        $posw_model = new POSWModel($this->model->db, $this->model->table);
        $posw_model->insert([
            'nama_lengkap' => $this->request->getPost('full_name', FILTER_SANITIZE_STRING),
            'username' => $this->request->getPost('username', FILTER_SANITIZE_STRING),
            'tingkat' => $this->request->getPost('level', FILTER_SANITIZE_STRING),
            'password' => $this->request->getPost('password', FILTER_SANITIZE_STRING)
        ]);
        return redirect()->to('/admin/pengguna');
    }

    public function updateUser(string $user_id)
    {
        $user_id = filter_var($user_id, FILTER_SANITIZE_STRING);

        $data['title'] = 'Perbaharui Pengguna . POSW';
        $data['page'] = 'perbaharui_pengguna';
        $data['user_id'] = $user_id;
        $data['user'] = $this->model->findUser($user_id, 'nama_lengkap, username, tingkat');

        return view('user/update_user', $data);
    }

    public function updateUserInDB()
    {
        $user_id = $this->request->getPost('user_id', FILTER_SANITIZE_STRING);

        // check password sign in user
        $password_sign_in_user = $this->request->getPost('password_sign_in_user', FILTER_SANITIZE_STRING);
        $password_db = $this->model->findUser($_SESSION['posw_user_id'], 'password')['password'];
        $check_password = check_password_sign_in_user($password_sign_in_user, $password_db);
        if($check_password !== true) {
            // make password errors message
            ValidationMessage::setFlashMessage(
                'form_errors',
                '<small class="form-message form-message--danger">',
                '</small>',
                ['password_sign_in_user' => $check_password]
            );
            return redirect()->back();
        }

        // generate array validate and array update data
        $array_validate = [];
        $array_data_update = [];

        $password = $this->request->getPost('password', FILTER_SANITIZE_STRING);
        if(!empty(trim($password))) {
            $array_validate = array_merge($array_validate, [
                'password' => [
                    'label' => 'Password',
                    'rules' => 'min_length[8]',
                    'errors' => ValidationMessage::generateIndonesianErrorMessage('min_length')
                ]
            ]);
            $array_data_update = array_merge($array_data_update, ['password' => password_hash($password, PASSWORD_DEFAULT)]);
        }

        $array_validate = array_merge($array_validate, [
            'full_name' => [
                'label' => 'Nama lengkap',
                'rules' => 'required|min_length[4]|max_length[32]',
                'errors' => ValidationMessage::generateIndonesianErrorMessage('required','min_length','max_length')
            ],
            'username' => [
                'label' => 'Username',
                'rules' => 'required|min_length[4]|max_length[32]|is_unique[pengguna.username,pengguna_id,'.$user_id.']',
                'errors' => ValidationMessage::generateIndonesianErrorMessage('required','min_length','max_length','is_unique')
            ],
            'level' => [
                'label' => 'Tingkat',
                'rules' => 'in_list[admin,kasir]',
                'errors' => ValidationMessage::generateIndonesianErrorMessage('in_list')
            ]
        ]);
        $array_data_update = array_merge($array_data_update, [
            'nama_lengkap' => $this->request->getPost('full_name', FILTER_SANITIZE_STRING),
            'username' => $this->request->getPost('username', FILTER_SANITIZE_STRING),
            'tingkat' => $this->request->getPost('level', FILTER_SANITIZE_STRING)
        ]);

        if(!$this->validate($array_validate)) {
            // set validation errors message to flash session
            ValidationMessage::setFlashMessage(
                'form_errors',
                '<small class="form-message form-message--danger">',
                '</small>',
                $this->validator->getErrors()
            );
            return redirect()->back();
        }

        // update data
        if($this->model->update($user_id, $array_data_update)) {
            // make success message
            ValidationMessage::setFlashMessage(
                'form_success',
                '<div class="alert alert--success mb-3"><span class="alert__icon"></span><p>',
                '</p><a class="alert__close" href="#"></a></div>',
                ['update_user' => '<strong>Berhasil!</strong> Pengguna telah diperbaharui']
            );
        }
        return redirect()->back();
    }
}
