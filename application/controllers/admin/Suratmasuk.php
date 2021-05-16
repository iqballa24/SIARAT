<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suratmasuk extends CI_Controller {

	public function __construct() {
		parent::__construct();

		// if (empty($this->session->userdata('NIP'))) {
		// 	redirect('petugas/login');
		// }
        $this->load->model(array('m_suratmasuk', 'm_category'));
    }

    public function index() {

		$this->read();
	}

	public function read() {
	
		// $NIP = $this->session->userdata('nama');

		$output = array(
						'theme_page' => 'surat/v_suratmasuk.php',
						'judul' 	 => 'Surat masuk'
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
			$row[] = '<b>No surat: </b>'.$field['no_surat'].'<br><b>Perihal: </b>'.$field['perihal'].'<br><b>Tanggal surat: </b>'.date_format($date2, "D, d M Y");
			$row[] = date_format($date1, "D, d M Y");
			$row[] = $field['jenis_surat'];
			$row[] = $field['keterangan'];
			$row[] = '
					<a href="'.site_url('admin/suratmasuk/detail/'.$field['id']).'" class="btn btn-info btn-sm" title="View" data = "'.$field['id'].'">
						<i class="fas fa-search"></i> 
					</a>
					<a href="'.site_url('admin/suratmasuk/update/'.$field['id']). '" class="btn btn-warning btn-sm " title="Edit">
						<i class="fas fa-edit"></i> 
					</a>
					<a href="'.site_url('admin/suratmasuk/delete/'.$field['id']).'" class="btn btn-danger btn-sm btnHapus" title="Hapus" data = "'.$field['id'].'">
						<i class="fas fa-trash-alt"></i> 
					</a>
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
	
		// mengirim data ke view
		$output = array(
						'theme_page' 	=> 'surat/v_suratmasuk_insert',
						'judul' 	 	=> 'Surat masuk',
                        'data_category' => $data_category
					);

		// memanggil file view
		$this->load->view('admin/theme/index', $output);
	}

	public function insert_submit() {

		if ($this->input->post('submit') == 'Simpan') {

			//aturan validasi input login
			$this->form_validation->set_rules('no_surat', 'No surat', 'required|callback_insert_check');
			$this->form_validation->set_rules('perihal', 'Perihal', 'required');
			$this->form_validation->set_rules('tgl_terima', 'Tanggal terima', 'required');
			$this->form_validation->set_rules('jenis_surat', 'Jenis surat', 'required');
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
				$tgl_terima     = $this->input->post('tgl_terima');
				$jenis_surat	= $this->input->post('jenis_surat');
				$tgl_surat  	= $this->input->post('tgl_surat');
				$keterangan     = $this->input->post('ket');

				//jika gagal upload
                if (!$this->upload->do_upload('userfile')) {
        
                    $response = $this->upload->display_errors();
                    $data_category = $this->m_category->read();
	
                    $output = array(
                        'theme_page' 	=> 'surat/v_suratmasuk_insert',
                        'judul' 	 	=> 'Surat masuk',
                        'response'      => $response,
                        'data_category' => $data_category
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
                        'no_surat'    => $no_surat,
                        'perihal' 	  => $perihal,
                        'tgl_terima'  => $tgl_terima,
                        'jenis_surat' => $jenis_surat,
                        'tgl_surat'   => $tgl_surat,
                        'keterangan'  => $keterangan,
                        'lampiran'    => $upload_data,
                    );
    
                    //memanggil function insert pada kota model
                    //function insert berfungsi menyimpan/create data ke table buku di database
                    $data_suratmasuk = $this->m_suratmasuk->insert($input);
        
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

		$this->update_submit();
		//menangkap id data yg dipilih dari view (parameter get)
		$id  = $this->uri->segment(4);
        $data_category = $this->m_category->read();
		$data_suratmasuk_single = $this->m_suratmasuk->read_single($id);

		//mengirim data ke view
		$output = array(
			'judul'	 		=> 'Surat masuk',
			'theme_page' 	=> 'surat/v_suratmasuk_update',
			'data_category' => $data_category,
			'data_suratmasuk_single' => $data_suratmasuk_single,
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
		$tgl_terima     = $this->input->post('tgl_terima');
		$jenis_surat	= $this->input->post('jenis_surat');
		$tgl_surat  	= $this->input->post('tgl_surat');
		$keterangan     = $this->input->post('ket');

        //menangkap id data yg dipilih dari view (parameter get)
        $id = $this->uri->segment(4);

        //jika gagal upload
        if (!$this->upload->do_upload('userfile')) {

			$id  					= $this->uri->segment(4);
			$data_category			= $this->m_category->read();
            $response 				= $this->upload->display_errors();
			$data_suratmasuk_single = $this->m_suratmasuk->read_single($id);
	
			//mengirim data ke view
			$output = array(
				'judul'	 				 => 'Surat masuk',
				'theme_page' 			 => 'surat/v_suratmasuk_update',
				'data_category' 		 => $data_category,
				'response'				 => $response,
				'data_suratmasuk_single' => $data_suratmasuk_single,
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
				'tgl_terima'  	=> $tgl_terima,
				'kd_jenis_surat'=> $jenis_surat,
				'tgl_surat'   	=> $tgl_surat,
				'keterangan'  	=> $keterangan,
				'lampiran'    	=> $upload_data
            );

            //memanggil function insert pada kota model
            //function insert berfungsi menyimpan/create data ke table buku di database
            $data_buku = $this->m_suratmasuk->update($input, $id);

            //mengembalikan halaman ke function read
            $this->session->set_tempdata('message', 'Data berhasil disimpan', 1);
            Redirect('admin/suratmasuk/read');
        }
    }

	public function delete() {

		$id = $this->uri->segment(4);

		$this->db->db_debug = false; //disable debugging queries
		
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
        
        // mengirim data ke view
        $output = array(
            'theme_page'    => 'surat/v_suratmasuk_detail',
            'judul'         => 'Detail surat masuk',
            'dt_suratmasuk' => $dt_suratmasuk
        );

        // memanggil file view
        $this->load->view('admin/theme/index', $output);
    }
}