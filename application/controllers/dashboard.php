<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public $data = array();
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->model('m_users');
		$this->load->model('m_masters');
		$this->load->model('m_purchase');
		/*echo '<pre>';
		print_r($this->session->userdata); 
		echo '</pre>';*/
		if (!$this->session->userdata('logged_in')) {
			// Allow some methods?
			$allowed = array();
			if (!in_array($this->router->method, $allowed)) {
				redirect(base_url() . 'users/login', 'refresh');
			}
		}
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
	function index()
	{
		$data['activeTab'] = 'dashboard';
		$data['activeItem'] = 'dashboard';
		$data['css'] = array('css/bootstrap.min.css', 'css/bootstrap-reset.css', 'assets/font-awesome/css/font-awesome.css', 'assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css', 'css/owl.carousel.css', 'css/style.css', 'css/style-responsive.css');
		$data['js_IE'] = array('js/html5shiv.js', 'js/respond.min.js');
		$data['js'] = array('js/jquery.js', 'js/jquery-1.8.3.min.js', 'js/bootstrap.min.js', 'js/jquery.scrollTo.min.js', 'js/jquery.nicescroll.js', 'js/jquery.sparkline.js', 'assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js', 'js/owl.carousel.js', 'js/jquery.customSelect.min.js');
		$data['js_common'] = array('js/common-scripts.js');
		$data['js_thispage'] = array('js/sparkline-chart.js', 'js/easy-pie-chart.js');
		//if ($this->session->userdata('logged_as') == 'user') {
		$this->load->view('v_dashboard.php', $data);
		// } else {
		// 	$this->load->view('v_dashboard_vc.php', $data);
		// }
	}
	function categorieshome()
	{
		$this->session->set_userdata('user_viewed', $this->uri->segment(3));
		redirect(base_url());
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
