<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ML_knitting extends CI_Model
{

    var $table = 'tbl_knitting_outward';

    var $column_order = array('tbl_knitting_outward.id');
    var $column_search = array('tbl_knitting_outward.company');

    var $order = array('tbl_knitting_outward.id' => 'desc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function get_datatables_query()
    {
        $this->db->select('tbl_knitting_outward.*,tbl_yarn.yarn_name,tbl_yarn.yarn_count,tbl_vendor.cname as company');
        $this->db->from($this->table);
        $this->db->join('tbl_yarn', 'tbl_yarn.id = tbl_knitting_outward.mat_name');
        $this->db->join('tbl_vendor', 'tbl_vendor.id = tbl_knitting_outward.company_name');
        $this->db->where('tbl_knitting_outward.is_active', 'Y');
        $this->db->where('tbl_knitting_outward.parent_id', $this->session->userdata('user_id'));
        $this->db->group_by('tbl_knitting_outward.id');
        $i = 0;

        foreach ($this->column_search as $item) // loop column 
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {

        $this->get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query =  $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        return $this->db->count_all_results();
    }

    public function load_outward($type)
    {

        $this->db->select('tbl_outward.*,tbl_group.*,tbl_yarn.yarn_name,tbl_yarn.yarn_count,tbl_vendor.cname as company,tbl_measure.name as type');
        $this->db->from('tbl_outward');
        $this->db->join('tbl_yarn', 'tbl_yarn.id = tbl_outward.mat_name');
        $this->db->join('tbl_group', 'tbl_group.id = tbl_yarn.group_id');
        $this->db->join('tbl_vendor', 'tbl_vendor.id = tbl_outward.company_name');
        $this->db->join('tbl_measure', 'tbl_measure.id = tbl_outward.umo');
        $this->db->where('tbl_outward.po_type', $type['type']);
        $this->db->where('tbl_outward.po_no', $type['po']);
        $this->db->where('tbl_outward.bill_no', $type['dc']);
        if ($type['mode'] == 1) {
            $this->db->where('tbl_outward.outward_type', 'Direct Inward');
        } else {
            $this->db->where('tbl_outward.recipe_code', $type['pt']);
        }
        $this->db->where('tbl_outward.job_type', '1');
        $this->db->where('tbl_outward.is_active', 'Y');
        //$this->db->where('tbl_outward.parent_id',$this->session->userdata('user_id'));

        $query = $this->db->get();
        return $query->result();
    }
    function get_no($id)
    {
        $this->db->select('count(id) as auto');
        $this->db->from('tbl_bill');
        $this->db->where('job_type', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function fab_content($type)
    {
        $this->db->select('tbl_outward.*,GROUP_CONCAT(tbl_content.name) as cname ');
        $this->db->from('tbl_outward');
        $this->db->join('tbl_content', 'find_in_set(tbl_content.id , tbl_outward.content)', 'left');
        $this->db->where('tbl_outward.po_type', $type['type']);
        $this->db->where('tbl_outward.po_no', $type['po']);
        $this->db->where('tbl_outward.fab_name', $type['title']);
        $this->db->where('tbl_outward.bill_no', $type['dc']);
        if ($type['r'] == 'NULL') {
            $this->db->where('tbl_outward.outward_type', $type['out']);
            $this->db->where('tbl_outward.recipe_code IS NULL');
        }
        if ($type['out'] == 'NULL') {
            $this->db->where('tbl_outward.recipe_code', $type['r']);
            $this->db->where('tbl_outward.outward_type IS NULL');
        }

        $this->db->where('tbl_outward.job_type', '1');
        $this->db->where('tbl_outward.mat_type', '2');
        $this->db->where('tbl_outward.is_active', 'Y');
        $this->db->group_by('tbl_outward.gsm');
        $this->db->group_by('tbl_outward.fab_name');
        $this->db->group_by('tbl_outward.content');
        $this->db->group_by('tbl_outward.dia');
        $this->db->group_by('tbl_outward.gauge');
        $this->db->order_by('tbl_outward.id', 'asc');

        $query = $this->db->get();
        return $query->result_array();
    }
    public function yarn_list()
    {
        $this->db->select('tbl_yarn.id,concat(tbl_yarn.yarn_name, " - ", tbl_yarn.yarn_count," Count  - ", tbl_color.cname," Color") as text');
        $this->db->from('tbl_stock');
        $this->db->join('tbl_yarn', 'tbl_yarn.id = tbl_stock.item_name');
        $this->db->join('tbl_color', 'tbl_color.id = tbl_yarn.yarn_color');
        $this->db->where('tbl_stock.item_type', '2');
        //$this->db->where($type);
        $this->db->group_by('tbl_stock.item_name');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function yarn_list_2($val)
    {
        if ($val == 2) {
            $this->db->select('tbl_yarn.id,concat(tbl_yarn.yarn_name, " - ", tbl_yarn.yarn_count," Count  - ", tbl_color.cname," Color") as text');
            $this->db->from('tbl_stock');
            $this->db->join('tbl_yarn', 'tbl_yarn.id = tbl_stock.item_name');
            $this->db->join('tbl_color', 'tbl_color.id = tbl_yarn.yarn_color');
            $this->db->where('tbl_stock.item_type', '2');

            $this->db->group_by('tbl_stock.item_name');
            $query = $this->db->get();
            return $query->result_array();
        } else if ($val == 1) {
            $this->db->select('tbl_fabric.id,concat(tbl_fab_name.name, " - ", tbl_fabric.fab_count," Count - ", tbl_color.cname," Color") as text');
            $this->db->from('tbl_stock');
            $this->db->join('tbl_fabric', 'tbl_fabric.id = tbl_stock.item_name');
            $this->db->join('tbl_fab_name', 'tbl_fab_name.id = tbl_fabric.fab_id');
            $this->db->join('tbl_color', 'tbl_color.id = tbl_fabric.fab_color');
            $this->db->where('tbl_stock.item_type', '1');
            $this->db->group_by('tbl_stock.item_name');
            $query = $this->db->get();
            return $query->result_array();
        } else {
            $this->db->select('id,concat(trim_name, " - ", trim_desc) as text');
            $this->db->from('tbl_trim');
            $this->db->where('is_active', 'Y');
            $query = $this->db->get();
            return $query->result_array();
        }
    }
    public function yarn_load($type)
    {
        $this->db->select('tbl_yarn.*,sum(tbl_stock.weight) as weight');
        $this->db->select('tbl_color.cname as color_name');
        $this->db->select('group_concat(tbl_content.name) as conname');
        $this->db->from('tbl_yarn');
        $this->db->join('tbl_stock', 'tbl_stock.item_name = tbl_yarn.id');
        $this->db->join('tbl_color', 'tbl_color.id = tbl_yarn.yarn_color');
        $this->db->join('tbl_content', 'find_in_set(tbl_content.id , tbl_yarn.yarn_content)', 'left');
        $this->db->where('tbl_yarn.id', $type['id']);
        /*
        $this->db->where('tbl_stock.po_type',$type['po_type']);
        $this->db->where('tbl_stock.po_no',$type['po']);}*/

        $this->db->where('tbl_stock.item_type', '2');
        $this->db->group_by('tbl_stock.item_name');
        $query = $this->db->get();
        return ($query->result_array());
    }
    public function yarn_load_2($id, $type)
    {

        if ($type == 1) {

            $this->db->select('tbl_fabric.*,sum(tbl_stock.weight) as weight');
            $this->db->select('tbl_color.cname as color_name');
            $this->db->from('tbl_stock');
            $this->db->join('tbl_fabric', 'tbl_fabric.id= tbl_stock.item_name');
            $this->db->join('tbl_color', 'tbl_color.id = tbl_fabric.fab_color');
            //$this->db->join('tbl_fab_name','tbl_fab_name.id = tbl_fabric.fab_id'); 	           $this->db->where('tbl_stock.item_name', $id);

            $this->db->where('tbl_stock.item_type', '1');
            $this->db->group_by('tbl_stock.item_name');
            $query = $this->db->get();
            return ($query->result_array());
        } else if ($type == 2) {
            $this->db->select('tbl_yarn.*,sum(tbl_stock.weight) as weight');
            $this->db->select('tbl_color.cname as color_name');
            $this->db->from('tbl_stock');
            $this->db->join('tbl_yarn', 'tbl_yarn.id= tbl_stock.item_name');
            $this->db->join('tbl_color', 'tbl_color.id = tbl_yarn.yarn_color');
            $this->db->where('tbl_stock.item_name', $id);

            $this->db->where('tbl_stock.item_type', '2');
            $this->db->group_by('tbl_stock.item_name');
            $query = $this->db->get();
            return ($query->result_array());
        } else {
            $this->db->select('sum(tbl_stock.weight) as weight');
            $this->db->select('tbl_trim.trim_name as yarn_name');
            $this->db->select('tbl_trim.trim_desc as color_name');
            $this->db->from('tbl_stock');
            $this->db->join('tbl_trim', 'tbl_trim.id= tbl_stock.item_name');
            $this->db->where('tbl_stock.item_name', $id);
            $this->db->where('tbl_stock.item_type', '3');
            $this->db->group_by('tbl_stock.item_name');
            $query = $this->db->get();
            return ($query->result_array());
        }
    }
    public function yarn_reduce($type)
    {
        $this->db->select('tbl_stock.*');
        $this->db->from('tbl_stock');
        $this->db->where('tbl_stock.item_type', '2');
        $this->db->where('tbl_stock.is_active', 'Y');
        $this->db->where('tbl_stock.item_name', $type['id']);

        $query = $this->db->get();
        return ($query->result_array());
    }
    public function total_recived($type)
    {
        $this->db->select('sum(d_weight) as total');
        $this->db->from('tbl_knitting_inward');
        $this->db->where($type);

        $query = $this->db->get();
        return ($query->result_array());
    }
    function total_amount_paid($id, $type, $po_type)
    {
        $this->db->select('sum(amount) as paid');
        $this->db->from('tbl_account');
        $this->db->where('dc_no', $id);
        $this->db->where('po_type', $po_type);
        $this->db->where('is_active', 'Y');
        $this->db->where('amount_type', $type);

        $query = $this->db->get();
        return ($query->result_array());
    }
    function bill_load($type)
    {
        $this->db->select('bill_no as id,bill_no as text');
        $this->db->from('tbl_knitting_outward');
        $this->db->where('tbl_knitting_outward.po_type', $type['type']);
        $this->db->group_by('bill_no');
        $query = $this->db->get();
        return $query->result_array();
    }
    function bill_load_2($type)
    {
        $this->db->select('bill_no as id,bill_no as text');
        $this->db->from('tbl_dyeing_outward');
        $this->db->where('tbl_dyeing_outward.po_type', $type['type']);
        $this->db->group_by('bill_no');
        $query = $this->db->get();
        return $query->result_array();
    }
    function chk_fab_content($tmp)
    {
        $this->db->select('id,fab_group,fab_dia,fab_gsm,fab_cauge');
        $this->db->from('tbl_fabric');
        $this->db->where('fab_group', $tmp[0]);
        $this->db->where('fab_gsm', $tmp[1]);
        $this->db->where('fab_dia', $tmp[3]);
        $this->db->where('fab_cauge', $tmp[4]);
        $this->db->where('fab_color', '1');
        $this->db->where('fab_content', str_replace('/', ',', $tmp[2]));
        $query = $this->db->get();
        return $query->result_array();
    }
    public function outward_reduce($type)
    {

        $this->db->select('tbl_outward.*');
        $this->db->from('tbl_outward');
        $this->db->where('tbl_outward.po_type', $type['type']);
        $this->db->where('tbl_outward.po_no', $type['po']);
        $this->db->where('tbl_outward.bill_no', $type['dc']);
        $this->db->where('tbl_outward.mat_name', $type['mat_name']);
        $this->db->where('tbl_outward.outward_type', 'Direct Inward');
        $this->db->where('tbl_outward.job_type', '1');
        $this->db->where('tbl_outward.mat_type', '2');
        $this->db->where('tbl_outward.is_active', 'Y');
        $this->db->where('tbl_outward.gsm', $type['fab_gsm']);
        $this->db->where('tbl_outward.fab_name', $type['fab_name']);
        $this->db->where('tbl_outward.content', $type['fab_content']);
        $this->db->where('tbl_outward.dia', $type['fab_dia']);
        $this->db->where('tbl_outward.gauge', $type['fab_cauge']);
        $this->db->order_by('tbl_outward.id', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function chk_knit($a, $b)
    {
        $this->db->select('*');
        $this->db->from('tbl_knit_list');
        $this->db->where('knit_id', $a);
        $this->db->where('knit_value', $b);
        return $this->db->get()->result_array();
    }
    function knit_list($a)
    {
        $this->db->select('tbl_knit_list.id as main');
        $this->db->select('tbl_knit_list.*,tbl_fabric.*');
        $this->db->from('tbl_knit_list');
        $this->db->join('tbl_fabric', 'tbl_fabric.id = tbl_knit_list.knit_value');
        $this->db->where('knit_id', $a);
        return $this->db->get()->result_array();
    }
    public function get_table($table, $where, $id, $active)
    {
        if ($active == 1) {
            $this->db->where('is_active', 'Y');
        } else if ($active == 2) {
            $this->db->where('is_active', 'N');
        } else {
        }
        if ($where != null && $id != null) {
            $this->db->where($where, $id);
        }

        return $this->db->get($table)->result_array();
    }
    public function get_table_data($tbl, $active, $where, $id, $column)
    {
        if ($active == 1) {
            $this->db->where('is_active', 'Y');
        } else if ($active == 2) {
            $this->db->where('is_active', 'N');
        } else {
        }
        if ($where != "" && $where != null) {
            if (count($where) > 1) {
                $this->db->where($where);
            } else {
                $this->db->where($where, $id);
            }
        }
        $this->db->order_by('id', 'desc');
        if ($column != '' && $column != null) {
            $query =  $this->db->get($tbl)->result_array();
            return $query[0][$column];
        } else {
            return $this->db->get($tbl)->result_array();
        }
    }
    public function get_table_data_concern_active($tbl, $active, $where, $id, $column)
    {
        $this->db->where('concern_active', 1);
        if ($active == 1) {
            $this->db->where('is_active', 'Y');
        } else if ($active == 2) {
            $this->db->where('is_active', 'N');
        } else {
        }
        if ($where != "" && $where != null) {
            if (count($where) > 1) {
                $this->db->where($where);
            } else {
                $this->db->where($where, $id);
            }
        }
        $this->db->order_by('id', 'desc');
        if ($column != '' && $column != null) {
            $query =  $this->db->get($tbl)->result_array();
            return $query[0][$column];
        } else {
            return $this->db->get($tbl)->result_array();
        }
    }
    function find_fabric($data)
    {
        $this->db->select('*');
        $this->db->from('tbl_fabric');
        $this->db->where($data);
        $chk = $this->db->get()->result_array();
        if (count($chk) > 0) {
            return $chk[0]['id'];
        } else {
            $this->db->insert('tbl_fabric', $data);
            return $this->db->insert_id();
        }
    }
    function find_yarn($data)
    {
        $this->db->select('*');
        $this->db->from('tbl_yarn');
        $this->db->where($data);
        $chk = $this->db->get()->result_array();
        if (count($chk) > 0) {
            return $chk[0]['id'];
        } else {
            $this->db->insert('tbl_yarn', $data);
            return $this->db->insert_id();
        }
    }
    public function item_reduce($type)
    {
        $this->db->select('tbl_stock.*');
        $this->db->from('tbl_stock');
        $this->db->where('tbl_stock.is_active', 'Y');
        $this->db->where($type);
        $query = $this->db->get();
        return ($query->result_array());
    }
    public function get_dyeing()
    {
        $this->db->select('tbl_dyeing_outward.*,tbl_vendor.cname vname');
        $this->db->from('tbl_dyeing_outward');
        $this->db->join('tbl_vendor', 'tbl_vendor.id = tbl_dyeing_outward.company_name');
        $this->db->where('tbl_dyeing_outward.is_active', 'Y');
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        return ($query->result_array());
    }
    public function get_compacting()
    {
        $this->db->select('tbl_compacting_outward.*,tbl_vendor.cname vname');
        $this->db->from('tbl_compacting_outward');
        $this->db->join('tbl_vendor', 'tbl_vendor.id = tbl_compacting_outward.company_name');
        $this->db->where('tbl_compacting_outward.is_active', 'Y');
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        return ($query->result_array());
    }
    public function get_heat()
    {
        $this->db->select('tbl_heat_outward.*,tbl_vendor.cname vname');
        $this->db->from('tbl_heat_outward');
        $this->db->join('tbl_vendor', 'tbl_vendor.id = tbl_heat_outward.company_name');
        $this->db->where('tbl_heat_outward.is_active', 'Y');
        $query = $this->db->get();
        return ($query->result_array());
    }
    public function knit_total_value($id)
    {
        $this->db->select('COALESCE(sum(total),0) as total');
        $this->db->from('tbl_knit_list');
        $this->db->where('knit_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function dy_total_value($id)
    {
        $this->db->select('COALESCE(sum(weight*rate),0) as total');
        $this->db->from('tbl_dyeing_list');
        $this->db->where('bill_no', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function compact_total_value($id)
    {
        $this->db->select('COALESCE(sum(weight*rate),0) as total');
        $this->db->from('tbl_compacting_list');
        $this->db->where('bill_no', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function heat_total_value($id)
    {
        $this->db->select('COALESCE(sum(weight*rate),0) as total');
        $this->db->from('tbl_heat_list');
        $this->db->where('bill_no', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function buy_total_value($id)
    {
        $this->db->select('COALESCE(sum(item_weight*item_rate),0) as total');
        $this->db->from('tbl_purchase_list');
        $this->db->where('purchase_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
}
