<?php
class Packing_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    public function get_suppliers()
    {
        $result = $this->db->get('bud_suppliers');
        return $result->result();
    }
    public function get_item_groups()
    {
        $result = $this->db->get('bud_itemgroups');
        return $result->result();
    }
    public function get_items()
    {
        $this->db->order_by('item_name', 'asc');
        $result = $this->db->get('bud_items');
        return $result->result();
    }
    public function get_shades()
    {
        $result = $this->db->get('bud_shades');
        return $result->result();
    }
    public function get_uoms()
    {
        $result = $this->db->get('bud_uoms');
        return $result->result();
    }
    public function get_concerns()
    {
        $this->db->where('concern_active', 1);
        $this->db->order_by('concern_name', 'asc');
        $result = $this->db->get('bud_concern_master');
        return $result->result();
    }
    public function get_stock_rooms($concern_id = false)
    {
        if (!empty($concern_id)) {
            $this->db->where('concern_id', $concern_id);
        }
        $result = $this->db->get('bud_stock_rooms');
        return $result->result();
    }
    function getNextBoxNo($box_prefix)
    {
        $this->db->select_max('box_no');
        $this->db->where('box_prefix', $box_prefix);
        $query = $this->db->get('bud_sh_packing');
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->box_no + 1;
        }
    }
    public function save_packing($save)
    {
        if ($save['box_id']) {
            $this->db->where('box_id', $save['box_id']);
            $this->db->update('bud_sh_packing', $save);
            return $save['box_id'];
        } else {

            $box_prefix = (isset($save['box_prefix'])) ? $save['box_prefix'] : 'SH';
            if ($this->box_check_exist($box_prefix, $save['box_no'])) {
                $this->db->insert('bud_sh_packing', $save);
                return $this->db->insert_id();
            }
        }
    }

    public function save_trans_packing($save)
    {
        if ($this->box_check_exist($save['box_prefix'], $save['box_no'])) {

            $this->db->insert('bud_sh_packing', $save);
            return $this->db->insert_id();
        }
    }
    //Dynamic Dost 3.0- stock deletion from indofila unit when transfered
    public function update_yt_packing($box_id)
    {

        $this->db->where('box_id', $box_id);
        $box['box_id'] = $box_id;
        $box['delivery_status'] = 0;
        $update_data[] = $box;
        $this->db->update_batch('bud_yt_packing_boxes', $update_data, 'box_id');
    }
    //end of Dynamic Dost 3.0- stock deletion from indofila unit when transfered

    public function update_trans_packing($update_data)
    {
        $this->db->where("box_prefix", $update_data['box_prefix']);
        $this->db->where("box_no", $update_data['box_no']);
        $this->db->update('bud_sh_packing', $update_data);
        return true;
    }

    public function box_check_exist($box_prefix, $box_no)
    {
        $this->db->where("box_prefix", $box_prefix);
        $this->db->where("box_no", $box_no);
        $query = $this->db->get("bud_sh_packing");
        if ($query->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function get_shop_packings($is_deleted = false, $shop_box_only = true)
    {
        $this->db->select('bud_sh_packing.*');
        $this->db->select('bud_itemgroups.group_name');
        $this->db->select('bud_items.item_name');
        $this->db->select('bud_users.user_nicename');
        $this->db->select('bud_shades.shade_name, bud_shades.shade_code');
        $this->db->select('bud_suppliers.sup_name');
        $this->db->select('bud_stock_rooms.stock_room_name');
        $this->db->join('bud_itemgroups', 'bud_sh_packing.item_group_id=bud_itemgroups.group_id', 'left');
        $this->db->join('bud_items', 'bud_sh_packing.item_id=bud_items.item_id', 'left');
        $this->db->join('bud_shades', 'bud_sh_packing.shade_id=bud_shades.shade_id', 'left');
        $this->db->join('bud_users', 'bud_sh_packing.prepared_by=bud_users.ID', 'left');
        $this->db->join('bud_suppliers', 'bud_sh_packing.supplier_id=bud_suppliers.sup_id', 'left');
        $this->db->join('bud_stock_rooms', 'bud_sh_packing.stock_room_id=bud_stock_rooms.stock_room_id', 'left');
        if (!empty($is_deleted)) {
            $this->db->where('bud_sh_packing.is_deleted', $is_deleted);
        }
        if (!empty($shop_box_only)) {
            $this->db->where('bud_sh_packing.box_prefix', 'SH');
        }
        $this->db->where('bud_sh_packing.is_deleted', 0);

        $this->db->order_by('bud_sh_packing.box_id', 'desc');
        return $this->db->get('bud_sh_packing')->result();
    }

    public function get_shop_deleted_boxes()
    {
        $this->db->select('bud_sh_packing.*');
        $this->db->select('bud_itemgroups.group_name');
        $this->db->select('bud_items.item_name');
        $this->db->select('bud_users.user_nicename');
        $this->db->select('delete_user.user_nicename as deleted_by');
        $this->db->select('bud_shades.shade_name, bud_shades.shade_code');
        $this->db->select('bud_suppliers.sup_name');
        $this->db->select('bud_stock_rooms.stock_room_name');
        $this->db->join('bud_itemgroups', 'bud_sh_packing.item_group_id=bud_itemgroups.group_id', 'left');
        $this->db->join('bud_items', 'bud_sh_packing.item_id=bud_items.item_id', 'left');
        $this->db->join('bud_shades', 'bud_sh_packing.shade_id=bud_shades.shade_id', 'left');
        $this->db->join('bud_users', 'bud_sh_packing.prepared_by=bud_users.ID', 'left');
        $this->db->join('bud_users delete_user', 'bud_sh_packing.prepared_by=delete_user.ID', 'left');
        $this->db->join('bud_suppliers', 'bud_sh_packing.supplier_id=bud_suppliers.sup_id', 'left');
        $this->db->join('bud_stock_rooms', 'bud_sh_packing.stock_room_id=bud_stock_rooms.stock_room_id', 'left');
        $this->db->where('bud_sh_packing.is_deleted', 1);
        $this->db->where('bud_sh_packing.final_deleted', 0);
        $this->db->order_by('bud_sh_packing.box_id', 'asc');
        return $this->db->get('bud_sh_packing')->result();
    }

    public function get_shop_box($box_id)
    {
        $this->db->select('bud_sh_packing.*');
        $this->db->select('bud_itemgroups.group_name');
        $this->db->select('bud_items.item_name');
        $this->db->select('bud_uoms.uom_name');
        $this->db->select('bud_users.user_nicename');
        $this->db->select('bud_shades.shade_name, bud_shades.shade_code, bud_shades.category_id');
        $this->db->select('bud_suppliers.sup_name');
        $this->db->select('bud_stock_rooms.stock_room_name');
        $this->db->join('bud_itemgroups', 'bud_sh_packing.item_group_id=bud_itemgroups.group_id', 'left');
        $this->db->join('bud_items', 'bud_sh_packing.item_id=bud_items.item_id', 'left');
        $this->db->join('bud_shades', 'bud_sh_packing.shade_id=bud_shades.shade_id', 'left');
        $this->db->join('bud_users', 'bud_sh_packing.prepared_by=bud_users.ID', 'left');
        $this->db->join('bud_suppliers', 'bud_sh_packing.supplier_id=bud_suppliers.sup_id', 'left');
        $this->db->join('bud_stock_rooms', 'bud_sh_packing.stock_room_id = bud_stock_rooms.stock_room_id', 'left');
        $this->db->join('bud_uoms', 'bud_sh_packing.uom_id = bud_uoms.uom_id', 'left');
        $this->db->where('bud_sh_packing.box_id', $box_id);
        return $this->db->get('bud_sh_packing')->row();
    }
}
