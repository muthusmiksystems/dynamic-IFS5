<?php
class Delivery_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_next_dc_no($concern_id = '')
    {
        $next_dc_no = 1;
        $this->db->select_max('dc_no');
        if (!empty($concern_id)) {
            $this->db->where('concern_id', $concern_id);
        }
        $this->db->where('bud_sh_delivery.delivery_is_deleted', 1); //ER-07-18#-3
        $result = $this->db->get('bud_sh_delivery')->row();
        $next_dc_no += $result->dc_no;
        return $next_dc_no;
    }

    public function save_delivery($save, $cart_items, $predc_items = array())
    {
        $save['delivery_lt_edtd_by'] = $this->session->userdata('user_id'); //ER-07-18#-3
        $save['delivery_is_deleted'] = 1; //ER-07-18#-3
        $delivery_id = false;
        if ($save['delivery_id']) {
            $this->db->where('delivery_id', $save['delivery_id']);
            $this->db->update('bud_sh_delivery', $save);
            $delivery_id = $save['delivery_id'];
        } else {
            $this->db->insert('bud_sh_delivery', $save);
            $delivery_id = $this->db->insert_id();
        }

        if ($delivery_id) {

            $this->save_dc_items($delivery_id, $cart_items);

            $this->update_predc_status(array('p_delivery_id' => $save['p_delivery_id'], 'p_delivery_status' => 1));
        }

        return $delivery_id;
    }

    public function save_dc_items($delivery_id, $cart_items)
    {
        $delivery_items = array();
        if (sizeof($cart_items) > 0) {
            foreach ($cart_items as $box) {
                $item['box_id'] = $box->box_id;
                $item['box_prefix'] = $box->box_prefix;
                $item['box_no'] = $box->box_no;
                $item['item_group_id'] = $box->item_group_id;
                $item['item_id'] = $box->item_id;
                $item['shade_id'] = $box->shade_id;
                $item['lot_no'] = $box->lot_no;
                $item['no_boxes'] = $box->no_boxes;
                $item['no_cones'] = $box->no_cones;
                $item['gr_weight'] = $box->gr_weight;
                $item['nt_weight'] = $box->nt_weight;
                $item['packed_on'] = $box->packed_on;
                $item['prepared_by'] = $box->prepared_by;
                $item['supplier_id'] = $box->supplier_id;
                $item['supplier_dc_no'] = $box->supplier_dc_no;
                $item['uom_id'] = $box->uom_id;
                $item['stock_room_id'] = $box->stock_room_id;
                $item['remarks'] = $box->remarks;
                $item['is_deleted'] = $box->is_deleted;
                $item['deleted_by'] = $box->deleted_by;
                $item['deleted_on'] = $box->deleted_on;
                $item['deleted_remarks'] = $box->deleted_remarks;
                $item['delivery_id'] = $delivery_id;
                $item['delivery_qty'] = $box->delivery_qty;
                $item['delivery_is_deleted'] = 1; //ER-07-18#-3
                $delivery_items[] = $item;
            }

            $this->db->insert_batch('bud_sh_delivery_items', $delivery_items);
        }
    }

    public function update_predc_status($save)
    {
        if ($save['p_delivery_id']) {
            $this->db->where('p_delivery_id', $save['p_delivery_id']);
            $this->db->update('bud_sh_predelivery', $save);
            $p_delivery_id = $save['p_delivery_id'];
        }
    }
    public function get_dc_row($delivery_id)
    {
        $this->db->where('delivery_id', $delivery_id);
        $this->db->where('bud_sh_delivery.delivery_is_deleted', 1); //ER-07-18#-3
        return $this->db->get('bud_sh_delivery')->row();
    }
    public function get_delivery($delivery_id)
    {
        $this->db->select('bud_sh_delivery.*');
        $this->db->select('bud_concern_master.*');
        $this->db->select('bud_customers.cust_name,bud_customers.cust_address,bud_customers.cust_tinno,bud_customers.cust_gst,bud_customers.cust_city'); //dc error correction
        $this->db->select('del_to.cust_name as del_cust_name,del_to.cust_address as del_cust_address,del_to.cust_tinno as del_cust_tinno,del_to.cust_cst as del_cust_cst,del_to.cust_cst as del_cust_city');
        $this->db->join('bud_concern_master', 'bud_sh_delivery.concern_id=bud_concern_master.concern_id', 'left');
        $this->db->join('bud_customers', 'bud_sh_delivery.customer_id=bud_customers.cust_id', 'left');
        $this->db->join('bud_customers del_to', 'bud_sh_delivery.delivery_to=del_to.cust_id', 'left');
        $this->db->where('bud_sh_delivery.delivery_id', $delivery_id);
        $this->db->where('bud_sh_delivery.delivery_is_deleted', 1); //ER-07-18#-3
        return $this->db->get('bud_sh_delivery')->row();
    }
    public function get_delivery_list($pending = '')
    {
        $this->db->select('bud_sh_delivery.*');
        $this->db->select('bud_concern_master.*');
        $this->db->select('bud_customers.cust_name,bud_customers.cust_address,bud_customers.cust_tinno,bud_customers.cust_cst,bud_customers.cust_city');
        $this->db->select('del_to.cust_name as del_cust_name,del_to.cust_address as del_cust_address,del_to.cust_tinno as del_cust_tinno,del_to.cust_cst as del_cust_cst,del_to.cust_cst as del_cust_city');
        $this->db->join('bud_concern_master', 'bud_sh_delivery.concern_id=bud_concern_master.concern_id', 'left');
        $this->db->join('bud_customers', 'bud_sh_delivery.customer_id=bud_customers.cust_id', 'left');
        $this->db->join('bud_customers del_to', 'bud_sh_delivery.delivery_to=del_to.cust_id', 'left');
        if (!empty($pending)) {
            $this->db->where('bud_sh_delivery.delivery_status', 0);
        }
        $this->db->where('bud_sh_delivery.delivery_is_deleted', 1); //ER-07-18#-3
        $this->db->group_by('bud_sh_delivery.delivery_id');
        $this->db->order_by('bud_sh_delivery.delivery_id', 'desc');
        return $this->db->get('bud_sh_delivery')->result();
    }
    public function get_delivery_items($delivery_id = '', $item_id = null, $is_deleted = 1) //ER-07-18#-4
    {
        $this->db->select('bud_sh_delivery_items.*');
        $this->db->select('bud_itemgroups.group_name');
        $this->db->select('bud_items.*'); //dc error correction
        $this->db->select('bud_users.user_nicename');
        $this->db->select('bud_shades.shade_name, bud_shades.shade_code, bud_shades.category_id');
        $this->db->select('bud_suppliers.sup_name');
        $this->db->select('bud_stock_rooms.stock_room_name');
        $this->db->join('bud_itemgroups', 'bud_sh_delivery_items.item_group_id=bud_itemgroups.group_id', 'left');
        $this->db->join('bud_items', 'bud_sh_delivery_items.item_id=bud_items.item_id', 'left');
        $this->db->join('bud_shades', 'bud_sh_delivery_items.shade_id=bud_shades.shade_id', 'left');
        $this->db->join('bud_users', 'bud_sh_delivery_items.prepared_by=bud_users.ID', 'left');
        $this->db->join('bud_suppliers', 'bud_sh_delivery_items.supplier_id=bud_suppliers.sup_id', 'left');
        $this->db->join('bud_stock_rooms', 'bud_sh_delivery_items.stock_room_id=bud_stock_rooms.stock_room_id', 'left');
        $this->db->order_by('bud_sh_delivery_items.box_id', 'asc');
        if (!empty($delivery_id)) {
            $this->db->where('bud_sh_delivery_items.delivery_id', $delivery_id);
        }
        if (!empty($item_id)) //ER-07-18#-4
        {
            $this->db->where('bud_sh_delivery_items.item_id', $item_id);
        }
        $this->db->where('bud_sh_delivery_items.delivery_is_deleted', $is_deleted); //ER-07-18#-3//ER-08-18#-28
        return $this->db->get('bud_sh_delivery_items')->result();
    }

    public function get_delivery_boxes($delivery_id = '', $box_id = '') //ER-08-18#-37
    {
        $this->db->select('bud_sh_delivery_items.*');
        $this->db->select('bud_sh_delivery.*');
        $this->db->select('bud_itemgroups.group_name');
        $this->db->select('bud_items.item_name');
        $this->db->select('bud_users.user_nicename');
        $this->db->select('bud_shades.shade_name, bud_shades.shade_code');
        $this->db->select('bud_suppliers.sup_name');
        $this->db->select('bud_stock_rooms.stock_room_name');
        $this->db->join('bud_sh_delivery', 'bud_sh_delivery_items.delivery_id=bud_sh_delivery.delivery_id', 'left');
        $this->db->join('bud_itemgroups', 'bud_sh_delivery_items.item_group_id=bud_itemgroups.group_id', 'left');
        $this->db->join('bud_items', 'bud_sh_delivery_items.item_id=bud_items.item_id', 'left');
        $this->db->join('bud_shades', 'bud_sh_delivery_items.shade_id=bud_shades.shade_id', 'left');
        $this->db->join('bud_users', 'bud_sh_delivery_items.prepared_by=bud_users.ID', 'left');
        $this->db->join('bud_suppliers', 'bud_sh_delivery_items.supplier_id=bud_suppliers.sup_id', 'left');
        $this->db->join('bud_stock_rooms', 'bud_sh_delivery_items.stock_room_id=bud_stock_rooms.stock_room_id', 'left');
        $this->db->order_by('bud_sh_delivery.delivery_id', 'desc');
        if (!empty($delivery_id)) {
            $this->db->where('bud_sh_delivery_items.delivery_id', $delivery_id);
        }
        if (!empty($box_id)) //ER-08-18#-37
        {
            $this->db->where('bud_sh_delivery_items.box_id', $box_id);
        }
        $this->db->where('bud_sh_delivery_items.delivery_is_deleted', 1); //ER-07-18#-3
        return $this->db->get('bud_sh_delivery_items')->result();
    }

    //box status register shop
    function get_dc_id($box_id)
    {
        $this->db->select("delivery_id,delivery_qty");
        $this->db->where('box_id', $box_id);
        $this->db->where('bud_sh_delivery_items.delivery_is_deleted', 1); //ER-07-18#-3
        $results = $this->db->get('bud_sh_delivery_items')->result_array();
        return $results;
    }
    //box status register shop
    public function update_delete_status_delivery_sh($delivery_id, $remarks) //ER-07-18#-3
    {
        $data = array(
            'delivery_is_deleted' => '0',
            'remarks' => $remarks,
            'delivery_lt_edtd_by' => $this->session->userdata('user_id'),
            'delivery_lt_edtd_time' => date('Y-m-d H:i:s')
        );
        $this->db->where('delivery_id', $delivery_id);
        $result = $this->db->update('bud_sh_delivery', $data);
        if ($result) {
            $updateData = array(
                'delivery_is_deleted' => 0
            );
            $result = $this->m_purchase->updateDatas('bud_sh_delivery_items', 'delivery_id', $delivery_id, $updateData);
        }
        if ($result) {
            $p_delivery_id = $this->m_masters->getmasterIDvalue('bud_sh_delivery', 'delivery_id', $delivery_id, 'p_delivery_id');
            $updateData = array(
                'p_delivery_status' => 0
            );
            $result = $this->m_purchase->updateDatas('bud_sh_predelivery', 'p_delivery_id', $p_delivery_id, $updateData);
        }
        return $result;
    }
    //ER-08-18#-37
    function get_delivery_nos($customer_id = '') //ER-08-18#-37
    {
        $this->db->select('dc_no,delivery_id');
        if (!empty($customer_id)) {
            $this->db->where('customer_id', $customer_id);
        }
        $this->db->where('bud_sh_delivery.delivery_is_deleted', 1);
        //$this->d>b->where('bud_sh_delivery.delivery_status', 0);//ER-08-18#-42
        $this->db->order_by('delivery_id', 'desc');
        return $this->db->get('bud_sh_delivery')->result();
    }
    public function get_rdc_cart_temp_items($cart_user_id = '') //ER-08-18#-37
    {
        $this->db->select('dyn_redel_items_temp.*');
        $this->db->select('bud_itemgroups.group_name');
        $this->db->select('bud_items.item_name');
        $this->db->select('bud_users.user_nicename');
        $this->db->select('bud_shades.shade_name, bud_shades.shade_code, bud_shades.category_id');
        $this->db->select('bud_suppliers.sup_name');
        $this->db->select('bud_stock_rooms.stock_room_name');
        $this->db->join('bud_itemgroups', 'dyn_redel_items_temp.item_group_id=bud_itemgroups.group_id', 'left');
        $this->db->join('bud_items', 'dyn_redel_items_temp.item_id=bud_items.item_id', 'left');
        $this->db->join('bud_shades', 'dyn_redel_items_temp.shade_id=bud_shades.shade_id', 'left');
        $this->db->join('bud_users', 'dyn_redel_items_temp.prepared_by=bud_users.ID', 'left');
        $this->db->join('bud_suppliers', 'dyn_redel_items_temp.supplier_id=bud_suppliers.sup_id', 'left');
        $this->db->join('bud_stock_rooms', 'dyn_redel_items_temp.stock_room_id=bud_stock_rooms.stock_room_id', 'left');
        $this->db->order_by('dyn_redel_items_temp.box_id', 'asc');
        if (!empty($cart_user_id)) {
            $this->db->where('dyn_redel_items_temp.cart_user_id', $cart_user_id);
        }
        return $this->db->get('dyn_redel_items_temp')->result();
    }
    public function rdc_add_to_cart($save) //ER-08-18#-37
    {
        if ($save['row_id']) {
            $this->db->where('row_id', $save['row_id']);
            $this->db->update('dyn_redel_items_temp', $save);
            return $save['row_id'];
        } else {
            if ($this->rdc_check_item_exist($save['box_prefix'], $save['box_no'])) {
                $this->db->insert('dyn_redel_items_temp', $save);
                return $this->db->insert_id();
            }
        }
    }
    public function rdc_check_item_exist($box_prefix, $box_no) //ER-08-18#-37
    {
        $this->db->where("box_prefix", $box_prefix);
        $this->db->where("box_no", $box_no);
        $query = $this->db->get("dyn_redel_items_temp");
        if ($query->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }
    public function rdc_remove_to_cart($row_id) //ER-08-18#-37
    {
        $this->db->where('row_id', $row_id);
        $this->db->delete('dyn_redel_items_temp');
    }
    public function rdc_remove_all_cart() //ER-08-18#-37
    {
        $this->db->where('cart_user_id', $this->session->userdata('user_id'));
        $this->db->delete('dyn_redel_items_temp');
    }
    public function save_rdc($save, $cart_items, $rdc_items = array(), $stock_room_id) //ER-08-18#-37
    {
        $row_id = false;
        $rdc_boxes = array();
        $this->db->insert('dyn_sh_rdc', $save);
        $row_id = $this->db->insert_id();
        if (sizeof($cart_items) > 0) {
            foreach ($cart_items as $box) {
                $item['box_id'] = $box->box_id;
                $item['delivery_id'] = $save['delivery_id'];
                $item['delivery_qty'] = $box->delivery_qty;
                $item['return_qty'] = $box->return_qty;
                $item['return_cones'] = $box->return_cones; //ER-08-18#-42
                $this->db->insert('dyn_redel_items', $item);
                $row_id = $this->db->insert_id();
                $box_prefix = ($box->box_prefix == 'TH') ? 'THSR' : 'SR';
                $this->db->select('box_id,gr_weight,nt_weight,no_cones,box_prefix,box_no');
                $this->db->where('item_id', $box->item_id);
                $this->db->where('shade_id', $box->shade_id);
                $this->db->where('box_prefix', $box_prefix);
                $pack_boxes = $this->db->get("bud_sh_packing")->result();
                if ($pack_boxes) {
                    foreach ($pack_boxes as $pack_box) {
                        //$save_box['gr_weight']=$pack_box->gr_weight+$box->gr_weight;
                        $save_box['gr_weight'] = $pack_box->gr_weight + $box->return_qty;
                        $save_box['nt_weight'] = $pack_box->nt_weight + $box->return_qty;
                        $save_box['no_cones'] = $pack_box->no_cones + $box->return_cones; //ER-08-18#-42
                        $this->db->where('box_id', $pack_box->box_id);
                        $row_id = $this->db->update('bud_sh_packing', $save_box);
                        $rdc_boxes[$row_id] = $pack_box->box_prefix . $pack_box->box_no; //ER-08-18#-43
                    }
                } else {
                    $save_box['box_prefix'] = $box_prefix;
                    $save_box['box_no'] = $this->Packing_model->getNextBoxNo($box_prefix);
                    $save_box['shade_id'] = $box->shade_id;
                    $save_box['item_group_id'] = $box->item_group_id;
                    $save_box['item_id'] = $box->item_id;
                    $save_box['lot_no'] = $box->lot_no;
                    $save_box['no_boxes'] = $box->no_boxes;
                    $save_box['no_cones'] = $box->return_cones; //ER-08-18#-42
                    $save_box['gr_weight'] = $box->return_qty;
                    $save_box['nt_weight'] = $box->return_qty;
                    $save_box['packed_on'] = date('Y-m-d H:i:s');
                    $save_box['prepared_by'] = $this->session->userdata('user_id');
                    $save_box['supplier_id'] = $box->supplier_id;
                    $save_box['supplier_dc_no'] = $box->supplier_dc_no;
                    $save_box['uom_id'] = $box->uom_id;
                    $save_box['stock_room_id'] = $stock_room_id;
                    $save_box['remarks'] = 'Returned Box';
                    $save_box['is_deleted'] = $box->is_deleted;
                    $save_box['deleted_by'] = $box->deleted_by;
                    $save_box['deleted_on'] = $box->deleted_on;
                    $save_box['deleted_remarks'] = $box->deleted_remarks;
                    $this->db->insert('bud_sh_packing', $save_box);
                    $row_id = $this->db->insert_id();
                    $rdc_boxes[$row_id] = $box_prefix . $save_box['box_no']; //ER-08-18#-42
                }
            }
        }
        if ($row_id) {
            $this->db->truncate('dyn_redel_items_temp');
        }
        return implode(',', $rdc_boxes);
    }

    //ER-08-18#-37
    public function get_rdc_report($filter = array()) //ER-08-18#-47
    {
        $this->db->select('dyn_redel_items .*,dyn_sh_rdc.*,');
        $this->db->select('bud_customers.cust_name,bud_shades.shade_name,bud_shades.shade_code,bud_sh_delivery_items.*,bud_items.item_name,bud_users.display_name,bud_sh_delivery.delivery_id');
        $this->db->join('dyn_sh_rdc', 'dyn_redel_items.delivery_id=dyn_sh_rdc.delivery_id', 'left');

        $this->db->join('bud_users', 'dyn_sh_rdc.entered_by = bud_users.ID', 'left');
        $this->db->join('bud_sh_delivery', 'bud_sh_delivery.delivery_id=dyn_sh_rdc.delivery_id', 'left');
        $this->db->join('bud_sh_delivery_items', 'bud_sh_delivery_items.delivery_id = dyn_redel_items.delivery_id AND bud_sh_delivery_items.box_id=dyn_redel_items.box_id');
        $this->db->join('bud_items', 'bud_sh_delivery_items.item_id=bud_items.item_id', 'left');
        $this->db->join('bud_shades', 'bud_sh_delivery_items.shade_id=bud_shades.shade_id', 'left');
        $this->db->join('bud_customers', 'bud_sh_delivery.customer_id=bud_customers.cust_id', 'left');
        if ($filter['cust_id']) {
            $this->db->where('customer_id', $filter['cust_id']);
        }
        if ($filter['from_date']) {
            $this->db->where('entered_time >=', $filter['from_date']);
        }
        if ($filter['to_date']) {
            $this->db->where('entered_time <=', $filter['to_date']);
        }
        if ($filter['item_id']) {
            $this->db->where('item_id', $filter['item_id']);
        }
        return $this->db->get('dyn_redel_items')->result();
    }
    function get_rdc_box_no_sh($box_prefix, $item_id, $shade_id)
    {
        $box_prefix = ($box_prefix == 'TH') ? 'THSR' : 'SR';
        $this->db->select('box_no,box_prefix');
        $this->db->where('item_id', $item_id);
        $this->db->where('shade_id', $shade_id);
        $this->db->where('box_prefix', $box_prefix);
        $result = $this->db->get('bud_sh_packing')->result();
        foreach ($result as $value) {
            $box_no = $value->box_prefix . $value->box_no;
        }
        return $box_no;
    }
}
