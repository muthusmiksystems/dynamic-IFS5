<?php
class M_registers extends CI_Model {
  	function __construct()
    {
        parent::__construct();
    }
    function getItem_rate_reg_yt($search)
    {
        $this->db->select('bud_yt_itemrates.*');
        $this->db->select('bud_customers.cust_name');
        $this->db->select('bud_items.item_name,bud_items.direct_sales_rate');
        $this->db->select('bud_shades.shade_name');
        $this->db->join('bud_customers', 'bud_yt_itemrates.customer_id=bud_customers.cust_id');
        $this->db->join('bud_items', 'bud_yt_itemrates.item_id=bud_items.item_id');
        $this->db->join('bud_shades', 'bud_yt_itemrates.shade_id=bud_shades.shade_id');

        if(isset($search['rate_changed_by']) && $search['rate_changed_by'] != '')
        {
            $this->db->where("FIND_IN_SET(".$search['rate_changed_by'].", rate_changed_by) != 0");
        }

        if(!empty($search['from_date']) && $search['to_date'])
        {
            $dates = $this->m_updates->date_range($search['from_date'], $search['to_date']);
            $dates_where = $this->convert_to_string($dates);
            if($dates_where != '')
            {
                $this->db->where("($dates_where)", NULL, FALSE);            
            }            
        }

        if(isset($search['customer_id']) && $search['customer_id'] != '')
        {
            $this->db->where('bud_yt_itemrates.customer_id', $search['customer_id']);
        }
        if(isset($search['item_id']) && $search['item_id'] != '')
        {
            $this->db->where('bud_yt_itemrates.item_id', $search['item_id']);
        }
        if(isset($search['shade_id']) && $search['shade_id'] != '')
        {
            $this->db->where('bud_yt_shaderates.shade_id', $search['shade_id']);
        }

        return $this->db->get('bud_yt_itemrates')->result();
    }

    function convert_to_string($dates)
    {
        return implode(" || ",array_map(function($v){return sprintf("FIND_IN_SET('%s', date(rate_changed_on)) != 0",$v);},array_values($dates)));
    }

    function getDeletedBoxesYt($search)
    {
        $this->db->select('bud_yt_packing_boxes.*');
        $this->db->select('bud_items.*');
        $this->db->select('bud_users.display_name as deleted_by_name');
        $this->db->select('bud_yt_yarndeniers.denier_tech');
        $this->db->select('bud_yt_poydeniers.denier_name as poy_denier_name');
        $this->db->select('bud_shades.*');
        $this->db->select('bud_lots.lot_no as pack_lot_no');
        $this->db->from('bud_yt_packing_boxes');
        $this->db->join('bud_items','bud_items.item_id = bud_yt_packing_boxes.item_id', 'left');
        $this->db->join('bud_yt_yarndeniers','bud_yt_yarndeniers.denier_id = bud_yt_packing_boxes.yarn_denier', 'left');
        $this->db->join('bud_yt_poydeniers','bud_yt_poydeniers.denier_id = bud_yt_packing_boxes.poy_denier', 'left');
        $this->db->join('bud_shades','bud_shades.shade_id = bud_yt_packing_boxes.shade_no', 'left');
        $this->db->join('bud_users','bud_users.ID = bud_yt_packing_boxes.deleted_by', 'left');        
        $this->db->join('bud_lots','bud_lots.lot_id = bud_yt_packing_boxes.lot_no', 'left');
        $this->db->where('bud_yt_packing_boxes.is_deleted', 1);
        if(!empty($search['from_date']) && !empty($search['to_date']))
        {
            $from_date = date("Y-m-d", strtotime($search['from_date']));
            $to_date = date("Y-m-d", strtotime($search['to_date']));
            $this->db->where("DATE(deleted_time) between '$from_date' and '$to_date'");
        }
        if(!empty($search['deleted_by']) && $search['deleted_by'] != 0)
        {
            $this->db->where('bud_yt_packing_boxes.deleted_by', $search['deleted_by']);
        }
        if(!empty($search['item_id']))
        {
            $this->db->where('bud_yt_packing_boxes.item_id', $search['item_id']);
        }
        if(!empty($search['shade_id']))
        {
            $this->db->where('bud_yt_packing_boxes.shade_no', $search['shade_id']);
        }
        $this->db->group_by('bud_yt_packing_boxes.box_id');
        $this->db->order_by('bud_yt_packing_boxes.deleted_time', 'desc');
        return $this->db->get('bud_yt_itemrates')->result();
    }

