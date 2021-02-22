<?php

class Users extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->form_validation->set_error_delimiters('<div>', '</div>');
        $this->load->model('Admin_model');
    }

    public function index()
    {
        redirect(admin_url());
    }

    public function login()
    {
        if (is_admin_login()) {
            redirect(admin_url());
        }
        $data = array('main' => 'users/login');
        if ($this->input->post('submit')) {
            //	echo '<pre>';print_r($_POST);die;
            $validate = array(array('field' => 'username', 'label' => 'Email ID', 'rules' => 'required'), array('field' => 'password', 'label' => 'Password', 'rules' => 'required'));
            $this->form_validation->set_rules($validate);
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('users/login', $data);
            } else {
                $email = $this->input->post('username');
                $pass = $this->input->post('password');
                if ($this->Admin_model->authenticate($email, md5($pass))) {
                    $admin = $this->Admin_model->getAdmin($email);
                    $sess = array('userid' => $admin->id);
                    $this->session->set_userdata($sess);
                    redirect(admin_url('dashboard'));
                } else {
                    $this->session->set_flashdata('error', 'Invalid Email/password. Try again');
                    redirect(admin_url('users/login'));
                }
            }
        } else {
            $this->load->view('users/login', $data);
        }
    }

    public function forget()
    {
        $data['main'] = 'users/forget';
        if ($this->input->post('submit')) {
            $validate = array(array('field' => 'email_id', 'label' => 'Email ID', 'rules' => 'required|valid_email'));
            $this->form_validation->set_rules($validate);
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('users/forget', $data);
            } else {
                $email = $this->input->post('email_id');
                $user = $this->db->get_where('admin', array('email' => $email))->first_row();
                if ($user) {
                    $msg = 'Dear Admin';
                    $msg .= '<br />Here is your login details : ';
                    $msg .= '<br />User Name: ' . $user->username;
                    $msg .= '<br />Password : ' . $user->password;
                    $msg .= '<br /><br /> To login here. <a href="' . base_url($this->config->item('admin_folder') . 'users/login') . '">Login Now</a>';
                    $this->load->library('email');
                    $this->email->from('no-reply@domain.com', 'Web Admin');
                    $this->email->to($user->email);
                    $this->email->subject('Recover Password');
                    $this->email->message($msg);
                    $this->email->send();
                    $this->session->set_flashdata('error', 'Password has been sent on your email id');
                    redirect($this->config->item('admin_folder') . '/users/login');
                } else {
                    $this->session->set_flashdata('error', 'Sorry, Invalid Email ID');
                    $this->load->view('users/forget', $data);
                }
            }
        } else {
            $this->load->view('users/forget', $data);
        }
    }

    public function logout()
    {
        $newdata = array('userid' => '', 'username' => '', 'role' => '');
        $this->session->unset_userdata($newdata);
        $this->session->sess_destroy();
        $this->session->set_flashdata('error', 'You have successfully logged out');
        redirect(admin_url('users/login'));
    }
}
