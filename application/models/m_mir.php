<?php
class M_mir extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }
   
    //changes on zipper3.0 doc:2
    function get_cust_sales_rep_te($from_date = null, $to_date = null,$cust)
    {
        if(!empty($from_date))
        {
            $this->db->where('invoice_date >=',$from_date);
        }
        if(!empty($to_date))
        {
            $this->db->where('invoice_date <=',$to_date);
        }
        $this->db->where('customer',$cust);
        $this->db->select('net_amount,invoice_no,customer,invoice_date');
        $this->db->from('bud_te_invoices');
        $this->db->order_by('invoice_date','desc');
        $return=$this->db->get()->result_array();
        return $return;
    }
    //changes on zipper3.0 doc:2
    function get_item_sales_rep_te($from_date = null, $to_date = null,$item=null,$term,$month)
    {
        $date_format=($term==2)?'Y':'M-y';
        if(!empty($from_date))
        {
            $this->db->where('invoice_date >=',$from_date);
        }
        if(!empty($to_date))
        {
            $this->db->where('invoice_date <=',$to_date);
        }
        $this->db->select('invoice_items, item_weights, item_rate, sub_total, invoice_date, invoice_no, item_uoms');
        $this->db->from('bud_te_invoices');
        $this->db->order_by('invoice_date','desc');
        $all_invoices=$this->db->get()->result_array();
        $this->db->select_sum('sub_total');
        $this->db->from('bud_te_invoices');
        $this->db->order_by('invoice_date','desc');
        $invoices=$this->db->get()->result_array();
        $data['grand_tot']=$invoices[0]['sub_total'];
        $data['tot_inv_rate']=0;
        $data['tot_inv_num']=array();
        foreach ($all_invoices as $all_inv) {
            $term_value=date($date_format,strtotime($all_inv['invoice_date']));
            $invoice_items=explode(',',$all_inv['invoice_items']);
            $item_rate=explode(',',$all_inv['item_rate']);
            $item_weights=explode(',',$all_inv['item_weights']);
            $item_uoms=explode(',',$all_inv['item_uoms']);
            foreach ($invoice_items as $key => $value) {
                if(($item!=0)&&($value!=$item))
                   continue;
                $this->db->select('item_name');
                $this->db->from('bud_te_items');
                $this->db->where('item_id',$value);
                $items=$this->db->get()->result_array(); 
                $item_name=$items[0]['item_name'].'-'.$value;
                $rate=$item_rate[$key]*$item_weights[$key];
                $data[$item_name][$term_value][$item_uoms[$key]]['item_rate'][$all_inv['invoice_no']]=$rate;
                $data[$item_name][$term_value][$item_uoms[$key]]['item_wt'][$all_inv['invoice_no']]=$item_weights[$key];
                $data[$item_name][$term_value]['inv_num'][$all_inv['invoice_no']]=1;
                $data['tot_inv_num'][$all_inv['invoice_no']]=1;
                $data['tot_inv_rate']+=$rate;
            }
        }
        return $data;
    } 
