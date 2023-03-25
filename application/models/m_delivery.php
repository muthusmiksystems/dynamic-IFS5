<?php
class m_delivery extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    // Start Yarn and Thread
    function getPackingBoxes($from_date, $to_date, $box_prefix = null, $item_id = false, $include_soft = true)
    {
        $this->db->select('bud_yt_packing_boxes.*,bud_items.*,bud_yt_yarndeniers.denier_tech,bud_yt_poydeniers.denier_name as poy_denier_name,bud_shades.*');
        $this->db->select('bud_poy_lots.poy_lot_no, bud_poy_lots.poy_lot_name');
        $this->db->select('bud_stock_rooms.stock_room_name');
        $this->db->select('bud_itemgroups.group_name');
        $this->db->from('bud_yt_packing_boxes');
        $this->db->join('bud_items', 'bud_items.item_id = bud_yt_packing_boxes.item_id', 'left');
        $this->db->join('bud_yt_yarndeniers', 'bud_yt_yarndeniers.denier_id = bud_yt_packing_boxes.yarn_denier', 'left');
        $this->db->join('bud_yt_poydeniers', 'bud_yt_poydeniers.denier_id = bud_yt_packing_boxes.poy_denier', 'left');
        $this->db->join('bud_shades', 'bud_shades.shade_id = bud_yt_packing_boxes.shade_no', 'left');
        $this->db->join('bud_stock_rooms', 'bud_yt_packing_boxes.stock_room_id = bud_stock_rooms.stock_room_id', 'left');

        $this->db->join('bud_poy_lots', 'bud_yt_packing_boxes.poy_lot_id = bud_poy_lots.poy_lot_id', 'left');

        $this->db->join('bud_itemgroups', 'bud_items.item_group=bud_itemgroups.group_id', 'left');

        if ($box_prefix != null) {
            $this->db->where('bud_yt_packing_boxes.box_prefix', $box_prefix);
        }
        if (!empty($item_id)) {
            $this->db->where('bud_yt_packing_boxes.item_id', $item_id);
        }
        if ($include_soft == false) {
            $this->db->where('bud_yt_packing_boxes.box_prefix !=', 'S');
        }
        $this->db->where("DATE(bud_yt_packing_boxes.packed_date) BETWEEN '$from_date' AND '$to_date'");
        $this->db->where('bud_yt_packing_boxes.delivery_status', 1);
        $this->db->where('bud_yt_packing_boxes.is_deleted', 0);
        $this->db->where('bud_yt_packing_boxes.delivered_in_group', 0);
        $query = $this->db->get();
        return $query->result_array();
    }

    // function get_packing_boxes($from_date, $to_date, $box_prefix = null, $item_id = false, $include_soft = true)
    function get_packing_boxes($filter = array())
    {
        $this->db->select('bud_yt_packing_boxes.*,bud_items.*,bud_yt_yarndeniers.denier_tech,bud_yt_poydeniers.denier_name as poy_denier_name,bud_shades.*');
        $this->db->select('bud_poy_lots.poy_lot_no, bud_poy_lots.poy_lot_name');
        $this->db->select('bud_stock_rooms.stock_room_name');
        $this->db->select('bud_itemgroups.group_name');
        $this->db->from('bud_yt_packing_boxes');
        $this->db->join('bud_items', 'bud_items.item_id = bud_yt_packing_boxes.item_id', 'left');
        $this->db->join('bud_yt_yarndeniers', 'bud_yt_yarndeniers.denier_id = bud_yt_packing_boxes.yarn_denier', 'left');
        $this->db->join('bud_yt_poydeniers', 'bud_yt_poydeniers.denier_id = bud_yt_packing_boxes.poy_denier', 'left');
        $this->db->join('bud_shades', 'bud_shades.shade_id = bud_yt_packing_boxes.shade_no', 'left');
        $this->db->join('bud_stock_rooms', 'bud_yt_packing_boxes.stock_room_id = bud_stock_rooms.stock_room_id', 'left');

        $this->db->join('bud_poy_lots', 'bud_yt_packing_boxes.poy_lot_id = bud_poy_lots.poy_lot_id', 'left');

        $this->db->join('bud_itemgroups', 'bud_items.item_group=bud_itemgroups.group_id', 'left');

        if (count($filter) > 0) {
            if (isset($filter['item_id']) && !empty($filter['item_id'])) {
                $this->db->where('bud_yt_packing_boxes.item_id', $filter['item_id']);
            }
            if (isset($filter['item_group_id']) && !empty($filter['item_group_id'])) {
                // $this->db->select('bud_itemgroups.group_name');
                $this->db->where('bud_itemgroups.group_id', $filter['item_group_id']);
            }
            if (isset($filter['shade_id']) && !empty($filter['shade_id'])) {
                $this->db->where('bud_shades.shade_id', $filter['shade_id']);
            }
            if (isset($filter['from_date']) && isset($filter['to_date'])) {
                $from_date = date("Y-m-d", strtotime($filter['from_date']));
                $to_date = date("Y-m-d", strtotime($filter['to_date']));
                $this->db->where("DATE(bud_yt_packing_boxes.packed_date) BETWEEN '$from_date' AND '$to_date'");
            }
            if (empty($filter['include_soft'])) {
                $this->db->where('bud_yt_packing_boxes.box_prefix !=', 'S');
            }
        }
        $this->db->where('bud_yt_packing_boxes.delivery_status', 1);
        $this->db->where('bud_yt_packing_boxes.is_deleted', 0);
        $this->db->where('bud_yt_packing_boxes.delivered_in_group', 0);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_packing_boxes_v2($filter = array())
    {
        $this->db->select('bud_yt_packing_boxes.*,bud_yt_packing_boxes.box_id as b_id,bud_items.*, dost_stock_room_box.*');
        $this->db->select('bud_stock_rooms.stock_room_name');
        $this->db->from('bud_yt_packing_boxes');
        $this->db->join('bud_items', 'bud_items.item_id = bud_yt_packing_boxes.item_id', 'left');
        $this->db->join('dost_stock_room_box', 'dost_stock_room_box.box_id = bud_yt_packing_boxes.box_id', 'left');
        $this->db->join('bud_stock_rooms', 'bud_yt_packing_boxes.stock_room_id = bud_stock_rooms.stock_room_id', 'left');

        if (count($filter) > 0) {
            if (empty($filter['include_soft'])) {
                $this->db->where('bud_yt_packing_boxes.box_prefix !=', 'S');
            }
        }
        $this->db->where('bud_yt_packing_boxes.delivery_status', 1);
        $this->db->where('bud_yt_packing_boxes.is_deleted', 0);
        //$this->db->where('dost_stock_room_box.status', 1);
        $this->db->where('bud_yt_packing_boxes.delivered_in_group', 0);
        $query = $this->db->get();
        return $query->result_array();
    }

    //yran lot link correction
    function getPackingBoxDetails($box_no)
    {
        $this->db->select('bud_yt_packing_boxes.*,bud_yarn_lots.*,bud_shades.*,bud_items.*,bud_yt_packing_boxes.yarn_denier as yarn_den');
        $this->db->select('bud_stock_rooms.stock_room_name');
        $this->db->select('bud_poy_lots.poy_lot_no, bud_poy_lots.poy_lot_name');
        $this->db->from('bud_yt_packing_boxes');
        $this->db->join('bud_yarn_lots', 'bud_yarn_lots.yarn_lot_id = bud_yt_packing_boxes.lot_no', 'left');
        $this->db->join('bud_shades', 'bud_shades.shade_id = bud_yt_packing_boxes.shade_no', 'left');
        $this->db->join('bud_items', 'bud_items.item_id = bud_yt_packing_boxes.item_id', 'left');
        $this->db->join('bud_stock_rooms', 'bud_yt_packing_boxes.stock_room_id = bud_stock_rooms.stock_room_id', 'left');
        $this->db->join('bud_poy_lots', 'bud_yt_packing_boxes.poy_lot_id = bud_poy_lots.poy_lot_id', 'left');
        $this->db->where('bud_yt_packing_boxes.box_id', $box_no);
        $query = $this->db->get();
        return $query->result_array();
    }
    //yran lot link correction
    function getPackingItemDetails($box_no)
    {
        $this->db->select('bud_yt_packing_boxes.*,bud_yarn_lots.*,bud_shades.*,bud_items.*')
            ->from('bud_yt_packing_boxes')
            ->join('bud_yarn_lots', 'bud_yarn_lots.yarn_lot_id = bud_yt_packing_boxes.lot_no', 'left')
            ->join('bud_shades', 'bud_shades.shade_id = bud_yt_packing_boxes.shade_no', 'left')
            ->join('bud_items', 'bud_items.item_id = bud_yt_packing_boxes.item_id', 'left')
            ->where('bud_yt_packing_boxes.box_id', $box_no);
        $query = $this->db->get();
        $results = $query->result_array();
        return $results;
    }
    function getPreDelItems($from_date, $to_date)
    {
        $this->db->select('ak_dyed_yarn_packing.*,bud_yarn_lots.*,bud_shades.*,bud_items.*')
            ->from('ak_dyed_yarn_packing')
            ->join('bud_yarn_lots', 'bud_yarn_lots.yarn_lot_id = ak_dyed_yarn_packing.yarn_lot_no', 'left')
            ->join('bud_shades', 'bud_shades.shade_id = ak_dyed_yarn_packing.shade', 'left')
            ->join('bud_items', 'bud_items.item_id = ak_dyed_yarn_packing.item_id', 'left')
            ->where("DATE(ak_dyed_yarn_packing.date) BETWEEN '$from_date' AND '$to_date'")
            // ->where("ak_dyed_yarn_packing.predelivery_status", 1)
            ->where("ak_dyed_yarn_packing.delivery_status", 1);
        $query = $this->db->get();
        return $query->result_array();
    }
    function getPreDelItemsDetails($box_no)
    {
        $this->db->select('ak_dyed_yarn_packing.*,bud_yarn_lots.*,bud_shades.*,bud_items.*')
            ->from('ak_dyed_yarn_packing')
            ->join('bud_yarn_lots', 'bud_yarn_lots.yarn_lot_id = ak_dyed_yarn_packing.yarn_lot_no', 'left')
            ->join('bud_shades', 'bud_shades.shade_id = ak_dyed_yarn_packing.shade', 'left')
            ->join('bud_items', 'bud_items.item_id = ak_dyed_yarn_packing.item_id', 'left')
            ->where('id', $box_no);
        $query = $this->db->get();
        return $query->result_array();
    }
    function insertYTCart($data)
    {
        $this->db->insert('bud_yt_cart_items', $data);
        return $this->db->insert_id();
    }
    function deleteYTCartItem($rowid)
    {
        $this->db->where('rowid', $rowid);
        $this->db->delete('bud_yt_cart_items');
        return true;
    }
    function deleteYTCart($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->delete('bud_yt_cart_items');
        return true;
    }
    function getBoxesArrayItems($column_name, $itemsArray)
    {
        $this->db->select('*');
        $this->db->from('bud_yt_packing_boxes');
        $this->db->where_in($column_name, $itemsArray);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_yt_predelivery_items($box_ids = array())
    {
        $this->db->select('*');
        $this->db->select('bud_items.item_name');
        $this->db->select('bud_shades.shade_name,bud_shades.shade_code');
        $this->db->join('bud_items', 'bud_yt_packing_boxes.item_id=bud_items.item_id', 'left');
        $this->db->join('bud_shades', 'bud_yt_packing_boxes.shade_no=bud_shades.shade_id', 'left');
        $this->db->from('bud_yt_packing_boxes');
        $this->db->where_in('box_id', $box_ids);
        $query = $this->db->get();
        return $query->result();
    }

    function get_tap_predelivery_items($box_ids = array())
    {
        $this->db->select('*');
        $this->db->select('bud_te_items.item_name');
        $this->db->select('bud_uoms.uom_name');
        $this->db->join('bud_te_items', 'bud_te_outerboxes.packing_innerbox_items=bud_te_items.item_id', 'left');
        $this->db->join('bud_uoms', 'bud_te_outerboxes.item_uom=bud_uoms.uom_id', 'left');
        $this->db->from('bud_te_outerboxes');
        $this->db->where_in('box_no', $box_ids);
        $query = $this->db->get();
        return $query->result();
    }

    function get_tap_delivery_items($box_ids = array())
    {
        $this->db->select('*');
        $this->db->select('bud_te_items.item_name');
        $this->db->select('bud_uoms.uom_name');
        $this->db->join('bud_te_items', 'bud_te_outerboxes.packing_innerbox_items=bud_te_items.item_id', 'left');
        $this->db->join('bud_uoms', 'bud_te_outerboxes.item_uom=bud_uoms.uom_id', 'left');
        $this->db->from('bud_te_outerboxes');
        $this->db->where_in('box_no', $box_ids);
        $query = $this->db->get();
        return $query->result();
    }


    // Soft Delivery
    function save_soft_dc($delivery, $boxes = false)
    {
        if ($delivery['delivery_id']) {
            $this->db->where('delivery_id', $delivery['delivery_id']);
            $this->db->update('bud_gray_yarn_soft_dc', $delivery);

            $id = $delivery['delivery_id'];
        } else {
            $this->db->insert('bud_gray_yarn_soft_dc', $delivery);
            $id = $this->db->insert_id();
        }


        if ($boxes !== false) {
            if ($delivery['delivery_id']) {
                //get all the boxes that the product is in
                $items   = $this->soft_delivery_items($id);

                //generate cat_id array
                $ids    = array();
                foreach ($items as $c) {
                    $ids[]  = $c->box_id;
                }

                //eliminate boxes that products are no longer in
                foreach ($ids as $c) {
                    if (!in_array($c, $boxes)) {
                        $this->db->delete('bud_yarn_soft_dc_items', array('delivery_id' => $id, 'box_id' => $c));
                    }
                }

                //add products to new boxes
                foreach ($boxes as $c) {
                    if (!in_array($c, $ids)) {
                        $this->db->insert('bud_yarn_soft_dc_items', array('delivery_id' => $id, 'box_id' => $c));
                    }
                }
            } else {
                //new product add them all
                foreach ($boxes as $c) {
                    $this->db->insert('bud_yarn_soft_dc_items', array('delivery_id' => $id, 'box_id' => $c));
                }
            }
        }


        //return the product id
        return $id;
    }

    function list_soft_delivery()
    {
        return $this->db->get('bud_gray_yarn_soft_dc')->result();
    }

    function list_gray_yarn_delivery()
    {
        return $this->db->get('bud_yt_gy_transfer')->result();
    }

    function get_soft_delivery($delivery_id)
    {
        $result = $this->db->get_where('bud_gray_yarn_soft_dc', array('delivery_id' => $delivery_id))->row();
        if (!$result) {
            return false;
        }

        $result->outer_boxes = $this->soft_delivery_items($result->delivery_id);

        return $result;
    }
    function delete_soft_delivery($delivery_id)
    {
        $this->db->where('delivery_id', $delivery_id);
        $this->db->delete('bud_gray_yarn_soft_dc');

        // delete children
        $this->delete_soft_delivery_items($delivery_id);
    }
    function soft_delivery_items($delivery_id)
    {
        $this->db->select('bud_yarn_soft_dc_items.*'); //Inclusion of Lotwise tot
        $this->db->where('delivery_id', $delivery_id);
        //Inclusion of Lotwise tot
        $this->db->join('bud_yt_packing_boxes', ' bud_yarn_soft_dc_items.box_id = bud_yt_packing_boxes.box_id ', 'left');
        $this->db->join('bud_yarn_lots', 'bud_yt_packing_boxes.yarn_lot_id = bud_yarn_lots.yarn_lot_id', 'left');
        $this->db->order_by('bud_yt_packing_boxes.yarn_lot_id', 'bud_yt_packing_boxes.item_id', 'bud_yt_packing_boxes.shade_id', 'asc');
        //end of Inclusion of Lotwise tot
        return $this->db->get('bud_yarn_soft_dc_items')->result();
    }
    function delete_soft_delivery_items($delivery_id)
    {
        $this->db->where('delivery_id', $delivery_id);
        $this->db->delete('bud_yarn_soft_dc_items');

        // delete children
        // $this->remove_product($id);
    }

    function yt_soft_packing_boxes($box_prefix = 'S', $from_date = false, $to_date = false, $item_id = false)
    {
        $this->db->select('bud_yt_packing_boxes.*,bud_items.*,bud_yt_yarndeniers.denier_tech,bud_yt_poydeniers.denier_name as poy_denier_name,bud_shades.*,bud_poy_lots.poy_lot_name');
        $this->db->from('bud_yt_packing_boxes');
        $this->db->join('bud_items', 'bud_items.item_id = bud_yt_packing_boxes.item_id', 'left');
        $this->db->join('bud_yt_yarndeniers', 'bud_yt_yarndeniers.denier_id = bud_yt_packing_boxes.yarn_denier', 'left');
        $this->db->join('bud_yt_poydeniers', 'bud_yt_poydeniers.denier_id = bud_yt_packing_boxes.poy_denier', 'left');
        $this->db->join('bud_shades', 'bud_shades.shade_id = bud_yt_packing_boxes.shade_no', 'left');
        $this->db->join('bud_poy_lots', 'bud_yt_packing_boxes.poy_lot_id = bud_poy_lots.poy_lot_id', 'left');
        if ($box_prefix != null) {
            $this->db->where('bud_yt_packing_boxes.box_prefix', $box_prefix);
        }
        if (!empty($from_date) && !empty($to_date)) {
            $this->db->where("DATE(bud_yt_packing_boxes.packed_date) between '$from_date' and '$to_date'");
        }
        if (!empty($item_id)) {
            $this->db->where('bud_yt_packing_boxes.item_id', $item_id);
        }
        $this->db->where('bud_yt_packing_boxes.predelivery_status', 1);
        $this->db->where('bud_yt_packing_boxes.delivery_status', 1);
        $this->db->where('bud_yt_packing_boxes.is_deleted', 0);
        $this->db->where('bud_yt_packing_boxes.box_id NOT IN (select box_id from bud_yarn_soft_dc_items)', NULL, FALSE);
        $query = $this->db->get();
        return $query->result_array();
    }

    function soft_delivery_item_details($box_id) //ER-10-18#-64
    {
        $this->db->select('bud_yt_packing_boxes.*,bud_items.*,bud_yt_yarndeniers.denier_tech,bud_yt_poydeniers.denier_name as poy_denier_name,bud_shades.*,bud_yarn_lots.yarn_lot_no,bud_lots.lot_no as sys_lot_no'); //Inclusion of Lotwise tot//ER-10-18#-64
        // $this->db->from('bud_yt_packing_boxes');
        $this->db->join('bud_yarn_lots', 'bud_yt_packing_boxes.yarn_lot_id = bud_yarn_lots.yarn_lot_id', 'left'); ////Inclusion of Lotwise tot
        $this->db->join('bud_items', 'bud_items.item_id = bud_yt_packing_boxes.item_id', 'left');
        $this->db->join('bud_yt_yarndeniers', 'bud_yt_yarndeniers.denier_id = bud_yt_packing_boxes.yarn_denier', 'left');
        $this->db->join('bud_yt_poydeniers', 'bud_yt_poydeniers.denier_id = bud_yt_packing_boxes.poy_denier', 'left');
        $this->db->join('bud_lots', 'bud_lots.lot_id = bud_yt_packing_boxes.lot_no', 'left'); //ER-10-18#-64
        $this->db->join('bud_shades', 'bud_shades.shade_id = bud_yt_packing_boxes.shade_no', 'left');
        return $this->db->get_where('bud_yt_packing_boxes', array('bud_yt_packing_boxes.box_id' => $box_id))->row();
    }

    function soft_delivery_item_list($from_date = false, $to_date = false, $poy_lot_id)
    {
        $this->db->join('bud_items', 'bud_items.item_id = bud_yt_packing_boxes.item_id');
        $this->db->join('bud_poy_lots', 'bud_yt_packing_boxes.poy_lot_id = bud_poy_lots.poy_lot_id');
        $this->db->join('bud_yarn_soft_dc_items', 'bud_yt_packing_boxes.box_id = bud_yarn_soft_dc_items.box_id');
        $this->db->join('bud_gray_yarn_soft_dc', 'bud_yarn_soft_dc_items.delivery_id = bud_gray_yarn_soft_dc.delivery_id');
        $this->db->where("date(bud_gray_yarn_soft_dc.delivery_date) between '$from_date' and '$to_date'");
        $this->db->where('bud_yt_packing_boxes.poy_lot_id', $poy_lot_id);
        return $this->db->get('bud_yt_packing_boxes')->result();
    }

    public function get_yt_predelivery_list($filter = array())
    {
        $this->db->select('bud_yt_delivery.*');
        $this->db->select('bud_customers.cust_name');
        $this->db->join('bud_customers', 'bud_yt_delivery.delivery_customer = bud_customers.cust_id', 'left');
        if (count($filter) > 0) {
            if (isset($filter['cust_id'])) {
                $this->db->where('bud_yt_delivery.delivery_customer', $filter['cust_id']);
            }
            if (isset($filter['invoice_status'])) {
                $this->db->where('bud_yt_delivery.invoice_status', $filter['invoice_status']);
            }
        }
        $this->db->where('bud_yt_delivery.delivery_is_deleted', 1); //ER-09-18#-58
        return $this->db->get('bud_yt_delivery')->result();
    }

    public function get_tap_predelivery_list($filter = array(), $invoice_status = false)
    {
        $this->db->select('bud_te_delivery.*');
        $this->db->select('bud_customers.cust_name');
        $this->db->join('bud_customers', 'bud_te_delivery.delivery_customer = bud_customers.cust_id', 'left');
        if (count($filter) > 0) {
            if (isset($filter['cust_id'])) {
                $this->db->where('bud_te_delivery.delivery_customer', $filter['cust_id']);
            }
        }
        if ($invoice_status != false) {
            $this->db->where('bud_te_delivery.invoice_status', 1);
        }
        $this->db->where('bud_te_delivery.is_deleted', 1); //delivery delete tapes
        return $this->db->get('bud_te_delivery')->result();
    }

    public function get_lbl_predelivery_list($filter = array(), $invoice_status = false)
    {
        $this->db->select('bud_lbl_delivery.*');
        $this->db->select('bud_customers.cust_name');
        $this->db->join('bud_customers', 'bud_lbl_delivery.delivery_customer = bud_customers.cust_id', 'left');
        if (count($filter) > 0) {
            if (isset($filter['cust_id'])) {
                $this->db->where('bud_lbl_delivery.delivery_customer', $filter['cust_id']);
            }
        }
        if ($invoice_status != false) {
            $this->db->where('bud_lbl_delivery.invoice_status', 1);
        }
        $this->db->where('bud_lbl_delivery.is_deleted', 1);
        return $this->db->get('bud_lbl_delivery')->result();
    }
    public function get_yt_delivery($delivery_id)
    {
        $this->db->where('delivery_id', $delivery_id);
        $this->db->where('bud_yt_delivery.delivery_is_deleted', 1); //ER-09-18#-58
        return $this->db->get('bud_yt_delivery')->row();
    }
    public function get_te_delivery($delivery_id)
    {
        $this->db->where('delivery_id', $delivery_id);
        return $this->db->get('bud_te_delivery')->row();
    }
    public function get_lbl_delivery($delivery_id)
    {
        $this->db->where('delivery_id', $delivery_id);
        return $this->db->get('bud_lbl_delivery')->row();
    }
}
