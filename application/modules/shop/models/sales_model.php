<?php
class Sales_model extends CI_Model {
  	function __construct()
    {
        parent::__construct();
    }

    public function get_cash_invoice_count($concern_id='')
    {
        if(!empty($concern_id))
        {
            $this->db->where('concern_id', $concern_id);
        }
        
        $this->db->where('bud_sh_cash_invoices.is_deleted',1);//ER-07-18#-22
        $count = $this->db->count_all_results('bud_sh_cash_invoices');
        return $count;
    }

    public function get_credit_invoice_count($concern_id='')
    {
        if(!empty($concern_id))
        {
            $this->db->where('concern_id', $concern_id);
        }
        $this->db->where('bud_sh_credit_invoices.is_deleted',1);//ER-07-18#-22
        $count = $this->db->count_all_results('bud_sh_credit_invoices');
        return $count;
    }

    public function get_scrapsales_count($concern_id='')
    {
        if(!empty($concern_id))
        {
            $this->db->where('concern_id', $concern_id);
        }
        $count = $this->db->count_all_results('bud_sh_scrapsales');
        return $count;
    }
    public function get_concern($concern_id)
    {
        $this->db->where('concern_id', $concern_id);
        $result = $this->db->get('bud_concern_master');
        return $result->row();
    }
    public function get_customer($cust_id)
    {
        $this->db->where('cust_id', $cust_id);
        $result = $this->db->get('bud_customers');
        return $result->row();
    }

    public function save_rate_master($save)
    {
        $rate_id = false;
        if($save['rate_id'])
        {
            $this->db->where('rate_id', $save['rate_id']);
            $this->db->update('bud_sh_itemrates', $save);
            $rate_id = $save['rate_id'];
        }
        else
        {
            $this->db->insert('bud_sh_itemrates', $save);
            $rate_id = $this->db->insert_id();
        }
        return $rate_id;
    }

    public function clear_gen_rate_master($item_id = '', $category_id = '')
    {
        if(!empty($item_id) && !empty($category_id))
        {
            $this->db->where('item_id', $item_id);
            $this->db->where('category_id', $category_id);
            $this->db->delete('bud_sh_gen_itemrates');            
        }
    }
    
    public function save_gen_rate_master($item_rates)
    {
        $this->db->insert_batch('bud_sh_gen_itemrates', $item_rates);
    }

    public function save_cash_receipt($save)
    {
    	$receipt_id = false;
    	if($save['receipt_id'])
        {
            $this->db->where('receipt_id', $save['receipt_id']);
            $this->db->update('bud_sh_cash_receipts', $save);
            $receipt_id = $save['receipt_id'];
        }
        else
        {
            $this->db->insert('bud_sh_cash_receipts', $save);
            $receipt_id = $this->db->insert_id();
        }
        return $receipt_id;
    }

    public function get_cash_receipt($receipt_id)
    {
    	$this->db->select('bud_sh_cash_receipts.*');
        $this->db->select('bud_concern_master.*');
        $this->db->select('bud_users.display_name');
        $this->db->select('bud_customers.cust_name,bud_customers.cust_address,bud_customers.cust_gst,bud_customers.cust_city,bud_customers.cust_pincode');
        $this->db->join('bud_concern_master', 'bud_sh_cash_receipts.concern_id=bud_concern_master.concern_id', 'left');
        $this->db->join('bud_customers', 'bud_sh_cash_receipts.customer_id=bud_customers.cust_id', 'left');
        $this->db->join('bud_users', 'bud_sh_cash_receipts.received_by=bud_users.ID', 'left');
        $this->db->where('bud_sh_cash_receipts.receipt_id', $receipt_id);
        return $this->db->get('bud_sh_cash_receipts')->row();
    }
    public function get_cash_receipt_list($filter = array())
    {
        $this->db->select('bud_sh_cash_receipts.*');
        $this->db->select('bud_concern_master.*');
        $this->db->select('bud_users.display_name');
        $this->db->select('bud_customers.cust_name,bud_customers.cust_address,bud_customers.cust_gst,bud_customers.cust_city,bud_customers.cust_pincode');
        $this->db->join('bud_concern_master', 'bud_sh_cash_receipts.concern_id=bud_concern_master.concern_id', 'left');
        $this->db->join('bud_customers', 'bud_sh_cash_receipts.customer_id=bud_customers.cust_id', 'left');
        $this->db->join('bud_users', 'bud_sh_cash_receipts.received_by=bud_users.ID', 'left');
        if(count($filter) > 0)
        {
            if(isset($filter['cash_tranfered']))
            {
                $this->db->where('bud_sh_cash_receipts.cash_tranfered', $filter['cash_tranfered']);
            }
        }
        $this->db->order_by('bud_sh_cash_receipts.receipt_date', 'desc');
        return $this->db->get('bud_sh_cash_receipts')->result();
    }

    // Credit Note
    public function save_credit_receipt($save)
    {
    	$receipt_id = false;
    	if($save['receipt_id'])
        {
            $this->db->where('receipt_id', $save['receipt_id']);
            $this->db->update('bud_sh_credit_receipts', $save);
            $receipt_id = $save['receipt_id'];
        }
        else
        {
            $this->db->insert('bud_sh_credit_receipts', $save);
            $receipt_id = $this->db->insert_id();
        }
        return $receipt_id;
    }

