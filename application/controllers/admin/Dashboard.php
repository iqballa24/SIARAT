<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct() {
		parent::__construct();

		// if (empty($this->session->userdata('NIP'))) {
		// 	redirect('petugas/login');
		// }

        // memanggil model
        // $this->load->model('anggota_model');
    }

    public function index() {
		// mengarahkan ke function read
		$this->read();
	}

	public function read() {
	
		// $NIP = $this->session->userdata('nama');

		// mengirim data ke view
		$output = array(
						'theme_page' => 'anggota_read',
						'judul' 	 => 'Dashboard',

						// data anggota dikirim ke view
						// 'data_petugas' => $NIP
					);

		// memanggil file view
		$this->load->view('admin/theme/index');
	}
}