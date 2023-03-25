<?php
class M_production extends CI_Model {
	function __construct()
    {
        parent::__construct();
    }
    public function save_zip_outerbox($save)
    {
        if($save['box_no'])
        {
            $this->db->where('box_no', $save['box_no']);
            $this->db->update('bud_te_outerboxes', $save);
            return $save['box_no'];
        }
        else
        {
            $this->db->insert('bud_te_outerboxes', $save);
            return $this->db->insert_id();
        }
    }
    function get_zip_outerbox($box_no)
    {
        $this->db->where('box_no', $box_no);
        $query = $this->db-> get('bud_te_outerboxes');
        return $query->row();
    }
    function P_order_custwise()
    {
        $this->db->select('*')
                 ->from('bud_te_purchaseorders')
                 ->where('order_status', 1);
        $query = $this -> db -> get();
        return $query->result_array();
    }
    function P_order_itemwise()
    {
        $this->db->select('*,SUM(enq_req_qty)')
                 ->from('bud_te_enq_items')
                 ->where('enq_item_status', 1)
                 ->group_by("enq_item");
        $query = $this -> db -> get();
        return $query->result_array();
    }
    function get_innerboxes_list($packing_customer, $packing_item)
    {
        $this->db->select('*');
        $this->db->from('bud_te_innerboxes');
        if($packing_customer != null)
        {
            $this->db->where('packing_cust', $packing_customer);
        }
        if($packing_item != null)
        {
            $this->db->where('packing_item', $packing_item);
        }
        $this->db->where('packing_outerbox', 1);
        $this->db->order_by('box_no', 'desc');
        $query = $this -> db -> get();
        return $query->result_array();
    }
    function get_outerboxes_list($packing_customer, $packing_item)
    {
        $this->db->select('*');
        $this->db->from('bud_te_outerboxes');
        if($packing_customer != null)
        {
            $this->db->where('packing_customer', $packing_customer);
        }
        if($packing_item != null)
        {
            $this->db->where('packing_innerbox_items', $packing_item);
        }
        $this->db->where('delivery_status', 1);
        $query = $this -> db -> get();
        return $query->result_array();
    }
    function getBoxesDaterange($tablename, $column, $from, $to)
    {
        $this->db->select('*')
                 ->from($tablename)
                 ->where("$column BETWEEN '$from' AND '$to'");
        $query = $this -> db -> get();
        return $query->result_array();
    }
    function getPoDetails($po_no) 
    {
        $this->db->select('bud_lbl_po_received.*,bud_customers.cust_name,bud_lbl_items.*, bud_te_machines.*')
                 ->from('bud_lbl_po_received')
                 ->join('bud_customers', 'bud_customers.cust_id = bud_lbl_po_received.customer_id')
                 ->join('bud_lbl_items', 'bud_lbl_items.item_id = bud_lbl_po_received.item_code')
                 ->join('bud_te_machines', 'bud_te_machines.machine_id = bud_lbl_po_received.machine_id')
                 ->order_by('po_no', 'desc')
                 ->where('po_no', $po_no);
        $query = $this -> db -> get();
        return $query->result_array();
    }
    function TodayProdOperatorwise($from_date,$to_date,$operator_id,$machine_id,$item_id,$sample,$shift) //ER-09-18#-53 //ER-09-18#-56 //ER-09-18#-62
    {
        $this->db->select('bud_lbl_prod_entry_operator.*,dyn_operators.op_name,bud_lbl_items.*,staff.display_name AS entered_by,bud_te_machines.*')//ER-09-18#-62
                 ->from('bud_lbl_prod_entry_operator')
                 ->join('dyn_operators', 'dyn_operators.operator_id= bud_lbl_prod_entry_operator.operator_id')//ER-09-18#-62
                 ->join('bud_users AS staff', 'staff.ID = bud_lbl_prod_entry_operator.entered_id')
                 ->join('bud_lbl_items', 'bud_lbl_items.item_id = bud_lbl_prod_entry_operator.item_id')
                 ->join('bud_te_machines', 'bud_te_machines.machine_id = bud_lbl_prod_entry_operator.machine_id')
                 ->where('bud_lbl_prod_entry_operator.is_deleted',1)//ER-09-18#-62
                 ->order_by('bud_lbl_prod_entry_operator.id', 'desc');
        if($from_date){
            $this->db->where('prod_date >=',$from_date);
        }
        if($to_date){
            $this->db->where('prod_date <=',$from_date);
        }
        if($operator_id){
            $this->db->where('operator_id',$operator_id);
        }
        if($machine_id){
            $this->db->where('bud_lbl_prod_entry_operator.machine_id',$machine_id);
        }
        if($item_id){
            $this->db->where('bud_lbl_prod_entry_operator.item_id',$item_id);
        }
        if($sample){
            $this->db->where('sample',$sample);
        }
        if($shift){
            $this->db->where('shift',$shift);
        }
        $query = $this -> db -> get();
        return $query->result_array();
    }
    function op_latest_data($machine_id=null,$p_date=null,$shift=null) //ER-09-18#-54 //ER-09-18#-56
    {
        $this->db->select('*')
                 ->from('dyn_lbl_prod_size_entry')
                 ->join('bud_lbl_prod_entry_operator', 'bud_lbl_prod_entry_operator.id = dyn_lbl_prod_size_entry.id')
                 ->where('dyn_lbl_prod_size_entry.is_deleted',1)
                 ->where('bud_lbl_prod_entry_operator.is_deleted',1)
                 ->where('machine_id',$machine_id)
                 ->order_by('prod_date', 'desc')
                 ->order_by('mac_cl_time', 'desc');
        if($p_date){
            $this->db->where('prod_date',$p_date);
        }
        if($shift){
            $this->db->where('shift',$shift);
        }
        $query = $this -> db -> get();
        return $query->result_array();
    }
    function TodayRollEntry() 
    {
        $this->db->select('bud_lbl_rollentry.*,bud_users.display_name,bud_lbl_items.*')
                 ->from('bud_lbl_rollentry')
                 ->join('bud_users', 'bud_users.ID = bud_lbl_rollentry.operator_id')
                 ->join('bud_lbl_items', 'bud_lbl_items.item_id = bud_lbl_rollentry.item_id')
                 ->order_by('bud_lbl_rollentry.id', 'desc');
        $query = $this -> db -> get();
        return $query->result_array();
    }
    function productionStock($item_id)
    {
        $this->db->select('*')
                 ->from('bud_lbl_rollentry')
                 ->where('item_id', $item_id);
        $query = $this -> db -> get();
        return $query->result_array();
    }
    function labelOuterboxes()
    {
        $this->db->select('bud_lbl_outerboxes.*,bud_users.display_name,bud_lbl_items.item_name,SUM(`total_qty`)')
                 ->from('bud_lbl_outerboxes')
                 ->join('bud_lbl_outerbox_items', 'bud_lbl_outerbox_items.box_no = bud_lbl_outerboxes.box_no')
                 ->join('bud_users', 'bud_users.ID = bud_lbl_outerboxes.operator_id')
                 ->join('bud_lbl_items', 'bud_lbl_items.item_id = bud_lbl_outerboxes.item_id')
                 ->group_by('bud_lbl_outerboxes.box_no')
                 ->order_by('bud_lbl_outerboxes.box_no', 'desc')
                 ->where('bud_lbl_outerboxes.delivery_status', 1)
                 ->where('bud_lbl_outerboxes.is_deleted', 0);
                 // ->limit(1, 1);
        $query = $this -> db -> get();
        return $query->result_array();
    }
    function labelOuterboxesDatewise($fromdate, $todate)
    {
        $this->db->select('bud_lbl_outerboxes.*,bud_users.display_name,bud_lbl_items.item_name,SUM(`total_qty`)')
                 ->from('bud_lbl_outerboxes')
                 ->join('bud_lbl_outerbox_items', 'bud_lbl_outerbox_items.box_no = bud_lbl_outerboxes.box_no')
                 ->join('bud_users', 'bud_users.ID = bud_lbl_outerboxes.operator_id')
                 ->join('bud_lbl_items', 'bud_lbl_items.item_id = bud_lbl_outerboxes.item_id')
                 ->group_by('bud_lbl_outerboxes.box_no')
                 ->order_by('bud_lbl_outerboxes.box_no', 'desc')
                 ->where('bud_lbl_outerboxes.delivery_status', 1)
                 ->where("bud_lbl_outerboxes.date_time between '$fromdate' and '$todate'");
                 // ->limit(1, 1);
        $query = $this -> db -> get();
        return $query->result_array();
    }
    function labelAllOuterboxes()
    {
        $this->db->select('bud_lbl_outerboxes.*,bud_users.display_name,bud_lbl_items.item_name,SUM(`total_qty`)')
                 ->from('bud_lbl_outerboxes')
                 ->join('bud_lbl_outerbox_items', 'bud_lbl_outerbox_items.box_no = bud_lbl_outerboxes.box_no')
                 ->join('bud_users', 'bud_users.ID = bud_lbl_outerboxes.operator_id')
                 ->join('bud_lbl_items', 'bud_lbl_items.item_id = bud_lbl_outerboxes.item_id')
                 ->group_by('bud_lbl_outerboxes.box_no')
                 ->order_by('bud_lbl_outerboxes.box_no', 'desc');
                 // ->limit(1, 1);
        $query = $this -> db -> get();
        return $query->result_array();
    }
    function labelwiseOuterboxes($item_id)
    {
        $this->db->select('bud_lbl_outerboxes.*,bud_users.display_name,bud_lbl_items.item_name,SUM(`total_qty`)');
        $this->db->from('bud_lbl_outerboxes');
        $this->db->join('bud_lbl_outerbox_items', 'bud_lbl_outerbox_items.box_no = bud_lbl_outerboxes.box_no');
        $this->db->join('bud_users', 'bud_users.ID = bud_lbl_outerboxes.operator_id');
        $this->db->join('bud_lbl_items', 'bud_lbl_items.item_id = bud_lbl_outerboxes.item_id');
        $this->db->group_by('bud_lbl_outerboxes.box_no');
        $this->db->order_by('bud_lbl_outerboxes.box_no', 'desc');
        if($item_id != null)
        {
            $this->db->where('bud_lbl_outerboxes.item_id', $item_id);            }
        $this->db->where('bud_lbl_outerboxes.delivery_status', 1);
                 // ->limit(1, 1);
        $query = $this -> db -> get();
        return $query->result_array();
    }
    function lblPredelItemSearch($from_date, $to_date, $item_id)
    {
        $this->db->select('bud_lbl_outerboxes.*,bud_users.display_name,bud_lbl_items.item_name,SUM(`total_qty`)');
        $this->db->from('bud_lbl_outerboxes');
        $this->db->join('bud_lbl_outerbox_items', 'bud_lbl_outerbox_items.box_no = bud_lbl_outerboxes.box_no');
        $this->db->join('bud_users', 'bud_users.ID = bud_lbl_outerboxes.operator_id');
        $this->db->join('bud_lbl_items', 'bud_lbl_items.item_id = bud_lbl_outerboxes.item_id');
        $this->db->group_by('bud_lbl_outerboxes.box_no');
        $this->db->order_by('bud_lbl_outerboxes.box_no', 'desc');
        if($item_id != null)
        {
            $this->db->where('bud_lbl_outerboxes.item_id', $item_id);            }
        if($from_date != null && $to_date != null)
        {
            $this->db->where("bud_lbl_outerboxes.date_time between '$from_date' and '$to_date'");            }
        //$this->db->where('bud_lbl_outerboxes.delivery_status', 1);
        $this->db->where('bud_lbl_outerboxes.is_deleted', 0);
                 // ->limit(1, 1);
        $query = $this -> db -> get();
        return $query->result_array();
    }
    //partial qty delivery 
    function boxDeliveredQty($box_no=null,$item=null,$itemsize=null,$p_delivery_id=null,$delivery_id=null,$invoice_id=null)
    {
        $this->db->select('SUM(`delivery_qty`)');
        if($box_no)
            $this->db->where('box_id',$box_no);
        if($item)
            $this->db->where('item_id',$item);
        if($itemsize)
            $this->db->where('item_size',$itemsize);
        if($p_delivery_id)
            $this->db->where('p_delivery_id',$p_delivery_id);
        if($delivery_id)
            $this->db->where('delivery_id',$delivery_id);
        if($invoice_id)
            $this->db->where('invoice_id',$invoice_id);
        $this->db->where('p_delivery_is_deleted',1); 
        $this->db->from('bud_lbl_predelivery_items');
        $query = $this -> db -> get()->result_array();
        return $query[0]['SUM(`delivery_qty`)'];
    }
    function tePredelItemSearch($from_date, $to_date, $packing_customer, $packing_item)
    {
        $this->db->select('bud_te_outerboxes.*');
        $this->db->select('bud_stock_rooms.stock_room_name');
        $this->db->select('bud_te_items.item_sample');
        $this->db->from('bud_te_outerboxes');
        $this->db->join('bud_stock_rooms','bud_te_outerboxes.packing_stock_room = bud_stock_rooms.stock_room_id', 'left');
        $this->db->join('bud_te_items','bud_te_outerboxes.packing_innerbox_items = bud_te_items.item_id', 'left');
        if($packing_customer != null)
        {
            $this->db->where('packing_customer', $packing_customer);
        }
        if($packing_item != null)
        {
            $this->db->where('packing_innerbox_items', $packing_item);
        }
        if($from_date != null && $to_date != null)
        {
            $this->db->where("packing_date between '$from_date' and '$to_date'");            }
        $this->db->where('delivery_status', 1);
        $query = $this -> db -> get();
        return $query->result_array();
    }

