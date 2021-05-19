<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_setting extends CI_Model {

    public function read() {

		//sql read
		$this->db->select('*');
		$this->db->from('tb_setting');
		$query = $this->db->get();

		// $query -> result_array = mengirim data ke controller dalam bentuk semua data
        return $query->result_array();
	}

	public function update($input, $id)
	{
		//$id = id data yang dikirim dari controller (sebagai filter data yang diubah)
		//filter data sesuai id yang dikirim dari controller
		$this->db->where('id', $id);

		//$input = data yang dikirim dari controller
		return $this->db->update('tb_setting', $input);
	}

}