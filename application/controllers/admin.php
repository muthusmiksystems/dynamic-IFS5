<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends CI_Controller
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

	function rateconfirmation()
	{
		$data['activeTab'] = 'admin';
		$data['activeItem'] = 'rateconfirmation';
		$data['page_title'] = 'Rate Confirmation';
		$data['items'] = $this->m_masters->getallmaster('bud_te_items');
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
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
		$this->load->view('v_rateconfirmation.php', $data);
	}
	function rateconfirmation_save()
	{
		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';*/
		$direct_sales_rate = $this->input->post('direct_sales_rate');
		$customer = $this->input->post('customer');
		$item_name = $this->input->post('item_name');
		$item_code = $this->input->post('item_code');
		$item_rates = $this->input->post('item_rates');
		$item_rates = array_filter($item_rates);
		$item_rate_active = $this->input->post('item_rate_active');
		$description = $this->input->post('description');
		$rate_changed_by = $this->input->post('rate_changed_by');
		$rate_changed_on = $this->input->post('rate_changed_on');
		$formData = array(
			'customer_id' => $customer,
			'item_id' => $item_name,
			'item_rates' => implode(",", $item_rates),
			'item_rate_active' => $item_rate_active,
			'rate_changed_by' => implode(",", $rate_changed_by),
			'rate_changed_on' => implode(",", $rate_changed_on),
			'description' => implode(",", $description)
		);
		$rates = $this->m_admin->getitemrates($customer, $item_name);
		if ($rates) {
			foreach ($rates as $rate) {
				$rate_id = $rate['rate_id'];
			}
			$result = $this->m_purchase->updateDatas('bud_te_itemrates', 'rate_id', $rate_id, $formData);
		} else {
			$result = $this->m_purchase->saveDatas('bud_te_itemrates', $formData);
		}

		$updateItem = array('direct_sales_rate' => $direct_sales_rate);
		$this->m_purchase->updateDatas('bud_te_items', 'item_id', $item_name, $updateItem);

		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "admin/rateconfirmation", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "admin/rateconfirmation", 'refresh');
		}
	}
	function getItemRetes()
	{
		$customer = $this->input->post('customer');
		$item_name = $this->input->post('item_name');
		if ($customer != '' && $item_name != '') {
			$data['customer'] = $customer;
			$data['item_name'] = $item_name;
			$this->load->view('v_2_get-item-retes', $data);
		} else {
			echo 'error';
		}
	}
	function concernMaster()
	{
		$data['activeTab'] = 'admin';
		$data['activeItem'] = 'concernMaster';
		$data['page_title'] = 'Concern Master';
		$data['concerns'] = $this->m_masters->getmasterdetails('bud_concern_master', 'module', $this->session->userdata('user_viewed'));
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
			$this->load->view('v_concern-master.php', $data);
		} else {
			$data['concern_id'] = $this->uri->segment(3);
			$this->load->view('v_concern-master.php', $data);
		}
	}
	function saveConcernMaster()
	{
		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';*/
		$concern_id = $this->input->post('concern_id');
		$module_id = $this->input->post('module_id');
		$old_concern_name = $this->input->post('old_concern_name');
		$concern_name = $this->input->post('concern_name');
		$concern_second_name = $this->input->post('concern_second_name');
		$concern_prefix = $this->input->post('concern_prefix');
		$concern_address = $this->input->post('concern_address');
		$concern_gst = $this->input->post('concern_gst');

		$formData = array(
			'module' => $module_id,
			'concern_name' => $concern_name,
			'concern_second_name' => $concern_second_name,
			'concern_prefix' => $concern_prefix,
			'concern_address' => $concern_address,
			'concern_gst' => $concern_gst,
			'concern_active' => $this->input->post('concern_active'),
			'user' => $this->session->userdata('display_name'),
			'date' => date("Y-m-d H:i:s")
		);
		if ($old_concern_name != $concern_name) {
			$if_exist = $this->m_admin->check_concern_exist($module_id, $concern_name);
		} else {
			$if_exist = null;
		}
		if ($if_exist) {
			$this->session->set_flashdata('error', 'Concern Already Exist');
			redirect(base_url() . "admin/concernMaster", 'refresh');
		} else {
			if ($concern_id == '') {
				$result = $this->m_purchase->saveDatas('bud_concern_master', $formData);
			} else {
				$result = $this->m_purchase->updateDatas('bud_concern_master', 'concern_id', $concern_id, $formData);
			}
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "admin/concernMaster", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "admin/concernMaster", 'refresh');
			}
		}
	}

	// Labels
	function rate_master_3()
	{
		$data['activeTab'] = 'admin';
		$data['activeItem'] = 'rate_master_3';
		$data['page_title'] = 'Rate Confirmation';
		$data['items'] = $this->m_masters->getallmaster('bud_lbl_items');
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
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
		$this->load->view('labels/v_3_rate-master', $data);
	}
	function getItemRetes_3()
	{
		$customer = $this->input->post('customer');
		$item_name = $this->input->post('item_name');
		if ($customer != '' && $item_name != '') {
			$data['customer'] = $customer;
			$data['item_name'] = $item_name;
			$this->load->view('labels/v_3_get-item-retes', $data);
		} else {
			echo 'error';
		}
	}
	function save_rate_master_3()
	{
		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';*/
		$direct_sales_rate = $this->input->post('direct_sales_rate');
		$customer = $this->input->post('customer');
		$item_name = $this->input->post('item_name');
		$item_code = $this->input->post('item_code');
		$item_rates = $this->input->post('item_rates');
		$cut_seal = $this->input->post('rates_cut_seal');
		$center_fold = $this->input->post('rates_center_fold');
		$meter_fold = $this->input->post('rates_meter_fold');
		$end_fold = $this->input->post('rates_end_fold');
		$dye_cut = $this->input->post('rates_dye_cut');
		$changed_by = $this->input->post('rate_changed_by');
		$changed_on = $this->input->post('rate_changed_on');
		$item_rates = array_filter($item_rates);
		foreach ($item_rates as $key => $value) {
			$rates_cut_seal[$key] = $cut_seal[$key];
			$rates_center_fold[$key] = $center_fold[$key];
			$rates_dye_cut[$key] = $dye_cut[$key];
			$rates_meter_fold[$key] = $meter_fold[$key];
			$rates_end_fold[$key] = $end_fold[$key];
			$rate_changed_by[$key] = $changed_by[$key];
			$rate_changed_on[$key] = $changed_on[$key];
		}
		$item_rate_active = $this->input->post('item_rate_active');
		$item_rate_form = $this->input->post('item_rate_form');
		$description = $this->input->post('description');
		$formData = array(
			'customer_id' => $customer,
			'item_id' => $item_name,
			'item_rates' => implode(",", $item_rates),
			'item_rate_active' => $item_rate_active,
			'rates_cut_seal' => implode(",", $rates_cut_seal),
			'rates_center_fold' => implode(",", $rates_center_fold),
			'rates_dye_cut' => implode(",", $rates_dye_cut),
			'rates_meter_fold' => implode(",", $rates_meter_fold),
			'rates_end_fold' => implode(",", $rates_end_fold),
			'rate_changed_by' => implode(",", $rate_changed_by),
			'rate_changed_on' => implode(",", $rate_changed_on),
			'description' => implode(",", $description),
			'item_rate_form' => $item_rate_form
		);
		$rates = $this->m_admin->getitemrates_label($customer, $item_name);
		if ($rates) {
			foreach ($rates as $rate) {
				$rate_id = $rate['rate_id'];
			}
			$result = $this->m_purchase->updateDatas('bud_lbl_itemrates', 'rate_id', $rate_id, $formData);
		} else {
			$result = $this->m_purchase->saveDatas('bud_lbl_itemrates', $formData);
		}

		$updateItem = array('direct_sales_rate' => $direct_sales_rate);
		$this->m_purchase->updateDatas('bud_lbl_items', 'item_id', $item_name, $updateItem);

		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "admin/rate_master_3", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "admin/rate_master_3", 'refresh');
		}
	}

	// Yarn and Thred Rate Master
	function rate_master_1()
	{
		$data['activeTab'] = 'admin';
		$data['activeItem'] = 'rate_master_1';
		$data['page_title'] = 'Rate Confirmation';
		$data['items'] = $this->m_masters->getallmaster('bud_items');
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['shades'] = $this->m_masters->getactivemaster('bud_shades', 'shade_status');
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
		$this->load->view('v_1_rate-master', $data);
	}
	function getItemRetes_1()
	{
		$customer = $this->input->post('customer');
		$item_name = $this->input->post('item_name');
		$shade_id = $this->input->post('shade_id');
		if ($customer != '' && $item_name != '' && $shade_id != '') {
			$data['customer'] = $customer;
			$data['item_name'] = $item_name;
			$data['shade_id'] = $shade_id;
			$this->load->view('v_1_get-item-retes', $data);
		} else {
			echo 'error';
		}
	}
	function save_rate_master_1()
	{
		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';*/
		$item_rates = array();
		$rate_changed_by = array();
		$rate_changed_on = array();
		$description = array();

		$direct_sales_rate = $this->input->post('direct_sales_rate');
		$customer = $this->input->post('customer');
		$item_name = $this->input->post('item_name');
		$item_code = $this->input->post('item_code');
		$shade_id = $this->input->post('shade_id');
		$item_rates = $this->input->post('item_rates');
		if (count($item_rates) > 0) {
			$item_rates = array_filter($item_rates);
		}
		$item_rate_active = $this->input->post('item_rate_active');
		$description = $this->input->post('description');
		$rate_changed_by = $this->input->post('rate_changed_by');
		$rate_changed_on = $this->input->post('rate_changed_on');
		$formData = array(
			'customer_id' => $customer,
			'item_id' => $item_name,
			'shade_id' => $shade_id,
			'item_rates' => implode(",", $item_rates),
			'item_rate_active' => $item_rate_active,
			'rate_changed_by' => implode(",", $rate_changed_by),
			'rate_changed_on' => implode(",", $rate_changed_on),
			'description' => implode(",", $description)
		);
		$rates = $this->m_admin->getitemrates_yt($customer, $item_name, $shade_id);
		if ($rates) {
			foreach ($rates as $rate) {
				$rate_id = $rate['rate_id'];
			}
			$result = $this->m_purchase->updateDatas('bud_yt_itemrates', 'rate_id', $rate_id, $formData);
		} else {
			$result = $this->m_purchase->saveDatas('bud_yt_itemrates', $formData);
		}

		$updateItem = array('direct_sales_rate' => $direct_sales_rate);
		$this->m_purchase->updateDatas('bud_items', 'item_id', $item_name, $updateItem);

		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "admin/rate_master_1", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "admin/rate_master_1", 'refresh');
		}
	}
}
