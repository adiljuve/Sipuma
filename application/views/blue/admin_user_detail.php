				<div class="block">
					<?php if($user_detail): ?>
					<h4><?php echo $user_detail->full_name;?></h4>
					<ul>
						<?php if($user_detail->user_status == '0'): ?>
						<li><b>Status:</b> Tidak Aktif</li>
						<?php elseif($user_detail->user_status == '1'): ?>
						<li><b>Status:</b> Aktif</li>
						<?php endif; ?>
						<?php if($user_detail->user_type == 'M'): ?>
						<li><b>Tipe User:</b> Mahasiswa</li>
						<?php elseif($user_detail->user_type == 'D'): ?>
						<li><b>Tipe User:</b> Dosen</li>
						<?php endif; ?>
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
						<li><b>No. Telepon:</b> <?php if($user_detail->phone_number != ''): ?><?php echo $user_detail->phone_number; ?><?php else: ?>-<?php endif; ?></li>
						<li><b>Email:</b> <?php if($user_detail->email != ''): ?><?php echo $user_detail->email; ?><?php else: ?>-<?php endif; ?></li>
						<li><b>Website:</b> <?php if($user_detail->website != ''): ?><?php echo $user_detail->website; ?><?php else: ?>-<?php endif; ?></li>
						<li><b>Tanggal Terdaftar:</b> <?php echo tgl_indo($user_detail->date_registered); ?></li>
					</ul>
					<?php echo $user_detail->info; ?>
					<?php $user_journal_member = $this->Sipuma_model->user_journal_member($user_detail->user_id); ?>
					<?php if($user_journal_member): ?>
					<h5>Jurnal</h5>					
					<ul>
						<?php foreach($user_journal_member as $journal_member): ?>
						<li><a href="<?php echo base_url().'admin/journal_detail/'.$journal_member->path; ?>"><?php echo $journal_member->journal_name; ?></a></li>
						<?php endforeach; ?>
					</ul>
					<?php endif; ?>
					<?php if($user_detail->user_type == 'M'): ?>
					<h5>Karya Ilmiah</h5>
					<div class="block">
					<?php if($paper_user): ?>
					<?php $no = 1; ?>
					<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
						<thead>
							<tr>
								<th>No.</th>
								<th>Judul</th>
								<th>Jurnal</th>
								<th>Tanggal Pengajuan</th>
								<th>Status</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($paper_user as $paper): ?>
						<?php $journal_detail = $this->Sipuma_model->journal_detail_id($paper->journal_id); ?>
							<tr>
								<td><?php echo $no++; ?></td>
								<td><?php if($paper->paper_status == '2'): ?><a href="<?php echo base_url().'admin/paper_detail/'.$paper->paper_id; ?>"><?php echo $paper->title; ?></a><?php else: ?><?php echo $paper->title; ?><?php endif; ?></a>	</td>
								<td><?php if($journal_detail): ?><a href="<?php echo base_url().'admin/journal_detail/'.$journal_detail->path; ?>"><?php echo $journal_detail->journal_name; ?></a><?php else: ?>-<?php endif; ?></td>
								<td><?php echo tgl_indo($paper->date_created); ?></td>
								<?php if($paper->paper_status == '0'): ?>
								<td><a href="<?php echo base_url().'admin/review_detail/'.$paper->paper_id; ?>">Review</a></td>
								<?php elseif($paper->paper_status =='1'): ?>
								<td><a href="<?php echo base_url().'admin/review_detail/'.$paper->paper_id; ?>">Ditolak</a></td>
								<?php elseif($paper->paper_status =='2'): ?>
								<td><a href="<?php echo base_url().'admin/review_detail/'.$paper->paper_id; ?>">Publikasi</a></td>
								<?php endif; ?>
								<td><a href="#" onClick="confirmation('<?php echo base_url().'admin/paper_delete/'.$paper->paper_id; ?>')">[Hapus]</a></td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
					<?php else: ?>
							<p>Tidak ada karya ilmiah</p>
					<?php endif; ?>
					</div>
					<?php elseif($user_detail->user_type == 'D'): ?>
					<h5>Sejarah Review</h5>
					<?php $review_list = $this->Sipuma_model->review_list($user_detail->user_id);?>
					<?php if($review_list): ?>
					<?php $no = 1; ?>
					<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
						<thead>
							<tr>
								<th>No.</th>
								<th>Judul</th>
								<th>Hasil Review</th>
								<th>Tanggal Review</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($review_list as $review): ?>
						<?php $paper_detail = $this->Sipuma_model->paper_detail($review->paper_id); ?>
						<tr>
							<td><?php echo $no++; ?></td>
							<td><?php if($paper_detail): ?><?php if($paper_detail->paper_status == '2'): ?><a href="<?php echo base_url().'admin/paper_detail/'.$paper_detail->paper_id; ?>"><?php echo $paper_detail->title; ?></a><?php else: ?><?php echo $paper_detail->title; ?><?php endif; ?><?php else: ?>-<?php endif; ?></td>
							<td>
							<?php if(($review->review_status == '0') || ($review->review_status == '3')): ?>
							Merevisi
							<?php elseif($review->review_status == '1'): ?>
							Menolak
							<?php elseif($review->review_status == '2'): ?>
							Menerima
							<?php endif; ?>
							</td>
							<td><?php echo tgl_indo($review->review_date); ?></td>
							<td><a href="<?php echo base_url().'admin/review_detail/'.$review->paper_id; ?>">[Detail]</a> |	<a href="#" onClick="confirmation('<?php echo base_url().'admin/review_delete/'.$review->review_id; ?>')">[Hapus]</a></td>
						</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
					<?php else: ?>
						<p>Tidak ada data review</p>
					<?php endif; ?>
					<?php endif; ?>
					<?php else: ?>
						<p>Data user tidak ditemukan</p>
					<?php endif; ?>
				</div>