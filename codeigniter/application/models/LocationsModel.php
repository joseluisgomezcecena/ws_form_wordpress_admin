<?php
class LocationsModel extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}

	public function get_plants_selectbox()
	{
		$company_id = $this->session->userdata('data')['company_id'];

		$this->db->select('*');
		$this->db->from('plants');
		$this->db->where('plant_company_id', $company_id);
		$query = $this->db->get();
		return $query->result_array();
	}


	public function get_all_plants($postData = null)
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
			//$searchQuery = " (plant_name like '%".$searchValue."%' or email like '%".$searchValue."%' or city like'%".$searchValue."%' ) ";
			$searchQuery = " (plant_name like '%".$searchValue."%' AND plant_company_id = '".$company_id."' ) ";
		}

		## Total number of records without filtering
		$this->db->select('count(*) as allcount');
		$this->db->where('plant_company_id', $company_id);//added
		$records = $this->db->get('plants')->result();
		$totalRecords = $records[0]->allcount;


		## Total number of record with filtering
		$this->db->select('count(*) as allcount');

		if($searchQuery != '')
		{
			$this->db->where($searchQuery);
		}

		$this->db->where('plant_company_id', $company_id);//added

		$records = $this->db->get('plants')->result();
		$totalRecordwithFilter = $records[0]->allcount;


		## Fetch records
		$this->db->select('*');

		if($searchQuery != '')
		{
			$this->db->where($searchQuery);
		}

		$this->db->where('plant_company_id', $company_id);//added

		$this->db->order_by($columnName, $columnSortOrder);
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get('plants')->result();


		$data = array();

		foreach($records as $record ){

			$data[] = array(
				"plant_id"=>$record->plant_id,
				"plant_name"=>$record->plant_name,
				"actions"=>'<a href="'.base_url().'plants/update/'.$record->plant_id.'" class="btn btn-edit item_edit" data-plant_id="'.$record->plant_id.'" data-plant_name="'.$record->plant_name.'">Edit</a>
				<a href="'.base_url().'plants/delete/'.$record->plant_id.'" class="btn btn-delete item_delete" data-plant_id="'.$record->plant_id.'" data-plant_name="'.$record->plant_name.'">Delete</a>'
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


	public function get_plants($id = null)
	{
		$company_id = $this->session->userdata('data')['company_id'];

		if($id === null)
		{
			$this->db->select('*');
			$this->db->from('plants');
			$this->db->where('plant_company_id', $company_id);
			$query = $this->db->get();
			return $query->result_array();
		}
		else
		{
			$query = $this->db->get_where('plants', array('plant_id' => $id, 'plant_company_id' => $company_id));
			return $query->row_array();
		}
	}


	public function add_plant()
	{
		//check if plant name already exists
		$company_id = $this->session->userdata('data')['company_id'];
		$plant_name = $this->input->post('plant_name');

		$this->db->select('*');
		$this->db->from('plants');
		$this->db->where('plant_name', $plant_name);
		$this->db->where('plant_company_id', $company_id);
		$query = $this->db->get();
		$result = $query->result_array();

		if(count($result) > 0){
			return array('status' => 'error', 'message' => "Plant name already exists.");
		}//finished checking.


		//insert plant.
		$data = array(
			'plant_name' => $plant_name,
			'plant_company_id' => $company_id,
		);
		$query =  $this->db->insert('plants', $data);

		if ($query){
			return array('status' => 'success', 'message' => "Plant added successfully.");
		}else{
			return array('status' => 'error', 'message' => validation_errors());
		}
	}



	public function update_plant()
	{
		$id = $this->input->post('id');
		$company_id = $this->session->userdata('data')['company_id'];
		$plant_name = $this->input->post('plant_name');

		//check if plant name already exists.
		$this->db->select('*');
		$this->db->from('plants');
		$this->db->where('plant_name', $plant_name);
		$this->db->where('plant_company_id', $company_id);
		$this->db->where_not_in('plant_id', $id);
		$query = $this->db->get();
		$result = $query->result_array();

		if(count($result) > 0){
			return array('status' => 'error', 'message' => "Plant name already exists.");
		}//finished checking.

		$data = array(
			'plant_name' => $plant_name,
			'plant_company_id' => $company_id,
		);
		
		$this->db->where('plant_id', $id);
		$query =  $this->db->update('plants', $data);

		if ($query){
			return array('status' => 'success', 'message' => "Plant updated successfully.");
		}else{
			return array('status' => 'error', 'message' => validation_errors());
		}
	}


	
	public function delete_plant($id)
	{
		$company_id = $this->session->userdata('data')['company_id'];

		$this->db->where( array("plant_id" => $id, "plant_company_id" => $company_id) );
		$query = $this->db->delete('plants');


		//delete all lines and stations in this plant.
		$this->db->select('*');
		$this->db->from('cells');
		$this->db->where('plant_id', $id);
		$this->db->where('cell_company_id', $company_id);
		$query = $this->db->get();
		$cells = $query->result_array();

		foreach ($cells as $station_line_id)
		{
			$this->db->where( array("station_line_id" => $station_line_id['cell_id'], "station_company_id" => $company_id) );
			$query = $this->db->delete('station_lines');
		}

		$this->db->where( array("plant_id" => $id, "cell_company_id" => $company_id) );
		$query = $this->db->delete('cells');


		if ($query){
			return array('status' => 'success', 'message' => "Plant deleted successfully, all lines and stations in this plant have also been deleted.");
		}else{
			return array('status' => 'error', 'message' => validation_errors());
		}

	}






	//...Lines
	public function get_lines_selectbox($plant_id = null)
	{
		$company_id = $this->session->userdata('data')['company_id'];

		if ($plant_id != null)
		{
			$this->db->where('plant_id', $plant_id);
		}

		$this->db->select('*');
		$this->db->from('cells');
		$this->db->where('cell_company_id', $company_id);
		$query = $this->db->get();
		return $query->result_array();
	}


	public function get_all_lines($postData = null)
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
			$searchQuery = " (line_name like '%".$searchValue."%' or plants.plant_name like '%".$searchValue."%' ) ";
		}

		## Total number of records without filtering
		$this->db->select('count(*) as allcount');
		$this->db->join('plants', 'plants.plant_id = cells.plant_id', 'left');
		$this->db->where('cell_company_id', $company_id);
		$records = $this->db->get('cells')->result();
		$totalRecords = $records[0]->allcount;


		## Total number of record with filtering
		$this->db->select('count(*) as allcount');
		$this->db->join('plants', 'plants.plant_id = cells.plant_id', 'left');
		if($searchQuery != '')
		{
			$this->db->where($searchQuery);
		}
		$this->db->where('cell_company_id', $company_id);//added
		$records = $this->db->get('cells')->result();
		$totalRecordwithFilter = $records[0]->allcount;


		## Fetch records
		$this->db->select('*');

		if($searchQuery != '')
		{
			$this->db->where($searchQuery);
		}
		$this->db->join('plants', 'plants.plant_id = cells.plant_id', 'left');
		$this->db->where('cell_company_id', $company_id);//added

		$this->db->order_by($columnName, $columnSortOrder);
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get('cells')->result();


		$data = array();

		foreach($records as $record){

			$data[] = array(
				"line_name"=>$record->line_name,
				"plant_name"=>$record->plant_name,
				"actions"=>'<a href="'.base_url().'lines/update/'.$record->line_id.'" class="btn btn-edit  item_edit" data-plant_id="'.$record->line_id.'" data-plant_name="'.$record->line_name.'">Edit</a>
				<a href="'.base_url().'lines/delete/'.$record->line_id.'" class="btn btn-delete  item_delete" data-plant_id="'.$record->line_id.'" data-plant_name="'.$record->line_name.'">Delete</a>'
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


	public function get_line($id)
	{
		$company_id = $this->session->userdata('data')['company_id'];
		$query = $this->db->get_where('cells', array('line_id' => $id, 'cell_company_id' => $company_id));
		#$lastQuery = $this->db->last_query();
		//print_r($lastQuery);
		return $query->row_array();
	}


	public function add_line()
	{
		$data = array(
			'plant_id' => $this->input->post('plant_id'),
			'line_name' => $this->input->post('line_name'),
			'cell_company_id' => $this->session->userdata('data')['company_id'],
		);
		$query =  $this->db->insert('cells', $data);
		if ($query){
			return array('status' => 'success', 'message' => "Line added successfully.");
		}else{
			return array('status' => 'error', 'message' => validation_errors());
		}
	}


	public function update_line($id, $name, $plant_id)
	{
		$data = array(
			'line_name' => $name,
			'plant_id' => $plant_id,
		);

		$this->db->where('line_id', $id);
		$query = $this->db->update('cells', $data);
		if ($query){
			return array('status' => 'success', 'message' => "Line updated successfully.");
		}else{
			return array('status' => 'error', 'message' => validation_errors());
		}

	}


	public function delete_line($id)
	{
		$company_id = $this->session->userdata('data')['company_id'];

		$this->db->where( array("station_line_id" => $id, "station_company_id" => $company_id) );
		$query = $this->db->delete('work_station');

		if (!$query)
		{
			return array('status' => 'error', 'message' => validation_errors());
		}
		else
		{
			$this->db->where( array("line_id" => $id, "cell_company_id" => $company_id) );
			$query = $this->db->delete('cells');

			if ($query){
				return array('status' => 'success', 'message' => "Line deleted successfully, all stations in this line will also be deleted.");
			}else{
				return array('status' => 'error', 'message' => validation_errors());
			}
		}
	}


	//get lines by plant id
	public function get_lines_by_plant_id($plant_id)
	{
		$company_id = $this->session->userdata('data')['company_id'];
		$this->db->select('*');
		$this->db->from('cells');
		$this->db->where('plant_id', $plant_id);
		$this->db->where('cell_company_id', $company_id);
		$query = $this->db->get();
		return $query->result_array();
	}



}
