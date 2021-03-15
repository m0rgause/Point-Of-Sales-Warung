<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Libraries\ValidationMessage;

class User extends Controller
{
    protected $helpers = ['form', 'active_menu', 'check_password_sign_in_user', 'generate_uuid'];

    public function __construct()
    {
        $this->model = new UserModel;
        $this->session = session();
    }

    public function index()
    {
        $data['title'] = 'Pengguna . POSW';
        $data['page'] = 'pengguna';
        $data['users_db'] = $this->model->getUsers();

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
        if (!$this->validate([
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

        $this->model->insert([
            'pengguna_id' => generate_uuid(),
            'nama_lengkap' => $this->request->getPost('full_name', FILTER_SANITIZE_STRING),
            'username' => $this->request->getPost('username', FILTER_SANITIZE_STRING),
            'tingkat' => $this->request->getPost('level', FILTER_SANITIZE_STRING),
            'password' => password_hash($this->request->getPost('password', FILTER_SANITIZE_STRING), PASSWORD_DEFAULT)
        ]);
        return redirect()->to('/admin/pengguna');
    }

    public function updateUser(string $user_id)
    {
        $user_id = filter_var($user_id, FILTER_SANITIZE_STRING);

        $data['title'] = 'Perbaharui Pengguna . POSW';
        $data['page'] = 'perbaharui_pengguna';
        $data['user_id'] = $user_id;
        $data['user_db'] = $this->model->findUser($user_id, 'nama_lengkap, username, tingkat');

        return view('user/update_user', $data);
    }

    public function updateUserInDB()
    {
        $user_id = $this->request->getPost('user_id', FILTER_SANITIZE_STRING);

        // check password sign in user
        $password_sign_in_user = $this->request->getPost('password_sign_in_user', FILTER_SANITIZE_STRING);
        $password_db = $this->model->findUser($_SESSION['posw_user_id'], 'password')['password'];
        $check_password = check_password_sign_in_user($password_sign_in_user, $password_db);
        if ($check_password !== 'yes') {
            // make password errors message
            ValidationMessage::setFlashMessage(
                'form_errors',
                '<small class="form-message form-message--danger">',
                '</small>',
                ['password_sign_in_user' => $check_password]
            );
            return redirect()->back();
        }

        // generate array validate
        $data_validate = [];

        $data_validate = array_merge($data_validate, [
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

        $password = $this->request->getPost('password', FILTER_SANITIZE_STRING);
        if (!empty(trim($password))) {
            $data_validate = array_merge($data_validate, [
                'password' => [
                    'label' => 'Password',
                    'rules' => 'min_length[8]',
                    'errors' => ValidationMessage::generateIndonesianErrorMessage('min_length')
                ]
            ]);
        }

        if (!$this->validate($data_validate)) {
            // set validation errors message to flash session
            ValidationMessage::setFlashMessage(
                'form_errors',
                '<small class="form-message form-message--danger">',
                '</small>',
                $this->validator->getErrors()
            );
            return redirect()->back();
        }

        // generate array update data
        $data_update = [];

        $data_update = array_merge($data_update, [
            'nama_lengkap' => $this->request->getPost('full_name', FILTER_SANITIZE_STRING),
            'username' => $this->request->getPost('username', FILTER_SANITIZE_STRING),
            'tingkat' => $this->request->getPost('level', FILTER_SANITIZE_STRING)
        ]);

        if (!empty(trim($password))) {
            $data_update = array_merge($data_update, ['password' => password_hash($password, PASSWORD_DEFAULT)]);
        }

        // update data
        if ($this->model->update($user_id, $data_update)) {
            // make success message
            ValidationMessage::setFlashMessage(
                'form_success',
                '<div class="alert alert--success mb-3"><span class="alert__icon"></span><p>',
                '</p><a class="alert__close" href="#"></a></div>',
                ['update_user' => '<strong>Berhasil</strong>, Pengguna telah diperbaharui.']
            );
        }
        return redirect()->back();
    }

    public function removeUserInDB()
    {
        // check password sign in user
        $password = $this->request->getPost('password', FILTER_SANITIZE_STRING);
        $password_db = $this->model->findUser($_SESSION['posw_user_id'], 'password')['password'];
        $check_password = check_password_sign_in_user($password, $password_db);
        if ($check_password !== 'yes') {
            return json_encode(['success'=>false, 'check_password_message'=>$check_password, 'csrf_value'=>csrf_hash()]);
        }

        $user_id = $this->request->getPost('user_id', FILTER_SANITIZE_STRING);
        if ($this->model->removeUser($user_id) > 0) {
            return json_encode(['success'=>true, 'csrf_value'=>csrf_hash()]);
        }

        $error_message = 'Gagal menghapus pengguna, cek apakah masih ada transaksi yang terhubung!';
        return json_encode(['success'=>false, 'error_message'=>$error_message, 'csrf_value'=>csrf_hash()]);
    }
}
