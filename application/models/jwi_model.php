<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Jwi_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Get all coaches
	 *
	 * @access public
	 * @return object all coaches
	 */
	function get()
	{
		return $this->db->get('bud_jwi_mst')->result();
	}

	/**
	 * get invoice no
	 *
	 * @access public
	 * @return object account object
	 */

	function generate_invoice()
	{
		$this->db->select('jwi_invoice_no');
		$this->db->from('bud_jwi_mst');
		$this->db->limit(1);
		$this->db->order_by('bud_jwi_mst.jwi_id', 'DESC');
		$query = $this->db->get();
		return $query->row();
	}


	/* get data from jwi_model */
	function get_job_work_invoice()
	{
		$this->db->select('*');
		$this->db->from('bud_jwi_mst a');
		$this->db->join('bud_jwi_details b', 'a.jwi_id = b.jwi_mst_id', 'INNER');
		$this->db->join('bud_customers c', 'a.jwi_customer_id = c.cust_id', 'INNER');
		$this->db->where('a.jwi_status', '1');
		$query = $this->db->get();
		return $query->result_array();
	}

	/* get count data from jwi_model */
	function get_count_job_work_invoice()
	{
		$this->db->select('*,sum(jwi_detail_amount) as amount,sum(jwi_detail_quantity) as qty');
		$this->db->from('bud_jwi_mst a');
		$this->db->join('bud_jwi_details b', 'a.jwi_id = b.jwi_mst_id', 'INNER');
		$this->db->join('bud_customers c', 'a.jwi_customer_id = c.cust_id', 'INNER');
		$this->db->where('a.jwi_status', '1');
		$this->db->group_by('a.jwi_id');
		$query = $this->db->get();
		return $query->result_array();
	}

	/* get data from jwi_model by id */
	function get_job_work_invoice_by_id($id)
	{
		$this->db->select('*');
		$this->db->from('bud_jwi_mst a');
		$this->db->join('bud_jwi_details b', 'a.jwi_id = b.jwi_mst_id', 'INNER');
		$this->db->join('bud_customers c', 'a.jwi_customer_id = c.cust_id', 'INNER');
		$this->db->where('a.jwi_status', '1');
		$this->db->where('a.jwi_id', $id);
		$query = $this->db->get();
		return $query->result_array();
	}

	function get_jobwork_invoice($jwi_id)
	{
		$this->db->select('bud_jwi_mst.*');
		$this->db->select('bud_concern_master.*');
		$this->db->select('bud_customers.cust_name,bud_customers.cust_address,bud_customers.cust_gst,bud_customers.cust_city'); //ER-07-18#-11
		$this->db->join('bud_concern_master', 'bud_jwi_mst.concern_id=bud_concern_master.concern_id', 'left');
		$this->db->join('bud_customers', 'bud_jwi_mst.jwi_customer_id=bud_customers.cust_id', 'left');
		$this->db->where('bud_jwi_mst.jwi_id', $jwi_id);
		return $this->db->get('bud_jwi_mst')->row();
	}
	function get_jobwork_inv_items($jwi_id = '')
	{
		$this->db->where('bud_jwi_details.jwi_mst_id', $jwi_id);
		return $this->db->get('bud_jwi_details')->result();
	}

	function save_jwi($save)
	{
		if ($save['jwi_id']) {
			$this->db->where('jwi_id', $save['jwi_id']);
			$this->db->update('bud_jwi_mst', $save);
			return $save['jwi_id'];
		} else {
			$this->db->insert('bud_jwi_mst', $save);
			return $this->db->insert_id();
		}
	}
}


/* End of file coach_model.php */
/* Location: ./application/account/models/coach_model.php */
