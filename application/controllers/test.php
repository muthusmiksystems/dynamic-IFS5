<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Test extends CI_Controller
{
    public $data = array();
    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Kolkata');
        $this->load->helper('url');
        $this->load->helper('string');
        $this->load->model('m_users');
        $this->load->model('m_masters');
        $this->load->model('m_purchase');
        $this->load->model('m_production');
        $this->load->model('m_general');
        $this->load->model('ak');
        $this->load->model('m_mycart'); //lbl PO & PS
        $this->load->model('m_mir'); //lbl PO & PS
        $this->load->model('m_admin'); //lbl PO & PS
        $this->load->library('cart');

        if (!$this->session->userdata('logged_in')) {
            // Allow some methods?
            $allowed = array();
            if (!in_array($this->router->method, $allowed)) {
                redirect(base_url() . 'users/login', 'refresh');
            }
        }

        $this->load->library('controllerlist');

        /*foreach ($this->controllerlist->getControllers() as $controller => $functions) {
            if($functions){
                foreach ($functions as $fkey => $fname) {
                    //print_r($controller);
                    //print_r($fname);
                    $data = array(
                        'upriv_controller' => $controller,
                        'upriv_function' => $fname
                    );
                    $this->ak->insert_new('bud_privileges', $data);
                }
            }
        }*/
    }

    function index()
    {

    }
}
