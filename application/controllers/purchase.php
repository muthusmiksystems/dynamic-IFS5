<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Purchase extends CI_Controller
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
	function enquiries()
	{
		$data['activeTab'] = 'purchase';
		$data['activeItem'] = 'enquiries';
		$data['page_title'] = 'Enquires';
		$data['enquiries'] = $this->m_purchase->getactiveenquiries();
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
			$this->load->view('v_enquiries.php', $data);
		} else {
			$data['category_id'] = $this->uri->segment(3);
			$this->load->view('v_enquiries.php', $data);
		}
	}
	function enquiry()
	{
		$data['activeTab'] = 'purchase';
		$data['activeItem'] = 'enquiry';
		$data['page_title'] = 'New Enquiry';
		$data['categories'] = $this->m_masters->getallcategories();
		$data['shades'] = $this->m_masters->getactiveCdatas('bud_shades', 'shade_status', 'shade_category', 1);
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
			$this->load->view('v_newenquiry.php', $data);
		} else {
			$data['category_id'] = $this->uri->segment(3);
			$this->load->view('v_newenquiry.php', $data);
		}
	}
	function addenquiryItem()
	{
		$enq_category = $this->input->post('enq_category');
		$enq_date = $this->input->post('enq_date');
		$enq_customer = $this->input->post('enq_customer');
		$enq_itemgroup = $this->input->post('enq_itemgroup');
		$enq_item = $this->input->post('enq_item');
		$enq_itemcolor = $this->input->post('enq_itemcolor');
		$enq_itemuom = $this->input->post('enq_itemuom');
		$enq_required_qty = $this->input->post('enq_required_qty');

		$cartdata = array(
			'id'      => $enq_item,
			'enq_category' => $enq_category,
			'enq_date' => $enq_date,
			'enq_customer' => $enq_customer,
			'enq_itemgroup' => $enq_itemgroup,
			'enq_item' => $enq_item,
			'enq_itemcolor' => $enq_itemcolor,
			'enq_itemuom' => $enq_itemuom,
			'enq_required_qty' => $enq_required_qty,
			'qty'     => $enq_required_qty,
			'price'   => 39.95,
			'name'    => $enq_item,
			'options' => array('enq_itemcolor' => $enq_itemcolor)
		);
		if (sizeof($this->cart->contents()) > 0) {
			foreach ($this->cart->contents() as $items) {
				$options = $this->cart->product_options($items['rowid']);
				if ($items['id'] == $enq_item && $options['enq_itemcolor'] == $enq_itemcolor) {
					$quantity = $items['qty'] + $enq_required_qty;
					$cartdata = array(
						'rowid' => $items['rowid'],
						'qty'   => $quantity
					);
					$this->cart->update($cartdata);
				} else {
					$this->cart->insert($cartdata);
				}
			}
		} else {
			$this->cart->insert($cartdata);
		}
	}
	function deleteenquiryItem($row_id = null)
	{
		$updatecart = array(
			'rowid' => $row_id,
			'qty'   => 0
		);
		$this->cart->update($updatecart);
		redirect(base_url() . 'purchase/enquiry');
	}
	function saveenquiry()
	{
		$enq_category = $this->input->post('enq_category');
		$enq_date = $this->input->post('enq_date');
		$enq_customer = $this->input->post('enq_customer');
		$enq_shade_no = $this->input->post('enq_shade_no');
		$enq_lot_no = $this->input->post('enq_lot_no');
		$enq_lead_time = $this->input->post('enq_lead_time');
		$enq_reference = $this->input->post('enq_reference');
		$enq_item_remarks = $this->input->post('enq_item_remarks');
		$enq_remarks = $this->input->post('enq_remarks');
		$ed = explode("-", $enq_date);
		$enq_date = $ed[2] . '-' . $ed[1] . '-' . $ed[0];
		$enquiryData = array(
			'enq_category' => $enq_category,
			'enq_date' => $enq_date,
			'enq_customer' => $enq_customer,
			'enq_shade_no' => $enq_shade_no,
			'enq_lot_no' => $enq_lot_no,
			'enq_lead_time' => $enq_lead_time,
			'enq_reference' => $enq_reference,
			'enq_item_remarks' => $enq_item_remarks,
			'enq_remarks' => $enq_remarks
		);
		$enq_ref_id = $this->m_purchase->saveenquiry($enquiryData);
		if ($enq_ref_id) {
			foreach ($this->cart->contents() as $items) {
				$itemData = array(
					'enq_ref_id' => $enq_ref_id,
					'enq_itemgroup' => $items['enq_itemgroup'],
					'enq_item' => $items['enq_item'],
					'enq_itemcolor' => $items['enq_itemcolor'],
					'enq_itemuom' => $items['enq_itemuom'],
					'enq_required_qty' => $items['qty']
				);
				$this->m_purchase->saveenquiryItem($itemData);
			}
		}
		if ($enq_ref_id) {
			$this->cart->destroy();
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "purchase/enquiry", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "purchase/enquiry", 'refresh');
		}
	}
	function enquiry_items()
	{
		$this->load->view('v_enquiry_items.php');
	}
	function newquotation()
	{
		$enq_id = $this->uri->segment(3);
		$data['activeTab'] = 'purchase';
		$data['activeItem'] = 'newquotation';
		$data['page_title'] = 'New Quotation';
		$data['enquiries'] = $this->m_purchase->getenquiry($enq_id);
		$data['items'] = $this->m_purchase->getenquiryitems($enq_id);
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
			$this->load->view('v_newquotation.php', $data);
		} else {
			$this->load->view('v_newquotation.php', $data);
		}
	}
	function savequotation()
	{
		$enq_id = $this->input->post('enq_id');
		$enq_customer = $this->input->post('enq_customer');
		$quote_category = $this->input->post('enq_category');
		$quote_date = $this->input->post('quote_date');
		$quote_lead_time = $this->input->post('quote_lead_time');
		$quote_reference = $this->input->post('quote_reference');
		$quote_item_remarks = $this->input->post('quote_item_remarks');
		$quote_remarks = $this->input->post('quote_remarks');
		$quote_payment_terms = $this->input->post('quote_payment_terms');
		$enq_item_rates = $this->input->post('enq_item_rate');
		$qd = explode("-", $quote_date);
		$quote_date = $qd[2] . '-' . $qd[1] . '-' . $qd[0];
		$quoteData = array(
			'quote_enq_id' => $enq_id,
			'quote_category' => $quote_category,
			'quote_date' => $quote_date,
			'quote_customer' => $enq_customer,
			'quote_lead_time' => $quote_lead_time,
			'quote_reference' => $quote_reference,
			'quote_item_remarks' => $quote_item_remarks,
			'quote_remarks' => $quote_remarks,
			'quote_payment_terms' => $quote_payment_terms
		);
		$result = $this->m_purchase->saveDatas('bud_quotations', $quoteData);
		foreach ($enq_item_rates as $key => $value) {
			$updateData = array(
				'enq_item_rate' => $value
			);
			$this->m_purchase->updatecartItem($key, $updateData);
		}
		if ($result) {
			$removeEnquiry = array(
				'enq_status' => 0
			);
			$this->m_purchase->updateDatas('bud_enquiries', 'enq_id', $enq_id, $removeEnquiry);
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "purchase/quotations", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "purchase/quotations", 'refresh');
		}
	}
	function quotations()
	{
		$data['activeTab'] = 'purchase';
		$data['activeItem'] = 'quotations';
		$data['page_title'] = 'Quotations';
		$data['quotations'] = $this->m_purchase->getactivequotations();
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
			$this->load->view('v_quotations.php', $data);
		} else {
			$data['category_id'] = $this->uri->segment(3);
			$this->load->view('v_quotations.php', $data);
		}
	}
	function newpurchaseorder()
	{
		$quote_id = $this->uri->segment(3);
		$data['activeTab'] = 'purchase';
		$data['activeItem'] = 'neworder';
		$data['page_title'] = 'New Purchase Order';
		$data['quotations'] = $this->m_purchase->getDatas('bud_quotations', 'quote_id', $quote_id);
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
			$this->load->view('v_newpurchaseorder.php', $data);
		} else {
			$this->load->view('v_newpurchaseorder.php', $data);
		}
	}
	function saveorder()
	{
		$quote_id = $this->input->post('quote_id');
		$order_enq_id = $this->input->post('order_enq_id');
		$order_category = $this->input->post('order_category');
		$order_date = $this->input->post('order_date');
		$order_customer = $this->input->post('order_customer');
		$taxs = $this->input->post('taxs');
		$order_tax_names = $this->input->post('order_tax_names');
		$order_othercharges = $this->input->post('order_othercharges');
		$order_othercharges_unit = $this->input->post('order_othercharges_unit');
		$order_othercharges_type = $this->input->post('order_othercharges_type');
		$order_othercharges_names = $this->input->post('order_othercharges_names');
		$order_packing_details = $this->input->post('order_packing_details');
		$order_transportation = $this->input->post('order_transportation');
		$order_lead_time = $this->input->post('order_lead_time');
		$order_reference = $this->input->post('order_reference');
		$order_item_remarks = $this->input->post('order_item_remarks');
		$order_remarks = $this->input->post('order_remarks');
		$order_payment_terms = $this->input->post('order_payment_terms');

		$od = explode("-", $order_date);
		$order_date = $od[2] . '-' . $od[1] . '-' . $od[0];
		$orderData = array(
			'order_enq_id' => $order_enq_id,
			'order_category' => $order_category,
			'order_date' => $order_date,
			'order_customer' => $order_customer,
			'taxs' => implode(",", $taxs),
			'order_tax_names' => implode(",", $taxs),
			'order_othercharges' => implode(",", $order_othercharges),
			'order_othercharges_unit' => implode(",", $order_othercharges_unit),
			'order_othercharges_type' => implode(",", $order_othercharges_type),
			'order_othercharges_names' => implode(",", $order_othercharges_names),
			'order_packing_details' => $order_packing_details,
			'order_transportation' => $order_transportation,
			'order_lead_time' => $order_lead_time,
			'order_reference' => $order_reference,
			'order_item_remarks' => $order_item_remarks,
			'order_remarks' => $order_remarks,
			'order_payment_terms' => $order_payment_terms,
			'order_status' => 1
		);
		$result = $this->m_purchase->saveDatas('bud_orders', $orderData);
		if ($result) {
			$removeQuote = array(
				'quote_status' => 0
			);
			$this->m_purchase->updateDatas('bud_quotations', 'quote_id', $quote_id, $removeQuote);
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "purchase/quotations", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "purchase/quotations", 'refresh');
		}
	}
	function purchaseorders()
	{
		$data['activeTab'] = 'purchase';
		$data['activeItem'] = 'neworder';
		$data['page_title'] = 'Purchase Orders';
		$data['orders'] = $this->m_purchase->getActivetableDatas('bud_orders', 'order_status');
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
			$this->load->view('v_orders.php', $data);
		} else {
			$data['category_id'] = $this->uri->segment(3);
			$this->load->view('v_orders.php', $data);
		}
	}
	function vieworder()
	{
		$order_id = $this->uri->segment(3);
		$data['activeTab'] = 'purchase';
		$data['activeItem'] = 'neworder';
		$data['page_title'] = 'Purchase Orders';
		$data['orders'] = $this->m_purchase->getDatas('bud_orders', 'order_id', $order_id);
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
			$this->load->view('v_vieworder.php', $data);
		} else {
			$this->load->view('v_vieworder.php', $data);
		}
	}
	function delivery()
	{
		$order_id = $this->uri->segment(3);
		$data['activeTab'] = 'purchase';
		$data['activeItem'] = 'deliveries';
		$data['page_title'] = 'Delivery';
		$data['orders'] = $this->m_purchase->getDatas('bud_orders', 'order_id', $order_id);
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
			$this->load->view('v_deliveryentry.php', $data);
		} else {
			$this->load->view('v_deliveryentry.php', $data);
		}
	}
	function savedelivery()
	{
		$delivery_items = array();
		$delivery_qty = array();
		$delivery_enq_id = $this->input->post('delivery_enq_id');
		$delivery_category = $this->input->post('delivery_category');
		$delivery_date = $this->input->post('delivery_date');
		$delivery_supplier = $this->input->post('delivery_supplier');
		$order_delivery_qty = $this->input->post('order_delivery_qty');
		$delivery_issued_by = $this->input->post('delivery_issued_by');
		$delivery_issued_to = $this->input->post('delivery_issued_to');
		$delivery_remarks = $this->input->post('delivery_remarks');
		$dd = explode("-", $delivery_date);
		$delivery_date = $dd[2] . '-' . $dd[1] . '-' . $dd[0];
		foreach ($order_delivery_qty as $key => $value) {
			$delivery_items[] = $key;
			$delivery_qty[] = $value;
		}
		$delivery_Data = array(
			'delivery_enq_id' => $delivery_enq_id,
			'delivery_category' => $delivery_category,
			'delivery_date' => $delivery_date,
			'delivery_supplier' => $delivery_supplier,
			'delivery_items' => implode(",", $delivery_items),
			'delivery_qty' => implode(",", $delivery_qty),
			'delivery_issued_by' => $delivery_issued_by,
			'delivery_issued_to' => $delivery_issued_to,
			'delivery_remarks' => $delivery_remarks
		);
		$result = $this->m_purchase->saveDatas('bud_deliveries', $delivery_Data);
		foreach ($order_delivery_qty as $key => $value) {
			$updateData = array(
				'enq_delivery_qty' => $value
			);
			$this->m_purchase->updatecartItem($key, $updateData);
		}
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "purchase/deliveries", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "purchase/deliveries", 'refresh');
		}
	}
	function deliveries()
	{
		$data['activeTab'] = 'purchase';
		$data['activeItem'] = 'deliveries';
		$data['page_title'] = 'Purchase Orders';
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
			$this->load->view('v_deliveries.php', $data);
		} else {
			$this->load->view('v_deliveries.php', $data);
		}
	}

	// Tapes and Elastic
	function getItems_2_datas($group_id = null)
	{
		$itemsdata_arr = array();
		$itemsdata = '<option value="">Select Item</option>';
		$items = $this->m_masters->getactiveCdatas('bud_te_items', 'item_status', 'item_group', $group_id);
		foreach ($items as $item) {
			$item_id = $item['item_id'];
			$item_name = $item['item_name'];
			$itemsdata .= '<option value="' . $item_id . '">' . $item_name . '</option>';
		}
		$itemsdata_arr[] = $itemsdata;
		echo implode(",", $itemsdata_arr);
	}

	function add_enq_2_item()
	{
		// $this->cart->destroy();
		$enq_item = $this->input->post('enq_item');
		$enq_itemgroup = $this->input->post('enq_itemgroup');
		$enq_required_qty = $this->input->post('enq_required_qty');
		$enq_itemuom = $this->input->post('enq_itemuom');
		$cartdata = array(
			'id'      => $enq_item,
			'enq_itemuom' => $enq_itemuom,
			'qty'     => $enq_required_qty,
			'price'   => 1,
			'name'    => $enq_itemgroup
		);
		if (sizeof($this->cart->contents()) > 0) {
			foreach ($this->cart->contents() as $items) {
				if ($items['id'] == $enq_item) {
					$quantity = $items['qty'] + $enq_required_qty;
					$cartdata = array(
						'rowid' => $items['rowid'],
						'qty'   => $quantity
					);
					$this->cart->update($cartdata);
				} else {
					$this->cart->insert($cartdata);
				}
			}
		} else {
			$this->cart->insert($cartdata);
		}
	}
	function remove_enq_2_item($row_id = null)
	{
		$updatecart = array(
			'rowid' => $row_id,
			'qty'   => 0
		);
		$this->cart->update($updatecart);
	}
	function enq_2_items()
	{
		$this->load->view('v_2_enq_items.php');
	}
	function newenquiry_2()
	{
		$data['activeTab'] = 'purchase';
		$data['activeItem'] = 'newenquiry_2';
		$data['page_title'] = 'New Enquiry';
		$data['staffs'] = $this->m_masters->getactivemaster('bud_users', 'user_status');
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['itemgroups'] = $this->m_masters->getactivemaster('bud_te_itemgroups', 'group_status');
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
			$this->load->view('v_2_newenquiry.php', $data);
		} else {
			$data['category_id'] = $this->uri->segment(3);
			$this->load->view('v_2_newenquiry.php', $data);
		}
	}
	function newenquiry_2_save()
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_te_enquiries'");
		$next = $next->row(0);
		$enq_id = $next->Auto_increment;

		$enq_date = $this->input->post('enq_date');
		$enq_customer = $this->input->post('enq_customer');
		$enq_mark_staff = $this->input->post('enq_mark_staff');
		$enq_lead_time = $this->input->post('enq_lead_time');
		$enq_reference = $this->input->post('enq_reference');
		$enq_item_remarks = $this->input->post('enq_item_remarks');
		$enq_remarks = $this->input->post('enq_remarks');
		$ed = explode("-", $enq_date);
		$enq_date = $ed[2] . '-' . $ed[1] . '-' . $ed[0];
		$formData = array(
			'enq_date' => $enq_date,
			'enq_customer' => $enq_customer,
			'enq_mark_staff' => $enq_mark_staff,
			'enq_lead_time' => $enq_lead_time,
			'enq_reference' => $enq_reference,
			'enq_item_remarks' => $enq_item_remarks,
			'enq_remarks' => $enq_remarks
		);
		$result = $this->m_purchase->saveDatas('bud_te_enquiries', $formData);
		if ($result) {

			foreach ($this->cart->contents() as $items) {
				$cartData = array(
					'enq_id' => $enq_id,
					'enq_item_group' => $items['name'],
					'enq_item' => $items['id'],
					'enq_req_qty' => $items['qty'],
					'enq_item_uom' => $items['enq_itemuom']
				);
				$result = $this->m_purchase->saveDatas('bud_te_enq_items', $cartData);
			}
			$this->cart->destroy();
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "purchase/newenquiry_2", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "purchase/newenquiry_2", 'refresh');
		}
	}
	function enquiries_2()
	{
		$data['activeTab'] = 'purchase';
		$data['activeItem'] = 'enquiries_2';
		$data['page_title'] = 'Enquires Recieved';
		$data['enquiries'] = $this->m_masters->getallmaster('bud_te_enquiries');
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
		$this->load->view('v_2_new_enq_receiced.php', $data);
	}
	function newquotation_2()
	{
		$enq_id = $this->uri->segment(3);
		$data['activeTab'] = 'purchase';
		$data['activeItem'] = 'newquotation_2';
		$data['page_title'] = 'New Quotation';
		$data['enquiries'] = $this->m_masters->getmasterdetails('bud_te_enquiries', 'enq_id', $enq_id);
		$data['items'] = $this->m_masters->getmasterdetails('bud_te_enq_items', 'enq_id', $enq_id);
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
			$this->load->view('v_2_newquotation.php', $data);
		} else {
			$this->load->view('v_2_newquotation.php', $data);
		}
	}
	function savequotation_2()
	{
		$quote_id = $this->input->post('quote_id');
		$quote_revised = $this->input->post('quote_revised');
		$enq_id = $this->input->post('enq_id');
		$quote_date = $this->input->post('quote_date');
		$enq_customer = $this->input->post('enq_customer');
		$quote_lead_time = $this->input->post('quote_lead_time');
		$quote_reference = $this->input->post('quote_reference');
		$quote_item_remarks = $this->input->post('quote_item_remarks');
		$quote_remarks = $this->input->post('quote_remarks');
		$quote_payment_terms = $this->input->post('quote_payment_terms');
		$enq_item_rate = $this->input->post('enq_item_rate');
		$qd = explode("-", $quote_date);
		$quote_date = $qd[2] . '-' . $qd[1] . '-' . $qd[0];

		$enq_items = array();
		foreach ($enq_item_rate as $key => $rates) {
			foreach ($rates as $key1 => $rate) {
				if ($rate == '') {
					unset($rates[$key1]);
				}
			}
			$enq_items[] = $key;
			$enq_item_rate[$key] = $rates;
		}

		$quote_rate_id = $this->input->post('quote_rate_id');

		$quoteData = array(
			'quote_enq_id' => $enq_id,
			'quote_date' => $quote_date,
			'quote_customer' => $enq_customer,
			'quote_lead_time' => $quote_lead_time,
			'quote_reference' => $quote_reference,
			'quote_item_remarks' => $quote_item_remarks,
			'quote_remarks' => $quote_remarks,
			'quote_payment_terms' => $quote_payment_terms,
			'quote_items' => implode(",", $enq_items),
			'quote_rate_id' => implode(",", $quote_rate_id)
		);
		if ($quote_revised == 1) {
			$result = $this->m_purchase->saveDatas('bud_te_quotations', $quoteData);
			foreach ($enq_item_rate as $key => $value) {
				$updateData = array(
					'enq_item_rate' => implode(",", $value)
				);
				$this->m_purchase->updateDatas('bud_te_enq_items', 'enq_item_id', $key, $updateData);
			}
			if ($result) {
				$removeEnquiry = array(
					'enq_status' => 0
				);
				$this->m_purchase->updateDatas('bud_te_enquiries', 'enq_id', $enq_id, $removeEnquiry);
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "purchase/enquiries_2", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "purchase/enquiries_2", 'refresh');
			}
		} else {
			if ($quote_id == '') {
				$result = $this->m_purchase->saveDatas('bud_te_quotations', $quoteData);
			} else {
				$result = $this->m_purchase->updateDatas('bud_te_quotations', 'quote_id', $quote_id, $quoteData);
			}
			foreach ($enq_item_rate as $key => $value) {
				$updateData = array(
					'enq_item_rate' => implode(",", $value)
				);
				$this->m_purchase->updateDatas('bud_te_enq_items', 'enq_item_id', $key, $updateData);
			}

			if ($result) {
				$removeEnquiry = array(
					'enq_status' => 0
				);
				$this->m_purchase->updateDatas('bud_te_enquiries', 'enq_id', $enq_id, $removeEnquiry);
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "purchase/enquiries_2", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "purchase/enquiries_2", 'refresh');
			}
		}
	}
	function quotations_2()
	{
		$data['activeTab'] = 'purchase';
		$data['activeItem'] = 'quotations_2';
		$data['page_title'] = 'Quotations';
		$data['quotations'] = $this->m_masters->getallmaster('bud_te_quotations');
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
			$this->load->view('v_2_quotations.php', $data);
		} else {
			$data['category_id'] = $this->uri->segment(3);
			$this->load->view('v_2_quotations.php', $data);
		}
	}
	function newpurchaseorder_2()
	{
		$quote_id = $this->uri->segment(3);
		$data['activeTab'] = 'purchase';
		$data['activeItem'] = 'purchaseorders_2';
		$data['page_title'] = 'New Purchase Order';
		$data['quotations'] = $this->m_purchase->getDatas('bud_te_quotations', 'quote_id', $quote_id);
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
			$this->load->view('v_2_newpurchaseorder.php', $data);
		} else {
			$this->load->view('v_2_newpurchaseorder.php', $data);
		}
	}
	function purchaseorder_2_save()
	{
		$quote_id = $this->input->post('quote_id');
		$order_enq_id = $this->input->post('order_enq_id');
		$order_date = $this->input->post('order_date');
		$order_customer = $this->input->post('order_customer');
		$taxs = $this->input->post('taxs');
		$order_tax_names = $this->input->post('order_tax_names');
		$order_othercharges = $this->input->post('order_othercharges');
		$order_othercharges_unit = $this->input->post('order_othercharges_unit');
		$order_othercharges_type = $this->input->post('order_othercharges_type');
		$order_othercharges_names = $this->input->post('order_othercharges_names');
		$order_packing_details = $this->input->post('order_packing_details');
		$order_transportation = $this->input->post('order_transportation');
		$order_lead_time = $this->input->post('order_lead_time');
		$order_reference = $this->input->post('order_reference');
		$order_item_remarks = $this->input->post('order_item_remarks');
		$order_remarks = $this->input->post('order_remarks');
		$order_payment_terms = $this->input->post('order_payment_terms');
		$quote_items = $this->input->post('quote_items');
		$order_rate_id = $this->input->post('quote_rate_id');

		$od = explode("-", $order_date);
		$order_date = $od[2] . '-' . $od[1] . '-' . $od[0];
		$orderData = array(
			'order_enq_id' => $order_enq_id,
			'order_date' => $order_date,
			'order_customer' => $order_customer, /*
			'taxs' => implode(",", $taxs), 
			'order_tax_names' => implode(",", $order_tax_names), 
			'order_othercharges' => implode(",", $order_othercharges), 
			'order_othercharges_unit' => implode(",", $order_othercharges_unit), 
			'order_othercharges_type' => implode(",", $order_othercharges_type), 
			'order_othercharges_names' => implode(",", $order_othercharges_names),*/
			'order_packing_details' => $order_packing_details,
			'order_transportation' => $order_transportation,
			'order_lead_time' => $order_lead_time,
			'order_reference' => $order_reference,
			'order_item_remarks' => $order_item_remarks,
			'order_remarks' => $order_remarks,
			'order_payment_terms' => $order_payment_terms,
			'order_items' => $quote_items,
			'order_rate_id' => $order_rate_id,
			'order_status' => 1
		);

		if ($this->input->post('taxs')) {
			$orderData['taxs'] = implode(",", $this->input->post('taxs'));
		}
		if ($this->input->post('order_tax_names')) {
			$orderData['order_tax_names'] = implode(",", $this->input->post('order_tax_names'));
		}
		if ($this->input->post('order_othercharges')) {
			$orderData['order_othercharges'] = implode(",", $this->input->post('order_othercharges'));
		}
		if ($this->input->post('order_othercharges_unit')) {
			$orderData['order_othercharges_unit'] = implode(",", $this->input->post('order_othercharges_unit'));
		}
		if ($this->input->post('order_othercharges_type')) {
			$orderData['order_othercharges_type'] = implode(",", $this->input->post('order_othercharges_type'));
		}
		if ($this->input->post('order_othercharges_names')) {
			$orderData['order_othercharges_names'] = implode(",", $this->input->post('order_othercharges_names'));
		}

		$result = $this->m_purchase->saveDatas('bud_te_purchaseorders', $orderData);
		if ($result) {
			$is_admin = $this->m_users->is_admin($this->session->userdata('user_id'));
			if ($is_admin) {
				$enq_item_rate = $this->input->post('enq_item_rate');
				$quote_rate_id = explode(",", $this->input->post('quote_rate_id'));
				$enq_item_rates = $this->input->post('enq_item_rates');
				$cust_key = 0;
				foreach ($enq_item_rates as $key => $value) {
					$rate_array = explode(",", $value);
					$rate_array[$quote_rate_id[$cust_key]] = $enq_item_rate[$key];
					$rateData = array(
						'enq_item_rate' => implode(",", $rate_array)
					);
					$cust_key++;
					$this->m_purchase->updateDatas('bud_te_enq_items', 'enq_item_id', $key, $rateData);
				}
			}

			$removeQuote = array(
				'quote_status' => 0
			);
			$this->m_purchase->updateDatas('bud_te_quotations', 'quote_id', $quote_id, $removeQuote);
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "purchase/purchaseorders_2", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "purchase/purchaseorders_2", 'refresh');
		}
	}
	function purchaseorders_2()
	{
		$data['activeTab'] = 'purchase';
		$data['activeItem'] = 'purchaseorders_2';
		$data['page_title'] = 'Purchase Orders';
		$data['orders'] = $this->m_purchase->getActivetableDatas('bud_te_purchaseorders', 'order_status');
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
			$this->load->view('v_2_purchaseorders.php', $data);
		} else {
			$data['category_id'] = $this->uri->segment(3);
			$this->load->view('v_2_purchaseorders.php', $data);
		}
	}
	function vieworder_2()
	{
		$order_id = $this->uri->segment(3);
		$data['activeTab'] = 'purchase';
		$data['activeItem'] = 'purchaseorders_2';
		$data['page_title'] = 'Purchase Orders';
		$data['orders'] = $this->m_purchase->getDatas('bud_te_purchaseorders', 'order_id', $order_id);
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
			$this->load->view('v_2_vieworder.php', $data);
		} else {
			$this->load->view('v_2_vieworder.php', $data);
		}
	}
	// Labels
	function po_register_3()
	{
		$data['activeTab'] = 'purchase';
		$data['activeItem'] = 'po_register_3';
		$data['page_title'] = 'P.O. Register';
		$data['purchaseorders'] = $this->m_purchase->getLabelPo(1);
		$data['items'] = $this->m_masters->getactivemaster('bud_lbl_items', 'item_status');
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['staffs'] = $this->m_masters->getactivemaster('bud_users', 'user_status');
		$data['machines'] = $this->m_masters->getactivemaster('bud_te_machines', 'machine_status');
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
			$this->load->view('labels/v_3_po-register', $data);
			$data['item_id'] = null;
		} else {
			$data['item_id'] = $this->uri->segment(3);
			$this->load->view('labels/v_3_po-register', $data);
		}
	}
	function po_received_3()
	{
		$data['activeTab'] = 'purchase';
		$data['activeItem'] = 'po_received_3';
		$data['page_title'] = 'P.O. Recieved';
		$data['purchaseorders'] = $this->m_purchase->getLabelPo();
		$data['items'] = $this->m_masters->getactivemaster('bud_lbl_items', 'item_status');
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['staffs'] = $this->m_masters->getactivemaster('bud_users', 'user_status');
		$data['machines'] = $this->m_masters->getactivemaster('bud_te_machines', 'machine_status');
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
			$this->load->view('labels/v_3_po-received', $data);
			$data['item_id'] = null;
		} else {
			$data['item_id'] = $this->uri->segment(3);
			$this->load->view('labels/v_3_po-received', $data);
		}
	}
	function save_po_received_3()
	{
		/*echo "<pre>";
		print_r($_POST);
		echo "</pre>";*/
		$po_date = date("Y-m-d");
		$item_name = $this->input->post('item_name');
		$machine_id = $this->input->post('machine_id');
		$item_code = $this->input->post('item_code');
		$customer_id = $this->input->post('customer_id');
		$delivery_form = $this->input->post('delivery_form');
		$marketing_by = $this->input->post('marketing_by');
		$po_qty = $this->input->post('po_qty');
		$po_sizes = array();
		foreach ($po_qty as $key => $value) {
			$po_sizes[$key] = $key;
		}
		$po_remarks = $this->input->post('po_remarks');
		$formData = array(
			'po_date' => $po_date,
			'machine_id' => $machine_id,
			'item_code' => $item_code,
			'customer_id' => $customer_id,
			'delivery_form' => $delivery_form,
			'marketing_by' => $marketing_by,
			'po_remarks' => $po_remarks
		);
		$po_no = $this->m_purchase->saveDatas('bud_lbl_po_received', $formData);
		if ($po_no) {
			foreach ($po_sizes as $key => $value) {
				$po_items = array(
					'po_no' => $po_no,
					'item_id' => $item_code,
					'po_item_size' => $value,
					'po_qty' => $po_qty[$key]
				);
				$this->m_purchase->saveDatas('bud_lbl_po_items', $po_items);
			}
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "purchase/po_received_3", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "purchase/po_received_3", 'refresh');
		}
	}

	function po_completed($po_no)
	{
		$p_order = $this->m_purchase->get_po_lbl($po_no);
		if (!$p_order) {
			$this->session->set_flashdata('error', 'No data found');
			redirect(base_url() . "purchase/po_received_3", 'refresh');
		}
		$data = array(
			'po_completed' => 1
		);
		$result = $this->m_purchase->updateDatas('bud_lbl_po_received', 'po_no', $po_no, $data);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "purchase/po_received_3", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "purchase/po_received_3", 'refresh');
		}
	}
	function po_edit_3()
	{
		$data['activeTab'] = 'purchase';
		$data['activeItem'] = 'po_received_3';
		$data['page_title'] = 'P.O. Edit';
		$data['purchaseorders'] = $this->m_purchase->getLabelPo();
		$data['items'] = $this->m_masters->getactivemaster('bud_lbl_items', 'item_status');
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['staffs'] = $this->m_masters->getactivemaster('bud_users', 'user_status');
		$data['machines'] = $this->m_masters->getactivemaster('bud_te_machines', 'machine_status');
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
			redirect(base_url());
		} else {
			$data['po_no'] = $this->uri->segment(3);
		}
		$this->load->view('labels/v_3_po-edit', $data);
	}
	function update_po_received_3()
	{
		/*echo "<pre>";
		print_r($_POST);
		echo "</pre>";*/
		// $po_date = date("Y-m-d");
		$po_no = $this->input->post('po_no');
		$item_name = $this->input->post('item_name');
		$item_code = $this->input->post('item_code');
		$machine_id = $this->input->post('machine_id');
		$customer_id = $this->input->post('customer_id');
		$delivery_form = $this->input->post('delivery_form');
		$marketing_by = $this->input->post('marketing_by');
		$po_qty = $this->input->post('po_qty');
		$po_sizes = array();
		foreach ($po_qty as $key => $value) {
			if ($value > 0) {
				$po_sizes[$key] = $key;
			}
		}
		$po_remarks = $this->input->post('po_remarks');
		$formData = array(
			'item_code' => $item_code,
			'machine_id' => $machine_id,
			'customer_id' => $customer_id,
			'delivery_form' => $delivery_form,
			'marketing_by' => $marketing_by,
			'po_remarks' => $po_remarks
		);
		$result = $this->m_purchase->updateDatas('bud_lbl_po_received', 'po_no', $po_no, $formData);
		if ($result) {
			$this->m_masters->deletemaster('bud_lbl_po_items', 'po_no', $po_no);
			foreach ($po_sizes as $key => $value) {
				$po_items = array(
					'po_no' => $po_no,
					'item_id' => $item_code,
					'po_item_size' => $value,
					'po_qty' => $po_qty[$key]
				);
				$this->m_purchase->saveDatas('bud_lbl_po_items', $po_items);
			}
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "purchase/po_received_3", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "purchase/po_received_3", 'refresh');
		}
	}
}
