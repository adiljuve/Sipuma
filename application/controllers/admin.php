<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->is_logged_in();
		$this->load->vars(array(
		'journal_stats'=>$this->Sipuma_model->journal_stats(),
		'user_stats'=>$this->Sipuma_model->user_stats(),
		'paper_stats'=>$this->Sipuma_model->paper_stats(),
		'review_stats'=>$this->Sipuma_model->review_stats(),
		'journal_max_paper'=>$this->Sipuma_model->journal_max_paper(),
		'user_max_paper'=>$this->Sipuma_model->user_max_paper(),
		'sidebar_user'=>$this->core_template().'/sidebar_admin',
		));
	}
	
	function is_logged_in() 
	{
		$is_logged_in = $this->session->userdata('logged_in_sipuma');
		$status = $this->session->userdata('login_status');
		if(!isset($is_logged_in) || $is_logged_in != true || $status != 'A')
		{
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
			if($data['column'] == 'title'){
				$config = array();
				$config['base_url'] = base_url().'admin/search';
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
				$config['base_url'] = base_url().'admin/search';
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
		$data['paper_published_list'] = $this->Sipuma_model->paper_published_list();
		$data['content'] = $this->core_template().'/admin_home';
		$this->load->view($this->template(), $data);
	}
	
	public function paper_detail()
	{
		$paper_id = $this->uri->segment(3);
		$data['heading'] = 'Manajemen Karya Ilmiah';
		$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
		$data['paper_detail'] = $this->Sipuma_model->paper_published_detail($paper_id);
		$data['journal_paper'] = $this->Sipuma_model->journal_paper($paper_id);
		$data['paper_detail_author'] = $this->Sipuma_model->paper_detail_author($paper_id);
		$data['free_user_paper'] = $this->Sipuma_model->free_user_paper_list($paper_id);
		$data['discussion_list'] = $this->Sipuma_model->discussion_list($paper_id);
		$data['content'] = $this->core_template().'/admin_paper_detail';
		$this->load->view($this->template(), $data);
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
		$paper_published_detail = $this->Sipuma_model->paper_detail($paper_id);
		if ($paper_published_detail){
			if (file_exists($paper_published_detail->file_directory.$paper_published_detail->file_name)){
				$file_data = file_get_contents($paper_published_detail->file_directory.$paper_published_detail->file_name);
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
		$paper_published_detail = $this->Sipuma_model->paper_detail($paper_id);
		if ($paper_published_detail){
			if (file_exists($paper_published_detail->file_directory.$paper_published_detail->file_name)){
				$file_data = file_get_contents($paper_published_detail->file_directory.$paper_published_detail->file_name);
				$file_name = $paper_published_detail->paper_id.'-'.$paper_published_detail->file_name;
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
			$this->Sipuma_model->admin_discussion_delete($discussion_id);
			$this->Sipuma_model->discussion_child_delete($discussion_id);
			if (isset($_SERVER['HTTP_REFERER'])){
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				redirect(isset($_SERVER['HTTP_REFERER']));
			}
		}
	}
	
	public function subject()
	{
		$this->load->library('form_validation');
		$config = array(
				array(
					'field'   => 'subject_name', 
                    'label'   => 'Nama Subjek', 
                    'rules'   => 'required|max_length[50]'
				)
            );
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', '%s is required');
		
		if($this->form_validation->run() == FALSE)
		{
			$data['heading'] = 'Manajemen Subjek';
			$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
			$data['subject_list'] = $this->Sipuma_model->subject_list();
			$data['content'] = $this->core_template().'/admin_subject';
			$this->load->view($this->template(), $data);
		}
		else
		{
			$this->subject_add();
		}
	}
	
	public function subject_detail()
	{
		$subject_id = $this->uri->segment(3);
		$data['heading'] = 'Manajemen Subjek';
		$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
		$data['subject_detail'] = $this->Sipuma_model->subject_detail($subject_id);
		$data['journal_list'] = $this->Sipuma_model->journal_list($subject_id);
		$data['content'] = $this->core_template().'/admin_subject_detail';
		$this->load->view($this->template(), $data);
	}
	
	public function subject_add()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$data = array(
					'subject_name' => htmlentities(trim($this->input->post('subject_name')))
					);
			$this->Sipuma_model->subject_add($data);
			if (isset($_SERVER['HTTP_REFERER'])){
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				redirect(isset($_SERVER['HTTP_REFERER']));
			}
		}else{
			redirect(base_url());
		}
	}
	
	public function subject_edit()
	{
		$this->load->library('form_validation');
		$config = array(
				array(
					'field'   => 'subject_name', 
                    'label'   => 'Nama Subjek', 
                    'rules'   => 'required|max_length[50]'
				)
            );
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', '%s is required');
		
		if($this->form_validation->run() == FALSE)
		{
			$subject_id = $this->uri->segment(3);
			$data['heading'] = 'Manajemen Subjek';
			$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
			$data['subject_detail'] = $this->Sipuma_model->subject_detail($subject_id);
			$data['content'] = $this->core_template().'/admin_subject_edit';
			$this->load->view($this->template(), $data);
		}
		else
		{
			$subject_id = $this->uri->segment(3);
			if ($_SERVER['REQUEST_METHOD'] == 'POST'){
				$data = array(
						'subject_name' => htmlentities(trim($this->input->post('subject_name')))
						);
				$this->Sipuma_model->subject_edit($subject_id, $data);
				echo "<script>window.alert('Perubahan Subjek berhasil'); window.location.href='".base_url()."admin/subject';</script>";
			}
		}
	}
	
	public function subject_delete()
	{
		$subject_id = $this->uri->segment(3);
		$journal_count = $this->Sipuma_model->journal_count($subject_id);
		if($journal_count == 0){
			if($subject_id==''){
				redirect(base_url());
			}else{
				$this->Sipuma_model->subject_delete($subject_id);
				$this->Sipuma_model->subject_journal_delete('subject_id', $subject_id);
				if (isset($_SERVER['HTTP_REFERER'])){
					redirect($_SERVER['HTTP_REFERER']);
				}else{
					redirect(isset($_SERVER['HTTP_REFERER']));
				}
			}
		}else{
			echo "<script>window.alert('Subjek tidak dapat dihapus karena masih terkait dengan beberapa jurnal'); window.location.href='".base_url()."admin/subject';</script>";
		}	
	}
	
	public function journal()
	{
		$this->load->library('form_validation');
		$config = array(
				array(
					'field'   => 'journal_name', 
                    'label'   => 'Nama Jurnal', 
                    'rules'   => 'required|max_length[100]'
				),
				array(
					'field'   => 'subject_id', 
                    'label'   => 'Subjek', 
                    'rules'   => 'required'
				),
				array(
					'field'   => 'path', 
                    'label'   => 'Path', 
                    'rules'   => 'required|max_length[25]'
				)
            );
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', '%s is required');
		
		if($this->form_validation->run() == FALSE)
		{
			$data['heading'] = 'Manajemen Jurnal';
			$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
			$data['subject_list'] = $this->Sipuma_model->subject_list();
			$data['journal_list_all'] = $this->Sipuma_model->journal_list_all();
			$data['content'] = $this->core_template().'/admin_journal';
			$this->load->view($this->template(), $data);
		}
		else
		{
			$this->journal_add();
		}
	}
	
	public function journal_detail()
	{
		$path = $this->uri->segment(3);
		$config = array();
		$config['base_url'] = base_url().'admin/journal_detail/'.$path;
		$config['total_rows'] = $this->Sipuma_model->publication_count();
		$config['per_page'] = 15; 
		$config['uri_segment'] = 4;
		$choice = $config['total_rows'] / $config['per_page'];
		$config['num_links'] = round($choice);
		$this->pagination->initialize($config); 
		
		$page = ($this->uri->segment(4))? $this->uri->segment(4) : 0;
		$data['links'] = $this->pagination->create_links();
		$data['heading'] = 'Manajemen Jurnal';
		$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
		$data['subject_list'] = $this->Sipuma_model->subject_list();
		$data['journal_detail'] = $this->Sipuma_model->journal_detail($path);
		$data['journal_paper_published'] = $this->Sipuma_model->journal_paper_published($path, $config['per_page'], $page);
		$data['content'] = $this->core_template().'/journal';
		$this->load->view($this->template(), $data);
	}
	
	public function journal_member()
	{
		$url = $this->uri->segment(2).'/'.$this->uri->segment(3);
		$this->session->set_userdata('redirect', $url);
		
		$path = $this->uri->segment(3);
		$data['heading'] = 'Manajemen Jurnal';
		$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
		$data['journal_detail'] = $this->Sipuma_model->journal_detail($path);
		$data['member_journal'] = $this->Sipuma_model->member_journal($path);
		$data['content'] = $this->core_template().'/admin_journal_member';
		$this->load->view($this->template(), $data);
	}
	
	public function journal_add()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$check_url = $this->Sipuma_model->journal_check(htmlentities(trim($this->input->post('path'))));
			if($check_url==0){
				$journal_id = random_string('nozero',6);
				$data = array(
						'journal_id' => $journal_id,
						'journal_name' => htmlentities(trim($this->input->post('journal_name'))),
						'path' => htmlentities(trim($this->input->post('path'))),
						'info' => trim(strip_tags($this->input->post('info'), '<p>, <b>, <strong>, <i>, <em>, <u>, <a>, <ol>, <ul>, <li>, <sup>, <sub>, <br>, <div>, <span>'))
						);
				$this->Sipuma_model->journal_add($data);
				$subject_list = $this->input->post('subject_id');
				if ($subject_list){
					foreach ($subject_list as $subject){
					$data = array(
						'subject_id' => $subject,
						'journal_id' => $journal_id
						);	
					$this->Sipuma_model->subject_journal_add($data);
					}
				}
				$new_folder = 'files/journal/'.$this->input->post('path');
				if(!is_dir($new_folder)){
					mkdir('files/journal/'.$this->input->post('path'));
					write_file('files/journal/'.$this->input->post('path').'/index.html', 'forbidden directory', 'x');
					echo "<script>window.alert('Penambahan Jurnal berhasil'); window.location.href='".base_url()."admin/journal';</script>";
				}else{
					echo "<script>window.alert('Penambahan Jurnal berhasil'); window.location.href='".base_url()."admin/journal';</script>";
				}				
			}else{
				echo "<script>window.alert('Maaf, penambahan jurnal gagal. Sudah ada jurnal dengan Path yang sama. Silakan menggunakan Path yang lain.'); window.location.href='".base_url()."admin/journal';</script>";
			}
		}else{
			redirect(base_url());
		}
	}
	
	public function journal_edit()
	{
		$this->load->library('form_validation');
		$config = array(
				array(
					'field'   => 'journal_name', 
                    'label'   => 'Nama Jurnal', 
                    'rules'   => 'required|max_length[100]'
				),
				array(
					'field'   => 'subject_id', 
                    'label'   => 'Subjek', 
                    'rules'   => 'required'
				)
            );
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', '%s is required');
		
		if($this->form_validation->run() == FALSE)
		{
			$path = $this->uri->segment(3);
			$data['heading'] = 'Manajemen Jurnal';
			$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
			$data['subject_list'] = $this->Sipuma_model->subject_list();
			$data['journal_detail'] = $this->Sipuma_model->journal_detail($path);
			$data['content'] = $this->core_template().'/admin_journal_edit';
			$this->load->view($this->template(), $data);
		}
		else
		{
			$path = $this->uri->segment(3);
			if ($_SERVER['REQUEST_METHOD'] == 'POST'){
				$data = array(
						'journal_name' => htmlentities(trim($this->input->post('journal_name'))),
						'info' => trim(strip_tags($this->input->post('info'), '<p>, <b>, <strong>, <i>, <em>, <u>, <a>, <ol>, <ul>, <li>, <sup>, <sub>, <br>, <div>, <span>'))
						);
				$this->Sipuma_model->journal_edit($path, $data);
				$this->Sipuma_model->subject_journal_delete('journal_id', $this->input->post('journal_id'));
				$subject_list = $this->input->post('subject_id');
				if ($subject_list){
					foreach ($subject_list as $subject){
					$data = array(
						'subject_id' => $subject,
						'journal_id' => $this->input->post('journal_id')
						);	
					$this->Sipuma_model->subject_journal_add($data);
					}
				}
				echo "<script>window.alert('Perubahan Jurnal berhasil'); window.location.href='".base_url()."admin/journal';</script>";
			}
		}
	}
	
	public function journal_delete()
	{
		$path = $this->uri->segment(3);
		$journal_id = $this->uri->segment(4);
		$paper_count = $this->Sipuma_model->paper_count($journal_id);
		if($paper_count == 0){
			if($journal_id==''){
				redirect(base_url());
			}else{
				$dir = 'files/journal/'.$path;
				$handle = opendir($dir);
				while (($file = readdir($handle))!==false) {
					@unlink($dir.'/'.$file);
				}
				closedir($handle);
				rmdir($dir);
				$this->Sipuma_model->journal_delete($journal_id);
				$this->Sipuma_model->subject_journal_delete('journal_id', $journal_id);
				if (isset($_SERVER['HTTP_REFERER'])){
					redirect($_SERVER['HTTP_REFERER']);
				}else{
					redirect(isset($_SERVER['HTTP_REFERER']));
				}
			}
		}else{
			echo "<script>window.alert('Jurnal tidak dapat dihapus karena masih berhubungan dengan beberapa karya ilmiah'); window.location.href='".base_url()."admin/journal';</script>";
		}
	}
	
	public function paper()
	{
		$data['heading'] = 'Manajemen Karya Ilmiah';
		$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
		$data['paper_list'] = $this->Sipuma_model->paper_list();
		$data['content'] = $this->core_template().'/admin_paper';
		$this->load->view($this->template(), $data);
	}
	
	public function review_detail()
	{
		$paper_id = $this->uri->segment(3);
		$data['heading'] = 'Tinjauan Karya Ilmiah';
		$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
		$data['journal_member'] = $this->Sipuma_model->journal_member($this->user_id());
		$data['journal_paper'] = $this->Sipuma_model->journal_paper($paper_id);
		$data['paper_detail_review'] = $this->Sipuma_model->paper_detail_review_dosen($paper_id);
		$data['paper_detail_author'] = $this->Sipuma_model->paper_detail_author($paper_id);
		$data['free_user_paper'] = $this->Sipuma_model->free_user_paper_list($paper_id);
		$data['content'] = $this->core_template().'/admin_review';
		$this->load->view($this->template(), $data);	
	}
	
	public function review_delete()
	{
		$review_id = $this->uri->segment(3);
		if($review_id==''){
			redirect(base_url());
		}else{
			$this->Sipuma_model->admin_review_delete($review_id);
			if (isset($_SERVER['HTTP_REFERER'])){
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				redirect(isset($_SERVER['HTTP_REFERER']));
			}
		}
	}
	
	public function paper_delete()
	{
		$paper_id = $this->uri->segment(3);
		if($paper_id==''){
			redirect(base_url());
		}else{
			$this->Sipuma_model->paper_delete($paper_id);
			$this->Sipuma_model->paper_delete_user($paper_id);
			$this->Sipuma_model->paper_delete_free_user($paper_id);
			$this->Sipuma_model->paper_delete_discussion($paper_id);
			if (isset($_SERVER['HTTP_REFERER'])){
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				redirect(isset($_SERVER['HTTP_REFERER']));
			}
		}
	}
	
	function file_delete()
	{
		$file_id = $this->uri->segment(3);
		if($file_id==''){
			redirect(base_url());
		}else{
			$select = $this->Sipuma_model->file_detail($file_id);
			unlink($select->file_directory.$select->file_name);
			$this->Sipuma_model->file_delete($file_id);
			if (isset($_SERVER['HTTP_REFERER'])){
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				redirect(isset($_SERVER['HTTP_REFERER']));
			}
		}
	}
	
	public function user()
	{
		$url = $this->uri->segment(2).'/'.$this->uri->segment(3);
		$this->session->set_userdata('redirect', $url);
		$this->load->library('form_validation');
		$config = array(
				array(
					'field'   => 'user_type', 
                    'label'   => 'Tipe Akun', 
                    'rules'   => 'required',
				),
				array(
                    'field'   => 'user_id', 
                    'label'   => 'ID', 
                    'rules'   => 'required|max_length[25]|callback__user_id_check',
                ),
				array(
                    'field'   => 'full_name', 
                    'label'   => 'Nama Lengkap', 
                    'rules'   => 'required|max_length[50]'
                ),
				array(
                    'field'   => 'gender', 
                    'label'   => 'Jenis Kelamin', 
                    'rules'   => 'required'
                ),
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
                ),
				array(
                    'field'   => 'password', 
                    'label'   => 'Password', 
                    'rules'   => 'required|max_length[50]'
                )
            );
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', '%s is required');
		
		if($this->form_validation->run() == FALSE)
		{		
			$data['heading'] = 'Manajemen User';
			$data['user_detail'] = $this->Sipuma_model->user_detail($this->session->userdata('user_id'));
			$data['user_list'] = $this->Sipuma_model->user_list($this->user_id());
			$data['content'] = $this->core_template().'/admin_user';
			$this->load->view($this->template(), $data);
		}
		else
		{
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				$user_id_check = $this->Sipuma_model->user_id_check(trim($this->input->post('user_id')));
				if($user_id_check == 0){
					$data = array(
							'user_id' => htmlentities(trim($this->input->post('user_id'))),
							'password' => md5($this->input->post('password')),
							'full_name' => htmlentities(trim($this->input->post('full_name'))),
							'gender' => htmlentities(trim($this->input->post('gender'))),
							'email' => htmlentities(trim($this->input->post('email'))),
							'phone_number' => htmlentities(trim($this->input->post('phone_number'))),
							'website' => htmlentities(trim($this->input->post('website'))),
							'date_registered' => date("Y-m-d"),
							'user_type' => htmlentities(trim($this->input->post('user_type'))),
							'user_status' => htmlentities(trim($this->input->post('user_status'))),
							);
					$this->Sipuma_model->register($data);	
					echo "<script>window.alert('Penambahan user berhasil')</script><meta http-equiv=refresh content=0;url='user'>";
				}else{
					echo "<script>window.alert('Penambahan user gagal, ID yang Anda masukkan sudah terdaftar sebelumnya.')</script><meta http-equiv=refresh content=0;url='user'>";
				}
			}
		}
	}
	
	public function user_type()
	{
		$url = $this->uri->segment(2).'/'.$this->uri->segment(3);
		$this->session->set_userdata('redirect', $url);
		
		$user_type = $this->uri->segment(3);
		if(($user_type == 'D') || ($user_type == 'M')){
			$this->load->library('form_validation');
			$config = array(
					array(
						'field'   => 'user_type', 
						'label'   => 'Tipe Akun', 
						'rules'   => 'required',
					),
					array(
						'field'   => 'user_id', 
						'label'   => 'ID', 
						'rules'   => 'required|max_length[25]|callback__user_id_check',
					),
					array(
						'field'   => 'full_name', 
						'label'   => 'Nama Lengkap', 
						'rules'   => 'required|max_length[50]'
					),
					array(
						'field'   => 'gender', 
						'label'   => 'Jenis Kelamin', 
						'rules'   => 'required'
					),
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
					),
					array(
						'field'   => 'password', 
						'label'   => 'Password', 
						'rules'   => 'required|max_length[50]'
					)
				);
			$this->form_validation->set_rules($config);
			$this->form_validation->set_message('required', '%s is required');
		
			if($this->form_validation->run() == FALSE)
			{
				$data['heading'] = 'Manajemen User';
				$data['user_detail'] = $this->Sipuma_model->user_detail($this->session->userdata('user_id'));
				$data['user_list'] = $this->Sipuma_model->user_type($user_type);
				$data['content'] = $this->core_template().'/admin_user';
				$this->load->view($this->template(), $data);
			}
			else
			{
				if($_SERVER['REQUEST_METHOD'] == 'POST'){
					$user_id_check = $this->Sipuma_model->user_id_check(trim($this->input->post('user_id')));
					if($user_id_check == 0){
						$data = array(
								'user_id' => htmlentities(trim($this->input->post('user_id'))),
								'password' => md5($this->input->post('password')),
								'full_name' => htmlentities(trim($this->input->post('full_name'))),
								'gender' => htmlentities(trim($this->input->post('gender'))),
								'email' => htmlentities(trim($this->input->post('email'))),
								'phone_number' => htmlentities(trim($this->input->post('phone_number'))),
								'website' => htmlentities(trim($this->input->post('website'))),
								'date_registered' => date("Y-m-d"),
								'user_type' => htmlentities(trim($this->input->post('user_type'))),
								'user_status' => htmlentities(trim($this->input->post('user_status'))),
								);
						$this->Sipuma_model->register($data);	
						echo "<script>window.alert('Penambahan user berhasil')</script><meta http-equiv=refresh content=0>";
					}else{
						echo "<script>window.alert('Penambahan user gagal, ID yang Anda masukkan sudah terdaftar sebelumnya.')</script><meta http-equiv=refresh content=0>";
					}
				}
			}
		}else{
			redirect(isset($_SERVER['HTTP_REFERER']));
		}
	}
	
	public function user_inactive()
	{
		$data['heading'] = 'Manajemen User';
		$data['user_detail'] = $this->Sipuma_model->user_detail($this->session->userdata('user_id'));
		$data['user_list'] = $this->Sipuma_model->user_inactive_list($this->user_id());
		$data['content'] = $this->core_template().'/admin_user_inactive';
		$this->load->view($this->template(), $data);
	}
	
	public function user_detail()
	{
		$user_id = $this->uri->segment(3);
		$data['heading'] = 'Manajemen Jurnal';
		$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
		$data['subject_list'] = $this->Sipuma_model->subject_list();
		$data['user_detail'] = $this->Sipuma_model->user_detail($user_id);
		$data['paper_user'] = $this->Sipuma_model->paper_user($user_id);
		$data['content'] = $this->core_template().'/admin_user_detail';
		$this->load->view($this->template(), $data);
	}
	
	public function user_delete()
	{
		$user_id = $this->uri->segment(3);
		if($user_id==''){
			redirect(base_url());
		}else{
			$this->Sipuma_model->user_delete($user_id);
			$this->Sipuma_model->user_paper_delete_user($user_id);
			if (isset($_SERVER['HTTP_REFERER'])){
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				redirect(isset($_SERVER['HTTP_REFERER']));
			}
		}
	}
	
	public function password_reset()
	{	
		$user_id = $this->uri->segment(3);
		if($user_id == ''){
			if (isset($_SERVER['HTTP_REFERER'])){
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				redirect(isset($_SERVER['HTTP_REFERER']));
			}
		}else{
			$data = array (
				'password' => md5($user_id)
			);
			$this->Sipuma_model->user_edit($user_id, $data);
			if (isset($_SERVER['HTTP_REFERER'])){
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				redirect(isset($_SERVER['HTTP_REFERER']));
			}
		}
	}
	
	public function activate()
	{
		$user_id = $this->uri->segment(3);
		if($user_id==''){
			redirect(base_url());
		}else{
			$data = array (
				'user_status' => '1'
			);
			$this->Sipuma_model->user_activation($user_id, $data);
			if (isset($_SERVER['HTTP_REFERER'])){
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				redirect(isset($_SERVER['HTTP_REFERER']));
			}
		}
	}
	
	public function deactivate()
	{
		$user_id = $this->uri->segment(3);
		if($user_id==''){
			redirect(base_url());
		}else{
			$data = array (
				'user_status' => '0'
			);
			$this->Sipuma_model->user_deactivation($user_id, $data);
			if (isset($_SERVER['HTTP_REFERER'])){
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				redirect(isset($_SERVER['HTTP_REFERER']));
			}
		}
	}
	
	public function user_edit()
	{
		$this->load->library('form_validation');
		$config = array(
				array(
                    'field'   => 'full_name', 
                    'label'   => 'Nama Lengkap', 
                    'rules'   => 'required|max_length[50]'
                ),
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
		
		$user_id = $this->uri->segment(3);
		
		if($this->form_validation->run() == FALSE)
		{
			
			$data['heading'] = 'Manajemen User';
			$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
			$data['user_detail'] = $this->Sipuma_model->user_detail($user_id);
			$data['content'] = $this->core_template().'/admin_user_edit';
			$this->load->view($this->template(), $data);
		}
		else
		{
			if ($_SERVER['REQUEST_METHOD'] == 'POST'){
				$data = array(
							'full_name' => htmlentities(trim($this->input->post('full_name'))),
							'gender' => htmlentities(trim($this->input->post('gender'))),
							'email' => htmlentities(trim($this->input->post('email'))),
							'phone_number' => htmlentities(trim($this->input->post('phone_number'))),
							'website' => htmlentities(trim($this->input->post('website'))),
							'user_type' => htmlentities(trim($this->input->post('user_type'))),
							'user_status' => htmlentities(trim($this->input->post('user_status'))),
							'info' => trim(strip_tags($this->input->post('info'), '<p>, <b>, <strong>, <i>, <em>, <u>, <a>, <ol>, <ul>, <li>, <sup>, <sub>, <br>, <div>, <span>'))
						);
				$this->Sipuma_model->user_edit($user_id, $data);
				$redirect = $this->session->userdata('redirect');
				echo "<script>window.alert('Perubahan User berhasil'); window.location.href='".base_url()."admin/".$redirect."';</script>";
			}
		}
	}
	
	public function site_info()
	{
		$this->load->library('form_validation');
		$config = array(
				array(
					'field'   => 'title', 
                    'label'   => 'Judul', 
                    'rules'   => 'required|max_length[100]'
				),
				array(
					'field'   => 'owner', 
                    'label'   => 'Nama Instansi', 
                    'rules'   => 'required|max_length[100]'
				),
				array(
					'field'   => 'phone_number', 
                    'label'   => 'No. Telepon', 
                    'rules'   => 'max_length[20]'
				),
				array(
					'field'   => 'fax', 
                    'label'   => 'Fax', 
                    'rules'   => 'max_length[50]'
				),
				array(
					'field'   => 'email', 
                    'label'   => 'Email', 
                    'rules'   => 'valid_email|max_length[50]'
				),
				array(
					'field'   => 'address', 
                    'label'   => 'Alamat', 
                    'rules'   => 'max_length[100]'
				)
            );
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', '%s is required');
		
		if($this->form_validation->run() == FALSE)
		{
			$data['heading'] = 'Administrator';
			$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
			$data['site_info'] = $this->Sipuma_model->site_info();
			$data['content'] = $this->core_template().'/admin_site';
			$this->load->view($this->template(), $data);
		}
		else
		{
			$data = array(
					'title' => htmlentities(trim($this->input->post('title'))),
					'owner' => htmlentities(trim($this->input->post('owner'))),
					'phone_number' => htmlentities(trim($this->input->post('phone_number'))),
					'fax' => htmlentities(trim($this->input->post('fax'))),
					'email' => htmlentities(trim($this->input->post('email'))),
					'address' => htmlentities(trim($this->input->post('address'))),
					'info' => trim(strip_tags($this->input->post('info'), '<p>, <b>, <strong>, <i>, <em>, <u>, <a>, <ol>, <ul>, <li>, <sup>, <sub>, <br>, <div>, <span>'))
					);
			$this->Sipuma_model->edit_site_info($data);
			redirect('admin/site_info');
		}
	}
	
	public function profile()
	{
		$this->load->library('form_validation');
		$config = array(
				array(
					'field'   => 'user_id', 
                    'label'   => 'ID', 
                    'rules'   => 'required|max_length[25]|callback__user_id_check'
				),
				array(
					'field'   => 'full_name', 
                    'label'   => 'Nama Lengkap', 
                    'rules'   => 'required|max_length[50]'
				),
				array(
					'field'   => 'email', 
                    'label'   => 'Email', 
                    'rules'   => 'required|valid_email|max_length[50]'
				),
				array(
					'field'   => 'phone_number', 
                    'label'   => 'Nomor Telepon', 
                    'rules'   => 'max_length[20]'
				),
				array(
					'field'   => 'website', 
                    'label'   => 'Website', 
                    'rules'   => 'max_length[50]|callback__valid_url'
				)
            );
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', '%s is required');
		
		if($this->form_validation->run() == FALSE)
		{
			$data['heading'] = 'Administrator';
			$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
			$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
			$data['content'] = $this->core_template().'/admin_profile';
			$this->load->view($this->template(), $data);
		}
		else
		{
			$data = array(
					'user_id' => htmlentities(trim($this->input->post('user_id'))),
					'full_name' => htmlentities(trim($this->input->post('full_name'))),
					'gender' => htmlentities(trim($this->input->post('gender'))),
					'email' => htmlentities(trim($this->input->post('email'))),
					'phone_number' => htmlentities(trim($this->input->post('phone_number'))),
					'website' => htmlentities(trim($this->input->post('website'))),
					'info' => trim(strip_tags($this->input->post('info'), '<p>, <b>, <strong>, <i>, <em>, <u>, <a>, <ol>, <ul>, <li>, <sup>, <sub>, <br>, <div>, <span>'))
					);
			$this->Sipuma_model->user_update($this->user_id(), $data);
			$data['heading'] = 'Administrator';
			$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
			$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
			$data['content'] = $this->core_template().'/admin_profile_success';
			$this->load->view($this->template(), $data);
		}
	}
	
	function _user_id_check($str)
	{
		$user_id_check = $this->Sipuma_model->user_id_check(trim($str));
		if($user_id_check == 0){
			return TRUE;
		}else{
			$this->form_validation->set_message('_user_id_check', 'The %s field does exist');
			return FALSE;
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
			$data['heading'] = 'Administrator';
			$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
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
	
	public function message_list()
	{
		$data['heading'] = 'Daftar Pesan';
		$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
		$data['message_list'] = $this->Sipuma_model->message_list();
		$data['content'] = $this->core_template().'/admin_message_list';
		$this->load->view($this->template(), $data);
	}	
	
	public function message_detail()
	{
		$message_id = $this->uri->segment(3);
		$data['heading'] = 'Detail Pesan';
		$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
		$data['subject_list'] = $this->Sipuma_model->subject_list();
		$data['message_detail'] = $this->Sipuma_model->message_detail($message_id);
		$data['content'] = $this->core_template().'/message_detail';
		$this->load->view($this->template(), $data);
	}
	
	public function message_delete()
	{
		$message_id = $this->uri->segment(3);
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
			$data['content'] = $this->core_template().'/admin_message';
			$this->load->view($this->template(), $data);
		}
		else
		{
			$this->message_send();
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

	public function message_send()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
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
		$data['inbox_list'] = $this->Sipuma_model->inbox($this->user_id());
		$data['content'] = $this->core_template().'/admin_inbox';
		$this->load->view($this->template(), $data);
	}
	
	public function inbox_unread()
	{
		$data['heading'] = 'Pesan Masuk';
		$data['user_detail'] = $this->Sipuma_model->user_detail($this->user_id());
		$data['journal_member'] = $this->Sipuma_model->journal_member($this->user_id());
		$data['inbox_list'] = $this->Sipuma_model->inbox_unread($this->user_id());
		$data['content'] = $this->core_template().'/admin_inbox';
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
			$data['subject_list'] = $this->Sipuma_model->subject_list();
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
		$data['outbox_list'] = $this->Sipuma_model->outbox($this->user_id());
		$data['content'] = $this->core_template().'/admin_outbox';
		$this->load->view($this->template(), $data);
	}
	
}