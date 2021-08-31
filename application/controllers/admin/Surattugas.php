<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surattugas extends CI_Controller {

	public function __construct() 
	{
		parent::__construct();

		if (empty($this->session->userdata('username'))) {
			redirect('admin/auth');
		}
		if ($this->session->userdata('is_active') == 'n') {
			redirect('admin/auth');
		}
        $this->load->model(array('M_surattugas','M_setting','M_asesor', 'M_skema', 'M_log'));
    }

    public function index() 
	{

		$this->read();
	}

	public function read() 
	{
	
		$name  = $this->session->userdata('name');
		$image = $this->session->userdata('image');
		$data_setting  = $this->M_setting->read();

		$output = array(
						'theme_page'  => 'surat/surattugas/v_surattugas.php',
						'judul' 	  => 'Surat tugas',
						'data_setting'=> $data_setting,
						'name'		  => $name,
						'image'		  => $image,
					);

		// memanggil file view
		$this->load->view('admin/theme/index', $output);
	}

	public function getRomawi($bln) 
	{
		switch ($bln){
			case 1: 
				return "01";
				break;
			case 2:
				return "02";
				break;
			case 3:
				return "03";
				break;
			case 4:
				return "04";
				break;
			case 5:
				return "05";
				break;
			case 6:
				return "06";
				break;
			case 7:
				return "07";
				break;
			case 8:
				return "08";
				break;
			case 9:
				return "09";
				break;
			case 10:
				return "10";
				break;
			case 11:
				return "11";
				break;
			case 12:
				return "12";
				break;
	  }
	}

	public function datatables()
	{

		//memanggil fungsi model datatables
		$list = $this->M_surattugas->get_datatables();
		$data = array();
		$no = $this->input->post('start');

		//mencetak data json
		foreach ($list as $field) {
			$no++;
			$date1 = date_create($field['tgl_surat']);
			$date2 = date_create($field['tgl_pelaksanaan']);
			$row = array();
			$row[] = $no;
			$row[] = $field['no_surat'];
			$row[] = $field['perihal'];
			$row[] = date_format($date1, "D, d M Y");
			$row[] = date_format($date2, "D, d M Y");

			$row[] = '
				<div class="btn-group" role="group" aria-label="Basic outlined example">
					<a href="'.site_url('admin/surattugas/detail/'.$field['id_surat']).'" class="btn btn-info btn-sm" title="View" data = "'.$field['id_surat'].'">
						<i class="fas fa-search"></i> 
					</a>
					<a href="'.site_url('admin/surattugas/update/'.$field['id_surat']). '" class="btn btn-warning btn-sm " title="Edit">
						<i class="fas fa-edit"></i> 
					</a>
					<a href="'.site_url('admin/surattugas/getTemplate/'.$field['id_surat']). '" class="btn btn-success btn-sm " title="Template">
						<i class="fas fa-file-invoice-dollar"></i> 
					</a>
					<a href="'.site_url('admin/surattugas/delete/'.$field['id_surat']).'" class="btn btn-danger btn-sm btnHapus" title="Hapus" data = "'.$field['id_surat'].'">
						<i class="fas fa-trash-alt"></i> 
					</a>
				</div>
					';

			$data[] = $row;
		}

		//mengirim data json
		$output = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $this->M_surattugas->count_all(),
			"recordsFiltered" => $this->M_surattugas->count_filtered(),
			"data" => $data,
		);

		//output dalam format JSON
		echo json_encode($output);
	}

	// Insert untuk surat tugas uji kompetensi
	public function insert() 
	{

		$this->insert_submit();

		$name  = $this->session->userdata('name');
		$image = $this->session->userdata('image');
		$data_setting = $this->M_setting->read();
        $data_asesor  = $this->M_asesor->getDataAsesor();
        $data_skema   = $this->M_skema->read();

		// no urut surat
		$year 		= date('Y'); 
		$maxData    = $this->M_surattugas->getMaxData($year);
		$no_urut 	= $maxData + 1;
	
		// mengirim data ke view
		$output = array(
						'theme_page' 	=> 'surat/surattugas/v_surattugas_insert',
						'judul' 	 	=> 'Surat tugas uji kompetensi',
						'data_asesor'	=> $data_asesor,
						'no_urut'		=> $no_urut,
						'name'		 	=> $name,
						'image'			=> $image,
						'skema'			=> $data_skema,
						'data_setting'  => $data_setting
					);

		// memanggil file view
		$this->load->view('admin/theme/index', $output);
	}

	public function insert_submit() 
	{

		if ($this->input->post('submit') == 'Simpan') {

			//aturan validasi input login
			$this->form_validation->set_rules('no_urut', 'No urut', 'required');
			$this->form_validation->set_rules('perihal', 'Perihal', 'required');
			$this->form_validation->set_rules('tgl_surat', 'Tanggal Surat', 'required');
			$this->form_validation->set_rules('skema', 'Skema', 'required');
			$this->form_validation->set_rules('tgl_pelaksanaan', 'Tanggal pelaksanaan', 'required');
			$this->form_validation->set_rules('batch', 'Batch', 'required');
			$this->form_validation->set_rules('asesor', 'Asesor');
			$this->form_validation->set_rules('asesi1', 'Asesi');

			if ($this->form_validation->run() == TRUE) {

				// menangkap data input dari view
				$no_urut		= $this->input->post('no_urut');
				$tgl_surat		= $this->input->post('tgl_surat');
				$perihal		= $this->input->post('perihal');
				$skema		  	= $this->input->post('skema');
				$tgl_pelaksanaan= $this->input->post('tgl_pelaksanaan');
				$batch      	= $this->input->post('batch');
				$asesor  	    = $this->input->post('asesor');
				$asesi1     	= $this->input->post('asesi1');
				$asesi2     	= $this->input->post('asesi2');
				$asesi3     	= $this->input->post('asesi3');

				$getBulan	 = date('n', strtotime($tgl_surat));
				$bulan		 = $this->getRomawi($getBulan);
				$year		 = date('Y');
				$no_surat	 = $no_urut.'/SP/KLSP-HCMI/'.$bulan.'/'.$year;
				
				//mengirim data ke model
				$input = array(
					//format : nama field/kolom table => data input dari view
					'no_surat' 	 	 => $no_surat,
					'no_urut'		 => $no_urut,
					'perihal'		 => $perihal,
					'tgl_surat' 	 => $tgl_surat,
					'skema' 	  	 => $skema,
					'tgl_surat'  	 => $tgl_surat,
					'tgl_pelaksanaan'=> $tgl_pelaksanaan,
					'batch'	  	 	 => $batch,
					'asesor' 	 	 => $asesor,
					'asesi1'		 => $asesi1,
					'asesi2'		 => $asesi2,
					'asesi3'		 => $asesi3,
					'tahun'			 => $year
				);
				
				$data_surattugas = $this->M_surattugas->insert($input);

				// input data log
				date_default_timezone_set('Asia/Jakarta');
                $name       = $this->session->userdata('name');
                $date       = date('l, d F Y H:i:s');
                $activity   = $name.' menambahkan data surat tugas : <b>'.$no_surat.'</b>';

                // mengirim data ke model
				$input_log = array(
                    // format : nama field/kolom table => data input dari view
                    'activity' 	=> $activity,
                    'date'	    => $date,
                );

                $data_log = $this->M_log->insert($input_log);
	
				//mengembalikan halaman ke function read
				$this->session->set_tempdata('message', 'Data berhasil ditambahkan', 1);
				Redirect('admin/surattugas/read');

			}

		}

	}
	
	// Insert untuk surat tugas lainnya
	public function insert2() 
	{

		$this->insert_submit2();

		$name  = $this->session->userdata('name');
		$image = $this->session->userdata('image');
		$data_setting = $this->M_setting->read();
        $data_asesor  = $this->M_asesor->getDataAsesor();
        $data_skema   = $this->M_skema->read();

		// no urut surat
		$year 		= date('Y'); 
		$maxData    = $this->M_surattugas->getMaxData($year);
		$no_urut 	= $maxData + 1;
	
		// mengirim data ke view
		$output = array(
						'theme_page' 	=> 'surat/surattugas/v_surattugas2_insert',
						'judul' 	 	=> 'Surat tugas',
						'data_asesor'	=> $data_asesor,
						'no_urut'		=> $no_urut,
						'name'		 	=> $name,
						'image'			=> $image,
						'skema'			=> $data_skema,
						'data_setting'  => $data_setting
					);

		// memanggil file view
		$this->load->view('admin/theme/index', $output);
	}

	public function insert_submit2() 
	{

		if ($this->input->post('submit') == 'Simpan') {

			//aturan validasi input login
			$this->form_validation->set_rules('no_urut', 'No urut', 'required');
			$this->form_validation->set_rules('perihal', 'Perihal', 'required');
			$this->form_validation->set_rules('tgl_surat', 'Tanggal Surat', 'required');
			$this->form_validation->set_rules('tgl_pelaksanaan', 'Tanggal pelaksanaan', 'required');

			if ($this->form_validation->run() == TRUE) {

				// menangkap data input dari view
				$no_urut		= $this->input->post('no_urut');
				$tgl_surat		= $this->input->post('tgl_surat');
				$perihal		= $this->input->post('perihal');
				$tgl_pelaksanaan= $this->input->post('tgl_pelaksanaan');

				$getBulan	 = date('n', strtotime($tgl_surat));
				$bulan		 = $this->getRomawi($getBulan);
				$year		 = date('Y');
				$no_surat	 = $no_urut.'/SP/KLSP-HCMI/'.$bulan.'/'.$year;
				
				//mengirim data ke model
				$input = array(
					//format : nama field/kolom table => data input dari view
					'no_surat' 	 	 => $no_surat,
					'no_urut'		 => $no_urut,
					'perihal'		 => $perihal,
					'tgl_surat' 	 => $tgl_surat,
					'tgl_pelaksanaan'=> $tgl_pelaksanaan,
					'tahun'			 => $year
				);
				
				$data_surattugas = $this->M_surattugas->insert($input);

				// input data log activity
				date_default_timezone_set('Asia/Jakarta');
                $name       = $this->session->userdata('name');
                $date       = date('l, d F Y H:i:s');
                $activity   = $name.' menambahkan data surat tugas : <b>'.$no_surat.'</b>';

                // mengirim data ke model
				$input_log = array(
                    // format : nama field/kolom table => data input dari view
                    'activity' 	=> $activity,
                    'date'	    => $date,
                );

                $data_log = $this->M_log->insert($input_log);
	
				//mengembalikan halaman ke function read
				$this->session->set_tempdata('message', 'Data berhasil ditambahkan', 1);
				Redirect('admin/surattugas/read');

			}

		}

	}

	public function getTemplate() 
	{
		$id  	  = $this->uri->segment(4);
		
		// menangkap data input dari view
		$dataNoUrut 		= $this->M_surattugas->getDataNoUrut($id);
		$dataNoSurat		= $this->M_surattugas->getDataNoSurat($id);
		$dataPerihal		= $this->M_surattugas->getDataPerihal($id);
		$dataTglSurat		= $this->M_surattugas->getDataTglSurat($id);
		$dataBatch	     	= $this->M_surattugas->getDataBatch($id);
		$dataSkema			= $this->M_surattugas->getDataSkema($id);
		$dataTglPelaksanaan	= $this->M_surattugas->getDataTglPelaksanaan($id);
		$dataAsesor			= $this->M_surattugas->getDataAsesor($id);
		$dataAsesi1			= $this->M_surattugas->getDataAsesi1($id);
		$dataAsesi2			= $this->M_surattugas->getDataAsesi2($id);
		$dataAsesi3			= $this->M_surattugas->getDataAsesi3($id);

		// pemilihan path dokumen
		$path = empty($this->M_surattugas->getDataAsesor($id)) ? "./assets/template/surat-tugas-default.rtf" : "./assets/template/surat-tugas.rtf";
		$document = file_get_contents($path);

		// isi dokumen dinyatakan dalam bentuk string
		$document = str_replace("#nosurat", $dataNoSurat, $document);
		$document = str_replace("#batch", $dataBatch, $document);
		$document = str_replace("#tanggal", date('d F Y', strtotime($dataTglSurat)), $document);
		$document = str_replace("#tgl", date('d F Y', strtotime($dataTglPelaksanaan)), $document);
		$document = str_replace("#skema", $dataSkema, $document);
		$document = str_replace("#asesor", $dataAsesor, $document);
		$document = str_replace("#asesi1", $dataAsesi1, $document);
		$document = str_replace("#asesi2", $dataAsesi2, $document);
		$document = str_replace("#asesi3", $dataAsesi3, $document);

		// header untuk membuka file output RTF dengan MS. Word
		header("Content-type: application/msword");
		header("Content-disposition: inline; filename= .$dataNoUrut. Surat Tugas $dataPerihal.doc");
		header("Content-length: ".strlen($document));
		echo $document;
	}

	public function update()
	{
		//menangkap id data yg dipilih dari view (parameter get)
		$id  					 = $this->uri->segment(4);
		$data_asesor 			 = $this->M_asesor->getDataAsesor();
		$data_surattugas_single  = $this->M_surattugas->read_single($id);
		$name  					 = $this->session->userdata('name');
		$image 					 = $this->session->userdata('image');
		$data_setting     		 = $this->M_setting->read();
        $data_skema			     = $this->M_skema->read();

		// pemilihan path dokumen
		$path = empty($this->M_surattugas->getDataAsesor($id)) ? "surat/surattugas/v_surattugas2_update" : "surat/surattugas/v_surattugas_update";

		//mengirim data ke view
		$output = array(
			'judul'	 			      => 'Surat tugas',
			'theme_page' 		   	  => $path,
			'data_asesor' 		  	  => $data_asesor,
			'data_surattugas_single'  => $data_surattugas_single,
			'data_setting'			  => $data_setting,
			'name'		 			  => $name,
			'skema'					  => $data_skema,
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
		$tgl_surat		= $this->input->post('tgl_surat');
		$perihal		= $this->input->post('perihal');
		$skema		  	= $this->input->post('skema');
		$tgl_pelaksanaan= $this->input->post('tgl_pelaksanaan');
		$batch      	= $this->input->post('batch');
		$asesor  	    = $this->input->post('asesor');
		$asesi1     	= $this->input->post('asesi1');
		$asesi2     	= $this->input->post('asesi2');
		$asesi3     	= $this->input->post('asesi3');
		$oldfile		= $this->input->post('userfileold');
				
        //menangkap id data yg dipilih dari view (parameter get)
        $id = $this->uri->segment(4);

		if (!empty($this->upload->do_upload('userfile'))) {
			
			//jika gagal upload
			if (!$this->upload->do_upload('userfile')) {
	
				$id  					 = $this->uri->segment(4);
				$data_asesor 			 = $this->M_asesor->getDataAsesor();
				$data_surattugas_single  = $this->M_surattugas->read_single($id);
				$name  					 = $this->session->userdata('name');
				$image 					 = $this->session->userdata('image');
				$data_setting     		 = $this->M_setting->read();
				$data_skema			     = $this->M_skema->read();

				//mengirim data ke view
				$output = array(
					'judul'	 			      => 'Surat tugas',
					'theme_page' 		   	  => 'surat/surattugas/v_surattugas_update',
					'data_asesor' 		  	  => $data_asesor,
					'data_surattugas_single'  => $data_surattugas_single,
					'data_setting'			  => $data_setting,
					'name'		 			  => $name,
					'skema'					  => $data_skema,
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
					'tgl_surat' 	 => $tgl_surat,
					'perihal' 	 	 => $perihal,
					'skema' 	  	 => $skema,
					'tgl_surat'  	 => $tgl_surat,
					'tgl_pelaksanaan'=> $tgl_pelaksanaan,
					'batch'	  	 	 => $batch,
					'asesor' 	 	 => $asesor,
					'asesi1'		 => $asesi1,
					'asesi2'		 => $asesi2,
					'asesi3'		 => $asesi3,
					'lampiran'    	 => $upload_data
				);
	
				$data_surat = $this->M_surattugas->update($input, $id);

				$id = $this->uri->segment(4);

				// Mengambil data dari Model
				$no_surat = $this->M_surattugas->getDataNoSurat($id);

				// input data log
				date_default_timezone_set('Asia/Jakarta');
                $name       = $this->session->userdata('name');
                $date       = date('l, d F Y H:i:s');
                $activity   = $name.' mengubah data surat tugas : <b>'.$no_surat.'</b>';

                // mengirim data ke model
				$input_log = array(
                    // format : nama field/kolom table => data input dari view
                    'activity' 	=> $activity,
                    'date'	    => $date,
                );

                $data_log = $this->M_log->insert($input_log);
	
				//mengembalikan halaman ke function read
				$this->session->set_tempdata('message', 'Data berhasil disimpan', 1);
				Redirect('admin/surattugas/read');
			}

		} else {

			//mengirim data ke model
			$input = array(
				//format : nama field/kolom table => data input dari view
				'tgl_surat' 	 => $tgl_surat,
				'perihal' 	 	 => $perihal,
				'skema' 	  	 => $skema,
				'tgl_surat'  	 => $tgl_surat,
				'tgl_pelaksanaan'=> $tgl_pelaksanaan,
				'batch'	  	 	 => $batch,
				'asesor' 	 	 => $asesor,
				'asesi1'		 => $asesi1,
				'asesi2'		 => $asesi2,
				'asesi3'		 => $asesi3,
			);

			$data_surat = $this->M_surattugas->update($input, $id);

			// Mengambil data dari Model
			$no_surat = $this->M_surattugas->getDataNoSurat($id);

			// input data log
			date_default_timezone_set('Asia/Jakarta');
			$name       = $this->session->userdata('name');
			$date       = date('l, d F Y H:i:s');
			$activity   = $name.' mengubah data surat tugas : <b>'.$no_surat.'</b>';

			// mengirim data ke model
			$input_log = array(
				// format : nama field/kolom table => data input dari view
				'activity' 	=> $activity,
				'date'	    => $date,
			);

			$data_log = $this->M_log->insert($input_log);

			//mengembalikan halaman ke function read
			$this->session->set_tempdata('message', 'Data berhasil disimpan', 1);
			Redirect('admin/surattugas/read');
		}

    }

	public function delete() {

		$id = $this->uri->segment(4);

		$this->db->db_debug = false; //disable debugging queries

		// Mengambil data dari Model
		$no_surat  = $this->M_surattugas->getDataNoSurat($id);

		// Input data log
		date_default_timezone_set('Asia/Jakarta');
		$name       = $this->session->userdata('name');
		$date       = date('l, d F Y H:i:s');
		$activity   = $name.' delete data surat tugas : <b>'.$no_surat.'</b>';

		// mengirim data ke model
		$input_log = array(
			// format : nama field/kolom table => data input dari view
			'activity' 	=> $activity,
			'date'	    => $date,
		);

		$data_log = $this->M_log->insert($input_log);
		
		// Error handling
		if (!$this->M_surattugas->delete($id)) {
			$msg =  $this->db->error();
			$this->session->set_tempdata('error', $msg['message'], 1);
		}

		//mengembalikan halaman ke function read
		$this->session->set_tempdata('message','Data berhasil dihapus',1);
		redirect('admin/surattugas/read');
	}

	public function detail()
    {

        $id           	= $this->uri->segment(4);
        $dt_surattugas  = $this->M_surattugas->detail($id);
		$name  			= $this->session->userdata('name');
		$image 			= $this->session->userdata('image');
		$data_setting   = $this->M_setting->read();
        
        // mengirim data ke view
        $output = array(
            'theme_page'     => 'surat/surattugas/v_surattugas_detail',
            'judul'          => 'Detail surat tugas',
            'dt_surattugas'  => $dt_surattugas,
			'data_setting'   => $data_setting,
			'name'		 	 => $name,
			'image'		 	 => $image,
        );

        // memanggil file view
        $this->load->view('admin/theme/index', $output);
    }
}