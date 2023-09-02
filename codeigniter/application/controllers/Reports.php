<?php
class Reports extends MY_Controller
{
	public function index()
	{
		$data['title'] = 'Reportes';

		if ($this->session->userdata('data') ['staff'] == 1)
		{
			$data['staff'] = 1;

			$databases = array('adminsystemsmx', 'drcarlosochoa',);
			$db_count = $data['database_count'] = count($databases);
			$counter = 0;

			$monthNames = array(
				1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr',
				5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago',
				9 => 'Sept', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'
			);

			$allSalesData = array(); // Array to store sales data from all databases
			$message_count = 0;


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

					//get number of rows.
					$rows = $query->num_rows();


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
							$message_count++;
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



					/*CHART DATA*/
					$currentYear = date('Y');

					// Query to retrieve sales data for the current year
					$query = $this->$db_name->select('MONTH(date) as month, SUM(count) as total_sales')
						->from($table_prefix .'visitor_counter')
						->where('YEAR(date)', $currentYear)
						->group_by('MONTH(date)')
						->get();

					$salesData = array();
					// Process the query results
					if ($query->num_rows() > 0) {
						foreach ($query->result() as $row) {
							$salesData[(int)$row->month] = (float)$row->total_sales;
						}
					}

					// Assign sales value of 0 for months without sales
					for ($month = 1; $month <= 12; $month++) {
						if (!isset($salesData[$month])) {
							$salesData[$month] = 0;
						}
					}


					// Add sales data from the current database to the allSalesData array
					foreach ($salesData as $month => $sales)
					{
						if (!isset($allSalesData[$month])) {
							$allSalesData[$month] = 0;
						}
						$allSalesData[$month] += $sales;
					}

					// Unload the database after operations.
					$this->$db_name->close();

				}
				else {
					echo "Database connection failed for: " . $db_name;
				}
			}//end foreach
			ksort($allSalesData);

			// Prepare the final data format for the chart
			$finalData = array(
				'labels' => array_values($monthNames),   // Month names
				'sales' => array_values($allSalesData)   // Aggregated sales values
			);

			$chart_data = json_encode($finalData);
			$data['chart_data'] = $chart_data;
			$data['visits'] = $finalData;

			$data['message_count'] = $message_count;

			$data['all_visits'] = array_sum($allSalesData);


		}

		else
		{
			$data['staff'] = 0;

			//load all databases.

			$databases = array('drcarlosochoa',);
			$db_count = $data['database_count'] = count($databases);


			$counter = 0;
			$monthNames = array(
				1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr',
				5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago',
				9 => 'Sept', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'
			);
			$allSalesData = array(); // Array to store sales data from all databases
			$message_count = 0;


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

					//get number of rows.
					$rows = $query->num_rows();


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
							$message_count++;
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



					/*CHART DATA*/
					$currentYear = date('Y');

					// Query to retrieve sales data for the current year
					$query = $this->$db_name->select('MONTH(date) as month, SUM(count) as total_sales')
						->from($table_prefix .'visitor_counter')
						->where('YEAR(date)', $currentYear)
						->group_by('MONTH(date)')
						->get();

					$salesData = array();
					// Process the query results
					if ($query->num_rows() > 0) {
						foreach ($query->result() as $row) {
							$salesData[(int)$row->month] = (float)$row->total_sales;
						}
					}

					// Assign sales value of 0 for months without sales
					for ($month = 1; $month <= 12; $month++) {
						if (!isset($salesData[$month])) {
							$salesData[$month] = 0;
						}
					}


					// Add sales data from the current database to the allSalesData array
					foreach ($salesData as $month => $sales)
					{
						if (!isset($allSalesData[$month])) {
							$allSalesData[$month] = 0;
						}
						$allSalesData[$month] += $sales;
					}







					// Unload the database after operations.
					$this->$db_name->close();

				}
				else {
					echo "Database connection failed for: " . $db_name;
				}




			}//end foreach
			ksort($allSalesData);

			// Prepare the final data format for the chart
			$finalData = array(
				'labels' => array_values($monthNames),   // Month names
				'sales' => array_values($allSalesData)   // Aggregated sales values
			);

			$chart_data = json_encode($finalData);
			$data['chart_data'] = $chart_data;

			$data['visits'] = $finalData;

			$data['message_count'] = $message_count;

			$data['all_visits'] = array_sum($allSalesData);

		}




		$this->load->view('_templates/dashboard/header', $data);
		$this->load->view('_templates/dashboard/sidebar', $data);
		$this->load->view('reports/index', $data);
		$this->load->view('_templates/general/footer');





	}
}
