<?php
class Scrapsales_model extends CI_Model {
  	function __construct()
    {
        parent::__construct();
    }

    public function save_scrapsales($save, $quotation_ids = array())
    {
        $invoice_id = false;
        if($save['invoice_id'])
        {
            $this->db->where('invoice_id', $save['invoice_id']);
            $this->db->update('bud_sh_scrapsales', $save);
            $invoice_id = $save['invoice_id'];
        }
        else
        {
            $this->db->insert('bud_sh_scrapsales', $save);
            $invoice_id = $this->db->insert_id();
        }

        if(count($quotation_ids) > 0)
        {
            foreach ($quotation_ids as $quotation_id) {
                $quotation['quotation_id'] = $quotation_id;
                $quotation['is_scrapsales'] = 2;
                $this->Sales_model->update_quotation($quotation);
            }
        }
        return $invoice_id;
    }

    public function update_scrap_inv_amt($save)
    {
        if($save['invoice_id'])
        {
            $this->db->where('invoice_id', $save['invoice_id']);
            $this->db->update('bud_sh_scrapsales', $save);
            $invoice_id = $save['invoice_id'];
        }
    }

    public function get_scrap_invoice_list()
    {
        $this->db->select('bud_sh_scrapsales.*');
        $this->db->select('bud_concern_master.*');
        $this->db->select('bud_customers.cust_name,bud_customers.cust_address,bud_customers.cust_tinno,bud_customers.cust_cst,bud_customers.cust_city');
        $this->db->select('del_to.cust_name as del_cust_name,del_to.cust_address as del_cust_address,del_to.cust_tinno as del_cust_tinno,del_to.cust_cst as del_cust_cst,del_to.cust_cst as del_cust_city');
        $this->db->join('bud_concern_master', 'bud_sh_scrapsales.concern_id=bud_concern_master.concern_id', 'left');
        $this->db->join('bud_customers', 'bud_sh_scrapsales.customer_id=bud_customers.cust_id', 'left');
        $this->db->join('bud_customers del_to', 'bud_sh_scrapsales.delivery_to=del_to.cust_id', 'left');
        return $this->db->get('bud_sh_scrapsales')->result();
    }

    public function get_scrap_invoice($invoice_id)
    {
        $this->db->select('bud_sh_scrapsales.*');
        $this->db->select('bud_concern_master.*');
        $this->db->select('bud_customers.cust_name,bud_customers.cust_address,bud_customers.cust_tinno,bud_customers.cust_cst,bud_customers.cust_city');
        $this->db->select('del_to.cust_name as del_cust_name,del_to.cust_address as del_cust_address,del_to.cust_tinno as del_cust_tinno,del_to.cust_cst as del_cust_cst,del_to.cust_cst as del_cust_city');
        $this->db->join('bud_concern_master', 'bud_sh_scrapsales.concern_id=bud_concern_master.concern_id', 'left');
        $this->db->join('bud_customers', 'bud_sh_scrapsales.customer_id=bud_customers.cust_id', 'left');
        $this->db->join('bud_customers del_to', 'bud_sh_scrapsales.delivery_to=del_to.cust_id', 'left');
        $this->db->where('bud_sh_scrapsales.invoice_id', $invoice_id);
        return $this->db->get('bud_sh_scrapsales')->row();
    }
}