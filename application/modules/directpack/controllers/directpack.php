<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Directpack extends CI_Controller
{
	var $item_id = false;
	function __construct()
	{
		parent::__construct();
		$this->load->model('shop/Packing_model');
		$this->load->model('shop/Stocktrans_model');
		$this->load->model('shop/Predelivery_model');
		$this->load->model('Directpack_model');
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
	public function lot_list_data()
	{
		$data['lot_list'] = $this->Directpack_model->get_lots();
		$this->load->view('includes/lot-list-data', $data);
	}
	public function lot_form($lot_id = '')
	{
		$data['activeTab'] = 'packing';
		$data['activeItem'] = 'lot_form';
		$data['page_title'] = 'Direct Lot Entry';
		$data['lot_list'] = array();
		$data['lot_id'] = $lot_id;
		$data['machines'] = $this->Directpack_model->get_machines(true);
		$data['items'] = $this->Directpack_model->get_items(true);
		$data['shades'] = $this->Directpack_model->get_shades(true);
		$this->load->view('lot-form', $data);
	}
	public function lot_save($lot_id = '')
	{
		$response = array();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('machine_id', 'Machine', 'required');
		$this->form_validation->set_rules('item_id', 'Item', 'required');
		$this->form_validation->set_rules('shade_id', 'Shade', 'required');
		$this->form_validation->set_rules('oil_required', 'Oil Required', 'required|numeric');
		$this->form_validation->set_rules('no_springs', 'No Springs', 'required|numeric');
		$this->form_validation->set_rules('lot_qty', 'Lot Qty', 'required|numeric');
		if ($this->form_validation->run() == FALSE) {
			$response['error'] = validation_errors();
		} else {
			$new_lot_id = false;
			$machine_prefix = '';
			$next_lot_id = '';

			$machine = $this->Directpack_model->get_machine($this->input->post('machine_id'));
			if ($machine) {
				$machine_prefix = $machine->machine_prefix;
			}

			if ($lot_id) {
				$next_lot_id = $lot_id;
			} else {
				$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_lots'");
				$next = $next->row(0);
				$next_lot_id = $next->Auto_increment;
			}
			$lot_no = $machine_prefix . $next_lot_id;

			$save['lot_id'] = $lot_id;
			$save['lot_prefix'] = $this->input->post('machine_id');
			$save['lot_no'] = $lot_no;
			$save['lot_shade_no'] = $this->input->post('shade_id');
			$save['lot_item_id'] = $this->input->post('item_id');
			$save['lot_oil_required'] = $this->input->post('oil_required');
			$save['lot_qty'] = $this->input->post('lot_qty');
			$save['lot_actual_qty'] = $this->input->post('lot_qty');
			$save['lot_status'] = 1;
			$save['no_springs'] = $this->input->post('no_springs');
			$save['lot_created_date'] = date("Y-m-d H:i:s");
			$save['lot_month'] = date("m-y H:i:s"); //tot direct lot qty correction
			$save['direct_entry'] = 1;

			$new_lot_id = $this->Directpack_model->save_lot($save);
			if ($new_lot_id) {
				$dlc_packing_items['id'] = '';
				$dlc_packing_items['lot_id'] = $new_lot_id;
				$dlc_packing_items['no_springs'] = $this->input->post('no_springs');
				$dlc_packing_items['no_springs_hold'] = 0;
				$dlc_packing_items['net_weight'] = $this->input->post('lot_qty');
				$dlc_packing_items['net_weight_hold'] = 0;
				$this->Directpack_model->save_dlc_packing_items($dlc_packing_items);
			}

			$response['success'] = 'Succcessfully Saved';
		}
		echo json_encode($response);
	}

	public function get_lot_list()
	{
		$filter = array();
		if ($this->input->post('shade_id')) {
			$filter['shade_id'] = $this->input->post('shade_id');
		}
		if ($this->input->post('item_id')) {
			$filter['item_id'] = $this->input->post('item_id');
		}
		$lots = $this->Directpack_model->get_lots($filter);

		// print_r($lots);

		$options = '<option value="">Select</option>';
		if (sizeof($lots) > 0) {
			foreach ($lots as $row) {
				$options .= '<option value="' . $row->lot_id . '">' . $row->lot_no . '</option>';
			}
		}
		echo $options;
	}

	function get_lot_qty($lot_id = false)
	{
		$this->load->model('m_purchase');
		$return = array();
		$lot_qty = 0.000;
		$tot_packed_qty = 0.000;
		$tot_balancd_qty = 0.000;
		$lot_shade_no = '';
		$percentage = 0;
		if (!empty($lot_id)) {
			// $lot = $this->m_masters->get_lot($lot_id);
			$lot = $this->m_masters->get_lot_details($lot_id);
			// print_r($lot);
			if ($lot) {
				$items = $this->m_purchase->get_dlc_lot_qty($lot_id);
				if (sizeof($items) > 0) {
					foreach ($items as $item) {
						$lot_qty += $item->net_weight;
					}
				}
				// $lot_qty = $lot->lot_actual_qty;
				$lot_shade_no = $lot->lot_shade_no;

				$return['item_name'] = $lot->item_name;
				$return['item_id'] = $lot->item_id;
				$return['cust_name'] = $lot->cust_name;
				$return['shade_code'] = $lot->shade_code;
				$return['shade_name'] = $lot->shade_name;
			}

			$pack_qty = $this->m_masters->get_lot_pack_qty($lot_id);
			if ($pack_qty) {
				if ($pack_qty->tot_packed_qty > 0) {
					$tot_packed_qty = $pack_qty->tot_packed_qty;
				}
			}
		}
		$tot_balancd_qty = $lot_qty - $tot_packed_qty;

		$return['lot_qty'] = number_format($lot_qty, 3, '.', '');
		$return['tot_packed_qty'] = number_format($tot_packed_qty, 3, '.', '');
		$return['tot_balancd_qty'] = number_format($tot_balancd_qty, 3, '.', '');
		$return['lot_shade_no'] = $lot_shade_no;
		echo json_encode($return);
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
	public function get_next_box_no()
	{
		$next_box_no = $this->Directpack_model->getNextBoxNo('DIR');
		echo $next_box_no;
	}
	public function packing_list_data()
	{
		$data['boxes'] = $this->Directpack_model->get_direct_packings();
		$this->load->view('includes/packing-list-data', $data);
	}

	public function packing_entry()
	{
		/*$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_sh_packing'");
		$next = $next->row(0);*/
		$box_no = $this->Directpack_model->getNextBoxNo('DIR');
		$data['new_box_no'] = $box_no;
		$data['box_no'] = $box_no;

		$data['activeTab'] = 'packing';
		$data['activeItem'] = 'direct_packing';
		$data['page_title'] = 'Direct Packing Entry';
		$data['lot_qty'] = '0';
		$data['tot_packed_qty'] = '0';
		$data['tot_balancd_qty'] = '0';

		$data['lot_list'] = $this->Directpack_model->get_lots();
		$data['item_groups'] = $this->Packing_model->get_item_groups();
		$data['items'] = $this->Packing_model->get_items();
		$data['shades'] = $this->Packing_model->get_shades();
		$data['uoms'] = $this->Packing_model->get_uoms();
		$data['concerns'] = $this->Packing_model->get_concerns();
		$data['stock_rooms'] = array();
		// $data['stock_rooms'] = $this->Packing_model->get_stock_rooms();
		// echo "string";
		$this->load->view('packing-entry', $data);
	}
	public function packing_save()
	{
		$response = array();
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('lot_id', 'Lot no', 'required');
		$this->form_validation->set_rules('item_id', 'Item', 'required');
		$this->form_validation->set_rules('shade_id', 'Shade Name', 'required');
		$this->form_validation->set_rules('no_boxes', 'No of boxes', 'required|numeric');
		$this->form_validation->set_rules('no_cones', 'No of cones', 'required|numeric');
		$this->form_validation->set_rules('gr_weight', 'Gross weight', 'required|numeric');
		$this->form_validation->set_rules('nt_weight', 'Net weight', 'required|numeric');
		$this->form_validation->set_rules('stock_room_id', 'Stock Room', 'required');
		$this->form_validation->set_rules('manual_lot_no', 'Manual Lot Qty', 'required');
		if ($this->form_validation->run() == FALSE) {
			$response['error'] = validation_errors();
		} else {
			$save['box_id'] = null;
			$save['box_prefix'] = 'DIR';
			$save['box_no'] = $this->Directpack_model->getNextBoxNo('DIR');
			$save['item_id'] = $this->input->post('item_id');
			$save['shade_no'] = $this->input->post('shade_id');
			$save['lot_no'] = $this->input->post('lot_id');
			$save['lot_month'] = $this->m_masters->getmasterIDvalue(' bud_lots', 'lot_id', $save['lot_no'], 'lot_month');
			$save['manual_lot_no'] = $this->input->post('manual_lot_no');
			$save['no_boxes'] = $this->input->post('no_boxes');
			$save['no_cones'] = $this->input->post('no_cones');
			$save['no_of_cones'] = $this->input->post('no_cones');
			$save['gross_weight'] = $this->input->post('gr_weight');
			$save['net_weight'] = $this->input->post('nt_weight');
			$save['packed_date'] = date("Y-m-d H:i:s");
			// $save['packed_time'] = date("H:i:s");
			$save['packed_by'] = $this->session->userdata('user_id');
			$save['stock_room_id'] = $this->input->post('stock_room_id');
			$save['remarks'] = $this->input->post('remarks');
			$save['prod_date'] = $this->input->post('prod_date'); //ER-07-18#-26
			$this->Directpack_model->save_packing($save);
			$response['success'] = 'Successfully saved';
			$response['submit'] = $this->input->post('submit');
		}
		echo json_encode($response);
	}

	function print_pack_slip($box_id = null)
	{
		$data['box_id'] = $box_id;
		$data['js'] = array(
			'barcode/jquery-1.3.2.min.js',
			'barcode/jquery-barcode.js'
		);
		$data['box'] = $this->Directpack_model->get_direct_pack_box($box_id);
		$this->load->view('print-packing-slip', $data);
	}
	public function confirm_delete($box_id = '')
	{
		$data['box_id'] = $box_id;
		$this->load->view('includes/confirm-delete-form', $data);
	}

	public function confirm_delete_save()
	{
		$response = array();
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('box_id', 'Box', 'required');
		$this->form_validation->set_rules('deleted_remarks', 'Remarks', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		if ($this->form_validation->run() == FALSE) {
			$response['error'] = validation_errors();
		} else {
			$username = $this->session->userdata('user_login');
			$password = $this->input->post('password');
			$login = $this->m_users->check_login($username, $password);
			if ($login) {
				$save['box_id'] = $this->input->post('box_id');
				$save['is_deleted'] = 1;
				$save['deleted_by'] = $this->session->userdata('user_id');
				$save['deleted_time'] = date("Y-m-d H:i:s");
				$save['remarks'] = $this->input->post('deleted_remarks');
				$this->Directpack_model->save_packing($save);
				$response['success'] = 'Successfully saved';
			} else {
				$response['error'] = 'Wrong password';
			}
		}
		echo json_encode($response);
	}
}
