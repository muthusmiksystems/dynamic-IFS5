<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registers extends CI_Controller {
	var $item_id = false;
	function __construct()
	{
		parent::__construct();
		$this->load->model('Packing_model');
		$this->load->model('Stocktrans_model');
		$this->load->model('Predelivery_model');
		$this->load->model('Delivery_model');
		$this->load->model('Cashinvoice_model');
		$this->load->model('Register_model');
		$this->load->model('Sales_model');
		$this->load->model('m_masters');
		$this->load->model('m_users');
		$this->load->model('m_mir');//ER-07-18#-24
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
	public function pre_delivery_boxes()
	{
		$data['activeTab'] = 'shop_registers';
		$data['activeItem'] = 'pre_delivery_boxes';
		$data['page_title'] = 'Shop Predelivery Boxes';
		$data['predc_boxes'] = $this->Predelivery_model->get_predc_boxes();
		$this->load->view('pre-delivery-boxes', $data);
	}
	public function delivery_boxes()//ER-10-18#-66
	{
		$data['activeTab'] = 'shop_registers';
		$data['activeItem'] = 'delivery_boxes';
		$data['page_title'] = 'Shop delivery Boxes';
		//ER-10-18#-66
		$data['item_id'] = 0;
		$data['cust_id'] = 0;
		$data['shade_code'] = 0;
		$data['dc_status']=0;
		$data['box_id']='';
		$data['dc_id']='';
		$data['f_date'] = date('Y-m-d',strtotime("-1 month"));
		$data['t_date'] = date('Y-m-d');
        $data['items'] = $this->m_masters->getactivemaster('bud_items', 'item_status');
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['dc_ids'] = $this->m_masters->getactivemaster('bud_sh_delivery', 'delivery_is_deleted');
		$data['dc_boxes'] = $this->m_masters->getallmaster('bud_sh_packing');
		$data['shades'] = $this->m_masters->getactivemaster('bud_shades', 'shade_status');
		if(isset($_POST['search']))
		{
			$data['item_id'] = $this->input->post('item_id');
			$data['cust_id'] = $this->input->post('cust_id');
			$data['f_date'] = $this->input->post('f_date');
			$data['t_date'] = $this->input->post('t_date');
			$data['shade_code']=$this->input->post('shade_code');
			$data['dc_status']=$this->input->post('dc_status');
			$data['box_id']=$this->input->post('box_id');
			$data['dc_id']=$this->input->post('dc_id');
		}
		$filter['item_id']=$data['item_id'];
		$filter['cust_id']=$data['cust_id'];	
		$filter['from_date']=$data['f_date'];
		$filter['to_date']=$data['t_date'];
		$filter['shade_code']=$data['shade_code'];
		$filter['dc_status']=$data['dc_status'];
		$filter['box_id']=$data['box_id'];
		$filter['dc_id']=$data['dc_id'];
		$data['boxes'] = $this->Register_model->get_delivery_boxes_reg($filter);
		//ER-10-18#-66
		$this->load->view('delivery-boxes', $data);
	}
	public function cash_inv_boxes()
	{
		$data['activeTab'] = 'shop_registers';
		$data['activeItem'] = 'cash_inv_boxes';
		$data['page_title'] = 'Shop Cash Invoice Boxes';
		$data['boxes'] = $this->Cashinvoice_model->get_cash_inv_boxes();
		$this->load->view('cash-invoice-boxes', $data);
	}
	public function credit_inv_boxes()
	{
		$data['activeTab'] = 'shop_registers';
		$data['activeItem'] = 'credit_inv_boxes';
		$data['page_title'] = 'Shop Credit Invoice Boxes';
		$data['boxes'] = $this->Sales_model->get_credit_inv_boxes();
		$this->load->view('credit-invoice-boxes', $data);
	}
	public function enquiry_boxes()
	{
		$data['activeTab'] = 'shop_registers';
		$data['activeItem'] = 'enquiry_boxes';
		$data['page_title'] = 'Shop Enquiry Boxes';
		$data['boxes'] = $this->Sales_model->get_enquiry_boxes();
		$this->load->view('enquiry-boxes', $data);
	}
	////box status register shop
	public function box_status()
	{
		$data['activeTab'] = 'shop_registers';
		$data['activeItem'] = 'box_status';
		$data['page_title'] = 'Shop Box Status';
		$data['f_box_no']=null;
		$data['t_box_no']=null;
		$data['box_no']=null;
		$data['box_prefix']=null;
		$box_no=array();
		if(isset($_POST['search']))
		{
			$data['f_box_no']=$this->input->post('from_box_no');
			$data['t_box_no']=$this->input->post('to_box_no');
			$data['box_no']=$this->input->post('box_no');
			$data['box_prefix']=$this->input->post('box_prefix');
			if($data['box_no'])
			{
				$box_no=explode(',',$data['box_no']);
			}
		}
		$data['box_detail'] = $this->Register_model->get_box_status($data['box_prefix'],$box_no,$data['f_box_no'],$data['t_box_no']);
		$this->load->view('v_box_status', $data);
	}
	//end of box status register shop
	//IRR Reports
	function irr_report_sh()
	{
		$data['activeTab'] = 'shop_registers';
		$data['activeItem'] = 'irr_report_sh';
		$data['page_title'] = 'IRR Report Shop';
		$data['catagory']='sh';
		$data['item_id'] = 0;
		$data['cust_id'] = 0;
		$data['shade_id'] = 0;
		$data['family_id'] = 0;
		$data['category_id'] = 0;
        $data['items'] = $this->m_masters->getactivemaster('bud_items', 'item_status');
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['shades'] = $this->m_masters->getactivemaster('bud_shades', 'shade_status');
		$data['shade_family'] = $this->m_masters->getactivemaster('bud_color_families', 'family_status');
		$data['shade_category'] = $this->m_masters->getallmaster('bud_color_category');
		if(isset($_POST['search']))
		{
			$data['item_id'] = $this->input->post('item_id');
			$data['cust_id'] = $this->input->post('cust_id');
			$data['shade_id'] = $this->input->post('shade_id');
			$data['family_id'] = $this->input->post('family_id');
			$data['category_id'] = $this->input->post('category_id');
		}
		$filter['item_id']=$data['item_id'];
		$filter['cust_id']=$data['cust_id'];	
		$filter['shade_id']=$data['shade_id'];
		$filter['family_id']=$data['family_id'];	
		$filter['category_id']=$data['category_id'];
		$data['irr_details']=$this->Register_model->get_irr_details($filter);

		$this->load->view('v_irr_report_sh', $data);
	}
	//End of IRR Reports
	function pdc_report_sh()//ER-07-18#-2
	{
		$data['activeTab'] = 'shop_registers';
		$data['activeItem'] = 'pdc_report_sh';
		$data['page_title'] = 'Predelivery Report Shop';
		$data['catagory']='sh';
		$data['item_id'] = 0;
		$data['cust_id'] = 0;
		$data['shade_code']=0;//ER-09-18#-51
		$data['f_date'] = date('Y-m-d',strtotime("-1 year"));
		$data['t_date'] = date('Y-m-d');
        $data['items'] = $this->m_masters->getactivemaster('bud_items', 'item_status');
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['shades'] = $this->m_masters->getactivemaster('bud_shades', 'shade_status');//ER-09-18#-51
		if(isset($_POST['search']))
		{
			$data['item_id'] = $this->input->post('item_id');
			$data['cust_id'] = $this->input->post('cust_id');
			$data['f_date'] = $this->input->post('f_date');
			$data['t_date'] = $this->input->post('t_date');
			$data['shade_code']=$this->input->post('shade_code');//ER-09-18#-51
		}
		$filter['item_id']=$data['item_id'];
		$filter['cust_id']=$data['cust_id'];	
		$filter['from_date']=$data['f_date'];
		$filter['to_date']=$data['t_date'];	
		$data['predc_list']=$this->Register_model->get_pdc_report_details($filter);
		$this->load->view('v_pdc_report_sh', $data);
	}
	function dc_report_sh()//ER-07-18#-4
	{
		$data['activeTab'] = 'shop_registers';
		$data['activeItem'] = 'dc_report_sh';
		$data['page_title'] = 'Delivery Report Shop';
		$data['catagory']='sh';
		$data['item_id'] = 0;
		$data['cust_id'] = 0;
		$data['shade_code'] = 0;//ER-09-18#-51
		$data['f_date'] = date('Y-m-d',strtotime("-1 month"));//ER-09-18#-51
		$data['t_date'] = date('Y-m-d');
        $data['items'] = $this->m_masters->getactivemaster('bud_items', 'item_status');
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['shades'] = $this->m_masters->getactivemaster('bud_shades', 'shade_status');//ER-09-18#-51
		if(isset($_POST['search']))
		{
			$data['item_id'] = $this->input->post('item_id');
			$data['cust_id'] = $this->input->post('cust_id');
			$data['f_date'] = $this->input->post('f_date');
			$data['t_date'] = $this->input->post('t_date');
			$data['shade_code']=$this->input->post('shade_code');//ER-09-18#-51
		}
		$filter['item_id']=$data['item_id'];
		$filter['cust_id']=$data['cust_id'];	
		$filter['from_date']=$data['f_date'];
		$filter['to_date']=$data['t_date'];	
		$data['delivery_list']=$this->Register_model->get_dc_report_details($filter);
		$this->load->view('v_dc_report_sh', $data);
	}
	function inv_report_sh()//ER-07-18#-23
	{
		$data['activeTab'] = 'shop_registers';
		$data['activeItem'] = 'inv_report_sh';
		$data['page_title'] = 'Invoice Report Shop';
		$data['catagory']='sh';
		$data['item_id'] = 0;
		$data['cust_id'] = 0;
		$data['status'] = 'all';
		$data['f_date'] = date('Y-m-d',strtotime("-1 year"));
		$data['t_date'] = date('Y-m-d');
        $data['items'] = $this->m_masters->getactivemaster('bud_items', 'item_status');
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['invoices_list']['cash']=array();
		$data['invoices_list']['credit']=array();
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
		$filter['status']=$data['status'];
		if($filter['status']!='credit'){
			$data['invoices_list']['cash']=$this->Register_model->get_cash_invoice_report($filter);
		}
		if($filter['status']!='cash'){
			$data['invoices_list']['credit']=$this->Register_model->get_credit_invoice_report($filter);
		}

		$this->load->view('v_inv_report_sh', $data);
	}
	function inward_report_sh()//ER-07-18#-24
	{
		$data['activeTab'] = 'shop_registers';
		$data['activeItem'] = 'inward_report_sh';
		$data['page_title'] = 'Stock Report- Branch wise-stock Room Wise';
		$data['catagory']='sh';
		$data['item_id'] = 0;
		$data['f_date'] = date('Y-m-d',strtotime("-1 month"));//ER-07-18#-25
		$data['t_date'] = date('Y-m-d');
		$data['shade_id']=null;//ER-07-18#-25
		$data['stock_room_id']=null;//ER-07-18#-25
		$data['stock_delivered']='all';//ER-07-18#-25
        $data['items'] = $this->m_masters->getactivemaster('bud_items', 'item_status');
        $data['shades'] = $this->m_masters->getactivemaster('bud_shades', 'shade_status');//ER-07-18#-25
        $data['stock_rooms'] = $this->m_masters->getactivemaster('bud_stock_rooms', 'stock_room_status');//ER-07-18#-25
		$data['box_detail']=array();
		if(isset($_POST['search']))
		{
			$data['item_id'] = $this->input->post('item_id');
			$data['f_date'] = $this->input->post('f_date');
			$data['t_date'] = $this->input->post('t_date');
			$data['shade_id']=$this->input->post('shade_id');//ER-07-18#-25
			$data['stock_room_id']=$this->input->post('stock_room_id');//ER-07-18#-25
			$data['stock_delivered']=$this->input->post('stock_delivered');//ER-07-18#-25
		}	
		$data['box_detail']=$this->m_mir->get_box_wise_inw_rep_sh($data['f_date'],$data['t_date'],0,$data['item_id'],$data['shade_id'],$data['stock_room_id']);//ER-07-18#-25
		$this->load->view('v_inward_report_sh', $data);
	}
	function enquiry_report_sh()//ER-08-18#-27
	{
		$data['activeTab'] = 'shop_registers';
		$data['activeItem'] = 'enquiry_report_sh';
		$data['page_title'] = 'Enquiry Report Shop';
		$data['catagory']='sh';
		$data['item_id'] = 0;
		$data['cust_id'] = 0;
		$data['f_date'] = date('Y-m-d',strtotime("-1 month"));
		$data['t_date'] = date('Y-m-d');
        $data['items'] = $this->m_masters->getactivemaster('bud_items', 'item_status');
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['invoices_list']=array();
		if(isset($_POST['search']))
		{
			$data['item_id'] = $this->input->post('item_id');
			$data['cust_id'] = $this->input->post('cust_id');
			$data['f_date'] = $this->input->post('f_date');
			$data['t_date'] = $this->input->post('t_date');
		}
		$filter['item_id']=$data['item_id'];
		$filter['cust_id']=$data['cust_id'];	
		$filter['from_date']=$data['f_date'];
		$filter['to_date']=$data['t_date'];	
		$data['invoices_list']=$this->Register_model->get_enq_report($filter);
		$this->load->view('v_enq_report_sh', $data);
	}
	function deleted_report_sh()//ER-08-18#-28
	{
		$data['activeTab'] = 'shop_registers';
		$data['activeItem'] = 'deleted_report_sh';
		$data['page_title'] = 'Deletion Report Shop';
		$data['catagory']='sh';
		$data['item_id'] = 0;
		$data['cust_id'] = 0;
		$data['status'] = '';
		$data['f_date'] = date('Y-m-d',strtotime("-1 month"));
		$data['t_date'] = date('Y-m-d');
        $data['items'] = $this->m_masters->getactivemaster('bud_items', 'item_status');
		$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
		$data['cash_invoices_list']=array();
		$data['cash_invoices_list']=array();
		$data['delivery_list']=array();
		$data['predelivery_list']=array();
		$data['enquiry_list']=array();
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
		switch ($data['status']) {
			case 'enquiry':
				$data['enquiry_list']=$this->Register_model->get_enq_report($filter,0);
				break;
			case 'cashinvoice':
				$data['cash_invoices_list']=$this->Register_model->get_cash_invoice_report($filter,0);
				break;
			case 'creditinvoice':
				$data['credit_invoices_list']=$this->Register_model->get_credit_invoice_report($filter,0);
				break;
			case 'delivery':
				$data['delivery_list']=$this->Register_model->get_dc_report_details($filter,0);
				break;
			case 'predelivery':
				$data['predelivery_list']=$this->Register_model->get_pdc_report_details($filter,0);
				break;
		}
		$this->load->view('v_deleted_report_sh', $data);
	}
}