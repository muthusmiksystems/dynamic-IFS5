<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Registers extends CI_Controller
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
		$this->load->model('m_registers');
		$this->load->model('m_updates');
		$this->load->library('cart');

		if (!$this->session->userdata('logged_in')) {
			// Allow some methods?
			$allowed = array();
			if (!in_array($this->router->method, $allowed)) {
				redirect(base_url() . 'users/login', 'refresh');
			}
		}
	}
	function item_rate_reg_yt()
	{
		$data['activeTab'] = 'registers';
		$data['activeItem'] = 'item_rate_reg_yt';
		$data['page_title'] = 'Item Rate Register';
		$data['from_date'] = date("d-m-Y");
		$data['to_date'] = date("d-m-Y");
		$data['customer_id'] = '';
		$data['rate_changed_by'] = '';
		$data['item_id'] = '';
		$data['shade_id'] = '';

		$search['from_date'] = false;
		$search['to_date'] = false;
		$search['customer_id'] = '';
		$search['rate_changed_by'] = '';
		$search['item_id'] = '';
		$search['shade_id'] = '';

		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['items'] = $this->m_masters->getactivemaster('bud_items', 'item_status');
		$data['shades'] = $this->m_masters->getactivemaster('bud_shades', 'shade_status');
		$data['users'] = $this->m_masters->getactivemaster('bud_users', 'user_status');
		if ($this->input->post('search')) {
			$data['from_date'] = $this->input->post('from_date');
			$data['to_date'] = $this->input->post('to_date');
			$data['customer_id'] = $this->input->post('customer_id');
			$data['rate_changed_by'] = $this->input->post('rate_changed_by');
			$data['item_id'] = $this->input->post('item_id');
			$data['shade_id'] = $this->input->post('shade_id');

			$search['from_date'] = $this->input->post('from_date');
			$search['to_date'] = $this->input->post('to_date');
			$search['customer_id'] = $this->input->post('customer_id');
			$search['rate_changed_by'] = $this->input->post('rate_changed_by');
			$search['item_id'] = $this->input->post('item_id');
			$search['shade_id'] = $this->input->post('shade_id');
		}

		$data['result_reg'] = $this->m_registers->getItem_rate_reg_yt($search);

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
		$this->load->view('item_rate_reg_yt', $data);
	}

	function deleted_box_reg_yt()
	{
		$data['activeTab'] = 'registers';
		$data['activeItem'] = 'deleted_box_reg_yt';
		$data['page_title'] = 'Deleted Boxes Register';
		$data['from_date'] = date("d-m-Y");
		$data['to_date'] = date("d-m-Y");
		$data['customer_id'] = '';
		$data['deleted_by'] = '';
		$data['item_id'] = '';
		$data['shade_id'] = '';

		$search['from_date'] = false;
		$search['to_date'] = false;
		$search['customer_id'] = '';
		$search['deleted_by'] = '';
		$search['item_id'] = '';
		$search['shade_id'] = '';

		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['items'] = $this->m_masters->getactivemaster('bud_items', 'item_status');
		$data['shades'] = $this->m_masters->getactivemaster('bud_shades', 'shade_status');
		$data['users'] = $this->m_masters->getactivemaster('bud_users', 'user_status');
		if ($this->input->post('search')) {
			$data['from_date'] = $this->input->post('from_date');
			$data['to_date'] = $this->input->post('to_date');
			$data['customer_id'] = $this->input->post('customer_id');
			$data['deleted_by'] = $this->input->post('deleted_by');
			$data['item_id'] = $this->input->post('item_id');
			$data['shade_id'] = $this->input->post('shade_id');

			$search['from_date'] = $this->input->post('from_date');
			$search['to_date'] = $this->input->post('to_date');
			// $search['customer_id'] = $this->input->post('customer_id');
			$search['deleted_by'] = $this->input->post('deleted_by');
			$search['item_id'] = $this->input->post('item_id');
			$search['shade_id'] = $this->input->post('shade_id');
		}

		$data['result_reg'] = $this->m_registers->getDeletedBoxesYt($search);

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
		$this->load->view('deleted_box_reg_yt', $data);
	}

	function cust_item_est_reg_yt()
	{
		$data['activeTab'] = 'registers';
		$data['activeItem'] = 'cust_item_est_reg_yt';
		$data['page_title'] = 'Shop(Quotation) Customer & Item Wise Sales Register';
		$data['from_date'] = false;
		$data['to_date'] = false;
		$data['customer_mobile'] = '';
		$data['item_id'] = '';
		$data['shade_id'] = '';

		$search['from_date'] = false;
		$search['to_date'] = false;
		$search['customer_mobile'] = '';
		$search['item_id'] = '';
		$search['shade_id'] = '';

		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['items'] = $this->m_masters->getactivemaster('bud_items', 'item_status');
		$data['shades'] = $this->m_masters->getactivemaster('bud_shades', 'shade_status');
		$data['users'] = $this->m_masters->getactivemaster('bud_users', 'user_status');
		if ($this->input->post('search')) {
			$data['from_date'] = $this->input->post('from_date');
			$data['to_date'] = $this->input->post('to_date');
			$data['customer_mobile'] = $this->input->post('customer_mobile');
			$data['item_id'] = $this->input->post('item_id');
			$data['shade_id'] = $this->input->post('shade_id');

			$search['from_date'] = $this->input->post('from_date');
			$search['to_date'] = $this->input->post('to_date');
			$search['customer_mobile'] = $this->input->post('customer_mobile');
			$search['item_id'] = $this->input->post('item_id');
			$search['shade_id'] = $this->input->post('shade_id');
		}

		$data['result_reg'] = $this->m_registers->get_cust_item_estimate_reg($search);

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
		$this->load->view('v_cust_item_est_reg_yt', $data);
	}
	function delete_estimates()
	{
		if ($this->input->post('delete')) {
			$selected_estimate = $this->input->post('selected_estimate');
			$updateData = array();
			foreach ($selected_estimate as $key => $estimate_id) {
				$updateData[$key]['estimate_id'] = $estimate_id;
				$updateData[$key]['is_deleted'] = 1;
			}
			$this->m_registers->delete_estimate_yt($updateData);
		}
		if ($this->input->post('final_delete')) {
			$selected_estimate = $this->input->post('selected_estimate');
			$this->m_registers->final_delete_estimate_yt($selected_estimate);
		}

		$this->session->set_flashdata('success', 'Successfully Deleted!!!');
		redirect(base_url() . "registers/cust_item_est_reg_yt", 'refresh');
	}
	function general_party_reg()
	{
		$this->load->model('m_masters');
		$data['activeTab'] = 'registers';
		$data['activeItem'] = 'general_party_reg';
		$data['page_title'] = 'General Party Master';
		$data['result_reg'] = $this->m_masters->getallmaster('bud_general_customers');

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
		$this->load->view('v_general_party_reg', $data);
	}
	function material_inw_reg()
	{
		$data['activeTab'] = 'registers';
		$data['activeItem'] = 'material_inw_reg';
		$data['page_title'] = 'Material Inward Register';
		$data['from_date'] = false;
		$data['to_date'] = false;
		$data['supplier'] = '';
		$data['prepared_by'] = '';
		$data['item_id'] = '';
		$data['concern_id'] = '';

		$search['from_date'] = false;
		$search['to_date'] = false;
		$search['supplier'] = '';
		$search['prepared_by'] = '';
		$search['item_id'] = '';
		$search['concern_id'] = '';

		$data['customers'] = $this->m_masters->getallmaster('bud_general_customers');
		$data['items'] = $this->m_masters->getactivemaster('bud_general_items', 'is_active');
		$data['shades'] = $this->m_masters->getactivemaster('bud_shades', 'shade_status');
		$data['users'] = $this->m_masters->getactivemaster('bud_users', 'user_status');
		$data['concerns'] = $this->m_masters->getallmaster('bud_concern_master');
		if ($this->input->post('search')) {
			$data['from_date'] = $this->input->post('from_date');
			$data['to_date'] = $this->input->post('to_date');
			$data['prepared_by'] = $this->input->post('prepared_by');
			$data['supplier'] = $this->input->post('supplier');
			$data['item_id'] = $this->input->post('item_id');
			$data['concern_id'] = $this->input->post('concern_id');

			$search['from_date'] = $this->input->post('from_date');
			$search['to_date'] = $this->input->post('to_date');
			$search['supplier'] = $this->input->post('supplier');
			$search['prepared_by'] = $this->input->post('prepared_by');
			$search['item_id'] = $this->input->post('item_id');
			$search['concern_id'] = $this->input->post('concern_id');
		}

		$data['result_reg'] = $this->m_registers->materialInwarsReg($search);

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
		$this->load->view('material_inw_reg', $data);
	}
	public function box_status_yt() //ER-09-18#-63
	{
		$data['activeTab'] = 'registers';
		$data['activeItem'] = 'box_status_yt';
		$data['page_title'] = 'Box Status Register';
		$data['f_box_no'] = null;
		$data['t_box_no'] = null;
		$data['box_no'] = null;
		$data['box_prefix'] = null;
		$box_no = array();
		$data['box_detail'] = array();
		if (isset($_POST['search'])) {
			$data['f_box_no'] = $this->input->post('from_box_no');
			$data['t_box_no'] = $this->input->post('to_box_no');
			$data['box_no'] = $this->input->post('box_no');
			$data['box_prefix'] = $this->input->post('box_prefix');
			if ($data['box_no']) {
				$box_no = explode(',', $data['box_no']);
			}
			$data['box_detail'] = $this->m_registers->get_box_status_yt($data['box_prefix'], $box_no, $data['f_box_no'], $data['t_box_no']);
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
		$this->load->view('v_1_box_status', $data);
	}
}
