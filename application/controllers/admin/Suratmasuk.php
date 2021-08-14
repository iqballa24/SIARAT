<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suratmasuk extends CI_Controller {

	public function __construct() {
		parent::__construct();

		if (empty($this->session->userdata('username'))) {
			redirect('admin/auth');
		}
		if ($this->session->userdata('is_active') == 'n') {
			redirect('admin/auth');
		}
        $this->load->model(array('m_suratmasuk', 'm_category','m_setting','M_log'));
    }

    public function index() {

		$this->read();
	}

	public function read() {
	
		$name  		   = $this->session->userdata('name');
		$image 		   = $this->session->userdata('image');
		$data_setting  = $this->m_setting->read();

		$output = array(
						'theme_page'   => 'surat/v_suratmasuk.php',
						'judul' 	   => 'Surat masuk',
						'data_setting' => $data_setting,
						'name'		   => $name,
						'image'		   => $image,
					);

		// memanggil file view
		$this->load->view('admin/theme/index', $output);
	}

	public function datatables()
	{
		//menunda loading (bisa dihapus, hanya untuk menampilkan pesan processing)
		// sleep(2);

		//memanggil fungsi model datatables
		$list = $this->m_suratmasuk->get_datatables();
		$data = array();
		$no = $this->input->post('start');

		//mencetak data json
		foreach ($list as $field) {
			$no++;
			$date1 = date_create($field['tgl_terima']);
            $date2 = date_create($field['tgl_surat']);
			$row = array();
			$row[] = $no;
			$row[] = $field['no_surat'];
			$row[] = $field['perihal'];
			$row[] = date_format($date2, "D, d M Y");
			$row[] = $field['pengirim'];
			$row[] = date_format($date1, "D, d M Y");
			$row[] = $field['jenis_surat'];
			$row[] = $field['keterangan'];
			$row[] = '
				<div class="btn-group" role="group" aria-label="Basic outlined example">
					<a href="'.site_url('admin/suratmasuk/detail/'.$field['id_surat']).'" class="btn btn-info btn-sm" title="View" data = "'.$field['id_surat'].'">
						<i class="fas fa-search"></i> 
					</a>
					<a href="'.site_url('admin/suratmasuk/update/'.$field['id_surat']). '" class="btn btn-warning btn-sm " title="Edit">
						<i class="fas fa-edit"></i> 
					</a>
					<a href="'.site_url('admin/suratmasuk/delete/'.$field['id_surat']).'" class="btn btn-danger btn-sm btnHapus" title="Hapus" data = "'.$field['id_surat'].'">
						<i class="fas fa-trash-alt"></i> 
					</a>
				</div>
				';

			$data[] = $row;
		}

		//mengirim data json
		$output = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $this->m_suratmasuk->count_all(),
			"recordsFiltered" => $this->m_suratmasuk->count_filtered(),
			"data" => $data,
		);

		//output dalam format JSON
		echo json_encode($output);
	}

	public function insert() {

		$this->insert_submit();
        $data_category = $this->m_category->read();
		$name  = $this->session->userdata('name');
		$image = $this->session->userdata('image');
		$data_setting  = $this->m_setting->read();
	
		// mengirim data ke view
		$output = array(
						'theme_page' 	=> 'surat/v_suratmasuk_insert',
						'judul' 	 	=> 'Surat masuk',
                        'data_category' => $data_category,
						'data_setting'  => $data_setting,
						'name'		 => $name,
						'image'		 => $image,
					);

		// memanggil file view
		$this->load->view('admin/theme/index', $output);
	}

	public function insert_submit() {

		if ($this->input->post('submit') == 'Simpan') {

			//aturan validasi input login
			$this->form_validation->set_rules('no_surat', 'No surat', 'required|callback_insert_check');
			$this->form_validation->set_rules('perihal', 'Perihal', 'required');
			$this->form_validation->set_rules('pengirim', 'Pengirim', 'required');
			$this->form_validation->set_rules('tgl_terima', 'Tanggal terima', 'required');
			$this->form_validation->set_rules('jenis_surat', 'Jenis surat');
			$this->form_validation->set_rules('tgl_surat', 'Tanggal surat', 'required');
			$this->form_validation->set_rules('ket', 'Keterangan');

			//setting library upload
            $config = array (
                'upload_path'    => './upload_folder/pdf/',
                'allowed_types'  => 'gif|jpg|png|pdf',
                'max_size'       => 5000
            );

            $this->load->library('upload', $config);

			if ($this->form_validation->run() == TRUE) {

				// menangkap data input dari view
				$no_surat	  	= $this->input->post('no_surat');
				$perihal	  	= $this->input->post('perihal');
				$pengirim	  	= $this->input->post('pengirim');
				$tgl_terima     = $this->input->post('tgl_terima');
				$jenis_surat	= $this->input->post('jenis_surat');
				$tgl_surat  	= $this->input->post('tgl_surat');
				$keterangan     = $this->input->post('ket');

				//jika gagal upload
                if (!$this->upload->do_upload('userfile')) {
        
                    $response = $this->upload->display_errors();
                    $data_category = $this->m_category->read();
					$name  = $this->session->userdata('name');
					$image = $this->session->userdata('image');
					$data_setting  = $this->m_setting->read();

                    $output = array(
                        'theme_page' 	=> 'surat/v_suratmasuk_insert',
                        'judul' 	 	=> 'Surat masuk',
                        'response'      => $response,
                        'data_category' => $data_category,
						'data_setting'	=> $data_setting,
						'name'		 => $name,
						'image'		 => $image,
                    );  
			
					// memanggil file view
					$this->load->view('admin/theme/index', $output);
        
                //jika berhasil upload
                } else {
                    $this->upload->do_upload('userfile');
                    $upload_data = $this->upload->data('file_name');
        
                    //mengirim data ke model
                    $input = array(
                        //format : nama field/kolom table => data input dari view
                        'no_surat'    	 => $no_surat,
                        'perihal' 	  	 => $perihal,
                        'pengirim' 	  	 => $pengirim,
                        'tgl_terima'  	 => $tgl_terima,
                        'kd_jenis_surat' => $jenis_surat,
                        'tgl_surat'  	 => $tgl_surat,
                        'keterangan' 	 => $keterangan,
                        'lampiran'   	 => $upload_data,
                    );
    
                    $data_suratmasuk = $this->m_suratmasuk->insert($input);

					// input data log
					date_default_timezone_set('Asia/Jakarta');
					$name       = $this->session->userdata('name');
					$date       = date('l, d F Y H:i:s');
					$activity   = $name.' menambahkan data surat masuk : <b>'.$perihal.'</b>';

					// mengirim data ke model
					$input_log = array(
						// format : nama field/kolom table => data input dari view
						'activity' 	=> $activity,
						'date'	    => $date,
					);

					$data_log = $this->M_log->insert($input_log);
        
                    //mengembalikan halaman ke function read
                    $this->session->set_tempdata('message', 'Data berhasil ditambahkan', 1);
					Redirect('admin/suratmasuk/read');
				}

			}

		}

	}

	public function insert_check()
	{

		//Menangkap data input dari view
		$no = $this->input->post('no_surat');

		//check data di database
		$data_user = $this->m_suratmasuk->read_check($no);

		if (!empty($data_user)) {

			//membuat pesan error
			$this->form_validation->set_message('insert_check', "No surat " . $no . " sudah ada dalam database");
			$this->session->set_tempdata('error', "Tidak dapat memasukan data yang sama", 1);
			return FALSE;
		}
		return TRUE;
	}

	public function update()
	{

		//menangkap id data yg dipilih dari view (parameter get)
		$id  					= $this->uri->segment(4);
        $data_category 			= $this->m_category->read();
		$data_suratmasuk_single = $this->m_suratmasuk->read_single($id);
		$name  					= $this->session->userdata('name');
		$image 					= $this->session->userdata('image');
		$data_setting  			= $this->m_setting->read();

		//mengirim data ke view
		$output = array(
			'judul'	 			     => 'Surat masuk',
			'theme_page' 		   	 => 'surat/v_suratmasuk_update',
			'data_category' 		 => $data_category,
			'data_setting'			 => $data_setting,	
			'data_suratmasuk_single' => $data_suratmasuk_single,
			'name'		 			 => $name,
			'image'					 => $image,
		);

		//memanggil file view
		$this->load->view('admin/theme/index', $output);
	}

	public function update_submit()
    {
        //setting library upload
        $config['upload_path']          = './upload_folder/pdf';
        $config['allowed_types']        = 'gif|jpg|png|pdf';
        $config['max_size']             = 5000;
        $this->load->library('upload', $config);

        //menangkap data input dari view
        $no_surat	  	= $this->input->post('no_surat');
		$perihal	  	= $this->input->post('perihal');
		$pengirim	    = $this->input->post('pengirim');
		$tgl_terima     = $this->input->post('tgl_terima');
		$jenis_surat	= $this->input->post('jenis_surat');
		$tgl_surat  	= $this->input->post('tgl_surat');
		$keterangan     = $this->input->post('ket');
		$oldfile		= $this->input->post('userfileold');

        //menangkap id data yg dipilih dari view (parameter get)
        $id = $this->uri->segment(4);

		if (!empty($this->upload->do_upload('userfile'))) {
			
			//jika gagal upload
			if (!$this->upload->do_upload('userfile')) {
	
				$id  					= $this->uri->segment(4);
				$data_category			= $this->m_category->read();
				$response 				= $this->upload->display_errors();
				$data_suratmasuk_single = $this->m_suratmasuk->read_single($id);
				$name 				    = $this->session->userdata('name');
				$image				    = $this->session->userdata('image');
				$data_setting  			= $this->m_setting->read();

		
				//mengirim data ke view
				$output = array(
					'judul'	 				 => 'Surat masuk',
					'theme_page' 			 => 'surat/v_suratmasuk_update',
					'data_category' 		 => $data_category,
					'response'				 => $response,
					'data_suratmasuk_single' => $data_suratmasuk_single,
					'data_setting'			 => $data_setting,
					'name'		 => $name,
					'image'		 => $image,
				);
		
				//memanggil file view
				$this->load->view('admin/theme/index', $output);
	
			 //jika berhasil upload
			} else {
				$this->upload->do_upload('userfile');
				$upload_data = $this->upload->data('file_name');
	
				//mengirim data ke model
				$input = array(
					//format : nama field/kolom table => data input dari view
					'no_surat'    	=> $no_surat,
					'perihal' 	  	=> $perihal,
					'pengirim' 	  	=> $pengirim,
					'tgl_terima'  	=> $tgl_terima,
					'kd_jenis_surat'=> $jenis_surat,
					'tgl_surat'   	=> $tgl_surat,
					'keterangan'  	=> $keterangan,
					'lampiran'    	=> $upload_data
				);
	
				$data_surat = $this->m_suratmasuk->update($input, $id);

				// input data log
				date_default_timezone_set('Asia/Jakarta');
                $name       = $this->session->userdata('name');
                $date       = date('l, d F Y H:i:s');
                $activity   = $name.' mengubah data surat masuk : <b>'.$perihal.'</b>';

                // mengirim data ke model
				$input_log = array(
                    // format : nama field/kolom table => data input dari view
                    'activity' 	=> $activity,
                    'date'	    => $date,
                );

                $data_log = $this->M_log->insert($input_log);
	
				//mengembalikan halaman ke function read
				$this->session->set_tempdata('message', 'Data berhasil disimpan', 1);
				Redirect('admin/suratmasuk/read');
			}

		} else {

			//mengirim data ke model
			$input = array(
				//format : nama field/kolom table => data input dari view
				'no_surat'    	=> $no_surat,
				'perihal' 	  	=> $perihal,
				'pengirim' 	  	=> $pengirim,
				'tgl_terima'  	=> $tgl_terima,
				'kd_jenis_surat'=> $jenis_surat,
				'tgl_surat'   	=> $tgl_surat,
				'keterangan'  	=> $keterangan,
				'lampiran'    	=> $oldfile
			);

			$data_surat = $this->m_suratmasuk->update($input, $id);

			// input data log
			date_default_timezone_set('Asia/Jakarta');
			$name       = $this->session->userdata('name');
			$date       = date('l, d F Y H:i:s');
			$activity   = $name.' mengubah data surat masuk : <b>'.$perihal.'</b>';

			// mengirim data ke model
			$input_log = array(
				// format : nama field/kolom table => data input dari view
				'activity' 	=> $activity,
				'date'	    => $date,
			);

			$data_log = $this->M_log->insert($input_log);

			//mengembalikan halaman ke function read
			$this->session->set_tempdata('message', 'Data berhasil disimpan', 1);
			Redirect('admin/suratmasuk/read');
		}

    }

	public function delete() {

		$id = $this->uri->segment(4);

		$this->db->db_debug = false; //disable debugging queries

		// Mengambil data dari Model
		$perihal  = $this->m_suratmasuk->getPerihalById($id);

		// Input data log
		date_default_timezone_set('Asia/Jakarta');
		$name       = $this->session->userdata('name');
		$date       = date('l, d F Y H:i:s');
		$activity   = $name.' delete data surat masuk : <b>'.$perihal.'</b>';

		// mengirim data ke model
		$input_log = array(
			// format : nama field/kolom table => data input dari view
			'activity' 	=> $activity,
			'date'	    => $date,
		);

		$data_log = $this->M_log->insert($input_log);
		
		// Error handling
		if (!$this->m_suratmasuk->delete($id)) {
			$msg =  $this->db->error();
			$this->session->set_tempdata('error', $msg['message'], 1);
		}

		//mengembalikan halaman ke function read
		$this->session->set_tempdata('message','Data berhasil dihapus',1);
		redirect('admin/suratmasuk/read');
	}

	public function detail()
    {

        $id            = $this->uri->segment(4);
        $dt_suratmasuk = $this->m_suratmasuk->detail($id);
		$name 		   = $this->session->userdata('name');
		$image		   = $this->session->userdata('image');
		$data_setting  = $this->m_setting->read();
        
        // mengirim data ke view
        $output = array(
            'theme_page'    => 'surat/v_suratmasuk_detail',
            'judul'         => 'Detail surat masuk',
            'dt_suratmasuk' => $dt_suratmasuk,
			'data_setting'  => $data_setting,
			'name'		 	=> $name,
			'image'		 	=> $image,
        );

        // memanggil file view
        $this->load->view('admin/theme/index', $output);
    }

	public function export_excel()
    {
        $data_suratmasuk = $this->m_suratmasuk->read();

        //mengirim data ke view
        $output = array(
            //data provinsi dikirim ke view
            'data_suratmasuk' => $data_suratmasuk,
        );

        //memanggil file view
        $this->load->view('admin/surat/v_suratmasuk_export_excel', $output);
    }
}