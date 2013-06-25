					<div class="block">
						<h5>Daftar Jurnal</h5>
						<div class="block">
						<?php if($journal_list_all): ?>		
							<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
								<thead>
									<tr>
										<th>No.</th>
										<th>Jurnal</th>
										<th>Subjek</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
							<?php $no = 1; ?>
							<?php foreach($journal_list_all as $journal): ?>
							<?php $journal_list_active = $this->Sipuma_model->journal_list_active($this->session->userdata('user_id'), $journal->journal_id); ?>
									<tr class="odd">
										<td>
											<?php echo $no++; ?>
										</td>
										<td>
											<a href="<?php echo base_url().'mahasiswa/journal_detail/'.$journal->path; ?>"><?php echo $journal->journal_name; ?></a>
										</td>
										<td>
										<?php if($journal_list_active): ?>
											Terdaftar
										<?php else: ?>
											Tidak Terdaftar
										<?php endif; ?>
										</td>
										<td>
										<?php if($journal_list_active): ?>
											<a href="#" onClick="confirmation('<?php echo base_url().'mahasiswa/journal_leave/'.$journal->journal_id;?>')">[Keluar]</a>
										<?php else: ?>
											<a href="#" onClick="confirmation('<?php echo base_url().'mahasiswa/journal_join/'.$journal->journal_id;?>')">[Bergabung]</a>
										<?php endif; ?>
										</td>
									</tr>
							<?php endforeach; ?>
								</tbody>
							</table>
						<?php else: ?>
								<p>
									Tidak ada karya ilmiah yang dipublikasi
								</p>
						<?php endif; ?>							
						</div>
					</div>