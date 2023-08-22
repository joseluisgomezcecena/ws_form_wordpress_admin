<?php
class TeamModel extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}

	public function get_team($id = null)
	{
		if ($id == null) {
			$query = $this->db->get('teams');
			return $query->result_array();
		} else {
			$query = $this->db->get_where('teams', array('id' => $id));
			return $query->row_array();
		}
	}

	public function add_team()
	{
		$company_id = $this->session->userdata('data')['company_id'];
		//save checkboxes if they are checked with a value of 1 if not checked then 0.
		$escalation1 = $this->input->post('escalation1');
		$escalation1 = $escalation1 == null ? 0 : 1;

		$escalation2 = $this->input->post('escalation2');
		$escalation2 = $escalation2 == null ? 0 : 1;

		$escalation3 = $this->input->post('escalation3');
		$escalation3 = $escalation3 == null ? 0 : 1;

		$escalation4 = $this->input->post('escalation4');
		$escalation4 = $escalation4 == null ? 0 : 1;

		$data = array(
			'team_name' => $this->input->post('team_name'),
			'escalation1' => $escalation1,
			'escalation2' => $escalation2,
			'escalation3' => $escalation3,
			'escalation4' => $escalation4,
			'team_company_id' => $company_id,
		);

		$this->db->insert('teams', $data);
		$team_id = $this->db->insert_id();

		//saving team members.

		//saving select2 values.
		foreach ($this->input->post('team_members') as $team_member) {
			$data = array(
				'team_id' => $team_id,
				'user_id' => $team_member,
				'tu_company_id' => $company_id,
			);
			$this->db->insert('team_members', $data);
		}


		//saving alerts.
		foreach ($this->input->post('alerts') as $alert) {
			$data = array(
				'team' => $team_id,
				'main' => $alert,
				'team_alert_company_id' => $company_id,
			);
			$this->db->insert('team_alert', $data);
		}

	}

	public function get_team_by_plant($plant_id)
	{
		$query = $this->db->get_where('teams', array('plant_id' => $plant_id));
		return $query->result_array();
	}

	public function get_team_by_station($station_id)
	{
		$query = $this->db->get_where('teams', array('station_id' => $station_id));
		return $query->result_array();
	}

	public function get_team_by_user($user_id)
	{
		$query = $this->db->get_where('teams', array('user_id' => $user_id));
		return $query->result_array();
	}

	public function get_team_by_user_and_plant($user_id, $plant_id)
	{
		$query = $this->db->get_where('teams', array('user_id' => $user_id, 'plant_id' => $plant_id));
		return $query->result_array();
	}

	public function get_team_by_user_and_station($user_id, $station_id)
	{
		$query = $this->db->get_where('teams', array('user_id' => $user_id, 'station_id' => $station_id));
		return $query->result_array();
	}

	public function get_team_by_user_and_plant_and_station($user_id, $plant_id, $station_id)
	{
		$query = $this->db->get_where('teams', array('user_id' => $user_id, 'plant_id' => $plant_id, 'station_id' => $station_id));
		return $query->result_array();
	}

	public function get_team_by_plant_and_station($plant_id, $station_id)
	{
		$query = $this->db->get_where('teams', array('plant_id' => $plant_id, 'station_id' => $station_id));
		return $query->result_array();
	}

}
