<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Divisi extends CI_Controller {

	public function __construct() {
		parent::__construct();

		// if (empty($this->session->userdata('NIP'))) {
		// 	redirect('petugas/login');
		// }
        $this->load->model('m_divisi');
    }

    public function index() {

		$this->read();
	}

	public function read() {
	
		// $NIP = $this->session->userdata('nama');

		$output = array(
						'theme_page' => 'divisi/v_divisi.php',
						'judul' 	 => 'Divisi / bagian'
					);

		// memanggil file view
		$this->load->view('admin/theme/index', $output);
	}

	public function datatables()
	{
		//menunda loading (bisa dihapus, hanya untuk menampilkan pesan processing)
		// sleep(2);

		//memanggil fungsi model datatables
		$list = $this->m_divisi->get_datatables();
		$data = array();
		$no = $this->input->post('start');

		//mencetak data json
		foreach ($list as $field) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $field['divisi'];
			$row[] = $field['kode'];
			$row[] = '
					<a href="'.site_url('admin/divisi/update/'.$field['kode']). '" class="btn btn-warning btn-sm " title="Edit">
						<i class="fas fa-edit"></i> 
					</a>
					<a href="'.site_url('admin/divisi/delete/'.$field['kode']).'" class="btn btn-danger btn-sm btnHapus" title="Hapus" data = "'.$field['kode'].'">
						<i class="fas fa-trash-alt"></i> 
					</a>';

			$data[] = $row;
		}

		//mengirim data json
		$output = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $this->m_divisi->count_all(),
			"recordsFiltered" => $this->m_divisi->count_filtered(),
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
						'theme_page' 	=> 'divisi/v_divisi_insert',
						'judul' 	 	=> 'Divisi / bagian',
					);

		// memanggil file view
		$this->load->view('admin/theme/index', $output);
	}

	public function insert_submit() {

		if ($this->input->post('submit') == 'Simpan') {

			//aturan validasi input login
			$this->form_validation->set_rules('divisi', 'Divisi', 'required');
			$this->form_validation->set_rules('Kode', 'Kode', 'required|callback_insert_check');

			if ($this->form_validation->run() == TRUE) {

				// menangkap data input dari view
				$divisi	  = $this->input->post('divisi');
				$kode	  = $this->input->post('Kode');
		
				// mengirim data ke model
				$input = array(
								// format : nama field/kolom table => data input dari view
								'divisi' => $divisi,
								'kode'   => $kode
							);
		
				$data_divisi = $this->m_divisi->insert($input);

				// mengembalikan halaman ke function read
				$this->session->set_tempdata('message', 'Data berhasil ditambahkan !', 1);
				redirect('admin/divisi/read');
			}

		}

	}

	public function insert_check()
	{

		//Menangkap data input dari view
		$kode = $this->input->post('Kode');

		//check data di database
		$data_user = $this->m_divisi->read_check($kode);

		if (!empty($data_user)) {

			//membuat pesan error
			$this->form_validation->set_message('insert_check', "Divisi / bagian " . $kode . " sudah ada dalam database");
			$this->session->set_tempdata('error', "Tidak dapat memasukan data yang sama", 1);
			return FALSE;
		}
		return TRUE;
	}

	public function update()
	{

		$this->update_submit();
		//menangkap id data yg dipilih dari view (parameter get)
		$id  = $this->uri->segment(4);
		// $NIP = $this->session->userdata('nama');

		//function read berfungsi mengambil 1 data dari table kategori sesuai id yg dipilih
		$data_divisi_single = $this->m_divisi->read_single($id);

		//mengirim data ke view
		$output = array(
			'judul'	 		=> 'Divisi / bagian',
			'theme_page' 	=> 'divisi/v_divisi_update',

			//mengirim data kota yang dipilih ke view
			'data_divisi_single' => $data_divisi_single,
		);

		//memanggil file view
		$this->load->view('admin/theme/index', $output);
	}

	public function update_submit()
	{

		if ($this->input->post('submit') == 'Simpan') {

			//aturan validasi input login
			$this->form_validation->set_rules('divisi', 'Divisi', 'required');
			$this->form_validation->set_rules('Kode', 'Kode', 'required');

			if ($this->form_validation->run() == TRUE) {

				//menangkap id data yg dipilih dari view
				$id = $this->uri->segment(4);

				// menangkap data input dari view
				$divisi	  = $this->input->post('divisi');
				$kode	  = $this->input->post('Kode');

				// mengirim data ke model
				$input = array(
					// format : nama field/kolom table => data input dari view
					'kode'		=> $kode,
					'divisi'	=> $divisi
				);

				$data_divisi = $this->m_divisi->update($input, $id);

				//mengembalikan halaman ke function read
				$this->session->set_tempdata('message', 'Data berhasil di ubah !', 1);
				redirect('admin/divisi/read');
			}
		}
	}

	public function delete() {

		$id = $this->uri->segment(4);

		$this->db->db_debug = false; //disable debugging queries
		
		// Error handling
		if (!$this->m_divisi->delete($id)) {
			$msg =  $this->db->error();
			$this->session->set_tempdata('error', $msg['message'], 1);
		}

		//mengembalikan halaman ke function read
		$this->session->set_tempdata('message','Data berhasil dihapus',1);
		redirect('admin/divisi/read');
	}
    
}