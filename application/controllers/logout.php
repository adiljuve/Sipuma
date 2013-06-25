<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {

	function index()
	{
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('login_status');
		$this->session->unset_userdata('status');
		$this->session->unset_userdata('user_type');
		$this->session->unset_userdata('redirect');
		$this->session->unset_userdata('logged_in_sipuma');
		redirect(base_url());
	}
}

