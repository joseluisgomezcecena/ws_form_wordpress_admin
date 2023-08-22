<?php
class Alerts extends CI_Controller
{
	public function index($action = null, $id = null)
	{
		$data['title'] = 'Alerts';
		$data['main_alerts'] = $this->AlertModel->get_main_selectbox();

		if ($action != null) {
			$data['action'] = $action;
			$data['alert'] = $this->AlertModel->get_main_alert($id);

			if($data['alert'] == null)
			{
				show_404();
			}
		}
		else
		{
			$data['action'] = false;
		}

		$this->load->view('_templates/dashboard/header', $data);
		$this->load->view('_templates/dashboard/sidebar');
		$this->load->view('alerts/alerts', $data);
		$this->load->view('_templates/general/footer');
	}




	public function main_list()
	{
		// POST data
		$postData = $this->input->post();
		// Get data
		$data = $this->AlertModel->get_all_main($postData);
		echo json_encode($data);
	}


	public function get_main_selectbox()
	{
		$data = $this->AlertModel->get_main_selectbox();
		echo json_encode($data);
	}


	public function save_main()
	{
		$data = $this->AlertModel->add_main();
		echo json_encode($data);
	}


	public function update_main()
	{
		$id = $this->input->post('main_id');

		if ($id == null) {
			echo json_encode(array('status' => 'error', 'message' => 'Main alert id is required.'));
			return;
		}

		if ($this->input->post('main_name') == '') {
			echo json_encode(array('status' => 'error', 'message' => 'Main or parent alert is required.'));
			return;
		}


		$data = $this->AlertModel->edit_main($id);
		echo json_encode($data);
	}


	public function delete_main()
	{

		$id = $this->input->post('main_id');

		if ($id == null) {
			echo json_encode(array('status' => 'error', 'message' => 'Main alert id is required.'));
			return;
		}

		$data = $this->AlertModel->delete_main($id);
		echo json_encode($data);
	}




}
