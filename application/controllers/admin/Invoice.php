<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends CI_Controller {

	public function __construct() {
		parent::__construct();

		if (empty($this->session->userdata('username')) && $this->session->userdata('level') == '2' ) {
			redirect('admin/auth');
		}

		if ($this->session->userdata('is_active') == 'n') {
			redirect('admin/auth');
		}

        $this->load->model(array('M_invoice','M_setting','M_log'));
    }

    public function index() {

		$this->read();
	}

	public function read() {
	
		$name  = $this->session->userdata('name');
		$image = $this->session->userdata('image');
		$data_setting  = $this->M_setting->read();

		$output = array(
						'theme_page'   => 'invoice/v_invoice.php',
						'judul' 	   => 'Invoice',
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
		$list = $this->M_invoice->get_datatables();
		$data = array();
		$no = $this->input->post('start');

		//mencetak data json
		foreach ($list as $field) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $field['no_invoice'];
			$row[] = date('d F Y', strtotime($field['tgl_invoice']));
			$row[] = $field['jatuh_tempo'];
			$row[] = $field['tujuan'];
			$row[] = $field['lokasi'];
			$row[] = $field['status'] == '1' ? '<div class ="btn btn-success btn-xs disabled">Lunas</div>' : '<div class="btn btn-danger btn-xs disabled">Belum Lunas</div>';
			$row[] = $field['lampiran'] == '' ? '<a href="'.site_url('admin/invoice/update/'.$field['id']).'" title="Upload"> <i class="fas fa-file-upload
			"></i> </a>' : '<a href="'.base_url('upload_folder/pdf/'.$field['lampiran']).'">'.$field['lampiran'].'</a>';
			$row[] = '
				<div class="btn-group" role="group" aria-label="Basic outlined example">
					<a href="'.site_url('admin/invoice/detail/'.$field['id']).'" class="btn btn-info btn-sm" title="View" data = "'.$field['id'].'">
						<i class="fas fa-search"></i> 
					</a>
					<a href="'.site_url('admin/invoice/update/'.$field['id']). '" class="btn btn-warning btn-sm " title="Edit">
						<i class="fas fa-edit"></i> 
					</a>
					<a href="'.site_url('admin/invoice/getTemplate/'.$field['id']). '" class="btn btn-success btn-sm " title="Template">
						<i class="fas fa-file-invoice-dollar"></i> 
					</a>
					<a href="'.site_url('admin/invoice/delete/'.$field['id']).'" class="btn btn-danger btn-sm btnHapus" title="Hapus" data = "'.$field['id'].'">
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
	}

	public function insert_submit() {

		if ($this->input->post('submit') == 'Simpan') {

			//aturan validasi input login
			$this->form_validation->set_rules('no_urut', 'No urut', 'required');
			$this->form_validation->set_rules('date', 'Tanggal Invoice', 'required');
			$this->form_validation->set_rules('jatuh_tempo', 'Jatuh Tempo');
			$this->form_validation->set_rules('tujuan', 'Tujuan', 'required');
			$this->form_validation->set_rules('lokasi', 'Lokasi', 'required');
			$this->form_validation->set_rules('status', 'Status', 'required');
			$this->form_validation->set_rules('terbilang', 'Terbilang', 'required');
			$this->form_validation->set_rules('uraian', 'Uraian', 'required');
			$this->form_validation->set_rules('kuantitas', 'Qty', 'required');
			$this->form_validation->set_rules('harga', 'Harga', 'required');
			$this->form_validation->set_rules('diskon', 'Diskon');

			if ($this->form_validation->run() == TRUE) {

				// menangkap data input dari view
				$no_invoice	 = $this->input->post('no_urut');
				$date	  	 = $this->input->post('date');
				$jatuh_tempo = $this->input->post('jatuh_tempo');
				$tujuan	  	 = $this->input->post('tujuan');
				$lokasi	  	 = $this->input->post('lokasi');
				$status	  	 = $this->input->post('status');
				$uraian	  	 = $this->input->post('uraian');
				$kuantitas	 = $this->input->post('kuantitas');
				$harga	  	 = preg_replace('/[Rp. ]/','',$this->input->post('harga'));
				$diskon	  	 = $this->input->post('diskon') == '' ? '0' : $this->input->post('diskon') ;
				$terbilang	 = $this->input->post('terbilang');
				$year		 = date('Y');
		
				// mengirim data ke model
				$input = array(
								// format : nama field/kolom table => data input dari view
								'no_invoice' 	=> $no_invoice,
								'tgl_invoice'	=> $date,
								'jatuh_tempo'	=> $jatuh_tempo,
								'tujuan'		=> $tujuan,
								'lokasi'		=> $lokasi,
								'status'		=> $status,
								'uraian'		=> $uraian,
								'kuantitas'		=> $kuantitas,
								'harga'			=> $harga,
								'diskon'		=> $diskon,
								'terbilang'		=> $terbilang,
								'insert_kwitansi'=> 'n',
								'tahun'			=> $year,
							);
		
				$data_invoice = $this->M_invoice->insert($input);

				// input data log
				date_default_timezone_set('Asia/Jakarta');
                $name       = $this->session->userdata('name');
                $date       = date('l, d F Y H:i:s');
                $activity   = $name.' menambahkan data invoice : <b>'.$no_invoice.'</b>';

                // mengirim data ke model
				$input_log = array(
                    // format : nama field/kolom table => data input dari view
                    'activity' 	=> $activity,
                    'date'	    => $date,
                );

                $data_log = $this->M_log->insert($input_log);

				// mengembalikan halaman ke function read
				$this->session->set_tempdata('message', 'Data berhasil ditambahkan !', 1);
				redirect('admin/invoice/read');
			}

		}

	}

	public function update()
	{
		//menangkap id data yg dipilih dari view (parameter get)
		$id    = $this->uri->segment(4);
		$name  = $this->session->userdata('name');
		$image = $this->session->userdata('image');
		$data_setting  = $this->M_setting->read();

		//function read berfungsi mengambil 1 data dari table kategori sesuai id yg dipilih
		$data_invoice_single = $this->M_invoice->read_single($id);

		//mengirim data ke view
		$output = array(
			'judul'	 		=> 'Update Invoice',
			'theme_page' 	=> 'invoice/v_invoice_update',
			'data_setting'  => $data_setting,
			'name'		 	=> $name,
			'image'		 	=> $image,

			//mengirim data kota yang dipilih ke view
			'data_invoice_single' => $data_invoice_single,
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
		$no_invoice	 = $this->input->post('no_urut');
		$date	  	 = $this->input->post('date');
		$jatuh_tempo = $this->input->post('jatuh_tempo');
		$tujuan	  	 = $this->input->post('tujuan');
		$lokasi	  	 = $this->input->post('lokasi');
		$status	  	 = $this->input->post('status');
		$uraian	  	 = $this->input->post('uraian');
		$kuantitas	 = $this->input->post('kuantitas');
		$harga	  	 = $this->input->post('harga');
		$diskon	  	 = $this->input->post('diskon') == '' ? '0' : $this->input->post('diskon') ;
		$terbilang	 = $this->input->post('terbilang');
				
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
					'no_invoice' 	=> $no_invoice,
					'tgl_invoice'	=> $date,
					'jatuh_tempo'	=> $jatuh_tempo,
					'tujuan'		=> $tujuan,
					'lokasi'		=> $lokasi,
					'status'		=> $status,
					'uraian'		=> $uraian,
					'kuantitas'		=> $kuantitas,
					'harga'			=> $harga,
					'diskon'		=> $diskon,
					'terbilang'		=> $terbilang,
					'lampiran'    	=> $upload_data
				);
	
				$data_invoice = $this->M_invoice->update($input, $id);

				// input data log
				date_default_timezone_set('Asia/Jakarta');
                $name       = $this->session->userdata('name');
                $date       = date('l, d F Y H:i:s');
                $activity   = $name.' mengubah data invoice : <b>'.$no_invoice.'</b>';

                // mengirim data ke model
				$input_log = array(
                    // format : nama field/kolom table => data input dari view
                    'activity' 	=> $activity,
                    'date'	    => $date,
                );

                $data_log = $this->M_log->insert($input_log);
	
				//mengembalikan halaman ke function read
				$this->session->set_tempdata('message', 'Data berhasil disimpan', 1);
				Redirect('admin/invoice/read');
			}

		} else {

			//mengirim data ke model
			$input = array(
				//format : nama field/kolom table => data input dari view
				'no_invoice' 	=> $no_invoice,
				'tgl_invoice'	=> $date,
				'jatuh_tempo'	=> $jatuh_tempo,
				'tujuan'		=> $tujuan,
				'lokasi'		=> $lokasi,
				'status'		=> $status,
				'uraian'		=> $uraian,
				'kuantitas'		=> $kuantitas,
				'harga'			=> $harga,
				'diskon'		=> $diskon,
				'terbilang'		=> $terbilang
			);

			$data_invoice = $this->M_invoice->update($input, $id);

			// input data log
			date_default_timezone_set('Asia/Jakarta');
			$name       = $this->session->userdata('name');
			$date       = date('l, d F Y H:i:s');
			$activity   = $name.' mengubah data invoice : <b>'.$no_invoice.'</b>';

			// mengirim data ke model
			$input_log = array(
				// format : nama field/kolom table => data input dari view
				'activity' 	=> $activity,
				'date'	    => $date,
			);

			$data_log = $this->M_log->insert($input_log);

			//mengembalikan halaman ke function read
			$this->session->set_tempdata('message', 'Data berhasil disimpan', 1);
			Redirect('admin/invoice/read');
		}

    }

	public function delete() {

		$id = $this->uri->segment(4);

		$this->db->db_debug = false; //disable debugging queries

		// Mengambil data dari Model
		$invoice  = $this->M_invoice->getDataNoInvoice($id);

		// Input data log
		date_default_timezone_set('Asia/Jakarta');
		$name       = $this->session->userdata('name');
		$date       = date('l, d F Y H:i:s');
		$activity   = $name.' delete data invoice : <b>'.$invoice.'</b>';

		// mengirim data ke model
		$input_log = array(
			// format : nama field/kolom table => data input dari view
			'activity' 	=> $activity,
			'date'	    => $date,
		);

		$data_log = $this->M_log->insert($input_log);
		
		// Error handling
		if (!$this->M_invoice->delete($id)) {
			$msg =  $this->db->error();
			$this->session->set_tempdata('error', $msg['message'], 1);
		}

		//mengembalikan halaman ke function read
		$this->session->set_tempdata('message','Data berhasil dihapus',1);
		redirect('admin/invoice/read');
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
		$document = file_get_contents("./assets/template/invoice.rtf");

		// menangkap data input dari view
		$no_invoice 	  	= $this->M_invoice->getDataNoInvoice($id);
		$tgl_invoice 	  	= $this->M_invoice->getDataTglInvoice($id);
		$jatuh_tempo 	  	= $this->M_invoice->getDataJatuhTempo($id);
		$tujuan		 	  	= $this->M_invoice->getDataTujuan($id);
		$lokasi		 	  	= $this->M_invoice->getDataLokasi($id);
		$uraian		 	  	= $this->M_invoice->getDataUraian($id);
		$qty		 	  	= $this->M_invoice->getDataQty($id);
		$harga		 	  	= $this->M_invoice->getDataHarga($id);
		$diskon		 	  	= $this->M_invoice->getDataDiskon($id);
		$total		 	  	= $this->M_invoice->getDataTotal($id);
		$terbilang	 	  	= $this->M_invoice->getDataTerbilang($id);
		$status 	  		= $this->M_invoice->getDataStatus($id);

		// isi dokumen dinyatakan dalam bentuk string
		$document = str_replace("#no_invoice", $no_invoice, $document);
		$document = str_replace("#tgl_invoice", date('d F Y', strtotime($tgl_invoice)), $document);
		$document = str_replace("#jatuh_tempo", $jatuh_tempo, $document);
		$document = str_replace("#tujuan", $tujuan, $document);
		$document = str_replace("#lokasi", $lokasi, $document);
		$document = str_replace("#uraian", $uraian, $document);
		$document = str_replace("#qty", $qty, $document);
		$document = str_replace("#harga", 'Rp. '.number_format($harga,0,',','.'), $document);
		$document = str_replace("#diskon", $diskon == '0' ? '-': $diskon, $document);
		$document = str_replace("#total", 'Rp. '.number_format($total,0,',','.'), $document);
		$document = str_replace("#terbilang", $terbilang, $document);
		$document = str_replace("#status", $status == '1' ? 'Lunas' : 'Belum lunas', $document);

		// header untuk membuka file output RTF dengan MS. Word
		header("Content-type: application/msword");
		header("Content-disposition: inline; filename=$no_invoice.doc");
		header("Content-length: ".strlen($document));
		echo $document;
	}

	public function export_excel()
    {
        $data_invoice = $this->M_invoice->read();

        //mengirim data ke view
        $output = array(
            //data provinsi dikirim ke view
            'data_invoice' => $data_invoice,
        );

        //memanggil file view
        $this->load->view('admin/invoice/v_invoice_export_excel', $output);
    }
}