<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suratkeluar extends CI_Controller {

	public function __construct() 
	{
		parent::__construct();

		if (empty($this->session->userdata('username'))) {
			redirect('admin/auth');
		}
		if ($this->session->userdata('is_active') == 'n') {
			redirect('admin/auth');
		}
        $this->load->model(array('m_suratkeluar', 'm_category', 'm_divisi','m_setting'));
    }

    public function index() 
	{

		$this->read();
	}

	public function read() 
	{
	
		$name  = $this->session->userdata('name');
		$image = $this->session->userdata('image');
		$data_setting  = $this->m_setting->read();

		$output = array(
						'theme_page'  => 'surat/v_suratkeluar.php',
						'judul' 	  => 'Surat keluar',
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
				return "I";
				break;
			case 2:
				return "II";
				break;
			case 3:
				return "III";
				break;
			case 4:
				return "IV";
				break;
			case 5:
				return "V";
				break;
			case 6:
				return "VI";
				break;
			case 7:
				return "VII";
				break;
			case 8:
				return "VIII";
				break;
			case 9:
				return "IX";
				break;
			case 10:
				return "X";
				break;
			case 11:
				return "XI";
				break;
			case 12:
				return "XII";
				break;
	  }
	}

	public function datatables()
	{
		//menunda loading (bisa dihapus, hanya untuk menampilkan pesan processing)
		// sleep(2);

		//memanggil fungsi model datatables
		$list = $this->m_suratkeluar->get_datatables();
		$data = array();
		$no = $this->input->post('start');

		//mencetak data json
		foreach ($list as $field) {
			$no++;
			$date1 = date_create($field['tgl_surat']);
			$row = array();
			$row[] = $no;
			$row[] = '<b>No: </b>'.$field['no_surat'].'<br><b>Perihal: </b>'.$field['perihal'].'<br><b>Tanggal surat: </b>'.date_format($date1, "D, d M Y");
			$row[] = $field['jenis_surat'];
			$row[] = $field['tujuan'];
			$row[] = $field['divisi'];
			$row[] = $field['keterangan'];
			$row[] = '
				<div class="btn-group" role="group" aria-label="Basic outlined example">
					<a href="'.site_url('admin/suratkeluar/detail/'.$field['id_surat']).'" class="btn btn-info btn-sm" title="View" data = "'.$field['id_surat'].'">
						<i class="fas fa-search"></i> 
					</a>
					<a href="'.site_url('admin/suratkeluar/update/'.$field['id_surat']). '" class="btn btn-warning btn-sm " title="Edit">
						<i class="fas fa-edit"></i> 
					</a>
					<a href="'.site_url('admin/suratKeluar/getTemplate/'.$field['id_surat']). '" class="btn btn-success btn-sm " title="Template">
						<i class="fas fa-file-invoice-dollar"></i> 
					</a>
					<a href="'.site_url('admin/suratkeluar/delete/'.$field['id_surat']).'" class="btn btn-danger btn-sm btnHapus" title="Hapus" data = "'.$field['id_surat'].'">
						<i class="fas fa-trash-alt"></i> 
					</a>
				</div>
					';

			$data[] = $row;
		}

		//mengirim data json
		$output = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $this->m_suratkeluar->count_all(),
			"recordsFiltered" => $this->m_suratkeluar->count_filtered(),
			"data" => $data,
		);

		//output dalam format JSON
		echo json_encode($output);
	}

	public function insert() 
	{

		$this->insert_submit();

        $data_category = $this->m_category->read();
		$data_divisi   = $this->m_divisi->read();
		$name  = $this->session->userdata('name');
		$image = $this->session->userdata('image');
		$data_setting  = $this->m_setting->read();

		// no urut surat
		$year 		= date('Y'); 
		$maxData    = $this->m_suratkeluar->getMaxData($year);
		$no_urut 	= $maxData + 1;
	
		// mengirim data ke view
		$output = array(
						'theme_page' 	=> 'surat/v_suratkeluar_insert',
						'judul' 	 	=> 'Surat keluar',
                        'data_category' => $data_category,
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
			$this->form_validation->set_rules('jenis_surat', 'Jenis surat', 'required');
			$this->form_validation->set_rules('perihal', 'Perihal', 'required');
			$this->form_validation->set_rules('tujuan', 'Tujuan', 'required');
			$this->form_validation->set_rules('tgl_surat', 'Tanggal surat', 'required');
			$this->form_validation->set_rules('divisi', 'Divisi', 'required');
			$this->form_validation->set_rules('ket', 'Keterangan');

			if ($this->form_validation->run() == TRUE) {

				// menangkap data input dari view
				$no_urut		= $this->input->post('no_urut');
				$jenis_surat	= $this->input->post('jenis_surat');
				$perihal	  	= $this->input->post('perihal');
				$tujuan 	  	= $this->input->post('tujuan');
				$tgl_surat      = $this->input->post('tgl_surat');
				$divisi  	    = $this->input->post('divisi');
				$keterangan     = $this->input->post('ket');

				$getBulan	 = date('n', strtotime($tgl_surat));
				$bulan		 = $this->getRomawi($getBulan);
				$year		 = date('Y');
				$no_surat	 = $jenis_surat.'.'.$no_urut.'/'.$divisi.'./LSP-HCMI/'.$bulan.'/'.$year;
				
				//mengirim data ke model
				$input = array(
					//format : nama field/kolom table => data input dari view
					'no_urut'		 => $no_urut,
					'kd_jenis_surat' => $jenis_surat,
					'perihal' 	  	 => $perihal,
					'tgl_surat'  	 => $tgl_surat,
					'tujuan'    	 => $tujuan,
					'kd_divisi'	  	 => $divisi,
					'keterangan' 	 => $keterangan,
					'no_surat'		 => $no_surat ,
					'tahun'			 => $year
				);
				
				$data_suratkeluar = $this->m_suratkeluar->insert($input);
	
				//mengembalikan halaman ke function read
				$this->session->set_tempdata('confirm', 'Data berhasil ditambahkan', 1);
				Redirect('admin/suratkeluar/read');

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

	public function getTemplate() 
	{
		$document = file_get_contents("./assets/template.rtf");
		$id  	  = $this->uri->segment(4);

		// menangkap data input dari view
		$lastDataNoSurat		= $this->m_suratkeluar->getLastDataNoSurat($id);
		$lastDataPerihal		= $this->m_suratkeluar->getLastDataPerihal($id);
		$lastDataTujuan	     	= $this->m_suratkeluar->getLastDataTujuan($id);
		$lastDataTanggal		= $this->m_suratkeluar->getLastDataTanggal($id);

		$no_surat 	  	= $lastDataNoSurat;
		$perihal	  	= $lastDataPerihal;
		$tujuan			= $lastDataTujuan;
		$tgl_surat      = $lastDataTanggal;

		// isi dokumen dinyatakan dalam bentuk string
		$document = str_replace("#tujuan", $tujuan, $document);
		$document = str_replace("#tanggal", date('d F Y', strtotime($tgl_surat)), $document);
		$document = str_replace("#perihal", $perihal, $document);
		$document = str_replace("#nosurat", $no_surat, $document);

		// header untuk membuka file output RTF dengan MS. Word
		header("Content-type: application/msword");
		header("Content-disposition: inline; filename=template.doc");
		header("Content-length: ".strlen($document));
		echo $document;
	}

	public function update()
	{

		//menangkap id data yg dipilih dari view (parameter get)
		$id  					 = $this->uri->segment(4);
        $data_category 			 = $this->m_category->read();
		$data_suratkeluar_single = $this->m_suratkeluar->read_single($id);
		$data_divisi   			 = $this->m_divisi->read();
		$name  					 = $this->session->userdata('name');
		$image 					 = $this->session->userdata('image');
		$data_setting     		 = $this->m_setting->read();

		//mengirim data ke view
		$output = array(
			'judul'	 			      => 'Surat keluar',
			'theme_page' 		   	  => 'surat/v_suratkeluar_update',
			'data_category' 		  => $data_category,
			'data_suratkeluar_single' => $data_suratkeluar_single,
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
		$no_urut		= $this->input->post('id_surat');
		$jenis_surat	= $this->input->post('jenis_surat');
		$perihal	  	= $this->input->post('perihal');
		$tujuan 	  	= $this->input->post('tujuan');
		$tgl_surat      = $this->input->post('tgl_surat');
		$divisi  	    = $this->input->post('divisi');
		$keterangan     = $this->input->post('ket');
		$tahun 			= $this->input->post('tahun');
		$oldfile		= $this->input->post('userfileold');

		$getBulan	 = date('n');
		$bulan		 = $this->getRomawi($getBulan);
		$year		 = date('Y');
		$no_surat	 = $jenis_surat.'.'.$no_urut.'/'.$divisi.'./LSP-HCMI/'.$bulan.'/'.$year;
				
        //menangkap id data yg dipilih dari view (parameter get)
        $id = $this->uri->segment(4);

		if (!empty($this->upload->do_upload('userfile'))) {
			
			//jika gagal upload
			if (!$this->upload->do_upload('userfile')) {
	
				//menangkap id data yg dipilih dari view (parameter get)
				$id  					 = $this->uri->segment(4);
				$data_category 			 = $this->m_category->read();
				$data_suratkeluar_single = $this->m_suratkeluar->read_single($id);
				$data_divisi   			 = $this->m_divisi->read();
				$name  					 = $this->session->userdata('name');
				$image 					 = $this->session->userdata('image');
				$data_setting     		 = $this->m_setting->read();

				//mengirim data ke view
				$output = array(
					'judul'	 			      => 'Surat keluar',
					'theme_page' 		   	  => 'surat/v_suratkeluar_update',
					'data_category' 		  => $data_category,
					'data_suratkeluar_single' => $data_suratkeluar_single,
					'data_divisi'			  => $data_divisi,
					'data_setting'			  => $data_setting,
					'name'		 			  => $name,
					'image'		 			  => $image
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
					'kd_jenis_surat' => $jenis_surat,
					'perihal' 	  	 => $perihal,
					'tgl_surat'  	 => $tgl_surat,
					'tujuan'    	 => $tujuan,
					'kd_divisi'	  	 => $divisi,
					'keterangan' 	 => $keterangan,
					'no_surat'		 => $no_surat,
					'tahun'			 => $tahun,
					'lampiran'    	 => $upload_data
				);
	
				$data_surat = $this->m_suratkeluar->update($input, $id);
	
				//mengembalikan halaman ke function read
				$this->session->set_tempdata('message', 'Data berhasil disimpan', 1);
				Redirect('admin/suratkeluar/read');
			}

		} else {

			//mengirim data ke model
			$input = array(
				//format : nama field/kolom table => data input dari view
				'id_surat'		 => $no_urut,
				'kd_jenis_surat' => $jenis_surat,
				'perihal' 	  	 => $perihal,
				'tgl_surat'  	 => $tgl_surat,
				'tujuan'    	 => $tujuan,
				'kd_divisi'	  	 => $divisi,
				'keterangan' 	 => $keterangan,
				'no_surat'		 => $no_surat,
				'lampiran'    	 => $oldfile,
				'tahun'			 => $tahun
			);

			$data_surat = $this->m_suratkeluar->update($input, $id);

			//mengembalikan halaman ke function read
			$this->session->set_tempdata('message', 'Data berhasil disimpan', 1);
			Redirect('admin/suratkeluar/read');
		}

    }

	public function delete() {

		$id = $this->uri->segment(4);

		$this->db->db_debug = false; //disable debugging queries
		
		// Error handling
		if (!$this->m_suratkeluar->delete($id)) {
			$msg =  $this->db->error();
			$this->session->set_tempdata('error', $msg['message'], 1);
		}

		//mengembalikan halaman ke function read
		$this->session->set_tempdata('message','Data berhasil dihapus',1);
		redirect('admin/suratkeluar/read');
	}

	public function detail()
    {

        $id           	= $this->uri->segment(4);
        $dt_suratkeluar = $this->m_suratkeluar->detail($id);
		$name  			= $this->session->userdata('name');
		$image 			= $this->session->userdata('image');
		$data_setting   = $this->m_setting->read();
        
        // mengirim data ke view
        $output = array(
            'theme_page'     => 'surat/v_suratkeluar_detail',
            'judul'          => 'Detail surat keluar',
            'dt_suratkeluar' => $dt_suratkeluar,
			'data_setting'   => $data_setting,
			'name'		 	 => $name,
			'image'		 	 => $image,
        );

        // memanggil file view
        $this->load->view('admin/theme/index', $output);
    }
}