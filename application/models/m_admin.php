<?php
class M_admin extends CI_Model {
  	function __construct()
    {
        parent::__construct();
    }
    function getitemrates($customer, $item_name)
    {
        $this->db->select('*')
                 ->from('bud_te_itemrates')
                 ->where('customer_id', $customer)
                 ->where('item_id', $item_name);
        $query = $this -> db -> get();
        return $query->result_array();
    }
    function getitemrates_yt($customer, $item_name, $shade_id)
    {
        $this->db->select('*')
                 ->from('bud_yt_itemrates')
                 ->where('customer_id', $customer)
                 ->where('item_id', $item_name)
                 ->where('shade_id', $shade_id);
        $query = $this -> db -> get();
        return $query->result_array();
    }
    function getitemrates_label($customer, $item_name)
    {
        $this->db->select('*')
                 ->from('bud_lbl_itemrates')
                 ->where('customer_id', $customer)
                 ->where('item_id', $item_name);
        $query = $this -> db -> get();
        return $query->result_array();
    }
    function check_concern_exist($module, $concern_name)
    {
        $this->db->select('*')
                 ->from('bud_concern_master')
                 ->where('module', $module)
                 ->where('concern_name', $concern_name);
        $query = $this -> db -> get();
        if ($query->num_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
