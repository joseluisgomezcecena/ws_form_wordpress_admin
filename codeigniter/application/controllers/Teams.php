<?php
class Teams extends CI_Controller
{
	public function index($action = null, $id = null)
	{
		$data['title'] = 'Teams';
	    $data['users'] = $this->UserModel->get_all();
		$data['alerts'] = $this->AlertModel->get_all();

		if ($action != null) {

			$data['action'] = $action;
			$data['team'] = $this->TeamModel->get_team($id);

			if ($data['team'] == null) {
				show_404();
			}

			$data['plant'] = $data['team']['plant_id'];
		} else {
			$data['action'] = false;
		}

		$this->load->view('_templates/dashboard/header', $data);
		$this->load->view('_templates/dashboard/sidebar');
		$this->load->view('teams/index', $data);
		$this->load->view('_templates/general/footer');
	}


	public function save()
	{
		//form validation.
		$this->form_validation->set_rules('team_name', 'Team Name', 'required');
		$this->form_validation->set_rules('team_user', 'Team Members', 'required');
		$this->form_validation->set_rules('alerts', 'Responsibilities', 'required');


		if ($this->form_validation->run() == FALSE)
		{
			echo json_encode(array('status' => 'error', 'message' => validation_errors()));
			return;
		}

		$data = $this->TeamModel->add_team();
		echo json_encode($data);
	}


	public function update()
	{
		//form validation.
		$this->form_validation->set_rules('team_name', 'Team Name', 'required');
		$this->form_validation->set_rules('team_user', 'Team Members', 'required');
		$this->form_validation->set_rules('alerts', 'Responsibilities', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			echo json_encode(array('status' => 'error', 'message' => validation_errors()));
			return;
		}

		$data = $this->TeamModel->update_team();
		echo json_encode($data);
	}


	public function delete()
	{
		$data = $this->TeamModel->delete_team();
		echo json_encode($data);
	}




}
