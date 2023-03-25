<?php
class M_mycart extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    // Yarn And Thread
    // End Yarn and Thread
    function insertPoCartYt($data)
    {
        $this->db->insert('bud_yt_po_cart_temp', $data);
        return $this->db->insert_id();
    }
    function deletePoCartItemYt($rowid)
    {
        $this->db->where('rowid', $rowid);
        $this->db->delete('bud_yt_po_cart_temp');
        return true;
    }
    function deletePoCartYt($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->delete('bud_yt_po_cart_temp');
        return true;
    }
    function viewPoCartYt()
    {
        $this->db->select('bud_yt_po_cart_temp.*,bud_uoms.uom_name,bud_items.item_name,bud_shades.shade_name')
            ->from('bud_yt_po_cart_temp')
            ->join('bud_items', 'bud_items.item_id=bud_yt_po_cart_temp.item_id')
            ->join('bud_shades', 'bud_shades.shade_id=bud_yt_po_cart_temp.shade_id', 'left')
            ->join('bud_uoms', 'bud_uoms.uom_id=bud_yt_po_cart_temp.item_uom')
            ->where('bud_yt_po_cart_temp.module', $this->session->userdata('user_viewed'))
            ->where('bud_yt_po_cart_temp.user_id', $this->session->userdata('user_id'));
        $query = $this->db->get();
        return $query->result_array();
    }


    function insertPoInwCartYt($data)
    {
        $this->db->insert('bud_yt_poyinw_cart_temp', $data);
        return $this->db->insert_id();
    }
    function deletePoInwCartItemYt($rowid)
    {
        $this->db->where('rowid', $rowid);
        $this->db->delete('bud_yt_poyinw_cart_temp');
        return true;
    }
    function deletePoInwCartYt($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->delete('bud_yt_poyinw_cart_temp');
        return true;
    }
    function viewPoInwCartYt()
    {
        $this->db->select('bud_yt_poyinw_cart_temp.*,bud_suppliers.sup_name,bud_yt_poydeniers.denier_name,bud_poy_lots.poy_lot_no,bud_uoms.uom_name,bud_items.item_name')
            ->from('bud_yt_poyinw_cart_temp')
            ->join('bud_items', 'bud_items.item_id=bud_yt_poyinw_cart_temp.item_id', 'left')
            ->join('bud_suppliers', 'bud_suppliers.sup_id=bud_yt_poyinw_cart_temp.supplier_id', 'left')
            ->join('bud_yt_poydeniers', 'bud_yt_poydeniers.denier_id=bud_yt_poyinw_cart_temp.poy_denier', 'left')
            ->join('bud_poy_lots', 'bud_poy_lots.poy_lot_id=bud_yt_poyinw_cart_temp.poy_lot', 'left')
            ->join('bud_uoms', 'bud_uoms.uom_id=bud_yt_poyinw_cart_temp.item_uom', 'left')
            ->where('bud_yt_poyinw_cart_temp.module', $this->session->userdata('user_viewed'))
            ->where('bud_yt_poyinw_cart_temp.user_id', $this->session->userdata('user_id'));
        $query = $this->db->get();
        return $query->result_array();
    }
    function yarnDelCartItems()
    {
        $this->db->select('bud_yt_yarn_del_items_temp.*,bud_yt_poydeniers.denier_name,bud_deniermaster.denier_name as yarn_denier,bud_uoms.uom_name,bud_items.item_name')
            ->from('bud_yt_yarn_del_items_temp')
            ->join('bud_items', 'bud_items.item_id=bud_yt_yarn_del_items_temp.item_id')
            ->join('bud_yt_poydeniers', 'bud_yt_poydeniers.denier_id=bud_yt_yarn_del_items_temp.poy_denier')
            ->join('bud_deniermaster', 'bud_deniermaster.denier_id=bud_yt_yarn_del_items_temp.yarn_denier')
            ->join('bud_uoms', 'bud_uoms.uom_id=bud_yt_yarn_del_items_temp.uom')
            ->where('bud_yt_yarn_del_items_temp.user_id', $this->session->userdata('user_id'));
        $query = $this->db->get();
        return $query->result_array();
    }
    function poySalesCartItems()
    {
        $this->db->select('bud_yt_poy_sales_items_temp.*,bud_yt_poydeniers.denier_name,bud_poy_lots.poy_lot_no as yarn_denier,bud_uoms.uom_name,bud_items.item_name')
            ->from('bud_yt_poy_sales_items_temp')
            ->join('bud_items', 'bud_items.item_id=bud_yt_poy_sales_items_temp.item_id')
            ->join('bud_yt_poydeniers', 'bud_yt_poydeniers.denier_id=bud_yt_poy_sales_items_temp.poy_denier')
            ->join('bud_poy_lots', 'bud_poy_lots.poy_lot_id=bud_yt_poy_sales_items_temp.poy_lot')
            ->join('bud_uoms', 'bud_uoms.uom_id=bud_yt_poy_sales_items_temp.uom')
            ->where('bud_yt_poy_sales_items_temp.user_id', $this->session->userdata('user_id'));
        $query = $this->db->get();
        return $query->result_array();
    }
    // Start Tapes and Elastic  
    function insertCart($data)
    {
        $this->db->insert('bud_cart_items', $data);
        return $this->db->insert_id();
    }
    function deleteCartItem($rowid)
    {
        $this->db->where('rowid', $rowid);
        $this->db->delete('bud_cart_items');
        return true;
    }
    function deleteCart($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->delete('bud_cart_items');
        return true;
    }
    // End Tapes and Elastic
    // Star Labels
    function insertCartLbl($data)
    {
        $this->db->insert('bud_lbl_cart_items', $data);
        return $this->db->insert_id();
    }
    function deleteCartItemLbl($rowid)
    {
        $this->db->where('rowid', $rowid);
        $this->db->delete('bud_lbl_cart_items');
        return true;
    }
    function deleteCartLbl($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->delete('bud_lbl_cart_items');
        return true;
    }
    function truncateTable($table_name = null)
    {
        $this->db->truncate($table_name);
        return true;
    }
    // End Labels    
}
