<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

	public function __construct() {
		parent::__construct();

		if (empty($this->session->userdata('username'))) {
			redirect('admin/auth');
		}
		if ($this->session->userdata('is_active') == 'n') {
			redirect('admin/auth');
		}

        $this->load->model('m_setting');
    }

    public function index() {

		$this->read();
	}

    public function read() {

        $name          = $this->session->userdata('name');
		$image         = $this->session->userdata('image');
		$data_setting  = $this->m_setting->read();

		$output = array(
						'theme_page'   => 'setting/v_setting.php',
						'judul' 	   => 'Setting',
						'name'		   => $name,
						'image'		   => $image,
                        'data_setting' => $data_setting
					);

		// memanggil file view
		$this->load->view('admin/theme/index', $output);
    }

    public function update_submit()
    {
        //setting library upload
        $config['upload_path']          = './upload_folder/img';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 5000;
        $this->load->library('upload', $config);

        // menangkap data input dari view
		$owner		= $this->input->post('owner');
		$address	= $this->input->post('address');
		$phone		= $this->input->post('phone');
		$email		= $this->input->post('email');
		$theme		= $this->input->post('theme');
		$sidebar	= $this->input->post('sidebar');
		$mode	  	= $this->input->post('mode');
		$oldfile    = $this->input->post('userfileold');

        //menangkap id data yg dipilih dari view (parameter get)
        $id = $this->uri->segment(4);

		if (!empty($this->upload->do_upload('userfile'))) {
			
			//jika gagal upload
			if (!$this->upload->do_upload('userfile')) {
	
				//menangkap id data yg dipilih dari view (parameter get)
				$name          = $this->session->userdata('name');
                $image         = $this->session->userdata('image');
                $data_setting  = $this->m_setting->read();

                $output = array(
                                'theme_page'   => 'setting/v_setting.php',
                                'judul' 	   => 'Setting',
                                'name'		   => $name,
                                'image'		   => $image,
                                'data_setting' => $data_setting
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
                    'owner'      => $owner,
                    'address'    => $address,
                    'email'      => $email,
                    'phone'      => $phone,
					'theme'		 => $theme,
					'sidebar'    => $sidebar,
					'mode' 	  	 => $mode,
					'logo'       => $upload_data
				);
	
				$data_surat = $this->m_setting->update($input, $id);
	
				//mengembalikan halaman ke function read
				$this->session->set_tempdata('message', 'Data berhasil disimpan', 1);
				Redirect('admin/setting/read');
			}

		} else {

			//mengirim data ke model
			$input = array(
				//format : nama field/kolom table => data input dari view
                'owner'      => $owner,
				'address'    => $address,
				'email'      => $email,
				'phone'      => $phone,
				'theme'		 => $theme,
                'sidebar'    => $sidebar,
                'mode' 	  	 => $mode,
                'logo'       => $oldfile,
			);

			$data_surat = $this->m_setting->update($input, $id);

			//mengembalikan halaman ke function read
			$this->session->set_tempdata('message', 'Data berhasil disimpan', 1);
			Redirect('admin/setting/read');
		}

    }
}