    public function get_credit_receipt($receipt_id)
    {
    	$this->db->select('bud_sh_credit_receipts.*');
        $this->db->select('bud_concern_master.*');
        $this->db->select('bud_users.display_name');
        $this->db->select('bud_customers.cust_name,bud_customers.cust_address,bud_customers.cust_gst,bud_customers.cust_city,bud_customers.cust_pincode');
        $this->db->join('bud_concern_master', 'bud_sh_credit_receipts.concern_id=bud_concern_master.concern_id', 'left');
        $this->db->join('bud_customers', 'bud_sh_credit_receipts.customer_id=bud_customers.cust_id', 'left');
        $this->db->join('bud_users', 'bud_sh_credit_receipts.received_by=bud_users.ID', 'left');
        $this->db->where('bud_sh_credit_receipts.receipt_id', $receipt_id);
        return $this->db->get('bud_sh_credit_receipts')->row();
    }
    public function get_credit_receipt_list()
    {
    	$this->db->select('bud_sh_credit_receipts.*');
        $this->db->select('bud_concern_master.*');
        $this->db->select('bud_users.display_name');
        $this->db->select('bud_customers.cust_name,bud_customers.cust_address,bud_customers.cust_gst,bud_customers.cust_city,bud_customers.cust_pincode');
        $this->db->join('bud_concern_master', 'bud_sh_credit_receipts.concern_id=bud_concern_master.concern_id', 'left');
        $this->db->join('bud_customers', 'bud_sh_credit_receipts.customer_id=bud_customers.cust_id', 'left');
        $this->db->join('bud_users', 'bud_sh_credit_receipts.received_by=bud_users.ID', 'left');
        $this->db->order_by('bud_sh_credit_receipts.receipt_date', 'desc');
        return $this->db->get('bud_sh_credit_receipts')->result();
    }

    // Debit Note
    public function save_debit_receipt($save)
    {
    	$receipt_id = false;
    	if($save['receipt_id'])
        {
            $this->db->where('receipt_id', $save['receipt_id']);
            $this->db->update('bud_sh_debit_receipts', $save);
            $receipt_id = $save['receipt_id'];
        }
        else
        {
            $this->db->insert('bud_sh_debit_receipts', $save);
            $receipt_id = $this->db->insert_id();
        }
        return $receipt_id;
    }

    public function get_debit_receipt($receipt_id)
    {
    	$this->db->select('bud_sh_debit_receipts.*');
        $this->db->select('bud_concern_master.*');
        $this->db->select('bud_users.display_name');
        $this->db->select('bud_customers.cust_name,bud_customers.cust_address,bud_customers.cust_gst,bud_customers.cust_city,bud_customers.cust_pincode');
        $this->db->join('bud_concern_master', 'bud_sh_debit_receipts.concern_id=bud_concern_master.concern_id', 'left');
        $this->db->join('bud_customers', 'bud_sh_debit_receipts.customer_id=bud_customers.cust_id', 'left');
        $this->db->join('bud_users', 'bud_sh_debit_receipts.received_by=bud_users.ID', 'left');
        $this->db->where('bud_sh_debit_receipts.receipt_id', $receipt_id);
        return $this->db->get('bud_sh_debit_receipts')->row();
    }
    public function get_debit_receipt_list()
    {
    	$this->db->select('bud_sh_debit_receipts.*');
        $this->db->select('bud_concern_master.*');
        $this->db->select('bud_users.display_name');
        $this->db->select('bud_customers.cust_name,bud_customers.cust_address,bud_customers.cust_gst,bud_customers.cust_city,bud_customers.cust_pincode');
        $this->db->join('bud_concern_master', 'bud_sh_debit_receipts.concern_id=bud_concern_master.concern_id', 'left');
        $this->db->join('bud_customers', 'bud_sh_debit_receipts.customer_id=bud_customers.cust_id', 'left');
        $this->db->join('bud_users', 'bud_sh_debit_receipts.received_by=bud_users.ID', 'left');
        $this->db->order_by('bud_sh_debit_receipts.receipt_date', 'desc');
        return $this->db->get('bud_sh_debit_receipts')->result();
    }

    public function get_item_rates($customer_id = '', $item_id = '', $shade_id = '')
    {
        if(!empty($customer_id) && !empty($item_id) && !empty($shade_id))
        {
            $this->db->select('bud_sh_itemrates.*');
            $this->db->select('bud_items.item_name');
            $this->db->select('bud_shades.shade_name, bud_shades.shade_code');
            $this->db->join('bud_items', 'bud_sh_itemrates.item_id=bud_items.item_id', 'left');
            $this->db->join('bud_shades', 'bud_sh_itemrates.shade_id=bud_shades.shade_id', 'left');
            $this->db->where('bud_sh_itemrates.customer_id', $customer_id);
            $this->db->where('bud_sh_itemrates.item_id', $item_id);
            $this->db->where('bud_sh_itemrates.shade_id', $shade_id);
            return $this->db->get('bud_sh_itemrates')->result();
        }
    }

    public function get_gen_item_rates($item_id = '', $category_id = '')
    {
        if(!empty($item_id) && !empty($category_id))
        {
            $this->db->select('bud_sh_gen_itemrates.*');
            $this->db->select('bud_items.item_name');
            $this->db->select('bud_color_category.color_category');
            $this->db->join('bud_items', 'bud_sh_gen_itemrates.item_id=bud_items.item_id', 'left');
            $this->db->join('bud_color_category', 'bud_sh_gen_itemrates.category_id=bud_color_category.category_id', 'left');
            $this->db->where('bud_sh_gen_itemrates.item_id', $item_id);
            $this->db->where('bud_sh_gen_itemrates.category_id', $category_id);
            return $this->db->get('bud_sh_gen_itemrates')->result();
        }
    }

