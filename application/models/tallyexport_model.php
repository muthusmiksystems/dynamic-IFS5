<?php
class Tallyexport_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    function get_yt_invoices()
    {
        $this->db->select('bud_yt_invoices.*');
        $this->db->select('bud_yt_invoices.concern_name as concern_id');
        $this->db->select('bud_customers.cust_name');
        $this->db->select('bud_concern_master.concern_name');
        $this->db->join('bud_customers', 'bud_yt_invoices.customer=bud_customers.cust_id', 'left');
        $this->db->join('bud_concern_master', 'bud_yt_invoices.concern_name=bud_concern_master.concern_id', 'left');
        $result = $this->db->get('bud_yt_invoices');
        return $result->result();
    }
}
