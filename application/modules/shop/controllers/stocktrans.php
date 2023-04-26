<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stocktrans extends CI_Controller {
	var $item_id = false;
	function __construct()
	{
		parent::__construct();
		$this->load->model('Packing_model');
		$this->load->model('Stocktrans_model');
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

	public function get_next_dc_no()
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_sh_stocktransfer'");
		$next = $next->row(0);
		$next_dc_no = $next->Auto_increment;
		echo $next_dc_no;
	}

	public function get_stock_rooms()
	{
		$response = array();
		$stock_room_list = '<option value="">All</option>';
		$concern_id = $this->input->post('from_concern_id');
		$stock_rooms = $this->Packing_model->get_stock_rooms($concern_id);
		// print_r($stock_rooms);
		if(sizeof($stock_rooms) > 0)
		{
			foreach ($stock_rooms as $row) {
				$stock_room_list .= '<option value="'.$row->stock_room_id.'">'.$row->stock_room_name.'</option>';
				// echo $stock_room_list;
			}
		}
		$response['stock_rooms'] = $stock_room_list;
		echo json_encode($response);
	}

	public function get_to_stock_rooms()
	{
		$response = array();
		$stock_room_list = '<option value="">All</option>';
		$concern_id = $this->input->post('to_concern_id');
		$stock_rooms = $this->Packing_model->get_stock_rooms($concern_id);
		// print_r($stock_rooms);
		if(sizeof($stock_rooms) > 0)
		{
			foreach ($stock_rooms as $row) {
				$stock_room_list .= '<option value="'.$row->stock_room_id.'">'.$row->stock_room_name.'</option>';
			}
		}
		$response['stock_rooms'] = $stock_room_list;
		echo json_encode($response);
	}

	public function get_packing_boxes()
	{
		$filter = array();
		if($this->input->post('from_stock_room_id') != '')
		{
			$filter['stock_room_id'] = $this->input->post('from_stock_room_id');
		}
		$data['boxes'] = $this->Stocktrans_model->getPackingBoxes($filter);
		$this->load->view('includes/packing-boxes', $data);		
	}

	public function index()
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_sh_stocktransfer'");
		$next = $next->row(0);
		$data['new_dc_no'] = $next->Auto_increment;
		$dc_no = $next->Auto_increment;
		$data['dc_no'] = $dc_no;

		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'stocktrans';
		$data['page_title'] = 'Stock transfer in group';

		$data['suppliers_list'] = $this->Packing_model->get_suppliers();
		$data['item_groups'] = $this->Packing_model->get_item_groups();
		$data['items'] = $this->Packing_model->get_items();
		$data['shades'] = $this->Packing_model->get_shades();
		$data['uoms'] = $this->Packing_model->get_uoms();
		$data['stock_rooms'] = $this->Packing_model->get_stock_rooms();
		$data['concerns'] = $this->Stocktrans_model->get_concerns();
		$data['users'] = $this->Stocktrans_model->get_users();
		// echo "string";
		$this->load->view('stock-transfer', $data);
	}

	public function stocktrans_save()
	{
		$response = array();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('from_concern_id', 'From Concern', 'required');
		// $this->form_validation->set_rules('from_stock_room_id', 'From Stock Room', 'required');
		$this->form_validation->set_rules('from_user_id', 'From Staff', 'required');
		$this->form_validation->set_rules('to_concern_id', 'To Concern', 'required');
		// $this->form_validation->set_rules('to_stock_room_id', 'To Stock Room', 'required');
		$this->form_validation->set_rules('to_user_id[]', 'To Staff', 'required');
		$this->form_validation->set_rules('selected_boxes', 'Packing Boxes', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$response['error'] = validation_errors();
		}
		else
		{
			$save['id'] = 0;
			$save['transfer_date'] = date("Y-m-d H:i:s");
			$save['from_concern_id'] = $this->input->post('from_concern_id');
			$save['from_stock_room_id'] = $this->input->post('from_stock_room_id');
			$save['from_user_id'] = $this->input->post('from_user_id');
			$save['to_concern_id'] = $this->input->post('to_concern_id');
			$save['to_stock_room_id'] = $this->input->post('to_stock_room_id')==''?0:$this->input->post('to_stock_room_id');
			$save['to_user_id'] = implode(",", $this->input->post('to_user_id'));
			$save['selected_boxes'] = $this->input->post('selected_boxes');
			if($this->input->post('submit') == 'save')
			{
				$save['transfer_status'] = 1;
			}
			else
			{
				$save['transfer_status'] = 1;
			}
			$this->Stocktrans_model->save_stocktransfer($save);
			$response['success'] = 'Successfully saved';
		}

		echo json_encode($response);
	}

	public function transfer_list_data()
	{
		$data['dc_list'] = $this->Stocktrans_model->get_stocktransfer_list();
		$this->load->view('includes/transfer-list-data', $data);
	}

	public function accept_dc_form($id)
	{
		$response = array();
		if($id)
		{
			$data['id'] = $id;

			$concern_id = false;
			$shop_dc = $this->Stocktrans_model->get_stocktransfer_dc($id);
			if($shop_dc)
			{
				$concern_id = $shop_dc->to_concern_id;
			}
			$data['stock_rooms'] = $this->Packing_model->get_stock_rooms($concern_id);
			$data['page_title'] = 'Accept DC';
			$this->load->view('includes/accept-dc-form', $data);
		}
		else
		{
			$response['error'] = 'Record not found';
			json_encode($response);
		}
	}	

	public function accept_dc_save()
	{
		$response = array();
		$response['error'] = '';

		$id = $this->input->post('id');
		$to_stock_room_id = $this->input->post('to_stock_room_id');
		$shop_dc = $this->Stocktrans_model->get_stocktransfer_dc($id);

		if($shop_dc)
		{
			/*echo "<pre>";
			print_r($shop_dc);
			echo "</pre>";*/
			$selected_boxes = explode(",", $shop_dc->selected_boxes);
			if(count($selected_boxes) > 0)
			{
				foreach($selected_boxes as $box_id)
				{
					$box = $this->Stocktrans_model->getPackingBox($box_id);
					$inner_boxes = json_decode($box->inner_boxes);
					if(count($inner_boxes))
					{
						$no_cones = 0;
						foreach ($inner_boxes as $inner_box_id => $inner_box) {
							$i_box = $this->ak->thread_inner_box_details($inner_box_id);
							if(!$i_box)
							{
								$no_cones += $i_box->no_of_cones;
							}
						}
						$save_box['no_cones'] = $no_cones;
					}
					else
					{
						$save_box['no_cones'] = $box->no_of_cones + $box->no_of_cones_2;
					}
					$save_box['box_id'] = 0;
					$save_box['box_prefix'] = $box->box_prefix;
					$save_box['box_no'] = $box->box_no;
					$save_box['item_group_id'] = 0;
					$save_box['item_id'] = $box->item_id;
					$save_box['shade_id'] = $box->shade_no;
					if($box->box_prefix == 'G' || $box->box_prefix == 'S')
					{
						$save_box['lot_no'] = $box->poy_lot_no;
					}
					else
					{
						$save_box['lot_no'] = $box->lot_no;						
					}

					$save_box['no_boxes'] = $box->no_boxes;
					$save_box['gr_weight'] = $box->gross_weight;
					$save_box['nt_weight'] = $box->net_weight;
					$save_box['packed_on'] = date("Y-m-d H:i:s");
					$save_box['prepared_by'] = $this->session->userdata('user_id');
					$save_box['supplier_id'] = 0;
					$save_box['supplier_dc_no'] = 0;
					$save_box['uom_id'] = $box->item_uom;
					if($this->input->post('to_stock_room_id'))
					{
						$save_box['stock_room_id'] = $this->input->post('to_stock_room_id');						
					}
					else
					{
						$save_box['stock_room_id'] = $box->stock_room_id;						
					}

					$save_box['remarks'] = $box->remarks;
					$this->Packing_model->save_trans_packing($save_box);
					//Dynamic Dost 3.0- stock deletion from indofila unit when transfered
					$this->Packing_model->update_yt_packing($box_id);
					//End of Dynamic Dost 3.0- stock deletion from indofila unit when transfered
				}
			}

			$save['id'] = $this->input->post('id');
			$save['accepted_by'] = $this->session->userdata('user_id');
			$save['transfer_status'] = 2;
			$save['recieved_date'] = date("Y-m-d H:i:s");
			$save['recieved_remarks'] = $this->input->post('recieved_remarks');
			$this->Stocktrans_model->save_stocktransfer($save);
			$response['success'] = 'Successfully saved';
		}
		else
		{
			$response['error'] = 'Record not found';			
		}
		json_encode($response);			

	}

	public function update_dc_form($id)
	{
		$response = array();
		if($id)
		{
			$data['id'] = $id;

			$concern_id = false;
			$shop_dc = $this->Stocktrans_model->get_stocktransfer_dc($id);
			if($shop_dc)
			{
				$concern_id = $shop_dc->to_concern_id;
			}
			$data['stock_rooms'] = $this->Packing_model->get_stock_rooms($concern_id);

			$data['page_title'] = 'Accept DC';
			$this->load->view('includes/update-dc-form', $data);
		}
		else
		{
			$response['error'] = 'Record not found';
			json_encode($response);
		}
	}

	public function accept_dc_update()
	{
		$response = array();
		$response['error'] = '';

		$id = $this->input->post('id');
		$to_stock_room_id = $this->input->post('to_stock_room_id');
		$shop_dc = $this->Stocktrans_model->get_stocktransfer_dc($id);

		if($shop_dc)
		{
			/*echo "<pre>";
			print_r($shop_dc);
			echo "</pre>";*/
			$selected_boxes = explode(",", $shop_dc->selected_boxes);
			if(count($selected_boxes) > 0)
			{
				foreach($selected_boxes as $box_id)
				{
					$box = $this->Stocktrans_model->getPackingBox($box_id);
					$update_data['box_prefix'] = $box->box_prefix;
					$update_data['box_no'] = $box->box_no;
					if($this->input->post('to_stock_room_id'))
					{
						$update_data['stock_room_id'] = $this->input->post('to_stock_room_id');						
					}
					else
					{
						$update_data['stock_room_id'] = $box->stock_room_id;						
					}
					$this->Packing_model->update_trans_packing($update_data);
				}
			}
			$response['success'] = 'Successfully saved';
		}
		else
		{
			$response['error'] = 'Record not found';			
		}
		json_encode($response);	
	}

	public function accept_dc($pending_only = '')
	{
		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'accept_dc';
		$data['page_title'] = 'Stock transfer in group';
		$filter = array();
		if($pending_only)
		{
			$filter['transfer_status'] = 1;
		}
        $filter['to_user_id'] = $this->session->userdata('user_id');
		$filter['from_user_id'] = $this->session->userdata('user_id');
		// print_r($filter);
		$data['dc_list'] = $this->Stocktrans_model->get_stocktransfer_list($filter);
		// echo "string";
		$this->load->view('stock-transfer-list', $data);
	}

	public function print_shop_dc($id='')
	{
		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'accept_dc';
		$data['page_title'] = 'Print Stock transfer DC';
		$data['shop_dc'] = $this->Stocktrans_model->get_stocktransfer_dc($id);
		$this->load->view('print-shop-dc', $data);
	}

	public function delete_stocktransfer()
	{
		$response = array();
		if($this->input->post('id'))
		{
			$id = $this->input->post('id');
			$this->Stocktrans_model->remove_stocktransfer($id);
			$response['success'] = 'Successfully deleted';
		}
		else
		{
			$response['error'] = 'Record not found';
		}
		echo json_encode($response);
	}
}