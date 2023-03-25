<?php
class Predelivery_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_next_pre_dc_no($p_concern_id = 2)
    {
        $next_p_dc_no = 1;
        $this->db->select_max('p_dc_no');
        if (!empty($p_concern_id)) {
            $this->db->where('p_concern_id', $p_concern_id);
        }
        $this->db->where('bud_sh_predelivery.p_delivery_is_deleted', 1); //ER-07-18#-1
        $result = $this->db->get('bud_sh_predelivery')->row();
        $next_p_dc_no += $result->p_dc_no;
        return $next_p_dc_no;
    }

    public function add_to_cart($save)
    {
        if ($save['row_id']) {
            $this->db->where('row_id', $save['row_id']);
            $this->db->update('bud_sh_predel_items_temp', $save);
            return $save['row_id'];
        } else {
            if ($this->check_item_exist($save['box_prefix'], $save['box_no'])) {
                $this->db->insert('bud_sh_predel_items_temp', $save);
                return $this->db->insert_id();
            }
        }
    }

    public function check_item_exist($box_prefix, $box_no)
    {
        $this->db->where("box_prefix", $box_prefix);
        $this->db->where("box_no", $box_no);
        $query = $this->db->get("bud_sh_predel_items_temp");
        if ($query->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function remove_to_cart($row_id)
    {
        $this->db->where('row_id', $row_id);
        $this->db->delete('bud_sh_predel_items_temp');
    }

    public function remove_all_cart()
    {
        $this->db->where('cart_user_id', $this->session->userdata('user_id'));
        $this->db->delete('bud_sh_predel_items_temp');
    }

    public function get_cart_temp_items($cart_user_id = '')
    {
        $this->db->select('bud_sh_predel_items_temp.*');
        $this->db->select('bud_itemgroups.group_name');
        $this->db->select('bud_items.item_name');
        $this->db->select('bud_users.user_nicename');
        $this->db->select('bud_shades.shade_name, bud_shades.shade_code, bud_shades.category_id');
        $this->db->select('bud_suppliers.sup_name');
        $this->db->select('bud_stock_rooms.stock_room_name');
        $this->db->join('bud_itemgroups', 'bud_sh_predel_items_temp.item_group_id=bud_itemgroups.group_id', 'left');
        $this->db->join('bud_items', 'bud_sh_predel_items_temp.item_id=bud_items.item_id', 'left');
        $this->db->join('bud_shades', 'bud_sh_predel_items_temp.shade_id=bud_shades.shade_id', 'left');
        $this->db->join('bud_users', 'bud_sh_predel_items_temp.prepared_by=bud_users.ID', 'left');
        $this->db->join('bud_suppliers', 'bud_sh_predel_items_temp.supplier_id=bud_suppliers.sup_id', 'left');
        $this->db->join('bud_stock_rooms', 'bud_sh_predel_items_temp.stock_room_id=bud_stock_rooms.stock_room_id', 'left');
        $this->db->order_by('bud_sh_predel_items_temp.box_id', 'asc');
        if (!empty($cart_user_id)) {
            $this->db->where('bud_sh_predel_items_temp.cart_user_id', $cart_user_id);
        }
        return $this->db->get('bud_sh_predel_items_temp')->result();
    }

    public function get_shop_packings($is_deleted = false, $shop_box_only = true, $filter = array())
    {
        $this->db->select('bud_sh_packing.*');
        $this->db->select('bud_itemgroups.group_name');
        $this->db->select('bud_items.item_name');
        $this->db->select('bud_users.user_nicename');
        $this->db->select('bud_shades.shade_name, bud_shades.shade_code, bud_shades.color_code');
        $this->db->select('bud_suppliers.sup_name');
        $this->db->select('bud_stock_rooms.stock_room_name');

        $this->db->select('SUM(predel_items_temp.delivery_qty) AS tot_predc_temp_qty', FALSE);
        $this->db->select('SUM(predel_items.delivery_qty) AS tot_predc_qty', FALSE);

        $this->db->select('SUM(bud_sh_delivery_items.delivery_qty) AS tot_dc_qty', FALSE);
        $this->db->select('SUM(bud_sh_quotation_items.delivery_qty) AS tot_quote_qty', FALSE);
        // $this->db->select('SUM(predel_items.delivery_qty + predel_items_temp.delivery_qty) AS tot_delivery_qty', FALSE);

        // $this->db->select('SUM(predel_items_temp.delivery_qty) + SUM(predel_items.delivery_qty) as tot_delivery_qty', FALSE);
        // $this->db->select('SUM(predel_items_temp.delivery_qty + predel_items.delivery_qty) as tot_delivery_qty', FALSE);

        $this->db->join('bud_itemgroups', 'bud_sh_packing.item_group_id=bud_itemgroups.group_id', 'left');
        $this->db->join('bud_items', 'bud_sh_packing.item_id=bud_items.item_id', 'left');
        $this->db->join('bud_shades', 'bud_sh_packing.shade_id=bud_shades.shade_id', 'left');
        $this->db->join('bud_users', 'bud_sh_packing.prepared_by=bud_users.ID', 'left');
        $this->db->join('bud_suppliers', 'bud_sh_packing.supplier_id=bud_suppliers.sup_id', 'left');
        $this->db->join('bud_stock_rooms', 'bud_sh_packing.stock_room_id=bud_stock_rooms.stock_room_id', 'left');

        $this->db->join('bud_sh_predel_items_temp predel_items_temp', 'bud_sh_packing.box_id = predel_items_temp.box_id', 'left');
        $this->db->join('bud_sh_predel_items predel_items', 'bud_sh_packing.box_id = predel_items.box_id', 'left');

        $this->db->join('bud_sh_delivery_items', 'bud_sh_packing.box_id = bud_sh_delivery_items.box_id', 'left');

        $this->db->join('bud_sh_quotation_items', 'bud_sh_packing.box_id = bud_sh_quotation_items.box_id', 'left');

        if (!empty($is_deleted)) {
            $this->db->where('bud_sh_packing.is_deleted', $is_deleted);
        }
        if (!empty($shop_box_only)) {
            $this->db->where('bud_sh_packing.box_prefix', 'SH');
        }

        $this->db->where('bud_sh_packing.is_deleted', 0);
        if (count($filter) > 0) {
            if (isset($filter['item_id']) && !empty($filter['item_id'])) {
                $this->db->where('bud_sh_packing.item_id', $filter['item_id']);
            }
            if (isset($filter['shade_id']) && !empty($filter['shade_id'])) {
                $this->db->where('bud_sh_packing.shade_id', $filter['shade_id']);
            }
            if (isset($filter['stock_room_id']) && !empty($filter['stock_room_id'])) {
                $this->db->where('bud_sh_packing.stock_room_id', $filter['stock_room_id']);
            }
            if (isset($filter['item_group_id']) && !empty($filter['item_group_id'])) {
                $this->db->where('bud_sh_packing.item_group_id', $filter['item_group_id']);
            }
        }

        $this->db->group_by('bud_sh_packing.box_id');
        // $this->db->order_by('bud_sh_packing.box_id', 'asc');
        $this->db->order_by('tot_predc_temp_qty', 'desc');
        return $this->db->get('bud_sh_packing')->result();
        //echo $this->db->last_query(); die;
    }

    public function get_shop_box($box_id)
    {
        $this->db->select('bud_sh_packing.*');
        $this->db->select('bud_itemgroups.group_name');
        $this->db->select('bud_items.item_name');
        $this->db->select('bud_users.user_nicename');
        $this->db->select('bud_shades.shade_name, bud_shades.shade_code');
        $this->db->select('bud_suppliers.sup_name');
        $this->db->select('SUM(bud_sh_predel_items_temp.delivery_qty) AS tot_predc_temp_qty', FALSE);
        $this->db->select('SUM(bud_sh_predel_items.delivery_qty) AS tot_predc_qty', FALSE);
        $this->db->join('bud_itemgroups', 'bud_sh_packing.item_group_id=bud_itemgroups.group_id', 'left');
        $this->db->join('bud_items', 'bud_sh_packing.item_id=bud_items.item_id', 'left');
        $this->db->join('bud_shades', 'bud_sh_packing.shade_id=bud_shades.shade_id', 'left');
        $this->db->join('bud_users', 'bud_sh_packing.prepared_by=bud_users.ID', 'left');
        $this->db->join('bud_suppliers', 'bud_sh_packing.supplier_id=bud_suppliers.sup_id', 'left');
        $this->db->join('bud_sh_predel_items_temp', 'bud_sh_packing.box_id = bud_sh_predel_items_temp.box_id', 'left');
        $this->db->join('bud_sh_predel_items', 'bud_sh_packing.box_id = bud_sh_predel_items.box_id', 'left');
        $this->db->where('bud_sh_packing.box_id', $box_id);
        $this->db->group_by('bud_sh_packing.box_id');
        return $this->db->get('bud_sh_packing')->row();
    }
    public function get_customer($cust_id)
    {
        $this->db->where('cust_id', $cust_id);
        $result = $this->db->get('bud_customers');
        return $result->row();
    }
    public function get_customers()
    {
        $this->db->order_by('cust_name', 'asc');
        $result = $this->db->get('bud_customers');
        return $result->result();
    }

    public function save_predc($save, $cart_items, $predc_items = array())
    {
        $p_delivery_id = false;
        $save['p_delivery_is_deleted'] = 1; //ER-07-18#-1
        $save['p_delivery_lt_edtd_by'] = $this->session->userdata('user_id'); //ER-07-18#-1
        if ($save['p_delivery_id']) {
            $this->db->where('p_delivery_id', $save['p_delivery_id']);
            $this->db->update('bud_sh_predelivery', $save);
            $p_delivery_id = $save['p_delivery_id'];
        } else {
            $this->db->insert('bud_sh_predelivery', $save);
            $p_delivery_id = $this->db->insert_id();
        }

        if ($p_delivery_id) {
            if (count($predc_items) > 0) {
                $order_item_ids = array();
                $existing_order_items = $this->get_predc_items($p_delivery_id);
                if (count($existing_order_items) > 0) {
                    foreach ($existing_order_items as $item) {
                        $order_item_ids[] = $item->row_id;
                    }
                }
                if (count($order_item_ids) > 0) {
                    foreach ($order_item_ids as $row_id) {
                        if (!in_array($row_id, $predc_items)) {
                            $this->delete_predc_item($row_id);
                        }
                    }
                }
            }

            $this->save_predc_items($p_delivery_id, $cart_items);
        }

        return $p_delivery_id;
    }

    public function delete_predc_item($row_id)
    {
        $this->db->where('row_id', $row_id);
        $this->db->where('bud_sh_predel_items.p_delivery_is_deleted', 1); //ER-07-18#-1
        $this->db->delete('bud_sh_predel_items');
    }
    public function update_delete_status_predelivery_sh($p_delivery_id, $remarks) //ER-07-18#-1
    {
        $data = array(
            'p_delivery_is_deleted' => '0',
            'remarks' => $remarks,
            'p_delivery_lt_edtd_by' => $this->session->userdata('user_id'),
            'p_delivery_lt_edtd_time' => date('Y-m-d H:i:s')
        );
        $this->db->where('p_delivery_id', $p_delivery_id);
        $result = $this->db->update('bud_sh_predelivery', $data);
        if ($result) {
            $updateData = array(
                'p_delivery_is_deleted' => 0
            );
            $result = $this->m_purchase->updateDatas('bud_sh_predel_items', 'p_delivery_id', $p_delivery_id, $updateData);
        }
        return $result;
    }
    public function save_predc_items($p_delivery_id, $cart_items)
    {
        $predel_items = array();
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
                $item['p_delivery_id'] = $p_delivery_id;
                $item['delivery_qty'] = $box->delivery_qty;

                $predel_items[] = $item;
            }

            $this->db->insert_batch('bud_sh_predel_items', $predel_items);
            $this->empty_cart();
        }
    }

    public function empty_cart()
    {
        $this->db->where('cart_user_id', $this->session->userdata('user_id'));
        $this->db->delete('bud_sh_predel_items_temp');
    }

    public function get_predc_list()
    {
        $this->db->select('bud_sh_predelivery.*');
        $this->db->select('bud_concern_master.*');
        $this->db->select('bud_customers.cust_name,bud_customers.cust_address,bud_customers.cust_tinno,bud_customers.cust_cst,bud_customers.cust_city');
        $this->db->select('del_to.cust_name as del_cust_name,del_to.cust_address as del_cust_address,del_to.cust_tinno as del_cust_tinno,del_to.cust_cst as del_cust_cst,del_to.cust_cst as del_cust_city');
        $this->db->join('bud_concern_master', 'bud_sh_predelivery.p_concern_id=bud_concern_master.concern_id', 'left');
        $this->db->join('bud_customers', 'bud_sh_predelivery.p_customer_id=bud_customers.cust_id', 'left');
        $this->db->join('bud_customers del_to', 'bud_sh_predelivery.p_delivery_to=del_to.cust_id', 'left');
        $this->db->group_by('bud_sh_predelivery.p_delivery_id');
        $this->db->where('bud_sh_predelivery.p_delivery_is_deleted', 1); //ER-07-18#-1
        return $this->db->get('bud_sh_predelivery')->result();
    }

    public function get_predc($p_delivery_id)
    {
        $this->db->select('bud_sh_predelivery.*');
        $this->db->select('bud_concern_master.*');
        $this->db->select('bud_customers.cust_name,bud_customers.cust_address,bud_customers.cust_gst,bud_customers.cust_city'); //ER-07-18#-8
        $this->db->select('del_to.cust_name as del_cust_name,del_to.cust_address as del_cust_address,del_to.cust_gst as del_cust_gst,del_to.cust_city as del_cust_city'); //ER-07-18#-8
        $this->db->join('bud_concern_master', 'bud_sh_predelivery.p_concern_id=bud_concern_master.concern_id', 'left');
        $this->db->join('bud_customers', 'bud_sh_predelivery.p_customer_id=bud_customers.cust_id', 'left');
        $this->db->join('bud_customers del_to', 'bud_sh_predelivery.p_delivery_to=del_to.cust_id', 'left');
        $this->db->where('bud_sh_predelivery.p_delivery_id', $p_delivery_id);
        $this->db->where('bud_sh_predelivery.p_delivery_is_deleted', 1); //ER-07-18#-1
        return $this->db->get('bud_sh_predelivery')->row();
    }

    public function get_predc_items($p_delivery_id = '', $item_id = null, $is_deleted = 1) //ER-09-18#-28
    {
        $this->db->select('bud_sh_predel_items.*');
        $this->db->select('bud_itemgroups.group_name');
        $this->db->select('bud_items.item_name');
        $this->db->select('bud_users.user_nicename');
        $this->db->select('bud_shades.shade_name, bud_shades.shade_code');
        $this->db->select('bud_suppliers.sup_name');
        $this->db->select('bud_stock_rooms.stock_room_name');
        $this->db->join('bud_itemgroups', 'bud_sh_predel_items.item_group_id=bud_itemgroups.group_id', 'left');
        $this->db->join('bud_items', 'bud_sh_predel_items.item_id=bud_items.item_id', 'left');
        $this->db->join('bud_shades', 'bud_sh_predel_items.shade_id=bud_shades.shade_id', 'left');
        $this->db->join('bud_users', 'bud_sh_predel_items.prepared_by=bud_users.ID', 'left');
        $this->db->join('bud_suppliers', 'bud_sh_predel_items.supplier_id=bud_suppliers.sup_id', 'left');
        $this->db->join('bud_stock_rooms', 'bud_sh_predel_items.stock_room_id=bud_stock_rooms.stock_room_id', 'left');
        $this->db->order_by('bud_sh_predel_items.box_id', 'asc');
        if (!empty($p_delivery_id)) {
            $this->db->where('bud_sh_predel_items.p_delivery_id', $p_delivery_id);
        }
        if (!empty($item_id)) {
            $this->db->where('bud_sh_predel_items.item_id', $item_id);
        }
        $this->db->where('bud_sh_predel_items.p_delivery_is_deleted', $is_deleted); //ER-07-18#-1//ER-08-18#-28
        return $this->db->get('bud_sh_predel_items')->result();
    }

    public function get_predc_boxes($p_delivery_id = '')
    {
        $this->db->select('bud_sh_predel_items.*');
        $this->db->select('bud_sh_predelivery.*');
        $this->db->select('bud_itemgroups.group_name');
        $this->db->select('bud_items.item_name');
        $this->db->select('bud_users.user_nicename');
        $this->db->select('bud_shades.shade_name, bud_shades.shade_code');
        $this->db->select('bud_suppliers.sup_name');
        $this->db->select('bud_stock_rooms.stock_room_name');
        $this->db->join('bud_sh_predelivery', 'bud_sh_predel_items.p_delivery_id=bud_sh_predelivery.p_delivery_id', 'left');
        $this->db->join('bud_itemgroups', 'bud_sh_predel_items.item_group_id=bud_itemgroups.group_id', 'left');
        $this->db->join('bud_items', 'bud_sh_predel_items.item_id=bud_items.item_id', 'left');
        $this->db->join('bud_shades', 'bud_sh_predel_items.shade_id=bud_shades.shade_id', 'left');
        $this->db->join('bud_users', 'bud_sh_predel_items.prepared_by=bud_users.ID', 'left');
        $this->db->join('bud_suppliers', 'bud_sh_predel_items.supplier_id=bud_suppliers.sup_id', 'left');
        $this->db->join('bud_stock_rooms', 'bud_sh_predel_items.stock_room_id=bud_stock_rooms.stock_room_id', 'left');
        $this->db->order_by('bud_sh_predelivery.p_delivery_id', 'desc');
        if (!empty($p_delivery_id)) {
            $this->db->where('bud_sh_predel_items.p_delivery_id', $p_delivery_id);
        }
        $this->db->where('bud_sh_predel_items.p_delivery_is_deleted', 1); //ER-07-18#-1
        return $this->db->get('bud_sh_predel_items')->result();
    }

    public function get_scapsales_boxes()
    {
        $this->db->select('bud_sh_quotation_items.*');
        $this->db->select('bud_sh_quotations.is_scrapsales');
        $this->db->join('bud_sh_quotations', 'bud_sh_quotation_items.quotation_id=bud_sh_quotations.quotation_id', 'left');
        $this->db->where('bud_sh_quotations.is_scrapsales', 2);
        return $this->db->get('bud_sh_quotation_items')->result();
    }

    //box status register shop
    function get_predc_id($box_id)
    {
        $this->db->select("p_delivery_id,delivery_qty");
        $this->db->where('box_id', $box_id);
        $this->db->where('bud_sh_predel_items.p_delivery_is_deleted', 1); //ER-07-18#-1
        $results = $this->db->get('bud_sh_predel_items')->result_array();
        return $results;
    }
    //box status register shop
}
