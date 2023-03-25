<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Request_form extends CI_Controller
{
	public $data = array();
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');
		$this->load->helper('url');
		$this->load->helper('string');
		$this->load->model('m_masters');
		$this->load->model('m_users');
		$this->load->model('m_request_form');
		$this->load->model('m_reports');
		$this->load->model('m_delivery');

		if (!$this->session->userdata('logged_in')) {
			// Allow some methods?
			$allowed = array();
			if (!in_array($this->router->method, $allowed)) {
				redirect(base_url() . 'users/login', 'refresh');
			}
		}
	}

	// Request Form Master
	function send_req_email()
	{
		$this->load->library('form_validation');
		$data['activeTab'] = 'request_form';
		$data['activeItem'] = 'send_req_email';
		$data['page_title'] = 'Send Request Email To Customers';
		$data['request_forms'] = $this->m_masters->get_request_forms();
		if ($this->input->post('cust_merit')) {
			$cust_merit = $this->input->post('cust_merit');
			$data['customers'] = $this->m_request_form->get_customers($cust_merit);
		} else {
			$data['customers'] = $this->m_request_form->get_customers();
		}
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
		$this->load->view('send_req_email', $data);
	}

	function req_email_send()
	{
		/*echo "<pre>";
		print_r($_POST);
		echo "</pre>";*/
		$id = $this->input->post('id');
		$selected_email = $this->input->post('selected_email');

		$request_form	= $this->m_masters->get_request_form($id);
		$subject = $request_form->subject;
		$header = $request_form->header;
		$greetings = $request_form->greetings;
		$main_content = $request_form->main_content;
		$footer = $request_form->footer;

		$message_body = $header . '<br>';
		$message_body .= $main_content . '<br>';
		$message_body .= $footer;

		$mail_settings = $this->m_masters->get_mail_settings();

		$emaildata = '';

		$user_viewed = $this->session->userdata('user_viewed');
		$concern_name = '';
		if ($user_viewed == 1) {
			$concern_name = 'Indofila Synthetices';
		} elseif ($user_viewed == 2) {
			$concern_name = 'Shiva Tapes';
		} else {
			$concern_name = 'Dynamic Creations';
		}

		$this->m_request_form->sendEmail($selected_email, $subject, $message_body, 'Indofila Synthetices');

		$this->session->set_flashdata('success', 'Mail Successfully Sent');
		redirect(base_url('request_form/send_req_email'));
	}

	function sale_tax_email_yt()
	{
		$this->load->library('form_validation');
		$data['activeTab'] = 'request_form';
		$data['activeItem'] = 'sale_tax_email_lbl';
		$data['page_title'] = 'Send Request Email To Customers';
		$data['request_forms'] = $this->m_masters->get_request_forms();
		$data['customers'] = $this->m_request_form->get_customers();
		$data['invoices'] = $this->m_request_form->get_yt_invoices();
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
		$this->load->view('sale_tax_email_yt', $data);
	}

	function get_cust_invoice_yt($cust_id = false)
	{
		$return = array();
		$invoices = array();
		$result = $this->m_request_form->get_yt_invoices($cust_id);
		foreach ($result as $row) {
			$invoices[$row->invoice_id] = $row->invoice_no;
		}
		$return['invoices'] = $invoices;
		echo json_encode($return);
	}

	function get_invoice_cust_yt($invoice_id = false)
	{
		$return = array();
		$customer = array();
		$result = $this->m_request_form->get_yt_invoice_cust($invoice_id);
		$customer[$result->cust_id] = $result->cust_name;
		$return['customer'] = $customer;
		echo json_encode($return);
	}

	function send_tax_email_yt()
	{
		$email_to = array();
		$invoice_id = $this->input->post('invoice_id');
		$id = $this->input->post('id');
		$other_emails = $this->input->post('other_emails');
		if ($other_emails != '') {
			$email_to = explode(",", $other_emails);
		}

		$customer = $this->m_request_form->get_yt_cust_email($invoice_id);
		$cust_email = $customer->cust_email;
		$email_to[] = $cust_email;


		$request_form	= $this->m_masters->get_request_form($id);
		$subject = $request_form->subject;
		$header = $request_form->header;
		$greetings = $request_form->greetings;
		$main_content = $request_form->main_content;
		$footer = $request_form->footer;

		$message_body = '<p style="text-align:center;color:red;font-size:18px;">' . nl2br($header) . '</p>';
		$message_body .= '<p style="font-size:15px;font-family:Verdana, Geneva, sans-serif;color:#9C205F">' . nl2br($greetings) . '</p>';
		$message_body .= '<p style="font-size:15px;font-family:Verdana, Geneva, sans-serif;color:#9C205F">' . nl2br($main_content) . '</p>';
		$message_body .= '<p style="text-align:center;color:red;font-size:18px;">' . nl2br($footer) . '</p>';

		$mail_settings = $this->m_masters->get_mail_settings();

		$emaildata = '';
		$emaildata['invoice_id'] = $invoice_id;

		$message_body .= $this->load->view('v_1_invoice_email_tpl.php', $emaildata, true);

		$message_body .= $this->load->view('email/v_signature', $emaildata, true);

		$this->m_request_form->sendEmail($email_to, $subject, $message_body, 'Indofila Synthetices');
		$this->session->set_flashdata('success', 'Mail Successfully Sent');
		redirect(base_url('request_form/sale_tax_email_yt'));
	}

	function sale_tax_email_te()
	{
		$this->load->library('form_validation');
		$data['activeTab'] = 'request_form';
		$data['activeItem'] = 'sale_tax_email_te';
		$data['page_title'] = 'Send Request Email To Customers';
		$data['request_forms'] = $this->m_masters->get_request_forms();
		$data['customers'] = $this->m_request_form->get_customers();
		$data['invoices'] = $this->m_request_form->get_te_invoices();
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
		$this->load->view('sale_tax_email_te', $data);
	}

	function get_cust_invoice_te($cust_id = false)
	{
		$return = array();
		$invoices = array();
		$result = $this->m_request_form->get_te_invoices($cust_id);
		foreach ($result as $row) {
			$invoices[$row->invoice_id] = $row->invoice_no;
		}
		$return['invoices'] = $invoices;
		echo json_encode($return);
	}

	function get_invoice_cust_te($invoice_id = false)
	{
		$return = array();
		$customer = array();
		$result = $this->m_request_form->get_te_invoice_cust($invoice_id);
		$customer[$result->cust_id] = $result->cust_name;
		$return['customer'] = $customer;
		echo json_encode($return);
	}

	function send_tax_email_te()
	{
		$email_to = array();
		$invoice_id = $this->input->post('invoice_id');
		$id = $this->input->post('id');
		$other_emails = $this->input->post('other_emails');
		if ($other_emails != '') {
			$email_to = explode(",", $other_emails);
		}

		$customer = $this->m_request_form->get_te_cust_email($invoice_id);
		$cust_email = $customer->cust_email;
		$email_to[] = $cust_email;


		$request_form	= $this->m_masters->get_request_form($id);
		$subject = $request_form->subject;
		$header = $request_form->header;
		$greetings = $request_form->greetings;
		$main_content = $request_form->main_content;
		$footer = $request_form->footer;

		$message_body = '<p style="text-align:center;color:red;font-size:18px;">' . $header . '</p>';
		$message_body .= '<p>' . $greetings . '</p>';
		$message_body .= '<p>' . $main_content . '</p>';
		$message_body .= '<p style="text-align:right;color:purple;font-size:14px;">' . $footer . '</p>';

		$mail_settings = $this->m_masters->get_mail_settings();

		$emaildata = '';
		$emaildata['invoice_id'] = $invoice_id;

		$message_body .= $this->load->view('v_2_invoice_email_tpl.php', $emaildata, true);

		$message_body .= $this->load->view('email/v_signature', $emaildata, true);

		$this->m_request_form->sendEmail($email_to, $subject, $message_body, 'Shiva Tapes');
		$this->session->set_flashdata('success', 'Mail Successfully Sent');
		redirect(base_url('request_form/sale_tax_email_te'));
	}

	function sale_tax_email_lbl()
	{
		$this->load->library('form_validation');
		$data['activeTab'] = 'request_form';
		$data['activeItem'] = 'sale_tax_email_lbl';
		$data['page_title'] = 'Send Request Email To Customers';
		$data['request_forms'] = $this->m_masters->get_request_forms();
		$data['customers'] = $this->m_request_form->get_customers();
		$data['invoices'] = $this->m_request_form->get_lbl_invoices();
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
		$this->load->view('sale_tax_email_lbl', $data);
	}

	function get_cust_invoice_lbl($cust_id = false)
	{
		$return = array();
		$invoices = array();
		$result = $this->m_request_form->get_lbl_invoices($cust_id);
		foreach ($result as $row) {
			$invoices[$row->invoice_id] = $row->invoice_no;
		}
		$return['invoices'] = $invoices;
		echo json_encode($return);
	}

	function get_invoice_cust_lbl($invoice_id = false)
	{
		$return = array();
		$customer = array();
		$result = $this->m_request_form->get_lbl_invoice_cust($invoice_id);
		$customer[$result->cust_id] = $result->cust_name;
		$return['customer'] = $customer;
		echo json_encode($return);
	}

	function send_tax_email_lbl()
	{
		$email_to = array();
		$invoice_id = $this->input->post('invoice_id');
		$id = $this->input->post('id');
		$other_emails = $this->input->post('other_emails');
		if ($other_emails != '') {
			$email_to = explode(",", $other_emails);
		}

		$customer = $this->m_request_form->get_lbl_cust_email($invoice_id);
		$cust_email = $customer->cust_email;
		$email_to[] = $cust_email;


		$request_form	= $this->m_masters->get_request_form($id);
		$subject = $request_form->subject;
		$header = $request_form->header;
		$greetings = $request_form->greetings;
		$main_content = $request_form->main_content;
		$footer = $request_form->footer;

		$message_body = '<p style="text-align:center;color:red;font-size:18px;">' . $header . '</p>';
		$message_body .= '<p>' . $greetings . '</p>';
		$message_body .= '<p>' . $main_content . '</p>';
		$message_body .= '<p style="text-align:right;color:purple;font-size:14px;">' . $footer . '</p>';

		$mail_settings = $this->m_masters->get_mail_settings();

		$emaildata = '';
		$emaildata['invoice_id'] = $invoice_id;

		$message_body .= $this->load->view('labels/v_3_invoice_email_tpl.php', $emaildata, true);

		$message_body .= $this->load->view('email/v_signature', $emaildata, true);

		$this->m_request_form->sendEmail($email_to, $subject, $message_body, 'Dynamic Creations');
		$this->session->set_flashdata('success', 'Mail Successfully Sent');
		redirect(base_url('request_form/sale_tax_email_lbl'));
	}

	function test()
	{
		$this->m_request_form->sendEmail();
	}
}
