<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_dashboard extends CI_Model 
{
    public function getTotalDivisi() {
        $this->db->select('COUNT(kode) as total');
        $this->db->from('tb_divisi');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getTotalCategory() {
        $this->db->select('COUNT(kd_surat) as total');
        $this->db->from('tb_category');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getTotalSuratKeluar() {
        $this->db->select('COUNT(no_surat) as total');
        $this->db->from('tb_suratkeluar');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getTotalSuratMasuk() {
        $this->db->select('COUNT(no_surat) as total');
        $this->db->from('tb_suratmasuk');
        $query = $this->db->get();

        return $query->result_array();
    }
}