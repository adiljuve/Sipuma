				<div class="block">
					<?php if($subject_detail): ?>
					<h4>Subjek <?php echo $subject_detail->subject_name;?></h4>
					<div class="block">
					<?php if($journal_list): ?>
						<h5>Daftar Jurnal</h5>
						<ol>					
						<?php foreach ($journal_list as $journal): ?>
							<li>
								<a href="<?php echo base_url(); ?>home/journal/<?php echo $journal->path; ?>"><?php echo $journal->journal_name;?></a>
								<?php $paper_published_count = $this->Sipuma_model->paper_published_count($journal->journal_id);?>
								(Jumlah Publikasi: <?php echo $paper_published_count; ?>)
							</li>
						<?php endforeach;?>
						</ol>
					<?php else: ?>							
						<p>Tidak Ada Jurnal</p>
					<?php endif; ?>	
					</div>
					<?php else: ?>
						<?php redirect('home'); ?>
					<?php endif;?>
				</div>