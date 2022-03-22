<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{

    public function index()
    {
        $data['titleLogin'] = $this->getDataRow('profile_company', 'titlelogin', '', '1')[0]['titlelogin'];
        $this->load->view('auth/login', $data);
    }

    public function login()
    {
        $username = $this->input->post('username');
        $password = md5($this->input->post('password'));
        $arrWhere = array('username' => $username, 'password' => $password);
        $cek = $this->getDataRow('account', '*', $arrWhere, 1);
        if (count($cek) == 0) {
            $msg = 'Username atau password salah';
            $this->session->set_flashdata('msg', $msg);
            redirect(base_url('Auth'));
        } else {
            foreach ($cek as $row) {
                $newdata = array(
                    'id'  => $row['pkey'],
                    'name'  => $row['name'],
                    'role'     => $row['role'],
                    'img' => $row['img'],
                    'login' => true
                );
            }
            $this->session->set_userdata($newdata);
            redirect(base_url('admin'));
            // switch ($this->session->userdata('role')) {
            //     case '1':
            //         redirect(base_url('admin'));
            //         break;

            //     default:
            //         redirect(base_url('Auth'));
            //         break;
            // }
        }
    }


    public function logout()
    {
        $this->session->unset_userdata('login');
        $this->session->unset_userdata('role');
        redirect(base_url('Auth'));
    }
}
