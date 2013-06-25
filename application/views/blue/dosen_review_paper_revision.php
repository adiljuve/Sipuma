				<div class="block">
				<?php if($paper_detail_review): ?>	
					<h4><?php echo $paper_detail_review->title; ?></h4>
					<div class="block">
						<ul>
							<li>
								<?php if($journal_paper): ?>
									<i><b>Jurnal:</b> <a href="<?php echo base_url().'dosen/journal_detail/'.$journal_paper->path; ?>"><?php echo $journal_paper->journal_name; ?></a></i>
									<?php $this->session->set_userdata('journal_id', $journal_paper->journal_id); ?>
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
						<h5>Abstraksi:</h5>
						<?php if($paper_detail_review->abstraction != ''): ?>
						<?php echo nl2br($paper_detail_review->abstraction); ?>
						<?php else: ?>
						-
						<?php endif; ?>
						<h5>File Terkait:</h5>
						<ul class="file">
						<?php if($paper_detail_review->file_name != ''): ?>
							<li><a href="<?php echo base_url().'dosen/file/'.$paper_detail_review->paper_id; ?>" onclick="$(this).modal({width:900, height:500}).open(); return false;"><?php echo $paper_detail_review->file_name; ?></a></li>
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
						<?php $dosen_review = $this->Sipuma_model->dosen_review($paper_detail_review->paper_id, $this->session->userdata('user_id'));?>
						<?php if($dosen_review > 0): ?>
						<p>Hasil Review: <a href="#" onClick="confirmation('<?php echo base_url().'dosen/paper_publish/'.$paper_detail_review->paper_id; ?>')">[Menerima]</a> | <a href="#dialog" name="modal">[Menolak]</a>
						| <a href="#revision" name="modal">[Merevisi Ulang]</a></p>
						<?php
						//jika paper status==3 maka berubah link/fungsi menerima, menolak, merevisi ulang.
						?>
						<?php endif; ?>
					</div>
					<div id="boxes">
						<div id="dialog" class="window">
							<form name="review_rejected" id="review_rejected" action="<?php echo base_url().'dosen/paper_reject'; ?>" method="post" onSubmit="return review_check(review_rejected)">
								<fieldset>
									<p>
										Tolak Hasil Karya Ilmiah
									</p>
									<p>
										<label>Pesan Review: (*)</label><br/>
										<input type="hidden" name="paper_id" value="<?php echo $paper_detail_review->paper_id; ?>" />
										<textarea name="review_message" id="review_message" cols="50" rows="10" maxlength="255" onBlur="white_space(review_message)"></textarea>
									</p>
									<input type="submit" value="Kirim" />
									<input type="reset" value="Batal" />
								</fieldset>
							</form>
						</div>
						<div id="mask"></div>

						<div id="revision" class="window">
							<form name="review_revision" id="review_revision" action="" method="post" onSubmit="return review_check(review_revision)">
								<fieldset>
									<p>
										Saran Revisi Karya Ilmiah
									</p>
									<p>
										<label>Pesan Revisi: (*)</label><br/>
										<input type="hidden" name="paper_id" value="<?php echo $paper_detail_review->paper_id; ?>" />
										<textarea name="review_message" id="review_message" cols="50" rows="10" maxlength="255" onBlur="white_space(review_message)"></textarea>
									</p>
									<input type="submit" value="Kirim" />
									<input type="reset" value="Batal" />
								</fieldset>
							</form>
						</div>
						<div id="mask"></div>
					</div>
					<!--<div id="boxes">
						
					</div>-->
					<?php $paper_review = $this->Sipuma_model->paper_review($paper_detail_review->paper_id); ?>
					<?php if($paper_review): ?>	
					<h5>Review</h5>
					<div class="first article">
						<?php foreach($paper_review as $review): ?>
							<p class="meta"><b><i><a href="<?php echo base_url().'dosen/user_detail/'.$review->user_id; ?>"><?php echo $review->full_name; ?></a>, <?php echo tgl_indo($review->review_date); ?></i></b></p>
							<p><?php echo nl2br($review->review_message); ?></p>
							<?php if($review->review_status == '0'): ?>
							<p><b>Hasil Review: Direvisi</b></p>
							<?php elseif($review->review_status == '1'): ?>
							<p><b>Hasil Review: Ditolak</b></p>
							<?php elseif($review->review_status == '2'): ?>
							<p><b>Hasil Review: Diterima</b></p>
							<?php endif; ?>
							<hr />
						<?php endforeach; ?>
					</div>
					<?php endif; ?>
				<?php else: ?>
					<?php redirect(base_url().'dosen/review'); ?>
				<?php endif; ?>
				</div>