<?php
class M_reports extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    function getPackingItems($data)
    {
        $this->db->get_where('bud_te_outerboxes', $data);
        $query = $this->db->get();
        return $query->result_array();
    }
    function getPackingItemsYt($from_date, $to_date, $box_prefix = null, $item_id = null)
    {
        $this->db->select('bud_yt_packing_boxes.*,bud_items.*,bud_yt_yarndeniers.denier_tech,bud_yt_poydeniers.denier_name as poy_denier_name,bud_shades.*');
        $this->db->from('bud_yt_packing_boxes');
        $this->db->join('bud_items', 'bud_items.item_id = bud_yt_packing_boxes.item_id', 'left');
        $this->db->join('bud_yt_yarndeniers', 'bud_yt_yarndeniers.denier_id = bud_yt_packing_boxes.yarn_denier', 'left');
        $this->db->join('bud_yt_poydeniers', 'bud_yt_poydeniers.denier_id = bud_yt_packing_boxes.poy_denier', 'left');
        $this->db->join('bud_shades', 'bud_shades.shade_id = bud_yt_packing_boxes.shade_no', 'left');
        if ($box_prefix != null) {
            $this->db->where('bud_yt_packing_boxes.box_prefix', $box_prefix);
        }
        if ($item_id != null) {
            $this->db->where('bud_yt_packing_boxes.item_id', $item_id);
        }
        $this->db->where("DATE(bud_yt_packing_boxes.packed_date) BETWEEN '$from_date' AND '$to_date'");
        // $this->db->where('bud_yt_packing_boxes.delivery_status', 1);
        $this->db->order_by('bud_yt_packing_boxes.lot_no', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Sathya
    function get_customer($customer_id)
    {
        $this->db->select('*');
        $this->db->where('cust_id', $customer_id);
        $result = $this->db->get('bud_customers');
        return $result->first_row('array');
    }
    function get_item_yt($item_id)
    {
        $this->db->select('*');
        $this->db->where('item_id', $item_id);
        $result = $this->db->get('bud_items');
        return $result->first_row('array');
    }
    function get_shade_yt($shade_id)
    {
        $this->db->select('*');
        $this->db->where('shade_id', $shade_id);
        $result = $this->db->get('bud_shades');
        return $result->first_row('array');
    }
    function get_item_lbl($item_id)
    {
        $this->db->select('*');
        $this->db->where('item_id', $item_id);
        $result = $this->db->get('bud_lbl_items');
        return $result->first_row('array');
    }
    function get_cust_pack_reg_yt($from_date, $to_date, $box_prefix = null, $customer_id = null, $item_id = null)
    {
        $return = array();
        $this->db->join('bud_shades', 'bud_shades.shade_id = bud_yt_packing_boxes.shade_no', 'left');
        if (!empty($from_date)) {
            $this->db->where('DATE(packed_date) >=', $from_date);
        }
        if (!empty($to_date)) {
            $this->db->where('DATE(packed_date) <=',  $to_date);
        }
        if (!empty($item_id)) {
            $this->db->where('bud_yt_packing_boxes.item_id', $item_id);
        }
        $box_details = $this->db->get('bud_yt_packing_boxes')->result();
        foreach ($box_details as $box) {
            $return[$box->item_id][] = $box;
        }
        return $return;
    }

    // Not Delevered Boxes
    function get_stock_reg_yt($from_date, $to_date, $box_prefix = null, $customer_id = null, $item_id = null, $shade_id = null, $lot_no = null, $room_no = null)
    {
        $return = array();
        // $this->db->join('bud_items','bud_items.item_id = bud_yt_packing_boxes.item_id');
        $this->db->join('bud_shades', 'bud_shades.shade_id = bud_yt_packing_boxes.shade_no', 'left');
        if (!empty($from_date)) {
            $this->db->where('packed_date >=', $from_date);
        }
        if (!empty($to_date)) {
            $this->db->where('packed_date <=',  $to_date);
        }
        if (!empty($item_id)) {
            $this->db->where('bud_yt_packing_boxes.item_id', $item_id);
        }
        if (!empty($shade_id)) {
            $this->db->where('bud_shades.shade_id', $shade_id);
        }
        if (!empty($room_no)) {
            $this->db->where('stock_room_id', $room_no);
        }

        if (!empty($lot_no)) {
            $where = "(`yarn_lot_id` LIKE '" . $lot_no . "%' OR `lot_no`='" . $lot_no . "')";
            $this->db->where($where);
            //$this->db->where('lot_no', $lot_no);        
        }

        //$this->db->where('bud_shades.shade_id !=', '1721');  
        $this->db->where('bud_yt_packing_boxes.delivery_status', 1);
        $box_details = $this->db->get('bud_yt_packing_boxes')->result();
        foreach ($box_details as $box) {
            $return[$box->item_id][] = $box;
        }
        //echo "<pre>";print_r($this->db->last_query());exit;

        return $return;
    }
    //Dynamic Dost 3.0 Stock Room Wise Stock Report
    function get_stock_stockroom_reg_yt($from_date, $to_date, $box_prefix = null, $customer_id = null, $item_id = null, $shade_id = null, $lot_no = null, $room_no = null, $status = null)
    {
        $return = array();
        // $this->db->join('bud_items','bud_items.item_id = bud_yt_packing_boxes.item_id');
        $this->db->join('bud_shades', 'bud_shades.shade_id = bud_yt_packing_boxes.shade_no', 'left');
        if (!empty($from_date)) {
            $this->db->where('packed_date >=', $from_date);
        }
        if (!empty($to_date)) {
            $this->db->where('packed_date <=',  $to_date);
        }
        if (!empty($item_id)) {
            $this->db->where('item_id', $item_id);
        }
        if (!empty($shade_id)) {
            $this->db->where('bud_shades.shade_id', $shade_id);
        }
        if (!empty($room_no)) {
            $this->db->where('stock_room_id', $room_no);
        }

        if (!empty($lot_no)) {
            $where = "(`yarn_lot_id` LIKE '" . $lot_no . "%' OR `lot_no`='" . $lot_no . "')";
            $this->db->where($where);
            //$this->db->where('lot_no', $lot_no);        
        }

        if (!empty($status)) {
            switch ($status) {
                case 1:
                    $this->db->where('predelivery_status', '0');
                    $this->db->where('delivered_in_group', '0');
                    $this->db->where('delivery_status', '0');
                    break;
                case 2:
                    $this->db->where('delivered_in_group', '1');
                    break;
                case 3:
                    $this->db->where('predelivery_status', '0');
                    $this->db->where('delivered_in_group', '0');
                    $this->db->where('delivery_status', '0');
                    break;
                case 4:
                    $this->db->where('delivery_status', '0');
                    //$this->db->where('predelivery_status', '0');
            }
        }
        $this->db->where('is_deleted', '0'); //ER-08-18#-40
        $this->db->where('is_perm_deleted', '0'); //ER-08-18#-40
        $box_details = $this->db->get('bud_yt_packing_boxes')->result();
        foreach ($box_details as $box) {
            $return[$box->stock_room_id][] = $box;
        }
        //echo "<pre>";print_r($this->db->last_query());exit;
        return $return;
    }
    //End of Dynamic Dost 3.0 Stock Room Wise Stock Report
    //Mari  Boxes
    function get_stock_reg_yt_m($from_date, $box_prefix = null, $customer_id = null, $item_id = null, $shade_id = null, $lot_no = null)
    {
        $return = array();
        // $this->db->join('bud_items','bud_items.item_id = bud_yt_packing_boxes.item_id');
        $this->db->join('bud_shades', 'bud_shades.shade_id = bud_yt_packing_boxes.shade_no', 'left');
        if (!empty($from_date)) {
            $date = "2014-01-01";
            $this->db->where('packed_date >=', $date);
            $this->db->where('packed_date <=',  $from_date);
        }

        if (!empty($item_id)) {
            $this->db->where('bud_yt_packing_boxes.item_id', $item_id);
        }

        if (!empty($shade_id)) {
            $this->db->where('bud_shades.shade_id', $shade_id);
        }

        if (!empty($lot_no)) {
            $where = "(`yarn_lot_id` LIKE '" . $lot_no . "%' OR `lot_no`='" . $lot_no . "')";
            $this->db->where($where);
            //$this->db->where('lot_no', $lot_no);        
        }

        $this->db->where('bud_yt_packing_boxes.delivery_status', 1);
        $box_details = $this->db->get('bud_yt_packing_boxes')->result();
        // echo $from_date;
        //echo var_dump($box_details);
        foreach ($box_details as $box) {
            $return[$box->item_id][] = $box;
        }
        // echo "s";
        return $return;
    }

    //Mari end
    // Customer Delivery Register
    function box_dc_no_yt($box_id)
    {
        $this->db->where("FIND_IN_SET('$box_id',delivery_boxes) !=", 0);
        $this->db->where('bud_yt_delivery.delivery_is_deleted', 1); //ER-09-18#-58
        return $this->db->get('bud_yt_delivery')->row();
    }
    function get_cust_delivery_reg_yt($from_date = null, $to_date = null, $box_prefix = null, $customer_id = null, $item_id = null)
    {
        $this->db->select('delivery_boxes,delivery_customer,dc_no,delivery_id'); //ER-08-18#-31
        if (!empty($from_date)) {
            $this->db->where('delivery_date >=', $from_date);
        }
        if (!empty($to_date)) {
            $this->db->where('delivery_date <=',  $to_date);
        }

        if (!empty($customer_id)) {
            $this->db->where('delivery_customer', $customer_id);
        }
        $this->db->where('bud_yt_delivery.delivery_is_deleted', 1); //ER-09-18#-58
        $deliveries = $this->db->get('bud_yt_delivery')->result();

        $delivery_boxes = array();
        $dc_nos = array();
        foreach ($deliveries as $delivery) {
            $delivery_boxes[$delivery->delivery_customer][] = explode(",", $delivery->delivery_boxes);
            $dc_nos[$delivery->dc_no] = explode(",", $delivery->delivery_boxes);
        }

        $boxes_array = array();
        foreach ($delivery_boxes as $key => $value) {
            $boxes_array[$key] = call_user_func_array('array_merge', $value);
        }

        unset($delivery_boxes);

        $return = array();
        foreach ($boxes_array as $customer_id => $boxes) {
            foreach ($boxes as $box_id) {
                $this->db->join('bud_items', 'bud_items.item_id = bud_yt_packing_boxes.item_id');
                $this->db->join('bud_shades', 'bud_shades.shade_id = bud_yt_packing_boxes.shade_no', 'left');
                $this->db->where('box_id', $box_id);
                if (!empty($item_id)) {
                    $this->db->where('bud_items.item_id', $item_id);
                }
                $box_details = $this->db->get('bud_yt_packing_boxes')->row();
                if ($box_details) {
                    $dc_no_result = $this->box_dc_no_yt($box_id);
                    // echo $dc_no;   
                    $box_details->dc_no = $dc_no_result->dc_no;
                    $box_details->delivery_id = $dc_no_result->delivery_id; //ER-08-18#-31
                    $box_details->delivery_date = $dc_no_result->delivery_date;
                    $return[$customer_id][] = $box_details;
                }
            }
        }
        return $return;
    }

    // Customer Invoice Register
    function box_invoice_no_yt($box_id)
    {
        $this->db->where("FIND_IN_SET('$box_id',boxes_array) !=", 0);
        return $this->db->get('bud_yt_invoices')->row();
    }
    // get box invoiced in te
    function get_box_invoiced_te($box_id)
    {
        $this->db->select('invoice_no');
        $this->db->like("invoice_items", $box_id);
        $invoice = $this->db->get('bud_te_invoices')->result_array();
        return (empty($invoice)) ? '' : $invoice[0]['invoice_no'];
    }
    // get box invoiced in lbl
    function get_box_invoiced_lbl($box_id)
    {
        //partial delivery qty
        $this->db->select('bud_lbl_invoices.invoice_id,invoice_no,delivery_qty');
        $this->db->where("box_id", $box_id);
        $this->db->where('p_delivery_is_deleted', 1);
        $this->db->join('bud_lbl_invoices', 'bud_lbl_invoices.invoice_id = bud_lbl_predelivery_items.invoice_id');
        $invoice = $this->db->get('bud_lbl_predelivery_items')->result_array();
        $inv_no = array();
        foreach ($invoice as $inv) {
            $inv_no[$inv['invoice_id']] = $inv['invoice_no'] . '-' . $inv['delivery_qty'];
        }
        return implode(',', $inv_no);
        //end of partial delivery qty
    }
    //get box delivered lbl
    function get_box_dc_lbl($box_id)
    {
        //partial delivery qty
        $this->db->select('dc_no,bud_lbl_delivery.delivery_id,bud_lbl_predelivery_items.delivery_qty');
        $this->db->where("box_id", $box_id);
        $this->db->where('p_delivery_is_deleted', 1);
        $this->db->join('bud_lbl_delivery', 'bud_lbl_delivery.delivery_id = bud_lbl_predelivery_items.delivery_id');
        $dcs = $this->db->get('bud_lbl_predelivery_items')->result_array();
        $dc_no = array();
        foreach ($dcs as $dc) {
            $dc_no[$dc['delivery_id']] = $dc['dc_no'] . '-' . $dc['delivery_qty'];
        }
        return implode(',', $dc_no);
        //end of partial delivery qty
    }
    // get dc invoiced in lbl
    //partial delivery qty
    //get box predelivered lbl
    function get_box_status($box_id)
    {
        $this->db->select('p_delivery_id,delivery_qty,delivery_id,invoice_id');
        $this->db->where("box_id", $box_id);
        $this->db->where('p_delivery_is_deleted', 1);
        $pdcs = $this->db->get('bud_lbl_predelivery_items')->result_array();
        $data['pdc_no'] = array();
        $data['dc_no'] = array();
        $data['inv_no'] = array();
        foreach ($pdcs as $pdc) {
            if ($pdc['invoice_id']) {
                $data['inv_no'][$pdc['invoice_id']] = $this->m_mir->getgroupfields('bud_lbl_invoices', 'invoice_no', array('invoice_id' => $pdc['invoice_id']))[0]['invoice_no'];
                $data['inv_no'][$pdc['invoice_id']] .= '=' . $pdc['delivery_qty'];
            } elseif ($pdc['delivery_id']) {
                $data['dc_no'][$pdc['delivery_id']] = $this->m_mir->getgroupfields('bud_lbl_delivery', 'dc_no', array('delivery_id' => $pdc['delivery_id']))[0]['dc_no'];
                $data['dc_no'][$pdc['delivery_id']] .= '=' . $pdc['delivery_qty'];
            } else {
                $data['pdc_no'][$pdc['p_delivery_id']] = 'PDC/' . $pdc['p_delivery_id'] . '=' . $pdc['delivery_qty'];
            }
        }
        return $data;
    }
    //partial delivery qty
    // get dc invoiced in lbl
    function get_dc_invoiced_lbl($dc)
    {
        $this->db->select('invoice_no');
        $this->db->like("selected_dc", $dc);
        $invoice = $this->db->get('bud_lbl_invoices')->result_array();
        return (empty($invoice)) ? '' : $invoice[0]['invoice_no'];
    }
    function get_cust_invoice_reg_yt($from_date = null, $to_date = null, $box_prefix = null, $customer_id = null, $item_id = null)
    {
        $this->db->select('boxes_array,customer,invoice_no');
        if (!empty($from_date)) {
            $this->db->where('invoice_date >=', $from_date);
        }
        if (!empty($to_date)) {
            $this->db->where('invoice_date <=',  $to_date);
        }

        if (!empty($customer_id)) {
            $this->db->where('customer', $customer_id);
        }
        $deliveries = $this->db->get('bud_yt_invoices')->result();

        $delivery_boxes = array();
        $invoice_nos = array();
        foreach ($deliveries as $delivery) {
            $delivery_boxes[$delivery->customer][] = explode(",", $delivery->boxes_array);
            $invoice_nos[$delivery->invoice_no] = explode(",", $delivery->boxes_array);
        }

        $boxes_array = array();
        foreach ($delivery_boxes as $key => $value) {
            $boxes_array[$key] = call_user_func_array('array_merge', $value);
        }

        unset($delivery_boxes);

        $return = array();
        foreach ($boxes_array as $customer_id => $boxes) {
            foreach ($boxes as $box_id) {
                $this->db->join('bud_items', 'bud_items.item_id = bud_yt_packing_boxes.item_id');
                $this->db->join('bud_shades', 'bud_shades.shade_id = bud_yt_packing_boxes.shade_no', 'left');
                $this->db->where('box_id', $box_id);
                if (!empty($item_id)) {
                    $this->db->where('bud_items.item_id', $item_id);
                }
                $box_details = $this->db->get('bud_yt_packing_boxes')->row();
                if ($box_details) {
                    $invoice_no_result = $this->box_invoice_no_yt($box_id);
                    $inv_boxes = explode(',', $invoice_no_result->boxes_array);
                    //Dynamic Dost 3.0
                    $inv_item_rates = explode(',', $invoice_no_result->item_rate);
                    foreach ($inv_boxes as $key => $value) {
                        if ($value == $box_id) {
                            $box_details->item_rate = @$inv_item_rates[$key];
                            break;
                        }
                    }
                    //Dynamic Dost 3.0
                    $box_details->invoice_no = $invoice_no_result->invoice_no;
                    $box_details->invoice_date = $invoice_no_result->invoice_date;
                    $return[$customer_id][] = $box_details;
                }
            }
        }
        return $return;
    }

    function get_invoice_qty_yt($boxes_array = array())
    {
        $total_qty = 0;
        foreach ($boxes_array as $box_id) {
            $this->db->where('box_id', $box_id);
            if (!empty($item_id)) {
                $this->db->where('bud_items.item_id', $item_id);
            }
            $box_details = $this->db->get('bud_yt_packing_boxes')->row();
            $total_qty += $box_details->net_weight;
        }
        return $total_qty;
    }

    function get_cust_sales_reg_yt($from_date = null, $to_date = null, $customer_id = null)
    {
        if (!empty($from_date)) {
            $this->db->where('invoice_date >=', $from_date);
        }
        if (!empty($to_date)) {
            $this->db->where('invoice_date <=',  $to_date);
        }
        if (!empty($customer_id)) {
            $this->db->where('customer', $customer_id);
        }

        $invoices = $this->db->get('bud_yt_invoices')->result();

        $return = array();
        foreach ($invoices as $invoice) {
            $boxes_array = explode(",", $invoice->boxes_array);

            $invoice->total_qty = $this->get_invoice_qty_yt($boxes_array);
            $return[$invoice->customer][] = $invoice;
        }
        return $return;
    }

    function get_invoice_qty_te($boxes_array = array())
    {
        $total_qty = 0;
        foreach ($boxes_array as $box_id) {
            $this->db->where('box_no', $box_id);
            $box_details = $this->db->get('bud_te_outerboxes')->row();
            $total_qty += $box_details->total_meters;
        }
        return $total_qty;
    }

    function get_cust_sales_reg_te($from_date = null, $to_date = null, $customer_id = null)
    {
        if (!empty($from_date)) {
            $this->db->where('invoice_date >=', $from_date);
        }
        if (!empty($to_date)) {
            $this->db->where('invoice_date <=',  $to_date);
        }
        if (!empty($customer_id)) {
            $this->db->where('customer', $customer_id);
        }

        $invoices = $this->db->get('bud_te_invoices')->result();

        $return = array();
        foreach ($invoices as $invoice) {
            $boxes_array = explode(",", $invoice->boxes_array);

            $invoice->total_qty = array_sum(explode(",", $invoice->item_weights));
            $return[$invoice->customer][] = $invoice;
        }
        return $return;
    }

    /*function get_invoice_qty_lbl($boxes_array = array())
    {
        $total_qty = 0;
        foreach ($boxes_array as $box_id) {
            $qty_details = $this->get_total_qty_lbl($box_id);
            $total_qty += $qty_details->tot_qty;
        }
        return $total_qty;
    }*/

    function get_cust_sales_reg_lbl($from_date = null, $to_date = null, $customer_id = null)
    {
        if (!empty($from_date)) {
            $this->db->where('invoice_date >=', $from_date);
        }
        if (!empty($to_date)) {
            $this->db->where('invoice_date <=',  $to_date);
        }
        if (!empty($customer_id)) {
            $this->db->where('customer', $customer_id);
        }

        $invoices = $this->db->get('bud_lbl_invoices')->result();

        $return = array();
        foreach ($invoices as $invoice) {
            $boxes_array = explode(",", $invoice->boxes_array);

            $invoice_items_row = explode(",", $invoice->invoice_items_row);
            $item_qty_array = array();
            foreach ($invoice_items_row as $key => $value) {
                $rows = explode("-", $value);
                $item_qty_array[] = $rows[2];
            }
            $invoice->total_qty = array_sum($item_qty_array);
            $return[$invoice->customer][] = $invoice;
        }
        return $return;
    }

    // Customer Packing Register Tapes and Elastic
    function get_cust_pack_reg_te($from_date, $to_date, $customer_id = null, $item_id = null)
    {
        $this->db->join('bud_te_items', 'bud_te_items.item_id = bud_te_outerboxes.packing_innerbox_items', 'inner');
        if (!empty($from_date)) {
            $this->db->where('packing_date >=', $from_date);
        }
        if (!empty($to_date)) {
            $this->db->where('packing_date <=',  $to_date);
        }
        if (!empty($item_id)) {
            $this->db->where('bud_te_items.item_id', $item_id);
        }
        if (!empty($customer_id)) {
            $this->db->where('packing_customer', $customer_id);
        }
        $box_details = $this->db->get('bud_te_outerboxes')->result();
        $return = array();
        foreach ($box_details as $box) {
            if ($box_details) {
                $return[$box->packing_customer][] = $box;
            }
        }
        return $return;
    }

    function get_stock_reg_te($from_date, $to_date, $customer_id = null, $item_id = null, $room_no = null, $lot_no = null)
    {
        $this->db->join('bud_te_items', 'bud_te_items.item_id = bud_te_outerboxes.packing_innerbox_items', 'inner');
        if (!empty($from_date)) {
            $this->db->where('packing_date >=', $from_date);
            //$this->db->like('packing_date', $from_date,"after");
        }
        if (!empty($to_date)) {
            $this->db->where('packing_date <',  $to_date);
        }
        if (!empty($item_id)) {
            $this->db->where('bud_te_items.item_id', $item_id);
        }
        if (!empty($customer_id)) {
            $this->db->where('packing_customer', $customer_id);
        }
        if (!empty($room_no)) {
            $this->db->where('packing_stock_room', $room_no);
        }

        if (!empty($lot_no)) {
            $this->db->where('dyed_lot_no', $lot_no);
        }
        $this->db->where('delivery_status', 0);
        $box_details = $this->db->get('bud_te_outerboxes')->result();
        //echo var_dump($box_details);

        $return = array();
        foreach ($box_details as $box) {
            if ($box_details) {
                $return[$box->packing_customer][] = $box;
            }
        }
        return $return;
    }
    // Customer Delivery Register Tapes
    function box_dc_no_te($box_id)
    {
        $this->db->where("FIND_IN_SET('$box_id',delivery_boxes) !=", 0);
        return $this->db->get('bud_te_delivery')->row();
    }
    function get_cust_delivery_reg_te($from_date, $to_date, $customer_id = null, $item_id = null)
    {
        $this->db->select('delivery_boxes,delivery_customer,delivery_id'); //ER-08-18#-30
        if (!empty($from_date)) {
            $this->db->where('delivery_date >=', $from_date);
        }
        if (!empty($to_date)) {
            $this->db->where('delivery_date <=',  $to_date);
        }
        if (!empty($customer_id)) {
            $this->db->where('delivery_customer', $customer_id);
        }
        $this->db->where('is_deleted', 1); //ER-08-18#-39
        $deliveries = $this->db->get('bud_te_delivery')->result();
        $delivery_boxes = array();
        foreach ($deliveries as $delivery) {
            $delivery_boxes[$delivery->delivery_customer][] = explode(",", $delivery->delivery_boxes);
        }

        $boxes_array = array();
        foreach ($delivery_boxes as $key => $value) {
            $boxes_array[$key] = call_user_func_array('array_merge', $value);
        }

        unset($delivery_boxes);

        $return = array();
        foreach ($boxes_array as $customer_id => $boxes) {
            foreach ($boxes as $box_id) {
                $this->db->join('bud_te_items', 'bud_te_items.item_id = bud_te_outerboxes.packing_innerbox_items');
                $this->db->where('box_no', $box_id);
                if (!empty($item_id)) {
                    $this->db->where('bud_te_items.item_id', $item_id);
                }
                $box_details = $this->db->get('bud_te_outerboxes')->row();
                if ($box_details) {
                    if ($box_details) {
                        $dc_no_result = $this->box_dc_no_te($box_id);

                        $box_details->dc_no = $dc_no_result->dc_no;
                        $box_details->delivery_id = $dc_no_result->delivery_id; //ER-08-18#-30
                        $box_details->delivery_date = $dc_no_result->delivery_date;
                        $return[$customer_id][] = $box_details;
                    }
                }
            }
        }
        return $return;
    }

    // Customer Invoice Register Tapes
    function box_invoice_no_te($box_id)
    {
        $this->db->where("FIND_IN_SET('$box_id',boxes_array) !=", 0);
        return $this->db->get('bud_te_invoices')->row();
    }
    function get_cust_invoice_reg_te($from_date, $to_date, $customer_id = null, $item_id = null)
    {
        $this->db->select('boxes_array,customer,invoice_no,invoice_id'); //ER-08-18#-33
        if (!empty($from_date)) {
            $this->db->where('invoice_date >=', $from_date);
        }
        if (!empty($to_date)) {
            $this->db->where('invoice_date <=',  $to_date);
        }

        if (!empty($customer_id)) {
            $this->db->where('customer', $customer_id);
        }
        $this->db->where('is_cancelled', 0); //ER-08-18#-33
        $deliveries = $this->db->get('bud_te_invoices')->result();
        $delivery_boxes = array();
        foreach ($deliveries as $delivery) {
            $delivery_boxes[$delivery->customer][] = explode(",", $delivery->boxes_array);
        }

        $boxes_array = array();
        foreach ($delivery_boxes as $key => $value) {
            $boxes_array[$key] = call_user_func_array('array_merge', $value);
        }

        unset($delivery_boxes);

        $return = array();
        foreach ($boxes_array as $customer_id => $boxes) {
            foreach ($boxes as $box_id) {
                $this->db->join('bud_te_items', 'bud_te_items.item_id = bud_te_outerboxes.packing_innerbox_items');
                $this->db->where('box_no', $box_id);
                if (!empty($item_id)) {
                    $this->db->where('bud_te_items.item_id', $item_id);
                }
                $box_details = $this->db->get('bud_te_outerboxes')->row();
                if ($box_details) {
                    if ($box_details) {
                        $invoice_no_result = $this->box_invoice_no_te($box_id);
                        // echo $invoice_no;   
                        $box_details->invoice_no = $invoice_no_result->invoice_no;
                        $box_details->invoice_id = $invoice_no_result->invoice_id; //ER-08-18#-33
                        $box_details->invoice_date = $invoice_no_result->invoice_date;
                        $return[$customer_id][] = $box_details;
                    }
                }
            }
        }
        return $return;
    }

    // Labels Report Function
    function get_total_qty_lbl($box_no)
    {
        $this->db->select('SUM(`total_qty`) as tot_qty');
        $this->db->where('box_no', $box_no);
        return $this->db->get('bud_lbl_outerbox_items')->row();
    }
    // Customer Packing Register Labels
    function get_cust_pack_reg_lbl($from_date, $to_date, $customer_id = null, $item_id = null)
    {

        $this->db->select('bud_lbl_outerboxes.*,bud_users.display_name');
        $this->db->join('bud_users', 'bud_users.ID = bud_lbl_outerboxes.operator_id');
        if (!empty($from_date)) {
            $this->db->where('date_time >=', $from_date);
        }
        if (!empty($to_date)) {
            $this->db->where('date_time <=',  $to_date);
        }
        if (!empty($item_id)) {
            $this->db->where('bud_lbl_outerboxes.item_id', $item_id);
        }
        $return = array();
        $box_details = $this->db->get('bud_lbl_outerboxes')->result();
        foreach ($box_details as $box) {
            $return[$box->item_id][] = $box;
        }

        return $return;
    }

    function get_stock_reg_lbl($from_date, $to_date, $customer_id = null, $item_id = null, $room = null)
    {

        $this->db->select('bud_lbl_outerboxes.*,bud_users.display_name');
        $this->db->join('bud_users', 'bud_users.ID = bud_lbl_outerboxes.operator_id');
        if (!empty($from_date)) {
            $this->db->where('date_time >=', $from_date);
        }
        if (!empty($to_date)) {
            $this->db->where('date_time <=',  $to_date);
        }
        if (!empty($item_id)) {
            $this->db->where('bud_lbl_outerboxes.item_id', $item_id);
        }
        if (!empty($room)) {
            $this->db->where('bud_lbl_outerboxes.packing_stock_room', $room);
        }
        $this->db->where('bud_lbl_outerboxes.delivery_status', 0);
        $return = array();
        $box_details = $this->db->get('bud_lbl_outerboxes')->result();
        // print_r($box_details);
        foreach ($box_details as $box) {
            $return[$box->item_id][] = $box;
        }

        return $return;
    }
    // Customer Delivery Register Tapes
    function box_dc_no_lbl($box_id)
    {
        $this->db->where("FIND_IN_SET('$box_id',delivery_boxes) !=", 0);
        return $this->db->get('bud_lbl_delivery')->row();
    }
    function get_cust_delivery_reg_lbl($from_date, $to_date, $customer_id = null, $item_id = null)
    {
        $this->db->select('delivery_boxes,delivery_customer');
        if (!empty($from_date)) {
            $this->db->where('delivery_date >=', $from_date);
        }
        if (!empty($to_date)) {
            $this->db->where('delivery_date <=',  $to_date);
        }
        if (!empty($customer_id)) {
            $this->db->where('delivery_customer', $customer_id);
        }
        $deliveries = $this->db->get('bud_lbl_delivery')->result();
        $delivery_boxes = array();
        foreach ($deliveries as $delivery) {
            $delivery_boxes[$delivery->delivery_customer][] = explode(",", $delivery->delivery_boxes);
        }

        $boxes_array = array();
        foreach ($delivery_boxes as $key => $value) {
            $boxes_array[$key] = call_user_func_array('array_merge', $value);
        }

        unset($delivery_boxes);

        $return = array();
        foreach ($boxes_array as $customer_id => $boxes) {
            foreach ($boxes as $box_id) {
                $this->db->join('bud_lbl_items', 'bud_lbl_items.item_id = bud_lbl_outerboxes.item_id');
                $this->db->where('box_no', $box_id);
                if (!empty($item_id)) {
                    $this->db->where('bud_lbl_items.item_id', $item_id);
                }
                $box_details = $this->db->get('bud_lbl_outerboxes')->row();
                if ($box_details) {
                    if ($box_details) {
                        $dc_no_result = $this->box_dc_no_lbl($box_id);
                        // echo $dc_no;   
                        $box_details->dc_no = $dc_no_result->dc_no;
                        $box_details->delivery_id = $dc_no_result->delivery_id; //partial delivery qty
                        $box_details->delivery_date = $dc_no_result->delivery_date;
                        $return[$customer_id][] = $box_details;
                    }
                }
            }
        }
        return $return;
    }

    // Customer Invoice Register Tapes
    function box_invoice_no_lbl($box_id)
    {
        $this->db->where("FIND_IN_SET('$box_id',boxes_array) !=", 0);
        $this->db->where('is_cancelled', 0); //ER-08-18#-34
        return $this->db->get('bud_lbl_invoices')->row();
    }
    function get_cust_invoice_reg_lbl($from_date, $to_date, $customer_id = null, $item_id = null)
    {
        $this->db->select('boxes_array,customer,invoice_no');
        if (!empty($from_date)) {
            $this->db->where('invoice_date >=', $from_date);
        }
        if (!empty($to_date)) {
            $this->db->where('invoice_date <=',  $to_date);
        }

        if (!empty($customer_id)) {
            $this->db->where('customer', $customer_id);
        }
        $deliveries = $this->db->get('bud_lbl_invoices')->result();
        $delivery_boxes = array();
        foreach ($deliveries as $delivery) {
            $delivery_boxes[$delivery->customer][] = explode(",", $delivery->boxes_array);
        }

        $boxes_array = array();
        foreach ($delivery_boxes as $key => $value) {
            $boxes_array[$key] = call_user_func_array('array_merge', $value);
        }

        unset($delivery_boxes);

        $return = array();
        foreach ($boxes_array as $customer_id => $boxes) {
            foreach ($boxes as $box_id) {
                $this->db->join('bud_lbl_items', 'bud_lbl_items.item_id = bud_lbl_outerboxes.item_id');
                $this->db->where('box_no', $box_id);
                if (!empty($item_id)) {
                    $this->db->where('bud_lbl_items.item_id', $item_id);
                }
                $box_details = $this->db->get('bud_lbl_outerboxes')->row();
                if ($box_details) {
                    if ($box_details) {
                        $invoice_no_result = $this->box_invoice_no_lbl($box_id);
                        // echo $invoice_no;   
                        $box_details->invoice_no = $invoice_no_result->invoice_no;
                        $box_details->invoice_id = $invoice_no_result->invoice_id; //partial delivery qty
                        $box_details->invoice_date = $invoice_no_result->invoice_date;
                        $return[$customer_id][] = $box_details;
                    }
                }
            }
        }
        return $return;
    }
    // End Sathya
    /* legrand charles */
    function getPackingCustomersYt($from_date, $to_date, $box_prefix = null, $customer_id = null)
    {

        if (!empty($customer_id)) {
            $str = '';
            $boxes = $this->m_reports->get_boxes_by_customer($customer_id);
            if ($boxes && !empty($boxes[0]->delivery_id)) {
                foreach ($boxes as $b) {
                    $str .= $b->delivery_boxes . ",";
                }
                $box_result = substr_replace($str, '', -1);
            }
        } else {
            $box_result = null;
        }

        $this->db->select('bud_yt_packing_boxes.*,bud_items.*,bud_yt_yarndeniers.denier_tech,bud_yt_poydeniers.denier_name as poy_denier_name,bud_shades.*');
        $this->db->from('bud_yt_packing_boxes');
        $this->db->join('bud_items', 'bud_items.item_id = bud_yt_packing_boxes.item_id', 'left');
        $this->db->join('bud_yt_yarndeniers', 'bud_yt_yarndeniers.denier_id = bud_yt_packing_boxes.yarn_denier', 'left');
        $this->db->join('bud_yt_poydeniers', 'bud_yt_poydeniers.denier_id = bud_yt_packing_boxes.poy_denier', 'left');
        $this->db->join('bud_shades', 'bud_shades.shade_id = bud_yt_packing_boxes.shade_no', 'left');
        if ($box_prefix != null) {
            $this->db->where('bud_yt_packing_boxes.box_prefix', $box_prefix);
        }
        if ($customer_id != null) {
            $this->db->where_in('bud_yt_packing_boxes.box_id', $box_result);
        }
        $this->db->where("DATE(bud_yt_packing_boxes.packed_date) BETWEEN '$from_date' AND '$to_date'");
        // $this->db->where('bud_yt_packing_boxes.delivery_status', 0);
        $this->db->order_by('bud_yt_packing_boxes.lot_no', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_boxes_by_customer($customer_id)
    {
        $this->db->select('delivery_id,delivery_boxes');
        $this->db->from('bud_yt_delivery');
        $this->db->where('bud_yt_delivery.delivery_is_deleted', 1); //ER-09-18#-58
        $this->db->where('delivery_customer', $customer_id);
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result(); //if data is true
        } else {
            return false; //if data is wrong
        }
    }

    function getDeletedBoxesYt($from_date, $to_date, $box_prefix = null)
    {
        $this->db->select('bud_yt_packing_boxes.*,bud_items.*,bud_users.display_name as deleted_by_name,bud_yt_yarndeniers.denier_tech,bud_yt_poydeniers.denier_name as poy_denier_name,bud_shades.*');
        $this->db->from('bud_yt_packing_boxes');
        $this->db->join('bud_items', 'bud_items.item_id = bud_yt_packing_boxes.item_id', 'left');
        $this->db->join('bud_yt_yarndeniers', 'bud_yt_yarndeniers.denier_id = bud_yt_packing_boxes.yarn_denier', 'left');
        $this->db->join('bud_yt_poydeniers', 'bud_yt_poydeniers.denier_id = bud_yt_packing_boxes.poy_denier', 'left');
        $this->db->join('bud_shades', 'bud_shades.shade_id = bud_yt_packing_boxes.shade_no', 'left');
        $this->db->join('bud_users', 'bud_users.ID = bud_yt_packing_boxes.deleted_by', 'left');
        if ($box_prefix != null) {
            $this->db->where('bud_yt_packing_boxes.box_prefix', $box_prefix);
        }
        $this->db->where("DATE(bud_yt_packing_boxes.packed_date) BETWEEN '$from_date' AND '$to_date'");
        $this->db->where('bud_yt_packing_boxes.is_deleted', 1);
        $this->db->order_by('bud_yt_packing_boxes.lot_no', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    function getItemsDeliveryRegisterYt($from_date, $to_date, $box_prefix = null, $item_id = null)
    {
        $this->db->select('bud_yt_packing_boxes.*,bud_items.*,bud_yt_yarndeniers.denier_tech,bud_yt_poydeniers.denier_name as poy_denier_name,bud_shades.*');
        $this->db->from('bud_yt_packing_boxes');
        $this->db->join('bud_items', 'bud_items.item_id = bud_yt_packing_boxes.item_id', 'left');
        $this->db->join('bud_yt_yarndeniers', 'bud_yt_yarndeniers.denier_id = bud_yt_packing_boxes.yarn_denier', 'left');
        $this->db->join('bud_yt_poydeniers', 'bud_yt_poydeniers.denier_id = bud_yt_packing_boxes.poy_denier', 'left');
        $this->db->join('bud_shades', 'bud_shades.shade_id = bud_yt_packing_boxes.shade_no', 'left');
        if ($box_prefix != null) {
            $this->db->where('bud_yt_packing_boxes.box_prefix', $box_prefix);
        }
        if ($item_id != null) {
            $this->db->where('bud_yt_packing_boxes.item_id', $item_id);
        }
        $this->db->where("DATE(bud_yt_packing_boxes.packed_date) BETWEEN '$from_date' AND '$to_date'");
        $this->db->where('bud_yt_packing_boxes.delivery_status', 0);
        $this->db->order_by('bud_yt_packing_boxes.lot_no', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    function getCustomersDeliveryRegisterYt($from_date, $to_date, $box_prefix = null, $customer_id = null)
    {

        if (!empty($customer_id)) {
            $str = '';
            $boxes = $this->m_reports->get_boxes_by_customer($customer_id);
            if ($boxes && !empty($boxes[0]->delivery_id)) {
                foreach ($boxes as $b) {
                    $str .= $b->delivery_boxes . ",";
                }
                $box_result = substr_replace($str, '', -1);
            } else {
                $box_result = null;
            }
        }

        $this->db->select('bud_yt_packing_boxes.*,bud_items.*,bud_yt_yarndeniers.denier_tech,bud_yt_poydeniers.denier_name as poy_denier_name,bud_shades.*');
        $this->db->from('bud_yt_packing_boxes');
        $this->db->join('bud_items', 'bud_items.item_id = bud_yt_packing_boxes.item_id', 'left');
        $this->db->join('bud_yt_yarndeniers', 'bud_yt_yarndeniers.denier_id = bud_yt_packing_boxes.yarn_denier', 'left');
        $this->db->join('bud_yt_poydeniers', 'bud_yt_poydeniers.denier_id = bud_yt_packing_boxes.poy_denier', 'left');
        $this->db->join('bud_shades', 'bud_shades.shade_id = bud_yt_packing_boxes.shade_no', 'left');
        if ($box_prefix != null) {
            $this->db->where('bud_yt_packing_boxes.box_prefix', $box_prefix);
        }
        if ($customer_id != null) {
            $this->db->where_in('bud_yt_packing_boxes.box_id', $box_result);
        }
        if ($customer_id != null && empty($box_result)) {
            $this->db->where('bud_yt_packing_boxes.box_id', NULL);
        }
        $this->db->where("DATE(bud_yt_packing_boxes.packed_date) BETWEEN '$from_date' AND '$to_date'");
        $this->db->where('bud_yt_packing_boxes.delivery_status', 0);
        $this->db->order_by('bud_yt_packing_boxes.lot_no', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }


    function get_boxes_from_invoice($status)
    {
        $this->db->select('invoice_id,boxes_array');
        $this->db->from('bud_yt_invoices');
        $this->db->where('is_cancelled', $status);
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result(); //if data is true
        } else {
            return false; //if data is wrong
        }
    }

    function get_boxes_from_invoice_by_customer($customer_id, $status)
    {
        $this->db->select('invoice_id,boxes_array');
        $this->db->from('bud_yt_invoices');
        $this->db->where('is_cancelled', $status);
        $this->db->where('customer', $customer_id);
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result(); //if data is true
        } else {
            return false; //if data is wrong
        }
    }

    function getItemsInvoiceRegisterYt($from_date, $to_date, $box_prefix = null, $item_id = null)
    {

        $str = '';
        $boxes = $this->m_reports->get_boxes_from_invoice('0');
        if ($boxes && !empty($boxes[0]->invoice_id)) {
            foreach ($boxes as $b) {
                $str .= $b->boxes_array . ",";
            }
            $box_result = substr_replace($str, '', -1);
        } else {
            $box_result = null;
        }


        $this->db->select('bud_yt_packing_boxes.*,bud_items.*,bud_yt_yarndeniers.denier_tech,bud_yt_poydeniers.denier_name as poy_denier_name,bud_shades.*');
        $this->db->from('bud_yt_packing_boxes');
        $this->db->join('bud_items', 'bud_items.item_id = bud_yt_packing_boxes.item_id', 'left');
        $this->db->join('bud_yt_yarndeniers', 'bud_yt_yarndeniers.denier_id = bud_yt_packing_boxes.yarn_denier', 'left');
        $this->db->join('bud_yt_poydeniers', 'bud_yt_poydeniers.denier_id = bud_yt_packing_boxes.poy_denier', 'left');
        $this->db->join('bud_shades', 'bud_shades.shade_id = bud_yt_packing_boxes.shade_no', 'left');
        if ($box_prefix != null) {
            $this->db->where('bud_yt_packing_boxes.box_prefix', $box_prefix);
        }
        if ($item_id != null) {
            $this->db->where('bud_yt_packing_boxes.item_id', $item_id);
        }
        if (!empty($box_result)) {
            $this->db->where_in('bud_yt_packing_boxes.box_id', $box_result);
        } else {
            $this->db->where('bud_yt_packing_boxes.box_id', NULL);
        }
        $this->db->where("DATE(bud_yt_packing_boxes.packed_date) BETWEEN '$from_date' AND '$to_date'");
        $this->db->where('bud_yt_packing_boxes.delivery_status', 0);
        $this->db->order_by('bud_yt_packing_boxes.lot_no', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }


    function getCustomersInvoiceRegisterYt($from_date, $to_date, $box_prefix = null, $customer_id = null)
    {

        if (!empty($customer_id)) {
            $str = '';
            $boxes = $this->m_reports->get_boxes_from_invoice_by_customer($customer_id, '0');
            if ($boxes && !empty($boxes[0]->invoice_id)) {
                foreach ($boxes as $b) {
                    $str .= $b->boxes_array . ",";
                }
                $box_result = substr_replace($str, '', -1);
            } else {
                $box_result = null;
            }
        } else {
            $str = '';
            $boxes = $this->m_reports->get_boxes_from_invoice('0');
            if ($boxes && !empty($boxes[0]->invoice_id)) {
                foreach ($boxes as $b) {
                    $str .= $b->boxes_array . ",";
                }
                $box_result = substr_replace($str, '', -1);
            } else {
                $box_result = null;
            }
        }

        $this->db->select('bud_yt_packing_boxes.*,bud_items.*,bud_yt_yarndeniers.denier_tech,bud_yt_poydeniers.denier_name as poy_denier_name,bud_shades.*');
        $this->db->from('bud_yt_packing_boxes');
        $this->db->join('bud_items', 'bud_items.item_id = bud_yt_packing_boxes.item_id', 'left');
        $this->db->join('bud_yt_yarndeniers', 'bud_yt_yarndeniers.denier_id = bud_yt_packing_boxes.yarn_denier', 'left');
        $this->db->join('bud_yt_poydeniers', 'bud_yt_poydeniers.denier_id = bud_yt_packing_boxes.poy_denier', 'left');
        $this->db->join('bud_shades', 'bud_shades.shade_id = bud_yt_packing_boxes.shade_no', 'left');
        if ($box_prefix != null) {
            $this->db->where('bud_yt_packing_boxes.box_prefix', $box_prefix);
        }
        if ($customer_id != null) {
            $this->db->where_in('bud_yt_packing_boxes.box_id', $box_result);
        }
        if (empty($box_result)) {
            $this->db->where('bud_yt_packing_boxes.box_id', NULL);
        }
        $this->db->where("DATE(bud_yt_packing_boxes.packed_date) BETWEEN '$from_date' AND '$to_date'");
        $this->db->where('bud_yt_packing_boxes.delivery_status', 0);
        $this->db->order_by('bud_yt_packing_boxes.lot_no', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    /* legrand charles */
    function getDeletedItemsYt($from_date, $to_date, $box_prefix = null, $item_id = null)
    {
        $this->db->select('bud_yt_packing_boxes.*,bud_items.*,bud_yt_yarndeniers.denier_tech,bud_yt_poydeniers.denier_name as poy_denier_name,bud_shades.*');
        $this->db->from('bud_yt_packing_boxes');
        $this->db->join('bud_items', 'bud_items.item_id = bud_yt_packing_boxes.item_id', 'left');
        $this->db->join('bud_yt_yarndeniers', 'bud_yt_yarndeniers.denier_id = bud_yt_packing_boxes.yarn_denier', 'left');
        $this->db->join('bud_yt_poydeniers', 'bud_yt_poydeniers.denier_id = bud_yt_packing_boxes.poy_denier', 'left');
        $this->db->join('bud_shades', 'bud_shades.shade_id = bud_yt_packing_boxes.shade_no', 'left');
        if ($box_prefix != null) {
            $this->db->where('bud_yt_packing_boxes.box_prefix', $box_prefix);
        }
        if ($item_id != null) {
            $this->db->where('bud_yt_packing_boxes.item_id', $item_id);
        }
        $this->db->where("DATE(bud_yt_packing_boxes.packed_date) BETWEEN '$from_date' AND '$to_date'");
        $this->db->where('bud_yt_packing_boxes.is_deleted', 1);
        $query = $this->db->get();
        return $query->result_array();
    }
    function deleteBoxes($tablename, $column_id, $id)
    {
        $this->db->where_in($column_id, $id);
        $this->db->delete($tablename);
        return true;
    }
    function getCustDelBoxes($customer_id)
    {
        $this->db->select('delivery_boxes')
            ->from('bud_yt_delivery')
            ->where('bud_yt_delivery.delivery_is_deleted', 1) //ER-09-18#-58
            ->where('delivery_customer', $customer_id);
        $query = $this->db->get();
        return $query->result_array();
    }


    /*legrand charles */
    function getPackingCustomersTe($from_date, $to_date, $customer_id = null)
    {
        $this->db->select('*')
            ->from('bud_te_outerboxes')
            ->join('bud_te_items', 'bud_te_outerboxes.packing_innerbox_items = bud_te_items.item_id', 'Inner')
            ->join('bud_customers', 'bud_te_outerboxes.packing_customer = bud_customers.cust_id', 'Inner')
            ->where("DATE(bud_te_outerboxes.packing_date) BETWEEN '$from_date' AND '$to_date'");
        if (!empty($customer_id)) {
            $this->db->where('bud_te_outerboxes.packing_customer', $customer_id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    //to include itemgroup filter in packing register
    function getPackingTe($where_array = array())
    {
        $from_date = $where_array['from_date'];
        $to_date = $where_array['to_date'];
        $this->db->select('*')
            ->from('bud_te_outerboxes')
            ->join('bud_te_items', 'bud_te_outerboxes.packing_innerbox_items = bud_te_items.item_id', 'Inner')
            ->join('bud_te_itemgroups', 'bud_te_items.item_group = bud_te_itemgroups.group_id', 'Inner')
            ->where("DATE(bud_te_outerboxes.packing_date) BETWEEN '$from_date' AND '$to_date'");
        if ($where_array['item_group_id']) {
            $this->db->where('bud_te_items.item_group', $where_array['item_group_id']);
        }
        if ($where_array['item_id']) {
            $this->db->where('bud_te_items.item_id', $where_array['item_id']);
        }
        $query = $this->db->get();
        return $query->result_array();
    }
    //end of to include itemgroup filter in packing register
    function getDeletedBoxesTe($from_date, $to_date)
    {
        $this->db->select('*,bud_users.display_name as deleted_by_name, packed_users.display_name as packed_by_name')
            ->from('bud_te_outerboxes_deleted')
            ->join('bud_te_items', 'bud_te_outerboxes_deleted.packing_innerbox_items = bud_te_items.item_id', 'left')
            ->join('bud_customers', 'bud_te_outerboxes_deleted.packing_customer = bud_customers.cust_id', 'left')
            ->join('bud_users', 'bud_te_outerboxes_deleted.deleted_by = bud_users.ID', 'left')
            ->join('bud_users as packed_users', 'bud_te_outerboxes_deleted.packing_by = packed_users.ID', 'left')
            ->where("DATE(bud_te_outerboxes_deleted.packing_date) BETWEEN '$from_date' AND '$to_date'");
        $query = $this->db->get();
        return $query->result_array();
    }

    function getItemsDeliveryRegisterTe($from_date, $to_date, $item_id = null)
    {
        $this->db->select('*')
            ->from('bud_te_outerboxes')
            ->join('bud_te_items', 'bud_te_outerboxes.packing_innerbox_items = bud_te_items.item_id', 'Inner')
            ->where("DATE(bud_te_outerboxes.packing_date) BETWEEN '$from_date' AND '$to_date'");
        if (!empty($item_id)) {
            $this->db->where('bud_te_outerboxes.packing_innerbox_items', $item_id);
        }
        $this->db->where('bud_te_outerboxes.delivery_status', '0');
        $query = $this->db->get();
        return $query->result_array();
    }

    function getCustomersDeliveryRegisterTe($from_date, $to_date, $customer_id = null)
    {

        if (!empty($customer_id)) {
            $str = '';
            $boxes = $this->m_reports->get_boxes_from_te_delivery_by_customer($customer_id);
            if ($boxes && !empty($boxes[0]->delivery_id)) {
                foreach ($boxes as $b) {
                    $str .= $b->delivery_boxes . ",";
                }
                $box_result = substr_replace($str, '', -1);
            } else {
                $box_result = null;
            }
        }


        $this->db->select('*')
            ->from('bud_te_outerboxes')
            ->join('bud_te_items', 'bud_te_outerboxes.packing_innerbox_items = bud_te_items.item_id', 'Inner')
            ->join('bud_customers', 'bud_te_outerboxes.packing_customer = bud_customers.cust_id', 'Inner')
            ->where("DATE(bud_te_outerboxes.packing_date) BETWEEN '$from_date' AND '$to_date'");
        if (!empty($customer_id)) {
            $this->db->where_in('bud_te_outerboxes.box_no', $box_result);
        }
        if ($customer_id != null && empty($box_result)) {
            $this->db->where('bud_te_outerboxes.box_no', NULL);
        }
        $this->db->where('bud_te_outerboxes.delivery_status', '1');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_boxes_from_te_delivery_by_customer($customer_id)
    {
        $this->db->select('delivery_id,delivery_boxes');
        $this->db->from('bud_te_delivery');
        $this->db->where('delivery_customer', $customer_id);
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result(); //if data is true
        } else {
            return false; //if data is wrong
        }
    }


    function getItemsInvoiceRegisterTe($from_date, $to_date, $item_id = null)
    {

        $str = '';
        $boxes = $this->m_reports->get_boxes_from_te_invoice('0');
        if ($boxes && !empty($boxes[0]->invoice_id)) {
            foreach ($boxes as $b) {
                $str .= $b->boxes_array . ",";
            }
            $box_result = substr_replace($str, '', -1);
        } else {
            $box_result = null;
        }


        $this->db->select('*')
            ->from('bud_te_outerboxes')
            ->join('bud_te_items', 'bud_te_outerboxes.packing_innerbox_items = bud_te_items.item_id', 'Inner')
            ->join('bud_customers', 'bud_te_outerboxes.packing_customer = bud_customers.cust_id', 'Inner')
            ->where("DATE(bud_te_outerboxes.packing_date) BETWEEN '$from_date' AND '$to_date'");
        if (!empty($box_result)) {
            $this->db->where_in('bud_te_outerboxes.box_no', $box_result);
        }
        if ($item_id != null) {
            $this->db->where('bud_te_outerboxes.packing_innerbox_items', $item_id);
        }
        $this->db->where('bud_te_outerboxes.delivery_status', '1');
        $query = $this->db->get();
        return $query->result_array();
    }


    function getCustomersInvoiceRegisterTe($from_date, $to_date, $customer_id = null)
    {

        if (!empty($customer_id)) {
            $str = '';
            $boxes = $this->m_reports->get_boxes_from_te_invoice_by_customer($customer_id, '0');
            if ($boxes && !empty($boxes[0]->invoice_id)) {
                foreach ($boxes as $b) {
                    $str .= $b->boxes_array . ",";
                }
                $box_result = substr_replace($str, '', -1);
            } else {
                $box_result = null;
            }
        } else {
            $str = '';
            $boxes = $this->m_reports->get_boxes_from_te_invoice('0');
            if ($boxes && !empty($boxes[0]->invoice_id)) {
                foreach ($boxes as $b) {
                    $str .= $b->boxes_array . ",";
                }
                $box_result = substr_replace($str, '', -1);
            } else {
                $box_result = null;
            }
        }


        $this->db->select('*')
            ->from('bud_te_outerboxes')
            ->join('bud_te_items', 'bud_te_outerboxes.packing_innerbox_items = bud_te_items.item_id', 'Inner')
            ->join('bud_customers', 'bud_te_outerboxes.packing_customer = bud_customers.cust_id', 'Inner')
            ->where("DATE(bud_te_outerboxes.packing_date) BETWEEN '$from_date' AND '$to_date'");
        if (!empty($customer_id)) {
            $this->db->where_in('bud_te_outerboxes.box_no', $box_result);
        }
        if (empty($box_result)) {
            $this->db->where('bud_te_outerboxes.box_no', NULL);
        } else {
            $this->db->where('bud_te_outerboxes.box_no', $box_result);
        }
        $this->db->where('bud_te_outerboxes.delivery_status', '1');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_boxes_from_te_invoice($status)
    {
        $this->db->select('invoice_id,boxes_array');
        $this->db->from('bud_te_invoices');
        $this->db->where('is_cancelled', $status);
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result(); //if data is true
        } else {
            return false; //if data is wrong
        }
    }

    function get_boxes_from_te_invoice_by_customer($customer_id, $status)
    {
        $this->db->select('invoice_id,boxes_array');
        $this->db->from('bud_te_invoices');
        $this->db->where('is_cancelled', $status);
        $this->db->where('customer', $customer_id);
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result(); //if data is true
        } else {
            return false; //if data is wrong
        }
    }

    /*legrand charles */

    /* legrand charles (label) */
    function getPackingItemsLbl($from_date, $to_date, $box_prefix = null, $item_id = null, $item_group_id = null, $boxes = null)
    {
        $this->db->select('bud_lbl_outerboxes.*');
        $this->db->select('bud_lbl_items.item_name');
        $this->db->select('bud_users.user_nicename');
        $this->db->select('bud_lbl_itemgroups.group_name');
        $this->db->select('bud_uoms.uom_name');
        $this->db->from('bud_lbl_outerboxes');
        $this->db->join('bud_lbl_items', 'bud_lbl_items.item_id = bud_lbl_outerboxes.item_id', 'INNER');
        $this->db->join('bud_users', 'bud_lbl_outerboxes.operator_id = bud_users.ID', 'INNER');
        $this->db->join('bud_lbl_itemgroups', 'bud_lbl_items.item_group = bud_lbl_itemgroups.group_id', 'INNER');
        $this->db->join('bud_uoms', 'bud_lbl_outerboxes.packing_uom = bud_uoms.uom_id', 'INNER');
        if ($box_prefix != null) {
            $this->db->where('bud_lbl_outerboxes.box_prefix', $box_prefix);
        }
        if ($item_id != null) {
            $this->db->where('bud_lbl_outerboxes.item_id', $item_id);
        }
        if ($item_group_id != null) {
            $this->db->where('item_group', $item_group_id);
        }
        if ($boxes != null) {
            $this->db->where_in('box_no', $boxes);
        }
        if ($from_date) {
            $this->db->where("bud_lbl_outerboxes.date_time >=", $from_date);
        }
        if ($to_date) {
            $this->db->where("bud_lbl_outerboxes.date_time <=", $to_date);
        }
        $this->db->where("bud_lbl_outerboxes.is_deleted", 0); //partial delivery qty
        $this->db->order_by('bud_lbl_outerboxes.box_no', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }
    function getBoxStatusLbl($f_box = null, $t_box = null, $boxes = null)
    {
        $this->db->select('bud_lbl_outerboxes.*');
        $this->db->select('bud_lbl_items.item_name');
        $this->db->select('bud_users.user_nicename');
        $this->db->select('bud_lbl_itemgroups.group_name');
        $this->db->select('bud_uoms.uom_name');
        $this->db->from('bud_lbl_outerboxes');
        $this->db->join('bud_lbl_items', 'bud_lbl_items.item_id = bud_lbl_outerboxes.item_id', 'INNER');
        $this->db->join('bud_users', 'bud_lbl_outerboxes.operator_id = bud_users.ID', 'INNER');
        $this->db->join('bud_lbl_itemgroups', 'bud_lbl_items.item_group = bud_lbl_itemgroups.group_id', 'INNER');
        $this->db->join('bud_uoms', 'bud_lbl_outerboxes.packing_uom = bud_uoms.uom_id', 'INNER');
        if ($f_box) {
            $this->db->where('box_no >=', $f_box);
        }
        if ($t_box) {

            $this->db->where('box_no <=', $t_box);
        }
        if ($boxes) {
            $this->db->where_in('box_no', $boxes);
        }
        $this->db->order_by('bud_lbl_outerboxes.box_no', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }
    function getPackingCustomersLbl($from_date, $to_date, $box_prefix = null, $customer_id = null)
    {

        if (!empty($customer_id)) {
            $str = '';
            $boxes = $this->m_reports->get_boxes_by_customer_Lbl($customer_id);
            if ($boxes && !empty($boxes[0]->delivery_id)) {
                foreach ($boxes as $b) {
                    $str .= $b->delivery_boxes . ",";
                }
                $box_result = substr_replace($str, '', -1);
            }
        } else {
            $box_result = null;
        }

        $this->db->select('*');
        $this->db->from('bud_lbl_outerboxes');
        $this->db->join('bud_lbl_items', 'bud_lbl_items.item_id = bud_lbl_outerboxes.item_id', 'INNER');
        if ($box_prefix != null) {
            $this->db->where('bud_lbl_outerboxes.box_prefix', $box_prefix);
        }
        if ($customer_id != null) {
            $this->db->where_in('bud_lbl_outerboxes.box_no', $box_result);
        }
        $this->db->where("DATE(bud_lbl_outerboxes.date_time) BETWEEN '$from_date' AND '$to_date'");
        $this->db->order_by('bud_lbl_outerboxes.box_no', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_boxes_by_customer_Lbl($customer_id)
    {
        $this->db->select('delivery_id,delivery_boxes');
        $this->db->from('bud_lbl_delivery');
        $this->db->where('delivery_customer', $customer_id);
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result(); //if data is true
        } else {
            return false; //if data is wrong
        }
    }

    function getDeletedBoxesLbl($from_date, $to_date, $box_prefix = null, $item_id = false)
    {
        $this->db->select('*,bud_users.display_name as deleted_by_name, packed_users.display_name as packed_by_name');
        $this->db->from('bud_lbl_outerboxes');
        $this->db->join('bud_lbl_items', 'bud_lbl_items.item_id = bud_lbl_outerboxes.item_id', 'INNER');
        $this->db->join('bud_users', 'bud_users.ID = bud_lbl_outerboxes.deleted_by', 'left');
        $this->db->join('bud_users packed_users', 'packed_users.ID = bud_lbl_outerboxes.operator_id', 'left');
        if ($box_prefix != null) {
            $this->db->where('bud_lbl_outerboxes.box_prefix', $box_prefix);
        }
        $this->db->where("bud_lbl_outerboxes.date_time >=", $from_date);
        $this->db->where("bud_lbl_outerboxes.date_time <=", $to_date);
        if (!empty($item_id)) {
            $this->db->where('bud_lbl_outerboxes.item_id', $item_id);
        }
        $this->db->where('bud_lbl_outerboxes.is_deleted', 1);
        $this->db->order_by('bud_lbl_outerboxes.box_no', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    function getItemsDeliveryRegisterLbl($from_date, $to_date, $box_prefix = null, $item_id = null)
    {
        $this->db->select('*');
        $this->db->from('bud_lbl_outerboxes');
        $this->db->join('bud_lbl_items', 'bud_lbl_items.item_id = bud_lbl_outerboxes.item_id', 'INNER');
        if ($box_prefix != null) {
            $this->db->where('bud_lbl_outerboxes.box_prefix', $box_prefix);
        }
        if ($item_id != null) {
            $this->db->where('bud_lbl_outerboxes.item_id', $item_id);
        }
        $this->db->where("DATE(bud_lbl_outerboxes.date_time) BETWEEN '$from_date' AND '$to_date'");
        $this->db->where('bud_lbl_outerboxes.delivery_status', 1);
        $this->db->order_by('bud_lbl_outerboxes.box_no', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    function getCustomersDeliveryRegisterLbl($from_date, $to_date, $box_prefix = null, $customer_id = null)
    {

        if (!empty($customer_id)) {
            $str = '';
            $boxes = $this->m_reports->get_boxes_by_customer_Lbl($customer_id);
            if ($boxes && !empty($boxes[0]->delivery_id)) {
                foreach ($boxes as $b) {
                    $str .= $b->delivery_boxes . ",";
                }
                $box_result = substr_replace($str, '', -1);
            }
        } else {
            $box_result = null;
        }

        $this->db->select('*');
        $this->db->from('bud_lbl_outerboxes');
        $this->db->join('bud_lbl_items', 'bud_lbl_items.item_id = bud_lbl_outerboxes.item_id', 'INNER');
        if ($box_prefix != null) {
            $this->db->where('bud_lbl_outerboxes.box_prefix', $box_prefix);
        }
        if ($customer_id != null) {
            $this->db->where_in('bud_lbl_outerboxes.box_no', $box_result);
        }
        $this->db->where("DATE(bud_lbl_outerboxes.date_time) BETWEEN '$from_date' AND '$to_date'");
        $this->db->where('bud_lbl_outerboxes.delivery_status', 1);
        $this->db->order_by('bud_lbl_outerboxes.box_no', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }


    function get_boxes_from_invoice_lbl($status)
    {
        $this->db->select('invoice_id,boxes_array');
        $this->db->from('bud_lbl_invoices');
        $this->db->where('is_cancelled', $status);
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result(); //if data is true
        } else {
            return false; //if data is wrong
        }
    }

    function get_boxes_from_invoice_by_customer_Lbl($customer_id, $status)
    {
        $this->db->select('invoice_id,boxes_array');
        $this->db->from('bud_lbl_invoices');
        $this->db->where('is_cancelled', $status);
        $this->db->where('customer', $customer_id);
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->result(); //if data is true
        } else {
            return false; //if data is wrong
        }
    }

    function getItemsInvoiceRegisterLbl($from_date, $to_date, $box_prefix = null, $item_id = null)
    {

        $str = '';
        $boxes = $this->m_reports->get_boxes_from_invoice_Lbl('0');
        if ($boxes && !empty($boxes[0]->invoice_id)) {
            foreach ($boxes as $b) {
                $str .= $b->boxes_array . ",";
            }
            $box_result = substr_replace($str, '', -1);
        } else {
            $box_result = null;
        }


        $this->db->select('*');
        $this->db->from('bud_lbl_outerboxes');
        $this->db->join('bud_lbl_items', 'bud_lbl_items.item_id = bud_lbl_outerboxes.item_id', 'INNER');
        if ($box_prefix != null) {
            $this->db->where('bud_lbl_outerboxes.box_prefix', $box_prefix);
        }
        if ($item_id != null) {
            $this->db->where('bud_lbl_outerboxes.item_id', $item_id);
        }
        if (!empty($box_result)) {
            $this->db->where_in('bud_lbl_outerboxes.box_no', $box_result);
        } else {
            $this->db->where('bud_lbl_outerboxes.box_no', NULL);
        }
        $this->db->where("DATE(bud_lbl_outerboxes.date_time) BETWEEN '$from_date' AND '$to_date'");
        $this->db->where('bud_lbl_outerboxes.delivery_status', 1);
        $this->db->order_by('bud_lbl_outerboxes.box_no', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }


    function getCustomersInvoiceRegisterLbl($from_date, $to_date, $box_prefix = null, $customer_id = null)
    {

        if (!empty($customer_id)) {
            $str = '';
            $boxes = $this->m_reports->get_boxes_from_invoice_by_customer_Lbl($customer_id, '0');
            if ($boxes && !empty($boxes[0]->invoice_id)) {
                foreach ($boxes as $b) {
                    $str .= $b->boxes_array . ",";
                }
                $box_result = substr_replace($str, '', -1);
            } else {
                $box_result = null;
            }
        } else {
            $str = '';
            $boxes = $this->m_reports->get_boxes_from_invoice('0');
            if ($boxes && !empty($boxes[0]->invoice_id)) {
                foreach ($boxes as $b) {
                    $str .= $b->boxes_array . ",";
                }
                $box_result = substr_replace($str, '', -1);
            } else {
                $box_result = null;
            }
        }

        $this->db->select('*');
        $this->db->from('bud_lbl_outerboxes');
        $this->db->join('bud_lbl_items', 'bud_lbl_items.item_id = bud_lbl_outerboxes.item_id', 'INNER');
        if ($box_prefix != null) {
            $this->db->where('bud_lbl_outerboxes.box_prefix', $box_prefix);
        }
        if ($customer_id != null) {
            $this->db->where_in('bud_lbl_outerboxes.box_no', $box_result);
        }
        if (empty($box_result)) {
            $this->db->where('bud_lbl_outerboxes.box_no', NULL);
        }
        $this->db->where("DATE(bud_lbl_outerboxes.date_time) BETWEEN '$from_date' AND '$to_date'");
        $this->db->where('bud_lbl_outerboxes.delivery_status', 1);
        $this->db->order_by('bud_lbl_outerboxes.box_no', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }


    function getDeletedItemsLbl($from_date, $to_date, $box_prefix = null, $item_id = null)
    {
        $this->db->select('*,bud_users.display_name as deleted_by_name');
        $this->db->from('bud_lbl_outerboxes');
        $this->db->join('bud_lbl_items', 'bud_lbl_items.item_id = bud_lbl_outerboxes.item_id', 'INNER');
        $this->db->join('bud_users', 'bud_users.ID = bud_lbl_outerboxes.deleted_by', 'left');
        if ($box_prefix != null) {
            $this->db->where('bud_lbl_outerboxes.box_prefix', $box_prefix);
        }
        if ($item_id != null) {
            $this->db->where('bud_lbl_outerboxes.item_id', $item_id);
        }
        $this->db->where("DATE(bud_lbl_outerboxes.date_time) BETWEEN '$from_date' AND '$to_date'");
        $this->db->where('bud_lbl_outerboxes.is_deleted', 1);
        $this->db->order_by('bud_lbl_outerboxes.box_no', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    function getCustDelBoxes_Lbl($customer_id)
    {
        $this->db->select('delivery_boxes')
            ->from('bud_yt_delivery')
            ->where('bud_yt_delivery.delivery_is_deleted', 1) //ER-09-18#-58
            ->where('delivery_customer', $customer_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    // dyes_cost_reg
    function get_dyes_cost_reg($from_date = false, $to_date = false, $lot_prefix = false, $lot_id = false)
    {
        $this->db->join('bud_machines', 'bud_lots.lot_prefix = bud_machines.machine_id', 'left');
        if (!empty($from_date) && !empty($to_date)) {
            $this->db->where("lot_created_date between '$from_date' and '$to_date'");
        }
        if (!empty($lot_prefix)) {
            $this->db->where('lot_prefix', $lot_prefix);
        }
        if (!empty($lot_id)) {
            $this->db->where('lot_id', $lot_id);
        }
        return $this->db->get('bud_lots')->result();
    }
    function get_recipe_details($shade_id)
    {
        return $this->db->get_where('bud_recipe_master', array('shade_id' => $shade_id))->row();
    }
    function get_dyes_chemical($dyes_chem_id)
    {
        return $this->db->get_where('bud_dyes_chemicals', array('dyes_chem_id' => $dyes_chem_id))->row();
    }
    /* End legrand charles (label) */

    function get_invoic_gr_wt_te($selected_dc = array())
    {
        $total_gr_weight = 0.000;
        if (count($selected_dc) > 0) {
            foreach ($selected_dc as $delivery_id) {
                $boxes = $this->db->get_where('bud_te_delivery', array('delivery_id' => $delivery_id))->row();
                $delivery_boxes = explode(",", $boxes->delivery_boxes);
                foreach ($delivery_boxes as $box_no) {
                    $box = $this->db->get_where('bud_te_outerboxes', array('box_no' => $box_no))->row();
                    $total_gr_weight += $box->packing_gr_weight;
                }
            }
        }
        return $total_gr_weight;
    }

    function get_invoic_gr_wt_lbl($selected_dc = array())
    {
        $total_gr_weight = 0.000;
        if (count($selected_dc) > 0) {
            foreach ($selected_dc as $delivery_id) {
                $boxes = $this->db->get_where('bud_lbl_delivery', array('delivery_id' => $delivery_id))->row();
                $delivery_boxes = explode(",", $boxes->delivery_boxes);
                foreach ($delivery_boxes as $box_no) {
                    $box = $this->db->get_where('bud_lbl_outerboxes', array('box_no' => $box_no))->row();
                    $total_gr_weight += $box->packing_gr_weight;
                }
            }
        }
        return $total_gr_weight;
    }

    function get_poy_opening_stock($poy_lot_id)
    {
        $current_date = date("Y-m-d H:i:s");
        $this->db->where('poy_lot_id', $poy_lot_id);
        $this->db->where('updated_date <=', $current_date);
        // $this->db->order_by('abs('.$current_date.' - updated_date)', 'asc');
        $this->db->order_by('updated_date', 'desc');
        $this->db->limit(1);
        return $this->db->get('bud_poy_physical_stock_log')->row();
    }

    function get_poy_opening_stock_list($id = false)
    {
        $this->db->join('bud_poy_lots', 'bud_poy_physical_stock_log.poy_lot_id=bud_poy_lots.poy_lot_id');
        $this->db->join('bud_yt_poydeniers', 'bud_poy_physical_stock_log.denier_id=bud_yt_poydeniers.denier_id');
        $this->db->join('bud_uoms', 'bud_poy_physical_stock_log.uom_id=bud_uoms.uom_id');
        if (!empty($id)) {
            $this->db->where('bud_poy_physical_stock_log.id', $id);
        }
        $this->db->order_by('updated_date', 'desc');
        return $this->db->get('bud_poy_physical_stock_log')->result();
    }

    function get_poy_closing_stock($poy_lot_id)
    {
        $current_date = date("Y-m-d");
        $this->db->where('poy_lot_id', $poy_lot_id);
        $this->db->where('updated_date', $current_date);
        $this->db->limit(1);
        return $this->db->get('bud_poy_physical_stock_log')->row();
    }

    function get_poy_inw_qty($poy_lot, $from_date = false, $to_date = false)
    {
        $this->db->select('SUM(po_qty) as tot_inw_qty');
        $this->db->join('bud_yt_poy_inward', 'bud_yt_poyinw_items.po_no = bud_yt_poy_inward.po_no');
        $this->db->where("po_date between '$from_date' and '$to_date'");
        $this->db->where('poy_lot', $poy_lot);
        return $this->db->get('bud_yt_poyinw_items')->row();
    }

    function get_total_yarn_pack_qty($poy_lot_id, $from_date = false, $to_date = false, $box_prefix)
    {
        $this->db->select('SUM(net_weight) as total_pack_qty');
        $this->db->where("date(packed_date) between '$from_date' and '$to_date'");
        $this->db->where('poy_lot_id', $poy_lot_id);
        $this->db->where('box_prefix', $box_prefix);
        return $this->db->get('bud_yt_packing_boxes')->row();
    }

    function get_poy_sales_qty($poy_lot, $from_date = false, $to_date = false)
    {
        $this->db->select('SUM(qty) as tot_sales_qty');
        $this->db->join('bud_yt_salesentry', 'bud_yt_poy_sales_items.sales_id = bud_yt_salesentry.sales_id');
        $this->db->where("sales_date between '$from_date' and '$to_date'");
        $this->db->where('poy_lot', $poy_lot);
        return $this->db->get('bud_yt_poy_sales_items')->row();
    }
    function get_rolls_register($from_date, $to_date, $item_id = NULL, $machine_no = NULL, $operator_id = NULL, $shift = NULL) //ER-10-18#-68
    {
        $this->db->select('bud_lbl_rollentry.*,bud_lbl_items.item_name,bud_users.display_name,bud_te_machines.machine_name'); //ER-10-18#-68
        if ($from_date) {
            $this->db->where('date >=', $from_date);
        }
        if ($to_date) {
            $this->db->where('date <=',  $to_date);
        }
        if (!empty($item_id)) {
            $this->db->where('bud_lbl_rollentry.item_id', $item_id);  //ER-10-18#-69                  
        }
        //ER-10-18#-68
        if ($machine_no) {
            $this->db->where('bud_lbl_rollentry.machine_no', $machine_no);
        }
        if ($operator_id) {
            $this->db->where('bud_lbl_rollentry.operator_id', $operator_id);
        }
        if ($shift) {
            $this->db->where('bud_lbl_rollentry.shift', $shift);
        }
        $this->db->join('bud_lbl_items', 'bud_lbl_items.item_id = bud_lbl_rollentry.item_id', 'left');
        $this->db->join('bud_te_machines', 'bud_te_machines.machine_id = bud_lbl_rollentry.machine_no', 'left');
        $this->db->join('bud_users', 'bud_users.ID = bud_lbl_rollentry.operator_id', 'left');
        //ER-10-18#-68
        return $this->db->get('bud_lbl_rollentry')->result();
    }
    function get_size_qty_lbl($box_no)
    {
        $this->db->select('total_qty,item_size');
        $this->db->where('box_no', $box_no);
        return $this->db->get('bud_lbl_outerbox_items')->result();
    }
    function get_dc_details_lbl($from_date = null, $to_date = null, $cust_id = null, $deleted = 1)
    {
        $this->db->select('bud_lbl_delivery.*, bud_customers.cust_name')
            ->from('bud_lbl_delivery')
            ->join('bud_customers', 'bud_customers.cust_id = bud_lbl_delivery.delivery_customer')
            ->order_by('bud_lbl_delivery.delivery_id', 'desc');
        if ($cust_id) {
            $this->db->where('bud_lbl_delivery.delivery_customer', $cust_id);
        }
        if ($from_date) {
            $this->db->where('delivery_date >=', $from_date);
        }
        if ($to_date) {
            $this->db->where('delivery_date <=', $to_date);
        }
        $this->db->where('bud_lbl_delivery.is_deleted', $deleted);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_pdc_details_lbl($from_date = null, $to_date = null, $cust_id = null, $deleted = 1)
    {
        $this->db->select('bud_lbl_predelivery.*, bud_customers.cust_name')
            ->from('bud_lbl_predelivery')
            ->join('bud_customers', 'bud_customers.cust_id = bud_lbl_predelivery.p_delivery_cust')
            ->order_by('bud_lbl_predelivery.p_delivery_id', 'desc');
        if ($cust_id) {
            $this->db->where('bud_lbl_predelivery.p_delivery_cust', $cust_id);
        }
        if ($from_date) {
            $this->db->where('p_delivery_date >=', $from_date);
        }
        if ($to_date) {
            $this->db->where('p_delivery_date <=', $to_date);
        }
        $this->db->where('bud_lbl_predelivery.p_delivery_is_deleted', $deleted);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_inv_details_lbl($from_date = null, $to_date = null, $deleted = 0)
    {
        $this->db->select('bud_lbl_invoices.*, bud_customers.cust_name')
            ->from('bud_lbl_invoices')
            ->join('bud_customers', 'bud_customers.cust_id = bud_lbl_invoices.customer')
            ->order_by('bud_lbl_invoices.invoice_id', 'desc');
        if ($from_date) {
            //$this->db->where('invoice_date >=',$from_date);
        }
        if ($to_date) {
            //$this->db->where('invoice_date <=',$to_date);
        }
        $this->db->where('bud_lbl_invoices.is_cancelled', $deleted);
        $query = $this->db->get();
        return $query->result_array();
    }
    function dc_items_lbl($deliveries = null, $invoice_id = null, $p_delivery_id = null, $deleted = 1)
    {
        $this->db->select('bud_lbl_predelivery_items.*,bud_lbl_items.item_name')
            ->from('bud_lbl_predelivery_items')
            ->join('bud_lbl_items', 'bud_lbl_items.item_id = bud_lbl_predelivery_items.item_id')
            ->order_by('bud_lbl_predelivery_items.item_id', 'desc');
        if ($deliveries) {
            $delivery_id = explode(',', $deliveries);
            $this->db->where_in('delivery_id', $delivery_id);
        }
        if ($invoice_id) {
            $this->db->where('invoice_id', $invoice_id);
        }
        if ($p_delivery_id) {
            $this->db->where('p_delivery_id', $p_delivery_id);
        }
        $this->db->where('bud_lbl_predelivery_items.p_delivery_is_deleted', $deleted);
        $query = $this->db->get();
        return $query->result_array();
    }
    function getPoyDetails($from_date = null, $to_date = null, $supplier_id = null, $item_id = null, $poy_inward_no = null, $poy_denier = null)
    {
        $this->db->select('bud_yt_poyinw_items.*,item_name,sup_name,display_name,bud_yt_poydeniers.denier_name');
        $this->db->join('bud_items', 'bud_yt_poyinw_items.item_id = bud_items.item_id');
        $this->db->join('bud_suppliers', 'bud_yt_poyinw_items.supplier_id = bud_suppliers.sup_id');
        $this->db->join('bud_yt_poydeniers', 'bud_yt_poyinw_items.poy_denier = bud_yt_poydeniers.denier_id');
        $this->db->join('bud_users', 'bud_yt_poyinw_items.user_id = bud_users.ID');
        $this->db->order_by('bud_yt_poyinw_items.edate', 'desc');
        if ($from_date) {
            $this->db->where('inward_date >=', $from_date);
        }
        if ($to_date) {
            $this->db->where('inward_date <=', $to_date);
        }
        if ($poy_inward_no) {
            $this->db->where('po_no', $poy_inward_no);
        }
        if ($supplier_id) {
            $this->db->where('bud_yt_poyinw_items.supplier_id', $supplier_id);
        }
        if ($poy_denier) {
            $this->db->where('poy_denier', $poy_denier);
        }
        if ($item_id) {
            $this->db->where('bud_yt_poyinw_items.item_id', $item_id);
        }
        return $this->db->get('bud_yt_poyinw_items')->result_array();
    }
    function dc_invoiced_te($delivery_id = '', $col_name = '') //ER-08-18#-30
    {
        $this->db->select('bud_te_invoices.' . $col_name);
        $this->db->where("delivery_id", $delivery_id);
        $this->db->where("is_deleted", 1);
        $this->db->join('bud_te_invoices', 'bud_te_invoices.invoice_id = bud_te_predelivery_items.invoice_id', 'left');
        $invoices = $this->db->get('bud_te_predelivery_items')->result_array();
        $invoice_no = '';
        if ($invoices) {
            $invoice_no = $invoices[0][$col_name];
        } else {
            $invoice_no = '';
        }
        return $invoice_no;
    }
    function dc_invoiced_yt($delivery_id = '366') //ER-08-18#-31
    {
        $invoice_no = '';
        //ER-09-18#-58
        $this->db->select('invoice_no');
        $this->db->join('bud_yt_invoices', 'bud_yt_invoices.invoice_id = dyn_yt_predelivery_items.invoice_id');
        $this->db->where("delivery_id", $delivery_id);
        $invoices = $this->db->get('dyn_yt_predelivery_items')->result_array();
        $invoice_no = ($invoices) ? $invoices[0]['invoice_no'] : '';
        //ER-09-18#-58
        return $invoice_no;
    }
    function dc_rate_yt($delivery_id = '', $box_id = '', $item_id = '', $cust_id = '', $shade_id = '') //ER-09-18#-49//ER-09-18#-58
    {
        $item_rate = 0;
        //ER-09-18#-58
        $this->db->select('item_rate');
        $this->db->where("delivery_id", $delivery_id);
        $this->db->where("box_id", $box_id);
        $this->db->where('item_rate', $item_id);
        $invoices = $this->db->get('dyn_yt_predelivery_items')->result_array();
        $item_rate = ($invoices) ? $invoices[0]['item_rate'] : 0;
        //ER-09-18#-58
        if ($item_rate == 0) {
            $filter['item_id'] = $item_id;
            $filter['cust_id'] = $cust_id;
            $filter['shade_id'] = $shade_id;
            $filter['category_id'] = '';
            $filter['family_id'] = '';
            $active_rate = $this->m_mir->get_irr_details($filter);
            foreach ($active_rate as $row) {
                $rate_array = explode(',', $row->item_rates);
                $active = $row->item_rate_active;
                $item_rate = $rate_array[$active];
            }
        }
        return $item_rate;
    }
}