    function get_te_packing_boxes($filter = array())
    {
        $this->db->select('bud_te_outerboxes.*');
        $this->db->select('bud_stock_rooms.stock_room_name');
        $this->db->select('bud_te_items.item_sample');
        $this->db->from('bud_te_outerboxes');
        $this->db->join('bud_stock_rooms','bud_te_outerboxes.packing_stock_room = bud_stock_rooms.stock_room_id', 'left');
        $this->db->join('bud_te_items','bud_te_outerboxes.packing_innerbox_items = bud_te_items.item_id', 'left');
        if(count($filter) > 0)
        {
            if(isset($filter['from_date']) && isset($filter['to_date']))
            {
                $from_date = date("Y-m-d", strtotime($filter['from_date']));
                $to_date = date("Y-m-d", strtotime($filter['to_date']));
                $this->db->where("DATE(bud_te_outerboxes.packing_date) BETWEEN '$from_date' AND '$to_date'");
            }
            if(isset($filter['packing_item']))
            {
                $this->db->where('packing_innerbox_items', $filter['packing_item']);
            }
            if(isset($filter['packing_customer']))
            {
                $this->db->where('packing_customer', $filter['packing_customer']);                    }
        }
        $this->db->where('delivery_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }
    /*function labelOuterboxes()
    {
        $this->db->select('bud_lbl_outerboxes.*,bud_users.display_name,bud_lbl_items.item_name,SUM(`total_qty`)')
                 ->from('bud_lbl_outerboxes')
                 ->join('bud_lbl_outerbox_items', 'bud_lbl_outerbox_items.box_no = bud_lbl_outerboxes.box_no')
                 ->join('bud_users', 'bud_users.ID = bud_lbl_outerboxes.operator_id')
                 ->join('bud_lbl_items', 'bud_lbl_items.item_id = bud_lbl_outerboxes.item_id')
                 ->order_by('bud_lbl_outerboxes.box_no', 'desc');
        $query = $this -> db -> get();
        return $query->result_array();
    }*/
    function labelTotalPackQty($item_id, $item_size) 
    {
        $this->db->select('SUM(`total_qty`) as total_pack_qty')
                 ->from('bud_lbl_outerbox_items')
                 ->where('item_id', $item_id)
                 ->where('item_size', $item_size);
        $query = $this -> db -> get();
        $row = $query->row(); 
        return $row->total_pack_qty;
    }
    function labelProductionClose($item_size) 
    {
        $production_closed = array();
        $run = "FIND_IN_SET('".$item_size."', label_sizes)";
        $this->db->select('*')
                 ->from('bud_lbl_rollentry')
                 ->where($run);
        $query = $this -> db -> get();
        $result = $query->result_array();
        foreach ($result as $row) {
            $id = $row['id'];
            $label_sizes = explode(",", $row['label_sizes']);
            $production_closed = explode(",", $row['production_closed']);
            foreach ($label_sizes as $key => $value) {
               if($value == $item_size)
               {
                $production_closed[$key] = 0;
               }
            }
            $data = array('production_closed' => implode(",", $production_closed));
            $this->db->where('id', $id);
            $this->db->update('bud_lbl_rollentry', $data);            }
    }
    function labelOuterbox($box_no) 
    {
        $this->db->select('bud_lbl_outerbox_items.*,bud_users.display_name,bud_lbl_items.*,bud_lbl_outerboxes.*')
                 ->from('bud_lbl_outerbox_items')
                 ->join('bud_lbl_outerboxes', 'bud_lbl_outerboxes.box_no = bud_lbl_outerbox_items.box_no')
                 ->join('bud_users', 'bud_users.ID = bud_lbl_outerboxes.operator_id')
                 ->join('bud_lbl_items', 'bud_lbl_items.item_id = bud_lbl_outerboxes.item_id')
                 ->where('bud_lbl_outerbox_items.box_no', $box_no);
        $query = $this -> db -> get();
        return $query->result_array();
    }
    function labelCartItems($user_id)
    {
        $this->db->select('bud_lbl_cart_items.*,bud_lbl_outerboxes.*,bud_lbl_items.item_name,SUM(`total_qty`)')
                 ->from('bud_lbl_cart_items')
                 ->join('bud_lbl_outerboxes', 'bud_lbl_outerboxes.box_no = bud_lbl_cart_items.item_id')
                 ->join('bud_lbl_outerbox_items', 'bud_lbl_outerbox_items.box_no = bud_lbl_cart_items.item_id')
                 ->join('bud_lbl_items', 'bud_lbl_items.item_id = bud_lbl_outerboxes.item_id')
                 ->group_by('bud_lbl_cart_items.item_id')
                 ->order_by('bud_lbl_cart_items.item_id', 'desc')
                 ->where('bud_lbl_cart_items.user_id', $user_id);
                 // ->limit(1, 1);
        $query = $this -> db -> get();
        return $query->result_array();
    }
    function labelDcItems($boxes)
    {
        $this->db->select('bud_lbl_outerboxes.*,bud_users.display_name,bud_lbl_items.item_name')
                 ->from('bud_lbl_outerboxes')
                 ->join('bud_users', 'bud_users.ID = bud_lbl_outerboxes.operator_id')
                 ->join('bud_lbl_items', 'bud_lbl_items.item_id = bud_lbl_outerboxes.item_id')
                 ->group_by('bud_lbl_outerboxes.box_no')
                 ->where_in('bud_lbl_outerboxes.box_no', $boxes);
                 // ->limit(1, 1);
        $query = $this -> db -> get();
        return $query->result_array();
    }
    function labelInvoiceItems($boxes)
    {
        $this->db->select('bud_lbl_outerboxes.*,bud_users.display_name,bud_lbl_items.item_name,bud_lbl_outerbox_items.total_qty,bud_lbl_outerbox_items.item_size')
                 ->from('bud_lbl_outerboxes')
                 ->join('bud_lbl_outerbox_items', 'bud_lbl_outerbox_items.box_no = bud_lbl_outerboxes.box_no')
                 ->join('bud_users', 'bud_users.ID = bud_lbl_outerboxes.operator_id')
                 ->join('bud_lbl_items', 'bud_lbl_items.item_id = bud_lbl_outerboxes.item_id')
                 // ->group_by('bud_lbl_outerboxes.box_no')
                 ->where_in('bud_lbl_outerboxes.box_no', $boxes);
                 // ->limit(1, 1);
        $query = $this -> db -> get();
        return $query->result_array();
    }
    //partial delivery qty
    function getItemSizeTot($box_no,$item_size,$pre_delivery_id)
    {
        $this->db->select('SUM(`delivery_qty`)')
                ->where('box_id',$box_no)  
                ->where('item_size',$item_size)
                ->where('p_delivery_id',$pre_delivery_id)
                ->where('p_delivery_is_deleted',1)
                ->from('bud_lbl_predelivery_items');
        $query = $this -> db -> get()->result_array();
        return $query[0]['SUM(`delivery_qty`)'];
    }
    //partial delivery qty
}
