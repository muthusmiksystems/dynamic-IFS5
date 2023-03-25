<?php
class Cashinvoice_model extends CI_Model {
  	function __construct()
    {
        parent::__construct();
    }

    public function save_transfer($save)
    {
        $id = false;
        if($save['id'])
        {
            $this->db->where('id', $save['id']);
            $this->db->update('bud_sh_cash_invoice_trans', $save);
            $id = $save['id'];
        }
        else
        {
            $this->db->insert('bud_sh_cash_invoice_trans', $save);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function get_transfer_list($filter = array(), $transfer_status = false)
    {
        // print_r($filter);
        $is_admin = $this->m_users->is_admin($this->session->userdata('user_id'));

        $this->db->select('bud_sh_cash_invoice_trans.*');
        $this->db->select('from_user.display_name as from_staff_name');
        $this->db->select('to_user.display_name as to_staff_name');
        $this->db->select('accepted.display_name as accepted_name');       
        
        $this->db->join('bud_users from_user', 'bud_sh_cash_invoice_trans.transfer_by=from_user.ID', 'left');
        $this->db->join('bud_users to_user', 'bud_sh_cash_invoice_trans.transfer_to=to_user.ID', 'left');
        $this->db->join('bud_users accepted', 'bud_sh_cash_invoice_trans.accepted_by=accepted.ID', 'left');
        
        if(!$is_admin)
        {
            if(count($filter) > 0)
            {
                if(isset($filter['accepted_by']))
                {
                    $this->db->where('bud_sh_cash_invoice_trans.accepted_by', $filter['accepted_by']);                
                }
                if(isset($filter['pending_only']))
                {
                    $this->db->where('bud_sh_cash_invoice_trans.is_accepted', 0);
                }
                if(isset($filter['to_user_id']))
                {
                    $to_user_id = $filter['to_user_id'];
                    $from_user_id = $filter['from_user_id'];
                    $where = "(FIND_IN_SET('$to_user_id',bud_sh_cash_invoice_trans.to_user_id) > 0 or bud_sh_cash_invoice_trans.from_user_id='$to_user_id')"; 
                    $this->db->where($where, null, false);
                }                
            }
        }
        else
        {
            if(count($filter) > 0)
            {
                if(isset($filter['accepted_by']))
                {
                    $this->db->where('bud_sh_cash_invoice_trans.accepted_by', $filter['accepted_by']);                
                }
                if(isset($filter['pending_only']))
                {
                    $this->db->where('bud_sh_cash_invoice_trans.is_accepted', 0);
                }
            }
        }

        // $this->db->group_by('bud_sh_cash_invoice_trans.id');
        $result = $this->db->get('bud_sh_cash_invoice_trans');
        return $result->result();
    }

    public function get_cash_transfer($id = '')
    {
        $this->db->select('bud_sh_cash_invoice_trans.*');
        $this->db->select('from_user.display_name as from_staff_name');
        $this->db->select('to_user.display_name as to_staff_name');
        $this->db->select('accepted.display_name as accepted_name');       
        
        $this->db->join('bud_users from_user', 'bud_sh_cash_invoice_trans.transfer_by=from_user.ID', 'left');
        $this->db->join('bud_users to_user', 'bud_sh_cash_invoice_trans.transfer_to=to_user.ID', 'left');
        $this->db->join('bud_users accepted', 'bud_sh_cash_invoice_trans.accepted_by=accepted.ID', 'left');
        
        $this->db->where('bud_sh_cash_invoice_trans.id', $id);

        $result = $this->db->get('bud_sh_cash_invoice_trans');
        return $result->row();
    }

    public function get_cash_inv_boxes($invoice_id = '')
    {
        $this->db->select('bud_sh_cash_invoice_items.*');
        $this->db->select('bud_sh_cash_invoices.*');
        $this->db->select('bud_itemgroups.group_name');
        $this->db->select('bud_items.item_name');
        $this->db->select('bud_shades.shade_name, bud_shades.shade_code');
        $this->db->join('bud_sh_cash_invoices', 'bud_sh_cash_invoice_items.invoice_id=bud_sh_cash_invoices.invoice_id', 'left');
        $this->db->join('bud_itemgroups', 'bud_sh_cash_invoice_items.item_group_id=bud_itemgroups.group_id', 'left');
        $this->db->join('bud_items', 'bud_sh_cash_invoice_items.item_id=bud_items.item_id', 'left');
        $this->db->join('bud_shades', 'bud_sh_cash_invoice_items.shade_id=bud_shades.shade_id', 'left');
        $this->db->order_by('bud_sh_cash_invoice_items.invoice_id', 'desc');
        if(!empty($invoice_id))
        {
            $this->db->where('bud_sh_cash_invoices.invoice_id', $invoice_id);
        }
        return $this->db->get('bud_sh_cash_invoice_items')->result();
    }
}