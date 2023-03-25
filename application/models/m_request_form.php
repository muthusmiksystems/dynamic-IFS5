<?php
class M_request_form extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function sendEmail($list = array(), $subject = '', $message = '', $condern_name = '')
    {
        /*$ci = get_instance();
        $ci->load->library('email');
        $config['protocol'] = "smtp";
        $config['smtp_host'] = "ssl://smtp.gmail.com";
        $config['smtp_port'] = "465";
        $config['smtp_user'] = "mahesh@dynamicdost.com"; 
        $config['smtp_pass'] = "#ddc7861";
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        $ci->email->initialize($config);
        $ci->email->from('mahesh@dynamicdost.com', $condern_name);
        $ci->email->to($list);
        $this->email->reply_to('mahesh@dynamicdost.com', $condern_name);
        $ci->email->subject($subject);
        $ci->email->message($message);*/

        $this->load->library('email');
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);



        $this->email->from('mahesh@dynamicdost.com', $condern_name);
        $this->email->to($list);
        $this->email->reply_to('mahesh@dynamicdost.com', $condern_name);
        $this->email->subject($subject);
        $this->email->message($message);
        // $this->email->send();

        if ($this->email->send()) {
            return true;
            // echo 'Your email was sent, thanks chamil.';
        } else {
            return false;
            // show_error($this->email->print_debugger());
        }
    }

    function get_customer($cust_id)
    {
        return $this->db->get_where('bud_customers', array('cust_id' => $cust_id))->row();
    }
    function get_customers($cust_merit = false)
    {
        if (!empty($cust_merit)) {
            $this->db->where('cust_merit', $cust_merit);
        }
        return $this->db->get_where('bud_customers')->result();
    }
    function get_te_invoices($cust_id = false)
    {
        if (!empty($cust_id)) {
            $this->db->where('customer', $cust_id);
        }
        return $this->db->get_where('bud_te_invoices')->result();
    }

    function get_te_invoice_cust($invoice_id = false)
    {
        $this->db->join('bud_customers', 'bud_te_invoices.customer = bud_customers.cust_id');
        if (!empty($invoice_id)) {
            $this->db->where('bud_te_invoices.invoice_id', $invoice_id);
        }
        return $this->db->get_where('bud_te_invoices')->row();
    }

    function get_te_cust_email($invoice_id = false)
    {
        $this->db->join('bud_customers', 'bud_te_invoices.customer = bud_customers.cust_id');
        if (!empty($invoice_id)) {
            $this->db->where('bud_te_invoices.invoice_id', $invoice_id);
        }
        return $this->db->get_where('bud_te_invoices')->row();
    }

    function get_lbl_invoices($cust_id = false)
    {
        if (!empty($cust_id)) {
            $this->db->where('customer', $cust_id);
        }
        return $this->db->get_where('bud_lbl_invoices')->result();
    }

    function get_lbl_invoice_cust($invoice_id = false)
    {
        $this->db->join('bud_customers', 'bud_lbl_invoices.customer = bud_customers.cust_id');
        if (!empty($invoice_id)) {
            $this->db->where('bud_lbl_invoices.invoice_id', $invoice_id);
        }
        return $this->db->get_where('bud_lbl_invoices')->row();
    }

    function get_lbl_cust_email($invoice_id = false)
    {
        $this->db->join('bud_customers', 'bud_lbl_invoices.customer = bud_customers.cust_id');
        if (!empty($invoice_id)) {
            $this->db->where('bud_lbl_invoices.invoice_id', $invoice_id);
        }
        return $this->db->get_where('bud_lbl_invoices')->row();
    }

    // Yarn
    function get_yt_invoices($cust_id = false)
    {
        if (!empty($cust_id)) {
            $this->db->where('customer', $cust_id);
        }
        return $this->db->get_where('bud_yt_invoices')->result();
    }

    function get_yt_invoice_cust($invoice_id = false)
    {
        $this->db->join('bud_customers', 'bud_yt_invoices.customer = bud_customers.cust_id');
        if (!empty($invoice_id)) {
            $this->db->where('bud_yt_invoices.invoice_id', $invoice_id);
        }
        return $this->db->get_where('bud_yt_invoices')->row();
    }

    function get_yt_cust_email($invoice_id = false)
    {
        $this->db->join('bud_customers', 'bud_yt_invoices.customer = bud_customers.cust_id');
        if (!empty($invoice_id)) {
            $this->db->where('bud_yt_invoices.invoice_id', $invoice_id);
        }
        return $this->db->get_where('bud_yt_invoices')->row();
    }
}
