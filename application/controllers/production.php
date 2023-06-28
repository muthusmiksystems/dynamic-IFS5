<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Production extends CI_Controller
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
		$this->load->model('m_mir');
		$this->load->model('m_reports'); //include delete Option Packing
		$this->load->library('cart');

		if (!$this->session->userdata('logged_in')) {
			// Allow some methods?
			$allowed = array();
			if (!in_array($this->router->method, $allowed)) {
				redirect(base_url() . 'users/login', 'refresh');
			}
		}
	}
	function internalpo()
	{
		$data['activeTab'] = 'production';
		$data['activeItem'] = 'internalpo';
		$data['page_title'] = 'Job Card Entry';
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
			$this->load->view('v_internalPO.php', $data);
		} else {
			$this->load->view('v_internalPO.php', $data);
		}
	}
	function getActivePO($category_id = null)
	{
		$resultData = array();
		$activePO = '';
		$P_orders = $this->m_masters->getactiveCdatas('bud_orders', 'order_status', 'order_category', $category_id);
		$activePO .= '<option value="">Select PO No</option>';
		foreach ($P_orders as $order) {
			$order_id = $order['order_id'];
			$activePO .= '<option value="' . $order_id . '">' . $order_id . '</option>';
		}
		$resultData[] = $activePO;
		echo implode(",", $resultData);
	}
	function getPOdetails($order_id = null)
	{
		$resultData = array();
		$orderData = '';
		$jobcards_items = '';
		$jobcards_items .= '<option value="">Select</option>';
		$P_orders = $this->m_masters->getactiveCdatas('bud_orders', 'order_status', 'order_id', $order_id);
		foreach ($P_orders as $order) {
			$order_enq_id = $order['order_enq_id'];
			$resultData[] = $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $order['order_customer'], 'cust_name');
			$resultData[] = $order['order_customer'];
		}
		$POitems = $this->m_purchase->getDatas('bud_enquiry_items', 'enq_ref_id', $order_enq_id);
		foreach ($POitems as $item) {
			$items[] = $item['enq_item_id'];
			$enq_item_id = $item['enq_item_id'];
			$enq_item = $item['enq_item'];

			$item_name = $this->m_masters->getmasterIDvalue('bud_items', 'item_id', $item['enq_item'], 'item_name');
			$item_color = $this->m_masters->getmasterIDvalue('bud_shades', 'shade_id', $item['enq_itemcolor'], 'shade_name');
			$jobcards_items .= '<option value="' . $enq_item_id . '">' . $item_name . ' / ' . $item_color . '</option>';
		}
		$resultData[] = $jobcards_items;
		echo implode(",", $resultData);
	}
	function getPOItemdetails($enq_item_id = null)
	{
		$resultData = array();
		$items = $this->m_purchase->getDatas('bud_enquiry_items', 'enq_item_id', $enq_item_id);
		foreach ($items as $item) {
			$jobcard_status = $item['jobcard_status'];
			$resultData[] = $item['enq_required_qty'];
			$resultData[] = $jobcard_status;
			// $resultData[] = $item['enq_required_qty'] - $item['enq_process_qty'];
			/*$resultData[] = $this->m_masters->getmasterIDvalue('bud_shades', 'shade_id', $item['enq_itemcolor'], 'shade_name');			
			$resultData[] = $this->m_masters->getmasterIDvalue('bud_lots', 'lot_id', $item['enq_lot_no'], 'lot_no');			*/
		}
		echo implode(",", $resultData);
	}
	function saveinternalPO()
	{
		$po_category = $this->input->post('po_category');
		$po_date = $this->input->post('po_date');
		$po_order = $this->input->post('po_order');
		$po_customer = $this->input->post('po_customer');
		$req_po_qty = $this->input->post('req_po_qty');
		$po_remarks = $this->input->post('po_remarks');
		$po_item = $this->input->post('po_item');
		$qd = explode("-", $po_date);
		$po_date = $qd[2] . '-' . $qd[1] . '-' . $qd[0];
		$formData = array(
			'jobcard_date' => $po_date,
			'jobcard_category' => $po_category,
			'jobcard_po_no' => $po_order,
			'jobcard_customer' => $po_customer,
			'jobcard_item' => $po_item,
			'jobcard_qty' => $req_po_qty,
			'jobcard_remarks' => $po_remarks
		);

		$result = $this->m_purchase->saveDatas('bud_jobcards', $formData);
		if ($result) {
			$updateData = array(
				'jobcard_status' => 0
			);
			$this->m_purchase->updateDatas('bud_enquiry_items', 'enq_item_id', $po_item, $updateData);

			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "production/internalpo", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "production/internalpo", 'refresh');
		}
	}
	function POrecieved()
	{
		$data['activeTab'] = 'production';
		$data['activeItem'] = 'POrecieved';
		$data['page_title'] = 'Job card recieved';
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
			$this->load->view('v_job_po_recieved.php', $data);
		} else {
			$data['category_id'] = $this->uri->segment(3);
			$this->load->view('v_job_po_recieved.php', $data);
		}
	}
	function processcard()
	{
		$data['activeTab'] = 'production';
		$data['activeItem'] = 'processcard';
		$data['page_title'] = 'Process card entry';
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
			$this->load->view('v_processcard_entry.php', $data);
		} else {
			$this->load->view('v_processcard_entry.php', $data);
		}
	}

	function getjobcard($jobcard_id = null)
	{
		$resultData = array();
		$jobcards = $this->m_purchase->getDatas('bud_jobcards', 'jobcard_id', $jobcard_id);
		foreach ($jobcards as $jobcard) {
			$jobcard_customer = $jobcard['jobcard_customer'];
			$jobcard_category = $jobcard['jobcard_category'];
			$jobcard_item = $jobcard['jobcard_item'];
			$jobcard_qty = $jobcard['jobcard_qty'];

			$items = $this->m_purchase->getDatas('bud_enquiry_items', 'enq_item_id', $jobcard_item);
			foreach ($items as $item) {
				$enq_item = $item['enq_item'];
				$enq_itemcolor = $item['enq_itemcolor'];
				$enq_process_qty = $item['enq_process_qty'];
				$item_name = $this->m_masters->getmasterIDvalue('bud_items', 'item_id', $enq_item, 'item_name');
				$item_name .= '/' . $this->m_masters->getmasterIDvalue('bud_shades', 'shade_id', $enq_itemcolor, 'shade_name');
			}
			$resultData[] = $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $jobcard_customer, 'cust_name');
			$resultData[] = $jobcard_customer;
			$resultData[] = $jobcard_item;
			$resultData[] = $item_name;
			$resultData[] = $jobcard_qty;
			$resultData[] = $jobcard_qty - $enq_process_qty;
		}
		$lots = $this->m_masters->getcategoryallmaster('bud_lots', 'category', $jobcard_category);
		$lotsdata = '';
		foreach ($lots as $lot) {
			$lot_id = $lot['lot_id'];
			$lot_prefix = $lot['lot_prefix'];
			$lot_no = $lot['lot_no'];
			$lotname = $this->m_masters->getmasterIDvalue('bud_machines', 'machine_id', $lot_prefix, 'machine_prefix') . $lot_no;
			$lotsdata .= '<option value="' . $lot_id . '">' . $lotname . '</option>';
		}
		$resultData[] = $lotsdata;
		echo implode(",", $resultData);
	}

	function getPOItems($po_order = null)
	{
		$po_category = '';
		$po_items = '';
		$P_orders = $this->m_purchase->getDatas('bud_po_store', 'store_po_id', $po_order);
		foreach ($P_orders as $order) {
			$po_category = $order['po_category'];
			$po_items = $order['po_items'];
		}
		$data['lots'] = $this->m_masters->getcategoryallmaster('bud_lots', 'category', $po_category);
		$data['POitems'] = $po_items;
		$this->load->view('v_PO_items.php', $data);
	}

	function saveprocess()
	{
		$po_category = $this->input->post('po_category');
		$po_date = $this->input->post('po_date');
		$job_card = $this->input->post('job_card');
		$po_customer = $this->input->post('po_customer');
		$po_item = $this->input->post('po_item');
		$po_qty = $this->input->post('po_qty');
		$lot_no = $this->input->post('lot_no');
		$qd = explode("-", $po_date);
		$po_date = $qd[2] . '-' . $qd[1] . '-' . $qd[0];

		$formData = array(
			'process_date' => $po_date,
			'process_jobcard' => $job_card,
			'process_category' => $po_category,
			'process_customer' => $po_customer,
			'process_item' => $po_item,
			'process_qty' => $po_qty,
			'process_lot' => $lot_no
		);

		$result = $this->m_purchase->saveDatas('bud_process_cards', $formData);
		if ($result) {
			$items = $this->m_purchase->getDatas('bud_enquiry_items', 'enq_item_id', $po_item);
			foreach ($items as $item) {
				$enq_process_qty = $item['enq_process_qty'];
			}
			$enq_process_qty += $po_qty;
			$updateData = array(
				'enq_process_qty' => $enq_process_qty
			);
			$this->m_purchase->updateDatas('bud_enquiry_items', 'enq_item_id', $po_item, $updateData);
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "production/processcard", 'refresh');
		}
	}
	function packingentry()
	{
		$data['activeTab'] = 'packing';
		$data['activeItem'] = 'packingentry';
		$data['page_title'] = 'Packing';
		$data['categories'] = $this->m_masters->getallcategories();
		$data['deliveries'] = $this->m_purchase->getActivetableDatas('bud_deliveries', 'delivery_status');
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
			$this->load->view('v_packingentry.php', $data);
		} else {
			$this->load->view('v_packingentry.php', $data);
		}
	}

	function getCustomerPO($customer_id = null)
	{
		$resultData = '';
		$customerPO = $this->m_purchase->getDatas('bud_process_cards', 'process_customer', $customer_id);
		$resultData .= '<option value="">Select Process Card</option>';
		foreach ($customerPO as $PO) {
			$process_id = $PO['process_id'];
			$resultData .= '<option value="' . $process_id . '">' . $process_id . '</option>';
		}
		echo $resultData;
	}
	function getPackingItems($process_id = null)
	{
		$resultData = array();
		$process_cards = $this->m_purchase->getDatas('bud_process_cards', 'process_id', $process_id);
		foreach ($process_cards as $process_card) {
			$process_item = $process_card['process_item'];
			$process_qty = $process_card['process_qty'];
			$process_lot = $process_card['process_lot'];
		}

		$items = $this->m_purchase->getDatas('bud_enquiry_items', 'enq_item_id', $process_item);
		$lotname = '';
		foreach ($items as $item) {
			$enq_item_id = $item['enq_item_id'];
			$enq_item = $item['enq_item'];
			$enq_itemcolor = $item['enq_itemcolor'];
			$enq_required_qty = $item['enq_required_qty'];

			$item_name = $this->m_masters->getmasterIDvalue('bud_items', 'item_id', $enq_item, 'item_name');
			$item_name .= '/' . $this->m_masters->getmasterIDvalue('bud_shades', 'shade_id', $enq_itemcolor, 'shade_name');
			$color_name = $this->m_masters->getmasterIDvalue('bud_shades', 'shade_id', $enq_itemcolor, 'shade_name');
			$enq_shade = $this->m_masters->getmasterIDvalue('bud_shades', 'shade_id', $enq_itemcolor, 'shade_code');

			$machine_id = $this->m_masters->getmasterIDvalue('bud_lots', 'lot_id', $process_lot, 'lot_prefix');
			$lotname .= $this->m_masters->getmasterIDvalue('bud_machines', 'machine_id', $machine_id, 'machine_prefix');
			$lotname .= $this->m_masters->getmasterIDvalue('bud_lots', 'lot_id', $process_lot, 'lot_no');

			$resultData[] = $enq_item;
			$resultData[] = $item_name;
			$resultData[] = $enq_itemcolor;
			$resultData[] = $color_name;
			$resultData[] = $enq_shade;
			$resultData[] = $process_lot;
			$resultData[] = $lotname;
			$resultData[] = $enq_required_qty;
			$resultData[] = $enq_item_id;
		}
		$resultData[] = $process_qty;
		echo implode(",", $resultData);
	}
	function savepacking()
	{
		$packing_date = $this->input->post('packing_date');
		$packing_category = $this->input->post('packing_category');
		$customer_id = $this->input->post('customer_id');
		$process_id = $this->input->post('process_id');
		$box_item = $this->input->post('box_item');
		$enq_item = $this->input->post('enq_item');
		$box_itemcolor = $this->input->post('box_itemcolor');
		$box_item_lot_no = $this->input->post('box_item_lot_no');
		$packing_process_qty = $this->input->post('packing_process_qty');
		$packing_box_type = $this->input->post('packing_box_type');
		$packing_box_weight = $this->input->post('packing_box_weight');
		$cones_type = $this->input->post('cones_type');
		$cones_count = $this->input->post('cones_count');
		$cones_weight = $this->input->post('cones_weight');
		$qd = explode("-", $packing_date);
		$packing_date = $qd[2] . '-' . $qd[1] . '-' . $qd[0];

		$box_tareweight = $packing_box_weight;
		foreach ($cones_count as $key => $value) {
			$box_tareweight += $value * $cones_weight[$key];
		}
		$box_grossweight = $packing_process_qty + $box_tareweight;
		$box_netweight = $box_grossweight - $box_tareweight;
		$packingData = array(
			'box_date' => $packing_date,
			'box_category' => $packing_category,
			'box_customer' => $customer_id,
			'box_processcard' => $process_id,
			'box_item' => $box_item,
			'box_enq_item' => $enq_item,
			'box_itemcolor' => $box_itemcolor,
			'box_item_lot_no' => $box_item_lot_no,
			'box_process_qty' => $packing_process_qty,
			'box_boxtype' => $packing_box_type,
			'box_boxweight' => $packing_box_weight,
			'box_conetypes' => implode(",", $cones_type),
			'box_nocones' => implode(",", $cones_count),
			'box_coneweights' => implode(",", $cones_weight),
			'box_grossweight' => $box_grossweight,
			'box_tareweight' => $box_tareweight,
			'box_netweight' => $box_netweight
		);
		$result = $this->m_purchase->saveDatas('bud_boxes', $packingData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "production/packingentry", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "production/packingentry", 'refresh');
		}
	}

	function packingreport()
	{
		$data['activeTab'] = 'packing';
		$data['activeItem'] = 'packingreport';
		$data['page_title'] = 'Packing Items';
		$data['boxes'] = $this->m_purchase->getActivetableDatas('bud_boxes', 'box_status');
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
		var_dump($data['boxes']);
		if ($this->uri->segment(3) === FALSE) {
			$this->load->view('v_packingitems.php', $data);
		} else {
			$data['category_id'] = $this->uri->segment(3);
			$this->load->view('v_packingitems.php', $data);
		}
	}
	function predelivery()
	{
		$data['activeTab'] = 'production';
		$data['activeItem'] = 'predelivery';
		$data['page_title'] = 'Pre Delivery';
		$data['boxes'] = $this->m_purchase->getActivetableDatas('bud_boxes', 'box_status');
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
			$this->load->view('v_predelivery.php', $data);
		} else {
			$this->load->view('v_predelivery.php', $data);
		}
	}
	function predelivery_save()
	{
		echo '<pre>';
		print_r($_POST);
		echo '</pre>';
	}

	function getCustomerBoxes($customer_id = null)
	{
		$data['boxes'] = $this->m_masters->getactiveCdatas('bud_boxes', 'box_status', 'box_customer', $customer_id);
		$this->load->view('v_predelivery_items.php', $data);
	}

	function savepredelivery()
	{
		$selected_boxes = $this->input->post('selected_boxes');
		$predelivery_date = $this->input->post('predelivery_date');
		$customer_id = $this->input->post('customer_id');
		$qd = explode("-", $predelivery_date);
		$predelivery_date = $qd[2] . '-' . $qd[1] . '-' . $qd[0];
		$formData = array(
			'predelivery_date' => $predelivery_date,
			'predelivery_customer' => $customer_id,
			'predelivery_boxes' => implode(",", $selected_boxes)
		);
		$result = $this->m_purchase->saveDatas('bud_predelivery', $formData);
		if ($result) {
			foreach ($selected_boxes as $box_id) {
				$updateData = array(
					'box_status' => 0
				);
				$this->m_purchase->updateDatas('bud_boxes', 'box_id', $box_id, $updateData);
			}
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "production/predelivery", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "production/predelivery", 'refresh');
		}
	}
	function delivery()
	{
		$data['activeTab'] = 'production';
		$data['activeItem'] = 'delivery';
		$data['page_title'] = 'Delivery';
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
			$this->load->view('v_delivery.php', $data);
		} else {
			$this->load->view('v_delivery.php', $data);
		}
	}

	function getdeliveryItems($customer_id = null)
	{
		$predelivery = $this->m_masters->getactiveCdatas('bud_predelivery', 'predelivery_status', 'predelivery_customer', $customer_id);
		$items = array();
		foreach ($predelivery as $value) {
			$arr_value = explode(",", $value['predelivery_boxes']);
			$items = array_merge($items, $arr_value);
		}
		$data['items'] = $items;
		$this->load->view('v_delivery_items.php', $data);
	}

	function savedelivery()
	{
		$selected_boxes = $this->input->post('selected_boxes');
		$delivery_date = $this->input->post('delivery_date');
		$customer_id = $this->input->post('customer_id');
		$qd = explode("-", $delivery_date);
		$delivery_date = $qd[2] . '-' . $qd[1] . '-' . $qd[0];
		$formData = array(
			'delivery_date' => $delivery_date,
			'delivery_customer' => $customer_id,
			'delivery_boxes' => implode(",", $selected_boxes)
		);
		$result = $this->m_purchase->saveDatas('bud_delivery', $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "production/delivery", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "production/delivery", 'refresh');
		}
	}

	// Start Tapes and Elastic	
	function joborder_custwise()
	{
		$item_id = $this->uri->segment(3);
		$data['activeTab'] = 'production';
		$data['activeItem'] = 'joborder_custwise';
		$data['page_title'] = 'Job Order Customer Wise';
		$data['p_orders'] = $this->m_production->P_order_custwise();

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
			$this->load->view('v_2_joborder_cust.php', $data);
		} else {
			$data['group_id'] = $this->uri->segment(3);
			$this->load->view('v_2_joborder_cust.php', $data);
		}
	}
	function joborder_itemwise()
	{
		$item_id = $this->uri->segment(3);
		$data['activeTab'] = 'production';
		$data['activeItem'] = 'joborder_itemwise';
		$data['page_title'] = 'Job Order Item Wise';
		$data['p_orders'] = $this->m_masters->getactivemaster('bud_te_purchaseorders', 'po_jobcard_status');

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
			$this->load->view('v_2_joborder_item.php', $data);
		} else {
			$data['group_id'] = $this->uri->segment(3);
			$this->load->view('v_2_joborder_item.php', $data);
		}
	}
	function get_machine_speed($machine_id = null)
	{
		$machines = $this->m_masters->getmasterdetails('bud_te_machines', 'machine_id', $machine_id);
		foreach ($machines as $machine) {
			$machine_speed = $machine['machine_speed'];
		}
		echo $machine_speed;
	}
	function get_color_combos($item_id = null)
	{
		$resultData = '<option value="">Select Combo</option>';
		$colorcombos = $this->m_masters->getmasterdetails('bud_te_color_combos', 'item_id', $item_id);
		$sno = 1;
		foreach ($colorcombos as $colorcombo) {
			$combo_id = $colorcombo['combo_id'];
			$resultData .= '<option value="' . $combo_id . '">' . $sno . '</option>';
			$sno++;
		}
		echo $resultData;
	}
	function combo_warping_data()
	{
		$combo_id = $this->uri->segment(3);
		$job_no_tapes = $this->uri->segment(4);
		$job_warping_qty = $this->uri->segment(5);
		$data['page_title'] = 'Color Combo - Warping Plan';
		$data['job_no_tapes'] = $job_no_tapes;
		$data['job_warping_qty'] = $job_warping_qty;
		$data['colorcombos'] = $this->m_masters->getmasterdetails('bud_te_color_combos', 'combo_id', $combo_id);
		$this->load->view('v_2_combo_warping_data.php', $data);
	}
	function jobsheet_warping()
	{
		$data['activeTab'] = 'production';
		$data['activeItem'] = 'jobsheet_warping';
		$data['page_title'] = 'Job Sheet - Warping';
		$data['machines'] = $this->m_masters->getactivemaster('bud_te_machines', 'machine_status');
		$data['staffs'] = $this->m_masters->getactivemaster('bud_users', 'user_status');
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
		if ($this->uri->segment(3) === FALSE) {
			$this->load->view('v_2_job_warping.php', $data);
		} else {
			$data['category_id'] = $this->uri->segment(3);
			$this->load->view('v_2_job_warping.php', $data);
		}
	}
	function jobsheet_warping_save()
	{
		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';*/
		$job_date = $this->input->post('job_date');
		$qd = explode("-", $job_date);
		$job_date = $qd[2] . '-' . $qd[1] . '-' . $qd[0];
		$job_machine = $this->input->post('job_machine');
		$job_artno = $this->input->post('job_artno');
		$job_item = $this->input->post('job_item');
		$job_qty = $this->input->post('job_qty');
		$job_warping_uom = $this->input->post('job_warping_uom');
		$job_no_tapes = $this->input->post('job_no_tapes');
		$job_item_width = $this->input->post('job_item_width');
		$job_po_ref = $this->input->post('job_po_ref');
		$job_design_code = $this->input->post('job_design_code');
		$beams_madeby = $this->input->post('beams_madeby');
		$job_shift = $this->input->post('job_shift');
		$job_time = $this->input->post('job_time');
		$combo_id = $this->input->post('combo_id');

		$formData = array(
			'job_date' => $job_date,
			'job_machine' => $job_machine,
			'job_artno' => $job_artno,
			'job_qty' => $job_qty,
			'job_qty_uom' => $job_warping_uom,
			'job_no_tapes' => $job_no_tapes,
			'job_item_width' => $job_item_width,
			'job_po_ref' => $job_po_ref,
			'job_design_code' => $job_design_code,
			'beams_madeby' => $beams_madeby,
			'job_time' => $job_time,
			'job_shift' => $job_shift,
			'job_combo_id' => $combo_id
		);
		$result = $this->m_purchase->saveDatas('bud_te_job_warping', $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "production/jobsheet_warping", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "production/jobsheet_warping", 'refresh');
		}
	}
	function jobsheet_ps()
	{
		$data['activeTab'] = 'production';
		$data['activeItem'] = 'jobsheet_ps';
		$data['page_title'] = 'Job Sheet - Warping';
		$data['jobcards'] = $this->m_masters->getactivemaster('bud_te_jabcards', 'jobcard_status');
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
		if ($this->uri->segment(3) === FALSE) {
			$this->load->view('v_2_job_ps.php', $data);
		} else {
			$data['category_id'] = $this->uri->segment(3);
			$this->load->view('v_2_job_ps.php', $data);
		}
	}
	function jobsheet_ps_view()
	{
		$data['activeTab'] = 'production';
		$data['activeItem'] = 'jobsheet_ps';
		$data['page_title'] = 'Job Sheet - Warping';
		$data['machines'] = $this->m_masters->getactivemaster('bud_te_machines', 'machine_status');
		$data['staffs'] = $this->m_masters->getactivemaster('bud_users', 'user_status');
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
		$data['jobcard_no'] = $this->uri->segment(3);
		$this->load->view('v_2_job_ps_view.php', $data);
	}
	function jobsheet_ps_save()
	{
		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';*/
		$job_machine = $this->input->post('job_machine');
		$job_date = $this->input->post('job_date');
		$qd = explode("-", $job_date);
		$job_date = $qd[2] . '-' . $qd[1] . '-' . $qd[0];
		$job_artno = $this->input->post('job_artno');
		$job_item = $this->input->post('job_item');
		$job_item_width = $this->input->post('job_item_width');
		$job_design_code = $this->input->post('job_design_code');
		$job_po_ref = $this->input->post('job_po_ref');
		$job_qty = $this->input->post('job_qty');
		$job_no_tapes = $this->input->post('job_no_tapes');
		$formData = array(
			'job_machine' => $job_machine,
			'job_date' => $job_date,
			'job_artno' => $job_artno,
			'job_qty' => $job_qty,
			'job_no_tapes' => $job_no_tapes,
			'job_item_width' => $job_item_width,
			'job_po_ref' => $job_po_ref,
			'job_design_code' => $job_design_code
		);
		$result = $this->m_purchase->saveDatas('bud_te_job_ps', $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "production/jobsheet_ps", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "production/jobsheet_ps", 'refresh');
		}
	}
	function create_jobcard_cust_2()
	{
		$enq_item_id = $this->uri->segment(3);
		$jobcard_po = $this->uri->segment(4);
		$items = $this->m_masters->getmasterdetails('bud_te_enq_items', 'enq_item_id', $enq_item_id);
		foreach ($items as $item) {
			$jobcard_item = $item['enq_item'];
			$jobcard_qty = $item['enq_req_qty'];
			$enq_item_uom = $item['enq_item_uom'];
		}
		$formData = array(
			'jobcard_date' => date("Y-m-d"),
			'jobcard_item' => $jobcard_item,
			'jobcard_po' => $jobcard_po,
			'jobcard_qty' => $jobcard_qty,
			'jobcard_item_uom' => $enq_item_uom
		);
		$result = $this->m_purchase->saveDatas('bud_te_jabcards', $formData);
		if ($result) {
			$updateData = array('jobcard_status' => 0);
			$this->m_purchase->updateDatas('bud_te_enq_items', 'enq_item_id', $enq_item_id, $updateData);
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "production/joborder_custwise", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "production/joborder_custwise", 'refresh');
		}
	}
	function jobcard_entry()
	{
		$item_id = $this->uri->segment(3);
		$data['activeTab'] = 'production';
		$data['activeItem'] = 'jobcard_entry';
		$data['page_title'] = 'Job Card Entry';
		$data['p_orders'] = $this->m_masters->getactivemaster('bud_te_purchaseorders', 'po_jobcard_status');

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
			$this->load->view('v_2_jobcard_entry.php', $data);
		} else {
			$data['group_id'] = $this->uri->segment(3);
			$this->load->view('v_2_jobcard_entry.php', $data);
		}
	}
	function jobcard_2_new()
	{
		$po_id = $this->uri->segment(3);
		$data['activeTab'] = 'production';
		$data['activeItem'] = 'jobcard_entry';
		$data['page_title'] = 'Job Card Entry';
		$data['p_orders'] = $this->m_purchase->getDatas('bud_te_purchaseorders', 'po_id', $po_id);
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
			$this->load->view('v_2_jobcard_new.php', $data);
		} else {
			$this->load->view('v_2_jobcard_new.php', $data);
		}
	}

	function jobcard_2_new_save()
	{
		$jobcard_po = $this->input->post('jobcard_po');
		$job_qty = $this->input->post('job_qty');
		$formData = array(
			'jobcard_date' => 'NOW()',
			'jobcard_po' => $jobcard_po,
			'jobcard_qty' => implode(",", $job_qty),
		);
		$result = $this->m_purchase->saveDatas('bud_te_jabcards', $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "production/jobcard_entry", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "production/jobcard_entry", 'refresh');
		}
	}
	function production_hrs_2()
	{
		$data['activeTab'] = 'production';
		$data['activeItem'] = 'production_hrs_2';
		$data['page_title'] = 'Production Entry - Hours Wise';
		$data['machines'] = $this->m_masters->getactivemaster('bud_te_machines', 'machine_status');
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
		if ($this->uri->segment(3) === FALSE) {
			$this->load->view('v_2_production_hrs.php', $data);
		} else {
			$data['category_id'] = $this->uri->segment(3);
			$this->load->view('v_2_production_hrs.php', $data);
		}
	}
	function production_hrs_2_save()
	{
		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';*/
		$machine_no = $this->input->post('machine_no');
		$operator_name = $this->input->post('operator_name');
		$nunning_hrs = $this->input->post('nunning_hrs');
		$formData = array(
			'p_entry_date' => date("Y-m-d"),
			'p_entry_machines' => implode(",", $machine_no),
			'p_entry_operators' => implode(",", $operator_name),
			'p_entry_nunning_hrs' => implode(",", $nunning_hrs)
		);
		$result = $this->m_purchase->saveDatas('bud_te_production_entry_hrs', $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "production/production_hrs_2", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "production/production_hrs_2", 'refresh');
		}
	}
	function production_e_item_2()
	{
		$data['activeTab'] = 'production';
		$data['activeItem'] = 'production_e_item_2';
		$data['page_title'] = 'Production Entry - Item Wise';
		$data['machines'] = $this->m_masters->getactivemaster('bud_te_machines', 'machine_status');
		$data['staffs'] = $this->m_masters->getactivemaster('bud_users', 'user_status');
		$data['items'] = $this->m_masters->getactivemaster('bud_te_items', 'item_status');
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
			$this->load->view('v_2_production_e_item.php', $data);
		} else {
			$data['category_id'] = $this->uri->segment(3);
			$this->load->view('v_2_production_e_item.php', $data);
		}
	}
	function production_e_item_2_save()
	{
		$entry_date = $this->input->post('entry_date');
		$ed = explode("-", $entry_date);
		$entry_date = $ed[2] . '-' . $ed[1] . '-' . $ed[0];
		$entry_shift = $this->input->post('entry_shift');
		$machine_no = $this->input->post('machine_no');
		$operator_name = $this->input->post('operator_name');
		$items = $this->input->post('items');
		$weight_box = $this->input->post('weight_box');
		$no_boxes = $this->input->post('no_boxes');
		$tare_weight = $this->input->post('tare_weight');
		$net_weight = $this->input->post('net_weight');
		$formData = array(
			'p_entry_date' => $entry_date,
			'p_entry_shift' => $entry_shift,
			'p_machines' => implode(",", $machine_no),
			'p_operators' => implode(",", $operator_name),
			'p_items' => implode(",", $items),
			'p_weight_box' => implode(",", $weight_box),
			'p_no_boxes' => implode(",", $no_boxes),
			'p_tare_weight' => implode(",", $tare_weight),
			'p_net_weight' => implode(",", $net_weight)
		);
		$result = $this->m_purchase->saveDatas('bud_te_productn_entry_item', $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "production/production_e_item_2", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "production/production_e_item_2", 'refresh');
		}
	}
	function production_r_item_2()
	{
		$data['activeTab'] = 'production';
		$data['activeItem'] = 'production_r_item_2';
		$data['page_title'] = 'Production Report Item Wise';
		$data['productions'] = $this->m_masters->getallmaster('bud_te_productn_entry_item');
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
		$this->load->view('v_production_r_item_2.php', $data);
	}
	function rollingentry()
	{
		$data['activeTab'] = 'production';
		$data['activeItem'] = 'rollingentry';
		$data['page_title'] = 'Rolling Entry';
		$data['staffs'] = $this->m_masters->getactivemaster('bud_users', 'user_status');
		$data['items'] = $this->m_masters->getactivemaster('bud_te_items', 'item_status');
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
			$this->load->view('v_2_rolling_entry.php', $data);
		} else {
			$data['category_id'] = $this->uri->segment(3);
			$this->load->view('v_2_rolling_entry.php', $data);
		}
	}
	function rollingentry_save()
	{
		$entry_date = $this->input->post('entry_date');
		$ed = explode("-", $entry_date);
		$entry_date = $ed[2] . '-' . $ed[1] . '-' . $ed[0];
		$entry_shift = $this->input->post('entry_shift');
		$operator_name = $this->input->post('operator_name');
		$items = $this->input->post('items');
		$no_rolls = $this->input->post('no_rolls');
		$meter_roll = $this->input->post('meter_roll');
		$formData = array(
			'roll_date' => $entry_date,
			'roll_shift' => $entry_shift,
			'roll_operators' => implode(",", $operator_name),
			'roll_items' => implode(",", $items),
			'no_of_rolls' => implode(",", $no_rolls),
			'meter_per_roll' => implode(",", $meter_roll)
		);
		$result = $this->m_purchase->saveDatas('bud_te_rolls', $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "production/rollingentry", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "production/rollingentry", 'refresh');
		}
	}
	function getpack_itemData($packing_item = null)
	{
		$resultData = array();
		$item_weight_mtr = 0;
		$item_sample = '';
		$items = $this->m_masters->getmasterdetails('bud_te_items', 'item_id', $packing_item);
		foreach ($items as $item) {
			$item_weight_mtr = $item['item_weight_mtr'];
			$item_sample = $item['item_sample'];
		}
		$resultData[] = $item_weight_mtr;
		$resultData[] = $item_sample;
		echo implode(",", $resultData);
	}
	function innerbox_packing()
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_te_innerboxes'");
		$next = $next->row(0);
		$data['new_box_no'] = $next->Auto_increment;

		if ($this->uri->segment(3) == TRUE) {
			$data['box_no'] = $this->uri->segment(3);
		}
		$data['activeTab'] = 'packing';
		$data['activeItem'] = 'innerbox_packing';
		$data['page_title'] = 'Inner Box Packing';
		$data['items'] = $this->m_masters->getallmaster('bud_te_items');
		$data['staffs'] = $this->m_masters->getactivemaster('bud_users', 'user_status');
		$data['tareweights'] = $this->m_masters->getactivemaster('bud_tareweights', 'tareweight_status');
		$data['stock_rooms'] = $this->m_masters->getactivemaster('bud_stock_rooms', 'stock_room_status');
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['innerboxes'] = $this->m_masters->getactivemaster_limit('bud_te_innerboxes', 'packing_outerbox', 20);
		$this->db->select('*');
		$this->db->from('bud_shades');
		$query = $this->db->get();
		$data['colors'] = $query->result_array();


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
			$this->load->view('v_2_innerbox_packing.php', $data);
		} else {
			// $data['group_id'] = $this->uri->segment(3);
			$this->load->view('v_2_innerbox_packing.php', $data);
		}
	}
	function innerbox_packing_pcs()
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_te_innerboxes'");
		$next = $next->row(0);
		$data['new_box_no'] = $next->Auto_increment;

		if ($this->uri->segment(3) == TRUE) {
			$data['box_no'] = $this->uri->segment(3);
		}
		$data['activeTab'] = 'packing';
		$data['activeItem'] = 'innerbox_packing_pcs';
		$data['page_title'] = 'Inner Box Packing';
		$data['items'] = $this->m_masters->getallmaster('bud_te_items');
		$data['staffs'] = $this->m_masters->getactivemaster('bud_users', 'user_status');
		$data['tareweights'] = $this->m_masters->getactivemaster('bud_tareweights', 'tareweight_status');
		$data['stock_rooms'] = $this->m_masters->getactivemaster('bud_stock_rooms', 'stock_room_status');
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['innerboxes'] = $this->m_masters->getactivemaster_limit('bud_te_innerboxes', 'packing_outerbox', 20);
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
			$this->load->view('v_2_innerbox_packing_pcs.php', $data);
		} else {
			// $data['group_id'] = $this->uri->segment(3);
			$this->load->view('v_2_innerbox_packing_pcs.php', $data);
		}
	}
	function innerbox_packing_save()
	{
		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';*/
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_te_innerboxes'");
		$next = $next->row(0);
		$next_box = $next->Auto_increment;

		$remark = $this->input->post('remark');

		$packing_type = $this->input->post('packing_type');
		$packing_date = $this->input->post('packing_date');
		$packing_cust = $this->input->post('packing_cust');
		$packing_item = $this->input->post('packing_item');
		$packing_rolls = $this->input->post('packing_rolls');
		$packing_wt_mtr = $this->input->post('packing_wt_mtr');
		$packing_wt_mtr_new = $this->input->post('packing_wt_mtr_new');
		$packing_tot_mtr = $this->input->post('packing_tot_mtr');
		$packing_gr_weight = $this->input->post('packing_gr_weight');
		$packing_box_weight = $this->input->post('packing_box_weight');
		$packing_no_boxes = $this->input->post('packing_no_boxes');
		$packing_bag_weight = $this->input->post('packing_bag_weight');
		$packing_no_bags = $this->input->post('packing_no_bags');
		$packing_othr_wt = $this->input->post('packing_othr_wt');
		$packing_net_weight = $this->input->post('packing_net_weight');
		$packing_by = $this->input->post('packing_by');
		$packing_stock_room = $this->input->post('packing_stock_room');
		$packing_stock_place = $this->input->post('packing_stock_place');

		$lot_no = $this->input->post('lot_no');
		$shade_id = $this->input->post('color_code');


		$ed = explode("-", $packing_date);
		$packing_date = $ed[2] . '-' . $ed[1] . '-' . $ed[0];
		$formData = array(
			'packing_date' => date("Y-m-d"),
			'packing_time' => date("h:i:s"),
			'packing_cust' => $packing_cust,
			'packing_item' => $packing_item,
			'packing_rolls' => $packing_rolls,
			'packing_wt_mtr' => $packing_wt_mtr,
			'packing_wt_mtr_new' => $packing_wt_mtr_new,
			'packing_tot_mtr' => round($packing_tot_mtr),
			'packing_gr_weight' => $packing_gr_weight,
			'packing_box_weight' => $packing_box_weight,
			'packing_no_boxes' => $packing_no_boxes,
			'packing_bag_weight' => $packing_bag_weight,
			'packing_no_bags' => $packing_no_bags,
			'packing_othr_wt' => $packing_othr_wt,
			'packing_net_weight' => $packing_net_weight,
			'packing_by' => $packing_by,
			'packing_stock_room' => $packing_stock_room,
			'packing_stock_place' => $packing_stock_place,
			'packing_type' => $packing_type,
			'lot_no' => $lot_no,
			'shade_id' => $shade_id,
			'remark' => $remark
		);
		$result = $this->m_purchase->saveDatas('bud_te_innerboxes', $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			if ($packing_type == 'rolls') {
				redirect(base_url() . "production/innerbox_packing/" . $next_box, 'refresh');
			}
			if ($packing_type == 'pcs') {
				redirect(base_url() . "production/innerbox_packing_pcs/" . $next_box, 'refresh');
			}
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			if ($packing_type == 'rolls') {
				redirect(base_url() . "production/innerbox_packing", 'refresh');
			}
			if ($packing_type == 'pcs') {
				redirect(base_url() . "production/innerbox_packing_pcs", 'refresh');
			}
		}
	}
	function print_i_packing_slip($box_no = null)
	{
		$data['box_no'] = $box_no;
		$data['js'] = array(
			'barcode/jquery-1.3.2.min.js',
			'barcode/jquery-barcode.js'
		);
		$this->load->view('v_2_print_i_packing_slip.php', $data);
	}
	function print_out_pack_slip($box_no = null)
	{
		$data['box_no'] = $box_no;
		$data['js'] = array(
			'barcode/jquery-1.3.2.min.js',
			'barcode/jquery-barcode.js'
		);
		$this->load->view('v_2_print_out_pack_slip.php', $data);
	}
	function getinnerboxes()
	{
		$data['packing_customer'] = null;
		$data['packing_item'] = null;
		if (isset($_POST['search'])) {
			if ($this->input->post('packing_customer') != '') {
				$data['packing_customer'] = $this->input->post('packing_customer');
			}
			if ($this->input->post('packing_item') != '') {
				$data['packing_item'] = $this->input->post('packing_item');
			}
		}
		$this->load->view('v_2_innerboxes_list.php', $data);
	}
	function outerbox_packing()
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_te_outerboxes'");
		$next = $next->row(0);
		$data['new_box_no'] = $next->Auto_increment;

		$data['activeTab'] = 'packing';
		$data['activeItem'] = 'outerbox_packing';
		$data['page_title'] = 'Outer Box Packing';
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['items'] = $this->m_masters->getallmaster('bud_te_items');
		$data['tareweights'] = $this->m_masters->getactivemaster('bud_tareweights', 'tareweight_status');
		$data['stock_rooms'] = $this->m_masters->getactivemaster('bud_stock_rooms', 'stock_room_status');
		$data['innerboxes'] = $this->m_masters->getactivemaster('bud_te_innerboxes', 'packing_outerbox');
		$data['outerboxes'] = $this->m_masters->getactivemaster('bud_te_outerboxes', 'delivery_status');
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
		if ($this->uri->segment(3) === FALSE) {
			$this->load->view('v_2_outerbox_packing.php', $data);
		} else {
			$data['group_id'] = $this->uri->segment(3);
			$this->load->view('v_2_outerbox_packing.php', $data);
		}
	}
	function delete_box_2()
	{
		/*echo "<pre>";
		print_r($_POST);
		echo "</pre>";*/
		$box_no = $this->input->post('box_no');
		$function_name = $this->input->post('function_name');
		$remarks = $this->input->post('remarks');

		$box_details = $this->m_masters->getmasterdetails('bud_te_outerboxes', 'box_no', $box_no);
		foreach ($box_details as $row) {
			$row['deleted_by'] = $this->session->userdata('user_id');
			$row['deleted_on'] = date("Y-m-d H:i:s");
		}
		$row['remarks'] = $remarks;
		$result = $this->m_masters->deletemaster('bud_te_outerboxes', 'box_no', $box_no);
		if ($result) {
			$this->m_purchase->saveDatas('bud_te_outerboxes_deleted', $row);
			$this->session->set_flashdata('success', 'Successfully Deleted!!!');
			redirect(base_url() . "production/" . $function_name, 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "production/" . $function_name, 'refresh');
		}
	}
	function delete_box_2_deleted($box_no = null)
	{
		$result = $this->m_masters->deletemaster('bud_te_outerboxes_deleted', 'box_no', $box_no);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Deleted!!!');
			redirect(base_url() . "reports/deletedBoxes", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "reports/deletedBoxes", 'refresh');
		}
	}
	function outerbox_packing_save()
	{
		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';*/

		$packing_date = $this->input->post('packing_date');
		$packing_customer = $this->input->post('packing_customer');
		$packing_item = $this->input->post('packing_item');
		$inner_boxes = $this->input->post('inner_boxes');

		$packing_box_weight = $this->input->post('packing_box_weight');
		$packing_no_boxes = $this->input->post('packing_no_boxes');
		$packing_bag_weight = $this->input->post('packing_bag_weight');
		$packing_no_bags = $this->input->post('packing_no_bags');
		$packing_othr_wt = $this->input->post('packing_othr_wt');
		$outerbox_tr_weight = ($packing_box_weight * $packing_no_boxes) + ($packing_bag_weight * $packing_no_bags) + $packing_othr_wt;
		$total_gr_weight = 0;
		$total_net_weight = 0;
		$total_rolls = 0;
		$total_meters = 0;
		$inner_tare_weight = 0;
		$total_tare_weight = 0;
		foreach ($inner_boxes as $inner_box) {
			$box_details = $this->m_masters->getmasterdetails('bud_te_innerboxes', 'box_no', $inner_box);
			foreach ($box_details as $row) {
				$total_rolls += $row['packing_rolls'];
				$total_meters += round($row['packing_tot_mtr']);
				$total_gr_weight += $row['packing_gr_weight'];
				$total_net_weight += $row['packing_net_weight'];
				$inner_tare_weight += $row['packing_gr_weight'] - $row['packing_net_weight'];
			}
		}
		$total_tare_weight += $inner_tare_weight;
		$total_tare_weight += $outerbox_tr_weight;
		$total_gr_weight += $outerbox_tr_weight;
		$packing_by = $this->input->post('packing_by');

		$ed = explode("-", $packing_date);
		$packing_date = $ed[2] . '-' . $ed[1] . '-' . $ed[0];
		$formData = array(
			'packing_date' => date("Y-m-d"),
			'packing_time' => date("h:i:s"),

			'packing_customer' => $packing_customer,
			'packing_innerboxes' => implode(",", $inner_boxes),
			'packing_innerbox_items' => $packing_item,
			'packing_gr_weight' => $total_gr_weight,
			'total_tare_weight' => $total_tare_weight,
			'packing_box_weight' => $packing_box_weight,
			'packing_no_boxes' => $packing_no_boxes,
			'packing_bag_weight' => $packing_bag_weight,
			'packing_no_bags' => $packing_no_bags,
			'packing_othr_wt' => $packing_othr_wt,
			'packing_net_weight' => $total_net_weight,
			'total_rolls' => $total_rolls,
			'total_meters' => round($total_meters),
			'packing_by' => $packing_by
		);
		$result = $this->m_purchase->saveDatas('bud_te_outerboxes', $formData);
		if ($result) {
			$updateData = array(
				'packing_outerbox' => 0
			);
			foreach ($inner_boxes as $innerbox) {
				$this->m_purchase->updateDatas('bud_te_innerboxes', 'box_no', $innerbox, $updateData);
			}
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "production/outerbox_packing", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "production/outerbox_packing", 'refresh');
		}
	}
	function edit_outerbox_packing()
	{
		if ($this->uri->segment(3) == TRUE) {
			$data['box_no'] = $this->uri->segment(3);
			$box_no = $this->uri->segment(3);
		} else {
			redirect(base_url() . "my404/404");
		}
		$data['activeTab'] = 'packing';
		$data['activeItem'] = 'outerbox_packing';
		$data['page_title'] = 'Outer Box Packing';
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['outerboxes'] = $this->m_masters->getmasterdetails('bud_te_outerboxes', 'box_no', $box_no);
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
		$this->load->view('v_2_edit_outerbox_packing.php', $data);
	}
	function outer_packing_update()
	{
		$box_no = $this->input->post('box_no');
		$packing_date = $this->input->post('packing_date');
		$packing_customer = $this->input->post('packing_customer');
		$inner_boxes = $this->input->post('inner_boxes');

		$packing_box_weight = $this->input->post('packing_box_weight');
		$packing_no_boxes = $this->input->post('packing_no_boxes');
		$packing_bag_weight = $this->input->post('packing_bag_weight');
		$packing_no_bags = $this->input->post('packing_no_bags');
		$packing_othr_wt = $this->input->post('packing_othr_wt');
		$outerbox_tr_weight = ($packing_box_weight * $packing_no_boxes) + ($packing_bag_weight * $packing_no_bags) + $packing_othr_wt;
		$total_gr_weight = 0;
		$total_net_weight = 0;
		$total_rolls = 0;
		$total_meters = 0;
		$inner_tare_weight = 0;
		$total_tare_weight = 0;
		foreach ($inner_boxes as $inner_box) {
			$box_details = $this->m_masters->getmasterdetails('bud_te_innerboxes', 'box_no', $inner_box);
			foreach ($box_details as $row) {
				$total_rolls += $row['packing_rolls'];
				$total_meters += round($row['packing_tot_mtr']);
				$total_gr_weight += $row['packing_gr_weight'];
				$total_net_weight += $row['packing_net_weight'];
				$inner_tare_weight += $row['packing_gr_weight'] - $row['packing_net_weight'];
			}
		}
		$total_tare_weight += $inner_tare_weight;
		$total_tare_weight += $outerbox_tr_weight;
		$total_gr_weight += $outerbox_tr_weight;

		$outerboxes = $this->m_masters->getmasterdetails('bud_te_outerboxes', 'box_no', $box_no);
		$removed_boxes = array();
		foreach ($outerboxes as $outerbox) {
			$packing_innerboxes = explode(",", $outerbox['packing_innerboxes']);
		}
		foreach ($packing_innerboxes as $key => $value) {
			if (!in_array($value, $inner_boxes)) {
				$removed_boxes[] = $value;
			}
		}
		$ed = explode("-", $packing_date);
		$packing_date = $ed[2] . '-' . $ed[1] . '-' . $ed[0];
		$formData = array(
			'packing_date' => $packing_date,
			'packing_customer' => $packing_customer,
			'packing_gr_weight' => $total_gr_weight,
			'total_tare_weight' => $total_tare_weight,
			'packing_box_weight' => $packing_box_weight,
			'packing_no_boxes' => $packing_no_boxes,
			'packing_bag_weight' => $packing_bag_weight,
			'packing_no_bags' => $packing_no_bags,
			'packing_othr_wt' => $packing_othr_wt,
			'packing_net_weight' => $total_net_weight,
			'total_rolls' => $total_rolls,
			'total_meters' => $total_meters,
			'packing_innerboxes' => implode(",", $inner_boxes)
		);
		$result = $this->m_masters->updatemaster('bud_te_outerboxes', 'box_no', $box_no, $formData);
		if ($result) {
			$updateData = array(
				'packing_outerbox' => 1
			);
			foreach ($removed_boxes as $innerbox) {
				$this->m_purchase->updateDatas('bud_te_innerboxes', 'box_no', $innerbox, $updateData);
			}
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "production/outerbox_packing", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "production/outerbox_packing", 'refresh');
		}
	}
	function outerbox_pack_without_ib()
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_te_outerboxes'");
		$next = $next->row(0);
		$data['new_box_no'] = $next->Auto_increment;

		if ($this->uri->segment(3) == TRUE) {
			$data['box_no'] = $this->uri->segment(3);
		}

		$data['activeTab'] = 'packing';
		$data['activeItem'] = 'outerbox_pack_without_ib';
		$data['page_title'] = 'Out box packing without innerbox';
		$data['items'] = $this->m_masters->getallmaster('bud_te_items');
		$data['staffs'] = $this->m_masters->getactivemaster('bud_users', 'user_status');
		$data['tareweights'] = $this->m_masters->getactivemaster('bud_tareweights', 'tareweight_status');
		$data['stock_rooms'] = $this->m_masters->getactivemaster('bud_stock_rooms', 'stock_room_status');
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['outerboxes'] = $this->m_masters->getactivemaster('bud_te_outerboxes', 'delivery_status');
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
		$this->load->view('v_2_outerbox_pack_without_ib.php', $data);
	}
	function outerbox_pack_without_ib_save()

	{

		$packing_date = $this->input->post('packing_date');
		$packing_cust = $this->input->post('packing_cust');
		$packing_item = $this->input->post('packing_item');
		$packing_rolls = $this->input->post('packing_rolls');
		$packing_wt_mtr = $this->input->post('packing_wt_mtr');
		$packing_wt_mtr_new = $this->input->post('packing_wt_mtr_new');
		$packing_tot_mtr = $this->input->post('packing_tot_mtr');
		$packing_gr_weight = $this->input->post('packing_gr_weight');
		$packing_box_weight = $this->input->post('packing_box_weight');
		$packing_no_boxes = $this->input->post('packing_no_boxes');
		$packing_bag_weight = $this->input->post('packing_bag_weight');
		$packing_no_bags = $this->input->post('packing_no_bags');
		$packing_othr_wt = $this->input->post('packing_othr_wt');
		$packing_net_weight = $this->input->post('packing_net_weight');
		$packing_by = $this->input->post('packing_by');
		$packing_stock_room = $this->input->post('packing_stock_room');
		$packing_stock_place = $this->input->post('packing_stock_place');
		$ed = explode("-", $packing_date);
		$packing_date = $ed[2] . '-' . $ed[1] . '-' . $ed[0];
		$formData = array(
			'packing_date' => date("Y-m-d"),
			'packing_time' => date("h:i:s"),
			'packing_customer' => $packing_cust,
			'remark' => $this->input->post('remark'),
			'packing_innerbox_items' => $packing_item,
			'total_rolls' => $packing_rolls,
			'total_meters' => round($packing_tot_mtr),
			'packing_gr_weight' => $packing_gr_weight,
			'total_tare_weight' => $packing_gr_weight - $packing_net_weight,
			'packing_box_weight' => $packing_box_weight,
			'packing_no_boxes' => $packing_no_boxes,
			'packing_bag_weight' => $packing_bag_weight,
			'packing_no_bags' => $packing_no_bags,
			'packing_othr_wt' => $packing_othr_wt,
			'packing_net_weight' => $packing_net_weight,
			'packing_wt_mtr' => $packing_wt_mtr,
			'packing_wt_mtr_new' => $packing_wt_mtr_new,
			'packing_by' => $packing_by,
			'packing_stock_room' => $packing_stock_room,
			'packing_stock_place' => $packing_stock_place
		);
		$result = $this->m_purchase->saveDatas('bud_te_outerboxes', $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "production/outerbox_pack_without_ib/" . $result, 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "production/outerbox_pack_without_ib", 'refresh');
		}
	}
	function outerbox_pack_kgs()
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_te_outerboxes'");
		$next = $next->row(0);
		$data['new_box_no'] = $next->Auto_increment;

		if ($this->uri->segment(3) == TRUE) {
			$data['box_no'] = $this->uri->segment(3);
		}

		$data['activeTab'] = 'packing';
		$data['activeItem'] = 'outerbox_pack_kgs';
		$data['page_title'] = 'Out box packing in kgs';
		$data['items'] = $this->m_masters->getallmaster('bud_te_items');
		$data['staffs'] = $this->m_masters->getactivemaster('bud_users', 'user_status');
		$data['tareweights'] = $this->m_masters->getactivemaster('bud_tareweights', 'tareweight_status');
		$data['stock_rooms'] = $this->m_masters->getactivemaster('bud_stock_rooms', 'stock_room_status');
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['outerboxes'] = $this->m_masters->getactivemaster('bud_te_outerboxes', 'delivery_status');
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
		$this->load->view('v_2_outerbox_pack_kgs.php', $data);
	}
	function outerbox_pack_kgs_save()
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_te_outerboxes'");
		$next = $next->row(0);
		$next_box = $next->Auto_increment;

		$packing_date = $this->input->post('packing_date');
		$packing_cust = $this->input->post('packing_cust');
		$packing_item = $this->input->post('packing_item');
		$packing_rolls = $this->input->post('packing_rolls');
		$packing_wt_mtr = $this->input->post('packing_wt_mtr');
		$packing_wt_mtr_new = $this->input->post('packing_wt_mtr_new');
		$packing_tot_mtr = $this->input->post('packing_tot_mtr');
		$packing_gr_weight = $this->input->post('packing_gr_weight');
		$packing_box_weight = $this->input->post('packing_box_weight');
		$packing_no_boxes = $this->input->post('packing_no_boxes');
		$packing_bag_weight = $this->input->post('packing_bag_weight');
		$packing_no_bags = $this->input->post('packing_no_bags');
		$packing_othr_wt = $this->input->post('packing_othr_wt');
		$packing_net_weight = $this->input->post('packing_net_weight');
		$packing_by = $this->input->post('packing_by');
		$packing_stock_room = $this->input->post('packing_stock_room');
		$packing_stock_place = $this->input->post('packing_stock_place');
		$ed = explode("-", $packing_date);
		$packing_date = $ed[2] . '-' . $ed[1] . '-' . $ed[0];
		$formData = array(
			'packing_date' => date("Y-m-d"),
			'packing_time' => date("h:i:s"),
			'packing_customer' => $packing_cust,
			'packing_innerbox_items' => $packing_item,
			'total_rolls' => $packing_rolls,
			'total_meters' => round($packing_tot_mtr),
			'packing_gr_weight' => $packing_gr_weight,
			'total_tare_weight' => $packing_gr_weight - $packing_net_weight,
			'packing_box_weight' => $packing_box_weight,
			'packing_no_boxes' => $packing_no_boxes,
			'packing_bag_weight' => $packing_bag_weight,
			'packing_no_bags' => $packing_no_bags,
			'packing_othr_wt' => $packing_othr_wt,
			'packing_net_weight' => $packing_net_weight,
			'packing_wt_mtr' => $packing_wt_mtr,
			'packing_wt_mtr_new' => $packing_wt_mtr_new,
			'packing_by' => $packing_by,
			'packing_stock_room' => $packing_stock_room,
			'packing_type' => 'kgs',
			'packing_stock_place' => $packing_stock_place
		);
		$result = $this->m_purchase->saveDatas('bud_te_outerboxes', $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "production/outerbox_pack_kgs/" . $result, 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "production/outerbox_pack_kgs", 'refresh');
		}
	}
	function predelivery_2()
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_te_predelivery'");
		$next = $next->row(0);
		$data['next_p_del_id'] = $next->Auto_increment;

		$data['party_name'] = null;
		$data['item_name'] = null;
		$data['search_date'] = null;
		$data['from_date'] = '03-04-2017';
		$data['to_date'] = date("d-m-Y");

		$filter = array();
		/*if(isset($_POST['search']))
		{
			$from_date = $this->input->post('from_date');
			$to_date = $this->input->post('to_date');
			$fd = explode("-", $from_date);
			$from_date = $fd[2].'-'.$fd[1].'-'.$fd[0];
			$td = explode("-", $to_date);
			$to_date = $td[2].'-'.$td[1].'-'.$td[0];
			$data['from_date'] = $from_date;
			$data['to_date'] = $to_date;
			$data['party_name'] = $this->input->post('party_name');
			$data['item_name'] = $this->input->post('item_name');
			$data['search_date'] = $this->input->post('search_date');
		}*/

		if ($this->input->post('from_date')) {
			$filter['from_date'] = $this->input->post('from_date');
			$data['from_date'] = $this->input->post('from_date');
		}
		if ($this->input->post('to_date')) {
			$filter['to_date'] = $this->input->post('to_date');
			$data['to_date'] = $this->input->post('to_date');
		}

		if ($this->input->post('party_name')) {
			$filter['packing_customer'] = $this->input->post('party_name');
			$data['party_name'] = $this->input->post('party_name');
		}

		if ($this->input->post('item_name')) {
			$filter['packing_item'] = $this->input->post('item_name');
			$data['item_name'] = $this->input->post('item_name');
		}

		$data['outerboxes'] = $this->m_production->get_te_packing_boxes($filter);

		$data['activeTab'] = 'production';
		$data['activeItem'] = 'predelivery_2';
		$data['page_title'] = 'Pre Delivery';
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['items'] = $this->m_masters->getallmaster('bud_te_items');
		$data['concerns'] = $this->m_masters->getmasterdetailsconcernactive('bud_concern_master', 'module', $this->session->userdata('user_viewed'));
		$data['pre_deliveries'] = $this->m_masters->getactivemaster('bud_te_predelivery', 'p_delivery_status');

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
		$this->load->view('v_2_predelivery.php', $data);
	}
	function selectedboxes()
	{
		$this->load->view('v_2_outerboxes_list.php');
	}
	function predelivery_2_add()
	{
		$checkeditems = explode(",", $this->input->post('checkeditems'));
		foreach ($checkeditems as $key => $value) {
			$if_exist = $this->m_masters->check_exist('bud_cart_items', 'item_id', $value);
			$data = array(
				'user_id'      => $this->session->userdata('user_id'),
				'item_id'     => $value
			);
			if (!$if_exist) {
				$this->m_mycart->insertCart($data);
			}
		}
		// echo count($checkeditems);
	}
	function predelivery_2_remove($row_id = null)
	{
		$this->m_mycart->deleteCartItem($row_id);
	}
	/*function predelivery_2_add()
	{
		$checkeditems = explode(",", $this->input->post('checkeditems'));
		foreach ($checkeditems as $key => $value) {
			$data = array(
				   'id'      => $value,
				   'qty'     => 1,
				   'price'   => 1,
				   'name'    => $value,
				   'options' => array()
				);

			$this->cart->insert($data);			
		}
	}*/
	/*function predelivery_2_remove($row_id = null)
	{
		$updatecart = array(
		   'rowid' => $row_id,
		   'qty'   => 0
		);
		$this->cart->update($updatecart);
	}*/
	function predelivery_2_save()
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_te_predelivery'");
		$next = $next->row(0);
		$next_p_del = $next->Auto_increment;

		$p_delivery_boxes = $this->input->post('p_delivery_boxes');
		$p_delivery_cust = $this->input->post('p_delivery_cust');
		$concern_name = $this->input->post('concern_name');
		//$delivery_qties=$this->input->post('p_del_qty');//ER-08-18#-36//ER-08-18#-60

		if (isset($_POST['save_as_predel'])) {
			//deletion of predelivery tapes	
			$formData = array(
				'concern_name' => $concern_name,
				'p_delivery_cust' => $p_delivery_cust,
				'p_delivery_date' => date("Y-m-d"),
				'p_delivery_boxes' => implode(",", $p_delivery_boxes),
				'p_delivery_lt_edtd_by' => $this->session->userdata('user_id'),
				'p_delivery_lt_edtd_time' => date('Y-m-d H:i:s')
			);
			//end of deletion of predelivery tapes	
			$result = $this->m_purchase->saveDatas('bud_te_predelivery', $formData);
			$p_delivery_id = $result;
			if ($result) {
				foreach ($p_delivery_boxes as $key => $box_id) {
					$item_details = $this->m_masters->getmasterdetails('bud_te_outerboxes', 'box_no', $box_id);
					foreach ($item_details as $item_detail) {
						$formData = array(
							'p_delivery_id' => $p_delivery_id,
							'box_id' => $box_id,
							'item_id'      => $item_detail['packing_innerbox_items'],
							'delivery_qty_meters' => ($item_detail['packing_net_weight']) ? '' : $item_detail['total_meters'], //ER-08-18#-36//ER-08-18#-60
							'delivery_qty_kgs' => ($item_detail['packing_net_weight']) ? $item_detail['packing_net_weight'] : '', //ER-08-18#-36//ER-08-18#-60
							'is_deleted' => 1
						);
					}
					$result = $this->m_purchase->saveDatas('bud_te_predelivery_items', $formData);
				}
				$result = $this->m_mycart->deleteCart($this->session->userdata('user_id'));
				//ER-08-18#-36//ER-08-18#-60
				$updateData = array(
					'predelivery_status' => 0
				);
				foreach ($p_delivery_boxes as $delivery_box) {
					$result = $this->m_purchase->updateDatas('bud_te_outerboxes', 'box_no', $delivery_box, $updateData);
				}
				if ($result) {
					$this->session->set_flashdata('success', 'Successfully Saved!!!');
					redirect(base_url() . "production/predelivery_2_print/" . $next_p_del, 'refresh');
				} else {
					$this->session->set_flashdata('error', 'That action is not valid, please try again');
					redirect(base_url() . "production/predelivery_2", 'refresh');
				}
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "production/predelivery_2", 'refresh');
			}
		} elseif (isset($_POST['save_as_del'])) {
			$dc_count = $this->m_masters->getmasterdetails('bud_te_delivery', 'concern_name', $concern_name);
			$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_te_delivery'");
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
				'is_deleted' => 1,
				'last_edited_id' => $this->session->userdata('user_id'),
				'last_edited_time' => date('Y-m-d H:i:s')
			);
			$result = $this->m_purchase->saveDatas('bud_te_delivery', $formData);
			$delivery_id = $result;
			if ($result) {
				$result = $this->m_mycart->deleteCart($this->session->userdata('user_id'));
				//deletion of predelivery tapes	
				$predelData = array(
					'p_delivery_date' => date("Y-m-d"),
					'p_delivery_cust' => $p_delivery_cust,
					'p_delivery_boxes' => implode(",", $p_delivery_boxes),
					'p_delivery_lt_edtd_by' => $this->session->userdata('user_id'),
					'p_delivery_lt_edtd_time' => date('Y-m-d H:i:s')
				);
				//end of deletion of predelivery tapes	
				$result = $this->m_purchase->saveDatas('bud_te_predelivery', $predelData);
				$p_delivery_id = $result;
				//predelivery items tapes
				foreach ($p_delivery_boxes as $key => $box_id) {
					$item_details = $this->m_masters->getmasterdetails('bud_te_outerboxes', 'box_no', $box_id);
					foreach ($item_details as $item_detail) {

						$formData = array(
							'p_delivery_id' => $p_delivery_id,
							'delivery_id'   => $delivery_id,
							'box_id' 		=> $box_id,
							'item_id'      	=> $item_detail['packing_innerbox_items'],
							'delivery_qty_meters' => ($item_detail['packing_net_weight']) ? '' : $item_detail['total_meters'], //ER-08-18#-36//ER-08-18#-60
							'delivery_qty_kgs' => ($item_detail['packing_net_weight']) ? $item_detail['packing_net_weight'] : '', //ER-08-18#-36 //ER-08-18#-60
							'is_deleted'	=> 1
						);
						$result = $this->m_purchase->saveDatas('bud_te_predelivery_items', $formData);
					}
				}
				//ER-08-18#-36//ER-08-18#-60
				$updateData = array(
					'predelivery_status' => 0,
					'delivery_status' => 0
				);
				$update_p_del = array(
					'p_delivery_status' => 0
				);
				//ER-08-18#-36//ER-08-18#-60
				foreach ($p_delivery_boxes as $delivery_box) {
					$result = $this->m_purchase->updateDatas('bud_te_outerboxes', 'box_no', $delivery_box, $updateData);
				}
				$result = $this->m_purchase->updateDatas('bud_te_predelivery', 'p_delivery_id', $next_p_del, $update_p_del);
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "production/delivery_2_print/" . $dc_no, 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "production/delivery_2", 'refresh');
			}
		} else {
			redirect(base_url());
		}
	}
	function predelivery_2_list()
	{
		$this->load->model('m_delivery');
		$data['activeTab'] = 'production';
		$data['activeItem'] = 'predelivery_2_list';
		$data['page_title'] = 'Pre Deliveries';
		$data['pre_deliveries'] = $this->m_masters->get_tapes_predc(); //deletion of predelivery Tapes
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
		$this->load->view('v_2_predelivery_list.php', $data);
	}
	function predelivery_2_edit()
	{

		$data['party_name'] = null;
		$data['item_name'] = null;
		$data['search_date'] = null;

		if (isset($_POST['search'])) {
			$data['party_name'] = $this->input->post('party_name');
			$data['item_name'] = $this->input->post('item_name');
			$data['search_date'] = $this->input->post('search_date');
		}
		$data['activeTab'] = 'production';
		$data['activeItem'] = 'predelivery_2';
		$data['page_title'] = 'Pre Delivery';
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['items'] = $this->m_masters->getallmaster('bud_te_items');
		$data['pre_deliveries'] = $this->m_masters->getactivemaster('bud_te_predelivery', 'p_delivery_status');

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
		if ($this->uri->segment(3) == TRUE) {
			$data['p_delivery_id'] = $this->uri->segment(3);
			$p_delivery_id = $this->uri->segment(3);
			$data['delivery_details'] = $this->m_masters->getmasterdetails('bud_te_predelivery', 'p_delivery_id', $p_delivery_id);
		} else {
			redirect(base_url() . "my404/404");
		}
		$this->load->view('v_2_edit_predelivery.php', $data);
	}
	//deletion of predelivery Tapes
	function predelivery_2_delete()
	{
		$p_delivery_id = $this->input->post("p_delivery_id");
		$remarks = $this->input->post("remarks");
		if ($p_delivery_id) {
			$result = $this->m_masters->update_delete_status_predelivery($p_delivery_id, $remarks);
		}
		echo ($result) ? $p_delivery_id . ' Successfully Deleted' : 'Error in Deletion';
	}
	//end of deletion of predelivery Tapes
	//deletion of delivery Tapes
	function delivery_2_delete()
	{
		$delivery_id = $this->input->post("delivery_id");
		$remarks = $this->input->post("remarks");
		if ($delivery_id) {
			$dc_no = $this->m_masters->getmasterIDvalue('bud_te_delivery', 'delivery_id', $delivery_id, 'dc_no');
			$update_data = array(
				'is_deleted' => '0',
				'last_edited_id' => $this->session->userdata('user_id'),
				'last_edited_time' => date('Y-m-d H:i:s'),
				'remarks' => $remarks
			);
			$result = $this->m_masters->updatemaster('bud_te_delivery', 'delivery_id', $delivery_id, $update_data);
			$update_data = array('delivery_id' => '0');
			$result = $this->m_masters->updatemaster('bud_te_predelivery_items', 'delivery_id', $delivery_id, $update_data);
			$delivery_boxes = $this->m_masters->getmasterIDvalue('bud_te_delivery', 'delivery_id', $delivery_id, 'delivery_boxes');
			$boxes_array = explode(',', $delivery_boxes);
			foreach ($boxes_array as $key => $value) {
				$data = array(
					'delivery_status' => '1'
				);
				$result = $this->m_masters->updatemaster('bud_te_outerboxes', 'box_no', $value, $data);
			}
			if ($result) {
				$p_delivery_id = $this->m_masters->getmasterIDvalue('bud_te_delivery', 'delivery_id', $delivery_id, 'p_delivery_ref');
				$update_data = array('p_delivery_status' => '1');
				$result = $this->m_masters->updatemaster('bud_te_predelivery', 'p_delivery_id', $p_delivery_id, $update_data);
			}
		}
		echo ($result) ? $dc_no . ' Successfully Deleted' : 'Error in Deletion';
	}
	//end of deletion of delivery Tapes
	function predelivery_2_update()
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
			$predelivery = $this->m_masters->getmasterdetails('bud_te_predelivery', 'p_delivery_id', $p_delivery_id);
			$removed_boxes = array();
			foreach ($predelivery as $row) {
				$old_packing_boxes = explode(",", $row['p_delivery_boxes']);
			}
			foreach ($old_packing_boxes as $key => $value) {
				if (!in_array($value, $new_delivery_boxes)) {
					$removed_boxes[] = $value;
				}
			}
			//deletion of predelivery tapes	
			$formData = array(
				'p_delivery_cust' => $p_delivery_cust,
				'p_delivery_boxes' => implode(",", $new_delivery_boxes),
				'p_delivery_lt_edtd_by' => $this->session->userdata('user_id'),
				'p_delivery_lt_edtd_time' => date('Y-m-d H:i:s')
			);
			//End of //deletion of predelivery tapes
			$result = $this->m_masters->updatemaster('bud_te_predelivery', 'p_delivery_id', $p_delivery_id, $formData);
			if ($result) {
				$this->cart->destroy();
				$remove_pre_del = array(
					'predelivery_status' => 0,
				);
				foreach ($new_delivery_boxes as $key => $value) {
					$this->m_purchase->updateDatas('bud_te_outerboxes', 'box_no', $value, $remove_pre_del);
					$old_box_array = explode(',', $old_packing_boxes);
					$is_exist = TRUE;
					foreach ($old_box_array as $old_box_id) {
						if ($old_box_id == $value) {
							$is_exist = FALSE;
						}
					}
					if ($is_exist) {
						$item_details = $this->m_masters->getmasterdetails('bud_te_outerboxes', 'box_no', $value);
						foreach ($item_details as $item_detail) {
							$formData = array(
								'p_delivery_id' => $p_delivery_id,
								'box_id' => $value,
								'item_id'      => $item_detail['packing_innerbox_items'],
								'delivery_qty_meters' => $item_detail['total_meters'],
								'delivery_qty_kgs' => $item_detail['packing_net_weight'],
								'is_deleted' => 1
							);
							$result = $this->m_purchase->saveDatas('bud_te_predelivery_items', $formData);
						}
					}
				}
				foreach ($removed_boxes as $outerbox) {
					$updateData = array(
						'predelivery_status' => 1
					);
					$this->m_purchase->updateDatas('bud_te_outerboxes', 'box_no', $outerbox, $updateData);
					$this->m_masters->deletemaster('bud_te_predelivery_items', 'box_id', $outerbox);
				}
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "production/predelivery_2_list", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "production/predelivery_2_list", 'refresh');
			}
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "production/predelivery_2_list", 'refresh');
		}
	}
	function predelivery_2_print()
	{

		$data['activeTab'] = 'production';
		$data['activeItem'] = 'predelivery_2';
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
			'assets/data-tables/jquery.dataTables.min.js',
			'assets/data-tables/DT_bootstrap.js'
		);
		$data['js_common'] = array('js/common-scripts.js');
		$data['js_thispage'] = array('js/form-validation-script.js', 'js/form-component.js', 'js/dynamic-table.js');
		if ($this->uri->segment(3) == TRUE) {
			$data['p_delivery_id'] = $this->uri->segment(3);
			$p_delivery_id = $this->uri->segment(3);
			$data['delivery_details'] = $this->m_masters->getmasterdetails('bud_te_predelivery', 'p_delivery_id', $p_delivery_id);
		} else {
			redirect(base_url() . "my404/404");
		}
		$this->load->view('v_2_predelivery_print.php', $data);
	}
	function delivery_2()
	{
		if ($this->uri->segment(3) == TRUE) {
			$data['p_delivery_id'] = $this->uri->segment(3);
			$p_delivery_id = $this->uri->segment(3);
			$data['delivery_details'] = $this->m_masters->getmasterdetails('bud_te_predelivery', 'p_delivery_id', $p_delivery_id);
		}
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_te_delivery'");
		$next = $next->row(0);
		$data['next_delivery'] = $next->Auto_increment;

		$data['activeTab'] = 'production';
		$data['activeItem'] = 'delivery_2';
		$data['page_title'] = 'Delivery';
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['items'] = $this->m_masters->getallmaster('bud_te_items');
		$data['outerboxes'] = $this->m_masters->getactivemaster('bud_te_outerboxes', 'delivery_status');
		$data['pre_deliveries'] = $this->m_masters->get_tapes_predc(); //deletion of predelivery tapes

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
		$this->load->view('v_2_delivery.php', $data);
	}
	function delivery_2_save()
	{

		$pre_delivery = $this->input->post('pre_delivery');
		$delivery_date = $this->input->post('delivery_date');
		$delivery_customer = $this->input->post('delivery_customer');
		$concern_name = $this->input->post('concern_name');
		$delivery_boxes = $this->input->post('delivery_boxes');
		$ed = explode("-", $delivery_date);
		$delivery_date = $ed[2] . '-' . $ed[1] . '-' . $ed[0];

		$dc_count = $this->m_masters->getmasterdetails('bud_te_delivery', 'concern_name', $concern_name);
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_te_delivery'");
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
			'is_deleted' => 1,
			'last_edited_id' => $this->session->userdata('user_id'),
			'last_edited_time' => date('Y-m-d H:i:s')
		);
		$result = $this->m_purchase->saveDatas('bud_te_delivery', $formData);
		if ($result) {
			//predelivery items tapes
			$updateData = array(
				'delivery_id'   => $result
			);
			$this->m_purchase->updateDatas('bud_te_predelivery_items', 'p_delivery_id', $pre_delivery, $updateData);
			//ER-08-18#-36
			$updateData = array(
				'delivery_status' => 0
			);
			$update_p_del = array(
				'p_delivery_status' => 0
			);
			//ER-08-18#-36
			foreach ($delivery_boxes as $delivery_box) {
				$this->m_purchase->updateDatas('bud_te_outerboxes', 'box_no', $delivery_box, $updateData);
			}
			$this->m_purchase->updateDatas('bud_te_predelivery', 'p_delivery_id', $pre_delivery, $update_p_del);
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "production/delivery_2_print/" . $dc_no, 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "production/delivery_2", 'refresh');
		}
	}
	function delivery_2_print()
	{

		$data['activeTab'] = 'production';
		$data['activeItem'] = 'delivery_2';
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
			'assets/data-tables/jquery.dataTables.min.js',
			'assets/data-tables/DT_bootstrap.js'
		);
		$data['js_common'] = array('js/common-scripts.js');
		$data['js_thispage'] = array('js/form-validation-script.js', 'js/form-component.js', 'js/dynamic-table.js');
		if ($this->uri->segment(3) == TRUE) {
			$data['delivery_id'] = $this->uri->segment(3);
			$delivery_id = $this->uri->segment(3);
			$data['delivery_details'] = $this->m_masters->getmasterdetails('bud_te_delivery', 'delivery_id', $delivery_id);
		} else {
			redirect(base_url() . "my404/404");
		}
		$this->load->view('v_2_delivery_print.php', $data);
	}
	function print_item_sticker_2()
	{

		$data['uoms'] = $this->m_masters->getactivemaster('bud_uoms', 'uom_status');
		$data['activeTab'] = 'packing';
		$data['activeItem'] = 'print_item_sticker_2';
		$data['page_title'] = 'Print Item Sticker';
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
		$this->load->view('v_2_item_sticker.php', $data);
	}
	function item_sticker_2_view()
	{
		$with_barcode = null;
		$item_name = $this->input->post('item_name');
		$no_qty = $this->input->post('no_qty');
		$no_rolls = $this->input->post('no_rolls');
		$item_qty = $this->input->post('item_qty');
		$item_uom = $this->input->post('item_uom');
		$with_barcode = $this->input->post('with_barcode');
		$data['no_rolls'] = $no_rolls;
		$data['item_qty'] = $item_qty;
		$data['item_uom'] = $item_uom;
		$data['item_name'] = $item_name;
		$data['no_qty'] = $no_qty;
		$data['with_barcode'] = $with_barcode;
		$data['js'] = array(
			'barcode/jquery-1.3.2.min.js',
			'barcode/jquery-barcode.js'
		);
		$this->load->view('v_2_item_sticker_view.php', $data);
	}
	function outerBoxQtyWise_2()
	{

		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_te_outerboxes'");
		$next = $next->row(0);
		$data['new_box_no'] = $next->Auto_increment;
		$data['outerboxes'] = $this->m_mir->getstock_outerbox_qtywise(); //only stock in outer boxes QTywise undertable
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status'); //inclusion of party name in outerbox qty wise
		$data['activeTab'] = 'packing';
		$data['activeItem'] = 'outerBoxQtyWise_2';
		$data['stock_rooms'] = $this->m_masters->getactivemaster('bud_stock_rooms', 'stock_room_status');
		$data['page_title'] = 'Outer Box - Qty Wise';
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
			$data['previous_box'] = $this->uri->segment(3);
		} else {
			$data['previous_box'] = null;
		}
		$this->load->view('v_2_outer-box-qtywise.php', $data);
	}
	function saveOuterBoxQty_2()
	{
		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';*/
		$item_name = $this->input->post('item_name');
		$packing_customer = $this->input->post('packing_customer'); //inclusion of party name in outerbox qtywise
		$no_rolls = $this->input->post('no_rolls');
		$qty_per_roll = $this->input->post('qty_per_roll');
		$item_uom = $this->input->post('item_uom');
		$total_qty = $this->input->post('total_qty');
		$gross_weight = $this->input->post('gross_weight');
		$packing_by = $this->input->post('packing_by');
		$dyed_lot_no = $this->input->post('dyed_lot_no');
		$packing_stock_room = $this->input->post('packing_stock_room');
		$packing_stock_place = $this->input->post('packing_stock_place');
		$remark = $this->input->post('remark');
		$formData = array(
			'packing_date' => date("Y-m-d"),
			'packing_time' => date("H:i:s"),
			'packing_innerbox_items' => $item_name,
			'packing_customer' => $packing_customer, //inclusion of party name in outerbox qtywise
			'packing_gr_weight' => $gross_weight,
			'total_rolls' => $no_rolls,
			'qty_per_roll' => $qty_per_roll,
			'total_meters' => round($total_qty),
			'item_uom' => $item_uom,
			'packing_by' => $packing_by,
			'dyed_lot_no' => $dyed_lot_no,
			'packing_type' => 'qtywise',
			'packing_stock_room' => $packing_stock_room,
			'packing_stock_place' => $packing_stock_place,
			'remark' => $remark
		);
		$box_no = $this->m_purchase->saveDatas('bud_te_outerboxes', $formData);
		if ($box_no) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "production/outerBoxQtyWise_2/" . $box_no, 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "production/outerBoxQtyWise_2", 'refresh');
		}
	}
	function print_box_sticker_2()
	{

		$data['activeTab'] = 'packing';
		$data['activeItem'] = 'print_box_sticker_2';
		$data['page_title'] = 'Print Box Sticker';
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
		$this->load->view('v_2_box_sticker.php', $data);
	}
	function view_box_sticker_2()
	{
		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';*/
		$box_type = $this->input->post('box_type');
		$boxes = $this->input->post('boxes');
		$data['boxes'] = $boxes;
		$data['js'] = array(
			'barcode/jquery-1.3.2.min.js',
			'barcode/jquery-barcode.js'
		);
		if ($box_type == 'bud_te_innerboxes') {
			$this->load->view('v_2_print_i_box_slips.php', $data);
		} else {
			$this->load->view('v_2_print_out_box_slips.php', $data);
		}
	}
	function print_ps_3()
	{
		if ($this->uri->segment(3)) {
			$data['po_no'] = $this->uri->segment(3);
			$formData = array('po_status' => 0);
			$this->m_purchase->updateDatas('bud_lbl_po_received', 'po_no', $this->uri->segment(3), $formData);
		} else {
			redirect(base_url());
		}
		$data['activeTab'] = 'purchase';
		$data['activeItem'] = 'po_received_3';
		$data['page_title'] = 'Print Production Sheet';
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
		$data['css_print'] = array('css/invoice-print.css');
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
			$this->load->view('labels/v_3_print-ps', $data);
			$data['po_no'] = null;
		} else {
			$data['po_no'] = $this->uri->segment(3);
			$this->load->view('labels/v_3_print-ps', $data);
		}
	}
	function prod_entry_operator_3() //ER-09-18#-53
	{
		$data['staffs'] = $this->m_masters->getactivemaster('bud_users', 'user_status');
		$data['operators'] = $this->m_masters->getactivemaster('dyn_operators', 'is_deleted'); //ER-09-18#-62
		$data['items'] = $this->m_masters->getactivemaster('bud_lbl_items', 'item_status');
		$data['machines'] = $this->m_masters->getactivemaster('bud_te_machines', 'machine_status');
		if ($this->uri->segment(3)) {
			$data['duplicate_id'] = $this->uri->segment(3);
		} else {
			$data['duplicate_id'] = null;
		}
		$data['activeTab'] = 'production';
		$data['activeItem'] = 'prod_entry_operator_3';
		$data['page_title'] = 'Production Entry - Operator Wise';
		$data['formselect'] = 'tapezip';
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
		$data['css_print'] = array('css/invoice-print.css');
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
		$this->load->view('labels/v_3-prod_entry_operator', $data);
	}
	function get_repeats($machine_id = null, $item_id = null, $p_date = null, $shift = null) //ER-09-18#-53//ER-09-18#-54
	{
		$data['machine_repeats'] = array();
		$data['item_sizes'] = array();
		$data['machine_repeats'] = $this->m_masters->getmasterIDvalue('bud_te_machines', 'machine_id', $machine_id, 'machine_no_tapes'); //ER-09-18#-54
		$data['item_sizes'] = explode(',', $this->m_masters->getmasterIDvalue('bud_lbl_items', 'item_id', $item_id, 'item_sizes')); //ER-09-18#-54
		$data['latest_data'] = $this->m_production->op_latest_data($machine_id, $p_date, $shift); //ER-09-18#-54
		$data['machine_data'] = $this->m_production->op_latest_data($machine_id); //ER-09-18#-56
		$data['max_mac_cl_time'] = ($data['machine_data']) ? $data['machine_data'][0]['mac_cl_time'] : 0; //ER-09-18#-56
		$data['item_id'] = $item_id; //ER-09-18#-54
		$this->load->view('labels/v_3_prod_entry_size_table', $data);
	}
	function save_operator_entry() //ER-09-18#-53
	{
		$prod_date = $this->input->post('prod_date'); //ER-09-18#-53
		$operator_id = $this->input->post('operator_id');
		$item_id = $this->input->post('item_id');
		$no_repts = $this->input->post('no_repts');
		$shift = $this->input->post('shift');
		$sample = $this->input->post('sample'); //ER-09-18#-53
		$machine_id = $this->input->post('machine_id'); //ER-09-18#-53
		$op_time = $this->input->post('op_time'); //ER-09-18#-53
		$cl_time = $this->input->post('cl_time'); //ER-09-18#-53
		$pdtn = $this->input->post('pdtn'); //ER-09-18#-62
		$no_repts_size = array();
		foreach ($no_repts as $key => $value) {
			if (($op_time[$key] >= $cl_time[$key]) || ($no_repts[$key] == 0)) {
				$error = '';
				if ($no_repts[$key] == 0) {
					$error .= "'0' repeats not allowed";
				}
				if ($op_time[$key] == $cl_time[$key]) {
					$error .= ' Meter Open & Closing Reading should not be same';
				}
				if ($op_time[$key] > $cl_time[$key]) {
					$error .= ' Meter Closing Reading should be Greater than openning reason';
				}
				$this->session->set_flashdata('error', $error);
				redirect(base_url() . "production/prod_entry_operator_3", 'refresh');
			}
		}
		$formData = array(
			'operator_id' => $operator_id,
			'item_id' => $item_id,
			'prod_date' => $prod_date, //ER-09-18#-53
			'shift' => $shift,
			'machine_id' => $machine_id, //ER-09-18#-53
			'sample' => $sample, //ER-09-18#-53
			'entered_id' => $this->session->userdata('user_id'), //ER-09-18#-53
			'entered_date' => date('Y-m-d H:i:s'), //ER-09-18#-53
			'is_deleted' => 1 //ER-09-18#-53
		);
		// print_r($formData);
		$result = $this->m_purchase->saveDatas('bud_lbl_prod_entry_operator', $formData);
		if ($result) {
			//ER-09-18#-53
			if (isset($_POST['save'])) {
				$next = '';
			} elseif (isset($_POST['save_continue'])) {
				$next = '/' . $result;
			}
			$size_result = 1;
			foreach ($no_repts as $key => $value) {
				if ($size_result) {
					$no_repts_size[$key] = $key;
					$form_size = array(
						'item_size' => $key,
						'no_repts' => $value,
						'mac_op_time' => $op_time[$key],
						'mac_cl_time' => $cl_time[$key],
						'tot_phy_pdtn' => $pdtn[$key], //ER-09-18#-62
						'id' => $result,
						'is_deleted' => 1
					);
					$size_result = $this->m_purchase->saveDatas('dyn_lbl_prod_size_entry', $form_size);
				}
			}
			//ER-09-18#-53
			if ($size_result) {
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "production/prod_entry_operator_3" . $next, 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "production/prod_entry_operator_3", 'refresh');
			}
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "production/prod_entry_operator_3", 'refresh');
		}
	}
	function prod_entry_operator_reg_3() //ER-09-18#-53
	{
		$data['staffs'] = $this->m_masters->getactivemaster('bud_users', 'user_status');
		$data['operators'] = $this->m_masters->getactivemaster('dyn_operators', 'is_deleted'); //ER-09-18#-62
		$data['items'] = $this->m_masters->getactivemaster('bud_lbl_items', 'item_status');
		$data['machines'] = $this->m_masters->getactivemaster('bud_te_machines', 'machine_status');
		$data['sample'] = '';
		$data['from_date'] = date("Y-m-d", strtotime("-1 month"));
		$data['to_date'] = date("Y-m-d");
		$data['operator_id'] = '';
		$data['machine_id'] = '';
		$data['item_id'] = '';
		$data['shift'] = '';
		if (isset($_POST['search'])) {
			$data['operator_id'] = $this->input->post('operator_id');
			$data['machine_id'] = $this->input->post('machine_id');
			$data['sample'] = $this->input->post('sample');
			$data['shift'] = $this->input->post('shift');
			$data['item_id'] = $this->input->post('item_id');
			$data['from_date'] = $this->input->post('from_date');
			$data['to_date'] = $this->input->post('to_date');
		}
		$data['today_production'] = $this->m_production->TodayProdOperatorwise('', '', $data['operator_id'], $data['machine_id'], $data['item_id'], $data['sample'], $data['shift']);
		$data['activeTab'] = 'production';
		$data['activeItem'] = 'prod_entry_operator_reg_3';
		$data['page_title'] = 'DATE WISE TAPE PRODUCTION REGISTER';
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
		$data['css_print'] = array('css/invoice-print.css');
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
		$this->load->view('labels/v_3-prod_entry_operator_reg', $data);
	}
	function prod_entry_3_delete() //ER-09-18#-53
	{
		$id = $this->input->post("id");
		$remarks = $this->input->post("remarks");
		if ($id) {
			$update_data = array(
				'is_deleted' => '0',
				'deleted_by' => $this->session->userdata('user_id'),
				'deleted_time' => date('Y-m-d H:i:s'),
				'deleted_remarks' => $remarks
			);
			$result = $this->m_masters->updatemaster('bud_lbl_prod_entry_operator', 'id', $id, $update_data);
			if ($result) {
				$update_data = array('is_deleted' => '0');
				$result = $this->m_masters->updatemaster('dyn_lbl_prod_size_entry', 'id', $id, $update_data);
			}
		}
		echo ($result) ? $id . ' Successfully Deleted' : 'Error in Deletion';
	}
	function roll_entry_3()
	{
		$data['staffs'] = $this->m_masters->getactivemaster('bud_users', 'user_status');
		$data['items'] = $this->m_masters->getactivemaster('bud_lbl_items', 'item_status');
		$data['machines'] = $this->m_masters->getactivemaster('bud_te_machines', 'machine_status');
		$data['today_rolls'] = $this->m_production->TodayRollEntry();
		if ($this->uri->segment(3)) {
			$data['view_item_id'] = $this->uri->segment(3);
		} else {
			$data['view_item_id'] = null;
		}
		if ($this->uri->segment(4)) {
			$data['duplicate_id'] = $this->uri->segment(4);
		} else {
			$data['duplicate_id'] = null;
		}
		$data['activeTab'] = 'production';
		$data['activeItem'] = 'roll_entry_3';
		$data['page_title'] = 'Roll Entry';
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
		$data['css_print'] = array('css/invoice-print.css');
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
		$this->load->view('labels/v_3-roll-entry', $data);
	}
	function save_roll_entry_3()
	{
		/*echo "<pre>";
		print_r($_POST);
		echo "</pre>";*/
		$date = date("Y-m-d");
		$item_id = $this->input->post('item_id');
		$operator_id = $this->input->post('operator_id');
		$machine_no = $this->input->post('machine_no');
		$shift = $this->input->post('shift');
		$no_labels_tape = $this->input->post('no_labels_tape');
		$no_tape = $this->input->post('no_tape');
		$label_sizes = array();
		foreach ($no_labels_tape as $key => $value) {
			if ($value == '') {
				unset($no_labels_tape[$key]);
			}
		}
		foreach ($no_tape as $key => $value) {
			if ($value == '') {
				unset($no_tape[$key]);
			}
		}
		foreach ($no_labels_tape as $key => $value) {
			$label_sizes[$key] = $key;
		}
		$production_closed = array();
		foreach ($label_sizes as $key => $value) {
			$production_closed[] = 1;
		}
		$formData = array(
			'date' => $date,
			'item_id' => $item_id,
			'operator_id' => $operator_id,
			'machine_no' => $machine_no,
			'shift' => $shift,
			'no_labels_tape' => implode(",", $no_labels_tape),
			'no_tape' => implode(",", $no_tape),
			'label_sizes' => implode(",", $label_sizes),
			'production_closed' => implode(",", $production_closed)
		);
		$result = $this->m_purchase->saveDatas('bud_lbl_rollentry', $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "production/roll_entry_3", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "production/roll_entry_3", 'refresh');
		}
	}
	function packing_entry_3()
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_lbl_outerboxes'");
		$next = $next->row(0);
		$data['new_box_no'] = $next->Auto_increment;

		$data['staffs'] = $this->m_masters->getactivemaster('bud_users', 'user_status');
		$data['items'] = $this->m_masters->getactivemaster('bud_lbl_items', 'item_status');
		$data['machines'] = $this->m_masters->getactivemaster('bud_te_machines', 'machine_status');
		$data['uoms'] = $this->m_masters->getactivemaster('bud_uoms', 'uom_status');
		$data['stock_rooms'] = $this->m_masters->getactivemaster('bud_stock_rooms', 'stock_room_status');
		$data['outerboxes'] = $this->m_production->labelOuterboxes();
		if ($this->uri->segment(3)) {
			$data['view_item_id'] = $this->uri->segment(3);
		} else {
			$data['view_item_id'] = null;
		}
		if ($this->uri->segment(4)) {
			$data['duplicate_id'] = $this->uri->segment(4);
		} else {
			$data['duplicate_id'] = null;
		}
		$data['activeTab'] = 'production';
		$data['activeItem'] = 'packing_entry_3';
		$data['page_title'] = 'Packing Entry';
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
		$data['css_print'] = array('css/invoice-print.css');
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
		$this->load->view('labels/v_3-packing-entry', $data);
	}

	/* legrand charles (change delete status in label outer boxes) */
	function delete_entry_3()
	{
		$box_no = $this->input->post("box_no");
		$remarks = $this->input->post("remarks");
		if ($box_no) {
			$result = $this->m_masters->update_delete_status_label($box_no, $remarks);
		}
		echo ($result) ? $box_no . ' Successfully Deleted' : 'Error in Deletion';
	}

	function rollback_entry_3($item_id, $box_no)
	{
		$status = '0';
		$result = $this->m_masters->update_delete_status_label($item_id, $box_no, $status);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Roll backed!!!');
			redirect(base_url() . "production/packing_entry_3", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "production/packing_entry_3", 'refresh');
		}
	}
	/* End legrand charles (change delete status in label outer boxes) */


	function save_packing_entry_3()
	{
		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';*/
		$date = date("Y-m-d H:i:s");
		$item_id = $this->input->post('item_id');
		$operator_id = $this->input->post('operator_id');
		$packing_uom = $this->input->post('packing_uom');
		// $packing_gr_weight = $this->input->post('packing_gr_weight');
		$packing_contact = $this->input->post('packing_contact');
		$packed_roll_qty = $this->input->post('packed_roll_qty');
		$packed_no_rolls = $this->input->post('packed_no_rolls');
		$total_qty_damaged = $this->input->post('total_qty_damaged');
		$packing_stock_room = $this->input->post('packing_stock_room');
		$packing_stock_place = $this->input->post('packing_stock_place');
		$remark = $this->input->post('remark');

		if (isset($_POST['production_closed'])) {
			$production_closed = $this->input->post('production_closed');
			foreach ($production_closed as $key => $value) {
				$this->m_production->labelProductionClose($key);
			}
		}
		$formData = array(
			'item_id' => $item_id,
			'operator_id' => $operator_id,
			'date_time' => $date,
			'packing_uom' => $packing_uom,
			// 'packing_gr_weight' => $packing_gr_weight, 
			'packing_contact' => $packing_contact,
			'packing_stock_room' => $packing_stock_room,
			'packing_stock_place' => $packing_stock_place,
			'remark' => $remark
		);
		$box_no = $this->m_purchase->saveDatas('bud_lbl_outerboxes', $formData);
		if ($box_no) {
			foreach ($packed_roll_qty as $size => $sizes) {
				foreach ($sizes as $key => $value) {
					if ($value > 0) {
						$boxItem = array(
							'box_no' => $box_no,
							'item_id' => $item_id,
							'item_size' => $size,
							'packed_roll_qty' => $value,
							'packed_no_rolls' => $packed_no_rolls[$size][$key],
							'total_qty_damaged' => $total_qty_damaged[$size][$key],
							// 'total_qty' => ($value * $packed_no_rolls[$size][$key]) + $total_qty_damaged[$size][$key]
							'total_qty' => ($value * $packed_no_rolls[$size][$key])
						);
						$this->m_purchase->saveDatas('bud_lbl_outerbox_items', $boxItem);
					}
				}
			}
		}
		$this->session->set_flashdata('success', 'Successfully Saved!!!');
		redirect(base_url() . "production/packing_entry_3", 'refresh');
	}
	function final_packing_entry_3()
	{
		$data['boxes'] = $this->m_masters->getallmaster('bud_lbl_outerboxes');
		if (isset($_POST['search'])) {
			$from_date = $this->input->post('from_date');
			$to_date = $this->input->post('to_date');
			$fd = explode("-", $from_date);
			$from_date = $fd[2] . '-' . $fd[1] . '-' . $fd[0];
			$td = explode("-", $to_date);
			$to_date = $td[2] . '-' . $td[1] . '-' . $td[0];
			$data['outerboxes'] = $this->m_production->labelOuterboxesDatewise($from_date, $to_date);
		} else {
			$data['outerboxes'] = $this->m_production->labelOuterboxes();
		}
		$data['activeTab'] = 'production';
		$data['activeItem'] = 'final_packing_entry_3';
		$data['page_title'] = 'Packing Entry';
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
		$data['css_print'] = array('css/invoice-print.css');
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
			$data['selected_box'] = $this->uri->segment(3);
		} else {
			$data['selected_box'] = null;
		}
		$this->load->view('labels/v_3-final-packing-entry', $data);
	}
	function update_final_packing_3()
	{
		/*echo "<pre>";
		print_r($_POST);
		echo "</pre>";*/
		$box_no = $this->input->post('box_no');
		$packing_gr_weight = $this->input->post('packing_gr_weight');
		$formData = array('packing_gr_weight' => $packing_gr_weight);
		$result = $this->m_purchase->updateDatas('bud_lbl_outerboxes', 'box_no', $box_no, $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "production/final_packing_entry_3", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "production/final_packing_entry_3", 'refresh');
		}
	}
	function delete_box_3()
	{
		$box_no = $this->uri->segment(3);
		$formData = array(
			'is_deleted' => 1,
			'deleted_by' => $this->session->userdata('user_id'),
			'deleted_time' => date("Y-m-d H:i:s")
		);
		$result = $this->m_purchase->updateDatas('bud_lbl_outerboxes', 'box_no', $box_no, $formData);

		// $result = $this->m_masters->deletemaster('bud_lbl_outerboxes', 'box_no', $box_no);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Deleted!!!');
			redirect(base_url() . "production/final_packing_entry_3", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "production/final_packing_entry_3", 'refresh');
		}
	}
	function print_out_pack_slip_3($box_no = null)
	{
		$data['box_no'] = $box_no;
		$data['js'] = array(
			'barcode/jquery-1.3.2.min.js',
			'barcode/jquery-barcode.js'
		);
		$this->load->view('labels/v_3_print_out_pack_slip', $data);
	}
	function print_delivery_pack_slip_3($delivery_id = null, $box_no = null)
	{
		$data['box_no'] = $box_no;
		$data['delivery_id'] = $delivery_id;
		$data['js'] = array(
			'barcode/jquery-1.3.2.min.js',
			'barcode/jquery-barcode.js'
		);
		$this->load->view('labels/v_3_print_delivery_pack_slip', $data);
	}
	function print_final_pack_slip_3($box_no = null)
	{
		$data['box_no'] = $box_no;
		$data['js'] = array(
			'barcode/jquery-1.3.2.min.js',
			'barcode/jquery-barcode.js'
		);
		$this->load->view('labels/v_3_print_final_pack_slip', $data);
	}
	function predelivery_3()
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_lbl_predelivery'");
		$next = $next->row(0);
		$data['next_p_del_id'] = $next->Auto_increment;

		// $data['party_name'] = null;
		$data['item_name'] = null;
		$data['search_date'] = null;
		$data['from_date'] = null;
		$data['to_date'] = null;
		if (isset($_POST['search'])) {
			$from_date = $this->input->post('from_date');
			$to_date = $this->input->post('to_date');
			//$fd = explode("-", $from_date);
			//$from_date = $fd[2].'-'.$fd[1].'-'.$fd[0];
			//$td = explode("-", $to_date);
			//$to_date = $td[2].'-'.$td[1].'-'.$td[0];
			$data['from_date'] = $from_date;
			$data['to_date'] = $to_date;
			$data['item_name'] = $this->input->post('item_name');
			$data['search_date'] = $this->input->post('search_date');
		}
		$data['activeTab'] = 'production';
		$data['activeItem'] = 'predelivery_3';
		$data['page_title'] = 'Pre Delivery';
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['items'] = $this->m_masters->getallmaster('bud_lbl_items');
		$data['concerns'] = $this->m_masters->getmasterdetailsconcernactive('bud_concern_master', 'module', $this->session->userdata('user_viewed'));
		$data['pre_deliveries'] = $this->m_masters->getactivemaster('bud_te_predelivery', 'p_delivery_status');

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
		$this->load->view('labels/v_3_predelivery', $data);
	}
	function selectedboxes_labels()
	{
		$this->load->view('labels/v_3_outerboxes_list');
	}
	function predelivery_3_add()
	{
		$checkeditems = explode(",", $this->input->post('checkeditems'));
		foreach ($checkeditems as $key => $value) {
			$if_exist = $this->m_masters->check_exist('bud_lbl_cart_items', 'item_id', $value);
			$data = array(
				'user_id'      => $this->session->userdata('user_id'),
				'item_id'     => $value
			);
			if (!$if_exist) {
				$this->m_mycart->insertCartLbl($data);
			}
		}
	}
	function predelivery_3_remove($row_id = null)
	{
		$this->m_mycart->deleteCartItemLbl($row_id);
	}
	function predelivery_3_removeAll()
	{
		$this->m_mycart->truncateTable('bud_lbl_cart_items');
	}
	function predelivery_3_save()
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_lbl_predelivery'");
		$next = $next->row(0);
		$next_p_del = $next->Auto_increment;

		$p_delivery_boxes = $this->input->post('p_delivery_boxes');
		$p_delivery_cust = $this->input->post('p_delivery_cust');
		$concern_name = $this->input->post('concern_name');

		$p_delivery_qty = $this->input->post('p_delivery_qty');
		$p_delivery_item = $this->input->post('item_size');
		if (isset($_POST['save_as_predel'])) {
			//deletion of predelivery label
			$formData = array(
				'concern_name' => $concern_name,
				'p_delivery_cust' => $p_delivery_cust,
				'p_delivery_date' => date("Y-m-d"),
				'p_delivery_boxes' => implode(",", $p_delivery_boxes),
				'p_delivery_lt_edtd_by' => $this->session->userdata('user_id'),
				'p_delivery_lt_edtd_time' => date('Y-m-d H:i:s')
			);
			//end of deletion of predelivery label
			$result = $this->m_purchase->saveDatas('bud_lbl_predelivery', $formData);
			//partial qty delivery
			foreach ($p_delivery_item as $key => $value) {
				$items = explode(',', $value);
				$formData = array(
					'box_id' => $items[0],
					'item_id' => $items[1],
					'item_size' => $items[2],
					'delivery_qty' => $p_delivery_qty[$key],
					'p_delivery_id' => $result,
					'p_delivery_is_deleted' => 1
				);
				$insert_items = $this->m_purchase->saveDatas('bud_lbl_predelivery_items', $formData);
			}
			//end of partial qty delivery
			if ($result) {
				$this->m_mycart->deleteCartLbl($this->session->userdata('user_id'));
				$updateData = array(
					'predelivery_status' => 0
				);
				foreach ($p_delivery_boxes as $delivery_box) {
					$this->m_purchase->updateDatas('bud_lbl_outerboxes', 'box_no', $delivery_box, $updateData);
				}
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "production/predelivery_3_print/" . $next_p_del, 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "production/predelivery_3", 'refresh');
			}
		} elseif (isset($_POST['save_as_del'])) {
			$dc_count = $this->m_masters->getmasterdetails('bud_lbl_delivery', 'concern_name', $concern_name);
			$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_lbl_delivery'");
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
				'delivery_boxes' => implode(",", $p_delivery_boxes)
			);
			$delivery_id = $this->m_purchase->saveDatas('bud_lbl_delivery', $formData);
			if ($delivery_id) {
				$this->m_mycart->deleteCartLbl($this->session->userdata('user_id'));
				//deletion of predelivery label
				$predelData = array(
					'p_delivery_date' => date("Y-m-d"),
					'p_delivery_cust' => $p_delivery_cust,
					'p_delivery_boxes' => implode(",", $p_delivery_boxes),
					'p_delivery_lt_edtd_by' => $this->session->userdata('user_id'),
					'p_delivery_lt_edtd_time' => date('Y-m-d H:i:s')
				);
				//deletion of predelivery label
				$p_delivery_id = $this->m_purchase->saveDatas('bud_lbl_predelivery', $predelData);
				//partial qty delivery
				foreach ($p_delivery_item as $key => $value) {
					$items = explode(',', $value);
					$formData = array(
						'box_id' => $items[0],
						'item_id' => $items[1],
						'item_size' => $items[2],
						'delivery_qty' => $p_delivery_qty[$key],
						'p_delivery_id' => $p_delivery_id
					);
					$insert_items = $this->m_purchase->saveDatas('bud_lbl_predelivery_items', $formData);
				}
				//end of partial qty delivery	
				$updateData = array(
					'delivery_status' => 0
				);
				$update_p_del = array(
					'p_delivery_status' => 0
				);
				foreach ($p_delivery_boxes as $delivery_box) {
					$this->m_purchase->updateDatas('bud_lbl_outerboxes', 'box_no', $delivery_box, $updateData);
				}
				$this->m_purchase->updateDatas('bud_lbl_predelivery', 'p_delivery_id', $next_p_del, $update_p_del);
				$this->m_purchase->updateDatas('bud_lbl_predelivery_items', 'p_delivery_id', $p_delivery_id, array('delivery_id' => $delivery_id));
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "production/delivery_3_print/" . $dc_no, 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "production/delivery_3", 'refresh');
			}
		} else {
			redirect(base_url());
		}
	}
	function predelivery_3_list()
	{
		$data['activeTab'] = 'production';
		$data['activeItem'] = 'predelivery_3_list';
		$data['page_title'] = 'Pre Deliveries';
		$data['pre_deliveries'] = $this->m_masters->get_lbl_predc(); //deletion of predelivery label
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
		$this->load->view('labels/v_3_predelivery_list', $data);
	}
	function predelivery_3_edit()
	{
		$data['item_name'] = null;
		$data['search_date'] = null;

		if (isset($_POST['search'])) {
			$data['item_name'] = $this->input->post('item_name');
			$data['search_date'] = $this->input->post('search_date');
		}
		$data['activeTab'] = 'production';
		$data['activeItem'] = 'predelivery_3_edit';
		$data['page_title'] = 'Edit Pre Delivery';
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['items'] = $this->m_masters->getallmaster('bud_lbl_items');
		$data['pre_deliveries'] = $this->m_masters->get_lbl_predc(); //deletion of predelivery label

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
		if ($this->uri->segment(3) == TRUE) {
			$data['p_delivery_id'] = $this->uri->segment(3);
			$p_delivery_id = $this->uri->segment(3);
			$data['delivery_details'] = $this->m_masters->getmasterdetails('bud_lbl_predelivery', 'p_delivery_id', $p_delivery_id);
		} else {
			redirect(base_url() . "my404/404");
		}
		$this->load->view('labels/v_3_edit_predelivery', $data);
	}
	function predelivery_3_update()
	{
		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';*/
		$p_delivery_cust = $this->input->post('p_delivery_cust');
		$p_delivery_id = $this->input->post('p_delivery_id');
		//partial deivery qty
		$p_delivery_qty = $this->input->post('p_delivery_qty');
		$p_delivery_item = $this->input->post('item_size');
		//end of partial deliverey qty
		if ($this->input->post('p_delivery_boxes')) {
			$new_delivery_boxes = $this->input->post('p_delivery_boxes');
		} else {
			$new_delivery_boxes = array();
		}
		if (sizeof($new_delivery_boxes) > 0) {
			$predelivery = $this->m_masters->getmasterdetails('bud_lbl_predelivery', 'p_delivery_id', $p_delivery_id);
			$removed_boxes = array();
			foreach ($predelivery as $row) {
				$old_packing_boxes = explode(",", $row['p_delivery_boxes']);
			}
			foreach ($old_packing_boxes as $key => $value) {
				if (!in_array($value, $new_delivery_boxes)) {
					$removed_boxes[] = $value;
				}
			}
			//deletion of Predelivery Label		
			$formData = array(
				'p_delivery_cust' => $p_delivery_cust,
				'p_delivery_boxes' => implode(",", $new_delivery_boxes),
				'p_delivery_lt_edtd_by' => $this->session->userdata('user_id'),
				'p_delivery_lt_edtd_time' => date('Y-m-d H:i:s')
			);
			//end of//deletion of Predelivery Label	
			$result = $this->m_masters->updatemaster('bud_lbl_predelivery', 'p_delivery_id', $p_delivery_id, $formData);
			if ($result) {
				//partial delivery qty
				$pre_items = array('p_delivery_is_deleted' => 2);
				$pre_items_update = $this->m_masters->updatemaster('bud_lbl_predelivery_items', 'p_delivery_id', $p_delivery_id, $pre_items);
				//partial qty delivery
				foreach ($p_delivery_item as $key => $value) {
					$items = explode(',', $value);
					$formData = array(
						'box_id' => $items[0],
						'item_id' => $items[1],
						'item_size' => $items[2],
						'delivery_qty' => $p_delivery_qty[$key],
						'p_delivery_id' => $p_delivery_id,
						'p_delivery_is_deleted' => 1
					);
					$insert_items = $this->m_purchase->saveDatas('bud_lbl_predelivery_items', $formData);
				}
				//end of partial qty delivery	
				// $this->cart->destroy();
				$this->m_mycart->deleteCartLbl($this->session->userdata('user_id'));
				$remove_pre_del = array(
					'predelivery_status' => 0,
				);
				foreach ($new_delivery_boxes as $key => $value) {
					$this->m_purchase->updateDatas('bud_lbl_outerboxes', 'box_no', $value, $remove_pre_del);
				}
				$updateData = array(
					'predelivery_status' => 1
				);
				foreach ($removed_boxes as $outerbox) {
					$this->m_purchase->updateDatas('bud_lbl_outerboxes', 'box_no', $outerbox, $updateData);
				}
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "production/predelivery_3_list", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "production/predelivery_3_list", 'refresh');
			}
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "production/predelivery_3_list", 'refresh');
		}
	}
	//deletion of predelivery Labels
	function predelivery_3_delete()
	{
		$p_delivery_id = $this->input->post("p_delivery_id");
		$remarks = $this->input->post("remarks");
		if ($p_delivery_id) {
			$result = $this->m_masters->update_delete_status_predelivery_lbl($p_delivery_id, $remarks);
		}
		echo ($result) ? $p_delivery_id . ' Successfully Deleted' : 'Error in Deletion';
	}
	//end of deletion of predelivery Labels
	//deletion of predelivery Labels
	function delivery_3_delete()
	{
		$delivery_id = $this->input->post("delivery_id");
		$remarks = $this->input->post("remarks");
		if ($delivery_id) {
			$dc_no = $this->m_masters->getmasterIDvalue('bud_lbl_delivery', 'delivery_id', $delivery_id, 'dc_no');
			$update_data = array(
				'is_deleted' => '0',
				'last_edited_id' => $this->session->userdata('user_id'),
				'last_edited_time' => date('Y-m-d H:i:s'),
				'remarks' => $remarks
			);
			$result = $this->m_masters->updatemaster('bud_lbl_delivery', 'delivery_id', $delivery_id, $update_data);
			if ($result) {
				$p_delivery_id = $this->m_masters->getmasterIDvalue('bud_lbl_delivery', 'delivery_id', $delivery_id, 'p_delivery_ref');
				$update_data = array('p_delivery_status' => '1');
				$result = $this->m_masters->updatemaster('bud_lbl_predelivery', 'p_delivery_id', $p_delivery_id, $update_data);
				$update_data = array('delivery_id' => '0');
				$result = $this->m_masters->updatemaster('bud_lbl_predelivery_items', 'p_delivery_id', $p_delivery_id, $update_data);
			}
		}
		echo ($result) ? $dc_no . ' Successfully Deleted' : 'Error in Deletion';
	}
	//end of deletion of delivery Labels
	function delivery_3_print()
	{

		$data['activeTab'] = 'production';
		$data['activeItem'] = 'delivery_3';
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
			'assets/data-tables/jquery.dataTables.min.js',
			'assets/data-tables/DT_bootstrap.js'
		);
		$data['js_common'] = array('js/common-scripts.js');
		$data['js_thispage'] = array('js/form-validation-script.js', 'js/form-component.js', 'js/dynamic-table.js');
		if ($this->uri->segment(3) == TRUE) {
			$data['delivery_id'] = $this->uri->segment(3);
			$delivery_id = $this->uri->segment(3);
			$data['delivery_details'] = $this->m_masters->getmasterdetails('bud_lbl_delivery', 'delivery_id', $delivery_id);
		} else {
			redirect(base_url() . "my404/404");
		}
		$this->load->view('labels/v_3_delivery_print', $data);
	}
	function predelivery_3_print()
	{

		$data['activeTab'] = 'production';
		$data['activeItem'] = 'predelivery_3';
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
			'assets/data-tables/jquery.dataTables.min.js',
			'assets/data-tables/DT_bootstrap.js'
		);
		$data['js_common'] = array('js/common-scripts.js');
		$data['js_thispage'] = array('js/form-validation-script.js', 'js/form-component.js', 'js/dynamic-table.js');
		if ($this->uri->segment(3) == TRUE) {
			$data['p_delivery_id'] = $this->uri->segment(3);
			$p_delivery_id = $this->uri->segment(3);
			$data['delivery_details'] = $this->m_masters->getmasterdetails('bud_lbl_predelivery', 'p_delivery_id', $p_delivery_id);
		} else {
			redirect(base_url() . "my404/404");
		}
		$this->load->view('labels/v_3_predelivery_print', $data);
	}
	function delivery_3()
	{
		if ($this->uri->segment(3) == TRUE) {
			$data['p_delivery_id'] = $this->uri->segment(3);
			$p_delivery_id = $this->uri->segment(3);
			$data['delivery_details'] = $this->m_masters->getmasterdetails('bud_lbl_predelivery', 'p_delivery_id', $p_delivery_id);
		}
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_lbl_delivery'");
		$next = $next->row(0);
		$data['next_delivery'] = $next->Auto_increment;

		$data['activeTab'] = 'production';
		$data['activeItem'] = 'delivery_3';
		$data['page_title'] = 'Delivery';
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['items'] = $this->m_masters->getallmaster('bud_lbl_items');
		$data['outerboxes'] = $this->m_masters->getactivemaster('bud_lbl_outerboxes', 'delivery_status');
		$data['pre_deliveries'] = $this->m_masters->get_lbl_predc(); //deletion of predelivery Label

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
		$this->load->view('labels/v_3_delivery', $data);
	}
	function delivery_3_save()
	{

		$pre_delivery = $this->input->post('pre_delivery');
		$delivery_date = $this->input->post('delivery_date');
		$delivery_customer = $this->input->post('delivery_customer');
		$concern_name = $this->input->post('concern_name');
		$delivery_boxes = $this->input->post('delivery_boxes');
		$ed = explode("-", $delivery_date);
		$delivery_date = $ed[2] . '-' . $ed[1] . '-' . $ed[0];

		$dc_count = $this->m_masters->getmasterdetails('bud_lbl_delivery', 'concern_name', $concern_name);
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_lbl_delivery'");
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
			'delivery_boxes' => implode(",", $delivery_boxes)
		);
		$result = $this->m_purchase->saveDatas('bud_lbl_delivery', $formData);
		if ($result) {
			$updateData = array(
				'delivery_status' => 0
			);
			$update_p_del = array(
				'p_delivery_status' => 0
			);
			$update_p_del_items = array(
				'delivery_id' => $result
			);
			foreach ($delivery_boxes as $delivery_box) {
				$this->m_purchase->updateDatas('bud_lbl_outerboxes', 'box_no', $delivery_box, $updateData);
			}
			$this->m_purchase->updateDatas('bud_lbl_predelivery', 'p_delivery_id', $pre_delivery, $update_p_del);
			$this->m_purchase->updateDatas('bud_lbl_predelivery_items', 'p_delivery_id', $pre_delivery, $update_p_del_items);
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "production/delivery_3_print/" . $dc_no, 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "production/delivery_3", 'refresh');
		}
	}

	function zip_outerbox($box_no = '', $edit = false)
	{
		$this->load->model('m_poy');
		$data['next_box_no'] = '1';
		$data['box_no'] = $box_no;
		$data['edit'] = $edit;
		$data['item_id'] = '';
		$data['shade_id'] = '';
		$data['customer_id'] = '';
		$data['lot_qty'] = '0';
		$data['tot_packed_qty'] = '0';
		$data['tot_balancd_qty'] = '0';
		$data['item_uom'] = '';
		$data['packing_by'] = $this->session->userdata('user_id');

		$data['box'] = '';
		if ($edit) {
			$data['new_box_no'] = $edit;
		} else {
			$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_te_outerboxes'");
			$next = $next->row(0);
			$data['new_box_no'] = $next->Auto_increment;
		}

		$data['outerboxes'] = $this->m_masters->getmasterdetails('bud_te_outerboxes', 'box_prefix', 'Z');

		if ($box_no) {
			$box = $this->m_production->get_zip_outerbox($box_no);
			if ($box) {
				$data['item_id'] = $box->packing_innerbox_items;
			}
		}

		$data['items'] = $this->m_masters->get_items();
		$data['shades'] = $this->m_masters->get_shades();
		$data['lots'] = $this->m_masters->get_lots();
		$data['customers'] = $this->m_poy->get_customers();
		$data['users'] = $this->m_masters->get_users();
		$data['uoms'] = $this->m_masters->get_uoms();

		$data['activeTab'] = 'packing';
		$data['activeItem'] = 'zip_outerbox';
		$data['page_title'] = 'Outer Box - Qty Wise';

		$response = array();
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('lot_id', 'Lot No', 'required');
		$this->form_validation->set_rules('item_id', 'Item', 'required');
		$this->form_validation->set_rules('shade_id', 'Shade', 'required');
		$this->form_validation->set_rules('no_rolls', 'No of rolls', 'required|numeric');
		$this->form_validation->set_rules('qty_per_roll', 'Qty per roll', 'required|numeric');
		$this->form_validation->set_rules('item_uom', 'UOM', 'required');
		$this->form_validation->set_rules('total_qty', 'Total Qty', 'required|numeric');
		$this->form_validation->set_rules('gross_weight', 'Gross weight', 'required|numeric');
		$this->form_validation->set_rules('packing_by', 'Packed by', 'required');

		if ($this->form_validation->run() == FALSE) {
			$data['error'] = validation_errors();
			$this->load->view('zip-outerbox', $data);
		} else {
			$action = $this->input->post('action');
			$save['box_no'] = $edit;
			// $save['box_no'] = $this->input->post('box_no');
			$save['packing_date'] = date("Y-m-d");
			$save['packing_time'] = date("H:i:s");
			$save['packing_customer'] = $this->input->post('customer_id');
			$save['packing_innerbox_items'] = $this->input->post('item_id');
			$save['item_uom'] = $this->input->post('item_uom');
			$save['packing_by'] = $this->session->userdata('user_id');
			$save['total_rolls'] = $this->input->post('no_rolls');
			$save['qty_per_roll'] = $this->input->post('qty_per_roll');
			$save['box_prefix'] = 'Z';
			$save['lot_id'] = $this->input->post('lot_id');
			$save['total_qty'] = $this->input->post('total_qty');
			$save['packing_gr_weight'] = $this->input->post('gross_weight');
			$save['packing_net_weight'] = $this->input->post('total_qty');
			$save['packing_type'] = $this->input->post('qtywise');

			$box_no = $this->m_production->save_zip_outerbox($save);
			if ($action == 'save_continue') {
				redirect(base_url('production/zip_outerbox/' . $box_no), 'refresh');
			} else {
				redirect(base_url('production/zip_outerbox'), 'refresh');
			}
		}
	}

	public function zip_outerbox_save()
	{
		$response = array();
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('lot_id', 'Lot No', 'required');
		// $this->form_validation->set_rules('customer_id', 'Customer', 'required');
		$this->form_validation->set_rules('item_id', 'Item', 'required');
		$this->form_validation->set_rules('shade_id', 'Shade', 'required');
		$this->form_validation->set_rules('no_rolls', 'No of rolls', 'required|numeric');
		$this->form_validation->set_rules('qty_per_roll', 'Qty per roll', 'required|numeric');
		$this->form_validation->set_rules('item_uom', 'UOM', 'required');
		$this->form_validation->set_rules('total_qty', 'Total Qty', 'required|numeric');
		$this->form_validation->set_rules('gross_weight', 'Gross weight', 'required|numeric');
		$this->form_validation->set_rules('packing_by', 'Packed by', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url() . "production/zip_outerbox", 'refresh');
		} else {
			$action = $this->input->post('action');
			$save['box_no'] = $this->input->post('box_no');
			$save['packing_date'] = date("Y-m-d");
			$save['packing_time'] = date("H:i:s");
			$save['packing_customer'] = $this->input->post('customer_id');
			$save['item_uom'] = $this->input->post('item_uom');
			$save['packing_by'] = $this->session->userdata('user_id');
			$save['total_rolls'] = $this->input->post('no_rolls');
			$save['qty_per_roll'] = $this->input->post('qty_per_roll');
			$save['box_prefix'] = 'Z';
			$save['lot_id'] = $this->input->post('lot_id');
			$save['total_qty'] = $this->input->post('total_qty');
			$save['packing_gr_weight'] = $this->input->post('gross_weight');
			$save['packing_net_weight'] = $this->input->post('total_qty');
			$box_no = $this->m_production->save_zip_outerbox($save);
			if ($action == 'save_continue') {
				redirect(base_url('production/zip_outerbox/' . $box_no), 'refresh');
			} else {
				redirect(base_url('production/zip_outerbox'), 'refresh');
			}
		}
	}
}
