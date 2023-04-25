<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sales extends CI_Controller
{
	var $item_id = false;
	function __construct()
	{
		parent::__construct();
		$this->load->model('Packing_model');
		$this->load->model('Stocktrans_model');
		$this->load->model('Predelivery_model');
		$this->load->model('Delivery_model');
		$this->load->model('Sales_model');
		$this->load->model('m_masters');
		$this->load->model('m_users');
		$this->load->model('m_mir'); //ER-07-18#-17
		$this->load->model('m_purchase'); //ER-07-18#-22
		if (!$this->session->userdata('logged_in')) {
			// Allow some methods?
			$allowed = array();
			if (!in_array($this->router->method, $allowed)) {
				redirect(base_url() . 'users/login', 'refresh');
			}
		}
	}

	public function item_rates_data()
	{
		$response = array();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('customer_id', 'Customer Name', 'required');
		$this->form_validation->set_rules('item_id', 'Item Name', 'required');
		$this->form_validation->set_rules('shade_id', 'Shade Name', 'required');
		if ($this->form_validation->run() == FALSE) {
			$response['error'] = validation_errors();
		} else {
			$customer_id = $this->input->post('customer_id');
			$item_id = $this->input->post('item_id');
			$shade_id = $this->input->post('shade_id');
			$data['item_rates'] = $this->Sales_model->get_item_rates($customer_id, $item_id, $shade_id);
			$this->load->view('includes/item-rates-data', $data);
		}
	}

	public function rate_master()
	{
		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'rate_master';
		$data['page_title'] = 'Shop Rate Master';
		$data['items'] = $this->Stocktrans_model->get_items();
		$data['shades'] = $this->Stocktrans_model->get_shades();
		$data['customers'] = $this->Predelivery_model->get_customers();
		$data['rate_list'] = $this->Sales_model->get_rate_master_list();
		$this->load->view('rate-master-form', $data);
	}

	public function rate_master_save()
	{
		/*echo "<pre>";
		print_r($_POST);
		echo "</pre>";*/

		$response = array();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('customer_id', 'Customer Name', 'required');
		$this->form_validation->set_rules('item_id', 'Item Name', 'required');
		$this->form_validation->set_rules('shade_id', 'Shade Name', 'required');
		if ($this->form_validation->run() == FALSE) {
			$response['error'] = validation_errors();
		} else {
			$save['rate_id'] = $this->input->post('rate_id');
			$save['customer_id'] = $this->input->post('customer_id');
			$save['item_id'] = $this->input->post('item_id');
			$save['shade_id'] = $this->input->post('shade_id');
			$save['item_rate_active'] = $this->input->post('item_rate_active');
			$save['item_rates'] = implode(",", $this->input->post('item_rates'));
			$save['rate_changed_by'] = implode(",", $this->input->post('rate_changed_by'));
			$save['rate_changed_on'] = implode(",", $this->input->post('rate_changed_on'));
			$save['description'] = implode(",", $this->input->post('description'));
			$this->Sales_model->save_rate_master($save);
			$response['success'] = 'Successfully Saved';
		}
		echo json_encode($response);
	}

	// General Rate Master
	public function gen_item_rates_data()
	{
		$response = array();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('item_id', 'Item Name', 'required');
		$this->form_validation->set_rules('category_id', 'Color Category', 'required');
		if ($this->form_validation->run() == FALSE) {
			$response['error'] = validation_errors();
		} else {
			$item_id = $this->input->post('item_id');
			$category_id = $this->input->post('category_id');
			$data['item_rates'] = $this->Sales_model->get_gen_item_rates($item_id, $category_id);
			$this->load->view('includes/gen-item-rates-data', $data);
		}
	}
	public function general_rate_master()
	{
		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'general_rate_master';
		$data['page_title'] = 'Shop General Rate Master';
		$data['items'] = $this->Stocktrans_model->get_items();
		// $data['shades'] = $this->Stocktrans_model->get_shades();
		$data['customers'] = $this->Predelivery_model->get_customers();
		$data['color_categories'] = $this->m_masters->get_color_categories();
		$data['rate_list'] = $this->Sales_model->get_gen_rate_master_list();
		$this->load->view('general-rate-master-form', $data);
	}
	public function gen_rate_master_save()
	{
		$response = array();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('item_id', 'Item Name', 'required');
		$this->form_validation->set_rules('category_id', 'Color Category', 'required');
		if ($this->form_validation->run() == FALSE) {
			$response['error'] = validation_errors();
		} else {
			$rate_id = $this->input->post('rate_id');
			$item_id = $this->input->post('item_id');
			$category_id = $this->input->post('category_id');
			$item_rate = $this->input->post('item_rate');
			$qty_from = $this->input->post('qty_from');
			$qty_to = $this->input->post('qty_to');
			$item_rates = array();
			if (count($item_rate) > 0) {
				foreach ($item_rate as $key => $value) {
					$item_data['rate_id'] = '';
					$item_data['item_id'] = $item_id;
					$item_data['category_id'] = $category_id;
					$item_data['qty_from'] = (isset($qty_from[$key])) ? $qty_from[$key] : 0;
					$item_data['qty_to'] = (isset($qty_to[$key])) ? $qty_to[$key] : 0;
					$item_data['item_rate'] = $value;
					$item_rates[] = $item_data;
				}
			}
			$this->Sales_model->clear_gen_rate_master($item_id, $category_id);
			$this->Sales_model->save_gen_rate_master($item_rates);
			$response['success'] = 'Successfully Saved';
		}
		echo json_encode($response);
	}

	public function get_cash_receipt_no($receipt_id = '')
	{
		if ($receipt_id) {
			echo $receipt_id;
		} else {
			$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_sh_cash_receipts'");
			$next = $next->row(0);
			$receipt_no = $next->Auto_increment;
			echo $receipt_no;
		}
	}
	public function cash_receipt()
	{
		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'cash_receipt';
		$data['page_title'] = 'Shop Cash Receipt';
		$data['concerns'] = $this->Stocktrans_model->get_concerns();
		$data['customers'] = $this->Predelivery_model->get_customers();
		$data['receipt_list'] = $this->Sales_model->get_cash_receipt_list();
		$this->load->view('cash-receipt-form', $data);
	}
	public function cash_receipt_save($receipt_id = '')
	{
		$response = array();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('concern_id', 'Concern Name', 'required');
		$this->form_validation->set_rules('customer_id', 'Party Name', 'required');
		$this->form_validation->set_rules('mobile_no', 'Mobile No', 'numeric');
		$this->form_validation->set_rules('amount', 'Amount', 'required|numeric');

		if ($this->form_validation->run() == FALSE) {
			$response['error'] = validation_errors();
		} else {
			if ($receipt_id) {
				$save['receipt_id'] = $receipt_id;
			} else {
				$save['receipt_id'] = '';
			}
			$save['receipt_date'] = date("Y-m-d H:i:s");
			$save['concern_id'] = $this->input->post('concern_id');
			$save['customer_id'] = $this->input->post('customer_id');
			$save['name'] = $this->input->post('name');
			$save['mobile_no'] = $this->input->post('mobile_no');
			$save['amount'] = $this->input->post('amount');
			$save['purpose'] = $this->input->post('purpose');
			$save['received_by'] = $this->session->userdata('user_id');

			$receipt_id = $this->Sales_model->save_cash_receipt($save);
			$response['receipt_id'] = $receipt_id;
		}
		echo json_encode($response);
	}
	public function print_cash_receipt($receipt_id = '')
	{
		if (!empty($receipt_id)) {
			$data['activeTab'] = 'shop';
			$data['activeItem'] = 'print_cash_receipt';
			$data['page_title'] = 'Shop Cash Receipt';
			$data['receipt'] = $this->Sales_model->get_cash_receipt($receipt_id);
			$this->load->view('print-cash-receipt', $data);
		} else {
			redirect(base_url('shop/sales/cash_receipt'));
		}
	}

	// Credit Note
	public function get_credit_receipt_no($receipt_id = '')
	{
		if ($receipt_id) {
			echo $receipt_id;
		} else {
			$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_sh_credit_receipts'");
			$next = $next->row(0);
			$receipt_no = $next->Auto_increment;
			echo $receipt_no;
		}
	}
	public function credit_receipt()
	{
		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'credit_receipt';
		$data['page_title'] = 'Shop Cash Receipt';
		$data['concerns'] = $this->Stocktrans_model->get_concerns();
		$data['customers'] = $this->Predelivery_model->get_customers();
		$data['receipt_list'] = $this->Sales_model->get_credit_receipt_list();
		$this->load->view('credit-receipt-form', $data);
	}
	public function credit_receipt_save($receipt_id = '')
	{
		$response = array();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('concern_id', 'Concern Name', 'required');
		$this->form_validation->set_rules('customer_id', 'Party Name', 'required');
		$this->form_validation->set_rules('mobile_no', 'Mobile No', 'numeric');
		$this->form_validation->set_rules('amount', 'Amount', 'required|numeric');

		if ($this->form_validation->run() == FALSE) {
			$response['error'] = validation_errors();
		} else {
			if ($receipt_id) {
				$save['receipt_id'] = $receipt_id;
			} else {
				$save['receipt_id'] = '';
			}
			$save['receipt_date'] = date("Y-m-d H:i:s");
			$save['concern_id'] = $this->input->post('concern_id');
			$save['customer_id'] = $this->input->post('customer_id');
			$save['name'] = $this->input->post('name');
			$save['mobile_no'] = $this->input->post('mobile_no');
			$save['amount'] = $this->input->post('amount');
			$save['purpose'] = $this->input->post('purpose');
			$save['received_by'] = $this->session->userdata('user_id');

			$receipt_id = $this->Sales_model->save_credit_receipt($save);
			$response['receipt_id'] = $receipt_id;
		}
		echo json_encode($response);
	}
	public function print_credit_receipt($receipt_id = '')
	{
		if (!empty($receipt_id)) {
			$data['activeTab'] = 'shop';
			$data['activeItem'] = 'print_cash_receipt';
			$data['page_title'] = 'Shop Cash Receipt';
			$data['receipt'] = $this->Sales_model->get_credit_receipt($receipt_id);
			$this->load->view('print-cheque-receipt', $data);
		} else {
			redirect(base_url('shop/sales/credit_receipt'));
		}
	}

	// Debit Note
	public function get_debit_receipt_no($receipt_id = '')
	{
		if ($receipt_id) {
			echo $receipt_id;
		} else {
			$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_sh_debit_receipts'");
			$next = $next->row(0);
			$receipt_no = $next->Auto_increment;
			echo $receipt_no;
		}
	}
	public function debit_receipt()
	{
		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'debit_receipt';
		$data['page_title'] = 'Shop Cash Receipt';
		$data['concerns'] = $this->Stocktrans_model->get_concerns();
		$data['customers'] = $this->Predelivery_model->get_customers();
		$data['receipt_list'] = $this->Sales_model->get_debit_receipt_list();
		$this->load->view('debit-receipt-form', $data);
	}
	public function debit_receipt_save($receipt_id = '')
	{
		$response = array();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('concern_id', 'Concern Name', 'required');
		$this->form_validation->set_rules('customer_id', 'Party Name', 'required');
		$this->form_validation->set_rules('mobile_no', 'Mobile No', 'numeric');
		$this->form_validation->set_rules('amount', 'Amount', 'required|numeric');

		if ($this->form_validation->run() == FALSE) {
			$response['error'] = validation_errors();
		} else {
			if ($receipt_id) {
				$save['receipt_id'] = $receipt_id;
			} else {
				$save['receipt_id'] = '';
			}
			$save['receipt_date'] = date("Y-m-d H:i:s");
			$save['concern_id'] = $this->input->post('concern_id');
			$save['customer_id'] = $this->input->post('customer_id');
			$save['name'] = $this->input->post('name');
			$save['mobile_no'] = $this->input->post('mobile_no');
			$save['amount'] = $this->input->post('amount');
			$save['purpose'] = $this->input->post('purpose');
			$save['received_by'] = $this->session->userdata('user_id');

			$receipt_id = $this->Sales_model->save_debit_receipt($save);
			$response['receipt_id'] = $receipt_id;
		}
		echo json_encode($response);
	}
	public function print_debit_receipt($receipt_id = '')
	{
		if (!empty($receipt_id)) {
			$data['activeTab'] = 'shop';
			$data['activeItem'] = 'debit_receipt';
			$data['page_title'] = 'Shop Discount Receipt';
			$data['receipt'] = $this->Sales_model->get_credit_receipt($receipt_id);
			$this->load->view('print-disc-voucher', $data);
		} else {
			redirect(base_url('shop/sales/credit_receipt'));
		}
	}

	// Cash Invoice
	public function cash_invoice_action()
	{
		$response = array();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('p_concern_id', 'Concern Name', 'required');
		$this->form_validation->set_rules('p_customer_id', 'Party Name', 'required');
		if ($this->form_validation->run() == FALSE) {
			$response['error'] = validation_errors();
		} else {
			$this->session->set_userdata('cash_inv_terms', $this->input->post());
			$response['success'] = 'success';
		}
		echo json_encode($response);
	}

	public function cash_invoice_form($p_delivery_id = '')
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_sh_cash_invoices'");
		$next = $next->row(0);
		$data['cash_inv_no'] = $next->Auto_increment;
		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'cash_incoice';
		$data['page_title'] = 'Shop Cash Invoice';
		$data['p_delivery_id'] = $p_delivery_id;
		$data['exist_inv_nos'] = $this->Sales_model->existing_invoice_nos('cash'); //ER-07-18#-22
		$data['cash_inv_terms'] = $this->session->userdata('cash_inv_terms');
		$data['cart_items'] = $this->Predelivery_model->get_cart_temp_items($this->session->userdata('user_id'));
		$this->load->view('cash-invoice-form', $data);
	}
	public function cash_invoice_save($p_delivery_id = '')
	{
		$invoice_id = false;
		$predc_items = array();
		$taxs = array();
		if ($this->session->userdata('cash_inv_terms')) {
			$cash_inv_terms = $this->session->userdata('cash_inv_terms');
			$predc_items = (isset($cash_inv_terms['predc_items'])) ? $cash_inv_terms['predc_items'] : array();
		}

		$p_concern_id = $this->input->post('p_concern_id');
		$p_customer_id = $this->input->post('p_customer_id');
		$p_delivery_to = $this->input->post('p_delivery_to');
		$name = $this->input->post('name');
		$mobile_no = $this->input->post('mobile_no');
		$remarks = $this->input->post('remarks');
		$transport_mode = $this->input->post('transport_mode');

		$order_othercharges = $this->input->post('order_othercharges');
		$order_othercharges_type = $this->input->post('order_othercharges_type');
		$order_othercharges_names = $this->input->post('order_othercharges_names');
		$order_othercharges_unit = $this->input->post('order_othercharges_unit');
		$order_othercharges_desc = $this->input->post('order_othercharges_desc');
		$order_tax_names = $this->input->post('order_tax_names');
		if ($this->input->post('taxs')) {
			$taxs = $this->input->post('taxs');
		}

		$othercharges_data = array();
		if (count($order_othercharges) > 0) {
			foreach ($order_othercharges as $key => $value) {
				$othercharges = array();
				$othercharges['id'] = $key;
				$othercharges['value'] = $value;
				$othercharges['type'] = $order_othercharges_type[$key];
				$othercharges['names'] = $order_othercharges_names[$key];
				$othercharges['unit'] = $order_othercharges_unit[$key];
				$othercharges['desc'] = $order_othercharges_desc[$key];

				$othercharges_data[] = $othercharges;
			}
		}

		$tax_data = array();
		if (count($taxs) > 0) {
			foreach ($taxs as $key => $value) {
				$tax['id'] = $key;
				$tax['value'] = $value;
				$tax['name'] = $order_tax_names[$key];
				$tax_data[] = $tax;
			}
		}


		if (!empty($p_delivery_id)) {
			$save['p_delivery_id'] = $p_delivery_id;
		} else {
			$save['p_delivery_id'] = 0;
		}
		$save['p_concern_id'] = $this->input->post('p_concern_id');
		$save['p_delivery_date'] = date("Y-m-d H:i:s");
		$save['p_customer_id'] = $this->input->post('p_customer_id');
		$save['p_delivery_to'] = $this->input->post('p_delivery_to');
		$save['name'] = $this->input->post('name');
		$save['mobile_no'] = $this->input->post('mobile_no');
		$save['remarks'] = $this->input->post('remarks');

		$cart_items = $this->Predelivery_model->get_cart_temp_items($this->session->userdata('user_id'));
		$p_delivery_id = $this->Predelivery_model->save_predc($save, $cart_items, $predc_items);
		if ($p_delivery_id) {
			$predc = $this->Predelivery_model->get_predc($p_delivery_id);
			if ($predc) {
				$save_dc['delivery_id'] = 0;
				$save_dc['concern_id'] = $predc->p_concern_id;
				$save_dc['delivery_date'] = date("Y-m-d H:i:s");
				$save_dc['customer_id'] = $predc->p_customer_id;
				$save_dc['delivery_to'] = $predc->p_delivery_to;
				$save_dc['name'] = $predc->name;
				$save_dc['mobile_no'] = $predc->mobile_no;
				$save_dc['remarks'] = $predc->remarks;
				$save_dc['p_delivery_id'] = $predc->p_delivery_id;

				$predc_items = $this->Predelivery_model->get_predc_items($p_delivery_id);
				$delivery_id = $this->Delivery_model->save_delivery($save_dc, $predc_items);


				$invoice_no = '';
				if ($this->input->post('old_invoice_no') != 'new') //ER-07-18#-22
				{
					$invoice_no = $this->input->post('old_invoice_no');
				} elseif ($this->input->post('cash_inv_no')) //ER-07-18#-22
				{
					$invoice_no = $this->input->post('cash_inv_no');
				}

				$cash_inv['invoice_id'] = 0;
				$cash_inv['invoice_no'] = $invoice_no;
				$cash_inv['concern_id'] = $predc->p_concern_id;
				$cash_inv['customer_id'] = $predc->p_customer_id;
				$cash_inv['delivery_to'] = $predc->p_delivery_to;
				$cash_inv['name'] = $predc->name;
				$cash_inv['mobile_no'] = $predc->mobile_no;
				$cash_inv['remarks'] = $predc->remarks;
				$cash_inv['created_by'] = $this->session->userdata('user_id');
				$cash_inv['invoice_date'] = date("Y-m-d H:i:s");
				$cash_inv['othercharges_data'] = json_encode($othercharges_data);
				$cash_inv['tax_data'] = json_encode($tax_data);
				$cash_inv['transport_mode'] = $this->input->post('transport_mode');

				$dc_items = $this->Delivery_model->get_delivery_items($delivery_id);
				$invoice_id = $this->Sales_model->save_cash_invoice($cash_inv, $dc_items);
			}
		}

		redirect(base_url('shop/sales/print_cashinvoice/' . $invoice_id), 'refresh');
	}

	public function print_cashinvoice($invoice_id = '')
	{
		if (!empty($invoice_id)) {
			$data['activeTab'] = 'shop';
			$data['activeItem'] = 'cashinvoice';
			$data['page_title'] = 'Shop Print Cash Invoice';
			$data['invoice'] = $this->Sales_model->get_cash_invoice($invoice_id);
			$this->load->view('print-cash-invoice', $data);
		} else {
			redirect(base_url('my404'));
		}
	}

	// Credit Invoice
	public function credit_invoice_action()
	{
		$response = array();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('p_concern_id', 'Concern Name', 'required');
		$this->form_validation->set_rules('p_customer_id', 'Party Name', 'required');
		if ($this->form_validation->run() == FALSE) {
			$response['error'] = validation_errors();
		} else {
			$this->session->set_userdata('credit_inv_terms', $this->input->post());
			$response['success'] = 'success';
		}
		echo json_encode($response);
	}

	public function credit_invoice_form($p_delivery_id = '')
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_sh_credit_invoices'");
		$next = $next->row(0);
		$data['credit_inv_no'] = $next->Auto_increment;
		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'credit_incoice';
		$data['page_title'] = 'Shop Credit Invoice';
		$data['p_delivery_id'] = $p_delivery_id;
		$credit_inv_terms = $this->session->userdata('credit_inv_terms');
		$data['credit_inv_terms'] = $this->session->userdata('credit_inv_terms');
		$data['accounts_data'] = $this->Sales_model->get_cust_credit_amt($credit_inv_terms['p_customer_id']);
		$data['exist_inv_nos'] = $this->Sales_model->existing_invoice_nos('credit'); //ER-07-18#-22
		$data['cart_items'] = $this->Predelivery_model->get_cart_temp_items($this->session->userdata('user_id'));
		$this->load->view('credit-invoice-form', $data);
	}
	public function credit_invoice_save($p_delivery_id = '')
	{
		$invoice_id = false;
		$predc_items = array();
		$taxs = array();
		if ($this->session->userdata('credit_inv_terms')) {
			$credit_inv_terms = $this->session->userdata('credit_inv_terms');
			$predc_items = (isset($credit_inv_terms['predc_items'])) ? $credit_inv_terms['predc_items'] : array();
		}

		$p_concern_id = $this->input->post('p_concern_id');
		$p_customer_id = $this->input->post('p_customer_id');
		$p_delivery_to = $this->input->post('p_delivery_to');
		$name = $this->input->post('name');
		$mobile_no = $this->input->post('mobile_no');
		$remarks = $this->input->post('remarks');
		$transport_mode = $this->input->post('transport_mode');

		$order_othercharges = $this->input->post('order_othercharges');
		$order_othercharges_type = $this->input->post('order_othercharges_type');
		$order_othercharges_names = $this->input->post('order_othercharges_names');
		$order_othercharges_unit = $this->input->post('order_othercharges_unit');
		$order_othercharges_desc = $this->input->post('order_othercharges_desc');
		$order_tax_names = $this->input->post('order_tax_names');
		if ($this->input->post('taxs')) {
			$taxs = $this->input->post('taxs');
		}

		$othercharges_data = array();
		if (count($order_othercharges) > 0) {
			foreach ($order_othercharges as $key => $value) {
				$othercharges = array();
				$othercharges['id'] = $key;
				$othercharges['value'] = $value;
				$othercharges['type'] = $order_othercharges_type[$key];
				$othercharges['names'] = $order_othercharges_names[$key];
				$othercharges['unit'] = $order_othercharges_unit[$key];
				$othercharges['desc'] = $order_othercharges_desc[$key];

				$othercharges_data[] = $othercharges;
			}
		}

		$tax_data = array();
		if (count($taxs) > 0) {
			foreach ($taxs as $key => $value) {
				$tax['id'] = $key;
				$tax['value'] = $value;
				$tax['name'] = $order_tax_names[$key];
				$tax_data[] = $tax;
			}
		}


		if (!empty($p_delivery_id)) {
			$save['p_delivery_id'] = $p_delivery_id;
		} else {
			$save['p_delivery_id'] = 0;
		}
		$save['p_concern_id'] = $this->input->post('p_concern_id');
		$save['p_delivery_date'] = date("Y-m-d H:i:s");
		$save['p_customer_id'] = $this->input->post('p_customer_id');
		$save['p_delivery_to'] = $this->input->post('p_delivery_to');
		$save['name'] = $this->input->post('name');
		$save['mobile_no'] = $this->input->post('mobile_no');
		$save['remarks'] = $this->input->post('remarks');

		$cart_items = $this->Predelivery_model->get_cart_temp_items($this->session->userdata('user_id'));
		$p_delivery_id = $this->Predelivery_model->save_predc($save, $cart_items, $predc_items);
		if ($p_delivery_id) {
			$predc = $this->Predelivery_model->get_predc($p_delivery_id);
			if ($predc) {
				$save_dc['delivery_id'] = 0;
				$save_dc['concern_id'] = $predc->p_concern_id;
				$save_dc['delivery_date'] = date("Y-m-d H:i:s");
				$save_dc['customer_id'] = $predc->p_customer_id;
				$save_dc['delivery_to'] = $predc->p_delivery_to;
				$save_dc['name'] = $predc->name;
				$save_dc['mobile_no'] = $predc->mobile_no;
				$save_dc['remarks'] = $predc->remarks;
				$save_dc['p_delivery_id'] = $predc->p_delivery_id;

				$predc_items = $this->Predelivery_model->get_predc_items($p_delivery_id);
				$delivery_id = $this->Delivery_model->save_delivery($save_dc, $predc_items);

				$invoice_no = '';
				if ($this->input->post('old_invoice_no') != 'new') //ER-07-18#-22
				{
					$invoice_no = $this->input->post('old_invoice_no');
				} elseif ($this->input->post('credit_inv_no')) //ER-07-18#-22
				{
					$invoice_no = $this->input->post('credit_inv_no');
				}

				$credit_inv['invoice_id'] = 0;
				$credit_inv['invoice_no'] = $invoice_no;
				$credit_inv['concern_id'] = $predc->p_concern_id;
				$credit_inv['customer_id'] = $predc->p_customer_id;
				$credit_inv['delivery_to'] = $predc->p_delivery_to;
				$credit_inv['name'] = $predc->name;
				$credit_inv['mobile_no'] = $predc->mobile_no;
				$credit_inv['remarks'] = $predc->remarks;
				$credit_inv['created_by'] = $this->session->userdata('user_id');
				$credit_inv['invoice_date'] = date("Y-m-d H:i:s");
				$credit_inv['othercharges_data'] = json_encode($othercharges_data);
				$credit_inv['tax_data'] = json_encode($tax_data);
				$credit_inv['transport_mode'] = $this->input->post('transport_mode');

				$dc_items = $this->Delivery_model->get_delivery_items($delivery_id);
				if ($dc_items) { //ER-07-18#-23
					$invoice_id = $this->Sales_model->save_credit_invoice($credit_inv, $dc_items);
				}
			}
		}

		redirect(base_url('shop/sales/print_credit_invoice/' . $invoice_id), 'refresh');
	}

	public function print_credit_gatepass($invoice_id = '')
	{
		if (!empty($invoice_id)) {
			$data['activeTab'] = 'shop';
			$data['activeItem'] = 'cashinvoice';
			$data['page_title'] = 'Shop Print Credit Invoice';
			$data['invoice'] = $this->Sales_model->get_credit_invoice($invoice_id);
			$data['copytype'] = 'ORIGINAL COPY FOR CUSTOMER';
			$this->load->view('print_credit_gatepass', $data);
		} else {
			redirect(base_url('my404'));
		}
	}

	public function print_credit_preprint($invoice_id = '')
	{
		if (!empty($invoice_id)) {
			$data['activeTab'] = 'shop';
			$data['activeItem'] = 'cashinvoice';
			$data['page_title'] = 'Shop Print Credit Invoice';
			$data['invoice'] = $this->Sales_model->get_credit_invoice($invoice_id);
			$data['copytype'] = 'ORIGINAL COPY FOR CUSTOMER';
			$this->load->view('print-credit-preprint', $data);
		} else {
			redirect(base_url('my404'));
		}
	}

	public function print_credit_invoice($invoice_id = '')
	{
		if (!empty($invoice_id)) {
			$data['activeTab'] = 'shop';
			$data['activeItem'] = 'cashinvoice';
			$data['page_title'] = 'Shop Print Credit Invoice';
			$data['invoice'] = $this->Sales_model->get_credit_invoice($invoice_id);
			$data['copytype'] = 'ORIGINAL COPY FOR CUSTOMER';
			$this->load->view('print-credit-invoice', $data);
		} else {
			redirect(base_url('my404'));
		}
	}
	public function print_credit_invoicedc($invoice_id = '')
	{
		if (!empty($invoice_id)) {
			$data['activeTab'] = 'shop';
			$data['activeItem'] = 'cashinvoice';
			$data['page_title'] = 'Shop Print Credit Invoice';
			$data['invoice'] = $this->Sales_model->get_credit_invoice($invoice_id);
			$data['copytype'] = 'DUPLICATE COPY FOR CUSTOMER';
			$this->load->view('print-credit-invoice', $data);
		} else {
			redirect(base_url('my404'));
		}
	}
	public function print_credit_invoiceac($invoice_id = '')
	{
		if (!empty($invoice_id)) {
			$data['activeTab'] = 'shop';
			$data['activeItem'] = 'cashinvoice';
			$data['page_title'] = 'Shop Print Credit Invoice';
			$data['invoice'] = $this->Sales_model->get_credit_invoice($invoice_id);
			$data['copytype'] = 'ACCOUNTS COPY FOR SUPPLIER';
			$this->load->view('print-credit-invoice', $data);
		} else {
			redirect(base_url('my404'));
		}
	}
	public function print_credit_invoicesc($invoice_id = '')
	{
		if (!empty($invoice_id)) {
			$data['activeTab'] = 'shop';
			$data['activeItem'] = 'cashinvoice';
			$data['page_title'] = 'Shop Print Credit Invoice';
			$data['invoice'] = $this->Sales_model->get_credit_invoice($invoice_id);
			$data['copytype'] = 'SHOP COPY';
			$this->load->view('print-credit-invoice', $data);
		} else {
			redirect(base_url('my404'));
		}
	}
	public function cash_inv_list()
	{
		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'cash_inv_list';
		$data['page_title'] = 'Shop Print Cash Invoice';
		$data['invoices'] = $this->Sales_model->get_cash_inv_list();
		$this->load->view('cash-inv-list', $data);
	}
	public function credit_inv_list()
	{
		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'credit_inv_list';
		$data['page_title'] = 'Shop Print Credit Invoice';
		$data['invoices'] = $this->Sales_model->get_credit_inv_list();
		$this->load->view('credit-inv-list', $data);
	}

	// Create Credit Invoice
	public function create_cr_invoice()
	{
		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'create_cr_invoice';
		$data['page_title'] = 'Shop Create Credit Invoice';
		$data['concern_id'] = '';
		$data['customer_id'] = '';
		$data['delivery_to'] = '';
		$data['name'] = '';
		$data['mobile_no'] = '';
		$data['remarks'] = '';
		$data['concerns'] = $this->Stocktrans_model->get_concerns();
		$data['customers'] = $this->Predelivery_model->get_customers();
		$data['delivery_list'] = $this->Delivery_model->get_delivery_list($pending = true);
		$this->load->view('create-cr-invoice', $data);
	}

	public function cr_invoice_preview()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');

		/*echo "<pre>";
		print_r($_POST);
		echo "</pre>";*/

		$this->form_validation->set_rules('concern_id', 'Concern Name', 'required');
		$this->form_validation->set_rules('customer_id', 'Party Name', 'required');
		$this->form_validation->set_rules('selected_boxes', 'DC Checkbox', 'required');

		if ($this->form_validation->run() == FALSE) {
			$error = validation_errors();
			$this->session->set_flashdata('error', $error);
			redirect(base_url('shop/sales/create_cr_invoice'), 'refresh');
		} else {
			$data['concern_id'] = $this->input->post('concern_id');
			$data['customer_id'] = $this->input->post('customer_id');
			$data['delivery_to'] = $this->input->post('delivery_to');
			$data['name'] = $this->input->post('name');
			$data['mobile_no'] = $this->input->post('mobile_no');

			$data['selected_dc'] = $this->input->post('selected_boxes');
			$data['remarks'] = '';
			$selected_dc = explode(",", $this->input->post('selected_boxes'));

			$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_sh_credit_invoices'");
			$next = $next->row(0);
			$data['credit_inv_no'] = $next->Auto_increment;
			$data['activeTab'] = 'shop';
			$data['activeItem'] = 'credit_incoice';
			$data['page_title'] = 'Shop Credit Invoice';

			// print_r($selected_dc);

			$cart_items = array();
			if (count($selected_dc) > 0) {
				foreach ($selected_dc as $delivery_id) {
					$dc_items = $this->Delivery_model->get_delivery_items($delivery_id);
					if (sizeof($dc_items) > 0) {
						foreach ($dc_items as $dc_item) {
							$cart_items[] = $dc_item;
						}
					}
				}
			}
			$data['cart_items'] = $cart_items;
			$this->load->view('credit-invoice-preview', $data);
		}
	}

	public function cr_invoice_save()
	{
		/*echo "<pre>";
		print_r($_POST);
		echo "</pre>";*/
		$taxs = array();
		$concern_id = $this->input->post('concern_id');
		$customer_id = $this->input->post('customer_id');
		$delivery_to = $this->input->post('delivery_to');
		$name = $this->input->post('name');
		$mobile_no = $this->input->post('mobile_no');
		$remarks = $this->input->post('remarks');
		$transport_mode = $this->input->post('transport_mode');
		$cust_pono = $this->input->post('cust_pono');

		$order_othercharges = $this->input->post('order_othercharges');
		$order_othercharges_type = $this->input->post('order_othercharges_type');
		$order_othercharges_names = $this->input->post('order_othercharges_names');
		$order_othercharges_unit = $this->input->post('order_othercharges_unit');
		$order_othercharges_desc = $this->input->post('order_othercharges_desc');
		$order_tax_names = $this->input->post('order_tax_names');
		if ($this->input->post('taxs')) {
			$taxs = $this->input->post('taxs');
		}

		$othercharges_data = array();
		if (count($order_othercharges) > 0) {
			foreach ($order_othercharges as $key => $value) {
				$othercharges = array();
				$othercharges['id'] = $key;
				$othercharges['value'] = $value;
				$othercharges['type'] = $order_othercharges_type[$key];
				$othercharges['names'] = $order_othercharges_names[$key];
				$othercharges['unit'] = $order_othercharges_unit[$key];
				$othercharges['desc'] = $order_othercharges_desc[$key];

				$othercharges_data[] = $othercharges;
			}
		}

		$tax_data = array();
		if (count($taxs) > 0) {
			foreach ($taxs as $key => $value) {
				$tax['id'] = $key;
				$tax['value'] = $value;
				$tax['name'] = $order_tax_names[$key];
				$tax_data[] = $tax;
			}
		}

		$invoice_no = '';
		if ($this->input->post('credit_inv_no')) {
			$invoice_no = $this->input->post('credit_inv_no');
		}
		$credit_inv['invoice_id'] = '';
		$credit_inv['invoice_no'] = $invoice_no;
		$credit_inv['concern_id'] = $concern_id;
		$credit_inv['customer_id'] = $customer_id;
		$credit_inv['delivery_to'] = $delivery_to;
		$credit_inv['name'] = $name;
		$credit_inv['mobile_no'] = $mobile_no;
		$credit_inv['remarks'] = $remarks;
		$credit_inv['cust_pono'] = $cust_pono;
		$credit_inv['created_by'] = $this->session->userdata('user_id');
		$credit_inv['invoice_date'] = date("Y-m-d H:i:s");
		$credit_inv['othercharges_data'] = json_encode($othercharges_data);
		$credit_inv['tax_data'] = json_encode($tax_data);
		$credit_inv['transport_mode'] = $this->input->post('transport_mode');

		$selected_dc = explode(",", $this->input->post('selected_dc'));
		$cart_items = array();
		if (count($selected_dc) > 0) {
			foreach ($selected_dc as $delivery_id) {
				$dc_items = $this->Delivery_model->get_delivery_items($delivery_id);
				if (sizeof($dc_items) > 0) {
					foreach ($dc_items as $dc_item) {
						$cart_items[] = $dc_item;
					}
				}
			}
		}
		$invoice_id = $this->Sales_model->save_credit_invoice($credit_inv, $cart_items);
		redirect(base_url('shop/sales/print_credit_invoice/' . $invoice_id), 'refresh');
	}

	// Quotation
	public function quotation_action()
	{
		$response = array();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('p_concern_id', 'Concern Name', 'required');
		$this->form_validation->set_rules('p_customer_id', 'Party Name', 'required');
		if ($this->form_validation->run() == FALSE) {
			$response['error'] = validation_errors();
		} else {
			$this->session->set_userdata('quotation_terms', $this->input->post());
			$response['success'] = 'success';
		}
		echo json_encode($response);
	}

	public function quotation_form($p_delivery_id = '')
	{
		$data['quotation_no'] = '';
		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'credit_incoice';
		$data['page_title'] = 'Shop Quotation';
		$data['p_delivery_id'] = $p_delivery_id;
		$data['quotation_nos'] = $this->Sales_model->existing_quoation_nos(); //ER-07-18#-17
		$data['quotation_terms'] = $this->session->userdata('quotation_terms');
		$data['cart_items'] = $this->Predelivery_model->get_cart_temp_items($this->session->userdata('user_id'));
		$this->load->view('quotation-form', $data);
	}
	public function quotation_save($p_delivery_id = '')
	{
		$quotation_id = false;
		$predc_items = array();
		$taxs = array();
		if ($this->session->userdata('quotation_terms')) {
			$quotation_terms = $this->session->userdata('quotation_terms');
			$predc_items = (isset($credit_inv_terms['predc_items'])) ? $credit_inv_terms['predc_items'] : array();
		}

		$p_concern_id = $this->input->post('p_concern_id');
		$p_customer_id = $this->input->post('p_customer_id');
		$p_delivery_to = $this->input->post('p_delivery_to');
		$name = $this->input->post('name');
		$mobile_no = $this->input->post('mobile_no');
		$remarks = $this->input->post('remarks');

		$order_othercharges = $this->input->post('order_othercharges');
		$order_othercharges_type = $this->input->post('order_othercharges_type');
		$order_othercharges_names = $this->input->post('order_othercharges_names');
		$order_othercharges_unit = $this->input->post('order_othercharges_unit');
		$order_othercharges_desc = $this->input->post('order_othercharges_desc');
		$order_tax_names = $this->input->post('order_tax_names');
		if ($this->input->post('taxs')) {
			$taxs = $this->input->post('taxs');
		}

		$othercharges_data = array();
		if (count($order_othercharges) > 0) {
			foreach ($order_othercharges as $key => $value) {
				$othercharges = array();
				$othercharges['id'] = $key;
				$othercharges['value'] = $value;
				$othercharges['type'] = $order_othercharges_type[$key];
				$othercharges['names'] = $order_othercharges_names[$key];
				$othercharges['unit'] = $order_othercharges_unit[$key];
				$othercharges['desc'] = $order_othercharges_desc[$key];

				$othercharges_data[] = $othercharges;
			}
		}

		$tax_data = array();
		if (count($taxs) > 0) {
			foreach ($taxs as $key => $value) {
				$tax['id'] = $key;
				$tax['value'] = $value;
				$tax['name'] = $order_tax_names[$key];
				$tax_data[] = $tax;
			}
		}


		if (!empty($p_delivery_id)) {
			$save['p_delivery_id'] = $p_delivery_id;
		} else {
			$save['p_delivery_id'] = 0;
		}
		$save['p_concern_id'] = $this->input->post('p_concern_id');
		$save['p_delivery_date'] = date("Y-m-d H:i:s");
		$save['p_customer_id'] = $this->input->post('p_customer_id');
		$save['p_delivery_to'] = $this->input->post('p_delivery_to');
		$save['name'] = $this->input->post('name');
		$save['mobile_no'] = $this->input->post('mobile_no');
		$save['remarks'] = $this->input->post('remarks');

		$cart_items = $this->Predelivery_model->get_cart_temp_items($this->session->userdata('user_id'));
		$p_delivery_id = $this->Predelivery_model->save_predc($save, $cart_items, $predc_items);
		if ($p_delivery_id) {
			$predc = $this->Predelivery_model->get_predc($p_delivery_id);
			if ($predc) {
				$save_dc['delivery_id'] = 0;
				$save_dc['concern_id'] = $predc->p_concern_id;
				$save_dc['delivery_date'] = date("Y-m-d H:i:s");
				$save_dc['customer_id'] = $predc->p_customer_id;
				$save_dc['delivery_to'] = $predc->p_delivery_to;
				$save_dc['name'] = $predc->name;
				$save_dc['mobile_no'] = $predc->mobile_no;
				$save_dc['remarks'] = $predc->remarks;
				$save_dc['p_delivery_id'] = $predc->p_delivery_id;

				$predc_items = $this->Predelivery_model->get_predc_items($p_delivery_id);
				$delivery_id = $this->Delivery_model->save_delivery($save_dc, $predc_items);

				$quotation_no = '';
				if ($this->input->post('quotation_no')) {
					$quotation_no = $this->input->post('quotation_no');
				}
				//ER-07-18#-17
				if ($this->input->post('old_quotation_no') != 'new') {
					$quotation_no = $this->input->post('old_quotation_no');
				}
				// end of ER-07-18#-17
				$quotation['quotation_id'] = 0;
				$quotation['quotation_no'] = $quotation_no;
				$quotation['concern_id'] = $predc->p_concern_id;
				$quotation['customer_id'] = $predc->p_customer_id;
				$quotation['delivery_to'] = $predc->p_delivery_to;
				$quotation['name'] = $predc->name;
				$quotation['mobile_no'] = $predc->mobile_no;
				$quotation['remarks'] = $predc->remarks;
				$quotation['created_by'] = $this->session->userdata('user_id');
				$quotation['quotation_date'] = date("Y-m-d H:i:s");
				$quotation['othercharges_data'] = json_encode($othercharges_data);
				$quotation['tax_data'] = json_encode($tax_data);

				$dc_items = $this->Delivery_model->get_delivery_items($delivery_id);
				$quotation_id = $this->Sales_model->save_quotation($quotation, $dc_items);
			}
		}

		redirect(base_url('shop/sales/print_quotation/' . $quotation_id), 'refresh');
	}

	public function print_quotation($quotation_id = '')
	{
		if (!empty($quotation_id)) {
			$data['activeTab'] = 'shop';
			$data['activeItem'] = 'quotation_list';
			$data['page_title'] = 'Shop Print Quotation';
			$data['quotation'] = $this->Sales_model->get_quotation($quotation_id);
			$this->load->view('print-quotation', $data);
		} else {
			redirect(base_url('my404'));
		}
	}
	public function quotation_list()
	{
		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'quotation_list';
		$data['page_title'] = 'Shop Print Quotation';
		$data['quotations'] = $this->Sales_model->get_quotation_list();
		$this->load->view('quotation-list', $data);
	}
	function invoice_delete() //ER-07-18#-22
	{
		$invoice_id = $this->input->post("invoice_id");
		$remarks = $this->input->post("remarks");
		$type = $this->input->post("type");
		$result = null;
		if ($invoice_id) {
			$result = $this->Sales_model->update_delete_status_invoice_sh($invoice_id, $remarks, $type);
		}
		echo ($result) ? $result . ' Successfully Deleted' : 'Error in Deletion';
	}
}
