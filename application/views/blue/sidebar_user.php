				<div class="box">
						<h2>
							<a href="#" id="toggle-list-items">Daftar Jurnal</a>
						</h2>
						<div class="block" id="list-items">
							<?php if($journal_member): ?>
							<p>Berikut daftar jurnal yang Anda ikuti.</p>
							<ul class="menu">
								<?php foreach($journal_member as $journal): ?>
									<li>
										<a href="<?php echo base_url().$this->uri->segment(1).'/journal_detail/'.$journal->path; ?>"><?php echo $journal->journal_name; ?></a>
									</li>
								<?php endforeach; ?>
							</ul>
							<p>Ingin mendaftar ke Jurnal yang lain? <a href="<?php echo base_url().$this->uri->segment(1).'/journal'; ?>">klik disini</a></p>
							<?php else: ?>
							<p>Belum ada jurnal yang Anda ikuti. Untuk mendaftar ke dalam Jurnal, <a href="<?php echo base_url().$this->uri->segment(1).'/journal'; ?>">klik disini</a></p>
							<?php endif; ?>
						</div>
				</div>				
				<?php $inbox_count = $this->Sipuma_model->inbox_count($this->session->userdata('user_id')); ?>
				<?php $review_count = $this->Sipuma_model->review_count($this->session->userdata('user_id')); ?>
				<?php $revision_count = $this->Sipuma_model->revision_count($this->session->userdata('user_id')); ?>
				<?php $revision_requested_count = $this->Sipuma_model->revision_requested_count($this->session->userdata('user_id')); ?>
				<?php $review_revision_count = $this->Sipuma_model->review_revision_count($this->session->userdata('user_id')); ?>
				<?php if($this->session->userdata('login_status') == "D"): ?>
					<?php if(($inbox_count != 0) || ($review_count != 0) || ($review_revision_count != 0)): ?>
					<div class="box">
						<h2>
							<a href="#" id="toggle-paragraphs">Notifikasi</a>
						</h2>
						<div class="block" id="paragraphs">
						<?php if($inbox_count != 0): ?>
							<p><img src="<?php echo base_url().'style/img/message.png'; ?>" /> Ada <a href="<?php echo base_url().'dosen/inbox_unread'; ?>"><?php echo $inbox_count; ?> pesan masuk</a> yang belum dibaca</p>
						<?php endif; ?>
						<?php if($review_count != 0): ?>
							<p><img src="<?php echo base_url().'style/img/paper.png'; ?>" /> Ada <a href="<?php echo base_url().'dosen/paper_list'; ?>"><?php echo $review_count; ?> karya ilmiah</a> yang perlu direview</p>
						<?php endif; ?>
						<?php if($review_revision_count != 0): ?>
							<p><img src="<?php echo base_url().'style/img/paper.png'; ?>" /> Ada <a href="<?php echo base_url().'dosen/paper_revision_list'; ?>"><?php echo $review_revision_count; ?> karya ilmiah</a> yang sudah direvisi</p>							
						<?php endif; ?>
						</div>
					</div>
					<?php endif; ?>
				<?php elseif($this->session->userdata('login_status') == "M"): ?>
					<?php if(($inbox_count != 0) || ($revision_count !=0) || ($revision_requested_count !=0)): ?>
					<div class="box">
						<h2>
							<a href="#" id="toggle-paragraphs">Notifikasi</a>
						</h2>
						<div class="block" id="paragraphs">
						<?php if($inbox_count != 0): ?>
							<p><img src="<?php echo base_url().'style/img/message.png'; ?>" /> Ada <a href="<?php echo base_url().'mahasiswa/inbox_unread'; ?>"><?php echo $inbox_count; ?> pesan masuk</a> yang belum dibaca</p>
						<?php endif; ?>
						<?php if($revision_count != 0): ?>
							<p><img src="<?php echo base_url().'style/img/paper.png'; ?>" /> Ada <a href="<?php echo base_url().'mahasiswa/revision_list'; ?>"><?php echo $revision_count; ?> karya ilmiah</a> yang perlu direvisi</p>
						<?php endif; ?>
						<?php if($revision_requested_count !=0): ?>
						<p><img src="<?php echo base_url().'style/img/paper.png'; ?>" /> Ada <a href="<?php echo base_url().'mahasiswa/revision_request_list'; ?>"><?php echo $revision_requested_count; ?> permintaan</a> revisi karya ilmiah</p>
						<?php endif; ?>
						</div>
					</div>
					<?php endif; ?>
				<?php endif; ?>