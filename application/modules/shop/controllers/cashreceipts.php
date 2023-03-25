<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cashreceipts extends CI_Controller {
	var $item_id = false;
	function __construct()
	{
		parent::__construct();
		$this->load->model('Packing_model');
		$this->load->model('Stocktrans_model');
		$this->load->model('Predelivery_model');
		$this->load->model('Delivery_model');
		$this->load->model('Sales_model');
		$this->load->model('Cashreceipts_model');
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

	public function add_to_list()
	{
		if($this->input->post('selected_ids'))
		{
			$selected_ids = explode(",", $this->input->post('selected_ids'));
			if(count($selected_ids) > 0)
			{
				foreach ($selected_ids as $receipt_id) {

					$cart_item = array( 
						'id' => $receipt_id,
						'name' => 'SHOP-'.$receipt_id,
						'price' => 1,
						'qty' => 1
					);

					$this->cart->insert($cart_item);

					$save['receipt_id'] = $receipt_id;
					$save['cash_tranfered'] = 1;
					$this->Sales_model->save_cash_receipt($save);
				}
			}
		}
	}

	public function remove_to_list()
	{
		if($this->input->post('row_id'))
		{
			$cart_items = $this->cart->contents();
			if(sizeof($cart_items) > 0)
			{
				foreach ($cart_items as $item) {
					if ( $item['id'] == $this->input->post('row_id') ) {
						$receipt = $this->Sales_model->get_cash_receipt($item['id']);
						if($receipt)
						{
							$save['receipt_id'] = $receipt->receipt_id;
							$save['cash_tranfered'] = 0;
							$this->Sales_model->save_cash_receipt($save);

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

	public function cart_temp_items()
	{
		$data['cart_items'] = $this->cart->contents();
		$this->load->view('includes/cash-recpt-temp-items', $data);
	}

	public function cash_recpt_list()
	{
		$filter['cash_tranfered'] = 0;
		$data['receipt_list'] = $this->Sales_model->get_cash_receipt_list($filter);
		$this->load->view('includes/cash-recpt-list', $data);
	}

	public function cash_recpt_delivery()
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_sh_cash_receipt_trans'");
		$next = $next->row(0);
		$data['transfer_id'] = $next->Auto_increment;

		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'cash_recpt_delivery';
		$data['page_title'] = 'Shop Cash Receipt Cash Delivery';
		$data['users'] = $this->Stocktrans_model->get_users(array('Admin'));
		$data['concerns'] = $this->Stocktrans_model->get_concerns();
		$data['customers'] = $this->Predelivery_model->get_customers();		
		$data['transfer_list'] = $this->Cashreceipts_model->get_transfer_list();		
		$this->load->view('cash-recpt-delivery', $data);
	}

	public function cash_recpt_trans()
	{
		$response = array();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('transfer_to', 'To Staff', 'required');
		$this->form_validation->set_rules('receipt_ids[]', 'Selected Receipts', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$response['error'] = validation_errors();
		}
		else
		{
			$save['id'] = '';
			$save['transfer_date'] = date("Y-m-d H:i:s");
			$save['transfer_by'] = $this->session->userdata('user_id');
			$save['transfer_to'] = $this->input->post('transfer_to');
			$save['remarks'] = $this->input->post('remarks');
			$save['receipt_ids'] = implode(",", $this->input->post('receipt_ids'));
			$id = $this->Cashreceipts_model->save_transfer($save);
			if($id)
			{
				foreach ($this->input->post('receipt_ids') as $receipt_id) {
					$receipt_data['receipt_id'] = $receipt_id;
					$receipt_data['cash_tranfered'] = 2;
					$this->Sales_model->save_cash_receipt($receipt_data);

					$this->cart->destroy();
				}
			}
			$response['id'] = $id;
		}
		echo json_encode($response);
	}

	public function print_cash_trans($id = '')
	{
		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'print_cash_trans';
		$data['page_title'] = 'Print Shop Cash Receipt Cash Tranfer';	
		$data['transfer'] = $this->Cashreceipts_model->get_cash_transfer($id);
		$this->load->view('print-cash-trans', $data);
	}

	public function pending_cash_trans()
	{
		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'pending_cash_trans';
		$data['page_title'] = 'Shop Cash Receipt Cash Tranfer Accept';	
		$data['transfer_list'] = $this->Cashreceipts_model->get_transfer_list();
		$this->load->view('pending-cash-trans', $data);
	}

	public function accept_cash_trans($id='')
	{
		if(!empty($id))
		{
			$save['id'] = $id;
			$save['is_accepted'] = 1;
			$save['accepted_on'] = date("Y-m-d H:i:s");
			$save['accepted_by'] = $this->session->userdata('user_id');
			$this->Cashreceipts_model->save_transfer($save);
			redirect(base_url(''), 'refresh');
		}
	}
}