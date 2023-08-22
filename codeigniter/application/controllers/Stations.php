<?php
class Stations extends CI_Controller
{
	public function index($action = null, $id = null)
	{
		$data['title'] = 'Work Stations';
		$data["plants"] = $this->LocationsModel->get_plants_selectbox();
		$data['lines'] = $this->LocationsModel->get_lines_selectbox();


		if ($action != null) {
			$station = $data['station'] = $this->StationModel->get_stations($id);
			$data['action'] = $action;
			$data['lines'] = $this->LocationsModel->get_lines_selectbox($station['plant_id']);

			if($data['station'] == null)
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
		$this->load->view('stations/index', $data);
		$this->load->view('_templates/general/footer');
	}


	public function station_list()
	{
		// POST data
		$postData = $this->input->post();
		// Get data
		$data = $this->StationModel->get_all_stations($postData);
		echo json_encode($data);
	}


	public function get_stations()
	{
		$id = $this->input->post('id');
		$data = $this->StationModel->get_stations($id);
		echo json_encode($data);
	}


	public function save_station()
	{
		$this->StationModel->add_station();
		echo json_encode(array('status' => true));
	}


	public function update_station()
	{
		$id = $this->input->post('id');
		$station_name = $this->input->post('station_name');
		$station_control_number = $this->input->post('station_control_number');
		$station_serial = $this->input->post('station_serial');
		$station_location = $this->input->post('station_location');
		$station_line_id = $this->input->post('line_id');

		$this->StationModel->update_station($id, $station_name, $station_control_number, $station_serial, $station_location, $station_line_id);
		echo json_encode(array('status' => true));
	}



	public function delete_station()
	{
		$id = $this->input->post('id');
		$this->StationModel->delete_station($id);
		echo json_encode(array('status' => true));
	}



}
