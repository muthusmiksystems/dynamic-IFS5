<?php
class Stocktrans_model extends CI_Model
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
    public function get_stock_rooms()
    {
        $result = $this->db->get('bud_stock_rooms');
        return $result->result();
    }
    public function get_concerns()
    {
        $this->db->where('concern_active', 1);
        //$this->db->order_by('concern_name', 'asc');
        $result = $this->db->get('bud_concern_master');
        return $result->result();
    }
    public function get_users($user_category = '')
    {
        $this->db->select('bud_users.*');
        if (!empty($user_category)) {
            $this->db->select('bud_user_category.category_id');
            $this->db->select('bud_user_category.category_name');
            $this->db->join('bud_user_category', 'bud_users.user_category=bud_user_category.category_id', 'left');
            $this->db->where_in('category_name', $user_category);
        }
        $result = $this->db->get('bud_users');
        return $result->result();
    }
    public function get_user($ID)
    {
        $this->db->where('ID', $ID);
        $result = $this->db->get('bud_users');
        return $result->row();
    }
    public function save_packing($save)
    {
        if ($save['box_id']) {
            $this->db->where('box_id', $save['box_id']);
            $this->db->update('bud_sh_packing', $save);
            return $save['box_id'];
        } else {
            $this->db->insert('bud_sh_packing', $save);
            return $this->db->insert_id();
        }
    }
    public function get_shop_packings($is_deleted = false)
    {
        $this->db->select('bud_sh_packing.*');
        $this->db->select('bud_itemgroups.group_name');
        $this->db->select('bud_items.item_name');
        $this->db->select('bud_users.user_nicename');
        $this->db->select('bud_shades.shade_name, bud_shades.shade_code');
        $this->db->select('bud_suppliers.sup_name');
        $this->db->join('bud_itemgroups', 'bud_sh_packing.item_group_id=bud_itemgroups.group_id', 'left');
        $this->db->join('bud_items', 'bud_sh_packing.item_id=bud_items.item_id', 'left');
        $this->db->join('bud_shades', 'bud_sh_packing.shade_id=bud_shades.shade_id', 'left');
        $this->db->join('bud_users', 'bud_sh_packing.prepared_by=bud_users.ID', 'left');
        $this->db->join('bud_suppliers', 'bud_sh_packing.supplier_id=bud_suppliers.sup_id', 'left');
        if (!empty($is_deleted)) {
            $this->db->where('bud_sh_packing.is_deleted', $is_deleted);
        }
        $this->db->order_by('bud_sh_packing.box_id', 'asc');
        return $this->db->get('bud_sh_packing')->result();
    }
    public function get_shop_box($box_id)
    {
        $this->db->select('bud_sh_packing.*');
        $this->db->select('bud_itemgroups.group_name');
        $this->db->select('bud_items.item_name');
        $this->db->select('bud_users.user_nicename');
        $this->db->select('bud_shades.shade_name, bud_shades.shade_code');
        $this->db->select('bud_suppliers.sup_name');
        $this->db->join('bud_itemgroups', 'bud_sh_packing.item_group_id=bud_itemgroups.group_id', 'left');
        $this->db->join('bud_items', 'bud_sh_packing.item_id=bud_items.item_id', 'left');
        $this->db->join('bud_shades', 'bud_sh_packing.shade_id=bud_shades.shade_id', 'left');
        $this->db->join('bud_users', 'bud_sh_packing.prepared_by=bud_users.ID', 'left');
        $this->db->join('bud_suppliers', 'bud_sh_packing.supplier_id=bud_suppliers.sup_id', 'left');
        $this->db->where('bud_sh_packing.box_id', $box_id);
        return $this->db->get('bud_sh_packing')->row();
    }
    function getPackingBoxes($filter = array())
    {
        $this->db->select('bud_yt_packing_boxes.*,bud_items.*,bud_yt_yarndeniers.denier_tech,bud_yt_poydeniers.denier_name as poy_denier_name,bud_shades.*');
        $this->db->select('bud_poy_lots.poy_lot_no, bud_poy_lots.poy_lot_name');
        $this->db->select('bud_stock_rooms.stock_room_name');
        $this->db->from('bud_yt_packing_boxes');
        $this->db->join('bud_items', 'bud_items.item_id = bud_yt_packing_boxes.item_id', 'left');
        $this->db->join('bud_yt_yarndeniers', 'bud_yt_yarndeniers.denier_id = bud_yt_packing_boxes.yarn_denier', 'left');
        $this->db->join('bud_yt_poydeniers', 'bud_yt_poydeniers.denier_id = bud_yt_packing_boxes.poy_denier', 'left');
        $this->db->join('bud_shades', 'bud_shades.shade_id = bud_yt_packing_boxes.shade_no', 'left');
        $this->db->join('bud_stock_rooms', 'bud_yt_packing_boxes.stock_room_id = bud_stock_rooms.stock_room_id', 'left');

        $this->db->join('bud_poy_lots', 'bud_yt_packing_boxes.poy_lot_id = bud_poy_lots.poy_lot_id', 'left');

        $this->db->where('bud_yt_packing_boxes.delivery_status', 1);
        $this->db->where('bud_yt_packing_boxes.is_deleted', 0);
        $this->db->where('bud_yt_packing_boxes.delivered_in_group', 0);

        if (count($filter) > 0) {
            if (isset($filter['stock_room_id'])) {
                $this->db->where('bud_yt_packing_boxes.stock_room_id', $filter['stock_room_id']);
            }
        }
        $query = $this->db->get();
        return $query->result();
    }

    function getPackingBox($box_id)
    {
        $this->db->select('bud_yt_packing_boxes.*,bud_items.*,bud_yt_yarndeniers.denier_tech,bud_yt_poydeniers.denier_name as poy_denier_name,bud_shades.*');
        $this->db->select('bud_poy_lots.poy_lot_no, bud_poy_lots.poy_lot_name');
        $this->db->select('bud_stock_rooms.stock_room_name');
        $this->db->from('bud_yt_packing_boxes');
        $this->db->join('bud_items', 'bud_items.item_id = bud_yt_packing_boxes.item_id', 'left');
        $this->db->join('bud_yt_yarndeniers', 'bud_yt_yarndeniers.denier_id = bud_yt_packing_boxes.yarn_denier', 'left');
        $this->db->join('bud_yt_poydeniers', 'bud_yt_poydeniers.denier_id = bud_yt_packing_boxes.poy_denier', 'left');
        $this->db->join('bud_shades', 'bud_shades.shade_id = bud_yt_packing_boxes.shade_no', 'left');
        $this->db->join('bud_stock_rooms', 'bud_yt_packing_boxes.stock_room_id = bud_stock_rooms.stock_room_id', 'left');

        $this->db->join('bud_poy_lots', 'bud_yt_packing_boxes.poy_lot_id = bud_poy_lots.poy_lot_id', 'left');

        $this->db->where('bud_yt_packing_boxes.box_id', $box_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_stocktransfer($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->get('bud_sh_stocktransfer');
        return $result->row();
    }

    public function save_stocktransfer($save)
    {
        $id = false;
        if ($save['id']) {
            $this->db->where('id', $save['id']);
            $this->db->update('bud_sh_stocktransfer', $save);
            $id = $save['id'];
        } else {
            $this->db->insert('bud_sh_stocktransfer', $save);
            $id = $this->db->insert_id();
        }

        if ($id) {
            $stocktransfer = $this->get_stocktransfer($id);
            if ($stocktransfer) {
                $update_data = array();
                $selected_boxes = explode(",", $stocktransfer->selected_boxes);
                if (count($selected_boxes) > 0) {
                    foreach ($selected_boxes as $box_id) {
                        $box['box_id'] = $box_id;
                        $box['predelivery_status'] = 1;
                        $box['delivery_status'] = 1;
                        $box['delivered_in_group'] = 1;

                        $update_data[] = $box;
                    }
                }

                $this->db->update_batch('bud_yt_packing_boxes', $update_data, 'box_id');
            }
        }
    }

    public function get_stocktransfer_list($filter = array(), $transfer_status = false)
    {
        // print_r($filter);
        $is_admin = $this->m_users->is_admin($this->session->userdata('user_id'));

        $this->db->select('bud_sh_stocktransfer.*');
        $this->db->select('from_concern.concern_name as from_concern_name');
        $this->db->select('to_concern.concern_name as to_concern_name');
        $this->db->select('from_stock_room.stock_room_name as from_stock_room_name');
        $this->db->select('to_stock_room.stock_room_name as to_stock_room_name');
        $this->db->select('from_user.display_name as from_staff_name');
        $this->db->select('to_user.display_name as to_staff_name');
        $this->db->select('accepted.display_name as accepted_name');

        $this->db->join('bud_concern_master from_concern', 'bud_sh_stocktransfer.from_concern_id=from_concern.concern_id', 'left');
        $this->db->join('bud_concern_master to_concern', 'bud_sh_stocktransfer.to_concern_id=to_concern.concern_id', 'left');

        $this->db->join('bud_stock_rooms from_stock_room', 'bud_sh_stocktransfer.from_stock_room_id=from_stock_room.stock_room_id', 'left');
        $this->db->join('bud_stock_rooms to_stock_room', 'bud_sh_stocktransfer.to_stock_room_id=to_stock_room.stock_room_id', 'left');

        $this->db->join('bud_users from_user', 'bud_sh_stocktransfer.from_user_id=from_user.ID', 'left');
        $this->db->join('bud_users to_user', 'bud_sh_stocktransfer.to_user_id=to_user.ID', 'left');
        $this->db->join('bud_users accepted', 'bud_sh_stocktransfer.accepted_by=accepted.ID', 'left');

        if (!$is_admin) {
            if (count($filter) > 0) {
                if (isset($filter['transfer_status'])) {
                    $this->db->where('bud_sh_stocktransfer.transfer_status', $filter['transfer_status']);
                }
                if (isset($filter['to_user_id'])) {
                    $to_user_id = $filter['to_user_id'];
                    $from_user_id = $filter['from_user_id'];
                    $where = "(FIND_IN_SET('$to_user_id',bud_sh_stocktransfer.to_user_id) > 0 or bud_sh_stocktransfer.from_user_id='$to_user_id')";
                    $this->db->where($where, null, false);
                }
            }
        } else {
            if (count($filter) > 0) {
                if (isset($filter['transfer_status'])) {
                    $this->db->where('bud_sh_stocktransfer.transfer_status', $filter['transfer_status']);
                }
            }
        }
        $result = $this->db->get('bud_sh_stocktransfer');
        return $result->result();
    }

    public function get_stocktransfer_dc($id)
    {
        $this->db->select('bud_sh_stocktransfer.*');
        $this->db->select('from_concern.concern_name as from_concern_name');
        $this->db->select('from_concern.concern_address as from_concern_addr');
        $this->db->select('from_concern.concern_tin as from_concern_tin');
        $this->db->select('from_concern.concern_gst as from_concern_gst');
        $this->db->select('to_concern.concern_name as to_concern_name');
        $this->db->select('to_concern.concern_address as to_concern_addr');
        $this->db->select('to_concern.concern_tin as to_concern_tin');
        $this->db->select('to_concern.concern_gst as to_concern_gst');
        $this->db->select('from_stock_room.stock_room_name as from_stock_room_name');
        $this->db->select('to_stock_room.stock_room_name as to_stock_room_name');
        $this->db->select('from_user.display_name as from_staff_name');
        $this->db->select('to_user.display_name as to_staff_name');

        $this->db->join('bud_concern_master from_concern', 'bud_sh_stocktransfer.from_concern_id=from_concern.concern_id', 'left');
        $this->db->join('bud_concern_master to_concern', 'bud_sh_stocktransfer.to_concern_id=to_concern.concern_id', 'left');

        $this->db->join('bud_stock_rooms from_stock_room', 'bud_sh_stocktransfer.from_stock_room_id=from_stock_room.stock_room_id', 'left');
        $this->db->join('bud_stock_rooms to_stock_room', 'bud_sh_stocktransfer.to_stock_room_id=to_stock_room.stock_room_id', 'left');

        $this->db->join('bud_users from_user', 'bud_sh_stocktransfer.from_user_id=from_user.ID', 'left');
        $this->db->join('bud_users to_user', 'bud_sh_stocktransfer.to_user_id=to_user.ID', 'left');

        $this->db->where('bud_sh_stocktransfer.id', $id);

        $result = $this->db->get('bud_sh_stocktransfer');
        return $result->row();
    }

    public function remove_stocktransfer($id = '')
    {
        if (!empty($id)) {
            $stocktransfer = $this->get_stocktransfer($id);
            if ($stocktransfer) {
                $update_data = array();
                $selected_boxes = explode(",", $stocktransfer->selected_boxes);
                if (count($selected_boxes) > 0) {
                    foreach ($selected_boxes as $box_id) {
                        $box['box_id'] = $box_id;
                        $box['predelivery_status'] = 1;
                        $box['delivery_status'] = 1;
                        $box['delivered_in_group'] = 0;

                        $update_data[] = $box;
                    }
                }

                $this->db->update_batch('bud_yt_packing_boxes', $update_data, 'box_id');
            }

            // Delete Record
            $this->db->where('id', $id);
            $this->db->delete('bud_sh_stocktransfer');
        }
    }
    function get_stdc_id($box_id)
    {
        $this->db->select("id");
        $this->db->like('selected_boxes', $box_id);
        $result = $this->db->get('bud_sh_stocktransfer')->result_array();
        return ($result) ? $result[0]['id'] : '';
    }
}
