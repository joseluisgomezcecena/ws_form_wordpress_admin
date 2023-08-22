<?php
class AndonModel extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}

	public function get_alerts($company_id = FALSE)
	{
		if($company_id === FALSE)
		{
			$query = $this->db->get('alerts');
			return $query->result_array();
		}

		$query = $this->db->get_where('alerts', array('company_id' => $company_id));
		return $query->result_array();
	}

	//chartjs
	public function get_alerts_by_month($company_id = FALSE)
	{
		$this->db->select('COUNT(*) as count, MONTHNAME(date) as month');
		$this->db->from('alerts');
		$this->db->where('company_id', $company_id);
		$this->db->group_by('MONTH(date)');
		$query = $this->db->get();
		return $query->result_array();
	}

}
