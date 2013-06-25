				<div class="block">
					<?php if($user_detail): ?>
					<h4><?php echo $user_detail->full_name;?></h4>
					<ul>
						<?php if($user_detail->user_type == 'M'): ?>
						<li><b>NIM:</b> <?php echo $user_detail->user_id; ?></li>
						<?php elseif($user_detail->user_type == 'D'): ?>
						<li><b>NIP:</b> <?php echo $user_detail->user_id; ?></li>
						<?php endif; ?>
						<?php if($user_detail->gender == 'L'): ?>
						<li><b>Jenis Kelamin:</b> Laki-laki</li>
						<?php elseif($user_detail->user_type == 'P'): ?>
						<li><b>Jenis Kelamin:</b> Perempuan</li>
						<?php endif; ?>
						<li><b>Website:</b> <?php if($user_detail->website != ''): ?><?php echo $user_detail->website; ?><?php else: ?>-<?php endif; ?></li>
						<li><b>Tanggal Terdaftar:</b> <?php echo tgl_indo($user_detail->date_registered); ?></li>
					</ul>
					<?php echo $user_detail->info; ?>
					<?php else: ?>
						<p>Data user tidak ditemukan</p>
					<?php endif; ?>
					<?php $user_journal_member = $this->Sipuma_model->user_journal_member($user_detail->user_id); ?>
					<?php if($user_journal_member): ?>
					<h5>Jurnal</h5>					
					<ul>
						<?php foreach($user_journal_member as $journal_member): ?>
						<li><a href="<?php echo base_url().'home/journal/'.$journal_member->path; ?>"><?php echo $journal_member->journal_name; ?></a></li>
						<?php endforeach; ?>
					</ul>
					<?php endif; ?>
					<?php if($user_detail->user_type == 'M'): ?>
					<h5>Publikasi</h5>
					<div class="block">
					<?php if($paper_published_user): ?>
					<?php $no = 1; ?>
					<ol>
						<?php foreach($paper_published_user as $paper): ?>
							<li>
								<a href="<?php echo base_url().'home/paper/'.$paper->paper_id; ?>"><?php echo $paper->title; ?></a>
								(<b>Publikasi:</b> <?php echo tgl_indo($paper->date_published); ?>)
							</li>
						<?php endforeach; ?>
					</ul>
					<?php else: ?>
							<p>Tidak ada publikasi</p>
					<?php endif; ?>
					</div>
					<?php else: ?>
						<?php redirect(base_url()); ?>
					<?php endif; ?>
				</div>