    function amount_words($number, $doOtherWords = true)
    {
    	//A function to convert numbers into words.
	    $words = array(
	    '0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five',
	    '6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten',
	    '11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fouteen','15' => 'fifteen',
	    '16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty',
	    '30' => 'thirty','40' => 'fourty','50' => 'fifty','60' => 'sixty','70' => 'seventy',
	    '80' => 'eighty','90' => 'ninty');

	    //First find the length of the number
	    $number_length = strlen($number);
	    //Initialize an empty array
	    $number_array = array(0,0,0,0,0,0,0,0,0);        
	    $received_number_array = array();

	    // Save off if we have a decimal in a variable. Assume we don't
	    $hasDecimal = false;
	    $numberAfterDecimal = '';
	    //Store all received numbers into an array
	    //ONLY do this until we find a decimal
	    for($i=0;$i<$number_length;$i++) { 
	        $character = substr($number,$i,1);    
	        if ($character == '.') {
	            $hasDecimal = true;
	            $numberAfterDecimal = substr($number, $i+1);
	            $received_number_array[$i] = 0;
	        } elseif ($hasDecimal) {
	            $received_number_array[$i] = 0;
	        } else {
	            $received_number_array[$i] = $character;
	        }
	    }


	    //Populate the empty array with the numbers received - most critical operation
	    for($i=9-$number_length,$j=0;$i<9;$i++,$j++){ $number_array[$i] = $received_number_array[$j]; }
	    $number_to_words_string = "";        
	    //Finding out whether it is teen ? and then multiplying by 10, example 17 is seventeen, so if 1 is preceeded with 7 multiply 1 by 10 and add 7 to it.
	    for($i=0,$j=1;$i<9;$i++,$j++){
	        if($i==0 || $i==2 || $i==4 || $i==7){
	            if($number_array[$i]=="1"){
	                $number_array[$j] = 10+$number_array[$j];
	                $number_array[$i] = 0;
	            }        
	        }
	    }
	    $value = "";
	    for($i=0;$i<9;$i++){
	        if($i==0 || $i==2 || $i==4 || $i==7){
	            $value = $number_array[$i]*10; 
	        } else{ 
	            $value = $number_array[$i];
	        }            

	        if($value!=0){ 
	            $number_to_words_string.= $words["$value"]." "; 
	        }

	        if ($doOtherWords) {
	            if($i==1 && $value!=0){    $number_to_words_string.= "Crores "; }
	            if($i==3 && $value!=0){    $number_to_words_string.= "Lakhs ";    }
	            if($i==5 && $value!=0){    $number_to_words_string.= "Thousand "; }
	            if($i==6 && $value!=0){    $number_to_words_string.= "Hundred "; }
	        }
	    }

	    // At this point you have the solution for everything BEFORE the decimal
	    // Now handle the decimal through recursion if in fact we have one
	    if ($hasDecimal) {
	        $number_to_words_string .= 'point ' . $this->amount_words($numberAfterDecimal, false);
	    }
	    if($number_length>9){ $number_to_words_string = "Sorry This does not support more than 99 Crores"; }
	    if ($doOtherWords) {
	        return ucwords(strtolower("".$number_to_words_string)."Only.");
	    }
	    // Don't add the other words on the recursive call
	    return ucwords(strtolower($number_to_words_string));
    }

    function get_gen_item_rate($qty = 0, $item_id = '', $category_id = '')
    {
        $this->db->where('item_id', $item_id);
        /*if(!empty($category_id))
        {
            $this->db->where('category_id', $category_id);
        }*/
        $this->db->where('category_id', $category_id);
        $this->db->where("'$qty' BETWEEN coalesce(`qty_from`,$qty) AND coalesce(`qty_to`,$qty)", null, false);
        // $this->db->or_where('qty_from <=', $qty);
        // $this->db->or_where('qty_to >=', $qty);
        return $this->db->get('bud_sh_gen_itemrates')->row();
    }

    function get_item_rate($customer_id, $item_id, $shade_id)
    {
        $this->db->select('*');
        $this->db->where('customer_id', $customer_id);
        $this->db->where('item_id', $item_id);
        $this->db->where('shade_id', $shade_id);
        $query = $this->db->get('bud_sh_itemrates');
        return $query->row();
    }

    public function update_dc_status($save)
    {
        if($save['delivery_id'])
        {
            $this->db->where_in('delivery_id', $save['delivery_id']);
            $this->db->update('bud_sh_delivery', $save);
            $delivery_id = $save['delivery_id'];
        }
    }

    public function save_cash_invoice($save, $invoice_items = array())
    {
        $invoice_id = false;
        $save['last_edited_id'] = $this->session->userdata('user_id');//ER-07-18#-22
        $save['is_deleted'] =1;//ER-07-18#-22
        if($save['invoice_id'])
        {
            $this->db->where('invoice_id', $save['invoice_id']);
            $this->db->update('bud_sh_cash_invoices', $save);
            $invoice_id = $save['invoice_id'];
        }
        else
        {
            $this->db->insert('bud_sh_cash_invoices', $save);
            $invoice_id = $this->db->insert_id();
        }

        if($invoice_id)
        {
            $this->save_cash_inv_items($invoice_id, $invoice_items, $save['customer_id']);
        }
        return $invoice_id;
    }

    public function update_cash_invoice($save)
    {
        $save['last_edited_id'] = $this->session->userdata('user_id');//ER-07-18#-22
        $save['is_deleted'] =1;//ER-07-18#-22
        $this->db->where('invoice_id', $save['invoice_id']);
        $this->db->update('bud_sh_cash_invoices', $save);
        $invoice_id = $save['invoice_id'];
    }

    public function save_cash_inv_items($invoice_id, $invoice_items, $customer_id)
    {
        $delivery_items = array();
        if(sizeof($invoice_items) > 0)
        {
            $delivery_ids = array();
            foreach ($invoice_items as $box) {
                $delivery_ids[$box->delivery_id] = $box->delivery_id;
                $item['delivery_id'] = $box->delivery_id;
                $item['delivery_row_id'] = $box->row_id;
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
                $item['delivery_qty'] = $box->delivery_qty;
                $item['uom_id'] = $box->uom_id;
                $item['is_deleted'] = 1;//ER-07-18#-22
                $item['invoice_id'] = $invoice_id;

                $cust_item_rate = $this->Sales_model->get_item_rate($customer_id, $box->item_id, $box->shade_id);
                if($cust_item_rate)
                {
                    $item_rates = explode(",", $cust_item_rate->item_rates);
                    $item_rate_active = $cust_item_rate->item_rate_active;
                    $item_rate = $item_rates[$item_rate_active];
                    $item['item_rate'] = $item_rate;
                }
                elseif ($this->Sales_model->get_gen_item_rate($box->delivery_qty, $box->item_id, $box->category_id)) {
                    $gen_item_rate = $this->Sales_model->get_gen_item_rate($box->delivery_qty, $box->item_id, $box->category_id);
                    $item['item_rate'] = $gen_item_rate->item_rate;
                }
                else
                {
                    $item['item_rate'] = 0;
                }
                
                /*$gen_item_rate = $this->Sales_model->get_gen_item_rate($box->delivery_qty, $box->item_id, $box->category_id);
                if($gen_item_rate)
                {
                    $item['item_rate'] = $gen_item_rate->item_rate;
                }*/

                $delivery_items[] = $item;
            }

            $this->db->insert_batch('bud_sh_cash_invoice_items', $delivery_items);

            $this->update_dc_status(array('delivery_id' => implode(",", $delivery_ids), 'delivery_status' => 1));
            // $this->empty_cart();
        }
    }