function get_item_pack_rep_te($from_date = null, $to_date = null,$item = null,$term=2,$uom=null)
    {
        $date_format=($term==2)?'Y':'M-y';
        if(!empty($from_date))
        {
            $this->db->where('packing_date >=',$from_date);
        }
        if(!empty($to_date))
        {
            $this->db->where('packing_date <=',$to_date);
        }
        if(!empty($uom))
        {
            $this->db->where_in('item_uom',$uom);//error correction
        }
        if(!empty($item))
        {
            $this->db->where('packing_innerbox_items',$item);
        }
        $this->db->select('bud_te_outerboxes.*, bud_te_items.item_name, bud_te_items.item_weight_mtr,bud_uoms.uom_name');
        $this->db->join('bud_uoms','bud_uoms.uom_id = bud_te_outerboxes.item_uom','left');
        $this->db->join('bud_te_items','bud_te_items.item_id = bud_te_outerboxes.packing_innerbox_items','left');
        $this->db->from('bud_te_outerboxes');
        $this->db->order_by('packing_innerbox_items','desc');
        $outerboxes=$this->db->get()->result_array();
        $this->db->select('boxes_array');
        $this->db->from('bud_te_invoices');
        $invoice=$this->db->get()->result_array(); 
        $return['tot_items']=array();
        $return['tot_kgs']=array();
        $return['tot_qty']['stock']=array();
        $return['tot_qty']['delivered']=array();
        $return['tot_qty']['invoiced']=array();
        $return['tot_qty']['non-invoiced']=array();
        foreach ($outerboxes as $box) {
            $item_name=$box['item_name'].'/'.$box['packing_innerbox_items'];
            $date=date($date_format,strtotime($box['packing_date']));
            $return[$item_name][$date]['uom_qty']['stock']=array();
            $return[$item_name][$date]['uom_qty']['delivered']=array();
            $return[$item_name][$date]['uom_qty']['invoiced']=array();
            $return[$item_name][$date]['uom_qty']['non-invoiced']=array();
            $return[$item_name][$date]['kgs']=array();
        }
        foreach ($outerboxes as $box) {   
            $item_name=$box['item_name'].'/'.$box['packing_innerbox_items'];
            $date=date($date_format,strtotime($box['packing_date']));
            if($box['delivery_status']=='1')
            {
                $status='delivered';
                foreach ($invoice as $inv) {
                    $boxes_array=explode(',',$inv['boxes_array']);
                    foreach ($boxes_array as $key=>$value) {
                        if($value==$box['box_no'])
                        {
                            $status='invoiced';
                            break;
                        }
                        else
                        {
                            $status='non-invoiced';
                        }
                    }
                }
            }
            else
            {
                $status='stock';
            }
            $return['tot_items'][$item_name]=1;
            $return['tot_kgs'][]=$box['packing_net_weight'];;
            $return['tot_qty'][$status][]=$box['total_meters'];
            $return[$item_name][$date]['uom_qty'][$status][$box['uom_name']][]=$box['total_meters'];
            $return[$item_name][$date]['kgs'][]=$box['packing_net_weight'];
        }
        return $return;
     }
    //zipper 3.0 lbl-isr,ipr,csr
    function get_item_sales_rep_lbl($from_date = null, $to_date = null,$item=null,$cust=null,$term=1,$month)
    {
        $date_format=($term==2)?'Y':'M-y';
        if(!empty($from_date))
        {
            $this->db->where('bud_lbl_invoices.invoice_date >=',$from_date);
        }
        if(!empty($to_date))
        {
            $this->db->where('bud_lbl_invoices.invoice_date <=',$to_date);
        }
        if(!empty($item))
        {
            $this->db->where('bud_lbl_predelivery_items.item_id',$item);
        }
        if(!empty($cust))
        {
            $this->db->where('bud_lbl_invoices.customer',$cust);
        }
        $this->db->where('bud_lbl_predelivery_items.invoice_id !=',0);
        $this->db->select('bud_lbl_invoices.*,bud_lbl_items.item_name,cust_name,bud_lbl_predelivery_items.*');
        $this->db->from('bud_lbl_predelivery_items');
        $this->db->join('bud_lbl_invoices','bud_lbl_predelivery_items.invoice_id = bud_lbl_invoices.invoice_id','left');
        $this->db->join('bud_customers','bud_customers.cust_id = bud_lbl_invoices.customer','left');
        $this->db->join('bud_lbl_items','bud_lbl_predelivery_items.item_id = bud_lbl_items.item_id','left');
        $this->db->order_by('invoice_date','desc');
        $invoices=$this->db->get()->result_array();
        $data['tot_inv_wt']=0;
        $data['tot_invs']=array();
        $data['tot_inv_price']=0;
        foreach ($invoices as $invoice) {
            $amt=$invoice['delivery_qty']*$invoice['item_rate'];
            $data[$invoice['item_id']][date($date_format,strtotime($invoice['invoice_date']))]['inv_no'][$invoice['invoice_id']]=$invoice['invoice_no'];
             $data[$invoice['item_id']][date($date_format,strtotime($invoice['invoice_date']))]['cust_name'][$invoice['customer']]=$invoice['cust_name'].'-'.$invoice['customer'];
            $data[$invoice['item_id']][date($date_format,strtotime($invoice['invoice_date']))]['item_name']=$invoice['item_name'].'/'.$invoice['item_id'];
            $data[$invoice['item_id']][date($date_format,strtotime($invoice['invoice_date']))]['inv_wt'][$invoice['invoice_id']][$invoice['item_size']]=$invoice['delivery_qty'];
            $data[$invoice['item_id']][date($date_format,strtotime($invoice['invoice_date']))]['inv_price'][$invoice['invoice_id']][$invoice['item_size']]=$amt;
            $data['tot_inv_wt']+=$invoice['delivery_qty'];
            $data['tot_inv_price']+=$amt;
            $data['tot_invs'][$invoice['invoice_id']]=$invoice['invoice_id'];
        }
        return $data;
    }
    function get_cust_sales_rep_lbl($from_date = null, $to_date = null,$cust=null,$term=1,$month)
    {
        $date_format=($term==2)?'Y':'M-y';
        if(!empty($from_date))
        {
            $this->db->where('invoice_date >=',$from_date);
        }
        if(!empty($to_date))
        {
            $this->db->where('invoice_date <=',$to_date);
        }
        if($cust!='0')
        {
            $this->db->where('bud_lbl_invoices.customer',$cust);
        }
        $this->db->select('invoice_items, item_rate, invoice_date, invoice_no, invoice_id, boxes_array, invoice_items_row, sub_total, net_amount, customer');
        $this->db->from('bud_lbl_invoices');
        //$this->db->join('bud_customers','bud_customers.cust_id = bud_lbl_invoices.customer');
        $this->db->order_by('invoice_date','desc');
        $invoices=$this->db->get()->result_array();
        $data['tot_inv_wt']=0;
        $data['tot_invs']=0;
        $data['tot_inv_rate']=0;
        $data['tot_inv_amt']=0;
        foreach ($invoices as $invoice) {
            $item_array=explode(',', $invoice['invoice_items_row']);
            $rate=0;
            $qty=$this->m_production->boxDeliveredQty(null,null,null,null,null,$invoice['invoice_id']);
            $item_name=array();
            foreach ($item_array as $key => $value) {
                $item_row=explode('-', $value);
                $rate+=$item_row[5]; 
                $this->db->select('item_name');
                $this->db->from('bud_lbl_items');
                $this->db->where('item_id',$item_row[0]);
                $items=$this->db->get()->result_array();
                $item_name[$item_row[0]]=$items[0]['item_name'];  
            }
            $data[$invoice['customer']][date($date_format,strtotime($invoice['invoice_date']))]['inv_no'][$invoice['invoice_id']]=$invoice['invoice_no'];
            foreach ($item_name as $id => $value) {
                $data[$invoice['customer']][date($date_format,strtotime($invoice['invoice_date']))]['inv_items'][$id]=$value;
            }
            $data[$invoice['customer']][date($date_format,strtotime($invoice['invoice_date']))]['inv_wt'][$invoice['invoice_id']]=$qty;
            $data[$invoice['customer']][date($date_format,strtotime($invoice['invoice_date']))]['rate'][$invoice['invoice_id']]=round($invoice['sub_total']);
            $data[$invoice['customer']][date($date_format,strtotime($invoice['invoice_date']))]['amount'][$invoice['invoice_id']]=$invoice['net_amount'];
            $data['tot_inv_wt']+=$qty;
            $data['tot_inv_rate']+=round($invoice['sub_total']);
            $data['tot_inv_amt']+=$invoice['net_amount'];
            $data['tot_invs']+=1;
        } 
        return $data;
    }
    function get_item_packing_rep_lbl($from_date = null, $to_date = null,$item=null,$term=1,$month)
    {
        $date_format=($term==2)?'Y':'M-y';
        if(!empty($from_date))
        {
            $this->db->where('date_time >=',$from_date);
        }
        if(!empty($to_date))
        {
            $this->db->where('date_time <=',$to_date);
        }
        if($item!='0')
        {
            $this->db->where('bud_lbl_outerboxes.item_id',$item);
        }
        $this->db->where('is_deleted','0');
        $this->db->select('bud_lbl_items.item_name,bud_lbl_outerboxes.*');
        $this->db->from('bud_lbl_outerboxes');
        $this->db->join('bud_lbl_items','bud_lbl_outerboxes.item_id = bud_lbl_items.item_id','left');
        $this->db->order_by('bud_lbl_outerboxes.item_id','asc');
        $boxes_items=$this->db->get()->result_array();
        $data['tot_box_wt']=0;
        $data['tot_box']=0;
        $data['tot_delv_box']=0;
        $data['tot_stock_box']=0;
        $data['tot_inv_box']=0;
        $data['tot_ninv_box']=0;
        $data['tot_res_box']=0;
        foreach ($boxes_items as $boxes) {
            $data[$boxes['item_id']][date($date_format,strtotime($boxes['date_time']))]['delv']=array();
            $data[$boxes['item_id']][date($date_format,strtotime($boxes['date_time']))]['res']=array();
            $data[$boxes['item_id']][date($date_format,strtotime($boxes['date_time']))]['stock']=array();
        }
        foreach ($boxes_items as $boxes) {
            $this->db->select('box_no,item_size,total_qty');
            $this->db->where_in('box_no',$boxes['box_no']);
            $this->db->from('bud_lbl_outerbox_items');
            $size_items=$this->db->get()->result_array();
            $qty=array();
            foreach ($size_items as $size_item) {
                $qty[$size_item['item_size']]=$size_item['total_qty'];
            }
            if(($boxes['predelivery_status']=='0')&&($boxes['delivery_status']=='1'))
            { 
                $status='res';  
                $data['tot_res_box']++;
            }
            elseif($boxes['delivery_status']=='0')
            {   
                $data['tot_delv_box']++;
                $status='delv';
                if(!empty($from_date))
                {
                    $this->db->where('invoice_date >=',$from_date);
                }
                if(!empty($to_date))
                {
                    $this->db->where('invoice_date <=',$to_date);
                }
                $this->db->select('boxes_array,invoice_date');
                $this->db->from('bud_lbl_invoices');
                $invoices=$this->db->get()->result_array();
                $check=0;
                foreach ($invoices as $inv) {
                    $inv_box=explode(',',$inv['boxes_array']);
                    foreach
                     ($inv_box as $key => $value) {
                        if($value==$boxes['box_no'])
                        {
                           $data[$boxes['item_id']][date($date_format,strtotime($inv['invoice_date']))]['invoiced'][]=$boxes['box_prefix'].'-'.$boxes['box_no']; 
                           $check=1;
                           break;
                        }
                    }
                    if($check==1)
                    {
                        $data['tot_inv_box']++;
                        break;
                    }
                }
                if($check==0)
                {
                    $data['tot_ninv_box']++;
                    $data[$boxes['item_id']][date($date_format,strtotime($boxes['date_time']))]['non_invoiced'][]=$boxes['box_prefix'].'-'.$boxes['box_no'];
                }
            }
            else   
            {
                $status='stock';
                $data['tot_stock_box']++;
            }
                
            $data[$boxes['item_id']][date($date_format,strtotime($boxes['date_time']))][$status][$boxes['box_prefix'].'-'.$boxes['box_no']]=$boxes['box_prefix'].'-'.$boxes['box_no'];
            $data[$boxes['item_id']][date($date_format,strtotime($boxes['date_time']))]['item_name']=$boxes['item_name'];
            $data[$boxes['item_id']][date($date_format,strtotime($boxes['date_time']))]['box_wt'][$boxes['box_no']]=$qty;
            $data[$boxes['item_id']][date($date_format,strtotime($boxes['date_time']))]['box_t_wt'][$boxes['box_no']]=array_sum($qty);
            $data['tot_box_wt']+=array_sum($qty);
            $data['tot_box']+=1;
        } 
        return $data;
    }
    //end of zipper 3.0 lbl-isr,ipr,csr
    //Abstract Report Labels 
    function get_abstract_rep_lbl($term=2,$selected_month,$selected_year)
    {
        //initialization
        $data['tot_inv_qty']=0;
        $data['tot_inv_amt_a']=0;
        $data['tot_inv_amt_b']=0;
        $data['tot_pkd_amt']['del']=0;
        $data['tot_pkd_qty']['del']=0;
        $data['tot_pkd_amt']['stock']=0;
        $data['tot_pkd_qty']['stock']=0;
        $data['tot_prod_amt']=0;
        $data['tot_prod_qty']=0;
        $year=($selected_year==0)?date('Y'):$selected_year;
        $end_year=($selected_year==0)?'2015':$selected_year;
        while ($year>=$end_year) {
            if($term==2)
            {
                $date_format=$year;
                $start_date=date('Y-m-d',strtotime('01-01-'.$date_format));
                $end_date=date('Y-m-d',strtotime('31-12-'.$date_format));
                $mon=1;
                $end_month=1;
            }
            elseif($term==1)
            {
                $mon=($selected_month==0)?date('m'):$selected_month;
                $end_month=($selected_month==0)?1:$selected_month;
            }
            while($mon>=$end_month) {
                //initialization
                if($term==1)
                {
                    $month=($mon>9)?$mon:'0'.$mon;
                    $date_format=$month.'-'.$year;
                    $start_date=date('Y-m-d',strtotime('01-'.$date_format));
                    $end_date=date('Y-m-t',strtotime('01-'.$date_format));
                }
                $data['details'][$date_format]['pkd_amt']['del']=0;
                $data['details'][$date_format]['pkd_amt']['stock']=0;
                $data['details'][$date_format]['pkd_qty']['del']=0;
                $data['details'][$date_format]['pkd_qty']['stock']=0;
                $data['details'][$date_format]['inv_qty']=0;
                $data['details'][$date_format]['prod_amt']=0;
                $data['details'][$date_format]['prod_qty']=0;
                //condition
                $inv_condition = array(
                'invoice_date >='=>$start_date,
                'invoice_date <='=>$end_date
                );
                $pkd_condition = array(
                'bud_lbl_outerboxes.date_time >='=>$start_date,
                'bud_lbl_outerboxes.date_time <='=>$end_date,
                'bud_lbl_outerboxes.is_deleted'=>'0'
                );
                $prod_condition = array(
                'date >='=>$start_date,
                'date <='=>$end_date
                );
                $this->db->select_sum('sub_total');
                $this->db->where($inv_condition);
                $this->db->from('bud_lbl_invoices');
                $sub_total=$this->db->get()->result_array();
                $this->db->select_sum('net_amount');
                $this->db->where($inv_condition);
                $this->db->from('bud_lbl_invoices');
                $net_amount=$this->db->get()->result_array();
                $this->db->select('boxes_array');
                $this->db->where($inv_condition);
                $this->db->from('bud_lbl_invoices');
                $invoices=$this->db->get()->result_array();
                $this->db->select('bud_lbl_outerbox_items.box_no, item_size, total_qty, bud_lbl_outerbox_items.item_id,delivery_status, date_time');
                $this->db->where($pkd_condition);
                $this->db->from('bud_lbl_outerbox_items');
                $this->db->join('bud_lbl_outerboxes','bud_lbl_outerbox_items.box_no = bud_lbl_outerboxes.box_no');
                $boxes=$this->db->get()->result_array();
                $this->db->select('no_labels_tape, no_tape');
                $this->db->where($prod_condition);
                $this->db->from('bud_lbl_rollentry');
                $prod=$this->db->get()->result_array();
                $data['details'][$date_format]['inv_amt_b']=($sub_total==null)?0:$sub_total[0]['sub_total'];
                $data['details'][$date_format]['inv_amt_a']=($net_amount==null)?0:$net_amount[0]['net_amount'];
                $data['tot_inv_amt_b']+=$sub_total[0]['sub_total'];
                $data['tot_inv_amt_a']+=$net_amount[0]['net_amount'];
                foreach ($boxes as $box) {
                    $this->db->select_min('item_rates');
                    $this->db->from('bud_lbl_itemrates');
                    $this->db->where('item_id',$box['item_id']);
                    $rates=$this->db->get()->result_array();
                    $rate=$rates[0]['item_rates'];
                    if($box['delivery_status']=='0')
                    {
                        $data['details'][$date_format]['pkd_amt']['del']+=$box['total_qty']*$rate;
                        $data['details'][$date_format]['pkd_qty']['del']+=$box['total_qty'];
                        $data['tot_pkd_amt']['del']+=$box['total_qty']*$rate;
                        $data['tot_pkd_qty']['del']+=$box['total_qty'];
                    }
                    else
                    {
                        $data['details'][$date_format]['pkd_amt']['stock']+=$box['total_qty']*$rate;
                        $data['details'][$date_format]['pkd_qty']['stock']+=$box['total_qty'];
                        $data['tot_pkd_amt']['stock']+=$box['total_qty']*$rate;
                        $data['tot_pkd_qty']['stock']+=$box['total_qty'];
                    }
                }
                foreach ($prod as $prd) {
                    $this->db->select_min('item_rates');
                    $this->db->from('bud_lbl_itemrates');
                    $this->db->where('item_id',$box['item_id']);
                    $rates=$this->db->get()->result_array();
                    $rate=$rates[0]['item_rates'];
                    $tape=explode(',',$prd['no_tape']);
                    $labels=explode(',',$prd['no_labels_tape']);
                    $qty=0;
                    foreach ($tape as $key => $value) {
                        $qty+=$value*$labels[$key];
                    }
                    $data['details'][$date_format]['prod_amt']+=$qty*$rate;
                    $data['details'][$date_format]['prod_qty']+=$qty;
                    $data['tot_prod_amt']+=$qty*$rate;
                    $data['tot_prod_qty']+=$qty;
                }
                foreach ($invoices as $invoice) {
                    $boxes_array=explode(',', $invoice['boxes_array']);
                    foreach ($boxes_array as $key => $value) {
                        $this->db->select_sum('total_qty');
                        $this->db->where('box_no',$value);
                        $this->db->from('bud_lbl_outerbox_items');
                        $box_wt=$this->db->get()->result_array();
                        $data['details'][$date_format]['inv_qty']+=$box_wt[0]['total_qty'];   
                        $data['tot_inv_qty']+=$box_wt[0]['total_qty'];
                    }
                }
                //decrement
                $mon--;
            }
            //decrement
            $mon=($term==2)?1:12;
            $year--;
        }
        return $data;
    }

    function get_abstract_rep_te($term,$selected_month,$selected_year)
    {
        //echo $selected_month;
        //echo $selected_year;
        //echo $term;
        //initialization
        $data['tot_inv_qty']=0;
        $data['tot_inv_amt_a']=0;
        $data['tot_inv_amt_b']=0;
        $data['tot_pkd_amt']['del']=0;
        $data['tot_pkd_qty']['del']=0;
        $data['tot_pkd_amt']['stock']=0;
        $data['tot_pkd_qty']['stock']=0;
        $year=($selected_year==0)?date('Y'):$selected_year;
        $end_year=($selected_year==0)?'2015':$selected_year;
        while ($year>=$end_year) {
            if($term==2)
            {
                $date_format=$year;
                $start_date=date('Y-m-d',strtotime('01-01-'.$date_format));
                $end_date=date('Y-m-d',strtotime('31-12-'.$date_format));
                $mon=1;
                $end_month=1;
            }
            elseif($term==1)
            {
                $mon=($selected_month==0)?date('m'):$selected_month;
                $end_month=($selected_month==0)?1:$selected_month;
            }
            while($mon>=$end_month) {
                //initialization
                if($term==1)
                {
                    $month=($mon>9)?$mon:'0'.$mon;
                    $date_format=$month.'-'.$year;
                    $start_date=date('Y-m-d',strtotime('01-'.$date_format));
                    $end_date=date('Y-m-t',strtotime('01-'.$date_format));
                }
                $data['details'][$date_format]['pkd_amt']['del']=0;
                $data['details'][$date_format]['pkd_amt']['stock']=0;
                $data['details'][$date_format]['pkd_qty']['del']=0;
                $data['details'][$date_format]['pkd_qty']['stock']=0;
                $data['details'][$date_format]['inv_qty']=0;
                //condition
                $inv_condition = array(
                'invoice_date >='=>$start_date,
                'invoice_date <='=>$end_date
                );
                $pkd_condition = array(
                'bud_te_outerboxes.packing_date >='=>$start_date,
                'bud_te_outerboxes.packing_date <='=>$end_date,
                );
                $this->db->select_sum('sub_total');
                $this->db->where($inv_condition);
                $this->db->from('bud_te_invoices');
                $sub_total=$this->db->get()->result_array();
                $this->db->select_sum('net_amount');
                $this->db->where($inv_condition);
                $this->db->from('bud_te_invoices');
                $net_amount=$this->db->get()->result_array();
                $this->db->select('boxes_array');
                $this->db->where($inv_condition);
                $this->db->from('bud_te_invoices');
                $invoices=$this->db->get()->result_array();
                $this->db->select('box_no,total_meters,packing_innerbox_items, delivery_status,packing_date');
                $this->db->where($pkd_condition);
                $this->db->from('bud_te_outerboxes');
                $boxes=$this->db->get()->result_array();
                $data['details'][$date_format]['inv_amt_b']=($sub_total==null)?0:$sub_total[0]['sub_total'];
                $data['details'][$date_format]['inv_amt_a']=($net_amount==null)?0:$net_amount[0]['net_amount'];
                $data['tot_inv_amt_b']+=$sub_total[0]['sub_total'];
                $data['tot_inv_amt_a']+=$net_amount[0]['net_amount'];
                foreach ($boxes as $box) {
                    $this->db->select_min('item_rates');
                    $this->db->from('bud_te_itemrates');
                    $this->db->where('item_id',$box['packing_innerbox_items']);
                    $rates=$this->db->get()->result_array();
                    $rate=$rates[0]['item_rates'];
                    $status=($box['delivery_status']=='0')?'del':'stock';
                    $data['details'][$date_format]['pkd_amt'][$status]+=$box['total_meters']*$rate;
                    $data['details'][$date_format]['pkd_qty'][$status]+=$box['total_meters'];
                    $data['tot_pkd_amt'][$status]+=$box['total_meters']*$rate;
                    $data['tot_pkd_qty'][$status]+=$box['total_meters'];
                }
                foreach ($invoices as $invoice) {
                    $boxes_array=explode(',', $invoice['boxes_array']);
                    foreach ($boxes_array as $key => $value) {
                        $this->db->select_sum('total_meters');
                        $this->db->where('box_no',$value);
                        $this->db->from('bud_te_outerboxes');
                        $box_wt=$this->db->get()->result_array();
                        $data['details'][$date_format]['inv_qty']+=$box_wt[0]['total_meters'];   
                        $data['tot_inv_qty']+=$box_wt[0]['total_meters'];
                    }
                }
                //decrement
                $mon--;
            }
            //decrement
            $mon=($term==2)?1:12;
            $year--;
        }
        return $data;
    }
    //end ofAbstract Report Labels

    //zipper 3.0 doc 3
    function getalldata_odr_field_name($tablename=null,$active_field=null,$order_by=null)
    {
        $this->db->select('*')
                 ->from($tablename)
                 ->where($active_field,1)
                 ->order_by($order_by,'asc');
        $query = $this -> db -> get();
        return $query->result_array();
    }
    //zipper 3.0 doc 3
    function getcolumn($tablename,$column_name)
    {
         $this->db->select($column_name)
                 ->from($tablename);
        $query = $this -> db -> get();
        return $query->result_array();
    }
    //zipper 3.0 doc 3
    function getgroupfields($tablename,$column_name,$condition)
    {
         $this->db->select($column_name)
                 ->from($tablename)
                 ->where($condition);
        $query = $this -> db -> get();
        return $query->result_array();
    }
    //yarns and theard packing
    function get_item_pack_rep_yt($from_date = null, $to_date = null,$item)
    {
        if(!empty($from_date))
        {
            $this->db->where('packed_date >=',$from_date);
        }
        if(!empty($to_date))
        {
            $this->db->where('packed_date <=',$to_date);
        }
        $this->db->where('item_id',$item);
        $this->db->select('net_weight,no_of_cones,packed_date');
        $this->db->from('bud_yt_packing_boxes');
        $this->db->order_by('packed_date','desc');
        $return=$this->db->get()->result_array();
        return $return;
    }
    function get_item_pack_rep_lbl($from_date = null, $to_date = null,$item,$uom=null)
    {
        if(!empty($from_date))
        {
            $this->db->where('date_time >=',$from_date);
        }
        if(!empty($to_date))
        {
            $this->db->where('date_time <=',$to_date);
        }
        if(!empty($uom))
        {
            $this->db->where('item_uom',$uom);
        }
        $this->db->where('packing_innerbox_items',$item);
        $this->db->select('item_id,date_time,packing_uom,total_meters,packing_net_weight');
        $this->db->from('bud_lbl_outerboxes');
        $this->db->order_by('date_time','desc');
        $return=$this->db->get()->result_array();
        return $return;
    }
    function get_rep_datas($from_date = null, $to_date = null,$condition=null,$fields,$tablename,$date_name)
    {

        if(!empty($from_date))
        {
            $this->db->where($date_name.' >=',$from_date);
        }
        if(!empty($to_date))
        {
            $this->db->where($date_name.' <=',$to_date);
        }
        $this->db->where($condition);
        $this->db->select($fields);
        $this->db->from($tablename);
        $this->db->order_by($date_name,'desc');
        $return=$this->db->get()->result_array();
        return $return;
    }
    //changes on zipper3.0 doc:2
    function get_item_sales_rep_yt($from_date = null, $to_date = null,$item=null,$term,$month)
    {
        if($item!='0')
        {
            $this->db->where('item_id',$item);
        }
        $this->db->select('item_name,item_id');
        $this->db->from('bud_items');
        $this->db->order_by('item_id','asc');
        $all_items=$this->db->get()->result_array();
        if(!empty($from_date))
        {
            $this->db->where('invoice_date >=',$from_date);
        }
        if(!empty($to_date))
        {
            $this->db->where('invoice_date <=',$to_date);
        }
        $this->db->select('boxes_array,item_weights,item_rate,sub_total,invoice_date');
        $this->db->from('bud_yt_invoices');
        $this->db->order_by('invoice_date','desc');
        $all_invoices=$this->db->get()->result_array();
        $this->db->select('sub_total');
        $this->db->from('bud_yt_invoices');
        $this->db->order_by('invoice_date','desc');
        $invoices=$this->db->get()->result_array();
        $data['grand_tot']=0;
        foreach ($invoices as $inv) {
            $data['grand_tot']+=$inv['sub_total'];
        }
        $data['item_tot']=0;
        foreach ($all_items as $all_item) {
            $data[$all_item['item_id']]['item_name']=$all_item['item_name'];
            if ($term=='1') {
                $tot_month=12;
                $end_value=1;
                if ($month!='0') {
                    $tot_month=$month;
                    $end_value=$month;
                }
                while ($tot_month>=$end_value) {
                    $mon =($tot_month<10)?'0'.$tot_month:$tot_month;
                    $data[$all_item['item_id']]['item_rate-'.$mon]=0;
                    $data[$all_item['item_id']]['inv_num-'.$mon]=0;
                    $data[$all_item['item_id']]['box_num-'.$mon]=0;
                    $data[$all_item['item_id']]['item_weight-'.$mon]=0;
                    $tot_month--;
                }
            }
            if($term=='2')
            {
                $date1=date('Y',strtotime($from_date));
                $data[$all_item['item_id']]['item_rate-'.$date1]=0;
                $data[$all_item['item_id']]['inv_num-'.$date1]=0;
                $data[$all_item['item_id']]['box-num'.$date1]=0;
                $date2=date('Y',strtotime($to_date));
                $data[$all_item['item_id']]['item_rate-'.$date2]=0;
                $data[$all_item['item_id']]['inv_num-'.$date2]=0;
                $data[$all_item['item_id']]['box_num-'.$date2]=0;
                $data[$all_item['item_id']]['item_weight-'.$date1]=0;
                $data[$all_item['item_id']]['item_weight-'.$date2]=0;
            }
            foreach ($all_invoices as $all_inv) {
                
                $boxes_array=explode(',',$all_inv['boxes_array']);
                $item_rate=explode(',',$all_inv['item_rate']);
                $item_weights=explode(',',$all_inv['item_weights']);
                foreach ($boxes_array as $key => $value) {
                    $this->db->where('box_id',$value);
                    $this->db->select('item_id,net_weight');
                    $this->db->from('bud_yt_packing_boxes');
                    $box_item=$this->db->get()->result_array();
                    if($box_item[0]['item_id']==$all_item['item_id'])
                    {
                        if ($term=='1') {
                            $term_value=date('m',strtotime($all_inv['invoice_date']));
                        }
                        if($term=='2'){
                            $term_value=date('Y',strtotime($all_inv['invoice_date']));
                        }
                        $rate=round($item_rate[$key]*$box_item[0]['net_weight']);
                        $data[$all_item['item_id']]['item_rate-'.$term_value]+=$rate;
                        $data[$all_item['item_id']]['item_weight-'.$term_value]+=$box_item[0]['net_weight'];
                        $data[$all_item['item_id']]['inv_num-'.$term_value]+=1;
                        $data['item_tot']+=$rate;
                    }
                }
            }
        }
        return $data;
    }
    //Dyeing Reports 
    function get_item_sent_dyeing_yt($from_date=null,$to_date=null,$item_id=null,$term=1,$report=1)
    {
        $this->db->select('*');
        if(!empty($from_date))
        {
            $this->db->where('delivery_date >=',$from_date);
        }
        if(!empty($to_date))
        {
            $this->db->where('delivery_date <=',$to_date);
        }
        if(!empty($item_id))
        {
            $this->db->where('bud_yt_packing_boxes.item_id',$item_id);
        }
        $this->db->from('bud_gray_yarn_soft_dc');
        $this->db->join('bud_yarn_soft_dc_items','bud_yarn_soft_dc_items.delivery_id = bud_gray_yarn_soft_dc.delivery_id', 'left');
        $this->db->join('bud_yt_packing_boxes','bud_yt_packing_boxes.box_id = bud_yarn_soft_dc_items.box_id', 'left');
        $this->db->join('bud_items','bud_items.item_id = bud_yt_packing_boxes.item_id', 'left');
        $this->db->order_by('bud_yt_packing_boxes.item_id','asc');
        $values=$this->db->get()->result_array();
        if($term=='2')
        {
            $term='Y';
        }
        if($term=='1')
        {
            $term='M-y';
        }
        $netweight=array();
        $grossweight=array();
        $no_of_boxes=array();
        $no_of_cones=array();
        $return['tot_nweight']=0;
        $return['tot_gweight']=0;
        $return['tot_cones']=0;
        $return['tot_boxes']=0;
        $dcs=array();
        $return['lots']=array();
        foreach ($values as $value) {
            $netweight[$value['item_id']][date($term,strtotime($value['delivery_date']))]=0;
            $grossweight[$value['item_id']][date($term,strtotime($value['delivery_date']))]=0;
            $no_of_boxes[$value['item_id']][date($term,strtotime($value['delivery_date']))]=0;
            $no_of_cones[$value['item_id']][date($term,strtotime($value['delivery_date']))]=0;
            $dcs[$value['item_id']][date($term,strtotime($value['delivery_date']))][$value['delivery_id']]=$value['delivery_id'];
            $return[$value['item_id']]=$value['item_name'];
            $return['lots']['lot_qty'][$value['item_id']][date($term,strtotime($value['delivery_date']))]=0;
            $return['lots']['no_of_lots'][$value['item_id']][date($term,strtotime($value['delivery_date']))]=0;
            $return['lots']['lot_no'][$value['item_id']][date($term,strtotime($value['delivery_date']))]='';
            $return['lots']['boxes']['stock'][$value['item_id']][date($term,strtotime($value['delivery_date']))]='';
            $return['lots']['boxes']['res'][$value['item_id']][date($term,strtotime($value['delivery_date']))]='';
            $return['lots']['boxes']['st'][$value['item_id']][date($term,strtotime($value['delivery_date']))]='';
            $return['lots']['boxes']['delv'][$value['item_id']][date($term,strtotime($value['delivery_date']))]='';
            $return['lots']['box_num'][$value['item_id']][date($term,strtotime($value['delivery_date']))]=0;
            $return['lots']['box_net_weight'][$value['item_id']][date($term,strtotime($value['delivery_date']))]=0;
            $return['lots']['tot_boxes_num']=0;
            $return['lots']['b_net_weight']=0;
            $return['lots']['boxes_num']['stock']=0;
            $return['lots']['boxes_num']['delv']=0;
            $return['lots']['boxes_num']['res']=0;
            $return['lots']['boxes_num']['st']=0;
        }
        foreach ($values as $value) {
            $netweight[$value['item_id']][date($term,strtotime($value['delivery_date']))]+=$value['net_weight'];
            $grossweight[$value['item_id']][date($term,strtotime($value['delivery_date']))]+=$value['gross_weight'];
            $no_of_boxes[$value['item_id']][date($term,strtotime($value['delivery_date']))]+=1;
            $no_of_cones[$value['item_id']][date($term,strtotime($value['delivery_date']))]+=$value['no_of_cones'];
            $return['tot_nweight']+=$value['net_weight'];
            $return['tot_gweight']+=$value['gross_weight'];
            $return['tot_cones']+=$value['no_of_cones'];
            $return['tot_boxes']++;
        }
        $return['netweight']=$netweight;
        $return['grossweight']=$grossweight;
        $return['numboxes']=$no_of_boxes;
        $return['numcones']=$no_of_cones;
        $return['dcs']=$dcs;
        if($report =='2')
        {
            $return['lots']=$this->lot_packed($from_date,$to_date,$item_id,$term,$return['lots']);
        }
        return $return;
    }
    function get_item_sent_dyeing_dcs_yt($from_date=null,$to_date=null,$item_id=null,$term=1)
    {
        $this->db->select('bud_gray_yarn_soft_dc.*,bud_gray_yarn_soft_dc.remarks as dcremarks,bud_yarn_soft_dc_items.*,bud_items.item_name,bud_yt_packing_boxes.*');
        if(!empty($from_date))
        {
            $this->db->where('delivery_date >=',$from_date);
        }
        if(!empty($to_date))
        {
            $this->db->where('delivery_date <=',$to_date);
        }
        if(!empty($item_id))
        {
            $this->db->where('bud_yt_packing_boxes.item_id',$item_id);
        }
        $this->db->from('bud_gray_yarn_soft_dc');
        $this->db->join('bud_yarn_soft_dc_items','bud_yarn_soft_dc_items.delivery_id = bud_gray_yarn_soft_dc.delivery_id', 'left');
        $this->db->join('bud_yt_packing_boxes','bud_yt_packing_boxes.box_id = bud_yarn_soft_dc_items.box_id', 'left');
        $this->db->join('bud_items','bud_items.item_id = bud_yt_packing_boxes.item_id', 'left');
        $this->db->order_by('bud_yt_packing_boxes.item_id','asc');
        $values=$this->db->get()->result_array();
        $return['tot_nweight']=0;
        $return['tot_gweight']=0;
        $return['tot_cones']=0;
        $return['tot_boxes']=0;
        foreach ($values as $value) {
            $return[$value['delivery_id']]['net_weight']=0;
            $return[$value['delivery_id']]['gross_weight']=0;
            $return[$value['delivery_id']]['no_of_boxes']=0;
            $return[$value['delivery_id']]['no_of_cones']=0;
            $return[$value['delivery_id']]['box_num']='';
            $return[$value['delivery_id']]['item_name']=$value['item_name'];
            $return[$value['delivery_id']]['delivery_date']=date('d-M-y',strtotime($value['delivery_date']));
            $return[$value['delivery_id']]['remarks']=$value['dcremarks'];
        }
        foreach ($values as $value) {
            $return[$value['delivery_id']]['net_weight']+=$value['net_weight'];
            $return[$value['delivery_id']]['gross_weight']+=$value['gross_weight'];
            $return[$value['delivery_id']]['no_of_boxes']+=1;
            $return[$value['delivery_id']]['no_of_cones']+=$value['no_of_cones'];
            $return[$value['delivery_id']]['box_num'].=$value['box_prefix'].$value['box_no'].',';
            $return['tot_nweight']+=$value['net_weight'];
            $return['tot_gweight']+=$value['gross_weight'];
            $return['tot_cones']+=$value['no_of_cones'];
            $return['tot_boxes']+=1;
        }
        return $return;
    }
    function dyed_against_po($from_date = null, $to_date = null,$item_id=null,$shade_no=null)
    {   
        if(!empty($item_id))
        {
            $this->db->where('bud_lots.lot_item_id',$item_id);
        }
        if(!empty($shade_no))
        {
            $this->db->where('bud_lots.lot_shade_no',$shade_no);
        }
         if(!empty($from_date))
        {
            $this->db->where('lot_created_date >=',$from_date);
        }
        if(!empty($to_date))
        {
            $this->db->where('lot_created_date <=',$to_date);
        }
        $this->db->select('ak_po_from_customers.R_po_no as rpono,bud_lots.*,bud_shades.shade_name,bud_items.item_name,ak_po_from_customers_items.qty');
        $this->db->from('bud_lots');
        $this->db->join('ak_po_from_customers','ak_po_from_customers.R_po_no = bud_lots.po_no');
        $this->db->join('bud_shades','bud_shades.shade_id = bud_lots.lot_shade_no', 'left');
        $this->db->join('ak_po_from_customers_items','ak_po_from_customers_items.R_po_no = ak_po_from_customers.R_po_no AND ak_po_from_customers_items.bud_items = bud_lots.lot_item_id AND ak_po_from_customers_items.bud_shades = bud_lots.lot_shade_no','left');
        $this->db->join('bud_items','bud_items.item_id = bud_lots.lot_item_id', 'left');
        $this->db->order_by('ak_po_from_customers.R_po_no,bud_lots.lot_item_id,bud_lots.lot_shade_no','desc');
        $values=$this->db->get()->result_array();
        $tot_p_qty=0;
        $p_qty=array();
        foreach ($values as $value1) {
            $p_qty[$value1['rpono']][$value1['lot_item_id']][$value1['lot_shade_no']]=0;
        }
        foreach ($values as $value1) {
            $p_qty[$value1['rpono']][$value1['lot_item_id']][$value1['lot_shade_no']]+=$value1['lot_qty'];
            $tot_p_qty+=$value1['lot_qty'];
        }
        $return['values']=$values;
        $return['p_qty']=$p_qty;
        $return['tot_p_qty']=$tot_p_qty;
        return $return;
    }
    function dyeing_prod($from_date = null, $to_date = null,$item_id=null,$shade_no=null,$machine_prefix=null)
    {   
        if(!empty($item_id))
        {
            $this->db->where('bud_lots.lot_item_id',$item_id);
        }
        if(!empty($shade_no))
        {
            $this->db->where('bud_lots.lot_shade_no',$shade_no);
        }
        if(!empty($machine_prefix))
        {
            $this->db->where('bud_lots.lot_prefix',$machine_prefix);
        }
         if(!empty($from_date))
        {
            $this->db->where('bud_lots.lot_created_date >=',$from_date);
        }
        if(!empty($to_date))
        {
            $this->db->where('bud_lots.lot_created_date <=',$to_date);
        }
        //$this->db->where('bud_lots.lot_id','43');
        $this->db->select('bud_lots.*,bud_shades.shade_code,bud_items.item_name');
        $this->db->from('bud_lots');
        $this->db->join('bud_shades','bud_shades.shade_id = bud_lots.lot_shade_no', 'left');
        $this->db->join('bud_items','bud_items.item_id = bud_lots.lot_item_id', 'left');
        $values=$this->db->get()->result_array();
        $tot_p_qty=0;
        $p_qty=array();
        foreach ($values as $value1) {
            $lot_id=$value1['lot_id'];
            $tot_p_qty+=$value1['lot_qty'];
            $this->db->where('lot_no',$lot_id);
            $this->db->select('bud_yt_packing_boxes.net_weight,bud_yt_packing_boxes.box_no,bud_yt_packing_boxes.box_prefix');
            $this->db->from('bud_yt_packing_boxes');
            $boxes=$this->db->get()->result_array();
            $return['boxes'][$lot_id]=''; 
            $return['box_net_weight'][$lot_id]=0; 
            $return['box_num'][$lot_id]=0;
            foreach ($boxes as $box) {
                $return['boxes'][$lot_id].=$box['box_prefix'].'-'.$box['box_no'].',';
                $return['box_num'][$lot_id]++;
                $return['box_net_weight'][$lot_id]+=round($box['net_weight'],2);
            }
            //to calculate balance and exess
            $reqd_qty=$value1['lot_qty'];
            $prod_qty=$return['box_net_weight'][$lot_id];
            if($prod_qty>$reqd_qty)
            {
               $return['exess_qty'][$lot_id]=$prod_qty-$reqd_qty;
               $return['bal_qty'][$lot_id]=0;
            }
            else
            {
               $return['exess_qty'][$lot_id]=0;
               $return['bal_qty'][$lot_id]=$reqd_qty-$prod_qty;
            }
        }
        $return['values']=$values;
        $return['tot_p_qty']=round($tot_p_qty,2);
        return $return;
    }
    function m_lot_dyeing_yt($from_date=null,$to_date=null,$item_id=null,$term=1,$lots=array())
    {
        $this->db->select('*');
        if(!empty($from_date))
        {
            $this->db->where('lot_created_date >=',$from_date);
        }
        if(!empty($to_date))
        {
            $this->db->where('lot_created_date <=',$to_date);
        }
        if(!empty($item_id))
        {
            $this->db->where('lot_item_id',$item_id);
        }
        $this->db->where('lot_prefix !=','4');
        $this->db->from('bud_lots');
        $this->db->join('bud_items','bud_items.item_id = bud_lots.lot_item_id', '
            left');
        $this->db->order_by('bud_lots.lot_created_date','asc');
        $values=$this->db->get()->result_array();
        if($term=='2')
        {
            $term='Y';
        }
        if($term=='1')
        {
            $term='M-y';
        }
        $return=$lots;
        $return['tot_lot_qty']=0;
        $return['tot_lot_no']=0;
        foreach ($values as $value) {
            $return['lot_qty'][$value['item_id']][date($term,strtotime($value['lot_created_date']))]=0;
            $return['no_of_lots'][$value['item_id']][date($term,strtotime($value['lot_created_date']))]=0;
            $return[$value['item_id']]=$value['item_name'];
        }
        foreach ($values as $value) {
            $return['lot_qty'][$value['item_id']][date($term,strtotime($value['lot_created_date']))]+=round($value['lot_qty'],2);
            $return['no_of_lots'][$value['item_id']][date($term,strtotime($value['lot_created_date']))]+=1;
            $return['lot_no'][$value['item_id']][date($term,strtotime($value['lot_created_date']))][$value['lot_no']]=$value['lot_no'];
            $return['tot_lot_qty']+=round($value['lot_qty'],2);
            $return['tot_lot_no']++;
        }
        $return['lot_values']=$values;
        return $return;
    }
    function lot_packed($from_date=null,$to_date=null,$item_id=null,$term=1,$lots=array())
    {   
        $this->db->select('*');
        if(!empty($from_date))
        {
            $this->db->where('lot_created_date >=',$from_date);
        }
        if(!empty($to_date))
        {
            $this->db->where('lot_created_date <=',$to_date);
        }
        if(!empty($item_id))
        {
            $this->db->where('lot_item_id',$item_id);
        }
        $this->db->where('lot_prefix !=','4');
        $this->db->from('bud_lots');
        $this->db->join('bud_items','bud_items.item_id = bud_lots.lot_item_id', '
            left');
        $this->db->order_by('bud_lots.lot_created_date','asc');
        $values=$this->db->get()->result_array();
        if($term=='2')
        {
            $term='Y';
        }
        if($term=='1')
        {
            $term='M-y';
        }
        $return=$lots;
        $return['tot_lot_qty']=0;
        $return['tot_lot_no']=0;
        $p_qty=array();
        $tot_p_qty=0;
        foreach ($values as $value) {
            $return['lot_qty'][$value['item_id']][date($term,strtotime($value['lot_created_date']))]=0;
            $return['no_of_lots'][$value['item_id']][date($term,strtotime($value['lot_created_date']))]=0;
            $return[$value['item_id']]=$value['item_name'];
            $return['boxes']['stock'][$value['item_id']][date($term,strtotime($value['lot_created_date']))]='';
            $return['boxes']['res'][$value['item_id']][date($term,strtotime($value['lot_created_date']))]='';
            $return['boxes']['st'][$value['item_id']][date($term,strtotime($value['lot_created_date']))]='';
            $return['boxes']['delv'][$value['item_id']][date($term,strtotime($value['lot_created_date']))]='';
            $return['box_num'][$value['item_id']][date($term,strtotime($value['lot_created_date']))]=0;
            $return['box_net_weight'][$value['item_id']][date($term,strtotime($value['lot_created_date']))]=0;
        }
        foreach ($values as $value) {
            $return['lot_qty'][$value['item_id']][date($term,strtotime($value['lot_created_date']))]+=round($value['lot_qty'],2);
            $return['no_of_lots'][$value['item_id']][date($term,strtotime($value['lot_created_date']))]+=1;
            $return['lot_no'][$value['item_id']][date($term,strtotime($value['lot_created_date']))][$value['lot_no']]=$value['lot_no'];
            $return['tot_lot_qty']+=round($value['lot_qty'],2);
            $return['tot_lot_no']++;
            $lot_id=$value['lot_id'];
            $tot_p_qty+=$value['lot_qty'];
            $this->db->where('lot_no',$lot_id);
            $this->db->where('is_deleted','0');
            $this->db->select('net_weight, box_no, box_prefix, predelivery_status, delivery_status, delivered_in_group');
            $this->db->from('bud_yt_packing_boxes');
            $boxes=$this->db->get()->result_array();
            foreach ($boxes as $box) {
                if($box['predelivery_status']=='1')
                {
                    if($box['delivery_status']=='1')
                    {
                        $return['boxes']['delv'][$value['item_id']][date($term,strtotime($value['lot_created_date']))].=$box['box_prefix'].'-'.$box['box_no'].', ';
                        $return['boxes_num']['delv']+=1;
                    }
                    else
                    {
                        $return['boxes']['res'][$value['item_id']][date($term,strtotime($value['lot_created_date']))].=$box['box_prefix'].'-'.$box['box_no'].', ';
                        $return['boxes_num']['res']+=1;
                    }
                }
                elseif($box['delivered_in_group']=='1')
                {
                    $return['boxes']['st'][$value['item_id']][date($term,strtotime($value['lot_created_date']))].=$box['box_prefix'].'-'.$box['box_no'].', ';
                    $return['boxes_num']['st']+=1;
                }
                else
                {
                    $return['boxes']['stock'][$value['item_id']][date($term,strtotime($value['lot_created_date']))].=$box['box_prefix'].'-'.$box['box_no'].', ';
                    $return['boxes_num']['stock']+=1;
                }
                $return['tot_boxes_num']+=1;
                $return['box_num'][$value['item_id']][date($term,strtotime($value['lot_created_date']))]++;
                $return['box_net_weight'][$value['item_id']][date($term,strtotime($value['lot_created_date']))]+=round($box['net_weight'],2);
                $return['b_net_weight']+=round($box['net_weight'],2);
            }
        }
        $return['lot_values']=$values;
        return $return;
        $return['tot_p_qty']=round($tot_p_qty,2);
        return $return;
    }
    //end of Dyeing Reports

    //Update boxes array in invoices - Labels
    function m_update_boxes_array_lbl()
    {
        $this->db->select('selected_dc,invoice_id');
        $this->db->from('bud_lbl_invoices');
        $invoices=$this->db->get()->result_array();
        foreach ($invoices as $inv) {
           $selected_dc= explode(',',$inv['selected_dc']);
           $boxes=array();
            foreach ($selected_dc as $key => $value) {
                $this->db->select('delivery_boxes');
                $this->db->from('bud_lbl_delivery');
                $this->db->where('delivery_id',$value);
                $delivery_boxes=$this->db->get()->result_array();
                if($delivery_boxes)
                {
                    $boxes[]=$delivery_boxes[0]['delivery_boxes'];
                }
            }
            $this->db->where('invoice_id', $inv['invoice_id']);
            $this->db->update('bud_lbl_invoices',array('boxes_array'=> implode(',',$boxes)));
        }
        return true;
    }
    //end of Update boxes array in invoices - Labels
    //Product Labels
    function get_prd_rep_lbl($filter)
    {
        if(!empty($filter['f_date']))
        {
            $this->db->where('date >=',date('Y-m-d',strtotime($filter['f_date'])));
        }
        if(!empty($filter['t_date']))
        {
            $this->db->where('date <=',date('Y-m-d',strtotime($filter['t_date'])));
        }
        if($filter['item_id']!=0)
        {
            $this->db->where('item_id',$filter['item_id']);
        }
        if($filter['operator_id']!=0)
        {
            $this->db->where('operator_id',$filter['operator_id']);
        }
        if($filter['shift']!=0)
        {
            $this->db->where('shift',$filter['shift']);
        }
        if($filter['sample']!=0)
        {
            $this->db->where('sample',$filter['sample']);
        }
        $this->db->select('bud_lbl_prod_entry_operator.*,bud_users.display_name,bud_lbl_items.*,bud_te_machines.machine_id,bud_te_machines.machine_name')
                 ->from('bud_lbl_prod_entry_operator')
                 ->join('bud_users', 'bud_users.ID = bud_lbl_prod_entry_operator.operator_id')
                 ->join('bud_lbl_items', 'bud_lbl_items.item_id = bud_lbl_prod_entry_operator.item_id')
                 ->join('bud_te_machines', 'bud_te_machines.machine_id = bud_lbl_prod_entry_operator.machine_id')
                 ->order_by('bud_lbl_prod_entry_operator.id', 'desc');
        $prd_details['details']=$this->db->get()->result_array();
        $prd_details['tot_runtime']=0;
        $prd_details['tot_repts']=0;
        foreach ($prd_details['details'] as $detail) {
            $prd_details['tot_runtime']+=$detail['mac_run_time'];
            $prd_details['tot_repts']+=$detail['no_repts'];
        }
        return $prd_details;
    }
    //end of Product Labels
    //Creation of Pending DC
    function m_pending_dc_lbl()
    {
        $this->db->select('*');
        $this->db->where('invoice_status','1');
        $this->db->from('bud_lbl_delivery');
        $deliveries=$this->db->get()->result_array();
        foreach ($deliveries as $delivery) {
            $insert=array('delivery_id' => $delivery['delivery_id'],
                          'concern_name' => $delivery['concern_name'],
                          'dc_no' => $delivery['dc_no'],
                          'p_delivery_ref' => $delivery['p_delivery_ref'] ,
                          'delivery_date' => $delivery['delivery_date'],
                          'delivery_customer' => $delivery['delivery_customer'],
                          'delivery_boxes' =>$delivery['delivery_boxes'],
                          'invoice_status'=>$delivery['invoice_status']);
            $this->db->insert('bud_lbl_pending_dc',$insert);
        }
        return true;
    }
    function m_pending_dc_te()
    {
        $this->db->select('*');
        $this->db->where('invoice_status','1');
        $this->db->from('bud_te_delivery');
        $deliveries=$this->db->get()->result_array();
        foreach ($deliveries as $delivery) {
            $insert=array('delivery_id' => $delivery['delivery_id'],
                          'concern_name' => $delivery['concern_name'],
                          'dc_no' => $delivery['dc_no'],
                          'p_delivery_ref' => $delivery['p_delivery_ref'] ,
                          'delivery_date' => $delivery['delivery_date'],
                          'delivery_customer' => $delivery['delivery_customer'],
                          'delivery_boxes' =>$delivery['delivery_boxes'],
                          'invoice_status'=>$delivery['invoice_status']);
            $this->db->insert('bud_te_pending_dc',$insert);
        }
        return true;
    }
    function m_pending_dc_yt()
    {
        $this->db->select('*');
        $this->db->where('invoice_status','1');
        $this->db->where('bud_yt_delivery.delivery_is_deleted',1);//ER-09-18#-58
        $this->db->from('bud_yt_delivery');
        $deliveries=$this->db->get()->result_array();
        foreach ($deliveries as $delivery) {
            $insert=array('delivery_id' => $delivery['delivery_id'],
                          'concern_name' => $delivery['concern_name'],
                          'dc_no' => $delivery['dc_no'],
                          'p_delivery_ref' => $delivery['p_delivery_ref'] ,
                          'delivery_date' => $delivery['delivery_date'],
                          'delivery_customer' => $delivery['delivery_customer'],
                          'delivery_boxes' =>$delivery['delivery_boxes'],
                          'invoice_status'=>$delivery['invoice_status']);
            $this->db->insert('bud_yt_pending_dc',$insert);
        }
        return true;
    }
    function m_pending_dc_sh()
    {
        $this->db->select('*');
        $this->db->where('delivery_status','0');
        $this->db->from('bud_sh_delivery');
        $deliveries=$this->db->get()->result_array();
        foreach ($deliveries as $delivery) {
            $insert=array('delivery_id' => $delivery['delivery_id'],
                          'concern_id' => $delivery['concern_id'],
                          'dc_no' => $delivery['dc_no'],
                          'delivery_date' => $delivery['delivery_date'] ,
                          'customer_id' => $delivery['customer_id'],
                          'delivery_to' => $delivery['delivery_to'],
                          'name' => $delivery['name'],
                          'mobile_no' => $delivery['mobile_no'] ,
                          'remarks' => $delivery['remarks'],
                          'delivery_boxes' =>$delivery['delivery_boxes'],
                          'delivery_status'=>$delivery['delivery_status'],
                          'p_delivery_id'=>$delivery['p_delivery_id']);
            $this->db->insert('bud_sh_pending_dc',$insert);
            //to create outerbox items
            $this->db->select('*');
            $this->db->where('delivery_id',$delivery['delivery_id']);
            $this->db->from('bud_sh_delivery_items');
            $boxes_items=$this->db->get()->result_array();
            foreach ($boxes_items as $value) {
                $insert_items=array('row_id' => $value['row_id'],
                          'box_id' => $value['box_id'],
                          'box_no' => $value['box_no'],
                          'box_prefix' => $value['box_prefix'],
                          'item_group_id' => $value['item_group_id'],
                          'item_id' => $value['item_id'],
                          'shade_id' => $value['shade_id'] ,
                          'lot_no' => $value['lot_no'],
                          'no_boxes' => $value['no_boxes'],
                          'no_cones' =>$value['no_cones'],
                          'gr_weight'=>$value['gr_weight'],
                          'nt_weight' => $value['nt_weight'],
                          'packed_on' => $value['packed_on'],
                          'supplier_id' => $value['supplier_id'],
                          'supplier_dc_no' => $value['supplier_dc_no'] ,
                          'uom_id' => $value['uom_id'],
                          'stock_room_id' => $value['stock_room_id'],
                          'remarks' =>$value['remarks'],
                          'is_deleted' => $value['is_deleted'],
                          'deleted_by' => $value['deleted_by'],
                          'deleted_on' =>$value['deleted_on'],
                          'deleted_remarks' => $value['deleted_remarks'],
                          'delivery_id' =>$value['delivery_id'],
                          'delivery_qty' =>$value['delivery_qty']);
                $this->db->insert('bud_sh_pending_dc_items',$insert_items);
            }
        }
        return true;
    }
    //end of Creation of Pending DC -tapes
    //Creation of Stock
    function m_stock_lbl()
    {
        $this->db->select('*');
        $this->db->from('bud_lbl_outerboxes');
        $boxes=$this->db->get()->result_array();
        foreach ($boxes as $box) {
            if (($box['date_time']<='2018-04-01')&&($box['delivery_status']=='0')&&($box['is_deleted']=='0')) {
               continue;
            }
            $insert=array('box_no' => $box['box_no'],
                          'box_prefix' => $box['box_prefix'],
                          'item_id' => $box['item_id'],
                          'operator_id' => $box['operator_id'] ,
                          'date_time' => $box['date_time'],
                          'packing_gr_weight' => $box['packing_gr_weight'],
                          'packing_uom' =>$box['packing_uom'],
                          'packing_net_weight'=>$box['packing_net_weight'],
                          'packing_contact' => $box['packing_contact'],
                          'packing_form' => $box['packing_form'],
                          'predelivery_status' => $box['predelivery_status'],
                          'delivery_status' => $box['delivery_status'] ,
                          'is_deleted' => $box['is_deleted'],
                          'deleted_by' => $box['deleted_by'],
                          'deleted_time' =>$box['deleted_time']);
            $this->db->insert('bud_lbl_outerboxes_stock',$insert);
            //to create outerbox items
            $this->db->select('*');
            $this->db->where('box_no',$box['box_no']);
            $this->db->from('bud_lbl_outerbox_items');
            $boxes_items=$this->db->get()->result_array();
            foreach ($boxes_items as $value) {
                $insert_items=array('id' => $value['id'],
                              'box_no' => $value['box_no'],
                              'item_id' => $value['item_id'],
                              'item_size' => $value['item_size'],
                              'packed_roll_qty' => $value['packed_roll_qty'],
                              'packed_no_rolls' => $value['packed_no_rolls'],
                              'total_qty_damaged' => $value['total_qty_damaged'],
                              'total_qty' => $value['total_qty']);
                $this->db->insert('bud_lbl_outerbox_items_stock',$insert_items);
            }
        }
        return true;
    }
    function m_stock_te()
    {
        $this->db->select('*');
        //$this->db->where('delivery_status','1');
        $this->db->from('bud_te_outerboxes');
        $boxes=$this->db->get()->result_array();
        foreach ($boxes as $box) {
            if (($box['packing_date']<='2018-04-01')&&($box['delivery_status']=='0')&&($box['is_deleted']=='0')) {
               continue;
            }
            $insert=array('box_no' => $box['box_no'],
                          'packing_date' => $box['packing_date'],
                          'packing_time' => $box['packing_time'],
                          'packing_innerboxes' => $box['packing_innerboxes'] ,
                          'packing_innerbox_items' => $box['packing_innerbox_items'],
                          'packing_gr_weight' => $box['packing_gr_weight'],
                          'total_tare_weight' =>$box['total_tare_weight'],
                          'packing_box_weight' =>$box['packing_box_weight'],
                          'packing_no_boxes' =>$box['packing_no_boxes'],
                          'packing_bag_weight'=>$box['packing_bag_weight'],
                          'packing_no_bags' => $box['packing_no_bags'],
                          'packing_othr_wt' => $box['packing_othr_wt'],
                          'packing_net_weight' => $box['packing_net_weight'],
                          'packing_wt_mtr' => $box['packing_wt_mtr'] ,
                          'packing_wt_mtr_new' => $box['packing_wt_mtr_new'],
                          'total_rolls' => $box['total_rolls'],
                          'qty_per_roll' =>$box['qty_per_roll'],
                          'total_meters' => $box['total_meters'],
                          'item_uom' => $box['item_uom'],
                          'packing_by' => $box['packing_by'] ,
                          'predelivery_status' => $box['predelivery_status'],
                          'delivery_status' => $box['delivery_status'],
                          'packing_type' => $box['packing_type'],
                          'packing_stock_room' => $box['packing_stock_room'] ,
                          'packing_stock_place' => $box['packing_stock_place'],
                          'dyed_lot_no' => $box['dyed_lot_no']);
            $this->db->insert('bud_te_outerboxes_stock',$insert);
        }
        return true;
    }
    function m_stock_yt()
    {
        $this->db->select('*'); 
        $this->db->where('is_deleted',0);
        $this->db->where('delivery_status',0);
        $this->db->from('bud_yt_packing_boxes');
        $boxes=$this->db->get()->result_array();
        foreach ($boxes as $box) {
        //if (($box['packed_date']<='2018-04-01')&&($box['delivery_status']=='0')||($box['is_deleted']=='1')) {
               //continue;
        //}
            $insert=array('box_id' => $box['box_id'],
                          'box_prefix' => $box['box_prefix'],
                          'box_no' => $box['box_no'],
                          'lot_no' => $box['lot_no'] ,
                          'item_id' => $box['item_id'],
                          'poy_denier' => $box['poy_denier'],
                          'poy_lot_id' =>$box['poy_lot_id'],
                          'poy_inward_no' =>$box['poy_inward_no'],
                          'yarn_denier' =>$box['yarn_denier'],
                          'shade_no'=>$box['shade_no'],
                          'box_weight' => $box['box_weight'],
                          'no_boxes' => $box['no_boxes'],
                          'poly_bag_weight' => $box['poly_bag_weight'],
                          'no_bags' => $box['no_bags'] ,
                          'cone_weight' => $box['cone_weight'],
                          'no_cones' => $box['no_cones'],
                          'spring_weight' =>$box['spring_weight'],
                          'weight_per_cone' => $box['weight_per_cone'],
                          'no_of_cones' => $box['no_of_cones'],
                          'meter_per_cone' => $box['meter_per_cone'] ,
                          'other_weight' => $box['other_weight'],
                          'gross_weight' => $box['gross_weight'],
                          'tare_weight' => $box['tare_weight'],
                          'net_weight' => $box['net_weight'] ,
                          'lot_wastage' => $box['lot_wastage'],
                          'net_weight_cones' => $box['net_weight_cones'],
                          'packed_by' => $box['packed_by'],
                          'packed_date' => $box['packed_date'],
                          'packed_time' => $box['packed_time'] ,
                          'stock_room_id' => $box['stock_room_id'],
                          'predelivery_status' => $box['predelivery_status'],
                          'delivery_status' => $box['delivery_status'],
                          'is_deleted' => $box['is_deleted'],
                          'deleted_time' => $box['deleted_time'],
                          'is_perm_deleted' => $box['is_perm_deleted'] ,
                          'inner_boxes' => $box['inner_boxes'],
                          'remarks' => $box['remarks'],
                          'delivered_in_group' => $box['delivered_in_group'],
                          'manual_lot_no' => $box['manual_lot_no'],
                          'yarn_lot_id' => $box['yarn_lot_id'],
                          'cone_weight_2' => $box['cone_weight_2'],
                          'no_of_cones_2' => $box['no_of_cones_2'],
                          'tot_cone_weight_2' => $box['tot_cone_weight_2'],
                          'poy_inward_no_2' => $box['poy_inward_no_2'],
                          'poy_inward_no_2_qty' => $box['poy_inward_no_2_qty'],
                          'poy_inward_no_1_qty' => $box['poy_inward_no_1_qty']);
            $this->db->insert('bud_yt_packing_boxes_stock',$insert);
        }
        return true;
    }
    function m_stock_sh()
    {
        $this->db->select('*');
        $this->db->from('bud_sh_packing');
        $boxes=$this->db->get()->result_array();
        foreach ($boxes as $box) {
            $this->db->select('*');
            $this->db->where('box_no',$box['box_id']);
            $this->db->from('bud_sh_delivery_items');
            $dc=$this->db->get()->result_array();
            if (($box['packed_on']<='2018-04-01')&&$dc&&($box['is_deleted']=='0')) {
               continue;
            }
            $insert=array('box_id' => $box['box_id'],
                          'box_no' => $box['box_no'],
                          'box_prefix' => $box['box_prefix'],
                          'item_group_id' => $box['item_group_id'],
                          'item_id' => $box['item_id'],
                          'shade_id' => $box['shade_id'] ,
                          'lot_no' => $box['lot_no'],
                          'no_boxes' => $box['no_boxes'],
                          'no_cones' =>$box['no_cones'],
                          'gr_weight'=>$box['gr_weight'],
                          'nt_weight' => $box['nt_weight'],
                          'packed_on' => $box['packed_on'],
                          'supplier_id' => $box['supplier_id'],
                          'supplier_dc_no' => $box['supplier_dc_no'] ,
                          'uom_id' => $box['uom_id'],
                          'stock_room_id' => $box['stock_room_id'],
                          'remarks' =>$box['remarks'],
                          'is_deleted' => $box['is_deleted'],
                          'deleted_by' => $box['deleted_by'],
                          'deleted_on' =>$box['deleted_on'],
                          'deleted_remarks' => $box['deleted_remarks'],
                          'final_deleted' =>$box['final_deleted']);
            $this->db->insert('bud_sh_packing_stock',$insert);
            //to create outerbox items
            $this->db->select('*');
            $this->db->where('box_no',$box['box_no']);
            $this->db->from('bud_lbl_outerbox_items');
            $boxes_items=$this->db->get()->result_array();
            foreach ($boxes_items as $value) {
                $insert_items=array('id' => $value['id'],
                              'box_no' => $value['box_no'],
                              'item_id' => $value['item_id'],
                              'item_size' => $value['item_size'],
                              'packed_roll_qty' => $value['packed_roll_qty'],
                              'packed_no_rolls' => $value['packed_no_rolls'],
                              'total_qty_damaged' => $value['total_qty_damaged'],
                              'total_qty' => $value['total_qty']);
                $this->db->insert('bud_lbl_outerbox_items_stock',$insert_items);
            }
        }
        return true;
    }
    //end of Creation of stock
    //Mir Reports - TIR
    function get_tot_inw_rep_sh($term=2,$selected_month,$selected_year)
    {
        //Initailisation
        $date_format=($term==2)?'Y':'M-y';
        $data['tot_gr_wt']['stdc']=0;
        $data['tot_nt_wt']['stdc']=0;
        $data['tot_box']['stdc']=0;
        $data['tot_gr_wt']['packed']=0;
        $data['tot_nt_wt']['packed']=0;
        $data['tot_box']['packed']=0;
        $data['tot_gr_wt']['total']=0;
        $data['tot_nt_wt']['total']=0;
        $data['tot_box']['total']=0;
        $data['details']=array();
        //to get data 
        $year=($selected_year==0)?date('Y'):$selected_year;
        if(($selected_month!=0)&&($selected_month>date('m'))&&($selected_year==0))
            $year--;
        $end_year=($selected_year==0)?'2015':$selected_year;
        while ($year>=$end_year) {
            if($term==2)
            {
                $date_format=$year;
                $start_date=date('Y-m-d',strtotime('01-01-'.$date_format));
                $end_date=date('Y-m-d',strtotime('31-12-'.$date_format));
                $mon=1;
                $end_month=1;
            }
            elseif($term==1)
            {
                if ($year==date('Y')) {
                $mon=($selected_month==0)?date('m'):$selected_month;
                }
                else {
                $mon=($selected_month==0)?12:$selected_month;    
                }
                $end_month=($selected_month==0)?1:$selected_month;
            }
            while($mon>=$end_month) {
                //initialization
                if($term==1)
                {
                    $month=($mon>9)?$mon:'0'.$mon;
                    $date_format=$month.'-'.$year;
                    $start_date=date('Y-m-d',strtotime('01-'.$date_format));
                    $end_date=date('Y-m-t',strtotime('01-'.$date_format));
                }
                $count=3;
                //to get data
                while($count>0)
                {
                    switch ($count) {
                        case 1:
                            $status='packed';
                            //condition
                            $condition = array(
                            'packed_on >='=>$start_date,
                            'packed_on <='=>$end_date,
                            'supplier_id !='=>'0',
                            'is_deleted'=>'0'
                            );
                            break;
                        case 2:
                            $status='total';
                            //condition
                            $condition = array(
                            'packed_on >='=>$start_date,
                            'packed_on <='=>$end_date,
                            'is_deleted'=>'0'
                            );
                            break;
                        case 3:
                            $status='stdc';
                            //condition
                            $condition = array(
                            'packed_on >='=>$start_date,
                            'packed_on <='=>$end_date,
                            'is_deleted'=>'0',
                            'supplier_id'=>'0'
                            );
                            break;
                    }
                    $data['details'][$date_format][$status]['gr_wt']=0;
                    $data['details'][$date_format]['term']=$term;
                    $data['details'][$date_format][$status]['nt_wt']=0;
                    $data['details'][$date_format][$status]['boxes']=0;
                    $this->db->select_sum('gr_weight');
                    $this->db->where($condition);
                    $this->db->from('bud_sh_packing');
                    $gr_wt=$this->db->get()->result_array();
                    $data['details'][$date_format][$status]['gr_wt']=($gr_wt[0]['gr_weight']==null)?0:$gr_wt[0]['gr_weight'];
                    $data['tot_gr_wt'][$status]+=($gr_wt[0]['gr_weight']==null)?0:$gr_wt[0]['gr_weight'];
                    $this->db->select_sum('nt_weight');
                    $this->db->where($condition);
                    $this->db->from('bud_sh_packing');
                    $nt_wt=$this->db->get()->result_array();
                    $data['details'][$date_format][$status]['nt_wt']=($nt_wt[0]['nt_weight']==null)?0:$nt_wt[0]['nt_weight'];
                    $data['tot_nt_wt'][$status]+=($nt_wt[0]['nt_weight']==null)?0:$nt_wt[0]['nt_weight'];
                    $this->db->where($condition);
                    $boxes=$this->db->count_all_results('bud_sh_packing');
                    $data['details'][$date_format][$status]['boxes']=$boxes;
                    $count--;
                    $data['tot_box'][$status]+=$boxes;
                }
                //decrement
                $mon--;
            }
            //decrement
            $mon=($term==2)?1:12;
            $year--;
        }
        return $data;
    }
    function get_item_wise_inw_rep_sh($from_date,$to_date,$term)
    {
        $date_format=($term==2)?'Y':'M-y';
        $data['tot_gr_wt']['stdc']=0;
        $data['tot_nt_wt']['stdc']=0;
        $data['tot_box']['stdc']=0;
        $data['tot_gr_wt']['packed']=0;
        $data['tot_nt_wt']['packed']=0;
        $data['tot_box']['packed']=0;
        $data['tot_gr_wt']['total']=0;
        $data['tot_nt_wt']['total']=0;
        $data['tot_box']['total']=0;
        $data['details']=array();

        if(!empty($from_date))
        {
            $this->db->where('packed_on >=',$from_date);
        }
        if(!empty($to_date))
        {
            $this->db->where('packed_on <=',$to_date);
        }
        $this->db->where('is_deleted','0');
        $this->db->select('bud_items.item_name,bud_sh_packing.*');
        $this->db->from('bud_sh_packing');
        $this->db->join('bud_items','bud_sh_packing.item_id = bud_items.item_id','left');
        $this->db->order_by('bud_sh_packing.item_id','asc');
        $boxes_items=$this->db->get()->result_array();
        foreach ($boxes_items as $boxes) {
            $data['details'][$boxes['item_name'].'/'.$boxes['item_id']]['packed']['gr_wt']=array();
            $data['details'][$boxes['item_name'].'/'.$boxes['item_id']]['packed']['nt_wt']=array();
            $data['details'][$boxes['item_name'].'/'.$boxes['item_id']]['stdc']['gr_wt']=array();
            $data['details'][$boxes['item_name'].'/'.$boxes['item_id']]['stdc']['nt_wt']=array();
            $data['details'][$boxes['item_name'].'/'.$boxes['item_id']]['item_id']=$boxes['item_id'];
        }
        foreach ($boxes_items as $boxes) { 
            $status=($boxes['supplier_id']=='0')?'stdc':'packed';
            $data['details'][$boxes['item_name'].'/'.$boxes['item_id']][$status]['gr_wt'][]=$boxes['gr_weight'];
            $data['details'][$boxes['item_name'].'/'.$boxes['item_id']][$status]['nt_wt'][]=$boxes['nt_weight'];
            $data['tot_gr_wt'][$status]+=$boxes['gr_weight'];
            $data['tot_nt_wt'][$status]+=$boxes['nt_weight'];
            $data['tot_box'][$status]++;
            $data['details'][$boxes['item_name'].'/'.$boxes['item_id']]['total']['gr_wt'][]=$boxes['gr_weight'];
            $data['details'][$boxes['item_name'].'/'.$boxes['item_id']]['total']['nt_wt'][]=$boxes['nt_weight'];
            $data['tot_gr_wt']['total']+=$boxes['gr_weight'];
            $data['tot_nt_wt']['total']+=$boxes['nt_weight'];
            $data['tot_box']['total']++;
        } 
        return $data;
    }
    function get_box_wise_inw_rep_sh($from_date=null,$to_date=null,$term=null,$item_id=null,$shade=null,$stock_room=null)//ER-07-18#-25
    {
        $date_format=($term==2)?'Y':'M-y';
        if(!empty($from_date))
        {
            $this->db->where('packed_on >=',$from_date);
        }
        if(!empty($to_date))
        {
            $this->db->where('packed_on <=',$to_date);
        }
        if(!empty($item_id))
        {
            $this->db->where('bud_sh_packing.item_id =',$item_id);
        }
        if(!empty($shade))//ER-07-18#-25
        {
            $this->db->where('bud_sh_packing.shade_id =',$shade);
        }        
        if(!empty($stock_room))//ER-07-18#-25
        {
            $this->db->where('bud_sh_packing.stock_room_id =',$stock_room);
        }
        $this->db->where('is_deleted','0');
        $this->db->select('bud_items.item_name,bud_sh_packing.*,bud_shades.shade_name,bud_shades.shade_code,bud_stock_rooms.stock_room_name');
        $this->db->from('bud_sh_packing');
        $this->db->join('bud_items','bud_sh_packing.item_id = bud_items.item_id','left');
        $this->db->join('bud_stock_rooms','bud_sh_packing.stock_room_id = bud_stock_rooms.stock_room_id','left');
        $this->db->join('bud_shades','bud_sh_packing.shade_id = bud_shades.shade_id','left');
        $this->db->order_by('bud_sh_packing.item_id','asc');
        $boxes_items=$this->db->get()->result_array();
        return $boxes_items;
    }
    //end of Mir Reports - TIR
    //TOR Shop
    function get_tot_otw_rep_sh($term=2,$selected_month,$selected_year)
    {
        //Initailisation
        $date_format=($term==2)?'Y':'M-y';
        $data['tot_nt_wt']['credit']=array();
        $data['tot_nt_wt']['cash']=array();
        $data['tot_nt_wt']['est']=array();
        $data['tot_del_wt']['credit']=0;
        $data['tot_del_wt']['cash']=0;
        $data['tot_del_wt']['est']=0;
        $data['tot_amt']['credit']=0;
        $data['tot_amt']['cash']=0;
        $data['tot_amt']['est']=0;
        $data['tot_dc_qty']=array();
        $data['tot_predc_qty']=array();
        $data['details']=array();
        //to get data 
        $year=($selected_year==0)?date('Y'):$selected_year;
        if(($selected_month!=0)&&($selected_month>date('m'))&&($selected_year==0))
            $year--;
        $end_year=($selected_year==0)?'2015':$selected_year;
        while ($year>=$end_year) {
            if($term==2)
            {
                $date_format=$year;
                $start_date=date('Y-m-d',strtotime('01-01-'.$date_format));
                $end_date=date('Y-m-d',strtotime('31-12-'.$date_format));
                $mon=1;
                $end_month=1;
            }
            elseif($term==1)
            {
                if ($year==date('Y')) {
                $mon=($selected_month==0)?date('m'):$selected_month;
                }
                else {
                $mon=($selected_month==0)?12:$selected_month;    
                }
                $end_month=($selected_month==0)?1:$selected_month;
            }
            while($mon>=$end_month) {
                //initialization
                if($term==1)
                {
                    $month=($mon>9)?$mon:'0'.$mon;
                    $date_format=$month.'-'.$year;
                    $start_date=date('Y-m-d',strtotime('01-'.$date_format));
                    $end_date=date('Y-m-t',strtotime('01-'.$date_format));
                }
                $condition=array(
                    'invoice_date >='=>$start_date,
                    'invoice_date <='=>$end_date
                );
                $condition_est=array(
                    'quotation_date >='=>$start_date, 
                    'quotation_date <='=>$end_date
                );
                //to get data
                $data['details'][$date_format]['credit']['nt_wt']=array();
                $data['details'][$date_format]['cash']['nt_wt']=array();
                $data['details'][$date_format]['est']['nt_wt']=array();
                $data['details'][$date_format]['tot']['nt_wt']=array();
                $data['details'][$date_format]['predc']=array();
                $data['details'][$date_format]['dc']=array();
                $data['details'][$date_format]['term']=$term;
                $data['details'][$date_format]['credit']['amt']=$this->total_values('bud_sh_credit_invoices',null,'invoice_amt',null,null,$condition);
                $data['tot_amt']['credit']+=$data['details'][$date_format]['credit']['amt'];
                $data['details'][$date_format]['cash']['amt']=$this->total_values('bud_sh_cash_invoices',null,'invoice_amt',null,null,$condition);
                $data['tot_amt']['cash']+=$data['details'][$date_format]['cash']['amt'];
                $data['details'][$date_format]['est']['amt']=$this->total_values('bud_sh_quotations',null,'quotation_amt',null,null,$condition_est);
                $data['tot_amt']['est']+=$data['details'][$date_format]['est']['amt'];
                $boxes=$this->get_two_table_values('bud_sh_predel_items','bud_sh_predelivery','delivery_qty,box_id','p_delivery_id','p_delivery_id',array(
                    'p_delivery_date >='=>$start_date, 
                    'p_delivery_date <='=>$end_date
                ));
                foreach ($boxes as $box) {
                    $data['details'][$date_format]['predc'][$box['box_id']]=$box['delivery_qty'];
                    $data['tot_predc_qty'][$box['box_id']]=$box['delivery_qty'];;
                }
                $boxes=$this->get_two_table_values('bud_sh_delivery_items','bud_sh_delivery','delivery_qty,box_id','delivery_id','delivery_id',array(
                    'delivery_date >='=>$start_date, 
                    'delivery_date <='=>$end_date
                ));
                foreach ($boxes as $box) {
                    $data['details'][$date_format]['dc'][$box['box_id']]=$box['delivery_qty'];
                    $data['tot_dc_qty'][$box['box_id']]=$box['delivery_qty'];
                }
                $data['details'][$date_format]['credit']['del_wt']=$this->total_values('bud_sh_credit_invoice_items','bud_sh_credit_invoices','delivery_qty','invoice_id','invoice_id',$condition);
                $data['tot_del_wt']['credit']+=$data['details'][$date_format]['credit']['del_wt'];
                $data['details'][$date_format]['cash']['del_wt']=$this->total_values('bud_sh_cash_invoice_items','bud_sh_cash_invoices','delivery_qty','invoice_id','invoice_id',$condition);
                $data['tot_del_wt']['cash']+=$data['details'][$date_format]['cash']['del_wt'];
                $data['details'][$date_format]['est']['del_wt']=$this->total_values('bud_sh_quotation_items','bud_sh_quotations','delivery_qty','quotation_id','quotation_id',$condition_est);
                $data['tot_del_wt']['est']+=$data['details'][$date_format]['est']['del_wt'];
                $cr_boxes=$this->get_3_table_values('bud_sh_credit_invoice_items','bud_sh_credit_invoices','bud_sh_packing','bud_sh_packing.nt_weight,bud_sh_packing.box_id','invoice_id','invoice_id','box_id','box_id',$condition);
                $ch_boxes=$this->get_3_table_values('bud_sh_cash_invoice_items','bud_sh_cash_invoices','bud_sh_packing','bud_sh_packing.nt_weight,bud_sh_packing.box_id','invoice_id','invoice_id','box_id','box_id',$condition);
                $est_boxes=$this->get_3_table_values('bud_sh_quotation_items','bud_sh_quotations','bud_sh_packing','bud_sh_packing.nt_weight,bud_sh_packing.box_id','quotation_id','quotation_id','box_id','box_id',$condition_est);
                foreach ($cr_boxes as $boxes) {
                    $data['details'][$date_format]['credit']['nt_wt'][$boxes['box_id']]=$boxes['nt_weight'];
                    $data['details'][$date_format]['tot']['nt_wt'][$boxes['box_id']]=$boxes['nt_weight'];
                    $data['tot_nt_wt']['credit'][$boxes['box_id']]=$boxes['nt_weight'];
                    $data['tot_nt_wt']['tot'][$boxes['box_id']]=$boxes['nt_weight'];
                }
                foreach ($ch_boxes as $boxes) {
                    $data['details'][$date_format]['cash']['nt_wt'][$boxes['box_id']]=$boxes['nt_weight'];
                    $data['details'][$date_format]['tot']['nt_wt'][$boxes['box_id']]=$boxes['nt_weight'];
                    $data['tot_nt_wt']['cash'][$boxes['box_id']]=$boxes['nt_weight'];
                    $data['tot_nt_wt']['tot'][$boxes['box_id']]=$boxes['nt_weight'];
                }
                foreach ($est_boxes as $boxes) {
                    $data['details'][$date_format]['est']['nt_wt'][$boxes['box_id']]=$boxes['nt_weight'];
                    $data['details'][$date_format]['tot']['nt_wt'][$boxes['box_id']]=$boxes['nt_weight'];
                    $data['tot_nt_wt']['est'][$boxes['box_id']]=$boxes['nt_weight'];
                    $data['tot_nt_wt']['tot'][$boxes['box_id']]=$boxes['nt_weight'];
                }
                //decrement
                $mon--;
            }
            //decrement
            $mon=($term==2)?1:12;
            $year--;
        }
        return $data;
    }
    function get_item_wise_otw_rep_sh($from_date,$to_date,$term)
    {
        $date_format=($term==2)?'Y':'M-y';
        $data['tot_nt_wt']['credit']=array();
        $data['tot_del_wt']['credit']=0;
        $data['tot_nt_wt']['cash']=array();
        $data['tot_del_wt']['cash']=0;
        $data['tot_nt_wt']['est']=array();
        $data['tot_del_wt']['est']=0;
        $data['tot_del_wt']['tot']=0;
        $data['tot_nt_wt']['tot']=array();
        $data['tot_dc_qty']=array();
        $data['tot_predc_qty']=array();
        $data['details']=array();

        $this->db->select('bud_sh_packing.box_id,bud_sh_packing.nt_weight,bud_sh_packing.item_id,delivery_qty');
        $this->db->where('bud_sh_quotations.quotation_date >=',$from_date);
        $this->db->where('bud_sh_quotations.quotation_date <=',$to_date);
        $this->db->from('bud_sh_quotation_items');
        $this->db->join('bud_sh_quotations','bud_sh_quotation_items.quotation_id = bud_sh_quotations.quotation_id','left');
        $this->db->join('bud_sh_packing','bud_sh_quotation_items.box_id = bud_sh_packing.box_id','left');  
        $this->db->order_by('bud_sh_packing.item_id','asc');
        $est_items=$this->db->get()->result_array();

        $this->db->select('bud_sh_packing.box_id,bud_sh_packing.nt_weight,bud_sh_packing.item_id,delivery_qty');
        $this->db->where('bud_sh_credit_invoices.invoice_date >=',$from_date);
        $this->db->where('bud_sh_credit_invoices.invoice_date <=',$to_date);
        $this->db->join('bud_sh_credit_invoices','bud_sh_credit_invoice_items.invoice_id = bud_sh_credit_invoices.invoice_id','left');
        $this->db->join('bud_sh_packing','bud_sh_credit_invoice_items.box_id = bud_sh_packing.box_id','left');
        $this->db->from('bud_sh_credit_invoice_items');
        $this->db->order_by('bud_sh_packing.item_id','asc');
        $credit_items=$this->db->get()->result_array();
        
        $this->db->select('bud_sh_packing.box_id,bud_sh_packing.nt_weight,bud_sh_packing.item_id,delivery_qty');
        $this->db->where('bud_sh_cash_invoices.invoice_date >=',$from_date);
        $this->db->where('bud_sh_cash_invoices.invoice_date <=',$to_date);
        $this->db->from('bud_sh_cash_invoice_items');
        $this->db->join('bud_sh_cash_invoices','bud_sh_cash_invoice_items.invoice_id = bud_sh_cash_invoices.invoice_id','left');
        $this->db->join('bud_sh_packing','bud_sh_cash_invoice_items.box_id = bud_sh_packing.box_id','left');       
        $this->db->order_by('bud_sh_packing.item_id','asc');
        $cash_items=$this->db->get()->result_array();
        
        $items=$this->m_masters->get_active_items_array();
        foreach ($items as $item) {
            $ch_check=$this->m_masters->getmasterIDvalue('bud_sh_cash_invoice_items','item_id',$item['item_id'],'box_id');
            $cr_check=$this->m_masters->getmasterIDvalue('bud_sh_credit_invoice_items' ,'item_id',$item['item_id'],'box_id');
            $q_check=$this->m_masters->getmasterIDvalue('bud_sh_quotation_items' ,'item_id',$item['item_id'],'box_id');
            if($ch_check||$cr_check||$q_check) {
                $data['details'][$item['item_id']]['cash']['nt_wt']=array();
                $data['details'][$item['item_id']]['cash']['del_wt']=array();
                $data['details'][$item['item_id']]['credit']['nt_wt']=array();
                $data['details'][$item['item_id']]['credit']['del_wt']=array();
                $data['details'][$item['item_id']]['est']['nt_wt']=array();
                $data['details'][$item['item_id']]['est']['del_wt']=array();
                $data['details'][$item['item_id']]['tot']['nt_wt']=array();
                $data['details'][$item['item_id']]['tot']['del_wt']=array();
            }
        }
        foreach ($cash_items as $boxes) {
            $data['details'][$boxes['item_id']]['cash']['nt_wt'][$boxes['box_id']]=$boxes['nt_weight'];
            $data['details'][$boxes['item_id']]['cash']['del_wt'][]=$boxes['delivery_qty'];
            $data['details'][$boxes['item_id']]['tot']['nt_wt'][$boxes['box_id']]=$boxes['nt_weight'];
            $data['details'][$boxes['item_id']]['tot']['del_wt'][]=$boxes['delivery_qty'];
            $data['tot_nt_wt']['cash'][$boxes['box_id']]=$boxes['nt_weight'];
            $data['tot_del_wt']['cash']+=$boxes['delivery_qty'];
            $data['tot_nt_wt']['tot'][$boxes['box_id']]=$boxes['nt_weight'];
            $data['tot_del_wt']['tot']+=$boxes['delivery_qty'];
        }
        foreach ($credit_items as $boxes) {
            $data['details'][$boxes['item_id']]['credit']['nt_wt'][$boxes['box_id']]=$boxes['nt_weight'];
            $data['details'][$boxes['item_id']]['credit']['del_wt'][]=$boxes['delivery_qty'];
            $data['details'][$boxes['item_id']]['tot']['nt_wt'][$boxes['box_id']]=$boxes['nt_weight'];
            $data['details'][$boxes['item_id']]['tot']['del_wt'][]=$boxes['delivery_qty'];
            $data['tot_nt_wt']['credit'][$boxes['box_id']]=$boxes['nt_weight'];
            $data['tot_del_wt']['credit']+=$boxes['delivery_qty'];
            $data['tot_nt_wt']['tot'][$boxes['box_id']]=$boxes['nt_weight'];
            $data['tot_del_wt']['tot']+=$boxes['delivery_qty'];
        }
        foreach ($est_items as $boxes) {
            $data['details'][$boxes['item_id']]['est']['nt_wt'][$boxes['box_id']]=$boxes['nt_weight'];
            $data['details'][$boxes['item_id']]['est']['del_wt'][]=$boxes['delivery_qty'];
            $data['details'][$boxes['item_id']]['tot']['nt_wt'][$boxes['box_id']]=$boxes['nt_weight'];
            $data['details'][$boxes['item_id']]['tot']['del_wt'][]=$boxes['delivery_qty'];
            $data['tot_nt_wt']['est'][$boxes['box_id']]=$boxes['nt_weight'];
            $data['tot_del_wt']['est']+=$boxes['delivery_qty'];
            $data['tot_nt_wt']['tot'][$boxes['box_id']]=$boxes['nt_weight'];
            $data['tot_del_wt']['tot']+=$boxes['delivery_qty'];
        }
        $boxes=$this->get_two_table_values('bud_sh_predel_items','bud_sh_predelivery','delivery_qty,box_id,item_id','p_delivery_id','p_delivery_id',array(
                    'p_delivery_date >='=>$from_date, 
                    'p_delivery_date <='=>$to_date
                ));
        foreach ($boxes as $box) {
            $data['details'][$box['item_id']]['predc'][$box['box_id']]=$box['delivery_qty'];
            $data['tot_predc_qty'][$box['box_id']]=$box['delivery_qty'];;
        }
        $boxes=$this->get_two_table_values('bud_sh_delivery_items','bud_sh_delivery','delivery_qty,box_id,item_id','delivery_id','delivery_id',array(
                    'delivery_date >='=>$from_date, 
                    'delivery_date <='=>$to_date
                ));
        foreach ($boxes as $box) {
            $data['details'][$box['item_id']]['dc'][$box['box_id']]=$box['delivery_qty'];
            $data['tot_dc_qty'][$box['box_id']]=$box['delivery_qty'];;
        }
        return $data;
    }
    function get_box_wise_otw_rep_sh($from_date,$to_date,$term,$item_id)
    {
        $date_format=($term==2)?'Y':'M-y';
        $condition=array(
            'invoice_date >='=>$from_date,
            'invoice_date <='=>$to_date,
            'item_id' =>$item_id
        );
        $condition_est=array(
            'quotation_date >='=>$from_date, 
            'quotation_date <='=>$to_date,
            'item_id' =>$item_id
        );
        $box_id='';
        $cr_boxes=$this->get_two_table_values('bud_sh_credit_invoice_items','bud_sh_credit_invoices','box_id','invoice_id','invoice_id',$condition);
        $ch_boxes=$this->get_two_table_values('bud_sh_cash_invoice_items','bud_sh_cash_invoices','box_id','invoice_id','invoice_id',$condition);
        $est_boxes=$this->get_two_table_values('bud_sh_quotation_items','bud_sh_quotations','box_id','quotation_id','quotation_id',$condition_est);
        foreach ($cr_boxes as $boxes) {
            $box_id.=$boxes['box_id'].',';
        }
        foreach ($ch_boxes as $boxes) {
            $box_id.=$boxes['box_id'].',';
        }
        foreach ($est_boxes as $boxes) {
            $box_id.=$boxes['box_id'].',';
        }
        $tot_box_id=explode(',', $box_id);

        $this->db->where_in('box_id',$tot_box_id);
        $this->db->select('bud_items.item_name,bud_sh_packing.*,bud_shades.shade_name,bud_shades.shade_code,bud_stock_rooms.stock_room_name');
        $this->db->from('bud_sh_packing');
        $this->db->join('bud_items','bud_sh_packing.item_id = bud_items.item_id','left');
        $this->db->join('bud_stock_rooms','bud_sh_packing.stock_room_id = bud_stock_rooms.stock_room_id','left');
        $this->db->join('bud_shades','bud_sh_packing.shade_id = bud_shades.shade_id','left');
        $this->db->order_by('bud_sh_packing.item_id','asc');
        $boxes_items=$this->db->get()->result_array();
        return $boxes_items;
    }
    //end of tor shop
    //TOR Tapes
    function get_tot_otw_rep_te($term=2,$selected_month,$selected_year)
    {
        //Initailisation
        $date_format=($term==2)?'Y':'M-y';
        $data['tot_inv_mtrs']=array();
        $data['tot_inv_boxes']=array();
        $data['tot_inv_a_tax']=array();
        $data['tot_inv_b_tax']=array();
        $data['tot_inv_nt_wt']=array();
        $data['tot_dc_boxes']=array();
        $data['tot_dc_nt_wt']=array();
        $data['tot_dc_mtrs']=array();
        $data['tot_pdc_boxes']=array();
        $data['tot_pdc_mtrs']=array();
        $data['tot_pdc_nt_wt']=array();
        $data['details']=array();
        //to get data 
        $year=($selected_year==0)?date('Y'):$selected_year;
        if(($selected_month!=0)&&($selected_month>date('m'))&&($selected_year==0))
            $year--;
        $end_year=($selected_year==0)?'2015':$selected_year;
        while ($year>=$end_year) {
            if($term==2)
            {
                $date_format=$year;
                $start_date=date('Y-m-d',strtotime('01-01-'.$date_format));
                $end_date=date('Y-m-d',strtotime('31-12-'.$date_format));
                $mon=1;
                $end_month=1;
            }
            elseif($term==1)
            {
                if ($year==date('Y')) {
                    $mon=($selected_month==0)?(int)date('m'):$selected_month;
                }
                else {
                $mon=($selected_month==0)?12:$selected_month;    
                }
                $end_month=($selected_month==0)?1:$selected_month;
            }
            while($mon>=$end_month) {
                //initialization
                if($term==1)
                {
                    $month=($mon>9)?$mon:'0'.$mon;
                    $date_format=$month.'-'.$year;
                    $start_date=date('Y-m-d',strtotime('01-'.$date_format));
                    $end_date=date('Y-m-t',strtotime('01-'.$date_format));
                }
                $inv_condition=array(
                    'invoice_date >='=>$start_date,
                    'invoice_date <='=>$end_date,
                    'is_cancelled'=>0
                );
                $pdc_condition=array(
                    'p_delivery_date >='=>$start_date, 
                    'p_delivery_date <='=>$end_date,
                    'p_delivery_is_deleted'=>1
                );
                $dc_condition=array(
                    'delivery_date >='=>$start_date, 
                    'delivery_date <='=>$end_date,
                    'bud_te_delivery.is_deleted'=>1
                );
                //to get data
                $data['details'][$date_format]['inv']=array();
                $data['details'][$date_format]['pdc']=array();
                $data['details'][$date_format]['dc']=array();
                $data['details'][$date_format]['inv']['box_id']=array();
                $data['details'][$date_format]['pdc']['box_id']=array();
                $data['details'][$date_format]['dc']['box_id']=array();
                $data['details'][$date_format]['term']=$term;
                $data['details'][$date_format]['inv']['amt_a_tax']=$this->total_values('bud_te_invoices',null,'net_amount',null,null,$inv_condition);
                $data['tot_inv_a_tax'][]=$data['details'][$date_format]['inv']['amt_a_tax'];
                $data['details'][$date_format]['inv']['amt_b_tax']=$this->total_values('bud_te_invoices',null,'sub_total',null,null,$inv_condition);
                $data['tot_inv_b_tax'][]=$data['details'][$date_format]['inv']['amt_b_tax'];
                 $data['details'][$date_format]['inv']['mtrs']=$this->total_values('bud_te_predelivery_items','bud_te_invoices','delivery_qty_meters','invoice_id','invoice_id',$inv_condition);
                 $data['tot_inv_mtrs'][]=$data['details'][$date_format]['inv']['mtrs'];
                $data['details'][$date_format]['inv']['nt_wt']=$this->total_values('bud_te_predelivery_items','bud_te_invoices','delivery_qty_kgs','invoice_id','invoice_id',$inv_condition);
                $data['tot_inv_nt_wt'][]=$data['details'][$date_format]['inv']['nt_wt'];
                $data['details'][$date_format]['pdc']['mtrs']=$this->total_values('bud_te_predelivery_items','bud_te_predelivery','delivery_qty_meters','p_delivery_id','p_delivery_id',$pdc_condition);
                $data['tot_pdc_mtrs'][]=$data['details'][$date_format]['pdc']['mtrs'];
                $data['details'][$date_format]['pdc']['nt_wt']=$this->total_values('bud_te_predelivery_items','bud_te_predelivery','delivery_qty_kgs','p_delivery_id','p_delivery_id',$pdc_condition);
                $data['tot_pdc_nt_wt'][]=$data['details'][$date_format]['pdc']['nt_wt'];
                $data['details'][$date_format]['dc']['mtrs']=$this->total_values('bud_te_predelivery_items','bud_te_delivery','delivery_qty_meters','delivery_id','delivery_id',$dc_condition);
                $data['tot_dc_mtrs'][]=$data['details'][$date_format]['dc']['mtrs'];
                $data['details'][$date_format]['dc']['nt_wt']=$this->total_values('bud_te_predelivery_items','bud_te_delivery','delivery_qty_kgs','delivery_id','delivery_id',$dc_condition);
                $data['tot_dc_nt_wt'][]=$data['details'][$date_format]['dc']['nt_wt'];
                $boxes=$this->get_two_table_values('bud_te_predelivery_items','bud_te_predelivery','box_id','p_delivery_id','p_delivery_id',$pdc_condition);
                foreach ($boxes as $box) {
                    $data['details'][$date_format]['pdc']['box_id'][$box['box_id']]=$box['box_id'];
                    $data['tot_pdc_boxes'][$box['box_id']]=$box['box_id'];
                }
                $boxes=$this->get_two_table_values('bud_te_predelivery_items','bud_te_delivery','box_id','delivery_id','delivery_id',$dc_condition);
                foreach ($boxes as $box) {
                    $data['details'][$date_format]['dc']['box_id'][$box['box_id']]=$box['box_id'];
                    $data['tot_dc_boxes'][$box['box_id']]=$box['box_id'];
                }
                $boxes=$this->get_two_table_values('bud_te_predelivery_items','bud_te_invoices','box_id','invoice_id','invoice_id',$inv_condition);
                foreach ($boxes as $box) {
                    $data['details'][$date_format]['inv']['box_id'][$box['box_id']]=$box['box_id'];
                    $data['tot_inv_boxes'][$box['box_id']]=$box['box_id'];
                }
                //decrement
                $mon--;
            }
            //decrement
            $mon=($term==2)?1:12;
            $year--;
        }
        return $data;
    }
    function get_item_wise_otw_rep_te($start_date,$end_date,$term)
    {
        $date_format=($term==2)?'Y':'M-y';
        $data['tot_inv_amt']=array();
        $data['tot_inv_nt_wt']=array();
        $data['tot_inv_mtrs']=array();
        $data['tot_dc_nt_wt']=array();
        $data['tot_dc_mtrs']=array();
        $data['tot_pdc_nt_wt']=array();
        $data['tot_pdc_mtrs']=array();
        $data['details']=array();
        $inv_condition=array(
            'invoice_date >='=>$start_date,
            'invoice_date <='=>$end_date,
            'is_cancelled'=>0
        );
        $pdc_condition=array(
            'p_delivery_date >='=>$start_date, 
            'p_delivery_date <='=>$end_date,
            'p_delivery_is_deleted'=>1
        );
        $dc_condition=array(
            'delivery_date >='=>$start_date, 
            'delivery_date <='=>$end_date,
            'bud_te_delivery.is_deleted'=>1
        );
        $boxes=$this->get_two_table_values('bud_te_predelivery_items','bud_te_predelivery','delivery_qty_kgs,delivery_qty_meters,box_id,item_id','p_delivery_id','p_delivery_id',$pdc_condition);
        foreach ($boxes as $box) {
            $data['details'][$box['item_id']]['inv']['nt_wt']=array();
            $data['details'][$box['item_id']]['inv']['mtrs']=array();
            $data['details'][$box['item_id']]['inv']['amt']=array();
            $data['details'][$box['item_id']]['dc']['nt_wt']=array();
            $data['details'][$box['item_id']]['dc']['mtrs']=array();
            $data['details'][$box['item_id']]['pdc']['nt_wt'][$box['box_id']]=$box['delivery_qty_kgs'];
            $data['tot_pdc_nt_wt'][$box['box_id']]=$box['delivery_qty_kgs'];
            $data['details'][$box['item_id']]['pdc']['mtrs'][$box['box_id']]=$box['delivery_qty_meters'];
            $data['tot_pdc_mtrs'][$box['box_id']]=$box['delivery_qty_meters'];
        }
        $inv_boxes=$this->get_two_table_values('bud_te_predelivery_items','bud_te_invoices','box_id,delivery_qty_kgs,delivery_qty_meters,item_id,bud_te_predelivery_items.item_rate,uom','invoice_id','invoice_id',$inv_condition);
        foreach ($inv_boxes as $box) {
            $data['details'][$box['item_id']]['inv']['nt_wt'][$box['box_id']]=$box['delivery_qty_kgs'];
            $data['tot_inv_nt_wt'][$box['box_id']]=$box['delivery_qty_kgs'];
            $data['details'][$box['item_id']]['inv']['mtrs'][$box['box_id']]=$box['delivery_qty_meters'];
            $data['tot_inv_mtrs'][$box['box_id']]=$box['delivery_qty_meters'];
            $amt=($box['delivery_qty_kgs'])?$box['delivery_qty_kgs']*$box['item_rate']:$box['delivery_qty_meters']*$box['item_rate'];
            $data['details'][$box['item_id']]['inv']['amt'][$box['box_id']]=$amt;
            $data['tot_inv_amt'][$box['box_id']]=$amt;
        }        
        $boxes=$this->get_two_table_values('bud_te_predelivery_items','bud_te_delivery','delivery_qty_kgs,box_id,item_id,delivery_qty_meters','delivery_id','delivery_id',$dc_condition);
        foreach ($boxes as $box) {
             $data['details'][$box['item_id']]['dc']['nt_wt'][$box['box_id']]=$box['delivery_qty_kgs'];
            $data['tot_dc_nt_wt'][$box['box_id']]=$box['delivery_qty_kgs'];
            $data['details'][$box['item_id']]['dc']['mtrs'][$box['box_id']]=$box['delivery_qty_meters'];
            $data['tot_dc_mtrs'][$box['box_id']]=$box['delivery_qty_meters'];
        }
        return $data;
    }
    function get_box_wise_otw_rep_te($from_date,$to_date,$term,$item_id)
    {
        $date_format=($term==2)?'Y':'M-y';
        $condition=array(
            'p_delivery_date >='=>$from_date,
            'p_delivery_date <='=>$to_date,
            'bud_te_predelivery_items.item_id' =>$item_id
        );
        $this->db->where($condition);
        $this->db->select('bud_te_items.item_name,bud_te_outerboxes.*,bud_te_predelivery_items.*,bud_users.display_name as packedby');
        $this->db->from('bud_te_predelivery_items');
        $this->db->join('bud_te_predelivery','bud_te_predelivery.p_delivery_id = bud_te_predelivery_items.p_delivery_id','left');
        $this->db->join('bud_te_outerboxes','bud_te_outerboxes.box_no = bud_te_predelivery_items.box_id','left');
        $this->db->join('bud_te_items','bud_te_outerboxes.packing_innerbox_items = bud_te_items.item_id','left');
        $this->db->join('bud_users','bud_te_outerboxes.packing_by = bud_users.ID','left');
        $this->db->order_by('bud_te_outerboxes.packing_innerbox_items','asc');
        $boxes_items=$this->db->get()->result_array();
        return $boxes_items;
    }
    //end of tor tapes
    //TOR Tapes
    function get_tot_otw_rep_lbl($term=2,$selected_month,$selected_year)
    {
        //Initailisation
        $date_format=($term==2)?'Y':'M-y';
        $data['tot_inv_qty']=array();
        $data['tot_inv_boxes']=array();
        $data['tot_inv_a_tax']=array();
        $data['tot_inv_b_tax']=array();
        $data['tot_dc_boxes']=array();
        $data['tot_dc_qty']=array();
        $data['tot_pdc_boxes']=array();
        $data['tot_pdc_qty']=array();
        $data['details']=array();
        //to get data 
        $year=($selected_year==0)?date('Y'):$selected_year;
        if(($selected_month!=0)&&($selected_month>date('m'))&&($selected_year==0))
            $year--;
        $end_year=($selected_year==0)?'2015':$selected_year;
        while ($year>=$end_year) {
            if($term==2)
            {
                $date_format=$year;
                $start_date=date('Y-m-d',strtotime('01-01-'.$date_format));
                $end_date=date('Y-m-d',strtotime('31-12-'.$date_format));
                $mon=1;
                $end_month=1;
            }
            elseif($term==1)
            {
                if ($year==date('Y')) {
                    $mon=($selected_month==0)?(int)date('m'):$selected_month;
                }
                else {
                $mon=($selected_month==0)?12:$selected_month;    
                }
                $end_month=($selected_month==0)?1:$selected_month;
            }
            while($mon>=$end_month) {
                //initialization
                if($term==1)
                {
                    $month=($mon>9)?$mon:'0'.$mon;
                    $date_format=$month.'-'.$year;
                    $start_date=date('Y-m-d',strtotime('01-'.$date_format));
                    $end_date=date('Y-m-t',strtotime('01-'.$date_format));
                }
                $inv_condition=array(
                    'invoice_date >='=>$start_date,
                    'invoice_date <='=>$end_date,
                    'is_cancelled'=>0
                );
                $pdc_condition=array(
                    'p_delivery_date >='=>$start_date, 
                    'p_delivery_date <='=>$end_date,
                    'bud_lbl_predelivery_items.p_delivery_is_deleted'=>1
                );
                $dc_condition=array(
                    'delivery_date >='=>$start_date, 
                    'delivery_date <='=>$end_date,
                    'bud_lbl_delivery.is_deleted'=>1
                );
                //to get data
                $data['details'][$date_format]['inv']=array();
                $data['details'][$date_format]['pdc']=array();
                $data['details'][$date_format]['dc']=array();
                $data['details'][$date_format]['inv']['box_id']=array();
                $data['details'][$date_format]['pdc']['box_id']=array();
                $data['details'][$date_format]['dc']['box_id']=array();
                $data['details'][$date_format]['term']=$term;
                $data['details'][$date_format]['inv']['amt_a_tax']=$this->total_values('bud_lbl_invoices',null,'net_amount',null,null,$inv_condition);
                $data['tot_inv_a_tax'][]=$data['details'][$date_format]['inv']['amt_a_tax'];
                $data['details'][$date_format]['inv']['amt_b_tax']=$this->total_values('bud_lbl_invoices',null,'sub_total',null,null,$inv_condition);
                $data['tot_inv_b_tax'][]=$data['details'][$date_format]['inv']['amt_b_tax'];
                $data['details'][$date_format]['inv']['tot_qty']=$this->total_values('bud_lbl_predelivery_items','bud_lbl_invoices','delivery_qty','invoice_id','invoice_id',$inv_condition);
                $data['tot_inv_qty'][]=$data['details'][$date_format]['inv']['tot_qty'];
                $data['details'][$date_format]['pdc']['tot_qty']=$this->total_values('bud_lbl_predelivery_items','bud_lbl_predelivery','delivery_qty','p_delivery_id','p_delivery_id',$pdc_condition);
                $data['tot_pdc_qty'][]=$data['details'][$date_format]['pdc']['tot_qty'];
                $data['details'][$date_format]['dc']['tot_qty']=$this->total_values('bud_lbl_predelivery_items','bud_lbl_delivery','delivery_qty','delivery_id','delivery_id',$dc_condition);
                $data['tot_dc_qty'][]=$data['details'][$date_format]['dc']['tot_qty'];
                $boxes=$this->get_two_table_values('bud_lbl_predelivery_items','bud_lbl_predelivery','box_id','p_delivery_id','p_delivery_id',$pdc_condition);
                foreach ($boxes as $box) {
                    $data['details'][$date_format]['pdc']['box_id'][$box['box_id']]=$box['box_id'];
                    $data['tot_pdc_boxes'][$box['box_id']]=$box['box_id'];
                }
                $boxes=$this->get_two_table_values('bud_lbl_predelivery_items','bud_lbl_delivery','box_id','delivery_id','delivery_id',$dc_condition);
                foreach ($boxes as $box) {
                    $data['details'][$date_format]['dc']['box_id'][$box['box_id']]=$box['box_id'];
                    $data['tot_dc_boxes'][$box['box_id']]=$box['box_id'];
                }
                $boxes=$this->get_two_table_values('bud_lbl_predelivery_items','bud_lbl_invoices','box_id','invoice_id','invoice_id',$inv_condition);
                foreach ($boxes as $box) {
                    $data['details'][$date_format]['inv']['box_id'][$box['box_id']]=$box['box_id'];
                    $data['tot_inv_boxes'][$box['box_id']]=$box['box_id'];
                }
                //decrement
                $mon--;
            }
            //decrement
            $mon=($term==2)?1:12;
            $year--;
        }
        return $data;
    }
    function get_item_wise_otw_rep_lbl($start_date,$end_date,$term)
    {
        $date_format=($term==2)?'Y':'M-y';
        $data['tot_inv_amt']=array();
        $data['tot_inv_qty']=array();
        $data['tot_dc_qty']=array();
        $data['tot_pdc_qty']=array();
         $data['tot_inv_boxes']=array();
        $data['tot_dc_boxes']=array();
        $data['tot_pdc_boxes']=array();
        $data['details']=array();
        $inv_condition=array(
            'invoice_date >='=>$start_date,
            'invoice_date <='=>$end_date,
            'is_cancelled'=>0,
            'p_delivery_is_deleted'=>1
        );
        $pdc_condition=array(
            'p_delivery_date >='=>$start_date, 
            'p_delivery_date <='=>$end_date,
            'bud_lbl_predelivery.p_delivery_is_deleted'=>1
        );
        $dc_condition=array(
            'delivery_date >='=>$start_date, 
            'delivery_date <='=>$end_date,
            'bud_lbl_delivery.is_deleted'=>1,
            'p_delivery_is_deleted'=>1
        );
        $pdcs=$this->get_two_table_values('bud_lbl_predelivery_items','bud_lbl_predelivery','delivery_qty,box_id,item_id','p_delivery_id','p_delivery_id',$pdc_condition);
        $dcs=$this->get_two_table_values('bud_lbl_predelivery_items','bud_lbl_delivery','delivery_qty,box_id,item_id','delivery_id','delivery_id',$dc_condition);
        $invoices=$this->get_two_table_values('bud_lbl_predelivery_items','bud_lbl_invoices','box_id,delivery_qty,item_id,bud_lbl_predelivery_items.item_rate','invoice_id','invoice_id',$inv_condition);
        //intialization
       foreach ($pdcs as $pdc) {
            $data['details'][$pdc['item_id']]['inv']['tot_qty']=array();            $data['details'][$pdc['item_id']]['dc']['tot_qty']=array();
            $data['details'][$pdc['item_id']]['inv']['boxes']=array();
            $data['details'][$pdc['item_id']]['dc']['boxes']=array();
        }
        foreach ($invoices as $inv) {
           $data['details'][$inv['item_id']]['dc']['tot_qty']=array();
            $data['details'][$inv['item_id']]['dc']['boxes']=array();
            $data['details'][$inv['item_id']]['pdc']['tot_qty']=array();
            $data['details'][$inv['item_id']]['pdc']['boxes']=array();
        }        
        
        foreach ($dcs as $dc) {
            $data['details'][$inv['item_id']]['inv']['tot_qty']=array();
            $data['details'][$inv['item_id']]['inv']['boxes']=array();
            $data['details'][$inv['item_id']]['pdc']['tot_qty']=array();
            $data['details'][$inv['item_id']]['pdc']['boxes']=array();
        }
        //end of initialisation
        
        foreach ($pdcs as $pdc) {
            $data['details'][$pdc['item_id']]['pdc']['tot_qty'][]=$pdc['delivery_qty'];
            $data['tot_pdc_qty'][]=$pdc['delivery_qty'];
            $data['details'][$pdc['item_id']]['pdc']['boxes'][$pdc['box_id']]=$pdc['box_id'];
            $data['tot_pdc_boxes'][$pdc['box_id']]=$pdc['box_id'];
        }
        foreach ($invoices as $inv) {
            $data['details'][$inv['item_id']]['inv']['tot_qty'][]=$inv['delivery_qty'];
            $data['tot_inv_qty'][]=$inv['delivery_qty'];
            $data['details'][$inv['item_id']]['inv']['boxes'][$inv['box_id']]=$inv['box_id'];
            $data['tot_inv_boxes'][$inv['box_id']]=$inv['box_id'];
        }        
        
        foreach ($dcs as $dc) {
             $data['details'][$dc['item_id']]['dc']['tot_qty'][]=$dc['delivery_qty'];
            $data['tot_dc_qty'][]=$dc['delivery_qty'];
            $data['details'][$dc['item_id']]['dc']['boxes'][$dc['box_id']]=$dc['box_id'];
            $data['tot_dc_boxes'][$dc['box_id']]=$dc['box_id'];
        }
        return $data;
    }
    function get_box_wise_otw_rep_lbl($start_date,$end_date,$term,$item_id)
    {
        $date_format=($term==2)?'Y':'M-y';
        $inv_condition=array(
            'invoice_date >='=>$start_date,
            'invoice_date <='=>$end_date,
            'item_id'=>$item_id,
            'is_cancelled'=>0
        );
        $pdc_condition=array(
            'p_delivery_date >='=>$start_date, 
            'p_delivery_date <='=>$end_date,
            'item_id'=>$item_id,
            'bud_lbl_predelivery_items.p_delivery_is_deleted'=>1
        );
        $dc_condition=array(
            'delivery_date >='=>$start_date, 
            'delivery_date <='=>$end_date,
            'item_id'=>$item_id,
            'bud_lbl_delivery.is_deleted'=>1
        );
        $pdcs=$this->get_two_table_values('bud_lbl_predelivery_items','bud_lbl_predelivery','box_id','p_delivery_id','p_delivery_id',$pdc_condition);
        $dcs=$this->get_two_table_values('bud_lbl_predelivery_items','bud_lbl_delivery','box_id','delivery_id','delivery_id',$dc_condition);
        $invoices=$this->get_two_table_values('bud_lbl_predelivery_items','bud_lbl_invoices','box_id','invoice_id','invoice_id',$inv_condition);
        foreach ($pdcs as $pdc) {
            $boxes[$pdc['box_id']]=$pdc['box_id'];
        }
        foreach ($dcs as $dc) {
            $boxes[$dc['box_id']]=$dc['box_id'];
        }
        foreach ($invoices as $inv) {
            $boxes[$inv['box_id']]=$inv['box_id'];
        }
        return $this->m_reports->getPackingItemsLbl(null,null,null,null,null,$boxes);
    }
    //end of tor labels
    function total_values($table1,$table2,$field,$joinfield1,$joinfield2,$condition)
    {
        $this->db->select_sum($field);
        if($condition)
        {
            $this->db->where($condition);
        }
        $this->db->from($table1);
        if($table2!=null)
        {
            $this->db->join($table2,$table2.'.'.$joinfield1 .'='. $table1.'.'.$joinfield2);
        }
        $result=$this->db->get()->result_array();
        $value=($result)?$result[0][$field]:0;
        return $value;
    }
    function get_two_table_values($table1,$table2,$field,$joinfield1,$joinfield2,$condition)
    {
        $this->db->select($field);
        $this->db->where($condition);
        $this->db->from($table1);
        if($table2!=null)
        {
            $this->db->join($table2,$table2.'.'.$joinfield1 .'='. $table1.'.'.$joinfield2);
        }
        $result=$this->db->get()->result_array();
        return $result;
    }
    function get_3_table_values($table1,$table2,$table3,$field,$joinfield1,$joinfield2,$joinfield3,$joinfield4,$condition)
    {
        $this->db->select($field);
        $this->db->where($condition);
        $this->db->from($table1);
        if($table2!=null)
        {
            $this->db->join($table2,$table2.'.'.$joinfield1 .'='. $table1.'.'.$joinfield2);
        }
        if($table3!=null)
        {
            $this->db->join($table3,$table1.'.'.$joinfield3 .'='. $table3.'.'.$joinfield4);
        }
        $result=$this->db->get()->result_array();
        return $result;
    }
    function m_moving_back_data_to_predel_sh()
    {
        $condition=array('p_concern_id' => '16');
        $this->db->select('box_id');
        $this->db->from('bud_sh_predel_items');
        $this->db->where($condition);
        $this->db->join('bud_sh_predelivery',' bud_sh_predelivery.p_delivery_id = bud_sh_predel_items.p_delivery_id','left');
        $box_id=$this->db->get()->result_array();
        foreach ($box_id as $key => $value) {
            $this->db->where($value);
            $update=$this->db->update('bud_sh_predel_items','delivery_qty',null);
        }
        return $update;
    }
   //IRR Report
    function get_irr_details($filter=array())
    {
        $this->db->select('bud_yt_itemrates.*');
        $this->db->select('bud_items.item_name');
        $this->db->select('bud_customers.cust_name');
        $this->db->select('bud_shades.*');
        $this->db->select('bud_color_category.color_category');
        $this->db->select('bud_color_families.family_name');
        if ($filter['item_id']) {
            $this->db->where('bud_yt_itemrates.item_id',$filter['item_id']);
        }
        if ($filter['cust_id']) {
            $this->db->where('customer_id',$filter['cust_id']);
        }
        if ($filter['shade_id']) {
            $this->db->where('bud_yt_itemrates.shade_id',$filter['shade_id']);
        }
        if ($filter['category_id']) {
            $this->db->where('bud_shades.shade_category',$filter['category_id']);
        }
        if ($filter['family_id']) {
            $this->db->where('bud_shades.shade_family',$filter['family_id']);
        }
        $this->db->join('bud_items','bud_items.item_id = bud_yt_itemrates.item_id','left');
        $this->db->join('bud_customers','bud_customers.cust_id = bud_yt_itemrates.customer_id','left');
        $this->db->join('bud_shades','bud_shades.shade_id = bud_yt_itemrates.shade_id','left');
        $this->db->join('bud_color_category','bud_shades.shade_category = bud_color_category.category_id','left');
        $this->db->join('bud_color_families','bud_shades.shade_family = bud_color_families.family_id','left');
        $this->db->order_by('bud_yt_itemrates.item_id,bud_yt_itemrates.customer_id,bud_shades.shade_category,bud_shades.shade_family,bud_yt_itemrates.shade_id','asc');
        $this->db->from('bud_yt_itemrates');
        return $this->db->get()->result();
    }
    //End of IRR Report
    //IRR Report Tapes
    function get_irr_2_details($filter=array())
    {
        $this->db->select('bud_te_itemrates.*');
        $this->db->select('bud_te_items.item_name,bud_te_items.item_weight_mtr,bud_te_items.item_group');
        $this->db->select('bud_te_items.item_name,bud_te_items.item_weight_mtr');
        $this->db->select('bud_customers.cust_name');
        $this->db->select('bud_te_itemgroups.group_name');
        if ($filter['item_id']) {
            $this->db->where('bud_te_itemrates.item_id',$filter['item_id']);
        }
        if ($filter['item_group_id']) {
            $this->db->where('bud_te_items.item_group',$filter['item_group_id']);
        }
        if ($filter['cust_id']) {
            $this->db->where('customer_id',$filter['cust_id']);
        }
        $this->db->join('bud_te_items','bud_te_items.item_id = bud_te_itemrates.item_id','left');
        $this->db->join('bud_te_itemgroups','bud_te_items.item_group = bud_te_itemgroups.group_id','left');
        $this->db->join('bud_customers','bud_customers.cust_id = bud_te_itemrates.customer_id','left');
        $this->db->order_by('bud_te_items.item_group,bud_te_itemrates.item_id,bud_te_itemrates.customer_id','asc');
        $this->db->from('bud_te_itemrates');
        return $this->db->get()->result();
    }
    //End of IRR Report Tapes
    //IRR Report Labels
    function get_irr_3_details($filter=array())
    {
        $this->db->select('bud_lbl_itemrates.*');
        $this->db->select('bud_lbl_items.item_name');
        $this->db->select('bud_lbl_itemgroups.group_name');
        $this->db->select('bud_customers.cust_name');
        if ($filter['item_id']) {
            $this->db->where('bud_lbl_itemrates.item_id',$filter['item_id']);
        }
        if ($filter['item_group_id']) {
            $this->db->where('bud_lbl_items.item_group',$filter['item_group_id']);
        }
        if ($filter['cust_id']) {
            $this->db->where('customer_id',$filter['cust_id']);
        }
        $this->db->join('bud_lbl_items','bud_lbl_items.item_id = bud_lbl_itemrates.item_id','left');
        $this->db->join('bud_lbl_itemgroups','bud_lbl_items.item_group = bud_lbl_itemgroups.group_id','left');
        $this->db->join('bud_customers','bud_customers.cust_id = bud_lbl_itemrates.customer_id','left');
        $this->db->order_by('bud_lbl_items.item_group,bud_lbl_itemrates.item_id,bud_lbl_itemrates.customer_id','asc');
        $this->db->from('bud_lbl_itemrates');
        return $this->db->get()->result();
    }
    //End of IRR Report Labels
    //tot poy qty correction 
    function m_set_poy_inward_prefix()
    {
        $update=true;
        $this->db->select('packed_date,box_id,poy_inward_no');
        $this->db->from('bud_yt_packing_boxes');
        $this->db->where('poy_inward_no is NOT NULL', NULL, FALSE);
        $boxes=$this->db->get()->result();
        foreach ($boxes as $box) {
            if(!$update)
                break;
            //ER-07-18#-13
            $poy_inward_prefix=array('poy_inward_prefix'=>null);
            if($box->packed_date >'2018-03-31'){
            $poy_inward_prefix=array('poy_inward_prefix'=>$this->m_masters->getmasterIDvalue('bud_yt_poy_inward', 'po_no', $box->poy_inward_no, 'poy_inward_prefix'));
            }
            //ER-07-18#-13
            $this->db->where('box_id',$box->box_id);
            $update=$this->db->update('bud_yt_packing_boxes',$poy_inward_prefix);
        }
        return $update;
    }
    //end of tot poy qty correction
     //tot direct lot qty correction 
    function m_set_lot_month()
    {
        $update=true;
        $this->db->select('packed_date,box_id');
        $this->db->from('bud_yt_packing_boxes');
        $this->db->where('lot_no is NOT NULL', NULL, FALSE);
        $boxes=$this->db->get()->result();
        foreach ($boxes as $box) {
            if(!$update)
                break;
            $lot_month=array('lot_month'=>date('m-y',strtotime($box->packed_date)));
            $this->db->where('box_id',$box->box_id);
            $update=$this->db->update('bud_yt_packing_boxes', $lot_month);
        }
        return $update;
    }
    //end of tot direct lot qty correction
    //only stock in outer boxes QTywise
    function getstock_outerbox_qtywise()
    {
        $this->db->select('*')
                 ->from('bud_te_outerboxes')
                 ->where('packing_type', 'qtywise')
                 ->where('delivery_status', '1')
                 ->order_by('packing_date', 'desc');
        $query = $this -> db -> get();
        return $query->result_array();
    }
    //end of stock in outer boxes QTywise
     //tot direct lot qty correction 
    function m_update_delivery_qty_lbl()
    {
        $pre_deliveries=$this->m_masters->getallmaster('bud_lbl_predelivery');
        $update=TRUE;

        foreach ($pre_deliveries as $pre_delivery) {
            if(!$update)
                break;
            $check=$this->m_masters->getmasterdetails('bud_lbl_predelivery_items','p_delivery_id',$pre_delivery['p_delivery_id']);
            if($check)
                continue;
            $delivery_boxes=explode(',', $pre_delivery['p_delivery_boxes']);
            $this->db->select('delivery_id');
            $this->db->where("p_delivery_ref",$pre_delivery['p_delivery_id']);
            $delivery=$this->db->get('bud_lbl_delivery')->result_array();
            $delivery_id=(empty($delivery))?'':$delivery[0]['delivery_id'];

            foreach ($delivery_boxes as $key => $box_no) {
                $item_details=$this->m_masters->getmasterdetails('bud_lbl_outerbox_items','box_no',$box_no);

                foreach ($item_details as $item_detail) {
                    $data=array('p_delivery_id'=>$pre_delivery['p_delivery_id'],
                                'box_id'       =>$box_no,
                                'item_id'      =>$item_detail['item_id'],
                                'item_size'    =>$item_detail['item_size'],
                                'delivery_qty' =>$item_detail['total_qty'],
                                'delivery_id'  =>$delivery_id);
                    $update=$this->db->insert('bud_lbl_predelivery_items',$data);
                    $update=$this->m_insert_inv_id_lbl();
                    $update=$this->m_insert_item_rate_lbl();
                }
            }
        }
        return $update;
    }
    //insert item rate in predelivery items table
    function m_insert_item_rate_lbl()
    {
        $pre_deliveries=$this->m_masters->getcategoryallmaster('bud_lbl_predelivery_items','invoice_id !=',0);
        $update=TRUE;

        foreach ($pre_deliveries as $pre_delivery) {
            if(!$update)
                break;
            $invoices=$this->m_masters->getmasterIDvalue('bud_lbl_invoices','invoice_id',$pre_delivery['invoice_id'],'invoice_items_row');
            if($invoices){
                $item_row=explode(',', $invoices);
                foreach ($item_row as $key=>$items) {
                    $item=explode('-',$items);
                    $update_array=array('item_rate'=>$item[4]);
                    $condition=array('item_id'=>$item[0],
                                     'invoice_id'=>$pre_delivery['invoice_id']);
                    $this->db->where($condition);
                    $update=$this->db->update('bud_lbl_predelivery_items', $update_array);
                    
                }
            }
        }
        return $update;
    }
    function m_insert_inv_id_lbl()
    {
        $check=array();
        $update=true;
        $this->db->set('invoice_id',0);
        $this->db->where('invoice_id !=',0);
        $update=$this->db->update('bud_lbl_predelivery_items');
        $invoices=$this->m_masters->getallmaster('bud_lbl_invoices');
        foreach ($invoices as $invoice) {
            $dcs=explode(',', $invoice['selected_dc']);
            foreach ($dcs as $key => $value) {
                if(!$update)
                    break;
                $update_array=array('invoice_id'=>$invoice['invoice_id']);
                $condition=array('delivery_id'=>$value);
                $this->db->where($condition);
                $update=$this->db->update('bud_lbl_predelivery_items', $update_array);
            }
            
        }
        return $update;
    }
    function m_insert_dc_id_lbl()
    {
        $update=true;
        $pre_delivery_items=$this->m_masters->getallmaster('bud_lbl_predelivery_items');
        foreach ($pre_delivery_items as $pre_delivery) {
            if(!$update)
                break;
            $this->db->select('delivery_id');
            $this->db->where("p_delivery_ref",$pre_delivery['p_delivery_id']);
            $delivery=$this->db->get('bud_lbl_delivery')->result_array();
            $delivery_id=(empty($delivery))?'':$delivery[0]['delivery_id'];

            $update_array=array('delivery_id'=>$delivery_id);
            $condition=array('p_delivery_id'=>$pre_delivery['p_delivery_id']);
            $this->db->where($condition);
            $update=$this->db->update('bud_lbl_predelivery_items', $update_array);
            
        }
        return $update;
    }
    //partial qty labels
    //predelivery items tapes
    function m_update_predelivery_items_tapes()
    {
        $pre_deliveries=$this->m_masters->getallmaster('bud_te_predelivery');
        $update=TRUE;

        foreach ($pre_deliveries as $pre_delivery) {
            if(!$update)
                break;
            $check=$this->m_masters->getmasterdetails('bud_te_predelivery_items','p_delivery_id',$pre_delivery['p_delivery_id']);
            if($check)
                continue;
            $delivery_boxes=explode(',', $pre_delivery['p_delivery_boxes']);
            $this->db->select('delivery_id');
            $this->db->where("p_delivery_ref",$pre_delivery['p_delivery_id']);
            $this->db->where("is_deleted",1);
            $delivery=$this->db->get('bud_te_delivery')->result_array();
            $delivery_id=(empty($delivery))?'':$delivery[0]['delivery_id'];

            foreach ($delivery_boxes as $key => $box_no) {
                $item_details=$this->m_masters->getmasterdetails('bud_te_outerboxes','box_no',$box_no);
                foreach ($item_details as $item_detail) {
                    $check=$this->m_masters->getmasterdetails('bud_te_predelivery_items','box_id',$box_no);
                    if($check)
                        continue;
                    $data=array('p_delivery_id'=>$pre_delivery['p_delivery_id'],
                                'box_id'       =>$box_no,
                                'item_id'      =>$item_detail['packing_innerbox_items'],
                                'delivery_qty_meters' =>$item_detail['total_meters'],
                                'delivery_qty_kgs' =>$item_detail['packing_net_weight'],
                                'delivery_id'  =>$delivery_id,
                                'is_deleted' => '1');
                    $update=$this->db->insert('bud_te_predelivery_items',$data);
                }
            }

        }
        $update=$this->m_insert_inv_id_te();
        $update=$this->m_insert_item_rateanduom_te();
        return $update;
    }
    function m_insert_item_rateanduom_te()
    {
        $pre_deliveries=$this->m_masters->getcategoryallmaster('bud_te_predelivery_items','invoice_id !=',0);
        $update=TRUE;

        foreach ($pre_deliveries as $pre_delivery) {
            if(!$update)
                break;
            $invoices=$this->m_masters->getmasterdetails('bud_te_invoices','invoice_id',$pre_delivery['invoice_id']);
            foreach ($invoices as $invoice) {
                $items_row=explode(',', $invoice['invoice_items']);
                $rate_row=explode(',', $invoice['item_rate']);
                $uom_row=explode(',', $invoice['item_uoms']);
                foreach ($items_row as $key=>$item_id) {
                    $update_array=array('item_rate'=>$rate_row[$key],
                                        'uom'=>$uom_row[$key]);
                    $condition=array('item_id'=>$item_id,
                                     'invoice_id'=>$pre_delivery['invoice_id']);
                    $this->db->where($condition);
                    $update=$this->db->update('bud_te_predelivery_items', $update_array);
                }
            }
        }
        return $update;
    }
    //predelivery items tapes
    function m_insert_inv_id_te()
    {
        $check=array();
        $update=true;
        $this->db->select('*');
        $this->db->where("is_cancelled",0);
        $invoices=$this->db->get('bud_te_invoices')->result_array();
        foreach ($invoices as $invoice) {
            $dcs=explode(',', $invoice['selected_dc']);
            foreach ($dcs as $key => $value) {
                if(!$update)
                    break;
                $update_array=array('invoice_id'=>$invoice['invoice_id']);
                $condition=array('delivery_id'=>$value);
                $this->db->where($condition);
                $update=$this->db->update('bud_te_predelivery_items', $update_array);
            }
            
        }
        return $update;
    }
    //ER-09-18#-58
    function m_update_predelivery_items_yt()//ER-09-18#-58
    {
        $pre_deliveries=$this->m_masters->getactivemaster('bud_yt_predelivery','p_delivery_is_deleted');
        $update=TRUE;

        foreach ($pre_deliveries as $pre_delivery) {
            if(!$update)
                break;
            $check=$this->m_masters->getmasterdetails('dyn_yt_predelivery_items','p_delivery_id',$pre_delivery['p_delivery_id']);
            if($check)
                continue;
            $delivery_boxes=explode(',', $pre_delivery['p_delivery_boxes']);
            $this->db->select('delivery_id');
            $this->db->where("p_delivery_ref",$pre_delivery['p_delivery_id']);
            $this->db->where("delivery_is_deleted",1);
            $delivery=$this->db->get('bud_yt_delivery')->result_array();
            $delivery_id=(empty($delivery))?'':$delivery[0]['delivery_id'];

            foreach ($delivery_boxes as $key => $box_id) {
                $item_details=$this->m_masters->getmasterdetails('bud_yt_packing_boxes','box_id',$box_id);
                foreach ($item_details as $item_detail) {
                    $check=$this->m_masters->getmasterdetails('dyn_yt_predelivery_items','box_id',$box_id);
                    if($check)
                        continue;
                    if(($item_detail['box_prefix']=='TH')||($item_detail['box_prefix']=='TI')){
                        $delivery_qty=$item_detail['no_of_cones'];
                        $uom='cones';
                    }
                    else{
                        $delivery_qty=$item_detail['net_weight'];
                        $uom='kgs';
                    }
                    $data=array('p_delivery_id' =>$pre_delivery['p_delivery_id'],
                                'box_id'        =>$box_id,
                                'item_id'       =>$item_detail['item_id'],
                                'delivery_qty'  =>$delivery_qty,
                                'uom'           =>$uom,
                                'delivery_id'   =>$delivery_id,
                                'is_deleted' => '1');
                    $update=$this->db->insert('dyn_yt_predelivery_items',$data);
                }
            }

        }
        $update=$this->m_insert_inv_id_yt();
        return $update;
    }
    function m_insert_inv_id_yt()//ER-09-18#-58
    {
        $update=TRUE;
        $invoices=$this->m_masters->getallmaster('bud_yt_invoices');
        foreach ($invoices as $invoice) {
            if($update){
                if ($invoice['is_cancelled']=='1') {
                    continue;
                }
                $box_row=explode(',', $invoice['boxes_array']);
                $rate_row=explode(',', $invoice['item_rate']);
                foreach ($box_row as $key=>$box_id) {
                    if($update){
                        $update_array=array(
                            'item_rate' =>$rate_row[$key],
                            'invoice_id'=>$invoice['invoice_id']);
                        $condition=array('box_id'=>$box_id);
                        $this->db->where($condition);
                        $update=$this->db->update('dyn_yt_predelivery_items', $update_array);
                    }
                }
            }
        }
        return $update;
    }
    //ER09-18#-58
    function m_to_remove_duplicate_dc_labels()
    {
        $check=array();
        $update=false;
        $dc_no_array=array();
        $avail_key[1]=0;
        $avail_key[2]=0;
        $test_dc_count=1;
        $concern_name=1;
        $dc_count[2] = sizeof($this->m_masters->getmasterdetails('bud_lbl_delivery', 'concern_name', 2));
        $dc_count[1]= sizeof($this->m_masters->getmasterdetails('bud_lbl_delivery', 'concern_name', 1));
        while ($test_dc_count<= $dc_count[$concern_name]) {
            if($test_dc_count== $dc_count[$concern_name]){
                if($concern_name==2)
                {
                    break;
                }
                $concern_name=2;
                $test_dc_count=1;
            }
            $financialyear = (date('m')<'04') ? date('y',strtotime('-1 year')) : date('y');
            $financialyear .= '-'.($financialyear + 1);
            $prefix = $this->m_masters->getmasterIDvalue('bud_concern_master', 'concern_id', $concern_name, 'concern_prefix');
            $test_dc_no = $prefix.'-'.$financialyear.'/'.($test_dc_count);
            $exist_dc=$this->m_masters->getmasterdetails('bud_lbl_delivery', 'dc_no', $test_dc_no);
            if(!$exist_dc)
            {
                $avail_dc_no[$concern_name][]=$test_dc_no;
            }
            $test_dc_count++;
        }
        $test_dc_count=1;
        $concern_name=1;
        while ($test_dc_count<= $dc_count[$concern_name]) {
            if($test_dc_count== $dc_count[$concern_name]){
                if($concern_name==2)
                {
                    break;
                }
                $concern_name=2;
                $test_dc_count=1;
            }
            $financialyear = (date('m')<'04') ? date('y',strtotime('-1 year')) : date('y');
            $financialyear .= '-'.($financialyear + 1);
            $prefix = $this->m_masters->getmasterIDvalue('bud_concern_master', 'concern_id', $concern_name, 'concern_prefix');
            $test_dc_no = $prefix.'-'.$financialyear.'/'.($test_dc_count);
            $exist_dc=$this->m_masters->getmasterdetails('bud_lbl_delivery', 'dc_no', $test_dc_no);
            if(sizeof($exist_dc)>1)
            {
                if($avail_dc_no[$concern_name][$avail_key[$concern_name]])
                {
                    $this->db->where('delivery_id',$exist_dc[1]['delivery_id']);
                    $update=$this->db->update('bud_lbl_delivery', array('dc_no'=>$avail_dc_no[$concern_name][$avail_key[$concern_name]]));
                    $avail_key[$concern_name]++;
                }
            }
            $test_dc_count++;
        }
        return $update;
    }
    //ER-07-18#-19
    function get_poy_vs_pack_rep_yt($term=2,$selected_month,$selected_year)
    {
        //Initailisation
        $date_format=($term==2)?'Y':'M-y';
        $data['tot_gr_wt']['packed']=0;
        $data['tot_nt_wt']['packed']=0;
        $data['tot_box']['packed']=0;
        $data['tot_poy_denier']['packed']=array();
        $data['tot_poy']['packed']=array();
        $data['tot_qty']['poy']=array();
        $data['tot_poy']['poy']=array();
        $data['tot_poy_denier']['poy']=array();
        $data['details']=array();
        //to get data 
        $year=($selected_year==0)?date('Y'):$selected_year;
        if(($selected_month!=0)&&($selected_month>date('m'))&&($selected_year==0))
            $year--;
        $end_year=($selected_year==0)?'2015':$selected_year;
        while ($year>=$end_year) {
            if($term==2)
            {
                $date_format=$year;
                $start_date=date('Y-m-d',strtotime('01-01-'.$date_format));
                $end_date=date('Y-m-d',strtotime('31-12-'.$date_format));
                $mon=1;
                $end_month=1;
            }
            elseif($term==1)
            {
                if ($year==date('Y')) {
                $mon=($selected_month==0)?(int)date('m'):$selected_month;
                }
                else {
                $mon=($selected_month==0)?12:$selected_month;    
                }
                $end_month=($selected_month==0)?1:$selected_month;
            }
            while($mon>=$end_month) {
                //initialization
                if($term==1)
                {
                    $month=($mon>9)?$mon:'0'.$mon;
                    $date_format=$month.'-'.$year;
                    $start_date=date('Y-m-d',strtotime('01-'.$date_format));
                    $end_date=date('Y-m-t',strtotime('01-'.$date_format));
                }                            //condition
                $pkd_condition = array(
                    'packed_date >='=>$start_date,
                    'packed_date <='=>$end_date,
                    'poy_inward_no !='=>'0',
                    'is_deleted'=>'0'
                    );
                $poy_condition = array(
                    'inward_date >='=>$start_date,
                    'inward_date <='=>$end_date
                    );      
                $data['details'][$date_format]['packed']['gr_wt']=0;
                $data['details'][$date_format]['term']=$term;
                $data['details'][$date_format]['packed']['nt_wt']=0;
                $data['details'][$date_format]['packed']['boxes']=0;           
                $data['details'][$date_format]['packed']['denier']=array();
                $data['details'][$date_format]['packed']['poy']=array();
                $data['details'][$date_format]['poy']['qty']=array();
                $data['details'][$date_format]['poy']['poy_inw']=array();
                $data['details'][$date_format]['poy']['poy_denier']=array();
                $this->db->select_sum('gross_weight');
                $this->db->where($pkd_condition);
                $this->db->from('bud_yt_packing_boxes');
                $gr_wt=$this->db->get()->result_array();
                $data['details'][$date_format]['packed']['gr_wt']=($gr_wt[0]['gross_weight']==null)?0:$gr_wt[0]['gross_weight'];
                $data['tot_gr_wt']['packed']+=($gr_wt[0]['gross_weight']==null)?0:$gr_wt[0]['gross_weight'];
                $this->db->select_sum('net_weight');
                $this->db->where($pkd_condition);
                $this->db->from('bud_yt_packing_boxes');
                $nt_wt=$this->db->get()->result_array();
                $data['details'][$date_format]['packed']['nt_wt']=($nt_wt[0]['net_weight']==null)?0:$nt_wt[0]['net_weight'];
                $data['tot_nt_wt']['packed']+=($nt_wt[0]['net_weight']==null)?0:$nt_wt[0]['net_weight'];
                $this->db->where($pkd_condition);
                $boxes=$this->db->count_all_results('bud_yt_packing_boxes');
                $data['details'][$date_format]['packed']['boxes']=$boxes;
                $data['tot_box']['packed']+=$boxes;
                $this->db->select('poy_denier,poy_inward_no');
                $this->db->where($pkd_condition);
                $this->db->from('bud_yt_packing_boxes');
                $poy_packed=$this->db->get()->result_array();
                foreach ($poy_packed as $box) {
                    $data['details'][$date_format]['packed']['poy'][$box['poy_inward_no']]=$box['poy_inward_no'];
                    $data['tot_poy']['packed'][$box['poy_inward_no']]=$box['poy_inward_no'];
                    $data['details'][$date_format]['packed']['denier'][$box['poy_denier']]=$box['poy_denier'];
                    $data['tot_poy_denier']['packed'][$box['poy_denier']]=$box['poy_denier'];
                }
                $poys=$this->get_two_table_values('bud_yt_poyinw_items','bud_yt_poy_inward','bud_yt_poy_inward.po_no,po_qty,poy_denier','po_no','po_no',$poy_condition);
                foreach ($poys as $poy) {
                    $data['details'][$date_format]['poy']['poy_inw'][$poy['po_no']]=$poy['po_no'];
                    $data['tot_poy']['poy'][$poy['po_no']]=$poy['po_no'];
                    $data['details'][$date_format]['poy']['poy_denier'][$poy['poy_denier']]=$poy['poy_denier'];
                    $data['tot_poy_denier']['poy'][$poy['poy_denier']]=$poy['poy_denier'];
                    $data['details'][$date_format]['poy']['qty'][$poy['po_qty']]=$poy['po_qty'];
                    $data['tot_qty']['poy'][$poy['po_qty']]=$poy['po_qty'];
                }
                $mon--;
            }
            //decrement
            $mon=($term==2)?1:12;
            $year--;
        }
        return $data;
    }
    function get_poy_wise_poyvspacking_rep_yt($from_date,$to_date,$term)
    {
        $date_format=($term==2)?'Y':'M-y';
        $data['tot_gr_wt']['packed']=0;
        $data['tot_nt_wt']['packed']=0;
        $data['tot_box']['packed']=0;
        $data['tot_poy_denier']['packed']=array();
        $data['tot_item']['packed']=array();
        $data['tot_poy']['packed']=array();
        $data['tot_qty']['poy']=0;
        $data['tot_item']['poy']=array();
        $data['tot_poy_denier']['poy']=array();
        $data['details']=array();

        if(!empty($from_date))
        {
            $this->db->where('packed_date >=',$from_date);
        }
        if(!empty($to_date))
        {
            $this->db->where('packed_date <=',$to_date);
        }
        $this->db->where('is_deleted','0');
        $this->db->where('poy_inward_no !=','0');
        $this->db->select('bud_items.item_name,bud_yt_packing_boxes.*');
        $this->db->from('bud_yt_packing_boxes');
        $this->db->join('bud_items','bud_yt_packing_boxes.item_id = bud_items.item_id','left');
        $this->db->order_by('bud_yt_packing_boxes.item_id','asc');
        $boxes_items=$this->db->get()->result_array();
        $poy_condition = array(
        'inward_date >='=>$from_date,
        'inward_date <='=>$to_date
        );
        $poys=$this->get_two_table_values('bud_yt_poyinw_items',null,'po_no,po_qty,poy_denier,item_id',null,null,$poy_condition);
        foreach ($boxes_items as $boxes) {
            $data['details'][$boxes['poy_inward_no']]['packed']['gr_wt']=array();
            $data['details'][$boxes['poy_inward_no']]['packed']['nt_wt']=array();
            $data['details'][$boxes['poy_inward_no']]['packed']['item']=0;
            $data['details'][$boxes['poy_inward_no']]['packed']['poy_denier']=0;
            $data['details'][$boxes['poy_inward_no']]['poy']['qty']=array();
            $data['details'][$boxes['poy_inward_no']]['poy']['item']=0;
            $data['details'][$boxes['poy_inward_no']]['poy']['poy_denier']=0;
        }
        foreach ($poys as $boxes) {
            $data['details'][$boxes['po_no']]['packed']['gr_wt']=array();
            $data['details'][$boxes['po_no']]['packed']['nt_wt']=array();
            $data['details'][$boxes['po_no']]['packed']['item']=0;
            $data['details'][$boxes['po_no']]['packed']['poy_denier']=0;
            $data['details'][$boxes['po_no']]['poy']['qty']=array();
            $data['details'][$boxes['po_no']]['poy']['item']=0;
            $data['details'][$boxes['po_no']]['poy']['poy_denier']=0;
        }
        foreach ($boxes_items as $boxes) { 
            $data['details'][$boxes['poy_inward_no']]['packed']['gr_wt'][]=$boxes['gross_weight'];
            $data['details'][$boxes['poy_inward_no']]['packed']['nt_wt'][]=$boxes['net_weight'];
            $data['details'][$boxes['poy_inward_no']]['packed']['item']=$boxes['item_id'];
            $data['details'][$boxes['poy_inward_no']]['packed']['poy_denier']=$boxes['poy_denier'];
            $data['tot_gr_wt']['packed']+=$boxes['gross_weight'];
            $data['tot_nt_wt']['packed']+=$boxes['net_weight'];
            $data['tot_box']['packed']++;
            $data['tot_poy_denier']['packed'][$boxes['poy_denier']]=$boxes['poy_denier'];
            $data['tot_item']['packed'][$boxes['item_id']]=$boxes['item_id'];
        }
        foreach ($poys as $poy) { 
            $data['details'][$poy['po_no']]['poy']['qty'][]=$poy['po_qty'];
            $data['details'][$poy['po_no']]['poy']['item']=$poy['item_id'];
            $data['details'][$poy['po_no']]['poy']['poy_denier']=$poy['poy_denier'];
            $data['tot_item']['poy'][$poy['item_id']]=$poy['item_id'];
            $data['tot_poy_denier']['poy'][$poy['poy_denier']]=$poy['poy_denier'];
            $data['tot_qty']['poy']+=$poy['po_qty'];
        } 
        return $data;
    }
    function get_box_wise_poyvspacking_rep_yt($from_date,$to_date,$term,$poy_inward_no)
    {
        $date_format=($term==2)?'Y':'M-y';
        if(!empty($from_date))
        {
            $this->db->where('packed_date >=',$from_date);
        }
        if(!empty($to_date))
        {
            $this->db->where('packed_date <=',$to_date);
        }
        if(!empty($poy_inward_no))
        {
            $this->db->where('bud_yt_packing_boxes.poy_inward_no =',$poy_inward_no);
        }
        $this->db->where('is_deleted','0');
        $this->db->select('bud_items.item_name,bud_yt_packing_boxes.*,bud_shades.shade_name,bud_shades.shade_code,bud_stock_rooms.stock_room_name,bud_yt_poydeniers.denier_name,bud_users.display_name');
        $this->db->from('bud_yt_packing_boxes');
        $this->db->join('bud_items','bud_yt_packing_boxes.item_id = bud_items.item_id','left');
        $this->db->join('bud_yt_poydeniers','bud_yt_packing_boxes.poy_denier = bud_yt_poydeniers.denier_id','left');
        $this->db->join('bud_stock_rooms','bud_yt_packing_boxes.stock_room_id = bud_stock_rooms.stock_room_id','left');
        $this->db->join('bud_shades','bud_yt_packing_boxes.shade_no = bud_shades.shade_id','left');
        $this->db->join('bud_users','bud_yt_packing_boxes.packed_by = bud_users.ID','left');
        $this->db->order_by('bud_yt_packing_boxes.packed_date','asc');
        $boxes_items=$this->db->get()->result_array();
        return $boxes_items;
    }
    //end of ER-07-18#-19
    function m_find_duplicate_box_no_yt()
    {
    	$duplicate_boxes['deleted']=array();
    	$duplicate_boxes['normal']=array();
    	$this->db->select('box_no,box_prefix');
    	$this->db->where('packed_date <=','2018-08-31');
    	$this->db->where('packed_date >=','2018-07-31');
    	$this->db->from('bud_yt_packing_boxes');
    	$boxes=$this->db->get()->result_array();
    	foreach ($boxes as $box) {
    		$this->db->select('box_id,is_deleted,box_no,box_prefix');
    		$this->db->where('box_prefix',$box['box_prefix']);
    		$this->db->where('box_no',$box['box_no']);
    		$this->db->from('bud_yt_packing_boxes');
    		$find_boxes=$this->db->get()->result_array();
    		$count=0;
    		if(count($find_boxes)>1){
				foreach ($find_boxes as $find_box) {
					$count++;
					if($count>1){
						
						if($find_box['is_deleted']==1){
							$duplicate_boxes['deleted'][]=$find_box['box_id'].$find_box['box_prefix'].$find_box['box_no'].' ';
						}
						else
						{
							$duplicate_boxes['normal'][]=$find_box['box_id'].$find_box['box_prefix'].$find_box['box_no'].' ';
						}
					}
				}
			}
    	}
    return $duplicate_boxes;
    }
    function get_yt_box_lot_no($box_id)
    {
        $box_details=$this->m_masters->getmasterdetails('bud_yt_packing_boxes', 'box_id', $box_id);
        foreach ($box_details as $row) {
            $lot_no=$row['lot_no'];
            if($row['packed_date']<='2018-03-31'){
                $yarn_table='bud_yarn_lots_pr_yr';
                $lot_table='bud_lots_pr_yr';
            }
            else{
                $yarn_table='bud_yarn_lots';
                $lot_table='bud_lots';
            }
            if (($row['box_prefix']=='G')||($row['box_prefix']=='S')) {
                $lot_no =$this->m_masters->getmasterIDvalue($yarn_table, 'yarn_lot_id', $row['yarn_lot_id'],'yarn_lot_no');
            }
            if (($row['box_prefix']=='DIR')||($row['box_prefix']=='TH')||($row['box_prefix']=='TI')||($row['box_prefix']=='D')) {
                $direct_entry=($row['box_prefix']=='DIR')?1:0;
                $condition=array('lot_id'=>$row['lot_no'],
                                  'direct_entry'=>$direct_entry);
                $result_lot =$this->m_mir->get_two_table_values($lot_table,null,'lot_no','','',$condition);
                $lot_no=($result_lot)?$result_lot[0]['lot_no']:'';
            }
        }
        return $lot_no;
    }
    //end of ER-07-18#-19
    function m_remove_delivered_stock_te()
    {
        $result=true;
        $this->db->select('p_delivery_boxes,p_delivery_id');
        $this->db->where('p_delivery_is_deleted',1);
        $this->db->from('bud_te_predelivery');
        $pdcs=$this->db->get()->result_array();
        $updateData = array(
            'delivery_status' => 0 
            );
        $update_p_del = array(
            'predelivery_status' => 0 
            );
        foreach ($pdcs as $pdc) {
            $boxes=explode(',',$pdc['p_delivery_boxes']);
            $dc=$this->get_two_table_values('bud_te_delivery','','delivery_id','','',array(
                    'p_delivery_ref '=>$pdc['p_delivery_id'], 
                    'is_deleted '=>1
                ));
            foreach ($boxes as $box) {
                if($result){
                    $result=$this->m_purchase->updateDatas('bud_te_outerboxes', 'box_no', $box, $update_p_del);
                    if(($dc)&&($result)){
                        $dc_id=$dc[0]['delivery_id'];
                     $result  =$this->m_purchase->updateDatas('bud_te_outerboxes', 'box_no', $box, $updateData);
                    }
                }
            }
        }
    return $result;
    }
}
