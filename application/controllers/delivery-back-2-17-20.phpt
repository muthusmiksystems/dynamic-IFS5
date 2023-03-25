<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Delivery extends CI_Controller
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
		$this->load->model('m_general');
		$this->load->model('m_delivery');
		$this->load->library('cart');

		if (!$this->session->userdata('logged_in')) {
			// Allow some methods?
			$allowed = array();
			if (!in_array($this->router->method, $allowed)) {
				redirect(base_url() . 'users/login', 'refresh');
			}
		}
	}
	function predelivery()
	{
		$data['activeTab'] = 'delivery';
		$data['activeItem'] = 'predelivery';
		$data['page_title'] = 'Pre Delivery';
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_yt_predelivery'");
		$next = $next->row(0);
		$data['next_p_del_id'] = $next->Auto_increment;
		$from_date = date("2016-11-01");
		$to_date = date("Y-m-d");

		$data['from_date'] = date("01-11-2016");
		$data['to_date'] = date("d-m-Y");
		$data['item_name'] = null;

		$data['item_group_id'] = '';
		if (isset($_POST['search'])) {
			$from_date = $this->input->post('from_date');
			$to_date = $this->input->post('to_date');
			$fd = explode("-", $from_date);
			$from_date = $fd[2] . '-' . $fd[1] . '-' . $fd[0];
			$td = explode("-", $to_date);
			$to_date = $td[2] . '-' . $td[1] . '-' . $td[0];
			$data['from_date'] = $this->input->post('from_date');
			$data['to_date'] = $this->input->post('to_date');
			$data['item_name'] = $this->input->post('item_name');
		}

		$filter = array();
		$filter['include_soft'] = false;
		if ($this->input->post('from_date')) {
			$filter['from_date'] = $this->input->post('from_date');
		}
		if ($this->input->post('to_date')) {
			$filter['to_date'] = $this->input->post('to_date');
		}
		if ($this->input->post('item_id')) {
			$filter['item_id'] = $this->input->post('item_name');
		}
		if ($this->input->post('item_group_id')) {
			$filter['item_group_id'] = $this->input->post('item_group_id');
			$data['item_group_id'] = $this->input->post('item_group_id');
		}


		$item_id = $data['item_name'];
		// $data['d_outerboxes'] = $this->m_delivery->getPackingBoxes($from_date, $to_date, null, $item_id, false);
		$data['d_outerboxes'] = $this->m_delivery->get_packing_boxes($filter);

		$data['items'] = $this->m_masters->get_active_items_array();
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['concerns'] = $this->m_masters->getmasterdetailsconcernactive('bud_concern_master', 'module', $this->session->userdata('user_viewed'));
		$data['item_groups'] = $this->m_masters->get_item_groups();
		// $data['boxes'] = $this->m_purchase->getActivetableDatas('bud_boxes', 'box_status');
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
			'assets/data-tables/jquery.dataTables.js',
			'assets/data-tables/DT_bootstrap.js'
		);
		$data['js_common'] = array('js/common-scripts.js');
		$data['js_thispage'] = array('js/form-validation-script.js', 'js/form-component.js', 'js/dynamic-table.js');
		if ($this->uri->segment(3) === FALSE) {
			$this->load->view('v_1_predelivery', $data);
		} else {
			$this->load->view('v_1_predelivery', $data);
		}
	}
	function selectedboxes()
	{
		$this->load->view('v_1_boxes_list.php');
	}
	function barcode_predel_add_item()
	{

		$box_id = false;
		$box = false;
		$response = array();
		if ($this->input->post('barcode_no')) {
			$barcode_no = explode("-", $this->input->post('barcode_no'));
			if (count($barcode_no) > 1) {
				$box_id = $barcode_no[1];
			} else {
				$box_id = $barcode_no[0];
			}

			$if_exist = $this->m_masters->check_exist('bud_yt_cart_items', 'item_id', $box_id);
			$data = array(
				'user_id' => $this->session->userdata('user_id'),
				'item_id' => $box_id
			);
			if (!$if_exist) {
				$this->m_delivery->insertYTCart($data);
			}
		}
	}
	function predel_add_item()
	{
		$checkeditems = explode(",", $this->input->post('checkeditems'));
		foreach ($checkeditems as $key => $value) {
			$if_exist = $this->m_masters->check_exist('bud_yt_cart_items', 'item_id', $value);
			$data = array(
				'user_id' => $this->session->userdata('user_id'),
				'item_id' => $value
			);
			if (!$if_exist) {
				$this->m_delivery->insertYTCart($data);
			}
		}
	}
	function predel_remove_item($row_id = null)
	{
		$this->m_delivery->deleteYTCartItem($row_id);
	}
	function predelivery_1_save()
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_yt_predelivery'");
		$next = $next->row(0);
		$next_p_del = $next->Auto_increment;

		$p_delivery_boxes = $this->input->post('p_delivery_boxes');
		$p_delivery_cust = $this->input->post('p_delivery_cust');
		$concern_name = $this->input->post('concern_name');

		if (isset($_POST['save_as_predel'])) {
			//deletion of predelivery tapes	
			$formData = array(
				'concern_name' => $concern_name,
				'p_delivery_cust' => $p_delivery_cust,
				'p_delivery_date' => date("Y-m-d"),
				'p_delivery_boxes' => implode(",", $p_delivery_boxes),
				'p_delivery_lt_edtd_by' => $this->session->userdata('user_id'), //ER-09-18#-58
				'p_delivery_lt_edtd_time' => date('Y-m-d H:i:s'), //ER-09-18#-58
				'p_delivery_is_deleted' => 1, //ER-09-18#-58
			);
			//end of deletion of predelivery tapes	
			$p_delivery_id = $this->m_purchase->saveDatas('bud_yt_predelivery', $formData); //ER-09-18#-58		
			if ($p_delivery_id) //ER-09-18#-58
			{
				//ER-09-18#-58
				foreach ($p_delivery_boxes as $key => $box_id) {
					$item_details = $this->m_masters->getmasterdetails('bud_yt_packing_boxes', 'box_id', $box_id);
					foreach ($item_details as $item_detail) {
						if (($item_detail['box_prefix'] == 'TH') || ($item_detail['box_prefix'] == 'TI')) {
							$delivery_qty = $item_detail['no_of_cones'];
							$uom = 'cones';
						} else {
							$delivery_qty = $item_detail['net_weight'];
							$uom = 'kgs';
						}
						$formData = array(
							'p_delivery_id' => $p_delivery_id,
							'box_id' 		=> $box_id,
							'item_id'     	=> $item_detail['item_id'],
							'delivery_qty'  => $delivery_qty,
							'uom' 			=> $uom,
							'is_deleted'	=> 1
						);
					}
					$result = $this->m_purchase->saveDatas('dyn_yt_predelivery_items', $formData);
				}
				//ER-09-18#-58
				$this->m_delivery->deleteYTCart($this->session->userdata('user_id'));
				$updateData = array(
					'predelivery_status' => 0
				);
				foreach ($p_delivery_boxes as $delivery_box) {
					$this->m_purchase->updateDatas('bud_yt_packing_boxes', 'box_id', $delivery_box, $updateData);
				}
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "delivery/predelivery_print/" . $next_p_del, 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "delivery/predelivery", 'refresh');
			}
		}
		if (isset($_POST['save_as_del'])) {
			$dc_count = $this->m_masters->getmasterdetails('bud_yt_delivery', 'concern_name', $concern_name);
			$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_yt_delivery'");
			$next = $next->row(0);
			$dc_no = $next->Auto_increment;

			$financialyear = (date('m') < '04') ? date('y', strtotime('-1 year')) : date('y');
			$financialyear .= '-' . ($financialyear + 1);
			$prefix = $this->m_masters->getmasterIDvalue('bud_concern_master', 'concern_id', $concern_name, 'concern_prefix');
			$next_dc_no = $prefix . '-' . $financialyear . '/' . (sizeof($dc_count) + 1);
			$formData = array(
				'concern_name' => $concern_name,
				'dc_no' => $next_dc_no,
				'p_delivery_ref' => $next_p_del,
				'delivery_date' => date("y-m-d"),
				'delivery_customer' => $p_delivery_cust,
				'delivery_boxes' => implode(",", $p_delivery_boxes),
				'delivery_lt_edtd_by' => $this->session->userdata('user_id'), //ER-09-18#-58
				'delivery_lt_edtd_time' => date('Y-m-d H:i:s'), //ER-09-18#-58
				'delivery_is_deleted' => 1, //ER-09-18#-58
			);
			$delivery_id = $this->m_purchase->saveDatas('bud_yt_delivery', $formData);	//ER-09-18#-58	
			if ($delivery_id) //ER-09-18#-58
			{
				$this->m_delivery->deleteYTCart($this->session->userdata('user_id'));
				//Deletion of predelivry yt
				$predelData = array(
					'p_delivery_date' => date("Y-m-d"),
					'p_delivery_cust' => $p_delivery_cust,
					'p_delivery_boxes' => implode(",", $p_delivery_boxes),
					'p_delivery_lt_edtd_by' => $this->session->userdata('user_id'), //ER-09-18#-58
					'p_delivery_lt_edtd_time' => date('Y-m-d H:i:s'), //ER-09-18#-58
					'p_delivery_is_deleted' => 1, //ER-09-18#-58
				);
				//End of deletion of predelivery yt
				$p_delivery_id = $this->m_purchase->saveDatas('bud_yt_predelivery', $predelData); //ER-09-18#-58
				//ER-09-18#-58
				foreach ($p_delivery_boxes as $key => $box_id) {
					$item_details = $this->m_masters->getmasterdetails('bud_yt_packing_boxes', 'box_id', $box_id);
					foreach ($item_details as $item_detail) {
						if (($item_detail['box_prefix'] == 'TH') || ($item_detail['box_prefix'] == 'TI')) {
							$delivery_qty = $item_detail['no_of_cones'];
							$uom = 'cones';
						} else {
							$delivery_qty = $item_detail['net_weight'];
							$uom = 'kgs';
						}
						$formData = array(
							'p_delivery_id' => $p_delivery_id,
							'delivery_id' => $delivery_id,
							'box_id' 		=> $box_id,
							'item_id'     	=> $item_detail['item_id'],
							'delivery_qty'  => $delivery_qty,
							'uom' 			=> $uom,
							'is_deleted'	=> 1
						);
					}
					$result = $this->m_purchase->saveDatas('dyn_yt_predelivery_items', $formData);
				}
				//ER-09-18#-58
				$updateData = array(
					'predelivery_status' => 0,
					'delivery_status' => 0
				);
				$update_p_del = array(
					'p_delivery_status' => 0
				);
				foreach ($p_delivery_boxes as $delivery_box) {
					$this->m_purchase->updateDatas('bud_yt_packing_boxes', 'box_id', $delivery_box, $updateData);
				}
				$this->m_purchase->updateDatas('bud_yt_predelivery', 'p_delivery_id', $next_p_del, $update_p_del);
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "delivery/delivery_1_print/" . $dc_no, 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "delivery/delivery_1", 'refresh');
			}
		}
	}
	function predelivery_print()
	{

		$data['activeTab'] = 'delivery';
		$data['activeItem'] = 'predelivery_1_list';
		$data['page_title'] = 'Print Pre Delivery';
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
			'assets/data-tables/jquery.dataTables.js',
			'assets/data-tables/DT_bootstrap.js'
		);
		$data['js_common'] = array('js/common-scripts.js');
		$data['js_thispage'] = array('js/form-validation-script.js', 'js/form-component.js', 'js/dynamic-table.js');
		if ($this->uri->segment(3) == TRUE) {
			$data['p_delivery_id'] = $this->uri->segment(3);
			$p_delivery_id = $this->uri->segment(3);
			$data['delivery_details'] = $this->m_masters->getmasterdetails('bud_yt_predelivery', 'p_delivery_id', $p_delivery_id);
		} else {
			redirect(base_url() . "my404/404");
		}
		$this->load->view('v_1_predelivery_print.php', $data);
	}
	function predelivery_1_list()
	{
		$data['activeTab'] = 'delivery';
		$data['activeItem'] = 'predelivery_1_list';
		$data['page_title'] = 'Pre Deliveries';
		$data['pre_deliveries'] = $this->m_masters->get_yt_predc();

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
			'assets/data-tables/jquery.dataTables.js',
			'assets/data-tables/DT_bootstrap.js'
		);
		$data['js_common'] = array('js/common-scripts.js');
		$data['js_thispage'] = array('js/form-validation-script.js', 'js/form-component.js', 'js/dynamic-table.js');
		$this->load->view('v_1_predelivery_list.php', $data);
	}
	function predelivery_1_edit()
	{

		$data['party_name'] = null;
		$data['item_name'] = null;
		$data['search_date'] = null;
		$from_date = date("2016-11-01");
		$to_date = date("Y-m-d");

		$data['from_date'] = date("01-11-2016");
		$data['to_date'] = date("d-m-Y");

		$filter = array();
		$filter['include_soft'] = false;
		if ($this->input->post('from_date')) {
			$filter['from_date'] = $this->input->post('from_date');
			$data['from_date'] = $this->input->post('from_date');
		}
		if ($this->input->post('to_date')) {
			$filter['to_date'] = $this->input->post('to_date');
			$data['to_date'] = $this->input->post('to_date');
		}
		if ($this->input->post('item_id')) {
			$filter['item_id'] = $this->input->post('item_name');
			$data['item_name'] = $this->input->post('item_name');
		}
		if ($this->input->post('item_group_id')) {
			$filter['item_group_id'] = $this->input->post('item_group_id');
			$data['item_group_id'] = $this->input->post('item_group_id');
		}


		$item_id = $data['item_name'];
		// $data['d_outerboxes'] = $this->m_delivery->getPackingBoxes($from_date, $to_date, null, $item_id, false);
		$data['d_outerboxes'] = $this->m_delivery->get_packing_boxes($filter);

		$data['activeTab'] = 'delivery';
		$data['activeItem'] = 'predelivery';
		$data['page_title'] = 'Pre Delivery';
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['items'] = $this->m_masters->getallmaster('bud_items');
		$data['pre_deliveries'] = $this->m_masters->get_yt_predc();

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
			'assets/data-tables/jquery.dataTables.js',
			'assets/data-tables/DT_bootstrap.js'
		);
		$data['js_common'] = array('js/common-scripts.js');
		$data['js_thispage'] = array('js/form-validation-script.js', 'js/form-component.js', 'js/dynamic-table.js');
		if ($this->uri->segment(3) == TRUE) {
			$data['p_delivery_id'] = $this->uri->segment(3);
			$p_delivery_id = $this->uri->segment(3);
			$data['delivery_details'] = $this->m_masters->getmasterdetails('bud_yt_predelivery', 'p_delivery_id', $p_delivery_id);
		} else {
			redirect(base_url() . "my404/404");
		}
		$this->load->view('v_1_edit_predelivery.php', $data);
	}
	function predelivery_1_update()
	{
		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';*/
		$p_delivery_cust = $this->input->post('p_delivery_cust');
		$p_delivery_id = $this->input->post('p_delivery_id');
		if ($this->input->post('p_delivery_boxes')) {
			$new_delivery_boxes = $this->input->post('p_delivery_boxes');
		} else {
			$new_delivery_boxes = array();
		}
		if (sizeof($new_delivery_boxes) > 0) {
			$predelivery = $this->m_masters->getmasterdetails('bud_yt_predelivery', 'p_delivery_id', $p_delivery_id);
			$removed_boxes = array();
			foreach ($predelivery as $row) {
				$old_packing_boxes = explode(",", $row['p_delivery_boxes']);
			}
			foreach ($old_packing_boxes as $key => $value) {
				if (!in_array($value, $new_delivery_boxes)) {
					$removed_boxes[] = $value;
				}
			}
			$formData = array(
				'p_delivery_cust' => $p_delivery_cust,
				'p_delivery_boxes' => implode(",", $new_delivery_boxes),
				'p_delivery_lt_edtd_by' => $this->session->userdata('user_id'), //ER-09-18#-58
				'p_delivery_lt_edtd_time' => date('Y-m-d H:i:s'), //ER-09-18#-58
				'p_delivery_is_deleted' => 1, //ER-09-18#-58
			);

			$result = $this->m_masters->updatemaster('bud_yt_predelivery', 'p_delivery_id', $p_delivery_id, $formData);
			if ($result) {
				$this->cart->destroy();
				$this->m_delivery->deleteYTCart($this->session->userdata('user_id'));
				$remove_pre_del = array(
					'predelivery_status' => 0,
				);
				//ER-09-18#-58
				$update_p_items = array(
					'is_deleted' => 2
				);
				$result = $this->m_purchase->updateDatas('dyn_yt_predelivery_items', 'p_delivery_id', $p_delivery_id, $update_p_items);
				if ($result) {
					foreach ($new_delivery_boxes as $key => $value) {
						$this->m_purchase->updateDatas('bud_yt_packing_boxes', 'box_id', $value, $remove_pre_del);
						$item_details = $this->m_masters->getmasterdetails('bud_yt_packing_boxes', 'box_id', $value);
						foreach ($item_details as $item_detail) {
							if (($item_detail['box_prefix'] == 'TH') || ($item_detail['box_prefix'] == 'TI')) {
								$delivery_qty = $item_detail['no_of_cones'];
								$uom = 'cones';
							} else {
								$delivery_qty = $item_detail['net_weight'];
								$uom = 'kgs';
							}
							$formData = array(
								'p_delivery_id' => $p_delivery_id,
								'box_id' 		=> $value,
								'item_id'     	=> $item_detail['item_id'],
								'delivery_qty'  => $delivery_qty,
								'uom' 			=> $uom,
								'is_deleted'	=> 1
							);
						}
						$result = $this->m_purchase->saveDatas('dyn_yt_predelivery_items', $formData);
					}
				}
				//ER-09-18#-58
				$updateData = array(
					'predelivery_status' => 0
				);

				foreach ($removed_boxes as $outerbox) {
					$this->m_purchase->updateDatas('bud_yt_packing_boxes', 'box_id', $outerbox, $updateData);
				}
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "delivery/predelivery_1_list", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "delivery/predelivery_1_list", 'refresh');
			}
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "delivery/predelivery_1_list", 'refresh');
		}
	}
	//deletion of predelivery Yt
	function predelivery_1_delete() //ER-09-18#-58
	{
		$p_delivery_id = $this->input->post("p_delivery_id");
		$remarks = $this->input->post("remarks");
		if ($p_delivery_id) {
			$result = $this->m_masters->update_delete_status_predelivery_yt($p_delivery_id, $remarks);
		}
		echo ($result) ? $p_delivery_id . ' Successfully Deleted' : 'Error in Deletion';
	}
	function delivery_1_delete() //ER-09-18#-58
	{
		$delivery_id = $this->input->post("delivery_id");
		$remarks = $this->input->post("remarks");
		if ($delivery_id) {
			$dc_no = $this->m_masters->getmasterIDvalue('bud_yt_delivery', 'delivery_id', $delivery_id, 'dc_no');
			$update_data = array(
				'delivery_is_deleted' => '0',
				'delivery_lt_edtd_by' => $this->session->userdata('user_id'),
				'delivery_lt_edtd_time' => date('Y-m-d H:i:s'),
				'remarks' => $remarks
			);
			$result = $this->m_masters->updatemaster('bud_yt_delivery', 'delivery_id', $delivery_id, $update_data);
			$update_data = array('delivery_id' => '0');
			$result = $this->m_masters->updatemaster('dyn_yt_predelivery_items', 'delivery_id', $delivery_id, $update_data);
			$delivery_boxes = $this->m_masters->getmasterIDvalue('bud_yt_delivery', 'delivery_id', $delivery_id, 'delivery_boxes');
			$boxes_array = explode(',', $delivery_boxes);
			foreach ($boxes_array as $key => $value) {
				$data = array(
					'delivery_status' => '0'
				);
				$result = $this->m_masters->updatemaster('bud_yt_packing_boxes', 'box_no', $value, $data);
			}
		}
		echo ($result) ? $dc_no . ' Successfully Deleted' : 'Error in Deletion';
	}
	//end of deletion of predelivery yt
	function delivery_1()
	{
		if ($this->uri->segment(3) == TRUE) {
			$data['p_delivery_id'] = $this->uri->segment(3);
			$p_delivery_id = $this->uri->segment(3);
			$data['delivery_details'] = $this->m_masters->getmasterdetails('bud_yt_predelivery', 'p_delivery_id', $p_delivery_id);
		}
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_yt_delivery'");
		$next = $next->row(0);
		$data['next_delivery'] = $next->Auto_increment;

		$data['activeTab'] = 'delivery';
		$data['activeItem'] = 'delivery_1';
		$data['page_title'] = 'Delivery';
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		/*$data['items'] = $this->m_masters->getallmaster('bud_yt_items');
		$data['outerboxes'] = $this->m_masters->getactivemaster('bud_yt_outerboxes','delivery_status');*/
		$data['pre_deliveries'] = $this->m_masters->getactivemaster('bud_yt_predelivery', 'p_delivery_status');

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
			'assets/data-tables/jquery.dataTables.js',
			'assets/data-tables/DT_bootstrap.js'
		);
		$data['js_common'] = array('js/common-scripts.js');
		$data['js_thispage'] = array('js/form-validation-script.js', 'js/form-component.js', 'js/dynamic-table.js');
		$this->load->view('v_1_delivery.php', $data);
	}
	function delivery_1_save()
	{

		$pre_delivery = $this->input->post('pre_delivery');
		$delivery_date = $this->input->post('delivery_date');
		$delivery_customer = $this->input->post('delivery_customer');
		$concern_name = $this->input->post('concern_name');
		$delivery_boxes = $this->input->post('delivery_boxes');
		$ed = explode("-", $delivery_date);
		$delivery_date = $ed[2] . '-' . $ed[1] . '-' . $ed[0];

		$dc_count = $this->m_masters->getmasterdetails('bud_yt_delivery', 'concern_name', $concern_name);
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_yt_delivery'");
		$next = $next->row(0);
		$dc_no = $next->Auto_increment;

		$financialyear = (date('m') < '04') ? date('y', strtotime('-1 year')) : date('y');
		$financialyear .= '-' . ($financialyear + 1);
		$prefix = $this->m_masters->getmasterIDvalue('bud_concern_master', 'concern_id', $concern_name, 'concern_prefix');
		$next_dc_no = $prefix . '-' . $financialyear . '/' . (sizeof($dc_count) + 1);

		$formData = array(
			'concern_name' => $concern_name,
			'dc_no' => $next_dc_no,
			'p_delivery_ref' => $pre_delivery,
			'delivery_date' => $delivery_date,
			'delivery_customer' => $delivery_customer,
			'delivery_boxes' => implode(",", $delivery_boxes),
			'delivery_lt_edtd_by' => $this->session->userdata('user_id'), //ER-09-18#-58
			'delivery_lt_edtd_time' => date('Y-m-d H:i:s'), //ER-09-18#-58
			'delivery_is_deleted' => 1, //ER-09-18#-58
		);
		$delivery_id = $this->m_purchase->saveDatas('bud_yt_delivery', $formData);
		if ($delivery_id) {

			$updateData = array(
				'delivery_status' => 0
			);
			$update_p_del = array(
				'p_delivery_status' => 0
			);
			//ER-09-18#-58
			$update_p_del_items = array(
				'delivery_id' => $delivery_id
			);
			$this->db->where('p_delivery_id', $pre_delivery);
			$this->db->where('is_deleted', 1);
			$this->db->update('dyn_yt_predelivery_items', $update_p_del_items);
			//ER-09-18#-58
			foreach ($delivery_boxes as $delivery_box) {
				$this->m_purchase->updateDatas('bud_yt_packing_boxes', 'box_id', $delivery_box, $updateData);
			}
			$this->m_purchase->updateDatas('bud_yt_predelivery', 'p_delivery_id', $pre_delivery, $update_p_del);
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "delivery/delivery_1_print/" . $dc_no, 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "delivery/delivery_1", 'refresh');
		}
	}
	function delivery_1_list()
	{
		$data['activeTab'] = 'delivery';
		$data['activeItem'] = 'delivery_1_list';
		$data['page_title'] = 'Deliveries';
		// $data['deliveries'] = $this->m_masters->getactivemaster('bud_yt_delivery','invoice_status');
		$data['deliveries'] = $this->m_masters->getactivemaster('bud_yt_delivery', 'delivery_is_deleted'); //ER-09-18#-58

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
			'assets/data-tables/jquery.dataTables.js',
			'assets/data-tables/DT_bootstrap.js'
		);
		$data['js_common'] = array('js/common-scripts.js');
		$data['js_thispage'] = array('js/form-validation-script.js', 'js/form-component.js', 'js/dynamic-table.js');
		$this->load->view('v_1_delivery_list.php', $data);
	}
	function delivery_1_print()
	{

		$data['activeTab'] = 'delivery';
		$data['activeItem'] = 'delivery_1';
		$data['page_title'] = 'Print Delivery';
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
			'assets/data-tables/jquery.dataTables.js',
			'assets/data-tables/DT_bootstrap.js'
		);
		$data['js_common'] = array('js/common-scripts.js');
		$data['js_thispage'] = array('js/form-validation-script.js', 'js/form-component.js', 'js/dynamic-table.js');
		if ($this->uri->segment(3) == TRUE) {
			$data['delivery_id'] = $this->uri->segment(3);
			$delivery_id = $this->uri->segment(3);
			$data['delivery_details'] = $this->m_masters->getmasterdetails('bud_yt_delivery', 'delivery_id', $delivery_id);
		} else {
			redirect(base_url() . "my404/404");
		}
		$this->load->view('v_1_delivery_print.php', $data);
	}


	function gray_yarn_soft_delivery($delivery_id = false)
	{
		$this->load->library('form_validation');
		$data['activeTab'] = 'delivery';
		$data['activeItem'] = 'gray_yarn_soft_delivery';
		$data['page_title'] = 'Gray Yarn Soft Delivery';

		$data['deliveries'] = $this->m_delivery->list_soft_delivery();

		$data['items'] = $this->m_masters->getactivemaster('bud_items', 'item_status');
		$data['concerns'] = $this->m_masters->getallmaster('bud_concern_master');

		$data['from_date'] = date("01-m-Y");
		$data['to_date'] = date("d-m-Y");
		$data['item_id'] = false;
		$data['box_prefix'] = 'S'; //ER-08-18#-44
		if ($this->input->post('search')) {
			$data['from_date'] = $this->input->post('from_date');
			$data['to_date'] = $this->input->post('to_date');
			$data['item_id'] = $this->input->post('item_id');
			$data['box_prefix'] = $this->input->post('box_prefix'); //ER-08-18#-44
		}
		$from_date = date("Y-m-d", strtotime($data['from_date']));
		$to_date = date("Y-m-d", strtotime($data['to_date']));
		$item_id = $data['item_id'];
		$box_prefix = $data['box_prefix']; //ER-08-18#-44

		$data['boxes'] = $this->m_delivery->yt_soft_packing_boxes($box_prefix, $from_date, $to_date, $item_id); //ER-08-18#-44

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
			'assets/data-tables/jquery.dataTables.js',
			'assets/data-tables/DT_bootstrap.js'
		);
		$data['js_common'] = array('js/common-scripts.js');
		$data['js_thispage'] = array('js/form-validation-script.js', 'js/form-component.js', 'js/dynamic-table.js');

		$data['delivery_id'] = $delivery_id;
		$data['from_concern'] = '';
		$data['to_concern'] = '';
		$data['remarks'] = '';
		$data['outer_boxes'] = array();
		if ($delivery_id) {
			$data['dc_no'] = $delivery_id;

			$delivery = $this->m_delivery->get_soft_delivery($delivery_id);
			if (!$delivery) {
				$this->session->set_flashdata('error', 'Record Not Found');
				redirect(base_url('delivery/gray_yarn_soft_delivery'));
			}

			$data['delivery_id'] = $delivery->delivery_id;
			$data['from_concern'] = $delivery->from_concern;
			$data['to_concern'] = $delivery->to_concern;
			$data['remarks'] = $delivery->remarks;

			if (!$this->input->post('save_as_del')) {
				$data['outer_boxes']	= array();
				foreach ($delivery->outer_boxes as $box) {
					$data['outer_boxes'][] = $box->box_id;
				}
			}
		} else {
			$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_gray_yarn_soft_dc'");
			$next = $next->row(0);
			$data['dc_no'] = $next->Auto_increment;
		}

		// Set Validation Rules
		$this->form_validation->set_rules('from_concern', 'From Concern', 'required');
		$this->form_validation->set_rules('to_concern', 'To Concern', 'required');
		$this->form_validation->set_rules('outer_boxes[]', 'Delivery Boxes', 'required');

		if ($this->input->post('save_as_del')) {
			$data['from_concern'] = $this->input->post('from_concern');
			$data['to_concern'] = $this->input->post('to_concern');
			$data['remarks'] = $this->input->post('remarks');
			$data['outer_boxes'] = $this->input->post('outer_boxes');
			$data['delivery_id'] = $delivery_id;
			$data['delivery_date'] = date("Y-m-d H:i:s");
			$data['delivered_by'] = $this->session->userdata('display_name');
		}

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('v_gray_yarn_soft_delivery', $data);
		} else {
			$outer_boxes = $this->input->post('outer_boxes');
			$save['from_concern'] = $this->input->post('from_concern');
			$save['to_concern'] = $this->input->post('to_concern');
			$save['remarks'] = $this->input->post('remarks');
			$save['delivery_id'] = $delivery_id;
			$save['delivery_date'] = date("Y-m-d H:i:s");
			$save['delivered_by'] = $this->session->userdata('display_name');

			$this->m_delivery->save_soft_dc($save, $outer_boxes);

			$this->session->set_flashdata('success', 'Successfully Saved');
			//go back to the DC list
			redirect(base_url('delivery/gray_yarn_soft_delivery'));
		}
	}

	function gray_yarn_dc_list($delivery_id = false)
	{
		$this->load->library('form_validation');
		$data['activeTab'] = 'delivery';
		$data['activeItem'] = 'gray_yarn_dc_list';
		$data['page_title'] = 'Gray Yarn Delivery';

		// $data['deliveries'] = $this->m_delivery->list_soft_delivery();
		$data['deliveries'] = $this->m_delivery->list_gray_yarn_delivery();

		$this->load->view('gray-yarn-dc-list', $data);
	}

	function gray_yarn_soft_dc($delivery_id = false)
	{
		$data['activeTab'] = 'delivery';
		$data['activeItem'] = 'gray_yarn_soft_delivery';
		$data['page_title'] = 'Gray Yarn Soft Packing Delivery';

		if ($delivery_id) {
			$delivery = $this->m_delivery->get_soft_delivery($delivery_id);
			if (!$delivery) {
				$this->session->set_flashdata('error', 'Record Not Found');
				redirect(base_url('delivery/gray_yarn_soft_delivery'));
			}

			$data['delivery'] = $delivery;
		} else {
			$this->session->set_flashdata('error', 'Record Not Found');
			redirect(base_url('delivery/gray_yarn_soft_delivery'));
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
			'assets/data-tables/jquery.dataTables.js',
			'assets/data-tables/DT_bootstrap.js'
		);
		$data['js_common'] = array('js/common-scripts.js');
		$data['js_thispage'] = array('js/form-validation-script.js', 'js/form-component.js', 'js/dynamic-table.js');
		$this->load->view('v_gray_yarn_soft_dc', $data);
	}

	function soft_delivery_save()
	{
		echo "<pre>";
		print_r($_POST);
		echo "</pre>";
	}
}
