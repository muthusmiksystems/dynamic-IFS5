<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class General extends CI_Controller
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
		$this->load->library('cart');

		if (!$this->session->userdata('logged_in')) {
			// Allow some methods?
			$allowed = array();
			if (!in_array($this->router->method, $allowed)) {
				redirect(base_url() . 'users/login', 'refresh');
			}
		}
	}
	function generalPartyMaster()
	{
		$data['activeTab'] = 'general';
		$data['activeItem'] = 'generalPartyMaster';
		$data['page_title'] = 'General Party Master';
		$data['customers'] = $this->m_masters->getallmaster('bud_general_customers');
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
			$this->load->view('v_general-party-master.php', $data);
		} else {
			$data['company_id'] = $this->uri->segment(3);
			$this->load->view('v_general-party-master.php', $data);
		}
	}
	function generalPartySave()
	{
		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';*/
		$company_id = $this->input->post('company_id');
		$company_name = $this->input->post('company_name');
		$company_address = $this->input->post('company_address');
		$is_active = $this->input->post('is_active');
		$contact_name = $this->input->post('contact_name');
		$mobile_no = $this->input->post('mobile_no');
		$email = $this->input->post('email');
		$designation = $this->input->post('designation');
		if ($company_id == '') {
			$compData = array(
				'company_name' => $company_name,
				'company_address' => $company_address,
				'is_active' => $is_active
			);
			$company_id_ref = $this->m_purchase->saveDatas('bud_general_customers', $compData);
			if ($company_id_ref) {
				foreach ($contact_name as $key => $value) {
					if ($value != '') {
						$conatcData = array(
							'company_id_ref' => $company_id_ref,
							'contact_name' => $value,
							'mobile_no' => $mobile_no[$key],
							'email_id' => $email[$key],
							'designation' => $designation[$key]
						);
						$this->m_purchase->saveDatas('bud_general_cust_contacts', $conatcData);
					}
				}
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "general/generalPartyMaster", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "general/generalPartyMaster", 'refresh');
			}
		} else {
			/*echo '<pre>';
			print_r($_POST);
			echo '</pre>';*/
			$contact_name_new = $this->input->post('contact_name_new');
			$mobile_no_new = $this->input->post('mobile_no_new');
			$email_new = $this->input->post('email_new');
			$designation_new = $this->input->post('designation_new');
			$compData = array(
				'company_name' => $company_name,
				'company_address' => $company_address,
				'is_active' => $is_active
			);
			$this->m_purchase->updateDatas('bud_general_customers', 'company_id', $company_id, $compData);
			foreach ($contact_name as $key => $value) {
				if ($value != '') {
					$conatcData = array(
						'company_id_ref' => $key,
						'contact_name' => $value,
						'mobile_no' => $mobile_no[$key],
						'email_id' => $email[$key],
						'designation' => $designation[$key]
					);
					$this->m_purchase->updateDatas('bud_general_cust_contacts', 'company_id_ref', $key, $conatcData);
				}
			}
			foreach ($contact_name_new as $key => $value) {
				if ($value != '') {
					$newconatcData = array(
						'company_id_ref' => $company_id,
						'contact_name' => $value,
						'mobile_no' => $mobile_no_new[$key],
						'email_id' => $email_new[$key],
						'designation' => $designation_new[$key]
					);
					$this->m_purchase->saveDatas('bud_general_cust_contacts', $newconatcData);
				}
			}
			$this->session->set_flashdata('success', 'Successfully Updated!!!');
			redirect(base_url() . "general/generalPartyMaster", 'refresh');
		}
	}
	function getItemImage($item_code = null)
	{
		$item_sample = $this->m_masters->getmasterIDvalue('bud_general_items', 'item_id', $item_code, 'item_sample');
		echo $item_sample;
	}
	function generalItemGroup()
	{
		$data['activeTab'] = 'general';
		$data['activeItem'] = 'generalItemGroup';
		$data['page_title'] = 'General Item Group';
		$data['itemgroups'] = $this->m_masters->getallmaster('bud_general_item_groups');
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
			$this->load->view('v_general-item-group.php', $data);
		} else {
			$data['group_id'] = $this->uri->segment(3);
			$this->load->view('v_general-item-group.php', $data);
		}
	}
	function generalItemGroupSave()
	{
		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';*/
		$group_id = $this->input->post('group_id');
		$group_name = $this->input->post('group_name');
		$is_active = $this->input->post('is_active');
		$formData = array(
			'group_name' => $group_name,
			'is_active' => $is_active
		);
		if ($group_id == '') {
			$result = $this->m_purchase->saveDatas('bud_general_item_groups', $formData);
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "general/generalItemGroup", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "general/generalItemGroup", 'refresh');
			}
		} else {
			$result = $this->m_purchase->updateDatas('bud_general_item_groups', 'group_id', $group_id, $formData);
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Updated!!!');
				redirect(base_url() . "general/generalItemGroup", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "general/generalItemGroup", 'refresh');
			}
		}
	}
	function generalItemMaster()
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_general_items'");
		$next = $next->row(0);
		$data['next_item'] = $next->Auto_increment;
		$data['activeTab'] = 'general';
		$data['activeItem'] = 'generalItemMaster';
		$data['page_title'] = 'General Item Master';
		$data['itemgroups'] = $this->m_masters->getactivemaster('bud_general_item_groups', 'is_active');
		$data['users'] = $this->m_masters->getactivemaster('bud_users', 'user_status');
		$data['concerns'] = $this->m_masters->getallmaster('bud_concern_master');
		$data['stockrooms'] = $this->m_masters->getallmaster('bud_stock_rooms');
		$data['items'] = $this->m_masters->getallmaster('bud_general_items');
		$data['categories'] = $this->m_masters->getallmaster('bud_general_item_category');
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
			$this->load->view('v_general-item-master.php', $data);
		} else {
			$data['item_id'] = $this->uri->segment(3);
			$data['duplicate'] = $this->uri->segment(4);
			$this->load->view('v_general-item-master.php', $data);
		}
	}
	function generalItemSave()
	{
		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';*/
		$item_sample = '';
		$item_id = $this->input->post('item_id');
		$group_name = $this->input->post('group_name');
		$item_name = $this->input->post('item_name');
		$item_remarks = $this->input->post('item_remarks');
		$is_active = $this->input->post('is_active');
		$item_categories = $this->input->post('item_categories');
		$opening_stock = $this->input->post('opening_stock');
		$concern_id = $this->input->post('concern_id');
		$stockroom_id = $this->input->post('stockroom_id');
		$custody_of = $this->input->post('custody_of');
		$duplicate = $this->input->post('duplicate');
		$old_item_sample = $this->input->post('old_item_sample');

		$config['upload_path'] = 'uploads/itemsamples/general/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']	= '16000';
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['overwrite'] = FALSE;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		$img_ext_chk = array('jpg', 'png', 'gif', 'jpeg');

		$formData = array(
			'group_name' => $group_name,
			'item_name' => $item_name,
			'item_remarks' => $item_remarks,
			'item_categories' => implode(",", $item_categories),
			'opening_stock' => $opening_stock,
			'concern_id' => $concern_id,
			'stockroom_id' => $stockroom_id,
			'custody_of' => $custody_of,
			'is_active' => $is_active
		);
		if ($item_id == '' || $duplicate == 'duplicate') {
			if (!$this->upload->do_upload('sample_file')) {
				$error = array('error' => $this->upload->display_errors());
			} else {
				$image = $this->upload->data();
				$item_sample = $image['file_name'];
			}
			$formData['item_sample'] = $item_sample;

			$result = $this->m_purchase->saveDatas('bud_general_items', $formData);
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "general/generalItemMaster", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "general/generalItemMaster", 'refresh');
			}
		} else {
			if (!$this->upload->do_upload('sample_file')) {
				$error = array('error' => $this->upload->display_errors());
			} else {
				if ($old_item_sample != '') {
					if (file_exists('uploads/itemsamples/general/' . $old_item_sample)) {
						unlink('uploads/itemsamples/general/' . $old_item_sample);
					}
				}
				$image = $this->upload->data();
				$item_sample = $image['file_name'];
				$formData['item_sample'] = $item_sample;
			}

			$result = $this->m_purchase->updateDatas('bud_general_items', 'item_id', $item_id, $formData);
			if ($result) {
				$this->session->set_flashdata('success', 'Successfully Updated!!!');
				redirect(base_url() . "general/generalItemMaster", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "general/generalItemMaster", 'refresh');
			}
		}
	}
	function generalDelivery()
	{
		$data['activeTab'] = 'general_others';
		$data['activeItem'] = 'generalDelivery';
		$data['page_title'] = 'General Delivery';
		$data['itemgroups'] = $this->m_masters->getactivemaster('bud_general_item_groups', 'is_active');
		$data['items'] = $this->m_masters->getallmaster('bud_general_items');
		$data['suppliers'] = $this->m_masters->getactivemaster('bud_general_customers', 'is_active');
		$data['uoms'] = $this->m_masters->getactivemaster('bud_uoms', 'uom_status');
		$data['general_dc'] = $this->m_general->getGeneralDc();
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
			$this->load->view('v_general-delivery.php', $data);
		} else {
			$data['item_id'] = $this->uri->segment(3);
			$this->load->view('v_general-delivery.php', $data);
		}
	}
	function getSupplierItemRate()
	{
		$price = 0.00;
		$item_name = $this->input->post('item_name');
		$supplier = $this->input->post('supplier');
		$item_rates = $this->m_general->getSupItemRate($supplier, $item_name);
		if ($item_rates) {
			$price = $item_rates['price'];
		}
		echo $price;
	}
	function generalDeliveryItems()
	{
		$this->load->view('v_general-delivery-items.php');
	}
	function addGeneralDCItem()
	{
		// $this->cart->destroy();
		$item_name = $this->input->post('item_name');
		$item_qty = $this->input->post('item_qty');
		$item_rate = $this->input->post('item_rate');
		$item_uom = $this->input->post('item_uom');
		$supplier = $this->input->post('supplier');
		$cartdata = array(
			'id'      => $item_name,
			'item_uom' => $item_uom,
			'supplier' => $supplier,
			'qty'     => $item_qty,
			'price'   => $item_rate,
			'name'    => $item_name
		);
		if (sizeof($this->cart->contents()) > 0) {
			foreach ($this->cart->contents() as $items) {
				if ($items['id'] == $item_name) {
					$quantity = $items['qty'] + $item_qty;
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
	function removeGeneralDCItem($row_id = null)
	{
		$updatecart = array(
			'rowid' => $row_id,
			'qty'   => 0
		);
		$this->cart->update($updatecart);
	}
	function generalDcGenerate()
	{
		$data['activeTab'] = 'general';
		$data['activeItem'] = 'generalDelivery';
		$data['page_title'] = 'General Delivery';
		$data['suppliers'] = $this->m_masters->getactivemaster('bud_general_customers', 'is_active');
		$data['concerns'] = $this->m_masters->getmasterdetailsconcernactive('bud_concern_master', 'module', $this->session->userdata('user_viewed'));
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
		$this->load->view('v_general-dc-generate.php', $data);
	}
	function generalDcSave()
	{
		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';*/
		$dc_items = array();
		$dc_item_suppliers = array();
		$dc_item_qty = array();
		$dc_item_uom = array();
		$dc_item_price = array();
		$dc_type = $this->input->post('dc_type');
		$dc_from = $this->input->post('dc_from');
		$dc_to = $this->input->post('dc_to');
		$item_descriptions = $this->input->post('item_descriptions');
		$gross_weights = $this->input->post('gross_weights');
		$net_weights = $this->input->post('net_weights');
		$dc_total_bundels = $this->input->post('dc_total_bundels');
		$dc_sent_through = $this->input->post('dc_sent_through');
		$dc_remarks = $this->input->post('dc_remarks');
		foreach ($this->cart->contents() as $items) {
			$dc_items[$items['id']] = $items['id'];
			$dc_item_suppliers[$items['id']] = $items['supplier'];
			$dc_item_qty[$items['id']] = $items['qty'];
			$dc_item_uom[$items['id']] = $items['item_uom'];
			$dc_item_price[$items['id']] = $items['price'];
			$supplier = $items['supplier'];
			$item_name = $items['id'];
			$item_rates = $this->m_general->getSupItemRate($supplier, $item_name);
			if ($item_rates) {
				if ($item_rates['price'] != $items['price']) {
					$itemRate = array(
						'date' => date("Y-m-d"),
						'item_id' => $items['id'],
						'general_party_id' => $supplier,
						'price' => $items['price'],
						'uom' => $items['item_uom'],
					);
					$this->m_purchase->saveDatas('bud_general_party_item_rates', $itemRate);
				}
			}
		}
		$formData = array(
			'dc_date_time' => date("Y-m-d H:i:s"),
			'dc_type' => $dc_type,
			'dc_from' => $dc_from,
			'dc_to' => $dc_to,
			'dc_items' => implode(",", $dc_items),
			'item_descriptions' => implode(",", $item_descriptions),
			'dc_item_suppliers' => implode(",", $dc_item_suppliers),
			'dc_item_qty' => implode(",", $dc_item_qty),
			'dc_item_uom' => implode(",", $dc_item_uom),
			'dc_item_price' => implode(",", $dc_item_price),
			'gross_weights' => implode(",", $gross_weights),
			'net_weights' => implode(",", $net_weights),
			'dc_total_bundels' => $dc_total_bundels,
			'dc_sent_through' => $dc_sent_through,
			'dc_remarks' => $dc_remarks,
			'dc_prepared_by' => $this->session->userdata('user_id'),
		);
		$result = $this->m_purchase->saveDatas('bud_general_deliveries', $formData);
		if ($result) {
			$this->cart->destroy();
			if ($dc_type == 1) {
				foreach ($dc_items as $key => $value) {
					$itemData = array(
						'delivery_id' => $result,
						'dc_supplier' => $dc_to,
						'item_id' => $value,
						'item_description' => $item_descriptions[$key],
						'item_qty' => $dc_item_qty[$key],
						'item_uom' => $dc_item_uom[$key],
						'in_or_out' => 0,
					);
					$this->m_purchase->saveDatas('bud_general_dc_returnable_items', $itemData);
				}
			}
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "general/generalDcView/" . $result, 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "general/generalDelivery", 'refresh');
		}
	}
	function generalDcView()
	{
		if ($this->uri->segment(3)) {
			$delivery_id = $this->uri->segment(3);
		} else {
			redirect(base_url() . "404", 'refresh');
		}
		$data['activeTab'] = 'general';
		$data['activeItem'] = 'generalDelivery';
		$data['page_title'] = 'General Delivery';
		$data['dc_details'] = $this->m_masters->getmasterdetails('bud_general_deliveries', 'delivery_id', $delivery_id);
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
		$data['print_css'] = array(
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
		$this->load->view('v_general-dc-view.php', $data);
	}
	function supGeneralDC($supplier = null)
	{
		$resultData = '<option value="">Select</option>';
		$result = $this->m_masters->getmasterdetails('bud_general_dc_returnable_items', 'dc_supplier', $supplier);
		$dc_nos = array();
		foreach ($result as $row) {
			$dc_nos[] = $row['delivery_id'];
		}
		$dc_nos = array_unique($dc_nos);
		foreach ($dc_nos as $key => $value) {
			$resultData .= '<option value="' . $value . '">' . $value . '</option>';
		}
		echo $resultData;
	}
	function getGeneralDCItems($dc_no = null)
	{
		$resultData = '<option value="">Select</option>';
		$result = $this->m_masters->getmasterdetails('bud_general_dc_returnable_items', 'delivery_id', $dc_no);
		$result = array_unique($result);
		foreach ($result as $row) {
			$item_name = $this->m_masters->getmasterIDvalue('bud_general_items', 'item_id', $row['item_id'], 'item_name');
			$resultData .= '<option value="' . $row['item_id'] . '">' . $item_name . '</option>';
		}
		echo $resultData;
	}
	function getGeneralDCItemQty()
	{
		$bal_qty = 0;
		$total_sent = 0;
		$total_receive = 0;
		$resultData = array();
		$item_name = $this->input->post('item_name');
		$supplier = $this->input->post('supplier');
		$dc_no = $this->input->post('dc_no');
		$result = $this->m_general->getGenItemBalQty($supplier, $dc_no, $item_name);
		foreach ($result as $row) {
			if ($row['in_or_out'] == 0) {
				$total_sent += $row['item_qty'];
			}
			if ($row['in_or_out'] == 1) {
				$total_receive += $row['item_qty'];
			}
		}
		$resultData[] = $total_sent;
		$resultData[] = $total_sent - $total_receive;
		$resultData[] = $this->m_masters->getmasterIDvalue('bud_general_items', 'item_id', $item_name, 'item_sample');
		echo implode(",", $resultData);
		// print_r($_POST);
	}
	function generalDeliveryInward()
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_general_delivery_inward'");
		$next = $next->row(0);
		$data['receipt_no'] = $next->Auto_increment;

		$data['activeTab'] = 'general_others';
		$data['activeItem'] = 'generalDeliveryInward';
		$data['page_title'] = 'General Delivery Inward';
		$data['suppliers'] = $this->m_masters->getactivemaster('bud_general_customers', 'is_active');
		$data['gen_deliveries'] = $this->m_masters->getallmaster('bud_general_deliveries');
		$data['items'] = $this->m_masters->getactivemaster('bud_general_items', 'is_active');
		$data['uoms'] = $this->m_masters->getactivemaster('bud_uoms', 'uom_status');
		$data['general_dc'] = $this->m_general->getGeneralDc();
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
		$data['print_css'] = array(
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
		$this->load->view('v_general-delivery-inward.php', $data);
	}
	function generalDcInwrdSave()
	{
		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';*/
		$supplier = $this->input->post('supplier');
		$dc_no = $this->input->post('dc_no');
		$item_name = $this->input->post('item_name');
		$item_uom = $this->input->post('item_uom');
		$total_qty_sent = $this->input->post('total_qty_sent');
		$received_qty = $this->input->post('received_qty');
		$balance_qty = $this->input->post('balance_qty');
		$packeges_recieved = $this->input->post('packeges_recieved');
		$remarks = $this->input->post('remarks');
		$formData = array(
			'date_time' => date("Y-m-d H:i:s"),
			'supplier' => $supplier,
			'dc_no' => $dc_no,
			'item_name' => $item_name,
			'item_uom' => $item_uom,
			'total_qty_sent' => $total_qty_sent,
			'received_qty' => $received_qty,
			'balance_qty' => $balance_qty,
			'packeges_recieved' => $packeges_recieved,
			'prepared_by' => $this->session->userdata('user_id'),
			'remarks' => $remarks
		);
		$result = $this->m_purchase->saveDatas('bud_general_delivery_inward', $formData);
		if ($result) {
			$inwardItemData = array(
				'delivery_id' => $dc_no,
				'dc_supplier' => $supplier,
				'item_id' => $item_name,
				'item_qty' => $received_qty,
				'item_uom' => $item_uom,
				'in_or_out' => 1
			);
			$this->m_purchase->saveDatas('bud_general_dc_returnable_items', $inwardItemData);
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "general/generalDcInwrdReceipt/" . $result, 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "general/generalDeliveryInward", 'refresh');
		}
	}
	function generalDcInwrdReceipt()
	{
		if ($this->uri->segment(3)) {
			$inward_id = $this->uri->segment(3);
		} else {
			redirect(base_url() . "404", 'refresh');
		}
		$data['activeTab'] = 'general';
		$data['activeItem'] = 'generalDeliveryInward';
		$data['page_title'] = 'General Delivery Inward Receipt';
		$data['inward_details'] = $this->m_masters->getmasterdetails('bud_general_delivery_inward', 'inward_id', $inward_id);
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
		$data['print_css'] = array(
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
		$this->load->view('v_general-dc-inwrd-receipt.php', $data);
	}
	function genStocktransItems()
	{
		$this->load->view('v_general-stocktrans-items');
	}
	function getGeneralStock()
	{
		$current_stock = 0;
		$item_id = $_POST['item_id'];
		$concern_id = $_POST['concern_id'];
		$stockroom_id = $_POST['stockroom_id'];
		$current_stock += $this->m_general->getOpeningStock($item_id, $concern_id, $stockroom_id);
		$result = $this->m_general->getCurrentStock($item_id, $concern_id, $stockroom_id);
		foreach ($result as $row) {
			$qty = $row['qty'];
			$type = $row['type'];
			if ($type == '+') {
				$current_stock += $qty;
			} else {
				$current_stock -= $qty;
			}
		}
		echo $current_stock;
	}
	function generalStockTransfer()
	{
		if ($this->uri->segment(3) == true) {
			$data['transfer_id'] = $this->uri->segment(3);
		}
		$data['activeTab'] = 'general';
		$data['activeItem'] = 'generalStockTransfer';
		$data['page_title'] = 'General Stock Transfer';
		$data['itemgroups'] = $this->m_masters->getactivemaster('bud_general_item_groups', 'is_active');
		$data['items'] = $this->m_masters->getallmaster('bud_general_items');
		$data['suppliers'] = $this->m_masters->getactivemaster('bud_general_customers', 'is_active');
		$data['uoms'] = $this->m_masters->getactivemaster('bud_uoms', 'uom_status');
		$data['concerns'] = $this->m_masters->getallmaster('bud_concern_master');
		$data['stockrooms'] = $this->m_masters->getallmaster('bud_stock_rooms');
		// $data['stockrooms'] = $this->m_general->getStockrooms($this->session->userdata('user_viewed'));
		$data['staffs'] = $this->m_masters->getactivemaster('bud_users', 'user_status');
		$data['peding_dc'] = $this->m_general->pendingTransferDc();
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
		$data['print_css'] = array(
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
		$this->load->view('v_general-stock-transfer.php', $data);
	}
	function StackTransDcGenerate()
	{
		$data['activeTab'] = 'general';
		$data['activeItem'] = 'generalStockTransfer';
		$data['page_title'] = 'Stock Transfer';
		$data['suppliers'] = $this->m_masters->getactivemaster('bud_general_customers', 'is_active');
		$data['staffs'] = $this->m_masters->getactivemaster('bud_users', 'user_status');
		$data['concerns'] = $this->m_masters->getallmaster('bud_concern_master');
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
		$this->load->view('v_general-stock-trans-generate.php', $data);
	}
	function generalStockTransSave()
	{
		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';*/
		$transfer_id = $this->input->post('transfer_id');
		$concern_id = $this->input->post('concern_id');
		$dc_to = $this->input->post('dc_to');
		$staff_name = $this->input->post('staff_name');
		$attn_to = $this->input->post('attn_to');
		$item_descriptions = $this->input->post('item_descriptions');
		$gross_weights = $this->input->post('gross_weights');
		$net_weights = $this->input->post('net_weights');
		$dc_total_bundels = $this->input->post('dc_total_bundels');
		$dc_sent_through = $this->input->post('dc_sent_through');
		$dc_remarks = $this->input->post('dc_remarks');
		$stockroom_id = $this->input->post('stockroom_id');

		$item_code = $this->input->post('item_code');
		$stockroom_id = $this->input->post('stockroom_id');
		$current_stock = $this->input->post('current_stock');
		$item_qty = $this->input->post('item_qty');
		$item_uom = $this->input->post('item_uom');

		$formData = array(
			'transfer_date' => date("Y-m-d H:i:s"),
			'transfer_from' => $concern_id,
			'from_stock_room' => $stockroom_id,
			'transfer_by' => $this->session->userdata('user_id'),
			'transfer_to' => $dc_to,
			'staff_name' => $staff_name,
			'attn_to' => $attn_to,
			'dc_total_bundels' => $dc_total_bundels,
			'dc_sent_through' => $dc_sent_through,
			'dc_remarks' => $dc_remarks
		);
		if ($item_qty <= $current_stock) {
			// print_r($formData);
			if ($transfer_id == '') {
				$transfer_id = $this->m_purchase->saveDatas('bud_general_stock_transfer', $formData);
				if ($transfer_id) {
					$transferItems = array(
						'transfer_id' => $transfer_id,
						'item_id' => $item_code,
						'item_qty' => $item_qty,
						'item_uom' => $item_uom,
						'gross_weight' => $gross_weights,
						'net_weight' => $net_weights
					);
					$this->m_purchase->saveDatas('bud_general_transfer_items', $transferItems);

					$this->session->set_flashdata('success', 'Successfully Saved!!!');
					redirect(base_url() . "general/generalStockTransDc/" . $transfer_id, 'refresh');
				} else {
					$this->session->set_flashdata('error', 'Enter Qty is less than the Stock');
					redirect(base_url() . "general/generalStockTransfer", 'refresh');
				}
			} else {
				$this->m_purchase->updateDatas('bud_general_stock_transfer', 'transfer_id', $transfer_id, $formData);
				$transferItems = array(
					'transfer_id' => $transfer_id,
					'item_id' => $item_code,
					'item_qty' => $item_qty,
					'item_uom' => $item_uom,
					'gross_weight' => $gross_weights,
					'net_weight' => $net_weights
				);
				$this->m_purchase->updateDatas('bud_general_transfer_items', 'transfer_id', $transfer_id, $transferItems);

				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "general/generalStockTransDc/" . $transfer_id, 'refresh');
			}
		} else {
			$this->session->set_flashdata('error', 'Enter Qty is less than the Stock');
			redirect(base_url() . "general/generalStockTransfer", 'refresh');
		}
	}
	function genStockTranDc_print()
	{
		if (isset($_POST['search'])) {
			$from_concern = $this->input->post('from_concern');
			$to_concern = $this->input->post('to_concern');
			$data['from_concern'] = $from_concern;
			$data['to_concern'] = $to_concern;
			$data['stock_trans_dc'] = $this->m_general->getstockTransDc($from_concern, $to_concern);
		} else {
			$data['stock_trans_dc'] = array();
			$data['from_concern'] = '';
			$data['to_concern'] = '';
		}
		$data['activeTab'] = 'general';
		$data['activeItem'] = 'generalStockTransfer';
		$data['page_title'] = 'General Stock Transfer';
		$data['concerns'] = $this->m_masters->getallmaster('bud_concern_master');
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
		$data['print_css'] = array(
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
		$this->load->view('v_general-stock-tran-print', $data);
	}
	function stockTranDc_print_view()
	{
		$data['from_concern'] = $this->input->post('from_concern');
		$data['to_concern'] = $this->input->post('to_concern');
		$data['selected_dc'] = $this->input->post('selected_dc');
		$data['activeTab'] = 'general';
		$data['activeItem'] = 'generalStockTransfer';
		$data['page_title'] = 'Stock Transfer DC';
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
		$data['print_css'] = array(
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
		$this->load->view('v_general-stock-trans-print-view', $data);
	}
	function generalStockTransDc()
	{
		if ($this->uri->segment(3)) {
			$transfer_id = $this->uri->segment(3);
		} else {
			redirect(base_url() . "404", 'refresh');
		}
		$data['activeTab'] = 'general';
		$data['activeItem'] = 'generalStockTransfer';
		$data['page_title'] = 'Stock Transfer DC';
		$data['transfer_details'] = $this->m_masters->getmasterdetails('bud_general_stock_transfer', 'transfer_id', $transfer_id);
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
		$data['print_css'] = array(
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
		$this->load->view('v_general-stock-trans-dc.php', $data);
	}

	function generalDcAcceptance()
	{
		$data['activeTab'] = 'general';
		$data['activeItem'] = 'generalDcAcceptance';
		$data['page_title'] = 'Dc Acceptance';
		$data['transfers'] = $this->m_masters->getactivemaster('bud_general_stock_transfer', 'status');
		$data['stockrooms'] = $this->m_masters->getallmaster('bud_stock_rooms');
		$data['peding_dc'] = $this->m_general->pendingTransferDc();
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
		$data['print_css'] = array(
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
			$data['transfer_id'] = $this->uri->segment(3);
			$data['transfer_details'] = $this->m_masters->getmasterdetails('bud_general_stock_transfer', 'transfer_id', $this->uri->segment(3));
			$this->load->view('v_general-dc-acceptance.php', $data);
		} else {
			$data['transfer_id'] = null;
			$this->load->view('v_general-pending-dc', $data);
		}
	}
	function generalDcAccepted()
	{
		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';*/
		$transfer_id = $this->input->post('transfer_id');
		$from_concern = $this->input->post('from_concern');
		$from_stock_room = $this->input->post('from_stock_room');
		$to_concern = $this->input->post('to_concern');
		$gr_wt_received = $this->input->post('gr_wt_received');
		$items = $this->input->post('items');
		$items_qty = $this->input->post('items_qty');
		$stock_room = $this->input->post('stock_room');
		$receiver_remarks = $this->input->post('receiver_remarks');
		foreach ($gr_wt_received as $key => $value) {
			$receivedData = array(
				'stock_room' => $stock_room[$key],
				'gross_wt_received' => $value
			);
			$this->m_purchase->updateDatas('bud_general_transfer_items', 'id', $key, $receivedData);
		}
		foreach ($items as $key => $value) {
			$inwardLog_1 = array(
				'concern_id' => $from_concern,
				'stockroom_id' => $from_stock_room,
				'item_id' => $value,
				'qty' => $items_qty[$key],
				'type' => '-',
			);
			$this->m_purchase->saveDatas('bud_material_inward_log', $inwardLog_1);
			$inwardLog_2 = array(
				'concern_id' => $to_concern,
				'stockroom_id' => $stock_room[$key],
				'item_id' => $value,
				'qty' => $items_qty[$key],
				'type' => '+',
			);
			$this->m_purchase->saveDatas('bud_material_inward_log', $inwardLog_2);
		}
		$transferData = array(
			'receiver_remarks' => $receiver_remarks,
			'accepted_date' => date("Y-m-d H:i:s"),
			'status' => 0
		);
		$result = $this->m_purchase->updateDatas('bud_general_stock_transfer', 'transfer_id', $transfer_id, $transferData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Updated!!!');
			redirect(base_url() . "general/generalDcAcceptance", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "general/generalDcAcceptance", 'refresh');
		}
	}
	function materialInward()
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_material_inward'");
		$next = $next->row(0);
		$data['next_inward_id'] = $next->Auto_increment;
		$data['activeTab'] = 'general';
		$data['activeItem'] = 'materialInward';
		$data['page_title'] = 'Material Inward';
		$data['inward_list'] = $this->m_general->materialInwarsList();
		$data['concerns'] = $this->m_masters->getallmaster('bud_concern_master');
		$data['items'] = $this->m_masters->getallmaster('bud_general_items');
		$data['suppliers'] = $this->m_masters->getactivemaster('bud_general_customers', 'is_active');
		$data['uoms'] = $this->m_masters->getactivemaster('bud_uoms', 'uom_status');
		$data['staffs'] = $this->m_masters->getactivemaster('bud_users', 'user_status');
		$data['stockrooms'] = $this->m_masters->getallmaster('bud_stock_rooms');
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
		$data['print_css'] = array(
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
		$this->load->view('v_general-meterial-inward.php', $data);
	}
	function materialInwardSave()
	{
		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';*/
		$concern_name = $this->input->post('concern_name');
		$item_name = $this->input->post('item_name');
		$item_code = $this->input->post('item_code');
		$supplier = $this->input->post('supplier');
		$item_rate = $this->input->post('item_rate');
		$item_qty = $this->input->post('item_qty');
		$item_uom = $this->input->post('item_uom');
		$party_boxno = $this->input->post('party_boxno');
		$dynamic_box_no = $this->input->post('dynamic_box_no');
		$stock_room = $this->input->post('stock_room');
		$remarks = $this->input->post('remarks');
		$given_to = $this->input->post('given_to');
		$formData = array(
			'inward_date' => date("Y-m-d H:i:s"),
			'concern_name' => $concern_name,
			'item_name' => $item_name,
			'supplier' => $supplier,
			'item_rate' => $item_rate,
			'item_qty' => $item_qty,
			'item_uom' => $item_uom,
			'party_boxno' => $party_boxno,
			'dynamic_box_no' => $dynamic_box_no,
			'given_to' => $given_to,
			'prepared_by' => $this->session->userdata('user_id'),
			'stock_room' => $stock_room,
			'remarks' => $remarks
		);
		$result = $this->m_purchase->saveDatas('bud_material_inward', $formData);
		if ($result) {
			$inwardLog = array(
				'concern_id' => $concern_name,
				'stockroom_id' => $stock_room,
				'item_id' => $item_name,
				'qty' => $item_qty,
				'type' => '+'
			);
			$this->m_purchase->saveDatas('bud_material_inward_log', $inwardLog);
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "general/materialInward", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "general/materialInward", 'refresh');
		}
	}
	function materialConsumption()
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_general_mtrl_consumption'");
		$next = $next->row(0);
		$data['next_id'] = $next->Auto_increment;
		$data['activeTab'] = 'general';
		$data['activeItem'] = 'materialConsumption';
		$data['page_title'] = 'Material Consumption';
		$data['inward_list'] = $this->m_general->materialInwarsList();
		$data['concerns'] = $this->m_masters->getallmaster('bud_concern_master');
		$data['items'] = $this->m_masters->getallmaster('bud_general_items');
		$data['stockrooms'] = $this->m_masters->getallmaster('bud_stock_rooms');
		$data['machines'] = $this->m_masters->getactivemaster('bud_te_machines', 'machine_status');
		$data['uoms'] = $this->m_masters->getactivemaster('bud_uoms', 'uom_status');
		$data['staffs'] = $this->m_masters->getactivemaster('bud_users', 'user_status');
		$data['mat_consumption'] = $this->m_general->materialComcemptionList();
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
		$data['print_css'] = array(
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
		$this->load->view('v_general-material-consumption.php', $data);
	}
	function save_materialConsumption()
	{
		/*echo "<pre>";
		print_r($_POST);
		echo "</pre>";*/
		// Enter Qty is less than the Stock
		$concern_name = $this->input->post('concern_name');
		$stockroom_id = $this->input->post('stockroom_id');
		$item_name = $this->input->post('item_name');
		$item_code = $this->input->post('item_code');
		$machines = $this->input->post('machines');
		$current_stock = $this->input->post('current_stock');
		$item_qty = $this->input->post('item_qty');
		$item_uom = $this->input->post('item_uom');
		$given_to = $this->input->post('given_to');
		$remarks = $this->input->post('remarks');
		$formData = array(
			'concern_name' => $concern_name,
			'stockroom_id' => $stockroom_id,
			'item_name' => $item_name,
			'machines' => $machines,
			'item_qty' => $item_qty,
			'item_uom' => $item_uom,
			'prepared_by' => $this->session->userdata('user_id'),
			'given_to' => $given_to,
			'remarks' => $remarks,
			'date_time' => date("Y-m-d H:i:s")
		);
		if ($item_qty > $current_stock) {
			$this->session->set_flashdata('error', 'Enter Qty is less than the Stock');
			redirect(base_url() . "general/materialConsumption", 'refresh');
		} else {
			$result = $this->m_purchase->saveDatas('bud_general_mtrl_consumption', $formData);
			if ($result) {
				$inwardLog_1 = array(
					'concern_id' => $concern_name,
					'stockroom_id' => $stockroom_id,
					'item_id' => $item_name,
					'qty' => $item_qty,
					'type' => '-',
				);
				$this->m_purchase->saveDatas('bud_material_inward_log', $inwardLog_1);

				$this->session->set_flashdata('success', 'Successfully Saved!!!');
				redirect(base_url() . "general/materialConsumption", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'That action is not valid, please try again');
				redirect(base_url() . "general/materialConsumption", 'refresh');
			}
		}
	}
	function stock_transfer_store()
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_material_inward'");
		$next = $next->row(0);
		$data['next_inward_id'] = $next->Auto_increment;
		$data['activeTab'] = 'general';
		$data['activeItem'] = 'stock_transfer_store';
		$data['page_title'] = 'Stock Transfer With in Store';
		$data['inward_list'] = $this->m_general->materialInwarsList();
		$data['concerns'] = $this->m_masters->getallmaster('bud_concern_master');
		$data['items'] = $this->m_masters->getallmaster('bud_general_items');
		$data['suppliers'] = $this->m_masters->getactivemaster('bud_general_customers', 'is_active');
		$data['uoms'] = $this->m_masters->getactivemaster('bud_uoms', 'uom_status');
		$data['staffs'] = $this->m_masters->getactivemaster('bud_users', 'user_status');
		$data['stockrooms'] = $this->m_masters->getactivemaster('bud_stock_rooms', 'stock_room_status');
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
		$data['print_css'] = array(
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
		$this->load->view('v_general-stock-trans-store', $data);
	}
	function stock_tran_store_save()
	{
		/*echo "<pre>";
		print_r($_POST);
		echo "</pre>";*/
		$staff_id = $this->input->post('staff_id');
		$stock_room = $this->input->post('stock_room');
		$remarks = $this->input->post('remarks');
		$concern_name = $this->input->post('concern_name');
		$selectedrows = $this->input->post('selectedrows');
		foreach ($selectedrows as $key => $value) {
			$transferData = array(
				'given_to' => $staff_id,
				'stock_room' => $stock_room,
				// 'concern_name' => $concern_name, 
				'remarks' => $remarks,
				'last_transfer_datetime' => date("Y-m-d H:i:s")
			);
			$this->m_purchase->updateDatas('bud_material_inward', 'inward_id', $key, $transferData);
		}
		$this->session->set_flashdata('success', 'Make sure you shift the stock to the new place. Here after stock will shown in the new place only.');
		redirect(base_url() . "general/stock_transfer_store", 'refresh');
	}
	function IOweYou()
	{
		$data['activeTab'] = 'general';
		$data['activeItem'] = 'IOweYou';
		$data['page_title'] = 'I Owe You Form';
		$data['concerns'] = $this->m_masters->getallmaster('bud_concern_master');
		$data['items'] = $this->m_masters->getallmaster('bud_general_items');
		$data['suppliers'] = $this->m_masters->getactivemaster('bud_general_customers', 'is_active');
		$data['uoms'] = $this->m_masters->getactivemaster('bud_uoms', 'uom_status');
		$data['staffs'] = $this->m_masters->getactivemaster('bud_users', 'user_status');
		$data['iou'] = $this->m_masters->getactivemaster('bud_general_iou', 'status');
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
		$data['print_css'] = array(
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
		$this->load->view('v_general-iowe-you.php', $data);
	}
	function IOweYouSave()
	{
		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';*/
		$concern_name = $this->input->post('concern_name');
		$given_from = $this->input->post('given_from');
		$given_to = $this->input->post('given_to');
		$itemnames = $this->input->post('itemnames');
		$qty_required = $this->input->post('qty_required');
		$amt_required = $this->input->post('amt_required');
		$formData = array(
			'date_time' => date("Y-m-d H:i:s"),
			'concern_name' => $concern_name,
			'given_from' => $given_from,
			'given_to' => $given_to
		);
		$iou_voucher_id = $this->m_purchase->saveDatas('bud_general_iou', $formData);
		if ($iou_voucher_id) {
			foreach ($itemnames as $key => $value) {
				if ($value != '') {
					$itemsArray = array(
						'iou_voucher_id' => $iou_voucher_id,
						'item_name' => $value,
						'qty_required' => $qty_required[$key],
						'amt_required' => $amt_required[$key]
					);
					$this->m_purchase->saveDatas('bud_general_iou_items', $itemsArray);
				}
			}
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "general/IOweYou", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "general/IOweYou", 'refresh');
		}
	}
}
