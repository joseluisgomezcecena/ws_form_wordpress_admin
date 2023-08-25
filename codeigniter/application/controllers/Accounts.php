<?php

class Accounts extends CI_Controller
{
	public function clients()
	{
		$data['title']  = 'Registrar Cliente';
		$data['clients'] = $this->UserModel->getClientAccounts();

		//validation styles


		$this->form_validation->set_rules('user_email', 'Email', 'required|callback_check_email_exists');
		$this->form_validation->set_rules('password', 'Password', 'required');
		//$this->form_validation->set_rules('password2', 'Confirmar Password', 'matches[password]');
		$this->form_validation->set_rules('user_phone', 'Telefono', 'required|callback_check_phone_exists');

		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('_templates/dashboard/header', $data);
			$this->load->view('_templates/dashboard/sidebar', $data);
			$this->load->view('accounts/register_client', $data);
			$this->load->view('_templates/general/footer');
		}
		else
		{
			$encrypted_pwd = password_hash($this->input->post('password'), PASSWORD_DEFAULT);

			$this->UserModel->registerClient($encrypted_pwd);

			$this->session->set_flashdata('message', 'El usuario ha sido registrado.');

			redirect(base_url() . 'accounts/clients');
		}


	}


	public function updateclient($id)
	{

		$data['title']  = 'Actualizar Cliente';
		$data['client'] = $this->UserModel->getSingleUserByCompany($id);
		$user_id = $data['client']['user_id'];


		//validation styles
		$this->form_validation->set_rules('user_email', 'Email', 'required|callback_check_email_exists_update[' . $user_id . ']');
		$this->form_validation->set_rules('user_phone', 'Telefono', 'required|callback_check_phone_exists_update[' . $user_id . ']');
		$this->form_validation->set_rules('password', 'Contraseña', 'required');

		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('_templates/dashboard/header', $data);
			$this->load->view('_templates/dashboard/sidebar', $data);
			$this->load->view('accounts/update_client', $data);
			$this->load->view('_templates/general/footer');
		}
		else
		{
			$encrypted_pwd = password_hash($this->input->post('password'), PASSWORD_DEFAULT);

			$this->UserModel->updateClient($encrypted_pwd, $user_id, $id);

			$this->session->set_flashdata('message', 'El usuario ha sido actualizado.');

			redirect(base_url() . 'accounts/clients');
		}


	}


	public function admins()
	{
		$data['title']  = 'Registrar Staff o Administrador.';
		$data['admins'] = $this->UserModel->getAdminAccounts();

		//validation styles


		$this->form_validation->set_rules('user_email', 'Email', 'required|callback_check_email_exists');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('user_phone', 'Telefono', 'required|callback_check_phone_exists');

		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('_templates/dashboard/header', $data);
			$this->load->view('_templates/dashboard/sidebar', $data);
			$this->load->view('accounts/register_admin', $data);
			$this->load->view('_templates/general/footer');
		}
		else
		{
			$encrypted_pwd = password_hash($this->input->post('password'), PASSWORD_DEFAULT);

			$this->UserModel->registerAdmin($encrypted_pwd);

			$this->session->set_flashdata('message', 'El administrador o miembro de staff ha sido registrado.');

			redirect(base_url() . 'accounts/admins');
		}
	}



	public function updateadmin($id)
	{

		$data['title'] = 'Actualizar Administrador o Staff';
		$data['admin'] = $this->UserModel->getSingleUser($id);
		$user_id = $data['admin']['user_id'];

		//validation styles
		$this->form_validation->set_rules('user_email', 'Email', 'required|callback_check_email_exists_update[' . $user_id . ']');
		$this->form_validation->set_rules('user_phone', 'Telefono', 'required|callback_check_phone_exists_update[' . $user_id . ']');
		$this->form_validation->set_rules('password', 'Contraseña', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('_templates/dashboard/header', $data);
			$this->load->view('_templates/dashboard/sidebar', $data);
			$this->load->view('accounts/update_admin', $data);
			$this->load->view('_templates/general/footer');
		} else {
			$encrypted_pwd = password_hash($this->input->post('password'), PASSWORD_DEFAULT);

			$this->UserModel->updateAdmin($user_id,$encrypted_pwd);

			$this->session->set_flashdata('message', 'El usuario ha sido actualizado.');

			redirect(base_url() . 'accounts/admins');
		}
	}



	public function profile()
	{
		$data['title']  = 'Perfil de Usuario';
		$data['user'] = $this->UserModel->getCurrentUser($this->session->userdata('data')['user_id']);
		$user_id = $this->session->userdata('data')['user_id'];

		//validation styles
		$this->form_validation->set_rules('user_email', 'Email', 'required|callback_check_email_exists_update[' . $user_id . ']');
		$this->form_validation->set_rules('user_phone', 'Telefono', 'required|callback_check_phone_exists_update[' . $user_id . ']');
		$this->form_validation->set_rules('password', 'Contraseña', 'required');

		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('_templates/dashboard/header', $data);
			$this->load->view('_templates/dashboard/sidebar', $data);
			$this->load->view('accounts/profile', $data);
			$this->load->view('_templates/general/footer');
		}
		else
		{
			$encrypted_pwd = password_hash($this->input->post('password'), PASSWORD_DEFAULT);

			$this->UserModel->updateUser($data['user']['user_id'], $encrypted_pwd);

			$this->session->set_flashdata('message', 'El perfil ha sido actualizado.');

			redirect(base_url() . 'accounts/profile');
		}

	}



	/*** CALLBACK FUNCTIONS ***/
	public function check_email_exists($email)
	{
		$this->form_validation->set_message('check_email_exists', 'El email ya esta registrado.');

		if($this->UserModel->check_email_exists($email))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function check_email_exists_update($email, $user_id)
	{
		$this->form_validation->set_message('check_email_exists_update', 'El email ya esta registrado.');

		if($this->UserModel->checkEmailExistsUpdate($email, $user_id))
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
		$this->form_validation->set_message('check_phone_exists', 'El telefono ya esta registrado.');

		if($this->UserModel->check_phone_exists($phone))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function check_phone_exists_update($phone, $user_id)
	{
		$this->form_validation->set_message('check_phone_exists_update', 'El telefono ya esta registrado.');

		if($this->UserModel->checkPhoneExistsUpdate($phone, $user_id))
		{
			return true;
		}
		else
		{
			return false;
		}
	}



}
