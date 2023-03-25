<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Deliveryaccept extends CI_Controller
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
		$this->load->model('m_mycart');
		$this->load->model('m_poy');
		$this->load->library('cart');

		if (!$this->session->userdata('logged_in')) {
			// Allow some methods?
			$allowed = array();
			if (!in_array($this->router->method, $allowed)) {
				redirect(base_url() . 'users/login', 'refresh');
			}
		}
	}
	function poy_accept()
	{
		// $data['issue_no'] = $this->m_poy->getNextPOYIssueNo();
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_yt_poy_issue'");
		$next = $next->row(0);
		//$data['issue_no'] = $next->Auto_increment;
		$data['activeTab'] = 'deliveryaccept';
		$data['activeItem'] = 'poy_accept';
		$data['page_title'] = 'POY Issue Accpetance';
		//$data['supplier_groups'] = $this->m_masters->getactivemaster('bud_yt_supplier_groups', 'status');
		//$data['departments'] = $this->m_masters->getactivemaster('bud_yt_departments', 'status');
		//$data['poy_lots'] = $this->m_masters->getallmaster('bud_poy_lots');
		//$data['uoms'] = $this->m_masters->getactivemaster('bud_uoms', 'uom_status');
		//$data['items'] = $this->m_masters->getactivemaster('bud_items', 'item_status');
		$data['poy_issue'] = $this->m_poy->getPoyIssueList();
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
		//$data['js_IE'] = array('js/html5shiv.js', 'js/respond.min.js');
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
			$this->load->view('v_1_po-issue-accept.php', $data);
		} else {
			$data['poy_lot_id'] = $this->uri->segment(3);
			$this->load->view('v_1_po-issue-accept.php', $data);
		}
	}
	function poy_accept_update()
	{
		/*echo "<pre>";
		print_r($_POST);
		echo "</pre>";*/
		$id = $this->input->post('id');
		$password = $this->input->post('password');
		$if_password_match = $this->m_poy->check_password($this->session->userdata('user_id'), $password);
		if ($if_password_match) {
			$formData = array(
				'accepted_datetime' => date("Y-m-d H:i:s"),
				'is_accepted' => 1
			);
			$this->m_masters->updatemaster('bud_yt_poy_issue', 'id', $id, $formData);
			$this->session->set_flashdata('success', 'Successfully Updated!!!');
			redirect(base_url() . "deliveryaccept/poy_accept", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'Please Enter Correct Password');
			redirect(base_url() . "deliveryaccept/poy_accept", 'refresh');
		}
	}
}
