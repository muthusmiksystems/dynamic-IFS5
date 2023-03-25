<?php
// Scrapsales
// Sub Std Sales
defined('BASEPATH') OR exit('No direct script access allowed');

class Scrapsales extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('Packing_model');
		$this->load->model('Stocktrans_model');
		$this->load->model('Predelivery_model');
		$this->load->model('Delivery_model');
		$this->load->model('Sales_model');
		$this->load->model('Quotation_model');
		$this->load->model('Scrapsales_model');
		$this->load->model('m_masters');
		$this->load->model('m_users');
		if ( ! $this->session->userdata('logged_in'))
	    {
	        // Allow some methods?
	        $allowed = array();
	        if ( ! in_array($this->router->method, $allowed))
	        {
	            redirect(base_url().'users/login', 'refresh');
	        }
	    }
	}
	public function add_to_cart()
	{
		if($this->input->post('selected_ids'))
		{
			$selected_ids = explode(",", $this->input->post('selected_ids'));
			if(count($selected_ids) > 0)
			{
				foreach ($selected_ids as $quotation_id) {

					$cart_item = array( 
						'id' => $quotation_id,
						'name' => $quotation_id,
						'price' => 1,
						'qty' => 1
					);
					$this->cart->insert($cart_item);
				}
			}
		}
	}
	public function remove_to_cart()
	{
		if($this->input->post('row_id'))
		{
			$cart_items = $this->cart->contents();
			if(sizeof($cart_items) > 0)
			{
				foreach ($cart_items as $item) {
					if ( $item['id'] == $this->input->post('row_id') ) {
						$quotation = $this->Sales_model->get_quotation($item['id']);
						if($quotation)
						{
							$cart_item = array(
								'rowid'   => $item['rowid'],
								'qty'     => 0
								);
           					$this->cart->update($cart_item);
						}
					}
				}
			}
		}
	}

	public function scr_sales_temp_items()
	{
		$data['cart_items'] = $this->cart->contents();
		$this->load->view('includes/scr-sales-temp-items', $data);
	}
	public function index()
	{
		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'scrap_sales';
		$data['page_title'] = 'Shop Sub Std Sales';
		$data['concern_id'] = '';
		$data['customer_id'] = '';
		$data['delivery_to'] = '';
		$data['name'] = '';
		$data['mobile_no'] = '';
		$data['concerns'] = $this->Stocktrans_model->get_concerns();		
		$data['customers'] = $this->Predelivery_model->get_customers();
		$data['quotations'] = $this->Sales_model->get_quotation_list(array('is_scrapsales' => 0));		
		$this->load->view('sub-std-sales', $data);
	}

	public function scrapsales_action()
	{
		$response = array();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('concern_id', 'Concern Name', 'required');
		$this->form_validation->set_rules('customer_id', 'Party Name', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$response['error'] = validation_errors();
		}
		else
		{
			$this->session->set_userdata('scrap_terms', $this->input->post());
			$response['success'] = 'success';
		}
		echo json_encode($response);
	}
	public function scrapsales_form()
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_sh_scrapsales'");
		$next = $next->row(0);
		$data['invoice_no'] = $next->Auto_increment;
		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'cash_incoice';
		$data['page_title'] = 'Shop Cash Invoice';
		$data['cash_inv_terms'] = $this->session->userdata('cash_inv_terms');
		$data['uoms'] = $this->Stocktrans_model->get_uoms();
		$data['cart_items'] = $this->cart->contents();
		$this->load->view('scrapsales-form', $data);
	}
	public function scrapsales_save()
	{
		$invoice_id = false;
		$taxs = array();

		$concern_id = $this->input->post('concern_id');
		$customer_id = $this->input->post('customer_id');
		$delivery_to = $this->input->post('delivery_to');
		$name = $this->input->post('name');
		$mobile_no = $this->input->post('mobile_no');
		$remarks = $this->input->post('remarks');
		$transport_mode = $this->input->post('transport_mode');
		$item_description = $this->input->post('item_description');
		$item_weight = $this->input->post('item_weight');
		$item_rate = $this->input->post('item_rate');

		$order_othercharges = $this->input->post('order_othercharges');
		$order_othercharges_type = $this->input->post('order_othercharges_type');
		$order_othercharges_names = $this->input->post('order_othercharges_names');
		$order_othercharges_unit = $this->input->post('order_othercharges_unit');
		$order_othercharges_desc = $this->input->post('order_othercharges_desc');
		$order_tax_names = $this->input->post('order_tax_names');
		if($this->input->post('taxs'))
		{
			$taxs = $this->input->post('taxs');
		}

		$othercharges_data = array();
		if(count($order_othercharges) > 0)
		{
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
		if(count($taxs) > 0)
		{
			foreach ($taxs as $key => $value) {
				$tax['id'] = $key;
				$tax['value'] = $value;
				$tax['name'] = $order_tax_names[$key];
				$tax_data[] = $tax;
			}
		}

		$invoice_no = '';
		if($this->input->post('scrap_inv_no'))
		{
			$invoice_no = $this->input->post('scrap_inv_no');
		}

		$save['invoice_id'] = '';
		$save['invoice_no'] = $invoice_no;
		$save['concern_id'] = $this->input->post('concern_id');
		$save['customer_id'] = $this->input->post('customer_id');
		$save['delivery_to'] = $this->input->post('delivery_to');
		$save['name'] = $this->input->post('name');
		$save['mobile_no'] = $this->input->post('mobile_no');
		$save['remarks'] = $this->input->post('remarks');
		$save['created_by'] = $this->session->userdata('user_id');
		$save['invoice_date'] = date("Y-m-d H:i:s");
		$save['othercharges_data'] = json_encode($othercharges_data);
		$save['tax_data'] = json_encode($tax_data);
		$save['transport_mode'] = $this->input->post('transport_mode');
		$save['item_description'] = $this->input->post('item_description');
		$save['item_weight'] = $this->input->post('item_weight');
		$save['item_rate'] = $this->input->post('item_rate');
		$save['uom_name'] = $this->input->post('uom_name');
		$save['quotation_ids'] = $this->input->post('quotation_ids');
		$quotation_ids = explode(",", $this->input->post('quotation_ids'));
		$invoice_id = $this->Scrapsales_model->save_scrapsales($save, $quotation_ids);

		if($invoice_id)
		{
			$this->cart->destroy();
		}

		redirect(base_url('shop/scrapsales/print_scrap_invoice/'.$invoice_id), 'refresh');
	}

	public function scrap_inv_list()
	{
		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'scrap_inv_list';
		$data['page_title'] = 'Shop Print Scrap Invoice';
		$data['invoices'] = $this->Scrapsales_model->get_scrap_invoice_list();
		$this->load->view('scrap-inv-list', $data);
	}

	public function print_scrap_invoice($invoice_id='')
	{
		if(!empty($invoice_id))
		{
			$data['activeTab'] = 'shop';
			$data['activeItem'] = 'cashinvoice';
			$data['page_title'] = 'Shop Print Cash Invoice';
			$data['invoice_id'] = $invoice_id;
			$data['invoice'] = $this->Scrapsales_model->get_scrap_invoice($invoice_id);
			$this->load->view('print-scrap-invoice', $data);
		}
		else
		{
			redirect(base_url('my404'));
		}
	}
}
?>