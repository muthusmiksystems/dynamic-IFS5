<?php
class M_masters extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    public function save_shades($save)
    {
        if ($save['shade_id']) {
            $this->db->where('shade_id', $save['shade_id']);
            $this->db->update('bud_shades', $save);
            return $save['shade_id'];
        } else {
            $this->db->insert('bud_shades', $save);
            return $this->db->insert_id();
        }
    }
    public function save_color_category($save)
    {
        if ($save['category_id']) {
            $this->db->where('category_id', $save['category_id']);
            $this->db->update('bud_color_category', $save);
            return $save['category_id'];
        } else {
            $this->db->insert('bud_color_category', $save);
            return $this->db->insert_id();
        }
    }

    public function save_category_master($save)
    {
        if ($save['category_id']) {
            $this->db->where('category_id', $save['category_id']);
            $this->db->update('bud_category_master', $save);
            return $save['category_id'];
        } else {
            $this->db->insert('bud_category_master', $save);
            return $this->db->insert_id();
        }
    }

    function check_shade_code($str, $shade_id = false)
    {
        $this->db->select('shade_code');
        $this->db->from('bud_shades');
        $this->db->where('shade_code', $str);
        if ($shade_id) {
            $this->db->where('shade_id !=', $shade_id);
        }
        $count = $this->db->count_all_results();

        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
    function get_yt_shade($shade_id)
    {
        return $this->db->get_where('bud_shades', array('shade_id' => $shade_id))->row();
    }
    function savecategory($data)
    {
        $this->db->insert('bud_categories', $data);
        return true;
    }
    function getallcategories()
    {
        $this->db->select('*')
            ->from('bud_categories');
        // ->where('category_id', 1);
        $query = $this->db->get();
        return $query->result_array();
    }
    function getcategorydetails($category_id)
    {
        $this->db->select('*')
            ->from('bud_categories')
            ->where('category_id', $category_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function updatecategory($category_id, $data)
    {
        $this->db->where('category_id', $category_id);
        $this->db->update('bud_categories', $data);
        return true;
    }
    function deletecategory($category_id)
    {
        $this->db->where('category_id', $category_id);
        $this->db->delete('bud_categories');
        return true;
    }
    /* Start customers */
    function savecustomers($data)
    {
        $this->db->insert('bud_customers', $data);
        return true;
    }
    function getallcustomers()
    {
        $this->db->select('*')
            ->from('bud_customers');
        $query = $this->db->get();
        return $query->result_array();
    }
    function getcustomerdetails($cust_id)
    {
        $this->db->select('*')
            ->from('bud_customers')
            ->where('cust_id', $cust_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_customer($cust_id)
    {
        $this->db->select('*')
            ->from('bud_customers')
            ->where('cust_id', $cust_id);
        $query = $this->db->get();
        return $query->row();
    }
    function get_concern($concern_id)
    {
        $this->db->select('*')
            ->from('bud_concern_master')
            ->where('concern_id', $concern_id);
        $query = $this->db->get();
        return $query->row();
    }
    function updatecustomer($cust_id, $data)
    {
        $this->db->where('cust_id', $cust_id);
        $this->db->update('bud_customers', $data);
        return true;
    }
    function deletecustomer($cust_id)
    {
        $this->db->where('cust_id', $cust_id);
        $this->db->delete('bud_customers');
        return true;
    }
    /* End customers */

    /* Start supplier */
    function savesuppliers($data)
    {
        $this->db->insert('bud_suppliers', $data);
        return true;
    }
    function getallsuppliers($module = false)
    {
        $this->db->select('*')
            ->from('bud_suppliers');
        if ($module) {
            $this->db->where('module', $module);
        }
        $query = $this->db->get();
        return $query->result_array();
    }
    function getsupplierdetails($sup_id)
    {
        $this->db->select('*')
            ->from('bud_suppliers')
            ->where('sup_id', $sup_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function updatesupplier($sup_id, $data)
    {
        $this->db->where('sup_id', $sup_id);
        $this->db->update('bud_suppliers', $data);
        return true;
    }
    function deletesupplier($sup_id)
    {
        $this->db->where('sup_id', $sup_id);
        $this->db->delete('bud_suppliers');
        return true;
    }
    /* End supplier */

    /* Start General Form Action */
    function m_purchase($tablename, $data)
    {
        $this->db->insert($tablename, $data);
        return $this->db->insert_id();
    }
    function savemaster($tablename, $data)
    {
        $this->db->insert($tablename, $data);
        // return true;
        return $this->db->insert_id();
    }
    function getactivemaster($tablename, $status, $module = false)
    {
        $fields = '';
        $fields = $this->db->field_data($tablename);
        $field_name = $fields[0]->name;
        $this->db->select('*')
            ->from($tablename)
            ->where($status, 1)
            ->order_by($field_name, 'desc');
        if ($module) {
            $this->db->where('module', $module);
        }
        $query = $this->db->get();
        return $query->result_array();
    }
    function getactivemaster_limit($tablename, $status, $limit)
    {
        $fields = '';
        $fields = $this->db->field_data($tablename);
        $field_name = $fields[0]->name;
        $this->db->select('*')
            ->from($tablename)
            ->where($status, 1)
            ->order_by($field_name, 'desc')
            ->limit($limit);
        $query = $this->db->get();
        return $query->result_array();
    }
    function getallmaster($tablename, $module = false)
    {
        $fields = '';
        $fields = $this->db->field_data($tablename);
        $field_name = $fields[0]->name;
        $this->db->select('*')
            ->from($tablename)
            ->order_by($field_name, 'desc');
        if ($module) {
            $this->db->where('module', $module);
        }
        $query = $this->db->get();
        return $query->result_array();
    }
    function getallmcmasteractive($tablename)
    {
        $fields = '';
        $fields = $this->db->field_data($tablename);
        $field_name = $fields[0]->name;
        $this->db->select('*')
            ->from($tablename)
            ->where('machine_status', '1')
            ->order_by($field_name, 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }
    function getallitemmasteractive($tablename)
    {
        $fields = '';
        $fields = $this->db->field_data($tablename);
        $field_name = $fields[0]->name;
        $this->db->select('*')
            ->from($tablename)
            ->where('item_status', '1')
            ->order_by($field_name, 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }
    function getallmachinemasteractive($tablename)
    {
        $fields = '';
        $fields = $this->db->field_data($tablename);
        $field_name = $fields[0]->name;
        $this->db->select('*')
            ->from($tablename)
            ->where('machine_status', '1')
            ->order_by($field_name, 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }
    function getallmasteractive($tablename)
    {
        $fields = '';
        $fields = $this->db->field_data($tablename);
        $field_name = $fields[0]->name;
        $this->db->select('*')
            ->from($tablename)
            ->where('shade_status', '1')
            ->order_by($field_name, 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }
    function getallmasteractivecolumn($tablename, $activecolumn)
    {
        $this->db->select('*')
            ->from($tablename)
            ->where($activecolumn, '1');
        $query = $this->db->get();
        return $query->result_array();
    }
    function getcategoryallmaster($tablename, $column_category, $category_id)
    {
        $this->db->select('*')
            ->from($tablename)
            ->where($column_category, $category_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function getactiveCdatas($tablename, $status, $category_column, $category_id)
    {
        $this->db->select('*')
            ->from($tablename)
            ->where($category_column, $category_id)
            ->where($status, 1);
        $query = $this->db->get();
        return $query->result_array();
    }
    function getmasterdetails($tablename, $column_id, $master_id, $module = false)
    {
        $fields = '';
        $fields = $this->db->field_data($tablename);
        $field_name = $fields[0]->name;

        $this->db->select('*')
            ->from($tablename)
            ->where($column_id, $master_id)
            ->order_by($field_name, 'desc');
        if ($module) {
            $this->db->where('module', $module);
        }
        $query = $this->db->get();
        return $query->result_array();
    }
    function getmasterdetails2($tablename, $column_id, $master_id, $column_id2, $master_id2, $module = false)
    {
        $fields = '';
        $fields = $this->db->field_data($tablename);
        $field_name = $fields[0]->name;

        $this->db->select('*')
            ->from($tablename)
            ->where($column_id, $master_id)
            ->where($column_id2, $master_id2)
            ->order_by($field_name, 'desc');
        if ($module) {
            $this->db->where('module', $module);
        }
        $query = $this->db->get();
        return $query->result_array();
    }
    function getmasterdetailsactive($tablename, $column_id, $master_id)
    {
        $fields = '';
        $fields = $this->db->field_data($tablename);
        $field_name = $fields[0]->name;

        $this->db->select('*')
            ->from($tablename)
            ->where($column_id, $master_id)
            ->where('status', 1)
            ->order_by($field_name, 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    function getmasterdetailsconcernactive($tablename, $column_id, $master_id)
    {
        $fields = '';
        $fields = $this->db->field_data($tablename);
        $field_name = $fields[0]->name;

        $this->db->select('*')
            ->from($tablename)
            ->where($column_id, $master_id)
            ->where('concern_active', 1)
            ->order_by($field_name, 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    /* edit by legrand charles */
    function getmasterIDvalue_customer($tablename, $column_id, $master_id)
    {
        $fields = '';
        $fields = $this->db->field_data($tablename);
        $field_name = $fields[0]->name;

        $cust_tbl = "bud_customers.cust_id";

        $this->db->select('*')
            ->from($tablename)
            ->where($column_id, $master_id)
            ->join('bud_customers', "'" . $tablename . "." . $column_id . "=" . $cust_tbl, 'left')
            ->order_by($field_name, 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }
    function find_hsn($id)
    {
        $this->db->select('hsn_code')
            ->from('bud_te_items')
            ->where('item_id', $id);

        $query = $this->db->get();
        return $query->result_array();
    }
    function getcolorfamily($family_id)
    {
        $where = "FIND_IN_SET('" . $family_id . "', shade_family)";
        $this->db->select('*')
            ->from('bud_shades')
            ->where($where);
        $query = $this->db->get();
        return $query->result_array();
    }
    function updatemaster($tablename, $column_id, $master_id, $data)
    {
        $this->db->where($column_id, $master_id);
        $this->db->update($tablename, $data);
        return true;
    }
    function updatemaster2($tablename, $column_id, $master_id, $column_id2, $master_id2, $data)
    {
        $this->db->where($column_id, $master_id);
        $this->db->where($column_id2, $master_id2);
        $this->db->update($tablename, $data);
        return true;
    }
    function updatedisablemaster($tablename, $column_id, $master_id, $data)
    {
        $this->db->where($column_id, $master_id);
        $this->db->update($tablename, $data);
        return true;
    }
    function getmasterIDvalue($tablename, $column_id, $master_id, $column_name)
    {
        $this->db->select('*')
            ->from($tablename)
            ->where($column_id, $master_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->$column_name;
        }
    }
    function deletemaster($tablename, $column_id, $id)
    {
        $this->db->where($column_id, $id);
        $this->db->delete($tablename);
        return true;
    }

    function getall_datewise($tablename, $column_name, $fromdate, $todate)
    {
        $fields = '';
        $fields = $this->db->field_data($tablename);
        $field_name = $fields[0]->name;

        $this->db->select('*')
            ->from($tablename)
            ->where("$column_name BETWEEN '$fromdate' AND '$todate'")
            ->order_by($field_name, 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }
    function check_exist($tablename, $column_id, $master_id)
    {
        $this->db->select('*')
            ->from($tablename)
            ->where($column_id, $master_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function getTaxDesc($tax_name, $tax_value)
    {
        $this->db->select('*')
            ->from('bud_tax')
            ->where('tax_name', $tax_name)
            ->where('tax_value', $tax_value);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->tax_description;
        }
    }
    function getpoyDeniers($module = false)
    {
        $this->db->select('bud_yt_poydeniers.*,bud_suppliers.sup_name,bud_suppliers.sup_group,bud_yt_supplier_groups.group_name')
            ->from('bud_yt_poydeniers')
            ->join('bud_suppliers', 'bud_suppliers.sup_id=bud_yt_poydeniers.supplier_id', 'left')
            ->join('bud_yt_supplier_groups', 'bud_yt_supplier_groups.group_id=bud_yt_poydeniers.sup_group_id', 'left')
            ->order_by('denier_name', 'asc');
        if ($module) {
            $this->db->where('bud_yt_poydeniers.module', $module);
        }
        $query = $this->db->get();
        return $query->result_array();
    }


    /* legrand charles */
    function get_delivery_id_by_invoice($invoice_id)
    {
        $this->db->select('delivery_id')
            ->from('bud_yt_delivery')
            ->join('bud_yt_invoices', 'bud_yt_delivery.delivery_id = bud_yt_invoices.selected_dc')
            ->where('invoice_id', $invoice_id);
        $query = $this->db->get();
        return $query->row();
    }

    /* change delete status in label outer boxes */
    function update_delete_status_label($box_no, $remarks)
    {
        $data = array(
            'is_deleted' => 1,
            'deleted_by' => $this->session->userdata('user_id'),
            'deleted_time' => date('Y-m-d H:i:s'),
            'remark' => $remarks
        );
        $this->db->where('box_no', $box_no);
        return $this->db->update('bud_lbl_outerboxes', $data);
    }
    /* End of change delete status in label outer boxes */

    /* legrand charles */

    /* End General Form Action */

    // Recipe Master

    function get_recipe($recipe_id)
    {
        return $this->db->get_where('bud_recipe_master', array('recipe_id' => $recipe_id))->row();
    }
    function get_recipe_details($recipe_id)
    {
        $this->db->select('bud_recipe_master.*, bud_shades.shade_name,bud_shades.shade_code,');
        $this->db->join('bud_shades', 'bud_recipe_master.shade_id = bud_shades.shade_id');
        return $this->db->get_where('bud_recipe_master', array('recipe_id' => $recipe_id))->row();
    }
    function get_shade_recipe($shade_id)
    {
        $this->db->select('bud_recipe_master.*, bud_shades.shade_name,bud_shades.shade_code,');
        $this->db->join('bud_shades', 'bud_recipe_master.shade_id = bud_shades.shade_id');
        $this->db->order_by('recipe_id', 'desc');
        return $this->db->get_where('bud_recipe_master', array('bud_recipe_master.shade_id' => $shade_id))->row();
    }
    function save_recipe($recipe)
    {
        if ($recipe['recipe_id']) {
            $this->db->where('recipe_id', $recipe['recipe_id']);
            $this->db->update('bud_recipe_master', $recipe);
            return $recipe['recipe_id'];
        } else {
            $this->db->insert('bud_recipe_master', $recipe);
            return $this->db->insert_id();
        }
    }
    function get_recipe_list($family_id = false, $shade_id = false)
    {
        $this->db->select('bud_recipe_master.*, bud_shades.shade_name,bud_shades.shade_code,');
        $this->db->join('bud_shades', 'bud_recipe_master.shade_id = bud_shades.shade_id');

        if (!empty($family_id)) {
            $this->db->where('bud_recipe_master.family_id', $family_id);
        }
        if (!empty($shade_id)) {
            $this->db->where('bud_recipe_master.shade_id', $shade_id);
        }
        $this->db->order_by('recipe_id', 'desc');
        return $this->db->get('bud_recipe_master')->result();
    }
    function get_recipe_list_active($family_id = false, $shade_id = false)
    {
        $this->db->select('bud_recipe_master.*, bud_shades.shade_name,bud_shades.shade_code,');
        $this->db->join('bud_shades', 'bud_recipe_master.shade_id = bud_shades.shade_id');

        if (!empty($family_id)) {
            $this->db->where('bud_recipe_master.family_id', $family_id);
        }
        if (!empty($shade_id)) {
            $this->db->where('bud_recipe_master.shade_id', $shade_id);
        }
        $this->db->where('recipe_status', '1');
        $this->db->order_by('recipe_id', 'desc');
        return $this->db->get('bud_recipe_master')->result();
    }
    function delete_recipe($recipe_id)
    {
        $this->db->where('recipe_id', $recipe_id);
        $this->db->delete('bud_recipe_master');

        // delete children
        // $this->remove_product($id);
    }

    // Lot Master
    function get_lot($lot_id)
    {
        $this->db->select('bud_lots.*');
        $this->db->select('bud_items.item_name');
        $this->db->select('bud_shades.shade_name,bud_shades.shade_code');
        $this->db->join('bud_items', 'bud_lots.lot_item_id = bud_items.item_id', 'left');
        $this->db->join('bud_shades', 'bud_lots.lot_shade_no = bud_shades.shade_id', 'left');
        $this->db->where('lot_id', $lot_id);
        return $this->db->get('bud_lots')->row();
    }
    function save_lot($lot)
    {
        if ($lot['lot_id']) {
            $this->db->where('lot_id', $lot['lot_id']);
            $this->db->update('bud_lots', $lot);
            return $lot['lot_id'];
        } else {
            $this->db->insert('bud_lots', $lot);
            return $this->db->insert_id();
        }
    }

    function save_lot_for_add_qty($lot)
    {
       
            $this->db->insert('bud_lots', $lot);
            return $this->db->insert_id();
        
    }


    function get_lots($filter = array())
    {
        $this->db->select('bud_lots.*, bud_shades.shade_name,bud_shades.shade_code');
        $this->db->join('bud_shades', 'bud_lots.lot_shade_no = bud_shades.shade_id', 'left');
        if (count($filter) > 0) {
            if (isset($filter['exclude_direct_entry'])) {
                $this->db->where('bud_lots.direct_entry', 0);
            }
        }
        $this->db->group_by('bud_lots.lot_id');
        $this->db->order_by('lot_id', 'desc');
        return $this->db->get('bud_lots')->result();
    }

    function get_items($filter = array())
    {
        $this->db->order_by('item_name', 'asc');
        return $this->db->get('bud_items')->result();
    }
    function get_items_array($tablename, $module = false)
    {
        $this->db->order_by('item_id', 'desc');
        if ($module) {
            $this->db->where('module', $module);
        }
        return $this->db->get($tablename)->result_array();
    }

    function get_active_items_array()
    {
        $this->db->where('item_status', 1);
        $this->db->order_by('item_name', 'desc');
        return $this->db->get('bud_items')->result_array();
    }

    function get_shades($filter = array())
    {
        return $this->db->get('bud_shades')->result();
    }

    function get_users($filter = array())
    {
        return $this->db->get('bud_users')->result();
    }

    function get_uoms($filter = array())
    {
        return $this->db->get('bud_uoms')->result();
    }

    function get_lot_details($lot_id)
    {
        $this->db->select('bud_lots.*, bud_shades.shade_name,bud_shades.shade_code,bud_items.*');
        $this->db->select('ak_po_from_customers.bud_customers');
        $this->db->select('bud_customers.cust_name');
        $this->db->join('bud_items', 'bud_lots.lot_item_id = bud_items.item_id');
        $this->db->join('bud_shades', 'bud_lots.lot_shade_no = bud_shades.shade_id');
        $this->db->join('ak_po_from_customers', 'bud_lots.po_no = ak_po_from_customers.R_po_no', 'left');
        $this->db->join('bud_customers', 'ak_po_from_customers.bud_customers = bud_customers.cust_id', 'left');
        $this->db->where('bud_lots.lot_id', $lot_id);
        //$this->db->where('bud_lots.lot_id', $lot_id);
        return $this->db->get('bud_lots')->row();
    }

    function get_lot_customer($po_no)
    {
        $this->db->join('ak_po_from_customers', 'bud_lots.po_no = ak_po_from_customers.R_po_no');
        $this->db->join('bud_customers', 'ak_po_from_customers.bud_customers = bud_customers.cust_id');
        $this->db->where('bud_lots.po_no', $po_no);
        return $this->db->get('bud_lots')->row();
    }

    // Packed Qty Lotwise
    function get_lot_pack_qty($lot_no = false)
    {
        $lot_month = $this->getmasterIDvalue(' bud_lots', 'lot_id', $lot_no, 'lot_month'); ///tot direct lot qty correction
        $this->db->select('SUM(net_weight) as tot_packed_qty');
        if (!empty($lot_no)) {
           // $this->db->where('lot_month', $lot_month); ///tot direct lot qty correction
            $this->db->where('lot_no', $lot_no);
        }
        $this->db->where('is_deleted', 0);
        return $this->db->get('bud_yt_packing_boxes')->row();
    }
    // Packed Qty Inward No wise
    function get_inward_pack_qty($poy_inward_no = false)
    {
        // $this->db->select('SUM(net_weight) as tot_packed_qty, SUM(lot_wastage) as tot_wastage_qty');
        //echo $poy_inward_no;
        $poy_inward_prefix = $this->m_masters->getmasterIDvalue(' bud_yt_poy_inward', 'po_no', $poy_inward_no, 'poy_inward_prefix'); //tot pkd qty correction
        $this->db->select('SUM(net_weight - poy_inward_no_1_qty) as tot_packed_qty, SUM(lot_wastage) as tot_wastage_qty');
        $this->db->where('is_deleted', 0);
        if (!empty($poy_inward_no)) {
            $this->db->where('poy_inward_no', $poy_inward_no);
        }
        //tot pkd qty correction
        if (!empty($poy_inward_prefix)) {
            $this->db->where('poy_inward_prefix', $poy_inward_prefix);
        }
        //end of tot pkd qty correction
        $result = $this->db->get('bud_yt_packing_boxes')->row();
        if ($result) {
            $tot_packed_qty = $result->tot_packed_qty;
            $mixed_pack_qty = $this->get_mixed_pack_qty($poy_inward_no);
            $result->tot_packed_qty = $tot_packed_qty + $mixed_pack_qty;
        }
        return $result;
    }

    function get_mixed_pack_qty($poy_inward_no_2 = '')
    {
        $poy_inward_no_2_qty = 0;
        if (!empty($poy_inward_no_2)) {
            $this->db->select_sum('poy_inward_no_2_qty');
            $this->db->where('poy_inward_no_2', $poy_inward_no_2);
            $query = $this->db->get('bud_yt_packing_boxes');
            $result = $query->row();

            if ($result->poy_inward_no_2_qty > 0) {
                $poy_inward_no_2_qty =  $result->poy_inward_no_2_qty;
            }
        }
        return $poy_inward_no_2_qty;
        # code...poy_inward_no_2
    }

    // GET Shade
    function get_shade($shade_id)
    {
        return $this->db->get_where('bud_shades', array('shade_id' => $shade_id))->row();
    }
    function get_color_category($category_id)
    {
        return $this->db->get_where('bud_color_category', array('category_id' => $category_id))->row();
    }
    function get_color_categories()
    {
        return $this->db->get('bud_color_category')->result();
    }
    function get_category_master($category_id)
    {
        return $this->db->get_where('bud_category_master', array('category_id' => $category_id))->row();
    }
    function get_categories_master()
    {
        return $this->db->get('bud_category_master')->result();
    }
    function get_categories_master_active()
    {
        $this->db->where('category_active', '1');
        return $this->db->get('bud_category_master')->result();
    }
    function get_shade_list()
    {
        $this->db->select('bud_shades.*');
        $this->db->select('bud_users.user_login');
        $this->db->select('bud_color_category.color_category');
        $this->db->join('bud_color_category', 'bud_color_category.category_id=bud_shades.category_id', 'left');
        $this->db->join('bud_users', 'bud_users.ID=bud_shades.added_user');
        $this->db->order_by('bud_shades.shade_id', 'desc');
        return $this->db->get('bud_shades')->result();
    }
    // GET Denier
    function get_denier_lbl($denier_id)
    {
        return $this->db->get_where('bud_deniermaster', array('denier_id' => $denier_id))->row();
    }

    // Start Request Form
    function get_request_form($id)
    {
        return $this->db->get_where('bud_request_master', array('id' => $id))->row();
    }
    function get_request_forms()
    {
        return $this->db->get_where('bud_request_master')->result();
    }
    function save_request_form($save)
    {
        if ($save['id']) {
            $this->db->where('id', $save['id']);
            $this->db->update('bud_request_master', $save);
            return $lot['id'];
        } else {
            $this->db->insert('bud_request_master', $save);
            return $this->db->insert_id();
        }
    }
    function delete_request_form($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('bud_request_master');

        // delete children
        // $this->remove_product($id);
    }

    function get_mail_settings()
    {
        return $this->db->get_where('bud_mail_setting', array('id' => 1))->row();
    }
    public function get_item_groups()
    {
        $result = $this->db->get('bud_itemgroups');
        return $result->result();
    }
    //deletion of predelivery tapes
    public function update_delete_status_predelivery($p_delivery_id, $remarks)
    {
        $this->db->select('p_delivery_boxes');
        $this->db->from('bud_te_predelivery');
        $this->db->where('p_delivery_id', $p_delivery_id);
        $query = $this->db->get();
        $boxes = $query->result_array();
        $boxes_array = explode(',', $boxes[0]['p_delivery_boxes']);
        $result = 1;
        if ($result) {
            foreach ($boxes_array as $key => $value) {
                $data = array(
                    'predelivery_status' => '1'
                );
                $this->db->where('box_no', $value);
                $result = $this->db->update('bud_te_outerboxes', $data);
            }
        }
        if ($result) {
            $data = array(
                'p_delivery_is_deleted' => '0',
                'remarks' => $remarks,
                'p_delivery_lt_edtd_by' => $this->session->userdata('user_id'),
                'p_delivery_lt_edtd_time' => date('Y-m-d H:i:s')
            );
            $this->db->where('p_delivery_id', $p_delivery_id);
            $result = $this->db->update('bud_te_predelivery', $data);
        }
        if ($result) {
            $updateData = array(
                'is_deleted' => 0
            );
            $result = $this->m_purchase->updateDatas('bud_te_predelivery_items', 'p_delivery_id', $p_delivery_id, $updateData);
        }
        return $result;
    }
    function get_tapes_predc()
    {
        $this->db->select('*')
            ->from('bud_te_predelivery')
            ->where('p_delivery_status', 1)
            ->where('p_delivery_is_deleted', 1)
            ->order_by('p_delivery_id', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }
    //end of deletion of predelivery tapes
    //deletion of predelivery Label
    public function update_delete_status_predelivery_lbl($p_delivery_id, $remarks)
    {
        $this->db->select('p_delivery_boxes');
        $this->db->from('bud_lbl_predelivery');
        $this->db->where('p_delivery_id', $p_delivery_id);
        $query = $this->db->get();
        $boxes = $query->result_array();
        $boxes_array = explode(',', $boxes[0]['p_delivery_boxes']);
        $result = 1;
        if ($result) {
            foreach ($boxes_array as $key => $value) {
                $data = array(
                    'predelivery_status' => '1'
                );
                $this->db->where('box_no', $value);
                $result = $this->db->update('bud_lbl_outerboxes', $data);
            }
        }
        if ($result) {
            $data = array(
                'p_delivery_is_deleted' => '0',
                'p_delivery_lt_edtd_by' => $this->session->userdata('user_id'),
                'p_delivery_lt_edtd_time' => date('Y-m-d H:i:s'),
                'remarks' => $remarks
            );
            $this->db->where('p_delivery_id', $p_delivery_id);
            $result = $this->db->update('bud_lbl_predelivery', $data);
            $data = array(
                'p_delivery_is_deleted' => '0'
            );
            $this->db->where('p_delivery_id', $p_delivery_id);
            $result = $this->db->update('bud_lbl_predelivery_items', $data);
        }
        return $result;
    }
    function get_lbl_predc()
    {
        $this->db->select('*')
            ->from('bud_lbl_predelivery')
            ->where('p_delivery_status', 1)
            ->where('p_delivery_is_deleted', 1)
            ->order_by('p_delivery_id', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }
    //end of deletion of predelivery label
    //deletion of predelivery yt
    public function update_delete_status_predelivery_yt($p_delivery_id, $remarks = '')
    {
        $this->db->select('p_delivery_boxes');
        $this->db->from('bud_yt_predelivery');
        $this->db->where('p_delivery_id', $p_delivery_id);
        $query = $this->db->get();
        $boxes = $query->result_array();
        $boxes_array = explode(',', $boxes[0]['p_delivery_boxes']);
        $result = 1;
        if ($result) {
            foreach ($boxes_array as $key => $value) {
                $data = array(
                    'predelivery_status' => '1',
                    'delivery_status' => '1'
                );
                $this->db->where('box_id', $value);
                $result = $this->db->update('bud_yt_packing_boxes', $data);
            }
        }
        if ($result) {
            $data = array(
                'p_delivery_is_deleted' => '0',
                'p_delivery_lt_edtd_by' => $this->session->userdata('user_id'),
                'p_delivery_lt_edtd_time' => date('Y-m-d H:i:s'),
                'remarks' => $remarks
            );
            $this->db->where('p_delivery_id', $p_delivery_id);
            $result = $this->db->update('bud_yt_predelivery', $data);
        }
        return $result;
    }
    public function update_delete_status_delivery_yt($delivery_id, $remarks = '')
    {
        $this->db->select('delivery_boxes');
        $this->db->from('bud_yt_delivery');
        $this->db->where('delivery_id', $delivery_id);
        $query = $this->db->get();
        $boxes = $query->result_array();
        $boxes_array = explode(',', $boxes[0]['delivery_boxes']);
        $result = 1;
        if ($result) {
            foreach ($boxes_array as $key => $value) {
                $data = array(
                    'predelivery_status' => '1',
                    'delivery_status' => '1'
                );
                $this->db->where('box_id', $value);
                $result = $this->db->update('bud_yt_packing_boxes', $data);
            }
        }
        if ($result) {
            $data = array(
                'delivery_is_deleted' => '0',
                'delivery_lt_edtd_by' => $this->session->userdata('user_id'),
                'delivery_lt_edtd_time' => date('Y-m-d H:i:s'),
                'remarks' => $remarks
            );
            $this->db->where('delivery_id', $delivery_id);
            $result = $this->db->update('bud_yt_delivery', $data);
        }
        return $result;
    }
    function get_yt_predc()
    {
        $this->db->select('*')
            ->from('bud_yt_predelivery')
            ->where('p_delivery_status', 1)
            ->where('p_delivery_is_deleted', 1)
            ->order_by('p_delivery_id', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }
    //end of deletion of predelivery yt

    //to calculate total value of field
    function get_tot_field_value($tablename = null, $field_name = null, $condition = null)
    {
        $this->db->select_sum($field_name)
            ->from($tablename);
        if ($condition) { //ER-07-18#-24
            $this->db->where($condition);
        }
        $query = $this->db->get();
        $tot_array = $query->result_array();
        return $tot_array[0][$field_name];
    }
    function check_user_exist($cust_email)
    {
        $this->db->select("cust_email");
        $this->db->where("cust_email", $cust_email);
        $query = $this->db->get("bud_customers");
        if ($query->num_rows() > 0) {
            return $query->result_array()[0]["cust_email"];
        } else {
            return false;
        }
    }
    function getAllCustomersByUserId($user_id)
    {
        $this->db->select('*')
            ->from("bud_customers")
            ->where("find_in_set('" . $user_id . "', cust_agent) <> 0");
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_uom($table_name, $uom_id, $field)
    {
        $this->db->select($field)
            ->from($table_name)
            ->where('uom_id', $uom_id);
        
        $query = $this->db->get();
        $result = $query->row(); // Fetch a single row
        
        if ($result) {
            return $result->$field; // Return the value of the specified field
        }
        
        return null; // Return null if no result is found
    }
}
