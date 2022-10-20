<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Item extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->model('item_model');
    }

    public function index()
    {

        $data = [
            'title' => 'Barang - Aplikasi Transaksi',
            'username' => $this->session->userdata('username')
        ];

        if ($this->session->userdata('username')) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('application/item', $data);
            $this->load->view('templates/footer', $data);
        } else {
            redirect('auth');
        }
    }

    public function get_form_data($dataType)
    {
        $title = "";
        switch ($dataType) {
            case 'ItemAdd':
                $title = "Tambah Data Barang";
                break;
            case 'ItemEdit':
                $title = "Ubah Data Barang";
                break;
        }
        $data = [
            'title' => $title
        ];
        echo json_encode($data);
    }

    public function item_add()
    {
        $data = [
            'kode' => $this->input->post('itemCode'),
            'nama' => $this->input->post('itemName'),
            'harga' => str_replace(",", "", $this->input->post('itemPrice'))
        ];

        if ($this->item_model->addItem($data)) {
            echo json_encode(true);
        }
    }
}
