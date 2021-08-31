<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_sppd extends CI_Model {

	var $table = array('tb_sppd');

	//field yang ditampilkan
	var $column_order = array(null,'id','no_surat','tanggal_surat','pemberi_perintah', 'penerima_perintah', 'golongan','jabatan', 'gaji', 'tingkat_perjalanan', 'tujuan_perjalanan', 'kendaraan', 'tempat_berangkat', 'tempat_tujuan', 'lama_perjalanan', 'tanggal_berangkat', 'tanggal_kembali', 'pembebanan_anggaran','keterangan');

	//field yang diizin untuk pencarian 
	var $column_search = array('no_surat','tanggal_surat','pemberi_perintah', 'penerima_perintah', 'golongan','jabatan', 'gaji', 'tingkat_perjalanan', 'tujuan_perjalanan', 'kendaraan', 'tempat_berangkat', 'tempat_tujuan', 'lama_perjalanan', 'tanggal_berangkat', 'tanggal_kembali', 'pembebanan_anggaran','keterangan');

	//field pertama yang diurutkan
	var $order = array('id' => 'desc');

	public function __construct()
	{
		parent::__construct();
	}

	private function _get_datatables_query()
	{

		$this->db->select('*');
		$this->db->from('tb_sppd');

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
        $query = $this->db->query("SELECT MAX(no_urut) as nomor from tb_sppd where tahun = $year");
        $hasil = $query->row();

        return $hasil->nomor;
    }
	
	public function getDataNoSurat($id)
    {
        $query = $this->db->query("SELECT no_surat from tb_sppd where id = $id");
		$hasil = $query->row();

        return $hasil->no_surat;
    }

	public function getDataTglSurat($id)
    {
        $query = $this->db->query("SELECT tanggal_surat from tb_sppd where id = $id");
		$hasil = $query->row();

        return $hasil->tanggal_surat;
    }

	public function getDataPemberiPerintah($id)
    {
        $query = $this->db->query("SELECT pemberi_perintah from tb_sppd where id = $id");
		$hasil = $query->row();

        return $hasil->pemberi_perintah;
    }

	public function getDataJabatanPemberiPerintah($id)
    {
        $query = $this->db->query("SELECT b.jabatan as jbtn from tb_sppd a join tb_pegawai b on a.pemberi_perintah = b.nama  where a.id = $id");
		$hasil = $query->row();

        return $hasil->jbtn;
    }

	public function getDataPenerimaPerintah($id)
    {
        $query = $this->db->query("SELECT penerima_perintah from tb_sppd where id = $id");
		$hasil = $query->row();

        return $hasil->penerima_perintah;
    }

	public function getDataGolongan($id)
    {
        $query = $this->db->query("SELECT golongan from tb_sppd where id = $id");
		$hasil = $query->row();

        return $hasil->golongan	;
    }

	public function getDataJabatan($id)
    {
        $query = $this->db->query("SELECT jabatan from tb_sppd where id = $id");
		$hasil = $query->row();

        return $hasil->jabatan;
    }

	public function getDataGaji($id)
    {
        $query = $this->db->query("SELECT gaji from tb_sppd where id = $id");
		$hasil = $query->row();

        return $hasil->gaji;
    }
	
	public function getDataTingkatPerjalanan($id)
    {
        $query = $this->db->query("SELECT tingkat_perjalanan from tb_sppd where id = $id");
		$hasil = $query->row();

        return $hasil->tingkat_perjalanan;
    }

	public function getDataKendaraan($id)
    {
        $query = $this->db->query("SELECT kendaraan from tb_sppd where id = $id");
		$hasil = $query->row();

        return $hasil->kendaraan;
    }

	public function getDataTujuanPerjalanan($id)
    {
        $query = $this->db->query("SELECT tujuan_perjalanan from tb_sppd where id = $id");
		$hasil = $query->row();

        return $hasil->tujuan_perjalanan;
    }

	public function getDataTempatBerangkat($id)
    {
        $query = $this->db->query("SELECT tempat_berangkat from tb_sppd where id = $id");
		$hasil = $query->row();

        return $hasil->tempat_berangkat;
    }

	public function getDataTempatTujuan($id)
    {
        $query = $this->db->query("SELECT tempat_tujuan from tb_sppd where id = $id");
		$hasil = $query->row();

        return $hasil->tempat_tujuan;
    }

	public function getDataLamaPerjalanan($id)
    {
        $query = $this->db->query("SELECT lama_perjalanan from tb_sppd where id = $id");
		$hasil = $query->row();

        return $hasil->lama_perjalanan;
    }

	public function getDataTanggalBerangkat($id)
    {
        $query = $this->db->query("SELECT tanggal_berangkat from tb_sppd where id = $id");
		$hasil = $query->row();

        return $hasil->tanggal_berangkat;
    }

	public function getDataTanggalKembali($id)
    {
        $query = $this->db->query("SELECT tanggal_kembali from tb_sppd where id = $id");
		$hasil = $query->row();

        return $hasil->tanggal_kembali;
    }

	public function getDataPembebananAnggaran($id)
    {
        $query = $this->db->query("SELECT pembebanan_anggaran from tb_sppd where id = $id");
		$hasil = $query->row();

        return $hasil->pembebanan_anggaran;
    }

	public function getDataKeterangan($id)
    {
        $query = $this->db->query("SELECT keterangan from tb_sppd where id = $id");
		$hasil = $query->row();

        return $hasil->keterangan;
    }

	public function getLastDataNoSurat($id)
    {
        $query = $this->db->query("SELECT no_surat from tb_sppd where id = $id");
		$hasil = $query->row();

        return $hasil->no_surat;
    }

	public function read()
	{
		$this->db->select('*');
		$this->db->from('tb_sppd');
		$query = $this->db->get();
		
		return $query->result_array();
	}

	public function read_single($id) {

		// sql read
		$this->db->select('*');
		$this->db->from('tb_sppd');
		$this->db->where('id', $id);

		$query = $this->db->get();

		// query -> row_array = mengirim data ke controller dalam bentuk 1 data
        return $query->row_array();
	}

	public function insert($input)
	{
		$this->db->insert('tb_sppd', $input);
	}

	public function update($input, $id)
	{
		//$id = id data yang dikirim dari controller (sebagai filter data yang diubah)
		//filter data sesuai id yang dikirim dari controller
		$this->db->where('id', $id);

		//$input = data yang dikirim dari controller
		return $this->db->update('tb_sppd', $input);
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete('tb_sppd');
	}

}