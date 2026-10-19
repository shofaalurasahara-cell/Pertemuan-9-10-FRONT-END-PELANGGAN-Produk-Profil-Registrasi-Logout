<?php
defined('BASEPATH') or exit('No direct script access allowed');

class produk_gambar_model extends CI_Model {
    private $_table = "produk_gambar";

    public function get_all_by_produk_id($produk_id) {
        $this->db->where('produk_id', $produk_id);
        $query = $this->db->get($this->_table);
        return $query->result_array();
    }

    public function get_by_id($id_gambar) {
        $this->db->where('id_gambar', $id_gambar);
        $query = $this->db->get($this->_table);
        return $query->row_array();
    }

    public function tambah($data) {
        $this->db->insert($this->_table, $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function ubah_nama_gambar($id_gambar, $nama_gambar_baru) {
        $this->db->where('id_gambar', $id_gambar);
        $this->db->update($this->_table, ['nama_gambar' => $nama_gambar_baru]);
        return ($this->db->affected_rows() >= 0) ? true : false;
    }

    public function hapus($id_gambar) {
        $this->db->where('id_gambar', $id_gambar);
        $this->db->delete($this->_table);
        return ($this->db->affected_rows() != 1) ? false : true;
    }
}