				<div class="block">
					<?php if($journal_detail): ?>
					<h4>Jurnal <?php echo $journal_detail->journal_name;?></h4>
					<p><?php echo nl2br($journal_detail->info);?></p>
						<h5>Daftar Publikasi</h5>
						<div class="block">
						<?php if($journal_paper_published): ?>
							<ul class="paper">	
							<?php foreach($journal_paper_published as $paper): ?>
							<?php $paper_published_author = $this->Sipuma_model->paper_published_author($paper->paper_id); ?>
								<li class="paper_list">
								<?php if($this->uri->segment(1) == 'admin'): ?>
									<h5><a href="<?php echo base_url().$this->uri->segment(1); ?>/paper_detail/<?php echo $paper->paper_id; ?>"><?php echo $paper->title; ?></a></h5>
								<?php else: ?>
									<h5><a href="<?php echo base_url().$this->uri->segment(1); ?>/paper/<?php echo $paper->paper_id; ?>"><?php echo $paper->title; ?></a></h5>
								<?php endif; ?>
								<?php if($paper_published_author): ?>
									<?php $category = ""; $comma = ", "; ?>
									<?php foreach ($paper_published_author as $author): ?>
										<?php $category .= $author->full_name.' ('.$author->user_id.')'; $category .= $comma; ?>
									<?php endforeach; ?>
									<?php $category = substr($category,0,-2); ?>
									<i><b>Penulis:</b> <?php echo $category; ?>
								<?php $free_user_paper = $this->Sipuma_model->free_user_paper_list($paper->paper_id); ?>
								<?php if($free_user_paper): ?>
									<?php foreach($free_user_paper as $free_user): ?>
									<?php echo ', '.$free_user->full_name; ?>	
									<?php endforeach; ?>
								<?php endif; ?>										
									</i> | 
								<?php else: ?>
									<i>Penulis: -</i> | 
								<?php endif; ?>
									<i><b>Tanggal Publikasi:</b> <?php echo tgl_indo($paper->date_published); ?></i>
								</li>
							<?php endforeach; ?>
							</ul>
							<?php echo $links; ?>
						<?php else: ?>
							<p>
								Tidak Ada Publikasi
							</p>
						<?php endif; ?>
						</div>
					<?php else:?>
						<?php redirect(base_url()); ?>
					<?php endif; ?>
				</div>