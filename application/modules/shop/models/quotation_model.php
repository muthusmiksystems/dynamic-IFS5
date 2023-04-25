<?php
class Quotation_model extends CI_Model {
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
            $this->db->update('bud_sh_quotation_trans', $save);
            $id = $save['id'];
        }
        else
        {
            $this->db->insert('bud_sh_quotation_trans', $save);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function get_transfer_list($filter = array(), $transfer_status = false)
    {
        // print_r($filter);
        $is_admin = $this->m_users->is_admin($this->session->userdata('user_id'));

        $this->db->select('bud_sh_quotation_trans.*');
        $this->db->select('from_user.display_name as from_staff_name');
        $this->db->select('to_user.display_name as to_staff_name');
        $this->db->select('accepted.display_name as accepted_name');       
        
        $this->db->join('bud_users from_user', 'bud_sh_quotation_trans.transfer_by=from_user.ID', 'left');
        $this->db->join('bud_users to_user', 'bud_sh_quotation_trans.transfer_to=to_user.ID', 'left');
        $this->db->join('bud_users accepted', 'bud_sh_quotation_trans.accepted_by=accepted.ID', 'left');
        
        if(!$is_admin)
        {
            if(count($filter) > 0)
            {
                if(isset($filter['accepted_by']))
                {
                    $this->db->where('bud_sh_quotation_trans.accepted_by', $filter['accepted_by']);                
                }
                if(isset($filter['pending_only']))
                {
                    $this->db->where('bud_sh_quotation_trans.is_accepted', 0);
                }
                if(isset($filter['to_user_id']))
                {
                    $to_user_id = $filter['to_user_id'];
                    $from_user_id = $filter['from_user_id'];
                    $where = "(FIND_IN_SET('$to_user_id',bud_sh_quotation_trans.to_user_id) > 0 or bud_sh_quotation_trans.from_user_id='$to_user_id')"; 
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
                    $this->db->where('bud_sh_quotation_trans.accepted_by', $filter['accepted_by']);                
                }
                if(isset($filter['pending_only']))
                {
                    $this->db->where('bud_sh_quotation_trans.is_accepted', 0);
                }
            }
        }

        // $this->db->group_by('bud_sh_quotation_trans.id');
        $result = $this->db->get('bud_sh_quotation_trans');
        return $result->result();
    }

    public function get_cash_transfer($id = '')
    {
        $this->db->select('bud_sh_quotation_trans.*');
        $this->db->select('from_user.display_name as from_staff_name');
        $this->db->select('to_user.display_name as to_staff_name');
        $this->db->select('accepted.display_name as accepted_name');       
        
        $this->db->join('bud_users from_user', 'bud_sh_quotation_trans.transfer_by=from_user.ID', 'left');
        $this->db->join('bud_users to_user', 'bud_sh_quotation_trans.transfer_to=to_user.ID', 'left');
        $this->db->join('bud_users accepted', 'bud_sh_quotation_trans.accepted_by=accepted.ID', 'left');
        
        $this->db->where('bud_sh_quotation_trans.id', $id);

        $result = $this->db->get('bud_sh_quotation_trans');
        return $result->row();
    }
    public function update_delete_status_quotation_sh($quotation_id,$remarks)//ER-07-18#-17
    {
        $data = array('is_deleted' => '0',
                      'remarks' => $remarks,
                      'last_edited_id' => $this->session->userdata('user_id'),
                      'last_edited_time' => date('Y-m-d H:i:s')
                    );
        $this->db->where('quotation_id', $quotation_id);
        $result=$this->db->update('bud_sh_quotations', $data);
        if($result)
        {
            $updateData = array(
                'is_deleted' => 0 
                );
            $result=$this->m_purchase->updateDatas('bud_sh_quotation_items','quotation_id', $quotation_id, $updateData);
        }
        $quotations=$this->m_masters->getmasterdetails('bud_sh_quotation_items','quotation_id',$quotation_id);
        $quotation_no=$this->m_masters->getmasterIDvalue('bud_sh_quotations','quotation_id',$quotation_id,'quotation_no');
        $dc_remarks='Quotation '.$quotation_no.' Deleted coz of'.$remarks;
        foreach ($quotations as $quotation) {
            $delivery_id=$quotation['delivery_id'];
            $p_delivery_id=$this->m_masters->getmasterIDvalue('bud_sh_delivery','delivery_id',$delivery_id,'p_delivery_id');
            if ($result) {
                $result=$this->Delivery_model->update_delete_status_delivery_sh($delivery_id,$dc_remarks);
            }
            if ($result) {
                $result=$this->Predelivery_model->update_delete_status_predelivery_sh($p_delivery_id,$dc_remarks);
            }
        }
        return $result;
    }
}
