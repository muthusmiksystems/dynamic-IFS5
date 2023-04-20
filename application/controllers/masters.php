<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Masters extends CI_Controller
{
	public $data = array();
	var $shade_id = false;
	var $category_id = false;
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');
		$this->load->helper('url');
		$this->load->helper('string');
		$this->load->model('m_users');
		$this->load->model('m_mir'); //ER-09-18#-62
		$this->load->model('m_masters');
		$this->load->model('m_purchase');
		$this->load->model('m_shop');
		$this->load->model('m_delivery');
		$this->load->library('encrypt');

		if (!$this->session->userdata('logged_in')) {
			// Allow some methods?
			$allowed = array(
				'login',
				'submitlogin',
				'forgotpassword',
				'getpassword',
				'resetpassword',
				'updatepassword'
			);
			if (!in_array($this->router->method, $allowed)) {
				redirect(base_url() . 'users/login', 'refresh');
			}
		}
	}
	function machines()
	{
		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'machines';
		$data['page_title'] = 'M/C Master';
		$data['departments'] = $this->m_masters->getallmaster('bud_yt_departments');
		$data['categories'] = $this->m_masters->getallcategories();
		$data['machines'] = $this->m_masters->getallmaster('bud_machines');
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
			$this->load->view('v_lotmachines.php', $data);
		} else {
			$data['machine_id'] = $this->uri->segment(3);
			$this->load->view('v_lotmachines.php', $data);
		}
	}

	function savemachine()
	{
		$machine_category = $this->input->post('machine_category');
		$machine_prefix = $this->input->post('machine_prefix');
		$machine_status = $this->input->post('machine_status');

		$formData = array(
			'machine_category' => $machine_category,
			'machine_prefix' => $machine_prefix,
			'machine_status' => $machine_status,
			'machine_name' => $this->input->post('machine_name'),
			'machine_production_capacity' => $this->input->post('machine_production_capacity'),
			'machine_water_capacity' => $this->input->post('machine_water_capacity'),
			'dyeing_machine_program_nos' => $this->input->post('dyeing_machine_program_nos'),
			'for_dyeing' => $this->input->post('for_dyeing'),
			'for_r_c' => $this->input->post('for_r_c'),
			'for_softner' => $this->input->post('for_softner'),
			'for_washing' => $this->input->post('for_washing'),
			'for_redyeing' => $this->input->post('for_redyeing'),
			'for_special_process' => $this->input->post('for_special_process'),
			'machine_production_capacity_lots' => $this->input->post('machine_production_capacity_lots'),
			'machine_production_capacity_kgs' => $this->input->post('machine_production_capacity_kgs'),
			'spindels_per_machine' => $this->input->post('spindels_per_machine'),
			'remarks' => $this->input->post('remarks')

		);
		$result = $this->m_masters->savemaster('bud_machines', $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "masters/machines", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/machines", 'refresh');
		}
	}

	function updatemachine()
	{
		$machine_id = $this->input->post('machine_id');
		$machine_category = $this->input->post('machine_category');
		$machine_prefix = $this->input->post('machine_prefix');
		$machine_status = $this->input->post('machine_status');
		$formData = array(
			'machine_category' => $machine_category,
			'machine_prefix' => $machine_prefix,
			'machine_status' => $machine_status,
			'machine_name' => $this->input->post('machine_name'),
			'machine_production_capacity' => $this->input->post('machine_production_capacity'),
			'machine_water_capacity' => $this->input->post('machine_water_capacity'),
			'dyeing_machine_program_nos' => $this->input->post('dyeing_machine_program_nos'),
			'for_dyeing' => $this->input->post('for_dyeing'),
			'for_r_c' => $this->input->post('for_r_c'),
			'for_softner' => $this->input->post('for_softner'),
			'for_washing' => $this->input->post('for_washing'),
			'for_redyeing' => $this->input->post('for_redyeing'),
			'for_special_process' => $this->input->post('for_special_process'),
			'machine_production_capacity_lots' => $this->input->post('machine_production_capacity_lots'),
			'machine_production_capacity_kgs' => $this->input->post('machine_production_capacity_kgs'),
			'spindels_per_machine' => $this->input->post('spindels_per_machine'),
			'remarks' => $this->input->post('remarks')
		);
		$result = $this->m_masters->updatemaster('bud_machines', 'machine_id', $machine_id, $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "masters/machines", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/machines", 'refresh');
		}
	}

	function deletemachine()
	{
		if ($this->uri->segment(3) === FALSE) {
			redirect(base_url() . "my404/404", 'refresh');
		} else {
			$machine_id = $this->uri->segment(3);
			$result = $this->m_masters->deletemaster('bud_machines', 'machine_id', $machine_id);
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Deleted!!!');
				redirect(base_url() . "masters/machines", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "masters/machines", 'refresh');
			}
		}
	}

	function categories()
	{
		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'categories';
		$data['page_title'] = 'Add New Category';
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
			$this->load->view('v_categories.php', $data);
		} else {
			$data['category_id'] = $this->uri->segment(3);
			$this->load->view('v_categories.php', $data);
		}
	}
	function savecategory()
	{
		$category_parent = $this->input->post('category_parent');
		$category_name = $this->input->post('category_name');
		$category_status = $this->input->post('category_status');
		$formData = array(
			'category_parent' => $category_parent,
			'category_name' => $category_name,
			'category_status' => $category_status
		);
		$result = $this->m_masters->savecategory($formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "masters/categories", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/categories", 'refresh');
		}
	}
	function updatecategory()
	{
		$category_id = $this->input->post('category_id');
		$category_parent = $this->input->post('category_parent');
		$category_name = $this->input->post('category_name');
		$category_status = $this->input->post('category_status');
		$formData = array(
			'category_parent' => $category_parent,
			'category_name' => $category_name,
			'category_status' => $category_status
		);
		$result = $this->m_masters->updatecategory($category_id, $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Updated!!!');
			redirect(base_url() . "masters/categories", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/categories", 'refresh');
		}
	}
	function deletecategory()
	{
		if ($this->uri->segment(3) === FALSE) {
			redirect(base_url() . "my404/404", 'refresh');
		} else {
			$category_id = $this->uri->segment(3);
			$result = $this->m_masters->deletecategory($category_id);
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Deleted!!!');
				redirect(base_url() . "masters/categories", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "masters/categories", 'refresh');
			}
		}
	}

	/* Start Customers */
	function customerGroup()
	{
		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'customerGroup';
		$data['page_title'] = 'Add New Category';
		$data['cust_groups'] = $this->m_masters->getallmaster('bud_customer_groups');
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
			$this->load->view('v_customer-group.php', $data);
		} else {
			$data['group_id'] = $this->uri->segment(3);
			$this->load->view('v_customer-group.php', $data);
		}
	}
	function savecustomerGroup()
	{
		$group_id = $this->input->post('group_id');
		$group_name = $this->input->post('group_name');
		$status = (isset($_POST['status'])) ? $this->input->post('status') : 0;
		$formData = array(
			'group_name' => $group_name,
			'status' => $status
		);
		if ($group_id == '') {
			$result = $this->m_purchase->saveDatas('bud_customer_groups', $formData);
		} else {
			$result = $this->m_masters->updatemaster('bud_customer_groups', 'group_id', $group_id, $formData);
		}
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "masters/customerGroup", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/customerGroup", 'refresh');
		}
	}

	function customers()
	{
		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'customers';
		$data['page_title'] = 'Cust./Vender';
		$data['customers'] = $this->m_masters->getallmaster('bud_customers', $this->session->userdata('user_viewed'));
		$data['cust_groups'] = $this->m_masters->getactivemaster('bud_customer_groups', 'status');
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
			$next = $this->db->query("SELECT cust_id FROM bud_customers WHERE module = " . $this->session->userdata('user_viewed'));
			$data['customer_code'] = $next->num_rows() + 1;
			$this->load->view('v_customers.php', $data);
		} else {

			$data['customer_code'] = $this->uri->segment(3);
			$data['cust_id'] = $this->uri->segment(3);
			$this->load->view('v_customers.php', $data);
		}
	}

	function savecustomers()
	{
		$cust_group = $this->input->post('cust_group');
		$cust_name = $this->input->post('cust_name');
		$cust_address = $this->input->post('cust_address');
		$cust_city = $this->input->post('cust_city');
		$cust_pincode = $this->input->post('cust_pincode');
		$cust_phone = $this->input->post('cust_phone');
		$cust_fax = $this->input->post('cust_fax');
		$cust_email = $this->input->post('cust_email');

		$cust_gst = $this->input->post('cust_gst');
		$cust_ob = $this->input->post('cust_ob');
		$cust_agent = @implode(",", $this->input->post('cust_agent'));
		$cust_balance_req = $this->input->post('cust_balance_req');
		// $cust_pricelist = $this->input->post('cust_pricelist');
		$cust_status = $this->input->post('cust_status');
		$cust_credit_limit = $this->input->post('cust_credit_limit');
		$cust_merit = $this->input->post('cust_merit');
		$sms_active = ($this->input->post('sms_active')) ? 1 : 0;
		$email_active = ($this->input->post('email_active')) ? 1 : 0;

		$cust_contacts = array();
		$cust_names = $this->input->post('cust_names');
		$cust_contactnos = $this->input->post('cust_contactnos');
		$cust_emails = $this->input->post('cust_emails');
		foreach ($cust_names as $key => $value) {
			if ($value != '') {
				$cust_contacts[] = $value . '##' . $cust_contactnos[$key] . '##' . $cust_emails[$key];
			}
		}
		$cust_contacts = @implode("|", $cust_contacts);

		$next = $this->db->query("SELECT id FROM bud_customers WHERE module = " . $this->session->userdata('user_viewed'));
		$newID = @$next->num_rows() + 1;

		$formData = array(
			'cust_group' => $cust_group,
			'cust_category' => '',
			'id' => $newID,
			'cust_name' => $cust_name,
			'cust_address' => $cust_address,
			'cust_city' => $cust_city,
			'cust_pincode' => $cust_pincode,
			'cust_phone' => $cust_phone,
			'cust_fax' => $cust_fax,
			'cust_email' => $cust_email,

			'cust_gst' => $cust_gst,
			'cust_ob' => $cust_ob,
			'cust_agent' => $cust_agent,
			'cust_balance_req' => $cust_balance_req,
			// 'cust_pricelist' => $cust_pricelist,
			'cust_status' => $cust_status,
			'cust_added_on' => date("Y-m-d H:i:s"),
			'cust_contacts' => $cust_contacts,
			'cust_credit_limit' => implode(",", $cust_credit_limit),
			'cust_merit' => $cust_merit,
			'sms_active' => $sms_active,
			'email_active' => $email_active,
			'password' => $this->encrypt->encode($this->input->post('password')),
			'cust_type' => $this->input->post('cust_type'),
			'module' => $this->session->userdata('user_viewed')
		);
		$if_exist = $this->m_masters->check_exist('bud_customers', 'cust_name', $cust_name);
		//$if_email_exist = $this->m_masters->check_exist('bud_customers', 'cust_email', $cust_email);
		if ($if_exist) {
			$this->session->set_flashdata('error', 'Customer Name Already Exist');
			redirect(base_url() . "masters/customers", 'refresh');
		} else {
			$result = $this->m_masters->savecustomers($formData);
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "masters/customers", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "masters/customers", 'refresh');
			}
		}
	}

	function updatecustomers()
	{
		$cust_id = $this->input->post('cust_id');
		$cust_group = $this->input->post('cust_group');
		$cust_name = $this->input->post('cust_name');
		$cust_address = $this->input->post('cust_address');
		$cust_city = $this->input->post('cust_city');
		$cust_pincode = $this->input->post('cust_pincode');
		$cust_phone = $this->input->post('cust_phone');
		$cust_fax = $this->input->post('cust_fax');
		$cust_email = $this->input->post('cust_email');

		$cust_gst = $this->input->post('cust_gst');
		$cust_ob = $this->input->post('cust_ob');
		$cust_agent = @implode(",", $this->input->post('cust_agent'));
		$cust_balance_req = $this->input->post('cust_balance_req');
		// $cust_pricelist = $this->input->post('cust_pricelist');
		$cust_status = $this->input->post('cust_status');
		$cust_credit_limit = $this->input->post('cust_credit_limit');
		$cust_merit = $this->input->post('cust_merit');
		$sms_active = ($this->input->post('sms_active')) ? 1 : 0;
		$email_active = ($this->input->post('email_active')) ? 1 : 0;

		$cust_contacts = array();
		$cust_names = $this->input->post('cust_names');
		$cust_contactnos = $this->input->post('cust_contactnos');
		$cust_emails = $this->input->post('cust_emails');
		foreach ($cust_names as $key => $value) {
			if ($value != '') {
				$cust_contacts[] = $value . '##' . $cust_contactnos[$key] . '##' . $cust_emails[$key];
			}
		}
		$cust_contacts = @implode("|", $cust_contacts);

		$formData = array(
			'cust_group' => $cust_group,
			'cust_category' => '',
			'cust_name' => $cust_name,
			'cust_address' => $cust_address,
			'cust_city' => $cust_city,
			'cust_pincode' => $cust_pincode,
			'cust_phone' => $cust_phone,
			'cust_fax' => $cust_fax,
			'cust_email' => $cust_email,

			'cust_gst' => $cust_gst,
			'cust_ob' => $cust_ob,
			'cust_agent' => $cust_agent,
			'cust_balance_req' => $cust_balance_req,
			// 'cust_pricelist' => $cust_pricelist,
			'cust_status' => $cust_status,
			'cust_added_on' => date("Y-m-d H:i:s"),
			'cust_contacts' => $cust_contacts,
			'cust_credit_limit' => implode(",", $cust_credit_limit),
			'cust_merit' => $cust_merit,
			'sms_active' => $sms_active,
			'email_active' => $email_active,
			'password' => $this->encrypt->encode($this->input->post('password')),
			'cust_type' => $this->input->post('cust_type'),
			'module' => $this->session->userdata('user_viewed')
		);
		/*
		$old_cust_email =  '';
		$editcustomer = $this->m_masters->getcustomerdetails($cust_id);
		foreach ($editcustomer as $customer) {
			$old_cust_email = $customer['cust_email'];
		}
		$if_email_exist = $this->m_masters->check_user_exist($cust_email);
		if ($if_email_exist != false && $if_email_exist != $old_cust_email) {
			$this->session->set_flashdata('error', 'Customer Name Already Exist');
			redirect(base_url() . "masters/customers/" . $cust_id, 'refresh');
		} else {*/
		$result = $this->m_masters->updatecustomer($cust_id, $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "masters/customers", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/customers/" . $cust_id, 'refresh');
		}
		//}
	}
	/* End Customers */

	function mycustomers()
	{
		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'customers';
		$data['page_title'] = 'Cust./Vender';
		$data['customers'] = $this->m_masters->getAllCustomersByUserId($this->session->userdata('user_id'));
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
		$data['customer_code'] = $this->uri->segment(3);
		$data['cust_id'] = $this->uri->segment(3);
		$this->load->view('marketing_v_customers.php', $data);
	}

	function departments_1()
	{
		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'departments_1';
		$data['page_title'] = 'Sub Department Master';
		$data['departments'] = $this->m_masters->getallmaster('bud_yt_departments', $this->session->userdata('user_viewed'));
		$data['maindepartments'] = $this->m_masters->getallmasteractivecolumn('dost_main_departments', 'status');
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
			$this->load->view('v_1_departments.php', $data);
		} else {
			$data['dept_id'] = $this->uri->segment(3);
			$this->load->view('v_1_departments.php', $data);
		}
	}
	function save_departments_1()
	{
		$dept_id = $this->input->post('dept_id');
		$dept_name = $this->input->post('dept_name');
		$main_dept_id = $this->input->post('main_dept_id');
		$status = (isset($_POST['status'])) ? $this->input->post('status') : 0;
		$formData = array(
			'dept_name' => $dept_name,
			'main_dept_id' => $main_dept_id,
			'status' => $status,
			'module' => $this->session->userdata('user_viewed')
		);
		if ($dept_id == '') {
			$result = $this->m_purchase->saveDatas('bud_yt_departments', $formData);
		} else {
			$result = $this->m_masters->updatemaster('bud_yt_departments', 'dept_id', $dept_id, $formData);
		}
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "masters/departments_1", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/departments_1", 'refresh');
		}
	}
	function delete_departments_1($dept_id)
	{
		$this->m_purchase->deteteDatas('bud_yt_departments', $dept_id);
		$this->session->set_flashdata('success', 'Deleted...!!!');
		redirect(base_url() . "masters/departments_1", 'refresh');
	}

	function maindepartments_1()
	{
		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'departments_1';
		$data['page_title'] = 'Main Department Master';
		$data['departments'] = $this->m_masters->getallmaster('dost_main_departments');
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
			$this->load->view('v_1_maindepartments.php', $data);
		} else {
			$data['dept_id'] = $this->uri->segment(3);
			$this->load->view('v_1_maindepartments.php', $data);
		}
	}
	function save_maindepartments_1()
	{
		$dept_id = $this->input->post('dept_id');
		$dept_name = $this->input->post('dept_name');
		$status = (isset($_POST['status'])) ? $this->input->post('status') : 0;
		$formData = array(
			'dept_name' => $dept_name,
			'status' => $status
		);
		if ($dept_id == '') {
			$result = $this->m_purchase->saveDatas('dost_main_departments', $formData);
		} else {
			$result = $this->m_masters->updatemaster('dost_main_departments', 'dept_id', $dept_id, $formData);
		}
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "masters/maindepartments_1", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/maindepartments_1", 'refresh');
		}
	}
	function delete_maindepartments_1($dept_id)
	{
		$this->m_purchase->deteteDatas('dost_main_departments', $dept_id);
		$this->session->set_flashdata('success', 'Deleted...!!!');
		redirect(base_url() . "masters/maindepartments_1", 'refresh');
	}
	/* Start Suppliers */
	function supplierGroup()
	{
		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'supplierGroup';
		$data['page_title'] = 'Supplier Group Master';
		$data['supp_groups'] = $this->m_masters->getallmaster('bud_yt_supplier_groups');
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
			$this->load->view('v_1_supplier-group.php', $data);
		} else {
			$data['group_id'] = $this->uri->segment(3);
			$this->load->view('v_1_supplier-group.php', $data);
		}
	}
	function savesupplierGroup()
	{
		$group_id = $this->input->post('group_id');
		$group_name = $this->input->post('group_name');
		$status = (isset($_POST['status'])) ? $this->input->post('status') : 0;
		$formData = array(
			'group_name' => $group_name,
			'status' => $status
		);
		if ($group_id == '') {
			$result = $this->m_purchase->saveDatas('bud_yt_supplier_groups', $formData);
		} else {
			$result = $this->m_masters->updatemaster('bud_yt_supplier_groups', 'group_id', $group_id, $formData);
		}
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "masters/supplierGroup", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/supplierGroup", 'refresh');
		}
	}
	function suppliers()
	{
		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'suppliers';
		$data['page_title'] = 'Suppliers';
		$data['suppliers'] = $this->m_masters->getallsuppliers($this->session->userdata('user_viewed'));
		$data['supplier_groups'] = $this->m_masters->getactivemaster('bud_yt_supplier_groups', 'status');
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
			$this->load->view('v_suppliers.php', $data);
		} else {
			$data['sup_id'] = $this->uri->segment(3);
			$this->load->view('v_suppliers.php', $data);
		}
	}
	function savesuppliers()
	{
		$sup_category = $this->input->post('sup_category');
		$sup_group = $this->input->post('sup_group');
		$sup_name = $this->input->post('sup_name');
		$sup_address = $this->input->post('sup_address');
		$sup_city = $this->input->post('sup_city');
		$sup_pincode = $this->input->post('sup_pincode');
		$sup_phone = $this->input->post('sup_phone');
		$sup_fax = $this->input->post('sup_fax');
		$sup_email = $this->input->post('sup_email');
		$sup_tinno = $this->input->post('sup_tinno');
		$sup_cst = $this->input->post('sup_cst');
		$sup_ob = $this->input->post('sup_ob');
		$sup_agent = @implode(",", $this->input->post('sup_agent'));
		$sup_status = $this->input->post('sup_status');

		$sup_contacts = array();
		$sup_names = $this->input->post('sup_names');
		$sup_contactnos = $this->input->post('sup_contactnos');
		$sup_emails = $this->input->post('sup_emails');
		foreach ($sup_names as $key => $value) {
			if ($value != '') {
				$sup_contacts[] = $value . '##' . $sup_contactnos[$key] . '##' . $sup_emails[$key];
			}
		}
		$sup_contacts = implode("|", $sup_contacts);

		$formData = array(
			'sup_group' => $sup_group,
			'sup_category' => $sup_category,
			'sup_name' => $sup_name,
			'sup_address' => $sup_address,
			'sup_city' => $sup_city,
			'sup_pincode' => $sup_pincode,
			'sup_phone' => $sup_phone,
			'sup_fax' => $sup_fax,
			'sup_email' => $sup_email,
			'sup_tinno' => $sup_tinno,
			'sup_cst' => $sup_cst,
			'sup_ob' => $sup_ob,
			'sup_agent' => $sup_agent,
			'sup_status' => $sup_status,
			'sup_added_on' => date("Y-m-d H:i:s"),
			'sup_contacts' => $sup_contacts,
			'module' => $this->session->userdata('user_viewed')
		);
		$result = $this->m_masters->savesuppliers($formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "masters/suppliers", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/suppliers", 'refresh');
		}
	}
	function updatesuppliers()
	{
		$sup_id = $this->input->post('sup_id');
		$sup_group = $this->input->post('sup_group');
		$sup_category = $this->input->post('sup_category');
		$sup_name = $this->input->post('sup_name');
		$sup_address = $this->input->post('sup_address');
		$sup_city = $this->input->post('sup_city');
		$sup_pincode = $this->input->post('sup_pincode');
		$sup_phone = $this->input->post('sup_phone');
		$sup_fax = $this->input->post('sup_fax');
		$sup_email = $this->input->post('sup_email');
		$sup_tinno = $this->input->post('sup_tinno');
		$sup_cst = $this->input->post('sup_cst');
		$sup_ob = $this->input->post('sup_ob');
		$sup_agent = @implode(",", $this->input->post('sup_agent'));
		$sup_status = $this->input->post('sup_status');

		$sup_contacts = array();
		$sup_names = $this->input->post('sup_names');
		$sup_contactnos = $this->input->post('sup_contactnos');
		$sup_emails = $this->input->post('sup_emails');
		foreach ($sup_names as $key => $value) {
			if ($value != '') {
				$sup_contacts[] = $value . '##' . $sup_contactnos[$key] . '##' . $sup_emails[$key];
			}
		}
		$sup_contacts = implode("|", $sup_contacts);

		$formData = array(
			'sup_group' => $sup_group,
			'sup_category' => $sup_category,
			'sup_name' => $sup_name,
			'sup_address' => $sup_address,
			'sup_city' => $sup_city,
			'sup_pincode' => $sup_pincode,
			'sup_phone' => $sup_phone,
			'sup_fax' => $sup_fax,
			'sup_email' => $sup_email,
			'sup_tinno' => $sup_tinno,
			'sup_cst' => $sup_cst,
			'sup_ob' => $sup_ob,
			'sup_agent' => $sup_agent,
			'sup_status' => $sup_status,
			'sup_added_on' => date("Y-m-d H:i:s"),
			'sup_contacts' => $sup_contacts
		);
		$result = $this->m_masters->updatesupplier($sup_id, $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Updated!!!');
			redirect(base_url() . "masters/suppliers", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/suppliers", 'refresh');
		}
	}
	/* End Suppliers */
	// Denier Master
	function deniermaster()
	{
		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'deniermaster';
		$data['page_title'] = 'Denier Master';
		$data['deniers'] = $this->m_masters->getallmaster('bud_deniermaster', $this->session->userdata('user_viewed'));
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
			$this->load->view('v_deniermaster.php', $data);
		} else {
			$data['denier_id'] = $this->uri->segment(3);
			$this->load->view('v_deniermaster.php', $data);
		}
	}
	function deniermaster_save()
	{
		$denier_id = $this->input->post('denier_id');
		$denier_name = $this->input->post('denier_name');
		$denier_tech = $this->input->post('denier_tech');
		$denier_status = ($this->input->post('denier_status') == 1) ? 1 : 0;
		$formData = array(
			'denier_name' => $denier_name,
			'denier_tech' => $denier_tech,
			'denier_status' => $denier_status,
			'module' => $this->session->userdata('user_viewed')
		);
		if ($denier_id == '') {
			$result = $this->m_masters->savemaster('bud_deniermaster', $formData);
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "masters/deniermaster", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "masters/deniermaster", 'refresh');
			}
		} else {
			$result = $this->m_masters->updatemaster('bud_deniermaster', 'denier_id', $denier_id, $formData);
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "masters/deniermaster", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "masters/deniermaster", 'refresh');
			}
		}
	}
	/* Start Shade Master */
	function colorfamily()
	{
		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'colorfamily';
		$data['page_title'] = 'Color Family Master';
		$data['colors'] = $this->m_masters->getallmaster('bud_color_families');
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
			$this->load->view('v_color_family.php', $data);
		} else {
			$data['family_id'] = $this->uri->segment(3);
			$this->load->view('v_color_family.php', $data);
		}
	}
	function colorfamily_save()
	{
		$family_id = $this->input->post('family_id');
		$family_name = $this->input->post('family_name');
		$family_status = ($this->input->post('family_status') == 1) ? 1 : 0;
		$formData = array(
			'family_name' => $family_name,
			'family_status' => $family_status
		);
		if ($family_id == '') {
			$result = $this->m_masters->savemaster('bud_color_families', $formData);
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "masters/colorfamily", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "masters/colorfamily", 'refresh');
			}
		} else {
			$result = $this->m_masters->updatemaster('bud_color_families', 'family_id', $family_id, $formData);
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "masters/colorfamily", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "masters/colorfamily", 'refresh');
			}
		}
	}
	function weavemaster_2()
	{
		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'weavemaster_2';
		$data['page_title'] = 'Weave Master';
		$data['colors'] = $this->m_masters->getallmaster('bud_te_weaves');
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
			$this->load->view('v_2_weave_master.php', $data);
		} else {
			$data['weave_id'] = $this->uri->segment(3);
			$this->load->view('v_2_weave_master.php', $data);
		}
	}
	function weavemaster_2_save()
	{
		$weave_id = $this->input->post('weave_id');
		$weave_name = $this->input->post('weave_name');
		$weave_status = ($this->input->post('weave_status') == 1) ? 1 : 0;
		$formData = array(
			'weave_name' => $weave_name,
			'weave_status' => $weave_status
		);
		if ($weave_id == '') {
			$result = $this->m_masters->savemaster('bud_te_weaves', $formData);
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "masters/weavemaster_2", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "masters/weavemaster_2", 'refresh');
			}
		} else {
			$result = $this->m_masters->updatemaster('bud_te_weaves', 'weave_id', $weave_id, $formData);
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "masters/weavemaster_2", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "masters/weavemaster_2", 'refresh');
			}
		}
	}
	function dc_family()
	{
		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'dc_family';
		$data['page_title'] = 'Dyes and Chemical Family Master';
		$data['dc_families'] = $this->m_masters->getallmaster('bud_dyes_chem_families');
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
			$this->load->view('v_dc_family.php', $data);
		} else {
			$data['dc_family_id'] = $this->uri->segment(3);
			$this->load->view('v_dc_family.php', $data);
		}
	}
	function dc_family_save()
	{
		$dc_family_id = $this->input->post('dc_family_id');
		$dc_family_name = $this->input->post('dc_family_name');
		$dc_family_status = ($this->input->post('dc_family_status') == 1) ? 1 : 0;
		$formData = array(
			'dc_family_name' => $dc_family_name,
			'dc_family_status' => $dc_family_status
		);
		if ($dc_family_id == '') {
			$result = $this->m_masters->savemaster('bud_dyes_chem_families', $formData);
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "masters/dc_family", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "masters/dc_family", 'refresh');
			}
		} else {
			$result = $this->m_masters->updatemaster('bud_dyes_chem_families', 'dc_family_id', $dc_family_id, $formData);
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "masters/dc_family", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "masters/dc_family", 'refresh');
			}
		}
	}
	function dyes_chemicals()
	{
		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'dyes_chemicals';
		$data['page_title'] = 'Dyes And Chemicals Master';
		$data['dyes_chemicals'] = $this->m_masters->getallmaster('bud_dyes_chemicals');
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
			$this->load->view('v_dyes_chemicals.php', $data);
		} else {
			$data['dyes_chem_id'] = $this->uri->segment(3);
			$this->load->view('v_dyes_chemicals.php', $data);
		}
	}
	function dyes_chemicals_save()
	{
		$dyes_chem_id = $this->input->post('dyes_chem_id');
		$dyes_chem_family = $this->input->post('dyes_chem_family');
		$dyes_chem_name = $this->input->post('dyes_chem_name');
		$dyes_chem_code = $this->input->post('dyes_chem_code');
		$dyes_chem_reorder = $this->input->post('dyes_chem_reorder');
		$dyes_open_stock = $this->input->post('dyes_open_stock');
		$dyes_rate = $this->input->post('dyes_rate');
		$dyes_chem_status = ($this->input->post('dyes_chem_status') == 1) ? 1 : 0;
		$formData = array(
			'dyes_chem_family' => $dyes_chem_family,
			'dyes_chem_name' => $dyes_chem_name,
			'dyes_chem_code' => $dyes_chem_code,
			'dyes_chem_reorder' => $dyes_chem_reorder,
			'dyes_open_stock' => $dyes_open_stock,
			'dyes_rate' => $dyes_rate,
			'dyes_chem_status' => $dyes_chem_status,
		);
		if ($dyes_chem_id == '') {
			$result = $this->m_masters->savemaster('bud_dyes_chemicals', $formData);
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "masters/dyes_chemicals", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "masters/dyes_chemicals", 'refresh');
			}
		} else {
			$result = $this->m_masters->updatemaster('bud_dyes_chemicals', 'dyes_chem_id', $dyes_chem_id, $formData);
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "masters/dyes_chemicals", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "masters/dyes_chemicals", 'refresh');
			}
		}
	}
	function shades($shade_id = '')
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'shades';
		$data['page_title'] = 'Shade Master';
		$data['shade_id'] = $shade_id;
		$data['shade_family'] = array();
		$data['shade_name'] = '';
		$data['shade_second_name'] = '';
		$data['shade_third_name'] = '';
		$data['shade_fourth_name'] = '';
		$data['shade_code'] = '';
		$data['color_code'] = '';
		$data['remarks'] = '';
		$data['shade_customers'] = array();
		$data['shade_status'] = '1';
		$data['category_id'] = '';
		$data['shades'] = $this->m_masters->get_shade_list();
		$data['color_categories'] = $this->m_masters->get_color_categories();
		$data['recipe_list'] = $this->m_masters->get_recipe_list();

		if ($shade_id) {
			$this->shade_id = $shade_id;
			$shade = $this->m_masters->get_shade($shade_id);
			if (!$shade) {
				$this->session->set_flashdata('error', 'Record not found');
				redirect(base_url('masters/shades'));
			}
			
			$data['shade_id'] = $shade->shade_id;
			$data['shade_family'] = explode(",", $shade->shade_family);
			$data['shade_name'] = $shade->shade_name;
			$data['shade_second_name'] = $shade->shade_second_name;
			$data['shade_third_name'] = $shade->shade_third_name;
			$data['shade_fourth_name'] = $shade->shade_fourth_name;
			$data['shade_code'] = $shade->shade_code;
			$data['shade_customers'] = explode(",", $shade->shade_customers);
			$data['shade_status'] = $shade->shade_status;
			$data['category_id'] = $shade->category_id;
			$data['color_code'] = $shade->color_code;
			$data['remarks'] = $shade->remarks;
		}

		$this->form_validation->set_rules('shade_name', 'Shade Name', 'required');
		$this->form_validation->set_rules('category_id', 'Color Category', 'required');
		$this->form_validation->set_rules('shade_code', 'Shade Code', 'required|callback_check_shade_code');

		if ($this->input->post('submit')) {
			$data['shade_family'] = (array) $this->input->post('shade_family');
			$data['shade_name'] = $this->input->post('shade_name');
			$data['shade_second_name'] = $this->input->post('shade_second_name');
			$data['shade_third_name'] = $this->input->post('shade_third_name');
			$data['shade_fourth_name'] = $this->input->post('shade_fourth_name');
			$data['shade_code'] = $this->input->post('shade_code');
			$data['shade_customers'] = (array) $this->input->post('shade_customers');
			$data['shade_status'] = $this->input->post('shade_status');
			$data['category_id'] = $this->input->post('category_id');
			$data['color_code'] = $this->input->post('color_code');
			$data['remarks'] = $this->input->post('remarks');
		}

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('shade-master-form', $data);
		} else {
			
			$save['shade_id'] = $shade_id==''?0:$shade_id;
			$save['shade_family'] = implode(",", $this->input->post('shade_family'));
			$save['shade_name'] = $this->input->post('shade_name');
			$save['shade_second_name'] = $this->input->post('shade_second_name');
			$save['shade_third_name'] = $this->input->post('shade_third_name');
			$save['shade_fourth_name'] = $this->input->post('shade_fourth_name');
			$save['shade_code'] = $this->input->post('shade_code');
			if ($this->input->post('shade_customers')) {
				$save['shade_customers'] = implode(",", $this->input->post('shade_customers'));
			}
			$save['shade_status'] = $this->input->post('shade_status');
			$save['category_id'] = $this->input->post('category_id');
			$save['color_code'] = $this->input->post('color_code');
			$save['remarks'] = $this->input->post('remarks');
			$save['added_user'] = $this->session->userdata('user_id');
			$this->m_masters->save_shades($save);
			$this->session->set_flashdata('success', 'Successfully Saved');
			redirect('masters/shades');
		}
	}

	function check_shade_code($str)
	{
		$shade_code = $this->m_masters->check_shade_code($str, $this->shade_id);
		if ($shade_code) {
			$this->form_validation->set_message('check_shade_code', 'Shade Code Already Exist');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function color_category($category_id = '')
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'color_category';
		$data['page_title'] = 'Color Category';
		$data['category_id'] = $category_id;
		$data['color_category'] = '';
		$data['color_categories'] = $this->m_masters->get_color_categories();

		if ($category_id) {
			$this->category_id = $category_id;
			$category = $this->m_masters->get_color_category($category_id);
			if (!$category) {
				$this->session->set_flashdata('error', 'Record not found');
				redirect(base_url('masters/color_category'));
			}
			$data['category_id'] = $category->category_id;
			$data['color_category'] = $category->color_category;
		}

		$this->form_validation->set_rules('color_category', 'Category Name', 'required');

		if ($this->input->post('submit')) {
			$data['color_category'] = $this->input->post('color_category');
		}

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('color-category-form', $data);
		} else {
			$save['category_id'] = $category_id;
			$save['color_category'] = $this->input->post('color_category');
			$this->m_masters->save_color_category($save);
			$this->session->set_flashdata('success', 'Successfully Saved');
			redirect('masters/color_category');
		}
	}

	function recipecategorymaster($category_id = '')
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'recipecategorymaster';
		$data['page_title'] = 'Category Master';
		$data['category_id'] = $category_id;
		$data['category_name'] = '';
		$data['category_prefix'] = '';
		$data['category_active'] = '';
		$data['categorymasters'] = $this->m_masters->get_categories_master();

		if ($category_id) {
			$this->category_id = $category_id;
			$category = $this->m_masters->get_category_master($category_id);
			if (!$category) {
				$this->session->set_flashdata('error', 'Record not found');
				redirect(base_url('masters/recipecategorymaster'));
			}
			$data['category_id'] = $category->category_id;
			$data['category_name'] = $category->category_name;
			$data['category_prefix'] = $category->category_prefix;
			$data['category_active'] = $category->category_active;
		}

		$this->form_validation->set_rules('category_name', 'Category Name', 'required');
		$this->form_validation->set_rules('category_prefix', 'Category Prefix', 'required');

		if ($this->input->post('submit')) {
			$data['category_name'] = $this->input->post('category_name');
			$data['category_prefix'] = $this->input->post('category_prefix');
			$data['category_active'] = $this->input->post('category_active');
		}

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('category-master-form', $data);
		} else {
			if ($category_id != '') {
				$save['category_id'] = $category_id;
			}
			$save['category_name'] = $this->input->post('category_name');
			$save['category_prefix'] = $this->input->post('category_prefix');
			$save['category_active'] = $this->input->post('category_active');

			$save['date'] = date("Y-m-d H:i:s");
			$save['user'] = $this->session->userdata('display_name');

			$this->m_masters->save_category_master($save);
			$this->session->set_flashdata('success', 'Successfully Saved');
			redirect('masters/recipecategorymaster');
		}
	}

	function shades_backup($shade_id = '')
	{
		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'shades';
		$data['page_title'] = 'Shade Master';
		// $data['shade_id'] = $shade_id;
		$data['shades'] = $this->m_masters->getallmaster('bud_shades');
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
			$this->load->view('v_shades.php', $data);
		} else {
			$data['shade_id'] = $this->uri->segment(3);
			$this->load->view('v_shades.php', $data);
		}
	}
	function saveshades()
	{
		$shade_name = $this->input->post('shade_name');
		$shade_second_name = $this->input->post('shade_second_name');
		$shade_third_name = $this->input->post('shade_third_name');
		$shade_fourth_name = $this->input->post('shade_fourth_name');
		$shade_code = $this->input->post('shade_code');
		$shade_status = $this->input->post('shade_status');
		$shade_family = $this->input->post('shade_family');
		$shade_customers = $this->input->post('shade_customers');
		$formData = array(
			'shade_name' => $shade_name,
			'shade_second_name' => $shade_second_name,
			'shade_third_name' => $shade_third_name,
			'shade_fourth_name' => $shade_fourth_name,
			'shade_code' => $shade_code,
			'shade_status' => $shade_status
		);
		if ($this->input->post('shade_family')) {
			if (count($shade_family) > 0) {
				$formData['shade_family'] = implode(",", $shade_family);
			}
		}

		if ($this->input->post('shade_customers')) {
			if (count($shade_customers) > 0) {
				$formData['shade_customers'] = implode(",", $shade_customers);
			}
		}
		$result = $this->m_masters->savemaster('bud_shades', $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "masters/shades", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/shades", 'refresh');
		}
	}
	function addchemicals()
	{
		$nextshade = $this->input->post('nextshade');
		$shade_chemicals = $this->input->post('shade_chemicals');
		$shade_chemicals_value = $this->input->post('shade_chemicals_value');
		$shade_chemicals_uoms = $this->input->post('shade_chemicals_uoms');
		$formData = array(
			'shade_id' => $nextshade,
			'chemical_id' => $shade_chemicals,
			'chemical_value' => $shade_chemicals_value,
			'chemical_uom' => $shade_chemicals_uoms,
		);
		$result = $this->m_masters->savemaster('bud_shade_chemicals', $formData);
	}
	function chemicalsdata($shade_id = null)
	{
		$data['shade_id'] = $shade_id;
		$this->load->view('v_chemicalsdata.php', $data);
	}
	function deletechemical($chemical_id = null)
	{
		$this->m_masters->deletemaster('bud_shade_chemicals', 'id', $chemical_id);
	}
	function adddyes()
	{
		$nextshade = $this->input->post('nextshade');
		$shade_dyes = $this->input->post('shade_dyes');
		$shade_dyes_value = $this->input->post('shade_dyes_value');
		$shade_dyes_uoms = $this->input->post('shade_dyes_uoms');
		$formData = array(
			'shade_id' => $nextshade,
			'dyes_id' => $shade_dyes,
			'dyes_value' => $shade_dyes_value,
			'dyes_uom' => $shade_dyes_uoms,
		);
		$result = $this->m_masters->savemaster('bud_shade_dyes', $formData);
	}
	function dyesdata($shade_id = null)
	{
		$data['shade_id'] = $shade_id;
		$this->load->view('v_dyesdata.php', $data);
	}
	function deletedyes($dyes_id = null)
	{
		$this->m_masters->deletemaster('bud_shade_dyes', 'id', $dyes_id);
	}
	function updateshades()
	{
		/*echo "<pre>";
		print_r($_POST);
		echo "</pre>";*/
		$shade_id = $this->input->post('shade_id');
		$shade_name = $this->input->post('shade_name');
		$shade_second_name = $this->input->post('shade_second_name');
		$shade_third_name = $this->input->post('shade_third_name');
		$shade_fourth_name = $this->input->post('shade_fourth_name');
		$shade_code = $this->input->post('shade_code');
		$shade_status = $this->input->post('shade_status');
		$shade_family = $this->input->post('shade_family');
		$shade_customers = $this->input->post('shade_customers');
		$formData = array(
			'shade_name' => $shade_name,
			'shade_second_name' => $shade_second_name,
			'shade_third_name' => $shade_third_name,
			'shade_fourth_name' => $shade_fourth_name,
			'shade_code' => $shade_code,
			'shade_status' => $shade_status
		);

		if ($this->input->post('shade_family')) {
			if (count($shade_family) > 0) {
				$formData['shade_family'] = implode(",", $shade_family);
			}
		}
		if ($this->input->post('shade_customers')) {
			if (count($shade_customers) > 0) {
				$formData['shade_customers'] = implode(",", $shade_customers);
			}
		}

		$result = $this->m_masters->updatemaster('bud_shades', 'shade_id', $shade_id, $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "masters/shades", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/shades", 'refresh');
		}
	}
	function recipemaster($recipe_id = false)
	{
		$this->load->library('form_validation');
		$this->load->model('m_poy');
		if ($recipe_id) {
			if (@$this->uri->segment(4) == 'duplicate') {
				$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_recipe_master'");
				$next = $next->row(0);

				$data['nextshade'] = $next->Auto_increment;
				$data['next_recipe'] = $next->Auto_increment;
			} else {
				$data['next_recipe'] = $recipe_id;
			}
		} else {
			$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_recipe_master'");
			$next = $next->row(0);

			$data['nextshade'] = $next->Auto_increment;
			$data['next_recipe'] = $next->Auto_increment;
		}
		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'recipemaster';
		$data['page_title'] = 'Recipe Master';
		$data['shades'] = $this->m_masters->getallmasteractive('bud_shades');
		$data['clyarn_lots'] = $this->m_poy->get_yarn_lots('bud_yarn_lots');
		$data['itemsmaster'] = $this->m_masters->get_active_items_array('bud_items');
		$data['categories'] = $this->m_masters->getallcategories();
		$data['categorymasters'] = $this->m_masters->get_categories_master_active();
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

		$data['recipe_id'] = $recipe_id;
		$data['shade_id'] = '';
		$data['denier_id'] = '';
		$data['poy_lot_id'] = '';
		$data['remarks'] = '';
		$data['shade_chemicals'] = array();
		$data['shade_dyes'] = array();
		$data['stage3'] = array();
		$data['stage4'] = array();
		$data['stage1_remarks'] = '';
		$data['stage2_remarks'] = '';
		$data['stage3_remarks'] = '';
		$data['stage4_remarks'] = '';
		$data['recipe_category'] = '';
		$data['recipe_status'] = '';
		$shades = array();

		$data['recipe_list'] = $this->m_masters->get_recipe_list();

		if ($recipe_id) {
			$recipe = $this->m_masters->get_recipe($recipe_id);
			if (!$recipe) {
				$this->session->set_flashdata('error', 'Record Not Found');
				redirect(base_url('masters/recipemaster'));
			}

			$data['recipe_id'] = $recipe->recipe_id;
			$data['shade_id'] = $recipe->shade_id;
			$data['denier_id'] = $recipe->denier_id;
			$data['poy_lot_id'] = $recipe->poy_lot_id;
			$data['remarks'] = $recipe->remarks;
			$data['shade_chemicals'] = (array) json_decode($recipe->shade_chemicals);
			$data['shade_dyes'] = (array) json_decode($recipe->shade_dyes);
			$data['stage3'] = (array) json_decode($recipe->stage3);
			$data['stage4'] = (array) json_decode($recipe->stage4);
			$data['stage1_remarks'] = $recipe->stage1_remarks;
			$data['stage2_remarks'] = $recipe->stage2_remarks;
			$data['stage3_remarks'] = $recipe->stage3_remarks;
			$data['stage4_remarks'] = $recipe->stage4_remarks;
			$data['recipe_category'] = @$recipe->recipe_category;
			$data['recipe_status'] = @$recipe->recipe_status;

			$data['stage1_temp'] = @$recipe->stage1_temp;
			$data['stage2_temp'] = @$recipe->stage2_temp;
			$data['stage2_temp1'] = @$recipe->stage2_temp1;
			$data['stage2_temp2'] = @$recipe->stage2_temp2;
			$data['stage3_temp'] = @$recipe->stage3_temp;
			$data['stage4_temp'] = @$recipe->stage4_temp;
		}

		$this->form_validation->set_rules('shade_id', 'Color Name', 'required');

		if ($this->input->post('sumbit')) {
			$data['recipe_id'] = $recipe_id;
			$data['shade_id'] = $this->input->post('shade_id');
			$data['denier_id'] = $this->input->post('denier_id');
			$data['poy_lot_id'] = $this->input->post('poy_lot_id');
			$data['remarks'] = $this->input->post('remarks');
			$data['shade_chemicals'] = $this->input->post('shade_chemicals');
			$data['shade_dyes'] = $this->input->post('shade_dyes');
			$data['stage3'] = $this->input->post('stage3');
			$data['stage4'] = $this->input->post('stage4');
			$data['stage1_remarks'] = $this->input->post('stage1_remarks');
			$data['stage2_remarks'] = $this->input->post('stage2_remarks');
			$data['stage3_remarks'] = $this->input->post('stage3_remarks');
			$data['stage4_remarks'] = $this->input->post('stage4_remarks');
			$data['recipe_category'] = $this->input->post('recipe_category');
			$data['recipe_status'] = $this->input->post('recipe_status');

			$data['stage1_temp'] = $this->input->post('stage1_temp');
			$data['stage2_temp'] = $this->input->post('stage2_temp');
			$data['stage2_temp1'] = $this->input->post('stage2_temp1');
			$data['stage2_temp2'] = $this->input->post('stage2_temp2');
			$data['stage3_temp'] = $this->input->post('stage3_temp');
			$data['stage4_temp'] = $this->input->post('stage4_temp');
		}

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('v_recipemaster.php', $data);
		} else {
			if ($recipe_id == $this->input->post('recipe_id')) {
				$save['recipe_id'] = $this->input->post('recipe_id');
			}
			$save['shade_id'] = $this->input->post('shade_id');
			$save['denier_id'] = $this->input->post('denier_id');
			$save['poy_lot_id'] = $this->input->post('poy_lot_id');
			$save['remarks'] = $this->input->post('remarks');

			$save['stage1_remarks'] = $this->input->post('stage1_remarks');
			$save['stage2_remarks'] = $this->input->post('stage2_remarks');
			$save['stage3_remarks'] = $this->input->post('stage3_remarks');
			$save['stage4_remarks'] = $this->input->post('stage4_remarks');

			$save['recipe_category'] = $this->input->post('recipe_category');
			$save['recipe_status'] = $this->input->post('recipe_status');

			$save['stage1_temp'] = $this->input->post('stage1_temp');
			$save['stage2_temp'] = $this->input->post('stage2_temp');
			$save['stage2_temp1'] = $this->input->post('stage2_temp1');
			$save['stage2_temp2'] = $this->input->post('stage2_temp2');
			$save['stage3_temp'] = $this->input->post('stage3_temp');
			$save['stage4_temp'] = $this->input->post('stage4_temp');

			$save['date'] = date("Y-m-d H:i:s");
			$save['username'] = $this->session->userdata('display_name');

			$save['shade_chemicals'] = json_encode($this->input->post('shade_chemicals'));
			$save['shade_dyes'] = json_encode($this->input->post('shade_dyes'));
			$save['stage3'] = json_encode($this->input->post('stage3'));
			$save['stage4'] = json_encode($this->input->post('stage4'));
			//echo '<pre>'; print_r($save); die;
			$this->m_masters->save_recipe($save);

			$this->session->set_flashdata('success', 'Successfully Saved');
			//go back to the Recipe list
			redirect(base_url('masters/recipemaster'));
		}
	}

	function recipe_print($recipe_id = false, $shade_id = false, $lot_qty = false, $lot_id = false)
	{
		if (!empty($shade_id)) {
			$shade_recipe = $this->m_masters->get_shade_recipe($shade_id);
			$recipe_id = $shade_recipe->recipe_id;
			$data['recipe_id'] = $recipe_id;
			$recipe = $this->m_masters->get_recipe_details($recipe_id);
		}
		if (!empty($recipe_id)) {
			$data['recipe_id'] = $recipe_id;
			$recipe = $this->m_masters->get_recipe_details($recipe_id);
		}

		if (!empty($lot_qty)) {
			/*$key = 'lot-qty';
			$this->load->library('encrypt');
			$data['lot_qty'] = $this->encrypt->decode($lot_qty);*/

			$data['lot_qty'] = $lot_qty;
		} else {
			$data['lot_qty'] = false;
		}

		if (!$recipe) {
			$this->session->set_flashdata('error', 'No Recipe Created');
			redirect(base_url('masters/lots'));
		}

		$data['recipe'] = $recipe;
		$data['lot_id'] = $lot_id;

		$data['css_print'] = array(
			'css/invoice-print.css'
		);
		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'recipemaster';
		$data['page_title'] = 'Print Recipe';
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
		$this->load->view('v_recipe_print.php', $data);
	}

	function deleterecipe($recipe_id)
	{
		if ($recipe_id) {
			$recipe	= $this->m_masters->get_recipe($recipe_id);
			//if the recipe does not exist, redirect them to the recipe list with an error
			if (!$recipe) {
				$this->session->set_flashdata('error', 'Record Not Found');
				redirect(base_url('masters/recipemaster'));
			} else {
				$this->m_masters->delete_recipe($recipe_id);

				$this->session->set_flashdata('success', 'Successfully Deleted');
				redirect(base_url('masters/recipemaster'));
			}
		} else {
			//if they do not provide an recipe_id send them to the recipe list page with an error
			$this->session->set_flashdata('error', 'Record Not Found');
			redirect(base_url('masters/recipemaster'));
		}
	}
	function recipemaster_save()
	{
		$shade_name = $this->input->post('shade_name');
		$shade_denier = $this->input->post('shade_denier');
		$shade_poy_lot = $this->input->post('shade_poy_lot');
		$shade_chemicals = $this->input->post('chemicals');
		$shade_chemical_uoms = $this->input->post('chemical_uoms');
		$shade_temperatures = $this->input->post('temperatures');
		$formData = array(
			'shade_denier' => $shade_denier,
			'shade_poy_lot' => $shade_poy_lot
		);
		$result = $this->m_masters->updatemaster('bud_shades', 'shade_id', $shade_name, $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "masters/recipemaster", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/recipemaster", 'refresh');
		}
	}
	function getfamilydata($family_id = null)
	{
		if (!empty($family_id)) {
			$shades = $this->m_masters->getcolorfamily($family_id);
			$resultData = array();
			$shadeData = '';
			$codeData = '';
			foreach ($shades as $shade) {
				$shadeData .= '<option value="' . $shade['shade_id'] . '">' . $shade['shade_name'] . '</option>';
				$codeData .= '<option value="' . $shade['shade_id'] . '">' . $shade['shade_code'] . '</option>';
			}
			$resultData[] = $shadeData;
			$resultData[] = $codeData;
			echo implode(",", $resultData);
		}
	}
	/* End Shade Master */
	/* Start Lot Master */
	function lots($lot_id = false)
	{
		if (!empty($lot_id)) {
			$data['nextlot'] = $lot_id;
		} else {
			$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_lots'");
			$next = $next->row(0);
			$data['nextlot'] = $next->Auto_increment;
		}
		$this->load->library('form_validation');
		$this->load->library('encrypt');

		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'lots';
		$data['page_title'] = 'Print Lot Slip';
		$data['lots'] = $this->m_masters->get_lots();
		$data['recipe_list'] = $this->m_masters->get_recipe_list_active();
		$data['categorymasters'] = $this->m_masters->get_categories_master_active();
		$data['machines'] = $this->m_masters->getallmachinemasteractive('bud_machines');
		$data['shades'] = $this->m_masters->getallmasteractive('bud_shades');
		// $data['categories'] = $this->m_masters->getallcategories();
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

		$data['lot_id'] = '';
		$data['lot_prefix'] = '';
		$data['lot_no'] = '';
		$data['lot_shade_no'] = '';
		$data['lot_oil_required'] = '';
		$data['lot_qty'] = '';
		$data['lot_actual_qty'] = '';
		$data['lot_status'] = '';

		if ($lot_id) {
			$lot = $this->m_masters->get_lot($lot_id);
			if (!$lot) {
				$this->session->set_flashdata('error', 'Record Not Found');
				redirect(base_url('masters/lots'));
			}

			$data['lot_id'] = $lot->lot_id;
			$data['lot_prefix'] = $lot->lot_prefix;
			$data['lot_no'] = $lot->lot_no;
			$data['lot_shade_no'] = $lot->lot_shade_no;
			$data['lot_oil_required'] = $lot->lot_oil_required;
			$data['lot_qty'] = $lot->lot_qty;
			$data['lot_actual_qty'] = $lot->lot_actual_qty;
			$data['lot_status'] = $lot->lot_status;
		}

		// Set Validation Rules
		$this->form_validation->set_rules('lot_prefix', 'Machine', 'required');

		if ($this->input->post('submit')) {
			$data['lot_id'] = $lot_id;
			$data['lot_prefix'] = $this->input->post('lot_prefix');
			$data['lot_shade_no'] = $this->input->post('lot_shade_no');
			$data['lot_oil_required'] = $this->input->post('lot_oil_required');
			$data['lot_qty'] = $this->input->post('lot_qty');
			$data['lot_actual_qty'] = $this->input->post('lot_actual_qty');
			$data['lot_status'] = $this->input->post('lot_status');
		}
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('v_lots', $data);
		} else {
			$save['lot_id'] = $lot_id;
			$save['lot_prefix'] = $this->input->post('lot_prefix');

			$machine_prefix = $this->m_masters->getmasterIDvalue('bud_machines', 'machine_id', $save['lot_prefix'], 'machine_prefix');

			$save['lot_no'] = $machine_prefix . $data['nextlot'];
			$save['lot_shade_no'] = $this->input->post('lot_shade_no');
			$save['lot_oil_required'] = $this->input->post('lot_oil_required');
			$save['lot_qty'] = $this->input->post('lot_qty');

			$percentege = ($this->input->post('lot_oil_required') * $this->input->post('lot_qty')) / 100;
			$lot_actual_qty = $this->input->post('lot_qty') + $percentege;
			$save['lot_actual_qty'] = $lot_actual_qty;

			$save['lot_status'] = $this->input->post('lot_status');

			$this->m_masters->save_lot($save);

			$this->session->set_flashdata('success', 'Successfully Saved');
			//go back to the Class list
			redirect(base_url('masters/lots'));
		}
	}
	function savelots()
	{
		$category = $this->input->post('category');
		$lot_prefix = $this->input->post('lot_prefix');
		$lot_no = $this->input->post('lot_no');
		$lot_shade_no = $this->input->post('lot_shade_no');
		$lot_oil_required = $this->input->post('lot_oil_required');
		$lot_qty = $this->input->post('lot_qty');
		$lot_actual_qty = $this->input->post('lot_actual_qty');
		$lot_status = $this->input->post('lot_status');
		$formData = array(
			'category' => $category,
			'lot_prefix' => $lot_prefix,
			'lot_no' => $lot_no,
			'lot_shade_no' => $lot_shade_no,
			'lot_oil_required' => $lot_oil_required,
			'lot_qty' => $lot_qty,
			'lot_actual_qty' => $lot_actual_qty,
			'lot_status' => $lot_status
		);
		$result = $this->m_masters->savemaster('bud_lots', $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "masters/lots", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/lots", 'refresh');
		}
	}
	function updatelots()
	{
		$lot_id = $this->input->post('lot_id');
		$category = $this->input->post('category');
		$lot_prefix = $this->input->post('lot_prefix');
		$lot_no = $this->input->post('lot_no');
		$lot_shade_no = $this->input->post('lot_shade_no');
		$lot_oil_required = $this->input->post('lot_oil_required');
		$lot_qty = $this->input->post('lot_qty');
		$lot_actual_qty = $this->input->post('lot_actual_qty');
		$lot_status = $this->input->post('lot_status');
		$formData = array(
			'category' => $category,
			'lot_prefix' => $lot_prefix,
			'lot_no' => $lot_no,
			'lot_shade_no' => $lot_shade_no,
			'lot_oil_required' => $lot_oil_required,
			'lot_qty' => $lot_qty,
			'lot_actual_qty' => $lot_actual_qty,
			'lot_status' => $lot_status
		);
		$result = $this->m_masters->updatemaster('bud_lots', 'lot_id', $lot_id, $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Updated!!!');
			redirect(base_url() . "masters/lots", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/lots", 'refresh');
		}
	}
	function poy_lots()
	{
		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'poy_lots';
		$data['page_title'] = 'POY Lot Master';
		$data['poy_lots'] = $this->m_masters->getallmaster('bud_poy_lots');
		$data['uoms'] = $this->m_masters->getactivemaster('bud_uoms', 'uom_status');
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
			$this->load->view('v_poy_lots.php', $data);
		} else {
			$data['poy_lot_id'] = $this->uri->segment(3);
			$this->load->view('v_poy_lots.php', $data);
		}
	}
	function poy_lots_save()
	{
		$poy_lot_id = $this->input->post('poy_lot_id');
		$poy_lot_name = $this->input->post('poy_lot_name');
		$poy_lot_no = $this->input->post('poy_lot_no');
		$poy_reorder = $this->input->post('poy_reorder');
		$poy_lot_uom = $this->input->post('poy_lot_uom');
		$poy_status = ($this->input->post('poy_status') == 1) ? 1 : 0;
		$formData = array(
			'poy_lot_name' => $poy_lot_name,
			'poy_lot_no' => $poy_lot_no,
			'poy_reorder' => $poy_reorder,
			'poy_lot_uom' => $poy_lot_uom,
			'poy_status' => $poy_status,
		);
		if ($poy_lot_id == '') {
			$result = $this->m_masters->savemaster('bud_poy_lots', $formData);
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "masters/poy_lots", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "masters/poy_lots", 'refresh');
			}
		} else {
			$result = $this->m_masters->updatemaster('bud_poy_lots', 'poy_lot_id', $poy_lot_id, $formData);
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "masters/poy_lots", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "masters/poy_lots", 'refresh');
			}
		}
	}
	/* End Lot Master */

	/* Start Unit Measurement Master */
	function uoms()
	{
		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'uoms';
		$data['page_title'] = 'Unit of measurement master';
		$data['uoms'] = $this->m_masters->getallmaster('bud_uoms');
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
			$this->load->view('v_unitmeasurement.php', $data);
		} else {
			$data['uom_id'] = $this->uri->segment(3);
			$this->load->view('v_unitmeasurement.php', $data);
		}
	}
	function saveuoms()
	{
		$uom_category = $this->input->post('uom_category');
		$uom_name = $this->input->post('uom_name');
		$uom_status = $this->input->post('uom_status');
		$formData = array(
			'uom_category' => $uom_category,
			'uom_name' => $uom_name,
			'uom_status' => $uom_status
		);
		$result = $this->m_masters->savemaster('bud_uoms', $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "masters/uoms", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/uoms", 'refresh');
		}
	}
	function updateuoms()
	{
		$uom_id = $this->input->post('uom_id');
		$uom_category = $this->input->post('uom_category');
		$uom_name = $this->input->post('uom_name');
		$uom_status = $this->input->post('uom_status');
		$formData = array(
			'uom_category' => $uom_category,
			'uom_name' => $uom_name,
			'uom_status' => $uom_status
		);
		$result = $this->m_masters->updatemaster('bud_uoms', 'uom_id', $uom_id, $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Updated!!!');
			redirect(base_url() . "masters/uoms", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/uoms", 'refresh');
		}
	}
	/* End Unit of Measurement Master */

	/* Start Tax Master */
	function tax()
	{
		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'tax';
		$data['page_title'] = 'Tax master';
		$data['taxlist'] = $this->m_masters->getallmaster('bud_tax');
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
			$this->load->view('v_tax.php', $data);
		} else {
			$data['tax_id'] = $this->uri->segment(3);
			$this->load->view('v_tax.php', $data);
		}
	}
	function savetax()
	{
		$tax_category = $this->input->post('tax_category');
		$tax_name = $this->input->post('tax_name');
		$tax_value = $this->input->post('tax_value');
		$tax_description = $this->input->post('tax_description');
		$tax_status = $this->input->post('tax_status');
		$formData = array(
			'tax_category' => $tax_category,
			'tax_name' => $tax_name,
			'tax_value' => $tax_value,
			'tax_description' => $tax_description,
			'tax_status' => $tax_status
		);
		$result = $this->m_masters->savemaster('bud_tax', $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "masters/tax", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/tax", 'refresh');
		}
	}
	function updatetax()
	{
		$tax_id = $this->input->post('tax_id');
		$tax_category = $this->input->post('tax_category');
		$tax_name = $this->input->post('tax_name');
		$tax_value = $this->input->post('tax_value');
		$tax_description = $this->input->post('tax_description');
		$tax_status = $this->input->post('tax_status');
		$formData = array(
			'tax_category' => $tax_category,
			'tax_name' => $tax_name,
			'tax_value' => $tax_value,
			'tax_description' => $tax_description,
			'tax_status' => $tax_status
		);
		$result = $this->m_masters->updatemaster('bud_tax', 'tax_id', $tax_id, $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Updated!!!');
			redirect(base_url() . "masters/tax", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/tax", 'refresh');
		}
	}
	/* End Unit Tax Master */

	/* Start Other Charges Master */
	function othercharges()
	{
		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'othercharges';
		$data['page_title'] = 'Other Charges master';
		$data['othercharges'] = $this->m_masters->getallmaster('bud_othercharges');
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
			$this->load->view('v_othercharges.php', $data);
		} else {
			$data['othercharge_id'] = $this->uri->segment(3);
			$this->load->view('v_othercharges.php', $data);
		}
	}
	function saveothercharges()
	{
		$othercharge_category = $this->input->post('othercharge_category');
		$othercharge_name = $this->input->post('othercharge_name');
		$othercharge_type = $this->input->post('othercharge_type');
		$othercharge_status = $this->input->post('othercharge_status');
		$formData = array(
			'othercharge_category' => $othercharge_category,
			'othercharge_name' => $othercharge_name,
			'othercharge_type' => $othercharge_type,
			'othercharge_status' => $othercharge_status
		);
		$result = $this->m_masters->savemaster('bud_othercharges', $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "masters/othercharges", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/othercharges", 'refresh');
		}
	}
	function updateothercharges()
	{
		$othercharge_id = $this->input->post('othercharge_id');
		$othercharge_category = $this->input->post('othercharge_category');
		$othercharge_name = $this->input->post('othercharge_name');
		$othercharge_type = $this->input->post('othercharge_type');
		$othercharge_status = $this->input->post('othercharge_status');
		$formData = array(
			'othercharge_category' => $othercharge_category,
			'othercharge_name' => $othercharge_name,
			'othercharge_type' => $othercharge_type,
			'othercharge_status' => $othercharge_status
		);
		$result = $this->m_masters->updatemaster('bud_othercharges', 'othercharge_id', $othercharge_id, $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Updated!!!');
			redirect(base_url() . "masters/othercharges", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/othercharges", 'refresh');
		}
	}
	/* End Other Charges Master */

	/* Start Tare Weight Master */
	function tareweights()
	{
		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'tareweights';
		$data['page_title'] = 'Tare Weight Master';
		$data['tareweights'] = $this->m_masters->getallmaster('bud_tareweights');
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
			$this->load->view('v_tereweight.php', $data);
		} else {
			$data['tareweight_id'] = $this->uri->segment(3);
			$this->load->view('v_tereweight.php', $data);
		}
	}
	function savetareweights()
	{
		$tareweight_name = $this->input->post('tareweight_name');
		$tareweight_value = $this->input->post('tareweight_value');
		$tareweight_status = $this->input->post('tareweight_status');
		$formData = array(
			'tareweight_name' => $tareweight_name,
			'tareweight_value' => $tareweight_value,
			'tareweight_status' => $tareweight_status
		);
		$result = $this->m_masters->savemaster('bud_tareweights', $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "masters/tareweights", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/tareweights", 'refresh');
		}
	}
	function updatetareweights()
	{
		$tareweight_id = $this->input->post('tareweight_id');
		$tareweight_name = $this->input->post('tareweight_name');
		$tareweight_value = $this->input->post('tareweight_value');
		$tareweight_status = $this->input->post('tareweight_status');
		$formData = array(
			'tareweight_name' => $tareweight_name,
			'tareweight_value' => $tareweight_value,
			'tareweight_status' => $tareweight_status
		);
		$result = $this->m_masters->updatemaster('bud_tareweights', 'tareweight_id', $tareweight_id, $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Updated!!!');
			redirect(base_url() . "masters/tareweights", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/tareweights", 'refresh');
		}
	}

	function delete_tareweight($tareweight_id = null)
	{
		$result = $this->m_masters->deletemaster('bud_tareweights', 'tareweight_id', $tareweight_id);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Deleted!!!');
			redirect(base_url() . "masters/tareweights", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/tareweights", 'refresh');
		}
	}
	/* End Tare Weight Master */

	/* Start Agents Master */
	function agents()
	{
		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'agents';
		$data['page_title'] = 'Agent Master';
		$data['agents'] = $this->m_masters->getallmaster('bud_agents');
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
			$this->load->view('v_agents.php', $data);
		} else {
			$data['agent_id'] = $this->uri->segment(3);
			$this->load->view('v_agents.php', $data);
		}
	}
	function saveagents()
	{
		$agent_category = $this->input->post('agent_category');
		$agent_name = $this->input->post('agent_name');
		$agent_address = $this->input->post('agent_address');
		$agent_city = $this->input->post('agent_city');
		$agent_pincode = $this->input->post('agent_pincode');
		$agent_phone = $this->input->post('agent_phone');
		$agent_fax = $this->input->post('agent_fax');
		$agent_email = $this->input->post('agent_email');
		$agent_status = $this->input->post('agent_status');
		$formData = array(
			'agent_category' => $agent_category,
			'agent_name' => $agent_name,
			'agent_address' => $agent_address,
			'agent_city' => $agent_city,
			'agent_pincode' => $agent_pincode,
			'agent_phone' => $agent_phone,
			'agent_fax' => $agent_fax,
			'agent_email' => $agent_email,
			'agent_status' => $agent_status
		);
		$result = $this->m_masters->savemaster('bud_agents', $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "masters/agents", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/agents", 'refresh');
		}
	}
	function updateagents()
	{
		$agent_id = $this->input->post('agent_id');
		$agent_category = $this->input->post('agent_category');
		$agent_name = $this->input->post('agent_name');
		$agent_address = $this->input->post('agent_address');
		$agent_city = $this->input->post('agent_city');
		$agent_pincode = $this->input->post('agent_pincode');
		$agent_phone = $this->input->post('agent_phone');
		$agent_fax = $this->input->post('agent_fax');
		$agent_email = $this->input->post('agent_email');
		$agent_status = $this->input->post('agent_status');
		$formData = array(
			'agent_category' => $agent_category,
			'agent_name' => $agent_name,
			'agent_address' => $agent_address,
			'agent_city' => $agent_city,
			'agent_pincode' => $agent_pincode,
			'agent_phone' => $agent_phone,
			'agent_fax' => $agent_fax,
			'agent_email' => $agent_email,
			'agent_status' => $agent_status
		);
		$result = $this->m_masters->updatemaster('bud_agents', 'agent_id', $agent_id, $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Updated!!!');
			redirect(base_url() . "masters/agents", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/agents", 'refresh');
		}
	}
	function delete_agents($agent_id = null)
	{
		$result = $this->m_masters->deletemaster('bud_agents', 'agent_id', $agent_id);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Deleted!!!');
			redirect(base_url() . "masters/agents", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/agents", 'refresh');
		}
	}
	/* End Agents Master */

	/* Start Item Groups Master */
	function itemgroups()
	{
		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'itemgroups';
		$data['page_title'] = 'Item Group Master';
		$data['itemgroups'] = $this->m_masters->getallmaster('bud_itemgroups', $this->session->userdata('user_viewed'));
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
			$this->load->view('v_itemgroups.php', $data);
		} else {
			$data['group_id'] = $this->uri->segment(3);
			$this->load->view('v_itemgroups.php', $data);
		}
	}
	function saveitemgroups()
	{
		$group_category = $this->input->post('group_category');
		$group_name = $this->input->post('group_name');
		$group_code = $this->input->post('group_code');
		$group_description = $this->input->post('group_description');
		$group_status = $this->input->post('group_status');
		$formData = array(
			'group_category' => $group_category,
			'group_name' => $group_name,
			'group_code' => $group_code,
			'group_description' => $group_description,
			'group_status' => $group_status,
			'module' => $this->session->userdata('user_viewed')
		);
		$result = $this->m_masters->savemaster('bud_itemgroups', $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "masters/itemgroups", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/itemgroups", 'refresh');
		}
	}
	function updateitemgroups()
	{
		$group_id = $this->input->post('group_id');
		$group_category = $this->input->post('group_category');
		$group_name = $this->input->post('group_name');
		$group_code = $this->input->post('group_code');
		$group_description = $this->input->post('group_description');
		$group_status = $this->input->post('group_status');
		$formData = array(
			'group_category' => $group_category,
			'group_name' => $group_name,
			'group_code' => $group_code,
			'group_description' => $group_description,
			'group_status' => $group_status
		);
		$result = $this->m_masters->updatemaster('bud_itemgroups', 'group_id', $group_id, $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Updated!!!');
			redirect(base_url() . "masters/itemgroups", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/itemgroups", 'refresh');
		}
	}
	/* End Item Groups Master */

	/* Start Items Master */
	function items()
	{
		$next = $this->db->query("SELECT item_id FROM bud_items WHERE module = " . $this->session->userdata('user_viewed'));
		$next = $next->num_rows();
		$data['next'] = $next + 1;

		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'items';
		$data['page_title'] = 'Items Master';
		// $data['items'] = $this->m_masters->getallmaster('bud_items');
		$data['items'] = $this->m_masters->get_items_array('bud_items', $this->session->userdata('user_viewed'));
		$data['categories'] = $this->m_masters->getallcategories();
		$data['deniers'] = $this->m_masters->getactivemaster('bud_deniermaster', 'denier_status', $this->session->userdata('user_viewed'));
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
		$this->session->set_userdata('simages', array());
		if ($this->uri->segment(3) === FALSE) {
			$this->load->view('v_items.php', $data);
		} else {
			$data['item_id'] = $this->uri->segment(3);
			$this->load->view('v_items.php', $data);
		}
	}
	function saveitems()
	{
		if (!empty($_FILES['file']['name'])) {
			$this->load->library('upload');
			$this->load->library('image_lib');
			$imagePath  = realpath(APPPATH . '../uploads/items');
			$rand       = random_string('alnum', 16);

			$config = array(
				'file_name'     => $rand,
				'allowed_types' => 'jpg|jpeg|png|gif',
				'max_size'      => 3000,
				'overwrite'     => FALSE,
				'upload_path'   => $imagePath
			);

			//Load upload library
			//$this->load->library('upload', $config);
			$this->upload->initialize($config);

			// File upload
			if ($this->upload->do_upload('file')) {
				// Get data about the file
				$uploadData = $this->upload->data();
				$myImg      = $uploadData['file_name'];
				$simages    = $this->session->userdata('simages');
				array_push($simages, $myImg);
				$this->session->set_userdata('simages', $simages);
			}

			$config = array(
				'file_name'     => 'sx_' . $rand,
				'allowed_types' => 'jpg|jpeg|png|gif',
				'max_size'      => 3000,
				'overwrite'     => FALSE,
				'upload_path'   => $imagePath
			);

			//Load upload library
			$this->upload->initialize($config);

			// File upload
			if ($this->upload->do_upload('file')) {
				// Get data about the file
				$uploadData = $this->upload->data();
				$configer =  array(
					'image_library'   => 'gd2',
					'source_image'    =>  $uploadData['full_path'],
					'maintain_ratio'  =>  TRUE,
					'width'           =>  116,
					'height'          =>  116,
				);
				$this->image_lib->clear();
				$this->image_lib->initialize($configer);
				$this->image_lib->resize();
			}

			print_r($this->session->userdata('simages'));
		} else {
			$item_id = $this->input->post('item_id');
			$item_category = $this->input->post('item_category');
			$item_name = $this->input->post('item_name');
			$item_group = $this->input->post('item_group')==''?0:$this->input->post('item_group');
			// $item_code = $this->input->post('item_code');
			$item_uom = $this->input->post('item_uom')==''?0:$this->input->post('item_uom');
			$item_tax = $this->input->post('item_tax');
			$item_rate = $this->input->post('item_rate');
			$item_reorder_level = $this->input->post('item_reorder_level')==''?0:$this->input->post('item_reorder_level');
			$item_status = $this->input->post('item_status');

			$hsn_code = $this->input->post('hsn_code');

			$denier_name = $this->input->post('denier_name');
			$item_description = $this->input->post('item_description');
			$item_second_name = $this->input->post('item_second_name');
			$item_third_name = $this->input->post('item_third_name');
			$item_width = $this->input->post('item_width')==''?0:$this->input->post('item_width');
			$item_gpm = $this->input->post('item_gpm');

			$item_customers = @implode(",", $this->input->post('item_customers'));

			$next = $this->db->query("SELECT item_id FROM bud_items WHERE item_name = '" . $item_name . "' AND module = " . $this->session->userdata('user_viewed'));
			$next = $next->num_rows();

			if ($next > 0) {
				$this->session->set_flashdata('error', 'Item Name already exist, please try with differrent name');
				redirect(base_url() . "masters/items/" . $item_id . '/duplicate', 'refresh');
			}
		
			$formData = array(
				'item_category' => $item_category==""?0:$item_category,
				'item_name' => $item_name,
				'item_group' => $item_group,
				// 'item_code' => $item_code, 
				'item_uom' => $item_uom,
				'item_tax' => $item_tax,
				'direct_sales_rate' => $item_rate,
				'denier_name' => $denier_name,
				'item_description' => $item_description,
				'item_second_name' => $item_second_name,
				'item_third_name' => $item_third_name,
				'user' => $this->session->userdata('display_name'),
				'date' => date("Y-m-d H:i:s"),
				'item_width' => $item_width,
				'item_gpm' => $item_gpm,
				'hsn_code' => $hsn_code,
				'item_reorder_level' => $item_reorder_level,
				'item_customers' => $item_customers,
				'item_status' => $item_status,
				'item_sample' => implode(', ', $this->session->userdata('simages')),
				'module' => $this->session->userdata('user_viewed')
			);
			$result = $this->m_masters->savemaster('bud_items', $formData);
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "masters/items", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "masters/items", 'refresh');
			}
		}
	}
	function updateitems()
	{
		$item_id = $this->input->post('item_id');
		$item_category = $this->input->post('item_category');
		$item_name = $this->input->post('item_name');
		$item_group = $this->input->post('item_group');
		// $item_code = $this->input->post('item_code');
		$item_uom = $this->input->post('item_uom');
		$item_tax = $this->input->post('item_tax');
		$item_rate = $this->input->post('item_rate');
		$item_reorder_level = $this->input->post('item_reorder_level');
		$item_status = $this->input->post('item_status');
		$hsn_code = $this->input->post('hsn_code');

		$denier_name = $this->input->post('denier_name');
		$item_description = $this->input->post('item_description');
		$item_second_name = $this->input->post('item_second_name');
		$item_third_name = $this->input->post('item_third_name');
		$item_width = $this->input->post('item_width');
		$item_gpm = $this->input->post('item_gpm');

		$item_customers = @implode(",", $this->input->post('item_customers'));

		$next = $this->db->query("SELECT item_id FROM bud_items WHERE item_id <>'" . $item_id . "' AND item_name = '" . $item_name . "' AND module = " . $this->session->userdata('user_viewed'));
		$next = $next->num_rows();

		if ($next > 0) {
			$this->session->set_flashdata('error', 'Item Name already exist, please try with differrent name');
			redirect(base_url() . "masters/items/" . $item_id, 'refresh');
		}

		$formData = array(
			'item_category' => $item_category,
			'item_name' => $item_name,
			'item_group' => $item_group,
			// 'item_code' => $item_code, 
			'item_uom' => $item_uom,
			'item_tax' => $item_tax,
			'direct_sales_rate' => $item_rate,
			'denier_name' => $denier_name,
			'item_description' => $item_description,
			'item_second_name' => $item_second_name,
			'item_third_name' => $item_third_name,
			'user' => $this->session->userdata('display_name'),
			'date' => date("Y-m-d H:i:s"),
			'item_width' => $item_width,
			'item_gpm' => $item_gpm,
			'hsn_code' => $hsn_code,
			'item_reorder_level' => $item_reorder_level,
			'item_customers' => $item_customers,
			'item_status' => $item_status,
			'module' => $this->session->userdata('user_viewed')
		);
		$result = $this->m_masters->updatemaster('bud_items', 'item_id', $item_id, $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Updated!!!');
			redirect(base_url() . "masters/items", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/items", 'refresh');
		}
	}
	/* End Items Master */

	/* Start Get Item Category Datas */
	function getItamcategorydatas($category_id = null)
	{
		$itemgroupdata_arr = array();
		$itemgroupdata = '';
		$itemuomdata = '';
		$itemtaxdata = '';
		$itemgroups = $this->m_masters->getactiveCdatas('bud_itemgroups', 'group_status', 'group_category', $category_id);
		$itemuoms = $this->m_masters->getactiveCdatas('bud_uoms', 'uom_status', 'uom_category', $category_id);
		$itemtaxs = $this->m_masters->getactiveCdatas('bud_tax', 'tax_status', 'tax_category', $category_id);
		foreach ($itemgroups as $itemgroup) {
			$group_id = $itemgroup['group_id'];
			$group_name = $itemgroup['group_name'];
			$itemgroupdata .= '<option value="' . $group_id . '">' . $group_name . '</option>';
		}
		$itemgroupdata_arr[] = $itemgroupdata;
		foreach ($itemuoms as $itemuom) {
			$uom_id = $itemuom['uom_id'];
			$uom_name = $itemuom['uom_name'];
			$itemuomdata .= '<option value="' . $uom_id . '">' . $uom_name . '</option>';
		}
		$itemgroupdata_arr[] = $itemuomdata;
		foreach ($itemtaxs as $itemtax) {
			$tax_id = $itemtax['tax_id'];
			$tax_name = $itemtax['tax_name'];
			$itemtaxdata .= '<option value="' . $tax_id . '">' . $tax_name . '</option>';
		}
		$itemgroupdata_arr[] = $itemtaxdata;
		echo implode(",", $itemgroupdata_arr);
	}
	/* End Get Item Category Datas */
	function getLotscategorydatas($category_id = null)
	{
		$itemgroupdata_arr = array();
		$shadesdata = '';
		$shades = $this->m_masters->getactiveCdatas('bud_shades', 'shade_status', 'shade_category', $category_id);
		foreach ($shades as $shade) {
			$shade_id = $shade['shade_id'];
			$shade_name = $shade['shade_name'];
			$shadesdata .= '<option value="' . $shade_id . '">' . $shade_name . '</option>';
		}
		echo $shadesdata;
	}
	function getsupplierdatas($category_id = null)
	{
		$itemgroupdata_arr = array();
		$agentsdata = '';
		$agentsdata .= '<option value="">Select</option>';
		$agents = $this->m_masters->getactiveCdatas('bud_agents', 'agent_status', 'agent_category', $category_id);
		foreach ($agents as $agent) {
			$agent_id = $agent['agent_id'];
			$agent_name = $agent['agent_name'];
			$agentsdata .= '<option value="' . $agent_id . '">' . $agent_name . '</option>';
		}
		echo $agentsdata;
	}
	function getcustomerdatas($category_id = null)
	{
		$itemgroupdata_arr = array();
		$cuatomerdata = '';
		$cuatomerdata .= '<option value="">Select</option>';
		$customers = $this->m_masters->getactiveCdatas('bud_customers', 'cust_status', 'cust_category', $category_id);
		foreach ($customers as $customer) {
			$cust_id = $customer['cust_id'];
			$cust_name = $customer['cust_name'];
			$cuatomerdata .= '<option value="' . $cust_id . '">' . $cust_name . '</option>';
		}
		echo $cuatomerdata;
	}
	function recipedata($shade_id = null)
	{
		$data['shades'] = $this->m_masters->getmasterdetails('bud_shades', 'shade_id', $shade_id);
		$this->load->view('v_recipedata.php', $data);
	}
	function getenquirySelectdatas($category_id = null)
	{
		$itemgroupdata_arr = array();
		$supplierdata = '';
		$itemgroupdata = '';
		$uomsdata = '';
		$shadesdata = '';
		$lotsdata = '';
		$shades = $this->m_masters->getactiveCdatas('bud_shades', 'shade_status', 'shade_category', $category_id);
		$customers = $this->m_masters->getactiveCdatas('bud_customers', 'cust_status', 'cust_category', $category_id);
		$itemuoms = $this->m_masters->getactiveCdatas('bud_uoms', 'uom_status', 'uom_category', $category_id);
		foreach ($customers as $supplier) {
			$cust_id = $supplier['cust_id'];
			$cust_name = $supplier['cust_name'];
			$supplierdata .= '<option value="' . $cust_id . '">' . $cust_name . '</option>';
		}
		$itemgroupdata_arr[] = $supplierdata;
		foreach ($itemuoms as $itemuom) {
			$uom_id = $itemuom['uom_id'];
			$uom_name = $itemuom['uom_name'];
			$uomsdata .= '<option value="' . $uom_id . '">' . $uom_name . '</option>';
		}
		$itemgroupdata_arr[] = $uomsdata;
		$itemgroups = $this->m_masters->getactiveCdatas('bud_itemgroups', 'group_status', 'group_category', $category_id);
		$itemgroupdata .= '<option value="">Select Group</option>';
		foreach ($itemgroups as $itemgroup) {
			$group_id = $itemgroup['group_id'];
			$group_name = $itemgroup['group_name'];
			$itemgroupdata .= '<option value="' . $group_id . '">' . $group_name . '</option>';
		}
		$itemgroupdata_arr[] = $itemgroupdata;
		foreach ($shades as $shade) {
			$shade_id = $shade['shade_id'];
			$shade_name = $shade['shade_name'];
			$shadesdata .= '<option value="' . $shade_id . '">' . $shade_name . '</option>';
		}
		$itemgroupdata_arr[] = $shadesdata;
		$lots = $this->m_masters->getactiveCdatas('bud_lots', 'lot_status', 'category', $category_id);
		foreach ($lots as $lot) {
			$lot_id = $lot['lot_id'];
			$lot_no = $lot['lot_no'];
			$lotsdata .= '<option value="' . $lot_id . '">' . $lot_no . '</option>';
		}
		$itemgroupdata_arr[] = $lotsdata;
		echo implode(",", $itemgroupdata_arr);
	}

	function getItemsdatas($group_id = null)
	{
		$itemsdata_arr = array();
		$itemsdata = '';
		$items = $this->m_masters->getactiveCdatas('bud_items', 'item_status', 'item_group', $group_id);
		foreach ($items as $item) {
			$item_id = $item['item_id'];
			$item_name = $item['item_name'];
			$itemsdata .= '<option value="' . $item_id . '">' . $item_name . '</option>';
		}
		$itemsdata_arr[] = $itemsdata;
		echo implode(",", $itemsdata_arr);
	}


	// Taps And Elastics
	function machines_2()
	{
		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'machines_2';
		$data['page_title'] = 'Add New Machine';
		$data['machines'] = $this->m_masters->getallmaster('bud_te_machines');
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
			$this->load->view('v_2_machines.php', $data);
		} else {
			$data['machine_id'] = $this->uri->segment(3);
			$this->load->view('v_2_machines.php', $data);
		}
	}
	function machines_2_save()
	{
		$machine_type = $this->input->post('machine_type');
		$machine_name = $this->input->post('machine_name');
		$machine_second_name = $this->input->post('machine_second_name');
		$machine_no_tapes = $this->input->post('machine_no_tapes');
		$machine_no_tapes_act = $this->input->post('machine_no_tapes_act');
		$machine_rpm = $this->input->post('machine_rpm');
		$machine_rpm_day = $this->input->post('machine_rpm_day'); //ER-09-18#-62
		$machine_rpm_night = $this->input->post('machine_rpm_night'); //ER-09-18#-62
		$machine_speed = $this->input->post('machine_speed');
		$machine_production = $this->input->post('machine_production');
		$machine_pick_density = $this->input->post('machine_pick_density');
		$default_picks_shift = $this->input->post('default_picks_shift');
		$machine_status = $this->input->post('machine_status');
		$formData = array(
			'machine_type' => $machine_type,
			'machine_name' => $machine_name,
			'machine_second_name' => $machine_second_name,
			'machine_no_tapes' => $machine_no_tapes,
			'machine_no_tapes_act' => $machine_no_tapes_act,
			'machine_rpm' => $machine_rpm,
			'machine_rpm_day' => $machine_rpm_day, //ER-09-18#-62
			'machine_rpm_night' => $machine_rpm_night, //ER-09-18#-62
			'machine_speed' => $machine_speed,
			'machine_production' => $machine_production,
			'machine_pick_density' => $machine_pick_density,
			'default_picks_shift' => $default_picks_shift,
			'machine_status' => $machine_status
		);
		$result = $this->m_purchase->saveDatas('bud_te_machines', $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Updated!!!');
			redirect(base_url() . "masters/machines_2", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/machines_2", 'refresh');
		}
	}
	function machines_2_update()
	{
		$machine_id = $this->input->post('machine_id');
		$machine_type = $this->input->post('machine_type');
		$machine_name = $this->input->post('machine_name');
		$machine_second_name = $this->input->post('machine_second_name');
		$machine_no_tapes = $this->input->post('machine_no_tapes');
		$machine_no_tapes_act = $this->input->post('machine_no_tapes_act');
		$machine_rpm = $this->input->post('machine_rpm');
		$machine_rpm_day = $this->input->post('machine_rpm_day'); //ER-09-18#-62
		$machine_rpm_night = $this->input->post('machine_rpm_night'); //ER-09-18#-62
		$machine_speed = $this->input->post('machine_speed');
		$machine_production = $this->input->post('machine_production');
		$machine_pick_density = $this->input->post('machine_pick_density');
		$default_picks_shift = $this->input->post('default_picks_shift');
		$machine_status = $this->input->post('machine_status');
		$formData = array(
			'machine_type' => $machine_type,
			'machine_name' => $machine_name,
			'machine_second_name' => $machine_second_name,
			'machine_no_tapes' => $machine_no_tapes,
			'machine_no_tapes_act' => $machine_no_tapes_act,
			'machine_rpm' => $machine_rpm,
			'machine_rpm_day' => $machine_rpm_day, //ER-09-18#-62
			'machine_rpm_night' => $machine_rpm_night, //ER-09-18#-62
			'machine_speed' => $machine_speed,
			'machine_production' => $machine_production,
			'machine_pick_density' => $machine_pick_density,
			'default_picks_shift' => $default_picks_shift,
			'machine_status' => $machine_status
		);
		$result = $this->m_purchase->updateDatas('bud_te_machines', 'machine_id', $machine_id, $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Updated!!!');
			redirect(base_url() . "masters/machines_2", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/machines_2", 'refresh');
		}
	}
	function deletemaster()
	{
		$bud_te_machines = $this->uri->segment(3);
		$column_id = $this->uri->segment(4);
		$master_id = $this->uri->segment(5);
		$result = $this->m_masters->deletemaster($bud_te_machines, $column_id, $master_id);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Deleted!!!');
			redirect(base_url() . $this->uri->segment(6) . "/" . $this->uri->segment(7), 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . $this->uri->segment(6) . "/" . $this->uri->segment(7), 'refresh');
		}
	}
	function itemgroups_2()
	{
		$data['activeTab'] = 'item_masters';
		$data['activeItem'] = 'itemgroups_2';
		$data['page_title'] = 'Item Group Master';
		$data['itemgroups'] = $this->m_masters->getallmaster('bud_te_itemgroups');
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
			$this->load->view('v_2_itemgroups.php', $data);
		} else {
			$data['group_id'] = $this->uri->segment(3);
			$this->load->view('v_2_itemgroups.php', $data);
		}
	}
	function itemgroups_2_save()
	{
		/*echo '<pre>';
		print_r($this->input->post());
		echo '</pre>';*/
		$group_category = $this->input->post('group_category');
		$group_name = $this->input->post('group_name');
		$group_second_name = $this->input->post('group_second_name');
		$group_status = $this->input->post('group_status');
		$formData = array(
			'group_category' => $group_category,
			'group_name' => $group_name,
			'group_second_name' => $group_second_name,
			'group_status' => $group_status
		);
		$result = $this->m_purchase->saveDatas('bud_te_itemgroups', $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Updated!!!');
			redirect(base_url() . "masters/itemgroups_2", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/itemgroups_2", 'refresh');
		}
	}
	function itemgroups_2_update()
	{
		$group_id = $this->input->post('group_id');
		$group_category = $this->input->post('group_category');
		$group_name = $this->input->post('group_name');
		$group_second_name = $this->input->post('group_second_name');
		$group_status = $this->input->post('group_status');
		$formData = array(
			'group_category' => $group_category,
			'group_name' => $group_name,
			'group_second_name' => $group_second_name,
			'group_status' => $group_status
		);
		$result = $this->m_purchase->updateDatas('bud_te_itemgroups', 'group_id', $group_id, $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Updated!!!');
			redirect(base_url() . "masters/itemgroups_2", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/itemgroups_2", 'refresh');
		}
	}
	function items_2_view()
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_te_items'");
		$next = $next->row(0);
		$data['item_code'] = $next->Auto_increment;

		$data['activeTab'] = 'item_masters';
		$data['activeItem'] = 'items_2_view';
		$data['page_title'] = 'View Items';
		$data['itemgroups'] = $this->m_masters->getallmaster('bud_te_itemgroups');
		$data['items'] = $this->m_masters->getallmaster('bud_te_items');
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
		$this->load->view('v_2_view_items.php', $data);
	}
	function items_2()
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_te_items'");
		$next = $next->row(0);
		$data['item_code'] = $next->Auto_increment;

		$data['activeTab'] = 'item_masters';
		$data['activeItem'] = 'items_2';
		$data['page_title'] = 'Item Master';
		$data['itemgroups'] = $this->m_masters->getallmaster('bud_te_itemgroups');
		$data['items'] = $this->m_masters->getallmaster('bud_te_items');
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
			$this->load->view('v_2_items.php', $data);
		} else {
			$data['group_id'] = $this->uri->segment(3);
			$this->load->view('v_2_items.php', $data);
		}
	}
	function items_2_save()
	{
		$item_sample = '';
		$item_category = $this->input->post('item_category');
		$item_group = $this->input->post('item_group');
		$item_name = $this->input->post('item_name');
		$item_width = $this->input->post('item_width');
		$hsn_code = $this->input->post('hsn');
		$item_second_name = $this->input->post('item_second_name');
		$item_third_name = $this->input->post('item_third_name');
		$total_metrs = $this->input->post('total_metrs');
		$total_weight = $this->input->post('total_weight');
		// $item_weight_mtr = $this->input->post('item_weight_mtr');
		// $item_weight_mtr = $total_metrs/$total_weight;
		$item_weight_mtr = $total_weight / $total_metrs;
		$item_created_on = $this->input->post('item_created_on');
		$ed = explode("-", $item_created_on);
		$item_created_on = $ed[2] . '-' . $ed[1] . '-' . $ed[0];
		$item_status = $this->input->post('item_status');

		$config['upload_path'] = 'uploads/itemsamples/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']	= '16000';
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['overwrite'] = FALSE;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		$img_ext_chk = array('jpg', 'png', 'gif', 'jpeg');

		if (!$this->upload->do_upload('sample_file')) {
			$error = array('error' => $this->upload->display_errors());
			// print_r($error);
			// exit();
		} else {
			$image = $this->upload->data();
			$item_sample = $image['file_name'];
		}

		$formData = array(
			'item_category' => $item_category,
			'item_group' => $item_group,
			'item_name' => $item_name,
			'item_width' => $item_width,
			'item_second_name' => $item_second_name,
			'item_third_name' => $item_third_name,
			'total_metrs' => $total_metrs,
			'total_weight' => $total_weight,
			'item_weight_mtr' => $item_weight_mtr,
			'item_created_on' => $item_created_on,
			'item_sample' => $item_sample,
			'item_status' => $item_status,
			'hsn_code' => $hsn_code
		);
		$result = $this->m_purchase->saveDatas('bud_te_items', $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Updated!!!');
			redirect(base_url() . "masters/items_2", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/items_2", 'refresh');
		}
	}
	function edititems_2()
	{
		$item_id = $this->uri->segment(3);
		$data['activeTab'] = 'item_masters';
		$data['activeItem'] = 'items_2';
		$data['page_title'] = 'Edit Item Master';
		$data['itemgroups'] = $this->m_masters->getallmaster('bud_te_itemgroups');
		$data['shades'] = $this->m_masters->getactivemaster('bud_te_shades', 'shade_status');
		$data['items'] = $this->m_masters->getmasterdetails('bud_te_items', 'item_id', $item_id);

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
			$this->load->view('v_2_edit_items.php', $data);
		} else {
			$data['group_id'] = $this->uri->segment(3);
			$this->load->view('v_2_edit_items.php', $data);
		}
	}
	function items_2_update()
	{
		$item_sample = '';
		$item_id = $this->input->post('item_id');
		$item_category = $this->input->post('item_category');
		$item_group = $this->input->post('item_group');
		$item_name = $this->input->post('item_name');
		$item_second_name = $this->input->post('item_second_name');
		$item_third_name = $this->input->post('item_third_name');
		$item_width = $this->input->post('item_width');
		$hsn_code = $this->input->post('hsn');
		$total_metrs = $this->input->post('total_metrs');
		$total_weight = $this->input->post('total_weight');
		// $item_weight_mtr = $this->input->post('item_weight_mtr');
		$item_weight_mtr = $total_weight / $total_metrs;
		$item_created_on = $this->input->post('item_created_on');
		$ed = explode("-", $item_created_on);
		$item_created_on = $ed[2] . '-' . $ed[1] . '-' . $ed[0];
		$item_status = $this->input->post('item_status');

		$old_item_sample = $this->input->post('old_item_sample');
		$item_sample = $old_item_sample;
		$config['upload_path'] = 'uploads/itemsamples/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']	= '16000';
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['overwrite'] = FALSE;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		$img_ext_chk = array('jpg', 'png', 'gif', 'jpeg');

		if (!$this->upload->do_upload('sample_file')) {
			$error = array('error' => $this->upload->display_errors());
			// print_r($error);
			// exit();
		} else {
			if ($old_item_sample != '') {
				if (file_exists('uploads/itemsamples/' . $old_item_sample)) {
					unlink('uploads/itemsamples/' . $old_item_sample);
				}
			}
			$image = $this->upload->data();
			$item_sample = $image['file_name'];
		}

		$formData = array(
			'item_category' => $item_category,
			'item_group' => $item_group,
			'item_name' => $item_name,
			'item_second_name' => $item_second_name,
			'item_third_name' => $item_third_name,
			'item_width' => $item_width,
			'total_metrs' => $total_metrs,
			'total_weight' => $total_weight,
			'item_weight_mtr' => $item_weight_mtr,
			'item_created_on' => $item_created_on,
			'item_sample' => $item_sample,
			'item_status' => $item_status,
			'hsn_code' => $hsn_code
		);
		$result = $this->m_purchase->updateDatas('bud_te_items', 'item_id', $item_id, $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Updated!!!');
			redirect(base_url() . "masters/items_2", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/items_2", 'refresh');
		}
	}
	// Item Technical Master
	function items_2_technical()
	{
		$item_id = $this->uri->segment(3);
		$combo_id = $this->uri->segment(4);
		$data['activeTab'] = 'item_masters';
		$data['activeItem'] = 'items_2_technical';
		$data['page_title'] = 'Item Technical Master';
		$data['itemgroups'] = $this->m_masters->getallmaster('bud_te_itemgroups');
		$data['shades'] = $this->m_masters->getactivemaster('bud_shades', 'shade_status');
		$data['deniers'] = $this->m_masters->getactivemaster('bud_deniermaster', 'denier_status');
		$data['items'] = $this->m_masters->getmasterdetails('bud_te_items', 'item_id', $item_id);
		$data['colorcombos'] = $this->m_masters->getmasterdetails('bud_te_color_combos', 'item_id', $item_id);
		$data['css'] = array(
			'css/bootstrap.min.css',
			'css/bootstrap-reset.css',
			'assets/font-awesome/css/font-awesome.css',
			'assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css',
			'css/owl.carousel.css',
			'css/style.css',
			'css/select2.css',
			'css/style-responsive.css',
			'assets/bootstrap-datepicker/css/datepicker.css',
			'css/jquery.fancybox.css'
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
			'assets/data-tables/DT_bootstrap.js',
			'js/jquery.fancybox.js'
		);
		$data['js_common'] = array('js/common-scripts.js');
		$data['js_thispage'] = array('js/form-validation-script.js', 'js/form-component.js', 'js/dynamic-table.js');

		if ($this->uri->segment(4) === FALSE) {
			$data['combo_id'] = '';
		} else {
			$data['combo_id'] = $this->uri->segment(4);
			$data['colorcombo'] = $this->m_masters->getmasterdetails('bud_te_color_combos', 'combo_id', $this->uri->segment(4));
		}

		if ($this->uri->segment(3) === FALSE) {
			$this->load->view('v_2_item_tech_search.php', $data);
		} else {
			$data['group_id'] = $this->uri->segment(3);
			$this->load->view('v_2_items_technical.php', $data);
		}
	}
	function items_2_technical_save()
	{
		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';*/
		$net_weight = array();
		$item_id = $this->input->post('item_id');
		$item_pick_density = $this->input->post('item_pick_density');
		$item_width = $this->input->post('item_width');
		$item_design_code = $this->input->post('item_design_code');
		$item_design_weave = $this->input->post('item_design_weave');
		$item_weave_remarks = $this->input->post('item_weave_remarks');
		$item_width_num = (int) $this->input->post('item_width');
		$shade_name = $this->input->post('shade_name');
		$shade_code = $this->input->post('shade_code');
		$denier = $this->input->post('denier');
		$no_ends = $this->input->post('no_ends');
		// New
		$ends_heald = $this->input->post('ends_heald');
		$healds_dent = $this->input->post('healds_dent');
		$design_weave = $this->input->post('design_weave');
		// End New
		$percentage = $this->input->post('percentage');
		$old_item_sample = $this->input->post('old_item_sample');
		$item_sample = $old_item_sample;
		$config['upload_path'] = 'uploads/itemsamples/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']	= '16000';
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['overwrite'] = FALSE;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		$img_ext_chk = array('jpg', 'png', 'gif', 'jpeg');

		if (!$this->upload->do_upload('sample_file')) {
			$error = array('error' => $this->upload->display_errors());
			// print_r($error);
			// exit();
		} else {
			if ($old_item_sample != '') {
				if (file_exists('uploads/itemsamples/' . $old_item_sample)) {
					unlink('uploads/itemsamples/' . $old_item_sample);
				}
			}
			$image = $this->upload->data();
			$item_sample = $image['file_name'];
		}

		if ($shade_name[0] > 0) {
			foreach ($denier as $key => $value) {
				/*if($key == 3)
				{
					$denier_val = $this->m_masters->getmasterIDvalue('bud_deniermaster', 'denier_id', $value, 'denier_tech');
					// $no_ends[$key] = ($item_width_num * $item_pick_density * 39) / 1000;
					$no_ends[$key] = ($item_width_num * $no_ends[$key] * $denier_val) / 1000;
					$val = (($denier_val * $no_ends[$key]) / 9000) + ((($denier_val * $no_ends[$key]) / 9000) * $percentage[$key]) / 100;
					$net_weight[] = number_format($val, 4, '.', '');
				}
				else
				{
					$denier_val = $this->m_masters->getmasterIDvalue('bud_deniermaster', 'denier_id', $value, 'denier_tech');				
					$val = (($denier_val * $no_ends[$key]) / 9000) + ((($denier_val * $no_ends[$key]) / 9000) * $percentage[$key]) / 100;
					$net_weight[] = number_format($val, 4, '.', '');
				}*/

				$denier_val = $this->m_masters->getmasterIDvalue('bud_deniermaster', 'denier_id', $value, 'denier_tech');
				$val = (($denier_val * $no_ends[$key]) / 9000) + ((($denier_val * $no_ends[$key]) / 9000) * $percentage[$key]) / 100;
				$net_weight[] = number_format($val, 4, '.', '');
			}
			$formData = array(
				'item_id' => $item_id,
				'shade_name' => implode(",", $shade_name),
				'shade_code' => implode(",", $shade_code),
				'denier' => implode(",", $denier),
				'no_ends' => implode(",", $no_ends),
				'ends_heald' => implode(",", $ends_heald),
				'healds_dent' => implode(",", $healds_dent),
				'design_weave' => implode(",", $design_weave),
				'net_weight' => implode(",", $net_weight),
				'percentage' => implode(",", $percentage)
			);
			$result = $this->m_purchase->saveDatas('bud_te_color_combos', $formData);
			if ($result) {
				$updateData = array(
					'item_pick_density' => $item_pick_density,
					'item_width' => $item_width,
					'item_design_code' => $item_design_code,
					'item_design_weave' => $item_design_weave,
					'item_weave_remarks' => $item_weave_remarks,
					'item_sample' => $item_sample
				);
				$this->m_purchase->updateDatas('bud_te_items', 'item_id', $item_id, $updateData);

				$this->session->set_flashdata('success', 'Successfully Updated!!!');
				redirect(base_url() . "masters/items_2_technical/" . $item_id, 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "masters/items_2_technical/" . $item_id, 'refresh');
			}
		} else {
			$updateData = array(
				'item_pick_density' => $item_pick_density,
				'item_width' => $item_width,
				'item_design_code' => $item_design_code,
				'item_design_weave' => $item_design_weave,
				'item_weave_remarks' => $item_weave_remarks,
				'item_sample' => $item_sample
			);
			$result = $this->m_purchase->updateDatas('bud_te_items', 'item_id', $item_id, $updateData);
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Updated!!!');
				redirect(base_url() . "masters/items_2_technical/" . $item_id, 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "masters/items_2_technical/" . $item_id, 'refresh');
			}
		}
	}
	function items_2_technical_update()
	{

		$net_weight = array();
		$combo_id = $this->input->post('combo_id');
		$item_id = $this->input->post('item_id');
		$item_width = $this->input->post('item_width');
		$item_design_code = $this->input->post('item_design_code');
		$item_design_weave = $this->input->post('item_design_weave');
		$item_weave_remarks = $this->input->post('item_weave_remarks');
		$item_width_num = (int) $this->input->post('item_width');
		$item_pick_density = $this->input->post('item_pick_density');
		$shade_name = $this->input->post('shade_name');
		$shade_code = $this->input->post('shade_code');
		$denier = $this->input->post('denier');
		$no_ends = $this->input->post('no_ends');
		$percentage = $this->input->post('percentage');
		// New
		$ends_heald = $this->input->post('ends_heald');
		$healds_dent = $this->input->post('healds_dent');
		$design_weave = $this->input->post('design_weave');
		// End New
		$old_item_sample = $this->input->post('old_item_sample');
		$item_sample = '';
		$config['upload_path'] = 'uploads/itemsamples/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']	= '16000';
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['overwrite'] = FALSE;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		$img_ext_chk = array('jpg', 'png', 'gif', 'jpeg');

		if (!$this->upload->do_upload('sample_file')) {
			$error = array('error' => $this->upload->display_errors());
			// print_r($error);
			// exit();
		} else {
			if ($old_item_sample != '') {
				if (file_exists('uploads/itemsamples/' . $photo_filename)) {
					unlink('uploads/itemsamples/' . $photo_filename);
				}
			}
			$image = $this->upload->data();
			$item_sample = $image['file_name'];
		}
		foreach ($denier as $key => $value) {
			/*if($key == 3)
			{
				$no_ends[$key] = ($item_width_num * $item_pick_density * 39) / 1000;
				$denier_val = $this->m_masters->getmasterIDvalue('bud_deniermaster', 'denier_id', $value, 'denier_tech');
				$val = (($denier_val * $no_ends[$key]) / 9000) + ((($denier_val * $no_ends[$key]) / 9000) * $percentage[$key]) / 100;
				$net_weight[] = number_format($val, 4, '.', '');
			}
			else
			{
				$denier_val = $this->m_masters->getmasterIDvalue('bud_deniermaster', 'denier_id', $value, 'denier_tech');
				$val = (($denier_val * $no_ends[$key]) / 9000) + ((($denier_val * $no_ends[$key]) / 9000) * $percentage[$key]) / 100;
				$net_weight[] = number_format($val, 4, '.', '');
			}*/

			$denier_val = $this->m_masters->getmasterIDvalue('bud_deniermaster', 'denier_id', $value, 'denier_tech');
			$val = (($denier_val * $no_ends[$key]) / 9000) + ((($denier_val * $no_ends[$key]) / 9000) * $percentage[$key]) / 100;
			$net_weight[] = number_format($val, 4, '.', '');
		}
		$formData = array(
			'item_id' => $item_id,
			'shade_name' => implode(",", $shade_name),
			'shade_code' => implode(",", $shade_code),
			'denier' => implode(",", $denier),
			'no_ends' => implode(",", $no_ends),
			'ends_heald' => implode(",", $ends_heald),
			'healds_dent' => implode(",", $healds_dent),
			'design_weave' => implode(",", $design_weave),
			'net_weight' => implode(",", $net_weight),
			'percentage' => implode(",", $percentage)
		);

		$result = $this->m_purchase->updateDatas('bud_te_color_combos', 'combo_id', $combo_id, $formData);
		if ($result) {
			$updateData = array(
				'item_pick_density' => $item_pick_density,
				'item_width' => $item_width,
				'item_design_code' => $item_design_code,
				'item_design_weave' => $item_design_weave,
				'item_weave_remarks' => $item_weave_remarks,
				'item_sample' => $item_sample
			);
			$this->m_purchase->updateDatas('bud_te_items', 'item_id', $item_id, $updateData);

			$this->session->set_flashdata('success', 'Successfully Updated!!!');
			redirect(base_url() . "masters/items_2_technical/" . $item_id, 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/items_2_technical/" . $item_id, 'refresh');
		}
	}
	function items_2_technical_copy($combo_id = null)
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_te_color_combos'");
		$next = $next->row(0);
		$nextcombo = $next->Auto_increment;

		$item_id = $this->uri->segment(3);
		$combo_id = $this->uri->segment(4);
		$colorcombos = $this->m_masters->getmasterdetails('bud_te_color_combos', 'combo_id', $combo_id);
		foreach ($colorcombos as $colorcombo) {
			$item_id = $colorcombo['item_id'];
			$shade_name = $colorcombo['shade_name'];
			$shade_code = $colorcombo['shade_code'];
			$denier = $colorcombo['denier'];
			$no_ends = $colorcombo['no_ends'];
			$net_weight = $colorcombo['net_weight'];
			$percentage = $colorcombo['percentage'];
		}
		$formData = array(
			'item_id' => $item_id,
			'shade_name' => $shade_name,
			'shade_code' => $shade_code,
			'denier' => $denier,
			'no_ends' => $no_ends,
			'net_weight' => $net_weight,
			'percentage' => $percentage
		);
		$result = $this->m_purchase->saveDatas('bud_te_color_combos', $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "masters/items_2_technical/" . $item_id . "/" . $nextcombo, 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/items_2_technical/" . $item_id, 'refresh');
		}
	}
	function items_2_technical_delete()
	{
		$item_id = $this->uri->segment(3);
		$combo_id = $this->uri->segment(4);
		$result = $this->m_masters->deletemaster('bud_te_color_combos', 'combo_id', $combo_id);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Deleted!!!');
			redirect(base_url() . "masters/items_2_technical/" . $item_id, 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/items_2_technical/" . $item_id, 'refresh');
		}
	}
	function tech_advanced()
	{
		$data['combo_id'] = $this->input->post('combo_id');
		$data['no_beams'] = $this->input->post('no_beams');
		$data['item_id'] = $this->input->post('item_id');
		$data['colorcombo'] = $this->m_masters->getmasterdetails('bud_te_color_combos', 'combo_id', $this->input->post('combo_id'));
		$data['activeTab'] = 'item_masters';
		$data['activeItem'] = 'items_2_technical';
		$data['page_title'] = 'Advance Technical Settings';
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
		$this->load->view('v_2_tech_advanced.php', $data);
	}
	function tech_advanced_save()
	{
		$item_id = $this->input->post('item_id');
		$combo_id = $this->input->post('combo_id');
		$beams_qty_arr = $this->input->post('beams_qty');
		foreach ($beams_qty_arr as $key => $value) {
			$beams_qty[$key] = implode(",", $value);
			$no_beams[$key] = sizeof($value);
		}
		$formData = array(
			'no_beams' => implode(",", $no_beams),
			'beams_qty' => implode("|", $beams_qty),
		);
		$result = $this->m_purchase->updateDatas('bud_te_color_combos', 'combo_id', $combo_id, $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Updated!!!');
			redirect(base_url() . "masters/items_2_technical/" . $item_id, 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/items_2_technical/" . $item_id, 'refresh');
		}
	}
	function stockrooms_1()
	{
		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'stockrooms_1';
		$data['page_title'] = 'Sub Stock Room Master';
		$data['stock_rooms'] = $this->m_masters->getallmaster('bud_sub_stock_rooms');
		$data['concerns'] = $this->m_masters->getallmaster('bud_concern_master');
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
			$data['stock_room_id'] = '';
			$this->load->view('v_stockrooms.php', $data);
		} else {
			$data['stock_room_id'] = $this->uri->segment(3);
			$this->load->view('v_stockrooms.php', $data);
		}
	}
	function stockrooms_1_save()
	{
		$stock_room_id = $this->input->post('stock_room_id');
		$stock_room_name = $this->input->post('stock_room_name');
		$concern_id = $this->input->post('concern_id');
		$stock_room_status = ($this->input->post('stock_room_status') == 1) ? 1 : 0;
		$formData = array(
			'module_id' => $this->session->userdata('user_viewed'),
			'stock_room_name' => $stock_room_name,
			'concern_id' => $concern_id,
			'stock_room_status' => $stock_room_status
		);
		if ($stock_room_id == '') {
			$result = $this->m_masters->savemaster('bud_stock_rooms', $formData);
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "masters/stockrooms_2", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "masters/stockrooms_2", 'refresh');
			}
		} else {
			$result = $this->m_masters->updatemaster('bud_stock_rooms', 'stock_room_id', $stock_room_id, $formData);
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "masters/stockrooms_2", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "masters/stockrooms_2", 'refresh');
			}
		}
	}

	function stockrooms_2()
	{
		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'stockrooms_2';
		$data['page_title'] = 'Stock Room Master';
		$data['stock_rooms'] = $this->m_masters->getallmaster('bud_stock_rooms');
		$data['concerns'] = $this->m_masters->getallmaster('bud_concern_master');
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
			$data['stock_room_id'] = '';
			$this->load->view('v_2_stockrooms.php', $data);
		} else {
			$data['stock_room_id'] = $this->uri->segment(3);
			$this->load->view('v_2_stockrooms.php', $data);
		}
	}
	function stockrooms_2_save()
	{
		$stock_room_id = $this->input->post('stock_room_id');
		$stock_room_name = $this->input->post('stock_room_name');
		$concern_id = $this->input->post('concern_id');
		$stock_room_status = ($this->input->post('stock_room_status') == 1) ? 1 : 0;
		$formData = array(
			'module_id' => $this->session->userdata('user_viewed'),
			'stock_room_name' => $stock_room_name,
			'concern_id' => $concern_id,
			'stock_room_status' => $stock_room_status
		);
		if ($stock_room_id == '') {
			$result = $this->m_masters->savemaster('bud_stock_rooms', $formData);
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "masters/stockrooms_2", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "masters/stockrooms_2", 'refresh');
			}
		} else {
			$result = $this->m_masters->updatemaster('bud_stock_rooms', 'stock_room_id', $stock_room_id, $formData);
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "masters/stockrooms_2", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "masters/stockrooms_2", 'refresh');
			}
		}
	}

	function stockroommanager()
	{
		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'stockroommanager';
		$data['page_title'] = 'Stock Room Manager';
		$data['stock_rooms'] = $this->m_masters->getallmaster('dost_stock_room_manager');;
		$data['concerns'] = $this->m_masters->getallmaster('bud_concern_master');
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
			$data['stock_room_id'] = '';
			$this->load->view('v_2_stockmanager.php', $data);
		} else {
			$data['stock_room_id'] = $this->uri->segment(3);
			$this->load->view('v_2_stockmanager.php', $data);
		}
	}
	function stockroommanager_save()
	{
		//echo '<pre>'; print_r($_POST); die;
		$stock_room_id = $this->input->post('stock_room_id');
		$concern_id = $this->input->post('concern_id');
		$stock_room_name = $this->input->post('stock_room_name');
		$blocks = $this->input->post('blocks');
		$stock_room_status = $this->input->post('stock_room_status');

		$formData = array(
			'concern_id' => $concern_id,
			'building_name' => $stock_room_name,
			'status' => $stock_room_status,
			'user' => $this->session->userdata('display_name'),
			'date' => date("Y-m-d H:i:s"),
			'module' => $this->session->userdata('user_viewed'),
		);

		if ($stock_room_id == '') {
			$result = $this->m_masters->savemaster('dost_stock_room_manager', $formData);
			if ($result) {

				if ($blocks) {
					foreach ($blocks as $block) {
						$formData2 = array(
							'stock_room_id' => $result,
							'block_name' => $block,
							'block_capacity' => 0,
							'status' => 1,
							'user' => $this->session->userdata('display_name'),
							'date' => date("Y-m-d H:i:s")
						);
						$this->m_masters->savemaster('dost_stock_block', $formData2);
					}
				}

				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "masters/stockroommanager", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "masters/stockroommanager", 'refresh');
			}
		} else {
			$result = $this->m_masters->updatemaster('dost_stock_room_manager', 'id', $stock_room_id, $formData);
			if ($result) {

				if ($blocks) {

					$formDatad = array(
						'status' => 0
					);
					$this->m_masters->updatedisablemaster('dost_stock_block', 'stock_room_id', $stock_room_id, $formDatad);

					$formData2 = array(
						'stock_room_id' => $stock_room_id,
						'remarks' => 'Building and Blocks Updated',
						'userby' => $this->session->userdata('display_name'),
						'dateby' => date("Y-m-d H:i:s")
					);
					$this->m_masters->savemaster('dost_stock_room_log', $formData2);

					foreach ($blocks as $id => $block) {

						$roomblocks = $this->m_masters->getmasterdetails2('dost_stock_block', 'id', $id, 'stock_room_id', $stock_room_id);

						if ($roomblocks) {

							$formData2 = array(
								'block_name' => $block,
								'status' => 1,
								'user' => $this->session->userdata('display_name')
							);
							$roomblocks = $this->m_masters->updatemaster2('dost_stock_block', 'id', $id, 'stock_room_id', $stock_room_id, $formData2);
						} else {

							$formData2 = array(
								'stock_room_id' => $stock_room_id,
								'block_name' => $block,
								'block_capacity' => 0,
								'status' => 1,
								'user' => $this->session->userdata('display_name'),
								'date' => date("Y-m-d H:i:s")
							);
							$this->m_masters->savemaster('dost_stock_block', $formData2);
						}
					}
				}

				$this->session->set_flashdata('success', 'Successfully Updated!!!');
				redirect(base_url() . "masters/stockroommanager", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "masters/stockroommanager", 'refresh');
			}
		}
	}

	function stockroomrackmanager()
	{
		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'stockroomrackmanager';
		$data['page_title'] = 'Stock Room Rack Manager';
		$data['stock_rooms'] = $this->m_masters->getallmaster('dost_stock_room_manager');
		$data['stock_blocks'] = $this->m_masters->getallmaster('dost_stock_block');
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
			$data['stock_room_id'] = '';
			$this->load->view('v_2_stockrackmanager.php', $data);
		} else {
			$data['stock_room_id'] = $this->uri->segment(3);
			$this->load->view('v_2_stockrackmanager.php', $data);
		}
	}
	function stockroomrackmanager_save()
	{
		$rack = $this->input->post('rack');
		$rack_sizes = $this->input->post('rack_sizes');
		$result = false;
		if ($rack) {
			foreach ($rack as $block_id => $block_name) {
				if ($block_id) {
					$formDatad = array(
						'status' => 0
					);
					$this->m_masters->updatedisablemaster('dost_stock_rack', 'block_id', $block_id, $formDatad);

					$formData2 = array(
						'block_id' => $block_id,
						'remarks' => 'Racks Updated',
						'userby' => $this->session->userdata('display_name'),
						'dateby' => date("Y-m-d H:i:s")
					);
					$this->m_masters->savemaster('dost_stock_room_log', $formData2);
				}
			}
			foreach ($rack as $block_id => $block_name) {
				if ($block_name) {
					foreach ($block_name as $rack_id => $rack_name) {

						$roomblocks = $this->m_masters->getmasterdetails2('dost_stock_rack', 'id', $rack_id, 'block_id', $block_id);
						if ($roomblocks) {

							$formData = array(
								'rack_name' => $rack_name,
								'rack_capacity' => $rack_sizes[$block_id][$rack_id],
								'status' => 1,
								'user' => $this->session->userdata('display_name')
							);
							$result = $this->m_masters->updatemaster2('dost_stock_rack', 'id', $rack_id, 'block_id', $block_id, $formData);
						} else {

							$formData = array(
								'block_id' => $block_id,
								'rack_name' => $rack_name,
								'rack_capacity' => $rack_sizes[$block_id][$rack_id],
								'status' => 1,
								'user' => $this->session->userdata('display_name'),
								'date' => date("Y-m-d H:i:s")
							);
							$result = $this->m_masters->savemaster('dost_stock_rack', $formData);
						}
					}
				}
			}
		}
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Updated!!!');
			redirect(base_url() . "masters/stockroomrackmanager", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/stockroomrackmanager", 'refresh');
		}
	}

	function stockroomtree()
	{
		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'stockroomtree';
		$data['page_title'] = 'Stock Room Building Tree';
		$data['stock_rooms'] = $this->m_masters->getallmaster('dost_stock_room_manager');
		$data['stock_blocks'] = $this->m_masters->getallmaster('dost_stock_block');
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
			$data['stock_room_id'] = '';
			$this->load->view('v_2_stockroomtree.php', $data);
		} else {
			$data['stock_room_id'] = $this->uri->segment(3);
			$this->load->view('v_2_stockroomtree.php', $data);
		}
	}

	function stockroomassign()
	{
		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'stockroomassign';
		$data['page_title'] = 'Stock Room Box Assign';

		$filter = array();
		$filter['include_soft'] = false;

		$data['d_outerboxes'] = $this->m_delivery->get_packing_boxes_v2($filter);

		$data['stock_rooms'] = $this->m_masters->getallmaster('dost_stock_room_manager');

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
			$this->load->view('v_1_stockroomassign', $data);
		} else {
			$this->load->view('v_1_stockroomassign', $data);
		}
	}

	function stockroomassign_save()
	{
		$building_id = $this->input->post('building_name');
		$building_name = $this->input->post('building');
		$block_id = $this->input->post('block_name');
		$block_name = $this->input->post('block');
		$rack_id = $this->input->post('rack_name');
		$rack_name = $this->input->post('rack');
		$boxes = $this->input->post('boxes');

		if ($boxes) {
			$boxes = explode(',', $boxes);
			foreach ($boxes as $box_id) {
				if ($box_id != 'on') {
					$formData = array(
						'box_id' => $box_id,
						'building_id' => $building_id,
						'building_name' => $building_name,
						'block_id' => $block_id,
						'block_name' => $block_name,
						'rack_id' => $rack_id,
						'rack_name' => $rack_name,
						'status' => 1,
						'user' => $this->session->userdata('display_name'),
						'date' => date("Y-m-d H:i:s")
					);
					$result = $this->m_masters->savemaster('dost_stock_room_box', $formData);
				}
			}
		}

		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Updated!!!');
			redirect(base_url() . "masters/stockroomassign", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/stockroomassign", 'refresh');
		}
	}

	function stockroomupdate()
	{
		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'stockroomupdate';
		$data['page_title'] = 'Stock Room Box Update';

		$filter = array();
		$filter['include_soft'] = false;

		$data['d_outerboxes'] = $this->m_delivery->get_packing_boxes_v2($filter);

		$data['stock_rooms'] = $this->m_masters->getallmaster('dost_stock_room_manager');

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
			$this->load->view('v_1_stockroomupdate', $data);
		} else {
			$this->load->view('v_1_stockroomupdate', $data);
		}
	}

	function stockroomupdate_save()
	{
		$building_id = $this->input->post('building_name');
		$building_name = $this->input->post('building');
		$block_id = $this->input->post('block_name');
		$block_name = $this->input->post('block');
		$rack_id = $this->input->post('rack_name');
		$rack_name = $this->input->post('rack');
		$boxes = $this->input->post('boxes');

		if ($boxes) {
			$boxes = explode(',', $boxes);
			foreach ($boxes as $box_id) {
				if ($box_id != 'on') {

					$boxData = $this->m_masters->getmasterdetails('dost_stock_room_box', 'box_id', $box_id);
					$boxData[0]['userby'] = $this->session->userdata('display_name');
					$boxData[0]['dateby'] = date("Y-m-d H:i:s");
					$result = $this->m_masters->savemaster('dost_stock_room_box_log', $boxData[0]);

					$formData = array(
						'building_id' => $building_id,
						'building_name' => $building_name,
						'block_id' => $block_id,
						'block_name' => $block_name,
						'rack_id' => $rack_id,
						'rack_name' => $rack_name,
						'status' => 1,
						'user' => $this->session->userdata('display_name'),
						'date' => date("Y-m-d H:i:s")
					);
					$result = $this->m_masters->updatemaster('dost_stock_room_box', 'box_id', $box_id, $formData);
				}
			}
		}

		if (@$result) {
			$this->session->set_flashdata('success', 'Successfully Updated!!!');
			redirect(base_url() . "masters/stockroomupdate", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/stockroomupdate", 'refresh');
		}
	}

	function get_block_list()
	{
		$id = $this->input->post('id');
		$options = '<option value="">Select Block</option>';
		if ($id != "") {
			$roomblock = $this->m_masters->getmasterdetails('dost_stock_block', 'stock_room_id', $id);
			if ($roomblock) {
				foreach ($roomblock as $block) {
					if ($block['status'] == false) {
						continue;
					}

					$options .= '<option value="' . $block['id'] . '">' . $block['block_name'] . '</option>';
				}
			}
		}
		echo $options;
	}

	function get_rack_list()
	{
		$id = $this->input->post('id');
		$options = '<option value="">Select Rack</option>';
		if ($id != "") {
			$roomracks = $this->m_masters->getmasterdetails('dost_stock_rack', 'block_id', $id);
			if ($roomracks) {
				foreach ($roomracks as $rack) {
					if ($rack['status'] == false) {
						continue;
					}

					$options .= '<option value="' . $rack['id'] . '">' . $rack['rack_name'] . '</option>';
				}
			}
		}
		echo $options;
	}

	function get_rack_count()
	{
		$id = $this->input->post('id');
		$options = '';
		if ($id != "") {
			$aroomracks = $this->m_masters->getmasterdetails('dost_stock_room_box', 'rack_id', $id);
			$roomracks = $this->m_masters->getmasterdetails('dost_stock_rack', 'id', $id);
			if ($roomracks) {
				foreach ($roomracks as $rack) {
					if ($rack['status'] == false) {
						continue;
					}

					$options .= '<span id="rack_count_total">' . $rack['rack_capacity'] . '</span>-<span id="rack_count_used">' . count($aroomracks) . '</span>=<span id="rack_count_pending">' . ($rack['rack_capacity'] - count($aroomracks)) . '</span>-';
				}
			}
		}
		echo $options;
	}

	// Labels
	function itemgroups_3()
	{
		$data['activeTab'] = 'item_masters';
		$data['activeItem'] = 'itemgroups_3';
		$data['page_title'] = 'Item Group Master';
		$data['itemgroups'] = $this->m_masters->getallmaster('bud_lbl_itemgroups');
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
			$this->load->view('labels/v_3_itemgroups.php', $data);
		} else {
			$data['group_id'] = $this->uri->segment(3);
			$this->load->view('labels/v_3_itemgroups.php', $data);
		}
	}
	function save_itemgroups_3()
	{
		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';*/
		$group_id = $this->input->post('group_id');
		$formData = $this->input->post('formData');
		if ($group_id == '') {
			$result = $this->m_masters->savemaster('bud_lbl_itemgroups', $formData);
		} else {
			$result = $this->m_masters->updatemaster('bud_lbl_itemgroups', 'group_id', $group_id, $formData);
		}
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "masters/itemgroups_3", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/itemgroups_3", 'refresh');
		}
	}
	function items_3()
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_lbl_items'");
		$next = $next->row(0);
		$data['item_code'] = $next->Auto_increment;
		$data['activeTab'] = 'item_masters';
		$data['activeItem'] = 'items_3';
		$data['page_title'] = 'Item Master';
		$data['itemgroups'] = $this->m_masters->getallmaster('bud_lbl_itemgroups');
		$data['items'] = $this->m_masters->getallmaster('bud_lbl_items');
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
			$this->load->view('labels/v_3_items.php', $data);
		} else {
			$data['item_id'] = $this->uri->segment(3);
			$this->load->view('labels/v_3_items.php', $data);
		}
	}
	function save_item_3()
	{
		$item_sample = '';
		$item_id = $this->input->post('item_id');
		$formData = $this->input->post('formData');
		$old_item_sample = $this->input->post('old_item_sample');
		$date = explode("-", $formData['item_created_on']);
		$formData['item_created_on'] = $date[2] . '-' . $date[1] . '-' . $date[0];

		$config['upload_path'] = 'uploads/itemsamples/labels/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']	= '16000';
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['overwrite'] = FALSE;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		$img_ext_chk = array('jpg', 'png', 'gif', 'jpeg');

		if ($item_id == '') {
			if (!$this->upload->do_upload('sample_file')) {
				// echo 'hi';
				$error = array('error' => $this->upload->display_errors());
				// print_r($error);
				// exit();
			} else {
				// echo 'hi';
				$image = $this->upload->data();
				$item_sample = $image['file_name'];
			}
			$formData['item_sample'] = $item_sample;
			$result = $this->m_masters->savemaster('bud_lbl_items', $formData);
		} else {
			if (!$this->upload->do_upload('sample_file')) {
				$error = array('error' => $this->upload->display_errors());
				// print_r($error);
				// exit();
			} else {
				if ($old_item_sample != '') {
					if (file_exists('uploads/itemsamples/labels/' . $old_item_sample)) {
						unlink('uploads/itemsamples/labels/' . $old_item_sample);
					}
				}
				$image = $this->upload->data();
				$item_sample = $image['file_name'];
				$formData['item_sample'] = $item_sample;
			}

			$result = $this->m_masters->updatemaster('bud_lbl_items', 'item_id', $item_id, $formData);
		}
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "masters/items_3", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/items_3", 'refresh');
		}
	}
	function item_size_3()
	{
		$data['activeTab'] = 'item_masters';
		$data['activeItem'] = 'item_size_3';
		$data['page_title'] = 'Item Size Master';
		$data['items'] = $this->m_masters->getactivemaster('bud_lbl_items', 'item_status');
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
			$this->load->view('labels/v_3_item-size-master', $data);
			$data['item_id'] = null;
		} else {
			$data['item_id'] = $this->uri->segment(3);
			$this->load->view('labels/v_3_item-size-master', $data);
		}
	}
	function save_item_size_3()
	{
		/*echo "<pre>";
		print_r($_POST);
		echo "</pre>";*/
		$item_code = $this->input->post('item_code');
		$item_sizes = $this->input->post('item_sizes');
		$formData = array('item_sizes' => implode(",", $item_sizes));
		$result = $this->m_masters->updatemaster('bud_lbl_items', 'item_id', $item_code, $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "masters/item_size_3", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/item_size_3", 'refresh');
		}
	}
	function item_technical_3()
	{
		$data['activeTab'] = 'item_masters';
		$data['activeItem'] = 'item_technical_3';
		$data['page_title'] = 'Item Technical Master - Labels';
		$data['item_id'] = null;
		$data['items'] = $this->m_masters->getactivemaster('bud_lbl_items', 'item_status');
		$data['shades'] = $this->m_masters->getactivemaster('bud_shades', 'shade_status');
		$data['deniers'] = $this->m_masters->getactivemaster('bud_deniermaster', 'denier_status');
		$data['weaves'] = $this->m_masters->getactivemaster('bud_te_weaves', 'weave_status');
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
			$this->load->view('labels/v_3_item-tech-master', $data);
			$data['item_id'] = null;
		} else {
			$data['item_id'] = $this->uri->segment(3);
			$this->load->view('labels/v_3_item-tech-master', $data);
		}
	}
	function update_item_technical_3()
	{
		/*echo "<pre>";
		print_r($_POST);
		echo "</pre>";*/
		$combo_id = $this->input->post('combo_id');
		$item_code = $this->input->post('item_code');
		$formData = $this->input->post('formData');
		$shade_name = $this->input->post('shade_name');
		$shade_code = $this->input->post('shade_code');
		$denier = $this->input->post('denier');
		$no_ends = $this->input->post('no_ends');
		$design_weave = $this->input->post('design_weave');
		$net_weight = $this->input->post('net_weight');
		$percentage = $this->input->post('percentage');
		$item_width_num = (int) $formData['item_width'];
		$new_net_weight = array();
		if ($shade_name[0] > 0) {
			foreach ($denier as $key => $value) {
				//ER-07-18#-7
				/*if($key == 3)
				{
					echo 'no_ends: '.$no_ends[$key] = ($item_width_num * $formData['item_pick_density'] * 39) / 1000;
					echo 'denierval: '.$denier_val = $this->m_masters->getmasterIDvalue('bud_deniermaster', 'denier_id', $value, 'denier_tech');
					echo "val:".$val = (($denier_val * $no_ends[$key]) / 9000) + ((($denier_val * $no_ends[$key]) / 9000) * $percentage[$key]) / 100;
					$new_net_weight[] = number_format($val, 4, '.', '');
					echo "</br>";
				}
				else
				{*/ //ER-07-18#-7
				$denier_val = $this->m_masters->getmasterIDvalue('bud_deniermaster', 'denier_id', $value, 'denier_tech');
				$actual_val = (($denier_val / 9000) * ($item_width_num * $no_ends[$key] / 1000)); //ER-07-18#-5
				$val = $actual_val + ($percentage[$key] * $actual_val / 100); //ER-07-18#-5
				$new_net_weight[] = number_format($val, 4, '.', '');
				//}ER-07-18#-7
			}
			$comboData = array(
				'item_id' => $item_code,
				'shade_name' => implode(",", $shade_name),
				'shade_code' => implode(",", $shade_code),
				'denier' => implode(",", $denier),
				'no_ends' => implode(",", $no_ends),
				'design_weave' => implode(",", $design_weave),
				'net_weight' => implode(",", $new_net_weight),
				'percentage' => implode(",", $percentage)
			);
			/*echo "<pre>";
			print_r($comboData);
			echo "</pre>";*/
			if ($combo_id == '') {
				$result = $this->m_purchase->saveDatas('bud_lbl_color_combos', $comboData);
			} else {
				$result = $this->m_masters->updatemaster('bud_lbl_color_combos', 'combo_id', $combo_id, $comboData);
			}
			if ($result) {
				$this->m_masters->updatemaster('bud_lbl_items', 'item_id', $item_code, $formData);
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "masters/item_technical_3", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "masters/item_technical_3", 'refresh');
			}
		}
	}

	// Request Form Master
	function request_form($id = false)
	{
		if (!empty($id)) {
			$data['next'] = $id;
		} else {
			$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_request_master'");
			$next = $next->row(0);
			$data['next'] = $next->Auto_increment;
		}
		$this->load->library('form_validation');

		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'request_form';
		$data['page_title'] = 'Request Form Master';
		$data['request_forms'] = $this->m_masters->get_request_forms();
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

		$data['id'] = '';
		$data['subject'] = '';
		$data['header'] = '';
		$data['greetings'] = '';
		$data['main_content'] = '';
		$data['footer'] = '';

		if ($id) {
			$request_form = $this->m_masters->get_request_form($id);
			if (!$request_form) {
				$this->session->set_flashdata('error', 'Record Not Found');
				redirect(base_url('masters/request_form'));
			}

			$data['id'] = $request_form->id;
			$data['subject'] = $request_form->subject;
			$data['header'] = $request_form->header;
			$data['greetings'] = $request_form->greetings;
			$data['main_content'] = $request_form->main_content;
			$data['footer'] = $request_form->footer;
		}

		// Set Validation Rules
		$this->form_validation->set_rules('subject', 'Subject', 'required');
		$this->form_validation->set_rules('main_content', 'Mail Content', 'required');

		if ($this->input->post('submit')) {
			$data['id'] = $id;
			$data['subject'] = $this->input->post('subject');
			$data['header'] = $this->input->post('header');
			$data['greetings'] = $this->input->post('greetings');
			$data['main_content'] = $this->input->post('main_content');
			$data['footer'] = $this->input->post('footer');
		}
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('request_form', $data);
		} else {
			$save['id'] = $id;
			$save['subject'] = $this->input->post('subject');
			$save['header'] = $this->input->post('header');
			$save['greetings'] = $this->input->post('greetings');
			$save['main_content'] = $this->input->post('main_content');
			$save['footer'] = $this->input->post('footer');

			$this->m_masters->save_request_form($save);

			$this->session->set_flashdata('success', 'Successfully Saved');
			//go back to the Class list
			redirect(base_url('masters/request_form'));
		}
	}

	function delete_request_form($id)
	{
		if ($id) {
			$request_form	= $this->m_masters->get_request_form($id);
			//if the request_form does not exist, redirect them to the request_form list with an error
			if (!$request_form) {
				$this->session->set_flashdata('error', 'Record Not Found');
				redirect(base_url('masters/request_form'));
			} else {
				$this->m_masters->delete_request_form($id);

				$this->session->set_flashdata('message', 'Successfully Deleted');
				redirect(base_url('masters/request_form'));
			}
		} else {
			//if they do not provide an id send them to the request_form list page with an error
			$this->session->set_flashdata('message', 'Successfully Deleted');
			redirect(base_url('masters/request_form'));
		}
	}
	//ER-09-18#-62
	function operators()
	{
		$data['activeTab'] = 'masters';
		$data['activeItem'] = 'operators';
		$data['page_title'] = 'Add New Operator';
		$data['concerns'] = $this->m_masters->getallmaster('bud_concern_master');
		$data['operators'] = $this->m_masters->getactivemaster('dyn_operators', 'is_deleted');
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
			$this->load->view('v_operator_master', $data);
		} else {
			$data['operator_id'] = $this->uri->segment(3);
			$this->load->view('v_operator_master', $data);
		}
	}
	function save_operator()
	{
		$result = false;
		$operator_id = $this->input->post('operator_id');
		$op_concern = $this->input->post('op_concern');
		$op_name = $this->input->post('op_name');
		$op_nick_name = $this->input->post('op_nick_name');
		$op_father_name = $this->input->post('op_father_name');
		$op_address = $this->input->post('op_address');
		$op_refered_by = $this->input->post('op_refered_by');
		$op_doj = $this->input->post('op_doj');
		$op_spd = $this->input->post('op_spd');
		$designation = $this->input->post('designation');
		$phone_number = $this->input->post('phone_number');
		$formData = array(
			'op_name' =>  $op_name,
			'op_nick_name' =>  $op_nick_name,
			'op_father_name' =>  $op_father_name,
			'op_address' =>  $op_address,
			'op_refered_by' =>  $op_refered_by,
			'op_doj' =>  $op_doj,
			'op_spd' =>  $op_spd,
			'op_concern' =>  $op_concern,
			'last_edited_id' => $this->session->userdata('user_id'),
			'is_deleted' => 1
		);
		if ($operator_id) {
			$result = $this->m_masters->updatemaster('dyn_operators', 'operator_id', $operator_id, $formData);
			$formData = array(
				'is_deleted' => 2
			);
			$result = $this->m_masters->updatemaster('dyn_operator_contact', 'operator_id', $operator_id, $formData);
		} else {
			$operator_id = $this->m_masters->savemaster('dyn_operators', $formData);
		}
		if ($operator_id) {
			foreach ($designation as $key => $value) {
				$formData = array(
					'op_relation' => $value,
					'op_contact_number' => $phone_number[$key],
					'operator_id' => $operator_id,
					'is_deleted' => 1
				);
				$result = $this->m_masters->savemaster('dyn_operator_contact', $formData);
			}
		}
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "masters/operators", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "masters/operators", 'refresh');
		}
	}
	function operator_delete() //ER-09-18#-62
	{
		$id = $this->input->post("id");
		$remarks = $this->input->post("remarks");
		if ($id) {
			$op_name = $this->m_masters->getmasterIDvalue('dyn_operators', 'operator_id', $id, 'op_name');
			$update_data = array(
				'is_deleted' => '0',
				'last_edited_id' => $this->session->userdata('user_id'),
				'last_edited_time ' => date('Y-m-d H:i:s'),
				'remarks' => $remarks
			);
			$result = $this->m_masters->updatemaster('dyn_operators', 'operator_id', $id, $update_data);
			if ($result) {
				$update_data = array('is_deleted' => '0');
				$result = $this->m_masters->updatemaster('dyn_operator_contact', 'operator_id', $id, $update_data);
			}
		}
		echo ($result) ? $op_name . '/' . $id . ' Successfully Deleted' : 'Error in Deletion';
	}
}
