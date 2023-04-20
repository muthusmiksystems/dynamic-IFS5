<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class POY extends CI_Controller
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
	function getsuppliers($sup_group_id = null)
	{
		$resultData = '<option value>Select</option>';
		$result = $this->m_masters->getmasterdetails('bud_suppliers', 'sup_group', $sup_group_id, $this->session->userdata('user_viewed'));
		foreach ($result as $row) {
			$sup_id = $row['sup_id'];
			$sup_name = $row['sup_name'];
			$resultData .= '<option value="' . $sup_id . '">' . $sup_name . '</option>';
		}
		echo $resultData;
	}
	function getsupplierDeniers($supplier_id = null)
	{
		$resultData = '<option value>Select</option>';
		$result = $this->m_masters->getmasterdetails('bud_yt_poydeniers', 'supplier_id', $supplier_id, $this->session->userdata('user_viewed'));
		foreach ($result as $row) {
			$denier_id = $row['denier_id'];
			$denier_name = $row['denier_name'];
			$resultData .= '<option value="' . $denier_id . '">' . $denier_name . '</option>';
		}
		echo $resultData;
	}
	function getpoylots($poy_denier = null)
	{
		$resultData = '<option value>Select</option>';
		$result = $this->m_masters->getmasterdetails('bud_poy_lots', 'poy_denier', $poy_denier, $this->session->userdata('user_viewed'));
		foreach ($result as $row) {
			$poy_lot_id = $row['poy_lot_id'];
			$poy_lot_no = $row['poy_lot_no'];
			$resultData .= '<option value="' . $poy_lot_id . '">' . $poy_lot_no . '</option>';
		}
		echo $resultData;
	}
	function poydenier()
	{
		$data['activeTab'] = 'poy';
		$data['activeItem'] = 'poydenier';
		$data['page_title'] = 'Raw Material & POY Denier Master';
		$data['supplier_groups'] = $this->m_masters->getactivemaster('bud_yt_supplier_groups', 'status');
		$data['poydeniers'] = $this->m_masters->getpoyDeniers($this->session->userdata('user_viewed'));
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
			$this->load->view('v_1_poy-denier.php', $data);
		} else {
			$data['denier_id'] = $this->uri->segment(3);
			$this->load->view('v_1_poy-denier.php', $data);
		}
	}
	function poydenier_save()
	{
		$sup_group_id = $this->input->post('sup_group_id');
		$supplier_id = $this->input->post('supplier_id');
		$denier_id = $this->input->post('denier_id');
		$denier_name = $this->input->post('denier_name') . ' / ' . substr($this->input->post('denier_postfix'), 0, 5);
		$denier_tech = $this->input->post('denier_tech');
		$denier_status = ($this->input->post('denier_status') == 1) ? 1 : 0;
		$formData = array(
			'sup_group_id' => $sup_group_id,
			'supplier_id' => $supplier_id,
			'denier_name' => $denier_name,
			'denier_tech' => $denier_tech,
			'denier_status' => $denier_status,
			'module' => $this->session->userdata('user_viewed')
		);
		if ($denier_id == '') {
			$result = $this->m_masters->savemaster('bud_yt_poydeniers', $formData);
		} else {
			$result = $this->m_masters->updatemaster('bud_yt_poydeniers', 'denier_id', $denier_id, $formData);
		}
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "poy/poydenier", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "poy/poydenier", 'refresh');
		}
	}
	function poy_lots()
	{
		$data['activeTab'] = 'poy';
		$data['activeItem'] = 'poy_lots';
		$data['page_title'] = 'POY Lot Master';
		$data['supplier_groups'] = $this->m_masters->getactivemaster('bud_yt_supplier_groups', 'status');
		$data['poy_lots'] = $this->m_masters->getallmaster('bud_poy_lots');
		$data['uoms'] = $this->m_masters->getactivemaster('bud_uoms', 'uom_status');
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
			$this->load->view('v_1_poy_lots.php', $data);
		} else {
			$data['poy_lot_id'] = $this->uri->segment(3);
			$this->load->view('v_1_poy_lots.php', $data);
		}
	}
	function poy_lots_save()
	{
		$sup_group_id = $this->input->post('sup_group_id');
		$supplier_id = $this->input->post('supplier_id');
		$poy_denier = $this->input->post('poy_denier');
		$poy_lot_id = $this->input->post('poy_lot_id');
		$poy_lot_name = $this->input->post('poy_lot_name');
		$poy_lot_no = $this->input->post('poy_lot_no');
		$poy_reorder = $this->input->post('poy_reorder');
		$poy_lot_uom = $this->input->post('poy_lot_uom');
		$poy_status = ($this->input->post('poy_status') == 1) ? 1 : 0;
		$formData = array(
			'sup_group_id' => $sup_group_id,
			'supplier_id' => $supplier_id,
			'poy_denier' => $poy_denier,
			'poy_lot_name' => $poy_lot_name,
			'poy_lot_no' => $poy_lot_no,
			'poy_reorder' => $poy_reorder,
			'poy_lot_uom' => $poy_lot_uom,
			'poy_status' => $poy_status,
			'module' => $this->session->userdata('user_viewed')
		);
		if ($poy_lot_id == '') {
			$result = $this->m_masters->savemaster('bud_poy_lots', $formData);
		} else {
			$result = $this->m_masters->updatemaster('bud_poy_lots', 'poy_lot_id', $poy_lot_id, $formData);
		}
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "poy/poy_lots", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "poy/poy_lots", 'refresh');
		}
	}

	function yarndenier()
	{ //ak
		$data['activeTab'] = 'poy';
		$data['activeItem'] = 'yarndenier';
		$data['page_title'] = 'Yarn Quality Master';
		$data['yarndeniers'] = $this->m_masters->getallmaster('bud_yt_yarndeniers');
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
			$this->load->view('v_1_yarn-denier.php', $data);
		} else {
			$data['denier_id'] = $this->uri->segment(3);
			$this->load->view('v_1_yarn-denier.php', $data);
		}
	}
	function yarndenier_save()
	{ //ak
		/*$sup_group_id = $this->input->post('sup_group_id');
		$supplier_id = $this->input->post('supplier_id');*/
		$denier_id = $this->input->post('denier_id');
		$denier_name = $this->input->post('denier_name');
		$denier_tech = $this->input->post('denier_tech');
		$denier_status = ($this->input->post('denier_status') == 1) ? 1 : 0;
		$formData = array(
			/*			'sup_group_id' => $sup_group_id, 
			'supplier_id' => $supplier_id, */
			'denier_name' => $denier_name,
			'denier_tech' => $denier_tech,
			'denier_status' => $denier_status
		);
		if ($denier_id == '') {
			$result = $this->m_masters->savemaster('bud_yt_yarndeniers', $formData);
		} else {
			$result = $this->m_masters->updatemaster('bud_yt_yarndeniers', 'denier_id', $denier_id, $formData);
		}
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "poy/yarndenier", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "poy/yarndenier", 'refresh');
		}
	}
	function yarn_lots()
	{
		//ak
		$data['activeTab'] = 'poy';
		$data['activeItem'] = 'yarn_lots';
		$data['page_title'] = 'YARN Lot Master';
		$data['poy_denier_id'] = '';

		$data['poy_deniers'] = $this->m_poy->get_poy_deniers();
		$data['poy_inwards'] = $this->m_poy->get_poy_inward();
		$data['yarn_lots'] = $this->m_poy->get_yarn_lots('bud_yarn_lots');
		$data['uoms'] = $this->m_masters->getactivemaster('bud_uoms', 'uom_status');
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
			$this->load->view('v_1_yarn_lots.php', $data);
		} else {
			$data['yarn_lot_id'] = $this->uri->segment(3);
			$this->load->view('v_1_yarn_lots.php', $data);
		}
	}

	function print_yarn_lots()
	{
		$data['js'] = array(
			'barcode/jquery-1.3.2.min.js',
			'barcode/jquery-barcode.js'
		);
		if ($this->uri->segment(3) === FALSE) {
			redirect(base_url() . "poy/yarn_lots", 'refresh');
		} else {
			$data['poy_deniers'] = $this->m_poy->get_poy_deniers();
			$data['yarn_deniers'] = $this->m_masters->getmasterdetails('bud_yt_yarndeniers', 'denier_status', '1');
			$data['yarn_lot_id'] = $this->uri->segment(3);
			$this->load->view('v_1_print_yarn_lots.php', $data);
		}
	}

	function yarn_lots_save()
	{
		//ak 
		$poy_denier = $this->input->post('yarn_denier');
		$poy_lot_id = $this->input->post('yarn_lot_id');
		$poy_lot_name = $this->input->post('yarn_lot_name');
		$poy_lot_no = $this->input->post('yarn_lot_no');
		$poy_reorder = $this->input->post('yarn_reorder');
		$poy_lot_uom = $this->input->post('yarn_lot_uom');
		$poy_denier_id = $this->input->post('poy_denier_id');
		$poy_status = ($this->input->post('yarn_status') == 1) ? 1 : 0;

		$yarn_lot_machinespeed = $this->input->post('yarn_lot_machinespeed');
		$yarn_lot_dy = $this->input->post('yarn_lot_dy');
		$yarn_lot_draw = $this->input->post('yarn_lot_draw');
		$yarn_lot_sos = $this->input->post('yarn_lot_sos');
		$yarn_lot_takeuphardwind = $this->input->post('yarn_lot_takeuphardwind');
		$yarn_lot_takeupsoftwind = $this->input->post('yarn_lot_takeupsoftwind');
		$yarn_lot_primarytemp = $this->input->post('yarn_lot_primarytemp');
		$yarn_lot_secondarytemp = $this->input->post('yarn_lot_secondarytemp');
		$yarn_lot_cpmhardwind = $this->input->post('yarn_lot_cpmhardwind');
		$yarn_lot_cpmsoftwind = $this->input->post('yarn_lot_cpmsoftwind');
		$yarn_lot_rottopresher = $this->input->post('yarn_lot_rottopresher');
		$yarn_lot_remarks = $this->input->post('yarn_lot_remarks');
		$yarn_lot_poyinwardno = $this->input->post('yarn_lot_poyinwardno');

		@$this->load->library('session');
		@$my_session_id = $_GET['session_id'];
		@$this->session->userdata('session_id', $my_session_id);
		$user_id = $this->session->userdata['user_id'];

		$formData = array(
			'yarn_denier' => $poy_denier,
			'yarn_lot_name' => $poy_lot_name,
			'yarn_lot_no' => $poy_lot_no,
			'yarn_reorder' => 0,
			'yarn_lot_uom' => $poy_lot_uom,
			'yarn_status' => $poy_status,
			'poy_denier_id' => $poy_denier_id,
			'yarn_lot_machinespeed' => $yarn_lot_machinespeed,
			'yarn_lot_dy' => $yarn_lot_dy,
			'yarn_lot_draw' => $yarn_lot_draw,
			'yarn_lot_sos' => $yarn_lot_sos,
			'yarn_lot_takeuphardwind' => $yarn_lot_takeuphardwind,
			'yarn_lot_takeupsoftwind' => $yarn_lot_takeupsoftwind,
			'yarn_lot_primarytemp' => $yarn_lot_primarytemp,
			'yarn_lot_secondarytemp' => $yarn_lot_secondarytemp,
			'yarn_lot_cpmhardwind' => $yarn_lot_cpmhardwind,
			'yarn_lot_cpmsoftwind' => $yarn_lot_cpmsoftwind,
			'yarn_lot_rottopresher' => $yarn_lot_rottopresher,
			'yarn_lot_remarks' => $yarn_lot_remarks,
			'yarn_lot_poyinwardno' => $yarn_lot_poyinwardno,
			'user_id' => $user_id,
			'date' => date('Y-m-d H:i:s')
		);

		if (!empty($this->input->post('save'))) {
			$result = $this->m_masters->savemaster('bud_yarn_lots', $formData);
		} else if (!empty($this->input->post('save_continue'))) {
			$result = $this->m_masters->savemaster('bud_yarn_lots', $formData);
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url('poy/yarn_lots/' . $result), 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "poy/yarn_lots", 'refresh');
			}
		} else if (!empty($this->input->post('update'))) {
			$result = $this->m_masters->updatemaster('bud_yarn_lots', 'yarn_lot_id', $poy_lot_id, $formData);
		}

		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "poy/yarn_lots", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "poy/yarn_lots", 'refresh');
		}
	}

	function poy_inward()
	{
		//$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_yt_poy_inward'");
		$next = $this->db->query("SELECT po_no FROM bud_yt_poy_inward WHERE module = ".$this->session->userdata('user_viewed'));
		$next = $next->num_rows();
		//echo '<pre>'; print_r($next); die;
		$data['inward_no'] = $next+1;
		$data['activeTab'] = 'poy';
		$data['activeItem'] = 'poy_inward';
		$data['page_title'] = 'POY Inward Entry';
		$data['supplier_groups'] = $this->m_masters->getactivemaster('bud_yt_supplier_groups', 'status');
		$data['departments'] = $this->m_masters->getactivemaster('bud_yt_departments', 'status', $this->session->userdata('user_viewed'));
		$data['poy_lots'] = $this->m_masters->getallmaster('bud_poy_lots', $this->session->userdata('user_viewed'));
		$data['uoms'] = $this->m_masters->getactivemaster('bud_uoms', 'uom_status');
		$data['items'] = $this->m_masters->getactivemaster('bud_items', 'item_status');

		$data['poy_inward'] = $this->m_poy->getPoyInward();

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
			$this->load->view('v_1_poy-inward.php', $data);
		} else {
			$data['poy_lot_id'] = $this->uri->segment(3);
			$this->load->view('v_1_poy-inward.php', $data);
		}
	}
	function poyInw_addtocart()
	{
		// print_r($_POST);
		$item_id = $_POST['item_id'];
		$supplier_id = $_POST['supplier_id'];
		$poy_denier = $_POST['poy_denier'];
		$poy_lot = $_POST['poy_lot'];
		$po_qty = $_POST['po_qty'];
		$po_item_rate = $_POST['po_item_rate'];
		$item_uom = $_POST['item_uom'];
		$formData = array(
			'user_id' => $this->session->userdata('user_id'),
			'item_id' => $item_id,
			'supplier_id' => $supplier_id,
			'poy_denier' => $poy_denier,
			'poy_lot' => $poy_lot,
			'po_qty' => $po_qty,
			'item_uom' => $item_uom,
			'po_item_rate' => $po_item_rate,
			'module' => $this->session->userdata('user_viewed')
		);
		$this->m_mycart->insertPoInwCartYt($formData);
	}
	function poyInw_removetocart($rowid = null)
	{
		$this->m_mycart->deletePoInwCartItemYt($rowid);
	}
	function poyInw_cartItems()
	{
		$this->load->view('v_1_poy-inw-cartitems');
	}
	function poy_inward_save()
	{

		$item_id = $this->input->post('item_id');
		$supplier_id = $this->input->post('supplier_id');
		$poy_denier = $this->input->post('poy_denier');
		$poy_lot = $this->input->post('poy_lot');
		$po_qty = $this->input->post('po_qty');
		$po_item_rate = $this->input->post('po_item_rate');
		$item_uom = $this->input->post('item_uom');
		
		/*echo "<pre>";
		print_r($formData);
		echo "</pre>";die;*/
		$sup_group_id = $this->input->post('sup_group_id');
		$department = $this->input->post('department');
		$inward_no = $this->input->post('inward_no');
		$formData = array(
			'inward_no' => $inward_no,
			'sup_group_id' => $sup_group_id,
			'department' => $department,
			'po_date' => date("Y-m-d"),
			'poy_inward_prefix' => date("m-y"), //tot pkd qty correction
			'po_time' => date("H:i:s"),
			'module' => $this->session->userdata('user_viewed')
		);
		$result = $this->m_masters->m_purchase('bud_yt_poy_inward', $formData);
		if ($result) {
			$itemsData = array(
				'po_no' => $result,
				'user_id' => $this->session->userdata('user_id'),
				'item_id' => $item_id,
				'supplier_id' => $supplier_id,
				'poy_denier' => $poy_denier,
				'poy_lot' => $poy_lot,
				'po_qty' => $po_qty,
				'po_item_rate' => $po_item_rate,
				'item_uom' => $item_uom,
				'inward_date' => date("Y-m-d"),
				'module' => $this->session->userdata('user_viewed')
			);
			$this->m_masters->savemaster('bud_yt_poyinw_items', $itemsData);

			/*
			$po_items = $this->m_masters->getmasterdetails('bud_yt_poyinw_cart_temp', 'user_id', $this->session->userdata('user_id'));
			foreach ($po_items as $row) {
				$itemsData = array(
					'po_no' => $result,
					'user_id' => $row['user_id'],
					'item_id' => $row['item_id'],
					'supplier_id' => $row['supplier_id'],
					'poy_denier' => $row['poy_denier'],
					'poy_lot' => $row['poy_lot'],
					'po_qty' => $row['po_qty'],
					'po_item_rate' => $row['po_item_rate'], //inclusion of item rate in poy inward
					'item_uom' => $row['item_uom'],
					'inward_date' => date("Y-m-d")
				);
				$this->m_masters->savemaster('bud_yt_poyinw_items', $itemsData);
			}
			$this->m_mycart->deletePoInwCartYt($this->session->userdata('user_id'));
			*/

			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "poy/poy_inward", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "poy/poy_inward", 'refresh');
		}
	}

	function poy_inwd_detail($po_no)
	{
		$data['inward_items'] = $this->ak->poy_inwd_detail($po_no);
		$data['po_no'] = $po_no;
		$this->load->view('includes/poy_inwd_items', $data);
	}

	public function poy_inwd_addqty($rowid = '')
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['page_title'] = 'Update Qty';
		$data['inward_date'] = date("d-m-Y");
		$data['qty'] = '';
		$data['item'] = $this->ak->poy_inwd_item($rowid);
		$this->load->view('poy-inward-update-qty', $data);
	}
	public function inwd_addqty_save()
	{
		/*echo "<pre>";
		print_r($_POST);
		echo "</pre>";*/
		$response = array();
		$this->load->library('form_validation');
		if ($this->input->post('rowid')) {
			$this->form_validation->set_rules('qty', 'Qty', 'required|numeric');
			if ($this->form_validation->run() == FALSE) {
				$response['error'] = validation_errors();
			} else {
				$rowid = $this->input->post('rowid');
				$item = $this->ak->poy_inwd_item($rowid);
				$save['rowid'] = 0;
				$save['po_no'] = $item->po_no;
				$save['user_id'] = $item->user_id;
				$save['item_id'] = $item->item_id;
				$save['supplier_id'] = $item->supplier_id;
				$save['poy_denier'] = $item->poy_denier;
				$save['poy_lot'] = $item->poy_lot;
				$save['edate'] = date("Y-m-d H:i:s");
				$save['euser'] = $this->session->userdata('display_name');
				$save['poy_lot_no_current'] = $this->input->post('poy_lot_no_current');
				$save['inward_invoice_no'] = $this->input->post('inward_invoice_no');
				$save['inward_quality'] = $this->input->post('inward_quality');
				$save['po_qty'] = $this->input->post('qty');
				$save['po_item_rate'] = $this->input->post('po_item_rate'); //inclusion of item rate in poy inward
				$save['inward_date'] = date("Y-m-d", strtotime($this->input->post('inward_date')));
				$save['remarks'] = $this->input->post('remarks');
				$save['item_uom'] = $item->item_uom;
				$this->ak->save_inward_item($save);
				$response['success'] = "Successfully Saved";
			}
		} else {
			$response['error'] = 'Record not found';
		}

		echo json_encode($response);
	}
	function po_issue()
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_yt_po_issue'");
		$next = $next->row(0);
		$data['issue_no'] = $next->Auto_increment;
		$data['activeTab'] = 'poy';
		$data['activeItem'] = 'po_issue';
		$data['page_title'] = 'POY PO Issue';
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['supplier_groups'] = $this->m_masters->getactivemaster('bud_yt_supplier_groups', 'status');
		$data['departments'] = $this->m_masters->getactivemaster('bud_yt_departments', 'status');
		$data['poy_lots'] = $this->m_masters->getallmaster('bud_poy_lots');
		$data['uoms'] = $this->m_masters->getactivemaster('bud_uoms', 'uom_status');
		$data['items'] = $this->m_masters->getactivemaster('bud_items', 'item_status');
		$data['shades'] = $this->m_masters->getactivemaster('bud_shades', 'shade_status');
		$data['suppliers'] = $this->m_masters->getallmaster('bud_suppliers');
		$data['po_issue'] = $this->m_poy->getPoyPoIssue();

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
			$this->load->view('v_1_po-issue.php', $data);
		} else {
			$data['poy_lot_id'] = $this->uri->segment(3);
			$this->load->view('v_1_po-issue.php', $data);
		}
	}
	function po_addtocart()
	{
		// print_r($_POST);
		$item_id = $_POST['item_id'];
		$shade_id = $_POST['shade_id'];
		$po_qty = $_POST['po_qty'];
		$item_uom = $_POST['item_uom'];
		$formData = array(
			'user_id' => $this->session->userdata('user_id'),
			'item_id' => $item_id,
			'shade_id' => $shade_id,
			'po_qty' => $po_qty,
			'item_uom' => $item_uom
		);
		$this->m_mycart->insertPoCartYt($formData);
	}
	function poy_removetocart($rowid = null)
	{
		$this->m_mycart->deletePoCartItemYt($rowid);
	}
	function po_cartItems()
	{
		$this->load->view('v_1_po-cartitems');
	}
	function po_removetocart($id = null)
	{
		$this->m_mycart->deletePoCartItemYt($id);
	}
	function po_issue_save()
	{
		/*echo "<pre>";
		print_r($_POST);
		echo "</pre>";*/
		$customer_id = $this->input->post('customer_id');
		$delivery_date = $this->input->post('delivery_date');
		$dd = explode("-", $delivery_date);
		$delivery_date = $dd[2] . '-' . $dd[1] . '-' . $dd[0];
		$formData = array(
			'customer_id' => $customer_id,
			'delivery_date' => $delivery_date,
			'po_date' => date("Y-m-d"),
			'po_time' => date("H:i:s")
		);
		$result = $this->m_purchase->saveDatas('bud_yt_po_issue', $formData);
		if ($result) {
			$po_items = $this->m_masters->getmasterdetails('bud_yt_po_cart_temp', 'user_id', $this->session->userdata('user_id'));
			foreach ($po_items as $row) {
				$itemsData = array(
					'po_no' => $result,
					'user_id' => $row['user_id'],
					'item_id' => $row['item_id'],
					'shade_id' => $row['shade_id'],
					'po_qty' => $row['po_qty'],
					'item_uom' => $row['item_uom']
				);
				$this->m_masters->savemaster('bud_yt_po_items', $itemsData);
			}
			$this->m_mycart->deletePoCartYt($this->session->userdata('user_id'));

			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "poy/po_issue", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "poy/po_issue", 'refresh');
		}
	}
	function poy_issue()
	{
		// $data['issue_no'] = $this->m_poy->getNextPOYIssueNo();
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_yt_poy_issue'");
		$next = $next->row(0);
		$data['issue_no'] = $next->Auto_increment;
		$data['activeTab'] = 'poy';
		$data['activeItem'] = 'poy_issue';
		$data['page_title'] = 'POY Issue From Store';
		$data['supplier_groups'] = $this->m_masters->getactivemaster('bud_yt_supplier_groups', 'status');
		$data['departments'] = $this->m_masters->getactivemaster('bud_yt_departments', 'status');
		$data['poy_lots'] = $this->m_masters->getallmaster('bud_poy_lots');
		$data['uoms'] = $this->m_masters->getactivemaster('bud_uoms', 'uom_status');
		$data['items'] = $this->m_masters->getactivemaster('bud_items', 'item_status');
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
			$this->load->view('v_1_poy-issue.php', $data);
		} else {
			$data['poy_lot_id'] = $this->uri->segment(3);
			$this->load->view('v_1_poy-issue.php', $data);
		}
	}
	function poy_issue_save()
	{
		/*echo "<pre>";
		print_r($_POST);
		echo "</pre>";*/
		$issue_no = $this->m_poy->getNextPOYIssueNo();
		$sup_group_id = $this->input->post('sup_group_id');
		$department = $this->input->post('department');
		$item_name = $this->input->post('item_name');
		$item_id = $this->input->post('item_id');
		$supplier_id = $this->input->post('supplier_id');
		$poy_denier = $this->input->post('poy_denier');
		$poy_lot = $this->input->post('poy_lot');
		$po_qty = $this->input->post('po_qty');
		$item_uom = $this->input->post('item_uom');
		$formData = array(
			'issue_no' => $issue_no,
			'department' => $department,
			'item_id' => $item_id,
			'sup_group_id' => $sup_group_id,
			'supplier_id' => $supplier_id,
			'poy_denier' => $poy_denier,
			'poy_lot' => $poy_lot,
			'qty' => $po_qty,
			'uom' => $item_uom,
			'issue_datetime' => date("Y-m-d H:i:s")
		);
		$result = $this->m_purchase->saveDatas('bud_yt_poy_issue', $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "poy/poy_issue", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "poy/poy_issue", 'refresh');
		}
	}
	function wpoy_delivery()
	{ //ak
		// $data['issue_no'] = $this->m_poy->getNextPOYIssueNo();
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_yt_wpoy_delivery'");
		$next = $next->row(0);
		//$data['issue_no'] = $next->Auto_increment;
		$data['activeTab'] = 'poy';
		$data['activeItem'] = 'poy_delivery';
		$data['page_title'] = 'POY delivery From SGS';
		$data['supplier_groups'] = $this->m_masters->getactivemaster('bud_yt_supplier_groups', 'status');
		$data['departments'] = $this->m_masters->getactivemaster('bud_yt_departments', 'status');
		$data['poy_lots'] = $this->m_masters->getallmaster('bud_poy_lots');
		$data['uoms'] = $this->m_masters->getactivemaster('bud_uoms', 'uom_status');
		$data['items'] = $this->m_masters->getactivemaster('bud_items', 'item_status');
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
			$this->load->view('v_1_wpoy-delivery.php', $data);
		} else {
			$data['poy_lot_id'] = $this->uri->segment(3);
			$this->load->view('v_1_wpoy-delivery.php', $data);
		}
	}
	function wpoy_dele($id, $weight)
	{
		$this->ak->update_wpoy($id, $weight);
	}

	function wpoy_acceptance()
	{
		$data['activeTab'] = 'poy';
		$data['activeItem'] = 'wpoy_acceptance';
		$data['page_title'] = 'Wastage POY Issue Accpetance';
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
		$this->load->view("v_1_poy_waste_accept", $data);
	}
	public function confirm_wpoy_accept($id = '')
	{
		$data['id'] = $id;
		$this->load->view('includes/confirm-wpoy-accept', $data);
	}
	function wpoy_accept($id)
	{
		$response = array();
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('id', 'Delivery Id', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		if ($this->form_validation->run() == FALSE) {
			$response['error'] = validation_errors();
		} else {
			$username = $this->session->userdata('user_login');
			$password = $this->input->post('password');
			$login = $this->m_users->check_login($username, $password);
			if ($login) {
				$this->ak->update_wpoy_accept($id);
				$response['success'] = 'Successfully saved';
			} else {
				$response['error'] = 'Wrong password';
			}
		}
		echo json_encode($response);

		// $this->ak->update_wpoy_accept($id);
	}
	function pyarn_acceptance()
	{
		$data['activeTab'] = 'poy';
		$data['activeItem'] = 'pyarn_acceptance';
		$data['page_title'] = 'Polyster YARN Acceptance';
		$data['supplier_groups'] = $this->m_masters->getactivemaster('bud_yt_supplier_groups', 'status');
		$data['poy_deniers'] = $this->m_masters->getactivemaster('bud_yt_poydeniers', 'denier_status');
		//To Inactive Denier Master
		//$data['yarn_deniers'] = $this->m_masters->getactivemaster('bud_deniermaster', 'denier_status');
		$data['departments'] = $this->m_masters->getactivemaster('bud_yt_departments', 'status');
		$data['poy_lots'] = $this->m_masters->getallmaster('bud_poy_lots');
		$data['uoms'] = $this->m_masters->getactivemaster('bud_uoms', 'uom_status');
		$data['items'] = $this->m_masters->getactivemaster('bud_items', 'item_status');
		$data['poy_issue'] = $this->m_poy->getPoyIssueList();
		$data['yarn_delivery'] = $this->m_poy->getYarnDelivery();
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
		$data['js_common'] = array('js/common-scripts.js');
		$data['js_thispage'] = array('js/form-validation-script.js', 'js/form-component.js', 'js/dynamic-table.js');
		$this->load->view("v_1_yarn_accept", $data);
	}
	function pyarn_accept_update()
	{
		$id = $this->input->post('id');
		$password = $this->input->post('password');
		$if_password_match = $this->m_poy->check_password($this->session->userdata('user_id'), $password);
		if ($if_password_match) {
			$formData = array(
				'accepted_date_time' => date("Y-m-d H:i:s"),
				'is_accepted' => 1
			);
			$this->m_masters->updatemaster('bud_yt_yarndelivery', 'delivery_id', $id, $formData);
			$this->session->set_flashdata('success', 'Successfully Updated!!!');
			redirect(base_url() . "poy/pyarn_acceptance", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'Please Enter Correct Password');
			redirect(base_url() . "poy/pyarn_acceptance", 'refresh');
		}
	}

	function yarn_delivery()
	{
		// $data['issue_no'] = $this->m_poy->getNextPOYIssueNo();
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_yt_yarndelivery'");
		$next = $next->row(0);
		$data['delivery_no'] = $next->Auto_increment;
		$data['activeTab'] = 'poy';
		$data['activeItem'] = 'yarn_delivery';
		$data['page_title'] = 'Inter Department Transfer';
		$data['supplier_groups'] = $this->m_masters->getactivemaster('bud_yt_supplier_groups', 'status');
		$data['poy_deniers'] = $this->m_masters->getactivemaster('bud_yt_poydeniers', 'denier_status');
		$data['yarn_deniers'] = $this->m_masters->getactivemaster('bud_yt_yarndeniers', 'denier_status');
		$data['departments'] = $this->m_masters->getactivemaster('bud_yt_departments', 'status');
		$data['poy_lots'] = $this->m_masters->getallmaster('bud_poy_lots');
		$data['uoms'] = $this->m_masters->getactivemaster('bud_uoms', 'uom_status');
		$data['items'] = $this->m_masters->getactivemaster('bud_items', 'item_status');
		$data['poy_issue'] = $this->m_poy->getPoyIssueList();
		$data['yarn_delivery'] = $this->m_poy->getYarnDelivery();
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
			$this->load->view('v_1_yarn-delivery.php', $data);
		} else {
			$data['poy_lot_id'] = $this->uri->segment(3);
			$this->load->view('v_1_yarn-delivery.php', $data);
		}
	}
	function yarn_del_addtocart()
	{
		$item_id = $_POST['item_id'];
		$poy_denier = $_POST['poy_denier'];
		$yarn_denier = $_POST['yarn_denier'];
		$po_qty = $_POST['po_qty'];
		$item_uom = $_POST['item_uom'];
		$cartData = array(
			'user_id' => $this->session->userdata('user_id'),
			'item_id' => $item_id,
			'poy_denier' => $poy_denier,
			'yarn_denier' => $yarn_denier,
			'qty' => $po_qty,
			'uom' => $item_uom
		);
		$this->m_purchase->saveDatas('bud_yt_yarn_del_items_temp', $cartData);
	}
	function yarn_del_removetocart($id = null)
	{
		$this->m_masters->deletemaster('bud_yt_yarn_del_items_temp', 'id', $id);
	}
	function yarn_del_cartitems()
	{
		$this->load->view('v_1_yarn-delivery-cartitems');
	}
	function yarn_delivery_save()
	{
		/*echo "<pre>";
		print_r($_POST);
		echo "</pre>";*/
		$delivery_from = $this->input->post('delivery_from');
		$delivery_to = $this->input->post('delivery_to');
		$formData = array(
			'delivery_from' => $delivery_from,
			'delivery_to' => $delivery_to,
			'delivery_date_time' => date("Y-m-d H:i:s")
		);
		$result = $this->m_purchase->saveDatas('bud_yt_yarndelivery', $formData);
		if ($result) {
			$po_items = $this->m_masters->getmasterdetails('bud_yt_yarn_del_items_temp', 'user_id', $this->session->userdata('user_id'));
			foreach ($po_items as $row) {
				$itemsData = array(
					'yarn_delivery_id' => $result,
					'item_id' => $row['item_id'],
					'poy_denier' => $row['poy_denier'],
					'yarn_denier' => $row['yarn_denier'],
					'qty' => $row['qty'],
					'uom' => $row['uom']
				);
				$this->m_masters->savemaster('bud_yt_yarn_delivery_items', $itemsData);
			}
			$this->m_masters->deletemaster('bud_yt_yarn_del_items_temp', 'user_id', $this->session->userdata('user_id'));

			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "poy/yarn_delivery", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "poy/yarn_delivery", 'refresh');
		}
	}

	function yarn_detail($id)
	{ //ak
		$result = $this->ak->yarn_detail($id);
		//var_dump($result);
		$Sno = 1;
		foreach ($result as $row) {
			echo "
		            <tr>
	                    <th>" . $Sno . "</th>
	                    <th>" . $id . "</th>
	                    <th>" . $row['item_name'] . "</th>
	                    <th>" . $row['item_code'] . "</th>
	                    <th>" . $row['poy'] . "</th>
						<th>" . $row['yarn'] . "</th>
	                    <th>" . $row['qty'] . "</th>
	                </tr>
			";
			++$Sno;
		}
	}
	function sales_entry()
	{	//ak
		// $data['issue_no'] = $this->m_poy->getNextPOYIssueNo();
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_yt_salesentry'");
		$next = $next->row(0);
		$data['invoice_no'] = $next->Auto_increment;
		$data['activeTab'] = 'poy';
		$data['activeItem'] = 'sales_entry';
		$data['page_title'] = 'POY Sales Entry';
		$data['supplier_groups'] = $this->m_masters->getactivemaster('bud_yt_supplier_groups', 'status');
		$data['poy_deniers'] = $this->m_masters->getactivemaster('bud_yt_poydeniers', 'denier_status');
		//To Inactive Denier Master
		//$data['yarn_deniers'] = $this->m_masters->getactivemaster('bud_deniermaster', 'denier_status');
		$data['departments'] = $this->m_masters->getactivemaster('bud_yt_departments', 'status');
		$data['poy_lots'] = $this->m_masters->getallmaster('bud_poy_lots');
		$data['uoms'] = $this->m_masters->getactivemaster('bud_uoms', 'uom_status');
		$data['items'] = $this->m_masters->getactivemaster('bud_items', 'item_status');
		$data['sales_entry'] = $this->ak->get_sales_entry();
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
			$this->load->view('v_1_sales-entry', $data);
		} else {
			$data['poy_lot_id'] = $this->uri->segment(3);
			$this->load->view('v_1_sales-entry', $data);
		}
	}
	function poy_sales_addtocart()
	{
		$item_id = $_POST['item_id'];
		$poy_denier = $_POST['poy_denier'];
		$poy_lot = $_POST['poy_lot'];
		$po_qty = $_POST['po_qty'];
		$item_uom = $_POST['item_uom'];
		$cartData = array(
			'user_id' => $this->session->userdata('user_id'),
			'item_id' => $item_id,
			'poy_denier' => $poy_denier,
			'poy_lot' => $poy_lot,
			'qty' => $po_qty,
			'uom' => $item_uom
		);
		$this->m_purchase->saveDatas('bud_yt_poy_sales_items_temp', $cartData);
	}
	function poy_sales_removetocart($id = null)
	{
		$this->m_masters->deletemaster('bud_yt_poy_sales_items_temp', 'id', $id);
	}
	function poy_sales_cartitems()
	{
		$this->load->view('v_1_poy-sales-cartitems');
	}
	function sales_entry_save()
	{
		/*echo "<pre>";
		print_r($_POST);
		echo "</pre>";*/
		$sales_to = $this->input->post('sales_to');
		$formData = array(
			'sales_to' => $sales_to,
			'sales_date' => date("Y-m-d"),
			'sales_time' => date("H:i:s")
		);
		$result = $this->m_purchase->saveDatas('bud_yt_salesentry', $formData);
		if ($result) {
			$po_items = $this->m_masters->getmasterdetails('bud_yt_poy_sales_items_temp', 'user_id', $this->session->userdata('user_id'));
			foreach ($po_items as $row) {
				$itemsData = array(
					'sales_id' => $result,
					'item_id' => $row['item_id'],
					'poy_denier' => $row['poy_denier'],
					'poy_lot' => $row['poy_lot'],
					'qty' => $row['qty'],
					'uom' => $row['uom']
				);
				$this->m_masters->savemaster('bud_yt_poy_sales_items', $itemsData);
			}
			$this->m_masters->deletemaster('bud_yt_poy_sales_items_temp', 'user_id', $this->session->userdata('user_id'));

			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "poy/sales_entry", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "poy/sales_entry", 'refresh');
		}
	}
}
