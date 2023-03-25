<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Accounts extends CI_Controller
{
	public $data = array();
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');
		$this->load->helper('url');
		$this->load->helper('string');
		$this->load->model('m_users');
		$this->load->model('m_masters');
		$this->load->model('m_purchase');
		$this->load->library('cart');

		if (!$this->session->userdata('logged_in')) {
			// Allow some methods?
			$allowed = array();
			if (!in_array($this->router->method, $allowed)) {
				redirect(base_url() . 'users/login', 'refresh');
			}
		}
	}

	function customeropenbalance()
	{
		$data['activeTab'] = 'accounts';
		$data['activeItem'] = 'cust_open_bal';
		$data['page_title'] = 'Customer Opening Balance';
		$data['categories'] = $this->m_masters->getallcategories();
		$data['shades'] = $this->m_masters->getactiveCdatas('bud_shades', 'shade_status', 'shade_category', 1);
		$data['css'] = array(
			'css/bootstrap.min.css',
			'css/bootstrap-reset.css',
			'assets/font-awesome/css/font-awesome.css',
			'assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css',
			'css/owl.carousel.css',
			'css/style.css',
			'css/select2.css',
			'css/style-responsive.css',
			'assets/bootstrap-datepicker/css/datepicker.css'
		);
		$data['js_IE'] = array('js/html5shiv.js', 'js/respond.min.js');
		$data['js'] = array(
			'js/jquery.js',
			'js/jquery-1.8.3.min.js',
			'js/select2.js',
			'js/bootstrap.min.js',
			'js/jquery.scrollTo.min.js',
			'js/jquery.nicescroll.js',
			'js/bootstrap-switch.js',
			'js/jquery.tagsinput.js',
			'js/jquery.sparkline.js',
			'assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js',
			'js/owl.carousel.js',
			'js/jquery.customSelect.min.js',
			'assets/bootstrap-datepicker/js/bootstrap-datepicker.js',
			'assets/bootstrap-daterangepicker/date.js',
			'assets/bootstrap-daterangepicker/daterangepicker.js',
			'assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js',
			'js/jquery.validate.min.js',
			'assets/data-tables/jquery.dataTables.min.js',
			'assets/data-tables/DT_bootstrap.js'
		);
		$data['js_common'] = array('js/common-scripts.js');
		$data['js_thispage'] = array('js/form-validation-script.js', 'js/form-component.js', 'js/dynamic-table.js');
		if ($this->uri->segment(3) === FALSE) {
			$this->load->view('v_cust_openingbalance.php', $data);
		} else {
			$this->load->view('v_cust_openingbalance.php', $data);
		}
	}
	function savecustomeropenbalance()
	{
		$process_date = $this->input->post('process_date');
		$payment_category = $this->input->post('payment_category');
		$payment_customer = $this->input->post('payment_customer');
		$amount = $this->input->post('amount');
		$amount_type = $this->input->post('amount_type');
		$reffrence = $this->input->post('reffrence');
		$qd = explode("-", $process_date);
		$process_date = $qd[2] . '-' . $qd[1] . '-' . $qd[0];
		$payementData = array(
			'payment_date' => $process_date,
			'payment_category' => $payment_category,
			'payment_customer' => $payment_customer,
			'payment_amount' => $amount,
			'payment_type' => $amount_type,
			'payment_reference' => $reffrence
		);

		$result = $this->m_purchase->saveDatas('bud_cust_payments', $payementData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "accounts/customeropenbalance", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "accounts/customeropenbalance", 'refresh');
		}
	}
	function supplieropenbalance()
	{
		$data['activeTab'] = 'accounts';
		$data['activeItem'] = 'sup_open_bal';
		$data['page_title'] = 'Supplier Opening Balance';
		$data['categories'] = $this->m_masters->getallcategories();
		$data['shades'] = $this->m_masters->getactiveCdatas('bud_shades', 'shade_status', 'shade_category', 1);
		$data['css'] = array(
			'css/bootstrap.min.css',
			'css/bootstrap-reset.css',
			'assets/font-awesome/css/font-awesome.css',
			'assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css',
			'css/owl.carousel.css',
			'css/style.css',
			'css/select2.css',
			'css/style-responsive.css',
			'assets/bootstrap-datepicker/css/datepicker.css'
		);
		$data['js_IE'] = array('js/html5shiv.js', 'js/respond.min.js');
		$data['js'] = array(
			'js/jquery.js',
			'js/jquery-1.8.3.min.js',
			'js/select2.js',
			'js/bootstrap.min.js',
			'js/jquery.scrollTo.min.js',
			'js/jquery.nicescroll.js',
			'js/bootstrap-switch.js',
			'js/jquery.tagsinput.js',
			'js/jquery.sparkline.js',
			'assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js',
			'js/owl.carousel.js',
			'js/jquery.customSelect.min.js',
			'assets/bootstrap-datepicker/js/bootstrap-datepicker.js',
			'assets/bootstrap-daterangepicker/date.js',
			'assets/bootstrap-daterangepicker/daterangepicker.js',
			'assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js',
			'js/jquery.validate.min.js',
			'assets/data-tables/jquery.dataTables.min.js',
			'assets/data-tables/DT_bootstrap.js'
		);
		$data['js_common'] = array('js/common-scripts.js');
		$data['js_thispage'] = array('js/form-validation-script.js', 'js/form-component.js', 'js/dynamic-table.js');
		if ($this->uri->segment(3) === FALSE) {
			$this->load->view('v_sup_openingbalance.php', $data);
		} else {
			$this->load->view('v_sup_openingbalance.php', $data);
		}
	}
	function savesupplieropenbalance()
	{
		$process_date = $this->input->post('process_date');
		$payment_category = $this->input->post('payment_category');
		$payment_customer = $this->input->post('payment_customer');
		$amount = $this->input->post('amount');
		$amount_type = $this->input->post('amount_type');
		$reffrence = $this->input->post('reffrence');
		$qd = explode("-", $process_date);
		$process_date = $qd[2] . '-' . $qd[1] . '-' . $qd[0];
		$payementData = array(
			'payment_date' => $process_date,
			'payment_category' => $payment_category,
			'payment_customer' => $payment_customer,
			'payment_amount' => $amount,
			'payment_type' => $amount_type,
			'payment_reference' => $reffrence
		);

		$result = $this->m_purchase->saveDatas('bud_sup_payments', $payementData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "accounts/supplieropenbalance", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "accounts/supplieropenbalance", 'refresh');
		}
	}
	function supplierpayements($payment_customer = null)
	{
		$data['payments'] = $this->m_purchase->getDatas('bud_sup_payments', 'payment_customer', $payment_customer);
		$this->load->view('v_supplier_payments.php', $data);
	}
	function customerpayements($payment_customer = null)
	{
		$data['payments'] = $this->m_purchase->getDatas('bud_cust_payments', 'payment_customer', $payment_customer);
		$this->load->view('v_customer_payments.php', $data);
	}
	function cashpayment()
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_cashpayments'");
		$next = $next->row(0);

		$data['voucher_no'] = $next->Auto_increment;
		$data['activeTab'] = 'accounts';
		$data['activeItem'] = 'cashpayment';
		$data['page_title'] = 'Cash Payement';
		$data['categories'] = $this->m_masters->getallcategories();
		$data['shades'] = $this->m_masters->getactiveCdatas('bud_shades', 'shade_status', 'shade_category', 1);
		$data['css'] = array(
			'css/bootstrap.min.css',
			'css/bootstrap-reset.css',
			'assets/font-awesome/css/font-awesome.css',
			'assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css',
			'css/owl.carousel.css',
			'css/style.css',
			'css/select2.css',
			'css/style-responsive.css',
			'assets/bootstrap-datepicker/css/datepicker.css'
		);
		$data['js_IE'] = array('js/html5shiv.js', 'js/respond.min.js');
		$data['js'] = array(
			'js/jquery.js',
			'js/jquery-1.8.3.min.js',
			'js/select2.js',
			'js/bootstrap.min.js',
			'js/jquery.scrollTo.min.js',
			'js/jquery.nicescroll.js',
			'js/bootstrap-switch.js',
			'js/jquery.tagsinput.js',
			'js/jquery.sparkline.js',
			'assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js',
			'js/owl.carousel.js',
			'js/jquery.customSelect.min.js',
			'assets/bootstrap-datepicker/js/bootstrap-datepicker.js',
			'assets/bootstrap-daterangepicker/date.js',
			'assets/bootstrap-daterangepicker/daterangepicker.js',
			'assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js',
			'js/jquery.validate.min.js',
			'assets/data-tables/jquery.dataTables.min.js',
			'assets/data-tables/DT_bootstrap.js'
		);
		$data['js_common'] = array('js/common-scripts.js');
		$data['js_thispage'] = array('js/form-validation-script.js', 'js/form-component.js', 'js/dynamic-table.js');
		if ($this->uri->segment(3) === FALSE) {
			$this->load->view('v_cashpayment.php', $data);
		} else {
			$this->load->view('v_cashpayment.php', $data);
		}
	}
	function savecashpayment()
	{
		$payment_date = $this->input->post('payment_date');
		$payment_type = $this->input->post('payment_type');
		$payment_ac_head = $this->input->post('payment_ac_head');
		$payment_amount = $this->input->post('payment_amount');
		$payment_remarks = $this->input->post('payment_remarks');
		$qd = explode("-", $payment_date);
		$payment_date = $qd[2] . '-' . $qd[1] . '-' . $qd[0];
		$paymentData = array(
			'payment_date' => $payment_date,
			'payment_type' => $payment_type,
			'payment_ac_head' => $payment_ac_head,
			'payment_amount' => $payment_amount,
			'payment_remarks' => $payment_remarks
		);
		$result = $this->m_purchase->saveDatas('bud_cashpayments', $paymentData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "accounts/cashpayment", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "accounts/cashpayment", 'refresh');
		}
	}
	function cashreceipt()
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_cashreceipts'");
		$next = $next->row(0);

		$data['voucher_no'] = $next->Auto_increment;
		$data['activeTab'] = 'accounts';
		$data['activeItem'] = 'cashreceipt';
		$data['page_title'] = 'Cash Payement';
		$data['categories'] = $this->m_masters->getallcategories();
		$data['shades'] = $this->m_masters->getactiveCdatas('bud_shades', 'shade_status', 'shade_category', 1);
		$data['css'] = array(
			'css/bootstrap.min.css',
			'css/bootstrap-reset.css',
			'assets/font-awesome/css/font-awesome.css',
			'assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css',
			'css/owl.carousel.css',
			'css/style.css',
			'css/select2.css',
			'css/style-responsive.css',
			'assets/bootstrap-datepicker/css/datepicker.css'
		);
		$data['js_IE'] = array('js/html5shiv.js', 'js/respond.min.js');
		$data['js'] = array(
			'js/jquery.js',
			'js/jquery-1.8.3.min.js',
			'js/select2.js',
			'js/bootstrap.min.js',
			'js/jquery.scrollTo.min.js',
			'js/jquery.nicescroll.js',
			'js/bootstrap-switch.js',
			'js/jquery.tagsinput.js',
			'js/jquery.sparkline.js',
			'assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js',
			'js/owl.carousel.js',
			'js/jquery.customSelect.min.js',
			'assets/bootstrap-datepicker/js/bootstrap-datepicker.js',
			'assets/bootstrap-daterangepicker/date.js',
			'assets/bootstrap-daterangepicker/daterangepicker.js',
			'assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js',
			'js/jquery.validate.min.js',
			'assets/data-tables/jquery.dataTables.min.js',
			'assets/data-tables/DT_bootstrap.js'
		);
		$data['js_common'] = array('js/common-scripts.js');
		$data['js_thispage'] = array('js/form-validation-script.js', 'js/form-component.js', 'js/dynamic-table.js');
		if ($this->uri->segment(3) === FALSE) {
			$this->load->view('v_cashreceipt.php', $data);
		} else {
			$this->load->view('v_cashreceipt.php', $data);
		}
	}
	function savecashreceipt()
	{
		$payment_date = $this->input->post('payment_date');
		$payment_type = $this->input->post('payment_type');
		$payment_ac_head = $this->input->post('payment_ac_head');
		$payment_amount = $this->input->post('payment_amount');
		$payment_remarks = $this->input->post('payment_remarks');
		$qd = explode("-", $payment_date);
		$payment_date = $qd[2] . '-' . $qd[1] . '-' . $qd[0];
		$paymentData = array(
			'payment_date' => $payment_date,
			'payment_type' => $payment_type,
			'payment_ac_head' => $payment_ac_head,
			'payment_amount' => $payment_amount,
			'payment_remarks' => $payment_remarks
		);
		$result = $this->m_purchase->saveDatas('bud_cashreceipts', $paymentData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "accounts/cashreceipt", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "accounts/cashreceipt", 'refresh');
		}
	}
	function bankpayment()
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_bankpayments'");
		$next = $next->row(0);

		$data['voucher_no'] = $next->Auto_increment;
		$data['activeTab'] = 'accounts';
		$data['activeItem'] = 'bankpayment';
		$data['page_title'] = 'Bank Payment';
		$data['categories'] = $this->m_masters->getallcategories();
		$data['shades'] = $this->m_masters->getactiveCdatas('bud_shades', 'shade_status', 'shade_category', 1);
		$data['css'] = array(
			'css/bootstrap.min.css',
			'css/bootstrap-reset.css',
			'assets/font-awesome/css/font-awesome.css',
			'assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css',
			'css/owl.carousel.css',
			'css/style.css',
			'css/select2.css',
			'css/style-responsive.css',
			'assets/bootstrap-datepicker/css/datepicker.css'
		);
		$data['js_IE'] = array('js/html5shiv.js', 'js/respond.min.js');
		$data['js'] = array(
			'js/jquery.js',
			'js/jquery-1.8.3.min.js',
			'js/select2.js',
			'js/bootstrap.min.js',
			'js/jquery.scrollTo.min.js',
			'js/jquery.nicescroll.js',
			'js/bootstrap-switch.js',
			'js/jquery.tagsinput.js',
			'js/jquery.sparkline.js',
			'assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js',
			'js/owl.carousel.js',
			'js/jquery.customSelect.min.js',
			'assets/bootstrap-datepicker/js/bootstrap-datepicker.js',
			'assets/bootstrap-daterangepicker/date.js',
			'assets/bootstrap-daterangepicker/daterangepicker.js',
			'assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js',
			'js/jquery.validate.min.js',
			'assets/data-tables/jquery.dataTables.min.js',
			'assets/data-tables/DT_bootstrap.js'
		);
		$data['js_common'] = array('js/common-scripts.js');
		$data['js_thispage'] = array('js/form-validation-script.js', 'js/form-component.js', 'js/dynamic-table.js');
		if ($this->uri->segment(3) === FALSE) {
			$this->load->view('v_bankpayment.php', $data);
		} else {
			$this->load->view('v_bankpayment.php', $data);
		}
	}
	function savebankpayment()
	{
		$payment_date = $this->input->post('payment_date');
		$payment_bank = $this->input->post('payment_bank');
		$payment_type = $this->input->post('payment_type');
		$payment_ac_head = $this->input->post('payment_ac_head');
		$payment_mode = $this->input->post('payment_mode');
		$payment_mode_no = $this->input->post('payment_mode_no');
		$payment_amount = $this->input->post('payment_amount');
		$payment_remarks = $this->input->post('payment_remarks');
		$qd = explode("-", $payment_date);
		$payment_date = $qd[2] . '-' . $qd[1] . '-' . $qd[0];
		$paymentData = array(
			'payment_date' => $payment_date,
			'payment_bank' => $payment_bank,
			'payment_type' => $payment_type,
			'payment_ac_head' => $payment_ac_head,
			'payment_mode' => $payment_mode,
			'payment_mode_no' => $payment_mode_no,
			'payment_amount' => $payment_amount,
			'payment_remarks' => $payment_remarks
		);
		$result = $this->m_purchase->saveDatas('bud_bankpayments', $paymentData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "accounts/bankpayment", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "accounts/bankpayment", 'refresh');
		}
	}
	function debitnote()
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_debitnotes'");
		$next = $next->row(0);

		$data['voucher_no'] = $next->Auto_increment;
		$data['activeTab'] = 'accounts';
		$data['activeItem'] = 'debitnote';
		$data['page_title'] = 'Debit Note';
		$data['categories'] = $this->m_masters->getallcategories();
		$data['shades'] = $this->m_masters->getactiveCdatas('bud_shades', 'shade_status', 'shade_category', 1);
		$data['css'] = array(
			'css/bootstrap.min.css',
			'css/bootstrap-reset.css',
			'assets/font-awesome/css/font-awesome.css',
			'assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css',
			'css/owl.carousel.css',
			'css/style.css',
			'css/select2.css',
			'css/style-responsive.css',
			'assets/bootstrap-datepicker/css/datepicker.css'
		);
		$data['js_IE'] = array('js/html5shiv.js', 'js/respond.min.js');
		$data['js'] = array(
			'js/jquery.js',
			'js/jquery-1.8.3.min.js',
			'js/select2.js',
			'js/bootstrap.min.js',
			'js/jquery.scrollTo.min.js',
			'js/jquery.nicescroll.js',
			'js/bootstrap-switch.js',
			'js/jquery.tagsinput.js',
			'js/jquery.sparkline.js',
			'assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js',
			'js/owl.carousel.js',
			'js/jquery.customSelect.min.js',
			'assets/bootstrap-datepicker/js/bootstrap-datepicker.js',
			'assets/bootstrap-daterangepicker/date.js',
			'assets/bootstrap-daterangepicker/daterangepicker.js',
			'assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js',
			'js/jquery.validate.min.js',
			'assets/data-tables/jquery.dataTables.min.js',
			'assets/data-tables/DT_bootstrap.js'
		);
		$data['js_common'] = array('js/common-scripts.js');
		$data['js_thispage'] = array('js/form-validation-script.js', 'js/form-component.js', 'js/dynamic-table.js');
		if ($this->uri->segment(3) === FALSE) {
			$this->load->view('v_debitnote.php', $data);
		} else {
			$this->load->view('v_debitnote.php', $data);
		}
	}
	function savedebitnote()
	{
		$debit_date = $this->input->post('debit_date');
		$debit_reason = $this->input->post('debit_reason');
		$debit_ac_type = $this->input->post('debit_ac_type');
		$debit_ac_head = $this->input->post('debit_ac_head');
		$debit_bill_ref = $this->input->post('debit_bill_ref');
		$debit_amount = $this->input->post('debit_amount');
		$debit_remarks = $this->input->post('debit_remarks');
		$qd = explode("-", $debit_date);
		$debit_date = $qd[2] . '-' . $qd[1] . '-' . $qd[0];
		$debitData = array(
			'debit_date' => $debit_date,
			'debit_reason' => $debit_reason,
			'debit_ac_type' => $debit_ac_type,
			'debit_ac_head' => $debit_ac_head,
			'debit_bill_ref' => $debit_bill_ref,
			'debit_amount' => $debit_amount,
			'debit_remarks' => $debit_remarks
		);
		$result = $this->m_purchase->saveDatas('bud_debitnotes', $debitData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "accounts/debitnote", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "accounts/debitnote", 'refresh');
		}
	}
	function creditnote()
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_creditnotes'");
		$next = $next->row(0);

		$data['voucher_no'] = $next->Auto_increment;
		$data['activeTab'] = 'accounts';
		$data['activeItem'] = 'creditnote';
		$data['page_title'] = 'Credit Note';
		$data['categories'] = $this->m_masters->getallcategories();
		$data['shades'] = $this->m_masters->getactiveCdatas('bud_shades', 'shade_status', 'shade_category', 1);
		$data['css'] = array(
			'css/bootstrap.min.css',
			'css/bootstrap-reset.css',
			'assets/font-awesome/css/font-awesome.css',
			'assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css',
			'css/owl.carousel.css',
			'css/style.css',
			'css/select2.css',
			'css/style-responsive.css',
			'assets/bootstrap-datepicker/css/datepicker.css'
		);
		$data['js_IE'] = array('js/html5shiv.js', 'js/respond.min.js');
		$data['js'] = array(
			'js/jquery.js',
			'js/jquery-1.8.3.min.js',
			'js/select2.js',
			'js/bootstrap.min.js',
			'js/jquery.scrollTo.min.js',
			'js/jquery.nicescroll.js',
			'js/bootstrap-switch.js',
			'js/jquery.tagsinput.js',
			'js/jquery.sparkline.js',
			'assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js',
			'js/owl.carousel.js',
			'js/jquery.customSelect.min.js',
			'assets/bootstrap-datepicker/js/bootstrap-datepicker.js',
			'assets/bootstrap-daterangepicker/date.js',
			'assets/bootstrap-daterangepicker/daterangepicker.js',
			'assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js',
			'js/jquery.validate.min.js',
			'assets/data-tables/jquery.dataTables.min.js',
			'assets/data-tables/DT_bootstrap.js'
		);
		$data['js_common'] = array('js/common-scripts.js');
		$data['js_thispage'] = array('js/form-validation-script.js', 'js/form-component.js', 'js/dynamic-table.js');
		if ($this->uri->segment(3) === FALSE) {
			$this->load->view('v_creditnote.php', $data);
		} else {
			$this->load->view('v_creditnote.php', $data);
		}
	}
	function savecreditnote()
	{
		$credit_date = $this->input->post('credit_date');
		$credit_reason = $this->input->post('credit_reason');
		$credit_ac_type = $this->input->post('credit_ac_type');
		$credit_ac_head = $this->input->post('credit_ac_head');
		$credit_bill_ref = $this->input->post('credit_bill_ref');
		$credit_amount = $this->input->post('credit_amount');
		$credit_remarks = $this->input->post('credit_remarks');
		$qd = explode("-", $credit_date);
		$credit_date = $qd[2] . '-' . $qd[1] . '-' . $qd[0];
		$creditData = array(
			'credit_date' => $credit_date,
			'credit_reason' => $credit_reason,
			'credit_ac_type' => $credit_ac_type,
			'credit_ac_head' => $credit_ac_head,
			'credit_bill_ref' => $credit_bill_ref,
			'credit_amount' => $credit_amount,
			'credit_remarks' => $credit_remarks
		);
		$result = $this->m_purchase->saveDatas('bud_creditnotes', $creditData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "accounts/creditnote", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "accounts/creditnote", 'refresh');
		}
	}

	function chequecollection()
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_chequecollections'");
		$next = $next->row(0);

		$data['voucher_no'] = $next->Auto_increment;
		$data['activeTab'] = 'accounts';
		$data['activeItem'] = 'chequecollection';
		$data['page_title'] = 'Cheque Collection';
		$data['categories'] = $this->m_masters->getallcategories();
		$data['css'] = array(
			'css/bootstrap.min.css',
			'css/bootstrap-reset.css',
			'assets/font-awesome/css/font-awesome.css',
			'assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css',
			'css/owl.carousel.css',
			'css/style.css',
			'css/select2.css',
			'css/style-responsive.css',
			'assets/bootstrap-datepicker/css/datepicker.css'
		);
		$data['js_IE'] = array('js/html5shiv.js', 'js/respond.min.js');
		$data['js'] = array(
			'js/jquery.js',
			'js/jquery-1.8.3.min.js',
			'js/select2.js',
			'js/bootstrap.min.js',
			'js/jquery.scrollTo.min.js',
			'js/jquery.nicescroll.js',
			'js/bootstrap-switch.js',
			'js/jquery.tagsinput.js',
			'js/jquery.sparkline.js',
			'assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js',
			'js/owl.carousel.js',
			'js/jquery.customSelect.min.js',
			'assets/bootstrap-datepicker/js/bootstrap-datepicker.js',
			'assets/bootstrap-daterangepicker/date.js',
			'assets/bootstrap-daterangepicker/daterangepicker.js',
			'assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js',
			'js/jquery.validate.min.js',
			'assets/data-tables/jquery.dataTables.min.js',
			'assets/data-tables/DT_bootstrap.js'
		);
		$data['js_common'] = array('js/common-scripts.js');
		$data['js_thispage'] = array('js/form-validation-script.js', 'js/form-component.js', 'js/dynamic-table.js');
		if ($this->uri->segment(3) === FALSE) {
			$this->load->view('v_chequecollection.php', $data);
		} else {
			$this->load->view('v_chequecollection.php', $data);
		}
	}
	function savechequecollection()
	{
		$payment_date = $this->input->post('payment_date');
		$payment_bank = $this->input->post('payment_bank');
		$payment_party = $this->input->post('payment_party');
		$payment_mode_no = $this->input->post('payment_mode_no');
		$payment_status = $this->input->post('payment_status');
		$payment_amount = $this->input->post('payment_amount');
		$payment_remarks = $this->input->post('payment_remarks');
		$qd = explode("-", $payment_date);
		$payment_date = $qd[2] . '-' . $qd[1] . '-' . $qd[0];
		$formData = array(
			'payment_date' => $payment_date,
			'payment_bank' => $payment_bank,
			'payment_party' => $payment_party,
			'payment_status' => $payment_status,
			'payment_mode_no' => $payment_mode_no,
			'payment_amount' => $payment_amount,
			'payment_remarks' => $payment_remarks
		);
		$result = $this->m_purchase->saveDatas('bud_chequecollections', $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "accounts/chequecollection", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "accounts/chequecollection", 'refresh');
		}
	}
}
