<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Reports extends CI_Controller
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
	function dyes_cost_reg()
	{
		$data['machines'] = $this->m_masters->getactivemaster('bud_machines', 'machine_status');

		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'dyes_cost_reg';
		$data['page_title'] = 'Dyes Costing Register';
		$data['from_date'] = date("d-m-Y");
		$data['to_date'] = date("d-m-Y");
		$data['lot_prefix'] = '';
		$data['lot_id'] = '';

		$data['lots'] = $this->m_masters->get_lots();
		echo $this->input->post('search');
		if ($this->input->post('search')) {
			echo $data['from_date'] = $this->input->post('from_date');
			echo $data['to_date'] = $this->input->post('to_date');
			$data['lot_prefix'] = $this->input->post('lot_prefix');
			$data['lot_id'] = $this->input->post('lot_id');
		}
		$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
		$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
		$lot_prefix = $this->input->post('lot_prefix');
		$lot_id = $this->input->post('lot_id');

		$total_consumption = array();

		$result = $this->m_reports->get_dyes_cost_reg($from_date, $to_date, $lot_prefix, $lot_id);
		/*echo "<pre>";
		print_r($result);
		echo "</pre>";*/
		$machine_name = '';
		foreach ($result as $lot) {
			$shade_chemicals = array();
			$lot_id = $lot->lot_id;
			$lot_no = $lot->lot_no;
			$lot_prefix = $lot->lot_prefix;
			$machine_prefix = $lot->machine_prefix;
			$machine_name = $machine_prefix . $lot_prefix;
			$lot_qty = $lot->lot_qty;
			$lot_shade_no = $lot->lot_shade_no;
			$recipe = $this->m_reports->get_recipe_details($lot_shade_no);

			$qty = 0;
			$value = 0;
			if ($recipe) {
				$shade_chemicals = (array) json_decode($recipe->shade_chemicals);
				if (sizeof($shade_chemicals) > 0) {
					foreach ($shade_chemicals as $stage1) {
						if ($stage1 != '') {
							$chemical_id = $stage1->chemical_id;
							$chemical = $this->m_reports->get_dyes_chemical($chemical_id);

							$qty += $stage1->chemical_value * $lot_qty;
							$value += $chemical->dyes_rate * $qty;
						}
					}
				}
				$shade_dyes = (array) json_decode($recipe->shade_dyes);
				if (sizeof($shade_dyes) > 0) {
					foreach ($shade_dyes as $stage2) {
						if ($stage2 != '') {
							$qty += $stage2->dyes_value * $lot_qty;

							$dyes_id = $stage2->dyes_id;
							$dyes = $this->m_reports->get_dyes_chemical($dyes_id);
							$value += $dyes->dyes_rate * $qty;
						}
					}
				}

				$stage3_data = (array) json_decode($recipe->stage3);
				if (sizeof($stage3_data) > 0) {
					foreach ($stage3_data as $stage3) {
						if ($stage3 != '') {
							$qty += $stage3->dyes_value * $lot_qty;

							$dyes_id = $stage3->dyes_id;
							$dyes = $this->m_reports->get_dyes_chemical($dyes_id);
							$value += $dyes->dyes_rate * $qty;
						}
					}
				}
				$stage4_data = (array) json_decode($recipe->stage4);
				if (sizeof($stage4_data) > 0) {
					foreach ($stage4_data as $stage4) {
						if ($stage4 != '') {
							$qty += $stage4->dyes_value * $lot_qty;

							$dyes_id = $stage4->dyes_id;
							$dyes = $this->m_reports->get_dyes_chemical($dyes_id);
							$value += $dyes->dyes_rate * $qty;
						}
					}
				}
			}
			$total_consumption[$lot_id]['lot_no'] = $lot_no;
			$total_consumption[$lot_id]['machine_name'] = $machine_name;
			$total_consumption[$lot_id]['total_consumption'] = $qty;
			$total_consumption[$lot_id]['total_value'] = $value;
			$total_consumption[$lot_id]['lot_qty'] = $lot_qty;
		}
		$data['total_consumption'] = $total_consumption;

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
		$this->load->view('dyes_cost_reg', $data);
	}

	function dyes_stock_reg()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'dyes_stock_reg';
		$data['page_title'] = 'Dyes Stock Register';
		$data['from_lot_id'] = '';
		$data['to_lot_id'] = '';
		$data['dyes_chem_id'] = '';
		$dyes_chem_id = '';

		$total_consumption = array();

		$result = $this->m_reports->get_dyes_cost_reg();

		if ($this->input->post('dyes_chem_id')) {
			$dyes_chem_id = $this->input->post('dyes_chem_id');
			$data['dyes_chem_id'] = $this->input->post('dyes_chem_id');
		}


		// echo $dyes_chem_id;

		/*echo "<pre>";
		print_r($result);
		echo "</pre>";*/
		$return = array();

		foreach ($result as $lot) {
			$shade_chemicals = array();
			$lot_id = $lot->lot_id;
			$lot_no = $lot->lot_no;
			$lot_qty = $lot->lot_qty;
			$lot_shade_no = $lot->lot_shade_no;
			$recipe = $this->m_reports->get_recipe_details($lot_shade_no);

			$qty = 0;
			$value = 0;
			if ($recipe) {
				$shade_chemicals = (array) json_decode($recipe->shade_chemicals);
				if (sizeof($shade_chemicals) > 0) {
					foreach ($shade_chemicals as $stage1) {
						if ($stage1 != '') {
							$chemical_id = $stage1->chemical_id;
							$chemical = $this->m_reports->get_dyes_chemical($chemical_id);

							/*echo "<pre>";
							print_r($chemical);
							echo "</pre>";*/

							if ($dyes_chem_id == '') {
								$qty += @$stage1->chemical_value * $lot_qty;
								$value += @$chemical->dyes_rate * $qty;

								$return[$chemical_id]['qty'][] = $stage1->chemical_value * $lot_qty;
								$return[$chemical_id]['name'] = @$chemical->dyes_chem_name;
								$return[$chemical_id]['code'] = @$chemical->dyes_chem_code;
								$return[$chemical_id]['open_stock'] = @$chemical->dyes_open_stock;
							} elseif ($dyes_chem_id == $chemical->dyes_chem_id) {
								$qty += @$stage1->chemical_value * $lot_qty;
								$value += @$chemical->dyes_rate * $qty;

								$return[$chemical_id]['qty'][] = $stage1->chemical_value * $lot_qty;
								$return[$chemical_id]['name'] = @$chemical->dyes_chem_name;
								$return[$chemical_id]['code'] = @$chemical->dyes_chem_code;
								$return[$chemical_id]['open_stock'] = @$chemical->dyes_open_stock;
							}
						}
					}
				}
				$shade_dyes = (array) json_decode($recipe->shade_dyes);
				if (sizeof($shade_dyes) > 0) {
					foreach ($shade_dyes as $stage2) {
						if ($stage2 != '') {
							$qty += $stage2->dyes_value * $lot_qty;

							$dyes_id = $stage2->dyes_id;
							$dyes = $this->m_reports->get_dyes_chemical($dyes_id);
							if ($dyes_chem_id == '') {
								$value += @$dyes->dyes_rate * $qty;

								$return[$dyes_id]['qty'][] = $stage2->dyes_value * $lot_qty;
								$return[$dyes_id]['name'] = @$dyes->dyes_chem_name;
								$return[$dyes_id]['code'] = @$dyes->dyes_chem_code;
								$return[$dyes_id]['open_stock'] = @$dyes->dyes_open_stock;
							} elseif ($dyes_chem_id == $dyes->dyes_chem_id) {
								$value += @$dyes->dyes_rate * $qty;

								$return[$dyes_id]['qty'][] = $stage2->dyes_value * $lot_qty;
								$return[$dyes_id]['name'] = @$dyes->dyes_chem_name;
								$return[$dyes_id]['code'] = @$dyes->dyes_chem_code;
								$return[$dyes_id]['open_stock'] = @$dyes->dyes_open_stock;
							}
						}
					}
				}
				$stage3_data = (array) json_decode($recipe->stage3);
				if (sizeof($stage3_data) > 0) {
					foreach ($stage3_data as $stage3) {
						if ($stage3 != '') {
							$qty += $stage3->dyes_value * $lot_qty;

							$dyes_id = $stage3->dyes_id;
							$dyes = $this->m_reports->get_dyes_chemical($dyes_id);

							if ($dyes_chem_id == '') {
								$value += @$dyes->dyes_rate * $qty;

								$return[$dyes_id]['qty'][] = $stage2->dyes_value * $lot_qty;
								$return[$dyes_id]['name'] = @$dyes->dyes_chem_name;
								$return[$dyes_id]['code'] = @$dyes->dyes_chem_code;
								$return[$dyes_id]['open_stock'] = @$dyes->dyes_open_stock;
							} elseif ($dyes_chem_id == $dyes->dyes_chem_id) {
								$value += @$dyes->dyes_rate * $qty;

								$return[$dyes_id]['qty'][] = $stage2->dyes_value * $lot_qty;
								$return[$dyes_id]['name'] = @$dyes->dyes_chem_name;
								$return[$dyes_id]['code'] = @$dyes->dyes_chem_code;
								$return[$dyes_id]['open_stock'] = @$dyes->dyes_open_stock;
							}
						}
					}
				}
				$stage4_data = (array) json_decode($recipe->stage4);
				if (sizeof($stage4_data) > 0) {
					foreach ($stage4_data as $stage4) {
						if ($stage4 != '') {
							$qty += $stage4->dyes_value * $lot_qty;

							$dyes_id = $stage4->dyes_id;
							$dyes = $this->m_reports->get_dyes_chemical($dyes_id);
							if ($dyes_chem_id == '') {
								// echo "string";
								$value += @$dyes->dyes_rate * $qty;

								$return[$dyes_id]['qty'][] = $stage2->dyes_value * $lot_qty;
								$return[$dyes_id]['name'] = @$dyes->dyes_chem_name;
								$return[$dyes_id]['code'] = @$dyes->dyes_chem_code;
								$return[$dyes_id]['open_stock'] = @$dyes->dyes_open_stock;
							} elseif ($dyes_chem_id == $dyes->dyes_chem_id) {
								$value += @$dyes->dyes_rate * $qty;

								$return[$dyes_id]['qty'][] = $stage2->dyes_value * $lot_qty;
								$return[$dyes_id]['name'] = @$dyes->dyes_chem_name;
								$return[$dyes_id]['code'] = @$dyes->dyes_chem_code;
								$return[$dyes_id]['open_stock'] = @$dyes->dyes_open_stock;
							}
						}
					}
				}
			}
			$total_consumption[$lot_id]['lot_no'] = $lot_no;
			$total_consumption[$lot_id]['total_consumption'] = $qty;
			$total_consumption[$lot_id]['total_value'] = $value;
			$total_consumption[$lot_id]['lot_qty'] = $lot_qty;
		}

		/*echo "<pre>";
		print_r($return);
		echo "</pre>";*/
		$data['result'] = $return;

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
		$this->load->view('dyes_stock_reg', $data);
	}
	function packingRegister()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'packingRegister';
		$data['page_title'] = 'Packing Register';
		// $data['f_date'] = date("d-m-Y");
		$data['f_date'] = date("d-m-Y", strtotime(date("d-m-Y", time()) . " - 1 year"));
		$data['t_date'] = date("d-m-Y");
		$data['item'] = null;
		$data['item_group_id'] = null;
		$where_array = array(
			'from_date' => $data['f_date'],
			'to_date' => $data['t_date'],
			'item_id' => null,
			'item_group_id' => null
		);
		if (isset($_POST['search'])) {
			$from_date = $this->input->post('from_date');
			$to_date = $this->input->post('to_date');
			$item_name = $this->input->post('item_name');
			$item_group_id = $this->input->post('item_group_id');

			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			$data['item'] = $item_name;
			$data['item_group_id'] = $item_group_id;

			$ed = explode("-", $from_date);
			$from_date = $ed[2] . '-' . $ed[1] . '-' . $ed[0];

			$ed = explode("-", $to_date);
			$to_date = $ed[2] . '-' . $ed[1] . '-' . $ed[0];
			$where_array = array(
				'from_date' => $from_date,
				'to_date' => $to_date,
				'item_id' => $item_name,
				'item_group_id' => $item_group_id
			);
		}
		$data['outerboxes'] = $this->m_reports->getPackingTe($where_array);
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
		$this->load->view('v_2_packing-register.php', $data);
	}
	function packingRegister_1()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'packingRegister_1';
		$data['page_title'] = 'Packing Register';
		// $data['f_date'] = date("01-m-Y");
		$data['f_date'] = date("d-m-Y", strtotime(date("d-m-Y", time()) . " - 1 year"));
		$data['t_date'] = date("d-m-Y");
		$data['item'] = null;
		$from_date = date("Y-m-01");
		$to_date = date("Y-m-d");
		$item_name = null;
		$box_prefix = null;
		if (isset($_POST['search'])) {
			$from_date = $this->input->post('from_date');
			$to_date = $this->input->post('to_date');
			$item_name = $this->input->post('item_name');

			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			$data['item'] = $item_name;

			$ed = explode("-", $from_date);
			$from_date = $ed[2] . '-' . $ed[1] . '-' . $ed[0];

			$ed = explode("-", $to_date);
			$to_date = $ed[2] . '-' . $ed[1] . '-' . $ed[0];

			$where_array = array(
				'packing_date >=' => $from_date,
				'packing_date <=' => $to_date
			);
			if ($item_name != '') {
				$where_array['packing_innerbox_items'] = $item_name;
			} else {
				$item_name = null;
			}
		}
		$data['outerboxes'] = $this->m_reports->getPackingItemsYt($from_date, $to_date, $box_prefix, $item_name);
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
		$this->load->view('v_1_packing-register.php', $data);
	}

	// Sathya
	function cust_pack_reg_test_1()
	{
		$result = $this->m_reports->get_cust_invoice_reg_yt();
		echo "<pre>";
		print_r($result);
		echo "</pre>";
	}
	// End Sathya
	/* legrand charles */
	function custPackRegister_1()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'custPackRegister_1';
		$data['page_title'] = 'Customer Packing Register';
		// $data['f_date'] = date("01-m-Y");
		$data['f_date'] = date("d-m-Y", strtotime(date("d-m-Y", time()) . " - 1 year"));
		$data['t_date'] = date("d-m-Y");
		$data['customer'] = null;
		$data['item_id'] = null;
		$from_date = date("Y-m-01");
		$to_date = date("Y-m-d");
		$cust_name = null;
		$item_id = null;
		$box_prefix = null;
		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
			$cust_name = $this->input->post('customer_name');
			$item_id = $this->input->post('item_id');

			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			$data['customer'] = $cust_name;
			$data['item_id'] = $item_id;

			$where_array = array(
				'packing_date >=' => $from_date,
				'packing_date <=' => $to_date
			);
			if ($cust_name != '') {
				$where_array['packing_innerbox_items'] = $cust_name;
				$data["customer_code"] = $cust_name;
				$get_customer_name = $this->m_masters->getcustomerdetails($cust_name);
				$data["customer_name"] = $get_customer_name[0]['cust_name'];
			} else {
				$cust_name = null;
			}

			if ($item_id != '') {
				$item_id = $this->input->post('item_id');
				$data['item_id'] = $item_id;
			} else {
				$item_id = null;
				$data['item_id'] = $item_id;
			}
		}
		// $data['outerboxes'] = $this->m_reports->getPackingCustomersYt($from_date, $to_date, $box_prefix, $cust_name);
		$data['cust_pack_register'] = $this->m_reports->get_cust_pack_reg_yt($from_date, $to_date, $box_prefix, $cust_name, $item_id);
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
		$this->load->view('v_1_cust-pack-register', $data);
	}

	function stock_register_1()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'stock_register_1';
		$data['page_title'] = 'Item Stock Register';
		// $data['f_date'] = date("01-m-Y");
		$data['f_date'] = date("d-m-Y", strtotime(date("d-m-Y", time()) . " - 4 year"));
		$data['t_date'] = date("d-m-Y");
		$data['customer'] = null;
		$data['item_id'] = null;
		$data['shade_id'] = null;
		$data['lot_number'] = null;
		$data['room_no'] = null;
		$data['room_id'] = null;
		$from_date = date("Y-m-01");
		$to_date = date("Y-m-d");
		$cust_name = null;
		$item_id = null;
		$shade_id = null;
		$lot_number = null;
		$room_id = null;
		$room_no = null;
		$box_prefix = null;

		$this->db->select('*');
		$this->db->from('bud_shades');
		$query = $this->db->get();
		$data['colors'] = $query->result_array();

		$this->db->select('*');
		$this->db->from('bud_yt_packing_boxes');
		$this->db->group_by('lot_no');
		$query = $this->db->get();
		$data['lot_no'] = $query->result_array();


		$this->db->select('*');
		$this->db->from('bud_stock_rooms');
		$query = $this->db->get();
		$data['room_no'] = $query->result_array();

		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date') . "1days"));
			$cust_name = $this->input->post('customer_name');
			$item_id = $this->input->post('item_id');
			$shade_id = $this->input->post('color_code');
			$lot_number = $this->input->post('lot_no');
			$room_id = $this->input->post('rno');

			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			$data['customer'] = $cust_name;
			$data['item_id'] = $item_id;
			$data['shade_id'] = $shade_id;
			$data['lot_number'] = $lot_number;
			$data['room_id'] = $room_id;


			$where_array = array(
				'packing_date >=' => $from_date,
				'packing_date <=' => $to_date
			);
			if ($cust_name != '') {
				$where_array['packing_innerbox_items'] = $cust_name;
				$data["customer_code"] = $cust_name;
				$get_customer_name = $this->m_masters->getcustomerdetails($cust_name);
				$data["customer_name"] = $get_customer_name[0]['cust_name'];
			} else {
				$cust_name = null;
			}

			if ($item_id != '') {
				$item_id = $this->input->post('item_id');
				$data['item_id'] = $item_id;
			} else {
				$item_id = null;
				$data['item_id'] = $item_id;
			}
		}
		// $data['outerboxes'] = $this->m_reports->getPackingCustomersYt($from_date, $to_date, $box_prefix, $cust_name);
		$data['cust_pack_register'] = $this->m_reports->get_stock_reg_yt($from_date, $to_date, $box_prefix, $cust_name, $item_id, $shade_id, $lot_number, $room_id);
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
		$this->load->view('v_1_stock-register', $data);
	}
	//Dynamic Dost 3.0 Stock Room Wise Stock Report
	function stock_register_storeroom_wise_1()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'stock_register storeroom_wise_1';
		$data['page_title'] = 'S R Wise Stock Register';
		// $data['f_date'] = date("01-m-Y");
		$data['f_date'] = date("d-m-Y", strtotime(date("d-m-Y", time()) . " - 1 year"));
		$data['t_date'] = date("d-m-Y");
		$data['customer'] = null;
		$data['item_id'] = null;
		$data['shade_id'] = null;
		$data['lot_number'] = null;
		$data['room_no'] = null;
		$data['room_id'] = null;
		$from_date = date("Y-m-01");
		$to_date = date("Y-m-d");
		$cust_name = null;
		$item_id = null;
		$shade_id = null;
		$lot_number = null;
		$room_id = null;
		$room_no = null;
		$box_prefix = null;
		$data['status'] = '';

		$this->db->select('*');
		$this->db->from('bud_shades');
		$query = $this->db->get();
		$data['colors'] = $query->result_array();

		$this->db->select('*');
		$this->db->from('bud_yt_packing_boxes');
		$this->db->group_by('lot_no');
		$query = $this->db->get();
		$data['lot_no'] = $query->result_array();


		$this->db->select('*');
		$this->db->from('bud_stock_rooms');
		$query = $this->db->get();
		$data['room_no'] = $query->result_array();

		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date') . "1days"));
			$cust_name = $this->input->post('customer_name');
			$item_id = $this->input->post('item_id');
			$shade_id = $this->input->post('color_code');
			$lot_number = $this->input->post('lot_no');
			$room_id = $this->input->post('rno');

			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			$data['customer'] = $cust_name;
			$data['item_id'] = $item_id;
			$data['shade_id'] = $shade_id;
			$data['lot_number'] = $lot_number;
			$data['room_id'] = $room_id;
			$data['status'] = $this->input->post('status');

			$where_array = array(
				'packing_date >=' => $from_date,
				'packing_date <=' => $to_date
			);
			if ($cust_name != '') {
				$where_array['packing_innerbox_items'] = $cust_name;
				$data["customer_code"] = $cust_name;
				$get_customer_name = $this->m_masters->getcustomerdetails($cust_name);
				$data["customer_name"] = $get_customer_name[0]['cust_name'];
			} else {
				$cust_name = null;
			}

			if ($item_id != '') {
				$item_id = $this->input->post('item_id');
				$data['item_id'] = $item_id;
			} else {
				$item_id = null;
				$data['item_id'] = $item_id;
			}
		}
		$data['cust_pack_register'] = $this->m_reports->get_stock_stockroom_reg_yt($from_date, $to_date, $box_prefix, $cust_name, $item_id, $shade_id, $lot_number, $room_id, $data['status']);
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
			'assets/data-tables/DT_bootstrap.js',
			'tabletools/js/dataTables.tableTools.js'
		);
		$data['js_common'] = array('js/common-scripts.js');
		$data['js_thispage'] = array('js/form-validation-script.js', 'js/form-component.js', 'js/dynamic-table.js');
		$this->load->view('v_1_stock_storeroom_wise-register', $data);
	}
	//End of Dynamic Dost 3.0 Stock Room Wise Stock Report
	function stock_register_m()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'stock_register_2';
		$data['page_title'] = 'As On Stock Register';
		// $data['f_date'] = date("01-m-Y");
		$data['f_date'] = date("d-m-Y");
		$data['t_date'] = date("d-m-Y");
		$data['customer'] = null;
		$data['item_id'] = null;
		$data['shade_id'] = null;
		$data['lot_number'] = null;
		$from_date = date("Y-m-01");
		$to_date = date("Y-m-d");
		$cust_name = null;
		$item_id = null;
		$shade_id = null;
		$lot_number = null;
		$box_prefix = null;

		$this->db->select('*');
		$this->db->from('bud_shades');
		$query = $this->db->get();
		$data['colors'] = $query->result_array();

		$this->db->select('*');
		$this->db->from('bud_yt_packing_boxes');
		$this->db->group_by('lot_no');
		$query = $this->db->get();
		$data['lot_no'] = $query->result_array();

		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date') . "1days"));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
			$cust_name = $this->input->post('customer_name');
			$item_id = $this->input->post('item_id');
			$shade_id = $this->input->post('color_code');
			$lot_number = $this->input->post('lot_no');

			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			$data['customer'] = $cust_name;
			$data['item_id'] = $item_id;
			$data['shade_id'] = $shade_id;
			$data['lot_number'] = $lot_number;

			$where_array = array(
				'packing_date' => $from_date,

			);
			if ($cust_name != '') {
				$where_array['packing_innerbox_items'] = $cust_name;
				$data["customer_code"] = $cust_name;
				$get_customer_name = $this->m_masters->getcustomerdetails($cust_name);
				$data["customer_name"] = $get_customer_name[0]['cust_name'];
			} else {
				$cust_name = null;
			}

			if ($item_id != '') {
				$item_id = $this->input->post('item_id');
				$data['item_id'] = $item_id;
			} else {
				$item_id = null;
				$data['item_id'] = $item_id;
			}
		}
		// $data['outerboxes'] = $this->m_reports->getPackingCustomersYt($from_date, $to_date, $box_prefix, $cust_name);
		$data['cust_pack_register'] = $this->m_reports->get_stock_reg_yt_m($from_date, $box_prefix, $cust_name, $item_id, $shade_id, $lot_number);
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
		$this->load->view('stock_register_m', $data);
	}


	function deletedboxRegister_1()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'deletedboxRegister_1';
		$data['page_title'] = 'Deleted Box Register';
		// $data['f_date'] = date("01-m-Y");
		$data['f_date'] = date("d-m-Y", strtotime(date("d-m-Y", time()) . " - 1 year"));
		$data['t_date'] = date("d-m-Y");
		$from_date = date("Y-m-01");
		$to_date = date("Y-m-d");
		$box_prefix = null;
		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));

			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');

			$where_array = array(
				'packing_date >=' => $from_date,
				'packing_date <=' => $to_date
			);
		}
		$data['outerboxes'] = $this->m_reports->getDeletedBoxesYt($from_date, $to_date, $box_prefix);
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
		$this->load->view('v_1_deleted-boxes-register', $data);
	}

	function itemdeliveryRegister_1()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'itemdeliveryRegister_1';
		$data['page_title'] = 'Item Delivery Register';
		// $data['f_date'] = date("01-m-Y");
		$data['f_date'] = date("d-m-Y", strtotime(date("d-m-Y", time()) . " - 1 year"));
		$data['t_date'] = date("d-m-Y");
		$data['item'] = null;
		$from_date = date("Y-m-01");
		$to_date = date("Y-m-d");
		$item_name = null;
		$box_prefix = null;
		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
			$item_name = $this->input->post('item_name');

			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			$data['item'] = $item_name;

			$where_array = array(
				'packing_date >=' => $from_date,
				'packing_date <=' => $to_date
			);
			if ($item_name != '') {
				$where_array['packing_innerbox_items'] = $item_name;
			} else {
				$item_name = null;
			}
		}
		$data['outerboxes'] = $this->m_reports->getItemsDeliveryRegisterYt($from_date, $to_date, $box_prefix, $item_name);
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
		$this->load->view('v_1_item_delivery-register', $data);
	}


	function custdeliveryRegister_1()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'custdeliveryRegister_1';
		$data['page_title'] = 'Customer Delivery Register';
		// $data['f_date'] = date("01-m-Y");
		$data['f_date'] = date("d-m-Y", strtotime(date("d-m-Y", time()) . " - 1 year"));
		$data['t_date'] = date("d-m-Y");
		$data['customer'] = null;
		$data['item_id'] = null;
		$data['status'] = 0; //ER-08-18#-31
		$from_date = date("Y-m-01");
		$to_date = date("Y-m-d");
		$cust_name = null;
		$item_id = null;
		$box_prefix = null;
		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
			$cust_name = $this->input->post('customer_name');
			$item_id = $this->input->post('item_id');

			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			$data['status'] = $this->input->post('status'); //ER-08-18#-31
			$data['customer'] = $cust_name;
			echo $data['item_id'] = $item_id;

			$where_array = array(
				'packing_date >=' => $from_date,
				'packing_date <=' => $to_date
			);
			if ($cust_name != '') {
				$where_array['packing_innerbox_items'] = $cust_name;
				$data["customer_code"] = $cust_name;
				$get_customer_name = $this->m_masters->getcustomerdetails($cust_name);
				$data["customer_name"] = $get_customer_name[0]['cust_name'];
			} else {
				$cust_name = null;
			}

			if ($item_id != '') {
				$item_id = $this->input->post('item_id');
			} else {
				$item_id = null;
			}
		}
		// $data['outerboxes'] = $this->m_reports->getPackingCustomersYt($from_date, $to_date, $box_prefix, $cust_name);
		$data['cust_pack_register'] = $this->m_reports->get_cust_delivery_reg_yt($from_date, $to_date, $box_prefix, $cust_name, $item_id);
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
		$this->load->view('v_1_cust-delivery-register', $data);
	}
	function iteminvoiceRegister_1()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'iteminvoiceRegister_1';
		$data['page_title'] = 'Item Invoice Register';
		// $data['f_date'] = date("01-m-Y");
		$data['f_date'] = date("d-m-Y", strtotime(date("d-m-Y", time()) . " - 1 year"));
		$data['t_date'] = date("d-m-Y");
		$data['item'] = null;
		$from_date = date("Y-m-01");
		$to_date = date("Y-m-d");
		$item_name = null;
		$box_prefix = null;
		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
			$item_name = $this->input->post('item_name');

			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			$data['item'] = $item_name;

			$where_array = array(
				'packing_date >=' => $from_date,
				'packing_date <=' => $to_date
			);
			if ($item_name != '') {
				$where_array['packing_innerbox_items'] = $item_name;
			} else {
				$item_name = null;
			}
		}
		$data['outerboxes'] = $this->m_reports->getItemsInvoiceRegisterYt($from_date, $to_date, $box_prefix, $item_name);
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
		$this->load->view('v_1_item_invoice-register', $data);
	}


	function custinvoiceRegister_1()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'custinvoiceRegister_1';
		$data['page_title'] = 'Customer Invoice Register';
		// $data['f_date'] = date("01-m-Y");
		$data['f_date'] = date("d-m-Y", strtotime(date("d-m-Y", time()) . " - 1 year"));
		$data['t_date'] = date("d-m-Y");
		$data['customer'] = null;
		$from_date = date("Y-m-01");
		$to_date = date("Y-m-d");
		$cust_name = null;
		$item_id = null;
		$box_prefix = null;
		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
			$cust_name = $this->input->post('customer_name');
			$item_id = $this->input->post('item_id');

			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			$data['customer'] = $cust_name;
			$data['item_id'] = $item_id;

			$where_array = array(
				'packing_date >=' => $from_date,
				'packing_date <=' => $to_date
			);
			if ($cust_name != '') {
				$where_array['packing_innerbox_items'] = $cust_name;
				$data["customer_code"] = $cust_name;
				$get_customer_name = $this->m_masters->getcustomerdetails($cust_name);
				$data["customer_name"] = $get_customer_name[0]['cust_name'];
			} else {
				$cust_name = null;
			}

			if ($item_id != '') {
				$item_id = $this->input->post('item_id');
			} else {
				$item_id = null;
			}
		}
		// $data['outerboxes'] = $this->m_reports->getPackingCustomersYt($from_date, $to_date, $box_prefix, $cust_name);
		$data['cust_pack_register'] = $this->m_reports->get_cust_invoice_reg_yt($from_date, $to_date, $box_prefix, $cust_name, $item_id);
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
		// $this->load->view('v_1_cust-delivery-register', $data);
		$this->load->view('v_1_customer_invoice-register', $data);
	}

	function cust_sales_register_1()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'cust_sales_register_1';
		$data['page_title'] = 'Customer Sales Register';
		// $data['f_date'] = date("01-m-Y");
		$data['f_date'] = date("d-m-Y", strtotime(date("d-m-Y", time()) . " - 1 year"));
		$data['t_date'] = date("d-m-Y");
		$data['customer'] = null;
		$from_date = date("Y-m-01");
		$to_date = date("Y-m-d");
		$cust_name = null;
		$item_id = null;
		$box_prefix = null;
		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
			$cust_name = $this->input->post('customer_name');
			$item_id = $this->input->post('item_id');

			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			$data['customer'] = $cust_name;
			$data['item_id'] = $item_id;

			$where_array = array(
				'packing_date >=' => $from_date,
				'packing_date <=' => $to_date
			);
			if ($cust_name != '') {
				$data["customer"] = $this->input->post('customer_name');
				$customer = $this->input->post('customer_name');
			} else {
				$cust_name = null;
			}
		}
		// $data['outerboxes'] = $this->m_reports->getPackingCustomersYt($from_date, $to_date, $box_prefix, $cust_name);
		$data['cust_pack_register'] = $this->m_reports->get_cust_sales_reg_yt($from_date, $to_date, $cust_name);
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
		// $this->load->view('v_1_cust-delivery-register', $data);
		$this->load->view('v_1_customer_sales-register', $data);
	}

	function cust_sales_register_2()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'cust_sales_register_2';
		$data['page_title'] = 'Customer Sales Register';
		// $data['f_date'] = date("01-m-Y");
		$data['f_date'] = date("d-m-Y", strtotime(date("d-m-Y", time()) . " - 1 year"));
		$data['t_date'] = date("d-m-Y");
		$data['customer'] = null;
		$from_date = date("Y-m-01");
		$to_date = date("Y-m-d");
		$cust_name = null;
		$item_id = null;
		$box_prefix = null;
		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
			$cust_name = $this->input->post('customer_name');
			$item_id = $this->input->post('item_id');

			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			$data['customer'] = $cust_name;
			$data['item_id'] = $item_id;

			$where_array = array(
				'packing_date >=' => $from_date,
				'packing_date <=' => $to_date
			);
			if ($cust_name != '') {
				$data["customer"] = $this->input->post('customer_name');
				$customer = $this->input->post('customer_name');
			} else {
				$cust_name = null;
			}
		}
		// $data['outerboxes'] = $this->m_reports->getPackingCustomersYt($from_date, $to_date, $box_prefix, $cust_name);
		$data['cust_pack_register'] = $this->m_reports->get_cust_sales_reg_te($from_date, $to_date, $cust_name);
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
		// $this->load->view('v_1_cust-delivery-register', $data);
		$this->load->view('v_2_customer_sales-register', $data);
	}

	function cust_sales_register_3()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'cust_sales_register_3';
		$data['page_title'] = 'Customer Sales Register';
		// $data['f_date'] = date("01-m-Y");
		$data['f_date'] = date("d-m-Y", strtotime(date("d-m-Y", time()) . " - 1 year"));
		$data['t_date'] = date("d-m-Y");
		$data['customer'] = null;
		$from_date = date("Y-m-01");
		$to_date = date("Y-m-d");
		$cust_name = null;
		$item_id = null;
		$box_prefix = null;
		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
			$cust_name = $this->input->post('customer_name');
			$item_id = $this->input->post('item_id');

			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			$data['customer'] = $cust_name;
			$data['item_id'] = $item_id;

			$where_array = array(
				'packing_date >=' => $from_date,
				'packing_date <=' => $to_date
			);
			if ($cust_name != '') {
				$data["customer"] = $this->input->post('customer_name');
				$customer = $this->input->post('customer_name');
			} else {
				$cust_name = null;
			}
		}
		// $data['outerboxes'] = $this->m_reports->getPackingCustomersYt($from_date, $to_date, $box_prefix, $cust_name);
		$data['cust_pack_register'] = $this->m_reports->get_cust_sales_reg_lbl($from_date, $to_date, $cust_name);
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
		// $this->load->view('v_1_cust-delivery-register', $data);
		$this->load->view('v_3_customer_sales-register', $data);
	}



	function demo()
	{
		$str = '';
		$boxes = $this->m_reports->get_boxes_by_customer();
		foreach ($boxes as $b) {
			$str .= $b->delivery_boxes . ",";
		}
		echo substr_replace($str, '', -1);
	}

	function demo1()
	{
		$str = '';
		$boxes = $this->m_reports->get_boxes_from_invoice('0');
		foreach ($boxes as $b) {
			$str .= $b->boxes_array . ",";
		}
		echo substr_replace($str, '', -1);
	}

	// Sathya
	function custPackRegister()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'custPackRegister';
		$data['page_title'] = 'Customer Packing Register';
		// $data['f_date'] = date("01-m-Y");
		$data['f_date'] = date("d-m-Y", strtotime(date("d-m-Y", time()) . " - 1 year"));
		$data['t_date'] = date("d-m-Y");
		$data['customer_name'] = null;
		$data['item_id'] = null;
		$from_date = date("Y-m-01");
		$to_date = date("Y-m-d");
		$customer_name = null;
		$item_id = null;
		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));

			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');

			if ($this->input->post('item_id')) {
				$item_id = $this->input->post('item_id');
				$data['item_id'] = $this->input->post('item_id');
			} else {
				$item_id = null;
				$data['item_id'] = null;
			}
			if ($this->input->post('customer_name')) {
				$customer_name = $this->input->post('customer_name');
				$data['customer_name'] = $this->input->post('customer_name');
			} else {
				$customer_name = null;
				$data['customer_name'] = null;
			}
		}
		$data['cust_pack_register'] = $this->m_reports->get_cust_pack_reg_te($from_date, $to_date, $customer_name, $item_id);
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
		$this->load->view('v_2_cust-pack-register', $data);
	}

	function stock_register_2()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'stock_register_2';
		$data['page_title'] = 'Stock Register';
		// $data['f_date'] = date("01-m-Y");
		$data['f_date'] = date("d-m-Y");
		$data['t_date'] = date("d-m-Y");
		$data['customer_name'] = null;
		$data['room_no'] = null;
		$data['colors'] = null;
		$data['lot_no'] = null;
		$data['item_id'] = null;

		$data['shade_id'] = null;
		$data['lot_number'] = null;
		$data['room_id'] = null;
		$data['room_no'] = null;

		$shade_id = null;
		$lot_number = null;
		$room_id = null;
		$room_no = null;
		$from_date = date("Y-m-d");
		$to_date = date("Y-m-d");
		$customer_name = null;
		$item_id = null;
		$lot_number = null;
		$this->db->select('*');
		$this->db->from('bud_shades');
		$query = $this->db->get();
		$data['colors'] = $query->result_array();

		$this->db->select('*');
		$this->db->from('bud_te_outerboxes');
		$this->db->group_by('dyed_lot_no');
		$query = $this->db->get();
		$data['lot_no'] = $query->result_array();


		$this->db->select('*');
		$this->db->from('bud_stock_rooms');
		$query = $this->db->get();
		$data['room_no'] = $query->result_array();

		if (isset($_POST['search'])) {

			//$to_date = date("Y-m-d", strtotime($this->input->post('to_date')."1days"));
			$from_date = date('Y-m-d', strtotime('2016-01-01' . '1days'));
			$to_date = date("Y-m-d", strtotime($this->input->post('from_date') . "1days"));

			$lot_number = $this->input->post('lot_no');
			$room_no = $this->input->post('rno');
			//$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));


			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = null;
			$data['lot_number'] = $lot_number;


			if ($this->input->post('item_id')) {
				$item_id = $this->input->post('item_id');
				$data['item_id'] = $this->input->post('item_id');
			} else {
				$item_id = null;
				$data['item_id'] = null;
			}
			if ($this->input->post('customer_name')) {
				$customer_name = $this->input->post('customer_name');
				$data['customer_name'] = $this->input->post('customer_name');
			} else {
				$customer_name = null;
				$data['customer_name'] = null;
			}
		}
		$data['cust_pack_register'] = $this->m_reports->get_stock_reg_te($from_date, $to_date, $customer_name, $item_id, $room_no, $lot_number);
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
		$this->load->view('v_2_stock-register', $data);
	}
	// End Sathya


	function deletedboxRegister()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'deletedboxRegister';
		$data['page_title'] = 'Deleted Box Register';
		// $data['f_date'] = date("01-m-Y");
		$data['f_date'] = date("d-m-Y", strtotime(date("d-m-Y", time()) . " - 1 year"));
		$data['t_date'] = date("d-m-Y");
		$from_date = date("Y-m-01");
		$to_date = date("Y-m-d");
		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));

			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
		}
		$data['outerboxes'] = $this->m_reports->getDeletedBoxesTe($from_date, $to_date);
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
		$this->load->view('v_2_deleted-boxes-register', $data);
	}

	function itemdeliveryRegister()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'itemdeliveryRegister';
		$data['page_title'] = 'Item Delivery Register';
		// $data['f_date'] = date("01-m-Y");
		$data['f_date'] = date("d-m-Y", strtotime(date("d-m-Y", time()) . " - 1 year"));
		$data['t_date'] = date("d-m-Y");
		$data['item'] = null;
		$from_date = date("Y-m-01");
		$to_date = date("Y-m-d");
		$item_name = null;
		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
			$item_name = $this->input->post('item_name');

			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			$data['item'] = $item_name;

			if ($item_name != '') {
				$where_array['packing_innerbox_items'] = $item_name;
			} else {
				$item_name = null;
			}
		}
		$data['outerboxes'] = $this->m_reports->getItemsDeliveryRegisterTe($from_date, $to_date, $item_name);
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
		$this->load->view('v_2_item_delivery-register', $data);
	}

	// Tapes
	function custdeliveryRegister()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'custdeliveryRegister';
		$data['page_title'] = 'Customer Delivery Register';
		// $data['f_date'] = date("01-m-Y");
		$data['f_date'] = date("d-m-Y", strtotime(date("d-m-Y", time()) . " - 1 year"));
		$data['t_date'] = date("d-m-Y");
		$data['customer_name'] = null;
		$data['item_id'] = null;
		$from_date = date("Y-m-01");
		$to_date = date("Y-m-d");
		$customer_name = null;
		$item_id = null;
		$data['status'] = '0'; //ER-08-18#-30
		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));

			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			$data['status'] = $this->input->post('status'); //ER-08-18#-30
			if ($this->input->post('item_id')) {
				$item_id = $this->input->post('item_id');
				$data['item_id'] = $this->input->post('item_id');
			} else {
				$item_id = null;
				$data['item_id'] = null;
			}
			if ($this->input->post('customer_name')) {
				$customer_name = $this->input->post('customer_name');
				$data['customer_name'] = $this->input->post('customer_name');
			} else {
				$customer_name = null;
				$data['customer_name'] = null;
			}
		}
		$data['cust_pack_register'] = $this->m_reports->get_cust_delivery_reg_te($from_date, $to_date, $customer_name, $item_id);
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
		$this->load->view('v_2_customer_delivery-register', $data);
	}


	function iteminvoiceRegister()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'iteminvoiceRegister';
		$data['page_title'] = 'Item Invoice Register';
		// $data['f_date'] = date("01-m-Y");
		$data['f_date'] = date("d-m-Y", strtotime(date("d-m-Y", time()) . " - 1 year"));
		$data['t_date'] = date("d-m-Y");
		$data['item'] = null;
		$from_date = date("Y-m-01");
		$to_date = date("Y-m-d");
		$item_name = null;
		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
			$item_name = $this->input->post('item_name');

			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			$data['item'] = $item_name;

			if ($item_name != '') {
				$where_array['packing_innerbox_items'] = $item_name;
			} else {
				$item_name = null;
			}
		}
		$data['outerboxes'] = $this->m_reports->getItemsInvoiceRegisterTe($from_date, $to_date, $item_name);
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
		$this->load->view('v_2_item_invoice-register', $data);
	}


	function custinvoiceRegister()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'custinvoiceRegister';
		$data['page_title'] = 'Customer Invoice Register';
		// $data['f_date'] = date("01-m-Y");
		$data['f_date'] = date("d-m-Y", strtotime(date("d-m-Y", time()) . " - 1 year"));
		$data['t_date'] = date("d-m-Y");
		$data['customer_name'] = null;
		$data['item_id'] = null;
		$from_date = date("Y-m-01");
		$to_date = date("Y-m-d");
		$customer_name = null;
		$item_id = null;
		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));

			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');

			if ($this->input->post('item_id')) {
				$item_id = $this->input->post('item_id');
				$data['item_id'] = $this->input->post('item_id');
			} else {
				$item_id = null;
				$data['item_id'] = null;
			}
			if ($this->input->post('customer_name')) {
				$customer_name = $this->input->post('customer_name');
				$data['customer_name'] = $this->input->post('customer_name');
			} else {
				$customer_name = null;
				$data['customer_name'] = null;
			}
		}
		$data['cust_pack_register'] = $this->m_reports->get_cust_invoice_reg_te($from_date, $to_date, $customer_name, $item_id);
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
		$this->load->view('v_2_customer_invoice-register', $data);
	}
	/* legrand charles (Tapes and Elastic ) */

	function deletedBoxes_1()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'deletedBoxes_1';
		$data['page_title'] = 'Deleted Boxes - Yarn and Thread';
		// $data['f_date'] = date("01-m-Y");
		$data['f_date'] = date("d-m-Y", strtotime(date("d-m-Y", time()) . " - 1 year"));
		$data['t_date'] = date("d-m-Y");
		$data['item'] = null;
		$from_date = date("Y-m-01");
		$to_date = date("Y-m-d");
		$item_name = null;
		$box_prefix = null;
		if (isset($_POST['search'])) {
			$from_date = $this->input->post('from_date');
			$to_date = $this->input->post('to_date');
			$item_name = $this->input->post('item_name');

			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			$data['item'] = $item_name;

			$ed = explode("-", $from_date);
			$from_date = $ed[2] . '-' . $ed[1] . '-' . $ed[0];

			$ed = explode("-", $to_date);
			$to_date = $ed[2] . '-' . $ed[1] . '-' . $ed[0];

			$where_array = array(
				'packing_date >=' => $from_date,
				'packing_date <=' => $to_date
			);
			if ($item_name != '') {
				$where_array['packing_innerbox_items'] = $item_name;
			} else {
				$item_name = null;
			}
		}
		$data['outerboxes'] = $this->m_reports->getDeletedItemsYt($from_date, $to_date, $box_prefix, $item_name);
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
		$this->load->view('v_1_deleted-boxes.php', $data);
	}
	function deletePermBoxes_1()
	{
		$selected_boxes = $this->input->post('selected_boxes');
		$result = $this->m_reports->deleteBoxes('bud_yt_packing_boxes', 'box_id', implode(",", $selected_boxes));
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Deleted!!!');
			redirect(base_url() . "reports/deletedBoxes_1", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "reports/deletedBoxes_1", 'refresh');
		}
	}
	function deletedBoxes()
	{
		$data['activeTab'] = 'admin';
		$data['activeItem'] = 'deletedBoxes';
		$data['page_title'] = 'Deleted Boxes';
		$data['outerboxes'] = $this->m_masters->getallmaster('bud_te_outerboxes_deleted');
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
		$this->load->view('v_2_deleted-boxes', $data);
	}
	function tpt_delivery_1()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'tpt_delivery_1';
		$data['page_title'] = 'Print DC';
		// $data['deliveries'] = $this->m_masters->getactivemaster('bud_yt_delivery','invoice_status');
		$data['deliveries'] = $this->m_masters->getallmaster('bud_yt_delivery');

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
		$this->load->view('v_1_delivery_rpt.php', $data);
	}
	function rpt_predelivery_1()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'rpt_predelivery_1';
		$data['page_title'] = 'Edit Pre. DC';
		$data['pre_deliveries'] = $this->m_masters->getallmaster('bud_yt_predelivery');

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
		$this->load->view('v_1_predelivery_rpt.php', $data);
	}
	function rpt_predelivery_2()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'rpt_predelivery_2';
		$data['page_title'] = 'Pre Deliveries';
		$data['pre_deliveries'] = $this->m_masters->getallmaster('bud_te_predelivery');

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
		$this->load->view('v_2_predelivery_rpt.php', $data);
	}

	function rpt_delivery_2()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'rpt_delivery_2';
		$data['page_title'] = 'Deliveries';
		$data['deliveries'] = $this->m_masters->getactivemaster('bud_te_delivery', 'is_deleted'); //delivery delete tapes

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
		$this->load->view('v_2_delivery_rpt.php', $data);
	}
	function rpt_predelivery_3()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'rpt_predelivery_3';
		$data['page_title'] = 'Pre Deliveries';
		$data['pre_deliveries'] = $this->m_masters->getallmaster('bud_lbl_predelivery');

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
		$this->load->view('labels/v_3_predelivery_rpt.php', $data);
	}
	function rpt_delivery_3()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'rpt_delivery_3';
		$data['page_title'] = 'Deliveries';
		$data['item_id'] = null;
		$data['cust_id'] = null;
		$pre_yr = date('Y');
		$pre_yr = $pre_yr - 1;
		$data['f_date'] = (date('m') < 4) ? date("d-m-Y", strtotime('01-04-' . $pre_yr)) : date("d-m-Y", strtotime('01-04-' . date('Y')));
		$data['t_date'] = date("d-m-Y");
		$data['deliveries'] = array();
		if (isset($_POST['search'])) {
			$data['item_id'] = $this->input->post('item_id');
			$data['f_date'] = $this->input->post('f_date');
			$data['t_date'] = $this->input->post('t_date');
			$data['cust_id'] = $this->input->post('cust_id');
			$data['deliveries'] = $this->m_reports->get_dc_details_lbl($data['f_date'], $data['t_date'], $data['cust_id']);
		}
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
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
		$this->load->view('labels/v_3_delivery_rpt.php', $data);
	}

	/* legrand charles (labels) */
	function packingRegister_3()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'packingRegister_3';
		$data['page_title'] = 'Packing Register Labels';
		// $data['f_date'] = date("01-m-Y");
		$data['f_date'] = date("d-m-Y", strtotime(date("d-m-Y", time()) . " - 1 year"));
		$data['t_date'] = date("d-m-Y");
		$data['item'] = null;
		$from_date = date("Y-m-01", strtotime(date("d-m-Y", time()) . " - 1 year"));
		$to_date = date("Y-m-d");
		$item_name = null;
		$item_group_id = null;
		$box_prefix = null;
		$data['outerboxes'] = array();
		if (isset($_POST['search'])) {
			$from_date = $this->input->post('from_date');
			$to_date = $this->input->post('to_date');
			$item_name = $this->input->post('item_name');
			$item_group_id = $this->input->post('item_group_id');

			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			$data['item'] = $item_name;
			$data['item_group_id'] = $item_group_id;

			$ed = explode("-", $from_date);
			$from_date = $ed[2] . '-' . $ed[1] . '-' . $ed[0];

			$ed = explode("-", $to_date);
			$to_date = $ed[2] . '-' . $ed[1] . '-' . $ed[0];
			$data['outerboxes'] = $this->m_reports->getPackingItemsLbl($from_date, $to_date, $box_prefix, $item_name, $item_group_id);
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
		$this->load->view('v_3_packing-register.php', $data);
	}
	function custPackRegister_3()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'custPackRegister_3';
		$data['page_title'] = 'Customer Packing Register';
		// $data['f_date'] = date("01-m-Y");
		$data['item_id'] = '';
		$data['f_date'] = date("d-m-Y", strtotime(date("d-m-Y", time()) . " - 1 year"));
		$data['t_date'] = date("d-m-Y");
		$data['customer_name'] = null;
		$from_date = date("Y-m-01");
		$to_date = date("Y-m-d");
		$customer_name = null;
		$item_id = null;
		$box_prefix = null;
		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');

			if ($this->input->post('customer_name')) {
				$customer_name = $this->input->post('customer_name');
				$data['customer_name'] = $this->input->post('customer_name');
			} else {
				$customer_name = null;
				$data['customer_name'] = null;
			}
			if ($this->input->post('item_id')) {
				$item_id = $this->input->post('item_id');
				$data['item_id'] = $this->input->post('item_id');
			} else {
				$item_id = null;
				$data['item_id'] = null;
			}
		}
		$data['cust_pack_register'] = $this->m_reports->get_cust_pack_reg_lbl($from_date, $to_date, $customer_name, $item_id);
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
		$this->load->view('v_3_cust-pack-register', $data);
	}

	function stock_register_3()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'stock_register_3';
		$data['page_title'] = 'Stock Register';
		// $data['f_date'] = date("01-m-Y");
		$data['f_date'] = date("d-m-Y", strtotime(date("d-m-Y", time()) . " - 1 year"));
		$data['t_date'] = date("d-m-Y");
		$data['item_id'] = null;
		$data['customer_name'] = null;
		$from_date = date("Y-m-01");
		$to_date = date("Y-m-d");
		$customer_name = null;
		$item_id = null;
		$box_prefix = null;
		$shade_id = null;
		$room_id = null;
		$room_no = null;

		$data['shade_id'] = null;
		$data['room_no'] = null;
		$data['room_id'] = null;

		$this->db->select('*');
		$this->db->from('bud_shades');
		$query = $this->db->get();
		$data['colors'] = $query->result_array();

		$this->db->select('*');
		$this->db->from('bud_stock_rooms');
		$query = $this->db->get();
		$data['room_no'] = $query->result_array();

		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			$room_id = $this->input->post('rno');
			$data['room_id'] = $room_id;

			if ($this->input->post('customer_name')) {
				$customer_name = $this->input->post('customer_name');
				$data['customer_name'] = $this->input->post('customer_name');
			} else {
				$customer_name = null;
				$data['customer_name'] = null;
			}
			if ($this->input->post('item_id')) {
				$item_id = $this->input->post('item_id');
				$data['item_id'] = $this->input->post('item_id');
			} else {
				$item_id = null;
				$data['item_id'] = null;
			}
		}
		$data['cust_pack_register'] = $this->m_reports->get_stock_reg_lbl($from_date, $to_date, $customer_name, $item_id, $room_id);
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
		$this->load->view('v_3_stock-register', $data);
	}


	function deletedboxRegister_3()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'deletedboxRegister_3';
		$data['page_title'] = 'Deleted Register';
		// $data['f_date'] = date("01-m-Y");
		$data['f_date'] = date("d-m-Y", strtotime(date("d-m-Y", time()) . " - 1 year"));
		$data['t_date'] = date("d-m-Y");
		$data['item_id'] = '';
		$item_id = '';
		$from_date = date("Y-m-01");
		$to_date = date("Y-m-d");
		$box_prefix = null;
		$data['section_id'] = null;
		$data['sub_page_title'] = "Deleted Register";
		if (isset($_POST['search'])) {
			// print_r($_POST);
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));

			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			$data['section_id'] = $this->input->post('section_id');
			$item_id = $this->input->post('item_id');
			$data['item_id'] = $this->input->post('item_id');
		}
		switch ($data['section_id']) {
			case 'box':
				$data['outerboxes'] = $this->m_reports->getDeletedBoxesLbl($from_date, $to_date, $box_prefix, $item_id);
				$data['sub_page_title'] = "Deleted Boxes";
				break;
			case 'dc':
				$data['outerboxes'] = $this->m_reports->get_dc_details_lbl($from_date, $to_date, null, 0);
				$data['sub_page_title'] = "Deleted Deliveries";
				break;
			case 'pdc':
				$data['outerboxes'] = $this->m_reports->get_pdc_details_lbl($from_date, $to_date, null, 0);
				$data['sub_page_title'] = "Deleted Predeliveries";
				break;
			case 'inv':
				$data['outerboxes'] = $this->m_reports->get_inv_details_lbl($from_date, $to_date, 1);
				$data['sub_page_title'] = "Deleted Invoices";
				break;
			default:
				$data['outerboxes'] = array();
				break;
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
		$this->load->view('v_3_deleted-boxes-register', $data);
	}

	function itemdeliveryRegister_3()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'itemdeliveryRegister_3';
		$data['page_title'] = 'Item Delivery Register';
		// $data['f_date'] = date("01-m-Y");
		$data['f_date'] = date("d-m-Y", strtotime(date("d-m-Y", time()) . " - 1 year"));
		$data['t_date'] = date("d-m-Y");
		$data['item'] = null;
		$from_date = date("Y-m-01");
		$to_date = date("Y-m-d");
		$item_name = null;
		$box_prefix = null;
		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
			$item_name = $this->input->post('item_name');

			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			$data['item'] = $item_name;

			$where_array = array(
				'packing_date >=' => $from_date,
				'packing_date <=' => $to_date
			);
			if ($item_name != '') {
				$where_array['packing_innerbox_items'] = $item_name;
			} else {
				$item_name = null;
			}
		}
		$data['outerboxes'] = $this->m_reports->getItemsDeliveryRegisterLbl($from_date, $to_date, $box_prefix, $item_name);
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
		$this->load->view('v_3_item_delivery-register', $data);
	}


	function custdeliveryRegister_3()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'custdeliveryRegister_3';
		$data['page_title'] = 'Customer Delivery Register';
		// $data['f_date'] = date("01-m-Y");
		$data['f_date'] = date("d-m-Y", strtotime(date("d-m-Y", time()) . " - 1 year"));
		$data['t_date'] = date("d-m-Y");
		$data['customer_name'] = null;
		$from_date = date("Y-m-01");
		$to_date = date("Y-m-d");
		$customer_name = null;
		$item_id = null;
		$box_prefix = null;
		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');

			if ($this->input->post('customer_name')) {
				$customer_name = $this->input->post('customer_name');
				$data['customer_name'] = $this->input->post('customer_name');
			} else {
				$customer_name = null;
				$data['customer_name'] = null;
			}
			if ($this->input->post('item_id')) {
				$item_id = $this->input->post('item_id');
				$data['item_id'] = $this->input->post('item_id');
			} else {
				$item_id = null;
				$data['item_id'] = null;
			}
		}
		$data['cust_pack_register'] = $this->m_reports->get_cust_delivery_reg_lbl($from_date, $to_date, $customer_name, $item_id);
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
		$this->load->view('v_3_customer_delivery-register', $data);
	}


	function iteminvoiceRegister_3()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'iteminvoiceRegister_3';
		$data['page_title'] = 'Item Invoice Register';
		// $data['f_date'] = date("01-m-Y");
		$data['f_date'] = date("d-m-Y", strtotime(date("d-m-Y", time()) . " - 1 year"));
		$data['t_date'] = date("d-m-Y");
		$data['item'] = null;
		$from_date = date("Y-m-01");
		$to_date = date("Y-m-d");
		$item_name = null;
		$box_prefix = null;
		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
			$item_name = $this->input->post('item_name');

			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			$data['item'] = $item_name;

			$where_array = array(
				'packing_date >=' => $from_date,
				'packing_date <=' => $to_date
			);
			if ($item_name != '') {
				$where_array['packing_innerbox_items'] = $item_name;
			} else {
				$item_name = null;
			}
		}
		$data['outerboxes'] = $this->m_reports->getItemsInvoiceRegisterLbl($from_date, $to_date, $box_prefix, $item_name);
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
		$this->load->view('v_3_item_invoice-register', $data);
	}


	function custinvoiceRegister_3()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'custinvoiceRegister_3';
		$data['page_title'] = 'Customer Invoice Register';
		// $data['f_date'] = date("01-m-Y");
		$data['f_date'] = date("d-m-Y", strtotime(date("d-m-Y", time()) . " - 1 year"));
		$data['t_date'] = date("d-m-Y");
		$data['item_id'] = null;
		$data['customer_name'] = null;
		$from_date = date("Y-m-01");
		$to_date = date("Y-m-d");
		$customer_name = null;
		$item_id = null;
		$box_prefix = null;
		if (isset($_POST['search'])) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');

			if ($this->input->post('customer_name')) {
				$customer_name = $this->input->post('customer_name');
				$data['customer_name'] = $this->input->post('customer_name');
			} else {
				$customer_name = null;
				$data['customer_name'] = null;
			}
			if ($this->input->post('item_id')) {
				$item_id = $this->input->post('item_id');
				$data['item_id'] = $this->input->post('item_id');
			} else {
				$item_id = null;
				$data['item_id'] = null;
			}
		}
		$data['cust_pack_register'] = $this->m_reports->get_cust_invoice_reg_lbl($from_date, $to_date, $customer_name, $item_id);
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
		$this->load->view('v_3_customer_invoice-register', $data);
	}

	function deletedBoxes_3()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'deletedBoxes_3';
		$data['page_title'] = 'Deleted Register - Label';
		// $data['f_date'] = date("01-m-Y");
		$data['f_date'] = date("d-m-Y", strtotime(date("d-m-Y", time()) . " - 1 year"));
		$data['t_date'] = date("d-m-Y");
		$data['item'] = null;
		$from_date = date("Y-m-01");
		$to_date = date("Y-m-d");
		$item_name = null;
		$box_prefix = null;
		if (isset($_POST['search'])) {
			$from_date = $this->input->post('from_date');
			$to_date = $this->input->post('to_date');
			$item_name = $this->input->post('item_name');

			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			$data['item'] = $item_name;

			$ed = explode("-", $from_date);
			$from_date = $ed[2] . '-' . $ed[1] . '-' . $ed[0];

			$ed = explode("-", $to_date);
			$to_date = $ed[2] . '-' . $ed[1] . '-' . $ed[0];

			$where_array = array(
				'packing_date >=' => $from_date,
				'packing_date <=' => $to_date
			);
			if ($item_name != '') {
				$where_array['packing_innerbox_items'] = $item_name;
			} else {
				$item_name = null;
			}
		}
		$data['outerboxes'] = $this->m_reports->getDeletedItemsLbl($from_date, $to_date, $box_prefix, $item_name);
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
		$this->load->view('v_3_deleted-boxes', $data);
	}
	function deletePermBoxes_3()
	{
		$selected_boxes = $this->input->post('selected_boxes');
		$result = $this->m_reports->deleteBoxes('bud_lbl_outerboxes', 'box_no', implode(",", $selected_boxes));
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Deleted!!!');
			redirect(base_url() . "reports/deletedBoxes_3", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "reports/deletedBoxes_3", 'refresh');
		}
	}
	/* legrand charles (labels) */

	function recipe_register()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'recipe_register';
		$data['page_title'] = 'Recipe Register';

		$data['family_id'] = '';
		$data['shade_id'] = '';
		$data['shades'] = array();

		if ($this->input->post('search')) {
			$data['family_id'] = $this->input->post('family_id');
			$data['shade_id'] = $this->input->post('shade_id');
		}

		if (!empty($data['family_id'])) {
			$shades = $this->m_masters->getmasterdetails('bud_shades', 'shade_category', $data['family_id']);
			$data['shades'] = $shades;
		}
		$family_id = $data['family_id'];
		$shade_id = $data['shade_id'];

		$data['recipe_list'] = $this->m_masters->get_recipe_list($family_id, $shade_id);
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
		$this->load->view('v_recipe_register.php', $data);
	}

	function poy_gain_report()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'poy_gain_report';
		$data['page_title'] = 'POY Gain Reports';

		$data['poy_lots'] = $this->m_masters->getactivemaster('bud_poy_lots', 'poy_status');

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
		$this->load->view('v_poy_gain_report', $data);
	}
	//packing against roll entry in Labels
	function pack_against_roll_lbl()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'pack_against_roll_lbl';
		$data['page_title'] = 'Packing against Roll entry in Labels';
		$data['item_id'] = null;
		$data['cust_id'] = null;
		$pre_yr = date('Y');
		$pre_yr = $pre_yr - 1;
		$data['f_date'] = (date('m') < 4) ? date("d-m-Y", strtotime('01-04-' . $pre_yr)) : date("d-m-Y", strtotime('01-04-' . date('Y')));
		$data['t_date'] = date("d-m-Y");
		$data['packing_register'] = array();
		if (isset($_POST['search'])) {
			$data['item_id'] = $this->input->post('item_id');
			$data['cust_id'] = $this->input->post('cust_id');
			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
			$data['packing_register'] = $this->m_reports->get_cust_pack_reg_lbl($data['f_date'], $data['t_date']);
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
		$data['js_IE'] = array('js/html5shiv.js', 'js/respond.min.js');
		$data['css_print'] = array(
			'css/invoice-print.css'
		);
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
		$this->load->view('labels/v_3_pack_against_roll_lbl.php', $data);
	}
	//Label Production Report
	function roll_entry_report_3() //ER-10-18#-68
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'roll_entry_report_3';
		$data['page_title'] = 'Roll entry report Labels';
		$data['item_id'] = null;
		$data['machine_no'] = null;
		$data['operator_id'] = null;
		$data['shift'] = null;
		$data['f_date'] = date('Y-m-d', strtotime("-1 month"));
		$data['t_date'] = date('Y-m-d');
		$data['items'] = $this->m_masters->getactivemaster('bud_lbl_items', 'item_status');
		$data['machines'] = $this->m_masters->getactivemaster('bud_te_machines', 'machine_status');
		$data['operators'] = $this->m_masters->getallmaster('bud_users');
		$data['entries'] = array();
		if (isset($_POST['search'])) {
			$data['machine_no'] = $this->input->post('machine_no');
			$data['operator_id'] = $this->input->post('operator_id');
			$data['shift'] = $this->input->post('shift');
			$data['item_id'] = $this->input->post('item_id');
			$data['f_date'] = $this->input->post('from_date');
			$data['t_date'] = $this->input->post('to_date');
		}
		$data['entries'] = $this->m_reports->get_rolls_register($data['f_date'], $data['t_date'], $data['item_id'], $data['machine_no'], $data['operator_id'], $data['shift']);
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
		$data['css_print'] = array(
			'css/invoice-print.css'
		);
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
		$this->load->view('labels/v_3_roll_entry_report.php', $data);
	}
	//Production Sheet
	function prod_sheet_3()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'prod_sheet_3';
		$data['page_title'] = 'Production Sheets in Labels';
		$data['item_id'] = null;
		$data['machine_id'] = null;
		$data['cust_id'] = null;
		$data['sappono'] = null;
		$pre_yr = date('Y');
		$pre_yr = $pre_yr - 1;
		$data['f_date'] = (date('m') < 4) ? date("d-m-Y", strtotime('01-04-' . $pre_yr)) : date("d-m-Y", strtotime('01-04-' . date('Y')));
		$data['t_date'] = date("d-m-Y");
		$data['ps_details'] = array();
		if ($this->uri->segment(3)) {
			$data['sappono'] = $this->uri->segment(3);
			$data['ps_details'] = $this->m_purchase->getPsDetails();
		}
		if (isset($_POST['search'])) {
			$data['item_id'] = $this->input->post('item_id');
			$data['f_date'] = $this->input->post('f_date');
			$data['t_date'] = $this->input->post('t_date');
			$data['machine_id'] = $this->input->post('machine_id');
			$data['cust_id'] = $this->input->post('cust_id');
			$data['sappono'] = $this->input->post('sappono');
			$data['ps_details'] = $this->m_purchase->getPsDetails(null, $data['f_date'], $data['t_date'], $data['item_id'], $data['machine_id']);
		}
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['machines'] = $this->m_masters->getactivemaster('bud_te_machines', 'machine_status');
		$data['items'] = $this->m_masters->getactivemaster('bud_lbl_items', 'item_status');
		$data['sappo'] = $this->m_masters->getactivemaster('bud_lbl_po', 'po_is_deleted');
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
		$data['css_print'] = array(
			'css/invoice-print.css'
		);
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
		$this->load->view('v_3_prod_sheet_report', $data);
	}
	//Purchase Order Report Label
	function po_report_lbl()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'po_report_lbl';
		$data['page_title'] = 'Purchase Order Register for Labels';
		$data['item_id'] = null;
		$data['cust_id'] = null;
		$data['sappono'] = null;
		$pre_yr = date('Y');
		$pre_yr = $pre_yr - 1;
		$data['f_date'] = (date('m') < 4) ? date("d-m-Y", strtotime('01-04-' . $pre_yr)) : date("d-m-Y", strtotime('01-04-' . date('Y')));
		$data['t_date'] = date("d-m-Y");
		$data['po_details'] = array();
		if (isset($_POST['search'])) {
			$data['item_id'] = $this->input->post('item_id');
			$data['f_date'] = $this->input->post('f_date');
			$data['t_date'] = $this->input->post('t_date');
			$data['cust_id'] = $this->input->post('cust_id');
			$data['sappono'] = $this->input->post('sappono');
			$data['po_details'] = $this->m_purchase->getPoDetails($data['f_date'], $data['t_date'], $data['cust_id'], $data['sappono']);
		}
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['items'] = $this->m_masters->getactivemaster('bud_lbl_items', 'item_status');
		$data['sappo'] = $this->m_masters->getactivemaster('bud_lbl_po', 'po_is_deleted');
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
		$data['css_print'] = array(
			'css/invoice-print.css'
		);
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
		$this->load->view('po_report_lbl', $data);
	}
	function boxStatus_3()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'boxStatus_3';
		$data['page_title'] = 'Box Status Register Labels';
		$data['f_box'] = null;
		$data['t_box']  = null;
		$data['boxes'] = null;
		$data['outerboxes'] = array();
		if (isset($_POST['search'])) {
			$data['f_box'] = $this->input->post('from_box');
			$data['t_box']  = $this->input->post('to_box');
			$data['boxes'] = $this->input->post('boxes');
			$boxes_array = ($data['boxes']) ? explode(',', $data['boxes']) : array();
			$data['outerboxes'] = $this->m_reports->getBoxStatusLbl($data['f_box'], $data['t_box'], $boxes_array);
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
		$this->load->view('v_3_box_status.php', $data);
	}
	function poy_register_1()
	{
		$data['activeTab'] = 'reports';
		$data['activeItem'] = 'poy_register_1';
		$data['page_title'] = 'POY Register-Yarn & Thread';
		$data['item_id'] = null;
		$data['poy_inward_no'] = null;
		$data['supplier_id'] = null;
		$data['poy_denier_id'] = null;
		$pre_yr = date('Y');
		$pre_yr = $pre_yr - 1;
		$data['f_date'] = (date('m') < 4) ? date("d-m-Y", strtotime('01-04-' . $pre_yr)) : date("d-m-Y", strtotime('01-04-' . date('Y')));
		$data['t_date'] = date("d-m-Y");
		$data['poy_details'] = array();
		if (isset($_POST['search'])) {
			$data['item_id'] = $this->input->post('item_id');
			$data['f_date'] = $this->input->post('f_date');
			$data['t_date'] = $this->input->post('t_date');
			$data['poy_inward_no'] = $this->input->post('cust_id');
			$data['supplier_id'] = $this->input->post('supplier_id');
			$data['poy_denier_id'] = $this->input->post('poy_denier_id');
			$data['poy_inward_no'] = $this->input->post('poy_inward_no');
			$data['poy_details'] = $this->m_reports->getPoyDetails($data['f_date'], $data['t_date'], $data['supplier_id'], $data['item_id'], $data['poy_inward_no'], $data['poy_denier_id']);
		}
		$data['supplier'] = $this->m_masters->getactivemaster('bud_suppliers', 'sup_status');
		$data['items'] = $this->m_masters->getactivemaster('bud_items', 'item_status');
		$data['poy_inward'] = $this->m_masters->getallmaster('bud_yt_poy_inward');
		$data['poy_deniers'] = $this->m_masters->getactivemaster('bud_yt_poydeniers', 'denier_status');
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
		$this->load->view('v_1_poy_register.php', $data);
	}
}
