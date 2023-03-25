<?php
class M_poy extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    function getPoyInward()
    {
        $this->db->select('bud_yt_poy_inward.*,bud_yt_supplier_groups.group_name,SUM(`po_qty`) as tatalPOqty,bud_yt_departments.dept_name, bud_yt_poyinw_items.remarks, bud_yt_poyinw_items.po_item_rate, bud_yt_poyinw_items.poy_denier, poy.denier_name');
        $this->db->select('bud_items.item_name,bud_items.item_id');
        $this->db->from('bud_yt_poy_inward');
        $this->db->join('bud_yt_supplier_groups', 'bud_yt_supplier_groups.group_id=bud_yt_poy_inward.sup_group_id', 'left');
        $this->db->join('bud_yt_poyinw_items', 'bud_yt_poyinw_items.po_no=bud_yt_poy_inward.po_no', 'left');
        $this->db->join('bud_yt_poydeniers as poy', 'poy.denier_id = bud_yt_poyinw_items.poy_denier', 'left');
        $this->db->join('bud_items', 'bud_items.item_id=bud_yt_poyinw_items.item_id', 'left');
        $this->db->join('bud_yt_departments', 'bud_yt_departments.dept_id=bud_yt_poy_inward.department', 'left');
        $this->db->where('bud_yt_poy_inward.module', $this->session->userdata('user_viewed'));
        $this->db->group_by('bud_yt_poy_inward.po_no');
        $query = $this->db->get();
        return $query->result_array();
    }

    function getPoyInwardsDet($po_no)
    {
        $this->db->select('e2.po_item_rate, e2.remarks');
        $this->db->from('bud_yt_poyinw_items as e1');
        $this->db->join('bud_yt_poyinw_items as e2', 'e1.po_no = e2.po_no AND e2.rowid > e1.rowid');
        $this->db->where('e1.po_no', $po_no);
        $this->db->where('e2.rowid', NULL);
        //$this->db->where('rowid.id > rowid.id');
        $query = $this->db->get();
        return $query->result_array();
    }

    function getPoyPoIssue()
    {
        $this->db->select('bud_yt_po_issue.*,bud_suppliers.sup_name as cust_name,SUM(`po_qty`) as tatalPOqty');
        $this->db->select('bud_yt_po_items.item_id,bud_yt_po_items.shade_id');
        $this->db->select('bud_items.item_name');
        $this->db->select('bud_shades.shade_name, bud_shades.shade_code');
        $this->db->from('bud_yt_po_issue');
        $this->db->join('bud_yt_po_items', 'bud_yt_po_items.po_no=bud_yt_po_issue.po_no', 'left');
        $this->db->join('bud_items', 'bud_yt_po_items.item_id=bud_items.item_id', 'left');
        $this->db->join('bud_shades', 'bud_yt_po_items.shade_id=bud_shades.shade_id', 'left');
        $this->db->join('bud_suppliers', 'bud_suppliers.sup_id=bud_yt_po_issue.customer_id', 'left');
        $this->db->group_by('bud_yt_po_issue.po_no');
        $query = $this->db->get();
        return $query->result_array();
    }
    function getPoyIssueList()
    {
        $this->db->select('bud_yt_poy_issue.*,bud_items.item_name,bud_yt_supplier_groups.group_name,bud_suppliers.sup_name,bud_yt_departments.dept_name,bud_yt_poydeniers.denier_name,bud_poy_lots.poy_lot_name,bud_uoms.uom_name')
            ->from('bud_yt_poy_issue')
            ->join('bud_items', 'bud_items.item_id=bud_yt_poy_issue.item_id')
            ->join('bud_yt_supplier_groups', 'bud_yt_supplier_groups.group_id=bud_yt_poy_issue.sup_group_id')
            ->join('bud_suppliers', 'bud_suppliers.sup_id=bud_yt_poy_issue.supplier_id')
            ->join('bud_yt_departments', 'bud_yt_departments.dept_id=bud_yt_poy_issue.department')
            ->join('bud_yt_poydeniers', 'bud_yt_poydeniers.denier_id=bud_yt_poy_issue.poy_denier')
            ->join('bud_poy_lots', 'bud_poy_lots.poy_lot_id=bud_yt_poy_issue.poy_lot')
            ->join('bud_uoms', 'bud_uoms.uom_id=bud_yt_poy_issue.uom')
            ->group_by('bud_yt_poy_issue.id');
        $query = $this->db->get();
        return $query->result_array();
    }
    function getYarnDelivery()
    {
        $this->db->select('bud_yt_yarndelivery.*,SUM(`qty`) as tatalqty,from_dept.dept_name as from_dept,to_dept.dept_name as to_dept,bud_uoms.uom_name')
            ->from('bud_yt_yarndelivery')
            ->join('bud_yt_yarn_delivery_items', 'bud_yt_yarn_delivery_items.yarn_delivery_id=bud_yt_yarndelivery.delivery_id')
            ->join('bud_yt_departments from_dept', 'from_dept.dept_id=bud_yt_yarndelivery.delivery_from')
            ->join('bud_yt_departments to_dept', 'to_dept.dept_id=bud_yt_yarndelivery.delivery_to')
            ->join('bud_uoms', 'bud_uoms.uom_id=bud_yt_yarn_delivery_items.uom')
            ->group_by('bud_yt_yarndelivery.delivery_id');
        $query = $this->db->get();
        return $query->result_array();
    }
    function getNextPOYIssueNo()
    {
        $this->db->select_max('issue_no');
        $query = $this->db->get('bud_yt_poy_issue');
        $result = $query->row();
        $data = $result->issue_no;
        return $data + 1;
    }
    function check_password($user_id, $password)
    {
        $this->db->where("user_pass", $password);
        $this->db->where("ID", $user_id);
        $query = $this->db->get("bud_users");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function get_poy_inwards()
    {
        $this->db->order_by('po_no', 'desc');
        return $this->db->get('bud_yt_poy_inward')->result();
    }
    function get_poy_inward($po_no = false, $filter = array())
    {
        $result = false;
        $this->db->select('bud_yt_poy_inward.*,bud_yt_supplier_groups.group_name,SUM(`po_qty`) as tatalPOqty,bud_yt_departments.dept_name');

        $this->db->select("bud_yarn_lots.yarn_lot_id, bud_yarn_lots.yarn_denier");

        $this->db->from('bud_yt_poy_inward');
        $this->db->join('bud_yt_supplier_groups', 'bud_yt_supplier_groups.group_id=bud_yt_poy_inward.sup_group_id', 'left');
        $this->db->join('bud_yt_poyinw_items', 'bud_yt_poyinw_items.po_no=bud_yt_poy_inward.po_no', 'left');
        $this->db->join('bud_yt_departments', 'bud_yt_departments.dept_id=bud_yt_poy_inward.department', 'left');

        $this->db->join('bud_yarn_lots', 'bud_yt_poyinw_items.poy_denier=bud_yarn_lots.poy_denier_id', 'left');

        if (!empty($po_no)) {
            $this->db->where('bud_yt_poy_inward.po_no', $po_no);
        }

        if (count($filter) > 0) {
            if (isset($filter['supplier_id'])) {
                $this->db->where('bud_yt_poyinw_items.supplier_id', $filter['supplier_id']);
            }
            if (isset($filter['poy_lot_id'])) {
                $this->db->where('bud_yt_poyinw_items.poy_lot', $filter['poy_lot_id']);
            }
            if (isset($filter['poy_denier'])) {
                $this->db->where('bud_yt_poyinw_items.poy_denier', $filter['poy_denier']);
            }
            if (isset($filter['yarn_lot_id'])) {
                $this->db->where('bud_yarn_lots.yarn_lot_id', $filter['yarn_lot_id']);
            }
            if (isset($filter['yarn_denier'])) {
                $this->db->where('bud_yarn_lots.yarn_denier', $filter['yarn_denier']);
            }
        }

        $this->db->group_by('bud_yt_poy_inward.po_no');
        $query = $this->db->get();
        $result = $query->result();
        if (sizeof($result) > 0) {
            foreach ($result as $row) {
                $row->inward_items = $this->get_poy_inward_items($po_no);
            }
        }
        return $result;
    }
    function get_poy_inward_items($po_no = false)
    {
        $this->db->join('bud_items', 'bud_items.item_id = bud_yt_poyinw_items.item_id', 'left');
        $this->db->join('bud_yt_poydeniers as poy', 'poy.denier_id = bud_yt_poyinw_items.poy_denier', 'left');
        $this->db->join('bud_poy_lots as lot', 'lot.poy_lot_id = bud_yt_poyinw_items.poy_lot', 'left');
        $this->db->join('bud_suppliers', 'bud_yt_poyinw_items.supplier_id = bud_suppliers.sup_id', 'left');
        if (!empty($po_no)) {
            $this->db->where('po_no', $po_no);
        }
        return $this->db->get('bud_yt_poyinw_items')->result();
    }
    function get_poy_inward_qty($po_no = false)
    {
        $this->db->select('SUM(po_qty) as tot_inward_qty');
        if (!empty($po_no)) {
            $this->db->where('po_no', $po_no);
        }
        return $this->db->get('bud_yt_poyinw_items')->row();
    }

    function save_physical_stock($save)
    {
        if ($save['id']) {
            $this->db->where('id', $save['id']);
            $this->db->update('bud_poy_physical_stock_log', $save);
            $id = $save['id'];
        } else {
            $this->db->insert('bud_poy_physical_stock_log', $save);
            $id = $this->db->insert_id();
        }
    }

    function get_poy_lost($filter = array())
    {
        if (count($filter) > 0) {
            if (isset($filter['supplier_id'])) {
                $this->db->where('supplier_id', $filter['supplier_id']);
            }
            if (isset($filter['poy_denier'])) {
                $this->db->where('poy_denier', $filter['poy_denier']);
            }
        }
        return $this->db->get('bud_poy_lots')->result();
    }

    function get_yarn_lots($filter = array())
    {
        $this->db->select("bud_yarn_lots.*");
        $this->db->select("bud_yt_yarndeniers.denier_name yarn_denier_name");
        $this->db->select("bud_yt_poydeniers.denier_name as poy_denier_name");
        $this->db->select("bud_uoms.uom_name");

        $this->db->join('bud_yt_yarndeniers', 'bud_yarn_lots.yarn_denier=bud_yt_yarndeniers.denier_id', 'left');
        $this->db->join('bud_yt_poydeniers', 'bud_yarn_lots.poy_denier_id=bud_yt_poydeniers.denier_id', 'left');
        $this->db->join('bud_uoms', 'bud_yarn_lots.yarn_lot_uom=bud_uoms.uom_id', 'left');

        if (count($filter) > 0) {
            if (isset($filter['yarn_denier'])) {
                $this->db->where('bud_yarn_lots.yarn_denier', $filter['yarn_denier']);
            }
        }
        return $this->db->get('bud_yarn_lots')->result();
    }
    function get_poy_deniers($filter = array())
    {
        if (count($filter) > 0) {
            if (isset($filter['supplier_id'])) {
                $this->db->where('supplier_id', $filter['supplier_id']);
            }
        }
        return $this->db->get('bud_yt_poydeniers')->result();
    }
    function get_suppliers($filter = array())
    {
        $this->db->where('sup_status', 1);
        return $this->db->get('bud_suppliers')->result();
    }
    function get_customers($filter = array())
    {
        $this->db->where('cust_status', 1);
        return $this->db->get('bud_customers')->result();
    }

    public function get_lot_list($filter = array())
    {
        $this->db->select('bud_lots.*');
        if (count($filter)) {
            if (isset($filter['shade_id'])) {
                $this->db->where('bud_lots.lot_shade_no', $filter['shade_id']);
            }
            if (isset($filter['item_id'])) {
                $this->db->where('bud_lots.lot_item_id', $filter['item_id']);
            }
            if (isset($filter['customer_id'])) {
                $this->db->select('ak_po_from_customers.bud_customers as customer_id');
                $this->db->join('ak_po_from_customers', 'bud_lots.po_no=ak_po_from_customers.R_po_no', 'left');
                $this->db->where('ak_po_from_customers.bud_customers', $filter['customer_id']);
            }
        }
        return $this->db->get('bud_lots')->result();
    }
}
