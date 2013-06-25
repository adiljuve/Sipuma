<?php
class Sipuma_model extends CI_Model
{
	/**************CONSTRUCT**************/
	function __construct()
	{
		parent::__construct();	
	}
	/**************CONSTRUCT**************/
	function review_check($limit_day)
	{
		$this->db->select('*');
		$this->db->from('review');
		$this->db->where('review_status','3');
		$this->db->where('active','Y');			
		$this->db->where('review_date <',$limit_day);
		return $this->db->get()->result();
	}
	
	function review_check_update($review_id, $data)
	{
		$this->db->where('review_id', $review_id);
		$this->db->update('review', $data);
	}
	
	function paper_accepted_count($paper_id)//cek jumlah suara diterima dari reviewer/dosen
	{
		$this->db->select('*');
		$this->db->from('review');
		$this->db->join('paper', 'paper.paper_id = review.paper_id');
		$this->db->where('review.paper_id',$paper_id);
		$this->db->where('review_status','2');
		$this->db->where('active','Y');
		//return $this->db->get()->row();
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	function paper_rejected_count($paper_id)
	{
		$this->db->select('*');
		$this->db->from('review');
		$this->db->join('paper', 'paper.paper_id = review.paper_id');
		$this->db->where('review.paper_id',$paper_id);
		$this->db->where('review_status','1');
		$this->db->where('active','Y');
		//return $this->db->get()->row();
		$query = $this->db->get();
		return $query->num_rows();	
	}
	
	function paper_reviewed_count($paper_id)
	{
		$this->db->select('*');
		$this->db->from('review');
		$this->db->join('paper', 'paper.paper_id = review.paper_id');
		$this->db->where('review.paper_id',$paper_id);
		//$this->db->where('review_status','0');
		//return $this->db->get()->row();
		$query = $this->db->get();
		return $query->num_rows();			
	}
	
	function review_all_status_count($paper_id)
	{
		$this->db->select('*');
		$this->db->from('review');
		$this->db->join('paper', 'paper.paper_id = review.paper_id');
		$this->db->where('review.paper_id',$paper_id);
		$query = $this->db->get();
		return $query->num_rows();	
	}
	
	
	function journal_reviewer_count($journal_id)
	{
		$this->db->select('*');
		$this->db->from('user');
		$this->db->join('journal_member', 'journal_member.user_id = user.user_id');
		$this->db->where('journal_id',$journal_id);
		$this->db->where('user_type','D');
		//return $this->db->get()->row();
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	//cek jumlah dosen, apabila >=3, dan 2 buah review menerima, maka otomatis paper_status = 2/publish
	//apabila jumlah dosen dlm 1 jurnal < 3, maka 1 review status menerima cukup untuk merubah status paper menjadi
	
	//revision jika >=3, jika 2 buah review menolak, maka otomatis ditolak, dan harus revisi
	//jika dosen < 3, maka 1 review menolak cukup untuk status ditolk dan harus revisi (yang lebih dahulu)
	
	//komentar saja dihapus, 0 = rejected, 1 = accepted
	
	
	//review paper sekali
	function paper_status($paper_id, $data)//jika paper diterima jumlahnya 2-3, maka paper status 2/published
	{
		$this->db->where('paper_id', $paper_id);
		$this->db->update('paper', $data);
	}
	
	function review_paper_count($paper_id, $reviewer_id)
	{
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->join('review', 'review.paper_id = paper.paper_id');
		$this->db->where('paper.paper_id',$paper_id);
		$this->db->where('reviewer_id',$reviewer_id);
		$this->db->where('paper_status','0');
		$this->db->where('review.active','Y');
		//return $this->db->get()->row();
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	function max_comment_review($paper_id, $reviewer_id)
	{
		$this->db->select_max('review_date');
		$this->db->from('review');
		$this->db->where('paper_id',$paper_id);
		$this->db->where('reviewer_id',$reviewer_id);
		$this->db->where('review_status','0');
		return $this->db->get()->row();
		//SELECT MAX(review_date) AS tanggal_review, review_message FROM review WHERE paper_id = '349389' AND reviewer_id = '523001' AND review_status = '0'
		//ambil tanggal maksimal
	}
	
	function latest_request($paper_id)
	{
		$this->db->select_max('review_date');
		$this->db->from('review');
		$this->db->where('paper_id',$paper_id);
		$this->db->where('review_status','0');
		return $this->db->get()->row();
	}
	
	/**************Home Controller**************/	
	function subject_list()
	{
		$this->db->select('*');
		$this->db->from('subject');
		return $this->db->get()->result();
	}
	
	function subject_detail($subject_id)
	{
		$this->db->select('*');
		$this->db->from('subject');
		$this->db->where('subject_id',$subject_id);
		return $this->db->get()->row();
	}
	
	function journal_list($subject_id)
	{
		$this->db->select('*');
		$this->db->from('journal');
		$this->db->join('subject_journal', 'subject_journal.journal_id = journal.journal_id');
		$this->db->join('subject', 'subject.subject_id = subject_journal.subject_id');		
		$this->db->where('subject.subject_id',$subject_id);
		return $this->db->get()->result();
	}
	
	function journal_detail($path)
	{
		$this->db->select('*');
		$this->db->from('journal');
		$this->db->where('path',$path);
		return $this->db->get()->row();
	}
	
	function journal_paper_published($path, $limit, $start)
	{
		$this->db->limit($limit, $start);
		$this->db->join('journal', 'journal.journal_id = paper.journal_id');
		$this->db->where('journal.path',$path);
		$this->db->where('paper.paper_status', '2');
		$this->db->order_by('paper.date_published', 'desc');
		$query = $this->db->get('paper');
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
	}
	
	function paper_published_list()
	{
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->limit('15');
		$this->db->where('paper_status', '2');
		$this->db->order_by("date_published", "desc"); 
		return $this->db->get()->result();
	}
	
	function paper_published_detail($paper_id)
	{
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->join('user_paper', 'user_paper.paper_id = paper.paper_id');
		$this->db->join('user', 'user.user_id = user_paper.user_id');
		$this->db->where('paper.paper_status', '2');
		$this->db->where('paper.paper_id',$paper_id);
		return $this->db->get()->row();
	}
	
	function journal_paper($paper_id)
	{
		$this->db->select('*');
		$this->db->from('journal');
		$this->db->join('paper', 'paper.journal_id = journal.journal_id');
		$this->db->where('paper.paper_id', $paper_id);
		return $this->db->get()->row();
	}
	
	function paper_detail_author($paper_id)
	{
		$this->db->select('*');
		$this->db->from('user_paper');
		$this->db->join('user', 'user.user_id = user_paper.user_id');
		$this->db->where('paper_id',$paper_id);
		return $this->db->get()->result();
	}
	
	function discussion_list($paper_id)
	{
		$this->db->select('*');
		$this->db->from('discussion');
		$this->db->where('parent_id',0);
		$this->db->where('paper_id',$paper_id);
		$this->db->order_by('comment_date','asc');
		return $this->db->get()->result();
	}
	
	function site_info()
	{
		$this->db->select('*');
		$this->db->from('site_info');
		return $this->db->get()->row();
	}
	
	function search_from_all($keyword)
	{
		$query = $this->db->query("SELECT paper.title, paper.abstraction, paper.date_created, paper.date_published, user_paper.paper_id, max( user_paper.user_id ) as max_user_id FROM `user_paper` join paper on paper.paper_id = user_paper.paper_id and paper.paper_status = '2' join user on user.user_id = user_paper.user_id where paper.title LIKE '%".$keyword."%' or paper.abstraction LIKE '%".$keyword."%' or user.full_name LIKE '%".$keyword."%' or user.user_id LIKE '%".$keyword."%' GROUP BY paper.paper_id ORDER BY paper.date_created = 'desc'");
		return $query->result();
	}
	
	function search_from_paper_count($column, $keyword)
	{
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->like($column, $keyword);
		$this->db->where('paper_status', '2');
		$this->db->order_by('date_created', 'desc');
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	function search_from_paper($column, $keyword)
	{
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->like($column, $keyword);
		$this->db->where('paper_status', '2');
		$this->db->order_by('date_created', 'desc');
		return $this->db->get()->result();
	}

	function search_from_paper_paging($column, $keyword, $limit, $start)
	{
		$this->db->limit($limit, $start);
		$this->db->like($column, $keyword);
		$this->db->where('paper_status', '2');
		$this->db->order_by('date_created', 'desc');
		
		$query = $this->db->get('paper');
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
	}	
	
	function search_from_user_count($keyword)
	{
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->join('user_paper', 'user_paper.paper_id = paper.paper_id');
		$this->db->join('user', 'user.user_id = user_paper.user_id');
		$this->db->like('user.full_name', $keyword);
		$this->db->where('paper.paper_status', '2');
		$this->db->order_by('paper.date_created', 'desc');
		$query = $this->db->get();
		return $query->num_rows();
	}

	function search_from_user($keyword)
	{
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->join('user_paper', 'user_paper.paper_id = paper.paper_id');
		$this->db->join('user', 'user.user_id = user_paper.user_id');
		$this->db->like('user.full_name', $keyword);
		$this->db->where('paper.paper_status', '2');
		$this->db->order_by('paper.date_created', 'desc');
		return $this->db->get()->result();
	}

	function search_from_user_paging($keyword, $limit, $start)
	{
		$this->db->limit($limit, $start);
		$this->db->join('user_paper', 'user_paper.paper_id = paper.paper_id');
		//$this->db->join('free_user_paper', 'free_user_paper.paper_id = paper.paper_id');
		$this->db->join('user', 'user.user_id = user_paper.user_id');
		$this->db->like('user.full_name', $keyword);
		$this->db->where('paper.paper_status', '2');
		$this->db->order_by('paper.date_created', 'desc');
		
		$query = $this->db->get('paper');
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
	}
	
	function user_id_check($user_id)
	{	
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('user_id', $user_id);
		return $this->db->get()->num_rows();
	}
	
	function registration($data)
	{
		$this->db->insert('user',$data);
	}
		
	function login($user_id, $pass)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('password', $pass);
		return $this->db->get('user')->row();
	}
	/**************Home Controller**************/
	
	
	
	/**************Admin Controller**************/
	function register($data)
	{
		$this->db->insert('user',$data);
	}
	
	function subject_journal_check($subject_id, $journal_id)
	{
		$this->db->select('*');
		$this->db->from('subject_journal');
		$this->db->where('subject_id',$subject_id);
		$this->db->where('journal_id',$journal_id);	
		$query = $this->db->get();
		return $query->num_rows();	
	}
	
	function journal_detail_id($journal_id)
	{
		$this->db->select('*');
		$this->db->from('journal');
		$this->db->where('journal_id',$journal_id);
		return $this->db->get()->row();
	}
	
	function paper_detail($paper_id)
	{
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->where('paper_id',$paper_id);
		return $this->db->get()->row();
	}
	
	function user_detail($user_id)
	{
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('user_id',$user_id);
		return $this->db->get()->row();
	}
	
	function user_journal_member($user_id)
	{
		$this->db->select('*');
		$this->db->from('journal');
		$this->db->join('journal_member', 'journal_member.journal_id = journal.journal_id');
		$this->db->where('user_id',$user_id);
		return $this->db->get()->result();
	}
	
	function user_list($user_id)
	{
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('user_id !=',$user_id);
		$this->db->order_by('date_registered', 'desc');
		return $this->db->get()->result();
	}

	function user_list_json($keyword, $user_id)
	{
		$this->db->select('user_id AS id, full_name AS name');
		$this->db->from('user');
		$this->db->like('full_name',$keyword);
		$this->db->where('user_id !=',$user_id);
		$this->db->where('user_type !=','A');
		return $this->db->get()->result();
	}

	function user_list_admin_json($keyword, $user_id)
	{
		$this->db->select('user_id AS id, full_name AS name');
		$this->db->from('user');
		$this->db->like('full_name',$keyword);
		$this->db->where('user_id !=',$user_id);
		return $this->db->get()->result();
	}
	
	function user_inactive_list()
	{
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('user_status', '0');
		return $this->db->get()->result();
	}
	
	function user_type($type)
	{
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('user_type', $type);
		return $this->db->get()->result();
	}
	
	function user_edit($user_id, $data)
	{
		$this->db->where('user_id',$user_id);
		$this->db->update('user', $data);
	}
	
	function admin_review_delete($review_id)
	{
		$this->db->where('review_id', $review_id);
		$this->db->delete('review');
	}
	
	function message_recipient_delete($message_id)
	{
		$this->db->where('message_id', $message_id);
		$this->db->delete('message_recipient');
	}
	/**************Admin Controller**************/
		
	
	
	/**************Mahasiswa Controller**************/
	function paper_revision_list($user_id)
	{
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->join('user_paper', 'user_paper.paper_id = paper.paper_id');
		$this->db->where('paper_status', '1');
		$this->db->where('user_id', $user_id);
		$this->db->order_by("date_created", "desc"); 
		return $this->db->get()->result();
	}

	function revision_request_list($user_id)
	{
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->join('user_paper', 'user_paper.paper_id = paper.paper_id');
		$this->db->join('review', 'review.paper_id = paper.paper_id');
		$this->db->where('review_status', '0');
		$this->db->where('active', 'Y');
		$this->db->where('paper_status', '3');
		$this->db->where('user_id', $user_id);
		$this->db->order_by("date_created", "desc"); 
		return $this->db->get()->result();
	}
	
	function paper_journal_member($user_id)
	{
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->limit('15');
		$this->db->join('journal_member', 'journal_member.journal_id = paper.journal_id');
		$this->db->where('paper.paper_status', '2');
		$this->db->where('journal_member.user_id',$user_id);
		$this->db->order_by('paper.date_created', 'desc');
		return $this->db->get()->result();
	}
	
	function get_url($journal_id)
	{
		$this->db->select('*');
		$this->db->from('journal');
		$this->db->where('journal_id', $journal_id);
		return $this->db->get()->row();
	}
	
	function partner_paper($paper_id, $user_id)
	{
		$this->db->select('*');
		$this->db->from('user_paper');
		$this->db->join('user', 'user.user_id = user_paper.user_id');
		$this->db->where('user_paper.paper_id', $paper_id);
		$this->db->where('user_paper.user_id !=', $user_id);		
		return $this->db->get()->result();
	}

	function partner_paper_json($paper_id, $user_id)
	{
		$this->db->select('user.user_id AS id, full_name AS name, user.user_id AS token');
		$this->db->from('user_paper');
		$this->db->join('user', 'user.user_id = user_paper.user_id');
		$this->db->where('user_paper.paper_id', $paper_id);
		$this->db->where('user_paper.user_id !=', $user_id);		
		return $this->db->get()->result();
	}
	
	function paper_rejected($paper_id)
	{
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->where('paper_id', $paper_id);
		$this->db->where('paper_status', '1');
		return $this->db->get()->row();
	}
	
	function paper_requested($paper_id)
	{
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->where('paper_id', $paper_id);
		$this->db->where('paper_status', '3');
		return $this->db->get()->row();	
	}

	function paper_revision($data, $paper_id)
	{
		$query = $this->db->query("UPDATE paper SET title = '".$data['title']."', abstraction = '".$data['abstraction']."', paper_status = '".$data['paper_status']."', revision_count = revision_count + 1, latest_revision = '".$data['latest_revision']."' WHERE paper_id = ".$paper_id."");
		return $query;
	}

	function paper_revision_file($data, $paper_id)
	{
		$query = $this->db->query("UPDATE paper SET title = '".$data['title']."', abstraction = '".$data['abstraction']."', paper_status = '".$data['paper_status']."', revision_count = revision_count + 1, latest_revision = '".$data['latest_revision']."', file_name = '".$data['file_name']."' WHERE paper_id = ".$paper_id."");
		return $query;
	}

	function review_revision_update($paper_id, $data)
	{
		$this->db->where('paper_id',$paper_id);
		$this->db->update('review', $data);
	}

	function review_revision_request_update($paper_id, $data)
	{
		$this->db->where('paper_id',$paper_id);
		$this->db->where('review_status','0');
		$this->db->update('review', $data);
	}
	
	function review_update($paper_id, $reviewer_id, $data)
	{
		$this->db->where('paper_id',$paper_id);
		$this->db->where('reviewer_id',$reviewer_id);
		$this->db->where('review_status','3');
		$this->db->update('review', $data);
	}
	/**************Mahasiswa Controller**************/
		
	
		
	/**************Dosen Controller**************/	
	function review_list($user_id)
	{
		$this->db->select('*');
		$this->db->from('review');
		$this->db->where('reviewer_id', $user_id);
		$this->db->order_by('review_date', 'desc');
		return $this->db->get()->result();
	}
	
	function paper_detail_review_list($paper_id)
	{
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->where('paper_id', $paper_id);
		return $this->db->get()->row();
	
	}
	
	function review_add($data)
	{
		$this->db->insert('review',$data);
	}
	
	function review_delete($review_id, $reviewer_id)
	{
		$this->db->where('review_id', $review_id);
		$this->db->where('reviewer_id', $reviewer_id);
		$this->db->delete('review');
	}
	/**************Dosen Controller**************/
	

	
	/**************SITE INFO**************/
	function edit_site_info($data)
	{
		$this->db->update('site_info',$data);
	}


	
	/**************SUBJECT**************/
	function subject_journal($journal_id)
	{
		$this->db->select('*');
		$this->db->from('subject');
		$this->db->join('journal', 'journal.subject_id = subject.subject_id');
		$this->db->where('journal.journal_id',$journal_id);
		return $this->db->get()->row();
	}
		
	function subject_add($data)
	{
		$this->db->insert('subject',$data);
	}
	
	function subject_edit($subject_id, $data)
	{
		$this->db->where('subject_id',$subject_id);
		$this->db->update('subject',$data);
	}
	
	function subject_delete($subject_id)
	{
		$this->db->where('subject_id', $subject_id);
		$this->db->delete('subject');
	}
	
	function subject_journal_delete($column, $id)
	{
		$this->db->where($column, $id);
		$this->db->delete('subject_journal');	
	}
	
	
	/**************JOURNAL**************/	
	function journal_list_all()
	{
		$this->db->select('*');
		$this->db->from('journal');
		return $this->db->get()->result();
	}
	
	function journal_list_active($user_id, $journal_id)
	{
		$this->db->select('*');
		$this->db->from('journal');
		$this->db->join('journal_member', 'journal_member.journal_id = journal.journal_id');
		$this->db->where('journal_member.user_id', $user_id);
		$this->db->where('journal_member.journal_id', $journal_id);
		return $this->db->get()->row();
	}
	
	function journal_count($subject_id)
	{
		$this->db->select('*');
		$this->db->from('journal');
		$this->db->join('subject_journal', 'subject_journal.journal_id = journal.journal_id');
		$this->db->join('subject', 'subject.subject_id = subject_journal.subject_id');
		$this->db->where('subject_journal.subject_id',$subject_id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	function journal_check($path)
	{
		$this->db->select('*');
		$this->db->from('journal');
		$this->db->where('path',$path);
		return $this->db->get()->num_rows();
	}
	
	function journal_add($data)
	{
		$this->db->insert('journal',$data);
	}
	
	function subject_journal_add($data)
	{
		$this->db->insert('subject_journal',$data);
	}
	
	function journal_edit($path, $data)
	{
		$this->db->where('path',$path);
		$this->db->update('journal',$data);
	}
		
	function journal_delete($journal_id)
	{
		$this->db->where('journal_id', $journal_id);
		$this->db->delete('journal');
	}
	
	function member_journal($path)
	{
		$this->db->select('*');
		$this->db->from('journal_member');
		$this->db->join('user', 'user.user_id = journal_member.user_id');
		$this->db->join('journal', 'journal.journal_id = journal_member.journal_id');
		$this->db->where('journal.path', $path);
		return $this->db->get()->result();	
	}
	
	function journal_member($user_id)
	{
		$this->db->select('*');
		$this->db->from('journal');
		$this->db->join('journal_member', 'journal.journal_id = journal_member.journal_id');
		$this->db->where('journal_member.user_id', $user_id);
		return $this->db->get()->result();
	}
	
	function journal_member_count($journal_id)
	{
		$this->db->select('*');
		$this->db->from('journal_member');
		$this->db->where('journal_id', $journal_id);
		$query = $this->db->get();
		return $query->num_rows();	
	}

	function journal_member_list($journal_id, $user_id)
	{
		$this->db->select('*');
		$this->db->from('journal');
		$this->db->join('journal_member', 'journal.journal_id = journal_member.journal_id');
		$this->db->join('user', 'user.user_id = journal_member.user_id');
		$this->db->where('journal.journal_id', $journal_id);
		$this->db->where('journal_member.user_id !=', $user_id);
		$this->db->where('user.user_type !=', 'D');
		return $this->db->get()->result();
	}
		
	function journal_join($data)
	{
		$this->db->insert('journal_member',$data);
	}
	
	function journal_leave($journal_id, $user_id)
	{
		$this->db->where('journal_id', $journal_id);
		$this->db->where('user_id', $user_id);
		$this->db->delete('journal_member');
	}


	
	/**************PAPER**************/
	function paper_list()
	{
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->order_by('date_created', 'desc'); 
		return $this->db->get()->result();
	}
	
	function paper_count($journal_id)
	{
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->join('journal', 'journal.journal_id = paper.journal_id');
		$this->db->where('paper.journal_id', $journal_id);
		$query = $this->db->get();
		return $query->num_rows();		
	}

	function paper_published_count($journal_id)
	{
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->join('journal', 'journal.journal_id = paper.journal_id');
		$this->db->where('paper.journal_id', $journal_id);
		$this->db->where('paper.paper_status', '2');
		$query = $this->db->get();
		return $query->num_rows();		
	}
	
	function paper_published_author($paper_id)
	{
		$this->db->select('*');
		$this->db->from('user_paper');
		$this->db->join('user', 'user.user_id = user_paper.user_id');
		$this->db->where('user_paper.paper_id',$paper_id);
		return $this->db->get()->result();
	}

	function paper_detail_edit($paper_id)
	{
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->join('user_paper', 'user_paper.paper_id = paper.paper_id');
		$this->db->join('user', 'user.user_id = user_paper.user_id');
		$this->db->where('paper.paper_status !=', '2');
		$this->db->where('paper.paper_id',$paper_id);
		return $this->db->get()->row();
	}

	function paper_comment_form($journal_id, $user_id)
	{
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->join('journal_member', 'journal_member.journal_id = paper.journal_id');
		$this->db->where('paper.journal_id', $journal_id);
		$this->db->where('journal_member.user_id', $user_id);
		return $this->db->get()->row();
	}
	
	function paper_detail_review($paper_id, $user_id)
	{
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->join('user_paper', 'user_paper.paper_id = paper.paper_id');
		$this->db->join('user', 'user.user_id = user_paper.user_id');
		$this->db->where('paper.paper_id',$paper_id);
		$this->db->where('user_paper.user_id',$user_id);
		return $this->db->get()->row();
	}

	function paper_detail_review_dosen($paper_id)
	{
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->join('user_paper', 'user_paper.paper_id = paper.paper_id');
		$this->db->join('user', 'user.user_id = user_paper.user_id');
		$this->db->where('paper.paper_id',$paper_id);
		return $this->db->get()->row();
	}

	function paper_detail_review_dosen_revision($paper_id)
	{
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->join('user_paper', 'user_paper.paper_id = paper.paper_id');
		$this->db->join('user', 'user.user_id = user_paper.user_id');
		$this->db->where('paper.paper_id',$paper_id);
		$this->db->where('paper.paper_status','3');
		return $this->db->get()->row();
	}
	
	function dosen_review($paper_id, $user_id)
	{
		$this->db->select('*');
		$this->db->from('review');
		$this->db->where('paper_id', $paper_id);
		$this->db->where('reviewer_id', $user_id);
		$this->db->where('review_status', '3');
		$this->db->where('active', 'Y');
		$query = $this->db->get();
		return $query->num_rows();			
	}
	
	function paper_review($paper_id)
	{
		$this->db->select('*');
		$this->db->from('review');
		$this->db->join('paper', 'paper.paper_id = review.paper_id');
		$this->db->join('user', 'user.user_id = review.reviewer_id');
		$this->db->where('review.paper_id',$paper_id);
		$this->db->order_by('review.review_date', 'asc'); 
		return $this->db->get()->result();
	}
	
	function paper_user($user_id)
	{
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->join('user_paper', 'user_paper.paper_id = paper.paper_id');
		$this->db->where('user_paper.user_id',$user_id);
		$this->db->order_by("paper.date_created", "desc"); 
		return $this->db->get()->result();
	}
	
	function paper_published_user($user_id)
	{
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->join('user_paper', 'user_paper.paper_id = paper.paper_id');
		$this->db->where('user_paper.user_id',$user_id);
		$this->db->where('paper.paper_status','2');
		$this->db->order_by('paper.date_created', 'asc'); 
		return $this->db->get()->result();
	}
	
	function paper_add($data)
	{
		$this->db->insert('paper',$data);
	}
	
	function paper_edit($paper_id, $data)
	{
		$this->db->where('paper_id', $paper_id);
		$this->db->update('paper',$data);
	}
	
	function paper_edit_check($paper_id)
	{
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->join('review', 'review.paper_id = paper.paper_id');
		$this->db->where('revision_count', '0');
		$this->db->where('paper.paper_id', $paper_id);
		$query = $this->db->get();
		return $query->num_rows();		
	}
	
	function paper_delete($paper_id)
	{
		$this->db->where('paper_id', $paper_id);
		$this->db->delete('paper');
	}
	
	function paper_delete_user($paper_id)
	{
		$this->db->where('paper_id', $paper_id);
		$this->db->delete('user_paper');
	}
	
	function paper_delete_free_user($paper_id)
	{	
		$this->db->where('paper_id', $paper_id);
		$this->db->delete('free_user_paper');
	}
	
	function paper_delete_discussion($paper_id)
	{
		$this->db->where('paper_id', $paper_id);
		$this->db->delete('discussion');
	}
	
	function paper_to_review($user_id)
	{
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->join('journal_member', 'journal_member.journal_id = paper.journal_id');	
		$this->db->where('paper.paper_status','0');
		$this->db->where('journal_member.user_id',$user_id);
		$this->db->order_by('paper.date_created', 'desc'); 
		return $this->db->get()->result();
	}
	
	function paper_publish($paper_id, $data)
	{
		$this->db->where('paper_id',$paper_id);
		$this->db->update('paper',$data);
	}
	
	function paper_publish_check($paper_id)
	{	
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->join('review', 'review.paper_id = paper.paper_id');
		$this->db->where('paper.paper_id',$paper_id);
		$this->db->where('review.review_status','2');
		//$this->db->where('journal_member.user_id',$user_id);
		//$this->db->order_by('paper.date_created', 'desc'); 
		//return $this->db->get()->result();		
		$query = $this->db->get();
		return $query->num_rows();
		//max ganjil 3, if 2 maka publish. or jumlah dosen < dari 3 maka 1 diterima = publish
	}
	
	function paper_reject($paper_id, $data)
	{
		$this->db->where('paper_id',$paper_id);
		$this->db->update('paper',$data);
	}
	
	function paper_review_add($data)
	{
		$this->db->insert('review',$data);
	}


	
	/**************USER PAPER**************/
	function user_paper_count($user_id)
	{
		$this->db->select('*');
		$this->db->from('user_paper');
		$this->db->where('user_paper.user_id', $user_id);
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	function user_paper_add_clean($user_id, $paper_id)
	{
		$this->db->where('user_id !=', $user_id);
		$this->db->where('paper_id', $paper_id);
		$this->db->delete('user_paper');
	}

	function user_paper_add($data)
	{
		$this->db->insert('user_paper',$data);
	}	
	
	function user_paper_delete($user_id, $paper_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('paper_id', $paper_id);
		$this->db->delete('user_paper');
	}
	
	function user_paper_delete_user($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->delete('user_paper');
	}

	function discussion_list_child($parent_id)
	{
		$this->db->select('*');
		$this->db->from('discussion');
		$this->db->where('parent_id',$parent_id);
		$this->db->order_by('comment_date','asc');
		return $this->db->get()->result();
	}
	

	
	/**************MESSAGE**************/
	function message_recipient($message_id)
	{
		$this->db->select('*');
		$this->db->from('message_recipient');
		$this->db->join('user', 'user.user_id = message_recipient.recipient_id');
		$this->db->where('message_recipient.message_id', $message_id);
		$this->db->order_by('user.full_name','asc');
		return $this->db->get()->result();
	}
	
	function message_list()
	{
		$this->db->select('*');
		$this->db->from('message');
		$this->db->join('user', 'user.user_id = message.sender_id');
		$this->db->order_by('message.message_date','desc');
		return $this->db->get()->result();
	}
	
	function message_detail($message_id)
	{
		$this->db->select('*');
		$this->db->from('message');
		$this->db->join('user', 'user.user_id = message.sender_id');
		$this->db->where('message.message_id',$message_id);
		return $this->db->get()->row();
	}
	
	function message_send($data)
	{
		$this->db->insert('message',$data);
	}
	
	function recipient_send($data)
	{
		$this->db->insert('message_recipient',$data);
	}
	
	function inbox($recipient_id)
	{
		$this->db->select('*');
		$this->db->from('message');
		$this->db->join('message_recipient', 'message_recipient.message_id = message.message_id');
		$this->db->join('user', 'user.user_id = message.sender_id');
		$this->db->where('message_recipient.recipient_id',$recipient_id);
		$this->db->order_by('message.message_date','desc');
		return $this->db->get()->result();
	}
	
	function inbox_unread($recipient_id)
	{
		$this->db->select('*');
		$this->db->from('message');
		$this->db->join('message_recipient', 'message_recipient.message_id = message.message_id');
		$this->db->join('user', 'user.user_id = message.sender_id');
		$this->db->where('message_recipient.message_status','0');
		$this->db->where('message_recipient.recipient_id',$recipient_id);
		$this->db->order_by('message.message_date','desc');
		return $this->db->get()->result();
	}
	
	function outbox($sender_id)
	{
		$this->db->select('*');
		$this->db->from('message');
		$this->db->where('sender_id', $sender_id);
		$this->db->order_by('message_date','desc');
		return $this->db->get()->result();
	}
	
	function message_delete($message_id)
	{
		$this->db->where('message_id', $message_id);
		$this->db->delete('message');
	}
	
	function message_inbox_delete($message_id, $recipient_id)
	{
		$this->db->where('message_id', $message_id);
		$this->db->where('recipient_id', $recipient_id);
		$this->db->delete('message_recipient');		
	}


	
	/**************USER**************/
	function user_journal($journal_id, $user_id, $user_type)
	{
		$this->db->select('*');
		$this->db->from('user');
		$this->db->join('journal_member', 'journal_member.user_id = user.user_id');
		$this->db->where('journal_member.journal_id',$journal_id);
		$this->db->where('user.user_id !=',$user_id);
		$this->db->where('user.user_type',$user_type);
		return $this->db->get()->result();
	}
	
	function user_published_count($user_id)
	{
		$this->db->select('*');
		$this->db->from('user_paper');
		$this->db->join('paper', 'paper.paper_id = user_paper.paper_id');
		$this->db->where('paper.paper_status', '2');
		$this->db->where('user_paper.user_id', $user_id);
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	function user_list_dosen($user_id)
	{
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('user_type','D');
		$this->db->where('user_id !=',$user_id);
		return $this->db->get()->result();
	}

	function user_list_mahasiswa($user_id)
	{
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('user_type','M');
		$this->db->where('user_id !=',$user_id);
		return $this->db->get()->result();
	}

	function user_list_mahasiswa_json($keyword, $user_id)
	{
		$this->db->select('user_id AS id, full_name AS name, user_id token');
		$this->db->from('user');		
		$this->db->like('full_name', $keyword);
		$this->db->where('user_type','M');
		$this->db->where('user_id !=',$user_id);
		return $this->db->get()->result();
	}
	
	function free_user_paper_add($data)
	{
		$this->db->insert('free_user_paper', $data);
	}
	
	function free_user_paper_delete($paper_id)
	{
		$this->db->where('paper_id', $paper_id);
		$this->db->delete('free_user_paper');
	}
	
	function free_user_paper_list($paper_id)
	{
		$this->db->select('*');
		$this->db->from('free_user_paper');		
		$this->db->like('paper_id', $paper_id);
		return $this->db->get()->result();		
	}

	function free_user_paper_list_json($paper_id)
	{
		$this->db->select('full_name AS id, full_name AS name, user_id AS token');
		$this->db->from('free_user_paper');		
		$this->db->like('paper_id', $paper_id);
		return $this->db->get()->result();		
	}
	
	function user_activation($user_id, $data)
	{
		$this->db->where('user_id', $user_id);
		$this->db->update('user', $data);
	}

	function user_deactivation($user_id, $data)
	{
		$this->db->where('user_id', $user_id);
		$this->db->update('user', $data);
	}
		
	function user_update($user_id, $data)
	{
		$this->db->where('user_id', $user_id);
		$this->db->update('user', $data);
		return;
	}
	
	function user_delete($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->delete('user');
	}
	
	
	
	/**************PROFIL**************/
	function profile_detail($user_id)
	{
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('user_id',$user_id);
		return $this->db->get()->row();
	}
	
	
	
	/**************Statistik**************/
	function journal_stats()
	{
		$this->db->select('*');
		$this->db->from('journal');
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	function user_stats()
	{
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('user_type !=', 'A');
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	function paper_stats()
	{
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->where('paper_status', '2');
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	function review_stats()
	{
		$this->db->select('*');
		$this->db->from('review');
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	function journal_max_paper()
	{
		$query = $this->db->query("SELECT MAX( hitung_paper ) AS jumlah_publikasi, nama_jurnal, direktori
									FROM (
									SELECT journal_name AS nama_jurnal, path AS direktori, COUNT( paper.journal_id ) AS hitung_paper
									FROM journal
									JOIN paper ON paper.journal_id = journal.journal_id
									WHERE paper_status =  '2'
									GROUP BY paper.journal_id
									) AS journal_stats
									GROUP BY hitung_paper DESC");
		return $query->row();
	}
	
	function user_max_paper()
	{
		$query = $this->db->query("SELECT MAX( hitung_paper ) AS jumlah_paper, nama_lengkap, id_user
									FROM (
									SELECT full_name AS nama_lengkap, user.user_id AS id_user, COUNT( DISTINCT paper.paper_id ) AS hitung_paper
									FROM paper
									JOIN user_paper ON user_paper.paper_id = paper.paper_id
									JOIN user ON user.user_id = user_paper.user_id
									WHERE paper_status =  '2'
									GROUP BY full_name
									) AS user_stats
									GROUP BY hitung_paper DESC
									LIMIT 1");
		return $query->row();
	}
	/**************Statistik**************/
	
	
	/**************************************/
	function user_select($paper_id)
	{
		$this->db->select('user.user_id');
		$this->db->from('user');
		$this->db->join('user_paper', 'user_paper.user_id = user.user_id');
		$this->db->where('user_paper.paper_id',$paper_id);
		$this->db->where('user.user_type !=','D');
		return $this->db->get()->result();	
	}
	
	function not_in($journal_id, $user)
	{
		$query = $this->db->query("select * from user join journal_member on journal_member.user_id = user.user_id where journal_id = ".$journal_id." and user.user_type != 'D' and user.user_id not in (".$user.")");
		return $query->result();
	}
	
	function check_subject_delete($user_id, $paper_id)
	{
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->join('user_paper', 'user_paper.paper_id = paper.paper_id');
		$this->db->where('user_paper.user_id',$user_id);
		$this->db->where('user_paper.paper_id',$paper_id);
		return $this->db->get()->row();	
	}
	
	function check_paper_delete($user_id, $paper_id)
	{
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->join('user_paper', 'user_paper.paper_id = paper.paper_id');
		$this->db->where('user_paper.user_id',$user_id);
		$this->db->where('user_paper.paper_id',$paper_id);
		return $this->db->get()->row();	
	}
	
	function check_message($message_id, $sender_id)
	{
		$this->db->select('*');
		$this->db->from('message');
		$this->db->where('message_id',$message_id);
		$this->db->where('sender_id',$sender_id);
		return $this->db->get()->row();	
	}
	
	function message_read($message_id, $user_id, $data)
	{
		$this->db->where('message_id',$message_id);
		$this->db->where('recipient_id',$user_id);
		$this->db->update('message_recipient', $data);
		return;
	}
	
	function select_user($user_id)
	{
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('user_id',$user_id);
		return $this->db->get()->row();
	}
	
	
	
	/**************Notification**************/
	function inbox_count($recipient_id)
	{
		$this->db->select('*');
		$this->db->from('message_recipient');
		$this->db->where('recipient_id', $recipient_id);
		$this->db->where('message_status', '0');
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	function user_inactive_count()
	{
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('user_status','0');
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	function review_count($user_id)
	{
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->join('journal_member', 'journal_member.journal_id = paper.journal_id');
		$this->db->where('paper.paper_status','0');
		$this->db->where('journal_member.user_id',$user_id);
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	function review_revision_count($user_id)
	{
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->join('review', 'review.paper_id = paper.paper_id');
		$this->db->where('paper.paper_status','3');
		$this->db->where('paper.revision_count !=','0');
		//$this->db->where('paper.latest_revision <=','paper.');
		$this->db->where('review.reviewer_id',$user_id);
		$this->db->where('review.review_status','3');
		$this->db->where('review.active','Y');
		$query = $this->db->get();
		return $query->num_rows();	
	}
	
	function review_revision($user_id)
	{
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->join('review', 'review.paper_id = paper.paper_id');
		$this->db->where('paper.paper_status','3');
		$this->db->where('paper.revision_count !=','0');
		$this->db->where('review.reviewer_id',$user_id);
		$this->db->where('review.review_status','3');
		$this->db->where('review.active','Y');
		$this->db->order_by('date_created','desc');
		return $this->db->get()->result();
	}
	
	function revision_count($user_id)
	{
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->join('user_paper', 'user_paper.paper_id = paper.paper_id');
		$this->db->where('paper.paper_status','1');
		$this->db->where('user_paper.user_id',$user_id);
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	function revision_requested_count($user_id)
	{
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->join('user_paper', 'user_paper.paper_id = paper.paper_id');
		$this->db->join('review', 'review.paper_id = paper.paper_id');
		$this->db->where('review.review_status','0');
		$this->db->where('review.active','Y');
		$this->db->where('paper.paper_status','3');
		$this->db->where('user_paper.user_id',$user_id);
		$query = $this->db->get();
		return $query->num_rows();	
	}
	
	function publication_count()
	{
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->where('paper_status', '2');
		$query = $this->db->get();
		return $query->num_rows();	
	}	
	
	function journal_publication_count($path)
	{
		$this->db->select('*');
		$this->db->from('paper');
		$this->db->join('journal', 'journal.journal_id = paper.journal_id');
		$this->db->where('journal.path',$path);
		$this->db->where('paper.paper_status', '2');
		$query = $this->db->get();
		return $query->num_rows();	
	}
	/**************Notification**************/
	
	
	
	/**************Discussion**************/
	function discussion_add($data)
	{
		$this->db->insert('discussion',$data);
	}
	
	function discussion_delete($discussion_id, $user_id)
	{
		$this->db->where('discussion_id', $discussion_id);
		$this->db->where('user_id', $user_id);
		$this->db->delete('discussion');
	}	
	
	function admin_discussion_delete($discussion_id)
	{
		$this->db->where('discussion_id', $discussion_id);
		$this->db->delete('discussion');
	}

	function discussion_child_delete($discussion_id)
	{
		$this->db->where('parent_id', $discussion_id);
		$this->db->delete('discussion');
	}
	/**************Discussion**************/
	
	/**************File Revision*************/
	function file_revision($paper_id)
	{
		$this->db->select('*');
		$this->db->from('file_revision');
		$this->db->where('paper_id',$paper_id);
		return $this->db->get()->result();
	}
	
	function file_revision_read($file_id)
	{
		$this->db->select('*');
		$this->db->from('file_revision');
		$this->db->where('file_id',$file_id);
		return $this->db->get()->row();
	}
	
	function file_revision_add($data)
	{
		$this->db->insert('file_revision',$data);
	}
	
	function file_revision_delete($file_id)
	{
		$this->db->where('file_id', $file_id);
		$this->db->delete('file_revision');	
	}
	
}