<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tallyexport extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('m_users');
		$this->load->model('m_masters');
		$this->load->model('m_purchase');
		$this->load->model('m_production');
		$this->load->model('m_admin');
		$this->load->model('m_general');
		$this->load->model('m_delivery');
		$this->load->model('Tallyexport_model');
		if (!$this->session->userdata('logged_in')) {
			// Allow some methods?
			$allowed = array();
			if (!in_array($this->router->method, $allowed)) {
				redirect(base_url() . 'users/login', 'refresh');
			}
		}
	}
	function yt_invoices()
	{
		$data['activeTab'] = 'tallyexport';
		$data['activeItem'] = 'exp_yt_invoices';
		$data['page_title'] = 'Yarn & Thread Invoices';
		$data['invoices'] = $this->Tallyexport_model->get_yt_invoices();
		$this->load->view('yt-invoices', $data);
	}
}
