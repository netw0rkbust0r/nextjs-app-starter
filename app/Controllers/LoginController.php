<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class LoginController extends Controller
{
    protected $userModel;
    protected $session;
    protected $validation;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = session();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        // Show login form
        echo view('login_form');
    }

    public function doLogin()
    {
        helper(['form']);

        $rules = [
            'username' => 'required|alpha_numeric',
            'password' => 'required|min_length[6]'
        ];

        if (!$this->validate($rules)) {
            return view('login_form', [
                'validation' => $this->validator
            ]);
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->userModel->getUserByUsername($username);

        if ($user) {
            if (password_verify($password, $user['password_hash'])) {
                if ($user['verified'] == 1) {
                    if (in_array($user['status'], ['A', 'Z', 'D'])) {
                        // Set session data
                        $this->session->set([
                            'username' => $user['username'],
                            'status' => $user['status'],
                            'grade' => $user['grade'],
                            'isLoggedIn' => true
                        ]);

                        // Redirect to dashboard or intended page
                        return redirect()->to('/dashboard');
                    } else {
                        return view('login_form', ['error' => 'Your account is not active. Please contact support.']);
                    }
                } else {
                    return view('login_form', ['error' => 'Your account is not verified. Please verify your email.']);
                }
            } else {
                return view('login_form', ['error' => 'Invalid username or password.']);
            }
        } else {
            return view('login_form', ['error' => 'Invalid username or password.']);
        }
    }

    public function logout()
    {
        $username = $this->session->get('username');
        if ($username) {
            $db = \Config\Database::connect();
            $builder = $db->table('account');
            $builder->set('online', 0);
            $builder->where('c_id', $username);
            $builder->update();
        }

        $this->session->destroy();

        // Clear cookies if set
        setcookie("user_id", '', time() - 3600, "/");
        setcookie("user_name", '', time() - 3600, "/");
        setcookie("user_key", '', time() - 3600, "/");

        return redirect()->to('/login?logout=1');
    }
}
