<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Stock extends CI_Controller
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
	function gy_transfer()
	{
		// author ak
		$data['activeTab'] = 'stock';
		$data['activeItem'] = 'gy_transfer';
		$data['page_title'] = 'POY Stock';
		$data['poy_deniers'] = $this->ak->get_poy_denier();
		$data['poy_items'] = $this->ak->get_poy_items();
		$data['poy_items_name'] = $this->ak->get_poy_items_name();
		$data['stock_rooms'] = $this->m_masters->getactivemaster('bud_stock_rooms', 'stock_room_status');
		$data['users'] = $this->m_masters->getactivemaster('bud_users', 'user_status');
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
			$this->load->view('v_1_gy-transfer', $data);
			$data['gray_yarn_packing'] = null;
			$data['stock_room_id'] = null;
		} else {
			// $data['gray_yarn_packing'] = $this->ak->get_gray_yarn_packing($this->uri->segment(3));
			$filter = array();
			if ($this->uri->segment(3)) {
				$filter['stock_room_id'] = $this->uri->segment(3);
			}
			// $data['gray_yarn_packing'] = $this->ak->get_gray_yarn_packing($this->uri->segment(3));
			$data['gray_yarn_packing'] = $this->ak->yt_packing_boxes('G', $filter);
			$data['stock_room_id'] = $this->uri->segment(3);
			$this->load->view('v_1_gy-transfer', $data);
		}
	}
	function gy_transfer_save()
	{
		/*echo "<pre>";
		print_r($_POST);
		echo "</pre>";*/
		$from_stock_room = $this->input->post('from_stock_room');
		$to_stock_room = $this->input->post('to_stock_room');
		$received_by = $this->input->post('received_by');
		$transfer_by = $this->session->userdata('user_id');
		$transfer_date = $this->input->post('transfer_date');
		$date = explode("-", $transfer_date);
		$transfer_date = $date[2] . '-' . $date[1] . '-' . $date[0];
		$selected_boxes = $this->input->post('selected_boxes');
		$formData = array(
			'transfer_date' => $transfer_date,
			'from_stock_room' => $from_stock_room,
			'to_stock_room' => $to_stock_room,
			'transfer_by' => $transfer_by,
			'received_by' => $received_by,
			'selected_boxes' => implode(",", $selected_boxes)
		);
		$result = $this->m_masters->savemaster('bud_yt_gy_transfer', $formData);
		if ($result) {
			foreach ($selected_boxes as $key => $box_id) {
				$updatData = array(
					'stock_room_id' => $to_stock_room
				);
				// $this->m_purchase->updateDatas('ak_gray_yarn_packing', 'id', $value, $updatData);
				$this->m_purchase->updateDatas('bud_yt_packing_boxes', 'box_id', $box_id, $updatData);
			}
			$this->session->set_flashdata('success', 'Successfully Transferred!!!');
			redirect(base_url() . "stock/gy_transfer", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "stock/gy_transfer", 'refresh');
		}
	}
}
