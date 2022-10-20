<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sale extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->model('sale_model');
        $this->load->model('item_model');
        $this->load->model('cust_model');
    }

    public function index()
    {

        $data = [
            'title' => 'Penjualan - Aplikasi Transaksi',
            'username' => $this->session->userdata('username')
        ];

        if ($this->session->userdata('username')) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('application/sale', $data);
            $this->load->view('templates/footer', $data);
        } else {
            redirect('auth');
        }
    }

    public function get_form_data($dataType)
    {
        $title = "";
        switch ($dataType) {
            case 'SaleAdd':
                $title = "Tambah";
                break;
            case 'SaleEdit':
                $title = "Ubah";
                break;
        }
        $data = [
            'title' => $title,
            'no' => $this->input->post('no'),
            'id' => $this->input->post('id'),
            'qty' => $this->input->post('qty'),
            'discPerc' => $this->input->post('discPerc'),
        ];
        echo json_encode($data);
    }

    // public function get_form_data($dataType)
    // {
    //     $title = "";
    //     switch ($dataType) {
    //         case 'ItemAdd':
    //             $title = "Tambah Data Barang";
    //             break;
    //         case 'ItemEdit':
    //             $title = "Ubah Data Barang";
    //             break;
    //     }
    //     $data = [
    //         'title' => $title
    //     ];
    //     echo json_encode($data);
    // }

    // public function sale_add()
    // {
    //     $data1 = [
    //         'kode' => $this->input->post('saleCode'),
    //         'tgl' => $this->input->post('saleDate'),
    //         'cust_id' => $this->input->post('idCust'),
    //         'subtotal' => $this->input->post('subTotal'),
    //         'diskon' =>    $this->input->post('disc'),
    //         'ongkir' =>    $this->input->post('shipping'),
    //         'total_bayar' => $this->input->post('totalFee'),
    //     ];

    //     if ($this->sale_model->addSale($data1)) {
    //         echo json_encode(true);
    //     }
    // }

    public function get_all_cust()
    {
        $key = $this->input->get('key');
        echo json_encode($this->cust_model->getAllCust($key));
    }

    public function get_all_item()
    {
        $key = $this->input->get('key');

        $data = [];
        foreach ($this->item_model->getAllItem($key) as $value) {
            $data[] = [
                'id' => $value['id'],
                'kode' => $value['kode'],
                'nama' => $value['nama'],
                'harga' => number_format($value['harga'], 2, ".", ",")
            ];
        }
        echo json_encode($data);
    }

    public function get_cust($id)
    {
        echo json_encode($this->cust_model->getCust($id));
    }

    public function get_no_trans()
    {
        $no = date('Ym') . "-" . str_pad($this->sale_model->getLastId(), 4, '0', STR_PAD_LEFT);;
        echo json_encode($no);
    }


    function sale_per_row()
    {
        $row = $this->item_model->getItem($this->input->post('items'));
        $no = $this->input->post('no');

        $harga_ban = $row['harga'];
        $diskon_dec = ($this->input->post('discPerc') / 100);
        $diskon_nom = $harga_ban * $diskon_dec;
        $harga_disc = $harga_ban - $diskon_nom;
        $harga_tot = $harga_disc * $this->input->post('qty');
        $data = [
            'id' => $row['id'],
            'kode_brg' => $row['kode'],
            'nama_brg' => $row['nama'],
            'qty' => $this->input->post('qty'),
            'harga_ban' => number_format($harga_ban, 2, ".", ","),
            'diskon_perc' => $this->input->post('discPerc'),
            'diskon_nom' => number_format($diskon_nom, 2, ".", ","),
            'harga_disc' => number_format($harga_disc, 2, ".", ","),
            'harga_tot' => number_format($harga_tot, 2, ".", ",")
        ];

        $response = [
            'no' => $no,
            // 'newId' => $row['id'],
            'html' => $this->load->view('part/sale_row', $data, true),
        ];

        echo json_encode($response);
    }

    public function totbar_count()
    {
        ob_start();
        $disco = str_replace(",", "", $this->input->post('disco'));
        $okr = str_replace(",", "", $this->input->post('okr'));
        $arrayTotal = $this->input->post('arrayTot');

        $subtot = 0;
        foreach ($arrayTotal as $tot) {
            $subtot += str_replace(",", "", $tot);
        }

        $totbar = $subtot - $disco + $okr;

        $data = [
            'subtot' => number_format($subtot, 2, ".", ","),
            'totbar' => number_format($totbar, 2, ".", ","),
        ];
        ob_end_clean();
        echo json_encode($data);
    }
    // function add_sale()
    // {
    //     $data = [
    //         'kode' => '',
    //         'tgl' => '',
    //         'cust_id' => '',
    //         'subtotal' => '',
    //         'diskon' => '',
    //         'ongkir' => '',
    //         'total_bayar' => ''
    //     ];
    //     // $insertId = $this->db->insert_id();

    //     $insert = [
    //         'insert' => $this->db->insert('t_sales', $data),
    //         'id' => $this->db->insert_id() + 1
    //     ];
    //     echo json_encode($insert);
    // }

    public function sale_submit()
    {
        $post = $this->input->post();
        $data1 = [
            'kode' => $post['noTrans'],
            'tgl' => $post['date'],
            'cust_id' => $post['custCode'],
            'subtotal' => str_replace(",", "", $post['subTot']),
            'diskon' => str_replace(",", "", $post['disco']),
            'ongkir' => str_replace(",", "", $post['okr']),
            'total_bayar' => str_replace(",", "", $post['totbar'])
        ];

        $insertSales = $this->sale_model->addSale($data1);

        if ($insertSales['insert']) {
            $data2 = [];
            for ($i = 0; $i < count($post['idItem']); $i++) {
                $data2[] = [
                    'sales_id' => $insertSales['insert_id'],
                    'barang_id' => $post['idItem'][$i],
                    'qty' => $post['qty'][$i],
                    'harga_bandrol' => str_replace(",", "", $post['itemPrice'][$i]),
                    'diskon_pct' => $post['discPerc'][$i] / 100,
                    'diskon_nilai' => str_replace(",", "", $post['nomDisc'][$i]),
                    'harga_diskon' => str_replace(",", "", $post['priceDisc'][$i]),
                    'total' => str_replace(",", "", $post['priceTot'][$i])
                ];
            }
        }
        $insertSaleDetail = $this->sale_model->addSaleDetail($data2);

        if ($insertSaleDetail) {
            echo json_encode(true);
        }
    }
}
