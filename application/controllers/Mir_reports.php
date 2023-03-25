<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//Dynamic Dost 3.0
class Mir_reports extends CI_Controller
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
		$this->load->model('m_reports');
		$this->load->model('m_delivery');
		$this->load->model('m_mir');
		$this->load->library('cart');

		if (!$this->session->userdata('logged_in')) {
			// Allow some methods?
			$allowed = array();
			if (!in_array($this->router->method, $allowed)) {
				redirect(base_url() . 'users/login', 'refresh');
			}
		}
	}
	function cust_sales_report_2()
	{
		$data['activeTab'] = 'mir_reports';
		$data['activeItem'] = 'cust_sales_report_2';
		$data['page_title'] = 'Customer Sales Report -Tapes And Zippers -CSR';
		$pre_yr = date('Y');
		$pre_yr = $pre_yr - 1;
		$data['f_date'] = (date('m') < 4) ? date("d-m-Y", strtotime('01-04-' . $pre_yr)) : date("d-m-Y", strtotime('01-04-' . date('Y')));
		$data['t_date'] = date("d-m-Y");
		$data['customer'] = 0;
		$data['month'] = 0;
		$data['term'] = 0;
		$month = 0;
		$term = 0;
		$customer = array();
		$from_date = $data['f_date'];
		$to_date = date("Y-m-d");
		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
			$term = $this->input->post('term');
			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			$data['term'] = $term;
			$data['customer'] = $this->input->post('customer_id');
			$customer = $this->m_masters->getcustomerdetails($data['customer']);
			$data['month'] = $this->input->post('month');
			$month = $data['month'];
			$where_array = array(
				'invoice_date >=' => $from_date,
				'invoice_date <=' => $to_date
			);
		}
		$data['customers'] = $this->m_mir->getalldata_odr_field_name('bud_customers', 'cust_status', 'cust_name');
		$data['tot_inv_amt'] = 0;
		if ($customer == null) {
			$customer = $data['customers'];
		}
		foreach ($customer as $cust) {
			$data['invoices'] = $this->m_mir->get_cust_sales_rep_te($from_date, $to_date, $cust['cust_id']);
			$value = 12;
			$end_value = 1;
			$m_or_y = 'm';
			if ($month != 0) {
				$value = $month;
				$end_value = $month;
			}
			if ($term == '2') {
				$value = date('Y', strtotime($to_date));
				$end_value = date('Y', strtotime($from_date));
				$m_or_y = 'Y';
			}
			while ($value >= $end_value) {
				$inv_cust_amt[$cust['cust_id']][$value] = 0;
				$inv_cust_num[$cust['cust_id']][$value] = 0;
				if ($data['invoices'] != null) {
					foreach ($data['invoices'] as $invoice) {
						$inv_month = date($m_or_y, strtotime($invoice['invoice_date']));
						if ($inv_month == $value) {
							$inv_cust_amt[$cust['cust_id']][$value] += $invoice['net_amount'];
							$inv_cust_num[$cust['cust_id']][$value] += 1;
							$data['tot_inv_amt'] += $invoice['net_amount'];
						}
					}
					$inv_amt = (string) $inv_cust_amt[$cust['cust_id']][$value];
					$len = strlen($inv_amt);
					if ($len > 3) {
						$len -= 3;
						$inv_amt = substr_replace($inv_amt, ',', $len, 0);

						while ($len > 2) {
							$len -= 2;
							$inv_amt = substr_replace($inv_amt, ',', $len, 0);
						}
					}
					$inv_cust_amt[$cust['cust_id']][$value] = $inv_amt;
				}
				$value--;
			}
		}
		$tot_amt = (string) $data['tot_inv_amt'];
		$len = strlen($tot_amt);
		if ($len > 3) {
			$len -= 3;
			$tot_amt = substr_replace($tot_amt, ',', $len, 0);

			while ($len > 2) {
				$len -= 2;
				$tot_amt = substr_replace($tot_amt, ',', $len, 0);
			}
		}
		$grand_tot = $this->m_mir->getcolumn('bud_te_invoices', 'net_amount');
		$tot = 0;
		foreach ($grand_tot as $key) {
			$tot += $key['net_amount'];
		}
		$tot = (string) $tot;
		$len = strlen($tot);
		if ($len > 3) {
			$len -= 3;
			$tot = substr_replace($tot, ',', $len, 0);

			while ($len > 2) {
				$len -= 2;
				$tot = substr_replace($tot, ',', $len, 0);
			}
		}
		$data['grand_tot'] = $tot;
		$data['tot_inv_amt'] = $tot_amt;
		$data['inv_cust_amt'] = $inv_cust_amt;
		$data['inv_cust_num'] = $inv_cust_num;
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
		$this->load->view('v_2_cust_sales_report', $data);
	}
	function item_sales_report_2()
	{
		$data['activeTab'] = 'mir_reports';
		$data['activeItem'] = 'item_sales_report_2';
		$data['page_title'] = 'Item Sales Report-Tapes And Zippers -ISR';
		$data['catagory'] = 'te';
		$pre_yr = date('Y');
		$pre_yr = $pre_yr - 1;
		$data['f_date'] = (date('m') < 4) ? date("d-m-Y", strtotime('01-04-' . $pre_yr)) : date("d-m-Y", strtotime('01-04-' . date('Y')));
		$data['t_date'] = date("d-m-Y");
		$data['item_id'] = 0;
		$data['items'] = $this->m_masters->getactivemaster('bud_te_items', 'item_status');
		$data['month'] = 0;
		$data['term'] = 1;
		$month = 0;
		$term = 1;
		$customer = array();
		$from_date = $data['f_date'];
		$to_date = date("Y-m-d");
		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
			$term = $this->input->post('term');
			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			$data['term'] = $term;
			$data['item_id'] = $this->input->post('item_id');
			$data['month'] = $this->input->post('month');
			$month = $data['month'];
			$where_array = array(
				'invoice_date >=' => $from_date,
				'invoice_date <=' => $to_date
			);
		}
		if ($term == '1') {
			$tyear = date("Y", strtotime($to_date));
			$fyear = date("Y", strtotime($from_date));
			$year = $tyear;
			if ($tyear != $fyear) {
				$year = ($month > 3) ? $fyear : $tyear;
			}

			if ($month != '0') {
				if ($month < 10) {
					$date = '01-0' . $month . '-' . $year;
				}
				$date = '01-' . $month . '-' . $year;
				$from_date = date("Y-m-d", strtotime($date));
				$to_date = date("Y-m-t", strtotime($date));
			}
		}
		$data['item_detail'] = $this->m_mir->get_item_sales_rep_te($from_date, $to_date, $data['item_id'], $term, $month);
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
		$this->load->view('v_2_item_sales_report', $data);
	}
	function item_pack_report_2()
	{
		$data['activeTab'] = 'mir_reports';
		$data['activeItem'] = 'item_pack_report_2';
		$data['page_title'] = 'Item Wise Packing Report-Tapes And Zippers-IPR';
		$pre_yr = date('Y');
		$pre_yr = $pre_yr - 1;
		$data['f_date'] = (date('m') < 4) ? date("d-m-Y", strtotime('01-04-' . $pre_yr)) : date("d-m-Y", strtotime('01-04-' . date('Y')));
		$data['t_date'] = date("d-m-Y");
		$data['uoms'] = $this->m_mir->getcolumn('bud_uoms', array('uom_id', 'uom_name'));
		$data['item_id'] = 0;
		$data['month'] = 0;
		$data['term'] = 0;
		$data['uom_val'] = array();
		$uom_val = array();
		$month = 0;
		$term = 0;
		$item = array();
		$from_date = $data['f_date'];
		$to_date = date("Y-m-d");
		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
			$term = $this->input->post('term');
			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			$data['term'] = $term;
			$data['item_id'] = $this->input->post('item_id');
			$item = $this->m_masters->getcategoryallmaster('bud_te_items', 'item_id', $data['item_id']);
			$data['month'] = $this->input->post('month');
			$uom_val = $this->input->post('uom');
			if ($uom_val != null) {
				foreach ($uom_val as $key => $value) {
					if ($key == 0) {
						$condition = 'uom_id = ' . $value;
					}
					$condition .= ' OR uom_id = ' . $value;
				}
				$data['uom_val'] = $this->m_mir->getgroupfields('bud_uoms', array('uom_id', 'uom_name'), $condition);
			}
			$month = $data['month'];
		}
		if ($term == '1') {
			$tyear = date("Y", strtotime($to_date));
			$fyear = date("Y", strtotime($from_date));
			$year = $tyear;
			if ($tyear != $fyear) {
				$year = ($month > 3) ? $fyear : $tyear;
			}

			if ($month != '0') {
				if ($month < 10) {
					$date = '01-0' . $month . '-' . $year;
				}
				$date = '01-' . $month . '-' . $year;
				$from_date = date("Y-m-d", strtotime($date));
				$to_date = date("Y-m-t", strtotime($date));
			}
		}
		$data['item_detail'] = $this->m_mir->get_item_pack_rep_te($from_date, $to_date, $data['item_id'], $term, $uom_val);

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
		$this->load->view('v_2_item_pack_report', $data);
	}
	function item_sales_report_1()
	{
		$data['activeTab'] = 'mir_reports';
		$data['activeItem'] = 'item_sales_report_1';
		$data['page_title'] = 'Item Sales Report-(Yarns & Threads)-ISR';
		$data['catagory'] = 'yt';
		$pre_yr = date('Y');
		$pre_yr = $pre_yr - 1;
		$data['f_date'] = (date('m') < 4) ? date("d-m-Y", strtotime('01-04-' . $pre_yr)) : date("d-m-Y", strtotime('01-04-' . date('Y')));
		$data['t_date'] = date("d-m-Y");
		$data['item_id'] = 0;
		$data['items'] = $this->m_masters->getactivemaster('bud_items', 'item_status');
		$data['item'] = 0;
		$data['month'] = 0;
		$data['term'] = 1;
		$month = 0;
		$term = 1;
		$customer = array();
		$from_date = $data['f_date'];
		$to_date = date("Y-m-d");
		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
			$term = $this->input->post('term');
			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			$data['term'] = $term;
			$data['item_id'] = $this->input->post('item_id');
			$data['month'] = $this->input->post('month');
			$month = $data['month'];
			$where_array = array(
				'invoice_date >=' => $from_date,
				'invoice_date <=' => $to_date
			);
		}
		if ($term == '1') {
			$tyear = date("Y", strtotime($to_date));
			$fyear = date("Y", strtotime($from_date));
			if ($tyear != $fyear) {
				$year = ($month > 3) ? $fyear : $tyear;
			}
			$year = $tyear;
			if ($month != '0') {
				if ($month < 10) {
					$date = '01-0' . $month . '-' . $year;
				}
				$date = '01-' . $month . '-' . $year;
				$from_date = date("Y-m-d", strtotime($date));
				$to_date = date("Y-m-t", strtotime($date));
			}
		}
		$data['item_detail'] = $this->m_mir->get_item_sales_rep_yt($from_date, $to_date, $data['item_id'], $term, $month);
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
		$this->load->view('v_1_item_sales_report', $data);
	}
	function item_pack_report_1()
	{
		$data['activeTab'] = 'mir_reports';
		$data['activeItem'] = 'item_pack_report_1';
		$data['page_title'] = 'Item Wise Packing Report-Yarns & Threads-IPR';
		$pre_yr = date('Y');
		$pre_yr = $pre_yr - 1;
		$data['f_date'] = (date('m') < 4) ? date("d-m-Y", strtotime('01-04-' . $pre_yr)) : date("d-m-Y", strtotime('01-04-' . date('Y')));
		$data['t_date'] = date("d-m-Y");
		$data['uoms'] = $this->m_mir->getcolumn('bud_uoms', array('uom_id', 'uom_name'));
		$data['item'] = 0;
		$data['month'] = 0;
		$data['term'] = 0;
		$data['uom_val'] = array();
		$uom_val = array();
		$month = 0;
		$term = 0;
		$item = array();
		$pack_weight = array();
		$pack_cones = array();
		$from_date = $data['f_date'];
		$to_date = date("Y-m-d");
		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
			$term = $this->input->post('term');
			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			$data['term'] = $term;
			$data['item'] = $this->input->post('item_id');
			$item = $this->m_masters->getcategoryallmaster('bud_items', 'item_id', $data['item']);
			$data['month'] = $this->input->post('month');
			$uom_val = $this->input->post('uom');
			if ($uom_val != null) {
				foreach ($uom_val as $key => $value) {
					$data['uom_val'] = $this->m_mir->getgroupfields('bud_uoms', array('uom_id', 'uom_name'), array('uom_id' => $value));
				}
			}
			$month = $data['month'];
		}

		$data['items'] = $this->m_mir->getalldata_odr_field_name('bud_items', 'item_status', 'item_name');
		$data['tot_wt'] = 0;
		$data['tot_cones'] = 0;
		foreach ($data['uoms'] as $uom1) {
			$data['tot'][$uom1['uom_id']] = 0;
			$tot[$uom1['uom_id']] = 0;
		}
		if ($item == null) {
			$item = $data['items'];
		}
		foreach ($item as $item1) {
			$data['item_details'] = $this->m_mir->get_item_pack_rep_yt($from_date, $to_date, $item1['item_id']);
			$value = 12;
			$end_value = 1;
			$m_or_y = 'm';
			if ($month != 0) {
				$value = $month;
				$end_value = $month;
			}
			if ($term == '2') {
				$value = date('Y', strtotime($to_date));
				$end_value = date('Y', strtotime($from_date));
				$m_or_y = 'Y';
			}
			while ($value >= $end_value) {
				$pack_weight[$item1['item_id']][$value] = 0;
				$pack_cones[$item1['item_id']][$value] = 0;
				if ($data['item_details'] != null) {
					foreach ($data['item_details'] as $pack) {
						$pack_month = date($m_or_y, strtotime($pack['packed_date']));
						if ($pack_month == $value) {
							$pk_weight = round($pack['net_weight'], 2, PHP_ROUND_HALF_UP);
							$pack_cones[$item1['item_id']][$value] += $pack['no_of_cones'];
							$pack_weight[$item1['item_id']][$value] += $pk_weight;
							$data['tot_wt'] += $pk_weight;
							$data['tot_cones'] += $pack['no_of_cones'];
						}
					}
				}
				$value--;
			}
		}
		$grand_tot = $this->m_mir->getcolumn('bud_yt_packing_boxes', array('net_weight', 'item_id', 'no_of_cones'));
		$tot_wt = 0;
		$tot_cones = 0;
		foreach ($grand_tot as $key) {
			$tot_cones += $key['no_of_cones'];
			$tot_wt += round($key['net_weight'], 2, PHP_ROUND_HALF_UP);
		}

		$data['grand_tot_cones'] = $tot_cones;
		$data['grand_tot'] = $tot_wt;
		$data['pk_wt'] = $pack_weight;
		$data['pk_cone'] = $pack_cones;
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
		$this->load->view('v_1_item_pack_report', $data);
	}
	function cust_sales_report_1()
	{
		$data['activeTab'] = 'mir_reports';
		$data['activeItem'] = 'cust_sales_report_1';
		$data['page_title'] = 'Customer Sales Report -Yarns And Threads -CSR';
		$pre_yr = date('Y');
		$pre_yr = $pre_yr - 1;
		$data['f_date'] = (date('m') < 4) ? date("d-m-Y", strtotime('01-04-' . $pre_yr)) : date("d-m-Y", strtotime('01-04-' . date('Y')));
		$data['t_date'] = date("d-m-Y");
		$data['customer'] = 0;
		$data['month'] = 0;
		$data['term'] = 0;
		$month = 0;
		$term = 0;
		$customer = array();
		$from_date = $data['f_date'];
		$to_date = date("Y-m-d");
		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
			$term = $this->input->post('term');
			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			$data['term'] = $term;
			$data['customer'] = $this->input->post('customer_id');
			$customer = $this->m_masters->getcustomerdetails($data['customer']);
			$data['month'] = $this->input->post('month');
			$month = $data['month'];
			$where_array = array(
				'invoice_date >=' => $from_date,
				'invoice_date <=' => $to_date
			);
		}
		$data['customers'] = $this->m_mir->getalldata_odr_field_name('bud_customers', 'cust_status', 'cust_name');
		$data['tot_inv_amt'] = 0;
		if ($customer == null) {
			$customer = $data['customers'];
		}
		foreach ($customer as $cust) {
			$data['invoices'] = $this->m_mir->get_rep_datas($from_date, $to_date, array('customer' => $cust['cust_id']), array('sub_total', 'customer', 'invoice_date'), 'bud_yt_invoices', 'invoice_date');
			$value = 12;
			$end_value = 1;
			$m_or_y = 'm';
			if ($month != 0) {
				$value = $month;
				$end_value = $month;
			}
			if ($term == '2') {
				$value = date('Y', strtotime($to_date));
				$end_value = date('Y', strtotime($from_date));
				$m_or_y = 'Y';
			}
			while ($value >= $end_value) {
				$inv_cust_amt[$cust['cust_id']][$value] = 0;
				$inv_cust_num[$cust['cust_id']][$value] = 0;
				if ($data['invoices'] != null) {
					foreach ($data['invoices'] as $invoice) {
						$inv_month = date($m_or_y, strtotime($invoice['invoice_date']));
						if ($inv_month == $value) {
							$inv_cust_amt[$cust['cust_id']][$value] += $invoice['sub_total'];
							$inv_cust_num[$cust['cust_id']][$value] += 1;
							$data['tot_inv_amt'] += $invoice['sub_total'];
						}
					}
					$inv_amt = (string) $inv_cust_amt[$cust['cust_id']][$value];
					$len = strlen($inv_amt);
					if ($len > 3) {
						$len -= 3;
						$inv_amt = substr_replace($inv_amt, ',', $len, 0);

						while ($len > 2) {
							$len -= 2;
							$inv_amt = substr_replace($inv_amt, ',', $len, 0);
						}
					}
					$inv_cust_amt[$cust['cust_id']][$value] = $inv_amt;
				}
				$value--;
			}
		}
		$tot_amt = (string) $data['tot_inv_amt'];
		$len = strlen($tot_amt);
		if ($len > 3) {
			$len -= 3;
			$tot_amt = substr_replace($tot_amt, ',', $len, 0);

			while ($len > 2) {
				$len -= 2;
				$tot_amt = substr_replace($tot_amt, ',', $len, 0);
			}
		}
		$grand_tot = $this->m_mir->getcolumn('bud_yt_invoices', 'sub_total');
		$tot = 0;
		foreach ($grand_tot as $key) {
			$tot += $key['sub_total'];
		}
		$tot = (string) $tot;
		$len = strlen($tot);
		if ($len > 3) {
			$len -= 3;
			$tot = substr_replace($tot, ',', $len, 0);
			while ($len > 2) {
				$len -= 2;
				$tot = substr_replace($tot, ',', $len, 0);
			}
		}
		$data['grand_tot'] = $tot;
		$data['tot_inv_amt'] = $tot_amt;
		$data['inv_cust_amt'] = $inv_cust_amt;
		$data['inv_cust_num'] = $inv_cust_num;
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
		$this->load->view('v_1_cust_sales_report', $data);
	}
	//zipper 3.0 lbl-isr,ipr,csr
	function cust_sales_report_3()
	{
		$data['activeTab'] = 'mir_reports';
		$data['activeItem'] = 'cust_sales_report_3';
		$data['page_title'] = 'Customer Wise Sales Report-Labels-CSR';
		$data['catagory'] = 'lbl';
		$pre_yr = date('Y');
		$pre_yr = $pre_yr - 1;
		$data['f_date'] = (date('m') < 4) ? date("d-m-Y", strtotime('01-04-' . $pre_yr)) : date("d-m-Y", strtotime('01-04-' . date('Y')));
		$data['t_date'] = date("d-m-Y");
		$data['cust_id'] = 0;
		$data['cust'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['month'] = 0;
		$data['term'] = 1;
		$month = 0;
		$term = 1;
		$customer = array();
		$from_date = $data['f_date'];
		$to_date = date("Y-m-d");
		$data['item_detail']['tot_invs'] = 0;
		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
			$term = $this->input->post('term');
			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			$data['term'] = $term;
			$data['cust_id'] = $this->input->post('cust_id');
			$data['month'] = $this->input->post('month');
			$month = $data['month'];
			$where_array = array(
				'invoice_date >=' => $from_date,
				'invoice_date <=' => $to_date
			);
			if ($term == '1') {
				$tyear = date("Y", strtotime($to_date));
				$fyear = date("Y", strtotime($from_date));
				if ($tyear != $fyear) {
					$year = ($month > 3) ? $fyear : $tyear;
				}
				$year = $tyear;
				if ($month != '0') {
					if ($month < 10) {
						$date = '01-0' . $month . '-' . $year;
					}
					$date = '01-' . $month . '-' . $year;
					$from_date = date("Y-m-d", strtotime($date));
					$to_date = date("Y-m-t", strtotime($date));
				}
			}
			$data['item_detail'] = $this->m_mir->get_cust_sales_rep_lbl($from_date, $to_date, $data['cust_id'], $term, $month);
			$data['grand_item_detail'] = $this->m_mir->get_cust_sales_rep_lbl(null, null, 0, $term, null);
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
		$this->load->view('v_3_cust_sales_report', $data);
	}
	function item_sales_report_3()
	{
		$data['activeTab'] = 'mir_reports';
		$data['activeItem'] = 'item_sales_report_3';
		$data['page_title'] = 'Item Wise Sales Report-Labels-ISR';
		$data['catagory'] = 'lbl';
		$pre_yr = date('Y');
		$pre_yr = $pre_yr - 1;
		$data['f_date'] = (date('m') < 4) ? date("d-m-Y", strtotime('01-04-' . $pre_yr)) : date("d-m-Y", strtotime('01-04-' . date('Y')));
		$data['t_date'] = date("d-m-Y");
		$data['item_id'] = 0;
		$data['items'] = $this->m_masters->getactivemaster('bud_lbl_items', 'item_status');
		$data['cust_id'] = 0;
		$data['cust'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['month'] = 0;
		$data['term'] = 1;
		$month = 0;
		$term = 1;
		$customer = array();
		$from_date = $data['f_date'];
		$to_date = date("Y-m-d");
		$data['item_detail']['tot_invs'] = 0;
		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
			$term = $this->input->post('term');
			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			$data['term'] = $term;
			$data['item_id'] = $this->input->post('item_id');
			$data['cust_id'] = $this->input->post('cust_id');
			$data['month'] = $this->input->post('month');
			$month = $data['month'];
			$where_array = array(
				'invoice_date >=' => $from_date,
				'invoice_date <=' => $to_date
			);
			if ($term == '1') {
				$tyear = date("Y", strtotime($to_date));
				$fyear = date("Y", strtotime($from_date));
				if ($tyear != $fyear) {
					$year = ($month > 3) ? $fyear : $tyear;
				}
				$year = $tyear;
				if ($month != '0') {
					if ($month < 10) {
						$date = '01-0' . $month . '-' . $year;
					}
					$date = '01-' . $month . '-' . $year;
					$from_date = date("Y-m-d", strtotime($date));
					$to_date = date("Y-m-t", strtotime($date));
				}
			}
			$data['item_detail'] = $this->m_mir->get_item_sales_rep_lbl($from_date, $to_date, $data['item_id'], $data['cust_id'], $term, $month);
			$data['grand_item_detail'] = $this->m_mir->get_item_sales_rep_lbl(null, null, 0, 0, $term, null);
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
		$this->load->view('v_3_item_sales_report', $data);
	}
	function item_pack_report_3()
	{
		$data['activeTab'] = 'mir_reports';
		$data['activeItem'] = 'item_pack_report_3';
		$data['page_title'] = 'Item Packing Report-Labels-IPR';
		$data['catagory'] = 'lbl';
		$pre_yr = date('Y');
		$pre_yr = $pre_yr - 1;
		$data['f_date'] = (date('m') < 4) ? date("d-m-Y", strtotime('01-04-' . $pre_yr)) : date("d-m-Y", strtotime('01-04-' . date('Y')));
		$data['t_date'] = date("d-m-Y");
		$data['item_id'] = 0;
		$data['items'] = $this->m_masters->getactivemaster('bud_lbl_items', 'item_status');
		$data['month'] = 0;
		$data['term'] = 1;
		$month = 0;
		$term = 1;
		$customer = array();
		$from_date = $data['f_date'];
		$to_date = date("Y-m-d");
		$data['item_detail']['tot_box'] = 0;
		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
			$term = $this->input->post('term');
			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			$data['term'] = $term;
			$data['item_id'] = $this->input->post('item_id');
			$data['month'] = $this->input->post('month');
			$month = $data['month'];
			$where_array = array(
				'invoice_date >=' => $from_date,
				'invoice_date <=' => $to_date
			);
			if ($term == '1') {
				$tyear = date("Y", strtotime($to_date));
				$fyear = date("Y", strtotime($from_date));
				if ($tyear != $fyear) {
					$year = ($month > 3) ? $fyear : $tyear;
				}
				$year = $tyear;
				if ($month != '0') {
					if ($month < 10) {
						$date = '01-0' . $month . '-' . $year;
					}
					$date = '01-' . $month . '-' . $year;
					$from_date = date("Y-m-d", strtotime($date));
					$to_date = date("Y-m-t", strtotime($date));
				}
			}
			$data['item_detail'] = $this->m_mir->get_item_packing_rep_lbl($from_date, $to_date, $data['item_id'], $term, $month);
			$data['grand_item_detail'] = $this->m_mir->get_item_packing_rep_lbl(null, null, 0, $term, null);
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
		$this->load->view('v_3_item_pack_report', $data);
	}
	// end of ISR,IPR & CSR Reports

	//Abstract Report Labels
	function abstract_report_3()
	{
		$data['activeTab'] = 'mir_reports';
		$data['activeItem'] = 'abstract_report_3';
		$data['page_title'] = 'Abstract Report-Labels-AR';
		$data['catagory'] = 'lbl';
		$data['term'] = 2;
		$data['month'] = 0;
		$data['year'] = 0;
		$month = 0;
		$term = 2;
		$year = 0;
		if (isset($_POST['search'])) {
			$term = $this->input->post('term');
			$month = $this->input->post('month');
			$year = $this->input->post('year');
			$data['term'] = $term;
			$data['year'] = $year;
			$data['month'] = $month;
		}
		$data['item_detail'] = $this->m_mir->get_abstract_rep_lbl($term, $month, $year);
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
		$this->load->view('v_3_abstract_report', $data);
	}
	//end of Abstract Report Labels
	//Abstract Report Tapes
	function abstract_report_2()
	{
		$data['activeTab'] = 'mir_reports';
		$data['activeItem'] = 'abstract_report_2';
		$data['page_title'] = 'Abstract Report-Tapes-AR';
		$data['catagory'] = 'te';
		$data['term'] = 2;
		$data['month'] = 0;
		$data['year'] = 0;
		$month = 0;
		$term = 2;
		$year = 0;
		if (isset($_POST['search'])) {
			$term = $this->input->post('term');
			$month = $this->input->post('month');
			$year = $this->input->post('year');
			$data['term'] = $term;
			$data['year'] = $year;
			$data['month'] = $month;
		}
		$data['item_detail'] = $this->m_mir->get_abstract_rep_te($term, $month, $year);
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
		$this->load->view('v_2_abstract_report', $data);
	}
	//end of Abstract Report Tapes
	//Dyeing Reports
	function dyeing_sent_items_1()
	{
		$data['activeTab'] = 'mir_reports';
		$data['activeItem'] = 'dyeing_sent_items_1';
		$data['page_title'] = 'Items Sent for Dyeing-(Yarns & Threads)';
		$data['catagory'] = 'yt';
		$pre_yr = date('Y');
		$pre_yr = $pre_yr - 1;
		$data['f_date'] = (date('m') < 4) ? date("d-m-Y", strtotime('01-04-' . $pre_yr)) : date("d-m-Y", strtotime('01-04-' . date('Y')));
		$data['t_date'] = date("d-m-Y");
		$data['item_id'] = 0;
		$data['items'] = $this->m_masters->getactivemaster('bud_items', 'item_status');
		$data['item'] = 0;
		$data['month'] = 0;
		$data['term'] = 1;
		$month = 0;
		$term = 1;
		$customer = array();
		$from_date = $data['f_date'];
		$to_date = date("Y-m-d");
		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
			$term = $this->input->post('term');
			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			$data['term'] = $term;
			$data['item_id'] = $this->input->post('item_id');
			$data['month'] = $this->input->post('month');
			$month = $data['month'];
			$where_array = array(
				'invoice_date >=' => $from_date,
				'invoice_date <=' => $to_date
			);
		}
		if ($term == '1') {
			$tyear = date("Y", strtotime($to_date));
			$fyear = date("Y", strtotime($from_date));
			if ($tyear != $fyear) {
				$year = ($month > 3) ? $fyear : $tyear;
			}
			$year = $tyear;
			if ($month != '0') {
				if ($month < 10) {
					$date = '01-0' . $month . '-' . $year;
				}
				$date = '01-' . $month . '-' . $year;
				$from_date = date("Y-m-d", strtotime($date));
				$to_date = date("Y-m-t", strtotime($date));
			}
		}
		$data['item_detail'] = $this->m_mir->get_item_sent_dyeing_yt($from_date, $to_date, $data['item_id'], $term, 1);
		$grand_tot = $this->m_mir->get_item_sent_dyeing_yt($term);
		$data['grand_tot_nwt'] = $grand_tot['tot_nweight'];
		$data['grand_tot_gwt'] = $grand_tot['tot_gweight'];
		$data['grand_tot_cones'] = $grand_tot['tot_cones'];
		$data['grand_tot_boxes'] = $grand_tot['tot_boxes'];
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
		$this->load->view('v_1_dyeing_sent_items_report', $data);
	}
	function dyeing_sent_dcs_1()
	{
		$data['activeTab'] = 'mir_reports';
		$data['activeItem'] = 'dyeing_sent_items_1';
		$data['page_title'] = 'Dyeing DCs-(Yarns & Threads)';
		$data['catagory'] = 'yt';
		$pre_yr = date('Y');
		$pre_yr = $pre_yr - 1;
		$data['f_date'] = (date('m') < 4) ? date("d-m-Y", strtotime('01-04-' . $pre_yr)) : date("d-m-Y", strtotime('01-04-' . date('Y')));
		$data['t_date'] = date("d-m-Y");
		$data['item_id'] = 0;
		$data['items'] = $this->m_masters->getactivemaster('bud_items', 'item_status');
		$data['item'] = 0;
		$data['month'] = 0;
		$data['term'] = 1;
		$month = 0;
		$term = 1;
		$customer = array();
		$from_date = $data['f_date'];
		$to_date = date("Y-m-d");
		if (!($this->uri->segment(3) === FALSE)) {
			/*$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
			$term = $this->input->post('term');
			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			$data['term'] = $term;
			$data['item_id']=$this->input->post('item_id');
			$data['month']=$this->input->post('month');*/
			$idata = (explode('-', $this->uri->segment(3)));
			$data['item_id'] = $idata['0'];
			$data['term'] = $idata['1'];
			if ($data['term'] == 1) {
				$data['month'] = date("m", strtotime($idata['2']));
				$data['year'] = $idata['3'];
				$date = '01-' . $data['month'] . '-20' . $data['year'];
				$from_date = date("Y-m-d", strtotime($date));
				$to_date = date("Y-m-t", strtotime($date));
			} else {
				$data['month'] = '00';
				$data['year'] = $idata['2'];
				$date1 = '01-01-' . $data['year'];
				$date2 = '01-12-' . $data['year'];
				$from_date = date("Y-m-d", strtotime($date1));
				$to_date = date("Y-m-t", strtotime($date2));
			}
			$term = $data['term'];
			$month = $data['month'];
			$year = $data['year'];
		}

		$data['f_date'] = $from_date;
		$data['t_date'] = $to_date;
		$data['item_detail'] = $this->m_mir->get_item_sent_dyeing_dcs_yt($from_date, $to_date, $data['item_id'], $term);
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
		$this->load->view('v_1_dyeing_sent_dcs_report', $data);
	}
	function dyeinglots_against_po_1()
	{
		$data['activeTab'] = 'mir_reports';
		$data['activeItem'] = 'dyeing_sent_items_1';
		$data['page_title'] = 'Dyeing Lots Against PO-(Yarns & Threads)';
		$data['catagory'] = 'yt';
		$pre_yr = date('Y');
		$pre_yr = $pre_yr - 1;
		$data['f_date'] = (date('m') < 4) ? date("d-m-Y", strtotime('01-04-' . $pre_yr)) : date("d-m-Y", strtotime('01-04-' . date('Y')));
		$data['t_date'] = date("d-m-Y");
		$data['item_id'] = 0;
		$data['shade_no'] = 0;
		/*$data['item']=0;
		$data['month']=0;
		$data['term']=1;
		$month=0;
		$term=1;
		$customer=array();*/
		$from_date = $data['f_date'];
		$to_date = date("Y-m-d");
		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
			//$term = $this->input->post('term');
			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			//$data['term'] = $term;
			$data['item_id'] = $this->input->post('item_id');
			$data['shade_no'] = $this->input->post('shade_no');
			//$data['month']=$this->input->post('month');
		}
		/*if ($term=='1') {
			$tyear=date("Y", strtotime($to_date));
			$fyear=date("Y", strtotime($from_date));
			if($tyear!=$fyear){
				$year=($month>3)?$fyear:$tyear;
			}
			$year=$tyear;
			if(!empty($month))
			{
				$date='01-'.$month.'-'.$year;
				$from_date=date("Y-m-d", strtotime($date));
				$to_date=date("Y-m-t", strtotime($date));
			}
			$data['f_date']=$from_date;
			$data['t_date']=$to_date;
		}	I*/
		$data['rows'] = $this->m_mir->dyed_against_po($from_date, $to_date, $data['item_id'], $data['shade_no']);
		$grand_tot = $this->m_mir->dyed_against_po();
		$data['grand_p_qty'] = $grand_tot['tot_p_qty'];
		//$data['grand_p_qty']=0;
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
		$this->load->view('v_1_dyeinglots_against_po', $data);
	}
	function dyeing_prod_rep_1()
	{
		$data['activeTab'] = 'mir_reports';
		$data['activeItem'] = 'dyeing_sent_items_1';
		$data['page_title'] = 'Lot Wise Production Report(incl.Dyeing)';
		$data['catagory'] = 'yt';
		$pre_yr = date('Y');
		$pre_yr = $pre_yr - 1;
		$data['f_date'] = (date('m') < 4) ? date("d-m-Y", strtotime('01-04-' . $pre_yr)) : date("d-m-Y", strtotime('01-04-' . date('Y')));
		$data['t_date'] = date("d-m-Y");
		$data['item_id'] = 0;
		$data['shade_no'] = 0;
		$data['machine_prefix'] = 0;
		$data['rows'] = array();
		/*$data['item']=0;
		$data['month']=0;
		$data['term']=1;
		$month=0;
		$term=1;
		$customer=array();*/
		$from_date = $data['f_date'];
		$to_date = date("Y-m-d");
		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
			//$term = $this->input->post('term');
			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			//$data['term'] = $term;
			$data['item_id'] = $this->input->post('item_id');
			$data['shade_no'] = $this->input->post('shade_no');
			$data['machine_prefix'] = $this->input->post('machine_prefix');
			//$data['month']=$this->input->post('month');
			/*if ($term=='1') {
				$tyear=date("Y", strtotime($to_date));
				$fyear=date("Y", strtotime($from_date));
				if($tyear!=$fyear){
					$year=($month>3)?$fyear:$tyear;
				}
				$year=$tyear;
				if(!empty($month))
				{
					$date='01-'.$month.'-'.$year;
					$from_date=date("Y-m-d", strtotime($date));
					$to_date=date("Y-m-t", strtotime($date));
				}
				$data['f_date']=$from_date;
				$data['t_date']=$to_date;
			}*/
			$data['rows'] = $this->m_mir->dyeing_prod($from_date, $to_date, $data['item_id'], $data['shade_no'], $data['machine_prefix']);
		}
		/*$grand_tot=$this->m_mir->dyeing_prod();
		$data['grand_p_qty']=$grand_tot['tot_p_qty'];
		$data['grand_box_net_qty']=round(array_sum($grand_tot['box_net_weight']),2);
        $data['grand_exess_qty']=array_sum($grand_tot['exess_qty']);
        $data['grand_bal_qty']=array_sum($grand_tot['bal_qty']);
		$data['grand_box_num']=array_sum($grand_tot['box_num']);*/
		//$data['grand_p_qty']=0;
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
		$this->load->view('v_1_dyeing_prod', $data);
	}
	function bal_in_dyeing_1()
	{
		$data['activeTab'] = 'mir_reports';
		$data['activeItem'] = 'dyeing_sent_items_1';
		$data['page_title'] = 'Balance Stock In Dyeing (Yarn-Zip & All Materials)';
		$data['catagory'] = 'yt';
		$pre_yr = date('Y');
		$pre_yr = $pre_yr - 1;
		$data['f_date'] = (date('m') < 4) ? date("d-m-Y", strtotime('01-04-' . $pre_yr)) : date("d-m-Y", strtotime('01-04-' . date('Y')));
		$data['t_date'] = date("d-m-Y");
		$data['item_id'] = 0;
		$data['shade_no'] = 0;
		$data['machine_prefix'] = 0;
		$data['item'] = 0;
		$data['month'] = 0;
		$data['term'] = 1;
		$month = 0;
		$term = 1;
		$from_date = $data['f_date'];
		$to_date = date("Y-m-d");
		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
			$term = $this->input->post('term');
			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			$data['term'] = $term;
			$data['item_id'] = $this->input->post('item_id');
			$data['shade_no'] = $this->input->post('shade_no');
			$data['machine_prefix'] = $this->input->post('machine_prefix');
			$data['month'] = $this->input->post('month');
			$month = $data['month'];
		}
		if ($term == '1') {
			$tyear = date("Y", strtotime($to_date));
			$fyear = date("Y", strtotime($from_date));
			if ($tyear != $fyear) {
				$year = ($month > 3) ? $fyear : $tyear;
			}
			$year = $tyear;
			if (!empty($month)) {
				$date = '01-' . $month . '-' . $year;
				$from_date = date("Y-m-d", strtotime($date));
				$to_date = date("Y-m-t", strtotime($date));
			}
			$data['f_date'] = $from_date;
			$data['t_date'] = $to_date;
		}
		$data['rows'] = $this->m_mir->get_item_sent_dyeing_yt($from_date, $to_date, $data['item_id'], $term, 2);
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
		$this->load->view('v_1_bal_in_dyeing_report', $data);
	}
	function dyeing_lots_1()
	{
		$data['activeTab'] = 'mir_reports';
		$data['activeItem'] = 'dyeing_lots_1';
		$data['page_title'] = 'Dyeing Lot Report-(Yarns & Threads)';
		$data['catagory'] = 'yt';
		$pre_yr = date('Y');
		$pre_yr = $pre_yr - 1;
		$data['f_date'] = (date('m') < 4) ? date("d-m-Y", strtotime('01-04-' . $pre_yr)) : date("d-m-Y", strtotime('01-04-' . date('Y')));
		$data['t_date'] = date("d-m-Y");
		$data['item_id'] = 0;
		$data['shade_no'] = 0;
		$data['machine_prefix'] = 0;
		$data['item'] = 0;
		$data['month'] = 0;
		$data['term'] = 1;
		$month = 0;
		$term = 1;
		$from_date = $data['f_date'];
		$to_date = date("Y-m-d");
		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
			$term = $this->input->post('term');
			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			$data['term'] = $term;
			$data['item_id'] = $this->input->post('item_id');
			$data['shade_no'] = $this->input->post('shade_no');
			$data['machine_prefix'] = $this->input->post('machine_prefix');
			$data['month'] = $this->input->post('month');
			$month = $data['month'];
		}
		if ($term == '1') {
			$tyear = date("Y", strtotime($to_date));
			$fyear = date("Y", strtotime($from_date));
			if ($tyear != $fyear) {
				$year = ($month > 3) ? $fyear : $tyear;
			}
			$year = $tyear;
			if (!empty($month)) {
				$date = '01-' . $month . '-' . $year;
				$from_date = date("Y-m-d", strtotime($date));
				$to_date = date("Y-m-t", strtotime($date));
			}
			$data['f_date'] = $from_date;
			$data['t_date'] = $to_date;
		}
		$data['rows'] = $this->m_mir->m_lot_dyeing_yt($from_date, $to_date, $data['item_id'], $term, array());
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
		$this->load->view('v_1_dyeing_lot_report', $data);
	}
	//End of Dyeing Reports
	//Update boxes array in invoices - Labels
	function update_boxes_array_lbl()
	{
		$result = $this->m_mir->m_update_boxes_array_lbl();
		if ($result) {
			echo 'Update Successfully !!!!';
		} else {
			echo 'Not Updated';
		}
	}
	//end of Update boxes array in invoices- Labels
	//Production Report Labels
	function prd_report_3()
	{
		$data['activeTab'] = 'mir_reports';
		$data['activeItem'] = 'prd_report_3';
		$data['page_title'] = 'Production Report-Labels -PR';
		$data['catagory'] = 'lbl';
		$pre_yr = date('Y');
		$pre_yr = $pre_yr - 1;
		$data['f_date'] = (date('m') < 4) ? date("d-m-Y", strtotime('01-04-' . $pre_yr)) : date("d-m-Y", strtotime('01-04-' . date('Y')));
		$data['t_date'] = date("d-m-Y");
		$data['item_id'] = 0;
		$data['operator_id'] = 0;
		$data['machine_id'] = 0;
		$data['sample'] = 0;
		$data['shift'] = 0;
		$data['staffs'] = $this->m_masters->getactivemaster('bud_users', 'user_status');
		$data['items'] = $this->m_masters->getactivemaster('bud_lbl_items', 'item_status');
		$data['machines'] = $this->m_masters->getactivemaster('bud_te_machines', 'machine_status');
		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			$data['item_id'] = $this->input->post('item_id');
			$data['operator_id'] = $this->input->post('operator_id');
			$data['sample'] = $this->input->post('sample');
			$data['shift'] = $this->input->post('shift');
			$data['machine_id'] = $this->input->post('machine_id');
		}
		$filter['f_date'] = $data['f_date'];
		$filter['t_date'] = $data['t_date'];
		$filter['item_id'] = $data['item_id'];
		$filter['operator_id'] = $data['operator_id'];
		$filter['machine_id'] = $data['machine_id'];
		$filter['sample'] = $data['sample'];
		$filter['shift'] = $data['shift'];
		$data['prd_details'] = $this->m_mir->get_prd_rep_lbl($filter);
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
		$this->load->view('v_3_prd_report', $data);
	}
	//End of Production Report Labels
	//Creation of Pending DC
	function update_pending_dc_lbl()
	{
		$result = $this->m_mir->m_pending_dc_lbl();
		if ($result) {
			echo 'Update Successfully !!!!';
		} else {
			echo 'Not Updated';
		}
	}
	function update_pending_dc_te()
	{
		$result = $this->m_mir->m_pending_dc_te();
		if ($result) {
			echo 'Update Successfully !!!!';
		} else {
			echo 'Not Updated';
		}
	}
	function update_pending_dc_yt()
	{
		$result = $this->m_mir->m_pending_dc_yt();
		if ($result) {
			echo 'Update Successfully !!!!';
		} else {
			echo 'Not Updated';
		}
	}
	function update_pending_dc_sh()
	{
		$result = $this->m_mir->m_pending_dc_sh();
		if ($result) {
			echo 'Update Successfully !!!!';
		} else {
			echo 'Not Updated';
		}
	}
	//end of Creation of Pending DC
	//Creation of Pending DC
	function update_stock_lbl()
	{
		$result = $this->m_mir->m_stock_lbl();
		if ($result) {
			echo 'Update Successfully !!!!';
		} else {
			echo 'Not Updated';
		}
	}
	function update_stock_te()
	{
		$result = $this->m_mir->m_stock_te();
		if ($result) {
			echo 'Update Successfully !!!!';
		} else {
			echo 'Not Updated';
		}
	}
	function update_stock_yt()
	{
		$result = $this->m_mir->m_stock_yt();
		if ($result) {
			echo 'Update Successfully !!!!';
		} else {
			echo 'Not Updated';
		}
	}
	function update_stock_sh()
	{
		$result = $this->m_mir->m_stock_sh();
		if ($result) {
			echo 'Update Successfully !!!!';
		} else {
			echo 'Not Updated';
		}
	}
	//end of Creation of Pending DC
	//Tir Report for shop
	function tot_inw_report_4()
	{
		$data['activeTab'] = 'Mir_reports';
		$data['activeItem'] = 'tot_inw_report_4';
		$data['page_title'] = 'Total Inward Report-Shop-TIR';
		$data['catagory'] = 'yt';
		$month = 0;
		$term = 2;
		$year = 0;
		if ($this->uri->segment(3)) {
			$term = $this->uri->segment(3);
		}
		if ($this->uri->segment(4)) {
			$year = $this->uri->segment(4);
		}
		if (($this->uri->segment(5)) && ($term == 1)) {
			$month = $this->uri->segment(5);
		}
		if (isset($_POST['search'])) {
			$term = $this->input->post('term');
			$month = ($term == 2) ? 0 : $this->input->post('month');
			$year = $this->input->post('year');
		}
		$data['term'] = $term;
		$data['year'] = $year;
		$data['month'] = $month;
		$data['item_detail'] = $this->m_mir->get_tot_inw_rep_sh($term, $month, $year);
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
		$this->load->view('v_4_tot_inw_report', $data);
	}
	function tot_inw_item_wise_4()
	{
		$data['activeTab'] = 'Mir_reports';
		$data['activeItem'] = 'tot_inw_item_wise_4';
		$data['page_title'] = 'Item Wise TIR-Shop';
		$data['catagory'] = 'yt';
		if ($this->uri->segment(3)) {
			$term = $this->uri->segment(3);
		} else {
			$term = null;
		}
		if ($this->uri->segment(4)) {
			$term_value = $this->uri->segment(4);
		} else {
			$term_value = null;
		}
		$data['term'] = $term;
		if ($term == 2) {
			$from_date = $term_value . '-01-01';
			$to_date = $term_value . '-12-31';
			$data['year'] = $term_value;
			$data['month'] = 0;
		} elseif ($term == 1) {
			$from_date = date('Y-m-d', strtotime('01-' . $term_value));
			$to_date = date('Y-m-t', strtotime('01-' . $term_value));
			$data['month'] = date('m', strtotime('01-' . $term_value));
			$data['month'] = (int) $data['month'];
			$data['year'] = date('Y', strtotime('01-' . $term_value));
		}
		if ($this->uri->segment(5)) {
			$data['o_month'] = $this->uri->segment(5);
		} else {
			$data['o_month'] = null;
		}
		$data['item_detail'] = $this->m_mir->get_item_wise_inw_rep_sh($from_date, $to_date, $term);
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
		$this->load->view('v_4_item_wise_inw_report', $data);
	}
	//End of Tir Report for shop
	function tot_inw_box_wise_4()
	{
		$data['activeTab'] = 'Mir_reports';
		$data['activeItem'] = 'tot_inw_box_wise_4';
		$data['page_title'] = 'Box Wise TIR-Shop';
		$data['catagory'] = 'yt';
		if ($this->uri->segment(3)) {
			$item_id = $this->uri->segment(3);
		} else {
			$item_id = null;
		}
		if ($this->uri->segment(4)) {
			$term = $this->uri->segment(4);
		} else {
			$term = null;
		}
		if ($this->uri->segment(5)) {
			$term_value = $this->uri->segment(5);
		} else {
			$term_value = null;
		}
		$data['term'] = $term;
		if ($term == 2) {
			$from_date = $term_value . '-01-01';
			$to_date = $term_value . '-12-31';
			$data['year'] = $term_value;
			$data['month'] = 0;
		} elseif ($term == 1) {
			$month_value = ($this->uri->segment(6) < 10) ? '0' . $this->uri->segment(6) : $this->uri->segment(6);
			$from_date = date('Y-m-d', strtotime('01-' . $month_value . '-' . $term_value));
			$to_date = date('Y-m-t', strtotime('01-' . $month_value . '-' . $term_value));
			$data['month'] = date('m', strtotime('01-' . $month_value . '-' . $term_value));
			$data['month'] = (int) $data['month'];
			$data['year'] = date('Y', strtotime('01-' . $month_value . '-' . $term_value));
		}
		if ($this->uri->segment(6)) {
			$data['o_month'] = $this->uri->segment(6);
		} else {
			$data['o_month'] = null;
		}
		$data['form'] = 'inw';
		$data['box_detail'] = $this->m_mir->get_box_wise_inw_rep_sh($from_date, $to_date, $term, $item_id);
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
		$this->load->view('v_4_box_wise_inw_report', $data);
	}
	//End of Tir Report for shop
	//TOR-Value Report for Branch
	function tot_otw_report_4()
	{
		$data['activeTab'] = 'Mir_reports';
		$data['activeItem'] = 'tot_out_report_4';
		$data['page_title'] = 'Total Outward Report-Branch-TOR';
		$data['catagory'] = '';
		$month = 0;
		$term = 2;
		$year = 0;
		if (isset($_POST['search'])) {
			$term = $this->input->post('term');
			$month = ($term == 2) ? 0 : $this->input->post('month');
			$year = $this->input->post('year');
		}
		$data['term'] = $term;
		$data['year'] = $year;
		$data['month'] = $month;
		$data['item_detail'] = $this->m_mir->get_tot_otw_rep_sh($term, $month, $year);
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
		$this->load->view('v_4_tot_otw_report', $data);
	}
	function tot_otw_item_wise_4()
	{
		$data['activeTab'] = 'Mir_reports';
		$data['activeItem'] = 'tot_otw_item_wise_4';
		$data['page_title'] = 'Item Wise TOR-Shop';
		$data['catagory'] = 'yt';
		if ($this->uri->segment(3)) {
			$term = $this->uri->segment(3);
		} else {
			$term = null;
		}
		if ($this->uri->segment(4)) {
			$term_value = $this->uri->segment(4);
		} else {
			$term_value = null;
		}
		$data['term'] = $term;
		if ($term == 2) {
			$from_date = $term_value . '-01-01';
			$to_date = $term_value . '-12-31';
			$data['year'] = $term_value;
			$data['month'] = 0;
		} elseif ($term == 1) {
			$from_date = date('Y-m-d', strtotime('01-' . $term_value));
			$to_date = date('Y-m-t', strtotime('01-' . $term_value));
			$data['month'] = date('m', strtotime('01-' . $term_value));
			$data['month'] = (int) $data['month'];
			$data['year'] = date('Y', strtotime('01-' . $term_value));
		}
		if ($this->uri->segment(5)) {
			$data['o_month'] = $this->uri->segment(5);
		} else {
			$data['o_month'] = null;
		}
		$data['item_detail'] = $this->m_mir->get_item_wise_otw_rep_sh($from_date, $to_date, $term);
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
		$this->load->view('v_4_item_wise_otw_report', $data);
	}
	function tot_otw_box_wise_4()
	{
		$data['activeTab'] = 'Mir_reports';
		$data['activeItem'] = 'tot_otw_box_wise_4';
		$data['page_title'] = 'Box Wise TOR-Shop';
		$data['catagory'] = 'yt';
		if ($this->uri->segment(3)) {
			$item_id = $this->uri->segment(3);
		} else {
			$item_id = null;
		}
		if ($this->uri->segment(4)) {
			$term = $this->uri->segment(4);
		} else {
			$term = null;
		}
		if ($this->uri->segment(5)) {
			$term_value = $this->uri->segment(5);
		} else {
			$term_value = null;
		}
		$data['term'] = $term;
		if ($term == 2) {
			$from_date = $term_value . '-01-01';
			$to_date = $term_value . '-12-31';
			$data['year'] = $term_value;
			$data['month'] = 0;
		} elseif ($term == 1) {
			$month_value = ($this->uri->segment(6) < 10) ? '0' . $this->uri->segment(6) : $this->uri->segment(6);
			$from_date = date('Y-m-d', strtotime('01-' . $month_value . '-' . $term_value));
			$to_date = date('Y-m-t', strtotime('01-' . $month_value . '-' . $term_value));
			$data['month'] = date('m', strtotime('01-' . $month_value . '-' . $term_value));
			$data['month'] = (int) $data['month'];
			$data['year'] = date('Y', strtotime('01-' . $month_value . '-' . $term_value));
		}
		if ($this->uri->segment(6)) {
			$data['o_month'] = $this->uri->segment(6);
		} else {
			$data['o_month'] = null;
		}
		$data['box_detail'] = $this->m_mir->get_box_wise_otw_rep_sh($from_date, $to_date, $term, $item_id);
		$data['form'] = 'otw';
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
		$this->load->view('v_4_box_wise_inw_report', $data);
	}
	//TOR shop
	//TOR-Value Report for Tapes
	function tot_otw_report_2()
	{
		$data['activeTab'] = 'Mir_reports';
		$data['activeItem'] = 'tot_out_report_2';
		$data['page_title'] = 'Total Outward Report-Tapes-TOR';
		$data['catagory'] = '';
		$month = 0;
		$term = 2;
		$year = 0;
		if ($this->uri->segment(3)) {
			$term = $this->uri->segment(3);
		}
		if ($this->uri->segment(4)) {
			$term_value = $this->uri->segment(4);
			$data['term_value'] = $term_value;
			if ($term == 1) {
				$array = str_split($term_value, 1);
				$month = ($array[0]) ? $array[0] . $array[1] : '' . $array[1];
				$year = $array[3] . $array[4] . $array[5] . $array[6];
			}
		} else {
			$term_value = null;
		}
		$data['term'] = $term;

		if (isset($_POST['search'])) {
			$term = $this->input->post('term');
			$month = ($term == 2) ? 0 : $this->input->post('month');
			$year = $this->input->post('year');
		}
		$data['term'] = $term;
		$data['year'] = $year;
		$data['month'] = $month;
		$data['item_detail'] = $this->m_mir->get_tot_otw_rep_te($term, $month, $year);
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
		$this->load->view('v_2_tot_otw_report', $data);
	}
	function tot_otw_item_wise_2()
	{
		$data['activeTab'] = 'Mir_reports';
		$data['activeItem'] = 'tot_otw_item_wise_2';
		$data['page_title'] = 'Item Wise TOR-tapes';
		$data['catagory'] = 'yt';
		if ($this->uri->segment(3)) {
			$term = $this->uri->segment(3);
		} else {
			$term = null;
		}
		if ($this->uri->segment(4)) {
			$term_value = $this->uri->segment(4);
		} else {
			$term_value = null;
		}
		$data['term'] = $term;
		$data['term_value'] = $term_value;
		if ($term == 2) {
			$from_date = $term_value . '-01-01';
			$to_date = $term_value . '-12-31';
			$data['year'] = $term_value;
			$data['month'] = 0;
		} elseif ($term == 1) {
			$from_date = date('Y-m-d', strtotime('01-' . $term_value));
			$to_date = date('Y-m-t', strtotime('01-' . $term_value));
			$data['month'] = date('m', strtotime('01-' . $term_value));
			$data['month'] = (int) $data['month'];
			$data['year'] = date('Y', strtotime('01-' . $term_value));
		}
		if ($this->uri->segment(5)) {
			$data['o_month'] = $this->uri->segment(5);
		} else {
			$data['o_month'] = null;
		}
		$data['item_detail'] = $this->m_mir->get_item_wise_otw_rep_te($from_date, $to_date, $term);
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
		$this->load->view('v_2_item_wise_otw_report', $data);
	}
	function tot_otw_box_wise_2()
	{
		$data['activeTab'] = 'Mir_reports';
		$data['activeItem'] = 'tot_otw_box_wise_2';
		$data['page_title'] = 'Box Wise TOR-Tapes';
		$data['catagory'] = 'te';
		if ($this->uri->segment(3)) {
			$item_id = $this->uri->segment(3);
		} else {
			$item_id = null;
		}
		if ($this->uri->segment(4)) {
			$term = $this->uri->segment(4);
		} else {
			$term = null;
		}
		if ($this->uri->segment(5)) {
			$term_value = $this->uri->segment(5);
		} else {
			$term_value = null;
		}
		$data['term'] = $term;
		$data['term_value'] = $term_value;
		if ($term == 2) {
			$from_date = $term_value . '-01-01';
			$to_date = $term_value . '-12-31';
			$data['year'] = $term_value;
			$data['month'] = 0;
		} elseif ($term == 1) {
			$from_date = date('Y-m-d', strtotime('01-' . $term_value));
			$to_date = date('Y-m-t', strtotime('01-' . $term_value));
			$data['month'] = date('m', strtotime('01-' . $term_value));
			$data['month'] = (int) $data['month'];
			$data['year'] = date('Y', strtotime('01-' . $term_value));
		}
		$data['box_detail'] = $this->m_mir->get_box_wise_otw_rep_te($from_date, $to_date, $term, $item_id);
		$data['form'] = 'otw';
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
		$this->load->view('v_2_box_wise_inw_report', $data);
	}
	//TOR Tapes
	//TOR-Value Report for Tapes
	function tot_otw_report_3()
	{
		$data['activeTab'] = 'Mir_reports';
		$data['activeItem'] = 'tot_out_report_3';
		$data['page_title'] = 'Total Outward Report-Labels-TOR';
		$data['catagory'] = '';
		$month = 0;
		$term = 2;
		$year = 0;
		if ($this->uri->segment(3)) {
			$term = $this->uri->segment(3);
		}
		if ($this->uri->segment(4)) {
			$term_value = $this->uri->segment(4);
			$data['term_value'] = $term_value;
			if ($term == 1) {
				$array = str_split($term_value, 1);
				$month = ($array[0]) ? $array[0] . $array[1] : '' . $array[1];
				$year = $array[3] . $array[4] . $array[5] . $array[6];
			}
		} else {
			$term_value = null;
		}
		$data['term'] = $term;

		if (isset($_POST['search'])) {
			$term = $this->input->post('term');
			$month = ($term == 2) ? 0 : $this->input->post('month');
			$year = $this->input->post('year');
		}
		$data['term'] = $term;
		$data['year'] = $year;
		$data['month'] = $month;
		$data['item_detail'] = $this->m_mir->get_tot_otw_rep_lbl($term, $month, $year);
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
		$this->load->view('v_3_tot_otw_report', $data);
	}
	function tot_otw_item_wise_3()
	{
		$data['activeTab'] = 'Mir_reports';
		$data['activeItem'] = 'tot_otw_item_wise_3';
		$data['page_title'] = 'Item Wise TOR-Labels';
		$data['catagory'] = 'yt';
		if ($this->uri->segment(3)) {
			$term = $this->uri->segment(3);
		} else {
			$term = null;
		}
		if ($this->uri->segment(4)) {
			$term_value = $this->uri->segment(4);
		} else {
			$term_value = null;
		}
		$data['term'] = $term;
		$data['term_value'] = $term_value;
		if ($term == 2) {
			$from_date = $term_value . '-01-01';
			$to_date = $term_value . '-12-31';
			$data['year'] = $term_value;
			$data['month'] = 0;
		} elseif ($term == 1) {
			$from_date = date('Y-m-d', strtotime('01-' . $term_value));
			$to_date = date('Y-m-t', strtotime('01-' . $term_value));
			$data['month'] = date('m', strtotime('01-' . $term_value));
			$data['month'] = (int) $data['month'];
			$data['year'] = date('Y', strtotime('01-' . $term_value));
		}
		if ($this->uri->segment(5)) {
			$data['o_month'] = $this->uri->segment(5);
		} else {
			$data['o_month'] = null;
		}
		$data['item_detail'] = $this->m_mir->get_item_wise_otw_rep_lbl($from_date, $to_date, $term);
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
		$this->load->view('v_3_item_wise_otw_report', $data);
	}
	function tot_otw_box_wise_3()
	{
		$data['activeTab'] = 'Mir_reports';
		$data['activeItem'] = 'tot_otw_box_wise_3';
		$data['page_title'] = 'Box Wise TOR-Labels';
		$data['catagory'] = 'te';
		if ($this->uri->segment(3)) {
			$item_id = $this->uri->segment(3);
		} else {
			$item_id = null;
		}
		if ($this->uri->segment(4)) {
			$term = $this->uri->segment(4);
		} else {
			$term = null;
		}
		if ($this->uri->segment(5)) {
			$term_value = $this->uri->segment(5);
		} else {
			$term_value = null;
		}
		$data['term'] = $term;
		$data['term_value'] = $term_value;
		if ($term == 2) {
			$from_date = $term_value . '-01-01';
			$to_date = $term_value . '-12-31';
			$data['year'] = $term_value;
			$data['month'] = 0;
		} elseif ($term == 1) {
			$from_date = date('Y-m-d', strtotime('01-' . $term_value));
			$to_date = date('Y-m-t', strtotime('01-' . $term_value));
			$data['month'] = date('m', strtotime('01-' . $term_value));
			$data['month'] = (int) $data['month'];
			$data['year'] = date('Y', strtotime('01-' . $term_value));
		}
		$data['outerboxes'] = $this->m_mir->get_box_wise_otw_rep_lbl($from_date, $to_date, $term, $item_id);
		$data['form'] = 'otw';
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
		$this->load->view('v_3_box_wise_inw_report', $data);
	}
	//TOR labels
	//issue with moving back data to predelivery
	function moving_back_data_to_predel()
	{
		$result = $this->m_mir->m_moving_back_data_to_predel_sh();
		if ($result) {
			echo 'Update Successfully !!!!';
		} else {
			echo 'Not Updated';
		}
	}
	//end of issue with moving back data to predelivery
	//IRR Reports
	function irr_report()
	{
		$data['activeTab'] = 'mir_reports';
		$data['activeItem'] = 'irr_report';
		$data['page_title'] = 'IRR Report Yarns & Threads';
		$data['catagory'] = 'yt';
		$data['item_id'] = 0;
		$data['cust_id'] = 0;
		$data['shade_id'] = 0;
		$data['family_id'] = 0;
		$data['category_id'] = 0;
		$data['items'] = $this->m_masters->getactivemaster('bud_items', 'item_status');
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['shades'] = $this->m_masters->getactivemaster('bud_shades', 'shade_status');
		$data['shade_family'] = $this->m_masters->getactivemaster('bud_color_families', 'family_status');
		$data['shade_category'] = $this->m_masters->getallmaster('bud_color_category');
		if (isset($_POST['search'])) {
			$data['item_id'] = $this->input->post('item_id');
			$data['cust_id'] = $this->input->post('cust_id');
			$data['shade_id'] = $this->input->post('shade_id');
			$data['family_id'] = $this->input->post('family_id');
			$data['category_id'] = $this->input->post('category_id');
		}
		$filter['item_id'] = $data['item_id'];
		$filter['cust_id'] = $data['cust_id'];
		$filter['shade_id'] = $data['shade_id'];
		$filter['family_id'] = $data['family_id'];
		$filter['category_id'] = $data['category_id'];
		$data['irr_details'] = $this->m_mir->get_irr_details($filter);
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
		$this->load->view('v_irr_report', $data);
	}
	//End of IRR Reports
	//IRR Repports Tapes
	function irr_report_2()
	{
		$data['activeTab'] = 'mir_reports';
		$data['activeItem'] = 'irr_report_2';
		$data['page_title'] = 'IRR Report Tapes';
		$data['catagory'] = 'te';
		$data['item_id'] = 0;
		$data['cust_id'] = 0;
		$data['item_group_id'] = 0;
		$data['items'] = $this->m_masters->getactivemaster('bud_te_items', 'item_status');
		$data['item_groups'] = $this->m_masters->getactivemaster('bud_te_itemgroups', 'group_status');
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		if (isset($_POST['search'])) {
			$data['item_id'] = $this->input->post('item_id');
			$data['cust_id'] = $this->input->post('cust_id');
			$data['item_group_id'] = $this->input->post('item_group_id');
		}
		$filter['item_id'] = $data['item_id'];
		$filter['cust_id'] = $data['cust_id'];
		$filter['item_group_id'] = $data['item_group_id'];
		$data['irr_details'] = $this->m_mir->get_irr_2_details($filter);
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
		$this->load->view('v_2_irr_report', $data);
	}
	//End of IRR Reports Tapes
	//IRR Reports Labels
	function irr_report_3()
	{
		$data['activeTab'] = 'mir_reports';
		$data['activeItem'] = 'irr_report_3';
		$data['page_title'] = 'IRR Report Labels';
		$data['catagory'] = 'lbl';
		$data['item_id'] = 0;
		$data['item_group_id'] = 0;
		$data['cust_id'] = 0;
		$data['items'] = $this->m_masters->getactivemaster('bud_lbl_items', 'item_status');
		$data['item_groups'] = $this->m_masters->getactivemaster('bud_lbl_itemgroups', 'group_status'); //ER-07-18#-14
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		if (isset($_POST['search'])) {
			$data['item_id'] = $this->input->post('item_id');
			$data['item_group_id'] = $this->input->post('item_group_id');
			$data['cust_id'] = $this->input->post('cust_id');
		}
		$filter['item_id'] = $data['item_id'];
		$filter['cust_id'] = $data['cust_id'];
		$filter['item_group_id'] = $data['item_group_id'];
		$data['irr_details'] = $this->m_mir->get_irr_3_details($filter);
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
		$this->load->view('labels/v_3_irr_report', $data);
	}
	//End of IRR Reports Labels
	//tot poy qty correction
	function set_poy_inward_prefix()
	{
		$result = $this->m_mir->m_set_poy_inward_prefix();
		if ($result) {
			echo 'Update Successfully !!!!';
		} else {
			echo 'Not Updated';
		}
	}
	//end of tot poy qty correction
	//tot direct lot qty correction
	function set_lot_month()
	{
		$result = $this->m_mir->m_set_lot_month();
		if ($result) {
			echo 'Update Successfully !!!!';
		} else {
			echo 'Not Updated';
		}
	}
	//end of tot direct lotqty correction
	//partial qty delivery in labels
	function update_delivery_qty_lbl()
	{
		$result = $this->m_mir->m_update_delivery_qty_lbl();
		if ($result) {
			echo 'Update Successfully !!!!';
		} else {
			echo 'Not Updated';
		}
	}
	//ER-08-18#-34
	//insert rate in predelivery items
	function update_item_rate_lbl()
	{
		$result = $this->m_mir->m_insert_item_rate_lbl();
		if ($result) {
			echo 'Update Successfully !!!!';
		} else {
			echo 'Not Updated';
		}
	}
	//predelivery items tapes
	function update_delivery_qty_te()
	{
		$result = $this->m_mir->m_update_predelivery_items_tapes();
		if ($result) {
			echo 'Update Successfully !!!!';
		} else {
			echo 'Not Updated';
		}
	}
	//Remove duplicate dcno
	function remove_duplicate_dc_labels()
	{
		$result = $this->m_mir->m_to_remove_duplicate_dc_labels();
		if ($result) {
			echo 'Update Successfully !!!!';
		} else {
			echo 'Not Updated';
		}
	}
	//ER-08-18#-41
	function find_duplicate_box_no_yt()
	{
		echo 'between 2018-07-31  & 2018-08-31';
		$duplicate_boxes = $this->m_mir->m_find_duplicate_box_no_yt();
		if ($duplicate_boxes['deleted']) {
			echo 'deleted_boxes =' . implode(',', $duplicate_boxes['deleted']) . '<br/>';
		}
		if ($duplicate_boxes['normal']) {
			echo 'stock_boxes =' . implode(',', $duplicate_boxes['normal']);
		}
		if (empty($duplicate_boxes['deleted']) && empty($duplicate_boxes['normal'])) {
			echo 'no duplicate boxes';
		}
	}
	//ER-07-18#-19
	function poyvspacking_report_1()
	{
		$data['activeTab'] = 'Mir_reports';
		$data['activeItem'] = 'poyvspacking_report_1';
		$data['page_title'] = 'POY Inward Vs Packing Report-Yarns';
		$data['catagory'] = 'yt';
		$month = 0;
		$term = 2;
		$year = 0;
		if ($this->uri->segment(3)) {
			$term = $this->uri->segment(3);
		}
		if ($this->uri->segment(4)) {
			$year = $this->uri->segment(4);
		}
		if (($this->uri->segment(5)) && ($term == 1)) {
			$month = $this->uri->segment(5);
		}
		if (isset($_POST['search'])) {
			$term = $this->input->post('term');
			$month = ($term == 2) ? 0 : $this->input->post('month');
			$year = $this->input->post('year');
		}
		$data['term'] = $term;
		$data['year'] = $year;
		$data['month'] = $month;
		$data['item_detail'] = $this->m_mir->get_poy_vs_pack_rep_yt($term, $month, $year);
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
		$this->load->view('v_1_poyvspacking_report', $data);
	}
	function poyvspacking_item_wise_1()
	{
		$data['activeTab'] = 'Mir_reports';
		$data['activeItem'] = 'poyvspacking_item_wise_1';
		$data['page_title'] = 'POY Wise POY Inward Vs Packing Report-Yarns';
		$data['catagory'] = 'yt';
		if ($this->uri->segment(3)) {
			$term = $this->uri->segment(3);
		} else {
			$term = null;
		}
		if ($this->uri->segment(4)) {
			$term_value = $this->uri->segment(4);
		} else {
			$term_value = null;
		}
		$data['term'] = $term;
		if ($term == 2) {
			$from_date = $term_value . '-01-01';
			$to_date = $term_value . '-12-31';
			$data['year'] = $term_value;
			$data['month'] = 0;
		} elseif ($term == 1) {
			$from_date = date('Y-m-d', strtotime('01-' . $term_value));
			$to_date = date('Y-m-t', strtotime('01-' . $term_value));
			$data['month'] = date('m', strtotime('01-' . $term_value));
			$data['month'] = (int) $data['month'];
			$data['year'] = date('Y', strtotime('01-' . $term_value));
		}
		if ($this->uri->segment(5)) {
			$data['o_month'] = $this->uri->segment(5);
		} else {
			$data['o_month'] = null;
		}
		$data['item_detail'] = $this->m_mir->get_poy_wise_poyvspacking_rep_yt($from_date, $to_date, $term);
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
		$this->load->view('v_1_item_wise_poyvspacking_report', $data);
	}
	function poyvspacking_box_wise_1()
	{
		$data['activeTab'] = 'Mir_reports';
		$data['activeItem'] = 'poyvspacking_box_wise_1';
		$data['page_title'] = 'Box Wise POy Vs Packing-Yarns';
		$data['catagory'] = 'yt';
		if ($this->uri->segment(3)) {
			$poy_inward_no = $this->uri->segment(3);
		} else {
			$poy_inward_no = null;
		}
		if ($this->uri->segment(4)) {
			$term = $this->uri->segment(4);
		} else {
			$term = null;
		}
		if ($this->uri->segment(5)) {
			$term_value = $this->uri->segment(5);
		} else {
			$term_value = null;
		}
		$data['term'] = $term;
		if ($term == 2) {
			$from_date = $term_value . '-01-01';
			$to_date = $term_value . '-12-31';
			$data['year'] = $term_value;
			$data['month'] = 0;
		} elseif ($term == 1) {
			$month_value = ($this->uri->segment(6) < 10) ? '0' . $this->uri->segment(6) : $this->uri->segment(6);
			$from_date = date('Y-m-d', strtotime('01-' . $month_value . '-' . $term_value));
			$to_date = date('Y-m-t', strtotime('01-' . $month_value . '-' . $term_value));
			$data['month'] = date('m', strtotime('01-' . $month_value . '-' . $term_value));
			$data['month'] = (int) $data['month'];
			$data['year'] = date('Y', strtotime('01-' . $month_value . '-' . $term_value));
		}
		if ($this->uri->segment(6)) {
			$data['o_month'] = $this->uri->segment(6);
		} else {
			$data['o_month'] = null;
		}
		$data['form'] = 'inw';
		$data['box_detail'] = $this->m_mir->get_box_wise_poyvspacking_rep_yt($from_date, $to_date, $term, $poy_inward_no);
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
		$this->load->view('v_1_box_wise_poyvspacking_report', $data);
	}
	//End of ER-07-18#-19
	function update_delivery_qty_yt() //ER-09-18#-58
	{
		$result = $this->m_mir->m_update_predelivery_items_yt();
		if ($result) {
			echo 'Update Successfully !!!!';
		} else {
			echo 'Not Updated';
		}
	}
	function remove_delivered_stock_te() //ER-09-18#-59
	{
		$result = $this->m_mir->m_remove_delivered_stock_te();
		if ($result) {
			echo 'Update Successfully !!!!';
		} else {
			echo 'Not Updated';
		}
	}
}
