<?php
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

require APPPATH . '/vendor/autoload.php';

class Auth extends CI_Controller{

	public function register()
	{
		$data['title'] = 'Sign Up!';

		$this->form_validation->set_rules('company_name', 'Company Name', 'required|callback_check_companyname_exists');
		$this->form_validation->set_rules('email', 'E-Mail', 'required|valid_email|callback_check_email_exists');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('password2', 'Password Confirmation', 'matches[password]');
		$this->form_validation->set_rules('phone', 'Mobile Number', 'callback_check_phone_exists');
		$this->form_validation->set_rules('area', 'Area Code', 'required');


		$this->form_validation->set_error_delimiters(
			'<div class="alert alert-danger alert-dismissible fade show bg-white card2" role="alert"><strong>Error!</strong>',
			'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
		);


		if($this->form_validation->run() === FALSE)
		{
			$this->load->view('_templates/auth/header');
			$this->load->view('auth/register', $data);
			$this->load->view('_templates/auth/footer');
		}
		else
		{
			//Encrypt password
			$encrypted_pwd = password_hash($this->input->post('password'), PASSWORD_DEFAULT);

			$this->UserModel->register($encrypted_pwd);


			//session message
			$this->session->set_flashdata('created', 'You can now login.');

			redirect(base_url() . 'auth/register');
		}

	}






	public function login()
	{

		if($this->session->userdata('logged_in'))
		{
			redirect(base_url() . 'home');
		}

		$data['title'] = 'Login Here!';

		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');




		//validation styles.
		$this->form_validation->set_error_delimiters(
			'<div class="alert alert-danger card2 bg-white" role="alert"><strong class="text-danger">Missing field:</strong>',
			'</div>'
		);


		if($this->form_validation->run() === FALSE)
		{
			$this->load->view('_templates/auth/header');
			$this->load->view('auth/login', $data);
			$this->load->view('_templates/auth/footer');
		}
		else
		{
			//Encrypt password
			$email = $this->input->post('email');
			$password = $this->input->post('password');


			$login_credentials = $this->UserModel->login($email, $password);

			if($login_credentials)
			{
				//create session
				$user_data = array(
					'data'=>$login_credentials,
					'user_email'=>$email,
					'logged_in'=>true,
				);

				$this->session->set_userdata($user_data);


				//session message
				$this->session->set_flashdata('login_success', 'You are now logged in.');
				redirect(base_url() . 'dashboard');
			}
			else
			{
				//session message
				$this->session->set_flashdata('login_failed', 'Invalid login credentials.');
				redirect(base_url() . 'auth/login');
			}
		}
	}






	public function logout()
	{
		$this->session->unset_userdata('logged_in');
		$this->session->unset_userdata('data');
		$this->session->unset_userdata('user_name');

		//session message
		$this->session->set_flashdata('user_logged_out', 'You have logged out.');
		redirect(base_url() . 'auth/login');
	}






	public function forgot()
	{
		if($this->session->userdata('logged_in'))
		{
			redirect(base_url() . 'home');
		}

		$data['title'] = 'Forgot Password';

		$this->form_validation->set_rules('email', 'Email', 'required');

		//validation styles.
		$this->form_validation->set_error_delimiters(
			'<div class="alert alert-danger" role="alert"><strong>Missing field:</strong>',
			'</div>'
		);


		if($this->form_validation->run() === FALSE)
		{
			$this->load->view('_templates/auth/header');
			$this->load->view('users/forgot', $data);
			$this->load->view('_templates/auth/footer');
		}
		else
		{

		}
	}

	public function get_user($id)
	{
		$user_array  = $this->session->userdata('user_id');
		$id = $user_array['id'];
		$data['user'] = $this->UserModel->get_user($id);
	}












	/* CALLBACKS */

	function check_companyname_exists($company)
	{
		$this->form_validation->set_message('check_companyname_exists','That company name is taken. Please choose a different one.');

		if($this->UserModel->check_companyname_exists($company))
		{
			return true;
		}
		else
		{
			return false;
		}
	}



	function check_email_exists($email)
	{
		$this->form_validation->set_message('check_email_exists','That email is taken. Please choose a different one.');

		if($this->UserModel->check_email_exists($email))
		{
			return true;
		}
		else
		{
			return false;
		}
	}


	function check_phone_exists($phone)
	{
		$this->form_validation->set_message('check_phone_exists','That phone number is taken. Please choose a different one.');

		if($this->UserModel->check_phone_exists($phone))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

}
