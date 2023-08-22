<?php
class Dashboards extends CI_Controller {

	public function index() 
	{
		$data['title'] = 'Dashboard';
		//$data['company_db'] = $this->session->userdata('data')['company_db'];


		if ($this->session->userdata('data') ['staff'] == 1)
		{
			$data['staff'] = 1;
			#echo "staff";

			/* RELEVANT TABLES.
			 * wpxw_wsf_submit_meta
			 * wsf_field
			 *
			 */

			//load all databases.
			$databases = array('adminsystemsmx', 'drcarlosochoa',);
			$db_count = $data['database_count'] = count($databases);
			$counter = 0;

			foreach ($databases as $db_name)
			{
				// Increment the counter.
				$counter++;

				$this->$db_name = $this->load->database($db_name, TRUE);

				if ($this->$db_name) {

					$this->db->select('*');
					$this->db->from('client_company');
					$this->db->where('company_db', $db_name);
					$query = $this->db->get();

					/*
					$last_query = $this->db->last_query();
					print_r($last_query);
					*/

					$result = $query->row_array();


					$account = $result['company_name'];
					$table_prefix = $result['db_prefix'];
					//$table_prefix = $this->session->userdata('data')['db_prefix'];


					$this->$db_name->select('*');
					$this->$db_name->from($table_prefix . 'wsf_submit_meta');
					$this->$db_name->join($table_prefix . 'wsf_field', $table_prefix . 'wsf_field.id = ' . $table_prefix . 'wsf_submit_meta.field_id', 'left');
					$this->$db_name->where($table_prefix . 'wsf_submit_meta.field_id IS NOT NULL');
					$query = $this->$db_name->get();

					$last_query = $this->$db_name->last_query();
					// print_r($last_query);

					// Get result in array format.
					$result = $query->result_array();

					// Create an associative array to organize data by parent_id.
					$organized_data = array();
					foreach ($result as $row) {
						$parent_id = $row['parent_id'];

						if (!isset($organized_data[$parent_id])) {
							$organized_data[$parent_id] = array(
								'email' => null,
								'name' => null,
								'phone' => null,
								'message' => null,
								'date' => null,
								'account' => $account,
							);
						}

						if ($row['type'] === 'email') {
							$organized_data[$parent_id]['email'] = $row['meta_value'];
						} elseif ($row['type'] === 'text' && ($row['label'] === 'Nombre (s)' || $row['label'] === 'Nombre')) {
							$organized_data[$parent_id]['name'] = $row['meta_value'];
						} elseif ($row['type'] === 'tel') {
							$organized_data[$parent_id]['phone'] = $row['meta_value'];
						} elseif ($row['type'] === 'textarea') {
							$organized_data[$parent_id]['message'] = $row['meta_value'];
						}

						if ($organized_data[$parent_id]['date'] === null) {
							$organized_data[$parent_id]['date'] = $row['date_added'];
						}
					}

					// Append the organized data to the result array.
					$data['result' . $counter] = $organized_data;


					// Unload the database after operations.
					$this->$db_name->close();

				}
				else {
					echo "Database connection failed for: " . $db_name;
				}
			}

		}
		else
		{
			$data['staff'] = 0;
		}



		$this->load->view('_templates/dashboard/header', $data);
		$this->load->view('_templates/dashboard/sidebar', $data);
		$this->load->view('dashboards/index', $data);
		$this->load->view('_templates/general/footer');
	}
}
