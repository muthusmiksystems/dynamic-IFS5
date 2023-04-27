<?php
class ak extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    function get_table($table)
    {
        return $this->db->get($table)->result_array();
    }
    function getNextBoxNo($box_prefix)
    {
        $this->db->select_max('box_no');
        $this->db->where('box_prefix', $box_prefix);
        $query = $this->db->get('bud_yt_packing_boxes');
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->box_no + 1;
        }
    }
    function yt_packing_boxes($box_prefix = null, $filter = array(), $all_boxes = false)
    {
        $this->db->select('bud_yt_packing_boxes.*,bud_yt_packing_boxes.remarks as bud_remarks,bud_items.*,bud_yt_yarndeniers.denier_tech,bud_yt_poydeniers.denier_name as poy_denier_name,bud_shades.*,bud_poy_lots.poy_lot_name');
        $this->db->from('bud_yt_packing_boxes');
        $this->db->join('bud_items', 'bud_items.item_id = bud_yt_packing_boxes.item_id', 'left');
        $this->db->join('bud_yt_yarndeniers', 'bud_yt_yarndeniers.denier_id = bud_yt_packing_boxes.yarn_denier', 'left');
        $this->db->join('bud_yt_poydeniers', 'bud_yt_poydeniers.denier_id = bud_yt_packing_boxes.poy_denier', 'left');
        $this->db->join('bud_shades', 'bud_shades.shade_id = bud_yt_packing_boxes.shade_no', 'left');
        $this->db->join('bud_poy_lots', 'bud_yt_packing_boxes.poy_lot_id = bud_poy_lots.poy_lot_id', 'left');
        if ($box_prefix != null) {
            $this->db->where('bud_yt_packing_boxes.box_prefix', $box_prefix);
        }
        if (count($filter) > 0) {
            if (isset($filter['stock_room_id'])) {
                $this->db->where('bud_yt_packing_boxes.stock_room_id', $filter['stock_room_id']);
            }
        }
        if (empty($all_boxes)) {
            $this->db->where('bud_yt_packing_boxes.predelivery_status', 1);
            $this->db->where('bud_yt_packing_boxes.delivery_status', 1);
            $this->db->where('bud_yt_packing_boxes.is_deleted', 0);
        }

        $this->db->order_by('box_id', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_dyed_thread_inner_boxes($box_ids = array())
    {
        $this->db->select('ak_po_dyed_thread_inner.*,bud_items.*,bud_shades.*, bud_lots.lot_no');
        $this->db->from('ak_po_dyed_thread_inner');
        $this->db->join('bud_items', 'bud_items.item_id = ak_po_dyed_thread_inner.item_id', 'left');
        $this->db->join('bud_shades', 'bud_shades.shade_id = ak_po_dyed_thread_inner.shade_id', 'left');
        $this->db->join('bud_lots', 'ak_po_dyed_thread_inner.lot_id = bud_lots.lot_id', 'left');
        if (count($box_ids) > 0) {
            $this->db->where_in('ak_po_dyed_thread_inner.inner_box_id', $box_ids);
        }
        $query = $this->db->get();
        return $query->result_array();
    }
    function yt_packing_box($box_id)
    {
        $this->db->select('bud_yt_packing_boxes.*,bud_items.*,bud_yt_yarndeniers.denier_tech,bud_yt_poydeniers.denier_name as poy_denier_name,bud_shades.*,bud_poy_lots.poy_lot_name');

        $this->db->select("bud_yarn_lots.yarn_lot_id, bud_yarn_lots.yarn_lot_no");

        // $this->db->from('bud_yt_packing_boxes');
        $this->db->join('bud_items', 'bud_items.item_id = bud_yt_packing_boxes.item_id', 'left');
        $this->db->join('bud_yt_yarndeniers', 'bud_yt_yarndeniers.denier_id = bud_yt_packing_boxes.yarn_denier', 'left');
        $this->db->join('bud_yt_poydeniers', 'bud_yt_poydeniers.denier_id = bud_yt_packing_boxes.poy_denier', 'left');
        $this->db->join('bud_shades', 'bud_shades.shade_id = bud_yt_packing_boxes.shade_no', 'left');
        $this->db->join('bud_poy_lots', 'bud_yt_packing_boxes.poy_lot_id = bud_poy_lots.poy_lot_id', 'left');

        // $this->db->join('bud_yarn_lots', 'bud_yt_poydeniers.denier_id=bud_yarn_lots.poy_denier_id', 'left');
        $this->db->join('bud_yarn_lots', 'bud_yt_packing_boxes.yarn_lot_id=bud_yarn_lots.yarn_lot_id', 'left');

        return $this->db->get_where('bud_yt_packing_boxes', array('bud_yt_packing_boxes.box_id' => $box_id))->row();
    }
    function get_vocher_no()
    {
        $this->db->select('iou_voucher_no')
            ->from('bud_general_iou')
            ->where('status', "1");
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_vocher_detail($vocher_id)
    {
        $this->db->select('*')
            ->from('bud_general_iou_items')
            ->where('iou_voucher_id', $vocher_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function complete_vocher_item($id, $spend, $balance)
    {
        $data = array(
            'cleared' => 1,
            'amt_spend' => $spend,
            'amt_remaining' => $balance
        );
        $this->db->where('id', $id);
        $this->db->update('bud_general_iou_items', $data);
    }
    /*function complete_vocher($id)
    {
        $data = array(
                'cleared' => 1
            );

        $this->db->where('iou_voucher_id',$id);
        $this->db->update('bud_general_iou_items',$data);
        //$this->db->where('iou_voucher_no',$id);
        //$this->db->delete('bud_general_iou');
    }*/
    function get_poy_denier()
    {
        $this->db->select('denier_id,denier_name,sup_group_id')
            ->from('bud_yt_poydeniers');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return NULL;
        }
    }
    function getPoyIssueList($id)
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
            ->where('bud_yt_poydeniers.denier_id', $id)
            ->group_by('bud_yt_poy_issue.id');
        $query = $this->db->get();
        return $query->result_array();
    }
    function tot_poy($denier)
    {
        $query = $this->db->query('SELECT sum(po_qty) as tot FROM bud_yt_poyinw_items where poy_denier = ' . $denier);
        if ($query->row(0)->tot != NULL) {
            return $query->row(0)->tot;
        } else {
            return "0";
        }
    }
    function issue_poy($denier)
    {
        $query = $this->db->query('SELECT sum(qty) as tot FROM bud_yt_poy_issue where poy_denier = ' . $denier);
        if ($query->row(0)->tot != NULL) {
            return $query->row(0)->tot;
        } else {
            return "0";
        }
    }
    function get_poy_items()
    {
        $query = $this->db->query('select * from bud_yt_poyinw_items');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return NULL;
        }
    }
    function get_poy_items_name()
    {
        $query = $this->db->query('select item_id,item_name from bud_items');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return NULL;
        }
    }
    function get_sales_entry()
    {
        $this->db->select('sale.*,sum(it.qty) as total_qty')
            ->from('bud_yt_salesentry as sale')
            ->join('bud_yt_poy_sales_items as it', 'it.sales_id = sale.sales_id')
            ->group_by('it.sales_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }
    function get_poy_sales_items($sales_id)
    {
        $this->db->select('bud_yt_poy_sales_items.*');
        $this->db->select('bud_items.item_name');
        $this->db->select('bud_yt_poydeniers.denier_name');
        $this->db->select('bud_poy_lots.poy_lot_no');
        $this->db->join('bud_items', 'bud_yt_poy_sales_items.item_id = bud_items.item_id');
        $this->db->join('bud_yt_poydeniers', 'bud_yt_poy_sales_items.poy_denier = bud_yt_poydeniers.denier_id');
        $this->db->join('bud_poy_lots', 'bud_yt_poy_sales_items.poy_lot = bud_poy_lots.poy_lot_id');
        $this->db->where('bud_yt_poy_sales_items.sales_id', $sales_id);
        return $this->db->get('bud_yt_poy_sales_items')->result_array();
    }
    function get_gray_yarn_soft()
    {
        $this->db->SELECT('gray.id as box,gray.date,yarn.denier_id as yarn_id,yarn.denier_name as yarn,shade.shade_id,shade.shade_name,shade.shade_code,poy.denier_id as poy_id,poy.denier_name as poy,gray.grant_wt,gray.net_wt,gray.packed_by')
            ->FROM('ak_gray_yarn_soft as gray ')
            ->join('bud_yt_poydeniers as poy', 'poy.denier_id = gray.poy')
            ->join('bud_yt_yarndeniers as yarn', 'yarn.denier_id = gray.yarn')
            ->join('bud_shades as shade', 'shade.shade_id = gray.shade')
            ->group_by('gray.id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }
    function get_gray_yarn_packing($stock_room_id = null)
    {
        $this->db->SELECT('gray.box_prefix,gray.stock_room_id,gray.id as box,gray.date,yarn.denier_id as yarn_id,yarn.denier_name as yarn,shade.shade_id,shade.shade_name,shade.shade_code,poy.denier_id as poy_id,poy.denier_name as poy,gray.grant_wt,gray.net_wt,gray.packed_by,bud_items.*');
        $this->db->FROM('ak_gray_yarn_packing as gray ');
        $this->db->join('bud_yt_poydeniers as poy', 'poy.denier_id = gray.poy');
        $this->db->join('bud_yt_yarndeniers as yarn', 'yarn.denier_id = gray.yarn');
        $this->db->join('bud_shades as shade', 'shade.shade_id = gray.shade');
        $this->db->join('bud_items', 'bud_items.item_id = gray.item_id');
        if ($stock_room_id != null) {
            $this->db->where('gray.stock_room_id', $stock_room_id);
        }
        $this->db->group_by('gray.id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }
    function get_dyed_yarn_packing()
    {
        $this->db->SELECT('gray.id as box,gray.date,yarn.denier_id as yarn_id,yarn.denier_name as yarn,shade.shade_id,shade.shade_name,shade.shade_code,bud_yarn_lots.*,gray.grant_wt,gray.net_wt,gray.packed_by,bud_items.*')
            ->FROM('ak_dyed_yarn_packing as gray ')
            ->join('bud_yarn_lots', 'bud_yarn_lots.yarn_lot_id = gray.yarn_lot_no')
            ->join('bud_yt_yarndeniers as yarn', 'yarn.denier_id = gray.yarn')
            ->join('bud_shades as shade', 'shade.shade_id = gray.shade')
            ->join('bud_items', 'bud_items.item_id = gray.item_id')
            ->group_by('gray.id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }
    function poy_inwd_detail($po_no, $limit = false)
    {
        $this->db->select('inw.*,inw.po_qty,itm.item_name,inw.item_id as item_code,poy.denier_name,lot.poy_lot_no')
            ->from('bud_yt_poyinw_items as inw')
            ->join('bud_items as itm', 'itm.item_id = inw.item_id', 'left')
            ->join('bud_yt_poydeniers as poy', 'poy.denier_id = inw.poy_denier', 'left')
            ->join('bud_poy_lots as lot', 'lot.poy_lot_id = inw.poy_lot', 'left')
            ->where('inw.po_no', $po_no)
            ->order_by('inw.edate', 'desc');
        if($limit){
            $this->db->limit($limit); 
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function poy_inwd_item($rowid = '')
    {
        if (!empty($rowid)) {
            $this->db->select('inw.*,itm.item_name, poy.denier_name,lot.poy_lot_no')
                ->from('bud_yt_poyinw_items as inw')
                ->join('bud_items as itm', 'itm.item_id = inw.item_id', 'left')
                ->join('bud_yt_poydeniers as poy', 'poy.denier_id = inw.poy_denier', 'left')
                ->join('bud_poy_lots as lot', 'lot.poy_lot_id = inw.poy_lot', 'left')
                ->where('inw.rowid', $rowid);
            $query = $this->db->get();
            return $query->row();
        }
    }
    function save_inward_item($save)
    {
        if ($save['rowid']) {
            $this->db->where('rowid', $save['rowid']);
            $this->db->update('bud_yt_poyinw_items', $save);
            return $save['rowid'];
        } else {
            $this->db->insert('bud_yt_poyinw_items', $save);
            return $this->db->insert_id();
        }
    }
    function yarn_detail($id)
    {
        $this->db->select('itm.item_name,del.item_id as item_code,poy.denier_name as poy,yarn.denier_name as yarn,del.qty')
            ->from('bud_yt_yarn_delivery_items as del')
            ->join('bud_items as itm', 'itm.item_id = del.item_id')
            ->join('bud_yt_poydeniers as poy', 'poy.denier_id = del.poy_denier')
            ->join('bud_yt_yarndeniers as yarn', 'yarn.denier_id = del.yarn_denier')
            ->where('del.yarn_delivery_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function ak_po_from_customers()
    {
        $this->db->select('po.*,cus.cust_name')
            ->from('ak_po_from_customers as po')
            ->join('bud_customers as cus', 'cus.cust_id = po.bud_customers');
        $query = $this->db->get();
        return $query->result_array();
    }
    function po_from_customers_table_details($id)
    {
        $this->db->select('po.id as row_id,it.item_name,po.bud_items as item_code,po.cust_shade_name,shade.shade_name,shade.shade_code,po.cust_epono,po.qty,uom.uom_name,po.rate,po.tax')
            ->from('ak_po_from_customers_items as po')
            ->join('bud_items as it', 'it.item_id = po.bud_items')
            ->join('bud_shades as shade', 'shade.shade_id = po.bud_shades')
            ->join('bud_uoms as uom', 'uom.uom_id = po.bud_uoms')
            ->where('po.R_po_no', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_lot_nos()
    {
        $this->db->select('lot_id,machine')
            ->from('ak_po_dye_production');
        $query = $this->db->get();
        return $query->result_array();
    }
    function yarn_lot_from_delivered()
    {
        $this->db->select('lot_no')
            ->from('ak_po_dlcp')
            ->where('delivery !=', 0)
            ->group_by('lot_no');
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_po_DLCP()
    {
        $this->db->select('tab.date,tab.id as box,tab.lot_no,pro.machine,bud_items.item_name,bud_items.item_id as item_code,bud_shades.shade_name,bud_shades.shade_code,tab.spring_no,tab.gross_wt,tab.net_wt,tab.form_by,tab.delivery')
            ->from('ak_po_dlcp as tab')
            ->join('ak_po_dye_production as pro', 'pro.lot_id = tab.lot_no')
            ->join('ak_po_from_customers_items as item', 'item.id = pro.item_id')
            ->join('bud_items', 'bud_items.item_id = item.bud_items')
            ->join('bud_shades', 'bud_shades.shade_id = item.bud_shades');
        $query = $this->db->get();
        return $query->result_array();
    }
    function dye_max_delivery()
    {
        $this->db->select_max('delivery')
            ->from('ak_po_dlcp');
        $query = $this->db->get();
        return $query->result_array();
    }
    function totLotPacked($lot_no)
    {
        $this->db->select('SUM(`net_weight`) as total_packed')
            ->from('bud_yt_packing_boxes')
            ->where('lot_no', $lot_no);
        $query = $this->db->get();
        $row = $query->row();
        return $row->total_packed;
    }
    function totThreadLotPacked($lot_no)
    {
        $this->db->select('SUM(`net2`) as total_packed')
            ->from('ak_po_dyed_thread_pack')
            ->where('lot', $lot_no);
        $query = $this->db->get();
        $row = $query->row();
        return $row->total_packed;
    }
    function lot_inf_bal($lot)
    {
        $this->db->SELECT('item.item_name,item.item_id as item_code,shade.shade_id,shade.shade_name,shade.shade_code,sum(total.net_wt)')
            ->FROM('ak_po_dye_production as pro')
            ->join('ak_po_from_customers_items as items', 'items.id = pro.item_id')
            ->join('bud_items as item', 'item.item_id = items.bud_items')
            ->join('bud_shades as shade', 'shade.shade_id = items.bud_shades')
            ->join('ak_po_dlcp as total', 'total.lot_no = pro.lot_id')
            ->where('pro.lot_id', $lot);
        $query = $this->db->get();
        return $query->result_array();
    }
    function dyed_yarn_packing()
    {
        $this->db->SELECT('pck.box_prefix,pck.date,pck.id as box,pck.lot,item.item_name,item.item_id as item_code,shade.shade_name,shade.shade_code,pck.gross,pck.net,pck.packed_by')
            ->FROM('ak_po_dyed_yarn_pack as pck')
            ->join('ak_po_dye_production as pro', 'pro.lot_id = pck.lot')
            ->join('ak_po_from_customers_items as items', 'items.id = pro.item_id')
            ->join('bud_items as item', 'item.item_id = items.bud_items')
            ->join('bud_shades as shade', 'shade.shade_id = items.bud_shades')
            ->group_by('pck.id');
        $query = $this->db->get();
        return $query->result_array();
    }
    function dyed_thread_packing()
    {
        $this->db->SELECT('pck.box_prefix,pck.date,pck.id as box,pck.lot,item.item_name,item.item_id as item_code,shade.shade_name,shade.shade_code,pck.gross,pck.net1,pck.net2,pck.packed_by,pck.no_of_cones')
            ->FROM('ak_po_dyed_thread_pack as pck')
            ->join('ak_po_dye_production as pro', 'pro.lot_id = pck.lot')
            ->join('ak_po_from_customers_items as items', 'items.id = pro.item_id')
            ->join('bud_items as item', 'item.item_id = items.bud_items')
            ->join('bud_shades as shade', 'shade.shade_id = items.bud_shades')
            ->group_by('pck.id');
        $query = $this->db->get();
        return $query->result_array();
    }
    function dyed_thread_inner()
    {
        $this->db->SELECT('pck.date,pck.id as box,pck.lot,item.item_name,item.item_id as item_code,shade.shade_name,shade.shade_code,pck.no_of_cones,pck.net_wt_per_cone,pck.meter_per_cone,pck.gross,pck.net,pck.remarks,pck.packed_by,pck.outerbox_no,pck.outerbox_no,pck.outerbox_date,pck.outerbox_gross,pck.outerbox_packed,pck.outerbox_remarks')
            //$this->db->SELECT('pck.date,pck.id as box,pck.lot,item.item_name,item.item_id as item_code,shade.shade_name,shade.shade_code,pck.no_of_cones,pck.net_wt_per_cone,pck.meter_per_cone,pck.gross,pck.net,pck.remarks,pck.packed_by,pck.outerbox_no')
            ->FROM('ak_po_dyed_thread_inner as pck')
            ->join('ak_po_dye_production as pro', 'pro.lot_id = pck.lot')
            ->join('ak_po_from_customers_items as items', 'items.id = pro.item_id')
            ->join('bud_items as item', 'item.item_id = items.bud_items')
            ->join('bud_shades as shade', 'shade.shade_id = items.bud_shades')
            ->group_by('pck.id');
        $query = $this->db->get();
        return $query->result_array();
    }
    function max_outer()
    {
        $this->db->SELECT_max('outerbox_no')
            ->FROM('ak_po_dyed_thread_inner');
        $q = $this->db->get();
        return $q->result_array();
    }

    function get_max_salesreturn_box()
    {
        $this->db->select_max('form_id')
            ->from('ak_po_salesreturn_box');
        $q = $this->db->get();
        return $q->result_array();
    }
    function get_max_salesreturn_item()
    {
        $this->db->select_max('form_id')
            ->from('ak_po_salesreturn_item');
        $q = $this->db->get();
        return $q->result_array();
    }
    function update_all($table, $col_name, $col_data, $data)   //po_DLCDelivery_save
    {
        $this->db->where($col_name, $col_data)
            ->update($table, $data);
    }
    function update_wpoy($id, $weight)
    {
        $data = array(
            'wastage_kg' => $weight,
            'wpoy_status' => "1"
        );
        $this->db->where('issue_no', $id)
            ->update('bud_yt_poy_issue', $data);
    }
    function update_wpoy_accept($id)
    {
        $data = array(
            'wpoy_status' => "2"
        );
        $this->db->where('issue_no', $id)
            ->update('bud_yt_poy_issue', $data);
    }
    function update_po_from_customers($id, $data)
    {
        $this->db->where('R_po_no', $id)
            ->update('ak_po_from_customers', $data);
        return "success";
    }
    function update_po_from_customers_master($id, $data)
    {
        $this->db->where('R_po_no', $id)
            ->update('ak_po_from_customers', $data);
        return "success";
    }
    function dyed_thread_outer($where, $data)
    {
        $this->db->where('id', $where)
            ->update('ak_po_dyed_thread_inner', $data);
        return "success";
    }
    function insert_new($table, $data)
    {
       
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function get_thread_inner_box($inner_box_id)
    {
        return $this->db->get_where('ak_po_dyed_thread_inner', array('inner_box_id' => $inner_box_id))->row();
    }

    function update_thread_inner_box($save)
    {
        if ($save['inner_box_id']) {
            $this->db->where('inner_box_id', $save['inner_box_id']);
            $this->db->update('ak_po_dyed_thread_inner', $save);
            return $save['inner_box_id'];
        }
    }
    function thread_inner_box_details($inner_box_id)
    {
        $this->db->select('ak_po_dyed_thread_inner.*, bud_shades.shade_name,bud_shades.shade_code,bud_lots.lot_no,bud_items.item_name');
        $this->db->join('bud_shades', 'ak_po_dyed_thread_inner.shade_id = bud_shades.shade_id');
        $this->db->join('bud_lots', 'ak_po_dyed_thread_inner.lot_id = bud_lots.lot_id');
        $this->db->join('bud_items', 'ak_po_dyed_thread_inner.item_id = bud_items.item_id');
        return $this->db->get_where('ak_po_dyed_thread_inner', array('inner_box_id' => $inner_box_id))->row();
    }

    function get_thread_inner_boxes($inner_box_id = false, $outerbox_packed = 0)
    {
        $this->db->select('ak_po_dyed_thread_inner.*, bud_shades.shade_name,bud_shades.shade_code,bud_lots.lot_no,bud_items.item_name');
        $this->db->join('bud_shades', 'ak_po_dyed_thread_inner.shade_id = bud_shades.shade_id', 'left');
        $this->db->join('bud_lots', 'ak_po_dyed_thread_inner.lot_id = bud_lots.lot_id', 'left');
        $this->db->join('bud_items', 'ak_po_dyed_thread_inner.item_id = bud_items.item_id', 'left');
        if (!empty($inner_box_id)) {
            $this->db->where('inner_box_id', $inner_box_id);
        }
        $this->db->where('outerbox_packed', $outerbox_packed);
        $this->db->order_by('inner_box_id', 'desc');
        return $this->db->get('ak_po_dyed_thread_inner')->result();
    }

    function save_thread_inner_box($inner_box)
    {
        if ($inner_box['inner_box_id']) {
            $this->db->where('inner_box_id', $inner_box['inner_box_id']);
            $this->db->update('ak_po_dyed_thread_inner', $inner_box);
            return $inner_box['inner_box_id'];
        } else {
            $this->db->insert('ak_po_dyed_thread_inner', $inner_box);
            return $this->db->insert_id();
        }
    }
    function del_thread_inner_box($inner_box_id)
    {
        $this->db->where('inner_box_id', $inner_box_id);
        $this->db->delete('ak_po_dyed_thread_inner');
    }

    function get_sales_return_items()
    {
        $this->db->select('ak_po_salesreturn_item.*');
        $this->db->select('bud_items.item_name');
        $this->db->select('bud_shades.shade_name');
        $this->db->join('bud_items', 'ak_po_salesreturn_item.bud_items = bud_items.item_id');
        $this->db->join('bud_shades', 'ak_po_salesreturn_item.bud_shades = bud_shades.shade_id');
        return $this->db->get('ak_po_salesreturn_item')->result_array();
    }

    function dost_po_accept_option($id = '')
    {
        $this->db->from('dost_po_accept_option');
        if ($id != '') {
            $this->db->where('id', $id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function dost_po_reject_option($id = '')
    {
        $this->db->from('dost_po_reject_option');
        if ($id != '') {
            $this->db->where('id', $id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function dost_po_sampling_option($id = '')
    {
        $this->db->from('dost_po_sampling_option');
        if ($id != '') {
            $this->db->where('id', $id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function dost_po_sample_complete_option($id = '')
    {
        $this->db->from('dost_po_sample_complete_option');
        if ($id != '') {
            $this->db->where('id', $id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function dost_po_sample_final_option($id = '')
    {
        $this->db->from('dost_po_sample_final_option');
        if ($id != '') {
            $this->db->where('id', $id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function dost_lot_status_option($id = '')
    {
        $this->db->from('dost_lot_status_option');
        if ($id != '') {
            $this->db->where('id', $id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function dost_lot_final_option($id = '')
    {
        $this->db->from('dost_lot_final_option');
        if ($id != '') {
            $this->db->where('id', $id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function dost_lot_final_approval($id = '')
    {
        $this->db->from('dost_lot_final_approval');
        if ($id != '') {
            $this->db->where('id', $id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function ak_po_list_customers($id, $filter_from_date, $filter_to_date, $cust_id, $module_id, $item_id, $shade_id)
    {
        $this->db->from('dost_customers_po_enquiry as po');
        $this->db->join('bud_customers as cus', 'cus.cust_id = po.cust_id');
        $this->db->join('dost_customers_po_accept as act', 'act.a_id = po.po_accept_no', 'left');
        $this->db->join('dost_customers_po_reject as reg', 'reg.r_id = po.po_reject_no', 'left');
        $this->db->join('dost_customers_po_sample as sam', 'sam.s_id = po.po_sample_no', 'left');
        if ($id != '') {
            $this->db->where('po.cust_id', $id);
        }
        if ($filter_from_date != '') {
            $this->db->where('po.date >=', $filter_from_date);
        }
        if ($filter_to_date != '') {
            $this->db->where('po.date <=', $filter_to_date);
        }
        if ($cust_id != '') {
            $this->db->where('po.cust_id', $cust_id);
        }
        if ($module_id != '') {
            $this->db->where('po.module_id', $module_id);
        }
        if ($item_id != '') {
            $this->db->where('po.item_id', $item_id);
        }
        if ($shade_id != '') {
            $this->db->where('po.shade_id', $shade_id);
        }
        $this->db->where('po.status > 0');
        $this->db->order_by('po.poeno', 'desc');
        $query = $this->db->get();
        
        log_message('info', 'The purpose of some variable is to provide some value.');
        return $query->result_array();
    }

    function ak_po_list_accepted_customers($id, $filter_from_date, $filter_to_date, $cust_id, $module_id, $item_id, $shade_id)
    {
        $this->db->from('dost_customers_po_enquiry as po');
        $this->db->join('bud_customers as cus', 'cus.cust_id = po.cust_id');
        $this->db->join('dost_customers_po_accept as act', 'act.a_id = po.po_accept_no', 'left');
        $this->db->join('dost_customers_po_reject as reg', 'reg.r_id = po.po_reject_no', 'left');
        $this->db->join('dost_customers_po_sample as sam', 'sam.s_id = po.po_sample_no', 'left');
        if ($id != '') {
            $this->db->where('po.cust_id', $id);
        }
        if ($filter_from_date != '') {
            $this->db->where('po.date >=', $filter_from_date);
        }
        if ($filter_to_date != '') {
            $this->db->where('po.date <=', $filter_to_date);
        }
        if ($cust_id != '') {
            $this->db->where('po.cust_id', $cust_id);
        }
        if ($module_id != '') {
            $this->db->where('po.module_id', $module_id);
        }
        if ($item_id != '') {
            $this->db->where('po.item_id', $item_id);
        }
        if ($shade_id != '') {
            $this->db->where('po.shade_id', $shade_id);
        }
        $this->db->where('act.a_option > 0');
        $this->db->where('po.status > 0');
        $query = $this->db->get();
        return $query->result_array();
    }

    function ak_po_list_rejected_customers($id, $filter_from_date, $filter_to_date, $cust_id, $module_id, $item_id, $shade_id)
    {
        $this->db->from('dost_customers_po_enquiry as po');
        $this->db->join('bud_customers as cus', 'cus.cust_id = po.cust_id');
        $this->db->join('dost_customers_po_reject as reg', 'reg.r_id = po.po_reject_no', 'left');
        if ($id != '') {
            $this->db->where('po.cust_id', $id);
        }
        if ($filter_from_date != '') {
            $this->db->where('po.date >=', $filter_from_date);
        }
        if ($filter_to_date != '') {
            $this->db->where('po.date <=', $filter_to_date);
        }
        if ($cust_id != '') {
            $this->db->where('po.cust_id', $cust_id);
        }
        if ($module_id != '') {
            $this->db->where('po.module_id', $module_id);
        }
        if ($item_id != '') {
            $this->db->where('po.item_id', $item_id);
        }
        if ($shade_id != '') {
            $this->db->where('po.shade_id', $shade_id);
        }
        $this->db->where('po.status', 0);
        $query = $this->db->get();
        return $query->result_array();
    }

    function ak_po_list_accepted_customers_by_stock($filter_from_date, $filter_to_date, $cust_id, $module_id, $item_id, $shade_id)
    {
        $this->db->from('dost_customers_po_enquiry as po');
        $this->db->join('bud_customers as cus', 'cus.cust_id = po.cust_id');
        $this->db->join('dost_customers_po_accept as act', 'act.a_id = po.po_accept_no', 'left');
        $this->db->join('dost_customers_po_reject as reg', 'reg.r_id = po.po_reject_no', 'left');
        $this->db->join('dost_customers_po_sample as sam', 'sam.s_id = po.po_sample_no', 'left');

        if ($filter_from_date != '') {
            $this->db->where('po.date >=', $filter_from_date);
        }
        if ($filter_to_date != '') {
            $this->db->where('po.date <=', $filter_to_date);
        }
        if ($cust_id != '') {
            $this->db->where('po.cust_id', $cust_id);
        }
        if ($module_id != '') {
            $this->db->where('po.module_id', $module_id);
        }
        if ($item_id != '') {
            $this->db->where('po.item_id', $item_id);
        }
        if ($shade_id != '') {
            $this->db->where('po.shade_id', $shade_id);
        }
        $this->db->where('act.a_option', 1);
        $this->db->where('po.status > 0');
        $query = $this->db->get();
        return $query->result_array();
    }

    function ak_po_list_accepted_customers_by_dyeing($filter_from_date, $filter_to_date, $cust_id, $module_id, $item_id, $shade_id)
    {
        $this->db->from('dost_customers_po_enquiry as po');
        $this->db->join('bud_customers as cus', 'cus.cust_id = po.cust_id');
        $this->db->join('dost_customers_po_accept as act', 'act.a_id = po.po_accept_no', 'left');
        $this->db->join('dost_customers_po_reject as reg', 'reg.r_id = po.po_reject_no', 'left');
        $this->db->join('dost_customers_po_sample as sam', 'sam.s_id = po.po_sample_no', 'left');
        if ($filter_from_date != '') {
            $this->db->where('po.date >=', $filter_from_date);
        }
        if ($filter_to_date != '') {
            $this->db->where('po.date <=', $filter_to_date);
        }
        if ($cust_id != '') {
            $this->db->where('po.cust_id', $cust_id);
        }
        if ($module_id != '') {
            $this->db->where('po.module_id', $module_id);
        }
        if ($item_id != '') {
            $this->db->where('po.item_id', $item_id);
        }
        if ($shade_id != '') {
            $this->db->where('po.shade_id', $shade_id);
        }
        $this->db->where('(act.a_option = 2 OR act.a_option = 3)');
        $this->db->where('po.status > 0');
        $query = $this->db->get();
        return $query->result_array();
    }

    function ak_po_list_accepted_customers_by_sampling($filter_from_date, $filter_to_date, $cust_id, $module_id, $item_id, $shade_id)
    {
        $this->db->from('dost_customers_po_enquiry as po');
        $this->db->join('bud_customers as cus', 'cus.cust_id = po.cust_id');
        $this->db->join('dost_customers_po_accept as act', 'act.a_id = po.po_accept_no', 'left');
        $this->db->join('dost_customers_po_reject as reg', 'reg.r_id = po.po_reject_no', 'left');
        $this->db->join('dost_customers_po_sample as sam', 'sam.s_id = po.po_sample_no', 'left');
        if ($filter_from_date != '') {
            $this->db->where('po.date >=', $filter_from_date);
        }
        if ($filter_to_date != '') {
            $this->db->where('po.date <=', $filter_to_date);
        }
        if ($cust_id != '') {
            $this->db->where('po.cust_id', $cust_id);
        }
        if ($module_id != '') {
            $this->db->where('po.module_id', $module_id);
        }
        if ($item_id != '') {
            $this->db->where('po.item_id', $item_id);
        }
        if ($shade_id != '') {
            $this->db->where('po.shade_id', $shade_id);
        }
        $this->db->where('(act.a_option = 2 OR act.a_option = 3)');
        $this->db->where('sam.s_option', 0);
        $this->db->where('sam.s_status', 1);
        $this->db->where('po.status > 0');
        $this->db->order_by('po.poeno', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    function ak_po_list_accepted_customers_by_sampling_completed($filter_from_date, $filter_to_date, $cust_id, $module_id, $item_id, $shade_id)
    {
        $this->db->from('dost_customers_po_enquiry as po');
        $this->db->join('bud_customers as cus', 'cus.cust_id = po.cust_id');
        $this->db->join('dost_customers_po_accept as act', 'act.a_id = po.po_accept_no', 'left');
        $this->db->join('dost_customers_po_reject as reg', 'reg.r_id = po.po_reject_no', 'left');
        $this->db->join('dost_customers_po_sample as sam', 'sam.s_id = po.po_sample_no', 'left');
        if ($filter_from_date != '') {
            $this->db->where('po.date >=', $filter_from_date);
        }
        if ($filter_to_date != '') {
            $this->db->where('po.date <=', $filter_to_date);
        }
        if ($cust_id != '') {
            $this->db->where('po.cust_id', $cust_id);
        }
        if ($module_id != '') {
            $this->db->where('po.module_id', $module_id);
        }
        if ($item_id != '') {
            $this->db->where('po.item_id', $item_id);
        }
        if ($shade_id != '') {
            $this->db->where('po.shade_id', $shade_id);
        }
        $this->db->where('(act.a_option = 2 OR act.a_option = 3)');
        $this->db->where('sam.s_option > 0 AND sam.s_option <> 3');
        $this->db->where('sam.s_status', 1);
        $this->db->where('po.status > 0');
        $this->db->order_by('po.poeno', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    function ak_po_list_accepted_customers_by_sampling_final($filter_from_date, $filter_to_date, $cust_id, $module_id, $item_id, $shade_id)
    {
        $this->db->from('dost_customers_po_enquiry as po');
        $this->db->join('bud_customers as cus', 'cus.cust_id = po.cust_id');
        $this->db->join('dost_customers_po_accept as act', 'act.a_id = po.po_accept_no', 'left');
        $this->db->join('dost_customers_po_reject as reg', 'reg.r_id = po.po_reject_no', 'left');
        $this->db->join('dost_customers_po_sample as sam', 'sam.s_id = po.po_sample_no', 'left');
        if ($filter_from_date != '') {
            $this->db->where('po.date >=', $filter_from_date);
        }
        if ($filter_to_date != '') {
            $this->db->where('po.date <=', $filter_to_date);
        }
        if ($cust_id != '') {
            $this->db->where('po.cust_id', $cust_id);
        }
        if ($module_id != '') {
            $this->db->where('po.module_id', $module_id);
        }
        if ($item_id != '') {
            $this->db->where('po.item_id', $item_id);
        }
        if ($shade_id != '') {
            $this->db->where('po.shade_id', $shade_id);
        }
        $this->db->where('(act.a_option = 2 OR act.a_option = 3)');
        $this->db->where('((sam.s_option > 0 AND sam.s_status = 3) OR (sam.s_option = 3 AND sam.s_status = 1))');
        //$this->db->where('sam.s_status', 3);
        $this->db->where('po.status > 0');
        $query = $this->db->get();
        return $query->result_array();
    }

    function ak_po_list_accepted_customers_by_dyeing_queue($filter_from_date, $filter_to_date, $cust_id, $module_id, $item_id, $shade_id)
    {
        $this->db->from('dost_customers_po_enquiry as po');
        $this->db->join('bud_customers as cus', 'cus.cust_id = po.cust_id');
        $this->db->join('dost_customers_po_accept as act', 'act.a_id = po.po_accept_no', 'left');
        $this->db->join('dost_customers_po_reject as reg', 'reg.r_id = po.po_reject_no', 'left');
        $this->db->join('dost_customers_po_sample as sam', 'sam.s_id = po.po_sample_no', 'left');
        $this->db->join('dost_customers_po_dyeplan as dpl', 'dpl.dy_poeno = po.poeno', 'left');
        if ($filter_from_date != '') {
            $this->db->where('po.date >=', $filter_from_date);
        }
        if ($filter_to_date != '') {
            $this->db->where('po.date <=', $filter_to_date);
        }
        if ($cust_id != '') {
            $this->db->where('po.cust_id', $cust_id);
        }
        if ($module_id != '') {
            $this->db->where('po.module_id', $module_id);
        }
        if ($item_id != '') {
            $this->db->where('po.item_id', $item_id);
        }
        if ($shade_id != '') {
            $this->db->where('po.shade_id', $shade_id);
        }
        $this->db->where('(act.a_option = 2 OR act.a_option = 3)');
        $this->db->where('(sam.s_status != 0)');
        $this->db->where('dpl.dy_poeno', null);
        $this->db->where('po.status > 0');
        $query = $this->db->get();
        return $query->result_array();
    }

    function ak_po_list_accepted_customers_by_dyeing_plan($filter_from_date, $filter_to_date, $cust_id, $module_id, $item_id, $shade_id)
    {
        $this->db->from('dost_customers_gpo as gpo');
        $this->db->join('dost_customers_po_dyeplan as dpl', 'dpl.dy_gpono = gpo.gpono', 'left');
        $this->db->join('dost_customers_po_enquiry as po', 'po.poeno = dpl.dy_poeno', 'left');
        $this->db->join('bud_customers as cus', 'cus.cust_id = po.cust_id', 'left');
        $this->db->join('dost_customers_po_accept as act', 'act.a_id = po.po_accept_no', 'left');
        $this->db->join('dost_customers_po_reject as reg', 'reg.r_id = po.po_reject_no', 'left');
        $this->db->join('dost_customers_po_sample as sam', 'sam.s_id = po.po_sample_no', 'left');
        if ($filter_from_date != '') {
            $this->db->where('po.date >=', $filter_from_date);
        }
        if ($filter_to_date != '') {
            $this->db->where('po.date <=', $filter_to_date);
        }
        if ($cust_id != '') {
            $this->db->where('po.cust_id', $cust_id);
        }
        if ($module_id != '') {
            $this->db->where('po.module_id', $module_id);
        }
        if ($item_id != '') {
            $this->db->where('po.item_id', $item_id);
        }
        if ($shade_id != '') {
            $this->db->where('po.shade_id', $shade_id);
        }
        $this->db->where('(act.a_option = 2 OR act.a_option = 3)');
        $this->db->where('(sam.s_status != 0)');
        $this->db->where('dpl.dy_poeno > 0');
        $this->db->where('po.status > 0');
        $this->db->group_by('gpo.gpono');
        $query = $this->db->get();
        return $query->result_array();
    }

    function ak_po_list_accepted_customers_by_dyeing_plan_by_gpo($gpono, $filter_from_date, $filter_to_date, $cust_id, $module_id, $item_id, $shade_id)
    {
        $this->db->from('dost_customers_gpo as gpo');
        $this->db->join('dost_customers_po_dyeplan as dpl', 'dpl.dy_gpono = gpo.gpono', 'left');
        $this->db->join('dost_customers_po_enquiry as po', 'po.poeno = dpl.dy_poeno', 'left');
        $this->db->join('bud_customers as cus', 'cus.cust_id = po.cust_id', 'left');
        $this->db->join('dost_customers_po_accept as act', 'act.a_id = po.po_accept_no', 'left');
        $this->db->join('dost_customers_po_reject as reg', 'reg.r_id = po.po_reject_no', 'left');
        $this->db->join('dost_customers_po_sample as sam', 'sam.s_id = po.po_sample_no', 'left');
        if ($filter_from_date != '') {
            $this->db->where('po.date >=', $filter_from_date);
        }
        if ($filter_to_date != '') {
            $this->db->where('po.date <=', $filter_to_date);
        }
        if ($cust_id != '') {
            $this->db->where('po.cust_id', $cust_id);
        }
        if ($module_id != '') {
            $this->db->where('po.module_id', $module_id);
        }
        if ($item_id != '') {
            $this->db->where('po.item_id', $item_id);
        }
        if ($shade_id != '') {
            $this->db->where('po.shade_id', $shade_id);
        }
        $this->db->where('gpo.gpono', $gpono);
        $this->db->where('(act.a_option = 2 OR act.a_option = 3)');
        $this->db->where('(sam.s_status != 0)');
        $this->db->where('dpl.dy_poeno > 0');
        $this->db->where('po.status > 0');
        $this->db->group_by('gpo.gpono');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_cust_po_enquiry($poeno)
    {
        $this->db->from('dost_customers_po_enquiry as po');
        $this->db->join('bud_customers as cus', 'cus.cust_id = po.cust_id');
        $this->db->join('dost_customers_po_accept as act', 'act.a_id = po.po_accept_no', 'left');
        $this->db->join('dost_customers_po_reject as reg', 'reg.r_id = po.po_reject_no', 'left');
        $this->db->join('dost_customers_po_sample as sam', 'sam.s_id = po.po_sample_no', 'left');
        $this->db->join('dost_customers_po_dyeplan as dpl', 'dpl.dy_poeno = po.poeno', 'left');
        $this->db->where('po.poeno', $poeno);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_cust_po_accept($poeno)
    {
        $this->db->from('dost_customers_po_accept');
        $this->db->where('a_poeno', $poeno);
        $this->db->order_by("a_id", "desc");
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_cust_po_sample($poeno)
    {
        $this->db->from('dost_customers_po_sample');
        $this->db->where('s_poeno', $poeno);
        $this->db->order_by("s_id", "desc");
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_cust_po_reject($poeno)
    {
        $this->db->from('dost_customers_po_reject');
        $this->db->where('r_poeno', $poeno);
        $this->db->order_by("r_id", "desc");
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_epo_by_gpo($gpoid)
    {
        $this->db->from('dost_customers_po_dyeplan');
        $this->db->where('dy_gpono', $gpoid);
        $this->db->where('dy_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_cust_gpo_totsum($gpoid)
    {
        $this->db->select_sum('dy_poqty');
        $this->db->from('dost_customers_po_dyeplan');
        $this->db->where('dy_gpono', $gpoid);
        $this->db->where('dy_status', 1);
        $query = $this->db->get();
        return ($query->row()->dy_poqty > 0) ? $query->row()->dy_poqty : 0;
    }

    function get_cust_gpo_prodsum($gpoid)
    {
        $this->db->select_sum('dyl_poqty');
        $this->db->from('dost_customers_po_dyelot');
        $this->db->where('dyl_gpono', $gpoid);
        //$this->db->where('dyl_status', 1);
        $query = $this->db->get();
        return ($query->row()->dyl_poqty > 0) ? $query->row()->dyl_poqty : 0;
    }

    function get_cust_gpo_prod_dyelot($gpoid, $status = 1)
    {
        $this->db->from('dost_customers_po_dyelot');
        $this->db->where('dyl_gpono', $gpoid);
        $this->db->where('dyl_status', $status);
        $query = $this->db->get();
        return $query->result_array();
    }

    function dost_customers_po_dyelotstatus($dyla_lotno)
    {
        $this->db->from('dost_customers_po_dyelotstatus');
        $this->db->where('dyla_lotno', $dyla_lotno);
        $query = $this->db->get();
        return $query->result_array();
    }

    function dost_customers_po_dyelotstatusloop($dyla_lotno)
    {
        $this->db->from('dost_customers_po_dyelotstatus');
        $this->db->where('dyla_lotno', $dyla_lotno);
        $this->db->where('dyla_loop', 0);
        $query = $this->db->get();
        return $query->result_array();
    }
}
//echo $this->db->last_query(); die;
