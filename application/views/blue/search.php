					<div class="block">
						<h4>Hasil Pencarian</h4>
						<div class="block" id="list-items">
							<h5>Menggunakan kata kunci '<?php echo $keyword; ?>':</h5>
							<ul class="paper">
					<?php if($result): ?>
						<?php foreach($result as $row): ?>
						<?php $paper_published_author = $this->Sipuma_model->paper_published_author($row->paper_id); ?>			
								<li class="paper_list">
								<?php if($this->uri->segment(1) == 'admin'): ?>
									<h5><a href="<?php echo base_url().$this->uri->segment(1); ?>/paper_detail/<?php echo $row->paper_id; ?>"><?php echo $row->title; ?></a></h5>
								<?php else: ?>
									<h5><a href="<?php echo base_url().$this->uri->segment(1); ?>/paper/<?php echo $row->paper_id; ?>"><?php echo $row->title; ?></a></h5>
								<?php endif; ?>
							<?php if($paper_published_author): ?>
									<?php $category = "";
										  $comma = ", "; ?>
										<?php foreach ($paper_published_author as $author): ?>
											<?php 
											$category .= $author->full_name.' ('.$author->user_id.')';
											$category .= $comma;
										?>
										<?php endforeach; ?>
										<?php $category = substr($category,0,-2); ?>
									<i><b>Penulis:</b> <?php echo $category; ?>
								<?php $free_user_paper = $this->Sipuma_model->free_user_paper_list($row->paper_id); ?>
								<?php if($free_user_paper): ?>
									<?php foreach($free_user_paper as $free_user): ?>
									<?php echo ', '.$free_user->full_name; ?>	
									<?php endforeach; ?>
								<?php endif; ?>									
									</i> | 
							<?php else: ?>
									<i>Penulis: -</i> | 
							<?php endif; ?>
									<i><b>Tanggal Publikasi:</b> <?php echo tgl_indo($row->date_published); ?></i>
								</li>
						<?php endforeach; ?>
							</ul>
							<?php echo $links; ?>
					<?php else: ?>
							<p><strong>Hasil pencarian tidak ditemukan.</strong></p>
					<?php endif; ?>
						</div>
					</div>