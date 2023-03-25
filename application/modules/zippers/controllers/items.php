<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Items extends CI_Controller {
	var $item_id = false;
	function __construct()
	{
		parent::__construct();
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

	public function index()
	{
		echo "string";
	}
}