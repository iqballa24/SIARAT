<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Scheme extends CI_Controller {

	public function index()
	{
        $this->read();
	}

    public function read() 
    {
		// mengirim data ke view
		$output = array(
			'theme_page' => 'scheme',
		);
 
		// // memanggil file view
		$this->load->view('frontend/theme/index', $output);
	}
}
