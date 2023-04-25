<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Predelivery extends CI_Controller
{
	var $item_id = false;
	function __construct()
	{
		parent::__construct();
		$this->load->model('Packing_model');
		$this->load->model('Stocktrans_model');
		$this->load->model('Predelivery_model');
		$this->load->model('m_masters');
		$this->load->model('m_users');
		$this->load->model('m_purchase'); //ER-07-18#-1
		if (!$this->session->userdata('logged_in')) {
			// Allow some methods?
			$allowed = array();
			if (!in_array($this->router->method, $allowed)) {
				redirect(base_url() . 'users/login', 'refresh');
			}
		}
	}

	public function index($p_delivery_id = '')
	{
		$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_sh_predelivery'");
		$next = $next->row(0);
		$data['new_dc_no'] = $next->Auto_increment;
		$pre_dc_no = $next->Auto_increment;
		$data['pre_dc_no'] = $pre_dc_no;

		$data['p_delivery_id'] = '';
		$data['p_concern_id'] = '';
		$data['p_customer_id'] = '';
		$data['p_delivery_to'] = '';
		$data['name'] = '';
		$data['mobile_no'] = '';
		$data['remarks'] = '';

		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'predelivery';
		$data['page_title'] = 'Shop Pre Delivery';

		$data['from_date'] = date("d-m-Y", strtotime("-1 month"));
		$data['to_date'] = date("d-m-Y");

		// $data['boxes'] = $this->Predelivery_model->get_shop_packings(false, false);

		$data['suppliers_list'] = $this->Packing_model->get_suppliers();
		$data['item_groups'] = $this->Packing_model->get_item_groups();
		$data['items'] = $this->Packing_model->get_items();
		$data['shades'] = $this->Packing_model->get_shades();
		$data['uoms'] = $this->Packing_model->get_uoms();
		$data['stock_rooms'] = $this->Packing_model->get_stock_rooms();
		$data['concerns'] = $this->Stocktrans_model->get_concerns();
		$data['customers'] = $this->Predelivery_model->get_customers();
		// echo "string";

		if ($p_delivery_id) {
			$data['pre_dc_no'] = $p_delivery_id;
			$data['p_delivery_id'] = $p_delivery_id;
			$predc = $this->Predelivery_model->get_predc($p_delivery_id);
			if ($predc) {
				$data['p_concern_id'] = $predc->p_concern_id;
				$data['p_customer_id'] = $predc->p_customer_id;
				$data['p_delivery_to'] = $predc->p_delivery_to;
				$data['name'] = $predc->name;
				$data['mobile_no'] = $predc->mobile_no;
				$data['remarks'] = $predc->remarks;
			}
		}

		$this->load->view('pre-delivery', $data);
	}

	public function get_next_pdc_no($p_delivery_id = '')
	{
		if ($p_delivery_id) {
			echo $p_delivery_id;
		} else {
			$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_sh_predelivery'");
			$next = $next->row(0);
			$pre_dc_no = $next->Auto_increment;
			// $pre_dc_no = $this->Predelivery_model->get_next_pre_dc_no();
			echo $pre_dc_no;
		}
	}

	public function packing_list_search()
	{
		// print_r($_POST);
		$filter = array();
		$filter['from_date'] = $this->input->post('from_date');
		$filter['to_date'] = $this->input->post('to_date');
		$filter['item_id'] = $this->input->post('item_id');
		$filter['shade_id'] = $this->input->post('shade_id');
		$filter['stock_room_id'] = $this->input->post('stock_room_id');
		$filter['item_group_id'] = $this->input->post('item_group_id');
		$data['boxes'] = $this->Predelivery_model->get_shop_packings(false, false, $filter);
		$this->load->view('includes/pre-del-packing-list-data', $data);
	}

	public function packing_list_data()
	{
		$data['boxes'] = $this->Predelivery_model->get_shop_packings(false, false);
		$this->load->view('includes/pre-del-packing-list-data', $data);
	}

	public function get_stock_rooms()
	{
		$response = array();
		$stock_room_list = '<option value="">Select</option>';
		$concern_id = $this->input->post('concern_id');
		$stock_rooms = $this->Packing_model->get_stock_rooms($concern_id);
		// print_r($stock_rooms);
		if (sizeof($stock_rooms) > 0) {
			foreach ($stock_rooms as $row) {
				$stock_room_list .= '<option value="' . $row->stock_room_id . '">' . $row->stock_room_name . '</option>';
				// echo $stock_room_list;
			}
		}
		$response['stock_rooms'] = $stock_room_list;
		echo json_encode($response);
	}

	public function add_to_cart()
	{
		if ($this->input->post('selected_boxes')) {
			$selected_boxes = explode(",", $this->input->post('selected_boxes'));
			if (count($selected_boxes) > 0) {
				foreach ($selected_boxes as $box_id) {
					$box = $this->Predelivery_model->get_shop_box($box_id);
					if ($box) {
						$cart_item['row_id'] = 0;
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

						// $bal_qty = $box->nt_weight - $box->tot_delivery_qty;
						$tot_pk_qty = (($box->box_prefix == 'TH') || ($box->box_prefix == 'TH')) ? $box->no_cones : $box->nt_weight; //ER-07-18#-6//ER-08-18#-42
						$bal_qty = $tot_pk_qty - ($box->tot_predc_temp_qty + $box->tot_predc_qty); //ER-07-18#-6

						$cart_item['nt_weight'] = $box->nt_weight;
						$cart_item['delivery_qty'] = $bal_qty;
						$cart_item['cart_user_id'] = $this->session->userdata('user_id');
						$this->Predelivery_model->add_to_cart($cart_item);
					}
				}
			}
		}
	}

	public function add_predc_row()
	{
		$box_id = false;
		$box = false;
		$response = array();
		if ($this->input->post('barcode_no')) {
			$barcode_no = explode("-", $this->input->post('barcode_no'));
			if (count($barcode_no) > 1) {
				$box_id = $barcode_no[1];
			} else {
				$box_id = $barcode_no[0];
			}

			if ($box_id) {
				$box = $this->Predelivery_model->get_shop_box($box_id);
				if ($box) {
					$bal_qty = $box->nt_weight - ($box->tot_predc_temp_qty + $box->tot_predc_qty);
					if ($bal_qty > 0) {
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

						// $bal_qty = $box->nt_weight - $box->tot_delivery_qty;
						$tot_pk_qty = (($box->box_prefix == 'TH') || ($box->box_prefix == 'TH')) ? $box->no_cones : $box->nt_weight; //ER-07-18#-6//ER-08-18#-42
						$bal_qty = $tot_pk_qty - ($box->tot_predc_temp_qty + $box->tot_predc_qty); //ER-07-18#-6

						$cart_item['nt_weight'] = $bal_qty;
						$cart_item['delivery_qty'] = $bal_qty;
						$cart_item['cart_user_id'] = $this->session->userdata('user_id');
						$this->Predelivery_model->add_to_cart($cart_item);
						$response['success'] = 'Item Successfully added';
					}
				} else {
					$response['error'] = 'Box not found';
				}
			} else {
				$response['error'] = 'Record not found';
			}
		} else {
			$response['error'] = 'Record not found';
		}

		echo json_encode($response);
		// echo $box_id;
	}

	public function remove_to_cart()
	{
		if ($this->input->post('row_id')) {
			$row_id = $this->input->post('row_id');
			$this->Predelivery_model->remove_to_cart($row_id);
		}
	}

	public function remove_all_item()
	{
		$this->Predelivery_model->remove_all_cart();
	}
	public function update_cart_item()
	{
		if ($this->input->post('row_id')) {
			$row_id = $this->input->post('row_id');
			$delivery_qty = $this->input->post('delivery_qty');
			$cart_item['row_id'] = $row_id;
			$cart_item['delivery_qty'] = $this->input->post('delivery_qty');
			// $this->Predelivery_model->remove_to_cart($row_id);
			$this->Predelivery_model->add_to_cart($cart_item);
		}
	}

	public function cart_temp_items($p_delivery_id = '', $coneornetwt = 1)
	{
		$data['predc_items'] = array();
		$data['coneornetwt'] = $coneornetwt;
		if ($p_delivery_id) {
			$data['predc_items'] = $this->Predelivery_model->get_predc_items($p_delivery_id);
		}
		$data['cart_items'] = $this->Predelivery_model->get_cart_temp_items($this->session->userdata('user_id'));
		
		$this->load->view('includes/predel-cart-temp-items', $data);
	}

	public function get_costomer()
	{
		$response = array();
		$response['name'] = '';
		$response['mobile_no'] = '';
		if ($this->input->post('p_customer_id')) {
			$customer = $this->Predelivery_model->get_customer($this->input->post('p_customer_id'));
			if ($customer) {
				$cust_contacts = explode("|", $customer->cust_contacts);
				$cust_contacts = array_filter($cust_contacts);
				if (count($cust_contacts) > 0) {
					if (count($cust_contacts) > 1) {
						if (isset($cust_contacts[1])) {
							$contacts = explode("##", $cust_contacts[1]);
							$response['name'] = $contacts[0];
							$response['mobile_no'] = $contacts[1];
						}
					} else {
						if (isset($cust_contacts[0])) {
							$contacts = explode("##", $cust_contacts[0]);
							print_r($contacts);
							$response['name'] = $contacts[0];
							$response['mobile_no'] = $contacts[1];
						}
					}
				}
			}
		}
		echo json_encode($response);
	}

	public function save_predelivery($p_delivery_id = '')
	{
		// print_r($_POST);
		$response = array();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('p_concern_id', 'Concern Name', 'required');
		$this->form_validation->set_rules('p_customer_id', 'Party Name', 'required');
		if ($this->form_validation->run() == FALSE) {
			$response['error'] = validation_errors();
		} else {
			if ($p_delivery_id) {
				$save['p_delivery_id'] = $p_delivery_id;
			} else {
				$save['p_delivery_id'] = 0;
			}
			$p_concern_id = $this->input->post('p_concern_id');
			$p_dc_no = $this->Predelivery_model->get_next_pre_dc_no($p_concern_id);
			$save['p_concern_id'] = $this->input->post('p_concern_id');
			$save['p_dc_no'] = $p_dc_no;
			$save['p_delivery_date'] = date("Y-m-d H:i:s");
			$save['p_customer_id'] = $this->input->post('p_customer_id');
			$save['p_delivery_to'] = $this->input->post('p_delivery_to');
			$save['name'] = $this->input->post('name');
			$save['mobile_no'] = $this->input->post('mobile_no');
			$save['remarks'] = $this->input->post('remarks');

			$predc_items = $this->input->post('predc_items');

			$cart_items = $this->Predelivery_model->get_cart_temp_items($this->session->userdata('user_id'));

			$p_delivery_id = $this->Predelivery_model->save_predc($save, $cart_items, $predc_items);
			$response['p_delivery_id'] = $p_delivery_id;
		}
		echo json_encode($response);
	}

	public function predc_list()
	{
		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'predc_list';
		$data['page_title'] = 'Shop Pre Delivery List';
		$data['predc_list'] = $this->Predelivery_model->get_predc_list();
		$this->load->view('pre-delivery-list', $data);
	}
	public function predc_edit()
	{
		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'predc_edit';
		$data['page_title'] = 'Shop Pre Delivery List';
		$data['predc_list'] = $this->Predelivery_model->get_predc_list();
		$this->load->view('pre-delivery-edit', $data);
	}

	public function predc_edit_form()
	{
		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'predc_edit';
		$data['page_title'] = 'Shop Pre Delivery Edit';
		$data['predc_list'] = $this->Predelivery_model->get_predc_list();
		$this->load->view('pre-delivery-edit', $data);
	}
	function predelivery_delete() //ER-07-18#-1
	{
		$p_delivery_id = $this->input->post("p_delivery_id");
		$remarks = $this->input->post("remarks");
		if ($p_delivery_id) {
			$result = $this->Predelivery_model->update_delete_status_predelivery_sh($p_delivery_id, $remarks);
		}
		echo ($result) ? $p_delivery_id . ' Successfully Deleted' : 'Error in Deletion';
	}
	public function print_predelivery($p_delivery_id)
	{
		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'predelivery';
		$data['page_title'] = 'Shop Pre Delivery';
		$data['predc'] = $this->Predelivery_model->get_predc($p_delivery_id);
		$this->load->view('print-pre-delivery', $data);
	}

	public function tranfer_delivery()
	{
	}

	public function save_delivery()
	{
	}

	public function print_quotation()
	{
		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'quotation';
		$data['page_title'] = 'Shop Print Quotation';
		$this->load->view('print-quotation', $data);
	}
	public function print_credit_invoice()
	{
		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'print_credit_invoice';
		$data['page_title'] = 'Shop Credit Invoice';
		$this->load->view('print-invoice', $data);
	}

	public function edit_stock_room($box_id = '')
	{
		$data['box_id'] = $box_id;
		$data['box'] = $this->Packing_model->get_shop_box($box_id);
		$data['stock_rooms'] = $this->Packing_model->get_stock_rooms();
		$this->load->view('includes/edit-stock-room', $data);
	}
	public function update_stock_room()
	{
		$response = array();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('box_id', 'Box', 'required');
		$this->form_validation->set_rules('stock_room_id', 'Stock Rooms', 'required');
		if ($this->form_validation->run() == FALSE) {
			$response['error'] = validation_errors();
		} else {
			$save['box_id'] = $this->input->post('box_id');
			$save['stock_room_id'] = $this->input->post('stock_room_id');
			$this->Packing_model->save_packing($save);
			$response['success'] = 'Successfully saved';
		}
		echo json_encode($response);
	}
}
