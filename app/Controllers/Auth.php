<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = \Config\Services::session();
    }

    /**
     * Tampilkan halaman login
     */
    public function index()
    {
        // Jika sudah login, redirect ke dashboard
        if ($this->session->get('is_logged_in')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    /**
     * Proses login dengan Ajax
     */
    public function login()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Request tidak valid'
            ]);
        }

        $rules = [
            'login' => 'required',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Login dan password harus diisi',
                'errors' => $this->validator->getErrors()
            ]);
        }

        $login = $this->request->getPost('login');
        $password = $this->request->getPost('password');

        $user = $this->userModel->authenticate($login, $password);

        if ($user) {
            // Set session data
            $sessionData = [
                'user_id' => $user['id'],
                'username' => $user['username'],
                'fullname' => $user['fullname'],
                'email' => $user['email'],
                'role' => $user['role'],
                'nrp' => $user['nrp'],
                'is_logged_in' => true
            ];

            $this->session->set($sessionData);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Login berhasil',
                'redirect' => base_url('/dashboard')
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Username/Email atau password salah'
            ]);
        }
    }

    /**
     * Logout dan hapus session
     */
    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/auth');
    }

    /**
     * Cek apakah user sudah login
     */
    public function checkAuth()
    {
        if (!$this->session->get('is_logged_in')) {
            return redirect()->to('/auth');
        }
    }

    /**
     * Middleware untuk cek role access
     */
    public function checkRole($allowedRoles = [])
    {
        $userRole = $this->session->get('role');

        if (!in_array($userRole, $allowedRoles)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses untuk fitur ini'
                ]);
            }

            return redirect()->to('/dashboard')->with('error', 'Anda tidak memiliki akses untuk fitur ini');
        }
    }
}
