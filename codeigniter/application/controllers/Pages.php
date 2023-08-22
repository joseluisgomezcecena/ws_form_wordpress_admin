<?php
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;
use Twilio\Rest\Client as TwilioClient;


require APPPATH . '/vendor/autoload.php';

class Pages extends CI_Controller
{

	public function view($page = 'index')
	{
		if(!file_exists(APPPATH . 'views/pages/' . $page . '.php'))
		{
			show_404();
		}

		$data['title'] = ucfirst($page);


		$alert_id = 20;
		$company_id = 77;

		$this->load->view('_templates/client/header');
		$this->load->view('pages/' . $page, $data); //loading page and data
		$this->load->view('_templates/general/footer');

		/*
		$version = new Version2X('http://localhost:3001');
		$client = new Client($version);

		$client->initialize();
		//$client->emit('newOrder', ['message' => 'Hello World!']);
		$client->emit('newOrder', ['message' => 'Hello World!', 'alert_id' => $alert_id, 'company_id' => $company_id]);
		$client->close();
		*/



	}



	public function getAlertDetails()
	{
		$post = $this->input->post("alert_id");

		echo json_encode($post);
	}


}
