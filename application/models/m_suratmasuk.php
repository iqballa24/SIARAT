<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_suratmasuk extends CI_Model {

	var $table = array('tb_suratmasuk');

	//field yang ditampilkan
	var $column_order = array(null,'id_surat', 'tgl_terima','pengirim', 'jenis_surat', 'keterangan');

	//field yang diizin untuk pencarian 
	var $column_search = array('perihal','no_surat', 'tgl_terima','pengirim','tgl_surat' ,'jenis_surat', 'keterangan');

	//field pertama yang diurutkan
	var $order = array('id_surat' => 'desc');

	public function __construct()
	{
		parent::__construct();
	}

	private function _get_datatables_query()
	{

		$this->db->select('*');
		$this->db->from('tb_suratmasuk a');
        $this->db->join('tb_category b', 'a.kd_jenis_surat = b.kd_surat');

		$i = 0;

		foreach ($this->column_search as $item) // looping awal
		{
			$search = $this->input->post('search');
			if ($search['value'])

			// jika datatable mengirimkan pencarian dengan metode POST
			{
				// looping awal 
				if ($i === 0) {
					$this->db->group_start();
					$this->db->like($item, $search['value']);
				} else {
					$this->db->or_like($item, $search['value']);
				}

				if (count($this->column_search) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if ($this->input->post('order')) {
			$order = $this->input->post('order');
			$this->db->order_by($this->column_order[$order['0']['column']], $order['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if ($this->input->post('length') != -1)
			$this->db->limit($this->input->post('length'), $this->input->post('start'));

		$query = $this->db->get();
		return $query->result_array();
	}

	//menghitung tota data sesuai filter/pagination
	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	//menghitung total data di table
	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function getPerihalById($id) 
	{
		$query = $this->db->query("SELECT perihal from tb_suratmasuk where id_surat = $id");
		$hasil = $query->row();

        return $hasil->perihal;
	}

	// function read berfungsi mengambil/read data dari table anggota di database
	public function read() {

		//sql read
		$this->db->select('*');
		$this->db->from('tb_suratmasuk a');
        $this->db->join('tb_category b', 'a.kd_jenis_surat = b.kd_surat');
		$query = $this->db->get();

		// $query -> result_array = mengirim data ke controller dalam bentuk semua data
        return $query->result_array();
	}

	public function read_check($kode)
	{
		$this->db->select('*');
		$this->db->from('tb_suratmasuk');
		$this->db->where('no_surat', $kode);
		$query = $this->db->get();

		return $query->row_array();
	}

	public function read_single($id) {

		// sql read
		$this->db->select('*');
		$this->db->from('tb_suratmasuk');
		$this->db->where('id_surat', $id);

		$query = $this->db->get();

		// query -> row_array = mengirim data ke controller dalam bentuk 1 data
        return $query->row_array();
	}

	public function insert($input)
	{
		// $input = data yang dikirim dari controller
		return $this->db->insert('tb_suratmasuk', $input);
	}

	public function update($input, $id)
	{
		$this->db->where('id_surat', $id);

		//$input = data yang dikirim dari controller
		return $this->db->update('tb_suratmasuk', $input);
	}

	public function delete($id) {
		// $id = data yang dikirim dari controller (sebagai filter data yang dihapus)
		$this->db->where('id_surat', $id);
		return $this->db->delete('tb_suratmasuk');
	}

	public function detail($id)
    {

        //sql read
        $this->db->select('*');
        $this->db->from('tb_suratmasuk a');
        $this->db->join('tb_category b', 'a.kd_jenis_surat = b.kd_surat');
        $this->db->where('a.id_surat', $id);
        $query = $this->db->get();

        // $query -> result_array = mengirim data ke controller dalam bentuk semua data
        return $query->result_array();
    }

}