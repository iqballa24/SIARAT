<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

	public function __construct() {
		parent::__construct();

		// if (empty($this->session->userdata('NIP'))) {
		// 	redirect('petugas/login');
		// }
        $this->load->model('m_category');
    }

    public function index() {

		$this->read();
	}

	public function read() {
	
		// $NIP = $this->session->userdata('nama');

		$output = array(
						'theme_page' => 'category/v_category.php',
						'judul' 	 => 'Kategori surat'
					);

		// memanggil file view
		$this->load->view('admin/theme/index', $output);
	}

	public function datatables()
	{
		//menunda loading (bisa dihapus, hanya untuk menampilkan pesan processing)
		// sleep(2);

		//memanggil fungsi model datatables
		$list = $this->m_category->get_datatables();
		$data = array();
		$no = $this->input->post('start');

		//mencetak data json
		foreach ($list as $field) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $field['kd_surat'];
			$row[] = $field['jenis_surat'];
			$row[] = '
					<a href="'.site_url('admin/category/update/'.$field['kd_surat']). '" class="btn btn-warning btn-sm " title="Edit">
						<i class="fas fa-edit"></i> 
					</a>
					<a href="'.site_url('admin/category/delete/'.$field['kd_surat']).'" class="btn btn-danger btn-sm btnHapus" title="Hapus" data = "'.$field['kd_surat'].'">
						<i class="fas fa-trash-alt"></i> 
					</a>';

			$data[] = $row;
		}

		//mengirim data json
		$output = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $this->m_category->count_all(),
			"recordsFiltered" => $this->m_category->count_filtered(),
			"data" => $data,
		);

		//output dalam format JSON
		echo json_encode($output);
	}

	public function insert() {

		$this->insert_submit();
		// $NIP = $this->session->userdata('nama');
	
		// mengirim data ke view
		$output = array(
						'theme_page' 	=> 'category/v_category_insert',
						'judul' 	 	=> 'Kategori surat',
					);

		// memanggil file view
		$this->load->view('admin/theme/index', $output);
	}

	public function insert_submit() {

		if ($this->input->post('submit') == 'Simpan') {

			//aturan validasi input login
			$this->form_validation->set_rules('kode', 'Kode surat', 'required|numeric|callback_insert_check');
			$this->form_validation->set_rules('jenis', 'Jenis surat', 'required');

			if ($this->form_validation->run() == TRUE) {

				// menangkap data input dari view
				$kode	  = $this->input->post('kode');
				$jenis	  = $this->input->post('jenis');
		
				// mengirim data ke model
				$input = array(
								// format : nama field/kolom table => data input dari view
								'kd_surat' 		=> $kode,
								'jenis_surat'	=> $jenis
							);
		
				// memanggil function insert pada anggota_model.php
				// function insert berfungsi menyimpan/create data ke table anggota di database
				$data_category = $this->m_category->insert($input);

				// mengembalikan halaman ke function read
				$this->session->set_tempdata('message', 'Data berhasil ditambahkan !', 1);
				redirect('admin/category/read');
			}

		}

	}

	public function insert_check()
	{

		//Menangkap data input dari view
		$kode = $this->input->post('kode');

		//check data di database
		$data_user = $this->m_category->read_check($kode);

		if (!empty($data_user)) {

			//membuat pesan error
			$this->form_validation->set_message('insert_check', "Kode surat " . $kode . " sudah ada dalam database");
			$this->session->set_tempdata('error', "Tidak dapat memasukan data yang sama", 1);
			return FALSE;
		}
		return TRUE;
	}
}