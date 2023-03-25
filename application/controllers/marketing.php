<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Marketing extends CI_Controller
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
		$this->load->model('m_production');
		$this->load->model('m_general');
		$this->load->model('m_marketing');
		$this->load->model('m_admin');
		$this->load->library('cart');

		if (!$this->session->userdata('logged_in')) {
			// Allow some methods?
			$allowed = array();
			if (!in_array($this->router->method, $allowed)) {
				redirect(base_url() . 'users/login', 'refresh');
			}
		}
	}
	function manageAppointments()
	{
		$data['activeTab'] = 'marketing';
		$data['activeItem'] = 'manageAppointments';
		$data['page_title'] = 'Manage Appointments';
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['staffs'] = $this->m_masters->getactivemaster('bud_users', 'user_status');
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
		$this->load->view('v_mark-add-appointment.php', $data);
	}
	function updateAppoinements()
	{
		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';*/
		$time = $this->input->post('time');
		$customer_id = $this->input->post('customer_id');
		$purpose_visit = $this->input->post('purpose_visit');
		$status = $this->input->post('status');
		foreach ($purpose_visit as $key => $value) {
			if ($value != '') {
				$formData = array(
					'user_id' => $this->session->userdata('user_id'),
					'date' => date("Y-m-d"),
					'time' => $time[$key],
					'customer_id' => $customer_id[$key],
					'purpose_visit' => $purpose_visit[$key]
					// 'status' => $status[$key]
				);
				$if_exist = $this->m_marketing->check_appoint_exist($time[$key], $this->session->userdata('user_id'));
				if ($if_exist) {
					$this->m_masters->updatemaster('bud_mark_appointments', 'time', $time[$key], $formData);
				} else {
					$this->m_purchase->saveDatas('bud_mark_appointments', $formData);
				}
			}
		}
		$this->session->set_flashdata('success', 'Successfully Updated!!!');
		redirect(base_url() . "marketing/manageAppointments", 'refresh');
	}
	function dailyPlans()
	{
		$data['activeTab'] = 'marketing';
		$data['activeItem'] = 'dailyPlans';
		$data['page_title'] = 'Daily Plans';
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['staffs'] = $this->m_masters->getactivemaster('bud_users', 'user_status');
		$data['pending_works'] = $this->m_marketing->getPendingAppoint($this->session->userdata('user_id'));
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
		$this->load->view('v_mark-daily-plans.php', $data);
	}
	function dailyPlansUpdate()
	{
		$time = $this->input->post('time');
		$customer_id = $this->input->post('customer_id');
		$purpose_visit = $this->input->post('purpose_visit');
		$status = $this->input->post('status');

		foreach ($purpose_visit as $key => $value) {
			if ($value != '') {
				$formData = array(
					'user_id' => $this->session->userdata('user_id'),
					'date' => date("Y-m-d"),
					'time' => $time[$key],
					'customer_id' => $customer_id[$key],
					'purpose_visit' => $purpose_visit[$key],
					'status' => $status[$key]
				);
				$this->m_masters->updatemaster('bud_mark_appointments', 'time', $time[$key], $formData);
			}
		}
		$this->session->set_flashdata('success', 'Successfully Updated!!!');
		redirect(base_url() . "marketing/dailyPlans", 'refresh');
	}
	function addVisitDetails()
	{
		$id = null;
		if ($this->uri->segment(3) == true) {
			$id = $this->uri->segment(3);
		} else {
			redirect(base_url() . "my404");
		}
		$data['activeTab'] = 'marketing';
		$data['activeItem'] = 'addVisitDetails';
		$data['page_title'] = 'Add Visit Details';
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['staffs'] = $this->m_masters->getactivemaster('bud_users', 'user_status');
		$data['pending_works'] = $this->m_masters->getmasterdetails('bud_mark_appointments', 'id', $id);
		$data['visits'] = $this->m_masters->getmasterdetails('bud_mark_visits_log', 'appointment_id', $id);
		$data['css'] = array(
			'css/bootstrap.min.css',
			'css/bootstrap-reset.css',
			'assets/font-awesome/css/font-awesome.css',
			'assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css',
			'css/owl.carousel.css',
			'css/style.css',
			'css/select2.css',
			'css/bootstrap-timepicker.min.css',
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
			'js/bootstrap-timepicker.js',
			'js/jquery.validate.min.js',
			'assets/data-tables/jquery.dataTables.min.js',
			'assets/data-tables/DT_bootstrap.js'
		);
		$data['js_common'] = array('js/common-scripts.js');
		$data['js_thispage'] = array('js/form-validation-script.js', 'js/form-component.js', 'js/dynamic-table.js');
		$this->load->view('v_mark-addvisit-details.php', $data);
	}
	function saveVisitDetails()
	{
		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';*/
		$id = $this->input->post('id');
		$visit_date = $this->input->post('visit_date');
		$visit_time = $this->input->post('visit_time');
		$visit_person = $this->input->post('visit_person');
		$status_person = $this->input->post('status_person');
		$status = $this->input->post('status');
		$details_meeting = $this->input->post('details_meeting');
		$qd = explode("-", $visit_date);
		$visit_date = $qd[2] . '-' . $qd[1] . '-' . $qd[0];
		$formData = array(
			'appointment_id' => $id,
			'visit_date' => $visit_date,
			'visit_time' => $visit_time,
			'visit_person' => $visit_person,
			'status_person' => $status_person,
			'details_meeting' => $details_meeting
		);
		$result = $this->m_purchase->saveDatas('bud_mark_visits_log', $formData);
		if ($result) {
			$updateData = array(
				'status' => $status
			);
			$this->m_masters->updatemaster('bud_mark_appointments', 'id', $id, $updateData);
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "marketing/addVisitDetails/" . $id, 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "marketing/dailyPlans", 'refresh');
		}
	}
	function targetSalesReceipt()
	{
		$is_admin = $this->m_users->is_admin($this->session->userdata('user_id'));
		if ($is_admin) {
			if ($this->uri->segment(3) == true) {
				$data['staff_id'] = $this->uri->segment(3);
			} else {
				$data['staff_id'] = $this->session->userdata('user_id');
			}
		} else {
			$data['staff_id'] = $this->session->userdata('user_id');
		}
		$data['activeTab'] = 'marketing';
		$data['activeItem'] = 'targetSalesReceipt';
		$data['page_title'] = 'Collection Budget';
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['users'] = $this->m_masters->getactivemaster('bud_users', 'user_status');
		// $data['collections'] = $this->m_marketing->getCollecBudget(date("Y-m"), $this->session->userdata('user_id'));
		$data['css'] = array(
			'css/bootstrap.min.css',
			'css/bootstrap-reset.css',
			'assets/font-awesome/css/font-awesome.css',
			'assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css',
			'css/owl.carousel.css',
			'css/style.css',
			'css/select2.css',
			'css/bootstrap-timepicker.min.css',
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
			'js/bootstrap-timepicker.js',
			'js/jquery.validate.min.js',
			'assets/data-tables/jquery.dataTables.min.js',
			'assets/data-tables/DT_bootstrap.js'
		);
		$data['js_common'] = array('js/common-scripts.js');
		$data['js_thispage'] = array('js/form-validation-script.js', 'js/form-component.js', 'js/dynamic-table.js');
		$this->load->view('v_mark-target-sales-receipt.php', $data);
	}
	function saveCollecBudget()
	{
		/*echo '<pre>';
		print_r($_POST);
		echo date("Y-m");
		echo '</pre>';*/
		$selected_invoices = $this->input->post('selected_invoices');
		$amounts = $this->input->post('amounts');
		$physical_collection = $this->input->post('physical_collection');
		$selected_amts = array();
		$collected_amts = array();
		foreach ($selected_invoices as $key => $value) {
			$selected_amts[] = $amounts[$value];
			$collected_amts[] = $physical_collection[$value];
		}
		if ($selected_invoices) {
			$formData = array(
				'user_id' => $this->session->userdata('user_id'),
				'budget_month' => date("Y-m"),
				'selected_invoices' => implode(",", $selected_invoices),
				'amounts' => implode(",", $selected_amts),
				'physical_collection' => implode(",", $collected_amts)
			);
			$if_exist = $this->m_marketing->check_budget_exist(date("Y-m"), $this->session->userdata('user_id'));
			if ($if_exist) {
				$this->m_marketing->updatebudget(date("Y-m"), $this->session->userdata('user_id'), $formData);
			} else {
				$this->m_purchase->saveDatas('bud_mark_collection_budget', $formData);
			}
			$this->session->set_flashdata('success', 'Successfully Updated!!!');
			redirect(base_url() . "marketing/targetSalesReceipt", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "marketing/targetSalesReceipt", 'refresh');
		}
	}
	function salesBudget()
	{
		$data['activeTab'] = 'marketing';
		$data['activeItem'] = 'salesBudget';
		$data['page_title'] = 'Sales Budget';
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['items'] = $this->m_masters->getactivemaster('bud_te_items', 'item_status');
		$data['salesItems'] = $this->m_marketing->getSalesBudgetItems(date("Y-m"), $this->session->userdata('user_id'));
		$data['css'] = array(
			'css/bootstrap.min.css',
			'css/bootstrap-reset.css',
			'assets/font-awesome/css/font-awesome.css',
			'assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css',
			'css/owl.carousel.css',
			'css/style.css',
			'css/select2.css',
			'css/bootstrap-timepicker.min.css',
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
			'js/bootstrap-timepicker.js',
			'js/jquery.validate.min.js',
			'assets/data-tables/jquery.dataTables.min.js',
			'assets/data-tables/DT_bootstrap.js'
		);
		$data['js_common'] = array('js/common-scripts.js');
		$data['js_thispage'] = array('js/form-validation-script.js', 'js/form-component.js', 'js/dynamic-table.js');
		$this->load->view('v_mark-sales-budget.php', $data);
	}
	function addSalesBudget()
	{
		$sales_month = date("Y-m");
		$party_name = $this->input->post('party_name');
		$item_name = $this->input->post('item_name');
		$item_qty = $this->input->post('item_qty');
		$rates = $this->m_admin->getitemrates($party_name, $item_name);
		if ($rates) {
			foreach ($rates as $rate) {
				$item_rates = explode(",", $rate['item_rates']);
				$item_rate_active = $rate['item_rate_active'];
			}
			$item_rate = $item_rates[$item_rate_active];
		} else {
			$item_rate = $this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $item_name, 'direct_sales_rate');
		}
		$formData = array(
			'sales_month' => $sales_month,
			'user_id' => $this->session->userdata('user_id'),
			'party_name' => $party_name,
			'item_name' => $item_name,
			'item_qty' => $item_qty,
			'item_rate' => $item_rate
		);
		$this->m_purchase->saveDatas('bud_mark_sales_budget', $formData);
	}
	function updateSalesBudget()
	{
		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';*/
		$actual_qty = $this->input->post('actual_qty');
		foreach ($actual_qty as $key => $value) {
			$formData = array(
				'actual_qty' => $value
			);
			$this->m_masters->updatemaster('bud_mark_sales_budget', 'id', $key, $formData);
		}
		$this->session->set_flashdata('success', 'Successfully Updated!!!');
		redirect(base_url() . "marketing/salesBudget/", 'refresh');
	}
}
