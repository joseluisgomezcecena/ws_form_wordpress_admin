<?php
class Views extends CI_Model
{

	public function __construct()
	{
		$this->load->database();
	}



	public function get_views_chart()
	{

		$currentYear = date('Y');

		// Query to retrieve sales data for the current year
		$query = $this->db->select('MONTH(created_at) as month, SUM(total) as total_sales')
			->from('purchase_order')
			->where('YEAR(created_at)', $currentYear)
			->group_by('MONTH(created_at)')
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

		// Sort the sales data array by keys (months) in ascending order
		ksort($salesData);

		// Prepare the final data format for the chart
		$finalData = array(
			'labels' => array_keys($salesData),   // Months
			'sales' => array_values($salesData)   // Sales values
		);

		return $finalData;
	}




}
