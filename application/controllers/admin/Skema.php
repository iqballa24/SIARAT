<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Skema extends CI_Controller {

	public function __construct() {
		parent::__construct();

		if (empty($this->session->userdata('username')) && $this->session->userdata('level') == '2' ) {
			redirect('admin/auth');
		}

		if ($this->session->userdata('is_active') == 'n') {
			redirect('admin/auth');
		}

        $this->load->model(array('M_skema', 'M_setting', 'M_log'));
    }

    public function index() {

		$this->read();
	}

	public function read() {
	
		$name  = $this->session->userdata('name');
		$image = $this->session->userdata('image');
		$data_setting  = $this->M_setting->read();

		$output = array(
						'theme_page'   => 'skema/v_skema.php',
						'judul' 	   => 'Skema',
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
		$list = $this->M_skema->get_datatables();
		$data = array();
		$no = $this->input->post('start');

		//mencetak data json
		foreach ($list as $field) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $field['skema'];
			$row[] = '
                <div class="btn-group" role="group" aria-label="Basic outlined example">
					<a href="'.site_url('admin/skema/update/'.$field['id']). '" class="btn btn-warning btn-sm " title="Edit">
						<i class="fas fa-edit"></i> 
					</a>
					<a href="'.site_url('admin/skema/delete/'.$field['id']).'" class="btn btn-danger btn-sm btnHapus" title="Hapus" data = "'.$field['id'].'">
						<i class="fas fa-trash-alt"></i> 
					</a>
                </div>';

			$data[] = $row;
		}

		//mengirim data json
		$output = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $this->M_skema->count_all(),
			"recordsFiltered" => $this->M_skema->count_filtered(),
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
						'theme_page' 	=> 'skema/v_skema_insert',
						'judul' 	 	=> 'Skema',
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
			$this->form_validation->set_rules('skema', 'Skema', 'required|callback_insert_check');

			if ($this->form_validation->run() == TRUE) {

				// menangkap data input dari view
				$skema         = $this->input->post('skema');
		
				// mengirim data ke model
				$input = array(
								// format : nama field/kolom table => data input dari view
								'skema' => $skema,
							);
		
				$data_skema = $this->M_skema->insert($input);

				// input data log
				date_default_timezone_set('Asia/Jakarta');
                $name       = $this->session->userdata('name');
                $date       = date('l, d F Y H:i:s');
                $activity   = $name.' menambahkan data skema : <b>'.$skema.'</b>';

                // mengirim data ke model
				$input_log = array(
                    // format : nama field/kolom table => data input dari view
                    'activity' 	=> $activity,
                    'date'	    => $date,
                );

                $data_log = $this->M_log->insert($input_log);

				// mengembalikan halaman ke function read
				$this->session->set_tempdata('message', 'Data berhasil ditambahkan !', 1);
				redirect('admin/skema/read');
			}

		}

	}

	public function insert_check()
	{

		//Menangkap data input dari view
		$skema = $this->input->post('skema');

		//check data di database
		$data_user = $this->M_skema->read_check($skema);

		if (!empty($data_user)) {

			//membuat pesan error
			$this->form_validation->set_message('insert_check',  $skema . " sudah ada dalam database");
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
		$data_skema_single = $this->M_skema->read_single($id);

		//mengirim data ke view
		$output = array(
			'judul'	 		=> 'Update skema',
			'theme_page' 	=> 'skema/v_skema_update',
			'data_setting'  => $data_setting,
			'name'		 	=> $name,
			'image'		 	=> $image,

			//mengirim data kota yang dipilih ke view
			'data_skema'    => $data_skema_single,
		);

		//memanggil file view
		$this->load->view('admin/theme/index', $output);
	}

	public function update_submit()
	{

		if ($this->input->post('submit') == 'Simpan') {

			//aturan validasi input login
			$this->form_validation->set_rules('skema', 'Skema', 'required|callback_update_check');

			if ($this->form_validation->run() == TRUE) {

				//menangkap id data yg dipilih dari view
				$id = $this->uri->segment(4);

				// menangkap data input dari view
				$skema	  = $this->input->post('skema');
		
				// mengirim data ke model
				$input = array(
								// format : nama field/kolom table => data input dari view
								'skema' 	=> $skema,
							);

				//memanggil function update pada kategori model
				$data_skema = $this->M_skema->update($input, $id);

				// input data log
				date_default_timezone_set('Asia/Jakarta');
                $name       = $this->session->userdata('name');
                $date       = date('l, d F Y H:i:s');
                $activity   = $name.' update data skema : <b>'.$skema.'</b>';

                // mengirim data ke model
				$input_log = array(
                    // format : nama field/kolom table => data input dari view
                    'activity' 	=> $activity,
                    'date'	    => $date,
                );

                $data_log = $this->M_log->insert($input_log);

				//mengembalikan halaman ke function read
				$this->session->set_tempdata('message', 'Data berhasil di ubah !', 1);
				redirect('admin/skema/read');
			}
		}
	}

    public function update_check()
	{

		//Menangkap data input dari view
		$skema = $this->input->post('skema');

		//check data di database
		$data_user = $this->M_skema->read_check($skema);

		if (!empty($data_user)) {

			//membuat pesan error
			$this->form_validation->set_message('insert_check',  $skema . " sudah ada dalam database");
			$this->session->set_tempdata('error', "Tidak dapat memasukan data yang sama", 1);
			return FALSE;
		}
		return TRUE;
	}

	public function delete() {

		$id = $this->uri->segment(4);

		$this->db->db_debug = false; //disable debugging queries

		// Mengambil data dari Model
		$skema  = $this->M_skema->getSkemaById($id);

		// Input data log
		date_default_timezone_set('Asia/Jakarta');
		$name       = $this->session->userdata('name');
		$date       = date('l, d F Y H:i:s');
		$activity   = $name.' delete data skema : <b>'.$skema.'</b>';

		// mengirim data ke model
		$input_log = array(
			// format : nama field/kolom table => data input dari view
			'activity' 	=> $activity,
			'date'	    => $date,
		);

		$data_log = $this->M_log->insert($input_log);
		
		// Error handling
		if (!$this->M_skema->delete($id)) {
			$msg =  $this->db->error();
			$this->session->set_tempdata('error', $msg['message'], 1);
		}

		//mengembalikan halaman ke function read
		$this->session->set_tempdata('message','Data berhasil dihapus',1);
		redirect('admin/skema/read');
	}

	public function export_excel()
    {
        $data_skema = $this->M_skema->read();

        //mengirim data ke view
        $output = array(

            //data provinsi dikirim ke view
            'data_skema' => $data_skema,
        );

        //memanggil file view
        $this->load->view('admin/skema/v_skema_export_excel', $output);
    }
}