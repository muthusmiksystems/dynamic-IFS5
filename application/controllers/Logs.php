<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Logs extends CI_Controller {
    
    public function view() {
        // Load the log file helper
        $this->load->helper('file');
        
        // Get the log file contents
        $log = read_file(APPPATH . 'logs/log-' . date('Y-m-d') . '.php');
        
        // Display the log file contents
        echo '<pre>' . $log . '</pre>';
    }
    
}