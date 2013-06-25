<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dosen extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->is_logged_in();
		$this->load->vars(array( 
		'sidebar_user'=>$this->core_template().'/sidebar_user'
		));
	}
	
	function is_logged_in() 
	{
		$is_logged_in = $this->session->userdata('logged_in_sipuma');
		$status = $this->session->userdata('login_status');
		if(!isset($is_logged_in) || $is_logged_in != true || $status != 'D'){
			redirect(base_url());
		}
	}
	
	public function search()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$data['column'] = $this->input->post('option');
			$data['keyword'] = htmlentities(trim($this->input->post('keyword')));
			$this->session->set_userdata('column', $data['column']);
			$this->session->set_userdata('keyword', $data['keyword']);
		}else{
			$data['column'] = $this->session->userdata('column');
			$data['keyword'] = $this->session->userdata('keyword');
		}
		
		if($data['keyword'] == ''){
			redirect(base_url());
		}else{
			$data['heading'] = 'Hasil Pencarian';	
			$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
			$data['journal_member'] = $this->Sipuma_model->journal_member($this->user_id());			
			if($data['column'] == 'title'){
				$config = array();
				$config['base_url'] = base_url().'dosen/search';
				$config['total_rows'] = $this->Sipuma_model->search_from_paper_count($data['column'], $data['keyword']);
				$config['per_page'] = 15; 
				$config['uri_segment'] = 3;
				$choice = $config['total_rows'] / $config['per_page'];
				$config['num_links'] = round($choice);
				$this->pagination->initialize($config); 
				
				$page = ($this->uri->segment(3))? $this->uri->segment(3) : 0;
				$data['links'] = $this->pagination->create_links();
				$data['result'] = $this->Sipuma_model->search_from_paper_paging($data['column'], $data['keyword'], $config['per_page'], $page);
				$data['content'] = $this->core_template().'/search';
				$this->load->view($this->template(), $data);
			}elseif($data['column'] == 'author'){
				$config = array();
				$config['base_url'] = base_url().'dosen/search';
				$config['total_rows'] = $this->Sipuma_model->search_from_user_count($data['keyword']);
				$config['per_page'] = 15; 
				$config['uri_segment'] = 3;
				$choice = $config['total_rows'] / $config['per_page'];
				$config['num_links'] = round($choice);
				$this->pagination->initialize($config); 
				
				$page = ($this->uri->segment(3))? $this->uri->segment(3) : 0;
				$data['links'] = $this->pagination->create_links();
				$data['result'] = $this->Sipuma_model->search_from_user_paging($data['keyword'], $config['per_page'], $page);
				$data['content'] = $this->core_template().'/search';
				$this->load->view($this->template(), $data);
			}
		}
	}
	
	public function index()
	{
		$data['heading'] = 'Home';
		$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
		$data['journal_member'] = $this->Sipuma_model->journal_member($this->user_id());
		$data['paper_journal_member'] = $this->Sipuma_model->paper_journal_member($this->user_id());
		$data['content'] = $this->core_template().'/dosen_home';
		$this->load->view($this->template(), $data);
	}
	
	public function paper()
	{
		$this->load->library('form_validation');
		$config = array(
				array(
					'field'   => 'comment', 
                    'label'   => 'Komentar', 
                    'rules'   => 'required|max_length[255]'
				)
            );
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', '%s is required');
		
		if($this->form_validation->run() == FALSE)
		{	
			$paper_id = $this->uri->segment(3);
			$data['heading'] = 'Detail Publikasi';
			$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
			$data['journal_member'] = $this->Sipuma_model->journal_member($this->user_id());
			$data['journal_paper'] = $this->Sipuma_model->journal_paper($paper_id);
			$data['paper_detail'] = $this->Sipuma_model->paper_published_detail($paper_id);
			$data['paper_detail_author'] = $this->Sipuma_model->paper_detail_author($paper_id);
			$data['free_user_paper'] = $this->Sipuma_model->free_user_paper_list($paper_id);
			$data['discussion_list'] = $this->Sipuma_model->discussion_list($paper_id);
			$data['content'] = $this->core_template().'/dosen_paper';
			$this->load->view($this->template(), $data);
		}
		else
		{
			$this->comment();
		}
	}
	
	public function file()
	{
		$data['paper_id'] = $this->uri->segment(3);
		$this->load->view($this->core_template().'/file', $data);
	}
	
	public function preview()
	{
		$this->load->helper('download');
		$paper_id = $this->uri->segment(3);
		$paper_detail = $this->Sipuma_model->paper_detail($paper_id);
		if ($paper_detail){
			if (file_exists($paper_detail->file_directory.$paper_detail->file_name)){
				$file_data = file_get_contents($paper_detail->file_directory.$paper_detail->file_name);
				header('Content-type: application/pdf');
				echo $file_data;
			}else{
				$this->_file_not_found();
			}
		}else{
			redirect(base_url());
		}
	}
	
	public function download()
	{
 		$this->load->helper('download');
		$paper_id = $this->uri->segment(3);
		$paper_detail = $this->Sipuma_model->paper_detail($paper_id);
		if ($paper_detail){
			if (file_exists($paper_detail->file_directory.$paper_detail->file_name)){
				$file_data = file_get_contents($paper_detail->file_directory.$paper_detail->file_name);
				$file_name = $paper_detail->paper_id.'-'.$paper_detail->file_name;
				force_download($file_name, $file_data);
			}else{
				$this->_file_not_found();
			}	
		}else{
			redirect(base_url());
		}	
	}
	
	function _file_not_found()
	{
		$this->load->view($this->core_template().'/file_not_found');
	}
	
	public function comment()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$discussion_id = random_string('nozero',6);
			$data = array(
					'discussion_id' => $discussion_id,
					'paper_id' => htmlentities($this->input->post('paper_id')),
					'user_id' => $this->user_id(),
					'comment' => htmlentities(trim($this->input->post('comment'))),
					'comment_date' => date('Y-m-d'),
					'parent_id' => 0
					);
			$this->Sipuma_model->discussion_add($data);
			if (isset($_SERVER['HTTP_REFERER'])){
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				redirect(isset($_SERVER['HTTP_REFERER']));
			}
		}else{
			redirect(base_url());
		}
	}
	
	public function comment_reply()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$discussion_id = random_string('nozero',6);
			$data = array(
					'discussion_id' => $discussion_id,
					'paper_id' => htmlentities($this->input->post('paper_id')),
					'user_id' => $this->user_id(),
					'comment' => htmlentities(trim($this->input->post('comment'))),
					'comment_date' => date('Y-m-d'),
					'parent_id' => htmlentities($this->input->post('parent_id'))
					);
			$this->Sipuma_model->discussion_add($data);
			if (isset($_SERVER['HTTP_REFERER'])){
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				redirect(isset($_SERVER['HTTP_REFERER']));
			}
		}else{
			redirect(base_url());
		}
	}
	
	public function comment_delete()
	{
		$discussion_id = $this->uri->segment(3);
		if($discussion_id==''){
			redirect(base_url());
		}else{
			$this->Sipuma_model->discussion_delete($discussion_id, $this->user_id());
			$this->Sipuma_model->discussion_child_delete($discussion_id);
			if (isset($_SERVER['HTTP_REFERER'])){
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				redirect(isset($_SERVER['HTTP_REFERER']));
			}
		}
	}
	
	public function user_detail()
	{
		$user_id = $this->uri->segment(3);
		$data['heading'] = 'Detail User';
		$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
		$data['journal_member'] = $this->Sipuma_model->journal_member($this->user_id());
		$data['user_other_detail'] = $this->Sipuma_model->user_detail($user_id);
		$data['paper_published_user'] = $this->Sipuma_model->paper_published_user($user_id);
		$data['content'] = $this->core_template().'/dosen_user_detail';
		$this->load->view($this->template(), $data);
	}
	
	public function journal()
	{
		$data['heading'] = 'Manajemen Jurnal';
		$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
		$data['journal_member'] = $this->Sipuma_model->journal_member($this->user_id());
		$data['journal_list_all'] = $this->Sipuma_model->journal_list_all();
		$data['content'] = $this->core_template().'/dosen_journal';
		$this->load->view($this->template(), $data);
	}
	
	public function journal_detail()
	{
		$path = $this->uri->segment(3);
		$config = array();
		$config['base_url'] = base_url().'dosen/journal_detail/'.$path;
		$config['total_rows'] = $this->Sipuma_model->publication_count();
		$config['per_page'] = 15; 
		$config['uri_segment'] = 4;
		$choice = $config['total_rows'] / $config['per_page'];
		$config['num_links'] = round($choice);
		$this->pagination->initialize($config); 
		
		$page = ($this->uri->segment(4))? $this->uri->segment(4) : 0;
		$data['links'] = $this->pagination->create_links();
		$data['heading'] = 'Detail Jurnal';
		$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
		$data['journal_member'] = $this->Sipuma_model->journal_member($this->user_id());
		$data['journal_detail'] = $this->Sipuma_model->journal_detail($path);
		$data['journal_paper_published'] = $this->Sipuma_model->journal_paper_published($path, $config['per_page'], $page);
		$data['content'] = $this->core_template().'/journal';
		$this->load->view($this->template(), $data);
	}
	
	function journal_join()
	{
		$journal_id = $this->uri->segment(3);
		if($journal_id==''){
			redirect(base_url());
		}else{
			$data = array(
				'journal_id' => $journal_id,
				'user_id' => $this->user_id(),
			);
			$this->Sipuma_model->journal_join($data);
			if (isset($_SERVER['HTTP_REFERER'])){
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				redirect(isset($_SERVER['HTTP_REFERER']));
			}
		}
	}
	
	function journal_leave()
	{
		$journal_id = $this->uri->segment(3);
		if($journal_id==''){
			redirect(base_url());
		}else{
			$this->Sipuma_model->journal_leave($journal_id, $this->user_id());
			if (isset($_SERVER['HTTP_REFERER'])){
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				redirect(isset($_SERVER['HTTP_REFERER']));
			}
		}
	}
	
	public function subject_detail()
	{
		$subject_id = $this->uri->segment(3);
		$data['heading'] = 'Manajemen Jurnal';
		$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
		$data['journal_member'] = $this->Sipuma_model->journal_member($this->user_id());
		$data['journal_list'] = $this->Sipuma_model->journal_list($subject_id);
		$data['content'] = $this->core_template().'/dosen_subject_detail';
		$this->load->view($this->template(), $data);
	}
	
	public function paper_list()
	{
		$data['heading'] = 'Manajemen Review';
		$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
		$data['journal_member'] = $this->Sipuma_model->journal_member($this->user_id());
		$data['paper_review'] = $this->Sipuma_model->paper_to_review($this->user_id());
		$data['content'] = $this->core_template().'/dosen_paper_list';
		$this->load->view($this->template(), $data);
	}
	
	public function paper_revision_list()
	{
		$data['heading'] = 'Manajemen Review';
		$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
		$data['journal_member'] = $this->Sipuma_model->journal_member($this->user_id());
		$data['paper_review'] = $this->Sipuma_model->review_revision($this->user_id());
		$data['content'] = $this->core_template().'/dosen_paper_list';
		$this->load->view($this->template(), $data);	
	}
	
	public function review_paper()
	{
		$this->load->library('form_validation');
		$config = array(
				array(
					'field'   => 'review_message', 
                    'label'   => 'Pesan Review', 
                    'rules'   => 'required|max_length[255]',
				)
            );
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', '%s is required');
		
		if($this->form_validation->run() == FALSE)
		{
			$paper_id = $this->uri->segment(3);
			$data['heading'] = 'Tinjauan Karya Ilmiah';
			$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
			$data['journal_member'] = $this->Sipuma_model->journal_member($this->user_id());
			$data['journal_paper'] = $this->Sipuma_model->journal_paper($paper_id);
			$data['paper_detail_review'] = $this->Sipuma_model->paper_detail_review_dosen($paper_id);
			$data['paper_detail_author'] = $this->Sipuma_model->paper_detail_author($paper_id);
			$data['free_user_paper'] = $this->Sipuma_model->free_user_paper_list($paper_id);
			$data['content'] = $this->core_template().'/dosen_review_paper';
			$this->load->view($this->template(), $data);
		}
		else
		{
			$this->paper_reviewed();
		}
	}
	
	function review_paper_revision()
	{
		$this->load->library('form_validation');
		$config = array(
				array(
					'field'   => 'review_message', 
                    'label'   => 'Pesan Review', 
                    'rules'   => 'required|max_length[255]',
				)
            );
		///status paper
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', '%s is required');
		
		if($this->form_validation->run() == FALSE)
		{
			$paper_id = $this->uri->segment(3);
			$data['heading'] = 'Tinjauan Karya Ilmiah';
			$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
			$data['journal_member'] = $this->Sipuma_model->journal_member($this->user_id());
			$data['journal_paper'] = $this->Sipuma_model->journal_paper($paper_id);
			$data['paper_detail_review'] = $this->Sipuma_model->paper_detail_review_dosen_revision($paper_id);
			$data['paper_detail_author'] = $this->Sipuma_model->paper_detail_author($paper_id);
			$data['free_user_paper'] = $this->Sipuma_model->free_user_paper_list($paper_id);
			$data['content'] = $this->core_template().'/dosen_review_paper_revision';
			$this->load->view($this->template(), $data);
		}
		else
		{
			$this->paper_reviewed();
		}
	}
	
	public function paper_reviewed()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$data_revision = array(
						'active' => 'N'
						);
			$this->Sipuma_model->review_update(htmlentities(trim($this->input->post('paper_id'))),$this->user_id(),$data_revision);
			
			$data_review = array (
				'paper_id' => htmlentities(trim($this->input->post('paper_id'))),
				'reviewer_id' => $this->user_id(),
				'review_message' => htmlentities(trim($this->input->post('review_message'))),
				'review_status' => '0',
				'active' => 'Y',
				'review_date' => date("Y-m-d")
				);
			$this->Sipuma_model->review_add($data_review);
			
			$data = array(
					'paper_status' => '3'
				);
			$this->Sipuma_model->paper_status(htmlentities(trim($this->input->post('paper_id'))), $data);

			if (isset($_SERVER['HTTP_REFERER'])){
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				redirect(isset($_SERVER['HTTP_REFERER']));
			}
		}else{
			redirect(base_url());
		}
	}

	public function paper_publish()
	{
		$paper_id = $this->uri->segment(3);
		if($paper_id==''){
			redirect(base_url());
		}else{
			$data_review = array (
				'paper_id' => $paper_id,
				'reviewer_id' => $this->user_id(),
				'review_status' => '2',
				'active' => 'Y',
				'review_date' => date("Y-m-d")
				);
			$this->Sipuma_model->review_add($data_review);
			
			$journal_id = $this->session->userdata('journal_id');
			
			$hitung_accepted = $this->Sipuma_model->paper_accepted_count($paper_id);
			$hitung_reviewer = $this->Sipuma_model->journal_reviewer_count($journal_id);
			
			if($hitung_reviewer >= 3)
			{
				if($hitung_accepted >= 2)
				{
					$data = array(
							'date_published' => date("Y-m-d"),
							'paper_status' => '2'
						);
					$this->Sipuma_model->paper_status($paper_id, $data);
				}else{
					$data = array(
							'paper_status' => '0'
						);
					$this->Sipuma_model->paper_status($paper_id, $data);				
				}
			}
			else if($hitung_reviewer < 3)
			{
				if($hitung_accepted >= 1)
				{
					$data = array(
							'date_published' => date("Y-m-d"),
							'paper_status' => '2'
						);
					$this->Sipuma_model->paper_status($paper_id, $data);		
				}else{
					$data = array(
							'paper_status' => '0'
						);
					$this->Sipuma_model->paper_status($paper_id, $data);
				}
			}
			$this->session->unset_userdata('journal_id');
			if (isset($_SERVER['HTTP_REFERER'])){
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				redirect(isset($_SERVER['HTTP_REFERER']));
			}
		}
	}
	
	public function paper_reject()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$data_review = array(
					'paper_id' => htmlentities(trim($this->input->post('paper_id'))),
					'reviewer_id' => $this->user_id(),
					'review_message' => htmlentities(trim($this->input->post('review_message'))),
					'review_status' => '1',
					'active' => 'Y',
					'review_date' => date("Y-m-d")
					);
			$this->Sipuma_model->paper_review_add($data_review);
			
			$journal_id = $this->session->userdata('journal_id');
			$paper_id = $this->input->post('paper_id');		
			
			$hitung_rejected = $this->Sipuma_model->paper_rejected_count($paper_id);
			$hitung_reviewer = $this->Sipuma_model->journal_reviewer_count($journal_id);
			
 			if($hitung_reviewer >= 3)
			{
				if($hitung_rejected >= 2)
				{ 
					$data = array(
							'paper_status' => '1'
						);
					$this->Sipuma_model->paper_status($paper_id, $data);				
 				}else{
					$data = array(
							'paper_status' => '0'
						);
					$this->Sipuma_model->paper_status($paper_id, $data);
				}
			}
			else if($hitung_reviewer < 3)
			{
				if($hitung_rejected >= 1)
				{
					$data = array(
							'paper_status' => '1'
						);
					$this->Sipuma_model->paper_status($paper_id, $data);				
				}else{
					$data = array(
							'paper_status' => '0'
						);
					$this->Sipuma_model->paper_status($paper_id, $data);
				}
			}
			$this->session->unset_userdata('journal_id');
			if (isset($_SERVER['HTTP_REFERER'])){
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				redirect(isset($_SERVER['HTTP_REFERER']));
			}
		}else{
			redirect(base_url());
		}
	}
	
	public function review_paper_detail()
	{
		$paper_id = $this->uri->segment(3);
		$data['heading'] = 'Manajemen Review';
		$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
		$data['journal_member'] = $this->Sipuma_model->journal_member($this->user_id());
		$data['paper_detail_review'] = $this->Sipuma_model->paper_detail_review_dosen($paper_id);
		$data['paper_detail_author'] = $this->Sipuma_model->paper_detail_author($paper_id);
		$data['content'] = $this->core_template().'/dosen_review_paper';
		$this->load->view($this->template(), $data);
	}
	
	public function review()
	{
		$data['heading'] = 'Manajemen Review';
		$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
		$data['journal_member'] = $this->Sipuma_model->journal_member($this->user_id());
		$data['review_list'] = $this->Sipuma_model->review_list($this->user_id());
		$data['content'] = $this->core_template().'/dosen_review';
		$this->load->view($this->template(), $data);
	}
	
	public function review_detail()
	{
		$paper_id = $this->uri->segment(3);
		$data['heading'] = 'Manajemen Review';
		$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
		$data['journal_member'] = $this->Sipuma_model->journal_member($this->user_id());
		$data['journal_paper'] = $this->Sipuma_model->journal_paper($paper_id);
		$data['paper_detail_review'] = $this->Sipuma_model->paper_detail_review_dosen($paper_id);
		$data['paper_detail_author'] = $this->Sipuma_model->paper_detail_author($paper_id);
		$data['free_user_paper'] = $this->Sipuma_model->free_user_paper_list($paper_id);
		$data['content'] = $this->core_template().'/dosen_review_detail';
		$this->load->view($this->template(), $data);
	}
	
	public function review_delete()
	{
		$review_id = $this->uri->segment(3);
		if($review_id==''){
			redirect(base_url());
		}else{
			$this->Sipuma_model->review_delete($review_id, $this->user_id());
			if (isset($_SERVER['HTTP_REFERER'])){
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				redirect(isset($_SERVER['HTTP_REFERER']));
			}
		}
	}
	
	public function profile()
	{
		$this->load->library('form_validation');
		$config = array(
				array(
					'field'   => 'email', 
                    'label'   => 'Email', 
                    'rules'   => 'required|max_length[50]|valid_email'
				),
				array(
                    'field'   => 'phone_number', 
                    'label'   => 'Nomor Telpon', 
                    'rules'   => 'max_length[20]|numeric'
                ),
				array(
                    'field'   => 'website', 
                    'label'   => 'Alamat Website', 
                    'rules'   => 'max_length[50]|callback__valid_url'
                )
			);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', '%s is required');
			
		if($this->form_validation->run() == FALSE)
		{
			$data['heading'] = 'Manajemen Profil';
			$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
			$data['journal_member'] = $this->Sipuma_model->journal_member($this->user_id());
			$data['profile_detail'] = $this->Sipuma_model->profile_detail($this->user_id());
			$data['content'] = $this->core_template().'/dosen_profile';
			$this->load->view($this->template(), $data);
		}
		else
		{
			$data = array(
					'email' => htmlentities(trim($this->input->post('email'))),
					'phone_number' => htmlentities(trim($this->input->post('phone_number'))),
					'website' => htmlentities(trim($this->input->post('website'))),
					'info' => trim(strip_tags($this->input->post('info'), '<p>, <b>, <strong>, <i>, <em>, <u>, <a>, <ol>, <ul>, <li>, <sup>, <sub>, <br>, <div>, <span>'))
					);
			$this->Sipuma_model->user_edit($this->user_id(), $data);
			$data['heading'] = 'Manajemen Profil';
			$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
			$data['journal_member'] = $this->Sipuma_model->journal_member($this->user_id());
			$data['profile_detail'] = $this->Sipuma_model->profile_detail($this->user_id());
			$data['content'] = $this->core_template().'/dosen_profile_success';
			$this->load->view($this->template(), $data);
		}
	}
	
	function _valid_url($str)
    {
		if($str != ''){
			$pattern = "/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i";
			if (!preg_match($pattern, $str))
			{
				$this->form_validation->set_message('_valid_url', 'The %s field must contain a valid URL.');
				return FALSE;
			}
				return TRUE;
		}
    }
	
	public function password()
	{
		$this->load->library('form_validation');
		$config = array(
				array(
					'field'   => 'password_old', 
                    'label'   => 'Password lama', 
                    'rules'   => 'required|max_length[50]|callback__check_password'
				),
				array(
					'field'   => 'password_new', 
                    'label'   => 'Password baru', 
                    'rules'   => 'required|max_length[50]'
				),
				array(
					'field'   => 'password_new_confirm', 
                    'label'   => 'Password baru(ulangi)', 
                    'rules'   => 'required|matches[password_new]|max_length[50]'
				)
			);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', '%s is required');
			
		if($this->form_validation->run() == FALSE)
		{
			$data['heading'] = 'Ganti Password';
			$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
			$data['journal_member'] = $this->Sipuma_model->journal_member($this->user_id());
			$data['content'] = $this->core_template().'/password';
			$this->load->view($this->template(), $data);
		}
		else
		{
			$data = array(
				'password' => md5($this->input->post('password_new')),
				);	
			$this->Sipuma_model->user_update($this->user_id(), $data);
			$data['heading'] = 'Ganti Password';
			$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
			$data['journal_member'] = $this->Sipuma_model->journal_member($this->user_id());
			$data['content'] = $this->core_template().'/password_success';
			$this->load->view($this->template(), $data);
		}
	}
	
	function _check_password($str)
	{
		if($str != '')
		{
			$user_detail = $this->Sipuma_model->user_detail($this->user_id());
			if($user_detail->password != md5($str)){
				$this->form_validation->set_message('_check_password', 'The %s field does not match with your account.');
				return FALSE;
			}
				return TRUE;
		}
	}
	
	public function contact()
	{
		if($_POST){
			$keyword = $_POST['q'];
			$query = $this->Sipuma_model->user_list_json($keyword, $this->user_id());
			header('Cache-Control: no-cache, must-revalidate');
			header('Content-type: application/json');
			echo json_encode($query);
		}
	}
	
	public function message()
	{
		$this->load->library('form_validation');
		$config = array(
				array(
					'field'   => 'recipient', 
                    'label'   => 'Tujuan', 
                    'rules'   => 'required'
				),
				array(
					'field'   => 'subject', 
                    'label'   => 'Subjek', 
                    'rules'   => 'required|max_length[25]'
				),
				array(
					'field'   => 'message_text', 
                    'label'   => 'Isi Pesan', 
                    'rules'   => 'required|max_length[255]'
				)
			);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', '%s is required');
		
		if($this->form_validation->run() == FALSE)
		{
			$data['heading'] = 'Kirim Pesan';
			$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
			$data['journal_member'] = $this->Sipuma_model->journal_member($this->user_id());
			$data['content'] = $this->core_template().'/dosen_message';
			$this->load->view($this->template(), $data);
		}
		else
		{
			$this->message_send();
		}
	}
	
	public function message_send()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$id = random_string('nozero',6);
			$data = array(
				'message_id' => $id,
				'sender_id' => $this->user_id(),
				'subject' => htmlentities(trim($this->input->post('subject'))),
				'message' => htmlentities(trim($this->input->post('message_text'))),
				'message_date' => date("Y-m-d")
			);	
			$this->Sipuma_model->message_send($data);
			$explode = $this->input->post('recipient');
			$recipient_list = explode(",", $explode);
			if($recipient_list){
				foreach($recipient_list as $recipient){
					if($recipient != ''){
						$data = array(
							'message_id' => $id,
							'recipient_id' => $recipient,
							'message_status' => '0'
							);	
						$this->Sipuma_model->recipient_send($data);
					}
				}
			}
			$data['heading'] = 'Kirim Pesan';
			$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
			$data['journal_member'] = $this->Sipuma_model->journal_member($this->user_id());
			$data['content'] = $this->core_template().'/message_success';
			$this->load->view($this->template(), $data);
		}else{
			redirect(base_url());
		}
	}
	
	public function inbox()
	{
		$data['heading'] = 'Pesan Masuk';
		$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
		$data['journal_member'] = $this->Sipuma_model->journal_member($this->user_id());
		$data['inbox_list'] = $this->Sipuma_model->inbox($this->user_id());
		$data['content'] = $this->core_template().'/dosen_inbox';
		$this->load->view($this->template(), $data);
	}
	
	public function inbox_unread()
	{
		$data['heading'] = 'Pesan Masuk';
		$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
		$data['journal_member'] = $this->Sipuma_model->journal_member($this->user_id());
		$data['inbox_list'] = $this->Sipuma_model->inbox_unread($this->user_id());
		$data['content'] = $this->core_template().'/dosen_inbox';
		$this->load->view($this->template(), $data);
	}
	
	public function message_read()
	{
		$message_status = $this->uri->segment(3);
		$message_id = $this->uri->segment(4);
		if($message_id==''){
			redirect(base_url());
		}else{
			if($message_status == '0'){
				$data = array(
						'message_status' => '1'
						);
				$this->Sipuma_model->message_read($message_id, $this->user_id(), $data);
			}
			$data['heading'] = 'Detail Pesan';
			$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
			$data['journal_member'] = $this->Sipuma_model->journal_member($this->user_id());
			$data['message_detail'] = $this->Sipuma_model->message_detail($message_id);
			$data['content'] = $this->core_template().'/message_read';
			$this->load->view($this->template(), $data);
		}	
	}
	
	public function message_reply()
	{
		$this->load->library('form_validation');
		$config = array(
				array(
					'field'   => 'subject', 
                    'label'   => 'Subjek', 
                    'rules'   => 'required|max_length[25]'
				),
				array(
					'field'   => 'message_text', 
                    'label'   => 'Isi Pesan', 
                    'rules'   => 'required|max_length[255]'
				)
			);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', '%s is required');
		
		if($this->form_validation->run() == FALSE)
		{
			$message_id = $this->uri->segment(3);
			$recipient = $this->uri->segment(4);
			$data['check'] = $this->Sipuma_model->check_message($message_id, $recipient);
			if($data['check']){
				$data['heading'] = 'Kirim Pesan';
				$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
				$data['journal_member'] = $this->Sipuma_model->journal_member($this->user_id());
				$data['content'] = $this->core_template().'/message_reply';
				$this->load->view($this->template(), $data);
			}else{
				redirect(base_url());
			}
		}
		else
		{
			$id = random_string('nozero',6);
			$data = array(
				'message_id' => $id,
				'sender_id' => $this->user_id(),
				'subject' => htmlentities(trim($this->input->post('subject'))),
				'message' => htmlentities(trim($this->input->post('message_text'))),
				'message_date' => date("Y-m-d")
			);	
			$this->Sipuma_model->message_send($data);
			$recipient = htmlentities(trim($this->input->post('recipient_reply')));
			if($recipient){
				$data = array(
					'message_id' => $id,
					'recipient_id' => $recipient,
					'message_status' => '0'
					);	
				$this->Sipuma_model->recipient_send($data);
			}
			$data['heading'] = 'Kirim Pesan';
			$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
			$data['journal_member'] = $this->Sipuma_model->journal_member($this->user_id());
			$data['content'] = $this->core_template().'/message_success';
			$this->load->view($this->template(), $data);
		}
	}
	
	public function message_inbox_delete()
	{
		$message_id = $this->uri->segment(3);
		if($message_id==''){
			redirect(base_url());
		}else{
			$this->Sipuma_model->message_inbox_delete($message_id, $this->user_id());
			if (isset($_SERVER['HTTP_REFERER'])){
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				redirect(isset($_SERVER['HTTP_REFERER']));
			}
		}	
	}
	
	public function outbox()
	{
		$data['heading'] = 'Pesan Keluar';
		$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
		$data['journal_member'] = $this->Sipuma_model->journal_member($this->user_id());
		$data['outbox_list'] = $this->Sipuma_model->outbox($this->user_id());
		$data['content'] = $this->core_template().'/dosen_outbox';
		$this->load->view($this->template(), $data);
	}
	
	public function message_detail()
	{
		$message_id = $this->uri->segment(3);
		if($message_id==''){
			redirect(base_url());
		}else{
			$data['heading'] = 'Detail Pesan';
			$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
			$data['journal_member'] = $this->Sipuma_model->journal_member($this->user_id());
			$data['message_detail'] = $this->Sipuma_model->message_detail($message_id);
			$data['content'] = $this->core_template().'/message_detail';
			$this->load->view($this->template(), $data);
		}
	}
	
	public function message_delete()
	{
		$message_id = $this->uri->segment(3);
		$check = $this->Sipuma_model->check_message_delete($message_id, $this->user_id());
		if($check){
			if($message_id==''){
				redirect(base_url());
			}else{
				$this->Sipuma_model->message_delete($message_id);
				$this->Sipuma_model->message_recipient_delete($message_id);
				if (isset($_SERVER['HTTP_REFERER'])){
					redirect($_SERVER['HTTP_REFERER']);
				}else{
					redirect(isset($_SERVER['HTTP_REFERER']));
				}
			}
		}else{
			redirect(base_url());
		}
	}
	
}