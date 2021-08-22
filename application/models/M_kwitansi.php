<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kwitansi extends CI_Model {

	var $table = array('tb_invoice');

	//field yang ditampilkan
	var $column_order = array(null,'no_kwitansi', 'tujuan', 'terbilang', 'tujuan_pembayaran', 'tgl_terima');

	//field yang diizin untuk pencarian 
	var $column_search = array('no_kwitansi', 'tujuan', 'terbilang', 'tujuan_pembayaran', 'tgl_terima');

	//field pertama yang diurutkan
	var $order = array('id_kwitansi' => 'desc');

	public function __construct()
	{
		parent::__construct();
	}

	private function _get_datatables_query()
	{

		$this->db->select('*, (kuantitas * harga - ((diskon * 0.01) * harga * kuantitas)) as total');
		$this->db->from('tb_invoice a');
        $this->db->join('tb_kwitansi b', 'a.id = b.invoice');

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
        $query = $this->db->query("SELECT MAX(no_kwitansi) as no_urut from tb_kwitansi where tahun = $year");
        $hasil = $query->row();

        return $hasil->no_urut;
    }

	public function getInvoice($postData)
	{
		$response = array();
 
		// Select record
		$this->db->select('id,tujuan,uraian');
		$this->db->where('id', $postData['id']);
		$q = $this->db->get('tb_invoice');
		$response = $q->result_array();
	
		return $response;
	}

	public function getDataNoKwitansi($id)
    {
        $query = $this->db->query("SELECT no_kwitansi from tb_kwitansi where id_kwitansi = '$id' ");
		$hasil = $query->row();

        return $hasil->no_kwitansi;
    }
	
	public function getDataTujuan($id)
    {
        $query = $this->db->query("SELECT tujuan from tb_invoice a join tb_kwitansi b on a.id = b.invoice where id_kwitansi = '$id' ");
		$hasil = $query->row();

        return $hasil->tujuan;
    }

	public function getDataTerbilang($id)
    {
        $query = $this->db->query("SELECT terbilang from tb_invoice a join tb_kwitansi b on a.id = b.invoice where id_kwitansi = '$id' ");
		$hasil = $query->row();

        return $hasil->terbilang;
    }

	public function getDataTujuanPembayaran($id)
    {
        $query = $this->db->query("SELECT tujuan_pembayaran from tb_kwitansi where id_kwitansi = '$id' ");
		$hasil = $query->row();

        return $hasil->tujuan_pembayaran;
    }

	public function getDataTotal($id)
    {
        $query = $this->db->query("SELECT (kuantitas * harga - (diskon * 0.01 * kuantitas * harga)) as total from tb_invoice a join tb_kwitansi b on a.id = b.invoice where id_kwitansi = '$id' ");
		$hasil = $query->row();

        return $hasil->total;
    }

	public function getDataTglTerima($id)
    {
        $query = $this->db->query("SELECT tgl_terima from tb_invoice a join tb_kwitansi b on a.id = b.invoice where id_kwitansi = '$id' ");
		$hasil = $query->row();

        return $hasil->tgl_terima;
    }

	public function getDataInvoice() {

		//sql read
		$this->db->select('*');
		$this->db->from('tb_invoice');
		$this->db->where('insert_kwitansi', 'n');
		$query = $this->db->get();

		// $query -> result_array = mengirim data ke controller dalam bentuk semua data
        return $query->result_array();
	}

	// function read berfungsi mengambil/read data dari table anggota di database
	public function read() {

		//sql read
		$this->db->select('*, (kuantitas * harga - ((diskon * 0.01) * harga * kuantitas)) as total');
		$this->db->from('tb_invoice a');
        $this->db->join('tb_kwitansi b', 'a.id = b.invoice');
		$query = $this->db->get();

		// $query -> result_array = mengirim data ke controller dalam bentuk semua data
        return $query->result_array();
	}

	public function read_single($id) {

		// sql read
		$this->db->select('*');
		$this->db->from('tb_kwitansi a');
        $this->db->join('tb_invoice b', 'a.invoice = b.id');
		$this->db->where('id_kwitansi', $id);

		$query = $this->db->get();

		// query -> row_array = mengirim data ke controller dalam bentuk 1 data
        return $query->row_array();
	}

	public function insert($input)
	{
		// $input = data yang dikirim dari controller
		return $this->db->insert('tb_kwitansi', $input);
	}

	public function update($input, $id)
	{
		//$id = id data yang dikirim dari controller (sebagai filter data yang diubah)
		//filter data sesuai id yang dikirim dari controller
		$this->db->where('id_kwitansi', $id);

		//$input = data yang dikirim dari controller
		return $this->db->update('tb_kwitansi', $input);
	}

	public function delete($id) {
		// $id = data yang dikirim dari controller (sebagai filter data yang dihapus)
		$this->db->where('id_kwitansi', $id);
		return $this->db->delete('tb_kwitansi');
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