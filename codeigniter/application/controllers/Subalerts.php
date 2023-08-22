<?php
class Subalerts extends CI_Controller
{
	public function index($action = null, $id = null)
	{
		$data['title'] = 'Alerts';
		$data['main_alerts'] = $this->AlertModel->get_main_selectbox();

		if ($action != null) {

			$data['action'] = $action;
			$data['alert'] = $this->AlertModel->get_alert($id);

			if ($data['alert'] == null) {
				show_404();
			}

			$data['main'] = $data['alert']['main_alert'];
		} else {
			$data['action'] = false;
		}

		$this->load->view('_templates/dashboard/header', $data);
		$this->load->view('_templates/dashboard/sidebar');
		$this->load->view('alerts/subalerts', $data);
		$this->load->view('_templates/general/footer');
	}


	public function alert_list()
	{
		// POST data
		$postData = $this->input->post();
		// Get data
		$data = $this->AlertModel->get_all_alerts($postData);
		echo json_encode($data);
	}


	public function save_alert()
	{
		//form validation
		$this->form_validation->set_rules('main_alert', 'Main Alert', 'required');
		$this->form_validation->set_rules('alert_name', 'Alert Name', 'required');

		if($this->form_validation->run() == FALSE)
		{
			echo json_encode(array('status' => 'error', 'message' => validation_errors()));
			return;
		}

		$data = $this->AlertModel->add_alert();
		echo json_encode($data);
	}


	public function update_alert()
	{
		//form validation
		$this->form_validation->set_rules('main_alert', 'Main Alert', 'required');
		$this->form_validation->set_rules('alert_name', 'Alert Name', 'required');

		if($this->form_validation->run() == FALSE)
		{
			echo json_encode(array('status' => 'error', 'message' => validation_errors()));
			return;
		}

		$id = $this->input->post('alert_id');

		if ($id == null) {
			echo json_encode(array('status' => 'error', 'message' => 'Alert id is required.'));
			return;
		}

		$data = $this->AlertModel->update_alert($id);
		echo json_encode($data);
	}


	public function delete_alert()
	{
		$id = $this->input->post('alert_id');

		if ($id == null) {
			echo json_encode(array('status' => 'error', 'message' => 'Alert id is required.'));
			return;
		}

		$data = $this->AlertModel->delete_alert($id);
		echo json_encode($data);
	}


}
