<?php

class MY_Controller extends CI_Controller {

    function __construct()
    {
        parent::__construct();
		$this->load->model('Sipuma_model');
		$this->load->vars(array(
		'menu'=>$this->menu(),
		'title'=>$this->title(),
		'owner' => $this->owner(),
		'phone_number' => $this->phone_number(),
		'fax' => $this->fax(),
		'email' => $this->email(),
		'address' => $this->address(),
		'footer'=>$this->footer()
		));
    }
	
	public function core_template()
	{
		$core_template = 'blue';
		return $core_template;
	}
	
	public function template()
	{
		$status = $this->session->userdata('login_status');
		if($status == 'A'):
			$template = $this->core_template().'/template_user';
		elseif($status == 'D'):
			$template = $this->core_template().'/template_user';
		elseif($status == 'M'):
			$template = $this->core_template().'/template_user';
		else:
			$template = $this->core_template().'/template';
		endif;
		return $template;
	}
	
	public function menu()
	{
		$status = $this->session->userdata('login_status');
		if($status == 'A'):
			$menu = $this->core_template().'/menu_admin';
		elseif($status == 'D'):
			$menu = $this->core_template().'/menu_dosen';
		elseif($status == 'M'):
			$menu = $this->core_template().'/menu_mahasiswa';
		else:
			$menu = $this->core_template().'/menu';
		endif;
		return $menu;
	}
	
	public function subject_list()
	{
		$subject_list = $this->Sipuma_model->subject_list();
		return $subject_list;
	}
	
	public function footer()
	{
		$name = 'SI PuMa (Sistem Informasi Publikasi Penelitian Mahasiswa)';
		$version = '1.0';
		$email =  'imadirrizki@gmail.com';
		$creator = 'Imadirrizki';
		$year = '2012';
		$footer = $name.' v.'.$version.' created by <a href=mailto:'.$email.'>'.$creator.'</a> &copy; '.$year;
		return $footer;
	}

	public function user_id()
	{
		$username = $this->session->userdata('user_id');
		return $username;
	}
	
	public function title()
	{
		$site_info = $this->Sipuma_model->site_info();
		if($site_info){
			$title = $site_info->title;
		}
		return $title;
	}	
	
	public function owner()
	{
		$site_info = $this->Sipuma_model->site_info();
		if($site_info){
			$owner = $site_info->owner;
		}
		return $owner;
	}	
	
	public function phone_number()
	{
		$site_info = $this->Sipuma_model->site_info();
		if($site_info){
			$phone_number = $site_info->phone_number;
		}
		return $phone_number;
	}	
	
	public function fax()
	{
		$site_info = $this->Sipuma_model->site_info();
		if($site_info){
			$fax = $site_info->fax;
		}
		return $fax;
	}	
	
	public function email()
	{
		$site_info = $this->Sipuma_model->site_info();
		if($site_info){
			$email = $site_info->email;
		}
		return $email;
	}	
	
	public function address()
	{
		$site_info = $this->Sipuma_model->site_info();
		if($site_info){
			$address = $site_info->address;
		}
		return $address;
	}
}