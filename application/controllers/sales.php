<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Sales extends CI_Controller
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
		$this->load->model('m_mir');
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
	function invoice_view()
	{
		$data['css_print'] = array(
			'css/invoice-print.css'
		);
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'invoice_view';
		$data['page_title'] = 'View Invoice';
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
		$this->load->view('v_invoice_view.php', $data);
	}
	function create_invoice_1()
	{
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'create_invoice_1';
		$data['page_title'] = 'Create Invoice';
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		// $data['deliveries'] = $this->m_masters->getactivemaster('bud_yt_delivery', 'invoice_status');
		$filter = array();
		$filter['invoice_status'] = 1;
		$data['deliveries'] = $this->m_delivery->get_yt_predelivery_list($filter);
		
		//print_r($data['deliveries']);
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
		if (isset($_POST['view'])) {
			$data['customer'] = $this->input->post('customer');
			$data['selected_dc'] = $this->input->post('selected_dc');
		} else {
			$data['customer'] = null;
			$data['selected_dc'] = null;
		}
		$this->load->view('v_1_create_invoice.php', $data);
	}
	function invoice_1_generate()
	{
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'create_invoice_1';
		$data['page_title'] = 'Generate Invoice';
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['deliveries'] = $this->m_masters->getactivemaster('bud_yt_delivery', 'invoice_status');
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
		if (isset($_POST['view'])) {
			$data['customer'] = $this->input->post('customer');
			$data['selected_dc'] = $this->input->post('selected_dc');
		} else {
			$data['customer'] = null;
			$data['selected_dc'] = null;
		}
		$this->load->view('v_1_invoice_generate.php', $data);
	}
	function invoice_1_save()
	{
		$concern_name = $this->input->post('concern_name');
		$item_rate = $this->input->post('item_rate');
		$selected_dc = $this->input->post('selected_dc');
		$customer = $this->input->post('customer');
		$no_of_boxes = $this->input->post('no_of_boxes');
		$boxes_array = $this->input->post('boxes_array');
		$order_othercharges = $this->input->post('order_othercharges');
		$order_othercharges_type = $this->input->post('order_othercharges_type');
		$order_othercharges_names = $this->input->post('order_othercharges_names');
		$order_othercharges_unit = $this->input->post('order_othercharges_unit');
		$order_othercharges_desc = $this->input->post('order_othercharges_desc');
		$order_tax_names = $this->input->post('order_tax_names');
		$taxs = $this->input->post('taxs');
		$sub_total = $this->input->post('sub_total');
		$invoice_no_type = $this->input->post('invoice_no');
		$remarks = $this->input->post('remarks'); //inclusion of remarks yt
		$invoice_items = array();
		$invoice_qty = array();
		$addtions_desc = array();
		$deduction_desc = array();
		$addtions_units = array();
		$tax_units = array();
		$deduction_units = array();
		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';*/

		if (isset($_POST['taxs'])) {
			$taxs = $this->input->post('taxs');
		} else {
			$taxs = array();
			$tax_values = array();
			$tax_amounts = array();
		}
		$amt = $this->input->post('sub_total');

		//echo $amt."<br>";
		$order_grand_total = 0;
		$order_subtotal = $sub_total;
		foreach ($order_othercharges_type as $key => $value) {
			if ($value == '-') {
				$duduction = 0;
				if ($order_othercharges_unit[$key] == '%') {
					$duduction = ($order_subtotal * $order_othercharges[$key]) / 100;
				} else {
					$duduction = $order_othercharges[$key];
				}
				//echo $duduction;
				$amt = $amt - $duduction;
				$deduction_names[] = $order_othercharges_names[$key];
				$deduction_values[] = $order_othercharges[$key];
				$deduction_amounts[] = $duduction;
				$deduction_desc[] = $order_othercharges_desc[$key];
				$deduction_units[] = $order_othercharges_unit[$key];
				$order_subtotal = $order_subtotal - $duduction;
				$order_grand_total = $order_grand_total + $order_subtotal;
			}
		}
		//echo  "Detuct Amount :".$amt . "<br>";
		// Calculate Additions
		foreach ($order_othercharges_type as $key => $value) {
			if ($value == '+') {
				$addition = 0;
				if ($order_othercharges_unit[$key] == '%') {
					$addition = ($order_subtotal * $order_othercharges[$key]) / 100;
				} else {
					$addition = $order_othercharges[$key];
				}
				$amt = $amt + $order_othercharges[$key];


				$addtions_names[] = $order_othercharges_names[$key];
				$addtions_values[] = $order_othercharges[$key];
				$addtions_amounts[] = $order_othercharges[$key];
				$addtions_desc[] = $order_othercharges_desc[$key];
				$addtions_units[] = $order_othercharges_unit[$key];
				$order_grand_total = $order_grand_total + $addition;
			}
		}
		//echo  "Add Amount :".$amt . "<br>";
		$tmp_amt = $amt;
		$tax_value = 0;
		$tax_total = 0;
		// Calculate Tax
		$tax_names = array();
		foreach ($taxs as $key => $tax) {
			if ($tax > 0) {
				$tax_value = ($tmp_amt * $tax) / 100;
				$tax_total = $tax_total + $tax_value;
				$tax_names[$key] = $order_tax_names[$key];
				$tax_units[$key] = '%';
				$tax_values[] = $tax;
				$tax_amounts[] = $tax_value;
				$order_grand_total = $order_grand_total + $tax_value;
			}
		}
		$amt = round($amt + $tax_total);
		//echo  "Total Amount :".$amt. "<br>";



		$table_name = '';
		if (isset($_POST['save'])) {
			$table_name = 'bud_yt_invoices';
			$invoice_count = $this->m_masters->getmasterdetails('bud_yt_invoices', 'concern_name', $concern_name);
		}
		if (isset($_POST['proforma'])) {
			$table_name = 'bud_yt_proforma_invoices';
			$invoice_count = $this->m_masters->getmasterdetails('bud_yt_proforma_invoices', 'concern_name', $concern_name);
		}
		$financialyear = (date('m') < '04') ? date('y', strtotime('-1 year')) : date('y');
		$financialyear .= '-' . ($financialyear + 1);
		$prefix = $this->m_masters->getmasterIDvalue('bud_concern_master', 'concern_id', $concern_name, 'concern_prefix');
		$invoice_start = $this->m_masters->getmasterIDvalue('bud_concern_master', 'concern_id', $concern_name, 'invoice_start');
		// $invoice_no = $prefix.'-'.$financialyear.'/'.(sizeof($invoice_count) + 1);
		$invoice_no = $prefix . '-' . (sizeof($invoice_count) + 1);
		if ($invoice_no_type == 'new') {
			$bill_year = date("y");
			$bill_month = date("m");
			$financialyear = ($bill_month < '04') ? $bill_year - 1 : $bill_year;
			$bill_year = $financialyear;

			$invoice_no = $prefix . '-' . $financialyear . '-' . ($bill_year + 1) . '/' . (sizeof($invoice_count) + 1 + $invoice_start);

			// $invoice_no = $prefix.'-'.$financialyear.'/'.(sizeof($invoice_count) + 1 + $invoice_start);			
			// $invoice_no = $prefix.'-'.(sizeof($invoice_count) + 1 + $invoice_start);			
		} else {
			$invoice_no = $invoice_no_type;
			if ($table_name != '') {
				$this->m_masters->deletemaster($table_name, 'invoice_no', $invoice_no);
			}
		}
		$formData = array(
			'concern_name' => $concern_name,
			'invoice_no' => $invoice_no,
			'invoice_date' => date("Y-m-d"),
			'customer' => $customer,
			'selected_dc' => $selected_dc,
			'item_rate' => implode(",", $item_rate),
			'boxes_array' => $boxes_array,
			'addtions_names' => implode(",", $addtions_names),
			'addtions_values' => implode(",", $addtions_values),
			'addtions_amounts' => implode(",", $addtions_amounts),
			'tax_names' => implode(",", $tax_names),
			'tax_values' => implode(",", $tax_values),
			'tax_amounts' => implode(",", $tax_amounts),
			'deduction_names' => implode(",", $deduction_names),
			'deduction_values' => implode(",", $deduction_values),
			'deduction_amounts' => implode(",", $deduction_amounts),
			'sub_total' => $sub_total,
			'net_amount' => $amt,
			'remarks' => $remarks, //inclusion of remarks yt
			'prepared_by' => $this->session->userdata('user_id'),
		);
		/*echo "<pre>";
		print_r($formData);
		echo "</pre>"*/
		if (isset($_POST['save'])) {
			$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_yt_invoices'");
			$next = $next->row(0);
			$next_invoice = $next->Auto_increment;

			$invoice_id = $this->m_purchase->saveDatas('bud_yt_invoices', $formData);
			if ($invoice_id) {
				$updateData = array(
					'invoice_status' => 0
				);
				//ER-09-18#-58
				$p_del_items = array(
					'invoice_id' => $invoice_id
				);
				$item_rate_array = array();
				$dc_box_array = explode(',', $boxes_array);
				foreach ($dc_box_array as $key => $box_id) {
					$item_rate_array[$box_id] = $item_rate[$key];
				}
				$deliveries = explode(",", $selected_dc);
				foreach ($deliveries as $delivery_id) {
					$this->m_purchase->updateDatas('bud_yt_delivery', 'delivery_id', $delivery_id, $updateData);
					$this->db->where('delivery_id', $delivery_id);
					$this->db->where('is_deleted', 1);
					$this->db->update('dyn_yt_predelivery_items', $p_del_items);
					$dc_p_boxes = $this->m_mir->get_two_table_values('dyn_yt_predelivery_items', '', 'box_id', '', '', array(
						'delivery_id' => $delivery_id,
						'is_deleted' => 1
					));
					foreach ($dc_p_boxes as $dc_p_box) {
						$p_item_rate = array(
							'item_rate' => $item_rate_array[$dc_p_box['box_id']]
						);
						$this->db->where('delivery_id', $delivery_id);
						$this->db->where('box_id', $dc_p_box['box_id']);
						$this->db->where('is_deleted', 1);
						$this->db->update('dyn_yt_predelivery_items', $p_item_rate);
					}
				}
				//ER-09-18#-58
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "sales/invoice_1_view/" . $next_invoice, 'refresh');
			}
		}
		if (isset($_POST['proforma'])) {
			$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_yt_proforma_invoices'");
			$next = $next->row(0);
			$next_invoice = $next->Auto_increment;

			$result = $this->m_purchase->saveDatas('bud_yt_proforma_invoices', $formData);
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "sales/proforma_invoice_1/" . $next_invoice, 'refresh');
			}
		}
	}
	function invoice_1_view()
	{
		if ($this->uri->segment(3)) {
			$data['invoice_id'] = $this->uri->segment(3);
		} else {
			redirect(base_url());
		}
		$data['css_print'] = array(
			'css/invoice-print.css'
		);
		$data['copytype'] = 'ORIGINAL COPY FOR CUSTOMER';
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'create_invoice_2';
		$data['page_title'] = 'View Invoice';
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
		$this->load->view('v_1_invoice_view.php', $data);
	}
	function invoice_1_viewsdc()
	{
		if ($this->uri->segment(3)) {
			$data['invoice_id'] = $this->uri->segment(3);
		} else {
			redirect(base_url());
		}
		$data['css_print'] = array(
			'css/invoice-print.css'
		);
		$data['copytype'] = 'DUPLICATE COPY FOR CUSTOMER';
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'create_invoice_2';
		$data['page_title'] = 'View Invoice';
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
		$this->load->view('v_1_invoice_view.php', $data);
	}
	function invoice_1_viewsac()
	{
		if ($this->uri->segment(3)) {
			$data['invoice_id'] = $this->uri->segment(3);
		} else {
			redirect(base_url());
		}
		$data['css_print'] = array(
			'css/invoice-print.css'
		);
		$data['copytype'] = 'ACCOUNTS COPY FOR SUPPLIER';
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'create_invoice_2';
		$data['page_title'] = 'View Invoice';
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
		$this->load->view('v_1_invoice_view.php', $data);
	}
	function invoice_1_viewsfc()
	{
		if ($this->uri->segment(3)) {
			$data['invoice_id'] = $this->uri->segment(3);
		} else {
			redirect(base_url());
		}
		$data['css_print'] = array(
			'css/invoice-print.css'
		);
		$data['copytype'] = 'FACTORY COPY';
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'create_invoice_2';
		$data['page_title'] = 'View Invoice';
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
		$this->load->view('v_1_invoice_view.php', $data);
	}

	function invoice_1_viewoc()
	{
		if ($this->uri->segment(3)) {
			$data['invoice_id'] = $this->uri->segment(3);
		} else {
			redirect(base_url());
		}
		$data['css_print'] = array(
			'css/invoice-print.css'
		);
		$data['copytype'] = 'ORIGINAL COPY FOR CUSTOMER';
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'create_invoice_2';
		$data['page_title'] = 'View Invoice';
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
		$this->load->view('v_1_invoice_viewt.php', $data);
	}
	function invoice_1_viewdc()
	{
		if ($this->uri->segment(3)) {
			$data['invoice_id'] = $this->uri->segment(3);
		} else {
			redirect(base_url());
		}
		$data['css_print'] = array(
			'css/invoice-print.css'
		);
		$data['copytype'] = 'DUPLICATE COPY FOR CUSTOMER';
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'create_invoice_2';
		$data['page_title'] = 'View Invoice';
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
		$this->load->view('v_1_invoice_viewt.php', $data);
	}
	function invoice_1_viewac()
	{
		if ($this->uri->segment(3)) {
			$data['invoice_id'] = $this->uri->segment(3);
		} else {
			redirect(base_url());
		}
		$data['css_print'] = array(
			'css/invoice-print.css'
		);
		$data['copytype'] = 'ACCOUNTS COPY FOR SUPPLIER';
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'create_invoice_2';
		$data['page_title'] = 'View Invoice';
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
		$this->load->view('v_1_invoice_viewt.php', $data);
	}
	function invoice_1_viewfc()
	{
		if ($this->uri->segment(3)) {
			$data['invoice_id'] = $this->uri->segment(3);
		} else {
			redirect(base_url());
		}
		$data['css_print'] = array(
			'css/invoice-print.css'
		);
		$data['copytype'] = 'FACTORY COPY';
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'create_invoice_2';
		$data['page_title'] = 'View Invoice';
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
		$this->load->view('v_1_invoice_viewt.php', $data);
	}

	function proforma_1_view()
	{
		if ($this->uri->segment(3)) {
			$data['invoice_id'] = $this->uri->segment(3);
		} else {
			redirect(base_url());
		}
		$data['css_print'] = array(
			'css/invoice-print.css'
		);
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'proforma_invoices_1';
		$data['page_title'] = 'View Estimate';
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
		$this->load->view('v_1_proforma_view.php', $data);
	}
	function invoices_1()
	{
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'invoices_1';
		$data['page_title'] = 'Print Invoices';
		// $data['invoices'] = $this->m_masters->getallmaster('bud_yt_invoices');
		$data['invoices'] = $this->m_masters->getmasterdetails('bud_yt_invoices', 'is_cancelled', '0');
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
		$this->load->view('v_1_invoices.php', $data);
	}
	function print_invoice_1()
	{
		/*echo "<pre>";
		print_r($_POST);
		echo "</pre>";*/
		$invoice_id = $this->input->post('invoice_id');
		$transport_name = $this->input->post('transport_name');
		$lr_no = $this->input->post('lr_no');
		$cust_pono = $this->input->post('cust_pono');
		$remarks = $this->input->post('remarks');
		$formData = array(
			'transport_name' => $transport_name,
			'lr_no' => $lr_no,
			'cust_pono' => $cust_pono,
			'remarks' => $remarks
		);
		$result = $this->m_purchase->updateDatas('bud_yt_invoices', 'invoice_id', $invoice_id, $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "sales/invoice_1_view/" . $invoice_id, 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "sales/invoice_1_view", 'refresh');
		}
	}

	function proforma_invoices_1()
	{
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'proforma_invoices_1';
		$data['page_title'] = 'Proforma Invoices';
		$data['proforma_invoices'] = $this->m_masters->getactivemaster('bud_yt_proforma_invoices', 'invoice_status');
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
		$this->load->view('v_1_proforma_invoices.php', $data);
	}
	function create_invoice_2()
	{
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'create_invoice_2';
		$data['page_title'] = 'Create Invoice';
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		// $data['deliveries'] = $this->m_masters->getactivemaster('bud_te_delivery', 'invoice_status');
		$data['deliveries'] = $this->m_delivery->get_tap_predelivery_list($filter = array(), true);
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
		if (isset($_POST['view'])) {
			$data['customer'] = $this->input->post('customer');
			$data['selected_dc'] = $this->input->post('selected_dc');
		} else {
			$data['customer'] = null;
			$data['selected_dc'] = null;
		}
		$this->load->view('v_2_create_invoice.php', $data);
	}
	function invoice_2_generate()
	{
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'create_invoice_2';
		$data['page_title'] = 'Generate Invoice';
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['deliveries'] = $this->m_masters->getactivemaster('bud_te_delivery', 'invoice_status');
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
		if (isset($_POST['view'])) {
			$data['customer'] = $this->input->post('customer');
			$data['selected_dc'] = $this->input->post('selected_dc');
		} else {
			$data['customer'] = null;
			$data['selected_dc'] = null;
		}
		$this->load->view('v_2_invoice_generate.php', $data);
	}
	function invoice_2_save()
	{
		$transport_name = '';
		$lr_no = '';

		$item_weights = $this->input->post('item_weights');
		$concern_name = $this->input->post('concern_name');
		$item_rate = $this->input->post('item_rate');
		$selected_dc = $this->input->post('selected_dc');
		$customer = $this->input->post('customer');
		// $invoice_items = $this->input->post('invoice_items');
		$no_of_boxes = $this->input->post('no_of_boxes');
		$item_uoms = $this->input->post('item_uoms');
		$boxes_array = $this->input->post('boxes_array');
		$order_othercharges = $this->input->post('order_othercharges');
		$order_othercharges_type = $this->input->post('order_othercharges_type');
		$order_othercharges_names = $this->input->post('order_othercharges_names');
		$order_othercharges_unit = $this->input->post('order_othercharges_unit');
		$order_othercharges_desc = $this->input->post('order_othercharges_desc');
		$order_tax_names = $this->input->post('order_tax_names');
		$taxs = $this->input->post('taxs');
		$sub_total = $this->input->post('sub_total');
		$invoice_no_type = $this->input->post('invoice_no');

		$transport_name = $this->input->post('transport_name');
		$lr_no = $this->input->post('lr_no');
		$remarks = $this->input->post('remarks'); //ER-08-18#-32
		$invoice_items = array();
		$invoice_qty = array();
		$addtions_desc = array();
		$deduction_desc = array();
		$addtions_units = array();
		$tax_units = array();
		$deduction_units = array();
		foreach ($item_weights as $key => $value) {
			$invoice_items[] = $key;
			$invoice_qty[] = $value;
		}
		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';*/

		if (isset($_POST['taxs'])) {
			$taxs = $this->input->post('taxs');
		} else {
			$taxs = array();
			$tax_values = array();
			$tax_amounts = array();
		}

		$amt = $this->input->post('sub_total');

		//echo $amt."<br>";
		$order_grand_total = 0;
		$order_subtotal = $sub_total;
		foreach ($order_othercharges_type as $key => $value) {
			if ($value == '-') {
				$duduction = 0;
				if ($order_othercharges_unit[$key] == '%') {
					$duduction = ($order_subtotal * $order_othercharges[$key]) / 100;
				} else {
					$duduction = $order_othercharges[$key];
				}
				//echo $duduction;
				$amt = $amt - $duduction;
				$deduction_names[] = $order_othercharges_names[$key];
				$deduction_values[] = $order_othercharges[$key];
				$deduction_amounts[] = $duduction;
				$deduction_desc[] = $order_othercharges_desc[$key];
				$deduction_units[] = $order_othercharges_unit[$key];
				$order_subtotal = $order_subtotal - $duduction;
				$order_grand_total = $order_grand_total + $order_subtotal;
			}
		}
		//echo  "Detuct Amount :".$amt . "<br>";
		// Calculate Additions
		foreach ($order_othercharges_type as $key => $value) {
			if ($value == '+') {
				$addition = 0;
				if ($order_othercharges_unit[$key] == '%') {
					$addition = ($order_subtotal * $order_othercharges[$key]) / 100;
				} else {
					$addition = $order_othercharges[$key];
				}
				$amt = $amt + $order_othercharges[$key];


				$addtions_names[] = $order_othercharges_names[$key];
				$addtions_values[] = $order_othercharges[$key];
				$addtions_amounts[] = $order_othercharges[$key];
				$addtions_desc[] = $order_othercharges_desc[$key];
				$addtions_units[] = $order_othercharges_unit[$key];
				$order_grand_total = $order_grand_total + $addition;
			}
		}
		//echo  "Add Amount :".$amt . "<br>";
		$tmp_amt = $amt;
		$tax_value = 0;
		$tax_total = 0;
		// Calculate Tax
		$tax_names = array();
		foreach ($taxs as $key => $tax) {
			if ($tax > 0) {
				$tax_value = ($tmp_amt * $tax) / 100;
				$tax_total = $tax_total + $tax_value;
				$tax_names[$key] = $order_tax_names[$key];
				$tax_units[$key] = '%';
				$tax_values[] = $tax;
				$tax_amounts[] = $tax_value;
				$order_grand_total = $order_grand_total + $tax_value;
			}
		}
		$amt = round($amt + $tax_total);
		//echo  "Total Amount :".$amt. "<br>";
		$table_name = '';
		if (isset($_POST['save'])) {
			$table_name = 'bud_te_invoices';
			$invoice_count = $this->m_masters->getmasterdetails('bud_te_invoices', 'concern_name', $concern_name);
		}
		if (isset($_POST['proforma'])) {
			$table_name = 'bud_te_proforma_invoices';
			$invoice_count = $this->m_masters->getmasterdetails('bud_te_proforma_invoices', 'concern_name', $concern_name);
		}
		$financialyear = (date('m') < '04') ? date('y', strtotime('-1 year')) : date('y');
		$financialyear .= '-' . ($financialyear + 1);
		$prefix = $this->m_masters->getmasterIDvalue('bud_concern_master', 'concern_id', $concern_name, 'concern_prefix');
		$invoice_start = $this->m_masters->getmasterIDvalue('bud_concern_master', 'concern_id', $concern_name, 'invoice_start');
		// $invoice_no = $prefix.'-'.$financialyear.'/'.(sizeof($invoice_count) + 1 + $invoice_start);
		$invoice_no = $prefix . '-' . (sizeof($invoice_count) + 1 + $invoice_start);
		if ($invoice_no_type == 'new') {
			$bill_year = date("y");
			$bill_month = date("m");
			$financialyear = ($bill_month < '04') ? $bill_year - 1 : $bill_year;
			$bill_year = $financialyear;

			$invoice_no = $prefix . '-' . $financialyear . '-' . ($bill_year + 1) . '/' . (sizeof($invoice_count) + 1 + $invoice_start);

			// $invoice_no = $prefix.'-'.$financialyear.'/'.(sizeof($invoice_count) + 1);
			// $invoice_no = $prefix.'-'.(sizeof($invoice_count) + 1);
		} else {
			$invoice_no = $invoice_no_type;
			if ($table_name != '') {
				$this->m_masters->deletemaster($table_name, 'invoice_no', $invoice_no);
			}
		}
		$formData = array(
			'concern_name' => $concern_name,
			'invoice_no' => $invoice_no,
			'invoice_date' => date("Y-m-d"),
			'customer' => $customer,
			'selected_dc' => $selected_dc,
			'invoice_items' => implode(",", $invoice_items),
			'item_weights' => implode(",", $invoice_qty),
			'item_rate' => implode(",", $item_rate),
			'no_of_boxes' => implode(",", $no_of_boxes),
			'item_uoms' => implode(",", $item_uoms),
			'boxes_array' => $boxes_array,
			'addtions_names' => implode(",", $addtions_names),
			'addtions_values' => implode(",", $addtions_values),
			'addtions_amounts' => implode(",", $addtions_amounts),
			'tax_names' => implode(",", $tax_names),
			'tax_values' => implode(",", $tax_values),
			'tax_amounts' => implode(",", $tax_amounts),
			'deduction_names' => implode(",", $deduction_names),
			'deduction_values' => implode(",", $deduction_values),
			'deduction_amounts' => implode(",", $deduction_amounts),
			'sub_total' => $sub_total,
			'net_amount' => $amt,
			'remarks' => $remarks, //ER-08-18#-32
			'prepared_by' => $this->session->userdata('user_id')
		);
		if (isset($_POST['save'])) {
			$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_te_invoices'");
			$next = $next->row(0);
			$next_invoice = $next->Auto_increment;

			$formData['transport_name'] = $transport_name;
			$formData['lr_no'] = $lr_no;

			$result = $this->m_purchase->saveDatas('bud_te_invoices', $formData);
			$invoice_id = $result;
			if ($result) {
				$deliveries = explode(",", $selected_dc);
				foreach ($deliveries as $key => $delivery_id) {
					$updateData = array(
						'invoice_status' => 0
					);
					$result = $this->m_purchase->updateDatas('bud_te_delivery', 'delivery_id', $delivery_id, $updateData);
					//predelivery items tapes
					$updateData = array(
						'invoice_id'   => $invoice_id
					);
					$result = $this->m_purchase->updateDatas('bud_te_predelivery_items', 'delivery_id', $delivery_id, $updateData);
				}
				foreach ($invoice_items as $key => $item_id) {
					$updateData = array(
						'item_rate'   => $item_rate[$key],
						'uom' => $item_uoms[$key]
					);
					$this->db->where(array('item_id' => $item_id, 'invoice_id' => $invoice_id));
					$result = $this->db->update('bud_te_predelivery_items', $updateData);
				}
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "sales/invoice_2_view/" . $next_invoice, 'refresh');
			}
		}
		if (isset($_POST['proforma'])) {
			$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_te_proforma_invoices'");
			$next = $next->row(0);
			$next_invoice = $next->Auto_increment;

			$result = $this->m_purchase->saveDatas('bud_te_proforma_invoices', $formData);
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "sales/proforma_invoice_2/" . $next_invoice, 'refresh');
			}
		}
	}

	// Create Invoice From Proforma Invoice List
	function print_invoice_2()
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_te_invoices'");
		$next = $next->row(0);
		$view_id = $next->Auto_increment;
		if (isset($_POST['print'])) {
			$invoice_id = $this->input->post('invoice_id');
			$transport_name = $this->input->post('transport_name');
			$lr_no = $this->input->post('lr_no');
			$updateData = array(
				'lr_no' => $lr_no,
				'transport_name' => $transport_name
			);
			$result = $this->m_purchase->updateDatas('bud_te_invoices', 'invoice_id', $invoice_id, $updateData);
			if ($result) {
				$customer_id = $this->m_masters->getmasterIDvalue('bud_te_invoices', 'invoice_id', $invoice_id, 'customer');
				$sms_active = $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer_id, 'sms_active');
				$email_active = $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer_id, 'email_active');
				$inv_no = $this->m_masters->getmasterIDvalue('bud_te_invoices', 'invoice_id', $invoice_id, 'invoice_no');
				if ($sms_active == 1) {
					$date_time = date("d-m-Y H:i:s");
					$sms_body = "Your goods despatched through $transport_name LRNO: $lr_no at $date_time against invoice no : $inv_no. Thanks SHIVA TAPES";
					// echo $sms_body;
					$cust_phone = $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer_id, 'cust_phone');
					// file_get_contents("http://transaction.lionsms.com/sendsms.jsp?user=smscbe&password=12345678&mobiles=".$cust_phone".&sms=".$sms_body."&unicode=0&senderid=smscbe");
					// echo "http://transaction.lionsms.com/sendsms.jsp?user=smscbe&password=12345678&mobiles=".$cust_phone."&sms=".$sms_body."&unicode=0&senderid=smscbe";
				}
				if ($email_active == 1) {
					$cust_email = $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer_id, 'cust_email');
					$emaildata['invoice_id'] = $invoice_id;
					$config = array(
						'protocol' => 'smtp',
						'smtp_host' => 'ssl://smtp.gmail.com',
						'smtp_port' => '465',
						'smtp_user' => 'budnetdesign@gmail.com',
						'smtp_pass' => 'newlife@5',
						'mailtype'  => 'html',
						'charset'   => 'utf-8',
						'newline'   => '\r\n'
					);
					$message_body = $this->load->view('v_2_invoice_email_tpl.php', $emaildata, true);
					$this->load->library('email', $config);
					$this->email->set_mailtype("html");
					$this->email->set_newline("\r\n");
					$this->email->from('buildtechdesigns@gmail.com', 'Budnet');
					$this->email->to($cust_email);
					$this->email->subject('SHIVA TAPES Goods despatch details of invoice no : #' . $inv_no);
					$this->email->message($message_body);
					$this->email->send();
				}
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "sales/invoice_2_view/" . $invoice_id, 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "sales/invoice_2_view", 'refresh');
			}
		} else {
			$invoice_id = $this->input->post('invoice_id');
			$transport_name = $this->input->post('transport_name');
			$lr_no = $this->input->post('lr_no');
			$invoice_details = $this->m_masters->getmasterdetails('bud_te_proforma_invoices', 'invoice_id', $invoice_id);
			foreach ($invoice_details as $row) {
				$invoice_date = $row['invoice_date'];
				$customer = $row['customer'];
				$selected_dc = $row['selected_dc'];
				$invoice_items = $row['invoice_items'];
				$item_weights = $row['item_weights'];
				$item_rate = $row['item_rate'];
				$no_of_boxes = $row['no_of_boxes'];
				$item_uoms = $row['item_uoms'];
				$boxes_array = $row['boxes_array'];
				$othercharges = $row['othercharges'];
				$othercharges_type = $row['othercharges_type'];
				$othercharges_names = $row['othercharges_names'];
				$othercharges_unit = $row['othercharges_unit'];
				$tax_names = $row['tax_names'];
				$taxs = $row['taxs'];
			}
			$formData = array(
				'invoice_date' => $invoice_date,
				'customer' => $customer,
				'selected_dc' => $selected_dc,
				'invoice_items' => $invoice_items,
				'item_weights' => $item_weights,
				'item_rate' => $item_rate,
				'no_of_boxes' => $no_of_boxes,
				'item_uoms' => $item_uoms,
				'boxes_array' => $boxes_array,
				'othercharges' => $othercharges,
				'othercharges_type' => $othercharges_type,
				'othercharges_names' => $othercharges_names,
				'othercharges_unit' => $othercharges_unit,
				'tax_names' => $tax_names,
				'taxs' => $taxs,
				'lr_no' => $lr_no,
				'transport_name' => $transport_name
			);
			$result = $this->m_purchase->saveDatas('bud_te_invoices', $formData);
			if ($result) {
				$customer_id = $this->m_masters->getmasterIDvalue('bud_te_invoices', 'invoice_id', $view_id, 'customer');
				$sms_active = $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer_id, 'sms_active');
				$email_active = $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer_id, 'email_active');
				// Start Send SMS
				if ($sms_active == 1) {
					$sms_body = 'Your goods despatched through ' . $transport_name . ' LRNO: ' . $lr_no . ' at ' . date("d-m-Y H:i:s") . ' against invoice no : ' . $view_id . '. Thanks SHIVA TAPES';
					$cust_phone = $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer_id, 'cust_phone');
					// file_get_contents('http://transaction.lionsms.com/sendsms.jsp?user=smscbe&password=12345678&mobiles='.$cust_phone.'&sms='.$sms_body.'&unicode=0&senderid=smscbe');
				}
				// End Send SMS
				// Start Send Email
				if ($email_active == 1) {
					$cust_email = $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer_id, 'cust_email');
					$emaildata['invoice_id'] = $view_id;
					$config = array(
						'protocol' => 'smtp',
						'smtp_host' => 'ssl://smtp.gmail.com',
						'smtp_port' => '465',
						'smtp_user' => 'budnetdesign@gmail.com',
						'smtp_pass' => 'newlife@5',
						'mailtype'  => 'html',
						'charset'   => 'utf-8',
						'newline'   => '\r\n'
					);
					$message_body = $this->load->view('v_2_invoice_email_tpl.php', $emaildata, true);
					$this->load->library('email', $config);
					$this->email->set_mailtype("html");
					$this->email->set_newline("\r\n");
					$this->email->from('buildtechdesigns@gmail.com', 'Budnet');
					$this->email->to($cust_email);
					$this->email->subject('SHIVA TAPES Goods despatch details of invoice no : #' . $view_id);
					$this->email->message($message_body);
					$this->email->send();
				}
				// End Send Email
				$selected_dc = explode(",", $selected_dc);
				$updateDC = array(
					'invoice_status' => 0
				);
				foreach ($selected_dc as $delivery_id) {
					$this->m_purchase->updateDatas('bud_te_delivery', 'delivery_id', $delivery_id, $updateDC);
				}
				$updateData = array(
					'invoice_status' => 0
				);
				$this->m_purchase->updateDatas('bud_te_proforma_invoices', 'invoice_id', $invoice_id, $updateData);

				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "sales/invoice_2_view/" . $view_id, 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "sales/invoice_2_view", 'refresh');
			}
		}
	}
	function invoice_2_view()
	{
		$this->load->model('m_reports');
		if ($this->uri->segment(3)) {
			$data['invoice_id'] = $this->uri->segment(3);
		} else {
			redirect(base_url());
		}
		$data['css_print'] = array(
			'css/invoice-print.css'
		);
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'create_invoice_2';
		$data['page_title'] = 'View Invoice';
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
		$this->load->view('v_2_invoice_view.php', $data);
	}
	function invoice_2_edit()
	{
		if ($this->uri->segment(3)) {
			$data['invoice_id'] = $this->uri->segment(3);
		} else {
			redirect(base_url());
		}
		$data['css_print'] = array(
			'css/invoice-print.css'
		);
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'create_invoice_2';
		$data['page_title'] = 'Edit Invoice';
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
		$this->load->view('v_2_invoice_edit.php', $data);
	}
	function invoice_2_update()
	{
		/*echo "<pre>";
		print_r($_POST);
		echo "</pre>";*/
		$sub_total = 0;
		$order_grand_total = 0;
		$invoice_id = $this->input->post('invoice_id');
		$customer = $this->input->post('customer');
		$item_weights = $this->input->post('item_weights');
		$item_rate = $this->input->post('item_rate');
		$order_othercharges = $this->input->post('order_othercharges');
		$order_othercharges_type = $this->input->post('order_othercharges_type');
		$order_othercharges_names = $this->input->post('order_othercharges_names');
		$order_othercharges_unit = $this->input->post('order_othercharges_unit');
		$order_othercharges_desc = $this->input->post('order_othercharges_desc');
		$order_tax_names = $this->input->post('order_tax_names');
		$taxs = $this->input->post('taxs');

		$invoice_items = array();
		$invoice_qty = array();
		$addtions_desc = array();
		$deduction_desc = array();
		$addtions_units = array();
		$tax_units = array();
		$deduction_units = array();

		foreach ($item_weights as $key => $value) {
			$invoice_items[] = $key;
			$invoice_qty[] = $value;
			$sub_total += $value * $item_rate[$key];
		}
		if (isset($_POST['taxs'])) {
			$taxs = $this->input->post('taxs');
		} else {
			$taxs = array();
			$tax_values = array();
			$tax_amounts = array();
		}
		foreach ($order_othercharges_type as $key => $value) {
			if ($value == '-') {
				$duduction = 0;
				if ($order_othercharges_unit[$key] == '%') {
					$duduction = ($sub_total * $order_othercharges[$key]) / 100;
				} else {
					$duduction = $order_othercharges[$key];
				}
				$deduction_names[] = $order_othercharges_names[$key];
				$deduction_values[] = $order_othercharges[$key];
				$deduction_amounts[] = $duduction;
				$deduction_desc[] = $order_othercharges_desc[$key];
				$deduction_units[] = $order_othercharges_unit[$key];
				$order_grand_total = $sub_total - $duduction; //edit Tax correction
			}
		}
		//edit Tax correction
		// Calculate Additions
		foreach ($order_othercharges_type as $key => $value) {
			if ($value == '+') {
				$addition = 0;
				if ($order_othercharges_unit[$key] == '%') {
					$addition = ($sub_total * $order_othercharges[$key]) / 100;
				} else {
					$addition = $order_othercharges[$key];
				}

				$addtions_names[] = $order_othercharges_names[$key];
				$addtions_values[] = $order_othercharges[$key];
				$addtions_amounts[] = $addition;
				$addtions_desc[] = $order_othercharges_desc[$key];
				$addtions_units[] = $order_othercharges_unit[$key];
				$order_grand_total = $order_grand_total + $addition;
			}
		}
		// Calculate Tax
		$tax_names = array();
		$b_tax_total = $order_grand_total; //edit Tax correction
		foreach ($taxs as $key => $tax) {
			if ($tax > 0) {
				$tax_value = ($b_tax_total * $tax) / 100; //edit Tax correction
				$tax_names[$key] = $order_tax_names[$key];
				$tax_units[$key] = '%';
				$tax_values[] = $tax;
				$tax_amounts[] = $tax_value;
				$order_grand_total = $order_grand_total + $tax_value;
			}
		} // end of edit Tax correction
		$formData = array(
			'customer' => $customer,
			'item_rate' => implode(",", $item_rate),
			'addtions_names' => implode(",", $addtions_names),
			'addtions_values' => implode(",", $addtions_values),
			'addtions_amounts' => implode(",", $addtions_amounts),
			'tax_names' => implode(",", $tax_names),
			'tax_values' => implode(",", $tax_values),
			'tax_amounts' => implode(",", $tax_amounts),
			'deduction_names' => implode(",", $deduction_names),
			'deduction_values' => implode(",", $deduction_values),
			'deduction_amounts' => implode(",", $deduction_amounts),
			'sub_total' => $sub_total,
			'net_amount' => round($order_grand_total),
			'prepared_by' => $this->session->userdata('user_id')
		);
		//print_r($formData);
		$result = $this->m_purchase->updateDatas('bud_te_invoices', 'invoice_id', $invoice_id, $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Updated!!!');
			redirect(base_url() . "sales/invoice_2_view/" . $invoice_id, 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "sales/invoices_2", 'refresh');
		}
	}
	function proforma_invoice_2()
	{
		if ($this->uri->segment(3)) {
			$data['invoice_id'] = $this->uri->segment(3);
		} else {
			redirect(base_url());
		}
		$data['css_print'] = array(
			'css/invoice-print.css'
		);
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'create_invoice_2';
		$data['page_title'] = 'View Invoice';
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
		$this->load->view('v_2_proforma_invoice.php', $data);
	}
	function proforma_invoices_2()
	{
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'proforma_invoices_2';
		$data['page_title'] = 'Proforma Invoices';
		$data['proforma_invoices'] = $this->m_masters->getactivemaster('bud_te_proforma_invoices', 'invoice_status');
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
		$this->load->view('v_2_proforma_invoices.php', $data);
	}
	function invoices_2()
	{
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'invoices_2';
		$data['page_title'] = 'Invoices';
		// $data['proforma_invoices'] = $this->m_masters->getallmaster('bud_te_invoices');
		$data['proforma_invoices'] = $this->m_masters->getmasterdetails('bud_te_invoices', 'is_cancelled', '0');
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
		$this->load->view('v_2_invoices.php', $data);
	}
	function print_trans_invoice_2()
	{
		$this->load->model('m_reports');
		if ($this->uri->segment(3) && $this->uri->segment(4)) {
			$data['invoice_id'] = $this->uri->segment(3);
			if ($this->uri->segment(4) == 1) {
				$data['table_name'] = 'bud_te_proforma_invoices';
			} else {
				$data['table_name'] = 'bud_te_invoices';
			}
		} else {
			redirect(base_url() . "404");
		}
		$data['css_print'] = array(
			'css/invoice-print.css'
		);
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'create_invoice_2';
		$data['page_title'] = 'View Invoice';
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
		$this->load->view('v_2_pro_trans_invoice.php', $data);
	}
	function print_trans_invoice_1()
	{
		if ($this->uri->segment(3) && $this->uri->segment(4)) {
			$data['invoice_id'] = $this->uri->segment(3);
			if ($this->uri->segment(4) == 1) {
				$data['table_name'] = 'bud_yt_proforma_invoices';
			} else {
				$data['table_name'] = 'bud_yt_invoices';
			}
		} else {
			redirect(base_url());
		}
		$data['css_print'] = array(
			'css/invoice-print.css'
		);
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'invoices_1';
		$data['page_title'] = 'Print Transport Invoice';
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
		$this->load->view('v_1_pro_trans_invoice.php', $data);
	}
	function print_gatepass_1()
	{
		if ($this->uri->segment(3) && $this->uri->segment(4)) {
			$data['invoice_id'] = $this->uri->segment(3);
			if ($this->uri->segment(4) == 1) {
				$data['table_name'] = 'bud_yt_proforma_invoices';
			} else {
				$data['table_name'] = 'bud_yt_invoices';
			}
		} else {
			redirect(base_url());
		}
		$data['css_print'] = array(
			'css/invoice-print.css'
		);
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'invoices_1';
		$data['page_title'] = 'Print Gate Pass';
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
		$this->load->view('v_1_print_gatepass.php', $data);
	}
	function print_gatepass_2()
	{
		if ($this->uri->segment(3) && $this->uri->segment(4)) {
			$data['invoice_id'] = $this->uri->segment(3);
			if ($this->uri->segment(4) == 1) {
				$data['table_name'] = 'bud_te_proforma_invoices';
			} else {
				$data['table_name'] = 'bud_te_invoices';
			}
		} else {
			redirect(base_url());
		}
		$data['css_print'] = array(
			'css/invoice-print.css'
		);
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'create_invoice_2';
		$data['page_title'] = 'View Invoice';
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
		$this->load->view('v_2_print_gatepass.php', $data);
	}
	function salesentry()
	{
		$data['activeTab'] = 'production';
		$data['activeItem'] = 'sales';
		$data['page_title'] = 'Sales Invoice';
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
			$this->load->view('v_sales_entry.php', $data);
		} else {
			$this->load->view('v_sales_entry.php', $data);
		}
	}
	function getcustomerDC($customer_id = null)
	{
		$deliveries = $this->m_masters->getactiveCdatas('bud_delivery', 'delivery_status', 'delivery_customer', $customer_id);
		$resultData = '<option value="">Select DC No</option>';
		foreach ($deliveries as $delivery) {
			$delivery_id = $delivery['delivery_id'];
			$resultData .= '<option value="' . $delivery_id . '">' . $delivery_id . '</option>';
		}
		echo $resultData;
	}
	function getDCItems($sales_dc_no = null)
	{
		$DCboxes = $this->m_purchase->getDatas('bud_delivery', 'delivery_id', $sales_dc_no);
		$items = array();
		foreach ($DCboxes as $DCbox) {
			$arr_value = explode(",", $DCbox['delivery_boxes']);
			$items = array_merge($items, $arr_value);
		}
		$data['items'] = $items;
		$this->load->view('v_DC_items.php', $data);
	}
	function savesalesentry()
	{
		$sales_date = $this->input->post('sales_date');
		$customer_id = $this->input->post('customer_id');
		$sales_dc_no = $this->input->post('sales_dc_no');
		$sales_boxes = $this->input->post('sales_boxes');
		$box_enq_item = $this->input->post('box_enq_item');
		$billrate = $this->input->post('billrate');
		$billtax = $this->input->post('billtax');
		$sales_remarks = $this->input->post('sales_remarks');
		$qd = explode("-", $sales_date);
		$sales_date = $qd[2] . '-' . $qd[1] . '-' . $qd[0];
		$formData = array(
			'sales_date' => $sales_date,
			'sales_customer' => $customer_id,
			'sales_dc_no' => $sales_dc_no,
			'sales_boxes' => implode(",", $sales_boxes),
			'sales_enq_item' => implode(",", $box_enq_item),
			'sales_billrate' => implode(",", $billrate),
			'sales_billtax' => implode(",", $billtax),
			'sales_remarks' => $sales_remarks
		);
		$result = $this->m_purchase->saveDatas('bud_sales', $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "sales/salesentry", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "sales/salesentry", 'refresh');
		}
	}

	function cash_invoice_2()
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_te_cash_invoices'");
		$next = $next->row(0);
		$data['invoice_id'] = $next->Auto_increment;

		$data['party_name'] = null;
		$data['item_name'] = null;
		$data['search_date'] = null;
		if (isset($_POST['search'])) {
			$data['item_name'] = $this->input->post('item_name');
			$data['search_date'] = $this->input->post('search_date');
		}
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'cash_invoice_2';
		$data['page_title'] = 'Cash Invoice';
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
		$this->load->view('v_2_cash_invoice.php', $data);
	}
	function cash_inv_selectedboxes()
	{
		$this->load->view('v_2_cash_inv_select_boxes.php');
	}
	// Get Direct Sales Customer Details
	function get_direct_customer($cust_mobile_no = null)
	{
		$resultData = array();
		$customer_name = '';
		$customer_details = $this->m_masters->getmasterdetails('bud_direct_sales_cust', 'customer_mobile', $cust_mobile_no);
		foreach ($customer_details as $row) {;
			$resultData[] = $row['customer_name'];
			$resultData[] = $row['customer_email'];
		}
		echo implode(",", $resultData);
	}
	function cash_invoice_2_gen()
	{
		$data['cust_mobile_no'] = $this->input->post('cust_mobile_no');
		$data['cust_name'] = $this->input->post('cust_name');
		$data['selected_boxes'] = $this->input->post('p_delivery_boxes');
		$data['customer'] = $this->input->post('customer');
		$data['customer_email'] = $this->input->post('customer_email');

		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'cash_invoice_2_gen';
		$data['page_title'] = 'Invoice Preview';
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['deliveries'] = $this->m_masters->getactivemaster('bud_te_delivery', 'invoice_status');
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
		$this->load->view('v_2_c_invoice_generate.php', $data);
	}
	function cash_invoice_2_save()
	{
		$customer_exist = $this->input->post('customer');
		$customer_email = $this->input->post('customer_email');
		$item_weights = $this->input->post('item_weights');
		$item_uoms = $this->input->post('item_uoms');
		$item_rate = $this->input->post('item_rate');
		$sub_total = $this->input->post('sub_total');
		$cust_name = $this->input->post('cust_name');
		$customer_mobile = $this->input->post('customer_mobile');
		$invoice_items = $this->input->post('invoice_items');
		$boxes_array = $this->input->post('boxes_array');
		$othercharges = $this->input->post('othercharges');
		$othercharges_type = $this->input->post('othercharges_type');
		$othercharges_names = $this->input->post('othercharges_names');
		$othercharges_unit = $this->input->post('othercharges_unit');
		$tax_names = $this->input->post('tax_names');
		if (isset($_POST['taxs'])) {
			$taxs = $this->input->post('taxs');
		} else {
			$taxs = array();
			$tax_values = array();
			$tax_amounts = array();
		}
		$order_grand_total = 0;
		$order_subtotal = $sub_total;
		foreach ($othercharges_type as $key => $value) {
			if ($value == '-') {
				$duduction = 0;
				if ($othercharges_unit[$key] == '%') {
					$duduction = ($order_subtotal * $othercharges[$key]) / 100;
				} else {
					$duduction = $othercharges[$key];
				}
				$deduction_names[] = $othercharges_names[$key];
				$deduction_values[] = $othercharges[$key];
				$deduction_amounts[] = $duduction;
				$order_subtotal = $order_subtotal - $duduction;
				$order_grand_total = $order_grand_total + $order_subtotal;
			}
		}

		/* Calculate Additions */
		foreach ($othercharges_type as $key => $value) {
			if ($value == '+') {
				$addition = 0;
				if ($othercharges_unit[$key] == '%') {
					$addition = ($order_subtotal * $othercharges[$key]) / 100;
				} else {
					$addition = $othercharges[$key];
				}

				$addtions_names[] = $othercharges_names[$key];
				$addtions_values[] = $othercharges[$key];
				$addtions_amounts[] = $addition;
				$order_grand_total = $order_grand_total + $addition;
			}
		}
		/* Calculate Tax */
		foreach ($taxs as $key => $tax) {
			$tax_value = ($order_subtotal * $tax) / 100;
			$tax_values[] = $tax;
			$tax_amounts[] = $tax_value;
			$order_grand_total = $order_grand_total + $tax_value;
		}

		if ($customer_exist != '') {
			$customer_id = $this->m_masters->getmasterIDvalue('bud_direct_sales_cust', 'customer_mobile', $customer_exist, 'customer_id');
			$updateCust = array(
				'customer_name' => $cust_name,
				'customer_mobile' => $customer_mobile,
				'customer_email' => $customer_email
			);
			$this->m_purchase->updateDatas('bud_direct_sales_cust', 'customer_id', $customer_id, $updateCust);
		} else {
			$custData = array(
				'customer_name' => $cust_name,
				'customer_mobile' => $customer_mobile,
				'customer_email' => $customer_email
			);
			$customer_id = $this->m_purchase->saveDatas('bud_direct_sales_cust', $custData);
		}
		$formData = array(
			'invoice_date' => date("Y-m-d"),
			'invoice_time' => date("H:i:s"),
			'customer' => $customer_id,
			'invoice_items' => $invoice_items,
			'item_weights' => implode(",", $item_weights),
			'item_rate' => implode(",", $item_rate),
			'item_uoms' => implode(",", $item_uoms),
			'boxes_array' => $boxes_array,
			'addtions_names' => implode(",", $addtions_names),
			'addtions_values' => implode(",", $addtions_values),
			'addtions_amounts' => implode(",", $addtions_amounts),
			'tax_names' => implode(",", $tax_names),
			'tax_values' => implode(",", $tax_values),
			'tax_amounts' => implode(",", $tax_amounts),
			'deduction_names' => implode(",", $deduction_names),
			'deduction_values' => implode(",", $deduction_values),
			'deduction_amounts' => implode(",", $deduction_amounts),
			'sub_total' => $sub_total,
			'net_amount' => round($order_grand_total)
		);
		$invoice_id = $this->m_purchase->saveDatas('bud_te_cash_invoices', $formData);
		if ($invoice_id) {
			$this->cart->destroy();
			$updateData = array(
				'predelivery_status' => 0,
				'delivery_status' => 0
			);
			$selected_boxes = explode(",", $boxes_array);
			foreach ($selected_boxes as $box_no) {
				$this->m_purchase->updateDatas('bud_te_outerboxes', 'box_no', $box_no, $updateData);
			}
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "sales/cash_invoice_2_view/" . $invoice_id, 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "sales/cash_invoice_2", 'refresh');
		}
	}
	function cash_invoice_2_view()
	{
		if ($this->uri->segment(3)) {
			$data['invoice_id'] = $this->uri->segment(3);
		} else {
			redirect(base_url());
		}
		$data['css_print'] = array(
			'css/invoice-print.css'
		);
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'cash_invoice_2';
		$data['page_title'] = 'View Invoice';
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
		$this->load->view('v_2_c_invoice_view.php', $data);
	}
	function packing_slip_2()
	{

		$data['css_print'] = array(
			'css/invoice-print.css'
		);
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'packing_slip_2';
		$data['page_title'] = 'Print Packing Slip';
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
		$this->load->view('v_2_packing_slip.php', $data);
	}
	function invoice_2_email_tpl()
	{
		if ($this->uri->segment(3)) {
			$data['invoice_id'] = $this->uri->segment(3);
		} else {
			redirect(base_url() . "404");
		}

		$data['css_print'] = array(
			'css/invoice-print.css'
		);
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'packing_slip_2';
		$data['page_title'] = 'Invoice Email Template';
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
		$this->load->view('v_2_invoice_email_tpl.php', $data);
	}

	function sendmail()
	{
		$data['invoice_id'] = 1;
		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.gmail.com',
			'smtp_port' => '465',
			'smtp_user' => 'budnetdesign@gmail.com',
			'smtp_pass' => 'newlife@5',
			'mailtype'  => 'html',
			'charset'   => 'utf-8',
			'newline'   => '\r\n'
		);
		$message_body = $this->load->view('v_2_invoice_email_tpl.php', $data, true);
		$this->load->library('email', $config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");
		$this->email->from('buildtechdesigns@gmail.com', 'Budnet');
		$this->email->to('sathan.1987@gmail.com');
		$this->email->subject('SHIVA TAPES Goods despatch details of invoice no : 1');
		$this->email->message($message_body);
		$this->email->send();
	}
	function invoice_1_preprint()
	{
		if ($this->uri->segment(3)) {
			$data['invoice_id'] = $this->uri->segment(3);
		} else {
			redirect(base_url());
		}
		$data['css_print'] = array(
			'css/invoice-print.css'
		);
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'invoices_2';
		$data['page_title'] = 'Print Invoice';
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
		$this->load->view('v_1_invoice-pre-printed.php', $data);
	}
	function invoice_2_preprint()
	{
		if ($this->uri->segment(3)) {
			$data['invoice_id'] = $this->uri->segment(3);
		} else {
			redirect(base_url());
		}
		$data['css_print'] = array(
			'css/invoice-print.css'
		);
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'invoices_2';
		$data['page_title'] = 'Print Invoice';
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
		$this->load->view('v_2_invoice-pre-printed.php', $data);
	}

	// Labels
	function create_invoice_3()
	{
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'create_invoice_3';
		$data['page_title'] = 'Create Invoice';
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['concerns'] = $this->m_masters->getallmaster('bud_concern_master');
		// $data['deliveries'] = $this->m_masters->getactivemaster('bud_lbl_delivery', 'invoice_status');
		$data['deliveries'] = $this->m_delivery->get_lbl_predelivery_list(array(), true);

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
		if (isset($_POST['view'])) {
			$data['customer'] = $this->input->post('customer');
			$data['selected_dc'] = $this->input->post('selected_dc');
			$data['concern'] = $this->input->post('concern'); //Inclusion of  select Concern Option
		} else {
			$data['customer'] = null;
			$data['selected_dc'] = null;
			$data['concern'] = null; //Inclusion of  select Concern Option
		}
		$this->load->view('labels/v_3_create_invoice', $data);
	}
	// Labels
	function invoice_3_generate()
	{
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'create_invoice_3';
		$data['page_title'] = 'Generate Invoice';
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['deliveries'] = $this->m_masters->getactivemaster('bud_lbl_delivery', 'invoice_status');
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
		if (isset($_POST['view'])) {
			$data['customer'] = $this->input->post('customer');
			$data['selected_dc'] = $this->input->post('selected_dc');
			$data['concern'] = $this->input->post('concern'); //Inclusion of  select Concern Option
		} else {
			$data['customer'] = null;
			$data['selected_dc'] = null;
			$data['concern'] = null; //Inclusion of  select Concern Option
		}
		$this->load->view('labels/v_3_invoice_generate', $data);
	}
	function invoice_3_save()
	{
		/*echo "<pre>";
		print_r($_POST);
		echo "</pre>";*/
		$transport_name = '';
		$lr_no = '';

		$invoice_items = $this->input->post('invoice_items');
		$item_rates = $this->input->post('item_rates');
		$item_uom = $this->input->post('item_uom');
		$item_boxes = $this->input->post('item_boxes');
		$sub_total = $this->input->post('sub_total');
		$selected_dc = $this->input->post('selected_dc');
		$customer = $this->input->post('customer');
		$concern_name = $this->input->post('concern_name');
		$boxes_array = $this->input->post('boxes_array');
		$order_othercharges = $this->input->post('order_othercharges');
		$order_othercharges_type = $this->input->post('order_othercharges_type');
		$order_othercharges_names = $this->input->post('order_othercharges_names');
		$order_othercharges_unit = $this->input->post('order_othercharges_unit');
		$order_othercharges_desc = $this->input->post('order_othercharges_desc');
		$order_tax_names = $this->input->post('order_tax_names');
		$taxs = $this->input->post('taxs');
		$sub_total = $this->input->post('sub_total');
		$invoice_no_type = $this->input->post('invoice_no');

		$transport_name = $this->input->post('transport_name');
		$lr_no = $this->input->post('lr_no');
		$remarks = $this->input->post('remarks'); //Inclusion of Remarks in invoices
		$items_row = array();
		foreach ($invoice_items as $key => $sizes) {
			foreach ($sizes as $size_key => $value) {
				$items_row[] = $key . '-' . $size_key . '-' . $value . '-' . $item_uom[$size_key] . '-' . $item_rates[$key] . '-' . ($value * $item_rates[$key]) . '-' . $item_boxes[$key];
			}
		}
		$addtions_desc = array();
		$deduction_desc = array();
		$addtions_units = array();
		$tax_units = array();
		$deduction_units = array();
		if (isset($_POST['taxs'])) {
			$taxs = $this->input->post('taxs');
		} else {
			$taxs = array();
			$tax_values = array();
			$tax_amounts = array();
		}
		$amt = $this->input->post('sub_total');
		$order_grand_total = 0;
		$order_subtotal = $sub_total;
		foreach ($order_othercharges_type as $key => $value) {
			if ($value == '-') {
				$duduction = 0;
				if ($order_othercharges_unit[$key] == '%') {
					$duduction = ($order_subtotal * $order_othercharges[$key]) / 100;
				} else {
					$duduction = $order_othercharges[$key];
				}
				//echo $duduction;
				$amt = $amt - $order_othercharges[$key];
				$deduction_names[] = $order_othercharges_names[$key];
				$deduction_values[] = $order_othercharges[$key];
				$deduction_amounts[] = $order_othercharges[$key];
				$deduction_desc[] = $order_othercharges_desc[$key];
				$deduction_units[] = $order_othercharges_unit[$key];
				$order_subtotal = $order_subtotal - $duduction;
				$order_grand_total = $order_grand_total + $order_subtotal;
			}
		}
		//echo  "Detuct Amount :".$amt . "<br>";
		// Calculate Additions
		foreach ($order_othercharges_type as $key => $value) {
			if ($value == '+') {
				$addition = 0;
				if ($order_othercharges_unit[$key] == '%') {
					$addition = ($order_subtotal * $order_othercharges[$key]) / 100;
				} else {
					$addition = $order_othercharges[$key];
				}
				$amt = $amt + $order_othercharges[$key];


				$addtions_names[] = $order_othercharges_names[$key];
				$addtions_values[] = $order_othercharges[$key];
				$addtions_amounts[] = $order_othercharges[$key];
				$addtions_desc[] = $order_othercharges_desc[$key];
				$addtions_units[] = $order_othercharges_unit[$key];
				$order_grand_total = $order_grand_total + $addition;
			}
		}
		$tmp_amt = $amt;
		$tax_value = 0;
		$tax_total = 0;
		// Calculate Tax
		$tax_names = array();
		foreach ($taxs as $key => $tax) {
			if ($tax > 0) {
				$tax_value = ($tmp_amt * $tax) / 100;
				$tax_total = $tax_total + $tax_value;
				$tax_names[$key] = $order_tax_names[$key];
				$tax_units[$key] = '%';
				$tax_values[] = $tax;
				$tax_amounts[] = $tax_value;
				$order_grand_total = $order_grand_total + $tax_value;
			}
		}
		$amt = round($amt + $tax_total);

		$table_name = '';
		if (isset($_POST['save'])) {
			$table_name = 'bud_lbl_invoices';
			$invoice_count = $this->m_masters->getmasterdetails('bud_lbl_invoices', 'concern_name', $concern_name);
		}
		if (isset($_POST['proforma'])) {
			$table_name = 'bud_lbl_proforma_invoices';
			$invoice_count = $this->m_masters->getmasterdetails('bud_lbl_proforma_invoices', 'concern_name', $concern_name);
		}
		$financialyear = (date('m') < '04') ? date('y', strtotime('-1 year')) : date('y');
		$financialyear .= '-' . ($financialyear + 1);
		$prefix = $this->m_masters->getmasterIDvalue('bud_concern_master', 'concern_id', $concern_name, 'concern_prefix');
		$invoice_start = $this->m_masters->getmasterIDvalue('bud_concern_master', 'concern_id', $concern_name, 'invoice_start');
		if ($invoice_no_type == 'new') {
			$bill_year = date("y");
			$bill_month = date("m");
			$financialyear = ($bill_month < '04') ? $bill_year - 1 : $bill_year;
			$bill_year = $financialyear;

			$invoice_no = $prefix . '-' . $financialyear . '-' . ($bill_year + 1) . '/' . (sizeof($invoice_count) + 1 + $invoice_start);
		} else {
			$invoice_no = $invoice_no_type;
			if ($table_name != '') {
				$this->m_masters->deletemaster($table_name, 'invoice_no', $invoice_no);
			}
		}
		$formData = array(
			'concern_name' => $concern_name,
			'invoice_no' => $invoice_no,
			'invoice_date' => date("Y-m-d"),
			'customer' => $customer,
			'selected_dc' => $selected_dc,
			'invoice_items_row' => implode(",", $items_row),
			'boxes_array' => $boxes_array,
			'addtions_names' => implode(",", $addtions_names),
			'addtions_values' => implode(",", $addtions_values),
			'addtions_units' => implode(",", $addtions_units),
			'addtions_amounts' => implode(",", $addtions_amounts),
			'addtions_desc' => implode(",", $addtions_desc),
			'tax_names' => implode(",", $tax_names),
			'tax_values' => implode(",", $tax_values),
			'tax_units' => implode(",", $tax_units),
			'tax_amounts' => implode(",", $tax_amounts),
			'deduction_names' => implode(",", $deduction_names),
			'deduction_values' => implode(",", $deduction_values),
			'deduction_units' => implode(",", $deduction_units),
			'deduction_amounts' => implode(",", $deduction_amounts),
			'deduction_desc' => implode(",", $deduction_desc),
			'sub_total' => $sub_total,
			'net_amount' => $amt,
			'remarks' => $remarks, //Inclusion of Remarks in invoices
			'prepared_by' => $this->session->userdata('user_id'),
			'last_edited_id' => $this->session->userdata('user_id'), //ER-09-18#-57
			'last_edited_time' => date('Y-m-d H:i:s') //ER-09-18#-57
		);
		// print_r($formData);
		if (isset($_POST['save'])) {
			$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_lbl_invoices'");
			$next = $next->row(0);
			$next_invoice = $next->Auto_increment;

			$formData['transport_name'] = $transport_name;
			$formData['lr_no'] = $lr_no;

			$result = $this->m_purchase->saveDatas('bud_lbl_invoices', $formData);
			if ($result) {
				$updateData = array(
					'invoice_status' => 0
				);
				$updateinv = array(
					'invoice_id' =>  $result
				);
				$deliveries = explode(",", $selected_dc);
				foreach ($deliveries as $delivery_id) {
					$this->m_purchase->updateDatas('bud_lbl_delivery', 'delivery_id', $delivery_id, $updateData);
					$this->m_purchase->updateDatas('bud_lbl_predelivery_items', 'delivery_id', $delivery_id, $updateinv);
				}
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "sales/invoice_3_view/" . $next_invoice, 'refresh');
			}
		}
		if (isset($_POST['proforma'])) {
			$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_lbl_proforma_invoices'");
			$next = $next->row(0);
			$next_invoice = $next->Auto_increment;

			$result = $this->m_purchase->saveDatas('bud_lbl_proforma_invoices', $formData);
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "sales/proforma_invoice_3/" . $next_invoice, 'refresh');
			}

			redirect(base_url() . "sales/create_invoice_3/", 'refresh');
		}
	}
	function invoice_3_view()
	{
		$this->load->model('m_reports');
		if ($this->uri->segment(3)) {
			$data['invoice_id'] = $this->uri->segment(3);
		} else {
			redirect(base_url());
		}
		$data['css_print'] = array(
			'css/invoice-print.css'
		);
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'create_invoice_3';
		$data['page_title'] = 'View Invoice';
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
		$this->load->view('labels/v_3_invoice_view', $data);
	}
	function invoice_3_edit()
	{
		if ($this->uri->segment(3)) {
			$data['invoice_id'] = $this->uri->segment(3);
		} else {
			redirect(base_url());
		}
		$data['css_print'] = array(
			'css/invoice-print.css'
		);
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'create_invoice_3';
		$data['page_title'] = 'Edit Invoice';
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
		$this->load->view('labels/v_3_invoice_edit', $data);
	}
	function invoice_3_update()
	{
		/*echo "<pre>";
		print_r($_POST);
		echo "</pre>";*/
		$sub_total = 0;
		$order_grand_total = 0;
		$invoice_id = $this->input->post('invoice_id');
		$customer = $this->input->post('customer');
		$invoice_items = $this->input->post('invoice_items');
		$item_boxes = $this->input->post('item_boxes');
		$item_uom = $this->input->post('item_uom');
		$item_rates = $this->input->post('item_rates');
		$order_othercharges = $this->input->post('order_othercharges');
		$order_othercharges_type = $this->input->post('order_othercharges_type');
		$order_othercharges_names = $this->input->post('order_othercharges_names');
		$order_othercharges_unit = $this->input->post('order_othercharges_unit');
		$order_othercharges_desc = $this->input->post('order_othercharges_desc');
		$order_tax_names = $this->input->post('order_tax_names');
		$taxs = $this->input->post('taxs');
		$items_row = array();
		foreach ($invoice_items as $key => $sizes) {
			foreach ($sizes as $size_key => $value) {
				$sub_total += $value * $item_rates[$key];
				$items_row[] = $key . '-' . $size_key . '-' . $value . '-' . $item_uom[$key] . '-' . $item_rates[$key] . '-' . ($value * $item_rates[$key]) . '-' . $item_boxes[$key];
			}
		}
		if (isset($_POST['taxs'])) {
			$taxs = $this->input->post('taxs');
		} else {
			$taxs = array();
			$tax_values = array();
			$tax_amounts = array();
		}
		foreach ($order_othercharges_type as $key => $value) {
			if ($value == '-') {
				$duduction = 0;
				if ($order_othercharges_unit[$key] == '%') {
					$duduction = ($sub_total * $order_othercharges[$key]) / 100;
				} else {
					$duduction = $order_othercharges[$key];
				}
				$deduction_names[] = $order_othercharges_names[$key];
				$deduction_values[] = $order_othercharges[$key];
				$deduction_amounts[] = $duduction;
				$deduction_desc[] = $order_othercharges_desc[$key];
				$deduction_units[] = $order_othercharges_unit[$key];
				$sub_total = $sub_total - $duduction;
				$order_grand_total = $order_grand_total + $sub_total;
			}
		}
		// Calculate Tax
		$tax_names = array();
		foreach ($taxs as $key => $tax) {
			if ($tax > 0) {
				$tax_value = ($sub_total * $tax) / 100;
				$tax_names[$key] = $order_tax_names[$key];
				$tax_units[$key] = '%';
				$tax_values[] = $tax;
				$tax_amounts[] = $tax_value;
				$order_grand_total = $order_grand_total + $tax_value;
			}
		}
		// Calculate Additions
		foreach ($order_othercharges_type as $key => $value) {
			if ($value == '+') {
				$addition = 0;
				if ($order_othercharges_unit[$key] == '%') {
					$addition = ($sub_total * $order_othercharges[$key]) / 100;
				} else {
					$addition = $order_othercharges[$key];
				}

				$addtions_names[] = $order_othercharges_names[$key];
				$addtions_values[] = $order_othercharges[$key];
				$addtions_amounts[] = $addition;
				$addtions_desc[] = $order_othercharges_desc[$key];
				$addtions_units[] = $order_othercharges_unit[$key];
				$order_grand_total = $order_grand_total + $addition;
			}
		}
		$formData = array(
			'customer' => $customer,
			'invoice_items_row' => implode(",", $items_row),
			'addtions_names' => implode(",", $addtions_names),
			'addtions_values' => implode(",", $addtions_values),
			'addtions_amounts' => implode(",", $addtions_amounts),
			'addtions_desc' => implode(",", $addtions_desc),
			'tax_names' => implode(",", $tax_names),
			'tax_values' => implode(",", $tax_values),
			'tax_amounts' => implode(",", $tax_amounts),
			'deduction_names' => implode(",", $deduction_names),
			'deduction_values' => implode(",", $deduction_values),
			'deduction_amounts' => implode(",", $deduction_amounts),
			'deduction_desc' => implode(",", $deduction_desc),
			'sub_total' => $sub_total,
			'net_amount' => round($order_grand_total),
			'prepared_by' => $this->session->userdata('user_id'),
			'last_edited_id' => $this->session->userdata('user_id'), //ER-09-18#-57
			'last_edited_time' => date('Y-m-d H:i:s') //ER-09-18#-57
		);
		/*echo "<pre>";
		print_r($formData);
		echo "</pre>";*/
		$result = $this->m_purchase->updateDatas('bud_lbl_invoices', 'invoice_id', $invoice_id, $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Updated!!!');
			redirect(base_url() . "sales/invoice_3_view/" . $invoice_id, 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "sales/invoices_3", 'refresh');
		}
		/*echo $sub_total;
		print_r($items_row);*/
	}
	function delete_invoice_1()
	{
		$invoice_id = $this->input->post("invoice_id");
		$remarks = $this->input->post("remarks");
		$result = false;
		if ($invoice_id) {
			$invoice_details = $this->m_masters->getmasterdetails('bud_yt_invoices', 'invoice_id', $invoice_id);
			$result = true;
			foreach ($invoice_details as $inv) {
				$selected_dc = explode(',', $inv['selected_dc']);
				$inv_no = $inv['invoice_no'];
				foreach ($selected_dc as $key => $value) {
					if (!$result) {
						break;
					}
					$updateData = array(
						'invoice_status' => 1
					);
					$result = $this->m_purchase->updateDatas('bud_yt_delivery', 'delivery_id', $value, $updateData);
				}
			}
			if ($result) {
				$update_data = array(
					'invoice_id' => '0',
					'uom' => '0',
					'item_rate' => '0'
				);
				$result = $this->m_masters->updatemaster('dyn_yt_predelivery_items', 'invoice_id', $invoice_id, $update_data);
			}
			if ($result) {
				$invoiceUpdate = array(
					'is_cancelled' => 1,
					'last_edited_id' => $this->session->userdata('user_id'),
					'last_edited_time' => date('Y-m-d H:i:s'),
					'remarks' => $remarks
				);
				$result = $this->m_purchase->updateDatas('bud_yt_invoices', 'invoice_id', $invoice_id, $invoiceUpdate);
			}
		}
		echo ($result) ? $inv_no . ' Successfully Deleted' : 'Error in Deletion';
	}

	/* legrand charles */
	function cancel_invoice_1($invoice_id = null)
	{
		if (!empty($invoice_id)) {
			$get_delivery_id_by_invoice = $this->m_masters->get_delivery_id_by_invoice($invoice_id);

			$updateData = array(
				'invoice_status' => '1'
			);
			$update_delivery = $this->m_masters->updatemaster('bud_yt_delivery', 'delivery_id', $get_delivery_id_by_invoice->delivery_id, $updateData);

			$updateData = array(
				'is_cancelled' => '1'
			);
			$update_invoice = $this->m_masters->updatemaster('bud_yt_invoices', 'invoice_id', $invoice_id, $updateData);
			//ER-09-18#-58
			$updateData = array(
				'invoice_id' => ''
			);
			$update_p_items = $this->m_masters->updatemaster('dyn_yt_predelivery_items', 'invoice_id', $invoice_id, $updateData);
			//ER-09-18#-58
			$this->session->set_flashdata('success', 'Successfully Cancelled!!!');
			redirect(base_url() . "sales/invoices_1", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'Failed to Delete!!!');
			redirect(base_url() . "sales/invoices_1", 'refresh');
		}
	}
	/* legrand charles */


	function delete_invoice_2()
	{
		$invoice_id = $this->input->post("invoice_id");
		$remarks = $this->input->post("remarks");
		$result = false;
		if ($invoice_id) {
			$invoice_details = $this->m_masters->getmasterdetails('bud_te_invoices', 'invoice_id', $invoice_id);
			$result = true;
			foreach ($invoice_details as $inv) {
				$selected_dc = explode(',', $inv['selected_dc']);
				$inv_no = $inv['invoice_no'];
				foreach ($selected_dc as $key => $value) {
					if (!$result) {
						break;
					}
					$updateData = array(
						'invoice_status' => 1
					);
					$result = $this->m_purchase->updateDatas('bud_te_delivery', 'delivery_id', $value, $updateData);
				}
			}
			if ($result) {
				$update_data = array(
					'invoice_id' => '0',
					'uom' => '0',
					'item_rate' => '0'
				);
				$result = $this->m_masters->updatemaster('bud_te_predelivery_items', 'invoice_id', $invoice_id, $update_data);
			}
			if ($result) {
				$invoiceUpdate = array(
					'is_cancelled' => 1,
					'last_edited_id' => $this->session->userdata('user_id'),
					'last_edited_time' => date('Y-m-d H:i:s'),
					'remarks' => $remarks
				);
				$result = $this->m_purchase->updateDatas('bud_te_invoices', 'invoice_id', $invoice_id, $invoiceUpdate);
			}
		}
		echo ($result) ? $inv_no . ' Successfully Deleted' : 'Error in Deletion';
	}
	function delete_invoice_3()
	{
		$invoice_id = $this->input->post("invoice_id");
		$remarks = $this->input->post("remarks");
		$result = false;
		if ($invoice_id) {
			$invoice_details = $this->m_masters->getmasterdetails('bud_lbl_invoices', 'invoice_id', $invoice_id);
			$result = true;
			foreach ($invoice_details as $inv) {
				$selected_dc = explode(',', $inv['selected_dc']);
				$inv_no = $inv['invoice_no'];
				foreach ($selected_dc as $key => $value) {
					if (!$result) {
						break;
					}
					$updateData = array(
						'invoice_status' => 1
					);
					$result = $this->m_purchase->updateDatas('bud_lbl_delivery', 'delivery_id', $value, $updateData);
				}
			}
			if ($result) {
				$update_data = array(
					'invoice_id' => '0',
					'item_rate' => '0'
				);
				$result = $this->m_masters->updatemaster('bud_lbl_predelivery_items', 'invoice_id', $invoice_id, $update_data);
			}
			if ($result) {
				$invoiceUpdate = array(
					'is_cancelled' => 1,
					'last_edited_id' => $this->session->userdata('user_id'),
					'last_edited_time' => date('Y-m-d H:i:s'),
					'remarks' => $remarks
				);
				$result = $this->m_purchase->updateDatas('bud_lbl_invoices', 'invoice_id', $invoice_id, $invoiceUpdate);
			}
		}
		echo ($result) ? $inv_no . ' Successfully Deleted' : 'Error in Deletion';
	}
	function invoices_3()
	{
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'invoices_3';
		$data['page_title'] = 'Invoices';
		$data['proforma_invoices'] = $this->m_general->getLblInvoices();
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
		$this->load->view('labels/v_3_invoices', $data);
	}
	function invoice_3_preprint()
	{
		if ($this->uri->segment(3)) {
			$data['invoice_id'] = $this->uri->segment(3);
		} else {
			redirect(base_url());
		}
		$data['css_print'] = array(
			'css/invoice-print.css'
		);
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'invoices_2';
		$data['page_title'] = 'Print Invoice';
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
		$this->load->view('labels/v_3_invoice-pre-printed', $data);
	}
	// Create Invoice From Proforma Invoice List
	function print_invoice_3()
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_lbl_invoices'");
		$next = $next->row(0);
		$view_id = $next->Auto_increment;
		if (isset($_POST['print'])) {
			$invoice_id = $this->input->post('invoice_id');
			$transport_name = $this->input->post('transport_name');
			$lr_no = $this->input->post('lr_no');
			$updateData = array(
				'lr_no' => $lr_no,
				'transport_name' => $transport_name
			);
			$result = $this->m_purchase->updateDatas('bud_lbl_invoices', 'invoice_id', $invoice_id, $updateData);
			if ($result) {
				$customer_id = $this->m_masters->getmasterIDvalue('bud_te_invoices', 'invoice_id', $invoice_id, 'customer');
				$sms_active = $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer_id, 'sms_active');
				$email_active = $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer_id, 'email_active');
				$inv_no = $this->m_masters->getmasterIDvalue('bud_te_invoices', 'invoice_id', $invoice_id, 'invoice_no');
				if ($sms_active == 1) {
					$date_time = date("d-m-Y H:i:s");
					$sms_body = "Your goods despatched through $transport_name LRNO: $lr_no at $date_time against invoice no : $inv_no. Thanks SHIVA TAPES";
					// echo $sms_body;
					$cust_phone = $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer_id, 'cust_phone');
					// file_get_contents("http://transaction.lionsms.com/sendsms.jsp?user=smscbe&password=12345678&mobiles=".$cust_phone".&sms=".$sms_body."&unicode=0&senderid=smscbe");
					// echo "http://transaction.lionsms.com/sendsms.jsp?user=smscbe&password=12345678&mobiles=".$cust_phone."&sms=".$sms_body."&unicode=0&senderid=smscbe";
				}
				/*if($email_active == 1)
	        	{
	        		$cust_email = $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer_id, 'cust_email');
	        		$emaildata['invoice_id'] = $invoice_id;		
					$config = array(
					    'protocol' => 'smtp',
					    'smtp_host' => 'ssl://smtp.gmail.com',
					    'smtp_port' => '465',
					    'smtp_user' => 'budnetdesign@gmail.com',
					    'smtp_pass' => 'newlife@5',
					    'mailtype'  => 'html', 
					    'charset'   => 'utf-8',
					    'newline'   => '\r\n'
					);
					$message_body = $this->load->view('labels/v_3_invoice_email_tpl', $emaildata, true);
					$this->load->library('email', $config);
					$this->email->set_mailtype("html");
					$this->email->set_newline("\r\n");
					$this->email->from('buildtechdesigns@gmail.com', 'Budnet');
					$this->email->to($cust_email);
					$this->email->subject('SHIVA TAPES Goods despatch details of invoice no : #'.$inv_no);
					$this->email->message($message_body);
					$this->email->send();
	        	}*/
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "sales/invoice_3_view/" . $invoice_id, 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "sales/invoice_3_view", 'refresh');
			}
		} else {
			$invoice_id = $this->input->post('invoice_id');
			$transport_name = $this->input->post('transport_name');
			$lr_no = $this->input->post('lr_no');
			$invoice_details = $this->m_masters->getmasterdetails('bud_lbl_proforma_invoices', 'invoice_id', $invoice_id);
			foreach ($invoice_details as $row) {
				$invoice_date = $row['invoice_date'];
				$customer = $row['customer'];
				$selected_dc = $row['selected_dc'];
				$invoice_items = $row['invoice_items'];
				$item_weights = $row['item_weights'];
				$item_rate = $row['item_rate'];
				$no_of_boxes = $row['no_of_boxes'];
				$item_uoms = $row['item_uoms'];
				$boxes_array = $row['boxes_array'];
				$othercharges = $row['othercharges'];
				$othercharges_type = $row['othercharges_type'];
				$othercharges_names = $row['othercharges_names'];
				$othercharges_unit = $row['othercharges_unit'];
				$tax_names = $row['tax_names'];
				$taxs = $row['taxs'];
			}
			$formData = array(
				'invoice_date' => $invoice_date,
				'customer' => $customer,
				'selected_dc' => $selected_dc,
				'invoice_items' => $invoice_items,
				'item_weights' => $item_weights,
				'item_rate' => $item_rate,
				'no_of_boxes' => $no_of_boxes,
				'item_uoms' => $item_uoms,
				'boxes_array' => $boxes_array,
				'othercharges' => $othercharges,
				'othercharges_type' => $othercharges_type,
				'othercharges_names' => $othercharges_names,
				'othercharges_unit' => $othercharges_unit,
				'tax_names' => $tax_names,
				'taxs' => $taxs,
				'lr_no' => $lr_no,
				'transport_name' => $transport_name
			);
			$result = $this->m_purchase->saveDatas('bud_lbl_invoices', $formData);
			if ($result) {
				$customer_id = $this->m_masters->getmasterIDvalue('bud_lbl_invoices', 'invoice_id', $view_id, 'customer');
				$sms_active = $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer_id, 'sms_active');
				$email_active = $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer_id, 'email_active');
				// Start Send SMS
				if ($sms_active == 1) {
					$sms_body = 'Your goods despatched through ' . $transport_name . ' LRNO: ' . $lr_no . ' at ' . date("d-m-Y H:i:s") . ' against invoice no : ' . $view_id . '. Thanks SHIVA TAPES';
					$cust_phone = $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer_id, 'cust_phone');
					// file_get_contents('http://transaction.lionsms.com/sendsms.jsp?user=smscbe&password=12345678&mobiles='.$cust_phone.'&sms='.$sms_body.'&unicode=0&senderid=smscbe');
				}
				// End Send SMS
				// Start Send Email
				/*if($email_active == 1)
	        	{
	        		$cust_email = $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer_id, 'cust_email');
	        		$emaildata['invoice_id'] = $view_id;		
					$config = array(
					    'protocol' => 'smtp',
					    'smtp_host' => 'ssl://smtp.gmail.com',
					    'smtp_port' => '465',
					    'smtp_user' => 'budnetdesign@gmail.com',
					    'smtp_pass' => 'newlife@5',
					    'mailtype'  => 'html', 
					    'charset'   => 'utf-8',
					    'newline'   => '\r\n'
					);
					$message_body = $this->load->view('labels/v_3_invoice_email_tpl', $emaildata, true);
					$this->load->library('email', $config);
					$this->email->set_mailtype("html");
					$this->email->set_newline("\r\n");
					$this->email->from('buildtechdesigns@gmail.com', 'Budnet');
					$this->email->to($cust_email);
					$this->email->subject('SHIVA TAPES Goods despatch details of invoice no : #'.$view_id);
					$this->email->message($message_body);
					$this->email->send();
	        	}*/
				// End Send Email
				$selected_dc = explode(",", $selected_dc);
				$updateDC = array(
					'invoice_status' => 0
				);
				foreach ($selected_dc as $delivery_id) {
					$this->m_purchase->updateDatas('bud_lbl_delivery', 'delivery_id', $delivery_id, $updateDC);
				}
				$updateData = array(
					'invoice_status' => 0
				);
				$this->m_purchase->updateDatas('bud_lbl_proforma_invoices', 'invoice_id', $invoice_id, $updateData);

				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "sales/invoice_3_view/" . $view_id, 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "sales/invoice_3_view", 'refresh');
			}
		}
	}
	function invoice_3_email_tpl()
	{
		if ($this->uri->segment(3)) {
			$data['invoice_id'] = $this->uri->segment(3);
		} else {
			redirect(base_url() . "404");
		}

		$data['css_print'] = array(
			'css/invoice-print.css'
		);
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'invoice_3_email_tpl';
		$data['page_title'] = 'Invoice Email Template';
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
		$this->load->view('labels/v_3_invoice_email_tpl', $data);
	}
	function print_trans_invoice_3()
	{
		if ($this->uri->segment(3) && $this->uri->segment(4)) {
			$data['invoice_id'] = $this->uri->segment(3);
			if ($this->uri->segment(4) == 1) {
				$data['table_name'] = 'bud_lbl_proforma_invoices';
			} else {
				$data['table_name'] = 'bud_lbl_invoices';
			}
		} else {
			redirect(base_url() . "404");
		}
		$data['css_print'] = array(
			'css/invoice-print.css'
		);
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'create_invoice_3';
		$data['page_title'] = 'Transport Invoice';
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
		$this->load->view('labels/v_3_pro_trans_invoice', $data);
	}
	function print_gatepass_3()
	{
		if ($this->uri->segment(3) && $this->uri->segment(4)) {
			$data['invoice_id'] = $this->uri->segment(3);
			if ($this->uri->segment(4) == 1) {
				$data['table_name'] = 'bud_lbl_proforma_invoices';
			} else {
				$data['table_name'] = 'bud_lbl_invoices';
			}
		} else {
			redirect(base_url());
		}
		$data['css_print'] = array(
			'css/invoice-print.css'
		);
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'create_invoice_3';
		$data['page_title'] = 'Gate Pass';
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
		$this->load->view('labels/v_3_print_gatepass', $data);
	}
	function proforma_invoices_3()
	{
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'proforma_invoices_3';
		$data['page_title'] = 'Proforma Invoices';
		$data['proforma_invoices'] = $this->m_masters->getactivemaster('bud_lbl_proforma_invoices', 'invoice_status');
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
		$this->load->view('labels/v_3_proforma_invoices', $data);
	}
	function proforma_invoice_3()
	{
		if ($this->uri->segment(3)) {
			$data['invoice_id'] = $this->uri->segment(3);
		} else {
			redirect(base_url());
		}
		$data['css_print'] = array(
			'css/invoice-print.css'
		);
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'create_invoice_3';
		$data['page_title'] = 'View Invoice';
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
		$this->load->view('labels/v_3_proforma_invoice', $data);
	}
	public function job_work_invoice()
	{
		$this->load->model('jwi_model');
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'job_work_invoice';
		$data['page_title'] = 'Job Work Invoice';
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['concern_list'] = $this->m_masters->getallmaster('bud_concern_master');
		$data['taxes'] = $this->m_masters->getactivemaster('bud_tax', 'tax_status');
		$data['invoice_gen'] = $this->jwi_model->generate_invoice();
		$data['table'] = $this->jwi_model->get_count_job_work_invoice();
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
		$this->load->view('v_1_create_job_work_invoice', $data);
	}

	function job_work_invoice_save()
	{
		$this->load->model('jwi_model');
		$sub_total = 0;
		$grand_total = 0;
		$taxs = $this->input->post('taxs');
		$order_tax_names = $this->input->post('order_tax_names');

		for ($a = 0; $a < count($_POST['a_particular']); $a++) {
			$sub_total += $_POST['a_amount'][$a];
		}

		// Calculate Tax
		$grand_total += $sub_total;
		$tax_names = array();
		$tax_units = array();
		$tax_values = array();
		$tax_amounts = array();
		foreach ($taxs as $key => $tax) {
			$tax_value = ($sub_total * $tax) / 100;
			$tax_names[$key] = $order_tax_names[$key];
			$tax_units[] = '%';
			$tax_values[] = $tax;
			$tax_amounts[] = $tax_value;
			$grand_total += $tax_value;
		}

		$save['jwi_id'] = '';
		$save['jwi_created_on'] = date("Y-m-d", strtotime($_POST['jwi_date']));
		$save['jwi_invoice_no'] = $_POST['invoice_no'];
		$save['jwi_customer_id'] = $_POST['customer'];
		$save['concern_id'] = $_POST['concern_id'];
		$save['tax_names'] = implode(",", $tax_names);
		$save['tax_values'] = implode(",", $tax_values);
		$save['tax_units'] = implode(",", $tax_units);
		$save['tax_amounts'] = implode(",", $tax_amounts);
		$save['sub_total'] = $sub_total;
		$save['grand_total'] = round($grand_total);
		$save['added_user'] = $this->session->userdata('user_id');

		$jwi_id = $this->jwi_model->save_jwi($save);

		for ($a = 0; $a < count($_POST['a_particular']); $a++) {
			$itms = array(
				'jwi_mst_id' => $jwi_id,
				'jwi_detail_particular' => $_POST['a_particular'][$a],
				'jwi_detail_quantity' => $_POST['a_qty'][$a],
				'jwi_detail_amount' => $_POST['a_amount'][$a],
				'jwi_detail_rate' => $_POST['a_rate'][$a],
				'jwi_detail_tax' => $_POST['a_tax'][$a],
				'jwi_detail_note' => $_POST['a_note'][$a]
			);
			$this->ak->insert_new('bud_jwi_details', $itms);
		}
		$this->session->set_flashdata('success', 'Successfully Saved!!!');
		redirect(base_url() . 'sales/print_jwi/' . $jwi_id, 'refresh');
	}

	function print_jwi($jwi_id = '')
	{
		$this->load->model('jwi_model');
		$data['activeTab'] = 'sales';
		$data['activeItem'] = 'job_work_invoice';
		$data['page_title'] = 'Print Jobwork Invoice';
		if (!empty($jwi_id)) {
			$data['jwi_id'] = $jwi_id;
			$data['invoice'] = $this->jwi_model->get_jobwork_invoice($jwi_id);
			$this->load->view('print-jobwork-invoice', $data);
		} else {
			$this->session->set_flashdata('error', 'Record not found!!!');
			redirect(base_url() . 'sales/job_work_invoice', 'refresh');
		}
	}

	function jwi_table_details($id)
	{
		$this->load->model('jwi_model');
		$result = $this->jwi_model->get_job_work_invoice_by_id($id);

		$Sno = 1;
		foreach ($result as $row) {
			echo    "<tr>
                        <th>" . $Sno . "</th>
                        <th>" . $row['cust_name'] . "</th>
                        <th>" . $row['jwi_detail_tax'] . "</th>
                        <th>" . $row['jwi_detail_particular'] . "</th>
                        <th>" . $row['jwi_detail_quantity'] . "</th>
						<th>" . $row['jwi_detail_amount'] . "</th>
						<th>" . $row['jwi_detail_rate'] . "</th>
                        <th>" . $row['jwi_detail_note'] . "</th>
                    </tr>";
			++$Sno;
		}
	}

	function print_transport_invoice_1()
	{

		$invoice_id = $this->input->post('invoice_id');
		$transport_name = $this->input->post('transport_name');
		$lr_no = $this->input->post('lr_no');
		$formData = array(
			'transport_name' => $transport_name,
			'lr_no' => $lr_no
		);
		$result = $this->m_purchase->updateDatas('bud_yt_invoices', 'invoice_id', $invoice_id, $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "sales/print_trans_invoice_1/" . $invoice_id . '/2', 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "sales/invoice_1_view", 'refresh');
		}
	}
}
