<?php

class UserModel extends CI_Model{

	public function __construct()
	{
		$this->load->database();
	}

	public function getCurrentUser($id)
	{
		$query = $this->db->get_where('users', array('user_id' => $id));
		//$last_query = $this->db->last_query();
		//print_r($last_query);

		return $query->row_array();
	}


	public function updateUser($id, $password)
	{
		$data = array(
			'user_email'=>$this->input->post('user_email'),
			'user_phone'=>$this->input->post('user_phone'),
			'password'=>$password,
		);
		$this->db->where('user_id', $id);
		return $this->db->update('users', $data);
	}


	public function getClientAccounts(){
		//get where staff = 0
		$this->db->select('*');
		$this->db->from('users');
		$this->db->join('client_company', 'users.user_id = client_company.user_id');
		$this->db->where('staff', 0);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getSingleUser($id)
	{
		//adjust for admins that dont have a company.
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('user_id', $id);
		$query = $this->db->get();
		$user = $query->row_array();
		//check if is staff/admin or not.
		if ($user['staff'] == 1){
			$this->db->select('*');
			$this->db->from('users');
			$this->db->where('users.user_id', $id);
			$query = $this->db->get();
		}else{
			$this->db->select('*');
			$this->db->from('users');
			$this->db->join('client_company', 'users.user_id = client_company.user_id');
			$this->db->where('users.user_id', $id);
			$query = $this->db->get();
		}


		return $query->row_array();
	}


	public function getSingleUserByCompany($company_id)
	{
		$this->db->select('*');
		$this->db->from('client_company');
		$this->db->join('users', 'users.user_id = client_company.user_id');
		$this->db->where('client_company.id', $company_id);
		$query = $this->db->get();
		return $query->row_array();
	}



	public function getAdminAccounts(){
		//get where staff = 1
		$query = $this->db->get_where('users', array('staff' => 1));
		return $query->result_array();
	}

	public function registerClient($encrypted_pwd)
	{
		$data = array(
			'user_email'=>$this->input->post('user_email'),
			'user_phone'=>$this->input->post('user_phone'),
			'password'=>$encrypted_pwd,
			'staff'=>0,
		);
		$this->db->insert('users', $data);

		$user_id = $this->db->insert_id();

		//register company.
		$company_data = array(
			'company_name'=>$this->input->post('company_name'),
			'company_site'=>"https://" . $this->input->post('company_site'),
			'company_db'=>$this->input->post('company_db'),
			'db_prefix'=>$this->input->post('db_prefix'),
			'user_id'=>$user_id,
		);
		$this->db->insert('client_company', $company_data);
	}



	public function updateClient($password, $user_id, $company_id)
	{
		$data = array(
			'user_email'=>$this->input->post('user_email'),
			'user_phone'=>$this->input->post('user_phone'),
			'password'=>$password,
		);
		$this->db->where('user_id', $user_id);
		$this->db->update('users', $data);

		$company_data = array(
			'company_name'=>$this->input->post('company_name'),
			'company_site'=>"https://" . $this->input->post('company_site'),
			'company_db'=>$this->input->post('company_db'),
			'db_prefix'=>$this->input->post('db_prefix'),
			'user_id'=>$user_id,
		);

		$this->db->where('id', $company_id);
		$this->db->update('client_company', $company_data);

	}




	public function registerAdmin($encrypted_pwd)
	{
		$data = array(
			'user_email'=>$this->input->post('user_email'),
			'user_phone'=>$this->input->post('user_phone'),
			'password'=>$encrypted_pwd,
			'staff'=>1,
		);

		return $this->db->insert('users', $data);
	}


	public function updateAdmin($id, $encrypted_pwd)
	{
		$data = array(
			'user_email'=>$this->input->post('user_email'),
			'user_phone'=>$this->input->post('user_phone'),
			'password'=>$encrypted_pwd,
		);

		$this->db->where('user_id', $id);
		$this->db->update('users', $data);
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
		//get if user is staff member.
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('users.user_email', $email);
		$query = $this->db->get();
		$result_staff = $query->row_array();

		if ($result_staff["staff"] == 1)
		{
			$this->db->select('*');
			$this->db->from('users');
			$this->db->where('users.user_email', $email);
			$query = $this->db->get();
			$result = $query->row_array();
		}
		else
		{
			$this->db->select('*');
			$this->db->from('users');
			$this->db->join('client_company', 'client_company.user_id = users.user_id', 'left');
			$this->db->where('users.user_email', $email);
			$query = $this->db->get();
			$result = $query->row_array();
		}





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


	public function checkEmailExistsUpdate($email, $user_id){
		$this->db->where('user_id !=', $user_id);
		$query = $this->db->get_where('users', array('user_email' => $email));

		if(empty($query->row_array())){
			return true;
		}else{
			return false;
		}
	}


	public function checkPhoneExistsUpdate($phone, $user_id){
		$this->db->where('user_id !=', $user_id);
		$query = $this->db->get_where('users', array('user_phone' => $phone));

		if(empty($query->row_array())){
			return true;
		}else{
			return false;
		}
	}

}



