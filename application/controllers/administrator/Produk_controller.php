<?php
defined('BASEPATH') or exit('No direct script access allowed');

class produk_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        is_admin_logged_in();
        $this->load->model('produk_model');
        $this->load->model('produk_kategori_model');
        $this->load->model('produk_gambar_model');
    }

    public function index() {
        $data['title'] = 'Daftar Produk';
        $data['list_produk'] = $this->produk_model->get_all();
        $this->load->view('administrator/templates/header', $data);
        $this->load->view('administrator/templates/sidebar');
        $this->load->view('administrator/produk/index', $data);
        $this->load->view('administrator/templates/footer');
    }

    public function tambah_produk() {
        $data['title'] = 'Tambah Produk';
        $this->form_validation->set_rules('nama_produk', 'Nama produk', 'required');
        $this->form_validation->set_rules('kategori_produk', 'Kategori', 'required');
        
        if ($this->form_validation->run() !== FALSE) {
            $this->__simpan_produk();
        } else {
            $data['list_kategori'] = $this->produk_kategori_model->get_all();
            $this->load->view('administrator/templates/header', $data);
            $this->load->view('administrator/templates/sidebar');
            $this->load->view('administrator/produk/tambah_produk', $data);
            $this->load->view('administrator/templates/footer');
        }
    }

    private function __simpan_produk() {
        $data = [
            'nama' => $this->input->post('nama_produk'),
            'id_kategori' => $this->input->post('kategori_produk'),
            'harga' => $this->input->post('harga_produk'),
            'stok' => $this->input->post('stok_produk'),
            'deskripsi' => $this->input->post('deskripsi_produk')
        ];

        $id_produk = $this->produk_model->tambah($data);

        $count = count($_FILES['gambar_produk']['name']);
        if ($count > 0) {
            $this->__produk_gambar_upload($count, $id_produk);
        }

        $this->session->set_flashdata('message', '
            <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
                <div>Berhasil Tambah Produk!</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        ');
        redirect('administrator/produk');
    }

    private function __produk_gambar_upload($count, $id_produk) {
        for ($i = 0; $i < $count; $i++) {
            if (!empty($_FILES['gambar_produk']['name'][$i])) {
                $_FILES['file']['name'] = $_FILES['gambar_produk']['name'][$i];
                $_FILES['file']['type'] = $_FILES['gambar_produk']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['gambar_produk']['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES['gambar_produk']['error'][$i];
                $_FILES['file']['size'] = $_FILES['gambar_produk']['size'][$i];

                $config['upload_path'] = './uploads/produk/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size'] = '5000';
                $config['file_name'] = "produk-" . $id_produk . "-" . $i . "-" . time();

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('file')) {
                    $uploadData = $this->upload->data();
                    $data_gambar = [
                        'nama_gambar' => $uploadData['file_name'],
                        'produk_id' => $id_produk
                    ];
                    $this->produk_gambar_model->tambah($data_gambar);
                }
            }
        }
    }

    public function ubah_produk($id) {
        $produk = $this->produk_model->get_by_id($id);
        
        if ($produk) {
            $this->form_validation->set_rules('nama_produk', 'Nama produk', 'required');
            $this->form_validation->set_rules('kategori_produk', 'Kategori', 'required');
            
            if ($this->form_validation->run() !== FALSE) {
                $this->__ubah_produk($id);
            } else {
                $data['title'] = 'Ubah Produk';
                $data['produk'] = $produk;
                $data['list_kategori'] = $this->produk_kategori_model->get_all();
                $data['list_gambar'] = $this->produk_gambar_model->get_all_by_produk_id($id);
                
                $this->load->view('administrator/templates/header', $data);
                $this->load->view('administrator/templates/sidebar');
                $this->load->view('administrator/produk/ubah_produk', $data);
                $this->load->view('administrator/templates/footer');
            }
        } else {
            $this->session->set_flashdata('message', '
                <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
                    <div>Produk Tidak Ditemukan!</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ');
            redirect('administrator/produk');
        }
    }

    private function __ubah_produk($id) {
        $data = [
            'nama' => $this->input->post('nama_produk'),
            'id_kategori' => $this->input->post('kategori_produk'),
            'harga' => $this->input->post('harga_produk'),
            'stok' => $this->input->post('stok_produk'),
            'deskripsi' => $this->input->post('deskripsi_produk')
        ];

        $this->produk_model->ubah($data, $id);

        if (!empty($_FILES['gambar_produk']['name'][0])) {
            $count = count($_FILES['gambar_produk']['name']);
            if ($count > 0) {
                $this->__produk_gambar_upload($count, $id);
            }
        }

        $this->session->set_flashdata('message', '
            <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
                <div>Data Produk Berhasil Diperbarui!</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        ');
        redirect('administrator/produk');
    }

    public function hapus_produk($id) {
        $produk = $this->produk_model->get_by_id($id);
        if ($produk) {
            $list_gambar = $this->produk_gambar_model->get_all_by_produk_id($id);
            foreach ($list_gambar as $gambar) {
                $path = './uploads/produk/' . $gambar['nama_gambar'];
                if (file_exists($path)) {
                    unlink($path);
                }
                $this->produk_gambar_model->hapus($gambar['id_gambar']);
            }

            $this->produk_model->hapus($id);
            $this->session->set_flashdata('message', '
                <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
                    <div>Berhasil Hapus Produk!</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ');
            redirect('administrator/produk');
        } else {
            $this->session->set_flashdata('message', '
                <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
                    <div>Produk Tidak Ditemukan!</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ');
            redirect('administrator/produk');
        }
    }

    public function hapus_gambar($id_gambar) {
        $gambar = $this->produk_gambar_model->get_by_id($id_gambar);
        if ($gambar) {
            $produk_id = $gambar['produk_id'];
            $path = './uploads/produk/' . $gambar['nama_gambar'];
            if (file_exists($path)) {
                unlink($path);
            }
            $this->produk_gambar_model->hapus($id_gambar);

            $this->session->set_flashdata('message', '
                <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
                    <div>Berhasil Hapus Gambar Produk!</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ');
            redirect('administrator/produk/ubah/' . $produk_id);
        } else {
            $this->session->set_flashdata('message', '
                <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
                    <div>Gambar Tidak Ditemukan!</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ');
            redirect('administrator/produk');
        }
    }

    public function ubah_gambar($id_gambar) {
        $produk_id = $this->input->post('produk_id');
        $gambar_lama = $this->produk_gambar_model->get_by_id($id_gambar);

        if ($gambar_lama && !empty($_FILES['gambar_baru']['name']) && $_FILES['gambar_baru']['error'] === 0) {
            $config['upload_path'] = './uploads/produk/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = '5000';
            $config['file_name'] = "produk-" . $produk_id . "-" . time();

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('gambar_baru')) {
                $path_lama = './uploads/produk/' . $gambar_lama['nama_gambar'];
                if (file_exists($path_lama)) {
                    unlink($path_lama);
                }

                $uploadData = $this->upload->data();
                $this->produk_gambar_model->ubah_nama_gambar($id_gambar, $uploadData['file_name']);

                $this->session->set_flashdata('message', '
                    <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
                        <div>Gambar Produk Berhasil Diubah!</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                ');
            } else {
                $this->session->set_flashdata('message', '
                    <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
                        <div>Gagal Mengubah Gambar: ' . $this->upload->display_errors() . '</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                ');
            }
        }
        redirect('administrator/produk/ubah/' . $produk_id);
    }
}