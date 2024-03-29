<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_notadinas extends CI_Model {

	var $table = array('tb_notadinas');

	//field yang ditampilkan
	var $column_order = array(null,'id','no_notadinas','tujuan','dari', 'perihal', 'tanggal','divisi');

	//field yang diizin untuk pencarian 
	var $column_search = array('no_notadinas','tujuan','dari', 'perihal', 'tanggal','divisi');

	//field pertama yang diurutkan
	var $order = array('id' => 'desc');

	public function __construct()
	{
		parent::__construct();
	}

	private function _get_datatables_query()
	{

		$this->db->select('*');
		$this->db->from('tb_notadinas a');
        $this->db->join('tb_divisi b', 'a.kd_divisi = b.kode');

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

    public function getMaxData($year)
    {
        $query = $this->db->query("SELECT MAX(no_urut) as nomor from tb_notadinas where tahun = $year");
        $hasil = $query->row();

        return $hasil->nomor;
    }	

	public function getLastDataNomor($id)
    {
        $query = $this->db->query("SELECT no_notadinas from tb_notadinas where id = $id");
		$hasil = $query->row();

        return $hasil->no_notadinas;
    }

	public function getLastDataTujuan($id)
    {
        $query = $this->db->query("SELECT tujuan from tb_notadinas where id = $id");
		$hasil = $query->row();

        return $hasil->tujuan;
    }

	public function getLastDataDari($id)
    {
        $query = $this->db->query("SELECT dari from tb_notadinas where id = $id");
		$hasil = $query->row();

        return $hasil->dari;
    }

	public function getLastDataPerihal($id)
    {
        $query = $this->db->query("SELECT perihal from tb_notadinas where id = $id");
		$hasil = $query->row();

        return $hasil->perihal;
    }

	public function getLastDataTanggal($id)
    {
        $query = $this->db->query("SELECT tanggal from tb_notadinas where id = $id");
		$hasil = $query->row();

        return $hasil->tanggal;
    }

	public function getLastDataNoUrut($id)
    {
        $query = $this->db->query("SELECT no_urut from tb_notadinas where id = $id");
		$hasil = $query->row();

        return $hasil->no_urut;
    }

    public function getDataNoSurat($id)
    {
        $query = $this->db->query("SELECT no_notadinas as nomor from tb_notadinas where id = $id");
		$hasil = $query->row();

        return $hasil->nomor;
    }

    public function read()
    {
        $this->db->select('*');
        $this->db->from('tb_notadinas a');
        $this->db->join('tb_divisi b', 'a.kd_divisi = b.kode');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function read_single($id)
    {
        $this->db->select('*');
        $this->db->from('tb_notadinas a');
        $this->db->join('tb_divisi b', 'a.kd_divisi = b.kode');
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function insert($input)
	{
		// $input = data yang dikirim dari controller
		return $this->db->insert('tb_notadinas', $input);
	}

    public function update($input, $id)
	{
		//$id = id data yang dikirim dari controller (sebagai filter data yang diubah)
		//filter data sesuai id yang dikirim dari controller
		$this->db->where('id', $id);

		//$input = data yang dikirim dari controller
		return $this->db->update('tb_notadinas', $input);
	}

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('tb_notadinas');
    }

    public function detail($id)
    {

        //sql read
        $this->db->select('*');
		$this->db->from('tb_notadinas a');
        $this->db->join('tb_divisi b', 'a.kd_divisi = b.kode');
        $this->db->where('a.id', $id);
        $query = $this->db->get();

        // $query -> result_array = mengirim data ke controller dalam bentuk semua data
        return $query->result_array();
    }

}