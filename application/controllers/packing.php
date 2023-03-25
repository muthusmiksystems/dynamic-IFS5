<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Packing extends CI_Controller
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
		$this->load->library('cart');

		if (!$this->session->userdata('logged_in')) {
			// Allow some methods?
			$allowed = array();
			if (!in_array($this->router->method, $allowed)) {
				redirect(base_url() . 'users/login', 'refresh');
			}
		}
	}
	function matetailReturened()
	{
		$data['activeTab'] = 'packing';
		$data['activeItem'] = 'matetailReturened';
		$data['page_title'] = 'Material Returened Back Form';
		$data['material_returns'] = $this->m_masters->getallmaster('bud_te_material_returns');
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
		$data['css_print'] = array(
			'css/invoice-print.css'
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
		if ($this->uri->segment(3) == true) {
			$data['return_id'] = $this->uri->segment(3);
		}
		$this->load->view('v_2_matetail-returened.php', $data);
	}
	function saveMatetailReturn()
	{
		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';*/
		$customer_id = $this->input->post('customer_id');
		$item_name = $this->input->post('item_name');
		$item_code = $this->input->post('item_code');
		$no_of_bags = $this->input->post('no_of_bags');
		$total_gr_weight = $this->input->post('total_gr_weight');
		$total_net_weight = $this->input->post('total_net_weight');
		$total_qty = $this->input->post('total_qty');
		$item_uom = $this->input->post('item_uom');
		$remarks = $this->input->post('remarks');
		$formData = array(
			'customer_id' => $customer_id,
			'item_name' => $item_name,
			'no_of_bags' => $no_of_bags,
			'total_gr_weight' => $total_gr_weight,
			'total_net_weight' => $total_net_weight,
			'total_qty' => $total_qty,
			'item_uom' => $item_uom,
			'remarks' => $remarks
		);
		$result = $this->m_purchase->saveDatas('bud_te_material_returns', $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "packing/matetailReturened", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "packing/matetailReturened", 'refresh');
		}
	}
}
