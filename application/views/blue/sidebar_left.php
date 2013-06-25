				<div class="box">
					<h2>Subjek Jurnal</h2>
					<div class="block">
					<?php if($subject_list): ?>
						<ul class="menu">
						<?php foreach ($subject_list as $subject): ?>
							<li><a href="<?php echo base_url(); ?>home/subject/<?php echo $subject->subject_id; ?>"><?php echo $subject->subject_name;?></a></li>
						<?php endforeach;?>
						<li><a href="<?php echo base_url(); ?>home/subject/all">Daftar Jurnal</a></li>
						</ul>
					<?php else: ?>
						<p>Tidak ada subjek</p>
					<?php endif; ?>
					</div>
				</div>
			</div>