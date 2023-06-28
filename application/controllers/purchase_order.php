<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Purchase_order extends CI_Controller
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
		$this->load->model('ak');
		$this->load->model('m_mycart'); //lbl PO & PS
		$this->load->model('m_mir'); //lbl PO & PS
		$this->load->model('m_admin'); //lbl PO & PS
		$this->load->library('cart');

		if (!$this->session->userdata('logged_in')) {
			// Allow some methods?
			$allowed = array();
			if (!in_array($this->router->method, $allowed)) {
				redirect(base_url() . 'users/login', 'refresh');
			}
		}
	}

	function get_dyes_chem()
	{
		$return = array();
		$dyes_chem = array();
		$dc_family_id = $this->input->post('dc_family_id');
		$dyes_chems = $this->m_purchase->get_dyes_chem($dc_family_id);
		foreach ($dyes_chems as $row) {
			$dyes_chem[$row->dyes_chem_id] = $row->dyes_chem_name . ' - ' . $row->dyes_chem_code;
		}
		$return['dyes_chem'] = $dyes_chem;
		echo json_encode($return);
	}

	function dyes_chem_inward($inward_no = false, $new = false)
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_dyes_chem_inward'");
		$next = $next->row(0);
		$data['next'] = $next->Auto_increment;
		$data['activeTab'] = 'purchase_order';
		$data['activeItem'] = 'dyes_chem_inward';
		$data['page_title'] = 'Dyes and Chemicals Inward Entry';
		$data['dyes_chem_families'] = $this->m_masters->getallmaster('bud_dyes_chem_families');
		$data['shades'] = $this->m_masters->getallmaster('bud_shades');
		$data['uoms'] = $this->m_masters->getallmaster('bud_uoms');
		$data['suppliers'] = $this->m_masters->getallmaster('bud_suppliers');
		$data['register'] = $this->m_purchase->get_dyes_chem_reg();
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

		$this->load->library("form_validation");
		$data['inward_no'] = $inward_no;
		$data['new'] = $new;
		$data['inward_date'] = date("Y-m-d H:i:s");
		$data['dc_family_id'] = '';
		$data['dyes_chem_id'] = '';
		$data['sup_id'] = '';
		$data['sup_dc_no'] = '';
		$data['qty_received'] = '';
		$data['uom_id'] = '';
		$data['item_rate'] = '';
		$data['dyes_chems'] = array();
		if ($inward_no) {
			$data['next'] = $inward_no;
			$inward = $this->m_purchase->get_dyes_chem_inward($inward_no);
			if (!$inward) {
				$this->session->set_flashdata('error', 'No Record Found');
				redirect(base_url('purchase_order/dyes_chem_inward'), 'refresh');
			}
			$data['inward_no'] = $inward->inward_no;
			$data['inward_date'] = $inward->inward_date;
			$data['dc_family_id'] = $inward->dc_family_id;
			$data['dyes_chem_id'] = $inward->dyes_chem_id;
			$data['sup_id'] = $inward->sup_id;
			$data['sup_dc_no'] = $inward->sup_dc_no;
			$data['qty_received'] = $inward->qty_received;
			$data['uom_id'] = $inward->uom_id;
			$data['item_rate'] = $inward->item_rate;

			$items = $this->m_purchase->get_dyes_chem($inward->dc_family_id);
			foreach ($items as $row) {
				$dyes_chems[$row->dyes_chem_id] = $row->dyes_chem_name . ' - ' . $row->dyes_chem_code;
			}
			$data['dyes_chems'] = $dyes_chems;
		}
		$this->form_validation->set_rules('dc_family_id', 'Item Family', 'required');
		$this->form_validation->set_rules('dyes_chem_id', 'Item Name', 'required');
		$this->form_validation->set_rules('qty_received', 'Qty Received', 'required');
		$this->form_validation->set_rules('uom_id', 'UOM', 'required');
		$this->form_validation->set_rules('item_rate', 'Item Rate', 'required');

		if ($this->input->post('save')) {
			$data['inward_no'] = $inward_no;
			$data['inward_date'] = date("Y-m-d H:i:s");
			$data['dc_family_id'] = $this->input->post('dc_family_id');
			$data['dyes_chem_id'] = $this->input->post('dyes_chem_id');
			$data['sup_id'] = $this->input->post('sup_id');
			$data['sup_dc_no'] = $this->input->post('sup_dc_no');
			$data['qty_received'] = $this->input->post('qty_received');
			$data['uom_id'] = $this->input->post('uom_id');
			$data['item_rate'] = $this->input->post('item_rate');
		}
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('dyes_chem_inward', $data);
		} else {
			if (empty($new)) {
				$save['inward_no'] = $inward_no;
			} else {
				$save['inward_no'] = '';
			}
			$save['inward_date'] = date("Y-m-d H:i:s");
			$save['dc_family_id'] = $this->input->post('dc_family_id');
			$save['dyes_chem_id'] = $this->input->post('dyes_chem_id');
			$save['sup_id'] = $this->input->post('sup_id');
			$save['sup_dc_no'] = $this->input->post('sup_dc_no');
			$save['qty_received'] = $this->input->post('qty_received');
			$save['uom_id'] = $this->input->post('uom_id');
			$save['item_rate'] = $this->input->post('item_rate');
			$save['inward_by'] = $this->session->userdata('display_name');

			$this->m_purchase->save_dyes_chem($save);
			$this->session->set_flashdata('success', 'Successfully Saved');
			redirect(base_url('purchase_order/dyes_chem_inward'));
		}
	}

	function po_from_customers()
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'ak_po_from_customers'");
		$next = $next->row(0);

		$this->db->select('*');
		$this->db->from('bud_yt_packing_boxes');
		$this->db->group_by('lot_no');
		$query = $this->db->get();
		$data['lot_no'] = $query->result_array();

		$data['next'] = $next->Auto_increment;
		$data['activeTab'] = 'purchase_order';
		$data['activeItem'] = 'po_from_customers';
		$data['page_title'] = 'Purchase order from Customers';
		$data['customers'] = $this->m_masters->getallmaster('bud_customers');
		$data['items'] = $this->m_masters->getallmaster('bud_items');
		$data['uoms'] = $this->m_masters->getallmaster('bud_uoms');
		$data['shades'] = $this->m_masters->getallmaster('bud_shades');
		$data['table'] = $this->ak->ak_po_from_customers();
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

		$this->load->view('po_from_customers', $data);
	}

	function po_from_customers_save()
	{
		$data = array(
			'date' => $_POST['date'],
			'bud_customers' => $_POST['customer'],
			'c_name' => $_POST['po_person'],
			'cust_epono' => $_POST['cust_epono'],
			'c_tel' => $_POST['po_number'],
			'user' => $_POST['user'],
			'remark' => $_POST['remarks']
		);
		$rid = $this->ak->insert_new('ak_po_from_customers', $data);

		for ($a = 0; $a < count($_POST['item']); $a++) {
			$itms = array(
				'R_po_no' => $rid,
				'cust_epono' => $_POST['cust_epono'],
				'bud_items' => $_POST['item'][$a],
				'cust_shade_name' => $_POST['c_shade'][$a],
				'bud_shades' => $_POST['colour'][$a],
				'qty' => $_POST['qty'][$a],
				'bud_uoms' => $_POST['uom'][$a],
				'rate' => $_POST['rate'][$a],
				'tax' => $_POST['tax'][$a]
			);
			$this->ak->insert_new('ak_po_from_customers_items', $itms);
		}
		$this->session->set_flashdata('success', 'Successfully Saved!!!');
		redirect(base_url() . 'purchase_order/po_from_customers', 'refresh');
	}

	function po_from_customers_table_details($id)
	{
		$result = $this->ak->po_from_customers_table_details($id);

		$Sno = 1;
		foreach ($result as $row) {
			echo    "<tr>
                        <th>" . $Sno . "</th>
                        <th>" . $id . "</th>
                        <th>" . @$row['cust_epono'] . "</th>
                        <th>" . $row['item_name'] . " - " . $row['item_code'] . "</th>
                        <th>" . $row['cust_shade_name'] . "</th>
                        <th>" . $row['shade_name'] . " - " . $row['shade_code'] . "</th>
						<th>" . $row['qty'] . "</th>
						<th>" . $row['uom_name'] . "</th>
                        <th>" . $row['rate'] . "</th>
						<th>" . $row['tax'] . "</th>
                    </tr>";
			++$Sno;
		}
	}

	function po_to_dye()
	{
		$data['activeTab'] = 'purchase_order';
		$data['activeItem'] = 'po_to_dye';
		$data['page_title'] = 'Purchase order to Dying Department';
		$data['table'] = $this->ak->ak_po_from_customers();
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

		$this->load->view('po_to_dyeing', $data);
	}

	function update_po_from_customers($id, $date)
	{
		$qd = explode("-", $date);
		$date = $qd[2] . '-' . $qd[1] . '-' . $qd[0];

		$data = array(
			'need_date' => $date,
			'status' => 1
		);
		echo $this->ak->update_po_from_customers($id, $data);
	}

	function po_dyeing_production()
	{
		$data['activeTab'] = 'purchase_order';
		$data['activeItem'] = 'po_dyeing_production';
		$data['page_title'] = 'Lot Production';
		$data['table'] = $this->ak->ak_po_from_customers();
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

		$this->load->view('po_dyeing_production', $data);
	}

	function update_po_from_customers_master($id, $date)
	{
		$qd = explode("-", $date);
		$date = $qd[2] . '-' . $qd[1] . '-' . $qd[0];

		$data = array(
			'master_date' => $date,
		);
		echo $this->ak->update_po_from_customers_master($id, $data);
	}

	function po_from_customers_table_details_lot($id)
	{
		$result = $this->ak->po_from_customers_table_details($id);

		$Sno = 1;
		foreach ($result as $row) {
			echo    "<tr>
                        <th>" . $Sno . "</th>
                        <th>" . $id . "</th>
                        <th>" . $row['item_name'] . " - " . $row['item_code'] . "</th>
                        <th>" . $row['cust_shade_name'] . "</th>
                        <th>" . $row['shade_name'] . " - " . $row['shade_code'] . "</th>   // editable
						<th>" . $row['qty'] . "</th>
						<th>" . $row['uom_name'] . "</th>

                        <th><button class='btn btn-primary' onclick='get_form(" . $row['row_id'] . "," . $id . ")'>Production</button></th>

                    </tr>";
			++$Sno;
		}
	}

	function po_dyeing_production_form($id, $R_po_no)
	{
		$data['machines'] = $this->m_masters->getallmaster('bud_machines');
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_lots'");
		$next = $next->row(0);
		$data['next'] = $next->Auto_increment;

		$data['id'] = $id;
		$data['R_po_no'] = $R_po_no;

		$this->db->select('*')
			->from('ak_po_from_customers_items')
			->where('id', $id);
		$q = $this->db->get();
		$data['tot'] = $q->result_array()[0]['qty'];
		$data['lot_shade_no'] = $q->result_array()[0]['bud_shades'];
		$data['lot_item_id'] = $q->result_array()[0]['bud_items'];

		$lot_item_id = $data['lot_item_id'];
		$lot_shade_no = $data['lot_shade_no'];
		$po_no = $R_po_no;

		$this->db->select_sum('lot_actual_qty')
			->from('bud_lots')
			->where('lot_item_id', $lot_item_id)
			->where('lot_shade_no', $lot_shade_no)
			->where('po_no', $po_no);
		$q = $this->db->get();
		$val = $q->result_array()[0]['lot_actual_qty'];
		if ($val == "") {
			$data['balance'] = $data['tot'];
		} else {
			$data['balance'] =  $data['tot'] - $val;
		}

		$this->load->view('po_dyeing_production_form', $data);
	}

	function po_dyeing_production_form_save()
	{
		$nextlot = $this->input->post('nextlot');
		$po_no = $this->input->post('po_no');
		$lot_prefix = $this->input->post('lot_prefix');
		$lot_oil_required = $this->input->post('lot_oil_required');
		$lot_qty = $this->input->post('lot_qty');
		$lot_item_id = $this->input->post('lot_item_id');
		$lot_shade_no = $this->input->post('lot_shade_no');
		$no_springs = $this->input->post('no_springs');
		if($no_springs=='')
		{
			$no_springs=0;
		}
		$machine_prefix = $this->m_masters->getmasterIDvalue('bud_machines', 'machine_id', $lot_prefix, 'machine_prefix');
		$lot_no = $machine_prefix . $nextlot;
		$percentege = ($lot_oil_required * $lot_qty) / 100;
		$lot_actual_qty = $lot_qty + $percentege;

		$save = array(
			'lot_id' => '0',
			'po_no' => $po_no,
			'lot_prefix' => $lot_prefix,
			'lot_no' => $lot_no,
			'lot_item_id' => $lot_item_id,
			'lot_shade_no' => $lot_shade_no,
			'no_springs' => $no_springs,
			'lot_oil_required' => $lot_oil_required,
			'lot_qty' => $lot_qty,
			'lot_actual_qty' => $lot_actual_qty,
			'lot_status' => 1,
			'lot_created_date' => date("Y-m-d H:i:s")
		);
		$result = $this->m_masters->save_lot($save);
		if ($result) {
			echo "success";
		}
		/*$data = array(
					'R_po_no' => $R_po_no,
					'item_id' => $id,
					'qty' =>  $lot,
					'machine' => $machine
				);
		$qe = $this->ak->insert_new('ak_po_dye_production',$data);
		if($qe)
		{
			echo "success";
		}*/
	}

	/*// Old
	function po_dyeing_production_form_save($R_po_no,$id,$lot,$machine)
	{
		$data = array(
					'R_po_no' => $R_po_no,
					'item_id' => $id,
					'qty' =>  $lot,
					'machine' => $machine
				);
		$qe = $this->ak->insert_new('ak_po_dye_production',$data);
		if($qe)
		{
			echo "success";
		}
	}*/

	function get_lot_qty($lot_id = false)
	{
		$return = array();
		$lot_qty = 0.000;
		$no_springs = 0.000;
		$item_name = '';
		$shade_name = '';
		$shade_code = '';
		if (!empty($lot_id)) {
			$lot = $this->m_masters->get_lot($lot_id);
			if ($lot) {
				$lot_qty = $lot->lot_actual_qty;
				$no_springs = $lot->no_springs;
				$item_name = $lot->item_name . '/' . $lot->lot_item_id;
				$shade_name = $lot->shade_name . '/' . $lot->lot_shade_no;
				$shade_code = $lot->shade_code;
			}
		}

		$return['lot_qty'] = number_format($lot_qty, 3, '.', '');
		$return['no_springs'] = $no_springs;
		$return['item_name'] = $item_name;
		$return['shade_name'] = $shade_name;
		$return['shade_code'] = $shade_code;
		echo json_encode($return);
	}

	function po_DLCPacking($id = false)
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_dlc_packings'");
		$next = $next->row(0);
		$data['next'] = $next->Auto_increment;

		$filter = array();
		$filter['exclude_direct_entry'] = true;
		$data['lots'] = $this->m_masters->get_lots($filter);
		$data['departments'] = $this->m_masters->getactivemaster('bud_yt_departments', 'status');
		$data['users'] = $this->m_masters->getactivemaster('bud_users', 'user_status');
		$data['register'] = $this->m_purchase->get_dlc_packing_reg();
		// $data['register'] = $this->m_purchase->get_dlc_packing_reg();

		$data['activeTab'] = 'purchase_order';
		$data['activeItem'] = 'po_DLCPacking';
		$data['page_title'] = 'Dyed Loose Cone Packing Entry';

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

		$this->load->library("form_validation");

		$data['id'] = $id;
		$data['from_dept_id'] = '';
		$data['to_dept_id'] = '';
		$data['from_user_id'] = '';
		$data['to_user_id'] = '';
		$data['packed_date'] = '';
		$data['sent_through'] = '';
		$data['vehicle_no'] = '';
		$data['packed_by'] = '';
		$data['remarks'] = '';
		$data['packing_items'] = array();

		if ($id) {
			$box = $this->m_purchase->get_dlc_packing($id);
			if (!$box) {
				$this->session->set_flashdata('error', 'Record Not Found');
				redirect(base_url('purchase_order/po_DLCPacking'));
			}
			$data['id'] = $box->id;
			$data['from_dept_id'] = $box->from_dept_id;
			$data['to_dept_id'] = $box->to_dept_id;
			$data['from_user_id'] = $box->from_user_id;
			$data['to_user_id'] = $box->to_user_id;
			$data['packed_date'] = $box->packed_date;
			$data['sent_through'] = $box->sent_through;
			$data['vehicle_no'] = $box->vehicle_no;
			$data['packed_by'] = $box->packed_by;
			$data['remarks'] = $box->remarks;
			$data['packing_items'] = $this->m_purchase->get_dlc_packing_items($id);
		}
		// Set Validation Rules
		$this->form_validation->set_rules('vehicle_no', 'Vehicle No', 'required');

		if ($this->input->post('save')) {
			$data['id'] = $id;
			$data['from_dept_id'] = $this->input->post('from_dept_id');
			$data['to_dept_id'] = $this->input->post('to_dept_id');
			$data['from_user_id'] = $this->input->post('from_user_id');
			$data['to_user_id'] = $this->input->post('to_user_id');
			$data['sent_through'] = $this->input->post('sent_through');
			$data['vehicle_no'] = $this->input->post('vehicle_no');
			$data['packed_by'] = $this->input->post('packed_by');
			$data['remarks'] = $this->input->post('remarks');
			$data['packing_items'] = $this->input->post('packing_items');
		}
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('po_DLCPacking', $data);
		} else {
			$save['id'] = $id;
			$save['from_dept_id'] = $this->input->post('from_dept_id');
			$save['to_dept_id'] = $this->input->post('to_dept_id');
			$save['from_user_id'] = $this->input->post('from_user_id');
			$save['to_user_id'] = $this->input->post('to_user_id');
			$save['packed_date'] = date("Y-m-d H:i:s");
			$save['sent_through'] = $this->input->post('sent_through');
			$save['vehicle_no'] = $this->input->post('vehicle_no');
			$save['packed_by'] = $this->input->post('packed_by');
			$save['remarks'] = $this->input->post('remarks');
			$packing_items = $this->input->post('packing_items');

			$items = array();
			$no_springs_hold = '';
			$net_weight_hold = '';
			foreach ($packing_items as $key => $item) {
				$lot_id = $item['lot_id'];
				$no_springs_hold = $item['no_springs_hold'];
				$net_weight_hold = $item['net_weight_hold'];
				$lot = $this->m_masters->get_lot($lot_id);
				$items[$key]['lot_id'] = $lot->lot_id;
				$items[$key]['no_springs'] = $lot->no_springs - $no_springs_hold;
				$items[$key]['no_springs_hold'] = $no_springs_hold;
				$items[$key]['net_weight'] = $lot->lot_qty - $net_weight_hold;
				$items[$key]['net_weight_hold'] = $net_weight_hold;
			}
			$result = $this->m_purchase->save_dlc_packing($save, $items);
			
			$this->session->set_flashdata('success', 'Successfully Saved');
			redirect(base_url('purchase_order/po_DLCPacking'));
		}

		// $this->load->view('po_DLCPacking', $data);
	}

	function po_dlcp_print($id = false)
	{
		$data['register'] = $this->m_purchase->get_dlc_packing_reg();
		$data['activeTab'] = 'purchase_order';
		$data['activeItem'] = 'po_DLCPacking';
		$data['page_title'] = 'Dyed Loose Cone Packing Entry';

		$box = $this->m_purchase->get_dlc_packing_details($id);
		if (!$box) {
			$this->session->set_flashdata('error', 'Record Not Found');
			redirect(base_url('purchase_order/po_DLCPacking'));
		}
		$data['id'] = $box->id;
		$data['from_dept_id'] = $box->from_dept_id;
		$data['from_dept_name'] = $box->from_dept_name;
		$data['to_dept_id'] = $box->to_dept_id;
		$data['to_dept_name'] = $box->to_dept_name;
		$data['from_user_id'] = $box->from_user_id;
		$data['from_user_name'] = $box->from_user_name;
		$data['to_user_id'] = $box->to_user_id;
		$data['to_user_name'] = $box->to_user_name;
		$data['packed_date'] = $box->packed_date;
		$data['sent_through'] = $box->sent_through;
		$data['vehicle_no'] = $box->vehicle_no;
		$data['packed_by'] = $box->packed_by;
		$data['remarks'] = $box->remarks;

		$data['css_print'] = array(
			'css/invoice-print.css'
		);
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
		$this->load->view('po_dlcp_print', $data);
	}

	function po_DLCPacking_save($lot, $no_spring, $gross, $net, $form_by)
	{
		$data = array(
			'lot_no' => $lot,
			'spring_no' => $no_spring,
			'gross_wt' => $gross,
			'net_wt' => $net,
			'form_by' => $form_by
		);
		$this->ak->insert_new('ak_po_dlcp', $data);
		echo "success";
	}

	function po_DLCDelivery()
	{
		$data['register'] = $this->m_purchase->get_dlc_packing_reg();

		$data['activeTab'] = 'purchase_order';
		$data['activeItem'] = 'po_DLCDelivery';
		$data['page_title'] = 'Dyed Loose Cone Delivery';

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

		$this->load->view('po_DLCDelivery', $data);
	}

	function po_DLCDelivery_save()
	{
		/*echo '<pre>';
		print_r($this->input->post());
		echo '</pre>';*/
		$next = $this->ak->dye_max_delivery();
		$next = ++$next[0]['delivery'];

		$arr = $this->input->post();
		$tot_tr = count($arr['data']);

		for ($i = 0; $i < $tot_tr; $i++) {
			$data = array(
				'delivery' => $next
			);
			$this->ak->update_all('ak_po_dlcp', 'id', $arr['data'][$i], $data);
		}
		echo "success";
	}

	//lbl PO & PS
	function po_from_customers_lbl()
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_lbl_po'");
		$next = $next->row(0);
		$data['next'] = $next->Auto_increment;
		$data['activeTab'] = 'purchase_order';
		$data['activeItem'] = 'po_from_customers_lbl';
		$data['page_title'] = 'Purchase order from Customers';
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['items'] = $this->m_masters->getactivemaster('bud_lbl_items', 'item_status');
		$data['tax'] = $this->m_masters->getactivemaster('bud_tax', 'tax_status');
		$data['uoms'] = $this->m_masters->getactivemaster('bud_uoms', 'uom_status');
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

		$this->load->view('po_from_customers_lbl', $data);
	}

	function po_item_size($item_id)
	{
		$result = $this->m_masters->getmasterIDvalue('bud_lbl_items', 'item_id', $item_id, 'item_sizes');

		$item_sizes = explode(',', $result);
		echo    "<option value=''>Select</option>";
		foreach ($item_sizes as $key => $value) {
			echo    "<option value='" . $value . "'>" . $value . "</option>";
		}
	}

	function ps_stock_qty($itemsize = null, $item_id = null)
	{
		$condition = array(
			'ps_item_id' => $item_id,
			'ps_item_size' => ($itemsize == "ws") ? 'W/S' : $itemsize
		);
		echo $this->m_mir->total_values('bud_lbl_ps_items', 'bud_lbl_ps', 'ps_stock_qty', 'ps_id', 'ps_id', $condition);
	}

	function po_item_rate($item_id = null, $cust_id = null)
	{
		$result = $this->m_admin->getitemrates_label($cust_id, $item_id);
		if ($result) {
			foreach ($result as $row) {
				$rate_array = explode(',', $row['item_rates']);
				$add_rate = 0;
				if ($row['item_rate_form'] != 'roll') {
					$add_rate_array = explode(',', $row[$row['item_rate_form']]);
					$add_rate = $add_rate_array[$row['item_rate_active']];
				}
				$return['rate'] = number_format($rate_array[$row['item_rate_active']] + $add_rate, 2);
			}
		} else {
			$return['rate'] = 0;
		}
		echo json_encode($return);
	}

	function po_from_customers_lbl_save()
	{
		$data = array(
			'cust_id' => $_POST['customer'],
			'c_name' => $_POST['po_person'],
			'c_tel' => $_POST['po_number'],
			'c_po_num' => $_POST['c_po_num'],
			'po_delivery_form' => $_POST['po_delivery_form'],
			'po_date' => $_POST['po_date'],
			'exp_del_date' => $_POST['exp_del_date'],
			'po_remarks' => $_POST['remarks'],
			'po_marketing_staff' => $_POST['staff'],
			'po_entered_by' => $_POST['user'],
			'po_entered_date' => date('Y-m-d H:i:s')
		);
		$rid = $this->ak->insert_new('bud_lbl_po', $data);

		for ($a = 0; $a < count($_POST['item']); $a++) {
			$itms = array(
				'erp_po_no' => $rid,
				'po_item_id' => $_POST['item'][$a],
				'po_item_size' => $_POST['item_size'][$a],
				'po_item_qty' => $_POST['qty'][$a],
				'po_item_uom' => $_POST['uom'][$a],
				'po_item_rate' => $_POST['rate'][$a],
				'po_item_remarks' => $_POST['remarks'][$a]
			);
			$this->ak->insert_new('bud_lbl_po_item', $itms);
		}
		$this->session->set_flashdata('success', 'Successfully Saved!!!');
		redirect(base_url() . 'purchase_order/po_list_lbl', 'refresh');
	}

	function po_list_lbl()
	{
		$data['activeTab'] = 'purchase_order';
		$data['activeItem'] = 'po_list_lbl';
		$data['page_title'] = 'Purchase orders List';
		$data['item_id'] = null;
		$data['item_width'] = null;
		$data['cust_id'] = null;
		if (isset($_POST['search'])) {
			$data['item_id'] = $_POST['item_id'];
			$data['item_width'] = $_POST['item_width'];
			$data['cust_id'] = $_POST['customer'];
		}
		$data['po_list'] = $this->m_purchase->getpolist(null, $data['item_id'], $data['item_width'], $data['cust_id']);
		$data['machines'] = $this->m_masters->getactivemaster('bud_te_machines', 'machine_status');
		$data['items'] = $this->m_masters->getactivemaster('bud_lbl_items', 'item_status');
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

		$this->load->view('po_list_lbl', $data);
	}

	function ps_items_lbl_save()
	{
		if (isset($_POST['save'])) {
			$rows = $_POST['rows'];
			$past_item_id = null;
			$present_item_id = null;
			foreach ($rows as $key => $value) {
				$present_item_id = $this->m_masters->getmasterIDvalue('bud_lbl_po_item', 'row_id', $value, 'po_item_id');
				if ((!empty($past_item_id)) && ($present_item_id != $past_item_id)) {
					$this->m_mycart->truncateTable('bud_lbl_po_item_temp');
					$this->session->set_flashdata('error', 'different items are Not allowed');
					redirect(base_url() . 'purchase_order/po_list_lbl', 'refresh');
				}
				$data = array(
					'row_id' => $value,
					'item_id' => $present_item_id
				);
				$this->ak->insert_new('bud_lbl_po_item_temp', $data);
				$past_item_id = $present_item_id;
			}
		}
		$rows = $this->m_masters->getallmaster("bud_lbl_po_item_temp");
		redirect(base_url() . 'purchase_order/po_list_lbl', 'refresh');
	}

	function remove_cart($row_id = null)
	{
		if ($row_id) {
			echo $this->m_masters->deletemaster('bud_lbl_po_item_temp', 'row_id', $row_id);
		} else {
			echo $this->m_mycart->truncateTable('bud_lbl_po_item_temp');
			redirect(base_url() . 'purchase_order/po_list_lbl', 'refresh');
		}
	}

	function ps_lbl_save()
	{
		$data = array(
			'ps_date' => $_POST['date'],
			'ps_machine_id' => $_POST['machine_id'],
			'ps_remarks' => $_POST['remarks'],
			'ps_entered_by' => $_POST['user'],
			'ps_item_id' => $_POST['item']
		);
		$ps_id = $this->ak->insert_new('bud_lbl_ps', $data);

		for ($a = 0; $a < count($_POST['erp_po_no']); $a++) {
			$itms = array(
				'ps_id' => $ps_id,
				'erp_po_no' => $_POST['erp_po_no'][$a],
				'ps_item_size' => $_POST['item_size'][$a],
				'ps_qty' => $_POST['ps_qty'][$a],
				'ps_stock_qty' => $_POST['ps_stock_qty'][$a],
			);
			$this->ak->insert_new('bud_lbl_ps_items', $itms);
		}
		$this->m_mycart->truncateTable('bud_lbl_po_item_temp');
		$this->session->set_flashdata('success', 'Successfully Saved!!!');
		redirect(base_url() . 'purchase_order/print_ps_lbl/' . $ps_id . '/1', 'refresh');
	}

	function print_ps_lbl()
	{
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
			$this->load->view('v_3_ps_print', $data);
			$data['ps_id'] = null;
			$data['next'] = $this->uri->segment(4);
		} else {
			$data['ps_id'] = $this->uri->segment(3);
			$data['next'] = $this->uri->segment(4);
			$this->load->view('v_3_ps_print', $data);
		}
	}

	function po_lbl_delete()
	{
		$remarks = 'no remarks given by user';
		$result = null;
		$erp_po_id = null;
		$erp_po_id = $this->input->post("erp_po_id");
		$remarks = $this->input->post("remarks");
		if ($erp_po_id) {
			$update_data = array(
				'po_is_deleted' => '0',
				'last_edited_id' => $this->session->userdata('user_id'),
				'last_edited_time' => date('Y-m-d H:i:s'),
				'deleted_remarks' => $remarks
			);
			$result = $this->m_masters->updatemaster('bud_lbl_po', 'erp_po_id', $erp_po_id, $update_data);
			if ($result) {
				$update_data = array(
					'po_is_deleted' => '0'
				);
			}
			$result = $this->m_masters->updatemaster('bud_lbl_po_item', 'erp_po_no', $erp_po_id, $update_data);
		}
		echo ($result) ? $erp_po_id . ' Successfully Deleted' : 'Error in Deletion';
	}

	function ps_lbl_delete()
	{
		$remarks = 'no remarks given by user';
		$result = null;
		$ps_id = null;
		$ps_id = $this->input->post("ps_id");
		$remarks = $this->input->post("remarks");
		if ($ps_id) {
			$update_data = array(
				'ps_is_deleted' => '0',
				'last_edited_id' => $this->session->userdata('user_id'),
				'last_edited_time' => date('Y-m-d H:i:s'),
				'deleted_remarks' => $remarks
			);
			$result = $this->m_masters->updatemaster('bud_lbl_ps', 'ps_id', $ps_id, $update_data);
			if ($result) {
				$update_data = array(
					'ps_is_deleted' => '0'
				);
			}
			$result = $this->m_masters->updatemaster('bud_lbl_ps_items', 'ps_id', $ps_id, $update_data);
		}
		echo ($result) ? $ps_id . ' Successfully Deleted' : 'Error in Deletion';
	}
	//end of lbl PO & PS
}
