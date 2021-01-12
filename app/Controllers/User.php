<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\PoswModel;
use App\Libraries\ValidationMessage;

class User extends Controller
{
    protected $helpers = ['form', 'active_menu'];

    public function __construct()
    {
        $this->model = new UserModel;
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

        $posw_model = new PoswModel($this->model->db, $this->model->table);
        $posw_model->insert([
            'nama_lengkap' => $this->request->getPost('full_name', FILTER_SANITIZE_STRING),
            'username' => $this->request->getPost('username', FILTER_SANITIZE_STRING),
            'tingkat' => $this->request->getPost('level', FILTER_SANITIZE_STRING),
            'password' => $this->request->getPost('password', FILTER_SANITIZE_STRING)
        ]);
        return redirect()->to('/admin/pengguna');
    }
}
