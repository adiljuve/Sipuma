				<div class="block">
				<?php if($paper_detail_review): ?>	
					<h4><?php echo $paper_detail_review->title; ?></h4>
					<div class="block">
						<ul>
							<li>
								<?php if($journal_paper): ?>
									<i><b>Jurnal:</b> <a href="<?php echo base_url().'admin/journal_detail/'.$journal_paper->path; ?>"><?php echo $journal_paper->journal_name; ?></a></i>
								<?php else: ?>
									<i><b>Jurnal</b>: -</i>
								<?php endif; ?>
							</li>
							<li>								 
								<?php if($paper_detail_author): ?>
									<?php foreach($paper_detail_author as $author): ?>
									<?php $list[] = '<a href="'.base_url().'admin/user_detail/'.$author->user_id.'">'.$author->full_name.' ('.$author->user_id.')</a>'; ?>
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
								<i><b>Tanggal Pengajuan:</b> <?php echo tgl_indo($paper_detail_review->date_created); ?></i>
							</li>
							<li>
								<i><b>Jumlah Revisi:</b> <?php echo $paper_detail_review->revision_count; ?></i>
							</li>
							<?php if($paper_detail_review->revision_count > 0): ?>
							<li>
								<i><b>Revisi Terakhir:</b> <?php echo tgl_indo($paper_detail_review->latest_revision); ?></i>
							</li>
							<?php endif; ?>
						</ul>
						<h5>Abstraki:</h5>
						<?php if($paper_detail_review->abstraction != ''): ?>
						<?php echo nl2br($paper_detail_review->abstraction); ?>
						<?php else: ?>
						-
						<?php endif; ?>	
						<h5>File Terkait:</h5>
						<ul class="file">
						<?php if($paper_detail_review->file_name != ''): ?>
							<li><a href="<?php echo base_url().'admin/file/'.$paper_detail_review->paper_id; ?>" onclick="$(this).modal({width:900, height:500}).open(); return false;"><?php echo $paper_detail_review->file_name; ?></a></li>
						<?php else: ?>
							<li>-</li>
						<?php endif; ?>
						</ul>	
						<h5>File Lama:</h5>
						<?php $file_revision = $this->Sipuma_model->file_revision($paper_detail_review->paper_id); ?>
						<ul class="file">
						<?php if($file_revision != ''): ?>
							<?php foreach($file_revision as $file): ?>
							<li><a href="<?php echo base_url().'file/revision/'.$file->file_id; ?>" onclick="$(this).modal({width:900, height:500}).open(); return false;"><?php echo $file->file_name; ?></a></li>
							<?php endforeach; ?>
						<?php else: ?>
							<li>-</li>
						<?php endif; ?>	
						</ul>						
					</div>
					<?php $paper_review = $this->Sipuma_model->paper_review($paper_detail_review->paper_id); ?>
					<?php if($paper_review): ?>					
					<h5>Review</h5>
					<div class="first article">
						<?php foreach($paper_review as $review): ?>							
							<p class="meta"><b><i><a href="<?php echo base_url().'admin/user_detail/'.$review->user_id; ?>"><?php echo $review->full_name; ?></a>, <?php echo tgl_indo($review->review_date); ?></i></b>  <a href="#" onClick="confirmation('<?php echo base_url().'dosen/review_delete/'.$review->review_id; ?>')">[Hapus]</a></p>
							<p><?php echo nl2br($review->review_message); ?></p>
							<?php if($review->review_status == '1'): ?>
							<p><b>Hasil Review: Ditolak</b></p>
							<?php elseif($review->review_status == '2'): ?>
							<p><b>Hasil Review: Diterima</b></p>
							<?php endif; ?>
							<hr />
						<?php endforeach; ?>
						<ul>
					</div>					
					<?php endif; ?>
					<p><a href="javascript:history.go(-1)">[Kembali]</a></p>
				<?php else: ?>
					<?php redirect(base_url().'admin/paper'); ?>
				<?php endif; ?>
				</div>