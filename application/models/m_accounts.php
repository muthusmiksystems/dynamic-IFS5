<?php
class M_accounts extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    function getCustomers()
    {
        $result = $this->db->get('bud_customers');
        return $result->result_array();
    }
    function getTotalAmount_yt($customer_id)
    {
        $total_amount = 0;
        $this->db->select('sum(net_amount) as total_amount');
        $this->db->where('customer', $customer_id);
        $this->db->from('bud_yt_invoices');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->total_amount;
        } else {
            return 0;
        }
    }
    function get_payment_yt($payment_id)
    {

        $result = $this->db->get_where('bud_yt_payment_log', array('payment_id' => $payment_id));
        return $result->row();
    }
    function get_payments_yt()
    {

        $this->db->join('bud_customers', 'bud_customers.cust_id=bud_yt_payment_log.customer_id', 'left');
        return $this->db->get('bud_yt_payment_log')->result();
    }
    function delete_payment_yt($payment_id)
    {
        $this->db->where(array('payment_id' => $payment_id))->delete('bud_yt_payment_log');
        return $payment_id;
    }
    function payment_save_yt($data)
    {
        if ($data['payment_id']) {
            $this->db->where('payment_id', $data['payment_id']);
            $this->db->update('bud_yt_payment_log', $data);
            return $data['payment_id'];
        } else {
            $this->db->insert('bud_yt_payment_log', $data);
            return $this->db->insert_id();
        }
    }
    function get_paid_amount_yt($customer_id)
    {
        $paid_amount = 0;
        $this->db->select('sum(amount) as paid_amount');
        $this->db->where('customer_id', $customer_id);
        $this->db->from('bud_yt_payment_log');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->paid_amount;
        } else {
            return 0;
        }
    }
}
