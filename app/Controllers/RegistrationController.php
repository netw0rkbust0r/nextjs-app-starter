<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class RegistrationController extends Controller
{
    protected $userModel;
    protected $session;
    protected $validation;
    protected $email;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = session();
        $this->validation = \Config\Services::validation();
        $this->email = \Config\Services::email();
    }

    public function index()
    {
        echo view('registration_form');
    }

    public function register()
    {
        helper(['form']);

        $rules = [
            'fullname' => 'required|min_length[3]|alpha_space',
            'username' => 'required|min_length[6]|max_length[15]|alpha_numeric',
            'email'    => 'required|valid_email|is_unique[account.c_headerb]',
            'password' => 'required|min_length[8]',
            'rpassword'=> 'matches[password]',
            'tel'      => 'required|numeric|exact_length[10]',
            'question' => 'required',
            'answer'   => 'required',
            'trnxpass' => 'required',
            'accept_terms' => 'required'
        ];

        if (!$this->validate($rules)) {
            return view('registration_form', [
                'validation' => $this->validator
            ]);
        }

        // Verify reCAPTCHA v3 token
        $recaptchaResponse = $this->request->getPost('g-recaptcha-response');
        $secretKey = getenv('RECAPTCHA_V3_SECRET_KEY');
        $recaptcha = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaResponse}");
        $recaptcha = json_decode($recaptcha);

        if (!$recaptcha->success || $recaptcha->score < 0.5) {
            return view('registration_form', [
                'validation' => $this->validator,
                'recaptchaError' => 'reCAPTCHA verification failed. Please try again.'
            ]);
        }

        $data = [
            'fullname' => $this->request->getPost('fullname'),
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_ARGON2ID),
            'tel'      => $this->request->getPost('tel'),
            'question' => $this->request->getPost('question'),
            'answer'   => $this->request->getPost('answer'),
            'trnxpass' => $this->request->getPost('trnxpass'),
            'referrer' => $this->request->getPost('referrer'),
            'activation_code' => bin2hex(random_bytes(16))
        ];

        // Insert user data into database
        $this->userModel->insertUser($data);

        // Send verification email
        $verificationLink = site_url("accountcontroller/verifyemail?acc={$data['username']}&code={$data['activation_code']}");
        $message = "Hello {$data['fullname']},<br>Please verify your account by clicking <a href='{$verificationLink}'>here</a>.";

        $this->email->setTo($data['email']);
        $this->email->setSubject('Account Verification');
        $this->email->setMessage($message);
        $this->email->send();

        return view('registration_form', ['successMessage' => 'Registration successful! Please check your email to verify your account.']);
    }
}
