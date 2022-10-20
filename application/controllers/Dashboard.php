<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('Sale_model');
	}

	public function index()
	{

		$data = [
			'title' => 'Dashboard - Aplikasi Transaksi',
			'username' => $this->session->userdata('username')
		];

		if ($this->session->userdata('username')) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('application/dashboard', $data);
			$this->load->view('templates/footer', $data);
		} else {
			redirect('auth');
		}
	}

	function detail_modal($data, $no)
	{
		$otput = '';
		foreach ($data as $detail) {
			$otput .= '<ul class="list-group mb-4">';
			$otput .= '<li class="list-group-item active">Kode : <b>' . $detail->kode . '</b></li>';
			$otput .= '<li class="list-group-item">Nama :  <b>' . $detail->nama . '</b></li>';
			$otput .= '<li class="list-group-item">Harga :  <b>' . number_format($detail->harga, 2, ".", ",") . '</b></li>';
			$otput .= '<li class="list-group-item">Jumlah :  <b>' . $detail->qty . '</b></li>';
			$otput .= '<li class="list-group-item">Diskon (%) :  <b>' . ($detail->diskon_pct * 100) . '</b></li>';
			$otput .= '<li class="list-group-item">Diskon (Rp) :  <b>' . number_format($detail->diskon_nilai, 2, ".", ",") . '</b></li>';
			$otput .= '<li class="list-group-item">Harga Dison :  <b>' . number_format($detail->harga_diskon, 2, ".", ",") . '</b></li>';
			$otput .= '<li class="list-group-item">Total Harga :  <b>' . number_format($detail->total, 2, ".", ",") . '</b></li>';
			$otput .= '</ul>';
		}

		$html = '<b>' . $no . '. </b>
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal-' . $no . '">
			<i class="fas fa-info-circle" aria-hidden="true"></i>
			</button>
			<div class="modal" id="myModal-' . $no . '">
			<div class="modal-dialog">
			  <div class="modal-content">
		  
				<!-- Modal Header -->
				<div class="modal-header">
				  <h4 class="modal-title">Detail Barang</h4>
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
		  
				<!-- Modal body -->
				<div class="modal-body">
				' . $otput . '
				</div>
		  
				<!-- Modal footer -->
				<div class="modal-footer">
				  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
		  
			  </div>
			</div>
		  </div>';
		return $html;
	}

	function get_data_trans()
	{
		$list = $this->Sale_model->get_datatables();
		$data = [];
		$no = $_POST['start'];
		foreach ($list as $field) {
			$no++;

			$detail = $this->Sale_model->get_detail($field->sales_id);


			$row = [];

			$html = $this->detail_modal($detail, $no);
			$row[] = $html;
			$row[] = $field->kode;
			$row[] = $field->tgl;
			$row[] = $field->name;
			$row[] = $field->juml_brg;
			$row[] = number_format($field->subtotal, 2, ".", ",");
			$row[] = number_format($field->diskon, 2, ".", ",");
			$row[] = number_format($field->ongkir, 2, ".", ",");
			$row[] = number_format($field->total_bayar, 2, ".", ",");



			$data[] = $row;
		}


		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Sale_model->count_all(),
			"recordsFiltered" => $this->Sale_model->count_filtered(),
			"data" => $data,
		);
		echo json_encode($output);
	}
}
