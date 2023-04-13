<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Store extends CI_Controller
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
	function poy_store()
	{
		// author ak
		$data['activeTab'] = 'store';
		$data['activeItem'] = 'poy_store';
		$data['page_title'] = 'POY Stock';
		$data['poy_deniers'] = $this->ak->get_poy_denier();
		$data['poy_items'] = $this->ak->get_poy_items();
		$data['poy_items_name'] = $this->ak->get_poy_items_name();
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
			$this->load->view('v_store_poy', $data);
		} else {
			$data['category_id'] = $this->uri->segment(3);
			$this->load->view('v_store_poy', $data);
		}
	}

	function wastage()
	{
		// author ak
		$data['activeTab'] = 'store';
		$data['activeItem'] = 'wastage';
		$data['page_title'] = 'POY Wastage';
		//$data['poy_deniers'] = $this->ak->get_poy_denier();
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

		$this->load->view('v_store_wastage', $data);
	}
	function poy_sales()
	{
		// author ak
		$data['activeTab'] = 'store';
		$data['activeItem'] = 'poy_sales';
		$data['page_title'] = 'POY Sales Entry';
		//$data['poy_deniers'] = $this->ak->get_poy_denier();
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
		$data['poy_deniers'] = $this->ak->get_poy_denier();
		$this->load->view('v_store_poy_sales', $data);
	}
	function polyster_yarn()
	{
		// author ak
		$data['activeTab'] = 'store';
		$data['activeItem'] = 'polyster_yarn';
		$data['page_title'] = 'Polyster Yarn';
		//$data['poy_deniers'] = $this->ak->get_poy_denier();
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
		$this->load->view('v_store_polyster_yarn', $data);
	}

	public function get_poy_inward_list()
	{
		$this->load->model('m_poy');
		$filter = array();
		if ($this->input->post('supplier_id')) {
			$filter['supplier_id'] = $this->input->post('supplier_id');
		}
		if ($this->input->post('poy_lot_id')) {
			$filter['poy_lot_id'] = $this->input->post('poy_lot_id');
		}
		if ($this->input->post('yarn_lot_id')) {
			$filter['yarn_lot_id'] = $this->input->post('yarn_lot_id');
		}
		if ($this->input->post('poy_denier')) {
			$filter['poy_denier'] = $this->input->post('poy_denier');
		}
		if ($this->input->post('yarn_denier')) {
			$filter['yarn_denier'] = $this->input->post('yarn_denier');
		}
		$poy_inwards = $this->m_poy->get_poy_inward(false, $filter);

		$options = '<option>Select</option>';
		if (sizeof($poy_inwards) > 0) {
			foreach ($poy_inwards as $poy_inward) {
				$options .= '<option value="' . $poy_inward->po_no . '">' . $poy_inward->po_no . '</option>';
			}
		}
		echo $options;
	}

	function get_poy_inward_qty($poy_inward_no = false)
	{
		$this->load->model('m_poy');
		$return = array();
		$inward_qty = 0.000;
		$tot_packed_qty = 0.000;
		$tot_balancd_qty = 0.000;
		$tot_wastage_qty = 0.000;
		$percentage = 0;
		if (!empty($poy_inward_no)) {
			$poy_inward = $this->m_poy->get_poy_inward($poy_inward_no);
			if (sizeof($poy_inward) > 0) {
				foreach ($poy_inward as $row) {
					$inward_items = $row->inward_items;
					$return['yarn_denier'] = $row->yarn_denier;
					$return['yarn_lot_id'] = $row->yarn_lot_id;
					/*echo "<pre>";
					print_r($inward_items);
					echo "</pre>";*/
					if (sizeof($inward_items) > 0) {
						foreach ($inward_items as $item) {
							$inward_qty += $item->po_qty;
							$return['poy_denier'] = $item->poy_denier;
							$return['denier_name'] = $item->denier_name;
							$return['item_id'] = $item->item_id;
							$return['item_name'] = $item->item_name;
							$return['poy_lot_id'] = $item->poy_lot_id;
							$return['poy_lot_no'] = $item->poy_lot_no;
							$return['supplier_id'] = $item->supplier_id;
						}
					}

					$return['supplier_name'] = $row->group_name;
				}
			}

			$pack_qty = $this->m_masters->get_inward_pack_qty($poy_inward_no);
			if ($pack_qty) {
				if ($pack_qty->tot_packed_qty > 0) {
					$tot_packed_qty = $pack_qty->tot_packed_qty;
					$tot_wastage_qty = $pack_qty->tot_wastage_qty;
				}
			}
		}
		$tot_balancd_qty = $inward_qty - ($tot_packed_qty + $tot_wastage_qty);
		if ($inward_qty > 0) {
			// $percentage = (($tot_packed_qty - $inward_qty) / $inward_qty) * 100;	
			if ($tot_wastage_qty > 0) {
				$percentage = ($tot_wastage_qty / $tot_packed_qty) * 100;
			}
		}

		$return['inward_qty'] = number_format($inward_qty, 3, '.', '');
		$return['tot_packed_qty'] = number_format($tot_packed_qty, 3, '.', '');
		$return['tot_balancd_qty'] = number_format($tot_balancd_qty, 3, '.', '');
		$return['percentage'] = number_format($percentage, 2, '.', '');
		$return['tot_wastage_qty'] = number_format($tot_wastage_qty, 3, '.', '');
		// echo $tot_wastage_qty;
		echo json_encode($return);
	}

	function get_poy_inward_qty2($poy_inward_no = false)
	{
		$this->load->model('m_poy');
		$data = array();
		if (!empty($poy_inward_no)) {
			$poy_inward = $this->m_poy->get_poy_inward($poy_inward_no);

			echo "<pre>";
			print_r($poy_inward);
			echo "</pre>";
		}


		echo json_encode($data);
	}

	function gray_yarn_soft($id = false, $edit = false)
	{
		$this->load->model('m_poy');
		// author ak
		$data['activeTab'] = 'store';
		$data['activeItem'] = 'gray_yarn_soft';
		$data['page_title'] = 'Soft Yarn Packing';
		$data['supplier_id'] = '';
		$data['poy_lot_id'] = '';
		$data['yarn_lot_id'] = '';

		if (!empty($id)) {
			$data['id'] = $this->uri->segment(3);
			$data['box_no'] = $this->ak->getNextBoxNo('S');
		} else {
			$data['id'] = null;
			$data['box_no'] = $this->ak->getNextBoxNo('S');
		}

		if (!empty($edit)) {
			$data['edit'] = $edit;
		}
		$data['print'] = "";
		if (!empty($this->uri->segment(4))) {
			if ($this->uri->segment(4) == 'print') {
				$data['print'] = base_url() . 'store/print_gray_yarn_soft/' . $this->uri->segment(3);
			}
		}

		$data['items'] = $this->m_masters->getactivemaster('bud_items', 'item_status');
		$data['poy_inwards'] = $this->m_poy->get_poy_inward();
		$data['poy_lots'] = $this->m_poy->get_poy_lost();
		$data['yarn_lots'] = $this->m_poy->get_yarn_lots();
		$data['suppliers'] = $this->m_poy->get_suppliers();
		$data['denier'] = $this->db->get('bud_yt_poydeniers')->result(); ////poy denier before poy inward
		$data['poydeniers'] = $this->m_masters->getactivemaster('bud_yt_poydeniers', 'denier_status');
		$data['yarndeniers'] = $this->m_masters->getactivemaster('bud_yt_yarndeniers', 'denier_status');
		$data['shades'] = $this->m_masters->getactivemaster('bud_shades', 'shade_status');
		$data['tareweights'] = $this->m_masters->getactivemaster('bud_tareweights', 'tareweight_status');
		$data['stock_rooms'] = $this->m_masters->getactivemaster('bud_stock_rooms', 'stock_room_status');
		$data['stock_room_id'] = '';
		$data['gray_yarn_soft'] = $this->ak->yt_packing_boxes('S');
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

		$this->load->view('v_store_gray_yarn_soft', $data);
	}
	//poy denier before poy inward
	function get_poy_po_no()
	{
		$this->db->where('poy_denier', $this->uri->segment(3));
		$this->db->group_by('po_no');
		$data = $this->db->get('bud_yt_poyinw_items')->result_array();
		echo '<option value=""> Choose </option>';
		foreach ($data as $row) {
			echo '<option value="' . $row['po_no'] . '">' . $row['po_no'] . '</option>';
		}
	}
	//poy denier before poy inward
	function gray_yarn_soft_save()
	{
		// echo "<pre>".print_r($_POST)."</pre>";
		$action = $this->input->post('action');
		$id = $this->input->post('id');
		$poy_inward_no = $this->input->post('poy_inward_no'); //tot pkd qty correction
		$poy_inward_prefix = $this->m_masters->getmasterIDvalue(' bud_yt_poy_inward', 'po_no', $poy_inward_no, 'poy_inward_prefix'); //tot pkd qty correction
		$data = array(
			'box_prefix' => 'S',
			'item_id' => $this->input->post('item_id')==''?0:$this->input->post('item_id'),
			'poy_denier' => $this->input->post('poy_denier'),
			'poy_inward_no' => $this->input->post('poy_inward_no'),
			'poy_inward_prefix' => $poy_inward_prefix, //tot pkd qty correction
			'remarks' => $this->input->post('remark'),
			'poy_lot_id' => $this->input->post('poy_lot_id'),
			'yarn_denier' => $this->input->post('yarn_denier'),
			'shade_no' => $this->input->post('colour'),
			'gross_weight' => $this->input->post('g_wt'),
			'net_weight' => $this->input->post('nt_wt'),
			'packed_by' => $this->input->post('pack_by'),
			'packed_date' => date('Y-m-d H:i:s'),
			'box_weight' => $this->input->post('box_weight'),
			'no_boxes' => $this->input->post('no_of_box'),
			'poly_bag_weight' => $this->input->post('poly_bag'),
			'spring_weight' => $this->input->post('spring_weight'),
			'cone_weight' => $this->input->post('cone_weight'),
			'no_cones' => $this->input->post('no_of_cones'),
			'no_of_cones' => $this->input->post('no_of_cones'),
			'other_weight' => $this->input->post('other_weight'),
			'lot_wastage' => $this->input->post('lot_wastage')==''?0:$this->input->post('lot_wastage'),
			'stock_room_id' => $this->input->post('stock_room_id'),
			'yarn_lot_id' => $this->input->post('yarn_lot_id')
		);

		if ($this->input->post('cone_weight_2')) {
			$data['cone_weight_2'] = $this->input->post('cone_weight_2');
		}
		if ($this->input->post('no_of_cones_2')) {
			$data['no_of_cones_2'] = $this->input->post('no_of_cones_2');
		}
		if ($this->input->post('tot_cone_weight_2')) {
			$data['tot_cone_weight_2'] = $this->input->post('tot_cone_weight_2');
		}

		if ($action == 'duplicate') {
			$box_no = $this->ak->getNextBoxNo('S');
			$data['box_no'] = $box_no;
			$result = $this->m_masters->savemaster('bud_yt_packing_boxes', $data);
		} elseif ($action == 'save_continue') {
			$box_no = $this->ak->getNextBoxNo('S');
			$data['box_no'] = $box_no;
			$result = $this->m_masters->savemaster('bud_yt_packing_boxes', $data);
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url('store/gray_yarn_soft/' . $result), 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "store/gray_yarn_soft", 'refresh');
			}
		} elseif ($action == 'save_continue_p') {
			$box_no = $this->ak->getNextBoxNo('S');
			$data['box_no'] = $box_no;
			$result = $this->m_masters->savemaster('bud_yt_packing_boxes', $data);
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url('store/gray_yarn_soft/' . $result . '/print'), 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "store/gray_yarn_soft", 'refresh');
			}
		} else {
			if ($id == '') {
				$box_no = $this->ak->getNextBoxNo('S');
				$data['box_no'] = $box_no;
				$result = $this->m_masters->savemaster('bud_yt_packing_boxes', $data);
			} else {
				$result = $this->m_purchase->updateDatas('bud_yt_packing_boxes', 'box_id', $id, $data);
			}
		}

		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "store/gray_yarn_soft", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "store/gray_yarn_soft", 'refresh');
		}
	}

	function print_gray_yarn_soft($box_no = null)
	{
		$box = $this->ak->yt_packing_box($box_no);
		if (!$box) {
			$this->session->set_flashdata('error', 'No data found');
			redirect(base_url() . "store/gray_yarn_soft", 'refresh');
		}

		$data['box'] = $box;
		$data['js'] = array(
			'barcode/jquery-1.3.2.min.js',
			'barcode/jquery-barcode.js'
		);
		$this->load->view('v_store_print_gray_yarn_soft', $data);
	}

	function delete_packing_box($box_id = null)
	{
		$remarks = $this->input->post('remarks');
		$formData = array(
			'remarks' => $remarks,
			'is_deleted' => 1,
			'deleted_by' => $this->session->userdata('user_id'),
			'deleted_time' => date("Y-m-d H:i:s")
		);
		$result = $this->m_purchase->updateDatas('bud_yt_packing_boxes', 'box_id', $box_id, $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Deleted!!!');
			redirect(base_url() . "store/" . $this->uri->segment(4), 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "store/" . $this->uri->segment(4), 'refresh');
		}
	}
	function gray_yarn_packing($id = false, $edit = false)
	{
		$this->load->model('m_poy');
		$data['activeTab'] = 'store';
		$data['activeItem'] = 'gray_yarn_packing';
		$data['page_title'] = 'Gray Yarn Packing';
		$data['yarn_lot_id'] = '';
		$data['supplier_id'] = '';

		if (!empty($id)) {
			$data['id'] = $this->uri->segment(3);
			$data['box_no'] = $this->ak->getNextBoxNo('G');
		} else {
			$data['id'] = null;
			$data['box_no'] = $this->ak->getNextBoxNo('G');
		}

		if (!empty($edit)) {
			$data['edit'] = $edit;
		}
		$data['print'] = "";
		if (!empty($this->uri->segment(4))) {
			if ($this->uri->segment(4) == 'print') {
				$data['print'] = base_url() . 'store/print_gray_yarn_pack/' . $this->uri->segment(3);
			}
		}

		// $data['poy_inwards'] = $this->m_poy->get_poy_inwards();
		$data['poy_inwards'] = $this->m_poy->get_poy_inward();
		$data['poy_lots'] = $this->m_poy->get_poy_lost();
		$data['yarn_lots'] = $this->m_poy->get_yarn_lots();
		$data['suppliers'] = $this->m_poy->get_suppliers();
		$data['gray_yarn_packing'] = $this->ak->yt_packing_boxes('G', array(), false); //to remove deleted boxes from under table
		$data['denier'] = $this->db->get('bud_yt_poydeniers')->result(); ////poy denier before poy inward
		$data['items'] = $this->m_masters->getactivemaster('bud_items', 'item_status');
		$data['poydeniers'] = $this->m_masters->getactivemaster('bud_yt_poydeniers', 'denier_status');
		$data['yarndeniers'] = $this->m_masters->getactivemaster('bud_yt_yarndeniers', 'denier_status');
		$data['shades'] = $this->m_masters->getactivemaster('bud_shades', 'shade_status');
		$data['tareweights'] = $this->m_masters->getactivemaster('bud_tareweights', 'tareweight_status');
		$data['stock_rooms'] = $this->m_masters->getactivemaster('bud_stock_rooms', 'stock_room_status');
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
		
		$this->load->view('v_store_gray_yarn_packing', $data);
	}

	function gray_yarn_packing_save()
	{
		//echo "<pre>".print_r($_POST)."</pre>";
		$action = $this->input->post('action');
		$id = $this->input->post('id');
		$poy_inward_no = $this->input->post('poy_inward_no'); //tot pkd qty correction
		$poy_inward_prefix = $this->m_masters->getmasterIDvalue(' bud_yt_poy_inward', 'po_no', $poy_inward_no, 'poy_inward_prefix'); //tot pkd qty correction
		$data = array(
			'box_prefix' => 'G',
			'remarks' => $this->input->post('remark'),
			'item_id' => $this->input->post('item_id')==''?0:$this->input->post('item_id'),
			'poy_denier' => $this->input->post('poy_denier')==''?0:$this->input->post('poy_denier'),
			'poy_inward_prefix' => $poy_inward_prefix, //tot pkd qty correction
			'poy_inward_no' => $this->input->post('poy_inward_no'),
			'yarn_denier' => $this->input->post('yarn_denier'),
			'shade_no' => $this->input->post('colour'),
			'gross_weight' => $this->input->post('g_wt'),
			'net_weight' => $this->input->post('nt_wt'),
			'packed_by' => $this->input->post('pack_by'),
			'packed_date' => date('Y-m-d H:i:s'),
			'box_weight' => $this->input->post('box_weight'),
			'no_boxes' => $this->input->post('no_of_box'),
			'poly_bag_weight' => $this->input->post('poly_bag'),
			'no_bags' => $this->input->post('no_of_poly_bag'),
			'cone_weight' => $this->input->post('cone_weight'),
			'no_cones' => $this->input->post('no_of_cones'),
			'no_of_cones' => $this->input->post('no_of_cones'),
			'spring_weight' => $this->input->post('spring_weight'),
			'other_weight' => $this->input->post('other_weight'),
			'stock_room_id' => $this->input->post('stock_room_id'),
			'poy_lot_id' => $this->input->post('poy_lot_id')==''?0:$this->input->post('poy_lot_id'),
			'yarn_lot_id' => $this->input->post('yarn_lot_id')
		);
		
		if ($this->input->post('cone_weight_2')) {
			$data['cone_weight_2'] = $this->input->post('cone_weight_2');
		}
		if ($this->input->post('no_of_cones_2')) {
			$data['no_of_cones_2'] = $this->input->post('no_of_cones_2');
		}
		if ($this->input->post('tot_cone_weight_2')) {
			$data['tot_cone_weight_2'] = $this->input->post('tot_cone_weight_2');
		}

		if ($this->input->post('poy_inward_no_2')) {
			$data['poy_inward_no_2'] = $this->input->post('poy_inward_no_2');
			$net_weight_temp = $this->input->post('nt_wt') / 2;
			$data['poy_inward_no_2_qty'] = $net_weight_temp;
			$data['poy_inward_no_1_qty'] = $net_weight_temp;
		}

		if ($action == 'duplicate') {
			$box_no = $this->ak->getNextBoxNo('G');
			$data['box_no'] = $box_no;
			$result = $this->m_masters->savemaster('bud_yt_packing_boxes', $data);
		} elseif ($action == 'save_continue') {
			$box_no = $this->ak->getNextBoxNo('G');
			$data['box_no'] = $box_no;
			$result = $this->m_masters->savemaster('bud_yt_packing_boxes', $data);
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url('store/gray_yarn_packing/' . $result), 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "store/gray_yarn_packing", 'refresh');
			}
		} elseif ($action == 'save_continue_p') {
			$box_no = $this->ak->getNextBoxNo('G');
			$data['box_no'] = $box_no;
			$result = $this->m_masters->savemaster('bud_yt_packing_boxes', $data);
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url('store/gray_yarn_packing/' . $result . '/print'), 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "store/gray_yarn_packing", 'refresh');
			}
		} else {
			if ($id == '') {
				$box_no = $this->ak->getNextBoxNo('G');
				$data['box_no'] = $box_no;
				$result = $this->m_masters->savemaster('bud_yt_packing_boxes', $data);
			} else {
				$result = $this->m_purchase->updateDatas('bud_yt_packing_boxes', 'box_id', $id, $data);
			}
		}
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "store/gray_yarn_packing", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "store/gray_yarn_packing", 'refresh');
		}
	}

	function print_gray_yarn_pack($box_no = null)
	{
		$box = $this->ak->yt_packing_box($box_no);
		if (!$box) {
			$this->session->set_flashdata('error', 'No data found');
			redirect(base_url() . "store/gray_yarn_packing", 'refresh');
		}

		$data['box'] = $box;
		$data['js'] = array(
			'barcode/jquery-1.3.2.min.js',
			'barcode/jquery-barcode.js'
		);
		$this->load->view('v_store_print_gray_yarn_pack', $data);
	}

	public function get_lot_list()
	{
		// print_r($_POST);
		$this->load->model('m_poy');
		$filter = array();
		if ($this->input->post('customer_id')) {
			$filter['customer_id'] = $this->input->post('customer_id');
		}
		if ($this->input->post('shade_id')) {
			$filter['shade_id'] = $this->input->post('shade_id');
		}
		if ($this->input->post('item_id')) {
			$filter['item_id'] = $this->input->post('item_id');
		}
		$lots = $this->m_poy->get_lot_list($filter);

		// print_r($lots);

		$options = '<option value="">Select</option>';
		if (sizeof($lots) > 0) {
			foreach ($lots as $row) {
				$options .= '<option value="' . $row->lot_id . '">' . $row->lot_no . '</option>';
			}
		}
		echo $options;
	}

	function dyed_yarn_packing($id = false, $edit = false)
	{
		$this->load->model('m_poy');
		$data['activeTab'] = 'store';
		$data['activeItem'] = 'dyed_yarn_packing';
		$data['page_title'] = 'Dyed Yarn Packing';

		if (!empty($id)) {
			$data['id'] = $this->uri->segment(3);
			$data['box_no'] = $this->ak->getNextBoxNo('D');
		} else {
			$data['id'] = null;
			$data['box_no'] = $this->ak->getNextBoxNo('D');
		}

		if (!empty($edit)) {
			$data['edit'] = $edit;
		}
		$data['print'] = "";
		if (!empty($this->uri->segment(4))) {
			if ($this->uri->segment(4) == 'print') {
				$data['print'] = base_url() . 'store/print_dyed_yarn_pack/' . $this->uri->segment(3);
			}
		}

		$data['items'] = $this->m_masters->getactivemaster('bud_items', 'item_status');
		$data['lots'] = $this->m_masters->get_lots();
		$data['yarndeniers'] = $this->m_masters->getactivemaster('bud_yt_yarndeniers', 'denier_status');
		$data['shades'] = $this->m_masters->getactivemaster('bud_shades', 'shade_status');
		$data['tareweights'] = $this->m_masters->getactivemaster('bud_tareweights', 'tareweight_status');
		$data['stock_rooms'] = $this->m_masters->getactivemaster('bud_stock_rooms', 'stock_room_status');
		$data['dyed_yarn_packing'] = $this->ak->yt_packing_boxes('D', array(), FALSE); //to remove deleted boxes from under table
		$data['customers'] = $this->m_poy->get_customers();
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

		$this->load->view('v_store_dyed_yarn_packing', $data);
	}
	function dyed_yarn_packing_save()
	{
		//echo "<pre>".print_r($_POST)."</pre>";
		$action = $this->input->post('action');
		echo $id = $this->input->post('id');
		$data = array(
			'box_prefix' => 'D',
			'item_id' => $this->input->post('item_id'),
			'lot_no' => $this->input->post('lot_no'),
			'remarks' => $this->input->post('remark'),
			'yarn_denier' => $this->input->post('yarn_denier'),
			'shade_no' => $this->input->post('colour'),
			'gross_weight' => $this->input->post('g_wt'),
			'net_weight' => $this->input->post('nt_wt'),
			'packed_by' => $this->input->post('pack_by'),
			'packed_date' => date('Y-m-d H:i:s'),
			'box_weight' => $this->input->post('box_weight'),
			'no_boxes' => $this->input->post('no_of_box'),
			'poly_bag_weight' => $this->input->post('poly_bag'),
			'no_bags' => $this->input->post('no_of_poly_bag'),
			'cone_weight' => $this->input->post('cone_weight'),
			'no_cones' => $this->input->post('no_of_cones'),
			'no_of_cones' => $this->input->post('no_of_cones'),
			'spring_weight' => $this->input->post('spring_weight'),
			'other_weight' => $this->input->post('other_weight'),
			'stock_room_id' => $this->input->post('stock_room_id')
		);
		if ($this->input->post('cone_weight_2')) {
			$data['cone_weight_2'] = $this->input->post('cone_weight_2');
		}
		if ($this->input->post('no_of_cones_2')) {
			$data['no_of_cones_2'] = $this->input->post('no_of_cones_2');
		}
		if ($this->input->post('tot_cone_weight_2')) {
			$data['tot_cone_weight_2'] = $this->input->post('tot_cone_weight_2');
		}

		if ($action == 'duplicate') {
			$box_no = $this->ak->getNextBoxNo('D');
			$data['box_no'] = $box_no;
			$result = $this->m_masters->savemaster('bud_yt_packing_boxes', $data);
		} elseif ($action == 'save_continue') {
			$box_no = $this->ak->getNextBoxNo('D');
			$data['box_no'] = $box_no;
			$result = $this->m_masters->savemaster('bud_yt_packing_boxes', $data);
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url('store/dyed_yarn_packing/' . $result), 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "store/dyed_yarn_packing", 'refresh');
			}
		} elseif ($action == 'save_continue_p') {
			$box_no = $this->ak->getNextBoxNo('D');
			$data['box_no'] = $box_no;
			$result = $this->m_masters->savemaster('bud_yt_packing_boxes', $data);
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url('store/dyed_yarn_packing/' . $result . '/print'), 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "store/dyed_yarn_packing", 'refresh');
			}
		}
		//Inclusion of Direct Print Option
		elseif ($action == 'save_print') {
			$box_no = $this->ak->getNextBoxNo('D');
			$data['box_no'] = $box_no;
			$result = $this->m_masters->savemaster('bud_yt_packing_boxes', $data);
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url('store/print_dyed_yarn_pack/' . $result . '/save_print'));
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "store/dyed_yarn_packing", 'refresh');
			}
		}
		//end of Inclusion of Direct Print Option
		else {
			if ($id == '') {
				$box_no = $this->ak->getNextBoxNo('D');
				$data['box_no'] = $box_no;
				$result = $this->m_masters->savemaster('bud_yt_packing_boxes', $data);
			} else {
				$result = $this->m_purchase->updateDatas('bud_yt_packing_boxes', 'box_id', $id, $data);
			}
		}
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "store/dyed_yarn_packing", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "store/dyed_yarn_packing", 'refresh');
		}
	}
	function print_dyed_yarn_pack($box_no = null, $action = false)
	{
		$data['continue'] = false;
		$box = $this->ak->yt_packing_box($box_no);
		if ($action) {
			$data['continue'] = true;
		}
		if (!$box) {
			$this->session->set_flashdata('error', 'No data found');
			redirect(base_url() . "store/dyed_yarn_packing", 'refresh');
		}

		$data['box'] = $box;
		$data['js'] = array(
			'barcode/jquery-1.3.2.min.js',
			'barcode/jquery-barcode.js'
		);
		$this->load->view('v_store_print_dyed_yarn_pack', $data);
	}
	function yarn_lot_details($id)
	{
		$resultData = array();
		$total_packed = $this->ak->totLotPacked($id);
		$result = $this->ak->lot_inf_bal($id);
		foreach ($result as $row) {
			$resultData[] = $row['item_code'];
			$resultData[] = $row['item_name'];
			$resultData[] = $row['shade_code'];
			$resultData[] = $row['shade_name'];
			$tot_lot_qty = $row['sum(total.net_wt)'];
			$resultData[] = $row['sum(total.net_wt)'];
			$resultData[] = $row['shade_id'];
		}
		$resultData[] = $tot_lot_qty - $total_packed;
		// print_r($resultData);
		echo implode("$$", $resultData);
	}
	function dyed_thread_inner($inner_box_id = false, $edit = false)
	{
		$this->load->library("form_validation");
		$this->load->model("m_poy");

		$data['items'] = $this->m_masters->getactivemaster('bud_items', 'item_status');
		$data['shades'] = $this->m_masters->getactivemaster('bud_shades', 'shade_status');
		$data['activeTab'] = 'store';
		$data['activeItem'] = 'dyed_thread_inner';
		$data['page_title'] = 'Thread inner Box Packing Entry';
		$data['lots'] = $this->m_masters->get_lots();
		$data['inner_boxes'] = $this->ak->get_thread_inner_boxes();
		$data['customers'] = $this->m_poy->get_customers();
		// $data['inner_boxes'] = $this->ak->get_dyed_thread_inner_boxes();
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

		if ($inner_box_id && !empty($edit)) {
			$data['box_no'] = $inner_box_id;
		} elseif ($inner_box_id) {
			$next = $this->db->query("SHOW TABLE STATUS LIKE 'ak_po_dyed_thread_inner'");
			$next = $next->row(0);
			$data['box_no'] = $next->Auto_increment;
		} else {
			$next = $this->db->query("SHOW TABLE STATUS LIKE 'ak_po_dyed_thread_inner'");
			$next = $next->row(0);
			$data['box_no'] = $next->Auto_increment;
		}


		$data['inner_box_id'] = '';
		$data['lot_id'] = '';
		$data['item_id'] = '';
		$data['shade_id'] = '';
		$data['no_of_cones'] = '';
		$data['nt_weight_cone'] = '';
		$data['meter_cone'] = '';
		$data['gross_weight'] = '';
		$data['net_weight'] = '';
		$data['packed_by'] = '';
		$data['packed_date'] = '';

		if ($inner_box_id) {
			$inner_box = $this->ak->get_thread_inner_box($inner_box_id);
			if (!$inner_box) {
				$this->session->set_flashdata('error', 'Record Not Found');
				redirect(base_url('store/dyed_thread_inner'));
			}
			$data['inner_box_id'] = $inner_box->inner_box_id;
			$data['lot_id'] = $inner_box->lot_id;
			$data['item_id'] = $inner_box->item_id;
			$data['shade_id'] = $inner_box->shade_id;
			$data['no_of_cones'] = $inner_box->no_of_cones;
			$data['nt_weight_cone'] = $inner_box->nt_weight_cone;
			$data['meter_cone'] = $inner_box->meter_cone;
			$data['gross_weight'] = $inner_box->gross_weight;
			$data['net_weight'] = $inner_box->net_weight;
			$data['packed_by'] = $inner_box->packed_by;
			$data['packed_date'] = $inner_box->packed_date;
		}

		// Set Validation Rules
		$this->form_validation->set_rules('lot_id', 'Lot No', 'required');
		$this->form_validation->set_rules('gross_weight', 'Gross Weight', 'required');
		$this->form_validation->set_rules('net_weight', 'Net Weight', 'required');

		$action = 'save';
		if ($this->input->post('save')) {
			$action = 'save';
		}
		if ($this->input->post('save_continue')) {
			$action = 'save_continue';
		}
		if ($this->input->post('save')) {
			$data['inner_box_id'] = $inner_box_id;
			$data['lot_id'] = $this->input->post('lot_id');
			$data['item_id'] = $this->input->post('item_id');
			$data['shade_id'] = $this->input->post('shade_id');
			$data['no_of_cones'] = $this->input->post('no_of_cones');
			$data['nt_weight_cone'] = $this->input->post('nt_weight_cone');
			$data['meter_cone'] = $this->input->post('meter_cone');
			$data['gross_weight'] = $this->input->post('gross_weight');
			$data['net_weight'] = $this->input->post('net_weight');
			$data['packed_by'] = $this->input->post('net_weight');
			$data['packed_date'] = $this->input->post('packed_date');
		}
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('v_store_dyed_thread_inner', $data);
		} else {
			if ($action == 'save') {
				$save['inner_box_id'] = $inner_box_id;
			} else {
				$save['inner_box_id'] = '';
			}

			$save['lot_id'] = $this->input->post('lot_id');
			$save['item_id'] = $this->input->post('item_id');
			$save['shade_id'] = $this->input->post('shade_id');
			$save['no_of_cones'] = $this->input->post('no_of_cones');
			$save['nt_weight_cone'] = $this->input->post('nt_weight_cone');
			$save['meter_cone'] = $this->input->post('meter_cone');
			$save['gross_weight'] = $this->input->post('gross_weight');
			$save['net_weight'] = $this->input->post('net_weight');
			$save['packed_by'] = $this->input->post('packed_by');
			$save['packed_date'] = $this->input->post('packed_date');

			$result = $this->ak->save_thread_inner_box($save);

			$this->session->set_flashdata('success', 'Successfully Saved');
			//go back to the Box list
			if ($action == 'save') {
				redirect(base_url('store/dyed_thread_inner'));
			}
			if ($action == 'save_continue') {
				redirect(base_url('store/dyed_thread_inner/' . $result));
			}
		}
	}

	function delete_thread_inner($inner_box_id)
	{
		if ($inner_box_id) {
			$inner_box	= $this->ak->get_thread_inner_box($inner_box_id);
			//if the inner_box does not exist, redirect them to the inner_box list with an error
			if (!$inner_box) {
				$this->session->set_flashdata('error', 'Record Not Found');
				redirect(base_url('store/dyed_thread_inner'));
			} else {
				$this->ak->del_thread_inner_box($inner_box_id);

				$this->session->set_flashdata('success', 'Successfully Deleted');
				redirect(base_url('store/dyed_thread_inner'));
			}
		} else {
			//if they do not provide an inner_box_id send them to the inner_box list page with an error
			$this->session->set_flashdata('success', 'Successfully Deleted');
			redirect(base_url('store/dyed_thread_inner'));
		}
	}
	function dyed_yarn_inner_save($lot, $gross, $no_of_cone, $cone_wt, $cone_meter, $net, $form)
	{
		$data = array(
			'lot' => $lot,
			'gross' => $gross,
			'no_of_cones' => $no_of_cone,
			'net_wt_per_cone' => $cone_wt,
			'meter_per_cone' => $cone_meter,
			'net' => $net,
			'packed_by' => $form
		);
		$this->ak->insert_new('ak_po_dyed_thread_inner', $data);
		echo "success";
	}

	function get_dyed_inner_boxes($value = '')
	{
		$data['inner_boxes'] = $this->ak->get_thread_inner_boxes();
		$this->load->view('includes/dyed-thread-inner-boxes', $data);
	}

	function th_outer_add_to_cart()
	{
		if ($this->input->post('selected_boxes')) {
			$selected_boxes = explode(",", $this->input->post('selected_boxes'));
			if (count($selected_boxes) > 0) {
				foreach ($selected_boxes as $inner_box_id) {
					$cart_item = array(
						'id' => $inner_box_id,
						'name' => $inner_box_id,
						'price' => 1,
						'qty' => 1
					);

					if ($this->cart->insert($cart_item)) {
						$update_box = array();
						$update_box['inner_box_id'] = $inner_box_id;
						$update_box['outerbox_packed'] = 1;
						$this->ak->update_thread_inner_box($update_box);
					}
				}
			}
		}
	}

	function th_outer_remove_cart($value = '')
	{
		if ($this->input->post('row_id')) {
			$row_id = $this->input->post('row_id');
			$cart_items = $this->cart->contents();
			if (sizeof($cart_items) > 0) {
				foreach ($cart_items as $item) {
					if ($item['id'] == $this->input->post('row_id')) {
						$update_box = array();
						$update_box['inner_box_id'] = $item['id'];
						$update_box['outerbox_packed'] = 0;
						$this->ak->update_thread_inner_box($update_box);

						$cart_item = array(
							'rowid'   => $item['rowid'],
							'qty'     => 0
						);
						$this->cart->update($cart_item);
					}
				}
			}
		}
	}

	function th_outer_cart_items()
	{
		// $data['inner_boxes'] = $this->ak->get_thread_inner_boxes();
		$data['cart_items'] = $this->cart->contents();
		$this->load->view('includes/th-outer-cart-items', $data);
	}

	function dyed_thread_outer()
	{
		// author ak
		$data['box_no'] = $this->ak->getNextBoxNo('TI');
		$data['activeTab'] = 'store';
		$data['activeItem'] = 'dyed_thread_outer';
		$data['page_title'] = 'Thread Outer Box Entry with Inner Box';
		$data['inner_boxes'] = $this->ak->get_thread_inner_boxes();
		$data['stock_rooms'] = $this->m_masters->getactivemaster('bud_stock_rooms', 'stock_room_status');
		$data['boxes'] = $this->ak->yt_packing_boxes('TI');
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


		$this->load->view('v_store_dyed_thread_outer', $data);
	}
	function dyed_yarn_outer_save()
	{
		/*echo "<pre>";
		print_r($_POST);
		echo "</pre>";*/
		$box_id = '';
		$net_weight = 0.000;
		$no_of_cones = 0;
		$box_ids = array();
		$gross_weight = $this->input->post('gross_weight');
		if ($this->input->post('box_ids')) {
			$box_ids = explode(",", $this->input->post('box_ids'));
		}
		if (count($box_ids) > 0) {
			$inner_boxes = array();
			foreach ($box_ids as $inner_box_id) {
				$inner_box = $this->ak->get_thread_inner_box($inner_box_id);
				$inner_boxes[$inner_box_id]['lot_id'] = $inner_box->lot_id;
				$inner_boxes[$inner_box_id]['item_id'] = $inner_box->item_id;
				$inner_boxes[$inner_box_id]['shade_id'] = $inner_box->shade_id;
				$inner_boxes[$inner_box_id]['no_of_cones'] = $inner_box->no_of_cones;
				$inner_boxes[$inner_box_id]['nt_weight_cone'] = $inner_box->nt_weight_cone;
				$inner_boxes[$inner_box_id]['meter_cone'] = $inner_box->meter_cone;
				$inner_boxes[$inner_box_id]['gross_weight'] = $inner_box->gross_weight;
				$inner_boxes[$inner_box_id]['net_weight'] = $inner_box->net_weight;

				$net_weight += $inner_box->net_weight;
				$no_of_cones += $inner_box->no_of_cones;
			}

			$data = array(
				'box_prefix' => 'TI',
				'gross_weight' => $gross_weight,
				'net_weight' => $net_weight,
				'packed_by' => $this->input->post('pack_by'),
				'packed_date' => date('Y-m-d H:i:s'),
				'no_of_cones' => $no_of_cones,
				'stock_room_id' => $this->input->post('stock_room_id'),
				'inner_boxes' => json_encode($inner_boxes)
			);

			if ($box_id == '') {
				$new  = array(
					'item_id' => $inner_boxes[$inner_box_id]['item_id'],
					'shade_no' => $inner_boxes[$inner_box_id]['shade_id']
				);

				$box_no = $this->ak->getNextBoxNo('TI');
				$data['box_no'] = $box_no;
				$result = $this->m_masters->savemaster('bud_yt_packing_boxes', array_merge($data, $new));
			} else {
				$new  = array(
					'item_id' => $inner_boxes[$inner_box_id]['item_id'],
					'shade_no' => $inner_boxes[$inner_box_id]['shade_id']
				);

				$result = $this->m_purchase->updateDatas('bud_yt_packing_boxes', 'box_id', $box_id, array_merge($data, $new));
			}
			if ($result) {
				foreach ($box_ids as $inner_box_id) {
					$inner_box_data = array(
						'outerbox_packed' => 1
					);
					$this->m_purchase->updateDatas('ak_po_dyed_thread_inner', 'inner_box_id', $inner_box_id, $inner_box_data);
				}
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				$this->cart->destroy();
				redirect(base_url() . "store/dyed_thread_outer", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "store/dyed_thread_outer", 'refresh');
			}
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "store/dyed_thread_outer", 'refresh');
		}

		// echo json_encode($inner_boxes);
	}

	function print_thread_with_i($box_no = null)
	{
		$box = $this->ak->yt_packing_box($box_no);
		if (!$box) {
			$this->session->set_flashdata('error', 'No data found');
			redirect(base_url() . "store/dyed_thread_outer", 'refresh');
		}

		$data['box'] = $box;
		$data['js'] = array(
			'barcode/jquery-1.3.2.min.js',
			'barcode/jquery-barcode.js'
		);
		$this->load->view('v_store_print_thread_with_i', $data);
	}

	function get_lot_qty($lot_id = false)
	{
		$return = array();
		$lot_qty = 0.000;
		$tot_packed_qty = 0.000;
		$tot_balancd_qty = 0.000;
		$lot_shade_no = '';
		$percentage = 0;
		if (!empty($lot_id)) {
			// $lot = $this->m_masters->get_lot($lot_id);
			$lot = $this->m_masters->get_lot_details($lot_id);
			// print_r($lot);
			if ($lot) {
				$items = $this->m_purchase->get_dlc_lot_qty($lot_id);
				if (sizeof($items) > 0) {
					foreach ($items as $item) {
						$lot_qty += $item->net_weight;
					}
				}
				// $lot_qty = $lot->lot_actual_qty;
				$lot_shade_no = $lot->lot_shade_no;

				$return['item_name'] = $lot->item_name;
				$return['item_id'] = $lot->item_id;
				$return['cust_name'] = $lot->cust_name;
				$return['customer_id'] = $lot->bud_customers;
				$return['shade_code'] = $lot->shade_code;
				$return['shade_name'] = $lot->shade_name;
			}

			$pack_qty = $this->m_masters->get_lot_pack_qty($lot_id);
			if ($pack_qty) {
				if ($pack_qty->tot_packed_qty > 0) {
					$tot_packed_qty = $pack_qty->tot_packed_qty;
				}
			}
		}
		$tot_balancd_qty = $lot_qty - $tot_packed_qty;

		$return['lot_qty'] = number_format($lot_qty, 3, '.', '');
		$return['tot_packed_qty'] = number_format($tot_packed_qty, 3, '.', '');
		$return['tot_balancd_qty'] = number_format($tot_balancd_qty, 3, '.', '');
		$return['lot_shade_no'] = $lot_shade_no;
		echo json_encode($return);
	}

	function dyed_thread_packing()
	{
		// author ak
		$this->load->model('m_poy');
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'ak_po_dyed_thread_pack'");
		$next = $next->row(0);
		$data['next'] = $next->Auto_increment;
		$data['next_boxno'] = $this->ak->getNextBoxNo('TH');
		$data['table'] = $this->ak->yt_packing_boxes('TH');
		$data['activeTab'] = 'store';
		$data['activeItem'] = 'dyed_thread_packing';
		$data['page_title'] = 'Dyed Thread Packing Entry ( Without Inner )';
		$data['tareweights'] = $this->m_masters->getactivemaster('bud_tareweights', 'tareweight_status');
		$data['items'] = $this->m_masters->getactivemaster('bud_items', 'item_status');
		$data['shades'] = $this->m_masters->getactivemaster('bud_shades', 'shade_status');
		$data['stock_rooms'] = $this->m_masters->getactivemaster('bud_stock_rooms', 'stock_room_status');
		// $data['LOT'] = $this->ak->yarn_lot_from_delivered();
		$data['lots'] = $this->m_masters->get_lots();
		$data['customers'] = $this->m_poy->get_customers();
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
		if ($this->uri->segment(3) == true) {
			$data['id'] = $this->uri->segment(3);
		} else {
			$data['id'] = null;
		}
		$data['print'] = "";
		if (!empty($this->uri->segment(4))) {
			if ($this->uri->segment(4) == 'print') {
				$data['print'] = base_url() . 'store/print_thread_without_i/' . $this->uri->segment(3);
			}
		}
		$this->load->view('v_store_dyed_thread_packing', $data);
	}
	function dyed_thread_packing_save()
	{
		/*echo "<pre>";
		print_r($_POST);
		echo "</pre>";*/
		$action = $this->input->post('action');
		$box_id = $this->input->post('box_id');
		$item_id = $this->input->post('item_id');
		$lot_no = $this->input->post('lot_no');

		$shade_no = $this->input->post('shade_no');
		$box_wt = $this->input->post('box_wt');
		$no_boxes = $this->input->post('no_boxes');
		$poly_bag_weight = $this->input->post('poly_bag_weight');
		$no_bags = $this->input->post('no_bags');
		$weight_per_cone = $this->input->post('weight_per_cone');
		$other_weight = $this->input->post('other_weight');
		$gross = $this->input->post('gross');
		$net1 = $this->input->post('nt_wt1');
		$net2 = $this->input->post('nt_wt');
		$meter_per_cone = $this->input->post('meter_per_cone');
		$no_of_cones = $this->input->post('no_of_cones');
		$t_wt = $this->input->post('t_wt');
		$pack_by = $this->input->post('pack_by');
		$stock_room_id = $this->input->post('stock_room_id');
		$formData = array(
			'box_prefix' => 'TH',
			'item_id' => $item_id,
			'lot_no' => $lot_no,
			'shade_no' => $shade_no,
			'box_weight' => $box_wt,
			'no_boxes' => $no_boxes,
			'remarks' => $this->input->post('remark'),

			'poly_bag_weight' => $poly_bag_weight,
			'no_bags' => $no_bags,
			'weight_per_cone' => $weight_per_cone,
			'other_weight' => $other_weight,
			'gross_weight' => $gross,
			'net_weight_cones' => $net1,
			'net_weight' => $net2,
			'packed_by' => $pack_by,
			'no_of_cones' => $no_of_cones,
			'meter_per_cone' => $meter_per_cone,
			'stock_room_id' => $stock_room_id,
			'packed_date' => date("Y-m-d H:i:s")
		);
		if ($action == 'duplicate') {
			$box_no = $this->ak->getNextBoxNo('TH');
			$formData['box_no'] = $box_no;
			$result = $this->m_masters->savemaster('bud_yt_packing_boxes', $formData);
		} elseif ($action == 'save_continue') {
			$box_no = $this->ak->getNextBoxNo('TH');
			$formData['box_no'] = $box_no;
			$result = $this->m_masters->savemaster('bud_yt_packing_boxes', $formData);
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url('store/dyed_thread_packing/' . $result), 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "store/dyed_thread_packing", 'refresh');
			}
		} elseif ($action == 'save_continue_p') {
			$box_no = $this->ak->getNextBoxNo('TH');
			$formData['box_no'] = $box_no;
			$result = $this->m_masters->savemaster('bud_yt_packing_boxes', $formData);
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url('store/dyed_thread_packing/' . $result . '/print'), 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "store/dyed_thread_packing", 'refresh');
			}
		} else {
			if ($box_id == '') {
				$box_no = $this->ak->getNextBoxNo('TH');
				$formData['box_no'] = $box_no;
				$result = $this->m_masters->savemaster('bud_yt_packing_boxes', $formData);
			} else {
				$result = $this->m_purchase->updateDatas('bud_yt_packing_boxes', 'box_id', $box_id, $formData);
			}
		}
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "store/dyed_thread_packing", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "store/dyed_thread_packing", 'refresh');
		}
	}
	function print_thread_without_i($box_no = null)
	{
		$box = $this->ak->yt_packing_box($box_no);
		if (!$box) {
			$this->session->set_flashdata('error', 'No data found');
			redirect(base_url() . "store/dyed_yarn_packing", 'refresh');
		}

		$data['box'] = $box;
		$data['js'] = array(
			'barcode/jquery-1.3.2.min.js',
			'barcode/jquery-barcode.js'
		);
		$this->load->view('v_store_print_thread_without_i', $data);
	}
	function sales_return_box()
	{
		/* author ak
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'ak_po_salesreturn_box'");
		$next = $next->row(0);
		$data['next'] = $next->Auto_increment;		
*/
		$next = $this->ak->get_max_salesreturn_box();
		if ($next[0]['form_id'] > 0) {
			$data['next'] = ++$next[0]['form_id'];
		} else {
			$data['next'] = 1;
		}

		$data['activeTab'] = 'store';
		$data['activeItem'] = 'sales_return_box';
		$data['page_title'] = 'Sales Return Box Wise';
		$data['customers'] = $this->ak->get_table('bud_customers');
		$data['table'] = $this->ak->get_table('ak_po_salesreturn_box');
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

		$this->load->view('v_store_sales_return_box', $data);
	}
	function sales_return_box_save()
	{
		$next = $this->ak->get_max_salesreturn_box();
		if ($next[0]['form_id'] > 0) {
			$next = ++$next[0]['form_id'];
		} else {
			$next = 1;
		}

		$customers = $_POST['customers'];
		$boxes = $_POST['boxes'];
		$times = count($boxes);
		for ($i = 0; $i < $times; $i++) {
			$data = array(
				'form_id' => $next,
				'bud_customers' => $customers[$i],
				'boxes' => $boxes[$i],
				'received_by' => $_POST['received_by'],
				'accepted_by' => $_POST['accepted_by'],
				'remarks' => $_POST['remarks']
			);
			$this->ak->insert_new('ak_po_salesreturn_box', $data);
		}
		$this->session->set_flashdata('success', 'Successfully Saved!!!');
		redirect(base_url() . "store/sales_return_box", 'refresh');
		//var_dump($data);
	}
	function sales_return_item()
	{
		// author ak
		$next = $this->ak->get_max_salesreturn_item();
		if ($next[0]['form_id'] > 0) {
			$data['next'] = ++$next[0]['form_id'];
		} else {
			$data['next'] = 1;
		}

		$data['activeTab'] = 'store';
		$data['activeItem'] = 'sales_return_item';
		$data['page_title'] = 'Sales Return Item Wise';
		$data['items'] = $this->ak->get_table('bud_items');
		$data['shades'] = $this->ak->get_table('bud_shades');
		$data['table'] = $this->ak->get_sales_return_items();
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
		$this->load->view('v_store_sales_return_item', $data);
	}
	function sales_return_item_save()
	{
		$next = $this->ak->get_max_salesreturn_item();
		if ($next[0]['form_id'] > 0) {
			$next = ++$next[0]['form_id'];
		} else {
			$next = 1;
		}

		$times = count($_POST['item']);
		for ($i = 0; $i < $times; $i++) {
			$data = array(
				'form_id' => $next,
				'bud_items' => $_POST['item'][$i],
				'bud_shades' => $_POST['shade'][$i],
				'cone' => $_POST['cone'][$i],
				'gross' => $_POST['gross'][$i],
				'net' => $_POST['net'][$i],
				'received_by' => $_POST['received_by'],
				'accepted_by' => $_POST['accepted_by'],
				'remarks' => $_POST['remarks']
			);
			$this->ak->insert_new('ak_po_salesreturn_item', $data);
		}
		$this->session->set_flashdata('success', 'Successfully Saved!!!');
		redirect(base_url() . "store/sales_return_item", 'refresh');
		//var_dump($data);
	}
	function poy_issue_list()
	{
		$poy_issue = $this->ak->getPoyIssueList($this->input->post('id'));
		$sno = 1;
		foreach ($poy_issue as $row) {
			$id = $row['id'];
			$is_accepted = $row['is_accepted'];
			if ($id != '') {
				echo "
                                <tr class='odd gradeX'>
                                    <td>";
				echo $sno;
				echo "</td>
                                    <td>";
				echo $row['item_name'];
				echo "</td>
                                    <td>";
				echo $row['item_id'];
				echo "</td>                                 
                                    <td>";
				echo $row['dept_name'];
				echo "</td>                                 
                                    <td>";
				echo $row['group_name'];
				echo "</td>                                 
                                    <td>";
				echo $row['sup_name'];
				echo "</td>
                                    <td>";
				echo $row['denier_name'];
				echo "</td>
                                    <td>";
				echo $row['poy_lot_name'];
				echo "</td>
                                    <td>";
				echo $row['qty'];
				echo "</td>
                                    <td>";
				echo $row['uom_name'];
				echo "</td>
                                    <td>";
				echo $row['issue_datetime'];
				echo "</td>
                                    <td>
                                      <span class='";
				echo ($is_accepted == 1) ? 'label label-success' : 'label label-danger';
				echo "'>";
				echo ($is_accepted == 1) ? 'Accepted' : 'Not Accepted';
				echo "</span>
                                    </td>
                                </tr>";
			}
			$sno++;
		}
	}
	function get_store_poy_remain($id)
	{
		$total = $this->ak->tot_poy($id);
		$send = $this->ak->issue_poy($id);
		$balance = $total - $send;
		echo "$total - $send = $balance";
	}
	function porecieved()
	{
		$data['activeTab'] = 'store';
		$data['activeItem'] = 'porecieved';
		$data['page_title'] = 'Purchase Orders Recieved';
		$data['purchaseorders'] = $this->m_purchase->getActivetableDatas('bud_jobcards', 'jobcard_status');
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
			$this->load->view('v_store_po_recieved.php', $data);
		} else {
			$data['category_id'] = $this->uri->segment(3);
			$this->load->view('v_store_po_recieved.php', $data);
		}
	}
	function stockissue()
	{
		$data['activeTab'] = 'store';
		$data['activeItem'] = 'stockissue';
		$data['page_title'] = 'Stock Issue';
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
			$this->load->view('v_stockissue.php', $data);
		} else {
			$this->load->view('v_stockissue.php', $data);
		}
	}
	function getActivePO($category_id = null)
	{
		$resultData = array();
		$activePO = '';
		$P_orders = $this->m_masters->getactiveCdatas('bud_jobcards', 'jobcard_status', 'jobcard_category', $category_id);
		$activePO .= '<option value="">Select job card</option>';
		foreach ($P_orders as $order) {
			$jobcard_id = $order['jobcard_id'];
			$activePO .= '<option value="' . $jobcard_id . '">' . $jobcard_id . '</option>';
		}
		$resultData[] = $activePO;
		echo implode(",", $resultData);
	}
	function getPOdetails($order_id = null)
	{
		$resultData = array();
		$orderData = '';
		$P_orders = $this->m_masters->getactiveCdatas('bud_jobcards', 'jobcard_status', 'jobcard_id', $order_id);
		foreach ($P_orders as $order) {
			$resultData[] = $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $order['jobcard_customer'], 'cust_name');
			$resultData[] = $order['jobcard_customer'];
			$resultData[] = $order['jobcard_qty'];
			$resultData[] = $order['jobcard_issued_qty'];
		}
		echo implode(",", $resultData);
	}
	function savestockissue()
	{
		$po_date = $this->input->post('po_date');
		$po_order = $this->input->post('po_order');
		$po_issued_qty = $this->input->post('po_issued_qty');
		$po_issued_remarks = $this->input->post('po_issued_remarks');
		$qd = explode("-", $po_date);
		$po_date = $qd[2] . '-' . $qd[1] . '-' . $qd[0];
		$formData = array(
			'jobcard_issued_qty' => $po_issued_qty
		);
		$result = $this->m_purchase->updateDatas('bud_jobcards', 'jobcard_id', $po_order, $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "store/stockissue", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "store/stockissue", 'refresh');
		}
	}

	function poy_physical_stock($id = false)
	{
		$this->load->model('m_poy');
		$this->load->model('m_reports');
		$this->load->library('form_validation');
		$data['activeTab'] = 'store';
		$data['activeItem'] = 'poy_physical_stock';
		$data['page_title'] = 'Update POY Physical Stock';
		$data['poydeniers'] = $this->m_masters->getactivemaster('bud_yt_poydeniers', 'denier_status');
		$data['poy_lots'] = $this->m_masters->getactivemaster('bud_poy_lots', 'poy_status');
		$data['uoms'] = $this->m_masters->getactivemaster('bud_uoms', 'uom_status');
		$data['stock_list'] = $this->m_reports->get_poy_opening_stock_list();
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

		$data['id'] = $id;
		if ($this->input->post('submit')) {
			$save['id'] = $id;
			$save['denier_id'] = $this->input->post('denier_id');
			$save['poy_lot_id'] = $this->input->post('poy_lot_id');
			$save['closing_stock'] = $this->input->post('closing_stock');
			$save['uom_id'] = $this->input->post('uom_id');
			$save['remarks'] = $this->input->post('remarks');
			$save['username'] = $this->session->userdata('display_name');
			$save['updated_date'] = date("Y-m-d H:i:s");

			$this->m_poy->save_physical_stock($save);
			$this->session->set_flashdata('success', 'Successfully Saved');
			redirect(base_url('store/poy_physical_stock'));
		}
		$this->load->view('v_poy_physical_stock', $data);
	}
	function print_physical_stock($id = false)
	{
		$data['activeTab'] = 'store';
		$data['activeItem'] = 'poy_physical_stock';
		$data['page_title'] = 'POY Physical Stock';
		$this->load->model('m_reports');
		$data['stock_list'] = $this->m_reports->get_poy_opening_stock_list($id);

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
			'tabletools/css/dataTables.tableTools.css'
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
			'assets/data-tables/DT_bootstrap.js',
			'tabletools/js/dataTables.tableTools.js'
		);
		$data['js_common'] = array('js/common-scripts.js');
		$data['js_thispage'] = array('js/form-validation-script.js', 'js/form-component.js', 'js/dynamic-table.js');
		$this->load->view('print_physical_stock', $data);
	}
}
