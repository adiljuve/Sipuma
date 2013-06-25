				<div class="block">
					<?php if($paper_detail): ?>	
					<h4><?php echo $paper_detail->title; ?></h4>
					<div class="block">
						<ul>
							<li>
								<?php if($journal_paper): ?>
									<i><b>Jurnal:</b> <a href="<?php echo base_url().'admin/journal_detail/'.$journal_paper->path; ?>"><?php echo $journal_paper->journal_name; ?></a></i>
								<?php else: ?>
									<i><b>Jurnal:</b> -</i>
								<?php endif; ?>
							</li>
							<li>
								<?php if($paper_detail_author): ?>
									<?php foreach($paper_detail_author as $author): ?>
									<?php $list[] = '<a href="'.base_url().'admin/user_detail/'.$author->user_id.'">'.$author->full_name.' ('.$author->user_id.')</a>'; ?>
									<?php endforeach; ?>	
								<?php endif; ?>								
								<i><b>Penulis: </b><?php echo implode(", ",$list); ?>
								<?php if($free_user_paper): ?>
									<?php foreach($free_user_paper as $free_user): ?>
									<?php echo ', '.$free_user->full_name; ?>	
									<?php endforeach; ?>
								<?php endif; ?>									
								</i>
							</li>
							<li>
								<i><b>Tanggal Publikasi: </b><?php echo tgl_indo($paper_detail->date_published); ?></i>
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
							<li><a href="<?php echo base_url().'admin/file/'.$paper_detail->paper_id; ?>" onclick="$(this).modal({width:900, height:500}).open(); return false;"><?php echo $paper_detail->file_name; ?></a></li>
						<?php else: ?>
							<li>-</li>
						<?php endif; ?>
						</ul>
					</div>
					<?php if($discussion_list): ?>
					<div class="block">
						<h5>Diskusi Publikasi</h5>
						<?php foreach($discussion_list as $discussion): ?>
							<?php $user_detail = $this->Sipuma_model->user_detail($discussion->user_id); ?>
							<hr />
							<p class="meta"><img src="<?php echo base_url().'style/img/comment.png'; ?>" /> <b><i><?php if($user_detail): ?><a href="<?php echo base_url().'admin/user_detail/'.$user_detail->user_id; ?>"><?php echo $user_detail->full_name; ?></a><?php endif; ?>, <?php echo tgl_indo($discussion->comment_date); ?></i></b></p>
							<p><?php echo nl2br($discussion->comment); ?></p>
							<a href="#" onClick="confirmation('<?php echo base_url().'admin/comment_delete/'.$discussion->discussion_id;?>')">[Hapus]</a>
							<div>
							</div>
							<?php $discussion_list_child = $this->Sipuma_model->discussion_list_child($discussion->discussion_id); ?>
							<?php if($discussion_list_child): ?>
							<div class="box">
							<?php foreach($discussion_list_child as $child): ?><?php $user_detail = $this->Sipuma_model->user_detail($child->user_id); ?>
								<p class="meta"><img src="<?php echo base_url().'style/img/comment.png'; ?>" /> <b><i><?php if($user_detail): ?><a href="<?php echo base_url().'admin/user_detail/'.$user_detail->user_id; ?>"><?php echo $user_detail->full_name; ?></a><?php endif; ?>, <?php echo tgl_indo($child->comment_date); ?></i></b></p>
								<p><?php echo nl2br($child->comment); ?></p>
								<a href="#" onClick="confirmation('<?php echo base_url().'admin/comment_delete/'.$child->discussion_id;?>')">[Hapus]</a>
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