    function getCustomers()
    {
        $this->db->select('customer_mobile, customer_name');
        $this->db->distinct('customer_mobile');
        $this->db->from('bud_estimates_shop');
        $query = $this -> db -> get();
        return $query->result_array();
    }
    function get_item($item_id)
    {
        $this->db->where('item_id', $item_id);
        return $this->db->get('bud_items')->row();
    }
    function delete_estimate_yt($updateData)
    {
        $this->db->update_batch('bud_estimates_shop', $updateData, 'estimate_id');
    }
    function final_delete_estimate_yt($selected_estimate = array())
    {
        $this->db->where_in('estimate_id', $selected_estimate);
        $this->db->delete('bud_estimates_shop');
    }
    function get_cust_item_estimate_reg($search)
    {
        $is_admin = $this->m_users->is_admin($this->session->userdata('user_id'));
        $this->db->select('*');        
        if(!empty($search['from_date']) && !empty($search['to_date']))
        {
            $from_date = date("Y-m-d", strtotime($search['from_date']));
            $to_date = date("Y-m-d", strtotime($search['to_date']));
            $this->db->where("DATE(estimate_date) between '$from_date' and '$to_date'");
        }
        if(!empty($search['customer_mobile']))
        {
            $this->db->where('customer_mobile', $search['customer_mobile']);
        }
        if(!$is_admin)
        {
            $this->db->where('is_deleted', 0);
        }
        $estimates = $this->db->get('bud_estimates_shop')->result();

        $return = array();
        foreach ($estimates as $estimate) {
            $estimate_id = $estimate->estimate_id;
            $estimate_date = $estimate->estimate_date;
            $customer_mobile = $estimate->customer_mobile;
            $customer_name = $estimate->customer_name;
            $this->db->select('bud_estimate_items.*, bud_items.item_name');
            $this->db->select('bud_shades.shade_name,bud_shades.shade_code');
            $this->db->join('bud_items','bud_items.item_id = bud_estimate_items.item_id');
            $this->db->join('bud_shades','bud_shades.shade_id = bud_estimate_items.shade_id');
            $this->db->where('estimate_id', $estimate_id);
            if(!empty($search['item_id']))
            {
                $this->db->where('bud_items.item_id', $search['item_id']);                    
            }
            if(!empty($search['shade_id']))
            {
                $this->db->where('bud_estimate_items.shade_id', $search['shade_id']);                    
            }
            $item_details = $this->db->get('bud_estimate_items')->result();

            if($item_details)
            {
                foreach ($item_details as $row) {
                    $item = $this->get_item($row->item_id);
                    $row->item_name = $item->item_name;
                    $row->estimate_date = $estimate_date;
                    $row->customer_name = $customer_name;
                    $row->customer_mobile = $customer_mobile;
                    // $return[$customer_mobile][] = $item_details;
                    $return[$estimate_id][] = $row;
                }
            }
        }
        return $return;
    }

    function materialInwarsReg($search)
    {
        $this->db->select('bud_material_inward.*');
        $this->db->select('bud_general_items.item_name as item_id');
        $this->db->select('bud_general_customers.company_name');
        $this->db->select('bud_uoms.uom_name');
        $this->db->select('bud_stock_rooms.stock_room_name');
        $this->db->select('bud_concern_master.concern_name');
        $this->db->select('inward_staff_tbl.user_login as inward_staff');
        $this->db->select('custody_staff_tbl.user_login as custody_staff');
        $this->db->join('bud_general_items', 'bud_general_items.item_id=bud_material_inward.item_name');
        $this->db->join('bud_concern_master', 'bud_concern_master.concern_id=bud_material_inward.concern_name');
        $this->db->join('bud_general_customers', 'bud_general_customers.company_id=bud_material_inward.supplier');
        $this->db->join('bud_uoms', 'bud_uoms.uom_id=bud_material_inward.item_uom');
        $this->db->join('bud_users inward_staff_tbl', 'inward_staff_tbl.ID=bud_material_inward.prepared_by');
        $this->db->join('bud_users custody_staff_tbl', 'custody_staff_tbl.ID=bud_material_inward.given_to');
        $this->db->join('bud_stock_rooms', 'bud_stock_rooms.stock_room_id=bud_material_inward.stock_room', 'left');
        if(!empty($search['from_date']) && !empty($search['to_date']))
        {
            $from_date = date("Y-m-d", strtotime($search['from_date']));
            $to_date = date("Y-m-d", strtotime($search['to_date']));
            $this->db->where("DATE(inward_date) between '$from_date' and '$to_date'");
        }
        if(!empty($search['prepared_by']))
        {
            $this->db->where('bud_material_inward.prepared_by', $search['prepared_by']);
        }
        if(!empty($search['supplier']))
        {
            $this->db->where('bud_material_inward.supplier', $search['supplier']);
        }
        if(!empty($search['item_id']))
        {
            $this->db->where('bud_material_inward.item_name', $search['item_id']);
        }
        if(!empty($search['concern_id']))
        {
            $this->db->where('bud_material_inward.concern_name', $search['concern_id']);
        }
        $this->db->order_by('bud_material_inward.inward_id', 'desc');
        return $this->db->get('bud_material_inward')->result();
    }
}