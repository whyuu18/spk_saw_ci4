<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Users extends BaseController
{
    protected $users;

    public function __construct()
    {
        $this->users = new UsersModel();
    }

    public function index()
    {
        // Pengecekan session login
        if (session()->get('login') != "login") {
            // Jika tidak ada session 'login', redirect ke halaman login dengan pesan error
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu.');
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Data Users',
            'users' => $this->users->findAll()
        ];
        return view('Users/index', $data);
    }

    public function tambah()
    {
        // Pengecekan session login
        if (session()->get('login') != "login") {
            // Jika tidak ada session 'login', redirect ke halaman login dengan pesan error
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu.');
            return redirect()->to('/login');
        }

        // session dipindahkan ke basecontroller
        $data = [
            'title' => 'Form Register User',
            'validation' => \Config\Services::validation()
        ];
        return view('Users/tambah', $data);
    }

    public function simpan()
    {
        $users = new usersModel();

        // validasi input
        $rules = [
            'username' => [
                'rules' => 'required|is_unique[user.username]',
                'errors' => [
                    'required' => 'Username wajib diisi!',
                    'is_unique' => 'Username sudah terdaftar!'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Password wajib diisi!',
                    'min_length' => 'Password minimal memiliki panjang 6 karakter!'
                ]
            ],
            'confirm_password' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Konfirmasi password wajib diisi!',
                    'matches' => 'Konfirmasi password tidak cocok dengan password!'
                ]
            ],
            'nama' => [
                'rules' => 'required|alpha_space',
                'errors' => [
                    'required' => 'Nama wajib diisi!',
                    'alpha_space' => 'Nama tidak valid!'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Email wajib diisi!',
                    'valid_email' => 'Email tidak valid!'
                ]
            ]
        ];

        if(!$this->validate($rules)){
            session()->setFlashdata('errors', $this->validator->listErrors());
            return redirect()->back();
        }

        // enkripsi password dengan Bcrypt
        $password = $this->request->getVar('password');
        $hashedPassword = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

        $users->save($this->request->getPost());

        // pesan data berhasil ditambah
        $isipesan = '<script> alert("User berhasil ditambahkan!") </script>';
        session()->setFlashdata('pesan', $isipesan);

        return redirect()->to('/users');
    }

    public function profile()
    {
        // Pengecekan session login
        if (session()->get('login') != "login") {
            // Jika tidak ada session 'login', redirect ke halaman login dengan pesan error
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu.');
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Profile User',
            'validation' => \Config\Services::validation()
        ];
        return view('/users/profile-user', $data);
    }

    public function edit($id)
    {
        // Pengecekan session login
        if (session()->get('login') != "login") {
            // Jika tidak ada session 'login', redirect ke halaman login dengan pesan error
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu.');
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Edit Users',
            'user' => $this->users->find($id),
            'validation' => \Config\Services::validation()
        ];
        return view('/users/edit', $data);
    }

    public function update($id)
    {
        $users = new usersModel();

        // validasi input
        $rules = [
            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Username wajib diisi!'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Password wajib diisi!',
                    'min_length' => 'Password minimal memiliki panjang 6 karakter!'
                ]
            ],
            'confirm_password' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Konfirmasi password wajib diisi!',
                    'matches' => 'Konfirmasi password tidak cocok dengan password!'
                ]
            ],
            'nama' => [
                'rules' => 'required|alpha_space',
                'errors' => [
                    'required' => 'Nama wajib diisi!',
                    'alpha_space' => 'Nama tidak valid!'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Email wajib diisi!',
                    'valid_email' => 'Email tidak valid!'
                ]
            ]
        ];

        if(!$this->validate($rules)){
            session()->setFlashdata('errors', $this->validator->listErrors());
            return redirect()->back();
        }

        // verifikasi password
        $password = $this->request->getVar('password');
        $hashedPassword = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

        $this->users->save([
            'id_user' => $id,
            'username' => $this->request->getVar('username'),
            'password' => $hashedPassword,
            'nama' => $this->request->getVar('nama'),
            'email' => $this->request->getVar('email'),
            'role' => $this->request->getVar('role'),
        ]);

        // pesan data berhasil ditambah
        $isipesan = '<script> alert("User berhasil ditambahkan!") </script>';
        session()->setFlashdata('pesan', $isipesan);

        return redirect()->to('/users');
    }

    public function delete($id)
    {
        // Pengecekan session login
        if (session()->get('login') != "login") {
            // Jika tidak ada session 'login', redirect ke halaman login dengan pesan error
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu.');
            return redirect()->to('/login');
        }

        $this->users->delete($id);

        // pesan berhasil didelete
        $isipesan = '<script> alert("Data berhasil dihapus!") </script>';
        session()->setFlashdata('pesan', $isipesan);

        return redirect()->to('/users');
    }
}
