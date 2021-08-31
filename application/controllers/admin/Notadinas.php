<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notadinas extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (empty($this->session->userdata('username'))) {
            redirect('admin/auth');
        }
        if ($this->session->userdata('is_active') == 'n') {
            redirect('admin/auth');
        }
        $this->load->model(array('M_notadinas', 'm_divisi', 'm_setting', 'M_log'));
    }

    public function index()
    {
        $this->read();
    }

    public function read()
    {
        $name             = $this->session->userdata('name');
        $image            = $this->session->userdata('image');
        $data_setting     = $this->m_setting->read();

        $output = array(
            'theme_page'   => 'notadinas/v_notadinas.php',
            'judul'        => 'Nota dinas',
            'data_setting' => $data_setting,
            'name'         => $name,
            'image'        => $image,
        );

        // memanggil file view
        $this->load->view('admin/theme/index', $output);
    }

    public function datatables()
	{
		//menunda loading (bisa dihapus, hanya untuk menampilkan pesan processing)
		// sleep(2);

		//memanggil fungsi model datatables
		$list = $this->M_notadinas->get_datatables();
		$data = array();
		$no = $this->input->post('start');

		//mencetak data json
		foreach ($list as $field) {
			$no++;
			$date = date_create($field['tanggal']);
			$row = array();
			$row[] = $no;
			$row[] = $field['no_notadinas'];
			$row[] = $field['tujuan'];
			$row[] = $field['dari'];
			$row[] = $field['perihal'];
			$row[] = date_format($date, "D, d M Y");
			$row[] = $field['divisi'];
			$row[] = '
				<div class="btn-group" role="group" aria-label="Basic outlined example">
					<a href="'.site_url('admin/notadinas/detail/'.$field['id']).'" class="btn btn-info btn-sm" title="View" data = "'.$field['id'].'">
						<i class="fas fa-search"></i> 
					</a>
					<a href="'.site_url('admin/notadinas/update/'.$field['id']). '" class="btn btn-warning btn-sm " title="Edit">
						<i class="fas fa-edit"></i> 
					</a>
					<a href="'.site_url('admin/notadinas/getTemplate/'.$field['id']). '" class="btn btn-success btn-sm " title="Template">
						<i class="fas fa-file-invoice-dollar"></i> 
					</a>
					<a href="'.site_url('admin/notadinas/delete/'.$field['id']).'" class="btn btn-danger btn-sm btnHapus" title="Hapus" data = "'.$field['id'].'">
						<i class="fas fa-trash-alt"></i> 
					</a>
				</div>
					';

			$data[] = $row;
		}

		//mengirim data json
		$output = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $this->M_notadinas->count_all(),
			"recordsFiltered" => $this->M_notadinas->count_filtered(),
			"data" => $data,
		);

		//output dalam format JSON
		echo json_encode($output);
	}

    public function insert() 
	{

		$this->insert_submit();

		$data_divisi   = $this->m_divisi->read();
		$name  = $this->session->userdata('name');
		$image = $this->session->userdata('image');
		$data_setting  = $this->m_setting->read();

		// no urut surat
		$year 		= date('Y'); 
		$maxData    = $this->M_notadinas->getMaxData($year);
		$no_urut 	= $maxData + 1;
	
		// mengirim data ke view
		$output = array(
						'theme_page' 	=> 'notadinas/v_notadinas_insert',
						'judul' 	 	=> 'Nota dinas',
						'data_divisi'	=> $data_divisi,
						'no_urut'		=> $no_urut,
						'name'		 	=> $name,
						'image'			=> $image,
						'data_setting'  => $data_setting
					);

		// memanggil file view
		$this->load->view('admin/theme/index', $output);
	}

	public function insert_submit() 
	{

		if ($this->input->post('submit') == 'Simpan') {

			//aturan validasi input login
			$this->form_validation->set_rules('perihal', 'Perihal', 'required');
			$this->form_validation->set_rules('tujuan', 'Tujuan', 'required');
			$this->form_validation->set_rules('dari', 'Dari', 'required');
			$this->form_validation->set_rules('tgl', 'Tanggal', 'required');
			$this->form_validation->set_rules('divisi', 'Divisi', 'required');

			if ($this->form_validation->run() == TRUE) {

				// menangkap data input dari view
				$no_urut		= $this->input->post('no_urut');
				$perihal	  	= $this->input->post('perihal');
				$tujuan 	  	= $this->input->post('tujuan');
				$dari 	  	    = $this->input->post('dari');
				$tgl            = $this->input->post('tgl');
				$divisi  	    = $this->input->post('divisi');

				$bulan	        = date('n', strtotime($tgl));
				$year		    = date('Y');
				$nomor	        = $no_urut.'/MA_LSPHCMI/'.substr($divisi,0,1).'/0'.$bulan.'/'.$year;
				
				//mengirim data ke model
				$input = array(
					//format : nama field/kolom table => data input dari view
					'no_urut'		 => $no_urut,
					'perihal' 	  	 => $perihal,
					'tujuan'    	 => $tujuan,
					'dari'   	  	 => $dari,
					'tanggal'        => $tgl,
					'kd_divisi'	  	 => $divisi,
					'no_notadinas'	 => $nomor,
					'tahun'			 => $year
				);
				
				$data_notadinas = $this->M_notadinas->insert($input);

				// input data log
				date_default_timezone_set('Asia/Jakarta');
                $name       = $this->session->userdata('name');
                $date       = date('l, d F Y H:i:s');
                $activity   = $name.' menambahkan data nota dinas : <b>'.$nomor.'</b>';

                // mengirim data ke model
				$input_log = array(
                    // format : nama field/kolom table => data input dari view
                    'activity' 	=> $activity,
                    'date'	    => $date,
                );

                $data_log = $this->M_log->insert($input_log);
	
				//mengembalikan halaman ke function read
				$this->session->set_tempdata('message', 'Data berhasil ditambahkan', 1);
				Redirect('admin/notadinas/read');

			}

		}

	}

    public function update()
	{

		//menangkap id data yg dipilih dari view (parameter get)
		$id  					= $this->uri->segment(4);
		$data_notadinas_single  = $this->M_notadinas->read_single($id);
		$data_divisi   			= $this->m_divisi->read();
		$name  					= $this->session->userdata('name');
		$image 					= $this->session->userdata('image');
		$data_setting     		= $this->m_setting->read();

		//mengirim data ke view
		$output = array(
			'judul'	 			      => 'Nota dinas',
			'theme_page' 		   	  => 'notadinas/v_notadinas_update',
			'data_notadinas_single'   => $data_notadinas_single,
			'data_divisi'			  => $data_divisi,
			'data_setting'			  => $data_setting,
			'name'		 			  => $name,
			'image'		 			  => $image,
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

        // menangkap data input dari view
		$no_urut		= $this->input->post('no_urut');
		$no_notadinas	= $this->input->post('no_notadinas');
        $perihal	  	= $this->input->post('perihal');
        $tujuan 	  	= $this->input->post('tujuan');
        $dari 	  	    = $this->input->post('dari');
        $tgl            = $this->input->post('tgl');
        $divisi  	    = $this->input->post('divisi');
		$tahun 			= $this->input->post('tahun');
		$oldfile		= $this->input->post('userfileold');

		$bulan		 = substr($no_notadinas, 17,2);
		$nomor       = $no_urut.'/MA_LSPHCMI/'.substr($divisi,0,1).'/'.$bulan.'/'.$tahun;
				
        //menangkap id data yg dipilih dari view (parameter get)
        $id = $this->uri->segment(4);

		if (!empty($this->upload->do_upload('userfile'))) {
			
			//jika gagal upload
			if (!$this->upload->do_upload('userfile')) {
	
				//menangkap id data yg dipilih dari view (parameter get)
                $id  					= $this->uri->segment(4);
                $data_notadinas_single  = $this->M_notadinas->read_single($id);
                $data_divisi   			= $this->m_divisi->read();
                $name  					= $this->session->userdata('name');
                $image 					= $this->session->userdata('image');
                $data_setting     		= $this->m_setting->read();

                //respon alasan kenapa gagal upload
				$response = $this->upload->display_errors();

                //mengirim data ke view
                $output = array(
                    'judul'	 			      => 'Nota dinas',
                    'theme_page' 		   	  => 'notadinas/v_notadinas_update',
					'response'      		  => $response,
                    'data_notadinas_single'   => $data_notadinas_single,
                    'data_divisi'			  => $data_divisi,
                    'data_setting'			  => $data_setting,
                    'name'		 			  => $name,
                    'image'		 			  => $image,
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
					'no_urut'		 => $no_urut,
					'perihal' 	  	 => $perihal,
					'tujuan'    	 => $tujuan,
					'dari'   	  	 => $dari,
					'tanggal'        => $tgl,
					'kd_divisi'	  	 => $divisi,
					'no_notadinas'	 => $nomor,
					'tahun'			 => $tahun,
					'lampiran'    	 => $upload_data
				);
	
                $data_notadinas = $this->M_notadinas->update($input, $id);

				// input data log
				date_default_timezone_set('Asia/Jakarta');
                $name       = $this->session->userdata('name');
                $date       = date('l, d F Y H:i:s');
                $activity   = $name.' mengubah data nota dinas : <b>'.$nomor.'</b>';

                // mengirim data ke model
				$input_log = array(
                    // format : nama field/kolom table => data input dari view
                    'activity' 	=> $activity,
                    'date'	    => $date,
                );

                $data_log = $this->M_log->insert($input_log);
	
				//mengembalikan halaman ke function read
				$this->session->set_tempdata('message', 'Data berhasil disimpan', 1);
				Redirect('admin/notadinas/read');
			}

		} else {

			//mengirim data ke model
			$input = array(
				//format : nama field/kolom table => data input dari view
				'no_urut'		 => $no_urut,
                'perihal' 	  	 => $perihal,
                'tujuan'    	 => $tujuan,
                'dari'   	  	 => $dari,
                'tanggal'        => $tgl,
                'kd_divisi'	  	 => $divisi,
                'no_notadinas'	 => $nomor,
                'tahun'			 => $tahun,
				'lampiran'    	 => $oldfile,
			);

			$data_notadinas = $this->M_notadinas->update($input, $id);

			// input data log
			date_default_timezone_set('Asia/Jakarta');
			$name       = $this->session->userdata('name');
			$date       = date('l, d F Y H:i:s');
			$activity   = $name.' mengubah data nota dinas : <b>'.$nomor.'</b>';

			// mengirim data ke model
			$input_log = array(
				// format : nama field/kolom table => data input dari view
				'activity' 	=> $activity,
				'date'	    => $date,
			);

			$data_log = $this->M_log->insert($input_log);

			//mengembalikan halaman ke function read
			$this->session->set_tempdata('message', 'Data berhasil disimpan', 1);
			Redirect('admin/notadinas/read');
		}

    }

    public function delete() {

		$id = $this->uri->segment(4);

		$this->db->db_debug = false; //disable debugging queries

		// Mengambil data dari Model
		$nomor  = $this->M_notadinas->getDataNoSurat($id);

		// Input data log
		date_default_timezone_set('Asia/Jakarta');
		$name       = $this->session->userdata('name');
		$date       = date('l, d F Y H:i:s');
		$activity   = $name.' delete data nota dinas : <b>'.$nomor.'</b>';

		// mengirim data ke model
		$input_log = array(
			// format : nama field/kolom table => data input dari view
			'activity' 	=> $activity,
			'date'	    => $date,
		);

		$data_log = $this->M_log->insert($input_log);
		
		// Error handling
		if (!$this->M_notadinas->delete($id)) {
			$msg =  $this->db->error();
			$this->session->set_tempdata('error', $msg['message'], 1);
		}

		//mengembalikan halaman ke function read
		$this->session->set_tempdata('message','Data berhasil dihapus',1);
		redirect('admin/notadinas/read');
	}

    public function detail()
    {

        $id           	= $this->uri->segment(4);
        $data_notadinas = $this->M_notadinas->detail($id);
		$name  			= $this->session->userdata('name');
		$image 			= $this->session->userdata('image');
		$data_setting   = $this->m_setting->read();
        
        // mengirim data ke view
        $output = array(
            'theme_page'     => 'notadinas/v_notadinas_detail',
            'judul'          => 'Detail nota dinas',
            'data_notadinas' => $data_notadinas,
			'data_setting'   => $data_setting,
			'name'		 	 => $name,
			'image'		 	 => $image,
        );

        // memanggil file view
        $this->load->view('admin/theme/index', $output);
    }

	public function getTemplate() 
	{
		$document = file_get_contents("./assets/template/notadinas.rtf");
		$id  	  = $this->uri->segment(4);

		// menangkap data input dari view
		$nomor		= $this->M_notadinas->getLastDataNomor($id);
		$tujuan	  	= $this->M_notadinas->getLastDataTujuan($id);
		$dari	  	= $this->M_notadinas->getLastDataDari($id);
		$perihal	= $this->M_notadinas->getLastDataPerihal($id);
		$tanggal	= $this->M_notadinas->getLastDataTanggal($id);
		$no_urut	= $this->M_notadinas->getLastDataNoUrut($id);

		// isi dokumen dinyatakan dalam bentuk string
		$document = str_replace("#tujuan", $tujuan, $document);
		$document = str_replace("#dari", $dari, $document);
		$document = str_replace("#tanggal", date('d F Y', strtotime($tanggal)), $document);
		$document = str_replace("#perihal", $perihal, $document);
		$document = str_replace("#nomor", $nomor, $document);

		// header untuk membuka file output RTF dengan MS. Word
		header("Content-type: application/msword");
		header("Content-disposition: inline; filename= .$no_urut $perihal.doc");
		header("Content-length: ".strlen($document));
		echo $document;
	}

	public function export_excel()
    {
        $data_notadinas = $this->M_notadinas->read();

        //mengirim data ke view
        $output = array(
            //data provinsi dikirim ke view
            'data_notadinas' => $data_notadinas,
        );

        //memanggil file view
        $this->load->view('admin/notadinas/v_notadinas_export_excel', $output);
    }
}
