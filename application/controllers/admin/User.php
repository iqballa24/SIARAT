<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
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

        //memanggil model
        $this->load->model(array('m_user','m_setting'));
    }


    public function index()
    {
        //mengarahkan ke function read
        $this->read();
    }

    public function read() {

        $name  = $this->session->userdata('name');
		$image = $this->session->userdata('image');
		$data_setting  = $this->m_setting->read();

        // mengirim data ke view
        $output = array(
            'theme_page'   => 'user/v_user',
            'judul'        => 'Access management',
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
        $list = $this->m_user->get_datatables();
        $data = array();
        $no = $this->input->post('start');

        //mencetak data json
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field['username'];
            $row[] = $field['name'];
            $row[] = $field['level'] == '1' ? 'User' : 'Admin';
            $row[] = '<img src="'.base_url('upload_folder/img/' .$field['image']).'" class="img-fluid" style="width:55px;" alt="'.$field['image'].'">';
            $row[] = $field['is_active'] == 'y' ? '<div class ="btn btn-success btn-sm disabled">Active</div>' : '<div class="btn btn-danger btn-sm disabled">Inactive</div>';
            $row[] = '
					<a href="' . site_url('admin/user/update/' . $field['id_user']) . '" class="btn btn-warning btn-sm" title="Edit">
                        <i class="fas fa-edit"></i>
					</a>
					<a href="' . site_url('admin/user/delete/' . $field['id_user']) . '" class="btn btn-danger btn-sm btnHapus" title="Hapus" data = "' . $field['id_user'] . '">
						<i class="fas fa-trash-alt"></i>
					</a>
                    <a href="' . site_url('admin/user/reset/' . $field['id_user']) . '" class="btn btn-info btn-sm btnReset" title="Reset password" data = "' . $field['id_user'] . '">
						<i class="fas fa-key"></i> Reset
					</a>';

            $data[] = $row;
        }

        //mengirim data json
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->m_user->count_all(),
            "recordsFiltered" => $this->m_user->count_filtered(),
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
		$data_setting  = $this->m_setting->read();

        // mengirim data ke view
        $output = array(
            'theme_page'     => 'user/v_user_insert',
            'judul'          => 'Kelola User',
            'data_setting'   => $data_setting,
            'name'		 => $name,
			'image'		 => $image,
        );

        // memanggil file view
        $this->load->view('admin/theme/index', $output);
    }

    public function insert_submit() 
    {

        if ($this->input->post('submit') == 'Simpan') {

            //aturan validasi input login
            $this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|alpha_numeric|callback_insert_check');
            $this->form_validation->set_rules('name', 'Nama', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
            $this->form_validation->set_rules('level', 'Level', 'required');
            $this->form_validation->set_rules('is_active', 'Active', 'required');

            if ($this->form_validation->run() == TRUE) {

                // menangkap data input dari view
                $username         = $this->input->post('username');
                $name            = $this->input->post('name');
                $password         = $this->input->post('password');
                $level            = $this->input->post('level');
                $is_active        = $this->input->post('is_active');
                $password_encrypt = md5($password);

                // mengirim data ke model
                $input = array(
                    // format : nama field/kolom table => data input dari view
                    'username'  => $username,
                    'name'      => $name,
                    'level'     => $level,
                    'password'  => $password_encrypt,
                    'is_active' => $is_active,
                );

                // memanggil function insert pada anggota_model.php
                // function insert berfungsi menyimpan/create data ke table anggota di database
                $data_user = $this->m_user->insert($input);

                // mengembalikan halaman ke function read
                $this->session->set_tempdata('message', 'Data berhasil ditambahkan !', 1);
                redirect('admin/user/read');
            }
        }
    }

    public function insert_check()
	{

		//Menangkap data input dari view
		$username = $this->input->post('username');

		//check data di database
		$data_user = $this->m_user->read_check($username);

		if (!empty($data_user)) {

			//membuat pesan error
			$this->form_validation->set_message('insert_check', "Username " . $username . " sudah ada dalam database");
			$this->session->set_tempdata('error', "Tidak dapat memasukan data yang sama", 1);
			return FALSE;
		}
		return TRUE;
	}

    public function update()
	{

		$this->update_submit();
		//menangkap id data yg dipilih dari view (parameter get)
		$id    = $this->uri->segment(4);
		$name  = $this->session->userdata('name');
		$image = $this->session->userdata('image');
		$data_setting  = $this->m_setting->read();

		//function read berfungsi mengambil 1 data dari table kategori sesuai id yg dipilih
		$data_user_single = $this->m_user->read_single($id);

		//mengirim data ke view
		$output = array(
			'judul'	 		=> 'Kelola user',
			'theme_page' 	=> 'user/v_user_update',
            'data_setting'  => $data_setting,
			'name'		    => $name,
			'image'		    => $image,

			//mengirim data kota yang dipilih ke view
			'data_user_single' => $data_user_single,
		);

		//memanggil file view
		$this->load->view('admin/theme/index', $output);
	}

    public function update_submit()
	{

		if ($this->input->post('submit') == 'Simpan') {

			//aturan validasi input login
            $this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|alpha_numeric');
            $this->form_validation->set_rules('name', 'Nama', 'required');
            $this->form_validation->set_rules('level', 'Level', 'required');
            $this->form_validation->set_rules('status', 'Status', 'required');

			if ($this->form_validation->run() == TRUE) {

				//menangkap id data yg dipilih dari view
				$id = $this->uri->segment(4);

				// menangkap data input dari view
                $username         = $this->input->post('username');
                $name             = $this->input->post('name');
                $level            = $this->input->post('level');
                $is_active        = $this->input->post('status');

				// mengirim data ke model
				$input = array(
					// format : nama field/kolom table => data input dari view
					'username'  => $username,
                    'name'      => $name,
                    'level'     => $level,
                    'is_active' => $is_active,
				);

				//memanggil function update pada kategori model
				$data_anggota = $this->m_user->update($input, $id);

				//mengembalikan halaman ke function read
				$this->session->set_tempdata('message', 'Data berhasil di ubah !', 1);
				redirect('admin/user/read');
			}
		}
	}

    public function reset()
	{
        //menangkap id data yg dipilih dari view
        $id = $this->uri->segment(4);

        // menangkap data input dari view
        $password         = 'lsphcmi2020';
        $password_encrypt = md5($password);

        // mengirim data ke model
        $input = array(
            // format : nama field/kolom table => data input dari view
            'password'  => $password_encrypt
        );

        //memanggil function update pada kategori model
        $this->m_user->update($input, $id);

        //mengembalikan halaman ke function read
        $this->session->set_tempdata('message', 'Password berhasil di Reset !', 1);
        redirect('admin/user/read');
      
	}

    public function delete() {

		$id = $this->uri->segment(4);

		$this->db->db_debug = false; //disable debugging queries
		
		// Error handling
		if (!$this->m_user->delete($id)) {
			$msg =  $this->db->error();
			$this->session->set_tempdata('error', $msg['message'], 1);
		}

		//mengembalikan halaman ke function read
		$this->session->set_tempdata('message','Data berhasil dihapus',1);
		redirect('admin/user/read');
	}
}