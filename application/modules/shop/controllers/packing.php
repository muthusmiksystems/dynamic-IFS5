<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Packing extends CI_Controller
{
	var $item_id = false;
	function __construct()
	{
		parent::__construct();
		$this->load->model('Packing_model');
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

	public function index()
	{
		/*$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_sh_packing'");
		$next = $next->row(0);*/
		$data['new_box_no'] = $this->Packing_model->getNextBoxNo('SH');
		$box_no = $this->Packing_model->getNextBoxNo('SH');
		$data['box_no'] = $box_no;

		$data['activeTab'] = 'shop';
		$data['activeItem'] = 'packing';
		$data['page_title'] = 'Shop Packing Entry';

		$data['suppliers_list'] = $this->Packing_model->get_suppliers();
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

	public function get_next_box_no()
	{
		/*$next = $this->db->query("SHOW TABLE STATUS LIKE 'bud_sh_packing'");
		$next = $next->row(0);
		$next_box_no = $next->Auto_increment;*/
		$next_box_no = $this->Packing_model->getNextBoxNo('SH');
		echo $next_box_no;
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

	public function packing_save()
	{
		$response = array();
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('supplier_id', 'Supplier', 'required');
		$this->form_validation->set_rules('supplier_dc_no', 'Supplier DC no', 'required');
		$this->form_validation->set_rules('item_group_id', 'Item group', 'required');
		$this->form_validation->set_rules('item_id', 'Item', 'required');
		$this->form_validation->set_rules('shade_id', 'Shade Name', 'required');
		$this->form_validation->set_rules('lot_no', 'Lot no', 'required');
		$this->form_validation->set_rules('no_boxes', 'No of boxes', 'required|numeric');
		$this->form_validation->set_rules('no_cones', 'No of cones', 'required|numeric');
		$this->form_validation->set_rules('gr_weight', 'Gross weight', 'required|numeric');
		$this->form_validation->set_rules('nt_weight', 'Net weight', 'required|numeric');
		$this->form_validation->set_rules('uom_id', 'UOM', 'required');
		$this->form_validation->set_rules('stock_room_id', 'Stock Room', 'required');

		if ($this->form_validation->run() == FALSE) {
			$response['error'] = validation_errors();
		} else {
			$save['box_id'] = '';
			$save['box_prefix'] = 'SH';
			// $save['box_no'] = $this->input->post('box_no');
			$save['box_no'] = $this->Packing_model->getNextBoxNo('SH');
			$save['item_group_id'] = $this->input->post('item_group_id');
			$save['item_id'] = $this->input->post('item_id');
			$save['shade_id'] = $this->input->post('shade_id');
			$save['lot_no'] = $this->input->post('lot_no');
			$save['no_boxes'] = $this->input->post('no_boxes');
			$save['no_cones'] = $this->input->post('no_cones');
			$save['gr_weight'] = $this->input->post('gr_weight');
			$save['nt_weight'] = $this->input->post('nt_weight');
			$save['packed_on'] = date("Y-m-d H:i:s");
			$save['prepared_by'] = $this->session->userdata('user_id');
			$save['supplier_id'] = $this->input->post('supplier_id');
			$save['supplier_dc_no'] = $this->input->post('supplier_dc_no');
			$save['uom_id'] = $this->input->post('uom_id');
			$save['stock_room_id'] = $this->input->post('stock_room_id');
			$save['remarks'] = $this->input->post('remarks');
			$this->Packing_model->save_packing($save);
			$response['success'] = 'Successfully saved';
			$response['submit'] = $this->input->post('submit');
		}
		echo json_encode($response);
	}

	public function packing_list_data()
	{
		$data['boxes'] = $this->Packing_model->get_shop_packings();
		$this->load->view('includes/packing-list-data', $data);
	}

	function print_pack_slip($box_id = null)
	{
		$data['box_id'] = $box_id;
		$data['js'] = array(
			'barcode/jquery-1.3.2.min.js',
			'barcode/jquery-barcode.js'
		);
		$data['box'] = $this->Packing_model->get_shop_box($box_id);
		$this->load->view('print-packing-slip.php', $data);
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
				$save['deleted_on'] = date("Y-m-d H:i:s");
				$save['deleted_remarks'] = $this->input->post('deleted_remarks');
				$this->Packing_model->save_packing($save);
				$response['success'] = 'Successfully saved';
			} else {
				$response['error'] = 'Wrong password';
			}
		}
		echo json_encode($response);
	}

	public function deleted_boxes()
	{
		$data['activeTab'] = 'admin';
		$data['activeItem'] = 'sh_deleted_boxes';
		$data['page_title'] = 'Shop Packing Entry';
		$data['boxes'] = $this->Packing_model->get_shop_deleted_boxes();
		$this->load->view('deleted-boxes', $data);
	}

	public function final_delete()
	{
		if ($this->input->post('submit')) {
			$selected_boxes = explode(",", $this->input->post('selected_boxes'));
			if (count($selected_boxes) > 0) {
				foreach ($selected_boxes as $box_id) {
					$save['box_id'] = $box_id;
					$save['final_deleted'] = 1;
					$this->Packing_model->save_packing($save);
				}
			}
			$this->session->set_flashdata('success', 'Successfully deleted');
			redirect(base_url('shop/packing/deleted_boxes'), 'refresh');
		} else {
			$this->session->set_flashdata('error', 'Record not found');
			redirect(base_url('shop/packing/deleted_boxes'), 'refresh');
		}
	}
}
