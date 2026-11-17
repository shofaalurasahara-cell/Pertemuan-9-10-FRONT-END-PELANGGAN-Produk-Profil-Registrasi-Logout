<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ongkir2422500011_controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        is_admin_logged_in();
        $this->load->model('Ongkir2422500011_model');
    }

    public function index() {
        $data['list_ongkir'] = $this->Ongkir2422500011_model->get_all();
        $this->load->view('administrator/templates/header');
        $this->load->view('administrator/templates/sidebar');
        $this->load->view('administrator/ongkir2422500011/index', $data);
        $this->load->view('administrator/templates/footer');
    }

    public function tambah_ongkir()
    {
        $data['title'] = 'Tambah ongkir';

        $this->form_validation->set_rules('nama_ekspedisi', 'Nama Ekspedisi', 'required');
        $this->form_validation->set_rules('jenis_layanan', 'Jenis Layanan', 'required');
        $this->form_validation->set_rules('tarif_per_kg', 'Tarif Per Kg', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run() != FALSE) {
            $this->__simpan_ongkir();
        } else {
            $this->load->view('administrator/templates/header', $data);
            $this->load->view('administrator/templates/sidebar');
            $this->load->view('administrator/ongkir2422500011/tambah_ongkir', $data);
            $this->load->view('administrator/templates/footer');
        }
    }

    private function __simpan_ongkir()
    {
        $data = [
            'nama_ekspedisi011' => $this->input->post('nama_ekspedisi'),
            'jenis_layanan011' => $this->input->post('jenis_layanan'),
            'tarif_per_kg011' => $this->input->post('tarif_per_kg'),
            'status011' => $this->input->post('status')
        ];
        $simpan = $this->Ongkir2422500011_model->tambah($data);
        if ($simpan) {
            $this->session->set_flashdata('message', '
                <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
                    <div>Berhasil menambahkan ongkir!!</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ');
        } else {
            $this->session->set_flashdata('message', '
                <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
                    <div>Gagal menambahkan ongkir!!</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ');
        }
        redirect('administrator/ongkir2422500011');
    }

    public function hapus_ongkir($id)
    {
        $ongkir = $this->Ongkir2422500011_model->get_by_id($id);
        if ($ongkir) {
            $hapus = $this->Ongkir2422500011_model->hapus($id);
            if ($hapus) {
                $this->session->set_flashdata('message', '
                    <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
                        <div>Berhasil menghapus ongkir!!</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                ');
            } else {
                $this->session->set_flashdata('message', '
                    <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
                        <div>Gagal menghapus ongkir!!</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                ');
            }
            redirect('administrator/ongkir2422500011');
        } else {
            $this->session->set_flashdata('message', '
                <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
                    <div>ongkir tidak ditemukan!!</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ');
            redirect('administrator/ongkir2422500011');
        }
    }

    public function ubah_ongkir($id)
    {
        $ongkir = $this->Ongkir2422500011_model->get_by_id($id);
        if ($ongkir) {
            $this->form_validation->set_rules('nama_ekspedisi', 'Nama Ekspedisi', 'required');
            $this->form_validation->set_rules('jenis_layanan', 'Jenis Layanan', 'required');
            $this->form_validation->set_rules('tarif_per_kg', 'Tarif Per Kg', 'required');
            $this->form_validation->set_rules('status', 'Status', 'required');

            if ($this->form_validation->run() != FALSE) {
                $this->__ubah_ongkir($id);
            } else {
                $data['title'] = 'Ubah ongkir';
                $data['ongkir'] = $ongkir;
                $this->load->view('administrator/templates/header', $data);
                $this->load->view('administrator/templates/sidebar');
                $this->load->view('administrator/ongkir2422500011/ubah_ongkir', $data);
                $this->load->view('administrator/templates/footer');
            }
        } else {
            $this->session->set_flashdata('message', '
                <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
                    <div>ongkir tidak ditemukan!!</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ');
            redirect('administrator/ongkir2422500011');
        }
    }

    private function __ubah_ongkir($id)
    {
        $data = [
            'nama_ekspedisi011' => $this->input->post('nama_ekspedisi'),
            'jenis_layanan011' => $this->input->post('jenis_layanan'),
            'tarif_per_kg011' => $this->input->post('tarif_per_kg'),
            'status011' => $this->input->post('status')
        ];
        $ubah = $this->Ongkir2422500011_model->ubah($data, $id);
        if ($ubah) {
            $this->session->set_flashdata('message', '
                <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
                    <div>Berhasil mengubah ongkir!!</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ');
        } else {
            $this->session->set_flashdata('message', '
                <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
                    <div>Gagal mengubah ongkir!!</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ');
        }
        redirect('administrator/ongkir2422500011');
    }
}