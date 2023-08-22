<?php
class AlertModel extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}


	// alerts datatable server side processing alerts with sub alerts.
	public function get_all_alerts($postData = null)
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
			$searchQuery = " (alert_name like '%".$searchValue."%' or main_name like '%".$searchValue."%') ";
		}

		## Total number of records without filtering
		$this->db->select('count(*) as allcount');
		$this->db->join('main_alert', 'main_alert.main_id = alerts.main_alert', 'left');
		$this->db->where('alert_company_id', $company_id);//added
		$records = $this->db->get('alerts')->result();
		$totalRecords = $records[0]->allcount;


		## Total number of record with filtering
		$this->db->select('count(*) as allcount');
		$this->db->join('main_alert', 'main_alert.main_id = alerts.main_alert', 'left');

		if($searchQuery != '')
		{
			$this->db->where($searchQuery);
		}

		$this->db->where('alert_company_id', $company_id);//added

		$records = $this->db->get('alerts')->result();
		$totalRecordwithFilter = $records[0]->allcount;


		## Fetch records
		$this->db->select('*');
		$this->db->join('main_alert', 'main_alert.main_id = alerts.main_alert', 'left');
		if($searchQuery != '')
		{
			$this->db->where($searchQuery);
		}
		$this->db->where('alert_company_id', $company_id);//added
		$this->db->order_by($columnName, $columnSortOrder);
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get('alerts')->result();


		$data = array();

		foreach($records as $record ){

			$data[] = array(
				"alert_name"=>$record->alert_name,
				"main_name"=>$record->main_name,
				"actions"=>'<a href="'.base_url().'subalerts/update/'.$record->alert_id.'" class="btn btn-primary btn-sm item_edit" data-plant_id="'.$record->alert_id.'" data-plant_name="'.$record->alert_name.'">Edit</a>
				<a href="'.base_url().'subalerts/delete/'.$record->alert_id.'" class="btn btn-danger btn-sm item_delete" data-plant_id="'.$record->alert_id.'" data-plant_name="'.$record->alert_name.'">Delete</a>
				<a href="#" class="btn btn-secondary btn-sm details" data-plant_id="'.$record->alert_id.'" data-plant_name="'.$record->alert_name.'">Details</a>'
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



	// alerts datatable server side processing just main alerts.
	public function get_all_main($postData = null)
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
			$searchQuery = " (main_name like '%".$searchValue."%') ";
		}

		## Total number of records without filtering
		$this->db->select('count(*) as allcount');
		$this->db->where('main_company_id', $company_id);//added
		$records = $this->db->get('main_alert')->result();
		$totalRecords = $records[0]->allcount;


		## Total number of record with filtering
		$this->db->select('count(*) as allcount');

		if($searchQuery != '')
		{
			$this->db->where($searchQuery);
		}

		$this->db->where('main_company_id', $company_id);//added

		$records = $this->db->get('main_alert')->result();
		$totalRecordwithFilter = $records[0]->allcount;


		## Fetch records
		$this->db->select('*');

		if($searchQuery != '')
		{
			$this->db->where($searchQuery);
		}
		$this->db->where('main_company_id', $company_id);//added
		$this->db->order_by($columnName, $columnSortOrder);
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get('main_alert')->result();


		$data = array();

		foreach($records as $record ){

			if ($record->has_children == 1) {
				$record->has_children = 'Yes';
			} else {
				$record->has_children = 'No';
			}

			$data[] = array(
				"main_name"=>$record->main_name,
				"has_children"=>$record->has_children,
				"actions"=>'<a href="'.base_url().'alerts/update/'.$record->main_id.'" class="btn btn-primary btn-sm item_edit" data-plant_id="'.$record->main_id.'" data-plant_name="'.$record->main_name.'">Edit</a>
				<a href="'.base_url().'alerts/delete/'.$record->main_id.'" class="btn btn-danger btn-sm item_delete" data-plant_id="'.$record->main_id.'" data-plant_name="'.$record->main_name.'">Delete</a>
				<a href="#" class="btn btn-secondary btn-sm details" data-plant_id="'.$record->main_id.'" data-plant_name="'.$record->main_name.'">Details</a>'
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


	// get all main alerts for selectbox for subalert creation.
	public function get_main_selectbox()
	{
		$company_id = $this->session->userdata('data')['company_id'];

		$this->db->select('*');
		$this->db->where('has_children', 1);
		$this->db->where('main_company_id', $company_id);//added
		$query = $this->db->get('main_alert');
		return $query->result_array();
	}


	public function get_all()
	{
		$company_id = $this->session->userdata('data')['company_id'];

		$this->db->select('*');
		$this->db->where('main_company_id', $company_id);//added
		$query = $this->db->get('main_alert');
		return $query->result_array();
	}


	// save new main alert.
	public function add_main()
	{
		//check if checkbox is checked
		if($this->input->post('has_children') == 'on') {
			$has_children = 1;
		} else {
			$has_children = 0;
		}

		//check if main alert already exists
		$this->db->where('main_name', $this->input->post('main_name'));
		$this->db->where('main_company_id', $this->session->userdata('data')['company_id']);
		$query = $this->db->get('main_alert');

		if($query->num_rows() > 0) {//already exists.
			return array('status' => 'error', 'message' => 'Main alert already exists, please try again or edit the existing one.');
		}

		if($this->input->post('main_name') == '') {//empty name.
			return array('status' => 'error', 'message' => 'Main alert name is required.');
		}


		$data = array(
			'main_name' => $this->input->post('main_name'),
			'has_children'=> $has_children,
			'main_company_id' => $this->session->userdata('data')['company_id']
		);

		$this->db->insert('main_alert', $data);
		return array('status' => 'success', 'message' => 'Main alert added successfully with id: '.$this->db->insert_id());
	}



	//get main alert by id.
	public function get_main_alert($id)
	{
		$this->db->select('*');
		$this->db->where('main_id', $id);
		$query = $this->db->get('main_alert');
		return $query->row_array();
	}


	//update main alert.
	public function edit_main($id)
	{
		//check if checkbox is checked
		if($this->input->post('has_children') == 'on') {
			$has_children = 1;
		} else {
			$has_children = 0;
		}

		//check if main alert has children before updating.
		$this->db->select('*');
		$this->db->where('main_id', $id);
		$query_previous = $this->db->get('main_alert');
		$main_data = $query_previous->row_array();


		//check if main alert already exists
		$this->db->where('main_id !=', $id);
		$this->db->where('main_name', $this->input->post('main_name'));
		$this->db->where('main_company_id', $this->session->userdata('data')['company_id']);
		$query = $this->db->get('main_alert');


		if($query->num_rows() > 0) { //already exists.
			return array('status' => 'error', 'message' => 'Another main or parent alert has already been registered with that name.');
		}


		$data = array(
			'main_name' => $this->input->post('main_name'),
			'has_children'=> $has_children,
			'main_company_id' => $this->session->userdata('data')['company_id']
		);

		//update main alert
		$this->db->where('main_id', $id);
		$this->db->update('main_alert', $data);


		if ($has_children == 0) //didn't check the has children checkbox.
		{

			$children = $main_data['has_children'];

			if($children == 1)
			{
				//delete all alerts with main id
				$this->db->where('main_alert', $id);
				$this->db->delete('alerts');
			}
		}

		return array('status' => 'success', 'message' => 'Main alert updated successfully with id: '.$id);
	}


	//delete main alert.
	public function delete_main($id)
	{
		//delete all alerts with main id
		$this->db->where('main_alert', $id);
		$this->db->delete('alerts');

		//delete main alert
		$this->db->where('main_id', $id);
		$this->db->delete('main_alert');

		return array('status' => 'success', 'message' => 'Main alert and categories deleted successfully.');
	}


	/*
	 * SubAlerts
	*/

	public function add_alert()
	{
		//check if alert already exists
		$this->db->where('alert_name', $this->input->post('alert_name'));
		$this->db->where('main_alert', $this->input->post('main_alert'));
		$this->db->where('alert_company_id', $this->session->userdata('data')['company_id']);
		$query = $this->db->get('alerts');
		if($query->num_rows() > 0)
		{
			return array('status' => 'error', 'message' => 'Alert already exists, please try again or edit the existing one.');
		}


		$data = array(
			'alert_name' => $this->input->post('alert_name'),
			'main_alert'=> $this->input->post('main_alert'),
			'alert_company_id' => $this->session->userdata('data')['company_id']
		);

		$this->db->insert('alerts', $data);
		$alert =  $this->db->insert_id();

		return array('status' => 'success', 'message' => 'Alert added successfully with id: '.$alert);
	}


	public function get_alert($id)
	{
		$this->db->select('*');
		$this->db->join('main_alert', 'main_alert.main_id = alerts.main_alert', 'left');
		$this->db->where('alert_id', $id);
		$query = $this->db->get('alerts');
		return $query->row_array();
	}


	public function update_alert($id)
	{
		//check if alert already exists
		$this->db->where('alert_id !=', $id);
		$this->db->where('alert_name', $this->input->post('alert_name'));
		$this->db->where('main_alert', $this->input->post('main_alert'));
		$this->db->where('alert_company_id', $this->session->userdata('data')['company_id']);
		$query = $this->db->get('alerts');
		if($query->num_rows() > 0)
		{
			return array('status' => 'error', 'message' => 'Another alert has already been registered with that name.');
		}

		$data = array(
			'alert_name' => $this->input->post('alert_name'),
			'main_alert'=> $this->input->post('main_alert'),
			'alert_company_id' => $this->session->userdata('data')['company_id']
		);

		$this->db->where('alert_id', $id);
		$this->db->update('alerts', $data);

		return array('status' => 'success', 'message' => 'Alert updated successfully with id: '.$id);

	}


	public function delete_alert($id)
	{
		//delete alert
		$this->db->where('alert_id', $id);
		$this->db->delete('alerts');

		return array('status' => 'success', 'message' => 'Alert deleted successfully.');
	}



}
