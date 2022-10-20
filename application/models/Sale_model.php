<?php

class Sale_model extends CI_Model
{
    private $_t_sales = 't_sales';
    private $_t_sales_det = 't_sales_det';
    private $_m_customer = 'm_customer';
    private $_m_barang = 'm_barang';

    var $column_order = array(null, null, 'tgl', null, 'juml_brg', 'subtotal', null, null, 'total_bayar'); //field yang ada di table user
    var $column_search = array('name'); //field yang diizin untuk pencarian 
    var $order = array('tgl' => 'asc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {

        $this->db->select('*, SUM(t_sales_det.qty) AS juml_brg');
        $this->db->from($this->_t_sales_det);
        $this->db->join($this->_t_sales, 't_sales_det.sales_id = t_sales.id');
        $this->db->join($this->_m_customer, 't_sales.cust_id = m_customer.id');
        $this->db->join($this->_m_barang, 't_sales_det.barang_id = m_barang.id');
        $this->db->group_by('t_sales.id');

        $i = 0;

        foreach ($this->column_search as $item) // looping awal
        {
            if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {

                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function get_detail($id)
    {
        $this->db->select('m_barang.kode, m_barang.nama, m_barang.harga, t_sales_det.qty, t_sales_det.diskon_pct, t_sales_det.diskon_nilai, t_sales_det.harga_diskon, t_sales_det.total');
        $this->db->join($this->_t_sales, 't_sales_det.sales_id = t_sales.id');
        $this->db->join($this->_m_customer, 't_sales.cust_id = m_customer.id');
        $this->db->join($this->_m_barang, 't_sales_det.barang_id = m_barang.id');
        return $this->db->get_where($this->_t_sales_det, ['t_sales.id' => $id])->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->_t_sales);
        return $this->db->count_all_results();
    }

    public function addSale($data)
    {
        return [
            'insert' => $this->db->insert($this->_t_sales, $data),
            'insert_id' => $this->db->insert_id()
        ];
    }

    public function addSaleDetail($data)
    {
        return $this->db->insert_batch($this->_t_sales_det, $data);
    }

    public function getLastId()
    {
        $row = $this->db->order_by('id', "desc")->limit(1)->get($this->_t_sales)->row_array();
        return $row['id'] ? $row['id'] + 1 : 1;
    }
}
