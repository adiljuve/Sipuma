					<div class="block">
						<h5>Daftar Karya Ilmiah</h5>
						<div class="block">
						<?php if($paper_journal_member): ?>		
							<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
								<thead>
									<tr>
										<th>No.</th>
										<th>Judul</th>
										<th>Jurnal</th>
										<th>Status</th>
										<th>Tanggal Pengajuan</th>
										<th>Jumlah Revisi</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
							<?php $no = 1; ?>
							<?php foreach($paper_journal_member as $paper): ?>
							<?php $paper_published_author = $this->Sipuma_model->paper_published_author($paper->paper_id); ?>
									<tr class="odd">
										<td>
											<?php echo $no++; ?>
										</td>
										<td>
										<?php if($paper->paper_status == '2'): ?>
											<a href="<?php echo base_url(); ?>mahasiswa/paper/<?php echo $paper->paper_id; ?>"><?php echo $paper->title; ?></a>
										<?php else: ?>
											<?php echo $paper->title; ?>
										<?php endif; ?>
										</td>
										<td>
											<?php $journal_paper = $this->Sipuma_model->journal_paper($paper->paper_id); ?>
											<?php if($journal_paper): ?>
												<?php echo $journal_paper->journal_name; ?>
												<?php //$this->session->set_userdata('journal_path', $journal_paper->path); ?>
											<?php else: ?>
												-
											<?php endif; ?>
										</td>
										<td>
											<?php if(($paper->paper_status == '0')||($paper->paper_status == '3')): ?>
											<a href="<?php echo base_url().'mahasiswa/review/'.$paper->paper_id; ?>">Review</a>
											<?php elseif($paper->paper_status == '1'): ?>
											<a href="<?php echo base_url().'mahasiswa/review/'.$paper->paper_id; ?>">Ditolak</a>							
											<?php elseif($paper->paper_status == '2'): ?>
											<a href="<?php echo base_url().'mahasiswa/review/'.$paper->paper_id; ?>">Pubikasi</a>							
											<?php endif; ?>
										</td>
										<td>
											<?php echo tgl_indo($paper->date_created); ?>
										</td>
										<td>
											<?php echo $paper->revision_count; ?>
										</td>
										<td>
											<?php if($paper->paper_status == '2'): ?>
											<a href="<?php echo base_url().'mahasiswa/paper/'.$paper->paper_id; ?>">[Lihat]</a> | <a href="#" onClick="confirmation('<?php echo base_url().'mahasiswa/paper_delete/'.$journal_paper->path.'/'.$paper->paper_id;?>')">[Hapus]</a>
											<?php elseif($paper->paper_status == '1'): ?>
											<a href="<?php echo base_url().'mahasiswa/revision/'.$paper->paper_id; ?>">[Revisi]</a> | <a href="#" onClick="confirmation('<?php echo base_url().'mahasiswa/paper_delete/'.$journal_paper->path.'/'.$paper->paper_id;?>')">[Hapus]</a>
											<?php else: ?>
											<?php $check_edit = $this->Sipuma_model->paper_edit_check($paper->paper_id); ?>
											<?php if($check_edit == 0): ?>
											<a href="<?php echo base_url().'mahasiswa/paper_edit/'.$paper->paper_id; ?>">[Edit]</a> | 
											<?php endif; ?>
											<?php if($this->uri->segment(2) == 'revision_request_list'):?>
											<a href="<?php echo base_url().'mahasiswa/revision_request/'.$paper->paper_id; ?>">[Revisi]</a> |
											<?php endif; ?>
											<a href="#" onClick="confirmation('<?php echo base_url().'mahasiswa/paper_delete/'.$journal_paper->path.'/'.$paper->paper_id;?>')">[Hapus]</a>
											<?php endif; ?>
										</td>
									</tr>
							<?php endforeach; ?>
								</tbody>
							</table>
						<?php else: ?>
							<p>Tidak ada karya ilmiah</p>
						<?php endif; ?>							
							<p><a href="<?php echo base_url().'mahasiswa/paper_add';?>">[+] Tambah Karya Ilmiah</a></p>
						</div>
					</div>