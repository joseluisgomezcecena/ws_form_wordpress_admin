<?php

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;
use Twilio\Rest\Client as TwilioClient;

require APPPATH . '/vendor/autoload.php';

class ClientApp extends CI_Controller
{


	public function index()
	{
		$data['title'] = 'Client App';

		$this->load->view('_templates/client/header');
		$this->load->view('client_app/index', $data);
		$this->load->view('_templates/general/footer');

		$this->send(4);
	}


	public function alert_form()
	{
		$data['title'] = 'Alert Form';

		if(!isset($_POST['submit']))
		{
			$this->load->view('_templates/client/header');
			$this->load->view('client_app/alert_form', $data);
			$this->load->view('_templates/general/footer');
		}
		else
		{
			$this->send(1);
		}

	}





	public function send($alert_id)
	{
		//$company_id = 77;
		//$alert_id = $this->input->post('alert_id');

		$company_id = $this->session->userdata('data')['company_id'];

		$version = new Version2X('http://localhost:3001');
		$client = new Client($version);
		$client->initialize();
		$client->emit(
			'newOrder',
			[
				'message' => 'New Alert',
				'alert_id' => $alert_id,
				'company_id' => $company_id
			]
		);
		$client->close();
	}


	public function receive()
	{
		$version = new Version2X('http://localhost:3001');
		$client = new Client($version);
		$client->initialize();
		$client->on('newOrder', function($data) {
			echo $data['message'];
		});
		$client->close();
	}
}
