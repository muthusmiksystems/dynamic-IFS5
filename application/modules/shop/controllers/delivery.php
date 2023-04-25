<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delivery extends CI_Controller {
	var $item_id = false;
	function __construct()
	{
		parent::__construct();
		$this->load->model('Packing_model');
		$this->load->model('Stocktrans_model');
		$this->load->model('Predelivery_model');
		$this->load->model('Delivery_model');
		$this->load->model('m_masters');
		$this->load->model('m_purchase');//ER-07-18#-3
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

	public function delivery_list()
	{
		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'delivery_list';
		$data['page_title'] = 'Shop Pre Delivery List';
		$data['delivery_list'] = $this->Delivery_model->get_delivery_list();
		$this->load->view('delivery-list', $data);
	}

	public function save_delivery($p_delivery_id='')
	{
		$response = array();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('p_concern_id', 'Concern Name', 'required');
		$this->form_validation->set_rules('p_customer_id', 'Party Name', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$response['error'] = validation_errors();
		}
		else
		{
			if($p_delivery_id)
			{
				$save['p_delivery_id'] = $p_delivery_id;
			}
			else
			{
				$save['p_delivery_id'] = 0;
			}
			$save['p_concern_id'] = $this->input->post('p_concern_id');
			$save['p_delivery_date'] = date("Y-m-d H:i:s");
			$save['p_customer_id'] = $this->input->post('p_customer_id');
			$save['p_delivery_to'] = $this->input->post('p_delivery_to');
			$save['name'] = $this->input->post('name');
			$save['mobile_no'] = $this->input->post('mobile_no');
			$save['remarks'] = $this->input->post('remarks');
			$predc_items = $this->input->post('predc_items');

			$cart_items = $this->Predelivery_model->get_cart_temp_items($this->session->userdata('user_id'));
			$p_delivery_id = $this->Predelivery_model->save_predc($save, $cart_items, $predc_items);
			if($p_delivery_id)
			{
				$predc = $this->Predelivery_model->get_predc($p_delivery_id);
				if($predc)
				{
					$p_concern_id = $this->input->post('p_concern_id');
					$dc_no = $this->Delivery_model->get_next_dc_no($p_concern_id);

					$save_dc['delivery_id'] = 0;
					$save_dc['concern_id'] = $predc->p_concern_id;
					$save_dc['dc_no'] = $dc_no;
					$save_dc['delivery_date'] = date("Y-m-d H:i:s");
					$save_dc['customer_id'] = $predc->p_customer_id;
					$save_dc['delivery_to'] = $predc->p_delivery_to;
					$save_dc['name'] = $predc->name;
					$save_dc['mobile_no'] = $predc->mobile_no;
					$save_dc['remarks'] = $predc->remarks;
					$save_dc['p_delivery_id'] = $predc->p_delivery_id;

					$predc_items = $this->Predelivery_model->get_predc_items($p_delivery_id);
					$delivery_id = $this->Delivery_model->save_delivery($save_dc, $predc_items);
					$response['delivery_id'] = $delivery_id;
				}
			}
		}
		echo json_encode($response);
	}

	public function print_delivery($delivery_id)
	{
		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'delivery';
		$data['page_title'] = 'Print Shop Delivery';
		$data['delivery'] = $this->Delivery_model->get_delivery($delivery_id);
		$this->load->view('print-delivery', $data);
	}
	function delivery_delete()//ER-07-18#-3
	{
		$delivery_id=$this->input->post("delivery_id");
		$remarks=$this->input->post("remarks");
		if($delivery_id)
		{
			$result = $this->Delivery_model->update_delete_status_delivery_sh($delivery_id,$remarks);
		}
		echo ($result)?$delivery_id.' Successfully Deleted':'Error in Deletion';
	}
	//ER-08-18#-37
	public function returned_dc()//ER-08-18#-37
	{
		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'returndelivery';
		$data['page_title'] = 'YARN ISSUED, RETURNED BACK TO STORE';//ER-08-18#-43
		$data['stock_rooms'] = $this->Packing_model->get_stock_rooms();
		$data['customers'] = $this->Predelivery_model->get_customers();
		$data['deliveries'] = $this->Delivery_model->get_delivery_nos();
		$data['boxes']=array();
		$data['delivery_id'] =0;
		$data['customer_id']=0;
		if(isset($_POST['search']))
		{
			$data['delivery_id'] = $this->input->post('delivery_id');
			$data['customer_id'] = $this->input->post('customer_id');
			$data['boxes'] = $this->Delivery_model->get_delivery_boxes($data['delivery_id']);
		}
		$this->load->view('returned_delivery', $data);
	}
	public function dcs($customer_id='')//ER-08-18#-37
	{
		$deliveries = $this->Delivery_model->get_delivery_nos($customer_id);
		echo    "<option value=''>Select</option>";
		foreach($deliveries as $delivery)
		{
			echo    "<option value='".$delivery->delivery_id."'>".$delivery->delivery_id."</option>";                    
		}
	}
	public function rdc_add_to_cart()//ER-08-18#-37
	{

		if($this->input->post('selected_boxes'))
		{
			$delivery_id=$this->input->post('delivery_id');
			$selected_boxes = explode(",", $this->input->post('selected_boxes'));
			if(count($selected_boxes) > 0)
			{
				foreach ($selected_boxes as $box_id) {
					$boxes = $this->Delivery_model->get_delivery_boxes($delivery_id,$box_id);
					foreach ($boxes as $box) {
						$cart_item['row_id'] = '';
						$cart_item['box_id'] = $box->box_id;
						$cart_item['box_prefix'] = $box->box_prefix;
						$cart_item['box_no'] = $box->box_no;
						$cart_item['item_group_id'] = $box->item_group_id;
						$cart_item['item_id'] = $box->item_id;
						$cart_item['shade_id'] = $box->shade_id;
						$cart_item['lot_no'] = $box->lot_no;
						$cart_item['no_boxes'] = $box->no_boxes;
						$cart_item['no_cones'] = $box->no_cones;
						$cart_item['gr_weight'] = $box->gr_weight;
						$cart_item['packed_on'] = $box->packed_on;
						$cart_item['prepared_by'] = $box->prepared_by;
						$cart_item['supplier_id'] = $box->supplier_id;
						$cart_item['supplier_dc_no'] = $box->supplier_dc_no;
						$cart_item['uom_id'] = $box->uom_id;
						$cart_item['stock_room_id'] = $box->stock_room_id;
						$cart_item['remarks'] = $box->remarks;
						$cart_item['is_deleted'] = $box->is_deleted;
						$cart_item['deleted_by'] = $box->deleted_by;
						$cart_item['deleted_on'] = $box->deleted_on;
						$cart_item['deleted_remarks'] = $box->deleted_remarks;
						$cart_item['nt_weight'] = $box->nt_weight;
						$cart_item['delivery_qty'] = $box->delivery_qty;
						$cart_item['return_qty'] = $box->delivery_qty;
						$cart_item['cart_user_id'] = $this->session->userdata('user_id');
						$this->Delivery_model->rdc_add_to_cart($cart_item);
					}
				}
			}
		}
	}
	public function rdc_cart_temp_items($delivery_id = '')//ER-08-18#-37
	{
		$data['rdc_items'] = array();
		$data['cart_items'] = $this->Delivery_model->get_rdc_cart_temp_items($this->session->userdata('user_id'));
		$this->load->view('includes/rdc-cart-temp-items', $data);
	}
	public function rdc_remove_to_cart()//ER-08-18#-37
	{
		if($this->input->post('row_id'))
		{
			$row_id = $this->input->post('row_id');
			$this->Delivery_model->rdc_remove_to_cart($row_id);
		}
	}
	public function rdc_remove_all_item()//ER-08-18#-37
	{
		$this->Delivery_model->rdc_remove_all_cart();
	}
	public function update_rdc_cart_item()//ER-08-18#-37
	{
		if($this->input->post('row_id'))
		{
			$row_id = $this->input->post('row_id');
			$return_qty = $this->input->post('return_qty');
			//ER-08-18#-42
			$return_cones = $this->input->post('return_cones');
			$cart_item['row_id'] = $row_id;
			if($return_qty){
				$cart_item['return_qty'] = $this->input->post('return_qty');
			}
			if($return_cones){
				$cart_item['return_cones'] = $this->input->post('return_cones');
			}
			//ER-08-18#-42
			$this->Delivery_model->rdc_add_to_cart($cart_item);
		}
	}
	public function rdc_save()//ER-08-18#-37
	{
		// print_r($_POST);
		$stock_room_id = $this->input->post('stock_room_id');
		$save['delivery_id'] = $this->input->post('delivery_id');
		$save['remarks'] = $this->input->post('remarks');
		$save['entered_by'] = $this->session->userdata('user_id');

		$rdc_items = $this->input->post('rdc_items');

		$cart_items = $this->Delivery_model->get_rdc_cart_temp_items($this->session->userdata('user_id'));
		$status = $this->Delivery_model->save_rdc($save, $cart_items, $rdc_items,$stock_room_id);
		if($status){
			$this->session->set_flashdata('success','USER,PLEASE NOTE, THIS YARN RETURNED IS SAVED IN TO BOX NO -'.$status);
		}
		else{
			$this->session->set_flashdata('error', 'error occured');
		}
	    redirect(base_url()."shop/delivery/returned_dc", 'refresh');
	}
	function rdc_report_sh()//ER-08-18#-28
	{
		$data['activeTab'] = 'shop_registers';
		$data['activeItem'] = 'rdc_report_sh';
		$data['page_title'] = 'RDC Report Shop';
		$data['catagory']='sh';
		$data['item_id'] = 0;
		$data['cust_id'] = 0;
		$data['status'] = '';
		$data['f_date'] = date('Y-m-d',strtotime("-1 month"));
		$data['t_date'] = date('Y-m-d');
        $data['items'] = $this->m_masters->getactivemaster('bud_items', 'item_status');
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['rdc_list']=array();
		if(isset($_POST['search']))
		{
			$data['item_id'] = $this->input->post('item_id');
			$data['cust_id'] = $this->input->post('cust_id');
			$data['f_date'] = $this->input->post('f_date');
			$data['t_date'] = $this->input->post('t_date');
			$data['status'] = $this->input->post('status');
		}
		$filter['item_id']=$data['item_id'];
		$filter['cust_id']=$data['cust_id'];	
		$filter['from_date']=$data['f_date'];
		$filter['to_date']=$data['t_date'];		
		$data['rdc_list']=$this->Delivery_model->get_rdc_report($filter);
		$this->load->view('v_rdc_report_sh', $data);
	}
	//ER-08-18#-37
}