    public function update_cash_inv_amt($save)
    {
        $save['last_edited_id'] = $this->session->userdata('user_id');//ER-07-18#-22
        $save['is_deleted'] =1;//ER-07-18#-22
        if($save['invoice_id'])
        {
            $this->db->where('invoice_id', $save['invoice_id']);
            $this->db->update('bud_sh_cash_invoices', $save);
            $invoice_id = $save['invoice_id'];
        }
    }

    public function save_credit_invoice($save, $invoice_items = array())
    {
        $invoice_id = false;
        $save['last_edited_id'] = $this->session->userdata('user_id');//ER-07-18#-22
        $save['is_deleted'] =1;//ER-07-18#-22
        if($save['invoice_id'])
        {
            $this->db->where('invoice_id', $save['invoice_id']);
            $this->db->update('bud_sh_credit_invoices', $save);
            $invoice_id = $save['invoice_id'];
        }
        else
        {
            $this->db->insert('bud_sh_credit_invoices', $save);
            $invoice_id = $this->db->insert_id();
        }

        if($invoice_id)
        {
            $this->save_credit_inv_items($invoice_id, $invoice_items, $save['customer_id']);
        }
        return $invoice_id;
    }

    public function save_credit_inv_items($invoice_id, $invoice_items, $customer_id)
    {
        $delivery_items = array();
        if(sizeof($invoice_items) > 0)
        {
            $delivery_ids = array();
            foreach ($invoice_items as $box) {
                $delivery_ids[$box->delivery_id] = $box->delivery_id;
                $item['delivery_id'] = $box->delivery_id;
                $item['delivery_row_id'] = $box->row_id;
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
                $item['delivery_qty'] = $box->delivery_qty;
                $item['uom_id'] = $box->uom_id;
                $item['is_deleted'] = 1;//ER-07-18#-22
                $item['invoice_id'] = $invoice_id;

                
                $cust_item_rate = $this->Sales_model->get_item_rate($customer_id, $box->item_id, $box->shade_id);
                if($cust_item_rate)
                {
                    $item_rates = explode(",", $cust_item_rate->item_rates);
                    $item_rate_active = $cust_item_rate->item_rate_active;
                    $item_rate = $item_rates[$item_rate_active];
                    $item['item_rate'] = $item_rate;
                }
                elseif ($this->Sales_model->get_gen_item_rate($box->delivery_qty, $box->item_id, $box->category_id)) {
                    $gen_item_rate = $this->Sales_model->get_gen_item_rate($box->delivery_qty, $box->item_id, $box->category_id);
                    $item['item_rate'] = $gen_item_rate->item_rate;
                }
                else
                {
                    $item['item_rate'] = 0;
                }

                $delivery_items[] = $item;
            }

            $this->db->insert_batch('bud_sh_credit_invoice_items', $delivery_items);

            $this->update_dc_status(array('delivery_id' => implode(",", $delivery_ids), 'delivery_status' => 1));
            // $this->empty_cart();
        }
    }

    public function update_credit_inv_amt($save)
    {
        $save['last_edited_id'] = $this->session->userdata('user_id');//ER-07-18#-22
        $save['is_deleted'] =1;//ER-07-18#-22
        if($save['invoice_id'])
        {
            $this->db->where('invoice_id', $save['invoice_id']);
            $this->db->update('bud_sh_credit_invoices', $save);
            $invoice_id = $save['invoice_id'];
        }
    }

    public function get_cash_inv_list($filter = array())
    {
        $this->db->select('bud_sh_cash_invoices.*');
        $this->db->select('bud_concern_master.*');
        $this->db->select('bud_customers.cust_name,bud_customers.cust_address,bud_customers.cust_gst,bud_customers.cust_city');
        $this->db->select('del_to.cust_name as del_cust_name,del_to.cust_address as del_cust_address,del_to.cust_tinno as del_cust_tinno,del_to.cust_gst as del_cust_gst,del_to.cust_city as del_cust_city');
        $this->db->join('bud_concern_master', 'bud_sh_cash_invoices.concern_id=bud_concern_master.concern_id', 'left');
        $this->db->join('bud_customers', 'bud_sh_cash_invoices.customer_id=bud_customers.cust_id', 'left');
        $this->db->join('bud_customers del_to', 'bud_sh_cash_invoices.delivery_to=del_to.cust_id', 'left');
        if(count($filter) > 0)
        {
            if(isset($filter['cash_tranfered']))
            {
                $this->db->where('bud_sh_cash_invoices.cash_tranfered', $filter['cash_tranfered']);                
            }
        }
        $this->db->where('bud_sh_cash_invoices.is_deleted',1);//ER-07-18#-22
        return $this->db->get('bud_sh_cash_invoices')->result();
    }

