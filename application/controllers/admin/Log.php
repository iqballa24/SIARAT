<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (empty($this->session->userdata('username')) && $this->session->userdata('level') == '2' ) {
            redirect('admin/auth');
        }

        if ($this->session->userdata('is_active') == 'n') {
            redirect('admin/auth');
        }

        $this->load->model(array('M_log', 'M_setting'));
    }

    public function index() {

        $this->read();
    }

    public function read() {

        $name  = $this->session->userdata('name');
        $image = $this->session->userdata('image');
        $data_setting  = $this->M_setting->read();

        $output = array(
                        'theme_page'   => 'log/v_log.php',
                        'judul' 	   => 'Log activity',
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
        $list = $this->M_log->get_datatables();
        $data = array();
        $no = $this->input->post('start');

        //mencetak data json
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field['date'];
            $row[] = $field['activity'];

            $data[] = $row;
        }

        //mengirim data json
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->M_log->count_all(),
            "recordsFiltered" => $this->M_log->count_filtered(),
            "data" => $data,
        );

        //output dalam format JSON
        echo json_encode($output);
    }

    public function delete() {

		$this->db->db_debug = false; //disable debugging queries
		
		// Error handling
		if (!$this->M_log->delete()) {
			$msg =  $this->db->error();
			$this->session->set_tempdata('error', $msg['message'], 1);
		}

		//mengembalikan halaman ke function read
		$this->session->set_tempdata('message','Data berhasil dihapus',1);
		redirect('admin/log/read');
	}
}