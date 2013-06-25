					<div class="block">
						<h5>Daftar Jurnal Berdasarkan Subjek</h5>
						<div class="block">
						<?php if($journal_list): ?>		
							<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
								<thead>
									<tr>
										<th>No.</th>
										<th>Jurnal</th>
										<th>Subjek</th>
										<th>Status</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
							<?php $no = 1; ?>
							<?php foreach($journal_list as $journal): ?>
							<?php $journal_list_active = $this->Sipuma_model->journal_list_active($this->session->userdata('user_id'), $journal->journal_id); ?>
							<?php $subject_detail = $this->Sipuma_model->subject_detail($journal->subject_id); ?>	
									<tr class="odd">
										<td>
											<?php echo $no++; ?>
										</td>
										<td>
											<a href="<?php echo base_url().'dosen/journal_detail/'.$journal->path; ?>"><?php echo $journal->journal_name; ?></a>
										</td>
										<td>
											<a href="<?php echo base_url().'dosen/subject_detail/'.$journal->subject_id;?>"><?php if($subject_detail): ?><?php echo $subject_detail->subject_name; ?><?php endif; ?></a>
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
											<a href="#" onClick="confirmation('<?php echo base_url().'dosen/journal_leave/'.$journal->journal_id;?>')">Keluar</a>
										<?php else: ?>
											<a href="#" onClick="confirmation('<?php echo base_url().'dosen/journal_join/'.$journal->journal_id;?>')">Bergabung</a>
										<?php endif; ?>										
										</td>
									</tr>	
							<?php endforeach; ?>
								</tbody>
							</table>
							<p>
								&nbsp;
							<p/>
						<?php else: ?>
							<p>
								Tidak ada jurnal yang ditemukan. <a href="javascript:history.go(-1)">Kembali</a>
							</p>
						<?php endif; ?>	
							<p>
								<a href="javascript:history.go(-1)">Kembali</a>
							<p>
						</div>
					</div>