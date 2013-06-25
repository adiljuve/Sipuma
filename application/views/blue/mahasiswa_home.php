					<div class="block">
						<h4>Publikasi Terbaru</h4>
						<div class="block">
						<?php if($paper_journal_member): ?>	
							<ul class="paper">
							<?php foreach($paper_journal_member as $paper): ?>
							<?php $paper_published_author = $this->Sipuma_model->paper_published_author($paper->paper_id); ?>
								<li class="paper_list">
									<h5><a href="<?php echo base_url(); ?>mahasiswa/paper/<?php echo $paper->paper_id; ?>"><?php echo $paper->title; ?></a></h5>
									<?php if($paper_published_author): ?>
									<?php $category = "";
										  $comma = ", "; ?>
										<?php foreach ($paper_published_author as $author): ?>
											<?php 
											$category .= $author->full_name.' ('.$author->user_id.')';
											$category .= $comma;
											$list[] = $author->full_name; 
										?>
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
						<?php else: ?>
								<p>Tidak ada karya ilmiah yang dipublikasi. <a href="<?php echo base_url().'mahasiswa/journal'; ?>">Mendaftar ke Jurnal yang lain</a></p>
						<?php endif; ?>							
						</div>
					</div>