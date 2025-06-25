<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AccountController extends Controller
{
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = session();
    }

    public function verifyEmail()
    {
        $account = $this->request->getGet('acc');
        $vercode = $this->request->getGet('code');

        if (!$account || !$vercode) {
            return redirect()->to('/login?error=invalid_request');
        }

        $account = esc($account);
        $vercode = esc($vercode);

        $user = $this->userModel->getUserByUsername($account);

        if (!$user) {
            return redirect()->to('/login?error=user_not_found');
        }

        if ($user['actcode'] === $vercode) {
            if ($user['verified'] > 1) {
                // Account banned
                return redirect()->to('/login?ban=1');
            } elseif ($user['verified'] == 1) {
                // Already activated
                return redirect()->to('/login?act=1');
            } else {
                // Activate account
                $db = \Config\Database::connect();
                $builder = $db->table('account');
                $builder->set('verified', 1);
                $builder->where('c_id', $account);
                $builder->update();

                return redirect()->to('/login?success=1');
            }
        } else {
            return redirect()->to('/login?err=1');
        }
    }
}
