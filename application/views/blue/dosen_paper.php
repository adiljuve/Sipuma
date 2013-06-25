				<div class="block">
					<?php if($paper_detail): ?>	
					<h4><?php echo $paper_detail->title; ?></h4>
					<div class="block">
						<ul>
							<li>
								<?php if($journal_paper): ?>
									<i><b>Jurnal:</b> <a href="<?php echo base_url().'dosen/journal_detail/'.$journal_paper->path; ?>"><?php echo $journal_paper->journal_name; ?></a></i>
								<?php else: ?>
									<i><b>Jurnal:</b> -</i>
								<?php endif; ?>
							</li>
							<li>								 
								<?php if($paper_detail_author): ?>
									<?php foreach($paper_detail_author as $author): ?>
									<?php $list[] = '<a href="'.base_url().'dosen/user_detail/'.$author->user_id.'">'.$author->full_name.' ('.$author->user_id.')</a>'; ?>
									<?php endforeach; ?>	
								<?php endif; ?>								
								<i><b>Penulis:</b> <?php echo implode(", ",$list); ?>
								<?php if($free_user_paper): ?>
									<?php foreach($free_user_paper as $free_user): ?>
									<?php echo ', '.$free_user->full_name; ?>	
									<?php endforeach; ?>
								<?php endif; ?>									
								</i>
							</li>
							<li>
								<i><b>Tanggal Publikasi:</b> <?php echo tgl_indo($paper_detail->date_published); ?></i>
							</li>
						</ul>
						<h5>Abstraksi:</h5>
						<?php if($paper_detail->abstraction != ''): ?>
						<?php echo nl2br($paper_detail->abstraction); ?>
						<?php else: ?>
						-
						<?php endif; ?>	
						<h5>File Terkait:</h5>
						<ul class="file">
						<?php if($paper_detail->file_name != ''): ?>
							<li><a href="<?php echo base_url().'dosen/file/'.$paper_detail->paper_id; ?>" onclick="$(this).modal({width:900, height:500}).open(); return false;"><?php echo $paper_detail->file_name; ?></a></li>
						<?php else: ?>
							<li>-</li>
						<?php endif; ?>
						</ul>
					</div>
					<h5>Diskusi Publikasi</h5>
					<?php $paper_comment_form = $this->Sipuma_model->paper_comment_form($paper_detail->journal_id, $this->session->userdata('user_id')) ?>
							<?php if ($paper_comment_form): ?>
					<div id="boxes">
						<form name="discussion" id="discussion" action="" method="post">
							<fieldset>
								<p>
									<label>Komentar: (*)</label><br/>
									<?php echo form_error('comment','<label><font color="red"><b>','</b></font></label><br />'); ?>
									<input type="hidden" name="paper_id" id="paper_id" value="<?php echo $paper_detail->paper_id; ?>">
									<textarea cols="50" rows="10" name="comment" id="comment" maxlength="255" onBlur="white_space(comment)"></textarea>
								</p>
								<p>
									<label>Keterangan(*): Wajib diisi</label>
								</p>
								<input type="submit" value="Kirim Komentar" />
								<input type="reset" value="Batal" />
							</fieldset>
						</form>
					</div>
					<?php endif; ?>
					<?php if($discussion_list): ?>
					<div class="block">
						<?php foreach($discussion_list as $discussion): ?>
							<?php $user_detail = $this->Sipuma_model->user_detail($discussion->user_id); ?>
							<hr />
							<p class="meta"><img src="<?php echo base_url().'style/img/comment.png'; ?>" /> <b><i><?php if($user_detail): ?><?php echo $user_detail->full_name; ?><?php endif; ?>, <?php echo tgl_indo($discussion->comment_date); ?></i></b></p>
							<p><?php echo nl2br($discussion->comment); ?></p>
							<?php $paper_comment_form = $this->Sipuma_model->paper_comment_form($paper_detail->journal_id, $this->session->userdata('user_id')) ?>
							<?php if ($paper_comment_form): ?>
							<div>
							<?php if($this->session->userdata('user_id') == $discussion->user_id): ?><a href="#" onClick="confirmation('<?php echo base_url().'dosen/comment_delete/'.$discussion->discussion_id;?>')">[Hapus]</a> | <?php endif; ?><a href="#reply<?php echo $discussion->discussion_id; ?>" id="<?php echo $discussion->discussion_id; ?>" class="title" name="<?php echo $discussion->discussion_id; ?>">[Balas Komentar]</a>
							</div>
							<div name="reply<?php echo $discussion->discussion_id; ?>" id="reply<?php echo $discussion->discussion_id; ?>" class="reply" style="display:none">						
							<form name="discussion_<?php echo $discussion->discussion_id; ?>" id="discussion_<?php echo $discussion->discussion_id; ?>" action="<?php echo base_url().'dosen/comment_reply'; ?>" method="post" onSubmit="return discussion_reply_check(discussion_<?php echo $discussion->discussion_id; ?>)">
								<fieldset>
									<p>
										<label>Balas komentar dari <?php echo $user_detail->full_name; ?>: </label><br/>
										<input type="hidden" name="paper_id" id="paper_id" value="<?php echo $paper_detail->paper_id; ?>">
										<input type="hidden" name="parent_id" id="parent_id" value="<?php echo $discussion->discussion_id; ?>">
										<textarea cols="40" rows="10" name="comment" id="comment" maxlength="255" onBlur="white_space(comment)"></textarea>
									</p>
									<input type="submit" value="Balas Komentar" class="register-button" />
								</fieldset>
							</form>
							</div>
							<?php endif; ?>
							<?php $discussion_list_child = $this->Sipuma_model->discussion_list_child($discussion->discussion_id); ?>
							<?php if($discussion_list_child): ?>
							<div class="box">
							<?php foreach($discussion_list_child as $child): ?><?php $user_detail = $this->Sipuma_model->user_detail($child->user_id); ?>
								<p class="meta"><img src="<?php echo base_url().'style/img/comment.png'; ?>" /> <b><i><?php if($user_detail): ?><?php echo $user_detail->full_name; ?><?php endif; ?>, <?php echo tgl_indo($child->comment_date); ?></i></b></p>
								<p><?php echo nl2br($child->comment); ?></p>
								<?php if($this->session->userdata('user_id') == $child->user_id): ?><a href="#" onClick="confirmation('<?php echo base_url().'dosen/comment_delete/'.$child->discussion_id;?>')">[Hapus]</a><?php endif; ?>
								<hr />
							<?php endforeach; ?>
							</div>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
					<?php endif; ?>
				<?php else: ?>
					<?php redirect(base_url()); ?>
				<?php endif; ?>
			</div>