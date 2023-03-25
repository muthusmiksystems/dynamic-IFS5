<?php
class M_marketing extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    function check_appoint_exist($time, $user_id)
    {
        $this->db->select('*')
            ->from('bud_mark_appointments')
            ->where('time', $time)
            ->where('user_id', $user_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function getAppointment($time, $user_id)
    {
        $this->db->select('*')
            ->from('bud_mark_appointments')
            ->where('time', $time)
            ->where('user_id', $user_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function getPendingAppoint($user_id)
    {
        $this->db->select('*')
            ->from('bud_mark_appointments')
            ->where('user_id', $user_id)
            ->where('status', 1)
            ->or_where('status', 3);
        $query = $this->db->get();
        return $query->result_array();
    }
    function check_budget_exist($budget_month, $user_id)
    {
        $this->db->select('*')
            ->from('bud_mark_collection_budget')
            ->where('budget_month', $budget_month)
            ->where('user_id', $user_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function updatebudget($budget_month, $user_id, $data)
    {
        $this->db->where('budget_month', $budget_month);
        $this->db->where('user_id', $user_id);
        $this->db->update('bud_mark_collection_budget', $data);
        return true;
    }
    function getCollecBudget($budget_month, $user_id)
    {
        $this->db->select('*')
            ->from('bud_mark_collection_budget')
            ->where('budget_month', $budget_month)
            ->where('user_id', $user_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function getSalesBudgetItems($sales_month, $user_id)
    {
        $this->db->select('*')
            ->from('bud_mark_sales_budget')
            ->where('sales_month', $sales_month)
            ->where('user_id', $user_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function getInvoices($user_id)
    {
        $this->db->select('*')
            ->from('bud_te_invoices')
            ->where('`customer` IN (SELECT `cust_id` FROM `bud_customers` WHERE `cust_agent`=' . $user_id . ')', NULL, FALSE);
        $query = $this->db->get();
        return $query->result_array();
    }
}
