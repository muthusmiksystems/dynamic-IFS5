<?php
class Register_Model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    //box status register shop
    function get_box_status($box_prefix = null, $box_no, $from_box_no = null, $to_box_no = null)
    {
        $this->db->select('*');
        if ($box_no) {
            $this->db->where_in('box_no', $box_no);
        }
        if ($box_prefix) {
            $this->db->where('box_prefix', $box_prefix);
        }
        if ($from_box_no) {
            $this->db->where('box_no >=', $from_box_no);
        }
        if ($to_box_no) {
            $this->db->where('box_no <=', $to_box_no);
        }
        return $this->db->get('bud_sh_packing')->result();
    }
    function get_inv_id($box_id) //ER-09-18#-61
    {
        $this->db->select("bud_sh_credit_invoices.invoice_no,bud_sh_credit_invoice_items.delivery_qty,bud_sh_credit_invoice_items.item_rate"); //ER-09-18#-61
        $this->db->where('box_id', $box_id);
        $this->db->join('bud_sh_credit_invoices', 'bud_sh_credit_invoices.invoice_id = bud_sh_credit_invoice_items.invoice_id', 'left');
        $data['credit'] = $this->db->get('bud_sh_credit_invoice_items')->result_array();

        $this->db->select("bud_sh_cash_invoices.invoice_no, bud_sh_cash_invoice_items.delivery_qty, bud_sh_cash_invoice_items.item_rate"); //ER-09-18#-61
        $this->db->where('box_id', $box_id);
        $this->db->join('bud_sh_cash_invoices', 'bud_sh_cash_invoices.invoice_id = bud_sh_cash_invoice_items.invoice_id', 'left');
        $data['cash'] = $this->db->get('bud_sh_cash_invoice_items')->result_array();

        $this->db->select("bud_sh_quotations.quotation_no, bud_sh_quotation_items.delivery_qty, bud_sh_quotation_items.item_rate"); //ER-09-18#-61
        $this->db->where('box_id', $box_id);
        $this->db->join('bud_sh_quotations', 'bud_sh_quotations.quotation_id = bud_sh_quotation_items.quotation_id', 'left');
        $this->db->where('bud_sh_quotation_items.is_deleted', 1); //ER-07-18#-17
        $data['quote'] = $this->db->get('bud_sh_quotation_items')->result_array();
        return $data;
    }
    //box status register shop
    //IRR Report
    function get_irr_details($filter = array())
    {
        $this->db->select('bud_sh_itemrates.*');
        $this->db->select('bud_items.item_name');
        $this->db->select('bud_customers.cust_name');
        $this->db->select('bud_shades.*');
        $this->db->select('bud_color_category.color_category');
        $this->db->select('bud_color_families.family_name');
        if ($filter['item_id']) {
            $this->db->where('bud_sh_itemrates.item_id', $filter['item_id']);
        }
        if ($filter['cust_id']) {
            $this->db->where('customer_id', $filter['cust_id']);
        }
        if ($filter['shade_id']) {
            $this->db->where('bud_sh_itemrates.shade_id', $filter['shade_id']);
        }
        if ($filter['category_id']) {
            $this->db->where('bud_shades.shade_category', $filter['category_id']);
        }
        if ($filter['family_id']) {
            $this->db->where('bud_shades.shade_family', $filter['family_id']);
        }
        $this->db->join('bud_items', 'bud_items.item_id = bud_sh_itemrates.item_id', 'left');
        $this->db->join('bud_customers', 'bud_customers.cust_id = bud_sh_itemrates.customer_id', 'left');
        $this->db->join('bud_shades', 'bud_shades.shade_id = bud_sh_itemrates.shade_id', 'left');
        $this->db->join('bud_color_category', 'bud_shades.shade_category = bud_color_category.category_id', 'left');
        $this->db->join('bud_color_families', 'bud_shades.shade_family = bud_color_families.family_id', 'left');
        $this->db->order_by('bud_sh_itemrates.item_id,bud_sh_itemrates.customer_id,bud_shades.shade_category,bud_shades.shade_family,bud_sh_itemrates.shade_id', 'asc');
        $this->db->from('bud_sh_itemrates');
        return $this->db->get()->result();
    }
    //End of IRR Report
    function get_pdc_report_details($filter = array(), $is_deleted = 1) //ER-07-18#-2
    {
        $this->db->select('bud_sh_predelivery.*');
        $this->db->select('bud_concern_master.*');
        $this->db->select('bud_users.display_name as last_edited_by'); //ER-08-18#-28
        $this->db->select('bud_customers.cust_name,bud_customers.cust_address,bud_customers.cust_tinno,bud_customers.cust_cst,bud_customers.cust_city');
        $this->db->select('del_to.cust_name as del_cust_name,del_to.cust_address as del_cust_address,del_to.cust_tinno as del_cust_tinno,del_to.cust_cst as del_cust_cst,del_to.cust_cst as del_cust_city');
        if ($filter['cust_id']) {
            $this->db->where('p_customer_id', $filter['cust_id']);
        }
        if ($filter['from_date']) {
            $this->db->where('p_delivery_date >=', $filter['from_date']);
        }
        if ($filter['to_date']) {
            $this->db->where('p_delivery_date <=', $filter['to_date']);
        }
        $this->db->where('bud_sh_predelivery.p_delivery_is_deleted', $is_deleted); //ER-08-18#-28
        $this->db->join('bud_concern_master', 'bud_sh_predelivery.p_concern_id = bud_concern_master.concern_id', 'left');
        $this->db->join('bud_customers', 'bud_sh_predelivery.p_customer_id = bud_customers.cust_id', 'left');
        $this->db->join('bud_customers del_to', 'bud_sh_predelivery.p_delivery_to = del_to.cust_id', 'left');
        $this->db->join('bud_users', 'bud_sh_predelivery.p_delivery_lt_edtd_by = bud_users.ID', 'left'); //ER-08-18#-28
        $this->db->group_by('bud_sh_predelivery.p_delivery_id', 'desc');
        return $this->db->get('bud_sh_predelivery')->result();
    }
    function get_dc_report_details($filter = array(), $is_deleted = 1) //ER-07-18#-4//ER-08-18#-28
    {
        $this->db->select('bud_sh_delivery.*');
        $this->db->select('bud_concern_master.*');
        $this->db->select('bud_users.display_name as last_edited_by'); //ER-08-18#-28
        $this->db->select('bud_customers.cust_name,bud_customers.cust_address,bud_customers.cust_tinno,bud_customers.cust_cst,bud_customers.cust_city');
        $this->db->select('del_to.cust_name as del_cust_name,del_to.cust_address as del_cust_address,del_to.cust_tinno as del_cust_tinno,del_to.cust_cst as del_cust_cst,del_to.cust_cst as del_cust_city');
        $this->db->join('bud_concern_master', 'bud_sh_delivery.concern_id=bud_concern_master.concern_id', 'left');
        $this->db->join('bud_customers', 'bud_sh_delivery.customer_id=bud_customers.cust_id', 'left');
        $this->db->join('bud_customers del_to', 'bud_sh_delivery.delivery_to=del_to.cust_id', 'left');
        if ($filter['cust_id']) {
            $this->db->where('customer_id', $filter['cust_id']);
        }
        if ($filter['from_date']) {
            $this->db->where('delivery_date >=', $filter['from_date']);
        }
        if ($filter['to_date']) {
            $this->db->where('delivery_date <=', $filter['to_date']);
        }
        $this->db->where('bud_sh_delivery.delivery_is_deleted', $is_deleted); //ER-08-18#-28
        $this->db->join('bud_users', 'bud_sh_delivery.delivery_lt_edtd_by = bud_users.ID', 'left'); //ER-08-18#-28
        $this->db->group_by('bud_sh_delivery.delivery_id');
        $this->db->order_by('bud_sh_delivery.delivery_id', 'desc');
        return $this->db->get('bud_sh_delivery')->result();
    }
    public function get_credit_invoice_report($filter = array(), $is_deleted = 1) //ER-07-18#-23//ER-08-18#-28
    {
        $this->db->select('bud_sh_credit_invoices.*');
        $this->db->select('bud_concern_master.*');
        $this->db->select('bud_users.display_name as last_edited_by'); //ER-08-18#-28
        $this->db->select('bud_customers.cust_name,bud_customers.cust_address,bud_customers.cust_gst,bud_customers.cust_city');
        $this->db->select('del_to.cust_name as del_cust_name,del_to.cust_address as del_cust_address,del_to.cust_gst as del_cust_gst,del_to.cust_city as del_cust_city');
        $this->db->join('bud_concern_master', 'bud_sh_credit_invoices.concern_id=bud_concern_master.concern_id', 'left');
        $this->db->join('bud_customers', 'bud_sh_credit_invoices.customer_id=bud_customers.cust_id', 'left');
        $this->db->join('bud_customers del_to', 'bud_sh_credit_invoices.delivery_to=del_to.cust_id', 'left');
        if ($filter['cust_id']) {
            $this->db->where('customer_id', $filter['cust_id']);
        }
        if ($filter['from_date']) {
            $this->db->where('invoice_date >=', $filter['from_date']);
        }
        if ($filter['to_date']) {
            $this->db->where('invoice_date <=', $filter['to_date']);
        }
        $this->db->where('bud_sh_credit_invoices.is_deleted', $is_deleted); //ER-08-18#-28
        $this->db->join('bud_users', 'bud_sh_credit_invoices.last_edited_id = bud_users.ID', 'left'); //ER-08-18#-28
        return $this->db->get('bud_sh_credit_invoices')->result();
    }
    public function get_cash_invoice_report($filter = array(), $is_deleted = 1) //ER-07-18#-23 //ER-08-18#-28
    {
        $this->db->select('bud_sh_cash_invoices.*');
        $this->db->select('bud_concern_master.*');
        $this->db->select('bud_users.display_name as last_edited_by'); //ER-08-18#-28
        $this->db->select('bud_customers.cust_name,bud_customers.cust_address,bud_customers.cust_tinno,bud_customers.cust_gst,bud_customers.cust_city');
        $this->db->select('del_to.cust_name as del_cust_name,del_to.cust_address as del_cust_address,del_to.cust_gst as del_cust_gst,del_to.cust_city as del_cust_city');
        $this->db->join('bud_concern_master', 'bud_sh_cash_invoices.concern_id=bud_concern_master.concern_id', 'left');
        $this->db->join('bud_customers', 'bud_sh_cash_invoices.customer_id=bud_customers.cust_id', 'left');
        $this->db->join('bud_customers del_to', 'bud_sh_cash_invoices.delivery_to=del_to.cust_id', 'left');
        if ($filter['cust_id']) {
            $this->db->where('customer_id', $filter['cust_id']);
        }
        if ($filter['from_date']) {
            $this->db->where('invoice_date >=', $filter['from_date']);
        }
        if ($filter['to_date']) {
            $this->db->where('invoice_date <=', $filter['to_date']);
        }
        $this->db->where('bud_sh_cash_invoices.is_deleted', $is_deleted); //ER-08-18#-28
        $this->db->join('bud_users', 'bud_sh_cash_invoices.last_edited_id = bud_users.ID', 'left'); //ER-08-18#-28
        return $this->db->get('bud_sh_cash_invoices')->result();
    }
    public function get_enq_report($filter = array(), $is_deleted = 1) //ER-08-18#-27 //ER-08-18#-28
    {
        $this->db->select('bud_sh_quotations.*');
        $this->db->select('bud_concern_master.*');
        $this->db->select('bud_users.display_name as last_edited_by'); //ER-08-18#-28
        $this->db->select('bud_customers.cust_name,bud_customers.cust_address,bud_customers.cust_tinno,bud_customers.cust_gst,bud_customers.cust_city');
        $this->db->select('del_to.cust_name as del_cust_name,del_to.cust_address as del_cust_address,del_to.cust_gst as del_cust_gst,del_to.cust_city as del_cust_city');
        $this->db->join('bud_concern_master', 'bud_sh_quotations.concern_id=bud_concern_master.concern_id', 'left');
        $this->db->join('bud_customers', 'bud_sh_quotations.customer_id=bud_customers.cust_id', 'left');
        $this->db->join('bud_customers del_to', 'bud_sh_quotations.delivery_to=del_to.cust_id', 'left');
        if ($filter['cust_id']) {
            $this->db->where('customer_id', $filter['cust_id']);
        }
        if ($filter['from_date']) {
            $this->db->where('quotation_date >=', $filter['from_date']);
        }
        if ($filter['to_date']) {
            $this->db->where('quotation_date <=', $filter['to_date']);
        }
        $this->db->where('bud_sh_quotations.is_deleted', $is_deleted); //ER-08-18#-28
        $this->db->join('bud_users', 'bud_sh_quotations.last_edited_id = bud_users.ID', 'left'); //ER-08-18#-28
        return $this->db->get('bud_sh_quotations')->result();
    }
    function get_box_dc_details($box_id = '') //ER-09-18#-61
    {
        $this->db->select("bud_sh_delivery.delivery_id,bud_sh_delivery.customer_id,bud_sh_delivery_items.delivery_qty,item_id,shade_id");
        $this->db->where('box_id', $box_id);
        $this->db->where('delivery_status', 0);
        $this->db->where('bud_sh_delivery.delivery_is_deleted', 1);
        $this->db->where('bud_sh_delivery_items.delivery_is_deleted', 1);
        $this->db->join('bud_sh_delivery', 'bud_sh_delivery.delivery_id = bud_sh_delivery_items.delivery_id', 'left');
        $dcs = $this->db->get('bud_sh_delivery_items')->result_array();
        $inv = $this->get_inv_id($box_id);
        $data['cash'] = array();
        $data['credit'] = array();
        $data['quotation'] = array();
        $data['dc'] = array();
        $data['dc_price'] = array();
        $data['cash_price'] = array();
        $data['credit_price'] = array();
        $data['quotation_price'] = array();
        $data['dc_qty'] = array();
        foreach ($inv['cash'] as $cash) {
            $data['cash'][] = $cash['invoice_no'] . '-' . $cash['item_rate'] * $cash['delivery_qty'];
            $data['dc_qty'][] = $cash['delivery_qty'];
            $data['cash_price'][] = $cash['item_rate'] * $cash['delivery_qty'];
        }
        foreach ($inv['credit'] as $credit) {
            $data['credit'][] = $credit['invoice_no'] . '-' . $credit['item_rate'] * $credit['delivery_qty'];
            $data['dc_qty'][] = $credit['delivery_qty'];
            $data['credit_price'][] = $credit['item_rate'] * $credit['delivery_qty'];
        }
        foreach ($inv['quote'] as $quotation) {
            $data['dc_qty'][] = $quotation['delivery_qty'];
            $data['quotation'][] = $quotation['quotation_no'] . '-' . $quotation['item_rate'] * $quotation['delivery_qty'];
            $data['quotation_price'][] = $quotation['item_rate'] * $quotation['delivery_qty'];
        }
        foreach ($dcs as $dc) {
            $item_rate = 0;
            $this->db->select("item_rates,item_rate_active");
            $this->db->where('item_id', $dc['item_id']);
            $this->db->where('shade_id', $dc['shade_id']);
            $this->db->where('customer_id', $dc['customer_id']);
            $rate_details = $this->db->get('bud_sh_itemrates')->result_array();
            if ($rate_details) {
                $item_rate_array = explode(',', $rate_details[0]['item_rates']);
                $item_rate = $item_rate_array[$rate_details[0]['item_rate_active']];
            }
            $data['dc_qty'][] = $dc['delivery_qty'];
            $data['dc'][] = 'SHOP-DC-' . $dc['delivery_id'] . '-' . $dc['delivery_qty'] * $item_rate;
            $data['dc_price'][] = $item_rate * $dc['delivery_qty'];
        }
        return $data;
    }
}
