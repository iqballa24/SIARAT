<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

	public function __construct() {
		parent::__construct();

		if (empty($this->session->userdata('username')) && $this->session->userdata('level') == '2' ) {
			redirect('admin/auth');
		}

		if ($this->session->userdata('is_active') == 'n') {
			redirect('admin/auth');
		}

        $this->load->model(array('m_category', 'm_setting', 'M_log'));
    }

    public function index() {

		$this->read();
	}

	public function read() {
	
		$name  = $this->session->userdata('name');
		$image = $this->session->userdata('image');
		$data_setting  = $this->m_setting->read();

		$output = array(
						'theme_page'   => 'category/v_category.php',
						'judul' 	   => 'Kategori surat',
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
		
		$name  = $this->session->userdata('name');
		$image = $this->session->userdata('image');
		$data_setting  = $this->m_setting->read();
	
		// mengirim data ke view
		$output = array(
						'theme_page' 	=> 'category/v_category_insert',
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
		
				$data_category = $this->m_category->insert($input);

				// input data log
				date_default_timezone_set('Asia/Jakarta');
                $name       = $this->session->userdata('name');
                $date       = date('l, d F Y H:i:s');
                $activity   = $name.' menambahkan data kategori : <b>'.$jenis.'</b>';

                // mengirim data ke model
				$input_log = array(
                    // format : nama field/kolom table => data input dari view
                    'activity' 	=> $activity,
                    'date'	    => $date,
                );

                $data_log = $this->M_log->insert($input_log);

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

	public function update()
	{

		$this->update_submit();
		//menangkap id data yg dipilih dari view (parameter get)
		$id  = $this->uri->segment(4);
		$name  = $this->session->userdata('name');
		$image = $this->session->userdata('image');
		$data_setting  = $this->m_setting->read();

		//function read berfungsi mengambil 1 data dari table kategori sesuai id yg dipilih
		$data_category_single = $this->m_category->read_single($id);

		//mengirim data ke view
		$output = array(
			'judul'	 		=> 'Update kategori surat',
			'theme_page' 	=> 'category/v_category_update',
			'data_setting'  => $data_setting,
			'name'		 => $name,
			'image'		 => $image,

			//mengirim data kota yang dipilih ke view
			'data_category_single' => $data_category_single,
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

				// input data log
				date_default_timezone_set('Asia/Jakarta');
                $name       = $this->session->userdata('name');
                $date       = date('l, d F Y H:i:s');
                $activity   = $name.' mengubah data kategori : <b>'.$jenis.'</b>';

                // mengirim data ke model
				$input_log = array(
                    // format : nama field/kolom table => data input dari view
                    'activity' 	=> $activity,
                    'date'	    => $date,
                );

                $data_log = $this->M_log->insert($input_log);

				//mengembalikan halaman ke function read
				$this->session->set_tempdata('message', 'Data berhasil di ubah !', 1);
				redirect('admin/category/read');
			}
		}
	}

	public function delete() {

		$id = $this->uri->segment(4);

		$this->db->db_debug = false; //disable debugging queries
		
		// Mengambil data dari Model
		$kategori  = $this->m_category->getCategoryById($id);

		// Input data log
		date_default_timezone_set('Asia/Jakarta');
		$name       = $this->session->userdata('name');
		$date       = date('l, d F Y H:i:s');
		$activity   = $name.' delete data kategori : <b>'.$kategori.'</b>';

		// mengirim data ke model
		$input_log = array(
			// format : nama field/kolom table => data input dari view
			'activity' 	=> $activity,
			'date'	    => $date,
		);

		$data_log = $this->M_log->insert($input_log);

		// Error handling
		if (!$this->m_category->delete($id)) {
			$msg =  $this->db->error();
			$this->session->set_tempdata('error', $msg['message'], 1);
		}

		//mengembalikan halaman ke function read
		$this->session->set_tempdata('message','Data berhasil dihapus',1);
		redirect('admin/category/read');
	}

	public function export_excel()
    {
        $data_category = $this->m_category->read();

        //mengirim data ke view
        $output = array(

            //data provinsi dikirim ke view
            'data_category' => $data_category,
        );

        //memanggil file view
        $this->load->view('admin/category/v_category_export_excel', $output);
    }
}