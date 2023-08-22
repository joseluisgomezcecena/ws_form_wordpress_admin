<?php
class StationModel extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}

	public function get_station_selectbox($line = null)
	{
		$company_id = $this->session->userdata('data')['company_id'];

		if ($line != null)
		{
			$this->where('station_line_id', $line);
		}
		$this->db->select('*');
		$this->db->from('plants');
		$this->db->where('plant_company_id', $company_id);
		$query = $this->db->get();
		return $query->result_array();
	}


	public function get_all_stations($postData = null)
	{
		$company_id = $this->session->userdata('data')['company_id'];

		$response = array();
		## Read value
		$draw = $postData['draw'];
		$start = $postData['start'];
		$rowperpage = $postData['length']; // Rows display per page
		$columnIndex = $postData['order'][0]['column']; // Column index
		$columnName = $postData['columns'][$columnIndex]['data']; // Column name
		$columnSortOrder = $postData['order'][0]['dir']; // asc or desc
		$searchValue = $postData['search']['value']; // Search value

		## Search
		$searchQuery = "";

		if($searchValue != '')
		{
			$searchQuery = " (station_name like '%".$searchValue."%' or station_serial like '%".$searchValue."%' or station_control_number like'%".$searchValue."%' or station_line_id like'%".$searchValue."%' ) ";
		}

		## Total number of records without filtering
		$this->db->select('count(*) as allcount');
		$this->db->where('station_company_id', $company_id);//added
		$records = $this->db->get('work_station')->result();
		$totalRecords = $records[0]->allcount;


		## Total number of record with filtering
		$this->db->select('count(*) as allcount');

		if($searchQuery != '')
		{
			$this->db->where($searchQuery);
		}

		$this->db->where('station_company_id', $company_id);//added

		$records = $this->db->get('work_station')->result();
		$totalRecordwithFilter = $records[0]->allcount;


		## Fetch records
		$this->db->select('*');

		if($searchQuery != '')
		{
			$this->db->where($searchQuery);
		}

		$this->db->where('station_company_id', $company_id);//added

		$this->db->order_by($columnName, $columnSortOrder);
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get('work_station')->result();


		$data = array();

		foreach($records as $record ){

			$data[] = array(
				"station_name"=>$record->station_name,
				"station_control_number"=>$record->station_control_number,
				"station_serial"=>$record->station_serial,
				"station_line_id"=>$record->station_line_id,
				"actions"=>'<a href="'.base_url().'stations/update/'.$record->station_id.'" class="btn btn-primary btn-sm item_edit" data-plant_id="'.$record->station_id.'" data-plant_name="'.$record->station_name.'">Edit</a>
				<a href="'.base_url().'stations/delete/'.$record->station_id.'" class="btn btn-danger btn-sm item_delete" data-plant_id="'.$record->station_id.'" data-plant_name="'.$record->station_name.'">Delete</a>
				<a href="#" class="btn btn-secondary btn-sm details" data-plant_id="'.$record->station_id.'" data-plant_name="'.$record->station_name.'">Details</a>'
			);
		}

		## Response
		$response = array(
			"draw" => intval($draw),
			"iTotalRecords" => $totalRecords,
			"iTotalDisplayRecords" => $totalRecordwithFilter,
			"aaData" => $data
		);

		return $response;
	}


	public function get_stations($id=null)
	{
		$company_id = $this->session->userdata('data')['company_id'];

		if ($id != null )
		{
			$this->db->select('*');
			$this->db->from('work_station');
			$this->db->join('cells', 'cells.line_id = work_station.station_line_id', 'left');
			$this->db->join('plants', 'plants.plant_id = cells.plant_id', 'left');
			$this->db->where('station_id', $id);

			$query = $this->db->get();

			//$query = $this->db->get_where('work_station', array('station_id' => $id, 'station_company_id' => $company_id));
			return $query->row_array();
		}
		else
		{
			$query = $this->db->get_where('work_station', array('station_company_id' => $company_id));
			return $query->result_array();
		}
	}

	public function add_station()
	{
		$data = array(
			'station_line_id' => $this->input->post('line_id'),
			'station_name' => $this->input->post('station_name'),
			'station_serial' => $this->input->post('station_serial'),
			'station_control_number' => $this->input->post('station_control_number'),
			'station_company_id' => $this->session->userdata('data')['company_id'],
			'station_location'=>$this->input->post('station_location'),
		);
		$query =  $this->db->insert('work_station', $data);

		if ($query)
		{
			return array('status' => 'success', 'message' => "Station added successfully.");
		}
		else
		{
			return array('status' => 'error', 'message' => validation_errors());
		}
	}


	public function update_station($id, $station_name, $station_control_number, $station_serial, $station_location, $station_line_id)
	{
		$data = array(
			'station_name' => $station_name,
			'station_control_number' => $station_control_number,
			'station_serial' => $station_serial,
			'station_location' => $station_location,
			'station_line_id' => $station_line_id,
		);
		$this->db->where('station_id', $id);
		$query = $this->db->update('work_station', $data);

		if ($query)
		{
			return array('status' => 'success', 'message' => "Station updated successfully.");
		}
		else
		{
			return array('status' => 'error', 'message' => validation_errors());
		}
	}


	public function delete_station($id)
	{
		$this->db->where('station_id', $id);
		$query = $this->db->delete('work_station');

		if ($query)
		{
			return array('status' => 'success', 'message' => "Station deleted successfully.");
		}
		else
		{
			return array('status' => 'error', 'message' => validation_errors());
		}

	}

}
