<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ML_quote extends CI_Model
{



    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    function get_no($where)
    {
        $this->db->select('count(id) as auto');
        $this->db->from('tbl_bill');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result_array();
    }
    function sale_outward_detail($where)
    {
        $this->db->select('tbl_quote.* , bud_concern_master.concern_name as bname');
        $this->db->from('tbl_quote');
        $this->db->join('bud_concern_master', 'bud_concern_master.concern_id= tbl_quote.branch', 'left');
        $this->db->where($where);
        $this->db->where('sale_type', '1');
        $this->db->order_by('tbl_quote.id', 'desc');
        return $this->db->get()->result_array();
    }
}
