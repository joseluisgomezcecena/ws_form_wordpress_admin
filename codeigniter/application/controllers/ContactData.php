<?php
class ContactData extends CI_Controller
{
	public function __construct(){}

	public function index()
	{
		//check if user is logged in as staff.
		if ($this->session->userdata('data') ['staff'] === 1)
		{
			//load all databases.
			$databases = array('default', 'drcarlosochoa');
			foreach ($databases as $db_name) {
				$this->load->database($db_name, TRUE);

				//checar prefijos.



				// Perform database operations for the current loaded database
				// Example: $this->db->get('table_name');

				// Unload the database after operations if needed wpxw_wsf_submit_meta
				$this->db->close();
			}

		}
		else
		{
			//check users company id.
			$company_id = $this->session->userdata('data')['company_id'];
			$wp_database = $this->session->userdata('data')['wp_database']; //wordpress database name.

			//get all contact form data from wordpress database for that user.
			$my_database = $this->load->database($wp_database, TRUE);

			$my_database->select('*');
			$my_database->from('wp_cf7dbplugin_submits');
			$my_database->where('form_name', 'Contact Form');
			$my_database->where('field_name', 'your-company');
			$my_database->where('field_value', $company_id);


		}
	}
}
