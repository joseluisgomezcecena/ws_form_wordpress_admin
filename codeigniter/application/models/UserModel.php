<?php

class UserModel extends CI_Model{

	public function __construct()
	{
		$this->load->database();
	}


	public function get_all()
	{
		$company_id = $this->session->userdata('data')['company_id'];

		$this->db->select ( '*' );
		$this->db->from ( 'users');
		$this->db->where('client_company_id', $company_id);
		$query = $this->db->get();
		return $query->result_array();
	}


	public function get_user($id)
	{
		$user_data = $this->session->userdata('user_id');

		$query = $this->db->get_where('users', array('user_id'=>$id, 'client_company_id'=>$user_data['client_company_id']));
		return $query->row_array();
	}



	public function register($encrypted_pwd)
	{
		//$licence_expires = date('Y-m-d', strtotime('+1 year'));

		$area_code = $this->input->post('area');
		$phone =  $this->input->post('phone');

		$data = array(
			'user_email'=>$this->input->post('email'),
			'user_phone'=>$this->input->post('area') . $this->input->post('phone'),
			'password'=>$encrypted_pwd,
			'staff'=>1,
		);

		$this->db->insert('users', $data);
		$user_id = $this->db->insert_id();


		$data_company = array(
			'company_name'=>$this->input->post('company_name'),
			'company_site'=> "https://drcarlosocchoa.com",
			'company_db'=> "drcarlosochoa",
			'db_prefix'=> "wpxw_", //this is the prefix for the wordpress database.
			'user_id'=>$user_id,
		);

		$this->db->insert('client_company', $data_company);
	}





	public function edit_profile($user_id, $encrypted_pwd)
	{

		$user_data = $this->session->userdata('user_id');
		$phone = $this->input->post('area') . $this->input->post('user_phone');

		$data = array(
			'user_email'=>$this->input->post('user_email'),
			'user_phone'=>$phone,
			'user_password'=>$encrypted_pwd,
		);

		return $this->db->update(
			'users',
			$data,
			array('user_id'=>$user_id,
				'client_company_id'=>$user_data['client_company_id']
			)
		);
	}



	public function delete_profile($user_id)
	{
		$user_data = $this->session->userdata('user_id');

		$this->db->where('user_id', $user_id);
		$this->db->where('client_company_id', $user_data['client_company_id']);
		$this->db->delete('users');
		return true;
	}





	public function login($email, $password)
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->join('client_company', 'client_company.user_id = users.user_id', 'left');
		$this->db->where('users.user_email', $email);
		$query = $this->db->get();


		$last_query = $this->db->last_query();
		print_r($last_query);


		$result = $query->row_array();

		if (!empty($result) && password_verify($password, $result['password']))
		{
			return $result;
		}
		else
		{
			return false;
		}

	}


	public function check_companyname_exists($company)
	{
		$query = $this->db->get_where('client_company', array('company_name' => $company));

		if(empty($query->row_array()))
		{
			return true;
		}
		else
		{
			return false;
		}
	}


	public function check_email_exists($email)
	{
		$query = $this->db->get_where('users', array('user_email' => $email));

		if(empty($query->row_array()))
		{
			return true;
		}
		else
		{
			return false;
		}
	}


	public function check_phone_exists($phone)
	{
		$query = $this->db->get_where('users', array('user_phone' => $phone));

		if(empty($query->row_array()))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}



