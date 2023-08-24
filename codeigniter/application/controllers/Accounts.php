<?php

class Accounts extends CI_Controller
{
	public function clients()
	{
		$data['title']  = 'Registrar Cliente';
		$data['clients'] = $this->UserModel->getClientAccounts();

		//validation styles


		$this->form_validation->set_rules('user_email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		//$this->form_validation->set_rules('password2', 'Confirmar Password', 'matches[password]');
		$this->form_validation->set_rules('user_phone', 'Telefono', 'required');

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


	public function admins()
	{
		$data['title']  = 'Registrar Staff o Administrador.';
		$data['admins'] = $this->UserModel->getAdminAccounts();

		//validation styles


		$this->form_validation->set_rules('user_email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('user_phone', 'Telefono', 'required');

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



	public function profile()
	{
		$data['title']  = 'Perfil de Usuario';
		$data['user'] = $this->UserModel->getCurrentUser($this->session->userdata('data')['user_id']);


		//validation styles
		$this->form_validation->set_rules('user_email', 'Email', 'required');
		$this->form_validation->set_rules('user_phone', 'Telefono', 'required');
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



}
