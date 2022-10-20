<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->model('auth_model');
    }

    public function index()
    {

        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            $this->_login();
        }
    }

    private function _login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->auth_model->getUser($username);

        if ($user) {
            if ($password == $user['password']) {
                $this->session->set_userdata(['username' => $user['username']]);
                redirect(base_url());
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password salah!!!</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Username salah!!!</div>');
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('username');
        $this->session->set_flashdata('message', '<div class="alert alert-primary" role="alert">Anda sudah logout!!!</div>');
        redirect('auth');
    }

    // public function registration()
    // {
    //     $this->form_validation->set_rules('name', 'Name', 'required|trim');
    //     $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
    //         'is_unique' => 'This email already registered!',
    //     ]);
    //     $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]', [
    //         'min_length' => 'Password too short!',
    //     ]);
    //     $this->form_validation->set_rules('password2', 'Repeat Password', 'required|trim|matches[password1]', [
    //         'matches' => 'Password dont match!',
    //     ]);

    //     if ($this->form_validation->run() == false) {
    //         $data['title'] = 'Registration';
    //         $this->load->view('templates/auth_header', $data);
    //         $this->load->view('auth/registration');
    //         $this->load->view('templates/auth_footer');
    //     } else {
    //         $data = [
    //             'name' => $this->input->post('name'),
    //             'email' => $this->input->post('email'),
    //             'image' => 'default.jpg',
    //             'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
    //             'role_id' => 2,
    //             'is_active' => 1,
    //             'date_created' => time()
    //         ];

    //         $this->db->insert('user', $data);
    //         $this->session->set_flashdata('message', '
    //             <div class="alert alert-success" role="alert">Conglaturation! your account has been created. Please Login</div>
    //         ');
    //         redirect('auth');
    //     }
    // }
}
