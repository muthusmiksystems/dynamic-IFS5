<?php
class M_purchase extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    function saveDatas($tablename, $data)
    {
        $this->db->insert($tablename, $data);
        return $this->db->insert_id();
    }
    function updateDatas($tablename, $enq_id_column, $id, $data)
    {
        $this->db->where($enq_id_column, $id);
        $this->db->update($tablename, $data);
        return true;
    }
    function deteteDatas($tablename, $dept_id)
    {
        $this->db->delete($tablename, array('dept_id' => $dept_id));
        return true;
    }
    function getActivetableDatas($tablename, $status)
    {
        $this->db->select('*')
            ->from($tablename)
            ->where($status, 1);
        $query = $this->db->get();
        return $query->result_array();
    }
    function getDatas($tablename, $column_id, $id)
    {
        $this->db->select('*')
            ->from($tablename)
            ->where($column_id, $id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function saveenquiry($data)
    {
        $this->db->insert('bud_enquiries', $data);
        return $this->db->insert_id();
    }
    function saveenquiryItem($data)
    {
        $this->db->insert('bud_enquiry_items', $data);
        return true;
    }
    function getactiveenquiries()
    {
        $this->db->select('*')
            ->from('bud_enquiries')
            ->where('enq_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }
    function getenquiry($enq_id)
    {
        $this->db->select('*')
            ->from('bud_enquiries')
            ->where('enq_id', $enq_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function getenquiryitems($enq_id)
    {
        $this->db->select('*')
            ->from('bud_enquiry_items')
            ->where('enq_ref_id', $enq_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function getenquiryActiveitems($enq_id)
    {
        $this->db->select('*')
            ->from('bud_enquiry_items')
            ->where('enq_ref_id', $enq_id)
            ->where('enq_production_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }
    function updatecartItem($enq_item_id, $data)
    {
        $this->db->where('enq_item_id', $enq_item_id);
        $this->db->update('bud_enquiry_items', $data);
        return true;
    }
    function getactivequotations()
    {
        $this->db->select('*')
            ->from('bud_quotations')
            ->where('quote_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    function getactiveTaxs($tax_category)
    {
        $this->db->select('*')
            ->from('bud_tax')
            ->where('tax_category', $tax_category)
            ->where('tax_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    function getactiveOthercharges($tothercharge_category)
    {
        $this->db->select('*')
            ->from('bud_othercharges')
            ->where('othercharge_category', $tothercharge_category)
            ->where('othercharge_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    function getadditions($category)
    {
        $this->db->select('*')
            ->from('bud_othercharges')
            ->where('othercharge_category', $category)
            ->where('othercharge_type', '+')
            ->where('othercharge_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }
    function getDuductions($category)
    {
        $this->db->select('*')
            ->from('bud_othercharges')
            ->where('othercharge_category', $category)
            ->where('othercharge_type', '-')
            ->where('othercharge_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }
    function getOrderTotalQty($enq_ref_id)
    {
        $this->db->select('SUM(enq_required_qty) as total_Qty', FALSE)
            ->from('bud_enquiry_items')
            ->where('enq_ref_id', $enq_ref_id);
        $query = $this->db->get();
        $row = $query->row();
        return $row->total_Qty;
    }
    function getJobTotalQty($enq_ref_id)
    {
        $this->db->select('SUM(enq_required_qty) as total_Qty', FALSE)
            ->from('bud_joborder_items')
            ->where('enq_ref_id', $enq_ref_id);
        $query = $this->db->get();
        $row = $query->row();
        return $row->total_Qty;
    }
    function getOrderDeliveryQty($enq_ref_id)
    {
        $this->db->select('SUM(enq_delivery_qty) as total_Qty', FALSE)
            ->from('bud_enquiry_items')
            ->where('enq_ref_id', $enq_ref_id);
        $query = $this->db->get();
        $row = $query->row();
        return $row->total_Qty;
    }

    function getActiveOrders($customer_id)
    {
        $this->db->select('*')
            ->from('bud_orders')
            ->where('order_supplier', $customer_id)
            ->where('order_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_total_Qty($tablename, $column_id, $column_name, $id)
    {
        $this->db->select('SUM(' . $column_name . ') as total_Qty', FALSE)
            ->from($tablename)
            ->where($column_id, $id);
        $query = $this->db->get();
        $row = $query->row();
        return $row->total_Qty;
    }
    function getLabelPo($po_completed = 0)
    {
        $this->db->select('bud_lbl_po_received.*,bud_customers.cust_name,bud_lbl_items.item_name,bud_lbl_items.item_sizes');
        $this->db->from('bud_lbl_po_received');
        $this->db->join('bud_customers', 'bud_customers.cust_id = bud_lbl_po_received.customer_id');
        $this->db->join('bud_lbl_items', 'bud_lbl_items.item_id = bud_lbl_po_received.item_code');
        $this->db->where('po_completed', $po_completed);
        $this->db->order_by('po_no', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_po_lbl($po_no)
    {
        return $this->db->get_where('bud_lbl_po_received', array('po_no' => $po_no))->row();
    }

    function get_dyes_chem_inward($inward_no)
    {
        return $this->db->get_where('bud_dyes_chem_inward', array('inward_no' => $inward_no))->row();
    }
    function get_dyes_chem($dyes_chem_family)
    {
        $this->db->where('dyes_chem_family', $dyes_chem_family);
        return $this->db->get('bud_dyes_chemicals')->result();
    }
    function save_dyes_chem($save)
    {
        if ($save['inward_no']) {
            $this->db->where('inward_no', $save['inward_no']);
            $this->db->update('bud_dyes_chem_inward', $save);
            return $save['inward_no'];
        } else {
            $this->db->insert('bud_dyes_chem_inward', $save);
            return $this->db->insert_id();
        }
    }

    function get_dyes_chem_inw_qty($dyes_chem_id)
    {
        $this->db->select('SUM(qty_received) as tot_inward_qty');
        $this->db->where('dyes_chem_id', $dyes_chem_id);
        $result = $this->db->get('bud_dyes_chem_inward')->row();
        if ($result->tot_inward_qty > 0) {
            return $result->tot_inward_qty;
        } else {
            return 0;
        }
    }

    function get_dyes_chem_reg()
    {
        $this->db->join('bud_suppliers', 'bud_dyes_chem_inward.sup_id = bud_suppliers.sup_id');
        $this->db->join('bud_dyes_chemicals', 'bud_dyes_chem_inward.dyes_chem_id = bud_dyes_chemicals.dyes_chem_id');
        $this->db->join('bud_uoms', 'bud_dyes_chem_inward.uom_id = bud_uoms.uom_id');
        return $this->db->get('bud_dyes_chem_inward')->result();
    }

    function get_dlc_packing($id)
    {
        return $this->db->get_where('bud_dlc_packings', array('id' => $id))->row();
    }

    function get_dlc_packing_items($id)
    {
        $this->db->select('bud_dlc_packing_items.*');
        $this->db->select('bud_lots.*');
        $this->db->join('bud_lots', 'bud_dlc_packing_items.lot_id = bud_lots.lot_id');
        $this->db->select('bud_items.item_name');
        $this->db->select('bud_shades.shade_name,bud_shades.shade_code');
        $this->db->join('bud_items', 'bud_lots.lot_item_id = bud_items.item_id', 'left');
        $this->db->join('bud_shades', 'bud_lots.lot_shade_no = bud_shades.shade_id', 'left');
        $this->db->where('bud_dlc_packing_items.id', $id);
        return $this->db->get('bud_dlc_packing_items')->result();
    }

    function get_dlc_lot_qty($lot_id)
    {
        //$this->db->join('bud_lots', 'bud_dlc_packing_items.lot_id = bud_lots.lot_id');
        $this->db->where('bud_dlc_packing_items.lot_id', $lot_id);
        return $this->db->get('bud_dlc_packing_items')->result();
    }

    function get_dlc_packing_reg()
    {
        return $this->db->get('bud_dlc_packings')->result();
    }

    function save_dlc_packing($save, $packing_items = false)
    {
        if ($save['id']) {
            $this->db->where('id', $save['id']);
            $this->db->update('bud_dlc_packings', $save);

            $id = $save['id'];
        } else {
            $this->db->insert('bud_dlc_packings', $save);
            $id = $this->db->insert_id();
        }
        if ($packing_items != false) {
            if ($save['id']) {
                foreach ($packing_items as $item) {
                    $item['id'] = $id;
                    $this->db->delete('bud_dlc_packing_items', array('id' => $id, 'lot_id' => $item['lot_id']));
                    $this->db->insert('bud_dlc_packing_items', $item);
                }
            } else {
                foreach ($packing_items as $item) {
                    $item['id'] = $id;
                    $this->db->insert('bud_dlc_packing_items', $item);
                }
            }
        }
        return $id;
    }

    function get_dlc_packing_item_reg($id)
    {
        $this->db->join('bud_lots', 'bud_dlc_packing_items.lot_id = bud_lots.lot_id');
        $this->db->join('bud_shades', 'bud_lots.lot_shade_no = bud_shades.shade_id');
        $this->db->join('ak_po_from_customers', 'bud_lots.po_no = ak_po_from_customers.R_po_no', 'left');
        $this->db->join('bud_customers', 'ak_po_from_customers.bud_customers = bud_customers.cust_id', 'left');
        $this->db->join('bud_items', 'bud_lots.lot_item_id = bud_items.item_id', 'left');
        $this->db->where('bud_dlc_packing_items.id', $id);
        return $this->db->get('bud_dlc_packing_items')->result();
    }

    function get_dlc_packing_details($id)
    {
        $this->db->select('bud_dlc_packings.*, from_staff.display_name as from_user_name,to_staff.display_name as to_user_name,from_dept.dept_name as from_dept_name,to_dept.dept_name as to_dept_name');
        $this->db->join('bud_users from_staff', 'bud_dlc_packings.from_user_id = from_staff.ID');
        $this->db->join('bud_users to_staff', 'bud_dlc_packings.to_user_id = to_staff.ID');
        $this->db->join('bud_yt_departments from_dept', 'bud_dlc_packings.from_dept_id = from_dept.dept_id');
        $this->db->join('bud_yt_departments to_dept', 'bud_dlc_packings.to_dept_id = to_dept.dept_id');
        $this->db->where('bud_dlc_packings.id', $id);
        return $this->db->get('bud_dlc_packings')->row();
    }
    function update_outerbox_item($box_id, $item_id, $item_size, $data)
    {
        $this->db->where('box_no', $box_id);
        $this->db->where('item_id', $item_id);
        $this->db->where('item_size', $item_size);
        $this->db->update('bud_lbl_outerbox_items', $data);
        return true;
    }
    //lbl PO & PS
    function getpolist($row_id = null, $item_id = null, $item_width = null, $cust_id = null, $sap_po_no = null)
    {
        $this->db->select('bud_lbl_po.*,bud_lbl_po_item.*,bud_customers.cust_name,bud_lbl_items.item_name,bud_lbl_items.item_width,bud_lbl_items.item_width,bud_uoms.uom_name as uom');
        if ($row_id) {
            $this->db->where('row_id', $row_id);
        }
        if ($item_id) {
            $this->db->where('po_item_id', $item_id);
        }
        if ($item_width) {
            $this->db->where('item_width', $item_width);
        }
        if ($cust_id) {
            $this->db->where('bud_lbl_po.cust_id', $cust_id);
        }
        if ($sap_po_no) {
            $this->db->where('erp_po_no', $sap_po_no);
        }
        $this->db->where('bud_lbl_po.po_is_deleted', 1);
        $this->db->where('bud_lbl_po_item.po_is_deleted', 1);
        $this->db->join('bud_lbl_items', 'bud_lbl_items.item_id = bud_lbl_po_item.po_item_id');
        $this->db->join('bud_lbl_po', 'bud_lbl_po_item.erp_po_no = bud_lbl_po.erp_po_id');
        $this->db->join('bud_customers', 'bud_customers.cust_id = bud_lbl_po.cust_id');
        $this->db->join('bud_uoms', 'bud_uoms.uom_id = bud_lbl_po_item.po_item_uom');
        return $this->db->get('bud_lbl_po_item')->result_array();
    }
    function getTotPSQty($erp_po_no = null, $item_id = null, $item_size = null, $colum_name = null)
    {
        $this->db->select('SUM(' . $colum_name . ') as total_Qty', FALSE)
            ->from('bud_lbl_ps_items')
            ->join('bud_lbl_ps', 'bud_lbl_ps.ps_id = bud_lbl_ps_items.ps_id');
        if ($erp_po_no) {
            $this->db->where('erp_po_no', $erp_po_no);
        }
        if ($item_id) {
            $this->db->where('ps_item_id', $item_id);
        }
        if ($item_size) {
            $this->db->where('ps_item_size', $item_size);
        }
        $this->db->where('bud_lbl_ps.ps_is_deleted', 1);
        $this->db->where('bud_lbl_ps_items.ps_is_deleted', 1);
        $query = $this->db->get();
        $row = $query->row();
        return $row->total_Qty;
    }
    function getPsDetails($ps_id = null, $from_date = null, $to_date = null, $item_id = null, $machine_id = null)
    {
        $this->db->select('bud_lbl_ps.*,bud_lbl_items.*, bud_te_machines.*')
            ->from('bud_lbl_ps')
            ->join('bud_lbl_items', 'bud_lbl_items.item_id = bud_lbl_ps.ps_item_id')
            ->join('bud_te_machines', 'bud_te_machines.machine_id = bud_lbl_ps.ps_machine_id')
            ->order_by('ps_id', 'desc')
            ->where('bud_lbl_ps.ps_is_deleted', 1);
        if ($ps_id) {
            $this->db->where('ps_id', $ps_id);
        }
        if ($item_id) {
            $this->db->where('ps_item_id', $item_id);
        }
        if ($machine_id) {
            $this->db->where('ps_machine_id', $machine_id);
        }
        if ($from_date) {
            $this->db->where('ps_date >=', $from_date);
        }
        if ($to_date) {
            $this->db->where('ps_date <=', $to_date);
        }
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_ps_items($ps_id = null, $cust_id = null, $sap_po_no = null)
    {
        $this->db->select('bud_lbl_ps_items.*,bud_lbl_po.*,bud_customers.cust_name')
            ->from('bud_lbl_ps_items')
            ->join('bud_lbl_po', 'bud_lbl_po.erp_po_id = bud_lbl_ps_items.erp_po_no')
            ->join('bud_customers', 'bud_customers.cust_id = bud_lbl_po.cust_id')
            ->where('bud_lbl_ps_items.ps_is_deleted', 1)
            ->order_by('ps_id', 'desc');
        if ($ps_id) {
            $this->db->where('ps_id', $ps_id);
        }
        if ($cust_id) {
            $this->db->where('bud_lbl_po.cust_id', $cust_id);
        }
        if ($sap_po_no) {
            $this->db->where('bud_lbl_po.erp_po_id', $sap_po_no);
        }
        $query = $this->db->get();
        return $query->result_array();
    }
    function getPoDetails($from_date = null, $to_date = null, $cust_id = null, $sap_po_no = null)
    {
        $this->db->select('bud_lbl_po.*,bud_customers.cust_name,bud_users.display_name');
        if ($from_date) {
            $this->db->where('po_date >=', $from_date);
        }
        if ($to_date) {
            $this->db->where('po_date <=', $to_date);
        }
        if ($cust_id) {
            $this->db->where('bud_lbl_po.cust_id', $cust_id);
        }
        if ($sap_po_no) {
            $this->db->where('bud_lbl_po.erp_po_id', $sap_po_no);
        }
        $this->db->where('bud_lbl_po.po_is_deleted', 1);
        $this->db->join('bud_customers', 'bud_customers.cust_id = bud_lbl_po.cust_id');
        $this->db->join('bud_users', 'bud_users.ID = bud_lbl_po.po_entered_by');
        return $this->db->get('bud_lbl_po')->result_array();
    }
    function getGroupFieldInOneVar($table_name = null, $filter_name = null, $filter_value = null, $data_field_name, $status_field)
    {
        $this->db->select($table_name . '.' . $data_field_name);
        if ($filter_value) {
            $this->db->where($filter_name, $filter_value);
        }
        $this->db->where($status_field, 1);
        $result = $this->db->get($table_name)->result_array();
        $data_field = array();
        foreach ($result as $result_data) {
            $data_field[$result_data[$data_field_name]] = $result_data[$data_field_name];
        }
        return implode(',', $data_field);
    }
    function checkItem($table_name = null, $condition)
    {
        $this->db->select($table_name . '.*');
        if ($condition) {
            $this->db->where($condition);
        }
        $result = $this->db->get($table_name)->result_array();
        return ($result) ? true : false;
    }
    //end  of lbl PO & PS
}
