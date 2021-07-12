<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct() {
		parent::__construct();

		// if (empty($this->session->userdata('NIP'))) {
		// 	redirect('petugas/login');
		// }
        $this->load->model(array('M_auth', 'M_log'));
    }

    public function index() {

		$this->login();
	}

    public function login()
    {

        //memanggil fungsi login submit	(agar di view tidak dilihat fungsi login submit)
        $this->login_submit();

        //memanggil file view
        $this->load->view('v_login');

    }

    private function login_submit()
    {

        //proses jika tombol login di submit
        if ($this->input->post('submit') == 'Login') {

            //aturan validasi input login
            $this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|alpha_numeric|callback_login_check');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');

            //jika validasi sukses 
            if ($this->form_validation->run() == TRUE) {
                
                date_default_timezone_set('Asia/Jakarta');
                $name       = $this->session->userdata('name');
                $date       = date('l, d F Y H:i:s');
                $activity   = $name.' login ke sistem';

                // mengirim data ke model
				$input = array(
                    // format : nama field/kolom table => data input dari view
                    'activity' 	=> $activity,
                    'date'	    => $date,
                );

                $data_log = $this->M_log->insert($input);

                redirect('admin/dashboard/read');
            }
        }
    }

    public function login_check()
    {
        //menangkap data input dari view
        $username   = $this->input->post('username');
        $password   = $this->input->post('password');

        //password encrypt
        $password_encrypt = md5($password);

        //check username & password sesuai dengan di database
        $data_user = $this->M_auth->read_single($username, $password_encrypt);

        //jika cocok : dikembalikan ke fungsi login_submit (validasi sukses)
        if (!empty($data_user)) {

            //buat session user 
            $this->session->set_userdata('username', $data_user['username']);
            $this->session->set_userdata('name', $data_user['name']);
            $this->session->set_userdata('level', $data_user['level']);
            $this->session->set_userdata('is_active', $data_user['is_active']);
            $this->session->set_userdata('password', $data_user['password']);
            $this->session->set_userdata('image', $data_user['image']);

            return TRUE;

            //jika tidak cocok : dikembalikan ke fungsi login_submit (validasi gagal)
        } else {

            //membuat pesan error
            $this->form_validation->set_message('login_check', 'Username & password tidak tepat');

            return FALSE;
        }
    }

    public function logout()
    {
        //hapus session user
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('name');
        $this->session->unset_userdata('is_active');
        $this->session->unset_userdata('level');
        $this->session->unset_userdata('password');
        $this->session->unset_userdata('image');

        //mengembalikan halaman ke function read
        redirect('admin/auth/login');
    }


}