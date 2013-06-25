					<div class="block">
						<h5>Daftar User Tidak Aktif</h5>
						<div class="block">
						<?php if($user_list): ?>	
							<?php $no = 1; ?>
							<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
								<thead>
									<tr>
										<th>No.</th>
										<th>Nama Lengkap</th>
										<th>Tipe User</th>
										<th>ID</th>
										<th>Status User</th>
										<th>Jumlah Karya Ilmiah</th>
										<th>Aksi</th>
										<th>Aktivasi</th>
									</tr>
								</thead>
								<tbody>
							<?php foreach($user_list as $user): ?>	
									<tr class="odd">
										<td><?php echo $no++; ?></td>
										<td><a href="<?php echo base_url().'admin/user_detail/'.$user->user_id; ?>"><?php echo $user->full_name; ?></a></td>
										<td><a href="<?php echo base_url().'admin/user_type/'.$user->user_type; ?>"><?php echo ucfirst($user->user_type); ?></a></td>
										<td><?php echo $user->user_id; ?></td>
										<td>
										<?php if($user->user_status == '1'): ?>
										Aktif
										<?php elseif($user->user_status == '0'): ?>
										Tidak Aktif
										<?php endif; ?>
										</td>
										<?php $user_paper_count = $this->Sipuma_model->user_paper_count($user->user_id); ?>
										<td>
										<?php echo $user_paper_count; ?>
										</td>
										<td>
										<a href="<?php echo base_url().'admin/user_edit/'.$user->user_id; ?>">[Edit]</a> | <a href="#" onClick="confirmation('<?php echo base_url().'admin/user_delete/'.$user->user_id; ?>')">[Hapus]</a>
										</td>
										<td>
										<?php if($user->user_status == '1'): ?>
										<a href="#" onClick="confirmation('<?php echo base_url().'admin/deactivate/'.$user->user_id; ?>')">[Nonaktifkan]</a>
										<?php elseif($user->user_status == '0'): ?>
										<a href="#" onClick="confirmation('<?php echo base_url().'admin/activate/'.$user->user_id; ?>')">[Aktifkan]</a>
										<?php endif; ?>
										</td>
									</tr>					
							<?php endforeach; ?>
								</tbody>
							</table>
						<?php else: ?>
							<p>Tidak ada user</p>
						<?php endif; ?>							
						</div>
					</div>