    public function get_cash_invoice($invoice_id)
    {
        $this->db->select('bud_sh_cash_invoices.*');
        $this->db->select('bud_concern_master.*');
        $this->db->select('bud_customers.cust_name,bud_customers.cust_address,bud_customers.cust_tinno,bud_customers.cust_gst,bud_customers.cust_city');
        $this->db->select('del_to.cust_name as del_cust_name,del_to.cust_address as del_cust_address,del_to.cust_gst as del_cust_gst,del_to.cust_city as del_cust_city');
        $this->db->join('bud_concern_master', 'bud_sh_cash_invoices.concern_id=bud_concern_master.concern_id', 'left');
        $this->db->join('bud_customers', 'bud_sh_cash_invoices.customer_id=bud_customers.cust_id', 'left');
        $this->db->join('bud_customers del_to', 'bud_sh_cash_invoices.delivery_to=del_to.cust_id', 'left');
        $this->db->where('bud_sh_cash_invoices.invoice_id', $invoice_id);
        $this->db->where('bud_sh_cash_invoices.is_deleted',1);//ER-07-18#-22
        return $this->db->get('bud_sh_cash_invoices')->row();
    }

    public function get_cash_inv_items($invoice_id = '',$item_id='',$is_deleted=1)//ER-07-18#-23//ER-08-18#-28
    {
        $this->db->select('bud_sh_cash_invoice_items.*');
        $this->db->select('bud_itemgroups.group_name');
        $this->db->select('bud_items.item_name,bud_items.hsn_code');
        $this->db->select('bud_uoms.uom_name');
        $this->db->select('bud_shades.shade_name, bud_shades.shade_code, bud_shades.category_id');
        $this->db->join('bud_itemgroups', 'bud_sh_cash_invoice_items.item_group_id=bud_itemgroups.group_id', 'left');
        $this->db->join('bud_items', 'bud_sh_cash_invoice_items.item_id=bud_items.item_id', 'left');
        $this->db->join('bud_shades', 'bud_sh_cash_invoice_items.shade_id=bud_shades.shade_id', 'left');
        $this->db->join('bud_uoms', 'bud_sh_cash_invoice_items.uom_id=bud_uoms.uom_id', 'left');
        if(!empty($invoice_id))
        {
            $this->db->where('bud_sh_cash_invoice_items.invoice_id', $invoice_id);
        }
        if(!empty($item_id))//ER-07-18#-23
        {
            $this->db->where('bud_sh_cash_invoice_items.item_id', $item_id);
        }
        $this->db->where('bud_sh_cash_invoice_items.is_deleted',$is_deleted);//ER-07-18#-22//ER-08-18#-28
        return $this->db->get('bud_sh_cash_invoice_items')->result();
    }

    public function get_credit_inv_list()
    {
        $this->db->select('bud_sh_credit_invoices.*');
        $this->db->select('bud_concern_master.*');
        $this->db->select('bud_customers.cust_name,bud_customers.cust_address,bud_customers.cust_tinno,bud_customers.cust_gst,bud_customers.cust_city');
        $this->db->select('del_to.cust_name as del_cust_name,del_to.cust_address as del_cust_address,del_to.cust_gst as del_cust_gst,del_to.cust_city as del_cust_city');
        $this->db->join('bud_concern_master', 'bud_sh_credit_invoices.concern_id=bud_concern_master.concern_id', 'left');
        $this->db->join('bud_customers', 'bud_sh_credit_invoices.customer_id=bud_customers.cust_id', 'left');
        $this->db->join('bud_customers del_to', 'bud_sh_credit_invoices.delivery_to=del_to.cust_id', 'left');
        $this->db->where('bud_sh_credit_invoices.is_deleted',1);//ER-07-18#-22
        return $this->db->get('bud_sh_credit_invoices')->result();
    }

    public function get_credit_invoice($invoice_id)
    {
        $this->db->select('bud_sh_credit_invoices.*');
        $this->db->select('bud_concern_master.*');
        $this->db->select('bud_customers.cust_name,bud_customers.cust_address,bud_customers.cust_gst,bud_customers.cust_city');
        $this->db->select('del_to.cust_name as del_cust_name,del_to.cust_address as del_cust_address,del_to.cust_gst as del_cust_gst,del_to.cust_city as del_cust_city');
        $this->db->join('bud_concern_master', 'bud_sh_credit_invoices.concern_id=bud_concern_master.concern_id', 'left');
        $this->db->join('bud_customers', 'bud_sh_credit_invoices.customer_id=bud_customers.cust_id', 'left');
        $this->db->join('bud_customers del_to', 'bud_sh_credit_invoices.delivery_to=del_to.cust_id', 'left');
        $this->db->where('bud_sh_credit_invoices.invoice_id', $invoice_id);
        $this->db->where('bud_sh_credit_invoices.is_deleted',1);//ER-07-18#-22
        return $this->db->get('bud_sh_credit_invoices')->row();
    }

    public function get_credit_inv_items($invoice_id = '',$item_id='',$is_deleted=1)//ER-07-18#-23 //ER-08-18#-28
    {
        $this->db->select('bud_sh_credit_invoice_items.*');
        $this->db->select('bud_itemgroups.group_name');
        $this->db->select('bud_items.item_name,bud_items.hsn_code');
        $this->db->select('bud_uoms.uom_name');
        $this->db->select('bud_shades.shade_name, bud_shades.shade_code, bud_shades.category_id', 'left');
        $this->db->join('bud_itemgroups', 'bud_sh_credit_invoice_items.item_group_id=bud_itemgroups.group_id', 'left');
        $this->db->join('bud_items', 'bud_sh_credit_invoice_items.item_id=bud_items.item_id', 'left');
        $this->db->join('bud_shades', 'bud_sh_credit_invoice_items.shade_id=bud_shades.shade_id', 'left');
        $this->db->join('bud_uoms', 'bud_sh_credit_invoice_items.uom_id=bud_uoms.uom_id', 'left');
        if(!empty($invoice_id))
        {
            $this->db->where('bud_sh_credit_invoice_items.invoice_id', $invoice_id);
        }
        if(!empty($item_id))//ER-07-18#-23
        {
            $this->db->where('bud_sh_credit_invoice_items.item_id', $item_id);
        }
        $this->db->where('bud_sh_credit_invoice_items.is_deleted',$is_deleted);//ER-08-18#-28
        return $this->db->get('bud_sh_credit_invoice_items')->result();
    }

