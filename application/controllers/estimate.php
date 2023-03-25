<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Estimate extends CI_Controller
{
	public $data = array();
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');
		$this->load->helper('url');
		$this->load->model('m_shop');
		$this->load->model('m_masters');
		$this->load->model('m_users');

		if (!$this->session->userdata('logged_in')) {
			// Allow some methods?
			$allowed = array();
			if (!in_array($this->router->method, $allowed)) {
				redirect(base_url() . 'users/login', 'refresh');
			}
		}
	}

	function inward()
	{
		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'inward';
		$data['page_title'] = 'Shop :: Inward Entry';
		$data['items'] = $this->m_shop->get_items();
		$data['shades'] = $this->m_shop->get_shades();
		$data['inward_register'] = $this->m_shop->get_inward_register();
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

		$this->load->view('v_s_inward.php', $data);
	}

	function inward_save()
	{
		/*echo "<pre>";
		print_r($_POST);
		echo "</pre>";*/
		$id = $this->input->post('id');
		$inward_date = $this->input->post('inward_date');
		$date = explode("-", $inward_date);
		$inward_date = $date[2] . '-' . $date[1] . '-' . $date[0];
		$dc_no = $this->input->post('dc_no');
		$box_no = $this->input->post('box_no');
		$item_name = $this->input->post('item_name');
		$item_id = $this->input->post('item_id');
		$shade_name = $this->input->post('shade_name');
		$shade_id = $this->input->post('shade_id');
		$no_cones = $this->input->post('no_cones');
		$gr_weight = $this->input->post('gr_weight');
		$nt_weight = $this->input->post('nt_weight');

		$formData = array(
			'id' => $id,
			'inward_date' => $inward_date,
			'dc_no' => $dc_no,
			'box_no' => $box_no,
			'item_id' => $item_id,
			'shade_id' => $shade_id,
			'no_cones' => $no_cones,
			'gr_weight' => $gr_weight,
			'nt_weight' => $nt_weight
		);

		$result = $this->m_shop->save_inward($formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "estimate/inward", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "estimate/inward", 'refresh');
		}
	}

	function inward_register()
	{
		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'inward_register';
		$data['page_title'] = 'Shop :: Inward Register';
		$data['from_date'] = date("d-m-Y");
		$data['to_date'] = date("d-m-Y");
		if ($this->input->post('search')) {
			$data['from_date'] = $this->input->post('from_date');
			$data['to_date'] = $this->input->post('to_date');
		}
		$from_date = date("Y-m-d", strtotime($data['from_date']));
		$to_date = date("Y-m-d", strtotime($data['to_date']));
		$data['inward_register'] = $this->m_shop->get_inward_register($from_date, $to_date);
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

		$this->load->view('v_s_inward_reg.php', $data);
	}
	function index()
	{
		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'estimate';
		$data['page_title'] = 'Shop :: Estimate';
		$data['items'] = $this->m_shop->get_items();
		$data['shades'] = $this->m_shop->get_shades();
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

		$this->load->view('v_s_estimate_form.php', $data);
	}
	function estimate_cartItems()
	{
		$this->load->view('v_s_estimate_cartitems');
	}
	function addtocart()
	{
		$item_id = $_POST['item_id'];
		$shade_id = $_POST['shade_id'];
		$qty = $_POST['qty'];
		$item_uom = $_POST['item_uom'];
		$rate = $_POST['rate'];
		$cartData = array(
			'user_id' => $this->session->userdata('user_id'),
			'item_id' => $item_id,
			'shade_id' => $shade_id,
			'qty' => $qty,
			'item_uom' => $item_uom,
			'rate' => $rate
		);
		$this->m_shop->insertEstimateCart($cartData);
	}
	function removetocart($row_id = null)
	{
		$this->m_shop->deleteEstimateCart($row_id);
	}
	function estimate_save()
	{
		/*echo "<pre>";
		print_r($_POST);
		echo "</pre>";*/
		$estimate_id = null;
		$customer_name = $this->input->post('customer_name');
		$customer_mobile = $this->input->post('customer_mobile');
		$remarks = $this->input->post('remarks');
		$estimate_date = $this->input->post('estimate_date');
		$date = explode("-", $estimate_date);
		$estimate_date = $date[2] . '-' . $date[1] . '-' . $date[0];
		$formData = array(
			'customer_name' => $customer_name,
			'customer_mobile' => $customer_mobile,
			'remarks' => $remarks,
			'estimate_date' => $estimate_date
		);
		$formData['estimate_id'] = $estimate_id;
		$result = $this->m_shop->save_estimate($formData);
		if ($result) {
			$mycart = $this->m_shop->viewEstimateCart();
			foreach ($mycart as $row) {
				$cartData = array(
					'estimate_id' => $result,
					'item_id' => $row['item_id'],
					'shade_id' => $row['shade_id'],
					'qty' => $row['qty'],
					'item_uom' => $row['uom'],
					'rate' => $row['rate'],
					'amount' => ($row['qty'] * $row['rate'])
				);
				$this->m_shop->saveEstimateCart($cartData);
			}

			$this->m_shop->destroyEstimateCart($this->session->userdata('user_id'));

			// $this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "estimate/estimate_view/" . $result, 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "estimate/estimate", 'refresh');
		}
	}
	function estimate_reg()
	{
		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'estimate_reg';
		$data['page_title'] = 'Target Register';

		$data['from_date'] = date("d-m-Y");
		$data['to_date'] = date("d-m-Y");
		$data['from_est_id'] = null;
		$data['to_est_id'] = null;
		if ($this->input->post('search')) {
			$data['from_date'] = $this->input->post('from_date');
			$data['to_date'] = $this->input->post('to_date');
			$data['from_est_id'] = $this->input->post('from_est_id');
			$data['to_est_id'] = $this->input->post('to_est_id');
		}
		$from_date = date("Y-m-d", strtotime($data['from_date']));
		$to_date = date("Y-m-d", strtotime($data['to_date']));
		$from_est_id = $data['from_est_id'];
		$to_est_id = $data['to_est_id'];

		if ($from_est_id > $to_est_id) {
			$data['error'] = 'Please enter From estimate no less than To estimate no';
		}

		$data['estimates'] = $this->m_shop->get_estimate_register($from_date, $to_date, $from_est_id, $to_est_id);
		// $data['shades'] = $this->m_shop->get_shades();
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

		$this->load->view('v_s_estimate_reg.php', $data);
	}
	function cust_item_est_reg()
	{
		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'cust_item_est_reg';
		$data['page_title'] = 'Cust. Targt. Reg.';

		$data['from_date'] = date("d-m-Y");
		$data['to_date'] = date("d-m-Y");
		$data['item_id'] = null;
		$data['customer_mobile'] = null;
		if ($this->input->post('search')) {
			$data['from_date'] = $this->input->post('from_date');
			$data['to_date'] = $this->input->post('to_date');
			$data['item_id'] = $this->input->post('item_id');
			$data['customer_mobile'] = $this->input->post('customer_mobile');
		}
		$from_date = date("Y-m-d", strtotime($data['from_date']));
		$to_date = date("Y-m-d", strtotime($data['to_date']));
		$item_id = $data['item_id'];
		$customer_mobile = $data['customer_mobile'];

		$data['estimates_list'] = $this->m_shop->get_cust_item_estimate_reg($from_date, $to_date, $item_id, $customer_mobile);
		// $data['shades'] = $this->m_shop->get_shades();
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

		$this->load->view('v_s_cust_item_est_reg.php', $data);
	}
	function estimate_view($estimate_id = false)
	{
		$estimate = $this->m_shop->get_estimate($estimate_id);
		/*echo "<pre>";
		print_r($estimate);
		echo "</pre>";*/
		if (!isset($estimate['estimate_id'])) {
			$this->session->set_flashdata('error', 'No data found!');
			redirect(base_url() . "estimate/estimate_reg", 'refresh');
		}
		$data['estimate'] = $estimate;
		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'estimate_view';
		$data['page_title'] = 'Shop :: View Estimate';
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

		$this->load->view('v_s_estimate_view.php', $data);
	}

	function estimate_report()
	{
		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'estimate_report';
		$data['page_title'] = 'Target Report';
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

		$from_date = date("01-m-Y");
		$to_date = date("d-m-Y");
		if ($this->input->post('from_date') && $this->input->post('to_date')) {
			$from_date = $this->input->post('from_date');
			$to_date = $this->input->post('to_date');
		}
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;

		$from_date = date('Y-m-d', strtotime($from_date));
		$to_date = date('Y-m-d', strtotime($to_date));

		$data['result'] = $this->m_shop->estimate_report($from_date, $to_date);

		$this->load->view('v_s_estimate_report', $data);
	}
}
