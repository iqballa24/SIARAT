<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends CI_Controller {

	public function index()
	{
        $this->read();
	}

    public function read() 
    {
		// mengirim data ke view
		$output = array(
			'theme_page' => 'about',
		);
 
		// // memanggil file view
		$this->load->view('client/theme/index', $output);
	}
}