    // Quotation
    public function save_quotation($save, $quotation_items = array())
    {
        $quotation_id = false;
        $save['last_edited_id'] = $this->session->userdata('user_id');//ER-07-18#-17
        $save['is_deleted'] =1;//ER-07-18#-17
        if($save['quotation_id'])
        {
            $this->db->where('quotation_id', $save['quotation_id']);
            $this->db->update('bud_sh_quotations', $save);
            $quotation_id = $save['quotation_id'];
        }
        else
        {
            $this->db->insert('bud_sh_quotations', $save);
            $quotation_id = $this->db->insert_id();
        }

        if($quotation_id)
        {
            $this->save_quotation_items($quotation_id, $quotation_items, $save['customer_id']);
        }
        return $quotation_id;
    }
    public function update_quotation($save)
    {
        $save['last_edited_id'] = $this->session->userdata('user_id');//ER-07-18#-17
        $save['is_deleted'] =1;//ER-07-18#-17
        $this->db->where('quotation_id', $save['quotation_id']);
        $this->db->update('bud_sh_quotations', $save);
        $quotation_id = $save['quotation_id'];
    }

    public function save_quotation_items($quotation_id, $quotation_items, $customer_id)
    {
        $delivery_items = array();
        if(sizeof($quotation_items) > 0)
        {
            $delivery_ids = array();
            foreach ($quotation_items as $box) {
                $delivery_ids[$box->delivery_id] = $box->delivery_id;
                $item['delivery_id'] = $box->delivery_id;
                $item['delivery_row_id'] = $box->row_id;
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
                $item['delivery_qty'] = $box->delivery_qty;
                $item['uom_id'] = $box->uom_id;
                $item['is_deleted'] = 1;//ER-07-18#-17
                $item['quotation_id'] = $quotation_id;

                $cust_item_rate = $this->Sales_model->get_item_rate($customer_id, $box->item_id, $box->shade_id);
                if($cust_item_rate)
                {
                    $item_rates = explode(",", $cust_item_rate->item_rates);
                    $item_rate_active = $cust_item_rate->item_rate_active;
                    $item_rate = $item_rates[$item_rate_active];
                    $item['item_rate'] = $item_rate;
                }
                elseif ($this->Sales_model->get_gen_item_rate($box->delivery_qty, $box->item_id, $box->category_id)) {
                    $gen_item_rate = $this->Sales_model->get_gen_item_rate($box->delivery_qty, $box->item_id, $box->category_id);
                    $item['item_rate'] = $gen_item_rate->item_rate;
                }
                else
                {
                    $item['item_rate'] = 0;
                }

                /*$gen_item_rate = $this->Sales_model->get_gen_item_rate($box->delivery_qty, $box->item_id, $box->category_id);
                if($gen_item_rate)
                {
                    $item['item_rate'] = $gen_item_rate->item_rate;
                }*/

                $delivery_items[] = $item;
            }

            $this->db->insert_batch('bud_sh_quotation_items', $delivery_items);

            $this->update_dc_status(array('delivery_id' => implode(",", $delivery_ids), 'delivery_status' => 1));
            // $this->empty_cart();
        }
    }

    public function update_quotation_amt($save)
    {
        $save['last_edited_id'] = $this->session->userdata('user_id');//ER-07-18#-17
        $save['is_deleted'] =1;//ER-07-18#-17
        if($save['quotation_id'])
        {
            $this->db->where('quotation_id', $save['quotation_id']);
            $this->db->update('bud_sh_quotations', $save);
            $quotation_id = $save['quotation_id'];
        }
    }

    public function get_quotation_list($filter = array())
    {
        $this->db->select('bud_sh_quotations.*');
        $this->db->select('bud_concern_master.*');
        $this->db->select('bud_customers.cust_name,bud_customers.cust_address,bud_customers.cust_gst,bud_customers.cust_city');
        $this->db->select('del_to.cust_name as del_cust_name,del_to.cust_address as del_cust_address,del_to.cust_gst as del_cust_gst,del_to.cust_city as del_cust_city');
        $this->db->join('bud_concern_master', 'bud_sh_quotations.concern_id=bud_concern_master.concern_id', 'left');
        $this->db->join('bud_customers', 'bud_sh_quotations.customer_id=bud_customers.cust_id', 'left');
        $this->db->join('bud_customers del_to', 'bud_sh_quotations.delivery_to=del_to.cust_id', 'left');
        if(count($filter) > 0)
        {
            if(isset($filter['cash_tranfered']))
            {
                $this->db->where('bud_sh_quotations.cash_tranfered', $filter['cash_tranfered']);                
            }
            if(isset($filter['is_scrapsales']))
            {
                $this->db->where('bud_sh_quotations.is_scrapsales', $filter['is_scrapsales']);                
            }
        }
        $this->db->where('bud_sh_quotations.is_deleted',1);//ER-07-18#-17
        return $this->db->get('bud_sh_quotations')->result();
    }

    public function get_quotation($quotation_id)
    {
        $this->db->select('bud_sh_quotations.*');
        $this->db->select('bud_concern_master.*');
        $this->db->select('bud_customers.cust_name,bud_customers.cust_address,bud_customers.cust_tinno,bud_customers.cust_gst,bud_customers.cust_city');
        $this->db->select('del_to.cust_name as del_cust_name,del_to.cust_address as del_cust_address,del_to.cust_gst as del_cust_gst,del_to.cust_city as del_cust_city');
        $this->db->join('bud_concern_master', 'bud_sh_quotations.concern_id=bud_concern_master.concern_id', 'left');
        $this->db->join('bud_customers', 'bud_sh_quotations.customer_id=bud_customers.cust_id', 'left');
        $this->db->join('bud_customers del_to', 'bud_sh_quotations.delivery_to=del_to.cust_id', 'left');
        $this->db->where('bud_sh_quotations.quotation_id', $quotation_id);
        $this->db->where('bud_sh_quotations.is_deleted',1);//ER-07-18#-17
        return $this->db->get('bud_sh_quotations')->row();
    }

