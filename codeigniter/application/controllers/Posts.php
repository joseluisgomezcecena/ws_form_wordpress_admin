<?php
class Posts extends CI_Controller
{

	public function index()
	{
		$data['title'] = 'Posts';

		//check if user is logged in as staff.
		if ($this->session->userdata('data') ['staff'] === 1) {


		}else{ //NOT LOGGED AS STAFF MEMBER.

		}

	}
}
