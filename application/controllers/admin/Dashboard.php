<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct() {
		parent::__construct();

		if (empty($this->session->userdata('username'))) {
			redirect('admin/auth');
		}

		if ($this->session->userdata('is_active') == 'n') {
			redirect('admin/auth');
		}

        // memanggil model
        $this->load->model(array('m_dashboard', 'm_setting'));
    }

    public function index() {
		// mengarahkan ke function read
		$this->read();
	}

	public function read() {
	
		// $NIP = $this->session->userdata('nama');
        $divisi       = $this->m_dashboard->getTotalDivisi();
        $category     = $this->m_dashboard->getTotalCategory();
        $totalInvoice = $this->m_dashboard->getTotalInvoice();
        $suratkeluar  = $this->m_dashboard->getTotalSuratKeluar();
        $suratmasuk   = $this->m_dashboard->getTotalSuratMasuk();
        $invoice	  = $this->m_dashboard->getInvoice();
		$name  = $this->session->userdata('name');
		$image = $this->session->userdata('image');
		$data_setting  = $this->m_setting->read();

		// mengirim data ke view
		$output = array(
						'theme_page' => 'dashboard/v_dashboard',
						'judul' 	 => 'Dashboard',
						'divisi'	 => $divisi,
						'category' 	 => $category,
						'allInvoice' => $totalInvoice,
						'suratkeluar'=> $suratkeluar,
						'suratmasuk' => $suratmasuk,
						'invoice'	 => $invoice,
						'name'		 => $name,
						'image'		 => $image,
						'data_setting' => $data_setting
					);

		// memanggil file view
		$this->load->view('admin/theme/index', $output);
	}
}