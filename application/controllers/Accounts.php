<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Accounts extends CI_Controller
{
	public $data = array();
	var $payment_id	= false;
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');
		$this->load->helper('url');
		$this->load->helper('string');
		$this->load->model('m_masters');
		$this->load->model('m_users');
		$this->load->model('m_accounts');

		if (!$this->session->userdata('logged_in')) {
			// Allow some methods?
			$allowed = array();
			if (!in_array($this->router->method, $allowed)) {
				redirect(base_url() . 'users/login', 'refresh');
			}
		}
	}
	function cust_statement_yt()
	{
		$data['activeTab'] = 'accounts';
		$data['activeItem'] = 'cust_statement_yt';
		$data['page_title'] = 'Accounts :: Customer Account Statement';
		$data['customers'] = $this->m_accounts->getCustomers();
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

		$this->load->view('v_1_acc_cust_statement', $data);
	}
	function cust_payment_yt($payment_id = false)
	{
		$data['activeTab'] = 'accounts';
		$data['activeItem'] = 'cust_payment_yt';
		$data['page_title'] = 'Accounts :: Customer Payment';
		$data['customers'] = $this->m_accounts->getCustomers();
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

		$this->load->library('form_validation');

		$data['payment_id']			= '';
		$data['customer_id']		= '';
		$data['amount']				= '';
		$data['payment_mode']		= 'cash';
		$data['cheque_dd_no']		= '';
		$data['bank_name']			= '';
		$data['payment_date']		= date("d-m-Y");

		if ($payment_id) {
			$payment_log = $this->m_accounts->get_payment_yt($payment_id);
			if (!$payment_log) {
				$this->session->set_flashdata('error', 'No data found');
				redirect(base_url() . "accounts/cust_payment_yt");
			}

			//set values to db values
			$data['payment_id'] = $payment_log->payment_id;
			$data['customer_id'] = $payment_log->customer_id;
			$data['payment_mode'] = $payment_log->payment_mode;
			$data['cheque_dd_no'] = $payment_log->cheque_dd_no;
			$data['bank_name'] = $payment_log->bank_name;
			$data['amount'] = $payment_log->amount;
			$data['payment_date'] = date('d-m-Y', strtotime($payment_log->payment_date));
		}

		$this->form_validation->set_rules('customer_id', 'Customer Name', 'required');
		$this->form_validation->set_rules('payment_mode', 'Payment Mode', 'required');
		$this->form_validation->set_rules('amount', 'Amount', 'required|numeric');
		$this->form_validation->set_rules('payment_date', 'Payment Date', 'required|callback_checkDateFormat');

		if ($this->input->post('sumbit')) {
			$data['payment_id'] = $payment_id;
			$data['customer_id'] = $this->input->post('customer_id');
			$data['payment_mode'] = $this->input->post('payment_mode');
			$data['cheque_dd_no'] = $this->input->post('cheque_dd_no');
			$data['bank_name'] = $this->input->post('bank_name');
			$data['amount'] = $this->input->post('amount');
			$data['payment_date'] = $this->input->post('payment_date');
		}
		if ($this->form_validation->run() == FALSE) {
			$data['error'] = validation_errors();
			$this->load->view('v_1_acc_cust_payment', $data);
		} else {
			$save['payment_id'] = $payment_id;
			$save['customer_id'] = $this->input->post('customer_id');
			$save['payment_mode'] = $this->input->post('payment_mode');
			$save['cheque_dd_no'] = $this->input->post('cheque_dd_no');
			$save['bank_name'] = $this->input->post('bank_name');
			$save['amount'] = $this->input->post('amount');
			$save['payment_date'] = date('Y-m-d', strtotime($this->input->post('payment_date')));
			$result = $this->m_accounts->payment_save_yt($save);
			$this->session->set_flashdata('success', 'Successfully Saved');
			redirect(base_url() . "accounts/cust_payment_yt/");
		}
	}
	function checkDateFormat($date)
	{
		if (preg_match("/^[0-9]{2}-[0-9]{2}-[0-9]{4}$/", $date)) {
			if (checkdate(substr($date, 3, 2), substr($date, 0, 2), substr($date, 6, 4))) {
				return true;
			} else {
				$this->form_validation->set_message('checkDateFormat', 'Please Enter correct values in dd-mm-yyyy Format');
				return false;
			}
		} else {
			$this->form_validation->set_message('checkDateFormat', 'Please Enter correct values in dd-mm-yyyy Format');
			return false;
		}
	}
	function cust_payments_yt()
	{
		$data['activeTab'] = 'accounts';
		$data['activeItem'] = 'cust_payments_yt';
		$data['page_title'] = 'Accounts :: Customer Payments';
		$data['payments'] = $this->m_accounts->get_payments_yt();
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

		$this->load->view('v_1_acc_cust_payments', $data);
	}
	function delete_payment_yt($payment_id = false)
	{
		if ($payment_id) {
			$payment	= $this->m_accounts->get_payment_yt($payment_id);
			//if the payment does not exist, redirect them to the payment list with an error
			if (!$payment) {
				$this->session->set_flashdata('error', 'Record not found');
				redirect(base_url() . "accounts/cust_payments_yt");
			} else {
				//if the payment is legit, delete them
				$delete	= $this->m_accounts->delete_payment_yt($payment_id);

				$this->session->set_flashdata('success', 'Successfully Deleted');
				redirect(base_url() . "accounts/cust_payments_yt");
			}
		} else {
			//if they do not provide an id send them to the payment list page with an error
			$this->session->set_flashdata('error', lang('error_not_found'));
			redirect(base_url() . "accounts/cust_payments_yt");
		}
	}

	public function print_cash_receipt()
	{
		$data['activeTab'] = 'accounts';
		$data['activeItem'] = 'print_cash_receipt';
		$data['page_title'] = 'Shop Cash Receipt';
		$this->load->view('print-cash-receipt', $data);
	}
	public function print_cheque_receipt()
	{
		$data['activeTab'] = 'accounts';
		$data['activeItem'] = 'print_cash_receipt';
		$data['page_title'] = 'Shop Cash Receipt';
		$this->load->view('print-cheque-receipt', $data);
	}
	public function print_disc_voucher()
	{
		$data['activeTab'] = 'accounts';
		$data['activeItem'] = 'print_disc_voucher';
		$data['page_title'] = 'Shop Discount Voucher';
		$this->load->view('print-disc-voucher', $data);
	}
}