    public function get_quotation_items($quotation_id = '',$item_id=null,$is_deleted=1)//ER-08-18#-27//ER-08-18#-28
    {
        $this->db->select('bud_sh_quotation_items.*');
        $this->db->select('bud_itemgroups.group_name');
        $this->db->select('bud_items.item_name,bud_items.hsn_code');
        $this->db->select('bud_uoms.uom_name');
        $this->db->select('bud_shades.shade_name, bud_shades.shade_code, bud_shades.category_id');
        $this->db->join('bud_itemgroups', 'bud_sh_quotation_items.item_group_id=bud_itemgroups.group_id', 'left');
        $this->db->join('bud_items', 'bud_sh_quotation_items.item_id=bud_items.item_id', 'left');
        $this->db->join('bud_shades', 'bud_sh_quotation_items.shade_id=bud_shades.shade_id', 'left');
        $this->db->join('bud_uoms', 'bud_sh_quotation_items.uom_id=bud_uoms.uom_id', 'left');
        if(!empty($quotation_id))
        {
            $this->db->where('bud_sh_quotation_items.quotation_id', $quotation_id);
        }
        if(!empty($item_id))//ER-08-18#-27
        {
            $this->db->where('bud_sh_quotation_items.item_id', $item_id);
        }
        $this->db->where('bud_sh_quotation_items.is_deleted',$is_deleted);//ER-07-18#-17//ER-08-18#-28
        return $this->db->get('bud_sh_quotation_items')->result();
    }

    public function get_credit_inv_boxes($invoice_id = '')
    {
        $this->db->select('bud_sh_credit_invoice_items.*');
        $this->db->select('bud_sh_credit_invoices.*');
        $this->db->select('bud_itemgroups.group_name');
        $this->db->select('bud_items.item_name,bud_items.hsn_code');
        $this->db->select('bud_shades.shade_name, bud_shades.shade_code');
        $this->db->join('bud_sh_credit_invoices', 'bud_sh_credit_invoice_items.invoice_id=bud_sh_credit_invoices.invoice_id', 'left');
        $this->db->join('bud_itemgroups', 'bud_sh_credit_invoice_items.item_group_id=bud_itemgroups.group_id', 'left');
        $this->db->join('bud_items', 'bud_sh_credit_invoice_items.item_id=bud_items.item_id', 'left');
        $this->db->join('bud_shades', 'bud_sh_credit_invoice_items.shade_id=bud_shades.shade_id', 'left');
        $this->db->order_by('bud_sh_credit_invoice_items.invoice_id', 'desc');
        if(!empty($invoice_id))
        {
            $this->db->where('bud_sh_credit_invoices.invoice_id', $invoice_id);
        }
        $this->db->where('bud_sh_credit_invoice_items.is_deleted',1);//ER-07-18#-22
        return $this->db->get('bud_sh_credit_invoice_items')->result();
    }
    public function get_enquiry_boxes($quotation_id = '')
    {
        $this->db->select('bud_sh_quotation_items.*');
        $this->db->select('bud_sh_quotations.*');
        $this->db->select('bud_itemgroups.group_name');
        $this->db->select('bud_items.item_name,bud_items.hsn_code');
        $this->db->select('bud_shades.shade_name, bud_shades.shade_code');
        $this->db->join('bud_sh_quotations', 'bud_sh_quotation_items.quotation_id=bud_sh_quotations.quotation_id', 'left');
        $this->db->join('bud_itemgroups', 'bud_sh_quotation_items.item_group_id=bud_itemgroups.group_id', 'left');
        $this->db->join('bud_items', 'bud_sh_quotation_items.item_id=bud_items.item_id', 'left');
        $this->db->join('bud_shades', 'bud_sh_quotation_items.shade_id=bud_shades.shade_id', 'left');
        $this->db->order_by('bud_sh_quotation_items.quotation_id', 'desc');
        if(!empty($quotation_id))
        {
            $this->db->where('bud_sh_quotations.quotation_id', $quotation_id);
        }
        $this->db->where('bud_sh_quotation_items.is_deleted',1);//ER-07-18#-17
        $this->db->where('bud_sh_quotations.is_deleted',1);//ER-07-18#-17
        return $this->db->get('bud_sh_quotation_items')->result();
    }

    public function get_rate_master_list()
    {
        $this->db->select('bud_sh_itemrates.*');
        $this->db->select('bud_items.item_name,bud_items.hsn_code');
        $this->db->select('bud_customers.cust_name');
        $this->db->select('bud_shades.shade_name, bud_shades.shade_code');
        $this->db->join('bud_items', 'bud_sh_itemrates.item_id=bud_items.item_id', 'left');
        $this->db->join('bud_shades', 'bud_sh_itemrates.shade_id=bud_shades.shade_id', 'left');
        $this->db->join('bud_customers', 'bud_sh_itemrates.customer_id=bud_customers.cust_id', 'left');
        return $this->db->get('bud_sh_itemrates')->result();
    }
    public function get_gen_rate_master_list()
    {
        $this->db->select('bud_sh_gen_itemrates.*');
        $this->db->select('bud_items.item_name,bud_items.hsn_code');
        $this->db->select('bud_color_category.color_category');
        $this->db->join('bud_items', 'bud_sh_gen_itemrates.item_id=bud_items.item_id', 'left');
        $this->db->join('bud_color_category', 'bud_sh_gen_itemrates.category_id=bud_color_category.category_id', 'left');
        return $this->db->get('bud_sh_gen_itemrates')->result();
    }

