<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asesor extends CI_Controller {

	public function __construct() {
		parent::__construct();

		if (empty($this->session->userdata('username')) && $this->session->userdata('level') == '2' ) {
			redirect('admin/auth');
		}

		if ($this->session->userdata('is_active') == 'n') {
			redirect('admin/auth');
		}

        $this->load->model(array('M_asesor', 'M_setting'));
    }

    public function index() {

		$this->read();
	}

	public function read() {
	
		$name  = $this->session->userdata('name');
		$image = $this->session->userdata('image');
		$data_setting  = $this->M_setting->read();

		$output = array(
						'theme_page'   => 'asesor/v_asesor.php',
						'judul' 	   => 'Asesor',
						'data_setting' => $data_setting,
						'name'		   => $name,
						'image'		   => $image
					);

		// memanggil file view
		$this->load->view('admin/theme/index', $output);
	}

	public function datatables()
	{
		//menunda loading (bisa dihapus, hanya untuk menampilkan pesan processing)
		// sleep(2);

		//memanggil fungsi model datatables
		$list = $this->M_asesor->get_datatables();
		$data = array();
		$no = $this->input->post('start');

		//mencetak data json
		foreach ($list as $field) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $field['nama'];
			$row[] = $field['Noreg'];
			$row[] = $field['Kompetensi'];
			$row[] = '
                <div class="btn-group" role="group" aria-label="Basic outlined example">
					<a href="'.site_url('admin/asesor/update/'.$field['id']). '" class="btn btn-warning btn-sm " title="Edit">
						<i class="fas fa-edit"></i> 
					</a>
					<a href="'.site_url('admin/asesor/delete/'.$field['id']).'" class="btn btn-danger btn-sm btnHapus" title="Hapus" data = "'.$field['id'].'">
						<i class="fas fa-trash-alt"></i> 
					</a>
                </div>';

			$data[] = $row;
		}

		//mengirim data json
		$output = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $this->M_asesor->count_all(),
			"recordsFiltered" => $this->M_asesor->count_filtered(),
			"data" => $data,
		);

		//output dalam format JSON
		echo json_encode($output);
	}

	public function insert() {

		$this->insert_submit();
		
		$name  = $this->session->userdata('name');
		$image = $this->session->userdata('image');
		$data_setting  = $this->M_setting->read();
	
		// mengirim data ke view
		$output = array(
						'theme_page' 	=> 'asesor/v_asesor_insert',
						'judul' 	 	=> 'Kategori surat',
						'data_setting'  => $data_setting,
						'name'		    => $name,
						'image'		 	=> $image
					);

		// memanggil file view
		$this->load->view('admin/theme/index', $output);
	}

	public function insert_submit() {

		if ($this->input->post('submit') == 'Simpan') {

			//aturan validasi input login
			$this->form_validation->set_rules('nama', 'Nama', 'required');
			$this->form_validation->set_rules('noreg', 'No.Reg./MET', 'required|callback_insert_check|min_length[26]|max_length[26]');
			$this->form_validation->set_rules('kompetensi', 'Kompetensi', 'required');

			if ($this->form_validation->run() == TRUE) {

				// menangkap data input dari view
				$nama         = $this->input->post('nama');
				$noreg  	  = $this->input->post('noreg');
				$kompetensi	  = $this->input->post('kompetensi');
		
				// mengirim data ke model
				$input = array(
								// format : nama field/kolom table => data input dari view
								'nama' 		=> $nama,
								'Noreg'	    => $noreg,
                                'Kompetensi'=> $kompetensi
							);
		
				$data_asesor = $this->M_asesor->insert($input);

				// mengembalikan halaman ke function read
				$this->session->set_tempdata('message', 'Data berhasil ditambahkan !', 1);
				redirect('admin/asesor/read');
			}

		}

	}

	public function insert_check()
	{

		//Menangkap data input dari view
		$noreg = $this->input->post('noreg');

		//check data di database
		$data_user = $this->M_asesor->read_check($noreg);

		if (!empty($data_user)) {

			//membuat pesan error
			$this->form_validation->set_message('insert_check', "No.Reg./MET " . $noreg . " sudah ada dalam database");
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
		$name  = $this->session->userdata('name');
		$image = $this->session->userdata('image');
		$data_setting  = $this->M_setting->read();

		//function read berfungsi mengambil 1 data dari table kategori sesuai id yg dipilih
		$data_asesor_single = $this->M_asesor->read_single($id);

		//mengirim data ke view
		$output = array(
			'judul'	 		=> 'Update asesor',
			'theme_page' 	=> 'asesor/v_asesor_update',
			'data_setting'  => $data_setting,
			'name'		 	=> $name,
			'image'		 	=> $image,

			//mengirim data kota yang dipilih ke view
			'data_asesor' => $data_asesor_single,
		);

		//memanggil file view
		$this->load->view('admin/theme/index', $output);
	}

	public function update_submit()
	{

		if ($this->input->post('submit') == 'Simpan') {

			//aturan validasi input login
			$this->form_validation->set_rules('kode', 'Kode surat', 'required|numeric');
			$this->form_validation->set_rules('jenis', 'Jenis surat', 'required');

			if ($this->form_validation->run() == TRUE) {

				//menangkap id data yg dipilih dari view
				$id = $this->uri->segment(3);

				// menangkap data input dari view
				$kode	  = $this->input->post('kode');
				$jenis	  = $this->input->post('jenis');

				// mengirim data ke model
				$input = array(
					// format : nama field/kolom table => data input dari view
					'kd_surat'		=> $kode,
					'jenis_surat'	=> $jenis
				);

				//memanggil function update pada kategori model
				$data_anggota = $this->m_category->update($input, $id);

				//mengembalikan halaman ke function read
				$this->session->set_tempdata('message', 'Data berhasil di ubah !', 1);
				redirect('admin/category/read');
			}
		}
	}

	public function delete() {

		$id = $this->uri->segment(4);

		$this->db->db_debug = false; //disable debugging queries
		
		// Error handling
		if (!$this->m_category->delete($id)) {
			$msg =  $this->db->error();
			$this->session->set_tempdata('error', $msg['message'], 1);
		}

		//mengembalikan halaman ke function read
		$this->session->set_tempdata('message','Data berhasil dihapus',1);
		redirect('admin/category/read');
	}
}