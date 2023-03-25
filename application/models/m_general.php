<?php
class M_general extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }
    function getSupItemRate($supplier, $item_name)
    {
        $this->db->select('*')
                 ->from('bud_general_party_item_rates')
                 ->where('general_party_id', $supplier)
                 ->where('item_id', $item_name);
        $query = $this -> db -> get();
        return $query->last_row('array');
        // return $query->result_array();
    }
    function getGenItemBalQty($supplier, $dc_no, $item_name)
    {
        $this->db->select('*')
                 ->from('bud_general_dc_returnable_items')
                 ->where('dc_supplier', $supplier)
                 ->where('delivery_id', $dc_no)
                 ->where('item_id', $item_name);
        $query = $this -> db -> get();
        return $query->result_array();
    }
    function getStockrooms($module_id)
    {
        $this->db->select('*')
                 ->from('bud_stock_rooms')
                 ->where('module_id', $module_id);
        $query = $this -> db -> get();
        return $query->result_array();
    }
    function getCurrentStock($item_id, $concern_id, $stockroom_id)
    {
        $this->db->select('*')
                 ->from('bud_material_inward_log')
                 ->where('item_id', $item_id)
                 // ->where('concern_id', $concern_id)
                 ->where('stockroom_id', $stockroom_id);
        $query = $this -> db -> get();
        return $query->result_array();
    }
    function getOpeningStock($item_id, $concern_id, $stockroom_id)
    {
        $this->db->select('*')
                 ->from('bud_general_items')
                 ->where('item_id', $item_id)
                 ->where('concern_id', $concern_id)
                 ->where('stockroom_id', $stockroom_id);
        $query = $this -> db -> get();
        if ($query->num_rows() > 0)
        {
            $row = $query->row(); 
            return $row->opening_stock;            }
        // return $query->result_array();
    }
    function get_transfered_qty($stockroom_id)
    {
        $this->db->select_sum('item_qty');
        $this->db->from('bud_general_transfer_items');
        if(!empty($stockroom_id))
        {
            $this->db->where('from_stock_room', $stockroom_id);            }
        $query = $this->db->get();
        return $query->row()->item_qty;
    }
    function get_received_qty($stockroom_id)
    {
        $this->db->select_sum('item_qty');
        $this->db->from('bud_general_transfer_items');
        if(!empty($stockroom_id))
        {
            $this->db->where('stock_room', $stockroom_id);            }
        $query = $this->db->get();
        return $query->row()->item_qty;
    }
    function GenStockRegister()
    {
        $this->db->select('bud_general_items.*,SUM(inward_tbl.`item_qty`) as total_qty,SUM(consumption_tbl.`item_qty`) as total_used')
                 ->from('bud_general_items')
                 ->join('bud_material_inward inward_tbl', 'inward_tbl.item_name=bud_general_items.item_id', 'left')
                 ->join('bud_general_mtrl_consumption consumption_tbl', 'consumption_tbl.item_name=bud_general_items.item_id', 'left')
                 ->where('bud_general_items.is_active', 1)
                 ->group_by('bud_general_items.item_id');
        $query = $this -> db -> get();
        return $query->result_array();
    }
    function GenStockLog($item_id)
    {
        $this->db->select('bud_material_inward_log.*,bud_stock_rooms.stock_room_name,bud_concern_master.concern_name')
                 ->from('bud_material_inward_log')
                 ->join('bud_stock_rooms', 'bud_stock_rooms.stock_room_id=bud_material_inward_log.stockroom_id', 'left')
                 ->join('bud_concern_master', 'bud_concern_master.concern_id=bud_material_inward_log.concern_id', 'left')
                 ->where('bud_material_inward_log.item_id', $item_id)
                 ->group_by('bud_material_inward_log.id');
        $query = $this -> db -> get();
        return $query->result_array();
    }
    function materialComcemptionList()
    {
        $this->db->select('bud_general_mtrl_consumption.*,bud_general_items.item_name as consomp_item_name,bud_te_machines.machine_name,bud_uoms.uom_name,bud_concern_master.concern_name,inward_staff_tbl.user_login as inward_staff,custody_staff_tbl.user_login as custody_staff')
                 ->from('bud_general_mtrl_consumption')
                 ->join('bud_general_items', 'bud_general_items.item_id=bud_general_mtrl_consumption.item_name', 'left')
                 ->join('bud_concern_master', 'bud_concern_master.concern_id=bud_general_mtrl_consumption.concern_name', 'left')
                 ->join('bud_te_machines', 'bud_te_machines.machine_id=bud_general_mtrl_consumption.machines', 'left')
                 ->join('bud_uoms', 'bud_uoms.uom_id=bud_general_mtrl_consumption.item_uom', 'left')
                 ->join('bud_users inward_staff_tbl', 'inward_staff_tbl.ID=bud_general_mtrl_consumption.prepared_by', 'left')
                 ->join('bud_users custody_staff_tbl', 'custody_staff_tbl.ID=bud_general_mtrl_consumption.given_to', 'left')
                 ->group_by('bud_general_mtrl_consumption.id')
                 ->order_by('bud_general_mtrl_consumption.id', 'desc');
        $query = $this -> db -> get();
        return $query->result_array();
    }
    function materialInwarsList()
    {
        $this->db->select('bud_material_inward.*,bud_general_items.item_name,bud_general_customers.company_name,bud_uoms.uom_name,bud_stock_rooms.stock_room_name,bud_concern_master.concern_name,inward_staff_tbl.user_login as inward_staff,custody_staff_tbl.user_login as custody_staff')
                 ->from('bud_material_inward')
                 ->join('bud_general_items', 'bud_general_items.item_id=bud_material_inward.item_name')
                 ->join('bud_concern_master', 'bud_concern_master.concern_id=bud_material_inward.concern_name')
                 ->join('bud_general_customers', 'bud_general_customers.company_id=bud_material_inward.supplier')
                 ->join('bud_uoms', 'bud_uoms.uom_id=bud_material_inward.item_uom')
                 ->join('bud_users inward_staff_tbl', 'inward_staff_tbl.ID=bud_material_inward.prepared_by')
                 ->join('bud_users custody_staff_tbl', 'custody_staff_tbl.ID=bud_material_inward.given_to')
                 ->join('bud_stock_rooms', 'bud_stock_rooms.stock_room_id=bud_material_inward.stock_room', 'left')
                 ->order_by('bud_material_inward.inward_date', 'desc');
        $query = $this -> db -> get();
        return $query->result_array();
    }
    function getLblInvoices()
    {
        $this->db->select('bud_lbl_invoices.*,bud_concern_master.concern_name')
                 ->from('bud_lbl_invoices')
                 ->join('bud_concern_master', 'bud_concern_master.concern_id=bud_lbl_invoices.concern_name')
                 ->where('bud_lbl_invoices.is_cancelled', 0)
                 ->order_by('bud_lbl_invoices.invoice_id', 'desc');
        $query = $this -> db -> get();
        return $query->result_array();
    }
    function getGeneralDc()
    {
        $this->db->select('bud_general_deliveries.*,bud_concern_master.concern_name,bud_general_customers.company_name')
                 ->from('bud_general_deliveries')
                 ->join('bud_concern_master', 'bud_concern_master.concern_id=bud_general_deliveries.dc_from')
                 ->join('bud_general_customers', 'bud_general_customers.company_id=bud_general_deliveries.dc_to')
                 ->order_by('bud_general_deliveries.dc_date_time', 'desc');
        $query = $this -> db -> get();
        return $query->result_array();
    }
    function getGeneralDcReceived($dc_no)
    {
        $this->db->select('SUM(`received_qty`) as totalreceived')
                 ->from('bud_general_delivery_inward')
                 ->where('dc_no', $dc_no);
         $query = $this -> db -> get();
        $row = $query->row(); 
        return $row->totalreceived;
    }
    function pendingDcCount()
    {
        $this->db->select('count(*) as total_peding');
        $this->db->from('bud_general_stock_transfer');
        $this->db->where('bud_general_stock_transfer.status', 1);
        if($this->session->userdata('user_id') != 1)
        {
            $this->db->where('bud_general_stock_transfer.staff_name', $this->session->userdata('user_id'));
        }
        $query = $this -> db -> get();
        $row = $query->row(); 
        return $row->total_peding;
    }
    function pendingTransferDc()
    {
        $this->db->select('bud_general_stock_transfer.*,from_concern.concern_name as from_concern,to_concern.concern_name as to_concern,from_staff.display_name as from_staff_name,to_staff.display_name as to_staff_name');
        $this->db->from('bud_general_stock_transfer');
        $this->db->join('bud_concern_master from_concern', 'from_concern.concern_id=bud_general_stock_transfer.transfer_from');
        $this->db->join('bud_concern_master to_concern', 'to_concern.concern_id=bud_general_stock_transfer.transfer_to');
        $this->db->join('bud_users from_staff', 'from_staff.ID=bud_general_stock_transfer.transfer_by');
        $this->db->join('bud_users to_staff', 'to_staff.ID=bud_general_stock_transfer.staff_name');
        // $this->db->where('bud_general_stock_transfer.status', 1);
        if($this->session->userdata('user_id') != 1)
        {
            $this->db->where('bud_general_stock_transfer.transfer_by', $this->session->userdata('user_id'));
            $this->db->or_where('bud_general_stock_transfer.staff_name', $this->session->userdata('user_id'));            }
        $this->db->order_by('bud_general_stock_transfer.transfer_id', 'desc');
        $query = $this -> db -> get();
        return $query->result_array();
    }
    function getstockTransDc($from_concern, $to_concern)
    {
        $this->db->select('bud_general_stock_transfer.*,from_concern.concern_name as from_concern,to_concern.concern_name as to_concern,from_staff.display_name as from_staff_name,to_staff.display_name as to_staff_name,bud_general_transfer_items.*,bud_general_items.item_name,bud_uoms.uom_name');
        $this->db->from('bud_general_stock_transfer');
        $this->db->join('bud_concern_master from_concern', 'from_concern.concern_id=bud_general_stock_transfer.transfer_from');
        $this->db->join('bud_concern_master to_concern', 'to_concern.concern_id=bud_general_stock_transfer.transfer_to');
        $this->db->join('bud_users from_staff', 'from_staff.ID=bud_general_stock_transfer.transfer_by');
        $this->db->join('bud_users to_staff', 'to_staff.ID=bud_general_stock_transfer.staff_name');
        $this->db->join('bud_general_transfer_items', 'bud_general_transfer_items.transfer_id=bud_general_stock_transfer.transfer_id');
        $this->db->join('bud_general_items', 'bud_general_items.item_id=bud_general_transfer_items.item_id');
        $this->db->join('bud_uoms', 'bud_uoms.uom_id=bud_general_transfer_items.item_uom');
        // $this->db->where('bud_general_stock_transfer.status', 1);
        $this->db->where('bud_general_stock_transfer.transfer_from', $from_concern);
        $this->db->where('bud_general_stock_transfer.transfer_to', $to_concern);
        if($this->session->userdata('user_id') != 1)
        {
            $this->db->where('bud_general_stock_transfer.transfer_by', $this->session->userdata('user_id'));
            $this->db->or_where('bud_general_stock_transfer.staff_name', $this->session->userdata('user_id'));            }
        $this->db->order_by('bud_general_stock_transfer.transfer_id', 'desc');
        $query = $this -> db -> get();
        return $query->result_array();
    }
    function getstockTransDcdetails($transfer_id)
    {
        $this->db->select('bud_general_stock_transfer.*,from_concern.concern_name as from_concern,to_concern.concern_name as to_concern,from_staff.display_name as from_staff_name,to_staff.display_name as to_staff_name,bud_general_transfer_items.*,bud_general_items.item_name,bud_uoms.uom_name');
        $this->db->from('bud_general_stock_transfer');
        $this->db->join('bud_concern_master from_concern', 'from_concern.concern_id=bud_general_stock_transfer.transfer_from');
        $this->db->join('bud_concern_master to_concern', 'to_concern.concern_id=bud_general_stock_transfer.transfer_to');
        $this->db->join('bud_users from_staff', 'from_staff.ID=bud_general_stock_transfer.transfer_by');
        $this->db->join('bud_users to_staff', 'to_staff.ID=bud_general_stock_transfer.staff_name');
        $this->db->join('bud_general_transfer_items', 'bud_general_transfer_items.transfer_id=bud_general_stock_transfer.transfer_id');
        $this->db->join('bud_general_items', 'bud_general_items.item_id=bud_general_transfer_items.item_id');
        $this->db->join('bud_uoms', 'bud_uoms.uom_id=bud_general_transfer_items.item_uom');
        // $this->db->where('bud_general_stock_transfer.status', 1);
        /*if($this->session->userdata('user_id') != 1)
        {
            $this->db->where('bud_general_stock_transfer.transfer_by', $this->session->userdata('user_id'));
            $this->db->or_where('bud_general_stock_transfer.staff_name', $this->session->userdata('user_id'));            }*/
        $this->db->where('bud_general_stock_transfer.transfer_id', $transfer_id);
        $this->db->order_by('bud_general_stock_transfer.transfer_id', 'desc');
        $this->db->group_by('bud_general_stock_transfer.transfer_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_pending_gen_inw_qty()
    {
        // $where = "SUM(IF(in_or_out = 0, item_qty, 0)) as tot_delivery, SUM(IF(in_or_out = 1, item_qty, 0)) as tot_inward"; 
        // $this->db->select('SUM(IF(in_or_out = 0, item_qty, 0)) as tot_delivery');
        // $this->db->select('SUM(IF(in_or_out = 1, item_qty, 0)) as tot_inward');
        // $this->db->select($where, null, false);
        // $this->db->select("SUM(IF(in_or_out = '0', item_qty, 0)) as tot_delivery");
        // return $this->db->get('bud_general_dc_returnable_items')->row();
        // $this->db->group_by('item_id');
        // $query = $this->db->query("select SUM(IF(in_or_out = '0', item_qty, 0)) as tot_delivery from bud_general_dc_returnable_items");
        // return $this->db->get('bud_general_dc_returnable_items')->result();
        // return $query->result();
    }

    public function get_iowe_you_voucher($iou_voucher_no='')
    {
        $this->db->select('bud_general_iou.*');
        $this->db->select('bud_concern_master.*');
        $this->db->select('bud_users.user_nicename');
        $this->db->join('bud_concern_master', 'bud_general_iou.concern_name=bud_concern_master.concern_id');
        $this->db->join('bud_users', 'bud_general_iou.given_from=bud_users.ID');
        $this->db->where('iou_voucher_no', $iou_voucher_no);
        $result = $this->db->get('bud_general_iou');
        return $result->row();
    }
    public function get_ioweu_items($iou_voucher_id='')
    {
        $this->db->where('iou_voucher_id', $iou_voucher_id);
        $result = $this->db->get('bud_general_iou_items');
        return $result->result();
    }
}
