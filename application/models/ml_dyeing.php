<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ML_dyeing extends CI_Model
{

    var $table = 'tbl_dyeing_outward';
    var $column_order = array('tbl_dyeing_outward.id');
    var $column_search = array('tbl_dyeing_outward.dc_no', 'tbl_vendor.cname');
    var $order = array('tbl_dyeing_outward.bill_no' => 'desc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    private function get_datatables_query()
    {
        $this->db->select('tbl_dyeing_outward.*,tbl_vendor.cname,tbl_fabric.fab_name as fabric,tbl_inter_po_product.style as style');
        $this->db->select('tbl_color.cname as rcolor');
        $this->db->join('tbl_vendor', 'tbl_vendor.id = tbl_dyeing_outward.company_name');
        $this->db->join('tbl_fabric', 'tbl_fabric.id = tbl_dyeing_outward.mat_name');
        $this->db->join('tbl_color', 'tbl_color.id = tbl_dyeing_outward.return_color');
        $this->db->join('tbl_inter_po_product', 'tbl_inter_po_product.id = tbl_dyeing_outward.style');
        $this->db->from('tbl_dyeing_outward');
        $this->db->where('tbl_dyeing_outward.job_type', '2');
        $this->db->where('tbl_dyeing_outward.is_active', 'Y');

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
    function load_knit_inward_data($id)
    {
        $this->db->select('tbl_stock.*,tbl_fabric.*,tbl_fab_name.name as fabric,sum(tbl_stock.weight) as sum_value');
        $this->db->from('tbl_stock');
        $this->db->join('tbl_fabric', 'tbl_fabric.id = tbl_stock.mat_id');
        $this->db->join('tbl_fab_name', 'tbl_fab_name.id = tbl_fabric.fab_id');
        $this->db->where('tbl_stock.style', $id);
        $this->db->where('tbl_stock.is_active', 'Y');
        $this->db->group_by('tbl_stock.mat_id');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function load_outward($type)
    {
        $this->db->select('tbl_dyeing_outward.*,tbl_vendor.cname,tbl_fabric.fab_name as fabric');
        $this->db->select('tbl_color.cname as rcolor');
        $this->db->join('tbl_vendor', 'tbl_vendor.id = tbl_dyeing_outward.company_name');
        $this->db->join('tbl_fabric', 'tbl_fabric.id = tbl_dyeing_outward.mat_name');
        $this->db->join('tbl_color', 'tbl_color.id = tbl_dyeing_outward.return_color');
        $this->db->from('tbl_dyeing_outward');
        $this->db->where('tbl_dyeing_outward.job_type', '2');
        $this->db->where('tbl_dyeing_outward.is_active', 'Y');
        $this->db->where('tbl_dyeing_outward.dc_no', $type['dc']);
        if ($type['type'] != '' && $type['type'] != null) {
            $this->db->where('tbl_dyeing_outward.po_type', $type['type']);
        }
        if ($type['po'] != '' &&  $type['po'] != null) {
            $this->db->where('tbl_dyeing_outward.po_no', $type['po']);
        }
        if ($type['jt'] != '' && $type['jt'] != null) {
            $this->db->where('tbl_dyeing_outward.inward_job_type', $type['jt']);
        }
        if ($type['pt'] != '' && $type['pt'] != null) {
            $this->db->where('tbl_dyeing_outward.recipe_code', $type['pt']);
        }
        if ($type['val'] != '' && $type['val'] != null) {
            $this->db->where('tbl_dyeing_outward.mat_name', $type['val']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function fab_load($type)
    {

        $this->db->select('tbl_fabric.id,concat("Name : ", tbl_fabric.fab_name, " Color : ",tbl_color.cname) as text');
        $this->db->from('tbl_stock');
        $this->db->join('tbl_fabric', 'tbl_fabric.id = tbl_stock.mat_id');
        $this->db->join('tbl_color', 'tbl_color.id = tbl_fabric.fab_color');
        $this->db->where('tbl_stock.po_type', $type['type']);
        $this->db->where('tbl_stock.po_number', $type['po']);
        if ($type['mode'] == 0) {
            $this->db->where('tbl_stock.inward_mode', 'Direct Inward');
        }
        if ($type['it'] != 0) {
            $this->db->where('tbl_stock.inward_type', $type['it']);
        } else {
            $this->db->where('tbl_stock.inward_type', null);
        }
        if (array_key_exists("rc", $type)) {
            $this->db->where('tbl_stock.recipe_code', $type['rc']);
        }
        //$this->db->where('tbl_stock.is_active','Y');
        $this->db->where('tbl_stock.mat_type', '1');
        $this->db->group_by('tbl_stock.mat_id');

        $query = $this->db->get();
        return $query->result_array();
    }
    function work_load($id)
    {
        $this->db->select('a.*');
        $this->db->from('tbl_recipe_job b');
        $this->db->join('tbl_job_work a', 'a.id = b.job_id');
        $this->db->where('b.recipe_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function bill_load($type)
    {
        $this->db->select('dc_no as id,dc_no as text');
        $this->db->from('tbl_dyeing_outward');
        $this->db->where('tbl_dyeing_outward.po_type', $type['type']);
        $this->db->where('tbl_dyeing_outward.po_no', $type['po']);
        $this->db->group_by('dc_no');
        $query = $this->db->get();
        return $query->result_array();
    }
    function fab_list($id, $type)
    {

        $this->db->select('tbl_fabric.*,sum(tbl_stock.quantity) as total,sum(tbl_stock.weight) as weight');
        $this->db->select('tbl_color.cname');
        $this->db->select('GROUP_CONCAT(tbl_content.name) as conname');
        $this->db->from('tbl_fabric');
        $this->db->join('tbl_stock', 'tbl_stock.mat_id = tbl_fabric.id');
        $this->db->join('tbl_color', 'tbl_color.id = tbl_fabric.fab_color');

        $this->db->join('tbl_content', 'find_in_set(tbl_content.id , tbl_fabric.fab_content)', 'left');
        $this->db->where('tbl_stock.is_active', 'Y');
        $this->db->where('tbl_fabric.id', $id);
        $this->db->where('tbl_stock.po_type', $type['type']);
        $this->db->where('tbl_stock.po_number', $type['po']);
        if ($type['mode'] == 1) {
            $this->db->where('tbl_stock.inward_mode', 'Direct Inward');
        }
        if ($type['it'] != 0) {
            $this->db->where('tbl_stock.inward_type', $type['it']);
        }
        $this->db->group_by('tbl_stock.mat_id');
        $query = $this->db->get();
        return ($query->result_array());
    }
    function stock_reduce($id, $type)
    {
        $this->db->select('*');
        $this->db->from('tbl_stock');
        $this->db->where('mat_id', $id);
        $this->db->where('is_active', 'Y');
        if ($type['type'] != '' && $type['type'] != null) {
            $this->db->where('tbl_stock.po_type', $type['type']);
        }
        if ($type['po'] != '' && $type['po'] != null) {
            $this->db->where('tbl_stock.po_number', $type['po']);
        }
        if ($type['mode'] == 1) {
            $this->db->where('tbl_stock.inward_mode', 'Direct Inward');
        }
        if ($type['it'] != 0) {
            $this->db->where('tbl_stock.inward_type', $type['it']);
        }
        $query = $this->db->get();
        return ($query->result_array());
    }
    function get_fabric($id)
    {
        $this->db->where('id', $id);
        $q = $this->db->get('tbl_fabric');
        return $q->result_array();
    }
    function chk_fabric($name, $clr)
    {
        $this->db->where('id', $name);
        $fabric = $this->db->get('tbl_fabric')->result_array();
        foreach ($fabric as $row) {
            $group = $row['fab_group'];
            $gsm = $row['fab_gsm'];
            $dia = $row['fab_dia'];
            $count = $row['fab_count'];
            $cauge = $row['fab_cauge'];
            $content = $row['fab_content'];
            $color = $clr;
            $group = $row['fab_group'];
            $name = $row['fab_name'];
            $al = $row['fab_allowence'];
        }
        $this->db->where('fab_gsm', $gsm);
        $this->db->where('fab_dia', $dia);
        $this->db->where('fab_group', $group);
        $this->db->where('fab_content', $content);
        $this->db->where('fab_count', $count);
        $this->db->where('fab_color', $color);
        $this->db->where('fab_cauge', $cauge);
        $chk = $this->db->get('tbl_fabric')->result_array();
        if (count($chk) > 0) {
            return $chk[0]['id'];
        } else {
            $data = array(
                'fab_name' => $name,
                'fab_count' => $count,
                'fab_color' => $color,
                'fab_group' => $group,
                'fab_gsm' => $gsm,
                'fab_dia' => $dia,
                'fab_cauge' => $cauge,
                'fab_content' => $content,
                'fab_allowence' => $al,
                'parent_id' => $this->session->userdata('user_id'),
                'added_date' => date('d-m-Y h:i:s')
            );
            $this->db->insert('tbl_fabric', $data);
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
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
    function dyeing_list($a)
    {
        $this->db->select('*,tbl_dyeing_outward.id as main');
        $this->db->select('tbl_dyeing_outward.*,tbl_fabric.*');
        $this->db->from('tbl_dyeing_outward');
        $this->db->join('tbl_fabric', 'tbl_fabric.id = tbl_dyeing_outward.mat_name');
        $this->db->join('tbl_color', 'tbl_color.id = tbl_dyeing_outward.return_color');
        $this->db->where('dc_no', $a);
        return $this->db->get()->result_array();
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
        if ($column != '' && $column != null) {
            $query =  $this->db->get($tbl)->result_array();
            return $query[0][$column];
        } else {
            return $this->db->get($tbl)->result_array();
        }
    }
}
