				<div class="block">
					<?php if($user_other_detail): ?>
					<h4><?php echo $user_other_detail->full_name;?></h4>
					<ul>
						<?php if($user_other_detail->user_status == '0'): ?>
						<li><b>Status:</b> Tidak Aktif</li>
						<?php elseif($user_other_detail->user_status == '1'): ?>
						<li><b>Status:</b> Aktif</li>
						<?php endif; ?>
						<?php if($user_other_detail->user_type == 'M'): ?>
						<li><b>Tipe User:</b> Mahasiswa</li>
						<?php elseif($user_other_detail->user_type == 'D'): ?>
						<li><b>Tipe User:</b> Dosen</li>
						<?php endif; ?>
						<?php if($user_other_detail->user_type == 'M'): ?>
						<li><b>NIM:</b> <?php echo $user_other_detail->user_id; ?></li>
						<?php elseif($user_other_detail->user_type == 'D'): ?>
						<li><b>NIP:</b> <?php echo $user_other_detail->user_id; ?></li>
						<?php endif; ?>
						<?php if($user_other_detail->gender == 'L'): ?>
						<li><b>Jenis Kelamin:</b> Laki-laki</li>
						<?php elseif($user_other_detail->user_type == 'P'): ?>
						<li><b>Jenis Kelamin:</b> Perempuan</li>
						<?php endif; ?>
						<li><b>No. Telepon:</b> <?php if($user_other_detail->phone_number != ''): ?><?php echo $user_other_detail->phone_number; ?><?php else: ?>-<?php endif; ?></li>
						<li><b>Email:</b> <?php if($user_other_detail->email != ''): ?><?php echo $user_other_detail->email; ?><?php else: ?>-<?php endif; ?></li>
						<li><b>Website:</b> <?php if($user_other_detail->website != ''): ?><?php echo $user_other_detail->website; ?><?php else: ?>-<?php endif; ?></li>
						<li><b>Tanggal Terdaftar:</b> <?php echo tgl_indo($user_other_detail->date_registered); ?></li>
					</ul>
					<?php echo $user_other_detail->info; ?>

					<?php $user_journal_member = $this->Sipuma_model->user_journal_member($user_other_detail->user_id); ?>
					<?php if($user_journal_member): ?>
					<h5>Jurnal</h5>					
					<ul>
						<?php foreach($user_journal_member as $journal_member): ?>
						<li><a href="<?php echo base_url().'dosen/journal_detail/'.$journal_member->path; ?>"><?php echo $journal_member->journal_name; ?></a></li>
						<?php endforeach; ?>
					</ul>
					<?php endif; ?>
					<?php if($user_other_detail->user_type == 'M'): ?>
					<h5>Publikasi</h5>
					<div class="block">
					<?php if($paper_published_user): ?>
					<?php $no = 1; ?>
					<ol>
						<?php foreach($paper_published_user as $paper): ?>
							<li>
								<a href="<?php echo base_url().'dosen/paper/'.$paper->paper_id; ?>"><?php echo $paper->title; ?></a>
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
					<?php endif; ?>
				</div>