<?php
class Locations extends CI_Controller
{
	// ...Plants
	public function plants($action = null, $id = null)
	{
		$data['title'] = 'Plants';

		if ($action != null) {
			$data['plant'] = $this->LocationsModel->get_plants($id);
			$data['action'] = $action;
		}
		else
		{
			$data['action'] = false;
		}

		$this->load->view('_templates/dashboard/header', $data);
		$this->load->view('_templates/dashboard/sidebar');
		$this->load->view('locations/plants', $data);
		$this->load->view('_templates/general/footer');
	}


	public function plant_list()
	{
		// POST data
		$postData = $this->input->post();
		// Get data
		$data = $this->LocationsModel->get_all_plants($postData);
		echo json_encode($data);
	}


	public function save_plant()
	{
		$this->form_validation->set_rules('plant_name', 'Plant Name', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			echo json_encode(array('status' => 'error', 'message' => validation_errors()));
			return;
		}

		$response = $this->LocationsModel->add_plant();
		echo json_encode($response);
	}


	public function update_plant()
	{
		$this->form_validation->set_rules('plant_name', 'Plant Name', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			echo json_encode(array('status' => 'error', 'message' => validation_errors()));
			return;
		}

		$response = $this->LocationsModel->update_plant();
		echo json_encode($response);
	}


	public function delete_plant()
	{
		$id = $this->input->post('id');
		$response = $this->LocationsModel->delete_plant($id);
		echo json_encode($response);
	}




	// ...lines
	public function lines($action = null, $id = null)
	{
		$data['title'] = 'Lines';
		$data["plants"] = $this->LocationsModel->get_plants_selectbox();

		if ($action != null) {
			$data['line'] = $this->LocationsModel->get_line($id);
			$data['action'] = $action;
		}
		else
		{
			$data['action'] = false;
		}

		$this->load->view('_templates/dashboard/header', $data);
		$this->load->view('_templates/dashboard/sidebar');
		$this->load->view('locations/Lines', $data);
		$this->load->view('_templates/general/footer');
	}


	public function line_list()
	{
		// POST data
		$postData = $this->input->post();
		// Get data
		$data = $this->LocationsModel->get_all_lines($postData);
		echo json_encode($data);
	}


	public function save_line()
	{
		$response = $this->LocationsModel->add_line();
		echo json_encode($response);
	}


	public function update_line()
	{
		$id = $this->input->post('id');
		$plant_id = $this->input->post('plant_id');
		$name = $this->input->post('line_name');

		$response = $this->LocationsModel->update_line($id, $name, $plant_id);
		echo json_encode($response);
	}



	public function delete_line()
	{
		$id = $this->input->post('id');
		$response=$this->LocationsModel->delete_line($id);
		echo json_encode($response);
	}


	//fetching lines by plant id for ajax
	public function get_lines_by_plant_id()
	{
		$plant_id = $this->input->post('plant_id');
		$data = $this->LocationsModel->get_lines_by_plant_id($plant_id);
		echo json_encode($data);
	}




	// ...callback functions

	//usage: $this->form_validation->set_rules('field_name', 'Field Label', 'callback_edit_unique[table_name.field_name.current_record_id.custom_primary_key]');
	public function edit_unique($value, $params)
	{
		$this->load->database();
		$params = explode('.', $params);

		$table = $params[0]; // Table name
		$field = $params[1]; // Field name
		$current_id = $params[2]; // Current record ID
		$primary_key = $params[3]; // Custom primary key column name
		$company_id = $params[4]; // Custom client ID column name
		$session_company_id = $this->session->userdata('company_id');

		// Check if the value already exists in the table, excluding the current record
		$query = $this->db->select($field)
			->from($table)
			->where($field, $value)
			->where($company_id, $session_company_id)
			->where_not_in($primary_key, $current_id)
			->limit(1)
			->get();

		if ($query->num_rows() === 0) {
			// The value is unique, validation passes
			return true;
		} else {
			// The value already exists in the table, validation fails
			return false;
		}
	}





}
