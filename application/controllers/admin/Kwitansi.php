<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class kwitansi extends CI_Controller {

	public function __construct() {
		parent::__construct();

		if (empty($this->session->userdata('username')) && $this->session->userdata('level') == '2' ) {
			redirect('admin/auth');
		}

		if ($this->session->userdata('is_active') == 'n') {
			redirect('admin/auth');
		}

        $this->load->model(array('M_invoice','M_setting','M_kwitansi','M_log'));
    }

    public function index() {

		$this->read();
	}

	public function read() {
	
		$name  = $this->session->userdata('name');
		$image = $this->session->userdata('image');
		$data_setting  = $this->M_setting->read();

		$output = array(
						'theme_page'   => 'kwitansi/v_kwitansi.php',
						'judul' 	   => 'Kwitansi',
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
		$list = $this->M_kwitansi->get_datatables();
		$data = array();
		$no = $this->input->post('start');
		
		//mencetak data json
		foreach ($list as $field) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $field['no_kwitansi'];
			$row[] = $field['tujuan'];
			$row[] = $field['terbilang'];
			$row[] = $field['tujuan_pembayaran'];
			$row[] = 'Rp. '.number_format($field['total']);
			$row[] = date('d F Y', strtotime($field['tgl_terima']));
			$row[] = $field['lampiran'] == '' ? '<a href="'.site_url('admin/invoice/update/'.$field['id']).'" title="Upload"> <i class="fas fa-file-upload
			"></i> </a>' : '<a href="'.base_url('upload_folder/pdf/'.$field['lampiran']).'" target="_blank">'.$field['lampiran'].'</a>';
			$row[] = '
				<div class="btn-group" role="group" aria-label="Basic outlined example">
					<a href="'.site_url('admin/kwitansi/update/'.$field['id_kwitansi']). '" class="btn btn-warning btn-sm " title="Edit">
						<i class="fas fa-edit"></i> 
					</a>
					<a href="'.site_url('admin/kwitansi/getTemplate/'.$field['id_kwitansi']). '" class="btn btn-success btn-sm " title="Template">
						<i class="fas fa-file-invoice-dollar"></i> 
					</a>
					<a href="'.site_url('admin/kwitansi/delete/'.$field['id_kwitansi']).'" class="btn btn-danger btn-sm btnHapus" title="Hapus" data = "'.$field['id'].'">
						<i class="fas fa-trash-alt"></i> 
					</a>
				</div>';

			$data[] = $row;
		}

		//mengirim data json
		$output = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $this->M_invoice->count_all(),
			"recordsFiltered" => $this->M_invoice->count_filtered(),
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
        $data_invoice = $this->M_kwitansi->getDataInvoice();
		
		// no urut surat
		$year 		= date('Y'); 
		$maxData    = $this->M_kwitansi->getMaxData($year);
        $nourut     = substr($maxData, 4, 4);
		$no_urut 	= $nourut + 1;
	
		// mengirim data ke view
		$output = array(
						'theme_page' 	=> 'kwitansi/v_kwitansi_insert',
						'judul' 	 	=> 'Kwitansi',
						'data_setting'  => $data_setting,
						'data_invoice'	=> $data_invoice,
						'year'			=> $year,
						'name'		    => $name,
						'image'		 	=> $image,
						'no_urut'		=> $no_urut
					);

		// memanggil file view
		$this->load->view('admin/theme/index', $output);
	}

	public function insert_submit() {

		if ($this->input->post('submit') == 'Simpan') {

			//aturan validasi input login
			$this->form_validation->set_rules('no_urut', 'No urut', 'required');
			$this->form_validation->set_rules('invoice', 'No invoice', 'required');
			$this->form_validation->set_rules('tujuan_pembayaran', 'Tujuan Pembayaran', 'required');
			$this->form_validation->set_rules('tgl_terima', 'Tanggal terima', 'required');

			if ($this->form_validation->run() == TRUE) {

				// menangkap data input dari view
				$no_kwitansi 		= $this->input->post('no_urut');
				$invoice	  	 	= $this->input->post('invoice');
				$tujuan_pembayaran 	= $this->input->post('tujuan_pembayaran');
				$tgl_terima	  	 	= $this->input->post('tgl_terima');
				$year		 		= date('Y');
		
				// mengirim data ke model
				$input = array(
								// format : nama field/kolom table => data input dari view
								'no_kwitansi' 		=> $no_kwitansi,
								'invoice'			=> $invoice,
								'tujuan_pembayaran'	=> $tujuan_pembayaran,
								'tgl_terima'		=> $tgl_terima,
								'tahun'				=> $year,
							);
		
				$data_invoice = $this->M_kwitansi->insert($input);

				// input data log
				date_default_timezone_set('Asia/Jakarta');
                $name       = $this->session->userdata('name');
                $date       = date('l, d F Y H:i:s');
                $activity   = $name.' menambahkan data kwitansi : <b>'.$no_kwitansi.'</b>';

                // mengirim data ke model
				$input_log = array(
                    // format : nama field/kolom table => data input dari view
                    'activity' 	=> $activity,
                    'date'	    => $date,
                );

                $data_log = $this->M_log->insert($input_log);

				// mengembalikan halaman ke function read
				$this->session->set_tempdata('message', 'Data berhasil ditambahkan !', 1);
				redirect('admin/kwitansi/read');
			}

		}

	}

	// public function insert_check()
	// {

	// 	//Menangkap data input dari view
	// 	$kode = $this->input->post('kode');

	// 	//check data di database
	// 	$data_user = $this->m_category->read_check($kode);

	// 	if (!empty($data_user)) {

	// 		//membuat pesan error
	// 		$this->form_validation->set_message('insert_check', "Kode surat " . $kode . " sudah ada dalam database");
	// 		$this->session->set_tempdata('error', "Tidak dapat memasukan data yang sama", 1);
	// 		return FALSE;
	// 	}
	// 	return TRUE;
	// }

	public function getInvoice()
	{
		// POST data 
		$postData = $this->input->post();

		// get data 
		$data = $this->M_kwitansi->getInvoice($postData);
		echo json_encode($data); 
	}

	public function update()
	{
		//menangkap id data yg dipilih dari view (parameter get)
		$id    = $this->uri->segment(4);
		$name  = $this->session->userdata('name');
		$image = $this->session->userdata('image');
		$data_setting  = $this->M_setting->read();

		//function read berfungsi mengambil 1 data dari table kategori sesuai id yg dipilih
		$data_kwitansi_single = $this->M_kwitansi->read_single($id);

		//mengirim data ke view
		$output = array(
			'judul'	 		=> 'Update Kwitansi',
			'theme_page' 	=> 'kwitansi/v_kwitansi_update',
			'data_setting'  => $data_setting,
			'name'		 	=> $name,
			'image'		 	=> $image,

			//mengirim data kota yang dipilih ke view
			'data_kwitansi_single' => $data_kwitansi_single,
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
		$no_kwitansi 		= $this->input->post('no_urut');
		$invoice	  	 	= $this->input->post('invoice');
		$tujuan_pembayaran 	= $this->input->post('tujuan_pembayaran');
		$tgl_terima	  	 	= $this->input->post('tgl_terima');
				
        //menangkap id data yg dipilih dari view (parameter get)
        $id = $this->uri->segment(4);

		if (!empty($this->upload->do_upload('userfile'))) {
			
			//jika gagal upload
			if (!$this->upload->do_upload('userfile')) {
	
				$name  = $this->session->userdata('name');
				$image = $this->session->userdata('image');
				$data_setting  = $this->M_setting->read();
				
				// no urut surat
				$year 		= date('Y'); 
				$maxData    = $this->M_invoice->getMaxData($year);
				$nourut     = substr($maxData, 13, 5);
				$no_urut 	= $nourut + 1;
			
				// mengirim data ke view
				$output = array(
						'theme_page' 	=> 'invoice/v_invoice_insert',
						'judul' 	 	=> 'Invoice',
						'data_setting'  => $data_setting,
						'name'		    => $name,
						'image'		 	=> $image,
						'no_urut'		=> $no_urut
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
					'no_kwitansi' 		=> $no_kwitansi,
					'tujuan_pembayaran'	=> $tujuan_pembayaran,
					'tgl_terima'		=> $tgl_terima,
					'lampiran'    		=> $upload_data
				);
	
				$data_kwitansi = $this->M_kwitansi->update($input, $id);

				// input data log
				date_default_timezone_set('Asia/Jakarta');
                $name       = $this->session->userdata('name');
                $date       = date('l, d F Y H:i:s');
                $activity   = $name.' mengubah data kwitansi : <b>'.$no_kwitansi.'</b>';

                // mengirim data ke model
				$input_log = array(
                    // format : nama field/kolom table => data input dari view
                    'activity' 	=> $activity,
                    'date'	    => $date,
                );

                $data_log = $this->M_log->insert($input_log);
	
				//mengembalikan halaman ke function read
				$this->session->set_tempdata('message', 'Data berhasil disimpan', 1);
				Redirect('admin/kwitansi/read');
			}

		} else {

			//mengirim data ke model
			$input = array(
				//format : nama field/kolom table => data input dari view
				'no_kwitansi' 		=> $no_kwitansi,
				'tujuan_pembayaran'	=> $tujuan_pembayaran,
				'tgl_terima'		=> $tgl_terima
			);

			$data_kwitansi = $this->M_kwitansi->update($input, $id);

			// input data log
			date_default_timezone_set('Asia/Jakarta');
			$name       = $this->session->userdata('name');
			$date       = date('l, d F Y H:i:s');
			$activity   = $name.' mengubah data kwitansi : <b>'.$no_kwitansi.'</b>';

			// mengirim data ke model
			$input_log = array(
				// format : nama field/kolom table => data input dari view
				'activity' 	=> $activity,
				'date'	    => $date,
			);

			$data_log = $this->M_log->insert($input_log);

			//mengembalikan halaman ke function read
			$this->session->set_tempdata('message', 'Data berhasil disimpan', 1);
			Redirect('admin/kwitansi/read');
		}

    }

	public function delete() {

		$id = $this->uri->segment(4);

		$this->db->db_debug = false; //disable debugging queries

		// Mengambil data dari Model
		$kwitansi  = $this->M_kwitansi->getDataNoKwitansi($id);

		// Input data log
		date_default_timezone_set('Asia/Jakarta');
		$name       = $this->session->userdata('name');
		$date       = date('l, d F Y H:i:s');
		$activity   = $name.' delete data kwitansi : <b>'.$kwitansi.'</b>';

		// mengirim data ke model
		$input_log = array(
			// format : nama field/kolom table => data input dari view
			'activity' 	=> $activity,
			'date'	    => $date,
		);

		$data_log = $this->M_log->insert($input_log);
		
		// Error handling
		if (!$this->M_kwitansi->delete($id)) {
			$msg =  $this->db->error();
			$this->session->set_tempdata('error', $msg['message'], 1);
		}

		//mengembalikan halaman ke function read
		$this->session->set_tempdata('message','Data berhasil dihapus',1);
		redirect('admin/kwitansi/read');
	}

	public function detail()
    {

        $id           	= $this->uri->segment(4);
        $data_invoice	= $this->M_invoice->detail($id);
		$name  			= $this->session->userdata('name');
		$image 			= $this->session->userdata('image');
		$data_setting   = $this->M_setting->read();
        
        // mengirim data ke view
        $output = array(
            'theme_page'     => 'invoice/v_invoice_detail',
            'judul'          => 'Detail Invoice',
            'data_invoice'	 => $data_invoice,
			'data_setting'   => $data_setting,
			'name'		 	 => $name,
			'image'		 	 => $image,
        );

        $this->load->view('admin/theme/index', $output);

	}

	public function getTemplate($id) 
	{
		$document = file_get_contents("./assets/template/Kwitansi.rtf");

		// menangkap data input dari view
		$DataNoKwitansi		 = $this->M_kwitansi->getDataNoKwitansi($id);
		$DataTujuan			 = $this->M_kwitansi->getDataTujuan($id);
		$DataTerbilang		 = $this->M_kwitansi->getDataTerbilang($id);
		$DataTujuanPembayaran= $this->M_kwitansi->getDataTujuanPembayaran($id);
		$DataTotal			 = $this->M_kwitansi->getDataTotal($id);
		$DataTglTerima		 = $this->M_kwitansi->getDataTglTerima($id);

		// isi dokumen dinyatakan dalam bentuk string
		$document = str_replace("#no_kwitansi", $DataNoKwitansi, $document);
		$document = str_replace("#tujuan", $DataTujuan, $document);
		$document = str_replace("#terbilang", $DataTerbilang, $document);
		$document = str_replace("#pembayaran", $DataTujuanPembayaran, $document);
		$document = str_replace("#terbilang", $DataTerbilang, $document);
		$document = str_replace("#total", 'Rp. '.number_format($DataTotal), $document);
		$document = str_replace("#tgl_terima", date('d F Y', strtotime($DataTglTerima)), $document);

		// header untuk membuka file output RTF dengan MS. Word
		header("Content-type: application/msword");
		header("Content-disposition: inline; filename=$DataNoKwitansi.doc");
		header("Content-length: ".strlen($document));
		echo $document;
	}

	public function export_excel()
    {
        $data_kwitansi = $this->M_kwitansi->read();

        //mengirim data ke view
        $output = array(
            //data provinsi dikirim ke view
            'data_kwitansi' => $data_kwitansi,
        );

        //memanggil file view
        $this->load->view('admin/kwitansi/v_kwitansi_export_excel', $output);
    }
}