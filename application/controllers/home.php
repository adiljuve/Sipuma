<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller{

	public function __construct()
	{
		parent::__construct();
		$this->is_logged_in();
		$this->load->vars(array(
		'title' => $this->title(),
		'sidebar_left' => $this->core_template().'/sidebar_left',
		'subject_list' => $this->subject_list(),
		'sidebar_right' => $this->core_template().'/sidebar_right'
		));
	}
	
	function is_logged_in()
	{
		$is_logged_in = $this->session->userdata('logged_in_sipuma');
		if(!isset($is_logged_in) || $is_logged_in == true){
			if ($this->session->userdata('login_status') == 'A'){
				redirect('admin');
			}elseif($this->session->userdata('login_status') == 'D'){
				redirect('dosen');
			}elseif($this->session->userdata('login_status') == 'M'){
				redirect('mahasiswa');
			}
		}
	}
	
	public function login()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$this->_review_check();
			$user_id = $this->input->post('user_id');
			$pass = md5($this->input->post('password'));
			$query = $this->Sipuma_model->login($user_id, $pass);	
			if($query){
				if($query->user_type == 'A'){
					$user_type = 'admin';
				}elseif($query->user_type == 'D'){
					$user_type = 'dosen';
				}elseif($query->user_type == 'M'){
					$user_type = 'mahasiswa';
				}
				if($query->user_status == '1'){
					$session = array(
							'user_id' => $user_id,
							'login_status' => $query->user_type,
							'user_type' => $user_type,
							'status' => 'user_sipuma',
							'logged_in_sipuma' => true
							);
					$this->session->set_userdata($session);
					if($query->user_type == 'A'){
						redirect('admin');
					}elseif($query->user_type =='D'){
						redirect('dosen');
					}else{
						redirect('mahasiswa');
					}
				}elseif($query->user_status == '0'){
					echo "<script> window.alert('Maaf, akun Anda belum diaktifkan. Mohon konfirmasi kepada Admin.'); </script><meta http-equiv=refresh content=0;url='".base_url()."'>";
				}
			}else{
				echo "<script> window.alert('User ID dan Password tidak cocok. Mohon ulangi kembali.'); </script><meta http-equiv=refresh content=0;url='".base_url()."'>";
			}
		}else{
				echo "<meta http-equiv=refresh content=0;url='".base_url()."'>";
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
			if($data['column'] == 'title'){
				$config = array();
				$config['base_url'] = base_url().'home/search';
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
				$config['base_url'] = base_url().'home/search';
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
		$data['content'] = $this->core_template().'/home';
		$data['paper_published_list'] = $this->Sipuma_model->paper_published_list();
		$this->load->view($this->template(), $data);
	}

	public function info()
	{
		$data['heading'] = 'Info';
		$data['site_info'] = $this->Sipuma_model->site_info();
		$data['content'] = $this->core_template().'/info';
		$this->load->view($this->template(), $data);
	}
	
	function captchaImg()
    {
		$this->load->library('captcha');
		$captchaImg = $this->captcha->captchaImg();
		return $captchaImg;
    }
	
	public function registration()
	{
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
                ),               
				array(
					'field'   => 'password_confirmation', 
                    'label'   => 'Konfirmasi Password', 
                    'rules'   => 'required|matches[password]|max_length[50]'
                ),
				array(
                    'field'   => 'verification', 
                    'label'   => 'Kode Verifikasi', 
                    'rules'   => 'required|callback__verification'
                )
            );
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', '%s is required');
		
		if($this->form_validation->run() == FALSE)
		{		
			$data['heading'] = 'Registrasi';
			$data['content'] = $this->core_template().'/registration';
			$this->load->view($this->template(), $data);
		}
		else
		{
			if($this->input->post('user_type') != 'A'){
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
					'user_status' => '0'
					);
			$this->Sipuma_model->registration($data);
			$data['heading'] = 'Registrasi';
			$data['content'] = $this->core_template().'/registration_success';
			$this->load->view($this->template(), $data);
			}else{
				redirect(base_url());
			}
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
	
	function _verification($str)
	{
		$this->load->library('captcha');
		$this->CI =& get_instance();
		$key = $this->CI->session->userdata('captchaKey');
		$code = $str;
		if($key == $code){
			return TRUE;
		}else{
			$this->form_validation->set_message('_verification', 'The %s field does not match');
			return FALSE;
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
	
	public function subject()
	{
		$subject_id = $this->uri->segment(3);
		if($subject_id == "all")
		{
			$data['heading'] = 'Daftar Jurnal';
			$data['content'] = $this->core_template().'/journal_list';
			$data['journal_list'] = $this->Sipuma_model->journal_list_all();
			$this->load->view($this->template(), $data);
		}else{
			$data['heading'] = 'Detail Subjek';
			$data['content'] = $this->core_template().'/subject';
			$data['subject_detail'] = $this->Sipuma_model->subject_detail($subject_id);
			$data['journal_list'] = $this->Sipuma_model->journal_list($subject_id);
			$this->load->view($this->template(), $data);
		}
	}

	public function journal()
	{
		$path = $this->uri->segment(3);
		$config = array();
		$config['base_url'] = base_url().'home/journal/'.$path;
		$config['total_rows'] = $this->Sipuma_model->journal_publication_count($path);
		$config['per_page'] = 15; 
		$config['uri_segment'] = 4;
		$choice = $config['total_rows'] / $config['per_page'];
		$config['num_links'] = round($choice);
		$this->pagination->initialize($config); 
		
		$page = ($this->uri->segment(4))? $this->uri->segment(4) : 0;
		$data['links'] = $this->pagination->create_links();
		$data['heading'] = 'Detail Jurnal';
		$data['content'] = $this->core_template().'/journal';
		$data['journal_detail'] = $this->Sipuma_model->journal_detail($path);
		$data['journal_paper_published'] = $this->Sipuma_model->journal_paper_published($path, $config['per_page'], $page);
		$this->load->view($this->template(), $data);	
	}
	
	public function paper()
	{
		$paper_id = $this->uri->segment(3);
		$data['heading'] = 'Detail Publikasi';
		$data['paper_published_detail'] = $this->Sipuma_model->paper_published_detail($paper_id);
		$data['journal_paper'] = $this->Sipuma_model->journal_paper($paper_id);
		$data['paper_detail_author'] = $this->Sipuma_model->paper_detail_author($paper_id);
		$data['free_user_paper'] = $this->Sipuma_model->free_user_paper_list($paper_id);
		$data['discussion_list'] = $this->Sipuma_model->discussion_list($paper_id);
		$data['content'] = $this->core_template().'/paper';
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
		$paper_published_detail = $this->Sipuma_model->paper_published_detail($paper_id);
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
		$paper_published_detail = $this->Sipuma_model->paper_published_detail($paper_id);
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
	
	public function user_detail()
	{
		$user_id = $this->uri->segment(3);
		$data['heading'] = 'Detail User';
		$data['subject_list'] = $this->Sipuma_model->subject_list();
		$data['user_detail'] = $this->Sipuma_model->user_detail($user_id);
		$data['paper_published_user'] = $this->Sipuma_model->paper_published_user($user_id);
		$data['content'] = $this->core_template().'/user_detail';
		$this->load->view($this->template(), $data);
	}
	
	function _review_check()
	{
		$prev_day = time() + (-7 * 24 * 60 * 60); //7 hari batas review oleh dosen setelah revisi
		$day_limit = date('Y-m-d', $prev_day);
		$review = $this->Sipuma_model->review_check($day_limit);
		
		$data_paper = array (
			'paper_status' => '0',
		);
		$data_review = array (
			'active' => 'N',
		);
		if($review){
			foreach($review as $review_detail){
				$this->Sipuma_model->paper_edit($review_detail->paper_id, $data_paper);
				$this->Sipuma_model->review_check_update($review_detail->review_id, $data_review);
			}
		}
	}
	
}