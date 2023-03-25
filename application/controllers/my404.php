<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class my404 extends CI_Controller
{
	public $data = array();
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$data['css'] = array('css/bootstrap.min.css', 'css/bootstrap-reset.css', 'assets/font-awesome/css/font-awesome.css', 'css/style.css', 'css/style-responsive.css');
		$data['js_IE'] = array('js/html5shiv.js', 'js/respond.min.js');
		$this->load->view('v_404.php', $data);
	}
}

/* End of file my404.php */
/* Location: ./application/controllers/my404.php */
