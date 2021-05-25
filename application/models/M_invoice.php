<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_invoice extends CI_Model {

	var $table = array('tb_invoice');

	//field yang ditampilkan
	var $column_order = array(null,'no_invoice', 'tgl_invoice', 'jatuh_tempo', 'tujuan', 'lokasi', 'status','lampiran');

	//field yang diizin untuk pencarian 
	var $column_search = array('no_invoice', 'tgl_invoice', 'jatuh_tempo', 'tujuan', 'lokasi', 'status', 'lampiran');

	//field pertama yang diurutkan
	var $order = array('id' => 'desc');

	public function __construct()
	{
		parent::__construct();
	}

	private function _get_datatables_query()
	{

		$this->db->select('*');
		$this->db->from($this->table);

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
        $query = $this->db->query("SELECT MAX(no_invoice) as no_urut from tb_invoice where tahun = $year");
        $hasil = $query->row();

        return $hasil->no_urut;
    }

	public function getDataNoInvoice($id)
    {
        $query = $this->db->query("SELECT no_invoice from tb_invoice where id = '$id' ");
		$hasil = $query->row();

        return $hasil->no_invoice;
    }
	
	public function getDataTglInvoice($id)
    {
        $query = $this->db->query("SELECT tgl_invoice from tb_invoice where id = '$id' ");
		$hasil = $query->row();

        return $hasil->tgl_invoice;
    }
	
	public function getDataJatuhTempo($id)
    {
        $query = $this->db->query("SELECT jatuh_tempo from tb_invoice where id = '$id' ");
		$hasil = $query->row();

        return $hasil->jatuh_tempo;
    }

	public function getDataTujuan($id)
    {
        $query = $this->db->query("SELECT tujuan from tb_invoice where id = '$id' ");
		$hasil = $query->row();

        return $hasil->tujuan;
    }

	public function getDataLokasi($id)
    {
        $query = $this->db->query("SELECT lokasi from tb_invoice where id = '$id' ");
		$hasil = $query->row();

        return $hasil->lokasi;
    }

	public function getDataUraian($id)
    {
        $query = $this->db->query("SELECT uraian from tb_invoice where id = '$id' ");
		$hasil = $query->row();

        return $hasil->uraian;
    }

	public function getDataQty($id)
    {
        $query = $this->db->query("SELECT kuantitas from tb_invoice where id = '$id' ");
		$hasil = $query->row();

        return $hasil->kuantitas;
    }

	public function getDataHarga($id)
    {
        $query = $this->db->query("SELECT harga from tb_invoice where id = '$id' ");
		$hasil = $query->row();

        return $hasil->harga;
    }

	public function getDataDiskon($id)
    {
        $query = $this->db->query("SELECT diskon from tb_invoice where id = '$id' ");
		$hasil = $query->row();

        return $hasil->diskon;
    }

	public function getDataTotal($id)
    {
        $query = $this->db->query("SELECT (kuantitas * harga * diskon) as total from tb_invoice where id = '$id'");
		$hasil = $query->row();

        return $hasil->total;
    }

	public function getDataTerbilang($id)
    {
        $query = $this->db->query("SELECT terbilang from tb_invoice where id = '$id'");
		$hasil = $query->row();

        return $hasil->terbilang;
    }

	public function getDataStatus($id)
    {
        $query = $this->db->query("SELECT a.status from tb_invoice a where id = '$id'");
		$hasil = $query->row();

        return $hasil->status;
    }

	// function read berfungsi mengambil/read data dari table anggota di database
	public function read() {

		//sql read
		$this->db->select('*');
		$this->db->from('tb_invoice');
		$query = $this->db->get();

		// $query -> result_array = mengirim data ke controller dalam bentuk semua data
        return $query->result_array();
	}

	public function read_check($kode)
	{
		$this->db->select('*');
		$this->db->from('tb_invoice');
		$this->db->where('no_invoice', $kode);
		$query = $this->db->get();

		return $query->row_array();
	}

	public function read_single($id) {

		// sql read
		$this->db->select('*');
		$this->db->from('tb_invoice');
		$this->db->where('id', $id);

		$query = $this->db->get();

		// query -> row_array = mengirim data ke controller dalam bentuk 1 data
        return $query->row_array();
	}

	public function insert($input)
	{
		// $input = data yang dikirim dari controller
		return $this->db->insert('tb_invoice', $input);
	}

	public function update($input, $id)
	{
		//$id = id data yang dikirim dari controller (sebagai filter data yang diubah)
		//filter data sesuai id yang dikirim dari controller
		$this->db->where('id', $id);

		//$input = data yang dikirim dari controller
		return $this->db->update('tb_invoice', $input);
	}

	public function delete($id) {
		// $id = data yang dikirim dari controller (sebagai filter data yang dihapus)
		$this->db->where('id', $id);
		return $this->db->delete('tb_invoice');
	}

	public function detail($id)
    {

        //sql read
        $this->db->select('*');
		$this->db->from('tb_invoice');
        $this->db->where('id', $id);
        $query = $this->db->get();

        // $query -> result_array = mengirim data ke controller dalam bentuk semua data
        return $query->result_array();
    }

}