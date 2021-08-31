<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sppd extends CI_Controller
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
		$this->load->model(array('M_sppd', 'm_setting', 'M_pegawai', 'M_log'));
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
			'theme_page'   => 'surat/sppd/v_sppd.php',
			'judul'        => 'Surat perintah perjalanan dinas',
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
		$list = $this->M_sppd->get_datatables();
		$data = array();
		$no = $this->input->post('start');

		//mencetak data json
		foreach ($list as $field) {
			$no++;
			$tgl_surat     = date_create($field['tanggal_surat']);
			$tgl_berangkat = date_create($field['tanggal_berangkat']);
			$tgl_kembali   = date_create($field['tanggal_kembali']);
			$row = array();
			$row[] = $no;
			$row[] = $field['no_surat'];
			$row[] = date_format($tgl_surat, "D, d M Y");
			$row[] = $field['pemberi_perintah'];
			$row[] = $field['penerima_perintah'];
			$row[] = $field['golongan'];
			$row[] = $field['jabatan'];
			$row[] = $field['gaji'];
			$row[] = $field['tingkat_perjalanan'];
			$row[] = $field['tujuan_perjalanan'];
			$row[] = $field['kendaraan'];
			$row[] = $field['tempat_berangkat'];
			$row[] = $field['tempat_tujuan'];
			$row[] = $field['lama_perjalanan'];
			$row[] = date_format($tgl_berangkat, "D, d M Y");
			$row[] = date_format($tgl_kembali, "D, d M Y");
			$row[] = $field['pembebanan_anggaran'];
			$row[] = $field['keterangan'];
			$row[] = $field['lampiran'] == '' ? '<a href="' . site_url('admin/sppd/update/' . $field['id']) . '" title="Upload"> <i class="fas fa-file-upload
			"></i> </a>' : '<a href="' . base_url('upload_folder/pdf/' . $field['lampiran']) . '" target="_blank">' . $field['lampiran'] . '</a>';
			$row[] = '
				<div class="btn-group" role="group" aria-label="Basic outlined example">
					<a href="' . site_url('admin/sppd/update/' . $field['id']) . '" class="btn btn-warning btn-sm " title="Edit">
						<i class="fas fa-edit"></i> 
					</a>
					<a href="' . site_url('admin/sppd/getTemplate/' . $field['id']) . '" class="btn btn-success btn-sm " title="Template">
						<i class="fas fa-file-invoice-dollar"></i> 
					</a>
					<a href="' . site_url('admin/sppd/delete/' . $field['id']) . '" class="btn btn-danger btn-sm btnHapus" title="Hapus" data = "' . $field['id'] . '">
						<i class="fas fa-trash-alt"></i> 
					</a>
				</div>
					';

			$data[] = $row;
		}

		//mengirim data json
		$output = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $this->M_sppd->count_all(),
			"recordsFiltered" => $this->M_sppd->count_filtered(),
			"data" => $data,
		);

		//output dalam format JSON
		echo json_encode($output);
	}

	public function insert()
	{

		$this->insert_submit();

		$name  = $this->session->userdata('name');
		$image = $this->session->userdata('image');
		$data_pegawai = $this->M_pegawai->read();
		$data_setting  = $this->m_setting->read();

		// no urut surat
		$year 		= date('Y');
		$maxData    = $this->M_sppd->getMaxData($year);
		$no_urut 	= $maxData + 1;

		// mengirim data ke view
		$output = array(
			'theme_page' 	=> 'surat/sppd/v_sppd_insert',
			'judul' 	 	=> 'Surat perintah perjalanan dinas',
			'no_urut'		=> $no_urut,
			'name'		 	=> $name,
			'image'			=> $image,
			'data_pegawai'  => $data_pegawai,
			'data_setting'  => $data_setting
		);

		// memanggil file view
		$this->load->view('admin/theme/index', $output);
	}

	public function insert_submit()
	{

		if ($this->input->post('submit') == 'Simpan') {

			//aturan validasi input login
			$this->form_validation->set_rules('tgl_surat', 'Tanggal Surat', 'required');
			$this->form_validation->set_rules('pemberi_perintah', 'Pejabat yang berwenang memberi perintah', 'required');
			$this->form_validation->set_rules('penerima_perintah', 'Nama pejabat yang diperintahkan', 'required');
			$this->form_validation->set_rules('golongan', 'Pangkat dan golongan', 'required');
			$this->form_validation->set_rules('jabatan', 'Jabatan', 'required');
			$this->form_validation->set_rules('gaji', 'Gaji pokok', 'required');
			$this->form_validation->set_rules('tingkat_perjalanan', 'Tingkat menurut peraturan perjalanan dinas', 'required');
			$this->form_validation->set_rules('tujuan_perjalanan', 'Maksud perjalanan dinas', 'required');
			$this->form_validation->set_rules('kendaraan', ' Alat angkut yang dipergunakan', 'required');
			$this->form_validation->set_rules('tempat_berangkat', 'Tempat berangkat', 'required');
			$this->form_validation->set_rules('tempat_tujuan', 'Tempat Tujuan', 'required');
			$this->form_validation->set_rules('lama_perjalanan', 'Lamanya perjalanan dinas', 'required');
			$this->form_validation->set_rules('tanggal_berangkat', 'Tanggal berangkat', 'required');
			$this->form_validation->set_rules('tanggal_kembali', 'Tanggal harus kembali', 'required');
			$this->form_validation->set_rules('pembebanan_anggaran', 'Pembebanan Anggaran', 'required');
			$this->form_validation->set_rules('keterangan', 'Keterangan Lain Lain', 'required');

			if ($this->form_validation->run() == TRUE) {

				// menangkap data input dari view
				$no_urut			= $this->input->post('no_urut');
				$tgl_surat			= $this->input->post('tgl_surat');
				$pemberi_perintah  	= $this->input->post('pemberi_perintah');
				$penerima_perintah 	= $this->input->post('penerima_perintah');
				$golongan 	  	    = $this->input->post('golongan');
				$jabatan            = $this->input->post('jabatan');
				$gaji  	    		= $this->input->post('gaji');
				$tingkat_perjalanan	= $this->input->post('tingkat_perjalanan');
				$tujuan_perjalanan	= $this->input->post('tujuan_perjalanan');
				$kendaraan  	    = $this->input->post('kendaraan');
				$tempat_berangkat  	= $this->input->post('tempat_berangkat');
				$tempat_tujuan  	= $this->input->post('tempat_tujuan');
				$lama_perjalanan  	= $this->input->post('lama_perjalanan');
				$tgl_berangkat  	= $this->input->post('tanggal_berangkat');
				$tgl_kembali  		= $this->input->post('tanggal_kembali');
				$pembebanan_anggaran = $this->input->post('pembebanan_anggaran');
				$keterangan  	    = $this->input->post('keterangan');

				$bulan	        = date('n', strtotime($tgl_surat));
				$year		    = date('Y');
				$no_surat       = $no_urut . '/SPPD/LSP-HCMI/' . $bulan . '/' . $year;

				//mengirim data ke model
				$input = array(
					//format : nama field/kolom table => data input dari view
					'no_urut'		 	 => $no_urut,
					'no_surat'		 	 => $no_surat,
					'tanggal_surat'  	 => $tgl_surat,
					'pemberi_perintah'   => $pemberi_perintah,
					'penerima_perintah'  => $penerima_perintah,
					'golongan'         	 => $golongan,
					'jabatan'	  	 	 => $jabatan,
					'gaji'	 			 => $gaji,
					'tingkat_perjalanan' => $tingkat_perjalanan,
					'tujuan_perjalanan'	 => $tujuan_perjalanan,
					'kendaraan'			 => $kendaraan,
					'tempat_berangkat'	 => $tempat_berangkat,
					'tempat_tujuan'		 => $tempat_tujuan,
					'lama_perjalanan'	 => $lama_perjalanan,
					'tanggal_berangkat'	 => $tgl_berangkat,
					'tanggal_kembali' 	 => $tgl_kembali,
					'pembebanan_anggaran' => $pembebanan_anggaran,
					'keterangan'		 => $keterangan
				);

				$data_sppd = $this->M_sppd->insert($input);

				// input data log
				date_default_timezone_set('Asia/Jakarta');
				$name       = $this->session->userdata('name');
				$date       = date('l, d F Y H:i:s');
				$activity   = $name . ' menambahkan data nota dinas : <b>' . $no_surat . '</b>';

				// mengirim data ke model
				$input_log = array(
					// format : nama field/kolom table => data input dari view
					'activity' 	=> $activity,
					'date'	    => $date,
				);

				$data_log = $this->M_log->insert($input_log);

				//mengembalikan halaman ke function read
				$this->session->set_tempdata('message', 'Data berhasil ditambahkan', 1);
				Redirect('admin/sppd/read');
			}
		}
	}

	public function update()
	{
		//menangkap id data yg dipilih dari view (parameter get)
		$id    = $this->uri->segment(4);
		$name  = $this->session->userdata('name');
		$image = $this->session->userdata('image');
		$data_pegawai = $this->M_pegawai->read();
		$data_setting = $this->m_setting->read();

		//function read berfungsi mengambil 1 data dari table kategori sesuai id yg dipilih
		$data_sppd_single = $this->M_sppd->read_single($id);

		//mengirim data ke view
		$output = array(
			//mengirim data kota yang dipilih ke view
			'judul'	 		=> 'Update surat perintah perjalanan dinas',
			'theme_page' 	=> 'surat/sppd/v_sppd_update',
			'data_pegawai' 	=> $data_pegawai,
			'data_setting'  => $data_setting,
			'data_sppd_single' => $data_sppd_single,
			'name'		 	=> $name,
			'image'		 	=> $image,
		);

		//memanggil file view
		$this->load->view('admin/theme/index', $output);
	}

	public function update_submit()
	{

		//setting library upload
		$config['upload_path']          = './upload_folder/pdf';
		$config['allowed_types']        = 'pdf';
		$config['max_size']             = 5000;
		$this->load->library('upload', $config);

		// menangkap data input dari view
		$no_surat			= $this->input->post('no_surat');
		$no_urut			= $this->input->post('no_urut');
		$tgl_surat			= $this->input->post('tgl_surat');
		$pemberi_perintah  	= $this->input->post('pemberi_perintah');
		$penerima_perintah 	= $this->input->post('penerima_perintah');
		$golongan 	  	    = $this->input->post('golongan');
		$jabatan            = $this->input->post('jabatan');
		$gaji  	    		= $this->input->post('gaji');
		$tingkat_perjalanan	= $this->input->post('tingkat_perjalanan');
		$tujuan_perjalanan	= $this->input->post('tujuan_perjalanan');
		$kendaraan  	    = $this->input->post('kendaraan');
		$tempat_berangkat  	= $this->input->post('tempat_berangkat');
		$tempat_tujuan  	= $this->input->post('tempat_tujuan');
		$lama_perjalanan  	= $this->input->post('lama_perjalanan');
		$tgl_berangkat  	= $this->input->post('tanggal_berangkat');
		$tgl_kembali  		= $this->input->post('tanggal_kembali');
		$pembebanan_anggaran = $this->input->post('pembebanan_anggaran');
		$keterangan  	    = $this->input->post('keterangan');

		//menangkap id data yg dipilih dari view (parameter get)
		$id = $this->uri->segment(4);

		if (!empty($this->upload->do_upload('userfile'))) {

			//jika gagal upload
			if (!$this->upload->do_upload('userfile')) {

				//menangkap id data yg dipilih dari view (parameter get)
				$name  = $this->session->userdata('name');
				$image = $this->session->userdata('image');
				$data_pegawai = $this->M_pegawai->read();
				$data_setting = $this->m_setting->read();

				//function read berfungsi mengambil 1 data dari table kategori sesuai id yg dipilih
				$data_sppd_single = $this->M_sppd->read_single($id);

				//mengirim data ke view
				$output = array(
					//mengirim data kota yang dipilih ke view
					'judul'	 		=> 'Update surat perintah perjalanan dinas',
					'theme_page' 	=> 'surat/sppd/v_sppd_update',
					'data_pegawai' 	=> $data_pegawai,
					'data_setting'  => $data_setting,
					'data_sppd_single' => $data_sppd_single,
					'name'		 	=> $name,
					'image'		 	=> $image,
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
					'no_urut'		 	 => $no_urut,
					'no_surat'		 	 => $no_surat,
					'tanggal_surat'  	 => $tgl_surat,
					'pemberi_perintah'   => $pemberi_perintah,
					'penerima_perintah'  => $penerima_perintah,
					'golongan'         	 => $golongan,
					'jabatan'	  	 	 => $jabatan,
					'gaji'	 			 => $gaji,
					'tingkat_perjalanan' => $tingkat_perjalanan,
					'tujuan_perjalanan'	 => $tujuan_perjalanan,
					'kendaraan'			 => $kendaraan,
					'tempat_berangkat'	 => $tempat_berangkat,
					'tempat_tujuan'		 => $tempat_tujuan,
					'lama_perjalanan'	 => $lama_perjalanan,
					'tanggal_berangkat'	 => $tgl_berangkat,
					'tanggal_kembali' 	 => $tgl_kembali,
					'pembebanan_anggaran' => $pembebanan_anggaran,
					'keterangan'		 => $keterangan,
					'lampiran'    	 	 => $upload_data

				);

				$data_sppd = $this->M_sppd->update($input, $id);

				// input data log
				date_default_timezone_set('Asia/Jakarta');
				$name       = $this->session->userdata('name');
				$date       = date('l, d F Y H:i:s');
				$activity   = $name . ' mengubah data surat SPPD : <b>' . $no_surat . '</b>';

				// mengirim data ke model
				$input_log = array(
					// format : nama field/kolom table => data input dari view
					'activity' 	=> $activity,
					'date'	    => $date,
				);

				$data_log = $this->M_log->insert($input_log);

				//mengembalikan halaman ke function read
				$this->session->set_tempdata('message', 'Data berhasil disimpan', 1);
				Redirect('admin/sppd/read');
			}
		} else {

			//mengirim data ke model
			$input = array(
				//format : nama field/kolom table => data input dari view
				'no_urut'		 	 => $no_urut,
				'no_surat'		 	 => $no_surat,
				'tanggal_surat'  	 => $tgl_surat,
				'pemberi_perintah'   => $pemberi_perintah,
				'penerima_perintah'  => $penerima_perintah,
				'golongan'         	 => $golongan,
				'jabatan'	  	 	 => $jabatan,
				'gaji'	 			 => $gaji,
				'tingkat_perjalanan' => $tingkat_perjalanan,
				'tujuan_perjalanan'	 => $tujuan_perjalanan,
				'kendaraan'			 => $kendaraan,
				'tempat_berangkat'	 => $tempat_berangkat,
				'tempat_tujuan'		 => $tempat_tujuan,
				'lama_perjalanan'	 => $lama_perjalanan,
				'tanggal_berangkat'	 => $tgl_berangkat,
				'tanggal_kembali' 	 => $tgl_kembali,
				'pembebanan_anggaran' => $pembebanan_anggaran,
				'keterangan'		 => $keterangan,
				'lampiran'    	 	 => $this->input->post('oldfile')
			);

			$data_sppd = $this->M_sppd->update($input, $id);

			// input data log
			date_default_timezone_set('Asia/Jakarta');
			$name       = $this->session->userdata('name');
			$date       = date('l, d F Y H:i:s');
			$activity   = $name . ' mengubah data surat SPPD : <b>' . $no_surat . '</b>';

			// mengirim data ke model
			$input_log = array(
				// format : nama field/kolom table => data input dari view
				'activity' 	=> $activity,
				'date'	    => $date,
			);

			$data_log = $this->M_log->insert($input_log);

			//mengembalikan halaman ke function read
			$this->session->set_tempdata('message', 'Data berhasil disimpan', 1);
			Redirect('admin/sppd/read');
		}
	}

	public function delete()
	{

		$id = $this->uri->segment(4);

		$this->db->db_debug = false; //disable debugging queries

		// Mengambil data dari Model
		$no_surat  = $this->M_sppd->getLastDataNoSurat($id);

		// Input data log
		date_default_timezone_set('Asia/Jakarta');
		$name       = $this->session->userdata('name');
		$date       = date('l, d F Y H:i:s');
		$activity   = $name . ' delete data surat SPPD : <b>' . $no_surat . '</b>';

		// mengirim data ke model
		$input_log = array(
			// format : nama field/kolom table => data input dari view
			'activity' 	=> $activity,
			'date'	    => $date,
		);

		$data_log = $this->M_log->insert($input_log);

		// Error handling
		if (!$this->M_sppd->delete($id)) {
			$msg =  $this->db->error();
			$this->session->set_tempdata('error', $msg['message'], 1);
		}

		//mengembalikan halaman ke function read
		$this->session->set_tempdata('message', 'Data berhasil dihapus', 1);
		redirect('admin/sppd/read');
	}

	public function getTemplate() 
	{
		$document = file_get_contents("./assets/template/SPPD.rtf");
		$id  	  = $this->uri->segment(4);

		// menangkap data input dari view
		$no_surat			= $this->M_sppd->getDataNoSurat($id);
		$tanggal_surat		= $this->M_sppd->getDataTglSurat($id);
		$pemberi_perintah  	= $this->M_sppd->getDataPemberiPerintah($id);
		$jabatan_perintah  	= $this->M_sppd->getDataJabatanPemberiPerintah($id);
		$penerima_perintah 	= $this->M_sppd->getDataPenerimaPerintah($id);
		$golongan			= $this->M_sppd->getDataGolongan($id);
		$jabatan			= $this->M_sppd->getDataJabatan($id);
		$gaji				= $this->M_sppd->getDataGaji($id);
		$tingkat_perjalanan	= $this->M_sppd->getDataTingkatPerjalanan($id);
		$kendaraan			= $this->M_sppd->getDataKendaraan($id);
		$tujuan_perjalanan	= $this->M_sppd->getDataTujuanPerjalanan($id);
		$tempat_berangkat	= $this->M_sppd->getDataTempatBerangkat($id);
		$tempat_tujuan		= $this->M_sppd->getDataTempatTujuan($id);
		$lama_perjalanan	= $this->M_sppd->getDataLamaPerjalanan($id);
		$tanggal_berangkat	= $this->M_sppd->getDataTanggalBerangkat($id);
		$tanggal_kembali	= $this->M_sppd->getDataTanggalKembali($id);
		$pembebanan_biaya	= $this->M_sppd->getDataPembebananAnggaran($id);
		$keterangan			= $this->M_sppd->getDataKeterangan($id);

		// isi dokumen dinyatakan dalam bentuk string
		$document = str_replace("#nomor", $no_surat, $document);
		$document = str_replace("#tanggal_surat", date('d F Y', strtotime($tanggal_surat)), $document);
		$document = str_replace("#perintah", $jabatan_perintah, $document);
		$document = str_replace("#pemberi_perintah", $pemberi_perintah, $document);
		$document = str_replace("#penerima_perintah", $penerima_perintah, $document);
		$document = str_replace("#golongan", $golongan, $document);
		$document = str_replace("#jabatan", $jabatan, $document);
		$document = str_replace("#gaji", $gaji, $document);
		$document = str_replace("#tingkat_perjalanan", $tingkat_perjalanan, $document);
		$document = str_replace("#kendaraan", $kendaraan, $document);
		$document = str_replace("#tujuan_perjalanan", $tujuan_perjalanan, $document);
		$document = str_replace("#tempat_berangkat", $tempat_berangkat, $document);
		$document = str_replace("#tempat_tujuan", $tempat_tujuan, $document);
		$document = str_replace("#lama_perjalanan", $lama_perjalanan, $document);
		$document = str_replace("#tanggal_berangkat", $tanggal_berangkat, $document);
		$document = str_replace("#tanggal_kembali", $tanggal_kembali, $document);
		$document = str_replace("#pembebanan_biaya", $pembebanan_biaya, $document);
		$document = str_replace("#keterangan", $keterangan, $document);

		// header untuk membuka file output RTF dengan MS. Word
		header("Content-type: application/msword");
		header("Content-disposition: inline; filename= SPPD NO:.$no_surat.doc");
		header("Content-length: ".strlen($document));
		echo $document;
	}

	public function export_excel()
	{
		$data_sppd = $this->M_sppd->read();

		//mengirim data ke view
		$output = array(

			//data provinsi dikirim ke view
			'data_sppd' => $data_sppd,
		);

		//memanggil file view
		$this->load->view('admin/surat/sppd/v_sppd_export_excel', $output);
	}
}
