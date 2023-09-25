<?php defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{
    public function __construct()
    {
        // Load the constructer from MY_Controller
        parent::__construct();
        $this->load->library('encryption');
        $this->load->helper('cookie');
        $this->load->model('Auth_model', 'auth');
    }

    // ----------------------------
    // -- Start - Login --
    // ----------------------------

    public function index() // Login Page
    {
        if (check_cookie_login() || $this->session->userdata('is_login')) redirect(base_url('back/dashboard'));
        $data['identity'] = $this->identity->getIdentity();
        $data['title'] = 'Login - ' . $data['identity']['company'];
        $this->load->view('auth/login', $data);
    }

    public function postLogin() // Submit Login
    {
        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_rules('email-username', 'Email/Username', 'trim|required|xss_clean');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

            if ($this->form_validation->run()) {
                $username = strtolower($this->input->post('email-username', true));
                $password = $this->input->post('password', true);

                $users = $this->auth->getUserByEmailOrUsername($username);
                $identity = $this->identity->getIdentity();

                if ($users) { // User exist 
                    if (password_verify($password, $users['password'])) { // Password correct
                        $dataSession = [
                            'id_user' => $users['id_user'],
                            'username' => $users['username'],
                            'email' => $users['email'],
                            'role_user' => $users['role_user'],
                            'is_login' => true
                        ];

                        if (!empty($this->input->post('remember-me', true))) { //remember me checked
                            set_cookie('login', $this->encryption->encrypt(json_encode($dataSession)), 7 * (24 * 60 * 60)); // 7 hari / bisa set via db
                        }

                        $this->session->set_userdata($dataSession);
                        echo json_encode(["status" => true, 'message' => ['title' => 'Login Berhasil! ', 'text' => 'Anda akan diarahkan ke halaman dashboard!'], 'url' => base_url('back/dashboard')]);
                    } else { // password salah
                        echo json_encode(["status" => false, 'message' => ['title' => 'Login Gagal!', 'text' => 'Username atau Password salah!']]);
                    }
                } else { // user doesn't exist
                    echo json_encode(["status" => false, 'message' => ['title' => 'Login Gagal!', 'text' => 'Username atau Password salah!']]);
                }
            } else {
                $res = [
                    'status' => false,
                    'message' => ['title' => "Login Gagal!", 'text' => validation_errors()],
                    'email-username' => form_error('email-username', form_err_style()[0], form_err_style()[1]),
                    'password' => form_error('password', form_err_style()[0], form_err_style()[1]),
                ];
                echo json_encode($res);
            }
        } else {
            redirect('auth');
        }
    }

    // ----------------------------
    // -- End - Login --
    // ----------------------------

    // ----------------------------
    // -- Start - Logout --
    // ----------------------------

    public function logout()
    {
        session_unset();
        session_destroy();
        delete_cookie('login');
        redirect('auth');
    }

    // ----------------------------
    // -- End - Logout --
    // ----------------------------
}
