					<div class="block">
					<?php if($journal_detail): ?>
						<h5>Daftar Anggota Jurnal <?php echo $journal_detail->journal_name; ?></h5>
						<div class="block">
						<?php if($member_journal): ?>	
							<?php $no = 1; ?>
							<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
								<thead>
									<tr>
										<th>No.</th>
										<th>Nama</th>
										<th>Tipe Akun</th>
										<th>Jumlah Publikasi</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
							<?php foreach($member_journal as $member): ?>	
									<tr class="odd">
										<td><?php echo $no++; ?></td>
										<td><a href="<?php echo base_url().'admin/user_detail/'.$member->user_id; ?>"><?php echo $member->full_name; ?></a></td>
										<td>
										<?php if($member->user_type == 'M'): ?>
										Mahasiswa
										<?php elseif($member->user_type == 'D'): ?>
										Dosen
										<?php endif; ?>
										</td>
										<?php $user_published_count = $this->Sipuma_model->user_published_count($member->user_id); ?>
										<td><?php echo $user_published_count; ?></td>
										<td><a href="<?php echo base_url().'admin/user_edit/'.$member->user_id; ?>">Edit</a> | <a href="#" onClick="confirmation('<?php echo base_url().'admin/user_delete/'.$member->user_id; ?>')">Hapus</a></td>
									</tr>					
							<?php endforeach; ?>
								</tbody>
							</table>
						<?php else: ?>
							<p>Tidak ada data</p>
						<?php endif; ?>							
						</div>
						<p><a href="javascript:history.back(1);">[Kembali]</a></p>
					<?php else: ?>
						<?php redirect('admin/journal'); ?>
					<?php endif; ?>
					</div>
