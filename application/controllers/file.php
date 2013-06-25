<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class File extends MY_Controller{

	public function __construct()
	{
		parent::__construct();
	}
	
	public function revision()
	{
		$data['file_id'] = $this->uri->segment(3);
		$this->load->view($this->core_template().'/file_revision', $data);
	}
	
	public function preview()
	{
		$this->load->helper('download');
		$file_id = $this->uri->segment(3);
		$paper_detail = $this->Sipuma_model->file_revision_read($file_id);
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
		$file_id = $this->uri->segment(3);
		$paper_detail = $this->Sipuma_model->file_revision_read($file_id);
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
	
}