<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Productions extends CI_Controller
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
		$data['activeTab'] = 'productions';
		$data['activeItem'] = 'enquiries';
		$data['page_title'] = 'Enquires';
		$data['enquiries'] = $this->m_purchase->getActivetableDatas('bud_joborder_enquiries', 'enq_status');
		$data['css'] = array('css/bootstrap.min.css', 'css/bootstrap-reset.css', 'assets/font-awesome/css/font-awesome.css', 'assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css', 'css/owl.carousel.css', 'css/style.css', 'css/style-responsive.css', 'assets/bootstrap-datepicker/css/datepicker.css');
		$data['js_IE'] = array('js/html5shiv.js', 'js/respond.min.js');
		$data['js'] = array(
			'js/jquery.js',
			'js/jquery-1.8.3.min.js',
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
			$this->load->view('v_joborderenquiries.php', $data);
		} else {
			$data['category_id'] = $this->uri->segment(3);
			$this->load->view('v_joborderenquiries.php', $data);
		}
	}
	function enquiry()
	{
		$data['activeTab'] = 'productions';
		$data['activeItem'] = 'enquiry';
		$data['page_title'] = 'New Enquiry';
		$data['categories'] = $this->m_masters->getallcategories();
		$data['shades'] = $this->m_masters->getactiveCdatas('bud_shades', 'shade_status', 'shade_category', 1);
		$data['css'] = array('css/bootstrap.min.css', 'css/bootstrap-reset.css', 'assets/font-awesome/css/font-awesome.css', 'assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css', 'css/owl.carousel.css', 'css/style.css', 'css/style-responsive.css', 'assets/bootstrap-datepicker/css/datepicker.css');
		$data['js_IE'] = array('js/html5shiv.js', 'js/respond.min.js');
		$data['js'] = array(
			'js/jquery.js',
			'js/jquery-1.8.3.min.js',
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
			$this->load->view('v_joborderenquiry.php', $data);
		} else {
			$data['category_id'] = $this->uri->segment(3);
			$this->load->view('v_joborderenquiry.php', $data);
		}
	}
	function jobenquirySelectdatas($category_id = null)
	{
		$itemgroupdata_arr = array();
		$supplierdata = '';
		$itemgroupdata = '';
		$uomsdata = '';
		$shadesdata = '';
		$lotsdata = '';
		$shades = $this->m_masters->getactiveCdatas('bud_shades', 'shade_status', 'shade_category', $category_id);
		$custmers = $this->m_masters->getactiveCdatas('bud_customers', 'cust_status', 'cust_category', $category_id);
		$itemuoms = $this->m_masters->getactiveCdatas('bud_uoms', 'uom_status', 'uom_category', $category_id);
		foreach ($custmers as $custmer) {
			$cust_id = $custmer['cust_id'];
			$cust_name = $custmer['cust_name'];
			$supplierdata .= '<option value="' . $cust_id . '">' . $cust_name . '</option>';
		}
		$itemgroupdata_arr[] = $supplierdata;
		foreach ($itemuoms as $itemuom) {
			$uom_id = $itemuom['uom_id'];
			$uom_name = $itemuom['uom_name'];
			$uomsdata .= '<option value="' . $uom_id . '">' . $uom_name . '</option>';
		}
		$itemgroupdata_arr[] = $uomsdata;
		$itemgroups = $this->m_masters->getactiveCdatas('bud_itemgroups', 'group_status', 'group_category', $category_id);
		$itemgroupdata .= '<option value="">Select Group</option>';
		foreach ($itemgroups as $itemgroup) {
			$group_id = $itemgroup['group_id'];
			$group_name = $itemgroup['group_name'];
			$itemgroupdata .= '<option value="' . $group_id . '">' . $group_name . '</option>';
		}
		$itemgroupdata_arr[] = $itemgroupdata;
		foreach ($shades as $shade) {
			$shade_id = $shade['shade_id'];
			$shade_name = $shade['shade_name'];
			$shade_code = $shade['shade_code'];
			$shadesdata .= '<option value="' . $shade_id . '">' . $shade_name . ' / ' . $shade_code . '</option>';
		}
		$itemgroupdata_arr[] = $shadesdata;
		$lots = $this->m_masters->getactiveCdatas('bud_lots', 'lot_status', 'category', $category_id);
		foreach ($lots as $lot) {
			$lot_id = $lot['lot_id'];
			$lot_no = $lot['lot_no'];
			$lotsdata .= '<option value="' . $lot_id . '">' . $lot_no . '</option>';
		}
		$itemgroupdata_arr[] = $lotsdata;
		echo implode(",", $itemgroupdata_arr);
	}
	function addenquiryItem()
	{
		$enq_category = $this->input->post('enq_category');
		$enq_date = $this->input->post('enq_date');
		$enq_supplier = $this->input->post('enq_supplier');
		$enq_itemgroup = $this->input->post('enq_itemgroup');
		$enq_item = $this->input->post('enq_item');
		$enq_itemcolor = $this->input->post('enq_itemcolor');
		$enq_itemuom = $this->input->post('enq_itemuom');
		$enq_required_qty = $this->input->post('enq_required_qty');

		$cartdata = array(
			'id'      => $enq_item,
			'enq_category' => $enq_category,
			'enq_date' => $enq_date,
			'enq_supplier' => $enq_supplier,
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
		$enq_contact_person = $this->input->post('enq_contact_person');
		$enq_marketing_staff = $this->input->post('enq_marketing_staff');
		$enq_mobile_no = $this->input->post('enq_mobile_no');
		$enq_email = $this->input->post('enq_email');
		$enq_remarks = $this->input->post('enq_remarks');
		$ed = explode("-", $enq_date);
		$enq_date = $ed[2] . '-' . $ed[1] . '-' . $ed[0];
		$enquiryData = array(
			'enq_category' => $enq_category,
			'enq_date' => $enq_date,
			'enq_customer' => $enq_customer,
			'enq_contact_person' => $enq_contact_person,
			'enq_marketing_staff' => $enq_marketing_staff,
			'enq_mobile_no' => $enq_mobile_no,
			'enq_email' => $enq_email,
			'enq_remarks' => $enq_remarks
		);
		$enq_ref_id = $this->m_purchase->saveDatas('bud_joborder_enquiries', $enquiryData);
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
				$this->m_purchase->saveDatas('bud_joborder_items', $itemData);
			}
		}
		if ($enq_ref_id) {
			$this->cart->destroy();
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "productions/enquiry", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "productions/enquiry", 'refresh');
		}
	}
	function newquotation()
	{
		$enq_id = $this->uri->segment(3);
		$data['activeTab'] = 'purchase';
		$data['activeItem'] = 'newquotation';
		$data['page_title'] = 'New Quotation';
		$data['enquiries'] = $this->m_purchase->getDatas('bud_joborder_enquiries', 'enq_id', $enq_id);
		$data['items'] = $this->m_purchase->getDatas('bud_joborder_items', 'enq_ref_id', $enq_id);
		$data['css'] = array('css/bootstrap.min.css', 'css/bootstrap-reset.css', 'assets/font-awesome/css/font-awesome.css', 'assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css', 'css/owl.carousel.css', 'css/style.css', 'css/style-responsive.css', 'assets/bootstrap-datepicker/css/datepicker.css');
		$data['js_IE'] = array('js/html5shiv.js', 'js/respond.min.js');
		$data['js'] = array(
			'js/jquery.js',
			'js/jquery-1.8.3.min.js',
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
			$this->load->view('v_newjoborderquote.php', $data);
		} else {
			$this->load->view('v_newjoborderquote.php', $data);
		}
	}
	function savequotation()
	{
		$quote_date = $this->input->post('quote_date');
		$quote_enq_id = $this->input->post('quote_enq_id');
		$quote_category = $this->input->post('quote_category');
		$quote_customer = $this->input->post('quote_customer');
		$quote_contact_person = $this->input->post('quote_contact_person');
		$quote_marketing_staff = $this->input->post('quote_marketing_staff');
		$quote_mobile_no = $this->input->post('quote_mobile_no');
		$quote_email = $this->input->post('quote_email');
		$quote_remarks = $this->input->post('quote_remarks');
		$enq_item_rates = $this->input->post('enq_item_rate');
		$qd = explode("-", $quote_date);
		$quote_date = $qd[2] . '-' . $qd[1] . '-' . $qd[0];
		$quoteData = array(
			'quote_enq_id' => $quote_enq_id,
			'quote_category' => $quote_category,
			'quote_date' => $quote_date,
			'quote_customer' => $quote_customer,
			'quote_contact_person' => $quote_contact_person,
			'quote_marketing_staff' => $quote_marketing_staff,
			'quote_mobile_no' => $quote_mobile_no,
			'quote_email' => $quote_email,
			'quote_remarks' => $quote_remarks
		);
		$result = $this->m_purchase->saveDatas('bud_joborder_quotations', $quoteData);
		foreach ($enq_item_rates as $key => $value) {
			$updateData = array(
				'enq_item_rate' => $value
			);
			// $this->m_purchase->updatecartItem($key, $updateData);
			$this->m_purchase->updateDatas('bud_joborder_items', 'enq_item_id', $key, $updateData);
		}
		if ($result) {
			$removeEnquiry = array(
				'enq_status' => 0
			);
			$this->m_purchase->updateDatas('bud_joborder_enquiries', 'enq_id', $quote_enq_id, $removeEnquiry);
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "productions/quotations", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "productions/quotations", 'refresh');
		}
	}
	function quotations()
	{
		$data['activeTab'] = 'productions';
		$data['activeItem'] = 'quotations';
		$data['page_title'] = 'Quotations';
		$data['quotations'] = $this->m_purchase->getActivetableDatas('bud_joborder_quotations', 'quote_status');
		$data['css'] = array('css/bootstrap.min.css', 'css/bootstrap-reset.css', 'assets/font-awesome/css/font-awesome.css', 'assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css', 'css/owl.carousel.css', 'css/style.css', 'css/style-responsive.css', 'assets/bootstrap-datepicker/css/datepicker.css');
		$data['js_IE'] = array('js/html5shiv.js', 'js/respond.min.js');
		$data['js'] = array(
			'js/jquery.js',
			'js/jquery-1.8.3.min.js',
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
			$this->load->view('v_joborderquotations.php', $data);
		} else {
			$data['category_id'] = $this->uri->segment(3);
			$this->load->view('v_joborderquotations.php', $data);
		}
	}
	function newjobinward()
	{
		$enq_id = $this->uri->segment(3);
		$data['activeTab'] = 'productions';
		$data['activeItem'] = 'jobinwards';
		$data['page_title'] = 'Job Inward';
		$data['quotations'] = $this->m_purchase->getDatas('bud_joborder_quotations', 'quote_enq_id', $enq_id);
		$data['items'] = $this->m_purchase->getDatas('bud_joborder_items', 'enq_ref_id', $enq_id);
		$data['css'] = array('css/bootstrap.min.css', 'css/bootstrap-reset.css', 'assets/font-awesome/css/font-awesome.css', 'assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css', 'css/owl.carousel.css', 'css/style.css', 'css/style-responsive.css', 'assets/bootstrap-datepicker/css/datepicker.css');
		$data['js_IE'] = array('js/html5shiv.js', 'js/respond.min.js');
		$data['js'] = array(
			'js/jquery.js',
			'js/jquery-1.8.3.min.js',
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
			$this->load->view('v_newjobinward.php', $data);
		} else {
			$this->load->view('v_newjobinward.php', $data);
		}
	}
	function savejobinward()
	{
		$job_date = $this->input->post('job_date');
		$job_enq_id = $this->input->post('job_enq_id');
		$job_category = $this->input->post('job_category');
		$job_customer = $this->input->post('job_customer');
		$job_customer_po_no = $this->input->post('job_customer_po_no');
		$job_purpose = $this->input->post('job_purpose');
		$job_marketing_staff = $this->input->post('job_marketing_staff');
		$job_remarks = $this->input->post('job_remarks');
		$item_lot_no = $this->input->post('item_lot_no');
		$qd = explode("-", $job_date);
		$job_date = $qd[2] . '-' . $qd[1] . '-' . $qd[0];
		$quoteData = array(
			'job_enq_id' => $job_enq_id,
			'job_category' => $job_category,
			'job_date' => $job_date,
			'job_customer' => $job_customer,
			'job_customer_po_no' => $job_customer_po_no,
			'job_marketing_staff' => $job_marketing_staff,
			'job_purpose' => $job_purpose,
			'job_remarks' => $job_remarks
		);
		$result = $this->m_purchase->saveDatas('bud_jobinwards', $quoteData);
		foreach ($item_lot_no as $key => $value) {
			$updateData = array(
				'enq_lot_no' => $value
			);
			$this->m_purchase->updateDatas('bud_joborder_items', 'enq_item_id', $key, $updateData);
		}
		if ($result) {
			$removeQuotation = array(
				'quote_status' => 0
			);
			$this->m_purchase->updateDatas('bud_joborder_quotations', 'quote_enq_id', $job_enq_id, $removeQuotation);
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "productions/jobinwards", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "productions/jobinwards", 'refresh');
		}
	}
	function jobinwards()
	{
		$data['activeTab'] = 'productions';
		$data['activeItem'] = 'jobinwards';
		$data['page_title'] = 'Job Inwards';
		$data['jobinwards'] = $this->m_purchase->getActivetableDatas('bud_jobinwards', 'job_status');
		$data['css'] = array('css/bootstrap.min.css', 'css/bootstrap-reset.css', 'assets/font-awesome/css/font-awesome.css', 'assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css', 'css/owl.carousel.css', 'css/style.css', 'css/style-responsive.css', 'assets/bootstrap-datepicker/css/datepicker.css');
		$data['js_IE'] = array('js/html5shiv.js', 'js/respond.min.js');
		$data['js'] = array(
			'js/jquery.js',
			'js/jquery-1.8.3.min.js',
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
			$this->load->view('v_jobinwards.php', $data);
		} else {
			$data['category_id'] = $this->uri->segment(3);
			$this->load->view('v_jobinwards.php', $data);
		}
	}
	function jobcardentry()
	{
		$enq_id = $this->uri->segment(3);
		$data['activeTab'] = 'productions';
		$data['activeItem'] = 'jobcard';
		$data['page_title'] = 'Job Card Entry';
		$data['categories'] = $this->m_masters->getallcategories();
		$data['quotations'] = $this->m_purchase->getDatas('bud_joborder_quotations', 'quote_enq_id', $enq_id);
		$data['items'] = $this->m_purchase->getDatas('bud_joborder_items', 'enq_ref_id', $enq_id);
		$data['css'] = array('css/bootstrap.min.css', 'css/bootstrap-reset.css', 'assets/font-awesome/css/font-awesome.css', 'assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css', 'css/owl.carousel.css', 'css/style.css', 'css/style-responsive.css', 'assets/bootstrap-datepicker/css/datepicker.css');
		$data['js_IE'] = array('js/html5shiv.js', 'js/respond.min.js');
		$data['js'] = array(
			'js/jquery.js',
			'js/jquery-1.8.3.min.js',
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
			$this->load->view('v_newjobcard.php', $data);
		} else {
			$this->load->view('v_newjobcard.php', $data);
		}
	}

	function getcustomerjobinwards($customer_id = null)
	{
		$itemgroupdata_arr = array();
		$jobinwards_data = '';
		$jobinwards_data .= '<option value="">Select</option>';
		$jobinwards = $this->m_masters->getactiveCdatas('bud_jobinwards', 'job_status', 'job_customer', $customer_id);
		foreach ($jobinwards as $jobinward) {
			$job_enq_id = $jobinward['job_enq_id'];
			$job_id = $jobinward['job_id'];
			$jobinwards_data .= '<option value="' . $job_enq_id . '">' . $job_id . '</option>';
		}
		echo $jobinwards_data;
	}
	function joborderItems($job_inward_no = null)
	{
		$data['items'] = $this->m_purchase->getDatas('bud_joborder_items', 'enq_ref_id', $job_inward_no);
		$this->load->view('v_joborder_items.php', $data);
	}
	function savejobcard()
	{
		$jobcard_date = $this->input->post('job_date');
		$jobcard_category = $this->input->post('jobcard_category');
		$jobcard_customer = $this->input->post('jobcard_customer');
		$job_inward_no = $this->input->post('job_inward_no');
		$job_quantity = $this->input->post('job_quantity');
		$jobcard_remarks = $this->input->post('jobcard_remarks');
		$qd = explode("-", $jobcard_date);
		$jobcard_date = $qd[2] . '-' . $qd[1] . '-' . $qd[0];
		$jobcard_items = array();
		$jobcard_qty = array();
		foreach ($job_quantity as $key => $value) {
			$jobcard_items[] = $key;
			$jobcard_qty[] = $value;
		}
		$jobData = array(
			'jobcard_date' => $jobcard_date,
			'jobcard_category' => $jobcard_category,
			'jobcard_enq_id' => $job_inward_no,
			'jobcard_customer' => $jobcard_customer,
			'jobcard_items' => implode(",", $jobcard_items),
			'jobcard_qty' => implode(",", $jobcard_qty),
			'jobcard_remarks' => $jobcard_remarks
		);
		$result = $this->m_purchase->saveDatas('bud_jobcards', $jobData);

		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "productions/jobcardentry", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "productions/jobcardentry", 'refresh');
		}
	}
	function processcardentry()
	{
		$enq_id = $this->uri->segment(3);
		$data['activeTab'] = 'productions';
		$data['activeItem'] = 'processcardentry';
		$data['page_title'] = 'Process Card Entry';
		$data['categories'] = $this->m_masters->getallcategories();
		$data['quotations'] = $this->m_purchase->getDatas('bud_joborder_quotations', 'quote_enq_id', $enq_id);
		$data['items'] = $this->m_purchase->getDatas('bud_joborder_items', 'enq_ref_id', $enq_id);
		$data['css'] = array('css/bootstrap.min.css', 'css/bootstrap-reset.css', 'assets/font-awesome/css/font-awesome.css', 'assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css', 'css/owl.carousel.css', 'css/style.css', 'css/style-responsive.css', 'assets/bootstrap-datepicker/css/datepicker.css');
		$data['js_IE'] = array('js/html5shiv.js', 'js/respond.min.js');
		$data['js'] = array(
			'js/jquery.js',
			'js/jquery-1.8.3.min.js',
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
			$this->load->view('v_newprocesscard.php', $data);
		} else {
			$this->load->view('v_newprocesscard.php', $data);
		}
	}
	function getcustomerjobcards($customer_id = null)
	{
		$itemgroupdata_arr = array();
		$jobcards_data = '';
		$jobcards_data .= '<option value="">Select</option>';
		$jobcards = $this->m_masters->getactiveCdatas('bud_jobcards', 'jobcard_status', 'jobcard_customer', $customer_id);
		// print_r($jobcards);
		foreach ($jobcards as $jobcard) {
			$jobcard_id = $jobcard['jobcard_id'];
			$jobcard_enq_id = $jobcard['jobcard_enq_id'];
			$jobcards_data .= '<option value="' . $jobcard_enq_id . '">' . $jobcard_id . '</option>';
		}
		echo $jobcards_data;
	}
	function getjobcarditems($enq_ref_id = null)
	{
		$itemgroupdata_arr = array();
		$jobcards_items = '';
		$jobcards_items .= '<option value="">Select</option>';
		$items = $this->m_masters->getactiveCdatas('bud_joborder_items', 'enq_production_status', 'enq_ref_id', $enq_ref_id);
		// print_r($items);
		foreach ($items as $item) {
			$enq_item_id = $item['enq_item_id'];
			$enq_item = $item['enq_item'];
			$item_name = $this->m_masters->getmasterIDvalue('bud_items', 'item_id', $item['enq_item'], 'item_name');
			$item_color = $this->m_masters->getmasterIDvalue('bud_shades', 'shade_id', $item['enq_itemcolor'], 'shade_name');
			$jobcards_items .= '<option value="' . $enq_item_id . '">' . $item_name . ' / ' . $item_color . '</option>';
		}
		echo $jobcards_items;
	}
	function jobcarditemDetails($enq_item_id = null)
	{
		$itemsData = array();
		$items = $this->m_masters->getactiveCdatas('bud_joborder_items', 'enq_production_status', 'enq_item_id', $enq_item_id);
		// print_r($items);
		foreach ($items as $item) {
			$itemsData[] = $this->m_masters->getmasterIDvalue('bud_shades', 'shade_id', $item['enq_itemcolor'], 'shade_name');
			$itemsData[] = $this->m_masters->getmasterIDvalue('bud_lots', 'lot_id', $item['enq_lot_no'], 'lot_no');
			$itemsData[] = $item['enq_required_qty'] - $item['enq_production_qty'];
		}
		echo implode(",", $itemsData);
	}
	function saveprocesscard()
	{
		$process_date = $this->input->post('process_date');
		$jobcard_category = $this->input->post('jobcard_category');
		$jobcard_customer = $this->input->post('jobcard_customer');
		$job_card_no = $this->input->post('job_card_no');
		$job_card_item = $this->input->post('job_card_item');
		$jobcard_prod_qty = $this->input->post('jobcard_prod_qty');
		$qd = explode("-", $process_date);
		$process_date = $qd[2] . '-' . $qd[1] . '-' . $qd[0];
		$processData = array(
			'process_date' => $process_date,
			'process_enq_id' => $job_card_no,
			'process_category' => $jobcard_category,
			'process_customer' => $jobcard_customer,
			'process_item' => $job_card_item,
			'process_qty' => $jobcard_prod_qty
		);

		$result = $this->m_purchase->saveDatas('bud_process_cards', $processData);
		if ($result) {
			$enq_production_qty = '';
			$joborder_items = $this->m_purchase->getDatas('bud_joborder_items', 'enq_item_id', $job_card_item);
			foreach ($joborder_items as $joborder_item) {
				$enq_production_qty = $joborder_item['enq_production_qty'];
				$enq_production_qty = $enq_production_qty + $jobcard_prod_qty;
			}
			$updateItem = array(
				'enq_production_qty' => $enq_production_qty,
			);
			$this->m_purchase->updateDatas('bud_joborder_items', 'enq_item_id', $job_card_item, $updateItem);
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "productions/processcardentry", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "productions/processcardentry", 'refresh');
		}
	}
	function packingentry()
	{
		$data['activeTab'] = 'productions';
		$data['activeItem'] = 'packingentry';
		$data['page_title'] = 'Packing';
		$data['categories'] = $this->m_masters->getallcategories();
		$data['deliveries'] = $this->m_purchase->getActivetableDatas('bud_deliveries', 'delivery_status');
		$data['css'] = array('css/bootstrap.min.css', 'css/bootstrap-reset.css', 'assets/font-awesome/css/font-awesome.css', 'assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css', 'css/owl.carousel.css', 'css/style.css', 'css/style-responsive.css', 'assets/bootstrap-datepicker/css/datepicker.css');
		$data['js_IE'] = array('js/html5shiv.js', 'js/respond.min.js');
		$data['js'] = array(
			'js/jquery.js',
			'js/jquery-1.8.3.min.js',
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
	function getProcessCards($customer_id = null)
	{
		$result_arr = array();
		$processcardsData = '';
		$processcardsData .= '<option value="">Select</option>';
		$itemsData = '';
		$itemsData .= '<option value="">Select</option>';
		$processcards = $this->m_purchase->getDatas('bud_process_cards', 'process_customer', $customer_id);
		foreach ($processcards as $processcard) {
			$process_id = $processcard['process_id'];
			$process_item = $processcard['process_item'];
			$enq_item_name = $this->m_masters->getmasterIDvalue('bud_items', 'item_id', $process_item, 'item_name');
			$processcardsData .= '<option value="' . $process_id . '">' . $process_id . '</option>';
			$itemsData .= '<option value="' . $process_item . '">' . $enq_item_name . '</option>';
		}
		$result_arr[] = $processcardsData;
		$result_arr[] = $itemsData;
		echo $processcardsData;
	}
	function getPackingItems($packing_process_card = null)
	{
		$result_arr = array();
		$processcards = $this->m_purchase->getDatas('bud_process_cards', 'process_id', $packing_process_card);
		foreach ($processcards as $processcard) {
			$process_item = $processcard['process_item'];
			$process_qty = $processcard['process_qty'];
			$enq_item = $this->m_masters->getmasterIDvalue('bud_joborder_items', 'enq_item_id', $process_item, 'enq_item');
			$enq_item_name = $this->m_masters->getmasterIDvalue('bud_items', 'item_id', $enq_item, 'item_name');
			// echo $process_item;
			$result_arr[] = $process_item;
			$result_arr[] = $enq_item_name;
			$result_arr[] = $process_qty;

			$joborder_items = $this->m_purchase->getDatas('bud_joborder_items', 'enq_item_id', $process_item);
			foreach ($joborder_items as $item) {
				$enq_required_qty = $item['enq_required_qty'];
				$enq_itemcolor = $item['enq_itemcolor'];
				$enq_lot_no = $item['enq_lot_no'];
				$color = $this->m_masters->getmasterIDvalue('bud_shades', 'shade_id', $enq_itemcolor, 'shade_name');
				$shade = $this->m_masters->getmasterIDvalue('bud_shades', 'shade_id', $enq_itemcolor, 'shade_code');
				$lot = $this->m_masters->getmasterIDvalue('bud_lots', 'lot_id', $enq_lot_no, 'lot_no');
				$result_arr[] = $enq_itemcolor;
				$result_arr[] = $color;
				$result_arr[] = $enq_itemcolor;
				$result_arr[] = $shade;
				$result_arr[] = $enq_lot_no;
				$result_arr[] = $lot;
				$result_arr[] = $enq_required_qty;
			}
		}
		echo implode(",", $result_arr);
	}
	function savepacking()
	{
		$packing_date = $this->input->post('packing_date');
		$packing_category = $this->input->post('packing_category');
		$customer_id = $this->input->post('customer_id');
		$packing_process_card = $this->input->post('packing_process_card');
		$box_item = $this->input->post('box_item');
		$box_itemcolor = $this->input->post('box_itemcolor');
		$box_itemshade = $this->input->post('box_itemshade');
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
			'box_processcard' => $packing_process_card,
			'box_item' => $box_item,
			'box_itemcolor' => $box_itemcolor,
			'box_itemshade' => $box_itemshade,
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
			redirect(base_url() . "productions/packingentry", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "productions/packingentry", 'refresh');
		}
	}
}