    public function get_cust_credit_amt($customer_id = false)
    {
        $this->db->select('SUM(bud_sh_credit_invoices.invoice_amt) AS tot_invoice_amt', FALSE);
        $this->db->select('SUM(bud_sh_cash_receipts.amount) AS tot_cash_receipt', FALSE);
        $this->db->join('bud_sh_cash_receipts', 'bud_sh_credit_invoices.customer_id=bud_sh_cash_receipts.customer_id', 'left');
        $this->db->where('bud_sh_credit_invoices.customer_id', $customer_id);
        $this->db->where('bud_sh_credit_invoices.is_deleted',1);//ER-07-18#-22
        return $this->db->get('bud_sh_credit_invoices')->row();
    }
    public function existing_quoation_nos()//ER-07-18#-17
    {
        $quotation_nos=array();
        $quotations=$this->m_masters->getmasterdetails('bud_sh_quotations','is_deleted',0);
        foreach ($quotations as $quotation) {
            $condition=array('quotation_no' =>$quotation['quotation_no'],
                             'is_deleted'=>1  );
            $new_created=$this->m_mir->get_two_table_values('bud_sh_quotations',null,'quotation_no',null,null,$condition);
            if(empty($new_created))
            {
                $quotation_nos[]=$quotation['quotation_no'];
            }
        }
        return $quotation_nos;
    }
     public function get_quotation_count($concern)//ER-07-18#-17
    {
        $quotation_nos=array();
        $condition=array('concern_id' =>$concern,
                             'is_deleted'=>1  );
        $quotations=$this->m_mir->get_two_table_values('bud_sh_quotations',null,'quotation_no',null,null,$condition);
        $condition=array('concern_id' =>$concern,
                             'is_deleted'=>0  );
        $deleted_quotations=$this->m_mir->get_two_table_values('bud_sh_quotations',null,'quotation_no',null,null,$condition);
        foreach ($deleted_quotations as $quotation) {
            $condition=array('quotation_no' =>$quotation['quotation_no'],
                             'is_deleted'=>1  );
            $new_created=$this->m_mir->get_two_table_values('bud_sh_quotations',null,'quotation_no',null,null,$condition);
            if(empty($new_created))
            {
                $quotation_nos[$quotation['quotation_no']]=$quotation['quotation_no'];
            }
        }
        $count=count($quotations)+count($quotation_nos);
        return $count;
    }
    public function update_delete_status_invoice_sh($invoice_id,$remarks,$type)//ER-07-18#-22
    {
        $tablename=($type=='credit')?"bud_sh_credit_invoices":"bud_sh_cash_invoices";
        $item_table=($type=='credit')?"bud_sh_credit_invoice_items":"bud_sh_cash_invoice_items";
        $data = array('is_deleted' => '0',
                      'remarks' => $remarks,
                      'last_edited_id' => $this->session->userdata('user_id'),
                      'last_edited_time' => date('Y-m-d H:i:s')
                    );
        $this->db->where('invoice_id', $invoice_id);
        $result=$this->db->update($tablename, $data);
        if($result)
        {
            $updateData = array(
                'is_deleted' => 0 
                );
            $result=$this->m_purchase->updateDatas($item_table,'invoice_id', $invoice_id, $updateData);
        }
        $invoices=$this->m_masters->getmasterdetails($item_table,'invoice_id',$invoice_id);
        $invoice_no=$this->m_masters->getmasterIDvalue($tablename,'invoice_id',$invoice_id,'invoice_no');
        $dc_remarks=$type.' Invoice '.$invoice_no.' Deleted coz of'.$remarks;
        foreach ($invoices as $invoice) {
            $delivery_id=$invoice['delivery_id'];
            $p_delivery_id=$this->m_masters->getmasterIDvalue('bud_sh_delivery','delivery_id',$delivery_id,'p_delivery_id');
            if ($result) {
                $result=$this->Delivery_model->update_delete_status_delivery_sh($delivery_id,$dc_remarks);
            }
            if ($result) {
                $result=$this->Predelivery_model->update_delete_status_predelivery_sh($p_delivery_id,$dc_remarks);
            }
        }
        $result=($result)?$invoice_no:$result;
        return $result;
    }
    public function existing_invoice_nos($type)//ER-07-18#-22
    {
        $tablename=($type=='credit')?"bud_sh_credit_invoices":"bud_sh_cash_invoices";
        $invoice_nos=array();
        $invoices=$this->m_masters->getmasterdetails($tablename,'is_deleted',0);
        foreach ($invoices as $invoice) {
            $condition=array('invoice_no' =>$invoice['invoice_no'],
                             'is_deleted'=>1  );
            $new_created=$this->m_mir->get_two_table_values($tablename,null,'invoice_no',null,null,$condition);
            if(empty($new_created))
            {
                $invoice_nos[]=$invoice['invoice_no'];
            }
        }
        return $invoice_nos;
    }
     public function get_invoice_count($concern,$type)//ER-07-18#-22
    {
        $tablename=($type=='credit')?"bud_sh_credit_invoices":"bud_sh_cash_invoices";
        $invoice_nos=array();
        $condition=array('concern_id' =>$concern,
                             'is_deleted'=>1  );
        $invoices=$this->m_mir->get_two_table_values($tablename,null,'invoice_no',null,null,$condition);
        $condition=array('concern_id' =>$concern,
                             'is_deleted'=>0  );
        $deleted_invoices=$this->m_mir->get_two_table_values($tablename,null,'invoice_no',null,null,$condition);
        foreach ($deleted_invoices as $invoice) {
            $condition=array('invoice_no' =>$invoice['invoice_no'],
                             'is_deleted'=>1  );
            $new_created=$this->m_mir->get_two_table_values($tablename,null,'invoice_no',null,null,$condition);
            if(empty($new_created))
            {
                $invoice_nos[$invoice['invoice_no']]=$invoice['invoice_no'];
            }
        }
        $count=count($invoices)+count($invoice_nos);
        return $count;
    }
}